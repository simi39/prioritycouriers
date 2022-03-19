<?php
require_once("../lib/common.php");
require_once(DIR_WS_CURRENT_LANGUAGE . "english.php");
require_once(DIR_WS_MODEL ."NewsLetterMaster.php");
$objNewsLetterMaster = NewsLetterMaster::Create();
$objNewsLetterData = new NewsLetterData();

if(isset($_POST['email']) && $_POST['email']!="")
{
	$err['email'] = checkEmailPattern($_POST['email'],"Please enter valid email address.");
}
if(empty($err['email']))
{
	$userSeaArr = array();
		  
	$userSeaArr[] = array('Search_On'=>'email_id', 'Search_Value'=>$_POST['email'], 'Type'=>'string', 'Equation'=>'Like', 'CondType'=>'AND', 'Prefix'=>'','Postfix'=>'');
	$NewsLetterData  = $objNewsLetterMaster->getNewsLetter(null, $userSeaArr);
	$NewsLetterData = $NewsLetterData[0];
	if(empty($NewsLetterData))
	{
		$objNewsLetterData->email_id = $_POST['email'];
		$objNewsLetterData->status = 1;
		$objNewsLetterMaster->addNewsLetter($objNewsLetterData);
	}
	
	echo json_encode(1);
	exit();
}else{
	echo json_encode(0);
	exit();
}

?>