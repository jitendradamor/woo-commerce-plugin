<?php

/**
 * The plugin file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://woocommerce.com/
 * @since             1.0.0
 * @package           Woocommerce_Add_On_Plugin
 *
 * @wordpress-plugin
 * Plugin Name:       Woocommerce Add On
 * Description:       This Plugin is Add On of Wocoommerce plugin.
 * Version:           1.0.0
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       woocommerce-add-on-plugin
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'WOOCOMMERCE_ADD_ON_PLUGIN_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-woocommerce-add-on-plugin-activator.php
 */
function activate_woocommerce_add_on_plugin() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-woocommerce-add-on-plugin-activator.php';
	woocommerce_add_on_plugin_activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-woocommerce-add-on-plugin-deactivator.php
 */
function deactivate_woocommerce_add_on_plugin() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-woocommerce-add-on-plugin-deactivator.php';
	Woocommerce_Add_On_Plugin_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_woocommerce_add_on_plugin' );
register_deactivation_hook( __FILE__, 'deactivate_woocommerce_add_on_plugin' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-woocommerce-add-on-plugin.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_woocommerce_add_on_plugin() {

	$plugin = new Woocommerce_Add_On_Plugin();
	$plugin->run();

}
run_woocommerce_add_on_plugin();

// Wocoomerce Plugin required if not activated then shows this error message
register_activation_hook( __FILE__, 'woocommerce_plugin_activate' );
function woocommerce_plugin_activate(){

    // Require parent (woocommerce) plugin
    if ( ! is_plugin_active( 'woocommerce/woocommerce.php' ) ) {
        // Stop activation redirect and show error
        wp_die('Sorry, but this plugin requires the Woocomerce Plugin to be activate. <br><a href="' . admin_url( 'plugins.php' ) . '">&laquo; Return to Plugins</a>');
    } else {
		is_plugin_active('woocommerce-add-on-plugin/woocommerce-add-on-plugin.php');
	}
}

// If Wocoomerce Plugin is Deactivated then shows this error message
function woocommerce_plugin_deactivation( $plugin, $network_activation ) {
    if ($plugin=="woocommerce/woocommerce.php") {
		wp_die('Sorry, but Woocommerce Add On plugin requires the Woocomerce Plugin to be activate. <br><a href="' . admin_url( 'plugins.php' ) . '">&laquo; Return to Plugins</a>');
    }
}
add_action( 'deactivated_plugin', 'woocommerce_plugin_deactivation', 10, 2 );

//Include taxonomy page related hooks file
require_once plugin_dir_path( __FILE__ ) . 'includes/taxonomy-page-hooks.php';

//Include Out of stock price hooks file
require_once plugin_dir_path( __FILE__ ) . 'includes/out-of-stock-hook.php';

//Include create custom fields in checkout page hooks file
require_once plugin_dir_path( __FILE__ ) . 'includes/checkout-custom-fields-hook.php';

//Include create custom fields in checkout page hooks file
require_once plugin_dir_path( __FILE__ ) . 'includes/woocommerce-api-endpoints.php';

//Include order concluded file
require_once plugin_dir_path( __FILE__ ) . 'includes/order-concluded.php';
