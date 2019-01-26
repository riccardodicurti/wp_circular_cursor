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
	wp_enqueue_style( 'rdc_wcc_style', plugin_dir_url( __FILE__ ) . 'public/css/circular_cursor_style.css');
  wp_enqueue_script( 'rdc_wcc_scripts', plugin_dir_url( __FILE__ ) . 'public/js/circular_cursor.js', array( 'jquery' ));
}
add_action( 'wp_enqueue_scripts', 'rdc_wcc_enqueue_dependencies');

function rdc_wcc_enqueue_admin_dependencies() {
	wp_enqueue_style( 'rdc_wcc_admin_style', plugin_dir_url( __FILE__ ) . 'admin/css/color_picker_style.min.css');
  wp_enqueue_script( 'rdc_wcc_admin_scripts', plugin_dir_url( __FILE__ ) . 'admin/js/wp-color-picker-alpha.js', array( 'wp-color-picker' ), false, true );
}
add_action( 'admin_enqueue_scripts', 'rdc_wcc_enqueue_admin_dependencies' );




/* TODO:
 * v. 0.0.2 Inserire nel js tutte le definizioni base del css
 * v. 0.0.3 Creare il menu lato backend per poter apportare tutte le modifiche del trader_cdl3starsinso
 * v. 0.0.4 Salvare nel database tutte le impostazioni scelte dal backen
 * v. 0.0.5 leggere il backend iun questo file e passare tutte le variabili al JS con la localizzazione
 * v. 0.1.0 infiocchettare tutto e vedere come mettere il software nella repository di Wordpress
 */

 function rdc_wcc_settings_init() {
  register_setting( 'rdc_wcc', 'rdc_wcc_options' );
  add_settings_section( 'rdc_wcc_section_developers', __( '', 'rdc_wcc' ), 'rdc_wcc_section_developers_cb', 'rdc_wcc' );
	// add_settings_field( $id, $title, $callback, $page, $section, $args );
	add_settings_field( 'rdc_wcc_field_cursore', __( 'Disattivare il cursore di base ?', 'rdc_wcc' ), 'rdc_wcc_field_cursore', 'rdc_wcc', 'rdc_wcc_section_developers', [ 'label_for' => 'rdc_wcc_field_pill', 'class' => 'rdc_wcc_row', 'rdc_wcc_custom_data' => 'custom', ] );
	add_settings_field( 'rdc_wcc_field_numero_di_palline', __( 'Numero di palline', 'rdc_wcc' ), 'rdc_wcc_field_pill_cb', 'rdc_wcc', 'rdc_wcc_section_developers', [ 'label_for' => 'rdc_wcc_field_pill', 'class' => 'rdc_wcc_row', 'rdc_wcc_custom_data' => 'custom', ] );
	add_settings_field( 'rdc_wcc_field_prima_pallina', __( 'Prima pallina', 'rdc_wcc' ), 'rdc_wcc_field_prima_pallina', 'rdc_wcc', 'rdc_wcc_section_developers', [ 'label_for' => 'rdc_wcc_field_pill', 'class' => 'rdc_wcc_row', 'rdc_wcc_custom_data' => 'custom', ] );
 }
 add_action( 'admin_init', 'rdc_wcc_settings_init' );

 function rdc_wcc_section_developers_cb( $args ) {
  ?>
  <p id="<?php echo esc_attr( $args['id'] ); ?>"><?php esc_html_e( 'In questa pagina si posso modificare le impostazioni del plugin.', 'rdc_wcc' ); ?></p>
  <?php
 }

 function rdc_wcc_field_cursore( $args ) {
  // get the value of the setting we've registered with register_setting()
  $options = get_option( 'rdc_wcc_options' );
  // output the field
  ?>
	<input type="checkbox" name="rdc_wcc_options[cursore]" value="1"<?php checked( 1 == $options['cursore'] ); ?> /><br>
	<?php
 }

 function rdc_wcc_field_pill_cb( $args ) {
  // get the value of the setting we've registered with register_setting()
  $options = get_option( 'rdc_wcc_options' );
  // output the field
  ?>
  <select id="<?php echo esc_attr( $args['label_for'] ); ?>" data-custom="<?php echo esc_attr( $args['rdc_wcc_custom_data'] ); ?>" name="rdc_wcc_options[<?php echo esc_attr( $args['label_for'] ); ?>]" >
	  <option value="red" <?php echo isset( $options[ $args['label_for'] ] ) ? ( selected( $options[ $args['label_for'] ], 'red', false ) ) : ( '' ); ?>>
		  <?php esc_html_e( 'Due palline', 'rdc_wcc' ); ?>
	  </option>
	  <option value="blue" <?php echo isset( $options[ $args['label_for'] ] ) ? ( selected( $options[ $args['label_for'] ], 'blue', false ) ) : ( '' ); ?>>
		  <?php esc_html_e( 'Una pallina', 'rdc_wcc' ); ?>
	  </option>
  </select>

	<p></br></p>
	<p> attivare o disattivare il cursore</p>
	<p> numero di palline 1 / 2</p>
	<p> colore e dimensione della prima pallina </p>
	<p> colore, dimensione e velocita della seconda pallina </p>

	<?php
 }

 function rdc_wcc_field_prima_pallina( $args ) {
	// get the value of the setting we've registered with register_setting()
	$options = get_option( 'rdc_wcc_options' );
	// output the field
	echo '<input type="text" class="color-picker" data-alpha="true" data-default-color="rgba(0,0,0,0.85)" name="rdc_wcc_options[col_prima_pallina]" value="' . $rdc_wcc_options['col_prima_pallina'] . '"/>';
 }

 function rdc_wcc_options_page() {
  // add top level menu page
  add_menu_page( 'WordPress Circular Cursor', 'Circular Cursor', 'manage_options', 'rdc_wcc', 'rdc_wcc_options_page_html' );
 }
 add_action( 'admin_menu', 'rdc_wcc_options_page' );

 function rdc_wcc_options_page_html() {
  // check user capabilities
  if ( ! current_user_can( 'manage_options' ) ) {
  return;
  }
  // add error/update messages
  // check if the user have submitted the settings
  // wordpress will add the "settings-updated" $_GET parameter to the url
  if ( isset( $_GET['settings-updated'] ) ) {
  // add settings saved message with the class of "updated"
  add_settings_error( 'rdc_wcc_messages', 'rdc_wcc_message', __( 'Settings Saved', 'rdc_wcc' ), 'updated' );
  }
  // show error/update messages
  settings_errors( 'rdc_wcc_messages' );
  ?>
  <div class="wrap">
  <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
  <form action="options.php" method="post">
  <?php
  // output security fields for the registered setting "rdc_wcc"
  settings_fields( 'rdc_wcc' );
  // output setting sections and their fields
  // (sections are registered for "rdc_wcc", each field is registered to a specific section)
  do_settings_sections( 'rdc_wcc' );
  // output save settings button
  submit_button( 'Save Settings' );
  ?>
  </form>
  </div>
  <?php
 }
