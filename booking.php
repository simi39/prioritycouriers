<?php
session_start();

require_once("lib/common.php");
require_once(DIR_WS_CURRENT_LANGUAGE . "booking.php");/* Language declaration of get_quote file(where all name constants where delcared) */
require_once(DIR_WS_MODEL ."CountryMaster.php");/* Zones are selected form this table(For International selection) .*/
require_once(DIR_WS_MODEL . "SupplierMaster.php");
require_once(DIR_WS_MODEL . "ServicePageMaster.php");
//require_once(DIR_WS_MODEL . "ServicePageMaster_1.php");

$CountryMasterObj = new CountryMaster();
$CountryMasterObj = $CountryMasterObj->Create();


$ObjSupplierMaster = SupplierMaster::Create();

$ObjServicePageIndexMaster	= ServicePageMaster::Create();
//$ObjServicePageIndexMaster_1	= ServicePageMaster_1::Create();

$arr_css_plugin_include[] = 'flexslider/flexslider.css"  media="screen';
$arr_css_plugin_include[] = 'waitMe/css/waitMe.min.css';


$arr_javascript_include[] = 'internal/ajex.js';
$arr_javascript_include[] = 'internal/ajax-dynamic-list.js';
$arr_javascript_include[] = 'internal/pickup.php';
$arr_javascript_plugin_include[] = 'flexslider/jquery.flexslider-min.js';
$arr_javascript_below_include[]  = 'internal/booking.php';
$arr_javascript_plugin_include[] = 'waitMe/js/waitMe.min.js';



//echo isset($_POST);
/*
$i = 123;
$no = str_pad($i, 7, '6700000', STR_PAD_LEFT);
echo $no;*/

/*
echo "<pre>";
print_r($_SESSION);
echo "</pre>";
*/
$selShippingType = $_POST['selShippingType'];

$errChk = false;
if(isset($_GET['Add']) && $_GET['Add']!='')
{
	$err['addmsg'] = chkStr(valid_input($_GET['Add']));
}
if(isset($err['addmsg']) && $err['addmsg'] != "")
{
	$errChk = true;
}
if(isset($_GET['action']) && $_GET['action']!='')
{
	$err['action'] = chkStr(valid_input($_GET['action']));
}
if(isset($err['action']) && $err['action'] != "")
{
	$errChk = true;

}
if(isset($_GET['bookingid']) && $_GET['bookingid']!='')
{
	$err['bookingid'] = isNumeric(valid_input($_GET['bookingid']),ERROR_ENTER_NUMERIC_VALUE);
}
if(isset($err['bookingid']) && $err['bookingid'] != "")
{
	$errChk = true;

}
$flag    = valid_input($_POST['flage']);
if(isset($flag) && $flag != '')
{
	$err['flag'] = isNumeric($flag, COMMON_NUMERIC_VAL);
}
if(isset($flag) && $err['flag']!= "")
{
	$errChk = true;
}

/* If session exists */
$BookingDetailsDataObj = $__Session->GetValue("booking_details");
if (!empty($BookingDetailsDataObj)) {
    $bookingvalue = new stdClass;
    foreach ($BookingDetailsDataObj as $akey => $aval) {
        $bookingvalue->{$akey} = $aval;
        $servicepage = $bookingvalue->servicepagename;
    }
}
/*
if($servicepage != '')
{
	$err['servicepage'] = chkSmall($servicepage);
}
if(!empty($err['servicepage']))
{
	$errChk = true;
}*/
if(isset($bookingvalue->pickupid) && $bookingvalue->pickupid!="")
{
	$pickup  = $bookingvalue->pickupid;
}else{
	$pickup  = valid_input($_POST['pickup']);
}

/* If users is coming from checkout page
  for editing the booking page
 */
$yesbtn = $_POST["databtn"];
/*
if(chkRestFields($yesbtn))
{
	$err['yesbtn'] = chkRestFields($yesbtn);
}
if(!empty($err['yesbtn']))
{
	$errChk = true;
	//logOut();
}
*/
if (isset($yesbtn) && $yesbtn == "true") {

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
	unset($_SESSION['dangerousgoods']);
	unset($_SESSION['securitystatement']);
	unset($_SESSION['terms']);
    $__Session->ClearValue("booking_details");
    $__Session->ClearValue("service_details");
    $__Session->ClearValue("booking_details_items");
    $__Session->ClearValue("booking_id");
    $__Session->ClearValue("client_address_dilivery");
    $__Session->ClearValue("client_address_pickup");
    $__Session->Store();

}
/*
echo "<pre>";
print_r($_SESSION);
echo "</pre>";
*/
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
/*
if(!empty($userid))
{
	$err['userid'] = isNumeric($userid,ERROR_ENTER_NUMERIC_VALUE);
}
if($err['userid'] != '')
{
	$errChk = true;
}
*/
/*volumetric calculation from admin */
$volumetric_divisor    = services_volumetric_charges;
$volumetric_divisor    = ($volumetric_divisor == '') ? ('4000') : ($volumetric_divisor);

$csrf = new csrf();


if(!isset($_POST['btn_submit']) && empty($_POST['btn_submit']))
{
	/*csrf validation*/
	$csrf->action = "booking";
	$ptoken = $csrf->csrfkey();
	/*csrf validation*/
}

if(!isset($_GET['Action']))
{
	/* Booking Summary session was getting destroyed that's why commented below line*/
	//UnsetSession();
}

if(isset($errChk) && $errChk == true){

	foreach ($err as $key => $Value) {
		if ($Value != '') {
			/*echo "<pre>";
					print_r($hidden_err);
					echo "</pre>";
					exit();*/ 
			logOut();
		}
	}
}
if(isset($_POST['btn_submit'])){
	/* Below code is to remove session for services
	**  so that selected dates and services won't show in next pages
	*/
	if(!isset($_GET['Action']))
	{
		/*global $__Session;
		$__Session->ClearValue("booking_details");
		$__Session->ClearValue("booking_details_items");
		$__Session->Store();
		*/
		UnsetSession();
	}
	/* Below code is to remove session for services
	**  so that selected dates and services won't show in next pages
	*/
	/*if(isEmpty(valid_input($_POST['ptoken']), true)){
		logOut();
	}else{*/
		
	$verifiedCsrf = $csrf->checkcsrf($_POST['ptoken']);
	//}
	/**/
	$err = array();
	$pickup  = valid_input($_POST['pickup']);
	$deliver = valid_input($_POST['deliver']);
	$flag    = valid_input($_POST['flage']);
	$no_rows = $_POST['no_rows'];

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
	$int_item_type = $_POST['inter_ShippingType_1'][0];
	$original_weight   = $_POST['original_weight_1'];
	$chargeable_weight = $_POST['chargeable_weight'];
    $volumetric_weight = $_POST['volumetric_weight'];
	$total_volume = $_POST['total_volume'];
	$int_volumetric_weight = $_POST['international_total_volumetric_weight'];
	$int_total_volume = $_POST['international_total_volume'];
	$int_chargeable_weight = $_POST['international_chargeable_weight'];
    $int_original_weight   = $_POST['international_total_weight'];
	$int_total_qty = $_POST['international_total_qty'];
	$int_no_rows = $_POST['international_no_rows'];
	$pickupid = valid_input($_POST["pickup"]);

	/*if(get_time_zonewise($pickupid)){
		$regionDate = date('d-m-Y', strtotime(get_time_zonewise($pickupid)));
		//$start_date = date('d-m-Y 7:0:0 a', strtotime(get_time_zonewise($pickupid)));
		$start_date = date('d-m-Y H:i:s', strtotime(get_time_zonewise($pickupid)));
	}
	*/
	$servicepage = valid_input($_POST["servicepagename"]);
	$err['PICKUPNOTEXISTS'] = chkStr($pickupid);

	if(isset($servicepage) && $servicepage != ''){
		$err['servicepage'] = chkSmall($servicepage);
	}
	//echo $servicepage;
	if(isset($int_total_qty) && $int_total_qty != ''){
		$err['int_total_qty'] = isNumeric($int_total_qty, COMMON_NUMERIC_VAL);
	}

	if(isset($_POST['optionsCountry']) && $_POST['optionsCountry'] != ""){
		$err['optionsCountryError'] = chkSmallCapital($_POST['optionsCountry'], 'Please enter proper value.');
	}

	if(isset($_POST['aus_total_qty']) && ($_POST['aus_total_qty'] != "")){
		$err['aus_total_qty'] = isFloat($_POST['aus_total_qty'], COMMON_NUMERIC_VAL);
	}

	if(isset($_POST['last_inserted_cell_australia']) && ($_POST['last_inserted_cell_australia'] != "")){
		$err['last_inserted_cell_australia'] = isNumeric($_POST['last_inserted_cell_australia'], COMMON_NUMERIC_VAL);
	}

	if(isset($int_no_rows) && $int_no_rows != ''){
		$err['int_no_rows'] = isNumeric($int_no_rows, COMMON_NUMERIC_VAL);
	}

	if(isset($flag) && $flag != ''){
		$err['flag'] = isNumeric($flag, COMMON_NUMERIC_VAL);
	}
	if(isset($no_rows) && $no_rows != ''){
		$err['no_rows'] = isNumeric($no_rows, COMMON_NUMERIC_VAL);
	}

	if(isset($flag) && $flag == 1){

		$pickup_drc = valid_input($_POST["pickup_location_type"]);

		if(isset($pickup_drc) && $pickup_drc != ''){
			$err['pickup_drc'] = isNumeric($pickup_drc, COMMON_NUMERIC_VAL);
		}

		$delivery_drc = valid_input($_POST["delivery_location_type"]);

		if(isset($delivery_drc) && $delivery_drc != ''){
			$err['delivery_drc'] = isNumeric($delivery_drc, COMMON_NUMERIC_VAL);
		}

		if(isset($pickup_drc) && isset($delivery_drc) && $pickup_drc == 1 && $delivery_drc == 1){
			$drc = 1;
		}elseif(isset($pickup_drc) && $pickup_drc == "" && isset($delivery_drc) && $delivery_drc == 1){
			$drc = 1;
		}elseif($pickup_drc == 1 && $delivery_drc ==""){
			$drc = 1;
		}else{
			$drc = 0;
		}
	}
	if(isset($original_weight) && $original_weight != ''){
		$err['original_weight'] = isFloat($original_weight, COMMON_NUMERIC_VAL);
	}

	if(isset($volumetric_weight) && $volumetric_weight != ''){
		$err['volumetric_weight'] = isFloat($volumetric_weight, COMMON_NUMERIC_VAL);
	}

	if(isset($chargeable_weight) && $chargeable_weight != ''){
		$err['chargeable_weight'] = isFloat($chargeable_weight, COMMON_NUMERIC_VAL);
	}
	if(isset($total_volume) && $total_volume != ''){
		$err['total_volume'] = isFloat($total_volume, COMMON_NUMERIC_VAL);
	}

	if(isset($int_original_weight) && $int_original_weight != ''){
		$err['int_original_weight'] = isFloat($int_original_weight, COMMON_NUMERIC_VAL);
	}

	if(isset($int_chargeable_weight) && $int_chargeable_weight != ''){
		$err['int_chargeable_weight'] = isFloat($int_chargeable_weight, COMMON_NUMERIC_VAL);
	}

	if(isset($int_volumetric_weight) && $int_volumetric_weight != ''){
		$err['int_volumetric_weight'] = isFloat($int_volumetric_weight, COMMON_NUMERIC_VAL);
	}

	if(isset($int_total_volume) && $int_total_volume != ''){
		$err['int_total_volume'] = isFloat($int_total_volume, COMMON_NUMERIC_VAL);
	}

	if(isset($chargeable_weight) && ($chargeable_weight != '')){
		$kg = $chargeable_weight;
	}
	//echo "chargeable weight:".$chargeable_weight."</br>";
	//exit();
	if(isset($int_chargeable_weight) && ($int_chargeable_weight != '')){
		$int_kg = $int_chargeable_weight;
	}

	$err['PICKUPNOTEXISTS'] = isEmpty(valid_input($pickup), SELECT_PICKUP_ITEM);
    if(isset($pickup) && $pickup == 'PICK UP SUBURB/POSTCODE') {
        $err['PICKUPNOTEXISTS'] = SELECT_PICKUP_ITEM;
    }

	if($pickup == '') {
        $err['PICKUPNOTEXISTS'] = SELECT_PICKUP_ITEM;
    }

	if(!empty($pickup) && $pickup != 'PICK UP SUBURB/POSTCODE'){
        $err['PICKUPNOTEXISTS'] = chkStr(valid_input($pickup));
    }

	if(isset($flag) && $flag == 1){

		$err['DELIVERNOTEXISTS'] = isEmpty(valid_input($deliver), SELECT_DELIVER_ITEM);
        if ($deliver == 'DELIVERY SUBURB/POSTCODE'){
            $err['DELIVERNOTEXISTS'] = SELECT_DELIVER_ITEM;
        }

		if ($deliver == ''){
            $err['DELIVERNOTEXISTS'] = SELECT_DELIVER_ITEM;
        }

        if(!empty($deliver) && $deliver != 'DELIVERY SUBURB/POSTCODE'){
            $err['DELIVERNOTEXISTS'] = chkStr(valid_input($deliver));
        }
		$countitem = count($selShippingType);

		$BookingItemDetailsDataObjArray = array();
		for($i=0;$i<($countitem-1);$i++)
		{
			$shipping_name = "selShippingType";
			$shipping_name_t = $_POST["selShippingType"][$i];
			$qty_name = "Item_qty";
			$org_weight_name = "Item_weight";
			$length_name = "Item_length";
			$width_name = "Item_width";
			$height_name = "Item_height";


			$BookingItemDetailsDataObj = new stdClass;
			$BookingItemDetailsDataObj->booking_id = valid_input($bookingid);
			$BookingItemDetailsDataObj->item_type = valid_input($_POST[$shipping_name][$i]);
			$BookingItemDetailsDataObj->quantity = valid_input($_POST[$qty_name][$i]);
			$BookingItemDetailsDataObj->item_weight = valid_input($_POST[$org_weight_name][$i]);
			$BookingItemDetailsDataObj->length = valid_input($_POST[$length_name][$i]);
			$BookingItemDetailsDataObj->width = valid_input($_POST[$width_name][$i]);
			$BookingItemDetailsDataObj->height = valid_input($_POST[$height_name][$i]);
			$BookingItemDetailsDataObj->vol_weight=ceil(((valid_input($_POST[$width_name][$i])*valid_input($_POST[$length_name][$i])*valid_input($_POST[$height_name][$i]))/$volumetric_divisor)*valid_input($_POST[$qty_name][$i]));
			//list multiple items
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

		for($i=0;$i<count($selShippingType)-1;$i++)
		{
			if(valid_input($selShippingType[$i]) == 0){
				$multi_err['shippingError'][$i] = SELECT_ANY_ITEM;
			}

			if($multi_err['shippingError'][$i] == ''){
				$multi_err['shippingError'][$i] = isNumeric($selShippingType[$i], COMMON_NUMERIC_VAL);
			}

			$multi_err['qtyError'][$i]	  =	isEmpty($item_qty[$i], COMMON_QTY_IS_REQUIRED) ? isEmpty($item_qty[$i], COMMON_QTY_IS_REQUIRED) : isNumeric($item_qty[$i], COMMON_NUMERIC_VAL);
			$multi_err['weightError'][$i] = isEmpty($item_weight[$i], COMMON_WEIGHT_IS_REQUIRED) ? isEmpty($item_weight[$i], COMMON_WEIGHT_IS_REQUIRED) : isFloat($item_weight[$i], 'Please enter float value.');
			$multi_err['lengthError'][$i] = isEmpty($item_length[$i], COMMON_LENGTH_IS_REQUIRED) ? isEmpty($item_length[$i], COMMON_LENGTH_IS_REQUIRED) : isNumeric($item_length[$i], COMMON_NUMERIC_VAL);
			$multi_err['widthError'][$i]  = isEmpty($item_width[$i], COMMON_WIDTH_IS_REQUIRED) ? isEmpty($item_width[$i], COMMON_WIDTH_IS_REQUIRED) : isNumeric($item_width[$i], COMMON_NUMERIC_VAL);
			$multi_err['heightError'][$i] = isEmpty($item_height[$i], COMMON_HEIGHT_IS_REQUIRED) ? isEmpty($item_height[$i], COMMON_HEIGHT_IS_REQUIRED) : isNumeric($item_height[$i], COMMON_NUMERIC_VAL);
			//echo "2:".$servicepage;
			if(valid_input($selShippingType[$i]) != 0){
				$fieldArr = array("*");
				$seaPageArr = array();
				$seaPageArr[] = array('Search_On'=>'service_page_name', 'Search_Value'=>$servicepage, 'Type'=>'string', 'Equation'=>'=', 'CondType'=>'AND', 'Prefix'=>'', 'Postfix'=>'');
				$pageData = $ObjServicePageIndexMaster->getServicePageName($fieldArr, $seaPageArr);
				$pageData = $pageData[0];
				/*echo "servicepage:".$servicepage."</br>";
				echo "<pre>";
				print_R($pageData);
				echo "</pre>";
				exit();
				*/
				/*echo "<pre>";
				print_R($_POST);
				echo "</pre>";
				*/
				/*
				echo "item quantity:".$item_qty."</br>";
				print_R($item_qty);*/
				if(!empty($pageData)){

					if(isset($item_qty[$i]) && $item_qty[$i]<0){
						$multi_err['qtyError'][$i] = 'Quantity must be greater than 0';
					}
					if(isset($item_weight[$i]) && $item_weight[$i]<0){
						$multi_err['weightError'][$i] = 'Weight must be greater than 0';
					}
					if(isset($item_length[$i]) && $item_length[$i]<0){
						$multi_err['lengthError'][$i] = 'Length must be greater than 0';

					}elseif(isset($item_length[$i]) && isset($pageData['length_max']) && $item_length[$i] > $pageData['length_max'] && valid_input($selShippingType[$i]) != '43'){// selshippingTyoe is 43 it's for pallet.we are not applying girth for pallets
						$multi_err['lengthError'][$i] = 'Length must be less than '.$pageData['length_max'];
					}
					if(isset($item_width[$i]) && $item_width[$i]<0){
						$multi_err['widthError'][$i] = 'Width must be greater than 0';
					}
					if(isset($item_height[$i]) && $item_height[$i]<0){
						$multi_err['heightError'][$i] = 'Height must be greater than 0';
					}
					if(isset($item_length[$i]) && isset($item_width[$i]) && isset($item_height[$i])){
						$total_girth[$i] = $item_length[$i]+(2*$item_width[$i])+(2*$item_height[$i]);// selshippingTyoe is 43 it's for pallet.we are not applying girth for pallets
						if(isset($total_girth[$i]) && isset($pageData['girth_max']) && $total_girth[$i]>$pageData['girth_max'] && valid_input($selShippingType[$i]) != '43'){
							$multi_err['heightError'][$i] = 'Sorry we can\'t accept these dimensions'.'cal girth:'.$total_girth[$i].'--'.'max girth:'.$pageData['girth_max'];
						}
					}
					
				}
			}
			/*echo "<pre>";
			print_r($multi_err);
			echo "</pre>";
			exit();*/
		}
		
	}

	if(isset($flag) && $flag == 2)	{

		if($int_country == 'SELECT COUNTRY'){
		  $err['interError'] = SELECT_INTERNATIONAL_COUNTRY;
		}

		if($int_country != 'SELECT COUNTRY' && $int_country !=''){
			$err['interError'] = isNumeric($int_country, COMMON_NUMERIC_VAL);
		}

		$inter_volumetric_divisor    = international_services_volumetric_charges;
		$inter_volumetric_divisor    = ($inter_volumetric_divisor == '') ? ('5000') : ($inter_volumetric_divisor);
		$inter_rows = count($int_qty_item);
		$BookingItemDetailsDataObjArray =array();
		for ($i=0;$i<$inter_rows-1;$i++)
		{
			$BookingItemDetailsDataObj = new stdClass;
			$BookingItemDetailsDataObj->item_type = $int_shipping_type[0];
			$BookingItemDetailsDataObj->quantity = $int_qty_item[$i];
			$BookingItemDetailsDataObj->item_weight = $int_weight_item[$i];
			$BookingItemDetailsDataObj->length = $int_length_item[$i];
			$BookingItemDetailsDataObj->width = $int_width_item[$i];
			$BookingItemDetailsDataObj->height = $int_height_item[$i];
			//echo $int_length_item[$i]."--".$int_width_item[$i]."--".$int_height_item[$i]."--".$inter_volumetric_divisor."--".$int_qty_item[$i]."</br>";
			$BookingItemDetailsDataObj->vol_weight = ceil((($int_length_item[$i]*$int_width_item[$i]*$int_height_item[$i])/$inter_volumetric_divisor)*$int_qty_item[$i]);
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
		for($j=0;$j<count($int_weight_item)-1;$j++)
		{
			if (valid_input($int_item_type[0]) == 0) {
				$multi_err['intItemError'][0] = SELECT_ANY_ITEM;
			}
			if($multi_err['intItemError'][0] == ''){
				$multi_err['intItemError'][0] = isNumeric($multi_err['intItemError'][0], COMMON_NUMERIC_VAL);
			}
			$multi_err['intqtyError'][$j]	  =	isEmpty($int_qty_item[$j], COMMON_QTY_IS_REQUIRED) ? isEmpty($int_qty_item[$j], COMMON_QTY_IS_REQUIRED) : isNumeric($int_qty_item[$j], COMMON_NUMERIC_VAL);
			$multi_err['intweightError'][$j] = isEmpty($int_weight_item[$j], COMMON_WEIGHT_IS_REQUIRED) ? isEmpty($int_weight_item[$j], COMMON_WEIGHT_IS_REQUIRED) : isFloat($int_weight_item[$j],"Please enter float value.");
			$multi_err['intlengthError'][$j] = isEmpty($int_length_item[$j], COMMON_LENGTH_IS_REQUIRED) ? isEmpty($int_length_item[$j], COMMON_LENGTH_IS_REQUIRED) : isNumeric($int_length_item[$j], COMMON_NUMERIC_VAL);
			$multi_err['intwidthError'][$j]  = isEmpty($int_width_item[$j], COMMON_WIDTH_IS_REQUIRED) ? isEmpty($int_width_item[$j], COMMON_WIDTH_IS_REQUIRED) : isNumeric(valid_input($_POST['width_item'][$j]), COMMON_NUMERIC_VAL);
			$multi_err['intheightError'][$j] = isEmpty($int_height_item[$j], COMMON_HEIGHT_IS_REQUIRED) ? isEmpty($int_height_item[$j], COMMON_HEIGHT_IS_REQUIRED) : isNumeric(valid_input($_POST['height_item'][$j]), COMMON_NUMERIC_VAL);
			//echo $servicepage."---".$int_item_type[0]."</br>";
			//exit();
			$fieldArr = array("*");
			$seaPageArr = array();
			$seaPageArr[] = array('Search_On'=>'service_page_name', 'Search_Value'=>'international', 'Type'=>'string', 'Equation'=>'=', 'CondType'=>'AND', 'Prefix'=>'', 'Postfix'=>'');
			$pageData = $ObjServicePageIndexMaster->getServicePageName($fieldArr, $seaPageArr);
			$pageData = $pageData[0];
			
			if(!empty($pageData)){

				if(isset($int_qty_item[$j]) && $int_qty_item[$j]<0){
					$multi_err['intqtyError'][$j] = 'Quantity must be greater than 0';
				}
				if(isset($int_weight_item[$j]) && $int_weight_item[$j]<0){
					$multi_err['intweightError'][$j] = 'Weight must be greater than 0';
				}
				if(isset($int_length_item[$j]) && $int_length_item[$j]<0){
					$multi_err['intlengthError'][$j] = 'Length must be greater than 0';
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
						$multi_err['intheightError'][$j] = 'Sorry we can\'t accept these dimensions'.'cal girth:'.$total_girth[$j].'max girth:'.$pageData['girth_max'];
					}
				}
				
			}
		}

	}
	/*echo "<pre>";
	print_r($multi_err);
	echo "</pre>";
	exit();*/
	foreach ($err as $key => $Value) {
		if ($Value != '') {
            $Svalidation = true;
			//logOut();
		}
    }


	/* this is for selecting multiple items row */
	foreach ($multi_err as $key => $Value) {
		foreach ($Value as $kky => $val1) {
				if ($val1 != '') {
				$Svalidation = true;
				//logOut();
			}
		}
	}
	if(isset($hidden_err)){

		foreach($hidden_err as $key => $Value) {
			foreach ($Value as $kky => $val1) {
				if ($val1 != '') {
					/*echo "<pre>";
					print_r($hidden_err);
					echo "</pre>";
					exit();*/
					logOut();
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
	$_SESSION['pagename']="booking";
	 
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
				$d_st_city_zone;
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
	//echo "metro valid state:".$o_metro_valid_state."--".$d_metro_valid_state."</br>";
	//echo "startrack:".$o_st_city_zone."--".$d_st_city_zone."</br>";
	//exit();
	if(empty($o_metro_valid_state) || empty($d_metro_valid_state)){
		$cond_metro = false;
	}

	/* Below condition is for testing its from same zone of metro or not */
	if($Svalidation == false && $o_metro_valid_state == $d_metro_valid_state && $flag == 1){
		$cond_supplier_id = 10;
		$cond_metro = true;
		$service_local = 1;

		if(isset($pickupid) && isset($deliverid) && $pickupid!='' && $deliverid !=''){
			$dis = distanceKm($pickupid,$deliverid);
		}

		if(!empty($o_metro_valid_state) && !empty($d_metro_valid_state)){

			$metroresult = totalServices($o_metro_valid_state,$d_metro_valid_state);
		}

		if($metroresult != ""){
			$metro_no = mysqli_num_rows($metroresult);
		}

		if($metro_no ==0){
			$err['no_service_available'] = NO_SERVICE_AVAILABLE;
		}
		//echo "metro number:".$metro_no;
		if($metro_no!=0){
			$k=0;
			$msg_fee_flag = 0;
			while($row = mysqli_fetch_array($metroresult)){
				$ser_code = $row['service_code'] ;
				$service_val = getServiceData($ser_code,$cond_supplier_id);
				/*echo "<pre>";
				print_r($service_val);
				echo "</pre>";
				exit();*/
				$service_val = $service_val[0];
				if(!empty($service_val)){

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
					if($o_metro_valid_state!=''){

						$base_tariff = strtolower($o_metro_valid_state.$service);
						$base_tariff = outboundDir($base_tariff);
						$tbl = checkTableExit($base_tariff);
						//echo "first if condition:".$base_tariff."table:".$tbl."</br>";
						//if($tbl!='' && $supplier_id == 3 && $cond_metro == true){
						if($tbl!='' && $supplier_id == 10 && $cond_metro == true){
							$service_data[$k]['service_rate'] = cal_val_direct($base_tariff,$kg,$tbl,$dis);
						}
					}

					/* condition for outbound */

					/* condition for inbound */
					if($d_metro_valid_state!=''){
						$base_tariff = strtolower($d_metro_valid_state.$service);
						//echo $base_tariff."</br>";
						$base_tariff = inboundDir($base_tariff);
						$tbl = checkTableExit($base_tariff);
						//echo "second if condition:".$base_tariff."table:".$tbl."</br>";
						//if($tbl!='' && $supplier_id == 3 && $cond_metro == true){
						if($tbl!='' && $supplier_id == 10 && $cond_metro == true){
							$service_data[$k]['service_rate'] = cal_val_direct($base_tariff,$kg,$tbl,$dis);
						}
					}

					/* condition for inbound */

					/* condition for both */
					if($service_data[$k]['service_rate'] == 0){
						/*
								Right now steve has told to use only single standard table for sydney
								For express and priority it will just multiplication of 2 and 3.
								So it means fetch values from syddcst table and when showing express and priority just
								multiply by 2 and 3.
						*/

						//$base_tariff = strtolower($o_metro_valid_state.$service);
						$base_tariff = strtolower($o_metro_valid_state.'st');
						$base_tariff = bothDir($base_tariff);
						$tbl = checkTableExit($base_tariff);
						$dest = $deliver;
						if($tbl === 0){
							//$base_tariff = strtolower($d_metro_valid_state.$service);
							$base_tariff = strtolower($d_metro_valid_state.'st');
							$base_tariff = bothDir($base_tariff);
							$tbl = checkTableExit($base_tariff);

							$dest = $pickup;
						}
						//echo "service:".$service."third if condition:".$base_tariff."table:".$tbl."</br>";
						//exit();
						//if($tbl!='' && $supplier_id == 3 && $cond_metro == true){
						if($tbl!='' && $supplier_id == 10 && $cond_metro == true){
							//echo $base_tariff."---".$kg."---".$tbl."--".$dis."</br>";
							//exit();
							$service_data[$k]['service_rate'] = cal_val_direct($base_tariff,$kg,$tbl,$dis);
							if(isset($service) && $service == 'ex'){
								$service_data[$k]['service_rate'] = 2*cal_val_direct($base_tariff,$kg,$tbl,$dis);
							}elseif (isset($service) && $service == 'pr') {
								# code...
								$service_data[$k]['service_rate'] = 3*cal_val_direct($base_tariff,$kg,$tbl,$dis);
							}

						}
					}

					/* condition for both */

					/* condition for zzz */
					if($service_data[$k]['service_rate'] == 0){
						$base_tariff = strtolower('zzz'.$service);
						$base_tariff = bothDir($base_tariff);

						$tbl = checkTableExit($base_tariff);
						//echo "fourth if condition:".$base_tariff."table:".$tbl."</br>";
						//if($tbl!='' && $supplier_id == 3 && $cond_metro == true){
						if($tbl!='' && $supplier_id == 10 && $cond_metro == true){
							$service_data[$k]['service_rate'] = cal_val_direct($base_tariff,$kg,$tbl,$dis);
						}
					}
					
					/* condition for zzz */
					if($service_data[$k]['service_rate'] != 0){
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
						$total_gst = calculate_gst_charge($gst,calculate_charge($suppier_fuel_charge[$service_val['supplier_id']],$service_data[$k]['service_rate'],$surcharge));
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
				exit();*/
			}

		}

	}

	//echo $o_st_city_zone."--".$d_st_city_zone."</br>";
	//exit();
	if($flag == 1 && $Svalidation == false){

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
			//$i=0;

			while($row = mysqli_fetch_array($result)){
				$ser_code = $row['service_code'];
				//echo $ser_code."</br>";
				$service_val = getServiceData($ser_code,$code_format_id,$cond_metro);
				$service_val = $service_val[0];

				if(!empty($service_val))
				{

					$service = strtolower($service_val['service_code']);
					$base_tariff = $city.$service;
					$base_tariff_destination = $d_st_city_zone.$service;


					
					$supplier_id = $service_val['supplier_id'];

					
					$totalweight = $kg;


					/* condition for both */
					if($service_data[$l]['service_rate'] == 0)
					{
						$base_tariff = strtolower('aus'.$service);
						$base_tariff = bothDir($base_tariff);
						$tbl = checkTableExit($base_tariff);
						/*echo "<pre>";
						print_r($_POST);
						echo "</pre>";*/
						//echo 'table:'.$tbl."-basetariff-".$base_tariff.'--kg-'.$kg.'-ocityname-'.$o_st_city_zone.'dstname'.$d_st_city_zone."</br>";
						if($tbl!='' && $supplier_id == 0)
						{
							$service_rate = cal_val($base_tariff,$kg,$tbl,$o_st_city_zone,$d_st_city_zone);
							//echo "first loop:".$service_rate."</br>";
							if(isset($service_rate) && !empty($service_rate)){
								$service_data[$l]['service_rate'] = $service_rate;
							}
						}

					}
					//echo $service_data[$l]['service_rate']."</br>";

					/* condition for both */

					/* condition for zzz */

					if($service_data[$l]['service_rate'] == 0)
					{
						$base_tariff = strtolower('zzz'.$service);
						$base_tariff = bothDir($base_tariff);

						$tbl = checkTableExit($base_tariff);
						//echo "table".$tbl;
						//exit();
						if($tbl!='' && $supplier_id == 0)
						{
							$service_rate = cal_val($base_tariff,$kg,$tbl,$o_st_city_zone,$d_st_city_zone);
							//echo "second loop:".$service_rate."</br>";
							if(isset($service_rate) && !empty($service_rate)){
								$service_data[$l]['service_rate'] = $service_rate;
							}
							 
						}

					}
					//echo $service_data[$l]['service_rate']."</br>";
					//exit();
					/* condition for zzz */

					if($service_data[$l]['service_rate'] != 0)
					{
						$gst = GST;
						if($drc==1){
							$surcharge=number_format($service_val->surcharge,2,'.','');
						}else{
							$surcharge=0;
						}
						
						$service_data[$l]['surcharge'] = $surcharge;
						$service_data[$l]['service_rate'] = $service_data[$l]['service_rate'];
						$service_data[$l]['service_name'] = $service_val['service_name'];
						$service_data[$l]['service_code'] = $service_val['service_code'];
						$service_data[$l]['supplier_name'] = $service_val['supplier_name'];
						$service_data[$l]['hours'] = $service_val['hours'];
						$service_data[$l]['minites'] = $service_val['minites'];
						$service_data[$l]['hr_formate'] = $service_val['hr_formate'];
						$service_data[$l]['supplier_id'] = $service_val['supplier_id'];
						$service_data[$l]['box_color'] = $service_val['box_color'];
						$service_data[$l]['sorting'] = $service_val['sorting'];
						$service_data[$l]['service_status_info'] = $service_val['service_status_info'];
						$service_data[$l]['service_info'] = $service_val['service_info'];
						$service_data[$l]['delivery_fee'] = number_format($service_data[$l]['service_rate'],2,'.','');
						$service_data[$l]['fuel_surcharge'] = calculate_fuel_charge($suppier_fuel_charge[$service_val['supplier_id']],$service_data[$l]['service_rate']);
						$service_data[$l]['base_fuel_fee'] = $suppier_fuel_charge[$service_val['supplier_id']];
						$total_gst = calculate_gst_charge($gst,calculate_charge($suppier_fuel_charge[$service_val['supplier_id']],$service_data[$l]['service_rate'],$surcharge));
						$service_data[$l]['total_gst'] = $total_gst;
						$service_data[$l]['sorting'] = $service_val['sorting'];
						$service_data[$l]['total_delivery_fee'] = calculate_charge($suppier_fuel_charge[$service_val['supplier_id']],$service_data[$l]['service_rate'],$surcharge);
						$service_data[$l]['service_rate'] =calculate_charge_with_gst(calculate_charge($suppier_fuel_charge[$service_val['supplier_id']],$service_data[$l]['service_rate'],$surcharge),$total_gst);
						$star_fee_flag = 1;
						$l++;

					}
					

				}

			}
			/*echo "<pre>";
		print_r($service_data);
		echo "</pre>";
		exit();*/
			//exit();
		}
		/*echo "<pre>";
		print_r($service_data);
		echo "</pre>";
		exit();

			exit();
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
				//echo $tnt_ser_code."</br>";
				$tnt_service_val = getServiceData($tnt_ser_code,$code_format_id,$cond_metro);
				$tnt_service_val = $tnt_service_val[0];
				//echo $tnt_service_val['service_code']."</br>";

				
				//echo "tnt service rate:".$tnt_service_val;
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
						if($tbl!='')
						{
					//echo "kgs".$kg;
					//echo $o_st_city_zone;
					//echo $d_st_city_zone;
							$tnt_service_rate = cal_val_tnt($base_tariff,$kg,$tbl,$o_st_city_zone,$d_st_city_zone);
						}

					}
					//echo "tnt service rate:".$tnt_service_rate;
					/* condition for both */
					//exit();

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
					//echo "supplier name:".$tnt_service_val['supplier_name'];
					if($tnt_service_rate != 0)
					{
						$gst = GST;
						$service_data[$t]['service_name'] = $tnt_service_val['service_name'];
						$service_data[$t]['service_code'] = $tnt_service_val['service_code'];
						$service_data[$t]['supplier_name'] = $tnt_service_val['supplier_name'];

						if($drc==1){
							$surcharge=number_format($tnt_service_val->surcharge,2,'.','');
							$service_data[$t]['surcharge']=number_format($tnt_service_val->surcharge,2,'.','');
						}else{
							$surcharge=0;
							$service_data[$t]['surcharge']=0;
						}
						//echo $service_data[$l]['service_rate']."</br>";
						$service_data[$t]['hours'] = $service_val['hours'];
						$service_data[$t]['minites'] = $service_val['minites'];
						$service_data[$t]['hr_formate'] = $service_val['hr_formate'];
						$service_data[$t]['supplier_id'] = $service_val['supplier_id'];
						$service_data[$t]['box_color'] = $service_val['box_color'];
						$service_data[$t]['sorting'] = $service_val['sorting'];
						$service_data[$t]['service_status_info'] = $service_val['service_status_info'];
						$service_data[$t]['service_info'] = $service_val['service_info'];
						$service_data[$t]['service_rate'] = $tnt_service_rate;
						$service_data[$t]['delivery_fee'] = number_format($service_data[$t]['service_rate'],2,'.','');
						$service_data[$t]['fuel_surcharge'] = calculate_fuel_charge($suppier_fuel_charge[$tnt_service_val['supplier_id']],$service_data[$t]['service_rate']);
						$service_data[$t]['base_fuel_fee'] = $suppier_fuel_charge[$tnt_service_val['supplier_id']];
						$total_gst = calculate_gst_charge($gst,calculate_charge($suppier_fuel_charge[$tnt_service_val['supplier_id']],$service_data[$t]['service_rate'],$surcharge));
						$service_data[$t]['total_gst'] = $total_gst;
						$service_data[$k]['sorting'] = $tnt_service_val['sorting'];
						$service_data[$t]['total_delivery_fee'] = calculate_charge($suppier_fuel_charge[$tnt_service_val['supplier_id']],$service_data[$t]['service_rate'],$surcharge);
						$service_data[$t]['service_rate'] =calculate_charge_with_gst(calculate_charge($suppier_fuel_charge[$tnt_service_val['supplier_id']],$service_data[$t]['service_rate'],$surcharge),$total_gst);

						$star_fee_flag = 1;

					}
					$t++;
					/*echo "<pre>";
					print_r($service_data);
					echo "</pre>";
					*/
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
			$cond_supplier_id = 4;
			if($result != "")
			{
				$no = mysqli_num_rows($result);
			}
			if($no != 0){
				$m=0;
				while($row = mysqli_fetch_array($result)){
					$ser_code = $row['service_code'] ;
					$service_val = getServiceData($ser_code,$cond_supplier_id);
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
					foreach($CountryData as $CountryDataval){
						$deliverinterzone=$CountryDataval['zone'];/* Selected the zone on the basis of delivery id for international zones*/
						$_SESSION['international_country_name']=$CountryDataval['countries_name'];
					}

					$service_data[$m]['service_rate'] = cal_val_int($base_tariff,$int_item_type,$int_kg,$tbl,$deliverinterzone);

					if($drc==1){
						$surcharge=number_format($service_val->surcharge,2,'.','');
						$service_data[$m]['surcharge']=number_format($service_val->surcharge,2,'.','');
					}else{
						$surcharge=0;
						$service_data[$m]['surcharge']=0;
					}

					if($service_data[$m]['service_rate'] != 0)
					{
						$service_data[$m]['delivery_fee'] = number_format($service_data[$m]['service_rate'],2,'.','');
						$service_data[$m]['fuel_surcharge'] = calculate_fuel_charge($suppier_fuel_charge[$service_val['supplier_id']],$service_data[$m]['service_rate']);

						$service_data[$m]['base_fuel_fee'] = $suppier_fuel_charge[$service_val['supplier_id']];
						$service_data[$m]['total_delivery_fee'] = calculate_charge($suppier_fuel_charge[$service_val['supplier_id']],$service_data[$m]['service_rate'],$surcharge);
						$service_data[$m]['service_rate'] =$service_data[$m]['total_delivery_fee'];
					}
					/*
					echo "<pre>";
					print_R($service_data);
					echo "</pre>";
					exit();*/
					if(((isset($_GET['bookingid'])) || $service_data[$m]['service_rate'] != 0 )	){

						require_once(DIR_WS_RELATED."international_service_multi.php");

					}
					$m++;
					}
				}
			}
		}
	}
}

require_once(DIR_WS_SITE_CURRENT_TEMPLATE . FILE_MAIN_INTERFACE);
?>
