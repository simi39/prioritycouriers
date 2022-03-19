<?php
session_start();
require_once("../lib/common.php");
require_once(DIR_WS_MODEL . "SupplierData.php");
require_once(DIR_WS_MODEL . "SupplierMaster.php");
require_once(DIR_WS_MODEL . "ServiceMaster.php");
	
$ObjServiceMaster	      = ServiceMaster::Create();
$ServiceData		      = new ServiceData();
$fieldArr = array("service.service_name","supplier_detail.supplier_name");
$seaByArr = array();
$supplier_id =4;
if($supplier_id == 4)
{
	$seaByArr[] = array('Search_On'=>'type', 'Search_Value'=>'1', 'Type'=>'string', 'Equation'=>'=', 'CondType'=>'and', 'Prefix'=>'', 'Postfix'=>'');
	$seaByArr[] = array('Search_On'=>'supplier_id ', 'Search_Value'=>'4', 'Type'=>'string', 'Equation'=>'=', 'CondType'=>'', 'Prefix'=>'and', 'Postfix'=>'');
}
$seaByArr[] = array('Search_On'=>'deleted', 'Search_Value'=>'1', 'Type'=>'string', 'Equation'=>'=', 'CondType'=>'', 'Prefix'=>'and', 'Postfix'=>'');
$seaByArr[] = array('Search_On'=>'status', 'Search_Value'=>'1', 'Type'=>'string', 'Equation'=>'=', 'CondType'=>'', 'Prefix'=>'and', 'Postfix'=>'');
$tableJoins = "service LEFT JOIN supplier_detail ON supplier_detail.auto_id = service.supplier_id";
$service_val = $ObjServiceMaster->getService($fieldArr,$seaByArr,null,null,null,null,$tableJoins);
if(empty($service_val))
{
	echo 0;
}else{
	$service_names = "";
	foreach($service_val as $val)
	{
		$service_names.= $val['service_name'];
	}
	echo valid_output($service_names);
}
?>