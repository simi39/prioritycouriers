<?php
/**
	 * Admin Management
	 * administrator.php
 */
define("ADMIN_ADMINISTRATOR_ADD_NEW_ADMIN","Add Admin");  
define("ADMIN_LABEL_USERNAME","Username");  
define("ADMIN_COMMON_LABEL_PASSWORD","Password");

define("ADMIN_SEARCH_LABEL_USERNAME","Search Username");
define("ADMIN_SEARCH_COMMON_EMAIL","Search Email");
define("ERROR_ALPHABETS_ONLY","Only alphabets are allowed.");
define("TITLE","Admin Listing");
define("ACTION","Action");
define("ADMIN_CURRPASSWORD_IS_REQUIRED","Current Password is required.");
define("ADMIN_NEWPASSWORD_IS_REQUIRED","New Password is required.");
define("ADMIN_NEW_AND_CURRENT_PASSWORD_BE_DIFFERENT","Current and New Password should be different.");
define("ADMIN_CONFIRM_PASSWORD_IS_REQUIRED","Confirm Password is required.");
define("ADMIN_CURRENT_AND_CONFIRM_PASSWORD_SAME","Current Password and Confirm Password must be same.");
/**
* Admin Management
* addadmin.php
*/

define("ADMIN_ADD_HEADING","Add Admin");
define("ADMIN_EDIT_HEADING","Edit Admin");
define("ADMIN_ADD_BUTTON","Save Admin");  
define("ADMIN_EDIT_BUTTON","Update Admin");  
define("ADMIN_CONFIRM_PASSWORD","Confirm Password");
define("COMMON_SECURITY_ANSWER_ALPHANUMERIC","Only Alphanumeric characters are allowed.");
	

define('ADMIN_ERROR_NAME_REQUIRED', 'Username is required');//JAVASCRIPT VALIDATION
define('ADMIN_ERROR_NAME_EXISTS', 'Username Already Exists');//JAVASCRIPT VALIDATION
define('ADMIN_ERROR_EMAIL_REQUIRED', 'E-mail Id is required');//JAVASCRIPT VALIDATION
define('ADMIN_ERROR_EMAIL_INVALID', 'Invalid E-mail Id');//JAVASCRIPT VALIDATION
define('ADMIN_ERROR_PASSWORD_REQUIRED', 'Password is required');//JAVASCRIPT VALIDATION
define('ADMIN_ERROR_CONFIRM_PASSWORD_REQUIRED', 'Confirm Password is required');//JAVASCRIPT MESSAGE DISPLAY
define('ADMIN_ERROR_PWD_AND_CONFIRM_PWD_DIFF', 'Password and Confirm Password does not match');//JAVASCRIPT MESSAGE DISPLAY
define("ADMIN_UPLOAD_CSV","Upload Multiple Admin Details :");
define("ADMIN_UPLOAD","Upload File");
define("ADMIN_USERS_PERSONAL_DETAILS","Admin  Details :");
define("ADMIN_EXPORT_NEW","Export Admin Details");
define("COMMON_LOGIN_ATTEMPTS","That's it. Game over.");

$arr_message = array (
	'MSG_ADD_SUCCESS' => 'Administrator has been added successfully',
	'MSG_EDIT_SUCCESS' => 'Administrator details has been updated successfully',
	'MSG_DEL_SUCCESS' => 'Administrator details has been deleted successfully',
	'SELECT_UPLOAD_CSV_FILE' => "Please Select the csv file.",
	'ERROR_CSV_FILE_FORMAT' =>  'The data of the csv is not match with the database field.Please select the valid csv.',
	'ERROR_ALREADY_CSV_FILE_AVAILABLE' => 'The data of the csv is already exist.',
);

?>
