<script type="text/javascript">
var captchaContainer = null;
//alert(captchaContainer);
if(captchaContainer == null)
{
	//$('#reCaptcha_error_message').show();
}
var loadCaptcha = function() {
  captchaContainer = grecaptcha.render('captcha_container', {
	'sitekey' : '6LeuBwoTAAAAALmH5yxGYT_tE-G9kMtvKHl0rsmX',
	'callback' : function(response) {
		$("#gcaptcha").val(response);
		$("#btnsubmit").removeAttr('disabled');
		$("#reCaptcha_error_message").css("display", "none");
	  //console.log(response);
	}
  });

};
<!--	****	Intiating slides 	****	-->
jQuery(document).ready(function() {
        App.initSliders();
    });
<!--	***		Bootstrap validator	***		-->
$(document).ready(function() {
    $('#contact-form').bootstrapValidator({
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {

            fullname: {
				selector: '#fullname',
				container: '#fullname_message',
					validators: {
						regexp: {
							regexp: /^[a-zA-Z\s]*$/, //lowercase, upercase, space
							message: '<?php echo CONTACT_FORM_NAME; ?>'
						}
					}
            },
			clientemail: {
				selector: '#clientemail',
				container: '#clientemail_message',
					validators: {
						notEmpty: {
                            message: '<?php echo CONTACT_FORM_FIELD_REQUIRED; ?>'
                        },
						emailAddress: {
                        	message: '<?php echo CONTACT_FORM_EMAIL_VALID; ?>'
                    	}
					}
            },
			enquiry: {
				selector: '#enquiry',
				container: '#enquiry_message',
					validators: {
						notEmpty: {
                            message: '<?php echo CONTACT_FORM_FIELD_REQUIRED; ?>'
                        },
						regexp: {
							regexp: /^[a-zA-Z0-9',_.!?\s\-\/]*$/, //message
							message: '<?php echo CONTACT_FORM_MESSAGE; ?>'
						}
					}
            },
        }
    })
	.on('success.form.bv', function(e) {

		 if($("#gcaptcha").val() == "")
		 {
			$("#reCaptcha_error_message").css("display", "block");
			return false;
		 }else{
			 $("#reCaptcha_error_message").css("display", "none");
			 return true;
		 }
	})

});
</script>
<script src="https://www.google.com/recaptcha/api.js?onload=loadCaptcha&render=explicit"></script>
