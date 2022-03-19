<script language="javascript" type="text/javascript" >

function validate_post_code(ObjForm) {

	var errorflag = false;
	
	/** Firstname Validation **/
	if(trim(ObjForm.Name.value) == ''){
		document.getElementById("NameError").innerHTML = "<?php echo COMMON_NAME_IS_REQUIRED; ?>";
		errorflag = true;
	} else  {
		document.getElementById("NameError").innerHTML = "";
	}

	/** LastName Validation **/
	if(trim(ObjForm.Postcode.value) == '')	{
		document.getElementById("PostcodeError").innerHTML = "<?php echo COMMON_POSTCODE_IS_REQUIRED; ?>";
		errorflag = true;
	} else {
		document.getElementById("PostcodeError").innerHTML = "";
	}

	/** Street Address Validation **/	
	if(trim(ObjForm.State.value) == ''){
		document.getElementById("StateError").innerHTML = "<?php echo COMMON_STREET_IS_REQUIRED; ?>";
		errorflag = true;
	} else {
		document.getElementById("StateError").innerHTML = "";
	}

	/** City Validation **/	
	if(trim(ObjForm.Zone.value) == ''){
		document.getElementById("ZoneError").innerHTML = "<?php echo COMMON_ZONE_IS_REQUIRED; ?>";
		errorflag = true;
	} else {
		document.getElementById("ZoneError").innerHTML = "";
	}

	/** Postcode Validation **/	
	if(trim(ObjForm.charging_zone.value) == ''){
		document.getElementById("charging_zoneError").innerHTML = "<?php echo COMMON_CHARGING_ZONE_IS_REQUIRED; ?>";
		errorflag = true;
	} else {
		document.getElementById("charging_zoneError").innerHTML = "";
	}

	/** State Validation **/	
	if(trim(ObjForm.time_zone.value) == ''){
		document.getElementById("time_zoneError").innerHTML = "<?php echo COMMON_TIME_ZONE_IS_REQUIRED; ?>";
		errorflag = true;
	} else {
		document.getElementById("time_zoneError").innerHTML = "";
	}

	/** Confirm Password Validation **/	
	
	
	if(errorflag == true)
		return false;
	else
		return true;
}

function validate_address(ObjForm) {
		
	var errorflag = false;
	if(trim(ObjForm.Name.value) == '')
	{

		document.getElementById("FNameError").innerHTML = "<?php echo COMMON_FIRSTNAME_IS_REQUIRED; ?>";
		errorflag = true;

	}
	else  {
		document.getElementById("FNameError").innerHTML = "";
	}
	if(trim(ObjForm.Postcode.value) == '')
	{

		document.getElementById("LNameError").innerHTML = "<?php echo COMMON_LASTNAME_IS_REQUIRED; ?>";
		errorflag = true;
	}
	else {
		document.getElementById("LNameError").innerHTML = "";
	}

	if(trim(ObjForm.State.value) == '')
	{
		document.getElementById("SNameError").innerHTML = "<?php echo COMMON_STREET_IS_REQUIRED; ?>";
		errorflag = true;
	}
	else {
		document.getElementById("SNameError").innerHTML = "";
	}
	if(trim(ObjForm.Zone.value) == '')
	{

		document.getElementById("CityNameError").innerHTML = "<?php echo COMMON_CITY_IS_REQUIRED; ?>";
		errorflag = true;
	}
	else {
		document.getElementById("CityNameError").innerHTML = "";
	}
	if(trim(ObjForm.charging_zone.value) == '')
	{
		document.getElementById("PostNameError").innerHTML = "<?php echo COMMON_ZIPCODE_IS_REQUIRED; ?>";
		errorflag = true;
	}
	else {
		document.getElementById("PostNameError").innerHTML = "";
	}
	if(trim(ObjForm.time_zone.value) == '')
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

	oldpass=trim(document.getElementById("Curr_Pass").value);
	newpass=(trim(document.getElementById("Change_Pass").value));
	conpass=(trim(document.getElementById("Conf_Pass").value));

	if(trim(oldpass) == "")
	{
		document.getElementById("CNameError").innerHTML = "<?php echo CURRPASSWORD_ISREQUIRED; ?>";
		errorflag = true;
	}
	else  {
		document.getElementById("CNameError").innerHTML = "";
	}

	if(newpass == "")
	{

		document.getElementById("NewNameError").innerHTML = "<?php echo NEWPASSWORD_IS_REQUIRED; ?>";
		errorflag = true;

	}
	else if(newpass==oldpass)
	 {
	 	document.getElementById("NewNameError").innerHTML = "<?php echo NEW_AND_CURRENT_PASSWORD_BE_DIFFERENT; ?>";
		errorflag = true;
	 }
	 else {
	 	document.getElementById("NewNameError").innerHTML = "";
	 }

	if(conpass == "")
	{
		document.getElementById("ConfNameError").innerHTML = "<?php echo CONFIRM_PASSWORD_IS_REQUIRED; ?>";
		errorflag = true;
	}
	else if(newpass != conpass)
	{
		document.getElementById("ConfNameError").innerHTML = "<?php echo CURRENT_AND_CONFIRM_PASSWORD_SAME; ?>";
		errorflag = true;
	}
	else {
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

function Validategetpassword(objform)
{ 
	var errorflag = false;
	if((objform.emailid.value) == '') {
		document.getElementById("EmailError").innerHTML = "<?php echo MSG_EMAIL_ID_IS_REQUIRED?>";
		errorflag = true;
	} else {
		 var emails=/^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
		 var membermailid = (objform.emailid.value);
		 result1=membermailid.search(emails);
		
		if(result1==-1)
		{
			document.getElementById("EmailError").innerHTML = "<?php echo MSG_FORGOT_PASSWORD_EMAIL_INVALID?> ";
			errorflag = true;
		} else {
			document.getElementById("EmailError").innerHTML = "";
		}
	}

	if (errorflag == true) {
		return false;
	} else {
		return true;
	}
}

</script>