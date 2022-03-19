<?php
/**
 * This file is for editing user's information
 *
 * This file contains code for editing user's information
 *
 *
 * @author     Radixweb <team.radixweb@gmail.com>
 * @copyright  Copyright (c) 2008, Radixweb
 * @version    1.0
 * @since      1.0
 */

/**
 * Common File Inclusion
 *
 */
require_once("lib/common.php");
require_once("lib/bcrypt.php");
define("TITLE","Profile");
if(!defined('SES_USER_ID')) {
	show_page_header(FILE_SIGNUP);
}
require_once(DIR_WS_MODEL . "UserMaster.php");
require_once(DIR_WS_MODEL . "CountryMaster.php");
require_once(DIR_WS_MODEL . "AddressMaster.php");
define("TITLE","User Profile Page");
require_once(DIR_WS_CURRENT_LANGUAGE . "user.php");

$display ='none';
/**
 * Inclusion and Exclusion CSS
 */
$arr_css_plugin_include[] = 'glyphicons_new/css/glyphicons.css';
/**
 * Inclusion and Exclusion Array of Javascript
 */
 $arr_css_plugin_include[] = 'waitMe/css/waitMe.min.css';
$arr_javascript_include[] = 'internal/ajex.js'; 
$arr_javascript_include[] = 'internal/ajax-dynamic-list.js';
$arr_javascript_plugin_include[] ="back-to-top.js";
$arr_javascript_below_include[] = 'internal/profile.php';
$arr_javascript_plugin_include[] = 'waitMe/js/waitMe.min.js';
/**
 * Object Declaration
 *
 */
$UserMasterObj    = UserMaster::Create();
$CountryMasterObj = CountryMaster::Create();
$UserData         = new UserData();
$ObjAddressMaster = AddressMaster::Create();
$ObjAddress       = new AddressData();

/**
 * This code is executed when submit is pressed checks about the fields and the user
 *
 */
 
if(defined('SES_USER_ID')) {
	$userSeaArr[]     = array('Search_On'=>'userid', 'Search_Value'=>SES_USER_ID, 'Type'=>'int', 'Equation'=>'=', 'CondType'=>'AND', 'Prefix'=>'','Postfix'=>'');
	$Users            = $UserMasterObj->getUser(null, $userSeaArr);
	$userAddressArr[] = array('Search_On'=>'user_id', 'Search_Value'=>SES_USER_ID, 'Type'=>'int', 'Equation'=>'=', 'CondType'=>'AND', 'Prefix'=>'','Postfix'=>'');
	$userAddressArr[] = array('Search_On'=>'from_signup', 'Search_Value'=>'1', 'Type'=>'string', 'Equation'=>'Like', 'CondType'=>'AND', 'Prefix'=>'','Postfix'=>'');
	$userAddress      = $ObjAddressMaster->getAddress(null, $userAddressArr);
	$userAddress      = $userAddress[0];
	$Users            = $Users[0];
	
}
/**
 * This code is for Editing user's profile
 *
 */
 /*csrf validation*/
$csrf = new csrf();
$csrf->action = "user_profile";
if($_POST['Submit']=='')
{
	$ptoken = $csrf->csrfkey();
}
/*csrf validation*/

//
if(isset($_POST['Submit']) && $_POST['Submit'] != '')
{
	
	if(isEmpty(valid_input($_POST['ptoken']), true)){	
			logOut();
	}else{
		$csrf->checkcsrf($_POST['ptoken']);
	}
	$err['firstname']		= isEmpty(valid_input($_POST['firstname']),COMMON_FIRSTNAME_IS_REQUIRED)?isEmpty(valid_input($_POST['firstname']),COMMON_FIRSTNAME_IS_REQUIRED):checkName(valid_input($_POST['firstname']));
	$err['lastname']			= isEmpty(valid_input($_POST['lastname']),COMMON_LASTNAME_IS_REQUIRED)?isEmpty(valid_input($_POST['lastname']),COMMON_LASTNAME_IS_REQUIRED):checkName(valid_input($_POST['lastname']));
	
	$err['suburb']	 			= isEmpty(valid_input($_POST['suburb']),COMM0N_SUBURB_IS_REQUIRED)?isEmpty(valid_input($_POST['suburb']),COMM0N_SUBURB_IS_REQUIRED):checkSuburb(valid_input($_POST['suburb']));
	if(COUNTRY_SELECT == $_POST['country'])
	{
		$err['postcode']	 		= isEmpty(valid_input($_POST['postcode']),COMMON_ZIPCODE_IS_REQUIRED)?isEmpty(valid_input($_POST['postcode']),COMMON_ZIPCODE_IS_REQUIRED):isNumeric(valid_input($_POST['postcode']),ERROR_ENTER_NUMERIC_VALUE);
	}else{
		$err['postcode']	 		= isEmpty(valid_input($_POST['postcode']),COMMON_ZIPCODE_IS_REQUIRED)?isEmpty(valid_input($_POST['postcode']),COMMON_ZIPCODE_IS_REQUIRED):chkStreet(valid_input($_POST['postcode']));
	}
	if(isset($_POST['country']) && $_POST['country']==UNITED_STATE_ID)
	{
		if(strlen($_POST['postcode'])!=5)
		{
			$err['postcode'] = ERROR_US_POSTCODE;
		}
	}
	$err['country']	 			= isEmpty(valid_input($_POST['country']),COMMON_COUNTRY_IS_REQUIRED)?isEmpty(valid_input($_POST['Country']),COMMON_COUNTRY_IS_REQUIRED):'';
	$err['areaCode']	 		= isEmpty(valid_input($_POST['sender_area_code']),COMMON_AREA_CODE_IS_REQUIRED)?isEmpty(valid_input($_POST['sender_area_code']),COMMON_AREA_CODE_IS_REQUIRED):areaCodePattern(valid_input($_POST['sender_area_code']),ERROR_AREA_CODE_INVALID,'1');
	$err['phone']	 			= isEmpty(valid_input($_POST['phone']),COMMON_PHONE_IS_REQUIRED)?isEmpty(valid_input($_POST['phone']),COMMON_PHONE_IS_REQUIRED):areaCodePattern(valid_input($_POST['phone']),ERROR_AREA_CODE_INVALID,'0');
	$err['address1']	 		= isEmpty(valid_input($_POST['address1']),COMMON_ADDRESS_IS_REQUIRED)?isEmpty(valid_input($_POST['address1']),COMMON_ADDRESS_IS_REQUIRED):chkStreet(valid_input($_POST['address1']));
	$err['securityQuesError_1']	= isEmpty(valid_input($_POST['security_ques_1']),COMMON_SECURITY_QUESTION_IS_REQUIRED)?isEmpty(valid_input($_POST['security_ques_1']),COMMON_SECURITY_QUESTION_IS_REQUIRED):isNumeric(valid_input($_POST['security_ques_1']),ERROR_ENTER_NUMERIC_VALUE);
	$err['securityAnsError_1']	= isEmpty(valid_input($_POST['security_ans_1']),COMMON_SECURITY_ANSWER_IS_REQUIRED)?isEmpty(valid_input($_POST['security_ans_1']),COMMON_SECURITY_ANSWER_IS_REQUIRED):chkStreet(valid_input($_POST['security_ans_1']));
	$err['securityQuesError_2']	= isEmpty(valid_input($_POST['security_ques_2']),COMMON_SECURITY_QUESTION_IS_REQUIRED)?isEmpty(valid_input($_POST['security_ques_2']),COMMON_SECURITY_QUESTION_IS_REQUIRED):isNumeric(valid_input($_POST['security_ques_2']),ERROR_ENTER_NUMERIC_VALUE);
	$err['securityAnsError_2']	= isEmpty(valid_input($_POST['security_ans_2']),COMMON_SECURITY_ANSWER_IS_REQUIRED)?isEmpty(valid_input($_POST['security_ans_2']),COMMON_SECURITY_ANSWER_IS_REQUIRED):chkStreet(valid_input($_POST['security_ans_2']));
	/*echo "<pre>";
	print_r($err['country']);
	echo "</pre>";
	exit();
*/
	if($_POST['firstname']!="" && strlen($_POST['firstname'])<2)
	{
		$err['firstname'] = ENTER_CHARACTER;
	}
	if($_POST['lastname']!="" && strlen($_POST['lastname'])<2)
	{
		$err['lastname'] = ENTER_CHARACTER;
	}
	
	if($_POST['old_security_question']!='')
	{
		$err['old_security_question'] = isNumeric(valid_input($_POST['old_security_question']),ERROR_ENTER_NUMERIC_VALUE);
	}
	if(!empty($err['old_security_question']))
	{
		logOut();
	}
	if($_POST['changed_cntry']!="")
	{
		$err['changed_cntry'] = isNumeric(valid_input($_POST['changed_cntry']),ERROR_ENTER_NUMERIC_VALUE);
	}
	if($err['changed_cntry']!="")
	{
		logOut();
	}
	if($_POST['company']!='')
	{
		$err['company'] = checkName(valid_input($_POST['company']));
	}
	if($_POST['ulangid']!='')
	{
		$err['ulangid'] = isNumeric(valid_input($_POST['ulangid']),ERROR_ENTER_NUMERIC_VALUE);
	}
	if(!empty($err['ulangid']))
	{
		logOut();
	}
	if($_POST['old_security_ans']!='')
	{
		$err['old_security_ans'] = checkName(valid_input($_POST['old_security_ans']));
	}
	if(!empty($err['old_security_ans']))
	{
		logOut();
	}
	if(valid_input($_POST['address2'])!="")
	{
		$err['address2'] = chkStreet(valid_input($_POST['address2']));
	}
	if(valid_input($_POST['address3'])!="")
	{
		$err['address3'] = chkStreet(valid_input($_POST['address3']));
	}
	if(valid_input($_POST['facsimile_no'])!="")
	{
		$err['facsimile_no'] = chkFax(valid_input($_POST['facsimile_no']));
	}
	if((valid_input($_POST['state'])!=""))
	{
		$err['state'] = chkState(valid_input($_POST['state']));
	}
	if(valid_input($_POST['sender_mb_area_code'])!="")
	{
		$err['areaContactNo2'] = areaCodePattern(valid_input($_POST['sender_mb_area_code']),ERROR_AREA_CODE_INVALID,'1');
	}
	if(valid_input($_POST['mobile_phone'])!="")
	{
		$err['contactNo2'] = areaCodePattern(valid_input($_POST['mobile_phone']),ERROR_AREA_CODE_INVALID,'0');
	}
	if(!empty($_POST['password'])){
		$err['Pass'] = checkPassword($_POST['password']);
	}
	if(!empty($_POST['confirmpassword'])){
		$err['confirmpassword'] = checkPassword($_POST['confirmpassword']);
	}
	if($err['confirmpassword']!="")
	{
		logOut();
	}
	if(!empty($_POST['oldpassword'])){
		$err['oldpassword'] = checkPassword($_POST['oldpassword']);
	}
	if($err['oldpassword']!="")
	{
		logOut();
	}
	if(!empty($_POST['valid_pass']))
	{
		$err['valid_pass'] = chkSmall($_POST['valid_pass']);
	}
	if($err['valid_pass']!="")
	{
		logOut();
	}
	if(!empty($_POST['email_old']))
	{
		$err['email_old'] = checkEmailPattern(valid_input($_POST['email_old']), ERROR_EMAIL_ID_INVALID);
	}
	if($err['email_old']!="")
	{
		logOut();
	}
	
	$bcrypt = new bcrypt(12);
	$FieldArr = array();
	$FieldArr[]='password'; // To Count Total Data
	$usersearch = array();
	if($userid!=''){
		$usersearch[]=array('Search_On'=>'userid', 'Search_Value'=>$userid, 'Type'=>'int', 'Equation'=>'=', 'CondType'=>'AND', 'Prefix'=>'', 'Postfix'=>'');
	}
	
	$DataUservalue =$UserMasterObj->getUser(null, $usersearch); // Fetch Data
	//$TotalUser = $DataUservalue[0]['total'];
	if(!empty($DataUservalue[0]['password'])){
		$HashFromDB = $DataUservalue[0]['password'];
	}
	
	//echo "hashfromdb:".$HashFromDB."<br>";
	//echo "oldpassword:".$_POST['oldpassword']."<br>";
	$pass_error = $bcrypt->verify($_POST['oldpassword'], $HashFromDB);
	//echo "pass_error".$pass_error;
	//echo "old pass".$_POST['oldpassword'];
	//exit();
	
	if(empty($pass_error) && !empty($_POST['oldpassword']))
	{
		$err['OldPass'] = USER_PASSWORD_NOT_MATCH;
		$display ='block';
	}
	$err['EmailId']	 			= isEmpty(valid_input($_POST['email']),COMMON_EMAIL_IS_REQUIRED)?isEmpty(valid_input($_POST['email']),COMMON_EMAIL_IS_REQUIRED):checkEmailPattern(valid_input($_POST['email']), ERROR_EMAIL_ID_INVALID);
	
	if($err['EmailId']==''){
			$FieldArr = array();
			$FieldArr[]='count(*) as total,userid'; // To Count Total Data
			$userEmailsearch = array();
			$userEmailsearch[]=array('Search_On'=>'email', 'Search_Value'=>valid_input($_POST['email']), 'Type'=>'string', 'Equation'=>'=', 'CondType'=>'AND', 'Prefix'=>'', 'Postfix'=>'');
			/*
			if($userid!=''){
				$usersearch[]=array('Search_On'=>'userid', 'Search_Value'=>$userid, 'Type'=>'int', 'Equation'=>'!=', 'CondType'=>'AND', 'Prefix'=>'', 'Postfix'=>'');
			}
			*/
			$DataUservalue =$UserMasterObj->getUser($FieldArr, $userEmailsearch); // Fetch Data
			$TotalUser = $DataUservalue[0]['total'];
			$dbuserid = $DataUservalue[0]['userid'];
			//echo "total same id:".$TotalUser;
			//exit();
			if($TotalUser>0 && $dbuserid!=$userid){
				$err['EmailId'] = COMMON_EMAIL_EXISTS;
				$display ='block';
			}
	}
	
	/*
	echo "</pre>";
	print_R($err);
	echo "</pre>";
	exit();
	*/	
	foreach($err as $key => $Value) {
		if($Value != '') {
			$Svalidation=true;
			$csrf->action = "forget_password";
			$ptoken = $csrf->csrfkey();
		}
	}
	
	if ($Svalidation==false)
	{
		
	/**
	 * This codes fetches the values from the user and updation is carried out
	 *
	 */
	if (isset($Users) && $Users!= '')
	{
	
		$UserData->userid         = SES_USER_ID;
		$UserData->firstname      = ucwords(strtolower(valid_input($_POST['firstname'])));
		$UserData->lastname       = ucwords(strtolower(valid_input($_POST['lastname'])));
		$UserData->company       = ucwords(valid_input(strtolower($_POST['company'])));
		$UserData->email          = $Users->email;
		//$UserData->password       = $Users->password;
		//$UserData->street_address = valid_input($_POST['street_address']);
		$UserData->suburb         = ucwords(valid_input(strtolower($_POST['suburb'])));
		//$UserData->city           = valid_input($_POST['city']);
		$UserData->postcode       = valid_input($_POST['postcode']);
		if(isset($_POST['country']) && $_POST['country']==AUSTRALIA_ID)
		{
			$UserData->state          = strtoupper(valid_input($_POST['state']));
		}else{
			$UserData->state = ucwords(strtolower($_POST['state']));
		}
		$UserData->state_code     = strtoupper(valid_input($_POST['register_state_code']));
		$UserData->country        = ucwords(strtolower(valid_input($_POST['country'])));
		$UserData->sender_area_code = valid_input($_POST['sender_area_code']);
		$UserData->phone_number   = valid_input($_POST['phone']);
		
		$UserData->sender_mb_area_code  = valid_input($_POST['sender_mb_area_code']);
		$UserData->mobile_no      = valid_input($_POST['mobile_phone']);
		
		$UserData->address1      = ucwords(strtolower(valid_input($_POST['address1'])));
		$UserData->address2      = ucwords(strtolower((valid_input($_POST['address2']))));
		$UserData->address3      = ucwords(strtolower((valid_input($_POST['address3']))));
		
		$UserData->security_ques_1  = ucwords(strtolower(valid_input($_POST['security_ques_1'])));
		$UserData->security_ans_1   = ucwords(strtolower(valid_input($_POST['security_ans_1'])));
		$UserData->security_ques_2  = ucwords(strtolower(valid_input($_POST['security_ques_2'])));
		$UserData->security_ans_2   = ucwords(strtolower(valid_input($_POST['security_ans_2'])));
		$UserData->email          = valid_input($_POST['email']);
		//$UserData->ip_address             = $_SERVER['REMOTE_ADDR'];
		$UserData->ip_address             = $_SERVER['HTTP_X_FORWARDED_FOR'];
		if(!empty($_POST['password']))
		{
			$UserData->password       = $bcrypt->genHash($_POST['password']);
		}else
		{
			$UserData->password       = $Users->password;
		
		}
		
		$UserData->user_type_id   = $Users->user_type_id;
		$UserData->corporate_id   = $Users->corporate_id;
		//$UserData->site_language_id   = $_POST['ulangid'];
		$UserData->site_language_id   = '1';
		$UserData->login_attempt = '0';
		$UserData->last_login_attempt_datetime = '0000-00-00 00:00:00';
		$UserMasterObj->editUser($UserData);

		$ObjAddress->user_id              = SES_USER_ID;
		$ObjAddress->firstname            = ucwords(strtolower($_POST['firstname']));
		$ObjAddress->lastname             = ucwords(strtolower($_POST['lastname']));
		//$ObjAddress->street_address       = $_POST['street_address'];
		$ObjAddress->suburb               = ucwords(valid_input(strtolower($_POST['suburb'])));
		$ObjAddress->postcode             = $_POST['postcode'];
		//$ObjAddress->city                 = $_POST['city'];
		if(isset($_POST['country']) && $_POST['country']==AUSTRALIA_ID)
		{
			$ObjAddress->state	= strtoupper($_POST['state']);
		}else{
			$ObjAddress->state	= ucwords(strtoupper($_POST['state']));
		}
		$ObjAddress->state_code		          = strtoupper($_POST['register_state_code']);
		
		$ObjAddress->country = ucwords(strtoupper($_POST['country']));
		$ObjAddress->sender_area_code        = valid_input($_POST['sender_area_code']);
		$ObjAddress->phone_number         = valid_input($_POST['phone']);
		$ObjAddress->default_address      = $userAddress['default_address'];
		$ObjAddress->from_signup          = "1";
		$ObjAddressMaster->editAddress($ObjAddress,"profile");
			
		//show_page_header(FILE_INDEX,false);
		header("Location:".SITE_INDEX);
		exit();
		
		}
	}
}

  require_once( DIR_WS_SITE_CURRENT_TEMPLATE . FILE_MAIN_INTERFACE);
?>
