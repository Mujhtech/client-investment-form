<?php if ( is_user_logged_in() ) { ?>

<form id="clientInvestmentFormPlugin" class="sunset-contact-form" action="#" method="post" data-url="<?php echo admin_url('admin-ajax.php'); ?>">
    <!-- <div class="form-group">
      <input type="text" name="name" value="" id="name" class=" sunset-form-control" placeholder="Your Name">
      <small class="text-danger form-control-msg">Your name is Required</small>
    </div> -->
    <input type="hidden" name="name" id="name" value="<?php echo get_user_by('id', get_current_user_id())->display_name; ?>">
    <div class="form-group">
      <input type="text" name="email" value="" id="email" class="form-control sunset-form-control" placeholder="Your Email">
      <small class="text-danger form-control-msg">Your Email is Required</small>
    </div>
    <div class="form-group">
      <input type="number" id="investment" name="totalAv" class="form-control sunset-form-control" value="" placeholder="Your Total Investment Asset">
      <small class="text-danger form-control-msg">Your Investment is Required</small>
    </div>
    <div class="form-group">
      <input type="text" name="website" value="" id="website" class="form-control sunset-form-control" placeholder="Your Website">
    </div>
    <div class="form-group">
      <textarea name="comment" rows="5" cols="40" id="comment" class="form-control sunset-form-control" placeholder="Your Comment"></textarea>
    </div>
    <div class="form-group">
      <div class="row custom-control custom-radio">
        <div class="col-md-3">What is your allowable level of risk tolerance?</div>
        <div class="col-md-3"><input type="radio" class="custom-control-input sunset-form-control" id="risk" name="chk[]" value="low">Low</div>
        <div class="col-md-3"><input type="radio" class="custom-control-input sunset-form-control" id="risk1" name="chk[]" value="moderate">Moderate</div>
        <div class="col-md-3"><input type="radio" class="custom-control-input sunset-form-control" id="risk2" name="chk[]" value="high">High</div>
      </div>
    </div>
    <div class="text-center">
  		<button type="stubmit" class="btn btn-default btn-lg btn-sunset-form">Submit</button>
      <small class="text-info form-control-msg js-form-submission">Submission in process, please wait..</small>
      <small class="text-success form-control-msg js-form-success">Message Successfully submitted, thank you!</small>
      <small class="text-danger form-control-msg js-form-error">There was a problem with the Contact Form, please try again!</small>
    </div>
  </form>
<?php } else { ?>
    <p>
      Please these form is restricted for only login user, click <a href="<?php echo get_site_url(); ?>/wp-login.php" title="Login Page" rel="home">here</a> to login in order to  to access the form
    </p>
<?php } ?>
