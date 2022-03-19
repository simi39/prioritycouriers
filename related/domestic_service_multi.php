<?php
	$BookingDetailsDataObj = new stdClass;
   /* $BookingDetailsDataObj->webservice =(($service_local==1)?('AAE'):('DIRCOUR'));
	*/

    $BookingDetailsData = $__Session->GetValue("booking_details");

	 if(isset($BookingDetailsData) && !empty($BookingDetailsData)){
		foreach ($BookingDetailsData as $key=>$val) {
			$BookingDetailsDataObj->{$key}=$val;
		}
	 }
	// $BookingDetailsDataObj->servicepagename = "domestic";
	if($service_local == 1)
	{
		$BookingDetailsDataObj->servicepagename = "sameday";
	}else{
		$BookingDetailsDataObj->servicepagename = "overnight";
	}

  $BookingDetailsDataObj->flag = "australia";
	$BookingDetailsDataObj->payment_done = "false";
	$BookingDetailsDataObj->booking_id = $bookingid;
	$BookingDetailsDataObj->pickupid = $pickup;
	$BookingDetailsDataObj->deliveryid = $deliver;
	$BookingDetailsDataObj->p_id=$pickupid;
	$BookingDetailsDataObj->d_id= $deliverid;
	$BookingDetailsDataObj->distance_in_km = $distance;
	$BookingDetailsDataObj->total_qty = $_POST['aus_total_qty'];
	$BookingDetailsDataObj->total_weight = $original_weight;
	$BookingDetailsDataObj->volumetric_weight = $volumetric_weight;
	$BookingDetailsDataObj->chargeable_weight = $chargeable_weight;
	$BookingDetailsDataObj->total_volume = $total_volume;
	$BookingDetailsDataObj->standard_rate = $samedayamt;
	$BookingDetailsDataObj->express_rate = $expcharge;
	$BookingDetailsDataObj->priority_rate = $priority;
	$BookingDetailsDataObj->overnight_rate = $overnightamt;
	$BookingDetailsDataObj->economy_rate = $economyamt;
	$BookingDetailsDataObj->road_express=$roadexpressamt;
	//$BookingDetailsDataObj->start_date =$start_date;
	$BookingDetailsDataObj->min_date =$min_date;
	//$BookingDetailsDataObj->time_hr =$time_hr;
	//$BookingDetailsDataObj->time_sec =$time_sec;
	//$BookingDetailsDataObj->hr_formate =$hr_formate;
	
	 
	//echo $min_date;
	//exit();
	if(isset($service_data))
	{
		$ServiceDataObjArray = array();
		$service_name = "";
		$supplierName ="";
		$ServiceDataObj	= "";
		$k=0;
		for($i=0;$i<count($service_data);$i++)
		{
			if($service_data[$i]['service_rate']){
				$ServiceDataObj = new stdClass;
				$ServiceDataObj->service_name = $service_data[$i]['service_name'];
				$ServiceDataObj->service_code = $service_data[$i]['service_code'];
				$ServiceDataObj->service_rate = $service_data[$i]['service_rate'];
				$ServiceDataObj->delivery_fee = $service_data[$i]['delivery_fee'];
				$ServiceDataObj->base_fuel_fee = $service_data[$i]['base_fuel_fee'];
				$ServiceDataObj->hours		   = $service_data[$k]['hours'];
				$ServiceDataObj->minites	 = $service_data[$k]['minites'];
				$ServiceDataObj->hr_formate  = $service_data[$k]['hr_formate'];
				$ServiceDataObj->service_status_info  = $service_data[$k]['service_status_info'];
				$ServiceDataObj->service_info  = $service_data[$k]['service_info'];
				$ServiceDataObj->sorting  = $service_data[$k]['sorting'];
				$ServiceDataObj->supplier_id	= $service_data[$k]['supplier_id'];
				$ServiceDataObj->box_color	=	$service_data[$k]['box_color'];
				$ServiceDataObj->surcharge = $service_data[$i]['surcharge'];
				$ServiceDataObj->fuel_surcharge = $service_data[$i]['fuel_surcharge'];
				$ServiceDataObj->total_gst = $service_data[$i]['total_gst'];
				$ServiceDataObj->total_delivery_fee = $service_data[$i]['total_delivery_fee'];
				$supplierName = strtolower($service_data[$i]['service_name'])."_supplier";
				//echo "valur of i".$i."supplier".$service_data[$i]['supplier_name']."</br>";

				$ServiceDataObj->$supplierName = $service_data[$i]['supplier_name'];
				$ServiceDataObjArray[$k] = (array)$ServiceDataObj;
				$k++;
			}

		}
	}

	$__Session->SetValue("service_details",$ServiceDataObjArray);
	$BookingDetailsDataObj->pickup_time_zone = $pickuptimezone;
	$BookingDetailsDataObj->delivery_time_zone = $delivertimezone;
	$BookingDetailsDataObj->pageid = "0";
	//$BookingDetailsDataObj->drc=$drc;

	$BookingDetailsDataObj->pickup_location_type=$pickup_drc;
	$BookingDetailsDataObj->delivery_location_type=$delivery_drc;
	//$BookingDetailsDataObj->userid = $userid;
	$BookingDetailsDataObj->pagename="quote";

	$BookingDetailsDataObjArray =array();
	$BookingDetailsDataObjArray = (array) $BookingDetailsDataObj;

	$__Session->SetValue("booking_details",$BookingDetailsDataObjArray);


	$countitem = count((array)$item_weight);


	$BookingItemDetailsDataObjArray= array();
	for($i=0;$i<$countitem-1;$i++)
	{
		$shipping_name="selShippingType";
		$qty_name="Item_qty";
		$org_weight_name ="Item_weight";
		$length_name="Item_length";
		$width_name="Item_width";
		$height_name="Item_height";


		$BookingItemDetailsDataObj = new stdClass;
		$BookingItemDetailsDataObj->booking_id=$bookingid;
		$BookingItemDetailsDataObj->item_type=$selShippingType[$i];
		$BookingItemDetailsDataObj->quantity=$item_qty[$i];
		$BookingItemDetailsDataObj->item_weight=$item_weight[$i];
		if($qty_status[$i]!="")
		{
			$BookingItemDetailsDataObj->qty_status=$qty_status[$i];
		}
		if($weight_status[$i]!="")
		{
			$BookingItemDetailsDataObj->weight_status=$weight_status[$i];
		}
		if($dim_status[$i]!="")
		{
			$BookingItemDetailsDataObj->dim_status=$dim_status[$i];
		}
		$item_qty[$i] = 1;
		//echo $i."--".$item_width[$i]."--".$item_length[$i]."---".$item_height[$i]."---".$item_qty[$i]."</br>";
		//exit();
		$BookingItemDetailsDataObj->length=$item_length[$i];
		$BookingItemDetailsDataObj->width=$item_width[$i];
		$BookingItemDetailsDataObj->height=$item_height[$i];
		$BookingItemDetailsDataObj->vol_weight=ceil((($item_width[$i]*$item_length[$i]*$item_height[$i])/4000)*$item_qty[$i]);
		//$BookingItemDetailsDataObj->vol_weight=ceil((($item_width[$i]*$item_length[$i]*$item_height[$i]))*$item_qty[$i]);

		//list multiple items
		$BookingItemDetailsDataObjArray[$i] = (array)$BookingItemDetailsDataObj;
	}


	$__Session->SetValue("booking_details_items",$BookingItemDetailsDataObjArray);
	//store in seesion
	$__Session->Store();

	if(	$service_local==1) {
		$_SESSION['diffzone_overnighamt'] = $overnightamt;/* Addtion of all the items having overnight amount*/
		$_SESSION['diffzone_economoyamt'] = $economyamt; /* Addtion of all the items having economy amount*/
	    $_SESSION['diffzone_roadexpressamt'] = $roadexpressamt;
	}
	if(isset($_GET['Action']) && $_GET['Action'] == 'edit'){
		//echo "inside this conditon:";
		//exit();
					header("Location:".FILE_CHECKOUT);
					exit();
	}else{
		if(isset($_GET['edit']))
		{
			if($_GET['edit']=="1")
			{
	              header('location:'.FILE_DOMESTIC_SHIPPING);
				  exit;
			}
			if($_GET['edit']=="2")
			{
				header('location:'.FILE_BOOKING);
				exit;
			}
			if($_GET['edit']=="3")
			{
				header('location:'.FILE_BOOKING_CONFIRMATION_AUSTRALIA);
				exit;
			}
		}
		else
		{

			if($service_local==2) {
				header('location:'.FILE_INTERSTATE_RATES);/*Redirection to overnight page. */
				exit;
			} else {
				header('location:'.FILE_METRO_RATES);
				exit;
			}
		}
	}
?>
