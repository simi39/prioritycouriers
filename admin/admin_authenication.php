<?php
	$arr_notValidate = array(FILE_ADMIN_INDEX, FILE_ADMIN_FORGOTPASS);
	$AdminLoginArray = $__Session->GetValue("_Sess_Admin_Login");
	if(!empty($AdminLoginArray) && in_array(FILE_FILENAME_WITH_EXT, $arr_notValidate)) {
		header("Location:".SITE_ADMIN_URL.FILE_WELCOME_ADMIN);
		exit;
	}
	if(empty($AdminLoginArray) && !in_array(FILE_FILENAME_WITH_EXT, $arr_notValidate)) {
		header("Location:".SITE_ADMIN_URL.FILE_ADMIN_INDEX);
		exit;
	}
	define('ADMIN_USERNAME', ucfirst($AdminLoginArray['LoginName']));
	define('ADMIN_USERID', ucfirst($AdminLoginArray['Loginid']));
	define('ADMIN_SUPERADMIN', ucfirst($AdminLoginArray['SuperAdmin']));
?>