<script type="text/javascript" >
<!--	***		Bootstrap validator	***		-->
$('#Save').click(function (){
	//alert("myquote button is clicked");
	ValidateAddressesForm();
	var validator = $('[id*=addressesForm]').data('bootstrapValidator');
    validator.validate();
   // return validator.isValid();
});
//$(document).ready(function() {
function ValidateAddressesForm() {
	//console.log("test");
    $('#addressesForm')
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
        fields: {

             sender_first_name: {
				selector: '#sender_first_name',
				container: '#sender_first_name_message',
					validators: {
						notEmpty: {
                            message: '<?php echo BOOKING_FIELD_REQUIRED." ".BOOKING_SENDER_FIRSTNAME_REQUIRED; ?>'
                        },
						regexp: {
							regexp: /^[a-zA-Z'\s]*$/, //lowercase, upercase, space
							message: '<?php echo BOOKING_ILLEGAL_CHARACTERS."<br />".BOOKING_ALLOWED_CHARACTERS_NAMES; ?>'
						}
					}
            },
			sender_last_name: {
				selector: '#sender_last_name',
				container: '#sender_last_name_message',
					validators: {
						notEmpty: {
                            message: '<?php echo BOOKING_FIELD_REQUIRED." ".BOOKING_SENDER_LASTNAME_REQUIRED; ?>'
                        },
						regexp: {
							regexp: /^[a-zA-Z'\s]*$/, //lowercase, upercase, apostrophe, space
							message: '<?php echo BOOKING_ILLEGAL_CHARACTERS."<br />".BOOKING_ALLOWED_CHARACTERS_NAMES; ?>'
						}
					}
            },
			sender_company_name: {
				selector: '#sender_company_name',
				container: '#sender_company_name_message',
					validators: {
						callback: {
							callback: function(value, validator, $field) {
								if(value.length>1)
								{
									if (value.search(/^[a-zA-Z0-9 .,:;'?_%\s\-\/]*$/) < 0) {
										return {
											valid: false,
											message: '<?php echo BOOKING_ILLEGAL_CHARACTERS; ?>'
										}
									}
								}
								return true;
							}
						}
					}
            },
			sender_address_1: {
				selector: '#sender_address_1',
				container: '#sender_address_1_message',
					validators: {
						notEmpty: {
                            message: '<?php echo BOOKING_FIELD_REQUIRED." ".BOOKING_SENDER_ADDRESS1_REQUIRED; ?>'
                        },
						regexp: {
							regexp: /^[a-zA-Z0-9 .,:#;'?_%\s\-\/]*$/,
							message: '<?php echo BOOKING_ILLEGAL_CHARACTERS; ?>'
						}
					}
            },
			sender_address_2: {
				selector: '#sender_address_2',
				container: '#sender_address_2_message',
					validators: {
						regexp: {
							regexp: /^[a-zA-Z0-9 .,:#;'?_%\s\-\/]*$/,
							message: '<?php echo BOOKING_ILLEGAL_CHARACTERS; ?>'
						}
					}
            },
			sender_address_3: {
				selector: '#sender_address_3',
				container: '#sender_address_3_message',
					validators: {
						regexp: {
							regexp: /^[a-zA-Z0-9 .,:#;'?_%\s\-\/]*$/,
							message: '<?php echo BOOKING_ILLEGAL_CHARACTERS; ?>'
						}
					}
            },
			sender_email: {
				selector: '#sender_email',
				container: '#sender_email_message',
					validators: {
						notEmpty: {
                            message: '<?php echo BOOKING_FIELD_REQUIRED." ".BOOKING_SENDER_EMAIL_REQUIRED; ?>'
                        },
						emailAddress: {
                        	message: '<?php echo BOOKING_EMAIL_VALID; ?>'
                    	}
					}
            },
			sender_areacode_phone: {
			selector: '#sender_area_code',
			container: '#sender_area_code_contact_no_message',
				validators: {
					notEmpty: {
						message: '<?php echo BOOKING_FIELD_REQUIRED." ".BOOKING_SENDER_COUNTRY_REQUIRED; ?>'
					},
					regexp: {
						regexp: /^[0-9+-\s]*$/,
						message: '<?php echo ADDRESSES_ILLEGAL_CHARACTERS."<br />".ADDRESSES_ALLOWED_CHARACTERS_DIGITS; ?>'
					},
					stringLength: {
						min: 1,
						message: '<?php echo ADDRESSES_CORRECT_AREACODE_LENGTH; ?>'
					}
				}
			},
			sender_contact_no: {
				selector: '#sender_contact_no',
				container: '#sender_contact_no_message',
					validators: {
						notEmpty: {
                            message: '<?php echo BOOKING_FIELD_REQUIRED." ".BOOKING_SENDER_CONTACTNO_REQUIRED; ?>'
                        },
						regexp: {
							regexp: /^[0-9]*$/,
							message: '<?php echo BOOKING_ILLEGAL_CHARACTERS."<br />".BOOKING_ALLOWED_CHARACTERS_DIGITS; ?>'
						},
						stringLength: {
                        	min: 9,
							max:12,
                        	message: '<?php echo BOOKING_CORRECT_PHONE_LENGTH; ?>'
                    	}
					}
            },
			sender_areacode_mobile: {
				selector: '#sender_mb_area_code',
				container: '#sender_mb_area_code_message',
					validators: {
						regexp: {
							regexp: /^[0-9+-\s]*$/,
							message: '<?php echo ADDRESSES_ILLEGAL_CHARACTERS."<br />".ADDRESSES_ALLOWED_CHARACTERS_DIGITS; ?>'
						},
						stringLength: {
							min: 1,
							message: '<?php echo ADDRESSES_CORRECT_AREACODE_LENGTH; ?>'
						}
					}
			},
			sender_mobile_no: {
				selector: '#sender_mobile_no',
				container: '#sender_mobile_no_message',
					validators: {
						regexp: {
							regexp: /^[0-9]*$/,
							message: '<?php echo BOOKING_ILLEGAL_CHARACTERS."<br />".BOOKING_ALLOWED_CHARACTERS_DIGITS; ?>'
						},
						stringLength: {
                        	min: 9,
							max:12,
                        	message: '<?php echo BOOKING_CORRECT_PHONE_LENGTH; ?>'
                    	}
					}
            },
			receiver_first_name: {
				selector: '#receiver_first_name',
				container: '#receiver_first_name_message',
					validators: {
						notEmpty: {
                            message: '<?php echo BOOKING_FIELD_REQUIRED." ".BOOKING_RECEIVER_FIRSTNAME_REQUIRED; ?>'
                        },
						regexp: {
							regexp: /^[a-zA-Z'\s]*$/, //lowercase, upercase, space
							message: '<?php echo BOOKING_ILLEGAL_CHARACTERS."<br />".BOOKING_ALLOWED_CHARACTERS_NAMES; ?>'
						}
					}
            },
			receiver_surname: {
				selector: '#receiver_surname',
				container: '#receiver_surname_message',
					validators: {
						notEmpty: {
                            message: '<?php echo BOOKING_FIELD_REQUIRED." ".BOOKING_RECEIVER_LASTNAME_REQUIRED; ?>'
                        },
						regexp: {
							regexp: /^[a-zA-Z'\s]*$/, //lowercase, upercase, apostrophe, space
							message: '<?php echo BOOKING_ILLEGAL_CHARACTERS."<br />".BOOKING_ALLOWED_CHARACTERS_NAMES; ?>'
						}
					}
            },
			receiver_company_name: {
				selector: '#receiver_company_name',
				container: '#receiver_company_name_message',
					validators: {
						callback: {
							callback: function(value, validator, $field) {
								if(value.length>1)
								{
									if (value.search(/^[a-zA-Z0-9 .,:;'?_%\s\-\/]*$/) < 0) {
										return {
											valid: false,
											message: '<?php echo BOOKING_ILLEGAL_CHARACTERS; ?>'
										}
									}
								}
								return true
							}
						}
					}
            },
			receiver_address_1: {
				selector: '#receiver_address_1',
				container: '#receiver_address_1_message',
					validators: {
						notEmpty: {
                            message: '<?php echo BOOKING_FIELD_REQUIRED." ".BOOKING_RECEIVER_ADDRESS1_REQUIRED; ?>'
                        },
						regexp: {
							regexp: /^[a-zA-Z0-9 .,:#;'?_%\s\-\/]*$/,
							message: '<?php echo BOOKING_ILLEGAL_CHARACTERS; ?>'
						}
					}
            },
			receiver_address_2: {
				selector: '#receiver_address_2',
				container: '#receiver_address_2_message',
					validators: {
						regexp: {
							regexp: /^[a-zA-Z0-9 .,:#;'?_%\s\-\/]*$/,
							message: '<?php echo BOOKING_ILLEGAL_CHARACTERS; ?>'
						}
					}
            },
			receiver_address_3: {
				selector: '#receiver_address_3',
				container: '#receiver_address_3_message',
					validators: {
						regexp: {
							regexp: /^[a-zA-Z0-9 .,:#;'?_%\s\-\/]*$/,
							message: '<?php echo BOOKING_ILLEGAL_CHARACTERS; ?>'
						}
					}
            },
			receiver_suburb_int: {
				selector: '#receiver_suburb',
				container: '#receiver_suburb_int_message',
					validators: {
						notEmpty: {
                            message: '<?php echo BOOKING_FIELD_REQUIRED." ".BOOKING_RECEIVER_SUBURB_REQUIRED; ?>'
                        },
						regexp: {
							regexp: /^[a-zA-Z0-9 .,:;'?_%\s\-\/]*$/,
							message: '<?php echo BOOKING_ILLEGAL_CHARACTERS; ?>'
						}
					}
            },
			receiver_state_int: {
				selector: '#receiver_state',
				container: '#receiver_state_int_message',
					validators: {
						regexp: {
							regexp: /^[a-zA-Z'\s]*$/,
							message: '<?php echo BOOKING_ILLEGAL_CHARACTERS; ?>'
						},
						remote: {
							url: '<?php echo DIR_HTTP_RELATED."inter_state_val.php"; ?>',
							data: function(validator) {
								return {
								chkstate:true,
								flag:validator.getFieldElements('selected_flag').val(),
								letters: validator.getFieldElements('receiver_state').val(),
								countryid:validator.getFieldElements('changed_cntry').val(),
								};
							},
                            message: '<?php echo ADDRESSES_STATE_NOT_FOUND; ?>'
						},
						callback: {
						message: '<?php echo BOOKING_RECEIVER_STATE_REQUIRED; ?>',
						callback: function (value, validator, $field) {
							var receiver_country = $("#receiver_country").val();

							var receiver_state = $("#receiver_state").val();

							if($('#receiver_country').length>0 && $('#receiver_state').length>0  && receiver_country == 'United States' && receiver_state=='')
							{
								return {
									valid: false,
									message: "<?php echo BOOKING_RECEIVER_STATE_REQUIRED; ?>"
								};
							}
							return true;

							}
						}
					},

            },
			receiver_postcode_int: {
				selector: '#receiver_postcode',
				container: '#receiver_postcode_int_message',
					validators: {
						notEmpty: {
                            message: '<?php echo BOOKING_FIELD_REQUIRED." ".BOOKING_RECEIVER_POSTCODE_REQUIRED; ?>'
                        },
						callback: {
							callback: function(value, validator, $field) {
							if (value === '') {
                                return true;
                            }
							if (value.search(/^[a-zA-Z0-9 .,:;'_\s\-\/]*$/) < 0) {
								return {
									valid: false,
									message: '<?php echo BOOKING_ILLEGAL_CHARACTERS; ?>'
								}
                            }
							var countryid = $("#receiver_country").val();

							if(countryid == '<?php echo UNITED_STATE_NAME; ?>')
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
									message: '<?php echo ADDRESSES_POSTCODE_CORRECT; ?>'
									};
								}

								}
							return true;
							}
						}

					}
            },
			receiver_email: {
				selector: '#receiver_email',
				container: '#receiver_email_message',
					validators: {
						emailAddress: {
                        	message: '<?php echo BOOKING_EMAIL_VALID; ?>'
                    	}
					}
            },
			receiver_areacode_phone: {
			selector: '#receiver_area_code',
			container: '#receiver_mobile_area_code_no_message',
				validators: {
					notEmpty: {
						message: '<?php echo BOOKING_FIELD_REQUIRED." ".BOOKING_RECEIVER_COUNTRY_REQUIRED; ?>'
					},
					regexp: {
						regexp: /^[0-9+-\s]*$/,
						message: '<?php echo ADDRESSES_ILLEGAL_CHARACTERS."<br />".ADDRESSES_ALLOWED_CHARACTERS_DIGITS; ?>'
					},
					stringLength: {
						min: 1,
						message: '<?php echo ADDRESSES_CORRECT_AREACODE_LENGTH; ?>'
					}
				}
			},
			receiver_contact_no: {
				selector: '#receiver_contact_no',
				container: '#receiver_contact_no_message',
					validators: {
						notEmpty: {
                            message: '<?php echo BOOKING_FIELD_REQUIRED." ".BOOKING_RECEIVER_CONTACTNO_REQUIRED; ?>'
                        },
						regexp: {
							regexp: /^[0-9]*$/,
							message: '<?php echo BOOKING_ILLEGAL_CHARACTERS."<br />".BOOKING_ALLOWED_CHARACTERS_DIGITS; ?>'
						},
						stringLength: {
                        	min: 7,
							max:12,
                        	message: '<?php echo BOOKING_CORRECT_PHONE_LENGTH; ?>'
                    	}
					}
            },
			receiver_areacode_mobile: {
				selector: '#receiver_mb_area_code',
				container: '#receiver_mobile_area_code_no_message',
					validators: {
						regexp: {
							regexp: /^[0-9+-\s]*$/,
							message: '<?php echo ADDRESSES_ILLEGAL_CHARACTERS."<br />".ADDRESSES_ALLOWED_CHARACTERS_DIGITS; ?>'
						},
						stringLength: {
							min: 1,
							message: '<?php echo ADDRESSES_CORRECT_AREACODE_LENGTH; ?>'
						}
					}
			},
			receiver_mobile_no: {
				selector: '#receiver_mobile_no',
				container: '#receiver_mobile_no_message',
					validators: {
						regexp: {
							regexp: /^[0-9]*$/,
							message: '<?php echo BOOKING_ILLEGAL_CHARACTERS."<br />".BOOKING_ALLOWED_CHARACTERS_DIGITS; ?>'
						},
						stringLength: {
                        	min: 7,
							max:12,
                        	message: '<?php echo BOOKING_CORRECT_PHONE_LENGTH; ?>'
                    	}
					}
            }

        }
    })

	.on('success.form.bv', function(e) {

		var succeed = false;
		var receiver_country = $("#receiver_country").val();
		return successfullydone();
				
	})
	.on('click', '.Reset', function() {
		$('#addressesForm').data('bootstrapValidator').resetForm(true);
	});

//});
}
function successfullydone(){
	$("#finalsubmit").val("Add");
	$('#addressesForm').bootstrapValidator('defaultSubmit');
	 return true;
}

function ntest(){

	return false;

}
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
// Read a page's GET URL variables and return them as an associative array.
function getUrlVars()
{
    var vars = [], hash;
    var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
    for(var i = 0; i < hashes.length; i++)
    {
        hash = hashes[i].split('=');
        vars.push(hash[0]);
        vars[hash[0]] = hash[1];
    }
    return vars;
}
function getAddressFromAddressBook(addType){
	var suburb;
	var state;
	var postcode;
	var countryval;
	var paramstring;
	var action = getUrlVars()["Action"];
	console.log("action"+action);
	if(addType ==  'pickup'){
		$("#pkp_address_from_book").val(1);
		suburb = $('#sender_suburb').val();
		state = $('#sender_state').val();
		postcode = $('#sender_postcode').val();
		if(suburb!=undefined && state!=undefined && postcode!=undefined){
			paramstring ="suburb="+suburb+"&state="+state+"&postcode="+postcode+"&type="+'pickup';
		}
	}else{
		$("#dlv_address_from_book").val(1);
		suburb = $('#receiver_suburb').val();
		state = $('#receiver_state').val();
		postcode = $('#receiver_postcode').val();
		countryval = $("#receiver_country").val();
		if(countryval!=undefined){
			paramstring = "country="+countryval+"&type="+'delivery';
		}else if(suburb!=undefined && state!=undefined && postcode!=undefined){
			paramstring = "suburb="+suburb+"&state="+state+"&postcode="+postcode+"&type="+'delivery';
		}



	}

	var pkpVal = $("#pkp_address_from_book").val();
	var delVal = $("#dlv_address_from_book").val();

	$.ajax({
       type: "GET",
       url: "related/ajax_address_exists.php",
       dataType: 'json',
	   data: paramstring,
       success: function(msg){
         //
		 if(msg.head)
		 {
			 console.log(msg.head);
			//window.location.href = msg.head;
			var urlArg;
			if(action!= undefined){
				urlArg = "&Action=edit";
				document.location="<?php echo FILE_ADDRESS_BOOK_LISTING; ?>?type=" + addType + "&pkpVal=" + pkpVal + "&delVal=" + delVal + urlArg;
			}else{
				document.location="<?php echo FILE_ADDRESS_BOOK_LISTING; ?>?type=" + addType + "&pkpVal=" + pkpVal + "&delVal=" + delVal;
			}
			

		 }
		 if(msg.error)
		 {
            //alert(msg.error+"inside add Error function"); return false;
			$('#msgContent').html(msg.error);
			$('#errorBox').modal('show'); //Anything you want
            var results = false;

		 }
       }

     });

}

$(function() {
$( "#sender_first_name" ).autocomplete({
minLength: 0,
source: function( request, response ) {
        $.ajax({
          url: "<?php echo DIR_HTTP_RELATED."ajax_addresslist.php"; ?>",
          dataType: "json",
          method: "post",
		  data: {
            letters: request.term,
			addType: 'Pickup',
          },
          success: function( data ) {
            response( data );

          }
        });
      },
focus: function( event, ui ) {
$( "#sender_first_name" ).val( ui.item.firstname );
return false;
},
select: function( event, ui ) {
$('#divpkaddress').css("display","none");
$("#confirmPkpAddYes ").val(0);
$( "#sender_client_address_id" ).val( ui.item.id );
$( "#sender_first_name" ).val( ui.item.firstname );
$( "#sender_last_name" ).val( ui.item.lastname );
$( "#sender_company_name" ).val( ui.item.company );
$( "#sender_address_1" ).val( ui.item.address );
$( "#sender_address_2" ).val( ui.item.address2 );
$( "#sender_address_3" ).val( ui.item.address3 );
$( "#sender_email" ).val( ui.item.email );
$( "#sender_contact_no" ).val( ui.item.contact );
$( "#sender_area_code" ).val( ui.item.area_code );
$( "#sender_mobile_no" ).val( ui.item.mobileno );
$( "#sender_mb_area_code" ).val( ui.item.m_area_code );
//revalidateSendersFields();
return false;
}
})

.autocomplete( "instance" )._renderItem = function( ul, item ) {

if(item.company != undefined)
{
	var company = item.company + " ";

}else{

	var company = "";
}
if(item.address2 != undefined)
{
	var add2 = item.address2 + " ";

}else{

	var add2 = "";
}
if(item.address3 != undefined)
{
	var add3 = item.address3 + " ";

}else{

	var add3 = "";
}
if(item.mobileno != undefined)
{
	var mobile = item.mobileno + " ";

}else{

	var mobile = "";
}
return $( "<li>" )
.append( "<a>" + item.firstname + " " + item.lastname + " " + item.address +"</a>" )
.appendTo(ul);
};
});
$(function() {
$( "#receiver_first_name" ).autocomplete({
minLength: 0,
source: function( request, response ) {
        $.ajax({
          url: "<?php echo DIR_HTTP_RELATED."ajax_addresslist.php"; ?>",
          dataType: "json",
          method: "post",
		  data: {
            letters: request.term,
			addType: 'Delivery',
          },
          success: function( data ) {
            response( data );
          }
        });
      },
focus: function( event, ui ) {
$( "#receiver_first_name" ).val( ui.item.firstname );
return false;
},
select: function( event, ui ) {
$('#divdeladdress').css("display","none");
$(" #confirmDelAddYes ").val(0);
$( "#receiver_first_name" ).val( ui.item.firstname );
$( "#receiver_surname" ).val( ui.item.lastname );
$( "#receiver_company_name" ).val( ui.item.company );
$( "#receiver_address_1" ).val( ui.item.address );
$( "#receiver_address_2" ).val( ui.item.address2 );
$( "#receiver_address_3" ).val( ui.item.address3 );
$( "#receiver_email" ).val( ui.item.email );
$( "#receiver_area_code" ).val( ui.item.area_code );
$( "#receiver_contact_no" ).val( ui.item.contact );
$( "#receiver_m_area_code" ).val( ui.item.m_area_code );
$( "#receiver_mobile_no" ).val( ui.item.mobileno );
//$('#addressesForm').data('bootstrapValidator').resetForm(true);
revalidateReceiversFields();
return false;
}
})
.autocomplete( "instance" )._renderItem = function( ul, item ) {
if(item.company != undefined)
{
	var company = item.company + " ";

}else{

	var company = "";
}
if(item.address2 != undefined)
{
	var add2 = item.address2 + " ";

}else{

	var add2 = "";
}
if(item.address3 != undefined)
{
	var add3 = item.address3 + " ";

}else{

	var add3 = "";
}
if(item.mobileno != undefined)
{
	var mobile = item.mobileno + " ";

}else{

	var mobile = "";
}
return $( "<li>" )
.append( "<a>" + item.firstname + " " + item.lastname + " " +  item.address + "</a>" )
.appendTo( ul );
};
});

$("#sender_contact_no").change(function (e) {
	var data = $('form').serialize();
	$.ajax({
	  url: "<?php echo DIR_HTTP_RELATED."ajax_check_sender_address.php"; ?>",
	  dataType: "json",
	  method: "post",
	  data: data,
	  success: function( response ) {
		  console.log("response:"+response);
		if(response == 0)
		{
			$('#divpkaddress').css("display","block");
		}else{
			$('#divpkaddress').css("display","none");
		}
	  }
	});
	//alert(form);
});
$("#sender_first_name").change(function (e) {
	var data = $('form').serialize();
	$.ajax({
	  url: "<?php echo DIR_HTTP_RELATED."ajax_check_sender_address.php"; ?>",
	  dataType: "json",
	  method: "post",
	  data: data,
	  success: function( response ) {
		if(response == 0)
		{
			$('#divpkaddress').css("display","block");
		}else{
			$('#divpkaddress').css("display","none");
		}
	  }
	});
	//alert(form);
});
$("#sender_last_name").change(function (e) {
	var data = $('form').serialize();
	$.ajax({
	  url: "<?php echo DIR_HTTP_RELATED."ajax_check_sender_address.php"; ?>",
	  dataType: "json",
	  method: "post",
	  data: data,
	  success: function( response ) {
		if(response == 0)
		{
			$('#divpkaddress').css("display","block");
		}else{
			$('#divpkaddress').css("display","none");
		}
	  }
	});
	//alert(form);
});

$("#receiver_contact_no").change(function (e) {
	var data = $('form').serialize();
	$.ajax({
	  url: "<?php echo DIR_HTTP_RELATED."ajax_check_receiver_address.php"; ?>",
	  dataType: "json",
	  method: "post",
	  data: data,
	  success: function( response ) {
		if(response == 0)
		{
			$('#divdeladdress').css("display","block");
		}else{
			$('#divdeladdress').css("display","none");
		}
	  }
	});
	//alert(form);
});
$("#receiver_first_name").change(function (e) {
	var data = $('form').serialize();
	$.ajax({
	  url: "<?php echo DIR_HTTP_RELATED."ajax_check_receiver_address.php"; ?>",
	  dataType: "json",
	  method: "post",
	  data: data,
	  success: function( response ) {
		if(response == 0)
		{
			$('#divdeladdress').css("display","block");
		}else{
			$('#divdeladdress').css("display","none");
		}
	  }
	});
	//alert(form);
});
$("#receiver_surname").change(function (e) {
	var data = $('form').serialize();
	$.ajax({
	  url: "<?php echo DIR_HTTP_RELATED."ajax_check_receiver_address.php"; ?>",
	  dataType: "json",
	  method: "post",
	  data: data,
	  success: function( response ) {
		if(response == 0)
		{
			$('#divdeladdress').css("display","block");
		}else{
			$('#divdeladdress').css("display","none");
		}
	  }
	});
	//alert(form);
});

function revalidateReceiversFields()
{
	//$('#addressesForm').bootstrapValidator('revalidateField', 'receiver_first_name');
	//$('#addressesForm').bootstrapValidator('revalidateField', $('#receiver_first_name'));
	//$('#addressesForm').bootstrapValidator('revalidateField', $('#receiver_first_name'));
	/*$('#addressesForm').bootstrapValidator('revalidateField', 'receiver_surname');
	$('#addressesForm').bootstrapValidator('revalidateField', 'receiver_company_name');
	$('#addressesForm').bootstrapValidator('revalidateField', 'receiver_address_1');
	$('#addressesForm').bootstrapValidator('revalidateField', 'receiver_address_2');
	$('#addressesForm').bootstrapValidator('revalidateField', 'receiver_address_3');
	
	$('#addressesForm').bootstrapValidator('revalidateField', 'receiver_suburb');
	$('#addressesForm').bootstrapValidator('revalidateField', 'receiver_state');
	$('#addressesForm').bootstrapValidator('revalidateField', 'receiver_postcode');
	
	$('#addressesForm').bootstrapValidator('revalidateField', 'receiver_email');
	
	$('#addressesForm').bootstrapValidator('revalidateField', 'receiver_area_code');
	$('#addressesForm').bootstrapValidator('revalidateField', 'receiver_contact_no');
	$('#addressesForm').bootstrapValidator('revalidateField', 'receiver_mb_area_code');
	$('#addressesForm').bootstrapValidator('revalidateField', 'receiver_mobile_no');*/
}
function revalidateSendersFields()
{

	$('#addressesForm').bootstrapValidator('revalidateField', 'sender_first_name');
	$('#addressesForm').bootstrapValidator('revalidateField', 'sender_last_name');
	$('#addressesForm').bootstrapValidator('revalidateField', 'sender_company_name');
	$('#addressesForm').bootstrapValidator('revalidateField', 'sender_address_1');
	$('#addressesForm').bootstrapValidator('revalidateField', 'sender_address_2');
	$('#addressesForm').bootstrapValidator('revalidateField', 'sender_address_3');
	$('#addressesForm').bootstrapValidator('revalidateField', 'sender_areacode_phone');
	$('#addressesForm').bootstrapValidator('revalidateField', 'sender_contact_no');
	$('#addressesForm').bootstrapValidator('revalidateField', 'sender_areacode_mobile');
	$('#addressesForm').bootstrapValidator('revalidateField', 'sender_mobile_no');

}
$(function(){
	var receiver_country = $("#receiver_country").val();
	if(receiver_country == 'United States')
	{
		$(document).on('click', '#ajax_index_listOfOptions div', function(){
			var receiver_state_val = $("#receiver_state").val();
		})
	}
})
/*
$("#receiver_state").keyup(
function(event){

		//alert("form id"+form_id);
		var receiver_country = $("#receiver_country").val();
		//alert("country_val:"+changed_country_val);
		if(receiver_country == 'United States')
		{
			ajax_showOptions(this,'state_search',event,'related/inter_state_val.php','ajax_index_listOfOptions');
		}
	}
);
*/
$(function(){
    $(document).on('click', '#ajax_index_listOfOptions div', function(){
        var receiver_country = $("#receiver_country").val();
		if(receiver_country == 'United States')
		{
			var receiver_state = $("#receiver_state").val();
			var statewithcode = receiver_state.split(" ");
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
			//alert(statewithcode[maximum_state_of_array-1]);
			$("#receiver_state").val(trim(state));
			$("#receiver_state_code").val(trim(statewithcode[maximum_state_of_array-1]));
			//$('#addressesForm').bootstrapValidator('revalidateField', 'receiver_state_int');
			$("#Save").prop("disabled", false);
		}

    });
})

$('#addressClsModal').click(function(e){
	$('#AddressError').modal('hide');
	e.preventDefault();
	// window.location.reload(false);
});
function addresstestClick(state,stateCode,postcode,city)
{
	$('#receiver_state').val(state);
	$('#receiver_state_code').val(stateCode);
	$('#receiver_postcode').val(postcode);
	$('#receiver_suburb').val(city);
	$('#AddressError').modal('hide');
	$("#Save").prop("disabled", false);
	//return false;
}
</script>
<?php if(isset($_GET['error']) && $_GET['error'] != ''){ ?>
<script>
$("#AddressError").modal('show');
</script>
<?php } ?>
