jQuery(document).ready(function() {
	jQuery("input[@name='bounce_payment']").click(function() {

		if (jQuery("input[@name='bounce_payment']:checked").val() == 'paypal') {
			jQuery(".boxpaypal").css("display","block");
			jQuery(".boxcheck").css("display","none");
	//		console.log('paypal');
		} else if (jQuery("input[@name='bounce_payment']:checked").val() == 'check') {
			jQuery(".boxpaypal").css("display","none");
			jQuery(".boxcheck").css("display","block");
	//		console.log('check');
		}
	});
	
	jQuery("#wpl").hide();
	jQuery("#wpr").hide();
	
	jQuery("#yes").click(function() {
		jQuery("#wpl").show();
		jQuery("#wpr").hide();
		jQuery("#no").fadeTo("slow", 0.33);
		jQuery(this).fadeTo("fast", 1.0);
	});
	
	jQuery("#no").click(function() {
		jQuery("#wpl").hide();
		jQuery("#wpr").show();
		jQuery("#yes").fadeTo("slow", 0.33);
		jQuery(this).fadeTo("fast", 1.0);
	});
	
	jQuery("#wpl").submit(function(){
		jQuery('#login_submit').val('Logging In...').addClass('submit-ajax');
		var inputs = [];
        jQuery(':input', this).each(function() {
          inputs.push(this.name + '=' + escape(this.value));
        });
		jQuery.ajax({
			data: inputs.join('&'),
			type: 'post',
			error: function() { 
		//		console.log("Login: failed to submit");
				jQuery('#login_error').css("display","block");
				jQuery('#login_submit').val('Log In').removeClass('submit-ajax');				
			},
			success: function(d,s) { 
				var obj = eval('(' + d + ')');
		//		console.log(obj);
				if (obj.userID == '-1') {
					jQuery('#login_submit').val('Log In').removeClass('submit-ajax');
					jQuery('#login_error').css("display","block");
		//			console.log('LOGIN error: '+obj.error);
				} else {
					jQuery('#settings').css("display","block");
					jQuery('#login').css("display","none");
					jQuery('#settings_instructions').css("display","block");
					jQuery('#bounce_affiliate').val(obj.userID);
					jQuery('#bounce_paypal').val(obj.email);
					jQuery('#bounce_check_firstname').val(obj.userFirstName);
					jQuery('#bounce_check_middlename').val(obj.userMI);
					jQuery('#bounce_check_lastname').val(obj.userLastName);
					jQuery('#bounce_check_address').val(obj.userAddress1);
					jQuery('#bounce_check_address2').val(obj.userAddress2);
					jQuery('#bounce_check_city').val(obj.userCity);
					jQuery('#bounce_check_state').val(obj.userState);
					jQuery('#bounce_check_zip').val(obj.userZipCode);
				}
			},
			complete: function() {
				//console.log("Complete Login Ajax");
				jQuery('#login_submit').val('Log In').removeClass('submit-ajax');
				jQuery('#login_error').css("display","none");
			}
		});
		//console.log('LOGIN: submitted to '+this.action+' with this data: '+inputs);
		return false;
	});

	jQuery("#wpr").submit(function() {
		jQuery('#register_submit').val('Submitting...').addClass('submit-ajax');
		var inputs = [];
		jQuery(':input',this).each(function() {
			inputs.push(this.name + '=' + escape(this.value));
		});
		jQuery.ajax({
			data: inputs.join('&'),
			type: 'post',
			error: function() {
			//	console.log("REGISTER: failed to submit");
				jQuery('#register_submit').val('Register').removeClass('submit-ajax');
				jQuery('#register_error').css("display","block");
			},
			success: function(d,s) {
				var obj = eval('(' + d + ')');
			//	console.log(obj);
				if (obj.userID == '-1') {
					jQuery('#register_submit').val('Register').removeClass('submit-ajax');
					jQuery('#register_error').css("display","block");
			//		console.log('REGISTER error: '+obj.error);
				} else {
			//		console.log('register success');
					jQuery('#settings').css("display","block");
					jQuery('#login').css("display","none");
					jQuery('#settings_instructions').css("display","block");
					jQuery('#bounce_affiliate').val(obj.userID);
					jQuery('#bounce_paypal').val(obj.email);
					jQuery('#bounce_check_name').val(obj.userFirstName +' '+ obj.userMI +' '+ obj.userLastName);
					jQuery('#bounce_check_address').val(obj.userAddress1);
					jQuery('#bounce_check_address2').val(obj.userAddress2);
					jQuery('#bounce_check_city').val(obj.userCity);
					jQuery('#bounce_check_state').val(obj.userState);
					jQuery('#bounce_check_zip').val(obj.userZipCode);
				}

			},
			complete: function() {
			//	console.log("Complete Register Ajax");
				jQuery('#register_submit').val('Register').removeClass('submit-ajax');
				jQuery('#register_error').css("display","none");
			}
		});
	//	console.log('REGISTER: submitted to '+this.action+' with this data: '+inputs);
		return false;
	});
});