<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://brdytoken.com
 * @since             1.0.0
 * @package           Brdy_Nest
 *
 * @wordpress-plugin
 * Plugin Name:       BRDY Nest
 * Plugin URI:        https://https://brdy-nest.github.io
 * Description:       BRDY Nests are small local projects that help others and can be placed on your site anywhere.  Kind of like your own "Go Fund Me".
 * Version:           1.0.0
 * Author:            Will
 * Author URI:        https://brdytoken.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       brdy-nest
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
define( 'BRDY_NEST_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-brdy-nest-activator.php
 */
function activate_brdy_nest() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-brdy-nest-activator.php';
	Brdy_Nest_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-brdy-nest-deactivator.php
 */
function deactivate_brdy_nest() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-brdy-nest-deactivator.php';
	Brdy_Nest_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_brdy_nest' );
register_deactivation_hook( __FILE__, 'deactivate_brdy_nest' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-brdy-nest.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_brdy_nest() {

	$plugin = new Brdy_Nest();
	$plugin->run();

}
run_brdy_nest();
