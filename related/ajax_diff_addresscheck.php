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
		$addressHolder = "Reciever";
		$searFullName=$tmp["deliveryid"];
	} else {
		$searFullName=$tmp["pickupid"];
		$addressHolder = "Sender";
	}
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
//exit();
//echo "<pre>";print_r($deliaddress);die();

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
		$destination = "suburb or city and postcode";
		
		$source_country = '<span class="my_red">'.$deliver_suburb.'&nbsp;'.$deliver_postcode.'</span>';
	}
	//echo "same page:".$same_page;
	//exit();
	if(isset($same_page) && $same_page=='false')
		{
		//header("Location:".FILE_BOOKING."?type=delivery&add_id=".$add_id);
		$__Session->SetValue($__Session->GetValue("type")."_add_from_book",1);
		$__Session->Store();	
		//header("Location:".FILE_BOOKING."?type=".$__Session->GetValue("type")."&add_id=".$add_id . $appendVal);	
		$__Session->ClearValue("fromBooking");
			if(isset($tmp["flag"])){
				
				$result['head'] = FILE_ADDRESSES."?type=".$__Session->GetValue("type")."&add_id=".$add_id . $appendVal; 
				//header("Location:../".FILE_ADDRESSES."?type=".$__Session->GetValue("type")."&add_id=".$add_id . $appendVal);	
				
				//exit();
			}
	
		}else{
			$result['error'] = $addressHolder . "  " . $destination." should be ".$source_country.'.';
			//echo $error;
			//exit();
			
		}
}
echo json_encode($result);
exit();
?>