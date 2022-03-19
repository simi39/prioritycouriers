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
require_once("lib/csrf.php");
require_once(DIR_WS_LIB ."functions.php");
require_once(DIR_WS_CURRENT_LANGUAGE . "addressbook.php");
require_once(DIR_WS_CURRENT_LANGUAGE . "addresses.php");
require_once(DIR_WS_MODEL."PublicHolidayMaster.php");
require_once(DIR_WS_MODEL."PostCodeMaster.php");
require_once(DIR_WS_MODEL ."CountryMaster.php");
require_once(DIR_WS_MODEL ."ClientAddressMaster.php");
require_once(DIR_WS_MODEL . "UserMaster.php");
require_once(DIR_WS_MODEL . "ServiceMaster.php");
require_once(DIR_WS_MODEL . "CountryMaster.php");


$error ='';
$arr_css_plugin_include[] = 'glyphicons_new/css/glyphicons.css';

$arr_css_plugin_include[] = 'autocomplete/css/jquery-ui.css';
$arr_css_plugin_include[] = 'waitMe/css/waitMe.min.css';
$arr_javascript_include[] = 'internal/ajex.js';
$arr_javascript_include[] = 'internal/ajax-dynamic-list.js';
$arr_javascript_below_include[] = 'internal/addresses.php';
$arr_javascript_plugin_include[] = 'autocomplete/js/jquery-ui.js';
$arr_javascript_plugin_include[] = 'waitMe/js/waitMe.min.js';
$PostCodeMasterObj = PostCodeMaster::create();
$PostCodeDataObj = new PostCodeData();

//$InternationalZoneMasterObj= InternationalZonesMaster::create();
//$InternationalZoneData = new InternationalZonesData();

$CountryMasterObj = CountryMaster::create();
$CountryData = new CountryData(); 

$publicholidayMasterObj = PublicHolidayMaster::create();
$publicholidayDataObj= new PublicHolidayData();

$objClientAddressMaster = ClientAddressMaster::Create();
$objClientAddressData=new ClientAddressData();

$UserMasterObj    = UserMaster::Create();
$UserData         = new UserData();
/*****************Help Manager*******************/
$objHelpManagerMaster = HelpManagerMaster::create();
$objHelpManagerData = new HelpManagerData();

$ObjServiceMaster	= ServiceMaster::Create();
$ServiceData		= new ServiceData();
$objHelpManagerData = $objHelpManagerMaster->getHelpManager("*");

/*csrf validation*/
$csrf = new csrf();
$csrf->action = "addresses";
if($_POST['finalsubmit']=='')
{
	$ptoken = $csrf->csrfkey();
}

/*
echo "<pre>";
print_r($_SESSION);
echo "</pre>";*/
/*csrf validation*/

$error = array();
$error_new = '';
if(isset($_POST['selected_flag']) && $_POST['selected_flag']!="")
{
	$error['selected_flag'] = specialcharaChk(valid_input($_POST['selected_flag']));
}
if(isset($_GET['step']) && $_GET['step']!="")
{
	$error['step'] = checkStr($_GET['step']);
}
if(isset($_GET['type']) && $_GET['type']!="")
{
	$error['type'] = checkStr($_GET['type']);
}
if(isset($_GET['pkpVal']) && $_GET['pkpVal']!="")
{
	$error['pkpVal'] = isNumeric(valid_input($_GET['pkpVal']),ERROR_ENTER_NUMERIC_VALUE);
}
if(isset($_GET['delVal']) && $_GET['delVal']!="")
{
	$error['delVal'] = isNumeric(valid_input($_GET['delVal']),ERROR_ENTER_NUMERIC_VALUE);
}
if(isset($_GET["dt"]) && $_GET['dt']!="")
{
	$error['dt'] = checkStr($_GET['dt']);
}
if(isset($_GET["add_id"]) && $_GET['add_id']!="")
{
	$error['add_id'] = isNumeric(valid_input($_GET['add_id']),ERROR_ENTER_NUMERIC_VALUE);
}
if(isset($_GET['error']) && $_GET['error']!="")
{ 
	$error['error'] = specialcharaChk($_GET['error']);
}
if(isset($_GET['fromBooking']) && $_GET['fromBooking']!="")
{ 
	$error['fromBooking'] = isNumeric(valid_input($_GET['fromBooking']),ERROR_ENTER_NUMERIC_VALUE);
}
if(isset($_POST['temp_value']) && $_POST['temp_value']!="")
{
	$error['temp_value'] = isNumeric(valid_input($_POST['temp_value']),ERROR_ENTER_NUMERIC_VALUE);
}
if(isset($_POST['confirmPkpAddYes']) && $_POST['confirmPkpAddYes']!="")
{
	$error['confirmPkpAddYes'] = isNumeric(valid_input($_POST['confirmPkpAddYes']),ERROR_ENTER_NUMERIC_VALUE);
}
if(isset($_POST['confirmDelAddYes']) && $_POST['confirmDelAddYes']!="")
{
	$error['confirmDelAddYes'] = isNumeric(valid_input($_POST['confirmDelAddYes']),ERROR_ENTER_NUMERIC_VALUE);
}
if(isset($_POST['pkp_address_from_book']) && $_POST['pkp_address_from_book']!="")
{
	$error['pkp_address_from_book'] = isNumeric(valid_input($_POST['pkp_address_from_book']),ERROR_ENTER_NUMERIC_VALUE);
}
if(isset($_POST['dlv_address_from_book']) && $_POST['dlv_address_from_book']!="")
{
	$error['dlv_address_from_book'] = isNumeric(valid_input($_POST['dlv_address_from_book']),ERROR_ENTER_NUMERIC_VALUE);
}
if(isset($_POST['user_id']) && $_POST['user_id']!="")
{
	$error['user_id'] = isNumeric(valid_input($_POST['user_id']),ERROR_ENTER_NUMERIC_VALUE);
}
if(isset($_POST['hidden_contact_flag_sender']) && $_POST['hidden_contact_flag_sender']!="")
{
	$error['hidden_contact_flag_sender'] = specialcharaChk(valid_input($_POST['hidden_contact_flag_sender']));
}
if(isset($_POST['pickup_readonly']) && $_POST['pickup_readonly']!="")
{
	$error['pickup_readonly'] = isNumeric(valid_input($_POST['pickup_readonly']),ERROR_ENTER_NUMERIC_VALUE);
}
if(isset($_POST['delivery_readonly']) && $_POST['delivery_readonly']!="")
{
	$error['delivery_readonly'] = isNumeric(valid_input($_POST['delivery_readonly']),ERROR_ENTER_NUMERIC_VALUE);
}

if(isset($_POST['drc']) && $_POST['drc']!="")
{
	$error['drc'] = isNumeric(valid_input($_POST['drc']),ERROR_ENTER_NUMERIC_VALUE);
}
if(isset($_POST['service_name']) && $_POST['service_name']!="")
{
	$error['service_name'] = specialcharaChk(valid_input($_POST['service_name']));
}


foreach ($error as $key => $Value) {
	if ($Value != '') {
		logOut();
	}
}
/*
echo "<pre>";
print_R($_POST);
echo "</pre>";
exit();
*/
if(isset($_GET['step'])){
	$_SESSION['address_return'] = 1;
}

foreach ($objHelpManagerData as $datarow) {
	$var=valid_output($datarow->help_code);
	$$var =	valid_output($datarow->help_description);
	
}
/*******************help manager end ******************/

$BookingDetailsDataObj = $__Session->GetValue("booking_details");
if($__Session->GetValue("fromBooking") == 1){
	$__Session->ClearValue("fromBooking");
	$__Session->Store();
}
$pickupid = $BookingDetailsDataObj['pickupid'];
$deliveryid = $BookingDetailsDataObj['deliveryid'];
$servicepagename = $BookingDetailsDataObj['servicepagename'];
$flag = $BookingDetailsDataObj['flag'];
$international_rate = $BookingDetailsDataObj['international_rate'];
$additional_cost = $BookingDetailsDataObj['additional_cost'];
if(isset($BookingDetailsDataObj) && ($BookingDetailsDataObj!=''))
{
	$BookingDatashow = new stdClass;
	foreach ($BookingDetailsDataObj as $key=>$val) {
		$BookingDatashow->{$key}=valid_output($val);
		
	}
}

$BookingItemDetailsData = $__Session->GetValue("booking_details_items");
/*echo "<pre>";
print_r($BookingDetailsDataObj);
echo "</pre>";
echo "<pre>";
print_r($BookingItemDetailsData);
echo "</pre>";*/
/*
echo "<pre>";
print_r($_SESSION);
echo "</pre>";*/
/* This session is for service rates and service name */
$ServiceDetailArr = $__Session->GetValue("temp_service_details");
if($ServiceDetailArr){
	foreach ($ServiceDetailArr as $akey => $aval) {
		$$akey = valid_output($aval);
	}
}
/* This session is for service rates and service name */

$publicholidaydate=$publicholidayMasterObj->getPublicHoliday(null,null,null);
if($publicholidaydate=="")
{
	$publicholidaydate=0;
}
$session_data = $__Session->GetValue("_sess_login_userdetails");
$userid = (int)$session_data['user_id'];

/* this is to check session address */
$objClientPkpAddressDataArray = $__Session->GetValue("client_address_pickup");
	
if(is_array($objClientPkpAddressDataArray)) {

	$objClientPkpAddressData =  new ClientAddressData();

	foreach ($objClientPkpAddressDataArray as $key=>$val) {
		
		if($key == 'firstname')
		{
			$senderfirstname = $val;
		}
		if($key == 'surname')
		{
			$senderlastname = $val;
		}
		if($key == 'address1')
		{
			$address_1 = $val;
		}
		if($key == 'address2')
		{
			$address_2 = $val;
		}
		if($key == 'address3')
		{
			$address_3 = $val;
		}
		if($key == 'suburb')
		{
			$suburb = $val;
		}
		if($key == 'state')
		{
			$state = $val;
		}
		if($key == 'postcode')
		{
			$postcode = $val;
		}
		
	}
	

	$seaSessionPickAddArr = array();
	$seaSessionPickAddArr[] = array('Search_On'    => 'userid',
		                      'Search_Value' => $userid,
		                      'Type'         => 'int',
		                      'Equation'     => '=',
		                      'CondType'     => 'and',
		                      'Prefix'       => '',
		                      'Postfix'      => ''); 
	$seaSessionPickAddArr[] = array('Search_On'    => 'firstname',
						  'Search_Value' => $senderfirstname,
						  'Type'         => 'string',
						  'Equation'     => '=',
						  'CondType'     => 'and',
						  'Prefix'       => '',
						  'Postfix'      => ''); 
	$seaSessionPickAddArr[] = array('Search_On'    => 'surname',
						  'Search_Value' => $senderlastname,
						  'Type'         => 'string',
						  'Equation'     => '=',
						  'CondType'     => 'and',
						  'Prefix'       => '',
						  'Postfix'      => '');
    
	$seaSessionPickAddArr[]	=	array('Search_On'    => 'suburb',
							'Search_Value' => $suburb,
							'Type'         => 'string',
							'Equation'     => '=',
							'CondType'     => 'AND',
							'Prefix'       => '',
							'Postfix'      => '');
	$seaSessionPickAddArr[]	=	array('Search_On'    => 'state',
							'Search_Value' => $state,
							'Type'         => 'string',
							'Equation'     => '=',
							'CondType'     => 'AND',
							'Prefix'       => '',
							'Postfix'      => '');
	$seaSessionPickAddArr[]	=	array('Search_On'    => 'postcode',
							'Search_Value' => $postcode,
							'Type'         => 'string',
							'Equation'     => '=',
							'CondType'     => 'AND',
							'Prefix'       => '',
							'Postfix'      => '');
						  
	$pickSessionaddress = $objClientAddressMaster->getClientAddress('null',$seaSessionPickAddArr);
	$senderSessionaddress = $pickSessionaddress[0];
	$sender_client_address_id = $senderSessionaddress['addressId'];
	if (is_array($pickSessionaddress[0]) && count($pickSessionaddress[0]) > 0) {
		$pickSessionaddress = count($pickSessionaddress[0]);
	}
	
	
	
	/* This is to check from user_master this address is present or not */
	$seaUserArr = array();
	$seaUserArr[]	=	array('Search_On'    => 'userid',
									  'Search_Value' => $userid,
									  'Type'         => 'int',
									  'Equation'     => '=',
									  'CondType'     => 'AND',
									  'Prefix'       => '',
									  'Postfix'      => '');
	$seaUserArr[]	=	array('Search_On'    => 'firstname',
						  'Search_Value' => $senderfirstname,
						  'Type'         => 'string',
						  'Equation'     => '=',
						  'CondType'     => 'AND',
						  'Prefix'       => '',
						  'Postfix'      => '');
	$seaUserArr[]	=	array('Search_On'    => 'lastname',
						  'Search_Value' => $senderlastname,
						  'Type'         => 'string',
						  'Equation'     => '=',
						  'CondType'     => 'AND',
						  'Prefix'       => '',
						  'Postfix'      => '');

	$seaUserArr[]	=	array('Search_On'    => 'suburb',
							'Search_Value' => $suburb,
							'Type'         => 'string',
							'Equation'     => '=',
							'CondType'     => 'AND',
							'Prefix'       => '',
							'Postfix'      => '');
	$seaUserArr[]	=	array('Search_On'    => 'state',
							'Search_Value' => $state,
							'Type'         => 'string',
							'Equation'     => '=',
							'CondType'     => 'AND',
							'Prefix'       => '',
							'Postfix'      => '');
	$seaUserArr[]	=	array('Search_On'    => 'postcode',
							'Search_Value' => $postcode,
							'Type'         => 'string',
							'Equation'     => '=',
							'CondType'     => 'AND',
							'Prefix'       => '',
							'Postfix'      => '');
	$Users = $UserMasterObj->getUser(null, $seaUserArr);
	$Users = $Users[0];
	if (is_array($Users) && count($Users) > 0) {
		$profileAddress = count($Users);
	}
	$_SESSION['chk_pk_address']=0;
	if(empty($pickSessionaddress) && empty($profileAddress))
	{
		$_SESSION['chk_pk_address']=1;
	}
	
}

/* this is to check session address */

/* this is to check session address */
$objClientDelAddressDataArray = $__Session->GetValue("client_address_dilivery");		
			
if(is_array($objClientDelAddressDataArray)) {

	$objClientDelAddressData =  new ClientAddressData();

	foreach ($objClientDelAddressDataArray as $key=>$val) {
		
		if($key == 'firstname')
		{
			$receiverfirstname = $val;
		}
		if($key == 'surname')
		{
			$receiverlastname = $val;
		}
		if($key == 'address1')
		{
			$address_1 = $val;
		}
		if($key == 'address2')
		{
			$address_2 = $val;
		}
		if($key == 'address3')
		{
			$address_3 = $val;
		}
		if($key == 'suburb')
		{
			$suburb = $val;
		}
		if($key == 'state')
		{
			$state = $val;
		}
		if($key == 'postcode')
		{
			$postcode = $val;
		}
		
	}
	
	$seaSessionDelAddArr = array();
	$seaSessionDelAddArr[] = array('Search_On'    => 'userid',
		                      'Search_Value' => $userid,
		                      'Type'         => 'int',
		                      'Equation'     => '=',
		                      'CondType'     => 'and',
		                      'Prefix'       => '',
		                      'Postfix'      => ''); 
	$seaSessionDelAddArr[] = array('Search_On'    => 'firstname',
						  'Search_Value' => $receiverfirstname,
						  'Type'         => 'string',
						  'Equation'     => '=',
						  'CondType'     => 'and',
						  'Prefix'       => '',
						  'Postfix'      => ''); 
	$seaSessionDelAddArr[] = array('Search_On'    => 'surname',
						  'Search_Value' => $receiverlastname,
						  'Type'         => 'string',
						  'Equation'     => '=',
						  'CondType'     => 'and',
						  'Prefix'       => '',
						  'Postfix'      => '');
    
	$seaSessionDelAddArr[]	=	array('Search_On'    => 'suburb',
							'Search_Value' => $suburb,
							'Type'         => 'string',
							'Equation'     => '=',
							'CondType'     => 'AND',
							'Prefix'       => '',
							'Postfix'      => '');
	$seaSessionDelAddArr[]	=	array('Search_On'    => 'state',
							'Search_Value' => $state,
							'Type'         => 'string',
							'Equation'     => '=',
							'CondType'     => 'AND',
							'Prefix'       => '',
							'Postfix'      => '');
	$seaSessionDelAddArr[]	=	array('Search_On'    => 'postcode',
							'Search_Value' => $postcode,
							'Type'         => 'string',
							'Equation'     => '=',
							'CondType'     => 'AND',
							'Prefix'       => '',
							'Postfix'      => '');
						  
	$delSessionaddress = $objClientAddressMaster->getClientAddress('null',$seaSessionDelAddArr);
	if (is_array($delSessionaddress[0]) && count($delSessionaddress[0]) > 0) {
		$delSessionaddress = count($delSessionaddress[0]);
	}
	/* This is to check from user_master this address is present or not */
	$seaUserArr = array();
	$seaUserArr[]	=	array('Search_On'    => 'userid',
									  'Search_Value' => $userid,
									  'Type'         => 'int',
									  'Equation'     => '=',
									  'CondType'     => 'AND',
									  'Prefix'       => '',
									  'Postfix'      => '');
	$seaUserArr[]	=	array('Search_On'    => 'firstname',
						  'Search_Value' => $receiverfirstname,
						  'Type'         => 'string',
						  'Equation'     => '=',
						  'CondType'     => 'AND',
						  'Prefix'       => '',
						  'Postfix'      => '');
	$seaUserArr[]	=	array('Search_On'    => 'lastname',
						  'Search_Value' => $receiverlastname,
						  'Type'         => 'string',
						  'Equation'     => '=',
						  'CondType'     => 'AND',
						  'Prefix'       => '',
						  'Postfix'      => '');

	$seaUserArr[]	=	array('Search_On'    => 'suburb',
							'Search_Value' => $suburb,
							'Type'         => 'string',
							'Equation'     => '=',
							'CondType'     => 'AND',
							'Prefix'       => '',
							'Postfix'      => '');
	$seaUserArr[]	=	array('Search_On'    => 'state',
							'Search_Value' => $state,
							'Type'         => 'string',
							'Equation'     => '=',
							'CondType'     => 'AND',
							'Prefix'       => '',
							'Postfix'      => '');
	$seaUserArr[]	=	array('Search_On'    => 'postcode',
							'Search_Value' => $postcode,
							'Type'         => 'string',
							'Equation'     => '=',
							'CondType'     => 'AND',
							'Prefix'       => '',
							'Postfix'      => '');
	$Users = $UserMasterObj->getUser(null, $seaUserArr);
	$Users = $Users[0];
	if(is_array($Users) && count($Users) > 0) {
		$profileAddress = count($Users);
	}
	
	
	$_SESSION['chk_del_address']=0;
	if(empty($delSessionaddress) && empty($profileAddress))
	{
		$_SESSION['chk_del_address']=1;
	}
	
}

/* this is to check session address */


//This variables $addMatchFlag value assigned by shailesh jamanapara Sat Apr 20 11:01:23 IST 2013	83	
/*Sets flag for users address matching 	84  ***/	  
/*$addMatchFlag = 1 for pickup address	    ***/	
/*$addMatchFlag = 2 for delivery address	 **/	
/*$addMatchFlag = 3 for both      address	 **/	
/*$addMatchFlag = 0 for none address matched **/		
	$addMatchFlag = 0;		
	$pickupVal = 0;		
	$delVal = 0;


if(isset($_GET["type"]) && isset($_GET["add_id"])) {
	if($_GET["type"]=="pickup") {
		$Pickupaddressbook="addressbook";
		$pickupRadio=(int)$_GET["add_id"];
		
		$bookadd_co="addressbook";
	} else if($_GET["type"] == "delivery") {
		$Deliveraddressbook="daddressbook";
		$deliverRadio=(int)$_GET["add_id"];
		
		$bookadd_co="daddressbook";
	}
	if($bookadd_co=="addressbook")
	{
		$seaPickAddArr[] = array('Search_On'    => 'userid',
		                      'Search_Value' => $userid,
		                      'Type'         => 'int',
		                      'Equation'     => '=',
		                      'CondType'     => 'and',
		                      'Prefix'       => '',
		                      'Postfix'      => ''); 
		$seaPickAddArr[] = array('Search_On'    => 'addressId',
		                      'Search_Value' => $pickupRadio,
		                      'Type'         => 'int',
		                      'Equation'     => '=',
		                      'CondType'     => 'and',
		                      'Prefix'       => '',
		                      'Postfix'      => ''); 
		$pickaddress = $objClientAddressMaster->getClientAddress('null',$seaPickAddArr);
		$pickaddress=$pickaddress[0];
		foreach ($pickaddress as $key=>$val) {
			$pickaddressArray[$key]=valid_output($val);
		}
		$__Session->SetValue("client_address_pickup",$pickaddressArray);
		$pickaddressId=(int)$pickaddress->addressId;
		
		$pickaddresstitle=valid_output($pickaddress->title);	                      
	} else if($bookadd_co=="daddressbook")
	{
		$seaDeliverAddArr[] = array('Search_On'    => 'userid',
		                      'Search_Value' => $userid,
		                      'Type'         => 'int',
		                      'Equation'     => '=',
		                      'CondType'     => 'and',
		                      'Prefix'       => '',
		                      'Postfix'      => ''); 
		$seaDeliverAddArr[] = array('Search_On'    => 'addressId',
		                      'Search_Value' => $deliverRadio,
		                      'Type'         => 'int',
		                      'Equation'     => '=',
		                      'CondType'     => 'and',
		                      'Prefix'       => '',
		                      'Postfix'      => ''); 
		$deliaddress = $objClientAddressMaster->getClientAddress('null',$seaDeliverAddArr);
		$deliaddress=$deliaddress[0];
		
		
		foreach ($deliaddress as $key=>$val) {
			$deliaddressArray[$key]=valid_output($val);
		}
		$__Session->SetValue("client_address_dilivery",$deliaddressArray);
		$DeliveraddressId=(int)$deliaddress->addressId;
		$Delivertitle=valid_output($deliaddress->title);
	}
	//This variable declared by shailesh jamanapara on Date Tue May 14 19:39:30 IST 2013  	
	if(isset($_GET['pkpVal'])){
			$pickupVal = $_GET['pkpVal'];
		}
		if(isset($_GET['delVal'])){
			$delVal = $_GET['delVal'];
		}
}
$__Session->Store();

$pickupseaArr[0] = array('Search_On'    => 'FullName',
                      'Search_Value' => $pickupid,
                      'Type'         => 'string',
                      'Equation'     => '=',
                      'CondType'     => '',
                      'Prefix'       => '',
                      'Postfix'      => ''); 
$PostCodeDataObj = $PostCodeMasterObj->getPostCode('null',false,$pickupseaArr);
$Pickupvalue=$PostCodeDataObj[0];
/*
echo "<pre>";
print_R($Pickupvalue);
echo "</pre>";
exit();*/
$deliverseaArr = array();
$deliverseaArr[] = array('Search_On'    => 'FullName',
                       'Search_Value' => $deliveryid,
                       'Type'         => 'string',
                       'Equation'     => '=',
                       'CondType'     => '',
                       'Prefix'       => '',
                       'Postfix'      => ''); 
$PostCodeDataObj = $PostCodeMasterObj->getPostCode('null',false,$deliverseaArr);
$Delivervalue=$PostCodeDataObj[0];
//echo "country selected:".$deliveryid;
if($flag=="international")
{
	
	$CountryMasterObj = new CountryMaster();
	$CountryMasterObj = $CountryMasterObj->Create();
	$countrySearch = array();
	$countryFieldArr = array("countries_id","area_code","countries_name","state_validation");
	$countrySearch[] = array('Search_On'    => 'countries_id',
						  'Search_Value' => $deliveryid,
						  'Type'         => 'int',
						  'Equation'     => '=',
						  'CondType'     => 'AND',
						  'Prefix'       => '',
						  'Postfix'      => '');
	$allCountry = $CountryMasterObj->getCountry($countryFieldArr,$countrySearch);
	$allCountry = $allCountry[0];
	$int_area_code = $allCountry->area_code;
	$int_m_area_code = $allCountry->area_code;
	$state_validation = $allCountry->state_validation;
	
}
//This below code commented by shailesh jamanapara on Date Tue May 14 19:40:38 IST 2013 
//if(isset($_POST['submit']))

if(isset($_POST['finalsubmit']))
{


	if(isEmpty(valid_input($_POST['ptoken']), true)){
				
		logOut();
	}else{
		
		$csrf->checkcsrf($_POST['ptoken']);
	}
	
    $Svalidation = false;
	
	$err['sender_first_name'] = isEmpty(valid_input($_POST['sender_first_name']),BOOKING_SENDER_FIRSTNAME_REQUIRED)?isEmpty(valid_input($_POST['sender_first_name']),BOOKING_SENDER_FIRSTNAME_REQUIRED):checkName(valid_input($_POST['sender_first_name']));
	
	$err['sender_last_name'] = isEmpty(valid_input($_POST['sender_last_name']),BOOKING_SENDER_LASTNAME_REQUIRED)?isEmpty(valid_input($_POST['sender_last_name']),BOOKING_SENDER_LASTNAME_REQUIRED):checkName(valid_input($_POST['sender_last_name']));
	if($_POST['sender_first_name']!="" && strlen($_POST['sender_first_name'])<2)
	{
		$err['sender_first_name'] = ENTER_CHARACTER;
	}
	if($_POST['sender_last_name']!="" && strlen($_POST['sender_last_name'])<2)
	{
		$err['sender_last_name'] = ENTER_CHARACTER;
	}
	if($_POST['sender_company_name']!='')
	{
		$err['sender_company_name'] = checkStr(valid_input($_POST['sender_company_name']));
	}
	
	$err['sender_address_1'] = isEmpty(($_POST['sender_address_1']),BOOKING_SENDER_ADDRESS1_REQUIRED)?isEmpty($_POST['sender_address_1'],BOOKING_SENDER_ADDRESS1_REQUIRED):chkStreet($_POST['sender_address_1']);
	
	if($_POST['sender_address_2']!='')
	{
		$err['sender_address_2'] = chkStreet($_POST['sender_address_2']);
	}
	if($_POST['sender_address_3']!='')
	{
		$err['sender_address_3'] = chkStreet($_POST['sender_address_3']);
	}
	if(valid_input($_POST['sender_suburb']!=''))
	{
		$err['sender_suburb'] = checkName(valid_input($_POST['sender_suburb']));
	}
	if(valid_input($_POST['sender_state']!=''))
	{
		$err['sender_state'] = chkState(valid_input($_POST['sender_state']));
	}
	if(valid_input($_POST['sender_postcode']!=''))
	{
		$err['sender_postcode'] = isNumeric(valid_input($_POST['sender_postcode']),ERROR_ENTER_NUMERIC_VALUE);
	}
	//$err['sender_email']        = isEmpty(valid_input($_POST['sender_email']),BOOKING_SENDER_EMAIL_REQUIRED)?isEmpty(valid_input($_POST['sender_email']),BOOKING_SENDER_EMAIL_REQUIRED):checkEmailPattern(valid_input($_POST['sender_email']), BOOKING_EMAIL_VALID);
	if(valid_input($_POST['sender_email']!=''))
	{
		$err['sender_email'] = checkEmailPattern(valid_input($_POST['sender_email']), BOOKING_EMAIL_VALID);
	}

	$err['sender_area_code']	= isEmpty(valid_input($_POST['sender_area_code']),BOOKING_SENDER_AREACODE_REQUIRED)?isEmpty(valid_input($_POST['sender_area_code']),BOOKING_SENDER_AREACODE_REQUIRED):areaCodePattern(valid_input($_POST['sender_area_code']),BOOKING_SENDER_AREACODE_ERROR,'1');
	$err['sender_contact_no']	= isEmpty(valid_input($_POST['sender_contact_no']),BOOKING_SENDER_CONTACTNO_REQUIRED)?isEmpty(valid_input($_POST['sender_contact_no']),BOOKING_SENDER_CONTACTNO_REQUIRED):areaCodePattern(valid_input($_POST['sender_contact_no']),BOOKING_SENDER_CONTACTNO_ERROR,'0');
	if(valid_input($_POST['sender_mb_area_code'])!="")
	{
		$err['sender_mb_area_code'] = areaCodePattern(valid_input($_POST['sender_mb_area_code']),BOOKING_SENDER_MOBILEAREACODE_ERROR,'1');
	}
	if(valid_input($_POST['sender_mobile_no'])!="")
	{
		$err['sender_mobile_no'] = areaCodePattern(valid_input($_POST['sender_mobile_no']),BOOKING_SENDER_MOBILECONTACT_ERROR,'0');
	}
	if(isset($_POST['sender_client_address_id']) && !empty($_POST['sender_client_address_id']))
	{
		$err['sender_client_address_id'] = isNumeric(valid_input($_POST['sender_client_address_id']),ERROR_ENTER_NUMERIC_VALUE);
	}
	$err['receiver_first_name'] = isEmpty(valid_input($_POST['receiver_first_name']),BOOKING_RECEIVER_FIRSTNAME_REQUIRED)?isEmpty(valid_input($_POST['receiver_first_name']),BOOKING_RECEIVER_FIRSTNAME_REQUIRED):checkName(valid_input($_POST['receiver_first_name']));
	$err['receiver_surname'] = isEmpty(valid_input($_POST['receiver_surname']),BOOKING_RECEIVER_LASTNAME_REQUIRED)?isEmpty(valid_input($_POST['receiver_surname']),BOOKING_RECEIVER_LASTNAME_REQUIRED):checkName(valid_input($_POST['receiver_surname']));
	if($_POST['receiver_first_name']!="" && strlen($_POST['receiver_first_name'])<2)
	{
		$err['receiver_first_name'] = ENTER_CHARACTER;
	}
	if($_POST['receiver_surname']!="" && strlen($_POST['receiver_surname'])<2)
	{
		$err['receiver_surname'] = ENTER_CHARACTER;
	}
	if($_POST['receiver_company_name']!='')
	{
		$err['receiver_company_name'] = checkName(valid_input($_POST['receiver_company_name']));
	}
	$err['receiver_address_1'] = isEmpty(valid_input($_POST['receiver_address_1']),BOOKING_RECEIVER_ADDRESS1_REQUIRED)?isEmpty($_POST['reciever_address_1'],BOOKING_RECEIVER_ADDRESS1_REQUIRED):chkStreet($_POST['reciever_address_1']);
	if($_POST['receiver_address_2']!='')
	{
		$err['receiver_address_2'] = chkStreet($_POST['receiver_address_2']);
	}
	if($_POST['reciever_address_3']!='')
	{
		$err['reciever_address_3'] = chkStreet($_POST['reciever_address_3']);
	}
	if(valid_input($_POST['receiver_suburb']!=''))
	{
		$err['receiver_suburb'] = checkName(valid_input($_POST['receiver_suburb']));
	}
	if(valid_input($_POST['receiver_state']!=''))
	{
		$err['receiver_state'] = chkState(valid_input($_POST['receiver_state']));
	}
	if(isset($_POST['selected_flag']) && $_POST['selected_flag']=='international')
	{
		if(isset($state_validation) && $state_validation==1)
		{
			$err['receiver_state'] = isEmpty(valid_input($_POST['receiver_state']),BOOKING_RECEIVER_STATE_REQUIRED)?isEmpty($_POST['receiver_state'],BOOKING_RECEIVER_STATE_REQUIRED):chkState($_POST['receiver_state']);
		}
		$err['receiver_state_code'] = chkCapital(valid_input($_POST['receiver_state_code']));
	}
	if($_POST['selected_flag']=='international' && valid_input($_POST['receiver_postcode']!=''))
	{
		$err['receiver_postcode'] = chkStreet(valid_input($_POST['receiver_postcode']));
	}else{
		$err['receiver_postcode'] = isNumeric(valid_input($_POST['receiver_postcode']),ERROR_ENTER_NUMERIC_VALUE);
	}
	if(isset($_POST['receiver_country']) && $_POST['receiver_country']==UNITED_STATE_NAME)
	{
		if(strlen($_POST['receiver_postcode'])!=5)
		{
			$err['receiver_postcode'] = ERROR_US_POSTCODE;
		}
	}
	if(valid_input($_POST['receiver_email']!=''))
	{
		$err['receiver_email'] = checkEmailPattern(valid_input($_POST['receiver_email']), BOOKING_EMAIL_VALID);
	}
	$err['receiver_area_code']	= isEmpty(valid_input($_POST['receiver_area_code']),BOOKING_SENDER_AREACODE_REQUIRED)?isEmpty(valid_input($_POST['receiver_area_code']),BOOKING_SENDER_AREACODE_REQUIRED):areaCodePattern(valid_input($_POST['receiver_area_code']),BOOKING_SENDER_AREACODE_ERROR,'1');
	$err['receiver_contact_no']	= isEmpty(valid_input($_POST['receiver_contact_no']),BOOKING_SENDER_CONTACTNO_REQUIRED)?isEmpty(valid_input($_POST['receiver_contact_no']),BOOKING_SENDER_CONTACTNO_REQUIRED):areaCodePattern(valid_input($_POST['receiver_contact_no']),BOOKING_SENDER_CONTACTNO_ERROR,'0');
	if(valid_input($_POST['receiver_mb_area_code'])!="")
	{
		$err['receiver_mb_area_code'] = areaCodePattern(valid_input($_POST['receiver_mb_area_code']),BOOKING_SENDER_MOBILEAREACODE_ERROR,'1');
	}
	if(valid_input($_POST['receiver_mobile_no'])!="")
	{
		$err['receiver_mobile_no'] = areaCodePattern(valid_input($_POST['receiver_mobile_no']),BOOKING_SENDER_MOBILECONTACT_ERROR,'0');
	}
	if(isset($_POST['delivery_client_address_id']) && !empty($_POST['delivery_client_address_id']))
	{
		$err['delivery_client_address_id'] = isNumeric(valid_input($_POST['delivery_client_address_id']),ERROR_ENTER_NUMERIC_VALUE);
	}
	if(isset($_POST['pkaddress']) && !empty($_POST['pkaddress']))
	{
		$err['sender_pkaddress'] = isNumeric(valid_input($_POST['pkaddress']),ERROR_ENTER_NUMERIC_VALUE);
	}
	if(isset($_POST['deladdress']) && !empty($_POST['deladdress']))
	{
		$err['delivery_deladdress'] = isNumeric(valid_input($_POST['deladdress']),ERROR_ENTER_NUMERIC_VALUE);
	}
	/*if(isset($err) && !empty($err)){
		echo "<pre>";
		print_r ($err);
		echo "</pre>";
		exit();
	}*/
	/**/
	foreach($err as $key => $Value) {
  		if($Value != '') {
  			$Svalidation=true;
			$ptoken = $csrf->csrfkey();
  		}
	}
	
	if($Svalidation == false)
	{
		$savepkaddress  = $_POST['pkaddress'];
		$savedeladdress = $_POST['deladdress'];
		
		$objClientAddressData1 = new stdClass;

		if($flag=="australia") {
			$objClientAddressData->suburbid=$d_id;
			$objClientAddressData1->country="Australia";
			//This variables $objClientAddressData1->countryid  value assigned  by shailesh jamanapara Tue May 14 19:41:24 IST 2013
			$objClientAddressData1->countryid	= 13;
		} else {
			$objClientAddressData1->suburbid=$deliveryid;
			$objClientAddressData1->country=$_POST['receiver_country'];
			//This variables $objClientAddressData1->countryid  value assigned  by shailesh jamanapara Tue May 14 19:42:08 IST 2013
			$objClientAddressData1->countryid	= $_POST['reciever_countryid'];
		}
		//Its bydefault sender is fro Austrlia so its assigne static value 
		//$objClientAddressData2->countryid=$_POST['sender_countryid'];
		
		$objClientAddressData2 = new stdClass;
		$objClientAddressData2->countryid = 13;					
		$objClientAddressData1->title="Delivery";
		$objClientAddressData1->type="Delivery";
		$objClientAddressData1->firstname=ucwords(strtolower($_POST['receiver_first_name']));
		$objClientAddressData1->surname=ucwords(strtolower($_POST['receiver_surname']));
		$objClientAddressData1->company=ucwords(strtolower($_POST['receiver_company_name']));		
		$objClientAddressData1->address1=ucwords(strtolower($_POST['receiver_address_1']));
		$objClientAddressData1->address2=ucwords(strtolower($_POST['receiver_address_2']));
		$objClientAddressData1->address3=ucwords(strtolower($_POST['receiver_address_3']));	
		$objClientAddressData1->suburb=ucwords(strtolower($_POST['receiver_suburb']));
		if($flag=="australia")
		{
			$objClientAddressData1->state=strtoupper($_POST['receiver_state']);
		}else{
			$objClientAddressData1->state=ucwords(strtolower($_POST['receiver_state']));
		}
		$objClientAddressData1->state_code=strtoupper($_POST['receiver_state_code']);
		$objClientAddressData1->postcode=$_POST['receiver_postcode'];		
		$objClientAddressData1->email=$_POST['receiver_email'];
		$objClientAddressData1->area_code=$_POST['receiver_area_code'];
		$objClientAddressData1->phoneno=$_POST['receiver_contact_no'];
		if($_POST['receiver_mb_area_code'])
		{
			$objClientAddressData1->m_area_code=$_POST['receiver_mb_area_code'];
			$objClientAddressData1->mobileno=$_POST['receiver_mobile_no'];
		}
		$ClientAddressData=(array)$objClientAddressData1;
		/*echo "<pre>";
		print_r($ClientAddressData);
		echo "<*/
		$__Session->SetValue("client_address_dilivery",$ClientAddressData);	

		$objClientAddressData2 = new stdClass;	
		$objClientAddressData2->suburbid=$p_id;
		$objClientAddressData2->title="Pickup";
		$objClientAddressData2->type="Pickup";
		$objClientAddressData2->firstname=ucwords(strtolower($_POST['sender_first_name']));
		$objClientAddressData2->surname=ucwords(strtolower($_POST['sender_last_name']));
		$objClientAddressData2->company=ucwords(strtolower($_POST['sender_company_name']));		
		$objClientAddressData2->address1=ucwords(strtolower($_POST['sender_address_1']));
		$objClientAddressData2->address2=ucwords(strtolower($_POST['sender_address_2']));
		$objClientAddressData2->address3=ucwords(strtolower($_POST['sender_address_3']));	
		$objClientAddressData2->suburb=ucwords(strtolower($_POST['sender_suburb']));
		$objClientAddressData2->state=strtoupper($_POST['sender_state']);
		$objClientAddressData2->postcode=$_POST['sender_postcode'];
		$objClientAddressData2->country="Australia";
		$objClientAddressData2->countryid=13;
		$objClientAddressData2->email=$_POST['sender_email'];
		$objClientAddressData2->phoneno=$_POST['sender_contact_no'];
		if($_POST['sender_mobile_no']){
			$objClientAddressData2->m_area_code=$_POST['sender_mb_area_code'];
			$objClientAddressData2->mobileno=$_POST['sender_mobile_no'];
		}
		$objClientAddressData2->area_code=$_POST['sender_area_code'];
		$ClientAddressData2=(array)$objClientAddressData2;
		$__Session->SetValue("client_address_pickup",$ClientAddressData2);	
		
		
		$BookingDetailsDataObj = new stdClass;
		$BookingDetailsDataObj=$BookingDatashow;
		$BookingDetailsDataObj->booking_id = $bookingid;
		$BookingDetailsDataObj->pageid = "4";
		
		$BookingDetailsDataObj->sender_first_name = ucwords(strtolower($_POST['sender_first_name']));
		$BookingDetailsDataObj->sender_surname = ucwords(strtolower($_POST['sender_last_name']));
		$BookingDetailsDataObj->sender_company_name = ucwords(strtolower($_POST['sender_company_name']));
		$BookingDetailsDataObj->sender_address_1 = ucwords(strtolower($_POST['sender_address_1']));
		$BookingDetailsDataObj->sender_address_2 = ucwords(strtolower($_POST['sender_address_2']));
		$BookingDetailsDataObj->sender_address_3 = ucwords(strtolower($_POST['sender_address_3']));
		$BookingDetailsDataObj->sender_suburb = ucwords(strtolower($_POST['sender_suburb']));
		$BookingDetailsDataObj->sender_state = strtoupper($_POST['sender_state']);
		$BookingDetailsDataObj->sender_postcode = $_POST['sender_postcode'];
		$BookingDetailsDataObj->sender_email = $_POST['sender_email'];
		$BookingDetailsDataObj->sender_contact_no = $_POST['sender_contact_no'];
		$BookingDetailsDataObj->sender_area_code = $_POST['sender_area_code'];
		$BookingDetailsDataObj->sender_mb_area_code = $_POST['sender_mb_area_code'];
		$BookingDetailsDataObj->reciever_mb_area_code = $_POST['reciever_mb_area_code'];
		$BookingDetailsDataObj->sender_mobile_no = $_POST['sender_mobile_no'];
		$BookingDetailsDataObj->reciever_firstname = ucwords(strtolower($_POST['receiver_first_name']));
		$BookingDetailsDataObj->reciever_surname = ucwords(strtolower($_POST['receiver_surname']));
		$BookingDetailsDataObj->reciever_company_name = ucwords(strtolower($_POST['receiver_company_name']));
		$BookingDetailsDataObj->reciever_address_1 = ucwords(strtolower($_POST['receiver_address_1']));
		$BookingDetailsDataObj->reciever_address_2 = ucwords(strtolower($_POST['receiver_address_2']));
		$BookingDetailsDataObj->reciever_address_3 = ucwords(strtolower($_POST['receiver_address_3']));
		$BookingDetailsDataObj->reciever_suburb = ucwords(strtolower($_POST['receiver_suburb']));
		if($flag=="australia")
		{
			$BookingDetailsDataObj->reciever_state = strtoupper($_POST['receiver_state']);
		}else{
			$BookingDetailsDataObj->reciever_state = ucwords(strtolower($_POST['receiver_state']));
		}
		$BookingDetailsDataObj->reciever_state_code = strtoupper($_POST['receiver_state_code']);
		$BookingDetailsDataObj->reciever_postcode = $_POST['receiver_postcode'];
		$BookingDetailsDataObj->reciever_email = $_POST['receiver_email'];
		$BookingDetailsDataObj->reciever_contact_no = $_POST['receiver_contact_no'];
		$BookingDetailsDataObj->reciever_area_code = $_POST['receiver_area_code'];
		$BookingDetailsDataObj->reciever_mb_area_code = $_POST['receiver_mb_area_code'];
		$BookingDetailsDataObj->reciever_mobile_no = $_POST['receiver_mobile_no'];
		$BookingDetailsDataObj->date_ready = $BookingDetailsDataObj->start_date;
		$BookingDetailsDataObj->time_ready == $BookingDetailsDataObj->time_ready;
		//$BookingDetailsDataObj->time_ready = $time_hr.":".$time_sec." ".$hr_formate;

		//$BookingDetailsDataObj->booking_date = date("j M Y");
		$BookingDetailsDataObj->booking_date = date("Y-m-d");
		$BookingDetailsDataObj->booking_time = date("g:i a");	
		
			
			
		$BookingDetailsData = (array)$BookingDetailsDataObj;
		$__Session->SetValue("booking_details",$BookingDetailsData);
		$__Session->Store();
		
		
		$_SESSION['set_pkp_readonly'] = $_POST['pickup_readonly'];
		$_SESSION['set_del_readonly'] = $_POST['delivery_readonly'];
		
		$_SESSION['set_pkp_addressbook'] = $savepkaddress;
		$_SESSION['set_del_addressbook'] = $savedeladdress;
		/*echo "<pre>";
		print_r($_POST);
		echo "</pre>";
		echo "<pre>";
		print_r($_SESSION);
		echo "</pre>";
		exit();*/

		$booking_details_data = $__Session->GetValue("booking_details");
		/*echo "<pre>";
		print_r($booking_details_data);
		echo "</pre>";
		exit();*/
		$upsValidCountry = false;
		if(isset($_POST['receiver_country']) && ($_POST['receiver_country'])!='')
		{
			if(in_array($_POST['receiver_country'],$valid_country_arr))
			{
				$upsValidCountry = true;
			}
		}
		
	/**********************************************************************************/
	/*Here we adding users address in address book after validated for duplicate entry*/
	/*It will added only then when validating from UPS Web services address norms of  */
	/*International address.For domestic users,it works new entry                     */
	/*From line #347 to #355 is for pickup address                                    */
	/*From line #358 to #366 is for delivery address                                  */
	/**********************************************************************************/
		//pickup address
		//$pickup_address_flag = $__Session->GetValue("pickup_address_flag");
		//$savepkaddress  = $_POST['pkaddress'];
		//$savedeladdress = $_POST['deladdress'];
		$pickup_address_flag = $_POST['confirmPkpAddYes'];
		
		
		if(isset($savepkaddress) && $savepkaddress == 1)
		{
			$pickup_address_flag = 1;
		}
		
		if(isset($pickup_address_flag) && $pickup_address_flag == 1){
		
			
		}elseif(isset($_POST['sender_client_address_id']) && !empty($_POST['sender_client_address_id']) && $_POST['sender_email']!='')
		{
			$objClientPkpAddressDataArray = $__Session->GetValue("client_address_pickup");
		
			if(is_array($objClientPkpAddressDataArray)) {
			
				$objClientPkpAddressData =  new ClientAddressData();
				/*
				foreach ($objClientPkpAddressDataArray as $key=>$val) {
		
					$objClientPkpAddressData->{$key}=valid_input($val);
				}
				*/
			}
			
			
			$objClientPkpAddressData->addressId = (int)$_POST['sender_client_address_id'];
			$objClientPkpAddressData->email = $_POST['sender_email'];
			$objClientPkpAddressData->userid=(int)$userid;
			$objClientAddressMaster->editClientAddress($objClientPkpAddressData,'','',true);
		}
		
		
		
		if(isset($savedeladdress) && $savedeladdress == 1)
		{
			$delivery_address_flag = 1;
		}
		if(isset($delivery_address_flag) && $delivery_address_flag == 1){
			
		}elseif(isset($_POST['delivery_client_address_id']) && !empty($_POST['delivery_client_address_id'])){
			$objClientDelAddressDataArray = $__Session->GetValue("client_address_dilivery");		
			
			if(is_array($objClientDelAddressDataArray)) {
			
				$objClientDelAddressData =  new ClientAddressData();
			
				foreach ($objClientDelAddressDataArray as $key=>$val) {
					
					$objClientDelAddressData->{$key}=ucwords(valid_output($val));
				}
			
			}
			$objClientDelAddressData->userid=(int)$userid;	
			$objClientDelAddressData->serial_address_id=(int)$_POST['delivery_client_address_id'];	
			$objClientAddressMaster->editClientAddress($objClientDelAddressData);
			
		}
		
		
		if(isset($_GET['Action']) && $_GET['Action']=='edit')
		{
			$arg = "?Action=edit";
		}
		$bookingid = generatebookigid();
		$__Session->SetValue("booking_id",$bookingid);
		$__Session->Store();
		if(isset($_GET['Action']) && $_GET['Action']=='edit') {
			//echo "inside";
			show_page_header(FILE_CHECKOUT,true);
			exit();
		}else{
			
			
			show_page_header(FILE_ADDITIONAL_DETAILS,true);
			exit();
		}
		//exit;
			
	}
}




//pre-filled pickup address
$pickaddressArray=$__Session->GetValue("client_address_pickup");

if(is_array($pickaddressArray)) {
	//echo "inside this condidtion of pickup";
	$pickaddress = new stdClass;
	foreach ($pickaddressArray as $key=>$val) {
		$pickaddress->{$key}=valid_output($val);
	}
		
}
/*echo "<pre>";
print_r($pickaddress);
echo "</pre>";*/
//pre-filled dilivery address
$deliaddressArray=$__Session->GetValue("client_address_dilivery");
if(is_array($deliaddressArray)) {
	$deliaddress = new stdClass;
	foreach ($deliaddressArray as $key=>$val) {
	$deliaddress->{$key}=valid_output($val);
	}
}
if(defined('SES_USER_ID')) {
		
		$userSeaArr[]     	= array('Search_On'=>'userid', 'Search_Value'=>SES_USER_ID, 'Type'=>'int', 'Equation'=>'=', 'CondType'=>'AND', 'Prefix'=>'','Postfix'=>'');
		$Users            	= $UserMasterObj->getUser(null, $userSeaArr);
		$Users            	= $Users[0];
		//echo SES_USER_ID;
		//exit();

		$pickaddressArray=$__Session->GetValue("client_address_pickup");
		$deliaddressArray=$__Session->GetValue("client_address_dilivery");
		
		$address_sess_data		= $__Session->GetValue("booking_details");
		$pkp_sess_data		= valid_output($address_sess_data['pickupid']);	
		$dlv_sess_data		= valid_output($address_sess_data['deliveryid']);	
		$explode_pkp_add	= explode(" ",$pkp_sess_data);
		//Array ( [0] => 3889 [1] => VIC [2] => Creek [3] => Tree [4] => Cabbage )
		$explode_pkp_add 	= array_reverse($explode_pkp_add);
		//print_r($explode_pkp_add);
		//$suburbName 		= $explode_pkp_add[2];
		$suburbArr = array();
		if(sizeof($explode_pkp_add) >= 2 ){
			
			for($i=2;$i<sizeof($explode_pkp_add);$i++)
			{
				$suburbArr[] = $explode_pkp_add[$i];
			} 
		} 
		$suburubArr = array_reverse($suburbArr);
		//print_R($suburubArr);
		$suburbName = '';
		if(!empty($suburubArr))
		{
			for($j=0;$j<sizeof($suburubArr);$j++)
			{
				if($j == sizeof($suburubArr))
				{
					$suburbName .= $suburubArr[$j];
				}else{
					$suburbName .= $suburubArr[$j]." ";
				}
			}
		}
		$explode_dlv_add	= explode(" ",$dlv_sess_data);
		$explode_dlv_add 	= array_reverse($explode_dlv_add); 
		/*echo "<pre>";
		print_r($explode_pkp_add);
		echo "</pre>";*/


		
		$user_suburb 	= valid_output($Users->suburb);
		//echo "suburb:".$user_suburb."state:".$Users->state."postcode:".$Users->postcode."comparedsuburb:".$suburbName;
		$zipComp 	= strcmp($explode_pkp_add[0],$Users->postcode);
		$stateComp 		= strcmp(strtolower($explode_pkp_add[1]),strtolower($Users->state)); 

		$suburbComp 		= strcmp(strtolower(trim($suburbName)),strtolower(trim($Users->suburb)));
		//This below code commented by shailesh jamanapara on Date Wed Apr 24 18:42:20 IST 2013
		//echo strtolower($suburbName)."--".strtolower($Users->suburb).strcmp(strtolower(trim($suburbName)),strtolower(trim($Users->suburb)))."</br>"; 
		//echo $suburbComp."--".$stateComp."---".$zipComp ."</br>";
		
		$PkaddMatchFlag = 0;
		$DladdMatchFlag = 0;
		/*Commented*/
		$pickaddress = new stdClass;
		//This below code commented by shailesh jamanapara on Date Mon Jul 29 17:02:00 IST 2013 
		
		if($pickaddressArray && is_array($pickaddressArray)){
				foreach ($pickaddressArray as $key=>$val) {
					$pickaddress->{$key}=valid_output($val);
				}
		}else{
			if($suburbComp == 0 && $stateComp == 0 && $zipComp == 0){
				$PkaddMatchFlag = 1;
				//$addMatchFlag = 1;
				
				$pickaddress->suburb 	= ucwords(strtolower($Users->city));
				$pickaddress->state 	= $Users->state;
				$pickaddress->postcode 	= $Users->postcode;
				$pickaddress->firstname = ucwords(strtolower($Users->firstname));
				$pickaddress->surname=ucwords(strtolower($Users->lastname));
				$pickaddress->email=$Users->email;
				$pickaddress->address1=ucwords(strtolower($Users->address1));
				$pickaddress->address2=ucwords(strtolower($Users->address2));
				$pickaddress->address3=ucwords(strtolower($Users->address3));
				$pickaddress->mobileno=$Users->mobile_no;
				$pickaddress->phoneno=$Users->phone_number;
				$pickaddress->area_code=$Users->sender_area_code;
				$pickaddress->m_area_code=$Users->sender_mb_area_code;
				//$pickaddress->company = $Users->company;
			}
		}
		
		
		$Pickupvalue['Name']	= $suburbName;
		$Pickupvalue['State']	= $explode_pkp_add[1];
		$Pickupvalue['Postcode']= $explode_pkp_add[0];
		
		//compairing delivery address here 
		//pre-filled dilivery address
		//$delSubUrb		= $explode_dlv_add[2]; 
		$delSubUrbArr = array();
		if(sizeof($explode_dlv_add) >= 2 ){
			
			for($i=2;$i<sizeof($explode_dlv_add);$i++)
			{
				$delSubUrbArr[] = $explode_dlv_add[$i];
			} 
		} 
		$delSubUrbArr = array_reverse($delSubUrbArr);
		//print_R($suburubArr);
		$delSubUrb = '';
		if(!empty($delSubUrbArr))
		{
			for($j=0;$j<sizeof($delSubUrbArr);$j++)
			{
				if($j == sizeof($delSubUrbArr))
				{
					$delSubUrb .= $delSubUrbArr[$j];
				}else{
					$delSubUrb .= $delSubUrbArr[$j]." ";
				}
			}
		}

		/*
		if(sizeof($explode_dlv_add) > 3){
			$delSubUrb	= $explode_dlv_add[3] . $explode_dlv_add[2];
		} */
		$zipCompDlv 	= strcmp($explode_dlv_add[0],$Users->postcode);
		$stateCompDlv 		= strcmp(strtolower($explode_dlv_add[1]),strtolower($Users->state)); 
		$suburbCompDlv 		= strcmp(strtolower(trim($delSubUrb)),strtolower(trim($Users->suburb)));
		//echo $suburbCompDlv."--".$stateCompDlv."--".$zipCompDlv;
			$deliaddress = new stdClass;	
				
			if(isset($deliaddressArray) && !empty($deliaddressArray)){
				foreach ($deliaddressArray as $key=>$val) {
					$deliaddress->{$key}=valid_output($val);
				}
			}else{
				if($suburbCompDlv == 0 && $stateCompDlv == 0 && $zipCompDlv == 0){
						if ($DladdMatchFlag == 0){
				 				$DladdMatchFlag = 1;
						}
						$deliaddress->suburb 	= ucwords(strtolower($Users->city));
						$deliaddress->state 	= $Users->state;
						$deliaddress->postcode 	= $Users->postcode;
						$deliaddress->firstname = ucwords(strtolower($Users->firstname));
						$deliaddress->surname	= ucwords(strtolower($Users->lastname));
						$deliaddress->email		= $Users->email;
						$deliaddress->address1	= ucwords(strtolower($Users->address1));
						$deliaddress->address2	= ucwords(strtolower($Users->address2));
						$deliaddress->address3	= ucwords(strtolower($Users->address3));
						$deliaddress->mobileno	= $Users->mobile_no;
						$deliaddress->phoneno	= $Users->phone_number;
						$deliaddress->area_code	=$Users->sender_area_code;
						$deliaddress->m_area_code	=$Users->sender_mb_area_code;
						//$deliaddress->company 	= $Users->company;
			}
			}

		$Delivervalue['Name']		= $delSubUrb;
		$Delivervalue['State']		= $explode_dlv_add[1];
		$Delivervalue['Postcode']	= $explode_dlv_add[0];
		//This below code edited by shailesh jamanapara on Date Wed Apr 24 18:42:38 IST 2013 
		$sessPkAddFromBook =$__Session->GetValue("pickup_add_from_book");
		$sessDlAddFromBook =$__Session->GetValue("delivery_add_from_book");
		if(isset($sessPkAddFromBook) && $sessPkAddFromBook == 1 ){
			if($PkaddMatchFlag == 0){
				$PkaddMatchFlag = 1;
			}
			
		}
		if(isset($sessDlAddFromBook) && $sessDlAddFromBook == 1 ){
			if($DladdMatchFlag == 0){
				$DladdMatchFlag = 1;
			}
		}
			
	}
//echo 

$booking_details = $__Session->GetValue("booking_details"); 
$data_deliver = $booking_details['deliveryid'];
$deliver_data = explode(" ",$data_deliver);

$deliver_suburb = (count((array)$deliver_data)==3)?($deliver_data[0]):($deliver_data[0].' '.$deliver_data[1]);

if($booking_details['servicepagename']=="overnight" || $booking_details['servicepagename']=="sameday")
{
	$fieldArr=array("*");
	$ServiceSear=array();
	$ServiceSear[]= array('Search_On'=>'service_name', 'Search_Value'=>$booking_details['service_name'], 'Type'=>'string', 'Equation'=>'=', 'CondType'=>'AND', 'Prefix'=>'', 'Postfix'=>'');
	$service_data = $ObjServiceMaster->getService($fieldArr,$ServiceSear);
	$service_data=$service_data[0];
}

//$Pickupvalue['Name']=(($user_suburb!=''&&(strcmp($deliver_suburb,$user_suburb)==0))?(''):($Pickupvalue['Name']));
require_once( DIR_WS_SITE_CURRENT_TEMPLATE . FILE_MAIN_INTERFACE); /* This include once is used for the html integration */
?>
