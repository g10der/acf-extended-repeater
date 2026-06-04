<?php
/**
 * Get repeater sub field value.
 *
 * @param array  $row Row data.
 * @param string $name Sub field name.
 * @param mixed  $default Default value.
 *
 * @return mixed
 */
function aer_get_sub_field(
	$row,
	$name,
	$default = ''
) {

	if ( ! is_array( $row ) ) {
		return $default;
	}

	return $row[ $name ] ?? $default;
}