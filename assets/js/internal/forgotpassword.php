<script src="https://www.google.com/recaptcha/api.js?onload=loadCaptcha&render=explicit"></script>

<script language="javascript" type="text/javascript">

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
$(document).ready(function() {
$('#frmlogin')
.bootstrapValidator({
	feedbackIcons: {
		valid: 'glyphicon glyphicon-ok',
		invalid: 'glyphicon glyphicon-remove',
		validating: 'glyphicon glyphicon-refresh'
	},
	fields: {
		
		forgotpassword_email: {
			selector: '#emailid',
			container: '#emailid_message',
				validators: {
					notEmpty: {
						message: '<?php echo MSG_EMAIL_ID_IS_REQUIRED." ".MSG_EMAIL_ID_IS_REQUIRED; ?>'
					},
					emailAddress: {
						message: '<?php echo MSG_FORGOT_PASSWORD_EMAIL_INVALID; ?>'
					}
				}
		}, 
		forgotpassword_recaptcha: {
			selector: captchaContainer,
			container: '#reCaptcha_error_message',
			validators: {
				notEmpty: {
					message: '<?php echo MSG_CAPTCHA_IS_REQUIRED; ?>'
				}
			}
		}
	}
})

.on('success.form.bv', function(e) {
	
	if($("#gcaptcha").val() == "")
	 {
		$("#reCaptcha_error_message").css("display", "block");
		return false;
	 }else{
		 $("#reCaptcha_error_message").css("display", "none");
		
	 
	var emailid = $("#emailid").val();
	run_waitMe('win8_linear');
	$.ajax({
	  url: '<?php echo DIR_HTTP_RELATED.FILE_FORGOTPASSWORD; ?>',
	  type: 'post',
	  data: {
            "emailid": $("#emailid").val(),
			"ptoken": $("#ptoken").val()
            },
	  dataType: 'json',
	  success: function(data, status) { 
	  
		if(data['email_id'])
		{
			$('.containerBlock > form').waitMe('hide');
			$('#EmailError_css').show();
			$('#EmailError').html(data['email_id']);
			$("#btnsubmit").removeAttr('disabled');
		}else if(data['emailIdNotdb']){
			$('.containerBlock > form').waitMe('hide');
			$('#forgotSuccess').modal('show');
		}else if(data['EmailIdNotExist']){
			$('.containerBlock > form').waitMe('hide');
			$('#forgotError').modal('show');
		}else{
			$('.containerBlock > form').waitMe('hide');
			$('#forgotSuccess').modal('show');
		}
		
	  },
	  
	}); // end ajax call
	 return false;
	}
	
	 
})
});
$('#p').click(function(e){
	
	window.location.href = '<?php echo SITE_INDEX; ?>';
	e.preventDefault();
	return true;
})
$('#errorp').click(function(){ 
	window.location.href = '<?php echo SITE_INDEX; ?>';
	e.preventDefault();
	return true;
})
<!--	***		Redirection to Index	***		-->
function redirectModel()
{
	window.location.href = '<?php echo SITE_INDEX; ?>';
	e.preventDefault();
	return true;
}
/*	*** This function removes error msg when keystroke is pressed within the form field	*** */
function removeError(id)
{
	$("#"+id).slideUp(400);
}
		
</script>
