<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://nubocoder.com
 * @since      1.0.0
 *
 * @package    Nubocoder_Bb_Simple_Module_Creator
 * @subpackage Nubocoder_Bb_Simple_Module_Creator/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Nubocoder_Bb_Simple_Module_Creator
 * @subpackage Nubocoder_Bb_Simple_Module_Creator/includes
 * @author     César Siancas <zed.1985@gmail.com>
 */
class Nubocoder_Bb_Simple_Module_Creator_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'nubocoder-bb-simple-module-creator',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
