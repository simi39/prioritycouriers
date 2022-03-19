<script type="text/javascript" >
<!--	***		Bootstrap validator	***		-->
$(document).ready(function() {
    $('#Frmaddclient')
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
		 feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
		submitButtons: 'button[type="submit"]',
        fields: {
		    profile_firstname: {
				selector: '#firstname',
				container: '#firstname_message',
					validators: {
						notEmpty: {
                            message: '<?php echo PROFILE_FIELD_REQUIRED." ".PROFILE_FIRSTNAME_REQUIRED; ?>'
                        },
						regexp: {
							regexp: /^[a-zA-Z'\s]*$/, //lowercase, upercase, space
							message: '<?php echo PROFILE_ILLEGAL_CHARACTERS."<br />".PROFILE_ALLOWED_CHARACTERS_NAMES; ?>'
						}
					}
            },
			profile_lastname: {
				selector: '#lastname',
				container: '#lastname_message',
					validators: {
						notEmpty: {
                            message: '<?php echo PROFILE_FIELD_REQUIRED." ".PROFILE_LASTNAME_REQUIRED; ?>'
                        },
						regexp: {
							regexp: /^[a-zA-Z'\s]*$/, //lowercase, upercase, apostrophe, space
							message: '<?php echo PROFILE_ILLEGAL_CHARACTERS."<br />".PROFILE_ALLOWED_CHARACTERS_NAMES; ?>'
						}
					}
            },
			profile_company: {
				selector: '#company',
				container: '#company_message',
					validators: {
						callback: {
							callback: function(value, validator, $field) {
								if(value.length>1)
								{
									if (value.search(/^[a-zA-Z0-9 .,:;'?_%\s\-\/]*$/) < 0) {
										return {
											valid: false,
											message: '<?php echo PROFILE_ILLEGAL_CHARACTERS; ?>'
										}
									}
								}
								return true;
							}
						}
					}
            },
			profile_address1: {
				selector: '#address1',
				container: '#address1_message',
					validators: {
						notEmpty: {
                            message: '<?php echo PROFILE_FIELD_REQUIRED." ".PROFILE_ADDRESS1_REQUIRED; ?>'
                        },
						regexp: {
							regexp: /^[a-zA-Z0-9 .,:;'?_%\s\-\/]*$/,
							message: '<?php echo PROFILE_ILLEGAL_CHARACTERS; ?>'
						}
					}
            },
			profile_address2: {
				selector: '#address2',
				container: '#address2_message',
					validators: {
						regexp: {
							regexp: /^[a-zA-Z0-9 .,:;'?_%\s\-\/]*$/,
							message: '<?php echo PROFILE_ILLEGAL_CHARACTERS; ?>'
						}
					}
            },
			profile_address3: {
				selector: '#address3',
				container: '#address3_message',
					validators: {
						regexp: {
							regexp: /^[a-zA-Z0-9 .,:;'?_%\s\-\/]*$/,
							message: '<?php echo PROFILE_ILLEGAL_CHARACTERS; ?>'
						}
					}
            },
			profile_country: {
					selector: '#country',
					container: '#country_message',
                    validators: {
                        notEmpty: {
                            message: '<?php echo PROFILE_COUNTRY_REQUIRED; ?>'
                        }
                    }
          	},
			profile_suburb: {
				selector: '#suburb',
				container: '#suburb_message',
					validators: {
						notEmpty: {
                            message: '<?php echo PROFILE_FIELD_REQUIRED." ".PROFILE_SUBURB_REQUIRED; ?>'
                        }
					}
            },
			profile_fsuburb:{
				 excluded: false,    // Don't ignore me
				 selector: '#fsuburb',
				 container: '#suburb_message',
				 validators: {
					/*notEmpty: {
                            message: '<?php echo PROFILE_FIELD_REQUIRED." ".PROFILE_SUBURB_REQUIRED; ?>'
                        },*/
					remote: {
						url: '<?php echo DIR_HTTP_RELATED."tms_index.php"; ?>',
						data: function(validator) {

							return {
							chksuburb:true,
							flag:validator.getFieldElements('selected_flag').val(),
							letters:$('#fsuburb').val()
							};
						},
						message: '<?php echo SUBURB_NOT_FOUND; ?>'
					},
					callback: {
							callback: function (value, validator, $field) {
							$field.val();
							/*if(value == "")
							{
								return {
									valid: false,
									message: '<?php echo PROFILE_FIELD_REQUIRED." ".PROFILE_SUBURB_REQUIRED; ?>'
								}
							}*/

							if(value.search(/^[a-zA-Z0-9 '%\s\-\/]*$/) < 0 && $('#changed_cntry').val()=='<?php echo AUSTRALIA_ID; ?>') {
								return {
									valid: false,
									message: '<?php echo PROFILE_ILLEGAL_CHARACTERS."<br />"; ?>'
								}
                            }else if(value.search(/^[a-zA-Z '%\s\-\/]*$/) < 0 && $('#changed_cntry').val()!='<?php echo AUSTRALIA_ID; ?>'){
								return {
									valid: false,
									message: '<?php echo PROFILE_ILLEGAL_CHARACTERS."<br />"; ?>'
								}
							}
							return true;

						}
					}
				 }
			},
			profile_state: {
				selector: '#state',
				container: '#state_message',
					validators: {
						notEmpty: {
                            message: '<?php echo PROFILE_FIELD_REQUIRED." ".PROFILE_SUBURB_REQUIRED; ?>'
                        },
						regexp: {
							regexp: /^[a-zA-Z0-9 .,:;'?_%\s\-\/]*$/,
							message: '<?php echo PROFILE_ILLEGAL_CHARACTERS; ?>'
						},
						remote: {
							url: '<?php echo DIR_HTTP_RELATED."inter_state_val.php"; ?>',
							data: function(validator) {
								return {
								letters: validator.getFieldElements('profile_state').val(),
								chkstate:true,
								flag:validator.getFieldElements('selected_flag').val(),
								countryid:validator.getFieldElements('changed_cntry').val(),
								};
							},
                            message: '<?php echo PROFILE_STATE_NOT_FOUND; ?>'
						}
					}
            },
			profile_postcode: {
				selector: '#postcode',
				container: '#postcode_message',
					validators: {
						notEmpty: {
                            message: '<?php echo PROFILE_FIELD_REQUIRED." ".PROFILE_POSTCODE_REQUIRED; ?>'
                        },
						callback: {
							callback: function(value, validator, $field) {
							if (value === '') {
                                return true;
                            }
							if (value.search(/^[a-zA-Z0-9 .,:;'_\s\-\/]*$/) < 0) {
								return {
									valid: false,
									message: '<?php echo PROFILE_ILLEGAL_CHARACTERS."<br />".PROFILE_ALLOWED_CHARACTERS_DIGITS; ?>'
								}
                            }
							var countryid = $("#changed_cntry").val();
							if(countryid == '<?php echo UNITED_STATE_ID ?>')
							{
								if(value.length!=5)
								{
									return {
									valid: false,
									message: '<?php echo ERROR_US_POSTCODE; ?>'
									}
								}
							}else{
									if(value.length<2 || value.length>8)
									{

									return {
									valid: false,
									message: '<?php echo PROFILE_POSTCODE_CORRECT; ?>'
									};
								}

								}
							return true;
							}
						}
					}
            },
			profile_areacode_phone: {
				selector: '#sender_area_code',
				container: '#sender_area_code_message',
					validators: {
						notEmpty: {
                            message: '<?php echo PROFILE_FIELD_REQUIRED." ".PROFILE_AREACODE_REQUIRED; ?>'
                        },
						regexp: {
							regexp: /^[0-9+\s]*$/,
							message: '<?php echo PROFILE_ILLEGAL_CHARACTERS."<br />".PROFILE_AREACODE_ALLOWED_CHARACTERS_DIGITS; ?>'
						},
						stringLength: {
                        	min: 1,
                        	message: '<?php echo PROFILE_CORRECT_AREACODE_LENGTH; ?>'
                    	}
					}
            },
			profile_sender_phone: {
				selector: '#phone',
				container: '#phone_message',
					validators: {
						notEmpty: {
                            message: '<?php echo PROFILE_FIELD_REQUIRED." ".PROFILE_CONTACTNO_REQUIRED; ?>'
                        },
						regexp: {
							regexp: /^[0-9]*$/,
							message: '<?php echo PROFILE_ILLEGAL_CHARACTERS."<br />".PROFILE_ALLOWED_CHARACTERS_DIGITS; ?>'
						},
						stringLength: {
                        	min: 9,
							max:12,
                        	message: '<?php echo PROFILE_CORRECT_PHONE_LENGTH; ?>'
                    	}
					}
            },
			profile_areacode_mobile: {
				selector: '#sender_mb_area_code',
				container: '#sender_mb_area_code_message',
					validators: {
						regexp: {
							regexp: /^[0-9+\s]*$/,
							message: '<?php echo PROFILE_ILLEGAL_CHARACTERS."<br />".PROFILE_AREACODE_ALLOWED_CHARACTERS_DIGITS; ?>'
						},
						stringLength: {
                        	min: 1,
                        	message: '<?php echo PROFILE_CORRECT_AREACODE_LENGTH; ?>'
                    	}
					}
            },
			profile_mobile_phone: {
				selector: '#mobile_phone',
				container: '#mobile_phone_message',
					validators: {
						regexp: {
							regexp: /^[0-9]*$/,
							message: '<?php echo PROFILE_ILLEGAL_CHARACTERS."<br />".PROFILE_ALLOWED_CHARACTERS_DIGITS; ?>'
						},
						stringLength: {
                        	min: 9,
							max:12,
                        	message: '<?php echo PROFILE_CORRECT_PHONE_LENGTH; ?>'
                    	}
					}
            },
			profile_email: {
				selector: '#email',
				container: '#email_message',
					validators: {
						notEmpty: {
                            message: '<?php echo PROFILE_FIELD_REQUIRED." ".PROFILE_EMAIL_REQUIRED; ?>'
                        },
						emailAddress: {
                        	message: '<?php echo PROFILE_EMAIL_VALID; ?>'
                    	}
					}
            },
			profile_security_question_1: {
					selector: '#security_ques_1',
					container: '#security_ques_message_1',
                    validators: {
                        notEmpty: {
                            message: '<?php echo PROFILE_SECURITY_QUESTION; ?>'
                        }
                    }
          	},
			profile_sequirity_answer_1: {
				selector: '#security_ans_1',
				container: '#security_ans_message_1',
					validators: {
						notEmpty: {
                            message: '<?php echo PROFILE_FIELD_REQUIRED." ".PROFILE_SECURITY_ANSWER; ?>'
                        },
						regexp: {
							regexp: /^[a-zA-Z0-9 .,:;'?_%\s\-\/]*$/,
							message: '<?php echo PROFILE_ILLEGAL_CHARACTERS; ?>'
						}
					}
            },
			profile_security_question_2: {
					selector: '#security_ques_2',
					container: '#security_ques_message_2',
                    validators: {
                        notEmpty: {
                            message: '<?php echo PROFILE_SECURITY_QUESTION; ?>'
                        }
                    }
          	},
			profile_sequirity_answer_2: {
				selector: '#security_ans_2',
				container: '#security_ans_message_2',
					validators: {
						notEmpty: {
                            message: '<?php echo PROFILE_FIELD_REQUIRED." ".PROFILE_SECURITY_ANSWER; ?>'
                        },
						regexp: {
							regexp: /^[a-zA-Z0-9 .,:;'?_%\s\-\/]*$/,
							message: '<?php echo PROFILE_ILLEGAL_CHARACTERS; ?>'
						}
					}
            },
			password: {
				selector: '#password',
				container: '#password_message',
					validators: {
						stringLength: {
                        	min: 8,
                        	message: '<?php echo PROFILE_PASSWORD_LENGTH; ?>'
                    	},
						regexp: {
							regexp: /^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=\S+$).{8,}$/,
							message: '<?php echo PROFILE_RIGHT_PASSWORD;?>'
						}
					}
            },
			confirmpassword: {
				selector: '#confirmpassword',
				container: '#confirmpassword_message',
					validators: {
						stringLength: {
                        	min: 8,
                        	message: '<?php echo PROFILE_PASSWORD_LENGTH; ?>'
                    	},
						identical: {
                    		field: 'password',
                    		message: '<?php echo PROFILE_PASSWORD_CONFIRM; ?>'
               			 }
					}
            },
			profile_oldpassword: {
				selector: '#oldpassword',
				container: '#oldpassword_message',
				enabled: false, // or false
					validators: {
						notEmpty: {
                            message: '<?php echo PROFILE_OLD_PASSWORD_REQUIRED; ?>'
                        },
						stringLength: {
                        	min: 8,
                        	message: '<?php echo PROFILE_OLD_PASSWORD_LENGTH; ?>'
                    	}
					}
            }


        }
		})
		.on('change', '[name="security_ques_1"]', function(e) {
			show_password(e);
			removeError('security_ques_Error_1');
			$('#Frmaddclient').bootstrapValidator('enableFieldValidators', 'profile_oldpassword', true);
		})
		.on('change', '[name="security_ques_2"]', function(e) {
			show_password(e);
			removeError('security_ques_Error_1');
			$('#Frmaddclient').bootstrapValidator('enableFieldValidators', 'profile_oldpassword', true);
		})
		.on('change', '[name="email"]', function(e) {
			show_password(e);
			//removeError('email_Error');
			$('#Frmaddclient').bootstrapValidator('enableFieldValidators', 'profile_oldpassword', true);
		})

		.on('change', '[name="country"]', function() {
			var countryid = $(this).val();
			if(countryid == '<?php echo UNITED_STATE_ID; ?>')
			{
				$('#pstlbl').html("<?php echo COMMON_US_ZIPCODE; ?><span class='color-red'>*</span>");
			}else{
				$('#pstlbl').html("<?php echo COMMON_ZIPCODE; ?><span class='color-red'>*</span>");
			}
			var anchorHREF = "<?php echo DIR_HTTP_RELATED.'countrylist.php?'; ?>";

			$.ajax({
			   type: "POST",
			   url: anchorHREF,
			   data: 'id='+countryid,
			   success: function(msg){
				   $('#sender_area_code').val(msg);
				   $('#sender_mb_area_code').val(msg);
				   $('#Frmaddclient').bootstrapValidator('updateStatus', 'profile_areacode_phone', 'NOT_VALIDATED')
				.bootstrapValidator('validateField', 'profile_areacode_phone');
					$('#Frmaddclient').bootstrapValidator('updateStatus', 'profile_areacode_mobile', 'NOT_VALIDATED')
				.bootstrapValidator('validateField', 'profile_areacode_mobile');
			   }
			}),
			$('#Frmaddclient').data('bootstrapValidator').resetField(
			"profile_suburb",true);
			$('#Frmaddclient').data('bootstrapValidator').resetField(
			"profile_state",true);
			$('#Frmaddclient').data('bootstrapValidator').resetField("profile_postcode",true);
			$('#Frmaddclient').data('bootstrapValidator').resetField("profile_fsuburb",true);

		})
		.on('change', '[name="suburb"]', function() {
			$("#fsuburb").val($("#suburb").val());

			var selected_id = $("#suburb").val();

			$("#fsuburb").val(selected_id);
			var postcodedatawithid = selected_id.split(" ");//find the postcode id for pickup
			var maximum_index_of_array = postcodedatawithid.length;

			var suburb ='';
			var removeValFromIndex = new Array(maximum_index_of_array-2,maximum_index_of_array-1);
			var suburbArr = $.grep(postcodedatawithid, 	function(n, i) {
			return $.inArray(i, removeValFromIndex) ==-1;
			});
			//alert(maximum_index_of_array);
			for (i = 0; i < suburbArr.length; ++i) {
				if(i == suburbArr.length)
				{
					suburb += suburbArr[i];
				}else{
					suburb += suburbArr[i]+" ";
				}
			}

			if(maximum_index_of_array>=3){
			$("#suburb").val(suburb);

			$("#state").val(postcodedatawithid[maximum_index_of_array-2]);
			$("#postcode").val(postcodedatawithid[maximum_index_of_array-1]);
			}
			$('#Frmaddclient').bootstrapValidator('revalidateField', 'profile_fsuburb');
			$('#Frmaddclient').bootstrapValidator('enableFieldValidators', 'profile_suburb',false);
		})
		.on('success.form.bv', function(e) {
			var succeed = false;
			var registered_country = $("#country").val();

			if(registered_country == '<?php echo UNITED_STATE_ID; ?>')
			{
				e.preventDefault();

				run_waitMe('win8_linear');
				$.ajax({
				  url: "<?php echo DIR_HTTP_RELATED."address_validation.php"; ?>",
				  dataType: "json",
				  method: "post",
				  data: {
					receiver_suburb:$('#suburb').val(),
					receiver_state_code:$('#register_state_code').val(),
					receiver_postcode: $('#postcode').val(),
					//addType: 'Delivery',
				  },
				  success: function( data ) {
				   // alert(data[0]);
					if(data == 1)
					{
						succeed = true;
						return successfullydone();

					}else{
						succeed = false;
						$('.containerBlock > form').waitMe('hide');
						$("#address_display").html(data);
						$("#addressRegisterError").modal('show');
						return ntest();
					}

				  }
				 });
				return false;
			}
		})
});
function removeError(a)
{
	//alert(a);
	$("#"+a).slideUp(400);
}
<!--=== 	Navigate to Additional Details	===-->

function AdditionalDetails(ad)
{
	var url = '<?php echo show_page_link(FILE_ADDITIONAL_DETAILS);?>';
	$(location).attr('href',url);
}

$(function(){

    $(document).on('click', '#ajax_index_listOfOptions div', function(){
        var country = $("#country").val();

		if(country == '<?php echo UNITED_STATE_ID; ?>')
		{
			var registered_state = $("#state").val();
			var statewithcode = registered_state.split(" ");
			var maximum_state_of_array = statewithcode.length;


			var state ='';

			for (i = 0; i < (statewithcode.length-1); ++i) {
				if(i == statewithcode.length)
				{
					state += statewithcode[i];
				}else{
					state += statewithcode[i]+" ";
				}

			}

			$("#state").val(trim(state));
			$("#register_state_code").val(trim(statewithcode[maximum_state_of_array-1]));
			$('#Frmaddclient').bootstrapValidator('revalidateField', 'profile_state');
			$("#btn_save").prop("disabled", false);
		}

    });
})


/*	***	Function shows old password field upon password chnage	***	*/
function show_password(ObjForm)
{

 document.getElementById("existing_pass_show").style.display ='block';
 document.getElementById("valid_pass").value ='invalid';
 $('#Frmaddclient').bootstrapValidator('enableFieldValidators', 'profile_oldpassword', true);
}
/*	***	Function shows password change after checkbox is clicked	***	*/
function change_password() {
  // Get the checkbox
  var checkBox = document.getElementById("change_pass");
  // Get the output text
  var text = document.getElementById("new_pass_show");

  // If the checkbox is checked, display the output text
  if (checkBox.checked == true){
    new_pass_show.style.display = "block";
  } else {
    new_pass_show.style.display = "none";
  }
}
function resetForm()
{

	$("#Frmaddclient").data('bootstrapValidator').resetForm();
	$("#suburb").attr("readonly", false);
	//$("#state").attr("readonly", false);
	//$("#postcode").attr("readonly", false);
}
function historyBack(){
	$('#Frmaddclient').bootstrapValidator('disableSubmitButtons', true);
	window.history.back();
	//disableSubmitButtons(true);

}
if($("#changed_cntry").val() == '13')
{
	$('#selected_flag').val('australia');
}else{
	$('#selected_flag').val('international');
}
$('#closemodal').click(function(e){
	$('#addressRegisterError').modal('hide');
	e.preventDefault();
});
/*
if($("#changed_cntry").val() == '235')
{

$('#Frmaddclient').bootstrapValidator('enableFieldValidators', 'profile_postcode', true, 'zipCode');
} */
if($("#country").val() == '13')
{
	$("#state_reg").attr("readonly", true);
	$("#postcode_reg").attr("readonly", true);
}
function successfullydone(){

	$('#Frmaddclient').bootstrapValidator('defaultSubmit');
	return true;
}

function ntest(){

	return false;

}
function addresstestClick(state,stateCode,postcode,city)
{
	$('#state').val(state);
	$('#register_state_code').val(stateCode);
	$('#postcode').val(postcode);
	$('#suburb').val(city);
	$('#addressRegisterError').modal('hide');
	$("#btn_save").prop("disabled", false);
	//return false;
}
</script>
