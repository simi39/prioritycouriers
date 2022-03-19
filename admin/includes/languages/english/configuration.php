<?php
/**
 *	Site Configuration 
 *	File Name ::  site_configuration.php
*/	
global  $help_messages;

define('ADMIN_DOMAIN_MAIN_MANAGEMENT_HEADING', 'Domain Management');
define('ADMIN_SITE_PAYMENT_CONFIGURATION_HEADING', 'Payment Configuration');
define("COMMAN_CARD_NUMBER_IS_REQUIRED", "Card  Number is required");
define("COMMAN_VERIFICATION_NUMBER_IS_REQUIRED", "Verification Card  Number is required");
define("COMMAN_INVALID_CARD_NUMBER", "Please enter valid card number");
define("COMMAN_INVALID_VERIFICATION_NUMBER", "Please enter valid card verification number");
define("COMMAN_INVALID_EXPIRED_DATE", "Please enter valid expiration date");
define('ADMIN_SHIPPING_CONFIG_FILE_NOT_FOUND', ' Configuration file not found');
define('ADMIN_PAYMENT_CONFIG_FILE_NOT_FOUND', ' Configuration file not found');
define('ADMIN_SHIPPING_RADIX_STANDARD_CONFIG_REQUIRE_NOTE', 'You have to configure Radix Stardard Shipping Method first.');
define('ADMIN_SHIPPING_METHOD_ENABLE_NOTE', 'Note : At a time, Only One Shipping Method can be enabled.');
define('ADMIN_LANGUAGE_PAYMENT_NOTE', 'Below information will be displayed on front end on checkout pages as per language selected by client.');
define('ADMIN_LABEL_CONFIGURATION_VALUE', 'Settings');
define('ADMIN_LABEL_CONFIGURATION_DESCRIPTION', 'Brief Description');
define('ADMIN_AUTH_SETTING_LOGIN_USERNAME', 'radix');
define('ADMIN_AUTH_SETTING_LOGIN_PASSWORD', 'deep70');

define('ADMIN_PAYMENT_ACTIVE_IMG_ALT_TEXT', 'Make it Inactive');
define('ADMIN_PAYMENT_ACTIVE_IMG_TITLE_TEXT', 'Make it Inactive');
define('ADMIN_PAYMENT_INACTIVE_IMG_ALT_TEXT', 'Make it Active');
define('ADMIN_PAYMENT_INACTIVE_IMG_TITLE_TEXT', 'Make it Active');
define('ADMIN_ENABLE_PAYMENT_METHOD', 'Enable payment method.');
define('ADMIN_PAYMENT_ID_REQUIRED', 'Payment Id is required.');
define('ADMIN_PAYMENT_TITLE_REQUIRED', 'Payment title is required.');
define("COMMON_SECURITY_ANSWER_ALPHANUMERIC", "Enter alphanumeric characters.");
define("ERROR_ENTER_NUMERIC_VALUE", "Enter only numeric values.");

/**
 *	Edit constants File.
 */
define('ADMIN_EDIT_CONSTANTS', 'Edit Constants');
define('ADMIN_EDIT_CONSTANTS_LABEL', 'Text Reference');
define('ADMIN_EDIT_CONSTANTS_TEXT', 'Textline');
define('ADMIN_EDIT_CONSTANTS_RECORDS_UPDATED', 'Record updated successfully');

/**
 * Shipping Modules Constants
 */
define('FORM_LABEL_SAVE_SHIPPING_CONFIG', 'Save Changes');
define('SHIP_COMMON_LBL_SHIPPING_TYPE', 'Select Shipping Types');
define('SHIP_COMMON_LBL_DEFAULT_SHIPPING_TYPE', 'Default Shipping Type');
define('CREATE_UPS_ACCOUNT', 'Create an Ups Account : ');
define('UPS_REGISTRATION_LINK','https://www.ups.com/one-to-one/register?sysid=myups&lang=en&langc=US&loc=en_US');
define('UPS_REGISTRATION','Register an account in UPS.');

/**
* Payment Modules Constants
*/
define('PAYMENT_LBL_SELECT_STATUS', 'Status');
define('PAYMENT_LBL_SORT_ORDER', 'Sort order');
define('PAYMENT_LBL_ENABLE', 'Active');
define('PAYMENT_LBL_DISABLE', 'Inactive');
define('PAYMENT_COMMON_LBL_TITLE', 'Payment Title');	// Payment Title label
define('PAYMENT_COMMON_LBL_STATUS', 'After success, Order Status');	// Payment Title label
define('PAYMENT_COMMON_LBL_NOTE', 'Payment Note');	// Payment Note label
define('PAYMENT_LBL_MAKE_DEFAULT', 'Set as Default');	// Label for Make Default option
define('PAYMENT_LBL_MAKE_DEFAULT_YES', 'Yes');	// Label for Make Default option value Yes
define('PAYMENT_LBL_MAKE_DEFAULT_NO', 'No');	// Label for Make Default option value No
define('ADMIN_LANGUAGE_SEARCH_CONSTANTS','Search Textline');
define('ADMIN_LANGUAGE_SEARCH_BY_KEYWORDS','Search By Keyword');
define('ADMIN_LANGUAGE_SEARCH_ALL','All');

define('PAYMENT_LBL_ENVIRONMENT', 'Payment Environment');
define('PAYMENT_LBL_TESTING_ENV', 'Testing');
define('PAYMENT_LBL_LIVE_ENV', 'Live');

/**
 * Markup Page
 */
define('SHIPPING_TYPE_LBL', 'Shipping Type');
define('SHIPPING_MARKUP_LBL', 'MarkUp [%]');
define('ADMIN_CONFIGURATION_SHIPPING_MARKUP','Markup');

/** Ideal Payment **/
define('IDEAL_LBL_PSPID', 'Payment Service Provider ID(PSPID)');
define('IDEAL_LBL_BUSINESS_EMAIL', 'Business Email');
define('IDEAL_PAYMENT_ACTION','Payment Type');
define('IDEAL_PAYMENT_SALE','Sale');
define('IDEAL_PAYMENT_ORDER','Order');
define('IDEAL_PAYMENT_AUTHORIZATION','Authorization');
define('IDEAL_LBL_ITEM_NAME', 'Item Name');
define('IDEAL_LBL_CURRENCY_CODE', 'Currency Code');
define('IDEAL_LBL_LANGUAGE_CODE', 'Language Code');
define('IDEAL_LANGUAGE_US', 'English');
define('IDEAL_LANGUAGE_FR', 'French');
define('IDEAL_LANGUAGE_DE', 'German');
define('IDEAL_LANGUAGE_NL', 'Dutch');
define('IDEAL_CURRENCY_CODE', 'Currency Code');

define('IDEAL_UNITED_ARAB_EMIRATES_DIRHAM', 'United Arab Emirates Dirham');
define('IDEAL_NETHERLANDS_ANTILLEAN_GUILDER', 'Netherlands Antillean Guilder');
define('IDEAL_ARGENTINE_PESO', 'Argentine peso');
define('IDEAL_AUSTRALIAN_DOLLAR', 'Australian Dollar');
define('IDEAL_ARUBAN_FLORIN', 'Aruban Florin');
define('IDEAL_BULGARIAN_LEV', 'Bulgarian Lev');
define('IDEAL_BRAZILIAN_REAL', 'Brazilian Real');
define('IDEAL_BELARUSSIAN_RUBLE', 'Belarussian Ruble');
define('IDEAL_CANADIAN_DOLLAR', 'Canadian Dollar');
define('IDEAL_SWISS_FRANC', 'Swiss Franc');
define('IDEAL_YUAN_RENMINBI', 'Yuan Renminbi');
define('IDEAL_CZECH_KORUNA', 'Czech Koruna');
define('IDEAL_DANISH_KRONER', 'Danish Kroner');
define('IDEAL_ESTONIAN_KRONER', 'Estonian Kroner');
define('IDEAL_EGYPTIAN_POUND', 'Egyptian Pound');
define('IDEAL_EURO', 'Euro');
define('IDEAL_BRITISH_POUND', 'British Pound');
define('IDEAL_GEORGIAN_LARI', 'Georgian Lari');
define('IDEAL_HONG_KONG_DOLLAR', 'Hong Kong Dollar');
define('IDEAL_CROATIAN_KUNA', 'Croatian Kuna');
define('IDEAL_HUNGARIAN_FORINT', 'Hungarian Forint');
define('IDEAL_NEW_ISRAELIAN_SHEKEL', 'New Israelian Shekel');
define('IDEAL_INDIAN_RUPEE', 'Indian rupee');
define('IDEAL_ICELAND_KRONA', 'Iceland Krona');
define('IDEAL_JAPANESE_YEN', 'Japanese Yen');
define('IDEAL_SOUTH_KOREAN_WON', 'South Korean Won');
define('IDEAL_LITAS', 'Litas');
define('IDEAL_LATS_LETTON', 'Lats Letton');
define('IDEAL_MOROCCAN_DIRHAM', 'Moroccan Dirham');
define('IDEAL_MEXICAN_PESO', 'Mexican Peso');
define('IDEAL_NORWEGIAN_KRONER', 'Norwegian Kroner');
define('IDEAL_NEW_ZEALAND_DOLLAR', 'New Zealand Dollar');
define('IDEAL_POLISH_ZLOTY', 'Polish Zloty');
define('IDEAL_QATARI_RIYAL', 'Qatari riyal');
define('IDEAL_ROMANIAN_LEU', 'Romanian Leu');
define('IDEAL_SERBIAN_DINAR', 'Serbian dinar');
define('IDEAL_RUSSIAN_ROUBLE', 'Russian Rouble');
define('IDEAL_SAUDI_ARABIAN_RIYAL', 'Saudi Arabian Riyal');
define('IDEAL_SWEDISH_KRONE', 'Swedish Krone');
define('IDEAL_SINGAPORE_DOLLAR', 'Singapore Dollar');
define('IDEAL_COURONNE_SLOVAQUE', 'Couronne Slovaque');
define('IDEAL_SYRIAN_POUND', 'Syrian Pound');
define('IDEAL_THAI_BATH', 'Thai Bath');
define('IDEAL_TUNISIAN_DINAR', 'Tunisian Dinar');
define('IDEAL_TURKEY_NEW_LIRA', 'Turkey New Lira');
define('IDEAL_TAIWAN_DOLLAR', 'Taiwan dollar');
define('IDEAL_UKRAINE_HRYVNIA', 'Ukraine Hryvnia');
define('IDEAL_US_DOLLAR', 'US Dollar');
define('IDEAL_CFA_FRANC_BEAC', 'CFA Franc BEAC');
define('IDEAL_CFA_FRANC_BCEAO', 'CFA Franc BCEAO');
define('IDEAL_CFP_FRANC', 'CFP Franc');
define('IDEAL_SOUTH_AFRICAN_RAND', 'South African Rand');


/** Direc pay  **/
define('DIREC_STD_CURRENCY_IND_INR', 'India Rupee');
define('DIREC_LBL_PAYMENT_MERCHANT_ID','Merchat Id');
define('DIREC_LBL_PAYMENT_OPERATION_MODE','Operation Mode');
define('DIREC_LBL_CURRENCY_CODE','Currency Code');
define('DIREC_LBL_COUNTRY','Country');
define('DIREC_CURRENCY_INDIAN_RUPEE', 'Indian Rupee => INR');
/** Direc pay  **/

/** Nbepay  **/
define('NBEPAY_LBL_CURRENCY_CODE', 'Currency Code');
define('NBEPAYL_MALAYSIAN_RINGGIT', 'Malaysian Ringgit');
/** Nbepay  **/


/** Elavon payment gateway  **/
define('ELAVON_STD_CURRENCY_IND_INR', 'India Rupee');
define('ELAVON_LBL_PAYMENT_MERCHANT_ID','Merchant Id');
define('ELAVON_LBL_PAYMENT_PIN','Pin No.');
/*define('ELAVON_LBL_PAYMENT_OPERATION_MODE','Operation Mode');
define('ELAVON_LBL_CURRENCY_CODE','Currency Code');
define('ELAVON_LBL_COUNTRY','Country');
define('ELAVON_CURRENCY_INDIAN_RUPEE', 'Indian Rupee');*/


/** Elavon Form Based payment gateway  **/
define('ELAVON_FORMBASE_STD_CURRENCY_IND_INR', 'India Rupee');
define('ELAVON_FORMBASE_LBL_PAYMENT_MERCHANT_ID','Merchant Id');
define('ELAVON_FORMBASE_LBL_PAYMENT_PIN','Pin No.');


/** Vakif Bank Payment **/
define('VAKIFBANK_LBL_API_USER_CODE', 'API User Code');
define('VAKIFBANK_LBL_PASSWORD', 'Password');
define('VAKIFBANK_LBL_SECURITY_CODE', 'Security Code');
define('VAKIFBANK_LBL_ENTERPRISE_NO','Enterprise Number');
define('VAKIFBANK_LBL_POS_NO','POS No.');
define('VAKIFBANK_LBL_PROVISION_NO','Provision No');


/** payment gateway  **/

/** Paypal Standard Texts **/
define('PAYPAL_STD_LBL_BUSINESS_EMAIL', 'Business Email');
define('PAYPAL_STD_PAYMENT_ACTION','Payment Type');
define('PAYPAL_STD_PAYMENT_SALE','Sale');
define('PAYPAL_STD_PAYMENT_ORDER','Order');
define('PAYPAL_STD_PAYMENT_AUTHORIZATION','Authorization');
define('PAYPAL_STD_LBL_ITEM_NAME', 'Item Name');
define('PAYPAL_STD_LBL_CURRENCY_CODE', 'Currency Code');
define('PAYPAL_STD_CURRENCY_AUSTRALIAN_DOLLAR', 'Australian Dollar');
define('PAYPAL_STD_CURRENCY_BRAZILIAN_REAL', 'Brazilian Real');
define('PAYPAL_STD_CURRENCY_CANADIAN_DOLLAR', 'Canadian Dollar');
define('PAYPAL_STD_CURRENCY_CZECH_KORUNA', 'Czech Koruna');
define('PAYPAL_STD_CURRENCY_DANISH_KRONE', 'Danish Krone');
define('PAYPAL_STD_CURRENCY_EURO', 'Euro');
define('PAYPAL_STD_CURRENCY_HONGKONG_DOLLAR', 'Hong Kong Dollar');
define('PAYPAL_STD_CURRENCY_HUNGARIAN_FORINT', 'Hungarian Forint');
define('PAYPAL_STD_CURRENCY_ISRAELI_NEW_SHEQEL', 'Israeli New Sheqel');
define('PAYPAL_STD_CURRENCY_JAPANESE_YEN', 'Japanese Yen');
define('PAYPAL_STD_CURRENCY_MALAYSIAN_RINGGIT', 'Malaysian Ringgit');
define('PAYPAL_STD_CURRENCY_MEXICAN_PESO', 'Mexican Peso');
define('PAYPAL_STD_CURRENCY_NORWEGIAN_KRONE', 'Norwegian Krone');
define('PAYPAL_STD_CURRENCY_NEW_ZEALAND_DOLLAR', 'New Zealand Dollar');
define('PAYPAL_STD_CURRENCY_PHILIPPINE_PESO', 'Philippine Peso');
define('PAYPAL_STD_CURRENCY_POLISH_ZLOTY', 'Polish Zloty');
define('PAYPAL_STD_CURRENCY_POUND_STERLING', 'Pound Sterling');
define('PAYPAL_STD_CURRENCY_SINGAPORE_DOLLAR', 'Singapore Dollar');
define('PAYPAL_STD_CURRENCY_SWEDISH_KRONA', 'Swedish Krona');
define('PAYPAL_STD_CURRENCY_SWISS_FRANC', 'Swiss Franc');
define('PAYPAL_STD_CURRENCY_TAIWAN_NEW_DOLLAR', 'Taiwan New Dollar');
define('PAYPAL_STD_CURRENCY_THAI_BAHT', 'Thai Baht');
define('PAYPAL_STD_CURRENCY_US_DOLLAR', 'U.S. Dollar');

/** GuestPay **/
define('GUESTPAY_LBL_MERCHANTID', 'Merchant Id');
/* For Upload OTP File for GuestPay */
define('GUESTPAY_UPLOAD_OTP_FILE','Upload Otp File');
define('GUESTPAY_UPLOAD_IMPOST_OTP_FILE','Import Otp File');
define('GUESTPAY_OTP_PASSWORD','Otp Password');
define('GUESTPAY_UPLOAD_FILE_MSC','Upload .ric file only');
define('GUESTPAY_ERROR_RIC_INVALID_EMAIL','Please upload only ric format file');
define('GUESTPAY_OPT_INSERT_RECORD','Success Inserted Record ');
define('GUESTPAY_OTP_SUCCESS_INSERT_RECORD','Opt Record is successful Insert');
define('GUESTPAY_UPLOAD_OTP','Upload OTP');
/* For GuestPay language code. */
define('GUESTPAY_LANGUAGE_ITALIAN','Italian');
define('GUESTPAY_LANGUAGE_ENGLISH','English');
define('GUESTPAY_LANGUAGE_SPANISH','Spanish');
define('GUESTPAY_LANGUAGE_FRENCH','French');
define('GUESTPAY_LANGUAGE_GERMAN','German');
define('GUESTPAY_CURRENCY_CODE', 'Currency Code');
define('GUESTPAY_LANGUAGE_CODE', 'Language Code');
define('GUESTPAY_ITALIAN_LIRA', 'Italian Lira');
define('GUESTPAY_EURO', 'Euro');
define('GUESTPAY_DOLLAR', 'US Dollar');
define('GUESTPAY_POUND', 'Pound Sterling');
define('GUESTPAY_YEN', 'Japanese Yen');
define('GUESTPAY_HONK_KONG_DOLLAR', 'Hong Kong Dollar');
define('GUESTPAY_REAL', 'Brazilian Real');


/** Paypal Pro **/
define('PAYPAL_PRO_LBL_USERNAME', 'Username');
define('PAYPAL_PRO_LBL_PASSWORD', 'Password');
define('PAYPAL_PRO_LBL_SIGNATURE', 'Signature');
define('PAYPAL_PRO_PAYMENT_ACTION','Payment Type');
define('PAYPAL_PRO_PAYMENT_SALE','Sale');
define('PAYPAL_PRO_PAYMENT_ORDER','Order');
define('PAYPAL_PRO_PAYMENT_AUTHORIZATION','Authorization');
define('PAYPAL_PRO_LBL_CURRENCY_CODE','Currency Code');
define('PAYPAL_PRO_LBL_PROXY', 'Proxy Enable');
define('PAYPAL_PRO_LBL_PROXY_ENABLE_YES', 'Yes');
define('PAYPAL_PRO_LBL_PROXY_ENABLE_NO', 'No');
define('PAYPAL_PRO_LBL_PROXY_HOST', 'Proxy Host');
define('PAYPAL_PRO_LBL_PROXY_PORT', 'Proxy Port');

define('PAYPAL_PRO_CURRENCY_AUSTRALIAN_DOLLAR', 'Australian Dollar');

define('PAYPAL_PRO_CURRENCY_BRAZILIAN_REAL', 'Brazilian Real');
define('PAYPAL_PRO_CURRENCY_CANADIAN_DOLLAR', 'Canadian Dollar');
define('PAYPAL_PRO_CURRENCY_CZECH_KORUNA', 'Czech Koruna');
define('PAYPAL_PRO_CURRENCY_DANISH_KRONE', 'Danish Krone');
define('PAYPAL_PRO_CURRENCY_EURO', 'Euro');
define('PAYPAL_PRO_CURRENCY_HONGKONG_DOLLAR', 'Hong Kong Dollar');
define('PAYPAL_PRO_CURRENCY_HUNGARIAN_FORINT', 'Hungarian Forint');
define('PAYPAL_PRO_CURRENCY_ISRAELI_NEW_SHEQEL', 'Israeli New Sheqel');
define('PAYPAL_PRO_CURRENCY_JAPANESE_YEN', 'Japanese Yen');
define('PAYPAL_PRO_CURRENCY_MALAYSIAN_RINGGIT', 'Malaysian Ringgit');
define('PAYPAL_PRO_CURRENCY_MEXICAN_PESO', 'Mexican Peso');
define('PAYPAL_PRO_CURRENCY_NORWEGIAN_KRONE', 'Norwegian Krone');
define('PAYPAL_PRO_CURRENCY_NEW_ZEALAND_DOLLAR', 'New Zealand Dollar');
define('PAYPAL_PRO_CURRENCY_PHILIPPINE_PESO', 'Philippine Peso');
define('PAYPAL_PRO_CURRENCY_POLISH_ZLOTY', 'Polish Zloty');
define('PAYPAL_PRO_CURRENCY_POUND_STERLING', 'Pound Sterling');
define('PAYPAL_PRO_CURRENCY_SINGAPORE_DOLLAR', 'Singapore Dollar');
define('PAYPAL_PRO_CURRENCY_SWEDISH_KRONA', 'Swedish Krona');
define('PAYPAL_PRO_CURRENCY_SWISS_FRANC', 'Swiss Franc');
define('PAYPAL_PRO_CURRENCY_TAIWAN_NEW_DOLLAR', 'Taiwan New Dollar');
define('PAYPAL_PRO_CURRENCY_THAI_BAHT', 'Thai Baht');
define('PAYPAL_PRO_CURRENCY_US_DOLLAR', 'U.S. Dollar');

/** EWAY Payment **/
define("PAYMENT_EWAY_LBL_CUSTOMER_ID","Customer Id");

/** Realex Payment **/
define("REALEX_COMMON_LBL_ENVIRONMENT","Payment Environment : ");
define("REALEX_FORM_ELEMENT_ENV","Customer Id");
define("REALEX_COMMON_LBL_ACCOUNT","Account");
define("REALEX_COMMON_LBL_SECRET","Secret Code");
define("REALEX_FORM_ELEMENT_ENVIRONMENT","sel_payment_env");
define('REALEX_CURRENCY_CODE', 'Currency Code');
/*For Currency Management in the Realex*/
define("REALEX_EURO","Euro");
define("REALEX_BRITISH_POUND","Pound Sterling");
define("REALEX_US_DOLLAR","US Dollar");
define("REALEX_SWEDISH_KRONA","Swedish Krona");
define("REALEX_SWISS_FRANC","Swiss Franc");
define("REALEX_HONG_KONG_DOLLAR","Hong Kong Dollar");
define("REALEX_JAPANESE_YEN","Japanese Yen");


/** CC Avenue **/
define('PAYMENT_COMMON_LBL_MERCHANT_ID', 'Merchant Id');
define('PAYMENT_COMMON_LBL_WORKING_COPY', 'Working Key');


/** Sage Pay Texts **/
define('SAGEPAY_LBL_ENVIRONMENT', 'Vendor Name');
define('SAGEPAY_LBL_VENDOR_NAME', 'Vendor Name');
define('SAGEPAY_LBL_PASSWORD', 'Password');
define('SAGEPAY_LBL_CURRENCY_CODE', 'Currency Code');
define('SAGEPAY_LBL_TRANCACTION_TYPE', 'Transaction Type');
define('SAGEPAY_LBL_PARTNER_ID', 'Partner Id');
define('SAGEPAY_LBL_EMAIL_ID', 'Email Id');
define('SAGEPAY_LBL_CUSTOMER_EMAIL_OPTION', 'Do you want to sent mail regarding transaction?');
define('SAGEPAY_LBL_CUSTOMER_EMAIL_OPTION_YES', 'Yes');
define('SAGEPAY_LBL_CUSTOMER_EMAIL_OPTION_NO', 'No');
define('SAGEPAY_LBL_TYPE_PAYMENT', 'PAYMENT');
define('SAGEPAY_LBL_TYPE_DEFERRED', 'DEFERRED');
define('SAGEPAY_LBL_TYPE_AUTHENTICATE', 'AUTHENTICATE');
define('SAGEPAY_LBL_EMAIL_MESSAGE', 'If yes, Provide the email content');
define('SAGEPAY_LBL_DESCRIPTION', 'Enter the Description to display in Sagepay');

/** Google Checkout Standard **/
define('GOOGLE_PAYMENT_ACTION','payment action');
define('GOOGLE_ITEMNAME','Item Name');
define('GOOGLE_PAYMENT_SALE','Sale');
define('GOOGLE_PAYMENT_ORDER','Order');
define('GOOGLE_PAYMENT_AUTHORIZATION','Authorization');
define('GOOGLE_LBL_MERCHANT_ID', 'Merchant Id');
define('GOOGLE_LBL_MERCHANT_KEY', 'Merchant Key');
define('GOOGLE_LBL_CURRENCY_CODE', 'Currency Code');
define('GOOGLE_CURRENCY_US_DOLLAR', 'U.S. Dollar');
define('GOOGLE_CURRENCY_POUND_STERLING', 'Pound Sterling');
define('GOOGLE_CURRENCY_EURO', 'Euro');

/** Multisafepay Gateway **/
define('MULTISAFEPAY_LBL_ACCOUNT', 'Account Number');
define('MULTISAFEPAY_LBL_SITE_ID', 'Website id');
define('MULTISAFEPAY_LBL_SITE_SECURE_CODE', 'Site Secure Code');
define('MULTISAFEPAY_LBL_CURRENCY_CODE', 'Transaction Currency');
define('MULTISAFEPAY_CURRENCY_EUR', 'Euro');
define('MULTISAFEPAY_CURRENCY_USD', 'U.S. Dollar');
define('MULTISAFEPAY_CURRENCY_GPB', 'British Pond');
define('MULTISAFEPAY_PAYMENT_DESCRIPTION', 'Transaction Comment');


/** Securenet **/
define('SECURENET_LBL_SECURENETID', 'Securenet ID');
define('SECURENET_LBL_SECURENETKEY', 'Securenet Key');
define('SECURENET_LBL_SIGNATURE', 'Signature');
define('SECURENET_LBL_AUTHORIZATIONCODE', 'Authorization Code');
define('SECURENET_LBL_TRANSACTIONTID', 'Transaction ID');
define('SECURENET_PAYMENT_TRANSACTIONTYPE','Transaction Type');
define('SECURENET_PAYMENT_AUTHORIZATION','Authorization');


/* shipping configuration */

define('FORM_ELEMENT_SHIP_TYPE_CHK', 'chkstd');		// Select of shipping type in Standard Shipping Method
define('FORM_ELEMENT_SHIP_TYPE_DEFAULT_SELECT', 'defaultShipType');		// Select of shipping type in Standard Shipping Method
define('FORM_ELEMENT_SHIPPING_ID', 'shipmethodid');	// Shipping Method id get from shipping method table
define('FORM_ELEMENT_SHIPPING_DIR', 'shipmethoddir');	// Shipping Directory get from shipping method table
define('FORM_BUTTON_ELEMENT_SAVE', 'btnsubmitship');	// Submit button name must be used for all shipping methods
define('FORM_ELEMENT_SHIP_MARKUP', 'markup');		// Select of shipping type in Standard Shipping Method


/* Shipping Configuration Form Constants */

define('SHIP_COMMON_LBL_TESTING_ENV', 'Testing');
define('SHIP_COMMON_LBL_LIVE_ENV', 'Live');
define('SHIP_COMMON_LBL_ENVIRONMENT','Select Shipping Environment');
define('SHIP_COMMON_LBL_LICENSE_CODE','Licence Number');
define('SHIP_COMMON_LBL_USERNAME','Customer Id / Username');
define('SHIP_COMMON_LBL_PASSWORD','Password');
define('SHIP_COMMON_LBL_ACCOUNT_NO','Account Number');
define('SHIP_COMMON_LBL_COMPANY_NAME','Company Name');
define('SHIP_COMMON_LBL_ATTENTION_NAME','Attention Name');
define('SHIP_COMMON_LBL_PHONE_NUMBER','Phone Number');
define('SHIP_COMMON_LBL_ADDRESS_ONE','Address Line 1');
define('SHIP_COMMON_LBL_ADDRESS_TWO','Address Line 2');
define('SHIP_COMMON_LBL_CITY','City');
define('SHIP_COMMON_LBL_STATE','State');
define('SHIP_COMMON_LBL_STATE_SHORTNAME','State Short Name');
define('SHIP_COMMON_LBL_POSTCODE','Post Code');
define('SHIP_COMMON_LBL_COUNTRY','Country');
define('SHIP_COMMON_LBL_UNDELIVER_EMAIL','Email (When Undelivered)');
define('SHIP_COMMON_LBL_PACKAGE_WEIGHT','Package Weight');
define('COMMAN_SELECT_COUNTRY','Select Country');
define('SHIP_COMMON_LBL_PARCEL_HEIGHT','Parcel Height');
define('SHIP_COMMON_LBL_PARCEL_LENGTH','Parcel Length');
define('SHIP_COMMON_LBL_PARCEL_WIDTH','Parcel Width');
define('SHIP_COMMON_LBL_NO_OF_PACKAGE','No Of Package');
define('SHIP_COMMON_LBL_METER_NO','Meter Number');
define('SHIP_COMMON_LBL_ACCESS_KEY','Acees Key');
define('CREATE_FEDEX_ACCOUNT','Create an Fedex Account');
define('FEDEX_REGISTRATION','Register an account in Fedex.');
define('FEDEX_REGISTRATION_LINK','https://www.fedex.com/in/account/index.html');

/* Shipping Configuration Form Constants End Here*/	


/* Authorize.net (AIM)*/
define('AUTHORIZE_LBL_USERNAME','Username');
define('AUTHORIZE_LBL_PASSWORD','Transaction Key');
define('AUTHORIZE_CURRENCY_CODE', 'Currency Code');
define('AUTHORIZE_US_DOLLAR', 'US Dollar');

/** Orbital Pay **/
define('ORBITAL_PRO_LBL_USERNAME', 'Connection Username');
define('ORBITAL_PRO_LBL_PASSWORD', 'Connection Password');
define('ORBITAL_PRO_PAYMENT_ACTION','Payment Type');
define('ORBITAL_PRO_PAYMENT_AUTH_LBL','Authorization request');
define('ORBITAL_PRO_PAYMENT_AUTH_CAPTURE_LBL','Authorization and Mark for Capture');
define('ORBITAL_PRO_PAYMENT_FORCE_CAPTURE_LBL','Force-Capture request');
define('ORBITAL_PRO_PAYMENT_REFUND_LBL','Refund request');
define('ORBITAL_PRO_PAYMENT_AUTH_VAL','A');
define('ORBITAL_PRO_PAYMENT_AUTH_CAPTURE_VAL','AC');
define('ORBITAL_PRO_PAYMENT_FORCE_CAPTURE_VAL','FC');
define('ORBITAL_PRO_PAYMENT_REFUND_VAL','R');
define('ORBITAL_PRO_LBL_TERMINAL', 'Bin Number');
define('ORBITAL_PRO_LBL_MERCHANT_ID', 'Merchant ID');
define('ORBITAL_PRO_LBL_TERMINAL_ID', 'Terminal ID');


$arr_message = array (
	MSG_ADD_SUCCESS => 'Setting has been added successfully',
	MSG_DEL_SUCCESS => 'Setting has been deleted successfully',
	MSG_EDIT_SUCCESS => 'Settings has been updated successfully',
);

$arr_payment_message = array (
	MSG_ADD_SUCCESS => 'Payment method has been added successfully',
	MSG_DEL_SUCCESS => 'Payment method has been deleted successfully',
	MSG_EDIT_SUCCESS => 'Payment method has been updated successfully',
);

$markup_message = array (
	MSG_ADD_SUCCESS => 'Markup has been added successfully',
	MSG_DEL_SUCCESS => 'Markup has been deleted successfully',
	MSG_EDIT_SUCCESS => 'Markup has been updated successfully',
);

$arr_message_shipping = array (
	MSG_ADD_SUCCESS => 'Shipping method has been added successfully',
	MSG_DEL_SUCCESS => 'Shipping method has been deleted successfully',
	MSG_EDIT_SUCCESS => 'Shipping method has been updated successfully',
);

/*Help messages */

/*Help messages */
	$help_messages = array (
	'HELP_SELECT_SHIPPING_TYPE'=>'Select Shipping Types, which will be reflected in the Payment Details Page(Front Side) as Shipping Type and respective Shipping Charges.',
	'HELP_SELECT_DEFAULT_SHIPPING_TYPE'=>'Select Shiping Type, which will reflected in the Payment Details Page(Front Side) as default Shipping Type.',
	'HELP_UPS_SHIPPING_ENVIRONMENT' => '1) Live, Live Shipping Environment is for Real Time transaction. <br /> 2) Testing, Testing Environment is used for testing the entire Shipping Process.',
	'HELP_UPS_LICENSE_NUMBER' => 'The License Number is an access key which is provided by the UPS. To get the key you have to request by providing the UPS Id and password generated at the time of registration. To Request an Access Key you have to go to the www.ups.com and then under the select Support -> Technology Support -> UPS Developer Kit -> Request an access.',
	'HELP_UPS_CUSTOMER_USERNAME' => 'The Username or the Id which was selected at the time of registration of the UPS Account should be provided here.',
	'HELP_UPS_CUSTOMER_PASSWORD' => 'The Password which was generated at the time of registration of the UPS Account should be provided here.',
	'HELP_FEDEX_CUSTOMER_PASSWORD'=> 'The Password which was generated at the time of registration of the Fedex Account should be provided here.',
	'HELP_FEDEX_METER_NUMBER' => 'The Meter Number which was generated at the time of registration of the Fedex Account should be provided here.',
	'HELP_FEDEX_ACCESS_KEY' => 'The Access Key which was generated at the time of registration of the Fedex Account should be provided here.',
	'HELP_FEDEX_NO_OF_PACKAGE' => 'No of Package which is use for calculate shipping price your shipping price of particular product will be calculated based on packages at front side.',
	'HELP_FEDEX_PARCEL_HEIGHT' => 'Parcel Height which is use for calculate shipping price your shipping price of particular order will be calculated based on parcel height at front side.',
	'HELP_FEDEX_PARCEL_LENGTH' => 'Parcel length which is use for calculate shipping price your shipping price of particular order will be calculated based on parcel length at front side.',
	'HELP_FEDEX_PARCEL_WIDTH' => 'Parcel width which is use for calculate shipping price your shipping price of particular order will be calculated based on parcel width at front side.',
	'HELP_UPS_CUSTOMER_ACCOUNT_NUMBER' => 'The Account Number which was generated at the time of registration of the UPS Account should be provided here.',
	'HELP_FEDEX_CUSTOMER_ACCOUNT_NUMBER' => 'The Account Number which was generated at the time of registration of the Fedex Account should be provided here.',
	'HELP_UPS_CUSTOMER_COMPANY_NAME' => 'The Company Name which was given at the time of registration of the UPS Account should be provided here.',
	'HELP_UPS_CUSTOMER_ATTENTION_NAME' => 'The Attention Name which was given at the time of registration of the UPS Account should be provided here.',
	'HELP_UPS_CUSTOMER_PHONE_NUMBER' => 'The Phone Number which was given at the time of registration of the UPS Account should be provided here.',
	'HELP_UPS_CUSTOMER_ADDRESS_LINE1' => 'The Address Line1 which was given at the time of registration of the UPS Account should be provided here.',
	'HELP_FEDEX_CUSTOMER_ADDRESS_LINE1' => 'The Address Line1 which was given at the time of registration of the Fedex Account should be provided here.',
	'HELP_UPS_CUSTOMER_ADDRESS_LINE2' => 'The Address Line2 which was given at the time of registration of the UPS Account should be provided here.',
	'HELP_FEDEX_CUSTOMER_ADDRESS_LINE2' => 'The Address Line2 which was given at the time of registration of the Fedex Account should be provided here.',
	'HELP_UPS_CUSTOMER_CITY' => 'The Name of the City which was given at the time of registration of the UPS Account should be provided here.',
	'HELP_UPS_CUSTOMER_STATE' => 'The Name of the State which was given at the time of registration of the UPS Account should be provided here. The state NAME should be Short Name like California is CA.',
	'HELP_FEDEX_CUSTOMER_STATE' => 'The Name of the State which was given at the time of registration of the Fedex Account should be provided here. The state NAME should be Short Name like California is CA.',
	'HELP_UPS_CUSTOMER_POST_CODE' => 'The Zip Code which was given at the time of registration of the UPS Account should be provided here.',
	'HELP_FEDEX_CUSTOMER_POST_CODE' => 'The Zip Code which was given at the time of registration of the Fedex Account should be provided here.',
	'HELP_UPS_CUSTOMER_COUNTRY' => 'The Name of the Country which was given at the time of registration of the UPS Account should be selected here.',
	'HELP_FEDEX_CUSTOMER_COUNTRY' => 'The Name of the Country which was given at the time of registration of the Fedex Account should be selected here.',
	'HELP_UPS_CUSTOMER_EMAIL_WHEN_UNDELIVERED' => 'The email address which was given at the time of registration of the UPS Account, when the shipment is not delivered should be provided here.',
	'HELP_UPS_PACKAGE_WEIGHT' => 'Package weight is limitation of package. For more information regarding the package weight you can go through this <a href="http://www.ups.com/content/us/en/resources/sri/sze2.html?srch_pos=2&srch_phr=150+weight&WT.svl=SRCH">link</a>.',
	'HELP_SITE_NAME' => 'Site Name is used in CMS pages and in image tag as Alternative text.',
	'HELP_WEBSITE_STATUS' => 'Live - Users will be able to visit the website. Maintenance - A message will be displayed as defined by admin, for eg: website under construction.',
	'HELP_FROM_EMAIL_ADDRESS' => 'This email address will be used when you have not specified any email address in email template.',
	'HELP_PATH_OF_COMPANY_LOGO' => 'This is the path to company logo which is displayed on header.',	
	'HELP_PATH_OF_COMPANY_LOGO_EMAIL' => 'This is the path to company logo which is displayed in outgoing mails.',
	'HELP_COUNTRY_NAME' => 'Selected country name will be displayed as default country name where ever country drop down is given at front and admin.',
	'HELP_TEMPLATE_LISTING_SEARCH_PATTERN' => 'Horizontal - A drop down of category list will come. Vertical - Category list will be displayed vertically.',
	'HELP_CURRENCY_AUTO_DETECT' => 'If set to Yes, it will take the currency value set in language management.',
	'HELP_LANGUAGE_AND_CURRENCY_STYLE' => 'Icon - Small image will be displayed. Dropdown - Combo box will be displayed.',
	'HELP_ENABLE_SSL' => 'It enables the secured socket layer which makes the payment transcation secured in the site.',
	'HELP_UTILITY_USED' => 'Please refer more help.',
	'HELP_DISPLAY_PRICE_CALCULATOR' => 'If set to Yes, it will display the price calculator on product information page.',
	'HELP_PRODUCT_IMAGE_WIDTH_DESCRIPTIVE_PAGE' => 'It will display the image with the width specified here on product description pages.',
	'HELP_PRODUCT_IMAGE_HEIGHT_DESCRIPTIVE_PAGE' => 'It will display the image with the height specified here on product description pages.',
	'HELP_ENABLE_COUPON_MODULE' => 'If set to Yes, it will set the textbox for entering discount coupon on checkout process.',
	'HELP_PRODUCT_IMAGE_WIDTH_LISTING_PAGE' => 'It will display the image with the width specified here on product listing pages.',
	'HELP_PRODUCT_IMAGE_HEIGHT_LISTING_PAGE' => 'It will display the image with the height specified here on product listing pages.',
	'HELP_DISPLAY_CAPTCHA' => 'Admin - It will ask for the security code only at admin side. Front - It will ask for the security code at front side. Both - It will ask for the security code on admin as well as front side.',
	'HELP_PRODUCT_SIZE_UNIT' => 'Inch - It will convert the size unit in inch. MM - It will convert the size unit in MM. CM - It will convert the size unit in CM.',
	'HELP_PRODUCT_DESCRIPTION_LAYOUT' => 'Different layouts for the product description page.',
	'HELP_INDEX_PAGE_MIDDLE_AREA_DISPLAY' => 'Product - It will display product images and short description. Template - It will display Templates. CMS - It will display the content of CMS index page written in content management.',
	'HELP_TEMPLATE_LISTING_MAX_PER_PAGE' => 'Maximum number of templates to be listed on template listing page.',
	'HELP_TEMPLATE_LISTING_MAX_PER_ROW' => 'Maximum number of templates to be listed on template listing per row.',
	'HELP_MYACCOUNT_PAGE_MAX_RECORD_PORTFOLIO_ORDER' => 'Maximum number of records to be displayed in portfolio and order page.',
	'HELP_INDEX_PAGE_PRODUCT_LISTING_MAX_PER_PAGE' => 'If you have selected Products in Index Page Middle area display type then how many products should be displayed per page you can specify here.',
	'HELP_MYACCOUNT_PAGE_COL_PER_ROW_PORTFOLIO_ORDER'	 => 'Maximum number of columns to be displayed in portfolio and order page.',
	'HELP_INDEX_PAGE_PRODUCT_LISTING_MAX_PER_ROW' => 'If you have selected Product in Index Page Middle area display type then how many products should be displayed per row you can specify here.',
	'HELP_PRODUCT_LISTING_MAX_PER_ROW' => 'Maximum number of products per row to be displayed in product listing page.',
	'HELP_PRODUCT_LISTING_MAX_PER_PAGE' => 'Maximum number of products per page to be displayed in product listing page.',
	'HELP_INDEX_PAGE_TEMPLATE_LISTING_MAX_PER_PAGE' => 'If you have selected Template in Index Page Middle area display type then how many products should be displayed per page you can specify here.',
	'HELP_INDEX_PAGE_TEMPLATE_LISTING_MAX_PER_ROW' => 'If you have selected Template in Index Page Middle area display type then how many products should be displayed per row you can specify here.',
	'HELP_USER_IMAGES_MAX_PER_ROW' => 'Maximum number of images to be displayed per row in user images page.',
	'HELP_COMMON_MAX_IMAGE_WIDTH' => 'Maximum image width to display templates in user account, user images, templates etc pages.',
	'HELP_COMMON_MAX_IMAGE_HEIGHT' => 'Maximum image height to display templates in user account, user images, templates etc pages.',
	'HELP_ADMIN_MAX_NO_OF_IMAGES_PER_ROW_IMG_MGMT' => 'In Admin side, maximum number of images per row in image gallery.',
	'HELP_ADMIN_MAX_NO_OF_IMAGES_PER_PAGE_IMG_MGMT' => 'In Admin side, maximum number of images per page in image gallery.',
	'HELP_ADMIN_MAX_NO_OF_TEMPLATES_PER_ROW_TEMP_MGMT' => 'In Admin side, maximum number of templates per row in template management.',
	'HELP_ADMIN_MAX_NO_OF_TEMPLATES_PER_PAGE_TEMP_MGMT' => 'In Admin side, maximum number of templates per page in template management.',
	'HELP_ADMIN_MAX_NO_OF_PAGE_LINK_IN_PAGING' => 'In Admin side, maximum number of pages in paging links.',
	'HELP_TAX_CALCULATION' => 'Not Applicable - Tax will not be applied on the price. Flat - Default Tax will be calculated. Country - Tax will be calculated on the basis of country selected. Country and state - Tax will be calculated on the basis of country and state.  Country and zipcode - Tax will be calculated on the basis of country and zipcode.',
	'HELP_INDEX_PAGE_MIDDLE_SECTION_CONFIG' => 'Full Page Banner - Full banner will be displayed on index page below the header menu. Full Page CMS - CMS defined in content management will be displayed on index page below the header menu. Inner Page Banner - Banner will be displayed on index page in middle part. Inner Page CMS - CMS defined in content management will be displayed on index page in middle part.',
	'HELP_ENABLE_SUBSCRIBE' => 'If enabled, subscribers textbox will be displayed on index page.',
	'HELP_GOOGLE_ANALYTICAL' => 'Code for google analytical to get the website status.',
	'HELP_ENABLE_PRODUCT_CATEGORY' => 'If enabled then products will be displayed based on the category.',
	'HELP_PRODUCT_PRICE_LIST' => 'Display Horizontal - Price list will be displayed horizontally with option to view more price. Display Vertical - Price list will be displayed vertically with option to view more price. Display Horizontal with Product Name - Price list will be displayed horizontall with all the products name above. Display Vertically with Product Name - Price list will be displayed vertically with all the products name above.',
	'HELP_BUTTON_STYLE'	 => 'Image - Images will be displayed as buttons. CSS - Buttons generated from style will be displayed.', 
	'HELP_PAYMENT_STATUS' => 'This will handle visibility at front store.',
	'HELP_SORT_ORDER' => 'Payment Listing is sorted with Sort Order.',
	'HELP_PAYMENT_ORDER_STATUS' => 'Order status is used to specify the status of the orders.',
	'HELP_PAYMENT_TITLE' => 'Title will be displayed on the checkout page.',
	'HELP_PAYMENT_NOTE' => 'Description for the type of payment used.',
	'HELP_PAYMENT_PAYPAL_PRO_ENVIRONMENT' => 'Live - Live Payment Environment is for Real Time transaction. <br />Testing - Testing Environment is used for testing the entire Payment Process.',
	'HELP_PAYMENT_PAYPAL_PRO_USERNAME' => 'Username that you created on PayPal\'s sandbox or the PayPal live site.',
	'HELP_PAYMENT_PAYPAL_PRO_PASSWORD' => 'The password associated with the user.',
	'HELP_PAYMENT_PAYPAL_PRO_SIGNATURE' => 'An API signature is a credential that consists of an API username along with an associated API password and signature, all of which are assigned by PayPal.',
	'HELP_PAYMENT_PAYPAL_PRO_PAYMENT_ACTION' => 'Sale - A sale payment action represents a single payment that completes a purchase for a specified amount.<br />Order - An order payment action represents an agreement to pay one or more authorized amounts up to the specified total over a maximum of 29 days.<br />Authorization - An authorization payment action represents an agreement to pay and places the buyer’s funds on hold for up to three days.',
	'HELP_PAYMENT_PAYPAL_PRO_CURRENCY_CODE' => 'The default currency of the paypal payment account.',
	'HELP_PAYMENT_PAYPAL_PRO_PROXY_ENABLE' => 'Set this variable to TRUE to route all the API requests through proxy.<br />If Proxy enable is yes, provide following details : ',
	'HELP_PAYMENT_PAYPAL_PRO_PROXY_HOST' => 'Set the host name or the IP address of proxy server.',
	'HELP_PAYMENT_PAYPAL_PRO_PROXY_PORT' => 'Set proxy port.',
	'HELP_PAYMENT_PAYPAL_STANDARD_ENVIRONMENT' => 'Live - Live Payment Environment is for Real Time transaction. <br />Testing - Testing Environment is used for testing the entire Payment Process.',
	'HELP_PAYMENT_PAYPAL_STANDARD_BUSINESS_EMAIL' => 'Email address associated with your PayPal account.',
	'HELP_PAYMENT_PAYPAL_STANDARD_PAYMENT_ACTION' => 'Sale - A sale payment action represents a single payment that completes a purchase for a specified amount.<br />Order - An order payment action represents an agreement to pay one or more authorized amounts up to the specified total over a maximum of 29 days.<br />Authorization - An authorization payment action represents an agreement to pay and places the buyer’s funds on hold for up to three days.',
	'HELP_PAYMENT_PAYPAL_STANDARD_ITEM_NAME' => 'Description of item being sold.',
	'HELP_PAYMENT_PAYPAL_STANDARD_CURRENCY_CODE' => 'The default currency of the paypal payment account.',
	'HELP_PAYMENT_EWAY_ENVIRONMENT' => 'Live - Live Payment Environment is for Real Time transaction. <br />Testing - Testing Environment is used for testing the entire Payment Process.',
	'HELP_PAYMENT_EWAY_CUSTOMER_ID' => 'Id associated with your payment account.',
	'HELP_PAYMENT_AUTHORIZE_AIM_ENVIRONMENT' => 'Live - Live Payment Environment is for Real Time transaction. <br />Testing - Testing Environment is used for testing the entire Payment Process.',
	'HELP_PAYMENT_AUTHORIZE_AIM_USERNAME' => 'Authorize.net API login username.',
	'HELP_PAYMENT_AUTHORIZE_AIM_KEY' => 'The Transaction Key is a 16-character alphanumeric value that is randomly generated in the Merchant Interface and works in conjunction with your API Login ID to authenticate you as an authorized user of the Authorize.Net Payment Gateway when submitting transactions from your Web site.',
	'HELP_PAYMENT_CCAVENUE_ENVIRONMENT' => 'Live - Live Payment Environment is for Real Time transaction. <br />Testing - Testing Environment is used for testing the entire Payment Process.',
	'HELP_PAYMENT_CCAVENUE_MERCHANT_ID' => 'The Merchant Id to use for the CCAVENUE service',
	'HELP_PAYMENT_CCAVENUE_WORKING_KEY' => '32 bit alphanumeric key is assigned to merchant.',
	'HELP_PAYMENT_SAGEPAY_ENVIRONMENT' => 'Live - Live Payment Environment is for Real Time transaction. <br />Testing - Testing Environment is used for testing the entire Payment Process.',
	'HELP_PAYMENT_SAGEPAY_VENDOR_NAME' => 'Vendor Name assigned to you by Sage Pay.',
	'HELP_PAYMENT_SAGEPAY_PASSWORD' => 'XOR Encryption password assigned to you by Sage Pay.',
	'HELP_PAYMENT_SAGEPAY_CURRENCY_CODE' => 'Indicate the currency in which you wish to trade.',
	'HELP_PAYMENT_SAGEPAY_PAYMENT_TYPE' => 'Sale - A sale payment action represents a single payment that completes a purchase for a specified amount.<br />Order - An order payment action represents an agreement to pay one or more authorized amounts up to the specified total over a maximum of 29 days.<br />Authorization - An authorization payment action represents an agreement to pay and places the buyer’s funds on hold for up to three days.',
	'HELP_PAYMENT_SAGEPAY_PARTNER_ID' => 'Optional setting. If you are a Sage Pay Partner and wish to flag the transactions with your unique partner id set it here.',
	'HELP_PAYMENT_SAGEPAY_EMAIL_ID' => 'Optional setting. Set this to the mail address which will receive order confirmations and failures.',
	'HELP_PAYMENT_SAGEPAY_SENT_MAIL' => '',
	'HELP_PAYMENT_SAGEPAY_EMAIL_CONTENT' => '',
	'HELP_PAYMENT_SAGEPAY_DESCRIPTION' => '',
	'HELP_PAYMENT_AUTHORIZE_SIM_ENVIRONMENT' => 'Live - Live Payment Environment is for Real Time transaction. <br />Testing - Testing Environment is used for testing the entire Payment Process.',
	'HELP_PAYMENT_AUTHORIZE_SIM_USERNAME' => 'Authorize.net API login username.',
	'HELP_PAYMENT_AUTHORIZE_SIM_KEY' => 'The Transaction Key is a 16-character alphanumeric value that is randomly generated in the Merchant Interface and works in conjunction with your API Login ID to authenticate you as an authorized user of the Authorize.Net Payment Gateway when submitting transactions from your Web site.',
	'HELP_PAYMENT_GOOGLE_ENVIRONMENT' => 'Live - Live Payment Environment is for Real Time transaction. <br />Testing - Testing Environment is used for testing the entire Payment Process.',
	'HELP_PAYMENT_GOOGLE_MERCHANT_ID' => 'Your Merchant ID is a unique, numeric code assigned to your business by Google.',
	'HELP_PAYMENT_GOOGLE_MERCHANT_KEY' => 'Your Merchant Key is a unique code that helps secure your communications with Google.',
	'HELP_PAYMENT_GOOGLE_ITEM_NAME' => 'Description of item being sold.',
	'HELP_PAYMENT_GOOGLE_CURRENCY_CODE' => 'Indicate the currency in which you wish to trade.',
	'HELP_PAYMENT_NBEPAY_ENVIRONMENT' => 'Live - Live Payment Environment is for Real Time transaction. <br />Testing - Testing Environment is used for testing the entire Payment Process.',
	'HELP_PAYMENT_NBEPAY_MERCHANT_ID' => 'Login username provided by the NBePay.',
	'HELP_PAYMENT_NBEPAY_WORKING_KEY' => 'The key which is used as a verify key and generated at the time of registration of the account',
	'HELP_PAYMENT_NBEPAY_CURRENCY_CODE' => 'The default currency of the Nbepay payment account.',
	'HELP_PAYMENT_IDEAL_ENVIRONMENT' => 'Live - Live Payment Environment is for Real Time transaction. <br />Testing - Testing Environment is used for testing the entire Payment Process.',
	'HELP_PAYMENT_IDEAL_BUSINESS_EMAIL' => 'Email address associated with your IDEAL account.',
	'HELP_PAYMENT_IDEAL_PAYMENT_ACTION' => 'Sale - A sale payment action represents a single payment that completes a purchase for a specified amount.<br />Order - An order payment action represents an agreement to pay one or more authorized amounts up to the specified total over a maximum of 29 days.<br />Authorization - An authorization payment action represents an agreement to pay and places the buyer’s funds on hold for up to three days.',
	'HELP_PAYMENT_IDEAL_ITEM_NAME' => 'Description of item being sold.',
	'HELP_PAYMENT_IDEAL_CURRENCY_CODE' => 'The default currency of the IDEAL payment account.',
	'HELP_PAYMENT_IDEAL_LANGUAGE_CODE' => 'The default Language of the IDEAL payment account to be displayed in the payment page.',
	'HELP_PAYMENT_IDEAL_PSPID' => 'The Payment Service Provider ID(PSPID), PSPID is your unique identifier for the Neos payment platform(IDEAL)',
	'HELP_PAYMENT_REALEX_ENVIRONMENT' => 'Live - Live Payment Environment is for Real Time transaction. <br />Testing - Testing Environment is used for testing the entire Payment Process.',
	'HELP_PAYMENT_REALEX_MERCHANT_ID' => 'Your Merchant ID is a unique, numeric code assigned to your business by Realex.',
	'HELP_PAYMENT_REALEX_ACCOUNT_NUMBER' => 'The Account Number which was generated at the time of registration of the Realex Account should be provided here.',
	'HELP_PAYMENT_REALEX_SECRET_NUMBER' => 'The Secret Code which was generated at the time of registration of the Realex Account should be provided here.',
	'HELP_PAYMENT_REALEX_CURRENCY_CODE' => 'The default currency of the Realex payment account.',
	'HELP_PAYMENT_GUESTPAY_MERCHANT_ID' => 'Unique Merchant Id that you created on GuestPays Account for Testing environment or Live.',
	'HELP_PAYMENT_GUESTPAY_ENVIRONMENT' => 'Live - Live Payment Environment is for Real Time transaction. <br />Testing - Testing Environment is used for testing the entire Payment Process.',
	'HELP_PAYMENT_GUESTPAY_CURRENCY_CODE' => 'The default currency of the Guestpay payment account.',
	'HELP_PAYMENT_GUESTPAY_LANGUAGE_CODE' => 'The default Language of the Guestpay payment account to be displayed in the payment page.',
	'HELP_PAYMENT_DIREC_ENVIRONMENT' => 'Live - Live Payment Environment is for Real Time transaction. <br />Testing - Testing Environment is used for testing the entire Payment Process.',
	'HELP_PAYMENT_DIREC_MECHANT_ID' => 'Merchant ID associated with direcpay payment account.',
	'HELP_PAYMENT_DIREC_OPERATION_CODE' => 'Merchant should only use \'DOM\' as its value.',
	'HELP_PAYMENT_DIREC_CURRENCY_CODE' => 'The default currency of the direcpay payment account.',
	'HELP_PAYMENT_DIREC_COUNTRY' => 'The default Country of the direcpay payment account.',	
	'HELP_PAYMENT_ELAVON_ENVIRONMENT'=> 'Live - Live Payment Environment is for Real Time transaction. <br />Testing - Testing Environment is used for testing the entire Payment Process.',
	'HELP_PAYMENT_ELAVON_MERCHANT_ID'=> 'Merchant ID associated with elavon payment account.',
	'HELP_PAYMENT_ELAVON_PIN'=> 'Pin associated with elavon payment account.',
	'HELP_AUTHORIZE_CURRENCY_CODE' => 'The default currency of the Authorize(aim) payment account.',
	'HELP_PAYMENT_VAKIFBANK_ENVIRONMENT'=> 'Live - Live Payment Environment is for Real Time transaction. <br />Testing - Testing Environment is used for testing the entire Payment Process.',
	'HELP_PAYMENT_VAKIFBANK_USERCODE'=> 'API user code provided by the vakifbank.',
	'HELP_PAYMENT_VAKIFBANK_PASSWORD'=> 'Password associated with the user code.',
	'HELP_PAYMENT_VAKIFBANK_SECURITY_CODE'=> 'Security code provided by the vakifbank.',
	'HELP_PAYMENT_VAKIFBANK_ENTERPRISE_NO'=> 'Enterprise number provided by the vakifbank.',
	'HELP_PAYMENT_VAKIFBANK_POS_NO'=> 'Pos number provided by the vakifbank.',
	'HELP_PAYMENT_VAKIFBANK_PROVISION_NO'=> 'Provision number provided by the vakifbank. Default value 000000.',	
	'HELP_PAYMENT_MULTISAFEPAY_ENVIRONMENT' => 'Live - Live Payment Environment is for Real Time transaction. <br />Testing - Testing Environment is used for testing the entire Payment Process.',
	'HELP_PAYMENT_MULTISAFEPAY_ACCOUNT_NUMBER' => 'Merchant Account Number given from Multisafepay.',
	'HELP_PAYMENT_MULTISAFEPAY_SITE_ID' => 'Website id is given from Multisafepay.',
	'HELP_PAYMENT_MULTISAFEPAY_SITE_SECURE_CODE' => 'Website secure code is given from Multisafepay.',
	'HELP_PAYMENT_MULTISAFEPAY_CURRENCY_CODE' => 'The default currency of the Multisafepay payment account.',
	'HELP_PAYMENT_MULTISAFEPAY_PAYMENT_DESCRIPTION' => 'Must be set. The Comments will be sent while transaction will be made by customer.',
	'HELP_PAYMENT_SECURENET_ENVIRONMENT' => 'Live - Live Payment Environment is for Real Time transaction. <br />Testing - Testing Environment is used for testing the entire Payment Process.',
	'HELP_PAYMENT_SECURENET_SECURENETID' => 'Security ID that you created on securenet live site.',
	'HELP_PAYMENT_SECURENET_SECURENETKEY' => 'The security key associated with the Security ID.',
	'HELP_PAYMENT_SECURENET_AUTH_CAPTURE' => 'On approval the transaction will be picked up for settlement.',
	'HELP_PAYMENT_ORBITAL_PRO_USERNAME' => 'Orbital Connection Username set up on Orbital Gateway.',
	'HELP_PAYMENT_ORBITAL_PRO_PASSWORD' => 'Orbital Connection Password used in conjunction with Orbital Username.',
	'HELP_PAYMENT_ORBITAL_PRO_PAYMENT_ACTION' => '<strong>Authorization request</strong> - Authorize the supplied information, but do NOT creat a settlement item. This transaction type should be used for deferred billing transactions.<br /><br />
	<strong>Authorization and Mark for Capture</strong> - Authorize the supplied information and mark it as captured for
next settlement cut. This transaction should be used for immediate fulfillment.<br /><br />
	<strong>Force-Capture request</strong> - Force transactions do not generate new authorizations. A good response simply indicates that the request has been properly formatted. The Orbital Gateway will settle the captured force during the next settlement event.<br /><br />
	<strong>Refund request</strong> - Instruct the Gateway to generate a refund based on the supplied information',
	'HELP_PAYMENT_ORBITAL_BIN_NUMBER' => 'The platform which you have selected at the time of set up account (Either Salem Platform(BIN 000001) or PNS Platform(BIN 000002))',
	'HELP_PAYMENT_ORBITAL_MERCHANT_ID' => 'Gateway merchant account number assigned by Chase Paymentech',
	'HELP_PAYMENT_ORBITAL_TERMINAL_ID' => 'Merchant Terminal ID assigned by Chase Paymentech',
);
/*end Help messages */	     
?>