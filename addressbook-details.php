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
 ob_start();

require_once("lib/common.php");
define("TITLE","Address Booking Page");
require_once(DIR_WS_CURRENT_LANGUAGE . "addressbook-details.php");
require_once(DIR_WS_CURRENT_LANGUAGE . "user.php");
require_once(DIR_WS_MODEL."PostCodeMaster.php");
require_once(DIR_WS_MODEL . "InternationalZonesMaster.php");
require_once(DIR_WS_MODEL ."ClientAddressMaster.php");
require_once(DIR_WS_MODEL ."CountryMaster.php");

$objCountryMaster = new CountryMaster();
$objCountryMaster = $objCountryMaster->Create();
$objCountryData=new CountryData();

$objClientAddressMaster = new ClientAddressMaster();
$objClientAddressMaster = $objClientAddressMaster->Create();
$objClientAddressData=new ClientAddressData();

$PostCodeMasterObj = new PostCodeMaster();
$PostCodeMasterObj = $PostCodeMasterObj->create();
$PostCodeDataObj = new PostCodeData();

$InternationalZoneMasterObj= new InternationalZonesMaster();
$InternationalZoneMasterObj= $InternationalZoneMasterObj->create();
$InternationalZoneData = new InternationalZonesData();


/**
 * Inclusion and Exclusion CSS
 */
$arr_css_plugin_include[] = 'glyphicons_new/css/glyphicons.css';
//$arr_css_plugin_include[] = 'datatables/css/jquery.dataTables.min.css';
//$arr_css_plugin_include[] = 'datatables/extensions/Responsive/css/dataTables.responsive.css';
$arr_css_plugin_include[] = 'waitMe/css/waitMe.min.css';

/**
 * Inclusion and Exclusion Array of Javascript
*/
$arr_javascript_include[] = 'internal/ajex.js';
$arr_javascript_include[] = 'internal/ajax-dynamic-list.js';
$arr_javascript_plugin_include[] ="back-to-top.js";
//$arr_javascript_plugin_include[] = 'datatables/js/jquery.dataTables.min.js';
//$arr_javascript_plugin_include[] = 'datatables/extensions/Responsive/js/dataTables.responsive.min.js';
//$arr_javascript_plugin_include[] = 'datatables/extensions/Bootstrap-Integration/js/dataTables.bootstrap.js';
//$arr_javascript_plugin_include[] = 'datatables/extensions/TableTools/js/dataTables.tableTools.min.js';
$arr_javascript_below_include[] = 'internal/addressbook-details.php';
$arr_javascript_plugin_include[] = 'waitMe/js/waitMe.min.js';
/*
echo "<pre>";
print_r($_POST);
echo "</pre>";
//exit();
/*csrf validation*/
$csrf = new csrf();

if((!isset($_POST['Save']) && $_POST['Save']==""))
{
	$csrf->action = "add_addressbook";
	$ptoken = $csrf->csrfkey();
}
/*csrf validation*/

if(isset($_GET['CatId']) && $_GET['CatId']!='')
{
	$err['CatId'] = isNumeric(valid_input($_GET['CatId']),ERROR_ENTER_NUMERIC_VALUE);
}
if(!empty($err['CatId']))
{
	logOut();
}
if(isset($_POST['CatId']) && $_POST['CatId']!='')
{
	$err['PostCatId'] = isNumeric(valid_input($_POST['CatId']),ERROR_ENTER_NUMERIC_VALUE);
}
if(!empty($err['PostCatId']))
{
	logOut();
}
if(isset($_GET['pkpVal']) && $_GET['pkpVal']!='')
{
	$err['pkpVal'] = isNumeric(valid_input($_GET['pkpVal']),ERROR_ENTER_NUMERIC_VALUE);
}
if(!empty($err['pkpVal']))
{
	logOut();
}
if(isset($_GET['delVal']) && $_GET['delVal']!='')
{
	$err['delVal'] = isNumeric(valid_input($_GET['delVal']),ERROR_ENTER_NUMERIC_VALUE);
}
if(!empty($err['delVal']))
{
	logOut();
}
if(isset($_GET['fromBooking']) && $_GET['fromBooking']!='')
{
	$err['fromBooking'] = isNumeric(valid_input($_GET['fromBooking']),ERROR_ENTER_NUMERIC_VALUE);
}
if(!empty($err['fromBooking']))
{
	logOut();
}
if(isset($_GET['sessState']) && $_GET['sessState']!='')
{
	$err['sessState'] = chkCapital(valid_input($_GET['sessState']));
}
if(!empty($err['sessState']))
{
	logOut();
}
if(isset($_GET['type']) && $_GET['type']!='')
{
	$err['type'] = chkSmall(valid_input($_GET['type']));
}
if(!empty($err['type']))
{
	logOut();
}
/*  js file */
$arr_javascript_include[] = 'addressbook-details.php';
/* js file end */

$session_data = json_decode($_SESSION['Thesessiondata']['_sess_login_userdetails'],true);
$userid = $session_data['user_id'];
//echo "userid:".$userid;
if(isset($userid) && $userid!='')
{
	$err['userid'] = isNumeric(valid_input($userid),ERROR_ENTER_NUMERIC_VALUE);
}
if(!empty($err['userid']))
{
	logOut();
}

//This condition added by shailesh jamanapara on date Mon May 27 19:33:08 IST 2013
$pkp_sess_data = valid_output($_SESSION['pickup']);
$explode_pkp_add	= explode(" ",$pkp_sess_data);
$explode_pkp_add 	= array_reverse($explode_pkp_add);
$suburbName 		= $explode_pkp_add[2] ;
if(sizeof($explode_pkp_add) > 3 ){
	$suburbName 	= $explode_pkp_add[3] ." " .  $explode_pkp_add[2] ;
}

$del_sess_data = valid_output($_SESSION['deliver']);
$explode_del_add	= explode(" ",$del_sess_data);
$explode_del_add 	= array_reverse($explode_del_add);
$delSuburbName 		= $explode_del_add[2] ;
if(is_array($delSuburbName) && sizeof($delSuburbName)  > 3){
	$delSuburbName 	= $explode_del_add[3] ." " .  $explode_del_add[2] ;
}

 if(isset($_GET['type'])){
 	$sessBookAddressType =$__Session->GetValue("booking_details");
   	if($_GET['type'] == "pickup"){
 		$sessBookAddress = valid_output($sessBookAddressType["pickupid"]);
   	}elseif ($_GET['type'] == 'delivery'){
   		$sessBookAddress = valid_output($sessBookAddressType["deliveryid"]);
   	}
 }
if(isset($_GET['type'])&& $_GET['type']!=""){
	$type= $_GET['type'];
	$__Session->ClearValue("pickup_add_from_book");
	$__Session->ClearValue("delivery_add_from_book");
	$button_url = FILE_ADDRESS_BOOK_LISTING."?type=".$type;
}else{
	$button_url = FILE_ADDRESS_BOOK_LISTING;
}


if((isset($_POST['Save'])))
{
		if(isEmpty(valid_input($_POST['ptoken']), true)){
			logOut();
		}else{
			$csrf->checkcsrf($_POST['ptoken']);
		}

		$err['firstname']			= isEmpty(valid_input($_POST['firstname']),COMMON_FIRSTNAME_IS_REQUIRED)?isEmpty(valid_input($_POST['firstname']),COMMON_FIRSTNAME_IS_REQUIRED):checkName(valid_input($_POST['firstname']));
	    $err['lastname']			= isEmpty(valid_input($_POST['lastname']),COMMON_LASTNAME_IS_REQUIRED)?isEmpty(valid_input($_POST['lastname']),COMMON_LASTNAME_IS_REQUIRED):checkName(valid_input($_POST['lastname']));
		if($_POST['firstname']!="" && strlen($_POST['firstname'])<2)
		{
			$err['firstname'] = ENTER_CHARACTER;
		}
		if($_POST['lastname']!="" && strlen($_POST['lastname'])<2)
		{
			$err['lastname'] = ENTER_CHARACTER;
		}
		if($_POST['company']!='')
		{
			$err['company'] = checkName(valid_input($_POST['company']));
		}
		$err['address1']	 		= isEmpty(valid_input($_POST['address1']),COMMON_ADDRESS_IS_REQUIRED)?isEmpty(valid_input($_POST['address1']),COMMON_ADDRESS_IS_REQUIRED):chkStreet(valid_input($_POST['address1']));
		if(valid_input($_POST['address2'])!='')
		{
			$err['address2'] = chkStreet(valid_input($_POST['address2']));
		}
		if(valid_input($_POST['address3'])!='')
		{
			$err['address3'] = chkStreet(valid_input($_POST['address3']));
		}
		if(COUNTRY_SELECT == $_POST['country'])
		{
			$err['postcode']	 		= isEmpty(valid_input($_POST['postcode']),COMMON_ZIPCODE_IS_REQUIRED)?isEmpty(valid_input($_POST['postcode']),COMMON_ZIPCODE_IS_REQUIRED):isNumeric(valid_input($_POST['postcode']),ERROR_ENTER_NUMERIC_VALUE);
		}else{
			$err['postcode']	 		= isEmpty(valid_input($_POST['postcode']),COMMON_ZIPCODE_IS_REQUIRED)?isEmpty(valid_input($_POST['postcode']),COMMON_ZIPCODE_IS_REQUIRED):chkStreet(valid_input($_POST['postcode']));
		}
		if(isset($_POST['country']) && $_POST['country']==UNITED_STATE_ID)
		{
			if(strlen($_POST['postcode'])!=5)
			{
				$err['postcode'] = ERROR_US_POSTCODE;
			}
		}
		$err['suburb']	 			= isEmpty(valid_input($_POST['suburb']),COMM0N_SUBURB_IS_REQUIRED)?isEmpty(valid_input($_POST['suburb']),COMM0N_SUBURB_IS_REQUIRED):checkSuburb(valid_input($_POST['suburb']));
		if(valid_input($_POST['state'])!='')
		{
			$err['state'] = chkState(valid_input($_POST['state']));
		}

		$err['country']	 			= isEmpty(valid_input($_POST['country']),COMMON_COUNTRY_IS_REQUIRED)?isEmpty(valid_input($_POST['country']),COMMON_COUNTRY_IS_REQUIRED):isNumeric(valid_input($_POST['country']),ERROR_ENTER_NUMERIC_VALUE);
		$err['areaCode']	 		= isEmpty(valid_input($_POST['sender_area_code']),COMMON_AREA_CODE_IS_REQUIRED)?isEmpty(valid_input($_POST['sender_area_code']),COMMON_AREA_CODE_IS_REQUIRED):areaCodePattern(valid_input($_POST['sender_area_code']),ERROR_AREA_CODE_INVALID,'1');
		$err['contactNo']	 		= isEmpty(valid_input($_POST['contactNo']),COMMON_PHONE_IS_REQUIRED)?isEmpty(valid_input($_POST['contactNo']),COMMON_PHONE_IS_REQUIRED):areaCodePattern(valid_input($_POST['contactNo']),ERROR_AREA_CODE_INVALID,'0');

		if($_POST['changed_cntry'])
		{
			$err['changed_cntry'] = isNumeric(valid_input($_POST['changed_cntry']),ERROR_ENTER_NUMERIC_VALUE);
		}
		if($err['changed_cntry'])
		{
			logOut();
		}

		if(valid_input($_POST['sender_mb_area_code'])!="")
		{
			$err['areaContactNo2'] = areaCodePattern(valid_input($_POST['sender_mb_area_code']),ERROR_AREA_CODE_INVALID,'1');
		}
		if(valid_input($_POST['mobile_phone'])!="")
		{
			$err['contactNo2'] = areaCodePattern(valid_input($_POST['mobile_phone']),ERROR_AREA_CODE_INVALID,'0');
		}
		if(valid_input($_POST['email']) != "")
		{
			$err['EmailId']	 = checkEmailPattern(valid_input($_POST['email']), ERROR_EMAIL_ID_INVALID);
		}
		if($_POST['country_name'] != "")
		{
			if(chkbrkts(trim($_POST['country_name'])))
			{
				logOut();
			}
		}

		foreach($err as $key => $Value) {
			if($Value != '') {
				$Svalidation=true;
				$ptoken = $csrf->csrfkey();
			}
		}

		if($Svalidation==false) {

		$check_condition = 'true'; //for the duplicate entry validation
		$objClientAddressData->userid =$userid;
		$objClientAddressData->firstname=ucwords(strtolower($_POST['firstname']));
		$objClientAddressData->surname=ucwords(strtolower($_POST['lastname']));
		$objClientAddressData->company=ucwords(strtolower($_POST['company']));

		$objClientAddressData->address1=ucwords(strtolower($_POST['address1']));
		$objClientAddressData->address2=ucwords(strtolower($_POST['address2']));
		$objClientAddressData->address3=ucwords(strtolower($_POST['address3']));
		$objClientAddressData->email=$_POST['email'];
		$objClientAddressData->area_code = valid_input($_POST['sender_area_code']);
		$objClientAddressData->phoneno=$_POST['contactNo'];
		//if($_POST['mobile_phone']){
		$objClientAddressData->m_area_code = valid_input($_POST['sender_mb_area_code']);
		$objClientAddressData->mobileno=$_POST['mobile_phone'];
		//}
		$objClientAddressData->suburb=ucwords(valid_input(strtolower($_POST['suburb'])));

		if(isset($_POST['country']) && $_POST['country']=="13")
		{
			$objClientAddressData->state=strtoupper(valid_input($_POST['state']));
		}else{
			$objClientAddressData->state=ucwords(strtolower(valid_input($_POST['state'])));
		}

		$objClientAddressData->countryid=$_POST['country'];
		$objClientAddressData->country=ucwords(strtolower(trim($_POST['country_name'])));


		if($_POST['country']==13){
			if(valid_input($_POST['Submit1']) == "Save And Use Address"){
				$pcode= valid_input($_POST['postcode']) ;
			}else{
				$pcode= substr($_POST['postcode'],-4);
			}
		}
		else
		{
			 $pcode= $_POST['postcode'];
			 $objClientAddressData->countryid=$_POST['country'];
			$objClientAddressData->country=ucwords(strtolower(trim($_POST['country_name'])));
		}

		$objClientAddressData->postcode=$pcode;
		$objClientAddressData->state_code=strtoupper($_POST['register_state_code']);

		//$objClientAddressData->postcode=$pcode;
			$seaArr9[]	=	array('Search_On'    => 'userid',
			                      'Search_Value' => $objClientAddressData->userid,
			                      'Type'         => 'int',
			                      'Equation'     => '=',
			                      'CondType'     => 'AND',
			                      'Prefix'       => '',
			                      'Postfix'      => '');
			$seaArr9[]	=	array('Search_On'    => 'firstname',
			                      'Search_Value' => $objClientAddressData->firstname,
			                      'Type'         => 'string',
			                      'Equation'     => '=',
			                      'CondType'     => 'AND',
			                      'Prefix'       => '',
			                      'Postfix'      => '');
			$seaArr9[]	=	array('Search_On'    => 'surname',
			                      'Search_Value' => $objClientAddressData->surname,
			                      'Type'         => 'string',
			                      'Equation'     => '=',
			                      'CondType'     => 'AND',
			                      'Prefix'       => '',
			                      'Postfix'      => '');
			$seaArr9[]	=	array('Search_On'    => 'address1',
			                      'Search_Value' => $objClientAddressData->address1,
			                      'Type'         => 'string',
			                      'Equation'     => '=',
			                      'CondType'     => 'AND',
			                      'Prefix'       => '',
			                      'Postfix'      => '');
			$seaArr9[]	=	array('Search_On'    => 'address2',
			                      'Search_Value' => $objClientAddressData->address2,
			                      'Type'         => 'string',
			                      'Equation'     => '=',
			                      'CondType'     => 'AND',
			                      'Prefix'       => '',
			                      'Postfix'      => '');
			$seaArr9[]	=	array('Search_On'    => 'address3',
			                      'Search_Value' => $objClientAddressData->address3,
			                      'Type'         => 'string',
			                      'Equation'     => '=',
			                      'CondType'     => 'AND',
			                      'Prefix'       => '',
			                      'Postfix'      => '');
			$seaArr9[]	=	array('Search_On'    => 'state',
			                      'Search_Value' => $objClientAddressData->state,
			                      'Type'         => 'string',
			                      'Equation'     => '=',
			                      'CondType'     => 'AND',
			                      'Prefix'       => '',
			                      'Postfix'      => '');
			$seaArr9[]	=	array('Search_On'    => 'area_code',
			                      'Search_Value' => $objClientAddressData->area_code,
			                      'Type'         => 'string',
			                      'Equation'     => '=',
			                      'CondType'     => 'AND',
			                      'Prefix'       => '',
			                      'Postfix'      => '');
			$seaArr9[]	=	array('Search_On'    => 'phoneno',
			                      'Search_Value' => $objClientAddressData->phoneno,
			                      'Type'         => 'string',
			                      'Equation'     => '=',
			                      'CondType'     => 'AND',
			                      'Prefix'       => '',
			                      'Postfix'      => '');
			$seaArr9[]	=	array('Search_On'    => 'mobileno',
			                      'Search_Value' => $objClientAddressData->mobileno,
			                      'Type'         => 'string',
			                      'Equation'     => '=',
			                      'CondType'     => 'AND',
			                      'Prefix'       => '',
			                      'Postfix'      => '');
		$clientAddressData_t=$objClientAddressMaster->GetClientAddress('null',$seaArr9);

		$error = '';

		if((isset($_GET['CatId']) && $_GET['CatId'] != "") ||((isset($_POST['CatId']) && $_POST['CatId'] !== "")) )
		{

				$objClientAddressData->userid = (int)$userid;
				if(isset($_GET['CatId']) && $_GET['CatId'] !="" )
				{
					$objClientAddressData->serial_address_id = (int)$_GET['CatId'];
				}else{
					$objClientAddressData->serial_address_id = (int)$_POST['CatId'];
				}
				$insert=$objClientAddressMaster->editClientAddress($objClientAddressData);
				//exit();
				if(valid_input($_POST['Submit1']) == "Save And Use Address"){
				$type= $_GET['type'];
				$button_url = FILE_BOOKING_WITH_ADDRESS."?type=".$type."&add_id=".$insert;
				$__Session->SetValue(valid_input($type)."_add_from_book",1);
				$__Session->Store();
				}
				else
				{
					$button_url = FILE_ADDRESS_BOOK_LISTING;
				}
				header("Location:".$button_url);
				exit();
		}else{

		//if(($clientAddressData_t == '' && (isset($_GET['CatId']) && !empty($_GET['CatId']))) ||  ($clientAddressData_t == '' && (isset($_POST['CatId']) && !empty($_POST['CatId']))))
		//{

			/*Start for the logic of serial_address_id */
			$srExitAdd[]	=	array('Search_On'    => 'userid',
			                      'Search_Value' => $userid,
			                      'Type'         => 'int',
			                      'Equation'     => '=',
			                      'CondType'     => 'AND',
			                      'Prefix'       => '',
			                      'Postfix'      => '');
			$srExitClientAddressData = $objClientAddressMaster->GetClientAddress('null',$srExitAdd);
			//$srExitClientAddressData = $srExitClientAddressData[0];

			if(!empty($srExitClientAddressData))
			{
				$count = count($srExitClientAddressData);
			}

			if($count == 0)
			{
				$objClientAddressData->serial_address_id = 1;
			}else
			{

				$i =1;
				$serialArr = array();
				$unproperSerialArr = array();
				foreach($srExitClientAddressData as $key){
					$serialArr[] = $i;
					$unproperSerialArr[] = $key['serial_address_id'];
					$i++;
				}
				$new_list=array_diff($serialArr,$unproperSerialArr);
				foreach($new_list as $j)
				{
					$objClientAddressData->serial_address_id = $j;
				}

				if(empty($objClientAddressData->serial_address_id))
				{
					///$srMaxAdd[]  = "";
					$srMaxAdd[]	=	array('Search_On'    => 'userid',
			                      'Search_Value' => $userid,
			                      'Type'         => 'int',
			                      'Equation'     => '=',
			                      'CondType'     => 'AND',
			                      'Prefix'       => '',
			                      'Postfix'      => '');

					$maxFieldArr = array("max(serial_address_id) as address_id");
					$srMaxClientAddressData = $objClientAddressMaster->GetClientAddress($maxFieldArr,$srMaxAdd);
					$srMaxClientAddressData = $srMaxClientAddressData[0];
					$objClientAddressData->serial_address_id = $srMaxClientAddressData['address_id']+1;
				}
			}

			/*End for the logic of serial_address_id */

			$insert=$objClientAddressMaster->addClientAddress($objClientAddressData);

			//This condition added by shailesh jamanapara on date Mon May 27 19:36:08 IST 2013
			if(valid_input($_POST['Submit1']) == "Save And Use Address")
			{
				$type= $_GET['type'];
				$button_url = FILE_BOOKING_WITH_ADDRESS."?type=".$type."&add_id=".$insert;
				$__Session->SetValue(valid_input($type)."_add_from_book",1);
				$__Session->Store();
			}
			else
			{
			$button_url = FILE_ADDRESS_BOOK_LISTING;
			}

			header("Location:".$button_url);
			exit();


		}

	}
}

$countryCode = $objCountryMaster->getCountry();
/*echo "<pre>";
print_r($countryCode);
echo "</pre>";
*/
if(isset($_GET['CatId']) && $_GET['CatId'] != 0)
{
		$addressid=$_GET['CatId'];
		$seaArr[0] = array('Search_On'    => 'serial_address_id',
		                      'Search_Value' => $addressid,
		                      'Type'         => 'int',
		                      'Equation'     => '=',
		                      'CondType'     => 'AND',
		                      'Prefix'       => '',
		                      'Postfix'      => '');
		$seaArr[1] = array('Search_On'    => 'userid',
		  'Search_Value' => $userid,
		  'Type'         => 'int',
		  'Equation'     => '=',
		  'CondType'     => 'AND',
		  'Prefix'       => '',
		  'Postfix'      => '');
		$clientAddressEdit=$objClientAddressMaster->GetClientAddress('null',$seaArr);
		if($clientAddressEdit=="")
		{
			$clientAddressEdit=0;
		}
		else
		{
			$clientAddressEdit=$clientAddressEdit[0];
		}
}
require_once( DIR_WS_SITE_CURRENT_TEMPLATE . FILE_MAIN_INTERFACE); /* This include once is used for the html integration */
?>
