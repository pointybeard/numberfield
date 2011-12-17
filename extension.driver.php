<?php

	Class extension_numberfield extends Extension {

		public function about() {
			return array(
				'name' => 'Field: Number',
				'version' => '1.5',
				'release-date' => '2011-12-17',
				'author' => array(
				 	'name' => 'Symphony Team',
					'website' => 'http://www.symphony-cms.com',
					'email' => 'team@symphony-cms.com'
				)
			);
		}

		public function uninstall() {
			Symphony::Database()->query("DROP TABLE `tbl_fields_number`");
		}

		public function install() {
			return Symphony::Database()->query("
				CREATE TABLE `tbl_fields_number` (
				`id` int(11) unsigned NOT NULL auto_increment,
				`field_id` int(11) unsigned NOT NULL,
				PRIMARY KEY  (`id`),
				UNIQUE KEY `field_id` (`field_id`)
				)  ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci
			");
		}

	}
