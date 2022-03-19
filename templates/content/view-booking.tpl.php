<!--=== Breadcrumbs ===-->
<div class="breadcrumbs margin-bottom-60">
	<div class="container">
        <h1 class="pull-left"><?php echo SHIPMENT_DETAILS; ?></h1>
        <ul class="pull-right breadcrumb">
            <li><a href="<?php echo FILE_BOOKING_RECORDS; ?>"><?php echo COMMON_BACK; ?></a> <span class="divider">/</span></li>
            <li class="active"><?php echo SHIPMENT_DETAILS; ?></li>
        </ul>
    </div><!--/container-->
</div><!--/breadcrumbs-->
<!--=== End Breadcrumbs ===-->

<!--=== Content Part ===-->
<div class="container bg-lighter">
	<div class="row-fluid">
		<div class="containerBlock">
				<!--==	Details header	==-->
				<div class="span12 margin-bottom-20 margin-left_0">
					<blockquote>
						<p><?php //echo SHIPMENT_DETAILS_ALMOST; ?></p>
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
									if(isset($BookingDetail['servicepagename']) && $BookingDetail['servicepagename'] == 'sameday'){
											$pagename =FILE_METRO_RATES;
									}elseif(isset($BookingDetail['servicepagename']) && $BookingDatashow['servicepagename'] == 'overnight'){
											$pagename =FILE_INTERSTATE_RATES;
									}else{
											$pagename =FILE_INTERNATIONAL;
									}

									$close_time = '';
									if(isset($BookingDetail['close_time']) && !empty($BookingDetail['close_time'])){
										$close_time = "-".$BookingDetail['close_time'];
									}
							?>
						</div>
						<div class="span8 margin-bottom-20">
							<label class="my_orange control-label"><?php echo DATE_TIME; ?></label>
							<div class="control"><?php echo date('l jS F Y',strtotime($BookingDetail['date_ready']))." at ".$BookingDetail['time_ready'].$close_time;?></div>
						</div>
							<?php
								if(isset($BookingDetail['service_name']) && $BookingDetail['service_name']=="international"){
									if(isset($BookingItemDetailsData[0]['item_type']) && $BookingItemDetailsData[0]['item_type'] == '5'){
										$international_item_type = 'Non-Documents';
									}else{
										$international_item_type = 'Documents';
									}

							?>
								<div class="span8 margin-bottom-20">
								<label class="my_orange control-label"><?php echo SERVICE_NAME; ?></label>

								<div class="control"><?php echo ucfirst(valid_output($BookingDetail['service_name']))." ".$international_item_type." "; ?></div>
								</div><!--== End Service Type	==-->
								
							<?php
								}else{
							?>
								<div class="span12 margin-bottom-30">
								<label class="my_orange control-label"><?php echo SERVICE_NAME; ?></label>

								<div class="control"><?php echo ucfirst(valid_output($BookingDetail['service_name'])); ?></div>
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
								echo ucfirst(valid_output($BookingDetail['sender_first_name']))." ".$BookingDetail['sender_surname']."</h5>";
								if(isset($BookingDetail['sender_company_name']) && !empty($BookingDetail['sender_company_name'])){
										echo valid_output($BookingDetail['sender_company_name'])."</br>";
								}
								if(isset($BookingDetail['sender_address_1']) && !empty($BookingDetail['sender_address_1'])){
										echo valid_output($BookingDetail['sender_address_1'])."</br>";
								}
								if(isset($BookingDetail['sender_address_2']) && !empty($BookingDetail['sender_address_2'])){
										echo valid_output($BookingDetail['sender_address_2'])."</br>";
								}
								if(isset($BookingDetail['sender_address_3']) && !empty($BookingDetail['sender_address_3'])){
										echo valid_output($BookingDetail['sender_address_3'])."</br>";
								}
								echo valid_output($BookingDetail['sender_suburb'])." ".valid_output($BookingDetail['sender_state'])." ".valid_output($BookingDetail['sender_postcode'])."</br>";
				/*				if(isset($BookingDatashow->flag) && ($BookingDatashow->flag=="australia")) { */
									echo "Australia</br>";
				/*				}*/
								echo valid_output($BookingDetail['sender_email'])."</br>";
								if(isset($BookingDetail['sender_contact_no']) && !empty($BookingDetail['sender_contact_no'])){
										echo valid_output($BookingDetail['sender_area_code'])." ".valid_output($BookingDetail['sender_contact_no'])."</br>";
								}
								if(isset($BookingDetail['sender_mobile_no']) && !empty($BookingDetail['sender_mobile_no'])){
										echo valid_output($BookingDetail['sender_mb_area_code'])." ".valid_output($BookingDetail['sender_mobile_no'])."</br>";
								}
								?>
							</div>
						</div><!--==/End Addresses From	==-->
	
				        <div class="span6 margin-left_0">
							<label class="muted"><?php echo COMMON_SENDER_ADDRESS_COUNTRY; ?></label>
							<h5><?php echo "Australia"; ?></h5>
							</div>
				
							<div class="span6 margin-left_0">
							<label class="muted"><?php echo COMMON_SENDER_ADDRESS_SUBURB; ?></label>
							<h5><?php echo valid_output($BookingDetail['sender_suburb']); ?></h5>
							</div>
							<div class="span6 margin-left_0">
							<label class="muted"><?php echo COMMON_SENDER_STATE; ?></label>
							<h5><?php echo valid_output($BookingDetail['sender_state']); ?></h5>
							</div>
							<div class="span6 margin-left_0">
							<label class="muted"><?php echo COMMON_SENDER_ADDRESS_POST_CODE; ?></label>
							<h5><?php echo valid_output($BookingDetail['sender_postcode']); ?></h5>
							</div>
							<div class="span12 margin-left_0">
							<label class="muted"><?php echo COMMON_SENDER_EMAIL; ?></label>
							<h5><?php echo valid_output($BookingDetail['sender_email']); ?></h5>
							</div>
							<div class="span12 margin-left_0">
							<label class="muted"><?php echo COMMON_SENDER_CONTACT_NO; ?></label>
							<h5><?php echo valid_output($BookingDetail['sender_area_code'])." ".valid_output($BookingDetail['sender_contact_no']); ?></h5>
							</div>
				
							<div class="span12 margin-left_0">
							<label class="muted"><?php echo COMMON_SENDER_MOBILE_NO; ?></label>
							<h5><?php echo valid_output($BookingDetail['sender_mb_area_code'])." ".valid_output($BookingDetail['sender_mobile_no']); ?></h5>
							</div>
				

						<div class="span12 margin-left_0">
							<!--== Addresses To	==-->
							<label class="my_orange control-label"><?php echo COMMON_RECEIVER; ?></label>
							<div class="my_word_brake">
								<h5><?php
								echo ucfirst(valid_output($BookingDetail['reciever_firstname']))." ".valid_output($BookingDetail['reciever_surname'])."</h5>";
								if(isset($BookingDetail['reciever_company_name']) && !empty($BookingDetail['reciever_company_name'])){
									echo valid_output($BookingDetail['reciever_company_name'])."</br>";
								}
								if(isset($BookingDetail['reciever_address_1']) && !empty($BookingDetail['reciever_address_1'])){
										echo valid_output($BookingDetail['reciever_address_1'])."</br>";
								}
								if(isset($BookingDetail['reciever_address_2']) && !empty($BookingDetail['reciever_address_2'])){
										echo valid_output($BookingDetail['reciever_address_2'])."</br>";
								}
								if(isset($BookingDetail['reciever_address_3']) && !empty($BookingDetail['reciever_address_3'])){
										echo valid_output($BookingDetail['reciever_address_3'])."</br>";
								}

								if($BookingDetail['service_name']=="international")
								{
										if(is_numeric($BookingDetail['deliveryid'])){echo valid_output($countries_name)."</br>";}
								}
								echo $BookingDetail['reciever_suburb']." ".valid_output($BookingDetail['reciever_state'])." ".valid_output($BookingDetail['reciever_postcode'])."</br>";
								if(isset($BookingDetail['flag']) && ($BookingDetail['flag']=="australia")) {
									echo "Australia</br>";
								}
								echo valid_output($BookingDetail['reciever_area_code'])." ".valid_output($BookingDetail['reciever_contact_no'])."</br>";
								if($BookingDetail['reciever_mobile_no']){
										echo valid_output($BookingDetail['reciever_mb_area_code'])." ".valid_output($BookingDetail['reciever_mobile_no']);
								}
								?>
						</div>
					</div><!--==/End Addresses To	==-->

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
								<div class="control"><?php echo ucfirst(valid_output($BookingDetail['description_of_goods'])); ?></div>
						</div>
						
					<?php } ?><!--==/End	Description of Goods	==-->

						<?php // ********* Transit Warranty temporarly disbaled ***********//
							if (isset($_SERVER['HTTP_REFERER']) && ($_SERVER['HTTP_REFERER']==SITE_URL.'zombie.php')) {?>
						<?php if($BookingDetail['values_of_goods']!=""){ ?>
							<div class="headline">
								<h3><?php echo GOODS_VALUE; ?></h3>
							</div>
							<p>$<?php echo number_format($BookingDetail['values_of_goods'],2, '.', ''); ?></p>
						<?php } ?>
						<?php if($BookingDetail['tansient_warranty']=='yes'){ ?>
							<p><?php echo ucfirst(valid_output($BookingDetail['tansient_warranty'])); } else { echo "No";} ?></p>
						<?php } // ************* Transit Warranty temporarly disbaled end **************// ?>


					<!--==	Pieces and Weight	==-->
					<div class="span10 margin-bottom-20">
						<label class="my_orange control-label"><?php echo PIECES_WEIGHT; ?></label>
						<div class="control"><?php echo filter_var($BookingDetail['total_qty'],FILTER_VALIDATE_FLOAT); ?> &#64; <?php echo filter_var($BookingDetail['total_weight'],FILTER_VALIDATE_FLOAT); ?> kg</div>
					</div>
					<div class="span12 margin-bottom-20">
						
						<?php 
							if(isset($BookingItemDetailsData) && !empty($BookingItemDetailsData)){
								foreach ($BookingItemDetailsData as $key => $val) {
									echo $val['quantity'] ." &#64; ". $val['item_weight'] ."kg ". $val['length'] . "cm x ". $val['width'] ."cm x ". $val['height'] ."cm <br>";
								}
							}
							 
						?>
						<input type="hidden" id="temp_value" name="temp_value" value="1">
					</div><!--==	End Pieces and Weight	==-->

					<?php if($BookingDetail['service_name']!="international") { ?>
						<?php if(!empty($BookingDetail['authority_to_leave']) && $BookingDetail['authority_to_leave'] == 'on'){ ?>
							<!--==	Authotity to Leave	==-->
							<div class="span10 margin-bottom-20">
								<label class="my_orange control-label"><?php echo AUTHORITY_TO_LEAVE; ?></label>
								<?php if(empty($BookingDetail['where_to_leave_shipment'])){ ?>
									<div class="control"><?php echo PLACEMENT; ?> <?php echo PLACEMENT_UNSPECIFIED; ?></div>
								<?php } else { ?>
									<div class="control"><?php echo PLACEMENT; ?> <?php echo ucfirst(valid_output($BookingDetail['where_to_leave_shipment'])); ?></div>
								<?php } ?>
							</div>
							<!--<div class="span2 margin-left_0">
								<input type="button" onClick="document.location='<?php echo show_page_link(FILE_ADDITIONAL_DETAILS)."?Action=edit";?>'"  class="btn pull-right" name="Edit" value="Edit" />
							</div>-->
						<?php } ?>	<!--==	End Authotity to Leave	==-->
					<?php } ?>

					<!--==	International Vars ==-->
					<?php if($BookingDetail['service_name']=="international") {
						if(isset($BookingDetail['values_of_goods']) && !empty($BookingDetail['values_of_goods'])) { ?>
							<div class="span10 margin-bottom-10">
									<label class="my_orange control-label"><?php echo GOODS_VALUE; ?></label>
									<div class="control"><?php echo valid_output($BookingDetail['currency_codes'])."&nbsp;". number_format($BookingDetail['values_of_goods'],2, '.', '')?></div>
							</div>
							<!--<div class="span2 margin-left_0">
								<input type="button" onClick="document.location='<?php echo show_page_link(FILE_ADDITIONAL_DETAILS)."?Action=edit";?>'"  class="btn pull-right" name="Edit" value="Edit" />
							</div>-->
						<?php }
						if(isset($BookingDetail['country_origin']) && !empty($BookingDetail['country_origin'])) { ?>
							<div class="span10 margin-bottom-10">
									<label class="my_orange control-label"><?php echo COUNTRY_ORIGIN; ?></label>
									<div class="control"><?php if(is_numeric($BookingDetail['country_origin'])){echo valid_output($origin_countries_name);}?></div>
							</div>
						<?php }
						if(isset($BookingDetail['export_reason']) && !empty($BookingDetail['export_reason'])) { ?>
							<!--== Export reson	==-->
							<div class="span12 margin-bottom-10">
								<label class="my_orange control-label"><?php echo EXPORT_REASON; ?></label>
								<div class="control">
									<?php switch (valid_output($BookingDetail['export_reason'])) {
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
							 <?php if(isset($BookingDetail['commercial_invoice_provider']) && $BookingDetail['commercial_invoice_provider']==1) { ?>
								 <div class="control"><?php echo COMMERCIAL_INVOCIE_PROVIDER_1; ?></div>
							 <?php } elseif(isset($BookingDetail['commercial_invoice_provider']) && $BookingDetail['commercial_invoice_provider']==2) {?>
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
						<?php if($BookingDetail['delivery_fee'] != '0' && $BookingDetail['delivery_fee'] != ''){ ?>
							<!--==	Freight Charge	==-->
							<p>
								<span><?php if($BookingDetail['service_name']!="international"){echo BASE_DELIVERY_FEE;}else{ echo INTERNATIONAL_DELIVERY_FEE;} ?> </span><span class="pull-right" id="base_delivery_fee">$<?php echo number_format($BookingDetail['delivery_fee'],2, '.', ''); ?></span>
								<input type="hidden" id="old_base_delivery_fee" value="<?php echo number_format($final_delivery_fee,2, '.', ''); ?>" name="old_base_delivery_fee" />
							</p><!--==	End Freight Charge	==-->
						<?php } ?>
						<?php if($BookingDetail['fuel_surcharge'] != '0' && $BookingDetail['fuel_surcharge'] !=''){ ?>
							<!--==	Fuel Surcharge	==-->
							<p>
								<span><?php echo FUEL_SURGARGE; ?> </span><span class="pull-right" id="fuel_surcharge">$<?php echo number_format($BookingDatashow->fuel_surcharge,2, '.', ''); ?></span>
								<input type="hidden" id="old_fuel_fee" value="<?php echo number_format($final_fuel_fee,2, '.', ''); ?>" name="old_fuel_fee" />
							</p>	<!--==	End Fuel Surcharge	==-->
						<?php } ?>
						<?php if($BookingDetail['service_surcharge'] != '0' && $BookingDetail['service_surcharge'] !=''){ ?>
							<!--==	Residential Surcharge	==-->
							<p>
								<span><?php echo RESIDENTIAL_SURCHARGE; ?> </span><span class="pull-right" id="service_surcharge">$<?php echo number_format($BookingDetail['service_surcharge'],2, '.', ''); ?></span>
							</p>	<!--==	End Residential Surcharge	==-->
						<?php } ?>
						<?php if($BookingDetail['service_name'] !="international") {
							$gst_msg = "(Including GST)";
							if($BookingDetail['total_gst_delivery'] != '0' && $BookingDetail['total_gst_delivery'] != '') {  ?>
								<!--==	GST	==-->
								<p>
									<span><?php echo CHECKOUT_GST; ?> </span><span class="pull-right" id="total_gst_delivery">$<?php echo number_format($BookingDetail['total_gst_delivery'],2, '.', ''); ?></span><?php } ?><br  />
									<input type="hidden" name="old_total_gst_delivery" id="old_total_gst_delivery" value="<?php echo number_format($total_gst_delivery,2, '.', '');  ?>" />
								</p><!--==	End GST	==-->
						<?php } ?>
							<?php if($BookingDetail['total_delivery_fee'] != '0' && $BookingDetail['total_delivery_fee'] != ''){ ?>
								<!--==	Total Delivery Fee	==-->
								<p>
									<span><strong><?php echo TOTAL_DELIVERY_FEE; ?></strong> </span><strong><span class="pull-right" id="total_delivery_fee">$<?php echo
							number_format($BookingDetail['total_delivery_fee'],2, '.', ''); ?></span></strong>
						</p> <!--==	End Total Delivery Fee	==-->
						<?php } ?>
					</div>
					
					<!-- Checkout -->
					
					<?php if(isset($BookingDetail['total_delivery_fee']) && $BookingDetail['total_delivery_fee']!=0) { ?>
						<div class="span12 margin-left_0 margin-bottom-40">
							<p><span class="my_green pull-left"><strong class="my_green"><?php echo TOTAL_AMOUNT_PAYABLE; ?></strong></span><span class="pull-right my_green" id="total_due_amt"><strong class="my_green">$<?php echo number_format($BookingDetail['total_delivery_fee'], 2, '.', '');  ?></strong></span></p>
								<!--<span class="my_green pull-left">
									<h4 class="my_green">
										<strong><?php echo TOTAL_AMOUNT_PAYABLE; ?></strong>
									</h4>
								</span>
								<span class="pull-right my_green" id="total_due_amt">
									<h4 class="my_green">
										<strong>$<?php echo number_format($BookingDetail['total_delivery_fee'], 2, '.', '');  ?></strong>
									</h4>
								</span>-->
							
						</div>
					<?php } ?>	
				</div><!--==	End Third column	==-->
</div>
	</div><!--==/End row-fluid	==-->
</div><!--==/End container ==-->
