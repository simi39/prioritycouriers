<?php 
	if(isset($__Session) && $__Session->HasValue("_sess_login_userdetails")) {
		$user_details = $__Session->GetValue("_sess_login_userdetails");
		
		define('SES_USER_ID', $user_details['user_id']);
		define('SES_USER_EMAIL', $user_details['email']);
		define('SES_USER_FIRSTNAME', $user_details['firstname']);
		define('SES_USER_LASTNAME', $user_details['lastname']);
		define('SES_USER_TYPE_ID', $user_details['user_type_id']);
		define('SES_USER_CORPORATE_ID', $user_details['corporate_id']);
		define('SES_USER_LANGUAGE_ID', $user_details['site_language_id']);
	}
	
	define("SEO_ENABLE",false);
	define("FRONT_NO_PAGES",5);
	define("FRONT_NO_RECORDS",8);
	define("ADMIN_NO_IMAGES_PER_PAGE", "8");
	define("ADMIN_NO_IMAGES_PER_ROW", "4");
	define("ADMIN_TEMPLATE_NO_IMAGES_PER_PAGE", "12");
	define("ADMIN_TEMPLATE_NO_IMAGES_PER_ROW", "3");
	define("ADMIN_NO_PAGE_LINKS", "5");

/******************* thumb image setting *****************************/
	define("MAX_SIZE_MOUNTAIN_LARGE_IMG",1024); //In Kilo Bytes "512000"

/******************* image gallery  *****************************/
	define("MAX_UPLOAD_SIZE", 20*1024*1024); //assign 2MB size in byts
	define("MAX_UPLOAD_SIZE_MB",10*1024*1024);//

//$Arr_extension = array("gif", "jpg", "jpeg", "tif", "tiff");
//define("ARR_FILE_EXTENSION", $Arr_extension); //assign 2MB size in byts
	//$quest_arr = array("1"=>"What was your childhood nickname?","2"=>"What is the name of your favorite childhood friend?","3"=>"What is your mother's maiden name?","4"=>"In what city or town was your first job?","5"=>"What is your boss's name?");
	$quest_arr_1 = array("1"=>"Mother's middle name?","2"=>"First street you grew up in?","3"=>"Favourite teacher's name?","4"=>"First company you worked for?","5"=>"First manager's name?");
	$quest_arr_2 = array("1"=>"What primary school did you attend?","2"=>"What are the last five digits of your driver's licence number?","3"=>"What is the last name of the teacher who gave you your first failing grade?","4"=>"In what town or city did you meet your spouse/partner?","5"=>"In what city or town does your nearest sibling live?");
	$payment_arr = array("master_card"=>"Master Card","visa"=>"Visa","american_express"=>"American Express");
	$anz_payment_response_arr = array("1"=>"<br /><br />Your payment was <span class='my_red'>NOT</span> successful. There was an undefined system error while processing your payment. Please try again.","2"=>"<br /><br />Your payment was <span class='my_red'>NOT</span> successful. The transaction was declined by the issuer. Please try again.","3"=>"<br /><br />Your payment was <span class='my_red'>NOT</span> successful. The issuer did not reply to the transaction request. This value frequently indicates a temporary system outage. Please try again later.","4"=>"<br /><br />Your payment was <span class='my_red'>NOT</span> successful. The card you used has expired. Please use different card.","5"=>"<br /><br />Your payment was <span class='my_red'>NOT</span> successful. The card you used has insufficient funds to cover the transaction. Please use different card","6"=>"<br /><br />Your payment was <span class='my_red'>NOT</span> successful. There was an error when communicating with Bank. Please try again.","7"=>"<br /><br />Your payment was <span class='my_red'>NOT</span> successful. There was a message detail error. Please try again.","8"=>"<br /><br />Your payment was <span class='my_red'>NOT</span> successful. Transaction was declined – transaction type is not supported. Please try again.","9"=>"<br /><br />Your payment was <span class='my_red'>NOT</span> successful. Bank declined the transaction – Do Not Contact Bank.");
	/*Payment gateway related settings*/
	$valid_country_arr = array("United States","Canada");
	
	define("THUMB_WIDTH",100);
	define("THUMB_HEIGHT",100);

	define("COLUMNS_PER_ROW", 4);			// No. of Products or Templates for each rows
	
	//This Constant is defined for header
	define('MSG_ADD_SUCCESS', 'as');
	define('MSG_EDIT_SUCCESS', 'es');
	define('MSG_EDIT_PRICE_SUCCESS', 'eps');
	define('MSG_DEL_SUCCESS', 'ds');
	define('MSG_MAIL_SUCCESS', 'ms');
	define('MSG_STATUS_SUCCESS', 'ss');
	define('MSG_DIS_HOME_SUCCESS', 'dhs');
	define('MSG_MOVE_SUCCESS', 'mus');
	define('MSG_RESTORE_SUCCESS', 'rus');
	define('LOGIN_TIME_PERIOD', 'INTERVAL 5 YEAR');
	define('LOGIN_IP_TIME_PERIOD', 'INTERVAL 30 MINUTE');
	define('FORGOTPASS_TIME_PERIOD', 'INTERVAL 15 MINUTE');
	define('FORGOTPASS_IP_TIME_PERIOD', 'INTERVAL 15 MINUTE');
	define('ATTEMPTS_NUMBER', '3');
	define('UNITED_STATE_ID', '235');
	define('AUSTRALIA_ID', '13');
	define('UNITED_STATE_NAME', 'United States');
	
	
	
	define("ALLOW_TAX_MANAGEMENT","Y");
/**
 * Start :: Get Data and Define Constant to make individual configuration for domains
 */
		require_once(DIR_WS_MODEL . "ConfigurationMaster.php");
	
		/** Object Site Domain Configuraton Master **/	
		$ObjConfigurationMaster = new ConfigurationMaster();	
		$ObjConfigurationMaster = $ObjConfigurationMaster->create();
		
		$DataSiteConfiguration = $ObjConfigurationMaster->getConfiguration();
		
		if($DataSiteConfiguration != '') {
			foreach ($DataSiteConfiguration as $ConfigurationValue) {
				if( empty($ConfigurationValue['set_value']) ) {
					define($ConfigurationValue['constant_name'], $ConfigurationValue['default_value']);
				} else {
					define($ConfigurationValue['constant_name'], $ConfigurationValue['set_value']);
				}
			}
		}
	//  End :: Get Data and Define Constant to make individual configuration for domains	

	
	
	
	
/* End set the item id for metro,interstate and international */
?>