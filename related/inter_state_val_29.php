<?php
require_once("../lib/common.php");
require_once(DIR_WS_MODEL . "InternationalStateMaster.php");
/* Objects declaration */

$ObjInternationalStateMaster	= InternationalStateMaster::Create();
$InternationalStateData		= new InternationalStateData();
/* Objects declaration */

define(COMMON_SECURITY_ANSWER_ALPHANUMERIC,"Please enter alphanumeric values.");

if(isset($_GET) && !empty($_GET["letters"])){
	$q = addslashes(valid_input($_GET["letters"]));
	
	if(preg_match("/[^a-zA-Z0-9\s]/", $q))
	{
		echo COMMON_SECURITY_ANSWER_ALPHANUMERIC;
		exit();
	}
	
	if($q != "" && empty($valid)){
		$seaByArr = array();
		$optArr   = array();
		$fieldArr = array();
		
		if(!is_numeric($q)){
			$seaByArr[]=array('Search_On'=>'state', 'Search_Value'=>"$q%", 'Type'=>'string', 'Equation'=>'LIKE', 'CondType'=>'', 'Prefix'=>'', 'Postfix'=>'');
		}
		$optArr[]=	array('Order_By' => 'state','Order_Type' => 'asc');
		$fieldArr = array("state","state_code");
		
		$InternationalStateData = $ObjInternationalStateMaster->getInternationalState($fieldArr,$seaByArr,$optArr,0,10);
		
		if(!empty($InternationalStateData)){
    		foreach($InternationalStateData as $postcodeval){ 
    			$return_data .= $postcodeval['state']." ".$postcodeval['state_code'].",";
    		}
			echo $return_data;
		}
	}
	
}
?>
