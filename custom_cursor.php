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

// creo il menu
 function wporg_settings_init() {
  // register a new setting for "wporg" page
  register_setting( 'wporg', 'wporg_options' );
  // register a new section in the "wporg" page
  add_settings_section( 'wporg_section_developers', __( 'The Matrix has you.', 'wporg' ), 'wporg_section_developers_cb', 'wporg' );
  // register a new field in the "wporg_section_developers" section, inside the "wporg" page
  add_settings_field( 'wporg_field_pill', __( 'Pill', 'wporg' ), 'wporg_field_pill_cb', 'wporg', 'wporg_section_developers', [ 'label_for' => 'wporg_field_pill', 'class' => 'wporg_row', 'wporg_custom_data' => 'custom', ] );
 }
 add_action( 'admin_init', 'wporg_settings_init' );

 function wporg_section_developers_cb( $args ) {
  ?>
  <p id="<?php echo esc_attr( $args['id'] ); ?>"><?php esc_html_e( 'Follow the white rabbit.', 'wporg' ); ?></p>
  <?php
 }

 function wporg_field_pill_cb( $args ) {
  // get the value of the setting we've registered with register_setting()
  $options = get_option( 'wporg_options' );
  // output the field
  ?>
  <select id="<?php echo esc_attr( $args['label_for'] ); ?>" data-custom="<?php echo esc_attr( $args['wporg_custom_data'] ); ?>" name="wporg_options[<?php echo esc_attr( $args['label_for'] ); ?>]" >
	  <option value="red" <?php echo isset( $options[ $args['label_for'] ] ) ? ( selected( $options[ $args['label_for'] ], 'red', false ) ) : ( '' ); ?>>
		  <?php esc_html_e( 'red pill', 'wporg' ); ?>
	  </option>
	  <option value="blue" <?php echo isset( $options[ $args['label_for'] ] ) ? ( selected( $options[ $args['label_for'] ], 'blue', false ) ) : ( '' ); ?>>
		  <?php esc_html_e( 'blue pill', 'wporg' ); ?>
	  </option>
  </select>

	<p></br></p>
	<p> attivare o disattivare il cursore</p>
	<p> numero di palline 1 / 2</p>
	<p> colore e dimensione della prima pallina </p>
	<p> colore, dimensione e velocita della seconda pallina </p>

	<?php
 }

 function wporg_options_page() {
  // add top level menu page
  add_menu_page( 'WPOrg', 'WPOrg Options', 'manage_options', 'wporg', 'wporg_options_page_html' );
 }
 add_action( 'admin_menu', 'wporg_options_page' );

 function wporg_options_page_html() {
  // check user capabilities
  if ( ! current_user_can( 'manage_options' ) ) {
  return;
  }
  // add error/update messages
  // check if the user have submitted the settings
  // wordpress will add the "settings-updated" $_GET parameter to the url
  if ( isset( $_GET['settings-updated'] ) ) {
  // add settings saved message with the class of "updated"
  add_settings_error( 'wporg_messages', 'wporg_message', __( 'Settings Saved', 'wporg' ), 'updated' );
  }
  // show error/update messages
  settings_errors( 'wporg_messages' );
  ?>
  <div class="wrap">
  <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
  <form action="options.php" method="post">
  <?php
  // output security fields for the registered setting "wporg"
  settings_fields( 'wporg' );
  // output setting sections and their fields
  // (sections are registered for "wporg", each field is registered to a specific section)
  do_settings_sections( 'wporg' );
  // output save settings button
  submit_button( 'Save Settings' );
  ?>
  </form>
  </div>
  <?php
 }
