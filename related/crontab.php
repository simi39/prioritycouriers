<?php
require_once("../lib/common.php");
require_once(DIR_WS_MODEL."TokenTableMaster.php");
require_once(DIR_WS_MODEL."TokenTableData.php");
require_once(DIR_WS_MODEL . "IPAddressMaster.php");
require_once(DIR_WS_MODEL . "ForgotPassEmailIdAddressMaster.php");
require_once(DIR_WS_MODEL . "ForgotPassIPAddressMaster.php");
require_once(DIR_WS_MODEL . "UserMaster.php");

$TokenTableMaster	      = new TokenTableMaster();
$TokenTableMaster	      = $TokenTableMaster->Create();
$TokenTableData		      = new TokenTableData();
$IPAddressMasterObj = new IPAddressMaster();
$IPAddressMasterObj = $IPAddressMasterObj->Create();
$ForgotPassEmailIdAddressMasterObj = new ForgotPassEmailIdAddressMaster();
$ForgotPassEmailIdAddressMasterObj = $ForgotPassEmailIdAddressMasterObj->Create();
$ForgotPassIPAddressMasterObj = new ForgotPassIPAddressMaster();
$ForgotPassIPAddressMasterObj = $ForgotPassIPAddressMasterObj->Create();
$UserMasterObj = new UserMaster();
$UserMasterObj = $UserMasterObj->Create();

$fieldname = 'stamp <';
/*Start this will delete 15 min csrf token */
$exp = time() - (15 * 60);
$expiry_time_taken = 15;
$TokenTableMaster->deleteTokenTable($exp,$fieldname,true,$expiry_time_taken);
/*End this will delete 15 min csrf token */
/*Start this will delete 24 hr csrf token */
$oldexp = time() - (24 * 60 * 60);
$expiry_24_time_taken = 24;
$TokenTableMaster->deleteTokenTable($oldexp,$fieldname,true,$expiry_24_time_taken);
/*End this will delete 24 hr csrf token */
/*Start below query will delete data from table login_attempts which are 15 min old */
$queryString = true;
$IPAddressMasterObj->deleteIPAddress('',$queryString);
/*End below query will delete data from table login_attempts which are 15 min old */
/*Start below query will delete data from table forgotpass_email_attempts which are 15 min old */
$ForgotPassEmailIdAddressMasterObj->deleteForgotPassEmailIdAddress('',$queryString);
/*End below query will delete data from table forgotpass_email_attempts which are 15 min old */
/*Start below query will delete data from table forgotpass_ipaddress_attempts which are 15 min old */
$ForgotPassIPAddressMasterObj->deleteForgotPassIPAddress('',$queryString);
/*End below query will delete data from table forgotpass_ipaddress_attempts which are 15 min old */
$UserMasterObj->editUser('','','',true);
?>