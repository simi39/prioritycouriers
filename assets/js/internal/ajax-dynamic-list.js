	/************************************************************************************************************
	(C) www.dhtmlgoodies.com, April 2006
	
	This is a script from www.dhtmlgoodies.com. You will find this and a lot of other scripts at our website.	
	
	Terms of use:
	You are free to use this script as long as the copyright message is kept intact. However, you may not
	redistribute, sell or repost it without our permission.
	
	Thank you!
	
	www.dhtmlgoodies.com
	Alf Magne Kalleland
	
	************************************************************************************************************/	

	var suffix;
	var ajaxBox_offsetX = 0;
	var ajaxBox_offsetY = 0;
	//var ajax_list_externalFile = suffix+'header_new.php';	// Path to external file
	var ajax_list_externalFile = '';	// Path to external file
	var minimumLettersBeforeLookup = 1;	// Number of letters entered before a lookup is performed.
	
	var ajax_list_objects = new Array();
	var ajax_list_cachedLists = new Array();
	var ajax_list_activeInput = false;
	var ajax_list_activeItem;
	var ajax_list_optionDivFirstItem = false;
	var ajax_list_currentLetters = new Array();
	var ajax_optionDiv = false;
	var ajax_optionDiv_iframe = false;
	//Added by shailesh to store address data in booking address affiliation form  
	//This variable are used in booking.tpl.php in ajaxShowAddressAlert function 
	var pickupUtilityArr = new Array();
	var deliveryUtilityArr = new Array();
	var currentTotalRecords = 0;
	var ajax_list_MSIE = false;
	if(navigator.userAgent.indexOf('MSIE')>=0 && navigator.userAgent.indexOf('Opera')<0)ajax_list_MSIE=true;
	
	var currentListIndex = 0;
	
	function ajax_getTopPos(inputObj)
	{
		
	  var returnValue = inputObj.offsetTop;
	  while((inputObj = inputObj.offsetParent) != null){
	  	returnValue += inputObj.offsetTop;
	  }
	  return returnValue;
	}
	function ajax_list_cancelEvent()
	{
		return false;
	}
	
	function ajax_getLeftPos(inputObj)
	{
	  var returnValue = inputObj.offsetLeft;
	  while((inputObj = inputObj.offsetParent) != null)returnValue += inputObj.offsetLeft;
	  
	  return returnValue;
	}
	
	function ajax_option_setValue(e,inputObj)
	{
		
		$(inputObj).click();
		if(!inputObj)inputObj=this;
		var tmpValue = inputObj.innerHTML;
		//console.log("inside ajax option:"+ajax_list_activeInput.id);
		//alert("ajax_list_active"+ajax_list_activeInput.id+"tmpVAlue"+tmpValue);
		if(ajax_list_activeInput.id == "sender_first_name" || ajax_list_activeInput.id == "reciever_name"){
			tmpValue = inputObj.id;
		}else{
			
			if(ajax_list_MSIE)tmpValue = inputObj.innerText;else tmpValue = inputObj.textContent;			
			
			var current_path = window.location.pathname.split('/').pop();
			//alert(current_path);
			//alert("inside ajax dynamic page"+current_path+"ajax active input:"+ajax_list_activeInput.id);
				//$("#servicePageItem_1").html(a);
			
			if(ajax_list_activeInput.id == "pickup")
			{	
				
				var pickupval = tmpValue;
				var deliverval = $('#deliver').val();
				var current_path = window.location.pathname.split('/').pop();
				//(current_path);
				

				//$("#servicePageItem_1").html(a);
				if((current_path == 'index.php'|| current_path == '') && (pickupval != "PICK UP SUBURB/POSTCODE" && pickupval!="") && (deliverval != "" && deliverval != "DELIVERY SUBURB/POSTCODE"))
				{
					
					//console.log("current path 96:"+current_path);	
					var j;
					var lastRow = $("#last_inserted_cell_australia").val();
					for(j=2;j<=lastRow;j++)
					{				
						//DelSizeDataRow(j);
					}
					$.ajax({
					  url: 'related/ajax_aus_services.php',
					  type: 'post',
					  data: {'pickup':pickupval,'deliver':deliverval,'servicepagename':$('#servicepagename_1').val()},
					  success: function(data, status) { 
						var res = data.split("$");
						var resservice = data.split("#");
						
						$("#servicepagename_1").val(resservice[1]);
						if(res[0] == 1){
							return false;	
						}
						console.log("res:"+res[0]+res[1]+res[2]);
						var length = res[2];
						var girtharr = res[3].split("#");
						var girth = girtharr[0];
						
						if(res[0] != 0)
						{	
							unsetIndexAusValues();
							$("#length_max_1").val(length);
							$("#girth_max_1").val(girth);
							callDropDownItems(res[0]);
							$("#servicePageBox").html(res[1]);
							
						}else{
							$('#pickup').val("PICK UP SUBURB/POSTCODE");
							$('#deliver').val("DELIVERY SUBURB/POSTCODE");
							$("#AusService").modal('show');
							return false;
						}
						
						  },
						  error: function(xhr, desc, err) {
							console.log(xhr);
							console.log("Details: " + desc + "\nError:" + err);
						  }
					});
				}
				/* To set the current date and time of origin */ 
				/*
				if((current_path == 'booking') && (pickupval !="" && pickupval != "PICK UP SUBURB/POSTCODE"))
				{
					var pickupArr = pickupval.split(" ");
					
					if(pickupArr.length == 5)
					{
						var pickupState = pickupArr[3];
						var pickupSuburb = pickupArr[0];
					}else if(pickupArr.length == 3){
						var pickupState = pickupArr[1];
						var pickupSuburb = pickupArr[0];
					}else{
						var pickupSuburb = pickupArr[0]+" "+pickupArr[1];
						var pickupState = pickupArr[2];
					}
					var zoneDateTime = zoneDateTimeSet(pickupSuburb,pickupState);
					//alert("zone:"+zoneDateTime);
					if(zoneDateTime != undefined)
					{
						$('#datetimepicker1').data("DateTimePicker").date(zoneDateTime);
					}
					//$('#datetimepicker1').data("DateTimePicker").minDate(	min);
					$('#selectedDate').val(zoneDateTime);
					$('#defaultDate').val(zoneDateTime);
					$('#minDate').val(zoneDateTime);
					var min = $('#datetimepicker1').data('DateTimePicker').date();
					//alert("mindate:"+min);
					//$('#datetimepicker1').data("DateTimePicker").minDate(min);
					//defaultDateset = zoneDateTime; DD MMM YYYY h:mm a
					
				}*/
				//alert("current path:"+current_path+"test"+ajax_list_activeInput.id);
				/* To set the current date and time of origin */ 
				//console.log("current path:"+current_path+"pickup:"+pickupval+"deliverval:"+deliverval);
				if((current_path == 'booking.php') && (pickupval !="" && pickupval != "PICK UP SUBURB/POSTCODE") && (deliverval != "" && deliverval != "DELIVERY SUBURB/POSTCODE"))
				{
					console.log("inside ajax-dynamic-list"+pickupval+"--"+deliverval);
					$.ajax({
					  url: 'related/ajax_aus_booking_services.php',
					  type: 'post',
					  data: {'pickup':pickupval,'deliver':deliverval,'servicepagename':$('#servicepagename_1').val()},
					  success: function(data, status) {
						var resservice = data.split("#");
						var res = resservice[0].split("$");
						
						$("#servicepagename_1").val(resservice[1]);
						if(res[0] != 0 && res[0] != 1)
						{	
							unsetAusValues();
							//alert(res[0]);
							$("#booking").data('bootstrapValidator').resetForm();
							callDropDownGetQuoteItems(res[0]);
							$("#servicePageBox").html(res[1]);
							var length = res[2];
							var girth = res[3];
							//console.log("length:"+length+"girth:"+girth);
							$("#length_max_1").val(length);
							$("#girth_max_1").val(girth);

							if($("#size_display_block_international").css("display","none")){
								$("#drc:selected").val('Please Select'); 
							}
							
						}else if(res[0] == 1){
							return false;	
						}else{
							$('#pickup').val("PICK UP SUBURB/POSTCODE");
							$('#deliver').val("DELIVERY SUBURB/POSTCODE");
							$("#AusService").modal('show');
							return false;
						}
						
						  },
						  error: function(xhr, desc, err) {
							console.log(xhr);
							console.log("Details: " + desc + "\nError:" + err);
						  }
					});
				
				}
				var j;
				var lastRow = $("#last_inserted_cell_australia").val();
				for(j=2;j<=lastRow;j++)
				{				
					//DelSizeDataRow(j);
				}
			}
			if(ajax_list_activeInput.id == "deliver" && tmpValue!="")
			{
				//alert(tmpValue);
				var pickupval = $('#pickup').val();
				var deliverval = $('#deliver').val();
				
				if(ajax_list_activeInput.id == "deliver")
				{
					
					if(pickupval == "PICK UP SUBURB/POSTCODE")
					{
						$("#pickupError").html("Enter post code or suburb and confirm your choice");
						$("#pickupError").focus();
						return false;
					}else{
						$("#pickupError").html("");
					}
				}
				
				
				if(ajax_list_activeInput.id == "pickup")
				{
					if(deliverval == "DELIVERY SUBURB/POSTCODE")
					{
						$("#deliverError").html("Enter post code or suburb and confirm your choice");
						$("#deliverError").focus();
						return false;
					}else{
						$("#deliverError").html("");
					}
				}
				
				var current_path = window.location.pathname.split('/').pop();
				
				var deliverval = tmpValue;
				//console.log("current path 274:"+current_path);

				if(current_path == 'index' || current_path == '' && (pickupval !="" && pickupval != "PICK UP SUBURB/POSTCODE") && (deliverval != "" && deliverval != "DELIVERY SUBURB/POSTCODE"))
				{
					//alert("service page val:"+$('#servicepagename').val());
					$.ajax({
					  url: 'related/ajax_aus_services.php',
					  type: 'post',
					  data: {'pickup':pickupval,'deliver':deliverval,'servicepagename':$('#servicepagename_1').val()},
					  success: function(data, status) { 
						var res = data.split("$");
						var resservice = data.split("#");
						//console.log("resservice:"+resservice[1]);
						$("#servicepagename_1").val(resservice[1]);
						if(res[0] == 1){
							return false;	
						}
						console.log("res1:"+res[1]+"res2:"+res[2]+"res3:"+res[3]);
						var length = res[2];
						var girtharr = res[3].split("#");
						var girth = girtharr[0];
						/*var weight = res[2].split("-");
						var length = res[3].split("-");
						var width = res[4].split("-");
						var height = res[5].split("-");
						*/
						if(res[0] != 0)
						{	
							unsetIndexAusValues();
							/*$("#weight_max").val(weight[0]);
							$("#weight_min").val(weight[1]);
							$("#length_max").val(length[0]);
							$("#length_min").val(length[1]);
							$("#width_max").val(width[0]);
							$("#width_min").val(width[1]);
							$("#height_max").val(height[0]);
							$("#height_min").val(height[1]);*/
							$("#length_max_1").val(length);
							$("#girth_max_1").val(girth);
							callDropDownItems(res[0]);
							$("#servicePageBox").html(res[1]);
							
							
						}else{
							$('#pickup').val("PICK UP SUBURB/POSTCODE");
							$('#deliver').val("DELIVERY SUBURB/POSTCODE");
							$("#AusService").modal('show');
							return false;
						}
						
						  },
						  error: function(xhr, desc, err) {
							console.log(xhr);
							console.log("Details: " + desc + "\nError:" + err);
						  }
					});
				}
				if(current_path == 'booking.php' && (pickupval !="" && pickupval != "PICK UP SUBURB/POSTCODE") && (deliverval != "" && deliverval != "DELIVERY SUBURB/POSTCODE"))
				{
					
					//console.log("current path:"+current_path+"pickup:"+pickupval+"deliverval:"+deliverval);
					$.ajax({
					  url: 'related/ajax_aus_booking_services.php',
					  type: 'post',
					  data: {'pickup':pickupval,'deliver':deliverval,'servicepagename':$("#servicepagename_1").val()},
					  success: function(data, status) {
						var resservice = data.split("#");
											  
						var res = resservice[0].split("$");
						//console.log("res:"+resservice);
						$("#servicepagename_1").val(resservice[1]);
						
						if(res[0] != 0 && res[0] != 1)
						{	
							unsetAusValues();
							$("#booking").data('bootstrapValidator').resetForm();
							callDropDownGetQuoteItems(res[0]);
							$("#servicePageBox").html(res[1]);
						
							var length = res[2];
							var girth = res[3];
							//console.log("length:"+length+"girth:"+girth);
							$("#length_max_1").val(length);
							$("#girth_max_1").val(girth);

							if($("#size_display_block_international").css("display","none")){
								$("#drc:selected").val("Please Select");
								
							}
							
						}else if(res[0] == 1){
							return false;
					    }else{
							$('#pickup').val("PICK UP SUBURB/POSTCODE");
							$('#deliver').val("DELIVERY SUBURB/POSTCODE");
							$("#AusService").modal('show');
							return false;
						}
						
						  },
						  error: function(xhr, desc, err) {
							console.log(xhr);
							console.log("Details: " + desc + "\nError:" + err);
						  }
					});
				
				}
			}
		
		}

		
		//if(!tmpValue)tmpValue = inputObj.innerHTML;
		//alert(ajax_list_activeInput.id);
		if(ajax_list_activeInput.id == "sender_first_name" || ajax_list_activeInput.id == "reciever_name"){
			var splitAddressList = tmpValue.split("^^^");
			
			var splitAddressStreet = splitAddressList[0];
			var splitAddressContact = splitAddressList[1];
			var splitAddress = splitAddressStreet.split("~");
			var splitAddress2 = splitAddressContact.split("~");
			//alert(splitAddress2);
			
		}
		if(ajax_list_activeInput.id == "sender_first_name"){
			
			for(var n=0;n < splitAddress.length; n++){
				pickupUtilityArr[n] = splitAddress[n];
			}
			
			$("#sender_first_name").val(trim(splitAddress[0]));
			$("#sender_last_name").val(trim(splitAddress[1]));
			$("#sender_company_name").val(trim(splitAddress[2]));
			$("#sender_address_1").val(trim(splitAddress[3]));
			if(splitAddress[4] != "--"){
				$("#sender_address_2").val(trim(splitAddress[4]));
			}else{
				$("#sender_address_2").val("");
			}
			if(splitAddress[5] != "--"){
				$("#sender_address_3").val(trim(splitAddress[5]));
			}else{
				$("#sender_address_3").val("");
			}
			$("#sender_email").val(trim(splitAddress2[0]));
			$("#sender_area_code").val(trim(splitAddress2[1]));
				
			
			if(splitAddress2[2] != "--"){
				$("#sender_contact_no").val(trim(splitAddress2[2]));
			}
			if(splitAddress2[3] != "--"){
				$("#sender_mb_area_code").val(trim(splitAddress2[3]));
			}
			
			if(splitAddress2[4] != "--"){
				$("#sender_mobile_no").val(trim(splitAddress2[4]));
			}
			
			
			pickupUtilityArr[6] = $("#sender_suburb").val();
			//pickupUtilityArr[7] = $("#sender_suburb").val();
			//pickupUtilityArr[8] = $("#sender_suburb").val();
			pickupUtilityArr[9] = $("#sender_area_code").val();
			pickupUtilityArr[10] = $("#sender_email").val();
			pickupUtilityArr[11] = $("#sender_contact_no").val();
			pickupUtilityArr[12] = $("#sender_mobile_no").val();
			pickupUtilityArr[13] = $("#sender_mb_area_code").val();
			
			$("#booking_form").hide(500);
			setaddressBookFlag(trim(ajax_list_activeInput.id));
			/*$.ajax({
					type: "POST",
					url: '<?php echo "ajax_address_session.php"; ?>',
					data: 'addressType=0&action=get_address&fname='+fname+'&surname='+surname+'&user_id='+user_id+'&Co='+Co+'&Add1='+Add1+'&Add2='+Add2+'&Add3='+Add3+'&Suburb='+Suburb+'&State='+State+'&Postcode='+Postcode+'&Email='+Email+'&Contact='+Contact+'&Mobile='+Mobile,
					success: function( msg ) {
						
					}
			});*/
				var validateFlag	= true ;
				var senderFirstName	= document.getElementById('sender_first_name').value;
				var senderLastName 	= document.getElementById('sender_last_name').value;
				var Co 		= document.getElementById('sender_company_name').value;
				var Add1 	= document.getElementById('sender_address_1').value;
				var Add2 	= document.getElementById('sender_address_2').value;
				var Add3 	= document.getElementById('sender_address_3').value;
				var Suburb 	= document.getElementById('sender_suburb').value;
				var State 	= document.getElementById('sender_state').value;
				var Postcode = document.getElementById('sender_postcode').value;
				var Acode 	= document.getElementById('sender_area_code').value;
				var Macode 	= document.getElementById('sender_mb_area_code').value;
				var Email 	= document.getElementById('sender_email').value;
				var Contact = document.getElementById('sender_contact_no').value;
				var Mobile 	= document.getElementById('sender_mobile_no').value;
				
				
				Email = Email.replace("--", "");
				$('#sender_email').val(Email);
				if(senderFirstName == "")
				{
					alert("Please Enter Your First Name");
					validateFlag = false;
					return false;
				}
				if(senderFirstName!="")
				{
					var validtest = validateUsername(senderFirstName);
					if(validtest == false)
					{
						alert("Please enter only alphanumeric values only.");
						validateFlag = false;
						return false;
					}
				}
				if(senderLastName == "")
				{
					alert("Please Enter Your Last Name");
					validateFlag = false;
					return false;
				}
				if(senderLastName!="")
				{
					var validtest = validateUsername(senderLastName);
					if(validtest == false)
					{
						alert("Please enter only alphanumeric values only.");
						validateFlag = false;
						return false;
					}
				}
				if(Co!="")
				{
					var validtest = validStreet(trim(Co));
					if(validtest == false)
					{
						alert("Please enter only alphanumeric values only.");
						validateFlag = false;
						return false;
					}
				}
				if(Add1=="")
				{
					alert("Please Enter Your Address1");
					validateFlag = false;
					return false;
				}
				if(Add1!="")
				{
					var validtest = validStreet(trim(Add1));
					if(validtest == false)
					{
						alert("Please enter only alphanumeric values only.");
						validateFlag = false;
						return false;
					}
				}
				if(Add2!="")
				{
					var validtest = validStreet(trim(Add2));
					if(validtest == false)
					{
						alert("Please enter only alphanumeric values only.");
						validateFlag = false;
						return false;
					}
				}
				if(Add3!="")
				{
					var validtest = validStreet(trim(Add3));
					if(validtest == false)
					{
						alert("Please enter only alphanumeric values only.");
						validateFlag = false;
						return false;
					}
				}
				if(Acode=="")
				{
					alert("Please Enter Your Area Code.");
					validateFlag = false;
					return false;
				}
				if(Acode!= "")
				{
					var txt_id = "sender_area_code";
					var valid_format = 1;
					var valid = contact_validation(txt_id,valid_format);
					if(valid == false){
						validateFlag = false;				
						return false;
					}			
				}
				if(Contact=="")
				{
					alert("Please Enter Your Contact Number.");
					validateFlag = false;
					return false;
				}
				if(Contact!="" )
				{
					var txt_id = "sender_contact_no";
					var valid_format = 0;
					var valid = contact_validation(txt_id,valid_format);
					if(valid == false){
						validateFlag = false;
						return false;
					}			
					
				}
				if(Macode!="")
				{
					var txt_id = "sender_mb_area_code";
					var valid_format = 1;
					var valid = contact_validation(txt_id,valid_format);
					if(valid == false){
						validateFlag = false;
						return false;
					}			
				}
				if(Mobile!= "")
				{
					var txt_id = "sender_mobile_no";
					var valid_format = 0;
					var valid = contact_validation(txt_id,valid_format);
					if(valid == false){
						validateFlag = false;
						return false;
					}			
				}
				if(Email=="")
				{
					$("#err_sender_email").html("Please enter Email Address");
					validateFlag = false;
					return false;
				}
				if(Email!=""){
					if(emailValidate(Email)!='')
					{
						$("#err_sender_email").html("Please enter valid Email Address");
						validateFlag = false;
						return false;
					}
				}
				
				var user_id 	= document.getElementById('user_id').value;
				//var fname  	= senderFirstName;
				//var surname = senderLastName ;
				
				if(validateFlag ==  true) {
					$.ajax({
						type: "POST",
						url: "related/ajax_address_session.php",
						data:'addressType=pickup&action=set_address&fname='+senderFirstName+'&surname='+senderLastName+'&user_id='+user_id+'&Co='+Co+'&Add1='+Add1+'&Add2='+Add2+'&Add3='+Add3+'&Suburb='+Suburb+'&State='+State+'&Postcode='+Postcode+'&Email='+Email+'&Acode='+Acode+'&Macode='+Macode+'&Contact='+Contact+'&Mobile='+Mobile,
					}).done(function( msg ) {
						//alert(msg); return false;
					});	
				}
				
			
		}else if(ajax_list_activeInput.id == "reciever_name"){
			for(var n=0;n < splitAddress.length; n++){
				deliveryUtilityArr[n] = splitAddress[n]; 
			}
			console.log("addresso:"+trim(splitAddress[0]));
			$("#reciever_name").val(trim(splitAddress[0]));
			$("#reciever_surname").val(trim(splitAddress[1]));
			$("#reciever_company_name").val(trim(splitAddress[2]));
			$("#reciever_address_1").val(trim(splitAddress[3]));
			if(trim(splitAddress[4]) != "--"){
				$("#reciever_address_2").val(trim(splitAddress[4]));
			}else{
				$("#reciever_address_2").val("");
			}
			if(trim(splitAddress[5]) != "--"){
				$("#reciever_address_3").val(trim(splitAddress[5]));
			}else{
				$("#reciever_address_3").val("");
			}
			$("#reciever_email").val(trim(splitAddress2[0]));
			$("#reciever_area_code").val(trim(splitAddress2[1]));
						
			if(trim(splitAddress2[2]) != "--"){
				
				$("#reciever_contact_number").val(trim(splitAddress2[2]));
			}
			if(trim(splitAddress2[3]) != "--"){
				$("#reciever_mb_area_code").val(trim(splitAddress2[3]));
			}
			if(trim(splitAddress2[4]) != "--"){
				$("#reciever_mobile_number").val(trim(splitAddress2[4]));
			}
			
			deliveryUtilityArr[6] = $("#reciever_suburb").val(); 
			//deliveryUtilityArr[7] = $("#"); 
			//deliveryUtilityArr[8] = $("#"); 
			deliveryUtilityArr[9] = $("#reciever_area_code").val(); 
			deliveryUtilityArr[10] = $("#reciever_email").val(); 
			deliveryUtilityArr[11] = $("#reciever_contact_number").val(); 
			deliveryUtilityArr[12] = $("#reciever_mobile_number").val(); 
			deliveryUtilityArr[13] = $("#reciever_mb_area_code").val(); 
			//$("#").val(); 
			$("#booking_form").hide(500);
			setaddressBookFlag(trim(ajax_list_activeInput.id));
			var validateFlag	= true ;
			var recieverFirstName = document.getElementById('reciever_name').value;
			var recieverLastName = document.getElementById('reciever_surname').value;
			//alert(addMatchFlag);
			/*var suburb 		= document.getElementById('reciever_suburb').value;
			var postcode 	= document.getElementById('reciever_postcode').value;*/
			var user_id 	= document.getElementById('user_id').value;
			//var addressHolder = 'reciever';
			var Co 			= document.getElementById('reciever_company_name').value;	
			var Add1 		= document.getElementById('reciever_address_1').value;	
			var Add2 		= document.getElementById('reciever_address_2').value;	
			var Add3 		= document.getElementById('reciever_address_3').value;	
			var Suburb 		= document.getElementById('reciever_suburb').value;
			var State 		= document.getElementById('reciever_state').value;
			var Postcode 	= document.getElementById('reciever_postcode').value;
			var Acode 		= document.getElementById('reciever_area_code').value;
			var Macode 		= document.getElementById('reciever_mb_area_code').value;
			var Email 		= document.getElementById('reciever_email').value;
			var Contact 	= document.getElementById('reciever_contact_number').value;
			var Mobile 		= document.getElementById('reciever_mobile_number').value;
			Email = Email.replace("--", "");
			$('#reciever_email').val(Email);
			if(recieverFirstName == "")
			{
				alert("Please Enter Your First Name");
				validateFlag = false;
				return false;
			}
			if(recieverFirstName!="")
			{
				var validtest = validateUsername(recieverFirstName);
				if(validtest == false)
				{
					alert("Please enter only alphanumeric values only.");
					validateFlag = false;
					return false;
				}
			}
			if(recieverLastName == "")
			{
				alert("Please Enter Your Last Name");
				validateFlag = false;
				return false;
			}
			if(recieverLastName!="")
			{
				var validtest = validateUsername(recieverLastName);
				if(validtest == false)
				{
					alert("Please enter only alphanumeric values only.");
					validateFlag = false;
					return false;
				}
			}
			if(Co!="")
			{
				var validtest = validStreet(trim(Co));
				if(validtest == false)
				{
					alert("Please enter only alphanumeric values only.");
					validateFlag = false;
					return false;
				}
			}
			if(Add1=="")
			{
				alert("Please Enter Your Address1");
				validateFlag = false;
				return false;
			}
			if(Add1!="")
			{
				var validtest = validStreet(trim(Add1));
				if(validtest == false)
				{
					alert("Please enter only alphanumeric values only.");
					validateFlag = false;
					return false;
				}
			}
			if(Add2!="")
			{
				var validtest = validStreet(trim(Add2));
				if(validtest == false)
				{
					alert("Please enter only alphanumeric values only.");
					validateFlag = false;
					return false;
				}
			}
			if(Add3!="")
			{
				var validtest = validStreet(trim(Add3));
				if(validtest == false)
				{
					alert("Please enter only alphanumeric values only.");
					validateFlag = false;
					return false;
				}
			}
			if(Acode=="")
			{
				alert("Please Enter Your Area Code.");
				validateFlag = false;
				return false;
			}
			if(Acode!= "")
			{
				var txt_id = "sender_area_code";
				var valid_format = 1;
				var valid = contact_validation(txt_id,valid_format);
				if(valid == false){
					validateFlag = false;				
					return false;
				}			
			}
			if(Contact=="")
			{
				alert("Please Enter Your Contact Number.");
				validateFlag = false;
				return false;
			}
			if(Contact!="" )
			{
				var txt_id = "sender_contact_no";
				var valid_format = 0;
				var valid = contact_validation(txt_id,valid_format);
				if(valid == false){
					validateFlag = false;
					return false;
				}			
				
			}
			if(Macode!="")
			{
				var txt_id = "sender_mb_area_code";
				var valid_format = 1;
				var valid = contact_validation(txt_id,valid_format);
				if(valid == false){
					validateFlag = false;
					return false;
				}			
			}
			if(Mobile!= "")
			{
				var txt_id = "sender_mobile_no";
				var valid_format = 0;
				var valid = contact_validation(txt_id,valid_format);
				if(valid == false){
					validateFlag = false;
					return false;
				}			
			}
			if(Email=="")
			{
				alert("Please enter Email Address");
				validateFlag = false;
				return false;
			}
			if(Email!=""){
				if(emailValidate(Email)!='')
				{
					alert("Please enter valid Email Address");
					validateFlag = false;
					return false;
				}
			}
			
			$.ajax({
					type: "POST",
					url: "related/ajax_address_session.php",
					data:'addressType=delivery&action=set_address&fname='+recieverFirstName+'&surname='+recieverLastName+'&user_id='+user_id+'&Co='+Co+'&Add1='+Add1+'&Add2='+Add2+'&Add3='+Add3+'&Suburb='+Suburb+'&State='+State+'&Postcode='+Postcode+'&Email='+Email+'&Contact='+Contact+'&Acode='+Acode+'&Macode='+Macode+'&Mobile='+Mobile,
				}).done(function( msg ) {
					
				});	
		}else{
			if(ajax_list_activeInput.id == "suburb_address_book"){
				var splitAddressList = tmpValue.split(" ");
					if(splitAddressList.length > 3 ){
						var suburb_name = splitAddressList[0]+" "+ splitAddressList[1];
					}else{
						var suburb_name = splitAddressList[0];
					}
				ajax_list_activeInput.value = suburb_name;
			}else{

			ajax_list_activeInput.value = tmpValue;
			}
		}
		//alert(ajax_list_activeInput.name);
		if(document.getElementById(ajax_list_activeInput.name + '_hidden'))document.getElementById(ajax_list_activeInput.name + '_hidden').value = inputObj.id; 
		ajax_options_hide();
	}
	
	function ajax_options_hide()
	{
		if(ajax_optionDiv)ajax_optionDiv.style.display='none';	
		if(ajax_optionDiv_iframe)ajax_optionDiv_iframe.style.display='none';
	}

	function ajax_options_rollOverActiveItem(item,fromKeyBoard)
	{
		if(ajax_list_activeItem)ajax_list_activeItem.className='optionDiv';
		item.className='optionDivSelected';
		ajax_list_activeItem = item;
		
		if(fromKeyBoard){
			if(ajax_list_activeItem.offsetTop>ajax_optionDiv.offsetHeight){
				ajax_optionDiv.scrollTop = ajax_list_activeItem.offsetTop - ajax_optionDiv.offsetHeight + ajax_list_activeItem.offsetHeight + 2 ;
			}
			if(ajax_list_activeItem.offsetTop<ajax_optionDiv.scrollTop)
			{
				ajax_optionDiv.scrollTop = 0;	
			}
		}
	}
	
	function ajax_option_list_buildList(letters,paramToExternalFile)
	{
		//alert(letters);
		ajax_optionDiv.innerHTML = '';
		ajax_list_activeItem = false;
		
		if(ajax_list_cachedLists[paramToExternalFile][letters.toLowerCase()].length<=1){
			ajax_options_hide();
			return;			
		}
		
		ajax_list_optionDivFirstItem = false;
		var optionsAdded = false;
		var fnameDiv   = document.createElement('DIV');
		fnameDiv.id    = "fname_col";
		fnameDiv.className = "fname_col";
		fnameDiv.innerHTML = "Firstname";
		
		
		var surnameDiv = document.createElement('DIV');
		surnameDiv.id  = "sname_col";
		surnameDiv.className = "sname_col";
		surnameDiv.innerHTML = "Surname";
		
		
		var companyDiv = document.createElement('DIV');
		companyDiv.id  = "company_col";
		companyDiv.className = "company_col";
		companyDiv.innerHTML = "Company";
		
		
		var addressDiv = document.createElement('DIV');
		addressDiv.id	   = "address_col";
		addressDiv.className = "address_col";
		addressDiv.innerHTML = "Address";
		
		var rightTop = document.createElement('DIV');
		rightTop.id	   = "closeFrame";
		rightTop.rel	   = "tooltip";
		rightTop.title   = "Close";
		rightTop.className = "closeFrame";
		rightTop.innerHTML = "  X ";
		
		for(var no=0;no<ajax_list_cachedLists[paramToExternalFile][letters.toLowerCase()].length;no++){
			//if(ajax_list_cachedLists[paramToExternalFile][letters.toLowerCase()][no].length==0)continue;
			optionsAdded = true;
			var div = document.createElement('DIV');
			currentTotalRecords = no+1;
			currentTotalRecords = currentTotalRecords * 29;
			var items = ajax_list_cachedLists[paramToExternalFile][letters.toLowerCase()][no].split(/###/gi);
			div.id = items[0];
			if(items[0].search("\\:")>=0){
				$items_a = items[0].split(":")
				items[0] = $items_a[0];
				}
			/*alert(items);*/
			if(ajax_list_cachedLists[paramToExternalFile][letters.toLowerCase()].length==1 && ajax_list_activeInput.value == items[0]){
				ajax_options_hide();
				return;						
			}
			/*alert(items[items.length-1]);*/
			if(ajax_list_activeInput.id == "sender_first_name" || ajax_list_activeInput.id == "reciever_name"){
				var splitItems = items[items.length-1].split("^^^");
				var separateRow = splitItems[0].split("~");
				var pushLabel = "";
				var pushLabel4 = '';
				for(var t = 0; t< separateRow.length;t++)
				{
					if(separateRow[t] != ""){
						var class_row = "address_row" + t;
						if(t == 0 || t== 1 || t == 2){
							var cutString = separateRow[t].substring(0, 10);
							pushLabel += "<label class="+ class_row +">" +cutString+ "</label>"; 
						}else{
							var cutAddressString = separateRow[t].substring(0, 10);
							pushLabel += cutAddressString + '...';
						}
					
						

					}
					
					//var separateRow =  separateRow.replace("~" , "</label> <label class ='address_row'>");
				}
				div.innerHTML = "<div class='fix_width'>" + pushLabel + "</div>";
			}else{
					
				div.innerHTML = items[items.length-1];
			}
		
			//code from 185 to 188 added by shailesh on date 9-7-13 to append address in hidden format for booking page affiliation page
			/*if(ajax_list_activeInput.id == "sender_first_name" || ajax_list_activeInput.id == "reciever_name"){
				var inputNo = eval(no + 1);
				document.getElementById("address_row"+inputNo).value=items[0];
			}*/
			if(suffix=='../'){
			div.onmousedown = function() {
				//CallSomeOne(id,div.id);
			};
			}
			div.className='optionDiv dataDiv';
			div.onmouseover = function(){ ajax_options_rollOverActiveItem(this,false) }
			div.onclick = ajax_option_setValue;
			
			if(!ajax_list_optionDivFirstItem)ajax_list_optionDivFirstItem = div;
			
			ajax_optionDiv.appendChild(div);
		}
		currentTotalRecords =currentTotalRecords+1;
		
		//alert(currentTotalRecords);
		if(ajax_list_activeInput.id == "sender_first_name" || ajax_list_activeInput.id == "reciever_name"){
			if(currentTotalRecords < 160){ var optionDivHeight = 160;}else{ var optionDivHeight = currentTotalRecords;}
			//$("#ajax_listOfOptions").css('width','572px');
			$("#ajax_listOfOptions").css('height',optionDivHeight);
			$("#ajax_listOfOptions").prepend(rightTop);
			$("#ajax_listOfOptions").prepend(addressDiv);
			$("#ajax_listOfOptions").prepend(companyDiv);	
			$("#ajax_listOfOptions").prepend(surnameDiv);	
			$("#ajax_listOfOptions").prepend(fnameDiv);	
		}
		if(optionsAdded){ 
			ajax_optionDiv.style.display='block';
			if(ajax_optionDiv_iframe)ajax_optionDiv_iframe.style.display='';
			ajax_options_rollOverActiveItem(ajax_list_optionDivFirstItem,true);
		}
					
	}
	
	function ajax_option_list_showContent(ajaxIndex,inputObj,paramToExternalFile,whichIndex)
	{
		/*alert();*/
		
		if(whichIndex!=currentListIndex)return;
		var letters = inputObj.value;
		
		var content = ajax_list_objects[ajaxIndex].response;
		
		var elements = content.split(',');
		
		ajax_list_cachedLists[paramToExternalFile][letters.toLowerCase()] = elements;
		
		ajax_option_list_buildList(letters,paramToExternalFile);
		
	}
	
	function ajax_option_resize(inputObj)
	{
		ajax_optionDiv.style.top = (ajax_getTopPos(inputObj) + inputObj.offsetHeight + ajaxBox_offsetY) + 'px';
		ajax_optionDiv.style.left = (ajax_getLeftPos(inputObj) + ajaxBox_offsetX) + 'px';
		if(ajax_optionDiv_iframe){
			ajax_optionDiv_iframe.style.left = ajax_optionDiv.style.left;
			ajax_optionDiv_iframe.style.top = ajax_optionDiv.style.top;			
		}		
		
	}
	
	function ajax_showOptions(inputObj,paramToExternalFile,e,File,divname)
	{	
		
		//console.log("divname:"+divname);
		ajax_list_externalFile = File;
		var filename = ajax_list_externalFile.split('/').pop();
		
		if(filename=="inter_state_val.php" && $('#changed_cntry').val()!='235')
		{
			return;
		}
		if(e.keyCode==13 || e.keyCode==9)return;
		if(ajax_list_currentLetters[inputObj.name]==inputObj.value)return;
		/* This is for the state dropdown list when united states is selected as country */
		
		
		/* This is for the state dropdown list when united states is selected as country */
		ajax_list_cachedLists[paramToExternalFile] = new Array();
		ajax_list_currentLetters[inputObj.name] = inputObj.value;
		if(!ajax_optionDiv){ 
			if(ajax_list_activeInput.id == "sender_first_name" || ajax_list_activeInput.id == "reciever_name"){
				if(strLength.length > 1){
				 ajax_optionDiv = document.createElement('DIV');
				}
			}else{
				ajax_optionDiv = document.createElement('DIV');
			}
			document.getElementById(inputObj.id).focus();
			ajax_optionDiv.id=divname;
			//ajax_optionDiv.id = 'ajax_listOfOptions';	
			document.body.appendChild(ajax_optionDiv);
			if(ajax_list_activeInput.id != "sender_first_name" || ajax_list_activeInput.id != "reciever_name"){
			 if(ajax_list_MSIE){
				ajax_optionDiv_iframe = document.createElement('IFRAME');
				ajax_optionDiv_iframe.border='0';
				ajax_optionDiv_iframe.style.width = ajax_optionDiv.clientWidth + 'px';
				ajax_optionDiv_iframe.style.height = ajax_optionDiv.clientHeight + 'px';
				ajax_optionDiv_iframe.id = 'ajax_listOfOptions_iframe';
				
				document.body.appendChild(ajax_optionDiv_iframe);
			 } 		
			}
			var allInputs = document.getElementsByTagName('INPUT');
			for(var no=0;no<allInputs.length;no++){
				if(!allInputs[no].onkeyup)allInputs[no].onfocus = ajax_options_hide;
			}			
			var allSelects = document.getElementsByTagName('SELECT');
			for(var no=0;no<allSelects.length;no++){
				allSelects[no].onfocus = ajax_options_hide;
			}

			var oldonkeydown=document.body.onkeydown;
			if(typeof oldonkeydown!='function'){
				document.body.onkeydown=ajax_option_keyNavigation;
			}else{
				document.body.onkeydown=function(){
					oldonkeydown();
				ajax_option_keyNavigation() ;}
			}
			var oldonresize=document.body.onresize;
			if(typeof oldonresize!='function'){
				document.body.onresize=function() {ajax_option_resize(inputObj); };
			}else{
				document.body.onresize=function(){oldonresize();
				ajax_option_resize(inputObj) ;}
			}
				
		}
		
		if(inputObj.value.length<minimumLettersBeforeLookup){
			ajax_options_hide();
			return;
		}
		
		ajax_optionDiv.style.top = (ajax_getTopPos(inputObj) + inputObj.offsetHeight + ajaxBox_offsetY) + 'px';
		ajax_optionDiv.style.left = (ajax_getLeftPos(inputObj) + ajaxBox_offsetX) + 'px';
		if(ajax_optionDiv_iframe){
			ajax_optionDiv_iframe.style.left = ajax_optionDiv.style.left;
			ajax_optionDiv_iframe.style.top = ajax_optionDiv.style.top;			
		}
		
		ajax_list_activeInput = inputObj;
		ajax_optionDiv.onselectstart =  ajax_list_cancelEvent;
		currentListIndex++;
		if(ajax_list_cachedLists[paramToExternalFile][inputObj.value.toLowerCase()]){
			ajax_option_list_buildList(inputObj.value,paramToExternalFile,currentListIndex);			
		}else{
			var tmpIndex=currentListIndex/1;
			ajax_optionDiv.innerHTML = '';
			var ajaxIndex = ajax_list_objects.length;
			ajax_list_objects[ajaxIndex] = new sack();
			//added by shailesh on date 9 7 2013 to list address depended on pick address type or delivery type in booking page
			var appendParam = "";
			if(ajax_list_activeInput.id == "sender_first_name"){
				appendParam = "&addType=pickup";
			}else if(ajax_list_activeInput.id == "reciever_name"){
				appendParam = "&addType=delivery";
			}
			/*if(appendParam != ""){
				var url = ajax_list_externalFile + '?' + paramToExternalFile + '=1&letters=' + inputObj.value.replace(" ","+") + appendParam;
			}else{
				var url = ajax_list_externalFile + '?' + paramToExternalFile + '=1&letters=' + inputObj.value.replace(" ","+");
			}*/
			var url = ajax_list_externalFile + '?' + paramToExternalFile + '=1&letters=' + inputObj.value.replace(" ","+") + appendParam;
			//var url = ajax_list_externalFile + '?' + paramToExternalFile + '=1&letters=' + inputObj.value.replace(" ","+");
			ajax_list_objects[ajaxIndex].requestFile = url;	// Specifying which file to get
			ajax_list_objects[ajaxIndex].onCompletion = function(){ ajax_option_list_showContent(ajaxIndex,inputObj,paramToExternalFile,tmpIndex); };	// Specify function that will be executed after file has been found
			//Edited by shailesh on date 15-7-2013 to get execute below in booking address page
			
			if(ajax_list_activeInput.id == "sender_first_name" || ajax_list_activeInput.id == "reciever_name"){
				var strLength = document.getElementById(ajax_list_activeInput.id).value; 
				if(strLength.length > 1){
					ajax_list_objects[ajaxIndex].runAJAX();		// Execute AJAX function
				}		
			}else{
				ajax_list_objects[ajaxIndex].runAJAX();		// Execute AJAX function	
			}
			
			//ajax_list_objects[ajaxIndex].runAJAX();		// Execute AJAX function
				
		}
		//This is to get list in booking page for users pickup and  delivery address auto fillup event
		if(currentTotalRecords < 160){ var optionDivHeight = 160;}else{ var optionDivHeight = currentTotalRecords;}
		if(ajax_list_activeInput.id == "sender_first_name"){
			$("#ajax_listOfOptions").css('width','524px');
			//$("#ajax_listOfOptions").css('height','102px');
			$("#ajax_listOfOptions").css('height',optionDivHeight);
			$("#ajax_listOfOptions").css('top','492px');
			$("#ajax_listOfOptions").css('left','614px');
			$("#ajax_listOfOptions").css('border-radius','7px');
			//$('#sender_first_name').focus(function() {$(this).setCursorPosition($('#sender_first_name').val().length);});
			//$("#booking_form").css('height','98px');
			//$("#address_col").css('height','98px');
			//$("#ajax_listOfOptions").focus();
		}else if(ajax_list_activeInput.id == "reciever_name"){
			//$('#reciever_name').focus(function() {$(this).setCursorPosition($('#reciever_name').val().length);});
			//$("#ajax_listOfOptions").css('font-weight','500');
			$("#ajax_listOfOptions").css('width','524px');
			//$("#ajax_listOfOptions").css('height','102px');
			$("#ajax_listOfOptions").css('height',optionDivHeight);
			$("#ajax_listOfOptions").css('top','492px');
			$("#ajax_listOfOptions").css('left','756px');
			$("#ajax_listOfOptions").css('border-radius','7px');
			//$("#booking_form").css('height','98px');
			//$("#address_col").css('height','98px');
			//$("#ajax_listOfOptions").focus();
		}
		
			
	}
	
	function ajax_option_keyNavigation(e)
	{
		
		if(document.all)e = event;
		
		if(!ajax_optionDiv)return;
		if(ajax_optionDiv.style.display=='none')return;
		
		if(e.keyCode==38){	// Up arrow
			if(!ajax_list_activeItem)return;
			if(ajax_list_activeItem && !ajax_list_activeItem.previousSibling)return;
			ajax_options_rollOverActiveItem(ajax_list_activeItem.previousSibling,true);
		}
		
		if(e.keyCode==40){	// Down arrow
			
			if(!ajax_list_activeItem){
				ajax_options_rollOverActiveItem(ajax_list_optionDivFirstItem,true);
			}else{
				if(!ajax_list_activeItem.nextSibling)return;
				ajax_options_rollOverActiveItem(ajax_list_activeItem.nextSibling,true);
			}
		}
		if(ajax_list_activeInput.id == "sender_first_name" || ajax_list_activeInput.id == "reciever_name"){
			
			if(e.keyCode==13){	// Enter key or tab key
				if(ajax_list_activeItem && ajax_list_activeItem.className=='optionDivSelected')ajax_option_setValue(false,ajax_list_activeItem);
				if(suffix=='../'){
				//CallSomeOne(gElement,ajax_list_activeItem.id);
				}
				if(e.keyCode==13)return false; else return true;
			}
			if(e.keyCode==27){	// Escape key
				ajax_options_hide();			
			}
		}else{
			if(e.keyCode==13)return false; else return true;
			//alert("test");
			//if(e.keyCode==13 || e.keyCode==9){	// Enter key or tab key
				if(e.keyCode==13 && e.keyCode!=9){	// Enter key or tab key
					if(ajax_list_activeItem && ajax_list_activeItem.className=='optionDivSelected')ajax_option_setValue(false,ajax_list_activeItem);
					if(suffix=='../'){
					//CallSomeOne(gElement,ajax_list_activeItem.id);
					}
					if(e.keyCode==13)return false; else return true;
				}else{
					//alert("enter key press");
					$("#ausPostcode").val("");
					$("#state").val("");
				}
				if(e.keyCode==27){	// Escape key
					ajax_options_hide();			
			}	
		}
		
	}
	
	
	document.documentElement.onclick = autoHideList;
	
	function autoHideList(e)
	{
		if(document.all)e = event;
		
		if (e.target) source = e.target;
			else if (e.srcElement) source = e.srcElement;
			if (source.nodeType == 3) // defeat Safari bug
				source = source.parentNode;		
		if(source.tagName.toLowerCase()!='input' && source.tagName.toLowerCase()!='textarea')ajax_options_hide();
		
	}
	
	function callDropDownItems(a)
	{
		$("#servicePageItem_1").html(a);
	}
	var k =0;
	function callDropDownGetQuoteItems(a)
	{
		//alert(i);
		$("#selShippingType_1").val("");
		var shipping_type = $("#selShippingType_1").val();
		
		var lastRow = $("#last_inserted_cell_australia").val();
		
		document.getElementById("servicePageItem_1").innerHTML = a;
		
		$(".separate").html(a);
		
			
		var j;
		for(j=2;j<=lastRow;j++)
		{
			DelSizeDataRow(j);
		}
		//i++;
	}
	function unsetAusValues()
	{
		//$("#Item_qty_1").val("");
		$("#Item_qty_1").val("1");
		$("#Item_weight_1").val("");
		$("#Item_length_1").val("");
		$("#Item_width_1").val("");
		$("#Item_height_1").val("");
		
		
		$("#total_qty").html("");
		$("#total_weight").html("");
		$("#total_volumetric_weight").html("");
		$("#Item_qty_1").attr('readonly', false);
		$("#Item_weight_1").attr('readonly', false);
		$("#Item_length_1").attr('readonly', false);
		$("#Item_width_1").attr('readonly', false);
		$("#Item_height_1").attr('readonly', false);
		$("#time_hr").val("hh");
		$("#hr_formate").val("am");
		$("#time_sec").val("mm");
	}
	function unsetIndexAusValues()
	{
		$("#Item_weight_1").val("");
		$("#Item_length_1").val("");
		$("#Item_width_1").val("");
		$("#Item_height_1").val("");
		var lastRow = $("#last_inserted_cell_australia").val();
		var j;
		for(j=2;j<=lastRow;j++)
		{
			DelSizeDataRow(j);
		}
		
		$("#Item_weight").attr('readonly', false);
		$("#Item_length").attr('readonly', false);
		$("#Item_width").attr('readonly', false);
		$("#Item_height").attr('readonly', false);
		$("#time_hr").val("hh");
		$("#hr_formate").val("am");
		$("#time_sec").val("mm");
	}
	