# ACF Extended Repeater

A lightweight repeater field extension for Advanced Custom Fields (ACF) Free.

## Features

- Repeater field for ACF Free
- Drag and drop sorting
- Row collapse / expand
- Min and Max row limits
- Import / Export support
- WYSIWYG support
- Date Picker support
- Date Time Picker support

## Requirements

- WordPress 6.0+
- PHP 7.4+
- Advanced Custom Fields Free

## Installation

1. Install Advanced Custom Fields.
2. Install and activate ACF Extended Repeater.
3. Create an Extended Repeater field inside a field group.

## Usage

```php
$rows = get_field( 'your_feild_key' );

if ( $rows ) {

	foreach ( $rows as $row ) {

		echo aer_get_sub_field(
			$row,
			'subfield_key'
		);
	}
}
```

## License

GPL-2.0-or-later
