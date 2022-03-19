<?php
session_start();
require_once("../lib/common.php");
require_once(DIR_WS_CURRENT_LANGUAGE . "additional-details.php");
require_once(DIR_WS_CURRENT_LANGUAGE . "commercial_invoice.php");
require_once(DIR_WS_MODEL . "SiteConstantMaster.php");
require_once(DIR_WS_MODEL."CommercialInvoiceMaster.php");
require_once(DIR_WS_MODEL."CommercialInvoiceItemMaster.php");
require_once(DIR_WS_MODEL . "ServiceMaster.php");


$ObjServiceMaster	= ServiceMaster::Create();
$ServiceData		= new ServiceData();

$BookingDetailsDataObj = $__Session->GetValue("booking_details");
$BookingDatashow = new stdClass;
foreach ($BookingDetailsDataObj as $key=>$val) {
	$BookingDatashow->{$key}=valid_output($val);
}
$flag = $BookingDatashow->flag;

$err          = array();
$booking_type = valid_input($_POST['bookingType']);
$shippingtype = valid_input($_POST['shippingType']);
$goodsvalue   = valid_input($_POST['goodsValue']);

$price        = $_POST['price'];

$err['BOOKING_TYPE_ERROR'] = checkStr($booking_type);
$err['SHIPPING_TYPE_ERROR'] = checkStr($shippingtype);
$err['GOODS_VALUE_ERROR'] = isNumeric($goodsvalue,COMMON_NUMERIC_VAL);
$err['PRICE_ERROR'] = isNumeric($price,COMMON_NUMERIC_VAL);
foreach ($err as $key => $Value) {
	
	if ($Value != '') {
		$Svalidation = true;
	}
}

if(isset($_POST['action']) && $_POST["action"] == "get_transit" && $Svalidation == false){
	
	if(isset($_POST['bookingType'])){
		$returnTransArr = array();
		$returnTransArr = getTransitPriceData($booking_type,$shippingtype,$goodsvalue);
		
		if(is_array($returnTransArr)){
			$returnTransArr['goodsValue']  = $goodsvalue;
			
			if(calTransitPrice($returnTransArr))
			{
				
				unset($_SESSION['transit_amount']);
				unset($_SESSION['without_gst_transit_amount']);
				
				$without_gst_transit_amt =  calTransitPrice($returnTransArr);
				if($flag == 'australia')
				{
					$total_gst =  calculate_gst_charge(GST,$without_gst_transit_amt);
				}else{
					$total_gst = 0;
					
				}
				$total_transit_amt = number_format(($without_gst_transit_amt+$total_gst),2, '.', '');
				$_SESSION['transit_amount'] = $total_transit_amt;
				$_SESSION['without_gst_transit_amount'] = $without_gst_transit_amt;
				echo $total_transit_amt.'^^^'.$without_gst_transit_amt;
				
			}else{
			
				echo 0;
			}
			exit;
		}else{
			echo "Transt_price_not_applicable";
			exit;
		}
	}
}elseif($_POST["action"] == "unset_transit" && $Svalidation == false){
	$BookingDetailsDataObj = $__Session->GetValue("booking_details");
	$BookingDatashow = new stdClass;

	foreach ($BookingDetailsDataObj as $key=>$val) {
		$BookingDatashow->{$key}=$val;
		

	}
	
	if (isset($tansient_warranty)){
		unset($tansient_warranty);
		unset($coverage_rate);
		
	}
	echo"Success";
	exit;
}else{
	
	foreach ($err as $key => $Value) {
		if ($Value != '') {
			echo $Value;
			exit;
		}
	}
}


?>