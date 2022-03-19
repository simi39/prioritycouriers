<script language="javascript" type="text/javascript" >
$(document).ready(function()
{
	var default_county = $("#changed_cntry").val();
	if(default_county == 13)
	{
		$("#suburb").keyup(function(event){
			ajax_showOptions(this,'admin_search',event,"<?php echo DIR_HTTP_RELATED.'tms_index.php'; ?>",'ajax_index_listOfOptions');
		}); 
	}
	jQuery("#ajax_index_listOfOptions div").live("click",function()
	{
		if(default_county == 13)
		{
			var selected_id = trim(jQuery(this).text());
			var postcodedatawithid = selected_id.split(" ");//find the postcode id for pickup
			var maximum_index_of_array = postcodedatawithid.length;
					
			var suburb = (postcodedatawithid.length<=3)?(postcodedatawithid[0]):(postcodedatawithid[0]+" "+postcodedatawithid[1]);
			$("#suburb").val(postcodedatawithid[0]);
			$("#state").val(postcodedatawithid[maximum_index_of_array-2]);
			$("#postcode").val(postcodedatawithid[maximum_index_of_array-1]);
			$("#suburb").attr('readonly','readonly');
			$("#state").attr('readonly','readonly');
			$("#postcode").attr('readonly','readonly');
		}
	});
});
function validate_client(ObjForm) {
	
	var errorflag = false;
	
	/** Firstname Validation **/
	if(trim(ObjForm.firstname.value) == ''){
		document.getElementById("firstnameError").innerHTML = "<?php echo COMMON_FIRSTNAME_IS_REQUIRED; ?>";
		errorflag = true;
	} else  {
		document.getElementById("firstnameError").innerHTML = " ";
	}
	
	/** LastName Validation **/
	if(trim(ObjForm.lastname.value) == '')	{
		document.getElementById("lastnameError").innerHTML = "<?php echo COMMON_LASTNAME_IS_REQUIRED; ?>";
		errorflag = true;
	} else {
		document.getElementById("lastnameError").innerHTML = "";
	}
	
	/** Street Address Validation **/
	/*Edited condition by shailesh*/

	if(ObjForm.address1){
		if(trim(ObjForm.address1.value) == ''){
			document.getElementById("addressError").innerHTML = "<?php echo COMMON_ADDRESS_IS_REQUIRED; ?>";
			errorflag = true;
		} else {
			var validtest = validStreet(trim(ObjForm.address1.value));
			if(validtest == false)
			{
				document.getElementById("addressError").innerHTML = "<?php echo COMMON_SECURITY_ANSWER_ALPHANUMERIC; ?>";
				errorflag = true;
			}
			else
			{
				document.getElementById("addressError").innerHTML = "";
			}
		}
	}

	if(trim(ObjForm.address2.value)!='')
	{
		var validtest = validStreet(trim(ObjForm.address2.value));
		if(validtest == false)
		{
			document.getElementById("address2Error").innerHTML = "<?php echo COMMON_SECURITY_ANSWER_ALPHANUMERIC; ?>";
			errorflag = true;
		}
		else
		{
			document.getElementById("address2Error").innerHTML = "";
		}
	}

	if(trim(ObjForm.address3.value)!='')
	{
		var validtest = validStreet(trim(ObjForm.address3.value));
		if(validtest == false)
		{
			document.getElementById("address3Error").innerHTML = "<?php echo COMMON_SECURITY_ANSWER_ALPHANUMERIC; ?>";
			errorflag = true;
		}
		else
		{
			document.getElementById("address3Error").innerHTML = "";
		}
	}
	
	
	//Added upper condition by shailesh on date 10-6-2013
	
	if(ObjForm.suburb){	
		if(trim(ObjForm.suburb.value) == ''){ 
			document.getElementById("suburbError").innerHTML = "<?php echo COMM0N_SUBURB_IS_REQUIRED; ?>";
			errorflag = true;
		} else {
			var validtest = validateUsername(trim(ObjForm.suburb.value));
			if(validtest == false)
			{
				document.getElementById("suburbError").innerHTML = "<?php echo COMMON_NAME_ALPHABETHS; ?>";
				errorflag = true;
			}
			else
			{
				document.getElementById("suburbError").innerHTML = "";
			}

			document.getElementById("suburbError").innerHTML = "";
		}
	}
	
	
	/** Postcode Validation **/	
	if(trim(ObjForm.postcode.value) == ''){
		document.getElementById("postcodeError").innerHTML = "<?php echo COMMON_ZIPCODE_IS_REQUIRED; ?>";
		errorflag = true;
	} else {
		var validtest = validPostcode(trim(ObjForm.postcode.value));
		if(validtest == false)
		{
			document.getElementById("postcodeError").innerHTML = "<?php echo COMM0N_ZIPCODE_IS_NUMERIC; ?>";
			errorflag = true;
		}
		else
		{
			document.getElementById("postcodeError").innerHTML = "";
		}
		
	}
	
	/** State Validation 	**/
	if(trim(ObjForm.state.value) == ''){
		document.getElementById("stateError").innerHTML = "<?php echo COMMON_STATE_IS_REQUIRED; ?>";
		errorflag = true;
	} else {
		var validtest = chkCapital(trim(ObjForm.state.value));
		if(validtest == false)
		{
			document.getElementById("stateError").innerHTML = "<?php echo COMMON_CAPITAL_LETTERS; ?>";
			errorflag = true;
		}
		else
		{
			document.getElementById("stateError").innerHTML = "";
		}
		
	}
	
	
	/** Country Validation **/	
	if(trim(ObjForm.country.value) == ''){
		document.getElementById("countryError").innerHTML = "<?php echo COMMON_COUNTRY_IS_REQUIRED; ?>";
		errorflag = true;
	} else {
		document.getElementById("countryError").innerHTML = "";
	}
	
	
	
	/** Phone Validation **/	
	if(trim(document.getElementById("phone_number").value) == ''){
		document.getElementById("phoneError").innerHTML = "<?php echo COMMON_PHONE_IS_REQUIRED; ?>";
		errorflag = true;
	} else {
		document.getElementById("phoneError").innerHTML = "";
	}
	
	
	/** Phone Validation **/	
	if(trim(document.getElementById("mobile_phone").value) != ''){
		var area_code = trim(document.getElementById("mobile_phone").value);
		var valid = areaCodePattern(area_code,"<?php echo ERROR_AREA_CODE_INVALID; ?>",0);
		if(valid != '')
		{
			document.getElementById("mobileError").innerHTML = valid;
			errorflag = true;
		}
		else
		{
			document.getElementById("mobileError").innerHTML = "";
		}
		
	}

	/** Security Question Validation **/

	if(document.getElementById('security_ques_1').length>0 && trim(ObjForm.security_ques_1.value) == 0){
		document.getElementById("securityQuesError_1").innerHTML = "<?php echo COMMON_SECURITY_QUESTION_IS_REQUIRED; ?>";
		errorflag = true;
	} else {
		
		document.getElementById("securityQuesError_1").innerHTML = "";
	}
	//return false;
	if(trim(ObjForm.security_ans_1.value) == '')
	{
		//alert(ObjForm.security_ans.value);
		document.getElementById("securityAnsError_1").innerHTML = "<?php echo COMMON_SECURITY_ANSWER_IS_REQUIRED; ?>";
		errorflag = true;
	}
	
	if(trim(ObjForm.security_ans_1.value)!='')
	{
		var validtest = validateUsername(trim(ObjForm.security_ans_1.value));
		
		if(validtest == false)
		{
			document.getElementById("securityAnsError_1").innerHTML =  "<?php echo COMMON_SECURITY_ANSWER_ALPHANUMERIC; ?>";
			errorflag = true;
		}
		else
		{
			document.getElementById("securityAnsError_1").innerHTML = "";
		}
		
	}

	if(document.getElementById('security_ques_2').length>0 && trim(ObjForm.security_ques_2.value) == 0){
		document.getElementById("securityQuesError_2").innerHTML = "<?php echo COMMON_SECURITY_QUESTION_IS_REQUIRED; ?>";
		errorflag = true;
	} else {
		
		document.getElementById("securityQuesError_2").innerHTML = "";
	}
	//return false;
	if(trim(ObjForm.security_ans_2.value) == '')
	{
		//alert(ObjForm.security_ans.value);
		document.getElementById("securityAnsError_2").innerHTML = "<?php echo COMMON_SECURITY_ANSWER_IS_REQUIRED; ?>";
		errorflag = true;
	}
	
	if(trim(ObjForm.security_ans_2.value)!='')
	{
		var validtest = validateUsername(trim(ObjForm.security_ans_2.value));
		
		if(validtest == false)
		{
			document.getElementById("securityAnsError_2").innerHTML =  "<?php echo COMMON_SECURITY_ANSWER_ALPHANUMERIC; ?>";
			errorflag = true;
		}
		else
		{
			document.getElementById("securityAnsError_2").innerHTML = "";
		}
		
	}
	

	/** Email Validation **/
	if(ObjForm.email) {
		
		if(trim(ObjForm.email.value) == ''){
			document.getElementById("emailError").innerHTML = "<?php echo COMMON_EMAIL_IS_REQUIRED; ?>";
			errorflag = true;
		} else {
			document.getElementById("emailError").innerHTML = "";
		}
	}
	if(trim(ObjForm.email.value) != '')
	{
		var valid = emailValidate(trim(ObjForm.email.value));
		if(valid)
		{
			document.getElementById("emailError").innerHTML = "<?php echo ERROR_EMAIL_ID_INVALID; ?>";
			errorflag = true;
		} else {
		
			document.getElementById("emailError").innerHTML = "";
		}
		
	}	
	
	var userid = '<?php if($_GET['userid']!=""){$err['userid'] = isNumeric($_GET['userid'],"Please enter numeric values");} if($err['userid']){ echo "error";}else{echo $_GET['userid'];}?>';
	
	if(userid == 'error')
	{
		errorflag = true;
	}
	var useriderr;
	
	if(userid != '')
	{
		useriderr = isNumber(userid,"Please enter numeric value for userid.");
		if(useriderr)
		{
			alert(useriderr);
			errorflag = true;
		}
	}
	
	/** Password Validation **/
	if(userid == "")
	{
		if(ObjForm.password) {
			if(trim(ObjForm.password.value) == ''){
				document.getElementById("passwordError").innerHTML = "<?php echo COMMON_PASSWORD_IS_REQUIRED; ?>";
				errorflag = true;
			} else {
				document.getElementById("passwordError").innerHTML = "";
			}
		}
		
		if(ObjForm.confirmpassword) {
			if(trim(ObjForm.confirmpassword.value) == ''){
				document.getElementById("confirmpasswordError").innerHTML = "<?php echo COMMON_CONFIRM_PASSWORD_IS_REQUIRED; ?>";
				errorflag = true;
			} else {
				document.getElementById("confirmpasswordError").innerHTML = "";
			}		
		
		
			
			if(trim(ObjForm.confirmpassword.value) != ''){
				if(trim(ObjForm.confirmpassword.value) != trim(ObjForm.password.value) ){
					document.getElementById("confirmpasswordError").innerHTML = "<?php echo COMMON_CONFIRM_PASSWORD_DIFFERENT_ERROR; ?>";
					errorflag = true;
				} else {
					document.getElementById("confirmpasswordError").innerHTML = "";
				}
			}
		}
	}		
	//console.log("errorflag:"+errorflag);
	//return false;

	if(errorflag == true){
		return false;
	}else{
		document.getElementById("frmuser").submit();
	}
}
function validate_register(ObjForm) {
	
	var errorflag = false;
	
	/** Firstname Validation **/
	if(trim(ObjForm.firstname.value) == ''){
		document.getElementById("firstnameError").innerHTML = "<?php echo COMMON_FIRSTNAME_IS_REQUIRED; ?>";
		errorflag = true;
	} else  {
		var validtest = validateUsername(trim(ObjForm.firstname.value));
		var letters = trim(ObjForm.firstname.value);
		var len = letters.length;
		letters = letters.substr(0,2);
		
		if(validtest == false)
		{
			document.getElementById("firstnameError").innerHTML = "<?php echo COMMON_NAME_ALPHABETHS; ?>";
			errorflag = true;
		}else if(len<2){
			document.getElementById("firstnameError").innerHTML = "<?php echo ENTER_CHARACTER; ?>";
			errorflag = true;
		}
		else
		{
			document.getElementById("firstnameError").innerHTML = " ";
		}
	}

	/** LastName Validation **/
	if(trim(ObjForm.lastname.value) == '')	{
		document.getElementById("lastnameError").innerHTML = "<?php echo COMMON_LASTNAME_IS_REQUIRED; ?>";
		errorflag = true;
	} else {
		var validtest = validateUsername(trim(ObjForm.lastname.value));
		var letters = trim(ObjForm.lastname.value);
		var len = letters.length;
		letters = letters.substr(0,2);
		if(validtest == false)
		{
			document.getElementById("lastnameError").innerHTML = "<?php echo COMMON_NAME_ALPHABETHS; ?>";
			errorflag = true;
		}else if(len<2){
			document.getElementById("lastnameError").innerHTML = "<?php echo ENTER_CHARACTER; ?>";
			errorflag = true;
		}else
		{
			document.getElementById("lastnameError").innerHTML = "";
		}
		
	}

	/** Street Address Validation **/
	/*Edited condition by shailesh*/	
	if(ObjForm.address1){
		if(trim(ObjForm.address1.value) == ''){
			document.getElementById("addressError").innerHTML = "<?php echo COMMON_ADDRESS_IS_REQUIRED; ?>";
			errorflag = true;
		} else {
			var validtest = validStreet(trim(ObjForm.address1.value));
			if(validtest == false)
			{
				document.getElementById("addressError").innerHTML = "<?php echo COMMON_ADDRESS_CHARACTERS; ?>";
				errorflag = true;
			}
			else
			{
				document.getElementById("addressError").innerHTML = "";
			}
		}
	}
	if(trim(ObjForm.address2.value)!='')
	{
		var validtest = validStreet(trim(ObjForm.address2.value));
		if(validtest == false)
		{
			document.getElementById("address2Error").innerHTML = "<?php echo COMMON_ADDRESS_CHARACTERS; ?>";
			errorflag = true;
		}
		else
		{
			document.getElementById("address2Error").innerHTML = "";
		}
	}
	if(trim(ObjForm.address3.value)!='')
	{
		var validtest = validStreet(trim(ObjForm.address3.value));
		if(validtest == false)
		{
			document.getElementById("address3Error").innerHTML = "<?php echo COMMON_ADDRESS_CHARACTERS; ?>";
			errorflag = true;
		}
		else
		{
			document.getElementById("address3Error").innerHTML = "";
		}
	}
	/** City Validation **/
	//Added upper condition by shailesh on date 10-6-2013
	if(ObjForm.suburb){	
		if(trim(ObjForm.suburb.value) == ''){
			document.getElementById("suburbError").innerHTML = "<?php echo COMM0N_SUBURB_IS_REQUIRED; ?>";
			errorflag = true;
		} else {
			var validtest = validateUsername(trim(ObjForm.suburb.value));
			if(validtest == false)
			{
				document.getElementById("suburbError").innerHTML = "<?php echo COMMON_NAME_ALPHABETHS; ?>";
				errorflag = true;
			}
			else
			{
				document.getElementById("suburbError").innerHTML = "";
			}
			
		}
	}
	/** Postcode Validation **/	
	if(trim(ObjForm.postcode.value) == ''){
		document.getElementById("postcodeError").innerHTML = "<?php echo COMMON_ZIPCODE_IS_REQUIRED; ?>";
		errorflag = true;
	} else {
		var validtest = validPostcode(trim(ObjForm.postcode.value));
		if(validtest == false)
		{
			document.getElementById("postcodeError").innerHTML = "<?php echo COMM0N_ZIPCODE_IS_NUMERIC; ?>";
			errorflag = true;
		}
		else
		{
			document.getElementById("postcodeError").innerHTML = "";
		}
		
	}

	/** State Validation 	**/
	if(trim(ObjForm.state.value) == ''){
		document.getElementById("stateError").innerHTML = "<?php echo COMMON_STATE_IS_REQUIRED; ?>";
		errorflag = true;
	} else {
		var validtest = chkCapital(trim(ObjForm.state.value));
		if(validtest == false)
		{
			document.getElementById("stateError").innerHTML = "<?php echo COMMON_CAPITAL_LETTERS; ?>";
			errorflag = true;
		}
		else
		{
			document.getElementById("stateError").innerHTML = "";
		}
			
	}
	
	/** Country Validation **/	
	if(trim(ObjForm.country.value) == ''){
		document.getElementById("countryError").innerHTML = "<?php echo COMMON_COUNTRY_IS_REQUIRED; ?>";
		errorflag = true;
	} else {
		document.getElementById("countryError").innerHTML = "";
	}
	
	/* Area code validation */
	if(trim(ObjForm.sender_area_code.value) == ''){
		document.getElementById("areaCodeError").innerHTML = "<?php echo COMMON_AREA_CODE_IS_REQUIRED; ?>";
		errorflag = true;
	} else {
		var area_code = trim(ObjForm.sender_area_code.value);
		var valid = areaCodePattern(area_code,"<?php echo ERROR_AREA_CODE_INVALID; ?>",1);
		if(valid != '')
		{
			document.getElementById("areaCodeError").innerHTML = valid;
			errorflag = true;
		}
		else
		{
			document.getElementById("areaCodeError").innerHTML = "";
		}
	}
	
	/** Phone Validation **/	
	if(trim(ObjForm.phone.value) == ''){
		document.getElementById("phoneError").innerHTML = "<?php echo COMMON_PHONE_IS_REQUIRED; ?>";
		errorflag = true;
	} else {
		var area_code = trim(ObjForm.phone.value);
		var valid = areaCodePattern(area_code,"<?php echo ERROR_AREA_CODE_INVALID; ?>",0);
		if(valid != '')
		{
			document.getElementById("phoneError").innerHTML = valid;
			errorflag = true;
		}
		else
		{
			document.getElementById("phoneError").innerHTML = "";
		}
		
	}
	
	/* Area code validation */
	if(trim(ObjForm.sender_mb_area_code.value) != ''){
		var area_code = trim(ObjForm.sender_mb_area_code.value);
		var valid = areaCodePattern(area_code,"<?php echo ERROR_AREA_CODE_INVALID; ?>",1);
		if(valid != '')
		{
			document.getElementById("mareaCodeError").innerHTML = valid;
			errorflag = true;
		}
		else
		{
			document.getElementById("mareaCodeError").innerHTML = "";
		}
	}
	
	/** Phone Validation **/	
	if(trim(ObjForm.mobile_phone.value) != ''){
		var area_code = trim(ObjForm.mobile_phone.value);
		var valid = areaCodePattern(area_code,"<?php echo ERROR_AREA_CODE_INVALID; ?>",0);
		if(valid != '')
		{
			document.getElementById("mobileError").innerHTML = valid;
			errorflag = true;
		}
		else
		{
			document.getElementById("mobileError").innerHTML = "";
		}
		
	}
	
	/*Facsimile No*/
	if(trim(ObjForm.facsimile_no.value) !='')
	{
		var fax_no = trim(ObjForm.facsimile_no.value);
		var valid = validateFax(fax_no);
		if(valid == false)
		{
			document.getElementById("facsimileError").innerHTML = '<?php echo COMMON_VALID_FAX_NO; ?>';
			errorflag = true;
		}
		else
		{
			document.getElementById("facsimileError").innerHTML = "";
		}
	}
	
	
	
	/** Email Validation **/
	if(ObjForm.email) {
		
		if(trim(ObjForm.email.value) == ''){
			document.getElementById("emailError").innerHTML = "<?php echo COMMON_EMAIL_IS_REQUIRED; ?>";
			errorflag = true;
		} else {
			document.getElementById("emailError").innerHTML = "";
		}
	}
	
	if(trim(ObjForm.email.value) != '')
	{
		var valid = emailValidate(trim(ObjForm.email.value));
		if(valid)
		{
			document.getElementById("emailError").innerHTML = "<?php echo ERROR_EMAIL_ID_INVALID; ?>";
			errorflag = true;
		} else {
		
			document.getElementById("emailError").innerHTML = "";
		}
		
	}	
			
	/** Security Question Validation **/
	if(trim(ObjForm.security_ques.value) == 0){
		document.getElementById("securityQuesError").innerHTML = "<?php echo COMMON_SECURITY_QUESTION_IS_REQUIRED; ?>";
		errorflag = true;
	} else {
		if(trim(ObjForm.security_ans.value) == '')
		{
			//alert(ObjForm.security_ans.value);
			document.getElementById("securityAnsError").innerHTML = "<?php echo COMMON_SECURITY_ANSWER_IS_REQUIRED; ?>";
			errorflag = true;
		}
		document.getElementById("securityQuesError").innerHTML = "";
	}	
	if(trim(ObjForm.security_ans.value)!='')
	{
		var valid = validateUsername(trim(ObjForm.security_ans.value));
		if(valid == false)
		{
			document.getElementById("securityAnsError").innerHTML =  "<?php echo COMMON_SECURITY_ANSWER_ALPHANUMERIC; ?>";
			errorflag = true;
		}
		document.getElementById("securityQuesError").innerHTML = "";
	}
		
	/** Password Validation **/	
	if(ObjForm.password) {
		if(trim(ObjForm.password.value) == ''){
			document.getElementById("passwordError").innerHTML = "<?php echo COMMON_PASSWORD_IS_REQUIRED; ?>";
			errorflag = true;
		} else {
			document.getElementById("passwordError").innerHTML = "";
		}
	}
	
	if(ObjForm.confirmpassword) {
		if(trim(ObjForm.confirmpassword.value) == ''){
			document.getElementById("confirmpasswordError").innerHTML = "<?php echo COMMON_CONFIRM_PASSWORD_IS_REQUIRED; ?>";
			errorflag = true;
		} else {
			document.getElementById("confirmpasswordError").innerHTML = "";
		}		
	
	
		
		if(trim(ObjForm.confirmpassword.value) != ''){
			if(trim(ObjForm.confirmpassword.value) != trim(ObjForm.password.value) ){
				document.getElementById("confirmpasswordError").innerHTML = "<?php echo COMMON_CONFIRM_PASSWORD_DIFFERENT_ERROR; ?>";
				errorflag = true;
			} else {
				document.getElementById("confirmpasswordError").innerHTML = "";
			}
		}
	}
	
	if(errorflag == true){
		return false;
	}else{
		$('#confirmBox').modal('show');
		//document.getElementById("frmuser").submit();
	}
}

function validate_profile(ObjForm) {
	
	var errorflag = false;
	
	/** Firstname Validation **/
	if(trim(ObjForm.firstname.value) == ''){
		document.getElementById("firstnameError").innerHTML = "<?php echo COMMON_FIRSTNAME_IS_REQUIRED; ?>";
		errorflag = true;
	} else  {
		var validtest = validateUsername(trim(ObjForm.firstname.value));
		var letters = trim(ObjForm.firstname.value);
		var len = letters.length;
		letters = letters.substr(0,2);
		if(validtest == false)
		{
			document.getElementById("firstnameError").innerHTML = "<?php echo COMMON_NAME_ALPHABETHS; ?>";
			errorflag = true;
		}else if(len<2){
			document.getElementById("firstnameError").innerHTML = "<?php echo ENTER_CHARACTER; ?>";
			errorflag = true;
		}else
		{
			document.getElementById("firstnameError").innerHTML = " ";
		}
		
	}
	
	/** LastName Validation **/
	if(trim(ObjForm.lastname.value) == '')	{
		document.getElementById("lastnameError").innerHTML = "<?php echo COMMON_LASTNAME_IS_REQUIRED; ?>";
		errorflag = true;
	} else {
		var validtest = validateUsername(trim(ObjForm.lastname.value));
		var letters = trim(ObjForm.lastname.value);
		var len = letters.length;
		letters = letters.substr(0,2);
		if(validtest == false)
		{
			document.getElementById("lastnameError").innerHTML = "<?php echo COMMON_NAME_ALPHABETHS; ?>";
			errorflag = true;
		}else if(len<2){
			document.getElementById("lastnameError").innerHTML = "<?php echo ENTER_CHARACTER; ?>";
			errorflag = true;
		}else
		{
			document.getElementById("lastnameError").innerHTML = "";
		}
	}
	
	/** Street Address Validation **/
	/*Edited condition by shailesh*/	
	if(ObjForm.address1){
		if(trim(ObjForm.address1.value) == ''){
			document.getElementById("addressError").innerHTML = "<?php echo COMMON_ADDRESS_IS_REQUIRED; ?>";
			errorflag = true;
		} else {
			var validtest = validStreet(trim(ObjForm.address1.value));
			if(validtest == false)
			{
				document.getElementById("addressError").innerHTML = "<?php echo COMMON_ADDRESS_CHARACTERS; ?>";
				errorflag = true;
			}
			else
			{
				document.getElementById("addressError").innerHTML = "";
			}
			
		}
	}
	if(trim(ObjForm.address2.value)!='')
	{
		var validtest = validStreet(trim(ObjForm.address2.value));
		if(validtest == false)
		{
			document.getElementById("address2Error").innerHTML = "<?php echo COMMON_ADDRESS_CHARACTERS; ?>";
			errorflag = true;
		}
		else
		{
			document.getElementById("address2Error").innerHTML = "";
		}
	}
	if(trim(ObjForm.address3.value)!='')
	{
		var validtest = validStreet(trim(ObjForm.address3.value));
		if(validtest == false)
		{
			document.getElementById("address3Error").innerHTML = "<?php echo COMMON_ADDRESS_CHARACTERS; ?>";
			errorflag = true;
		}
		else
		{
			document.getElementById("address3Error").innerHTML = "";
		}
	}
	
	/** City Validation **/
	//Added upper condition by shailesh on date 10-6-2013
	if(ObjForm.suburb){	
		if(trim(ObjForm.suburb.value) == ''){
			document.getElementById("suburbError").innerHTML = "<?php echo COMM0N_SUBURB_IS_REQUIRED; ?>";
			errorflag = true;
		} else {
			var validtest = validateUsername(trim(ObjForm.suburb.value));
			if(validtest == false)
			{
				document.getElementById("suburbError").innerHTML = "<?php echo COMMON_NAME_ALPHABETHS; ?>";
				errorflag = true;
			}
			else
			{
				document.getElementById("suburbError").innerHTML = "";
			}
			
		}
	}
	/** Postcode Validation **/	
	if(trim(ObjForm.postcode.value) == ''){
		document.getElementById("postcodeError").innerHTML = "<?php echo COMMON_ZIPCODE_IS_REQUIRED; ?>";
		errorflag = true;
	} else {
		var validtest = validPostcode(trim(ObjForm.postcode.value));
		if(validtest == false)
		{
			document.getElementById("postcodeError").innerHTML = "<?php echo COMM0N_ZIPCODE_IS_NUMERIC; ?>";
			errorflag = true;
		}
		else
		{
			document.getElementById("postcodeError").innerHTML = "";
		}
		
	}

	/** State Validation 	**/
	if(trim(ObjForm.state.value) == ''){
		document.getElementById("stateError").innerHTML = "<?php echo COMMON_STATE_IS_REQUIRED; ?>";
		errorflag = true;
	} else {
		var validtest = chkCapital(trim(ObjForm.state.value));
		if(validtest == false)
		{
			document.getElementById("stateError").innerHTML = "<?php echo COMMON_CAPITAL_LETTERS; ?>";
			errorflag = true;
		}
		else
		{
			document.getElementById("stateError").innerHTML = "";
		}
		
	}
	
	/** Country Validation **/	
	if(trim(ObjForm.country.value) == ''){
		document.getElementById("countryError").innerHTML = "<?php echo COMMON_COUNTRY_IS_REQUIRED; ?>";
		errorflag = true;
	} else {
		document.getElementById("countryError").innerHTML = "";
	}
	
	/* Area code validation */
	if(trim(ObjForm.sender_area_code.value) == ''){
		document.getElementById("areaCodeError").innerHTML = "<?php echo COMMON_AREA_CODE_IS_REQUIRED; ?>";
		errorflag = true;
	} else {
		var area_code = trim(ObjForm.sender_area_code.value);
		var valid = areaCodePattern(area_code,"<?php echo ERROR_AREA_CODE_INVALID; ?>",1);
		if(valid != '')
		{
			document.getElementById("areaCodeError").innerHTML = valid;
			errorflag = true;
		}
		else
		{
			document.getElementById("areaCodeError").innerHTML = "";
		}
		
	}
	
	/** Phone Validation **/	
	if(trim(ObjForm.phone.value) == ''){
		document.getElementById("phoneError").innerHTML = "<?php echo COMMON_PHONE_IS_REQUIRED; ?>";
		errorflag = true;
	} else {
		var area_code = trim(ObjForm.phone.value);
		var valid = areaCodePattern(area_code,"<?php echo ERROR_AREA_CODE_INVALID; ?>",0);
		if(valid != '')
		{
			document.getElementById("phoneError").innerHTML = valid;
			errorflag = true;
		}
		else
		{
			document.getElementById("phoneError").innerHTML = "";
		}
	}
	/* Area code validation */
	if(trim(document.getElementById("sender_mb_area_code").value) != ''){
		var area_code = trim(document.getElementById("sender_mb_area_code").value);
		var valid = areaCodePattern(area_code,"<?php echo ERROR_AREA_CODE_INVALID; ?>",1);
		if(valid != '')
		{
			document.getElementById("mareaCodeError").innerHTML = valid;
			errorflag = true;
		}
		else
		{
			document.getElementById("mareaCodeError").innerHTML = "";
		}
	}
	
	/** Phone Validation **/	
	if(trim(document.getElementById("mobile_phone").value) != ''){
		var area_code = trim(document.getElementById("mobile_phone").value);
		var valid = areaCodePattern(area_code,"<?php echo ERROR_AREA_CODE_INVALID; ?>",0);
		if(valid != '')
		{
			document.getElementById("mobileError").innerHTML = valid;
			errorflag = true;
		}
		else
		{
			document.getElementById("mobileError").innerHTML = "";
		}
		
	}
	/*Facsimile No*/
	if(trim(ObjForm.facsimile_no.value) !='')
	{
		var fax_no = trim(ObjForm.facsimile_no.value);
		var valid = validateFax(fax_no);
		if(valid == false)
		{
			document.getElementById("facsimileError").innerHTML = '<?php echo COMMON_VALID_FAX_NO; ?>';
			errorflag = true;
		}
		else
		{
			document.getElementById("facsimileError").innerHTML = "";
		}
	}
	if(trim(ObjForm.email.value) != '')
	{
		var valid = emailValidate(trim(ObjForm.email.value));
		if(valid)
		{
			document.getElementById("emailError").innerHTML = "<?php echo ERROR_EMAIL_ID_INVALID; ?>";
			errorflag = true;
		} else {
		
			document.getElementById("emailError").innerHTML = "";
		}
	}	
		
	/** Security Question Validation **/
	if(trim(ObjForm.security_ques.value) == 0){
		document.getElementById("securityQuesError").innerHTML = "<?php echo COMMON_SECURITY_QUESTION_IS_REQUIRED; ?>";
		errorflag = true;
	} else {
		if(trim(ObjForm.security_ans.value) == '')
		{
			//alert(ObjForm.security_ans.value);
			document.getElementById("securityAnsError").innerHTML = "<?php echo COMMON_SECURITY_ANSWER_IS_REQUIRED; ?>";
			errorflag = true;
		}
		document.getElementById("securityAnsError").innerHTML = "";
	}
	if(trim(ObjForm.security_ans.value)!='')
	{
		var valid = validateUsername(trim(ObjForm.security_ans.value));
		if(valid == false)
		{
			document.getElementById("securityAnsError").innerHTML =  "<?php echo COMMON_SECURITY_ANSWER_ALPHANUMERIC; ?>";
			errorflag = true;
		}
		document.getElementById("securityAnsError").innerHTML = "";
	}
	/*
	if(ObjForm.email) {
		
		if(trim(ObjForm.email.value) == ''){
			document.getElementById("emailError").innerHTML = "<?php echo COMMON_EMAIL_IS_REQUIRED; ?>";
			errorflag = true;
		} else {
			document.getElementById("emailError").innerHTML = "";
		}
	}
		*/
		
		
	/** Password Validation **/	
	/*
	if(ObjForm.password) {
		if(trim(ObjForm.password.value) == ''){
			document.getElementById("passwordError").innerHTML = "<?php echo COMMON_PASSWORD_IS_REQUIRED; ?>";
			errorflag = true;
		} else {
			document.getElementById("passwordError").innerHTML = "";
		}
	}
	*/
	if(ObjForm.password) {
		if(trim(ObjForm.password.value) != ''){
			if(ObjForm.confirmpassword) {
				if(trim(ObjForm.confirmpassword.value) == ''){
					document.getElementById("confirmpasswordError").innerHTML = "<?php echo COMMON_CONFIRM_PASSWORD_IS_REQUIRED; ?>";
					errorflag = true;
				} else {
					document.getElementById("confirmpasswordError").innerHTML = "";
				}		
			
			
				
				if(trim(ObjForm.confirmpassword.value) != ''){
					if(trim(ObjForm.confirmpassword.value) != trim(ObjForm.password.value) ){
						document.getElementById("confirmpasswordError").innerHTML = "<?php echo COMMON_CONFIRM_PASSWORD_DIFFERENT_ERROR; ?>";
						errorflag = true;
					} else {
						document.getElementById("confirmpasswordError").innerHTML = "";
					}
				}
			}
		}	
	}
	
	var old_email = trim(ObjForm.email_old.value);
	var new_email = trim(ObjForm.email.value);
	var chg_pwd_val = false;
	if(old_email != new_email)
	{
		chg_pwd_val = true;
	}
	var old_security_question = trim(ObjForm.old_security_question.value);
	var new_security_question = trim(ObjForm.security_ques.value);
	if(old_security_question != new_security_question)
	{
		chg_pwd_val = true;
	}
	
	var old_security_ans = trim(ObjForm.old_security_ans.value);
	var new_security_ans = trim(ObjForm.security_ans.value);
	if(old_security_ans != new_security_ans)
	{
		chg_pwd_val = true;
	}
	//alert(trim(ObjForm.email_old.value));
	//return false;
	//if(trim(ObjForm.valid_pass.value) == 'invalid')
	if(chg_pwd_val == true)
	{
		/** Email Validation **/
	
	if(ObjForm.oldpassword) {
		if(trim(ObjForm.oldpassword.value) == ''){
			document.getElementById("existpasswordError").innerHTML = "<?php echo COMMON_PASSWORD_IS_REQUIRED; ?>";
			errorflag = true;
		} else {
			document.getElementById("existpasswordError").innerHTML = "";
		}
	}
	
	
	
	}
	if(errorflag == true){
		return false;
	}else{
	   
	    //alert();
		//return true;
		document.getElementById("frmuser").submit();
	}
}
function show_password(ObjForm)
{
 document.getElementById("existing_pass_show").style.display ='block';
 document.getElementById("valid_pass").value ='invalid';
 
}
function validate_address(ObjForm) {
		
	var errorflag = false;
	if(trim(ObjForm.firstname.value) == '')
	{

		document.getElementById("FNameError").innerHTML = "<?php echo COMMON_FIRSTNAME_IS_REQUIRED; ?>";
		errorflag = true;

	}
	else  {
		document.getElementById("FNameError").innerHTML = "";
	}
	if(trim(ObjForm.lastname.value) == '')
	{

		document.getElementById("LNameError").innerHTML = "<?php echo COMMON_LASTNAME_IS_REQUIRED; ?>";
		errorflag = true;
	}
	else {
		document.getElementById("LNameError").innerHTML = "";
	}

	if(trim(ObjForm.street_address.value) == '')
	{
		document.getElementById("SNameError").innerHTML = "<?php echo COMMON_STREET_IS_REQUIRED; ?>";
		errorflag = true;
	}
	else {
		document.getElementById("SNameError").innerHTML = "";
	}
	if(trim(ObjForm.city.value) == '')
	{

		document.getElementById("CityNameError").innerHTML = "<?php echo COMMON_CITY_IS_REQUIRED; ?>";
		errorflag = true;
	}
	else {
		document.getElementById("CityNameError").innerHTML = "";
	}
	if(trim(ObjForm.postcode.value) == '')
	{
		document.getElementById("PostNameError").innerHTML = "<?php echo COMMON_ZIPCODE_IS_REQUIRED; ?>";
		errorflag = true;
	}
	else {
		document.getElementById("PostNameError").innerHTML = "";
	}
	if(trim(ObjForm.state.value) == '')
	{
		document.getElementById("StateNameError").innerHTML = "<?php echo COMMON_STATE_IS_REQUIRED; ?>";
		errorflag = true;
	}
	else {
		document.getElementById("StateNameError").innerHTML = "";
	}
	if(trim(ObjForm.country.value) == '')
	{
		document.getElementById("CountryNameError").innerHTML = "<?php echo COMMON_COUNTRY_IS_REQUIRED; ?>";
		errorflag = true;
	}
	else {
		document.getElementById("CountryNameError").innerHTML = "";
	}
	if(trim(ObjForm.phone.value) == ''){
		document.getElementById("phoneError").innerHTML = "<?php echo COMMON_PHONE_IS_REQUIRED; ?>";
		errorflag = true;
	} else {
		document.getElementById("phoneError").innerHTML = "";
	}


	if(errorflag == true)
		return false;
	else
		return true;
	
}

function PassWordValidation()
{
	var errorflag = false;
	//oldpass=trim(document.getElementById("Curr_Pass").value);
	newpass=(trim(document.getElementById("Change_Pass").value));
	conpass=(trim(document.getElementById("Conf_Pass").value));
/*
	if(trim(oldpass) == "")
	{
		document.getElementById("CNameError").innerHTML = "<?php echo CURRPASSWORD_ISREQUIRED; ?>";
		errorflag = true;
	}
	else  {
		document.getElementById("CNameError").innerHTML = "";
	}
*/
	if(newpass == "")
	{

		document.getElementById("NewNameError").innerHTML = "<?php echo NEWPASSWORD_IS_REQUIRED; ?>";
		errorflag = true;

	}else {
	 	document.getElementById("NewNameError").innerHTML = "";
	 }
	/*else if(newpass==oldpass)
	 {
	 	document.getElementById("NewNameError").innerHTML = "<?php echo NEW_AND_CURRENT_PASSWORD_BE_DIFFERENT; ?>";
		errorflag = true;
	 } */
	 
	
	if(conpass == "")
	{
		document.getElementById("ConfNameError").innerHTML = "<?php echo CONFIRM_PASSWORD_IS_REQUIRED; ?>";
		errorflag = true;
	}
	else if(newpass != conpass)
	{
		document.getElementById("ConfNameError").innerHTML = "<?php echo CURRENT_AND_CONFIRM_PASSWORD_SAME; ?>";
		errorflag = true;
	}else {
		document.getElementById("ConfNameError").innerHTML = "";
	}
	


	if (errorflag == true)
	{
		return false;
	}
	else {
		return true;
	}

}

function submitfunction()
{
	if (confirm("<?php echo MSG_CONFIRM_MODIFICATION;?>")) {
		document.getElementById('HiddenSubmit').value='yes';
		document.changepass.submit();
	}
	else {
		return false;
	}
}

function Validatesignin()
{
	var errorflag = false;
	var iChars = "!@#$%^&*()+=-[]\\\';,./{}|\":<>?0123456789";
	email = document.loginsignin.email_signup.value;
	if(email == '') {
		document.getElementById("UNameError").innerHTML = "<?php echo ERROR_EMAIL_ID_IS_REQUIRED; ?>";
		errorflag = true;
	} else if (emailValidate(email) == 'error') {
		document.getElementById("UNameError").innerHTML = "<?php echo ERROR_EMAIL_ID_INVALID; ?>";
		errorflag = true;
	} else {
		document.getElementById("UNameError").innerHTML = "";
	}
	
	if(trim(document.loginsignin.password_signup.value) == "") {
		document.getElementById("PassError").innerHTML = "<?php echo ERROR_PASSWORD_REQUIRE; ?>";
		errorflag = true;
	} else {
		document.getElementById("PassError").innerHTML = "";
	}
	if(errorflag == true) {
		return false;
	} else{
		return true;
	}
}




</script>
<script>
var country_val = 13 ;
	$("#suburb").keyup( 
	function(event){
				ajax_showOptions(this,'admin_search',event,"<?php echo DIR_HTTP_RELATED.'tms_index.php';?>",'ajax_index_listOfOptions');
		}
	);
	jQuery("#ajax_index_listOfOptions div").live("click",function()
	{
		var country_val = $("#default_cntry").val();
		if(country_val == 13)
		{
			var selected_id = jQuery(this).text();
			

			var postcodedatawithid = selected_id.split(" ");//find the postcode id for pickup
			var maximum_index_of_array = postcodedatawithid.length;
			
			var suburb = (postcodedatawithid.length<=3)?(postcodedatawithid[0]):(postcodedatawithid[0]+" "+postcodedatawithid[1]);
			$("#suburb").val(postcodedatawithid[0]);
			$("#state").val(postcodedatawithid[maximum_index_of_array-2]);
			$("#postcode").val(postcodedatawithid[maximum_index_of_array-1]);
			$("#suburb").attr('readonly','readonly');
			$("#state").attr('readonly','readonly');
			$("#postcode").attr('readonly','readonly');
		}
	});
</script>
