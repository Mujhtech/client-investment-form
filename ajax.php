<?php

/*

    ========================
        AJAX FUNCTIONS
    ========================
*/

add_action('wp_ajax_nopriv_client_save_investment_form', 'client_save_form');
add_action('wp_ajax_client_save_investment_form', 'client_save_form');

function client_save_form()
{
    $title = wp_strip_all_tags($_POST['name']);
    $email = wp_strip_all_tags($_POST['email']);
    $message = wp_strip_all_tags($_POST['comment']);
    $website = wp_strip_all_tags($_POST['website']);
    $investment = wp_strip_all_tags($_POST['investment']);
    $risk = wp_strip_all_tags($_POST['risk']);


    $post_title = $title;
    $post_status = "publish"; //publish, draft, etc
    $post_type = "client-form"; // or whatever post type desired

    /* Attempt to find post id by post name if it exists */
    $found_post_title = get_page_by_title( $post_title, OBJECT, $post_type );
    $found_post_id = $found_post_title->ID;

    /**********************************************************
    ** Check If Page does not exist, if true, create a new post
    ************************************************************/
    if ( FALSE === get_post_status( $found_post_id ) ) {

      $args = array(
          'post_title' => $title,
          'post_content' => $message,
          'post_author' => 1,
          'post_status' => 'publish',
          'post_type' => 'client-form',
          'meta_input' => array(
              '_client_contact_email_value_key' => $email,
              '_client_website_value_key' => $website,
              '_client_asset_value_key' => $investment,
              '_client_risk_value_key' => $risk,
          ),
       );
       $returned_post_id = wp_insert_post( $args );
       $result = array(
         'success' => true,
         'name' => $title,
         'investment' => $investment
       );
       return wp_send_json( $result );

    } else {
    /***************************
    ** IF POST EXISTS, update it
    ****************************/

          /* Update post */
          $update_post_args = array(
            'ID'           => $found_post_id,
            'post_title'   => $post_title,
            'post_content' => $message,
          );

          /* Update the post into the database */
          wp_update_post( $update_post_args );
          update_post_meta( $found_post_id, '_client_contact_email_value_key', $email );
          update_post_meta( $found_post_id, '_client_risk_value_key', $risk );
          update_post_meta( $found_post_id, '_client_asset_value_key', $investment );
          update_post_meta( $found_post_id, '_client_website_value_key', $website );

          $result = array(
            'success' => true,
            'name' => $title,
            'investment' => $investment
          );
          return wp_send_json( $result );
    }
    die();
}
