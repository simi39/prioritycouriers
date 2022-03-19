<?php
$deliveryFromBook = 0;
$pickupFromBook = 0;
$session_data = json_decode($_SESSION['Thesessiondata']['_sess_login_userdetails'],true);
$userid = $session_data['user_id'];
/*echo "<pre>";
print_r($_SESSION);
echo "</pre>";
*/
if(isset($_GET["type"]) && $_GET["type"]=="delivery") {
	$DladdMatchFlag=1;
	$address_flag = 0;
}else{
    /*if(isset($_GET["type"]) && $_GET["type"]=="pickup"){
        $DladdMatchFlag=1;
        $address_flag = 0;
    }else{*/
        //$DladdMatchFlag = $DladdMatchFlag;
   // }
	$DladdMatchFlag=1;

}

//echo $DladdMatchFlag;
if($PkaddMatchFlag == 1) $pkp_address_from_book = 0;
//else $pkp_address_from_book = 1;
//Flag for delivery address
if($DladdMatchFlag == 1) $dlv_address_from_book = 0;
//else $dlv_address_from_book = 1;
if(isset($_SESSION['address_return'] ) && $_SESSION['address_return']  == 1){
	$pkp_address_from_book = 0;
	$dlv_address_from_book= 0;
}
if(isset($_GET['Action']) && $_GET['Action']=='edit')
{
	$backurl=FILE_CHECKOUT;
}
if($flag=="australia" && (!isset($_GET['Action']) && $_GET['Action']!='edit'))
{
	if($servicepagename=="sameday")
	{
		$backurl=FILE_METRO_RATES;
	}
	else if($servicepagename=="overnight")
	{
		$backurl=FILE_INTERSTATE_RATES;
	}
}elseif($flag=="international" && (!isset($_GET['Action']) && $_GET['Action']!='edit')){

	$backurl=FILE_INTERNATIONAL;
}

?>

<!--=== Breadcrumbs ===-->
<div class="breadcrumbs margin-bottom-60">
	<div class="container">
        <h1 class="pull-left"><?php echo COMMON_ADDRESSES; ?></h1>
        <ul class="pull-right breadcrumb">
            <li><a href="<?php echo SITE_INDEX;?>"><?php echo COMMON_HOME; ?></a> <span class="divider">/</span></li>
            <li class="active"><?php echo COMMON_ADDRESSES; ?></li>
        </ul>
    </div><!--/container-->
</div><!--/breadcrumbs-->
<!--=== End Breadcrumbs ===-->

<!--=== Content Part action="<?php echo $_SERVER['PHP_SELF'];?>"===-->
<div class="container">
	<div class="row-fluid">
	<div class="containerBlock span9 margin-bottom-40  margin-left_0">
   	<form name="addressesForm" autocomplete="off" id="addressesForm" class="span12" method="post">

        	<?php if(defined('SES_USER_ID')){ ?>
        	<!--==	Using Addressbook Info Header	==-->
        	<div class="span12 margin-bottom-20 margin-left_0 bg-lighter">
            	<blockquote>
                	<p><?php echo COMMON_USING_ADDRESS_FROM_ADDRESS; ?></p>
            	</blockquote>
        	</div><!--== /End Using Addressbook Info Header	==-->
        	<?php }else{ ?>
        	<?php } ?>

        	<!--==== From ====-->
         	<div class="span6 bg-lighter margin-left_0">
            <div class="headline"><h3><?php echo COMMON_SENDER_DETAILS; ?></h3></div>
            	<?php if(defined('SES_USER_ID')){ ?>
                <!-- button to add address from addressbook -->
				<div class="margin-bottom-20">
				<input type="button" name="pickup" onClick="javascript: getAddressFromAddressBook('pickup');"  value="<?php echo COMMON_SELECT_ADDRESS_FROM_ADDRESS; ?>" data-toggle="tooltip" data-original-title="<?php echo valid_output($pickup_from_booking_details); ?>" class="btn-block btn-u my_btn-large" />
				<!-- /End button to add address from addressbook -->
				<!-- all hidden values -->
				<input type="hidden" name="user_id" id="user_id" value="<?php echo filter_var($userid,FILTER_VALIDATE_INT);?>">
				  <!--This 2 hidden are set after confirmation to either to add pickup address and delivery address or not-->
				  <input type="hidden" name="confirmPkpAddYes" id="confirmPkpAddYes" value="<?php echo valid_output($pkp_address_from_book);?>" />
				  <input type="hidden" name="confirmDelAddYes" id="confirmDelAddYes" value="<?php echo valid_output($dlv_address_from_book);?>" />
				  <input type="hidden" name="pkp_address_from_book" id="pkp_address_from_book" value="<?php echo valid_output($pkp_address_from_book);?>" />
				  <input type="hidden" name="dlv_address_from_book" id="dlv_address_from_book" value="<?php echo valid_output($dlv_address_from_book); ?>" />
                  </div>
				  <!-- /End all hidden values -->
                  <?php }else{ ?>
                  <?php } ?>
				  <?php
					/*
					echo "<pre>";
					print_R($pickaddress);
					echo "</pre>";
					*/
				  ?>
				<!--=== From First Name	===-->
            	<div class="span6 form-group control-group margin-left_0 first_name ui-front">
                <label class="control-label"><?php echo COMMON_SENDER_NAME; ?> <span class="color-red">*</span></label>

                <input name="sender_first_name"  id="sender_first_name" tabindex="1"  autocomplete="off"  type="text" class="span12 form-control" value="<?php if(isset($_POST['sender_first_name']) && $_POST['sender_first_name']!=''){ echo ucwords(valid_output($_POST['sender_first_name'])); }else{ echo ucwords(valid_output($pickaddress->firstname)); } ?>" onkeypress="javascript:removeError('sender_first_name_Error_css');" /><br />
               		<span class="autocomplete_index help-block alert-error" id="sender_first_name_message"></span>
                   	<?php
					if(isset($err['sender_first_name'])){
					?>
					<!-- PHP Validation	-->
					<div class="alert alert-error show" id="sender_first_name_Error_css">
                    	<div id="sender_first_name_Error"> <?php echo ucwords($err['sender_first_name']);?></div>
                  	</div><!--	End PHP Validation	-->
					<?php
					}
					?>
              	</div><!--/End From First Name-->
                <!--=== From Surname	===-->
            	<div class="span6 form-group control-group">
                <label class="control-label"><?php echo COMMON_SENDER_SURNAME; ?> <span class="color-red">*</span></label>
                <input name="sender_last_name" id="sender_last_name" tabindex="2" type="text" class="span12 form-control" value="<?php if(isset($_POST['sender_last_name']) && $_POST['sender_last_name']!=''){ echo ucwords(valid_output($_POST['sender_last_name'])); }else{ echo ucwords(valid_output($pickaddress->surname));} ?>" onkeypress="javascript:removeError('sender_last_name_Error_css');" autocomplete='off' /><br />
                	<span class="autocomplete_index help-block alert-error" id="sender_last_name_message"></span>
                    <?php
						if(isset($err['sender_last_name'])){
					?>
					<!-- PHP Validation	-->
                    <div class="alert alert-error show" id="sender_last_name_Error_css">
                    	<div id="sender_last_name_Error" class="requiredInformation"><?php  echo ucwords($err['sender_last_name']);?></div>
                    </div><!--	End PHP Validation	-->
					<?php } ?>
                </div><!--/End From Surname-->
                <!--=== From Company	===-->
                <div class="span12 form-group control-group margin-left_0">
                <label class="control-label"><?php echo COMMON_SENDER_COMPANY; ?></label>
                <input name="sender_company_name" id="sender_company_name" tabindex="3" type="text" class="span12 form-control" value="<?php if(isset($_POST['sender_company_name']) && $_POST['sender_company_name']!=''){ echo ucwords(valid_output($_POST['sender_company_name'])); }else{echo ucwords(valid_output($pickaddress->company));} ?>" onkeypress="javascript:removeError('sender_company_name_Error_css');" autocomplete='off'/><br />
                	<span class="autocomplete_index help-block alert-error" id="sender_company_name_message"></span>
                    <?php
					if(isset($err['sender_company_name'])){
					?>
					<!-- PHP Validation	-->
                    <div class="alert alert-error show" id="sender_company_name_Error_css">
                    	<div id="sender_company_name_Error" class="requiredInformation"><?php  echo ucwords($err['sender_company_name']);?></div>
                    </div><!--	End PHP Validation	-->
					<?php
					}
					?>
                </div><!--===/End From Company	===-->
                <!--=== From Address 1	===-->
                <div class="span12 form-group control-group margin-left_0 margin-bottom_0">
                <label class="control-label"><?php echo COMMON_SENDER_ADDRESS_HEADER; ?> <span class="color-red">*</span></label>
                <input name="sender_address_1" id="sender_address_1" tabindex="4" type="text" class="span12 form-control" value="<?php if(isset($_POST['sender_address_1']) && $_POST['sender_address_1']!=''){ echo ucwords(valid_output($_POST['sender_address_1'])); }else{ echo ucwords(html_entity_decode($pickaddress->address1));} ?>" onkeypress="javascript:removeError('sender_address_1_Error_css');" autocomplete='off'/><br />
                <span class="autocomplete_index help-block alert-error" id="sender_address_1_message"></span>
                	<?php if(isset($err['sender_address_1'])){ ?>
					<!-- PHP Validation	-->
                    <div class="alert alert-error show" id="sender_address_1_Error_css">
                    	<div id="sender_address_1_Error" class="requiredInformation"><?php  echo ucwords($err['sender_address_1']);?></div>
                    </div><!--	End PHP Validation	-->
					<?php } ?>
                </div><!--===/End From Address 1	===-->
                <!--=== From Address 2	===-->
                <div class="span12 form-group control-group margin-left_0 margin-bottom_0">
                <label></label>
                <input name="sender_address_2" id="sender_address_2" tabindex="5" type="text" class="span12 form-control" value="<?php if(isset($_POST['sender_address_2']) && $_POST['sender_address_2']!=''){ echo ucwords(valid_output($_POST['sender_address_2'])); }else{ echo ucwords(html_entity_decode($pickaddress->address2));} ?>" onkeypress="javascript:removeError('sender_address_2_Error_css');" autocomplete='off'/><br />
                <span class="autocomplete_index help-block alert-error" id="sender_address_2_message"></span>
                	<?php if(isset($err['sender_address_2'])){ ?>
					<!-- PHP Validation	-->
                    <div class="alert alert-error show" id="sender_address_2_Error_css">
                    	<div id="sender_address_2_Error" class="requiredInformation"><?php  echo ucwords($err['sender_address_2']); ?></div>
                    </div><!--	End PHP Validation	-->
					<?php } ?>
                </div><!--===/End From Address 2	===-->
				<!--=== From Address 3	===-->
                <div class="span12 form-group control-group margin-left_0">
                <label></label>
                <input name="sender_address_3" id="sender_address_3" tabindex="5" type="text" class="span12 form-control" value="<?php if(isset($_POST['sender_address_3']) && $_POST['sender_address_3']!=''){ echo ucwords(valid_output($_POST['sender_address_3'])); }else{ echo ucwords(html_entity_decode($pickaddress->address3));} ?>" onkeypress="javascript:removeError('sender_address_3_Error_css');" autocomplete='off'/><br />
                <span class="autocomplete_index help-block alert-error" id="sender_address_3_message"></span>
                	<?php if(isset($err['sender_address_3'])){ ?>
					<!-- PHP Validation	-->
                    <div class="alert alert-error show" id="sender_address_3_Error_css">
                    	<div id="sender_address_3_Error" class="requiredInformation"><?php  echo ucwords($err['sender_address_3']); ?></div>
                    </div><!--	End PHP Validation	-->
					<?php } ?>
                </div><!--===/End From Address 2	===-->
        		<!--=== From Suburb	===-->
                <div class="span12 form-group control-group margin-left_0">
                <label class="control-label"><?php echo COMMON_SENDER_ADDRESS_SUBURB; ?> <span class="color-red">*</span></label>

                <input name="sender_suburb" readonly id="sender_suburb" type="text" class="span12 form-control" value="<?php if(isset($_POST['sender_suburb']) && $_POST['sender_suburb']!=''){ echo ucwords(valid_output($_POST['sender_suburb'])); }else{ echo valid_output($Pickupvalue['Name']);}?>" autocomplete='off'/><br />
                	<span class="autocomplete_index help-block alert-error"></span>
                	<?php if(isset($err['sender_suburb'])){ ?>
					<!-- PHP Validation	-->
                    <div class="alert alert-error show" id="sender_suburb_Error_css">
                    	<div id="sender_suburb_Error" class="requiredInformation"><?php echo ucwords($err['sender_suburb']); ?></div>
                    </div><!--	End PHP Validation	-->
					<?php } ?>
             	</div><!--===/End From Suburb	===-->
                <!--=== From State	===-->
                <div class="span6 form-group control-group margin-left_0">
                <label class="control-label"><?php echo COMMON_SENDER_STATE; ?> <span class="color-red">*</span></label><br />
                <input name="sender_state" readonly id="sender_state" type="text" class="span6 form-control" value="<?php if(isset($_POST['sender_state']) && $_POST['sender_state']!=''){ echo valid_output($_POST['sender_state']); }else{ echo valid_output($Pickupvalue['State']); }?>" autocomplete='off'/><br />
                	<span class="autocomplete_index help-block alert-error"></span>
                	<?php if(isset($err['sender_state'])){ ?>
					<!-- PHP Validation	-->
                    <div class="alert alert-error show" id="sender_state_Error_css">
                    	<div id="sender_state_Error" class="requiredInformation"><?php  echo ucwords($err['sender_state']); ?></div>
                    </div><!--	End PHP Validation	-->
					<?php } ?>
              	</div><!--===/End From State	===-->
                <!--===	From Post Code	===-->
                <div class="span6 form-group control-group">
                <label class="control-label"><?php echo COMMON_SENDER_ADDRESS_POST_CODE; ?> <span class="color-red">*</span></label>
                <input name="sender_postcode" readonly id="sender_postcode" type="text" class="span12 form-control" value="<?php if(isset($_POST['sender_postcode']) && $_POST['sender_postcode']!=''){ echo filter_var($_POST['sender_postcode'],FILTER_VALIDATE_INT); }else{ echo filter_var($Pickupvalue['Postcode'],FILTER_VALIDATE_INT);}?>" autocomplete='off'/><br />
                	<span class="autocomplete_index help-block alert-error"></span>
                	<?php if(isset($err['sender_postcode'])){ ?>
					<!-- PHP Validation	-->
                    <div class="alert alert-error show" id="sender_postcode_Error_css">
                    	<div id="sender_postcode_Error" class="requiredInformation"><?php  echo ucwords($err['sender_postcode']); ?></div>
                    </div><!--	End PHP Validation	-->
					<?php } ?>
               	</div><!--===/End From Post Code	===-->
                <!--=== From For International	===-->
                  <?php if(($service_name =='international')||($flag=="international"))
                     {?>
                <div class="span12 form-group control-group margin-left_0">
                <label class="control-label"><?php echo COMMON_SENDER_ADDRESS_COUNTRY; ?> <span class="color-red">*</span></label>
                <input name="sender_country" readonly id="sender_country" type="text" class="span12 form-control" value="<?php if(isset($_POST['sender_country']) && $_POST['sender_country']!=''){ echo ucwords(valid_output($_POST['sender_country'])); }else{ echo ucwords(valid_output("Australia"));}?>" /><br />
                	<?php if(isset($err['sender_country'])){ ?>
					<!-- PHP Validation	-->
                    <div class="alert alert-error show" id="sender_country_Error_css">
                    	 <div id="sender_country_Error" class="requiredInformation"><?php  echo ucwords($err['sender_country']);?></div>
                    </div><!--	End PHP Validation	-->
					<?php } ?>
               	</div><!--===/End From For International	===-->
                  <?php }

                  ?>
                 <!--=== From Email	===-->
                 <div class="span12 form-group control-group margin-left_0">
                 <label class="control-label"><?php echo COMMON_SENDER_EMAIL; ?><span class="color-red">*</span></label>
                 <input name="sender_email" id="sender_email" tabindex="6" type="email" class="span12 form-control" value="<?php if(isset($_POST['sender_email']) && $_POST['sender_email']!=''){ echo valid_output($_POST['sender_email']); }else{ echo valid_output($pickaddress->email);} ?>" onkeypress="javascript:removeError('sender_email_Error_css');" autocomplete='off'/><br />
                 	<span class="autocomplete_index help-block alert-error" id="sender_email_message"></span>
                	<?php if(isset($err['sender_email'])){ ?>
					<!-- PHP Validation	-->
                    <div class="alert alert-error show" id="sender_email_Error_css">

                     	<div id="sender_email_Error" class="requiredInformation"><?php  echo ucwords($err['sender_email']); ?></div>
                    </div><!--	End PHP Validation	-->
					<?php } ?>
                 </div><!--===/End From Email	===-->
                 <!--===From Primary Tel	===-->
				 <div class="span6 form-group control-group margin-left_0">
				 <label class="control-label"><?php echo COMMON_COUNTRY_CODE; ?> <span class="color-red">*</span></label><br/ >
				 <input type="tel"  value="<?php if(isset($pickaddress->area_code) && $pickaddress->area_code!=""){echo valid_output($pickaddress->area_code);}elseif(isset($_POST['sender_area_code'])&& $_POST['sender_area_code']!=""){echo $_POST['sender_area_code'];}else{ echo "61";}?>"   class="span6 form-control" name="sender_area_code" id="sender_area_code" onkeypress="javascript:removeError('sender_area_code_contact_no_Error_css');">
				 <span class="autocomplete_index help-block alert-error" id="sender_area_code_contact_no_message"></span>
                	<?php if(isset($err['sender_area_code'])){ ?>
					<!-- PHP Validation	-->
                    <div class="alert alert-error show" id="sender_area_code_contact_no_Error_css">

                    	<div id="sender_area_code_contact_no_Error" class="requiredInformation"><?php  echo $err['sender_area_code']; ?></div>
                    </div><!--	End PHP Validation	-->
					<?php } ?>
				 </div>
                 <div class="span6 form-group control-group">
                 <label class="control-label"><?php echo COMMON_SENDER_CONTACT_NO; ?> <span class="color-red">*</span></label>

				 <input name="sender_contact_no" id="sender_contact_no" tabindex="7" type="tel" class="span12 form-control" value="<?php if(isset($_POST['sender_contact_no']) && $_POST['sender_contact_no']!=''){ echo $_POST['sender_contact_no']; }else{ echo $pickaddress->phoneno; }?>" onkeypress="javascript:removeError('sender_contact_no_Error_css');" autocomplete='off' /><br />
   					<span class="autocomplete_index help-block alert-error" id="sender_contact_no_message"></span>
                	<?php if(isset($err['sender_contact_no'])){ ?>
					<!-- PHP Validation	-->
                    <div class="alert alert-error show" id="sender_contact_no_Error_css">

                    	<div id="sender_contact_no_Error" class="requiredInformation"><?php  echo $err['sender_contact_no']; ?></div>
                    </div><!--	End PHP Validation	-->
					<?php } ?>
              	</div><!--===/End From Primary Tel	===-->
                <!--===	From Secondary Tel	===-->

				 <div class="span6 form-group control-group margin-left_0">
				 <label class="control-label"><?php echo COMMON_COUNTRY_CODE; ?></label><br />
				 <input type="tel" value="<?php if(isset($pickaddress->m_area_code) && $pickaddress->m_area_code!=""){echo valid_output($pickaddress->m_area_code);}elseif(isset($_POST[sender_mb_area_code]) && $_POST[sender_mb_area_code]!=""){ echo $_POST[sender_mb_area_code];}else{ echo "61";};?>" class="span6 form-control" name="sender_mb_area_code" id="sender_mb_area_code" onkeypress="javascript:removeError('sender_area_code_mobile_no_Error_css');">
				 <span class="autocomplete_index help-block alert-error" id="sender_area_code_mobile_no_message"></span>
                	<?php if(isset($err['sender_mb_area_code'])){ ?>
					<!-- PHP Validation	-->
                    <div class="alert alert-error show" id="sender_area_code_mobile_no_Error_css">

                    	<div id="sender_area_code_mobile_no_Error" class="requiredInformation"><?php  echo $err['sender_mb_area_code']; ?></div>
                    </div><!--	End PHP Validation	-->
					<?php } ?>
				</div>
                <div class="span6 form-group control-group">
                <label class="control-label"><?php echo COMMON_SENDER_MOBILE_NO; ?></label>
                <input name="sender_mobile_no" id="sender_mobile_no" tabindex="8" type="tel" class="span12 form-control" value="<?php if(isset($_POST['sender_mobile_no']) && $_POST['sender_mobile_no']!=''){ echo $_POST['sender_mobile_no']; }else{ echo $pickaddress->mobileno;}?>" onkeypress="javascript:removeError('sender_mobile_no_Error_css');" autocomplete='off'/><br />
   					<span class="autocomplete_index help-block alert-error" id="sender_mobile_no_message"></span>
                	<?php if(isset($err['sender_mobile_no'])){ ?>
					<!-- PHP Validation	-->
                    <div class="alert alert-error show" id="sender_mobile_no_Error_css">

                      	<div id="sender_mobile_no_Error" class="requiredInformation"><?php  echo ucwords($err['sender_mobile_no']);?></div>
                    </div><!--	End PHP Validation	-->
					<?php } ?>
               	</div><!--===/End From Secondary Tel	===-->
				<!-- Start checkbox to save pickup address in address book --->
				<?php if(isset($userid) && !empty($userid)){
					$pkp_display = "block";
                    $pkchecked = 'checked';
					
					/*
					if(isset($_SESSION['chk_pk_address']) && $_SESSION['chk_pk_address']==1)
					{
						$pkp_display = "block";
					}
				*/
				?>
				<div class="span12 form-group control-group" style="display:<?php echo $pkp_display; ?>;" id="divpkaddress">
                	<label class="control-label control-label-long">
						<p class="my_bigger_font"><?php echo ADDRESSES_PICKUPADDRESS_SAVE; ?></p></label>
				<input type="checkbox" name="pkaddress" id="pkaddress" value="1" <?php echo $pkchecked; ?>/>
				<span class="autocomplete_index help-block alert-error" id="save_pk_address_message"></span>
                	<?php if(isset($err['sender_pkaddress'])){ ?>
					<!-- PHP Validation	-->
                    <div class="alert alert-error show" id="save_pk_address_no_Error_css">

                    	<div id="save_pk_address_Error" class="requiredInformation"><?php  echo $err['sender_pkaddress']; ?></div>
                    </div><!--	End PHP Validation	-->
					<?php } ?>
				</div>
				<!-- End checkbox  to save pickup address in address book --->
				<?php } ?>
           	</div><!--==== From ====-->

			<!--==== To ====-->
          	<div class="span6 bg-lighter">
           	<div class="headline"><h3><?php echo COMMON_RECEIVER_DETAILS; ?></h3></div>
            	<?php if(defined('SES_USER_ID')){ ?>
                <!-- button to add address from addressbook -->
			 	<div class="margin-bottom-20">
                <input type="button" name="pickup" onClick="javascript: getAddressFromAddressBook('delivery')"  value="<?php echo COMMON_SELECT_ADDRESS_FROM_ADDRESS; ?>" data-toggle="tooltip" data-original-title="<?php echo valid_output($delivery_to_booking_details); ?>" onMouseOut="return nd();" class="btn-block btn-u my_btn-large" />
			  	</div>
                <!-- /End button to add address from addressbook -->
                <?php }else{ ?>
                <?php } ?>
            	<!--=== To First Name	===-->
            	<div class="span6 form-group control-group margin-left_0 first_name ui-front">
                <label class="control-label"><?php echo COMMON_RECEIVER_NAME; ?> <span class="color-red">*</span></label>
                <input name="receiver_first_name" id="receiver_first_name" tabindex="9" type="text" class="span12 form-control" value="<?php if(isset($_POST['receiver_first_name']) && $_POST['receiver_first_name']!=''){ echo ucwords(valid_output($_POST['receiver_first_name'])); }else{ echo ucwords(valid_output($deliaddress->firstname));} ?>" onkeypress="javascript:removeError('receiver_first_name_Error_css');" autocomplete='off'/><br />
   					<span class="autocomplete_index help-block alert-error" id="receiver_first_name_message"></span>
                	<?php if(isset($err['receiver_name'])){ ?>
					<!-- PHP Validation	-->
                    <div class="alert alert-error show" id="receiver_first_name_Error_css">

						<div id="receiver_first_name_Error" class="requiredInformation"><?php  echo ucwords($err['receiver_name']); ?></div>
					</div><!--	End PHP Validation	-->
					<?php } ?>
				</div><!--===/End To First Name	===-->
                <!--=== To Surname	===-->
                <div class="span6 form-group control-group">
                <label class="control-label"><?php echo COMMON_RECEIVER_SURNAME; ?> <span class="color-red">*</span></label>
				<input name="receiver_surname" id="receiver_surname" tabindex="10" type="text" class="span12 form-control" value="<?php if(isset($_POST['receiver_surname']) && $_POST['receiver_surname']!=''){ echo ucwords(valid_output($_POST['receiver_surname'])); }else{ echo ucwords(valid_output($deliaddress->surname)); }?>" onkeypress="javascript:removeError('receiver_surname_Error_css');" autocomplete='off'/><br />
   					<span class="autocomplete_index help-block alert-error" id="receiver_surname_message"></span>
                	<?php if(isset($err['receiver_surname'])){ ?>
					<!-- PHP Validation	-->
                    <div class="alert alert-error show" id="receiver_surname_Error_css">

						<div id="receiver_surname_Error" class="requiredInformation"><?php  echo ucwords($err['receiver_surname']); ?></div>
					</div><!--	End PHP Validation	-->
					<?php } ?>
				</div><!--===/End To Surname	===-->
                <!--=== Company	===-->
                <div class="span12 form-group control-group margin-left_0">
                <label class="control-label"><?php echo COMMON_RECEIVER_COMPANY_NAME; ?></label>
                <input name="receiver_company_name" id="receiver_company_name" tabindex="11" type="text" class="span12 form-control" value="<?php if(isset($_POST['receiver_company_name']) && $_POST['receiver_company_name']!=''){ echo ucwords(valid_output($_POST['receiver_company_name'])); }else{ echo ucwords(valid_output($deliaddress->company));} ?>" onkeypress="javascript:removeError('receiver_company_name_Error_css');" autocomplete='off'/><br />
   					<span class="autocomplete_index help-block alert-error" id="receiver_company_name_message"></span>
                	<?php if(isset($err['receiver_company_name'])){ ?>
					<!-- PHP Validation	-->
                    <div class="alert alert-error show" id="receiver_company_name_Error_css">

						<div id="receiver_company_name_Error" class="requiredInformation"><?php  echo ucwords($err['receiver_company_name']); ?></div>
					</div><!--	End PHP Validation	-->
					<?php } ?>
				</div> <!--===/End To Company	===-->
                <!--=== Address 1	===-->
                <div class="span12 form-group control-group margin-left_0 margin-bottom_0">
                <label class="control-label"><?php echo COMMON_RECEIVER_ADDRESS; ?> <span class="color-red">*</span></label>
                <input name="receiver_address_1" id="receiver_address_1" tabindex="12"  type="text" class="span12 form-control" value="<?php if(isset($_POST['receiver_address_1']) && $_POST['receiver_address_1']!=''){ echo ucwords(valid_output($_POST['receiver_address_1'])); }else{ echo ucwords(html_entity_decode($deliaddress->address1));} ?>" onkeypress="javascript:removeError('receiver_address_1_Error_css');" autocomplete='off'/><br />
   					<span class="autocomplete_index help-block alert-error" id="receiver_address_1_message"></span>
                	<?php if(isset($err['receiver_address_1'])){ ?>
					<!-- PHP Validation	-->
                    <div class="alert alert-error show" id="receiver_address_1_Error_css">

						<div id="receiver_address_1_Error" class="requiredInformation"><?php  echo ucwords($err['receiver_address_1']); ?></div>
					</div><!--	End PHP Validation	-->
					<?php } ?>
				</div><!--===/End To Address 1	===-->
                <!--=== Address 2	===-->
                <div class="span12 form-group control-group margin-left_0 margin-bottom_0">
                <label></label>
                <input name="receiver_address_2" id="receiver_address_2" tabindex="13" type="text" class="span12 form-control" value="<?php if(isset($_POST['receiver_address_2']) && $_POST['receiver_address_2']!=''){ echo ucwords(valid_output($_POST['receiver_address_2'])); }else{ echo ucwords(html_entity_decode($deliaddress->address2));} ?>" onkeypress="javascript:removeError('receiver_address_2_Error_css');" autocomplete='off'/><br />
   					<span class="autocomplete_index help-block alert-error" id="receiver_address_2_message"></span>
                	<?php if(isset($err['receiver_address_2'])){ ?>
					<!-- PHP Validation	-->
                    <div class="alert alert-error show" id="receiver_address_2_Error_css">

						<div id="receiver_address_2_Error" class="requiredInformation"><?php  echo ucwords($err['receiver_address_2']); ?></div>
					</div><!--	End PHP Validation	-->
					<?php } ?>
				</div><!--===/End To Address 2	===-->
                <!--=== Address 3	===-->
                <div class="span12 form-group control-group margin-left_0">
                <label></label>
                <input name="receiver_address_3" id="receiver_address_3" tabindex="13" type="text" class="span12 form-control" value="<?php if(isset($_POST['receiver_address_3']) && $_POST['receiver_address_3']!=''){ echo ucwords(valid_output($_POST['receiver_address_3'])); }else{ echo ucwords(html_entity_decode($deliaddress->address3));} ?>" onkeypress="javascript:removeError('receiver_address_3_Error_css');" autocomplete='off'/><br />
   					<span class="autocomplete_index help-block alert-error" id="receiver_address_3_message"></span>
                	<?php if(isset($err['receiver_address_3'])){ ?>
					<!-- PHP Validation	-->
                    <div class="alert alert-error show" id="receiver_address_3_Error_css">

						<div id="receiver_address_3_Error" class="requiredInformation"><?php  echo ucwords($err['receiver_address_3']); ?></div>
					</div><!--	End PHP Validation	-->
					<?php } ?>
				</div><!--===/End To Address 3	===-->
                <!--=== If International	===-->
				<?php if(($service_name =='international')||($flag=="international"))
                                {?>
              	<!--=== Suburb	International===-->
                <div class="span12 form-group control-group margin-left_0">
                <label class="control-label"><?php echo COMMON_RECEIVER_SUBURB;?> <span class="color-red">*</span></label>
                <input name="receiver_suburb" id="receiver_suburb" tabindex="14" type="text" class="span12 form-control" value="<?php if(isset($_POST['receiver_suburb']) && $_POST['receiver_suburb']!=''){ echo valid_output($_POST['receiver_suburb']); }else{ echo valid_output($deliaddress->suburb);}?>" onkeypress="javascript:removeError('receiver_suburb_int_css');" autocomplete='off'/><br />
   					<span class="autocomplete_index help-block alert-error" id="receiver_suburb_int_message"></span>
                	<?php if(isset($err['receiver_suburb'])){ ?>
					<!-- PHP Validation	-->
                    <div class="alert alert-error show" id="receiver_suburb_int_Error_css">

                       	<div id="receiver_suburb_int_Error" class="requiredInformation"><?php  echo $err['receiver_suburb']; ?></div>
                    </div><!--	End PHP Validation	-->
					<?php } ?>
              	</div><!--===/End To Suburb International	===-->
                <!--=== State International	===-->
                <div class="span6 form-group control-group margin-left_0">
                <label class="control-label"><?php echo COMMON_RECEIVER_STATE; ?>
				<?php
				if(isset($state_validation) && $state_validation==1){?>
				<span class="color-red">*</span><?php } ?></label>
				<!--
				ajax_showOptions(this,'search_val',event,'<?php echo DIR_HTTP_RELATED; ?>tms_index.php','ajax_index_listOfOptions'),removeError('pickupError_css');
				related/inter_state_val.php-->
                <input name="receiver_state" id="receiver_state" tabindex="15"  onkeyup="ajax_showOptions(this,'search_val',event,'<?php echo DIR_HTTP_RELATED; ?>inter_state_val.php','ajax_index_listOfOptions'),removeError('pickupError_css');" type="text" class="span12 form-control" value="<?php if(isset($_POST['receiver_state']) && $_POST['receiver_state']!=''){ echo valid_output($_POST['receiver_state']) ; }else{ echo valid_output($deliaddress->state);}?>" onkeypress="javascript:removeError('receiver_state_int_Error_css');" autocomplete='off'/><br />

				<?php
					//print_r($deliaddress);
				?>
				<input type="hidden" name="receiver_state_code" id="receiver_state_code" value="<?php echo $deliaddress->state_code;  ?>"  />

   					<span class="autocomplete_index help-block alert-error" id="receiver_state_int_message"></span>
                	<?php if(isset($err['receiver_state'])){ ?>
					<!-- PHP Validation	-->
                    <div class="alert alert-error show" id="receiver_state_int_Error_css">

                        <div id="receiver_state_int_Error" class="requiredInformation"><?php echo $err['receiver_state']; ?></div>
					</div><!--	End PHP Validation	-->
					<?php } ?>
              	</div><!--===/End To State International	===-->
                <!--===	Post Code International	===-->

                <div class="span6 form-group control-group">
                <label class="control-label"><?php if(isset($allCountry->countries_id) && $allCountry->countries_id==UNITED_STATE_ID){ echo COMMON_US_ZIPCODE;}else{ echo COMMON_RECEIVER_POST_CODE;} ?> <span class="color-red">*</span></label>
				<?php

				/*
				if($flag=="international")
				{
					$rec_postcode = filter_var($deliaddress->postcode, FILTER_CALLBACK, array('options' => 'chkStreet'));
				}else{
					$rec_postcode = filter_var($deliaddress->postcode, FILTER_CALLBACK, array('options' => 'isNumeric'));
				}*/
				if(isset($_POST['receiver_postcode']) && $_POST['receiver_postcode']!=''){ $int_rec_postcode=$_POST['receiver_postcode']; }elseif(isset($deliaddress->postcode)){ $int_rec_postcode= $deliaddress->postcode;}


				$err_int_rec_postcode = filter_var($int_rec_postcode, FILTER_CALLBACK, array('options' => function($int_rec_postcode) {
					return chkStreet($int_rec_postcode);
				}));
				if(is_string($err_int_rec_postcode))
				{
					$err['receiver_postcode'] = $err_int_rec_postcode;
				}
				?>
               	<input name="receiver_postcode" id="receiver_postcode" tabindex="16" type="text" class="span12 form-control" value="<?php echo $int_rec_postcode;?>" onkeypress="javascript:removeError('receiver_postcode_int_Error_css');"  autocomplete='off'/><br />
   					<span class="autocomplete_index help-block alert-error" id="receiver_postcode_int_message"></span>
                	<?php if(isset($err['receiver_postcode'])){ ?>
					<!-- PHP Validation	-->
                    <div class="alert alert-error show" id="receiver_postcode_int_Error_css">

                        <div id="receiver_postcode_int_Error" class="requiredInformation"><?php  echo $err['receiver_postcode']; ?></div>
					</div><!--	End PHP Validation	-->
					<?php } ?>



              	</div><!--===/End To Post Code International	===-->
                <!--===/End If International	===-->
				<?php
				if(isset($_GET['error'])){  ?>

                <div class="span12 form-group control-group margin-left_0">
				<!-- PHP Validation	-->
                    <div class="alert alert-error show" id="receiver_state_int_Error_css">

                        <div id="receiver_state_int_Error" class="requiredInformation"><?php echo ADDRESSES_POSTCODE_CORRECT; ?></div>
					</div><!--	End PHP Validation	-->
				</div>
				<?php
					}
				?>
                <!--=== If Australia	===-->
                              <?php
                                 }
                                 else
                                 {?>
             	<!--=== To Suburb ===-->
                <div class="span12 form-group control-group margin-left_0">
                <label class="control-label"><?php echo COMMON_RECEIVER_SUBURB;?> <span class="color-red">*</span></label>
                <input name="receiver_suburb" readonly id="receiver_suburb" type="text" class="span12 form-control" value="<?php  if(isset($_POST['receiver_suburb']) && $_POST['receiver_suburb']!=''){ echo valid_output($_POST['receiver_suburb']); }else{ echo valid_output($Delivervalue['Name']);}?>" autocomplete='off'/><br />
                	<span class="autocomplete_index help-block alert-error"></span>
                	<?php if(isset($err['receiver_suburb'])){ ?>
					<!-- PHP Validation	-->
                    <div class="alert alert-error show" id="receiver_suburb_Error_css">
                    	<div id="receiver_suburb_Error" class="requiredInformation"><?php echo $err['receiver_suburb']; ?></div>
					</div><!--	End PHP Validation	-->
					<?php } ?>
				</div><!--===/End To Suburb	===-->
                <!--=== To State ===-->
                <div class="span6 form-group control-group margin-left_0">
                <label class="control-label"><?php echo COMMON_RECEIVER_STATE; ?> <span class="color-red">*</span></label><br />
                <input name="receiver_state" readonly id="receiver_state" type="text" class="span6 form-control" value="<?php if(isset($_POST['receiver_state']) && $_POST['receiver_state']!=''){ echo valid_output($_POST['receiver_state']); }else{ echo valid_output($Delivervalue['State']);}?>" autocomplete='off'/><br />
                	<span class="autocomplete_index help-block alert-error"></span>
                	<?php if(isset($err['receiver_state'])){ ?>
					<!-- PHP Validation	-->
                    <div class="alert alert-error show" id="receiver_state_Error_css">

						<div id="receiver_state_Error" class="requiredInformation"><?php  if(isset($err['receiver_state'])){echo $err['receiver_state'];} ?></div>
					</div><!--	End PHP Validation	-->
					<?php } ?>
				</div><!--===/End To State ===-->
                <!--=== To Postcode ===-->
                <div class="span6 form-group control-group">
                <label class="control-label"><?php echo COMMON_RECEIVER_POST_CODE; ?> <span class="color-red">*</span></label>
				<?php
				if(isset($_POST['receiver_postcode']) && $_POST['receiver_postcode']!=''){ $rec_postcode=trim($_POST['receiver_postcode']); }else{ $rec_postcode= trim($Delivervalue['Postcode']);}

				$err_rec_postcode = filter_var($rec_postcode, FILTER_CALLBACK, array('options' => function($rec_postcode) {
					return isNumeric($rec_postcode, ERROR_ENTER_NUMERIC_VALUE);
				}));
				if(is_string($err_rec_postcode))
				{
					$err['receiver_postcode'] = 'ERROR_ENTER_NUMERIC_VALUE';
				}
				?>
                <input name="receiver_postcode" readonly id="receiver_postcode" type="text" class="span12 form-control" value="<?php echo $rec_postcode; ?>" autocomplete='off'/><br />
                	<span class="autocomplete_index help-block alert-error"></span>
                	<?php if(isset($err['receiver_postcode'])){ ?>
					<!-- PHP Validation	-->
                    <div class="alert alert-error show" id="receiver_postcode_Error_css">

						<div id="receiver_postcode_Error" class="requiredInformation"><?php  echo $err['receiver_postcode']; ?></div>
					</div><!--	End PHP Validation	-->
					<?php } ?>
				</div><!--===/End To Postcode ===-->
                              <?php }

                                 ?>
                              <?php if(($service_name =='international')||($flag=="international"))
                                 {       	 //echo $CountryName->country;
                                 ?>
                <!--=== To Country ===-->
           		<div class="span12 form-group control-group margin-left_0">
                <label class="control-label"><?php echo COMMON_RECEIVER_COUNTRY; ?> <span class="color-red">*</span></label>
                <input name="receiver_country" readonly id="receiver_country" type="text" class="span12 form-control" value="<?php if(isset($_POST['receiver_country']) && $_POST['receiver_country']!=''){ echo valid_output($_POST['receiver_country']); }else{ echo valid_output($allCountry->countries_name);}?>" />
                </div><!--===/End To Country ===-->
                              <?php } ?>
                <!--=== To Email ===-->
                <div class="span12 form-group control-group margin-left_0">
                <label class="control-label"><?php echo COMMON_RECEIVER_EMAIL; ?></label>
                <input name="receiver_email"  id="receiver_email" tabindex="17" type="email" class="span12 form-control" value="<?php if(isset($_POST['receiver_email']) && $_POST['receiver_email']!=''){ echo valid_output($_POST['receiver_email']); }else{ echo valid_output($deliaddress->email);}?>" onkeypress="javascript:removeError('receiver_email_Error_css');" autocomplete='off'/><br />

					<span class="autocomplete_index help-block alert-error" id="receiver_email_message"></span>
                	<?php if(isset($err['receiver_email'])){ ?>
                    <div class="alert alert-error show" id="receiver_email_Error_css">

                        <div id="receiver_email_Error" class="requiredInformation"><?php  echo $err['receiver_email']; ?></div>
					</div>
					<?php } ?>
             	</div><!--===/End To Email ===-->
                <!--===To Primary Tel	===-->
				<!--===	Area Primary Tel	===-->
				 <div class="span6 form-group control-group margin-left_0">
                <label class="control-label"><?php echo COMMON_COUNTRY_CODE; ?> <span class="color-red">*</span></label><br />
				<?php

					if(isset($int_area_code) && $int_area_code!="" && $flag=="international" && (!isset($deliaddress->area_code) && $deliaddress->area_code=="")){
						$receiver_area_code = $int_area_code;
					}elseif(isset($deliaddress->area_code) && $deliaddress->area_code!="" && $flag=="international"){
						$receiver_area_code = $deliaddress->area_code;
					}elseif(isset($_POST['receiver_area_code'])&& $_POST['receiver_area_code']!=""){
						$receiver_area_code = $_POST['receiver_area_code'];
					}else{
						$receiver_area_code = '61';
					}
				?>
                <input type="tel" id="receiver_area_code" name="receiver_area_code" value="<?php echo $receiver_area_code;  ?>"  class="span6 form-control" onkeypress="javascript:removeError('receiver_contact_area_code_no_Error_css');">
   					<span class="autocomplete_index help-block alert-error" id="receiver_mobile_area_code_no_message"></span>
                	<?php if(isset($err['receiver_area_code'])){ ?>
					<!-- PHP Validation	-->
                    <div class="alert alert-error show" id="receiver_contact_area_code_no_Error_css">

                      	<div id="receiver_contact_area_code_no_Error" class="requiredInformation"><?php  echo ucwords($err['receiver_area_code']);?></div>
                    </div><!--	End PHP Validation	-->
					<?php } ?>
               	</div>
                <!--===/End Area Primary Tel	===-->
                <!--===	To Primary Tel	===-->
               	<div class="span6 form-group control-group">
                <label class="control-label"><?php echo COMMON_RECEIVER_CONTACT_NUMBER; ?> <span class="color-red">*</span></label>
				<input name="receiver_contact_no" id="receiver_contact_no" tabindex="18" type="tel" class="span12 form-control" value="<?php if(isset($_POST['receiver_contact_no']) && $_POST['receiver_contact_no']!=''){ echo $_POST['receiver_contact_no']; }else{ echo $deliaddress->phoneno;} ?>" onkeypress="javascript:removeError('receiver_contact_no_Error_css');" autocomplete='off' />
   					<span class="autocomplete_index help-block alert-error" id="receiver_contact_no_message"></span>
                	<?php if(isset($err['receiver_contact_no'])){ ?>
					<!-- PHP Validation	-->
                    <div class="alert alert-error show" id="receiver_contact_no_Error_css">

						<div id="receiver_contact_no_Error" class="requiredInformation"><?php  if(isset($err['receiver_contact_no'])){echo $err['receiver_contact_no'];} ?></div>
					</div><!--	End PHP Validation	-->
					<?php } ?>
            	</div><!--===/End To Primary Tel	===-->
                <!--=== Secondary Tel	===-->
                <div class="span6 form-group control-group margin-left_0">
                <label class="control-label"><?php echo COMMON_COUNTRY_CODE; ?></label><br />
                <input type="tel" id="receiver_mb_area_code" name="receiver_mb_area_code" value="<?php if(isset($deliaddress->m_area_code) && $deliaddress->m_area_code!="" && $flag!="international"){echo valid_output($deliaddress->m_area_code);}elseif(isset($_POST['receiver_mb_area_code']) && $_POST['receiver_mb_area_code']!=""){ echo $_POST['receiver_mb_area_code'];}elseif(isset($int_m_area_code) && $int_m_area_code!="" && $flag=="international"){echo $int_m_area_code;}else{ echo "61";} ?>"  class="span6 form-control" onkeypress="javascript:removeError('receiver_mobile_area_code_no_Error_css');">
   					<span class="autocomplete_index help-block alert-error" id="receiver_mobile_area_code_no_message"></span>
                	<?php if(isset($err['receiver_mb_area_code'])){ ?>
					<!-- PHP Validation	-->
                    <div class="alert alert-error show" id="receiver_mobile_area_code_no_Error_css">

                      	<div id="receiver_mobile_area_code_no_Error" class="requiredInformation"><?php  echo ucwords($err['receiver_mb_area_code']);?></div>
                    </div><!--	End PHP Validation	-->
					<?php } ?>
               	</div>
				<div class="span6 form-group control-group">
                <label class="control-label"><?php echo COMMON_RECEIVER_ALTERNATE_NUMBER; ?></label>
				<input name="receiver_mobile_no" id="receiver_mobile_no"  type="tel" class="span12 form-control" value="<?php if(isset($_POST['receiver_mobile_number']) && $_POST['receiver_mobile_number']!=''){ echo $_POST['receiver_mobile_number']; }else{ echo $deliaddress->mobileno;} ?>" onkeypress="javascript:removeError('receiver_mobile_no_Error_css');" autocomplete='off'/><br />
   					<span class="autocomplete_index help-block alert-error" id="receiver_mobile_no_message"></span>
                	<?php if(isset($err['receiver_mobile_number'])){ ?>
					<!-- PHP Validation	-->
                    <div class="alert alert-error show" id="receiver_mobile_no_Error_css">

						<div id="receiver_mobile_no_Error" class="requiredInformation"><?php  echo $err['receiver_mobile_number']; ?></div>
					</div><!--	End PHP Validation	-->
					<?php } ?>
				</div><!--===/End Secondary Tel	===-->
				<!-- Start checkbox to save delivered address in address book --->
				<?php if(isset($userid) && !empty($userid)){
					$del_display = "block";
					$delchecked ="checked";
					
					/*
					if(isset($_SESSION['chk_del_address']) && $_SESSION['chk_del_address']==1)
					{
						$del_display = "block";
						$allCountry->countries_id
					} */

				?>
				<div class="span12 form-group control-group" style="display:<?php echo $del_display; ?>;" id="divdeladdress">
                	<label class="control-label control-label-long">
						<p class="my_bigger_font"><?php echo ADDRESSES_DELIVEREDADDRESS_SAVE; ?></p></label>
					<input type="checkbox" name="deladdress" id="deladdress"value="1" <?php echo $delchecked; ?> />
				<span class="autocomplete_index help-block alert-error" id="save_deladdress_message"></span>
                	<?php if(isset($err['delivery_deladdress'])){ ?>
					<!-- PHP Validation	-->
                    <div class="alert alert-error show" id="save_deladdress_no_Error_css">

                    	<div id="save_deladdress_Error" class="requiredInformation"><?php  echo $err['delivery_deladdress']; ?></div>
                    </div><!--	End PHP Validation	-->
					<?php } ?>
				</div>
				<?php
					}
				?>
				<!-- End checkbox  to save delivered address in address book --->
        	</div><!--====/End  To ====-->
			<?php
				$btn_name = 'NEXT';
				$bk_name = 'PREVIOUS';
				if(isset($_GET['Action']) && $_GET['Action']=='edit')
				{
					$bk_name = 'CANCEL';
					$btn_name = 'SAVE';
				}
			?>
			<div class="span12 margin-left_0">
			<input type="button" onClick="document.location='<?php  echo $backurl; ?>'"  class="btn-u btn-u-large pull-left" name="BackButton" value="&laquo; <?php echo $bk_name; ?>" />
			<input name="changed_cntry" id="changed_cntry" type="hidden" class="span12 form-control" value="<?php echo $allCountry->countries_id; ?>" />
        	<input type="hidden" name="ConfrimBooking" id="ConfrimBooking" value=""/>
        	<input type="hidden" name="service_name" value="<?php echo valid_output($service_name); ?>" id="service_name" />
        	<input type="hidden" name="selected_flag"  value="<?php echo  valid_output($flag);?>" id="selected_flag" />
        	<input type="hidden" id="ptoken" value="<?php echo $ptoken; ?>" name="ptoken">
			<input type="hidden" name="sender_client_address_id" id="sender_client_address_id" value="<?php echo $sender_client_address_id; ?>" >
			<input type='hidden' name='finalsubmit' id='finalsubmit' />
			<!--<button type="submit" tabindex="34" class="btn-u btn-u-large pull-right" name="next" /><?php echo $btn_name; ?>&raquo;</button>-->
			<button class="btn-u btn-u-large pull-right" tabindex="34" type="submit"  name="Save" id="Save" /><?php echo $btn_name; ?> &raquo;</button>
            <button type="button" class="btn align_centre just_block Reset" id="reset">Reset</button>
            </div>




   <!--=== Start Address Error ===-->
<div class="modal hide fade small_rates" id="AddressError" data-backdrop="static" data-keyboard="false">
<div class="modal-header">
<h3><?php echo ADDRESSES_WRONG_HEAD; ?></h3>
</div>
<div class="modal-body justy">
<div id="address_display"></div>

</div>
<div class="modal-footer"><a href="#" class="btn-u btn-u-primary"  id="addressClsModal">Close</a></div>
</div>
<!--=== End Address Error ===-->
   	</form>
     </div><!--/Container Block	-->
    <!-- Right Column -->
    <div class="span3 bg-lighter">
		<?php include(DIR_WS_RELATED.FILE_BOOKING_SUMMARY); ?>
    </div><!--/span3-->

    </div><!--/row-fluid-->
</div><!--/container-->
<!--DIV confirmBox starts here-->
<div class="modal hide fade small_rates" id="confirmBox">
    <div class="modal-header">
        <h3>Delete Address</h3>
    </div>
    <div class="modal-body">
        <div id="message"></div>
        <div id="message2"></div>
        <div class="btn btn-primary pull-left" id="no">No</div>
        <div class="btn btn-primary pull-right" id="yes">Yes</div>
    </div>
    <div class="modal-footer"></div>
</div>
<!--DIV error msg box starts here-->
<div class="modal hide fade small_rates" id="errorBox">
    <div class="modal-header">
        <h3><?php echo ADDRESSBOOK_WRONG_SUB_HEAD;?></h3>
    </div>
    <div class="modal-body my_bigger_font" id="msgContent">
        <?php echo valid_output($error_new); ?>
        <div class="btn btn-primary pull-right" id="yes">Login</div>
    </div>
    <div class="modal-footer"><a href="#" class="btn-u btn-u-primary" data-dismiss="modal" id="closemodal">Close</a></div>
</div>
