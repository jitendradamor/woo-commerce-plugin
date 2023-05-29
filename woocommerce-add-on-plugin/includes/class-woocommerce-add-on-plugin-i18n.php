<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://https://woocommerce.com/
 * @since      1.0.0
 *
 * @package    Woocommerce_Add_On_Plugin
 * @subpackage Woocommerce_Add_On_Plugin/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Woocommerce_Add_On_Plugin
 * @subpackage Woocommerce_Add_On_Plugin/includes
 * @author     Woocommerce <testineed2@gmail.com>
 */
class Woocommerce_Add_On_Plugin_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'woocommerce-add-on-plugin',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
