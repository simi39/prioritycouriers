<?php
/**
	 * This is index file
	 *
	 *
	 * @author     Radixweb <team.radixweb@gmail.com>
	 * @copyright  Copyright (c) 2008, Radixweb
	 * @version    1.0
	 * @since      1.0
	 */
/**
	 * include common
	 */
session_start();
require_once("lib/common.php");
require_once(DIR_WS_MODEL ."BookingDetailsMaster.php");
require_once(DIR_WS_MODEL ."BookingItemDetailsMaster.php");
require_once(DIR_WS_MODEL ."InternationalZonesMaster.php");
require_once(DIR_WS_CURRENT_LANGUAGE . "bookinghistory.php");
require_once(DIR_WS_MODEL."CommercialInvoiceMaster.php");
require_once(DIR_WS_MODEL."CommercialInvoiceItemMaster.php");
require_once(SITE_ADMIN_DIRECTORY."pagination_top.php");
//This files added by shailesh on date 15-5-2013
require_once(DIR_WS_MODEL . "ServiceMaster.php");
require_once(DIR_WS_MODEL . "ProductLabelMaster.php");
/* Below code is commented by smita because we are currently
not using tracking
*/
/*$arr_javascript_plugin_below_include[] = 'gmap/gmaps.js';
$arr_javascript_below_include[] = 'internal/tracking.php';*/
/* Above code is commented by smita because we are currently
not using tracking //111Z05046936EXP00001
*/

$BookingItemDetailsMasterObj = BookingItemDetailsMaster::create();
$BookingItemDetailsDataObj = new BookingItemDetailsData();

$BookingDetailsMasterObj = BookingDetailsMaster::create();
$BookingDetailsDataObj = new BookingDetailsData();

$InternationalZoneMasterObj= InternationalZonesMaster::create();
$InternationalZoneData = new InternationalZonesData();

//This below added by shailesh jamanapara on Date Wed May 15 17:08:25 IST 2013
$ObjProductLabelMaster	= ProductLabelMaster::Create();
$ProductLabelData		= new ProductLabelData();

$ObjServiceMaster	= ServiceMaster::Create();
$ServiceData		= new ServiceData();

$arr_javascript_include[] = 'internal/bookinghistory.php';
$arr_javascript_plugin_include[] = 'datatables/datatables.min.js';

$arr_css_plugin_include[] = 'datatables/datatables.min.css';
$arr_css_plugin_include[] = 'datatables/Buttons-1.7.0/css/buttons.dataTables.min.css';

/*csrf validation*/
$csrf = new csrf();
$csrf->action = "booking_history";
$ptoken = $csrf->csrfkey();
/*csrf validation*/

$pagenum= 1;
if($_GET['pagenum']!='')
	$pagenum=$_GET['pagenum'];

if(isset($pagenum) && $pagenum!='')
{
	$err['pagenum'] = isNumeric(valid_input($pagenum),ERROR_ENTER_NUMERIC_VALUE);
}
if(!empty($err['pagenum']))
{
	logOut();
}
if(isset($_GET['booking_id']) && $_GET['booking_id']!='')
{
	$err['booking_id'] = isNumeric(valid_input($_GET['booking_id']),ERROR_ENTER_NUMERIC_VALUE);
}
if(!empty($err['booking_id']))
{
	logOut();
}
if(isset($_GET['viewdelid']) && $_GET['viewdelid']!='')
{
	$err['viewdelid'] = chkSmall(valid_input($_GET['viewdelid']));
}
if(!empty($err['viewdelid']))
{
	logOut();
}
$session_data = json_decode($_SESSION['Thesessiondata']['_sess_login_userdetails'],true);
$userid = $session_data['user_id'];
//for cancel button : done by parag
if($_GET['booking_id']!="" && $_GET["viewdelid"]=="delete")
{
	if(isset($_POST['ptoken'])) {
		$csrf->checkcsrf($_POST['ptoken']);
	}
	$deleteid=$_GET['booking_id'];
	$BookingDetailsDataObj=$BookingDetailsMasterObj->deleteBookingDetails($deleteid);
	$BookingItemDetailsDataObj=$BookingItemDetailsMasterObj->deleteBookingItemDetails($deleteid);
}
//for cancel button : done by parag end
if($_POST['bookingid']!="" && $_POST["viewdelid"]=="delete")
{
	if(isset($_POST['ptoken'])) {
		$csrf->checkcsrf($_POST['ptoken']);
	}
	$deleteid=$_POST['bookingid'];
	$BookingDetailsDataObj=$BookingDetailsMasterObj->deleteBookingDetails($deleteid);
	$BookingItemDetailsDataObj=$BookingItemDetailsMasterObj->deleteBookingItemDetails($deleteid);
}

/* Function used for copy function in my booking history page. */

$copybookingid=$_GET['booking_id'];
$seaArr[] = array('Search_On'    => 'userid',
                      'Search_Value' => $userid,
                      'Type'         => 'int',
                      'Equation'     => '=',
                      'CondType'     => 'AND',
                      'Prefix'       => '',
                      'Postfix'      => '');
$optArr2[]	=	array('Order_By'   => 'auto_id', 'Order_Type' => 'DESC');

/*End of the function used for copy function in my booking history page.
$only_field = array('booking_id');


	$optArr2[]	=	array('Order_By'   => 'booking_date', 'Order_Type' => 'Desc');
	$optArr2[]	=	array('Order_By'   => 'service_name', 'Order_Type' => 'Asc');
	$data = $BookingDetailsMasterObj->getBookingDetails($only_field,$seaArr, $optArr=null, $start=null, $total=null,$distinct=null, $ThrowError=true,$havingArray=null,$bookingid=null,$tot='find');

	$all = (!empty($data))?$data:(0);
	$data_result = pagination(null,$pagenum,false,$all);
	$fieldArr = array("*");
    $from = $data_result[0];
	*/
	$BookingDetailsData=$BookingDetailsMasterObj->getBookingDetails('null',$seaArr,$optArr2);
	/*echo "<pre>";
	print_r($BookingDetailsData);
	echo "</pre>";*/
	//$countRecords = count((array)$BookingDetailsData);
	//echo "countRecords:".$countRecords;

function cmsPageContent($CmsPageName)
{
	require_once(DIR_WS_MODEL."CmsPagesMaster.php");
	require_once(DIR_WS_CURRENT_LANGUAGE . "cms.php");
	$ObjCmsPagesMaster	= CmsPagesMaster::Create();

	$fieldArr = array("cms_pages.*, cms_pages_description.page_heading , cms_pages_description.page_content");
	$searchArr = array();
	$searchArr[] = " AND cms_pages_description.site_language_id = '".SITE_LANGUAGE_ID."'";
	$searchArr[] = " AND cms_pages.page_name = '".$CmsPageName."'";
	$searchArr[] = " OR cms_pages.page_name = '".$CmsPageName."'";
	$searchArr[] = " AND cms_pages.status='1'";
	$DataCmsMaster = $ObjCmsPagesMaster->getCmsPagesDetails($searchArr, $fieldArr);
	if(!empty($DataCmsMaster)) {
		$cmsData = $DataCmsMaster[0];
	}

	return $cmsData;
}
//echo "<pre>";print_r($BookingDetailsData);exit();
require_once( DIR_WS_SITE_CURRENT_TEMPLATE . FILE_MAIN_INTERFACE); /* This include once is used for the html integration */
//echo "memory_get_peak_usage". memory_get_peak_usage();
?>
