<?php
require_once("../lib/common.php");
require_once(DIR_WS_MODEL ."BookingDetailsMaster.php");
require_once(DIR_WS_MODEL ."BookingItemDetailsMaster.php");

$session_data = json_decode($_SESSION['Thesessiondata']['_sess_login_userdetails'],true);
$userid = $session_data['user_id'];
$booking_id = $_GET['nr'];
/*
if(isset($_GET['nr']) && $_GET['nr']!='')
{
	$err['nr'] = isNumeric(valid_input($_GET['nr']),ERROR_ENTER_NUMERIC_VALUE);
}
if(!empty($err['nr']))
{
	logOut();
}
*/
$BookingDetailsMasterObj = BookingDetailsMaster::create();
$BookingDetailsDataObj = new BookingDetailsData();

$BookingItemDetailsMasterObj = BookingItemDetailsMaster::create();
$BookingItemDetailsDataObj = new BookingItemDetailsData();

$seaArr[] = array('Search_On'    => 'userid',
                      'Search_Value' => $userid,
                      'Type'         => 'int',
                      'Equation'     => '=',
                      'CondType'     => 'AND',
                      'Prefix'       => '',
                      'Postfix'      => '');
$seaArr[] = array('Search_On'    => 'booking_id',
                      'Search_Value' => $booking_id,
                      'Type'         => 'int',
                      'Equation'     => '=',
                      'CondType'     => 'AND',
                      'Prefix'       => '',
                      'Postfix'      => ''); 					  

$BookingDetailsData=$BookingDetailsMasterObj->getBookingDetails('null',$seaArr);
$BookingDetailsData=$BookingDetailsData[0];
$booking_id = $BookingDetailsData['booking_id'];
$auto_id = $BookingDetailsData['auto_id'];
if(empty($booking_id))
{
	logOut();
	exit();
}

header('Content-type: application/pdf');
header('Content-Disposition: attachment; filename="commercial_invoice.pdf"');
readfile(DIR_WS_ONLINEPDF.'commercial_invoice/Commercial_Invoice_'.$booking_id.'.pdf');
?>