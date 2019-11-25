<?php

/*
@package mujhtechtheme


	CUSTOM POST TYPE
*/
	$option = get_option( 'activate_client_form' );
	if ( @$option == 1 ) {
		add_action( 'init', 'client_investment_form_custom_post_type' );
		add_filter( 'manage_client-form_posts_columns', 'client_entry_set_contact_columns' );
		add_action( 'manage_client-form_posts_custom_column', 'client_entry_custom_columns', 10, 2 );
		add_action( 'add_meta_boxes', 'client_entry_add_meta_box' );
		add_action( 'save_post', 'client_entry_save_email_data' );
		add_action( 'save_post', 'client_entry_save_website_data' );
		add_action( 'save_post', 'client_entry_save_asset_data' );
		add_action( 'save_post', 'client_entry_save_risk_data' );

	}


	function client_investment_form_custom_post_type(){
		$labels = array(
				'name'				=>	'Client Investments',
				'singular_name'		=>	'Client Investment',
				'menu_name'			=>	'Client Investments',
				'name_admin_bar'	=>	'Client Investment'
		);

		$args = array(
				'labels'				=>	$labels,
				'show_ui'		=>	true,
				'show_ui_menu'			=>	true,
				'capability_type'	=>	'post',
				'hierarchical'	=>	false,
				'menu_position'	=>	200,
				'publicly_queryable' => true,
				'menu_icon'	=>	'dashicons-email-alt',
				'supports'	=>	array( 'title', 'editor' )
		);

		register_post_type( 'client-form', $args );
	}

	function client_entry_set_contact_columns( $columns ) {
		$clientColumns = array();
		$clientColumns['cb'] = "<input type=\"checkbox\" />";
		$clientColumns['title'] = 'Full Name';
		$clientColumns['email'] = 'Email';
		$clientColumns['website'] = 'Website';
		$clientColumns['investment'] = 'Total Investment Asset';
		$clientColumns['message'] = 'Comment';
		$clientColumns['risk'] = 'Risk';
		return $clientColumns;

	}


	function client_entry_custom_columns( $columns, $post_id ) {

		switch ( $columns ) {
			case 'email':
				$value = get_post_meta( $post_id, '_client_contact_email_value_key', true );
				echo '<a href="mailto:'.$value.'">'.$value.'</a>';
				break;

				case 'website':
					$value = get_post_meta( $post_id, '_client_website_value_key', true );
					echo '<a href="http://'.$value.'" target="_blank">'.$value.'</a>';
					break;

				case 'investment':
					$value = get_post_meta( $post_id, '_client_asset_value_key', true );
					echo '<strong>$'.$value.'</strong>';
					break;

				case 'message':
					echo get_the_excerpt();
					break;

				case 'risk':
					$value = get_post_meta( $post_id, '_client_risk_value_key', true );
					echo '<strong>'.strtoupper($value).'</strong>';
					break;
		}

	}

	function client_entry_add_meta_box(){
		add_meta_box( 'client_contact_email', 'Email Address', 'client_entry_email_callback', 'client-form', 'side' );
		add_meta_box( 'client_website', 'Website Link', 'client_entry_website_callback', 'client-form', 'side' );
		add_meta_box( 'client_asset', 'Total Investment Asset in $', 'client_entry_asset_callback', 'client-form', 'side' );
		add_meta_box( 'client_risk', 'Risk', 'client_entry_risk_callback', 'client-form', 'side' );
	}

	function client_entry_email_callback( $post ){
		wp_nonce_field( 'client_entry_save_email_data', 'client_entry_email_meta_box_nonce' );
		$value = get_post_meta( $post->ID, '_client_contact_email_value_key', true );

		echo '<label for="client_entry_email_field"> User Email </label> ';
		echo '<input type="text" name="client_entry_email_field" id="client_entry_email_field" value="'. esc_attr( $value ).'" size="25"/>';
	}

	function client_entry_website_callback( $post ){
		wp_nonce_field( 'client_entry_save_website_data', 'client_entry_website_meta_box_nonce' );
		$value = get_post_meta( $post->ID, '_client_website_value_key', true );

		echo '<label for="client_entry_website_field">Website Link</label> ';
		echo '<input type="text" name="client_entry_website_field" id="client_entry_website_field" value="'. esc_attr( $value ).'" size="25"/>';
	}

	function client_entry_asset_callback( $post ){
		wp_nonce_field( 'client_entry_save_asset_data', 'client_entry_asset_meta_box_nonce' );
		$value = get_post_meta( $post->ID, '_client_asset_value_key', true );

		echo '<label for="client_entry_asset_field">Total Investment Asset in $</label> ';
		echo '<input type="text" name="client_entry_asset_field" id="client_entry_asset_field" value="'. esc_attr( $value ).'" size="25"/>';
	}

	function client_entry_risk_callback( $post ){
		wp_nonce_field( 'client_entry_save_risk_data', 'client_entry_risk_meta_box_nonce' );

		$value = get_post_meta( $post->ID, '_client_risk_value_key', true );
		$checkedHig = '';
		$checkedLow = '';
		$checkedMod = '';
		if ($value == 'high') {
			$checkedHig = 'checked';
		} elseif ($value == 'moderate') {
			$checkedMod = 'checked';
		} elseif ($value == 'low') {
			$checkedLow = 'checked';
		} else {
			$checkedHig = '';
			$checkedLow = '';
			$checkedMod = '';
		}

		echo '<label for="client_entry_risk_field"></label><br/>';
		echo '<input type="radio" id="client_entry_risk_field" name="client_entry_risk_field" value="high"  '.$checkedHig.'>High ';
		echo '<input type="radio" id="client_entry_risk_field" name="client_entry_risk_field" value="moderate"  '.$checkedMod.'>Moderate ';
		echo '<input type="radio" id="client_entry_risk_field" name="client_entry_risk_field" value="low" '.$checkedLow.'>Low';
	}


	function client_entry_save_email_data( $post_id ){

	if (! isset( $_POST['client_entry_email_meta_box_nonce'] ) ) {
		 		return;
 	}
	if (! wp_verify_nonce( $_POST['client_entry_email_meta_box_nonce'], 'client_entry_save_email_data' ) ) {
	 		return;
	}
	if ( define('DOING_AUTOSAVE') && DOING_AUTOSAVE ) {
		return;
	}
	if (! current_user_can( 'edit_post', $post_id )) {
		return;
	}
	if (! isset( $_POST['client_entry_email_field'] )) {
		return;
	}

 	$my_data = sanitize_text_field( $_POST['client_entry_email_field'] );

 	update_post_meta( $post_id , '_client_contact_email_value_key' , $my_data );

 }

 function client_entry_save_website_data( $post_id ){

 if (! isset( $_POST['client_entry_website_meta_box_nonce'] ) ) {
			 return;
 }
 if (! wp_verify_nonce( $_POST['client_entry_website_meta_box_nonce'], 'client_entry_save_website_data' ) ) {
		 return;
 }
 if ( define('DOING_AUTOSAVE') && DOING_AUTOSAVE ) {
	 return;
 }
 if (! current_user_can( 'edit_post', $post_id )) {
	 return;
 }
 if (! isset( $_POST['client_entry_website_field'] )) {
	 return;
 }

 $my_data = sanitize_text_field( $_POST['client_entry_website_field'] );

 update_post_meta( $post_id , '_client_website_value_key' , $my_data );

}


function client_entry_save_asset_data( $post_id ){

if (! isset( $_POST['client_entry_asset_meta_box_nonce'] ) ) {
			return;
}
if (! wp_verify_nonce( $_POST['client_entry_asset_meta_box_nonce'], 'client_entry_save_asset_data' ) ) {
		return;
}
if ( define('DOING_AUTOSAVE') && DOING_AUTOSAVE ) {
	return;
}
if (! current_user_can( 'edit_post', $post_id )) {
	return;
}
if (! isset( $_POST['client_entry_asset_field'] )) {
	return;
}

$my_data = sanitize_text_field( $_POST['client_entry_asset_field'] );

update_post_meta( $post_id , '_client_asset_value_key' , $my_data );

}


function client_entry_save_risk_data( $post_id ){

if (! isset( $_POST['client_entry_risk_meta_box_nonce'] ) ) {
			return;
}
if (! wp_verify_nonce( $_POST['client_entry_risk_meta_box_nonce'], 'client_entry_save_risk_data' ) ) {
		return;
}
if ( define('DOING_AUTOSAVE') && DOING_AUTOSAVE ) {
	return;
}
if (! current_user_can( 'edit_post', $post_id )) {
	return;
}
if (! isset( $_POST['client_entry_risk_field'] )) {
	return;
}

$my_data = sanitize_text_field( $_POST['client_entry_risk_field'] );

update_post_meta( $post_id , '_client_risk_value_key' , $my_data );

}
