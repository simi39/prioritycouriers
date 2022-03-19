<?php
session_start();
require_once("lib/common.php");
require_once(DIR_WS_CURRENT_LANGUAGE . "login.php");
/**
 * Inclusion and Exclusion CSS
 */
$arr_css_plugin_include[] = 'glyphicons_new/css/glyphicons.css';
/**
 * Inclusion and Exclusion Array of Javascript
 */
$arr_javascript_include[] = 'internal/login.php';

if(isset($_GET['action']) && $_GET['action'] == 'logout') {
	logOut();
}

$csrf = new csrf();
$csrf->action = "login";

if($_POST['btnlogin']=="")
{	
	
	/*csrf validation*/
	$ptoken = $csrf->csrfkey();
	/*csrf validation*/
}

if(isset($_POST['registerBtn']) && !empty($_POST['registerBtn'])){
	show_page_header(FILE_SIGNUP, true);
}
if(isset($_POST['btnlogin'])) {
	
	$auth_result = user_athuentication(valid_input($_POST['email_signup']), valid_input($_POST['password_signup']));
	/*below lines are commented because when logged in 
		* through login button in services pages session values are getting 
		* deleted for booking values coming from get quote(Start)
		* Commented by Smita 4th Jan 2021
		*/
	//UnsetSession();
	/*
		End part
	*/
	if(empty($auth_result['error_email']) && empty($auth_result['error_password'])){
		show_page_header(FILE_BOOKING, true);
	}else{
		/*csrf validation*/

		$ptoken = $csrf->csrfkey();
		
		/*csrf validation*/
	}
}

require_once( DIR_WS_SITE_CURRENT_TEMPLATE . FILE_MAIN_INTERFACE);
?>