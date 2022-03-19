<?php
/**
	 * This is index file
	 *
	 *
	 * @author     Radixweb <team.radixweb@gmail.com>
	 * @copyright  Copyright (c) 2008, Radixweb
	 * @version    1.0
	 * @since      1.0
	 */
/**
	 * include common
	 */
require_once("lib/common.php");
require_once(DIR_WS_CURRENT_LANGUAGE . "international_get_quote.php");
require_once(DIR_WS_MODEL ."InternationalZonesMaster.php");
require_once(DIR_WS_MODEL ."BookingDetailsMaster.php");
require_once(DIR_WS_MODEL ."BookingItemDetailsMaster.php");
require_once(DIR_WS_MODEL ."InternationalItemTypeMaster.php");
require_once(DIR_WS_MODEL . "ServiceMaster.php");
require_once(DIR_WS_MODEL . "ServiceCutoffMaster.php");
require_once(DIR_WS_MODEL."PostCodeMaster.php");
require_once(DIR_WS_MODEL . "SupplierMaster.php");
$ObjServiceCutoffMaster = new ServiceCutoffMaster();
$ObjServiceCutoffMaster	= $ObjServiceCutoffMaster->Create();
$ServiceCutoffData		= new ServiceCutoffData();

$PostCodeMasterObj = new PostCodeMaster();
$PostCodeMasterObj = $PostCodeMasterObj->create();
$PostCodeDataObj = new PostCodeData();
$ObjServiceMaster = new ServiceMaster();
$ObjServiceMaster	= $ObjServiceMaster->Create();
$ServiceData		= new ServiceData();

$InternationalZoneMasterObj = new InternationalZonesMaster();
$InternationalZoneMasterObj= $InternationalZoneMasterObj->create();
$InternationalZoneData = new InternationalZonesData();
$ObjSupplierMaster	= new SupplierMaster();
$ObjSupplierMaster	= $ObjSupplierMaster->Create();
$SupplierData		= new SupplierData();
$arr_css_plugin_include[] = 'glyphicons_new/css/glyphicons.css';
////$arr_css_plugin_include[] = 'bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css';
$arr_javascript_plugin_include[] = 'moment/js/moment.js';
//$arr_javascript_plugin_include[] = 'bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js';
$arr_javascript_include[] = 'highslide/highslide-with-html.js';
$arr_javascript_below_include[] = 'internal/international.php';

if($_POST['ptoken'])
{
	$err['ptoken'] = chkTrk($_POST['ptoken']);
}
if($err['ptoken'])
{
	logOut();
}
$session_data = json_decode($_SESSION['Thesessiondata']['_sess_login_userdetails'],true);
$userid       = $session_data['user_id'];
/*csrf validation*/
$BookingDetailsDataObjArray = $__Session->GetValue("booking_details");
$pickupid = $BookingDetailsDataObjArray['pickupid'];
if(isset($pickupid) && !empty($pickupid)){
	$state = get_state_code($pickupid);
}


//$zonedate = date('Y-m-d H:i',strtotime(get_time_zonewise($pickupid)));
$zoneCurrentDate = date('d-m-Y',strtotime(get_time_zonewise($pickupid)));
$originalDateRegion = date('d-m-Y',strtotime(get_time_zonewise($pickupid)));
//$zoneCurrentDate = '06-04-2021';
$start_date = date('d-m-Y H:i:s', strtotime(get_time_zonewise($pickupid)));
$defaultdate = date('l j F Y h:i:s A',strtotime(get_time_zonewise($pickupid)));						
$defaulthr = date("H",strtotime(get_time_zonewise($pickupid)));
$defaultmin = date("i",strtotime(get_time_zonewise($pickupid)));
$defaultsec = date("s",strtotime(get_time_zonewise($pickupid)));
$defaultTime = date('H:i', ceil(strtotime($defaulthr.":".$defaultmin)/1800)*1800);
$regionOriginalTiming = date("h:i A",strtotime(get_time_zonewise($pickupid)));;

if(isset($zoneCurrentDate) && !empty($zoneCurrentDate) && isset($state) && !empty($state)){
	$dates = aWeekBusinessDays($state,$zoneCurrentDate);
}
/*
	Below code to disable today from dropdown list of dates
*/
$cutOffTime = '2:00 PM';							
$disableToday = 'true';
if((strtotime($regionOriginalTiming)>=strtotime($cutOffTime)))
{
	$disableToday = 'false';
}
if(isset($zoneCurrentDate) && $zoneCurrentDate === $dates[0]  && isset($disableToday) && $disableToday == 'false'){
	array_shift($dates);		
}
/* Below code is if today's date is holiday then  
* below code will be executed
*/
if(isset($dates[0]) && isset($zoneCurrentDate) && $dates[0] != $zoneCurrentDate){
	$zoneCurrentDate = date('d-m-Y',strtotime($dates[0]));
	$start_date = date('d-m-Y 7:00:00', strtotime($dates[0]));
	$defaultdate = date('l j F Y 7:00:00 A',strtotime($dates[0]));						
	$defaultTime = '7:00:00 AM';
	$regionOriginalTiming = '7:00:00 AM';
	
}
if(isset($BookingDetailsDataObjArray['start_date'])){
	$start_date = $BookingDetailsDataObjArray['start_date'];
}
/*
echo "<pre>";
print_r($dates);
echo "</pre>";
*/
$display_collection_dt = 'display:none;';
/*
	Below condition is to open collection date box to show that service is available
	in two conditions
	1) when date is in session
	2) when current date is not same as date dropdown first selected date 
	3) When current date is same as collecetion date dropdown and cutoff time has not exceeded
	4) When by default tommorrow is selected

*/
//echo $dates[0]."---".$zoneCurrentDate."--".$regionOriginalTiming."</br>";

if((isset($BookingDetailsDataObjArray['start_date']) && !empty($BookingDetailsDataObjArray['start_date'])) || (isset($dates[0]) && isset($zoneCurrentDate) && $dates[0] != $zoneCurrentDate) || (isset($dates[0]) && isset($zoneCurrentDate) && $dates[0] == $zoneCurrentDate && strtotime($regionOriginalTiming)<strtotime('2:00 PM')) ){
	$display_collection_dt = 'display:block;';
}

if(isset($start_date) && !empty($start_date)){
	$startdateArr    = explode(" ",$start_date);
	$starttimeArr    = explode(":",$startdateArr[1]);
	
	$time_hr = $starttimeArr[0];
	$time_min = $starttimeArr[1];
	$hr_formate = $startdateArr['hr_formate'];
	$usertiming = $time_hr.":".$time_min." ".$hr_formate;
	$usertiming = date('h:i a',strtotime($usertiming));
}

//exit();
$bk_type_hidden = $_POST["booking_type_hidden"];
$courier_id_hidden = $_POST["courier_id_hidden"];
$total_amt = $_POST['total_amt'];

if(!empty($_GET["action"]))
{
	$action = valid_input($_GET["action"]);
	$err['ACTIONERROR'] = chkPages($action);
}
if((isset($_GET['action']) && $_GET['action'] == 'service_cutoff')||(isset($_GET['Action']) && $_GET['Action'] == 'edit'))
{
	unset($_SESSION['original_amount']);
    unset($_SESSION['base_fuel_fee']);
    unset($_SESSION['due_amt']);
    unset($_SESSION['coverage_rate']);
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
	
}
/*csrf validation*/
$csrf = new csrf();
if($bk_type_hidden=='')
{
	$csrf->action = "international";
	$ptoken = $csrf->csrfkey();
}

/*csrf validation*/

$zonedate = date('Y-m-d H:i',strtotime(get_time_zonewise($pickupid)));
$zoneCurrentDate = date('d-m-Y',strtotime(get_time_zonewise($pickupid)));
//$zoneCurrentDate = '06-04-2021';
$start_date = date('d-m-Y H:i:s', strtotime(get_time_zonewise($pickupid)));
if(isset($BookingDetailsDataObjArray['start_date'])){
	$start_date = $BookingDetailsDataObjArray['start_date'];
}
if(isset($start_date) && !empty($start_date)){
	$startdateArr    = explode(" ",$start_date);
	$starttimeArr    = explode(":",$startdateArr[1]);
	
	$time_hr = $starttimeArr[0];
	$time_min = $starttimeArr[1];
	$hr_formate = $startdateArr['hr_formate'];
	$usertiming = $time_hr.":".$time_min." ".$hr_formate;
	$usertiming = date('h:i a',strtotime($usertiming));
}
//exit();

if(!empty($bk_type_hidden))
{
	$err['bk_type_hidden'] = chkSmall($bk_type_hidden);
}
if(!empty($courier_id_hidden))
{
	$err['courier_id_hidden'] = isNumeric($courier_id_hidden,COMMON_NUMERIC_VAL);
}

if(!empty($total_amt))
{
	$err['total_amt'] = isFloat($total_amt,COMMON_NUMERIC_VAL);
}
/*
$err['TIMEHRERROR'] = isNumeric($time_hr,COMMON_NUMERIC_VAL);
$err['TIMESECONDERROR'] = isNumeric($time_sec,COMMON_NUMERIC_VAL);	
$err['TIMEHRFROMATE'] = chkSmall($hr_formate);
$err['STARTDATE'] = chkStr($start_date); *//* date is coming in the formate of 2013-12-12 */

if(isset($err))
{
foreach ($err as $key => $Value) {
	if ($Value != '') {
		
		$Svalidation = true;
		/*csrf validation*/
		$ptoken = $csrf->csrfkey();
		/*csrf validation*/
		logOut();
	}
}
}
if($Svalidation == false){
	
	$BookingDetailsDataObjArray = $__Session->GetValue("booking_details");
	$__Session->SetValue("booking_details",$BookingDetailsDataObjArray);
	$__Session->Store();
}
$BookingItemDetailsData =  $__Session->GetValue("booking_details_items");
$ServiceDetailsData = $__Session->GetValue("service_details");


//exit();
if (isset($bk_type_hidden) && $bk_type_hidden!="" && $Svalidation == false) {

	
	if(isEmpty(valid_input($_POST['ptoken']), true))
	{	
		logOut();
	}
	else
	{
		$csrf->checkcsrf($_POST['ptoken']);
	}
	
	//
	if(isset($_POST['international_collection_date']) && $_POST['international_collection_date']!=""){
		$start_date = $_POST['international_collection_date']; 
	}
	if(isset($_POST['ready_time']) && $_POST['ready_time'] != ""){
		$collection_time = $_POST['ready_time'];
	}
	if(isset($_POST['close_time']) && $_POST['close_time'] != ""){
		$close_time = $_POST['close_time'];
	}
	$BookingDetailsDataObjArray["start_date"] = $start_date;
	$BookingDetailsDataObjArray["date_ready"] = $start_date;
	$BookingDetailsDataObjArray["servicepagename"] = "international";
	$BookingDetailsDataObjArray["time_ready"] = $collection_time;
	$BookingDetailsDataObjArray["close_time"] = $close_time;
	$service_name = $bk_type_hidden;
	
	$fieldArr =array();
	$fieldArr=array("auto_id","supplier_name");
	$seaByArr=array();
	$seaByArr[]=array('Search_On'=>'auto_id', 'Search_Value'=>$courier_id_hidden, 'Type'=>'string', 'Equation'=>'=', 'CondType'=>'and', 'Prefix'=>'', 'Postfix'=>'');
	$DataSupplier=$ObjSupplierMaster->getSupplier($fieldArr,$seaByArr);
	$DataSupplier = $DataSupplier[0];
	$courier_name = $DataSupplier['supplier_name'];
	$BookingDetailsDataObjArray["service_name"] = $bk_type_hidden;
	$serviceSupplier = strtolower($BookingDetailsDataObjArray["service_name"])."_supplier";
	
	$BookingDetailsDataObjArray["webservice"] = $courier_name;
	$BookingDetailsDataObjArray["rate"] = $total_amt;
	
	$__Session->SetValue("booking_details",$BookingDetailsDataObjArray);
	$__Session->Store();
	if(isset($_GET['Action']) && $_GET['Action']=='edit')
	{
		header("Location:".FILE_CHECKOUT);
		exit();
	}else{
		
		header("Location:".FILE_ADDRESSES);
		//echo "inside";
		exit();
		

	}
	
}


require_once( DIR_WS_SITE_CURRENT_TEMPLATE . FILE_MAIN_INTERFACE);

?>