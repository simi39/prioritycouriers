<?php
session_start();
require_once("../lib/common.php");
require_once(DIR_WS_MODEL . "UserMaster.php");
require_once(DIR_WS_RELATED."system_mail.php");
require_once(DIR_WS_CURRENT_LANGUAGE . "forgotpassword.php");

/**
 * create object
 */

$SiteUserObj        = UserMaster::Create();
$SiteUserData       = new UserData();

$emailid = $_POST['emailid'];
$ptoken = $_POST['ptoken'];

$csrf = new csrf();

/* for ip ban and email ban */
//$clientip = $_SERVER['REMOTE_ADDR'];
$clientip = $_SERVER['HTTP_X_FORWARDED_FOR'];
$result = checkForgotPassIPAddress($clientip); // check the ip address for ban
$err = array();
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
if(empty($_POST['emailid']) || $_POST['emailid'] == COMMON_EMAIL_ID)
{
	$err['email_id'] = MSG_EMAIL_ID_IS_REQUIRED;
	
}else{
	$err['email_id'] = checkEmailPattern($_POST['emailid'], MSG_FORGOT_PASSWORD_EMAIL_INVALID);
}

if(isset($err))
{
foreach($err as $key => $Value){
	
	if($Value != '') {
		$Svalidation=true;
	}
}
}

if(isset($_POST['emailid']) && $_POST['emailid']!=""){
	
	if(isEmpty(valid_input($_POST['ptoken']), true))
	{	
		logOut();
	}
	else
	{
		$token = $csrf->checkcsrf($_POST['ptoken']);
		
	}

if($Svalidation == false)
{
	
	$userSeaArr[] = array('Search_On'=>'email', 'Search_Value'=>$_POST['emailid'], 'Type'=>'string', 'Equation'=>'Like', 'CondType'=>'AND', 'Prefix'=>'','Postfix'=>'');
	$UserDetails = $SiteUserObj->getUser(null, $userSeaArr);
	$UserDetails = $UserDetails[0];
	/*echo "<pre>";
	print_r($UserDetails);
	echo "</pre>";
	exit();*/
	if($UserDetails != ''){
		Forgot_Password($UserDetails);
	}else{
		/* for updating the attempts in login_attempts table*/
		$err['emailIdNotdb'] = MSG_EMAIL_NOT_EXITS;
		
	}
	/* for updating the attempts in login_attempts table*/
	addForgotPassIPAttempts($clientip);
	addForgotPassEmailIdAttempts($_POST['emailid']);
	$messagesuccess = FORGOTPASS_EMAIL_SENT_SUCCESS;
	if(isset($err['emailIdNotdb']))
	{
		echo json_encode($err);
		exit();
	}
	echo json_encode('1');
}else{
	echo json_encode($err);
	exit();
	}
}else{
	echo json_encode($err);
	exit();
}
exit();
?>