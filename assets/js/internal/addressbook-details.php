<?php
$session_data = json_decode($_SESSION['Thesessiondata']['_sess_login_userdetails'],true);
$userid = $session_data['user_id'];
?>
<script type="text/javascript">
function confirmAction(){ 
	doConfirm(function yes(){
		
		var valid = 'add';
		$("#Save").val("Add");
		$('#addressbook_detail').bootstrapValidator('defaultSubmit');
		
		//document.bookingrecords.submit();
		return true;
	}, 
	function no()
	{
		
		var valid = 'edit';
		var firstname = $("#firstname").val();
		var lastname = $("#lastname").val();
			$.ajax({
			  url: '<?php echo DIR_HTTP_RELATED."ajax_duplicate_address.php"; ?>',
			  type: 'post',
			  data: {'userid': '<?php echo $userid; ?>','firstname':firstname,'lastname':lastname},
			  success: function(data, status) {  
				
				$("#duplicateAdd").html(data);
				$("#duplicateAddressBox").modal('show');
				return true;
			  },
			  error: function(xhr, desc, err) {
				console.log(xhr);
				console.log("Details: " + desc + "\nError:" + err);
			  }
			  
			}); // end ajax call
		
		
	});
}
function doConfirm(yesFn, noFn)
{
	
	$('#addressBox').modal('show');
	
	var addressBox = $("#addressBox");
	
    addressBox.find("#yes,#no").unbind().click(function()
    {
        //addressBox.hide();
		//$('#addressBox').modal('hide');
    });
    addressBox.find("#yes").click(yesFn);
    addressBox.find("#no").click(noFn);
    addressBox.show();
}
//return false;
<!--	***		Bootstrap validator	***		-->

$(document).ready(function() {
	if($("#Add").val() != undefined && $("#Add").val() =="Add")
	{
		//alert($("#Add").val());
		$("#addressbook_detail").submit();
		return false;
		
	}
	
	$('#addressbook_detail')
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
				valid: 'glyphicon',
				invalid: 'glyphicon',
				validating: 'glyphicon glyphicon-refresh'
			},
			submitHandler: function(validator, form, submitButton) { 
                // Do nothing
				$.ajax({
					type: $(form).attr('method'),
					url: '<?php echo DIR_HTTP_RELATED."ajax_edit_address.php"; ?>',
					data: $(form).serialize(),
					success: function (data, status) {
						$(this).modal('hide');
					}
				});
			},
			fields: {
				addressbook_detail_firstname: {
				selector: '#firstname',
				container: '#firstname_message',
					validators: {
						notEmpty: {
                            message: '<?php echo ADDRESSBOOK_DETAILS_FIELD_REQUIRED." ".ADDRESSBOOK_DETAILS_FIRSTNAME_REQUIRED; ?>'
                        },
						regexp: {
							regexp: /^[a-zA-Z'\s]*$/, //lowercase, upercase, space
							message: '<?php echo ADDRESSBOOK_DETAILS_ILLEGAL_CHARACTERS."<br />".ADDRESSBOOK_DETAILS_ALLOWED_CHARACTERS_NAMES; ?>'
						}
					}
				},
				addressbook_detail_lastname: {
				selector: '#lastname',
				container: '#lastname_message',
					validators: {
						notEmpty: {
                            message: '<?php echo ADDRESSBOOK_DETAILS_FIELD_REQUIRED." ".ADDRESSBOOK_DETAILS_LASTNAME_REQUIRED; ?>'
                        },
						regexp: {
							regexp: /^[a-zA-Z'\s]*$/, //lowercase, upercase, apostrophe, space
							message: '<?php echo ADDRESSBOOK_DETAILS_ILLEGAL_CHARACTERS."<br />".ADDRESSBOOK_DETAILS_ALLOWED_CHARACTERS_NAMES; ?>'
						}
					}
				},
				addressbook_detail_company: {
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
											message: '<?php echo ADDRESSBOOK_DETAILS_ILLEGAL_CHARACTERS; ?>'
										}
									}
								}
								return true;
							}
						}
					}
				},
				addressbook_detail_address1: {
				selector: '#address1',
				container: '#address1_message',
					validators: {
						notEmpty: {
                            message: '<?php echo ADDRESSBOOK_DETAILS_FIELD_REQUIRED." ".ADDRESSBOOK_DETAILS_ADDRESS1_REQUIRED; ?>'
                        },
						regexp: {
							regexp: /^[a-zA-Z0-9 .,:;'?_%\s\-\/]*$/,
							message: '<?php echo ADDRESSBOOK_DETAILS_ILLEGAL_CHARACTERS; ?>'
						}
					}
				},
				addressbook_detail_address2: {
				selector: '#address2',
				container: '#address2_message',
					validators: {
						regexp: {
							regexp: /^[a-zA-Z0-9 .,:;'?_%\s\-\/]*$/,
							message: '<?php echo ADDRESSBOOK_DETAILS_ILLEGAL_CHARACTERS; ?>'
						}
					}
				},
				addressbook_detail_address3: {
					selector: '#address3',
					container: '#address3_message',
						validators: {
							regexp: {
								regexp: /^[a-zA-Z0-9 .,:;'?_%\s\-\/]*$/,
								message: '<?php echo ADDRESSBOOK_DETAILS_ILLEGAL_CHARACTERS; ?>'
							}
						}
				},
				addressbook_detail_country: {
					selector: '#country',
					container: '#country_message',
                    validators: {
                        notEmpty: {
                            message: '<?php echo PROFILE_COUNTRY_REQUIRED; ?>'
                        }
                    }
				},
				addressbook_detail_suburb: {
				selector: '#suburb',
				container: '#suburb_message',
					validators: {
						notEmpty: {
                            message: '<?php echo ADDRESSBOOK_DETAILS_FIELD_REQUIRED." ".ADDRESSBOOK_DETAILS_SUBURB_REQUIRED; ?>'
                        }
						/*,
						regexp: {
							regexp: /^[a-zA-Z0-9 .,:;'?_%\s\-\/]*$/,
							message: '<?php echo ADDRESSBOOK_DETAILS_ILLEGAL_CHARACTERS; ?>'
						} */
					}
				},
				addressbook_detail_fsuburb:{
				 excluded: false,    // Don't ignore me
				 selector: '#fsuburb',
				 container: '#suburb_message',
				 validators: {
					/*notEmpty: {
                            message: '<?php echo ADDRESSBOOK_DETAILS_FIELD_REQUIRED." ".ADDRESSBOOK_DETAILS_SUBURB_REQUIRED; ?>'
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
									message: '<?php echo ADDRESSBOOK_DETAILS_FIELD_REQUIRED." ".ADDRESSBOOK_DETAILS_SUBURB_REQUIRED; ?>'
								}
							}*/
							
							if(value.search(/^[a-zA-Z0-9 '%\s\-\/]*$/) < 0 && $('#changed_cntry').val()=='<?php echo AUSTRALIA_ID; ?>') {
								return {
									valid: false,
									message: '<?php echo ADDRESSBOOK_DETAILS_ILLEGAL_CHARACTERS."<br />"; ?>'
								}
                            }else if(value.search(/^[a-zA-Z '%\s\-\/]*$/) < 0 && $('#changed_cntry').val()!='<?php echo AUSTRALIA_ID; ?>'){
								return {
									valid: false,
									message: '<?php echo ADDRESSBOOK_DETAILS_ILLEGAL_CHARACTERS."<br />"; ?>'
								}
							}
							return true;
							
						}
					}
				 }
				},
				addressbook_detail_state: {
					selector: '#state',
					container: '#state_message',
						validators: {
							/*notEmpty: {
								message: '<?php echo ADDRESSBOOK_DETAILS_FIELD_REQUIRED." ".ADDRESSBOOK_DETAILS_STATE_REQUIRED; ?>'
							},*/
							regexp: {
								regexp: /^[a-zA-Z0-9 .,:;'?_%\s\-\/]*$/,
								message: '<?php echo ADDRESSBOOK_DETAILS_ILLEGAL_CHARACTERS; ?>'
							},
							remote: {
								url: '<?php echo DIR_HTTP_RELATED."inter_state_val.php"; ?>',
								data: function(validator) { 
									return {
									letters: validator.getFieldElements('addressbook_detail_state').val(),
									chkstate:true,
									flag:validator.getFieldElements('selected_flag').val(),
									countryid:validator.getFieldElements('changed_cntry').val(),
								
									};
								},
								message: '<?php echo PROFILE_STATE_NOT_FOUND; ?>'
							}
						}
				},
				addressbook_detail_postcode: {
					selector: '#postcode',
					container: '#postcode_message',
						validators: {
							/*notEmpty: {
								message: '<?php echo ADDRESSBOOK_DETAILS_FIELD_REQUIRED." ".ADDRESSBOOK_DETAILS_POSTCODE_REQUIRED; ?>'
							},*/
							callback: {
								callback: function(value, validator, $field) {
									if (value === '') {
										return true;
									}	
								if (value.search(/^[a-zA-Z0-9 .,:;'_\s\-\/]*$/) < 0) {
									return {
										valid: false,
										message: '<?php echo ADDRESSBOOK_DETAILS_ILLEGAL_CHARACTERS."<br />".ADDRESSBOOK_DETAILS_ALLOWED_CHARACTERS_DIGITS; ?>'
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
										message: '<?php echo ADDRESSBOOK_DETAILS_POSTCODE_CORRECT; ?>'
										};
									}

									}
								return true;
							}
						}
						}
				},
				addressbook_areacode_phone: {
					selector: '#sender_area_code',
					container: '#sender_area_code_message',
						validators: {
							notEmpty: {
								message: '<?php echo ADDRESSBOOK_DETAILS_FIELD_REQUIRED." ".ADDRESSBOOK_DETAILS_AREACODE_REQUIRED; ?>'
							},
							regexp: {
								regexp: /^[0-9+\s]*$/,
								message: '<?php echo ADDRESSBOOK_DETAILS_ILLEGAL_CHARACTERS."<br />".ADDRESSBOOK_DETAILS_AREACODE_ALLOWED_CHARACTERS_DIGITS; ?>'
							},
							stringLength: {
								min: 1,
								message: '<?php echo ADDRESSBOOK_DETAILS_AREACODE_LENGTH; ?>'
							}
						}
				},
				addressbook_detail_phone: {
				selector: '#contactNo',
				container: '#phone_message',
					validators: {
						notEmpty: {
                            message: '<?php echo ADDRESSBOOK_DETAILS_FIELD_REQUIRED." ".ADDRESSBOOK_DETAILS_CONTACTNO_REQUIRED; ?>'
                        },
						regexp: {
							regexp: /^[0-9]*$/,
							message: '<?php echo ADDRESSBOOK_DETAILS_ILLEGAL_CHARACTERS."<br />".ADDRESSBOOK_DETAILS_ALLOWED_CHARACTERS_DIGITS; ?>'
						},
						stringLength: {
                        	min: 10,
							max:12,
                        	message: '<?php echo ADDRESSBOOK_DETAILS_CORRECT_PHONE_LENGTH; ?>'
                    	}
					}
				},
				addressbook_areacode_mobile: {
					selector: '#sender_mb_area_code',
					container: '#sender_mb_area_code_message',
						validators: {
							notEmpty: {
								message: '<?php echo ADDRESSBOOK_DETAILS_FIELD_REQUIRED." ".ADDRESSBOOK_DETAILS_AREACODE_REQUIRED; ?>'
							},
							regexp: {
								regexp: /^[0-9+\s]*$/,
								message: '<?php echo ADDRESSBOOK_DETAILS_ILLEGAL_CHARACTERS."<br />".ADDRESSBOOK_DETAILS_AREACODE_ALLOWED_CHARACTERS_DIGITS; ?>'
							},
							stringLength: {
								min: 1,
								message: '<?php echo ADDRESSBOOK_DETAILS_AREACODE_LENGTH; ?>'
							}
						}
				},
				addressbook_areacode_mobile: {
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
				addressbook_detail_mobile_phone: {
					selector: '#mobile_phone',
					container: '#mobile_phone_message',
						validators: {
							regexp: {
								regexp: /^[0-9]*$/,
								message: '<?php echo ADDRESSBOOK_DETAILS_ILLEGAL_CHARACTERS."<br />".ADDRESSBOOK_DETAILS_ALLOWED_CHARACTERS_DIGITS; ?>'
							},
							stringLength: {
								min: 10,
								max:12,
								message: '<?php echo ADDRESSBOOK_DETAILS_CORRECT_PHONE_LENGTH; ?>'
							}
						}
				},
				addressbook_detail_email: {
				selector: '#email',
				container: '#email_message',
					validators: {
						emailAddress: {
                        	message: '<?php echo ADDRESSBOOK_DETAILS_EMAIL_VALID; ?>'
                    	}
					}
				},
			},
			
			
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
			   	//alert("inside test"+msg);
				   $('#sender_area_code').val(msg);
				   $('#sender_mb_area_code').val(msg);
				
			   }	
			}),
			$('#addressbook_detail').data('bootstrapValidator').resetField(
			"addressbook_areacode_phone",true);
			$('#addressbook_detail').data('bootstrapValidator').resetField(
			"addressbook_areacode_mobile",true);
			$('#addressbook_detail').data('bootstrapValidator').resetField(
			"addressbook_detail_suburb",true);
			$('#addressbook_detail').data('bootstrapValidator').resetField(
			"addressbook_detail_state",true);
			$('#addressbook_detail').data('bootstrapValidator').resetField(
			"addressbook_detail_postcode",true);
			('#addressbook_detail').data('bootstrapValidator').resetField(
			"addressbook_detail_fsuburb",true);
			
		})
		.on('change', '[name="suburb"]', function() {
			//alert("suburb val:"+$("#suburb").val());
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
			//alert("test");
			$('#addressbook_detail').bootstrapValidator('revalidateField', 'addressbook_detail_fsuburb');
			$('#addressbook_detail').bootstrapValidator('enableFieldValidators', 'addressbook_detail_suburb',false);
		})
		.on('success.form.bv', function(e) {
			e.preventDefault();
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
				  },
				  success: function( data ) {
				    
					if(data == 1)
					{
						succeed = true;
						var firstname = $("#firstname").val();
						var lastname = $("#lastname").val();
						$.ajax({
						  url: '<?php echo DIR_HTTP_RELATED."ajax_edit_address.php"; ?>',
						  type: 'post',
						  data: {'action': 'duplicate', 'userid': '<?php echo $userid; ?>','firstname':firstname,'lastname':lastname},
						  success: function(data, status) { 
							//alert(data);
							if(data == 1)
							{
								//alert("after success"+$("#CatId").val());
								if($("#CatId").val() == "")
								{
									$('.containerBlock > form').waitMe('hide');
									return confirmAction();
								}else{
									//$("#addressbook_detail").submit();
									$('.containerBlock > form').waitMe('hide');
									 $("#Save").val("Add");
									 $('#addressbook_detail').bootstrapValidator('defaultSubmit');
								}
							}else{
								$('.containerBlock > form').waitMe('hide');
								$("#Save").val("Add");
								$('#addressbook_detail').bootstrapValidator('defaultSubmit');
							}
						  },
						  error: function(xhr, desc, err) {
							console.log(xhr);
							console.log("Details: " + desc + "\nError:" + err);
						  }
						}); // end ajax call
						
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
				var firstname = $("#firstname").val();
				var lastname = $("#lastname").val();
				run_waitMe('win8_linear');
				$.ajax({
				  url: '<?php echo DIR_HTTP_RELATED."ajax_edit_address.php"; ?>',
				  type: 'post',
				  data: {'action': 'duplicate', 'userid': '<?php echo $userid; ?>','firstname':firstname,'lastname':lastname},
				  success: function(data, status) { 
					//alert(data);
					if(data == 1)
					{
						//alert("after success"+$("#CatId").val());
						if($("#CatId").val() == "")
						{
							$('.containerBlock > form').waitMe('hide');
							return confirmAction();
						}else{
							//$("#addressbook_detail").submit();
							$('.containerBlock > form').waitMe('hide');
							 $("#Save").val("Add");
							 $('#addressbook_detail').bootstrapValidator('defaultSubmit');
						}
					}else{
						$("#Save").val("Add");
						$('.containerBlock > form').waitMe('hide');
						$('#addressbook_detail').bootstrapValidator('defaultSubmit');
					}
				  },
				  error: function(xhr, desc, err) {
					console.log(xhr);
					console.log("Details: " + desc + "\nError:" + err);
				  }
				}); // end ajax call
			}
		})
});
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
			//alert(state);
			$("#state").val(trim(state));
			$("#register_state_code").val(trim(statewithcode[maximum_state_of_array-1]));
			$('#addressbook_detail').bootstrapValidator('revalidateField', 'addressbook_detail_state');
			$("#Save").prop("disabled", false);
			$('#addressbook_detail').bootstrapValidator('revalidateField', 'addressbook_detail_fsuburb');
		}
		
    });
})

function removeError(a)
{
	//alert(a);
	$("#"+a).slideUp(400);
}
function resetForm()
{
	
	$("#addressbook_detail").data('bootstrapValidator').resetForm();
	$("#suburb").attr("readonly", false); 
	//$("#state").attr("readonly", false); 	
	//$("#postcode").attr("readonly", false); 	
}
function historyBack(){ 
	$('#addressbook_detail').bootstrapValidator('disableSubmitButtons', true);
	window.history.back();
	//disableSubmitButtons(true);
	
}
//alert("country val:"+$("#country").val());
if($("#country").val() == '13')
{
	$("#state").attr("readonly", true);
	$("#postcode").attr("readonly", true);
}
function successfullydone(){
	
	$('#addressbook_detail').bootstrapValidator('defaultSubmit');
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
	$("#Save").prop("disabled", false);
	//return false;
}
function addressError(){
	return false;
}
</script>