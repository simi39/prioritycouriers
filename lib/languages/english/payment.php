<?php
define("TITLE","Payment Page");
require_once(DIR_WS_MODEL ."CmsPagesMaster.php");

$ObjCmsPagesMaster	= new CmsPagesMaster();                 
$ObjCmsPagesMaster	= $ObjCmsPagesMaster->Create();                 

define("COMMON_CARD_HOLDER","Card Holder Name:");
define("COMMON_PAYMENT_DETAILS","Payment Details: ");
define("COMMON_CARD_NUMBER","Card Number: ");
define("COMMON_EXP_DATE","Expiry Date: ");
define("COMMON_VARI_NO","CCV Number: ");
define("COMMON_CARD_TYPE","Card Type: ");
define("COMMON_EMAIL","Email:");
define("COMMON_CONFIRM_EMAIL","Confirm Email:");
define("COMMON_RECEIPT_MESSAGE","Email Receipt required for courier purpose");
define("COMMON_RECEIPT_EMAIL","Do not send me receipt email");
define("COMMON_SECURITY_ANSWER_ALPHANUMERIC", "Enter alphanumeric characters (a-z A-Z 0-9)");
define("COMMON_CARD_TYPE_IS_REQUIERD","Card type is required");
define("COMMON_YEAR_IS_REQUIRED","Year is required");
define("COMMON_MONTH_IS_REQUIRED","Month is required");
define("COMMON_NUMERIC_VALUE_REQUIRED","Numeric value required");
define("COMMON_EMAIL_ID_REQUIRED","Email id is required");
define("COMMON_EMAIL_PATTERN","Enter proper email address");
define("COMMON_CARDNAME_IS_REQUIRED","Enter 16 digit Card Number");
define("COMMON_CARDVERIFICATION_NO_IS_REQUIRED","Enter your Card Verification Number");
define("COMMON_CARD_HOLDER_NAME_IS_REQUIRED","Enter card holder name");
define("MODAL_POPUP_PAYMENT","Please wait while your payment is being processed");
?>