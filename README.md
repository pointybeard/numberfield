# Number Field

- Version: 1.5
- Author: Symphony Team (team@symphony-cms.com)
- Release Date: 8th May 2012
- Requirements: Symphony 2.3

## Overview

Input field that provides built-in number validation and numeric sorting.

## Installation

1. Upload the 'numberfield' folder in this archive to your Symphony 'extensions' folder.
2. Enable it by selecting the "Field: Number", choose Enable from the with-selected menu, then click Apply.
3. You can now add the "Number" field to your sections.

## Changelog

- **1.5** Updates for Symphony 2.3.
- **1.4.1** Slight cleanup for Symphony 2.2
- **1.4** In the publish area, will no longer get errors when leaving a non-required number field empty.
- **1.3** Filtering supports ranges via the use of MySQL expressions. To filter by ranges, add `mysql:` to the beginning of the filter input. Use `value` for field name. E.G. `mysql: value >= 1.01 AND value <= {$price}`
