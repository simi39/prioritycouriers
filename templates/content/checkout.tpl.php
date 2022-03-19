<?php
session_start();

if(valid_output($_SESSION['original_weight'])>=valid_output($_SESSION['total_vol_weight']))
{
	$weight=valid_output($_SESSION['original_weight']);
}
else
{
	$weight=valid_output($_SESSION['total_vol_weight']);
}
/*
echo "<pre>";
print_r();
echo "</pre>";
*/
?>

<!--=== Breadcrumbs ===-->
<div class="breadcrumbs margin-bottom-60">
	<div class="container">
        <h1 class="pull-left"><?php echo SHIPMENT_DETAILS; ?></h1>
        <ul class="pull-right breadcrumb">
            <li><a href="index.php"><?php echo COMMON_HOME; ?></a> <span class="divider">/</span></li>
            <li class="active"><?php echo SHIPMENT_DETAILS; ?></li>
        </ul>
    </div><!--/container-->
</div><!--/breadcrumbs-->
<!--=== End Breadcrumbs ===-->
<?php

//echo $stringItems;
?>
<!--=== Content Part ===-->
<div class="container bg-lighter">
	<div class="row-fluid">
		<div class="containerBlock">
			<form name="checkout" id="checkout" class="span12" method="POST" autocomplete='off' action="" >
				<!--==	Details header	==-->
				<div class="span12 margin-bottom-20 margin-left_0">
					<blockquote>
						<p><?php echo SHIPMENT_DETAILS_ALMOST; ?></p>
					</blockquote>
				</div><!--==/End Details header	==-->

					<?php
					 //echo "<pre>";
					 //print_r($Users);
					 //print_r($BookingDetailsData);
					 //print_r($BookingDetailsDataVal);

					//echo "</pre>";  ?>

				<!--==	First Column	==-->
				<div class="span4 margin-left_0">
					<!--== Collection	==-->
						<div class="span12 margin-bottom-20 margin-left-span">
							<h3 class="my_green"><?php echo COLLECTION; ?></h3>
							<?php
									if(isset($BookingDatashow->servicepagename) && $BookingDatashow->servicepagename == 'sameday'){
											$pagename =FILE_METRO_RATES;
											$dateMiddleStr = '&nbsp;at&nbsp;';
											$betweenDateStr = '';
									}elseif(isset($BookingDatashow->servicepagename) && $BookingDatashow->servicepagename == 'overnight'){
											$pagename =FILE_INTERSTATE_RATES;
											$dateMiddleStr = ' ';
											$betweenDateStr = '&nbsp;between&nbsp;';
									}else{
											$pagename =FILE_INTERNATIONAL;
											$dateMiddleStr = '&nbsp;at&nbsp;';
											$betweenDateStr = '';
									}

									$close_time = '';
									if(isset($BookingDatashow->close_time) && !empty($BookingDatashow->close_time)){
										$close_time = $BookingDatashow->close_time;
									}
							?>
						</div>
						<div class="span8 margin-bottom-20">
							<label class="my_orange control-label"><?php echo DATE_TIME; ?></label>
							<div class="control"><?php echo date('l jS F Y',strtotime($BookingDatashow->date_ready)).$dateMiddleStr.$BookingDatashow->time_ready.$betweenDateStr.$close_time;?></div>
						</div>
						<div class="span4 margin-left_0">
							<input type="button" onClick="document.location='<?php echo show_page_link($pagename)."?Action=edit";?>'"  class="btn pull-right" name="Edit" id="Edit" value="Edit" />
						</div>

							<?php
								if(isset($BookingDatashow->service_name) && $BookingDatashow->service_name=="international"){
									if(isset($BookingItemDetailsData[0]['item_type']) && $BookingItemDetailsData[0]['item_type'] == '5'){
										$international_item_type = 'Non-Documents';
									}else{
										$international_item_type = 'Documents';
									}

							?>
								<div class="span8 margin-bottom-20">
								<label class="my_orange control-label"><?php echo SERVICE_NAME; ?></label>

								<div class="control"><?php echo ucfirst(valid_output($BookingDatashow->service_name))." ".$international_item_type." "; ?></div>
								</div><!--== End Service Type	==-->
								<div class="span4 margin-left_0">
								<input type="button" onClick="editBooking();"  class="btn pull-right" name="Edit" value="Edit" />
								</div>
							<?php
								}else{
							?>
								<div class="span12 margin-bottom-30">
								<label class="my_orange control-label"><?php echo SERVICE_NAME; ?></label>

								<div class="control"><?php echo ucfirst(valid_output($BookingDatashow->service_name)); ?></div>
								</div><!--== End Service Type	==-->
							<?php
								}
							?>


					<!--== Addresses ==-->
					<div class="span12">
						<div class="span10 margin-bottom-20">
							<!--== Addresses From	==-->
							<label class="my_orange control-label"><?php echo COMMON_SENDER; ?></label>
							<div class="my_word_brake">
								<h5><?php
								echo ucfirst(valid_output($BookingDatashow->sender_first_name))." ".$BookingDatashow->sender_surname."</h5>";
								if(isset($BookingDatashow->sender_company_name) && !empty($BookingDatashow->sender_company_name)){
										echo valid_output($BookingDatashow->sender_company_name)."</br>";
								}
								if(isset($BookingDatashow->sender_address_1) && !empty($BookingDatashow->sender_address_1)){
										echo valid_output($BookingDatashow->sender_address_1)."</br>";
								}
								if(isset($BookingDatashow->sender_address_2) && !empty($BookingDatashow->sender_address_2)){
										echo valid_output($BookingDatashow->sender_address_2)."</br>";
								}
								if(isset($BookingDatashow->sender_address_3) && !empty($BookingDatashow->sender_address_3)){
										echo valid_output($BookingDatashow->sender_address_3)."</br>";
								}
								echo valid_output($BookingDatashow->sender_suburb)." ".valid_output($BookingDatashow->sender_state)." ".valid_output($BookingDatashow->sender_postcode)."</br>";
				/*				if(isset($BookingDatashow->flag) && ($BookingDatashow->flag=="australia")) { */
									echo "Australia</br>";
				/*				}*/
								echo valid_output($BookingDatashow->sender_email)."</br>";
								if(isset($BookingDatashow->sender_contact_no) && !empty($BookingDatashow->sender_contact_no)){
										echo valid_output($BookingDatashow->sender_area_code)." ".valid_output($BookingDatashow->sender_contact_no)."</br>";
								}
								if(isset($BookingDatashow->sender_mobile_no) && !empty($BookingDatashow->sender_mobile_no)){
										echo valid_output($BookingDatashow->sender_mb_area_code)." ".valid_output($BookingDatashow->sender_mobile_no)."</br>";
								}
								?>
							</div>
						</div><!--==/End Addresses From	==-->
						<div class="span2 margin-left_0">
							<input type="button" onClick="document.location='<?php echo show_page_link(FILE_ADDRESSES)."?Action=edit";?>'"  class="btn pull-right" name="Edit" value="Edit" />
						</div>

							<!--<div class="span6">
							<label class="muted"><?php echo COMMON_SENDER_SURNAME; ?></label>
							<h5 class="my_word_brake"><?php echo valid_output($BookingDatashow->sender_surname); ?></h5>
							</div>
							<div class="span12 margin-left_0" style="display:'<?php //if (!empty(valid_output($BookingDatashow->sender_company_name))) {echo "block";}else{echo "none";}?>';">
							<label class="muted"><?php echo COMMON_SENDER_COMPANY; ?></label>
							<h5><?php echo valid_output($BookingDatashow->sender_company_name); ?></h5>
							</div>
							<div class="span12 margin-left_0">
							<label class="muted"><?php echo COMMON_SENDER_ADDRESS_HEADER; ?></label>
							<h5><?php echo valid_output($BookingDatashow->sender_address_1); ?></h5>
							</div>
							<div class="span12 margin-left_0">
							<h5><?php echo valid_output($BookingDatashow->sender_address_2); ?></h5>
							</div>
				<?php
				//if($BookingDatashow->service_name=="international")
				//{
				?>
				<div class="span6 margin-left_0">
							<label class="muted"><?php echo COMMON_SENDER_ADDRESS_COUNTRY; ?></label>
							<h5><?php echo "Australia"; ?></h5>
							</div>
				<?php
				//}
				?>
							<div class="span6 margin-left_0">
							<label class="muted"><?php echo COMMON_SENDER_ADDRESS_SUBURB; ?></label>
							<h5><?php echo valid_output($BookingDatashow->sender_suburb); ?></h5>
							</div>
							<div class="span6 margin-left_0">
							<label class="muted"><?php echo COMMON_SENDER_STATE; ?></label>
							<h5><?php echo valid_output($BookingDatashow->sender_state); ?></h5>
							</div>
							<div class="span6 margin-left_0">
							<label class="muted"><?php echo COMMON_SENDER_ADDRESS_POST_CODE; ?></label>
							<h5><?php echo valid_output($BookingDatashow->sender_postcode); ?></h5>
							</div>
							<div class="span12 margin-left_0">
							<label class="muted"><?php echo COMMON_SENDER_EMAIL; ?></label>
							<h5><?php echo valid_output($BookingDatashow->sender_email); ?></h5>
							</div>
							<div class="span12 margin-left_0">
							<label class="muted"><?php echo COMMON_SENDER_CONTACT_NO; ?></label>
							<h5><?php echo valid_output($BookingDatashow->sender_area_code)." ".valid_output($BookingDatashow->sender_contact_no); ?></h5>
							</div>
				<?php //if($BookingDatashow->sender_mobile_no){ ?>
							<div class="span12 margin-left_0">
							<label class="muted"><?php echo COMMON_SENDER_MOBILE_NO; ?></label>
							<h5><?php echo valid_output($BookingDatashow->sender_mb_area_code)." ".valid_output($BookingDatashow->sender_mobile_no); ?></h5>
							</div>
				<?php //} ?>-->

						<div class="span12 margin-left_0">
							<!--== Addresses To	==-->
							<label class="my_orange control-label"><?php echo COMMON_RECEIVER; ?></label>
							<div class="my_word_brake">
								<h5><?php
								echo ucfirst(valid_output($BookingDatashow->reciever_firstname))." ".valid_output($BookingDatashow->reciever_surname)."</h5>";
								if(isset($BookingDatashow->reciever_company_name) && !empty($BookingDatashow->reciever_company_name)){
									echo valid_output($BookingDatashow->reciever_company_name)."</br>";
								}
								if(isset($BookingDatashow->reciever_address_1) && !empty($BookingDatashow->reciever_address_1)){
										echo valid_output($BookingDatashow->reciever_address_1)."</br>";
								}
								if(isset($BookingDatashow->reciever_address_2) && !empty($BookingDatashow->reciever_address_2)){
										echo valid_output($BookingDatashow->reciever_address_2)."</br>";
								}
								if(isset($BookingDatashow->reciever_address_3) && !empty($BookingDatashow->reciever_address_3)){
										echo valid_output($BookingDatashow->reciever_address_3)."</br>";
								}

								if($BookingDatashow->service_name=="international")
								{
										if(is_numeric($BookingDatashow->deliveryid)){echo valid_output($countries_name)."</br>";}
								}
								echo $BookingDatashow->reciever_suburb." ".valid_output($BookingDatashow->reciever_state)." ".valid_output($BookingDatashow->reciever_postcode)."</br>";
								if(isset($BookingDatashow->flag) && ($BookingDatashow->flag=="australia")) {
									echo "Australia</br>";
								}
								echo valid_output($BookingDatashow->reciever_area_code)." ".valid_output($BookingDatashow->reciever_contact_no)."</br>";
								if($BookingDatashow->reciever_mobile_no){
										echo valid_output($BookingDatashow->reciever_mb_area_code)." ".valid_output($BookingDatashow->reciever_mobile_no);
								}
								?>
						</div>
					</div><!--==/End Addresses To	==-->

						<!--<div class="span6">
						<label class="muted"><?php echo COMMON_RECEIVER_SURNAME; ?></label>
						<h5 class="my_word_brake"><?php echo valid_output($BookingDatashow->reciever_surname); ?></h5>
						</div>
						<div class="span12 margin-left_0" style="display:'<?php if (!empty(valid_output($BookingDatashow->reciever_company_name))) {echo "block";}else{echo "none";}?>';">
						<label class="muted"><?php echo COMMON_RECEIVER_COMPANY_NAME; ?></label>
						<h5><?php echo valid_output($BookingDatashow->reciever_company_name); ?></h5>
						</div>
						<div class="span12 margin-left_0">
						<label class="muted"><?php echo COMMON_RECEIVER_ADDRESS; ?></label>
						<h5><?php echo ($BookingDatashow->reciever_address_1); ?></h5>
						</div>
						<div class="span12 margin-left_0">
						<h5><?php echo ($BookingDatashow->reciever_address_2); ?></h5>
						</div>
			<?php
			if($BookingDatashow->service_name=="international")
			{
			?>
			<div class="span6 margin-left_0">
						<label class="muted"><?php echo COMMON_RECEIVER_COUNTRY; ?></label>
						<h5><?php if(is_numeric($BookingDatashow->deliveryid)){echo valid_output($countries_name);} ?></h5>
						</div>
			<?php
			}
			?>
						<div class="span6 margin-left_0">
						<label class="muted"><?php echo COMMON_RECEIVER_SUBURB; ?></label>
						<h5><?php echo valid_output($BookingDatashow->reciever_suburb); ?></h5>
						</div>
			<div class="span6 margin-left_0">
						<label class="muted"><?php echo COMMON_RECEIVER_STATE; ?></label>
						<h5><?php echo valid_output($BookingDatashow->reciever_state); ?></h5>
						</div>
						<div class="span6 margin-left_0">
						<label class="muted"><?php echo COMMON_RECEIVER_POST_CODE; ?></label>
						<h5><?php echo valid_output($BookingDatashow->reciever_postcode); ?></h5>
						</div>
						<div class="span12 margin-left_0">
						<label class="muted"><?php echo COMMON_RECEIVER_EMAIL; ?></label>
						<h5><?php echo valid_output($BookingDatashow->reciever_email); ?></h5>
						</div>
						<div class="span12 margin-left_0">
						<label class="muted"><?php echo COMMON_SENDER_CONTACT_NO; ?></label>
						<h5><?php echo valid_output($BookingDatashow->reciever_area_code)." ".valid_output($BookingDatashow->reciever_contact_no); ?></h5>
						</div>
			<?php if($BookingDatashow->reciever_mobile_no){ ?>
						<div class="span12 margin-left_0">
						<label class="muted"><?php echo COMMON_RECEIVER_ALTERNATE_NUMBER; ?></label>
						<h5><?php echo valid_output($BookingDatashow->reciever_mb_area_code)." ".valid_output($BookingDatashow->reciever_mobile_no); ?></h5>
						</div>
			<?php } ?>-->
					</div><!--== End Addresses ==-->
				</div><!--==	End First Column	==-->

				<!--==	Second column	==-->
				<div class="span4">
					<!--==	Description of Goods	==-->
					<div class="span12 margin-bottom-20 margin-left-span">
						<h3 class="my_green"><?php echo DESCRIPTION_OF_GOODS; ?></h3>
					</div>
					<?php if($BookingDatashow->description_of_goods!=""){ ?>
						<div class="span10 margin-bottom-10">
								<label class="my_orange control-label"><?php echo DESCRIPTION_OF_GOODS; ?></label>
								<div class="control"><?php echo ucfirst(valid_output($BookingDatashow->description_of_goods)); ?></div>
						</div>
						<div class="span2 margin-left_0">
							<input type="button" onClick="document.location='<?php echo show_page_link(FILE_ADDITIONAL_DETAILS)."?Action=edit";?>'"  class="btn pull-right" name="Edit" value="Edit" />
						</div>
					<?php } ?><!--==/End	Description of Goods	==-->

						<?php // ********* Transit Warranty temporarly disbaled ***********//
							if (isset($_SERVER['HTTP_REFERER']) && ($_SERVER['HTTP_REFERER']==SITE_URL.'zombie.php')) {?>
						<?php if($BookingDatashow->values_of_goods!=""){ ?>
							<div class="headline">
								<h3><?php echo GOODS_VALUE; ?></h3>
							</div>
							<p>$<?php echo number_format($BookingDatashow->values_of_goods,2, '.', ''); ?></p>
						<?php } ?>
						<?php if($BookingDatashow->tansient_warranty=='yes'){ ?>
							<p><?php echo ucfirst(valid_output($BookingDatashow->tansient_warranty)); } else { echo "No";} ?></p>
						<?php } // ************* Transit Warranty temporarly disbaled end **************// ?>


					<!--==	Pieces and Weight	==-->
					<div class="span10 margin-bottom-20">
						<label class="my_orange control-label"><?php echo PIECES_WEIGHT; ?></label>
						<div class="control"><?php echo filter_var($BookingDatashow->total_qty,FILTER_VALIDATE_FLOAT); ?> &#64; <?php echo filter_var($BookingDatashow->total_weight,FILTER_VALIDATE_FLOAT); ?> kg</div>
					</div>
					<div class="span2 margin-left_0">
						<input type="button" onClick="editBooking();"  class="btn pull-right" name="Edit" value="Edit" />
					</div>
					<div class="span12 margin-bottom-20">
						<?php /* if(valid_output($_SESSION['original_weight'])>=valid_output($_SESSION['total_vol_weight'])) {
							$weight=valid_output($_SESSION['original_weight']);
						} else {
							$weight=valid_output($_SESSION['total_vol_weight']);
						} */ ?>
						<?php foreach ($BookingItemDetailsData as $key => $val) {
							echo $val['quantity'] ." &#64; ". $val['item_weight'] ."kg ". $val['length'] . "cm x ". $val['width'] ."cm x ". $val['height'] ."cm <br>";
						} ?>
						<input type="hidden" id="temp_value" name="temp_value" value="1">
					</div><!--==	End Pieces and Weight	==-->

					<?php if($BookingDatashow->service_name!="international") { ?>
						<?php if(!empty($BookingDatashow->authority_to_leave) && $BookingDatashow->authority_to_leave == 'on'){ ?>
							<!--==	Authotity to Leave	==-->
							<div class="span10 margin-bottom-20">
								<label class="my_orange control-label"><?php echo AUTHORITY_TO_LEAVE; ?></label>
								<?php if(empty($BookingDatashow->where_to_leave_shipment)){ ?>
									<div class="control"><?php echo PLACEMENT; ?> <?php echo PLACEMENT_UNSPECIFIED; ?></div>
								<?php } else { ?>
									<div class="control"><?php echo PLACEMENT; ?> <?php echo ucfirst(valid_output($BookingDatashow->where_to_leave_shipment)); ?></div>
								<?php } ?>
							</div>
							<div class="span2 margin-left_0">
								<input type="button" onClick="document.location='<?php echo show_page_link(FILE_ADDITIONAL_DETAILS)."?Action=edit";?>'"  class="btn pull-right" name="Edit" value="Edit" />
							</div>
						<?php } ?>	<!--==	End Authotity to Leave	==-->
					<?php } ?>

					<!--==	International Vars ==-->
					<?php if($BookingDatashow->service_name=="international") {
						if(isset($BookingDatashow->values_of_goods) && !empty($BookingDatashow->values_of_goods)) { ?>
							<div class="span10 margin-bottom-10">
									<label class="my_orange control-label"><?php echo GOODS_VALUE; ?></label>
									<div class="control"><?php echo valid_output($BookingDatashow->currency_codes)."&nbsp;". number_format($BookingDatashow->values_of_goods,2, '.', '')?></div>
							</div>
							<div class="span2 margin-left_0">
								<input type="button" onClick="document.location='<?php echo show_page_link(FILE_ADDITIONAL_DETAILS)."?Action=edit";?>'"  class="btn pull-right" name="Edit" value="Edit" />
							</div>
						<?php }
						if(isset($BookingDatashow->country_origin) && !empty($BookingDatashow->country_origin)) { ?>
							<div class="span10 margin-bottom-10">
									<label class="my_orange control-label"><?php echo COUNTRY_ORIGIN; ?></label>
									<div class="control"><?php if(is_numeric($BookingDatashow->country_origin)){echo valid_output($origin_countries_name);}?></div>
							</div>
						<?php }
						if(isset($BookingDatashow->export_reason) && !empty($BookingDatashow->export_reason)) { ?>
							<!--== Export reson	==-->
							<div class="span12 margin-bottom-10">
								<label class="my_orange control-label"><?php echo EXPORT_REASON; ?></label>
								<div class="control">
									<?php switch (valid_output($BookingDatashow->export_reason)) {
										case 1:
											echo EXPORT_REASON_1;
											break;
										case 2:
											echo EXPORT_REASON_2;
											break;
										case 3:
											echo EXPORT_REASON_3;
											break;
										case 4:
											echo EXPORT_REASON_4;
											break;
										case 5:
											echo EXPORT_REASON_5;
											break;
										case 6:
											echo EXPORT_REASON_6;
											break;
										case 7:
											echo EXPORT_REASON_7;
											break;
										case 8:
											echo EXPORT_REASON_8;
											break;
									}?>
								</div>
							</div><!--==/End  Export reson	==-->
						<?php }
					 	if(isset($BookingItemDetailsData[0]['item_type']) && $BookingItemDetailsData[0]['item_type']=='5') { ?>
						 <div class="span12 margin-bottom-10">
							 <label class="my_orange control-label"><?php echo COMMERCIAL_INVOICE; ?></label>
							 <?php if(isset($BookingDatashow->commercial_invoice_provider) && $BookingDatashow->commercial_invoice_provider==1) { ?>
								 <div class="control"><?php echo COMMERCIAL_INVOCIE_PROVIDER_1; ?></div>
							 <?php } elseif(isset($BookingDatashow->commercial_invoice_provider) && $BookingDatashow->commercial_invoice_provider==2) {?>
								 <div class="control"><?php echo COMMERCIAL_INVOCIE_PROVIDER_2; ?></div>
							 <?php } ?>
						 </div>
						<?php } ?><!--==	End Commercial Invoice for none documents	==-->
				 	<?php }?>
				</div><!--==	/EndSecond column	==-->
				<!--==	Third column	==-->
				<div class="span4">
					<!--==	Fees and Charges	==-->
					<div class="span12 margin-bottom-20">
						<h3 class="my_green"><?php echo FEE_HEADER; ?></h3>
					</div>
					<div class="span12 margin-bottom-20 margin-left_0">
						<?php if($BookingDatashow->delivery_fee != '0' && $BookingDatashow->delivery_fee != ''){ ?>
							<!--==	Freight Charge	==-->
							<p>
								<span><?php if($BookingDatashow->service_name!="international"){echo BASE_DELIVERY_FEE;}else{ echo INTERNATIONAL_DELIVERY_FEE;} ?> </span><span class="pull-right" id="base_delivery_fee">$<?php echo number_format($BookingDatashow->delivery_fee,2, '.', ''); ?></span>
								<input type="hidden" id="old_base_delivery_fee" value="<?php echo number_format($final_delivery_fee,2, '.', ''); ?>" name="old_base_delivery_fee" />
							</p><!--==	End Freight Charge	==-->
						<?php } ?>
						<?php if($BookingDatashow->fuel_surcharge != '0' && $BookingDatashow->fuel_surcharge !=''){ ?>
							<!--==	Fuel Surcharge	==-->
							<p>
								<span><?php echo FUEL_SURGARGE; ?> </span><span class="pull-right" id="fuel_surcharge">$<?php echo number_format($BookingDatashow->fuel_surcharge,2, '.', ''); ?></span>
								<input type="hidden" id="old_fuel_fee" value="<?php echo number_format($final_fuel_fee,2, '.', ''); ?>" name="old_fuel_fee" />
							</p>	<!--==	End Fuel Surcharge	==-->
						<?php } ?>
						<?php if($BookingDatashow->service_surcharge != '0' && $BookingDatashow->service_surcharge !=''){ ?>
							<!--==	Residential Surcharge	==-->
							<p>
								<span><?php echo RESIDENTIAL_SURCHARGE; ?> </span><span class="pull-right" id="service_surcharge">$<?php echo number_format($BookingDatashow->service_surcharge,2, '.', ''); ?></span>
							</p>	<!--==	End Residential Surcharge	==-->
						<?php } ?>
						<?php if($BookingDatashow->service_name !="international") {
							$gst_msg = "(Including GST)";
							if($BookingDatashow->total_gst_delivery != '0' && $BookingDatashow->total_gst_delivery != '') {  ?>
								<!--==	GST	==-->
								<p>
									<span><?php echo CHECKOUT_GST; ?> </span><span class="pull-right" id="total_gst_delivery">$<?php echo number_format($BookingDatashow->total_gst_delivery,2, '.', ''); ?></span><?php } ?><br  />
									<input type="hidden" name="old_total_gst_delivery" id="old_total_gst_delivery" value="<?php echo number_format($total_gst_delivery,2, '.', '');  ?>" />
								</p><!--==	End GST	==-->
						<?php } ?>
							<?php if($BookingDatashow->total_delivery_fee != '0' && $BookingDatashow->total_delivery_fee != ''){ ?>
								<!--==	Total Delivery Fee	==-->
								<p>
									<span><strong><?php echo TOTAL_DELIVERY_FEE; ?></strong> </span><strong><span class="pull-right" id="total_delivery_fee">$<?php echo
							number_format($BookingDatashow->total_delivery_fee,2, '.', ''); ?></span></strong>
						</p> <!--==	End Total Delivery Fee	==-->
						<?php } ?>
						<input type="hidden" name="old_total_delivery_fee" id="old_total_delivery_fee" value="<?php echo number_format($total_delivery_charge,2, '.', '');  ?>" />
					</div>
					
					<!-- Checkout -->
					<div class="span12 margin-bottom-20 margin-left_0">
						<h3 class="my_green"><?php echo COMMON_CHECKOUT; ?></h3>
					</div>

					<?php if($total_due!="" && $total_due!=0) { ?>
						<div class="span12 margin-left_0 margin-bottom-40">
							<p>
								<span class="my_green pull-left"><h3 class="my_green"><strong><?php echo TOTAL_AMOUNT_PAYABLE; ?></strong></h3></span><span class="my_bigger_font pull-right my_green" id="total_due_amt"><h3 class="my_green"><strong>$<?php echo number_format($total_due, 2, '.', '');  ?></strong></h3></span>
								<input type="hidden" name="old_total_due_amt" id="old_total_due_amt" value="<?php echo number_format($total_due,2, '.', '');  ?>" />
							</p>
						</div>
					<?php } ?>
					<div class="span12 margin-left_0">
						<!-- Paypal Payment Hidden Values -->
					 <input type='hidden' name='PAYMENTREQUEST_0_AMT' id="payment_amt" value='<?php if(isset($total_due) && $total_due!=0){echo filter_var($total_due,FILTER_VALIDATE_FLOAT);}  ?>'>

					 <input type='hidden' name='ptoken' value='<?php echo $ptoken;  ?>' id='ptoken'>
						<!-- /End Paypal Payment Hidden Values -->
						<div class="form-group">
							<button type="submit" class="paypal_checkout pull-right margin-bottom-30" id="paypal" name="paypal"></button>
							<!--  ANZ payment gateway method--->
							<!--<input type="hidden" name="Title" value="PHP VPC 3-Party">
							<input type="hidden" name="virtualPaymentClientURL" value="https://migs.mastercard.com.au/vpcpay">-->
							<input type="hidden" name="vpc_Version" value="1" size="20" maxlength="8">
							<input type="hidden" name="vpc_Command" value="pay" size="20" maxlength="16">
							<input type="hidden" name="vpc_AccessCode" value="097F9AD7" size="20" maxlength="8">
							<input type="hidden" name="vpc_MerchTxnRef" value="<?php if(isset($BookingDatashow->booking_id) && !empty($BookingDatashow->booking_id)){echo $BookingDatashow->booking_id;} ?>" size="20" maxlength="40">

							<input type="hidden" name="vpc_Merchant" value="TESTANZPRIORIT" size="20" maxlength="16">
							<input type="hidden" name="vpc_OrderInfo" value="abc" size="20" maxlength="34">
							<input type="hidden" name="vpc_Amount" id="vpc_Amount" value="100<?php //if(isset($total_due) && $total_due!=0){echo filter_var(($total_due*100),FILTER_VALIDATE_INT);}  ?>" size="20" maxlength="10">
							<input type="hidden" name="vpc_Locale" value="en_AU" size="20" maxlength="5">
							<input type="hidden" name="vpc_Currency" value="AUD" size="20" maxlength="5">
							<input type="hidden" name="vpc_ReturnURL" size="63" value="<?php echo SITE_URL."checkout.php";?>" maxlength="250">
							<!--  ANZ payment gateway method--->
							<input type="hidden" name="status" value="paypal"/>
							<button type="submit" class="cc_checkout pull-right" id="paynow" name="paynow"></button>
							<!--End of ANZ payment -->
					 	</div>
					</div>
						<!--<input type="text" name="error" id="error" value="" />-->
				</div><!--==	End Third column	==-->

				<!-- Modal with Data loss warning -->
				<div class="modal hide fade small_rates" id="dataLossEff" data-backdrop="static" data-keyboard="false">
					<div class="modal-header">
						<h3><?php echo CHECKOUT_DATA_LOSS_HEADER; ?></h3>
					</div>
					<div class="modal-body my_bigger_font justy">
						<?php echo CHECKOUT_DATA_LOSS; ?>
						<input type="hidden" id="databtn" value="false">
					</div>
					<div class="modal-footer">
						<a href="#" class="btn-u pull-left button_modal_fl" data-dismiss="modal" id="closemodal">No</a>
						<a href="#" class="btn-u pull-right button_modal_fl"  id="dataLoseClose">Yes</a></div>
				</div> <!--	/End Modal with Data loss warning -->

				<?php // ********* Coupon is temporarly disbaled ***********//
				if (isset($_SERVER['HTTP_REFERER']) && ($_SERVER['HTTP_REFERER']==SITE_URL.'zombie.php')) {?>
        <!--==	Coupon	==-->
        <div class="span12 margin-left_0 promo-over">
                <div class="headline">
                <h3><?php echo COUPON_CODE_HEAD; ?></h3>
                </div>
                <div class="row-fluid margin-bottom-10">
                <div class="span6">
                <blockquote>
                    <p><?php echo ENTER_COUPON_CODE; ?></p>
               	</blockquote>
                </div>
                <div class="span6 margin-left_0">
                    	<div class="form-inline ">
                    	<span class="pull-right form-group control-group">
                        <label class="control-label"></label>
						<?php
							$readonly ="";
							$button = "Redeem";
							$style ="none";
							if(isset($_SESSION['couponCode']) && $_SESSION['couponCode']!=''){
								$readonly ="readonly";
								$button = "Reset";
								$style ="block";
							}elseif(isset($_POST['couponCode']) && $_POST['couponCode']!='')
							{
								$readonly ="readonly";
								$button = "Reset";
								$style ="block";
							}
							/*
							echo "<pre>";
							print_R($_SESSION);
							echo "</pre>";*/
						?>
						<input type="text" <?php echo $readonly; ?> name="coupon_code" id="coupon_code" value="<?php if(isset($_SESSION['couponCode']) && $_SESSION['couponCode']!=''){ echo $_SESSION['couponCode'];}else{echo valid_output($_POST['coupon_code']);} ?>" class="search-query form-control" placeholder="Promo Code" onkeyup="javascript:enableRedeem('redeem');">
							<button type="button" value="<?php echo $button; ?>" name="redeem" id="redeem" class="btn-u" onclick="javascript: get_coupon_code_status('<?php if(defined('SES_USER_ID')){ echo SES_USER_ID;} ?>');" disabled="disabled"><?php echo $button; ?></button><br />
							<span class="help-block alert-error" id="coupon_code_message"></span>
							<?php if(isset($err['PICKUPNOTEXISTS'])) { ?>
							<!-- PHP Validation	-->
                        	<div class="alert alert-error show" id="couponError_css">
                           	 <div class="requiredInformation" id="couponcodeError"><?php  echo $err['PICKUPNOTEXISTS'];?></div>
                        	</div>
							<!--	End PHP Validation	-->
							<?php } ?>
						</span>
                        </div>
                    </div>
                    </div>
                    <div class="span6">
						<div class="form-inline" id="discountDisplay" style="display:<?php echo $style; ?>">
							<span class="form-group control-group">
								<span class="muted"><?php echo DISCOUNT_AMOUNT; ?></span>&nbsp;
								<span class="pull-right">$<span id="discount_amount"><?php if(isset($_SESSION['discountAmt']) && $_SESSION['discountAmt']!=0){ echo $_SESSION['discountAmt']; }else{ echo '0.00';} ?></span></span><br />
							</span>
						</div>
            		</div>
                    <div class="span6 margin-left_0"></div>
        </div><!--==/End Coupon	==-->
			<?php } // ************* Coupon temporarly disbaled end **************// ?>
			<div class="span12 margin-left_0 pull-right">
				<input type="button" onClick="cancelBooking();"  class="btn-u btn-u-large pull-right" name="Cancel" value="Cancel" />
			</div>
		</form>

		<!--<form action="<?php echo SITE_URL.'VPC_PHP_3P_DO.php';?>" method="post" id="anz">

		</form>-->

        <div class="modal hide fade small_rates" id="anzacPaymentCancel" data-backdrop="static" data-keyboard="false">
			<div class="modal-header">
			<h3><?php echo CHECKOUT_CANCELLATION_HEAD; ?></h3>
			</div>
			<div class="modal-body justy">
			<?php
			if((isset($_GET['mode']) && $_GET['mode'] == 'cancel') || isset($_GET["vpc_TxnResponseCode"]) && $_GET["vpc_TxnResponseCode"]=="C"){
			?>
			<span class="my_bigger_font"><?php echo MANUAL_CANCELLATION_MESSAGE; ?></span>
			<?php
			}elseif($payment_cancelled_msg){
			?>
			<span class="my_bigger_font"><?php echo $payment_cancelled_msg; ?></span>
			<?php }else{ ?>
			<span class="my_bigger_font"><?php echo CANCELLATION_MESSAGE; ?></span>
			<?php } ?>
			<?php if(isset($response["L_LONGMESSAGE0"]) && $_POST['status'] != 'paynow' && (isset($_GET["token"]) &&  $_GET["token"]!= '') && $response['ACK'] != 'Success'){ ?>
			<span class="my_bigger_font"><?php echo $response['L_SHORTMESSAGE0']."</br>"."Error Code:".$response['L_ERRORCODE0']; ?></span>
			<?php
			}
			?>
			</div>

			<div class="modal-footer">
				<div class="button_row">
			        <div class="btn-u pull-right button_modal_fl" id="anzacCloseModal">Close</div>
				</div>
			</div>
		</div>
		<div class="modal hide fade small_rates" id="timeCancel" data-backdrop="static" data-keyboard="false">
			<div class="modal-header">
			<h3><?php echo CHECKOUT_CUT_OFF_HEAD; ?></h3>
			</div>
			<div class="modal-body">
			<span class="my_bigger_font"><?php echo CHECKOUT_CUT_OFF_MESSAGE; ?></span>
			</div>
			<div class="modal-footer"><a href="#" class="btn-u btn-u-primary"  id="cutoffclosemodal">Close</a></div>
		</div>
		<!--=== Start Address Error ===-->
		<div class="modal hide fade small_rates" id="AddressError" data-backdrop="static" data-keyboard="false">
		<div class="modal-header">
		<h3><?php echo ADDRESSES_WRONG_HEAD; ?></h3>
		</div>
		<div class="modal-body justy">
		<div id="address_display"></div>
		<?php
		if((isset($addresserror)) && $addresserror != ''){
		$removeStr =  substr($addresserror,88,13);
		$displayStr = str_replace($removeStr, '', $addresserror);
		?>
		<span class="my_bigger_font"><?php echo $displayStr; ?></span>
		<?php
		}
		?>
		</div>
		<div class="modal-footer"><a href="#" class="btn-u btn-u-primary"  id="addressClsModal">Close</a></div>
		</div>
		<!--=== End Address Error ===-->
<!-- Start Exception Error -->
<!-- End Exception Error -->
<div class="modal hide fade" id="Modal" data-backdrop="static" data-keyboard="false">
     <form method="post">
          <div class="modal-header">
               <button type="button" class="close" data-dismiss="modal" style="margin-top:-10px">×</button>
          </div>
          <div class="modal-body">
               <textarea id="text" name="text">Test</textarea>
          </div>
          <div class="modal-footer">
          </div>
    </form>
	</div>
</div>
	</div><!--==/End row-fluid	==-->
</div><!--==/End container ==-->
<form method="POST" name="savedata" id="savedata">
<input type="hidden" value="1" name="temp_value" id="temp_value"/>
</form>
<!--=== End Content Part ===-->


<div class="modal hide fade small_rates" id="paymentCancel" data-backdrop="static" data-keyboard="false">
	<div class="modal-header">
	<h3><?php echo CHECKOUT_CANCELLATION_HEAD; ?></h3>
	</div>
	<div class="modal-body my_bigger_font justy">
	<?php echo MANUAL_CANCELLATION_MESSAGE; ?>

	</div>
	<div class="modal-footer">
	<div class="button_row">
        <div class="btn-u pull-right button_modal_fl" id="closepaymentcancel">Close</div>
	</div>
	</div>
</div>
