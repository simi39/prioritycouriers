<?php
error_reporting(E_ALL ^ E_NOTICE ^ E_DEPRECATED ^ E_STRICT);

if(strpos($_SERVER['HTTP_HOST'],"radixusers.com") !== FALSE){
	$pos=strpos($_SERVER['SCRIPT_FILENAME'],"public_html");
	$docRoot=substr($_SERVER['SCRIPT_FILENAME'],0,$pos);
	$_SERVER['DOCUMENT_ROOT']=$docRoot."public_html";
}
/*
if(strpos($_SERVER['HTTP_HOST'],"localhost") !== FALSE){
	$pos=strpos($_SERVER['SCRIPT_FILENAME'],"prioritycouriers");
	//echo $pos;
	$docRoot=substr($_SERVER['SCRIPT_FILENAME'],0,$pos);
	//echo $docRoot;
	$_SERVER['DOCUMENT_ROOT']=$docRoot."/";
}*/
session_start();

// php.ini setting
ini_set("memory_limit","24000M");
ini_set('max_execution_time', 1200);
//  DEFINE THE SSL SITE Protocol
define('ENABLE_SSL',false); //$_root_path
/** Define ABSPATH as this files directory */
define('SITE_ABSPATH', dirname(__FILE__) . '/');
define('QUICKQUOTE','Box'); /* this is for quick quote page used in htmloutput page getItemTypeIndex*/
/** Allocate Memory **/
/**
	 * Include the Path file. Define all the path in this file
	 */

require_once(SITE_ABSPATH . "path.php");

/**
	 * Local config file: Setup the Database connetctivity
	 */
//echo DIR_WS_LIB;
require DIR_WS_LIB.'config.php';

/** IDENTIFY FILE NAME **/
$con=mysqli_connect(DATABASE_HOST,DATABASE_USERNAME,DATABASE_PASSWORD,DATABASE_NAME);
if (mysqli_connect_errno())
{
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}else{

	//echo "connected";
}
$FileNameTemp = $_SERVER['HTTP_REFERER']; //reading the url in browser
$FullFileName = $_SERVER['SCRIPT_FILENAME']; //reading the url in browser
$FileNameWithExt=substr($FullFileName,strrpos($FullFileName,'/')+1,strlen($FullFileName));//complete filename with extension from the url
$FileNameWithoutExt = substr($FileNameWithExt, 0, strrpos($FileNameWithExt, "."));	//  filename without extension
$template_filename	= $FileNameWithoutExt.".tpl.php";
define('FILE_FILENAME_WITH_EXT', $FileNameWithExt);
define('FILE_FILENAME_WITHOUT_EXT', $FileNameWithoutExt);
define('FILE_TEMPLATE_FILENAME', $template_filename);
$str_dir_name = dirname(str_replace(SITE_DOCUMENT_ROOT, "", $_SERVER['SCRIPT_FILENAME']));  // Return the directory of the URL
if(strrpos($str_dir_name,'admin'))
{
 $str_dir_name = 'admin';
}
if((strtolower($str_dir_name) == substr(SITE_ADMIN_DIRECTORY,0,-1)) || (FILE_FILENAME_WITH_EXT == "template_manager_action.php"))  ///  Remove the "/" from the SITE_ADMIN_DIRECTORY CONSTAT
{
	define('APPLICATION_TYPE','admin');
	define('IS_ADMIN',true);
}
else
{
	define('APPLICATION_TYPE','');
	define('IS_ADMIN',false);
}

/**********************Session Management******************************************/
/*session class file */
require_once(DIR_LIB_CLASSES."RSession.php");

if (isset($_SESSION['Thesessiondata'])) {
	$__Session = new Session($_SESSION['Thesessiondata']);
}else{

	$__Session = new Session();
}

//define all static constant value in this file
require_once(DIR_WS_LIB . 'siteconstants.php');

/// inclusion of preference file
require_once(DIR_WS_LIB. 'preferences.php');
$PreferencesObj = new  Preferences();

require_once(DIR_LIB_CLASSES."Comm.php");
require_once(DIR_LIB_CLASSES."RNameValueCollection.php");
//require_once(DIR_WS_LIB."dbpager.php");
require_once(DIR_WS_LIB."seo.php");
require_once(DIR_LIB_CLASSES."RCookie.php");
require_once(DIR_LIB_CLASSES."RRequest.php");
require_once(DIR_LIB_CLASSES."RValidation.php");
require_once(DIR_LIB_CLASSES_EXCEPTION."RDataException.php");
require_once(DIR_LIB_CLASSES_EXCEPTION."RInvalidCollectionOffsetException.php");
require_once(DIR_LIB_CLASSES_MODELS."RMasterModel.php");
require_once(DIR_LIB_CLASSES_MODELS."RDataModel.php");

/** Language Configuration **/
/*define('DIR_WS_CURRENT_LANGUAGE', DIR_WS_LANGUAGES.DIR_CURRENT_LANGUAGE."/"); //language wise
define('DIR_HTTP_CURRENT_LANGUAGE', DIR_HTTP_LANGUAGES."/".DIR_CURRENT_LANGUAGE."/");
*/

$sessPkAddFromBook =$__Session->GetValue("pickup_add_from_book");
$sessDlAddFromBook =$__Session->GetValue("delivery_add_from_book");

//This condition added by shailesh jamanapara on date Thu Jun 13 17:41:02 IST 2013
/*if(isset($sessPkAddFromBook) && $sessPkAddFromBook == 1){
	$__Session->ClearValue("pickup_add_from_book");
}
if(isset($sessDlAddFromBook) && $sessDlAddFromBook == 1){
	$__Session->ClearValue("delivery_add_from_book");
}*/

require_once(DIR_WS_LIB."config_language.php");

require_once(DIR_WS_LIB."csrf.php");
/* -------   Include Language Files  ------- */
$arr_javascript_include = array();
$arr_javascript_exclude = array();
$arr_javascript_plugin_include = array();
$arr_javascript_plugin_exclude = array();

$arr_css_include = array();
$arr_css_exclude = array();
$arr_css_plugin_include = array();
$arr_css_plugin_exclude = array();
$arr_css_plugin_below_include = array();
$arr_css_plugin_below_exclude = array();
$arr_css_admin_include = array();
$arr_css__admin_exclude = array();

//$arr_css_respons_include = array();
//$arr_css_ie_include = array();

/* -- Globaly included JS --*/



if(IS_ADMIN) {
	$arr_css_admin_include[] = 'style.css';
	$arr_css_admin_include[] = 'jquery.css';
	$arr_css_plugin_include[] = 'bootstrap/css/bootstrap.min.css';

	require_once(DIR_WS_ADMIN_INCLUDES."filenames.php");
	require_once(DIR_WS_ADMIN."admin_authenication.php");
	require_once(DIR_WS_LIB.'htmloutput.php');
	require_once(DIR_WS_ADMIN_LANGUAGES . DIR_CURRENT_LANGUAGE . '/' . DIR_CURRENT_LANGUAGE.".php");
	require_once(DIR_WS_ADMIN_LANGUAGES . DIR_CURRENT_LANGUAGE . '/' . FILE_COMMON_METATAGS);
	//require_once(DIR_WS_FCKEDITOR . 'fckeditor.php');

	//$arr_javascript_include[] = 'pickup.php';
	$arr_javascript_include[] = 'jquery.min.js';
	$arr_javascript_include[] = 'jquery-migrate.min.js';
	$arr_javascript_include[] = 'app.js';
	$arr_javascript_include[] = 'internal/common.js';
	$arr_javascript_include[] = 'internal/overlib.js';
	$arr_javascript_plugin_include[] = 'moment/js/moment.js';
	$arr_javascript_plugin_include[] = 'bootstrap/js/bootstrap.min.js';
	$arr_javascript_plugin_include[] = 'ddaccordion/js/ddaccordion.js';


}
else {
	//echo "inside other pages";
	require_once(DIR_WS_LIB."filenames.php");
	require_once(DIR_WS_CURRENT_LANGUAGE . DIR_CURRENT_LANGUAGE.".php");
	require_once(DIR_WS_CURRENT_LANGUAGE . FILE_COMMON_METATAGS);
	require_once(DIR_WS_LIB.'htmloutput.php');
//	$arr_javascript_include[] = 'treemenu.js';
//	$arr_javascript_include[] = 'pickup.php';
	$arr_css_plugin_include[] = 'font-awesome/css/font-awesome.css';
	$arr_css_plugin_include[] = 'bootstrapValidator/css/bootstrapValidator.min.css';
	$arr_css_include[] = 'themes/default.css" id="style_color';
	$arr_css_include[] = 'custom-style.css';
//	$arr_css_include[] = DIR_HTTP_SITE_CURRENT_TEMPLATE_CSS.'style.css';
//	$arr_css_include[] = DIR_HTTP_SITE_CURRENT_TEMPLATE_CSS.'lightbox.css';
//	$arr_css_include[] = DIR_HTTP_SITE_CURRENT_TEMPLATE_CSS.'default.css';
	$arr_javascript_include[] = 'jquery.min.js';
	$arr_javascript_include[] = 'internal/common.js';
	$arr_javascript_include[] = 'modernizr.custom.js';
	$arr_javascript_include[] = 'jquery-migrate.min.js';
	$arr_javascript_include[] = 'app.js';
	
	$arr_javascript_plugin_include[] = 'bootstrap/js/bootstrap.min.js';
	$arr_javascript_plugin_include[] = 'bootstrapValidator/js/bootstrapValidator.min.js';
	$arr_javascript_below_include[] = 'internal/footer.php';
	$arr_javascript_plugin_include[] = 'back-to-top.js';
	/*$arr_javascript_plugin_below_include[] = 'gmap/gmaps.js';
	$arr_javascript_below_include[] = 'internal/tracking.php';*/
	//$arr_javascript_below_include[] = 'internal/tracking.php';

	if(FILE_FILENAME_WITH_EXT!="underconstruction.php")
	{
	require_once(DIR_WS_MODEL . "SiteConstantMaster.php");
	$objSiteConstantMaster = new SiteConstantMaster();
	$objSiteConstantMaster = $objSiteConstantMaster->create();
	$objSiteConstantData = new SiteConstantData();
	$siteconstantvalue=array();
	$SiteConstantDataVal = $objSiteConstantMaster->getSiteConstant($fieldArr=null, $seaArr=null, $optArr=null, $start=null, $total=null, $ThrowError=true,$constant_id=null,$from_admin=true);
	foreach ($SiteConstantDataVal as $SiteConstant)
	{
		$siteconstantvalue[$SiteConstant->constant_name]=$SiteConstant->constant_value;
		//This variable declared by shailesh jamanapara on Date Wed May 15 12:42:39 IST 2013
		define(trim($SiteConstant->constant_name),stripslashes($SiteConstant->constant_value));
	}
	if($siteconstantvalue["site_under_construction"]=="yes")
	{
		header("Location:".SITE_URL."underconstruction.php");
	}
	}

}

$arrayNotAccessFiles = array();
if(IS_ADMIN == true){
}
else {
	$arrayNotAccessFiles = array();
}
//$index=($_SERVER['PHP_SELF']);
//validate for booking process
/*
$session_booking_required=array(FILE_INTERNATIONAL_GET_QUOTE,
									FILE_SAMEDAY_RATES,
									FILE_OVERNIGHT_RATES,
									FILE_DOMESTIC_SHIPPING,
									//FILE_BOOKING,
									FILE_BOOKING_CONFIRMATION_AUSTRALIA,
									FILE_PAYMENT,
									FILE_XML_VARIFICATION,
									FILE_EWAY_PAYMENT);FILE_PAYMENT,*/
$session_booking_required=array(FILE_XML_VARIFICATION,FILE_EWAY_PAYMENT);

if(in_array($FileNameWithExt,$session_booking_required)) {
	if($__Session->GetValue("booking_details")=="") {
		//header("Location: ".FILE_INDEX);
	}
}

//validate for isLogin
$session_data = json_decode($_SESSION['Thesessiondata']['_sess_login_userdetails'],true);
$userid = $session_data['user_id'];

/*
$session_user_required=array(FILE_BOOKING_RECORDS,
								FILE_MY_ACCOUNT,
								FILE_ADDRESS_BOOK_LISTING,
								FILE_CLIENT_TRACKING,
								FILE_ADDRESS_BOOK,
								FILE_FEEDBACK,
								FILE_CALCULATOR,
								FILE_PROFILE,
								FILE_MY_PAYMENT_DETAILS,
								FILE_AUTO_SESSION);*/
$session_user_required=array(FILE_BOOKING_RECORDS,
								FILE_ADDRESS_BOOK_LISTING,
								FILE_ADDRESS_BOOK,
								FILE_FEEDBACK,
								FILE_CALCULATOR,
								FILE_PROFILE,
								FILE_ADDRESSES,
								/*FILE_METRO_RATES,
								FILE_INTERSTATE_RATES,
								FILE_INTERNATIONAL,*/
								FILE_VIEW_BOOKING,
								FILE_CHECKOUT,
								FILE_BOOKING,
								FILE_ADDITIONAL_DETAILS,
								FILE_MY_PAYMENT_DETAILS,
								FILE_AUTO_SESSION);
if(in_array($FileNameWithExt,$session_user_required)) {
	if($userid=="") {
		//header("Location: ".FILE_INDEX);
		
		header("Location:".SITE_INDEX);
		exit();
	}
}
/* echo "<pre>";
print_r($_SESSION);
echo "</pre>"; */


require_once(DIR_WS_MODEL . "HelpManagerMaster.php");
require_once('functions.php');
/*****************Help Manager*******************/
$objHelpManagerMaster = new HelpManagerMaster();
$objHelpManagerMaster = $objHelpManagerMaster->create();
$objHelpManagerData = new HelpManagerData();

$objHelpManagerData = $objHelpManagerMaster->getHelpManager("*");

$tooltip = false;
$i=0;

if(!empty($objHelpManagerData))
{
	foreach ($objHelpManagerData as $datarow) {

		if($datarow->help_code)
		{

			$tooltiperr['tooltiptitle'][$i] = checkHelp($datarow->help_code);
			if(!empty($tooltiperr['tooltiptitle'][$i]))
			{
				$tooltip = true;
			}
		}
		if($datarow->help_description)
		{
			$tooltiperr['tooltipdesc'][$i] = checkHelp($datarow->help_description);
			if(!empty($tooltiperr['tooltipdesc'][$i]))
			{
				$tooltip = true;
			}
		}

		if($tooltip == false)
		{
			$var=$datarow->help_code;
			$$var =	$datarow->help_description;
		}else{

			logOut();
		}
		$i++;
	}
}

//exit();
/*******************help manager end ******************/

/******************trackstate with particular ips**************/

/*$browser  =$_SERVER['HTTP_USER_AGENT']; // get the browser name
	$curr_page=$_SERVER['PHP_SELF'];// get page name
	$ip  =  $_SERVER['REMOTE_ADDR'];   // get the IP address
	$from_page = $_SERVER['HTTP_REFERER'];//  page from which visitor came
	$page=$_SERVER['PHP_SELF'];//get current page
	//Insert the data in the table...
	$query_insert  ="INSERT INTO statTracker
	(browser,ip,thedate_visited,page,from_page) VALUES
	('$browser','$ip',now(),'$page','$from_page')" ;
	$result=mysql_query ( $query_insert);
	if(!$result){
	die(mysql_error());
	}*/
/******************trackstate with particular ips**************/
require_once(DIR_WS_LIB.'functions.php');
$arr_javascript_include[] = 'internal/session.php';
//$public_holidays =getPublicHoliDays(); //this variable  added by shailesh jamanapara
//$date_arr = dateArr($public_holidays);
//$public_holidays =
$date_arr = array('2021-04-02','2021-04-03');
$arrCouponTypes  =array('1'=>"Amount ($)","2"=>"Percentage (%)");
$spanClass6 = "class = span6_faq";

sessionCheck();

function sessionCheck()
{
	session_start();
	$FileNameTemp = $_SERVER['HTTP_REFERER']; //reading the url in browser
	$FullFileName = $_SERVER['SCRIPT_FILENAME']; //reading the url in browser
	$FileNameWithExt=substr($FullFileName,strrpos($FullFileName,'/')+1,strlen($FullFileName));

	if(($FileNameWithExt == 'cms.php' && $_SESSION['ses_flag']==1))
	{

		sessionX();
	}
	elseif($FileNameWithExt != 'cms.php' && $_SESSION['ses_flag']==1)
	{

		sessionX();
	}elseif($FileNameWithExt)
	{

		sessionX();
	}
}
if(IS_ADMIN){

	sessionX();
}

/* Below function is for javascript popup timing window */
function sessionTimings()
{
	global $__Session;
	if(!isset($_SESSION)){ session_start();}
	if(isset($__Session))
	{
		$session_data = $__Session->GetValue("_sess_login_userdetails");
		$userid = $session_data['user_id'];
	}
	//echo "userid".$userid;
	//exit();
	if(IS_ADMIN)
	{
		$userid = 1;
		//$logLength = 900000; # time in seconds :: 900 = 15 minutes please change this when go for live
		$logLength = 86400000; # time in seconds :: 900 = 15 minutes please change this when go for live
	}
	else
	{
		$userid =$userid;
		if($userid)
		{
			//$logLength = 900000; # time in secondsmilisecond :: 60000 = 1 minutes setup for 15min commented by smita on 21 jan 2021
			$logLength = 86400000;
			//print("debugging message:from javascript:");

		}elseif($_SESSION['ses_flag']){

			//$logLength = 900000; # time in seconds :: 60000= 1 minutes setup for 15min
			//$logLength = 900000; # time in seconds :: 60000= 1 minutes setup for 15min commented by smita on 21 jan 2021
			$logLength = 86400000;
			//$logLength = 120000; # time in seconds :: 60000= 1 minutes setup for 2min

			//$logLength = 60000; # time in seconds :: 60000= 1 minutes setup for 15min
		}//else{
			//$logLength = 86400000; /* 24 hrs setup for unsigned user and not submitting any buttons */
			//$logLength = 180000; /* 24 hrs setup for unsigned user and not submitting any buttons */
		//}
	}

	echo $logLength;
}

?>
