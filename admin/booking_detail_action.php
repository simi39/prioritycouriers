<?php
/**
	* This file is for display user list
	*
	* @author     Radixweb <team.radixweb@gmail.com>
	* @copyright  Copyright (c) 2008, Radixweb
	* @version    1.0
	* @since      1.0
	*/

/**
	 * include common file
	 */

require_once("../lib/common.php");
require_once(DIR_WS_MODEL . "BookingDetailsMaster.php");
require_once(DIR_WS_MODEL . "UserMaster.php");
require_once(DIR_WS_MODEL ."CountryMaster.php");
require_once(DIR_WS_MODEL . "PostCodeMaster.php");
require_once(DIR_WS_MODEL . "ItemTypeMaster.php");
require_once(DIR_WS_MODEL . "SiteConstantMaster.php");
require_once(DIR_WS_ADMIN_LANGUAGES . DIR_CURRENT_LANGUAGE. '/booking_detail.php');
require_once(DIR_WS_MODEL . "ServiceMaster.php");

/**
	 * Start :: Object declaration
	 */
/*csrf validation*/
$csrf = new csrf();
$csrf->action = "booking_detail_action";
if(!isset($_POST['ptoken'])) {
	$ptoken = $csrf->csrfkey();
}


/*csrf validation*/

$ObjBookingDetailsMaster	= new BookingDetailsMaster();
$ObjBookingDetailsMaster	= $ObjBookingDetailsMaster->Create();
$BookingDetailsData		= new BookingDetailsData();
$ObjUserMaster	= new UserMaster();
$ObjUserMaster	= $ObjUserMaster->Create();
$UserData		= new UserData();
$ObjPostCodeMaster	= new PostCodeMaster();
$ObjPostCodeMaster	= $ObjPostCodeMaster->Create();
$PostCodeData		= new PostCodeData();
$CountryMasterObj = new CountryMaster();
$CountryMasterObj = $CountryMasterObj->Create();
$CountryData  = new CountryData();
$ObjInternationalMaster	= new ItemTypeMaster();
$ObjInternationalMaster	= $ObjInternationalMaster->Create();
$objSiteConstantMaster = new SiteConstantMaster();
$objSiteConstantMaster = $objSiteConstantMaster->create();
$objSiteConstantData = new SiteConstantData();
$ObjServiceMaster	= new ServiceMaster();
$ObjServiceMaster   = $ObjServiceMaster->Create();
$ServiceData		= new ServiceData();

$SiteConstantDataVal = $objSiteConstantMaster->getSiteConstant($fieldArr=null, $seaArr=null, $optArr=null, $start=null, $total=null, $ThrowError=true,$constant_id=null,$from_admin=false,'services_volumetric_charges');
$SiteConstantData = $SiteConstantDataVal[0];
$volumetric_divisor = ($SiteConstantData->constant_value!="")?($SiteConstantData->constant_value):(4000);

/**
	 * Inclusion and Exclusion Array of CSS and Javascript
	 */
$arr_css_admin_exclude[] = 'jquery.css';
$arr_css_plugin_include[] ='bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css';
$arr_css_plugin_include[] = 'glyphicons_new/css/glyphicons.css';
$arr_css_plugin_include[] ='tabbed-panels/css/tabbed_panels.css';
$arr_css_admin_include[] = 'custom-style.css';

$arr_javascript_include[] = 'internal/ajex.js';
$arr_javascript_include[] = 'internal/ajax-dynamic-list.js';
$arr_javascript_plugin_include[] = 'bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js';
$arr_javascript_plugin_include[] = 'moment/js/moment-with-locales.min.js';
$arr_javascript_plugin_include[] = 'bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js';

$arr_javascript_include[] = "shipping.js";
$arr_javascript_include[] = "postcode_action.php";
$arr_javascript_include[] = 'holiday_validation.php';
$arr_javascript_include[] ='booking_details.php';

/**
	 * Variable Declaration
	 */




$btnSubmit = ADMIN_BUTTON_SAVE_POSTCODE;
$HeadingLabel = ADMIN_LINK_SAVE_POSTCODE;


$hh = array('1','2','3','4','5','6','7','8','9','10','11','12');
$mm = array('00','15','30','45');
$am_pm = array('am','pm');

$flag = array('australia','international');
$webservice = array("AAE"=>"AAE","DIRCOUR"=>"Direct Courier","UPS" => "UPS");
$payment_done = array("true","false");
$tansient_warranty =  array("true","false");
$authority_to_leave =  array("true","false");
$serviceFieldArr = array("service_name");
$serviceSeaByArr=array();

$DataService=$ObjServiceMaster->getService($serviceFieldArr, $serviceSeaByArr,null,$from,$to);
$service = array();
if(!empty($DataService))
{
	foreach ($DataService as $service_details) {
		$service[] = strtolower($service_details['service_name']);
	}
}	

$pickup_time_zone = array('EST (Eastern Standard Time)','CST (Central Standard Time)','WST (Western Standard Time)');
$deliver_time_zone = array('EST (Eastern Standard Time)','CST (Central Standard Time)','WST (Western Standard Time)');
$pro_froma_invoice = array("Yes","No");
$pagenum = ($_GET['pagenum']!="")?($_GET['pagenum']):(1);
if(!empty($pagenum))
{
	$err['pagenum'] = isNumeric(valid_input($pagenum),ENTER_NUMERIC_VALUES_ONLY);
}
if(!empty($err['pagenum']))
{
	logOut();
}

$SiteConstantDataVal = $objSiteConstantMaster->getSiteConstant($fieldArr=null, $seaArr=null, $optArr=null, $start=null, $total=null, $ThrowError=true,$constant_id=null,$from_admin=true);
$SiteConstant = new stdClass;
	foreach ($SiteConstantDataVal as $key=>$val) 
	{
		$key = $val->constant_name;
		$value =$val->constant_value;
		$SiteConstant->{$key}=$value;
		$$key=$value;
		
	}
/*echo "<pre>";print_r($SiteConstant);die();
	$SiteConstantData = $SiteConstantDataVal[0];
	echo "<pre>";print_r($SiteConstantData);die();*/

//declaration of variable
$minimum_charge = "";
$minimum_transient_value = $SiteConstant->transit_warranty;
$minimum_charge_constant = $SiteConstant->minimum_charge;
$minimum_charge_array = explode("%",$minimum_charge_constant);
if(count($minimum_charge_array)==2 && is_numeric($minimum_charge_array[0]) && $minimum_charge_array[0]!=0){
	$minimum_charge = $minimum_charge_array[0]/100;
}
$minimum_transient_value = ($minimum_transient_value=='')?('95'):($minimum_transient_value);
$minimum_charge = ($minimum_charge=='')?(3/100):($minimum_charge);
$acl_constant = ($acl_constant=='')?(6):($acl_constant);


if(!empty($_GET['Action']))
{
	$err['Action'] = chkStr(valid_input($_GET['Action']));
}
if(!empty($err['Action']))
{
	logOut();
}
//export the csv file 
if($_GET['Action']!='' &&  $_GET['Action']=='export'){
	$optArrforBookingDetails[]= array();
	 $seaArrforBookingDetails[]	= array();
	$seaArrforBookingDetails[]	=	array('Search_On'=>'CCConnote',
			  									'Search_Value'=>'',
			  									'Type'=>'string',
			  									'Equation'=>'!=',
			  									'CondType'=>'AND',
			  									'Prefix'=>'',
			  									'Postfix'=>'');
			  					
	$BookingDetails = $ObjBookingDetailsMaster->getBookingDetails($fieldArr=null, $seaArrforBookingDetails);


	$filename = DIR_WS_ADMIN_DOCUMENTS."booking_details.csv"; //Balnk CSV File
	$file_extension = strtolower(substr(strrchr($filename,"."),1));	//GET EXtension

	/**
	 * Genration of CSV File
	 */
	switch( $file_extension ) {
		case "csv": $ctype = "text/comma-separated-values";break;
		case "jpg": $ctype="image/jpg"; break;
		default: $ctype="application/force-download";
	}
	header("Pragma: public"); // required
	header('Expires: ' . gmdate('D, d M Y H:i:s') . ' GMT');
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Cache-Control: private",false); // required for certain browsers
	header("Content-Type: $ctype");
	header("Content-Disposition: attachment; filename=".basename($filename).";" );
	header("Content-Transfer-Encoding: binary");

	ob_clean();

	$curr= array("€"=>"�","£"=>"�");
	$data = "";
	$data.= "pickupid,\"deliveryid\",\"distance_in_km\",\"flag\",\"userid\",\"pageid\",\"booking_id\",\"webservice\",\"payment_done\",\"total_qty\",\"total_weight\",\"volumetric_weight\",\"chargeable_weight\",\"standard_rate\",\"express_rate\",\"international_rate\",\"priority_rate\",\"overnight_rate\",\"economy_rate\",\"description_of_goods\",\"dangerous_goods\",\"tansient_warranty\",\"values_of_goods\",\"authority_to_leave\",\"where_to_leave_shipment\",\"additional_cost\",\"coverage_rate\",\"service_name\",\"sender_first_name\",\"sender_surname\",\"sender_company_name\",\"sender_address_1\",\"sender_address_2\",\"sender_address_3\",\"sender_suburb\",\"sender_state\",\"sender_postcode\",\"sender_email\",\"sender_contact_no\",\"sender_mobile_no\",\"reciever_firstname\",\"reciever_surname\",\"reciever_company_name\",\"reciever_address_1\",\"reciever_address_2\",\"reciever_address_3\",\"reciever_suburb\",\"reciever_state\",\"reciever_postcode\",\"reciever_email\",\"reciever_contact_no\",\"reciever_mobile_no\",\"date_ready\",\"time_ready\",\"booking_date\",\"booking_time\",\"pickup_time_zone\",\"delivery_time_zone\",\"pagename\",\"servicepagename\",\"connote_no\",\"booking_no\",\"p_id\",\"d_id\"";
	//$data.= PICKUP_FROM.",".DILIVER_TO.",".DISTANCEINKM;

	if(isset($BookingDetails) && !empty($BookingDetails)) {
		foreach ($BookingDetails as $BookingDetail) {
			/*Code for the Currency value in which the order has been done*/
			//echo "<pre>";print_r($BookingDetail);exit();


			$pickupid       = $BookingDetail['pickupid'];
			$deliveryid       = $BookingDetail['deliveryid'];
			$distance_in_km       = $BookingDetail['distance_in_km'];
			$flag       = $BookingDetail['flag'];
			$userid       = $BookingDetail['userid'];
			$pageid       = $BookingDetail['pageid'];
			$booking_id       = $BookingDetail['booking_id'];
			$webservice       = valid_output($BookingDetail['webservice']);
			$payment_done       = valid_output($BookingDetail['payment_done']);
			$total_qty       = $BookingDetail['total_qty'];
			$total_weight       = $BookingDetail['total_weight'];
			$volumetric_weight       = $BookingDetail['volumetric_weight'];
			$chargeable_weight       = $BookingDetail['chargeable_weight'];
			$standard_rate       = $BookingDetail['standard_rate'];
			$express_rate       = $BookingDetail['express_rate'];
			$international_rate       = $BookingDetail['international_rate'];
			$priority_rate       = $BookingDetail['priority_rate'];
			$overnight_rate       = $BookingDetail['overnight_rate'];
			$economy_rate       = $BookingDetail['economy_rate'];
			$description_of_goods       = valid_output($BookingDetail['description_of_goods']);
			$dangerous_goods       = valid_output($BookingDetail['dangerous_goods']);
			$tansient_warranty       = valid_output($BookingDetail['tansient_warranty']);
			$values_of_goods       = $BookingDetail['values_of_goods'];
			$authority_to_leave       = valid_output($BookingDetail['authority_to_leave']);
			$where_to_leave_shipment       = valid_output($BookingDetail['where_to_leave_shipment']);
			$additional_cost       = $BookingDetail['additional_cost'];
			$coverage_rate       = $BookingDetail['coverage_rate'];
			$service_name       = valid_output($BookingDetail['service_name']);
			$sender_first_name       = valid_output($BookingDetail['sender_first_name']);
			$sender_surname       = valid_output($BookingDetail['sender_surname']);
			$sender_company_name       = valid_output($BookingDetail['sender_company_name']);
			$sender_address_1       = valid_output($BookingDetail['sender_address_1']);
			$sender_address_2       = valid_output($BookingDetail['sender_address_2']);
			$sender_address_3       = valid_output($BookingDetail['sender_address_3']);
			$sender_suburb       = valid_output($BookingDetail['sender_suburb']);
			$sender_state       = valid_output($BookingDetail['sender_state']);
			$sender_postcode       = $BookingDetail['sender_postcode'];
			$sender_email       = valid_output($BookingDetail['sender_email']);
			$sender_contact_no       = $BookingDetail['sender_contact_no'];
			$sender_mobile_no       = $BookingDetail['sender_mobile_no'];
			$reciever_firstname       = valid_output($BookingDetail['reciever_firstname']);
			$reciever_surname       = valid_output($BookingDetail['reciever_surname']);
			$reciever_company_name       = valid_output($BookingDetail['reciever_company_name']);
			$reciever_address_1       = valid_output($BookingDetail['reciever_address_1']);
			$reciever_address_2       = valid_output($BookingDetail['reciever_address_2']);
			$reciever_address_3       = valid_output($BookingDetail['reciever_address_3']);
			$reciever_suburb       = valid_output($BookingDetail['reciever_suburb']);
			$reciever_state       = valid_output($BookingDetail['reciever_state']);
			$reciever_postcode       = $BookingDetail['reciever_postcode'];
			$reciever_email       = valid_output($BookingDetail['reciever_email']);
			$reciever_contact_no       = $BookingDetail['reciever_contact_no'];
			$reciever_mobile_no       = $BookingDetail['reciever_mobile_no'];
			$date_ready       = valid_output($BookingDetail['date_ready']);
			$time_ready       = valid_output($BookingDetail['time_ready']);
			$booking_date       = valid_output($BookingDetail['booking_date']);
			$booking_time       = valid_output($BookingDetail['booking_time']);
			$pickup_time_zone       = valid_output($BookingDetail['pickup_time_zone']);
			$delivery_time_zone       = valid_output($BookingDetail['delivery_time_zone']);
			$pagename       = valid_output($BookingDetail['pagename']);
			$servicepagename       = valid_output($BookingDetail['servicepagename']);
			$CCConnote       = valid_output($BookingDetail['CCConnote']);
			$BookingNumber       = valid_output($BookingDetail['BookingNumber']);
			$p_id       = $BookingDetail['p_id'];
			$d_id       = $BookingDetail['d_id'];
			//$pro_froma_invoice       = $BookingDetail['pro_froma_invoice'];


			$data.= "\n";

			$data.= '"'.$pickupid.'","'.$deliveryid.'","'.$distance_in_km.'","'.$flag.'","'.$userid.'","'.$pageid.'","'.$booking_id.'","'.$webservice.'","'.$payment_done.'","'.$total_qty.'","'.$total_weight.'","'.$volumetric_weight.'","'.$chargeable_weight.'","'.$standard_rate.'","'.$express_rate.'","'.$international_rate.'","'.$priority_rate.'","'.$overnight_rate.'","'.$economy_rate.'","'.$description_of_goods.'","'.$dangerous_goods.'","'.$tansient_warranty.'","'.$values_of_goods.'","'.$authority_to_leave.'","'.$where_to_leave_shipment.'","'.$additional_cost.'","'.$coverage_rate.'","'.$service_name.'","'.$sender_first_name.'","'.$sender_surname.'","'.$sender_company_name.'","'.$sender_address_1.'","'.$sender_address_2.'","'.$sender_address_3.'","'.$sender_suburb.'","'.$sender_state.'","'.$sender_postcode.'","'.$sender_email.'","'.$sender_contact_no.'","'.$sender_mobile_no.'","'.$reciever_firstname.'","'.$reciever_surname.'","'.$reciever_company_name.'","'.$reciever_address_1.'","'.$reciever_address_2.'","'.$reciever_address_3.'","'.$reciever_suburb.'","'.$reciever_state.'","'.$reciever_postcode.'","'.$reciever_email.'","'.$reciever_contact_no.'","'.$reciever_mobile_no.'","'.$date_ready.'","'.$time_ready.'","'.$booking_date.'","'.$booking_time.'","'.$pickup_time_zone.'","'.$delivery_time_zone.'","'.$pagename.'","'.$servicepagename.'","'.$CCConnote.'","'.$BookingNumber.'","'.$p_id.'","'.$d_id.'"';


		}
	}
	echo $data;
	exit();
}

//import the csv file 





//add / update the record
if((isset($_POST['submit']) && $_POST['submit'] != "")){
	
	if(isEmpty(valid_input($_POST['ptoken']), true)){	
			logOut();
	}else{
		//$csrf->checkcsrf($_POST['ptoken']);
	}
	$err['flagError'] 		 = isEmpty($_POST['flag'],FLAG_IS_REQUIRED)?isEmpty($_POST['flag'],FLAG_IS_REQUIRED):chkStr($_POST['flag']);
	$err['useridError'] 	 = isEmpty($_POST['userid'], USER_IS_REQUIRED)?isEmpty($_POST['userid'], USER_IS_REQUIRED):isNumeric(valid_input($_POST['userid']),ERROR_SENDER_CONTACT_REQUIRE_IN_NUMERIC); 
	$err['webserviceError']  = isEmpty($_POST['webservice'], WEBSERVICE_IS_REQUIRED)?isEmpty($_POST['webservice'], WEBSERVICE_IS_REQUIRED):chkStr($_POST['webservice']);
	if(!empty($_POST['current_active_id']))
	{
		$err['current_active_id'] = isNumeric(valid_input($_POST['current_active_id']),ENTER_NUMERIC_VALUES_ONLY);
	}
	if(!empty($err['current_active_id']))
	{
		logOut();
	}
	if(!empty($_POST['volumetric_divisor']))
	{
		$err['volumetric_divisor'] = isNumeric(valid_input($_POST['volumetric_divisor']),ENTER_NUMERIC_VALUES_ONLY);
	}
	if(!empty($err['volumetric_divisor']))
	{
		logOut();
	}
	if(!empty($_POST['description_of_goods']))
	{
		$err['description_of_goods'] = chkStreet($_POST['description_of_goods']);
	}
	if(!empty($_POST['distance_in_km']))
	{
		$err['distance_in_km'] = isFloat($_POST['distance_in_km'],ADMIN_ENTER_DECIMAL_VALUE);
	}
	if(!empty($_POST['total_qty']))
	{
		$err['total_qty'] = isNumeric($_POST['total_qty'],ENTER_VALUE_IN_NUMERIC);
	}
	if(!empty($_POST['height']))
	{
		$err['height'] = isNumeric($_POST['height'],ENTER_VALUE_IN_NUMERIC);
	}
	if(!empty($_POST['width']))
	{
		$err['width'] = isNumeric($_POST['width'],ENTER_VALUE_IN_NUMERIC);
	}
	if(!empty($_POST['length']))
	{
		$err['length'] = isNumeric($_POST['length'],ENTER_VALUE_IN_NUMERIC);
	}
	if(!empty($_POST['australia_item_weight']))
	{
		$err['australia_item_weight'] = isFloat($_POST['australia_item_weight'],ADMIN_ENTER_DECIMAL_VALUE);
	}
	if(!empty($_POST['item_weight']))
	{
		$err['item_weight'] = isFloat($_POST['item_weight'],ADMIN_ENTER_DECIMAL_VALUE);
	}
	if(!empty($_POST['australia_item_weight']))
	{
		$err['australia_item_weight'] = isFloat($_POST['australia_item_weight'],ADMIN_ENTER_DECIMAL_VALUE);
	}
	if($_POST['flag']!="" && $_POST['flag']=="australia"){
		$err['deliveryidError']  = isEmpty($_POST['DeliveryPostcode'], DELIVERY_IS_REQUIRED)?isEmpty($_POST['DeliveryPostcode'], DELIVERY_IS_REQUIRED):chkStr($_POST['DeliveryPostcode']);
		$_POST['deliveryid'] = $_POST['deliveryid'];
		$err['reciever_postcodeError'] 		 =(isEmpty(valid_input($_POST['reciever_postcode']),RECEIVER_POSTCODE_IS_REQUIRES))?(isEmpty(valid_input($_POST['reciever_postcode']),RECEIVER_POSTCODE_IS_REQUIRES)):isNumeric(valid_input($_POST['reciever_postcode']),ERROR_RECEIVER_POSTCODE_REQUIRE_IN_NUMERIC);
	}else{
		$err['deliveryidError']  = isEmpty($_POST['deliveryidforinternational'], DELIVERY_IS_REQUIRED)?isEmpty($_POST['deliveryidforinternational'], DELIVERY_IS_REQUIRED):chkStr($_POST['deliveryidforinternational']);
		$_POST['deliveryid'] = $_POST['deliveryidforinternational'];
		
		$err['reciever_postcodeError'] 		 =(isEmpty(valid_input($_POST['reciever_postcode']),RECEIVER_POSTCODE_IS_REQUIRES))?(isEmpty(valid_input($_POST['reciever_postcode']),RECEIVER_POSTCODE_IS_REQUIRES)):chkStreet(valid_input($_POST['reciever_postcode']));
		
	}
	
	//$err['pickupidError']  = isEmpty($_POST['PickupPostcode'], PICKUP_IS_REQUIRED)?isEmpty($_POST['PickupPostcode'], PICKUP_IS_REQUIRED):isNumeric($_POST['PickupPostcode'],COMMON_ZIPCODE_IN_NUMERIC);
	
	$err['total_weightError']  = isEmpty($_POST['total_weight'], TOTAL_WEIGHT_IS_REQUIRED)?isEmpty($_POST['total_weight'], TOTAL_WEIGHT_IS_REQUIRED):isFloat($_POST['total_weight'],ADMIN_ENTER_DECIMAL_VALUE);
	$err['volumetric_weightError']  = isEmpty($_POST['volumetric_weight'], VOLUMETRIC_WEIGHT_IS_REQUIRED)?isEmpty($_POST['volumetric_weight'], VOLUMETRIC_WEIGHT_IS_REQUIRED):isFloat(valid_input($_POST['volumetric_weight']),ADMIN_ENTER_DECIMAL_VALUE);
	$err['sender_first_nameError']  = isEmpty($_POST['sender_first_name'], SENDER_FIRST_NAME_IS_REQUIRED)?isEmpty($_POST['sender_first_name'], SENDER_FIRST_NAME_IS_REQUIRED):checkName(valid_input($_POST['sender_first_name']));
	$err['reciever_first_nameError']  = isEmpty(valid_input($_POST['reciever_first_name']), RECEIVER_FIRST_NAME_IS_REQUIRED)?isEmpty(valid_input($_POST['reciever_first_name']), RECEIVER_FIRST_NAME_IS_REQUIRED):checkName(valid_input($_POST['reciever_first_name']));
	$err['sender_surnameError']  = isEmpty(valid_input($_POST['sender_surname']), SENDER_SURNAME_IS_REQUIRED)?isEmpty(valid_input($_POST['sender_surname']), SENDER_SURNAME_IS_REQUIRED):checkName(valid_input($_POST['sender_surname']));
	$err['reciever_surnameError']  = isEmpty($_POST['reciever_surname'], RECEIVER_SURNAME_IS_REQUIRED)?isEmpty(valid_input($_POST['reciever_surname']), RECEIVER_SURNAME_IS_REQUIRED):checkName(valid_input($_POST['reciever_surname']));
	$err['sender_address_1Error']  = isEmpty($_POST['sender_address_1'], SENDER_ADDRESS_IS_REQUIRED)?isEmpty(valid_input($_POST['sender_address_1']), SENDER_ADDRESS_IS_REQUIRED):chkStreet(valid_input($_POST['sender_address_1']));
	$err['reciever_address_1Error']  = isEmpty($_POST['reciever_address_1'], RECEIVER_ADDRESS_IS_REQUIRED)?isEmpty(valid_input($_POST['reciever_address_1']), RECEIVER_ADDRESS_IS_REQUIRED):chkStreet(valid_input($_POST['reciever_address_1']));
	
	$err['sender_emailError'] 		 = (isEmpty(valid_input($_POST['sender_email']),SENDER_EMAIL_IS_REQUIRES))?isEmpty(valid_input($_POST['sender_email']),SENDER_EMAIL_IS_REQUIRES):checkEmailPattern(valid_input($_POST['sender_email']),ERROR_EMAIL_ID_INVALID);
	if(isset($_POST['reciever_email']) && $_POST['reciever_email']!="")
	{
		$err['reciever_emailError']  = checkEmailPattern(valid_input($_POST['reciever_email']),ERROR_EMAIL_ID_INVALID);
	}
	$err['sender_suburbError'] 		 =isEmpty($_POST['sender_suburb'], SENDER_SUBURB_IS_REQUIRES)?isEmpty($_POST['sender_suburb'], SENDER_SUBURB_IS_REQUIRES):checkName(valid_input($_POST['sender_suburb']));
	$err['reciever_suburbError'] 		 =isEmpty($_POST['reciever_suburb'], RECEIVER_SUBURB_IS_REQUIRES)?isEmpty(valid_input($_POST['reciever_suburb']), RECEIVER_SUBURB_IS_REQUIRES):checkName(valid_input($_POST['reciever_suburb']));
	$err['sender_stateError'] 		 =isEmpty($_POST['sender_state'], SENDER_STATE_IS_REQUIRES)?isEmpty($_POST['sender_state'], SENDER_STATE_IS_REQUIRES):chkState(valid_input($_POST['sender_state']));
	$err['reciever_stateError'] 		 =isEmpty($_POST['reciever_state'], RECEIVER_STATE_IS_REQUIRES)?isEmpty($_POST['reciever_state'], RECEIVER_STATE_IS_REQUIRES):chkState(valid_input($_POST['reciever_state']));
	$err['sender_postcodeError'] 		 = (isEmpty(valid_input($_POST['sender_postcode']),SENDER_POSTCODE_IS_REQUIRES))?(isEmpty(valid_input($_POST['sender_postcode']),SENDER_POSTCODE_IS_REQUIRES)):isNumeric(valid_input($_POST['sender_postcode']),ERROR_SENDER_POSTCODE_REQUIRE_IN_NUMERIC);
	
	
	
	//$err['date_readyError'] 		 =isEmpty($_POST['date_ready'], DATE_READY_IS_REQUIRES)?isEmpty($_POST['date_ready'], DATE_READY_IS_REQUIRES):chkStr($_POST['date_ready']);
	//$err['booking_dateError'] 		 =isEmpty($_POST['booking_date'],BOOKING_DATE_IS_REQUIRES)?isEmpty($_POST['booking_date'],BOOKING_DATE_IS_REQUIRES):chkStr($_POST['booking_date']);
	$err['pickup_time_zoneError'] 		 =isEmpty($_POST['pickup_time_zone'],PICKUP_TIME_ZONE_IS_REQUIRES)?isEmpty($_POST['pickup_time_zone'],PICKUP_TIME_ZONE_IS_REQUIRES):chkbrkts($_POST['pickup_time_zone']);
	$err['delivery_time_zoneError'] 		 =isEmpty($_POST['delivery_time_zone'],DELIVER_TIME_ZONE_IS_REQUIRES)?isEmpty($_POST['delivery_time_zone'],DELIVER_TIME_ZONE_IS_REQUIRES):chkbrkts($_POST['delivery_time_zone']);
	
	
	$err['sender_contact_noError'] 		 =(isEmpty(valid_input($_POST['sender_contact_no']),''))?(isEmpty(valid_input($_POST['sender_contact_no']),'')):isNumeric(valid_input($_POST['sender_contact_no']),ERROR_SENDER_CONTACT_REQUIRE_IN_NUMERIC);
	$err['reciever_contact_noError'] 		 =(isEmpty(valid_input($_POST['reciever_contact_no']),''))?(isEmpty(valid_input($_POST['reciever_contact_no']),'')):isNumeric(valid_input($_POST['reciever_contact_no']),ERROR_RECEIVER_CONTACT_REQUIRE_IN_NUMERIC);
	
	$err['sender_mobile_noError'] 		 =(isEmpty(valid_input($_POST['sender_mobile_no']),''))?(isEmpty(valid_input($_POST['sender_mobile_no']),'')):isNumeric(valid_input($_POST['sender_mobile_no']),ERROR_SENDER_MOBILE_REQUIRE_IN_NUMERIC);
	$err['reciever_mobile_noError'] 		 =(isEmpty(valid_input($_POST['reciever_mobile_no']),''))?(isEmpty(valid_input($_POST['reciever_mobile_no']),'')):isNumeric(valid_input($_POST['reciever_mobile_no']),ERROR_RECEIVER_MOBILE_REQUIRE_IN_NUMERIC);
	if($_POST['CCConnote']!='')
	{
		$err['CCConnoteError'] = isNumeric(valid_input($_POST['CCConnote']),ENTER_VALUE_IN_NUMERIC);
	}

	foreach($err as $key => $Value) {
		if($Value != '') 
		{
			$Svalidation=true;
			$ptoken = $csrf->csrfkey();
		}
	}
	
	if($Svalidation==false){
		
		//This below code commented by shailesh jamanapara on Date Fri Jun 14 15:47:46 IST 2013 
		
		if($comman_rate!=""){
		$BookingDetailsData->$comman_rate = valid_input($_POST['rate']);
		}
		//Its changed to rate from service+_rate name e.g. standardrade, premiium_rate, eonomy_rate, priority_rate etc.
		$BookingDetailsData->rate = valid_input($_POST['rate']);
		
		if($_POST['transit_warranty']=="yes")
		{
			
		}
		$time_ready 	= valid_input($_POST['time_ready_time_hr']).":".valid_input($_POST['time_ready_time_sec']).valid_input($_POST['time_ready_hr_formate']);
		$booking_time  	= valid_input($_POST['booking_time_hr']).":".valid_input($_POST['booking_time_sec']).valid_input($_POST['booking_time_hr_formate']);
		
		$BookingDetailsData->flag = valid_input($_POST['flag']);
		$BookingDetailsData->userid = valid_input($_POST['userid']);
		$BookingDetailsData->webservice = valid_input($_POST['webservice']);
		$BookingDetailsData->payment_done = valid_input($_POST['payment_done']);
		$BookingDetailsData->pickupid = valid_input($_POST['pickupid']);
		$BookingDetailsData->deliveryid = valid_input($_POST['deliveryid']);
		$BookingDetailsData->distance_in_km = valid_input($_POST['distance_in_km']);
		$BookingDetailsData->pickup_location_type = $_POST["pickup_location_type"];
		$BookingDetailsData->delivery_location_type = $_POST["delivery_location_type"];
		$BookingDetailsData->total_qty = valid_input($_POST['total_qty']);
		$BookingDetailsData->total_weight = valid_input($_POST['total_weight']);
		$BookingDetailsData->volumetric_weight = valid_input($_POST['volumetric_weight']);

		$BookingDetailsData->chargeable_weight = valid_input($_POST['total_weight']);

		$BookingDetailsData->description_of_goods = valid_input($_POST['description_of_goods']);
		$BookingDetailsData->dangerous_goods = 'no';
		$BookingDetailsData->tansient_warranty = valid_input($_POST['transit_warranty']);

		$BookingDetailsData->values_of_goods = valid_input($_POST['values_of_goods']);
		$BookingDetailsData->authority_to_leave = valid_input($_POST['authority_to_leave']);
		$BookingDetailsData->where_to_leave_shipment = valid_input($_POST['where_to_leave_shipment']);
		$BookingDetailsData->service_name = valid_input($_POST['service_name']);
		$BookingDetailsData->sender_first_name       = valid_input($_POST['sender_first_name']);
		$BookingDetailsData->sender_surname       = valid_input($_POST['sender_surname']);
		$BookingDetailsData->sender_company_name       = valid_input($_POST['sender_company_name']);
		$BookingDetailsData->sender_address_1       = valid_input($_POST['sender_address_1']);
		$BookingDetailsData->sender_address_2       = valid_input($_POST['sender_address_2']);
		$BookingDetailsData->sender_address_3       = valid_input($_POST['sender_address_3']);
		$BookingDetailsData->sender_suburb       = valid_input($_POST['sender_suburb']);
		$BookingDetailsData->sender_state       = valid_input($_POST['sender_state']);
		$BookingDetailsData->sender_postcode       = valid_input($_POST['sender_postcode']);
		$BookingDetailsData->sender_email       = valid_input($_POST['sender_email']);
		$BookingDetailsData->sender_contact_no       = valid_input($_POST['sender_contact_no']);
		$BookingDetailsData->sender_mobile_no       = valid_input($_POST['sender_mobile_no']);
		$BookingDetailsData->reciever_firstname       = valid_input($_POST['reciever_first_name']);
		$BookingDetailsData->reciever_surname       = valid_input($_POST['reciever_surname']);
		$BookingDetailsData->reciever_company_name       = valid_input($_POST['reciever_company_name']);
		$BookingDetailsData->reciever_address_1       = valid_input($_POST['reciever_address_1']);
		$BookingDetailsData->reciever_address_2       = valid_input($_POST['reciever_address_2']);
		$BookingDetailsData->reciever_address_3       = valid_input($_POST['reciever_address_3']);
		$BookingDetailsData->reciever_suburb       = valid_input($_POST['reciever_suburb']);
		$BookingDetailsData->reciever_state       = valid_input($_POST['reciever_state']);
		$BookingDetailsData->reciever_postcode       = valid_input($_POST['reciever_postcode']);
		$BookingDetailsData->reciever_email       = valid_input($_POST['reciever_email']);
		$BookingDetailsData->reciever_contact_no       = valid_input($_POST['reciever_contact_no']);
		$BookingDetailsData->reciever_mobile_no       = valid_input($_POST['reciever_mobile_no']);
		
		if($_POST['booking_date']!="")
		{
			$bookingArr = explode(" ",$_POST['booking_date']);
		}
		
		$BookingDetailsData->date_ready       = date('Y-m-d H:i', strtotime($_POST['date_ready']));
		$BookingDetailsData->time_ready       = valid_input($time_ready);
		$BookingDetailsData->booking_date       = $bookingArr[0]." ".$bookingArr[1]." ".$bookingArr[2];
		$BookingDetailsData->booking_time       = $bookingArr[3]."".$bookingArr[4];
		$BookingDetailsData->pickup_time_zone       = valid_input($_POST['pickup_time_zone']);
		$BookingDetailsData->delivery_time_zone       = valid_input($_POST['delivery_time_zone']);

		$BookingDetailsData->CCConnote       = valid_input($_POST['CCConnote']);
		//$BookingDetailsData->BookingNumber       = valid_input($_POST['BookingNumber']);
		$BookingDetailsData->p_id       = valid_input($_POST['fetchpickupid']);
		$BookingDetailsData->d_id       = valid_input($_POST['fetchdeliveryid']);
		
		$BookingDetailsData->additional_cost = valid_input($_POST['coverage_rate']) + valid_input($_POST['rate']);
		$BookingDetailsData->coverage_rate = valid_input($_POST['coverage_rate']);
		if($_GET['auto_id']!='')
		{
			//$booking_id = $_GET['booking_id'];
			//$BookingDetailsData->booking_id = $booking_id;
			$BookingDetailsData->auto_id = $_GET['auto_id'];
			$ObjBookingDetailsMaster->editBookingDetails($BookingDetailsData,'from_admin');
			$UParam = "?pagenum=".$pagenum."&message=".MSG_EDIT_BOOKING_DETAIL_SUCCESS;
		}else{
			$insertedbooking_id = $ObjBookingDetailsMaster->addBookingDetails($BookingDetailsData,null,true);
			$UParam = "?pagenum=".$pagenum."&message=".MSG_ADD_BOOKING_DETAIL_SUCCESS;
		}
		header('Location:'.FILE_BOOKING_DETAILS_LISTING.$UParam);
		exit();
	}
}

/**
	 * Gets details for the user
	 */
$seaByArr = array();
$fieldArr = array();
$auto_id = $_GET['auto_id'];
/*
if(!empty($booking_id))
{
	$err['booking_id'] = chkTrk(valid_input($booking_id));
}
if(!empty($err['booking_id']))
{
	logOut();
}*/
//deleter the record
if($_GET['Action']=='trash'){
	$ObjBookingDetailsMaster->deleteBookingDetails($auto_id);
	$UParam = "?pagenum=".$pagenum."&message=".MSG_DELETE_BOOKING_DETAIL_SUCCESS;
	header('Location: '.FILE_BOOKING_DETAILS_LISTING.$UParam);
}
if(!empty($_GET['m_trash_id']))
{
	$err['m_trash_id'] = isNumeric(valid_input($_GET['m_trash_id']),ENTER_NUMERIC_VALUES_ONLY);
}
if(!empty($err['m_trash_id']))
{
	logOut();
}
if($_GET['Action']=='mtrash'){
$booking_id = $_GET['m_trash_id'];
	$m_t_a=explode(",",$booking_id);
	foreach($m_t_a as $val)
	{
		$ObjBookingDetailsMaster->deleteBookingDetails($val);
	}
	$UParam = "?pagenum=".$pagenum."&message=".MSG_DELETE_BOOKING_DETAIL_SUCCESS;
	header('Location: '.FILE_BOOKING_DETAILS_LISTING.$UParam);
}


	if($auto_id!='')
	{
		
		$seaByArr[]=array('Search_On'=>'auto_id', 'Search_Value'=>"$auto_id", 'Type'=>'int', 'Equation'=>'=', 'CondType'=>'and', 'Prefix'=>'', 'Postfix'=>'');
		$BookingDetails=$ObjBookingDetailsMaster->getBookingDetails($fieldArr,$seaByArr); // Fetch Data
		$BookingDetail = $BookingDetails[0];
		
		$btnSubmit = ADMIN_BUTTON_UPDATE_POSTCODE;
		$HeadingLabel = ADMIN_LINK_UPDATE_POSTCODE;
		$service_name = ($BookingDetail['service_name']=="")?(""):($BookingDetail['service_name']."_rate");
		$BookingDetail['volumetric_weight'] = ($BookingDetail['volumetric_weight']=="")?(0):($BookingDetail['volumetric_weight']);
		$toa = ($BookingDetail['total_qty']=="" || $BookingDetail['total_qty']==0)?(1):($BookingDetail['total_qty']);
		$common_height_width_length = floor(pow(($volumetric_divisor * $BookingDetail['volumetric_weight']),1/3)/($toa));
		/* code for listing the deliver to category on the basis of the flag start here */
		if(!empty($BookingDetail['flag']) && ($BookingDetail['flag']=='international')){
			//for international
			$display_style_australia = "style='display:none'";
			$display_style_international = 'block';
		}else{
			//for australia
			$display_style_australia = "style='visibility:visible'";
			$display_style_international = "none";
		}
	}else
	{
		$display_style_australia = "style='visibility:visible'";
		$display_style_international = "style='display:none'";
	}

	$flag_for_searching ="international";
	$seaByArrforPackage[]=array('Search_On'=>'type', 'Search_Value'=>$flag_for_searching, 'Type'=>'string', 'Equation'=>'like', 'CondType'=>'and', 'Prefix'=>'', 'Postfix'=>'');
	$package_type = $ObjInternationalMaster->getItemType($fieldArr,$seaByArrforPackage);
	$message = valid_input($arr_message1[$_GET["message"]]);
	if(!empty($message))
	{
		$err['MessageError'] = specialcharaChk($message);
	}
	if(!empty($err['MessageError']))
	{
		logOut();
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php if ($_GET['booking_id']=='') { echo ADMIN_ADD_BOOKING_DETAIL; } else { echo ADMIN_EDIT_BOOKING_DETAIL;}?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<?php
addCSSFileAdmin($arr_css_admin_include, $arr_css_admin_exclude);
addPluginCSSFile($arr_css_plugin_include,$arr_css_plugin_exclude);
addJavaScriptFile($arr_javascript_include, $arr_javascript_exclude);
addPluginJavaScriptFile($arr_javascript_plugin_include,$arr_javascript_plugin_exclude);
?>

</head>
<body >
<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
	<tr>
		<td valign="top">
		<?php require_once(DIR_WS_ADMIN_INCLUDES . ADMIN_FILE_HEADER);?>
		</td>
	</tr>	
	<!-- Start Middle Content part -->
	<tr>
		<td class="middle_content">
			<table width="100%" align="center" border="1" cellpadding="1" cellspacing="1">
				<tr>
					<td class="middle_left_content">
						<?php 
						// Include the Left Panel
						require_once(DIR_WS_ADMIN_INCLUDES . ADMIN_FILE_LEFT_MENU);
						?>
					</td>
					
					<td valign="top">
					<table class="middle_right_content" align="center" border="0" cellpadding="0" cellspacing="0">
							<tr>
								<td align="left" class="breadcrumb">
										<span><a href="<?php echo FILE_WELCOME_ADMIN; ?>"><?php echo ADMIN_HEADER_HOME; ?></a> > <a href="<?php echo FILE_BOOKING_DETAILS_LISTING; ?>"> <?php echo ADMIN_HEADER_BOOKING_DETAIL; ?> </a> > <? echo $HeadingLabel; ?></span>
										<div><label class="top_navigation"><a href="<?php echo FILE_BOOKING_DETAILS_LISTING; ?>"><?php echo ADMIN_COMMON_BACK; ?></a></label></div>
								</td>
							</tr>
							<tr>
								<td class="heading">
									<?php echo $HeadingLabel; ?>
								</td>
							</tr>
							
											
											<tr><td colspan="4">&nbsp;</td></tr>
											
											<?php
											
											if($message!='')
											{ ?>
											<tr>
												<td class="message_error noprint" align="center"><?php echo valid_output($message) ; ?></td>
											</tr>
											
											<?php }  ?>		
												
											
							<tr>
								<td align="center">
									<?php  /*** Start :: Listing Table ***/ ?>
									<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
										
										<form name="frmbookingdetails" method="POST"  action="" id="frmbookingdetails" onsubmit="javascript:return ValidateForm(this.form);">
										<input type="hidden" name="Id" value="<?php // echo $maximum_id[0];?>"  />
										<tr>
											<td>
												<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
													<tr>
														<td>
															<table width="98%" border="0" cellpadding="0" border="0" cellspacing="0" >
															<tr><td colspan="4">&nbsp;</td></tr>
															<tr><td colspan="4">&nbsp;</td></tr>
															<tr>
											<td colspan="4" align="left" valign="top" class="grayheader">
											<b><?php echo ADMIN_POSTCODE_UPLOAD_CSV;?> : </td>
											</tr>
											<tr><td colspan="4">&nbsp;</td></tr>
											<tr>
												<td class="message_mendatory" align="right" colspan="4">
													<?echo ADMIN_COMMAN_REQUIRED_INFO;?>
												</td>
											</tr>
																
											<tr>
												<td  align="left" valign="middle"><?php echo FLAG;?>&nbsp;</td>
												<td  align="left" valign="middle"  class="message_mendatory"><?php
											$flag_cond=	($_POST['flag']!="")?($_POST['flag']):($BookingDetail['flag']);
												$cont = '';
												$cont .= "<select name='flag' size='1' style='width: 50mm' id='flag' class='select_flag change_all_data' ><option value='' >Please Select Any One</option>";
												foreach ($flag as $ser){
													$cont .=  "<option  value='".$ser."'";
													$cont .= (
													
													$ser==$flag_cond )?("selected"):("");
													$cont .= ">".$ser."</option>";

												}
												$cont .="</select>";
												echo $cont ;
												?>
												
												
												<img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>internal/help_up.gif" class="help_btn" alt="<?php echo FLAG;?>" onmouseover="return overlib('<?php echo $Flag;?>');" onmouseout="return nd();" /></td>
												<td  align="left" valign="middle"><?php echo USER_ID;?></td>
												<td  align="left" valign="top" class="message_mendatory">
												<?php
												$user_cond=	($_POST['userid']!="")?($_POST['userid']):($BookingDetail['userid']);
												
												$fieldArr = array("userid","email");

												$PostCodedatas = $ObjUserMaster->getUserListing($fieldArr);
												$countryOutput.="<select name='userid'   id='pickup_chargingzone' size='1' style='width: 50mm' >
<option value=''>SELECT USER ID</option>";
												if($PostCodedatas!=''){
													foreach($PostCodedatas as $country_val)
													{			
													$cond = ($country_val["userid"]==$user_cond)?("selected"):('');
													$countryname=$country_val["email"];
													$countryOutput.='<option value="'.$country_val["userid"].'"';
													$countryOutput.=$cond;
													$countryOutput.='  >'.valid_output($countryname).'</option>';
													}
												}
												$countryOutput.="</select>";
												echo $countryOutput;
?><img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>internal/help_up.gif" class="help_btn" alt="<?php echo USER_ID;?>" onmouseover="return overlib('<?php echo $user_id;?>');" onmouseout="return nd();" />
												</td>
											</tr>
											<tr>
												<td align="left" valign="middle">&nbsp;</td>
												<td align="left" valign="top" class="message_mendatory" id="PickUpError"><?php echo $err['flagError'];  ?></td>
												<td align="left" valign="middle">&nbsp;</td>
												<td align="left" valign="top" class="message_mendatory" id="DeliverToError"><?php echo $err['useridError'];  ?></td>
											</tr>								

											<tr>
												<td  align="left" valign="middle"><?php echo PICKUP_FROM;?>&nbsp;</td>
												<td  align="left" valign="middle"  class="message_mendatory">
												<input type="hidden" name="current_active_id" id="current_active_id" value=""/>
												<input type="hidden" name="volumetric_divisor" id="volumetric_divisor" value="<?php echo $volumetric_divisor;?>"/>
												<input type="hidden" name="pickupzone" value="<?php echo ($_POST['pickupzone']!="")?(valid_output($_POST['pickupzone'])):("");?>" id="pickupzone" />
												<input type="hidden" name="pickupid" value="<?php echo ($_POST['pickupid']!="")?(valid_output($_POST['pickupid'])):($BookingDetail->pickupid);?>" id="pickupid" />
												<input type="hidden" name="fetchpickupid" value="<?php echo ($_POST['fetchpickupid']!="")?(valid_output($_POST['fetchpickupid'])):($BookingDetail->p_id);?>" id="fetchpickupid" />
												<?php
												 $pickupid_cond=	($_POST['fetchpickupid']!="")?(valid_output($_POST['fetchpickupid'])):(valid_output($BookingDetail['p_id']));
												?>										
												<input type="text" class="change_all_data pick_form_textbox_big"  name="PickupPostcode" id="pickup"   autocomplete="off" onkeyup="ajax_showOptions(this,'admin_search',event,'<?php echo DIR_HTTP_RELATED."tms_index.php"; ?>','ajax_index_listOfOptions');" style="<?php echo $css;?>" value="<?php if($_POST['PickupPostcode']!=""){echo $_POST['PickupPostcode'];}else{echo $BookingDetail['pickupid'];}?>"/><img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>internal/help_up.gif" class="help_btn" alt="<?php echo PICKUP_FROM;?>" onmouseover="return overlib('<?php echo $Pick_Up_From;?>');" onmouseout="return nd();" />-
												<span  id="deliverResult" name="deliverResult" class="autocomplete_index"></span></br>
												</td>
												<td  align="left" valign="middle"><?php echo DILIVER_TO;?></td>
												<td  align="left" valign="top" class="message_mendatory">										
												<input type="hidden" name="deliveryzone" value="<?php echo ($_POST['deliveryzone']!="")?(valid_output($_POST['deliveryzone'])):("");?>" id="deliveryzone" />
												<input type="hidden" name="deliveryid" value="<?php echo ($_POST['deliveryid']!="")?(valid_output($_POST['deliveryid'])):(valid_output($BookingDetail->deliveryid));?>" id="deliveryid" />
												<input type="hidden" name="fetchdeliveryid" value="<?php  echo ($_POST['fetchdeliveryid']!="")?(valid_output($_POST['fetchdeliveryid'])):(valid_output($BookingDetail->d_id));?>" id="fetchdeliveryid" />												
												<?php
												//for australia category
												
												$deliveryidforaustralia_cond=	($_POST['fetchdeliveryid']!="")?(valid_output($_POST['fetchdeliveryid'])):(valid_output($BookingDetail['d_id']));
												?>
												<input type="text" class="change_all_data pick_form_textbox_big" name="DeliveryPostcode" id="delivery" <?php echo $display_style_australia;?> autocomplete="off" onkeyup="ajax_showOptions(this,'admin_search',event,'<?php echo DIR_HTTP_RELATED."tms_index.php"; ?>','ajax_index_listOfOptions');" style="<?php echo $css;?>" value="<?php if($_POST['DeliveryPostcode']!=""){echo valid_output($_POST['DeliveryPostcode']);}else{echo valid_output($BookingDetail['deliveryid']);}?>"  />
												<span  id="deliverResult" name="deliverResult" class="autocomplete_index"></span></br>
												<?php
												//for international category
												
												$countryOutput ="";
												$selectCountryId=$BookingDetail->deliveryid;
												$deliveryidforinternational_cond=	($_POST['deliveryidforinternational']!="")?($_POST['deliveryidforinternational']):($selectCountryId);
												$fieldArr = array("countries_id","countries_name","days");
												$seaArr=array();
	$seaArr[] = array('Search_On'=>'status','Search_Value'=>'A', 'Type'=>'string', 'Equation'=>'=', 'CondType'=>'AND', 'Prefix'=>'', 'Postfix'=>'');
												$CountryData = $CountryMasterObj->getCountry($fieldArr,$seaArr);
												
												$countryOutput.="<select name='deliveryidforinternational' class ='pick_form_textbox_index' size='1' style='width: 50mm;display:$display_style_international' id='deliveryidforinternational' ><option>SELECT COUNTRY</option>";
												foreach($CountryData as $country_val)
												{
													$cond = ($country_val["countries_id"]==$deliveryidforinternational_cond)?("selected"):('');
													$cond .= " rel='".$country_val["countries_id"]."'";
													$countryname=$country_val["countries_name"]."(".$country_val['days'].")";
													$countryOutput.='<option value="'.$country_val["countries_id"].'"';
													$countryOutput.=$cond;
													$countryOutput.='>'.valid_output($countryname).'</option>';
												}
												$countryOutput.="</select>";
												echo $countryOutput;?><img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>internal/help_up.gif" class="help_btn" alt="<?php echo DILIVER_TO;?>" onmouseover="return overlib('<?php echo $Deliver_To;?>');" onmouseout="return nd();" />
												</td>
											</tr>
											<tr>
												<td align="left" valign="middle">&nbsp;</td>
												<td align="left" valign="top" class="message_mendatory" id="pickupidError"><?php echo $err['pickupidError'];  ?></td>
												<td align="left" valign="middle">&nbsp;</td>
												<td align="left" valign="top" class="message_mendatory" id="deliveryidError"><?php echo $err['deliveryidError'];  ?></td>
											</tr>
											<tr>
											<?php 
					if(isset($_POST['pickup_location_type']) && $_POST['pickup_location_type']==1)
					{
						$pickupchk = "checked='checked'";
					}elseif(isset($BookingDetail->pickup_location_type) && $BookingDetail->pickup_location_type==1){ 
						$pickupchk = "checked='checked'";
					}
					if(isset($_POST['pickup_location_type']) && $_POST['pickup_location_type']!="")
					{
						$pickup_loction_type = $_POST['pickup_location_type'];
						//$pickupchk = "checked='checked'";
					}elseif(isset($BookingDetail->pickup_location_type) && $BookingDetail->pickup_location_type!=""){ 
						$pickup_loction_type = $BookingDetail->pickup_location_type; 
						//$pickupchk = "checked='checked'";
					}else{ 
						$pickup_loction_type = 1;
					} 
				 
				 ?>
												<td><?php echo COMMON_RESIDENTIAL; ?></td>
												<td><input type="checkbox" name="pickup_location_type" id="pickup_location_type" class="control-label" value="<?php echo $pickup_loction_type; ?>" <?php echo $pickupchk; ?>  /></td>
												<td><?php echo COMMON_RESIDENTIAL; ?></td>
												<?php 
						
											if(isset($_POST['delivery_location_type']) && $_POST['delivery_location_type']==1)
											{
												
												$deliverychk = "checked='checked'";
											}elseif(isset($BookingDetail->delivery_location_type) && $BookingDetail->delivery_location_type==1){ 
												$deliverychk = "checked='checked'";
											}					
											 
											if(isset($_POST['delivery_location_type']) && $_POST['delivery_location_type']!="")
											{
												$delivery_location_type = $_POST['delivery_location_type'];
												
											}elseif(isset($BookingDetail->delivery_location_type) && $BookingDetail->delivery_location_type!=""){ 
												$delivery_location_type = $BookingDetail->delivery_location_type; 
												//$deliverychk = "checked='checked'";
											}else{ 
												$delivery_location_type = 1;
											} 
					 
											?>
												<td><input type="checkbox" name="delivery_location_type" id="delivery_location_type" class="control-label"  value="<?php echo $delivery_location_type; ?>" <?php echo $deliverychk; ?>/></td>
											</tr>
																			
		
											<tr>
												<td  align="left" valign="middle"><?php echo WEBSERVICE;?>&nbsp;</td>
													<td  align="left" valign="middle"  class="message_mendatory">
													<input type="hidden" value="<?php echo ($_POST['webservice']!="")?($_POST['webservice']):(valid_output($BookingDetail->webservice));
													?>" name="webservice" id="webservice"/>
													<input type="text" disabled="true" name='tempwebservice' value="<?php echo ($_POST['tempwebservice']!="")?(valid_output($_POST['tempwebservice'])):(valid_output($BookingDetail->webservice));
													?>" id='tempwebservice' />
													<img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>internal/help_up.gif" class="help_btn" alt="<?php echo WEBSERVICE;?>" onmouseover="return overlib('<?php echo $Webservice;?>');" onmouseout="return nd();" />
													
												</td>
												
												<td  align="left" valign="middle" id="hide_package_type" class="hide_package_type" >
												</td>
												<td  align="left" valign="top" id="hide_package_type" class="hide_package_type" class="message_mendatory" style="color: red; ">
													
													</td>
												
												
									</tr>
									<tr>
										<td align="left" valign="middle">&nbsp;</td>
										<td align="left" valign="top" class="message_mendatory" id="serviceError"><?php echo $err['serviceError'];  ?></td>
										<td align="left" valign="middle">&nbsp;</td>
										<td align="left" valign="top" class="message_mendatory" id="description_of_goodsError"><?php echo $err['description_of_goods'];  ?></td>
									</tr>	
									
									
									<tr>
												<td  align="left" valign="middle"  class="hidedistance_in_km" <?php echo $display_style_australia;?>><?php echo DISTANCEINKM;?>&nbsp;</td>
												<td  align="left" valign="middle"  class=" hidedistance_in_km message_mendatory"  class="hidedistance_in_km" <?php echo $display_style_australia;?> >
												<input  type="text" id="distance_in_km" class="input_consignor" name="distance_in_km" value="<?php if($BookingDetail['distance_in_km']==""){echo $_POST['distance_in_km'];}else{ echo $BookingDetail['distance_in_km'];}?>" /></span><img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>internal/help_up.gif" class="help_btn" alt="Flag" onmouseover="return overlib('<?php echo $Distance_Km;?>');" onmouseout="return nd();" />
										    	<td  align="left" valign="middle"><?php echo TOTAL_QUENTITY;?></td>
												<td  align="left" valign="top" class="message_mendatory">
												<input  type="text" class="input_consignor" id="total_qty" name="total_qty"  value="<?php if($_POST['total_qty']==""){echo $BookingDetail['total_qty'];}else{ echo $_POST['total_qty'];}?>" onblur="javascript:display_all_value(<?php echo $volumetric_divisor;?>);"/><img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>internal/help_up.gif" class="help_btn" alt="<?php echo TOTAL_QUENTITY;?>" onmouseover="return overlib('<?php echo $Total_Quentity;?>');" onmouseout="return nd();" /></td>
									</tr>
									
										
									<tr>
										<td align="left" valign="middle">&nbsp;</td>
										<td align="left" valign="top" class="message_mendatory" ><?php if(isset($err['distance_in_km']) && $err['distance_in_km']!= ''){ echo $err['distance_in_km'];} ?></td>
										<td align="left" valign="middle" class="message_mendatory"></td>
										<td align="left" valign="top" class="message_mendatory" ><?php if(isset($err['total_qty']) && $err['total_qty']!=''){echo $err['total_qty'];}?></td>
									</tr>								
									<tr><td colspan="4">&nbsp;</td></tr>
									<tr>				
										<td  align="left" valign="middle"><?php echo HEIGHT;?></td>
											<td  align="left" valign="top" class="message_mendatory"><input  type="text" id="height" class="input_consignor" name="height" value="<?php echo ($_POST['height']=="")?($common_height_width_length):($_POST['height']);?>" onblur="javascript:display_all_value(<?php echo $volumetric_divisor;?>);"/><img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>internal/help_up.gif" class="help_btn" alt="<?php echo HEIGHT;?>" onmouseover="return overlib('<?php echo $Height;?>');" onmouseout="return nd();" /></td>
										
											<td  align="left" valign="middle"><?php echo WIDTH;?></td>
											<td  align="left" valign="top" class="message_mendatory"><input  type="text" id="width" class="input_consignor" name="width" value="<?php echo ($_POST['width']=="")?($common_height_width_length):($_POST['width']);?>" onblur="javascript:display_all_value(<?php echo $volumetric_divisor;?>);"/><img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>internal/help_up.gif" class="help_btn" alt="<?php echo WIDTH;?>" onmouseover="return overlib('<?php echo $Width;?>');" onmouseout="return nd();" /></td>
									</tr>
									<tr>
											<td align="left" valign="middle">&nbsp;</td>
											<td align="left" valign="top" class="message_mendatory" ><?php if(isset($err['height']) && $err['height']!=''){ echo $err['height'];}  ?></td>
											<td align="left" valign="middle">&nbsp;</td>
											<td align="left" valign="top" class="message_mendatory" ><?php if(isset($err['width']) && $err['width']!=''){ echo $err['width'];}  ?></td>
									</tr>				
									<tr>
											<td  align="left" valign="middle"><?php echo LENGTH;?></td>
												<td   align="left" valign="top" class="message_mendatory"><input  type="text" id="length" class="input_consignor" name="length" value="<?php echo ($_POST['length']!="")?($_POST['length']):($common_height_width_length);?>" onblur="javascript:display_all_value(<?php echo $volumetric_divisor;?>);"/><img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>internal/help_up.gif" class="help_btn" alt="<?php echo LENGTH;?>" onmouseover="return overlib('<?php echo $Length;?>');" onmouseout="return nd();" /></td>
												
												
												<td  align="left" valign="middle"><?php echo ITEM_WEIGHT;?>&nbsp;</td>
												<td  align="left" valign="middle"  class="message_mendatory">
				
												<input type="hidden" name="item_weight" id="item_weight" value="<?php if($_POST['item_weight']==""){echo ceil($item);}else{ echo $_POST['item_weight'];}?>" onblur="javascript:display_all_value(<?php echo $volumetric_divisor;?>);"/>
												
					<?php if($BookingDetail['total_qty']!="" && $BookingDetail['total_qty']>= 1 && $BookingDetail['total_weight']!=""){$item = $BookingDetail['total_weight']/$BookingDetail['total_qty'];}
			
				?>							
					
												
												<input  type="text" class="input_consignor" id="australia_item_weight" name="australia_item_weight" value="<?php if($_POST['australia_item_weight']!=""){echo $_POST['australia_item_weight'];}else{ echo $item;}?>"  onblur="javascript:display_all_value(<?php echo $volumetric_divisor;?>);"/><img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>internal/help_up.gif" class="help_btn" alt="<?php echo ITEM_WEIGHT;?>" onmouseover="return overlib('<?php echo $Item_Weight ;?>');" onmouseout="return nd();" />
												</td>		
									</tr>
									<tr>
											<td align="left" valign="middle">&nbsp;</td>
											<td align="left" valign="middle" class="message_mendatory"><?php if(isset($err['length']) && $err['length']!=''){ echo $err['length'];} ?>&nbsp;</td>
											<td align="left" valign="middle">&nbsp;</td>
											<td align="left" valign="middle" class="message_mendatory"><?php if(isset($err['item_weight']) && $err['item_weight']!=''){ echo $err['item_weight'];} ?>&nbsp;</td>
											<td align="left" valign="top" class="message_mendatory" id="PickUpError" colspan="2"><?php   ?></td>
									</tr>	
																
									<tr>
									<td colspan="4">&nbsp;</td>
									</tr>
																
									<tr>
									<td  align="left" valign="middle"><?php echo VOLUMETRIC_WEIGHT;?></td>
										<td  align="left" valign="top" class="message_mendatory">
										<input  type="text" class="input_consignor" id="volumetric_weight" name="volumetric_weight" value="<?php if($_POST['volumetric_weight']==""){echo $BookingDetail['volumetric_weight'];}else{ echo $_POST['volumetric_weight'];}?>" /><img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>internal/help_up.gif" class="help_btn" alt="<?php echo VOLUMETRIC_WEIGHT;?>" onmouseover="return overlib('<?php echo $Volumetric_Weight;?>');" onmouseout="return nd();" /></td>
									
										
									
										<td  align="left" valign="middle"><?php echo TOTAL_WEIGHT;?></td>
										<td  align="left" valign="top" class="message_mendatory"><input readonly="true" type="text" class="input_consignor" id="total_weight" name="total_weight" value="<?php if($_POST['total_weight']==""){echo $BookingDetail['total_weight'];}else{ echo $_POST['total_weight'];}?>"  />
										<img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>internal/help_up.gif" class="help_btn" alt="<?php echo TOTAL_WEIGHT;?>" onmouseover="return overlib('<?php echo $Total_Weight;?>');" onmouseout="return nd();" />
										</td>	
										
									</tr>
									<tr>
									<td align="left" valign="middle">&nbsp;</td>
										<td align="left" valign="top" class="message_mendatory" id="DeliverToError"><?php echo $err['volumetric_weightError'];  ?></td>
										<td align="left" valign="middle">&nbsp;</td>
										<td align="left" valign="top" class="message_mendatory" id="PickUpError"><?php echo $err['total_weightError'];  ?></td>
										
									</tr>								

									
									
									<tr>
										
										<td  align="left" valign="middle"><?php echo SERVICE;?>&nbsp;</td>
										<td  align="left" valign="middle"  class="message_mendatory">
										<input id="service_name" type="hidden" name="service_name" value="<?php echo $BookingDetail['service_name'];?>"/>
										<?php
										$cont = '';
									//	echo $BookingDetail['service_name'];die();
										$service_cond=	($_POST['service']!="")?($_POST['service']):($BookingDetail['service_name']);
										$cont .= "<select name='service' id='service' ><option value=''>Please Select Any One</option>";
										foreach ($service as $key => $value){
											$cont .=  "<option value='".$key."'";
											$cont .= ($value==$service_cond)?("selected"):("");
											$cont .= ">".$value."</option>";

										}
										$cont .="</select>";
										echo $cont ;
										?>
										<img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>internal/help_up.gif" class="help_btn" alt="<?php echo SERVICE;?>" onmouseover="return overlib('<?php echo $Service;?>');" onmouseout="return nd();" />
										</td>
										
										
												
									<td  align="left" valign="middle"><?php echo ADMIN_DELIVER_FEE; ?></td>
									<td  colspan="3" align="left" valign="top" class="message_mendatory"><input type="text" name="delivery_fee" value="<?php echo $BookingDetail['delivery_fee'];  ?>"></td>
									
									</tr>
									<tr>
										<td align="left" valign="middle">&nbsp;</td>
										<td align="left" valign="top" class="message_mendatory" id="PickUpError"><?php echo $err['serviceError'];  ?></td>
										<td align="left" valign="middle">&nbsp;</td>
										<td align="left" valign="top" class="message_mendatory" id="DeliverToError"><?php echo $err['payment_doneError'];  ?></td>
									</tr>		
									<tr>
										<td  align="left" valign="middle"><?php echo DESCRIPTION_OF_GOODS;?>&nbsp;</td>
										<td  align="left" valign="middle"  class="message_mendatory">
										<textarea class="input_consignor" name="description_of_goods" ><?php if($BookingDetail['description_of_goods']==""){echo $_POST['description_of_goods'];}else{ echo valid_output($BookingDetail['description_of_goods']);}?></textarea>								
										<span id="temp_additional_cost">
										<input  type="hidden" class="input_consignor" name="additional_cost" id="additional_cost" value="<?php if($BookingDetail['additional_cost']==""){echo $_POST['additional_cost'];}else{ echo $BookingDetail['additional_cost'];}?>" />
										</span>
										<img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>internal/help_up.gif" class="help_btn" alt="<?php echo DESCRIPTION_OF_GOODS;?>" onmouseover="return overlib('<?php echo valid_output($Description_Of_Goods);?>');" onmouseout="return nd();" />
										</td>
										<td  align="left" valign="middle" class="hidepro_froma_invoice"><?php echo PRO_FORMA_INVOICE;?>&nbsp;</td>
										<td  align="left"  class="hidepro_froma_invoice message_mendatory" <?php echo $display_style_international;?>><?php
										/*$cont = '';
										$cont .= "<select name='pro_froma_invoice' id='pro_froma_invoice'><option value=''>Please Select Any One</option>";
										foreach ($pro_froma_invoice as $key => $val){

											$cont .=  "<option value='".$val."'";
											$cont .= ($BookingDetail['pro_froma_invoice']=="$val" )?("selected"):("");
											$cont .= ">".valid_output($val)."</option>";

										}
										$cont .="</select>";
										echo $cont ; */
										?>
										</span><img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>internal/help_up.gif" class="help_btn" alt="<?php echo DISTANCEINKM;?>" onmouseover="return overlib('<?php echo $pro_form_invoice;?>');" onmouseout="return nd();" /></div>
										
										</td>
										
									</tr>
									<tr>
										<td align="left" valign="middle">&nbsp;</td>
										<td align="left" valign="top" class="message_mendatory" id="PickUpError"><?php   ?></td>
										<td align="left" valign="middle">&nbsp;</td>
										<td align="left" valign="top" class="message_mendatory" id="DeliverToError"><?php   ?></td>
									</tr>	
									<tr>
										<td align="left" valign="middle">&nbsp;</td>
										<td align="left" valign="top" ></td>
										<td align="left" valign="middle"><?php echo ADMIN_FUEL_FEE; ?>&nbsp;</td>
										<td align="left" valign="top" ><input type="text" name="fuel_surcharge" value="<?php echo $BookingDetail['fuel_surcharge']; ?>" ?></td>
									</tr>	
									
									<tr>
										<td align="left" valign="middle">&nbsp;</td>
										<td align="left" valign="top" ></td>
										<td align="left" valign="middle"><?php echo ADMIN_SERVICE_FEE; ?>&nbsp;</td>
										<td align="left" valign="top" ><input type="text" name="service_surcharge" value="<?php echo $BookingDetail['service_surcharge']; ?>" ?></td>
									</tr>
									<tr>
										<td align="left" valign="middle">&nbsp;</td>
										<td align="left" valign="top" ></td>
										<td align="left" valign="middle"><?php echo ADMIN_TOTAL_DELIVERY_CHARGE; ?>&nbsp;</td>
										<td align="left" valign="top" ><input type="text" name="total_delivery_fee" value="<?php echo $BookingDetail['total_delivery_fee']; ?>" ?></td>
									</tr>
									<tr>
										<td align="left" valign="middle">&nbsp;</td>
										<td align="left" valign="top" ></td>
										<td align="left" valign="middle"><?php echo ADMIN_DISCOUNT; ?>&nbsp;</td>
										<td align="left" valign="top" ><input type="text" name="discount" value="<?php echo $BookingDetail['discount']; ?>" ?></td>
									</tr>
									<tr>
										<td align="left" valign="middle">&nbsp;</td>
										<td align="left" valign="top" ></td>
										<td align="left" valign="middle"><?php echo ADMIN_TOTAL_DELIVERY_CHARGE; ?>&nbsp;</td>
										<td align="left" valign="top" ><input type="text" name="total_dis_delivery_fee" value="<?php echo $BookingDetail['total_dis_delivery_fee']; ?>" ?></td>
									</tr>
									
									<tr>
										<td  align="left" valign="middle"  ><?php //echo TRANSIENT_WARRENTY;?>&nbsp;</td>
										<td  align="left" valign="middle"  class="  message_mendatory" >
											<!--<input type="radio" tabindex="5" name="transit_warranty" id="transit_warranty" value="yes" <?php //if ($BookingDetail->tansient_warranty=="yes"){echo "checked";}?> onclick="javascript:common_hide(this.name,this.value);">Yes <input type="radio" tabindex="6"  name="transit_warranty" id="transit_warranty"  value="no" <?php //if ($BookingDetail->tansient_warranty=="no" || $BookingDetail->tansient_warranty==""){echo "checked";}?> onclick="javascript:common_hide(this.name,this.value);" > No<img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>internal/help_up.gif" class="help_btn" alt="<?php echo TRANSIENT_WARRENTY;?>" onmouseover="return overlib('<?php //echo $Transient_Warrenty;?>');" onmouseout="return nd();" />-->
										<?php
											/*echo "<pre>";
											print_r($BookingDetail);
											echo "</pre>";*/
										?>
										</td>
											
										<td  align="left" valign="middle" class="hide_authority_to_leave"><?php echo AUTHORITY_TO_LIVE;?></td>
										<td  align="left" valign="top" class="message_mendatory hide_authority_to_leave"><input type="radio" tabindex="5" name="authority_to_leave" id="authority_to_leave" value="yes" <?php if ($BookingDetail->authority_to_leave=="yes"){echo "checked";}?> onclick="javascript:common_hide(this.name,this.value);">Yes <input type="radio" tabindex="6"  name="authority_to_leave" id="authority_to_leave"  value="no" <?php if ($BookingDetail->authority_to_leave=="no" || $BookingDetail->authority_to_leave==""){echo "checked";}?> onclick="javascript:common_hide(this.name,this.value);" > No 
											<img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>internal/help_up.gif" class="help_btn" alt="<?php echo  AUTHORITY_TO_LIVE;?>" onmouseover="return overlib('<?php echo $Authority_live;?>');" onmouseout="return nd();" />
										</td>
											
									</tr>
									<tr>
										<td align="left" valign="middle">&nbsp;</td>
										<td align="left" valign="top" class="message_mendatory" id="PickUpError"><?php   ?></td>
										<td align="left" valign="middle">&nbsp;</td>
										<td align="left" valign="top" class="message_mendatory" id="DeliverToError"><?php   ?></td>
									</tr>
									<tr>
										<td  align="left" valign="middle" class="hide_values_of_goods"><?php echo VALUES_OF_GOODS;?></td>
										<td  align="left" valign="top" class="message_mendatory hide_values_of_goods">
										<!--<input type="hidden" name="minimum_transient_value" id="minimum_transient_value" value="<?php //echo $minimum_transient_value;?>"/>
										<input type="hidden" name="coverage_rate" id="coverage_rate" value="<?php //if($BookingDetail['coverage_rate']==""){echo $_POST['coverage_rate'];}else{ echo valid_output($BookingDetail['coverage_rate']);}?>"?>
										<input  type="text" class="input_consignor" name="values_of_goods" id="values_of_goods" value="<?php //if($BookingDetail['values_of_goods']==""){echo $_POST['values_of_goods'];}else{ echo valid_output($BookingDetail['values_of_goods']);}?>" onblur="javascript:change_tempcoverage_rate(<?php echo $minimum_transient_value;?>)"/>-->									</td>
										</td>
										<td  align="left" valign="middle" class="hide_values_of_goods"><?php echo COVERAGE_FEE;?></td>
										<td  align="left"  class="message_mendatory hide_values_of_goods"><b>$<span id="tempcoverage_rate"><?php //echo $BookingDetail['coverage_rate']?></span>		
										</td>
											
									</tr>
									<tr>
										<td align="left" valign="middle">&nbsp;</td>
										<td align="left" valign="top" class="message_mendatory" id="PickUpError"><?php   ?></td>
										<td align="left" valign="middle">&nbsp;</td>
										<td align="left" valign="top" class="message_mendatory" id="DeliverToError"><?php   ?></td>
									</tr>
									<tr>
												<td  align="left" valign="middle"  class="temp_where_to_leave_shipment" style="display:none"><?php echo WHERE_TO_LIVE_SHIPMENT;?>&nbsp;</td>
												<td  align="left" valign="middle"  class=" temp_where_to_leave_shipment message_mendatory" style="display:none" >
												<textarea class="input_consignor"  class="temp_where_to_leave_shipment" name="where_to_leave_shipment" id="where_to_leave_shipment" > <?php if($BookingDetail['where_to_leave_shipment']==""){echo $_POST['where_to_leave_shipment'];}else{ echo valid_output($BookingDetail['where_to_leave_shipment']);}?></textarea>	
												</td>
													
										    	<td  align="left" valign="middle" class="temp_where_to_leave_shipment" style="display:none">&nbsp;</td>
												<td  align="left" valign="top" class="message_mendatory temp_where_to_leave_shipment" style="display:none">&nbsp;</span>		
												</td>
													
											</tr>							
											
										<tr>
											<td align="left" valign="middle">&nbsp;</td>
											<td align="left" valign="top" class="message_mendatory" id="PickUpError"><?php   ?></td>
											<td align="left" valign="middle">&nbsp;</td>
											<td align="left" valign="top" class="message_mendatory" id="DeliverToError"><?php  ?></td>
										</tr>
<tr>
										<td align="left" valign="middle">&nbsp;</td>
										<td align="left" valign="top" ></td>
										<td align="left" valign="middle"><?php echo ADMIN_TOTAL_NEW_CHARGE; ?>&nbsp;</td>
										<td align="left" valign="top" ><input type="text" name="total_new_charge" value="<?php echo $BookingDetail['total_new_charge']; ?>" ?></td>
									</tr>
									<tr>
										<td align="left" valign="middle">&nbsp;</td>
										<td align="left" valign="top" ></td>
										<td align="left" valign="middle"><?php echo ADMIN_TOTAL_GST; ?>&nbsp;</td>
										<td align="left" valign="top" ><input type="text" name="gst_surcharge" value="<?php echo $BookingDetail['gst_surcharge']; ?>" ?></td>
									</tr>
										<tr>
											<td></td>
											<td></td>
											<td><?php echo RATE;?></td>
											<td><input  type="text" id="rate" class="input_consignor" name="rate" value="<?php echo ($_POST['rate']!="")?($_POST['rate']):($BookingDetail['rate']);?>" /><img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>internal/help_up.gif" class="help_btn" alt="<?php echo RATE;?>" onmouseover="return overlib('<?php echo $Rate;?>');" onmouseout="return nd();" /></td>
										</tr>										
										<tr><td colspan="4">&nbsp;</td></tr>				
										<tr>
											<td colspan="4" align="left" valign="top" class="grayheader">
											<b><?php echo BOOKING_FORM;?> : </td>
											</tr>
											<tr><td colspan="4">&nbsp;</td>
										</tr>											
																
																
										<tr>
											<td  align="left" valign="middle"><?php echo SENDER_FIRST_NAME;?>&nbsp;</td>
											<td  align="left" valign="middle"  class="message_mendatory"><input  type="text" class="input_consignor" name="sender_first_name" value="<?php if($BookingDetail['sender_first_name']==""){echo $_POST['sender_first_name'];}else{ echo valid_output($BookingDetail['sender_first_name']);}?>" />
											<img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>internal/help_up.gif" class="help_btn" alt="<?php echo  SENDER_FIRST_NAME;?>" onmouseover="return overlib('<?php echo $FirstName;?>');" onmouseout="return nd();" />
											</td>
											<td  align="left" valign="middle"><?php echo RECEIVER_FIRST_NAME;?></td>
											<td  align="left" valign="top" class="message_mendatory"><input  type="text" class="input_consignor" name="reciever_first_name" value="<?php if($BookingDetail['reciever_firstname']==""){echo $_POST['reciever_first_name'];}else{ echo valid_output($BookingDetail['reciever_firstname']);}?>" />
										<img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>internal/help_up.gif" class="help_btn" alt="<?php echo  RECEIVER_FIRST_NAME;?>" onmouseover="return overlib('<?php echo $FirstName;?>');" onmouseout="return nd();" />	
											</td>
										</tr>
										<tr>
											<td align="left" valign="middle">&nbsp;</td>
											<td align="left" valign="top" class="message_mendatory" id="PickUpError"><?php echo $err['sender_first_nameError'];  ?></td>
											<td align="left" valign="middle">&nbsp;</td>
											<td align="left" valign="top" class="message_mendatory" id="DeliverToError"><?php echo $err['reciever_first_nameError'];  ?></td>
										</tr>								

										
										<tr>
											<td  align="left" valign="middle"><?php echo SENDER_SURNAME;?>&nbsp;</td>
											<td  align="left" valign="middle"  class="message_mendatory"><input  type="text" class="input_consignor" name="sender_surname" value="<?php if($BookingDetail['sender_surname']==""){echo $_POST['sender_surname'];}else{ echo valid_output($BookingDetail['sender_surname']);}?>" /><img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>internal/help_up.gif" class="help_btn" alt="<?php echo  SENDER_SURNAME;?>" onmouseover="return overlib('<?php echo $LastName;?>');" onmouseout="return nd();" />
											
											</td>
											<td  align="left" valign="middle"><?php echo RECEIVER_SURNAME;?></td>
											<td  align="left" valign="top" class="message_mendatory"><input  type="text" class="input_consignor" name="reciever_surname" value="<?php if($BookingDetail['reciever_surname']==""){echo $_POST['reciever_surname'];}else{ echo valid_output($BookingDetail['reciever_surname']);}?>" />
											<img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>internal/help_up.gif" class="help_btn" alt="<?php echo  RECEIVER_SURNAME;?>" onmouseover="return overlib('<?php echo $LastName;?>');" onmouseout="return nd();" />
											</td>
										</tr>
										<tr>
											<td align="left" valign="middle">&nbsp;</td>
											<td align="left" valign="top" class="message_mendatory" id="PickUpError"><?php echo $err['sender_surnameError'];  ?></td>
											<td align="left" valign="middle">&nbsp;</td>
											<td align="left" valign="top" class="message_mendatory" id="DeliverToError"><?php echo $err['reciever_surnameError'];  ?></td>
										</tr>								

										
										<tr>
											<td  align="left" valign="middle"><?php echo SENDER_COMPANY_NAME;?>&nbsp;</td>
											<td  align="left" valign="middle"  class="message_mendatory"><input  type="text" class="input_consignor" name="sender_company_name" value="<?php if($BookingDetail['sender_company_name']==""){echo $_POST['sender_company_name'];}else{ echo valid_output($BookingDetail['sender_company_name']);}?>" />
											<img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>internal/help_up.gif" class="help_btn" alt="<?php echo  SENDER_COMPANY_NAME;?>" onmouseover="return overlib('<?php echo $CompanyName;?>');" onmouseout="return nd();" />
											</td>
											<td  align="left" valign="middle"><?php echo RECEIVER_COMPANY_NAME;?></td>
											<td  align="left" valign="top" class="message_mendatory"><input  type="text" class="input_consignor" name="reciever_company_name" value="<?php if($BookingDetail['reciever_company_name']==""){echo $_POST['reciever_company_name'];}else{ echo valid_output($BookingDetail['reciever_company_name']);}?>" />
											<img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>internal/help_up.gif" class="help_btn" alt="<?php echo  RECEIVER_COMPANY_NAME;?>" onmouseover="return overlib('<?php echo $CompanyName;?>');" onmouseout="return nd();" />
											</td>
										</tr>
										<tr>
											<td align="left" valign="middle">&nbsp;</td>
											<td align="left" valign="top" class="message_mendatory" id="PickUpError"><?php echo $err['sender_company_nameError'];  ?></td>
											<td align="left" valign="middle">&nbsp;</td>
											<td align="left" valign="top" class="message_mendatory" id="DeliverToError"><?php echo $err['reciever_company_nameError'];  ?></td>
										</tr>								
										<tr>
											<td  align="left" valign="middle"><?php echo SENDER_ADDRESS;?></td>
											<td  align="left" valign="middle"  class="message_mendatory"><input type="text" class="input_consignor" name="sender_address_1" value="<?php if($BookingDetail['sender_address_1']==""){echo $_POST['sender_address_1'];}else{echo valid_output($BookingDetail['sender_address_1']);} ?>"/>
											<img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>internal/help_up.gif" class="help_btn" alt="<?php echo  SENDER_ADDRESS;?>" onmouseover="return overlib('<?php echo $Address;?>');" onmouseout="return nd();" />
											</td>
											<td  align="left" valign="middle"><?php echo RECEIVER_ADDRESS;?></td>
											<td  align="left" valign="top" class="message_mendatory"><input type="text" class="input_consignee" name="reciever_address_1" value="<?php if($BookingDetail['reciever_address_1']==""){echo $_POST['reciever_address_1'];}else{echo valid_output($BookingDetail['reciever_address_1']);} ?>"/>
											<img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>internal/help_up.gif" class="help_btn" alt="<?php echo  RECEIVER_ADDRESS;?>" onmouseover="return overlib('<?php echo $Address;?>');" onmouseout="return nd();" />
											</td>
										</tr>
										<tr>
											<td align="left" valign="middle">&nbsp;</td>
											<td align="left" valign="top" class="message_mendatory" id="PickUpError"><?php echo $err['sender_address_1Error'];?></td>
											<td align="left" valign="middle">&nbsp;</td>
											<td align="left" valign="top" class="message_mendatory" id="DeliverToError"><?php echo $err['reciever_address_1Error'];?></td>
										</tr>	
										
										<tr>
											<td  align="left" valign="middle"></td>
											<td  align="left" valign="middle"  class="message_mendatory"><input type="text" class="input_consignor" name="sender_address_2" value="<?php if($BookingDetail['sender_address_2']==""){echo valid_output($_POST['sender_address_2']);}else{echo valid_output($BookingDetail['sender_address_2']);} ?>"/></td>
											<td  align="left" valign="middle"></td>
											<td  align="left" valign="top" class="message_mendatory"><input type="text" class="input_consignee" name="reciever_address_2" value="<?php if($BookingDetail['reciever_address_2']==""){echo valid_output($_POST['reciever_address_2']);}else{echo valid_output($BookingDetail['reciever_address_2']);} ?>"/></td></td>
										</tr>
										<tr>
											<td align="left" valign="middle">&nbsp;</td>
											<td align="left" valign="top" class="message_mendatory" id="PickUpError"></td>
											<td align="left" valign="middle">&nbsp;</td>
											<td align="left" valign="top" class="message_mendatory" id="DeliverToError"></td>
										</tr>	
										
										<tr>
											<td  align="left" valign="middle"></td>
											<td  align="left" valign="middle"  class="message_mendatory"><input type="text" class="input_consignor" name="sender_address_3" value="<?php if($BookingDetail['sender_address_3']==""){echo $_POST['sender_address_3'];}else{echo valid_output($BookingDetail['sender_address_3']);} ?>"/></td>
											<td  align="left" valign="middle"></td>
											<td  align="left" valign="top" class="message_mendatory"><input type="text" class="input_consignee" name="reciever_address_3" value="<?php if($BookingDetail['reciever_address_3']==""){echo $_POST['reciever_address_3'];}else{echo valid_output($BookingDetail['reciever_address_3']);} ?>"/></td>
										</tr>
										<tr>
											<td align="left" valign="middle">&nbsp;</td>
											<td align="left" valign="top" class="message_mendatory" id="PickUpError"></td>
											<td align="left" valign="middle">&nbsp;</td>
											<td align="left" valign="top" class="message_mendatory" id="DeliverToError"></td>
										</tr>	
										
										<tr>
											<td  align="left" valign="middle"><?php echo SENDER_SUBURB;?></td>
											<td  align="left" valign="middle"  class="message_mendatory"><input type="text" class="input_consignor" name="sender_suburb" value="<?php if($BookingDetail['sender_suburb']==""){echo $_POST['sender_suburb'];}else{echo valid_output($BookingDetail['sender_suburb']);} ?>"/><img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>internal/help_up.gif" class="help_btn" alt="<?php echo  SENDER_SUBURB;?>" onmouseover="return overlib('<?php echo $SuburbName;?>');" onmouseout="return nd();" />
											
											</td>
											<td  align="left" valign="middle"><?php echo RECEIVER_SUBURB;?></td>
											<td  align="left" valign="top" class="message_mendatory"><input type="text" class="input_consignee" name="reciever_suburb" value="<?php if($BookingDetail['reciever_suburb']==""){echo $_POST['reciever_suburb'];}else{echo valid_output($BookingDetail['reciever_suburb']);} ?>"/><img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>internal/help_up.gif" class="help_btn" alt="<?php echo  RECEIVER_SUBURB;?>" onmouseover="return overlib('<?php echo $SuburbName;?>');" onmouseout="return nd();" />
											
											</td>
										</tr>
										<tr>
											<td align="left" valign="middle">&nbsp;</td>
											<td align="left" valign="top" class="message_mendatory" id="PickUpError"><?php echo $err['sender_suburbError'];  ?></td>
											<td align="left" valign="middle">&nbsp;</td>
											<td align="left" valign="top" class="message_mendatory" id="DeliverToError"><?php echo $err['reciever_suburbError'];  ?></td>
										</tr>	
										
										<tr>
											<td  align="left" valign="middle"><?php echo SENDER_STATE;?></td>
											<td  align="left" valign="middle"  class="message_mendatory"><input type="text" class="input_consignor" name="sender_state" value="<?php if($BookingDetail['sender_state']==""){echo $_POST['sender_state'];}else{echo valid_output($BookingDetail['sender_state']);} ?>"/><img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>internal/help_up.gif" class="help_btn" alt="<?php echo  SENDER_STATE;?>" onmouseover="return overlib('<?php echo $State;?>');" onmouseout="return nd();" />
											
											</td>
											<td  align="left" valign="middle"><?php echo RECEIVER_STATE;?></td>
											<td  align="left" valign="top" class="message_mendatory"><input type="text" class="input_consignor" name="reciever_state" value="<?php if($BookingDetail['reciever_state']==""){echo $_POST['reciever_state'];}else{echo valid_output($BookingDetail['reciever_state']);} ?>"/><img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>internal/help_up.gif" class="help_btn" alt="<?php echo  RECEIVER_STATE;?>" onmouseover="return overlib('<?php echo $State;?>');" onmouseout="return nd();" />
											
											</td>
										</tr>
										<tr>
											<td align="left" valign="middle">&nbsp;</td>
											<td align="left" valign="top" class="message_mendatory" id="PickUpError"><?php echo $err['sender_stateError'];  ?></td>
											<td align="left" valign="middle">&nbsp;</td>
											<td align="left" valign="top" class="message_mendatory" id="DeliverToError"><?php echo $err['reciever_stateError'];  ?></td>
										</tr>	
										
										<tr>
											<td  align="left" valign="middle"><?php echo SENDER_POSTCODE;?></td>
											<td  align="left" valign="middle"  class="message_mendatory"><input type="text" class="input_consignor" name="sender_postcode" value="<?php if($BookingDetail['sender_postcode']==""){echo $_POST['sender_postcode'];}else{echo $BookingDetail['sender_postcode'];} ?>"/><img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>internal/help_up.gif" class="help_btn" alt="<?php echo  SENDER_POSTCODE;?>" onmouseover="return overlib('<?php echo $PostcodeName;?>');" onmouseout="return nd();" />
											
											</td>
											<td  align="left" valign="middle"><?php echo RECEIVER_POSTCODE;?></td>
											<td  align="left" valign="top" class="message_mendatory"><input type="text" class="input_consignor" name="reciever_postcode" value="<?php if($BookingDetail['reciever_postcode']==""){echo $_POST['reciever_postcode'];}else{echo $BookingDetail['reciever_postcode'];} ?>"/><img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>internal/help_up.gif" class="help_btn" alt="<?php echo  RECEIVER_POSTCODE;?>" onmouseover="return overlib('<?php echo $PostcodeName;?>');" onmouseout="return nd();" />
											
											</td>
										</tr>
										<tr>
											<td align="left" valign="middle">&nbsp;</td>
											<td align="left" valign="top" class="message_mendatory" id="PickUpError"><?php echo $err['sender_postcodeError'];  ?></td>
											<td align="left" valign="middle">&nbsp;</td>
											<td align="left" valign="top" class="message_mendatory" id="DeliverToError"><?php echo $err['reciever_postcodeError'];  ?></td>
										</tr>	
										
										<tr>
											<td  align="left" valign="middle"><?php echo SENDER_EMAIL;?></td>
											<td  align="left" valign="middle"  class="message_mendatory"><input type="text" class="input_consignor" name="sender_email" value="<?php if($BookingDetail['sender_email']==""){echo $_POST['sender_email'];}else{echo valid_output($BookingDetail['sender_email']);} ?>"/><img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>internal/help_up.gif" class="help_btn" alt="<?php echo  SENDER_EMAIL;?>" onmouseover="return overlib('<?php echo $Email_Address;?>');" onmouseout="return nd();" />
											</td>
											<td  align="left" valign="middle"><?php echo RECEIVER_EMAIL;?></td>
											<td  align="left" valign="top" class="message_mendatory"><input type="text" class="input_consignor" name="reciever_email" value="<?php if($BookingDetail['reciever_email']==""){echo $_POST['reciever_email'];}else{echo valid_output($BookingDetail['reciever_email']);} ?>"/><img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>internal/help_up.gif" class="help_btn" alt="<?php echo  RECEIVER_EMAIL;?>" onmouseover="return overlib('<?php echo $Email_Address;?>');" onmouseout="return nd();" />
											</td>
										</tr>
										<tr>
											<td align="left" valign="middle">&nbsp;</td>
											<td align="left" valign="top" class="message_mendatory" id="PickUpError"><?php echo $err['sender_emailError'];  ?></td>
											<td align="left" valign="middle">&nbsp;</td>
											<td align="left" valign="top" class="message_mendatory" id="DeliverToError"><?php echo $err['reciever_emailError'];  ?></td>
										</tr>	
										
										<tr>
											<td  align="left" valign="middle"><?php echo SENDER_CONTACT_NO;?></td>
											<td  align="left" valign="middle"  class="message_mendatory"><input type="text" class="input_consignor" name="sender_contact_no" value="<?php if($BookingDetail['sender_contact_no']==""){echo $_POST['sender_contact_no'];}else{echo $BookingDetail['sender_contact_no'];} ?>"/>
											<img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>internal/help_up.gif" class="help_btn" alt="<?php echo  SENDER_CONTACT_NO;?>" onmouseover="return overlib('<?php echo $PhoneNO;?>');" onmouseout="return nd();" />
											</td>
											<td  align="left" valign="middle"><?php echo RECEIVER_CONTACT_NO;?></td>
											<td  align="left" valign="top" class="message_mendatory"><input type="text" class="input_consignor" name="reciever_contact_no" value="<?php if($BookingDetail['reciever_contact_no']==""){echo $_POST['reciever_contact_no'];}else{echo $BookingDetail['reciever_contact_no'];} ?>"/>
											<img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>internal/help_up.gif" class="help_btn" alt="<?php echo  RECEIVER_CONTACT_NO;?>" onmouseover="return overlib('<?php echo $PhoneNO;?>');" onmouseout="return nd();" />
											</td>
										</tr>
										<tr>
											<td align="left" valign="middle">&nbsp;</td>
											<td align="left" valign="top" class="message_mendatory" id="PickUpError"><?php echo $err['sender_contact_noError'];  ?></td>
											<td align="left" valign="middle">&nbsp;</td>
											<td align="left" valign="top" class="message_mendatory" id="DeliverToError"><?php echo $err['reciever_contact_noError'];  ?></td>
										</tr>	
										
										<tr>
											<td  align="left" valign="middle"><?php echo SENDER_MOBILE_NO;?></td>
											<td  align="left" valign="middle"  class="message_mendatory"><input type="text" class="input_consignor" name="sender_mobile_no" value="<?php if($BookingDetail['sender_mobile_no']==""){echo $_POST['sender_mobile_no'];}else{echo $BookingDetail['sender_mobile_no'];} ?>"/>
											<img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>internal/help_up.gif" class="help_btn" alt="<?php echo  SENDER_MOBILE_NO;?>" onmouseover="return overlib('<?php echo $MobileNo;?>');" onmouseout="return nd();" />
											</td>
											<td  align="left" valign="middle"><?php echo RECEIVER_MOBILE_NO;?></td>
											<td  align="left" valign="top" class="message_mendatory"><input type="text" class="input_consignor" name="reciever_mobile_no" value="<?php if($BookingDetail['reciever_mobile_no']==""){echo $_POST['reciever_mobile_no'];}else{echo $BookingDetail['reciever_mobile_no'];} ?>"/>
											<img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>internal/help_up.gif" class="help_btn" alt="<?php echo  RECEIVER_MOBILE_NO;?>" onmouseover="return overlib('<?php echo $MobileNo;?>');" onmouseout="return nd();" />
											</td>
										</tr>
										<tr>
											<td align="left" valign="middle">&nbsp;</td>
											<td align="left" valign="top" class="message_mendatory" id="PickUpError"><?php echo $err['sender_mobile_noError'];  ?></td>
											<td align="left" valign="middle">&nbsp;</td>
											<td align="left" valign="top" class="message_mendatory" id="DeliverToError"><?php echo $err['reciever_mobile_noError'];  ?></td>
										</tr>

									
										<tr>
											<td  align="left" valign="middle"><?php echo DATE_READY;?></td>
											<td  align="left" valign="middle"  class="message_mendatory">
											<!--
											<label>
                                            <div class="form-group">
                							<div class='input-group date'  id='datetimepicker6' data-link-field="dtp_input1">
                							<span class="input-group-addon" style="display:inline-block !important;">
                							<input type='hidden' class="form-control" id="dtp_input1" />
                                            <img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>internal/cal-ico.png"  alt="Pickup From" border="0"  /></span>
                                            </label>
											<?php
											//date('Y-m-d H:i', strtotime($BookingDetailsDataObj['start_date']))
											if($BookingDetail['date_ready']==""){$date_ready = date('Y-m-d H:i', strtotime($_POST['date_ready']));}else{$date_ready = date('Y-m-d H:i',strtotime($BookingDetail['date_ready']));}
											?>
                                            <input  type="text" id="date_ready" name="date_ready" value="<?php echo $date_ready; ?>" class="register"><span> *</span><img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>internal/help_up.gif" class="help_btn" alt="<?php echo  BOOKING_DATE;?>" onmouseover="return overlib('<?php echo $Booking_Date;?>');" onmouseout="return nd();" />
											</div>
                                            </div>-->
											<div class="form-group">
												<input type="hidden" id="dateArr" value="<?php echo $date_arr; ?>" />
												<div class='input-group date' id='datetimepicker6'>
												<label class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></label>
												<?php
											
													if($BookingDetail['date_ready']==""){$date_ready = date('Y-m-d H:i', strtotime($_POST['date_ready']));}else{$date_ready = date('Y-m-d H:i',strtotime($BookingDetail['date_ready']));}
												?>
												<input type='text' class="form-control"     data-toggle="tooltip"  name="date_ready" id="date_ready" />
												<input type='hidden' class="form-control" value='<?php echo $date_ready; ?>'    data-toggle="tooltip"  name="dtp_input1" id="dtp_input1" />
												
												</div>
											</div>
											</td>
											<td  align="left" valign="middle"><?php echo BOOKING_DATE;?></td>
											<td  align="left" valign="middle"  class="message_mendatory">
                                            
											<div class="form-group">
												<input type="hidden" id="dateArr" value="<?php echo $date_arr; ?>" />
												<div class='input-group date' id='datetimepicker7'>
												<label class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></label>
												<?php
											
													
													if($BookingDetail['booking_date']==""){$booking_date = date('Y-m-d H:i', strtotime($_POST['booking_date']));}else{
													$booking_date = date('Y-m-d H:i', strtotime($BookingDetail['booking_date']." ".$BookingDetail['booking_time']));
													}
													//echo $booking_date;
												?>
												<input type='text' class="form-control"   readonly  data-toggle="tooltip"  name="booking_date" id="booking_date" />
												<input type='hidden' value="<?php  echo $booking_date; ?>"   data-toggle="tooltip"  name="dtp_input2" id="dtp_input2" />
												</div>
											</div>
											</td>
										</tr>
										<tr>
											<td align="left" valign="middle">&nbsp;</td>
											<td align="left" valign="top" class="message_mendatory" id="PickUpError"><?php echo $err['date_readyError'];  ?></td>
											<td align="left" valign="middle">&nbsp;</td>
											<td align="left" valign="top" class="message_mendatory" id="DeliverToError"><?php echo $err['booking_dateError'];  ?></td>
										</tr>		
																
										<tr>
											<td  align="left" valign="middle"><?php echo PICKUP_TIME_ZONE;?></td>
											<td  align="left" valign="middle"  class="message_mendatory"><?php
											$cont = '';
											$pickup_time_zone_cond=	($_POST['pickup_time_zone']!="")?($_POST['pickup_time_zone']):(valid_output($BookingDetail['pickup_time_zone']));
											$cont .= "<select name='pickup_time_zone'><option value=''>Please Select Any One</option>";
											foreach ($pickup_time_zone as $ser){
												$cont .=  "<option value='".$ser."'";
												$cont .= ($ser==$pickup_time_zone_cond)?("selected"):("");
												$cont .= ">".$ser."</option>";

											}
											$cont .="</select>";
											echo $cont ;
											?>
											<img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>internal/help_up.gif" class="help_btn" alt="<?php echo  PICKUP_TIME_ZONE;?>" onmouseover="return overlib('<?php echo $Pickup_Time_Zone;?>');" onmouseout="return nd();" />
											
											</td>
											<td  align="left" valign="middle"><?php echo DELIVERY_TIME_ZONE;?></td>
											<td  align="left" valign="top" class="message_mendatory">
											<?php

											$cont = '';
											$delivery_time_zone_cond=	($_POST['delivery_time_zone']!="")?($_POST['delivery_time_zone']):(valid_output($BookingDetail['delivery_time_zone']));
											$cont .= "<select name='delivery_time_zone'><option value=''>Please Select Any One</option>";
											foreach ($deliver_time_zone as $test){
												$cont .=  "<option value='".$test."'";
												$cont .= ($test==$delivery_time_zone_cond)?("selected"):("");
												$cont .= ">".$test."</option>";

											}
											$cont .="</select>";
											echo $cont ;
											?>
											<img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>internal/help_up.gif" class="help_btn" alt="<?php echo  DELIVERY_TIME_ZONE;?>" onmouseover="return overlib('<?php echo $Delivery_Time_Zone;?>');" onmouseout="return nd();" />
											
											</td>
										</tr>
										<tr>
											<td align="left" valign="middle">&nbsp;</td>
											<td align="left" valign="top" class="message_mendatory" id="PickUpError"><?php echo $err['pickup_time_zoneError'];  ?></td>
											<td align="left" valign="middle">&nbsp;</td>
											<td align="left" valign="top" class="message_mendatory" id="DeliverToError"><?php echo $err['delivery_time_zoneError'];  ?></td>
										</tr>
										<tr>
										<td><span class="pickup_form"><?php echo TIME_READY; ?>:</span></td>
										<td>
										<?php
											$bookingTimeReady 	= strtotime(valid_input(substr($BookingDetail['time_ready'],0,-2)));
											$hourR  			= date('H',$bookingTimeReady);	
											$minutesR  			= date('i',$bookingTimeReady);	
											$formatR  			= valid_input(substr($BookingDetail['booking_time'],-2));
																							
										?>
										<span style="width:10px;">&nbsp;</span>
										<?php
											echo "<select name='time_ready_time_hr'>";
											for($i=1;$i<13;$i++){
											if(intval($hourR) == $i) $selectedHr = "selected = 'selected'";
												echo "<option value ='".$i."' ";
												if(intval($hourR) == $i) {echo "selected = 'selected'";}
												echo ">";
												echo $i;
												echo "</option>";
											}
											echo "</select>";
											$ready_by_time_sec = '';
											$ready_by_time_sec  .= "<select name='time_ready_time_sec'>";
											?><select name='time_ready_time_sec'>
													<option value="15" <?php if(intval($minutesR) == 15) echo "selected = 'selected'" ;?>>15</option>
													<option value="30" <?php if(intval($minutesR) == 30) echo "selected = 'selected'" ;?>>30</option>
													<option value="45" <?php if(intval($minutesR) == 45) echo "selected = 'selected'" ;?>>45</option>
											</select>
								
											<select name='time_ready_hr_formate'>
												<option value="am"<?php if($formatR == 'am') echo "selected = 'selected'";?> >am</option>
												<option value="pm"<?php if($formatR == 'pm') echo "selected = 'selected'";?>>pm</option>
											</select>
											
											
										</td>
										<td><span class="pickup_form"><?php echo BOOKING_TIME; ?>:</span></td>
										<td>
										<?php
											$bookingTime 	= strtotime(valid_input(substr($BookingDetail['booking_time'],0,-2)));
											$hour  			= date('H',$bookingTime);	
											$minutes  		= date('i',$bookingTime);	
											$format  		= valid_input(substr($BookingDetail['booking_time'],-2));
																							
										?>
											
										<span style="width:10px;">&nbsp;</span>
										<?php
											echo "<select name='booking_time_hr'>";
											for($i=1;$i<13;$i++){
											if(intval($hour) == $i) $selectedHr = "selected = 'selected'";else $selectedHr = "";
												echo "<option value ='".$i."' " .$selectedHr. " > " .$i. "</option>";
											}
											echo "</select>";
											?>
											<select name='booking_time_sec'>
													<option value="15" <?php if(intval($minutes) == 15) echo "selected = 'selected'" ;?>>15</option>
													<option value="30" <?php if(intval($minutes) == 30) echo "selected = 'selected'" ;?>>30</option>
													<option value="45" <?php if(intval($minutes) == 45) echo "selected = 'selected'" ;?>>45</option>
											</select>
											<select name='booking_time_hr_formate'>
												<option value="am"<?php if($format == 'am') echo "selected = 'selected'";?> >am</option>
												<option value="pm"<?php if($format == 'pm') echo "selected = 'selected'";?>>pm</option>
											</select>	
										</td>
									</tr>
									<tr>
										<td align="left" valign="middle">&nbsp;</td>
										<td align="left" valign="top" class="message_mendatory" id="ready_byError"><?php echo $err['ready_byError'];  ?></td>
										<td align="left" valign="middle">&nbsp;</td>
										<td align="left" valign="top" class="message_mendatory" id="delivery_byError"><?php echo $err['delivery_byError'];  ?></td>
									</tr>
									<tr>
										<td  align="left" valign="middle"><?php echo CCCONNOTE;?></td>
										
										<td  align="left" valign="top" class="message_mendatory" ><input type="text" class="input_consignor" name="CCConnote" value="<?php if($BookingDetail['CCConnote']==""){echo $_POST['CCConnote'];}else{echo valid_output($BookingDetail['CCConnote']);} ?>"/><img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>internal/help_up.gif" class="help_btn" alt="<?php echo CCCONNOTE;?>" onmouseover="return overlib('<?php echo $Shopping_Number;?>');" onmouseout="return nd();" />
										</td>
										<td  align="left" valign="middle"><?php echo PAYMENT_DONE;?></td>
										<td  align="left" valign="top" class="message_mendatory">
										<?php
										$cont = '';
										$cond_payment_done = ($_POST['payment_done']!="")?($_POST['payment_done']):($BookingDetail['payment_done']);
										$cont .= "<select name='payment_done'><option value=''>Please Select Any One</option>";
										foreach ($payment_done as $ser){
											$cont .=  "<option value='".$ser."'";
											$cont .= ($ser==$cond_payment_done)?("selected"):("");
											$cont .= ">".$ser."</option>";

										}
										$cont .="</select>";
										echo $cont ;
										?><img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>internal/help_up.gif" class="help_btn" alt="<?php echo PAYMENT_DONE;?>" onmouseover="return overlib('<?php echo $Payment_Done;?>');" onmouseout="return nd();" />
										
										</td>
									</tr>
									<tr>
										<td align="left" valign="middle">&nbsp;</td>
										<td align="left" valign="top" class="message_mendatory" id="PickUpError"><?php echo $err['CCConnoteError'];  ?></td>
										<td align="left" valign="middle">&nbsp;</td>
										<td align="left" valign="top" class="message_mendatory" id="DeliverToError"><?php echo $err['payment_doneError'];  ?></td>
									</tr>
																
											</table>
														</td>
													</tr>
													<tr>
														<td>&nbsp;</td>
													</tr>
												
												</table>
											</td>
										</tr>
										<tr>
											<td>&nbsp;</td>
										</tr>
										<tr>
											<td align="center">
											<input type="hidden" size="34" id="ptoken" value="<?php echo $ptoken; ?>" name="ptoken">
											<input type="submit" class="action_button" tabindex="36" name="submit" value="<?php echo $btnSubmit; ?>" onclick="return validate_client(this.form);" >
											<input type="reset" tabindex="37" name="reset" class="action_button" value="<?php echo ADMIN_COMMON_BUTTON_RESET; ?>" >
											<input type="button"  class="action_button" name="cancel" tabindex="38" value="<?php echo ADMIN_COMMON_BUTTON_CANCEL;?>" onclick="javascript:document.location.href='<?php echo FILE_BOOKING_DETAILS_LISTING; ?>';return true;"/>
											</td>
										</tr>
										<tr>
											<td><input type="hidden" id="dateArr" value="<?php echo $date_arr; ?>" />&nbsp;
											<?php 
												if(isset($_POST['minDate']) && $_POST['minDate']!="")
												{
													$min_date = date('Y-m-d H:i', strtotime($_POST['minDate']));
												}else{
													$min_date = date('Y-m-d H:i');
												}
											?>
											<input type="hidden" name="minDate" id="minDate" value="<?php echo $min_date; ?>"/>
											</td>
										</tr>
										</form>
									</table>
									<?php  /*** End :: Listing Table ***/ ?>
								</td>
							</tr>
						</table>
					<!-- End :  Middle Content-->
					</td>
				</tr>
			</table>
		</td>
	</tr>
<!-- End Middle Content part -->
	<tr>
		<td id="footer">
			<?php require_once(DIR_WS_ADMIN_INCLUDES . ADMIN_FILE_FOOTER);?>
		</td>
	</tr>
</table>
</body>
</html>
<script type="text/javascript">
var dat = $("#dateArr").val();
var dateTest = dat.split(",");
var dateArr = [];
for(var i=0;i<dateTest.length;i++)
{
	dateArr[i] = dateTest[i];
}
var m = $("#minDate").val();
var minDate = m;

if(trim(minDate) == "")
{
	minDate = moment().format();
}

if(trim($("#dtp_input1").val())!="")
{
	var start_date = $("#dtp_input1").val();
}else{
	var start_date = moment().format();
}

$('#datetimepicker6').datetimepicker({
	date: start_date,
	minDate: minDate,
	format: 'DD MMM YYYY h:mm a',
	daysOfWeekDisabled: [0,6],
	sideBySide: true,
	widgetPositioning: {
		horizontal: 'left'
	},
	showClose: true,
	locale: 'en',
	ignoreReadonly:true,
	disabledDates:dateArr
});

$("#datetimepicker6").on("dp.change",function (e) { 
	var date = $('#date_ready').val();
	$('#dtp_input1').val(date);
});

if($("#dtp_input2").val()!="")
{
	var end_date = $("#dtp_input2").val();
}else{
	var end_date = moment().format();
}
//alert(minDate);

$('#datetimepicker7').datetimepicker({
	date: end_date,
	minDate: minDate,
	format: 'DD MMM YYYY h:mm a',
	daysOfWeekDisabled: [0,6],
	sideBySide: true,
	widgetPositioning: {
		horizontal: 'left'
	},
	showClose: true,
	locale: 'en',
	ignoreReadonly:true,
	disabledDates:dateArr
});


$("#datetimepicker7").on("dp.change",function (e) { 
	var date = $('#booking_date').val();
	$("#dtp_input2").val(date);
});

//var first = moment().format('DD MMMM YYYY');


</script>