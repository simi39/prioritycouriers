<?php
/**
 * include common
 */
session_start();

require_once("../lib/common.php");
require_once(DIR_WS_CURRENT_LANGUAGE . "addressbook.php");
require_once(DIR_WS_MODEL ."BookingDetailsMaster.php");
require_once(DIR_WS_MODEL ."BookingItemDetailsMaster.php");
require_once(DIR_WS_MODEL ."InternationalZonesMaster.php");
require_once(DIR_WS_MODEL ."ClientAddressMaster.php");
require_once(DIR_WS_MODEL."PostCodeMaster.php");
require_once(DIR_WS_MODEL . "UserMaster.php");

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
$userid = SES_USER_ID;

if($_GET["type"]!="" && isset($_GET["type"])) {
	$tmp = $__Session->GetValue("booking_details");
	$__Session->SetValue("type",$_GET['type']);

	if($_GET["type"]=="delivery") {
		$addressHolder = "Reciever does not have addresses related with";
		$searFullName=$tmp["deliveryid"];
	} else {
		$searFullName=$tmp["pickupid"];
		$addressHolder = "Sender does not have addresses related with";
	}
}

	
	//echo $_GET['type'];
	if($tmp['flag']=="international" && isset($_GET['type']) && $_GET['type'] == 'delivery'){
		$source_country = $_SESSION['international_country_name'];
		$country = trim($_GET['country']);
		
		//echo $country."---".$source_country."</br>";
		$seaDeliverAddArr[] = array('Search_On'    => 'country',
						  'Search_Value' => $country,
						  'Type'         => 'string',
						  'Equation'     => '=',
						  'CondType'     => 'and',
						  'Prefix'       => '',
						  'Postfix'      => ''); 
		$deliaddress = $clientAddressMasterObj->getClientAddress('null',$seaDeliverAddArr);
		$deliaddress=$deliaddress[0];
		$destination_country = $deliaddress->country;
		$same_page = (strtolower($source_country)==strtolower($destination_country))?('false'):('true');
		//echo $source_country."-- destination".$destination_country;
		$destination = "country";

	}else{
		if(isset($_GET['suburb']) && !empty($_GET['suburb']) && isset($_GET['state']) && !empty($_GET['state']) && isset($_GET['postcode']) && !empty($_GET['postcode'])){
			$suburb = $_GET['suburb'];
			$state = $_GET['state'];
			$postcode = $_GET['postcode'];
		$seaDeliverAddArr[] = array('Search_On'    => 'userid',
						  'Search_Value' => $userid,
						  'Type'         => 'int',
						  'Equation'     => '=',
						  'CondType'     => 'and',
						  'Prefix'       => '',
						  'Postfix'      => ''); 
		$seaDeliverAddArr[] = array('Search_On'    => 'suburb',
	                      'Search_Value' => $suburb,
	                      'Type'         => 'string',
	                      'Equation'     => '=',
	                      'CondType'     => 'AND',
	                      'Prefix'       => '',
	                      'Postfix'      => '');
	    $seaDeliverAddArr[] = array('Search_On'    => 'state',
	                      'Search_Value' => $state,
	                      'Type'         => 'string',
	                      'Equation'     => '=',
	                      'CondType'     => 'AND',
	                      'Prefix'       => '',
	                      'Postfix'      => '');
	    $seaDeliverAddArr[] = array('Search_On'    => 'postcode',
	                      'Search_Value' => $postcode,
	                      'Type'         => 'string',
	                      'Equation'     => '=',
	                      'CondType'     => 'AND',
	                      'Prefix'       => '',
	                      'Postfix'      => '');  
		$deliaddress = $clientAddressMasterObj->getClientAddress('null',$seaDeliverAddArr);
		$deliaddress = $deliaddress[0];
		$searFullName = $suburb." ".$state." ".$postcode;
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
		$destination = "suburb or city and postcode";
		
		$source_country = '<span class="my_red">'.$deliver_suburb.'&nbsp;'.$deliver_postcode.'</span>';
	}
		
	}
	
	if(isset($same_page) && $same_page=='false'){

		$result['head'] = "success";
	}else{
		$result['error'] = $addressHolder . "  " . $destination."  ".$source_country.'.';
	}



echo json_encode($result);
exit();
?>
