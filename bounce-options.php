<?php
/*
	Options page for the Bounce plugin
*/
if ( !empty($_POST ) ) :
	update_option('bounce_affiliate',$_POST['bounce_affiliate']);
	update_option('bounce_payment',$_POST['bounce_payment']);
	update_option('bounce_paypal',$_POST['bounce_paypal']);
	update_option('bounce_check_firstname',$_POST['bounce_check_firstname']);
	update_option('bounce_check_middlename',$_POST['bounce_check_middlename']);
	update_option('bounce_check_lastname',$_POST['bounce_check_lastname']);
	update_option('bounce_check_address',$_POST['bounce_check_address']);
	update_option('bounce_check_address2',$_POST['bounce_check_address2']);
	update_option('bounce_check_city',$_POST['bounce_check_city']);
	update_option('bounce_check_state',$_POST['bounce_check_state']);
	update_option('bounce_check_zip',$_POST['bounce_check_zip']);	
	
	require_once( ABSPATH . 'wp-includes/class-snoopy.php');
	$snoopy = new Snoopy();
	$result = $snoopy->submit('http://bounce.cc/wpu.php',$_POST);
	if ($result) {
		$response = $snoopy->results;
	} else {
		echo 'Could not reach remote web service';
	}

	if ($response) {
?>
	<div id="message" class="updated fade"><p><strong>Options Saved!</strong></p></div>
<?php } else { ?>
	<div id="message" class="updated fade"><p><strong>Problem Saving Options. Please try again.</strong></p></div>
<?php }	?>
<?php
endif;

$bounce_affiliate = get_option('bounce_affiliate');
$bounce_payment = get_option('bounce_payment');
$bounce_paypal = get_option('bounce_paypal');
$bounce_check_firstname = get_option('bounce_check_firstname');
$bounce_check_middlename = get_option('bounce_check_middlename');
$bounce_check_lastname = get_option('bounce_check_lastname');
$bounce_check_address = get_option('bounce_check_address');
$bounce_check_address2 = get_option('bounce_check_address2');
$bounce_check_city = get_option('bounce_check_city');
$bounce_check_state = get_option('bounce_check_state');
$bounce_check_zip = get_option('bounce_check_zip');
if (!isset($_POST['bounce_footer']))
{
	$_POST['bounce_footer'] = 0;
}
update_option('bounce_footer',$_POST['bounce_footer']);


$siteurl = get_option('siteurl');
$path = PLUGINDIR.'/'.dirname(plugin_basename(__FILE__));
if (is_numeric($bounce_affiliate)) {
	$show_settings = true;
} else {
	$show_settings = false;
}
?>
<link rel="stylesheet" href="<?php echo $siteurl.'/'.$path; ?>/bounce.css" type="text/css" media="screen" charset="utf-8" />
<script type="text/javascript" charset="utf-8" src="<?php echo $siteurl; ?>/wp-includes/js/jquery/jquery.js"></script>
<script>
	jQuery(document).ready(function() {
		jQuery.ajaxSetup({url: '<?php echo $siteurl; ?>/wp-admin/admin-ajax.php'});
	});
</script>
<script type="text/javascript" charset="utf-8" src="<?php echo $siteurl.'/'.$path; ?>/bounce.js"></script>
<style>
.submit-ajax {
	background: url(<?php echo $siteurl.'/'.$path; ?>/ajax.gif) no-repeat right center;
}

#yes {
	background: #CEE1EF url(<?php echo $siteurl.'/'.$path; ?>/yes.png) no-repeat 5px center;
}

#no {
	background: #CEE1EF url(<?php echo $siteurl.'/'.$path; ?>/no.png) no-repeat 5px center;
}
</style>
<div class="wrap">
	<div id="settings" <?php if ($show_settings) { echo 'style="display: block;"'; } else { echo 'style="display: none;"'; } ?>>
		<h2>Bounce.cc Settings</h2>
		<div id="settings_instructions" style="display: none;">
			Select a payment type, make any changes you need to make and then click <strong>Update Options</strong>.
		</div>
		
		<form method="post" action="" id="bounce-settings">
			<?php wp_nonce_field('update-options'); ?>
			<input type="hidden" name="action" value="update" />
			<input type="hidden" name="page_options" value="bounce_affiliate" />
			<input type="hidden" name="page_options" value="bounce_payment" />
			<input type="hidden" name="page_options" value="bounce_footer" />
			<input type="hidden" name="page_options" value="bounce_paypal" />
			<input type="hidden" name="page_options" value="bounce_check_firstname" />
			<input type="hidden" name="page_options" value="bounce_check_middlename" />
			<input type="hidden" name="page_options" value="bounce_check_lastname" />
			<input type="hidden" name="page_options" value="bounce_check_address" />
			<input type="hidden" name="page_options" value="bounce_check_address2" />
			<input type="hidden" name="page_options" value="bounce_check_city" />
			<input type="hidden" name="page_options" value="bounce_check_state" />
			<input type="hidden" name="page_options" value="bounce_check_zip" />

			<div class="form-row"><label for="bounce_affiliate">Bounce.cc ID:</label><input type="text" name="bounce_affiliate" value="<?php echo $bounce_affiliate; ?>" id="bounce_affiliate" /></div>
			<div class="form-row"><strong class="label">Payment Method:</strong> <div class="paymentgroup"><label class="strong" for="bounce_payment_paypal"><input type="radio" name="bounce_payment" value="paypal" id="bounce_payment_paypal" <?php if ($bounce_payment == 'paypal') { ?>checked="checked"<?php } ?> /> Paypal</label> <label class="strong" for="bounce_payment_check"><input type="radio" name="bounce_payment" value="check" id="bounce_payment_check" <?php if ($bounce_payment == 'check') { ?>checked="checked"<?php } ?> /> Check</label></div></div>

			<div class="form-row boxpaypal" <?php if ($bounce_payment == 'paypal') { ?>style="display: block;"<?php } ?>><label for="bounce_paypal">PayPal Email Address:</label><input type="text" name="bounce_paypal" value="<?php echo $bounce_paypal; ?>" id="bounce_paypal" /></div>

			<fieldset class="boxcheck" <?php if ($bounce_payment == 'check') { ?>style="display: block;"<?php } ?>>
				<legend>Send My Check To:</legend>
				<div class="form-row"><label for="bounce_check_firstname">First Name:</label> <input type="text" name="bounce_check_firstname" value="<?php echo $bounce_check_firstname; ?>" id="bounce_check_firstname" /></div>
				<div class="form-row"><label for="bounce_check_middlename">Middle Initial:</label> <input type="text" name="bounce_check_middlename" value="<?php echo $bounce_check_middlename; ?>" id="bounce_check_middlename" /></div>
				<div class="form-row"><label for="bounce_check_lastname">Last Name:</label> <input type="text" name="bounce_check_lastname" value="<?php echo $bounce_check_lastname; ?>" id="bounce_check_lastname" /></div>
				
				<div class="form-row"><label for="bounce_check_address">Mailing Address:</label> <input type="text" name="bounce_check_address" value="<?php echo $bounce_check_address; ?>" id="bounce_check_address" /></div>
				<div class="form-row"><label for="bounce_check_address2">Address Line 2:</label> <input type="text" name="bounce_check_address2" value="<?php echo $bounce_check_address2; ?>" id="bounce_check_address2" /></div>
				<div class="form-row"><label for="bounce_check_city">City:</label> <input type="text" name="bounce_check_city" value="<?php echo $bounce_check_city; ?>" id="bounce_check_city" /></div>
				<div class="form-row"><label for="bounce_check_state">State:</label> <input type="text" name="bounce_check_state" value="<?php echo $bounce_check_state; ?>" id="bounce_check_state" /></div>
				<div class="form-row"><label for="bounce_check_zip">Zip Code:</label> <input type="text" name="bounce_check_zip" value="<?php echo $bounce_check_zip; ?>" id="bounce_check_zip" /></div>
			</fieldset>

			<div class="tablenav">
				<input type="submit" name="submit" value="Update Options »" class="button-secondary" id="options_submit" />
			</div>
		</form>
	</div>
	<div id="login" <?php if ($show_settings) { echo 'style="display: none;"'; } else { echo 'style="display: block;"'; } ?>>
		<ul id="bounce">
		<h2>Do you have a Bounce.cc account yet?</h2>
		<li><a href="#wrap" id="yes">Yes</a></li><li><a href="#wrap" id="no">No</a></li></ul>
		<form method="post" action="<?php echo get_option('siteurl'); ?>/wp-admin/admin-ajax.php" id="wpl">
		<div id="login_error">There was a problem logging into your account. Please try again.</div>
		<p>Login in below and we will automatically configure the plugin.</p>

			<div class="form-row"><label for="email">Email:</label> <input type="text" name="email" value="" id="email" /></div>
			<div class="form-row"><label for="password">Password:</label> <input type="password" name="password" value="" id="password" /></div>
			<input type="hidden" name="action" value="bounce_login" id="action" />
			<div class="tablenav">
				<input type="submit" name="submit" value="Login" class="button-secondary" id="login_submit" />
			</div>
		</form>

		<form action="<?php echo get_option('siteurl'); ?>/wp-admin/admin-ajax.php" method="post" id="wpr">
			<div id="register_error">There was a problem registering your new account. Please try again.</div>
			<p><a href="http://bounce.cc/index.php?inc=newreg">Register with Bounce.cc</a> below and we will automatically configure the plugin to work with your new account. All fields are required.</p>
			<div class="col-left">
				<div class="form-row"><label for="firstname">First Name:</label><input type="text" name="firstname" value="" id="firstname" /></div>
				<div class="form-row"><label for="middlename">Middle Initial:</label><input type="text" name="middlename" value="" id="middlename" /></div>
				<div class="form-row"><label for="lastname">Last Name:</label><input type="text" name="lastname" value="" id="lastname" /></div>
				<div class="form-row"><label for="address">Address Line 1:</label><input type="text" name="address" value="" id="address" /></div>
				<div class="form-row"><label for="address2">Address Line 2:</label><input type="text" name="address2" value="" id="address2" /></div>
				<div class="form-row"><label for="city">City:</label><input type="text" name="city" value="" id="city" /></div>
				<div class="form-row"><label for="state">State:</label><input type="text" name="state" value="" id="state" /></div>
				<div class="form-row"><label for="zip">Zip Code:</label><input type="text" name="zip" value="" id="zip" /></div>
				<div class="form-row"><label for="phone">Phone Number:</label><input type="text" name="phone" value="" id="phone" /></div>
			</div>
			<div class="col-right">
				<h4>Create Your Login</h4>
				<div class="form-row">
					<label for="remail">Email:</label> <input type="text" name="email" value="" id="email" />
					<br /><em>This will also be your username.</em>
				</div>
				<div class="form-row"><label for="rpassword">Password:</label> <input type="password" name="password" value="" id="password" /></div>
				<div class="form-row"><label for="rpassword2">Confirm Password:</label> <input type="password" name="rpassword2" value="" id="rpassword2" /></div>
			</div>
			<input type="hidden" name="action" value="bounce_register" id="action" />
			<div class="tablenav">
				<input type="submit" name="submit" value="Register" class="button-secondary" id="register_submit" />
			</div>
		</form>
	</div>
	
</div>