<!-- Spacer -->
<div class="margin-bottom-30">
</div><!--/End Spacer -->
<div class="container">
<!-- Top Blokcs -->
	<div class="row-fluid margin-bottom-20">
        <div class="containerBlock">
        <!-- Quick Quote -->
        <form name="myform" id="myform" class="span7 margin-bottom_0" method="post" autocomplete='off' enctype="multipart/form-data">

        <div id="more_light" class="span12 margin-bottom-40 margin-left_0">
            <div class="headline"><h2 class="my_green_header"><?php echo COMMON_QQ; ?></h2></div>
            <div class="headline"><h3><?php echo COMMON_WHERE_ARE_YOU_SENDING; ?></h3></div>

            <!--==	Domstic/International ==-->
            <div class="row-fluid tab-underline margin-bottom-20" >
                <ul class="nav nav-tabs tabs">
                    <li class="<?php if($bookingvalue->flag =="australia" || $_POST['flage'] == '1' ){ echo "active"; }elseif(!isset($bookingvalue) && !isset($_POST['flage'])){ echo "active";} ?>" id="domint_1" ><a href="#size_display_block_1" data-toggle="tab" id="domestic"><?php echo COMMON_DOMESTIC; ?></a></li>
                    <li id="domint_2" class="<?php if($bookingvalue->flag =="international" || $_POST['flage'] == '2' ){ echo "active"; } ?>"><a href="#size_display_block_international" data-toggle="tab" id="international"><?php echo COMMON_INTERNATIONAL; ?></a></li>
                </ul>
            </div><!--==/End Domstic/International ==-->
            <!--===	From To 	====-->
            <div class="row-fluid margin-bottom-10">
                <!--	Pickup from 	-->

                <div id="i_from" class="span6 margin-left_0 form-group control-group">
                <label class="control-label"><i class="icon-circle-arrow-up"></i>&nbsp;<?php echo COMMON_PICK_UP_ITEM_FROM; ?></label>
                <input class="span12 form-control" name="pickup" tabindex="1" type="text" id="pickup" autocomplete="off" placeholder="PICK UP SUBURB/POSTCODE" onkeyup="ajax_showOptions(this,'search_val',event,'<?php echo DIR_HTTP_RELATED; ?>tms_index.php','ajax_index_listOfOptions'),removeError('pickupError_css');" value="<?php if($bookingvalue->pickupid !="" && !isset($_GET['action'])){ echo valid_output($bookingvalue->pickupid);}elseif(valid_output($_POST['pickup'])!=""){echo valid_output($_POST['pickup']);}?>"  onfocus="if(this.value=='PICK UP SUBURB/POSTCODE'){this.value=''};" data-toggle="tooltip" title="<?php echo $delivery_to_tooltip;?>" /><br />
                <span class="autocomplete_index help-block alert-error" id="pickupResult"></span>
                <?php if(isset($err['PICKUPNOTEXISTS'])) { ?>
                    <!-- PHP Validation	-->
                    <div class="alert alert-error show" id="pickupError_css">
                        <div class="requiredInformation" id="pickupError"><?php  echo $err['PICKUPNOTEXISTS'];?></div>
                    </div>
                    <!--	End PHP Validation	-->
                <?php } ?>
                <!--	Domestic Option	-->
                <div class="span7 margin-left_0" id="p_location_type" style="display:<?php  if($bookingvalue->flag =="international"){echo "none";}else{echo "block";}?>;">
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
                <!--====	Delivery Block		====-->
                <div id="i_to" class="span6 form-group control-group">
                    <!--====	Domestic		====-->
                    <div id="display_delivery" class="margin-up-10" style="display:<?php if($bookingvalue->flag =="international" || $_POST['flage'] == '2'){ echo "none";}else{echo "block";}?>">
                        <label class="control-label"><i class="icon-circle-arrow-down control-label"></i>&nbsp;<?php echo COMMON_DELIVERY_OF_ITEM; ?></label>
                        <input name="deliver" id="deliver" tabindex="2" autocomplete="off"  class="span12 form-control" type="text" placeholder="DELIVERY SUBURB/POSTCODE" value="<?php if($bookingvalue->deliveryid!="" && !is_numeric($bookingvalue->deliveryid) && !isset($_GET['action'])){ echo valid_output($bookingvalue->deliveryid);}elseif($_POST['deliver']!=""){echo valid_output($_POST['deliver']);} ?>" onblur="if(this.value==''){this.value='DELIVERY SUBURB/POSTCODE'};" onfocus="if(this.value=='DELIVERY SUBURB/POSTCODE'){this.value=''};"   onkeyup="ajax_showOptions(this,'search_val',event,'<?php echo DIR_HTTP_RELATED; ?>tms_index.php','ajax_index_listOfOptions'),removeError('deliverError_css');" data-toggle="tooltip" title="<?php echo $pickup_from_tooltip;?>" /><br />
                        <span class="autocomplete_index help-block alert-error" id="deliverResult"></span>
                        <?php if(isset($err['DELIVERNOTEXISTS'])) { ?>
                            <!-- PHP Validation	-->
                            <div class="alert alert-error show" id="deliverError_css">
                                <div class="requiredInformation" id="deliverError"><?php echo $err['DELIVERNOTEXISTS'];?></div>
                            </div>
                            <!--	End PHP Validation	-->
                        <?php } ?>
                        <!--	Domestic Option	-->
                    <div class="span7 margin-left_0" id="d_location_type" style="display:<?php  if($bookingvalue->flag =="international"){echo "none";}else{echo "block";}?>;">
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
                    </div><!--====/End Domestic		====-->
                    <?php
                    //print_R($bookingvalue);
                    ?>
                    <!--====	International		====-->
                    <div id="international_country_display"  style="display:<?php if($bookingvalue->flag=="international" || $_POST['flage'] == '2'){echo 'block';}else{echo "none";}?>" class='margin-up-10'>
                    <label class='control-label'><i class='icon-circle-arrow-down'></i>&nbsp;<?php echo COMMON_DELIVERY_OF_ITEM;?></label>

                     <?php
                      if(isset($bookingvalue->deliveryid) && $bookingvalue->deliveryid!=""){
                        $selectCountryId=$bookingvalue->deliveryid;
                      }elseif(isset($_POST['inter_country']) && $_POST['inter_country']!="")
                      {
                         $selectCountryId=$_POST['inter_country'];
                      }else{
                         $selectCountryId="0";
                      }

                      echo getDropeCountry($selectCountryId,'3', 'class="span12 form-control"','inter_country');
                      ?>
                       <span class="autocomplete_index help-block alert-error" id="changed_cntry_message"></span>
                        <div class="alert alert-error hide" id="intdeliverError_css">
                        <a class="close">×</a>
                        <div class="requiredInformation" id="intdeliverError" ></div>
                    </div>
                    </div><!--====/End International		====-->
                   </div> <!--	//End Delivery to 	-->
            </div><!-- /End row-fluid	-->



            <div class="headline"><h3><?php echo COMMON_INFORMATION_ABOUT_THE_ITEM; ?></h3></div>
            <!--<div class="tab-content">-->
    <!--	****	Dimentions within Australia		****		-->
            <div  id="size_display_block_1" style="display:<?php if($bookingvalue->flag =="australia" || $_POST['flage'] == '1' ){ echo "block;"; }elseif(!isset($bookingvalue->flag) && !isset($_POST['flage'])){echo "block";}else{ echo "none;";} ?>"  class="row-fluid tab-pane active margin-bottom-10">

                <?php
                if(isset($bookingvalue->servicepagename) && $bookingvalue->servicepagename!="")
                {
                    $service_page_item = $bookingvalue->servicepagename;
                }else{
                    $service_page_item = "sameday";
                }
                //print_R($BookingItemDetailsData);

                if(($bookingvalue->flag =="australia"  && !empty($BookingItemDetailsData)) || ($_POST['flage'] == '1' && !empty($BookingItemDetailsData)))
                {
                    $i=1;
                    $k=0;
                    $lastval =1;

                    foreach ($BookingItemDetailsData as $BookingItemvalue) {

                ?>
                <div id="<?php echo filter_var($i,FILTER_VALIDATE_INT); ?>" class="controls controls-row">

                    <input type="hidden" name="selShippingType[]" id="selShippingType_<?php echo filter_var($i,FILTER_VALIDATE_INT); ?>" value='<?php echo $BookingItemvalue->item_type; ?>'>

                    <span  class="control-group white-space extra_width margin-left_0 form-group">
                        <label for="weight" class="control-label lebel_index-width"><?php echo COMMON_QTY; ?>&nbsp;&nbsp;<i class="icon-plus icon_index-width control-label"></i></label>

                        <input class="input-mini border-radius-none form-control" type="tel" name="Item_qty[]" id="<?php echo "Item_qty_".filter_var($i,FILTER_VALIDATE_INT);?>" onchange="display_total_value();" value="<?php if($BookingItemvalue->quantity){echo $BookingItemvalue->quantity;}else{ echo "1";} ?>">
                        <span class="help-block alert-error" id="Items_qty_<?php echo filter_var($i,FILTER_VALIDATE_INT); ?>"><?php if(isset($multi_err['qtyError'][$k])){ echo $multi_err['qtyError'][$k];} ?></span>
                        <?php if(isset($multi_err['qtyError'][$k])) { ?>
                        <!-- PHP Validation -->
                        <div class="alert alert-error show" id="qty_err_<?php echo filter_var($i,FILTER_VALIDATE_INT); ?>_css">
                            <div class="requiredInformation" ><?php echo $multi_err['qtyError'][$k];?></div>
                        </div>
                        <!--    End PHP Validation  -->
                        <?php } ?>
                    </span>&nbsp;&nbsp;


                    <span  class="control-group white-space extra_width margin-left_0 form-group">
                    <label for="weight" class="control-label lebel_index-width"><?php echo COMMON_WEIGHT; ?>&nbsp;&nbsp;&nbsp;<i class="icon-download-alt icon_index-width control-label"></i></label>
                    <input type="tel" id="<?php echo "Item_weight_".filter_var($i,FILTER_VALIDATE_INT);?>" class="input-mini border-radius-none form-control" onkeypress="javascript:removeError('Items_weight_err_<?php echo filter_var($i,FILTER_VALIDATE_INT); ?>');"  value="<?php if($bookingvalue->flag !="international"){ echo valid_output($BookingItemvalue->item_weight);} ?>" placeholder="kg" name="Item_weight[]" title="<?php echo $item_weight_tooltip;?>" <?php echo $weight_display; ?> maxlength="5" size="5" onkeyup="numberDecimal(this.value,'<?php echo "Item_weight_".filter_var($i,FILTER_VALIDATE_INT);?>','myform');" />
                    <span class="help-block alert-error" id="Items_weight_<?php echo filter_var($i,FILTER_VALIDATE_INT); ?>"></span>
                    <?php if(isset($multi_err['weightError'][$k])){ ?>
                        <!-- PHP Validation	-->
                        <div class="alert alert-error show" id="Items_weight_err_<?php echo filter_var($i,FILTER_VALIDATE_INT); ?>">
                            <div ><?php echo $multi_err['weightError'][$k]; ?></div>
                        </div>
                        <!--	End PHP Validation	-->
                    <?php } ?>
                    </span>&nbsp;&nbsp;
                    <span class="control-group white-space extra_width margin-left_0 form-group">
                    <label for="length"  class="control-label lebel_index-width"><?php echo COMMON_LENGTH; ?>&nbsp;&nbsp;&nbsp;<i class="icon-resize-horizontal icon_index-width control-label"></i></label>
                    <input type="tel" class="input-mini border-radius-none form-control" placeholder="cm"  name="Item_length[]"  value="<?php if($bookingvalue->flag !="international"){ echo valid_output($BookingItemvalue->length);} ?>" title="<?php echo $item_length_tooltip;?>" id="<?php echo "Item_length_".filter_var($i,FILTER_VALIDATE_INT)?>" <?php if(isset($BookingItemvalue->dim_status) && $BookingItemvalue->dim_status==0)
                            { echo "readonly"; } ?> onkeypress="javascript:removeError('Items_length_err_<?php echo filter_var($i,FILTER_VALIDATE_INT); ?>');" />
                    <span class="help-block alert-error" id="Items_length_<?php echo filter_var($i,FILTER_VALIDATE_INT); ?>"></span>
                    <?php if(isset($multi_err['lengthError'][$k])){ ?>
                        <!-- PHP Validation	-->
                        <div class="alert alert-error show" id="Items_length_err_<?php echo filter_var($i,FILTER_VALIDATE_INT); ?>">
                            <div ><?php echo $multi_err['lengthError'][$k]; ?></div>
                        </div>
                        <!--	End PHP Validation	-->
                    <?php } ?>
                    </span>&nbsp;&nbsp;
                    <span class="control-group white-space extra_width margin-left_0 form-group">
                    <label for="width" class="control-label lebel_index-width"><?php echo COMMON_WIDTH; ?>&nbsp;&nbsp;&nbsp;<i class="icon-resize-horizontal icon_index-width control-label"></i></label>
                    <input type="tel" class="input-mini border-radius-none form-control" placeholder="cm" name="Item_width[]" title="<?php echo $item_width_tooltip;?>" id="<?php echo "Item_width_".filter_var($i,FILTER_VALIDATE_INT)?>" onkeypress="javascript:removeError('Items_width_err_<?php echo filter_var($i,FILTER_VALIDATE_INT); ?>');" onchange="round_up(this.id,this.value,1);"  value="<?php if($bookingvalue->flag !="international"){ echo valid_output($BookingItemvalue->width);} ?>" <?php if(isset($BookingItemvalue->dim_status) && $BookingItemvalue->dim_status==0)
                            { echo "readonly"; } ?>/>
                    <span class="help-block alert-error" id="Items_width_<?php echo filter_var($i,FILTER_VALIDATE_INT); ?>"></span>
                     <?php if(isset($multi_err['widthError'][$k])){ ?>
                            <!-- PHP Validation	-->
                            <div class="alert alert-error show" id="Items_width_err_<?php echo filter_var($i,FILTER_VALIDATE_INT); ?>">
                                <div ><?php echo $multi_err['widthError'][$k]; ?></div>
                            </div>
                            <!--	End PHP Validation	-->
                        <?php } ?>
                    </span>&nbsp;&nbsp;
                    <span class="control-group white-space extra_width margin-left_0 form-group">
                    <label for="height" class="control-label lebel_index-width"><?php echo COMMON_HEIGHT; ?>&nbsp;&nbsp;&nbsp;<i class="icon-resize-vertical icon_index-width control-label"></i></label>
                    <input type="tel" class="input-mini border-radius-none form-control" placeholder="cm" title="<?php echo $item_height_tooltip;?>" id="<?php echo "Item_height_".filter_var($i,FILTER_VALIDATE_INT)?>" name="Item_height[]" value="<?php if($bookingvalue->flag !="international"){ echo valid_output($BookingItemvalue->height);} ?>" onchange="round_up(this.id,this.value,1);" <?php if(isset($BookingItemvalue->dim_status) && $BookingItemvalue->dim_status==0)
                            { echo "readonly"; } ?> onkeypress="javascript:removeError('Items_height_err_<?php echo filter_var($i,FILTER_VALIDATE_INT); ?>');" />
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
                </div>
                <?php
                    $i=$i+1; $k++;
                    $lastval =$i;
                    }

                }else{
                ?>
                <div id="1" class="controls controls-row">
                <input type="hidden" name="selShippingType[]" id="selShippingType_1" value="<?php echo $item_type; ?>">

                <span  class="control-group white-space extra_width margin-left_0 form-group">
                <label for="qty" class="control-label lebel_index-width"><?php echo COMMON_QTY; ?>&nbsp;&nbsp;&nbsp;<i class="icon-plus icon_index-width control-label"></i></label>
                <input type="tel" class="input-mini border-radius-none form-control" name="Item_qty[]" id="Item_qty_1" value="<?php if(isset($_POST["Item_qty"]) && $_POST["Item_qty"]!=""){echo filter_var($_POST["Item_qty"],FILTER_VALIDATE_FLOAT);}else{ echo "1";}?>">
                <span class="help-block alert-error" id="Items_qty_1"></span>
                <?php if(isset($multi_err['qtyError'][0])){ ?>
                <!-- PHP Validation -->
                <div class="alert alert-error show" id="Items_qty_err_<?php echo filter_var(1,FILTER_VALIDATE_INT); ?>">
                    <div ><?php echo $multi_err['qtyError'][0]; ?></div>
                </div>
                <?php } ?>
                </span>&nbsp;&nbsp;


                <span  class="control-group white-space extra_width margin-left_0 form-group">
                <label for="weight" class="control-label lebel_index-width"><?php echo COMMON_WEIGHT; ?>&nbsp;&nbsp;&nbsp;<i class="icon-download-alt icon_index-width control-label"></i></label>
                <input type="tel"  id="Item_weight_1" class="input-mini border-radius-none form-control"  value="<?php if(isset($_POST["Item_weight"]) && $_POST["Item_weight"]!=""){echo filter_var($_POST["Item_weight"],FILTER_VALIDATE_FLOAT);}?>" placeholder="kg" name="Item_weight[]" title="<?php echo $item_weight_tooltip;?>" <?php echo $weight_display; ?> maxlength="5" size="5" onkeyup="numberDecimal(this.value,'Item_weight_1','myform');"/>
                <span class="help-block alert-error" id="Items_weight_1"></span>
                <?php if(isset($multi_err['weightError'][0])){ ?>
                <!-- PHP Validation	-->
                <div class="alert alert-error show" id="Items_weight_err_<?php echo filter_var(1,FILTER_VALIDATE_INT); ?>">
                    <div ><?php echo $multi_err['weightError'][0]; ?></div>
                </div>
                <?php } ?>
                </span>&nbsp;&nbsp;


                <span class="control-group white-space extra_width margin-left_0 form-group">
                <label for="length"  class="control-label lebel_index-width"><?php echo COMMON_LENGTH; ?>&nbsp;&nbsp;&nbsp;<i class="icon-resize-horizontal icon_index-width control-label"></i></label>
                <input type="tel" class="input-mini border-radius-none form-control" placeholder="cm"  name="Item_length[]" id="Item_length_1" title="<?php echo $item_length_tooltip;?>" value="<?php if(isset($_POST['Item_length']) && $_POST['Item_length']!=""){echo filter_var($_POST["Item_length"],FILTER_VALIDATE_FLOAT);}?>" <?php echo $dim_display; ?> />
                <span class="help-block alert-error" id="Items_length_1"></span>
                <?php if(isset($multi_err['lengthError'][0])){ ?>
                        <!-- PHP Validation	-->
                        <div class="alert alert-error show" id="Items_length_err_<?php echo filter_var('1',FILTER_VALIDATE_INT); ?>">
                            <div ><?php echo $multi_err['lengthError'][0]; ?></div>
                        </div>
                        <!--	End PHP Validation	-->
                <?php } ?>
                </span>&nbsp;&nbsp;
                <span class="control-group white-space extra_width margin-left_0 form-group">
                <label for="width" class="control-label lebel_index-width"><?php echo COMMON_WIDTH; ?>&nbsp;&nbsp;&nbsp;<i class="icon-resize-horizontal icon_index-width control-label"></i></label>
                <input type="tel" class="input-mini border-radius-none form-control" placeholder="cm" name="Item_width[]" title="<?php echo $item_width_tooltip;?>" id="Item_width_1" onchange="round_up(this.id,this.value,1);" <?php echo $dim_display; ?> value="<?php if(isset($_POST['Item_width']) && $_POST['Item_width']!=""){echo filter_var($_POST["Item_width"],FILTER_VALIDATE_FLOAT);}?>"/>
                <span class="help-block alert-error" id="Items_width_1"></span>
                <?php if(isset($multi_err['widthError'][0])){ ?>
                    <!-- PHP Validation	-->
                    <div class="alert alert-error show" id="Items_width_err_<?php echo filter_var('1',FILTER_VALIDATE_INT); ?>">
                        <div ><?php echo $multi_err['widthError'][0]; ?></div>
                    </div>
                    <!--	End PHP Validation	-->
                <?php } ?>
                </span>&nbsp;&nbsp;
                <span class="control-group white-space extra_width margin-left_0 form-group">
                <label for="height" class="control-label lebel_index-width"><?php echo COMMON_HEIGHT; ?>&nbsp;&nbsp;&nbsp;<i class="icon-resize-vertical icon_index-width control-label"></i></label>
                <input type="tel" class="input-mini border-radius-none form-control" placeholder="cm" id="Item_height_1" title="<?php echo $item_height_tooltip;?>" name="Item_height[]" value="<?php if(isset($_POST['Item_height']) && $_POST['Item_height']!=""){echo filter_var($_POST["Item_height"],FILTER_VALIDATE_FLOAT);}?>" onchange="round_up(this.id,this.value,1);" <?php echo $dim_display; ?> />
                <span class="help-block alert-error" id="Items_height_1"></span>
                <?php if(isset($multi_err['heightError'][0])){ ?>
                    <!-- PHP Validation	-->
                    <div class="alert alert-error show" id="Items_height_err_<?php echo filter_var('1',FILTER_VALIDATE_INT); ?>">
                        <div ><?php echo $multi_err['heightError'][0]; ?></div>
                    </div>
                    <!--	End PHP Validation	-->
                <?php
                }
                ?>
                </span>
                <span class="control-group white-space"><a href="#plus"  class="add_field_button"><i id="#plus" class="icon-plus-sign icon_plus_size"></i></a>
                </span>
                </div>
                <?php
                }
                ?>
    <!--	****	Hidden Domestic Items 	****		-->

            <div  class="row-fluid hide" id="optionTemplate">
                <div class="controls controls-row" id="1">
                <input type="hidden" name="selShippingType[]" id="selShippingType_1" value="<?php echo $item_type; ?>">

                <span  class="control-group white-space extra_width form-group">
                <!--<label for="qty" class="control-label lebel_index-width control-label"><?php echo COMMON_QTY; ?>&nbsp;&nbsp;&nbsp;<i class="icon-plus icon_index-width control-label"></i></label>-->
                <input type="tel" class="input-mini border-radius-none form-control" name="Item_qty[]" id="Item_qty_1" value="<?php if(isset($_POST["Item_qty"]) && $_POST["Item_qty"]!=""){echo filter_var($_POST["Item_qty"],FILTER_VALIDATE_FLOAT);}else{ echo "1";}?>">
                <span class="help-block alert-error" id="Items_qty_1"></span>
                </span>&nbsp;&nbsp;

                <span  class="control-group white-space extra_width  form-group">
                <!--<label for="weight" class="control-label lebel_index-width control-label"><?php echo COMMON_WEIGHT; ?>&nbsp;&nbsp;&nbsp;<i class="icon-download-alt icon_index-width control-label"></i></label>-->
                <input type="tel" id="Item_weight_1"  class="input-mini border-radius-none form-control"  value="<?php if(isset($_POST["Item_weight"]) && $_POST["Item_weight"]!=""){echo filter_var($_POST["Item_weight"],FILTER_VALIDATE_FLOAT);}?>" placeholder="kg"  name="Item_weight[]" title="<?php echo $item_weight_tooltip;?>" <?php echo $weight_display; ?> maxlength="5" size="5" onkeyup="numberDecimal(this.value,'<?php echo "Item_weight_1";?>','myform');" />
                <span class="help-block alert-error" id="Items_weight_1"></span>
                </span>&nbsp;&nbsp;
                <span class="control-group white-space extra_width form-group">
                <!--<label for="length"  class="control-label lebel_index-width"><?php echo COMMON_LENGTH; ?>&nbsp;&nbsp;&nbsp;<i class="icon-resize-horizontal icon_index-width control-label"></i></label>-->
                <input type="tel" id="Item_length_1" class="input-mini border-radius-none form-control" placeholder="cm"  name="Item_length[]"  title="<?php echo $item_length_tooltip;?>" value="<?php if(isset($_POST['Item_length']) && $_POST['Item_length']!=""){echo filter_var($_POST["Item_length"],FILTER_VALIDATE_FLOAT);}?>" <?php echo $dim_display; ?> />
                <span class="help-block alert-error" id="Items_length_1"></span>

                </span>&nbsp;&nbsp;
                <span class="control-group white-space extra_width form-group">
                <!--<label for="width" class="control-label lebel_index-width"><?php echo COMMON_WIDTH; ?>&nbsp;&nbsp;&nbsp;<i class="icon-resize-horizontal icon_index-width control-label"></i></label>-->
                <input type="tel" id="Item_width_1" class="input-mini border-radius-none form-control" placeholder="cm" title="<?php echo $item_width_tooltip;?>" name="Item_width[]"  onchange="round_up(this.id,this.value,1);" <?php echo $dim_display; ?> value="<?php if(isset($_POST['Item_width']) && $_POST['Item_width']!=""){echo filter_var($_POST["Item_width"],FILTER_VALIDATE_FLOAT);}?>"/>
                <span class="help-block alert-error" id="Items_width_1"></span>

                </span>&nbsp;&nbsp;
                <span class="control-group white-space extra_width form-group">
                <!--<label for="height" class="control-label lebel_index-width"><?php echo COMMON_HEIGHT; ?>&nbsp;&nbsp;&nbsp;<i class="icon-resize-vertical icon_index-width control-label"></i></label>-->
                <input type="tel" class="input-mini border-radius-none form-control" placeholder="cm" id="Item_height_1" name="Item_height[]" title="<?php echo $item_height_tooltip;?>" value="<?php if(isset($_POST['Item_height']) && $_POST['Item_height']!=""){echo filter_var($_POST["Item_height"],FILTER_VALIDATE_FLOAT);}?>" onchange="round_up(this.id,this.value,1);" <?php echo $dim_display; ?> />
                <span class="help-block alert-error" id="Items_height_1"></span>
                </span>
                <span class="control-group white-space">
                <a href="#minus" onclick="javascript:DelSizeDataRow(1)"  class="removeButton" ><i class="icon-minus-sign icon_plus_size" id="#minus"></i>
                </a>
                </span>
                </div>
            </div>

    <!--	****	Hidden Domestic Items 	****		-->
            </div>

    <!--	****	Dimensions International 	****		-->
            <div id="size_display_block_international" class="row-fluid tab-pane" style="display:<?php if($bookingvalue->flag =="international" || $_POST['flage'] == '2' ){ echo "block;"; }else{ echo "none;";} ?>">


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
                 ?>
                 <?php if($i==1){ ?>
                 <div class="row-fluid tab-underline" >
                    <ul class="nav nav-tabs tabs">
                        <li id="doc_1" class="<?php echo $doc_active; ?>">
                            <label class="radio">
                                <input type="radio" name="inter_ShippingType_1[]" value="4" <?php echo $doc_chk; ?> onclick="javascript:selectedInterItems(this.value);"> Documents
                            </label>
                        </li>
                        <li id="doc_2" class="<?php echo $nondoc_active; ?>">
                            <label class="radio">
                                <input type="radio" name="inter_ShippingType_1[]" <?php  echo $nondoc_chk;?> value="5" onclick="javascript:selectedInterItems(this.value);"> Non Documents
                            </label>

                        </li>
                    </ul>
                </div>
                 <?php } ?>
                 <div id="<?php echo filter_var($i,FILTER_VALIDATE_INT); ?>" class="controls controls-row">
                 <span  class="control-group white-space extra_width margin-left_0 form-group">
                    <label for="weight" class="control-label lebel_index-width"><?php echo COMMON_QTY; ?>&nbsp;&nbsp;<i class="icon-plus icon_index-width control-label"></i></label>

                    <input type="text" class="float_none span6" name="qty_item[]" id="qty_item_<?php echo filter_var($i,FILTER_VALIDATE_INT); ?>" onchange="totalInterVal();" value="<?php if(isset($booingItemValue->quantity) && $booingItemValue->quantity!=""){echo $booingItemValue->quantity;}else{echo "1";} ?>">
                    <span class="help-block alert-error" id="qty_items_<?php echo filter_var($i,FILTER_VALIDATE_INT); ?>"><?php if(isset($multi_err['intqtyError'][$k])){ echo $multi_err['intqtyError'][$k];} ?></span>
                    <?php if(isset($multi_err['intqtyError'][$k])) { ?>
                    <!-- PHP Validation -->
                    <div class="alert alert-error show" id="qty_err_<?php echo filter_var($i,FILTER_VALIDATE_INT); ?>_css">
                        <div class="requiredInformation" ><?php echo $multi_err['intqtyError'][$k];?></div>
                    </div>
                    <!--    End PHP Validation  -->
                    <?php } ?>
                </span>
                <span class="control-group white-space extra_width margin-left_0 form-group">
                <label for="weight" class="control-label lebel_index-width"><?php echo COMMON_WEIGHT; ?>&nbsp;&nbsp;&nbsp;<i class="icon-download-alt icon_index-width"></i></label>
                <input type="tel" class="input-mini border-radius-none" placeholder="kg" id='weight_item_<?php echo $i; ?>' name="weight_item[]" value="<?php echo valid_output($booingItemValue->item_weight); ?>" maxlength="5" size="5" onkeyup="numberDecimal(this.value,'<?php echo "weight_item_1";?>','myform');"/>
                <span class="help-block alert-error" id="weight_items_<?php echo $i; ?>"></span>
                <?php if(isset($multi_err['intweightError'][$k])){ ?>
                <!-- PHP Validation	-->
                <div class="alert alert-error show" id="weight_items_err_<?php echo filter_var($i,FILTER_VALIDATE_INT); ?>">
                    <div ><?php echo $multi_err['intweightError'][$k]; ?></div>
                </div>
                <?php } ?>
                </span>
                <span class="control-group white-space extra_width margin-left_0 form-group">
                <label for="length" class="control-label lebel_index-width"><?php echo COMMON_LENGTH; ?>&nbsp;&nbsp;&nbsp;<i class="icon-resize-horizontal icon_index-width"></i></label>
                <input type="tel" class="input-mini border-radius-none" placeholder="cm"  name="length_item[]" value="<?php echo valid_output($booingItemValue->length); ?>" id="length_item_<?php echo $i; ?>"  />
                 <span class="help-block alert-error" id="length_items_<?php echo $i; ?>"></span>
                <?php if(isset($multi_err['intlengthError'][$k])){ ?>
                <!-- PHP Validation	-->
                <div class="alert alert-error show" id="length_items_err_<?php echo filter_var($i,FILTER_VALIDATE_INT); ?>">
                    <div ><?php echo $multi_err['intlengthError'][$k]; ?></div>
                </div>
                <?php } ?>
                </span>&nbsp;&nbsp;
                <span class="control-group white-space extra_width margin-left_0 form-group">
                <label for="width" class="control-label lebel_index-width"><?php echo COMMON_WIDTH; ?>&nbsp;&nbsp;&nbsp;<i class="icon-resize-horizontal icon_index-width"></i></label>
                <input type="tel" class="input-mini border-radius-none form-control" placeholder="cm"  name="width_item[]" title="<?php echo $item_width_tooltip;?>" value="<?php echo valid_output($booingItemValue->width); ?>" id="width_item_<?php echo $i; ?>" />

                <span class="help-block alert-error" id="width_items_<?php echo $i; ?>"></span>
                <?php if(isset($multi_err['intwidthError'][$k])){ ?>
                <!-- PHP Validation	-->
                <div class="alert alert-error show" id="width_items_err_<?php echo filter_var($i,FILTER_VALIDATE_INT); ?>">
                    <div ><?php echo $multi_err['intwidthError'][$k]; ?></div>
                </div>
                <?php } ?>
               </span>&nbsp;&nbsp;
                <span class="control-group white-space extra_width margin-left_0 form-group">
                <label for="height" class="control-label lebel_index-width"><?php echo COMMON_HEIGHT; ?>&nbsp;&nbsp;&nbsp;<i class="icon-resize-vertical icon_index-width"></i></label>
                <input type="tel" class="input-mini border-radius-none" placeholder="cm" id="height_item_<?php echo $i; ?>" value="<?php echo valid_output($booingItemValue->height); ?>"  name="height_item[]" />
                <span class="help-block alert-error" id="height_items_<?php echo $i; ?>"></span>
                <?php if(isset($multi_err['intheightError'][$k])){ ?>
                <!-- PHP Validation	-->
                <div class="alert alert-error show" id="height_items_err_<?php echo filter_var($i,FILTER_VALIDATE_INT); ?>">
                    <div ><?php echo $multi_err['intheightError'][$k]; ?></div>
                </div>
                <?php } ?>
                </span>

                <?php if($i==1){ ?>
                    <span class="control-group white-space"><a href="#plus"  class="add_inter_button"><i id="#plus" class="icon-plus-sign icon_plus_size"></i></a>
                    </span>
                    <?php }else{ ?>
                    <span class="control-group white-space">
                    <a href="#minus" onclick="javascript:DelSizeDataRow('<?php echo $i; ?>');"  class="removeButton" ><i class="icon-minus-sign icon_plus_size" id="#minus"></i></a></span>
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
                                <input type="radio" name="inter_ShippingType_1[]" value="4" <?php echo $doc_chk; ?> onclick="javascript:selectedInterItems(this.value);"> Documents
                            </label>
                        </li>
                        <li id="doc_2" class="<?php echo $nondoc_active; ?>">
                            <label class="radio">
                                <input type="radio" name="inter_ShippingType_1[]" <?php  echo $nondoc_chk;?> value="5" onclick="javascript:selectedInterItems(this.value);"> Non Documents
                            </label>

                        </li>
                    </ul>
                </div>
                <span class="control-group white-space extra_width margin-left_0 form-group">
                <label for="qty" class="control-label lebel_index-width"><?php echo COMMON_QTY; ?>&nbsp;&nbsp;&nbsp;<i class="icon-plus icon_index-width control-label"></i></label>
                <input type="tel" class="input-mini border-radius-none" placeholder="pcs" id='qty_item_1' value="<?php if(isset($_POST['qty_item'][0]) && !empty($_POST['qty_item'][0])){echo $_POST['qty_item'][0]; }else{ echo "1";}?>" name="qty_item[]" maxlength="5" size="5" />
                <span class="help-block alert-error" id="qty_items_1"></span>
                <div class="alert alert-error hide" id="all_items_int_qty_css_1">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <div id=""></div>
                </div>
                </span>
                <span class="control-group white-space extra_width margin-left_0 form-group">
                <label for="weight" class="control-label lebel_index-width"><?php echo COMMON_WEIGHT; ?>&nbsp;&nbsp;&nbsp;<i class="icon-download-alt icon_index-width"></i></label>
                <input type="tel" class="input-mini border-radius-none" placeholder="kg" id='weight_item_1' name="weight_item[]"maxlength="5" size="5" onkeyup="numberDecimal(this.value,'<?php echo "weight_item_1";?>','myform');" />
                <span class="help-block alert-error" id="weight_items_1"></span>
                <div class="alert alert-error hide" id="all_items_int_weight_css_1">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <div id=""></div>
                </div>
                </span>
                <span class="control-group white-space extra_width margin-left_0 form-group">
                <label for="length" class="control-label lebel_index-width"><?php echo COMMON_LENGTH; ?>&nbsp;&nbsp;&nbsp;<i class="icon-resize-horizontal icon_index-width"></i></label>
                <input type="tel" class="input-mini border-radius-none" placeholder="cm"  name="length_item[]" title="<?php echo $item_weight_tooltip;?>" id="length_item_1"  />
                <span class="help-block alert-error" id="length_items_1"></span>
                <div class="alert alert-error hide" id="all_items_int_length_css_1">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <div id="length_items_1"></div>
                </div>
                </span>&nbsp;&nbsp;
                <span class="control-group white-space extra_width margin-left_0 form-group">
                <label for="width" class="control-label lebel_index-width"><?php echo COMMON_WIDTH; ?>&nbsp;&nbsp;&nbsp;<i class="icon-resize-horizontal icon_index-width"></i></label>
                <input type="tel" class="input-mini border-radius-none form-control" placeholder="cm"  name="width_item[]" title="<?php echo $item_width_tooltip;?>" id="width_item_1" />
                <span class="help-block alert-error" id="width_items_1"></span>
                <div class="alert alert-error hide" id="all_items_int_width_css_1">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <div id="width_items_1"></div>
                </div>
               </span>&nbsp;&nbsp;
                <span class="control-group white-space extra_width margin-left_0 form-group">
                <label for="height" class="control-label lebel_index-width"><?php echo COMMON_HEIGHT; ?>&nbsp;&nbsp;&nbsp;<i class="icon-resize-vertical icon_index-width"></i></label>
                <input type="tel" class="input-mini border-radius-none" placeholder="cm" id="height_item_1" name="height_item[]" />
                <span class="help-block alert-error" id="height_items_1"></span>
                <div class="alert alert-error hide" id="all_items_int_height_css_1">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <div id="height_items_1"></div>
                </div>
                </span>
                <span class="control-group white-space"><a href="#plus" class="add_inter_button"><i id="#plus" class="icon-plus-sign icon_plus_size"></i></a></span>

                <?php echo getItemTypeIndex($item,'5',$extra_para,null,'inter'); ?>
                </div>
            <?php } ?>
            <!-- Hidden Dimesions for International -->
        <div  class="row-fluid hide" id="optionIntTemplate">
                <div class="controls controls-row" id="1">
                     <span class="control-group white-space extra_width margin-left_0 form-group">
                <!--<label for="weight" class="control-label lebel_index-width"><?php echo COMMON_QTY; ?>&nbsp;&nbsp;&nbsp;<i class="icon-plus icon_index-width control-label"></i></label>-->
                <input type="tel" class="input-mini border-radius-none" placeholder="pcs" id='qty_item_1' name="qty_item[]" maxlength="5" size="5" />
                <span class="help-block alert-error" id="qty_items_1" value="<?php if(isset($_POST['qty_item'][0]) && !empty($_POST['qty_item'][0])){echo $_POST['qty_item'][0]; }else{ echo "1";}?>"></span>
                <div class="alert alert-error hide" id="all_items_int_qty_css_1">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <div id=""></div>
                </div>
                </span>
                <span  class="control-group white-space extra_width form-group">
                <!--<label for="weight" class="control-label lebel_index-width control-label"><?php echo COMMON_WEIGHT; ?>&nbsp;&nbsp;&nbsp;<i class="icon-download-alt icon_index-width control-label"></i></label>-->
                <input type="tel" id="weight_item_1" name="weight_item[]" maxlength="5" size="5" onkeyup="numberDecimal(this.value,'<?php echo "weight_item_1";?>','myform');"  class="input-mini border-radius-none form-control"  value="<?php if(isset($_POST["weight_item"]) && $_POST["weight_item"]!=""){echo filter_var($_POST["weight_item"],FILTER_VALIDATE_FLOAT);}?>" placeholder="kg"   title="<?php echo $item_weight_tooltip;?>" <?php echo $weight_display; ?>  />
                <span class="help-block alert-error" id="weight_items_1"></span>
                </span>&nbsp;&nbsp;
                <span class="control-group white-space extra_width form-group">
                <!--<label for="length"  class="control-label lebel_index-width"><?php echo COMMON_LENGTH; ?>&nbsp;&nbsp;&nbsp;<i class="icon-resize-horizontal icon_index-width control-label"></i></label>-->
                <input type="tel" id="length_item_1" class="input-mini border-radius-none form-control" placeholder="cm"  name="length_item[]"  title="<?php echo $item_length_tooltip;?>" value="<?php if(isset($_POST['length_item']) && $_POST['length_item']!=""){echo filter_var($_POST["length_item"],FILTER_VALIDATE_FLOAT);}?>" <?php echo $dim_display; ?> />
                <span class="help-block alert-error" id="length_items_1"></span>

                </span>&nbsp;&nbsp;
                <span class="control-group white-space extra_width form-group">
                <!--<label for="width" class="control-label lebel_index-width"><?php echo COMMON_WIDTH; ?>&nbsp;&nbsp;&nbsp;<i class="icon-resize-horizontal icon_index-width control-label"></i></label>-->
                <input type="tel" id="width_item_1" class="input-mini border-radius-none form-control" placeholder="cm" title="<?php echo $item_width_tooltip;?>" name="width_item[]"  onchange="round_up(this.id,this.value,1);" <?php echo $dim_display; ?> value="<?php if(isset($_POST['width_item']) && $_POST['width_item']!=""){echo filter_var($_POST["width_item"],FILTER_VALIDATE_FLOAT);}?>"/>
                <span class="help-block alert-error" id="width_items_1"></span>

                </span>&nbsp;&nbsp;
                <span class="control-group white-space extra_width form-group">
                <!--<label for="height" class="control-label lebel_index-width"><?php echo COMMON_HEIGHT; ?>&nbsp;&nbsp;&nbsp;<i class="icon-resize-vertical icon_index-width control-label"></i></label>-->
                <input type="tel" class="input-mini border-radius-none form-control" placeholder="cm" id="height_item_1" name="height_item[]" title="<?php echo $item_height_tooltip;?>" value="<?php if(isset($_POST['height_item']) && $_POST['height_item']!=""){echo filter_var($_POST["height_item"],FILTER_VALIDATE_FLOAT);}?>" onchange="round_up(this.id,this.value,1);" <?php echo $dim_display; ?> />
                <span class="help-block alert-error" id="height_items_1"></span>
                </span>
                <span class="control-group white-space">
                <a href="#minus" onclick="javascript:DelSizeDataRow(1)"  class="removeButton" ><i class="icon-minus-sign icon_plus_size" id="#minus"></i>
                </a>
                </span>
                </div>
            </div>
        <!-- Hidden Dimesions for international -->
            </div>
            <!--</div>-->
        <!--	****	Dimensions International 	****		-->

            <div id="servicePageBox">
                <?php if(isset($servicepage) && $servicepage!=""){ ?>
                <input type="hidden" id="servicepagename" name="servicepagename" value="<?php echo $servicepage; ?>" />
                <?php } ?>
             </div>
			 <input type="hidden" id="servicepagename_1" name="servicepagename_1" value="<?php echo $servicepage; ?>" />
             <div id="servicePageItem_1">
                <?php
                if(($bookingvalue->flag =="international" && !isset($_GET['action']) && !empty($BookingItemDetailsData)) || ($_POST['flage'] == '2' && !empty($BookingItemDetailsData))){

                ?>
                <input type="hidden" name="inter_ShippingType_1[]" value="<?php if($bookingvalue->item_type){echo $bookingvalue->item_type;}else{ echo $_POST['inter_ShippingType_1'][0];} ?>">
                        <?php
                }else{
                    echo getItemTypeIndex($item,'5',$extra_para,null,'sameday');
                }
                ?>
            </div>

            <div class="form-group">
                <input type="hidden" id="length_max_1" name="length_max" value="<?php echo $length_max; ?>" />
                <input type="hidden" id="girth_max_1" name="girth_max" value="<?php echo $girth_max; ?>" />
            </div>
            <div class="row-fluid align_relative ">
             
            <input type="hidden" id="ptoken" value="<?php echo $ptoken; ?>" name="ptoken">
            <input type="hidden" id="temp" value="">
            <!--<input type="hidden" id="Item_qty" name="Item_qty" value="<?php //if(isset($lastval) && $lastval!=''){ echo ($lastval-1);}else{ echo 1;} ?>">-->
            <input type="hidden" id="aus_total_qty" name="aus_total_qty" value="<?php if(isset($lastval) && $lastval!=''){ echo ($lastval-1);}else{ echo 1;} ?>">
            <?php
            //print_R($bookingvalue);
            ?>
            <input type="hidden" name="flage" id="flage" value="<?php if(($bookingvalue->flag =="international") || ($_POST['flage'] == 2)){echo "2";}else{echo "1";}?>" />
            <input type="hidden" value="<?php if(isset($intlastval) && $intlastval!=''){ echo ($intlastval-1);}else{ echo 1;} ?>" name="last_inserted_cell_inter" id="last_inserted_cell_inter">
            <input type="hidden" value="<?php if(isset($lastval) && $lastval!=''){ echo ($lastval-1);}else{ echo 1;} ?>" name="last_inserted_cell_australia" id="last_inserted_cell_australia">
            <button type="button" class="btn align_absolute align_bottom pull-left Reset" id="reset">Reset</button>
            <input type="hidden" name="defaultDate" id="defaultDate" value="<?php echo $start_date; ?>"/>
            <input type="hidden" name="minDate" id="minDate" value="<?php echo $min_date; ?>"/>
            <input type="hidden" name="btn_submit" id="btn_submit" value="" />
             <input type="submit" class="btn-u btn-u-large pull-right" id="myquote" name="My Quote" value="Get Quote">
            <input type="hidden" name="original_weight_1" id="original_weight_1" />
            <input type="hidden" name="chargeable_weight" id="chargeable_weight" />
            <input type="hidden" name="volumetric_weight" id="volumetric_weight" />

            <input type="hidden" name="international_total_weight" id="international_total_weight" />
            <input type="hidden" name="international_total_volumetric_weight" id="international_total_volumetric_weight" />
            <input type="hidden" name="international_chargeable_weight" id="international_chargeable_weight" />
            <input type="hidden" name="international_total_qty" id="international_total_qty" />


            </div>
        </div><!--	/End more_light-->

        </form>
        </div><!--containerBlock -->
	<?php // How to make a booking is disabled as it has now a dedicated page //
	       if (isset($_SERVER['HTTP_REFERER']) && ($_SERVER['HTTP_REFERER']==SITE_URL.'zombie.php')) {?>
        <!-- Booking in 5 steps -->
        <div class="span6">
            <div class="bg-green">
                <div class="headline"><h2 class="my_5_steps_header"><?php echo INDEX_5_STEPS; ?></h2></div>
                <div class="headline my_5_steps"><h4><?php echo INDEX_5_STEPS_BELOW; ?></h4></div>
                <div id="myCarousel" class="carousel slide carousel-margin-b">
                    <div class="carousel-inner">
                      <div class="item active">
                        <img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>5steps/priority-logistics-booking-in-5-steps-p01.jpg" alt="" />
                        <div class="carousel-caption">
                          <p><?php echo INDEX_5_STEPS_1; ?></p>
                        </div>
                      </div>
                      <div class="item">
                        <img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>5steps/priority-logistics-booking-in-5-steps-p02.jpg" alt="" />
                        <div class="carousel-caption">
                          <p><?php echo INDEX_5_STEPS_2; ?></p>
                        </div>
                      </div>
                      <div class="item">
                        <img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>5steps/priority-logistics-booking-in-5-steps-p03.jpg" alt="" />
                        <div class="carousel-caption">
                          <p><?php echo INDEX_5_STEPS_3; ?></p>
                        </div>
                      </div>
                      <div class="item">
                        <img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>5steps/priority-logistics-booking-in-5-steps-p04.jpg" alt="" />
                        <div class="carousel-caption">
                          <p><?php echo INDEX_5_STEPS_4; ?></p>
                        </div>
                      </div>
                      <div class="item">
                        <img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>5steps/priority-logistics-booking-in-5-steps-p05.jpg" alt="" />
                        <div class="carousel-caption">
                          <p><?php echo INDEX_5_STEPS_5; ?></p>
                        </div>
                      </div>
                    </div>

                    <div class="carousel-arrow">
                        <a class="left carousel-control" href="#myCarousel" data-slide="prev"><i class="icon-angle-left"></i></a>
                        <a class="right carousel-control" href="#myCarousel" data-slide="next"><i class="icon-angle-right"></i></a>
                    </div>
                </div>
            </div><!--/span4-->
        </div><!--/Booking in 5 steps -->
			<?php } // How to make a booking is disabled as it has now a dedicated page //?>
        <!--	Register Small -->
        <div id="register_small" class="span6">
        <?php if(defined('SES_USER_ID')){ ?>
			<div class="row-fluid margin-bottom-40"></div>
		<?php }else{ ?>
        <!-- Registration Block -->
            <div class="row-fluid purchase margin-bottom-30">
                <div class="container">
                    <div class="span12">
                    <span>Don't have an account yet?</span>
                    <p class="justy">Take benefit from many special offers with Priority Couriers and unlock the full potencial of our portal. Don't wait any longer, sign up now!</p>
                    </div>
                    <div id="reg_small_spacer" class="span12"></div>
                    <!-- Temp Unavailable	<a href="<?php echo show_page_link(FILE_SIGNUP);?>" class="btn-buy hover-effect">Registration</a> -->
                    <a href="<?php echo show_page_link(FILE_SIGNUP);?>" class="btn-u hover-effect pull-right">Registration</a>
                </div>
            </div><!--/ End Registration Block -->
        <?php } ?>
        </div><!--/Register Small -->
	</div><!--/row-fluid-->
	<!-- //End Top Blokcs -->

    <!--	Register Small -->
  	<div id="register_big">
	<?php if(defined('SES_USER_ID')){ ?>
		<div class="row-fluid margin-bottom-40"></div>
	<?php }else{ ?>
	<!-- Registration Block -->
		<div class="row-fluid purchase margin-bottom-30">
   			<div class="container">
				<div class="span9">
            		<span>Don't have an account yet?</span>
            		<p>Take benefit from many special offers with Priority Couriers and unlock the full potencial of our portal. Don't wait any longer, sign up now!</p>
        		</div>
        		<!-- Temp Unavailable	<a href="<?php echo show_page_link(FILE_SIGNUP);?>" class="btn-buy hover-effect">Registration</a> -->
        		<a href="<?php echo show_page_link(FILE_SIGNUP);?>" class="btn-buy hover-effect">Registration</a>
    		</div>
		</div><!--/ End Registration Block -->
	<?php } ?>
    </div><!--/End Register Small -->
<!-- Key Points Blocks -->
	<div class="row-fluid">
    	<div class="span4">
    		<div class="service clearfix">
                <i class="icon-envelope-alt"></i>
    			<div class="desc">
    				<h4>Domestic</h4>
                    <p>Same day metropolitan and inter-capital city express services, economy overnight services and integrated road and airfreight solutions for larger shipments.</p>
    			</div>
    		</div>
    	</div>
    	<div class="span4">
    		<div class="service clearfix">
                <i class="icon-plane"></i>
    			<div class="desc">
    				<h4>International</h4>
                    <p>Priority Couriers tries to make the world a smaller place for you to do business in.</p>
    			</div>
    		</div>
    	</div>
    	<div class="span4">
    		<div class="service clearfix">
                <i class="icon-edit"></i>
    			<div class="desc">
    				<h4>Bookings</h4>
                    <p>You can manage the booking and tracing of your consignments 24/7 using “Track & Trace” button.</p>
    			</div>
    		</div>
    	</div>
	</div><!--/row-fluid-->
	<!-- //End Key Points Blokcs -->

	<!-- Services Highlights -->
	<div class="headline"><h3>Services highlights</h3></div>
    <ul class="thumbnails">
        <li class="span4">
            <div class="thumbnail-style thumbnail-kenburn">
            	<div class="thumbnail-img">
                    <div class="overflow-hidden"><img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>Banners/Metro2.jpg" alt="" /></div>
                    <a class="btn-more hover-effect" href="<?php echo show_page_link(FILE_CMS .'?page=services');?>#anchor-sdm">read more +</a>
                </div>
                <h3><a class="hover-effect" href="#"><?php echo COMMON_METRO; ?></a></h3>
                <p>Priority Couriers provide same day and overnight metro deliveries tailored especially to your needs.</p>
            </div>
        </li>
        <li class="span4">
            <div class="thumbnail-style thumbnail-kenburn">
            	<div class="thumbnail-img">
                    <div class="overflow-hidden"><img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>Banners/Domestic.jpg" alt="" /></div>
                    <a class="btn-more hover-effect" href="<?php echo show_page_link(FILE_CMS .'?page=services');?>#anchor-ovr">read more +</a>
                </div>
                <h3><a class="hover-effect" href="#"><?php echo COMMON_INTERSTATE; ?></a></h3>
                <p>Priority Couriers offer a broad range of domestic courier services throughout Australia. Together with our contracted agents we can deliver to virtually every address in Australia.</p>
            </div>
        </li>
        <li class="span4">
            <div class="thumbnail-style thumbnail-kenburn">
            	<div class="thumbnail-img">
                    <div class="overflow-hidden"><img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>Banners/International.jpg" alt="Priority Logistics - International delivery" /></div>
                    <a class="btn-more hover-effect" href="<?php echo show_page_link(FILE_CMS .'?page=services');?>#anchor-int">read more +</a>
                </div>
                <h3><a class="hover-effect" href="#"><?php echo COMMON_INTERNATIONAL; ?></a></h3>
                <p>Using the networks of our specialist partners, we can ship your consignments by air as easily as local deliveries.</p>
            </div>
        </li>
    </ul><!--/thumbnails-->
	<!-- //End Recent Works -->

	<div class="row-fluid">
	<div class="span4"></div>
    <div class="span4">
	<!-- Our Clients -->
	<div id="clients-flexslider" class="flexslider home clients">
        <div class="headline"><h3>Our Partners</h3></div>
		<ul class="slides">
			<li>
                <a href="#">
                    <img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>Partners/StarTrackBlue-Logo_60.jpg" alt="" />
                    <img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>Partners/StarTrackBlue-Logo_60.jpg" class="color-img" alt="" />
                </a>
            </li>
			<li>
                <a href="#">
                    <img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>Partners/UPS-Logo_60.jpg" alt="" />
                    <img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>Partners/UPS-Logo_60.jpg" class="color-img" alt="" />
                </a>
            </li>
		</ul>
	</div><!--/flexslider-->
    </div>
    <div class="span4"></div>
    </div>
	<!-- //End Our Clients -->
</div><!--/container-->
<!-- End Content Part -->

<!-- International service not available pop up -->
<div class="modal hide fade small_rates" id="InterService" data-backdrop="static" data-keyboard="false">
	<div class="modal-header">
	<h3><?php echo INTERNATIONAL_NOT_AVAILABLE_HEAD; ?></h3>
	</div>
	<div class="modal-body" id="AvailableServices">
 	<?php echo INTERNATIONAL_NOT_AVAIL_SERVICE; ?>
   	</div>
	<div class="modal-footer">
   		<span class="white-space"><a href="#more_light" id="closeInt" class="btn-u">Close</a></span>
   	</div>
</div>
<!--	/End International service not available pop up -->
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
