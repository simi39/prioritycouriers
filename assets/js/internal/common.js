
function trim(sString) { 
	if(sString) { 
		if(sString.length!=null){
			while (sString.substring(0,1) == ' ')
			{
				sString = sString.substring(1, sString.length);
			}
			while (sString.substring(sString.length-1, sString.length) == ' ')
			{
				sString = sString.substring(0,sString.length-1);
			}
		}
	}	
	return sString;
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
function validateUsername(Str)
{
	/* this validation is for small,capital and apostrophe space */
	if (/[^a-zA-Z-\'\s]/.test(Str)) 
	{
		return false;
	}
	
}
function chkCapital(Str)
{
	/* this validation is capital */
	if (/[^A-Z]/.test(Str))
	{
		return false;
	}
}
function chkSmallCapital(Str)
{
	/* this validation is capital */
	if (/[^a-zA-Z]/.test(Str))
	{
		return false;
	}
}
function validSuburb(Str)
{
	/* this validation is for small,capital,number and space */
	if (/[^a-zA-Z\s\-]/.test(Str))
	{
		return false;
	}
}
function validateStr(Str)
{
	/* this validation is for small,capital,number and space */
	if (/[^a-zA-Z0-9\s]/.test(Str))
	{
		return false;
	}
}
function validateTrack(Str)
{
	/* this validation is for small,capital and number */
	if (/[^a-zA-Z0-9]/.test(Str))
	{
		return false;
	}

}
function validPostcode(Str)
{
	if (/[^0-9]/.test(Str))
	{
		return false;
	}
}
function validStreet(Str)
{
	/* small captial space and number backspace,hypen */
	if(/[^a-zA-Z0-9'\s\-\/]/.test(Str))
	{
		return false;
	}
}
function checkStr(Str)
{
	/* small captial space and number backspace,hypen */
	if(/[^a-zA-Z0-9',_.\s\-\/]/.test(Str))
	{
		return false;
	}
}
function checkMessage(Str)
{
	/* small captial space and number backspace,hypen */
	if(/[^a-zA-Z0-9',_.!\s\-\/]/.test(Str))
	{
		return false;
	}
}
function areaCodePattern(contact_no,msgstring,valid_format)
{
	
	var pattern;
	if(valid_format == 1)
	{
		pattern = /^[+]?[0-9]+$/;
	}
	else
	{
		pattern = /^[0-9]+$/;
	}
	if(!pattern.test(contact_no))
	{
		return msgstring;
	}else
	{
		return '';
	}
	if(valid_format == 1)
	{
		if(contact_no.length<1 || contact_no.length>4)
		{
			return "Enter the Area Code of lengths between 1 and 4";
		}else
		{
			return '';
		}
	}
	else
	{
		if(contact_no.length<6 || contact_no.length>16)
		{
			return "Enter the Contact Code of lengths between 6 and 16";
		}else
		{
			return '';
		}
		
	}
}
function validatePhone(sText)
{
	 var ValidChars = "0123456789 ";
	 var IsNumber=true;
	 var Char;

 
	for (i = 0; i < sText.length && IsNumber == true; i++) 
	  { 
	  Char = sText.charAt(i); 
	  if (ValidChars.indexOf(Char) == -1) 
		 {
		 IsNumber = false;
		 }
	  }
   return IsNumber;

}
function validateFax(checkField) {
    if (checkField.length > 0) {
        var faxRegEx = /^\+?[0-9]+$/;
        if (!checkField.match(faxRegEx)) {
            return false;
        }
    }
    return true;
}
function changeText(obj, defaultVal, type) {
	if(trim(obj.value) == '' && type == 'blur') {
		obj.value = defaultVal;
	}
	if(obj.value == defaultVal && type == 'focus') {
		obj.value = '';
	}
}
function popupWindow(url, width, height, resizable, scrollbars , top, left) {
	
	
	if(trim(url) != '') {
		
		if(width == '') { width = 150; }
		if(height == '') { height = 150; }
		
		resizable = resizable;
		if(resizable == '') { resizable = 'yes'; }
		
		scrollbars = scrollbars;
		if(scrollbars == '') { scrollbars = 'no'; }
		
		if(top == '') { top = 50; }
		if(left == '') { left = 50; }
		window.open(url,'popupWindow','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=' + scrollbars + ',resizable=' + resizable + ',copyhistory=no,width=' + width + ',height=' + height + ',top=' + top + ',left=' + left );
	}
}

function OpenHelp(url) {	
	url = "studio_help.php";
  window.open(url,'popupWindow','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=no,resizable=no,copyhistory=no,width=930,height=625,top=50,left=50');
}

function emailValidate(email) {
	var error = '';
	var emailFilter=/^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
	if (email.search(emailFilter) == -1) {
	       error = "error";
	}
	return error;
}
// Start isNumber function
function isNumber(numstr, errString) {
	
	numdecs = 0;
	for (i = 0; i < numstr.length; i++) {
		mychar = numstr.charAt(i);
		if ((mychar >= "0" && mychar <= "9") || mychar == "." ) {
			if (mychar ==  ".")
				numdecs++;
		} else {
			return errString;
		}
	}
	
	if (numdecs > 1) {
		return errString;
	}
	return '';
}
function numberDecimal(val,fieldName,formName){
	
	var decimalRe = new RegExp(/^\d*?(\.[0-9])?$/);
	var numRe = new RegExp(/^[0-9]*$/);
	
	//console.log("common.jsfile:val"+decimalRe.test(val)+"fieldname:"+fieldName+"formName:"+formName);
	if(numRe.test(val))
	{
		if(val.length>3)
		{
			var newnumber = val.substring(0, 3);
			$("#"+fieldName).val(newnumber);
		} 
		
	}else if(decimalRe.test(val)){
		
		var decstr = val.split('.');
		if(decstr!= undefined)
		{
			if(decstr[1].length>1)
			{
				var afterpointNum = decstr[1].substring(0, 1);
			}
			console.log("common.jsfile:decstr"+decstr[1]);
			if(afterpointNum != undefined)
			{
				
				var finalnumber = decstr[0]+"."+afterpointNum;
				$("#"+fieldName).val(finalnumber);
				var nameFiled = $("#"+fieldName).attr("name");
				//alert(nameFiled);
				$('#'+formName).bootstrapValidator('revalidateField', nameFiled);
			}
		}
	}
}
// Start isNumber function
function isCurrency(numstr, errString, dec_point, thousand_sep) {
	if(dec_point == '' || (thousand_sep != '.' && thousand_sep != "" )) {
		dec_point = '.';
	}
	if(thousand_sep == '' || (dec_point != ',' && dec_point != "" )) {
		thousand_sep = ',';
	}
	numdecs = 0;
	for (i = 0; i < numstr.length; i++) {
		mychar = numstr.charAt(i);
		if ((mychar >= "0" && mychar <= "9") || mychar == dec_point || mychar == thousand_sep ) {
			if (mychar == dec_point)
				numdecs++;
		} else {
			return errString;
		}
	}
	
	if (numdecs > 1) {
		return errString;
	}
	return '';
}
// end isNumber function

function print_url(url)
{
	var test ="toprint";
	window.open(url+"&t="+test,"popupWindow","menubar=no,scrollbars=yes,resizable=yes,width=428,height=680,top=120,left=340");
}



// Start : Ajax Object creation Function //
function GetXmlHttpObject(handler)
{
	var objXmlHttp=null

	if (navigator.userAgent.indexOf("Opera")>=0)
	{
		alert("This Site doesn't work in Opera")
		return
	}
	if (navigator.userAgent.indexOf("MSIE")>=0)
	{
		var strName="Msxml2.XMLHTTP"
		if (navigator.appVersion.indexOf("MSIE 5.5")>=0)
		{
			strName="Microsoft.XMLHTTP"
		}
		try
		{
			objXmlHttp=new ActiveXObject(strName)
			objXmlHttp.onreadystatechange=handler
			return objXmlHttp
		}
		catch(e)
		{
			alert("Error. Scripting for ActiveX might be disabled")
			return
		}
	}
	if (navigator.userAgent.indexOf("Mozilla")>=0)
	{
		objXmlHttp=new XMLHttpRequest()
		objXmlHttp.onload=handler
		objXmlHttp.onerror=handler
		return objXmlHttp
	}
}
function isValidCreditCard(type, ccnum) {

   if (type == "visa") {
      // Visa: length 16, prefix 4, dashes optional.
      var re = /^4\d{3}-?\d{4}-?\d{4}-?\d{4}$/;
   } else if (type == "master_card") {
      // Mastercard: length 16, prefix 51-55, dashes optional.
      var re = /^5[1-5]\d{2}-?\d{4}-?\d{4}-?\d{4}$/;
   } else if (type == "Disc") {
      // Discover: length 16, prefix 6011, dashes optional.
      var re = /^6011-?\d{4}-?\d{4}-?\d{4}$/;
   } else if (type == "american_express") {
      // American Express: length 15, prefix 34 or 37.
      var re = /^3[4,7]\d{13}$/;
   } else if (type == "Diners") {
      // Diners: length 14, prefix 30, 36, or 38.
      var re = /^3[0,6,8]\d{12}$/;
   }
   if (!re.test(ccnum)) return false;
   // Remove all dashes for the checksum checks to eliminate negative numbers
   ccnum = ccnum.split("-").join("");
   // Checksum ("Mod 10")
   // Add even digits in even length strings or odd digits in odd length strings.
   var checksum = 0;
   for (var i=(2-(ccnum.length % 2)); i<=ccnum.length; i+=2) {
      checksum += parseInt(ccnum.charAt(i-1));
   }
   // Analyze odd digits in even length strings or even digits in odd length strings.
   for (var i=(ccnum.length % 2) + 1; i<ccnum.length; i+=2) {
      var digit = parseInt(ccnum.charAt(i-1)) * 2;
      if (digit < 10) { checksum += digit; } else { checksum += (digit-9); }
   }
   if ((checksum % 10) == 0) return true; else return false;
}
// End : Ajax Object creation Function //
function contact_validation(txt_id,valid_format,error_id)
{
	var userPhoneNo = document.getElementById(txt_id).value;
	var flag = true;
	if(valid_format==1)
	{
		// validation for area code
		var validPhNo = /^[+]?[0-9]+$/; 
	}else
	{
		var validPhNo = /^[0-9]+$/;
	}
	var msgErrPh = '';
	if(validPhNo.test(userPhoneNo) == false) {
		$("#"+error_id).html("Enter only numeric values (0-9)");
		document.getElementById(txt_id).focus();
		flag = false;
		return false;
	}
	if(valid_format==1)
	{
		//validation for area code
		if(userPhoneNo.length < 1 || userPhoneNo.length > 4)
		{
			$("#"+error_id).html("Entered number length should be<br />1 digit to 4 digits");
			document.getElementById(txt_id).focus();
			flag = false;
			return false;
		}
	}
	else
	{
		if(userPhoneNo.length < 6 || userPhoneNo.length > 16)
		{
			$("#"+error_id).html("Entered number length should be<br />6 digits to 16 digits");
			document.getElementById(txt_id).focus();
			flag = false;
			return false;
			
		}
	}
	if(flag == true)
	{
		return true;
	}else
	{
		return false;
	}
	
}
String.prototype.replaceAll = function(target, replacement) {
  return this.split(target).join(replacement);
};
$(function(){
    $(document).on('click', '#ajax_index_listOfOptions div', function(){
        var changed_country_val = $("#changed_cntry").val();
		
		if(changed_country_val == 13)
		{
			var selected_id = trim(jQuery(this).text());
			
			$("#fsuburb").val(selected_id);/* Full name like Mascot NSW 2020 is only validated */
			var postcodedatawithid = selected_id.split(" ");//find the postcode id for pickup
			var maximum_index_of_array = postcodedatawithid.length;
			var suburb;
			//alert(maximum_index_of_array);
			var removeValFromIndex = new Array(maximum_index_of_array-2,maximum_index_of_array-1);
			//var suburb = (postcodedatawithid.length<=3)?(postcodedatawithid[0]):(postcodedatawithid[0]+" "+postcodedatawithid[1]);
			var suburb ='';
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
			//alert(suburb);
			
			$("#suburb").val(suburb);
			$("#state").val(postcodedatawithid[maximum_index_of_array-2]);
			$("#postcode").val(postcodedatawithid[maximum_index_of_array-1]);
			$("#suburb").attr('readonly','readonly');
			$("#state").attr('readonly','readonly');
			$("#postcode").attr('readonly','readonly');
			$('#addressbook_detail').bootstrapValidator('revalidateField', 'addressbook_detail_fsuburb');
			$('#quote_customer_details').bootstrapValidator('revalidateField', 'quote_customer_details_state');
			$('#quote_customer_details').bootstrapValidator('revalidateField', 'quote_customer_details_postcode');
			$('#quote_customer_details').bootstrapValidator('revalidateField', 'quote_customer_details_fsuburb');
			$('#Frmaddclient').bootstrapValidator('revalidateField', 'profile_fsuburb');
		}
    })
})
$("#suburb").keyup(
function(event){
		
		//alert("form id"+form_id);
		var changed_country_val = $("#changed_cntry").val();
		//alert("country_val:"+changed_country_val);
		if(changed_country_val == 13)
		{
			//alert("country_val:"+country_val);
			$('#selected_flag').val('australia');
			ajax_showOptions(this,'admin_search',event,'related/tms_index.php','ajax_index_listOfOptions');
			
		}else{
			$('#selected_flag').val('international');
		}
	}
);
		
function choose_country(id)
{
  
	$("#country_name").val($("#"+id+" option:selected").text());
	var country_val = document.getElementById(id).value;
	$("#changed_cntry").val(country_val);
	var form_id = $("#changed_cntry").closest("form").attr('id');
	
	if(country_val == '235')
	{
		$('#registration').bootstrapValidator('enableFieldValidators', 'profile_postcode', true, 'zipCode');
	}
	if(country_val == 13)
	{
		$("#state").attr('readonly','readonly');
		$("#postcode").attr('readonly','readonly');
		$('#selected_flag').val('australia');
		$("#suburb").keyup(
		function(event){
				
				var changed_country_val = $("#changed_cntry").val();
				if(changed_country_val == 13)
				{
					//alert("country_val:"+country_val);
					ajax_showOptions(this,'admin_search',event,'related/tms_index.php','ajax_index_listOfOptions');
				}
			}
		);
		jQuery("#ajax_index_listOfOptions div").live("click",function()
		{
			var changed_country_val = $("#changed_cntry").val();
			if(changed_country_val == 13)
			{
				var selected_id = trim(jQuery(this).text());
				

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
				$("#suburb").val(suburb);
				$("#state").val(postcodedatawithid[maximum_index_of_array-2]);
				$("#postcode").val(postcodedatawithid[maximum_index_of_array-1]);
				$("#suburb").attr('readonly','readonly');
				$("#state").attr('readonly','readonly');
				$("#postcode").attr('readonly','readonly');
			}
		});

			
	}else
	{
		
		$("#suburb").removeAttr('readonly');
		$("#state").removeAttr('readonly');
		$("#postcode").removeAttr('readonly','readonly');
		if($("#state_reg").val()!=undefined)
		{
			$("#state_reg").removeAttr('readonly');
			$("#state_reg").val("");
		}
		if($("#postcode_reg").val()!=undefined)
		{
			$("#postcode_reg").removeAttr('readonly');
			$("#postcode_reg").val("");
		}
		if($("#suburb_reg").val()!=undefined)
		{
			$("#suburb_reg").removeAttr('readonly');
			$("#suburb_reg").val("");
		}
		$("#suburb").val("");
		$("#state").val("");
		$("#postcode").val("");
		$('#selected_flag').val('international');
		$("#ajax_index_listOfOptions div").remove();
	}
}

$(".alert").find(".close").on("click", function (e) {
	// Find all elements with the "alert" class, get all descendant elements with the class "close", and bind a "click" event handler
	e.stopPropagation();    // Don't allow the click to bubble up the DOM
	e.preventDefault();    // Don't let any default functionality occur (in case it's a link)
	$(this).closest(".alert").slideUp(400);    // Hide this specific Alert
});

function getCurrentTime(date) { //alert("inside getcurrent time");
	var hours = date.getHours(),
		minutes = date.getMinutes(),
		ampm = hours >= 12 ? 'PM' : 'AM';

		if(minutes > 30 ){
			minutes = "00";
			hours ++;
		}
		else {
			minutes = "00";
		}
	hours = hours % 12;
	hours = hours ? hours : 12; // the hour '0' should be '12'

	return hours + ':' + minutes + ' ' + ampm;

}  
function zoneDateTimeSet(suburb,state)
{
	var zoneDate;
	moment.locale('en');
	
	if(state!=undefined)
	{
		switch (state)
		{
			case "NT":
				//Australia/North
				zoneDate = moment.tz('Australia/North').format('DD MMM YYYY h:mm a');
				break;
			case "SA":
				//Australia/South
				zoneDate = moment.tz('Australia/South').format('DD MMM YYYY h:mm a');
				break;
			case "WA":
				//Australia/West
				zoneDate = moment.tz('Australia/West').format('DD MMM YYYY h:mm a');
				break;
			case "NSW":
				if(suburb == "Broken Hill")
				//Australia/Broken_Hill
				zoneDate = moment.tz('Australia/Broken_Hill').format('DD MMM YYYY h:mm a');
				else
				//"Australia/NSW"
				zoneDate = moment.tz('Australia/NSW').format('DD MMM YYYY h:mm a');
				break;
			case "QLD":
				//Australia/Queensland
				zoneDate = moment.tz('Australia/Queensland').format('DD MMM YYYY h:mm a');
				break;
			case "VIC":
				//Australia/Victoria
				zoneDate = moment.tz('Australia/Victoria').format('DD MMM YYYY h:mm a');
				break;
			case "TAS":
				//Australia/Tasmania
				zoneDate = moment.tz('Australia/Tasmania').format('DD MMM YYYY h:mm a');
				break;
			case "ACT":
				//Australia/ACT
				zoneDate = moment.tz('Australia/ACT').format('DD MMM YYYY h:mm a');
				break;
			case "broken hill":
				//Australia/Broken_Hill
				zoneDate = moment.tz('Broken_Hill').format('DD MMM YYYY h:mm a');
				break;
			
		}
		return zoneDate;
	}
	
}


//setInterval(function(){alert("Hello")}, 5000);

//This condition opens Search tabs
if(location.hash == "#search-anchor"){
	
	$("#search-open-tab").addClass("just_block");
}

jQuery(document).ready(function() {
	App.init();
});
/*
// Clears popups if appropriate
function nd(time) {
	var olLoaded;
	if (olLoaded != 'undefined' && isExclusive() != 'undefined' &&  ! ()) {
		hideDelay(time);  // delay popup close if time specified

		if (o3_removecounter >= 1) { o3_showingsticky = 0 };
		
		if (o3_showingsticky == 0) {
			o3_allowmove = 0;
			if (over != null && o3_timerid == 0) runHook("hideObject", FREPLACE, over);
		} else {
			o3_removecounter++;
		}
	}
	
	return true;
}
*/
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
}


