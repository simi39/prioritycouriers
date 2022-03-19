<?php
require_once("../lib/common.php");
require_once(DIR_WS_MODEL ."ClientAddressMaster.php");
require_once(DIR_WS_MODEL ."CountryMaster.php");

$objClientAddressMaster = ClientAddressMaster::Create();
$objClientAddressData=new ClientAddressData();

$action = $_POST['action'];

if(isset($action) && $action!='')
{
	$err['action'] = chkSmall(valid_input($action));
}
if(!empty($err['action']))
{
	logOut();
}
$userid = $_POST['userid'];
if(isset($userid) && $userid!='')
{
	$err['userid'] = isNumeric(valid_input($userid),ERROR_ENTER_NUMERIC_VALUE);
}
if(!empty($err['userid']))
{
	logOut();
}
$firstname = $_POST['firstname'];
if(isset($firstname) && $firstname!='')
{
	$err['firstname'] = checkName(valid_input($firstname));
}
if(!empty($err['firstname']))
{
	logOut();
}
$lastname = $_POST['lastname'];
if(isset($lastname) && $lastname!='')
{
	$err['lastname'] = checkName(valid_input($lastname));
}
if(!empty($err['lastname']))
{
	logOut();
}
$seaArr = array();
$seaArr[]	=	array('Search_On'    => 'userid',
			                      'Search_Value' => $userid,
			                      'Type'         => 'int',
			                      'Equation'     => '=',
			                      'CondType'     => 'AND',
			                      'Prefix'       => '',
			                      'Postfix'      => '');
$seaArr[]	=	array('Search_On'    => 'firstname',
					  'Search_Value' => $firstname,
					  'Type'         => 'string',
					  'Equation'     => '=',
					  'CondType'     => 'AND',
					  'Prefix'       => '',
					  'Postfix'      => '');
$seaArr[]	=	array('Search_On'    => 'surname',
					  'Search_Value' => $lastname,
					  'Type'         => 'string',
					  'Equation'     => '=',
					  'CondType'     => 'AND',
					  'Prefix'       => '',
					  'Postfix'      => '');
$clientAddressData_t=$objClientAddressMaster->GetClientAddress('null',$seaArr);
if($clientAddressData_t)
{
	echo 1;
}else
{
	echo 0;
}
?>