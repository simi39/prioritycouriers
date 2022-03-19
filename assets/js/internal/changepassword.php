<script type="text/javascript" >
$(document).ready(function() {
	$('#frmchangepassword')
		// IMPORTANT: on('init.field.bv') must be declared
        // before calling .bootstrapValidator(...)
        .on('init.field.bv', function(e, data) {
            // $(e.target)  --> The field element
            // data.bv      --> The BootstrapValidator instance
            // data.field   --> The field name
            // data.element --> The field element
            var $parent = data.element.parents('.form-group'),
                $icon   = $parent.find('.form-control-feedback[data-bv-icon-for="' + data.field + '"]'),
                $label  = $parent.find('label');

            // Place the icon right after the label
            $icon.insertAfter($label);
        })
		.bootstrapValidator({
		excluded: ':disabled',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
		    changepassword_newpass: {
				selector: '#Change_Pass',
				container: '#newpass_message',
					validators: {
						notEmpty: {
                            message: '<?php echo NEWPASSWORD_IS_REQUIRED; ?>'
                        },
						stringLength: {
                         min: 8,
                         message: '<?php echo CHANGEPASSWORD_PASSWORD_LENGTH; ?>'
						},
						regexp: {
						   regexp: /^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=\S+$).{8,}$/,
						   message: '<?php echo CHANGEPASSWORD_RIGHT_PASSWORD;?>'
						}
					}
            },
			changepassword_confpass: {
			 	selector: '#Conf_Pass',
				container: '#confpass_message',
			    validators: {
                    notEmpty: {
                            message: '<?php echo CONFIRMPASSWORD_IS_REQUIRED; ?>'
                        },
					identical: {
                        field: 'changepassword_newpass',
                        message: 'The password and its confirm are not the same'
                    }
                }
            }
		}
		})
		
});
/*	*** This function removes error msg when keystroke is pressed within the form field	*** */
function removeError(id)
{
	$("#"+id).slideUp(400);
}
</script>
