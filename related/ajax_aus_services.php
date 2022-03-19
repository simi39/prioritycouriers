<?php
session_start();
require_once("../lib/common.php");
require_once(DIR_WS_CURRENT_LANGUAGE . "index.php");
require_once(DIR_WS_MODEL . "SupplierData.php");
require_once(DIR_WS_MODEL . "SupplierMaster.php");
require_once(DIR_WS_MODEL . "ServiceMaster.php");
require_once(DIR_WS_MODEL . "ServicePageMaster.php");
require_once(DIR_WS_MODEL . "ItemTypeMaster.php");

$ItemTypeMasterObj = new ItemTypeMaster();
$ItemTypeMasterObj = $ItemTypeMasterObj->create();
$ObjServiceMaster	      = ServiceMaster::Create();
$ServiceData		      = new ServiceData();
$ObjServicePageIndexMaster = new ServicePageMaster();
$ObjServicePageIndexMaster	= $ObjServicePageIndexMaster->Create();
$ServicePageData		= new ServicePageData();

$pickup  = valid_input($_POST['pickup']);
$deliver = valid_input($_POST['deliver']);
$servicepagename = $_POST['servicepagename'];
$interId = $_POST['inter_country'];
$inter_item_type = $_POST['item'];
$Svalidation = false;
if(isset($interId) && $interId == 'SELECT COUNTRY')
{
	$err['interError'] = SELECT_INTERNATIONAL_COUNTRY;
}

if(isset($interId) && $interId != 'SELECT COUNTRY' && $interId !='')
{
	$err['interError'] = isNumeric($interId, COMMON_NUMERIC_VAL);
}

if(!empty($err['interError']))
{
	logOut();
}
if($interId !='')
{
	$service_item_type = 'international';
	$item_type = $inter_item_type;
	$result = '<input type="hidden" id="servicepagename" name="servicepagename" value="international" />'; /* international services */
	//exit();
}
if($pickup == 'PICK UP SUBURB/POSTCODE'){
	$err['PICKUPNOTEXISTS'] = SELECT_PICKUP_ITEM;	
}
if(!empty($pickup)){
	$err['PICKUPNOTEXISTS'] = chkStr(valid_input($_POST['pickup']));
}

if($deliver == 'DELIVERY SUBURB/POSTCODE'){
	$err['DELIVERNOTEXISTS'] = SELECT_DELIVER_ITEM;	
}
if(!empty($deliver)){
	$err['DELIVERNOTEXISTS'] = chkStr(valid_input($deliver));
}
if(isset($err)){
foreach($err as $key => $Value) {
	if($Value != '') {
		$Svalidation=true;
	}
}
}
$flag =1;
if($pickup != "PICK UP SUBURB/POSTCODE" && $Svalidation == false && $interId=='' && $inter_item_type==''){
	$o_st_city_zone = getDirectZoneFromSt($pickup); /* Direct Zones from startrack table */
	$pic_msg_arr = getMessengerZone($pickup); /* zone from messenger */
	$o_city_name = $pic_msg_arr['Name'];
	$o_city_postcode = $pic_msg_arr['Postcode'];
	$o_city_msg_arr = getMessengerValid($o_city_name,$o_city_postcode);
	$o_city_msg_courier = $o_city_msg_arr['Courier'];
	$o_city_msg_state = $o_city_msg_arr['State'];
	$pickupid = $pic_msg_arr['id'];
}

if(($deliver != "ENTER SUBURB OR POSTCODE") && ($flag == "1") && $Svalidation == false ){
		
	$d_st_city_zone = getDirectZoneFromSt($deliver); /* Direct Zones from startrack table */
	$del_msg_arr = getMessengerZone($deliver);
	$d_city_postcode = $del_msg_arr['Postcode'];
	$d_city_name = $del_msg_arr['Name'];
	$d_city_msg_arr = getMessengerValid($d_city_name,$d_city_postcode);
	$d_city_msg_courier = $d_city_msg_arr['Courier'];
	$d_city_msg_state = $d_city_msg_arr['State'];
	$deliverid = $del_msg_arr['id'];
}
/*
if($o_city_msg_courier == 'Y' && $d_city_msg_courier == 'Y')
{
	$msg_courier = true;
} */
$metrozones = explode(",",zones_within_australia);

if(!empty($metrozones))
{
	foreach($metrozones as $metrozone)
	{		
		if(strpos($metrozone,$o_st_city_zone)!='')
		{
			$o_metro_valid_state_arr = explode("-",$metrozone);
			$o_metro_valid_state = $o_metro_valid_state_arr[0];
		}
		if(strpos($metrozone,$d_st_city_zone)!='')
		{
			$d_metro_valid_state_arr = explode("-",$metrozone);
			$d_metro_valid_state = $d_metro_valid_state_arr[0];
		}
	}
}
if(empty($o_metro_valid_state) && empty($d_metro_valid_state))
{
	$o_metro_valid_state = $o_st_city_zone;	
	$d_metro_valid_state = $d_st_city_zone;
}
/*
echo $o_metro_valid_state."---".$d_metro_valid_state."</br>";
echo $o_st_city_zone."--".$d_st_city_zone;
exit();
*/
if($Svalidation == false && $o_metro_valid_state == $d_metro_valid_state && $interId=='')
{
	$service_item_type = 'sameday';
	
	$seaQuickArr = array();
	$seaQuickArr[] = array('Search_On' => 'item_name',
				  'Search_Value' => QUICKQUOTE,
				  'Type'         => 'string',
				  'Equation'     => '=',
				  'CondType'     => 'AND',
				  'Prefix'       => '',
				  'Postfix'      => '');
	$seaQuickArr[] = array('Search_On' => 'type',
				  'Search_Value' => $service_item_type,
				  'Type'         => 'string',
				  'Equation'     => '=',
				  'CondType'     => 'AND',
				  'Prefix'       => '',
				  'Postfix'      => '');
	$allItem = $ItemTypeMasterObj->getItemType(null,$seaQuickArr);
	$allItem = $allItem[0];
	$item_type = $allItem->item_id;
	if(isset($servicepagename) && $servicepagename=="sameday"){
		$servicename='sameday';
		$result="1";  //same service family is selected
		//exit();
	}else{
		$result = getItemTypeIndex($item,'3',$extra_para,null,'sameday').'$<input type="hidden" id="servicepagename" name="servicepagename" value="sameday" />'; /* applied for metro */
		$servicename='sameday';
	}
	
}elseif($Svalidation == false && $o_metro_valid_state != $d_metro_valid_state && $interId=='' && $inter_item_type ==''){
	$fieldArr = array("service.service_name","supplier_detail.supplier_name");
	$seaByArr = array();
	$supplier_id = 0;
	if($supplier_id == 0)
	{
		if($cond_metro == false)
		{
			$seaByArr[] = array('Search_On'=>'type', 'Search_Value'=>'1', 'Type'=>'string', 'Equation'=>'=', 'CondType'=>'and', 'Prefix'=>'(', 'Postfix'=>'');
			$seaByArr[] = array('Search_On'=>'type', 'Search_Value'=>'0', 'Type'=>'string', 'Equation'=>'=', 'CondType'=>'OR', 'Prefix'=>'', 'Postfix'=>')');
		}else
		{
			$seaByArr[] = array('Search_On'=>'type', 'Search_Value'=>'0', 'Type'=>'string', 'Equation'=>'=', 'CondType'=>'AND', 'Prefix'=>'', 'Postfix'=>'');
		}
		$seaByArr[] = array('Search_On'=>'supplier_id ', 'Search_Value'=>'0', 'Type'=>'string', 'Equation'=>'=', 'CondType'=>'', 'Prefix'=>'and', 'Postfix'=>'');

	}
	$seaByArr[] = array('Search_On'=>'deleted', 'Search_Value'=>'1', 'Type'=>'string', 'Equation'=>'=', 'CondType'=>'', 'Prefix'=>'and', 'Postfix'=>'');
	$seaByArr[] = array('Search_On'=>'status', 'Search_Value'=>'1', 'Type'=>'string', 'Equation'=>'=', 'CondType'=>'', 'Prefix'=>'and', 'Postfix'=>'');
	$tableJoins = "service LEFT JOIN supplier_detail ON supplier_detail.auto_id = service.supplier_id";
	$service_val = $ObjServiceMaster->getService($fieldArr,$seaByArr,null,null,null,null,$tableJoins);
	
	if(empty($service_val))
	{
		echo 0;
		exit();
	}elseif(isset($servicepagename) && $servicepagename=="overnight"){
		$servicename='overnight';
		$result="1"; //same service family is selected
		//exit();
	}else{
		$service_names = "";
		foreach($service_val as $val)
		{
			$service_names.= $val['service_name'];
		}
		if(!empty($service_names))
		{
			$service_item_type = 'overnight';
			$seaQuickArr = array();
			$seaQuickArr[] = array('Search_On' => 'item_name',
						  'Search_Value' => QUICKQUOTE,
						  'Type'         => 'string',
						  'Equation'     => '=',
						  'CondType'     => 'AND',
						  'Prefix'       => '',
						  'Postfix'      => '');
			$seaQuickArr[] = array('Search_On' => 'type',
						  'Search_Value' => 'domestic',
						  'Type'         => 'string',
						  'Equation'     => '=',
						  'CondType'     => 'AND',
						  'Prefix'       => '',
						  'Postfix'      => '');
			$allItem = $ItemTypeMasterObj->getItemType(null,$seaQuickArr);
			$allItem = $allItem[0];
			$item_type = $allItem->item_id;
			//$item_type = INTERSTATE_QUICK_ITEM_ID;
			$result = getItemTypeIndex($item,'3',$extra_para,null,'domestic').'$<input type="hidden" id="servicepagename" name="servicepagename" value="overnight" />'; /* startrack services */
			$servicename='overnight';
			
		}
	}
	
}
/*Start for the validation of items*/
$fieldArr=array("*");
$seaArr = array();
$seaArr[]=array('Search_On'=>'service_page_name', 'Search_Value'=>$service_item_type, 'Type'=>'string', 'Equation'=>'=', 'CondType'=>'AND', 'Prefix'=>'', 'Postfix'=>'');		
$data = $ObjServicePageIndexMaster->getServicePageName($fieldArr,$seaArr);

if(!empty($data))
{
	foreach ($data as $servicePageDetail)
	{
		
		
		if(isset($servicePageDetail['length_max']) && $servicePageDetail['length_max']!="")
		{
			$lengthStr = $servicePageDetail['length_max'];
		}
		if(isset($servicePageDetail['girth_max']) && $servicePageDetail['girth_max']!="")
		{
			$girthStr = $servicePageDetail['girth_max'];
		}
	}
}
/*End for the validation of items*/

echo $result."$".$lengthStr."$".$girthStr."#".$servicename;
exit();
?>