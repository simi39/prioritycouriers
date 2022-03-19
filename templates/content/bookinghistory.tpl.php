<!--=== Breadcrumbs ===-->
<div class="breadcrumbs margin-bottom-60">
	<div class="container">
        <h1 class="pull-left"><?php echo COMMON_BOOKING_HISTORY; ?></h1>
        <ul class="pull-right breadcrumb">
            <li><a href="<?php echo SITE_INDEX;?>"><?php echo COMMON_HOME; ?></a> <span class="divider">/</span></li>
            <li class="active"><?php echo COMMON_BOOKING_HISTORY; ?></li>
        </ul>
    </div><!--/container-->
</div><!--/breadcrumbs-->
<!--=== End Breadcrumbs ===-->

<!--=== Content Part ===-->
<div class="container">
	<div class="row-fluid">
        <form name="bookingrecords" id="bookingrecords" method="post" action="" >
					<div id="more_light" class="span12 margin-bottom-40 margin-left_0">
        	<input type="hidden" size="34" id="ptoken" value="<?php echo $ptoken; ?>" name="ptoken">

        <!------------------------------>

        <table id="example" class="table table-striped table-hover dt-responsive" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th><?php echo BOOKING_RECORD_DATE; ?></th>
                        <th><?php echo BOOKING_RECORD_CONSIGNMENT_NOTE; ?></th>
                        <th><?php echo BOOKING_RECORD_ID; ?></th>
                        <th><?php echo BOOKING_RECORD_SERVICE; ?></th>
                        <th><?php echo BOOKING_SENDER; ?></th>
                        <th><?php echo BOOKING_RECEIVER; ?></th>
                        <th><?php echo BOOKING_RECORD_ORIGIN; ?></th>
                        <th><?php echo BOOKING_RECORD_DESTINATION; ?></th>
                        <!--<th><?php echo BOOKING_PIECES; ?></th>
                        <th><?php echo BOOKING_WEIGHT; ?></th>-->
                        <th class="all"><?php echo BOOKING_OPTION; ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php


                            if(isset($BookingDetailsData) && $BookingDetailsData!=null)
                            {
                                $no=1;
                                foreach ($BookingDetailsData as $bookingrecord)
                                {
                                    $booking_item_id = $bookingrecord['booking_id'];
                                    $tracking_id = $bookingrecord->CCConnote;
                                    $commercial_invoice = $bookingrecord->commercial_invoice;
                                    /* for booking status and load booking buttons */

                                    if(empty($bookingrecord->CCConnote))
                                    {
                                        $booking_status = BOOKING_RECORD_PENDING;

                                        $copybtn ="";
                                    }else{
                                        $booking_status = BOOKING_RECORD_FINALISED;


                                    }

                                    $service_name = ($bookingrecord->service_name=="international")?$international_shipped_items:$bookingrecord->service_name;

                                    $webservice = $bookingrecord->webservice;
                                    if(!empty($tracking_id))
                                    {

                                        $tracking_status_ids = tracking_xml_response($tracking_id);
                                        if(empty($tracking_status_ids)){
                                            $tracking_status = BOOKED_STATUS;
                                        }
                                        set_tracking_status();
                                        //echo count((array)$tracking_status_ids)."</br>";
                                        //exit();
                                        for($i=0;$i<count((array)$tracking_status_ids);$i++){
                                            if(DELIVERED_STATUS_VALUE == $tracking_status_ids[$i]){
                                                $tracking_status = DELIVERED_STATUS;
                                            }elseif (BOOKED_STATUS_VALUE == $tracking_status_ids[$i]){
                                                $tracking_status = TRANSTI_STATUS;
                                            }

                                        }
                                        if(empty($tracking_status) && $bookingrecord->tracking_status != "Cancelled")
                                        {
                                            $tracking_status = BOOKED_STATUS;
                                        }else{
                                            $tracking_status = "Cancelled";
                                        }
                                    }
									
                        ?>
                        <?php
						//$CmsPageName = "transit-warranty";
						//$Transit_Warranty = cmsPageContent($CmsPageName);


						//echo lightBoxCmsDesc($Transit_Warranty);
					?>
                    <tr>
                        <td><?php echo date("d-m-Y",strtotime(valid_output($bookingrecord->date_ready)));?></td>
                        <!--<td><a href="#" onclick="showMap('','<?php echo valid_output($bookingrecord->CCConnote); ?>')"><?php echo valid_output($bookingrecord->CCConnote); ?></a></td>Commented by Smita 3 Dec 2020-->
                        <td><a href="<?php echo SITE_URL.FILE_VIEW_BOOKING."?cn=".$bookingrecord->CCConnote;  ?>"><?php echo valid_output($bookingrecord->CCConnote); ?></a></td>
                        <td><?php echo ($bookingrecord->shipment_number);?></td>
                        <td><?php echo ucfirst(strtolower(valid_output($service_name)));?></td>
                        <td><?php echo ucfirst(strtolower(valid_output($bookingrecord->sender_surname)));?></td>
                        <td><?php echo ucfirst(strtolower(valid_output($bookingrecord->reciever_surname)));?></td>
                        <td><?php echo ucfirst(strtolower(valid_output($bookingrecord->sender_suburb)));?></td>
                        <td><?php echo ucfirst(strtolower(valid_output($bookingrecord->reciever_suburb)));?></td>
                        <!--<td><?php echo filter_var($bookingrecord->total_qty,FILTER_VALIDATE_INT);?></td>
                        <td><?php echo filter_var($bookingrecord->total_weight,FILTER_VALIDATE_FLOAT);?></td>-->
                        <td>
                            <div id="navbar-docs" class="navbar">
                                <div class="docs">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Documents
                                    <b class="caret"></b>
                                    </a>
                                    <?php
                                            $CCConnote = $bookingrecord->CCConnote;
                                            $servicename = $bookingrecord->service_name;
                                            $booking_id = $bookingrecord->booking_id;
                                            $label_name = $pagename."_".$servicename."_".(int)$CCConnote.".pdf";
                    				?>
                                    <ul class="dropdown-menu">
                                    <li>
                                           
                                           <a href="<?php echo DIR_HTTP_RELATED.FILE_SHIPPING_LABEL."?nr=".$bookingrecord->booking_id."&label=tracking";  ?>" style="width: 145px !important;" target=_new><i class="icon-barcode"></i>&nbsp;<?php echo BOOKING_OPTION_PRINT_TRACKING_LABEL; ?></a>
                                           
                                       </li>
                                        <li>
                                           
                                            <a href="<?php echo DIR_HTTP_RELATED.FILE_SHIPPING_LABEL."?nr=".$bookingrecord->booking_id."&label=consignment";  ?>" style="width: 145px !important;" target=_new><i class="icon-barcode"></i>&nbsp;<?php echo BOOKING_OPTION_PRINT_CONSIGNMENT; ?></a>
                                            
                                        </li>
                                        <li>
                                            <?php
                                                if(file_exists(DIR_WS_ONLINEPDF."receipt/Completion_Receipt_PC".$bookingrecord->auto_id.".pdf")) { ?>
                                                    <a href="<?php echo DIR_HTTP_RELATED."completion_receipt.php?nr=".$bookingrecord->booking_id;  ?>" style="width: 145px !important;" target=_new><i class="icon-barcode"></i>&nbsp;<?php echo BOOKING_OPTION_PRINT_RECEIPT; ?></a>
                                        	<?php } ?>
                                        </li>
                                        <!--<li>
                                            <?php
                                               // if(file_exists(DIR_WS_ONLINEPDF."commercial_invoice/Commercial_Invoice_".$bookingrecord->booking_id.".pdf")) { ?>
                                                    <a href="<?php //echo DIR_HTTP_RELATED."commercial_invoice.php?nr=".$bookingrecord->booking_id; ?>" style="width: 145px !important;" target=_new><i class="icon-barcode"></i>&nbsp;<?php echo BOOKING_OPTION_COMMERCIAL_INVOICE_RECEIPT; ?></a>
                							<?php //} ?>
                                        </li>-->
                                    </ul>
                                    <b class="caret-out"></b>
                                </div>
                             </div>
                        </td>
                    </tr>
                    <?php 	$no++;
                                }
                            }else{
                        ?>


                      <?php } ?>
                </tbody>
            </table>

        <!------------------------------->

		  </div>
        </form>
	    </div><!--/row-fluid-->
</div><!--/container-->
<!--=== End Content Part ===-->
<?php //echo "memory_get_peak_usage".memory_get_peak_usage(); ?>
