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
require_once(DIR_WS_CURRENT_LANGUAGE . "checkout.php");
require_once(DIR_WS_RELATED . "Paypal.php");
require_once(DIR_WS_RELATED.'system_mail.php');
require_once(DIR_WS_LIB ."functions.php");
require_once(DIR_WS_MODEL ."BookingDetailsMaster.php");
require_once(DIR_WS_MODEL ."PostCodeMaster.php");
require_once(DIR_WS_MODEL ."InternationalZonesMaster.php");
require_once(DIR_WS_MODEL ."BookingItemDetailsMaster.php");
require_once(DIR_WS_MODEL ."CountryMaster.php");
require_once(DIR_WS_MODEL . "ServiceMaster.php");
require_once(DIR_WS_MODEL . "ProductLabelMaster.php");
require_once(DIR_WS_MODEL . "UserMaster.php");

require_once(DIR_WS_MODEL ."ClientAddressMaster.php");
require_once(DIR_WS_MODEL."CommercialInvoiceMaster.php");
require_once(DIR_WS_MODEL."CommercialInvoiceItemMaster.php");
require_once(DIR_WS_MODEL."BookingDiscountDetailsMaster.php");
require_once(DIR_WS_MODEL . "SupplierMaster.php");
require_once(DIR_WS_MODEL . "AddressMaster.php");
require_once(DIR_WS_RELATED.'/vendor/autoload.php');


use Dompdf\Dompdf;

ob_start();
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



$BookingItemDetailsMasterObj = BookingItemDetailsMaster::create();
$BookingItemDetailsDataObj = new BookingItemDetailsData();

$BookingDetailsMasterObj = BookingDetailsMaster::create();
$BookingDetailsDataObj = new BookingDetailsData();

$PostCodeMasterObj = PostCodeMaster::create();
$PostCodedataObj = new PostCodeData();

$InternationalzonesMasterObj = InternationalZonesMaster::Create();
$InternationalDataobj= new InternationalZonesData();


$objClientAddressMaster = ClientAddressMaster::create();
$objClientAddressData =  new ClientAddressData();

$ObjServiceMaster	= ServiceMaster::Create();
$ServiceData		= new ServiceData();

$ObjProductLabelMaster	= ProductLabelMaster::Create();
$ProductLabelData		= new ProductLabelData();

$UserMasterObj    = UserMaster::Create();
$UserData         = new UserData();


$CountryMasterObj = CountryMaster::create();
$CountryDataObj = new CountryData();

$ObjSupplierMaster	= new SupplierMaster();
$ObjSupplierMaster	= $ObjSupplierMaster->Create();
$SupplierData		= new SupplierData();

$ObjAddressMaster   = new AddressMaster();
$ObjAddressMaster   = $ObjAddressMaster->Create();
$ObjAddress	        = new AddressData();

//exit();
//echo DIR_WS_ONLINEPDF;
//echo "site url:".SITE_URL;
$arr_css_plugin_include[] = 'glyphicons_new/css/glyphicons.css';
$arr_css_plugin_include[] = 'waitMe/css/waitMe.min.css';

$arr_javascript_below_include[] = 'internal/checkout.php';
$arr_javascript_plugin_include[] = 'waitMe/js/waitMe.min.js';




/*
$csrf = new csrf();
if($_POST['status'] == '')
{
	$csrf->action = "checkout";
	$ptoken = $csrf->csrfkey();
}
*/
/*echo "<pre>";
print_r($_SESSION);
echo "</pre>";*/
/**
 * This code is executed when submit is pressed checks about the fields and the user
 *
 */

if(defined('SES_USER_ID')) {
	$userSeaArr[]     = array('Search_On'=>'userid', 'Search_Value'=>SES_USER_ID, 'Type'=>'int', 'Equation'=>'=', 'CondType'=>'AND', 'Prefix'=>'','Postfix'=>'');
	$Users            = $UserMasterObj->getUser(null, $userSeaArr);
	$Users            = $Users[0];
	$AddressSearch = array();
	$AddressSearch[]=array('Search_On'=>'user_id', 'Search_Value'=>SES_USER_ID, 'Type'=>'string', 'Equation'=>'=', 'CondType'=>'AND', 'Prefix'=>'', 'Postfix'=>'');
	$UserAddresData = $ObjAddressMaster->getAddress(null, $AddressSearch);
	$UserAddresData = $UserAddresData[0];
		
}
//echo "account no:".$UserAddresData->account_no;

$BookingDetailsData = $__Session->GetValue("booking_details");
$BookingItemDetailsData = $__Session->GetValue("booking_details_items");
$invoice_id = $__Session->GetValue("invoice_id");
$cancel_booking_id =  (int)$BookingDetailsData['booking_id'];
$BookingDatashow = new StdClass;
if(!empty($BookingDetailsData))
{
	foreach ($BookingDetailsData as $key=>$val) {
		$BookingDatashow->{$key}=$val;
	}
}
/*
echo "<pre>";
print_r($BookingDatashow);
echo "</pre>";
*/
if(isset($BookingDatashow))
{


	if($BookingDatashow->flag=="australia")
	{
		$receiverLocName    = valid_output($BookingDatashow->reciever_suburb);
		$receiverLocPostcode= valid_output($BookingDatashow->reciever_postcode);
		$receiverState      = valid_output($BookingDatashow->reciever_state);
		$receiver_contry_code = "AU";
		//echo "reciever loc:".$receiverLocName."</br>";
		//echo "reciever post:".$receiverLocPostcode."</br>";

	}else{
		// international values
		$receiverLocName    = $BookingDatashow->reciever_suburb;
		$receiverState      = $BookingDatashow->reciever_state;
		$receiverLocPostcode= $BookingDatashow->reciever_postcode;
		//find the receiver courntry code for cconnote image
		$deliverid          = (int)$BookingDatashow->deliveryid;
		/*
		$deliverseaArr[0] = array('Search_On'    => 'id',
		'Search_Value' => $deliverid,
		'Type'         => 'int',
		'Equation'     => '=',
		'CondType'     => '',
		'Prefix'       => '',
		'Postfix'      => '');
		$InternationalDataobj=$InternationalzonesMasterObj->getInternationalZones(null,$deliverseaArr);
		$interCodedata=$InternationalDataobj[0]; */


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
		//$receiver_area_code = $CountryDataObj['area_code'];
		$countries_name= (isset($_SESSION['international_country_name']) && $_SESSION['international_country_name']!="")?($_SESSION['international_country_name']):($CountryDataObj['countries_name']);

		if(isset($BookingDatashow->country_origin) && !empty($BookingDatashow->country_origin)){
			$country_origin = $BookingDatashow->country_origin;

			$seabycountryoriginArr[0] = array('Search_On'    => 'countries_id',
			'Search_Value' => $country_origin,
			'Type'         => 'int',
			'Equation'     => '=',
			'CondType'     => 'and ',
			'Prefix'       => '',
			'Postfix'      => '');
			$fieldArrforCountryOriginName = array("countries_name","countries_iso_code_2","area_code");
			$CountryOriginDataObj = $CountryMasterObj->getCountry($fieldArrforCountryOriginName,$seabycountryoriginArr);
			$CountryOriginDataObj = $CountryOriginDataObj[0];
			$origin_contry_code = $CountryOriginDataObj['countries_iso_code_2'];
			$origin_countries_name= $CountryOriginDataObj['countries_name'];


		}

		if(isset($Users->country) && !empty($Users->country)){
			$country_profile = $Users->country;

			$seabycountryprofileArr[0] = array('Search_On'    => 'countries_id',
			'Search_Value' => $country_profile,
			'Type'         => 'int',
			'Equation'     => '=',
			'CondType'     => 'and ',
			'Prefix'       => '',
			'Postfix'      => '');
			$fieldArrforCountryProfileName = array("countries_name","countries_iso_code_2","area_code");
			$CountryProfileDataObj = $CountryMasterObj->getCountry($fieldArrforCountryProfileName,$seabycountryprofileArr);
			$CountryProfileDataObj = $CountryProfileDataObj[0];
			$profile_contry_code = $CountryProfileDataObj['countries_iso_code_2'];
			$profile_countries_name= $CountryProfileDataObj['countries_name'];


		}



	}
	$datetime      = $BookingDatashow->date_ready." ".$BookingDatashow->time_ready;
	$total_weight  = $BookingDatashow->total_weight;
	$total_qty     = $BookingDatashow->total_qty;
	$senderName    = $BookingDatashow->sender_first_name." ".$BookingDatashow->sender_surname;
	$service_name  = $BookingDatashow->service_name;
	//if($BookingDatashow->service_name == "international")
	//{
		$senderaddress1= $BookingDatashow->sender_address_1.",";
		if(isset($BookingDatashow->sender_address_2) && $BookingDatashow->sender_address_2 != "")
		{
			$senderaddress2= $BookingDatashow->sender_address_2.",";
		}
		if(isset($BookingDatashow->sender_address_3) && $BookingDatashow->sender_address_3 != "")
		{
			$senderaddress3= $BookingDatashow->sender_address_3.",";
		}
		$senderPhoneNO = $BookingDatashow->sender_contact_no;
		$senderLocName = $BookingDatashow->sender_suburb;
		$senderLocPostcode = $BookingDatashow->sender_postcode;
	//}else{
		//$senderaddress1= 'PO BOX 7108,';
		//$senderPhoneNO = '1300824423';
		//$senderLocName = 'ALEXANDRIA';
		//$senderLocPostcode = '2015';
	//}
	$senderEmail   = $BookingDatashow->sender_email;




	$senderState   = $BookingDatashow->sender_state;
	$sender_counrty_code = "AU";
	$supplier_name = $BookingDatashow->webservice;
	
	/*echo "<pre>";
	print_R($BookingDatashow);
	echo "</pre>";*/
	///Receiver
	$receiverName     = $BookingDatashow->reciever_firstname." ".$BookingDatashow->reciever_surname.",";
	$receiverAddress1 = $BookingDatashow->reciever_address_1.",";
	if(isset($BookingDatashow->reciever_address_2) && $BookingDatashow->reciever_address_2 != "")
	{
		$receiverAddress2 = $BookingDatashow->reciever_address_2.",";
	}
	if(isset($BookingDatashow->reciever_address_3) && $BookingDatashow->reciever_address_3 != "")
	{
		$receiverAddress3 = $BookingDatashow->reciever_address_3.",";
	}
	$receiverPhoneNo  = $BookingDatashow->reciever_contact_no;
	//echo "Number of digits :".countDigits($receiverPhoneNo);
	//exit();
	if(isset($BookingDatashow->reciever_contact_no) && countDigits($receiverPhoneNo)<9){
		//echo $BookingDatashow->reciever_area_code."inside";
		$receiverPhoneNo  = $BookingDatashow->reciever_area_code.$BookingDatashow->reciever_contact_no;
	}
	/*echo "<pre>";
	print_r($BookingDatashow);
	echo "</pre>";
	echo "Number of digits :".$receiverPhoneNo;
	exit();*/
	$receiverEmail    = $BookingDatashow->reciever_email;
	$goodDescription  = $BookingDatashow->description_of_goods;
	$valueOfGoods     = 0;

	//
	if(isset($BookingDatashow->values_of_goods) && !empty($BookingDatashow->values_of_goods)){
		$valueOfGoods     = $BookingDatashow->values_of_goods;
	}else{
		$BookingDatashow->values_of_goods = 0;
	}
	$BookingDatashow->pickup_location_type =0;
	$BookingDatashow->delivery_location_type =0;

	$provider_name    = 'DIRCOUR';
	$pickupid = $BookingDatashow->pickupid;
	if(isset($pickupid) && !empty($pickupid)){
		$state = get_state_code($pickupid);
	}
	//echo "state:".$state;
	if(isset($state) && !empty($state)){
		switch($state) {
			case "NSW":
			   $thirdtoken = 'C93D900359768C369A199E44B958AA5B';
			  break;
			case "VIC":
			   $thirdtoken = 'E4C3536BC2A6DB09161B76A099A61B31';
			  break;
			case "QLD":
			   $thirdtoken = 'B162FE86624AECB2FDB5817732F3913E';
			  break;
			case "WA":
				$thirdtoken = 'FCBBFACAC3BA17ADE7A0CA9B85EC7369';
			   break;
			case "SA":
				$thirdtoken = 'A47CB406B42951790EF1034D648475EC';
			   break;
		  }	
	}
	
	/*echo "<pre>";
	print_r($BookingDatashow);
	echo "</pre>";
	exit();*/
	//$commercial_invoice = $BookingDatashow->commercial_invoice;
	$shipmentStr = "";
	if($BookingDatashow->service_name == 'premium' ||  $BookingDatashow->service_name == 'economy')
	{
		$provider_name = 'STEAU';
		$thirdtoken = '45BA9B494479ECADE06A9213C4281466';
		$shipmentStr = "<Shipment><IntegrationData><movement_type></movement_type><packaging_type>CTN</packaging_type></IntegrationData></Shipment>";
	}
	//$shipmentStr = "<Shipment><IntegrationData><movement_type></movement_type><packaging_type>CTN</packaging_type></IntegrationData></Shipment>";
	if(isset($BookingDatashow->service_name) && $BookingDatashow->service_name == 'international'){
		$service_name="international";
		$thirdtoken = 'EC9DB124888A6F233A6AA23072700BA4';
		$shipmentStr = "<IntegrationData><Packaging>02</Packaging></IntegrationData>";
	}

	$supplierFieldArr = array("auto_id");
	$supplierSear=array();
	$supplierSear[]= array('Search_On'=>'supplier_name', 'Search_Value'=>$supplier_name, 'Type'=>'string', 'Equation'=>'=', 'CondType'=>'AND', 'Prefix'=>'', 'Postfix'=>'');
	$DataSupplier=$ObjSupplierMaster->getSupplier($supplierFieldArr, $supplierSear,null,$from,$to);
	$DataSupplier = $DataSupplier[0];
	$supplier_id = $DataSupplier['auto_id'];

	//echo "supplier id:".$supplier_id;
	//exit();
	if($service_name=="international")
	{
		$fieldArr=array("*");
		$ServiceSear=array();
		$ServiceSear[]= array('Search_On'=>'service_name', 'Search_Value'=>$service_name, 'Type'=>'string', 'Equation'=>'=', 'CondType'=>'AND', 'Prefix'=>'', 'Postfix'=>'');
		$ServiceSear[]= array('Search_On'=>'supplier_id', 'Search_Value'=>$supplier_id, 'Type'=>'string', 'Equation'=>'=', 'CondType'=>'AND', 'Prefix'=>'', 'Postfix'=>'');
		$service_data = $ObjServiceMaster->getService($fieldArr,$ServiceSear);
		$service_data=$service_data[0];
		$cutoff_time = $service_data["hours"].":".$service_data["minites"]." ".$service_data["hr_formate"];
		//$serviceCutOffTime = strtotime($cutoff_time);

		/* cutoff time validation */
		$pickupid = $BookingDatashow->pickupid;

		if(get_time_zonewise($pickupid))
		{
			$dateArr    = explode(" ",get_time_zonewise($pickupid));
			$timeArr    = explode(":",$dateArr[3]);
			$start_date = $dateArr[0]." ".$dateArr[1]." ".$dateArr[2];
			$time_hr    = $timeArr[0];
			$time_sec   = $timeArr[1];
			$hr_formate = $dateArr[4];
		}
		/* cutoff time validation */
		/* if pickup date is similar to current date
		   with pickup id date then this if condition has been taken
		*/

		if(isset($BookingDatashow->date_ready) && $BookingDatashow->date_ready)
		{
			$bookedDate = date('d M Y h:i:s a', strtotime($BookingDatashow->date_ready));
			$dateReadyArr    = explode(" ",$bookedDate);
			$timeReadyArr    = explode(":",$dateReadyArr[3]);
			$dateReady = $dateReadyArr[0]." ".$dateReadyArr[1]." ".$dateReadyArr[2];
		    $timeReady_hr    = $timeReadyArr[0];
			$timeReady_sec   = $timeReadyArr[1];
			$hrReady_formate = $dateReadyArr[4];
		}

		if(isset($dateReady) && isset($start_date) && strtotime($dateReady) == strtotime($start_date)){
			$current_time =  ($time_hr.":".$time_sec." ".$hr_formate);
		}else{
			$current_time = ($timeReady_hr.":".$timeReady_sec." ".$hrReady_formate);
		}


		$serviceCutOffTime = ($cutoff_time);

		$product_code_id=$service_data["product_code_id"];

		foreach($BookingItemDetailsData as $key => $val){
			if(isset($val['item_type']) && !empty($val['item_type']) && $val['item_type'] == '4'){
				//$product_name_code = 'ED';//international document
				$product_name_code = 'INTERNATIONAL DOCUMENT';
			}elseif(isset($val['item_type']) && !empty($val['item_type']) && $val['item_type'] == '5'){
				//$product_name_code = 'EN';//international non-document
				$product_name_code = 'INTERNATIONAL NON-DOCUMENT';
			}
		}
		//echo "product name:".$product_name_code;
		$fieldArr=array("*");
		$seaByArr=array();
		if(isset($product_code_id) && $product_code_id){
			/*
				Below code is done for international document and non-document
				because product code is different for both types that's why commented product code id
			*/
			//$seaByArr[]=array('Search_On'=>'auto_id', 'Search_Value'=>$product_code_id, 'Type'=>'int', 'Equation'=>'=', 'CondType'=>'', 'Prefix'=>'and', 'Postfix'=>'');
			$seaByArr[]=array('Search_On'=>'product_name', 'Search_Value'=>$product_name_code, 'Type'=>'string', 'Equation'=>'=', 'CondType'=>'', 'Prefix'=>'and', 'Postfix'=>'');
			$DataService=$ObjProductLabelMaster->getProductLabel($fieldArr,$seaByArr); // Fetch Data

			$DataService = $DataService[0];
			$service_name_code=$DataService["product_code"];
		}

		//echo "service name code:".$service_name_code."</br>";
		//exit();
		/*echo "<pre>";
		print_r($_SESSION);
		echo "</pre>";*/
		$service_name="DEE";
		$provider_name = 'UPS';

	}else {
		//echo $service_name."---".$supplier_id."</br>";
		$fieldArr=array("*");
		$ServiceSear=array();
		$ServiceSear[]= array('Search_On'=>'service_name', 'Search_Value'=>$service_name, 'Type'=>'string', 'Equation'=>'=', 'CondType'=>'AND', 'Prefix'=>'', 'Postfix'=>'');
		$ServiceSear[]= array('Search_On'=>'supplier_id', 'Search_Value'=>$supplier_id, 'Type'=>'string', 'Equation'=>'=', 'CondType'=>'AND', 'Prefix'=>'', 'Postfix'=>'');
		$service_data = $ObjServiceMaster->getService($fieldArr,$ServiceSear);
		$service_data=$service_data[0];
		$cutoff_time = $service_data["hours"].":".$service_data["minites"]." ".$service_data["hr_formate"];
		//$serviceCutOffTime = strtotime($cutoff_time);

		/* cutoff time validation */
		$pickupid = $BookingDatashow->pickupid;

		if(get_time_zonewise($pickupid))
		{
			$dateArr    = explode(" ",get_time_zonewise($pickupid));
			$timeArr    = explode(":",$dateArr[3]);
			$start_date = $dateArr[0]." ".$dateArr[1]." ".$dateArr[2];
			$zoneCurrentDate = date('d M Y', strtotime($start_date));
			$time_hr    = $timeArr[0];
			$time_sec   = $timeArr[1];
			$hr_formate = $dateArr[4];
		}

		/* cutoff time validation */
		/* if pickup date is similar to current date
		   with pickup id date then this if condition has been taken
		*/

		if($BookingDatashow->date_ready)
		{
			$bookedDate = date('d M Y h:i:s a', strtotime($BookingDatashow->date_ready));
			$dateReadyArr    = explode(" ",$bookedDate);
			$timeReadyArr    = explode(":",$dateReadyArr[3]);
			$dateReady = $dateReadyArr[0]." ".$dateReadyArr[1]." ".$dateReadyArr[2];
		    $timeReady_hr    = $timeReadyArr[0];
			$timeReady_sec   = $timeReadyArr[1];
			$hrReady_formate = $dateReadyArr[4];
		}

		
		if(strtotime($dateReady) == strtotime($zoneCurrentDate)){
			$current_time =  date('h:i A',strtotime($time_hr.":".$time_sec." ".$hr_formate));
		}else{
			//$current_time = ($timeReady_hr.":".$timeReady_sec." ".$hrReady_formate);
			$current_time = $BookingDatashow->time_ready;
		}

		/*echo $zoneCurrentDate."---".$dateReady."---".$current_time."</br>";
		echo "<pre>";
		print_r($BookingDatashow);
		echo "</pre>";
		exit();*/

		$serviceCutOffTime = ($cutoff_time);
		/*echo "<pre>";
		print_r($service_data);
		echo "</pre>";
		*/
		$product_code_id=$service_data["product_code_id"];


		$fieldArr=array("*");
		$seaByArr=array();
		if($product_code_id){
			$seaByArr[]=array('Search_On'=>'auto_id', 'Search_Value'=>$product_code_id, 'Type'=>'int', 'Equation'=>'=', 'CondType'=>'', 'Prefix'=>'and', 'Postfix'=>'');
			$DataService=$ObjProductLabelMaster->getProductLabel($fieldArr,$seaByArr); // Fetch Data

			$DataService = $DataService[0];
			$service_name_code=$DataService["product_code"];
		}
		/*echo "<pre>";
		print_r($DataService);
		echo "</pre>";
		exit();*/
	}
	//echo "service name code:".$service_name_code."</br>";
	//exit();
	$ch = curl_init();
	if($BookingDatashow->service_name == "international")
	{
		$senderCompany = ($senderName!="" && $BookingDatashow->sender_company_name!="")?($BookingDatashow->sender_company_name):($senderName);
		$recCompany = $BookingDatashow->reciever_company_name.",";
		$receiverCompany = ($receiverName!="" && $BookingDatashow->reciever_company_name!="")?($recCompany):($receiverName);
	}
	else{
		$senderCompany = ($senderName!="" && $BookingDatashow->sender_company_name!="")?($BookingDatashow->sender_company_name):($senderName);
		$recCompany = $BookingDatashow->reciever_company_name.",";
		$receiverCompany = ($receiverName!="" && $BookingDatashow->reciever_company_name!="")?($recCompany):',';
	}

	//$receiverCompany = ',';
	$goodDescription = ($goodDescription=="")?("GOODS' DESCRIPTION"):($BookingDatashow->description_of_goods);
	$upsValidCountry = false;

	if(isset($countries_name) && ($countries_name)!='')
	{
		if(in_array($countries_name,$valid_country_arr))
		{

			$upsValidCountry = true;
		}
	}

	if($upsValidCountry == true)
	{
		$receiverState = $BookingDatashow->reciever_state_code;
	}
}



$desc_of_goods = $BookingDatashow->description_of_goods;
//$desc_of_goods = $BookingDatashow->goods_nature;
$service_name  = $BookingDatashow->service_name;
$ServiceDetailsData = $__Session->GetValue("service_details");
if($ServiceDetailsData)
{

	for($i=0;$i<count($ServiceDetailsData);$i++)
	{

		if(strtolower($ServiceDetailsData[$i]['service_name']) == $BookingDatashow->service_name)
		{

			$final_delivery_fee = $ServiceDetailsData[$i]['delivery_fee'];

			if($final_delivery_fee)
			{
				$err['final_delivery_fee'] = isFloat(valid_input($final_delivery_fee),"Please enter float values.");
			}
			if($err['final_delivery_fee'])
			{
				logOut();
			}

			$final_surcharge_fee = $ServiceDetailsData[$i]['surcharge'];
			if($final_surcharge_fee)
			{
				$err['final_surcharge_fee'] = isFloat(valid_input($final_surcharge_fee),"Please enter float values.");
			}
			if($err['final_surcharge_fee'])
			{
				logOut();
			}
			$final_fuel_fee = $ServiceDetailsData[$i]['fuel_surcharge'];
			if($final_fuel_fee)
			{
				$err['final_fuel_fee'] = isFloat(valid_input($final_fuel_fee),"Please enter float values.");
			}
			if($err['final_fuel_fee'])
			{
				logOut();
			}
			$total_delivery_charge_org =  $ServiceDetailsData[$i]['total_delivery_fee'];
			$base_fuel_fee = $ServiceDetailsData[$i]['base_fuel_fee'];
			$_SESSION['base_fuel_fee']= $base_fuel_fee;

		}

	}

}
/*
echo "<pre>";
print_r($ServiceDetailsData);
echo "</pre>";*/
$_SESSION['due_amt'] = $final_delivery_fee; // Base delivery fee for coupon

/* 
* Below code can be commented as we are not using coverage_rate
*/
if(isset($_POST['old_total_new_charges']) && $_POST['old_total_new_charges']!=0)
{
	$err['old_total_new_charges'] = isFloat(valid_input($_POST['old_total_new_charges']),"Please enter float values.");
}
if($err['old_total_new_charges'])
{
	logOut();
}
if(isset($_POST['old_total_gst']) && $_POST['old_total_gst']!=0)
{
	$err['old_total_gst'] = isFloat(valid_input($_POST['old_total_gst']),"Please enter float values.");
}
if($err['old_total_gst'])
{
	logOut();
}
if(isset($_POST['old_total_due_amt']) && $_POST['old_total_due_amt']!=0)
{
	$err['old_total_due_amt'] = isFloat(valid_input($_POST['old_total_due_amt']),"Please enter float values.");
}
if($err['old_total_due_amt'])
{
	logOut();
}
//echo "total:".$total_delivery_charge_org;

$gst = 0;
if($BookingDatashow->service_name!="international")
{
	$gst = GST;
}
/* gst calculation for transit amount */
//echo "original transit:".$original_transit;

/* gst calculation for transit amount */
$total_gst_delivery =0;
if($gst != 0 && $total_delivery_charge_org != 0)
{
	$total_gst_delivery = calculate_gst_charge($gst,$total_delivery_charge_org);
}
//echo "first step1:gst-".$total_gst_delivery."total delivery original charge:".$total_delivery_charge_org."</br>";
if($total_gst_delivery)
{
	$err['total_gst_delivery'] = isFloat(valid_input($total_gst_delivery),"Please enter float values.");
}
if($err['total_gst_delivery'])
{
	logOut();
}
//echo $_SESSION['total_gst_delivery'];
/*
echo "<pre>";
print_r($_SESSION);
echo "</pre>";
echo "<pre>";
print_R($BookingDatashow);
echo "</pre>";*/
if(isset($_SESSION['nett_due_amt']) && $_SESSION['nett_due_amt']!=0)
{
	$total_gst = $_SESSION['total_gst_delivery'];
}else{
	//echo $total_gst_delivery."--".$total_transit_gst;
	$total_gst = $total_gst_delivery;
}
//echo "total gst:".$total_gst."</br>";
$total_delivery_charge = $total_delivery_charge_org+$total_gst_delivery;
//echo "second: total delivery charge:".$total_delivery_charge."</br>";
//$total_new_charges = $total_delivery_charge+$coverage_rate;
if(isset($_SESSION['nett_due_amt']) && $_SESSION['nett_due_amt']!=0)
{
	$total_new_charges = $_SESSION['nett_due_amt']+$_SESSION['final_fuel_fee'];
}else{
	$total_new_charges = $total_delivery_charge_org;
}


if(isset($total_delivery_charge) && !empty($total_delivery_charge)){
	$total_due = $total_delivery_charge;
}elseif(isset($_SESSION['total_delivery_fee']) && $_SESSION['total_delivery_fee']!=0){
	$total_due = $_SESSION['total_delivery_fee'];
}else{

}

//echo "total due:".$total_due."total gst:".$total_gst."</br>";
//!isset($_SESSION['couponCode']) &&
if((!isset($_SESSION['couponCode'])) && !isset($_POST['coupon_code']) && $_POST['coupon_code']=="")
{
	unset($_SESSION['discountAmt']);
}



if(empty($_SESSION['discountAmt']))
{
	$_SESSION['total_gst_delivery'] = $total_gst_delivery;
	$_SESSION['total_new_charges'] = $total_new_charges;
	$_SESSION['total_gst'] = $total_gst;
	$_SESSION['total_due'] = $total_due;
	$_SESSION['final_fuel_fee'] = $final_fuel_fee;
	$_SESSION['total_delivery_fee']= $total_delivery_charge;
}
/*echo "<pre>";
print_r($_SESSION);
echo "</pre>";*/
$user = 'completeconsultantgroup-facilitator_api1.outlook.com';
$pass = '44RBM8SEMQNKSPBG';
$signature = 'AcfNR-JVJL4nurSsiXgC7zOy7-ywAN0Qe2YWOSC0QS5EZmypkvT7VgJB';
$paypal_server = 'https://api-3t.sandbox.paypal.com/nvp';
$amount = $_POST['PAYMENTREQUEST_0_AMT'];
$currency = "AUD";
$success_url = SITE_URL."checkout.php";
$cancel_url = SITE_URL."checkout.php?mode=cancel";
$paypal = new Paypal($user, $pass, $signature, $paypal_server);

//----------------------------------exit();
if(isset($_POST['status']) && $_POST['status']!='')
{

	/* csrf validation check
	if(isEmpty(valid_input($_POST['ptoken']), true))
	{
		logOut();
	}
	else
	{
		$test = $csrf->checkcsrf($_POST['ptoken']);
	}
	*/

	/* csrf validation check */
	if($final_delivery_fee)
	{
		$err['final_delivery_fee'] = isFloat(valid_input($final_delivery_fee),"Please enter float values.");
	}
	if($final_fuel_fee)
	{
		$err['final_fuel_fee'] = isFloat(valid_input($final_fuel_fee),"Please enter float values.");
	}
	/*if($final_security_fee)
	{
		$err['final_security_fee'] = isFloat(valid_input($final_security_fee),"Please enter float values.");
	}*/
	if($total_delivery_charge)
	{
		$err['total_delivery_charge'] = isFloat(valid_input($total_delivery_charge),"Please enter float values.");
	}
	if($_SESSION['discountAmt'])
	{
		$err['discountAmt'] = isFloat(valid_input($_SESSION['discountAmt']),"Please enter float values.");
	}
	if($_POST['temp_value']!="")
	{
		$err['temp_value'] = isNumeric(valid_input($_POST['temp_value']),ERROR_ENTER_NUMERIC_VALUE);
	}
	if($_POST['tvalid']!="")
	{
		$err['tvalid'] = isNumeric(valid_input($_POST['tvalid']),ERROR_ENTER_NUMERIC_VALUE);
	}

	if($_SESSION['due_amt']!="")
	{
		$err['due_amt'] = isFloat(valid_input($_SESSION['due_amt']),"Please enter float values.");
	}
	
	if($_SESSION['total_gst'])
	{
		$err['net_gst_hidden'] = isFloat(valid_input($_SESSION['total_gst']),"Please enter float values.");
	}
	if($_SESSION['total_new_charges'])
	{
		$err['hidden_total_new_charges'] = isFloat(valid_input($_SESSION['total_new_charges']),"Please enter float values.");
	}
	if($_SESSION['total_due']!="")
	{
		$err['hidden_total_due_amt'] = isFloat(valid_input($_SESSION['total_due']),"Please enter float values.");
	}
	if($_POST['PAYMENTREQUEST_0_AMT']!="")
	{
		$err['payment_amt'] = isFloat(valid_input($_POST['PAYMENTREQUEST_0_AMT']),"Please enter float values.");
	}
	if($_POST['terms_and_conditions']!="")
	{
		$err['terms_and_conditions'] = chkSmall(valid_input($_POST['terms_and_conditions']));
	}

	if(isset($err))
	{
		foreach($err as $key => $Value) {

			if($Value != '') {
				$Svalidation=true;
				logOut();
			}
		}
	}
	if($Svalidation == false)
	{
	/* Its to check the cut off timings for the services */
	$timeflag = false;

	if(strtotime($current_time) > strtotime($serviceCutOffTime))
	{
		$timeflag = true;
		echo "<script src='".SITE_URL."/assets/js/jquery.min.js'></script><script type='text/javascript' src='".SITE_URL."assets/plugins/bootstrap/js/bootstrap.min.js'></script><script type='text/javascript'>
		$(document).ready(function(){
			$('#timeCancel').modal('show');
			$('#cutoffclosemodal').click(function(){
				var pagename = '$BookingDatashow->servicepagename';
				if(pagename == 'sameday')
				{
					var url = '".SITE_URL.FILE_METRO_RATES."?action=service_cutoff';
					$(location).attr('href',url);
				}else if(pagename == 'overnight'){
					var url = '".SITE_URL.FILE_INTERSTATE_RATES."?action=service_cutoff';
					$(location).attr('href',url);
				}else{
					var url = '".SITE_URL.FILE_INTERNATIONAL."?action=service_cutoff';
					$(location).attr('href',url);
				}
			});
		});

		</script>";

	}
	/*echo "<pre>";
	print_r($_SESSION);
	echo "</pre>";
	exit();*/
	if(!isset($BookingDatashow->CCConnote) && empty($BookingDatashow->CCConnote)){
		$stringItems = "";
		foreach($BookingItemDetailsData as $key => $val){
			
			$stringItems .= '<CCItem><CCItemWeight>'.$val['item_weight'].'</CCItemWeight>';
			$stringItems .= '<CCItemDeadWeight>'.$val['vol_weight'].'</CCItemDeadWeight>';
			$stringItems .= '<CCItemCubicLengthCm>'.$val['length'].'</CCItemCubicLengthCm>';
			$stringItems .= '<CCItemCubicWidthCm>'.$val['width'].'</CCItemCubicWidthCm>';
			$stringItems .= '<CCItemCubicHeightCm>'.$val['height'].'</CCItemCubicHeightCm><CCItemCubicWeight></CCItemCubicWeight><CCItemAltRef></CCItemAltRef><CCItemNotes></CCItemNotes><CCItemCustomsValue></CCItemCustomsValue><CCItemCurrencyCode></CCItemCurrencyCode><CCItemGoodsDesc></CCItemGoodsDesc><CCItemHarmonisedCode></CCItemHarmonisedCode><CCItemOriginCountryCode></CCItemOriginCountryCode><CCItemNoOfPcs></CCItemNoOfPcs>
			</CCItem>';
				
		}
		if(isset($shipmentStr) && !empty($shipmentStr)){
			$stringItems .= $shipmentStr;
		}
		$xmlString=("<?xml version='1.0' encoding='ISO-8859-1' ?><WSGET><AccessRequest><WSVersion>WS1.3</WSVersion><FileType>19</FileType><Action>upload</Action><EntityID>6FC39A3131DD95C2CB2DF21A9784FE3B</EntityID><EntityPIN>WS_EPORTAL</EntityPIN><MessageID>$bookingidXml</MessageID><AccessID>PRIORITY_ID</AccessID><AccessPIN>ngy8jo9</AccessPIN><CreatedDateTime>".$BookingDatashow->booking_date."</CreatedDateTime><CarrierSID>-1448</CarrierSID></AccessRequest><CMDetail><CC><ThirdPartyToken>".$thirdtoken."</ThirdPartyToken><CCToCarrier>".ucwords(strtolower($provider_name))."</CCToCarrier><CCLabelReq>Y</CCLabelReq><CCAccCardCode>EPORTAL</CCAccCardCode><CCCustDeclaredWeight>".$total_weight."</CCCustDeclaredWeight><CCWeightMeasure>Kgs</CCWeightMeasure><CCNumofItems>".$total_qty."</CCNumofItems><CCSTypeCode>".$service_name_code."</CCSTypeCode><CCSenderName>".strtoupper($senderCompany)."</CCSenderName><CCSenderAdd1>".strtoupper($senderaddress1)."</CCSenderAdd1><CCSenderAdd2>".strtoupper($senderaddress2)."</CCSenderAdd2><CCSenderAdd3>".strtoupper($senderaddress3)."</CCSenderAdd3><CCSenderLocCode>".strtoupper($sender_counrty_code)."</CCSenderLocCode><CCSenderLocName>".strtoupper($senderLocName)."</CCSenderLocName><CCSenderLocState>".strtoupper($senderState)."</CCSenderLocState><CCSenderLocPostcode>".$senderLocPostcode."</CCSenderLocPostcode><CCSenderLocCtryCode>".$sender_counrty_code."</CCSenderLocCtryCode><CCSenderContact>".strtoupper($senderName)."</CCSenderContact><CCSenderPhone>".$senderPhoneNO."</CCSenderPhone><CCSenderEmail>".strtoupper($senderEmail)."</CCSenderEmail><CCReceiverName>".strtoupper($receiverCompany)."</CCReceiverName><CCReceiverAdd1>".strtoupper($receiverAddress1)."</CCReceiverAdd1><CCReceiverAdd2>".strtoupper($receiverAddress2)."</CCReceiverAdd2><CCReceiverAdd3>".strtoupper($receiverAddress3)."</CCReceiverAdd3><CCReceiverLocCode>".strtoupper($receiver_contry_code)."</CCReceiverLocCode><CCReceiverLocName>".strtoupper($receiverLocName)."</CCReceiverLocName><CCReceiverLocState>".strtoupper($receiverState)."</CCReceiverLocState><CCReceiverLocPostcode>".$receiverLocPostcode."</CCReceiverLocPostcode><CCReceiverLocCtryCode>".strtoupper($receiver_contry_code)."</CCReceiverLocCtryCode><CCReceiverContact>".strtoupper($receiverName)."</CCReceiverContact><CCReceiverPhone>".$receiverPhoneNo."</CCReceiverPhone><CCReceiverEmail>".strtoupper($receiverEmail)."</CCReceiverEmail><CCWeight>".$total_weight."</CCWeight><CCSenderRef1>TEST</CCSenderRef1><CCSenderRef2>TEST1</CCSenderRef2><CCSenderRef3>TEST3</CCSenderRef3><CCCustomsValue>".$valueOfGoods."</CCCustomsValue><CCCustomsCurrencyCode>AUD</CCCustomsCurrencyCode><CCClearanceRef>qw</CCClearanceRef><CCCubicLength>0</CCCubicLength><CCCubicWidth>0</CCCubicWidth><CCCubicHeight>0</CCCubicHeight><CCCubicMeasure>KG</CCCubicMeasure><CCCODAmount>0.0000</CCCODAmount><CCCODCurrCode>USD</CCCODCurrCode><CCBag>0</CCBag><CCNotes>CCNotes</CCNotes><CCSystemNotes>CCNotes</CCSystemNotes><CCOriginLocCode>AU</CCOriginLocCode><CCBagNumber></CCBagNumber><CCCubicWeight></CCCubicWeight><CCDeadWeight></CCDeadWeight><CCDeliveryInstructions></CCDeliveryInstructions><CCGoodsDesc>".strtoupper($goodDescription)."</CCGoodsDesc><CCSenderFax></CCSenderFax><CCReceiverFax></CCReceiverFax><CCGoodsOriginCtryCode>".strtoupper($sender_counrty_code)."</CCGoodsOriginCtryCode><CCReasonExport>PERMANENT</CCReasonExport><CCShipTerms>DDU</CCShipTerms><CCDestTaxes></CCDestTaxes><CCManNoOfShipments>1</CCManNoOfShipments><CCSecurity>0.0000</CCSecurity><CCInsurance>0.0000</CCInsurance><CCInsuranceCurrCode>USD</CCInsuranceCurrCode><CCSerialNo></CCSerialNo><CCReceiverPhone2></CCReceiverPhone2><CCCreateJob>Y</CCCreateJob><CCJobCollectionAddress>".strtoupper($senderaddress1)." ".strtoupper($senderaddress2)." ".strtoupper($senderaddress3)."</CCJobCollectionAddress><CCJobCollectionContactName>".strtoupper($senderName)."</CCJobCollectionContactName><CCJobCollectionPhone>".$senderPhoneNO."</CCJobCollectionPhone><CCJobCollectionCompany>".strtoupper($senderCompany)."</CCJobCollectionCompany><CCJobCollectionDate>".$BookingDatashow->date_ready."</CCJobCollectionDate><CCJobCollectionReadyTime>".date("H:i", strtotime($BookingDatashow->time_ready))."</CCJobCollectionReadyTime><CCJobCollectionCloseTime>".date("H:i", strtotime($BookingDatashow->close_time))."</CCJobCollectionCloseTime><CCSurcharge></CCSurcharge><CCIsValidate>N</CCIsValidate>$stringItems</CC></CMDetail></WSGET>");
		//echo $xmlString;
		//exit();
		$pxml = simplexml_load_string($xmlString);
		$result = xml2array($pxml);
		
		$data = array();
		$data['Username']='9B948D40DCF977EE65A95A424A543A34';
		$data['Password']='EE4C5439A0CEB17D7159D53D08ADA548';
		$data['xmlStream']=$xmlString;
		$data['LevelConfirm']='detail';
		$post_str = '';

		foreach($data as $key=>$val) {
			$post_str .= $key.'='.$val.'&';
		}
		$post_str = substr($post_str, 0, -1);
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, 'https://ws05.ffdx.net/ffdx_ws/v12/service_customer.asmx/UploadCMawbWithLabelToServer');
		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post_str);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		$result = curl_exec($ch);

		curl_close($ch);
		$pxml = simplexml_load_string($result);
		$result = xml2array($pxml);
		/*echo "<pre>";
		print_r($result);
		echo "</pre>";
		exit();*/
		/* For testing purpose below code i have kept */
		$to = "smita.mahata@gmail.com";
		$subject = "Result to compare from API Integration";
		$mail_body = '<html>
		<body bgcolor="#ffffcc" topmargin="25">
		<h1>API Result</h1>
		<p>The follow items need attention: ' . print_r($result,true) . ' </p></body></html>';
		$headers = "From:info@prioritycouriers.com.au\r\n";
		$headers .= "Content-type: text/html\r\n";
		mail($to, $subject, $mail_body, $headers);
		/* For testing purpose below code i have kept */
		/*echo "<pre>";
		print_r($result);
		echo "</pre>";
		exit();*/
		$addresserror = $result['WSGET']['Status']['Error'];
		$storeData=$result['WSGET']['Status']['CC'];
		$webservice = $result['WSGET']['Status']['CCToCarrier'];
		 
		//commit the transaction in your database
		if(isset($storeData['CCAltRef']) && !empty($storeData['CCAltRef'])){
			$shippmentNo = $storeData['CCAltRef'];
			if($BookingDatashow->service_name == 'premium' ||  $BookingDatashow->service_name == 'economy')
			{
				$shippmentNo =  substr($shippmentNo, 0, 12);
			}
			$BookingDatashow->shipment_number = $shippmentNo;
		}
		//$response[PAYMENTINFO_0_TRANSACTIONID]
		
		$CCConnote = ($storeData['CCConnote']); /*Commented by smita 1 Dec 2020 */
		
	}
	
	if(isset($CCConnote) && !empty($CCConnote)){
		$BookingDatashow->CCConnote = $CCConnote;
	}
	//echo $CCConnote;
	//exit();
	//$addresserror="Label generated failed"; 
	/*This is commented because now xml verification is moving after payment*/	
	if (isset($addresserror) && $addresserror!=""){

		echo "<script src='".SITE_URL."/assets/js/jquery.min.js'></script><script type='text/javascript' src='".SITE_URL."assets/plugins/bootstrap/js/bootstrap.min.js'></script><script type='text/javascript'>
		$(document).ready(function(){
			$('#AddressError').modal('show');
			$('#addressClsModal').click(function(e){

				var url = '".SITE_URL."addresses.php?error=true';

				$(location).attr('href',url);
				e.preventDefault();
			});
		});

		</script>";

	} 
	
	if(isset($BookingDatashow->service_name) && $BookingDatashow->service_name == 'international'){
		$BookingDatashow->servicepagename = 'international';
	}

	$tracking_id = $CCConnote;
	if(defined(BOOKED_STATUS)){
		$tracking_status = BOOKED_STATUS;
	}
	/*
	Important Point: status is set as booked because currently tracking is removed
	if(!empty($tracking_id))
	{
		
		$tracking_status_ids = tracking_xml_response($tracking_id);
	

		if(empty($tracking_status_ids) && defined(BOOKED_STATUS)){
			$tracking_status = BOOKED_STATUS;
		}
		set_tracking_status();

		for($i=0;$i<count((array)$tracking_status_ids);$i++){
			if(defined(DELIVERED_STATUS_VALUE) && DELIVERED_STATUS_VALUE == $tracking_status_ids[$i]){
				$tracking_status = DELIVERED_STATUS;
			}elseif (defined(BOOKED_STATUS_VALUE) && BOOKED_STATUS_VALUE == $tracking_status_ids[$i]){
				$tracking_status = TRANSIT_STATUS;
			}

		}

	} */
	$BookingNumber=($storeData['BookingNumber']);
	$BookingDatashow->tracking_status = BOOKED_STATUS;
}
}
//if($CCConnote){
	/* end to check with the ffdex validation */
	//echo "timeflag:".$timeflag."addresserror:".$addresserror."</br>";
	if($timeflag == false && $addresserror==""){

		if(isset($_SESSION['nett_due_amt']) && $_SESSION['nett_due_amt']!=0)
		{
			$BookingDatashow->delivery_fee = $_SESSION['nett_due_amt'];
		}else{
			$BookingDatashow->delivery_fee = $final_delivery_fee;
		}
		if(isset($_SESSION['final_fuel_fee']) && $_SESSION['final_fuel_fee']!=0)
		{
			$BookingDatashow->fuel_surcharge = $_SESSION['final_fuel_fee'];
		}else{
			$BookingDatashow->fuel_surcharge = $final_fuel_fee;
		}
		if(isset($_SESSION['total_delivery_fee']) && $_SESSION['total_delivery_fee']!=0)
		{
			$BookingDatashow->total_delivery_fee = $_SESSION['total_delivery_fee'];
		}else{
			$BookingDatashow->total_delivery_fee = $total_delivery_charge;
		}
		$BookingDatashow->service_surcharge = $final_surcharge_fee;

		$BookingDatashow->delivery_fee_org = $final_delivery_fee;
		$BookingDatashow->fuel_surcharge_org = $final_fuel_fee;
		$BookingDatashow->total_delivery_fee_org = $total_delivery_charge;
		$BookingDatashow->total_gst_delivery_org= $total_gst_delivery;

		$BookingDatashow->discount = number_format($_SESSION['discountAmt'],2,'.',''); // unwanted variable because we are not putting and discount now
		if($_SESSION['discountAmt'])
		{
			$total_delivery_charge_after_dis = $_SESSION['nett_due_amt']+$_SESSION['final_fuel_fee']+$_SESSION['total_gst_delivery'];
			$BookingDatashow->total_dis_delivery_fee = floatval($total_delivery_charge_after_dis);
		}
		/*
		$BookingDatashow->total_new_charge = $_SESSION['total_new_charges'];
		$BookingDatashow->gst_surcharge = $_SESSION['total_gst'];
		if(isset($_SESSION['total_due']) && $_SESSION['total_due']!=0)
		{
			$BookingDatashow->rate = $_SESSION['total_due'];
		}else{
			$BookingDatashow->rate = $total_due;
		}
		*/
		//echo "total due:".$total_due;
		//exit();
		$BookingDatashow->total_new_charge = $total_new_charges;
		$BookingDatashow->gst_surcharge = $total_gst;
		$BookingDatashow->rate = $total_due;
		
		if(isset($_SESSION['total_gst_delivery']) && $_SESSION['total_gst_delivery']!=0)
		{
			$BookingDatashow->total_gst_delivery = $_SESSION['total_gst_delivery'];
		}else{
			$BookingDatashow->total_gst_delivery = $total_gst_delivery;
		}
		$booking_id=$__Session->GetValue("booking_id");
		//echo "booking id:".$booking_id."</br>";
		$BookingDatashow->booking_id = $booking_id;
		$__Session->SetValue("booking_details",$BookingDatashow);

		$__Session->Store();
		$BookingDetailsData = $__Session->GetValue("booking_details");
		/*echo "isset:".isset($addresserror); 
		echo "<pre>";
		 print_r($_POST['status']);
		 echo "</pre>";
		 exit();*/
		 /* Steve only wants to save details after payment is successful
		if(!isset($addresserror) && empty($addresserror) && isset($_POST['status']) && $_POST['status']!=''){
			try {
				
				include_once(DIR_WS_RELATED."savebookingdata.php");
			}catch (HttpException $ex) {
				echo "status code:".$ex->statusCode;
				print_r($ex->getMessage());
			}
			//echo "autoid:".$autoId;
			//();
		}
		*/
		
		/*Paypal integration*/
		
		if(empty($_GET['TOKEN']) && empty($_GET['PayerID']) && $_POST['status'] == 'paypal' && $addresserror==""){

			  /* Old paypal integration comment by smita 30 Nov 2020*/
			  /*$request_params = array(
				 'RETURNURL' => $success_url,
				 'CANCELURL' => $cancel_url,
				 'NOSHIPPING' => '1',
				 'ALLOWNOTE' => '1'
			  );

			  $order_params = array(
				 'PAYMENTREQUEST_0_AMT' => $amount,
				 'PAYMENTREQUEST_0_ITEMAMT' => $amount,
				 'PAYMENTREQUEST_0_CURRENCYCODE' => $currency
			  );
			  $_SESSION['total_due'] = $amount;
			  $item = array(
				 'L_PAYMENTREQUEST_0_NAME0' => $service_name,
				 'L_PAYMENTREQUEST_0_DESC0' => $desc_of_goods,
				 'L_PAYMENTREQUEST_0_AMT0' => $amount,
				 'L_PAYMENTREQUEST_0_QTY0' => '1'
			  );

			  //initiate express checkout transaction
			  $response = $paypal->request('SetExpressCheckout', $request_params + $order_params + $item);
			  $BookingDetailsData['payment_type'] = 'paypal';

			  if(is_array($response) && $response['ACK'] == 'Success'){
				  $token = $response['TOKEN'];

				  //redirect to paypal where the buyer will make his payment
				  header('Location: https://www.sandbox.paypal.com/webscr?cmd=_express-checkout&token=' . $token);
				  die();
			  }*/
			  /* Old paypal integration comment by smita 30 Nov 2020 */
		/*Paypal integration*/
			
			/*
			if($autoId)
		{
			*/
			$request = new OrdersCreateRequest();
			$request->prefer('return=representation');
			$request->body = [
			                     "intent" => "CAPTURE",
			                     "purchase_units" => [[
			                         "reference_id" => $service_name,
			                         "amount" => [
			                             "value" => $amount,
			                             "currency_code" => $currency
			                         ]
			                     ]],
			                     "application_context" => [
			                          "cancel_url" => $cancel_url,
			                          "return_url" => $success_url
			                     ]
			                 ];

			try {
			    // Call API with your client and get a response for your call
			    $response = $client->execute($request);
			    /*echo "<pre>";
			    print_r($response);
			    echo "</pre>";
			    exit();*/
			    // If call returns body in response, you can get the deserialized version from the result attribute of the response
			    if(isset($response->result->links[1]->href) && !empty($response->result->links[1]->href)){
			    	//echo $response->result->links[1]->href;
			    	 header('Location:'.$response->result->links[1]->href);
				 	 die();
			    }

			}catch (HttpException $ex) {
			    echo $ex->statusCode;
			    print_r($ex->getMessage());
			}


		}

	}



	//after a successful redirect, complete the express checkout transaction
	if (!defined('PAYPALWPP_SKIP_LINE_ITEM_DETAIL_FORMATTING') || PAYPALWPP_SKIP_LINE_ITEM_DETAIL_FORMATTING != 'true'){
        $order_amount_fmt = number_format($total_due,2);
      }
      else{
        $order_amount_fmt = $total_due;
      }

      $amount = isset($_SESSION['total_due']) ? $_SESSION['total_due'] : $order_amount_fmt;
	/*
	if(isset($_SESSION['total_due']) && $_SESSION['total_due']!=0)
	{
		$amount = $_SESSION['total_due'];
	}else{
		$amount = $total_due;
	}*/
	//echo "</br>".$amount;

	if(isset($_GET["token"]) && isset($_GET["PayerID"]))
	{

		//echo "token:".$_GET["token"]."</br>";
		//echo "payer:".$_GET["PayerID"]."</br>";
		/* Commented by Smita 30 No 2020 */
		/*$params = array(
		  'TOKEN' => $_GET['token']
		  );
		$resArray = $paypal->request("GetExpressCheckoutDetails", $params );
		$_SESSION ['reshash'] = $resArray;
		$ack = strtoupper ( $resArray ["ACK"] );
		if ($ack == "SUCCESS") {
			$amount = $resArray[PAYMENTREQUEST_0_AMT];
		}


		$amount = $resArray[AMT];
		$currency = 'AUD';
		$request_params = array(
		  'TOKEN' => $_GET['token'],
		  'PAYMENTACTION' => 'Sale',
		  'PAYERID' => $_GET['PayerID'],
		  'PAYMENTREQUEST_0_AMT' => $amount,
		  'PAYMENTREQUEST_0_CURRENCYCODE' => $currency
		);


		$response = $paypal->request('DoExpressCheckoutPayment', $request_params);*/
		/* Commented by Smita 30 No 2020 */
		$tokenid = $_GET["token"];
		$request = new OrdersGetRequest($tokenid);
		try {
			$response = $client->execute($request);
			if(isset($response->statusCode) && $response->statusCode == 201 && isset($response->result->status) && $response->result->status == 'COMPLETED'){
				$transaction_id = $response->result->purchase_units[0]->payments->captures[0]->id;
		    	$amount = $response->result->purchase_units[0]->payments->captures[0]->amount->value;
				$payment_status = $response->result->status;
				$txnResponseCode = "0";
				$payment_success = true;
			}else{
				$request = new OrdersCaptureRequest($tokenid);
				$request->prefer('return=representation');
				try {
				    // Call API with your client and get a response for your call
				    $response = $client->execute($request);

				    // If call returns body in response, you can get the deserialized version from the result attribute of the response
				    if(isset($response->statusCode) && $response->statusCode == 201 && $response->result->status == 'COMPLETED'){

				    	$transaction_id = $response->result->purchase_units[0]->payments->captures[0]->id;
				    	$amount = $response->result->purchase_units[0]->payments->captures[0]->amount->value;
						$payment_status = $response->result->status;
						$txnResponseCode = "0";
						$payment_success = true;
						
				    }
				    //echo "transaction id:".$transaction_id."amount:".$amount."payment status:".$payment_status;
				    //exit();
				}catch (HttpException $ex) {
					echo $ex->statusCode;
					print_r($ex->getMessage());
				}
			}

		}catch (HttpException $ex) {
		    echo $ex->statusCode;
		    print_r($ex->getMessage());
		}


	}





	/*if(is_array($response) && $response['ACK'] == 'Success'){
		$transaction_id = $response[PAYMENTINFO_0_TRANSACTIONID];
		$payment_success = true;
	}elseif(isset($response["L_LONGMESSAGE0"]) && $_POST['status'] != 'paynow' && (isset($_GET["token"]) &&  $_GET["token"]!= '') && $response['ACK'] != 'Success'){
		echo "<script src='".SITE_URL."/assets/js/jquery.min.js'></script><script type='text/javascript' src='".SITE_URL."assets/plugins/bootstrap/js/bootstrap.min.js'></script><script type='text/javascript'>
		$(document).ready(function(){
			$('#paymentCancel').modal('show');

		});

		</script>";



    }*/

	$payment_status ='paypal';

	if((isset($_POST['status']) && $_POST['status'] == 'paynow') && ($timeflag == false))
	{

		// $SECURE_SECRET = "secure-hash-secret";
		//test account$SECURE_SECRET = "F8EEF90721D26E27EEF40F4B1522F592";
		$SECURE_SECRET = "365B97A93AAAC4A070120923BB4B65AB";
		// add the start of the vpcURL querystring parameters
		//$vpcURL = $_POST["virtualPaymentClientURL"] . "?";
		$vpcURL = "https://migs.mastercard.com.au/vpcpay"."?";
		unset($_POST["virtualPaymentClientURL"]);
		unset($_POST["paynow"]);
		// merchant secret has been provided.
		$md5HashData = $SECURE_SECRET;
		ksort($_POST);
		$appendAmp = 0;

		foreach($_POST as $key => $value) {
			if($key!='PAYMENTREQUEST_0_AMT' && $key!='dangerousgood' && $key!='old_base_delivery_fee' && $key!='old_fuel_fee' && $key!='old_total_delivery_fee' && $key!='old_total_due_amt' && $key !='old_total_gst' && $key!='old_total_gst_delivery' && $key!='old_total_new_charges' && $key!='ptoken' && $key!='security_statement' && $key!='terms_and_conditions' && $key!='temp_value'){
				
				
			 if (strlen($value) > 0) {
				
				if ($appendAmp == 0) {
					$vpcURL .= urlencode($key) . '=' . urlencode($value);
					$appendAmp = 1;
				} else {
					$vpcURL .= '&' . urlencode($key) . "=" . urlencode($value);
					
				}
				 /*
				$md5HashData .= $value;
				*/
				$hashInput .= $key . "=" . $value . "&";
			 }
			 }
		}
		
		// the merchant secret has been provided.
		if (strlen($SECURE_SECRET) > 0) {
			/* 
				Below code i am using to replace abc in orderInfo to pass connoate number
				And in VPC payment method all the parameters should be pass ascending alphabetic
				order
			*/
			$hashInput = str_replace("vpc_OrderInfo=abc&","vpc_OrderInfo=$BookingDatashow->CCConnote&",$hashInput);
			$hashInput = rtrim($hashInput,"&");
			
			/* 
				Below code i am using to replace status=paynow to null
				And in VPC payment method all the parameters should be pass ascending alphabetic
				order
			*/
			$hashInput = str_replace("status=paynow&","",$hashInput);
			$secureHash = strtoupper(hash_hmac('SHA256',$hashInput, pack("H*",$SECURE_SECRET)));
			
			$vpcURL .= "&Title=PHP+VPC+3+Party+Transacion&vpc_SecureHash=".$secureHash."&vpc_SecureHashType=SHA256";
			
		}
		$vpcURL = str_replace("status=paynow&","",$vpcURL);
		$vpcURL = str_replace("vpc_OrderInfo=abc&","vpc_OrderInfo=$BookingDatashow->CCConnote&",$vpcURL);
		
		header("Location: ".$vpcURL);
		exit();
	}


	//exit();
	
	
	if(isset($transaction_id) && !empty($transaction_id)){
		$transactionNo = $transaction_id;
	}else{
		$transactionNo = null2unknown($_GET["vpc_TransactionNo"]);
	}
	if(isset($txnResponseCode) && !empty($txnResponseCode)){
		$txnResponseCode = $txnResponseCode;
	}else{
		$txnResponseCode = null2unknown($_GET["vpc_TxnResponseCode"]);
	}


	/*
	Comment by smita 1 Dec 2020*/
	if($txnResponseCode == "0" && $txnResponseCode != "No Value Returned") {
		$transaction_id = $transactionNo;
		//$payment_status = $_GET['vpc_Card'];
		$payment_status = $_GET['vpc_Card'];
		if($transaction_id)
		$payment_success = true;
	}else{
		if(isset($_GET['vpc_TxnResponseCode']) && $_GET['vpc_TxnResponseCode']){
			$payment_cancelled_msg = getResultDescription($_GET['vpc_TxnResponseCode']);
		}
		//echo $payment_cancelled_msg;
		//exit();
		/*
			Commented by Smita 2022 4th feb
		foreach($anz_payment_response_arr as $key => $value) {
			if(isset($_GET['vpc_TxnResponseCode']) && $_GET['vpc_TxnResponseCode']==$key)
			{
				$payment_cancelled_msg = $value;
			}
		}*/
	}
	//echo $payment_cancelled_msg;
	/*echo "transaction id:".$transaction_id."amount:".$amount."payment status:".$payment_status;
    echo "status:".$_POST['status']."</br>";
    echo "payment success".$payment_success;
    echo "<pre>";
    print_r($addresserror);
    echo "</pre>";
	exit();*/
	if(isset($payment_success) && $payment_success == true){
		
		$bookingid=$__Session->GetValue("booking_id");
		$BookingDatashow->payment_type = $payment_status;
		$BookingDatashow->payment_done = 'true';
		$BookingDatashow->transaction_id = $transaction_id;
		
		/* Its to check the cut off timings for the services */
		/* start to check with the ffdex validation */
		$bookingidXml=stripslashes($bookingid);
		//echo "booking xml:".$bookingidXml;
		//exit();
		/*echo "<pre>";
		print_r($BookingItemDetailsData);
		echo "</pre>";*/
		/*$stringItems = "";

		foreach($BookingItemDetailsData as $key => $val){
			
			$stringItems .= '<CCItem><CCItemWeight>'.$val['item_weight'].'</CCItemWeight>';
			$stringItems .= '<CCItemDeadWeight>'.$val['vol_weight'].'</CCItemDeadWeight>';
			$stringItems .= '<CCItemCubicLengthCm>'.$val['length'].'</CCItemCubicLengthCm>';
			$stringItems .= '<CCItemCubicWidthCm>'.$val['width'].'</CCItemCubicWidthCm>';
			$stringItems .= '<CCItemCubicHeightCm>'.$val['height'].'</CCItemCubicHeightCm><CCItemCubicWeight/><CCItemAltRef/><CCItemNotes/><CCItemCustomsValue/><CCItemCurrencyCode/><CCItemGoodsDesc/><CCItemHarmonisedCode/><CCItemOriginCountryCode/><CCItemNoOfPcs/>
			</CCItem>';
				
		}
*/
		/* Commented by smita 1 Dec 2020 */
		/**/
		$__Session->SetValue("booking_details",$BookingDatashow);
		$__Session->Store();

		include_once(DIR_WS_RELATED."savebookingdata.php");

		//require_once(DIR_WS_PDF.'dompdf/dompdf_config.inc.php');

		//$bookingid ='8l4h2q8P2t9q4f';
		
		if($autoId)
		{

			$fieldArr=array("*");
			$BookingSearchDetailArray = array();
			$BookingSearchDetailArray[] = array('Search_On'=>'auto_id', 'Search_Value'=>$autoId, 'Type'=>'int', 'Equation'=>'=', 'CondType'=>'AND', 'Prefix'=>'', 'Postfix'=>'');
			$BookingDetailsData = $BookingDetailsMasterObj->getBookingDetails($fieldArr,$BookingSearchDetailArray);
			$BookingDetailsDataVal = $BookingDetailsData[0];
			/*echo "<pre>";
			print_r($BookingDetailsDataVal);
			echo "</pre>";
			exit();*/
			$total_display_rate=$BookingDetailsDataVal['rate'];
			$payment_type = $_SESSION['payment_type'];
			$CCConnote_t = $BookingDetailsDataVal['CCConnote'];
			$CCConnote = $BookingDetailsDataVal['CCConnote'];
			$service_name = $BookingDetailsDataVal['service_name'];
			$country_code = $BookingDetailsDataVal['deliveryid'];
			$flag = $BookingDetailsDataVal['flag'];
			if($flag == 'international')
			{
				$countryseaArr[0] = array('Search_On'    => 'countries_id',
				'Search_Value' => $country_code,
				'Type'         => 'int',
				'Equation'     => '=',
				'CondType'     => 'And',
				'Prefix'       => '',
				'Postfix'      => '');
				$CountryDataObj=$CountryMasterObj->getCountry(null,$countryseaArr);
				$interCodedata=$CountryDataObj[0];
				if(isset($interCodedata['countries_name']) && $interCodedata['countries_name'] != 'Australia'){
					$recieverCountry= '<li>'.ucwords(strtolower($interCodedata['countries_name'])).'</li>';
				}
				

				$senderCountry = '<tr>
<td class="w_30" valign="top">Country:</td>
<td class="w_65" valign="top">Australia</td>
</tr>';
			}/*else{
				$recieverCountry = 'Australia';
				$senderCountry = 'Australia';
			}*/
			if($country_code == UNITED_STATE_ID)
			{
				$postcodelbl = COMMON_US_ZIPCODE;
			}else{
				$postcodelbl = COMMON_RECEIVER_POST_CODE;
			}
			ob_start();
			if($flag == 'international')
			{
				$webservice = strtoupper($BookingDetailsDataVal["webservice"]);
			}else{
				$webservice = ucwords(strtolower($BookingDetailsDataVal["webservice"]));
			}
			if($BookingDetailsDataVal['discount']!=0 && $BookingDetailsDataVal['discount']!='')
			{
				if($BookingDetailsDataVal['delivery_fee_org']!=0 && $BookingDetailsDataVal['delivery_fee_org']!=''){
					$extra_row .= '<li class="w_100">'.BASE_DELIVERY_FEE.'<span class="pull-right">$'.number_format($BookingDetailsDataVal['delivery_fee_org'],2, '.', '').'</span></li>';
				}
				if($BookingDetailsDataVal['fuel_surcharge_org']!=0 && $BookingDetailsDataVal['fuel_surcharge_org']!=''){
					$extra_row .= '<li class="w_100">Fuel Surcharge<span class="pull-right">$'.number_format($BookingDetailsDataVal['fuel_surcharge_org'],2, '.', '').'</span></li>';
				}
				if($BookingDetailsDataVal['total_gst_delivery_org']!=0 && $BookingDetailsDataVal['total_gst_delivery_org']!=''){
					$extra_row .= '<li class="w_100">'.CHECKOUT_GST.'<span class="pull-right">$'.number_format($BookingDetailsDataVal['total_gst_delivery_org'],2, '.', '').'</span></li>';
				}
				if($BookingDetailsDataVal['total_delivery_fee_org']!=0 && $BookingDetailsDataVal['total_delivery_fee_org']!='')
				{
					$extra_row .='<li class="w_100">Total Invoice Amount<span class="pull-right">$'.number_format($BookingDetailsDataVal['total_delivery_fee_org'],2, '.', '').'</span></li>';
				}
			}else{
				if($BookingDetailsDataVal['delivery_fee']!=0 && $BookingDetailsDataVal['delivery_fee']!=''){
					$extra_row .= '<li class="w_100">'.BASE_DELIVERY_FEE.'<span class="pull-right">$'.number_format($BookingDetailsDataVal['delivery_fee'],2, '.', '').'</span></li>';
				}
				if($BookingDetailsDataVal['fuel_surcharge']!=0 && $BookingDetailsDataVal['fuel_surcharge']!=''){
					$extra_row .= '<li class="w_100">Fuel Surcharge<span class="pull-right">$'.number_format($BookingDetailsDataVal['fuel_surcharge'],2, '.', '').'</span></li>';
				}
				if($BookingDetailsDataVal['service_surcharge']!=0 && $BookingDetailsDataVal['service_surcharge']!=''){
					$extra_row .= '<li class="w_100">'.RESIDENTIAL_SURCHARGE.'<span class="pull-right">$'.number_format($BookingDetailsDataVal['service_surcharge'],2, '.', '').'</span></li>';
				}
				if($BookingDetailsDataVal['total_gst_delivery']!=0 && $BookingDetailsDataVal['total_gst_delivery']!=''){
					$extra_row .= '<li class="w_100">'.CHECKOUT_GST.'<span class="pull-right">$'.number_format($BookingDetailsDataVal['total_gst_delivery'],2, '.', '').'</span></li>';
				}
				if($BookingDetailsDataVal['total_delivery_fee']!=0 && $BookingDetailsDataVal['total_delivery_fee']!='')
				{
					$extra_row .='<li class="w_100">Total Invoice Amount<span class="pull-right">$'.number_format($BookingDetailsDataVal['total_delivery_fee'],2, '.', '').'</span></li>';
				}
			}
			if($BookingDetailsDataVal['total_dis_delivery_fee']!=0 && $BookingDetailsDataVal['total_dis_delivery_fee']!=''){
			$extra_row .='<li class="w_100">Total Delivery Discounted Fee<span class="pull-right">$'.number_format($BookingDetailsDataVal['total_dis_delivery_fee'],2, '.', '').'</span></li>';
			}
			/*
			if($BookingDetailsDataVal['values_of_goods']!=0 && $BookingDetailsDataVal['values_of_goods']!=''){
				$extra_row .='<tr>
				<td class="w_35 fee_dashed"></td>
				<td class="w_60 fee_dashed"></td>
				</tr>
				<tr>
				<td class="w_35 fee_above_dashed" valign="top">Value Of Goods</td>
				<td class="w_60 fee_above_dashed text-right" valign="top">$'.number_format($BookingDetailsDataVal['values_of_goods'],2, '.', '').'</td>
				</tr>';
			}
			*/
			
			
			if($BookingDetailsDataVal["description_of_goods"]){

				$desc = $BookingDetailsDataVal["description_of_goods"];
			}/*else{

				$desc = $BookingDetailsDataVal["goods_nature"];
			}*/

			/*if(($BookingDetailsDataVal['coverage_rate']!=0 && $BookingDetailsDataVal['coverage_rate']!='')||($BookingDetailsDataVal['discount']!=0 && $BookingDetailsDataVal['discount']!=''))
			{
				if($BookingDetailsDataVal['total_new_charge']!=0 && $BookingDetailsDataVal['total_new_charge']!=''){
					$extra_row .='<li class="w_100">Total Fee<span class="pull-right">$'.number_format($BookingDetailsDataVal['total_new_charge'],2, '.', '').'</span></li>';
				}
				if($BookingDetailsDataVal['gst_surcharge']!=0 && $BookingDetailsDataVal['gst_surcharge']!=''){
					$extra_row .='<li class="w_100">Total GST<span class="pull-right">$'.number_format($BookingDetailsDataVal['gst_surcharge'],2, '.', '').'</span></li>';
				}
			}*/
			if($BookingDetailsDataVal['rate']!='' && $BookingDetailsDataVal['rate']!=0){
				$extra_row .='<li class="w_100 bold padding_top_30">Total Amount Paid<span class="pull-right">$'.number_format($BookingDetailsDataVal['rate'],2, '.', '').'</span></li>';
			}
			if (isset($BookingDetailsDataVal['payment_type']) && !empty($BookingDetailsDataVal['payment_type'])) {
				$extra_row .='<li class="w_100 padding_top_20">Form of Payment<span class="pull-right">'.ucfirst($BookingDetailsDataVal['payment_type']).'</span></li>';
			}
			if (isset($BookingDetailsDataVal['transaction_id']) && !empty($BookingDetailsDataVal['transaction_id'])) {
				$extra_row .='<li class="w_100">TID<span class="pull-right">'.ucfirst($BookingDetailsDataVal['transaction_id']).'</span></li>';
			}
			if(!empty($BookingDetailsDataVal["authority_to_leave"])&& $BookingDetailsDataVal["authority_to_leave"]!='no')
			{
			 $str_authority ='<tr>
                                                        <td class="w_45" valign="top">Authority to leave:</td>
                                                        <td class="w_50" valign="top">'. $BookingDetailsDataVal["authority_to_leave"].'</td>
                                                    </tr>
													<tr>
                                                        <td class="w_90" valign="top">Placement:</td>
                                                   	</tr>
                                                    <tr>
                       									<td class="w_90" valign="top">'. $BookingDetailsDataVal["where_to_leave_shipment"].'</td>
                                                    </tr>';
			}
			/* Invoice Payee conditional fields */
			if (isset($Users->company) && !empty($Users->company)) {
				$user_company ='<li>'.ucfirst(valid_output($Users->company)).'</li>';
			}
			if (isset($Users->address2) && !empty($Users->address2)) {
				$user_address2 ='<li>'.ucfirst(valid_output($Users->address2)).'</li>';
			}
			if (isset($Users->address3) && !empty($Users->address3)) {
				$user_address3 ='<li>'.ucfirst(valid_output($Users->address3)).'</li>';
			}
			if (isset($Users->sender_area_code) && !empty($Users->sender_area_code)) {
				$user_sender_area_code =(valid_output($Users->sender_area_code)).'&nbsp;';
			}
			/* Address conditional fields */
			if (isset($BookingDetailsDataVal["sender_company_name"]) && !empty($BookingDetailsDataVal["sender_company_name"])) {
				$sender_company ='<li>'.ucfirst(valid_output($BookingDetailsDataVal["sender_company_name"])).'</li>';
			}
			if (isset($BookingDetailsDataVal["sender_address_2"]) && !empty($BookingDetailsDataVal["sender_address_2"])) {
				$sender_address2 ='<li>'.ucfirst(valid_output($BookingDetailsDataVal["sender_address_2"])).'</li>';
			}
			if (isset($BookingDetailsDataVal["sender_address_3"]) && !empty($BookingDetailsDataVal["sender_address_3"])) {
				$sender_address3 ='<li>'.ucfirst(valid_output($BookingDetailsDataVal["sender_address_3"])).'</li>';
			}
			if (isset($BookingDetailsDataVal["reciever_company_name"]) && !empty($BookingDetailsDataVal["reciever_company_name"])) {
				$receiver_company ='<li>'.ucfirst(valid_output($BookingDetailsDataVal["sender_company_name"])).'</li>';
			}
			if (isset($BookingDetailsDataVal["reciever_address_2"]) && !empty($BookingDetailsDataVal["reciever_address_2"])) {
				$receiver_address2 ='<li>'.ucfirst(valid_output($BookingDetailsDataVal["reciever_address_2"])).'</li>';
			}
			if (isset($BookingDetailsDataVal["reciever_address_3"]) && !empty($BookingDetailsDataVal["reciever_address_3"])) {
				$receiver_address3 ='<li>'.ucfirst(valid_output($BookingDetailsDataVal["reciever_address_3"])).'</li>';
			}
			
			/*echo "<pre>";
			print_r($_SESSION);
			echo "</pre>";
			exit();*/
			/* Dimmensions variable */
			foreach ($BookingItemDetailsData as $key => $val) {
				$individual_items .= $val["quantity"] .' &#64; '. $val["item_weight"] .'kg '. $val["length"] . 'cm x '. $val["width"] .'cm x '. $val["height"] .'cm <br>';
			}

		//echo $abc;
		$html='<style type="text/css">
		#outlook a {padding:0;}body{width:100% !important; -webkit-text-size-adjust:100%; -ms-text-size-adjust:100%; margin:0; padding:0;}.ExternalClass {width:100%;}
		.ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div {line-height: 100%;}#backgroundTable {margin:-30px 0 0; padding:0; width:100% !important; line-height: 100% !important; color:#333; font-size: 14px; font-family:"Helvetica Neue",Helvetica,Arial,sans-serif;}img {outline:none; text-decoration:none; -ms-interpolation-mode: bicubic;}
		a img {border:none;}
		.image_fix {display:block;}p {margin: 1em 0;}
		h1, h2, h3, h4, h5, h6 {font-family: "Open Sans", sans-serif; font-weight: normal;}h1 a, h2 a, h3 a, h4 a, h5 a, h6 a {color: blue !important;}
		h1 a:active, h2 a:active,  h3 a:active, h4 a:active, h5 a:active, h6 a:active {
		  color: red !important;
		 }h1 a:visited, h2 a:visited,  h3 a:visited, h4 a:visited, h5 a:visited, h6 a:visited {
		  color: purple !important;
		}table td {border-collapse: collapse; width:100%}
		table { border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt; width:100%}
		a {color: #72c02c; text-decoration:none;}

		  a[href^="tel"], a[href^="sms"] {
		        text-decoration: none;
		        color: blue; /* or whatever your want */
		        pointer-events: none;
		        cursor: default;
		      }

		  .mobile_link a[href^="tel"], .mobile_link a[href^="sms"] {
		        text-decoration: default;
		        color: orange !important;
		        pointer-events: auto;
		        cursor: default;
		      }
		.w_100 {
		  width:100%;
		}
		.w_90 {
		  width:90%;
		}
		.w_75 {
		  width:75%;
		}
		.w_70 {
		  width:70%;
		}
		.w_65 {
		  width:65%;
		}
		.w_60 {
		  width:60%;
		}
		.w_55 {
		  width:55%;
		}
		.w_50 {
		  width:50%;
		}
		.w_45 {
		  width:45%;
		}
		.w_40 {
		  width:40%;
		}
		.w_35 {
		  width:35%;
		}
		.w_33 {
		  width:33.3%;
		}
		.w_30 {
		  width:30%;
		}
		.w_20 {
		  width:20%;
		}
		.ft-10 {
		  font-size: 10px;
		}
		.ft-11 {
		  font-size: 11px;
		}
		.ft-12 {
		  font-size: 12px;
		}
		.ft-13 {
		  font-size: 13px;
		}
		.ft-14 {
		  font-size: 14px;
		}
		.margin_bottom_60 {
		  margin-bottom: 60px;
		}
		.margin_bottom_40 {
		  margin-bottom: 40px;
		}
		.margin_bottom_30 {
		  margin-bottom: 30px;
		}
		.margin_bottom_20 {
		  margin-bottom: 20px;
		}
		.padding_bottom_20 {
		  padding-bottom: 20px;
		}
		.padding_bottom_10 {
		  padding-bottom: 10px;
		}
		.padding_top_30 {
		  padding-top: 30px;
		}
		.padding_top_20 {
		  padding-top: 20px;
		}
		ul {
		  list-style-type: none;
		  padding-left:0;
		}
		ul li {
		  padding-bottom:4px;
		}
		h2 {
		  font-size: 31.5px;
		  margin-bottom:0;
		  text-align:center;
		  }
		.no_border-b {
		  border-bottom:none !important;
		  margin-bottom: 0;
		}
		.bg-light {
		  padding:10px 15px;
		  border-radius:3px;
		  margin-bottom:10px;
		  background:#fcfcfc;
		  border:solid 1px #fcfcfc;
		  }
		.bg-light:hover {
		  border:solid 1px #e5e5e5;
		  }
		blockquote {
		  padding: 0 0 0 15px;
		  margin: 0 0 20px;
		  border-left: 5px solid #eee;
		  font-size: 17.5px;
		  font-weight: 300;
		  line-height: 1.25;
		  }
		blockquote:hover {
		  border-left: 5px solid #72c02c;
		  }
		blockquote p {
		  color: #555;
		  font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;
		  }
		.standard_font {
		  padding: 0 0 0 15px;
		  margin: 0 0 20px;
		  font-size: 17.5px;
		  font-weight: 300;
		  line-height: 1.25;
		  color: #555;
		  font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;
		}
		.bold {
		  font-weight: bold;
		}
		.my-red {
		  color: #F00;
		}
		.my-black {
		  color:#333;
		}
		.justy {
		  text-align: justify;
		  text-align: center;
		  }
		.my_green {
		  color: #72c02c !important;
		  }
		.muted {
		  color: #999;
		  }
		.text-right {
		  text-align:right;
		  }
		.pull-right {
		  text-align:right;
		  float:right;
		  }
		.border_bottom {
		  background: transparent;
		  color: transparent;
		  border-left: none;
		  border-right: none;
		  border-top: none;
		  border-bottom: 2px dashed #72c02c;
		  }
		.footer {
		  margin-top: 40px;
		  padding: 20px 10px;
		  background: #585f69;
		  color: #dadada;
		  }
		.footer h4, .footer h3 {
		  color: #e4e4e4 !important;
		  background: none;
		  text-shadow: none;
		  font-weight:lighter !important;
		  }
		.copyright {
		  font-size: 12px;
		  padding: 5px 10px;
		  background: #3e4753;
		  border-top: solid 1px #777;
		  color: #dadada;
		  }
		.address {
		  display: block;
		  margin-bottom: 20px;
		  font-style:normal;
		  line-height: 20px;
		  }
		.social_googleplus {
		  background: url(http://prioritycouriers.com.au/assets/img/icons/social/googleplus.png) no-repeat;
		  width: 28px;
		  height: 28px;
		  display: block;
		  }
		.social_googleplus:hover {
		  background-position: 0px -38px;
		  }
		.receipt {
		  font-size:10px;
		}
		.headline {
		  margin: 5px 0 10px 0;
		  }
		.lead {
		  font-size: 16px;
		  font-weight: 100;
		  line-height: 35px;
		  }
		.my_bigger_font,
		.my_bigger_font td {
		  font-size: 10px;
		  font-weight: 200;
		  line-height: 1;
		  }
		.pad_main {
		  padding: 10px 10px 5px 10px;
		}
		.pad_side {
		  padding: 0 10px 0 10px;
		}
		.pad_3 td {
		  padding: 3px;
		  font-size: 10px;
		}
		.pad_fee td,
		.pad_address {
		  padding: 3px;
		}
		.fee_dashed {
		  border-bottom: 2px dashed #72c02c;
		}
		.fee_above_dashed {
		  padding-top:10px !important;
		}
		</style>

		<table cellpadding="0" cellspacing="0" border="0" id="backgroundTable">
		  <tr>
		    <td>
		      <table cellpadding="0" cellspacing="0" border="0" align="center" class="w_100">
		        <tr>
		          <td valign="top">
		            <table cellpadding="0" cellspacing="1" border="0" align="center">
		              <tr>
		                <td class="pad_main" valign="top">
		                  <table  cellpadding="0" cellspacing="0" border="0" align="center">
		                    <tr>
		                      <td class="w_50" valign="top"></td>
		                      <td class="w_50" valign="top">
		                        <table cellpadding="0" cellspacing="0" border="0" align="center">
		                          <tr>
		                            <td valign="top">
		                              <table cellpadding="0" cellspacing="0" border="0" align="center">
		                                <tr>
		                                  <td class="w_45"></td>
		                                  <td>
		                                    <div class="headline text-right">
		                                      <img src="https://prioritycouriers.com.au/assets/img/Logo/Priority_Couriers-Logo_footer.png" style="width: 200px; /*height: 73px;*/" />
		                                    </div>
		                                  </td>
		                                </tr>
		                              </table>
		                            </td>
		                          </tr>
		                          <tr>
		                            <td>
		                              <table cellpadding="0" cellspacing="0" border="0" align="center">
		                                <tr>
		                                  <td class="w_75"></td>
		                                  <td>
		                                    <div class="text-left">
		                                        <ul>
		                                          <li class="ft-10">Priority Logistics Australia Pty Ltd</li>
		                                          <li class="ft-10">Trading as Priority Couriers</li>
		                                          <li>ABN 44 168 906 045</li>
		                                        </ul>
		                                    </div>
		                                  </td>
		                                </tr>
		                              </table>
		                            </td>
		                          </tr>
		                        </table>
		                      </td>
		                    </tr>
		                  </table>
		                </td>
		              </tr>
		            </table>
		          </td>
		        </tr>
		        <tr>
		          <td class="pad_side" valign="top">
		            <h2 class="bold">Tax Invoice</h2>
		            </td>
		        </tr>
		        <tr>
		          <td class="pad_side" valign="top">
		            <p class="justy ft-12">Your booking has been confirmed</p>
		          </td>
		        </tr>
		        <tr>
		          <td class="pad_main" valign="top">
		            <table cellpadding="0" cellspacing="1" border="0" align="center">
		              <tr>
		                <td valign="top">
		                  <table  cellpadding="0" cellspacing="0" border="0" align="center">
		                    <tr>
		                      <td class="w_50" valign="top"> <!--<img src="assets/img/Logo/Priority_Logistics_logo-small.png"/>-->
		                        <ul class="address margin-bottom_0">
		                          <li class="my-black">Customer No&nbsp;'.$UserAddresData->account_no.'</li>
		                          <li>'.ucfirst($Users->firstname).' '.ucfirst($Users->lastname).'</li>
		                          '.$user_company.'
		                          <li>'.ucfirst($Users->address1).'</li>
		                          '.$user_address2.'
		                          '.$user_address3.'
		                          <li>'.(valid_output($Users->suburb)).' '.(valid_output($Users->state)).' '.(valid_output($Users->postcode)).'</li>
		                          <li>'.(valid_output($profile_countries_name)).'</li>
		                        </ul>
		                      </td>
		                      <td class="w_50" valign="top">
		                        <table cellpadding="0" cellspacing="0" border="0" align="center">
		                          <tr>
		                            <td class="w_75"></td>
		                            <td>
		                              <ul>
		                                <li>InvoiceNo:&nbsp;'.$invoice_id.'</li>
		                                <li>'.date("d-M-Y").'</li>
		                              </ul>
		                            </td>
		                          </tr>
		                        </table>
		                      </td>
		                    </tr>
		                  </table>
		                </td>
		              </tr>
		              <tr>
		                <td class="pad_main" valign="top">
		                  <table cellpadding="0" cellspacing="0" border="0" align="center">
		                    <tr>
		                      <td class="w_33" valign="top">
		                        <table cellpadding="0" cellspacing="0" border="0" align="center">
		                          <tr>
		                            <td valign="top">
		                              <div class="headline bold w_90">Details</div>
		                            </td>
		                          </tr>
		                          <tr>
		                            <td valign="top">
		                              <ul>
		                                <li class="bold">Collection Date</li>
		                                <li>'. date("d M Y",strtotime($BookingDetailsDataVal["date_ready"])).'</li>
		                              </ul>
		                            </td>
		                          </tr>
		                          <tr>
		                            <td>
		                              <ul class="address margin-bottom_0">
		                                <li class="ft-12 bold">Service</li>
		                                <li class="padding_bottom_20">'. ucwords(strtolower($BookingDetailsDataVal["service_name"])).'</li>
		                                <li class="ft-12 bold">From</li>
		                                <li>'. ucwords(strtolower($BookingDetailsDataVal["sender_first_name"])).'&nbsp;'. ucwords(strtolower($BookingDetailsDataVal["sender_surname"])).'</li>
		                                '.$sender_company.'
		                                <li>'. ucwords(strtolower($BookingDetailsDataVal["sender_address_1"])).'</li>
		                                '.$sender_address2.'
		                                '.$sender_address3.'
		                                <li>'.ucwords(strtolower($BookingDetailsDataVal["sender_suburb"])).' '.strtoupper($BookingDetailsDataVal["sender_state"]).' '.$BookingDetailsDataVal["sender_postcode"].'</li>
		                                <li class="padding_bottom_20">&nbsp;</li>
		                                <li class="ft-12 bold">To</li>
		                                <li>'.ucwords(strtolower($BookingDetailsDataVal["reciever_firstname"])).'&nbsp;'.ucwords(strtolower($BookingDetailsDataVal["reciever_surname"])).'</li>
		                                '.$receiver_company.'
		                                <li>'.ucwords(strtolower($BookingDetailsDataVal["reciever_address_1"])).'</li>
		                                '.$receiver_address2.'
		                                '.$receiver_address3.'
		                                <li>'.ucwords(strtolower($BookingDetailsDataVal["reciever_suburb"])).' '.strtoupper($BookingDetailsDataVal["reciever_state"]).' '.$BookingDetailsDataVal["reciever_postcode"].'</li>
		                                '.$recieverCountry.'
		                              </ul>
		                            </td>
		                          </tr>
		                        </table>
		                      </td>
		                      <td class="w_33" valign="top">
		                        <table cellpadding="0" cellspacing="0" border="0" align="center">
		                          <tr>
		                            <td valign="top">
		                              <div class="headline bold w_90">Shipment details</div>
		                            </td>
		                          </tr>
		                          <tr>
		                            <td>
		                              <ul class="address margin-bottom_0">
		                                <li class="ft-12 bold">Description of Goods</li>
		                                <li>'.$desc.'</li>
		                              </ul>
		                              <ul class="address margin-bottom_0">
		                                <li class="ft-12 bold">Pieces and Weight</li>
		                                <li class="bold">'.$BookingDetailsDataVal["total_qty"].'@'.$BookingDetailsDataVal["total_weight"].'kg</li>
		                                <li>'.$individual_items.'</li>
		                              </ul>
		                            </td>
		                          </tr>
		                        </table>
		                      </td>
		                      <td class="w_33" valign="top">
		                        <table cellpadding="0" cellspacing="0" border="0" align="center">
		                          <tr>
		                            <td valign="top">
		                              <div class="headline bold w_90">Fees and Charges</div>
		                            </td>
		                          </tr>
		                          <tr>
		                            <td>
		                              <ul class="address margin-bottom_0">
		                                '.$extra_row.'
		                              </ul>
		                            </td>
		                          </tr>
		                        </table>
		                      </td>
		                    </tr>
		                  </table>
		                </td>
		              </tr>
		            </table>
		          </td>
		        </tr>
		      </table>
		    </td>
		  </tr>
		</table>';
//echo $html;
		//exit();

			//Commented by Smita 1 Dec 2020
		ob_clean();
		$path_to_pdf = DIR_WS_ONLINEPDF."receipt/TaxInvoice".(int)$autoId.".pdf";
		//use Dompdf;
		if (file_exists($path_to_pdf)) {
			unlink($path_to_pdf);
		}

		try {

			$dompdf = new DOMPDF();
			$dompdf->set_option('isHtml5ParserEnabled', true);
			$dompdf->set_option('isRemoteEnabled', true);
			$dompdf->load_html($html);
			$dompdf->render();
			file_put_contents($path_to_pdf, $dompdf->output());
		}catch (DOMPDF_Exception $e){
			return 'Error during PDF creation: ' . $e->getMessage();
		}
		//echo $html;
		//exit();

/*
	Below code is to save commercial invoice as pdf when international non-document is selected.
	It will be executed only when commercial invoice provider as value 2(I will use the Priority Couriers prepared commercial invoice)
*/
if(isset($BookingDatashow->commercial_invoice_provider) && $BookingDatashow->commercial_invoice_provider == 2){

	/* Dimmensions variable **** Curently not Used */
	foreach ($BookingItemDetailsData as $key => $val) {
		$items_des_str .= $val["quantity"] .' &#64; '. $val["item_weight"] .'kg '. $val["length"] . 'cm x '. $val["width"] .'cm x '. $val["height"] .'cm <br>';
	}
	/* Sender Company */
	if(isset($BookingDatashow->sender_company_name) && !empty($BookingDatashow->sender_company_name)){
		$Sender_Co .='<tr>
			<td valign="top">'. ucwords(strtolower($BookingDetailsDataVal["sender_company_name"])).'</td>
		</tr>';
	}
	/*	Certyfication paragraph - Person or Company */
	if(isset($BookingDatashow->sender_company_name) && !empty($BookingDatashow->sender_company_name)){
		$Cert .='<tr>
			<td valign="top">We,&nbsp;<span class="my-red">'. ucwords(strtolower($BookingDetailsDataVal["sender_company_name"])).'</span>&nbsp;certify the particulars and quantity of the the goods specified in this documentther the goods which aresubmitted for the clearance for export out of Australia.</td>
		</tr>';
	} else {
		$Cert .='<tr>
			<td valign="top">I,&nbsp;<span class="my-red">'.ucwords(strtolower($BookingDetailsDataVal["sender_first_name"])).'&nbsp;'.ucwords(strtolower($BookingDetailsDataVal["sender_surname"])).'</span>&nbsp;certify the particulars and quantity of the the goods specified in this documentther the goods which aresubmitted for the clearance for export out of Australia.</td>
		</tr>';
	}
	/* Sender Address 2 */
	if(isset($BookingDatashow->sender_address_2) && !empty($BookingDatashow->sender_address_2)){
		$Sender_Address_2 .='<tr>
			<td valign="top">'. ucwords(strtolower($BookingDetailsDataVal["sender_address_2"])).'</td>
		</tr>';
	}
	/* Sender Address 3 */
	if(isset($BookingDatashow->sender_address_3) && !empty($BookingDatashow->sender_address_3)){
		$Sender_Address_3 .='<tr>
			<td valign="top">'. ucwords(strtolower($BookingDetailsDataVal["sender_address_3"])).'</td>
		</tr>';
	}
	/* Receiver Company */
	if(isset($BookingDatashow->reciever_company_name) && !empty($BookingDatashow->reciever_company_name)){
		$Receiver_Co .='<tr>
			<td valign="top">'. ucwords(strtolower($BookingDetailsDataVal["reciever_company_name"])).'</td>
		</tr>';
	}
	/* Receiver Address 2 */
	if(isset($BookingDatashow->reciever_address_2) && !empty($BookingDatashow->reciever_address_2)){
		$Receiver_Address_2 .='<tr>
			<td valign="top">'. ucwords(strtolower($BookingDetailsDataVal["reciever_address_2"])).'</td>
		</tr>';
	}
	/* Receiver Address 3 */
	if(isset($BookingDatashow->reciever_address_3) && !empty($BookingDatashow->reciever_address_3)){
		$Receiver_Address_3 .='<tr>
			<td valign="top">'. ucwords(strtolower($BookingDetailsDataVal["reciever_address_3"])).'</td>
		</tr>';
	}
	/* Receiver State/Postcode */
	if(isset($BookingDatashow->reciever_state) && !empty($BookingDatashow->reciever_state)){
		$Receiver_State_Postcode .='<tr>
			<td valign="top">'. $BookingDetailsDataVal["reciever_state"].'&nbsp;'.$BookingDetailsDataVal["reciever_postcode"].'</td>
		</tr>';
	} else {
		$Receiver_State_Postcode .='<tr>
			<td valign="top">'.$BookingDetailsDataVal["reciever_postcode"].'</td>
		</tr>';
	}
	/* Export Reason */
	switch (valid_output($BookingDatashow->export_reason)) {
		case 1:
			$Receiver_State_Postcode = EXPORT_REASON_1;
		 	break;
		case 2:
			$Receiver_State_Postcode = EXPORT_REASON_2;
			break;
		case 3:
			$Receiver_State_Postcode = EXPORT_REASON_3;
			break;
		case 4:
			$Receiver_State_Postcode = EXPORT_REASON_4;
			break;
		case 5:
			$Receiver_State_Postcode = EXPORT_REASON_5;
			break;
		case 6:
			$Receiver_State_Postcode = EXPORT_REASON_6;
			break;
		case 7:
			$Receiver_State_Postcode = EXPORT_REASON_7;
			break;
			case 8:
			$Receiver_State_Postcode = EXPORT_REASON_8;
			break;
	}
$html_commercial_invoice='<style type="text/css">
#outlook a {padding:0;}body{width:100% !important; -webkit-text-size-adjust:100%; -ms-text-size-adjust:100%; margin:0; padding:0;}.ExternalClass {width:100%;}
.ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div {line-height: 100%;}#backgroundTable {margin:0; padding:0; width:100% !important; line-height: 100% !important; color:#333; font-size: 13px; font-family:"Helvetica Neue",Helvetica,Arial,sans-serif;}img {outline:none; text-decoration:none; -ms-interpolation-mode: bicubic;}
a img {border:none;}
.image_fix {display:block;}p {margin: 1em 0;}
h1, h2, h3, h4, h5, h6 {font-family: "Open Sans", sans-serif; font-weight: normal;}h1 a, h2 a, h3 a, h4 a, h5 a, h6 a {color: blue !important;}
h1 a:active, h2 a:active,  h3 a:active, h4 a:active, h5 a:active, h6 a:active {
  color: red !important;
 }h1 a:visited, h2 a:visited,  h3 a:visited, h4 a:visited, h5 a:visited, h6 a:visited {
  color: purple !important;
}table td {border-collapse: collapse; width:100%}
table { border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt; width:100%}
a {color: #72c02c; text-decoration:none;}

  a[href^="tel"], a[href^="sms"] {
        text-decoration: none;
        color: blue; /* or whatever your want */
        pointer-events: none;
        cursor: default;
      }

  .mobile_link a[href^="tel"], .mobile_link a[href^="sms"] {
        text-decoration: default;
        color: orange !important;
        pointer-events: auto;
        cursor: default;
      }
.bold {
  font-weight: bold;
}
.my-red {
  color: #F00;
}
.my-font-16 {
  font-size: 16px;
}
.w_100 {
  width:100%;
}
.w_90 {
  width:90%;
}
.w_80 {
  width:80%;
}
.w_70 {
  width:70%;
}
.w_65 {
  width:65%;
}
.w_60 {
  width:60%;
}
.w_55 {
  width:55%;
}
.w_50 {
  width:50%;
}
.w_45 {
  width:45%;
}
.w_40 {
  width:40%;
}
.w_35 {
  width:35%;
}
.w_33 {
  width:33.3%;
}
.w_30 {
  width:30%;
}
.w_25 {
  width:25%;
}
.w_20 {
  width:20%;
}
.margin_bottom_60 {
	margin-bottom: 60px;
}
.margin_bottom_40 {
	margin-bottom: 40px;
}
.margin_bottom_30 {
  margin-bottom: 30px;
}
.margin_bottom_20 {
  margin-bottom: 20px;
}
.padding_bottom_20 {
  padding-bottom: 20px;
}
.padding_bottom_10 {
  padding-bottom: 10px;
}
ul {
  list-style-type: none;
  padding-left:0;
}
ul li {
  padding-bottom:4px;
}
h2 {
  font-size: 31.5px;
  margin-bottom: 15px;
  text-align:center;
  }
.headline h3, .headline h4 {
  border-bottom: 2px solid #72c02c;
}
.bordered {
  border: 2px solid #72c02c;
}
.sign {
  border-bottom: 2px dotted #000;
}
.no_border-b {
  border-bottom:none !important;
  margin-bottom: 0;
}
.bg-light {
  padding:10px 15px;
  border-radius:3px;
  margin-bottom:10px;
  background:#fcfcfc;
  border:solid 1px #fcfcfc;
  }
.bg-light:hover {
  border:solid 1px #e5e5e5;
  }
blockquote {
  padding: 0 0 0 15px;
  margin: 0 0 20px;
  border-left: 5px solid #eee;
  font-size: 17.5px;
  font-weight: 300;
  line-height: 1.25;
  }
blockquote:hover {
  border-left: 5px solid #72c02c;
  }
blockquote p {
  color: #555;
  font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;
  }
.standard_font {
  padding: 0 0 0 15px;
  margin: 0 0 20px;
  font-size: 17.5px;
  font-weight: 300;
  line-height: 1.25;
  color: #555;
  font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;
}
.justy {
  text-align: justify;
  }
.my_green {
  color: #72c02c !important;
  }
.muted {
  color: #999;
  }
.text-right {
  text-align:right;
  }
.pull-right {
  text-align:right;
  float:right;
  }
.border_bottom {
  background: transparent;
  color: transparent;
  border-left: none;
  border-right: none;
  border-top: none;
  border-bottom: 2px dashed #72c02c;
  }
.footer {
  margin-top: 40px;
  padding: 20px 10px;
  background: #585f69;
  color: #dadada;
  }
.footer h4, .footer h3 {
  color: #e4e4e4 !important;
  background: none;
  text-shadow: none;
  font-weight:lighter !important;
  }
.copyright {
  font-size: 12px;
  padding: 5px 10px;
  background: #3e4753;
  border-top: solid 1px #777;
  color: #dadada;
  }
.address {
  display: block;
  margin-bottom: 20px;
  font-style:normal;
  line-height: 20px;
  font-size: 13px;
  }
.social_googleplus {
  background: url(http://prioritycouriers.com.au/assets/img/icons/social/googleplus.png) no-repeat;
  width: 28px;
  height: 28px;
  display: block;
  }
.social_googleplus:hover {
  background-position: 0px -38px;
  }
.receipt {
  font-size:10px;
}
.headline {
  margin: 5px 0 10px 0;
  }
.lead {
  font-size: 16px;
  font-weight: 100;
  line-height: 35px;
  }
.my_bigger_font,
.my_bigger_font td {
  font-size: 10px;
  font-weight: 200;
  line-height: 1;
  }
.pad_main {
  padding: 10px 10px 5px 10px;
}
.pad_side {
  padding: 0 10px 0 10px;
}
.pad_3 td {
  padding: 3px;
}
.pad_fee td,
.pad_address {
  padding: 3px;
}
.fee_dashed {
  border-bottom: 2px dashed #72c02c;
}
.fee_above_dashed {
  padding-top:10px !important;
}
</style>

<table cellpadding="0" cellspacing="0" border="0" id="backgroundTable">
  <tr>
    <td>
      <table cellpadding="0" cellspacing="0" border="0" align="center" class="w_90">
        <tr>
          <td valign="top">
            <table cellpadding="0" cellspacing="1" border="0" align="center">
              <tr>
                <td class="pad_main" valign="top">
                  <table cellpadding="0" cellspacing="0" border="0" align="center" class="headline">
                    <tr>
                      <td class="pad_side" valign="top">
                        <h2 class ="bold">Commercial Invoice</h2>
                      </td>
                    </tr>
                  </table>
                  <table  cellpadding="0" cellspacing="0" border="0" align="center" class="margin_bottom_30">
                    <tr>
                      <td class="w_50" valign="top">
                        <table cellpadding="0" cellspacing="0" border="0" align="center">
                          <tr>
                            <td class="w_20 bold" valign="top">Date</td>
                            <td class="my-red" valign="top">'.date("d-M-Y").'</td>
                          </tr>
                        </table>
                      </td>
                      <td class="w_50" valign="top">
                        <table cellpadding="0" cellspacing="0" border="0" align="center">
                          <tr>
                            <td class="w_30 bold" valign="top">Reference</td>
                            <td class="my-red" valign="top">'.$CCConnote_t.'</td>
                          </tr>
                        </table>
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>
            </table>
          </td>
        </tr>
        <tr>
          <td class="pad_main" valign="top">
            <table class="margin_bottom_30" cellpadding="0" cellspacing="0" border="0" align="center">
              <tr>
                <td class="w_50" valign="top">
                  <table class="pad_3" cellpadding="0" cellspacing="0" border="0" align="center">
                    <tr>
                      <td valign="top" class="my-font-16 bold">Shipper</td>
                    </tr>
                    <tr>
                      <td valign="top">'.ucwords(strtolower($BookingDetailsDataVal["sender_first_name"])).'&nbsp;'.ucwords(strtolower($BookingDetailsDataVal["sender_surname"])).'</td>
                    </tr>
                    	'.$Sender_Co.'
                    <tr>
                      <td valign="top">'. ucwords(strtolower($BookingDetailsDataVal["sender_address_1"])).'</td>
                    </tr>
											'.$Sender_Address_2.'
											'.$Sender_Address_3.'
                    <tr>
                      <td valign="top">'.ucwords(strtolower($BookingDetailsDataVal["sender_suburb"])).'</td>
                    </tr>
                    <tr>
                      <td valign="top">'.strtoupper($BookingDetailsDataVal["sender_state"]).'&nbsp;'.$BookingDetailsDataVal["sender_postcode"].'</td>
                    </tr>
                    <tr>
                      <td valign="top">Australia</td>
                    </tr>
                  </table>
                </td>
                <td class="w_50" valign="top">
                  <table class="pad_3" cellpadding="0" cellspacing="0" border="0" align="center">
                    <tr>
                      <td valign="top" class="my-font-16 bold">Receiver</td>
                    </tr>
                    <tr>
                      <td valign="top">'.ucwords(strtolower($BookingDetailsDataVal["reciever_firstname"])).'&nbsp;'.ucwords(strtolower($BookingDetailsDataVal["reciever_surname"])).'</td>
                    </tr>
										'.$Receiver_Co.'
                    <tr>
                      <td valign="top">'.ucwords(strtolower($BookingDetailsDataVal["reciever_address_1"])).'</td>
                    </tr>
											'.$Receiver_Address_2.'
											'.$Receiver_Address_3.'
                    <tr>
                      <td valign="top">'. ucwords(strtolower($BookingDetailsDataVal["reciever_suburb"])).'</td>
                    </tr>
										'.$Receiver_State_Postcode.'
                    <tr>
                      <td valign="top">'.ucwords(strtolower($interCodedata['countries_name'])).'</td>
                    </tr>
                  </table>
                </td>
              </tr>
            </table>
            <table class="w_100 margin_bottom_30" cellpadding="0" cellspacing="0" border="0" align="center">
              <tr>
                <td valign="top" class="my-font-16 bold">Descriprion of Goods</td>
              </tr>
              <tr>
                <td valign="top" class="my-red padding_bottom_20">'. $BookingDetailsDataVal["description_of_goods"].'</td>
              </tr>
              <tr>
                <td valign="top" class="bold">Reason For Export</td>
              </tr>
              <tr>
                <td valign="top" class="my-red padding_bottom_20">'.$Receiver_State_Postcode.'</td>
              </tr>
              <tr>
                <td valign="top" class="bold">Country Of Origin</td>
              </tr>
              <tr>
                <td valign="top" class="my-red padding_bottom_20">'.valid_output($origin_countries_name).'</td>
              </tr>
              <tr>
                <td valign="top" class="bold">Declared Value of goods</td>
              </tr>
              <tr>
                <td valign="top" class="my-red padding_bottom_20">'. $BookingDetailsDataVal["currency_codes"].'&nbsp;'. $BookingDetailsDataVal["values_of_goods"].'</td>
              </tr>
              <tr>
                <td valign="top" class="bold">Total Weight:</td>
              </tr>
              <tr>
                <td valign="top" class="my-red padding_bottom_20">'. $BookingDetailsDataVal["total_qty"].'&nbsp;@&nbsp;'. $BookingDetailsDataVal["total_weight"].' kg</td>
              </tr>
            </table>
            <table cellpadding="0" cellspacing="0" border="0" align="center" class="margin_bottom_20">
              <tr>
                <td>I decalre that the information provided on this commercial invoice is true and correct to the best of my knowledge.</td>
              </tr>
            </table>
            <table cellpadding="0" cellspacing="0" border="0" align="center" class="margin_bottom_20">
							'.$Cert.'
            </table>
            <table cellpadding="0" cellspacing="0" border="0" align="center" class="margin_bottom_60">
              <tr>
                <td class="bold">Signed</td>
              </tr>
            </table>
            <table cellpadding="0" cellspacing="0" border="0" align="center" class="margin_bottom_20">
							<tr>
								<td>
									<table cellpadding="0" cellspacing="0" border="0" align="center">
										<tr>
											<td class="w_50 sign"></td>
											<td class="w_40"></td>
										</tr>
									</table>
								</td>
							</tr>
            </table>
						<table cellpadding="0" cellspacing="0" border="0" align="center" class="margin_bottom_60">
							<tr>
								<td class="my-font-16 bold">Designation of Authorised Signatory</td>
							</tr>
						</table>
						<table cellpadding="0" cellspacing="0" border="0" align="center" class="margin_bottom_20">
							<tr>
								<td>
									<table cellpadding="0" cellspacing="0" border="0" align="center">
										<tr>
											<td class="w_50 sign"></td>
											<td class="w_40"></td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>';

		//Printing Commercial Invoice
	ob_clean();
	$path_to_commecrial_invoice_pdf = DIR_WS_ONLINEPDF."commercial_invoice/Commercial_Invoice_".$bookingid.".pdf";
	//use Dompdf;
	if (file_exists($path_to_commecrial_invoice_pdf)) {
		unlink($path_to_commecrial_invoice_pdf);
	}

	try {

		$dompdf = new DOMPDF();
		$dompdf->load_html($html_commercial_invoice);
		$dompdf->render();
		file_put_contents($path_to_commecrial_invoice_pdf, $dompdf->output());
	}catch (DOMPDF_Exception $e){
		return 'Error during PDF creation: ' . $e->getMessage();
	}

}


	$service_name = ucwords(strtolower($service_name));
	/* Smita commented 1 Dec 2020 */
	if($commercial_invoice == 'Yes')
	{
		$path_to_dir = DIR_WS_ONLINEPDF.'commercial_invoice/Commercial_Invoice_'.$bookingid.'.pdf';
		$path_to_url = "http://ws01.ffdx.net/v4/printdoc/docCommercialInvoice_pcs.aspx?accessid=PRIORITY_ID&shipno=$CCConnote&format=pdf";

		file_put_contents($path_to_dir, file_get_contents($path_to_url));
	}

	if($service_name_code=='DP')
	{
		/*Startrack Labels URL */
		$path_to_url = "https://ws01.ffdx.net/v4/printdoc/3rdPartyConnector.aspx?qr=1&accessid=6FC39A3131DD95C2CB2DF21A9784FE3B&shipno=$CCConnote&format=pdf";
		$path_to_dir = DIR_WS_ONLINEPDF."StarTrack/connoate/TrackingLabel"."_".$bookingid.".pdf";
		file_put_contents($path_to_dir, file_get_contents($path_to_url));
		
		/*Prioritylogistics Consignment Note label */
		//$path_to_url = "https://ws01.ffdx.net/v4/printdoc/3rdPartyConnector.aspx?accessid=PRIORITY_ID&shipno=$CCConnote";
		$path_to_consignment_url = "https://ws01.ffdx.net/v4/printdoc/docConnoteStyle1.aspx?qr=1&accessid=6FC39A3131DD95C2CB2DF21A9784FE3B&shipno=$CCConnote&format=pdf";
		$path_to_consignment_dir = DIR_WS_ONLINEPDF."StarTrack/consignment/ConsignmentNote"."_".$bookingid.".pdf";
		file_put_contents($path_to_consignment_dir, file_get_contents($path_to_consignment_url));
		
	}
	if($service_name_code=='DE')
	{
		$path_to_dir = DIR_WS_ONLINEPDF."StarTrack/connoate/TrackingLabel"."_".$bookingid.".pdf";

		//$path_to_url = "https://ws01.ffdx.net/v4/printdoc/3rdPartyConnector.aspx?accessid=PRIORITY_ID&shipno=$CCConnote";
		$path_to_url = "https://ws01.ffdx.net/v4/printdoc/3rdPartyConnector.aspx?qr=1&accessid=6FC39A3131DD95C2CB2DF21A9784FE3B&shipno=$CCConnote&format=pdf";
		file_put_contents($path_to_dir, file_get_contents($path_to_url));

		$path_to_consignment_url = "https://ws01.ffdx.net/v4/printdoc/docConnoteStyle1.aspx?qr=1&accessid=6FC39A3131DD95C2CB2DF21A9784FE3B&shipno=$CCConnote&format=pdf";
		$path_to_consignment_dir = DIR_WS_ONLINEPDF."StarTrack/consignment/ConsignmentNote"."_".$bookingid.".pdf";
		file_put_contents($path_to_consignment_dir, file_get_contents($path_to_consignment_url));
		
	}
	
	if($service_name_code != 'DE' && $service_name_code != 'DP' && $service_name_code != 'ED' && $service_name_code != 'EN')
	{
		$path_to_dir = DIR_WS_ONLINEPDF."DirectCourier/connoate/TrackingLabel"."_".$bookingid.".pdf";

		$path_to_url = "https://ws01.ffdx.net/v4/printdoc/3rdPartyConnector.aspx?qr=1&accessid=6FC39A3131DD95C2CB2DF21A9784FE3B&shipno=$CCConnote&format=pdf";
		file_put_contents($path_to_dir, file_get_contents($path_to_url));
		$path_to_consignment_url = "https://ws01.ffdx.net/v4/printdoc/docConnoteStyle1.aspx?qr=1&accessid=6FC39A3131DD95C2CB2DF21A9784FE3B&shipno=$CCConnote&format=pdf";
		$path_to_consignment_dir = DIR_WS_ONLINEPDF."DirectCourier/consignment/ConsignmentNote"."_".$bookingid.".pdf";
		file_put_contents($path_to_consignment_dir, file_get_contents($path_to_consignment_url));
	}
	if($service_name_code=='ED' || $service_name_code=='EN')
	{

		$img = DIR_WS_ONLINEPDF."UPS/connoate/TrackingLabel_".$bookingid.".pdf";
		$url = "https://ws01.ffdx.net/v4/printdoc/3rdPartyConnector.aspx?accessid=6FC39A3131DD95C2CB2DF21A9784FE3B&shipno=$CCConnote&format=pdf";
		file_put_contents($img, file_get_contents($url));
		$path_to_consignment_url = "https://ws01.ffdx.net/v4/printdoc/docConnoteStyle1.aspx?qr=1&accessid=6FC39A3131DD95C2CB2DF21A9784FE3B&shipno=$CCConnote&format=pdf";
		$path_to_consignment_dir = DIR_WS_ONLINEPDF."UPS/consignment/ConsignmentNote"."_".$bookingid.".pdf";
		file_put_contents($path_to_consignment_dir, file_get_contents($path_to_consignment_url));

	}
	/* Smita commented 1 Dec 2020 */
		//send mail code after the successful confirmation of payment

		Booking_Confirmation($bookingid,$_POST['cardnumber'],$service_name_code,$autoId);
		Admin_Booking_Confirmation($bookingid,$_POST['cardnumber'],$service_name_code,$autoId);
		//exit();
		/*Below Code is commented by Smita 2 Dec */
		
		header('Location:'.FILE_EWAY_PAYMENT."?booking_id=".$bookingid);
		exit();
	}
}
//}
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



require_once( DIR_WS_SITE_CURRENT_TEMPLATE . FILE_MAIN_INTERFACE);
/* This include once is used for the html integration */

?>
