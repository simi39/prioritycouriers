<?php
/**
 * This file is changepassword for user
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
require_once("lib/functions.php");
require_once("lib/ft-nonce-lib.php");
require_once("lib/bcrypt.php");
if(!defined('SES_USER_ID')) {
	//show_page_header(FILE_SIGNUP);
}
require_once(DIR_WS_MODEL . "UserMaster.php");
require_once(DIR_WS_RELATED."system_mail.php");
require_once(DIR_WS_LIB . "bcrypt.php");
require_once(DIR_WS_MODEL . "NonceMaster.php");
require_once(DIR_WS_MODEL . "NonceData.php");
require_once(DIR_WS_CURRENT_LANGUAGE . "changepassword.php");
require_once(DIR_WS_MODEL . "ForgotPassEmailIdAddressMaster.php");
require_once(DIR_WS_MODEL . "ForgotPassIPAddressMaster.php");
require_once(DIR_WS_MODEL . "IPAddressMaster.php");

$arr_css_plugin_include[] = 'glyphicons_new/css/glyphicons.css';
$arr_javascript_below_include[] = 'internal/changepassword.php';
$NonceMasterObj = NonceMaster::Create();
$NonceData = new NonceData();

$ForgotPassEmailIdAddressMasterObj = new ForgotPassEmailIdAddressMaster();
$ForgotPassEmailIdAddressMasterObj = $ForgotPassEmailIdAddressMasterObj->Create();
$ForgotPassIPAddressMasterObj = new ForgotPassIPAddressMaster();
$ForgotPassIPAddressMasterObj = $ForgotPassIPAddressMasterObj->Create();
$IPAddressMasterObj = new IPAddressMaster();
$IPAddressMasterObj = $IPAddressMasterObj->Create();

/*csrf validation*/
$csrf = new csrf();
if($_POST['Submits'] == "" )
{
	$csrf->action = "user_changepassword";
	$ptoken = $csrf->csrfkey();
}

if(isset($_POST['ptoken'])) {
	$csrf->checkcsrf($_POST['ptoken']);
}
/*csrf validation*/


$hasurl = $_GET['hash'];
/*
Commented by Smita 11 Dec 2020
$sptfromurl = '$2y$12$';
$hasurl = $sptfromurl.$hasurl;*/

if(!empty($hasurl))
{
	$NonceFieldArr   = array("*");
	$NonceSeaArr = array();
	$NonceSeaArr[] = array('Search_On'=>'url', 'Search_Value'=>$hasurl, 'Type'=>'string', 'Equation'=>'=', 'CondType'=>'AND', 'Prefix'=>'','Postfix'=>'');
	$DataNonce  = $NonceMasterObj->getNonce($NonceFieldArr, $NonceSeaArr);
	$DataNonce 	= $DataNonce[0];
	$id = $DataNonce['user_id'];
	$time = $DataNonce['stamp'];
	$action = $DataNonce['action'];
	$nonce = $DataNonce['nonce'];
	$hasurlfromdb = $DataNonce['url'];
}

/* Commented by Smita 11 Dec 2020
$bcrypt = new bcrypt(12);
$url_error = $bcrypt->verify($nonce, $hasurl);
/* bcrypt validation */

 $cnonce = hash('sha512', makeRandomString());
 $data = $action." ".$id;
 $testHash = hash('sha512',$nonce . $cnonce . $data);
 $hash = hash('sha512', $nonce . $cnonce . $data);


 if(isset($DataNonce) && !empty($DataNonce) && isset($testHash) && isset($hash) && $testHash == $hash){

 	$url_error = TRUE;
 }else{
 	$url_error = FALSE;
 }

if(isset($url_error) && $url_error == FALSE)
{
	//show_page_header(FILE_INDEX.'?Add=Failure',false);
	header("Location:".SITE_INDEX.'?Add=Failure');
	exit();
}


/**
 * Object of AdminMaster
 *
 */
$ObjUserMaster = UserMaster::Create(); 
$UserData			= new UserData();
if(!empty($id))
{
	$userSeaArr = array();
	$userSeaArr[] = array('Search_On'=>'userid', 'Search_Value'=>trim($id), 'Type'=>'int', 'Equation'=>'=', 'CondType'=>'AND', 'Prefix'=>'','Postfix'=>'');
	$clientDetails = $ObjUserMaster->getUser(null,$userSeaArr);
	$clientDetails= $clientDetails[0];
	$user_id = $clientDetails['userid'];
	$email_id = $clientDetails['email'];
}


if(isset($nonce) && !isset($_POST['Submits']))
{
	
	if(ft_verify_onetime_nonce($hasurl,$nonce,$time,'chg_pass',$user_id))
	{
		$auth = "true";
		
	}else{
		//show_page_header(FILE_INDEX.'?Add=Failure',false);
		header("Location:".SITE_INDEX.'?Add=Failure');
		exit();
	}
}

//exit();
/**
 * Inclusion and Exclusion Array of Javascript
 */
//$arr_javascript_include[] = "user_action.php";

/**
 *Code for change password
 *
 */

if(isset($_POST['Submits']) && $_POST['Submits'] =='Submit' && $_POST['nonce_auth']== 'true') {
	/*
	if(isEmpty(valid_input($_POST['ptoken']), true))
	{	
		
		logOut();
	}
	else
	{
		$csrf->checkcsrf($_POST['ptoken']);
	}
	*/
	
	$UserOldPassword = trim($_POST['Curr_Pass']);
/** server side validation **/
	$Svalidation = false;
	//$err['OldPs']= isEmpty(trim($_POST['Curr_Pass']),COMMON_CURRENT_PASSWORD_IS_REQUIRED)?isEmpty(trim($_POST['Curr_Pass']),COMMON_CURRENT_PASSWORD_IS_REQUIRED):'';
    $err['ChangePs']= isEmpty(trim($_POST['Change_Pass']),COMMON_NEW_PASSWORD_IS_REQUIRED)?isEmpty(trim($_POST['Change_Pass']),COMMON_NEW_PASSWORD_IS_REQUIRED):'';
    $err['ConPs']= isEmpty(trim($_POST['Conf_Pass']),COMMON_CONFIRM_PASSWORD_IS_REQUIRED)?isEmpty(trim($_POST['Conf_Pass']),COMMON_CONFIRM_PASSWORD_IS_REQUIRED):'';
	if(!empty($_POST['Change_Pass'])){
		$err['ChangePs'] = checkPassword($_POST['Change_Pass']);
	}
	if(!empty($_POST['Conf_Pass'])){
		$err['ConPs'] = checkPassword($_POST['Conf_Pass']);
	}
	if(isset($_POST['Change_Pass']) && isset($_POST['Conf_Pass']))
	{
		if(strcmp($_POST['Change_Pass'],$_POST['Conf_Pass'])!=0)
		{
			$err['ConPs'] = CURRENT_AND_CONFIRM_PASSWORD_SAME;
			
		}
	}
	
	foreach($err as $key => $Value){
		if($Value != '') {
			$Svalidation=true;
			$csrf->action = "user_changepassword";
			$ptoken = $csrf->csrfkey();
		}
	}

	
   /**If Entered PassWord & Current Password are not same then change password else throw header **/
	if($Svalidation == false) {
				/** Method to  change password **/
				/*
				Commented By Smita 11 Dec 2020
				$bcrypt = new bcrypt(12);
				$UserData->password  = $bcrypt->genHash($_POST['Change_Pass']);*/
				$UserData->password = password_hash($_POST['Change_Pass'],PASSWORD_DEFAULT);		
				$UserData->userid = $id;
				$UserData->email = $email_id;
				
				// Array of editable fields
				$changeStatus = array("password","login_attempt","last_login_date","last_login_attempt_datetime");
				$UserData->login_attempt = 0;
				$UserData->last_login_attempt_datetime = '0000-00-00 00:00:00'; 
				$UserData->last_login_date = date('Y-m-d H:i:s'); 
				$ObjUserMaster->editUser($UserData, $changeStatus);
				
				/* */
				$ip = $_SERVER['REMOTE_ADDR'];
				$IPAddressMasterObj->deleteIPAddress($ip);
				$ForgotPassEmailIdAddressMasterObj->deleteForgotPassEmailIdAddress($email_id);
				$ForgotPassIPAddressMasterObj->deleteForgotPassIPAddress($ip);
				
				echo "<script src='".SITE_URL."/assets/js/jquery.min.js'></script><script type='text/javascript' src='".SITE_URL."assets/plugins/bootstrap/js/bootstrap.min.js'></script><script type='text/javascript'>
					$(document).ready(function(){
					$('#successBox').modal('show');
					$('#p').click(function(){
						
						window.location.href = '".SITE_URL."login.php';

					})	
				})
				</script>";
				
				//show_page_header(FILE_INDEX.'?Add=Success',false);
				//exit();
			}
	
}
require_once( DIR_WS_SITE_CURRENT_TEMPLATE . FILE_MAIN_INTERFACE);
?>
