<?php
	/**
	* This file is for display user list
	*
	* @author     Radixweb <team.radixweb@gmail.com>
	* @copyright  Copyright (c) 2008, Radixweb
	* @version    1.0
	* @since      1.0
	*/
	
	/**
	 * include common file
	 */
	require_once("../lib/common.php");
	require_once('pagination_top.php');
	require_once(DIR_WS_MODEL . "UserMaster.php");
	require_once(DIR_WS_MODEL . "AddressMaster.php");
	require_once(DIR_WS_MODEL . "CountryMaster.php");
	require_once(DIR_WS_RELATED."system_mail.php");
	require_once("../lib/bcrypt.php");	
	require_once(DIR_WS_ADMIN_LANGUAGES . DIR_CURRENT_LANGUAGE. '/user.php');
	
		
	/**
	 * Start :: Object declaration
	 */
	$CountryMasterObj   = new CountryMaster();
	$CountryMasterObj   = $CountryMasterObj->Create();
	$ObjUserMaster		= new UserMaster();
	$ObjUserMaster		= $ObjUserMaster->Create();
	$UserData			= new UserData();
	$ObjAddressMaster   = new AddressMaster();
	$ObjAddressMaster   = $ObjAddressMaster->Create();
	$ObjAddress	        = new AddressData();
		
	
	/**
	 * Inclusion and Exclusion Array of Javascript
	 */
	$arr_javascript_include[] = "internal/user_action.php";
	$arr_javascript_plugin_include[] = 'overlib.js';
	$arr_javascript_plugin_include[] = 'datatables/js/jquery.dataTables.min.js';
	$arr_javascript_plugin_include[] = 'bootstrap/js/bootstrap.min.js';
	$arr_javascript_plugin_include[] = 'ddaccordion/js/ddaccordion.js';
	
	$pagenum = ($_GET['pagenum']!="")?($_GET['pagenum']):(1);
	if(!empty($pagenum))
	{
		$err['pagenum'] = isNumeric(valid_input($pagenum),ENTER_NUMERIC_VALUES_ONLY);
	}
	if(!empty($err['pagenum']))
	{
		logOut();
	}
	$userid = $_GET['userid'];
	if(!empty($userid))
	{
		$err['userid'] = isNumeric(valid_input($userid),ENTER_NUMERIC_VALUES_ONLY);
	}
	if(!empty($err['userid']))
	{
		logOut();
	}
	
	

	/**
	 * Variable Declaration
	 */
	 /*csrf validation*/
	$csrf = new csrf();
	$csrf->action = "admin_user_action";
	/*if(!isset($_POST['ptoken']))
	{
		$ptoken = $csrf->csrfkey();
	}*/
	/*csrf validation*/
	
	$btnSubmit = ADMIN_BUTTON_SAVE_USER;
	$HeadingLabel = ADMIN_USERS_ADD_HEADING;
	
	if(!empty($_GET['Action']))
	{
		$err['Action'] = chkStr(valid_input($_GET['Action']));
	}
	if(!empty($err['Action']))
	{
		logOut();
	}
	 if($_GET['Action']!='' &&  $_GET['Action']=='export'){


	$Users = $ObjUserMaster->getUser();	
	
	$filename = DIR_WS_ADMIN_DOCUMENTS."user.csv"; //Balnk CSV File
	$file_extension = strtolower(substr(strrchr($filename,"."),1));	//GET EXtension
    
	/**
	 * Genration of CSV File
	 */
	switch( $file_extension ) {
	  case "csv": $ctype = "text/comma-separated-values";break;
	  case "jpg": $ctype="image/jpg"; break;
	  default: $ctype="application/force-download";
	}    
	header("Pragma: public"); // required
	header('Expires: ' . gmdate('D, d M Y H:i:s') . ' GMT');
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Cache-Control: private",false); // required for certain browsers
	header("Content-Type: $ctype");
	header("Content-Disposition: attachment; filename=".basename($filename).";" );
	header("Content-Transfer-Encoding: binary");
	
	ob_clean();
	
	$curr= array("€"=>"�","£"=>"�");
	$data = "";
	$data.= "userid,\"firstname\",\"lastname\",\"email\",\"password\",\"street_address\",\"suburb\",\"city\",\"postcode\",\"state\",\"country\",\"deleted\",\"phone_number\",\"work_phone_no\",\"mobile_no\",\"user_type_id\",\"corporate_id\",\"site_language_id\",\"last_login_date\",\"address1\",\"address2\",\"address3\",\"facsimile_no\"";
				
	if(isset($Users) && !empty($Users)) {		
		foreach ($Users as $User) {		
			/*Code for the Currency value in which the order has been done*/
			$userid = $User['userid'];
			$firstname = valid_output($User['firstname']);
			$lastname = valid_output($User['lastname']);
			$email  = valid_output($User['email']);
			$salt = generateSalt($email);
	        $storededPassword = generateHash($salt, $User['password']);
	        $password = valid_output($storededPassword);
			$suburb  = valid_output($User['suburb']);
			$postcode = valid_output($User['postcode']);
			$state  = valid_output($User['state']);
			$country  = valid_output($User['country']);
			$deleted  = valid_output($User['deleted']);
			$phone_number  = valid_output($User['phone_number']);
			$work_phone_no = valid_output($User['work_phone_no']);
			$user_type_id = valid_output($User['user_type_id']);
			$corporate_id = valid_output($User['corporate_id']);
			$site_language_id  = valid_output($User['site_language_id']);
			$last_login_date  = valid_output($User['last_login_date']);
			$address1  = valid_output($User['address1']);
			$address2  = valid_output($User['address2']);
			$address3  = valid_output($User['address3']);
			$facsimile_no = valid_output($User['facsimile_no']);

			$data.= "\n";
			$data.= '"'.$userid.'","'.$firstname.'","'.$lastname.'","'.$email.'","'.$password.'","'.$street_address.'","'.$suburb.'","'.$city.'","'.$postcode.'","'.$state.'","'.$country.'","'.$deleted.'","'.$phone_number.'","'.$work_phone_no.'","'.$user_type_id.'","'.$corporate_id.'","'.$site_language_id.'","'.$last_login_date.'","'.$address1.'","'.$address2.'","'.$address3.'","'.$facsimile_no.'"';
		}			
	}
	echo $data;
	exit();
}
	
	
	
	if((isset($_POST['btnsubmit']) && $_POST['btnsubmit'] != "")){
		
		if(isEmpty(valid_input($_POST['ptoken']), true))
		{	
			//logOut();
		}
		else
		{
			//$csrf->checkcsrf($_POST['ptoken']);
		}
		
		$err['firstnameError'] 		 = isEmpty(valid_input($_POST['firstname']), COMMON_FIRSTNAME_IS_REQUIRED)?isEmpty(valid_input($_POST['firstname']), COMMON_FIRSTNAME_IS_REQUIRED):checkName(valid_input($_POST['firstname']));
		$err['lastnameError'] 		 = isEmpty(valid_input($_POST['lastname']), COMMON_LASTNAME_IS_REQUIRED)?isEmpty(valid_input($_POST['lastname']),COMMON_LASTNAME_IS_REQUIRED):checkName(valid_input($_POST['lastname']));
		$err['suburbError']          = isEmpty(valid_input($_POST['suburb']), COMM0N_SUBURB_IS_REQUIRED)?isEmpty(valid_input($_POST['suburb']),COMM0N_SUBURB_IS_REQUIRED):checkName(valid_input($_POST['suburb']));;
		$err['address1']	 		= isEmpty(valid_input($_POST['address1']),COMMON_ADDRESS_IS_REQUIRED)?isEmpty(valid_input($_POST['address1']),COMMON_ADDRESS_IS_REQUIRED):chkStreet(valid_input($_POST['address1']));	
		if($_POST['country']=='13' && valid_input($_POST['country']!=''))
		{
			$err['postcodeError'] 		 = (isEmpty(valid_input($_POST['postcode']),COMMON_ZIPCODE_IS_REQUIRED))?isEmpty(valid_input($_POST['postcode']),COMMON_ZIPCODE_IS_REQUIRED):isNumeric(valid_input($_POST['postcode']),COMMON_ZIPCODE_IN_NUMERIC);
		;
		}else{
			$err['postcodeError']  = chkStreet(valid_input($_POST['postcode']));
		}
		$err['countryError'] 		 = isEmpty(valid_input($_POST['country']), COMMON_COUNTRY_IS_REQUIRED)?isEmpty(valid_input($_POST['country']),COMMON_PHONE_IS_REQUIRED):isNumeric(valid_input($_POST['country']),COMMON_PHONE_IN_NUMERIC);
		$err['phoneError']	 		 = (isEmpty(valid_input($_POST['phone_number']),COMMON_PHONE_IS_REQUIRED))?isEmpty(valid_input($_POST['phone_number']),COMMON_PHONE_IS_REQUIRED):isNumeric(valid_input($_POST['phone_number']),COMMON_PHONE_IN_NUMERIC);
		
		$err['emailError'] 			 = (isEmpty(valid_input($_POST['email']),COMMON_EMAIL_IS_REQUIRED))?isEmpty(valid_input($_POST['email']),COMMON_EMAIL_IS_REQUIRED):checkEmailPattern(valid_input($_POST['email']),ERROR_EMAIL_FORMAT);
		$err['securityQuesError_1']	= isEmpty(valid_input($_POST['security_ques_1']),COMMON_SECURITY_QUESTION_IS_REQUIRED)?isEmpty(valid_input($_POST['security_ques_1']),COMMON_SECURITY_QUESTION_IS_REQUIRED):'';
		$err['securityAnsError_1']	= isEmpty(valid_input($_POST['security_ans_1']),COMMON_SECURITY_ANSWER_IS_REQUIRED)?isEmpty(valid_input($_POST['security_ans_1']),COMMON_SECURITY_ANSWER_IS_REQUIRED):chkStreet(valid_input($_POST['security_ans_1']));
		$err['securityQuesError_2']	= isEmpty(valid_input($_POST['security_ques_2']),COMMON_SECURITY_QUESTION_IS_REQUIRED)?isEmpty(valid_input($_POST['security_ques_2']),COMMON_SECURITY_QUESTION_IS_REQUIRED):'';
		$err['securityAnsError_2']	= isEmpty(valid_input($_POST['security_ans_2']),COMMON_SECURITY_ANSWER_IS_REQUIRED)?isEmpty(valid_input($_POST['security_ans_2']),COMMON_SECURITY_ANSWER_IS_REQUIRED):chkStreet(valid_input($_POST['security_ans_2']));
		
		if(empty($userid))
		{
			$err['passwordError'] 		 = isEmpty(valid_input($_POST['password']), COMMON_PASSWORD_IS_REQUIRED);
			$err['passwordError'] 		 = checkPassword(valid_input($_POST['password']));
			$err['confirmpasswordError'] = isEmpty(valid_input($_POST['confirmpassword']), COMMON_CONFIRM_PASSWORD_IS_REQUIRED);
			$err['confirmpasswordError'] = checkPassword(valid_input($_POST['confirmpassword']));
		}
		if($_POST['company']!='')
		{
			$err['companyError'] = checkName(valid_input($_POST['company']));
		}
		if((valid_input($_POST['address2']))!="")
		{
			$err['address2'] = chkStreet(valid_input($_POST['address2']));
		}
		if((valid_input($_POST['address3']))!="")
		{
			$err['address3'] = chkStreet(valid_input($_POST['address3']));
		}
		if((valid_input($_POST['state'])!=""))
		{
			$err['stateError'] = chkState(valid_input($_POST['state']));
		}
		
		if(valid_input($_POST['mobile_phone'])!="")
		{
			$err['contactNo2'] = areaCodePattern(valid_input($_POST['mobile_phone']),ERROR_AREA_CODE_INVALID,'0');
		}
	    checkEmailPattern(valid_input($_POST['email']),ERROR_EMAIL_FORMAT);
		
		if($err['emailError']==''){
			$FieldArr = array();
			$FieldArr[]='count(*) as total'; // To Count Total Data
			$usersearch = array();
			$usersearch[]=array('Search_On'=>'email', 'Search_Value'=>valid_input($_POST['email']), 'Type'=>'string', 'Equation'=>'=', 'CondType'=>'AND', 'Prefix'=>'', 'Postfix'=>'');

			if($userid!=''){
				$usersearch[]=array('Search_On'=>'userid', 'Search_Value'=>$userid, 'Type'=>'int', 'Equation'=>'!=', 'CondType'=>'AND', 'Prefix'=>'', 'Postfix'=>'');
			}
			//Checks for duplicat email address
			$DataUservalue =$ObjUserMaster->getUser($FieldArr, $usersearch); // Fetch Data
			$TotalUser = $DataUservalue[0]['total'];
			if($TotalUser>0){
				$err['emailError'] = COMMON_EMAIL_EXISTS;
			}
		}
    	if($err['passwordError'] =='' && $err['confirmpasswordError']==''){
    		if(valid_input($_POST['password']) != valid_input($_POST['confirmpassword'])){
				$err['confirmpasswordError'] = COMMON_CONFIRM_PASSWORD_DIFFERENT_ERROR;
    		}
    	}
		/*echo "<pre>";
		print_r($err);
		echo "</pre>";
		exit();*/
	    /**
		 * Checking Error Exists
		 */
		foreach($err as $key => $Value) {
			if($Value != '') {
				$Svalidation=true;
				$ptoken = $csrf->csrfkey();
			}
		}
		if($Svalidation==false){
			
			$UserData->firstname = valid_input($_POST['firstname']);
			$UserData->lastname = valid_input($_POST['lastname']);
			$UserData->company    = valid_input($_POST['company']);
			$UserData->suburb = valid_input($_POST['suburb']);
			$UserData->address1 = valid_input($_POST['address1']);
	  		$UserData->address2 = valid_input($_POST['address2']);
	  		$UserData->address3 = valid_input($_POST['address3']);
			$UserData->postcode = valid_input($_POST['postcode']);
			$UserData->state = valid_input($_POST['state']);
			$UserData->country = valid_input($_POST['country']);
			$UserData->phone_number = valid_input($_POST['phone_number']);
			$UserData->mobile_no = valid_input($_POST['mobile_phone']);
			$UserData->email = valid_input($_POST['email']);
			$UserData->deleted =1;
			$UserData->user_type_id = 1;			
			$UserData->corporate_id = 0;
			$UserData->site_language_id = SITE_LANGUAGE_ID;
			$UserData->last_login_date = date('Y-m-d H:i:s');
			//$UserData->ip_address = $_SERVER['REMOTE_ADDR'];
			$UserData->ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
			$UserData->last_login_attempt_datetime = '00:00:00';
			$UserData->login_attempt = 0;
			
			$UserData->facsimile_no="";
			$UserData->security_ques_1 = valid_input($_POST['security_ques_1']);	  		
			$UserData->security_ans_1 = valid_input($_POST['security_ans_1']);	  		
			$UserData->security_ques_2 = valid_input($_POST['security_ques_2']);	  		
			$UserData->security_ans_2 = valid_input($_POST['security_ans_2']);
			
			if($userid!=''){
				//Edit Users
				$UserData->userid = $userid;
				$ObjUserMaster->editAdminUser($UserData);
				$UParam = "?pagenum=".$pagenum."&message=".MSG_EDIT_SUCCESS;
			}else{
				//Add Users
				$bcrypt = new bcrypt(12);
				$UserData->password  = $bcrypt->genHash($_POST['password']);
				$insertedUserId = $ObjUserMaster->addUser($UserData);
				$UParam = "?pagenum=".$pagenum."&message=".MSG_ADD_SUCCESS;
			}
			/**
			 * Insert Or Edit User Address Data
			 */		
			$ObjAddress->firstname    	= valid_input($_POST['firstname']);
			$ObjAddress->lastname    		= valid_input($_POST['lastname']);
			
			$ObjAddress->street_address   = valid_input($_POST['street_address']);
			$ObjAddress->suburb        	= valid_input($_POST['suburb']);
			$ObjAddress->postcode    		= valid_input($_POST['postcode']);
			$ObjAddress->state           	= valid_input($_POST['state']);
			$ObjAddress->country        	= valid_input($_POST['country']);
			$ObjAddress->phone_number        	= valid_input($_POST['phone_number']);
			$ObjAddress->default_address    	= ($_POST['default_address']!='')? $_POST['default_address'] : '1';
			$ObjAddress->from_signup          	= '1';
			
			
			if($userid!=''){
				$ObjAddress->user_id = $userid;
				$ObjAddressMaster->editAddress($ObjAddress,"profile");
				
			}else{
				//Addition of user address
				//Send_New_User_Registration_Mail($UserData);
				$ObjAddress->user_id = $insertedUserId;
				$ObjAddressMaster->addAddress($ObjAddress);		
				
			}
			header('Location:'.FILE_USERS.$UParam);
			exit;
		}
		
	}
	
	/**
	 * Gets details for the user
	 */
	if($userid!=''){
		$usersearch = array();
		$usersearch[]=array('Search_On'=>'userid', 'Search_Value'=>$userid, 'Type'=>'int', 'Equation'=>'=', 'CondType'=>'AND', 'Prefix'=>'', 'Postfix'=>'');
		$DataUser=$ObjUserMaster->getUser(null, $usersearch); // Fetch Data
		$DataUser = $DataUser[0];
		//Get sign up Address
		$AddressSearch = array();
		$AddressSearch[]=array('Search_On'=>'user_id', 'Search_Value'=>$userid, 'Type'=>'string', 'Equation'=>'=', 'CondType'=>'AND', 'Prefix'=>'', 'Postfix'=>'');
		$AddressSearch[]=array('Search_On'=>'from_signup', 'Search_Value'=>'1', 'Type'=>'string', 'Equation'=>'=', 'CondType'=>'AND', 'Prefix'=>'', 'Postfix'=>'');
		$UserAddresData = $ObjAddressMaster->getAddress(null, $AddressSearch);
		$UserAddresData = $UserAddresData[0];
		
		//Variable declaration
		$langId = $DataUser["site_language_id"];
		$SelCountry = $DataUser["country"];
		$UserTypeId = $DataUser["user_type_id"];
		if(!empty($DataUser["corporate_id"])){
			$UserTypeId = $UserTypeId . "_" . $DataUser["corporate_id"];
		}
		
		$btnSubmit = ADMIN_BUTTON_UPDATE_USER;
		$HeadingLabel = ADMIN_USERS_EDIT_HEADING;
	}
	$allCountry = $CountryMasterObj->getCountry();
	/*echo "<pre>";
	print_R($DataUser);
	echo "</pre>";
	exit();*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php if ($_GET['userid']=='') { echo ADMIN_ADD_USER; } else { echo ADMIN_EDIT_USER;}?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<?php 
addPluginCSSFile($arr_css_plugin_include,$arr_css_plugin_exclude);
addCSSFileAdmin($arr_css_admin_include, $arr_css_admin_exclude);
addJavaScriptFile($arr_javascript_include, $arr_javascript_exclude);
addPluginJavaScriptFile($arr_javascript_plugin_include,$arr_javascript_plugin_exclude);
?>
</head>
<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
	<tr>
		<td valign="top">
		<?php require_once(DIR_WS_ADMIN_INCLUDES . ADMIN_FILE_HEADER);?>
		</td>
	</tr>	
	<!-- Start Middle Content part -->
	<tr>
		<td class="middle_content">
			<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td class="middle_left_content">
						<?php 
						// Include the Left Panel
						require_once(DIR_WS_ADMIN_INCLUDES . ADMIN_FILE_LEFT_MENU);
						?>
					</td>
					<td valign="top">
					<!-- Start :  Middle Content-->
						<table class="middle_right_content" align="center" border="0" cellpadding="0" cellspacing="0">
							<tr>
								<td align="left" class="breadcrumb">
										<span><a href="<?php echo FILE_WELCOME_ADMIN; ?>"><?php echo ADMIN_HEADER_HOME; ?></a> > <a href="<?php echo FILE_USERS."?pagenum=".$pagenum; ?>"> <?php echo ADMIN_HEADER_USERS; ?> </a> > <? echo $HeadingLabel; ?></span>
										<div><label class="top_navigation"><a href="<?php echo FILE_USERS."?pagenum=".$pagenum;; ?>"><?php echo ADMIN_COMMON_BACK ?></a></label></div>
								</td>
							</tr>
							<tr>
								<td class="heading">
									<?php echo $HeadingLabel; ?>
								</td>
							</tr>
																
							<tr><td colspan="4">&nbsp;</td></tr>
													
															
							<tr>
								<td align="center">
									<?php  /*** Start :: Listing Table ***/ ?>
									<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
										
										<form name="frmuser" id="frmuser" method="POST"  action="" autocomplete="off">
										<input type="hidden" name="default_address" value="<?php echo valid_output($UserAddresData["default_address"]); ?>" >
										<tr>
											<td>
												<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
													<tr>
														<td>
															<table width="98%" border="0" cellpadding="0" border="0" cellspacing="0" >
																<tr>
																	<td class="message_mendatory" align="right" colspan="4">
																		<?echo ADMIN_COMMAN_REQUIRED_INFO;?>
																	</td>
																</tr>
																<tr>
																	<td colspan="4" align="left" valign="top" class="grayheader"><b><?php echo ADMIN_USERS_PERSONAL_DETAILS;?> : </b></td>
																</tr>
																<tr><td colspan="4"><input type="hidden" id="ptoken" value="<?php echo $ptoken; ?>" name="ptoken">&nbsp;</td></tr>
																<tr>
																	<td  align="left" valign="middle"><?php echo ADMIN_COMMON_FIRSTNAME;?></td>
																	<td  align="left" valign="middle"  class="message_mendatory"><input class="textbox" type="text" name="firstname"  value="<?php if($_POST['firstname'] != ''){ echo valid_output($_POST['firstname']);}else{ echo valid_output($DataUser["firstname"]); } ?>" maxlength="50" tabindex="18"/>&nbsp;*<img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>internal/help_up.gif" class="help_btn" alt="<?php echo ADMIN_COMMON_FIRSTNAME; ?>"onmouseover="return overlib('<?php echo $FirstName;?>');" onmouseout="return nd();" /></td>
																	<td  align="left" valign="middle"><?php echo ADMIN_COMMON_LASTNAME;?></td>
																	<td  align="left" valign="top" class="message_mendatory"><input class="textbox" type="text" name="lastname"  value="<?php if($_POST['lastname'] != ''){ echo valid_output($_POST['lastname']);}else{ echo valid_output($DataUser["lastname"]); } ?>" maxlength="50" tabindex="19"/>&nbsp;*<img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>internal/help_up.gif" class="help_btn" alt="<?php echo ADMIN_COMMON_LASTNAME; ?>"onmouseover="return overlib('<?php echo $LastName;?>');" onmouseout="return nd();" /></td>
																</tr>
																<tr>
																	<td align="left" valign="middle">&nbsp;</td>
																	<td align="left" valign="top" class="message_mendatory" id="firstnameError"><?php echo $err['firstnameError'];  ?></td>
																	<td align="left" valign="middle">&nbsp;</td>
																	<td align="left" valign="top" class="message_mendatory" id="lastnameError"><?php echo $err['lastnameError'];  ?></td>
																</tr>
	<!-- Company name field start-->
	<tr>
																	<td  align="left" valign="middle"><?php echo ADMIN_COMMON_COMPANY;?></td>
																	<td  align="left" valign="middle"  class="message_mendatory"><input class="textbox" type="text" name="company"  value="<?php if($_POST['company'] != ''){ echo valid_output($_POST['company']);}else{ echo valid_output($DataUser["company"]); } ?>" maxlength="50" tabindex="18"/>&nbsp;<img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>internal/help_up.gif" class="help_btn" alt="<?php echo ADMIN_COMMON_FIRSTNAME; ?>"onmouseover="return overlib('<?php echo $Company;?>');" onmouseout="return nd();" /></td>
																	<td  align="left" valign="middle">&nbsp;</td>
																	<td  align="left" valign="top" class="message_mendatory">&nbsp;</td>
																</tr>
																<tr>
																	<td align="left" valign="middle">&nbsp;</td>
																	<td align="left" valign="top" class="message_mendatory" id="companyError"><?php echo $err['companyError'];  ?></td>
																	<td align="left" valign="middle">&nbsp;</td>
																	<td align="left" valign="top" class="message_mendatory" ></td>
																</tr>
	<!-- Company name field end -->
   	<tr>
																	<td align="left" valign="middle"  nowrap="nowrap"><?php echo ADMIN_COMMON_ADDRESS;?></td>
																	<td  align="left" valign="middle" class="message_mendatory"><input type="text" maxlength="25" name="address1" value="<?php if($_POST['address1'] != ''){ echo valid_output($_POST['address1']);}elseif ($DataUser['address1']!='') { echo valid_output($DataUser['address1']); }  ?>" id="address1" tabindex="20"/>&nbsp;*<img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>internal/help_up.gif" class="help_btn" alt="<?php echo ADMIN_COMMON_STREET; ?>"onmouseover="return overlib('<?php echo $Address;?>');" onmouseout="return nd();" /></td>
																	<td align="left" valign="middle"><?php echo ADMIN_COMMON_SUBURB;?></td>
																	<td align="left" valign="top" class="message_mendatory"><input name="suburb" type="text" class="textbox"  value="<?php if($_POST['suburb'] != ''){ echo valid_output($_POST['suburb']);}else{ echo valid_output($DataUser["suburb"]); } ?>"  tabindex="21" />*</td>
																</tr>
																<tr>
																	<td align="left" valign="middle">&nbsp;</td>
																	<td align="left" valign="top" class="message_mendatory" id="addressError"><?php  if (isset($err['address1'])) {echo 
			$err['address1'];}  ?></td>
																	<td  align="left" valign="middle" >&nbsp;</td>
																	<td  align="left" valign="top" id="suburbError" class="message_mendatory"><?php echo $err['suburbError'];?>&nbsp;</td>
																</tr>
																<tr>
																	<td  align="left" valign="middle"></td>
																	<td  align="left" valign="middle" class="message_mendatory">
																	<input type="text" maxlength="25" name="address2" value="<?php if($_POST['address2'] != ''){ echo valid_output($_POST['address2']); } 
			elseif ($Users!='') { echo valid_output($DataUser['address2']); }  ?>" id="address2" tabindex="22"/>&nbsp;*<img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>internal/help_up.gif" class="help_btn" alt="<?php echo ADMIN_COMMON_CITY; ?>"onmouseover="return overlib('<?php echo $City;?>');" onmouseout="return nd();" /></td>
																	<td  align="left" valign="middle"><?php echo ADMIN_COMMON_ZIPCODE;?></td>
																	<td  align="left" valign="middle" class="message_mendatory"><input name="postcode" type="text" class="textbox"  value="<?php if($_POST['postcode'] != ''){ echo $_POST['postcode'];}else{ echo $DataUser["postcode"]; } ?>" tabindex="23"/>&nbsp;*<img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>internal/help_up.gif" class="help_btn" alt="<?php echo ADMIN_COMMON_ZIPCODE; ?>"onmouseover="return overlib('<?php echo $PostCodes;?>');" onmouseout="return nd();" /></td>
																</tr>
																<tr>
																	<td align="left" valign="middle">&nbsp;</td>
																	<td align="left" valign="middle" class="message_mendatory" id="address2Error" ><?php  if (isset($err['address2'])) {echo 
			$err['address2'];}  ?></td>
																	<td align="left" valign="middle">&nbsp;</td>
																	<td align="left" valign="middle" class="message_mendatory" id="postcodeError"><?php echo $err['postcodeError']; ?></td>
																</tr>
																<tr>
																	<td align="left" valign="middle">&nbsp;</td>
																	<td align="left" valign="middle" ><input type="text" maxlength="25" name="address3" value="<?php if($_POST['address3'] != ''){ 
			echo valid_output($_POST['address3']); } elseif ($Users!='') { echo valid_output($DataUser['address3']); }  ?>" id="address3" tabindex="5"/></td>
																	<td align="left" valign="middle">&nbsp;</td>
																	<td align="left" valign="middle"  ></td>
																</tr>
																<tr>
																	<td align="left" valign="middle">&nbsp;</td>
																	<td align="left" valign="middle" class="message_mendatory" id="address3Error"><?php  if (isset($err['address3'])) {echo 
			$err['address3'];}  ?></td>
																	<td align="left" valign="middle">&nbsp;</td>
																	<td align="left" valign="middle"  id="countryError" class="message_mendatory"><?php echo $err['countryError']; ?></td>
																</tr>
																<tr>
																	<td  align="left" valign="middle"><?php echo ADMIN_COMMON_STATE;?></td>
																	<td  align="left" valign="middle" ><input name="state" type="text" class="textbox"  value="<?php if($_POST['state'] != ''){ echo valid_output($_POST['state']);}else{ echo valid_output($DataUser["state"]); } ?>" tabindex="24"/>&nbsp;<img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>internal/help_up.gif" class="help_btn" alt="<?php echo ADMIN_COMMON_STATE; ?>"onmouseover="return overlib('<?php echo $State;?>');" onmouseout="return nd();" /></td>
																	<td align="left" valign="middle"><?php echo ADMIN_COMMON_COUNTRY?></td>
																	<td colspan="3" align="left" valign="middle" class="message_mendatory">
																	<select name="country" id="country" tabindex="25"  >
																		<option value=""><?php echo ADMIN_COMMON_SELECT_COUNTRY;?></option>
																		<?php
																		if($_POST['country']!="")
																		{
																			$err['country'] = isNumeric(valid_input($_POST['country']),ERROR_ENTER_NUMERIC_VALUE);
																			if($err['country'])
																			{
																				logOut();
																			}
																		}elseif($userid && $userid != ""){
																			$SelCountry = $DataUser->country;
																		}else{
																			$SelCountry = COUNTRY_SELECT;
																		}
																		if ($allCountry != ''){
																		foreach ($allCountry as $Country)
																		{?>
																		<option value="<?php echo $Country->countries_id;?>" <?php if($SelCountry==$Country->countries_id){  ?>selected<?php }?>>
																		<?php echo valid_output($Country->countries_name);?>
																		</option>
																		<?php }
																		}?>
																	</select>&nbsp;*
																	<img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>internal/help_up.gif" class="help_btn" alt="<?php echo ADMIN_COMMON_COUNTRY; ?>"onmouseover="return overlib('<?php echo $CountryName;?>');" onmouseout="return nd();" />
																	</td>
																</tr>
																<tr>
																	<td align="left" valign="middle">&nbsp;</td>
																	<td align="left" valign="middle" class="message_mendatory" id="stateError"><?php echo $err['stateError']; ?></td>
																	<td align="left" valign="middle">&nbsp;</td>
																	<td align="left" valign="middle"  id="countryError" class="message_mendatory"><?php echo $err['countryError']; ?></td>
																</tr>
																<tr>
																	<td align="left" valign="middle"><?php echo ADMIN_COMMON_HOME_PHONE;?></td>
																	<td align="left" valign="top"  class="message_mendatory">
																	<table >
																		<tr>
																			<td></td>
																			<td><input name="phone_number" id="phone_number" class="textbox" type="tel" value="<?php if($_POST['phone_number'] != ''){ echo $_POST['phone_number'];}else{ echo $DataUser["phone_number"]; }?>"  tabindex="27"/>&nbsp;*<img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>internal/help_up.gif" class="help_btn" alt="<?php echo ADMIN_COMMON_HOME_PHONE; ?>"onmouseover="return overlib('<?php echo $PhoneNO;?>');" onmouseout="return nd();" /></td>
																		</tr>
																	</table>
																	</td>
																	<td align="left" valign="middle"><?php echo ADMIN_SECURITY_QUESTION; ?></td>
																	<td align="left" valign="top" class="message_mendatory" ><select tabindex="28" name="security_ques_1" id="security_ques_1" >
																	<option value='0'>Select Security Question</option>
																	<?php
																	foreach($quest_arr_1 as $key => $val)
																	{
																												
																		$selected ="selected='selected'";
																	?>
																	<option value='<?php echo $key; ?>' <?php if($DataUser['security_ques_1'] == $key){echo $selected;}?>><?php echo $val; ?></option>
																	<?php
																	}
																	?>
																	</select> *
																	</td>
																</tr> 
																<tr>
																	<td align="left" valign="middle">&nbsp;</td>
																	<td align="left" valign="top">
																	<table >
																		<tr>
																			<td  id="areaCodeError" class="message_mendatory">&nbsp;</td>
																			<td  id="phoneError" class="message_mendatory"><?php echo $err['phoneError']; ?></td>
																		</tr>
																	</table>
																	</td>
																	<td align="left" valign="middle">&nbsp;</td>
																	<td align="left" valign="middle" id="securityQuesError_1" class="message_mendatory"><?php if(isset($err['securityQuesError_1'])) { echo $err['securityQuesError_1']; } ?>&nbsp;</td>
																</tr>
																<tr>
																	<td align="left" valign="middle"><?php echo ADMIN_COMMON_MOBILE_PHONE;?>&nbsp;</td>
																	<td align="left" valign="middle">
																	<table>
																		<tr>
																		<td></td>
																		<td><input name="mobile_phone" class="textbox" type="tel" id="mobile_phone" value="<?php if($_POST['mobile_phone'] != ''){ echo $_POST['mobile_phone'];}else{ echo $DataUser["mobile_no"]; }?>"  tabindex="31"/></td>
																		</tr>
																	</table>
																	</td>
																	<td align="left" valign="middle" ><?php echo ADMIN_SECURITY_ANSWER; ?>&nbsp;</td>
																	<td align="left" valign="middle" class="message_mendatory"><input type="text" tabindex="29" name="security_ans_1" id="security_ans_1" value="<?php echo valid_output($DataUser['security_ans_1']);?>"  />&nbsp;</td>
																</tr>
																<tr>
														<td>&nbsp;</td>
														<td align="left" valign="middle">
														<table>
															<tr>
															<td align="left" valign="middle" id="" class="message_mendatory">&nbsp;</td>
															<td align="left" valign="middle" id="" class="message_mendatory"><?php echo $err['contactNo2']; ?>&nbsp;</td>
															</tr>
														</table>
														</td>
														<td align="left" valign="middle">&nbsp;</td>
														<td align="left" valign="middle" class="message_mendatory" id="securityAnsError_1"><?php if(isset($err['securityAnsError_1'])) { echo $err['securityAnsError_1']; } ?>&nbsp;</td>
													</tr>
													<tr>
	<td align="left" valign="middle">&nbsp;</td>
	<td align="left" valign="middle">
	<table>
		<tr>
		<td></td>
		<td></td>
		</tr>
	</table>
	</td>
	<td align="left" valign="middle" ><?php echo ADMIN_SECURITY_QUESTION; ?>&nbsp;</td>
	<td align="left" valign="middle" class="message_mendatory">
	<select tabindex="28" name="security_ques_2" id="security_ques_2" >
	<option value='0'>Select Security Question</option>
	<?php
	foreach($quest_arr_2 as $key => $val)
	{										
		$selected ="selected='selected'";
	?>
	<option value='<?php echo $key; ?>' <?php if($DataUser['security_ques_2'] == $key){echo $selected;}?>><?php echo $val; ?></option>
	<?php
	}
	?>
	</select> *
	&nbsp;</td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td align="left" valign="middle">
	<table>
		<tr>
			<td align="left" valign="middle" id="" class="message_mendatory">&nbsp;</td>
			<td align="left" valign="middle" id="" class="message_mendatory">&nbsp;</td>
		</tr>
	</table>
	</td>
	<td align="left" valign="middle">&nbsp;</td>
	<td align="left" valign="middle" class="message_mendatory" id="securityQuesError_2"><?php if(isset($err['securityQuesError_2'])) { echo $err['securityQuesError_2']; } ?>&nbsp;</td>
</tr>
<tr>
	<td align="left" valign="middle">&nbsp;</td>
	<td align="left" valign="middle">
	<table>
		<tr>
		<td></td>
		<td></td>
		</tr>
	</table>
	</td>
	<td align="left" valign="middle" ><?php echo ADMIN_SECURITY_ANSWER; ?>&nbsp;</td>
	<td align="left" valign="middle" class="message_mendatory">
	<input type="text" tabindex="29" name="security_ans_2" id="security_ans_2" value="<?php echo valid_output($DataUser['security_ans_2']);?>"  />*
	&nbsp;</td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td align="left" valign="middle">
	<table>
		<tr>
			<td align="left" valign="middle" id="" class="message_mendatory">&nbsp;</td>
			<td align="left" valign="middle" id="" class="message_mendatory">&nbsp;</td>
		</tr>
	</table>
	</td>
	<td align="left" valign="middle">&nbsp;</td>
	<td align="left" valign="middle" class="message_mendatory" id="securityAnsError_2"><?php if(isset($err['securityAnsError_2'])) { echo $err['securityAnsError_2']; } ?>&nbsp;</td>
</tr>



															</table>
														</td>
													</tr>
																										<tr>
														<td>
															<table width="98%" border="0" cellpadding="3" border="0" cellspacing="0" >
																<tr>
																	<td align="left" valign="top" class="grayheader"><b><?php echo ADMIN_USERS_LOGIN_INFO;?> : </b></td>
																</tr>
																<tr>
																	<td>
																		<table width="100%" border="0" cellpadding="0" border="0" cellspacing="0" >
																			<tr><td>&nbsp;</td></tr>
																			<tr>
																				<td width="20%" align="left"><?php echo ADMIN_COMMON_EMAIL_ADDRESS; ?></td>
																				<td class="message_mendatory" align="left"><input tabindex="32" type="text" name="email" value="<?php if($_POST['email'] != ''){ echo $_POST['email'];}else{ echo valid_output($DataUser["email"]); }?>" class="register" >&nbsp;*<img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>internal/help_up.gif" class="help_btn" alt="<?php echo ADMIN_COMMON_EMAIL_ADDRESS; ?>"onmouseover="return overlib('<?php echo $Email_Address;?>');" onmouseout="return nd();" /></td>
																			</tr>
																			<tr>
																				<td>&nbsp;</td>
																				<td align="left" valign="middle"  id="emailError" class="message_mendatory"><?php echo $err['emailError']; ?></td>
																			</tr>
																			<?php
																			 if(!isset($userid) && empty($userid))
																			 {
																			?>
																			<tr>
																				<td align="left"><?php echo ADMIN_COMMON_PASSWORD; ?></td>
																				<td class="message_mendatory" align="left"><input tabindex="33" type="password" name="password" autocomplete="password" value="<?php if($_POST['password'] != ''){ echo $_POST['password'];}else{ echo valid_output($DataUser["password"]); }?>" class="register" >&nbsp;*<img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>internal/help_up.gif" class="help_btn" alt="<?php echo ADMIN_COMMON_COMFIRM_PASSWORD; ?>"onmouseover="return overlib('<?php echo $Password;?>');" onmouseout="return nd();" /></td>
																			</tr>
																			<tr>
																				<td>&nbsp;</td>
																				<td align="left" valign="middle"  id="passwordError" class="message_mendatory"><?php echo $err['passwordError']; ?></td>
																			</tr>
																			<tr>
																				<td align="left"><?php echo ADMIN_COMMON_COMFIRM_PASSWORD; ?></td>
																				<td class="message_mendatory" align="left"><input tabindex="34" type="password" name="confirmpassword" autocomplete="new-password" value="<?php if($_POST['confirmpassword'] != ''){ echo $_POST['confirmpassword'];}else{ echo valid_output($DataUser["password"]); }?>" class="register" >&nbsp;*<img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>internal/help_up.gif" class="help_btn" alt="<?php echo ADMIN_COMMON_COMFIRM_PASSWORD; ?>"onmouseover="return overlib('<?php echo $Confirm_Password;?>');" onmouseout="return nd();" /></td>
																			</tr>
																			<?php
																			}
																			?>
																			<tr>
																				<td>&nbsp;</td>
																				<td align="left" valign="middle"  id="confirmpasswordError" class="message_mendatory"><?php echo $err['confirmpasswordError']; ?></td>
																			</tr>
																		</table>
																	</td>
																</tr>
																<tr>
																	<td>&nbsp;</td>
																</tr>
															</table>
														</td>
													</tr>
												</table>
											</td>
										</tr>
										<tr>
											<td>&nbsp;</td>
										</tr>
										<tr>
											<td align="center">
											<input type="submit" class="action_button" tabindex="36" name="btnsubmit" value="<?php echo $btnSubmit; ?>" onclick="return validate_client(this.form);" >
											<input type="reset" tabindex="37" name="reset" class="action_button" value="<?php echo ADMIN_COMMON_BUTTON_RESET; ?>" >
											<input type="button"  class="action_button" name="cancel" tabindex="38" value="<?php echo ADMIN_COMMON_BUTTON_CANCEL;?>" onclick="javascript:document.location.href='<?php echo FILE_USERS."?pagenum=".$pagenum; ?>';return true;"/>
											</td>
										</tr>
										<tr>
											<td>&nbsp;</td>
										</tr>
										</form>
									</table>
									<?php  /*** End :: Listing Table ***/ ?>
								</td>
							</tr>
						</table>
					<!-- End :  Middle Content-->
					</td>
				</tr>
			</table>
		</td>
	</tr>
<!-- End Middle Content part -->
	<tr>
		<td id="footer">
			<?php require_once(DIR_WS_ADMIN_INCLUDES . ADMIN_FILE_FOOTER);?>
		</td>
	</tr>
</table>
</body>
</html>
<?php require_once(DIR_WS_JSCRIPT."internal/jquery.php"); ?>
