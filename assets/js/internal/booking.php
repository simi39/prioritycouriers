<script type="text/javascript">
/*Below lines i am commenting because we have removed calendar from
* booking page. 28 Jan 2020 by smita
*/

var ind = 2;
var Qty = $("#aus_total_qty").val();
var lastRow = $("#last_inserted_cell_australia").val();
if(lastRow!=1){
	var ind = 3;
}
//console.log($('#selShippingType_<?php //echo filter_var($i,FILTER_VALIDATE_INT); ?>').children('option:selected').val())
//console.log("selectbox:"+$('select[name="selShippingType[]"] option:selected').val());
//display_size($('select[name="selShippingType[]"] option:selected').val(),'1');
$('.add_field_button').click(function (){
	//console.log("clicked add button for domestic");
	//ValidateBookingForm();
	if(checkValidation() == true){
		var $template = $('#optionTemplate'),
			$clone    = $template
							.clone()
							.removeClass('hide')
							.removeAttr('id')
							.insertBefore($template),
			$divId       = $clone.find('.controls-row').attr('id', ind);
			$seldiv      = $clone.find('[id="servicePageItem_1"]').attr('id', 'servicePageItem_' + ind);
			$selTxt   	 = $clone.find('[name="selShippingType[]"]');
			$selId       = $clone.find('[id="selShippingType_1"]').attr('id', 'selShippingType_' + ind);
			$selSpan     = $clone.find('[id="selShippingTypes_1"]').attr('id', 'selShippingTypes_' + ind);
			/* Below line is commented by smita 7/52021 because with latest validation we don't need validation setup based on 
			*	select type
			*/
			//$seldisSpan     = $clone.find('[onchange="return display_size(this.value,1)"]').attr('onchange', 'return display_size(this.value,'+ind+')' );
			$seldisVal     =$clone.find('[id="selShippingTypes_1"]').eq(ind).val();
			
			$qtyTxt      = $clone.find('[name="Item_qty[]"]');
			$qtyId       = $clone.find('[id="Item_qty_1"]').attr('id', 'Item_qty_' + ind);
			$qtySpan     = $clone.find('[id="Items_qty_1"]').attr('id', 'Items_qty_' + ind);


			$weightTxt   = $clone.find('[name="Item_weight[]"]');
			$weightId    = $clone.find('[id="Item_weight_1"]').attr('id', 'Item_weight_' + ind);
			$weightSpan  = $clone.find('[id="Items_weight_1"]').attr('id', 'Items_weight_' + ind);
			$weightkeyup   = $clone.find('[name="Item_weight[]"]').attr('onkeyup','numberDecimal(this.value,"Item_weight_'+ind+'","booking")');
			//$seldisSpan     = $clone.find('[onchange="return display_size(this.value,1)"]').attr('onchange', 'return display_size(this.value,'+ind+')' );
			//console.log("weight span:"+$clone.find('[onkeyup="return numberDecimal(this.value,Item_weight_1,booking);"]'));
			$lengthTxt   = $clone.find('[name="Item_length[]"]');
			$lengthId    = $clone.find('[id="Item_length_1"]').attr('id', 'Item_length_' + ind);
			$lengthSpan  = $clone.find('[id="Items_length_1"]').attr('id', 'Items_length_' + ind);
			$widthTxt    = $clone.find('[name="Item_width[]"]');
			$widthId     = $clone.find('[id="Item_width_1"]').attr('id', 'Item_width_' + ind);
			$widthSpan   = $clone.find('[id="Items_width_1"]').attr('id', 'Items_width_' + ind);
			$heightTxt   = $clone.find('[name="Item_height[]"]');
			$heightId     = $clone.find('[id="Item_height_1"]').attr('id', 'Item_height_' + ind);
			$heightSpan  = $clone.find('[id="Items_height_1"]').attr('id', 'Items_height_' + ind);
			/*$qtyMaxHidden = $clone.find('[id="qty_max_1"]').attr('id', 'qty_max_' + ind);
			$qtyMinHidden = $clone.find('[id="qty_min_1"]').attr('id', 'qty_min_' + ind);
			$weightMaxHidden = $clone.find('[id="weight_max_1"]').attr('id', 'weight_max_' + ind);
			$weightMinHidden = $clone.find('[id="weight_min_1"]').attr('id', 'weight_min_' + ind);
			$lengthMaxHidden = $clone.find('[id="length_max_1"]').attr('id', 'length_max_' + ind);
			$lengthMinHidden = $clone.find('[id="length_min_1"]').attr('id', 'length_max_' + ind);
			$widthMaxHidden = $clone.find('[id="width_max_1"]').attr('id', 'width_max_' + ind);
			$widthMinHidden = $clone.find('[id="width_min_1"]').attr('id', 'width_min_' + ind);
			$heightMaxHidden = $clone.find('[id="height_max_1"]').attr('id', 'height_max_' + ind);
			$heightMinHidden = $clone.find('[id="height_min_1"]').attr('id', 'height_min_' + ind);*/
			/*$lengthMaxHidden = $clone.find('[id="length_max_1"]').attr('id', 'length_max_' + ind);
			$lengthMaxHidden_1 = $clone.find('[id="length_max_"]').attr('id', 'length_max_' + ind);
			$girthMaxHidden = $clone.find('[id="girth_max_1"]').attr('id', 'girth_max_' + ind);*/
			$delSpan     = $clone.find('[class="removeButton"]').attr('onclick', 'javascript:DelSizeDataRow('+ind+')');

		// Add new field
		$('#booking').bootstrapValidator('addField', $qtySpan);
		$('#booking').bootstrapValidator('addField', $qtyId);
		$('#booking').bootstrapValidator('addField', $qtyTxt);
		$('#booking').bootstrapValidator('addField', $selSpan);
		//$('#booking').bootstrapValidator('addField', $seldisSpan);
		$('#booking').bootstrapValidator('addField', $seldisVal);
		$('#booking').bootstrapValidator('addField', $selId);
		$('#booking').bootstrapValidator('addField', $selTxt);
		$('#booking').bootstrapValidator('addField', $weightSpan);
		$('#booking').bootstrapValidator('addField', $weightkeyup);
		$('#booking').bootstrapValidator('addField', $weightId);
		$('#booking').bootstrapValidator('addField', $weightTxt);
		
		$('#booking').bootstrapValidator('addField', $lengthTxt);
		$('#booking').bootstrapValidator('addField', $lengthId);
		$('#booking').bootstrapValidator('addField', $lengthSpan);
		$('#booking').bootstrapValidator('addField', $widthTxt);
		$('#booking').bootstrapValidator('addField', $widthId);
		$('#booking').bootstrapValidator('addField', $widthSpan);
		
		$('#booking').bootstrapValidator('addField', $heightTxt);
		$('#booking').bootstrapValidator('addField', $heightId);
		$('#booking').bootstrapValidator('addField', $heightSpan);
		$("#last_inserted_cell_australia").val(ind);


		ind++;
		Qty++;
		//alert(Qty);
		display_total_value();
	}else{
		$('#booking').data('bootstrapValidator').validate();
	}
});

/* Add button for international */
var interind = 2;
var lastInterRow = $("#last_inserted_cell_inter").val();

if(lastInterRow!=1){
	var interind = 3;
}

$('.add_inter_button').click(function (){
//ValidateBookingForm();
if(checkInterValidation() == true){
var $interTemplate = $('#optionIntTemplate'),
	$interclone    = $interTemplate
					.clone()
					.removeClass('hide')
					.removeAttr('id')
					.insertBefore($interTemplate),
	$divId       = $interclone.find('.controls-row').attr('id', interind);

	$qtyIntSpan  = $interclone.find('[id="qty_items_1"]').attr('id', 'qty_items_' + interind);
	$qtyIntId    = $interclone.find('[id="qty_item_1"]').attr('id', 'qty_item_' + interind);
	$qtyIntTxt   = $interclone.find('[name="qty_item[]"]');
	$weightIntSpan  = $interclone.find('[id="weight_items_1"]').attr('id', 'weight_items_' + interind);
	$weightIntId    = $interclone.find('[id="weight_item_1"]').attr('id', 'weight_item_' + interind);
	$weightIntkeyup   = $interclone.find('[name="weight_item[]"]').attr('onkeyup','numberDecimal(this.value,"weight_item_'+ind+'","booking")');
	$weightIntTxt   = $interclone.find('[name="weight_item[]"]');
	$lengthIntTxt   = $interclone.find('[name="length_item[]"]');
	$lengthIntId    = $interclone.find('[id="length_item_1"]').attr('id', 'length_item_' + interind);
	$lengthIntSpan  = $interclone.find('[id="length_items_1"]').attr('id', 'length_items_' + interind);
	$widthIntTxt    = $interclone.find('[name="width_item[]"]');
	$widthIntId     = $interclone.find('[id="width_item_1"]').attr('id', 'width_item_' + interind);
	$widthIntSpan   = $interclone.find('[id="width_items_1"]').attr('id', 'width_items_' + interind);
	$heightIntTxt   = $interclone.find('[name="height_item[]"]');
	$heightIntId     = $interclone.find('[id="height_item_1"]').attr('id', 'height_item_' + interind);
	$heightIntSpan  = $interclone.find('[id="height_items_1"]').attr('id', 'height_items_' + interind);
	$delIntSpan  = $interclone.find('[class="removeButton"]').attr('onclick', 'javascript:DelSizeDataRow('+interind+')');


// Add new field
$('#booking').bootstrapValidator('addField', $qtyIntSpan);
$('#booking').bootstrapValidator('addField', $qtyIntId);
$('#booking').bootstrapValidator('addField', $qtyIntTxt);

$('#booking').bootstrapValidator('addField', $weightIntSpan);
$('#booking').bootstrapValidator('addField', $weightIntId);
$('#booking').bootstrapValidator('addField', $weightIntTxt);

$('#booking').bootstrapValidator('addField', $lengthIntTxt);
$('#booking').bootstrapValidator('addField', $lengthIntId);
$('#booking').bootstrapValidator('addField', $lengthIntSpan);

$('#booking').bootstrapValidator('addField', $widthIntTxt);
$('#booking').bootstrapValidator('addField', $widthIntId);
$('#booking').bootstrapValidator('addField', $widthIntSpan);
$('#booking').bootstrapValidator('addField', $weightIntkeyup);

$('#booking').bootstrapValidator('addField', $heightIntTxt);
$('#booking').bootstrapValidator('addField', $heightIntId);
$('#booking').bootstrapValidator('addField', $heightIntSpan);
$("#last_inserted_cell_inter").val(interind);
interind++;
totalInterVal();
}else{
	//ValidateBookingForm();
	$('#booking').data('bootstrapValidator').validate();
}
});

/* Add button for international */



/*
$('#next').click(function (){
	//ValidateBookingForm();
	checkpackage();
	var validator = $('[id*=booking]').data('bootstrapValidator');
	validator.validate();
	// return validator.isValid();
});
*/
//function ValidateBookingForm() {
$(document).ready(function(){
    	$('#booking').bootstrapValidator({
            feedbackIcons: {
                /*valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'*/
                valid: 'glyphicon',
                invalid: 'glyphicon',
                validating: 'glyphicon'
            },
            fields: {
				pickup:{
					selector: '#pickup',
					container: "#pickupResult",
					validators: {
						notEmpty: {
								message: '<?php echo SELECT_PICKUP_ITEM; ?>'
						},

						regexp: {
							regexp: /^[a-zA-Z0-9\s-]*$/, //lowercase, upercase, apostrophe, space
							message: '<?php echo BOOKING_ILLEGAL_CHARACTERS."<br />".BOOKING_ALLOWED_CHARACTERS_FROMTO; ?>'
						},
						callback: {
							message: '<?php echo SELECT_PICKUP_ITEM; ?>',
							callback: function (value, validator, $field) {
								var selecttype= $('select[name="selShippingType[]"] option:selected').val();
								var deliver = $('#deliver').val();
								if(value != "" && selecttype != "" && deliver !=""){
									$("input[name='Item_weight[]']").prop("disabled", false);
									$("input[name='Item_length[]']").prop("disabled", false);
									$("input[name='Item_width[]']").prop("disabled", false);
									$("input[name='Item_height[]']").prop("disabled", false);

								}

								return true;
							}
						},
						/*remote: {
							url: '<?php //echo DIR_HTTP_RELATED."tms_index.php"; ?>',
							data: function(validator) {
								return {
								chksuburb:true,
								letters: validator.getFieldElements('pickup').val()
								};
							},
							message: '<?php //echo YOUR_SUBURB_NOT_FOUND; ?>'
						}*/
						
					}
				},
				deliver:{
					selector: '#deliver',
					container: "#deliverResult",
					validators: {
						notEmpty: {
								message: '<?php echo SELECT_PICKUP_ITEM; ?>'
						},

						regexp: {
							regexp: /^[a-zA-Z0-9\s-]*$/, //lowercase, upercase, apostrophe, space
							message: '<?php echo BOOKING_ILLEGAL_CHARACTERS."<br />".BOOKING_ALLOWED_CHARACTERS_FROMTO; ?>'
						},
						callback: {
							message: '<?php echo SELECT_PICKUP_ITEM; ?>',
							callback: function (value, validator, $field) {
								var selecttype= $('select[name="selShippingType[]"] option:selected').val();
								var pickkup = $('#pickup').val();
								console.log("deliver value:"+$('#deliver').val());
								if(value != "" && selecttype != "" && pickkup !=""){
									$("input[name='Item_weight[]']").prop("disabled", false);
									$("input[name='Item_length[]']").prop("disabled", false);
									$("input[name='Item_width[]']").prop("disabled", false);
									$("input[name='Item_height[]']").prop("disabled", false);

								}

								return true;
							}
						},
						/*remote: {
							url: '<?php echo DIR_HTTP_RELATED."tms_index.php"; ?>',
							data: function(validator) {
								return {
								chksuburb:true,
								letters: validator.getFieldElements('deliver').val()
								};
							},
							message: '<?php echo YOUR_SUBURB_NOT_FOUND; ?>'
						}*/
					}
				},
				intercountry:{
					selector: '#inter_country',
					container: '#changed_cntry_message',
					validators: {
						notEmpty: {
							message: '<?php echo INDEX_COUNTRY_REQUIRED; ?>'
						}
					}
				},

				'qty_item[]': {
					validators: {
						notEmpty: {
							message: '<?php echo COMMON_EMPTY_FIELD; ?>'
						},
						regexp: {
							regexp: /^[0-9]*$/, //lowercase, upercase, apostrophe, space
							message: '<?php echo BOOKING_ILLEGAL_CHARACTERS."<br />".BOOKING_ALLOWED_CHARACTERS_DIGITS; ?>'
						},

						callback: {
							message: 'Quantity must be greater than 1',
							callback: function (value, validator, $field) {

								if(parseFloat(value)<1)
								{
									return {
										valid: false,
										message: "Quantity must be greater than 1"
									};
								}

								return true;
							}
						}
					}
				},

				'weight_item[]': {
						validators: {
							notEmpty: {
								message: '<?php echo COMMON_EMPTY_FIELD; ?>'
							},
							regexp: {
								regexp: /^\d*?(\.\d{0,1})?$/, //integers,and after decimal point only one digit
								message: '<?php echo BOOKING_ILLEGAL_CHARACTERS."<br />".BOOKING_ALLOWED_WEIGHT_CHARACTERS_DIGITS; ?>'
							},

							callback: {
								message: 'Weight must be greater than 1',
								callback: function (value, validator, $field) {
								if(parseFloat(value) < 1)
									{
										return {
											valid: false,
											message: "Weight must be greater than 1"
										};
									}
									return true;
								}
							}
						}
				},

				'length_item[]': {
					validators: {
						notEmpty: {
							message: '<?php echo COMMON_EMPTY_FIELD; ?>'
						},
						regexp: {
							regexp: /^[0-9]*$/, //lowercase, upercase, apostrophe, space
							message: '<?php echo BOOKING_ILLEGAL_CHARACTERS."<br />".BOOKING_ALLOWED_CHARACTERS_DIGITS; ?>'
						},

						callback: {
							message: 'Length must be greater than 1',
							callback: function (value, validator, $field) {
								var length_max = parseFloat($("#int_length_max_1").val());
								var selId = $field.attr('id');
								var idArr = selId.split("_");
								var id = idArr[2];
								var girthLength = parseFloat($("#length_item_"+id).val());
								var girthWidth = parseFloat($("#width_item_"+id).val());
								var girthHeight = parseFloat($("#height_item_"+id).val());
								var maxGirth = parseFloat($("#int_girth_max_1").val());
								var totalGirth = (girthLength+(2*girthWidth)+(2*girthHeight));
								console.log("international length:"+ length_max+"girth:"+totalGirth);
								if(parseFloat(value) < 1)
								{
									return {
										valid: false,
										message: "Length must be greater than 1"
									};
								}
								if(value>length_max){
									return {
										valid: false,
										message: "Length is too long"
									};
								}
								if(totalGirth>maxGirth){
									//$('#booking').data('bootstrapValidator').resetField("#height_item_"+id,true);
									return {
										valid: false,
										message: "Sorry we can't accept these dimensions because Girth is:"+maxGirth
									};
								}
								
								return true;
							}
						}

					}
				},
				'width_item[]': {
					validators: {
						notEmpty: {
							message: '<?php echo COMMON_EMPTY_FIELD; ?>'
						},
						regexp: {
							regexp: /^[0-9]*$/, //lowercase, upercase, apostrophe, space
							message: '<?php echo BOOKING_ILLEGAL_CHARACTERS."<br />".BOOKING_ALLOWED_CHARACTERS_DIGITS; ?>'
						},

						callback: {
							message: 'Width must be greater than 1',
							callback: function (value, validator, $field) {
								var selId = $field.attr('id');
								var idArr = selId.split("_");
								var id = idArr[2];
								var girthLength = parseFloat($("#length_item_"+id).val());
								var girthWidth = parseFloat($("#width_item_"+id).val());
								var girthHeight = parseFloat($("#height_item_"+id).val());
								var maxGirth = parseFloat($("#int_girth_max_1").val());
								var totalGirth = (girthLength+(2*girthWidth)+(2*girthHeight));
								if(parseFloat(value)<1)
								{
									return {
										valid: false,
										message: "Width must be greater than 1"
									};
								}
								if(totalGirth>maxGirth){
									return {
										valid: false,
										message: "Sorry we can't accept these dimensions because Girth is:"+maxGirth
									};
								}
								return true;
							}
						}

					}
				},
				'height_item[]': {
					validators: {
						notEmpty: {
							message: '<?php echo COMMON_EMPTY_FIELD; ?>'
						},
						regexp: {
							regexp: /^[0-9]*$/, //lowercase, upercase, apostrophe, space
							message: '<?php echo BOOKING_ILLEGAL_CHARACTERS."<br />".BOOKING_ALLOWED_CHARACTERS_DIGITS; ?>'
						},

						callback: {
							message: 'Height must be greater than 1',
							callback: function (value, validator, $field) {
								var selId = $field.attr('id');
								var idArr = selId.split("_");
								var id = idArr[2];
								var girthLength = parseFloat($("#length_item_"+id).val());
								var girthWidth = parseFloat($("#width_item_"+id).val());
								var girthHeight = parseFloat($("#height_item_"+id).val());
								var maxGirth = parseFloat($("#int_girth_max_1").val());
								var totalGirth = (girthLength+(2*girthWidth)+(2*girthHeight));
								console.log("international");
								console.log("length:"+$("#length_item_"+id).val());
								console.log("width:"+$("#width_item_"+id).val());
								console.log("height:"+$("#height_item_"+id).val()+"this value:"+value+"id:"+id);
								console.log("max girth:400"+"toal girth:"+(girthLength+(2*girthWidth)+(2*girthHeight)));
								if(parseFloat(value)<1)
								{
									return {
										valid: false,
										message: "Height must be greater than1"
									};
								}
								if(totalGirth>maxGirth){
									return {
										valid: false,
										message: "Sorry we can't accept these dimensions because Girth is:"+maxGirth
									};
								}
								return true;
							}
						}

					}
				},
				'Item_qty[]': {
						validators: {
							notEmpty: {
								message: '<?php echo COMMON_EMPTY_FIELD; ?>'
							},
							regexp: {
								regexp: /^[0-9]*$/, //lowercase, upercase, apostrophe, space
								message: '<?php echo BOOKING_ILLEGAL_CHARACTERS."<br />".BOOKING_ALLOWED_CHARACTERS_DIGITS; ?>'
							},
							callback: {
							message: 'Quantity between %s and %s',
							callback: function (value, validator, $field) {

								/*var selId = $field.attr('id');
								var idArr = selId.split("_");
								var id = idArr[2];
								var qty_max = parseFloat($("#qty_max_"+id).val());
								var qty_min = parseFloat($("#qty_min_"+id).val());
								*/
								if(parseFloat(value) == 0)
								{
									return {
										valid: false,
										message: "Quantity must be greater than zero"
									};
								}
								/*if(parseFloat(value)>qty_max || parseFloat(value)<qty_min)
								{
									return {
										valid: false,
										message: "Quantity must be between "+qty_min+" and "+qty_max
									};
								}*/

								return true;
								}
							}

						}
				},

				'Item_weight[]': {
						validators: {
							notEmpty: {
								message: '<?php echo COMMON_EMPTY_FIELD; ?>'
							},
							regexp: {
								regexp: /^\d*?(\.\d{0,1})?$/, //integers,and after decimal point only one digit
								message: '<?php echo BOOKING_ILLEGAL_CHARACTERS."<br />".BOOKING_ALLOWED_WEIGHT_CHARACTERS_DIGITS; ?>'
							},

							callback: {
								message: 'Weight between %s and %s',
								callback: function (value, validator, $field) {
									// Determine the numbers which are [name="Item_qty[]"]generated in captchaOperation
									var selId = $field.attr('id');
									var idArr = selId.split("_");
								    var id = idArr[2];

									/*var weight_max = parseFloat($("#weight_max_"+id).val());
									var weight_min = parseFloat($("#weight_min_"+id).val());
									
									
									//console.log("inside call back funciton of validation weight:"+weight_max);
									/*var pickup = $("#pickup").val();
									
									if(pickup == ""){
										$('#booking').bootstrapValidator('revalidateField', 'pickup');
										//value ="";
										$field.prop("disabled", true);
									}

									var deliver = $("#deliver").val();
									if(deliver == ""){
										$('#booking').bootstrapValidator('revalidateField', 'deliver');
										$field.prop("disabled", true);
									}
									var selecttype= $('select[name="selShippingType[]"] option:selected').val();
									//alert(selecttype);
									if(selecttype == ""){
										$('#booking').bootstrapValidator('revalidateField', 'selShippingType[]');
										$field.prop("disabled", true);
									}
									*/
									if(parseFloat(value) == 0)
									{
										return {
											valid: false,
											message: "Weight must be greater than zero"
										};
									}

									/*if(parseFloat(value)>weight_max || parseFloat(value)<weight_min)
									{

										return {
											valid: false,
											message: "Weight must be between "+weight_min+" and "+weight_max
										};
									}*/
									return true;

								}
							}
						}
				},

				'Item_length[]': {
						validators: {
							notEmpty: {
								message: '<?php echo COMMON_EMPTY_FIELD; ?>'
							},
							regexp: {
								regexp: /^[0-9]*$/, //lowercase, upercase, apostrophe, space
								message: '<?php echo BOOKING_ILLEGAL_CHARACTERS."<br />".BOOKING_ALLOWED_CHARACTERS_DIGITS; ?>'
							},

							callback: {
								message: 'Length between %s and %s',
								callback: function (value, validator, $field) {
									// Determine the numbers which are [name="Item_qty[]"]generated in captchaOperation
									var selId = $field.attr('id');
									var idArr = selId.split("_");
								    var id = idArr[2];
									var length_max = parseFloat($("#length_max_1").val());
									console.log("length max:"+length_max);
									//var length_min = parseFloat($("#length_min_"+id).val());
									var girthLength = parseFloat($("#Item_length_"+id).val());
									var girthWidth = parseFloat($("#Item_width_"+id).val());
									var girthHeight = parseFloat($("#Item_height_"+id).val());
									var maxGirth = parseFloat($("#girth_max_1").val());
									var totalGirth = (girthLength+(2*girthWidth)+(2*girthHeight));
									var selShippingType = $("#selShippingType_"+id).val();
									console.log("total girth:"+totalGirth+"shipping type"+"#selShippingType_"+id+":"+selShippingType);
									/*var pickup = $("#pickup").val();
									
									if(pickup == ""){
										$('#booking').bootstrapValidator('revalidateField', 'pickup');
										//value ="";
										$field.prop("disabled", true);
									}

									var deliver = $("#deliver").val();
									if(deliver == ""){
										$('#booking').bootstrapValidator('revalidateField', 'deliver');
										$field.prop("disabled", true);
									}
									var selecttype= $('select[name="selShippingType[]"] option:selected').val();
									//alert(selecttype);
									if(selecttype == ""){
										$('#booking').bootstrapValidator('revalidateField', 'selShippingType[]');
										$field.prop("disabled", true);
									}
									*/
									
									if(parseFloat(value) == 0)
									{
										return {
											valid: false,
											message: "Length must be greater than zero"
										};
									}
									if(parseFloat(value)>length_max && selShippingType != '43') // Type is pallet
									{
										return {
											valid: false,
											message: "Length must be less than "+length_max
										};
									}
									if(totalGirth>maxGirth && selShippingType != '43'){
										return {
											valid: false,
											message: "Sorry we can't accept these dimensions because Girth is:"+maxGirth
										};
									}
									return true;
								}
							}
						}
				},

				'Item_width[]': {
					validators: {
						notEmpty: {
							message: '<?php echo COMMON_EMPTY_FIELD; ?>'
						},
						regexp: {
								regexp: /^[0-9]*$/, //lowercase, upercase, apostrophe, space
								message: '<?php echo BOOKING_ILLEGAL_CHARACTERS."<br />".BOOKING_ALLOWED_CHARACTERS_DIGITS; ?>'
						},

						callback: {
							message: 'Width between %s and %s',
							callback: function (value, validator, $field) {
								// Determine the numbers which are [name="Item_qty[]"]generated in captchaOperation
								var selId = $field.attr('id');
								var idArr = selId.split("_");
								var id = idArr[2];
								/*var width_max = parseFloat($("#width_max_"+id).val());
								var width_min = parseFloat($("#width_min_"+id).val());*/
								/*
								var pickup = $("#pickup").val();
									
								if(pickup == ""){
									$('#booking').bootstrapValidator('revalidateField', 'pickup');
									//value ="";
									$field.prop("disabled", true);
								}

								var deliver = $("#deliver").val();
								if(deliver == ""){
									$('#booking').bootstrapValidator('revalidateField', 'deliver');
									$field.prop("disabled", true);
								}
								var selecttype= $('select[name="selShippingType[]"] option:selected').val();
								//alert(selecttype);
								if(selecttype == ""){
									$('#booking').bootstrapValidator('revalidateField', 'selShippingType[]');
									$field.prop("disabled", true);
								}
								*/
								/*
								if(parseFloat(value)>width_max || parseFloat(value)<width_min)
								{
									return {
										valid: false,
										message: "Width must be between "+width_min+" and "+width_max
									};
								}
								*/
								var girthLength = parseFloat($("#Item_length_"+id).val());
								var girthWidth = parseFloat($("#Item_width_"+id).val());
								var girthHeight = parseFloat($("#Item_height_"+id).val());
								var maxGirth = parseFloat($("#girth_max_1").val());
								var totalGirth = (girthLength+(2*girthWidth)+(2*girthHeight));
								var selShippingType = $("#selShippingType_"+id).val();
								console.log("total girth:"+totalGirth);
								if(parseFloat(value) == 0)
								{
									return {
										valid: false,
										message: "Width must be greater than zero"
									};
								}
								
								if(totalGirth>maxGirth && selShippingType != '43'){
									return {
										valid: false,
										message: "Sorry we can't accept these dimensions because Girth is:"+maxGirth
									};
								}
								return true;
							}
						}
					}
				},

				'Item_height[]': {
					validators: {
						notEmpty: {
							message: '<?php echo COMMON_EMPTY_FIELD; ?>'
						},
						regexp: {
								regexp: /^[0-9]*$/, //lowercase, upercase, apostrophe, space
								message: '<?php echo BOOKING_ILLEGAL_CHARACTERS."<br />".BOOKING_ALLOWED_CHARACTERS_DIGITS; ?>'
						},

						callback: {
							message: 'Height between %s and %s',
							callback: function (value, validator, $field) {

								var selId = $field.attr('id');
								var idArr = selId.split("_");
								var id = idArr[2];
								/*var height_max = parseFloat($("#height_max_"+id).val());
								var height_min = parseFloat($("#height_min_"+id).val());*/
								/*
								var pickup = $("#pickup").val();
									
								if(pickup == ""){
									$('#booking').bootstrapValidator('revalidateField', 'pickup');
									//value ="";
									$field.prop("disabled", true);
								}

								var deliver = $("#deliver").val();
								if(deliver == ""){
									$('#booking').bootstrapValidator('revalidateField', 'deliver');
									$field.prop("disabled", true);
								}
								var selecttype= $('select[name="selShippingType[]"] option:selected').val();
								//alert(selecttype);
								if(selecttype == ""){
									$('#booking').bootstrapValidator('revalidateField', 'selShippingType[]');
									$field.prop("disabled", true);
								}
								*/
								var girthLength = parseFloat($("#Item_length_"+id).val());
								var girthWidth = parseFloat($("#Item_width_"+id).val());
								var girthHeight = parseFloat($("#Item_height_"+id).val());
								var maxGirth = parseFloat($("#girth_max_1").val());
								var totalGirth = (girthLength+(2*girthWidth)+(2*girthHeight));
								var selShippingType = $("#selShippingType_"+id).val();
								console.log(maxGirth+"total girth:"+totalGirth);
								
								if(parseFloat(value) == 0)
								{
									return {
										valid: false,
										message: "Height must be greater than zero"
									};
								}
								
								if(totalGirth>maxGirth && selShippingType != '43'){
									return {
										valid: false,
										message: "Sorry we can't accept these dimensions because Girth is:"+maxGirth
									};
								}
								return true;
							}
						}
					}
				},
				drc: {
					selector : '#drc',
					container : '#drcError',
					validators: {
						notEmpty: {
							message: '<?php echo PLEASE_SELECT_DELIVERY_TYPE; ?>'
						}
					}
				},
				'selShippingType[]': {
					validators: {
						notEmpty: {
							message: '<?php echo PLEASE_SELECT_ITEM_TYPE; ?>'
						},
						callback: {
							message: '<?php echo PLEASE_SELECT_ITEM_TYPE; ?>',
							callback: function (value, validator, $field) {
								var pickup = $('#pickup').val();
								var deliver = $('#deliver').val();
								if(value != "" && pickup != "" && deliver !=""){
									$("input[name='Item_weight[]']").prop("disabled", false);
									$("input[name='Item_length[]']").prop("disabled", false);
									$("input[name='Item_width[]']").prop("disabled", false);
									$("input[name='Item_height[]']").prop("disabled", false);

								}

								return true;
							}
						}

					}
				}
            }
        })

		// On error validator
		.on('error.validator.bv','[name="selShippingType[]"]', function(e, data) {

		   var weightId = $(this).attr("id");
		   var idArr = weightId.split("_");
		   var id = idArr[1];

		   if (data.field === 'selShippingType[]') {

				data.element
					.data('bv.messages')
					// Hide all the messages
					.find('.help-block[data-bv-for="' + data.field + '"]').hide()
					// Show only message associated with current validator
					.filter('[data-bv-validator="' + data.validator + '"]').show()

					.appendTo("#selShippingTypes_"+id);

					//$("#pak").css("display", "none");
			}
		 })

		 .on('error.validator.bv','[name="Item_qty[]"]', function(e, data) {

		   var weightId = $(this).attr("id");
		   var idArr = weightId.split("_");
		   var id = idArr[2];

		   if (data.field === 'Item_qty[]') {

				data.element
					.data('bv.messages')
					// Hide all the messages
					.find('.help-block[data-bv-for="' + data.field + '"]').hide()
					// Show only message associated with current validator
					.filter('[data-bv-validator="' + data.validator + '"]').show()

					.appendTo("#Items_qty_"+id);
			}
		 })

		.on('error.validator.bv','[name="Item_weight[]"]', function(e, data) {

		   var weightId = $(this).attr("id");
		   var idArr = weightId.split("_");
		   var id = idArr[2];

		   if (data.field === 'Item_weight[]') {
				//alert(data.validator);
				data.element
					.data('bv.messages')
					// Hide all the messages
					.find('.help-block[data-bv-for="' + data.field + '"]').hide()
					// Show only message associated with current validator
					.filter('[data-bv-validator="' + data.validator + '"]').show()

					.appendTo("#Items_weight_"+id);
			}
		  })
		.on('error.validator.bv','[name="Item_length[]"]', function(e, data) {

			var lengthId = $(this).attr("id");
			var idArr = lengthId.split("_");
			var id = idArr[2];

			if (data.field === 'Item_length[]') {
				data.element
					.data('bv.messages')
					// Hide all the messages
					.find('.help-block[data-bv-for="' + data.field + '"]').hide()
					// Show only message associated with current validator
					.filter('[data-bv-validator="' + data.validator + '"]').show()

					.appendTo("#Items_length_"+id);
			}
		})
		.on('error.validator.bv','[name="Item_width[]"]', function(e, data) {

			var widthId = $(this).attr("id");
			var idArr = widthId.split("_");
			var id = idArr[2];

			if (data.field === 'Item_width[]') {
				data.element
					.data('bv.messages')
					// Hide all the messages
					.find('.help-block[data-bv-for="' + data.field + '"]').hide()
					// Show only message associated with current validator
					.filter('[data-bv-validator="' + data.validator + '"]').show()

					.appendTo("#Items_width_"+id);
			}
		})
		.on('error.validator.bv','[name="Item_height[]"]', function(e, data) {
			var heightId = $(this).attr("id");
			var idArr = heightId.split("_");
			var id = idArr[2];
			if (data.field === 'Item_height[]') {
					data.element
						.data('bv.messages')
						// Hide all the messages
						.find('.help-block[data-bv-for="' + data.field + '"]').hide()
						// Show only message associated with current validator
						.filter('[data-bv-validator="' + data.validator + '"]').show()

						.appendTo("#Items_height_"+id);
				}
        })
		.on('error.validator.bv','[name="qty_item[]"]', function(e, data) {
			var heightId = $(this).attr("id");
			var idArr = heightId.split("_");
			var id = idArr[2];
			if (data.field === 'qty_item[]') {
					data.element
						.data('bv.messages')
						// Hide all the messages
						.find('.help-block[data-bv-for="' + data.field + '"]').hide()
						// Show only message associated with current validator
						.filter('[data-bv-validator="' + data.validator + '"]').show()

						.appendTo("#qty_items_"+id);
				}
        })
		.on('error.validator.bv','[name="weight_item[]"]', function(e, data) {
			var heightId = $(this).attr("id");
			var idArr = heightId.split("_");
			var id = idArr[2];
			if (data.field === 'weight_item[]') {
					data.element
						.data('bv.messages')
						// Hide all the messages
						.find('.help-block[data-bv-for="' + data.field + '"]').hide()
						// Show only message associated with current validator
						.filter('[data-bv-validator="' + data.validator + '"]').show()

						.appendTo("#weight_items_"+id);
				}
        })
		.on('error.validator.bv','[name="length_item[]"]', function(e, data) {
			var heightId = $(this).attr("id");
			var idArr = heightId.split("_");
			var id = idArr[2];
			if (data.field === 'length_item[]') {
					data.element
						.data('bv.messages')
						// Hide all the messages
						.find('.help-block[data-bv-for="' + data.field + '"]').hide()
						// Show only message associated with current validator
						.filter('[data-bv-validator="' + data.validator + '"]').show()

						.appendTo("#length_items_"+id);
				}
        })
		.on('error.validator.bv','[name="width_item[]"]', function(e, data) {
			var heightId = $(this).attr("id");
			var idArr = heightId.split("_");
			var id = idArr[2];
			if (data.field === 'width_item[]') {
					data.element
						.data('bv.messages')
						// Hide all the messages
						.find('.help-block[data-bv-for="' + data.field + '"]').hide()
						// Show only message associated with current validator
						.filter('[data-bv-validator="' + data.validator + '"]').show()

						.appendTo("#width_items_"+id);
				}
        })
		.on('error.validator.bv','[name="height_item[]"]', function(e, data) {
			var heightId = $(this).attr("id");
			var idArr = heightId.split("_");
			var id = idArr[2];
			if (data.field === 'height_item[]') {
					data.element
						.data('bv.messages')
						// Hide all the messages
						.find('.help-block[data-bv-for="' + data.field + '"]').hide()
						// Show only message associated with current validator
						.filter('[data-bv-validator="' + data.validator + '"]').show()

						.appendTo("#height_items_"+id);
				}
        })
        .on('change', '[name="inter_country"]', function() {
            ajaxInterValidation();
            //console.log("on change function is called");
		})


		.on('change', '[name="Item_qty[]"]', function() {
           display_total_value();
        })
		.on('click', '.removeButton', function() {

            var $row    = $(this).parents('.controls-row'),
                $ind = $row.attr('data-index'),
                $option = $row.find('[name="Item_weight[]' + $ind + '"]');

            $('#myform').bootstrapValidator('removeField', $option.eq(0).attr('name'));

            // Remove element containing the option
            $row.remove();
			Qty = Qty-1;
            // Remove field
			display_total_value();

        })
		.on('click', '#next', function() {

			var shipping_type = $("#selShippingType_1").val();
			var rowno = 1;
			console.log("pressed next button");
			/*if(shipping_type == "")
			{
				$("#selShippingTypes_"+rowno).closest('.help-block').show();
				$("#pak").css("display", "block");
			}else{
				removeError("selShippingTypes_err_"+rowno);
				$("#selShippingType_"+rowno).closest('.control-group').removeClass('has-error').addClass('has-success');
				$("#selShippingTypes_"+rowno).closest('.help-block').hide();
			}*/
		})
		.on('success.form.bv', function(e) {

			var inter_country = $('#inter_country').val();
			if(inter_country)
			{

				var finalinterval = checkInterValidation();

				$('#flage').val("2");
				if(finalinterval == true)
				{
					var interVal = totalInterVal();

					if(interVal == true){
						<?php if(isset($_GET['Action']) && isset($_GET['Action']) == 'edit'){ ?>
						//alert("under this condition");
						/*var editval = editpage();
						if($('#databtn').val() == 'false')
						{
							return false;
						}
						if($('#databtn').val() == true)
						{
							return false;
						}*/
						return true;
						//return true;
						<?php }else{ ?>
							return true;
						<?php } ?>


					}
				}else{
						return false;
				}

			}else{
				var finalval = checkValidation();
				//alert("finalval:"+finalval);

				console.log("inside domestic condition"+finalval);
				display_total_value();
				if(finalval == true)
				{
				<?php //if(isset($_GET['Action']) && isset($_GET['Action']) == 'edit'){ ?>
				//var editval = editpage();
				/*if($('#databtn').val() == 'false')
				{
					return false;
				}
				if($('#databtn').val() == true)
				{
					return false;
				}*/
				<?php // }else{ ?>
				e.preventDefault();
				run_waitMe('win8_linear');

				$.ajax({
				  url: "<?php echo DIR_HTTP_RELATED."ajax_postcode_rates.php"; ?>",
				  dataType: "json",
				  method: "post",
				  data: {
					pickup:$('#pickup').val(),
					deliver:$('#deliver').val(),
				  },
				  success: function( data ) { //alert("inside popup;");
					console.log("going inside else part of ajax postcode rate success"+data);
					if(data == 'false')
					{
						$('#postcode_available').modal('show');
						return false;

					}else{

						//alert(data);
						console.log("else part to submit for booking.php");
						$('.containerBlock > form').waitMe('hide');
						$('#booking').bootstrapValidator('defaultSubmit');
						e.preventDefault();
						return true;

					}

				  }
				});
				//return true;
				/*$('#booking').bootstrapValidator('defaultSubmit');
				e.preventDefault();
				return true;*/
				<?php //} ?>
				}else{
						return false;
				}
			}
        })
		// Called on click of reset button
        .on('click', '.Reset', function() {
			<?php if(isset($_GET['Action']) && isset($_GET['Action']) == 'edit'){ ?>
				$("#dataResetLossEff").modal("show");
				$('#dataResetLoseyes').click(function(){
				for(var j = 2;j<=(ind-1);j++)
				{
					$('#'+j).remove();
					// Remove field
				}
				for(var k = 2;k<=(interind-1);k++)
				{
					$('#'+k).remove();
					// Remove field
				}

				$('#booking').data('bootstrapValidator').resetForm(true);
				/* this function is to unset bookingitem object from session */

				//alert($('input[name=delivery_location_type]:checked');
				//alert($('input[name=pickup_location_type]:checked');
				$("#dataResetLossEff").modal("hide");
				$.ajax({
					type: "POST",
					url: 'related/destroyitems.php',
					data: '',
					success: function(data) {
					 	window.location.href='booking.php';
					}
				  });
				});

				$('#dataResetLoseno').click(function(){
					//$("#databtn").val('false');
					$("#dataResetLossEff").modal("hide");
				});
			<?php }else{ ?>
			for(var j = 2;j<=(ind-1);j++)
			{
				$('#'+j).remove();
				// Remove field
			}
			for(var k = 2;k<=(interind-1);k++)
			{
				$('#'+k).remove();
				// Remove field
			}
			console.log("reset button is clicked");
			$('#booking').data('bootstrapValidator').resetForm(true);
			$('#booking').data('bootstrapValidator').resetField('selShippingType[]',true);
			//alert($('input[name=delivery_location_type]:checked','#booking').val);
			$("#selShippingType_1").val("");

			//$("#selShippingType_1").closest('.control-group').removeClass('has-error');
			//$("#selShippingTypes_1").closest('.help-block').removeClass//('alert-error');
			//$("#selShippingTypes_1").closest('.help-block').hide();
			if(($("#pickup_location_type").val()==1))
			{
				$("#pickup_location_type").checked = false;
			}

			if($("#delivery_location_type").val()==1)
			{
				$("#delivery_location_type").checked = false;
			}
			//alert(($("#pickup_location_type").checked));
			//alert($('input[name=pickup_location_type]:checked','#booking'));

			<?php } ?>
		});
	});
//}


$('#dataLoseyes').click(function(){
	$("#databtn").val('true');
	$("#booking").submit();
});
$('#dataLoseno').click(function(){
	$("#databtn").val('false');
	$("#dataLossEff").modal("hide");
});
$('#inter_country').change(function() {
  ajaxInterValidation();
});
$( "#ajax_index_listOfOptions" ).change(function() {
	var node = $('.optionDivSelected');
	var text  = node.textContent || node.innerText;
	/*alert(text);*/
  console.log( "Handler for .keyup() called."+this.val());
});

/*
$('#reset').click(function(){
	ValidateBookingForm();
	<?php //if(isset($_GET['Action']) && isset($_GET['Action']) == 'edit'){ ?>
		$("#dataResetLossEff").modal("show");
		$('#dataResetLoseyes').click(function(){
		for(var j = 2;j<=(ind-1);j++)
		{
			$('#'+j).remove();
			// Remove field
		}
		for(var k = 2;k<=(interind-1);k++)
		{
			$('#'+k).remove();
			// Remove field
		}

		$('#booking').data('bootstrapValidator').resetForm(true);
		/* this function is to unset bookingitem object from session */

		/*$("#dataResetLossEff").modal("hide");
		$.ajax({
			type: "POST",
			url: 'related/destroyitems.php',
			data: '',
			success: function(data) {
			 	window.location.href='booking.php';
			}
		  });
		});

		$('#dataResetLoseno').click(function(){

			$("#dataResetLossEff").modal("hide");
		});
	<?php //}else{ ?>
	for(var j = 2;j<=(ind-1);j++)
	{
		$('#'+j).remove();
		// Remove field
	}
	for(var k = 2;k<=(interind-1);k++)
	{
		$('#'+k).remove();
		// Remove field
	}
	console.log("reset button is clicked");
	$('#booking').data('bootstrapValidator').resetForm(true);
	$('#booking').data('bootstrapValidator').resetField('selShippingType[]',true);

	$("#selShippingType_1").val("");


	if(($("#pickup_location_type").val()==1))
	{
		$("#pickup_location_type").checked = false;
	}

	if($("#delivery_location_type").val()==1)
	{
		$("#delivery_location_type").checked = false;
	}

	<?php //} ?>
});

*/
$('#reset').click(function(){

	$("#dataResetLossEff").modal("show");
	$('#dataResetLoseyes').click(function(){
		//ValidateBookingForm();
		for(var j = 2;j<=(ind-1);j++)
		{
			$('#'+j).remove();
			// Remove field
		}
		for(var k = 2;k<=(interind-1);k++)
		{
			$('#'+k).remove();
			// Remove field
		}

		$('#booking').data('bootstrapValidator').resetForm(true);
		/* this function is to unset bookingitem object from session */

		$("#dataResetLossEff").modal("hide");
		$.ajax({
			type: "POST",
			url: 'related/destroyitems.php',
			data: '',
			success: function(data) {
			 	window.location.href='booking.php';
			}
		  });
	});
	$('#dataResetLoseno').click(function(){
		//alert("second function reset click");
		$("#dataResetLossEff").modal("hide");
	});

});
function display_total_value()
{
	var sum=0;
	var total_weight=0;
	var base_weight=0;
	var volumetric_weight=0;
	var total_volume=0;
	var chargeable_weight=0;
	var total_volumetric_weight=0;
	var h1,l1,w1,Qty,Weight;
	lastRow = $('#last_inserted_cell_australia').val();
	//alert("lastrow:"+lastRow);
	//ValidateBookingForm();
	var selectypeid = '#selShippingType_'+lastRow;
	var shipping_type =$(selectypeid).val();
	
	//display_size(shipping_type,lastRow,'');
	//var focusId = $(this).val();
	//console.log("total display:"+shipping_type);
	for(var i=1;i<=lastRow;i++)
	{
		//console.log("item height:"+document.getElementById("Item_height_"+i) );
		if(document.getElementById("Item_height_"+i) != undefined)
		{
			if((document.getElementById("Item_height_"+i).value)=="")
			{
				h1=0;
				//console.log("ifconditio:"+i+"--height:"+document.getElementById("Item_height_"+i).value);
			}
			else
			{
				h1=document.getElementById("Item_height_"+i).value;
				//console.log("elseconditio:"+i+"--height:"+document.getElementById("Item_height_"+i).value);
			}
		}
		else
		{
			//console.log("3rdconditio");
			continue;
		}
		if(document.getElementById("Item_length_"+i) != undefined)
		{
			if((document.getElementById("Item_length_"+i).value)=="")
			{
				//document.getElementById("Item_length_"+i).value="0";
				l1=0;
			}
			else
			{
				l1=document.getElementById("Item_length_"+i).value;
			}
		}
		else
		{
			continue;
		}
		if(document.getElementById("Item_width_"+i) != undefined)
		{
			if((document.getElementById("Item_width_"+i).value)=="")
			{
				//document.getElementById("Item_width_"+i).value="0";
				w1=0;
			}
			else
			{
				w1=document.getElementById("Item_width_"+i).value;
			}
		}
		else
		{
			continue;
		}
		if(document.getElementById('Item_qty_'+i) != undefined)
		{
			if(document.getElementById('Item_qty_'+i).value=="")
			{
				Qty ="0";
			}
			else
			{
				Qty=document.getElementById('Item_qty_'+i).value;
			}
		}
		else
		{
			continue;
		}
		if(document.getElementById('Item_weight_'+i) != undefined)
		{
			if(document.getElementById('Item_weight_'+i).value=="")
			{
				//document.getElementById('Item_weight_'+i).value="0";
				Weight="0";
			}
			else
			{
				Weight=document.getElementById('Item_weight_'+i).value;
			}
		}
		else
		{
			continue;
		}
		var divisior = <?php echo services_volumetric_charges; ?>;

		volumetric_weight =((h1*l1*w1)/divisior);
		total_volumetric_weight=roundup(total_volumetric_weight,2)+(roundup(volumetric_weight,2)*eval(Qty));

		total_volume = total_volume+(((h1*l1*w1)/1000000)*Qty);
		//console.log("h1:"+h1+"l1:"+l1+"w1:"+w1);
		sum=sum+eval(Qty);
		total_weight=total_weight+ (eval(Weight)*eval(Qty));

		base_weight = (eval(Weight)*eval(Qty));
		var volumetric_weight_qty =  (volumetric_weight*eval(Qty));

		//if(parseFloat(base_weight)>parseFloat(volumetric_weight_qty))
		if(parseFloat(total_weight)>parseFloat(total_volumetric_weight))
		{

			chargeable_weight = chargeable_weight+total_weight;
		}else{
			chargeable_weight = chargeable_weight+volumetric_weight_qty;
		}

		sum =roundup(sum,0);
		$("#original_weight_1").val(total_weight);
		$("#chargeable_weight").val(Math.ceil(chargeable_weight));
		$("#aus_total_qty").val(sum);
		$("#volumetric_weight").val(total_volumetric_weight);
		$("#total_volume").val(total_volume);
		//console.log("total volume:"+total_volume);
		//The below method is used to match php rounding in session (2 decimal places)
		$("#total_volume_rounded").html(Math.round(total_volume*100)/100);
		//console.log("chargable weight:"+Math.ceil(chargeable_weight));
		$("#total_chargeable_weight").html(Math.ceil(chargeable_weight));
		$("#total_qty").html(eval(sum));
		total_weight=roundup(total_weight,1);
		$("#total_weight").html(parseFloat(total_weight));
		//total_volumetric_weight=roundup(total_volumetric_weight,1);
		$("#total_volumetric_weight").html(parseFloat(total_volumetric_weight));
		//console.log("total volumetric weight:"+total_volumetric_weight);

	}
	//console.log("chargable weight:"+chargeable_weight+"total wight:"+total_weight+"base weight:"+base_weight+"total volumetric_weight:"+total_volumetric_weight+"Qty:"+Qty);
}
function totalInterVal()
{
	var inter_sum=0;
	var inter_total_weight=0;
	var inter_base_weight=0;
	var inter_volumetric_weight=0;
	var inter_total_volumetric_weight=0;
	var inter_total_volume=0;
	var Ih1,Il1,Iw1,IQty,IWeight;
	var inter_chargeable_weight=0;
	lastInterRow = $('#last_inserted_cell_inter').val();

	for(var i=1; i<=lastInterRow; i++)
	{

		if($('#qty_item_'+i).val() != undefined)
		{
			if($('#qty_item_'+i).val()=="")
			{
				IQty ="0";
			}
			else
			{
				IQty=$('#qty_item_'+i).val();
			}
		}


		if($("#height_item_"+i).val()=="")
		{
			Ih1=0;
		}else if($("#height_item_"+i).val() == undefined){
			Ih1=0;
		}else{
			Ih1=$("#height_item_"+i).val();
		}
		if($("#length_item_"+i).val()=="")
		{
			Il1=0;
		}else if($("#length_item_"+i).val() == undefined){
			Il1=0;
		}else{
			Il1=$("#length_item_"+i).val();
		}
		if($("#width_item_"+i).val()=="")
		{
			Iw1=0;
		}else if($("#width_item_"+i).val() == undefined){
			Iw1=0;
		}else{
			Iw1=$("#width_item_"+i).val();
		}

		if($('#weight_item_'+i).val()=="")
		{
			IWeight="0";
		}else if($("#weight_item_"+i).val() == undefined){
			IWeight="0";
		}else{
			IWeight=$('#weight_item_'+i).val();
		}
		//IQty =1;

		var inter_divisior = <?php echo international_services_volumetric_charges; ?>;
		//console.log("divisior:"+inter_divisior);
		inter_volumetric_weight =(Ih1*Il1*Iw1)/inter_divisior;
		inter_total_volumetric_weight=roundup(inter_total_volumetric_weight,2)+(roundup(inter_volumetric_weight,2)*eval(IQty));
		inter_total_volume =(((Ih1*Il1*Iw1)/1000000)*Qty);
		inter_sum=inter_sum+eval(IQty);
		inter_sum =roundup(inter_sum,0);
		inter_total_weight=inter_total_weight+ (eval(IWeight)*eval(IQty));
		var inter_volu_weight_qty = ((inter_volumetric_weight)*eval(IQty));
		inter_base_weight = (eval(IWeight)*eval(IQty));
		if(parseFloat(inter_base_weight)>parseFloat(inter_volu_weight_qty))
		{
			//alert("deadweight:"+base_weight+"--volumetric:"+volumetric_weight);
			inter_chargeable_weight = inter_chargeable_weight+inter_base_weight;
		}else{
			inter_chargeable_weight = inter_chargeable_weight+inter_volu_weight_qty;
		}
	}


	//total_qty = Qty;

	inter_total_weight=roundup(inter_total_weight,1);
	inter_total_volumetric_weight=roundup(inter_total_volumetric_weight,2);
	$("#international_total_weight").val(inter_total_weight);
	$("#international_total_qty").val(parseFloat(inter_sum));
	$("#international_total_volumetric_weight").val(inter_total_volumetric_weight);
	$("#international_total_weight").val(inter_total_weight);
	$("#international_chargeable_weight").val(inter_chargeable_weight);
	$("#international_total_qty").val(parseFloat(inter_sum));
	$("#international_total_volumetric_weight").val(inter_total_volumetric_weight);
	$("#international_total_volume").val(inter_total_volume);
	$("#international_total_volumetric_weight").html(inter_total_volumetric_weight);
	$("#inter_total_weight").html(inter_total_weight);
	$("#inter_total_chargeable_weight").html(roundup(inter_chargeable_weight,1));
	$("#inter_total_volume_round").html(roundup(total_volume,2));
	$("#inter_total_qty").html(parseFloat(inter_sum));
	console.log("totalInterVal function is called");
	return true;
}

function DelSizeDataRow(Rowno){
	$('#booking').find('#next').removeAttr('disabled');
	console.log("from delete row remove disabled from next button");
	$('#'+Rowno).remove();
	if($('#deliver').val())
	{
		display_total_value();

	}else{
		totalInterVal();
	}
}
function display_size(shipping_type,rowno,totalblocks)
{
	//ValidateBookingForm();
	console.log("display_size function shipping_type:"+shipping_type);
	var item_width = document.getElementById("Item_width_"+rowno);
	var item_length = document.getElementById("Item_length_"+rowno);
	var item_height = document.getElementById("Item_height_"+rowno);
	var service_page = trim($("#servicepagename").val());
	console.log("display_size function service page:"+service_page);
	if(shipping_type == "")
	{
		$("#selShippingType_"+rowno).closest('.control-group').removeClass('has-success').addClass('has-error');
		$("#selShippingTypes_"+rowno).closest('.help-block').show();
	}else{
		removeError("selShippingTypes_err_"+rowno);
		$("#selShippingType_"+rowno).closest('.control-group').removeClass('has-error').addClass('has-success');
		$("#selShippingTypes_"+rowno).closest('.help-block').hide();
	}
	var pickup  = trim($("#pickup").val());
	var deliver = trim($("#deliver").val());
	//alert("Item_width_"+rowno);
	//$('#booking').bootstrapValidator('revalidateField', 'selShippingType[]');

	service_page = 'domestic';
	if($('#size_display_block_international').css('display') == 'block')
	{
		var inter_box = $.trim($("#inter_country").val());
		deliver = inter_box;
		service_page = 'international';
	}

	if(pickup != '' && deliver != '')
	{
		//unsetAusValues();
		//alert("service page:"+service_page+"item type:"+shipping_type);
		console.log("display_size function service page:"+service_page+"item type:"+shipping_type);
		/*
		$.ajax({
		url: '<?php echo "related/ajax_booking_validation.php"; ?>',
		type: 'POST',
		data: {service_item_type:service_page,row_num:rowno,item_type:shipping_type,item_change:true},
		success: function(response) {

			var firstArr  = response.split("^");
			console.log("firstarray: ajax booking validation"+firstArr);
			var rowNo    = firstArr[0];
			var dimArr = firstArr[1].split("@");

			var qty    = dimArr[1].split("-");
			var weight = dimArr[2].split("-");
			var length = dimArr[3].split("-");
			var width  = dimArr[4].split("-");
			var height = dimArr[5].split("-");
			var resArr = firstArr[1].split("$");

			var j;

			$("#qty_max_"+rowNo).val(qty[0]);
			$("#qty_min_"+rowNo).val(qty[1]);
			$("#weight_max_"+rowNo).val(weight[0]);
			$("#weight_min_"+rowNo).val(weight[1]);
			$("#length_max_"+rowNo).val(length[0]);
			$("#length_min_"+rowNo).val(length[1]);
			$("#width_max_"+rowNo).val(width[0]);
			$("#width_min_"+rowNo).val(width[1]);
			$("#height_max_"+rowNo).val(height[0]);
			$("#height_min_"+rowNo).val(height[1]);

			if(resArr.length!=0)
			{
				for(j = 0;j<(resArr.length-1);j++)
				{
					var resError = resArr[j].split("=>");
					//console.log("resError"+resError[0]);

					if(trim(resError[1])=="active")
					{
						if(resError[0].indexOf("Item_qty_") != 1)
						{
							//$(resError[0]).val('');
						}
						$(resError[0]).attr('readonly', false);

						display_total_value();

						$('#booking').data('bootstrapValidator').resetForm();

					}else{


						//$(resError[0]).val(0);
						$('#booking').data('bootstrapValidator').resetForm();
						$(resError[0]).attr('readonly', true);
					}

				}
			}

		},
		error: function () {
			alert("your error code");
		}
		});
		*/
	}

}
function checkValidation()
{

	$('#booking').bootstrapValidator('revalidateField', 'pickup');
	$('#booking').bootstrapValidator('revalidateField', 'deliver');
	$('#booking').bootstrapValidator('revalidateField', 'Item_weight[]');
	lastRow = $('#last_inserted_cell_australia').val();
			//alert("inside success"+lastRow);
	var error = false;

	for(var i=1; i<=lastRow; i++)
	{

		if($("#selShippingType_"+i).val()=="")
		{
			//h1=0;

			$('#booking').bootstrapValidator('validateField', "#selShippingType_"+i);
			error = true;
		}
		if($("#Item_height_"+i).val()=="")
		{
			h1=0;
			$('#booking').bootstrapValidator('validateField', "#Item_height_"+i);
			error = true;
		}
		if($("#Item_length_"+i).val()=="")
		{
			l1=0;
			$('#booking').bootstrapValidator('validateField', "#Item_length_"+i);
			error = true;
		}
		if($("#Item_width_"+i).val()=="")
		{
			w1=0;
			$('#booking').bootstrapValidator('validateField', "#Item_width_"+i);
			error = true;
		}

		if($('#Item_weight_'+i).val()=="")
		{
			Weight="0";
			$('#booking').bootstrapValidator('validateField', "#Item_weight_"+i);
			error = true;
		}

	}
	if(error == false)
	{
		return true;

	}else{
		return false;
	}
}
function removeError(a)
{
	//alert(a);
	$("#"+a).slideUp(400);
}
function checkpackage()
{

	var shipping_type = $("#selShippingType_1").val();
	console.log("inside checkpage");
	if(shipping_type == "")
	{
		var errDiv ='<small id="pak" class="help-block" style="display: block;" data-bv-validator="notEmpty" data-bv-for="selShippingType[]" data-bv-result="NOT_VALIDATED">Select any Item Type</small>';
		$("#selShippingType_1").closest('.control-group').addClass('has-error');
		if($("#selShippingTypes_1").next('.help-block').attr('style') == "display: none;")
		{
			if($("#pak").attr('style') == undefined)
			$(errDiv).appendTo("#selShippingTypes_1");
		}else{
			$("#selShippingTypes_1").next('.help-block').attr('style', 'display:block;');
		}
		//return false;
	}else{

		$("#selShippingType_1").closest('.control-group').removeClass('has-error').addClass('has-success');
		$("#selShippingTypes_1").closest('.help-block').hide();
		//return true;
	}
}
$('#closemodal').on('click', function () {
   $('#aus_cls').attr("checked", true);
   $('#international_country_display').hide();
   $('#display_delivery').show();
});

var activeTab = null;
$('a[data-toggle="tab"]').on('shown', function (e) {
	activeTab = e.target;
	var pickupval = $('#pickup').val();
	var inter_country = $('#inter_country').val();
	var deliverval = $("#deliver").val();
	//alert("test");
	if($(this).attr('id') == 'international')
	{
		//ajaxInterValidation();
		$.ajax({
		  url: '<?php echo DIR_HTTP_RELATED.FILE_INTERNATIONAL_AJAX_INTER_SERVICE; ?>',
		  type: 'post',
		  success: function(data, status) {
			if(data != 0)
			{
				var entryDomestic = preFilledDomestic();

				if(entryDomestic == false)
				{
					//$("#InterPersonalEff").modal('show');
					//ValidateBookingForm();

					$("#booking").data('bootstrapValidator').resetForm();

					unsetAusValues();
					unsetSession();
					lastRow = $('#last_inserted_cell_australia').val();

					for(var j = 2;j<=(lastRow);j++)
					{
						$('#'+j).remove();
						// Remove field
					}
					$('#deliver').val("DELIVERY SUBURB/POSTCODE");
					$('#pickup').val("PICK UP SUBURB/POSTCODE");
					$('#selShippingType_1').val("");


					/*Start to disable domestic validation */
					$('#booking')
								.bootstrapValidator('enableFieldValidators', 'deliver',false);
					$('#booking')
								.bootstrapValidator('enableFieldValidators', 'Item_weight[]',false);
					$('#booking')
					.bootstrapValidator('enableFieldValidators', 'Item_width[]',false);
					$('#booking')
					.bootstrapValidator('enableFieldValidators', 'Item_length[]',false);
					$('#booking')
					.bootstrapValidator('enableFieldValidators', 'Item_height[]',false);
					$("#flage").val("2");

					/*End to disable domestic validation*/
					$('#display_delivery').hide();
					$('#delivery_location_type').hide();
					//$('#InterPersonalEff').modal('hide');
				}
				$('#display_delivery').hide();
				$('#ausResult').attr('style','display:none');
				$('#interResult').attr('style','display:block');
				$('#delivery_location_type').hide();
				$('#international_country_display').show();
				$("#optionsCountry").val("Australia");
				$('#size_display_block_international').show();
				$('#size_display_block_1').hide();

			}else{

				$("#InterService").modal('show');
				$("#domint_1").addClass("active");
				$("#domint_2").removeClass("active");
				$('#display_delivery').show();
				$('#ausResult').attr('style','display:block');
				$('#interResult').attr('style','display:none');
				$('#delivery_location_type').show();
				$('#international_country_display').hide();
				$("#optionsCountry").val("Australia");
			}
			},
		  error: function(xhr, desc, err) {
			console.log(xhr);
			console.log("Details: " + desc + "\nError:" + err);
		  }
		}); // end ajax call

	}else{


		var entryInternational =preFilledInternational();
		if(entryInternational == false)
		{
			console.log("toggle tab function");
			//$("#DomesticEff").modal('show');
			//ValidateBookingForm();
			unsetSession();
			lastRow = $('#last_inserted_cell_inter').val();

			for(var j = 2;j<=(lastRow);j++)
			{
				$('#'+j).remove();
				// Remove field
			}

			$('#inter_country').val("");
			$('#pickup').val("PICK UP SUBURB/POSTCODE");
			$('#selShippingType_1').val("");
			$('#booking').data('bootstrapValidator').resetForm(true);
			$("#booking").submit();
			window.location.href='booking.php';

			/*Start to enable domestic validation */
			$('#booking')
						.bootstrapValidator('enableFieldValidators', 'deliver');
			$('#booking')
						.bootstrapValidator('enableFieldValidators', 'Item_weight[]');
			$('#booking')
			.bootstrapValidator('enableFieldValidators', 'Item_width[]');
			$('#booking')
			.bootstrapValidator('enableFieldValidators', 'Item_length[]');
			$('#booking')
			.bootstrapValidator('enableFieldValidators', 'Item_height[]');
			/*End to enable domestic validation*/
			$("#flage").val("1");
			$('#DomesticEff').modal('hide');

		}

		$('#display_delivery').show();
		$('#ausResult').attr('style','display:block');
		$('#interResult').attr('style','display:none');
		$('#international_country_display').hide();
		$('#size_display_block_international').hide();
		$('#size_display_block_1').show();
		$('#delivery_location_type').show();

	}
})

function ajaxInterValidation()
{
	var pickupval = $('#pickup').val();
	var inter_country = $('#inter_country').val();
	var item_name = $('input[name="inter_ShippingType_1[]"]:checked').val();
	console.log("This function is called"+inter_country);
	if(inter_country){
	$.ajax({
	  url: 'related/ajax_aus_booking_services.php',
	  type: 'post',
	  data: {'pickup':pickupval,'inter_country':inter_country,'item':item_name},
	  success: function(data, status) {

		var res = data.split("$");
		//console.log("data"+data+"res:"+res[1]+res[2]);
		//return false;
		/*var qty = res[1].split("-");
		var weight = res[2].split("-");
		var length = res[3].split("-");
		var width = res[4].split("-");
		var height = res[5].split("-");*/
		var length = res[1];
		var girth = res[2];
		$("#int_length_max_1").val(length);
		$("#int_girth_max_1").val(girth);
			/*$("#int_qty_max_1").val(qty[0]);
			$("#int_qty_min_1").val(qty[1]);
			$("#int_weight_max_1").val(weight[0]);
			$("#int_weight_min_1").val(weight[1]);

			$("#int_length_max_1").val(length[0]);
			$("#int_length_min_1").val(length[1]);
			$("#int_width_max_1").val(width[0]);
			$("#int_width_min_1").val(width[1]);
			$("#int_height_max_1").val(height[0]);
			$("#int_height_min_1").val(height[1]);*/
			//callDropDownItems(res[0]);
			$("#servicePageBox").html(res[0]);
			return true;


		  },
		  error: function(xhr, desc, err) {
			console.log(xhr);
			console.log("Details: " + desc + "\nError:" + err);
		  }
	});
	}

}
function checkInterValidation()
{
	//ValidateBookingForm();
	//ajaxInterValidation();
	//return false;
	$('#booking').bootstrapValidator('revalidateField', 'pickup');
	$('#booking').bootstrapValidator('revalidateField', 'intercountry');
	lastInterRow = $('#last_inserted_cell_inter').val();

	var error = false;

	for(var i=1; i<=lastInterRow; i++)
	{

		if($("#height_item_"+i).val()=="")
		{
			h1=0;
			$('#booking').bootstrapValidator('validateField', "height_item_"+i);
			error = true;
		}
		if($("#length_item_"+i).val()=="")
		{
			l1=0;
			$('#booking').bootstrapValidator('validateField', "length_item_"+i);
			error = true;
		}
		if($("#width_item_"+i).val()=="")
		{
			w1=0;
			$('#booking').bootstrapValidator('validateField', "width_item_"+i);
			error = true;
		}

		if($('#weight_item_'+i).val()=="")
		{
			Weight="0";
			$('#booking').bootstrapValidator('validateField', "weight_item_"+i);
			error = true;
		}

	}


	if(error == false)
	{
		return true;

	}else{
		return false;
	}
}
function selectedInterItems(item_name)
{
	//ValidateBookingForm();

	if($('input[name="inter_ShippingType_1[]"]:checked').val() == 4){

		ajaxInterValidation();/*to set the validation from backened*/
		$("#doc_1").addClass("active");

		$('#booking').data('bootstrapValidator').resetField('weight_item[]',true);
		$('#booking').data('bootstrapValidator').resetField('length_item[]',true);
		$('#booking').data('bootstrapValidator').resetField('width_item[]',true);
		$('#booking').data('bootstrapValidator').resetField('height_item[]',true);
	}else{
		$("#doc_1").removeClass("active");
	}
	if($('input[name="inter_ShippingType_1[]"]:checked').val() == 5){

		ajaxInterValidation();/*to set the validation from backened*/
		$("#doc_2").addClass("active");
		$('#booking').data('bootstrapValidator').resetField('weight_item[]',true);
		$('#booking').data('bootstrapValidator').resetField('length_item[]',true);
		$('#booking').data('bootstrapValidator').resetField('width_item[]',true);
		$('#booking').data('bootstrapValidator').resetField('height_item[]',true);
	}else{
		$("#doc_2").removeClass("active");
	}
}
$('#domyes').click(function(){
	//console.log("yes is clicked");
	//ValidateBookingForm();
	unsetSession();
	lastRow = $('#last_inserted_cell_inter').val();

	for(var j = 2;j<=(lastRow);j++)
	{
		$('#'+j).remove();
		// Remove field
	}

	$('#inter_country').val("");
	$('#pickup').val("PICK UP SUBURB/POSTCODE");
	$('#selShippingType_1').val("");
	$('#booking').data('bootstrapValidator').resetForm(true);
	$("#booking").submit();
	window.location.href='booking.php';
	/*$('#mySelect')
    .find('option')
    .remove()
    .end()
    .append('<option value="whatever">text</option>')
    .val('whatever')
;
	*/
	/*Start to enable domestic validation */
	$('#booking')
				.bootstrapValidator('enableFieldValidators', 'deliver');
	$('#booking')
				.bootstrapValidator('enableFieldValidators', 'Item_weight[]');
	$('#booking')
	.bootstrapValidator('enableFieldValidators', 'Item_width[]');
	$('#booking')
	.bootstrapValidator('enableFieldValidators', 'Item_length[]');
	$('#booking')
	.bootstrapValidator('enableFieldValidators', 'Item_height[]');
	/*End to enable domestic validation*/
	$("#flage").val("1");
	$('#DomesticEff').modal('hide');

});
$('#domno').click(function(){
    $('#DomesticEff').modal('hide');
	$("#domint_2").addClass("active");
	$("#domint_1").removeClass("active");
	$('#display_delivery').hide();
	$('#delivery_location_type').hide();
	$('#international_country_display').show();
	$('#size_display_block_international').show();
	$('#size_display_block_1').hide();
	//$("#optionsCountry").val("Australia");
});
$('#yes').click(function(){
	//console.log("yes is clicked");
	//ValidateBookingForm();

	$("#booking").data('bootstrapValidator').resetForm();

	unsetAusValues();
	unsetSession();
	lastRow = $('#last_inserted_cell_australia').val();

	for(var j = 2;j<=(lastRow);j++)
	{
		$('#'+j).remove();
		// Remove field
	}
	$('#deliver').val("DELIVERY SUBURB/POSTCODE");
	$('#pickup').val("PICK UP SUBURB/POSTCODE");
	$('#selShippingType_1').val("");


	/*Start to disable domestic validation */
	$('#booking')
				.bootstrapValidator('enableFieldValidators', 'deliver',false);
	$('#booking')
				.bootstrapValidator('enableFieldValidators', 'Item_weight[]',false);
	$('#booking')
	.bootstrapValidator('enableFieldValidators', 'Item_width[]',false);
	$('#booking')
	.bootstrapValidator('enableFieldValidators', 'Item_length[]',false);
	$('#booking')
	.bootstrapValidator('enableFieldValidators', 'Item_height[]',false);
	$("#flage").val("2");

	/*End to disable domestic validation*/
	$('#display_delivery').hide();
	$('#delivery_location_type').hide();
//$('#InterPersonalEff').modal('hide');
});
$('#no').click(function(){
//$('#InterPersonalEff').modal('hide');
	$("#domint_1").addClass("active");
	$("#domint_2").removeClass("active");
	$('#display_delivery').show();
	$('#international_country_display').hide();
	$('#size_display_block_international').hide();
	$('#size_display_block_1').show();
	$('#delivery_location_type').show();
	$("#optionsCountry").val("Australia");
});
$(function(){
	$('#ajax_index_listOfOptions').change(function() {
	console.log($('#pickup').val());
	})
});

function test(){
	//console.log($().value);
	console.log($('#pickup').val());
}
function unsetSession()
{
 /* this function is to unset bookingitem object from session */
  $.ajax({
	type: "POST",
	url: 'related/destroyitems.php',
	data: '',
	success: function(data) {
	 // alert(data);
	 <?php if(isset($_GET['Action']) && isset($_GET['Action']) == 'edit'){ ?>
		window.location.href='booking.php';
	 <?php } ?>
	}
  });

}
/*
$(function(){
    $(document).on('click', '#ajax_index_listOfOptions div', function(){
		if($('#pickup').val()){
			$('#booking').bootstrapValidator('revalidateField', 'pickup');
		}
		if($('#deliver').val()){
			$('#booking').bootstrapValidator('revalidateField', 'deliver');
		}
	});
})*/
function preFilledDomestic()
{
	var pickup = $('#pickup').val();
	var deliver = $('#deliver').val();
	var itemtype = $('#selShippingType_1').val();
	lastRow = $('#last_inserted_cell_australia').val();

	var error = false;
	if(pickup)
	{
		error = true;
	}
	if(deliver)
	{
		error = true;
	}
	if(itemtype)
	{
		error = true;
	}
	for(var i=1; i<=lastRow; i++)
	{

		if($("#Item_weight_"+i).val())
		{
			error = true;
		}
		if($("#Item_length_"+i).val())
		{
			error = true;
		}
		if($("#Item_width_"+i).val())
		{
			error = true;
		}

		if($('#Item_height_'+i).val())
		{
			error = true;
		}

	}

	if(error == false)
	{
		return true;

	}else{
		return false;
	}

}
function preFilledInternational()
{

	var pickup = $('#pickup').val();
	var deliver = $('#inter_country').val();

	lastInterRow = $('#last_inserted_cell_inter').val();

	var error = false;
	if(pickup)
	{
		error = true;
	}
	if(deliver)
	{
		error = true;
	}

	for(var i=1; i<=lastInterRow; i++)
	{

		if($("#weight_item_"+i).val())
		{
			error = true;
		}
		if($("#length_item_"+i).val())
		{
			error = true;
		}
		if($("#width_item_"+i).val())
		{
			error = true;
		}

		if($('#height_item_'+i).val())
		{
			error = true;
		}

	}

	if(error == false)
	{
		return true;

	}else{
		return false;
	}

}
function editpage()
{
	$('#dataLossEff').modal('show');
	return 1;
}
$('#interclose').on('click', function () {
	$('#InterService').modal('hide');
	$("#domint_1").addClass("active");
	//$("#domint_2").removeClass("active");
	$('#display_delivery').show();
	$('#international_country_display').hide();
	$("#optionsCountry").val("Australia");
})
$('#postInt').click(function(){
	$('.containerBlock > form').waitMe('hide');
	$('#postcode_available').modal('hide');
});

</script>
