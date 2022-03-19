<?php
define("TITLE","International Quote Page");
require_once(DIR_WS_MODEL ."CmsPagesMaster.php");
$ObjCmsPagesMaster	= CmsPagesMaster::Create();

define("COMMON_PICK_UP_READY","When are the goods ready for collection?");
define("COMMON_DATE_READY","Date Ready");
define("COMMON_TIME_READY","*Time Ready");
define("COMMON_TIME_MESSAGE","If you want to use any service whoes cut-off time has already passed, simple change the date and time accordingly.");define("SELECT_TIME_DATE","Pickup Date");define("COMMON_INCLUDE_GST","The service price includes GST.");
$CmsPageName = "international_content";
$fieldArr = array("cms_pages.*, cms_pages_description.page_heading , cms_pages_description.page_content");
$searchArr = array();
$searchArr[] = " AND cms_pages_description.site_language_id = '".SITE_LANGUAGE_ID."'";
$searchArr[] = " AND cms_pages.page_name = '".$CmsPageName ."'";
$searchArr[] = " OR cms_pages.page_name = '".$CmsPageName ."'";
$searchArr[] = " AND cms_pages.status='1'";
$DataCmsMaster = $ObjCmsPagesMaster->getCmsPagesDetails($searchArr, $fieldArr);

if(!empty($DataCmsMaster)) {
	$international_content = $DataCmsMaster[0];
}

define("COMMON_DELIVERY_SUMMARY","Delivery Summary");
define("COMMON_LOCAL_DELIVERY_QUOTES","LOCAL DELIVERY QUOTES");
define("COMMON_INTERNATIONAL_DELIVERY_QUOTES","International Pricing");
define("COMMON_INTERNATIONAL","INTERNATIONAL");
define("COMMON_HOME","Home");

define("COMMON_INTERNATIONAL_CONTENT",'<h2><a class="thickbox" href="#TB_inline?height=300&width=400&inlineId=international_content"></h2><br /><h2><img src="'.DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES.'MOREDETAILS_UP.gif" border="0"></h2></a><br /><br /><div id="international_content" style="display:none">'.$international_content['page_content'].'</div>');
define("COMMON_OPTIONAL","OPTIONAL");
define("COMMON_TRANSIENT_WARRANTY","Transit Warranty");
define("COMMON_SURCHARGE_OPTIONS","Surcharge Options:");
define("COMMON_TRANSIENT_CONTENT","Our services include $50.00 Transit warranty as Standard. If you would like additional cover please enter the amount<br>");
define("COMMON_SELECT_AMOUNT","Select Amount");
define("COMMON_ADDITIONAL_COST","Cost of additional Transit Warranty");
define("COMMON_AUTHORITY_LEAVE_DELIVERY_CARD","Authority to Leave Delivery Card");
define("COMMON_BOOK_NOW","BOOK NOW");
define("COMMON_AUTHORITY_CONTENT","A card will be left for shipment to be collected from the Local Post Office");
define("TIME_MESSAGE_HEAD","Current time message.");
define("COMMON_GST_NOT_APPLICABLE","** GST is not applicable **");
define("COMMON_NUMERIC_VAL", "Please enter numeric value.");
define("LOGIN_REGISTER_MESSAGE","You need to Login or Register to access our website and use our service.  It’s a simple process and will take only a minute or two.
.");
define("LOGIN_SINGUP","Login/Register");
define("READY_TIME","Ready Time");
define("CLOSING_TIME","Close Time");
define("SELECT_SERVICE","Select Service");
define("COMPARE_TIMER_MSG", "Please select your Closing Time more than your Ready Time.");
define("COMPARE_TIMER_HEADER_MSG","Prioritycouriers Says:");
define("TIMER_GAP_MSG","Please keep the hour gap of 3 hours or more between Ready Time and Close Time");
define("INTERNATIONAL_BOOKING_HEADER_MSG","Prioritycouriers Says:");
define("INTER_SEL_BOOKING_MSG","Please click on any SELECT SERVICE button to go further.");
define("INTERNATIONAL_BOOKING_CONFIRMATION_MSG","Are you sure you want to proceed further?");
define("INTERNATIONAL_DATETIME_BLOCK_MSG","Choose a collection window");
define("INTERNATIONAL_DATETIME_BLOCK_SUB_MSG","The collection window must be 3 hours or more.");
?>
