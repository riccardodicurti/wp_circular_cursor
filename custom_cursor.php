<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://example.com
 * @since             1.0.0
 * @package           Plugin_Name
 *
 * @wordpress-plugin
 * Plugin Name:       WordPress Plugin Boilerplate
 * Plugin URI:        http://example.com/plugin-name-uri/
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           0.0.1
 * Author:            Riccardo Di Curti
 * Author URI:        http://example.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       rdc_cc
 * Domain Path:       /languages
 */

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'PLUGIN_NAME_VERSION', '0.0.1' );


// import JS e CSS
function rdc_cc_enqueue_dependencies() {
	wp_enqueue_style( 'rdc_cc_style', plugins_url( 'custom_cursor/public/css/custom_cursor_style.css', dirname(__FILE__)));
  wp_enqueue_script( 'rdc_cc_scripts', plugins_url( 'custom_cursor/public/js/custom_cursor.js', dirname(__FILE__) ), array( 'jquery' ));
}

add_action( 'wp_enqueue_scripts', 'rdc_cc_enqueue_dependencies');



// create

// .custom-cursor(style="opacity: 1;")
//   span#main
//   span#follow

// settings




?>
