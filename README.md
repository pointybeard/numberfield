# Number Field

- Version: 1.5.1
- Author: Symphony Team (team@symphony-cms.com)
- Release Date: 12th May 2012
- Requirements: Symphony 2.1

## Overview

Input field that provides built-in number validation and numeric sorting.

## Installation

1. Upload the 'numberfield' folder in this archive to your Symphony 'extensions' folder.
2. Enable it by selecting the "Field: Number", choose Enable from the with-selected menu, then click Apply.
3. You can now add the "Number" field to your sections.

## Datasource Filtering

The number field provides two additional datasource filtering methods:

### Range filtering

You can easily filter by a numeric range on the number field on your datasource. Simply enter something like this:

	10 to 20

This will return all entries that have a field value between 10 and 20. Spaces are optional. 

Just like any other datasource filter, you can make these values dynamic: 

	{$url-lower-limit} to {$url-upper-limit}

This would let you pass through the upper and lower limit as url parameters. E.g. `/products/?lower-limit-10&upper-limit=20`

### Less than or greater than

You can also use standard greater than or less than symbols in the filter value. E.g.

	> 20

This will return all entries that have a value greater than 20.