<?php
$session_data = json_decode($_SESSION['Thesessiondata']['_sess_login_userdetails'],true);
$userid = $session_data['user_id'];
?>

<!--=== Breadcrumbs ===-->
<div class="breadcrumbs margin-bottom-20">
	<div class="container">
        <h1 class="color-green pull-left"><?php echo NAVIGATION_BOOKING;?></h1>

    </div><!--/container-->
</div><!--/breadcrumbs-->
<!--=== End Breadcrumbs ===-->

<!--=== Main Block ===-->
<div class="container">
	<div class="row-fluid">
    	<!--=== Booking Frame ===-->

		<div class="containerBlock">
            <form name="booking" id="booking" class="span9" method="post" autocomplete='off' enctype="multipart/form-data">
         	<div id="more_light">
                <!--==	Domestic/International ==-->
                <?php
                    $disabled="";
                    if(isset($_GET['Action']) && $_GET['Action'] == 'edit'){
                        $disabled = 'readonly="readonly"';
                    }

                ?>
                <div class="row-fluid tab-underline margin-bottom-10">
                    <?php
                        if(!isset($_GET['Action'])){
                            /*echo "test";
                            echo "<pre>";
                            print_r($bookingvalue);
                            echo "</pre>";
                            */
                            /*if($bookingvalue->flag =="australia" || $_POST['flage'] == '1'){
                                echo "inside if condition1";
                            }elseif(!isset($bookingvalue->flag) && !isset($_POST['flage']))
                            {
                                echo "inside second condition2";
                            }*/
                     ?>

                    <ul class="nav nav-tabs tabs">
                        <li class="<?php if($bookingvalue->flag =="australia" || $_POST['flage'] == '1' ){ echo "active"; }elseif(!isset($bookingvalue->flag) && !isset($_POST['flage'])){ echo "active";} ?>" id="domint_1"><a href="#size_display_block_1" data-toggle="tab" id="domestic">Domestic</a></li>
                        <li id="domint_2" class="<?php if($bookingvalue->flag =="international" || $_POST['flage'] == '2' ){ echo "active"; } ?>"><a href="#size_display_block_international" data-toggle="tab" id="international">International</a></li>
                    </ul>
                    <?php
                        }
                    ?>
                </div><!--==/End Domestic/International ==-->

                <div class="row-fluid">
                    <!--	Pickup from 	-->
                    <div id="b_from" class="span6 margin-left_0 form-group">
                    <label class="control-label"><i class="icon-circle-arrow-up control-label"></i>&nbsp;<?php echo COMMON_PICK_UP_ITEM_FROM; ?></label>
                    <input <?php echo $disabled; ?> class="span7 form-control" name="pickup" tabindex="1" type="text" id="pickup" autocomplete="off" placeholder="PICK UP SUBURB/POSTCODE" onkeyup="ajax_showOptions(this,'search_val',event,'<?php echo DIR_HTTP_RELATED; ?>tms_index.php','ajax_index_listOfOptions');"  value="<?php if($bookingvalue->pickupid !="" && !isset($_GET['action'])){ echo valid_output($bookingvalue->pickupid);}elseif(valid_output($_POST['pickup'])!=""){echo valid_output($_POST['pickup']);}?>"  onfocus="if(this.value=='PICK UP SUBURB/POSTCODE'){this.value=''};" data-toggle="tooltip" title="<?php echo $delivery_to_tooltip;?>" /><br />
                        <span class="autocomplete_index help-block alert-error" id="pickupResult"></span>
                        <?php if(isset($err['PICKUPNOTEXISTS'])) { ?>
                            <!-- PHP Validation	-->
                            <div class="alert alert-error show" id="pickupError_css">
                                <div class="requiredInformation" id="pickupError"><?php  echo $err['PICKUPNOTEXISTS'];?></div>
                            </div>
                            <!--	End PHP Validation	-->
                        <?php } ?>
                        <!--	Domestic Option	-->
                        <div class="span6 margin-left_0" id="p_location_type" style="display:<?php  if($bookingvalue->flag =="international"){echo "none";}else{echo "block";}?>;">
                 <?php
                    if(isset($_POST['pickup_location_type']) && $_POST['pickup_location_type']==1)
                    {
                        $pickupchk = "checked='checked'";
                    }elseif(isset($bookingvalue->pickup_location_type) && $bookingvalue->pickup_location_type==1){
                        $pickupchk = "checked='checked'";
                    }
                    if(isset($_POST['pickup_location_type']) && $_POST['pickup_location_type']!="")
                    {
                        $pickup_loction_type = $_POST['pickup_location_type'];
                        //$pickupchk = "checked='checked'";
                    }elseif(isset($bookingvalue->pickup_location_type) && $bookingvalue->pickup_location_type!=""){
                        $pickup_loction_type = $bookingvalue->pickup_location_type;
                        //$pickupchk = "checked='checked'";
                    }else{
                        $pickup_loction_type = 1;
                    }

                 ?>
                  <label class="control-label control-label-medium my_bigger_font"><i class="icon-home"></i>&nbsp;<?php echo COMMON_RESIDENTIAL; ?></label>
                  <input type="checkbox" name="pickup_location_type" id="pickup_location_type" class="control-label" value="<?php echo $pickup_loction_type; ?>" <?php echo $pickupchk; ?>  />
                  </div><!--	//EndDomestic Option	-->
                    </div><!--	//End Pickup from -->
                    <!--	Delivery to 	-->
                    <div id="b_to" class="span6 margin-left_0 form-group">
                    <div id="display_delivery" class="margin-up-10" style="display:<?php if($bookingvalue->flag =="international" || $_POST['flage'] == '2'){ echo "none";}else{echo "block";}?>">
                    <label class="control-label"><i class="icon-circle-arrow-up control-label"></i>&nbsp;<?php echo COMMON_DELIVERY_OF_ITEM; ?></label>
                    <input name="deliver" <?php echo $disabled; ?> id="deliver" tabindex="2" autocomplete="off"  class="span7 form-control" type="text" placeholder="DELIVERY SUBURB/POSTCODE" value="<?php if($bookingvalue->deliveryid!="" && !isset($_GET['action'])){ echo valid_output($bookingvalue->deliveryid);}elseif($_POST['deliver']!=""){echo valid_output($_POST['deliver']);} ?>" onblur="if(this.value==''){this.value='DELIVERY SUBURB/POSTCODE'};" onfocus="if(this.value=='DELIVERY SUBURB/POSTCODE'){this.value=''};"   onkeyup="ajax_showOptions(this,'search_val',event,'<?php echo DIR_HTTP_RELATED; ?>tms_index.php','ajax_index_listOfOptions');" data-toggle="tooltip" title="<?php echo $pickup_from_tooltip;?>" /><br />
                        <span class="autocomplete_index help-block alert-error" id="deliverResult"></span>
                        <?php if(isset($err['DELIVERNOTEXISTS'])) { ?>
                            <!-- PHP Validation	-->
                            <div class="alert alert-error show" id="deliverError_css">
                                <div class="requiredInformation" id="deliverError"><?php echo $err['DELIVERNOTEXISTS'];?></div>
                            </div>
                            <!--	End PHP Validation	-->
                        <?php } ?>
                        <!--	Domestic Option	-->
                        <div class="span6 margin-left_0" id="d_location_type" style="display:<?php  if($bookingvalue->flag =="international"){echo "none";}else{echo "block";}?>;">
                   <?php

                    if(isset($_POST['delivery_location_type']) && $_POST['delivery_location_type']==1)
                    {

                        $deliverychk = "checked='checked'";
                    }elseif(isset($bookingvalue->delivery_location_type) && $bookingvalue->delivery_location_type==1){
                        $deliverychk = "checked='checked'";
                    }

                    if(isset($_POST['delivery_location_type']) && $_POST['delivery_location_type']!="")
                    {
                        $delivery_location_type = $_POST['delivery_location_type'];

                    }elseif(isset($bookingvalue->delivery_location_type) && $bookingvalue->delivery_location_type!=""){
                        $delivery_location_type = $bookingvalue->delivery_location_type;
                        //$deliverychk = "checked='checked'";
                    }else{
                        $delivery_location_type = 1;
                    }

                 ?>
                 <label class="control-label control-label-medium my_bigger_font"><i class="icon-home"></i>&nbsp;<?php echo COMMON_RESIDENTIAL; ?></label>
                 <input type="checkbox" name="delivery_location_type" id="delivery_location_type" class="control-label"  value="<?php echo $delivery_location_type; ?>" <?php echo $deliverychk; ?>/>
                  </div>
                        <!--	//End Domestic Option	-->
                    </div><!--	//End Delivery to 	-->

                    <!--====	International		====-->
                        <div id="international_country_display"  style="display:<?php if($bookingvalue->flag=="international" || $_POST['flage'] == '2'){echo 'block';}else{echo "none";}?>" class="margin-up-10">

                        <label class="control-label"><i class="icon-circle-arrow-down control-label"></i>&nbsp;<?php echo COMMON_DELIVERY_OF_ITEM; ?></label>
                         <?php
                          if(isset($bookingvalue->deliveryid) && $bookingvalue->deliveryid!=""){
                            $selectCountryId=$bookingvalue->deliveryid;
                          }elseif(isset($_POST['inter_country']) && $_POST['inter_country']!="")
                          {
                             $selectCountryId=$_POST['inter_country'];
                          }else{
                             $selectCountryId="0";
                          }
                          echo getDropeCountry($selectCountryId,'3', 'class=""','inter_country');
                          ?>
                           <span class="autocomplete_index help-block alert-error" id="changed_cntry_message"></span>
                            <div class="alert alert-error hide" id="intdeliverError_css">
                            <a class="close">×</a>
                            <div class="requiredInformation" id="intdeliverError" ></div>
                        </div>
                        </div><!--====/End International		====-->
                    </div><!--====/End Domestic		====-->

                </div><!-- /End row-fluid	-->

                <!--====	Delivery Block	OLD	====-->

                <!--====		Dimentions		====-->
                <div class="headline"><h3><?php echo COMMON_INFORMATION_ABOUT_THE_ITEM; ?></h3></div>

                <!--	****	Dimentions within Australia		****		-->
                <div class="row-fluid" id="size_display_block_1" style="display:<?php if((isset($bookingvalue->flag) && $bookingvalue->flag =="australia") || ($bookingvalue->flag =="" && (!isset($_POST['flage']))) || (isset($_POST['flage']) && $_POST['flage'] == '1')){ echo "block;"; }else{ echo "none;";} ?>">

                        <?php
                        if(isset($_POST['servicepagename']) && $_POST['servicepagename']!=""){
                            $service_page_item = $_POST['servicepagename'];
                        }elseif(isset($bookingvalue->servicepagename) && $bookingvalue->servicepagename!=""){
                            $service_page_item = $bookingvalue->servicepagename;
                        }else{
                            /*
                                Commented by smita 5 feb 2021
                            */
                            $service_page_item = "sameday";
                           // $service_page_item = "domestic";
                        }
                        // echo "service page item:".$service_page_item;
                        if(($bookingvalue->flag =="australia"  && !isset($_GET['action'])) || ($flag == 1 && !empty($BookingItemDetailsData)))
                        {
                            $i=1;
                            $k=0;
                            $lastval =1;

                            foreach ($BookingItemDetailsData as $BookingItemvalue) {

                        ?>
                        <div id="<?php echo filter_var($i,FILTER_VALIDATE_INT); ?>" class="controls controls-row">
                            <span  class="control-group white-space extra_width-booking_qty form-group">
                            <?php if(isset($i) && $i===1){?>
                            <label for="weight" class="control-label lebel_index-width"><?php echo COMMON_QTY; ?>&nbsp;&nbsp;<i class="icon-plus icon_index-width control-label"></i></label>
                            <?php } ?>
                            <input class="float_none span6" name="Item_qty[]" type="text" id="<?php echo "Item_qty_".filter_var($i,FILTER_VALIDATE_INT);?>" onchange="display_total_value();" value="<?php if($BookingItemvalue->quantity){echo $BookingItemvalue->quantity;}else{ echo "1";} ?>">
                            <span class="help-block alert-error" id="Items_qty_<?php echo filter_var($i,FILTER_VALIDATE_INT); ?>"><?php if(isset($multi_err['qtyError'][$k])){ echo $multi_err['qtyError'][$k];} ?></span>
                            <?php if(isset($multi_err['qtyError'][$k])) { ?>
                            <!-- PHP Validation	-->
                            <div class="alert alert-error show" id="qty_err_<?php echo filter_var($i,FILTER_VALIDATE_INT); ?>_css">
                                <div class="requiredInformation" ><?php echo $multi_err['qtyError'][$k];?></div>
                            </div>
                            <!--	End PHP Validation	-->
                            <?php } ?>
                        </span>
                        <span  class="control-group white-space extra_width-booking_type form-group">
                            <?php if(isset($i) && $i===1){?>
                            <label for="selShippingType[]" class="control-label lebel_index-width"><?php echo SELECT_PACKAGE_TYPE; ?>&nbsp;&nbsp;&nbsp;<i class="icon-question-sign icon_index-width control-label"></i></label>
                            <?php } ?>
                           <div id="servicePageItem_<?php echo filter_var($i,FILTER_VALIDATE_INT); ?>">
                            <?php
                            if(isset($_POST['selShippingType'][0]))
                            {
                                $item=filter_var($_POST['selShippingType'][0],FILTER_VALIDATE_INT);
                            }elseif(isset($BookingItemvalue->item_type)){
                                $item=filter_var($BookingItemvalue->item_type,FILTER_VALIDATE_INT);
                            }else{
                                $item =0;
                            }
                            //echo "value of dollar i:".$i."</br>";
                            //echo "value of item type:".$BookingItemvalue->item_type;
                            $extra_para ="class='float_none span10'";
                            /**Important Note: servicepage is always for australia sameday and overnight to distinguish various pages.
                             * Whereas itemtypes and its validation for sameday and overnight will always be choosen from domestic pagename
                             *(which is define in admin portion of servicepage.php file)
                             */
                            echo getItemType($item,'5',$extra_para,$i,'domestic');

                            ?>
                            </div>
                            <span class="help-block alert-error" id="selShippingTypes_<?php echo filter_var($i,FILTER_VALIDATE_INT); ?>"></span>
                            <?php if(isset($multi_err['shippingError'][$k])){ ?>
                                <!-- PHP Validation	-->
                                <div class="alert alert-error show" id="selShippingTypes_err_<?php echo filter_var($i,FILTER_VALIDATE_INT); ?>">
                                    <div ><?php echo $multi_err['shippingError'][$k]; ?></div>
                                </div>
                                <!--	End PHP Validation	-->
                            <?php } ?>
                            </span>&nbsp;&nbsp;
                        </span>
                            <span  class=" control-group white-space extra_width-booking  form-group">
                            <?php if(isset($i) && $i===1){?>
                            <label for="weight" class="control-label lebel_index-width"><?php echo COMMON_WEIGHT; ?>&nbsp;&nbsp;&nbsp;<i class="icon-download-alt icon_index-width control-label"></i></label>
                            <?php } ?>
                            <!-- onchange="display_size($('#selShippingType_<?php //echo filter_var($i,FILTER_VALIDATE_INT); ?>').children('option:selected').val())" -->
                            <input type="text" id="<?php echo "Item_weight_".filter_var($i,FILTER_VALIDATE_INT);?>" onblur="display_total_value();"  class="input-mini border-radius-none form-control"  onkeypress="javascript:removeError('Items_weight_err_<?php echo filter_var($i,FILTER_VALIDATE_INT); ?>');"  value="<?php if($bookingvalue->flag !="international"){ echo valid_output($BookingItemvalue->item_weight);} ?>" placeholder="kg" name="Item_weight[]" title="<?php echo $item_weight_tooltip;?>" <?php echo $weight_display; ?> autocomplete="off" maxlength="5" size="5" onkeyup="numberDecimal(this.value,'Item_weight_<?php echo filter_var($i,FILTER_VALIDATE_INT); ?>','booking');"/>
                            <span class="autocomplete_index help-block alert-error" id="Items_weight_<?php echo filter_var($i,FILTER_VALIDATE_INT); ?>"></span>
                                <?php if(isset($multi_err['weightError'][$k])){ ?>
                                <!-- PHP Validation	-->
                                <div class="alert alert-error show" id="Items_weight_err_<?php echo filter_var($i,FILTER_VALIDATE_INT); ?>">
                                    <div ><?php echo $multi_err['weightError'][$k]; ?></div>
                                </div>
                                <!--	End PHP Validation	-->
                                <?php } ?>
                            </span>&nbsp;&nbsp;
                            <span class="control-group white-space extra_width-booking form-group">
                            <?php if(isset($i) && $i===1){?>
                            <label for="length"  class="control-label lebel_index-width"><?php echo COMMON_LENGTH; ?>&nbsp;&nbsp;&nbsp;<i class="icon-resize-horizontal icon_index-width control-label"></i></label>
                            <?php } ?>
                            <input type="text" class="input-mini border-radius-none form-control" placeholder="cm"  name="Item_length[]" onblur="display_total_value();" onkeypress="javascript:removeError('Items_length_err_<?php echo filter_var($i,FILTER_VALIDATE_INT); ?>');"  value="<?php if($bookingvalue->flag !="international"){ echo valid_output($BookingItemvalue->length);} ?>" title="<?php echo $item_length_tooltip;?>" id="<?php echo "Item_length_".filter_var($i,FILTER_VALIDATE_INT)?>" <?php if(isset($BookingItemvalue->dim_status) && $BookingItemvalue->dim_status==0)
                                    { echo "readonly"; } ?> autocomplete="off" />
                            <span class="help-block alert-error" id="Items_length_<?php echo filter_var($i,FILTER_VALIDATE_INT); ?>"></span>
                            <?php if(isset($multi_err['lengthError'][$k])){ ?>
                                <!-- PHP Validation	-->
                                <div class="alert alert-error show" id="Items_length_err_<?php echo filter_var($i,FILTER_VALIDATE_INT); ?>">
                                    <div ><?php echo $multi_err['lengthError'][$k]; ?></div>
                                </div>
                                <!--	End PHP Validation	-->
                            <?php } ?>
                            </span>&nbsp;&nbsp;
                            <span class="control-group white-space extra_width-booking form-group">
                            <?php if(isset($i) && $i===1){?>
                            <label for="width" class="control-label lebel_index-width"><?php echo COMMON_WIDTH; ?>&nbsp;&nbsp;&nbsp;<i class="icon-resize-horizontal icon_index-width control-label"></i></label>
                            <?php } ?>
                            <input type="text" class="input-mini border-radius-none form-control" placeholder="cm" name="Item_width[]" onblur="display_total_value();" id="<?php echo "Item_width_".filter_var($i,FILTER_VALIDATE_INT)?>" onkeypress="javascript:removeError('Items_width_err_<?php echo filter_var($i,FILTER_VALIDATE_INT); ?>');" onchange="round_up(this.id,this.value,1);"  title="<?php echo $item_width_tooltip;?>" value="<?php if($bookingvalue->flag !="international"){ echo valid_output($BookingItemvalue->width);} ?>" <?php if(isset($BookingItemvalue->dim_status) && $BookingItemvalue->dim_status==0)
                                    { echo "readonly"; } ?> autocomplete="off"/>
                            <span class="help-block alert-error" id="Items_width_<?php echo filter_var($i,FILTER_VALIDATE_INT); ?>"></span>
                            <?php if(isset($multi_err['widthError'][$k])){ ?>
                                <!-- PHP Validation	-->
                                <div class="alert alert-error show" id="Items_width_err_<?php echo filter_var($i,FILTER_VALIDATE_INT); ?>">
                                    <div ><?php echo $multi_err['widthError'][$k]; ?></div>
                                </div>
                                <!--	End PHP Validation	-->
                            <?php } ?>
                            </span>&nbsp;&nbsp;
                            <span class="control-group white-space extra_width-booking form-group">
                            <?php if(isset($i) && $i===1){?>
                            <label for="height" class="control-label lebel_index-width"><?php echo COMMON_HEIGHT; ?>&nbsp;&nbsp;&nbsp;<i class="icon-resize-vertical icon_index-width control-label"></i></label>
                            <?php } ?>
                            <input type="text" class="input-mini border-radius-none form-control" placeholder="cm" id="<?php echo "Item_height_".filter_var($i,FILTER_VALIDATE_INT)?>" name="Item_height[]" title="<?php echo $item_height_tooltip;?>" onkeypress="javascript:removeError('Items_height_err_<?php echo filter_var($i,FILTER_VALIDATE_INT); ?>');" onblur="display_total_value();" value="<?php if($bookingvalue->flag !="international"){ echo valid_output($BookingItemvalue->height);} ?>"  <?php if(isset($BookingItemvalue->dim_status) && $BookingItemvalue->dim_status==0)
                                    { echo "readonly"; } ?> autocomplete="off"/>
                            <span class="help-block alert-error" id="Items_height_<?php echo filter_var($i,FILTER_VALIDATE_INT); ?>"></span>
                            <?php if(isset($multi_err['heightError'][$k])){ ?>
                                <!-- PHP Validation	-->
                                <div class="alert alert-error show" id="Items_height_err_<?php echo filter_var($i,FILTER_VALIDATE_INT); ?>">
                                    <div ><?php echo $multi_err['heightError'][$k]; ?></div>
                                </div>
                                <!--	End PHP Validation	-->
                            <?php } ?>
                            </span>
                            <?php if($i==1){ ?>
                            <span class="control-group white-space"><a href="#plus"  class="add_field_button"><i id="#plus" class="icon-plus-sign icon_plus_size"></i></a>
                            </span>
                            <?php }else{ ?>
                            <span class="control-group white-space">
                            <a href="#minus" onclick="javascript:DelSizeDataRow('<?php echo $i; ?>');"  class="removeButton" ><i class="icon-minus-sign icon_plus_size" id="#minus"></i>
                            </a>
                            </span>
                            <?php } ?>
                            <!--=== All hidden values from database ==-->
                            <?php
                                $fieldArr=array("*");
                                $seaArr = array();
                                /**
                                 * changinge service_item_type because currently from backened 
                                 * selShippingType is coming from servicepage type as domestic(table service_page_item)
                                 * so all validation will be applied for interstate and metro will be considered domestic
                                 */
                                $service_item_type = $service_page_item;
                               // $service_item_type = 'domestic';
                                //echo $service_page_item."</br>";
                                $item_type = $item;
                                $seaArr[]=array('Search_On'=>'service_page_name', 'Search_Value'=>$service_item_type, 'Type'=>'string', 'Equation'=>'=', 'CondType'=>'AND', 'Prefix'=>'', 'Postfix'=>'');
                               // $seaArr[]=array('Search_On'=>'item_type', 'Search_Value'=>$item_type, 'Type'=>'string', 'Equation'=>'=', 'CondType'=>'AND', 'Prefix'=>'', 'Postfix'=>'');

                                $data = $ObjServicePageIndexMaster->getServicePageName($fieldArr,$seaArr);
                                $servicePageDetail = $data[0];
                                /*echo "<pre>";
                                print_r($data);
                                echo "</pre>";*/
                                if(!empty($servicePageDetail))
                                {
                                   // $dim_status = $servicePageDetail['dim_status'];
                                    $length_max = $servicePageDetail['length_max'];
                                    $girth_max = $servicePageDetail['girth_max'];
                            ?>
                            <div class="form-group">
                            <!--<input type="hidden" id="qty_max_<?php echo filter_var($i,FILTER_VALIDATE_INT); ?>" name="qty_max[]" value="<?php if($qty_status == '1'){echo $servicePageDetail['qty_max'];} ?>" />
                            <input type="hidden" id="qty_min_<?php echo filter_var($i,FILTER_VALIDATE_INT); ?>" name="qty_min[]" value="<?php if($qty_status == '1'){ echo $servicePageDetail['qty_min'];}?>" />
                            <input type="hidden" id="weight_max_<?php echo filter_var($i,FILTER_VALIDATE_FLOAT); ?>" name="weight_max[]" value="<?php if($weight_status == '1'){ echo $servicePageDetail['weight_max'];} ?>" />
                            <input type="hidden" id="weight_min_<?php echo filter_var($i,FILTER_VALIDATE_FLOAT); ?>" name="weight_min[]" value="<?php if($weight_status == '1'){echo $servicePageDetail['weight_min'];}?>" />
                            <input type="hidden" id="length_max_<?php echo filter_var($i,FILTER_VALIDATE_INT); ?>" name="length_max[]" value="<?php if($dim_status==1){ echo $servicePageDetail['length_max'];} ?>" />
                            <input type="hidden" id="length_min_<?php echo filter_var($i,FILTER_VALIDATE_INT); ?>" name="length_min[]" value="<?php if($dim_status==1){echo $servicePageDetail['length_min'];}?>" />
                            <input type="hidden" id="width_max_<?php echo filter_var($i,FILTER_VALIDATE_INT); ?>" name="width_max[]" value="<?php if($dim_status==1){ echo $servicePageDetail['width_max'];} ?>" />
                            <input type="hidden" id="width_min_<?php echo filter_var($i,FILTER_VALIDATE_INT); ?>" name="width_min[]" value="<?php if($dim_status==1){ echo $servicePageDetail['width_min'];}?>" />
                            <input type="hidden" id="height_max_<?php echo filter_var($i,FILTER_VALIDATE_INT); ?>" name="height_max[]" value="<?php if($dim_status==1){ echo $servicePageDetail['height_max'];} ?>" />
                            <input type="hidden" id="height_min_<?php echo filter_var($i,FILTER_VALIDATE_INT); ?>" name="height_min[]" value="<?php if($dim_status==1){ echo $servicePageDetail['height_min']; } ?>" />-->
                            <input type="hidden" id="length_max_<?php echo filter_var($i,FILTER_VALIDATE_INT); ?>" name="length_max[]" value="<?php if(isset($servicePageDetail['length_max'])){ echo $servicePageDetail['length_max'];} ?>" />
                            <input type="hidden" id="girth_max_<?php echo filter_var($i,FILTER_VALIDATE_INT); ?>" name="girth_max[]" value="<?php if(isset($servicePageDetail['girth_max'])){ echo $servicePageDetail['girth_max'];} ?>" />
                            </div>
                            <?php
                                }
                            ?>
                        <!--===All hidden values from database==-->
                        </div>
                        <?php
                            $i=$i+1; $k++;
                            $lastval =$i;
                            }

                        }else{
                        ?>
                        <div id="1" class="controls controls-row">
                        <span  class="control-group white-space extra_width-booking_qty form-group">
                            <label for="weight" class="control-label lebel_index-width"><?php echo COMMON_QTY; ?>&nbsp;&nbsp;<i class="icon-plus icon_index-width control-label"></i></label>
                            <input type="text" name="Item_qty[]" id="Item_qty_1" class="float_none span6" onblur="display_total_value();" value="1">
                            <span class="help-block alert-error" id="Items_qty_1"></span>
                        </span>
                        <span  class="control-group white-space extra_width-booking_type form-group">
                            <label for="selShippingType[]" class="control-label lebel_index-width"><?php echo SELECT_PACKAGE_TYPE; ?>&nbsp;&nbsp;&nbsp;<i class="icon-question-sign icon_index-width control-label"></i></label>
                            <div id="servicePageItem_1">
                            <?php
                            if(isset($_POST['selShippingType'][0]))
                            {
                                $item=filter_var($_POST['selShippingType'][0],FILTER_VALIDATE_INT);
                            }elseif(isset($BookingItemvalue->item_type)){
                                $item=filter_var($BookingItemvalue->item_type,FILTER_VALIDATE_INT);
                            }else{
                                $item =0;
                            }
                            //echo "item:".$item."</br>";
                            $extra_para ="class='float_none span10'";
                            echo getItemType($item,'5',$extra_para,1,'domestic');

                            ?>
                            </div>

                            <span class="help-block alert-error" id="selShippingTypes_1"></span>
                        </span>
                        <span  class="control-group white-space extra_width-booking form-group">
                        <label for="weight" class="control-label lebel_index-width"><?php echo COMMON_WEIGHT; ?>&nbsp;&nbsp;<i class="icon-download-alt icon_index-width control-label"></i></label>
                        <input type="text" id="Item_weight_1" class="input-mini border-radius-none form-control"   value="<?php if(isset($_POST["Item_weight"]) && $_POST["Item_weight"]!=""){echo filter_var($_POST["Item_weight"],FILTER_VALIDATE_FLOAT);}?>" placeholder="kg" name="Item_weight[]" title="<?php echo $item_weight_tooltip;?>" <?php echo $weight_display; ?> onblur="display_total_value();" autocomplete="off" maxlength="5" size="5" onkeyup="return numberDecimal(this.value,'<?php echo 'Item_weight_1' ;?>','booking');"/>
                        <span class="help-block alert-error" id="Items_weight_1"></span>

                        </span>&nbsp;&nbsp;
                        <span class="control-group white-space extra_width-booking form-group">
                        <label for="length"  class="control-label lebel_index-width"><?php echo COMMON_LENGTH; ?>&nbsp;&nbsp;&nbsp;<i class="icon-resize-horizontal icon_index-width control-label"></i></label>
                        <input type="text" class="input-mini border-radius-none form-control"  placeholder="cm"  name="Item_length[]" title="<?php echo $item_length_tooltip;?>" id="Item_length_1" value="<?php if(isset($_POST['Item_length']) && $_POST['Item_length']!=""){echo filter_var($_POST["Item_length"],FILTER_VALIDATE_FLOAT);}?>" <?php echo $dim_display; ?> onblur="display_total_value();" autocomplete="off"/>
                        <span class="help-block alert-error" id="Items_length_1"></span>
                        </span>&nbsp;&nbsp;
                        <span class="control-group white-space extra_width-booking form-group">
                        <label for="width" class="control-label lebel_index-width"><?php echo COMMON_WIDTH; ?>&nbsp;&nbsp;&nbsp;<i class="icon-resize-horizontal icon_index-width control-label"></i></label>
                        <input type="text" class="input-mini border-radius-none form-control"  placeholder="cm" name="Item_width[]" title="<?php echo $item_width_tooltip;?>" id="Item_width_1" onchange="round_up(this.id,this.value,1);" <?php echo $dim_display; ?> value="<?php if(isset($_POST['Item_width']) && $_POST['Item_width']!=""){echo filter_var($_POST["Item_width"],FILTER_VALIDATE_FLOAT);}?>" onblur="display_total_value();" autocomplete="off"/>
                        <span class="help-block alert-error" id="Items_width_1"></span>
                        </span>&nbsp;&nbsp;
                        <span class="control-group white-space extra_width-booking form-group">
                        <label for="height" class="control-label lebel_index-width"><?php echo COMMON_HEIGHT; ?>&nbsp;&nbsp;&nbsp;<i class="icon-resize-vertical icon_index-width control-label"></i></label>
                        <input type="text" class="input-mini border-radius-none form-control"  placeholder="cm" id="Item_height_1" title="<?php echo $item_height_tooltip;?>" name="Item_height[]" value="<?php if(isset($_POST['Item_height']) && $_POST['Item_height']!=""){echo filter_var($_POST["Item_height"],FILTER_VALIDATE_FLOAT);}?>"  <?php echo $dim_display; ?> onblur="display_total_value();" autocomplete="off"/>
                        <span class="help-block alert-error" id="Items_height_1"></span>
                        </span>
                        <span class="control-group white-space"><a href="#plus"  class="add_field_button"><i id="#plus" class="icon-plus-sign icon_plus_size"></i></a>
                        </span>
                        <?php
                                $fieldArr=array("*");
                                $seaArr = array();
                                /**
                                 * changinge service_item_type because currently from backened 
                                 * selShippingType is coming from servicepage type as domestic(table service_page_item)
                                 * so all validation will be applied for interstate and metro will be considered domestic
                                 */
                                $service_item_type = $service_page_item;
                               // $service_item_type = 'domestic';
                               // echo $service_page_item."---".$item."</br>";
                                $item_type = $item;
                                $seaArr[]=array('Search_On'=>'service_page_name', 'Search_Value'=>$service_item_type, 'Type'=>'string', 'Equation'=>'=', 'CondType'=>'AND', 'Prefix'=>'', 'Postfix'=>'');
                               // $seaArr[]=array('Search_On'=>'item_type', 'Search_Value'=>$item_type, 'Type'=>'string', 'Equation'=>'=', 'CondType'=>'AND', 'Prefix'=>'', 'Postfix'=>'');

                                $data = $ObjServicePageIndexMaster->getServicePageName($fieldArr,$seaArr);
                                $servicePageDetail = $data[0];
                                /*echo "<pre>";
                                print_r($data);
                                echo "</pre>";*/
                                if(!empty($servicePageDetail))
                                {
                                   // $dim_status = $servicePageDetail['dim_status'];
                                    $length_max = $servicePageDetail['length_max'];
                                    $girth_max = $servicePageDetail['girth_max'];
                                }
                                    
                            ?>
                        <!--=== All hidden values from database ==-->
                        <div class="form-group">
                        <!--<input type="hidden" id="qty_max_1" name="qty_max[]" value="<?php echo filter_var($qty_max,FILTER_VALIDATE_INT); ?>" />
                        <input type="hidden" id="qty_min_1" name="qty_min[]" value="<?php echo filter_var($qty_min,FILTER_VALIDATE_INT);?>" />
                        <input type="hidden" id="weight_max_1" name="weight_max[]" value="<?php echo filter_var($weight_max,FILTER_VALIDATE_INT); ?>" />
                        <input type="hidden" id="weight_min_1" name="weight_min[]" value="<?php echo filter_var($weight_min,FILTER_VALIDATE_INT);?>" />
                        <input type="hidden" id="length_max_1" name="length_max[]" value="<?php echo filter_var($length_max,FILTER_VALIDATE_INT); ?>" />
                        <input type="hidden" id="length_min_1" name="length_min[]" value="<?php echo filter_var($length_min,FILTER_VALIDATE_INT);?>" />
                        <input type="hidden" id="width_max_1" name="width_max[]" value="<?php echo filter_var($width_max,FILTER_VALIDATE_INT); ?>" />
                        <input type="hidden" id="width_min_1" name="width_min[]" value="<?php echo filter_var($width_min,FILTER_VALIDATE_INT);?>" />
                        <input type="hidden" id="height_max_1" name="height_max[]" value="<?php echo filter_var($height_max,FILTER_VALIDATE_INT); ?>" />
                        <input type="hidden" id="height_min_1" name="height_min[]" value="<?php echo filter_var($height_min,FILTER_VALIDATE_INT);?>" />-->
                        <input type="hidden" id="length_max_1" name="length_max[]" value="<?php //echo filter_var($length_max,FILTER_VALIDATE_INT); ?>" />
                        <input type="hidden" id="girth_max_1" name="girth_max[]" value="<?php //echo filter_var($girth_max,FILTER_VALIDATE_INT); ?>" />
           
                        </div>
                        <!--===All hidden values from database==-->
                        </div>
                        <?php
                        }
                        ?>
        <!--	****	Hidden Domestic Items 	****		-->

                    <div  class="row-fluid hide" id="optionTemplate">
                        <div class="controls controls-row" id="1">
                        <span  class="control-group white-space extra_width-booking_qty form-group">
                            <!--<label for="weight"  class="control-label lebel_index-width"><?php echo COMMON_QTY; ?>&nbsp;&nbsp;<i class="icon-plus icon_index-width control-label"></i></label>-->
                            <input type="text" name="Item_qty[]" id="Item_qty_1" class="float_none span6" onblur="display_total_value();" value="1">

                            <span class="help-block alert-error" id="Items_qty_1"></span>
                        </span>
                        <span  class="control-group white-space extra_width-booking_type form-group">
                            <!--<label for="weight" class="control-label lebel_index-width"><?php echo SELECT_PACKAGE_TYPE; ?>&nbsp;&nbsp;<i class="icon-question-sign icon_index-width control-label"></i></label>-->
                            <div id="servicePageItem_1" class="separate">
                            <?php
                            if(isset($_POST['selShippingType'][0]))
                            {
                                $item=filter_var($_POST['selShippingType'][0],FILTER_VALIDATE_INT);
                            }elseif(isset($BookingItemvalue->item_type)){
                                $item=filter_var($BookingItemvalue->item_type,FILTER_VALIDATE_INT);
                            }else{
                                $item =0;
                            }
                            $extra_para ="class='float_none span10'";
                            echo getItemType($item,'5',$extra_para,1,'domestic');

                            ?>


                            </div>
                            <span class="help-block alert-error" id="selShippingTypes_1"></span>
                        </span>
                        <span  class="control-group white-space extra_width-booking form-group">
                        <!--<label for="weight" class="control-label lebel_index-width control-label"><?php echo COMMON_WEIGHT; ?>&nbsp;&nbsp;&nbsp;<i class="icon-download-alt icon_index-width control-label"></i></label>-->
                        <input type="text" id="Item_weight_1"  class="input-mini border-radius-none form-control"  value="<?php if(isset($_POST["Item_weight"]) && $_POST["Item_weight"]!=""){echo filter_var($_POST["Item_weight"],FILTER_VALIDATE_FLOAT);}?>" placeholder="kg"  name="Item_weight[]" onblur="display_total_value();" title="<?php echo $item_weight_tooltip;?>" <?php echo $weight_display; ?> autocomplete="off" maxlength="5" size="5" onkeyup="numberDecimal(this.value,'<?php echo "Item_weight_1";?>','booking');"/>
                        <span class="help-block alert-error"  id="Items_weight_1"></span>
                        <!--<button type="button" class="btn btn-default removeButton"><i class="icon-minus-sign icon_plus_size"></i></button>-->
                        </span>&nbsp;&nbsp;
                        <span class="control-group white-space extra_width-booking form-group">
                        <!--<label for="length"  class="control-label lebel_index-width"><?php echo COMMON_LENGTH; ?>&nbsp;&nbsp;&nbsp;<i class="icon-resize-horizontal icon_index-width control-label"></i></label>-->
                        <input type="text" id="Item_length_1" class="input-mini border-radius-none form-control" placeholder="cm"  title="<?php echo $item_length_tooltip;?>" name="Item_length[]"  value="<?php if(isset($_POST['Item_length']) && $_POST['Item_length']!=""){echo filter_var($_POST["Item_length"],FILTER_VALIDATE_FLOAT);}?>" <?php echo $dim_display; ?>  onblur="display_total_value();" autocomplete="off"/>
                        <span class="help-block alert-error" id="Items_length_1"></span>

                        </span>&nbsp;&nbsp;
                        <span class="control-group white-space extra_width-booking form-group">
                        <!--<label for="width" class="control-label lebel_index-width"><?php echo COMMON_WIDTH; ?>&nbsp;&nbsp;&nbsp;<i class="icon-resize-horizontal icon_index-width control-label"></i></label>-->
                        <input type="text" id="Item_width_1" class="input-mini border-radius-none form-control" placeholder="cm" title="<?php echo $item_width_tooltip;?>" name="Item_width[]"  onchange="round_up(this.id,this.value,1);" <?php echo $dim_display; ?> value="<?php if(isset($_POST['Item_width']) && $_POST['Item_width']!=""){echo filter_var($_POST["Item_width"],FILTER_VALIDATE_FLOAT);}?>" autocomplete="off"/>
                        <span class="help-block alert-error" id="Items_width_1"></span>

                        </span>&nbsp;&nbsp;
                        <span class="control-group white-space extra_width-booking form-group">
                        <!--<label for="height" class="control-label lebel_index-width"><?php echo COMMON_HEIGHT; ?>&nbsp;&nbsp;&nbsp;<i class="icon-resize-vertical icon_index-width control-label"></i></label>-->
                        <input type="text" class="input-mini border-radius-none form-control" placeholder="cm" id="Item_height_1" title="<?php echo $item_height_tooltip;?>" name="Item_height[]" value="<?php if(isset($_POST['Item_height']) && $_POST['Item_height']!=""){echo filter_var($_POST["Item_height"],FILTER_VALIDATE_FLOAT);}?>" onchange="round_up(this.id,this.value,1);" <?php echo $dim_display; ?> onblur="display_total_value();" autocomplete="off"/>
                        <span class="help-block alert-error" id="Items_height_1"></span>
                        </span>
                        <span class="control-group white-space">

                        <a href="#minus"  onclick="javascript:DelSizeDataRow(1)" class="removeButton" ><i class="icon-minus-sign icon_plus_size" id="#minus"></i>
                        </a>
                        </span>
                        <?php
                        $fieldArr=array("*");
                        $seaArr = array();
                        /**
                         * changinge service_item_type because currently from backened 
                         * selShippingType is coming from servicepage type as domestic(table service_page_item)
                         * so all validation will be applied for interstate and metro will be considered domestic
                         */
                        $service_item_type = $service_page_item;
                        // $service_item_type = 'domestic';
                        // echo $service_page_item."---".$item."</br>";
                        $item_type = $item;
                        $seaArr[]=array('Search_On'=>'service_page_name', 'Search_Value'=>$service_item_type, 'Type'=>'string', 'Equation'=>'=', 'CondType'=>'AND', 'Prefix'=>'', 'Postfix'=>'');
                        // $seaArr[]=array('Search_On'=>'item_type', 'Search_Value'=>$item_type, 'Type'=>'string', 'Equation'=>'=', 'CondType'=>'AND', 'Prefix'=>'', 'Postfix'=>'');

                        $data = $ObjServicePageIndexMaster->getServicePageName($fieldArr,$seaArr);
                        $servicePageDetail = $data[0];
                        /*echo "<pre>";
                        print_r($data);
                        echo "</pre>";*/
                        if(!empty($servicePageDetail))
                        {
                        // $dim_status = $servicePageDetail['dim_status'];
                            $length_max = $servicePageDetail['length_max'];
                            $girth_max = $servicePageDetail['girth_max'];
                        }
                            
                        ?>
                       
                        <!--=== All hidden values from database ==-->
                        <div class="form-group">
                        <!--<input type="hidden" id="qty_max_1" name="qty_max[]" value="<?php echo filter_var($qty_max,FILTER_VALIDATE_INT); ?>" />
                        <input type="hidden" id="qty_min_1" name="qty_min[]" value="<?php echo filter_var($qty_min,FILTER_VALIDATE_INT);?>" />
                        <input type="hidden" id="weight_max_1" name="weight_max[]" value="<?php echo filter_var($weight_max,FILTER_VALIDATE_INT); ?>" />
                        <input type="hidden" id="weight_min_1" name="weight_min[]" value="<?php echo filter_var($weight_min,FILTER_VALIDATE_INT);?>" />
                        <input type="text" id="length_max_1" name="length_max[]" value="<?php echo filter_var($length_max,FILTER_VALIDATE_INT); ?>" />
                        <input type="hidden" id="length_min_1" name="length_min[]" value="<?php echo filter_var($length_min,FILTER_VALIDATE_INT);?>" />
                        <input type="hidden" id="width_max_1" name="width_max[]" value="<?php echo filter_var($width_max,FILTER_VALIDATE_INT); ?>" />
                        <input type="hidden" id="width_min_1" name="width_min[]" value="<?php echo filter_var($width_min,FILTER_VALIDATE_INT);?>" />
                        <input type="hidden" id="height_max_1" name="height_max[]" value="<?php echo filter_var($height_max,FILTER_VALIDATE_INT); ?>" />
                        <input type="hidden" id="height_min_1" name="height_min[]" value="<?php echo filter_var($height_min,FILTER_VALIDATE_INT);?>" />
                        Length1<input type="text" id="length_max_1" name="length_max[]" value="<?php echo filter_var($length_max,FILTER_VALIDATE_INT); ?>" />
                        Girth1<input type="text" id="girth_max_1" name="girth_max[]" value="<?php echo filter_var($girth_max,FILTER_VALIDATE_INT); ?>" />-->
    
                        </div>
                        <!--===All hidden values from database==-->
                        </div>
                    </div>

        <!--	****	Hidden Domestic Items 	****		-->
                    </div>
                    <!--	****	Dimentions International 	****		-->
                    <div class="row-fluid" id="size_display_block_international" style="display:<?php if($bookingvalue->flag =="international" || $_POST['flage'] == '2' ){ echo "block;"; }else{ echo "none;";} ?>">
                    <?php
                    if(($bookingvalue->flag =="international" && !isset($_GET['action']) && !empty($BookingItemDetailsData)) || ($_POST['flage'] == '2' && !empty($BookingItemDetailsData))){
                    $i=1;
                    $k=0;
                    $intlastval =1;
                    foreach ($BookingItemDetailsData as $booingItemValue)
                    {


                        if(isset($booingItemValue->item_type) && $booingItemValue->item_type=='4')
                        {
                            $doc_active = 'active';
                            $doc_chk = 'checked';
                        }
                        if(isset($booingItemValue->item_type) && $booingItemValue->item_type=='5')
                        {
                            $nondoc_active = 'active';
                            $nondoc_chk = 'checked';
                        }
                        if(isset($booingItemValue->item_type)){
                            $inter_item=filter_var($booingItemValue->item_type,FILTER_VALIDATE_INT);
                        }
                        if(isset($int_item_type) && $int_item_type == '4'){
                            $doc_active = 'active';
                            $doc_chk = 'checked';
                        }
                        if(isset($int_item_type) && $int_item_type == '5'){
                            $nondoc_active = 'active';
                            $nondoc_chk = 'checked';
                        }
                        //echo $int_item_type;
                        $service_page_item = 'international';
                    ?>
                    <?php if($i==1){ ?>
                     <div class="row-fluid tab-underline" >
                        <ul class="nav nav-tabs tabs">
                            <li id="doc_1" class="<?php echo $doc_active; ?>">
                                <label class="radio">
                                   <!-- <input type="radio" name="inter_ShippingType_1[]" value="4" <?php //echo $doc_chk; ?> onclick="javascript:selectedInterItems(this.value);"> Documents-->
                                    <input type="radio" name="inter_ShippingType_1[]" value="4" <?php echo $doc_chk; ?>> Documents
                                </label>
                            </li>
                            <li id="doc_2" class="<?php echo $nondoc_active; ?>">
                                <label class="radio">
                                    <!--<input type="radio" name="inter_ShippingType_1[]" <?php  echo $nondoc_chk;?> value="5" onclick="javascript:selectedInterItems(this.value);"> Non Documents-->
                                    <input type="radio" name="inter_ShippingType_1[]" <?php  echo $nondoc_chk;?> value="5"> Non Documents
                                </label>

                            </li>
                        </ul>
                    </div>
                     <?php }
                        ?>
                      <div id="<?php echo filter_var($i,FILTER_VALIDATE_INT); ?>" class="controls controls-row">
                            <span  class="control-group white-space extra_width-booking_qty form-group">
                            <?php if(isset($i) && $i===1){?>
                            <label for="weight" class="control-label lebel_index-width"><?php echo COMMON_QTY; ?>&nbsp;&nbsp;<i class="icon-plus icon_index-width control-label"></i></label>
                            <?php } ?>
                            <input type="text" class="float_none span6" name="qty_item[]" id="qty_item_<?php echo filter_var($i,FILTER_VALIDATE_INT); ?>" onchange="totalInterVal();" value="<?php if(isset($booingItemValue->quantity) && $booingItemValue->quantity!=""){echo $booingItemValue->quantity;}else{echo "1";} ?>">
                            <span class="help-block alert-error" id="qty_items_<?php echo filter_var($i,FILTER_VALIDATE_INT); ?>"><?php if(isset($multi_err['intqtyError'][$k])){ ?><small style="" class="help-block" data-bv-validator="callback" data-bv-for="qty_item[]" data-bv-result="INVALID"><?php echo $multi_err['intqtyError'][$k]; ?></small><?php } ?></span>
                            <?php if(isset($multi_err['intqtyError'][$k])) { ?>
                            <!-- PHP Validation	-->
                            <!--<div class="alert alert-error show" id="qty_err_<?php echo filter_var($i,FILTER_VALIDATE_INT); ?>_css">-->
                                <span class="help-block has-error alert-error" id="qty_err_<?php echo filter_var($i,FILTER_VALIDATE_INT); ?>_css"><small style="" class="help-block" data-bv-validator="callback" data-bv-for="qty_item[]" data-bv-result="INVALID"><?php echo $multi_err['intqtyError'][$k];?></small></span>
                            <!--</div>-->
                            <!--	End PHP Validation	-->
                            <?php } ?>
                        </span>
                        <span  class=" control-group white-space extra_width-booking  form-group">
                            <?php if(isset($i) && $i===1){?>
                            <label for="weight" class="control-label lebel_index-width"><?php echo COMMON_WEIGHT; ?>&nbsp;&nbsp;&nbsp;<i class="icon-download-alt icon_index-width control-label"></i></label>
                            <?php } ?>
                            <input type="text" id="<?php echo "weight_item_".filter_var($i,FILTER_VALIDATE_INT);?>" class="input-mini border-radius-none form-control" onblur="totalInterVal();" onkeypress="javascript:removeError('weight_items_err_<?php echo filter_var($i,FILTER_VALIDATE_INT); ?>');"  value="<?php if(isset($booingItemValue->item_weight) && $booingItemValue->item_weight!=""){ echo $booingItemValue->item_weight;}  ?>" placeholder="kg" name="weight_item[]" title="<?php echo $item_weight_tooltip;?>" <?php echo $weight_display; ?> autocomplete="off" maxlength="5" size="5" onkeyup="numberDecimal(this.value,'<?php echo "weight_item_".filter_var($i,FILTER_VALIDATE_INT);?>','booking');"/>
                            <span class="autocomplete_index help-block alert-error" id="weight_items_<?php echo filter_var($i,FILTER_VALIDATE_INT); ?>"></span>
                                <?php if(isset($multi_err['weightError'][$k])){ ?>
                                <!-- PHP Validation	-->
                                <!--<div class="alert alert-error show" id="weight_items_err_<?php echo filter_var($i,FILTER_VALIDATE_INT); ?>">-->
                                    <span class="help-block has-error alert-error" id="weight_items_err_<?php echo filter_var($i,FILTER_VALIDATE_INT); ?>"><small style="" class="help-block" data-bv-validator="callback" data-bv-for="weight_item[]" data-bv-result="INVALID"><?php echo $multi_err['intweightError'][$k]; ?></small></span>
                                <!--</div>-->
                                <!--	End PHP Validation	-->
                                <?php } ?>
                            </span>&nbsp;&nbsp;
                            <span class="control-group white-space extra_width-booking form-group">
                            <?php if(isset($i) && $i===1){?>
                            <label for="length"  class="control-label lebel_index-width"><?php echo COMMON_LENGTH; ?>&nbsp;&nbsp;&nbsp;<i class="icon-resize-horizontal icon_index-width control-label"></i></label>
                            <?php } ?>
                            <input type="text" class="input-mini border-radius-none form-control" placeholder="cm"  name="length_item[]" onblur="totalInterVal();" onkeypress="javascript:removeError('length_items_err_<?php echo filter_var($i,FILTER_VALIDATE_INT); ?>');"  value="<?php if(isset($booingItemValue->length) && $booingItemValue->length!=""){ echo $booingItemValue->length;}  ?>" title="<?php echo $length_item_tooltip;?>" id="<?php echo "length_item_".filter_var($i,FILTER_VALIDATE_INT)?>" <?php if(isset($BookingItemvalue->dim_status) && $BookingItemvalue->dim_status==0)
                                    { echo "readonly"; } ?> autocomplete="off" />
                            <span class="help-block alert-error" id="length_items_<?php echo filter_var($i,FILTER_VALIDATE_INT); ?>"></span>
                            <?php if(isset($multi_err['intlengthError'][$k])){ ?>
                                <!-- PHP Validation	-->
                                <!--<div class="alert alert-error show" id="length_items_err_<?php echo filter_var($i,FILTER_VALIDATE_INT); ?>">-->
                                    <span class="help-block has-error alert-error" id="length_items_err_<?php echo filter_var($i,FILTER_VALIDATE_INT); ?>"><small style="" class="help-block" data-bv-validator="callback" data-bv-for="length_item[]" data-bv-result="INVALID"><?php echo $multi_err['intlengthError'][$k]; ?></small></span>
                                <!--</div>-->
                                <!--	End PHP Validation	-->
                            <?php } ?>
                            </span>&nbsp;&nbsp;
                            <span class="control-group white-space extra_width-booking form-group">
                            <?php if(isset($i) && $i===1){?>
                            <label for="width" class="control-label lebel_index-width"><?php echo COMMON_WIDTH; ?>&nbsp;&nbsp;&nbsp;<i class="icon-resize-horizontal icon_index-width control-label"></i></label>
                            <?php } ?>
                            <input type="text" class="input-mini border-radius-none form-control" placeholder="cm" name="width_item[]" onblur="totalInterVal();" id="<?php echo "width_item_".filter_var($i,FILTER_VALIDATE_INT)?>" onkeypress="javascript:removeError('width_items_err_<?php echo filter_var($i,FILTER_VALIDATE_INT); ?>');" onchange="round_up(this.id,this.value,1);"  title="<?php echo $width_items_tooltip;?>" value="<?php if(isset($booingItemValue->width) && $booingItemValue->width!=""){ echo $booingItemValue->width;}  ?>" <?php if(isset($BookingItemvalue->dim_status) && $BookingItemvalue->dim_status==0)
                                    { echo "readonly"; } ?> autocomplete="off" />
                            <span class="help-block alert-error" id="width_items_<?php echo filter_var($i,FILTER_VALIDATE_INT); ?>"></span>
                            <?php if(isset($multi_err['intwidthError'][$k])){ ?>
                                <!-- PHP Validation	-->
                                <!--<div class="alert alert-error show" id="Items_width_err_<?php echo filter_var($i,FILTER_VALIDATE_INT); ?>">-->
                                    <span class="help-block has-error alert-error" id="Items_width_err_<?php echo filter_var($i,FILTER_VALIDATE_INT); ?>"><small style="" class="help-block" data-bv-validator="callback" data-bv-for="width_item[]" data-bv-result="INVALID"><?php echo $multi_err['intwidthError'][$k]; ?></small></span>
                                <!--</div>-->
                                <!--	End PHP Validation	-->
                            <?php } ?>
                            </span>&nbsp;&nbsp;
                            <span class="control-group white-space extra_width-booking form-group">
                            <?php if(isset($i) && $i===1){?>
                            <label for="height" class="control-label lebel_index-width"><?php echo COMMON_HEIGHT; ?>&nbsp;&nbsp;&nbsp;<i class="icon-resize-vertical icon_index-width control-label"></i></label>
                            <?php } ?>
                            <input type="text" class="input-mini border-radius-none form-control" placeholder="cm" id="<?php echo "height_item_".filter_var($i,FILTER_VALIDATE_INT)?>" name="height_item[]" title="<?php echo $height_item_tooltip;?>" onkeypress="javascript:removeError('height_items_err_<?php echo filter_var($i,FILTER_VALIDATE_INT); ?>');" onblur="totalInterVal();" value="<?php if(isset($booingItemValue->height) && $booingItemValue->height!=""){ echo $booingItemValue->height;}  ?>"  <?php if(isset($BookingItemvalue->dim_status) && $BookingItemvalue->dim_status==0)
                                    { echo "readonly"; } ?> autocomplete="off"/>
                            <span class="help-block alert-error" id="height_items_<?php echo filter_var($i,FILTER_VALIDATE_INT); ?>"></span>
                            <?php if(isset($multi_err['heightError'][$k])){ ?>
                                <!-- PHP Validation	-->
                                <!--<div class="alert alert-error show" id="height_items_err_<?php echo filter_var($i,FILTER_VALIDATE_INT); ?>">-->
                                    <span class="help-block has-error alert-error" id="height_items_err_<?php echo filter_var($i,FILTER_VALIDATE_INT); ?>"><small style="" class="help-block" data-bv-validator="callback" data-bv-for="height_item[]" data-bv-result="INVALID"><?php echo $multi_err['heightError'][$k]; ?></small></span>
                                <!--</div>-->
                                <!--	End PHP Validation	-->
                            <?php } ?>
                            </span>
                            <?php if($i==1){ ?>
                            <span class="control-group white-space"><a href="#plus"  class="add_inter_button"><i id="#plus" class="icon-plus-sign icon_plus_size"></i></a></span>
                            <?php }else{ ?>
                            <span class="control-group white-space">
                            <a href="#minus" onclick="javascript:DelSizeDataRow('<?php echo $i; ?>');"  class="removeButton" ><i class="icon-minus-sign icon_plus_size" id="#minus"></i>
                            </a>
                            </span>
                            <?php } ?>

                        </div>
                   <?php
                     $i=$i+1; $k++;
                     $intlastval =$i;
                    }}else{
                        $doc_active = 'active';
                        $doc_chk = 'checked';
                        if(isset($_POST['inter_ShippingType_1'][0]) && $_POST['inter_ShippingType_1'][0]=="4")
                        {
                            $doc_active = 'active';
                            $doc_chk = 'checked';
                        }
                        if(isset($_POST['inter_ShippingType_1'][0]) && $_POST['inter_ShippingType_1'][0]=="5")
                        {
                            $nondoc_active = 'active';
                            $nondoc_chk = 'checked';
                        }
                    ?>
                    <div id="1" class="controls controls-row">
                         <div class="row-fluid tab-underline" >
                            <ul class="nav nav-tabs tabs">
                            <li id="doc_1" class="<?php echo $doc_active; ?>">
                                <label class="radio">
                                   <!-- <input type="radio" name="inter_ShippingType_1[]" value="4" <?php echo $doc_chk; ?> onclick="javascript:selectedInterItems(this.value);"> Documents-->
                                    <input type="radio" name="inter_ShippingType_1[]" value="4" <?php echo $doc_chk; ?> > Documents

                                </label>
                            </li>
                            <li id="doc_2" class="<?php echo $nondoc_active; ?>">
                                <label class="radio">
                                    <!--<input type="radio" name="inter_ShippingType_1[]" <?php  echo $nondoc_chk;?> value="5" onclick="javascript:selectedInterItems(this.value);"> Non Documents-->
                                    <input type="radio" name="inter_ShippingType_1[]" <?php  echo $nondoc_chk;?> value="5"> Non Documents

                                </label>

                            </li>
                        </ul>
                        </div>

                        <span  class="control-group white-space extra_width-booking_qty form-group">
                        <label for="weight" class="control-label lebel_index-width"><?php echo COMMON_QTY; ?>&nbsp;&nbsp;<i class="icon-plus icon_index-width control-label"></i></label>
                            <input type="text" name="qty_item[]" id="qty_item_1" class="float_none span6"  onchange="totalInterVal();" value="1" />
                            <span class="help-block alert-error" id="qty_items_1"></span>
                        </span>
                        <span  class="control-group white-space extra_width-booking form-group">
                        <label for="weight" class="control-label lebel_index-width"><?php echo COMMON_WEIGHT; ?>&nbsp;&nbsp;<i class="icon-download-alt icon_index-width control-label"></i></label>
                        <input type="text" id="weight_item_1" class="input-mini border-radius-none form-control"  value="<?php if(isset($_POST["weight_item"]) && $_POST["weight_item"]!=""){echo filter_var($_POST["weight_item"],FILTER_VALIDATE_FLOAT);}?>" placeholder="kg" name="weight_item[]" title="<?php echo $weight_item_tooltip;?>" onblur="totalInterVal();" autocomplete="off" maxlength="5" size="5" onkeyup="numberDecimal(this.value,'<?php echo "weight_item_1";?>','booking');"/>
                        <span class="help-block alert-error" id="weight_items_1"></span>

                        </span>&nbsp;&nbsp;
                        <span class="control-group white-space extra_width-booking form-group">
                        <label for="length" class="control-label lebel_index-width"><?php echo COMMON_LENGTH; ?>&nbsp;&nbsp;&nbsp;<i class="icon-resize-horizontal icon_index-width"></i></label>
                        <input type="text" class="input-mini border-radius-none" placeholder="cm"  name="length_item[]" id="length_item_1" onblur="totalInterVal();" autocomplete="off"/>
                       <span class="help-block alert-error" id="length_items_1"></span>
                        </span>&nbsp;&nbsp;
                        <span class="control-group white-space extra_width-booking form-group">
                        <label for="width" class="control-label lebel_index-width"><?php echo COMMON_WIDTH; ?>&nbsp;&nbsp;&nbsp;<i class="icon-resize-horizontal icon_index-width"></i></label>
                        <input type="text" class="input-mini border-radius-none" placeholder="cm"  name="width_item[]" onblur="totalInterVal();" id="width_item_1" autocomplete="off"/>
                       <span class="help-block alert-error" id="width_items_1"></span>
                       </span>&nbsp;&nbsp;
                        <span class="control-group white-space extra_width-booking form-group">
                        <label for="height" class="control-label lebel_index-width"><?php echo COMMON_HEIGHT; ?>&nbsp;&nbsp;&nbsp;<i class="icon-resize-vertical icon_index-width"></i></label>
                        <input type="text" class="input-mini border-radius-none" placeholder="cm" id="height_item_1" name="height_item[]" autocomplete="off" onblur="totalInterVal();"/>
                        <span class="help-block alert-error" id="height_items_1"></span>
                        </span>
                         <span class="control-group white-space"><a href="#plus"  class="add_inter_button"><i id="#plus" class="icon-plus-sign icon_plus_size"></i></a>
                        </span>


                        </div>
                        <?php } ?>

                        <input type="hidden" name="international_total_weight" id="international_total_weight" />
                        <input type="hidden" name="international_chargeable_weight" id="international_chargeable_weight" />
                        <input type="hidden" name="international_total_volumetric_weight" id="international_total_volumetric_weight" />
                        <input type="hidden" name="international_total_volume" id="international_total_volume" />
                        <?php echo getItemTypeIndex($item,'5',$extra_para,null,'inter'); ?>
                        <!-- Hidden Dimesions for international -->
                        <div  class="row-fluid hide" id="optionIntTemplate">
                            <div class="controls controls-row" id="1">
                            <span  class="control-group white-space extra_width-booking_qty form-group">
                            <input type="text" name="qty_item[]" id="qty_item_1" class="float_none span6" onchange="totalInterVal();" value="1" />
                            <span class="help-block alert-error" id="qty_items_1"></span>
                        </span>
                            <span  class="control-group white-space extra_width-booking form-group">
                            <!--<label for="weight" class="control-label lebel_index-width control-label"><?php echo COMMON_WEIGHT; ?>&nbsp;&nbsp;&nbsp;<i class="icon-download-alt icon_index-width control-label"></i></label>-->
                            <input type="tel" id="weight_item_1" name="weight_item[]" onblur="totalInterVal();" class="input-mini border-radius-none form-control"  value="<?php if(isset($_POST["weight_item"]) && $_POST["weight_item"]!=""){echo filter_var($_POST["weight_item"],FILTER_VALIDATE_FLOAT);}?>" placeholder="kg"   title="<?php echo $item_weight_tooltip;?>" <?php echo $weight_display; ?> maxlength="5" size="5" onkeyup="numberDecimal(this.value,'<?php echo "weight_item_1";?>','booking');"/>
                            <span class="help-block alert-error" id="weight_items_1"></span>
                            </span>&nbsp;&nbsp;
                            <span class="control-group white-space extra_width-booking form-group">
                            <!--<label for="length"  class="control-label lebel_index-width"><?php echo COMMON_LENGTH; ?>&nbsp;&nbsp;&nbsp;<i class="icon-resize-horizontal icon_index-width control-label"></i></label>-->
                            <input type="tel" id="length_item_1" class="input-mini border-radius-none form-control" onblur="totalInterVal();" placeholder="cm"  name="length_item[]"  title="<?php echo $item_length_tooltip;?>" value="<?php if(isset($_POST['length_item']) && $_POST['length_item']!=""){echo filter_var($_POST["length_item"],FILTER_VALIDATE_FLOAT);}?>" <?php echo $dim_display; ?> />
                            <span class="help-block alert-error" id="length_items_1"></span>

                            </span>&nbsp;&nbsp;
                            <span class="control-group white-space extra_width-booking form-group">
                            <!--<label for="width" class="control-label lebel_index-width"><?php echo COMMON_WIDTH; ?>&nbsp;&nbsp;&nbsp;<i class="icon-resize-horizontal icon_index-width control-label"></i></label>-->
                            <input type="tel" id="width_item_1" class="input-mini border-radius-none form-control" onblur="totalInterVal();" placeholder="cm" title="<?php echo $item_width_tooltip;?>" name="width_item[]"  onchange="round_up(this.id,this.value,1);" <?php echo $dim_display; ?> value="<?php if(isset($_POST['width_item']) && $_POST['width_item']!=""){echo filter_var($_POST["width_item"],FILTER_VALIDATE_FLOAT);}?>"/>
                            <span class="help-block alert-error" id="width_items_1"></span>

                            </span>&nbsp;&nbsp;
                            <span class="control-group white-space extra_width-booking form-group">
                            <!--<label for="height" class="control-label lebel_index-width"><?php echo COMMON_HEIGHT; ?>&nbsp;&nbsp;&nbsp;<i class="icon-resize-vertical icon_index-width control-label"></i></label>-->
                            <input type="tel" onblur="totalInterVal();" class="input-mini border-radius-none form-control" placeholder="cm" id="height_item_1" name="height_item[]" title="<?php echo $item_height_tooltip;?>" value="<?php if(isset($_POST['height_item']) && $_POST['height_item']!=""){echo filter_var($_POST["height_item"],FILTER_VALIDATE_FLOAT);}?>" onchange="round_up(this.id,this.value,1);" <?php echo $dim_display; ?> />
                            <span class="help-block alert-error" id="height_items_1"></span>
                            </span>
                            <span class="control-group white-space">
                            <a href="#minus" onclick="javascript:DelSizeDataRow(1)"  class="removeButton" ><i class="icon-minus-sign icon_plus_size" id="#minus"></i>
                            </a>
                            </span>
                            </div>
                        </div>
                        <!-- Hidden Dimesions for international -->
                        <?php

                            /*if(isset($_POST['inter_ShippingType_1'][0]))
                            {
                                $inter_item=filter_var($_POST['inter_ShippingType_1'][0],FILTER_VALIDATE_INT);
                                $service_page_item = 'international';
                            }elseif(empty($inter_item)){
                                $inter_item =0;
                                $service_page_item = 'international';
                            }

                            $fieldArr=array("*");
                            $seaArr = array();
                            $service_item_type = $service_page_item;




                            $item_type = $inter_item;
                            $seaArr[]=array('Search_On'=>'service_page_name', 'Search_Value'=>$service_item_type, 'Type'=>'string', 'Equation'=>'=', 'CondType'=>'AND', 'Prefix'=>'', 'Postfix'=>'');
                            $seaArr[]=array('Search_On'=>'item_type', 'Search_Value'=>$item_type, 'Type'=>'string', 'Equation'=>'=', 'CondType'=>'AND', 'Prefix'=>'', 'Postfix'=>'');
                            $data = $ObjServicePageIndexMaster->getServicePageName($fieldArr,$seaArr);
                            $servicePageDetail = $data[0];
                            if(!empty($servicePageDetail))
                            {
                                $int_qty_max = $servicePageDetail['qty_max'];
                                $int_qty_min = $servicePageDetail['qty_min'];
                                $int_weight_max = $servicePageDetail['weight_max'];
                                $int_weight_min = $servicePageDetail['weight_min'];
                                $int_length_max = $servicePageDetail['length_max'];
                                $int_length_min = $servicePageDetail['length_min'];
                                $int_width_max = $servicePageDetail['width_max'];
                                $int_width_min = $servicePageDetail['width_min'];
                                $int_height_max = $servicePageDetail['height_max'];
                                $int_height_min = $servicePageDetail['height_min'];
                            }
                            */

                            $fieldArr=array("*");
                            $seaArr = array();
                            $seaArr[]=array('Search_On'=>'service_page_name', 'Search_Value'=>'international', 'Type'=>'string', 'Equation'=>'=', 'CondType'=>'AND', 'Prefix'=>'', 'Postfix'=>'');
                            //$seaArr[]=array('Search_On'=>'item_type', 'Search_Value'=>$item_type, 'Type'=>'string', 'Equation'=>'=', 'CondType'=>'AND', 'Prefix'=>'', 'Postfix'=>'');
                            $data = $ObjServicePageIndexMaster->getServicePageName($fieldArr,$seaArr);
                            $servicePageDetail = $data[0];
                            if(isset($servicePageDetail) && !empty($servicePageDetail)){
                                $int_length_max = $servicePageDetail['length_max'];
                                $int_girth_max = $servicePageDetail['girth_max'];
                            }
                           /* echo "<pre>";
                            print_r($servicePageDetail);
                            echo "</pre>";*/
                        ?>
                        <!--=== All hidden values from database ==-->
                        <div class="form-group">
                        <!--<input type="hidden" id="int_qty_max_1" name="int_qty_max[]" value="<?php echo filter_var($int_qty_max,FILTER_VALIDATE_INT); ?>" />
                        <input type="hidden" id="int_qty_min_1" name="int_qty_min[]" value="<?php echo filter_var($int_qty_min,FILTER_VALIDATE_INT);?>" />
                        <input type="hidden" id="int_weight_max_1" name="int_weight_max[]" value="<?php echo filter_var($int_weight_max,FILTER_VALIDATE_FLOAT); ?>" />
                        <input type="hidden" id="int_weight_min_1" name="int_weight_min[]" value="<?php echo filter_var($int_weight_min,FILTER_VALIDATE_FLOAT);?>" />
                        <input type="hidden" id="int_length_max_1" name="int_length_max[]" value="<?php echo filter_var($int_length_max,FILTER_VALIDATE_FLOAT); ?>" />
                        <input type="hidden" id="int_length_min_1" name="int_length_min[]" value="<?php echo filter_var($int_length_min,FILTER_VALIDATE_FLOAT);?>" />
                        <input type="hidden" id="int_width_max_1" name="int_width_max[]" value="<?php echo filter_var($int_width_max,FILTER_VALIDATE_FLOAT); ?>" />
                        <input type="hidden" id="int_width_min_1" name="int_width_min[]" value="<?php echo filter_var($int_width_min,FILTER_VALIDATE_FLOAT);?>" />
                        <input type="hidden" id="int_height_max_1" name="int_height_max[]" value="<?php echo filter_var($int_height_max,FILTER_VALIDATE_INT); ?>" />
                        <input type="hidden" id="int_height_min_1" name="int_height_min[]" value="<?php echo filter_var($int_height_min,FILTER_VALIDATE_INT);?>" />-->
                        <input type="hidden" id="int_length_max_1" name="int_length_max[]" value="<?php echo filter_var($int_length_max,FILTER_VALIDATE_INT); ?>" />
                        <input type="hidden" id="int_girth_max_1" name="int_girth_min[]" value="<?php echo filter_var($int_girth_max,FILTER_VALIDATE_INT);?>" />
           
                        </div>
                        <!--===All hidden values from database==-->


                   </div><!--	****	//End Dimentions International 	****		-->

                    
                    <?php
                        $btn_name = 'NEXT';
                        $btn_bk = 'BACK';
                        $btn_reset ='btn align_absolute align_bottom pull-left Reset';
                        if(isset($_GET['Action']) && $_GET['Action']=='edit')
                        {
                            $btn_bk = 'CANCEL';
                            $btn_name = 'SAVE';
                            $btn_reset ='btn-u align_bottom btn-u-large align_centre just_block Reset';
                        }
                    ?>
                    <input type="hidden" name="defaultDate" id="defaultDate" value="<?php echo $start_date; ?>"/>
                    <input type="hidden" name="dateChange" value="<?php if(isset($dateChange) && $dateChange!=""){ echo $dateChange;}else{ echo "false";} ?>" id="dateChange" />
                    <input type="hidden" name="minDate" id="minDate" value="<?php echo $min_date; ?>"/>
            <!--=== Bottom buttons ===-->
                    <div class="row-fluid align_relative">
                        <input type="hidden" id="aus_total_qty" name="aus_total_qty" value="<?php if(isset($lastval) && $lastval!=''){ echo ($lastval-1);}else{ echo 1;} ?>">
                        <input type="hidden" name="original_weight_1" id="original_weight_1" />
                        <input type="hidden" name="chargeable_weight" id="chargeable_weight" />
                        <input type="hidden" name="volumetric_weight" id="volumetric_weight" />
                        <input type="hidden" name="total_volume" id="total_volume" />
                        </br>
                        <input type="hidden" name="flage" id="flage" value="<?php if(($bookingvalue->flag =="international") || ($_POST['flage'] == 2)){echo "2";}else{echo "1";}?>" />
                        </br>
                        <input type="hidden" value="<?php if(isset($lastval) && $lastval!=''){ echo ($lastval-1);}else{ echo 1;} ?>" name="last_inserted_cell_australia" id="last_inserted_cell_australia">
                        <input type="hidden" value="<?php if(isset($intlastval) && $intlastval!=''){ echo ($intlastval-1);}else{ echo 1;} ?>" name="last_inserted_cell_inter" id="last_inserted_cell_inter">
                        <input type="hidden" name="international_total_qty" id="international_total_qty" />
                        <input type="hidden" name="international_no_rows" id="international_no_rows" />

                        <input type="hidden" name="btn_submit" id="btn_submit" value="" />
                        <!--<input type="submit" value="<?php echo $btn_name; ?> &raquo;" class="btn-u btn-u-large pull-right" id="next" name="Next" onclick="javascript:checkpackage();" />-->
                         <input type="submit" value="<?php echo $btn_name; ?> &raquo;" class="btn-u btn-u-large pull-right" id="next" name="Next" />
                        <?php if(isset($_GET['Action']) && isset($_GET['Action']) == 'edit'){ ?>
                        <input onclick="document.location='<?php echo SITE_URL.FILE_CHECKOUT; ?>'" type="button" class="btn-u btn-u-large pull-left back_booking" value="&laquo; <?php echo $btn_bk; ?>" name="BackButton" />
                        <?php } ?>
                        <input type="hidden" id="temp" value="">
                        <div id="servicePageBox">
                        <input type="hidden" id="servicepagename" name="servicepagename" value="<?php if(isset($servicepage) && $servicepage!=""){ echo valid_output($servicepage); } ?>" />
                        </div>
                        <input type="hidden" id="servicepagename_1" name="servicepagename_1" value="<?php echo $servicepage; ?>" />
                        <!--class="btn-u btn-u-large pull-left"-->
                        <?php
                            if(!isset($_GET['Action'])){
                        ?>
                        <input name="new_quote" type="button" class="<?php echo $btn_reset; ?>"  value="RESET" id="reset" />
                        <?php
                            }
                        ?>
                        <input type="hidden" id="ptoken" value="<?php $ptoken = $csrf->csrfkey(); echo $ptoken; ?>" name="ptoken">
                        </br>
                        </br>
                        <input type="hidden" id="databtn" name="databtn" value="false"><!-- this button is to check from session whether we want to loose data or not -->

                    </div><!--=== //End Bottom buttons ===-->
                </div><!--/bg-light-->
			</form>
            </div><!--	/containerBlock	-->
            <?php
            if ((isset($_GET['Action']) && $_GET['Action']=='edit') || (isset($_SERVER['HTTP_REFERER']) && ($_SERVER['HTTP_REFERER']==SITE_URL.'metro.php')) || (isset($_SERVER['HTTP_REFERER']) && ($_SERVER['HTTP_REFERER']==SITE_URL.'interstate.php')) || (isset($_SERVER['HTTP_REFERER']) && ($_SERVER['HTTP_REFERER']==SITE_URL.'international.php'))){
            ?>
                <div class="span3 bg-lighter">
                    <?php include(DIR_WS_RELATED.FILE_BOOKING_SUMMARY); ?>
                </div><!--/span3-->
            <?php } ?>
   	</div><!--/row-fluid-->
</div><!--/container-->
<!-- End Content Part -->
<?php
//echo "<pre>";
//print_r($booking_details_data);
//print_r($ServiceDetailsData);
//print_r($service_val['service_name']);
//print_r($final_price);
//echo "</pre>";
?>

                   <?php
    		 $session_data = json_decode($_SESSION['Thesessiondata']['_sess_login_userdetails'],true);
	$userid = $session_data['user_id'];
	//if ($userid !="")
	//{
		//echo "</div>";
	//}
	?>

<!-- International Data Loss pop up
<div class="modal hide fade small_rates" id="InterPersonalEff" data-backdrop="static" data-keyboard="false">
	<div class="modal-header">
	<h3><?php //echo INTERNATIONAL_MESSAGE_HEAD; ?></h3>
	</div>
	<div class="modal-body">
	<?php //echo DATA_LOSS; ?>
	</div>
	<div class="modal-footer"><div class="button_row">
		<div class="btn-u pull-left button_modal_fl" id="no">No</div>
        <div class="btn-u pull-right button_modal_fl" id="yes">Yes</div>
		</div></div>
</div>-->
<!-- /End International Data Loss pop up -->
<!-- Domestic Data Loss pop up -->
<div class="modal hide fade small_rates" id="DomesticEff" data-backdrop="static" data-keyboard="false">
	<div class="modal-header">
	<h3><?php echo "Domestic Service"; ?></h3>
	</div>
	<div class="modal-body">
	<?php echo DATA_LOSS; ?>
	</div>
	<div class="modal-footer"><div class="button_row">
		<div class="btn-u pull-left button_modal_fl" id="domno">No</div>
        <div class="btn-u pull-right button_modal_fl" id="domyes">Yes</div>
		</div></div>
</div>
<!--	/End Domestic Data Loss pop up -->
<!-- International service not available pop up -->
 <div class="modal hide fade small_rates" id="InterService" data-backdrop="static" data-keyboard="false">
		<div class="modal-header">
		<h3><?php echo INTERNATIONAL_NOT_AVAILABLE_HEAD; ?></h3>
		</div>
		<div class="modal-body" id="AvailableServices">
        <?php echo INTERNATIONAL_NOT_AVAIL_SERVICE; ?>
        </div>
		<div class="modal-footer">
        	<span class="white-space"><a href="#" class="btn-u" id="interclose">Close</a></span>
       	</div>
	</div>
<!--	/End International service not available pop up -->
<!-- Overnight service not available pop up -->
<div class="modal hide fade small_rates" id="AusService" data-backdrop="static" data-keyboard="false">
	<div class="modal-header">
	<h3><?php echo OVERNIGHT_NOT_AVAILABLE_HEAD; ?></h3>
	</div>
	<div class="modal-body" id="AvailableServices">
	<span class="my_bigger_font"><?php echo OVERNIGHT_NOT_AVAIL_SERVICE; ?></span>
	</div>
	<div class="modal-footer">
    	<span class="white-space"><a href="#" class="btn-u" data-dismiss="modal">Close</a></span>
  	</div>
</div>
<!-- End Overnight service not available pop up -->
<!-- Booking Data Loss from Checkout pop up -->
<div class="modal hide fade small_rates" id="dataLossEff" data-backdrop="static" data-keyboard="false">
	<div class="modal-header">
	<h3><?php echo "Warning"; ?></h3>
	</div>
	<div class="modal-body my_bigger_font justy">
	<?php echo DATA_LOSS; ?>

	</div>
	<div class="modal-footer">
	<div class="button_row">
    	<div class="btn-u pull-left button_modal_fl" id="dataLoseno">No</div>
		<div class="btn-u pull-right button_modal_fl" id="dataLoseyes">Yes</div>
	</div>
	</div>
</div>
<!--	/End Booking Data Loss from Checkout pop up -->
<!-- Booking Data Loss - Reset pop up -->
<div class="modal hide fade small_rates" id="dataResetLossEff" data-backdrop="static" data-keyboard="false">
	<div class="modal-header">
	<h3><?php echo "Warning"; ?></h3>
	</div>
	<div class="modal-body my_bigger_font justy">
	<?php echo DATA_RESET; ?>

	</div>
	<div class="modal-footer">
	<div class="button_row">
		<div class="btn-u pull-left button_modal_fl" id="dataResetLoseno">No</div>
        <div class="btn-u pull-right button_modal_fl" id="dataResetLoseyes">Yes</div>
	</div>
	</div>
</div>
<!--	/End Booking Data Loss - Reset pop up -->
<!-- Route not available pop up -->
<div class="modal hide fade small_rates" id="postcode_available" data-backdrop="static" data-keyboard="false">
	<div class="modal-header">
	<h3><?php echo ROUTE_NOT_AVAIL_MESSAGE_HEAD; ?></h3>
	</div>
	<div class="modal-body" id="AvailableServices">
	<?php echo ROUTE_NOT_AVAIL_MESSAG; ?>
	</div>
	<div class="modal-footer">
    	<span class="white-space"><a href="#more_light" id="postInt" class="btn-u">Close</a></span>
   	</div>
</div>
<!--	/End Route not available pop up -->
