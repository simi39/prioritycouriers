<?php
require_once("../lib/common.php");
require_once(DIR_WS_MODEL ."BookingDetailsMaster.php");
require_once(DIR_WS_MODEL ."BookingItemDetailsMaster.php");
/*echo "<pre>";
print_r($_SESSION);
echo "</pre>";*/
$session_data = json_decode($_SESSION['Thesessiondata']['_sess_login_userdetails'],true);
$userid = $session_data['user_id'];
if(isset($_SESSION['Thesessiondata']['_Sess_Admin_Login']) && !empty($_SESSION['Thesessiondata']['_Sess_Admin_Login'])){
    $session_data = json_decode($_SESSION['Thesessiondata']['_Sess_Admin_Login'],true);
    $userid = $session_data['Loginid'];
}

$booking_id = $_GET['nr'];
/*echo "<pre>";
print_r($session_data);
echo "</pre>";
echo "is admin:".$userid;
exit();*/
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
if(isset($userid) && !empty($userid) && $userid == 1){

}else{
  $seaArr[] = array('Search_On'    => 'userid',
                      'Search_Value' => $userid,
                      'Type'         => 'int',
                      'Equation'     => '=',
                      'CondType'     => 'AND',
                      'Prefix'       => '',
                      'Postfix'      => '');

}
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
header('Content-Disposition: attachment; filename="completion_receipt.pdf"');
readfile(DIR_WS_ONLINEPDF."receipt/Completion_Receipt_PC".(int)$auto_id.".pdf");
?>