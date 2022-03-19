<script language="javascript" type="text/javascript" >
function validatelogin()
{
	var errorflag = false;
	var iChars = "!@#$%^&*()+=-[]\\\';,./{}|\":<>?0123456789";
	if(trim(document.adminfrmlogin.username.value) == '') {
		document.getElementById("usernameError").innerHTML = "<?php echo ADMIN_USERNAME_REQUIRE ?>";
		document.adminfrmlogin.username.focus();
		errorflag = true;
	} else  {
		for (var i = 0; i < document.adminfrmlogin.username.value.length; i++) {
		  	if (iChars.indexOf(document.adminfrmlogin.username.value.charAt(i)) != -1) {
			    document.getElementById("usernameError").innerHTML = "<? echo ADMIN_USERNAME_INVALID?>";
			  	errorflag = true;
		  	}
		  	else{
		  		document.getElementById("usernameError").innerHTML = "";
		  	}
		}
	}

	if(trim(document.adminfrmlogin.password.value) == "") {
		document.getElementById("passwordError").innerHTML = "<? echo ADMIN_PASSWORD_REQUIRE;?>";
		errorflag = true;
	}else{
		var pass=document.adminfrmlogin.password.value.length;
		if(pass < 5 || pass > 20 ) {
			document.getElementById("passwordError").innerHTML = "<? echo ADMIN_PASSWORD_LENGTH_ERROR;?>";
			errorflag = true;
		}
		else {
			document.getElementById("passwordError").innerHTML =  "";
		}
	}
	//
	//return false;
	if (errorflag == true) {
		return false;
	}else{
		$('#adminfrmlogin').submit();
		return true;
	}
}
</script>