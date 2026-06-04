=== ACF Extended Repeater ===

Contributors: Jitender Kumar
Tags: acf, repeater, advanced custom fields, custom fields, acf free
Requires at least: 6.0
Tested up to: 6.8
Requires PHP: 7.4
Stable tag: 1.0.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Adds a lightweight Repeater Field to Advanced Custom Fields Free.

== Description ==

ACF Extended Repeater brings repeater functionality to Advanced Custom Fields Free.

Create repeatable groups of fields without requiring ACF Pro.

Features:

* Repeater field for ACF Free
* Unlimited rows
* Minimum and maximum row limits
* Drag and drop row sorting
* Row collapse and expand
* Multiple repeater fields per page
* Import and export support
* Developer-friendly API
* Lightweight and fast

Supported Sub Fields:

* Text
* Textarea
* Number
* Select
* Checkbox
* Radio
* True / False
* Image
* File
* Date Picker
* Date Time Picker
* WYSIWYG

== Usage ==

Create an "Extended Repeater" field inside an ACF field group.

Retrieve values using:

<?php

$rows = get_field( 'your_field_key' );

if ( $rows ) {

	foreach ( $rows as $row ) {

		echo aer_get_sub_field(
			$row,
			'subfield_key'
		);
	}
}

?>

== Helper Function ==

The plugin includes a helper function:

<?php

aer_get_sub_field(
	$row,
	$field_name
);

?>

Example:

<?php

$rows = get_field( 'post_layout' );

foreach ( $rows as $row ) {

	echo aer_get_sub_field(
		$row,
		'heading'
	);
}

?>

Select and Radio fields return:

<?php

array(
	'value' => 'option_1',
	'label' => 'Option 1',
);

?>

Checkbox fields return:

<?php

array(
	'option_1' => 'Option 1',
	'option_2' => 'Option 2',
);

?>

== Installation ==

1. Install and activate Advanced Custom Fields.
2. Upload and activate ACF Extended Repeater.
3. Create or edit a field group.
4. Add the Extended Repeater field.
5. Configure sub fields.
6. Save the field group.

== Frequently Asked Questions ==

= Does this require ACF Pro? =

No. It works with Advanced Custom Fields Free.

= Does import and export work? =

Yes. Field groups can be exported and imported normally.

= Can I use get_field()? =

Yes. The field integrates with ACF's get_field() function.

= Can I reorder rows? =

Yes. Rows can be reordered using drag and drop.

== Screenshots ==

1. Extended Repeater field settings
2. Sub field builder
3. Repeater rows in the editor
4. Drag and drop row sorting

== Changelog ==

= 1.0.0 =

* Initial release.
* Repeater field for ACF Free.
* Drag and drop sorting.
* Row collapse and expand.
* Min and max row validation.
* Import and export support.
* WYSIWYG support.
* Date Picker support.
* Date Time Picker support.
* Helper functions.

== Upgrade Notice ==

= 1.0.0 =

Initial release.
