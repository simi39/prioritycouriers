<?php
session_start();
require_once("lib/common.php");
require_once(DIR_WS_CURRENT_LANGUAGE . "view-booking.php");
require_once(DIR_WS_MODEL . "BookingDetailsMaster.php");
require_once(DIR_WS_MODEL ."BookingItemDetailsMaster.php");

$ObjBookingDetailsMaster	= new BookingDetailsMaster();
$ObjBookingDetailsMaster	= $ObjBookingDetailsMaster->Create();
$BookingDetailsData		= new BookingDetailsData();

$ObjBookingItemDetailsMaster	= new BookingItemDetailsMaster();
$BookingItemDetailsData		= new BookingItemDetailsData();

$connateNumber = $_REQUEST['cn'];

//$seaArrforBookingDetails[]	= array();
//$seaArrforBookingDetails[]	= array('Search_On'=>'CCConnote','Search_Value'=>"$connateNumber",'Type'=>'string','Equation'=>'==','CondType'=>'AND','Prefix'=>'','Postfix'=>'');
/*$seaArrforBookingDetails[]=array('Search_On'=>'CCConnote', 'Search_Value'=>"$connateNumber", 'Type'=>'string', 'Equation'=>'=', 'CondType'=>'and', 'Prefix'=>'', 'Postfix'=>'');
$BookingDetails = $ObjBookingDetailsMaster->getBookingDetails($fieldArr=null, $seaArrforBookingDetails);
*/
$session_data = json_decode($_SESSION['Thesessiondata']['_sess_login_userdetails'],true);
$userid = $session_data['user_id'];
//echo $userid."--".$connateNumber;
/*exit();*/
$seaByArr[]=array('Search_On'=>'CCConnote', 'Search_Value'=>"$connateNumber", 'Type'=>'int', 'Equation'=>'=', 'CondType'=>'and', 'Prefix'=>'', 'Postfix'=>'');
$seaByArr[]=array('Search_On'=>'userid', 'Search_Value'=>"$userid", 'Type'=>'int', 'Equation'=>'=', 'CondType'=>'and', 'Prefix'=>'', 'Postfix'=>'');
$BookingDetails=$ObjBookingDetailsMaster->getBookingDetails($fieldArr,$seaByArr); // Fetch Data
$BookingDetail = $BookingDetails[0];
/*echo "<pre>";
print_r($BookingDetail);
echo "</pre>";
exit();*/
if(empty($BookingDetail)) {
    header("Location:".FILE_BOOKING_RECORDS);
	exit();
}
//echo $BookingDetail['webservice'];

$fieldArr=array("*");
$seaByArr = array();
$seaByArr[]=array('Search_On'=>'CCConnote', 'Search_Value'=>"$connateNumber", 'Type'=>'int', 'Equation'=>'LIKE', 'CondType'=>'and', 'Prefix'=>'', 'Postfix'=>'');
$BookingItemDetailsData=$ObjBookingItemDetailsMaster->getBookingItemDetails($fieldArr, $seaByArr); // Fetch Data

require_once( DIR_WS_SITE_CURRENT_TEMPLATE . FILE_MAIN_INTERFACE);
?>