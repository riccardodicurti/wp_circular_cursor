<?php
/**
 * Plugin Name:       WordPress Circular Cursor
 * Plugin URI:        http://example.com/plugin-name-uri/
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           0.0.1
 * Author:            Riccardo Di Curti
 * Author URI:        http://example.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       rdc_wcc
 * Domain Path:       /languages
 */

// import JS e CSS
function rdc_wcc_enqueue_dependencies() {
	wp_enqueue_style( 'rdc_wcc_style', plugin_dir_url( __FILE__ ) . 'public/css/custom_cursor_style.css');
  wp_enqueue_script( 'rdc_wcc_scripts', plugin_dir_url( __FILE__ ) . 'public/js/custom_cursor.js', array( 'jquery' ));
}
add_action( 'wp_enqueue_scripts', 'rdc_wcc_enqueue_dependencies');


/* TODO:
 * v. 0.0.2 Inserire nel js tutte le definizioni base del css
 * v. 0.0.3 Creare il menu lato backend per poter apportare tutte le modifiche del trader_cdl3starsinso
 * v. 0.0.4 Salvare nel database tutte le impostazioni scelte dal backen
 * v. 0.0.5 leggere il backend iun questo file e passare tutte le variabili al JS con la localizzazione
 * v. 0.1.0 infiocchettare tutto e vedere come mettere il software nella repository di Wordpress
 */

?>
