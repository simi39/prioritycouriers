
<!--=== Breadcrumbs ===-->
<div class="breadcrumbs margin-bottom-60">
	<div class="container">
        <h1 class="pull-left"><?php echo COMMON_METRO_PRICING; ?></h1>
        <ul class="pull-right breadcrumb">
            <li><a href="<?php echo SITE_INDEX;?>"><?php echo COMMON_HOME; ?></a> <span class="divider">/</span></li>
            <li class="active"><?php echo COMMON_PRICE; ?></li>
        </ul>
    </div><!--/container-->
</div><!--/breadcrumbs-->
<!--=== End Breadcrumbs ===-->


<!--=== Content Part ===-->
<div class="container">
	<div class="row-fluid">
        <!-- Pricing -->
		<form method="Post" id="metro" action="">
        <div class="row-fluid margin-bottom-40 span9" id="Service">
        	<?php
					
			 $k =1;
		
			$filteredServiceDetails = $ServiceDetailsData;
			
			if(isset($ServiceDetailsData['selected_service_cutoff_time']) && !empty($ServiceDetailsData['selected_service_cutoff_time'])){
				unset($filteredServiceDetails['selected_service_cutoff_time']);
				//$filteredServiceDetails = 
			}
			if(isset($filteredServiceDetails)){
				array_sort_by_column($filteredServiceDetails, 'sorting');
			}
			
			
			//exit();
			
			/*echo "<pre>";
			print_r($ServiceDetailsData);
			echo "</pre>";*/
			//echo "<pre>";
			//echo count((array)$ServiceDetailsData);
			//print_r($ServiceDetailsData);
			//echo "</pre>";
			 for($i=0;$i<count((array)$filteredServiceDetails)-1;$i++)
			 {
				 $servicedetails = ((array)$filteredServiceDetails);
				 $service_name = valid_output($filteredServiceDetails[$i]['service_name']);
				 $service_code = valid_output($filteredServiceDetails[$i]['service_code']);

				 /*echo "<pre>";
				 print_r($servicedetails);
				 echo "</pre>";*/
				/* $fieldArr =array();
				 $fieldArr=array("auto_id","supplier_id","service_name","service_info","service_status_info","service_description","box_color","hours","minites","hr_formate");
				 $seaByArr=array();

				 $seaByArr[]=array('Search_On'=>'service_name', 'Search_Value'=>"$service_name", 'Type'=>'string', 'Equation'=>'=', 'CondType'=>'and', 'Prefix'=>'', 'Postfix'=>'');
				 $seaByArr[]=array('Search_On'=>'service_code', 'Search_Value'=>"$service_code", 'Type'=>'string', 'Equation'=>'=', 'CondType'=>'and', 'Prefix'=>'', 'Postfix'=>'');
				 $service_data = $ObjServiceMaster->getService($fieldArr,$seaByArr);
				 $service_val = $service_data[0];
				echo "<pre>";
				print_r($service_val);
				echo "</pre>";*/
				 $final_price = ($filteredServiceDetails[$i]['service_rate']);
				// echo "final price:".$final_price."</br>";
				 /*$time_hr1=valid_output($service_val['hours']);
				 $time_sec1=valid_output($service_val['minites']);
				 $hr_formate1=valid_output($service_val['hr_formate']);
				 */
				$time_hr1=valid_output($filteredServiceDetails[$i]['hours']);
				$time_sec1=valid_output($filteredServiceDetails[$i]['minites']);
				$hr_formate1=valid_output($filteredServiceDetails[$i]['hr_formate']);
				$dbtiming   = $time_hr1.":".$time_sec1." ".$hr_formate1;
				$jsdbtiming = date('h:i A',strtotime($dbtiming));

				/* $courier_id = $service_val['supplier_id'];
				 $box_color = $service_val['box_color'];*/
				 $courier_id = $filteredServiceDetails[$i]['supplier_id'];
				 $box_color = $filteredServiceDetails[$i]['box_color'];
				// echo "usertiming:".($usertiming)."service timing:".($dbtiming)."</br>";
			 	if(isset($final_price) && isset($service_code) && $service_code != 'EC'){
	 		 		$opacity ="bg_opacity";
					$display_collection_dt = 'display:none;';
					//$showb="showb";

					if((strtotime($usertiming)!=00) && (strtotime($usertiming)<=strtotime($dbtiming) ))
					{
						//echo "inside";
						$opacity ="";
						$display_collection_dt = 'display:block;';
						//$showb ="";
			 		}

				$priceArr = explode(".",number_format($final_price,2,'.',''));
				$dollarVal = $priceArr[0];
				$centVal = $priceArr[1];
				//echo $service_code;
				//if()
				//$price
				// WE have restricted display of EConomy in metro startrack
				$booking_details_data = $__Session->GetValue("booking_details");
				/** Adding a CSS class "top-price" if service is selected  **/
				if (strtolower($filteredServiceDetails[$i]['service_name']) == ($booking_details_data['service_name'])){
					$top_price ="top-price";
				} else {
					$top_price ="";
				}
				//echo $ServiceDetailsData[$i]['service_name'];
				/** Adding a CSS class no-click if service is selected **/
				if (strtolower($filteredServiceDetails[$i]['service_name']) == ($booking_details_data['service_name'])){
					$no_click="no-click";
				} else {
					$no_click="";
				}
				/** Changing the button name if clicked **/
				if (strtolower($filteredServiceDetails[$i]['service_name']) == ($booking_details_data['service_name'])){
					$service_select="SELECTED";
				} else {
					$service_select=SELECT_SERVICE;
				}

				if(isset($service_code) && $service_code != 'EC'){
            ?>
			<div id="<?php echo $service_code;?>" class="span4 pricing hover-effect <?php echo $top_price;?>">
            	<div class="pricing-head <?php echo $opacity; ?>">
                	<h3><?php echo strtoupper(valid_output($filteredServiceDetails[$i]['service_name'])); ?></h3>
                    <h4><?php echo "<i>$</i>$dollarVal"."<i>.".$centVal."</i>"; ?></h4>
                </div>
  				<!--== Service highlights ==-->
                <?php if($filteredServiceDetails[$i]['service_status_info'] == 1){ ?>
					<div class="details-link <?php echo $opacity; ?>"><?php echo $filteredServiceDetails[$i]['service_info']; ?></div>
				<?php } ?>
                <!--==/End Service highlights ==-->
					<div class="pricing-footer form-group">
						<div class='input-group date width_100 datetimepicker' id='datetimepicker<?php echo $k; ?>'>
							<p class="<?php echo $opacity; ?>"><?php echo COMMON_INCLUDE_GST; ?></p>
							<input type='hidden'  class="form-control" data-date-format="DD MMM YYYY h:mm a"   id="dtp_input<?php echo $k; ?>" readonly="readonly"  />

							<span class="input-group-addon input-group-addon-go">
							<?php
							if($opacity && isset($userid) && !empty($userid)){
							?>
								<button type="button" id="addresses_<?php echo $k; ?>" class="btn-u <?php echo $no_click;?>" name="selectDt" onclick="riseService('<?php echo $service_code; ?>');showButton();JavaScript:return ChooseCollectionDate('<?php echo $k; ?>','<?php echo strtolower(valid_output($filteredServiceDetails[$i]['service_name'])); ?>','<?php echo $courier_id; ?>','<?php echo number_format($final_price,2,'.','');?>','<?php echo $jsdbtiming;  ?>');"><?php echo $service_select; ?></button>

							<?php
							}else{
							?>
							<?php
								if(isset($userid) && !empty($userid)){
							?>

								<button  id="addresses_<?php echo $k; ?>" class="btn-u <?php echo $no_click;?>" name="bookNow" type="button" onclick="riseService('<?php echo $service_code; ?>');showButton();javascript:ChooseService('<?php echo $k; ?>','<?php echo strtolower(valid_output($filteredServiceDetails[$i]['service_name'])); ?>','<?php echo $courier_id; ?>','<?php echo number_format($final_price,2,'.','');?>','<?php echo $jsdbtiming;  ?>');"><?php echo $service_select; ?></button>
							<?php
								}else{
							?>
								<!--<button id="addresses_<?php echo $k; ?>" class="btn-u" type="button" onclick="javascript:ChooseLogin('<?php //echo $k; ?>');"><?php //echo SELECT_SERVICE; ?></button>-->
							<?php
								}
							?>
							<?php
							}
							?>
							</span>
						</div>
					</div>

			</div>


			<?php
			}
			$k++;
			}
			}

			?>
        	<input type="hidden" id="dateArr" value="<?php echo $date_arr; ?>" />
        </div><!--/row-fluid-->
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
			if(isset($userid) && !empty($userid)){
				//echo "smita";
		?>
        <!--===		Date and Time Block		===-->
		<?php
			//echo $display_collection_dt;

		?>
		<div class="row-fluid margin-bottom-20" style="<?php echo $display_collection_dt; ?>" id="collection_date_block">
        	<div class="span9">
                <div class="span8 bg-light">
                <div class="headline"><h3><?php echo SELECT_TIME_DATE; ?></h3></div>
                    <div class="form-group">
                        <?php
                        	//echo "start date:".$start_date;
                    		/*
                    		$filteredHolidayDate = filteredBusinessDate($regionDate);
							*/
                    		$regionDate = date('d-m-Y', strtotime($start_date));
							//$zone_date_current = date('d-m-Y', strtotime(get_time_zonewise($pickupid)));


							/* This default date format is necessary as it is not
							** taking values in timepicker drop down list of times(timepicker function in javascript)
							*/
					//		$defaultdate = date('l j F Y h:i:s A',strtotime($start_date));

							//echo "dt:".$defaultdate.'---'.$defaultTime."</br>";
							if(isset($BookingDetailsDataObjArray['time_ready']) && !empty($BookingDetailsDataObjArray['time_ready'])){
								//echo "inside";
								$ready_time = $BookingDetailsDataObjArray['time_ready'];
								$datetime = $start_date." ".$ready_time;
								//$defaultdate = date('l j F Y h:i:s A',strtotime($datetime));
								$defaulthr = date("H",strtotime($datetime));
								$defaultmin = date("i",strtotime($datetime));
								$defaultsec = date("s",strtotime($datetime));
								$defaultTime = date('H:i', ceil(strtotime($defaulthr.":".$defaultmin)/1800)*1800);
							}
							//echo "default date:".$defaultdate."default time".$defaultTime."</br>";

							//echo $defaultTime;
							$chkTommorrow = date('d-m-Y', strtotime(get_time_zonewise($pickupid).' +1 day'));
							//echo "zone current dt:".$zoneCurrentDate."state:".$state."</br>";
							if(isset($zoneCurrentDate) && !empty($zoneCurrentDate) && isset($state) && !empty($state)){
								$dates = aWeekBusinessDays($state,$zoneCurrentDate);
							}
							//exit();
							if(isset($dates) && !empty($dates)){
								if(in_array($chkTommorrow, $dates)) {
									//echo "yes it is available";
									$displayTommorrow = "Tommorrow";
								}else{
									$displayTommorrow = date('l jS F Y',strtotime($dates[1]));
									$chkTommorrow = $dates[1];
								}
							}
							/*echo $disableToday;
							echo $zone_date_current."---".$dates[0];*/


						?>
						<div class='input-group date'>
                        	<select class="form-control" id="collection_date" name="collection_date">
                        	<!--<option>Select Date</option>-->
                        <?php
						if(isset($dates) && !empty($dates)){
                        	foreach ($dates as $key => $valueDt) {
                        			$displayDt =  date('l jS F Y',strtotime($valueDt));

                        ?>
                        	<option value="<?php echo date('m/d/Y',strtotime($valueDt)); ?>" <?php if((isset($valueDt) && !empty($valueDt)) && (isset($regionDate) && !empty($regionDate)) && $valueDt == $regionDate){ echo "selected";} ?>><?php if(isset($originalDateRegion) && isset($valueDt) && ($originalDateRegion == $valueDt)){echo 'Today';}elseif(isset($chkTommorrow) && isset($valueDt) && $chkTommorrow == $valueDt){ echo $displayTommorrow;}else{echo $displayDt;} ?></option>
                        <?php
                    		}
						}
                        ?>
                        </select>
                        </div>
                    </div>
				    <div id="collection_time_block">
				    <div class="headline"><h3><?php echo READY_TIME; ?></h3></div>
				    <div class="form-group">
					<input type="text" id="ready_time" class="form-control timepicker" name="ready_time" value="<?php echo $defaultTime; ?>" />
                       </div>
                    </div>
                </div>
                <div class="span3"></div>
                <div class="span3"><input type="hidden" name="defaultDate" id="defaultDate" value="<?php echo $defaultdate; ?>"/>
                	<!--  This below hidden textbox of regionCurrentDate is required to compare original date of region--->
                	<input type="hidden" name="regionCurrentDate" id="regionCurrentDate" value="<?php echo date('m/d/Y',strtotime($regionDate)); ?>"/>
					<input type="hidden" name="firstBusinessDt" id="firstBusinessDt" value="<?php if(isset($dates[0]) && !empty($dates[0])){ echo $dates[0]; } ?>"/>
					<input type="hidden" name="tmrrwBusinessDt" id="tmrrwBusinessDt" value="<?php if(isset($chkTommorrow) && !empty($chkTommorrow)){ echo date('m/d/Y',strtotime($chkTommorrow)); } ?>"/>

				</div>
           	</div>
		</div> <!--===	//End	Date and Time Block		===-->



		<?php
			}
		?>

		<input type="hidden" name="service_cutoff_time" id="service_cutoff_time" value="<?php if(isset($ServiceDetailsData['selected_service_cutoff_time']) && !empty($ServiceDetailsData['selected_service_cutoff_time'])){ echo $ServiceDetailsData['selected_service_cutoff_time'];} ?>">
		<input type="hidden" name="booking_type_hidden" id="booking_type_hidden" value="<?php if(isset($BookingDetailsDataObjArray['service_name']) && !empty($BookingDetailsDataObjArray['service_name'])){ echo $BookingDetailsDataObjArray['service_name']; } ?>">
		<input type="hidden" name="courier_id_hidden" id="courier_id_hidden">
		<input type="hidden" name="total_amt" id="total_amt" value="<?php if(isset($BookingDetailsDataObjArray['rate']) && !empty($BookingDetailsDataObjArray['rate'])){ echo $BookingDetailsDataObjArray['rate']; } ?>">
        <input type="hidden" name="ptoken" id="ptoken" value="<?php echo $ptoken;?>">
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
		<!-- onclick="document.location='<?php //echo $backurl; ?>'" -->
		<div class="row-fluid span9 margin-left_0">
			<input onclick="document.location='<?php echo $backurl; ?>'" type="button" class="btn-u btn-u-large pull-left" value="&laquo; <?php echo $btn_bk; ?>" name="BackButton" id="BackButton" />
			<?php
				if(isset($userid) && !empty($userid)){
			?>
				<button class="btn-u btn-u-large pull-right <?php echo $showb; ?>" tabindex="34" type="button"  name="Save" id="Save" onclick="javascript:return ChooseBooking();"  /><?php echo $btn_name; ?> &raquo;</button>
			<?php }else{ ?>
				<button class="btn-u btn-u-large pull-right" tabindex="34" type="button"  name="Save" id="Save" onclick="javascript:return ChooseLogin();" /><?php echo $btn_name; ?> &raquo;</button>
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
//print_r($service_val['service_name']);
//print_r($final_price);
//echo "</pre>";  ?>
<!--=== End Content Part ===-->
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


<div class="modal hide fade small_rates" id="selBkMsgBox" data-backdrop="static" data-keyboard="false">
	<div class="modal-header">
	<h3><?php echo BOOKING_HEADER_MSG; ?></h3>
	</div>
	<div class="modal-body my_bigger_font justy">
	<?php echo SEL_BOOKING_MSG; ?>
	</div>
	<div class="modal-footer">
	<div class="button_row">
        <div class="btn-u pull-right button_modal_fl" id="yes">Close</div>
	</div>
	</div>
</div>
<div class="modal hide fade small_rates" id="selBkConfirmBox">
    <div class="modal-header">
        <h3><?php echo BOOKING_HEADER_MSG;?></h3>
    </div>
    <div class="modal-body my_bigger_font" id="msgBkContent">
        <?php echo BOOKING_CONFIRMATION_MSG;?>
        <div id="detailMsg"></div>
    </div>
		<div class="modal-footer"><div class="button_row">
    	<div class="btn-u pull-left button_modal_fl" id="msgBkContentNo">No</div>
        <div class="btn-u pull-right button_modal_fl" id="msgBkContentYes">Yes</div>
		</div></div>
</div>
