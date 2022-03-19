<?php
	$BookingDetailsDataObj = new stdClass;
	 $BookingDetailsData = $__Session->GetValue("booking_details");
	//$BookingDatashow = new stdClass;
	 if(isset($BookingDetailsData) && !empty($BookingDetailsData)){
		foreach ($BookingDetailsData as $key=>$val) {
			$BookingDetailsDataObj->{$key}=$val;
			//$$key=$val;
		}
	}
	if(isset($service_data) && $service_data != ""){

		$ServiceDataObjArray = array();
		$service_name = "";
		$supplierName ="";
		$ServiceDataObj	= "";

		for($i=0;$i<count($service_data);$i++)
		{
			$ServiceDataObj = new stdClass;
			$ServiceDataObj->service_name = $service_data[$i]['service_name'];
			$ServiceDataObj->service_code = $service_data[$i]['service_code'];
			$ServiceDataObj->service_rate = $service_data[$i]['service_rate'];
			$ServiceDataObj->delivery_fee = $service_data[$i]['delivery_fee'];
			$ServiceDataObj->base_fuel_fee = $service_data[$i]['base_fuel_fee'];
			$ServiceDataObj->surcharge = $service_data[$i]['surcharge'];
			$ServiceDataObj->fuel_surcharge = $service_data[$i]['fuel_surcharge'];
			$supplierName = strtolower($service_data[$i]['service_name'])."_supplier";
			$ServiceDataObj->total_delivery_fee = $service_data[$i]['total_delivery_fee'];
			$ServiceDataObj->$supplierName = $service_data[$i]['supplier_name'];
			$ServiceDataObjArray[$i] = (array)$ServiceDataObj;
		}

	}

	$__Session->SetValue("service_details",$ServiceDataObjArray);


	$BookingDetailsDataObj->flag = "international";
	$BookingDetailsDataObj->webservice ='UPS';
	$BookingDetailsDataObj->payment_done = "false";
	$BookingDetailsDataObj->p_id=$pickupid;
	$BookingDetailsDataObj->d_id= $deliverid;
	$BookingDetailsDataObj->pickupid = $pickup;
	$BookingDetailsDataObj->deliveryid = $int_country;
	$BookingDetailsDataObj->distance_in_km = $distance;
	$BookingDetailsDataObj->total_qty = $_POST['international_total_qty'];
	$BookingDetailsDataObj->total_weight = $int_original_weight;
	$BookingDetailsDataObj->total_volume =$int_total_volume;
	$BookingDetailsDataObj->chargeable_weight = $int_chargeable_weight;
	$BookingDetailsDataObj->standard_rate = $samedayamt;
	$BookingDetailsDataObj->express_rate = $expcharge;
	$BookingDetailsDataObj->servicepagename = "international";
	/*$BookingDetailsDataObj->priority_rate = $priority;
	$BookingDetailsDataObj->overnight_rate = $overnightamt;
	$BookingDetailsDataObj->economy_rate = $economyamt;*/
	$BookingDetailsDataObj->international_rate=$service_data[0]['service_rate'];
	$BookingDetailsDataObj->rate=$service_data[0]['service_rate'];
	$BookingDetailsDataObj->additional_cost=0;
	$BookingDetailsDataObj->pickup_time_zone = $pickuptimezone;
	$BookingDetailsDataObj->delivery_time_zone = $delivertimezone;
	$BookingDetailsDataObj->userid=$userid;
	$BookingDetailsDataObj->flag="international";
	$BookingDetailsDataObj->pageid="0";
	$BookingDetailsDataObj->pagename="quote";
	//$BookingDetailsDataObj->service_name="international";
	$BookingDetailsDataObj->start_date =$start_date;
	$BookingDetailsDataObj->min_date =$min_date;
	$BookingDetailsDataObj->time_hr =$time_hr;
	$BookingDetailsDataObj->time_sec =$time_sec;
	$BookingDetailsDataObj->hr_formate =$hr_formate;


	$BookingDetailsDataObjArray =array();
	$BookingDetailsDataObjArray = (array) $BookingDetailsDataObj;
	//print_R($_POST);
	//print_R($BookingDetailsDataObj);
	//exit();
	$__Session->SetValue("booking_details",$BookingDetailsDataObjArray);
	$booking_detail = $__Session->GetValue("booking_details");

	$inter_rows=count($_POST['weight_item']);
	$BookingItemDetailsDataObjArray =array();
	//echo "international item type:".$int_shipping_type;
	/*echo "<pre>";
	print_r($BookingItemDetailsData);
	echo "</pre>";
	echo "item type:".$int_item_type;
	exit();*/
	for ($i=0;$i<$inter_rows-1;$i++)
	{
		$BookingItemDetailsDataObj = new stdClass;

		$BookingItemDetailsDataObj->item_type=$int_item_type;
		$BookingItemDetailsDataObj->quantity=$int_qty_item[$i];
		$BookingItemDetailsDataObj->item_weight=$int_weight_item[$i];
		$BookingItemDetailsDataObj->length=$int_length_item[$i];
		$BookingItemDetailsDataObj->width=$int_width_item[$i];
		$BookingItemDetailsDataObj->height=$int_height_item[$i];
		if($int_qty_status[$i]!="")
		{
			$BookingItemDetailsDataObj->qty_status=$int_qty_status[$i];
		}
		if($int_weight_status[$i]!="")
		{
			$BookingItemDetailsDataObj->weight_status=$int_weight_status[$i];
		}
		if($int_dim_status[$i]!="")
		{
			$BookingItemDetailsDataObj->dim_status=$int_dim_status[$i];
		}
		$inter_volumetric_divisor    = international_services_volumetric_charges;
		$inter_volumetric_divisor    = ($inter_volumetric_divisor == '') ? ('5000') : ($inter_volumetric_divisor);
		$BookingItemDetailsDataObj->vol_weight=ceil((($int_length_item[$i]*$int_width_item[$i]*$int_height_item[$i])/$inter_volumetric_divisor)*$int_qty_item[$i]);
		$BookingItemDetailsDataObjArray[$i] = (array)$BookingItemDetailsDataObj;
	}
	//set val in session
	$__Session->SetValue("booking_details_items",$BookingItemDetailsDataObjArray);
	//store in seesion
	$__Session->Store();
	/*echo "<pre>";
	print_r($BookingItemDetailsDataObjArray);
	echo "</pre>";
	exit();*/
	if(isset($_GET['Action']) && $_GET['Action'] == 'edit'){

		header("Location:".FILE_ADDITIONAL_DETAILS);
		exit();

	}else{
		header('location:'.FILE_INTERNATIONAL);
		exit();
	}

require_once( DIR_WS_SITE_CURRENT_TEMPLATE . FILE_MAIN_INTERFACE); /* This include once is used for the html integration */
?>
