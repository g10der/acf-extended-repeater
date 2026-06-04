<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class AER_Repeater_Field extends acf_field {

	/**
	 * Field constructor.
	 *
	 * @return void
	 */
	public function initialize() {

		$this->name     = 'aer_repeater';
		$this->label    = __( 'Extended Repeater', 'acf-extended-repeater' );
		$this->category = 'layout';

		$this->defaults = array(
			'min' => 0,
			'max' => 0,
		);
	}

/**
 * Render field.
 *
 * @param array $field Field data.
 *
 * @return void
 */
public function render_field( $field ) {

	/*
	|--------------------------------------------------------------------------
	| Dynamic Sub Fields
	|--------------------------------------------------------------------------
	*/

	$sub_fields = ! empty( $field['sub_fields'] )
		? $field['sub_fields']
		: array();

		/*
 * No sub fields = no rows.
 */
if ( empty( $sub_fields ) ) {

	$field['value'] = array();
}


// echo '<pre>';
// print_r( $sub_fields );
// echo '</pre>';
	/*
	|--------------------------------------------------------------------------
	| Field Value
	|--------------------------------------------------------------------------
	*/

	$value = ! empty( $field['value'] )
		? $field['value']
		: array();

	?>

	<div class="aer-repeater-wrapper">

		<div class="aer-repeater-rows">

			<?php if ( ! empty( $value ) ) : ?>

				<?php foreach ( $value as $row_index => $row ) : ?>

					<div class="aer-repeater-row">

						<div class="aer-repeater-handle">

	 <div class="aer-row-left">
        <span class="aer-row-toggle">▼</span>
        <span class="aer-row-number"><?php esc_html_e(
		'Row #1',
		'acf-extended-repeater'
	); ?></span>
    </div>
<button
							type="button"
							class="button button-link-delete aer-remove-row"
						>
						<?php esc_html_e(
	'Remove',
	'acf-extended-repeater'
); ?>
						</button>
</div>

						<div class="aer-repeater-fields">

							<?php foreach ( $sub_fields as $sub_field ) : ?>

								<?php

								/*
								 * Skip invalid fields.
								 */
								if (
									empty( $sub_field['type'] ) ||
									empty( $sub_field['name'] )
								) {
									continue;
								}

								/*
								 * Prepare field.
								 */
								$acf_sub_field = $sub_field;

					


/*
|--------------------------------------------------------------------------
| Convert Choices
|--------------------------------------------------------------------------
*/

if (
	in_array(
		$acf_sub_field['type'],
		array(
			'select',
			'checkbox',
			'radio',
		),
		true
	)
) {

	$acf_sub_field['choices'] =
		$this->parse_choices(
			$acf_sub_field['choices']
		);
}


								/*
								 * Load saved value.
								 */
								$acf_sub_field['value'] =
									$row[ $sub_field['key'] ] ?? '';

								/*
								 * Prefix for ACF saving.
								 */
								$acf_sub_field['prefix'] =
									$field['name'] .
									'[' . $row_index . ']';

								/*
								 * Image field settings.
								 */
								if (
									$acf_sub_field['type'] === 'image'
								) {

									$acf_sub_field['return_format'] = 'array';

									$acf_sub_field['preview_size'] = 'thumbnail';

									$acf_sub_field['library'] = 'all';
								}

								/*
|--------------------------------------------------------------------------
| Date Picker Settings
|--------------------------------------------------------------------------
*/

if (
	$acf_sub_field['type'] === 'date_picker'
) {

	$acf_sub_field['display_format'] = 'd/m/Y';

	$acf_sub_field['return_format'] = 'Y-m-d';

	$acf_sub_field['first_day'] = 1;
}

/*
|--------------------------------------------------------------------------
| Date Time Picker Settings
|--------------------------------------------------------------------------
*/

if (
	$acf_sub_field['type'] === 'date_time_picker'
) {

	$acf_sub_field['display_format'] =
		'd/m/Y g:i a';

	$acf_sub_field['return_format'] =
		'Y-m-d H:i:s';

	$acf_sub_field['first_day'] = 1;
}

/*
|--------------------------------------------------------------------------
| WYSIWYG Settings
|--------------------------------------------------------------------------
*/

if (
	$acf_sub_field['type'] === 'wysiwyg'
) {

	$acf_sub_field['tabs'] =
		'all';

	$acf_sub_field['toolbar'] =
		'full';

	$acf_sub_field['media_upload'] =
		1;

	$acf_sub_field['delay'] =
		0;
}


								/*
								 * Render field.
								 */
								acf_render_field_wrap(
									$acf_sub_field
								);

								?>

							<?php endforeach; ?>

						</div>

						

					</div>

				<?php endforeach; ?>

			<?php endif; ?>

		</div>

		<!-- Hidden Template Row -->
		<div
			class="aer-repeater-template"
			style="display:none;"
		>

			<div class="aer-repeater-row">

				<div class="aer-repeater-handle">

	 <div class="aer-row-left">
        <span class="aer-row-toggle">▼</span>
        <span class="aer-row-number"><?php esc_html_e(
		'Row #1',
		'acf-extended-repeater'
	); ?></span>
    </div>
	<button
					type="button"
					class="button button-link-delete aer-remove-row"
				>
				<?php esc_html_e(
	'Remove',
	'acf-extended-repeater'
); ?>
				</button>

</div>

				<div class="aer-repeater-fields">

					<?php foreach ( $sub_fields as $sub_field ) : ?>

						<?php

						/*
						 * Skip invalid fields.
						 */
						if (
							empty( $sub_field['type'] ) ||
							empty( $sub_field['name'] )
						) {
							continue;
						}

						$template_field = $sub_field;

/*
|--------------------------------------------------------------------------
| Convert Choices
|--------------------------------------------------------------------------
*/

if (
	in_array(
		$template_field['type'],
		array(
			'select',
			'checkbox',
			'radio',
		),
		true
	)
) {

	$template_field['choices'] =
		$this->parse_choices(
			$template_field['choices']
		);
}

						/*
						 * Empty value.
						 */
						$template_field['value'] = '';

						/*
						 * Template placeholder index.
						 */
						$template_field['prefix'] =
							$field['name'] .
							'[__index__]';

						/*
						 * Image field settings.
						 */
						if (
							$template_field['type'] === 'image'
						) {

							$template_field['return_format'] = 'array';

							$template_field['preview_size'] = 'thumbnail';

							$template_field['library'] = 'all';
						}


									/*
|--------------------------------------------------------------------------
| Date Picker Settings
|--------------------------------------------------------------------------
*/

if (
	$template_field['type'] === 'date_picker'
) {

	$template_field['display_format'] = 'd/m/Y';

	$template_field['return_format'] = 'Y-m-d';

	$template_field['first_day'] = 1;
}

/*
|--------------------------------------------------------------------------
| Date Time Picker Settings
|--------------------------------------------------------------------------
*/

if (
	$template_field['type'] === 'date_time_picker'
) {

	$template_field['display_format'] =
		'd/m/Y g:i a';

	$template_field['return_format'] =
		'Y-m-d H:i:s';

	$template_field['first_day'] = 1;
}

/*
|--------------------------------------------------------------------------
| Template WYSIWYG
|--------------------------------------------------------------------------
*/

if (
	$template_field['type'] === 'wysiwyg'
) {
$template_field['tabs'] = 'all';
	$template_field['toolbar'] = 'full';

	$template_field['media_upload'] = 1;

	$template_field['delay'] = 1;
}



						/*
						 * Render field.
						 */
						acf_render_field_wrap(
							$template_field
						);

						?>

					<?php endforeach; ?>

				</div>

				

			</div>

		</div>

		<button
			type="button"
			class="button button-primary aer-add-row"
		>
			<?php esc_html_e(
	'Add Row',
	'acf-extended-repeater'
); ?>
		</button>

	</div>

	<?php
}


/**
 * Render field settings.
 *
 * @param array $field Field settings.
 *
 * @return void
 */
public function render_field_settings( $field ) {

$admin_sub_fields = ! empty(
	$field['sub_fields']
)
	? $field['sub_fields']
	: array();

foreach ( $admin_sub_fields as &$sub_field ) {

	if (
		isset( $sub_field['choices'] ) &&
		is_array( $sub_field['choices'] )
	) {

		$sub_field['choices'] =
			$this->choices_to_textarea(
				$sub_field['choices']
			);
	}
}

unset( $sub_field );

$field['sub_fields_json'] = wp_json_encode(
	$admin_sub_fields
);
	/*
	|--------------------------------------------------------------------------
	| Minimum Rows
	|--------------------------------------------------------------------------
	*/

	acf_render_field_setting(

		$field,

		array(
			'label'        => __( 'Minimum Rows', 'acf-extended-repeater' ),
			'instructions' => __( 'Minimum number of rows required.', 'acf-extended-repeater' ),
			'type'         => 'number',
			'name'         => 'min',
			'min'          => 0,
		)
	);

	/*
	|--------------------------------------------------------------------------
	| Maximum Rows
	|--------------------------------------------------------------------------
	*/

	acf_render_field_setting(

		$field,

		array(
			'label'        => __( 'Maximum Rows', 'acf-extended-repeater' ),
			'instructions' => __( 'Maximum number of rows allowed.', 'acf-extended-repeater' ),
			'type'         => 'number',
			'name'         => 'max',
			'min'          => 0,
		)
	);


/*
|--------------------------------------------------------------------------
| Sub Fields JSON
|--------------------------------------------------------------------------
*/


acf_render_field_setting(

	$field,

	array(
		'label' => __(
	'Sub Fields JSON',
	'acf-extended-repeater'
),
		'name'  => 'sub_fields_json',
		'type'  => 'text',

		'wrapper' => array(
			'class' => 'aer-hidden-setting',
		),
	)
);


?>




<div class="aer-subfields-builder">

	<div class="aer-subfields-list"></div>

	<button
		type="button"
		class="button button-primary aer-add-subfield"
	>
		<?php esc_html_e(
	'Add Sub Field',
	'acf-extended-repeater'
); ?>
	</button>

</div>

<?php
}

/**
 * Update field.
 *
 * @param array $field Field settings.
 *
 * @return array
 */
public function update_field( $field ) {

	$sub_fields = array();

	if ( ! empty( $field['sub_fields_json'] ) ) {

		$decoded = json_decode(
			$field['sub_fields_json'],
			true
		);

		if ( is_array( $decoded ) ) {
			$sub_fields = $decoded;
		}
	}

	$clean_sub_fields = array();

	foreach ( $sub_fields as $sub_field ) {

		if ( empty( $sub_field['label'] ) ) {
			continue;
		}

		/*
		|--------------------------------------------------------------------------
		| Choices
		|--------------------------------------------------------------------------
		|
		| Support both:
		|
		| String:
		| select1 : Select 1
		| select2 : Select 2
		|
		| Array:
		| array(
		|     'select1' => 'Select 1',
		| )
		|
		*/

		$choices = array();

		if ( ! empty( $sub_field['choices'] ) ) {

			if ( is_array( $sub_field['choices'] ) ) {

				$choices = $sub_field['choices'];

			} else {

				$choices = $this->choices_to_array(
					sanitize_textarea_field(
						$sub_field['choices']
					)
				);
			}
		}

		$clean_sub_fields[] = array(

			'key' => ! empty( $sub_field['key'] )
				? $sub_field['key']
				: 'field_aer_' . uniqid(),

			'label' => sanitize_text_field(
				$sub_field['label']
			),

			'name' => sanitize_title(
				$sub_field['name']
			),

			'type' => sanitize_text_field(
				$sub_field['type']
			),

			'choices' => $choices,
		);
	}

	$field['sub_fields'] = $clean_sub_fields;

	/*
	|--------------------------------------------------------------------------
		| Import / Export Backup
	|--------------------------------------------------------------------------
	*/

	$field['sub_fields_json'] = wp_json_encode(
		$clean_sub_fields
	);

	return $field;
}

/**
 * Update value.
 *
 * @param mixed $value Field value.
 * @param int   $post_id Post ID.
 * @param array $field Field settings.
 *
 * @return array
 */
public function update_value( $value, $post_id, $field ) {

	if ( empty( $value ) || ! is_array( $value ) ) {

		return array();
	}

	$clean_rows = array();

	foreach ( $value as $row_key => $row ) {
 /*
     * Never save template row.
     */
    if ( '__index__' === (string) $row_key ) {
        continue;
    }
		/*
		 * Skip invalid rows.
		 */
		if ( ! is_array( $row ) ) {
			continue;
		}

		/*
		 * Detect non-empty row.
		 */
		$has_value = false;

		foreach ( $row as $field_value ) {

			if (
				is_string( $field_value ) &&
				trim( $field_value ) !== ''
			) {

				$has_value = true;
				break;
			}

			if (
				is_array( $field_value ) &&
				! empty( $field_value )
			) {

				$has_value = true;
				break;
			}
		}

		/*
		 * Preserve ORIGINAL unique key.
		 */
		if ( $has_value ) {

			$clean_rows[ $row_key ] = $row;
		}
	}

	return $clean_rows;
}

/**
 * Validate value.
 *
 * @param bool|string $valid Validation state.
 * @param mixed       $value Field value.
 * @param array       $field Field settings.
 * @param string      $input Input name.
 *
 * @return bool|string
 */
public function validate_value( $valid, $value, $field, $input ) {

	/*
	|--------------------------------------------------------------------------
	| Existing validation failed
	|--------------------------------------------------------------------------
	*/

	if ( $valid !== true ) {
		return $valid;
	}

	/*
	|--------------------------------------------------------------------------
	| Ensure array
	|--------------------------------------------------------------------------
	*/

	if ( empty( $value ) || ! is_array( $value ) ) {

		$value = array();
	}

	/*
	|--------------------------------------------------------------------------
	| Remove empty rows
	|--------------------------------------------------------------------------
	*/

	$rows = array();

	foreach ( $value as $row ) {

		if ( ! is_array( $row ) ) {
			continue;
		}

		$has_value = false;

		foreach ( $row as $field_value ) {

			if (
				is_string( $field_value ) &&
				trim( $field_value ) !== ''
			) {

				$has_value = true;
				break;
			}

			if (
				is_array( $field_value ) &&
				! empty( $field_value )
			) {

				$has_value = true;
				break;
			}
		}

		if ( $has_value ) {

			$rows[] = $row;
		}
	}

	$row_count = count( $rows );

	/*
	|--------------------------------------------------------------------------
	| Minimum rows
	|--------------------------------------------------------------------------
	*/

	if (
		! empty( $field['min'] ) &&
		$row_count < (int) $field['min']
	) {

		return sprintf(
			__( 'Minimum %d rows required.', 'acf-extended-repeater' ),
			$field['min']
		);
	}

	/*
	|--------------------------------------------------------------------------
	| Maximum rows
	|--------------------------------------------------------------------------
	*/

	if (
		! empty( $field['max'] ) &&
		$row_count > (int) $field['max']
	) {

		return sprintf(
			__( 'Maximum %d rows allowed.', 'acf-extended-repeater' ),
			$field['max']
		);
	}

	return true;
}

	/**
	 * Load value.
	 *
	 * @param mixed $value Field value.
	 * @param int   $post_id Post ID.
	 * @param array $field Field settings.
	 *
	 * @return mixed
	 */
	public function load_value( $value, $post_id, $field ) {

		return $value;
	}

	/**
 * Format value.
 *
 * Used by get_field().
 * Does NOT affect admin editing.
 *
 * @param mixed $value Field value.
 * @param int   $post_id Post ID.
 * @param array $field Field settings.
 *
 * @return mixed
 */
public function format_value( $value, $post_id, $field ) {

	if (
		empty( $value ) ||
		! is_array( $value ) ||
		empty( $field['sub_fields'] )
	) {

		return $value;
	}

	$formatted_rows = array();

	foreach ( $value as $row ) {

		if ( ! is_array( $row ) ) {
			continue;
		}

		$new_row = array();

	foreach ( $field['sub_fields'] as $sub_field ) {

	$key   = $sub_field['key'];
	$name  = $sub_field['name'];
	$type  = $sub_field['type'];

	$value = $row[ $key ] ?? '';

	/*
	|--------------------------------------------------------------------------
	| Select / Radio
	|--------------------------------------------------------------------------
	*/

	if (
		in_array(
			$type,
			array(
				'select',
				'radio',
			),
			true
		)
	) {

		$choices = $this->parse_choices(
			$sub_field['choices']
		);

		$new_row[ $name ] = array(
			'value' => $value,
			'label' => $choices[ $value ] ?? $value,
		);

		continue;
	}

	/*
	|--------------------------------------------------------------------------
	| Checkbox
	|--------------------------------------------------------------------------
	*/

	if (
		'checkbox' === $type
	) {

		$choices = $this->parse_choices(
			$sub_field['choices']
		);

		$formatted = array();

		if ( is_array( $value ) ) {

			foreach ( $value as $choice ) {

				$formatted[ $choice ] =
					$choices[ $choice ]
					?? $choice;
			}
		}

		$new_row[ $name ] = $formatted;

		continue;
	}

	$new_row[ $name ] = $value;
}

		$formatted_rows[] = $new_row;
	}

	return $formatted_rows;
}


/**
 * Parse choices.
 *
 * @param string $choices Choices string.
 *
 * @return array
 */
private function parse_choices( $choices ) {

	if ( is_array( $choices ) ) {
		return $choices;
	}

	$parsed = array();

	$lines = preg_split(
		'/\r\n|\r|\n/',
		(string) $choices
	);

	foreach ( $lines as $line ) {

		$line = trim( $line );

		if ( empty( $line ) ) {
			continue;
		}

		$parts = explode(
			':',
			$line,
			2
		);

		if ( 2 === count( $parts ) ) {

			$parsed[
				trim( $parts[0] )
			] = trim(
				$parts[1]
			);

		} else {

			$parsed[ $line ] = $line;
		}
	}

	return $parsed;
}


/**
 * Load field settings.
 *
 * Rebuild choice field line breaks after ACF import.
 *
 * @param array $field Field settings.
 *
 * @return array
 */
public function load_field( $field ) {

	/*
	|--------------------------------------------------------------------------
	| Restore imported fields
	|--------------------------------------------------------------------------
	*/

	if (
		empty( $field['sub_fields'] ) &&
		! empty( $field['sub_fields_json'] )
	) {

		$decoded = json_decode(
			$field['sub_fields_json'],
			true
		);

		if ( is_array( $decoded ) ) {

			$field['sub_fields'] = $decoded;
		}
	}

	if ( empty( $field['sub_fields'] ) ) {
		return $field;
	}

	/*
	|--------------------------------------------------------------------------
	| Migrate old installs
	|--------------------------------------------------------------------------
	*/

	foreach ( $field['sub_fields'] as &$sub_field ) {

		if (
			isset( $sub_field['choices'] ) &&
			is_string( $sub_field['choices'] ) &&
			in_array(
				$sub_field['type'],
				array(
					'select',
					'checkbox',
					'radio',
				),
				true
			)
		) {

			$sub_field['choices'] =
				$this->choices_to_array(
					$sub_field['choices']
				);
		}
	}

	unset( $sub_field );

	/*
	|--------------------------------------------------------------------------
	| Admin JSON
	|--------------------------------------------------------------------------
	*/

	$field['sub_fields_json'] = wp_json_encode(
		$field['sub_fields']
	);

	return $field;
}

/**
 * Convert textarea choices to array.
 *
 * @param string $choices Choices textarea.
 *
 * @return array
 */
private function choices_to_array( $choices ) {

	$parsed = array();

	$lines = preg_split(
		'/\r\n|\r|\n/',
		(string) $choices
	);

	foreach ( $lines as $line ) {

		$line = trim( $line );

		if ( empty( $line ) ) {
			continue;
		}

		$parts = explode(
			':',
			$line,
			2
		);

		if ( 2 === count( $parts ) ) {

			$parsed[
				trim( $parts[0] )
			] = trim(
				$parts[1]
			);

		} else {

			$parsed[ $line ] = $line;
		}
	}

	return $parsed;
}

/**
 * Convert choices array to textarea format.
 *
 * @param array $choices Choices array.
 *
 * @return string
 */
private function choices_to_textarea( $choices ) {

	if ( empty( $choices ) || ! is_array( $choices ) ) {
		return '';
	}

	$lines = array();

	foreach ( $choices as $value => $label ) {

		$lines[] =
			$value .
			' : ' .
			$label;
	}

	return implode(
		"\n",
		$lines
	);
}


}

