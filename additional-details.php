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
session_start();
require_once("lib/common.php");
require_once("lib/csrf.php");
require_once(DIR_WS_CURRENT_LANGUAGE . "additional-details.php");
require_once(DIR_WS_CURRENT_LANGUAGE . "commercial_invoice.php");
require_once(DIR_WS_MODEL . "SiteConstantMaster.php");
require_once(DIR_WS_MODEL."CommercialInvoiceMaster.php");
require_once(DIR_WS_MODEL."CommercialInvoiceItemMaster.php");
require_once(DIR_WS_MODEL . "ServiceMaster.php");
require_once(DIR_WS_MODEL . "SupplierMaster.php");
require_once(DIR_WS_MODEL . "SupplierData.php");



$ObjSupplierMaster	= SupplierMaster::Create();
$SupplierData		= new SupplierData();

$arr_css_plugin_include[] = 'glyphicons_new/css/glyphicons.css';

$arr_javascript_include[] = 'pickup.js';
$arr_javascript_include[] = 'commercial_invoice.php';
$arr_javascript_below_include[] = 'internal/additional-details.php';

$ObjServiceMaster	= ServiceMaster::Create();
$ServiceData		= new ServiceData();

if(isset($_GET['step']) && $_GET['step']!="")
{
	$error['step'] = checkStr($_GET['step']);
}
if($error['step']!='')
{
	logOut();
}
if(isset($_GET['step'])){
	$_SESSION['address_return'] = 1;
}
/*
echo "<pre>";
print_r($_SESSION);
echo "</pre>";*/
/*
Below code i have added because if they change any of description fields related 
with goods. They have to compulsory again choose select boxes
*/
if(isset($_SESSION['terms']) && !empty($_SESSION['terms'])){
	unset($_SESSION['terms']);
}
if(isset($_SESSION['dangerousgoods']) && !empty($_SESSION['dangerousgoods'])){
	unset($_SESSION['dangerousgoods']);
}

if(isset($BookingDatashow->dangerousgoods) && $BookingDatashow->dangerousgoods=="0"){
	unset($BookingDatashow->dangerousgoods);
}
/*csrf validation*/
$csrf = new csrf();
$csrf->action = "additional-details";
/*csrf validation*/

if(!isset($_POST['submitbtn']) && $_POST['submitbtn']=='')
{
	$ptoken = $csrf->csrfkey();
}

if(isset($_POST['submitbtn'])&& $_POST['submitbtn']!="")
{

	if(isEmpty(valid_input($_POST['ptoken']), true))
	{
		logOut();
	}
	else
	{
		$csrf->checkcsrf($_POST['ptoken']);
	}
	/*
	$err['goods_nature']	= isEmpty(valid_input($_POST['goods_nature']),COMMON_SHIPPING_TYPE)?isEmpty(valid_input($_POST['goods_nature']),COMMON_SHIPPING_TYPE):checkStr(valid_input($_POST['goods_nature']));
	if($_POST['goods_nature'] == 'commercial')
	{
		$err['goods_nature']	= isEmpty(valid_input($_POST['goods_nature']),REQUIRED_TRANSIT_GOODS_DESCRIPTION)?isEmpty(valid_input($_POST['goods_nature']),REQUIRED_TRANSIT_GOODS_DESCRIPTION):checkStr(valid_input($_POST['goods_nature']));
	}*/
	if(isset($_POST['goods_description_au']) && empty($_POST['goods_description_au']))
	{
		$err['gooddescription'] = checkEmpty($_POST['goods_description_au']);
	}
	if($_POST['goods_description_au'] != "")
	{
		$err['gooddescription'] = checkStr(valid_input($_POST['goods_description_au']));
	}

	if($_POST['shipment_detail'] != "")
	{
		$err['shipment_detail'] = checkStr(valid_input($_POST['shipment_detail']));
	}
	if(chkSmall($_POST['select_transit_warranty']))
	{
		logOut();
	}
  /*
	if(chkSmall($_POST['commercial_invoice']))
	{
		logOut();
	}*/
	if(chkSmall($_POST['confirm_transit_policy']))
	{
		logOut();
	}

	if(chkSmall($_POST['select_authority']))
	{
		logOut();
	}
	if(chkSmall($_POST['service_name']))
	{
		logOut();
	}
	if(isNumFloat($_POST['bookingType'], COMMON_NUMERIC_VAL))
	{
		logOut();
	}
	if(isNumFloat($_POST['service_rate'], COMMON_NUMERIC_VAL))
	{
		logOut();
	}
	if(chkOrgRate($_SESSION['original_amount']))
	{
		logOut();
	}
	
	if($_POST['currency_code'] != "")
	{
		$err['currencycode'] = chkCurrency(valid_input($_POST['currency_code']));
	}
	if(isset($_POST['export_reason']) && empty($_POST['export_reason'])) {
		$err['exportreason'] = checkEmpty($_POST['export_reason']);
	}
		/* if($_POST['export_reason'] != "")
	{
		$err['exportreason'] = checkStr(valid_input($_POST['export_reason']));
	}*/
	if(isset($_POST['commercial_invoice_provider']) && empty($_POST['commercial_invoice_provider'])) {
		$err['comm_inv_provider'] = checkEmpty($_POST['commercial_invoice_provider']);
	}
	if(isset($_POST['country_of_origin']) && empty($_POST['country_of_origin'])) {
		$err['countryorigin'] = checkEmpty($_POST['country_of_origin']);
	}
	if(!isset($_POST['terms_and_conditions']))
	{
		$err['terms_conditions'] = chkBox($_POST['terms_and_conditions']);
	}
	if(!isset($_POST['dangerousgood']))
	{
		$err['dangerousgoods'] = chkBox($_POST['dangerousgood']);
	}
	if(isset($_POST['dangerousgood']) && $_POST['dangerousgood']=='1')
	{
		$err['dangerousgoods'] = chkDG($_POST['dangerousgood']);
	}
	/*if(!isset($_POST['security_statement']))
	{
		$err['securitystatement'] = chkBox($_POST['security_statement']);
	}*/
	if(isset($_POST['transit_warranty_au']) && $_POST['transit_warranty_au']!='')
	{
		$err['transit_warranty_au'] = isNumFloat($_POST['transit_warranty_au'],REQUIRED_TRANSIT_DECLARED_WEIGHT);
	}



	if(isset($_POST['temp_value']) && $_POST['temp_value'] != '')
	{
		if(isNumeric($_POST['temp_value'], COMMON_NUMERIC_VAL))
		{
			logOut();
		}
	}

	if(isset($err))
	{
		foreach($err as $key => $Value) {

			if($Value != '') {
				$Svalidation=true;
				$ptoken = $csrf->csrfkey();
			}
		}
	}

	if ($Svalidation==false) {

		$without_gst_transit_amount = $_POST['without_gst_transit_amount'];
		if($_POST['select_transit_warranty']!="yes"){
			//$coverage_fees[1]="0";
			$coverage_fees="0";
			$without_gst_transit_amount = 0;
			$value_of_goods = '';


		}else{
			//$coverage_fees = $_POST['hidden_transit_txt'];
			$coverage_fees = $_SESSION['transit_amount'];
			$without_gst_transit_amount = $_SESSION['without_gst_transit_amount'];
			$value_of_goods = $_POST['transit_warranty_au'];
		}

		if(isset($_POST['service_name']) && $_POST['service_name']=="international")
		{
			$value_of_goods = $_POST['transit_warranty_au'];
		}

		//echo "value of goods:".$value_of_goods."---".$coverage_fees."----".$without_gst_transit_amount."</br>";
		//exit();
		if($_SESSION['transit_amount']!=0){
			//$price=explode("$",$_POST['transit_amount']);
			$price=explode("$",$_SESSION['transit_amount']);
			$price = $price[0];
		}else{
			$orignial_cost=explode("$",$_SESSION['original_amount']);
			$price="0";
		}

		$BookingDetailsDataObj = new stdClass;
		$BookingDetailsDataObj->description_of_goods = ucwords(strtolower($_POST['goods_description_au']));
		//$BookingDetailsDataObj->tansient_warranty = $_POST['select_transit_warranty'];
		$BookingDetailsDataObj->currency_codes = $_POST['currency_code'];
		$BookingDetailsDataObj->values_of_goods = $value_of_goods;
		$BookingDetailsDataObj->country_origin = $_POST['country_of_origin'];
		$BookingDetailsDataObj->export_reason = $_POST['export_reason'];
		$BookingDetailsDataObj->commercial_invoice_provider = $_POST['commercial_invoice_provider'];
		$BookingDetailsDataObj->authority_to_leave = $_POST['select_authority'];
		$BookingDetailsDataObj->where_to_leave_shipment = ucwords(strtolower($_POST['shipment_detail']));
		$BookingDetailsDataObj->additional_cost = $price; //$orignial_cost[1]
		//exit();
		//$BookingDetailsDataObj->coverage_rate = $coverage_fees[1];
		//$BookingDetailsDataObj->coverage_rate = $coverage_fees;
		//if($without_gst_transit_amount!=0){
		//$BookingDetailsDataObj->without_gst_coverage_rate = $without_gst_transit_amount;
		//}
		$BookingDetailsDataObj->pageid="2";
		//$BookingDetailsDataObj->goods_nature = $_POST["goods_nature"];
		//$BookingDetailsDataObj->commercial_invoice = $_POST['commercial_invoice'];
		$_SESSION['terms'] = $_POST['terms_and_conditions'];
		$BookingDetailsDataObj->dangerousgoods = $_POST['dangerousgood'];
		//$_SESSION['dangerousgoods']  = $_POST['dangerousgood'];
		//$_SESSION['securitystatement']  = $_POST['security_statement'];
		$BookingDetailsDataObjArray = (array)$BookingDetailsDataObj;

		$BookingDetailsDataObjArray_tmp = $__Session->GetValue("booking_details");
		$BookingDetailsDataObjArray = array_merge($BookingDetailsDataObjArray_tmp,$BookingDetailsDataObjArray);

		/*echo "<pre>";
		print_r($BookingDetailsDataObjArray);
		echo "</pre>";
		exit();*/
		$__Session->SetValue("booking_details",$BookingDetailsDataObjArray);
		$__Session->Store();
		//This condition added by shailesh jamanapara on date Wed May 29 19:53:50 IST 2013
		if(defined('SES_USER_ID')){
			header("Location:" . FILE_CHECKOUT);
			exit();

		}else{
			header("Location:".FILE_CHECKOUT);
			exit();
		}
	}
}

$BookingDetailsDataObj = $__Session->GetValue("booking_details");
$BookingDatashow = new stdClass;
foreach ($BookingDetailsDataObj as $key=>$val) {
	$BookingDatashow->{$key}=valid_output($val);
}

/* This session is for service rates and service name */
$ServiceDetailArr = $__Session->GetValue("temp_service_details");
if($ServiceDetailArr){

	foreach ($ServiceDetailArr as $akey => $aval) {
		$$akey = valid_output($aval);
	}
}
$service_name = $BookingDatashow->service_name;
$servicepagename = $BookingDatashow->servicepagename;
/* This session is for service rates and service name */
//echo $servicepagename;
//echo $service_name;
//if($servicepagename=="overnight" || $servicepagename=="sameday")
if($service_name)
{
	$fieldArr=array("*");
	$ServiceSear=array();
	$ServiceSear[]= array('Search_On'=>'service_name', 'Search_Value'=>"$service_name", 'Type'=>'string', 'Equation'=>'=', 'CondType'=>'AND', 'Prefix'=>'', 'Postfix'=>'');
	$service_data = $ObjServiceMaster->getService($fieldArr,$ServiceSear);
	$service_data = $service_data[0];
	$supplier_id = $service_data['supplier_id'];
}


/*
this is comment by smita on friday 6 nov 2020
because it was throwing errors related with file constants.
if(isset($servicepagename))
{
	switch($servicepagename)
	{
		case "overnight":
			$filename = FILE_OVERNIGHT_RATES;
			break;
		case "sameday":
			$filename = FILE_SAMEDAY_RATES;
			break;
		case "international":
			$filename = FILE_INTERNATIONAL_GET_QUOTE;
			break;
	}
}*/
$BookingItemDetailsData = $__Session->GetValue("booking_details_items");
$objSiteConstantMaster = SiteConstantMaster::create();
$objSiteConstantData = new SiteConstantData();


$SiteConstantDataVal = $objSiteConstantMaster->getSiteConstant($fieldArr=null, $seaArr=null, $optArr=null, $start=null, $total=null, $ThrowError=true,$constant_id=null,$from_admin=true);
$SiteConstant = new stdClass;
foreach ($SiteConstantDataVal as $key=>$val) {
	$key = $val->constant_name;
	$value =$val->constant_value;
	$SiteConstant->{$key}=valid_output($value);
	$$key=valid_output($value);
	//echo "key:".$$key."--".$value."</br>";
}
/*
template calculation for price
*/


$service_rate=$BookingDatashow->rate;
if($BookingDatashow->tansient_warranty =="yes")
{
	$price=$BookingDatashow->coverage_rate+$service_rate;
}else
{
	$price	  = $service_rate;
	$orgprice = $service_rate;
}

$serviceRate = $service_rate;
$_SESSION['original_amount'] = $price;

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

$transitParam 	= array();
$transitParam[0] = array("australia"=>"domestic", "international"=>"international");
$transitParam[1] = array("business"=>"commercial", "residential"=>"personal_effects");

require_once(DIR_WS_MODEL . "AdditionalDetailItemsMaster.php");
/*
echo "booking data:".$BookingDatashow->flag."</br>";
echo $transitParam[0][$BookingDatashow->flag];
exit();
*/
$AdditionalDetailItemsMaster	= new AdditionalDetailItemsMaster();
$AdditionalDetailItemsMaster	= $AdditionalDetailItemsMaster->Create();
$AdditionalDetailItemsData		= new AdditionalDetailItemsData();

$seaArr = array();
$seaArr[]	=	array('Search_On'    => 'status',
					  'Search_Value' => '1',
					  'Type'         => 'int',
					  'Equation'     => '=',
					  'CondType'     => 'AND',
					  'Prefix'       => '',
					  'Postfix'      => '');

$additionalParam1 = $AdditionalDetailItemsMaster->getAdditionalDetailItems("*",$seaArr);
$additionalParamOptions = array();
if(!empty($additionalParam1))
{
	foreach ($additionalParam1 as $testlist){
		$additionalParamOptions[] = $testlist['item_type'];
	}
}else{
	$err['additionalErr'] = REQUIRED_TRANSIT_SETUP_IN_ADMIN;

}


function cmsPageContent($CmsPageName)
{
	require_once(DIR_WS_MODEL."CmsPagesMaster.php");
	require_once(DIR_WS_CURRENT_LANGUAGE . "cms.php");
	$ObjCmsPagesMaster	= CmsPagesMaster::Create();

	$fieldArr = array("cms_pages.*, cms_pages_description.page_heading , cms_pages_description.page_content");
	$searchArr = array();
	$searchArr[] = " AND cms_pages_description.site_language_id = '".SITE_LANGUAGE_ID."'";
	$searchArr[] = " AND cms_pages.page_name = '".$CmsPageName."'";
	$searchArr[] = " OR cms_pages.page_name = '".$CmsPageName."'";
	$searchArr[] = " AND cms_pages.status='1'";
	$DataCmsMaster = $ObjCmsPagesMaster->getCmsPagesDetails($searchArr, $fieldArr);
	if(!empty($DataCmsMaster)) {
		$cmsData = $DataCmsMaster[0];
	}

	return $cmsData;
}
require_once( DIR_WS_SITE_CURRENT_TEMPLATE . FILE_MAIN_INTERFACE); /* This include once is used for the html integration */
?>
