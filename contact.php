<?php
/**
 * This is index file
 *
 *
 * @author     Radixweb <team.radixweb@gmail.com>
 * @copyright  Copyright (c) 2008, Radixweb
 * @version    1.0
 * @since      1.0
 */
require_once("lib/common.php");
require_once(DIR_WS_MODEL."CmsPagesMaster.php");
require_once(DIR_WS_CURRENT_LANGUAGE . "cms.php");
require_once(DIR_WS_CURRENT_LANGUAGE . "contact.php");
require_once(DIR_WS_RECAPTCHA."autoload.php");

$arr_javascript_below_include[] = 'internal/tracking.php';
$arr_css_plugin_include[] = 'flexslider/flexslider.css"  media="screen';
$arr_css_plugin_include[] = 'glyphicons_new/css/glyphicons.css';

$arr_javascript_plugin_include[] = 'flexslider/jquery.flexslider-min.js';
//$arr_javascript_plugin_below_include[] = 'gmap/gmaps.js';
$arr_javascript_below_include[] = 'internal/contact.php';


$Svalidation = false;
/*csrf validation*/
$csrf = new csrf();
if(isset($__Session))
{
	$session_data = $__Session->GetValue("_sess_login_userdetails");
	$userid = valid_output($session_data['user_id']);
	$useremailid = valid_output($session_data['email']);
	
	$fullname = valid_output($session_data['firstname'])." ".valid_output($session_data['lastname']);
}

if(!isset($_POST['ptoken'])) {
	$csrf->action = "contact_us";
	$ptoken = $csrf->csrfkey();
}

/*csrf validation*/
if(isset($_POST['btnlogin'])) {
	if(isEmpty(valid_input($_POST['ptoken']), true))
	{	
		logOut();
	}
	else
	{
		$csrf->checkcsrf($_POST['ptoken']);
	}
	$auth_result = user_athuentication($_POST['email_signup'], $_POST['password_signup']);
	UnsetSession();
	if(empty($auth_result['error_email']) && empty($auth_result['error_password'])){
		show_page_header(FILE_GET_QUOTE, false);
		exit();
	}
}
$ObjCmsPagesMaster	= CmsPagesMaster::Create();
if(empty($CmsPageName)) {
	$CmsPageName = 'contact_us';
	$file = str_replace('../', '', $CmsPageName);/*if some page path is included validation for that is applied*/
	
	if(!isset($file))
	{
		$error =true;
	}
	$error = chkPages($CmsPageName);/*only small,capital and underscore is applied */
	
	if(isset($error))
	{
		//show_page_header(FILE_INDEX, false);
		header("Location:".SITE_INDEX);
		exit();
	}
}
	$fieldArr = array("cms_pages.*, cms_pages_description.page_heading , cms_pages_description.page_content");
	$searchArr = array();
	$searchArr[] = " AND cms_pages_description.site_language_id = '".SITE_LANGUAGE_ID."'";
	$searchArr[] = " AND cms_pages.page_name = '".$CmsPageName ."'";
	$searchArr[] = " OR cms_pages.page_name = '".$CmsPageName ."'";
	$searchArr[] = " AND cms_pages.status='1'";
	$DataCmsMaster = $ObjCmsPagesMaster->getCmsPagesDetails($searchArr, $fieldArr);
	//This condition added by shailesh jamanapara on date Sat Jun 08 11:59:26 IST 2013
	if($CmsPageName == "services"){
		require_once(DIR_WS_MODEL . "ServiceMaster.php");
		require_once(DIR_WS_ADMIN_LANGUAGES . DIR_CURRENT_LANGUAGE. '/service.php');
		require_once(DIR_WS_MODEL . "SupplierMaster.php");
		//require_once( DIR_WS_SITE_CURRENT_TEMPLATE . "css/services.php");
		$ObjServiceMaster	= ServiceMaster::Create();
		$ServiceData		= new ServiceData();
		$fieldArr=array("*");
		$seaByArr=array();
		$seaByArr[]=array('Search_On'=>'status', 'Search_Value'=>'1', 'Type'=>'string', 'Equation'=>'=', 'CondType'=>'', 'Prefix'=>'and', 'Postfix'=>'');
		$servicesData = $ObjServiceMaster->getService($fieldArr,$seaByArr);
	}
	
	
	if(!empty($DataCmsMaster)) {
		$cmsData = $DataCmsMaster[0];
	} else {
		header("Location:".SITE_INDEX);
		exit();
	}
	
	define("TITLE",$cmsData['page_heading']);
if($_POST['Submit'] != '')
{
	$err['Submit'] = checkStr(valid_input($_POST['Submit']));
}

if(!empty($err['Submit']))
{
	logOut();
}
if($_GET['message']!='')
{
	$err['msg'] = specialcharaChk($_GET['message']);
}
if(!empty($err['msg']))
{
	logOut();
}
if(isset($_GET['message']) && $_GET['message'] =='success' && $cmsData['page_name'] == 'contact_us') {
	$successMsg = CONTACTUS_ENQUIRY_SENT_SUCCESS;
}else if (isset($_GET['message']) && $_GET['message'] =='success'){
	$successMsg = TELLAFRIEND_MESSAGE_SENT_SUCCESS;
}
$secret = '6LeuBwoTAAAAAKOkON9SsUfxpHY81QIFn9wMpVRe';
if(isset($_POST['Submit']) && $_POST['Submit'] == 'Send Message')
{
		if(isEmpty(valid_input($_POST['ptoken']), true))
		{	
			logOut();
		}
		else
		{
			$csrf->checkcsrf($_POST['ptoken']);
		}
		if(isset($userid) && $userid!="")
		{
			$fullname = $fullname;
			$useremail = $useremailid;
			
		}else{
			$fullname = $_POST['fullname'];
			$useremail = $_POST['clientemail'];
			/*
			if(empty($_SESSION['6_letters_code'] ) || strcasecmp($_SESSION['6_letters_code'], $_POST['6_letters_code']) != 0)
			{
				
				$err['captcha'] = CONTACTUS_CAPTCHA_ERROR;
			}
			*/
		
		}
		$err['fullname']	= isEmpty(valid_input($fullname),COMMON_FULLNAME_IS_REQUIRED)?isEmpty(valid_input($fullname),COMMON_FULLNAME_IS_REQUIRED):checkName(valid_input($fullname));
		$err['emailerror']	= isEmpty(valid_input($useremail),ERROR_EMAIL_ID_IS_REQUIRED)?isEmpty(valid_input($useremail),ERROR_EMAIL_ID_IS_REQUIRED):checkEmailPattern(valid_input($useremail),ERROR_EMAIL_ID_INVALID);
		$err['enquiry']		= isEmpty(valid_input($_POST['enquiry']),COMMON_MESSAGE_IS_REQUIRED)?isEmpty(valid_input($_POST['enquiry']),COMMON_MESSAGE_IS_REQUIRED):checkStr(valid_input($_POST['enquiry']));
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
		
		foreach($err as $key => $Value){
			if($Value != '') {
				$Svalidation=true;
				$ptoken = $csrf->csrfkey();
			}
		}		
		
		if($Svalidation == false) {
			require_once(DIR_WS_RELATED."system_mail.php");
			
			$test = Enquiry_Mail_Client($fullname,$useremail);
			
			Enquiry_Mail($fullname,$userid,$useremail,ucwords(strtolower($_POST['enquiry'])));
			echo "<script src='".SITE_URL."/assets/js/jquery.min.js'></script><script type='text/javascript' src='".SITE_URL."assets/plugins/bootstrap/js/bootstrap.min.js'></script><script type='text/javascript'>
				$(document).ready(function(){ 
					$('#Contact').modal('show');
					$('#Contact').on('hidden.bs.modal', function (e) {
						var url = '".SITE_URL.FILE_CONTACT."';    
						$(location).attr('href',url);
					});
				});
				</script>";
			//exit();
		}
	}

//exit();
	// Variable Declaration
	if($_GET['message'] == 'success') {
		$successMsg = CONTACTUS_ENQUIRY_SENT_SUCCESS;
	}
require_once( DIR_WS_SITE_CURRENT_TEMPLATE . FILE_MAIN_INTERFACE);
?>
