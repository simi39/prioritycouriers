<?php
require_once("lib/common.php");
require_once(DIR_WS_MODEL ."BookingDetailsMaster.php");
require_once(DIR_WS_CURRENT_LANGUAGE . "booking-successful.php");
//require_once(DIR_WS_PDF.'dompdf/dompdf_config.inc.php');
require_once(DIR_WS_MODEL ."CountryMaster.php");
require_once(DIR_WS_RELATED.'/vendor/autoload.php');

$BookingDetailsMasterObj = BookingDetailsMaster::create();
$BookingDetailsDataObj = new BookingDetailsData();

$CountryMasterObj = CountryMaster::create();
$CountryDataObj = new CountryData();
//$arr_css_include[] = 'print.css';
$trackingid=$_GET['booking_id'];
//$bookingid='97Q0986H339293';

use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\SandboxEnvironment;
use PayPalCheckoutSdk\Orders\OrdersCreateRequest;
use PayPalCheckoutSdk\Orders\OrdersCaptureRequest;
use PayPalCheckoutSdk\Orders\OrdersGetRequest;

// Creating an environment
$clientId = "AUTyokDQ0aw42p39EYZuWBKNuFtKuuGbwSnqc1vS415LkPUdz0u2hf1IGx7dUaohCEAgV_jL_O4zZ8F_";
$clientSecret = "ECY3QiMtlipz2zzcOSXB4tP53M4P6_wqzpYpuRJCF-ZWcrouP6GE2D7R_4G5RddGF41RLsBQMYUHXYY4";


$environment = new SandboxEnvironment($clientId, $clientSecret);
$client = new PayPalHttpClient($environment);

if(isset($__Session))
{
	$session_data = $__Session->GetValue("_sess_login_userdetails");
	$userid = valid_output($session_data['user_id']);
}
$countries_name = 'Australia';
if(isset($trackingid) && $trackingid != "")
{
	$fieldArr=array("*");
	/*$BookingSearchDetailArray[] = array('Search_On'=>'CCConnote', 'Search_Value'=>$trackingid, 'Type'=>'int', 'Equation'=>'=', 'CondType'=>'AND', 'Prefix'=>'', 'Postfix'=>'');	*/
	$BookingSearchDetailArray[] = array('Search_On'=>'booking_id', 'Search_Value'=>$trackingid, 'Type'=>'int', 'Equation'=>'=', 'CondType'=>'AND', 'Prefix'=>'', 'Postfix'=>'');
	$BookingDetailsData = $BookingDetailsMasterObj->getBookingDetails($fieldArr,$BookingSearchDetailArray);
	$BookingDetailsDataVal = $BookingDetailsData[0];
	$total_display_rate=$BookingDetailsDataVal['rate'];
	$deliverid = $BookingDetailsDataVal['deliveryid'];
	$transid = $BookingDetailsDataVal['transaction_id'];
	$orderId = $transid;
	/*$orderId = '6TY15314X03120107';
	$request = new OrdersGetRequest($orderId);

	$response = $client->execute($request);
	echo "<pre>";
	print_r($response);
	echo "</pre>";*/
	if(is_numeric($deliverid))
	{
		$seabycountryArr[0] = array('Search_On'    => 'countries_id',
		'Search_Value' => $deliverid,
		'Type'         => 'int',
		'Equation'     => '=',
		'CondType'     => 'and ',
		'Prefix'       => '',
		'Postfix'      => '');
		$fieldArrforCountryName = array("countries_name","countries_iso_code_2","area_code");
		$CountryDataObj = $CountryMasterObj->getCountry($fieldArrforCountryName,$seabycountryArr);
		$CountryDataObj = $CountryDataObj[0];
		$receiver_contry_code = $CountryDataObj['countries_iso_code_2'];
		$countries_name= (isset($_SESSION['international_country_name']) && $_SESSION['international_country_name']!="")?($_SESSION['international_country_name']):($CountryDataObj['countries_name']);
	}

}
/* */
unset($_SESSION['final_fuel_fee']);
unset($_SESSION['nett_due_amt']);
unset($_SESSION['total_new_charges']);
unset($_SESSION['total_due']);
unset($_SESSION['discountAmt']);
unset($_SESSION['couponCode']);
unset($_SESSION['total_gst']);
unset($_SESSION['total_tansit_gst']);
unset($_SESSION['total_gst_delivery']);
unset($_SESSION['total_delivery_fee']);
unset($_SESSION['set_del_addressbook']);
unset($_SESSION['set_pkp_addressbook']);
unset($_SESSION['chk_pk_address']);
unset($_SESSION['chk_del_address']);
unset($_SESSION['terms']);
unset($_SESSION['dangerousgoods']);
unset($_SESSION['securitystatement']);
/* */

$__Session->ClearValue("booking_details");
$__Session->ClearValue("service_details");
$__Session->ClearValue("booking_details_items");
$__Session->ClearValue("booking_id");
$__Session->ClearValue("auto_id");
$__Session->ClearValue("invoice_id");
$__Session->ClearValue("client_address_dilivery");
$__Session->ClearValue("client_address_pickup");
$__Session->ClearValue("commercial_invoice_id");
$__Session->ClearValue("commercial_invoice");
$__Session->ClearValue("commercial_invoice_item");
$__Session->Store();
$csrf = new csrf();
$csrf->logout();
/*
if($userid == '')
{
	unSetCookie();
} */
require_once( DIR_WS_SITE_CURRENT_TEMPLATE . FILE_MAIN_INTERFACE); /* This include once is used for the html integration */
?>
