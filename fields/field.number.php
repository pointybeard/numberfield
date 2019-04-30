<?php
    
    class fieldNumber extends Field
    {
        const SIMPLE = 0;
        const REGEXP = 1;
        const RANGE = 3;
        const ERROR = 4;
        
        public function __construct(&$parent)
        {
            parent::__construct($parent);
            $this->_name = 'Number';
            $this->_required = true;
            $this->set('required', 'yes');
        }

        public function isSortable()
        {
            return true;
        }
        
        public function canFilter()
        {
            return true;
        }

        public function allowDatasourceOutputGrouping()
        {
            return true;
        }
        
        public function allowDatasourceParamOutput()
        {
            return true;
        }

        public function canPrePopulate()
        {
            return true;
        }

        public function groupRecords($records)
        {
            if (!is_array($records) || empty($records)) {
                return;
            }
            
            $groups = array($this->get('element_name') => array());
            
            foreach ($records as $r) {
                $data = $r->getData($this->get('id'));
                
                $value = $data['value'];
                
                if (!isset($groups[$this->get('element_name')][$value])) {
                    $groups[$this->get('element_name')][$value] = array('attr' => array('value' => $value),
                                                                         'records' => array(), 'groups' => array());
                }
                                                                                    
                $groups[$this->get('element_name')][$value]['records'][] = $r;
            }

            return $groups;
        }

        public function displaySettingsPanel(&$wrapper, $errors=null)
        {
            parent::displaySettingsPanel($wrapper, $errors);
            $this->appendRequiredCheckbox($wrapper);
            $this->appendShowColumnCheckbox($wrapper);
        }

        public function displayPublishPanel(&$wrapper, $data=null, $flagWithError=null, $fieldnamePrefix=null, $fieldnamePostfix=null)
        {
            $value = $data['value'];
            $label = Widget::Label($this->get('label'));
            if ($this->get('required') != 'yes') {
                $label->appendChild(new XMLElement('i', 'Optional'));
            }
            $label->appendChild(Widget::Input('fields'.$fieldnamePrefix.'['.$this->get('element_name').']'.$fieldnamePostfix, (strlen($value) != 0 ? $value : null)));

            if ($flagWithError != null) {
                $wrapper->appendChild(Widget::wrapFormElementWithError($label, $flagWithError));
            } else {
                $wrapper->appendChild($label);
            }
        }

        public function displayDatasourceFilterPanel(&$wrapper, $data=null, $errors=null, $fieldnamePrefix=null, $fieldnamePostfix=null)
        {
            $wrapper->appendChild(new XMLElement('h4', $this->get('label') . ' <i>'.$this->Name().'</i>'));
            $label = Widget::Label('Value');
            $label->appendChild(Widget::Input('fields[filter]'.($fieldnamePrefix ? '['.$fieldnamePrefix.']' : '').'['.$this->get('id').']'.($fieldnamePostfix ? '['.$fieldnamePostfix.']' : ''), ($data ? General::sanitize($data) : null)));
            $wrapper->appendChild($label);
            
            $wrapper->appendChild(new XMLElement('p', 'To filter by ranges, add <code>mysql:</code> to the beginning of the filter input. Use <code>value</code> for field name. E.G. <code>mysql: value &gt;= 1.01 AND value &lt;= {$price}</code>', array('class' => 'help')));
        }
        
        public function checkPostFieldData($data, &$message, $entry_id=null)
        {
            $message = null;
            
            if ($this->get('required') == 'yes' && strlen($data) == 0) {
                $message = 'This is a required field.';
                return self::__MISSING_FIELDS__;
            }
            
            if (strlen($data) > 0 && !is_numeric($data)) {
                $message = 'Must be a number.';
                return self::__INVALID_FIELDS__;
            }
                        
            return self::__OK__;
        }
        
        public function createTable()
        {
            return $this->Database->query(
                "CREATE TABLE IF NOT EXISTS `tbl_entries_data_" . $this->get('id') . "` (
				  `id` int(11) unsigned NOT NULL auto_increment,
				  `entry_id` int(11) unsigned NOT NULL,
				  `value` double default NULL,
				  PRIMARY KEY  (`id`),
				  KEY `entry_id` (`entry_id`),
				  KEY `value` (`value`)
				) TYPE=MyISAM;"
            
            );
        }

        public function buildDSRetrivalSQL($data, &$joins, &$where, $andOperation=false)
        {
            
            ## Check its not a regexp
            if (preg_match('/^mysql:/i', $data[0])) {
                $field_id = $this->get('id');
                
                $expression = str_replace(array('mysql:', 'value'), array('', " `t$field_id`.`value` " ), $data[0]);
                
                $joins .= " LEFT JOIN `tbl_entries_data_$field_id` AS `t$field_id` ON (`e`.`id` = `t$field_id`.entry_id) ";
                $where .= " AND $expression ";
            } else {
                parent::buildDSRetrivalSQL($data, $joins, $where, $andOperation);
            }
            
            return true;
        }
    }
