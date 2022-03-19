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
		$("#btn_submit").removeAttr('disabled');
		$("#reCaptcha_error_message").css("display", "none");
	  //console.log(response);
	}
  });
  
};
<!--	***		Bootstrap validator	***		-->
$(document).ready(function() {
    $('#registration')
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
        fields: {
		    profile_firstname: {
				selector: '#firstname_reg',
				container: '#firstname_reg_message',
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
				selector: '#lastname_reg',
				container: '#lastname_reg_message',
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
				selector: '#company_reg',
				container: '#company_reg_message',
					validators: {
						regexp: {
							regexp: /^[a-zA-Z0-9 .,:;'?_%\s\-\/]*$/,
							message: '<?php echo PROFILE_ILLEGAL_CHARACTERS; ?>'
						}
					}
            },
			profile_address1: {
				selector: '#address1_reg',
				container: '#address1_reg_message',
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
				selector: '#address2_reg',
				container: '#address2_reg_message',
					validators: {
						regexp: {
							regexp: /^[a-zA-Z0-9 .,:;'?_%\s\-\/]*$/,
							message: '<?php echo PROFILE_ILLEGAL_CHARACTERS; ?>'
						}
					}
            },
			profile_address3: {
				selector: '#address3_reg',
				container: '#address3_reg_message',
					validators: {
						regexp: {
							regexp: /^[a-zA-Z0-9 .,:;'?_%\s\-\/]*$/,
							message: '<?php echo PROFILE_ILLEGAL_CHARACTERS; ?>'
						}
					}
            },
			profile_country: {
					selector: '#country',
					container: '#changed_cntry_message',
                    validators: {
                        notEmpty: {
                            message: '<?php echo PROFILE_COUNTRY_REQUIRED; ?>'
                        }
                    }
          	},
			profile_suburb: {
				selector: '#suburb_reg',
				container: '#suburb_reg_message',
					validators: {
						notEmpty: {
                            message: '<?php echo PROFILE_FIELD_REQUIRED." ".PROFILE_SUBURB_REQUIRED; ?>'
                        },
						regexp: {
							regexp: /^[a-zA-Z0-9 .,:;'?_%\s\-\/]*$/,
							message: '<?php echo PROFILE_ILLEGAL_CHARACTERS; ?>'
						}/*,
						remote: {
							url: '<?php echo DIR_HTTP_RELATED."tms_index.php"; ?>',
							data: function(validator) { 
								return {
								chksuburb:true,
								letters: validator.getFieldElements('profile_suburb').val()
								};
							},
							message: '<?php echo SUBURB_NOT_FOUND; ?>'
						}
						*/
					}
            },
			profile_fsuburb:{
				 excluded: false,    // Don't ignore me
				 selector: '#fsuburb',
				 container: '#suburb_reg_message',
				 validators: {
					notEmpty: {
                            message: '<?php echo PROFILE_FIELD_REQUIRED." ".PROFILE_SUBURB_REQUIRED; ?>'
                        },
					/*regexp: {
						regexp: /^[a-zA-Z0-9 .,:;'?_%\s\-\/]*$/,
						message: '<?php echo PROFILE_ILLEGAL_CHARACTERS; ?>'
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
							if(value == "")
							{
								return {
									valid: false,
									message: '<?php echo PROFILE_FIELD_REQUIRED." ".PROFILE_SUBURB_REQUIRED; ?>'
								}
							}
							
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
				selector: '#state_reg',
				container: '#state_reg_message',
					validators: {
						notEmpty: {
                            message: '<?php echo PROFILE_FIELD_REQUIRED." ".PROFILE_SUBURB_REQUIRED; ?>'
                        },
						regexp: {
							regexp: /^[a-zA-Z0-9 '\s\-\/]*$/,
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
				selector: '#postcode_reg',
				container: '#postcode_reg_message',
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
							regexp: /^[0-9+-\s]*$/,
							message: '<?php echo PROFILE_ILLEGAL_CHARACTERS."<br />".PROFILE_AREACODE_ALLOWED_CHARACTERS_DIGITS; ?>'
						},
						stringLength: {
                        	min: 1,
                        	message: '<?php echo PROFILE_CORRECT_AREACODE_LENGTH; ?>'
                    	}
					}
            },
			profile_sender_phone: {
				selector: '#phone_reg',
				container: '#phone_reg_message',
					validators: {
						notEmpty: {
                            message: '<?php echo PROFILE_FIELD_REQUIRED." ".PROFILE_CONTACTNO_REQUIRED; ?>'
                        },
						regexp: {
							regexp: /^[0-9]*$/,
							message: '<?php echo PROFILE_ILLEGAL_CHARACTERS."<br />".PROFILE_ALLOWED_CHARACTERS_DIGITS; ?>'
						},
						stringLength: {
                        	min: 7,
                        	message: '<?php echo PROFILE_CORRECT_PHONE_LENGTH; ?>'
                    	}
					}
            },
			profile_areacode_mobile: {
				selector: '#sender_mb_area_code',
				container: '#sender_mb_area_code_message',
					validators: {
						regexp: {
							regexp: /^[0-9+-\s]*$/,
							message: '<?php echo PROFILE_ILLEGAL_CHARACTERS."<br />".PROFILE_AREACODE_ALLOWED_CHARACTERS_DIGITS; ?>'
						},
						stringLength: {
                        	min: 1,
                        	message: '<?php echo PROFILE_CORRECT_AREACODE_LENGTH; ?>'
                    	}
					}
            },
			profile_mobile_phone: {
				selector: '#mobile_phone_reg',
				container: '#mobile_phone_reg_message',
					validators: {
						regexp: {
							regexp: /^[0-9]*$/,
							message: '<?php echo PROFILE_ILLEGAL_CHARACTERS."<br />".PROFILE_ALLOWED_CHARACTERS_DIGITS; ?>'
						},
						stringLength: {
                        	min: 7,
                        	message: '<?php echo PROFILE_CORRECT_PHONE_LENGTH; ?>'
                    	}
					}
            },
			profile_email: {
				selector: '#email_reg',
				container: '#email_reg_message',
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
					selector: '#security_ques_reg_1',
					container: '#security_ques_reg_message_1',
                    validators: {
                        notEmpty: {
                            message: '<?php echo PROFILE_SECURITY_QUESTION; ?>'
                        }
                    }
          	},
			profile_sequirity_answer_1: {
				selector: '#security_ans_reg_1',
				container: '#security_ans_reg_message_1',
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
					selector: '#security_ques_reg_2',
					container: '#security_ques_reg_message_2',
                    validators: {
                        notEmpty: {
                            message: '<?php echo PROFILE_SECURITY_QUESTION; ?>'
                        }
                    }
          	},
			profile_sequirity_answer_2: {
				selector: '#security_ans_reg_2',
				container: '#security_ans_reg_message_2',
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
				selector: '#password_reg',
				container: '#password_reg_message',
					validators: {
						notEmpty: {
                            message: '<?php echo PROFILE_FIELD_REQUIRED." ".PROFILE_PASSWORD_REQUIRED; ?>'
                        },
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
				selector: '#confirmpassword_reg',
				container: '#confirmpassword_reg_message',
					validators: {
						notEmpty: {
                            message: '<?php echo PROFILE_FIELD_REQUIRED." ".PROFILE_PASSWORD_CONFIRM_REQUIRED; ?>'
                        },
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
			termsandconditon: {
				selector: '#terms_cond',
				container: '#terms_n_cond_message',
				validators: {
					 notEmpty: {
                        message: '<?php echo TERMS_AND_CONDITION; ?>'
                     }
				}
			}
			
        }
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
				   $('#registration').bootstrapValidator('updateStatus', 'profile_areacode_phone', 'NOT_VALIDATED')
				.bootstrapValidator('validateField', 'profile_areacode_phone');
					$('#registration').bootstrapValidator('updateStatus', 'profile_areacode_mobile', 'NOT_VALIDATED')
				.bootstrapValidator('validateField', 'profile_areacode_mobile');
			   }	
			}),
			$('#registration').data('bootstrapValidator').resetField(
			"profile_suburb",true);
			$('#registration').data('bootstrapValidator').resetField(
			"profile_state",true);
			$('#registration').data('bootstrapValidator').resetField("profile_postcode",true);
			$('#registration').data('bootstrapValidator').resetField("profile_fsuburb",true);
			
		})
		.on('change', '[name="suburb"]', function() {
			$("#fsuburb").val($("#suburb_reg").val());
			
			var selected_id = $("#suburb_reg").val();
		
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
			$("#suburb_reg").val(suburb);
			
			$("#state_reg").val(postcodedatawithid[maximum_index_of_array-2]);
			$("#postcode_reg").val(postcodedatawithid[maximum_index_of_array-1]);
			}
			$('#registration').bootstrapValidator('revalidateField', 'profile_fsuburb');
			$('#registration').bootstrapValidator('enableFieldValidators', 'profile_suburb',false);
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
					receiver_suburb:$('#suburb_reg').val(),
					receiver_state_code:$('#register_state_code').val(),
					receiver_postcode: $('#postcode_reg').val(),
				  },
				  success: function( data ) {
				    
					if(data == 1)
					{
						succeed = true;
						//return successfullydone();
						if($("#gcaptcha").val() == "")
						{
							$("#reCaptcha_error_message").css("display", "block");
							return false;
						}else{
							$('.containerBlock > form').waitMe('hide');
							$("#reCaptcha_error_message").css("display", "none");
							$('#confirmBox').modal('show');
							return false;
						}
						
					}else{
						succeed = false;
						$('.containerBlock > form').waitMe('hide');
						$("#address_display").html(data);
						$("#addressRegisterError").modal('show');
						return addressError();
					}
					
				  }
				});
				return false;
			}else{
				
				
				
				if($("#gcaptcha").val() == "")
				{
					$("#reCaptcha_error_message").css("display", "block");
					return false;
				}else{
					run_waitMe('win8_linear');
						
					$('.containerBlock > form').waitMe('hide');
					$("#reCaptcha_error_message").css("display", "none");
					$('#confirmBox').modal('show');
					return false;
					
				}
			}
			
		})
});
/*	***	Automatically brings up the list of available suburbs	***	*/
var country_val = 13 ;

$("#suburb_reg").keyup( 
function(event){
	var current_country = $("#changed_cntry").val();
	
		if(current_country == <?php echo AUSTRALIA_ID; ?>)
		{
			$('#selected_flag').val('australia');
			ajax_showOptions(this,'admin_search',event,"<?php echo DIR_HTTP_RELATED.'tms_index.php';?>",'ajax_index_listOfOptions');
		}else{
			$('#selected_flag').val('international');
		}
	}
);
$(function(){
    $(document).on('click', '#ajax_index_listOfOptions div', function(){
	var country_val = $("#country").val();
	console.log("conuntry val:"+country_val);
	if(country_val == <?php echo AUSTRALIA_ID; ?>)
	{
		var selected_id = jQuery(this).text();
		
		$("#fsuburb").val(selected_id);
		var postcodedatawithid = selected_id.split(" ");//find the postcode id for pickup
		var maximum_index_of_array = postcodedatawithid.length;
		
		var suburb ='';
		var removeValFromIndex = new Array(maximum_index_of_array-2,maximum_index_of_array-1);
		var suburbArr = $.grep(postcodedatawithid, function(n, i) { 
			return $.inArray(i, removeValFromIndex) ==-1;
		});
		//alert("length array"+suburbArr.length);
		for (i = 0; i < suburbArr.length; ++i) {
			if(i == suburbArr.length)
			{
				suburb += suburbArr[i];
			}else{
				suburb += suburbArr[i]+" ";
			}
		}
		$("#suburb_reg").val(suburb);
		
		$("#state_reg").val(postcodedatawithid[maximum_index_of_array-2]);
		$("#postcode_reg").val(postcodedatawithid[maximum_index_of_array-1]);
		$('#registration').bootstrapValidator('updateStatus', 'profile_state', 'NOT_VALIDATED')
		.bootstrapValidator('validateField', 'profile_state');
		$('#registration').bootstrapValidator('updateStatus', 'profile_postcode', 'NOT_VALIDATED')
			.bootstrapValidator('validateField', 'profile_postcode');
		//$("#suburb_reg").attr('readonly','readonly');
		$("#state_reg").attr('readonly','readonly');
		$("#postcode_reg").attr('readonly','readonly');
		$('#registration').bootstrapValidator('revalidateField', 'profile_fsuburb');
	} 
	
});
});

$('#p').click(function(e){
	$("#finalval").val("success");
	$('#registration').bootstrapValidator('defaultSubmit');
	e.preventDefault();
})
if($("#country").val() == '<?php echo AUSTRALIA_ID; ?>')
{
	$("#state_reg").attr("readonly", true);
	$("#postcode_reg").attr("readonly", true);
}	
if($("#changed_cntry").val() == '13')
{
	$('#selected_flag').val('australia');
}else{
	$('#selected_flag').val('international');
}
$(function(){
    $(document).on('click', '#ajax_index_listOfOptions div', function(){
        var country = $("#country").val();
		
		if(country == '<?php echo UNITED_STATE_ID; ?>')
		{
			var registered_state = $("#state_reg").val();
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
			
			$("#state_reg").val(trim(state));
			$("#register_state_code").val(trim(statewithcode[maximum_state_of_array-1]));
			$('#registration').bootstrapValidator('revalidateField', 'profile_state');
			$("#btn_submit").prop("disabled", false);
		}
		
    });
})
function addresstestClick(state,stateCode,postcode,city)
{
	$('#state_reg').val(state);
	$('#register_state_code').val(stateCode);
	$('#postcode_reg').val(postcode);
	$('#suburb_reg').val(city);
	$('#addressRegisterError').modal('hide');
	$("#btn_submit").prop("disabled", false);
	//return false;
}
function addressError(){
	return false;
}
function removeError(id)
{
	$("#"+id).slideUp(400);
}
$('#closemodal').click(function(e){ 
	$('#addressRegisterError').modal('hide');
	e.preventDefault();
});
/*	***	Ajax Loading/Spinner script	***	*/
function run_waitMe(effect){ 
	$('.containerBlock > form').waitMe({
		effect: effect,
		text: 'Please wait...',
		bg: 'rgba(255,255,255,0.9)',
		color:'#72c02c',
		sizeW:'',
		sizeH:'30px',
		source: 'img.svg'
	});
	return false;
	$("#finalval").val("success");
}

</script>