<?php
require_once("lib/common.php");
require_once("lib/bcrypt.php");
define("TITLE","Make Customer Quote Details");

if(!defined('SES_USER_ID')) {
	show_page_header(FILE_SIGNUP);
}

require_once(DIR_WS_MODEL . "UserMaster.php");
require_once(DIR_WS_MODEL ."QuoteCustomerDetailsMaster.php");
require_once(DIR_WS_CURRENT_LANGUAGE . "make_customer_quote.php");



$objQuoteCustomerMaster = new QuoteCustomerDetailsMaster();
$objQuoteCustomerMaster = $objQuoteCustomerMaster->Create();
$objQuoteCustomerDetailsData=new QuoteCustomerDetailsData();
$objQuoteCustomerData = $objQuoteCustomerMaster->getQuoteCustomerDetailsAddress();

/*$PostCodeMasterObj = new PostCodeMaster();
$PostCodeMasterObj = $PostCodeMasterObj->create();
$PostCodeDataObj = new PostCodeData();

$countryCode = $objCountryMaster->getCountry();
*/

$arr_css_plugin_include[] = 'bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css';
$arr_css_plugin_include[] = 'glyphicons_new/css/glyphicons.css';


$arr_javascript_plugin_include[] = 'moment/js/moment-with-locales.min.js';
$arr_javascript_plugin_include[] = 'moment/js/moment-timezone.min.js';
$arr_javascript_plugin_include[] = 'bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js';
$arr_javascript_below_include[]  = 'internal/make-customer-quote.php';


require_once( DIR_WS_SITE_CURRENT_TEMPLATE . FILE_MAIN_INTERFACE);
?>