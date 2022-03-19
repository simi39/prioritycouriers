<?php
require_once("../lib/common.php");
require_once(DIR_WS_MODEL . "CountryMaster.php");

$CountryMasterObj = CountryMaster::Create();
$CountryDataobj= new CountryData();

define("COMMON_NUMERIC_VAL","Please enter numeric values only.");
$selectCountryId=$_POST['id'];
if(isset($_POST) && $_POST['id']!="")
{
	$err['CountryError'] = isNumeric($selectCountryId,COMMON_NUMERIC_VAL);
}
if(!empty($err['CountryError']))
{
	logOut();
}

$fieldArr = array("area_code");
$seaArr[] = array('Search_On'=>'countries_id', 'Search_Value'=>$selectCountryId, 'Type'=>'string', 'Equation'=>'=', 'CondType'=>'AND', 'Prefix'=>'','Postfix'=>'');
$CountryDataobj = $CountryMasterObj->getCountry($fieldArr,$seaArr);
$CountryDataobj = $CountryDataobj[0];
echo $CountryDataobj['area_code'];
exit();
?>