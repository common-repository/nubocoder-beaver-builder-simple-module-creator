<?php

/**
 * NuboCoder - Beaver Builder Simple Module Creator
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://nubocoder.com
 * @since             1.0.0
 * @package           Nubocoder_Bb_Simple_Module_Creator
 *
 * @wordpress-plugin
 * Plugin Name:       NuboCoder - Beaver Builder Simple Module Creator
 * Plugin URI:        https://nubocoder.com/nubocoder-bb-simple-module-creator
 * Description:       Simple module creator for Beaver Builder.
 * Version:           1.0.0
 * Author:            César Siancas
 * Author URI:        https://nubocoder.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       nubocoder-bb-simple-module-creator
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
define( 'NUBOCODER_BB_SIMPLE_MODULE_CREATOR_VERSION', '1.0.0' );

/**
 * Folder containing all the custom class definitions
 */
define( 'NUBOCODER_BB_SIMPLE_MODULE_CREATOR_MODULES_FOLDER', WP_CONTENT_DIR.'/nubocoder/bb-simple-module-creator/modules' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-nubocoder-bb-simple-module-creator-activator.php
 */
function ncbbsmc_activate_nubocoder_bb_simple_module_creator() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-nubocoder-bb-simple-module-creator-activator.php';
	Nubocoder_Bb_Simple_Module_Creator_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-nubocoder-bb-simple-module-creator-deactivator.php
 */
function ncbbsmc_deactivate_nubocoder_bb_simple_module_creator() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-nubocoder-bb-simple-module-creator-deactivator.php';
	Nubocoder_Bb_Simple_Module_Creator_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'ncbbsmc_activate_nubocoder_bb_simple_module_creator' );
register_deactivation_hook( __FILE__, 'ncbbsmc_deactivate_nubocoder_bb_simple_module_creator' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-nubocoder-bb-simple-module-creator.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function ncbbsmc_run_nubocoder_bb_simple_module_creator() {

	$plugin = new Nubocoder_Bb_Simple_Module_Creator();
	$plugin->run();

}

ncbbsmc_run_nubocoder_bb_simple_module_creator();
