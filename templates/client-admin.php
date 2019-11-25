<?php settings_errors(); ?>
<p>Use this <strong>shortcode</strong> to show client investment form inside a page or a post</p>
<p><code>[client_form_show]</code></p>
<p>Use this <strong>shortcode</strong> to show client investment calculation inside a page or a post</p>
<p>Use this to display all information<code>[client_calculation_show display="all" calc_value="0.02"]</code></p>
<p>Use this to display name, investment and calculation information<code>[client_calculation_show display="name" calc_value="0.02"]</code></p>
<p>Use this to display name, email, investment and calculation information<code>[client_calculation_show display="name_email" calc_value="0.02"]</code></p>
<p>Use this to display name, email, website, investment and calculation information<code>[client_calculation_show display="name_email_website" calc_value="0.02"]</code></p>
<form method="post" action="options.php" class="mujhtech-general-form">
	<?php settings_fields( 'client-investment-group' ); ?>
	<?php do_settings_sections( 'client_investment_plugin' ); ?>
	<?php submit_button( 'Save Changes', 'primary', 'btnSubmit' ); ?>
</form>
