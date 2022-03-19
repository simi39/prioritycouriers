<?php
require_once("lib/common.php");
require_once("lib/bcrypt.php");
define("TITLE","Customer Details");
if(!defined('SES_USER_ID')) {
	show_page_header(FILE_SIGNUP);
}
require_once(DIR_WS_MODEL . "UserMaster.php");
require_once(DIR_WS_MODEL . "CountryMaster.php");
require_once(DIR_WS_MODEL ."PostCodeMaster.php");
require_once(DIR_WS_MODEL ."QuoteCustomerDetailsMaster.php");
define("TITLE","Quote Customer Details");

require_once(DIR_WS_CURRENT_LANGUAGE . "quote_customer_details.php");
$objCountryMaster = new CountryMaster();
$objCountryMaster = $objCountryMaster->Create();
$objCountryData=new CountryData();

$objQuoteCustomerMaster = new QuoteCustomerDetailsMaster();
$objQuoteCustomerMaster = $objQuoteCustomerMaster->Create();
$objQuoteCustomerDetailsData=new QuoteCustomerDetailsData();

$PostCodeMasterObj = new PostCodeMaster();
$PostCodeMasterObj = $PostCodeMasterObj->create();
$PostCodeDataObj = new PostCodeData();

$countryCode = $objCountryMaster->getCountry();

$arr_css_plugin_include[] = 'glyphicons_new/css/glyphicons.css';
$arr_css_plugin_include[] = 'datatables/css/jquery.dataTables.min.css';
$arr_css_plugin_include[] = 'datatables/extensions/Responsive/css/dataTables.responsive.css';
$arr_css_plugin_include[] = 'waitMe/css/waitMe.min.css';
$arr_javascript_include[] = 'internal/ajex.js'; 
$arr_javascript_include[] = 'internal/ajax-dynamic-list.js';
$arr_javascript_include[] = 'internal/quote-customer-details.php';

$arr_javascript_plugin_include[] ="back-to-top.js";
$arr_javascript_plugin_include[] = 'datatables/js/jquery.dataTables.min.js';
$arr_javascript_plugin_include[] = 'datatables/extensions/Responsive/js/dataTables.responsive.min.js';
$arr_javascript_plugin_include[] = 'datatables/extensions/Bootstrap-Integration/js/dataTables.bootstrap.js';
$arr_javascript_plugin_include[] = 'datatables/extensions/TableTools/js/dataTables.tableTools.min.js';
$arr_javascript_plugin_include[] = 'waitMe/js/waitMe.min.js';

if((isset($_POST['Save'])))
{
	
	/*exit();
*/
	$objQuoteCustomerDetailsData->first_name=ucwords(strtolower($_POST['firstname']));
	$objQuoteCustomerDetailsData->last_name =ucwords(strtolower($_POST['lastname']));
	$objQuoteCustomerDetailsData->company=ucwords(strtolower($_POST['company']));
	
	$objQuoteCustomerDetailsData->first_address=ucwords(strtolower($_POST['address1']));
	$objQuoteCustomerDetailsData->second_address=ucwords(strtolower($_POST['address2']));
	$objQuoteCustomerDetailsData->third_address=ucwords(strtolower($_POST['address3']));
	$objQuoteCustomerDetailsData->email_id=$_POST['email'];
	$objQuoteCustomerDetailsData->postcode = $_POST['postcode'];
	$objQuoteCustomerDetailsData->contact_phone=$_POST['contactNo'];
	$objQuoteCustomerDetailsData->phone_no=$_POST['mobileNo'];
	$objQuoteCustomerDetailsData->account_number =$_POST['account_number'];
	//if($_POST['mobile_phone']){
	//$objQuoteCustomerDetailsData->m_area_code = valid_input($_POST['sender_mb_area_code']);
	//$objQuoteCustomerDetailsData->mobileno=$_POST['mobile_phone'];
	//}
	$objQuoteCustomerDetailsData->suburb=ucwords(valid_input(strtolower($_POST['suburb'])));
	
	if(isset($_POST['country']) && $_POST['country']=="13")
	{
		$objQuoteCustomerDetailsData->state=strtoupper(valid_input($_POST['state']));
	}else{
		$objQuoteCustomerDetailsData->state=ucwords(strtolower(valid_input($_POST['state'])));
	}
	
	//$objQuoteCustomerDetailsData->countryid=$_POST['country'];
	$objQuoteCustomerDetailsData->country=ucwords(strtolower(trim($_POST['country_name'])));
		
	$insert=$objQuoteCustomerMaster->addQuoteCustomerDetails($objQuoteCustomerDetailsData);
	if($insert)		
	{
		$button_url = FILE_QUOTE_CUSTOMER_DETAILS."?msg='Address added successfully.'";
		header("Location:".$button_url);	
		exit();
	}
}


require_once( DIR_WS_SITE_CURRENT_TEMPLATE . FILE_MAIN_INTERFACE); /* This include once is used for the html integration */
?>