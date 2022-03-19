<script language="javascript" type="text/javascript" >
function validation()	
{	
	
	var errorflag = false;
	
	if((document.getElementById("txt_sdate").value) == ''){  
		
		document.getElementById("textsdateError").innerHTML = "<?php echo HOLIDAY_HOLIDAY_DATE_REQUIRED;?>";
		errorflag = true;
	}else{
		
		document.getElementById("textsdateError").innerHTML = "";
	}

	if((document.getElementById("state").value) == 'Please Select State'){  
		
		document.getElementById("stateError").innerHTML = "<?php echo HOLIDAY_STATE_REQUIRED ;?>";
		errorflag = true;
	}else{
		
		document.getElementById("stateError").innerHTML = "";
	}

	if((document.getElementById("state").value) == 'Please Select State'){  
		
		document.getElementById("stateError").innerHTML = "<?php echo HOLIDAY_STATE_REQUIRED ;?>";
		errorflag = true;
	}else{
		
		document.getElementById("stateError").innerHTML = "";
	}

	if((document.getElementById("txt_name").value) == ''){  
		
		document.getElementById("nameError").innerHTML = "<?php echo HOLIDAY_NAME_REQUIRED ;?>";
		errorflag = true;
	}else{
		
		document.getElementById("nameError").innerHTML = "";
	}
	//console.log("error"+errorflag);
	if(errorflag == true)
		return false;
	else
		return true;
}
</script>
