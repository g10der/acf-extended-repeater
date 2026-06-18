<?php
/**
 * Plugin Name: G10DER Repeater Fields for Advanced Custom Fields
 * Plugin URI: https://github.com/g10der/acf-extended-repeater
 * Description: Adds a lightweight repeater field to Advanced Custom Fields Free.
 * Version: 1.0.0
 * Requires at least: 6.0
 * Requires PHP: 7.4
 * Author: Jitender kumar
 * Author URI: https://profiles.wordpress.org/devg10der/
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: g10der-repeater-fields-for-advanced-custom-fields
 * Domain Path: /languages
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Plugin Constants
 */
define( 'G10DER_VERSION', '1.0.0' );
define( 'G10DER_PATH', plugin_dir_path( __FILE__ ) );
define( 'G10DER_URL', plugin_dir_url( __FILE__ ) );


/**
 * Activation Check
 *
 * @return void
 */
function g10der_activate_plugin() {

	if (
		! class_exists( 'ACF' ) &&
		! function_exists( 'acf_register_field_type' )
	) {

		deactivate_plugins(
			plugin_basename( __FILE__ )
		);

		wp_die(

			esc_html__(
				'ACF Extended Repeater requires Advanced Custom Fields to be installed and activated.',
				'g10der-repeater-fields-for-advanced-custom-fields'
			),

			esc_html__(
				'Plugin Dependency Check',
				'g10der-repeater-fields-for-advanced-custom-fields'
			),

			array(
				'back_link' => true,
			)

		);
	}
}

register_activation_hook(
	__FILE__,
	'g10der_activate_plugin'
);


/**
 * Initialize Plugin
 */
add_action(
	'plugins_loaded',
	'g10der_init_plugin'
);

/**
 * Plugin Init
 *
 * @return void
 */
function g10der_init_plugin() {

	// Check if ACF exists.
	if (
	! class_exists( 'ACF' ) &&
	! function_exists( 'acf_register_field_type' )
) {

		add_action(
	'admin_notices',
	'g10der_acf_missing_notice'
);

add_action(
	'admin_init',
	'g10der_deactivate_plugin'
);
		return;
	}

	// Load plugin core.
	require_once G10DER_PATH . 'includes/class-plugin.php';

	// Initialize plugin.
	G10DER_Plugin::instance();
}

/**
 * Deactivate plugin if ACF is missing.
 *
 * @return void
 */
function g10der_deactivate_plugin() {

	if (
		class_exists( 'ACF' ) ||
		function_exists( 'acf_register_field_type' )
	) {
		return;
	}

	deactivate_plugins(
		plugin_basename( __FILE__ )
	);

	if ( isset( $_GET['activate'] ) ) {
		unset( $_GET['activate'] );
	}
}

/**
 * ACF Missing Notice
 *
 * @return void
 */
function g10der_acf_missing_notice() {
	?>

	<div class="notice notice-error">
		<p>
			<?php
			esc_html_e(
				'ACF Extended Repeater requires Advanced Custom Fields plugin to be installed and activated.',
				'g10der-repeater-fields-for-advanced-custom-fields'
			);
			?>
		</p>
	</div>

	<?php
}

