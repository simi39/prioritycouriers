<?php
	/**
	 * This file is for forgot password user
	 *
	 *
	 * @author     Radixweb <team.radixweb@gmail.com>
	 * @copyright  Copyright (c) 2008, Radixweb
	 * @version    1.0
	 * @since      1.0
	 */

	/**
	 * include common file
	 */
	require_once("lib/common.php");
	require_once(DIR_WS_MODEL . "UserMaster.php");
	require_once(DIR_WS_RELATED."system_mail.php");     
	require_once(DIR_WS_CURRENT_LANGUAGE . "forgotpassword.php");
	require_once(DIR_WS_RECAPTCHA."autoload.php");
   
	/**
	 * array to include files
	 */
	$arr_css_plugin_include[] = 'glyphicons_new/css/glyphicons.css';
	$arr_css_plugin_include[] = 'waitMe/css/waitMe.min.css';
	
	$arr_javascript_include[] = 'internal/forgotpassword.php';
	$arr_javascript_plugin_include[] = 'waitMe/js/waitMe.min.js';
	/**
	 * create object
	 */

	$SiteUserObj        = UserMaster::Create();
	$SiteUserData       = new UserData();
	$PreferencesObj     = new  Preferences();
	
	
	$Svalidation        = false;
	
	/*csrf validation*/
	$csrf = new csrf();
	if($_POST['Submits'] == "")
	{
		$csrf->action = "forget_password";
		$ptoken = $csrf->csrfkey();
	}
	/*csrf validation*/

	/* Keys for recaptcha */
	$siteKey = '6LeuBwoTAAAAALmH5yxGYT_tE-G9kMtvKHl0rsmX';
	$secret = '6LeuBwoTAAAAAKOkON9SsUfxpHY81QIFn9wMpVRe';
	$lang = 'en';
	/* Keys for recaptcha */
	
	if(isset($_POST['btnlogin'])) {
		$auth_result = user_athuentication($_POST['email_signup'], $_POST['password_signup']);
		/*echo "<pre>";
		print_r($auth_result);
		echo "</pre>";
		exit();*/
		UnsetSession();
		if(empty($auth_result['error_email']) && empty($auth_result['error_password'])){
			show_page_header(FILE_FORGOT_PASSWORD, false);
			exit();
		}
	}
	//**************getting all data from site user*****************//
	
	/*	
	if(isset($_POST['Submits']) && $_POST['Submits'] =='Submit')
	{
	
		
		if(isEmpty(valid_input($_POST['ptoken']), true))
		{	
			logOut();
		}
		else
		{
			$csrf->checkcsrf($_POST['ptoken']);
		}
		
		
		/* for ip ban and email ban 
		if($_POST['emailid'] == COMMON_EMAIL_ID)
		{
			$err['email_id'] = MSG_EMAIL_ID_IS_REQUIRED;
			
		}else{
			$err['email_id'] = checkEmailPattern($_POST['emailid'], MSG_FORGOT_PASSWORD_EMAIL_INVALID);
		}
		if($_POST['g-recaptcha-response'] == '')
		{
			$err['recaptcha']= MSG_CAPTCHA_IS_REQUIRED;
		}
		
		if(isset($_POST['g-recaptcha-response']))
		{
			$recaptcha = new \ReCaptcha\ReCaptcha($secret);
			$resp = $recaptcha->verify($_POST['g-recaptcha-response'], $_SERVER['REMOTE_ADDR']);
			if ($resp->isSuccess()){
				
			}else{
				$err['recaptcha']= MSG_ERROR_IN_CAPTCHA;
			}
		}
		
		
		/* for ip ban and email ban 
		$clientip = $_SERVER['REMOTE_ADDR'];
		$result = checkForgotPassIPAddress($clientip); // check the ip address for ban
		//exit();
		if($result == 1)
		{
		  $err['EmailIdNotExist'] = COMMON_LOGIN_ATTEMPTS;
		}
		if(!empty($_POST['emailid']))
		{
			$result = checkForgotPassEmailIdAddress($_POST['emailid']);
		}
		
		if($result == 1)
		{
		  $err['EmailIdNotExist'] = COMMON_LOGIN_ATTEMPTS;
		}
		
		
		foreach($err as $key => $Value){
			
			if($Value != '') {
				$Svalidation=true;
				$csrf->action = "forget_password";
				$ptoken = $csrf->csrfkey();
			}
		}
		
		if($Svalidation == false)
		{
			/*
			$userSeaArr[] = array('Search_On'=>'email', 'Search_Value'=>$_POST['emailid'], 'Type'=>'string', 'Equation'=>'Like', 'CondType'=>'AND', 'Prefix'=>'','Postfix'=>'');
			$UserDetails = $SiteUserObj->getUser(null, $userSeaArr);
			$UserDetails = $UserDetails[0];
			
			if($UserDetails != ''){
				Forgot_Password($UserDetails);
			}else{ */
				/* for updating the attempts in login_attempts table*/
				/*$err['emailIdNotdb'] = MSG_EMAIL_NOT_EXITS;
				if(isset($err['emailIdNotdb']))
				{
					$csrf->action = "forget_password";
					$ptoken = $csrf->csrfkey();
				}
			}
			/* for updating the attempts in login_attempts table*/
			//addForgotPassIPAttempts($clientip);
			//addForgotPassEmailIdAttempts($_POST['emailid']);
			//$messagesuccess = FORGOTPASS_EMAIL_SENT_SUCCESS;
			//header('Location:'.FILE_INDEX);
			//exit();
			
		//}
	//}
	
	require_once( DIR_WS_SITE_CURRENT_TEMPLATE . FILE_MAIN_INTERFACE);
?>