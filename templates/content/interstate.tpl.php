
<!--=== Breadcrumbs ===-->
<div class="breadcrumbs margin-bottom-60">
	<div class="container">
        <h1 class="pull-left"><?php echo COMMON_INTERSTATE_PRICING; ?></h1>
        <ul class="pull-right breadcrumb">
            <li><a href="<?php echo SITE_INDEX;?>">Home</a> <span class="divider">/</span></li>
            <li><a href="">Pages</a> <span class="divider">/</span></li>
            <li class="active"><?php echo COMMON_INTERSTATE_PRICING; ?></li>
        </ul>
    </div><!--/container-->
</div><!--/breadcrumbs-->
<!--=== End Breadcrumbs ===-->
<?php

	$regionDate = date('d-m-Y', strtotime($start_date));
	/* This default date format is necessary as it is not
	** taking values in timepicker drop down list of times(timepicker function in javascript)
	*/

	if(isset($BookingDetailsDataObjArray['time_ready']) && !empty($BookingDetailsDataObjArray['time_ready'])){
		$ready_time = $BookingDetailsDataObjArray['time_ready'];
		$datetime = $start_date." ".$ready_time;
		//$defaultdate = date('l j F Y h:i:s A',strtotime($datetime));
		$defaulthr = date("H",strtotime($datetime));
		$defaultmin = date("i",strtotime($datetime));
		$defaultsec = date("s",strtotime($datetime));
		$defaultTime = date('H:i', ceil(strtotime($defaulthr.":".$defaultmin)/1800)*1800);

	}
	/*$cutOffTime = '2:00 PM';
	//echo $regionOriginalTiming."---".$cutOffTime."</br>";
	$disableToday = 'true';
	if((strtotime($regionOriginalTiming)>=strtotime($cutOffTime)))
	{
		//echo "greater".conv($regionOriginalTiming)."----".conv($cutOffTime)."</br>";
		$disableToday = 'false';
	}*/
	$chkTommorrow = date('d-m-Y', strtotime(get_time_zonewise($pickupid).' +1 day'));

	if(isset($dates[0]) && !empty($dates[0])){
		$firstBusinessDt = $dates[0]; //format is d-m-Y
	}
	//$displayTommorrow = "Tommorrow";
	if(isset($dates) && !empty($dates)){
		if(in_array($chkTommorrow, $dates)) {
			//echo "yes it is available";
			$displayTommorrow = "Tommorrow";
		}else{
			$displayTommorrow = date('l jS F Y',strtotime($dates[1]));
			$chkTommorrow = $dates[1];
		}
	}

?>
<!--=== Content Part ===-->
<div class="container">
	<div class="row-fluid">
        <!-- Pricing -->
		<form method="Post" id="interstate" action="">
        <div class="row-fluid margin-bottom-40 span9" id="Service">
        	<?php

			$k =1;
			
			if(isset($ServiceDetailsData) && !empty($ServiceDetailsData)){
				array_sort_by_column($ServiceDetailsData, 'sorting');
			}
			
			/*echo "<pre>";
			print_r($ServiceDetailsData);
			echo "</pre>";*/
			 for($i=0;$i<count((array)$ServiceDetailsData);$i++)
			 {
				 
				$service_name = valid_output($ServiceDetailsData[$i]['service_name']);
				$service_code = valid_output($ServiceDetailsData[$i]['service_code']);
				 $final_price = ($ServiceDetailsData[$i]['service_rate']);
				 $time_hr1=valid_output($ServiceDetailsData[$i]['hours']);
				 $time_sec1=valid_output($ServiceDetailsData[$i]['minites']);
				 $hr_formate1=valid_output($ServiceDetailsData[$i]['hr_formate']);
				 $dbtiming   = $time_hr1.":".$time_sec1." ".$hr_formate1;
				 $jsdbtiming = date('h:i A',strtotime($dbtiming));
				 //$usertiming = $time_hr.":".$time_min." ".$hr_formate;
				$courier_id = $ServiceDetailsData[$i]['supplier_id'];
			 	
				if(isset($final_price)){
	 		 		$opacity ="";
					
					$cutOffTime = "2:00 PM";
					//echo $usertiming."---".$dbtiming."</br>";
					// if today's date for that region is same as selected business date than only compare time otherwise it will always tommorrow
					if(isset($firstBusinessDt) && !empty($firstBusinessDt) && isset($regionDate) && !empty($regionDate) && strtotime($firstBusinessDt) == strtotime($regionDate) && strtotime($usertiming) < strtotime($cutOffTime)){
						
						if((conv($usertiming)!=00) && (conv($usertiming)<=conv($dbtiming) )){
							$opacity ="";
						
						}else{
							$opacity ="bg_opacity";
						
						}
					}
				//echo "display collection dt:".$display_collection_dt."</br>";
				$priceArr = explode(".",number_format($final_price,2,'.',''));
				$dollarVal = $priceArr[0];
				$centVal = $priceArr[1];
				$booking_details_data = $__Session->GetValue("booking_details");

				/** Adding a CSS class "top-price" if service is selected  **/
				if (strtolower($ServiceDetailsData[$i]['service_name']) == ($booking_details_data['service_name'])){
					$top_price ="top-price";
				} else {
					$top_price ="";
				}
				/** Adding a CSS class no-click if service is selected **/
				if (strtolower($ServiceDetailsData[$i]['service_name']) == ($booking_details_data['service_name'])){
					$no_click="no-click";
				} else {
					$no_click="";
				}
				//echo $service_val['service_name']."---".$booking_details_data['service_name']."</br>";
				/** Changing the button name if clicked **/
				if (strtolower($ServiceDetailsData[$i]['service_name']) == ($booking_details_data['service_name'])){
					$service_select="SELECTED";
				} else {
					$service_select=SELECT_SERVICE;
				}
				//$booking_details_data = $__Session->GetValue("booking_details");
			?>
			<div id="<?php echo $service_code; ?>" class="span4 pricing hover-effect <?php echo $top_price;?>">
            	<div class="pricing-head <?php echo $opacity; ?>">
                	<h3><?php echo strtoupper(valid_output($ServiceDetailsData[$i]['service_name'])); ?></h3>
                    <h4><?php echo "<i>$</i>$dollarVal"."<i>.".$centVal."</i>"; ?></h4>
                </div>
                <!--== Service highlights ==-->
                <?php if($ServiceDetailsData[$i]['service_status_info'] == 1){ ?>
					<div class="details-link"><?php echo $ServiceDetailsData[$i]['service_info']; ?></div>
				<?php } ?>
                <!--==/End Service highlights ==-->
            	<div class="pricing-footer form-group">
                	<div class='input-group date width_100' id='datetimepicker<?php echo $k; ?>'>
						<p class="<?php echo $opacity; ?>"><?php echo COMMON_INCLUDE_GST; ?></p>
						<input type='hidden' class="form-control"  id="dtp_input<?php echo $k; ?>" data-date-format="DD MMM YYYY hh:mm A" />
						<span class="input-group-addon input-group-addon-go">
						<?php
						//echo "opacity:".$opacity;
						if(($opacity) && isset($userid) && !empty($userid)){
						?>
							<button id="addresses_<?php echo $k; ?>" class="btn-u <?php echo $no_click;?>" name="selectDt" type="button" onclick="riseService('<?php echo $service_code; ?>');showButton();javascript:ChooseInterStateCollectionDate('<?php echo $k; ?>','<?php echo strtolower(valid_output($ServiceDetailsData[$i]['service_name'])); ?>','<?php echo $courier_id; ?>','<?php echo number_format($final_price,2,'.','');?>','<?php echo $jsdbtiming;  ?>');"><?php echo $service_select; ?></button>
						<?php
						}else{
						?>
							<?php
								if(isset($userid) && !empty($userid)){

							?>
							<button id="addresses_<?php echo $k; ?>" class="btn-u <?php echo $no_click;?>" name="bookNow" type="button" onclick="riseService('<?php echo $service_code; ?>');showButton();javascript:ChooseInterService('<?php echo strtolower(valid_output($ServiceDetailsData[$i]['service_name'])); ?>','<?php echo $courier_id; ?>','<?php echo number_format($final_price,2,'.','');?>','<?php echo $jsdbtiming;  ?>');"><?php echo $service_select; ?></button>
						<?php }else{ ?>
								<!--<button id="addresses_<?php echo $k; ?>" class="btn-u" type="button" onclick="javascript:ChooseLogin('<?php //echo $k; ?>');"><?php //echo SELECT_SERVICE."thirdoption"; ?></button>-->
						<?php } ?>

						<?php
						}
						?>
						</span>
					</div>
                </div>
            </div>
			<?php
			$k++;
			}
			}
			?>

        </div><!--/row-fluid-->
		<?php
			/*echo "<pre>";
			print_r($_SESSION);
			echo "</pre>";*/

		?>
				<?php
					if(isset($_SESSION['pagename']) && $_SESSION['pagename']!= 'index'){
						//echo "pagename:".$_SESSION['pagename'];
				?>
				<div class="span3 bg-lighter">

					<?php include(DIR_WS_RELATED.FILE_BOOKING_SUMMARY); ?>

				</div><!--/span3-->
				<?php
					}
				?>
        <?php
			if(isset($userid) && ($userid)==1){
		?>
        <!--==	Date Time Info	==-->
        <div class="row-fluid">
        	<div class="span9">
        	<blockquote class="align_centre"><h4>sdfsd<?php echo "test:".COMMON_TIME_MESSAGE; ?></h4></blockquote>
            </div>
        </div><!--==/End Date Time Info	==-->
        <?php
    	}

        ?>
		<input type="hidden" name="ptoken" id="ptoken" value="<?php echo $ptoken;?>">
		<input type="hidden" name="booking_type_hidden" id="booking_type_hidden" value="<?php if(isset($BookingDetailsDataObjArray['service_name']) && !empty($BookingDetailsDataObjArray['service_name'])){ echo $BookingDetailsDataObjArray['service_name']; } ?>">
		<input type="hidden" name="courier_id_hidden" id="courier_id_hidden">
		<input type="hidden" name="total_amt" id="total_amt" value="<?php if(isset($BookingDetailsDataObjArray['rate']) && !empty($BookingDetailsDataObjArray['rate'])){ echo $BookingDetailsDataObjArray['rate']; } ?>">
		<input type="hidden" id="dateArr" value="<?php echo $date_arr; ?>" />
		<!--===		Date and Time Block		===-->
		<?php
			if(isset($userid) && !empty($userid)){
				
		?>
		<!-- -->
		<div class="row-fluid margin-bottom-20" style="<?php echo $display_collection_dt; ?>" id="interstate_collection_date_block">
        	<div class="span9">
                <div class="span8 bg-light">
									<div class="span12">
                		<div class="headline"><h3><?php echo SELECT_TIME_DATE; ?></h3>
						<h5><?php echo INTERSTATE_DATETIME_BLOCK_MSG; ?></h5>
						<h5 class="my_red my_bold_font"><?php echo INTERSTATE_DATETIME_BLOCK_SUB_MSG; ?></h5>
						</div>
                    <div class="form-group">
											<div class='input-group date'>
                        	<select class="form-control" id="interstate_collection_date" name="interstate_collection_date">
                        	<!--<option>Select Date</option>-->
                        <?php
						

                        foreach ($dates as $key => $valueDt) {
                        			$displayDt =  date('l jS F Y',strtotime($valueDt));


                        ?>
                        	<option value="<?php echo date('m/d/Y',strtotime($valueDt)); ?>" <?php if((isset($valueDt) && !empty($valueDt)) && (isset($regionDate) && !empty($regionDate)) && $valueDt == $regionDate){ echo "selected";} ?>><?php if(isset($originalDateRegion) && isset($valueDt) && $originalDateRegion == $valueDt){echo 'Today';}elseif(isset($chkTommorrow) && isset($valueDt) && $chkTommorrow == $valueDt){ echo $displayTommorrow;}else{echo $displayDt;} ?></option>
                        <?php
                    		}
                        ?>
                        </select>
                        </div>
                    </div>

									</div>
									<div class="span12 margin-left_0">
										<div class="span6">
											<div id="collection_time_block" >
					    					<div class="headline"><h3><?php echo READY_TIME; ?></h3></div>
					    					<div class="form-group">
													<input type="text" id="ready_time" class="form-control timepicker" name="ready_time" value="<?php if(isset($BookingDetailsDataObjArray['time_ready']) && !empty($BookingDetailsDataObjArray['time_ready'])){echo $BookingDetailsDataObjArray['time_ready'];}else{echo $defaultTime;} ?>" />
												</div>
	                    </div>
										</div>
										<div class="span6">
											<div class="headline"><h3><?php echo CLOSING_TIME; ?></h3></div>
					    				<div class="form-group">
												<input type="text" id="close_time" class="form-control timepicker" name="close_time" value="<?php if(isset($BookingDetailsDataObjArray['close_time']) && !empty($BookingDetailsDataObjArray['close_time'])){ echo $BookingDetailsDataObjArray['close_time']; } ?>" />
						   				</div>
										</div>
									</div>
              	</div>
              </div>
              <div class="span3"></div>

                <div class="span3"><input type="hidden" name="defaultDate" id="defaultDate" value="<?php echo $defaultdate; ?>"/>
				<input type="hidden" name="regionCurrentDate" id="regionCurrentDate" value="<?php echo date('m/d/Y',strtotime($regionDate)); ?>"/>
				<input type="hidden" name="firstBusinessDt" id="firstBusinessDt" value="<?php if(isset($dates[0]) && !empty($dates[0])){ echo $dates[0]; } ?>"/>
				<input type="hidden" name="tmrrwBusinessDt" id="tmrrwBusinessDt" value="<?php if(isset($chkTommorrow) && !empty($chkTommorrow)){ echo date('m/d/Y',strtotime($chkTommorrow)); } ?>"/>


				</div>
           	</div>
		</div> <!--===	//End	Date and Time Block		===-->
		<?php
			}
		?>
		<?php
			$response =$_SESSION['pagename'];
			$btn_name = 'BOOK NOW';
			if(isset($_SESSION['pagename']) && $_SESSION['pagename']=='index'){
				$btn_name = 'MAKE A BOOKING';
			}

			$btn_bk = 'PREVIOUS';
			if(isset($_GET['Action']) && $_GET['Action']=='edit')
			{
				$btn_name = 'SAVE';
				$btn_bk = 'CANCEL';
				$backurl = SITE_URL.FILE_CHECKOUT;
			}elseif($response=="index" && !isset($_GET['Action'])){
				$backurl = SITE_URL;
			}else{
				$backurl = SITE_URL.FILE_BOOKING;
			}
			/** Making the Book Now button visible if service has been selected**/
			if (!isset($booking_details_data['service_name'])){
				$showb="showb";
			} else {
				$showb="";
			}
		?>
		<div class="row-fluid span9 margin-left_0">
			<input onclick="document.location='<?php echo $backurl; ?>'" type="button" class="btn-u btn-u-large pull-left" value="&laquo; <?php echo $btn_bk; ?>" name="BackButton" />
	        <?php
				if(isset($userid) && !empty($userid)){
			?>
			<button class="btn-u btn-u-large pull-right <?php echo $showb; ?>" tabindex="34" type="button"  name="Save" id="Save" onclick="javascript:return ChooseInterStateBooking();"><?php echo $btn_name; ?> &raquo;</button>
			<?php
			}else{
			?>
			<button class="btn-u btn-u-large pull-right" tabindex="34" type="button"  name="Save" id="Save" onclick="javascript:ChooseLogin();"><?php echo $btn_name; ?> &raquo;</button>

			<?php
				}
			?>
		</div>
		</form>
		<!--//End Pricing -->

		   <!--//End Pricing "No Spacing" -->
    </div><!--/row-fluid-->
</div><!--/container-->

<?php
//echo "<pre>";
//print_r($booking_details_data);
//print_r($ServiceDetailsData);
//print_r($service_val);
//print_r($final_price);
//echo "</pre>"; ?>

<!--=== End Content Part ===-->

<div class="modal hide fade small_rates" id="cmpTwoTimers" data-backdrop="static" data-keyboard="false">
	<div class="modal-header">
	<h3><?php echo COMPARE_TIMER_HEADER_MSG; ?></h3>
	</div>
	<div class="modal-body my_bigger_font justy">
	<?php echo COMPARE_TIMER_MSG; ?>
	</div>
	<div class="modal-footer">
	<div class="button_row">
        <div class="btn-u pull-right button_modal_fl" id="cmpTimerYes">Close</div>
	</div>
	</div>
</div>
<div class="modal hide fade small_rates" id="gapOfTimers" data-backdrop="static" data-keyboard="false">
	<div class="modal-header">
	<h3><?php echo COMPARE_TIMER_HEADER_MSG; ?></h3>
	</div>
	<div class="modal-body my_bigger_font justy">
	<?php echo TIMER_GAP_MSG; ?>
	</div>
	<div class="modal-footer">
	<div class="button_row">
        <div class="btn-u pull-right button_modal_fl" id="gapofTimerYes">Close</div>
	</div>
	</div>
</div>

<!--<div class="modal hide fade small_rates" id="selInterBkMsgBox" data-backdrop="static" data-keyboard="false">
	<div class="modal-header">
	<h3><?php echo INTERSTATE_BOOKING_HEADER_MSG; ?></h3>
	</div>
	<div class="modal-body my_bigger_font justy">
	<?php echo INTER_SEL_BOOKING_MSG; ?>
	</div>
	<div class="modal-footer">
	<div class="button_row">
        <div class="btn-u pull-right button_modal_fl" id="selInterYes">Close</div>
	</div>
	</div>
</div>-->
<!--<div class="modal hide fade small_rates" id="selInterBkConfirmBox">
    <div class="modal-header">
        <h3><?php echo INTERSTATE_BOOKING_HEADER_MSG;?></h3>
    </div>
    <div class="modal-body my_bigger_font" id="msgInterBkContent">
        <?php echo INTER_STATE_BOOKING_CONFIRMATION_MSG;?>
        <div id="detailInterMsg"></div>
    </div>
		<div class="modal-footer"><div class="button_row">
    	<div class="btn-u pull-left button_modal_fl" id="msgInterBkContentNo">No</div>
        <div class="btn-u pull-right button_modal_fl" id="msgInterBkContentYes">Yes</div>
		</div></div>
</div>-->
<div class="modal hide fade small_rates" id="loginMsgBox">
    <div class="modal-header">
        <h3><?php echo LOGIN_SINGUP;?></h3>
    </div>
    <div class="modal-body my_bigger_font" id="msgContent">
        <?php echo LOGIN_REGISTER_MESSAGE;?>
    </div>
		<div class="modal-footer"><div class="button_row">
    	<a href="<?php echo show_page_link(FILE_LOGIN); ?>" class="btn-u pull-left button_modal_fl" id="closemodal">Login</a>
			<a href="<?php echo show_page_link(FILE_SIGNUP); ?>" class="btn-u pull-left margin-left_20 button_modal_fl" id="closemodal">Register</a>
			<a href="#" class="btn-u pull-right button_modal_fl" id="closemodal">Cancel</a>
		</div></div>
</div>
