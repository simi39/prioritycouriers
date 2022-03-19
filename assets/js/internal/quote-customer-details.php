<script type="text/javascript">
	$(document).ready(function() {
		$("#m_trash_all").click(function () { alert("this");
        	$(".checkBoxClass").prop('checked', $(this).prop('checked'));
    	});
		$('#quote_customer_details')
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
                // alert("hi");

            // Place the icon right after the label
            $icon.insertAfter($label);
        })
        .bootstrapValidator({
			feedbackIcons: {
				valid: 'glyphicon glyphicon-ok',
				invalid: 'glyphicon glyphicon-remove',
				validating: 'glyphicon glyphicon-refresh'
			},
			submitHandler: function(validator, form, submitButton) { 
                // Do nothing
				
			},
			fields: {
				quote_customer_details_firstname: {
				selector: '#firstname',
				container: '#firstname_message',
					validators: {
						notEmpty: {
                            message: '<?php echo QUOTE_CUSTOMER_DETAILS_FIELD_REQUIRED." ".QUOTE_CUSTOMER_DETAILS_FIRSTNAME_REQUIRED; ?>'
                        },
						regexp: {
							regexp: /^[a-zA-Z'\s]*$/, //lowercase, upercase, space
							message: '<?php echo QUOTE_CUSTOMER_DETAILS_ILLEGAL_CHARACTERS."<br />".QUOTE_CUSTOMER_DETAILS_ALLOWED_CHARACTERS_NAMES; ?>'
						}
					}
				},
				quote_customer_details_lastname: {
				selector: '#lastname',
				container: '#lastname_message',
					validators: {
						notEmpty: {
                            message: '<?php echo QUOTE_CUSTOMER_DETAILS_FIELD_REQUIRED." ".QUOTE_CUSTOMER_DETAILS_LASTNAME_REQUIRED; ?>'
                        },
						regexp: {
							regexp: /^[a-zA-Z'\s]*$/, //lowercase, upercase, apostrophe, space
							message: '<?php echo QUOTE_CUSTOMER_DETAILS_ILLEGAL_CHARACTERS."<br />".QUOTE_CUSTOMER_DETAILS_ALLOWED_CHARACTERS_NAMES; ?>'
						}
					}
				},
				quote_customer_details_address1: {
				selector: '#address1',
				container: '#address1_message',
					validators: {
						notEmpty: {
                            message: '<?php echo QUOTE_CUSTOMER_DETAILS_FIELD_REQUIRED." ".QUOTE_CUSTOMER_DETAILS_ADDRESS1_REQUIRED; ?>'
                        },
						regexp: {
							regexp: /^[a-zA-Z0-9 .,:;'?_%\s\-\/]*$/,
							message: '<?php echo QUOTE_CUSTOMER_DETAILS_ILLEGAL_CHARACTERS; ?>'
						}
					}
				},
				quote_customer_details_address2: {
				selector: '#address2',
				container: '#address2_message',
					validators: {
						regexp: {
							regexp: /^[a-zA-Z0-9 .,:;'?_%\s\-\/]*$/,
							message: '<?php echo QUOTE_CUSTOMER_DETAILS_ILLEGAL_CHARACTERS; ?>'
						}
					}
				},
				quote_customer_details_address3: {
					selector: '#address3',
					container: '#address3_message',
						validators: {
							regexp: {
								regexp: /^[a-zA-Z0-9 .,:;'?_%\s\-\/]*$/,
								message: '<?php echo QUOTE_CUSTOMER_DETAILS_ILLEGAL_CHARACTERS; ?>'
							}
						}
				},
				quote_customer_details_country: {
					selector: '#country',
					container: '#country_message',
                    validators: {
                        notEmpty: {
                            message: '<?php echo PROFILE_COUNTRY_REQUIRED; ?>'
                        }
                    }
				},
				quote_customer_details_suburb: {
				selector: '#suburb',
				container: '#suburb_message',
					validators: {
						notEmpty: {
                            message: '<?php echo QUOTE_CUSTOMER_DETAILS_FIELD_REQUIRED." ".QUOTE_CUSTOMER_DETAILS_SUBURB_REQUIRED; ?>'
                        }
					}
				},
				quote_customer_details_fsuburb:{
				 excluded: false,    // Don't ignore me
				 selector: '#fsuburb',
				 container: '#suburb_message',
				 validators: {
					/*notEmpty: {
                            message: '<?php echo QUOTE_CUSTOMER_DETAILS_FIELD_REQUIRED." ".QUOTE_CUSTOMER_DETAILS_SUBURB_REQUIRED; ?>'
                        },*/
					remote: {
						url: '<?php echo DIR_HTTP_RELATED."tms_index.php"; ?>',
						data: function(validator) { 
							//alert($('#fsuburb').val()+$('#selected_flag').val());
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
									message: '<?php echo QUOTE_CUSTOMER_DETAILS_FIELD_REQUIRED." ".QUOTE_CUSTOMER_DETAILS_SUBURB_REQUIRED; ?>'
								}
							}*/
							
							if(value.search(/^[a-zA-Z0-9 '%\s\-\/]*$/) < 0 && $('#changed_cntry').val()=='<?php echo AUSTRALIA_ID; ?>') {
								return {
									valid: false,
									message: '<?php echo QUOTE_CUSTOMER_DETAILS_ILLEGAL_CHARACTERS."<br />"; ?>'
								}
                            }else if(value.search(/^[a-zA-Z '%\s\-\/]*$/) < 0 && $('#changed_cntry').val()!='<?php echo AUSTRALIA_ID; ?>'){
								return {
									valid: false,
									message: '<?php echo QUOTE_CUSTOMER_DETAILS_ILLEGAL_CHARACTERS."<br />"; ?>'
								}
							}
							return true;
							
						}
					}
				 }
				},
				quote_customer_details_state: {
					selector: '#state',
					container: '#state_message',
						validators: {
							notEmpty: {
								message: '<?php echo QUOTE_CUSTOMER_DETAILS_FIELD_REQUIRED." ".QUOTE_CUSTOMER_DETAILS_STATE_REQUIRED; ?>'
							},
							regexp: {
								regexp: /^[a-zA-Z0-9 .,:;'?_%\s\-\/]*$/,
								message: '<?php echo QUOTE_CUSTOMER_DETAILS_ILLEGAL_CHARACTERS; ?>'
							},
							remote: {
								url: '<?php echo DIR_HTTP_RELATED."inter_state_val.php"; ?>',
								data: function(validator) { 
									return {
									letters: validator.getFieldElements('quote_customer_detail_state').val(),
									chkstate:true,
									flag:validator.getFieldElements('selected_flag').val(),
									countryid:validator.getFieldElements('changed_cntry').val(),
								
									};
								},
								message: '<?php echo PROFILE_STATE_NOT_FOUND; ?>'
							}
						}
				},
				quote_customer_details_postcode: {
					selector: '#postcode',
					container: '#postcode_message',
						validators: {
							notEmpty: {
								message: '<?php echo QUOTE_CUSTOMER_DETAILS_FIELD_REQUIRED." ".QUOTE_CUSTOMER_DETAILS_POSTCODE_REQUIRED; ?>'
							},
							callback: {
								callback: function(value, validator, $field) {
									if (value === '') {
										return true;
									}	
								if (value.search(/^[a-zA-Z0-9 .,:;'_\s\-\/]*$/) < 0) {
									return {
										valid: false,
										message: '<?php echo QUOTE_CUSTOMER_DETAILS_ILLEGAL_CHARACTERS."<br />".QUOTE_CUSTOMER_DETAILS_ALLOWED_CHARACTERS_DIGITS; ?>'
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
										message: '<?php echo QUOTE_CUSTOMER_DETAILS_POSTCODE_CORRECT; ?>'
										};
									}

									}
								return true;
							}
						}
						}
				},				
				quote_customer_detail_phone: {
				selector: '#contactNo',
				container: '#phone_message',
					validators: {
						notEmpty: {
                            message: '<?php echo QUOTE_CUSTOMER_DETAILS_FIELD_REQUIRED." ".QUOTE_CUSTOMER_DETAILS_CONTACTNO_REQUIRED; ?>'
                        },
						regexp: {
							regexp: /^[0-9]*$/,
							message: '<?php echo QUOTE_CUSTOMER_DETAILS_ILLEGAL_CHARACTERS."<br />".QUOTE_CUSTOMER_DETAILS_ALLOWED_CHARACTERS_DIGITS; ?>'
						},
						stringLength: {
                        	min: 10,
							max:12,
                        	message: '<?php echo QUOTE_CUSTOMER_DETAILS_CORRECT_PHONE_LENGTH; ?>'
                    	}
					}
				},
				quote_customer_mobile_phone: {
				selector: '#mobileNo',
				container: '#mobile_message',
					validators: {
						notEmpty: {
                            message: '<?php echo QUOTE_CUSTOMER_DETAILS_FIELD_REQUIRED." ".QUOTE_CUSTOMER_DETAILS_CONTACTNO_REQUIRED; ?>'
                        },
						regexp: {
							regexp: /^[0-9]*$/,
							message: '<?php echo QUOTE_CUSTOMER_DETAILS_ILLEGAL_CHARACTERS."<br />".QUOTE_CUSTOMER_DETAILS_ALLOWED_CHARACTERS_DIGITS; ?>'
						},
						stringLength: {
                        	min: 10,
							max:12,
                        	message: '<?php echo QUOTE_CUSTOMER_DETAILS_CORRECT_PHONE_LENGTH; ?>'
                    	}
					}
				},
				quote_customer_account_number: {
				selector: '#account_number',
				container: '#account_number_message',
					validators: {
						notEmpty: {
                            message: '<?php echo QUOTE_CUSTOMER_DETAILS_FIELD_REQUIRED." ".QUOTE_CUSTOMER_DETAILS_ACCOUNTNO_REQUIRED; ?>'
                        }					
					}
				},
				quote_customer_detail_email: {
				selector: '#email',
				container: '#email_message',
					validators: {
						emailAddress: {
                        	message: '<?php echo QUOTE_CUSTOMER_DETAILS_EMAIL_VALID; ?>'
                    	}
					}
				},
			}

		})
		.on('change', '[name="suburb"]', function() {
			
			$('#quote_customer_details').bootstrapValidator('revalidateField', 'quote_customer_details_fsuburb');
			$('#quote_customer_details').bootstrapValidator('enableFieldValidators', 'quote_customer_details_suburb',false);
		})

		.on('success.form.bv', function(e) {
			//e.preventDefault();
			return true;
		})

	});
	function removeError(a)
	{
		//alert(a);
		$("#"+a).slideUp(400);
	}
$(document).ready(function () {
    
});
</script>