<?php

	/*## coupon_management.php ##*/
	
	define("ADMIN_COUPON_HEADING", "Coupon Management");
	define("ADD_NEW_COUPON", "ADD NEW COUPON");
	define("COUPON_NAME", "Coupon Name");
	define("COUPON_CODE", "Coupon Code");
	define("COUPON_START_DATE", "Start Date");
	define("COUPON_END_DATE", "End Date");
	define("COUPON_USAGE", "Coupon Usage");
	define("STATUS", "Status");
	define("ADMIN_COUPON_MANAGEMENT_HELPTEXT1", "[A short name for the coupon]");
	define("ADMIN_COUPON_MANAGEMENT_HELPTEXT2", "[Description: The value of the discount for the coupon, either fixed or add a % on the end for a percentage discount.]");
	define("ADMIN_COUPON_MANAGEMENT_HELPTEXT3", "[You can enter your own code here, or leave blank for an auto generated one.]");
	define("ADMIN_COUPON_MANAGEMENT_HELPTEXT4", "[The date the coupon will be valid from]");
	define("ADMIN_COUPON_MANAGEMENT_HELPTEXT5", "[The date the coupon expires]");
	define("ADMIN_COUPON_MANAGEMENT_HELPTEXT6", "[You can select coupon usage one time / more than one time]");
	define("ADMIN_SEARCH_COUPON_NAME", "Search Coupon Name");
	define("ADMIN_SEARCH_COUPON_AMOUNT", "Search Coupon Amount");
	define("ADMIN_SEARCH_COUPON_CODE", "Search Coupon Code");
	
	define("ADMIN_ADD_HEADING","Add Coupon");
	define("ADMIN_EDIT_HEADING","Edit Coupon");
	define("ADMIN_ADD_BUTTON","Save Coupon");  
	define("ADMIN_EDIT_BUTTON","Update Coupon"); 
	
	/** Coupon Management **/
	define('ADMIM_COUPON_NAME_REQUIRE',"Coupon Name is required");
	define('ADMIM_COUPON_AMOUNT_REQUIRE',"Coupon Amount is required");
	define('ADMIM_COUPON_START_DATE_REQUIRE',"Coupon Start Date is required");
	define('ADMIM_COUPON_END_DATE_REQUIRE',"Coupon End Date is required");
	define('ADMIM_COUPON_CODE_EXISTS',"Coupon code already exists");
	define('ADMIM_COUPON_NAME_EXISTS',"Coupon name already exists");
	define('ENTER_FLOAT_VALUE',"Enter only float values.");
	define('COMMON_SECURITY_ANSWER_ALPHANUMERIC','Only alphanumeric characters are required.');
	define('CURRENT_SITE_ID',"Current Site Id");

	$arr_message = array (
		'MSG_ADD_SUCCESS' => 'Coupon has been added successfully.',
		'MSG_DEL_SUCCESS' => 'Coupon has been deleted successfully.',
		'MSG_EDIT_SUCCESS' => 'Coupon has been updated successfully.',
		'MSG_STATUS_SUCCESS' => 'Status has been updated successfully.',
	);
?>