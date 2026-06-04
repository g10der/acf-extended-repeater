<?php
/**
 * Plugin Name: ACF Extended Repeater
 * Plugin URI: https://github.com/g10der/acf-extended-repeater
 * Description: Adds a lightweight repeater field to Advanced Custom Fields Free.
 * Version: 1.0.0
 * Requires at least: 6.0
 * Requires PHP: 7.4
 * Author: Jitender kumar
 * Author URI: https://github.com/g10der
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: acf-extended-repeater
 * Domain Path: /languages
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Plugin Constants
 */
define( 'AER_VERSION', '1.0.0' );
define( 'AER_PATH', plugin_dir_path( __FILE__ ) );
define( 'AER_URL', plugin_dir_url( __FILE__ ) );


/**
 * Activation Check
 *
 * @return void
 */
function aer_activate_plugin() {

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
				'acf-extended-repeater'
			),

			esc_html__(
				'Plugin Dependency Check',
				'acf-extended-repeater'
			),

			array(
				'back_link' => true,
			)

		);
	}
}

register_activation_hook(
	__FILE__,
	'aer_activate_plugin'
);


/**
 * Initialize Plugin
 */
add_action( 'plugins_loaded', 'aer_init_plugin' );

/**
 * Plugin Init
 *
 * @return void
 */
function aer_init_plugin() {

	// Check if ACF exists.
	if (
	! class_exists( 'ACF' ) &&
	! function_exists( 'acf_register_field_type' )
) {

		add_action( 'admin_notices', 'aer_acf_missing_notice' );

add_action(
			'admin_init',
			'aer_deactivate_plugin'
		);
		return;
	}

	// Load plugin core.
	require_once AER_PATH . 'includes/class-plugin.php';

	// Initialize plugin.
	AER_Plugin::instance();
}

/**
 * Deactivate plugin if ACF is missing.
 *
 * @return void
 */
function aer_deactivate_plugin() {

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
 * Load plugin textdomain.
 */
add_action(
    'init',
    function() {

        load_plugin_textdomain(
            'acf-extended-repeater',
            false,
            dirname(
                plugin_basename(__FILE__)
            ) . '/languages'
        );

    }
);

/**
 * ACF Missing Notice
 *
 * @return void
 */
function aer_acf_missing_notice() {
	?>

	<div class="notice notice-error">
		<p>
			<?php
			esc_html_e(
				'ACF Extended Repeater requires Advanced Custom Fields plugin to be installed and activated.',
				'acf-extended-repeater'
			);
			?>
		</p>
	</div>

	<?php
}

