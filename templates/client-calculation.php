<?php if ( is_user_logged_in() ) { ?>
  <?php
    global $wpdb;
    $userName = get_user_by('id', get_current_user_id())->display_name;
    $res = "SELECT * FROM " .$wpdb->posts. " WHERE post_type = 'client-form' AND post_status = 'publish' AND post_title = '" .$userName. "' ";
    $args = $wpdb->get_results($res, OBJECT);
    if ( $args ) {
      foreach ($args as $post) {
        setup_postdata( $post );
        ?>
          <?php if ($display == 'all') { ?>
            <h2><?php echo "Dear, " .$post->post_title. " "; ?></h2>
            <p><strong>Comment: <?php echo $post->post_content; ?></strong><br>
            <strong>Email Address: <?php  echo get_post_meta( $post->ID, '_client_contact_email_value_key', true); ?></strong><br>
            <strong>Website Link: <a href="http://<?php  echo get_post_meta( $post->ID, '_client_website_value_key', true); ?>"><?php  echo get_post_meta( $post->ID, '_client_website_value_key', true); ?></a></strong><br>
            <strong>Total Investment: $<?php  echo get_post_meta( $post->ID, '_client_asset_value_key', true); ?></strong><br>
            <strong>Risk Level: <?php  echo get_post_meta( $post->ID, '_client_risk_value_key', true); ?></strong></p>
            <input type="hidden" id="riskLevel" value="<?php  echo get_post_meta( $post->ID, '_client_risk_value_key', true); ?>">
            <input type="hidden" id="investLevel" value="<?php  echo get_post_meta( $post->ID, '_client_asset_value_key', true); ?>">
            <input type="hidden" id="calcValue" value="<?php  echo $calc_value; ?>">
            <p><strong>We recommended you to invest <span id="recommededInvest"></span></strong></p>
          <?php } elseif ($display == 'name') { ?>
            <h2><?php echo "Dear, " .$post->post_title. " "; ?></h2>
            <p><strong>Total Investment: $<?php  echo get_post_meta( $post->ID, '_client_asset_value_key', true); ?></strong><br>
            <strong>Risk Level: <?php  echo get_post_meta( $post->ID, '_client_risk_value_key', true); ?></strong></p>
            <input type="hidden" id="riskLevel" value="<?php  echo get_post_meta( $post->ID, '_client_risk_value_key', true); ?>">
            <input type="hidden" id="investLevel" value="<?php  echo get_post_meta( $post->ID, '_client_asset_value_key', true); ?>">
            <input type="hidden" id="calcValue" value="<?php  echo $calc_value; ?>">
            <p><strong>We recommended you to invest <span id="recommededInvest"></span></strong></p>
          <?php } elseif ($display == 'name_email') { ?>
            <h2><?php echo "Dear, " .$post->post_title. " "; ?></h2>
            <p><strong>Email Address: <?php  echo get_post_meta( $post->ID, '_client_contact_email_value_key', true); ?></strong><br>
            <strong>Total Investment: $<?php  echo get_post_meta( $post->ID, '_client_asset_value_key', true); ?></strong><br>
            <strong>Risk Level: <?php  echo get_post_meta( $post->ID, '_client_risk_value_key', true); ?></strong></p>
            <input type="hidden" id="riskLevel" value="<?php  echo get_post_meta( $post->ID, '_client_risk_value_key', true); ?>">
            <input type="hidden" id="investLevel" value="<?php  echo get_post_meta( $post->ID, '_client_asset_value_key', true); ?>">
            <input type="hidden" id="calcValue" value="<?php  echo $calc_value; ?>">
            <p><strong>We recommended you to invest <span id="recommededInvest"></span></strong></p>
          <?php } elseif ($display == 'name_email_website') { ?>
            <h2><?php echo "Dear, " .$post->post_title. " "; ?></h2>
            <p><strong>Email Address: <?php  echo get_post_meta( $post->ID, '_client_contact_email_value_key', true); ?></strong><br>
              <strong>Website Link: <a href="http://<?php  echo get_post_meta( $post->ID, '_client_website_value_key', true); ?>"><?php  echo get_post_meta( $post->ID, '_client_website_value_key', true); ?></a></strong><br>
            <strong>Total Investment: $<?php  echo get_post_meta( $post->ID, '_client_asset_value_key', true); ?></strong><br>
            <strong>Risk Level: <?php  echo get_post_meta( $post->ID, '_client_risk_value_key', true); ?></strong></p>
            <input type="hidden" id="riskLevel" value="<?php  echo get_post_meta( $post->ID, '_client_risk_value_key', true); ?>">
            <input type="hidden" id="investLevel" value="<?php  echo get_post_meta( $post->ID, '_client_asset_value_key', true); ?>">
            <input type="hidden" id="calcValue" value="<?php  echo $calc_value; ?>">
            <p><strong>We recommended you to invest <span id="recommededInvest"></span></strong></p>
          <?php } ?>
        <?php
      }
    } else {
      echo "No investment available for this user";
    }
  ?>
<?php } else { ?>
    <p>
      Please these form is restricted for only login user, click <a href="<?php echo get_site_url(); ?>/wp-login.php" title="Login Page" rel="home">here</a> to login in order to  to access the form
    </p>
<?php } ?>
