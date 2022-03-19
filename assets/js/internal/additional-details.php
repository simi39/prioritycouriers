<script language="javascript" type="text/javascript">

var originalprice=0;

function unsetCalc(){
	var anchorHREF = "<?php echo DIR_HTTP_RELATED."ajax_get_transit_amount.php?"; ?>";
	$.ajax({
		   type: "POST",
		   url: anchorHREF,
		   data: 'action=unset_transit',
		   success: function(msg){
		   	if (msg != "fail") {

		   		$("#transit_txt").html("");
		   	}
	   }
	});

	if($('input[name=select_transit_warranty]:checked', '#additional-detailsForm').val() == 'undefined')
	{

		if($("#transit_warranty_au").val("")!=undefined)
		{
			$("#transit_warranty_au").val("");
		}else{
			$("#transit_warranty_int").val("")
		}
	}
	//alert($("#transit_amount").val());
	var price = $("#service_rate").val();
	$("#original_price").html(price);
	if($("#transit_amount").val()!=0)
	{
		var amtprice = parseFloat($("#service_rate").val())-parseFloat($("#transit_amount").val());
		$("#original_price").html(parseFloat(amtprice).toFixed(2));
		//$("#transit_amount").val(0);
	}

	$("#transit_txt").html("");

}

<!--	***		Bootstrap validator	***		-->
$(document).ready(function() {
    $('#additional-detailsForm')
	 .bootstrapValidator({
      /*  feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },*/
        fields: {
			currency_code: {

				selector: '#currency_code',
				container: '#currency_code_message',
				validators: {
					notEmpty: {
						message: '<?php echo ADDITIONAL_DETAILS_FIELD_REQUIRED; ?>'
					},
					regexp: {
					regexp: /^([a-zA-Z.]{1,3})$/, //message
					message: '<?php echo CURRENCY_CODE_REGEX; ?>'
					}
				}
			},
			customs_value: {

				selector: '#transit_warranty_int',
				container: '#transit_warranty_int_message',
					validators: {
					notEmpty: {
                            message: '<?php echo ADDITIONAL_DETAILS_FIELD_REQUIRED; ?>'
                        },
					regexp: {
							regexp: /^[0-9]*$/, //message
							message: '<?php echo CUSTOMS_VALUE; ?>'
						}
					}
      },
			country_of_origin: {
				selector: '#country_of_origin',
				container: '#country_origin_message',
				validators: {
					notEmpty: {
						message: '<?php echo REQUIRED_ITEM_NAMES; ?>'
					}
				}
			},
            /*item_type: {
				selector: '#goods_nature',
				container: '#goods_nature_message',
					validators: {
					notEmpty: {
                            message: '<?php echo REQUIRED_ITEM_NAMES; ?>'
                        }
					}
            },*/
            enquiry: {
				selector: '#goods_description_au',
				container: '#goods_description_au_message',
					validators: {
						regexp: {
							regexp: /^[a-zA-Z0-9',_.!?\s\-\/]*$/, //message
							message: '<?php echo ADDITIONAL_DETAILS_ILLEGAL_CHARACTERS; ?>'
						},
						notEmpty: {
                            message: '<?php echo ADDITIONAL_DETAILS_FIELD_REQUIRED." ".REQUIRED_TRANSIT_GOODS_DESCRIPTION; ?>'
                        },
						stringLength: {
							max:160,
                        	message: '<?php echo REQUIRED_ITEM_LENGTH; ?>'
                    	}
					}
            },
			transit_warranty_au: {
				selector: '#transit_warranty_au',
				container: '#transit_warranty_au_message',
					validators: {

						regexp: {
							regexp: /^[0-9]*$/,
							message: '<?php echo ADDITIONAL_DETAILS_ILLEGAL_CHARACTERS."<br />".ADDITIONAL_DETAILS_ALLOWED_CHARACTERS_DIGITS; ?>'
						}
					}
            },
			authority: {
				selector: '#shipment_detail',
				container: '#shipment_detail_message',
					validators: {
						notEmpty: {
                            message: '<?php echo ADDITIONAL_DETAILS_FIELD_REQUIRED." ".REQUIRED_TRANSIT_GOODS_DESCRIPTION; ?>'
                        },
						regexp: {
							regexp: /^[a-zA-Z0-9',_.!?\s\-\/]*$/, //message
							message: '<?php echo ADDITIONAL_DETAILS_ILLEGAL_CHARACTERS; ?>'
						}
					}
      },
			export_reason: {
				selector: '#export_reason',
				container: '#export_reason_message',
				validators: {
					notEmpty: {
						message: '<?php echo REQUIRED_ITEM_NAMES; ?>'
					}
				}
			},
			commercial_invoice_provider: {
				selector: '#commercial_invoice_provider',
				container: '#commercial_invoice_provider_message',
				validators: {
					notEmpty: {
						message: '<?php echo REQUIRED_ITEM_NAMES; ?>'
					}
				}
			},
			terms_conditions: {
				selector: '#terms_and_conditions',
				container: '#terms_and_conditions_message',
					validators: {
					notEmpty: {
						message: '<?php echo TERMS_AND_CONDITIONS_REQUIRED; ?>'
					}
				}
			},
			dangerousgood: {
				//selector: '#dangerousgood',
				container: '#dangerousgood_message',
					validators: {
						notEmpty: {
							message: '<?php echo DANGEROUS_GOODS_STATEMENT_REQUIRED; ?>'
						},
					regexp: {
						regexp: /^[0]*$/,
							message: '<?php echo ERROR_DANGEROUS_GOODS_YES; ?>'
						}
					}
			},
		/*	security_statement: {
				selector: '#security_statement',
				container: '#security_statement_message',
					validators: {
						notEmpty: {
							message: '<?php echo DANGEROUS_GOODS_STATEMENT_REQUIRED; ?>'
						}
					}
				},*/
      }
    })
	// On change of transit warrranty text box
	.on('keyup', '[name="transit_warranty_au"]', function() {
		//var delayVal;
		delay(function(){
			//delayVal = "yes";
			//alert('Time elapsed!');
			getTransitPriceData();
		}, 1500 );


	})
	.on('keyup', '[name="goods_description_au"]', function() {
		//var delayVal;
		/*delay(function(){
			//delayVal = "yes";
			//alert('Time elapsed!');
			getTransitPriceData();
		}, 1500 );*/


	});
});
//	**	Authority to leave	** //
function select_authority_option() {
	// Get the checkbox
	var authBox = document.getElementById("select_authority");
	// Get the output text
	var authText = document.getElementById("authority_display");

	// If the checkbox is checked, display the output text
	if (authBox.checked == true){
		authText.style.display = "block";
	} else {
		authText.style.display = "none";
	}


	/* if($('input[name=select_authority]:checked', '#additional-detailsForm').val()=='yes')
	{
		$("#authority_display").css("display", "block");

	}

	if($('input[name=select_authority]:checked', '#additional-detailsForm').val()=='no')
	{
		getTransitPriceData();
		$("#authority_display").css("display", "none");
	} */
}
/****	Commercial Invoice Yes/No	**/
function select_commercial_invoice() {
  // Get the checkbox
  var checkBox = document.getElementById("commercial_invoice");
  // Get the output text
  var text = document.getElementById("commercial_invoice_block");

  // If the checkbox is checked, display the output text
  if (checkBox.checked == true){
    commercial_invoice_block.style.display = "block";
  } else {
    commercial_invoice_block.style.display = "none";
  }
}
/****	Dangerous Goods Yes modal	open **/
$('#dg_yes').on('click', function () {
	//alert("hi S")
   $("#dg_modal").modal('show');
});
/****	Dangerous Goods Yes modal	close **/
$('#dg_return_booking').click(function(){
	$('#dg_yes').prop('checked', false);
	$('small.help-block').css('display', "none");
	//$("#databtn").val('false');
	$("#dg_modal").modal("hide");
});
/*** This function is to unset bookingitem object from session */
$('#dg_booking_cancel').click(function(){

	$("#dg_modal").modal("hide");
	$("#dgDataLossEff").modal("show");
	
});
$('#dgDataLoseNo').click(function(){
	$('#dg_yes').prop('checked', false);
	$('small.help-block').css('display', "none");
	$("#dg_modal").modal("hide");
	$("#dgDataLossEff").modal("hide");

});
$('#dgDataLoseYes').click(function(){
	$("#dgDataLossEff").modal("hide");
	$.ajax({
		type: "POST",
		url: 'related/destroyitems.php',
		data: '',
		success: function(data) {
			window.location.href='booking.php';
		}
	});

});


function removeError(a)
{
	//alert(a);
	$("#"+a).slideUp(400);
}
/*  commented for goods nature
if($("#goods_nature").val() == "other"){
	$(".items_wrapper").show(800);
}else{
	$(".items_wrapper").hide(800);
}
function toggleListDiv(){
	if($("#goods_nature").val() == "other"){
		$(".items_wrapper").show(800);

		}else{

			if(document.getElementById("goods_description_au")){
				document.getElementById("goods_description_au").value = "";
			}
		$(".items_wrapper").hide(800);

	}

}
*/
function getTransitPriceData(){
		var anchorHREF = "<?php echo DIR_HTTP_RELATED.'ajax_get_transit_amount.php?'; ?>";

		if($("#transit_warranty_int").val()!=undefined)
		{
			var goodsValue = $("#transit_warranty_int").val();
			var shippingType = 'commercial';
		}else{
			var goodsValue = $("#transit_warranty_au").val();
			var shippingType = 'personal_effects';
		}


		//var shippingType = $("#goods_nature").val();

		var price = $("#service_rate").val();
		var bookingType = $("#bookingType").val();
		//alert($("#select_transit_warranty").checked);
		if(goodsValue != "" && goodsValue > 0 && $('input[name=select_transit_warranty]:checked', '#additional-detailsForm').val()=='yes'){

			$.ajax({
			   type: "POST",
			   url: anchorHREF,
			   data: 'action=get_transit&bookingType='+bookingType+'&shippingType='+shippingType+'&goodsValue='+goodsValue,
			   success: function(msg){
					if(trim(msg) == 0)
					{
						$("#transit_txt").html('<?php echo Transt_price_not_applicable_high; ?>');
					}
					if (trim(msg) != "Transt_price_not_applicable" && trim(msg) != 0) {

						var transitData 				= msg.split('^^^');
						var totalTransitAmt = transitData[0];
						var withoutGSTTransitAmt = transitData[1];
						$("#without_gst_transit_amount").val(withoutGSTTransitAmt);
						if($("#transit_warranty_au").val()!=undefined)
						{
							warrenty_price = eval(parseFloat(price) + parseFloat(totalTransitAmt));
							$("#original_price").html( warrenty_price.toFixed(2));
							$("#transit_txt").html("$ "+ totalTransitAmt);
						}
						if($("#transit_warranty_int").val()!=undefined)
						{
							warrenty_price = eval(parseFloat(price) + parseFloat(totalTransitAmt));
							$("#original_price").html( warrenty_price.toFixed(2));
							$("#transit_txt").html("$ "+ totalTransitAmt);
						}
						$("#transit_txt").html("$ " + totalTransitAmt);
						}else{

							$("#original_price").html(parseFloat(price));
							$("#transit_warranty_au").val("");
							$("#transit_warranty_int").val("");
							if(trim(msg) != 0)
							$("#transit_txt").html("$ "+ totalTransitAmt);
						}
					}
			});
		}else{
			unsetCalc();
		}
}

function confirmTransitPolicy()
{
	if($('#displayTransit').attr('id')!=undefined){
		document.getElementById("displayTransit").style.display="none";
	}
		document.getElementById("boxTransit").style.display="none";

	if($('input[name=select_transit_warranty]:checked', '#additional-detailsForm').val()=='yes')
	{

		document.getElementById("boxTransit").style.display="block";

		if($('#displayTransit').attr('id')!=undefined){
			document.getElementById("displayTransit").style.display="block";
		}
		$('#additional-detailsForm').bootstrapValidator('enableFieldValidators', 'customs_value');
		$('#additional-detailsForm').bootstrapValidator('revalidateField', 'customs_value');

		var shippingType = $("#goods_nature").val();

		if(shippingType == ""){

			$('#additional-detailsForm').bootstrapValidator('revalidateField', 'item_type');

		}else{
			//alert("inside this");
			getTransitPriceData();
		}
	}else{

		unsetCalc();
	}

}
function display_value_goods(price,min_transient_amt,minimum_charge)
{

	if(document.getElementById("select_transit_warranty").checked==true)
	{
		document.getElementById("transit_display").style.display="block";


	}
	if(document.getElementById("select_transit_warranty").checked==false)
	{
		if(document.getElementById("original_amount").value!="")
		{
			price=document.getElementById("original_amount").value;
		}


		document.getElementById("displayTransit").style.display="none";
		document.getElementById("original_price").innerHTML = price;
	}
}
var delay = (function(){
  var timer = 0;
  return function(callback, ms){
    clearTimeout (timer);
    timer = setTimeout(callback, ms);
  };
})();
</script>
