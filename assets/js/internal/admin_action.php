<script language="javascript" type="text/javascript" >
function validation() {
	var errorflag = false;
	if(trim(document.frmadmin.user_name.value) == '') {
		document.getElementById("UserNameError").innerHTML = "<?php echo ADMIN_ERROR_NAME_REQUIRED;?>";
		errorflag = true;
	} else  {
		document.getElementById("UserNameError").innerHTML = "";
	}
	if(trim(document.frmadmin.user_name.value)!='')
	{
		var validtest = validateUsername(trim(document.frmadmin.user_name.value));
		if(validtest == false)
		{
			document.getElementById("UserNameError").innerHTML = "Please enter only alphanumeric values only.";
			errorflag = true;
		}
	}
	
	var membermailid = trim(document.frmadmin.user_email.value);
	if(membermailid == "") {
		document.getElementById("UserEmailError").innerHTML = "<?php echo ADMIN_ERROR_EMAIL_REQUIRED;?>";
		errorflag = true;
	} else  {
		 result = emailValidate(membermailid);
		 if(result=='error') {
			document.getElementById("UserEmailError").innerHTML = "<?php echo ADMIN_ERROR_EMAIL_INVALID;?>";
			errorflag = true;
		 } else {
		 	document.getElementById("UserEmailError").innerHTML = "";
		 }
	}		
<?php if(empty($AdminId)) { ?>
	password=trim(document.frmadmin.user_password.value);
	if(password == '') {
		document.getElementById("PasswordError").innerHTML = "<?php echo ADMIN_ERROR_PASSWORD_REQUIRED;?>";
		errorflag = true;
	} else  {
		document.getElementById("PasswordError").innerHTML = "";
	}
	
	conpass=trim(document.frmadmin.user_conf_password.value);
	if(conpass == '') {
		document.getElementById("ConfPasswordError").innerHTML = "<?php echo ADMIN_ERROR_CONFIRM_PASSWORD_REQUIRED;?>";
		errorflag = true;
	} else if(password != conpass) {
	 	document.getElementById("ConfPasswordError").innerHTML = "<?php echo ADMIN_ERROR_PWD_AND_CONFIRM_PWD_DIFF;?>";
		errorflag = true;
	} else  {
		document.getElementById("ConfPasswordError").innerHTML = "";
	}
<?php } ?>
	if(errorflag == true)
		return false;
	return true;
}

function PassWordValidation()
{
	//alert(currentpassword);exit;
	var errorflag = false;
	
	oldpass=trim(document.getElementById("Curr_Pass").value);
	newpass=(trim(document.getElementById("Change_Pass").value));
	conpass=(trim(document.getElementById("Conf_Pass").value));

	if(trim(oldpass) == "") {
		document.getElementById("CNameError").innerHTML = "<?php echo ADMIN_CURRPASSWORD_IS_REQUIRED;?>";
		errorflag = true;
	} else {
		document.getElementById("CNameError").innerHTML = "";
	}

	if(newpass == "") {
		document.getElementById("NewNameError").innerHTML = "<?php echo ADMIN_NEWPASSWORD_IS_REQUIRED;?>";
		errorflag = true;
	} else if(newpass==oldpass) {
	 	document.getElementById("NewNameError").innerHTML = "<?php echo ADMIN_NEW_AND_CURRENT_PASSWORD_BE_DIFFERENT;?>";
		errorflag = true;
	} else {
		document.getElementById("NewNameError").innerHTML = "";
	}

	if(conpass == "") {
		document.getElementById("ConfNameError").innerHTML = "<?php echo ADMIN_CONFIRM_PASSWORD_IS_REQUIRED;?>";
		errorflag = true;
	} else if(newpass != conpass) {
		document.getElementById("ConfNameError").innerHTML = "<?php echo ADMIN_CURRENT_AND_CONFIRM_PASSWORD_SAME;?>";
		errorflag = true;
	} else {
		document.getElementById("ConfNameError").innerHTML = "";
	}

	if (errorflag == true) {
		return false;
	} else {
		return true;
	}
}

</script>