<?php
require_once(DIR_WS_MODEL . "InternationalZonesMaster.php");
$InternationalZoneMasterObj= InternationalZonesMaster::create();
$InternationalZoneData = new InternationalZonesData();
/*csrf validation*/
$csrf = new csrf();

$booking_details_data = $__Session->GetValue("booking_details");
$supplier_name = $booking_details_data["service_name"]."_supplier";
$pickupid = $booking_details_data["pickupid"];
$deliveryid = $booking_details_data["deliveryid"];
$distance = $booking_details_data["distance"];
$flag = $booking_details_data["flag"];
/*
echo "<pre>";
print_R($_SESSION);
echo "</pre>";
*/
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
}

?>

	<?php if($__Session->GetValue("booking_id")!="") { ?>
	<span class="bluefont">BOOKING REFERENCE </span><BR><span class="pickup_form_orange">	
	<?php echo generatebookigid($__Session->GetValue("booking_details"));?></span><br>
	<hr width="190px" color="#1576E0">
	<?php }
	
	
	?>
	<span class="gray_small_font">Provider Name: </span> <br>
	<span class="orange_small_font"><?php echo $$supplier_name;?></span><br/><br/>
	<span class="gray_small_font">Pick Up From: </span> <br>
	<span class="orange_small_font"><?php echo $pickupid; ?></span><br>
	<span class="orange_small_font"></span><br>
	<span class="gray_small_font">Deliver To: </span> <br>
	<span class="orange_small_font"><?php if($internationaName->country!=""){echo $internationaName->country;}else {echo $deliveryid;} ?></span><br>
	<?php	 
	if($distance!="" || $BookingData->distance_in_km != "")
	{
	?>
	<span class="gray_small_font">Distance in Km: </span> <br>
	<span class="orange_small_font"><?php if($BookingData->distance_in_km==""){ echo $distance;}else{ echo $BookingData->distance_in_km; } ?></span>	<br>
	<?php
	}
	?>
	<br>
	<?php  if(empty($BookingItemDetailsData))
	{
		header("Location:".SITE_URL);
	}
	$i=0;
		foreach ($BookingItemDetailsData as $BookingItemDetailsDataval)
		{
			if(isset($BookingItemDetailsDataval['quantity']) && $BookingItemDetailsDataval['quantity'] > 0){
			$shipping_type = $BookingItemDetailsDataval['item_type'];
			switch($shipping_type)
			{
					case "1":
						$shipping_item_name="Envelope";
					break;
					case "2":
						$shipping_item_name="Carton";
					break;
					case "3":
						$shipping_item_name="Parcel";
					break;
					case "4":
						$shipping_item_name="Document";
					break;
					case "5":
						$shipping_item_name="Non-Document";
					break;				
				}		?>
	<script type="text/javascript">
	animatedcollapse.addDiv('<?php echo "jason".$i; ?>', 'optional_attribute_string')
	//additional addDiv() call...
	//additional addDiv() call...
	animatedcollapse.init()
	</script>
<a href="javascript:animatedcollapse.toggle('<?php echo "jason".$i; ?>')"><span class="pickup_form_orange"><?php echo $shipping_item_name; ?></span><span class="orange_small_font">[Hide/show] </span></a> 
<div id="<?php echo "jason".$i; ?>" style="display:block">
	<span class="gray_small_font">QTY: </span> 
	<span class="orange_small_font">
	<?php 
	echo mb_chunk_split($BookingItemDetailsDataval['quantity'], 25, '<br />');?>
	</span><br>	
	<span class="gray_small_font">Item Weight : </span> <span class="orange_small_font">
	<?php echo mb_chunk_split($BookingItemDetailsDataval['item_weight']."&nbsp;kg",25,'<br/>');?></span><br>	
	<span class="gray_small_font">Total Weight : </span> <span class="orange_small_font"><?php echo mb_chunk_split($BookingItemDetailsDataval['quantity'] *$BookingItemDetailsDataval['item_weight']."&nbsp;kgs",25,'<br/>');?></span><br>					
	<?php
	$length=$BookingItemDetailsDataval['length'];
	$height=$BookingItemDetailsDataval['height'];
	$width=$BookingItemDetailsDataval['width'];
	if(($length=="0")&&($height=="0")&&($width=="0"))
	{?>		
	<?php }else{
	?>
	<span class="gray_small_font">Dimensions : </span> <span class="orange_small_font"><?php echo mb_chunk_split($BookingItemDetailsDataval['length'] ."x".$BookingItemDetailsDataval['width']."x".$BookingItemDetailsDataval['height']."cm",26,'<br/>');?></span><br>
	<span class="gray_small_font">Volumetic Weight : </span> <span class="orange_small_font"><?php echo mb_chunk_split($BookingItemDetailsDataval['vol_weight']."&nbsp;kgs",26,'<br/>');?></span><br>	<?php }?>
</div>
<?php
$i++;		}
		}
?>
<div><br>
				<?php if(FILE_DOMESTIC_SHIPPING!=$FileNameWithExt && FILE_PAYMENT!=$FileNameWithExt ) {
						 if(FILE_BOOKING_CONFIRMATION_AUSTRALIA == $FileNameWithExt) {
						 	?>
							<span><input name="edit" onclick="document.location='<?php  echo FILE_GET_QUOTE; ?>?step=edit'" type="button" class="btn btn-primary" value="&laquo; Edit" /></span><br>

							<?php 
						 }else{
						 		?>
									<span><input name="edit" onclick="document.location='<?php $response =$_SESSION['pagename'];
        if($response=="index")  {   echo SITE_URL.FILE_INDEX; } else { echo SITE_URL.FILE_GET_QUOTE; } ?>'" type="button" class="btn btn-primary" value="&laquo; Edit" /></span><br>
							<?php 
						 }
					}
if(FILE_DOMESTIC_SHIPPING==$FileNameWithExt)
{
?>	
<span><input name="edit" onclick="document.location='<?php  echo $filename; ?>?step=edit'" type="button" class="btn btn-primary" value="&laquo; Edit" /></span><br>
<?php 
}
?>
</div>
<?php 
$reqArray=array(FILE_DOMESTIC_SHIPPING,
				FILE_OVERNIGHT_RATES,
				FILE_SAMEDAY_RATES,
				FILE_INTERNATIONAL_GET_QUOTE,
				FILE_PAYMENT);

if($shipping_type !="4" && !in_array($FileNameWithExt,$reqArray))
{?>
<br>
<hr width="190px" color="#1576E0">
	<div id="tansit">
		<span class="gray_small_font">Transit Warranty :</span><span class="orange_small_font"><?php echo $tansient_warranty;?></span><br>
		<?php 
		 if($tansient_warranty=="yes")
		 {
		?>
		<span class="gray_small_font">Declare Value of Goods :</span><span class="orange_small_font">&nbsp;$<?php echo mb_chunk_split($values_of_goods,25,'<br/>');?></span><br>
		<span class="gray_small_font">Coverage Fee :</span><span class="orange_small_font">&nbsp;$<?php echo mb_chunk_split($coverage_rate,25,'<br/>');?></span><br>
		<?php
		 }
		?>
		<?php if($flag=="australia"){ ?>
		
		<span class="gray_small_font">Authority to Leave :</span><span class="orange_small_font"><?php echo  mb_chunk_split($authority_to_leave,25,'<br/>');?></span><br>
		<?php 
		}
		?>
		<?php
		if($authority_to_leave=="yes")
		{
		?>
		<span class="gray_small_font">Where to leave the Shipment :</span><br><span class="orange_small_font"><?php echo mb_chunk_split($where_to_leave_shipment, 25, '<br/>');?></span><br>
		<?php
		}
		?>
	</div>
			<div align="left">
				<br>
				<?php
				//echo FILE_BOOKING_CONFIRMATION_AUSTRALIA;
				 if(FILE_BOOKING_CONFIRMATION_AUSTRALIA == $FileNameWithExt) {
				 	?> <input name="edit" onclick="document.location='<?php  echo FILE_DOMESTIC_SHIPPING; ?>?step=edit'" type="button" class="btn btn-primary" value="&laquo; Edit" /> <?php
				 }else {
				 	?> <input name="edit" onclick="document.location='<?php  echo FILE_DOMESTIC_SHIPPING; ?>'" type="button" class="btn btn-primary" value="&laquo; Edit" /> <?php
				 }
				?>
					
				<br>
			</div>
			
			<?php } ?>
			
<?php 
		 	$session_data = json_decode($_SESSION['Thesessiondata']['_sess_login_userdetails'],true);
			$userid = $session_data['user_id'];
			if(FILE_BOOKING_CONFIRMATION_AUSTRALIA==$FileNameWithExt || FILE_PAYMENT==$FileNameWithExt)
			{?>
				<br><hr width="190px" color="#1576E0">
				<div>
				
				</br />		
				</div>
			<?php }
		 ?>
        


