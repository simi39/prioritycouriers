<!--=== Breadcrumbs ===-->
<div class="breadcrumbs margin-bottom-20">
	<div class="container" >
        <h1 class="pull-left"><?php echo COMMON_BS; ?></h1>
        <ul class="pull-right breadcrumb" id="booking_breadcrumb">
            <li><a href="<?php echo SITE_INDEX;?>"><?php echo COMMON_HOME; ?></a> <span class="divider">/</span></li>
            <li class="active"><?php echo COMMON_BS; ?></li>
        </ul>
    </div><!--/container-->
</div><!--/breadcrumbs-->
<!--=== End Breadcrumbs ===-->
<?php
//echo "<pre>";
//print_r($BookingDatashow);
//print_r($BookingItemDetailsData);
//print_r($BookingDetailsDataVal);
//print_r($_SESSION);
//echo "</pre>";
?>


<!--=== Content Part ===-->
<div class="container">
	<div class="row-fluid">
	<form action="" method="post" name="Frmaddclient" id="Frmaddclient">
		 <div class="span9 margin-bottom-20 margin-left_0">
         	<!--==	Your Booking Summary ==-->
         	<div class="span12 margin-bottom-20 bg-light margin-left_0">
                <div class="headline">
                    <h3><?php echo BS_YOUR_BOOKING_SUMMARY; ?></h3>
                </div>
    			<blockquote><p class="justy"><?php echo BOOKING_SUCCESS_1; ?>&nbsp;<strong class="my_green"><?php echo valid_output($BookingDetailsDataVal['CCConnote']);//echo valid_output($BookingDetailsDataVal['booking_id']);?></strong>.&nbsp;<?php echo BOOKING_SUCCESS_2; ?>
                </p></blockquote>
           	</div><!--==/End Your Booking Summary ==-->
            <!--==	Main Booking Summary ==-->
            <div class="span1"></div>
            <div class="span10 margin-left_0 bg-light my_bigger_font my_line_height">
            	<span class="muted"><?php echo BS_BOOKING_REF; ?></span>
                <span class="pull-right my_green"><?php echo valid_output($BookingDetailsDataVal['CCConnote']);//echo valid_output($BookingDetailsDataVal['booking_id']);?>
                </span><br />
            	<span class="muted"><?php echo BS_BOOKING_DATE_TIME; ?></span>
                <span class="pull-right my_green">
                    <?php
						if($BookingDetailsDataVal["time_ready"]!=": " && $BookingDetailsDataVal['date_ready']!='')
				 			{
								$date =   valid_output($BookingDetailsDataVal["time_ready"])." ".valid_output($BookingDetailsDataVal['date_ready']);
							echo date('d M Y h:i a',strtotime($date));
				 		}else
				 			{

							echo date('d M Y h:i a',strtotime(valid_output($BookingDetailsDataVal['date_ready'])));
						}
					?>
              	</span><br />
                <!--<span class="muted"><?php echo BS_WEIGHT; ?></span>
                <span class="pull-right my_green"><?php echo valid_output($BookingDetailsDataVal['chargeable_weight']);?> kg
                </span><br />-->
                <span class="muted"><?php echo BS_COURIER_NAME; ?></span>
                <span class="pull-right my_green"><?php echo valid_output($BookingDetailsDataVal['webservice']);?>
                </span><br />
                <span class="muted"><?php echo BS_SERVICE_TYPE; ?></span>
                <span class="pull-right my_green"><?php echo ucwords(valid_output($BookingDetailsDataVal['service_name']));?>
                </span><br />
                <!--<span class="muted"><?php echo BS_QUANTITY; ?></span>
                <span class="pull-right my_green"><?php echo valid_output($BookingDetailsDataVal['total_qty']);?>
                </span><br />-->
               <!-- <span class="muted"><?php echo BS_SENDER; ?></span>
                <span class="pull-right my_green"><?php echo ucwords(valid_output($BookingDetailsDataVal['sender_first_name'])." ".valid_output($BookingDetailsDataVal['sender_surname']));?>
                </span><br />
                <span class="muted"><?php echo BS_RECEIVER; ?></span>
                <span class="pull-right my_green"><?php echo ucwords(valid_output($BookingDetailsDataVal['reciever_firstname'])." ".valid_output($BookingDetailsDataVal['reciever_surname']));?>
                </span><br />-->
				<?php
					if(is_numeric($deliverid))
					{
						$sender_suburb = ucwords(valid_output($BookingDetailsDataVal['sender_suburb'])).", "."Australia";
						$receiver_suburb = ucwords(valid_output($BookingDetailsDataVal['reciever_suburb'])).", ". $countries_name;
					}else{
						$sender_suburb = ucwords(valid_output($BookingDetailsDataVal['sender_suburb']));
						$receiver_suburb = ucwords(valid_output($BookingDetailsDataVal['reciever_suburb']));
					}
				?>
                <span class="muted"><?php echo BS_PICKUP_FROM; ?></span>
                <span class="pull-right my_green"><?php echo $sender_suburb; ?>
                </span><br />
                <span class="muted"><?php echo BS_DELIVER_TO; ?></span>
                <span class="pull-right my_green"><?php echo $receiver_suburb ;?>
                </span>
                <div class="hr_dashed">&nbsp;</div><br />
                <?php if(isset($BookingDetailsDataVal['total_gst_delivery'])&&!empty($BookingDetailsDataVal['total_gst_delivery'])) {?>
                    <span class="muted"><?php echo BS_AMOUNT_GST; ?></span>
                    <span class="pull-right my_green">$ <?php echo number_format($BookingDetailsDataVal['total_gst_delivery'],2,'.','');?></span><br />
                <?php } ?>
                <span class="muted"><?php echo BS_AMOUNT_PAID; ?></span>
                <span class="pull-right my_green">$ <?php echo number_format($total_display_rate,2,'.','');?>
                </span><br />
           	</div>
            <div class="span1"></div><!--==/End Main Booking Summary ==-->
            <div class="span12 margin-left_0" id="printsec">
            	 <div class="span2"></div><!--==/End Main Booking Summary ==-->
                 	<div class="span8">
                    <a class="btn btn-large text_centre pull-left" href="#" onclick="javascript:myfunction();"><i class="icon-print"></i>&nbsp; <?php echo BS_PRINT;?></a>

        			<a class="btn-u btn-u-large text_centre pull-right" href="<?php echo show_page_link(FILE_BOOKING);?>" ><?php echo ANOTHER_BOOKING;?></a>
                    </div>
            	 <div class="span2"></div><!--==/End Main Booking Summary ==-->
   			</div>
      	</div><!--==/End span9 ==-->
        <?php // ********* Tracking Info temporarly disbaled ***********//
            if (isset($_SERVER['HTTP_REFERER']) && ($_SERVER['HTTP_REFERER']==SITE_URL.'zombie.php')) {?>
                <div class="span3" id="tracking_info">
         		<!-- Our Services -->
                    <div class="who margin-bottom-30">
                        <div class="headline"><h3><?php echo BS_TRACKING; ?></h3></div>
                        <p class="justy"><?php echo BS_TRACKING_INFO; ?></p>
                    </div>
         		</div><!--==/End span3 ==-->
        <?php } // ************* Tracking Info temporarly disbaled end **************// ?>        
</form>
	</div>
</div><!--/End Container -->
<script>
function myfunction(){
	window.print();
}
</script>
