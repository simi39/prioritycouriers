<?php
/**
 * include common
 */
session_start();

require_once("lib/common.php");
require_once(DIR_WS_CURRENT_LANGUAGE . "addressbook.php");
require_once(DIR_WS_MODEL ."BookingDetailsMaster.php");
require_once(DIR_WS_MODEL ."BookingItemDetailsMaster.php");
require_once(DIR_WS_MODEL ."InternationalZonesMaster.php");
require_once(DIR_WS_MODEL ."ClientAddressMaster.php");
require_once(DIR_WS_MODEL."PostCodeMaster.php");
require_once(DIR_WS_MODEL . "UserMaster.php");
$error = '';

$UserMasterObj    = UserMaster::Create();
$UserData         = new UserData();
$PostCodeMasterObj = PostCodeMaster::create();
$PostCodeDataObj = new PostCodeData();

$clientAddressMasterObj = ClientAddressMaster::create();
$clientAddressDataObj = new ClientAddressData();
$client_copy_address = new ClientAddressData();
$BookingItemDetailsMasterObj = BookingItemDetailsMaster::create();
$BookingItemDetailsDataObj = new BookingItemDetailsData();

$BookingDetailsMasterObj = BookingDetailsMaster::create();
$BookingDetailsDataObj = new BookingDetailsData();

$InternationalZoneMasterObj= InternationalZonesMaster::create();
$InternationalZoneData = new InternationalZonesData();


$arr_css_respons_include[] = DIR_HTTP_CSS.'addressBookListing-compact.css';
$arr_css_plugin_include[] = 'datatables/datatables.min.css';
$arr_css_plugin_include[] = 'datatables/Buttons-1.7.0/css/buttons.dataTables.min.css';


$arr_javascript_include[] = 'internal/addressbook.php';
$arr_javascript_plugin_include[] = 'datatables/datatables.min.js';
//$arr_javascript_plugin_include[] = 'animatedcollapse.js';


////
/*csrf validation*/
$csrf = new csrf();
$csrf->action = "addressbook";
$ptoken = $csrf->csrfkey();
/*csrf validation*/

if(isset($_POST['ptoken'])) {
	$csrf->checkcsrf($_POST['ptoken']);
}
$deleteid = $_GET['deleteid'];
if($deleteid != '')
{
	$err['deleteid'] = isNumeric($deleteid, COMMON_NUMERIC_VAL);
}
if(!empty($err['deleteid']))
{
	logOut();
}
if(!empty($_GET['action']))
{
	$err['action'] = chkStr(valid_input($_GET['action']));
}
/*echo "<pre>";
print_r($err);
echo "</pre>";
exit();*/
if(!empty($err['action']))
{
	logOut();
}
if($_GET['action']=="delete" && !empty($deleteid)) {
		$clientAddressMasterObj->deleteClientAddress($deleteid,$userid);
}

if($userid != '')
{
	$err['userid'] = isNumeric($userid, COMMON_NUMERIC_VAL);
}
if(!empty($err['userid']))
{
	logOut();
}
if($_GET['fromBooking'] != '')
{
	$err['fromBooking'] = isNumeric($_GET['fromBooking'], COMMON_NUMERIC_VAL);
}
if(!empty($err['fromBooking']))
{
	logOut();
}
if($_GET['pkpVal'] != '')
{
	$err['pkpVal'] = isNumeric($_GET['pkpVal'], COMMON_NUMERIC_VAL);
}
if(!empty($err['pkpVal']))
{
	logOut();
}
if($_GET['country'])
{
	$err['country'] = isNumeric(valid_input($_POST['country']),ERROR_ENTER_NUMERIC_VALUE);
}
if($err['country'])
{
	logOut();
}
if($_GET['delVal'] != '')
{
	$err['delVal'] = isNumeric($_GET['delVal'], COMMON_NUMERIC_VAL);
}
if(!empty($err['delVal']))
{
	logOut();
}
if($_GET['type'] != '')
{
	$err['type'] = chkStr($_GET['type']);
}
if(!empty($err['type']))
{
	logOut();
}
if($_GET['add_id'] != '')
{
	$err['add_id'] = isNumeric($_GET['add_id'], COMMON_NUMERIC_VAL);
}
if(!empty($err['add_id']))
{
	logOut();
}
if(isset($userid) && $userid!=''){
$current_user = $__Session->GetValue('_sess_login_userdetails');
$first_name = $current_user['firstname'];
$last_name = $current_user['lastname'];
}
//This condition added by shailesh jamanapara on date Wed Apr 24 20:10:00 IST 2013
$appendPara = '';
//This condition added by shailesh jamanapara on date Wed Apr 24 20:10:00 IST 2013
 if (isset($_GET['fromBooking']) && $_GET['fromBooking'] == 1) {
 	$appendPara = "&fromBooking=1";
 	$__Session->SetValue("fromBooking",1);
 	$__Session->Store();
 }
$appendVal = '';
if(isset($_GET['pkpVal'])){
	if(isset($_GET['Action']) && $_GET['Action'] == 'edit'){
		$appendVal = "&pkpVal=".$_GET['pkpVal']."&Action=edit";
	}else{
		$appendVal = "&pkpVal=".$_GET['pkpVal'];
	}

}
if(isset($_GET['delVal'])){
	if(isset($_GET['Action']) && $_GET['Action'] == 'edit'){
		$appendVal = "&delVal=".$_GET['delVal']."&Action=edit";
	}else{
		$appendVal .= "&delVal=".$_GET['delVal'];
	}
}

if($_GET["type"]!="" && isset($_GET["type"])) {
	$tmp = $__Session->GetValue("booking_details");
	$__Session->SetValue("type",$_GET['type']);

	if($_GET["type"]=="delivery") {
		$addressHolder = "Reciever";
		$searFullName=$tmp["deliveryid"];
	} else {
		$searFullName=$tmp["pickupid"];
		$addressHolder = "Sender";
	}


	if(isset($_GET['add_id']))
	{

	$add_id = $_GET['add_id'];

	$seaDeliverAddArr[] = array('Search_On'    => 'userid',
		                      'Search_Value' => $userid,
		                      'Type'         => 'int',
		                      'Equation'     => '=',
		                      'CondType'     => 'and',
		                      'Prefix'       => '',
		                      'Postfix'      => '');
	$seaDeliverAddArr[] = array('Search_On'    => 'addressId',
		                      'Search_Value' => $add_id,
		                      'Type'         => 'int',
		                      'Equation'     => '=',
		                      'CondType'     => 'and',
		                      'Prefix'       => '',
		                      'Postfix'      => '');
	$deliaddress = $clientAddressMasterObj->getClientAddress('null',$seaDeliverAddArr);
	$deliaddress=$deliaddress[0];
	//echo "<pre>";print_r($_SESSION);die();

		if($tmp['flag']=="international"){
			if($_GET['type']=="pickup"){
				$source_details = 'Australia';
				$source_country = 'Australia';
				$destination_country = $deliaddress->country;
			}else{
				$source_country = $_SESSION['international_country_name'];
				$destination_country = $deliaddress->country;
				/*
				$seaArr[] = array('Search_On'    => 'id',
                      'Search_Value' => $destination_country,
                      'Type'         => 'string',
                      'Equation'     => '=',
                      'CondType'     => '',
                      'Prefix'       => '',
                      'Postfix'      => '');
				$InternationalZoneData=$InternationalZoneMasterObj->getInternationalZones('null',$seaArr);
				$internationaName=$InternationalZoneData[0];
				$source_country = $internationaName->country;
				*/
			}

			$same_page = (strtolower($source_country)==strtolower($destination_country))?('false'):('true');
			//echo $source_country."-- destination".$destination_country;
			$destination = "country";
		}else {
			   $deliver_data = explode(" ",$searFullName);


			//$deliver_suburb=$deliver_data[0];
			 $deliver_suburb = (count($deliver_data)==3)?($deliver_data[0]):($deliver_data[0].' '.$deliver_data[1]);
			 $receiver_suburb= $deliaddress->suburb;

			$length = strlen($searFullName);
    	    $start = $length - 4;
    		$deliver_postcode = substr($searFullName , $start ,4);

			//$deliver_postcode = (count($deliver_data)==3)?($deliver_data[2]):($deliver_data[3]);
			$receiver_postcode=  $deliaddress->postcode;

			$same_page = (strtolower(trim($deliver_suburb))==strtolower(trim($receiver_suburb)) && in_array($receiver_postcode,$deliver_data))?('false'):('true');
			$destination = "suburb/postcode";

			$source_country = $deliver_suburb.'/'.$deliver_postcode;
		}

		if(isset($same_page) && $same_page=='false')
			{
			//header("Location:".FILE_BOOKING."?type=delivery&add_id=".$add_id);
			$__Session->SetValue($__Session->GetValue("type")."_add_from_book",1);
			$__Session->Store();
			//header("Location:".FILE_BOOKING."?type=".$__Session->GetValue("type")."&add_id=".$add_id . $appendVal);
			$__Session->ClearValue("fromBooking");
				if(isset($tmp["flag"])){

						header("Location:".FILE_ADDRESSES."?type=".$__Session->GetValue("type")."&add_id=".$add_id . $appendVal);
						exit();
				}

			}else{
				$error = $addressHolder . "  " . $destination." should be ".$source_country.'.';
			}
	}

	/*echo "<pre>";
	print_r($searFullName);
	echo "</pre>";*/
	//exit();
	$pickupseaArr[0] = array('Search_On'    => 'FullName',
                      'Search_Value' => $searFullName,
                      'Type'         => 'string',
                      'Equation'     => '=',
                      'CondType'     => '',
                      'Prefix'       => '',
                      'Postfix'      => '');
	$PostCodeDataObj = $PostCodeMasterObj->getPostCode('null',false,$pickupseaArr);
	$Pickupvalue=$PostCodeDataObj[0];

	$session_data = json_decode($_SESSION['Thesessiondata']['_sess_login_userdetails'],true);
	$userid = $session_data['user_id'];

}else{/*
	$seaArr1[] = array('Search_On'    => 'userid',
	                      'Search_Value' => $userid,
	                      'Type'         => 'int',
	                      'Equation'     => '=',
	                      'CondType'     => 'AND',
	                      'Prefix'       => '',
	                      'Postfix'      => '');
$optArr1[]	=	array('Order_By'   => 'surname',
	                      'Order_Type' => 'asc');
$clientAddressData = $clientAddressMasterObj->GetClientAddress('null',$seaArr1,$optArr1);*/
}
$seaArr1[] = array('Search_On'    => 'userid',
	                      'Search_Value' => $userid,
	                      'Type'         => 'int',
	                      'Equation'     => '=',
	                      'CondType'     => 'AND',
	                      'Prefix'       => '',
	                      'Postfix'      => '');
//$tmp['flag']!="international"
if($_GET["type"]!="" && isset($_GET["type"]) && $tmp['flag']!="international") {

	$pickup_data = explode(" ",$searFullName);
	if(isset($pickup_data) && !empty($pickup_data) && count($pickup_data)==3){
		$suburb =  $pickup_data[0];
		$state =   $pickup_data[1];
		$postcode = $pickup_data[2];
	}elseif (isset($pickup_data) && !empty($pickup_data) && count($pickup_data)==4) {
		# code...
		$suburb =  $pickup_data[0]." ".$pickup_data[1];
		$state =   $pickup_data[2];
		$postcode = $pickup_data[3];
	}elseif (isset($pickup_data) && !empty($pickup_data) && count($pickup_data)==5) {
		# code...
		$suburb =   $pickup_data[0]." ".$pickup_data[1]." ".$pickup_data[2];
		$state =    $pickup_data[3];
		$postcode = $pickup_data[4];
	}elseif (isset($pickup_data) && !empty($pickup_data) && count($pickup_data)==6) {
		# code...
		$suburb =  $pickup_data[0]." ".$pickup_data[1]." ".$pickup_data[2]." ".$pickup_data[3];
		$state =   $pickup_data[4];
		$postcode = $pickup_data[5];
	}
	$seaArr1[] = array('Search_On'    => 'suburb',
                      'Search_Value' => $suburb,
                      'Type'         => 'string',
                      'Equation'     => '=',
                      'CondType'     => 'AND',
                      'Prefix'       => '',
                      'Postfix'      => '');
    $seaArr1[] = array('Search_On'    => 'state',
                      'Search_Value' => $state,
                      'Type'         => 'string',
                      'Equation'     => '=',
                      'CondType'     => 'AND',
                      'Prefix'       => '',
                      'Postfix'      => '');
    $seaArr1[] = array('Search_On'    => 'postcode',
                      'Search_Value' => $postcode,
                      'Type'         => 'string',
                      'Equation'     => '=',
                      'CondType'     => 'AND',
                      'Prefix'       => '',
                      'Postfix'      => '');
}elseif ($_GET["type"]!="" && isset($_GET["type"]) && $tmp['flag']=="international") {
	# code...

	if($_GET["type"]!="" && isset($_GET["type"]) && $_GET["type"]=='delivery'){

		$destination_country = $_SESSION['international_country_name'];

		$seaArr1[] = array('Search_On'    => 'country',
                      'Search_Value' => $destination_country,
                      'Type'         => 'string',
                      'Equation'     => '=',
                      'CondType'     => 'AND',
                      'Prefix'       => '',
                      'Postfix'      => '');
	}elseif ($_GET["type"]!="" && isset($_GET["type"]) && $_GET["type"]=='pickup') {
		# code...
		$pickup_data = explode(" ",$searFullName);
		if(isset($pickup_data) && !empty($pickup_data) && count($pickup_data)==3){
			$suburb =  $pickup_data[0];
			$state =   $pickup_data[1];
			$postcode = $pickup_data[2];
		}elseif (isset($pickup_data) && !empty($pickup_data) && count($pickup_data)==4) {
			# code...
			$suburb =  $pickup_data[0]." ".$pickup_data[1];
			$state =   $pickup_data[2];
			$postcode = $pickup_data[3];
		}elseif (isset($pickup_data) && !empty($pickup_data) && count($pickup_data)==5) {
			# code...
			$suburb =   $pickup_data[0]." ".$pickup_data[1]." ".$pickup_data[2];
			$state =    $pickup_data[3];
			$postcode = $pickup_data[4];
		}elseif (isset($pickup_data) && !empty($pickup_data) && count($pickup_data)==6) {
			# code...
			$suburb =  $pickup_data[0]." ".$pickup_data[1]." ".$pickup_data[2]." ".$pickup_data[3];
			$state =   $pickup_data[4];
			$postcode = $pickup_data[5];
		}
		$seaArr1[] = array('Search_On'    => 'suburb',
	                      'Search_Value' => $suburb,
	                      'Type'         => 'string',
	                      'Equation'     => '=',
	                      'CondType'     => 'AND',
	                      'Prefix'       => '',
	                      'Postfix'      => '');
	    $seaArr1[] = array('Search_On'    => 'state',
	                      'Search_Value' => $state,
	                      'Type'         => 'string',
	                      'Equation'     => '=',
	                      'CondType'     => 'AND',
	                      'Prefix'       => '',
	                      'Postfix'      => '');
	    $seaArr1[] = array('Search_On'    => 'postcode',
	                      'Search_Value' => $postcode,
	                      'Type'         => 'string',
	                      'Equation'     => '=',
	                      'CondType'     => 'AND',
	                      'Prefix'       => '',
	                      'Postfix'      => '');
	}

}



/*echo "<pre>";
print_r($seaArr1);
echo "</pre>";*/
    /*
	$seaArr1[] = array('Search_On'    => 'firstname',
	                      'Search_Value' => $first_name,
	                      'Type'         => 'string',
	                      'Equation'     => 'LIKE',
	                      'CondType'     => 'AND',
	                      'Prefix'       => '',
	                      'Postfix'      => '');
	$another_array[] = array('Search_On'    => 'userid',
	                      'Search_Value' => $userid,
	                      'Type'         => 'int',
	                      'Equation'     => '=',
	                      'CondType'     => 'AND',
	                      'Prefix'       => '',
	                      'Postfix'      => '');
    $another_array[] = array('Search_On'    => 'firstname',
	                      'Search_Value' => $first_name,
	                      'Type'         => 'string',
	                      'Equation'     => 'NOT LIKE',
	                      'CondType'     => 'AND',
	                      'Prefix'       => '',
	                      'Postfix'      => '');

	/*$optArr1[]	=	array('Order_By'   => 'firstname',
	                       'Order_Type' => 'asc');
	$optArr1[]	=	array('Order_By'   => 'surname',
	                      'Order_Type' => 'asc');
	*/
	    $optArr1[]	=	array('Order_By' => 'surname','Order_Type' => 'asc');
		$i=0;
		$clientAddressData1 = $clientAddressMasterObj->GetClientAddress('null',$seaArr1,$optArr1);
		/*$clientAddressData2 = $clientAddressMasterObj->GetClientAddress('null',$another_array,$optArr1);*/

		if($clientAddressData1){
			$clientAddressData = new stdClass();
			foreach ($clientAddressData1 as $key => $value){
				$clientAddressData->{$i} = $value;
				$i = $i+1;
			}
		}
		/*
		if($clientAddressData2){
			foreach ($clientAddressData2 as $key => $value){
				$clientAddressData->{$i} = $value;
				$i = $i+1;
			}
		}
		*/

$base = basename($_SERVER['HTTP_REFERER']);
$tot = 'find';
$AddressCnt1 = count((array)$clientAddressData1);
$AddressCnt2 = count((array)$clientAddressData2);
$AddressCnt = $AddressCnt1 + $AddressCnt2;
//print_r($_SERVER) ;

$booking_details=$__Session->GetValue("booking_details");
$service_name= $booking_details["service_name"];
/*$userSeaArr[]     = array('Search_On'=>'userid', 'Search_Value'=>SES_USER_ID, 'Type'=>'int', 'Equation'=>'=', 'CondType'=>'AND', 'Prefix'=>'','Postfix'=>'');
$Users            = $UserMasterObj->getUser(null, $userSeaArr);
$Users            = $Users[0];*/
$User= $__Session->GetValue('_sess_login_userdetails');

/*foreach ($clientAddressData as $data){

}

print_r($clientAddressData);*/
 $type = $__Session->GetValue("type");

 if($__Session->GetValue("type")!=""){
	$button_url = SITE_URL.FILE_ADDRESSES."?type=".$__Session->GetValue("type").$appendPara;
}else{
	$button_url = SITE_URL.FILE_ADDRESS_BOOK;
}
//if((($_GET['type'] != '') && $base=='booking.php') || $service_name != '' ){
if($service_name != '' ){
	if(defined('SES_USER_ID')){
			$back_url = FILE_BOOKING_WITH_ADDRESS;
	}else {
			$back_url = FILE_BOOKING;
	}

}else{
	$back_url = FILE_BOOKING_RECORDS;
}


require_once( DIR_WS_SITE_CURRENT_TEMPLATE . FILE_MAIN_INTERFACE); /* This include once is used for the html integration */
?>
