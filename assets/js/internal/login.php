<script language="javascript" type="text/javascript" >
<!--	***		Removes PHP Error 	***		-->
function removeError(id)
{
	//alert(id);
	//$("#"+id).css("display", "none");
	$("#"+id).slideUp(400);
}

<!--	***		Bootstrap validator	***		-->
$(document).ready(function() {

$('#login_btn').click(function (){
	//alert("myquote button is clicked");
	ValidateLoginForm();
	var validator = $('[id*=frmuser]').data('bootstrapValidator');
    validator.validate();
   // return validator.isValid();
});

});

function ValidateLoginForm() {
    $('#frmuser').bootstrapValidator({
		excluded: ':disabled',
        feedbackIcons: {
            valid: 'glyphicon',
            invalid: 'glyphicon',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
		    profile_email: {
				selector: '#email_header',
				container: '#email_header_message',
					validators: {
						notEmpty: {
                            message: '<?php echo PAGE_LOGIN_FIELD_REQUIRED." ".PAGE_LOGIN_EMAIL_REQUIRED; ?>'
                        },
						emailAddress: {
                        	message: '<?php echo PAGE_LOGIN_EMAIL_VALID; ?>'
                    	}
					}
            },
			password: {
				selector: '#password_header',
				container: '#password_header_message',
					validators: {
						notEmpty: {
                            message: '<?php echo PAGE_LOGIN_FIELD_REQUIRED; ?>'
                        }
					}
            }
        }
		});
    }
</script>
