<!--=== Breadcrumbs ===-->
<div class="breadcrumbs margin-bottom-60">
	<div class="container">
        <h1 class="pull-left"><?php echo COMMON_CONTENTS; ?></h1>
        <ul class="pull-right breadcrumb">
            <li><a href="<?php echo SITE_INDEX;?>"><?php echo COMMON_HOME; ?></a> <span class="divider">/</span></li>
            <li class="active"><?php echo COMMON_CONTENTS; ?></li>
        </ul>
    </div><!--/container-->
</div><!--/breadcrumbs-->
<!--=== End Breadcrumbs ===-->
<!--=== Content Part ===-->
<div class="container">
<div class="row-fluid">

	<?php
	/*echo "<pre>";
	print_r($BookingDatashow);
	print_r($BookingItemDetailsData);
	//echo $selectCountryOrigin;
	echo "</pre>";*/  ?>

<form name="additional-detailsForm" id="additional-detailsForm" autocomplete='off' method="post">
	<div class="span9 margin-bottom-20 margin-left_0 bg-lighter">
		<!--==	First Block	==-->
		<div class="span12 margin-left_0 margin-bottom-20">
      <h3 class="my_green margin-bottom-40"><?php //echo COMMON_CONTENTS; ?></h3>
		<?php
		if($BookingDatashow->flag =='international')
		{
		?>
<!--==	International	==-->
<!--==	Select Item Type	==-->
<!--<div class="span6 form-group control-group margin-bottom_0">
	 		<label class="control-label"><p class="my_bigger_font"><?php echo COMMON_ITEM_TYPE; ?>&nbsp;</p></label>
			<div class="control">
				<select id="goods_nature" class="form-control"  tabindex="1" name="goods_nature" onchange="javascript: toggleListDiv();">
					<option value="">Select</option>
					<?php foreach ($additionalParamOptions as $key=>$val){
						$optionVal = valid_output($val);
						if(strpos($val,"_")){
							$val = str_replace("_"," ",$val);
						}
						$val = ucfirst($val);
						?>
					<option value="<?php echo valid_output($optionVal);?>" <?php if(valid_output($BookingDatashow->goods_nature) == $optionVal){ echo "selected = 'selected'";}?>><?php echo valid_output($val);?> </option>
					<?php } ?>
				</select>
				<span class="autocomplete_index help-block alert-error" id="goods_nature_message"></span>
				<?php if(isset($err['additionalErr'])){ ?>
					<div class="alert alert-error show" id="additional_Error_css">
						<div class="requiredInformation" id="additional_Error"><?php echo $err['additionalErr']; ?></div>
					</div>
				<?php } ?>
			</div>
		</div>--><!--==/End Select Item Type	==-->
			<!-- Other Goods Description Field	-->
			<div class="items_wrapper span12">
				<!--=== Text Field	===-->
				<div class="form-group control-group">
				<p class="my_green"><?php echo COMMON_CONTENTS; ?>&nbsp;<a id="popup" class="details-link" data-toggle="modal" href="#<?php echo "div_describe-goods"; ?>" ><i class="icon-question-sign my_red"></i></a></p>
				<?php
					$CmsPageName = "describe-goods";
					$Describe_goods = cmsPageContent($CmsPageName);
					echo lightBoxCmsDesc($Describe_goods);
				?>
				<textarea class="form-control span12"  tabindex="1" id="goods_description_au" rows="1" name="goods_description_au" onkeyup="javascript:removeError('goods_description_au_Error_css');" data-toggle="tooltip" data-original-title="<?php echo $desc_goods_tooltip; ?>" autocomplete='off'/><?php if(isset($_POST['goods_description_au']) && $_POST['goods_description_au']!=""){ echo valid_output($_POST['goods_description_au']);}else{ echo valid_output($BookingDatashow->description_of_goods); }?></textarea><br />
					<span class="autocomplete_index help-block alert-error" id="goods_description_au_message"></span>
					<?php if(isset($err['gooddescription'])){ ?>
					<!-- PHP Validation	-->
					<div class="alert alert-error show" id="goods_description_au_Error_css">
						<div class="requiredInformation" id="goods_description_au_Error"><?php echo $err['gooddescription']; ?></div>
					</div><!--	End PHP Validation	-->
					<?php } ?>
				</div><!--===/End Text Field	===-->
			</div><!-- Other Goods Description Field	-->
			<!-- Export Reason Field	-->
			<?php

			if(($BookingDatashow->flag =="international" && !empty($BookingItemDetailsData))){
				foreach ($BookingItemDetailsData as $booingItemValue) {
					if(isset($booingItemValue['item_type']) && $booingItemValue['item_type']=='5') {
						$nondoc_active = 'active';
					}
				}
			}
			if(isset($nondoc_active) && $nondoc_active =='active') {

			?>
			<div class="items_wrapper span12">
				<p class="my_green"><?php echo COMMERCIAL_INVOCIE_EXPORT_REASON; ?></p>
					<select class="form-control" name="export_reason" id="export_reason">
						<option value="">Select Reason</option>
						<option value="1" <?php if(valid_output($BookingDatashow->export_reason) == '1'){ echo "selected = 'selected'";}elseif(isset($_POST['export_reason']) && $_POST['export_reason'] == '1') {echo "selected = 'selected'";}?>>Sale</option>
						<option value="2" <?php if(valid_output($BookingDatashow->export_reason) == '2'){ echo "selected = 'selected'";}elseif(isset($_POST['export_reason']) && $_POST['export_reason'] == '2') {echo "selected = 'selected'";}?>>Sample</option>
						<option value="3" <?php if(valid_output($BookingDatashow->export_reason) == '3'){ echo "selected = 'selected'";}elseif(isset($_POST['export_reason']) && $_POST['export_reason'] == '3') {echo "selected = 'selected'";}?>>Gift</option>
						<option value="4" <?php if(valid_output($BookingDatashow->export_reason) == '4'){ echo "selected = 'selected'";}elseif(isset($_POST['export_reason']) && $_POST['export_reason'] == '4') {echo "selected = 'selected'";}?>>Return</option>
						<option value="5" <?php if(valid_output($BookingDatashow->export_reason) == '5'){ echo "selected = 'selected'";}elseif(isset($_POST['export_reason']) && $_POST['export_reason'] == '5') {echo "selected = 'selected'";}?>>Repair</option>
						<option value="6" <?php if(valid_output($BookingDatashow->export_reason) == '6'){ echo "selected = 'selected'";}elseif(isset($_POST['export_reason']) && $_POST['export_reason'] == '6') {echo "selected = 'selected'";}?>>Temporary Export</option>
						<option value="7" <?php if(valid_output($BookingDatashow->export_reason) == '7'){ echo "selected = 'selected'";}elseif(isset($_POST['export_reason']) && $_POST['export_reason'] == '7') {echo "selected = 'selected'";}?>>Exhibition Goods</option>
						<option value="8" <?php if(valid_output($BookingDatashow->export_reason) == '8'){ echo "selected = 'selected'";}elseif(isset($_POST['export_reason']) && $_POST['export_reason'] == '8') {echo "selected = 'selected'";}?>>Testing/Analysis</option>
					</select>
				<!--=== Text Field	===-->
				<div class="form-group control-group">
				<!--<textarea class="span10 form-control"  tabindex="1" id="export_reason" rows="1" name="export_reason" onkeyup="javascript:removeError('export_reason_Error_css');" data-toggle="tooltip" data-original-title="<?php echo $desc_goods_tooltip; ?>" autocomplete='off'/><?php if(isset($_POST['export_reason']) && $_POST['export_reason']!=""){ echo valid_output($_POST['export_reason']);}else{ echo valid_output($BookingDatashow->export_reason); }?></textarea>-->
					<span class="autocomplete_index help-block alert-error" id="export_reason_message"></span>
					<?php if(isset($err['exportreason'])){ ?>
					<!-- PHP Validation	-->
					<div class="autocomplete_index help-block alert-error has-error show" id="export_reason_Error_css">
						<div class="requiredInformation help-block" id="export_reason_Error"><?php echo $err['exportreason']; ?></div>
					</div><!--	End PHP Validation	-->
					<?php } ?>
				</div><!--===/End Text Field	===-->
			</div><!--== End Export Reason Field	-->
			<!-- Value of Goods for Customs	-->
			<div class="items_wrapper span12">
			<span class="form-group control-group white-space">
					<p class="my_green"><?php echo CURRENCY_CODE; ?></p>
				  <select class="form-control" name="currency_code" id="currency_code">
						<option value="AUD"<?php if(valid_output($BookingDatashow->currency_codes) == 'AUD'){ echo "selected = 'selected'";}elseif(isset($_POST['currency_code']) && $_POST['currency_code'] == 'AUD') {echo "selected = 'selected'";}?>>Australian Dollars</option>
						<option value="USD" <?php if(valid_output($BookingDatashow->currency_codes) == 'USD'){ echo "selected = 'selected'";}elseif(isset($_POST['currency_code']) && $_POST['currency_code'] == 'USD') {echo "selected = 'selected'";}?>>United States Dollars</option>
						<option value="EUR" <?php if(valid_output($BookingDatashow->currency_codes) == 'EUR'){ echo "selected = 'selected'";}elseif(isset($_POST['currency_code']) && $_POST['currency_code'] == 'EUR') {echo "selected = 'selected'";}?>>Euro</option>
						<option value="GBP" <?php if(valid_output($BookingDatashow->currency_codes) == 'GBP'){ echo "selected = 'selected'";}elseif(isset($_POST['currency_code']) && $_POST['currency_code'] == 'GBP') {echo "selected = 'selected'";}?>>United Kingdom Pounds</option>
						<option value="DZD" <?php if(valid_output($BookingDatashow->currency_codes) == 'DZD'){ echo "selected = 'selected'";}elseif(isset($_POST['currency_code']) && $_POST['currency_code'] == 'DZD') {echo "selected = 'selected'";}?>>Algeria Dinars</option>
						<option value="ARP" <?php if(valid_output($BookingDatashow->currency_codes) == 'ARP'){ echo "selected = 'selected'";}elseif(isset($_POST['currency_code']) && $_POST['currency_code'] == 'ARP') {echo "selected = 'selected'";}?>>Argentina Pesos</option>
						<option value="ATS"<?php if(valid_output($BookingDatashow->currency_codes) == 'ATS'){ echo "selected = 'selected'";}elseif(isset($_POST['currency_code']) && $_POST['currency_code'] == 'ATS') {echo "selected = 'selected'";}?>>Austria Schillings</option>
						<option value="BSD"<?php if(valid_output($BookingDatashow->currency_codes) == 'BSD'){ echo "selected = 'selected'";}elseif(isset($_POST['currency_code']) && $_POST['currency_code'] == 'BSD') {echo "selected = 'selected'";}?>>Bahamas Dollars</option>
						<option value="BBD"<?php if(valid_output($BookingDatashow->currency_codes) == 'BBD'){ echo "selected = 'selected'";}elseif(isset($_POST['currency_code']) && $_POST['currency_code'] == 'BBD') {echo "selected = 'selected'";}?>>Barbados Dollars</option>
						<option value="BEF"<?php if(valid_output($BookingDatashow->currency_codes) == 'BEF'){ echo "selected = 'selected'";}elseif(isset($_POST['currency_code']) && $_POST['currency_code'] == 'BEF') {echo "selected = 'selected'";}?>>Belgium Francs</option>
						<option value="BMD"<?php if(valid_output($BookingDatashow->currency_codes) == 'BMD'){ echo "selected = 'selected'";}elseif(isset($_POST['currency_code']) && $_POST['currency_code'] == 'BMD') {echo "selected = 'selected'";}?>>Bermuda Dollars</option>
						<option value="BRR"<?php if(valid_output($BookingDatashow->currency_codes) == 'BRR'){ echo "selected = 'selected'";}elseif(isset($_POST['currency_code']) && $_POST['currency_code'] == 'BRR') {echo "selected = 'selected'";}?>>Brazil Real</option>
						<option value="BGL"<?php if(valid_output($BookingDatashow->currency_codes) == 'BGL'){ echo "selected = 'selected'";}elseif(isset($_POST['currency_code']) && $_POST['currency_code'] == 'BGL') {echo "selected = 'selected'";}?>>Bulgaria Lev</option>
						<option value="CAD"<?php if(valid_output($BookingDatashow->currency_codes) == 'CAD'){ echo "selected = 'selected'";}elseif(isset($_POST['currency_code']) && $_POST['currency_code'] == 'CAD') {echo "selected = 'selected'";}?>>Canada Dollars</option>
						<option value="CLP"<?php if(valid_output($BookingDatashow->currency_codes) == 'CLP'){ echo "selected = 'selected'";}elseif(isset($_POST['currency_code']) && $_POST['currency_code'] == 'CLP') {echo "selected = 'selected'";}?>>Chile Pesos</option>
						<option value="CNY"<?php if(valid_output($BookingDatashow->currency_codes) == 'CNY'){ echo "selected = 'selected'";}elseif(isset($_POST['currency_code']) && $_POST['currency_code'] == 'CNY') {echo "selected = 'selected'";}?>>China Yuan Renmimbi</option>
						<option value="CYP" <?php if(valid_output($BookingDatashow->currency_codes) == 'CYP'){ echo "selected = 'selected'";}elseif(isset($_POST['currency_code']) && $_POST['currency_code'] == 'CYP') {echo "selected = 'selected'";}?>>Cyprus Pounds</option>
						<option value="CSK" <?php if(valid_output($BookingDatashow->currency_codes) == 'CSK'){ echo "selected = 'selected'";}elseif(isset($_POST['currency_code']) && $_POST['currency_code'] == 'CSK') {echo "selected = 'selected'";}?>>Czech Republic Koruna</option>
						<option value="DKK" <?php if(valid_output($BookingDatashow->currency_codes) == 'DKK'){ echo "selected = 'selected'";}elseif(isset($_POST['currency_code']) && $_POST['currency_code'] == 'DKK') {echo "selected = 'selected'";}?>>Denmark Kroner</option>
						<option value="NLG"<?php if(valid_output($BookingDatashow->currency_codes) == 'NLG'){ echo "selected = 'selected'";}elseif(isset($_POST['currency_code']) && $_POST['currency_code'] == 'NLG') {echo "selected = 'selected'";}?>>Dutch Guilders</option>
						<option value="XCD"<?php if(valid_output($BookingDatashow->currency_codes) == 'XCD'){ echo "selected = 'selected'";}elseif(isset($_POST['currency_code']) && $_POST['currency_code'] == 'XCD') {echo "selected = 'selected'";}?>>Eastern Caribbean Dollars</option>
						<option value="EGP"<?php if(valid_output($BookingDatashow->currency_codes) == 'EGP'){ echo "selected = 'selected'";}elseif(isset($_POST['currency_code']) && $_POST['currency_code'] == 'EGP') {echo "selected = 'selected'";}?>>Egypt Pounds</option>
						<option value="FJD"<?php if(valid_output($BookingDatashow->currency_codes) == 'FJD'){ echo "selected = 'selected'";}elseif(isset($_POST['currency_code']) && $_POST['currency_code'] == 'FJD') {echo "selected = 'selected'";}?>>Fiji Dollars</option>
						<option value="FIM"<?php if(valid_output($BookingDatashow->currency_codes) == 'FIM'){ echo "selected = 'selected'";}elseif(isset($_POST['currency_code']) && $_POST['currency_code'] == 'FIM') {echo "selected = 'selected'";}?>>Finland Markka</option>
						<option value="FRF"<?php if(valid_output($BookingDatashow->currency_codes) == 'FRF'){ echo "selected = 'selected'";}elseif(isset($_POST['currency_code']) && $_POST['currency_code'] == 'FRF') {echo "selected = 'selected'";}?>>France Francs</option>
						<option value="DEM"<?php if(valid_output($BookingDatashow->currency_codes) == 'DEM'){ echo "selected = 'selected'";}elseif(isset($_POST['currency_code']) && $_POST['currency_code'] == 'DEM') {echo "selected = 'selected'";}?>>Germany Deutsche Marks</option>
						<option value="XAU"<?php if(valid_output($BookingDatashow->currency_codes) == 'XAU'){ echo "selected = 'selected'";}elseif(isset($_POST['currency_code']) && $_POST['currency_code'] == 'XAU') {echo "selected = 'selected'";}?>>Gold Ounces</option>
						<option value="GRD"<?php if(valid_output($BookingDatashow->currency_codes) == 'GRD'){ echo "selected = 'selected'";}elseif(isset($_POST['currency_code']) && $_POST['currency_code'] == 'GRD') {echo "selected = 'selected'";}?>>Greece Drachmas</option>
						<option value="HKD"<?php if(valid_output($BookingDatashow->currency_codes) == 'HKD'){ echo "selected = 'selected'";}elseif(isset($_POST['currency_code']) && $_POST['currency_code'] == 'HKD') {echo "selected = 'selected'";}?>>Hong Kong Dollars</option>
						<option value="HUF" <?php if(valid_output($BookingDatashow->currency_codes) == 'HUF'){ echo "selected = 'selected'";}elseif(isset($_POST['currency_code']) && $_POST['currency_code'] == 'HUF') {echo "selected = 'selected'";}?>>Hungary Forint</option>
						<option value="ISK"<?php if(valid_output($BookingDatashow->currency_codes) == 'ISK'){ echo "selected = 'selected'";}elseif(isset($_POST['currency_code']) && $_POST['currency_code'] == 'ISK') {echo "selected = 'selected'";}?>>Iceland Krona</option>
						<option value="INR"<?php if(valid_output($BookingDatashow->currency_codes) == 'INR'){ echo "selected = 'selected'";}elseif(isset($_POST['currency_code']) && $_POST['currency_code'] == 'INR') {echo "selected = 'selected'";}?>>India Rupees</option>
						<option value="IDR"<?php if(valid_output($BookingDatashow->currency_codes) == 'IDR'){ echo "selected = 'selected'";}elseif(isset($_POST['currency_code']) && $_POST['currency_code'] == 'IDR') {echo "selected = 'selected'";}?>>Indonesia Rupiah</option>
						<option value="IEP"<?php if(valid_output($BookingDatashow->currency_codes) == 'IEP'){ echo "selected = 'selected'";}elseif(isset($_POST['currency_code']) && $_POST['currency_code'] == 'IEP') {echo "selected = 'selected'";}?>>Ireland Punt</option>
						<option value="ILS"<?php if(valid_output($BookingDatashow->currency_codes) == 'ILS'){ echo "selected = 'selected'";}elseif(isset($_POST['currency_code']) && $_POST['currency_code'] == 'ILS') {echo "selected = 'selected'";}?>>Israel New Shekels</option>
						<option value="ITL"<?php if(valid_output($BookingDatashow->currency_codes) == 'ITL'){ echo "selected = 'selected'";}elseif(isset($_POST['currency_code']) && $_POST['currency_code'] == 'ITL') {echo "selected = 'selected'";}?>>Italy Lira</option>
						<option value="JMD"<?php if(valid_output($BookingDatashow->currency_codes) == 'JMD'){ echo "selected = 'selected'";}elseif(isset($_POST['currency_code']) && $_POST['currency_code'] == 'JMD') {echo "selected = 'selected'";}?>>Jamaica Dollars</option>
						<option value="JPY"<?php if(valid_output($BookingDatashow->currency_codes) == 'JPY'){ echo "selected = 'selected'";}elseif(isset($_POST['currency_code']) && $_POST['currency_code'] == 'JPY') {echo "selected = 'selected'";}?>>Japan Yen</option>
						<option value="JOD"<?php if(valid_output($BookingDatashow->currency_codes) == 'JOD'){ echo "selected = 'selected'";}elseif(isset($_POST['currency_code']) && $_POST['currency_code'] == 'JOD') {echo "selected = 'selected'";}?>>Jordan Dinar</option>
						<option value="KRW"<?php if(valid_output($BookingDatashow->currency_codes) == 'KRW'){ echo "selected = 'selected'";}elseif(isset($_POST['currency_code']) && $_POST['currency_code'] == 'KRW') {echo "selected = 'selected'";}?>>Korea (South) Won</option>
						<option value="LBP"<?php if(valid_output($BookingDatashow->currency_codes) == 'LBP'){ echo "selected = 'selected'";}elseif(isset($_POST['currency_code']) && $_POST['currency_code'] == 'LBP') {echo "selected = 'selected'";}?>>Lebanon Pounds</option>
						<option value="LUF"<?php if(valid_output($BookingDatashow->currency_codes) == 'LUF'){ echo "selected = 'selected'";}elseif(isset($_POST['currency_code']) && $_POST['currency_code'] == 'LUF') {echo "selected = 'selected'";}?>>Luxembourg Francs</option>
						<option value="MYR"<?php if(valid_output($BookingDatashow->currency_codes) == 'MYR'){ echo "selected = 'selected'";}elseif(isset($_POST['currency_code']) && $_POST['currency_code'] == 'MYR') {echo "selected = 'selected'";}?>>Malaysia Ringgit</option>
						<option value="MXP"<?php if(valid_output($BookingDatashow->currency_codes) == 'MXP'){ echo "selected = 'selected'";}elseif(isset($_POST['currency_code']) && $_POST['currency_code'] == 'MXP') {echo "selected = 'selected'";}?>>Mexico Pesos</option>
						<option value="NLG"<?php if(valid_output($BookingDatashow->currency_codes) == 'NLG'){ echo "selected = 'selected'";}elseif(isset($_POST['currency_code']) && $_POST['currency_code'] == 'NLG') {echo "selected = 'selected'";}?>>Netherlands Guilders</option>
						<option value="NZD"<?php if(valid_output($BookingDatashow->currency_codes) == 'NZD'){ echo "selected = 'selected'";}elseif(isset($_POST['currency_code']) && $_POST['currency_code'] == 'NZD') {echo "selected = 'selected'";}?>>New Zealand Dollars</option>
						<option value="NOK"<?php if(valid_output($BookingDatashow->currency_codes) == 'NOK'){ echo "selected = 'selected'";}elseif(isset($_POST['currency_code']) && $_POST['currency_code'] == 'NOK') {echo "selected = 'selected'";}?>>Norway Kroner</option>
						<option value="PKR"<?php if(valid_output($BookingDatashow->currency_codes) == 'PKR'){ echo "selected = 'selected'";}elseif(isset($_POST['currency_code']) && $_POST['currency_code'] == 'PKR') {echo "selected = 'selected'";}?>>Pakistan Rupees</option>
						<option value="XPD"<?php if(valid_output($BookingDatashow->currency_codes) == 'XPD'){ echo "selected = 'selected'";}elseif(isset($_POST['currency_code']) && $_POST['currency_code'] == 'XPD') {echo "selected = 'selected'";}?>>Palladium Ounces</option>
						<option value="PHP"<?php if(valid_output($BookingDatashow->currency_codes) == 'PHP'){ echo "selected = 'selected'";}elseif(isset($_POST['currency_code']) && $_POST['currency_code'] == 'PHP') {echo "selected = 'selected'";}?>>Philippines Pesos</option>
						<option value="XPT"<?php if(valid_output($BookingDatashow->currency_codes) == 'XPT'){ echo "selected = 'selected'";}elseif(isset($_POST['currency_code']) && $_POST['currency_code'] == 'XPT') {echo "selected = 'selected'";}?>>Platinum Ounces</option>
						<option value="PLZ"<?php if(valid_output($BookingDatashow->currency_codes) == 'PLZ'){ echo "selected = 'selected'";}elseif(isset($_POST['currency_code']) && $_POST['currency_code'] == 'PLZ') {echo "selected = 'selected'";}?>>Poland Zloty</option>
						<option value="PTE"<?php if(valid_output($BookingDatashow->currency_codes) == 'PTE'){ echo "selected = 'selected'";}elseif(isset($_POST['currency_code']) && $_POST['currency_code'] == 'PTE') {echo "selected = 'selected'";}?>>Portugal Escudo</option>
						<option value="ROL"<?php if(valid_output($BookingDatashow->currency_codes) == 'ROL'){ echo "selected = 'selected'";}elseif(isset($_POST['currency_code']) && $_POST['currency_code'] == 'ROL') {echo "selected = 'selected'";}?>>Romania Leu</option>
						<option value="RUR"<?php if(valid_output($BookingDatashow->currency_codes) == 'RUR'){ echo "selected = 'selected'";}elseif(isset($_POST['currency_code']) && $_POST['currency_code'] == 'RUR') {echo "selected = 'selected'";}?>>Russia Rubles</option>
						<option value="SAR" <?php if(valid_output($BookingDatashow->currency_codes) == 'SAR'){ echo "selected = 'selected'";}elseif(isset($_POST['currency_code']) && $_POST['currency_code'] == 'SAR') {echo "selected = 'selected'";}?>>Saudi Arabia Riyal</option>
						<option value="XAG"<?php if(valid_output($BookingDatashow->currency_codes) == 'XAG'){ echo "selected = 'selected'";}elseif(isset($_POST['currency_code']) && $_POST['currency_code'] == 'XAG') {echo "selected = 'selected'";}?>>Silver Ounces</option>
						<option value="SGD"<?php if(valid_output($BookingDatashow->currency_codes) == 'SGD'){ echo "selected = 'selected'";}elseif(isset($_POST['currency_code']) && $_POST['currency_code'] == 'SGD') {echo "selected = 'selected'";}?>>Singapore Dollars</option>
						<option value="SKK"<?php if(valid_output($BookingDatashow->currency_codes) == 'SKK'){ echo "selected = 'selected'";}elseif(isset($_POST['currency_code']) && $_POST['currency_code'] == 'SKK') {echo "selected = 'selected'";}?>>Slovakia Koruna</option>
						<option value="ZAR"<?php if(valid_output($BookingDatashow->currency_codes) == 'ZAR'){ echo "selected = 'selected'";}elseif(isset($_POST['currency_code']) && $_POST['currency_code'] == 'ZAR') {echo "selected = 'selected'";}?>>South Africa Rand</option>
						<option value="KRW"<?php if(valid_output($BookingDatashow->currency_codes) == 'KRW'){ echo "selected = 'selected'";}elseif(isset($_POST['currency_code']) && $_POST['currency_code'] == 'KRW') {echo "selected = 'selected'";}?>>South Korea Won</option>
						<option value="ESP"<?php if(valid_output($BookingDatashow->currency_codes) == 'ESP'){ echo "selected = 'selected'";}elseif(isset($_POST['currency_code']) && $_POST['currency_code'] == 'ESP') {echo "selected = 'selected'";}?>>Spain Pesetas</option>
						<option value="XDR"<?php if(valid_output($BookingDatashow->currency_codes) == 'XDR'){ echo "selected = 'selected'";}elseif(isset($_POST['currency_code']) && $_POST['currency_code'] == 'XDR') {echo "selected = 'selected'";}?>>Special Drawing Right (IMF)</option>
						<option value="SDD"<?php if(valid_output($BookingDatashow->currency_codes) == 'SDD'){ echo "selected = 'selected'";}elseif(isset($_POST['currency_code']) && $_POST['currency_code'] == 'SDD') {echo "selected = 'selected'";}?>>Sudan Dinar</option>
						<option value="SEK"<?php if(valid_output($BookingDatashow->currency_codes) == 'SEK'){ echo "selected = 'selected'";}elseif(isset($_POST['currency_code']) && $_POST['currency_code'] == 'SEK') {echo "selected = 'selected'";}?>>Sweden Krona</option>
						<option value="CHF"<?php if(valid_output($BookingDatashow->currency_codes) == 'CHF'){ echo "selected = 'selected'";}elseif(isset($_POST['currency_code']) && $_POST['currency_code'] == 'CHF') {echo "selected = 'selected'";}?>>Switzerland Francs</option>
						<option value="TWD"<?php if(valid_output($BookingDatashow->currency_codes) == 'TWD'){ echo "selected = 'selected'";}elseif(isset($_POST['currency_code']) && $_POST['currency_code'] == 'TWD') {echo "selected = 'selected'";}?>>Taiwan Dollars</option>
						<option value="THB"<?php if(valid_output($BookingDatashow->currency_codes) == 'THB'){ echo "selected = 'selected'";}elseif(isset($_POST['currency_code']) && $_POST['currency_code'] == 'THB') {echo "selected = 'selected'";}?>>Thailand Baht</option>
						<option value="TTD"<?php if(valid_output($BookingDatashow->currency_codes) == 'TTD'){ echo "selected = 'selected'";}elseif(isset($_POST['currency_code']) && $_POST['currency_code'] == 'TTD') {echo "selected = 'selected'";}?>>Trinidad and Tobago Dollars</option>
						<option value="TRL"<?php if(valid_output($BookingDatashow->currency_codes) == 'TRL'){ echo "selected = 'selected'";}elseif(isset($_POST['currency_code']) && $_POST['currency_code'] == 'TRL') {echo "selected = 'selected'";}?>>Turkey Lira</option>
						<option value="VEB"<?php if(valid_output($BookingDatashow->currency_codes) == 'VEB'){ echo "selected = 'selected'";}elseif(isset($_POST['currency_code']) && $_POST['currency_code'] == 'VEB') {echo "selected = 'selected'";}?>>Venezuela Bolivar</option>
						<option value="ZMK"<?php if(valid_output($BookingDatashow->currency_codes) == 'ZMK'){ echo "selected = 'selected'";}elseif(isset($_POST['currency_code']) && $_POST['currency_code'] == 'ZMK') {echo "selected = 'selected'";}?>>Zambia Kwacha</option>
						<option value="EUR"<?php if(valid_output($BookingDatashow->currency_codes) == 'EUR'){ echo "selected = 'selected'";}elseif(isset($_POST['currency_code']) && $_POST['currency_code'] == 'EUR') {echo "selected = 'selected'";}?>>Euro</option>
						<option value="XCD"<?php if(valid_output($BookingDatashow->currency_codes) == 'XCD'){ echo "selected = 'selected'";}elseif(isset($_POST['currency_code']) && $_POST['currency_code'] == 'XCD') {echo "selected = 'selected'";}?>>Eastern Caribbean Dollars</option>
						<option value="XDR"<?php if(valid_output($BookingDatashow->currency_codes) == 'XDR'){ echo "selected = 'selected'";}elseif(isset($_POST['currency_code']) && $_POST['currency_code'] == 'XDR') {echo "selected = 'selected'";}?>>Special Drawing Right (IMF)</option>
						<option value="XAG"<?php if(valid_output($BookingDatashow->currency_codes) == 'XAG'){ echo "selected = 'selected'";}elseif(isset($_POST['currency_code']) && $_POST['currency_code'] == 'XAG') {echo "selected = 'selected'";}?>>Silver Ounces</option>
						<option value="XAU"<?php if(valid_output($BookingDatashow->currency_codes) == 'XAU'){ echo "selected = 'selected'";}elseif(isset($_POST['currency_code']) && $_POST['currency_code'] == 'XAU') {echo "selected = 'selected'";}?>>Gold Ounces</option>
						<option value="XPD"<?php if(valid_output($BookingDatashow->currency_codes) == 'XPD'){ echo "selected = 'selected'";}elseif(isset($_POST['currency_code']) && $_POST['currency_code'] == 'XPD') {echo "selected = 'selected'";}?>>Palladium Ounces</option>
						<option value="XPT"<?php if(valid_output($BookingDatashow->currency_codes) == 'XPT'){ echo "selected = 'selected'";}elseif(isset($_POST['currency_code']) && $_POST['currency_code'] == 'XPT') {echo "selected = 'selected'";}?>>Platinum Ounces</option>
					</select>
					<!--<input type="text" tabindex="3" size="4" placeholder="AUD" value="<?php if(isset($_POST['currency_code']) && $_POST['currency_code']==""){echo "";}elseif(isset($_POST['currency_code']) && $_POST['currency_code']!=""){ echo valid_output($_POST['currency_code']); } else {echo valid_output($BookingDatashow->currency_codes);}?>" class="form-control" name="currency_code" id="currency_code"  autocomplete='off'/>-->
					<span class="autocomplete_index help-block alert-error" id="currency_code_message"></span>
					<?php if(isset($err['currencycode'])){ ?>
						<!-- PHP Validation	-->
						<div class="autocomplete_index help-block alert-error has-error show" id="currency_code_Error_css">
							<div id="currency_code_Error" class="requiredInformation help-block"><?php  echo $err['currencycode']; ?></div>
						</div><!--	End PHP Validation	-->
					<?php } ?>
				</span>
				<span class="form-group control-group white-space">
					<p class="my_green"><?php echo VALUE_OF_GOODS; ?></p>
					<input type="tel"  tabindex="3" size="4" value="<?php if(valid_output($BookingDatashow->values_of_goods)=="0"){echo "0";}elseif(isset($_POST['transit_warranty_au']) && $_POST['transit_warranty_au']!=0){ echo valid_output($_POST['transit_warranty_au']); } else {echo valid_output($BookingDatashow->values_of_goods);}?>" class="form-control" name="transit_warranty_au" id="transit_warranty_int"  autocomplete='off'/><br />
					<span class="autocomplete_index help-block alert-error" id="transit_warranty_int_message"></span>
					<?php if(isset($err['transit_warranty_au'])){ ?>
					<!-- PHP Validation	-->
					<div class="alert alert-error hide" id="transit_warranty_au_Error_css">
						<div id="transit_warranty_au_Error" class="requiredInformation"><?php  echo $err['transit_warranty_au']; ?></div>
					</div><!--	End PHP Validation	-->
					<?php } ?>
				</span>

				<span class="form-group control-group white-space">
					<p class="my_green"><?php echo COUNTRY_ORIGIN; ?></p>
					<?php

					 if(isset($BookingDatashow->country_origin) && $BookingDatashow->country_origin!=""){
						 $selectCountryOrigin=$BookingDatashow->country_origin;
					 }elseif(isset($_POST['country_of_origin']) && $_POST['country_of_origin']!="")
					 {
							$selectCountryOrigin=$_POST['country_of_origin'];
					 }else{
							$selectCountryOrigin="0";
					 }
					 echo getDropeCountry($selectCountryOrigin,'3', 'class="span12 form-control"','country_of_origin');
					 ?>
					 <span class="autocomplete_index help-block alert-error" id="country_origin_message"></span>
					 <?php if(isset($err['countryorigin'])){ ?>
 					 	<!-- PHP Validation	-->
						<div class="autocomplete_index help-block alert-error has-error show" id="country_origin_Error_css">
							<div id="country_origin_Error" class="requiredInformation help-block"><?php  echo $err['countryorigin']; ?></div>
						</div>
						<?php } ?>
				</span>
			</div><!--/End Value of Goods for Customs	-->
			<?php
			}
			?>
	<!--== /End International	==-->
	<?php }else{ ?>
		<!-- Domestic What Are you sending -->
	<!--<div class="span6">
		<div class="form-group control-group">
		 <label class="control-label"><p class="my_bigger_font"><?php echo COMMON_ITEM_TYPE; ?>&nbsp;</p></label>

		<select id="goods_nature" class="form-control"  tabindex="1" name="goods_nature" onchange="javascript: toggleListDiv();">
				<option value="">Select</option>
				<?php foreach ($additionalParamOptions as $key=>$val){
					$optionVal = valid_output($val);
					if(strpos($val,"_")){
						$val = str_replace("_"," ",$val);
					}
					$val = ucfirst($val);
					?>
					<option value="<?php echo valid_output($optionVal);?>" <?php if(valid_output($BookingDatashow->goods_nature) == $optionVal){ echo "selected = 'selected'";}?>><?php echo valid_output($val);?> </option>
				<?php
				}

				?>

			</select>
			<span class="autocomplete_index help-block alert-error" id="goods_nature_message"></span>
			<?php if(isset($err['additionalErr'])){ ?>
			<div class="alert alert-error show" id="additional_Error_css">
				<div class="requiredInformation" id="additional_Error"><?php echo $err['additionalErr']; ?></div>
			</div>
			<?php } ?>
		</div>
	</div>-->
	<!--=== What are you sending AU	===-->
	<div class="span12">
	<!--=== Others	===-->
	<div class="items_wrapper_9">
	<p class="my_green"><?php echo COMMON_CONTENTS; ?></p>
		<!--=== Goods description	===-->
		<div class="form-group control-group">
		<textarea class="span8 form-control"  tabindex="1" id="goods_description_au" rows="1" name="goods_description_au" onkeyup="javascript:removeError('goods_description_au_Error_css');" data-toggle="tooltip" data-original-title="<?php echo $desc_goods_tooltip; ?>" autocomplete='off'/><?php if(isset($_POST['goods_description_au']) && $_POST['goods_description_au']!=""){ echo valid_output($_POST['goods_description_au']);}else{ echo valid_output($BookingDatashow->description_of_goods); }?></textarea><br />
			<span class="autocomplete_index help-block alert-error" id="goods_description_au_message"></span>
			<?php if(isset($err['gooddescription'])){ ?>
			<!-- PHP Validation	-->
			<div class="alert alert-error show" id="goods_description_au_Error_css">
				<div class="requiredInformation" id="goods_description_au_Error"><?php echo $err['gooddescription']; ?></div>
			</div><!--	End PHP Validation	-->
			<?php } ?>
		</div><!--===/End Goods description	===-->
	</div><!--===/End Others	===-->

	<?php // ********* Dangerous statement temporarly disbaled ***********//
		if (isset($_SERVER['HTTP_REFERER']) && ($_SERVER['HTTP_REFERER']==SITE_URL.'zombie.php')) {?>
			<blockquote class="margin-bottom-40">
			<p><?php echo CONSTANT_DANGER_PROHIBITED_HELP; ?></p>
			</blockquote>
			<?php
				$CmsPageName = "prohibited-items";
				$Prohibited_Items = cmsPageContent($CmsPageName);
				echo lightBoxCmsDesc($Prohibited_Items);

				$CmsPageName1 = "dangerous-goods";
				$Dangerous_goods = cmsPageContent($CmsPageName1);
				echo lightBoxCmsDesc($Dangerous_goods);

			?>
		<?php } // ************* Dangerous statement temporarly disbaled end **************// ?>
	</div><!--===/End What are you sending AU	===-->
	<?php } ?>
    </div><!--==/End First Block	==-->
		<?php // *********Transit Warranty is temporarily disbaled ***********//
			if (isset($_SERVER['HTTP_REFERER']) && ($_SERVER['HTTP_REFERER']==SITE_URL.'zombie.php')) {?>
	<!--=== Second Block - Transit Warranty	===-->
	<input type="hidden" id="temp_value" name="temp_value" value="1">
	<div class="span12 margin-bottom-20 bg-light margin-left_0">
	<div class="headline">
	<h3><?php echo COMMON_TRANSIT_WARRANTY."tests"; ?></h3>
	</div>
		 <?php

			if($BookingDatashow->flag!='international'){

			?>
	<!--=== Transit Warranty AU	==-->
    <div class="span6">
	<blockquote>
		<p><?php echo TRANSIT_WARRANTY_COVER; ?></p>
	</blockquote>
    </div>
    <div class="span6 margin-left_0 control-group form-group white-space-ad">

        	<label class="control-label control-label-long"><p class="my_bigger_font"><?php echo TRANSIT_WARRANTY_YES; ?></p></label>
            <input type="checkbox" name="select_transit_warranty" id="select_transit_warranty" onclick="javascript: confirmTransitPolicy();" value="yes"  <?php if(isset($BookingDatashow->tansient_warranty) && $BookingDatashow->tansient_warranty=="yes"){echo "checked";}elseif(isset($_POST['select_transit_warranty']) && $_POST['select_transit_warranty']=="yes"){ echo "checked";} ?> />
  		</div>
        	<!--===	span6	===-->
		<?php
		$au_display ='none';
		if(isset($BookingDatashow->tansient_warranty) && $BookingDatashow->tansient_warranty=="yes"){
			$au_display = 'block';
		}elseif(isset($_POST['select_transit_warranty']) && $_POST['select_transit_warranty']=="yes"){
			$au_display = 'block';
		}

		?>
        <!--===	The Value	===-->
        <div class="span1"></div>
		<div class="span10 control-group form-group" id="boxTransit" style="display:<?php echo $au_display; ?>">     <?php
				//echo "val of guds:".$BookingDatashow->values_of_goods;
			?>
			<label class="control-label control-label-long-value"><p class="my_bigger_font"><?php echo TRANSIT_WARRANTY_AMOUNT; ?></p></label>
			<input type="text"  value="<?php if(valid_output($BookingDatashow->values_of_goods)=="0"){echo "0";}elseif(isset($_POST['transit_warranty_au']) && $_POST['transit_warranty_au']!=0){ echo valid_output($_POST['transit_warranty_au']); } else {echo valid_output($BookingDatashow->values_of_goods);}?>" class="border-radius-none form-control control-value" name="transit_warranty_au" id="transit_warranty_au" placeholder="$"  size="8" /><br />
				<span class="autocomplete_index help-block alert-error" id="transit_warranty_au_message"></span>
				<?php if(isset($err['transit_warranty_au'])){ ?>
				<!-- PHP Validation	-->
				<div class="alert alert-error hide" id="transit_warranty_au_Error_css">
					<div id="transit_warranty_au_Error" class="requiredInformation"><?php  echo $err['transit_warranty_au']; ?></div>
			   </div><!--	End PHP Validation	-->
			   <?php } ?>
		</div><!--===/End The Value	===-->
        <!--===	Covarage Fee	===-->
        <div class="span1"></div>
		<div class="span10 control-group form-group" id="displayTransit" style="display:<?php echo $au_display; ?>">
			<label class="control-label control-label-long-value"><p class="my_bigger_font"><?php echo TRANSIT_WARRANTY_COVERAGE; ?></p></label><div class="controls my_bigger_font my_bold_font my_green" id="transit_txt">
				<?php
					echo valid_output($BookingDatashow->coverage_rate);
				?>
			</div>
		</div><!--===/End Control group	===-->
        <div class="span1"></div>
	<!--===/End Transit Warranty AU	==-->
		<?php
			}else{

		?>
    <!--=== Transit Warranty International	==-->
    <div class="span12">
    <div class="span6">
        <blockquote>
            <p><?php echo TRANSIT_WARRANTY_COVER; ?></p>
        </blockquote>
    </div>
	<div class="span6 margin-left_0 control-group form-group white-space-ad">
        <label class="control-label control-label-long"><p class="my_bigger_font"><?php echo TRANSIT_WARRANTY_YES; ?></p></label>
        <input type="checkbox" name="select_transit_warranty" id="select_transit_warranty" onclick="javascript: confirmTransitPolicy();" value="yes"  <?php if(isset($BookingDatashow->tansient_warranty) && $BookingDatashow->tansient_warranty=="yes"){echo "checked";}elseif(isset($_POST['select_transit_warranty']) && $_POST['select_transit_warranty']=="yes"){ echo "checked";} ?> />
  	</div>
	<?php
		$int_display ="none";
		if(isset($BookingDatashow->tansient_warranty) && $BookingDatashow->tansient_warranty=="yes")
		{
			$int_display ="block";
		}elseif(isset($_POST['select_transit_warranty']) && $_POST['select_transit_warranty']=="yes"){
			$int_display ="block";
		}
	?>
    <!--===	Coverage block	==-->
    <div class="span10" id="boxTransit" style="display:<?php echo $int_display; ?>">
		<div class="my_bigger_font span6 margin-left_0 inline" ><?php echo TRANSIT_WARRANTY_COVERAGE; ?>
        <span class="my_bigger_font my_bold_font my_green inline" id="transit_txt">
        <?php echo "$".valid_output($BookingDatashow->coverage_rate);?>
        </span></div>
	</div><!--===/End Coverage block	==-->
	<?php
			$CmsPageName = "transit-warranty";
			$transit_warranty = cmsPageContent($CmsPageName);
			echo lightBoxCmsDesc($transit_warranty);
	?>
	 </div><!--=== Transit Warranty International	==-->
	  <?php
	 }
	  ?>
 </div><!--==/End Second Block - Transit Warranty	==-->
	<?php } // *************Transit Warranty is temporarily disbaled end **************// ?>
 <!--=== Third Block - Authority to Leave AU	bg-light==-->
	<?php if(valid_output($BookingDatashow->flag)!='international'){?>
	<div class="span12 margin-bottom-20">
	<p class="my_green"><?php echo COMMON_DRIVER_RELEASE; ?>&nbsp;<input type="checkbox" id="select_authority" name="select_authority" onclick="select_authority_option()" <?php if (valid_output($BookingDatashow->authority_to_leave)=="on"){echo "checked";}elseif(isset($_POST['select_authority']) && $_POST['select_authority']=='on'){ echo "checked"; }else {echo "";} ?>></p>

	<div id="authority_display" style="display:<?php if (valid_output($BookingDatashow->authority_to_leave)=="on" || (isset($_POST['select_authority']) && $_POST['select_authority']=='on')) {echo "block";}else{echo "none";}?>;">
	<!--=== Authority to Leave	YES==-->
	<p class="my_green"><?php echo COMMON_WHERE_TO_SHIPMENT_DETAILS; ?></p>
	<div class="form-group control-group">
	<textarea class="span8 form-control margin_bottom_0_important"  tabindex="1" id="shipment_detail" rows="1" onkeyup="javascript:removeError('shipment_detail_Error_css');" name="shipment_detail" data-toggle="tooltip" data-original-title="<?php echo $desc_goods_tooltip; ?>" autocomplete='off'/><?php if(isset($_POST['shipment_detail']) && $_POST['shipment_detail']!=""){ echo valid_output($_POST['shipment_detail']);}else{ echo valid_output($BookingDatashow->where_to_leave_shipment); }?></textarea><br />
	<span class="autocomplete_index help-block alert-error" id="shipment_detail_message"></span>
	<?php if(isset($err['shipment_detail']) && $err['shipment_detail']!=''){ ?>
	<!-- PHP Validation	-->
	<div class="alert alert-error show" id="shipment_detail_Error_css">
		<div class="requiredInformation" id="shipment_detail_Error"><?php  echo $err['shipment_detail']; ?></div>
	</div><!--/End PHP Validation	-->
	<?php } ?>
	</div>
	</div><!--===/End Authority to Leave YES	===--->
	</div><!--===/End Third Block - Authority to Leave	AU==-->
	<?php
	 }
	?>
	<?php if(($BookingDatashow->flag =="international" && !empty($BookingItemDetailsData))){
		foreach ($BookingItemDetailsData as $booingItemValue) {
			if(isset($booingItemValue['item_type']) && $booingItemValue['item_type']=='5') {
				$nondoc_active = 'active';
			}
		}
	}
	if(isset($nondoc_active) && $nondoc_active =='active') { ?>
	<!-- Start Commercial Invoice for Internation non document -->
	<div class="items_wrapper span12">
		<div id="commercial_invoice_block" class="controls">
			<p><?php echo COMMON_COMMERCIAL_INVOCIE; ?></p>
			<!--===	Commercial Invoice Provider	===-->
			<div class="items_wrapper margin-bottom-40">
				<p class="my_green"><?php echo COMMERCIAL_INVOCIE_PROVIDER_TYPE; ?></p>
				<div class="form-group control-group">
				 <select id="commercial_invoice_provider" class="form-control span7"  tabindex="1" name="commercial_invoice_provider" onchange="javascript: toggleListDiv();">
					 <option value="">Select Provider</option>
					 <option value="1" <?php if (isset($BookingDatashow->commercial_invoice_provider) && $BookingDatashow->commercial_invoice_provider=="1"){echo "selected";}elseif(isset($_POST['commercial_invoice_provider']) && $_POST['commercial_invoice_provider']=="1"){echo "selected";} ?>><?php echo COMMERCIAL_INVOCIE_PROVIDER_1; ?></option>
					 <option value="2" <?php if (isset($BookingDatashow->commercial_invoice_provider) && $BookingDatashow->commercial_invoice_provider=="2"){echo "selected";}elseif(isset($_POST['commercial_invoice_provider']) && $_POST['commercial_invoice_provider']=="2"){echo "selected";} ?>><?php echo COMMERCIAL_INVOCIE_PROVIDER_2; ?></option>
				 </select>
					<span class="autocomplete_index help-block alert-error" id="commercial_invoice_provider_message"></span>
					<?php if(isset($err['comm_inv_provider'])){ ?>
					<!-- PHP Validation	-->
						<div class="alert alert-error show" id="commercial_invoice_provider_Error_css">
							<div class="requiredInformation" id="commercial_invoice_provider_Error"><?php echo $err['comm_inv_provider']; ?></div>
						</div><!--	End PHP Validation	-->
					<?php } ?>
				</div>
			</div>	<!--===	/End Commercial Invoice Provider	===-->
		</div>
	</div><!--=== //End Commercial Invoice for Internation non document	==-->
	<?php } ?>

	<!--==	Confirmation	Statements== bg-light-->
 <div id="statements" class="span12 margin-bottom-40">
	 <!--==	Conditions of Carriage Confirmation		==-->
	 <h3 class="my_green">Please Read the following before booking.</h3>
	<p class="my_green"><?php echo TERMS_AND_CONDITIONS; ?></p>
	 <div class="form-group control-group margin-bottom-20">
		 <label class="checkbox control-label">
			 	<div class="my_bigger_font justy">
					<p>I agree to the terms and conditions for freight lodged for transportation by Priority Couriers and their partner transport companies <a id="popup" class="details-link" data-toggle="modal" href="#<?php echo "div_terms-conditions"; ?>" ><strong class="my_red">Conditions of Carriage</strong></a>.</p>
					 <?php
					 $CmsPageName = "terms-conditions";
					 $Terms_Conditions = cmsPageContent($CmsPageName);
					 echo lightBoxCmsDesc($Terms_Conditions);
					 ?>
				 	<p>I agree to the terms and conditions of the <a id="popup" class="details-link" data-toggle="modal" href="#<?php echo "div_privacy-policy"; ?>" ><strong class="my_red">Priority Couriers Privacy Policy</strong></a>.</p>
					 <?php
					 $CmsPageName = "privacy-policy";
					 $Privacy_Policy = cmsPageContent($CmsPageName);
					 echo lightBoxCmsDesc($Privacy_Policy);
					 ?>
				 	<p>This consignment does not contain an unauthorised explosive or incendiary device and I understand that it may be subject to security screening by explosive trace detection, X-Ray and/or physical search.</p>
					<p>I accept that this consignment maybe subject to mandatory screening prior transportation.</p>
					<p>I understand that I am personally responsible for the above statements and that a false or misleading statement made knowingly or recklessly is a statutory offence punishable by imprisonment and/or fine and may render me liable in damages for breach of contract.</p>
				 <input type="checkbox" name="terms_and_conditions" id="terms_and_conditions" class="form-control"
					 <?php if(isset($_SESSION['terms']) && $_SESSION['terms']=="on"){
						 echo "checked";}
					 elseif(isset($_POST['terms_and_conditions']) && $_POST['terms_and_conditions']=="on"){
						 echo "checked";}?>/>
				 <p>I have read and agree to the above terms and conditions.</p>
			 </div>
		 </label>
		 <span class="autocomplete_index help-block alert-error" id="terms_and_conditions_message"></span>
		 <?php if(isset($err['terms_conditions'])){ ?>
		 <!-- PHP Validation	-->
			 <div class="alert alert-error show" id="commercial_invoice_provider_Error_css">
				 <div class="requiredInformation" id="commercial_invoice_provider_Error"><?php echo $err['terms_conditions']; ?></div>
			 </div><!--	End PHP Validation	-->
		 <?php } ?>
	 </div><!--==	End Conditions of Carriage Confirmation		==-->
	 <!--==	Dangerous Goods 	==-->
		 <p class="my_green"><?php echo DANGEROUS_GOODS_STATEMENT; ?></p>
	 <div class="form-group control-group margin-bottom-20">

		 <?php // ********* Original Dangerous Goods is disbaled ***********//
		 	//echo SITE_URL.'zombie.php';
 			if (isset($_SERVER['HTTP_REFERER']) && ($_SERVER['HTTP_REFERER']==SITE_URL.'zombie.php')) {
				 ?>
		 <label class="checkbox control-label">
			 <input type="checkbox" name="dangerousgood" class="form-control" id="dangerousgood"
				 <?php /*if(isset($_SESSION['dangerousgoods']) && $_SESSION['dangerousgoods']=="on"){
					 echo "checked";}
				 elseif(isset($_POST['dangerousgood']) && $_POST['dangerousgood']=="on"){
					 echo "checked";}*/ ?> />
			 	<div class="my_bigger_font justy">
					<p>I acknowledge that this consignment/package/parcel/envelope, does not contain any items that may be considered <a id="popup" class="details-link" data-toggle="modal" href="#<?php echo "div_dangerous-goods"; ?>" ><strong class="my_red">Dangerous Goods</strong></a>.</p>
					<?php
						$CmsPageName1 = "dangerous-goods";
						$Dangerous_goods = cmsPageContent($CmsPageName1);
						echo lightBoxCmsDesc($Dangerous_goods);
					?>
				</div>
			</label>
			<span class="autocomplete_index help-block alert-error" id="dangerousgood_message"></span>
			<?php if(isset($err['dangerousgoods'])){ ?>
				<!-- PHP Validation	-->
				<div class="alert alert-error show" id="dangerousgood_Error_css">
					<div class="requiredInformation" id="dangerous_error"><?php  echo $err['dangerousgoods']; ?></div>
				</div><!--/End PHP Validation	-->
			<?php } ?>
		<?php } // *************Original Dangerous Goods is disbaled end **************// ?>

			<div class="my_bigger_font justy radio">
				<p>I acknowledge that this consignment/package/parcel/envelope, does not contain any items that may be considered <a id="popup" class="details-link" data-toggle="modal" href="#<?php echo "div_dangerous-goods"; ?>" ><strong class="my_red">Dangerous Goods</strong></a>.</p>
				<?php
					$CmsPageName1 = "dangerous-goods";
					$Dangerous_goods = cmsPageContent($CmsPageName1);
					echo lightBoxCmsDesc($Dangerous_goods);
				?>
			</div>
			<div class="my_bigger_font justy radio">
				<p>I understand that failure to declare Dangerous Goods or to misrepresent the contents of any package, is a criminal offence under Australian Civil Aviation Act, Regulations and Orders and I may be subject to prosecution.</p>
			</div>
			 <p class="my_bold_font">Does this consignment contain Dangerous Goods?</p>
				 <label class="control-label radio">
					 <input type="radio" id="dg_no" name="dangerousgood" value="0" <?php /*if(isset($BookingDatashow->dangerousgoods) && $BookingDatashow->dangerousgoods=="0"){
						 echo "checked";}
					 elseif(isset($_POST['dangerousgood']) && $_POST['dangerousgood']=="0"){
						 echo "checked";} */?> />
					 No
				 </label>
				 <label class="control-label radio">
					 <input type="radio" id="dg_yes" name="dangerousgood" value="1" <?php /*if(isset($BookingDatashow->dangerousgoods) && $BookingDatashow->dangerousgoods=="1"){
						 echo "checked";}
					 elseif(isset($_POST['dangerousgood']) && $_POST['dangerousgood']=="1"){
						 echo "checked";}*/ ?> />
					 Yes
				 </label>
			<span class="autocomplete_index help-block alert-error" id="dangerousgood_message"></span>
			<?php if(isset($err['dangerousgoods'])){ ?>
				<!-- PHP Validation	-->
				<div class="alert alert-error show" id="dangerousgood_Error_css">
					<div class="requiredInformation" id="dangerous_error"><?php  echo $err['dangerousgoods']; ?></div>
				</div><!--/End PHP Validation	-->
			<?php } ?>
		</div><!--==/End Dangerous Goods ==-->
		<!--==	Security Statement 	==-->
		<div class="form-group control-group margin-bottom-20">
			<?php // ********* Original 2 Security Statement is disbaled ***********//
			 if (isset($_SERVER['HTTP_REFERER']) && ($_SERVER['HTTP_REFERER']==SITE_URL.'zombie.php')) {?>
			<label class="checkbox control-label">
				<input type="checkbox" name="security_statement" class="form-control" id="security_statement"
					<?php if(isset($_SESSION['securitystatement']) && $_SESSION['securitystatement']=="on"){
						echo "checked";}
					elseif(isset($_POST['security_statement']) && $_POST['security_statement']=="on"){
						echo "checked";} ?> />
 			 	<div class="my_bigger_font justy">
					<p>I understand that failure to declare Dangerous Goods or to misrepresent the contents of any package, is a criminal offence under Australian Civil Aviation Act, Regulations and Orders and I may be subject to prosecution.</p>
		 		</div>
			</label>
			<span class="autocomplete_index help-block alert-error" id="security_statement_message"></span>
			<?php if(isset($err['securitystatement'])){ ?>
				<!-- PHP Validation	-->
				<div class="alert alert-error show" id="dangerousgood_Error_css">
					<div class="requiredInformation" id="dangerous_error"><?php  echo $err['securitystatement']; ?></div>
				</div><!--/End PHP Validation	-->
			<?php } ?>
			<?php } // ************* Original 2 Security Statement is disbaled **************// ?>

		</div><!--==	Security Statement 	==-->


		<?php // ********* Original Security Statement is temporarily disbaled ***********//
			if (isset($_SERVER['HTTP_REFERER']) && ($_SERVER['HTTP_REFERER']==SITE_URL.'zombie.php')) {?>
			 <div class="headline">
				 <h3><?php echo SECURITY_STATEMENT; ?></h3>
			 </div>
			 <div class="form-group control-group margin-bottom-20">
			 <label class="checkbox control-label">
				 <input type="checkbox" name="security_statement" class="form-control" id="security_statement" /><div class="my_bigger_font justy"><?php echo SECURITY_STATEMENT_CONTENT; ?></div>
			 </label>
			 <span class="autocomplete_index help-block alert-error" id="security_statement_message"></span>
			 <?php if(isset($err['dangerousgoods'])){ ?>
				 <!-- PHP Validation	-->
				 <div class="alert alert-error hide" id="dangerousgood_Error_css">
					 <div class="requiredInformation" id="dangerous_error"><?php  echo $err['dangerousgoods']; ?></div>
				 </div><!--/End PHP Validation	-->
			 <?php } ?>
		 </div><!--==/End Security Statement ==-->
	 <?php } // *************Transit Warranty is temporarily disbaled end **************// ?>

 </div><!--==/End Conditions of Carriage Confirmation	==-->


	<!-- End Commercial Invoice for Internation non document -->
	<div class="span12 margin-left_0">
	<?php
	$backurl = $_SERVER['HTTP_REFERER'];

	//$serviceRate = $BookingDatashow->rate;
	?>
	<?php
			$btn_name = 'NEXT';
			$bk_btn ='PREVIOUS';
		if(isset($_GET['Action']) && $_GET['Action']=='edit')
		{
			$bk_btn ='CANCEL';
			$btn_name = 'SAVE';
		}
	 ?>
	<input type="button" class="btn-u btn-u-large pull-left" name="BackButton" value="&laquo; <?php echo $bk_btn; ?>" onClick="window.history.back()"/>
	 <input type="hidden" name="ptoken" id="ptoken" value="<?php echo $ptoken;?>" />
	 <input type="hidden" name="service_name" id="service_name" value="<?php echo valid_output($service_name);?>" />
	 
	 <input type="hidden" name="transit_amount" id="transit_amount" value="<?php echo $BookingDatashow->coverage_rate ?>" />
	 <input type="hidden" id="service_rate" name="service_rate" value="<?php echo valid_output($serviceRate);?>">
	 <input type="hidden" name="bookingType" id="bookingType" value="<?php echo filter_var($supplier_id,FILTER_VALIDATE_INT);?>" />

	 <input type="submit" tabindex="4" value="<?php echo $btn_name; ?> &raquo;" class="btn-u btn-u-large pull-right" name="submitbtn"  />
	</div>
</div> <!-- span9 margin-bottom-20 margin-left_0 -->
<div class="span3 bg-lighter">
	<?php include(DIR_WS_RELATED.FILE_BOOKING_SUMMARY); ?>
</div><!--/span3-->
</form>

</div><!--/End Spacer -->
</div><!--/container-->
<!-- form for commercial invoice  pop up -->
<div class="modal hide fade commercial_invoice" id="commercial_invoice" data-backdrop="static" data-keyboard="false">
	<div class="modal-header">
	<h3><?php echo "Please fill in Commercial Invoice Form"; ?></h3>
	</div>
	<div class="modal-body">
	<form>
			<div>
				<span>Consignor</span><span>Consignee</span>

			</div>

	</form>
	</div>
	<div class="modal-footer">
    	<span class="white-space"><a href="#more_light" id="postInt" class="btn-u">Close</a></span>
   	</div>
</div>
<!--	/End form for commercial invoice  pop up -->
<!-- International Data Loss pop up -->
<div class="modal hide fade small_rates" id="dg_modal" data-backdrop="static" data-keyboard="false">
	<div class="modal-header">
		<h3><?php echo DANGEROUS_GOODS_TITLE; ?></h3>
	</div>
	<div class="modal-body"><?php echo DANGEROUS_GOODS_DESC; ?></div>
	<div class="modal-footer">
	<div class="btn-u pull-left button_modal_fl" id="dg_booking_cancel"><?php echo BTN_CANCEL; ?></div>
		<div class="btn-u pull-right button_modal_fl" id="dg_return_booking"><?php echo RETURN_TO_BOOKING; ?></div>
	</div>
</div>

<!-- Modal with Data loss warning -->
<div class="modal hide fade small_rates" id="dgDataLossEff" data-backdrop="static" data-keyboard="false">
	<div class="modal-header">
		<h3><?php echo DANGEROUS_GOODS_CANCEL_DATA_LOSS_HEADER; ?></h3>
	</div>
	<div class="modal-body my_bigger_font justy">
		<?php echo DANGEROUS_GOODS_CANCEL_DATA_LOSS; ?>
	</div>
	<div class="modal-footer">
		<a href="#" class="btn-u pull-left button_modal_fl" data-dismiss="modal" id="dgDataLoseNo">No</a>
		<a href="#" class="btn-u pull-right button_modal_fl"  id="dgDataLoseYes">Yes</a>
	</div>
</div> <!--	/End Modal with Data loss warning -->

