<div class="breadcrumbs margin-bottom-50">
    <div class="container">
        <h1 class="color-green pull-left"><?php echo QUOTE_CUSTOMER_DETAILS; ?></h1>
        <ul class="pull-right breadcrumb">
            <li><a href="<?php echo SITE_INDEX;?>"><?php echo COMMON_HOME; ?></a> <span class="divider">/</span></li>
            <li class="active"><?php echo QUOTE_CUSTOMER_DETAILS; ?></li>
        </ul>
    </div><!--/container-->
</div><!--/breadcrumbs-->
<div class="container">
	<div class="row-fluid margin-bottom-10">
		<div class="containerBlock">
			<form name="quote_customer_details" id="quote_customer_details" autocomplete='off' class="reg-page" method="post">
				<h3><?php echo QUOTE_CUSTOMER_DETAILS_PAGE; ?></h3>
				<?php
					if(isset($_GET['msg']) && !empty($_GET['msg']))
					{
						echo $_GET['msg'];
					}
				?>
				<!--==	1st Row	==-->	
					<div class="controls">
						<!--==	FirstName	==-->
						<div class="span6 form-group control-group">
						<label class="control-label"><?php echo QUOTE_SENDER_NAME; ?><span class="color-red">*</span></label>
						<input name="firstname" id="firstname" type="text" class="span12 form-control" value="<?php if(isset($_GET['CatId'])){echo valid_output($clientAddressEdit->firstname);}else{ echo valid_output($_POST['firstname']);} ?>" tabindex="1" onkeypress="javascript:removeError('error_firstname_css');" autocomplete='off'/>
							<span class="autocomplete_index help-block alert-error" id="firstname_message"></span>
							<?php
							if(isset($err['firstname'])){
							?>
							<!-- PHP Validation	-->
							<div class="alert alert-error show" id="firstname_Error_css">
								<div id="firstname_Error"> <?php echo $err['firstname'];?></div>
							</div><!--	End PHP Validation	-->
							<?php
							}
							?>
						</div><!--==/End FirstName	==-->
						<!--==	LastName	==-->
						<div class="span6 form-group control-group">
						<label class="control-label"><?php echo QUOTE_SENDER_SURNAME; ?> <span class="color-red">*</span></label>
						<input name="lastname" id="lastname" type="text" class="span12 form-control" value="<?php if(isset($_GET['CatId'])){echo  valid_output($clientAddressEdit->surname);} else{ echo valid_output($_POST['lastname']);} ?>" tabindex="2" onkeypress="javascript:removeError('error_lastname_css');" autocomplete='off'/>
							<span class="autocomplete_index help-block alert-error" id="lastname_message"></span>
							<?php 
							if(isset($err['lastname'])){
							?>
							<!-- PHP Validation	-->
							<div class="alert alert-error show" id="lastname_Error_css">
								<div id="lastname_Error" class="requiredInformation"><?php  echo $err['lastname'];?></div>
							</div><!--	End PHP Validation	-->
							<?php
							}
							?>
						</div><!--==/End LastName	==-->
					</div>
					<!--==/End of the 1st Row	==-->
					<!--==	2nd Row	==-->
					<div class="controls"> 
						<!--==	Company	==-->
			        <div class="span12 form-group control-group"> 
			        <label class="control-label"><?php echo QUOTE_COMPANY_NAME; ?></label>
			        <input name="company" id="company" type="text" class="span12 form-control" value="<?php if(isset($_GET['CatId'])){echo valid_output($clientAddressEdit->company);}else{ echo valid_output($_POST['company']);} ?>" tabindex="3" onkeypress="javascript:removeError('error_company_css');" autocomplete='off'/>
			            <span class="autocomplete_index help-block alert-error" id="company_message"></span>
			         	<?php 
						if(isset($err['company'])){
						?>
						<!-- PHP Validation	-->
			          	<div class="alert alert-error show" id="company_Error_css">
			            	<div id="company_Error" class="requiredInformation"><?php  echo $err['company'];?></div>
			       		</div><!--	End PHP Validation	-->
						<?php
			           	}
						?>
						</div><!--==/End Company	==-->
					</div><!--==/End 2nd Row	==-->
					<!--==	3rd Row	==-->
					<div class="controls">
		        	<!--==	Address 1	==-->
		            <div class="span12 form-group control-group"> 
		            <label class="control-label"><?php echo QUOTE_ADDRESS; ?> <span class="color-red">*</span></label>
		            <input name="address1" id="address1" type="text" class="span12 form-control" value="<?php if(isset($_GET['CatId'])){echo valid_output($clientAddressEdit->address1);}else{ echo valid_output($_POST['address1']);} ?>" tabindex="4" onkeypress="javascript:removeError('error_address1_css');" autocomplete='off'/>
		                <span class="autocomplete_index help-block alert-error" id="address1_message"></span>
		             	<?php 
						if(isset($err['address1'])){
						?>
						<!-- PHP Validation	-->
		              	<div class="alert alert-error show" id="address1_Error_css">
		                	<div id="address1_Error" class="requiredInformation"><?php  echo $err['address1'];?></div>
		           		</div><!--	End PHP Validation	-->
						<?php
		               	}
						?>
		            </div><!--==/End Address 1	==-->
		        </div><!--==/End 3rd Row	==-->
		        <!--==	4th Row	==-->
			        <div class="controls">
			            <!--==	Address 2	==-->
			            <div class="span12 form-group control-group">
			            <label></label>
			            <input name="address2" id="address2" type="text" class="span12 form-control" value="<?php if(isset($_GET['CatId'])){echo valid_output($clientAddressEdit->address2);}else{ echo valid_output($_POST['address2']);} ?>" tabindex="5" onkeypress="javascript:removeError('error_address2_css');" autocomplete='off' />
			                <span class="autocomplete_index help-block alert-error" id="address2_message"></span>
			             	<?php 
							if(isset($err['address2'])){
							?>
							<!-- PHP Validation	-->
			              	<div class="alert alert-error show" id="address2_Error_css">
			                	<div id="address2_Error" class="requiredInformation"><?php  echo $err['address2'];?></div>
			           		</div><!--	End PHP Validation	-->
							<?php
			               	}
							?>
			            </div><!--==/End Address 2	==-->
			        </div><!--==/End 4th Row	==-->
			        <!--==	5th Row	==-->
			        <div class="controls">
			        	<!--== Address 3	==-->
			            <div class="span12 form-group control-group">
			            <label></label>
			            <input name="address3" id="address3" type="text" class="span12 form-control" value="<?php if(isset($_GET['CatId'])){echo valid_output($clientAddressEdit->address3);}else{ echo valid_output($_POST['address3']);} ?>" tabindex="6" onkeypress="javascript:removeError('error_address3_css');" autocomplete='off'/>
			                <span class="autocomplete_index help-block alert-error" id="address3_message"></span>
			             	<?php 
							if(isset($err['address3'])){
							?>
							<!-- PHP Validation	-->
			              	<div class="alert alert-error show" id="address3_Error_css">
			                	<div id="address3_Error" class="requiredInformation"><?php  echo $err['address3'];?></div>
			           		</div><!--	End PHP Validation	-->
							<?php
			               	}
							?>
			            </div><!--==/End Address 3	==-->
			        </div><!--== /End 5th Row	==-->
					<!--==	6th Row	==-->
			        <div class="controls">
			        	<!--==	Country	==-->
			            <div class="span12 form-group control-group">
			            <label><?php echo QUOTE_COUNTRY; ?> <span class="color-red">*</span></label>
			                <select class="span12" tabindex="7" id="country" name="country" onchange="choose_country('country')">
								<option value="">Select</option>
								<?php 
									foreach ($countryCode as $Postcode)
									{
										if($clientAddressEdit->countryid == $Postcode->countries_id)
										{
											$selected = "selected='selected'";
											if($clientAddressEdit->countryid == COUNTRY_SELECT)
											{
												$readonly = "readonly='readonly'";
											}
										}
										else
										{
											$selected = "";
										}
										
								?>
								<option id="<?php  echo filter_var($Postcode->countries_id,FILTER_VALIDATE_INT);?>" value="<?php echo filter_var($Postcode->countries_id,FILTER_VALIDATE_INT);?>" <?php if($Postcode->countries_id == 13){echo "selected"; }else{ echo $selected;} ?>>
								<?php echo valid_output($Postcode->countries_name);?>
								<?php } ?>
								</option>
							</select>
							<?php
							
							if(isset($_POST['country']) && $_POST['country']!="")
							{
								$default_country =$_POST['country'];
							}elseif(isset($clientAddressEdit->countryid))
							{
								$default_country =$clientAddressEdit->countryid;
							}else{
								$default_country ='13';
							}
							?>
							<input type="hidden" name="changed_cntry" id="changed_cntry" value="<?php echo $default_country;?>" />
							<input type="hidden" name="country_name" id="country_name" value="<?php if(isset($clientAddressEdit->country)){echo valid_output($clientAddressEdit->country);}else{ echo "Australia";}?>">
							<span class="autocomplete_index help-block alert-error" id="country_message"></span>
			            </div><!--==/End Country	==-->
			        </div><!--== /End 6th Row	==-->
			        <!--==	7th Row	==-->
			        <div class="controls">
			        	<!--==	Suburb	==-->
			            <div class="span12 form-group control-group">
			            <label class="control-label"><?php echo QUOTE_SUBURB; ?> <span class="color-red">*</span></label>
			            <input name="suburb" id="suburb" type="text" value="<?php if(isset($_GET['CatId'])){echo valid_output($clientAddressEdit->suburb);}else{ echo valid_output($_POST['suburb']);} ?>" class="span12 form-control" autocomplete="off"  tabindex="8" onkeypress="javascript:removeError('error_suburb_css');" />
						<input type="hidden"  id="fsuburb" name="fsuburb" />
			            	<span class="autocomplete_index help-block alert-error" id="suburb_message"></span>			
							<?php if(isset($err['suburb'])){ ?>
							<!-- PHP Validation	-->
			              	<div class="alert alert-error show" id="suburb_Error_css">
			                	<div id="suburb_Error" class="requiredInformation"><?php echo $err['suburb']; ?></div>
			              	</div><!--	End PHP Validation	-->
							<?php
			                } 
							?>
			            </div><!--==/End Suburb	==-->
			        </div><!--==/End 7th Row	==-->
			        <!--==	8th Row	==-->
					
			        <div class="controls">
			            <!--==	State	==-->
			            <div class="span6 form-group control-group">
			           	<label class="control-label"><?php echo QUOTE_STATE; ?> <span class="color-red">*</span></label><br />
			          	<input name="state" <?php if(isset($_GET['CatId']) && $clientAddressEdit->country == '13'){ echo "readonly";} ?> id="state" type="text" class="span6 form-control" value="<?php if(isset($_GET['CatId'])){echo valid_output($clientAddressEdit->state);}else{ echo valid_output($_POST['state']);} ?>"   tabindex="9" onkeyup="ajax_showOptions(this,'search_val',event,'<?php echo DIR_HTTP_RELATED; ?>inter_state_val.php','ajax_index_listOfOptions'),removeError('pickupError_css');" onkeypress="javascript:removeError('error_state_css');" autocomplete='off' />
						
						<input type="hidden" name="register_state_code" id="register_state_code" value="<? if($_POST['register_state_code'] != ''){ echo valid_output($_POST['register_state_code']); }elseif ($clientAddressEdit!='') { echo valid_output($clientAddressEdit->state_code); } ?>"  />
			            	<span class="autocomplete_index help-block alert-error" id="state_message"></span>			
							<?php if(isset($err['state'])){ ?>
							<!-- PHP Validation	-->
			              	<div class="alert alert-error show" id="state_Error_css">
			                	<div id="state_Error" class="requiredInformation"><?php echo $err['state']; ?></div>
			              	</div><!--	End PHP Validation	-->
							<?php
			                } 
							?>
			            </div><!--==/End State	==-->
			            <!--==	Postcode	==-->
						<?php
						//echo $Users->country;
						///echo "<pre>";
						//print_r();
						//echo "</pre>";
						?>
			            <div class="span6 form-group control-group">
			           	<label class="control-label" id="pstlbl"><?php if($clientAddressEdit->countryid == UNITED_STATE_ID || $_POST['country'] == UNITED_STATE_ID) { echo COMMON_US_ZIPCODE;}else{
							echo QUOTE_ZIPCODE;
						} ?> <span class="color-red">*</span></label>
						<?php
							if($Users->country == COUNTRY_SELECT || $_POST['country'] == COUNTRY_SELECT)
							{
								if(isset($_GET['CatId'])){
									$postcode = filter_var($clientAddressEdit->postcode,FILTER_VALIDATE_INT);
								}else{ 
									$postcode = filter_var($_POST['postcode'],FILTER_VALIDATE_INT);
								}
							}else{
								
								if(isset($_GET['CatId'])){
									$postcode = $clientAddressEdit->postcode;
								}else{ 
									$postcode = $_POST['postcode'];
								}
								
								$err_int_postcode = filter_var($postcode, FILTER_CALLBACK, array('options' => function($postcode) {
									return chkStreet($postcode);
								}));
								if(is_string($err_int_postcode))
								{
									$err['postcode'] = $err_int_postcode;
								}
							}
						?>
			          	<input name="postcode" id="postcode" type="text" class="span12 form-control" value="<?php echo $postcode;?>" tabindex="10" <?php if(isset($_GET['CatId']) && $clientAddressEdit->country == '13'){ echo "readonly";} ?> onkeypress="javascript:removeError('error_postcode_css');" autocomplete='off'/>
			            	<span class="autocomplete_index help-block alert-error" id="postcode_message"></span>			
							<?php if(isset($err['postcode'])){ ?>
							<!-- PHP Validation	-->
			              	<div class="alert alert-error show" id="postcode_Error_css">
			                	<div id="postcode_Error" class="requiredInformation"><?php echo $err['postcode']; ?></div>
			              	</div><!--	End PHP Validation	-->
							<?php
			                } 
							?>
			            </div> <!--==/End Postcode	==-->
			           <!--	Divider	-->
			            <div class="span12 margin-left_0 ">
			            	<div class="margin_bottom_20_important">&nbsp;</div>
			            </div> 
			      	</div><!--==/End 8th Row	==-->
			      	
			        <!--==	10th Row	==-->
			        <div class="controls">
			        	<!--==	Email	==-->
			            <div class="span12 form-group control-group"> 
			            <label class="control-label"><?php echo QUOTE_CONTACT_NUMBER; ?><span class="color-red">*</span></label>
			            <input name="contactNo" id="contactNo" type="tel" class="span12 form-control" value="<?php if(isset($_GET['CatId'])){echo filter_var($clientAddressEdit->phoneno, FILTER_VALIDATE_FLOAT);}else{ echo filter_var($_POST['contactNo'], FILTER_VALIDATE_FLOAT);} ?>" tabindex="11" onkeypress="javascript:removeError('error_phone_css');" autocomplete='off'/>
			                <span class="autocomplete_index help-block alert-error" id="phone_message"></span>
			                <?php if(isset($err['contactNo'])){ ?>
							<!-- PHP Validation	-->
			              	<div class="alert alert-error show" id="phone_Error_css">
			                	<div id="phone_Error" class="requiredInformation"><?php  echo $err['contactNo']; ?></div>
			               	</div><!--	End PHP Validation	-->
							<?php
			                }
							?>
			            </div><!--==/End Email	==-->
			        </div><!--==/End 10th Row	==-->
			        <!--==	10th Row	==-->
			        <div class="controls">
			        	<!--==	Email	==-->
			            <div class="span12 form-group control-group"> 
			            <label class="control-label"><?php echo QUOTE_MOBILE_NUMBER; ?><span class="color-red">*</span></label>
			            <input name="mobileNo" id="mobileNo" type="tel" class="span12 form-control" value="<?php if(isset($_GET['CatId'])){echo filter_var($clientAddressEdit->phoneno, FILTER_VALIDATE_FLOAT);}else{ echo filter_var($_POST['mobileNo'], FILTER_VALIDATE_FLOAT);} ?>" tabindex="11" onkeypress="javascript:removeError('error_phone_css');" autocomplete='off'/>
			                <span class="autocomplete_index help-block alert-error" id="mobile_message"></span>
			                <?php if(isset($err['mobileNo'])){ ?>
							<!-- PHP Validation	-->
			              	<div class="alert alert-error show" id="phone_Error_css">
			                	<div id="phone_Error" class="requiredInformation"><?php  echo $err['mobileNo']; ?></div>
			               	</div><!--	End PHP Validation	-->
							<?php
			                }
							?>
			            </div><!--==/End Email	==-->
			        </div><!--==/End 10th Row	==-->
					<!--==	10th Row	==-->
			        <div class="controls">
			        	<!--==	Email	==-->
			            <div class="span12 form-group control-group"> 
			            <label class="control-label"><?php echo QUOTE_EMAIL_ID; ?></label>
			            <input name="email" id="email" type="text" class="span12 form-control" value="<?php if(isset($_GET['CatId'])){echo valid_output($clientAddressEdit->email);}else{ echo valid_output($_POST['email']);} ?>" tabindex="12" onkeypress="javascript:removeError('error_email_css');" autocomplete='off'/>
			            	<span class="autocomplete_index help-block alert-error" id="email_message"></span>
			                <?php if(isset($err['EmailId'])){ ?>
							<!-- PHP Validation	-->
			              	<div class="alert alert-error show" id="email_Error_css">
			              		<div id="email_Error" class="requiredInformation"><?php  echo $err['EmailId']; ?></div>
			               	</div><!--	End PHP Validation	-->
							<?php
			                }
							?>
			            </div><!--==/End Email	==-->
			        </div><!--==/End 10th Row	==-->
			        <!--==	11th Row	==-->
			        <div class="controls">
			        	<!--==	Email	==-->
			            <div class="span12 form-group control-group"> 
			            <label class="control-label"><?php echo QUOTE_CONTACT_NAME; ?></label>
			            <input name="contact_name" id="contact_name" type="text" class="span12 form-control" value="<?php if(isset($_GET['CatId'])){echo valid_output($clientAddressEdit->email);}else{ echo valid_output($_POST['email']);} ?>" tabindex="12" onkeypress="javascript:removeError('error_email_css');" autocomplete='off'/>
			            	<span class="autocomplete_index help-block alert-error" id="email_message"></span>
			                <?php if(isset($err['EmailId'])){ ?>
							<!-- PHP Validation	-->
			              	<div class="alert alert-error show" id="email_Error_css">
			              		<div id="email_Error" class="requiredInformation"><?php  echo $err['EmailId']; ?></div>
			               	</div><!--	End PHP Validation	-->
							<?php
			                }
							?>
			            </div><!--==/End contact name	==-->
			        </div><!--==/End 11th Row	==-->
			        <!--==	12th Row	==-->
			        <div class="controls">
			        	<!--==	Email	==-->
			            <div class="span12 form-group control-group"> 
			            <label class="control-label"><?php echo QUOTE_ACCOUNT_NUMBER; ?><span class="color-red">*</span></label>
			            <input name="account_number" id="account_number" type="text" class="span12 form-control" value="<?php if(isset($_GET['CatId'])){echo valid_output($clientAddressEdit->email);}else{ echo valid_output($_POST['email']);} ?>" tabindex="12" onkeypress="javascript:removeError('error_email_css');" autocomplete='off'/>
			            	<span class="autocomplete_index help-block alert-error" id="account_number_message"></span>
			                <?php if(isset($err['EmailId'])){ ?>
							<!-- PHP Validation	-->
			              	<div class="alert alert-error show" id="email_Error_css">
			              		<div id="email_Error" class="requiredInformation"><?php  echo $err['EmailId']; ?></div>
			               	</div><!--	End PHP Validation	-->
							<?php
			                }
							?>
			            </div><!--==/End contact name	==-->
			        </div><!--==/End 12th Row	==-->
					<div class="controls form-inline text_centre">
						<div class="span12 form-group control-group">
							<button class="btn-u pull-right" type="submit"  name="Save" id="Save" />Save</button>&nbsp;
							<input class="btn-u pull-left" type="button" onclick="javascript:historyBack();" value="Back"/>&nbsp;
						</div>
					</div>
			</form>
		</div>
	</div>
</div>