<?php
/**
 * Plugin Name:       WordPress Circular Cursor
 * Plugin URI:        https://github.com/riccardodicurti/wp_circular_cursor
 * GitHub Plugin URI: riccardodicurti/wp_circular_cursor
 * Description:       WordPress Circular Cursor è un plugin che ti permette di migliorare il tuo cursore rendendolo particolare.
 * Version:           20200319
 * Author:            Riccardo Di Curti
 * Author URI:        https://riccardodicurti.it/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       rdc_wcc
 * Domain Path:       /languages
 */

function rdc_wcc_enqueue_dependencies() {
	wp_register_script( 'rdc_wcc_scripts', plugin_dir_url( __FILE__ ) . 'public/js/circular_cursor.js', array( 'jquery' ), false, true);
	wp_register_script( 'rdc_wcc_scripts-2', plugin_dir_url( __FILE__ ) . 'public/js/paper-core.min.js', array( 'jquery' ), false, true);
	wp_register_script( 'rdc_wcc_scripts-3', plugin_dir_url( __FILE__ ) . 'public/js/initPageTransition.js', array( 'jquery' ), false, true);
	wp_register_script( 'rdc_wcc_scripts-4', plugin_dir_url( __FILE__ ) . 'public/js/gsap.min.js', array( 'jquery' ), false, true);
	wp_register_script( 'rdc_wcc_scripts-5', plugin_dir_url( __FILE__ ) . 'public/js/scripts.js', array( 'jquery' ), false, true);

	$options = get_option( 'rdc_wcc_options' );

	if ( $options['numero_di_palline'] > 2 ) {
		// modalità a doppia pallina magnetica 
		wp_enqueue_style( 'rdc_wcc_style', plugin_dir_url( __FILE__ ) . 'public/css/circular_cursor_style.min.css');
		wp_enqueue_style( 'rdc_wcc_style-2', plugin_dir_url( __FILE__ ) . 'public/css/circular_cursor_magnetico_style.css');
		wp_enqueue_script( 'rdc_wcc_scripts-2' );
		wp_enqueue_script( 'rdc_wcc_scripts-4' );
		wp_enqueue_script( 'rdc_wcc_scripts-5' );
	} else {
		// modalità a una o due palline normali 
		wp_enqueue_style( 'rdc_wcc_style', plugin_dir_url( __FILE__ ) . 'public/css/circular_cursor_style.min.css');
		wp_localize_script( 'rdc_wcc_scripts', 'options', $options );
		wp_enqueue_script( 'rdc_wcc_scripts' );
	}
}
add_action( 'wp_enqueue_scripts', 'rdc_wcc_enqueue_dependencies');

function rdc_wcc_enqueue_admin_dependencies() {
	wp_enqueue_style( 'rdc_wcc_admin_style', plugin_dir_url( __FILE__ ) . 'admin/css/color_picker_style.min.css');
	wp_enqueue_style( 'rdc_wcc_admin_style_2', plugin_dir_url( __FILE__ ) . 'admin/css/admin_page_style.min.css');
  	wp_enqueue_script( 'rdc_wcc_admin_scripts', plugin_dir_url( __FILE__ ) . 'admin/js/wp-color-picker-alpha.js', array( 'wp-color-picker' ), false, true );
}
add_action( 'admin_enqueue_scripts', 'rdc_wcc_enqueue_admin_dependencies' );

 function rdc_wcc_settings_init() {
  	register_setting( 'rdc_wcc', 'rdc_wcc_options' );

  	add_settings_section( 'rdc_wcc_section_developers', __( '', 'rdc_wcc' ), 'rdc_wcc_section_developers_cb', 'rdc_wcc' );
	add_settings_field( 'rdc_wcc_field_cursore', __( 'Turn off the basic cursor?', 'rdc_wcc' ), 'rdc_wcc_field_cursore', 'rdc_wcc', 'rdc_wcc_section_developers', [ 'label_for' => 'rdc_wcc_field_cursore', 'class' => 'rdc_wcc_row', 'rdc_wcc_custom_data' => 'custom', ] );
	add_settings_field( 'rdc_wcc_field_cursore', __( 'Set the z-index value of the first cursor', 'rdc_wcc' ), 'rdc_wcc_field_zindex', 'rdc_wcc', 'rdc_wcc_section_developers', [ 'label_for' => 'rdc_wcc_field_zindex', 'class' => 'rdc_wcc_row', 'rdc_wcc_custom_data' => 'custom', ] );
	add_settings_field( 'rdc_wcc_field_numero_di_palline', __( 'Select the type of cursor', 'rdc_wcc' ), 'rdc_wcc_field_numero_di_palline', 'rdc_wcc', 'rdc_wcc_section_developers', [ 'label_for' => 'rdc_wcc_field_numero_di_palline', 'class' => 'rdc_wcc_row', 'rdc_wcc_custom_data' => 'custom', ] );
	add_settings_field( 'rdc_wcc_field_colore_prima_pallina', __( 'Select the color of the first cursor', 'rdc_wcc' ), 'rdc_wcc_field_colore_prima_pallina', 'rdc_wcc', 'rdc_wcc_section_developers', [ 'label_for' => 'rdc_wcc_field_colore_prima_pallina', 'class' => 'rdc_wcc_row', 'rdc_wcc_custom_data' => 'custom', ] );
	add_settings_field( 'rdc_wcc_field_dimensione_prima_pallina', __( 'Select the size of the first cursor', 'rdc_wcc' ), 'rdc_wcc_field_dimensione_prima_pallina', 'rdc_wcc', 'rdc_wcc_section_developers', [ 'label_for' => 'rdc_wcc_field_dimensione_prima_pallina', 'class' => 'rdc_wcc_row', 'rdc_wcc_custom_data' => 'custom', ] );
	add_settings_field( 'rdc_wcc_field_colore_seconda_pallina', __( 'Select the color of the second cursor', 'rdc_wcc' ), 'rdc_wcc_field_colore_seconda_pallina', 'rdc_wcc', 'rdc_wcc_section_developers', [ 'label_for' => 'rdc_wcc_field_colore_seconda_pallina', 'class' => 'rdc_wcc_row', 'rdc_wcc_custom_data' => 'custom', ] );
	add_settings_field( 'rdc_wcc_field_dimensione_seconda_pallina', __( 'Select the size of the second cursor', 'rdc_wcc' ), 'rdc_wcc_field_dimensione_seconda_pallina', 'rdc_wcc', 'rdc_wcc_section_developers', [ 'label_for' => 'rdc_wcc_field_dimensione_seconda_pallina', 'class' => 'rdc_wcc_row', 'rdc_wcc_custom_data' => 'custom', ] );
	add_settings_field( 'rdc_wcc_field_multiplicatore_seconda_pallina', __( 'Select the growth multiplier of the second cursor', 'rdc_wcc' ), 'rdc_wcc_field_multiplicatore_seconda_pallina', 'rdc_wcc', 'rdc_wcc_section_developers', [ 'label_for' => 'rdc_wcc_field_multiplicatore_seconda_pallina', 'class' => 'rdc_wcc_row', 'rdc_wcc_custom_data' => 'custom', ] );
	add_settings_field( 'rdc_wcc_field_ritardo_seconda_pallina', __( 'Select the delay of the second cursor respect to the first', 'rdc_wcc' ), 'rdc_wcc_field_ritardo_seconda_pallina', 'rdc_wcc', 'rdc_wcc_section_developers', [ 'label_for' => 'rdc_wcc_field_ritardo_seconda_pallina', 'class' => 'rdc_wcc_row', 'rdc_wcc_custom_data' => 'custom', ] );
 }
 add_action( 'admin_init', 'rdc_wcc_settings_init' );

 function rdc_wcc_section_developers_cb( $args ) {
  ?>
  <p id="<?php echo esc_attr( $args['id'] ); ?>"><?php esc_html_e( 'In questa pagina si posso modificare le impostazioni del plugin.', 'rdc_wcc' ); ?></p>
  <?php
 }

 function rdc_wcc_field_cursore( $args ) {
  	$rdc_wcc_options = get_option( 'rdc_wcc_options' );
  	?>
	<input type="checkbox" name="rdc_wcc_options[zindex]" value="10"<?php checked( 1 == $rdc_wcc_options['zindex'] ); ?> /><br>
	<?php
 }

 function rdc_wcc_field_zindex( $args ) {
	$rdc_wcc_options = get_option( 'rdc_wcc_options' );
  	echo '<input type="number" name="rdc_wcc_options[zindex]" min="0" max="10001" step="1" value="' . $rdc_wcc_options['zindex'] . '"/>';
 }

 function rdc_wcc_field_numero_di_palline( $args ) {
  	$rdc_wcc_options = get_option( 'rdc_wcc_options' );
  	?>
  	<select id="<?php echo esc_attr( $args['label_for'] ); ?>" data-custom="<?php echo esc_attr( $args['rdc_wcc_custom_data'] ); ?>" name="rdc_wcc_options[numero_di_palline]" >
  	  	<option value="3" <?php echo isset( $rdc_wcc_options['numero_di_palline'] ) ? ( selected( $rdc_wcc_options['numero_di_palline'], '3', false ) ) : ( '' ); ?>>
		  	<?php esc_html_e( 'Double magnetic circular slider', 'rdc_wcc' ); ?>
	  	</option>  
	  	<option value="2" <?php echo isset( $rdc_wcc_options['numero_di_palline'] ) ? ( selected( $rdc_wcc_options['numero_di_palline'], '2', false ) ) : ( '' ); ?>>
		  	<?php esc_html_e( 'Double circular cursor', 'rdc_wcc' ); ?>
	 	</option>
	 	<option value="1" <?php echo isset( $rdc_wcc_options['numero_di_palline'] ) ? ( selected( $rdc_wcc_options['numero_di_palline'], '1', false ) ) : ( '' ); ?>>
			<?php esc_html_e( 'Single circular cursor', 'rdc_wcc' ); ?>
	  	</option>
  	</select>
	<?php
 }

 function rdc_wcc_field_colore_prima_pallina( $args ) {
	$rdc_wcc_options = get_option( 'rdc_wcc_options' );
	echo '<input type="text" class="color-picker" data-alpha="true" data-default-color="rgba(0,0,0,0.85)" name="rdc_wcc_options[col_prima_pallina]" value="' . $rdc_wcc_options['col_prima_pallina'] . '"/>';
 }

 function rdc_wcc_field_dimensione_prima_pallina( $args ) {
	 $rdc_wcc_options = get_option( 'rdc_wcc_options' );
	 echo '<input type="number" class="dim_prima_pallina" name="rdc_wcc_options[dim_prima_pallina]" min="1" max="20" step="1" value="' . $rdc_wcc_options['dim_prima_pallina'] . '"/><span> px</span>';
 }

 function rdc_wcc_field_colore_seconda_pallina( $args ) {
	$rdc_wcc_options = get_option( 'rdc_wcc_options' );
	echo '<input type="text" class="color-picker" data-alpha="true" data-default-color="rgba(0,0,0,0.50)" name="rdc_wcc_options[col_seconda_pallina]" value="' . $rdc_wcc_options['col_seconda_pallina'] . '"/>';
 }

 function rdc_wcc_field_dimensione_seconda_pallina( $args ) {
	$rdc_wcc_options = get_option( 'rdc_wcc_options' );
	echo '<input type="number" class="dim_seconda_pallina" name="rdc_wcc_options[dim_seconda_pallina]" min="1" max="20" step="1" value="' . $rdc_wcc_options['dim_seconda_pallina'] . '"/><span> px</span>';
 }

 function rdc_wcc_field_multiplicatore_seconda_pallina( $args ) {
	$rdc_wcc_options = get_option( 'rdc_wcc_options' );
	echo '<input type="number" class="multi_seconda_pallina" name="rdc_wcc_options[multi_seconda_pallina]" min="1" max="20" step="1" value="' . $rdc_wcc_options['multi_seconda_pallina'] . '"/><span> X</span>';
 }

 function rdc_wcc_field_ritardo_seconda_pallina( $args ) {
 $rdc_wcc_options = get_option( 'rdc_wcc_options' );
 echo '<input type="number" class="vel_seconda_pallina" name="rdc_wcc_options[vel_seconda_pallina]" min="50" max="800" step="50" value="' . $rdc_wcc_options['vel_seconda_pallina'] . '"/><span> milliseconds</span> ';
 }

 function rdc_wcc_options_page() {
	add_options_page( 'WordPress Circular Cursor', 'Circular Cursor', 'manage_options', 'rdc_wcc', 'rdc_wcc_options_page_html' );
 }
 add_action( 'admin_menu', 'rdc_wcc_options_page' );

 function rdc_wcc_options_page_html() {
  if ( ! current_user_can( 'manage_options' ) ) {
  	return;
  }
  if ( isset( $_GET['settings-updated'] ) ) {
  	add_settings_error( 'rdc_wcc_messages', 'rdc_wcc_message', __( 'Settings Saved', 'rdc_wcc' ), 'updated' );
  }
  settings_errors( 'rdc_wcc_messages' );
  ?>
  <div class="wrap">
	  <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
	  <form action="options.php" method="post">
		  <?php
		  settings_fields( 'rdc_wcc' );
		  do_settings_sections( 'rdc_wcc' );
		  submit_button( 'Save Settings' );
		  ?>
	  </form>
  </div>
  <?php
 }
