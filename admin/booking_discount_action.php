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
//echo "<pre>";print_r($_POST);
require_once("../lib/common.php");
require_once(DIR_WS_MODEL . "BookingDetailsMaster.php");
require_once(DIR_WS_MODEL . "UserMaster.php");
require_once(DIR_WS_MODEL ."InternationalZonesMaster.php");
require_once(DIR_WS_MODEL . "PostCodeMaster.php");
require_once(DIR_WS_MODEL . "ItemTypeMaster.php");
require_once(DIR_WS_MODEL . "SiteConstantMaster.php");
require_once(DIR_WS_ADMIN_LANGUAGES . DIR_CURRENT_LANGUAGE. '/booking_detail.php');

/**
	 * Start :: Object declaration
	 */

$ObjBookingDetailsMaster	= new BookingDetailsMaster();
$ObjBookingDetailsMaster	= $ObjBookingDetailsMaster->Create();
$BookingDetailsData		= new BookingDetailsData();
$ObjUserMaster	= new UserMaster();
$ObjUserMaster	= $ObjUserMaster->Create();
$UserData		= new UserData();
$ObjPostCodeMaster	= new PostCodeMaster();
$ObjPostCodeMaster	= $ObjPostCodeMaster->Create();
$PostCodeData		= new PostCodeData();
$InternationalzonesMasterObj = new InternationalZonesMaster();
$InternationalzonesMasterObj = $InternationalzonesMasterObj->Create();
$InternationalDataobj= new InternationalZonesData();
$ObjInternationalMaster	= new ItemTypeMaster();
$ObjInternationalMaster	= $ObjInternationalMaster->Create();
$objSiteConstantMaster = new SiteConstantMaster();
$objSiteConstantMaster = $objSiteConstantMaster->create();
$objSiteConstantData = new SiteConstantData();

$SiteConstantDataVal = $objSiteConstantMaster->getSiteConstant($fieldArr=null, $seaArr=null, $optArr=null, $start=null, $total=null, $ThrowError=true,$constant_id=null,$from_admin=false,'services_volumetric_charges');
$SiteConstantData = $SiteConstantDataVal[0];
$volumetric_divisor = ($SiteConstantData->constant_value!="")?($SiteConstantData->constant_value):(4000);

/**
	 * Inclusion and Exclusion Array of Javascript
	 */

$arr_javascript_include[] = "shipping.js";
$arr_javascript_include[] = "postcode_action.php";
$arr_javascript_include[] = "jquery.dataTables.js";
$arr_javascript_include[] = 'moment.min.js';
$arr_javascript_include[] = 'bootstrap.min.js';
$arr_javascript_include[] = 'bootstrap-datetimepicker.min.js';
$arr_css_plugin_include[] = 'datatables/css/jquery.dataTables.min.css';	
$arr_javascript_plugin_include[] = 'datatables/js/jquery.dataTables.min.js';

$arr_javascript_include[] = 'tabbed_panels.js';
$arr_javascript_include[] = 'holiday_validation.php';
$arr_css_include[] = DIR_HTTP_ADMIN_CSS.'tabbed_panels.css';
$arr_css_exclude[] = DIR_HTTP_ADMIN_CSS.'jquery.css';
$arr_css_include[] = DIR_HTTP_CSS.'bootstrap-datetimepicker.css';
$arr_javascript_include[] ='booking_details.php';
/**
	 * Variable Declaration
	 */


$btnSubmit = ADMIN_BUTTON_SAVE_POSTCODE;
$HeadingLabel = ADMIN_LINK_SAVE_POSTCODE;
/*csrf validation*/
$csrf = new csrf();

//die();
if(!isset($_POST['submit'])) {
	$csrf->action = "client_address_book";
	$ptoken = $csrf->csrfkey();
}

$hh = array('1','2','3','4','5','6','7','8','9','10','11','12');
$mm = array('00','15','30','45');
$am_pm = array('am','pm');

$flag = array('australia','international');
$webservice = array("AAE"=>"AAE","DIRCOUR"=>"Direct Courier","UPS" => "UPS");
$payment_done = array("true","false");
$tansient_warranty =  array("true","false");
$authority_to_leave =  array("true","false");
$service = array('economy','express','overnight','priority','standard','international');
$pickup_time_zone = array('EST (Eastern Standard Time)','CST (Central Standard Time)','WST (Western Standard Time)');
$deliver_time_zone = array('EST (Eastern Standard Time)','CST (Central Standard Time)','WST (Western Standard Time)');
$pro_froma_invoice = array("Yes","No");
$pagenum = ($_GET['pagenum']!="")?($_GET['pagenum']):(1);
$booking_id = $_GET['booking_id'];
if(!empty($pagenum))
{
	$err['pagenum'] = isNumeric(valid_input($pagenum),ENTER_NUMERIC_VALUES_ONLY);
}
if(!empty($err['pagenum']))
{
	logOut();
}

if(!empty($booking_id))
{
	$err['bookingid'] = isNumeric(valid_input($booking_id),ENTER_NUMERIC_VALUES_ONLY);
}
if(!empty($err['bookingid']))
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
	$data.= "pickupid,\"deliveryid\",\"distance_in_km\",\"flag\",\"userid\",\"pageid\",\"booking_id\",\"webservice\",\"payment_done\",\"total_qty\",\"total_weight\",\"volumetric_weight\",\"chargeable_weight\",\"standard_rate\",\"express_rate\",\"international_rate\",\"priority_rate\",\"overnight_rate\",\"economy_rate\",\"description_of_goods\",\"dangerous_goods\",\"tansient_warranty\",\"values_of_goods\",\"authority_to_leave\",\"where_to_leave_shipment\",\"additional_cost\",\"coverage_rate\",\"service_name\",\"sender_first_name\",\"sender_surname\",\"sender_company_name\",\"sender_address_1\",\"sender_address_2\",\"sender_address_3\",\"sender_suburb\",\"sender_state\",\"sender_postcode\",\"sender_email\",\"sender_contact_no\",\"sender_mobile_no\",\"reciever_firstname\",\"reciever_surname\",\"reciever_company_name\",\"reciever_address_1\",\"reciever_address_2\",\"reciever_address_3\",\"reciever_suburb\",\"reciever_state\",\"reciever_postcode\",\"reciever_email\",\"reciever_contact_no\",\"reciever_mobile_no\",\"date_ready\",\"time_ready\",\"booking_date\",\"booking_time\",\"pickup_time_zone\",\"delivery_time_zone\",\"pagename\",\"servicepagename\",\"connote_no\",\"booking_no\",\"p_id\",\"d_id\",\"pro_froma_invoice\"";
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
			$webservice       = $BookingDetail['webservice'];
			$payment_done       = $BookingDetail['payment_done'];
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
			$description_of_goods       = $BookingDetail['description_of_goods'];
			$dangerous_goods       = $BookingDetail['dangerous_goods'];
			$tansient_warranty       = $BookingDetail['tansient_warranty'];
			$values_of_goods       = $BookingDetail['values_of_goods'];
			$authority_to_leave       = $BookingDetail['authority_to_leave'];
			$where_to_leave_shipment       = $BookingDetail['where_to_leave_shipment'];
			$additional_cost       = $BookingDetail['additional_cost'];
			$coverage_rate       = $BookingDetail['coverage_rate'];
			$service_name       = $BookingDetail['service_name'];
			$sender_first_name       = $BookingDetail['sender_first_name'];
			$sender_surname       = $BookingDetail['sender_surname'];
			$sender_company_name       = $BookingDetail['sender_company_name'];
			$sender_address_1       = $BookingDetail['sender_address_1'];
			$sender_address_2       = $BookingDetail['sender_address_2'];
			$sender_address_3       = $BookingDetail['sender_address_3'];
			$sender_suburb       = $BookingDetail['sender_suburb'];
			$sender_state       = $BookingDetail['sender_state'];
			$sender_postcode       = $BookingDetail['sender_postcode'];
			$sender_email       = $BookingDetail['sender_email'];
			$sender_contact_no       = $BookingDetail['sender_contact_no'];
			$sender_mobile_no       = $BookingDetail['sender_mobile_no'];
			$reciever_firstname       = $BookingDetail['reciever_firstname'];
			$reciever_surname       = $BookingDetail['reciever_surname'];
			$reciever_company_name       = $BookingDetail['reciever_company_name'];
			$reciever_address_1       = $BookingDetail['reciever_address_1'];
			$reciever_address_2       = $BookingDetail['reciever_address_2'];
			$reciever_address_3       = $BookingDetail['reciever_address_3'];
			$reciever_suburb       = $BookingDetail['reciever_suburb'];
			$reciever_state       = $BookingDetail['reciever_state'];
			$reciever_postcode       = $BookingDetail['reciever_postcode'];
			$reciever_email       = $BookingDetail['reciever_email'];
			$reciever_contact_no       = $BookingDetail['reciever_contact_no'];
			$reciever_mobile_no       = $BookingDetail['reciever_mobile_no'];
			$date_ready       = $BookingDetail['date_ready'];
			$time_ready       = $BookingDetail['time_ready'];
			$booking_date       = $BookingDetail['booking_date'];
			$booking_time       = $BookingDetail['booking_time'];
			$pickup_time_zone       = $BookingDetail['pickup_time_zone'];
			$delivery_time_zone       = $BookingDetail['delivery_time_zone'];
			$pagename       = $BookingDetail['pagename'];
			$servicepagename       = $BookingDetail['servicepagename'];
			$CCConnote       = $BookingDetail['CCConnote'];
			$BookingNumber       = $BookingDetail['BookingNumber'];
			$p_id       = $BookingDetail['p_id'];
			$d_id       = $BookingDetail['d_id'];
			$pro_froma_invoice       = $BookingDetail['pro_froma_invoice'];


			$data.= "\n";

			$data.= '"'.$pickupid.'","'.$deliveryid.'","'.$distance_in_km.'","'.$flag.'","'.$userid.'","'.$pageid.'","'.$booking_id.'","'.$webservice.'","'.$payment_done.'","'.$total_qty.'","'.$total_weight.'","'.$volumetric_weight.'","'.$chargeable_weight.'","'.$standard_rate.'","'.$express_rate.'","'.$international_rate.'","'.$priority_rate.'","'.$overnight_rate.'","'.$economy_rate.'","'.$description_of_goods.'","'.$dangerous_goods.'","'.$tansient_warranty.'","'.$values_of_goods.'","'.$authority_to_leave.'","'.$where_to_leave_shipment.'","'.$additional_cost.'","'.$coverage_rate.'","'.$service_name.'","'.$sender_first_name.'","'.$sender_surname.'","'.$sender_company_name.'","'.$sender_address_1.'","'.$sender_address_2.'","'.$sender_address_3.'","'.$sender_suburb.'","'.$sender_state.'","'.$sender_postcode.'","'.$sender_email.'","'.$sender_contact_no.'","'.$sender_mobile_no.'","'.$reciever_firstname.'","'.$reciever_surname.'","'.$reciever_company_name.'","'.$reciever_address_1.'","'.$reciever_address_2.'","'.$reciever_address_3.'","'.$reciever_suburb.'","'.$reciever_state.'","'.$reciever_postcode.'","'.$reciever_email.'","'.$reciever_contact_no.'","'.$reciever_mobile_no.'","'.$date_ready.'","'.$time_ready.'","'.$booking_date.'","'.$booking_time.'","'.$pickup_time_zone.'","'.$delivery_time_zone.'","'.$pagename.'","'.$servicepagename.'","'.$CCConnote.'","'.$BookingNumber.'","'.$p_id.'","'.$d_id.'","'.$pro_froma_invoice.'"';


		}
	}
	echo $data;
	exit();
}

//import the csv file 





//add / update the record
if((isset($_POST['submit']) && submit != "")){
	$err['flagError'] 		 = isEmpty($_POST['flag'],FLAG_IS_REQUIRED);
	$err['useridError'] 		 = isEmpty($_POST['userid'], USER_IS_REQUIRED);
	$err['webserviceError']  = isEmpty($_POST['webservice'], WEBSERVICE_IS_REQUIRED);
	if($_POST['flag']!="" && $_POST['flag']=="australia"){
		$err['deliveryidError']  = isEmpty($_POST['DeliveryPostcode'], DELIVERY_IS_REQUIRED);
		$_POST['deliveryid'] = $_POST['deliveryid'];
	}else{
		$err['deliveryidError']  = isEmpty($_POST['deliveryidforinternational'], DELIVERY_IS_REQUIRED);
		$_POST['deliveryid'] = $_POST['deliveryidforinternational'];
	}
	$err['pickupidError']  = isEmpty($_POST['PickupPostcode'], PICKUP_IS_REQUIRED);
	
	$err['total_weightError']  = isEmpty($_POST['total_weight'], TOTAL_WEIGHT_IS_REQUIRED);
	$err['volumetric_weightError']  = isEmpty($_POST['volumetric_weight'], VOLUMETRIC_WEIGHT_IS_REQUIRED);
	$err['sender_first_nameError']  = isEmpty($_POST['sender_first_name'], SENDER_FIRST_NAME_IS_REQUIRED);
	$err['reciever_first_nameError']  = isEmpty($_POST['reciever_first_name'], RECEIVER_FIRST_NAME_IS_REQUIRED);
	$err['sender_surnameError']  = isEmpty($_POST['sender_surname'], SENDER_SURNAME_IS_REQUIRED);
	$err['reciever_surnameError']  = isEmpty($_POST['reciever_surname'], RECEIVER_SURNAME_IS_REQUIRED);
	$err['sender_address_1Error']  = isEmpty($_POST['sender_address_1'], SENDER_ADDRESS_IS_REQUIRED);
	$err['reciever_address_1Error']  = isEmpty($_POST['reciever_address_1'], RECEIVER_ADDRESS_IS_REQUIRED);
	
	$err['sender_emailError'] 		 = (isEmpty(trim($_POST['sender_email']),SENDER_EMAIL_IS_REQUIRES))?isEmpty(trim($_POST['sender_email']),SENDER_EMAIL_IS_REQUIRES):checkEmailPattern(trim($_POST['sender_email']),ERROR_EMAIL_ID_INVALID);
	$err['reciever_emailError'] 		 = (isEmpty(trim($_POST['reciever_email']),RECEIVER_EMAIL_IS_REQUIRES))?isEmpty(trim($_POST['reciever_email']),RECEIVER_EMAIL_IS_REQUIRES):checkEmailPattern(trim($_POST['reciever_email']),ERROR_EMAIL_ID_INVALID);
	
	$err['sender_suburbError'] 		 =isEmpty($_POST['sender_surname'], SENDER_SUBURB_IS_REQUIRES);
	$err['reciever_suburbError'] 		 =isEmpty($_POST['reciever_suburb'], RECEIVER_SUBURB_IS_REQUIRES);
	$err['sender_stateError'] 		 =isEmpty($_POST['sender_state'], SENDER_STATE_IS_REQUIRES);
	$err['reciever_stateError'] 		 =isEmpty($_POST['reciever_state'], RECEIVER_STATE_IS_REQUIRES);
	$err['sender_postcodeError'] 		 = (isEmpty(trim($_POST['sender_postcode']),SENDER_POSTCODE_IS_REQUIRES))?(isEmpty(trim($_POST['sender_postcode']),SENDER_POSTCODE_IS_REQUIRES)):isNumeric(trim($_POST['sender_postcode']),ERROR_SENDER_POSTCODE_REQUIRE_IN_NUMERIC);
	
	$err['reciever_postcodeError'] 		 =(isEmpty(trim($_POST['reciever_postcode']),RECEIVER_POSTCODE_IS_REQUIRES))?(isEmpty(trim($_POST['reciever_postcode']),RECEIVER_POSTCODE_IS_REQUIRES)):isNumeric(trim($_POST['reciever_postcode']),ERROR_RECEIVER_POSTCODE_REQUIRE_IN_NUMERIC);
	
	$err['date_readyError'] 		 =isEmpty($_POST['date_ready'], DATE_READY_IS_REQUIRES);
	$err['booking_dateError'] 		 =isEmpty($_POST['booking_date'],BOOKING_DATE_IS_REQUIRES);
	$err['pickup_time_zoneError'] 		 =isEmpty($_POST['pickup_time_zone'],PICKUP_TIME_ZONE_IS_REQUIRES);
	$err['delivery_time_zoneError'] 		 =isEmpty($_POST['delivery_time_zone'],DELIVER_TIME_ZONE_IS_REQUIRES);
	
	
	$err['sender_contact_noError'] 		 =(isEmpty(trim($_POST['sender_contact_no']),''))?(isEmpty(trim($_POST['sender_contact_no']),'')):isNumeric(trim($_POST['sender_contact_no']),ERROR_SENDER_CONTACT_REQUIRE_IN_NUMERIC);
	$err['reciever_contact_noError'] 		 =(isEmpty(trim($_POST['reciever_contact_no']),''))?(isEmpty(trim($_POST['reciever_contact_no']),'')):isNumeric(trim($_POST['reciever_contact_no']),ERROR_RECEIVER_CONTACT_REQUIRE_IN_NUMERIC);
	
	$err['sender_mobile_noError'] 		 =(isEmpty(trim($_POST['sender_mobile_no']),''))?(isEmpty(trim($_POST['sender_mobile_no']),'')):isNumeric(trim($_POST['sender_mobile_no']),ERROR_SENDER_MOBILE_REQUIRE_IN_NUMERIC);
	$err['reciever_mobile_noError'] 		 =(isEmpty(trim($_POST['reciever_mobile_no']),''))?(isEmpty(trim($_POST['reciever_mobile_no']),'')):isNumeric(trim($_POST['reciever_mobile_no']),ERROR_RECEIVER_MOBILE_REQUIRE_IN_NUMERIC);

	foreach($err as $key => $Value) {
		if($Value != '') 
		{
		$Svalidation=true;
		}
	}
	if($Svalidation==false){
		if(isset($_POST['ptoken'])) {
			$csrf->checkcsrf($_POST['ptoken']);
		}
		$comman_rate = trim($_POST['service_name'])."_rate";
		if($comman_rate!=""){
		$BookingDetailsData->$comman_rate = trim($_POST['rate']);
		}
		if($_POST['transit_warranty']=="yes")
		{
			
		}
		$time_ready = $_POST['time_ready_time_hr'].":".$_POST['time_ready_time_sec']."&nbsp;".$_POST['time_ready_hr_formate'];
		
		$booking_time  = $_POST['booking_time_hr'].":".$_POST['booking_time_sec']."&nbsp;".$_POST['booking_time_hr_formate'];
		
		$BookingDetailsData->flag = trim($_POST['flag']);
		$BookingDetailsData->userid = trim($_POST['userid']);
		$BookingDetailsData->webservice = trim($_POST['webservice']);
		$BookingDetailsData->payment_done = trim($_POST['payment_done']);
		$BookingDetailsData->pickupid = trim($_POST['pickupid']);
		$BookingDetailsData->deliveryid = trim($_POST['deliveryid']);
		$BookingDetailsData->distance_in_km = trim($_POST['distance_in_km']);
		$BookingDetailsData->total_qty = trim($_POST['total_qty']);
		$BookingDetailsData->total_weight = trim($_POST['total_weight']);
		$BookingDetailsData->volumetric_weight = trim($_POST['volumetric_weight']);

		$BookingDetailsData->chargeable_weight = trim($_POST['total_weight']);

		$BookingDetailsData->description_of_goods = trim($_POST['description_of_goods']);
		$BookingDetailsData->dangerous_goods = 'no';
		$BookingDetailsData->tansient_warranty = trim($_POST['transit_warranty']);

		$BookingDetailsData->values_of_goods = trim($_POST['values_of_goods']);
		$BookingDetailsData->authority_to_leave = trim($_POST['authority_to_leave']);
		$BookingDetailsData->where_to_leave_shipment = trim($_POST['where_to_leave_shipment']);
		$BookingDetailsData->service_name = trim($_POST['service_name']);
		$BookingDetailsData->sender_first_name       = trim($_POST['sender_first_name']);
		$BookingDetailsData->sender_surname       = trim($_POST['sender_surname']);
		$BookingDetailsData->sender_company_name       = trim($_POST['sender_company_name']);
		$BookingDetailsData->sender_address_1       = trim($_POST['sender_address_1']);
		$BookingDetailsData->sender_address_2       = trim($_POST['sender_address_2']);
		$BookingDetailsData->sender_address_3       = trim($_POST['sender_address_3']);
		$BookingDetailsData->sender_suburb       = trim($_POST['sender_suburb']);
		$BookingDetailsData->sender_state       = trim($_POST['sender_state']);
		$BookingDetailsData->sender_postcode       = trim($_POST['sender_postcode']);
		$BookingDetailsData->sender_email       = trim($_POST['sender_email']);
		$BookingDetailsData->sender_contact_no       = trim($_POST['sender_contact_no']);
		$BookingDetailsData->sender_mobile_no       = trim($_POST['sender_mobile_no']);
		$BookingDetailsData->reciever_firstname       = trim($_POST['reciever_first_name']);
		$BookingDetailsData->reciever_surname       = trim($_POST['reciever_surname']);
		$BookingDetailsData->reciever_company_name       = trim($_POST['reciever_company_name']);
		$BookingDetailsData->reciever_address_1       = trim($_POST['reciever_address_1']);
		$BookingDetailsData->reciever_address_2       = trim($_POST['reciever_address_2']);
		$BookingDetailsData->reciever_address_3       = trim($_POST['reciever_address_3']);
		$BookingDetailsData->reciever_suburb       = trim($_POST['reciever_suburb']);
		$BookingDetailsData->reciever_state       = trim($_POST['reciever_state']);
		$BookingDetailsData->reciever_postcode       = trim($_POST['reciever_postcode']);
		$BookingDetailsData->reciever_email       = trim($_POST['reciever_email']);
		$BookingDetailsData->reciever_contact_no       = trim($_POST['reciever_contact_no']);
		$BookingDetailsData->reciever_mobile_no       = trim($_POST['reciever_mobile_no']);
		$BookingDetailsData->date_ready       = trim($_POST['date_ready']);
		$BookingDetailsData->time_ready       = trim($time_ready);
		$BookingDetailsData->booking_date       = trim($_POST['booking_date']);
		$BookingDetailsData->booking_time       = trim($booking_time);
		$BookingDetailsData->pickup_time_zone       = trim($_POST['pickup_time_zone']);
		$BookingDetailsData->delivery_time_zone       = trim($_POST['delivery_time_zone']);

		$BookingDetailsData->CCConnote       = trim($_POST['CCConnote']);
		$BookingDetailsData->BookingNumber       = trim($_POST['BookingNumber']);
		$BookingDetailsData->p_id       = trim($_POST['fetchpickupid']);
		$BookingDetailsData->d_id       = trim($_POST['fetchdeliveryid']);
		$BookingDetailsData->pro_froma_invoice       = trim($_POST['pro_froma_invoice']);
		$BookingDetailsData->additional_cost = trim($_POST['coverage_rate']) + trim($_POST['rate']);
		$BookingDetailsData->coverage_rate = trim($_GET['coverage_rate']);
		if($_GET['booking_id']!='')
		{
			$booking_id = $_GET['booking_id'];
			$BookingDetailsData->booking_id = $booking_id;
			$BookingDetailsData->booking_id = $_GET['booking_id'];
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

//deleter the record
if($_GET['Action']=='trash'){
	$ObjBookingDetailsMaster->deleteBookingDetails($booking_id);
	$UParam = "?pagenum=".$pagenum."&message=".MSG_DELETE_BOOKING_DETAIL_SUCCESS;
	header('Location: '.FILE_BOOKING_DETAILS_LISTING.$UParam);
}
if($_GET['Action']=='mtrash'){
$booking_id= $_GET['m_trash_id'];
	$m_t_a=explode(",",$booking_id);
	foreach($m_t_a as $val)
	{
		$ObjBookingDetailsMaster->deleteBookingDetails($val);
	}
	$UParam = "?pagenum=".$pagenum."&message=".MSG_DELETE_BOOKING_DETAIL_SUCCESS;
	header('Location: '.FILE_BOOKING_DETAILS_LISTING.$UParam);
}

if(isset($_POST['btnimport']) && $_POST['btnimport']!=''){
	$message = '';

	$Error = array();

	if(isset($_FILES['csv_file']['name']) && $_FILES['csv_file']['name']!='') {
		$str_ext = substr($_FILES['csv_file']['name'],strrpos($_FILES['csv_file']['name'],'.'));
		if( strtolower($str_ext) != '.csv' ) {
			$message = SELECT_UPLOAD_CSV_FILE;
		} else {
			//  Read csv file and making array
			$SyncArray = array(
			'pickup_id' => 'pickupid',
			'delivery_id' => 'deliveryid',
			'distance_in_km' => 'distance_in_km',
			'flag' => 'flag',
			'userid' => 'userid',
			'pageid' => 'pageid',
			'webservice' => 'webservice',
			'payment_done' => 'payment_done',
			'pickupid' => 'pickupid',
			'deliveryid' => 'deliveryid',
			'distance_in_km' => 'distance_in_km',
			'total_qty' => 'total_qty',
			'total_weight' => 'total_weight',
			'volumetric_weight' => 'volumetric_weight',
			'chargeable_weight' => 'chargeable_weight',
			'standard_rate' => 'standard_rate',
			'express_rate' => 'express_rate',
			'international_rate' => 'international_rate',
			'priority_rate' => 'priority_rate',
			'overnight_rate' => 'overnight_rate',
			'economy_rate' => 'economy_rate',
			'description_of_goods' => 'description_of_goods',
			'dangerous_goods' => 'dangerous_goods',
			'tansient_warranty' => 'tansient_warranty',
			'values_of_goods' => 'values_of_goods',
			'authority_to_leave' => 'authority_to_leave',
			'where_to_leave_shipment' => 'where_to_leave_shipment',
			'additional_cost' => 'additional_cost',
			'coverage_rate' => 'coverage_rate',
			'service_name' => 'service_name',
			'sender_first_name' => 'sender_first_name',
			'sender_surname' => 'sender_surname',
			'sender_company_name' => 'sender_company_name',
			'sender_address_1' => 'sender_address_1',
			'sender_address_2' => 'sender_address_2',
			'sender_address_3' => 'sender_address_3',
			'sender_suburb' => 'sender_suburb',
			'sender_state' => 'sender_state',
			'sender_postcode' => 'sender_postcode',
			'sender_email' => 'sender_email',
			'sender_contact_no' => 'sender_contact_no',
			'sender_mobile_no' => 'sender_mobile_no',
			'reciever_firstname' => 'reciever_firstname',
			'reciever_surname' => 'reciever_surname',
			'reciever_company_name' => 'reciever_company_name',
			'reciever_address_1' => 'reciever_address_1',
			'reciever_address_2' => 'reciever_address_2',
			'reciever_address_3' => 'reciever_address_3',
			'reciever_suburb' => 'reciever_suburb',
			'reciever_state' => 'reciever_state',
			'reciever_postcode' => 'reciever_postcode',
			'reciever_email' => 'reciever_email',
			'reciever_contact_no' => 'reciever_contact_no',
			'reciever_mobile_no' => 'reciever_mobile_no',
			'date_ready' => 'date_ready',
			'time_ready' => 'time_ready',
			'booking_date' => 'booking_date',
			'booking_time' => 'booking_time',
			'pickup_time_zone' => 'pickup_time_zone',
			'delivery_time_zone' => 'delivery_time_zone',
			'pagename' => 'pagename',
			'servicepagename' => 'servicepagename',
			'connote_no' => 'connote_no',
			'booking_no' => 'booking_no',
			'p_id' => 'p_id',
			'd_id' => 'd_id',
			'pro_froma_invoice' => 'pro_froma_invoice',

			);
$str = "";

			$Array_Data = readCSVFile($_FILES['csv_file']['tmp_name'], $SyncArray);
			
			$i =$cnt= 0;            
			$str = "";
			
			if($Array_Data != '' && !empty($Array_Data)) {
				
				$cnt = count($Array_Data);
				foreach ($Array_Data as $key => $record) {
					
					$BookingDetailsData->flag       = trim(str_replace("'","`",htmlspecialchars($record['flag'])));
					$BookingDetailsData->userid       = trim(str_replace("'","`",htmlspecialchars($record['userid'])));
					$BookingDetailsData->pageid       = trim(str_replace("'","`",htmlspecialchars($record['pageid'])));
					$BookingDetailsData->webservice       = trim(str_replace("'","`",htmlspecialchars($record['webservice'])));
					$BookingDetailsData->payment_done       = trim(str_replace("'","`",htmlspecialchars($record['payment_done'])));
					$BookingDetailsData->pickupid       = trim(str_replace("'","`",htmlspecialchars($record['pickupid'])));
					$BookingDetailsData->deliveryid       = trim(str_replace("'","`",htmlspecialchars($record['deliveryid'])));
					$BookingDetailsData->distance_in_km       = trim(str_replace("'","`",htmlspecialchars($record['distance_in_km'])));
					$BookingDetailsData->total_qty       = trim(str_replace("'","`",htmlspecialchars($record['total_qty'])));
					$BookingDetailsData->total_weight       = trim(str_replace("'","`",htmlspecialchars($record['total_weight'])));
					$BookingDetailsData->volumetric_weight       = trim(str_replace("'","`",htmlspecialchars($record['volumetric_weight'])));
					$BookingDetailsData->chargeable_weight       = trim(str_replace("'","`",htmlspecialchars($record['chargeable_weight'])));
					$BookingDetailsData->standard_rate       = trim(str_replace("'","`",htmlspecialchars($record['standard_rate'])));
					$BookingDetailsData->express_rate       = trim(str_replace("'","`",htmlspecialchars($record['express_rate'])));
					$BookingDetailsData->international_rate       = trim(str_replace("'","`",htmlspecialchars($record['international_rate'])));
					$BookingDetailsData->priority_rate       = trim(str_replace("'","`",htmlspecialchars($record['priority_rate'])));
					$BookingDetailsData->overnight_rate       = trim(str_replace("'","`",htmlspecialchars($record['overnight_rate'])));
					$BookingDetailsData->economy_rate       = trim(str_replace("'","`",htmlspecialchars($record['economy_rate'])));
					$BookingDetailsData->description_of_goods       = trim(str_replace("'","`",htmlspecialchars($record['description_of_goods'])));
					$BookingDetailsData->dangerous_goods       = trim(str_replace("'","`",htmlspecialchars($record['dangerous_goods'])));
					$BookingDetailsData->tansient_warranty       = trim(str_replace("'","`",htmlspecialchars($record['tansient_warranty'])));
					$BookingDetailsData->values_of_goods       = trim($record['values_of_goods']);
					$BookingDetailsData->authority_to_leave       = trim(str_replace("'","`",htmlspecialchars($record['authority_to_leave'])));
					$BookingDetailsData->where_to_leave_shipment       = trim(str_replace("'","`",htmlspecialchars($record['where_to_leave_shipment'])));
					$BookingDetailsData->additional_cost       = trim($record['additional_cost']);
					$BookingDetailsData->coverage_rate       = trim($record['coverage_rate']);
					$BookingDetailsData->service_name       = trim($record['service_name']);
					$BookingDetailsData->sender_first_name       = trim($record['sender_first_name']);
					$BookingDetailsData->sender_surname       = trim(str_replace("'","`",htmlspecialchars($record['sender_surname'])));
					$BookingDetailsData->sender_company_name       = trim(str_replace("'","`",htmlspecialchars($record['sender_company_name'])));
					$BookingDetailsData->sender_address_1       = trim(str_replace("'","`",htmlspecialchars($record['sender_address_1'])));
					$BookingDetailsData->sender_address_2       = trim(str_replace("'","`",htmlspecialchars($record['sender_address_2'])));
					$BookingDetailsData->sender_address_3       = trim(str_replace("'","`",htmlspecialchars($record['sender_address_3'])));
					$BookingDetailsData->sender_suburb       = trim(str_replace("'","`",htmlspecialchars($record['sender_suburb'])));
					$BookingDetailsData->sender_state       = trim(str_replace("'","`",htmlspecialchars($record['sender_state'])));
					$BookingDetailsData->sender_postcode       = trim(str_replace("'","`",htmlspecialchars($record['sender_postcode'])));
					$BookingDetailsData->sender_email       = trim(str_replace("'","`",htmlspecialchars($record['sender_email'])));
					$BookingDetailsData->sender_contact_no       = trim(str_replace("'","`",htmlspecialchars($record['sender_contact_no'])));
					$BookingDetailsData->sender_mobile_no       = trim(str_replace("'","`",htmlspecialchars($record['sender_mobile_no'])));
					$BookingDetailsData->reciever_firstname       = trim(str_replace("'","`",htmlspecialchars($record['reciever_firstname'])));
					$BookingDetailsData->reciever_surname       = trim(str_replace("'","`",htmlspecialchars($record['reciever_surname'])));
					$BookingDetailsData->reciever_company_name       = trim(str_replace("'","`",htmlspecialchars($record['reciever_company_name'])));
					$BookingDetailsData->reciever_address_1       = trim(str_replace("'","`",htmlspecialchars($record['reciever_address_1'])));
					$BookingDetailsData->reciever_address_2       = trim(str_replace("'","`",htmlspecialchars($record['reciever_address_2'])));
					$BookingDetailsData->reciever_address_3       = trim(str_replace("'","`",htmlspecialchars($record['reciever_address_3'])));
					$BookingDetailsData->reciever_suburb       = trim(str_replace("'","`",htmlspecialchars($record['reciever_suburb'])));
					$BookingDetailsData->reciever_state       = trim(str_replace("'","`",htmlspecialchars($record['reciever_state'])));
					$BookingDetailsData->reciever_postcode       = trim(str_replace("'","`",htmlspecialchars($record['reciever_postcode'])));
					$BookingDetailsData->reciever_email       = trim(str_replace("'","`",htmlspecialchars($record['reciever_email'])));
					$BookingDetailsData->reciever_contact_no       = trim(str_replace("'","`",htmlspecialchars($record['reciever_contact_no'])));
					$BookingDetailsData->reciever_mobile_no       = trim(str_replace("'","`",htmlspecialchars($record['reciever_mobile_no'])));
					$BookingDetailsData->date_ready       = trim(str_replace("'","`",htmlspecialchars($record['date_ready'])));
					$BookingDetailsData->time_ready       = trim(str_replace("'","`",htmlspecialchars($record['time_ready'])));
					$BookingDetailsData->booking_date       = trim(str_replace("'","`",htmlspecialchars($record['booking_date'])));
					$BookingDetailsData->booking_time       = trim(str_replace("'","`",htmlspecialchars($record['booking_time'])));
					$BookingDetailsData->pickup_time_zone       = trim(str_replace("'","`",htmlspecialchars($record['pickup_time_zone'])));
					$BookingDetailsData->delivery_time_zone       = trim(str_replace("'","`",htmlspecialchars($record['delivery_time_zone'])));
					$BookingDetailsData->pagename       = trim(str_replace("'","`",htmlspecialchars($record['pagename'])));
					$BookingDetailsData->servicepagename       = trim(str_replace("'","`",htmlspecialchars($record['servicepagename'])));
					$BookingDetailsData->CCConnote       = trim(($record['connote_no']));
					$BookingDetailsData->BookingNumber       =  trim(($record['booking_no']));
					$BookingDetailsData->p_id       = trim(str_replace("'","`",htmlspecialchars($record['p_id'])));
					$BookingDetailsData->d_id       = trim(str_replace("'","`",htmlspecialchars($record['d_id'])));
					$BookingDetailsData->pro_froma_invoice       = trim(str_replace("'","`",htmlspecialchars($record['pro_froma_invoice'])));
					
					
					
					
					$fieldArr=array("*");
					$seaByArr = array() ;
					/*if($BookingDetailsData->flag!=''  && $BookingDetailsData->userid!='' && $BookingDetailsData->pickupid!='' && $BookingDetailsData->deliveryid!='' )
					{
					$seaByArr[]=array('Search_On'=>'flag', 'Search_Value'=>"$BookingDetailsData->flag", 'Type'=>'string', 'Equation'=>'=', 'CondType'=>'and', 'Prefix'=>'', 'Postfix'=>''); 		
					$seaByArr[]=array('Search_On'=>'userid', 'Search_Value'=>"$BookingDetailsData->userid", 'Type'=>'string', 'Equation'=>'=', 'CondType'=>'and', 'Prefix'=>'', 'Postfix'=>''); 	
					if(trim($BookingDetailsData->pickupid)!=""){$seaByArr[]=array('Search_On'=>'pickupid', 'Search_Value'=>"$BookingDetailsData->pickupid", 'Type'=>'string', 'Equation'=>'=', 'CondType'=>'and', 'Prefix'=>'', 'Postfix'=>''); 	}
					if(trim($BookingDetailsData->deliveryid)!=""){$seaByArr[]=array('Search_On'=>'deliveryid', 'Search_Value'=>"$BookingDetailsData->deliveryid", 'Type'=>'string', 'Equation'=>'=', 'CondType'=>'and', 'Prefix'=>'', 'Postfix'=>''); }	
					if(trim($BookingDetailsData->total_qty)!=""){$seaByArr[]=array('Search_On'=>'total_qty', 'Search_Value'=>"$BookingDetailsData->total_qty", 'Type'=>'string', 'Equation'=>'=', 'CondType'=>'and', 'Prefix'=>'', 'Postfix'=>''); 	}
					if(trim($BookingDetailsData->total_weight)!=""){$seaByArr[]=array('Search_On'=>'total_weight', 'Search_Value'=>"$BookingDetailsData->total_weight", 'Type'=>'string', 'Equation'=>'=', 'CondType'=>'and', 'Prefix'=>'', 'Postfix'=>''); 	}
					if(trim($BookingDetailsData->volumetric_weight)!=""){$seaByArr[]=array('Search_On'=>'volumetric_weight', 'Search_Value'=>"$BookingDetailsData->volumetric_weight", 'Type'=>'string', 'Equation'=>'=', 'CondType'=>'and', 'Prefix'=>'', 'Postfix'=>''); 	}
					if(trim($BookingDetailsData->service_name)!=""){$seaByArr[]=array('Search_On'=>'service_name', 'Search_Value'=>"$BookingDetailsData->service_name", 'Type'=>'string', 'Equation'=>'=', 'CondType'=>'and', 'Prefix'=>'', 'Postfix'=>''); 	}
					if(trim($BookingDetailsData->sender_email)!=""){$seaByArr[]=array('Search_On'=>'sender_email', 'Search_Value'=>"$BookingDetailsData->sender_email", 'Type'=>'string', 'Equation'=>'=', 'CondType'=>'and', 'Prefix'=>'', 'Postfix'=>''); 	}
					if(trim($BookingDetailsData->reciever_email)!=""){$seaByArr[]=array('Search_On'=>'reciever_email', 'Search_Value'=>"$BookingDetailsData->reciever_email", 'Type'=>'string', 'Equation'=>'=', 'CondType'=>'and', 'Prefix'=>'', 'Postfix'=>''); }	
					
					if(trim($BookingDetailsData->booking_date)!="")$seaByArr[]=array('Search_On'=>'booking_date', 'Search_Value'=>"$BookingDetailsData->booking_date", 'Type'=>'string', 'Equation'=>'=', 'CondType'=>'and', 'Prefix'=>'', 'Postfix'=>'');		
					}*/
					
					if($BookingDetailsData->CCConnote!='')
					{
					$seaByArr[]=array('Search_On'=>'CCConnote', 'Search_Value'=>"$BookingDetailsData->CCConnote", 'Type'=>'string', 'Equation'=>'LIKE', 'CondType'=>'and', 'Prefix'=>'', 'Postfix'=>''); }
					else{
						$message = CCCONNOTE_NOT_EXIST;
						//break;
					}
					$countBookingDetailsRecord=$ObjBookingDetailsMaster->getBookingDetails($fieldArr, $seaByArr, $optArr=null, $start=null, $total=null,$distinct=null, $ThrowError=true,$havingArray=null,$bookingid=null,$tot='find');
					//echo "<pre>";print_r($Data)."</br>";
					
					if($countBookingDetailsRecord!=0) {
						$alreadyaddedRecord = $alreadyaddedRecord+1;
					}
					else{
						$str .= "('".$BookingItemDetailsData->flag."','".$BookingDetailsData->userid."','".$BookingDetailsData->pageid."','".$BookingDetailsData->webservice."','".$BookingDetailsData->payment_done."','".$BookingDetailsData->pickupid."','".$BookingDetailsData->deliveryid."','".$BookingDetailsData->distance_in_km."','".$BookingDetailsData->total_qty."','".$BookingDetailsData->total_weight."','".$BookingDetailsData->volumetric_weight."','".$BookingDetailsData->chargeable_weight."','".$BookingDetailsData->standard_rate."','".$BookingDetailsData->express_rate."','".$BookingDetailsData->international_rate."','".$BookingDetailsData->priority_rate."','".$BookingDetailsData->overnight_rate."','".$BookingDetailsData->economy_rate."','".$BookingDetailsData->description_of_goods."','".$BookingDetailsData->dangerous_goods."','".$BookingDetailsData->tansient_warranty."','".$BookingDetailsData->values_of_goods."','".$BookingDetailsData->authority_to_leave."','".$BookingDetailsData->where_to_leave_shipment."','".$BookingDetailsData->additional_cost."','".$BookingDetailsData->coverage_rate."','".$BookingDetailsData->service_name."','".$BookingDetailsData->sender_first_name."','".$BookingDetailsData->sender_surname."','".$BookingDetailsData->sender_company_name."','".$BookingDetailsData->sender_address_1."','".$BookingDetailsData->sender_address_2."','".$BookingDetailsData->sender_address_3."','".$BookingDetailsData->sender_suburb."','".$BookingDetailsData->sender_state."','".$BookingDetailsData->sender_postcode."','".$BookingDetailsData->sender_email."','".$BookingDetailsData->sender_contact_no."','".$BookingDetailsData->sender_mobile_no."','".$BookingDetailsData->reciever_firstname."','".$BookingDetailsData->reciever_surname."','".$BookingDetailsData->reciever_company_name."','".$BookingDetailsData->reciever_address_1."','".$BookingDetailsData->reciever_address_2."','".$BookingDetailsData->reciever_address_3."','".$BookingDetailsData->reciever_suburb."','".$BookingDetailsData->reciever_state."','".$BookingDetailsData->reciever_postcode."','".$BookingDetailsData->reciever_email."','".$BookingDetailsData->reciever_contact_no."','".$BookingDetailsData->reciever_mobile_no."','".$BookingDetailsData->date_ready."','".$BookingDetailsData->time_ready."','".$BookingDetailsData->booking_date."','".$BookingDetailsData->booking_time."','".$BookingDetailsData->pickup_time_zone."','".$BookingDetailsData->delivery_time_zone."','".$BookingDetailsData->pagename."','".$BookingDetailsData->servicepagename."','".$BookingDetailsData->CCConnote."','".$BookingDetailsData->BookingNumber."','".$BookingDetailsData->p_id."','".$BookingDetailsData->d_id."','".$BookingDetailsData->pro_froma_invoice."'),";
						
						$i = $i+1;
					}
				}

			}
			//echo "cnt".$cnt;
			//echo "alreadyaddedRecord".$alreadyaddedRecord;
			if($i > 0) {
				$str = substr($str, 0, strlen($str)-1); 
				$qr = "INSERT INTO booking_details (flag,userid,pageid,webservice,payment_done,pickupid,deliveryid,distance_in_km,total_qty,total_weight,volumetric_weight,chargeable_weight,standard_rate,express_rate,international_rate,priority_rate,overnight_rate,economy_rate,description_of_goods,dangerous_goods,tansient_warranty,values_of_goods,authority_to_leave,where_to_leave_shipment,additional_cost,coverage_rate,service_name,sender_first_name,sender_surname,sender_company_name,sender_address_1,sender_address_2,sender_address_3,sender_suburb,sender_state,sender_postcode,sender_email,sender_contact_no,sender_mobile_no,reciever_firstname,reciever_surname,reciever_company_name,reciever_address_1,reciever_address_2,reciever_address_3,reciever_suburb,reciever_state,reciever_postcode,reciever_email,reciever_contact_no,reciever_mobile_no,date_ready,time_ready,booking_date,booking_time,pickup_time_zone,delivery_time_zone,pagename,servicepagename,CCConnote,BookingNumber,p_id,d_id,pro_froma_invoice) VALUES $str";
				$con=mysqli_connect(DATABASE_HOST,DATABASE_USERNAME,DATABASE_PASSWORD,DATABASE_NAME);
				mysqli_query($con,$qr);
				if(mysqli_insert_id($con)){
				$message        = MSG_ADD_BOOKING_DETAIL_SUCCESS;}

			} elseif($cnt == $alreadyaddedRecord  && $alreadyaddedRecord >= 1) {
				$message = ERROR_ALREADY_INTERNATIONAL_AVAILABLE_CSV_FILE;

			}else{
                if($message==""){
				$message = ERROR_CSV_FILE_FORMAT;
                }
			}
			header('Location: '.FILE_BOOKING_DETAILS_ACTION.'?message='.$message);die();
		}


	}
}

	if($booking_id!='')
	{
		$seaByArr[]=array('Search_On'=>'booking_id', 'Search_Value'=>"$booking_id", 'Type'=>'int', 'Equation'=>'=', 'CondType'=>'and', 'Prefix'=>'', 'Postfix'=>'');
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
			$display_style_international = "style='visibility:visible'";
		}else{
			//for australia
			$display_style_australia = "style='visibility:visible'";
			$display_style_international = "style='display:none'";
		}
	}else
	{
		$display_style_australia = "style='visibility:visible'";
		$display_style_international = "style='display:none'";
	}

	$flag_for_searching ="international";
	$seaByArrforPackage[]=array('Search_On'=>'type', 'Search_Value'=>$flag_for_searching, 'Type'=>'string', 'Equation'=>'like', 'CondType'=>'and', 'Prefix'=>'', 'Postfix'=>'');
	$package_type = $ObjInternationalMaster->getItemType($fieldArr,$seaByArrforPackage);
	$message = $_GET['message'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php if ($_GET['booking_id']=='') { echo ADMIN_ADD_BOOKING_DETAIL; } else { echo ADMIN_EDIT_BOOKING_DETAIL;}?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<?php
addCSSFileAdmin($arr_css_admin_include, $arr_css_admin_exclude);
addJavaScriptFile($arr_javascript_include, $arr_javascript_exclude); 
addPluginCSSFile($arr_css_plugin_include,$arr_css_plugin_exclude);
addPluginJavaScriptFile($arr_javascript_plugin_include,$arr_javascript_plugin_exclude);
?>
<script>
$(document).ready(function() {
    $('#maintable').dataTable();
} );
</script> 
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
			<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
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
							
											<tr>
											<td colspan="4" align="left" valign="top" class="grayheader">
											<b><?php echo ADMIN_POSTCODE_UPLOAD_CSV;?> : </td>
											</tr>
											<tr><td colspan="4">&nbsp;</td></tr>
											
											<?php
											
											if($message!='')
											{ ?>
											<tr>
												<td class="message_error noprint" align="center"><?php echo $arr_message1[$message] ; ?></td>
											</tr>
											
											<?php }  ?>		
												
											<tr>
												<td>
													<form name="frmimport" method="POST" action="#" enctype="multipart/form-data" >
													
														<table border="0" width="100%" cellpadding="0" cellspacing="2">
															<tr>
																<td  colspan="2"><?php // echo draw_separator($sep_width,10);?></td>															
															</tr>
															
															<tr>
																<td width="20%" class="form_caption"><?php echo ADMIN_UPLOAD_CSV;?> : </td>
																<td><input type="file" name="csv_file" id="csv_file" ></td>
															</tr>
														
															<tr>
																<td><?php //echo draw_separator($sep_width,$sep_height);?></td>
																<td align="left"><input type="submit" name="btnimport" value="Upload CSV" id="btnimport" class="action_button"></td>
															</tr>
														</table>
													</form>
												</td>
											</tr>

							
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
													{			$cond = ($country_val["userid"]==$user_cond)?("selected"):('');
													$countryname=$country_val["email"];
													$countryOutput.='<option value="'.$country_val["userid"].'"';
													$countryOutput.=$cond;
													$countryOutput.='  >'.trim($countryname).'</option>';
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
												<input type="hidden" name="pickupzone" value="<?php echo ($_POST['pickupzone']!="")?($_POST['pickupzone']):("");?>" id="pickupzone" />
												<input type="hidden" name="pickupid" value="<?php echo ($_POST['pickupid']!="")?($_POST['pickupid']):($BookingDetail->pickupid);?>" id="pickupid" />
												<input type="hidden" name="fetchpickupid" value="<?php echo ($_POST['fetchpickupid']!="")?($_POST['fetchpickupid']):($BookingDetail->p_id);?>" id="fetchpickupid" />
												<?php
												 $pickupid_cond=	($_POST['fetchpickupid']!="")?($_POST['fetchpickupid']):($BookingDetail['p_id']);
												?>										
												<input type="text" class="change_all_data pick_form_textbox_big"  name="PickupPostcode" id="pickup"   autocomplete="off" onkeyup="ajax_showOptions(this,'admin_search',event,'<?php echo DIR_HTTP_RELATED."tms_index.php"; ?>','ajax_index_listOfOptions');" style="<?php echo $css;?>" value="<?php if($_POST['PickupPostcode']!=""){echo $_POST['PickupPostcode'];}else{echo $BookingDetail['pickupid'];}?>"/><img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>internal/help_up.gif" class="help_btn" alt="<?php echo PICKUP_FROM;?>" onmouseover="return overlib('<?php echo $Pick_Up_From;?>');" onmouseout="return nd();" />-
												<span  id="deliverResult" name="deliverResult" class="autocomplete_index"></span></br>
												</td>
												<td  align="left" valign="middle"><?php echo DILIVER_TO;?></td>
												<td  align="left" valign="top" class="message_mendatory">										
												<input type="hidden" name="deliveryzone" value="<?php echo ($_POST['deliveryzone']!="")?($_POST['deliveryzone']):("");?>" id="deliveryzone" />
												<input type="hidden" name="deliveryid" value="<?php echo ($_POST['deliveryid']!="")?($_POST['deliveryid']):($BookingDetail->deliveryid);?>" id="deliveryid" />
												<input type="hidden" name="fetchdeliveryid" value="<?php  echo ($_POST['fetchdeliveryid']!="")?($_POST['fetchdeliveryid']):($BookingDetail->d_id);?>" id="fetchdeliveryid" />												
												<?php
												//for australia category
												$deliveryidforaustralia_cond=	($_POST['fetchdeliveryid']!="")?($_POST['fetchdeliveryid']):($BookingDetail['d_id']);
												?>
												<input type="text" class="change_all_data pick_form_textbox_big" name="DeliveryPostcode" id="delivery" <?php echo $display_style_australia;?> autocomplete="off" onkeyup="ajax_showOptions(this,'admin_search',event,'<?php echo DIR_HTTP_RELATED."tms_index.php"; ?>','ajax_index_listOfOptions');" style="<?php echo $css;?>" value="<?php if($_POST['DeliveryPostcode']!=""){echo $_POST['DeliveryPostcode'];}else{echo $BookingDetail['deliveryid'];}?>"  />
												<span  id="deliverResult" name="deliverResult" class="autocomplete_index"></span></br>
												<?php
												//for international category
												$countryOutput ="";
												$selectCountryId=$BookingDetail->deliveryid;
												$deliveryidforinternational_cond=	($_POST['deliveryidforinternational']!="")?($_POST['deliveryidforinternational']):($selectCountryId);
												$fieldArr = array("id","country","days");
												$Internationaldata = $InternationalzonesMasterObj->getInternationalZones($fieldArr);
												$countryOutput.="<select name='deliveryidforinternational' class ='pick_form_textbox_index' size='1' style='width: 50mm;display:none' id='deliveryidforinternational' $display_style_international><option>SELECT COUNTRY</option>";
												foreach($Internationaldata as $country_val)
												{
													$cond = ($country_val["id"]==$deliveryidforinternational_cond)?("selected"):('');
													$cond .= " rel='".$country_val["id"]."'";
													$countryname=$country_val["country"]."(".$country_val['days'].")";
													$countryOutput.='<option value="'.$country_val["id"].'"';
													$countryOutput.=$cond;
													$countryOutput.='>'.trim($countryname).'</option>';
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
												<td  align="left" valign="middle"><?php echo WEBSERVICE;?>&nbsp;</td>
													<td  align="left" valign="middle"  class="message_mendatory">
													<input type="hidden" value="<?php echo ($_POST['webservice']!="")?($_POST['webservice']):($BookingDetail->webservice);
													?>" name="webservice" id="webservice"/>
													<input type="text" disabled="true" name='tempwebservice' value="<?php echo ($_POST['tempwebservice']!="")?($_POST['tempwebservice']):($BookingDetail->webservice);
													?>" id='tempwebservice' />
													<img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>internal/help_up.gif" class="help_btn" alt="<?php echo WEBSERVICE;?>" onmouseover="return overlib('<?php echo $Webservice;?>');" onmouseout="return nd();" />
													
												</td>
												
												<td  align="left" valign="middle" id="hide_package_type" class="hide_package_type" style="display:none">
												<?php echo PACKAGE_TYPE;?></td>
												<td  align="left" valign="top" id="hide_package_type" class="hide_package_type" class="message_mendatory" style="color: red;display:none; ">
													<?php
													$cont = '';
													
													$cont .= "<select name='package_type' id='package_type'><option value=''>Please Select Any One</option>";
													foreach ($package_type as $package_type){

														$cont .=  "<option value='".$package_type->item_id."'";
														$cont .= ($BookingDetail['pro_froma_invoice']!="" && $package_type->item_id=="5")?("selected"):("");
														$cont .= ">".$package_type->item_name."</option>";

													}
													$cont .="</select>";
													echo $cont ;
													?>
													<img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>internal/help_up.gif" class="help_btn" alt="<?php echo PACKAGE_TYPE;?>" onmouseover="return overlib('<?php echo $flagforbookingdetails;?>');" onmouseout="return nd();" />
													</td>
												
												<!--<td colspan="2" id="hide_package_type" style="display:none">
												<table>
												<tr>
												<td  align="left" valign="middle"><?php echo PACKAGE_TYPE;?></td>
													<td  align="left" valign="top" class="message_mendatory" style="color: red; padding-left: 18px;">
													<?php
													/*$cont = '';
													
													$cont .= "<select name='package_type' id='package_type'><option value=''>Please Select Any One</option>";
													foreach ($package_type as $package_type){

														$cont .=  "<option value='".$package_type->item_id."'";
														$cont .= ($BookingDetail['pro_froma_invoice']!="" && $package_type->item_id=="5")?("selected"):("");
														$cont .= ">".$package_type->item_name."</option>";

													}
													$cont .="</select>";
													echo $cont ;*/
													?>
													<img src="<?php /*echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES;*/ ?>help_up.gif" class="help_btn" alt="<?php /*echo PACKAGE_TYPE;*/?>" onmouseover="return overlib('<?php /*echo $flagforbookingdetails;*/?>');" onmouseout="return nd();" />
													</td>	
												</tr>
									</table>
																
																
									</td>-->
									</tr>
									<tr>
										<td align="left" valign="middle">&nbsp;</td>
										<td align="left" valign="top" class="message_mendatory" id="serviceError"><?php echo $err['serviceError'];  ?></td>
										<td align="left" valign="middle">&nbsp;</td>
										<td align="left" valign="top" class="message_mendatory" id="description_of_goodsError"><?php echo $err['description_of_goodsError'];  ?></td>
									</tr>	
									
									
									<tr>
												<td  align="left" valign="middle"  class="hidedistance_in_km" <?php echo $display_style_australia;?>><?php echo DISTANCEINKM;?>&nbsp;</td>
												<td  align="left" valign="middle"  class=" hidedistance_in_km message_mendatory"  class="hidedistance_in_km">
												<input  type="text" id="distance_in_km" class="input_consignor" name="distance_in_km" value="<?php if($BookingDetail['distance_in_km']==""){echo $_POST['distance_in_km'];}else{ echo $BookingDetail['distance_in_km'];}?>" /></span><img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>internal/help_up.gif" class="help_btn" alt="Flag" onmouseover="return overlib('<?php echo $Distance_Km;?>');" onmouseout="return nd();" />
										    	<td  align="left" valign="middle"><?php echo TOTAL_QUENTITY;?></td>
												<td  align="left" valign="top" class="message_mendatory">
												<input  type="text" class="input_consignor" id="total_qty" name="total_qty"  value="<?php if($_POST['total_qty']==""){echo $BookingDetail['total_qty'];}else{ echo $_POST['total_qty'];}?>" onblur="javascript:display_all_value(<?php echo $volumetric_divisor;?>);"/><img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>internal/help_up.gif" class="help_btn" alt="<?php echo TOTAL_QUENTITY;?>" onmouseover="return overlib('<?php echo $Total_Quentity;?>');" onmouseout="return nd();" /></td>
									</tr>
									
										<!--						
									<tr>
										<td  align="left" valign="middle" colspan="2">
										<div id="hidedistance_in_km" <?php echo $display_style_australia;?>><span><?php echo DISTANCEINKM;?>&nbsp;</span><input  type="text" id="distance_in_km" class="input_consignor" name="distance_in_km" value="<?php if($BookingDetail['distance_in_km']==""){echo $_POST['distance_in_km'];}else{ echo $BookingDetail['distance_in_km'];}?>" /></span><img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>help_up.gif" class="help_btn" alt="Flag" onmouseover="return overlib('<?php echo $Distance_Km;?>');" onmouseout="return nd();" /></div>
										<div id="hidepro_froma_invoice" <?php echo $display_style_international;?>><span><?php echo PRO_FORMA_INVOICE;?>&nbsp;</span>
										<?php
										/*$cont = '';
										$cont .= "<select name='pro_froma_invoice' id='pro_froma_invoice'><option value=''>Please Select Any One</option>";
										foreach ($pro_froma_invoice as $key => $val){

											$cont .=  "<option value='".$val."'";
											$cont .= ($BookingDetail['pro_froma_invoice']=="$val" )?("selected"):("");
											$cont .= ">".$val."</option>";

										}
										$cont .="</select>";
										echo $cont ;*/
										?>
										</span><img src="<?php /*echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES;*/ ?>help_up.gif" class="help_btn" alt="<?php echo DISTANCEINKM;?>" onmouseover="return overlib('<?php echo $pro_form_invoice;?>');" onmouseout="return nd();" /></div>
										</td>
										<td  align="left" valign="middle"><?php /*echo TOTAL_QUENTITY;*/?></td>
										<td  align="left" valign="top" class="message_mendatory"><input  type="text" class="input_consignor" id="total_qty" name="total_qty"  value="<?php if($_POST['total_qty']==""){echo $BookingDetail['total_qty'];}else{ echo $_POST['total_qty'];}?>" onblur="javascript:display_all_value(<?php echo $volumetric_divisor;?>);"/><img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>help_up.gif" class="help_btn" alt="<?php echo TOTAL_QUENTITY;?>" onmouseover="return overlib('<?php echo $Total_Quentity;?>');" onmouseout="return nd();" /></td>
									</tr>-->
									<tr>
										<td align="left" valign="middle">&nbsp;</td>
										<td align="left" valign="top" class="message_mendatory" id="PickUpError"><?php ?></td>
										<td align="left" valign="middle">&nbsp;</td>
										<td align="left" valign="top" class="message_mendatory" id="DeliverToError"><?php ?></td>
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
											<td align="left" valign="top" class="message_mendatory" id="PickUpError"><?php  ?></td>
											<td align="left" valign="middle">&nbsp;</td>
											<td align="left" valign="top" class="message_mendatory" id="DeliverToError"><?php  ?></td>
									</tr>				
									<tr>
											<td  align="left" valign="middle"><?php echo LENGTH;?></td>
												<td   align="left" valign="top" class="message_mendatory"><input  type="text" id="length" class="input_consignor" name="length" value="<?php echo ($_POST['length']!="")?($_POST['length']):($common_height_width_length);?>" onblur="javascript:display_all_value(<?php echo $volumetric_divisor;?>);"/><img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>internal/help_up.gif" class="help_btn" alt="<?php echo LENGTH;?>" onmouseover="return overlib('<?php echo $Length;?>');" onmouseout="return nd();" /></td>
												
												
												<td  align="left" valign="middle"><?php echo ITEM_WEIGHT;?>&nbsp;</td>
												<td  align="left" valign="middle"  class="message_mendatory">
				
												<input type="hidden" name="item_weight" id="item_weight" value="<?php if($_POST['item_weight']==""){echo ceil($item);}else{ echo $_POST['item_weight'];}?>" onblur="javascript:display_all_value(<?php echo $volumetric_divisor;?>);"/>
												
					<?php if($BookingDetail['total_qty']!="" && $BookingDetail['total_qty']>= 1 && $BookingDetail['total_weight']!=""){$item = $BookingDetail['total_weight']/$BookingDetail['total_qty'];}
			
				?>							
					
												<?php echo getItemWeight($item,"input_consignor","international_item_weight","international_item_weight","javascript:display_all_value( $volumetric_divisor);"); 	?>
												<input  type="text" class="input_consignor" id="australia_item_weight" name="australia_item_weight" value="<?php if($_POST['australia_item_weight']!=""){echo $_POST['australia_item_weight'];}else{ echo $item;}?>"  onblur="javascript:display_all_value(<?php echo $volumetric_divisor;?>);"/><img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>internal/help_up.gif" class="help_btn" alt="<?php echo ITEM_WEIGHT;?>" onmouseover="return overlib('<?php echo $Item_Weight ;?>');" onmouseout="return nd();" />
												</td>		
									</tr>
									<tr>
											<td align="left" valign="middle">&nbsp;</td>
											<td align="left" valign="top" class="message_mendatory" id="PickUpError" colspan="3"><?php   ?></td>
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
										
										
												
									<td  align="left" valign="middle"><?php echo RATE;?></td>
										<td  colspan="3" align="left" valign="top" class="message_mendatory"><input  type="text" id="rate" class="input_consignor" name="rate" value="<?php echo ($_POST['rate']!="")?($_POST['rate']):($BookingDetail[$service_name]);?>" /><img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>internal/help_up.gif" class="help_btn" alt="<?php echo RATE;?>" onmouseover="return overlib('<?php echo $Rate;?>');" onmouseout="return nd();" /></td>
									
										
										
										
										
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
										<textarea class="input_consignor" name="description_of_goods" ><?php if($BookingDetail['description_of_goods']==""){echo $_POST['description_of_goods'];}else{ echo $BookingDetail['description_of_goods'];}?></textarea>								
										<span id="temp_additional_cost">
										<input  type="hidden" class="input_consignor" name="additional_cost" id="additional_cost" value="<?php if($BookingDetail['additional_cost']==""){echo $_POST['additional_cost'];}else{ echo $BookingDetail['additional_cost'];}?>" />
										</span>
										<img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>internal/help_up.gif" class="help_btn" alt="<?php echo DESCRIPTION_OF_GOODS;?>" onmouseover="return overlib('<?php echo $Description_Of_Goods;?>');" onmouseout="return nd();" />
										</td>
										<td  align="left" valign="middle" class="hidepro_froma_invoice"><?php echo PRO_FORMA_INVOICE;?>&nbsp;</td>
										<td  align="left"  class="hidepro_froma_invoice message_mendatory" <?php echo $display_style_international;?>><?php
										$cont = '';
										$cont .= "<select name='pro_froma_invoice' id='pro_froma_invoice'><option value=''>Please Select Any One</option>";
										foreach ($pro_froma_invoice as $key => $val){

											$cont .=  "<option value='".$val."'";
											$cont .= ($BookingDetail['pro_froma_invoice']=="$val" )?("selected"):("");
											$cont .= ">".$val."</option>";

										}
										$cont .="</select>";
										echo $cont ;
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
										<td  align="left" valign="middle"  ><?php echo TRANSIENT_WARRENTY;?>&nbsp;</td>
										<td  align="left" valign="middle"  class="  message_mendatory" >
											<input type="radio" tabindex="5" name="transit_warranty" id="transit_warranty" value="yes" <?php if ($BookingDetail->tansient_warranty=="yes"){echo "checked";}?> onclick="javascript:common_hide(this.name,this.value);">Yes <input type="radio" tabindex="6"  name="transit_warranty" id="transit_warranty"  value="no" <?php if ($BookingDetail->tansient_warranty=="no" || $BookingDetail->tansient_warranty==""){echo "checked";}?> onclick="javascript:common_hide(this.name,this.value);" > No<img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>internal/help_up.gif" class="help_btn" alt="<?php echo TRANSIENT_WARRENTY;?>" onmouseover="return overlib('<?php echo $Transient_Warrenty;?>');" onmouseout="return nd();" />
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
										<input type="hidden" name="minimum_transient_value" id="minimum_transient_value" value="<?php echo $minimum_transient_value;?>"/>
										<input type="hidden" name="coverage_rate" id="coverage_rate" value="<?php if($BookingDetail['coverage_rate']==""){echo $_POST['coverage_rate'];}else{ echo $BookingDetail['coverage_rate'];}?>"?>
										<input  type="text" class="input_consignor" name="values_of_goods" id="values_of_goods" value="<?php if($BookingDetail['values_of_goods']==""){echo $_POST['values_of_goods'];}else{ echo $BookingDetail['values_of_goods'];}?>" onblur="javascript:change_tempcoverage_rate(<?php echo $minimum_transient_value;?>)"/>									</td>
										</td>
										<td  align="left" valign="middle" class="hide_values_of_goods"><?php echo COVERAGE_FEE;?></td>
										<td  align="left"  class="message_mendatory hide_values_of_goods"><b>$<span id="tempcoverage_rate"><?php echo $BookingDetail['coverage_rate']?></span>		
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
												<textarea class="input_consignor"  class="temp_where_to_leave_shipment" name="where_to_leave_shipment" id="where_to_leave_shipment" > <?php if($BookingDetail['where_to_leave_shipment']==""){echo $_POST['where_to_leave_shipment'];}else{ echo $BookingDetail['where_to_leave_shipment'];}?></textarea>	
												</td>
													
										    	<td  align="left" valign="middle" class="temp_where_to_leave_shipment" style="display:none">&nbsp;</td>
												<td  align="left" valign="top" class="message_mendatory temp_where_to_leave_shipment" style="display:none">&nbsp;</span>		
												</td>
													
											</tr>							
															
														
														
										<!--<tr >
											<td colspan="4"> 
											<table id="temp_where_to_leave_shipment" style="display:none">
											<tr>
												<td  colspan="4">
												<table>
												
													<tr>
														<td  align="left" valign="middle" colspan="2">
													
													<?php /*echo  WHERE_TO_LIVE_SHIPMENT;*/?>
														</td>
														<td  align="left" valign="top" class="message_mendatory" colspan="2"><textarea class="input_consignor" name="where_to_leave_shipment" id="where_to_leave_shipment" > <?php if($BookingDetail['where_to_leave_shipment']==""){echo $_POST['where_to_leave_shipment'];}else{ echo $BookingDetail['where_to_leave_shipment'];}?></textarea>		
														</td>
													</tr>
												</table>
												</td>
											</tr>
											</table>
											</td>
										</tr>	-->			
										<tr>
											<td align="left" valign="middle">&nbsp;</td>
											<td align="left" valign="top" class="message_mendatory" id="PickUpError"><?php   ?></td>
											<td align="left" valign="middle">&nbsp;</td>
											<td align="left" valign="top" class="message_mendatory" id="DeliverToError"><?php  ?></td>
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
											<td  align="left" valign="middle"  class="message_mendatory"><input  type="text" class="input_consignor" name="sender_first_name" value="<?php if($BookingDetail['sender_first_name']==""){echo $_POST['sender_first_name'];}else{ echo $BookingDetail['sender_first_name'];}?>" />
											<img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>internal/help_up.gif" class="help_btn" alt="<?php echo  SENDER_FIRST_NAME;?>" onmouseover="return overlib('<?php echo $FirstName;?>');" onmouseout="return nd();" />
											</td>
											<td  align="left" valign="middle"><?php echo RECEIVER_FIRST_NAME;?></td>
											<td  align="left" valign="top" class="message_mendatory"><input  type="text" class="input_consignor" name="reciever_first_name" value="<?php if($BookingDetail['reciever_firstname']==""){echo $_POST['reciever_first_name'];}else{ echo $BookingDetail['reciever_firstname'];}?>" />
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
											<td  align="left" valign="middle"  class="message_mendatory"><input  type="text" class="input_consignor" name="sender_surname" value="<?php if($BookingDetail['sender_surname']==""){echo $_POST['sender_surname'];}else{ echo $BookingDetail['sender_surname'];}?>" /><img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>internal/help_up.gif" class="help_btn" alt="<?php echo  SENDER_SURNAME;?>" onmouseover="return overlib('<?php echo $LastName;?>');" onmouseout="return nd();" />
											
											</td>
											<td  align="left" valign="middle"><?php echo RECEIVER_SURNAME;?></td>
											<td  align="left" valign="top" class="message_mendatory"><input  type="text" class="input_consignor" name="reciever_surname" value="<?php if($BookingDetail['reciever_surname']==""){echo $_POST['reciever_surname'];}else{ echo $BookingDetail['reciever_surname'];}?>" />
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
											<td  align="left" valign="middle"  class="message_mendatory"><input  type="text" class="input_consignor" name="sender_company_name" value="<?php if($BookingDetail['sender_company_name']==""){echo $_POST['sender_company_name'];}else{ echo $BookingDetail['sender_company_name'];}?>" />
											<img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>internal/help_up.gif" class="help_btn" alt="<?php echo  SENDER_COMPANY_NAME;?>" onmouseover="return overlib('<?php echo $CompanyName;?>');" onmouseout="return nd();" />
											</td>
											<td  align="left" valign="middle"><?php echo RECEIVER_COMPANY_NAME;?></td>
											<td  align="left" valign="top" class="message_mendatory"><input  type="text" class="input_consignor" name="reciever_company_name" value="<?php if($BookingDetail['reciever_company_name']==""){echo $_POST['reciever_company_name'];}else{ echo $BookingDetail['reciever_company_name'];}?>" />
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
											<td  align="left" valign="middle"  class="message_mendatory"><input type="text" class="input_consignor" name="sender_address_1" value="<?php if($BookingDetail['sender_address_1']==""){echo $_POST['sender_address_1'];}else{echo $BookingDetail['sender_address_1'];} ?>"/>
											<img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>internal/help_up.gif" class="help_btn" alt="<?php echo  SENDER_ADDRESS;?>" onmouseover="return overlib('<?php echo $Address;?>');" onmouseout="return nd();" />
											</td>
											<td  align="left" valign="middle"><?php echo RECEIVER_ADDRESS;?></td>
											<td  align="left" valign="top" class="message_mendatory"><input type="text" class="input_consignee" name="reciever_address_1" value="<?php if($BookingDetail['reciever_address_1']==""){echo $_POST['reciever_address_1'];}else{echo $BookingDetail['reciever_address_1'];} ?>"/>
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
											<td  align="left" valign="middle"  class="message_mendatory"><input type="text" class="input_consignor" name="sender_address_2" value="<?php if($BookingDetail['sender_address_2']==""){echo $_POST['sender_address_2'];}else{echo $BookingDetail['sender_address_2'];} ?>"/></td>
											<td  align="left" valign="middle"></td>
											<td  align="left" valign="top" class="message_mendatory"><input type="text" class="input_consignee" name="reciever_address_2" value="<?php if($BookingDetail['reciever_address_2']==""){echo $_POST['reciever_address_2'];}else{echo $BookingDetail['reciever_address_2'];} ?>"/></td></td>
										</tr>
										<tr>
											<td align="left" valign="middle">&nbsp;</td>
											<td align="left" valign="top" class="message_mendatory" id="PickUpError"></td>
											<td align="left" valign="middle">&nbsp;</td>
											<td align="left" valign="top" class="message_mendatory" id="DeliverToError"></td>
										</tr>	
										
										<tr>
											<td  align="left" valign="middle"></td>
											<td  align="left" valign="middle"  class="message_mendatory"><input type="text" class="input_consignor" name="sender_address_3" value="<?php if($BookingDetail['sender_address_3']==""){echo $_POST['sender_address_3'];}else{echo $BookingDetail['sender_address_3'];} ?>"/></td>
											<td  align="left" valign="middle"></td>
											<td  align="left" valign="top" class="message_mendatory"><input type="text" class="input_consignee" name="reciever_address_3" value="<?php if($BookingDetail['reciever_address_3']==""){echo $_POST['reciever_address_3'];}else{echo $BookingDetail['reciever_address_3'];} ?>"/></td>
										</tr>
										<tr>
											<td align="left" valign="middle">&nbsp;</td>
											<td align="left" valign="top" class="message_mendatory" id="PickUpError"></td>
											<td align="left" valign="middle">&nbsp;</td>
											<td align="left" valign="top" class="message_mendatory" id="DeliverToError"></td>
										</tr>	
										
										<tr>
											<td  align="left" valign="middle"><?php echo SENDER_SUBURB;?></td>
											<td  align="left" valign="middle"  class="message_mendatory"><input type="text" class="input_consignor" name="sender_suburb" value="<?php if($BookingDetail['sender_suburb']==""){echo $_POST['sender_suburb'];}else{echo $BookingDetail['sender_suburb'];} ?>"/><img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>internal/help_up.gif" class="help_btn" alt="<?php echo  SENDER_SUBURB;?>" onmouseover="return overlib('<?php echo $SuburbName;?>');" onmouseout="return nd();" />
											
											</td>
											<td  align="left" valign="middle"><?php echo RECEIVER_SUBURB;?></td>
											<td  align="left" valign="top" class="message_mendatory"><input type="text" class="input_consignee" name="reciever_suburb" value="<?php if($BookingDetail['reciever_suburb']==""){echo $_POST['reciever_suburb'];}else{echo $BookingDetail['reciever_suburb'];} ?>"/><img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>internal/help_up.gif" class="help_btn" alt="<?php echo  RECEIVER_SUBURB;?>" onmouseover="return overlib('<?php echo $SuburbName;?>');" onmouseout="return nd();" />
											
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
											<td  align="left" valign="middle"  class="message_mendatory"><input type="text" class="input_consignor" name="sender_state" value="<?php if($BookingDetail['sender_state']==""){echo $_POST['sender_state'];}else{echo $BookingDetail['sender_state'];} ?>"/><img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>internal/help_up.gif" class="help_btn" alt="<?php echo  SENDER_STATE;?>" onmouseover="return overlib('<?php echo $State;?>');" onmouseout="return nd();" />
											
											</td>
											<td  align="left" valign="middle"><?php echo RECEIVER_STATE;?></td>
											<td  align="left" valign="top" class="message_mendatory"><input type="text" class="input_consignor" name="reciever_state" value="<?php if($BookingDetail['reciever_state']==""){echo $_POST['reciever_state'];}else{echo $BookingDetail['reciever_state'];} ?>"/><img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>internal/help_up.gif" class="help_btn" alt="<?php echo  RECEIVER_STATE;?>" onmouseover="return overlib('<?php echo $State;?>');" onmouseout="return nd();" />
											
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
											<td  align="left" valign="middle"  class="message_mendatory"><input type="text" class="input_consignor" name="sender_email" value="<?php if($BookingDetail['sender_email']==""){echo $_POST['sender_email'];}else{echo $BookingDetail['sender_email'];} ?>"/><img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>internal/help_up.gif" class="help_btn" alt="<?php echo  SENDER_EMAIL;?>" onmouseover="return overlib('<?php echo $Email_Address;?>');" onmouseout="return nd();" />
											</td>
											<td  align="left" valign="middle"><?php echo RECEIVER_EMAIL;?></td>
											<td  align="left" valign="top" class="message_mendatory"><input type="text" class="input_consignor" name="reciever_email" value="<?php if($BookingDetail['reciever_email']==""){echo $_POST['reciever_email'];}else{echo $BookingDetail['reciever_email'];} ?>"/><img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>internal/help_up.gif" class="help_btn" alt="<?php echo  RECEIVER_EMAIL;?>" onmouseover="return overlib('<?php echo $Email_Address;?>');" onmouseout="return nd();" />
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
                                            <label>
                                            <div class="form-group">
                							<div class='input-group date'  id='datetimepicker6' data-link-field="dtp_input1"  >
                							<span class="input-group-addon" style="display:inline-block !important;">
                							<input type='hidden' class="form-control" id="dtp_input1" />
                                            <img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>522954.png"  alt="Pickup From" border="0"  /></span></label>
                                            <input readonly type="text" id="date_ready" name="date_ready" style="width:250px;" value="<?php if($BookingDetail['date_ready']==""){echo $_POST['date_ready'];}else{echo $BookingDetail['date_ready'];} ?>" class="register"><span> *</span><img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>internal/help_up.gif" class="help_btn" alt="<?php echo  DATE_READY;?>" onmouseover="return overlib('<?php echo $Date_Ready;?>');" onmouseout="return nd();" />
											</div>
                                            </div>
											</td>
											<td  align="left" valign="middle"><?php echo BOOKING_DATE;?></td>
											<td  align="left" valign="middle"  class="message_mendatory">
                                            <label>
                                            <div class="form-group">
                							<div class='input-group date'  id='datetimepicker7' data-link-field="dtp_input2"  >
                							<span class="input-group-addon" style="display:inline-block !important;">
                							<input type='hidden' class="form-control" id="dtp_input2" /><img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>522954.png"  alt="Pickup From" border="0"  /></span></label><input readonly type="text" id="booking_date" name="booking_date" style="width:250px;" value="<?php if($BookingDetail['booking_date']==""){echo $_POST['booking_date'];}else{echo $BookingDetail['booking_date'];} ?>" class="register"><span> *</span><img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>internal/help_up.gif" class="help_btn" alt="<?php echo  BOOKING_DATE;?>" onmouseover="return overlib('<?php echo $Booking_Date;?>');" onmouseout="return nd();" />
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
											$pickup_time_zone_cond=	($_POST['pickup_time_zone']!="")?($_POST['pickup_time_zone']):($BookingDetail['pickup_time_zone']);
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
											$delivery_time_zone_cond=	($_POST['delivery_time_zone']!="")?($_POST['delivery_time_zone']):($BookingDetail['delivery_time_zone']);
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
										
									
										<span style="width:10px;">&nbsp;</span>
																									<?php $ready_by_time_hr = '';
																									$ready_by_time_hr .= "<select name='time_ready_time_hr'>";
																									foreach ($hh as $ser){
																										$ready_by_time_hr .=  "<option value='".$ser."'";
																										$ready_by_time_hr .= ($ser==$ready_hours[0])?("selected"):("");
																										$ready_by_time_hr .= ">".$ser."</option>";
									
																									}
																									$ready_by_time_hr .="</select>";
																									echo $ready_by_time_hr ;
																									?>
									
											<?php
											$ready_by_time_sec = '';
											$ready_by_time_sec  .= "<select name='time_ready_time_sec'>";
											foreach ($mm as $ser){
												$ready_by_time_sec .=  "<option value='".$ser."'";
												$ready_by_time_sec .= ($ser==$ready_minutes[0])?("selected"):("");
												$ready_by_time_sec .= ">".$ser."</option>";
									
											}
											$ready_by_time_sec .="</select>";
											echo $ready_by_time_sec ;
																									?>
																										<?php
																										$ready_by_hr_formate = '';
																										$ready_by_hr_formate .= "<select name='time_ready_hr_formate'>";
																										foreach ($am_pm as $ser){
																											$ready_by_hr_formate .=  "<option value='".$ser."'";
																											$ready_by_hr_formate .= ($ser==$ready_minutes[1])?("selected"):("");
																											$ready_by_hr_formate .= ">".$ser."</option>";
									
																										}
																										$ready_by_hr_formate .="</select>";
																										echo $ready_by_hr_formate ;
																									?>
											
											
										</td>
										<td><span class="pickup_form"><?php echo BOOKING_TIME; ?>:</span></td>
										<td>
										<span style="width:10px;">&nbsp;</span>
											<?php $delivery_by_time_hr = '';
											$delivery_by_time_hr .= "<select name='booking_time_hr'>";
											foreach ($hh as $ser){
												$delivery_by_time_hr .=  "<option value='".$ser."'";
												$delivery_by_time_hr .= ($ser==$delivery_hours[0])?("selected"):("");
												$delivery_by_time_hr .= ">".$ser."</option>";
									
											}
											$delivery_by_time_hr .="</select>";
											echo $delivery_by_time_hr ;
																									?>
									
											<?php
											$delivery_by_time_sec = '';
											$delivery_by_time_sec  .= "<select name='booking_time_sec'>";
											foreach ($mm as $ser){
												$delivery_by_time_sec .=  "<option value='".$ser."'";
												$delivery_by_time_sec .= ($ser==$delivery_minutes[0])?("selected"):("");
												$delivery_by_time_sec .= ">".$ser."</option>";
									
											}
											$delivery_by_time_sec .="</select>";
											echo $delivery_by_time_sec ;
											?>
											<?php
											$delivery_by_hr_formate = '';
											$delivery_by_hr_formate .= "<select name='booking_time_hr_formate'>";
											foreach ($am_pm as $ser){
												$delivery_by_hr_formate .=  "<option value='".$ser."'";
												$delivery_by_hr_formate .= ($ser==$delivery_minutes[1])?("selected"):("");
												$delivery_by_hr_formate .= ">".$ser."</option>";

											}
											$delivery_by_hr_formate .="</select>";
											echo $delivery_by_hr_formate ;
														?>
											
											
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
										
										<td  align="left" valign="top" class="message_mendatory" ><input type="text" class="input_consignor" name="CCConnote" value="<?php if($BookingDetail['CCConnote']==""){echo $_POST['CCConnote'];}else{echo $BookingDetail['CCConnote'];} ?>"/><img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>internal/help_up.gif" class="help_btn" alt="<?php echo CCCONNOTE;?>" onmouseover="return overlib('<?php echo $Shopping_Number;?>');" onmouseout="return nd();" />
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
											<input type="submit" class="action_button" tabindex="36" name="submit" value="<?php echo $btnSubmit; ?>" onclick="return validate_client(this.form);" >
											<input type="reset" tabindex="37" name="reset" class="action_button" value="<?php echo ADMIN_COMMON_BUTTON_RESET; ?>" >
											<input type="button"  class="action_button" name="cancel" tabindex="38" value="<?php echo ADMIN_COMMON_BUTTON_CANCEL;?>" onclick="javascript:document.location.href='<?php echo FILE_BOOKING_DETAILS_LISTING; ?>';return true;"/>
											</td>
										</tr>
										<tr>
											<td>&nbsp;</td>
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
<?php require_once(DIR_WS_JSCRIPT."/jquery.php"); ?>
<script type="text/javascript">
var first = moment().format('DD MMMM YYYY');

 
$('#datetimepicker7').datetimepicker({
	weekStart: 1,
	defaultDate: new Date(),
	format: 'DD MMMM YYYY',					
	pickTime: false,
	todayHighlight: 1,
	showToday: true,
	setStartDate: 'DD MMMM YYYY',
	minDate:first,
	daysOfWeekDisabled: '0,6',
	disabledDates: [<?php echo $date_arr;?>]
});

$("#datetimepicker7").on("dp.change",function (e) { 
	$('#start_date').val($('#dtp_input2').val());
});

var first = moment().format('DD MMMM YYYY');

 
$('#datetimepicker6').datetimepicker({
	weekStart: 1,
	defaultDate: new Date(),
	format: 'DD MMMM YYYY',					
	pickTime: false,
	todayHighlight: 1,
	showToday: true,
	setStartDate: 'DD MMMM YYYY',
	minDate:first,
	daysOfWeekDisabled: '0,6',
	disabledDates: [<?php echo $date_arr;?>]
});

$("#datetimepicker6").on("dp.change",function (e) { 
	$('#start_date').val($('#dtp_input1').val());
});
</script>