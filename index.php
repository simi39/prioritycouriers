<?php
session_start();
require_once("lib/common.php");
require_once("lib/bcrypt.php");
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
require_once(DIR_WS_MODEL ."CountryMaster.php");/* Zones are selected form this table(For International selection) .*/
require_once(DIR_WS_RELATED.'system_mail.php');
require_once(DIR_WS_MODEL ."InternationalRatesMaster.php");/* Based on zones rates were selected form this table(For International selection) .*/
require_once(DIR_WS_MODEL ."ClientAddressMaster.php");
require_once(DIR_WS_MODEL . "ServicePageMaster.php");

//echo FILE_CMS_SERVICES;
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

$CountryMasterObj = new CountryMaster();
$CountryMasterObj = $CountryMasterObj->Create();
$CountryData  = new CountryData();
$InternationalRatesMasterObj= new InternationalRatesMaster();
$InternationalRatesMasterObj = $InternationalRatesMasterObj->create();
$InternationalRatesDataobj = new InternationalRatesData();
$ObjServicePageIndexMaster= new ServicePageMaster();
$ObjServicePageIndexMaster	= $ObjServicePageIndexMaster->Create();
$ServicePageData		= new ServicePageData();

$arr_css_plugin_include[] = 'flexslider/flexslider.css"  media="screen';
$arr_css_plugin_include[] = 'parallax-slider/css/parallax-slider.css';
$arr_css_plugin_include[] = 'glyphicons_new/css/glyphicons.css';
$arr_css_plugin_include[] = 'waitMe/css/waitMe.min.css';
$arr_javascript_plugin_include[] = 'flexslider/jquery.flexslider-min.js';
$arr_javascript_plugin_include[] = 'parallax-slider/js/modernizr.js';
$arr_javascript_plugin_include[] = 'parallax-slider/js/jquery.cslider.js';
$arr_javascript_plugin_include[] = 'back-to-top.js';
$arr_javascript_plugin_include[] = 'moment/js/moment-with-locales.min.js';
$arr_javascript_include[] = 'pages/index.js';
$arr_javascript_include[] = 'internal/ajex.js';
$arr_javascript_include[] = 'internal/ajax-dynamic-list.js';
$arr_javascript_below_include[] = 'internal/index.php';
$arr_javascript_include[] = 'internal/pickup.php';
$arr_javascript_plugin_include[] = 'waitMe/js/waitMe.min.js';


if(isset($__Session))
{
	$session_data = $__Session->GetValue("_sess_login_userdetails");
	$userid = valid_output($session_data['user_id']);
}

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
//echo $_POST['flage']."</br>";
//exit();
/*echo "<pre>";
print_r($_POST);
echo "</pre>";
echo $service_item_type."</br>";*/
//exit();



if(isset($_POST['flage']) && $_POST['flage']=="2")
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
$data = $ObjServicePageIndexMaster->getServicePageName($fieldArr,$seaArr);
if(!empty($data))
{
	foreach ($data as $servicePageDetail)
	{
		if($servicePageDetail['length_max']!="" && $servicePageDetail['length_max']!="")
		{
			$length_max = $servicePageDetail['length_max'];
		}
		if($servicePageDetail['girth_max']!="" && $servicePageDetail['girth_max']!="")
		{
			$girth_max = $servicePageDetail['girth_max'];
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
	
	//show_page_header(FILE_INDEX,false);
	header("Location:".SITE_INDEX);
	exit();
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
	/*
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
	} */
	$pickup_drc = valid_input($_POST["pickup_location_type"]);
		
	if($pickup_drc != '')
	{
		$err['pickup_drc'] = isNumeric($pickup_drc, COMMON_NUMERIC_VAL);
	}
	
	$delivery_drc = valid_input($_POST["delivery_location_type"]);
	
	
	if($delivery_drc != '')
	{
		$err['delivery_drc'] = isNumeric($delivery_drc, COMMON_NUMERIC_VAL);
	}
	if($pickup_drc == 1 && $delivery_drc ==1)
	{
		$drc = 1;
	}elseif($pickup_drc == "" && $delivery_drc ==1)
	{
		$drc = 1;
	}elseif($pickup_drc == 1 && $delivery_drc =="")
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

// && ($_POST['btn_submit']) == 'Next'
//echo "ptoken:".$ptoken;
UnsetSession();
if(isset($_POST['btn_submit']))
{
	
	if($userid=="")
	{
		//
		session_start();
		session_regenerate_id(true);
		$_SESSION['ses_flag'] = 1;
	}
	if(isEmpty(valid_input($_POST['ptoken']), true))
	{	
		logOut();
	}
	else
	{
		/*echo "ptoken:".$_POST['ptoken'];
		exit();*/
		$csrf->checkcsrf($_POST['ptoken']);
		$csrf->logout();
		UnsetSession();
	}
	
	//exit();
	
	$err = array();
	$pickup  = valid_input($_POST['pickup']);
	$deliver = valid_input($_POST['deliver']);
	$flag    = valid_input($_POST['flage']);
	$item_qty    = $_POST['aus_total_qty'];
	$item_qty = $_POST['Item_qty'];
	$item_weight = $_POST['Item_weight'];
	$item_length = $_POST['Item_length'];
	$item_width = $_POST['Item_width'];
	$item_height = $_POST['Item_height'];
	$int_country = $_POST['inter_country'];
	$int_qty_item = $_POST['qty_item'];
	$int_weight_item = $_POST['weight_item'];
	$int_length_item = $_POST['length_item'];
	$int_width_item = $_POST['width_item'];
	$int_height_item = $_POST['height_item'];
	//$int_item_type = $_POST['inter_ShippingType'];
	$int_item_type = $_POST['inter_ShippingType_1'][0];
	$chargeable_weight = $_POST['chargeable_weight'];
	$original_weight   = $_POST['original_weight_1'];
    $volumetric_weight = $_POST['volumetric_weight'];
	$int_volumetric_weight = $_POST['international_total_volumetric_weight'];
    $int_original_weight   = $_POST['international_total_weight'];
	$int_chargeable_weight = $_POST['international_chargeable_weight'];
	$pickupid = valid_input($_POST["pickup"]);
	$servicepage = valid_input($_POST["servicepagename"]);
	
	

	$errChk = false;
	if(isset($_POST['last_inserted_cell']) && $_POST['last_inserted_cell'] != "")
	{
		$err['last_inserted_cell'] = isNumeric($_POST['last_inserted_cell'], COMMON_NUMERIC_VAL);
	}
	
	if(isset($err['last_inserted_cell'])&& ($err['last_inserted_cell']!=''))
	{
		$errChk = true;
	}

	if(isset($_POST['aus_total_qty']) && $_POST['aus_total_qty'] != "")
	{
		$err['aus_total_qty'] = isNumeric($_POST['aus_total_qty'], COMMON_NUMERIC_VAL);
	}
	if(isset($err['aus_total_qty']) && $err['aus_total_qty'] != "")
	{
		$errChk = true;
	}
	if(isset($servicepage) && $servicepage != '')
	{
		$err['servicepage'] = chkSmall($servicepage);
	}
	if(isset($err['servicepage']) && $err['servicepage'] != "")
	{
		$errChk = true;
	}
	if(isset($flag) && $flag != '')
	{
		$err['flag'] = isNumeric($flag, COMMON_NUMERIC_VAL);
	}
	if(isset($err['flag']) && $err['flag']!= "")
	{
		$errChk = true;
	}
	
	if(isset($original_weight) && $original_weight!='')
	{
		$err['original_weight'] = isFloat($original_weight, 'Please enter float value.');
	}
	if(isset($err['original_weight']) && ($err['original_weight'] != ""))
	{
		$errChk = true;
	}
	if(isset($chargeable_weight) && $chargeable_weight!='')
	{
		$err['chargeable_weight'] = isFloat($chargeable_weight, COMMON_NUMERIC_VAL);
	}
	if(isset($err['chargeable_weight']) && ($err['chargeable_weight']!=""))
	{
		$errChk = true;
	}
	if($volumetric_weight!='')
	{
		$err['volumetric_weight'] = isFloat($volumetric_weight, 'Please enter float value.');
	}
	if(isset($err['volumetric_weight']) && $err['volumetric_weight']!="")
	{
		$errChk = true;
	}
	
	if(isset($int_original_weight) && $int_original_weight!='')
	{
		$err['int_original_weight'] = isFloat($int_original_weight, 'Please enter float value.');
	}
	if(isset($err['int_original_weight']) && $err['int_original_weight'] != '')
	{
		$errChk = true;
	}
	if(isset($int_volumetric_weight) && $int_volumetric_weight!='')
	{
		$err['int_volumetric_weight'] = isFloat($int_volumetric_weight, 'Please enter float value.');
	}
	if(isset($err['int_volumetric_weight']) && ($err['int_volumetric_weight']!=""))
	{
		$errChk = true;
	}
	
	if(isset($_POST['length_max']) && $_POST['length_max'] != "")
	{
		$err['lengthMaxError'] = isFloat($_POST['length_max'], 'Please enter float value.');
	}
	if(isset($err['lengthMaxError']) && $err['lengthMaxError']!= "")
	{
		$errChk = true;
	}
	if(isset($_POST['girth_max']) && $_POST['girth_max'] != "")
	{
		$err['girthMaxError'] = isFloat($_POST['girth_max'], 'Please enter float value.');
	}
	if(isset($err['girthMaxError']) && $err['girthMaxError']!= "")
	{
		$errChk = true;
	}
	
	if(isset($_POST['optionsCountry']) && $_POST['optionsCountry'] != "")
	{
		$err['optionsCountryError'] = chkSmallCapital($_POST['optionsCountry'], 'Please enter proper value.');
	}
	if(isset($err['optionsCountryError']) && $err['optionsCountryError'] != "")
	{
		$errChk = true;
	}
	
	if(isset($errChk) && $errChk == true){
	
		foreach ($err as $key => $Value) {
			if ($Value != '') {
				logOut();
			}
		}
	}
	/*
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
	}*/
	if(isset($chargeable_weight) && ($chargeable_weight != ""))
	{
		$kg = $chargeable_weight;
	}
	if(isset($int_chargeable_weight) && ($int_chargeable_weight != ""))
	{
		$int_kg = $int_chargeable_weight;
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
			$qty_name = "Item_qty";
			$org_weight_name = "Item_weight";
			$length_name = "Item_length";
			$width_name = "Item_width";
			$height_name = "Item_height";
			
			$BookingItemDetailsDataObj = new stdClass;
			$BookingItemDetailsDataObj->booking_id = valid_input($bookingid);
			$BookingItemDetailsDataObj->quantity = valid_input($_POST[$qty_name][$i]);
			$BookingItemDetailsDataObj->item_weight = valid_input($_POST[$org_weight_name][$i]);
			$BookingItemDetailsDataObj->length = valid_input($_POST[$length_name][$i]);
			$BookingItemDetailsDataObj->width = valid_input($_POST[$width_name][$i]);
			$BookingItemDetailsDataObj->height = valid_input($_POST[$height_name][$i]);
			/*echo "<pre>";
			print_r($_POST);
			echo "</pre>";*/
			//echo "qty:".$_POST['Item_qty']."</br>";

			$BookingItemDetailsDataObj->vol_weight=ceil(((valid_input($_POST[$width_name][$i])*valid_input($_POST[$length_name][$i])*valid_input($_POST[$height_name][$i]))/$volumetric_divisor)*valid_input($_POST[$qty_name][$i]));
			//list multiple items
			$BookingItemDetailsDataObjArray[$i] = (array)$BookingItemDetailsDataObj; 
			//echo "original weight:".$_POST[$org_weight_name][$i]."</br>";
		}
		//exit();
		
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
			$multi_err['qtyError'][$i]	  =	isEmpty($item_qty[$i], COMMON_QTY_IS_REQUIRED) ? isEmpty($item_qty[$i], COMMON_QTY_IS_REQUIRED) : isNumeric($item_qty[$i], COMMON_NUMERIC_VAL);  
			$multi_err['weightError'][$i] = isEmpty($item_weight[$i], COMMON_WEIGHT_IS_REQUIRED) ? isEmpty($item_weight[$i], COMMON_WEIGHT_IS_REQUIRED) : isFloat($item_weight[$i], 'Please enter float value.');
			$multi_err['lengthError'][$i] = isEmpty($item_length[$i], COMMON_LENGTH_IS_REQUIRED) ? isEmpty($item_length[$i], COMMON_LENGTH_IS_REQUIRED) : isNumeric($item_length[$i], COMMON_NUMERIC_VAL);
			$multi_err['widthError'][$i]  = isEmpty($item_width[$i], COMMON_WIDTH_IS_REQUIRED) ? isEmpty($item_width[$i], COMMON_WIDTH_IS_REQUIRED) : isNumeric($item_width[$i], COMMON_NUMERIC_VAL);
			$multi_err['heightError'][$i] = isEmpty($item_height[$i], COMMON_HEIGHT_IS_REQUIRED) ? isEmpty($item_height[$i], COMMON_HEIGHT_IS_REQUIRED) : isNumeric($item_height[$i], COMMON_NUMERIC_VAL);
			
			
			//if(valid_input($item_weight[$i]) != 0)
			//{
				
				$fieldArr = array("*");
				$seaPageArr = array();
				$seaPageArr[] = array('Search_On'=>'service_page_name', 'Search_Value'=>$servicepage, 'Type'=>'string', 'Equation'=>'=', 'CondType'=>'AND', 'Prefix'=>'', 'Postfix'=>'');	
				//$seaPageArr[] = array('Search_On'=>'item_type', 'Search_Value'=>$selShippingType[0], 'Type'=>'string', 'Equation'=>'=', 'CondType'=>'AND', 'Prefix'=>'', 'Postfix'=>'');
				$pageData = $ObjServicePageIndexMaster->getServicePageName($fieldArr, $seaPageArr);
				$pageData = $pageData[0];
				if(!empty($pageData))
				{
					
					if(isset($item_qty[$i]) && $item_qty[$i]<0){
						$multi_err['qtyError'][$i] = 'Quantity must be greater than 0';
					}
					if(isset($item_weight[$i]) && $item_weight[$i]<0){
						$multi_err['weightError'][$i] = 'Weight must be greater than 0';
					}
					if(isset($item_length[$i]) && $item_length[$i]<0){
						$multi_err['lengthError'][$i] = 'Length must be greater than 0';
					}elseif(isset($item_length[$i]) && isset($pageData['length_max']) && $item_length[$i] > $pageData['length_max']){
						$multi_err['lengthError'][$i] = 'Length must be less than '.$pageData['length_max'];
					}
					if(isset($item_width[$i]) && $item_width[$i]<0){
						$multi_err['widthError'][$i] = 'Width must be greater than 0';
					}
					if(isset($item_height[$i]) && $item_height[$i]<0){
						$multi_err['heightError'][$i] = 'Height must be greater than 0';
					}
					if(isset($item_length[$i]) && isset($item_width[$i]) && isset($item_height[$i])){
						$total_girth[$i] = $item_length[$i]+(2*$item_width[$i])+(2*$item_height[$i]);
						if(isset($total_girth[$i]) && isset($pageData['girth_max']) && $total_girth[$i]>$pageData['girth_max']){
							$multi_err['heightError'][$i] = 'Sorry we can\'t accept these dimensions';
						}
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
			$BookingItemDetailsDataObj->quantity = $int_qty_item[$i];
			$BookingItemDetailsDataObj->item_weight = $int_weight_item[$i];
			$BookingItemDetailsDataObj->length = $int_length_item[$i];
			$BookingItemDetailsDataObj->width = $int_width_item[$i];
			$BookingItemDetailsDataObj->height = $int_height_item[$i];
			echo $int_length_item[$i]."--".$int_width_item[$i]."--".$int_height_item[$i].$volumetric_divisor."</br>";
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
			$multi_err['intqtyError'][$j]	  =	isEmpty($int_qty_item[$j], COMMON_QTY_IS_REQUIRED) ? isEmpty($int_qty_item[$j], COMMON_QTY_IS_REQUIRED) : isNumeric($int_qty_item[$j], COMMON_NUMERIC_VAL); 
			$multi_err['intweightError'][$j] = isEmpty($int_weight_item[$j], COMMON_WEIGHT_IS_REQUIRED) ? isEmpty($int_weight_item[$j], COMMON_WEIGHT_IS_REQUIRED) : isFloat($int_weight_item[$j],"Please enter float value.");
			$multi_err['intlengthError'][$j] = isEmpty($int_length_item[$j], COMMON_LENGTH_IS_REQUIRED) ? isEmpty($int_length_item[$j], COMMON_LENGTH_IS_REQUIRED) : isNumeric($int_length_item[$j], COMMON_NUMERIC_VAL);
			$multi_err['intwidthError'][$j]  = isEmpty($int_width_item[$j], COMMON_WIDTH_IS_REQUIRED) ? isEmpty($int_width_item[$j], COMMON_WIDTH_IS_REQUIRED) : isNumeric(valid_input($_POST['width_item'][$j]), COMMON_NUMERIC_VAL);
			$multi_err['intheightError'][$j] = isEmpty($int_height_item[$j], COMMON_HEIGHT_IS_REQUIRED) ? isEmpty($int_height_item[$j], COMMON_HEIGHT_IS_REQUIRED) : isNumeric(valid_input($_POST['height_item'][$j]), COMMON_NUMERIC_VAL);
			
			$fieldArr = array("*");
			$seaPageArr = array();
			$seaPageArr[] = array('Search_On'=>'service_page_name', 'Search_Value'=>$servicepage, 'Type'=>'string', 'Equation'=>'=', 'CondType'=>'AND', 'Prefix'=>'', 'Postfix'=>'');	
			//$seaPageArr[] = array('Search_On'=>'item_type', 'Search_Value'=>$int_item_type, 'Type'=>'string', 'Equation'=>'=', 'CondType'=>'AND', 'Prefix'=>'', 'Postfix'=>'');
			$pageData = $ObjServicePageIndexMaster->getServicePageName($fieldArr, $seaPageArr);
			$pageData = $pageData[0];
			//$int_qty_item = 14;
			//$int_weight_item = 30;
			if(!empty($pageData))
			{
				
				
				if(isset($int_qty_item[$j]) && $int_qty_item[$j]<0){
					$multi_err['intqtyError'][$j] = 'Quantity must be greater than 0';
				}
				if(isset($int_weight_item[$j]) && $int_weight_item[$j]<0){
					$multi_err['intweightError'][$i] = 'Weight must be greater than 0';
				}
				if(isset($int_length_item[$j]) && $int_length_item[$j]<0){
					$multi_err['intlengthError'][$i] = 'Length must be greater than 0';
				}elseif(isset($int_length_item[$j]) && isset($pageData['length_max']) && $int_length_item[$j] > $pageData['length_max']){
					$multi_err['intlengthError'][$j] = 'Length must be less than '.$pageData['length_max'];
				}
				if(isset($int_width_item[$j]) && $int_width_item[$j]<0){
					$multi_err['intwidthError'][$j] = 'Width must be greater than 0';
				}
				if(isset($int_height_item[$j]) && $int_height_item[$j]<0){
					$multi_err['intheightError'][$j] = 'Height must be greater than 0';
				}
				if(isset($int_length_item[$j]) && isset($int_width_item[$j]) && isset($int_height_item[$j])){
					$total_girth[$j] = $int_length_item[$j]+(2*$int_width_item[$j])+(2*$int_height_item[$j]);
					if(isset($total_girth[$j]) && isset($pageData['girth_max']) && $total_girth[$j]>$pageData['girth_max']){
						$multi_err['intheightError'][$j] = 'Sorry we can\'t accept these dimensions';
					}
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
	/*echo "<pre>";
	print_r($multi_err);
	echo "</pre>";
	exit();*/
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
	/*
	echo "<pre>";
	print_R($err);
	echo "</pre>";
	echo "<pre>";
	print_R($multi_err);
	echo "</pre>";
	exit();
	*/
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
	
	
	if(!empty($metrozones))
	{
		foreach($metrozones as $metrozone)
		{		
			
			if(strpos($metrozone,$o_st_city_zone)!== false)
			{
				$o_metro_valid_state_arr = explode("-",$metrozone);
				$o_metro_valid_state = $o_metro_valid_state_arr[0];
			}
			if(strpos($metrozone,$d_st_city_zone)!== false)
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
	if(empty($o_metro_valid_state) && empty($d_metro_valid_state))
	{
		$o_metro_valid_state = $o_st_city_zone;	
		$d_metro_valid_state = $d_st_city_zone;
	}
	

	/* Below condition is for testing its from same zone of metro or not */
	if($Svalidation == false && $o_metro_valid_state == $d_metro_valid_state && $flag == 1 )
	{		
		$code_format_id = 10; // direct courier
		$cond_metro = true;
		$service_local = 1;
		if($pickupid!='' && $deliverid !='')
		{
			$dis = distanceKm($pickupid,$deliverid);
		}
		//echo $dis;
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
						

						// Messenger Post if($tbl!='' && $supplier_id == 3 && $cond_metro == true)
						if($tbl!='' && $supplier_id == 10 && $cond_metro == true)// Condition for direct courier
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
						
						// Messenger Post if($tbl!='' && $supplier_id == 3 && $cond_metro == true)
						if($tbl!='' && $supplier_id == 10 && $cond_metro == true)// Condition for direct Courier
						{	
							$service_data[$k]['service_rate'] = cal_val_direct($base_tariff,$kg,$tbl,$dis);
						}
					}
					
					/* condition for inbound */
					//echo $d_metro_valid_state;
					/* condition for both */
					if($service_data[$k]['service_rate'] == 0)
					{
						//$base_tariff = strtolower($o_metro_valid_state.$service);
						$base_tariff = strtolower($o_metro_valid_state.'st');
						//echo "b:".$base_tariff."</br>";
						$base_tariff = bothDir($base_tariff);
						//echo "a:".$base_tariff."</br>";
						$tbl = checkTableExit($base_tariff);
						//echo "tbl:".$tbl;
						$dest = $deliver;
						if($tbl === 0)
						{	
							//echo "d:".$d_metro_valid_state;
							$base_tariff = strtolower($d_metro_valid_state.'st');
							//echo $base_tariff ;
							$base_tariff = bothDir($base_tariff);
							$tbl = checkTableExit($base_tariff);
							$dest = $pickup;
						}
						//echo "service:".$service."third if condition:".$base_tariff."table:".$tbl."</br>";
						//Messenger Post condition if($tbl!='' && $supplier_id == 3 && $cond_metro == true)
						if($tbl!='' && $supplier_id == 10 && $cond_metro == true)// Direct Courier
						{	
							$service_data[$k]['service_rate'] = cal_val_direct($base_tariff,$kg,$tbl,$dis);
							if(isset($service) && $service == 'ex'){
								$service_data[$k]['service_rate'] = 2*cal_val_direct($base_tariff,$kg,$tbl,$dis);
							}elseif (isset($service) && $service == 'pr') {
								# code...
								$service_data[$k]['service_rate'] = 3*cal_val_direct($base_tariff,$kg,$tbl,$dis);
							}
							//echo $tbl."</br>";
							//echo $service_data[$k]['service_rate']."</br>";
						}
					}
					//exit();
					/* condition for both */
					
					/* condition for zzz */
					if($service_data[$k]['service_rate'] == 0)
					{
						$base_tariff = strtolower('zzz'.$service);
						$base_tariff = bothDir($base_tariff);
						
						$tbl = checkTableExit($base_tariff);
						
						// Messenger Post if($tbl!='' && $supplier_id == 3 && $cond_metro == true)
						if($tbl!='' && $supplier_id == 10 && $cond_metro == true) /* Direct Courier */
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
						$service_data[$k]['hours'] = $service_val['hours'];
						$service_data[$k]['minites'] = $service_val['minites'];
						$service_data[$k]['hr_formate'] = $service_val['hr_formate'];
						$service_data[$k]['supplier_id'] = $service_val['supplier_id'];
						$service_data[$k]['box_color'] = $service_val['box_color'];
						$service_data[$k]['sorting'] = $service_val['sorting'];
						$service_data[$k]['service_status_info'] = $service_val['service_status_info'];
						$service_data[$k]['service_info'] = $service_val['service_info'];
						$total_gst = calculate_gst_charge($gst,calculate_charge($suppier_fuel_charge[$service_val['supplier_id']],$service_data[$k]['service_rate'],$$surcharge));
						$service_data[$k]['total_gst'] = $total_gst;
						$service_data[$k]['total_delivery_fee'] = calculate_charge($suppier_fuel_charge[$service_val['supplier_id']],$service_data[$k]['service_rate'],$surcharge);
						$service_data[$k]['service_rate'] =calculate_charge_with_gst(calculate_charge($suppier_fuel_charge[$service_val['supplier_id']],$service_data[$k]['service_rate'],$surcharge),$total_gst);
						$msg_fee_flag = 1;
					}
					
					$k++;
				}
				/*echo "<pre>";
					print_r($service_data);
					echo "</pre>";
					exit();
				*/
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
			
			$code_format_id = 0;
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
				
				if(!empty($service_val))
				{
				
					$service = strtolower($service_val['service_code']);
					//echo $service."</br>";
					$base_tariff = $city.$service;
					$base_tariff_destination = $d_st_city_zone.$service;
					$service_data[$l]['service_name'] = $service_val['service_name'];
					$service_data[$l]['service_code'] = $service_val['service_code'];
					$service_data[$l]['supplier_name'] = $service_val['supplier_name'];
					$supplier_id = $service_val['supplier_id'];	
					
					if($drc==1){
						$surcharge=number_format($service_val->surcharge,2,'.','');
						$service_data[$l]['surcharge']=number_format($service_val->surcharge,2,'.','');
					}else{
						$surcharge=0;
						$service_data[$l]['surcharge']=0;
					}
					
					$supplier_id = $service_val['supplier_id'];	
					$totalweight = $kg;
					$service_rate = 0;
					
					/* condition for both */
					if($service_data[$l]['service_rate'] == 0)
					{
						$base_tariff = strtolower('aus'.$service);
						
						
						$base_tariff = bothDir($base_tariff);
						$tbl = checkTableExit($base_tariff);
						//echo "table name:".$tbl."</br>";
						//echo 'table:'.$tbl."-basetariff-".$base_tariff.'--kg-'.$kg.'-ocityname-'.$o_st_city_zone.'dstname'.$d_st_city_zone."</br>";
						if($tbl!='' && $supplier_id == 0)
						{	
							$service_data[$l]['service_rate'] = cal_val($base_tariff,$kg,$tbl,$o_st_city_zone,$d_st_city_zone);
						}
						//echo $base_tariff."--".$service_data[$l]['service_rate']."<br>";
					}
					
					/* condition for both */
					
					
					/* condition for zzz */
					if($service_data[$l]['service_rate'] == 0)
					{
						$base_tariff = strtolower('zzz'.$service);
						$base_tariff = bothDir($base_tariff);
						
						$tbl = checkTableExit($base_tariff);
						//echo $base_tariff."--".$tbl."</br>";
						if($tbl!='' && $supplier_id == 0)
						{	
							$service_data[$l]['service_rate'] = cal_val($base_tariff,$kg,$tbl,$o_st_city_zone,$d_st_city_zone);
						}
						//echo $service_data[$l]['service_rate']."<br>";
					}
					
					//echo $base_tariff."</br>";
					
					/* condition for zzz */
					//echo $service_data[$l]['service_rate']."<br>";
					if($service_data[$l]['service_rate'] != 0)
					{
						$gst = GST;
						
						//echo $service_data[$l]['service_rate']."</br>";
						
						$service_data[$l]['delivery_fee'] = number_format($service_data[$l]['service_rate'],2,'.','');
						$service_data[$l]['fuel_surcharge'] = calculate_fuel_charge($suppier_fuel_charge[$service_val['supplier_id']],$service_data[$l]['service_rate']);
						$service_data[$l]['base_fuel_fee'] = $suppier_fuel_charge[$service_val['supplier_id']];	
						$total_gst = calculate_gst_charge($gst,calculate_charge($suppier_fuel_charge[$service_val['supplier_id']],$service_data[$l]['service_rate'],$surcharge));
						$service_data[$l]['total_gst'] = $total_gst;
						$service_data[$l]['hours'] = $service_val['hours'];
						$service_data[$l]['minites'] = $service_val['minites'];
						$service_data[$l]['hr_formate'] = $service_val['hr_formate'];
						$service_data[$l]['supplier_id'] = $service_val['supplier_id'];
						$service_data[$l]['box_color'] = $service_val['box_color'];
						$service_data[$l]['sorting'] = $service_val['sorting'];
						$service_data[$l]['service_status_info'] = $service_val['service_status_info'];
						$service_data[$l]['service_info'] = $service_val['service_info'];
						$service_data[$l]['total_delivery_fee'] = calculate_charge($suppier_fuel_charge[$service_val['supplier_id']],$service_data[$l]['service_rate'],$surcharge);
						$service_data[$l]['service_rate'] =calculate_charge_with_gst(calculate_charge($suppier_fuel_charge[$service_val['supplier_id']],$service_data[$l]['service_rate'],$surcharge),$total_gst);
						
						$star_fee_flag = 1;
						//continue;
						//echo $service_data[$l]['service_rate']."</br>";
					}
					
					$l++;
				}
			}

			
			//$code_format_id = 2;
			
		}
		/*echo "<pre>";
			print_r($service_data);
			echo "</pre>";
			exit();*/
		//exit();
		
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
		/*echo "tnt:".$tntno;
		exit();*/
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
						$service_data[$t]['hours'] = $tnt_service_val['hours'];
						$service_data[$t]['minites'] = $tnt_service_val['minites'];
						$service_data[$t]['hr_formate'] = $tnt_service_val['hr_formate'];
						$service_data[$t]['supplier_id'] = $tnt_service_val['supplier_id'];
						$service_data[$t]['box_color'] = $tnt_service_val['box_color'];
						$service_data[$t]['sorting'] = $tnt_service_val['sorting'];
						$service_data[$t]['service_status_info'] = $tnt_service_val['service_status_info'];
						$service_data[$t]['service_info'] = $tnt_service_val['service_info'];
						$service_data[$t]['total_delivery_fee'] = calculate_charge($suppier_fuel_charge[$tnt_service_val['supplier_id']],$service_data[$t]['service_rate'],$surcharge);
						$service_data[$t]['service_rate'] =calculate_charge_with_gst(calculate_charge($suppier_fuel_charge[$tnt_service_val['supplier_id']],$service_data[$t]['service_rate'],$surcharge),$total_gst);
						
						$star_fee_flag = 1;
						
					}
					$t++;
					
				
				}
			}

		}
		
		/* TNT format is calculated here */
		
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
					$fieldArr = array("zone","countries_name");
					
					$seaArr = array('Search_On'=>'countries_id','Search_Value'=>$int_country, 'Type'=>'int', 'Equation'=>'=', 'CondType'=>'AND', 'Prefix'=>'', 'Postfix'=>'');
					
					$CountryData = $CountryMasterObj->getCountry($fieldArr,$seaArr);
					//$CountryData = $CountryData[0];
					foreach($CountryData as $CountryDataval){
						$deliverinterzone=$CountryDataval['zone'];/* Selected the zone on the basis of delivery id for international zones*/
						$_SESSION['international_country_name']=$CountryDataval['countries_name'];
					}
					//echo "zone selected:".$deliverinterzone;
					//exit();
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
						$service_data[$m]['hours'] = $service_val['hours'];
						$service_data[$m]['minites'] = $service_val['minites'];
						$service_data[$m]['hr_formate'] = $service_val['hr_formate'];
						$service_data[$m]['supplier_id'] = $service_val['supplier_id'];
						$service_data[$m]['box_color'] = $service_val['box_color'];
						$service_data[$m]['sorting'] = $service_val['sorting'];
						$service_data[$m]['service_status_info'] = $service_val['service_status_info'];
						$service_data[$m]['service_info'] = $service_val['service_info'];
						$service_data[$m]['total_delivery_fee'] = calculate_charge($suppier_fuel_charge[$service_val['supplier_id']],$service_data[$m]['service_rate'],$surcharge);
						$service_data[$m]['service_rate'] =$service_data[$m]['total_delivery_fee']; 
					} 
					/*
					echo "<pre>";
					print_R($service_data);
					echo "</pre>";
					exit(); */
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