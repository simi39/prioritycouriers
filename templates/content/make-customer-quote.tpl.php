<div class="breadcrumbs margin-bottom-50">
    <div class="container">
        <h1 class="color-green pull-left"><?php echo MAKE_CUSTOMER_DETAILS; ?></h1>
        <ul class="pull-right breadcrumb">
            <li><a href="<?php echo SITE_INDEX;?>"><?php echo COMMON_HOME; ?></a> <span class="divider">/</span></li>
            <li class="active"><?php echo MAKE_CUSTOMER_DETAILS; ?></li>
        </ul>
    </div><!--/container-->
</div><!--/breadcrumbs-->
<div class="container">
	<div class="row-fluid margin-bottom-10">
		<div class="containerBlock">
			<form name="make_customer_quote" id="make_customer_quote" autocomplete='off' class="quote-page" method="post">
                <div class="controls">
                    <div class="span6 form-group control-group">
                        <label class="control-label"><?php echo MAKE_CUSTOMER_DROP_DOWN_LIST; ?><span class="color-red">*</span></label>
                        <select class="span6" tabindex="1" id="customer_list" name="customer_list">
                                <option value="">Select</option>
                                <?php

                                    foreach ($objQuoteCustomerData as $QuoteCustomerDetails)
                                    {
                                                                       ?>
                                <option id="<?php  echo filter_var($QuoteCustomerDetails->id,FILTER_VALIDATE_INT);?>" value="<?php echo filter_var($QuoteCustomerDetails->id,FILTER_VALIDATE_INT);?>" <?php if($QuoteCustomerDetails->id == $_POST['customer_list']){echo "selected"; }else{ echo $selected;} ?>>
                                <?php echo valid_output($QuoteCustomerDetails->first_name);?>
                                <?php } ?>
                                </option>
                            </select>
                    </div>
                </div>
                <div>
                    <div class="span6 form-group control-group">
                        <label class="control-label"><?php echo MAKE_CUSTOMER_QUOTE; ?><span class="color-red">*</span></label>
                        <input name="quote" id="quote" type="text" class="span6 form-control" value="" tabindex="1" autocomplete='off'/>
                        <label class="control-label"><?php echo MAKE_CUSTOMER_NAME; ?><span class="color-red">*</span></label>
                        <input name="quote" id="quote" type="text" class="span6 form-control" value="" tabindex="1" autocomplete='off'/> 
                        <label class="control-label"><?php echo MAKE_DATE; ?><span class="color-red">*</span></label>
                        <div class='form-group control-group'>
                            <div class="span6 form-group">
                                <input type="hidden" id="dateArr" value="<?php echo $date_arr; ?>" />
                                <div class='input-group date' id='datetimepicker1'>
                                <label class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></label>
                                <input type='text' class="form-control"  readonly  data-toggle="tooltip"  name="selectedDate" id="selectedDate" title="Change collection time and date"/>
                                </div>
                            </div>
                        </div>
                        <div class='span6 form-group control-group'>
                        </div>
                        <label class="control-label"><?php echo MAKE_QUOTE_EXPIRY; ?><span class="color-red">*</span></label>
                        <input name="quote" id="quote" type="text" class="span6 form-control" value="" tabindex="1" autocomplete='off'/> 
                        <label class="control-label"><?php echo MAKE_EXPIRY_DATE; ?><span class="color-red">*</span></label>
                        <input name="quote" id="quote" type="text" class="span6 form-control" value="" tabindex="1" autocomplete='off'/> 
                        <label class="control-label"><?php echo MAKE_SERVICE; ?><span class="color-red">*</span></label>
                        <input name="quote" id="quote" type="text" class="span6 form-control" value="" tabindex="1" autocomplete='off'/>              
                    </div>   
                </div>
			</form>
		</div>
	</div>
</div>