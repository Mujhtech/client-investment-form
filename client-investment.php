<?php
/**
 * @package Client_Investment_Form
 * @version 1.0.0
 */
/*
Plugin Name: Client Investment Form
Plugin URI: http://mujhtech.educonsult.cloud
Description: This is a plugin that ask about client investment and give an angorithm result based on client input.
Author: Mujhtech Mujeeb Muhideen
Version: 1.0.0.
Author URI: http://mujhtech.educonsult.cloud/
*/


function client_investment_add_admin_page() {

    //Admin page

	add_menu_page( 'Client Investment Form Settings', 'Client Investment Form', 'manage_options', 'client_investment_plugin', 'client_investment_setting_page', 'dashicons-admin-settings', 110 );

    //Activate Custom Setting

    add_action( 'admin_init', 'client_investment_custom_setting' );


}
add_action( 'admin_menu', 'client_investment_add_admin_page' );


function client_investment_custom_setting() {

	//Client Investment Form
	register_setting( 'client-investment-group', 'activate_client_form' );
	// register_setting( 'client-investment-group', 'min_investment' );
	// register_setting( 'client-investment-group', 'max_investment' );
	add_settings_section( 'client-investment-form-plugin' , 'Client Investment Form' , 'client_investment_plugin_form' , 'client_investment_plugin' );
	add_settings_field( 'client-investment-form', 'Activate Client Investment Form', 'client_investment_form_activate', 'client_investment_plugin', 'client-investment-form-plugin' );
	// add_settings_field( 'max-investment-input', 'Maximum investment input', 'client_investment_max_input', 'client_investment_plugin', 'client-investment-form-plugin' );
	// add_settings_field( 'min-investment-input', 'Minimum investment input', 'client_investment_min_input', 'client_investment_plugin', 'client-investment-form-plugin' );

}

function client_investment_setting_page() {
	include( plugin_dir_path(__FILE__) . 'templates/client-admin.php');
}

function client_investment_plugin_form(){
	echo "Activate client investment form options";
}

// function client_investment_min_input() {
// 	$min_input = esc_attr(get_option( 'min_investment' ));
// 	echo '<input type="text" name="min_investment" value="'.$min_input.'" placeholder="Min Investment">';
// }
//
// function client_investment_max_input() {
// 	$max_input = esc_attr(get_option( 'max_investment' ));
// 	echo '<input type="text" name="max_investment" value="'.$max_input.'" placeholder="Maximum Investment">';
// }

function client_investment_form_activate() {
	$option = get_option( 'activate_client_form' );
	$checked = ( @$option == 1 ? 'checked' : '' );
	echo '<label><input type="checkbox" name="activate_client_form" value="1" id="activate_client_form" '.$checked.' /></label>';
}

require plugin_dir_path(__FILE__) . 'admin/custom-post-type.php';


function show_client_investment_form( $atts, $content = null ){

	$atts = shortcode_atts(
		array(),
		$atts,
		'client_form_show'
	);

	ob_start();
	include plugin_dir_path(__FILE__) . 'templates/client-form.php';
	return ob_get_clean();

}
add_shortcode( 'client_form_show', 'show_client_investment_form' );

function show_client_investment_calculation( $atts, $content = null ){

	extract(shortcode_atts(
		array( 'display' => 'all',
						'calc_value' => '0.02'),
		$atts,
		'client_form_show'
	));


	ob_start();
	include plugin_dir_path(__FILE__) . 'templates/client-calculation.php';
	return ob_get_clean();

}
add_shortcode( 'client_calculation_show', 'show_client_investment_calculation' );


function client_form_load_scripts(){
  wp_enqueue_style( 'sunset', plugin_dir_url(__FILE__) . 'css/sunset.css', array(), '1.0.0', 'all' );
  wp_enqueue_style( 'client', plugin_dir_url(__FILE__) . 'css/client.css', array(), '1.0.0', 'all' );

	wp_deregister_script( 'jquery' );
	//wp_register_script( 'jquery' , plugin_dir_url(__FILE__) . 'js/jquery.js', false, '1.11.3', true );
	wp_register_script( 'jquery' , 'https://code.jquery.com/jquery-3.4.1.min.js');
	wp_enqueue_script( 'jquery' );
	wp_register_script( 'clientjs', plugin_dir_url(__FILE__) . 'js/client.js', array('jquery'), '1.0.0', true );
  wp_enqueue_script( 'clientjs' );

}
add_action( 'wp_enqueue_scripts', 'client_form_load_scripts' );


require plugin_dir_path(__FILE__) . 'ajax.php';
