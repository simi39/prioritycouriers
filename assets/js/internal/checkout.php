<script type="text/javascript">
function lightbox_display()
{

	document.getElementById('oldpage').value ="<?php echo $_SESSION['lightpage'];?>";
	document.getElementById('light').style.display='block';
	document.getElementById('fade').style.display='block';
}

function enableRedeem()
{
		if($("#coupon_code").val() == "")
 		{
  		document.getElementById("redeem").disabled = true;
 		}else{
  		document.getElementById("redeem").disabled = false;
 		}

}

</script>

<script type="text/javascript">
function get_coupon_code_status(userId)
	{
		//var xmlhttp;

		var btnCoupon = $("#redeem").val();
		//alert(btnCoupon);
		if($("#redeem").val() == "Redeem")
		{
			$("#redeem").html("Reset");
			$("#redeem").val("Reset");
			$("#coupon_code").attr('readonly', true);

		}else{
			$("#redeem").html("Redeem");
			$("#redeem").val("Redeem");
			$("#coupon_code").val("");
			$("#coupon_code").attr('readonly', false);
		}
		var user_input_code = $("#coupon_code").val();

		if(user_input_code == "")
		{
			$('#discountDisplay').hide('slow');
			$("#discount_amount").html('0.00');
			$("#net_due_amt").html('0.00');
			var total_new_charges = parseFloat($("#old_base_delivery_fee").val())+parseFloat($("#old_fuel_fee").val())+parseFloat($("#without_gst_coverage_rate").val());
			$("#total_new_charges").html(total_new_charges);
			var total_gst = parseFloat($("#old_total_gst_delivery").val())+parseFloat($("#old_total_transit_gst").val());
			$("#total_gst").html(total_gst);
			$("#total_gst_delivery").html("$"+$("#old_total_gst_delivery").val());
			$("#total_delivery_fee").html($("#old_total_delivery_fee").val());
			//alert($("#old_total_due_amt").val());

			if(isNaN(total_new_charges))
			{
				var total_due = parseFloat($("#old_total_delivery_fee").val());

			}else{
				var total_due = parseFloat(total_new_charges)+parseFloat(total_gst);

			}
			$("#total_due_amt").html("$"+parseFloat(total_due).toFixed(2));


			$("#payment_amt").val(parseFloat(total_due).toFixed(2));
			$("#vpc_Amount").val(total_due*100);
		}
		var due_amt 		= "<?php echo filter_var($_SESSION['due_amt'],FILTER_VALIDATE_FLOAT); ?>";
		var transit_amt 	= "<?php echo filter_var($_SESSION['coverage_rate'],FILTER_VALIDATE_FLOAT); ?>";
		var gst             = "<?php echo filter_var($_SESSION['total_gst'],FILTER_VALIDATE_FLOAT); ?>";

		var anchorHREF		= 'related/get_coupon_code_price.php?';
		/*
		if(user_input_code.match(/^\s*$/)) {
    		$("#couponError").html("Enter valid coupon code");
    		return false;
		}else{
			$("#couponError").html("");
		}
		if(user_input_code.length>16){
			$("#couponError").html("Enter valid coupon code");
    		return false;
		}else{
			$("#couponError").html("");
		}
		*/
		$.ajax({
		   type: "POST",
		   url: anchorHREF,
		   data: 'Action=calculate&couponCode='+user_input_code+'&btnCoupon='+btnCoupon,
		   success: function(msg){

		   if(msg != 0){
					//$('#discountDisplay').css('display') ='block';
					if($('#discountDisplay').css('display') == 'none'){
					   $('#discountDisplay').show('slow');
					} else {
					   $('#discountDisplay').hide('slow');
					}

		   			var couponData 				= msg.split('^^^');
					var coupon_discount			= parseFloat(couponData[0]).toFixed(2);
					var nett_due_amount			= parseFloat(couponData[1]).toFixed(2);

					var total_fuel_charges		= parseFloat(couponData[2]).toFixed(2);
					var total_gst_delivery		= parseFloat(couponData[3]).toFixed(2);
					var total_delivery_fee		= parseFloat(couponData[4]).toFixed(2);
					var total_new_charges		= parseFloat(couponData[5]).toFixed(2);
					var total_gst		= parseFloat(couponData[6]).toFixed(2);
					var total_due_charges		= parseFloat(couponData[7]).toFixed(2);


					var total_transit_delivery_gst = parseFloat(total_gst);

					$("#discount_amount").html(coupon_discount);
					$("#base_delivery_fee").html("$"+nett_due_amount);
					$("#fuel_surcharge").html("$"+total_fuel_charges);
					//$("#net_due_amt").html(nett_due_amount);


					var new_charges = parseFloat(total_new_charges).toFixed(2);

					$("#total_new_charges").html("$"+new_charges);

					//var due_charges = parseFloat(total_transit_delivery_gst)+parseFloat(new_charges);
					$("#total_due_amt").html("$"+parseFloat(total_due_charges).toFixed(2));
					$("#total_delivery_fee").html("$"+total_delivery_fee);
					$("#total_gst_delivery").html("$"+total_gst_delivery);
					$("#total_gst").html("$"+total_gst);
					//var total_new_charges = parseFloat($("#old_base_delivery_fee").val())+parseFloat($("#old_fuel_fee").val())+parseFloat($("#without_gst_coverage_rate").val());
					$("#total_new_charges").html("$"+parseFloat(total_new_charges).toFixed(2));
					//var total_gst = parseFloat($("#old_total_gst_delivery").val())+parseFloat($("#old_total_transit_gst").val());
					$("#total_gst").html("$"+parseFloat(total_gst).toFixed(2));
					$("#payment_amt").val(total_due_charges);
					$("#vpc_Amount").val(total_due_charges*100);
					$("#tvalid").val(1);
					//$("#total_gst_delivery_transit").html("$"+parseFloat(total_transit_delivery_gst).toFixed(2));

				}else{

					$('#discountDisplay').hide('slow');
					$("#discount_amount").html('0.00');

					//$("#net_due_amt").html('0.00');
					$("#base_delivery_fee").html("$"+$("#old_base_delivery_fee").val());
					$("#fuel_surcharge").html("$"+$("#old_fuel_fee").val());
					//$("#total_new_charges").html("$"+$("#old_total_new_charges").val());
					//$("#total_due_amt").html("$"+$("#old_total_due_amt").val());
					var total_new_charges = parseFloat($("#old_base_delivery_fee").val())+parseFloat($("#old_fuel_fee").val())+parseFloat($("#without_gst_coverage_rate").val());
					$("#total_new_charges").html(parseFloat(total_new_charges).toFixed(2));
					var total_gst = parseFloat($("#old_total_gst_delivery").val())+parseFloat($("#old_total_transit_gst").val());
					$("#total_gst").html("$"+parseFloat(total_gst).toFixed(2));
					$("#total_delivery_fee").html("$"+$("#old_total_delivery_fee").val());
					$("#total_gst_delivery").html("$"+$("#old_total_gst_delivery").val());
					//alert(isNaN(total_new_charges));
					if(isNaN(total_new_charges))
					{

						var total_due = parseFloat($("#old_total_delivery_fee").val());
					}else{

						if(isNaN(total_gst))
						{
							/* When international gst is absent */
							var total_due = parseFloat(total_new_charges);

						}else{
							var total_due = parseFloat(total_new_charges)+parseFloat(total_gst);
						}


					}
					$("#total_due_amt").html("$"+parseFloat(total_due).toFixed(2));

					$("#payment_amt").val(parseFloat(total_due).toFixed(2));
					$("#vpc_Amount").val(total_due*100);
					$("#total_gst_delivery_transit").html("$"+$("#old_total_gst_delivery_transit").val());
					$("#couponError").html("Enter valid coupon code or leave the filed empty");
				}
	  		 }
			});
	}



$(document).ready(function() {
    $('#checkout')
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
		excluded: [':disabled', ':hidden'],
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },

        fields: {
			checkout_couponcode: {
				selector: '#coupon_code',
				container: '#coupon_code_message',
					validators: {
						regexp: {
							regexp: /^[a-zA-Z0-9]*$/,
							message: '<?php echo CHECKOUT_ILLEGAL_CHARACTERS; ?>'
						},
						stringLength: {
							max:12,
                        	message: '<?php echo CHECKOUT_CODE_LENGTH; ?>'
                    	}
					}
            }

        }

    })
	.on('success.form.bv', function(e) {
       var $form        = $(e.target),     // Form instance
		// Get the clicked button
		$button      = $form.data('bootstrapValidator').getSubmitButton(),
		// You might need to update the "status" field before submitting the form
		$statusField = $form.find('[name="status"]');
		// To demonstrate which button is clicked,
		// I use Bootbox (http://bootboxjs.com/) to popup a simple message
		// You might don't need to use it in real application
		run_waitMe('win8_linear');
		//return false;
		switch ($button.attr('id')) {
			case 'paynow':
				$statusField.val('paynow');
				break;
			case 'paypal':
			default:
				$statusField.val('paypal');
				break;
		}



	});


});
function editBooking()
{
	//$("#dataLossEff").modal('show');
	//$('#dataLoseClose').click(function(e){
		document.location='<?php echo show_page_link(FILE_BOOKING)."?Action=edit";?>';
		e.preventDefault();
	//});
}
/*
$('#closemodal').click(function(e){
	console.log("close button is clicked");
	document.location='<?php echo show_page_link(FILE_CHECKOUT);?>';
	e.preventDefault();
});*/
function cancelBooking()
{
	$("#dataLossEff").modal('show');
	$('#dataLoseClose').click(function(e){
		$.ajax({
			type: "POST",
			url: 'related/destroyitems.php',
			data: '',
			success: function(data) {
				document.location='<?php echo show_page_link(FILE_BOOKING);?>';
				e.preventDefault();
			}
		});
	});
}

</script>
<?php if(isset($_GET['mode']) && $_GET['mode'] == 'cancel'){ ?>
<script>
$(document).ready(function() {
	$("#paymentCancel").modal('show');
	$('#closepaymentcancel').click(function (){
		console.log("close button is clicked");
		$("#paymentCancel").modal('hide');
	});
});
</script>
<?php } ?>
<?php if(isset($_GET["vpc_TxnResponseCode"]) && $_GET["vpc_TxnResponseCode"]!="0"){ ?>
<script>
$("#anzacPaymentCancel").modal('show');
$('#anzacCloseModal').click(function(){
	$("#anzacPaymentCancel").modal('hide');
});
</script>
<?php } if (isset($addresserror) && $addresserror!=""){?>
<script>
$("#AddressError").modal('show');
</script>
<?php } ?>
