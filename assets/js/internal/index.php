<script>
var d = $("#defaultDate").val();
var defaultDateset = d;
var m = $("#minDate").val();
var minDate = m;
if(trim(defaultDateset) == "")
{	
	defaultDateset = moment().format();
}
if(trim(minDate) == "")
{
	minDate = moment().format();
}
if( $("#defaultDate").val() == "")
{
	date =defaultDateset;
	$("#defaultDate").val(date);
}
if( $("#minDate").val() == "")
{
	mindate =minDate;
	$("#minDate").val(mindate);
}
 // When the DOM is ready & loaded, do this..
$(document).ready(function(){
    // Remove the `no-js` and add the `js` (because JS is enabled (we're using it!)
    $('body').removeClass('no-js').addClass('js');

    // Assign it to a var so you don't traverse the DOM unnecessarily.
    var useJS = $('body').hasClass('js');
    if(useJS){
        // JS Enabled
		//alert("js is enabled");
    }
});
</script>

<!--	*****	Overlay images on the Parallax slideshow	***** -->
<script type="text/javascript">
    jQuery(document).ready(function() {
      	App.initSliders();
        Index.initParallaxSlider();
    });
</script>
<!--	***		Bootstrap validator	***		-->
<script type="text/javascript">
/* Add button for domestic */
var ind = 2;
var success = false;
var lastRow = $("#last_inserted_cell_australia").val();

if(lastRow!=1){
var ind = 3;
}
$('.add_field_button').click(function (){
//ValidateForm();
if(checkValidation() == true){


var $template = $('#optionTemplate'),
	$clone    = $template
					.clone()
					.removeClass('hide')
					.removeAttr('id')
					.insertBefore($template),
	$divId       = $clone.find('.controls-row').attr('id', ind);
	$selectTxt   = $clone.find('[name="selShippingType[]"]').attr('id', 'selShippingType_' + ind);
	$qtySpan     = $clone.find('[id="Items_qty_1"]').attr('id','Items_qty_'+ind);
	$qtyId       = $clone.find('[id="Item_qty_1"]').attr('id', 'Item_qty_' + ind);
	$qtyTxt      = $clone.find('[name="Item_qty[]"]');
	$weightSpan  = $clone.find('[id="Items_weight_1"]').attr('id', 'Items_weight_' + ind);
	$weightId    = $clone.find('[id="Item_weight_1"]').attr('id', 'Item_weight_' + ind);
	$weightTxt   = $clone.find('[name="Item_weight[]"]');
	$weightkeyup   = $clone.find('[name="Item_weight[]"]').attr('onkeyup','numberDecimal(this.value,"Item_weight_'+ind+'","myform")');
	$lengthTxt   = $clone.find('[name="Item_length[]"]');
	$lengthId    = $clone.find('[id="Item_length_1"]').attr('id', 'Item_length_' + ind);
	$lengthSpan  = $clone.find('[id="Items_length_1"]').attr('id', 'Items_length_' + ind);
	$widthTxt    = $clone.find('[name="Item_width[]"]');
	$widthId     = $clone.find('[id="Item_width_1"]').attr('id', 'Item_width_' + ind);
	$widthSpan   = $clone.find('[id="Items_width_1"]').attr('id', 'Items_width_' + ind);
	$heightTxt   = $clone.find('[name="Item_height[]"]');
	$heightId     = $clone.find('[id="Item_height_1"]').attr('id', 'Item_height_' + ind);
	$heightSpan  = $clone.find('[id="Items_height_1"]').attr('id', 'Items_height_' + ind);
	$delSpan  = $clone.find('[class="removeButton"]').attr('onclick', 'javascript:DelSizeDataRow('+ind+')');
	

// Add new field

$('#myform').bootstrapValidator('addField', $qtySpan);
$('#myform').bootstrapValidator('addField', $qtyId);
$('#myform').bootstrapValidator('addField', $qtyTxt);

$('#myform').bootstrapValidator('addField', $weightSpan);
$('#myform').bootstrapValidator('addField', $weightId);
$('#myform').bootstrapValidator('addField', $weightTxt);
$('#myform').bootstrapValidator('addField', $weightkeyup);

$('#myform').bootstrapValidator('addField', $lengthTxt);
$('#myform').bootstrapValidator('addField', $lengthId);
$('#myform').bootstrapValidator('addField', $lengthSpan);

$('#myform').bootstrapValidator('addField', $widthTxt);
$('#myform').bootstrapValidator('addField', $widthId);
$('#myform').bootstrapValidator('addField', $widthSpan);

$('#myform').bootstrapValidator('addField', $heightTxt);
$('#myform').bootstrapValidator('addField', $heightId);
$('#myform').bootstrapValidator('addField', $heightSpan);
//console.log("on click of add button");

$("#last_inserted_cell_australia").val(ind);
ind++;
}else{
	$('#myform').data('bootstrapValidator').validate();
}
});
/* Add button for domestic */
/* Add button for international */
var interind = 2;
var lastInterRow = $("#last_inserted_cell_inter").val();

if(lastInterRow!=1){
	var interind = 3;
}
$('.add_inter_button').click(function (){
//ValidateForm();
if(checkInterValidation() == true){

var $interTemplate = $('#optionIntTemplate'),
	$interclone    = $interTemplate
					.clone()
					.removeClass('hide')
					.removeAttr('id')
					.insertBefore($interTemplate),
	$divId       = $interclone.find('.controls-row').attr('id', interind);
	
	$qtySpan     	= $interclone.find('[id="Items_qty_1"]').attr('id','Items_qty_'+ind);
	$qtyId       	= $interclone.find('[id="Item_qty_1"]').attr('id', 'Item_qty_' + ind);
	$qtyTxt      	= $interclone.find('[name="Item_qty[]"]');
	$weightIntSpan  = $interclone.find('[id="weight_items_1"]').attr('id', 'weight_items_' + interind);
	$weightIntId    = $interclone.find('[id="weight_item_1"]').attr('id', 'weight_item_' + interind);
	$weightIntTxt   = $interclone.find('[name="weight_item[]"]');
	$weightIntkeyup   = $interclone.find('[name="weight_item[]"]').attr('onkeyup','numberDecimal(this.value,"weight_item_'+ind+'","myform")');
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

$('#myform').bootstrapValidator('addField', $qtySpan);
$('#myform').bootstrapValidator('addField', $qtyId);
$('#myform').bootstrapValidator('addField', $qtyTxt);

$('#myform').bootstrapValidator('addField', $weightIntSpan);
$('#myform').bootstrapValidator('addField', $weightIntId);
$('#myform').bootstrapValidator('addField', $weightIntTxt);
$('#myform').bootstrapValidator('addField', $weightIntkeyup);

$('#myform').bootstrapValidator('addField', $lengthIntTxt);
$('#myform').bootstrapValidator('addField', $lengthIntId);
$('#myform').bootstrapValidator('addField', $lengthIntSpan);

$('#myform').bootstrapValidator('addField', $widthIntTxt);
$('#myform').bootstrapValidator('addField', $widthIntId);
$('#myform').bootstrapValidator('addField', $widthIntSpan);

$('#myform').bootstrapValidator('addField', $heightIntTxt);
$('#myform').bootstrapValidator('addField', $heightIntId);
$('#myform').bootstrapValidator('addField', $heightIntSpan);


$("#last_inserted_cell_inter").val(interind);
interind++;
}else{
	$('#myform').data('bootstrapValidator').validate();
}
});
/*
$('#myquote').click(function (){
	//alert("myquote button is clicked");
	ValidateForm();
	var validator = $('[id*=myform]').data('bootstrapValidator');
    validator.validate();
   // return validator.isValid();
});*/
//
/* Add button for international */
//function ValidateForm() {
$('#myform').bootstrapValidator({
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
					regexp: /^[a-zA-Z0-9\s]*$/, //lowercase, upercase, apostrophe, space
					message: '<?php echo INDEX_ILLEGAL_CHARACTERS."<br />".INDEX_ALLOWED_CHARACTERS_FROMTO; ?>'
				},
				/*remote: {
					url: '<?php echo DIR_HTTP_RELATED."tms_index.php"; ?>',
					data: function(validator) { 
						return {
						chksuburb:true,
						letters: validator.getFieldElements('pickup').val()
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
		deliver:{
			selector: '#deliver',
			container: "#deliverResult",
			validators: {
				notEmpty: {
						message: '<?php echo SELECT_PICKUP_ITEM; ?>'
					},
				regexp: {
					regexp: /^[a-zA-Z0-9\s]*$/, //lowercase, upercase, apostrophe, space
					message: '<?php echo INDEX_ILLEGAL_CHARACTERS."<br />".INDEX_ALLOWED_CHARACTERS_FROMTO; ?>'
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
		'Item_qty[]': {
						validators: {
							notEmpty: {
								message: '<?php echo COMMON_EMPTY_FIELD; ?>'
							},
							regexp: {
								regexp: /^[0-9]*$/, //lowercase, upercase, apostrophe, space
								message: '<?php echo INDEX_ILLEGAL_CHARACTERS."<br />".INDEX_ALLOWED_CHARACTERS_DIGITS; ?>'
							},
							callback: {
							message: 'Quantity between %s and %s',
							callback: function (value, validator, $field) {
								
								if(parseFloat(value) == 0)
								{
									return {
										valid: false,
										message: "Quantity must be greater than zero"
									};
								}	
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
						message: '<?php echo INDEX_ILLEGAL_CHARACTERS."<br />".INDEX_ALLOWED_WEIGHT_CHARACTERS_DIGITS; ?>'
					},
					callback: {
						message: 'Weight between %s and %s',
						callback: function (value, validator, $field) {
						
							if(parseFloat(value) == 0)
							{
								return {
									valid: false,
									message: "Weight must be greater than zero"
								};
							}	
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
						message: '<?php echo INDEX_ILLEGAL_CHARACTERS."<br />".INDEX_ALLOWED_CHARACTERS_DIGITS; ?>'
					},
					callback: {
						message: 'Length between %s and %s',
						callback: function (value, validator, $field) {
							var selId = $field.attr('id');
							var idArr = selId.split("_");
							var id = idArr[2];
							var length_max = parseFloat($("#length_max_1").val());
							var girthLength = parseFloat($("#Item_length_"+id).val());
							var girthWidth = parseFloat($("#Item_width_"+id).val());
							var girthHeight = parseFloat($("#Item_height_"+id).val());
							var maxGirth = parseFloat($("#girth_max_1").val());
							var totalGirth = (girthLength+(2*girthWidth)+(2*girthHeight));
							//console.log("length max"+length_max);
							if(parseFloat(value)>length_max)
							{
								return {
									valid: false,
									message: "Length must be less than"+length_max
								};
							}
							if(totalGirth>maxGirth){
								return {
									valid: false,
									message: "Sorry we can't accept these dimensions as max girth is"+maxGirth
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
						message: '<?php echo INDEX_ILLEGAL_CHARACTERS."<br />".INDEX_ALLOWED_CHARACTERS_DIGITS; ?>'
				},
				callback: {
					message: 'Width between %s and %s',
					callback: function (value, validator, $field) {
						var selId = $field.attr('id');
						var idArr = selId.split("_");
						var id = idArr[2];
						var girthLength = parseFloat($("#Item_length_"+id).val());
						var girthWidth = parseFloat($("#Item_width_"+id).val());
						var girthHeight = parseFloat($("#Item_height_"+id).val());
						var maxGirth = parseFloat($("#girth_max_1").val());
						var totalGirth = (girthLength+(2*girthWidth)+(2*girthHeight));
						
						if(parseFloat(value) == 0)
						{
							return {
								valid: false,
								message: "Width must be greater than zero"
							};
						}
						if(totalGirth>maxGirth){
							return {
								valid: false,
								message: "Sorry we can't accept these dimensions as max girth is"+maxGirth
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
				callback: {
					message: 'Height between %s and %s',
					callback: function (value, validator, $field) {
						var selId = $field.attr('id');
						var idArr = selId.split("_");
						var id = idArr[2];
						var girthLength = parseFloat($("#Item_length_"+id).val());
						var girthWidth = parseFloat($("#Item_width_"+id).val());
						var girthHeight = parseFloat($("#Item_height_"+id).val());
						var maxGirth = parseFloat($("#girth_max_1").val());
						var totalGirth = (girthLength+(2*girthWidth)+(2*girthHeight));
						
						if(parseFloat(value) == 0)
						{
							return {
								valid: false,
								message: "Height must be greater than zero"
							};
						}
						if(totalGirth>maxGirth){
							return {
								valid: false,
								message: "Sorry we can't accept these dimensions as max girth is"+maxGirth
							};
						}
						return true;
					}
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
								message: '<?php echo INDEX_ILLEGAL_CHARACTERS."<br />".INDEX_ALLOWED_CHARACTERS_DIGITS; ?>'
							},
							callback: {
							message: 'Quantity between %s and %s',
							callback: function (value, validator, $field) {
								
								if(parseFloat(value) == 0)
								{
									return {
										valid: false,
										message: "Quantity must be greater than zero"
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
						message: '<?php echo INDEX_ILLEGAL_CHARACTERS."<br />".INDEX_ALLOWED_WEIGHT_CHARACTERS_DIGITS; ?>'
					},
					callback: {
						message: 'Weight between %s and %s',
						callback: function (value, validator, $field) {
							if(parseFloat(value) == 0)
							{
								return {
									valid: false,
									message: "Weight must be greater than zero"
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
						message: '<?php echo INDEX_ILLEGAL_CHARACTERS."<br />".INDEX_ALLOWED_CHARACTERS_DIGITS; ?>'
					},
					callback: {
						message: 'Length between %s and %s',
						callback: function (value, validator, $field) {
							var length_max = parseFloat($("#length_max_1").val());
							var selId = $field.attr('id');
							var idArr = selId.split("_");
							var id = idArr[2];
							var girthLength = parseFloat($("#length_item_"+id).val());
							var girthWidth = parseFloat($("#width_item_"+id).val());
							var girthHeight = parseFloat($("#height_item_"+id).val());
							var maxGirth = parseFloat($("#girth_max_1").val());
							var totalGirth = (girthLength+(2*girthWidth)+(2*girthHeight));
						
							if(parseFloat(value) == 0)
							{
								return {
									valid: false,
									message: "Length must be greater than zero"
								};
							}
							if(parseFloat(value)>length_max)
							{
								return {
									valid: false,
									message: "Length must be less than"+length_max
								};
							}
							if(totalGirth>maxGirth){
								return {
									valid: false,
									message: "Sorry we can't accept these dimensions as max girth is"+maxGirth
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
						message: '<?php echo INDEX_ILLEGAL_CHARACTERS."<br />".INDEX_ALLOWED_CHARACTERS_DIGITS; ?>'
				},
				callback: {
					message: 'Width between %s and %s',
					callback: function (value, validator, $field) {
						var selId = $field.attr('id');
						var idArr = selId.split("_");
						var id = idArr[2];
						var girthLength = parseFloat($("#length_item_"+id).val());
						var girthWidth = parseFloat($("#width_item_"+id).val());
						var girthHeight = parseFloat($("#height_item_"+id).val());
						var maxGirth = parseFloat($("#girth_max_1").val());
						var totalGirth = (girthLength+(2*girthWidth)+(2*girthHeight));
						
						if(parseFloat(value) == 0)
						{
							return {
								valid: false,
								message: "Length must be greater than zero"
							};
						}
						if(totalGirth>maxGirth){
							return {
								valid: false,
								message: "Sorry we can't accept these dimensions as max girth is"+maxGirth
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
					message: '<?php echo INDEX_ILLEGAL_CHARACTERS."<br />".INDEX_ALLOWED_CHARACTERS_DIGITS; ?>'
				},
				callback: {
					message: 'Height between %s and %s',
					callback: function (value, validator, $field) {
						var selId = $field.attr('id');
						var idArr = selId.split("_");
						var id = idArr[2];
						var girthLength = parseFloat($("#length_item_"+id).val());
						var girthWidth = parseFloat($("#width_item_"+id).val());
						var girthHeight = parseFloat($("#height_item_"+id).val());
						var maxGirth = parseFloat($("#girth_max_1").val());
						var totalGirth = (girthLength+(2*girthWidth)+(2*girthHeight));
						if(parseFloat(value) == 0)
						{
							return {
								valid: false,
								message: "Length must be greater than zero"
							};
						}
						if(totalGirth>maxGirth){
							return {
								valid: false,
								message: "Sorry we can't accept these dimensions as max girth is"+maxGirth
							};
						}
						return true;
					}
				}
			}
		},
	}
})


// On selection of Country option
.on('click', '[name="inter_country"]', function() {
	ajaxInterValidation();
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
// On error validator
.on('error.validator.bv','[name="Item_weight[]"]', function(e, data) {
   
   var weightId = $(this).attr("id");
   var idArr = weightId.split("_"); 
   var id = idArr[2]; 
	
   if (data.field === 'Item_weight[]') {
		
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
// On selection of close button in international popup
.on('change', '[name="Item_height[]"]', function() {
	$('#myform').find('.add_field_button').removeAttr('disabled');
})
.on('error.validator.bv','[name="qty_item[]"]', function(e, data) {
   
   var qtyId = $(this).attr("id");
   var idArr = qtyId.split("_"); 
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
   
   var weightId = $(this).attr("id");
   var idArr = weightId.split("_"); 
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
	
	var lengthId = $(this).attr("id");
	var idArr = lengthId.split("_"); 
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
	
	var widthId = $(this).attr("id");
	var idArr = widthId.split("_"); 
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
// Called after adding new field
.on('added.field.bv', function(e, data) {
	
	if (data.element.val() != '') {
	
			$('#myform').find('.add_field_button').attr('enabled', 'enabled');
	   
	}
})


.on('success.form.bv', function(e) {
	
	var inter_country = $('#inter_country').val();
	if(inter_country)
	{
		
		var finalinterval = checkInterValidation();
		//alert(finalinterval);
		
		$('#flage').val("2");
		if(finalinterval == true)
		{
			var interVal = totalInterVal();
			
			if(interVal == true){
				//alert("submit"+interVal);
				return true;
			}
		}else{
				return false;
		}
		
	}else{
		var finalval = checkValidation();
		
		if(finalval == true)
		{
			
			var interVal = totalDomesticVal();
			
			if(interVal == true){
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
				  success: function( data ) {
				   //alert(data);
					if(data == 'false')
					{
						$('#postcode_available').modal('show');
						
						return false;
						
					}else{
						 
						$('.containerBlock > form').waitMe('hide');
						$('#myform').bootstrapValidator('defaultSubmit');
						e.preventDefault();
						return true;
						
					}
					
				  }
				});
				//return true;
			}
			
		}else{
			return false;			
		}
		
	}
	

	
})

// Called on click of reset button
.on('click', '.Reset', function() { 
	$('#myform').data('bootstrapValidator').resetForm(true);
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
});
//}		
       
//});
function checkValidation()
{
	$('#myform').bootstrapValidator('revalidateField', 'pickup');
	$('#myform').bootstrapValidator('revalidateField', 'deliver');
	lastRow = $('#last_inserted_cell_australia').val();
				
	var error = false;

	for(var i=1; i<=lastRow; i++)
	{
		
		if($("#Item_height_"+i).val()=="")
		{
			h1=0;
			$('#myform').bootstrapValidator('validateField', "Item_height_"+i);
			error = true;
		}
		if($("#Item_length_"+i).val()=="")
		{
			l1=0;
			$('#myform').bootstrapValidator('validateField', "Item_length_"+i);
			error = true;
		}
		if($("#Item_width_"+i).val()=="")
		{
			w1=0;
			$('#myform').bootstrapValidator('validateField', "Item_width_"+i);
			error = true;
		}
		
		if($('#Item_weight_'+i).val()=="")
		{
			Weight="0";
			$('#myform').bootstrapValidator('validateField', "Item_weight_"+i);
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
function checkInterValidation()
{
	$('#myform').bootstrapValidator('revalidateField', 'pickup');
	$('#myform').bootstrapValidator('revalidateField', 'intercountry');
	lastInterRow = $('#last_inserted_cell_inter').val();
			
	var error = false;
	
	for(var i=1; i<=lastInterRow; i++)
	{
		
		if($("#height_item_"+i).val()=="")
		{
			h1=0;
			$('#myform').bootstrapValidator('validateField', "height_item_"+i);
			error = true;
		}
		if($("#length_item_"+i).val()=="")
		{
			l1=0;
			$('#myform').bootstrapValidator('validateField', "length_item_"+i);
			error = true;
		}
		if($("#width_item_"+i).val()=="")
		{
			w1=0;
			$('#myform').bootstrapValidator('validateField', "width_item_"+i);
			error = true;
		}
		
		if($('#weight_item_'+i).val()=="")
		{
			Weight="0";
			$('#myform').bootstrapValidator('validateField', "weight_item_"+i);
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
function DelSizeDataRow(Rowno){
	$('#myform').find('#myquote').removeAttr('disabled');
	$('#'+Rowno).remove();
}
$('#deliveryService').on('hide', function () {
	$('#myform').find('#myquote').removeAttr('disabled');
})
//$('#deliveryService').on('click', function () {
  
  // do something…
  //if($('#drc:checked').val() != undefined){
	//alert($('#drc:checked').val());
	// Reset the message element when the form is valid
		
  /*}else{
	$("#drcError").html("Delivery Location Type is needed.");
	return false;
  }
  */
//})
function totalDomesticVal()
{
	var sum=0;
	var total_weight=0;
	var volumetric_weight=0;
	var base_weight=0;
	var chargeable_weight=0;
	var total_volumetric_weight=0;
	var h1,l1,w1,Qty,Weight;
	
	lastRow = $('#last_inserted_cell_australia').val();
	
	for(var i=1; i<=lastRow; i++)
	{
		//alert($("#Item_height_"+i).val());
		if($("#Item_height_"+i).val()=="")
		{
			h1=0;
		}else if($("#Item_height_"+i).val() == undefined){
			h1=0;
		}else{
			h1=$("#Item_height_"+i).val();
		}
		if($("#Item_length_"+i).val()=="")
		{
			l1=0;
		}else if($("#Item_length_"+i).val() == undefined){
			l1=0;
		}else{
			l1=$("#Item_length_"+i).val();
		}
		if($("#Item_width_"+i).val()=="")
		{
			w1=0;
		}else if($("#Item_width_"+i).val() == undefined){
			w1=0;
		}else{
			w1=$("#Item_width_"+i).val();
		}
		if($("#Item_qty_"+i).val()=="")
		{
			Qty=0;
		}else if($("#Item_qty_"+i).val() == undefined){
			Qty=0;
		}else{
			Qty=$("#Item_qty_"+i).val();
		}
		if($('#Item_weight_'+i).val()=="")
		{
			Weight="0";
		}else if($("#Item_weight_"+i).val() == undefined){
			Weight="0";
		}else{
			Weight=$('#Item_weight_'+i).val();
		}
		//alert("#Item_weight_"+i+"value:"+Weight);
		//Qty =1;
		
		var divisior = <?php echo services_volumetric_charges; ?>;
		volumetric_weight =(h1*l1*w1)/divisior;
		total_volumetric_weight=roundup(total_volumetric_weight,1)+(roundup(volumetric_weight,1)*eval(Qty));
		sum=sum+eval(Qty);
		base_weight = (eval(Weight)*eval(Qty));
		var volumetric_weight_qty =  (volumetric_weight*eval(Qty));
		if(parseFloat(base_weight)>parseFloat(volumetric_weight_qty))
		{
			//alert("deadweight:"+base_weight+"--volumetric:"+volumetric_weight);
			chargeable_weight = chargeable_weight+base_weight;
		}else{
			chargeable_weight = chargeable_weight+volumetric_weight_qty;
		}
		sum =roundup(sum,0);
		total_weight=total_weight+ (eval(Weight)*eval(Qty));
			
	}
	
	
	//total_qty = Qty;
	total_weight=roundup(total_weight,1);
	total_volumetric_weight=roundup(total_volumetric_weight,0);
	
	$("#original_weight_1").val(total_weight);
	$("#chargeable_weight").val(chargeable_weight);
	$("#aus_total_qty").val(parseFloat(sum));
	$("#volumetric_weight").val(total_volumetric_weight);
	$("#total_chargeable_weight").html(parseFloat(chargeable_weight));
	//return false;
	//$('#deliveryService').modal("hide");
	//$("#myform").submit();
	return true;
}
function totalInterVal()
{
	var inter_sum=0;
	var inter_total_weight=0;
	var inter_volumetric_weight=0;
	var inter_total_volumetric_weight=0;
	var inter_base_weight=0;
	var inter_chargeable_weight=0;
	var Ih1,Il1,Iw1,IQty,IWeight;
	
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
		
		var inter_divisior = <?php echo services_volumetric_charges; ?>;
		inter_volumetric_weight =(Ih1*Il1*Iw1)/inter_divisior;
		inter_total_volumetric_weight=roundup(inter_total_volumetric_weight,1)+(roundup(inter_volumetric_weight,1)*eval(IQty));
		inter_sum=inter_sum+eval(IQty);
		inter_sum =roundup(inter_sum,0);
		inter_base_weight = (eval(IWeight)*eval(IQty));
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
	inter_total_volumetric_weight=roundup(inter_total_volumetric_weight,0);
	
	$("#international_total_weight").val(inter_total_weight);
	$("#international_total_qty").val(parseFloat(inter_sum));
	$("#international_total_volumetric_weight").val(inter_total_volumetric_weight);
	$("#international_chargeable_weight").val(inter_chargeable_weight);
	
	return true;
}

function removeError(a)
{
	//alert(a);
	$("#"+a).slideUp(400);
}
function round_up (name,val, precision) {
	
	power = Math.pow (10, precision);
	poweredVal = Math.ceil (val * power);
	result =(isNaN(val))?(0):(poweredVal / power);
	document.getElementById(name).value=result;
	//setConsignmentsValue();
	return result;
}
function roundup(val,precision)
{
	power = Math.pow (10, precision);
	poweredVal = Math.ceil (val * power);
	result = poweredVal / power;
	return result;

}
$('#closemodal').on('click', function () {
   $('#aus_cls').attr("checked", true);
   $('#international_country_display').hide();
   $('#display_delivery').show();
})
$('#closeInt').on('click', function () {
	$('#InterService').modal('hide');
	$("#domint_1").addClass("active");
	//$("#domint_2").removeClass("active");
	$('#display_delivery').show();
	$('#international_country_display').hide();
	$("#optionsCountry").val("Australia");
})
$('.carousel').carousel({
	interval: 4000
})



var activeTab = null;
$('a[data-toggle="tab"]').on('shown', function (e) {
  activeTab = e.target;
  
	var pickupval = $('#pickup').val();
	var inter_country = $('#inter_country').val();
	var deliverval = $("#deliver").val();
	  if($(this).attr('id') == 'international')
	{
		
		$.ajax({
		  url: '<?php echo DIR_HTTP_RELATED.FILE_INTERNATIONAL_AJAX_INTER_SERVICE; ?>',
		  type: 'post',
		  success: function(data, status) { 
			if(data != 0)
			{
				
				if(pickupval!='' && deliverval!='')
				{
					//$("#InterPersonalEff").modal('show');
					unsetSession();
					lastRow = $('#last_inserted_cell_australia').val();
						
					for(var j = 2;j<=(lastRow);j++)
					{
						$('#'+j).remove();
						// Remove field
					}
					$('#myform').data('bootstrapValidator').resetForm(true);
					
					/*Start to disable domestic validation*/
					$('#myform')
								.bootstrapValidator('enableFieldValidators', 'deliver',false);
					$('#myform')
								.bootstrapValidator('enableFieldValidators', 'Item_weight[]',false);
					$('#myform')
					.bootstrapValidator('enableFieldValidators', 'Item_width[]',false);
					$('#myform')
					.bootstrapValidator('enableFieldValidators', 'Item_length[]',false);
					$('#myform')
					.bootstrapValidator('enableFieldValidators', 'Item_height[]',false);
					$("#flage").val("2");
					/*End to disable domestic validation*/
				}
				$('#display_delivery').hide();
				$('#p_location_type').hide();
				$('#d_location_type').hide();
				$('#international_country_display').show();
				$("#optionsCountry").val("Australia");
				$('#size_display_block_international').show();
				$('#size_display_block_1').hide();
				
				//$('#deliver').val("DELIVERY SUBURB/POSTCODE");
				//$('#pickup').val("PICK UP SUBURB/POSTCODE");
					
					
			}else{
					
				$("#InterService").modal('show');
				$("#domint_1").addClass("active");
				$("#domint_2").removeClass("active");
				$('#p_location_type').hide();
				$('#d_location_type').hide();
				$('#display_delivery').show();
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
		if(pickupval!='PICK UP SUBURB/POSTCODE' && inter_country!='')
		{
			unsetSession();
			//ValidateForm();
			lastRow = $('#last_inserted_cell_inter').val();
				
			for(var j = 2;j<=(lastRow);j++)
			{
				$('#'+j).remove();
				// Remove field
			}
			$('#myform').data('bootstrapValidator').resetForm(true);
			
			$('#inter_country').val("");
			$('#pickup').val("PICK UP SUBURB/POSTCODE");
			$('#myform').data('bootstrapValidator').resetForm(true);
			/*Start to enable domestic validation */
			$('#myform')
						.bootstrapValidator('enableFieldValidators', 'deliver');
			$('#myform')
						.bootstrapValidator('enableFieldValidators', 'Item_weight[]');
			$('#myform')
			.bootstrapValidator('enableFieldValidators', 'Item_width[]');
			$('#myform')
			.bootstrapValidator('enableFieldValidators', 'Item_length[]');
			$('#myform')
			.bootstrapValidator('enableFieldValidators', 'Item_height[]');
			/*End to enable domestic validation*/
			$("#flage").val("1");
		}
		$('#p_location_type').show();
		$('#d_location_type').show();
		$('#display_delivery').show();
		$('#international_country_display').hide();
		$('#size_display_block_international').hide();
		$('#size_display_block_1').show();
		
	}
	
})
function selectedInterItems(item_name)
{
	var fv = $('#myform').data('bootstrapValidator');
  
	if($('input[name="inter_ShippingType_1[]"]:checked').val() == 4){
		
		ajaxInterValidation();/*to set the validation from backened*/		
		$("#doc_1").addClass("active");
		var bootstrapValidator = $('#myform').data('bootstrapValidator');
		if (bootstrapValidator == undefined){
			//ValidateForm();
			$('#myform').data('bootstrapValidator').resetField('weight_item[]',true);
			$('#myform').data('bootstrapValidator').resetField('length_item[]',true);
			$('#myform').data('bootstrapValidator').resetField('width_item[]',true);
			$('#myform').data('bootstrapValidator').resetField('height_item[]',true);
		}
	}else{
		$("#doc_1").removeClass("active");
	}
	if($('input[name="inter_ShippingType_1[]"]:checked').val() == 5){
		
		ajaxInterValidation();/*to set the validation from backened*/		
		$("#doc_2").addClass("active");
		//
		var bootstrapValidator = $('#myform').data('bootstrapValidator');
		if (bootstrapValidator == undefined){
			//ValidateForm();
			$('#myform').data('bootstrapValidator').resetField('weight_item[]',true);
			$('#myform').data('bootstrapValidator').resetField('length_item[]',true);
			$('#myform').data('bootstrapValidator').resetField('width_item[]',true);
			$('#myform').data('bootstrapValidator').resetField('height_item[]',true);
		}
 
	}else{
		$("#doc_2").removeClass("active");
	}
}

function ajaxInterValidation()
{
	//ValidateForm();
	var pickupval = $('#pickup').val();
	var inter_country = $('#inter_country').val();
	var item_name = $('input[name="inter_ShippingType_1[]"]:checked').val();
	console.log("inside ajax interval"+pickupval+'-'+inter_country+item_name);

	if(inter_country){
	$.ajax({
	  url: 'related/ajax_aus_services.php',
	  type: 'post',
	  data: {'pickup':pickupval,'inter_country':inter_country,'item':item_name},
	  success: function(data, status) { 
		var res = data.split("$");
		
		
		var girtharr = res[2].split("#");
		var girth = girtharr[0];
		var length = res[1];
		//console.log(data+"res0:"+res[0]+"res1:"+res[1]+"res2:"+res[2]);
		$("#length_max_1").val(res[1]);
		$("#girth_max_1").val(girth);
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
$(function(){
    $(document).on('click', '#ajax_index_listOfOptions div', function(){
		/*if($('#pickup').val()){ //alert("hi");
			$('#myform').bootstrapValidator('revalidateField', 'pickup');
		}
		if($('#deliver').val()){
			$('#myform').bootstrapValidator('revalidateField', 'deliver');
		}*/
	});
})
/*
if($('#pickup').val())
{
	alert($('#pickup').val());
	$('#myform').bootstrapValidator('revalidateField', 'pickup');	
} */

function unsetSession()
{
 /* this function is to unset bookingitem object from session */
  $.ajax({
	type: "POST",
	url: 'related/destroyitems.php',
	data: '',
	success: function(data) {
	 // alert(data);
	}
  });
	
}
$('#postInt').click(function(){
	$('.containerBlock > form').waitMe('hide');
	$('#postcode_available').modal('hide');
});
</script>