<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class G10DER_Plugin {

	/**
	 * Plugin instance.
	 *
	 * @var G10DER_Plugin|null
	 */
	private static $instance = null;

	/**
	 * Get plugin instance.
	 *
	 * @return G10DER_Plugin
	 */
	public static function instance() {

		if ( null === self::$instance ) {

			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Constructor.
	 *
	 * @return void
	 */
	private function __construct() {

		$this->includes();

		$this->hooks();
	}

	/**
	 * Load required files.
	 *
	 * @return void
	 */
	private function includes() {

require_once G10DER_PATH . 'includes/fields/class-repeater-field.php';
require_once G10DER_PATH . 'includes/helpers/functions.php';
	}

	/**
	 * Register hooks.
	 *
	 * @return void
	 */
	private function hooks() {

		add_action(
			'acf/include_field_types',
			array( $this, 'register_field' )
		);

		add_action(
			'admin_enqueue_scripts',
			array( $this, 'enqueue_assets' )
		);

	add_filter(
    'acf/update_field',
    array( $this, 'update_g10der_field' )
);
	}

	/**
	 * Register custom field.
	 *
	 * @return void
	 */
	public function register_field() {

		new G10DER_Repeater_Field();
	}

	/**
	 * Enqueue admin assets.
	 *
	 * @return void
	 */
	public function enqueue_assets() {

	wp_enqueue_style(
    'g10der-admin',
    G10DER_URL . 'assets/css/admin.css',
    array(),
    G10DER_VERSION
);

		wp_enqueue_script(
    'g10der-admin',
    G10DER_URL . 'assets/js/admin.js',
    array( 'jquery', 'jquery-ui-sortable' ),
    G10DER_VERSION,
    true
);

	wp_localize_script(
    'g10der-admin',
    'g10derRepeater',
	array(

		'addRow' => __( 'Add Row', 'g10der-repeater-fields-for-advanced-custom-fields' ),
'remove' => __( 'Remove', 'g10der-repeater-fields-for-advanced-custom-fields' ),
'newField' => __( 'New Field', 'g10der-repeater-fields-for-advanced-custom-fields' ),
'row' => __( 'Row', 'g10der-repeater-fields-for-advanced-custom-fields' ),
'label' => __( 'Label', 'g10der-repeater-fields-for-advanced-custom-fields' ),
'name' => __( 'Name', 'g10der-repeater-fields-for-advanced-custom-fields' ),
'type' => __( 'Type', 'g10der-repeater-fields-for-advanced-custom-fields' ),
'text' => __( 'Text', 'g10der-repeater-fields-for-advanced-custom-fields' ),
'textarea' => __( 'Textarea', 'g10der-repeater-fields-for-advanced-custom-fields' ),
'number' => __( 'Number', 'g10der-repeater-fields-for-advanced-custom-fields' ),
'select' => __( 'Select', 'g10der-repeater-fields-for-advanced-custom-fields' ),
'checkbox' => __( 'Checkbox', 'g10der-repeater-fields-for-advanced-custom-fields' ),
'radio' => __( 'Radio', 'g10der-repeater-fields-for-advanced-custom-fields' ),
'trueFalse' => __( 'True / False', 'g10der-repeater-fields-for-advanced-custom-fields' ),
'image' => __( 'Image', 'g10der-repeater-fields-for-advanced-custom-fields' ),
'file' => __( 'File', 'g10der-repeater-fields-for-advanced-custom-fields' ),
'datePicker' => __( 'Date Picker', 'g10der-repeater-fields-for-advanced-custom-fields' ),
'dateTimePicker' => __( 'Date Time Picker', 'g10der-repeater-fields-for-advanced-custom-fields' ),
'wysiwyg' => __( 'WYSIWYG', 'g10der-repeater-fields-for-advanced-custom-fields' ),
'choicesPlaceholder' => __(
	'One choice per line',
	'g10der-repeater-fields-for-advanced-custom-fields'
),

	)
);
	}

	/**
 * Update g10der field before save.
 *
 * @param array $field Field data.
 *
 * @return array
 */
public function update_g10der_field( $field ) {

	if (
		isset( $field['type'] ) &&
		'g10der_repeater' === $field['type']
	) {

		$field['sub_fields_json'] = wp_json_encode(
			$field['sub_fields'] ?? array()
		);
	}

	return $field;
}
}