<?php
require_once("../lib/common.php");
require_once(DIR_WS_MODEL ."BookingDetailsMaster.php");
require_once(DIR_WS_MODEL ."BookingItemDetailsMaster.php");

$session_data = json_decode($_SESSION['Thesessiondata']['_sess_login_userdetails'],true);
$userid = $session_data['user_id'];
$booking_id = $_GET['nr'];
$labelType = $_GET['label'];
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
$pagename = $BookingDetailsData['servicepagename'];
$servicename = $BookingDetailsData['service_name'];
$booking_id = $BookingDetailsData['booking_id'];
//echo $filepath;
    //exit();
if(empty($booking_id))
{
    logOut();
    exit();
}
$CCConnote = $BookingDetailsData['CCConnote'];
//echo "connate number:".$CCConnote."</br>";
if(isset($labelType) && $labelType == "consignment"){

    //$label_name = ucfirst($pagename)."_Consignment_".ucfirst($servicename)."_".$booking_id.".pdf";
    $label_name = "ConsignmentNote"."_".$booking_id.".pdf";
    if(isset($pagename) && $pagename=="overnight")
    {
        $filepath = DIR_WS_ONLINEPDF."StarTrack/consignment/".$label_name;
    }elseif(isset($pagename) && $pagename=="sameday"){
        $filepath = DIR_WS_ONLINEPDF."DirectCourier/consignment/".$label_name;
    }else{
        $filepath = DIR_WS_ONLINEPDF."UPS/consignment/".$label_name;
    }


    

    header('Content-type: application/pdf');
    header('Content-Disposition: attachment; filename="consignment_label.pdf"');
    //readfile(DIR_WS_ONLINEPDF."consignment/".$label_name);
    readfile($filepath);
}else if(isset($labelType) && $labelType == "tracking"){
    $label_name = "TrackingLabel_".$booking_id.".pdf";
    if(isset($pagename) && $pagename=="overnight")
    {
       // $label_name = ucfirst($pagename)."_".ucfirst($servicename)."_".$booking_id.".pdf";
        $filepath = DIR_WS_ONLINEPDF."StarTrack/connoate/".$label_name;
    }elseif(isset($pagename) && $pagename=="sameday"){
       // $label_name = ucfirst($pagename)."_".ucfirst($servicename)."_".$booking_id.".pdf";
        $filepath = DIR_WS_ONLINEPDF."DirectCourier/connoate/".$label_name;
    }else{
       // $label_name = ucfirst($pagename)."_".$booking_id.".pdf";
        $filepath = DIR_WS_ONLINEPDF."UPS/connoate/".$label_name;
    }
    header('Content-type: application/pdf');
    header('Content-Disposition: attachment; filename="tracking_label.pdf"');
    //readfile(DIR_WS_ONLINEPDF."consignment/".$label_name);
    readfile($filepath);
}

?>