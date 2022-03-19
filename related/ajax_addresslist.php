<?php
require_once("../lib/common.php");
require_once(DIR_WS_CURRENT_LANGUAGE . "addresses.php");
require_once(DIR_WS_MODEL ."ClientAddressMaster.php");

/* Objects declaration */
$objClientAddressMaster = ClientAddressMaster::create();
$objClientAddressData =  new ClientAddressData();
/* Objects declaration */

if(isset($_POST["letters"]) && $_POST["letters"] != ""){
	$letters = valid_input($_POST["letters"]);
 $addtype = valid_input($_POST['addType']);
 $err['letters'] = checkStr($letters);
 $err['addtype'] = checkStr($addtype);
 $q = addslashes($letters);
 $seaArr9 = array();
 $BookingAddressData = $__Session->GetValue("booking_details");
 
 if(defined('SES_USER_ID')){
	$user_id = SES_USER_ID;
	
	$seaArr9[]	=	array('Search_On' => 'userid',
							  'Search_Value' => $user_id,
							  'Type'         => 'int',
							  'Equation'     => '=',
							  'CondType'     => 'AND',
							  'Prefix'       => '',
							  'Postfix'      => '');
	foreach($err as $key => $Value) {
		if($Value != '') {
			$Svalidation=true;
		}
	}
	
	if($q != "" && $Svalidation == false){
	$seaByArr = array();
	$optArr   = array();
	$fieldArr = array();	
	
	if(isset($addtype)){
		if($addtype == "Pickup"){
			$adressType = trim($BookingAddressData['pickupid']);
			
		}else{
		
			$adressType = trim($BookingAddressData['deliveryid']);
			
		}
		
	}
	$servicepageName = trim($BookingAddressData['servicepagename']);
	
	$explode_add	= explode(" ",$adressType);
	$explode_add 	= array_reverse($explode_add);
	//$suburbName 		= $explode_add[2];
	//if(sizeof($explode_add) > 3 ){
		//$suburbName 	= $explode_add[3] ." " .  $explode_add[2];
	//} 
	$suburbArr = array();
	if(sizeof($explode_add) >= 2 ){
		
		for($i=2;$i<sizeof($explode_add);$i++)
		{
			$suburbArr[] = $explode_add[$i];
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
	$stateCode = $explode_add[1];
	$Postcode = $explode_add[0];
	$seaArr9[]	=	array('Search_On'    => 'firstname',
						  'Search_Value' => "$q%",
						  'Type'         => 'string',
						  'Equation'     => 'LIKE',
						  'CondType'     => 'AND',
						  'Prefix'       => '',
						  'Postfix'      => '');
	$seaArr9[]	=	array('Search_On'    => 'suburb',
						  'Search_Value' => $suburbName,
						  'Type'         => 'string',
						  'Equation'     => '=',
						  'CondType'     => 'AND',
						  'Prefix'       => '',
						  'Postfix'      => '');

														
	$seaArr9[]	=	array('Search_On'    => 'state',
						  'Search_Value' => $stateCode,
						  'Type'         => 'string',
						  'Equation'     => '=',
						  'CondType'     => 'AND',
						  'Prefix'       => '',
						  'Postfix'      => ''); 
	$seaArr9[]	=	array('Search_On'    => 'postcode',
						  'Search_Value' => $Postcode,
						  'Type'         => 'int',
						  'Equation'     => '=',
						  'CondType'     => 'AND',
						  'Prefix'       => '',
						  'Postfix'      => '');                                                                                     
	
	
	$clientAddressData_t=$objClientAddressMaster->GetClientAddress('null',$seaArr9,'null',0,10);
	
	if(empty($clientAddressData_t))
	{
		echo 0;
		exit();
	}
	if(!empty($clientAddressData_t)){
		$i=1;
		$address = array();
		
		foreach($clientAddressData_t as $addressDataRow){
			
			
			$address[]=array_filter(array("id"=>$addressDataRow['addressId'],"firstname"=>$addressDataRow['firstname'],"lastname"=>$addressDataRow['surname'],"company"=>$addressDataRow['company'],"address"=>$addressDataRow['address1'],"address2"=>$addressDataRow['address2'],"address3"=>$addressDataRow['address3'],"email"=>$addressDataRow['email'],"contact"=>$addressDataRow['phoneno'],"mobileno"=>$addressDataRow['mobileno'],"area_code"=>$addressDataRow['area_code'],"m_area_code"=>$addressDataRow['m_area_code']));
			
			//echo $address[$i]['firstname']."</br>";
			$i++;
		}
	}	
	
	
	echo json_encode($address);
	exit();	
}
}
}

  

?>