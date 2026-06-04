<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class AER_Plugin {

	/**
	 * Plugin instance.
	 *
	 * @var AER_Plugin|null
	 */
	private static $instance = null;

	/**
	 * Get plugin instance.
	 *
	 * @return AER_Plugin
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

		require_once AER_PATH . 'includes/fields/class-repeater-field.php';
		require_once AER_PATH . 'includes/helpers/functions.php';
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
		array( $this, 'update_aer_field' )
	);
	}

	/**
	 * Register custom field.
	 *
	 * @return void
	 */
	public function register_field() {

		new AER_Repeater_Field();
	}

	/**
	 * Enqueue admin assets.
	 *
	 * @return void
	 */
	public function enqueue_assets() {

		wp_enqueue_style(
			'aer-admin',
			AER_URL . 'assets/css/admin.css',
			array(),
			AER_VERSION
		);

		wp_enqueue_script(
			'aer-admin',
			AER_URL . 'assets/js/admin.js',
			array( 'jquery', 'jquery-ui-sortable' ),
			AER_VERSION,
			true
		);

		wp_localize_script(
	'aer-admin',
	'aerRepeater',
	array(

		'addRow' => __( 'Add Row', 'acf-extended-repeater' ),
'remove' => __( 'Remove', 'acf-extended-repeater' ),
'newField' => __( 'New Field', 'acf-extended-repeater' ),
'row' => __( 'Row', 'acf-extended-repeater' ),
'label' => __( 'Label', 'acf-extended-repeater' ),
'name' => __( 'Name', 'acf-extended-repeater' ),
'type' => __( 'Type', 'acf-extended-repeater' ),
'text' => __( 'Text', 'acf-extended-repeater' ),
'textarea' => __( 'Textarea', 'acf-extended-repeater' ),
'number' => __( 'Number', 'acf-extended-repeater' ),
'select' => __( 'Select', 'acf-extended-repeater' ),
'checkbox' => __( 'Checkbox', 'acf-extended-repeater' ),
'radio' => __( 'Radio', 'acf-extended-repeater' ),
'trueFalse' => __( 'True / False', 'acf-extended-repeater' ),
'image' => __( 'Image', 'acf-extended-repeater' ),
'file' => __( 'File', 'acf-extended-repeater' ),
'datePicker' => __( 'Date Picker', 'acf-extended-repeater' ),
'dateTimePicker' => __( 'Date Time Picker', 'acf-extended-repeater' ),
'wysiwyg' => __( 'WYSIWYG', 'acf-extended-repeater' ),
'choicesPlaceholder' => __(
	'One choice per line',
	'acf-extended-repeater'
),

	)
);
	}

	/**
 * Update AER field before save.
 *
 * @param array $field Field data.
 *
 * @return array
 */
public function update_aer_field( $field ) {

	if (
		isset( $field['type'] ) &&
		'aer_repeater' === $field['type']
	) {

		$field['sub_fields_json'] = wp_json_encode(
			$field['sub_fields'] ?? array()
		);
	}

	return $field;
}
}