<?php
session_start();
require_once("../lib/common.php");
require_once(DIR_WS_MODEL ."ClientAddressMaster.php");
require_once(DIR_WS_MODEL ."CountryMaster.php");
require_once(DIR_WS_MODEL . "UserMaster.php");
require_once(DIR_WS_CURRENT_LANGUAGE . "addressbook.php");

$objClientAddressMaster = ClientAddressMaster::Create();
$objClientAddressData=new ClientAddressData();

$UserMasterObj    = UserMaster::Create();
$UserData         = new UserData();

$action = $_POST['action'];

if(isset($action) && $action!='')
{
	$err['action'] = chkSmall(valid_input($action));
}
if(!empty($err['action']))
{
	logOut();
}
$userid = $_POST['user_id'];
if(isset($userid) && $userid!='')
{
	$err['userid'] = isNumeric(valid_input($userid),ERROR_ENTER_NUMERIC_VALUE);
}
if(!empty($err['userid']))
{
	logOut();
}

$receiverfirstname = $_POST['receiver_first_name'];
if(isset($receiverfirstname) && $receiverfirstname!='')
{
	$err['receiverfirstname'] = checkName(valid_input($receiverfirstname));
}
if(!empty($err['receiverfirstname']))
{
	logOut();
}
$receiverlastname = $_POST['receiver_surname'];
if(isset($receiverlastname) && $receiverlastname!='')
{
	$err['receiverlastname'] = checkName(valid_input($receiverlastname));
}
if(!empty($err['receiverlastname']))
{
	logOut();
}
$receivercompany = $_POST['receiver_company_name'];
$address_1 = $_POST['receiver_address_1'];
$address_2 = $_POST['receiver_address_2'];
$address_3 = $_POST['receiver_address_3'];

$suburb = $_POST['receiver_suburb'];
$state = $_POST['receiver_state'];
$postcode = $_POST['receiver_postcode'];
$email = $_POST['receiver_email'];
$countrycode = $_POST['receiver_mb_area_code'];
$phonenumber = $_POST['receiver_contact_no'];
$seaArr = array();
$seaArr[]	=	array('Search_On'    => 'userid',
			                      'Search_Value' => $userid,
			                      'Type'         => 'int',
			                      'Equation'     => '=',
			                      'CondType'     => 'AND',
			                      'Prefix'       => '',
			                      'Postfix'      => '');
$seaArr[]	=	array('Search_On'    => 'firstname',
					  'Search_Value' => $receiverfirstname,
					  'Type'         => 'string',
					  'Equation'     => '=',
					  'CondType'     => 'AND',
					  'Prefix'       => '',
					  'Postfix'      => '');
$seaArr[]	=	array('Search_On'    => 'surname',
					  'Search_Value' => $receiverlastname,
					  'Type'         => 'string',
					  'Equation'     => '=',
					  'CondType'     => 'AND',
					  'Prefix'       => '',
					  'Postfix'      => '');
$seaArr[]	=	array('Search_On'    => 'company',
						'Search_Value' => $receivercompany,
						'Type'         => 'string',
						'Equation'     => '=',
						'CondType'     => 'AND',
						'Prefix'       => '',
						'Postfix'      => '');

$seaArr[]	=	array('Search_On'    => 'suburb',
						'Search_Value' => $suburb,
						'Type'         => 'string',
						'Equation'     => '=',
						'CondType'     => 'AND',
						'Prefix'       => '',
						'Postfix'      => '');
$seaArr[]	=	array('Search_On'    => 'state',
						'Search_Value' => $state,
						'Type'         => 'string',
						'Equation'     => '=',
						'CondType'     => 'AND',
						'Prefix'       => '',
						'Postfix'      => '');
$seaArr[]	=	array('Search_On'    => 'postcode',
						'Search_Value' => $postcode,
						'Type'         => 'string',
						'Equation'     => '=',
						'CondType'     => 'AND',
						'Prefix'       => '',
						'Postfix'      => '');


$clientAddressData_t=$objClientAddressMaster->GetClientAddress('null',$seaArr);
$clientAddressData_t = $clientAddressData_t[0];
$totalrows = count(array($clientAddressData_t));
//echo "total rows:".$totalrows;
/* This is to check from user_master this address is present or not */
$seaUserArr = array();
$seaUserArr[]	=	array('Search_On'    => 'userid',
			                      'Search_Value' => $userid,
			                      'Type'         => 'int',
			                      'Equation'     => '=',
			                      'CondType'     => 'AND',
			                      'Prefix'       => '',
			                      'Postfix'      => '');
$seaUserArr[]	=	array('Search_On'    => 'firstname',
					  'Search_Value' => $receiverfirstname,
					  'Type'         => 'string',
					  'Equation'     => '=',
					  'CondType'     => 'AND',
					  'Prefix'       => '',
					  'Postfix'      => '');
$seaUserArr[]	=	array('Search_On'    => 'lastname',
					  'Search_Value' => $receiverlastname,
					  'Type'         => 'string',
					  'Equation'     => '=',
					  'CondType'     => 'AND',
					  'Prefix'       => '',
					  'Postfix'      => '');
$seaUserArr[]	=	array('Search_On'    => 'suburb',
						'Search_Value' => $suburb,
						'Type'         => 'string',
						'Equation'     => '=',
						'CondType'     => 'AND',
						'Prefix'       => '',
						'Postfix'      => '');
$seaUserArr[]	=	array('Search_On'    => 'state',
						'Search_Value' => $state,
						'Type'         => 'string',
						'Equation'     => '=',
						'CondType'     => 'AND',
						'Prefix'       => '',
						'Postfix'      => '');
$seaUserArr[]	=	array('Search_On'    => 'postcode',
						'Search_Value' => $postcode,
						'Type'         => 'string',
						'Equation'     => '=',
						'CondType'     => 'AND',
						'Prefix'       => '',
						'Postfix'      => '');
$Users = $UserMasterObj->getUser(null, $seaUserArr);
$Users = $Users[0];
$profileAddress = count(array($Users));
/* This is to check from user_master this address is present or not */

if((isset($totalrows) && $totalrows == 1) || (isset($profileAddress) && $profileAddress == 1))
{
	echo "1";
}else{
	$_SESSION['chk_del_address']=1;
	echo "0";
}
exit();
?>
