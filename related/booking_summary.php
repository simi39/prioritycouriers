<?php
require_once(DIR_WS_MODEL . "InternationalZonesMaster.php");
require_once(DIR_WS_MODEL . "ItemTypeMaster.php");

$InternationalZoneMasterObj= InternationalZonesMaster::create();
$InternationalZoneData = new InternationalZonesData();

$ItemTypeMasterObj = new ItemTypeMaster();
$ItemTypeMasterObj = $ItemTypeMasterObj->create();

$booking_details_data = $__Session->GetValue("booking_details");
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
	if($BookingItemDetailsData1->item_type == '4')
	{
		$international_item_type = "Document";
	}else{
		$international_item_type = "Non-Document";
	}
}

$supplier_name = $booking_details_data["service_name"]."_supplier";
$pickupid = $booking_details_data["pickupid"];
$deliveryid = $booking_details_data["deliveryid"];

$distance = $booking_details_data["distance"];
$flag = $booking_details_data["flag"];
$service_name = $booking_details_data["service_name"];
$rate = $booking_details_data["rate"];
$coverage_rate = $booking_details_data["coverage_rate"];
/*
if(isset($coverage_rate))
{
	$rate = $rate+$coverage_rate;
}*/
$seaArr = array();
/*
if($flag=="international")
{
	$seaArr[] = array('Search_On'    => 'id',
						  'Search_Value' => $deliveryid,
						  'Type'         => 'string',
						  'Equation'     => '=',
						  'CondType'     => '',
						  'Prefix'       => '',
						  'Postfix'      => '');
	$InternationalZoneData=$InternationalZoneMasterObj->getInternationalZones('null',$seaArr);
	$internationaName=$InternationalZoneData[0];
}*/

	/*echo "<pre>";
	print_R($booking_details_data);
	echo "</pre>";*/
	$courier_name = $booking_details_data["webservice"];

	//echo "flag:".$booking_details_data['flag']."</br>";

?>
<!-- Summary -->
<div class="who margin-bottom-30">
	<div class="headline"><h3>Shipment Summary</h3></div>
	<!--=== Weight and Dimentions Summary===-->
	<ul id="ausResult" style="display:<?php  if($booking_details_data['flag'] !="international"){echo "block";}else{echo "none";}?>;">
		<li>Quantity: <span id="total_qty"><?php if(isset($booking_details_data['total_qty']) && $booking_details_data['total_qty']!=""){echo filter_var($booking_details_data['total_qty'],FILTER_VALIDATE_INT);}else{ echo "1";}?></span></li>
		<li>Weight: <span class="pickup_form_orange" id="total_weight"><?php if(isset($booking_details_data['total_weight']) && $booking_details_data['total_weight']!=""){ echo filter_var($booking_details_data['total_weight'],FILTER_VALIDATE_FLOAT);}  ?></span>kg</li>
		<li>Chargeable weight: <span class="pickup_form_orange" id="total_chargeable_weight"><?php echo filter_var($booking_details_data['chargeable_weight'],FILTER_VALIDATE_FLOAT);?></span>kg</li>
    <li>Total Volume: <span class="pickup_form_orange" id="total_volume_rounded"><?php echo filter_var(round($booking_details_data['total_volume'],2),FILTER_VALIDATE_FLOAT);?></span>m<sup>3</sup></li>
	</ul>

	<ul id="interResult" style="display:<?php  if($booking_details_data['flag'] =="international"){echo "block";}else{echo "none";}?>;">
	<?php  if($booking_details_data['flag'] =="international")?>
		<li>Total Quantity: <span class="pickup_form_orange" id="inter_total_qty"><?php echo filter_var($booking_details_data['total_qty'],FILTER_VALIDATE_INT);?></span></li>
		<li>Deadweight: <span class="pickup_form_orange" id="inter_total_weight"><?php echo filter_var($booking_details_data['total_weight'],FILTER_VALIDATE_FLOAT);  ?></span>kg</li>
		<li>Volumetric weight: <span class="pickup_form_orange" id="inter_total_volumetric_weight"><?php echo filter_var($booking_details_data['volumetric_weight'],FILTER_VALIDATE_FLOAT);?></span>kg</li>
		<li>Chargeable weight: <span class="pickup_form_orange" id="inter_total_chargeable_weight"><?php echo filter_var($booking_details_data['chargeable_weight'],FILTER_VALIDATE_FLOAT);?></span>kg</li>
		<li>Total Volume: <span class="pickup_form_orange" id="inter_total_volume_round"><?php echo filter_var(round($booking_details_data['total_volume'],2),FILTER_VALIDATE_FLOAT);?></span>m<sup>3</sup></li>
	</ul>
	<!--=== Weight and Dimentions Summary===-->
	<ul>
	   <?php if(isset($service_name) && !empty($service_name)){ ?>
	   <li>Service Name: <span class="pickup_form_orange" id="span_service_name"><?php  echo ucwords($service_name);?></span></li>
	  <?php }
	if($booking_details_data['flag'] =="international" && $international_item_type!="")
	{
	?>
	<li>International Item Type: <span class="pickup_form_orange" ><?php echo ucwords($international_item_type);?></span>
	<?php
	}
	if($rate){
		//echo "courier name:".$courier_name."</br>";
	?>
	<li>Freight Charges: $<span class="pickup_form_orange" id="original_price"><?php if(isset($rate)){echo $rate;}?></span>
	<?php
	}
	//if(isset($booking_details_data['start_date']) && !empty($booking_details_data['start_date']))
	//{
		/*$zonedate = date('Y-m-d H:i',strtotime(get_time_zonewise($pickupid)));
		if(!empty($booking_details_data['start_date']))
		{
			$sessiondate = date('Y-m-d H:i', strtotime($booking_details_data['start_date']));
			$start_date = $zonedate;
			if(strtotime($sessiondate) > strtotime($start_date))
			{
				$start_date = date('Y-m-d H:i', strtotime($booking_details_data['start_date']));
			}
			$dateChange = 'true';
		}*/
		/*echo "<pre>";
		print_r($booking_details_data);
		echo "</pre>";*/
		$display_span_collection_dt = 'display:none';
		if(isset($booking_details_data['start_date']) && !empty($booking_details_data['start_date'])){
			$display_span_collection_dt = 'display:block';
		}

		$display_span_time_ready = 'display:none';
		if(isset($booking_details_data['time_ready']) && !empty($booking_details_data['time_ready'])){
			$display_span_time_ready = 'display:block';
		}

		$display_span_close_time = 'display:none';
		if(isset($booking_details_data['close_time']) && !empty($booking_details_data['close_time']) && isset($courier_name) && ($courier_name == 'Startrack' || $courier_name == 'UPS')){
			$display_span_close_time = 'display:block';

		}
	?>
	<li id="li_collection_dt" style="<?php echo $display_span_collection_dt; ?>">Collection Date: <span class="pickup_form_orange" id="span_collection_dt" ><?php if(isset($booking_details_data['start_date']) && !empty($booking_details_data['start_date'])){echo date('jS F Y',strtotime($booking_details_data['start_date']));} ?></span></li>
	<li id="li_ready_time" style="<?php echo $display_span_time_ready;  ?>">Ready Time: <span class="pickup_form_orange" id="span_time_ready"><?php if(isset($booking_details_data['time_ready']) && !empty($booking_details_data['time_ready'])){echo $booking_details_data['time_ready'];}?></span></li>
	<?php
		//if(isset($booking_details_data['close_time']) && !empty($booking_details_data['close_time'])){
	?>
	<li id="li_close_time" style="<?php echo $display_span_close_time;  ?>">Close Time: <span class="pickup_form_orange" id="span_close_time"><?php if(isset($booking_details_data['close_time']) && !empty($booking_details_data['close_time'])){echo $booking_details_data['close_time'];}?></span></li>
	<?php
		//}
	?>
	<?php
	//}
	?>
	</ul>

</div><!-- //End Summary -->
