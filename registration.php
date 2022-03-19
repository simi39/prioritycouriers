<?php
/**
 * This file is for registration
 *
 * This file content all the code for registration of user
 *
 *
 * @author     Radixweb <team.radixweb@gmail.com>
 * @copyright  Copyright (c) 2008, Radixweb
 * @version    1.0
 * @since      1.0
 * 
 */


/**
 * Common File Inclusion
 *
 */
 
require_once("lib/common.php");

//define("TITLE","Create a new account | Online Couriers");
require_once(DIR_WS_MODEL . "UserMaster.php");
require_once(DIR_WS_MODEL . "AddressMaster.php");
require_once(DIR_WS_CURRENT_LANGUAGE . "user.php");
require_once(DIR_WS_MODEL."CmsPagesMaster.php");
require_once(DIR_WS_MODEL ."BookingDetailsMaster.php");
require_once(DIR_WS_MODEL ."BookingItemDetailsMaster.php");
require_once(DIR_WS_MODEL ."ClientAddressMaster.php");
require_once(DIR_WS_MODEL."CommercialInvoiceMaster.php");
require_once(DIR_WS_MODEL."CommercialInvoiceItemMaster.php");
require_once(DIR_WS_RELATED."system_mail.php");
//require_once("lib/bcrypt.php");	
require_once(DIR_WS_RECAPTCHA."autoload.php");
error_reporting(E_ALL ^ E_NOTICE ^ E_DEPRECATED ^ E_STRICT);
/**
 * Object and variable Declaration
 * 
 */



$UserMasterObj      = UserMaster::Create();
$UserData           = new UserData();

$ObjAddressMaster   = AddressMaster::Create();
$ObjAddress	        = new AddressData();

$ObjCmsPagesMaster	= CmsPagesMaster::Create();

$objClientAddressMaster = ClientAddressMaster::create();
$objClientAddressData =  new ClientAddressData();

/**
 * Inclusion and Exclusion CSS
 */
$arr_css_plugin_include[] = 'glyphicons_new/css/glyphicons.css';
$arr_css_plugin_include[] = 'waitMe/css/waitMe.min.css';
/**
 * Inclusion and Exclusion Array of Javascript
 */
$arr_javascript_include[] = 'internal/ajex.js';  
$arr_javascript_include[] = 'internal/ajax-dynamic-list.js';
$arr_javascript_below_include[] = "internal/registration.php";
$arr_javascript_plugin_include[] ="back-to-top.js";
$arr_javascript_plugin_include[] = 'waitMe/js/waitMe.min.js';


/*csrf validation*/
$csrf = new csrf();
if(!isset($_POST['submit_form']))
{
	$csrf->action = "user_registration";
	$ptoken = $csrf->csrfkey();
}

/*csrf validation*/
if(defined('SES_USER_ID')) {
	show_page_header(FILE_GET_QUOTE);
	exit();
}

//
/** This Code set the url of Back **/
if(isset($_GET["preurl"]) && $_GET["preurl"] != '' ) {
	 $__Session->SetValue("Go_Back_Url",$_SERVER["HTTP_REFERER"]);
	 $__Session->Store();
}
$PreviousUrl = $__Session->GetValue("Go_Back_Url");

	$CmsPageName = "registration";
	if($CmsPageName)
	{
		$file = str_replace('../', '', $CmsPageName);/*if some page path is included validation for that is applied*/
		if(!isset($file))
		{
				$error =true;
		}
		$error = chkPages($CmsPageName);/*only small,capital and underscore is applied */
		
		if(isset($error))
		{
			header("Location:".SITE_INDEX);
			exit();
		}	
	}
	$fieldArr = array("cms_pages.*, cms_pages_description.page_heading , cms_pages_description.page_content");
	$searchArr = array();
	$searchArr[] = " AND cms_pages_description.site_language_id = '".SITE_LANGUAGE_ID."'";
	$searchArr[] = " AND cms_pages.page_name = '".$CmsPageName ."'";
	$searchArr[] = " AND cms_pages.status='1'";
	$DataCmsMaster = $ObjCmsPagesMaster->getCmsPagesDetails($searchArr, $fieldArr);
	$cmsData = $DataCmsMaster[0];

	/* Keys for recaptcha */
	$siteKey = '6LeuBwoTAAAAALmH5yxGYT_tE-G9kMtvKHl0rsmX';
	$secret = '6LeuBwoTAAAAAKOkON9SsUfxpHY81QIFn9wMpVRe';
	$lang = 'en';
	/* Keys for recaptcha */
/**
 *
 * This code is for signin to user
 *
 */
 

if(isset($_POST['btnlogin'])) {
		$auth_result = user_athuentication($_POST['email_signup'], $_POST['password_signup']);
		
		//This below code commented on Date Wed Apr 03 19:11:20 IST 2013 
		//show_page_header(FILE_BOOKING_RECORDS, false);
		//This below line commented by shailesh jamanapara on Date Wed Jul 24 10:44:09 IST 2013
		UnsetSession();
		show_page_header(FILE_GET_QUOTE, false);
		exit();
		
		
}

/**
 *
 * This code is for registration of user
 *
 */
 
 //exit();
if(isset($_POST['submit_form']) && $_POST['submit_form'] != '') {
	
	if(isEmpty(valid_input($_POST['ptoken']), true)){	
		logOut();
	}else{
		$csrf->checkcsrf($_POST['ptoken']);
	}
	
	//Server Side Validation
	$err['firstname']			= isEmpty(valid_input($_POST['firstname']),COMMON_FIRSTNAME_IS_REQUIRED)?isEmpty(valid_input($_POST['firstname']),COMMON_FIRSTNAME_IS_REQUIRED):checkName(valid_input($_POST['firstname']));
	
	$err['lastname']			= isEmpty(valid_input($_POST['lastname']),COMMON_LASTNAME_IS_REQUIRED)?isEmpty(valid_input($_POST['lastname']),COMMON_LASTNAME_IS_REQUIRED):checkName(valid_input($_POST['lastname']));
	$err['EmailId']	 			= isEmpty(valid_input($_POST['email']),COMMON_EMAIL_IS_REQUIRED)?isEmpty(valid_input($_POST['email']),COMMON_EMAIL_IS_REQUIRED):checkEmailPattern(valid_input($_POST['email']), ERROR_EMAIL_ID_INVALID);
    $err['Pass']			    = (isEmpty(valid_input($_POST['password']),ERROR_PASSWORD_REQUIRE))?isEmpty(valid_input($_POST['password']),ERROR_PASSWORD_REQUIRE):'';
	$err['ConfPass'] 			= isEmpty(valid_input($_POST['confirmpassword']),COMMON_CONFIRM_PASSWORD_IS_REQUIRED)?isEmpty(valid_input($_POST['confirmpassword']),COMMON_CONFIRM_PASSWORD_IS_REQUIRED):isPassConpassSame(valid_input($_POST['password']),valid_input($_POST['confirmpassword']));
	$err['address1']	 		= isEmpty(valid_input($_POST['address1']),COMMON_ADDRESS_IS_REQUIRED)?isEmpty(valid_input($_POST['address1']),COMMON_ADDRESS_IS_REQUIRED):chkStreet(valid_input($_POST['address1']));
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
	$err['state']	 		= isEmpty(valid_input($_POST['state']),COMM0N_STATE_IS_REQUIRED)?isEmpty(valid_input($_POST['state']),COMM0N_STATE_IS_REQUIRED):isNumeric(valid_input($_POST['state']),ERROR_ENTER_NUMERIC_VALUE);
	$err['suburb']	 			= isEmpty(valid_input($_POST['suburb']),COMM0N_SUBURB_IS_REQUIRED)?isEmpty(valid_input($_POST['suburb']),COMM0N_SUBURB_IS_REQUIRED):checkName(valid_input($_POST['suburb']));
	$err['country']	 			= isEmpty(valid_input($_POST['country']),COMMON_COUNTRY_IS_REQUIRED)?isEmpty(valid_input($_POST['country']),COMMON_COUNTRY_IS_REQUIRED):isNumeric(valid_input($_POST['country']),ERROR_ENTER_NUMERIC_VALUE);
	$err['areaCode']	 		= isEmpty(valid_input($_POST['sender_area_code']),COMMON_AREA_CODE_IS_REQUIRED)?isEmpty(valid_input($_POST['sender_area_code']),COMMON_AREA_CODE_IS_REQUIRED):areaCodePattern(valid_input($_POST['sender_area_code']),ERROR_AREA_CODE_INVALID,'1');
	$err['phone']	 			= isEmpty(valid_input($_POST['phone']),COMMON_PHONE_IS_REQUIRED)?isEmpty(valid_input($_POST['phone']),COMMON_PHONE_IS_REQUIRED):areaCodePattern(valid_input($_POST['phone']),ERROR_AREA_CODE_INVALID,'0');
	
	$err['securityQuesError_1']	= isEmpty(valid_input($_POST['security_ques_1']),COMMON_SECURITY_QUESTION_IS_REQUIRED)?isEmpty(valid_input($_POST['security_ques_1']),COMMON_SECURITY_QUESTION_IS_REQUIRED):isNumeric(valid_input($_POST['security_ques_1']),ERROR_ENTER_NUMERIC_VALUE);
	
	$err['securityAnsError_1']	= isEmpty(valid_input($_POST['security_ans_1']),COMMON_SECURITY_ANSWER_IS_REQUIRED)?isEmpty(valid_input($_POST['security_ans_1']),COMMON_SECURITY_ANSWER_IS_REQUIRED):chkStreet(valid_input($_POST['security_ans_1']));
	$err['securityQuesError_2']	= isEmpty(valid_input($_POST['security_ques_2']),COMMON_SECURITY_QUESTION_IS_REQUIRED)?isEmpty(valid_input($_POST['security_ques_2']),COMMON_SECURITY_QUESTION_IS_REQUIRED):isNumeric(valid_input($_POST['security_ques_2']),ERROR_ENTER_NUMERIC_VALUE);
	
	$err['securityAnsError_2']	= isEmpty(valid_input($_POST['security_ans_2']),COMMON_SECURITY_ANSWER_IS_REQUIRED)?isEmpty(valid_input($_POST['security_ans_2']),COMMON_SECURITY_ANSWER_IS_REQUIRED):chkStreet(valid_input($_POST['security_ans_2']));
	$err['terms_cond']	= isEmpty(valid_input($_POST['terms_cond']),TERMS_AND_CONDITION)?isEmpty(valid_input($_POST['terms_cond']),TERMS_AND_CONDITION):chkSmall(valid_input($_POST['terms_cond']));
	if($_POST['firstname']!="" && strlen($_POST['firstname'])<2)
	{
		$err['firstname'] = ENTER_CHARACTER;
	}
	if($_POST['lastname']!="" && strlen($_POST['lastname'])<2)
	{
		$err['lastname'] = ENTER_CHARACTER;
	}
	if($_POST['company_reg']!='')
	{
		$err['company_reg'] = checkName(valid_input($_POST['company_reg']));
	}
	if($_POST['changed_cntry']!="")
	{
		$err['changed_cntry'] = isNumeric(valid_input($_POST['changed_cntry']),ERROR_ENTER_NUMERIC_VALUE);
	}
	if($err['changed_cntry']!="")
	{
		logOut();
	}
	if($_POST['g-recaptcha-response'] == '')
	{
		$err['recaptcha']= MSG_CAPTCHA_IS_REQUIRED;
	}
	
	if(isset($_POST['g-recaptcha-response']))
	{
		$recaptcha = new \ReCaptcha\ReCaptcha($secret);
		//$resp = $recaptcha->verify($_POST['g-recaptcha-response'], $_SERVER['REMOTE_ADDR']);
		$resp = $recaptcha->verify($_POST['g-recaptcha-response'], $_SERVER['HTTP_X_FORWARDED_FOR']);
		if ($resp->isSuccess()){
			
		}else{
			$err['recaptcha']= MSG_ERROR_IN_CAPTCHA;
		}
	}
	if((valid_input($_POST['address1']))!="")
	{
		$err['address1'] = chkStreet(valid_input($_POST['address1']));
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
		$err['state'] = chkState(valid_input($_POST['state']));
	}
	if(valid_input($_POST['sender_mb_area_code'])!="")
	{
		$err['areaContactNo2'] = areaCodePattern(valid_input($_POST['sender_mb_area_code']),ERROR_AREA_CODE_INVALID,'1');
	}
	if(valid_input($_POST['mobile_phone'])!="")
	{
		$err['mobile_phone'] = areaCodePattern(valid_input($_POST['mobile_phone']),ERROR_AREA_CODE_INVALID,'0');
	}
	
	if( $err['Pass']=="")
	{
		$err['Pass'] = checkPassword($_POST['password']);
	}
	if($err['ConfPass']=="")
	{
		$err['ConfPass'] = checkPassword($_POST['confirmpassword']);
	}
	
	foreach($err as $key => $Value) {
  		if($Value != '') {
  			$Svalidation=true;
			$ptoken = $csrf->csrfkey();
  		}
	}
	
	
	$userSeaArr[] = array('Search_On'=>'email', 'Search_Value'=>valid_input($_POST['email']), 'Type'=>'string', 'Equation'=>'=', 'CondType'=>'AND', 'Prefix'=>'','Postfix'=>'');
	if ($UserMasterObj->getUser(null, $userSeaArr)) {
		$UserObj = $UserMasterObj->getUser(null, $userSeaArr);
		$siteobj = $UserObj[0];
		$err['EmailId'] =  COMMON_EMAIL_EXITS;
		$Svalidation=true;
		
		Send_Existing_User_Mail($siteobj);
		
		if(isset($_POST['submit_form']) && $_POST['submit_form']!='')
		{
			Send_Existing_User_Mail_To_Admin($_POST);
			//exit();
			
		}
		header('location:'.FILE_LOGIN);
	  	exit;
	}
		
		if ($Svalidation==false) {	
			
  			$UserData->firstname              = ucwords(valid_input(strtolower($_POST['firstname'])));
	  		$UserData->lastname     		  = ucwords(valid_input(strtolower($_POST['lastname'])));
	  		$UserData->company     		  = ucwords(valid_input(strtolower($_POST['company_reg'])));
	  		$UserData->email      		      = valid_input($_POST['email']);
			/* Two create a Hash you do */
			/*$bcrypt = new bcrypt(12);
			$UserData->password               = $bcrypt->genHash($_POST['password']);*/
			$UserData->password               = password_hash($_POST['password'],PASSWORD_DEFAULT);
			$UserData->suburb       		  = ucwords(valid_input(strtolower($_POST['suburb'])));
	  		$UserData->postcode      		  = valid_input($_POST['postcode']);
			if(isset($_POST['country']) && $_POST['country']==AUSTRALIA_ID)
			{
				$UserData->state  = strtoupper(valid_input($_POST['state']));
			}else{
				$UserData->state  = ucwords(strtolower(valid_input($_POST['state'])));
			}
	  		$UserData->state_code         		  = strtoupper(valid_input($_POST['register_state_code']));
	  		$UserData->country   = valid_input(ucwords(strtolower($_POST['country'])));
	  		$UserData->deleted         		  = '0';
	  		$UserData->sender_area_code       = valid_input($_POST['sender_area_code']);
			$UserData->phone_number           = valid_input($_POST['phone']);
			$UserData->sender_mb_area_code    = valid_input($_POST['sender_mb_area_code']);
			$UserData->mobile_no              = valid_input($_POST['mobile_phone']);
			$UserData->user_type_id           = 1;
	  		$UserData->corporate_id           = 0;
	  		$UserData->site_language_id       = SITE_LANGUAGE_ID;
	  		$UserData->last_login_date        = date('Y-m-d H:i:s');
	  		$UserData->login_attempt          = 0;
	  		$UserData->last_login_attempt_datetime        = date('Y-m-d H:i:s');
	  		$UserData->address1 = ucwords(strtolower(valid_input($_POST['address1'])));
	  		$UserData->address2               = ucwords(valid_input(strtolower($_POST['address2'])));
	  		$UserData->address3               = ucwords(valid_input(strtolower($_POST['address3'])));
			$UserData->security_ques_1          = ucwords(valid_input(strtolower($_POST['security_ques_1'])));	  		
			$UserData->security_ans_1           = ucwords(valid_input(strtolower($_POST['security_ans_1'])));
			$UserData->security_ques_2          = valid_input(ucwords(strtolower(($_POST['security_ques_2']))));	  		
			$UserData->security_ans_2           = valid_input(ucwords(strtolower($_POST['security_ans_2'])));	  		
			$UserData->ip_address             = $_SERVER['REMOTE_ADDR'];
			
			// to remove the already exiting session data
			unsetSession();
			
	  		if($UserMasterObj->addUser($UserData)) {
	  			//global $con;
				//$insertedUserId = mysqli_insert_id($con);
				$insertedUserId = $UserMasterObj->Connection->LastInsertedId();
	  			$UserData->userid = $insertedUserId;
	  			//create_user_session($UserData);
	  			

				$ObjAddress->user_id                 = $insertedUserId;
				$ObjAddress->account_no              = str_pad($insertedUserId, 7, '6700000', STR_PAD_LEFT);
		    	$ObjAddress->firstname               = ucwords(valid_input(strtolower($_POST['firstname'])));
		    	$ObjAddress->lastname                = ucwords(valid_input(strtolower($_POST['lastname'])));
		    	$ObjAddress->street_address          = ucwords(valid_input(strtolower($_POST['street_address'])));
		    	$ObjAddress->suburb                  = ucwords(valid_input(strtolower($_POST['suburb'])));
		   		$ObjAddress->postcode                = valid_input($_POST['postcode']);
		    	$ObjAddress->city                    = valid_input(ucwords(strtolower($_POST['city'])));
		   		
		   		$ObjAddress->state_code                   = strtoupper(valid_input($_POST['register_state_code']));
				if(isset($_POST['country']) && $_POST['country']==AUSTRALIA_ID)
				{
					$ObjAddress->state                   = strtoupper(valid_input($_POST['state']));
				}else{
					$ObjAddress->state                   = ucwords(strtolower(valid_input($_POST['state'])));
				}
		        $ObjAddress->country                 = valid_input(ucwords(strtolower($_POST['country'])));
		        $ObjAddress->sender_area_code        = valid_input($_POST['sender_area_code']);
				$ObjAddress->phone_number            = valid_input($_POST['phone']);
				$ObjAddress->default_address         = "1";
				$ObjAddress->from_signup             = "1";
           
				$ObjAddressMaster->addAddress($ObjAddress);
	  			
			
				//Send mail to 
				Send_New_User_Registration_Mail($UserData);
				if($PreviousUrl != '') {
	  				$location = $PreviousUrl;
					
				} else {
	  				$location = FILE_LOGIN;
					
				}
				header('Location:'.$location);
				//echo $location;
				exit();
				/*
				echo "<script src='".SITE_URL."/assets/js/jquery.min.js'></script><script type='text/javascript' src='".SITE_URL."assets/plugins/bootstrap/js/bootstrap.min.js'></script><script type='text/javascript'>
					$(document).ready(function(){
					$('#confirmBox').modal('show');
					$('#p').click(function(){
						
						window.location.href = '".SITE_URL."$location';

					})	
				})
				</script>";	
				
	  			*/
	  		}
  	}

}

/**
 *
 * Terms and Conditions modal pop up
 *
 */
function cmsPageContent($CmsPageName)
	{
		require_once(DIR_WS_MODEL."CmsPagesMaster.php");
		require_once(DIR_WS_CURRENT_LANGUAGE . "cms.php");
		$ObjCmsPagesMaster	= CmsPagesMaster::Create();
	
		$fieldArr = array("cms_pages.*, cms_pages_description.page_heading , cms_pages_description.page_content");
		$searchArr = array();
		$searchArr[] = " AND cms_pages_description.site_language_id = '".SITE_LANGUAGE_ID."'";
		$searchArr[] = " AND cms_pages.page_name = '".$CmsPageName."'";
		$searchArr[] = " OR cms_pages.page_name = '".$CmsPageName."'";
		$searchArr[] = " AND cms_pages.status='1'";
		$DataCmsMaster = $ObjCmsPagesMaster->getCmsPagesDetails($searchArr, $fieldArr);
		if(!empty($DataCmsMaster)) {
			$cmsData = $DataCmsMaster[0];
		}
		
		return $cmsData;
	}

//Include the File Function
require_once( DIR_WS_SITE_CURRENT_TEMPLATE . FILE_MAIN_INTERFACE);
?>
