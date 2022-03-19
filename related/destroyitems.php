<?php
session_start();
require_once("../lib/common.php");
require_once(DIR_WS_CURRENT_LANGUAGE . "index.php");
global $__Session;
unset($_SESSION['final_fuel_fee']);
unset($_SESSION['nett_due_amt']);
unset($_SESSION['total_new_charges']);
unset($_SESSION['total_due']);
unset($_SESSION['discountAmt']);
unset($_SESSION['couponCode']);
unset($_SESSION['total_gst']);
unset($_SESSION['total_tansit_gst']);
unset($_SESSION['total_gst_delivery']);
unset($_SESSION['total_delivery_fee']);
unset($_SESSION['coverage_rate']);
/*$booking_details_items = $__Session->GetValue("booking_details_items");
$booking_details= $__Session->GetValue("booking_details");*/
/*echo "<pre>";
print_r($booking_details);
echo"</pre>";
echo "<pre>";
print_r($booking_details_items);
echo"</pre>";
exit();*/
//unset($_SESSION['coverage_rate']);
$__Session->ClearValue("booking_details");
$__Session->ClearValue("service_details");
$__Session->ClearValue("booking_details_items");
$__Session->ClearValue("booking_id");
$__Session->ClearValue("auto_id");
$__Session->ClearValue("client_address_dilivery");
$__Session->ClearValue("client_address_pickup");
$__Session->ClearValue("commercial_invoice_id");
$__Session->ClearValue("commercial_invoice");
$__Session->ClearValue("commercial_invoice_item");
$__Session->Store();
//session_destroy();
//unset($_COOKIE['PHPSESSID']);

?>