<?php
session_start();

require_once("lib/common.php");

require_once(DIR_WS_CURRENT_LANGUAGE . "index.php");/* Language declaration of get_quote file(where all name constants where delcared) */
require_once(DIR_WS_MODEL ."ItemTypeMaster.php");/*(Items for australia are coming from this page.) */
require_once(DIR_WS_MODEL . "SupplierData.php");
require_once(DIR_WS_MODEL . "SupplierMaster.php");
require_once(DIR_WS_MODEL . "SteRatesFormateData.php");
require_once(DIR_WS_MODEL . "SteRatesFormateMaster.php");
require_once(DIR_WS_MODEL . "SteDetailsData.php");
require_once(DIR_WS_MODEL . "SteDetailsMaster.php");
require_once(DIR_WS_MODEL . "SteRateData.php");
require_once(DIR_WS_MODEL . "SteRateMaster.php");
require_once(DIR_WS_MODEL ."InternationalZonesMaster.php");/* Zones are selected form this table(For International selection) .*/
require_once(DIR_WS_MODEL ."InternationalRatesMaster.php");/* Based on zones rates were selected form this table(For International selection) .*/
require_once(DIR_WS_MODEL ."ClientAddressMaster.php");
require_once(DIR_WS_MODEL . "ServicePageMaster.php");

$arr_javascript_plugin_below_include[] = 'gmap/gmaps.js';
$arr_javascript_below_include[] = 'internal/tracking.php';

$ItemTypeMasterObj = new ItemTypeMaster();
$ItemTypeMasterObj        = $ItemTypeMasterObj->create();
$ItemTypedataObj          = new ItemTypeData();
$ObjSupplierMaster = new SupplierMaster();
$ObjSupplierMaster	      = $ObjSupplierMaster->Create();
$SupplierData		      = new SupplierData();
$ObjSteRatesFormateMaster = new SteRatesFormateMaster();
$ObjSteRatesFormateMaster = $ObjSteRatesFormateMaster->Create();
$SteRatesFormatesData	  = new SteRatesFormateData();
$ObjSteDetailsMaster = new SteDetailsMaster();
$ObjSteDetailsMaster	  = $ObjSteDetailsMaster->Create();
$SteDetailsData		      = new SteDetailsData();
$ObjSteRateMaster = new SteRateMaster();
$ObjSteRateMaster	      = $ObjSteRateMaster->Create();
$SteRateData		      = new SteRateData();
$objClientAddressMaster = new ClientAddressMaster();
$objClientAddressMaster = $objClientAddressMaster->Create();
$objClientAddressData = new ClientAddressData();

$InternationalzonesMasterObj= new InternationalZonesMaster();
$InternationalzonesMasterObj = $InternationalzonesMasterObj->Create();
$InternationalDataobj= new InternationalZonesData();
$InternationalRatesMasterObj= new InternationalRatesMaster();
$InternationalRatesMasterObj = $InternationalRatesMasterObj->create();
$InternationalRatesDataobj = new InternationalRatesData();
$ObjServicePageIndexMaster= new ServicePageMaster();
$ObjServicePageIndexMaster	= $ObjServicePageIndexMaster->Create();
$ServicePageData		= new ServicePageData();

$arr_css_plugin_include[] = 'flexslider/flexslider.css"  media="screen';
$arr_css_plugin_include[] = 'parallax-slider/css/parallax-slider.css';
$arr_css_plugin_include[] = 'glyphicons_new/css/glyphicons.css';

$arr_javascript_plugin_include[] = 'flexslider/jquery.flexslider-min.js';
$arr_javascript_plugin_include[] = 'parallax-slider/js/modernizr.js';
$arr_javascript_plugin_include[] = 'parallax-slider/js/jquery.cslider.js';
$arr_javascript_plugin_include[] = 'back-to-top.js';
$arr_javascript_plugin_include[] = 'moment/js/moment-with-locales.min.js';
$arr_javascript_include[] = 'pages/index.js';
$arr_javascript_include[] = 'internal/ajex.js';
$arr_javascript_include[] = 'internal/ajax-dynamic-list.js';
$arr_javascript_below_include[] = 'internal/index.php';
//$arr_javascript_include[] = 'internal/pickup.php';


if(isset($__Session))
{
	$session_data = $__Session->GetValue("_sess_login_userdetails");
	$userid = valid_output($session_data['user_id']);
}
/*
if(isset($_SESSION) && $userid=="")
{

	session_destroy();
	session_start();
}*/
//print_R($_SESSION);

$selShippingType = $_POST['selShippingType'];
$flag    = valid_input($_POST['flage']);

$BookingDetailsDataObj = $__Session->GetValue("booking_details");

if (!empty($BookingDetailsDataObj)) {
    $bookingvalue = new stdClass;
    foreach ($BookingDetailsDataObj as $akey => $aval) {
        $bookingvalue->{$akey} = $aval;
        $servicepage = $bookingvalue->servicepagename;

    }
}
$BookingItemDetailsDataObj = $__Session->GetValue("booking_details_items");
if (!empty($BookingItemDetailsDataObj)) {
    $BookingItemDetailsData = new stdClass;
    foreach ($BookingItemDetailsDataObj as $key => $val) {
        $BookingItemDetailsData1 = new stdClass;
        foreach ($val as $kky => $val1) {
            $BookingItemDetailsData1->{$kky} = $val1;
			$item_type = $BookingItemDetailsData1->item_type;
        }
        $BookingItemDetailsData->{$key} = $BookingItemDetailsData1;
    }
}

if(!empty($BookingDetailsDataObj['start_date']))
{
	$start_date =  date('Y-m-d H:i', strtotime($BookingDetailsDataObj['start_date']));
}
if(!empty($BookingDetailsDataObj['min_date']))
{
	$min_date =  date('Y-m-d H:i', strtotime($BookingDetailsDataObj['min_date']));
}
/*Start for the validation of items*/
/* Start set the item id for metro,interstate and international */
require_once(DIR_WS_MODEL . "ItemTypeMaster.php");

$ItemTypeMasterObj = new ItemTypeMaster();
$ItemTypeMasterObj = $ItemTypeMasterObj->create();

$seaQuickArr = array();
//echo "service page:".$_POST['servicepagename'];

if(isset($servicepage))
{
	$service_item_type = $servicepage;
}elseif(isset($_POST['servicepagename']) && $_POST['servicepagename']!=""){
	$service_item_type = $_POST['servicepagename'];
}else{
	$service_item_type = 'sameday';
}


if($service_item_type=="international")
{
	if(isset($_POST['inter_ShippingType_1'][0]))
	{
	  $item_type =$_POST['inter_ShippingType_1'][0];
	}
}else{
	$seaQuickArr[] = array('Search_On' => 'item_name',
				  'Search_Value' => QUICKQUOTE,
				  'Type'         => 'string',
				  'Equation'     => '=',
				  'CondType'     => 'AND',
				  'Prefix'       => '',
				  'Postfix'      => '');
	$seaQuickArr[] = array('Search_On' => 'type',
					  'Search_Value' => $service_item_type,
					  'Type'         => 'string',
					  'Equation'     => '=',
					  'CondType'     => 'AND',
					  'Prefix'       => '',
					  'Postfix'      => '');
	$allItem = $ItemTypeMasterObj->getItemType(null,$seaQuickArr);
	if ($allItem != '') {
		$item = $allItem[0];
		$item_type = $item->item_id;
	}
}



$fieldArr=array("*");
$seaArr = array();

$seaArr[]=array('Search_On'=>'service_page_name', 'Search_Value'=>$service_item_type, 'Type'=>'string', 'Equation'=>'=', 'CondType'=>'AND', 'Prefix'=>'', 'Postfix'=>'');
$seaArr[]=array('Search_On'=>'item_type', 'Search_Value'=>$item_type, 'Type'=>'string', 'Equation'=>'=', 'CondType'=>'AND', 'Prefix'=>'', 'Postfix'=>'');
$data = $ObjServicePageIndexMaster->getServicePageName($fieldArr,$seaArr);
if(!empty($data))
{
	foreach ($data as $servicePageDetail)
	{
		if($servicePageDetail['weight_status']=='1' && $servicePageDetail['weight_min']!="" && $servicePageDetail['weight_max']!="")
		{
			$weight_max = $servicePageDetail['weight_max'];
			$weight_min = $servicePageDetail['weight_min'];
		}
		if($servicePageDetail['dim_status']=='1')
		{
			if($servicePageDetail['length_min']!="" && $servicePageDetail['length_max']!="")
			{
				$length_max = $servicePageDetail['length_max'];
				$length_min = $servicePageDetail['length_min'];
			}
			if($servicePageDetail['width_min']!="" && $servicePageDetail['width_max']!="")
			{
				$width_max = $servicePageDetail['width_max'];
				$width_min = $servicePageDetail['width_min'];
			}
			if($servicePageDetail['height_min']!="" && $servicePageDetail['width_max']!="")
			{
				$height_max = $servicePageDetail['height_max'];
				$height_min = $servicePageDetail['height_min'];
			}
		}
	}
}

/* If session exists */

if(!empty($_GET["action"]))
{
	$action = valid_input($_GET["action"]);
	$err['ACTIONERROR'] = chkPages($action);
}
/*When the button of logout is set*/
if(isset($_GET['action']) && $_GET['action'] == 'logout') {
	$csrf = new csrf();
	$csrf->cleanOldSession();
	$csrf->logout();
	UnsetLoginSession();
	$_SESSION = array();
	user_deletecookie();
	session_destroy();
	session_start();
	$_SESSION = array();
	session_regenerate_id(true);
	show_page_header(FILE_INDEX);
}
/*End for the validation of items*/

if($flag != '')
{
	$err['flag'] = isNumeric($flag, COMMON_NUMERIC_VAL);
}
if(!empty($err['flag']))
{
	logOut();
}
if(isset($flag) && $flag == 1)
{
	$drc = valid_input($_POST["drc"]);
	if($drc != '')
	{
		$err['drc'] = chkSmall($drc);
	}

	if(!empty($err['drc']))
	{
		logOut();
	}
	if(isset($drc) && valid_input($drc) == 'residential')
	{
		$drc = 1;
	}else{
		$drc = 0;
	}
}

if($servicepage != '')
{
	$err['servicepage'] = chkSmall($servicepage);
}
if(!empty($err['servicepage']))
{
	logOut();
}
$BookingItemDetailsDataObj = $__Session->GetValue("booking_details_items");
if (!empty($BookingItemDetailsDataObj)) {
    $BookingItemDetailsData = new stdClass;
    foreach ($BookingItemDetailsDataObj as $key => $val) {
        $BookingItemDetailsData1 = new stdClass;
        foreach ($val as $kky => $val1) {
            $BookingItemDetailsData1->{$kky} = $val1;
        }
        $BookingItemDetailsData->{$key} = $BookingItemDetailsData1;
    }
}
/* If session exists */

$session_data = json_decode($_SESSION['Thesessiondata']['_sess_login_userdetails'],true);
$userid       = $session_data['user_id'];
if(!empty($userid))
{
	$err['userid'] = isNumeric($userid,ERROR_ENTER_NUMERIC_VALUE);
}
if($err['userid'] != '')
{
	logOut();
}
/*volumetric calculation from admin */
$volumetric_divisor    = services_volumetric_charges;
$volumetric_divisor    = ($volumetric_divisor == '') ? ('4000') : ($volumetric_divisor);
/*volumetric calculation from admin */
$csrf = new csrf();
$csrf->action = "index";
if(!isset($_POST['btn_submit']))
{
	/*csrf validation*/
	$ptoken = $csrf->csrfkey();
	/*csrf validation*/
}

//exit();
// && ($_POST['btn_submit']) == 'Next'
//echo "ptoken:".$ptoken;
if(isset($_POST['btn_submit']))
{

	if(isEmpty(valid_input($_POST['ptoken']), true))
	{
		logOut();
	}
	else
	{
		$csrf->checkcsrf($_POST['ptoken']);
	}

	$err = array();
	$pickup  = valid_input($_POST['pickup']);
	$deliver = valid_input($_POST['deliver']);
	$flag    = valid_input($_POST['flage']);
	$item_qty    = $_POST['aus_total_qty'];
	$item_weight = $_POST['Item_weight'];
	$item_length = $_POST['Item_length'];
	$item_width = $_POST['Item_width'];
	$item_height = $_POST['Item_height'];
	$int_country = $_POST['inter_country'];
	$int_weight_item = $_POST['weight_item'];
	$int_length_item = $_POST['length_item'];
	$int_width_item = $_POST['width_item'];
	$int_height_item = $_POST['height_item'];
	//$int_item_type = $_POST['inter_ShippingType'];
	$int_item_type = $_POST['inter_ShippingType_1'][0];

	$original_weight   = $_POST['original_weight_1'];
    $volumetric_weight = $_POST['volumetric_weight'];
	$int_volumetric_weight = $_POST['international_total_volumetric_weight'];
    $int_original_weight   = $_POST['international_total_weight'];
	$pickupid = valid_input($_POST["pickup"]);
	$servicepage = valid_input($_POST["servicepagename"]);

	if(get_time_zonewise($pickupid))
	{
		$start_date = date('Y-m-d H:i', strtotime(get_time_zonewise($pickupid)));
	}
	//echo $start_date;
	//exit();
	/*
	if(isset($_POST['defaultDate']) && trim($_POST['defaultDate'])!="")
	{
		$start_date = date('Y-m-d H:i', strtotime($_POST['defaultDate']));

	}*/

	if(isset($_POST['minDate']) && trim($_POST['minDate'])!="")
	{
		$min_date = date('Y-m-d H:i', strtotime($_POST['minDate']));

	}
	if(empty($min_date))
	{
		$min_date = $start_date;
	}

	if($_POST['last_inserted_cell'])
	{
		$err['last_inserted_cell'] = isNumeric($_POST['last_inserted_cell'], COMMON_NUMERIC_VAL);
	}

	if(!empty($err['last_inserted_cell']))
	{
		logOut();
	}
	if($_POST['aus_total_qty'])
	{
		$err['aus_total_qty'] = isNumeric($_POST['aus_total_qty'], COMMON_NUMERIC_VAL);
	}
	if(!empty($err['aus_total_qty']))
	{
		logOut();
	}
	if($servicepage != '')
	{
		$err['servicepage'] = chkSmall($servicepage);
	}
	if(!empty($err['servicepage']))
	{
		logOut();
	}
	if($flag != '')
	{
		$err['flag'] = isNumeric($flag, COMMON_NUMERIC_VAL);
	}
	if(!empty($err['flag']))
	{
		logOut();
	}

	if($original_weight!='')
	{
		$err['original_weight'] = isNumeric($original_weight, COMMON_NUMERIC_VAL);
	}
	if(!empty($err['original_weight']))
	{
		logOut();
	}
	if($volumetric_weight!='')
	{
		$err['volumetric_weight'] = isNumeric($volumetric_weight, COMMON_NUMERIC_VAL);
	}
	if(!empty($err['volumetric_weight']))
	{
		logOut();
	}

	if($int_original_weight!='')
	{
		$err['int_original_weight'] = isNumeric($int_original_weight, COMMON_NUMERIC_VAL);
	}
	if(!empty($err['int_original_weight']))
	{
		logOut();
	}
	if($int_volumetric_weight!='')
	{
		$err['int_volumetric_weight'] = isNumeric($int_volumetric_weight, COMMON_NUMERIC_VAL);
	}
	if(!empty($err['int_volumetric_weight']))
	{
		logOut();
	}
	if($_POST['weight_max'])
	{
		$err['weightMaxError'] = isFloat($_POST['weight_max'], 'Please enter float value.');
	}
	if(!empty($err['weightMaxError']))
	{
		logOut();
	}
	if($_POST['weight_min'])
	{
		$err['weightMinError'] = isFloat($_POST['weight_min'], 'Please enter float value.');
	}
	if(!empty($err['weightMinError']))
	{
		logOut();
	}
	if($_POST['length_max'])
	{
		$err['lengthMaxError'] = isFloat($_POST['length_max'], 'Please enter float value.');
	}
	if(!empty($err['lengthMaxError']))
	{
		logOut();
	}
	if($_POST['length_min'])
	{
		$err['lengthMinError'] = isFloat($_POST['length_min'], 'Please enter float value.');
	}
	if(!empty($err['lengthMinError']))
	{
		logOut();
	}
	if($_POST['optionsCountry'])
	{
		$err['optionsCountryError'] = chkSmallCapital($_POST['optionsCountry'], 'Please enter proper value.');
	}
	if(!empty($err['optionsCountryError']))
	{
		logOut();
	}
	if($_POST['width_max'])
	{
		$err['widthMaxError'] = isFloat($_POST['width_max'], 'Please enter float value.');
	}
	if(!empty($err['widthMaxError']))
	{
		logOut();
	}
	if($_POST['width_min'])
	{
		$err['widthMinError'] = isFloat($_POST['width_min'], 'Please enter float value.');
	}
	if(!empty($err['widthMinError']))
	{
		logOut();
	}
	if($_POST['height_max'])
	{
		$err['heightMaxError'] = isFloat($_POST['height_max'], 'Please enter float value.');
	}
	if(!empty($err['heightMaxError']))
	{
		logOut();
	}
	if($_POST['Item_qty'])
	{
		$err['Item_qtyError'] = isFloat($_POST['Item_qty'], 'Please enter float value.');
	}
	if(!empty($err['Item_qtyError']))
	{
		logOut();
	}
	if($_POST['height_min'])
	{
		$err['heightMinError'] = isFloat($_POST['height_min'], 'Please enter float value.');
	}
	if(!empty($err['heightMinError']))
	{
		logOut();
	}

	if($original_weight < $volumetric_weight)
	{
		$kg = ceil($volumetric_weight);
	}else{
		$kg = ceil($original_weight);
	}
	if($int_original_weight < $int_volumetric_weight)
	{
		$int_kg = ceil($int_volumetric_weight);
	}else{
		$int_kg = ceil($int_original_weight);
	}
	$err['PICKUPNOTEXISTS'] = isEmpty(valid_input($pickup), SELECT_PICKUP_ITEM);
    if($pickup == 'PICK UP SUBURB/POSTCODE')
	{
        $err['PICKUPNOTEXISTS'] = SELECT_PICKUP_ITEM;
    }
	if(!empty($pickup) && $pickup != 'PICK UP SUBURB/POSTCODE')
	{
        $err['PICKUPNOTEXISTS'] = chkStr(valid_input($pickup));
    }

	if(isset($flag) && $flag == 1)
	{
		$err['DELIVERNOTEXISTS'] = isEmpty(valid_input($deliver), SELECT_DELIVER_ITEM);
        if ($deliver == 'DELIVERY SUBURB/POSTCODE')
		{
            $err['DELIVERNOTEXISTS'] = SELECT_DELIVER_ITEM;
        }
        if(!empty($deliver) && $deliver != 'DELIVERY SUBURB/POSTCODE')
		{
            $err['DELIVERNOTEXISTS'] = chkStr(valid_input($deliver));
        }
		$countitem = count($_POST["Item_weight"]);

		$BookingItemDetailsDataObjArray = array();
		for($i=0;$i<($countitem-1);$i++)
		{
			$org_weight_name = "Item_weight";
			$length_name = "Item_length";
			$width_name = "Item_width";
			$height_name = "Item_height";

			$BookingItemDetailsDataObj = new stdClass;
			$BookingItemDetailsDataObj->booking_id = valid_input($bookingid);
			$BookingItemDetailsDataObj->quantity = valid_input($_POST['aus_total_qty']);
			$BookingItemDetailsDataObj->item_weight = valid_input($_POST[$org_weight_name][$i]);
			$BookingItemDetailsDataObj->length = valid_input($_POST[$length_name][$i]);
			$BookingItemDetailsDataObj->width = valid_input($_POST[$width_name][$i]);
			$BookingItemDetailsDataObj->height = valid_input($_POST[$height_name][$i]);

			$BookingItemDetailsDataObj->vol_weight=ceil(((valid_input($_POST[$width_name][$i])*valid_input($_POST[$length_name][$i])*valid_input($_POST[$height_name][$i]))/$volumetric_divisor)*valid_input($_POST['Item_qty']));
			//list multiple items
			$BookingItemDetailsDataObjArray[$i] = (array)$BookingItemDetailsDataObj;
			//echo "original weight:".$_POST[$org_weight_name][$i]."</br>";
		}


		$BookingItemDetailsData = new stdClass;
		foreach ($BookingItemDetailsDataObjArray as $key => $val) {
			$BookingItemDetailsData1 = new stdClass;
			foreach ($val as $kky => $val1) {
				$BookingItemDetailsData1->{$kky} = $val1;
			}
			$BookingItemDetailsData->{$key} = $BookingItemDetailsData1;
		}

		$qty_status = array();
		$dim_status = array();
		$weight_status = array();
		/*echo "<pre>";
		print_R($_POST);
		echo "</pre>";*/
		//echo "count value:".count($_POST['Item_weight']);
		for($i=0;$i<$countitem-1;$i++)
		{

			$multi_err['weightError'][$i] = isEmpty($item_weight[$i], COMMON_WEIGHT_IS_REQUIRED) ? isEmpty($item_weight[$i], COMMON_WEIGHT_IS_REQUIRED) : isFloat($item_weight[$i], 'Please enter float value.');
			$multi_err['lengthError'][$i] = isEmpty($item_length[$i], COMMON_LENGTH_IS_REQUIRED) ? isEmpty($item_length[$i], COMMON_LENGTH_IS_REQUIRED) : isNumeric($item_length[$i], COMMON_NUMERIC_VAL);
			$multi_err['widthError'][$i]  = isEmpty($item_width[$i], COMMON_WIDTH_IS_REQUIRED) ? isEmpty($item_width[$i], COMMON_WIDTH_IS_REQUIRED) : isNumeric($item_width[$i], COMMON_NUMERIC_VAL);
			$multi_err['heightError'][$i] = isEmpty($item_height[$i], COMMON_HEIGHT_IS_REQUIRED) ? isEmpty($item_height[$i], COMMON_HEIGHT_IS_REQUIRED) : isNumeric($item_height[$i], COMMON_NUMERIC_VAL);


			//if(valid_input($item_weight[$i]) != 0)
			//{

				$fieldArr = array("*");
				$seaPageArr = array();
				$seaPageArr[] = array('Search_On'=>'service_page_name', 'Search_Value'=>$servicepage, 'Type'=>'string', 'Equation'=>'=', 'CondType'=>'AND', 'Prefix'=>'', 'Postfix'=>'');
				$seaPageArr[] = array('Search_On'=>'item_type', 'Search_Value'=>$selShippingType[0], 'Type'=>'string', 'Equation'=>'=', 'CondType'=>'AND', 'Prefix'=>'', 'Postfix'=>'');
				$pageData = $ObjServicePageIndexMaster->getServicePageName($fieldArr, $seaPageArr);
				$pageData = $pageData[0];
				if(!empty($pageData))
				{

					if($pageData['weight_status']=='1' && (($item_weight[$i]) < $pageData['weight_min']) || (($item_weight[$i]) > $pageData['weight_max']))
					{

						$multi_err['weightError'][$i] = 'Weight between </br>'.$pageData['weight_min'].' kgs and '.$pageData['weight_max'].' kgs';
					}

					if($pageData['weight_status']!="")
					{
						$weight_status[$i] = $pageData['weight_status'];
					}

					if($pageData['dim_status']=='1' && ((($item_length[$i])<$pageData['length_min']) || (($item_length[$i])>$pageData['length_max'])))
					{
						$multi_err['lengthError'][$i] = 'Length between </br>'.$pageData['length_min'].' cm and  '.$pageData['length_max'].' cm';
					}
					if($pageData['dim_status']=='1' && ((($item_width[$i])<$pageData['width_min']) || (($item_width[$i])>$pageData['width_max'])))
					{
						$multi_err['widthError'][$i] = 'Width between </br>'.$pageData['width_min'].' cm and  '.$pageData['width_max'].' cm';
					}
					if($pageData['dim_status']=='1' && ((($item_height[$i])<$pageData['height_min']) || (($item_height[$i])>$pageData['height_max'])))
					{
						$multi_err['heightError'][$i] = 'Height between </br>'.$pageData['height_min'].' cm and '.$pageData['height_max'].' cm';
					}

					if($pageData['dim_status']!="")
					{
						$dim_status[$i] = $pageData['dim_status'];
					}

				}
			//}
		}


	}

	if(isset($flag) && $flag == 2)
	{

		if($int_country == 'SELECT COUNTRY')
		{
		  $err['interError'] = SELECT_INTERNATIONAL_COUNTRY;
		}
		if($int_country != 'SELECT COUNTRY' && $int_country !='')
		{
			$err['interError'] = isNumeric($int_country, COMMON_NUMERIC_VAL);
		}
		if(!empty($err['interError']))
		{
			logOut();
		}

		$inter_rows = count($int_weight_item);
		$BookingItemDetailsDataObjArray =array();
		for ($i=0;$i<$inter_rows-1;$i++)
		{
			$BookingItemDetailsDataObj = new stdClass;
			$BookingItemDetailsDataObj->item_type = $int_item_type;
			$BookingItemDetailsDataObj->item_weight = $int_weight_item[$i];
			$BookingItemDetailsDataObj->length = $int_length_item[$i];
			$BookingItemDetailsDataObj->width = $int_width_item[$i];
			$BookingItemDetailsDataObj->height = $int_height_item[$i];
			$BookingItemDetailsDataObj->vol_weight = ceil((($int_length_item[$i]*$int_width_item[$i]*$int_height_item[$i])/$volumetric_divisor)*1);
			$BookingItemDetailsDataObjArray[$i] = (array)$BookingItemDetailsDataObj;
		}
		$BookingItemDetailsData = new stdClass;
		foreach ($BookingItemDetailsDataObjArray as $key => $val) {
			$BookingItemDetailsData1 = new stdClass;
			foreach ($val as $kky => $val1) {
				$BookingItemDetailsData1->{$kky} = $val1;
			}
			$BookingItemDetailsData->{$key} = $BookingItemDetailsData1;
		}

		$int_dim_status = array();
		$int_weight_status = array();

		for($j=0;$j<count($int_weight_item)-1;$j++)
		{

			$multi_err['intweightError'][$j] = isEmpty($int_weight_item[$j], COMMON_WEIGHT_IS_REQUIRED) ? isEmpty($int_weight_item[$j], COMMON_WEIGHT_IS_REQUIRED) : isFloat($int_weight_item[$j],"Please enter float value.");
			$multi_err['intlengthError'][$j] = isEmpty($int_length_item[$j], COMMON_LENGTH_IS_REQUIRED) ? isEmpty($int_length_item[$j], COMMON_LENGTH_IS_REQUIRED) : isNumeric($int_length_item[$j], COMMON_NUMERIC_VAL);
			$multi_err['intwidthError'][$j]  = isEmpty($int_width_item[$j], COMMON_WIDTH_IS_REQUIRED) ? isEmpty($int_width_item[$j], COMMON_WIDTH_IS_REQUIRED) : isNumeric(valid_input($_POST['width_item'][$j]), COMMON_NUMERIC_VAL);
			$multi_err['intheightError'][$j] = isEmpty($int_height_item[$j], COMMON_HEIGHT_IS_REQUIRED) ? isEmpty($int_height_item[$j], COMMON_HEIGHT_IS_REQUIRED) : isNumeric(valid_input($_POST['height_item'][$j]), COMMON_NUMERIC_VAL);

			$fieldArr = array("*");
			$seaPageArr = array();
			$seaPageArr[] = array('Search_On'=>'service_page_name', 'Search_Value'=>$servicepage, 'Type'=>'string', 'Equation'=>'=', 'CondType'=>'AND', 'Prefix'=>'', 'Postfix'=>'');
			$seaPageArr[] = array('Search_On'=>'item_type', 'Search_Value'=>$int_item_type, 'Type'=>'string', 'Equation'=>'=', 'CondType'=>'AND', 'Prefix'=>'', 'Postfix'=>'');
			$pageData = $ObjServicePageIndexMaster->getServicePageName($fieldArr, $seaPageArr);
			$pageData = $pageData[0];
			//$int_qty_item = 14;
			//$int_weight_item = 30;
			if(!empty($pageData))
			{

				if($pageData['weight_status']=='1' && (($int_weight_item[$j]) < $pageData['weight_min']) || (($int_weight_item[$j]) > $pageData['weight_max']))
				{
					$multi_err['intweightError'][$j] = 'Weight between </br>'.$pageData['weight_min'].' kgs and '.$pageData['weight_max'].' kgs';
				}
				if($pageData['weight_status']!="")
				{
					$int_weight_status[$j] = $pageData['weight_status'];
				}

				if($pageData['dim_status']=='1' && ((($int_length_item[$j])<$pageData['length_min']) || (($int_length_item[$j])>$pageData['length_max'])))
				{
					$multi_err['intlengthError'][$j] = 'Length between </br>'.$pageData['length_min'].' cm and  '.$pageData['length_max'].' cm';
				}
				if($pageData['dim_status']=='1' && ((($int_width_item[$j])<$pageData['width_min']) || (($int_width_item[$j])>$pageData['width_max'])))
				{
					$multi_err['intwidthError'][$j] = 'Width between </br>'.$pageData['width_min'].' cm and  '.$pageData['width_max'].' cm';
				}
				if($pageData['dim_status']=='1' && ((($int_height_item[$j])<$pageData['height_min']) || (($int_height_item[$j])>$pageData['height_max'])))
				{
					$multi_err['intheightError'][$j] = 'Height between </br>'.$pageData['height_min'].' cm and '.$pageData['height_max'].' cm';
				}

				if($pageData['dim_status']!="")
				{
					$int_dim_status[$j] = $pageData['dim_status'];
				}
			}
		}
	}
	foreach ($err as $key => $Value) {
		if ($Value != '') {
            $Svalidation = true;
			/*csrf validation*/
			$ptoken = $csrf->csrfkey();
			/*csrf validation*/
        }
    }

	/* this is for selecting multiple items row */
	if(isset($multi_err) && $multi_err!="")
	{
		foreach ($multi_err as $key => $Value) {
			foreach ($Value as $kky => $val1) {
					if ($val1 != '') {
					$Svalidation = true;
					/*csrf validation*/
					$ptoken = $csrf->csrfkey();
					/*csrf validation*/
				}
			}
		}
	}


	$fieldArr = array("*");
	$DataSuppliers=$ObjSupplierMaster->getSupplier($fieldArr);
	$suppier_fuel_charge=array();
	foreach ($DataSuppliers as $DataSupplier){
		$suppier_fuel_charge[$DataSupplier->auto_id]=$DataSupplier->fuel_charge;
	}

	$metrozones = explode(",",zones_within_australia); /*Used to create array for the zones within australia. */

	if($pickup != "PICK UP SUBURB/POSTCODE" && $Svalidation == false){
		$o_st_city_zone = getDirectZoneFromSt($pickup); /* Direct Zones from startrack table */
		$pic_msg_arr = getMessengerZone($pickup); /* zone from messenger */
		$o_city_zone = $pic_msg_arr['charging_zone'];
		$o_city_name = $pic_msg_arr['Name'];
		$o_city_postcode = $pic_msg_arr['Postcode'];
		$pickuptimezone = $pic_msg_arr['time_zone'];
		$o_city_msg_arr = getMessengerValid($o_city_name,$o_city_postcode);
		$o_city_msg_courier = $o_city_msg_arr['Courier'];
		$o_city_msg_state = $o_city_msg_arr['State'];
		$pickupid = $pic_msg_arr['id'];
	}
	$_SESSION['pagename']="index";
	if(($deliver != "ENTER SUBURB OR POSTCODE")&&($flag == "1") && $Svalidation == false){
		$d_st_city_zone = getDirectZoneFromSt($deliver); /* Direct Zones from startrack table */
		$del_msg_arr = getMessengerZone($deliver);
		$d_city_zone = $del_msg_arr['charging_zone'];
		$d_city_postcode = $del_msg_arr['Postcode'];
		$delivertimezone = $del_msg_arr['time_zone'];
		$d_city_name = $del_msg_arr['Name'];
		$d_city_msg_arr = getMessengerValid($d_city_name,$d_city_postcode);
		$d_city_msg_courier = $d_city_msg_arr['Courier'];
		$d_city_msg_state = $d_city_msg_arr['State'];
		$deliverid = $del_msg_arr['id'];
	}


	if($o_city_msg_courier == 'Y' && $d_city_msg_courier == 'Y')
	{
		$msg_courier = true;
	}

	if(!empty($metrozones))
	{
		foreach($metrozones as $metrozone)
		{
			if(strpos($metrozone,$o_city_msg_state)!='')
			{
				$o_metro_valid_state_arr = explode("-",$metrozone);
				$o_metro_valid_state = $o_metro_valid_state_arr[0];
			}
			if(strpos($metrozone,$d_city_msg_state)!='')
			{
				$d_metro_valid_state_arr = explode("-",$metrozone);
				$d_metro_valid_state = $d_metro_valid_state_arr[0];
			}
		}
	}

	if(empty($o_metro_valid_state) || empty($d_metro_valid_state))
	{
		$cond_metro = false;
	}

	/* Below condition is for testing its from same zone of metro or not */
	if($Svalidation == false && $o_metro_valid_state == $d_metro_valid_state && $flag == 1 && $msg_courier == true)
	{
		$code_format_id = 3;
		$cond_metro = true;
		$service_local = 1;
		if($pickupid!='' && $deliverid !='')
		{
			$dis = distanceKm($pickupid,$deliverid);
		}
		//echo "distance:".$dis;
		//exit();
		if(!empty($o_metro_valid_state) && !empty($d_metro_valid_state))
		{

			$metroresult = totalServices($o_metro_valid_state,$d_metro_valid_state);
		}
		if($metroresult != "")
		{
			$metro_no = mysqli_num_rows($metroresult);
		}

		if($metro_no ==0)
		{
			$err['no_service_available'] = NO_SERVICE_AVAILABLE;

		}

		if($metro_no!=0){
			$k=0;
			$msg_fee_flag = 0;

			while($row = mysqli_fetch_array($metroresult)){


				$ser_code = $row['service_code'] ;
				$service_val = getServiceData($ser_code,$code_format_id);
				$service_val = $service_val[0];


				$valid = 0;
				for($i=0;$i<count($selShippingType[0]);$i++)
				{
					if($service_val['qty_status']=='1' && ((($item_qty[$i])<$service_val['qty_min']) || (($item_qty[$i])>$service_val['qty_max'])))
					{

						$valid = 1;
					}
					if($service_val['weight_status']=='1' && ((($item_weight[$i])<$service_val['weight_min']) || (($item_weight[$i])>$service_val['weight_max'])))
					{
						$valid = 1;
					}

					if($service_val['dim_status']=='1' && (($item_length[$i]<$service_val['len_min']) || ($item_length[$i]>$service_val['len_max'])))
					{
						$valid = 1;
					}
					if($service_val['dim_status']=='1' && (($item_width[$i]<$service_val['width_min']) || ($item_width[$i]>$service_val['width_max'])))
					{
						$valid = 1;
					}
					if($service_val['dim_status']=='1' && (($item_height[$i]<$service_val['height_min']) || ($item_height[$i]>$service_val['height_max'])))
					{
						$valid = 1;
					}

				}

				if($valid == 1)
				{
					continue;
				}
				if(!empty($service_val))
				{
					$service = strtolower($service_val['service_code']);

					$base_tariff = $city.$service;

					$base_tariff_destination = $d_metro_valid_state.$service;

					$service_data[$k]['service_name'] = $service_val['service_name'];
					$service_data[$k]['service_code'] = $service_val['service_code'];
					$service_data[$k]['supplier_name'] = $service_val['supplier_name'];
					$supplier_id = $service_val['supplier_id'];

					if($drc==1){
						$surcharge=number_format($service_val->surcharge,2,'.','');
						$service_data[$k]['surcharge'] = number_format($service_val->surcharge,2,'.','');
					}else{
						$surcharge=0;
						$service_data[$k]['surcharge'] = 0;
					}
					$totalweight = $kg;

					/* condition for outbound */
					if($o_metro_valid_state!='')
					{
						$base_tariff = strtolower($o_metro_valid_state.$service);
						$base_tariff = outboundDir($base_tariff);
						$tbl = checkTableExit($base_tariff);

						if($tbl!='' && $supplier_id == 3 && $cond_metro == true)
						{
							$service_data[$k]['service_rate'] = cal_val_direct($base_tariff,$kg,$tbl,$dis);
						}
					}

					/* condition for outbound */

					/* condition for inbound */
					if($d_metro_valid_state!='')
					{
						$base_tariff = strtolower($d_metro_valid_state.$service);
						$base_tariff = inboundDir($base_tariff);
						$tbl = checkTableExit($base_tariff);

						if($tbl!='' && $supplier_id == 3 && $cond_metro == true)
						{
							$service_data[$k]['service_rate'] = cal_val_direct($base_tariff,$kg,$tbl,$dis);
						}
					}

					/* condition for inbound */

					/* condition for both */
					if($service_data[$k]['service_rate'] == 0)
					{
						$base_tariff = strtolower($o_metro_valid_state.$service);
						$base_tariff = bothDir($base_tariff);
						$tbl = checkTableExit($base_tariff);
						$dest = $deliver;
						if($tbl === 0)
						{
							$base_tariff = strtolower($d_metro_valid_state.$service);
							$base_tariff = bothDir($base_tariff);
							$tbl = checkTableExit($base_tariff);
							$dest = $pickup;
						}

						if($tbl!='' && $supplier_id == 3 && $cond_metro == true)
						{
							$service_data[$k]['service_rate'] = cal_val_direct($base_tariff,$kg,$tbl,$dis);
						}
					}

					/* condition for both */

					/* condition for zzz */
					if($service_data[$k]['service_rate'] == 0)
					{
						$base_tariff = strtolower('zzz'.$service);
						$base_tariff = bothDir($base_tariff);

						$tbl = checkTableExit($base_tariff);

						if($tbl!='' && $supplier_id == 3 && $cond_metro == true)
						{
							$service_data[$k]['service_rate'] = cal_val_direct($base_tariff,$kg,$tbl,$dis);
						}
					}

					/* condition for zzz */
					if($service_data[$k]['service_rate'] != 0)
					{
						$gst = GST;
						$service_data[$k]['delivery_fee'] = number_format($service_data[$k]['service_rate'],2,'.','');
						$service_data[$k]['fuel_surcharge'] = calculate_fuel_charge($suppier_fuel_charge[$service_val['supplier_id']],$service_data[$k]['service_rate']);
						$service_data[$k]['base_fuel_fee'] = $suppier_fuel_charge[$service_val['supplier_id']];
						$total_gst = calculate_gst_charge($gst,calculate_charge($suppier_fuel_charge[$service_val['supplier_id']],$service_data[$k]['service_rate'],$$surcharge));
						$service_data[$k]['total_gst'] = $total_gst;
						$service_data[$k]['total_delivery_fee'] = calculate_charge($suppier_fuel_charge[$service_val['supplier_id']],$service_data[$k]['service_rate'],$surcharge);
						$service_data[$k]['service_rate'] =calculate_charge_with_gst(calculate_charge($suppier_fuel_charge[$service_val['supplier_id']],$service_data[$k]['service_rate'],$surcharge),$total_gst);
						$msg_fee_flag = 1;
					}

					$k++;
				}
			}

		}


	}

	if($flag == 1 && $Svalidation == false)
	{
		/* Star track format is calculated here */
		$code_format_id = 0;
		if(!empty($o_st_city_zone) && !empty($d_st_city_zone))
		{
			$result = totalServices('','',$code_format_id);
		}

		if($result != "")
		{
			$no = mysqli_num_rows($result);
		}
		if($no ==0)
		{
			$err['no_service_available'] = NO_SERVICE_AVAILABLE;

		}

		if($no!=0){
			if($metro_no!=0)
			{
				if($k)
				{
					$l=$k;
				}
			}else{
				$l=0;
			}


			if(empty($service_local))
			{
				$service_local = 2;
			}
			$star_fee_flag = 0;
			while($row = mysqli_fetch_array($result)){
				$ser_code = $row['service_code'] ;
				//echo "service code:".$ser_code."</br>";
				$service_val = getServiceData($ser_code,$code_format_id,$cond_metro);
				$service_val = $service_val[0];
				//echo $service_val['service_code']."</br>";
				$intravalid = 0;

				for($i=0;$i<count($selShippingType[0]);$i++)
				{
					//echo "item weight:".$item_weight[$i]." ".$service_val['weight_status']." ".$service_val['weight_min']." ".$service_val['weight_max']."</br>";
					if($service_val['weight_status']=='1' && ((($item_weight[$i])<$service_val['weight_min']) || (($item_weight[$i])>$service_val['weight_max'])))
					{
						$intravalid = 1;
					}

					if($service_val['dim_status']=='1' && (($item_length[$i]<$service_val['len_min']) || ($item_length[$i]>$service_val['len_max'])))
					{
						$intravalid = 1;
					}
					if($service_val['dim_status']=='1' && (($item_width[$i]<$service_val['width_min']) || ($item_width[$i]>$service_val['width_max'])))
					{
						$intravalid = 1;
					}
					if($service_val['dim_status']=='1' && (($item_height[$i]<$service_val['height_min']) || ($item_height[$i]>$service_val['height_max'])))
					{
						$intravalid = 1;
					}

				}
				if($intravalid == 1)
				{
					continue;
				}
				if(!empty($service_val))
				{

					$service = strtolower($service_val['service_code']);
					$base_tariff = $city.$service;
					$base_tariff_destination = $d_st_city_zone.$service;
					$supplier_id = $service_val['supplier_id'];
					$totalweight = $kg;
					$service_rate = 0;

					/* condition for both */
					if($service_rate == 0)
					{
						$base_tariff = strtolower('aus'.$service);


						$base_tariff = bothDir($base_tariff);
						$tbl = checkTableExit($base_tariff);
						//echo "base tariff:".$base_tariff."</br>";echo "table:".$tbl."</br>";
						//echo "supplier id:".$supplier_id."</br>";
						if($tbl!='' && $supplier_id == 0)
						{
							$service_rate = cal_val($base_tariff,$kg,$tbl,$o_st_city_zone,$d_st_city_zone);
						}

					}
					/* condition for both */


					/* condition for zzz */
					if($service_rate == 0)
					{
						$base_tariff = strtolower('zzz'.$service);
						$base_tariff = bothDir($base_tariff);

						$tbl = checkTableExit($base_tariff);
						if($tbl!='' && $supplier_id == 0)
						{
							$service_rate = cal_val($base_tariff,$kg,$tbl,$o_st_city_zone,$d_st_city_zone);
						}

					}
					/* condition for zzz */

					if($service_rate != 0)
					{
						$gst = GST;
						$service_data[$l]['service_name'] = $service_val['service_name'];
						$service_data[$l]['service_code'] = $service_val['service_code'];
						$service_data[$l]['supplier_name'] = $service_val['supplier_name'];

						if($drc==1){
							$surcharge=number_format($service_val->surcharge,2,'.','');
							$service_data[$l]['surcharge']=number_format($service_val->surcharge,2,'.','');
						}else{
							$surcharge=0;
							$service_data[$l]['surcharge']=0;
						}
						//echo $service_data[$l]['service_rate']."</br>";
						$service_data[$l]['service_rate'] = $service_rate;
						$service_data[$l]['delivery_fee'] = number_format($service_data[$l]['service_rate'],2,'.','');
						$service_data[$l]['fuel_surcharge'] = calculate_fuel_charge($suppier_fuel_charge[$service_val['supplier_id']],$service_data[$l]['service_rate']);
						$service_data[$l]['base_fuel_fee'] = $suppier_fuel_charge[$service_val['supplier_id']];
						$total_gst = calculate_gst_charge($gst,calculate_charge($suppier_fuel_charge[$service_val['supplier_id']],$service_data[$l]['service_rate'],$surcharge));
						$service_data[$l]['total_gst'] = $total_gst;
						$service_data[$l]['total_delivery_fee'] = calculate_charge($suppier_fuel_charge[$service_val['supplier_id']],$service_data[$l]['service_rate'],$surcharge);
						$service_data[$l]['service_rate'] =calculate_charge_with_gst(calculate_charge($suppier_fuel_charge[$service_val['supplier_id']],$service_data[$l]['service_rate'],$surcharge),$total_gst);

						$star_fee_flag = 1;

					}
					$l++;
				}
			}

			$code_format_id = 2;

		}
		/* End  Star track format is calculated here */

		/* TNT format is calculated here */
		$code_format_id = 2;
		if(!empty($o_st_city_zone) && !empty($d_st_city_zone))
		{
			$tntresult = totalServices('','',$code_format_id);
		}
		if($tntresult != "")
		{
			$tntno = mysqli_num_rows($tntresult);
		}
		if($tntno ==0)
		{
			$err['no_service_available'] = NO_SERVICE_AVAILABLE;

		}
		if($tntno!=0){
			if($l)
			{
				$t=$l;

			}else{
				$t=0;
			}

			while($tntrow = mysqli_fetch_array($tntresult)){
				$tnt_ser_code = $tntrow['service_code'] ;
				$tnt_service_val = getServiceData($tnt_ser_code,$code_format_id,$cond_metro);
				$tnt_service_val = $tnt_service_val[0];
				//echo $tnt_service_val['service_code']."</br>";
				$tntvalid = 0;
				for($s=0;$s<count($selShippingType[0]);$s++)
				{
					if($tnt_service_val['weight_status']=='1' && ((($item_weight[$s])<$tnt_service_val['weight_min']) || (($item_weight[$s])>$tnt_service_val['weight_max'])))
					{
						$tntvalid = 1;
					}

					if($tnt_service_val['dim_status']=='1' && (($item_length[$s]<$tnt_service_val['len_min']) || ($item_length[$s]>$tnt_service_val['len_max'])))
					{
						$tntvalid = 1;
					}
					if($tnt_service_val['dim_status']=='1' && (($item_width[$s]<$tnt_service_val['width_min']) || ($item_width[$s]>$tnt_service_val['width_max'])))
					{
						$tntvalid = 1;
					}
					if($tnt_service_val['dim_status']=='1' && (($item_height[$s]<$tnt_service_val['height_min']) || ($item_height[$s]>$tnt_service_val['height_max'])))
					{
						$tntvalid = 1;
					}

				}
				if($tntvalid == 1)
				{
					continue;
				}

				if(!empty($tnt_service_val))
				{
					$service = strtolower($tnt_service_val['service_code']);
					$base_tariff = $city.$service;
					$base_tariff_destination = $d_st_city_zone.$service;
					$supplier_id = $tnt_service_val['supplier_id'];
					$totalweight = $kg;
					$tnt_service_rate = 0;
					//echo "supplier id:".$supplier_id;
					/* condition for both */
					if($tnt_service_rate == 0)
					{
						$base_tariff = strtolower('tnt'.$service);
						$base_tariff = bothDir($base_tariff);
						//echo "base tariff:".$base_tariff;
						$tbl = checkTableExit($base_tariff);
						//echo "tbl:".$tbl;
						if($tbl!='' && $supplier_id == 8)
						{
							$tnt_service_rate = cal_val_tnt($base_tariff,$kg,$tbl,$o_st_city_zone,$d_st_city_zone);
						}

					}
					/* condition for both */


					/* condition for zzz */
					if($tnt_service_rate == 0)
					{
						$base_tariff = strtolower('zzz'.$service);
						$base_tariff = bothDir($base_tariff);

						$tbl = checkTableExit($base_tariff);
						if($tbl!='' && $supplier_id == 8)
						{
							$tnt_service_rate = cal_val_tnt($base_tariff,$kg,$tbl,$o_st_city_zone,$d_st_city_zone);
						}

					}
					/* condition for zzz */
					//echo "value of t".$t."</br>";
					if($tnt_service_rate != 0)
					{
						$gst = GST;
						$service_data[$t]['service_name'] = $tnt_service_val['service_name'];
						$service_data[$t]['service_code'] = $tnt_service_val['service_code'];
						$service_data[$t]['supplier_name'] = $tnt_service_val['supplier_name'];

						if($drc==1){
							$surcharge=number_format($tnt_service_val->surcharge,2,'.','');
							$service_data[$t]['surcharge']=number_format($service_val->surcharge,2,'.','');
						}else{
							$surcharge=0;
							$service_data[$t]['surcharge']=0;
						}
						//echo $service_data[$l]['service_rate']."</br>";
						$service_data[$t]['service_rate'] = $tnt_service_rate;
						$service_data[$t]['delivery_fee'] = number_format($service_data[$t]['service_rate'],2,'.','');
						$service_data[$t]['fuel_surcharge'] = calculate_fuel_charge($suppier_fuel_charge[$tnt_service_val['supplier_id']],$service_data[$t]['service_rate']);
						$service_data[$t]['base_fuel_fee'] = $suppier_fuel_charge[$tnt_service_val['supplier_id']];
						$total_gst = calculate_gst_charge($gst,calculate_charge($suppier_fuel_charge[$tnt_service_val['supplier_id']],$service_data[$t]['service_rate'],$surcharge));
						$service_data[$t]['total_gst'] = $total_gst;
						$service_data[$t]['total_delivery_fee'] = calculate_charge($suppier_fuel_charge[$tnt_service_val['supplier_id']],$service_data[$t]['service_rate'],$surcharge);
						$service_data[$t]['service_rate'] =calculate_charge_with_gst(calculate_charge($suppier_fuel_charge[$tnt_service_val['supplier_id']],$service_data[$t]['service_rate'],$surcharge),$total_gst);

						$star_fee_flag = 1;

					}
					$t++;


				}
			}

		}
		/* TNT format is calculated here */
		//exit();
		if(($flag == "1" && $msg_fee_flag == 1 && $star_fee_flag == 1) || ($flag == "1" && $msg_fee_flag == 1 && $star_fee_flag == 0) || ($flag == "1" && $msg_fee_flag == 0 && $star_fee_flag == 1)){

			require_once(DIR_WS_RELATED."domestic_service_multi.php");
		}
	}else{

		if($Svalidation == false)
		{

			$result = totalServices('','in');

			$code_format_id = 4;
			if($result != "")
			{
				$no = mysqli_num_rows($result);
			}

			if($no != 0){
				$m=0;
				while($row = mysqli_fetch_array($result)){

					$ser_code = $row['service_code'] ;
					$service_val = getServiceData($ser_code,$code_format_id);
					$service_val = $service_val[0];
					$service = strtolower($service_val['service_code']);

					$intervalid = 0;
					for($j=0;$j<count($int_weight_item);$j++)
					{

						if($service_val['weight_status']=='1' && ((($int_weight_item[$j])<$service_val['qty_min']) || (($int_weight_item[$j])>$service_val['qty_max'])))
						{
							$intervalid = 1;
						}

						if($service_val['dim_status']=='1' && (($int_length_item[$j]<$service_val['len_min']) || ($int_length_item[$j]>$service_val['len_max'])))
						{
							$intervalid = 1;
						}
						if($service_val['dim_status']=='1' && (($int_width_item[$j]<$service_val['width_min']) || ($int_width_item[$j]>$service_val['width_max'])))
						{
							$intervalid = 1;
						}
						if($service_val['dim_status']=='1' && (($int_height_item[$j]<$service_val['height_min']) || ($int_height_item[$j]>$service_val['height_max'])))
						{
							$intervalid = 1;
						}

					}

					if($intervalid == 1)
					{
						continue;
					}
					if(!empty($service_val))
					{
						$service_data[$m]['service_name'] = $service_val['service_name'];
						$service_data[$m]['service_code'] = $service_val['service_code'];
					if($o_st_city_zone!='')
					{
						$base_tariff = strtolower($o_st_city_zone.$service);
						$base_tariff = outboundDir($base_tariff);
						$tbl = checkTableExit($base_tariff);

					}
					if($tbl == 0)
					{

						$base_tariff = 'zzz'.$service;
						$base_tariff = bothDir($base_tariff);
						$tbl = checkTableExit($base_tariff);
					}
					$totalweight = $int_kg;
					$seaArr="";
					$fieldArr = array("id","zone","country");

					$seaArr[] = array('Search_On'=>'id','Search_Value'=>$int_country, 'Type'=>'int', 'Equation'=>'=', 'CondType'=>'', 'Prefix'=>'', 'Postfix'=>'');
					$Internationaldata = $InternationalzonesMasterObj->getInternationalZones($fieldArr,$seaArr);
					foreach($Internationaldata as $Internationaldataval){
						$deliverinterzone=$Internationaldataval['zone'];/* Selected the zone on the basis of delivery id for international zones*/
						$_SESSION['international_country_name']=$Internationaldataval['country'];
					}

					$service_data[$m]['service_rate'] = cal_val_int($base_tariff,$int_item_type,$int_kg,$tbl,$deliverinterzone);
					//echo "service data tariff:".$service_data[$m]['service_rate'];
					//exit();
					if($drc==1){
						$surcharge=number_format($service_val->surcharge,2,'.','');
						$service_data[$m]['surcharge']=number_format($service_val->surcharge,2,'.','');
					}else{
						$surcharge=0;
						$service_data[$m]['surcharge']=0;
					}
					//echo "service code:".$service_data[$m]['service_rate'];
					if($service_data[$m]['service_rate'] != 0)
					{
						$service_data[$m]['delivery_fee'] = number_format($service_data[$m]['service_rate'],2,'.','');
						$service_data[$m]['fuel_surcharge'] = calculate_fuel_charge($suppier_fuel_charge[$service_val['supplier_id']],$service_data[$m]['service_rate']);

						$service_data[$m]['base_fuel_fee'] = $suppier_fuel_charge[$service_val['supplier_id']];
						$service_data[$m]['total_delivery_fee'] = calculate_charge($suppier_fuel_charge[$service_val['supplier_id']],$service_data[$m]['service_rate'],$surcharge);
						$service_data[$m]['service_rate'] =$service_data[$m]['total_delivery_fee'];
					}

					if(((isset($_GET['bookingid'])) || $service_data[$m]['service_rate'] != 0 )	){

						require_once(DIR_WS_RELATED."international_service_multi.php");
					}
					$m++;
				  }
				}
			}
			exit();
		}
	}
}

require_once( DIR_WS_SITE_CURRENT_TEMPLATE . FILE_MAIN_INTERFACE);
?>
