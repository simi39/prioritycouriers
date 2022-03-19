<!--=== Breadcrumbs ===-->
<div class="breadcrumbs margin-bottom-50">
    <div class="container">
        <h1 class="color-green pull-left"><?php echo PROFILE_PAGE_NAME; ?></h1>
        <ul class="pull-right breadcrumb">
            <li><a href="<?php echo SITE_INDEX;?>"><?php echo COMMON_HOME; ?></a> <span class="divider">/</span></li>
            <li class="active"><?php echo PROFILE_PAGE_NAME; ?></li>
        </ul>
    </div><!--/container-->
</div><!--/breadcrumbs-->

<!--Container-->
<div class="container">
    <div class="row-fluid margin-bottom-10">
	<div class="containerBlock">
	<form action="" method="post" name="Frmaddclient" id="Frmaddclient" class="reg-page" autocomplete="off"><h3><?php echo PROFILE_PAGE_EDIT; ?></h3>
        <!--==	1st Row	==-->
        <div class="controls">
            <!--==	FirstName	==-->
            <div class="span6 form-group control-group">
            <label class="control-label"><?php echo COMMON_FIRSTNAME; ?> <span class="color-red">*</span></label>
            <input name="firstname" id="firstname" type="text" class="span12 form-control" value="<?php if($_POST['firstname'] != ''){ 	echo valid_output($_POST['firstname']);} elseif ($Users!='') { echo valid_output($Users->firstname); } ?>" tabindex="1" onkeypress="javascript:removeError('firstname_Error_css');"/>
                <span class="autocomplete_index help-block alert-error" id="firstname_message"></span>
                <?php
                if(isset($err['firstname'])){
                ?>
                <!-- PHP Validation	-->
                <div class="alert alert-error show" id="firstname_Error_css">
					<a class="close">×</a>
                    <div id="firstname_Error"><?php echo $err['firstname'];?></div>
                </div><!--	End PHP Validation	-->
                <?php
                }
                ?>
        	</div><!--==/End FirstName	==-->
        	<!--==	LastName	==-->
        	<div class="span6 form-group control-group">
            <label class="control-label"><?php echo COMMON_LASTNAME; ?> <span class="color-red">*</span></label>
            <input name="lastname" id="lastname" type="text" class="span12 form-control" value="<?php if($_POST['lastname'] != ''){ echo valid_output($_POST['lastname']);}elseif($Users!=''){ echo valid_output($Users->lastname); }  ?>" tabindex="2" onkeypress="javascript:removeError('lastname_Error_css');" />
            	<span class="autocomplete_index help-block alert-error" id="lastname_message"></span>
             	<?php
				if(isset($err['lastname'])){
				?>
				<!-- PHP Validation	-->
              	<div class="alert alert-error show" id="lastname_Error_css">
                	<a class="close">×</a>
					<div id="lastname_Error" class="requiredInformation"><?php  echo $err['lastname'];?></div>
           		</div><!--	End PHP Validation	-->
				<?php
               	}
				?>
       		</div><!--==/End LastName	==-->
      	</div><!--==/End of the 1st Row	==-->
        <!--==	2nd Row	==-->
        <div class="controls">
        	<!--==	Company	==-->
            <div class="span12 form-group control-group">
            <label class="control-label"><?php echo COMMON_COMPANY_NAME; ?></label>
            <input name="company" id="company" type="text" class="span12 form-control" value="<?php if($_POST['company'] != ''){ echo valid_output($_POST['company']);}elseif($Users!=''){ echo valid_output($Users->company); }  ?>" tabindex="3" onkeypress="javascript:removeError('company_Error_css');" />
                <span class="autocomplete_index help-block alert-error" id="company_message"></span>
             	<?php
				if(isset($err['company'])){
				?>
				<!-- PHP Validation	-->
              	<div class="alert alert-error show" id="company_Error_css">
					<a class="close">×</a>
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
            <label class="control-label"><?php echo COMMON_ADDRESS; ?> <span class="color-red">*</span></label>
            <input name="address1" id="address1" type="text" class="span12 form-control" value="<?php if($_POST['address1'] != ''){ echo valid_output($_POST['address1']); } elseif ($Users!='') { echo valid_output($Users->address1); }  ?>" tabindex="4" onkeypress="javascript:removeError('address1_Error_css');" />
                <span class="autocomplete_index help-block alert-error" id="address1_message"></span>
             	<?php
				if(isset($err['address1'])){
				?>
				<!-- PHP Validation	-->
              	<div class="alert alert-error show" id="address1_Error_css">
                	<a class="close">×</a>
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
            <input name="address2" id="address2" type="text" class="span12 form-control" value="<?php if($_POST['address2'] != ''){echo valid_output($_POST['address2']); } elseif ($Users!='') { echo valid_output($Users->address2); }  ?>" tabindex="5" onkeypress="javascript:removeError('address2_Error_css');" />
                <span class="autocomplete_index help-block alert-error" id="address2_message"></span>
             	<?php
				if(isset($err['address2'])){
				?>
				<!-- PHP Validation	-->
              	<div class="alert alert-error show" id="address2_Error_css">
					<a class="close">×</a>
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
            <input name="address3" id="address3" type="text" class="span12 form-control" value="<?php if($_POST['address3'] != ''){echo valid_output($_POST['address3']); } elseif ($Users!='') { echo valid_output($Users->address3); }  ?>" tabindex="6" onkeypress="javascript:removeError('address3_Error_css');" />
                <span class="autocomplete_index help-block alert-error" id="address3_message"></span>
             	<?php
				if(isset($err['address3'])){
				?>
				<!-- PHP Validation	-->
              	<div class="alert alert-error show" id="address3_Error_css">
					<a class="close">×</a>
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
                    <label class="control-label"><?php echo COMMON_COUNTRY; ?> <span class="color-red">*</span></label>
                    	<?php

						$country='';

  				if(isset($_POST['country']) && $_POST['country'] != ''){
  					$country=valid_output($_POST['country']);
  					echo getDropeCountry($country,'9', ' class="span12" onchange="choose_country(\'country\');"');
  				}elseif($Users->country!='')
				{
					$country=valid_output($Users->country);

  					echo getDropeCountry($country,'9', ' class="span12" onchange="choose_country(\'country\');"');
				}
  				else {
  					echo getDropeCountry('13','9', ' class="span12" onchange="choose_country(\'country\');"');
  				}
  			    ?>
                <input type="hidden" class="span12 form-control" name="changed_cntry" id="changed_cntry" value="<?php echo filter_var('13', FILTER_VALIDATE_INT); ?>" /><br />
                	<span class="help-block alert-error" id="changed_cntry_message"></span>
                		<?php if(isset($err['country']) && !empty($err['country'])){ ?>
						<div class="alert alert-error show" id="error_country_css">
                        <a class="close">×</a>
                            <div id="error_country"><?php echo $err['country']; ?></div>
                        </div>
						<?php } ?>
                    </div><!--==/End Country	==-->
             	</div><!--== /End 6th Row	==-->
        <!--==	7th Row	==-->
        <div class="controls">
        	<!--==	Suburb	==-->
            <div class="span12 form-group control-group">
            <label class="control-label"><?php echo COMMON_SUBURB; ?> <span class="color-red">*</span></label>
            <input name="suburb"  id="suburb" type="text" value="<?php if($_POST['suburb'] != ''){ echo valid_output($_POST['suburb']);} elseif ($Users!='') { echo valid_output($Users->suburb); }  ?>" class="span12 form-control" autocomplete="off"  tabindex="7" onkeypress="javascript:removeError('suburb_Error_css');" />
			<input type="hidden"  id="fsuburb" name="fsuburb" />
            	<span class="autocomplete_index help-block alert-error" id="suburb_message"></span>
				<?php if(isset($err['suburb'])){ ?>
				<!-- PHP Validation	-->
              	<div class="alert alert-error show" id="suburb_Error_css">
					<a class="close">×</a>
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
           	<label class="control-label"><?php echo COMMON_STATE; ?> <span class="color-red">*</span></label><br />
          	<input name="state" <?php if((isset($_POST['country']) && $_POST['country'] == '13')){ echo "readonly";}elseif((isset($Users->country) && $Users->country == '13' )){ echo "readonly";}?> id="state" type="text" class="span6 form-control" value="<?php if($_POST['state'] != ''){ echo valid_output($_POST['state']);} elseif ($Users!='') { echo valid_output($Users->state); } ?>" tabindex="8" onkeyup="ajax_showOptions(this,'search_val',event,'<?php echo DIR_HTTP_RELATED; ?>inter_state_val.php','ajax_index_listOfOptions'),removeError('pickupError_css');" onkeypress="javascript:removeError('state_Error_css');" />
			<input type="hidden" name="register_state_code" id="register_state_code" value="<?php echo $Users->state_code;  ?>"  />
            	<span class="autocomplete_index help-block alert-error" id="state_message"></span>
				<?php if(isset($err['state'])){ ?>
				<!-- PHP Validation	-->
              	<div class="alert alert-error show" id="state_Error_css">
                	<a class="close">×</a>
					<div id="state_Error" class="requiredInformation"><?php echo $err['state']; ?></div>
              	</div><!--	End PHP Validation	-->
				<?php
                }
				?>
            </div><!--==/End State	==-->
            <!--==	Postcode	==-->
            <div class="span6 form-group control-group">
           	<label class="control-label" id="pstlbl"><?php if($Users->country == UNITED_STATE_ID){ echo COMMON_US_ZIPCODE;}else{echo COMMON_ZIPCODE; }?> <span class="color-red">*</span></label>
			<?php
				if($Users->country == COUNTRY_SELECT)
				{
					if($_POST['postcode'] != ''){
						$postcode =  filter_var($_POST['postcode'], FILTER_VALIDATE_INT);
					} elseif ($Users!='') {
						$postcode = filter_var($Users->postcode, FILTER_VALIDATE_INT);
					}

				}else{
					if($_POST['postcode'] != ''){
						$postcode = $_POST['postcode'];
					} elseif ($Users!='') {
						$postcode = $Users->postcode;
					}
					//$postcode = '@#$#@$#@';
					$err_int_postcode = filter_var($postcode, FILTER_CALLBACK, array('options' => function($postcode) {
						return chkStreet($postcode);
					}));
					if(is_string($err_int_postcode))
					{
						$err['postcode'] = $err_int_postcode;
					}
				}

			?>
			<!--onkeypress="javascript:removeError('postcode_Error_css');"-->
          	<input name="postcode" <?php if(isset($Users->country) && $Users->country == AUSTRALIA_ID || (isset($_POST['country']) && $_POST['country'] == '13')){ echo "readonly";} ?> id="postcode" type="text" class="span12 form-control" value="<?php echo $postcode; ?>" tabindex="9"  />
            	<span class="autocomplete_index help-block alert-error" id="postcode_message"></span>
				<?php if(isset($err['postcode'])){ ?>
				<!-- PHP Validation	-->
              	<div class="alert alert-error show" id="postcode_Error_css">
                	<a class="close">×</a>
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
        <!--==	9th Row	==-->
        <div class="controls">
        	<!--==	Contact Number	==-->
			<div class="span6 form-group control-group">
			<label class="control-label"><?php echo COMMON_AREA_CODE; ?><span class="color-red">*</span></label></br>
			<input type="tel"   name="sender_area_code" id="sender_area_code" class="span6 form-control" value="<?php if($_POST['sender_area_code'] != ''){ echo valid_output($_POST['sender_area_code']); }elseif ($Users!='') { echo valid_output($Users->sender_area_code); }else{ echo "61";} ?>" tabindex="10" onkeypress="javascript:removeError('error_area_code_reg_css');">
			<span class="help-block alert-error" id="sender_area_code_message"></span>
				<?php
				if(isset($err['areaCode'])){
				?>
				<!-- PHP Validation	-->
				<div class="alert alert-error show" id="error_area_code_reg_css">
					<a class="close">×</a>
					<div id="error_phone_reg"><?php  echo $err['areaCode'];?></div>
				</div><!--	End PHP Validation	-->
				<?php
				}
				?>
			 </div>
            <div class="span6 form-group control-group">
          	<label class="control-label"><?php echo COMMON_CONTACT_NUMBER; ?> <span class="color-red">*</span></label>
           	<input name="phone" id="phone" type="tel" class="span12 form-control" value="<?php if($_POST['phone'] != ''){ echo filter_var($_POST['phone'], FILTER_VALIDATE_INT); }elseif ($Users!='') { echo valid_output($Users->phone_number); } ?>" tabindex="11" onkeypress="javascript:removeError('phone_Error_css');" />
                <span class="autocomplete_index help-block alert-error" id="phone_message"></span>
                <?php if(isset($err['phone'])){ ?>
				<!-- PHP Validation	-->
              	<div class="alert alert-error show" id="phone_Error_css">
                	<a class="close">×</a>
					<div id="phone_Error" class="requiredInformation"><?php  echo $err['phone']; ?></div>
               	</div><!--	End PHP Validation	-->
				<?php
                }
				?>
            </div>
			</div>
			<!--==/End Contact Number	==-->
            <!--==	Alternative Number	==-->
			<div class="controls">
			<div class="span6 form-group control-group">
			<label class="control-label"><?php echo COMMON_AREA_CODE; ?></label></br>
			<input type="tel"  name="sender_mb_area_code" id="sender_mb_area_code"  class="span6 form-control" value="<?php if($_POST['sender_mb_area_code'] != ''){ echo valid_output($_POST['sender_mb_area_code']); }elseif ($Users->sender_mb_area_code!='') { echo valid_output($Users->sender_mb_area_code); }else{ echo $Users->sender_area_code;} ?>" tabindex="12" onkeypress="javascript:removeError('error_mb_area_code_reg_css');">
			<span class="help-block alert-error" id="sender_mb_area_code_message"></span>
				<?php
				if(isset($err['areaContactNo2'])){
				?>
				<!-- PHP Validation	-->
				<div class="alert alert-error show" id="error_mb_area_code_reg_css">
					<a class="close">×</a>
					<div id="error_area_code_reg"><?php  echo $err['areaContactNo2'];?></div>
				</div><!--	End PHP Validation	-->
				<?php
				}
				?>
			</div>
            <div class="span6 form-group control-group">
           	<label class="control-label"><?php echo COMMON_CONTACT_NUMBER_2; ?></label>
           	<input name="mobile_phone" id="mobile_phone" type="tel" class="span12 form-control" value="<?php if($_POST['mobile_phone'] != ''){ echo filter_var($_POST['mobile_phone'], FILTER_VALIDATE_INT); }  elseif ($Users->mobile_no!='') { echo filter_var($Users->mobile_no, FILTER_VALIDATE_FLOAT); } ?>" tabindex="13" onkeypress="javascript:removeError('mobile_phone_Error_css');"/>
                <span class="autocomplete_index help-block alert-error" id="mobile_phone_message"></span>
                <?php if(isset($err['phone'])){ ?>
				<!-- PHP Validation	-->
              	<div class="alert alert-error show" id="mobile_phone_Error_css">
                	<a class="close">×</a>
					<div id="mobile_phone_Error" class="requiredInformation"><?php  echo $err['phone']; ?></div>
               	</div><!--	End PHP Validation	-->
				<?php
                }
				?>
            </div><!--==/End Alternative Number	==-->
			</div>
        <!--==/End 9th Row	==-->
        <!--==	10th Row	==-->
        <div class="controls">
        	<!--==	Email	==-->
            <div class="span12 form-group control-group">
            <label class="control-label"><?php echo COMMON_EMAIL_ID; ?> <span class="color-red">*</span></label>
            <input name="email" id="email" type="text" class="span12 form-control" value="<?php if($_POST['email'] != ''){ echo valid_output($_POST['email']);	}elseif ($Users!='') { echo valid_output($Users->email); }?>" tabindex="14" onkeypress="javascript:removeError('email_Error_css');" />
            	<span class="autocomplete_index help-block alert-error" id="email_message"></span>
                <?php

				if(isset($err['email']) || isset($err['EmailId'])){ ?>
				<!-- PHP Validation	-->
              	<div class="alert alert-error show" id="email_Error_css">
              		<a class="close">×</a>
					<div id="email_Error" class="requiredInformation"><?php if(isset($err['email'])){echo $err['email'];}elseif(isset($err['EmailId'])){ echo $err['EmailId'];} ?></div>
               	</div><!--	End PHP Validation	-->
				<?php
                }
				?>
            </div><!--==/End Email	==-->
        </div><!--==/End 10th Row	==-->
        <!--	Divider	-->
        <div class="span12">
        <div class="margin_bottom_20_important">&nbsp;</div>
        </div><!--/End Divider	-->
        <!--==11th Row	==-->
        <div class="controls">
        	<!--==	Security Question	==-->
            <div class="span12 form-group control-group">
            <label class="control-label"><?php echo COMMON_SECURITY_QUESTION; ?> <span class="color-red">*</span></label>
            <select class="span12 form-control" name="security_ques_1" id="security_ques_1" tabindex="15">
				<option value=''>Select Security Question</option>
                            <?php
									foreach($quest_arr_1 as $key => $val)
									{

										$selected ="selected='selected'";

									?>
									<option value='<?php echo filter_var($key,FILTER_VALIDATE_INT); ?>' <?php if($Users->security_ques_1 == $key){echo $selected;}?>><?php echo valid_output($val); ?></option>
									<?php
									}
									?>
            </select>
            	<span class="autocomplete_index help-block alert-error" id="security_ques_message_1"></span>
				<?php if(isset($err['securityQuesError_1'])){ ?>
				<!-- PHP Validation	-->
              	<div class="alert alert-error show" id="security_ques_Error_css_1">
                	<a class="close">×</a>
					<div id="security_ques_Error_1" class="requiredInformation"><?php echo $err['securityQuesError_1']; ?></div>
              	</div><!--	End PHP Validation	-->
				<?php
                }
				?>
            </div><!--==/End Security Question	==-->
        </div><!--==/End 11th Row	==-->
        <!--==12th Row	==-->
        <div class="controls">
        	<!--==Security Answer	==-->
            <div class="span12 form-group control-group">
            <label class="control-label"><?php echo COMMON_SECURITY_ANSWER; ?> <span class="color-red">*</span></label>
            <input name="security_ans_1" id="security_ans_1" type="text" class="span12 form-control" value="<?php echo valid_output($Users->security_ans_1);?>" tabindex="16" onchange="javascript:show_password(this.form);" onkeypress="javascript:removeError('security_ans_Error_css_1');"/>
            	<span class="autocomplete_index help-block alert-error" id="security_ans_message_1"></span>
				<?php if(isset($err['securityAnsError_1'])){ ?>
				<!-- PHP Validation	-->
              	<div class="alert alert-error show" id="security_ans_Error_css_1">
                	<a class="close">×</a>
					<div id="security_ans_Error_1" class="requiredInformation"><?php echo $err['securityAnsError_1']; ?></div>
              	</div><!--	End PHP Validation	-->
				<?php
                }
				?>
            </div><!--==/End Security Answer	==-->
        </div><!--==/End 12th Row	==-->
		<!--==13th Row	==-->
        <div class="controls">
        	<!--==	Security Question	==-->
            <div class="span12 form-group control-group">
            <label class="control-label"><?php echo COMMON_SECURITY_QUESTION; ?> <span class="color-red">*</span></label>
            <select class="span12 form-control" name="security_ques_2" id="security_ques_2" tabindex="15">
				<option value=''>Select Security Question</option>
                            <?php
									foreach($quest_arr_2 as $key => $val)
									{

										$selected ="selected='selected'";

									?>
									<option value='<?php echo filter_var($key,FILTER_VALIDATE_INT); ?>' <?php if($Users->security_ques_2 == $key){echo $selected;}?>><?php echo valid_output($val); ?></option>
									<?php
									}
									?>
            </select>
            	<span class="autocomplete_index help-block alert-error" id="security_ques_message_2"></span>
				<?php if(isset($err['securityQuesError_2'])){ ?>
				<!-- PHP Validation	-->
              	<div class="alert alert-error show" id="security_ques_Error_css_2">
                	<a class="close">×</a>
					<div id="security_ques_Error_2" class="requiredInformation"><?php echo $err['securityQuesError_2']; ?></div>
              	</div><!--	End PHP Validation	-->
				<?php
                }
				?>
            </div><!--==/End Security Question	==-->
        </div><!--==/End 13th Row	==-->
        <!--==14th Row	==-->
        <div class="controls">
        	<!--==Security Answer	==-->
            <div class="span12 form-group control-group">
            <label class="control-label"><?php echo COMMON_SECURITY_ANSWER; ?> <span class="color-red">*</span></label>
            <input name="security_ans_2" id="security_ans_2" type="text" class="span12 form-control" value="<?php echo valid_output($Users->security_ans_2);?>" tabindex="16" onchange="javascript:show_password(this.form);" onkeypress="javascript:removeError('security_ans_Error_css_2');"/>
            	<span class="autocomplete_index help-block alert-error" id="security_ans_message_2"></span>
				<?php if(isset($err['securityAnsError_2'])){ ?>
				<!-- PHP Validation	-->
              	<div class="alert alert-error show" id="security_ans_Error_css_2">
                	<a class="close">×</a>
					<div id="security_ans_Error_2" class="requiredInformation"><?php echo $err['securityAnsError_2']; ?></div>
              	</div><!--	End PHP Validation	-->
				<?php
                }
				?>
            </div><!--==/End Security Answer	==-->
        </div><!--==/End 14th Row	==-->
        <!--==	15th Row	==-->
        <div class="margin_bottom_20_important">
            <input type="checkbox" id="change_pass" onclick="javascript:change_password();">
            <label class="control-label" for="change_pass"> I want to change my password</label>
        </div>
        <div id="new_pass_show" class="controls" style="display:none">
        	<!--==	Password	==-->
            <div class="span6 form-group control-group">
          	<label class="control-label">New Password <span class="color-red">*</span></label>
           	<input name="password" id="password" autocomplete="new-password" type="password" class="span12 form-control" value="<?php if($_POST['password'] != ''){ echo valid_output($_POST['password']);	}?>" tabindex="17" onchange="javascript:show_password(this.form);" onkeypress="javascript:removeError('password_Error_css');"/>
            	<span class="autocomplete_index help-block alert-error" id="password_message"></span>
				<?php if(isset($err['password'])){ ?>
				<!-- PHP Validation	-->
              	<div class="alert alert-error show" id="password_Error_css">
                	<a class="close">×</a>
					<div id="password_Error" class="requiredInformation"><?php echo $err['password']; ?></div>
              	</div><!--	End PHP Validation	-->
				<?php
                }
				?>
            </div><!--==/End Password	==-->
            <!--==	Confirm Password	==-->
            <div class="span6 form-group control-group">
          	<label class="control-label">Confirm Password <span class="color-red">*</span></label>
          	<input name="confirmpassword" id="confirmpassword" type="password" class="span12 form-control" value="<?php if($_POST['confirmpassword'] != ''){ echo valid_output($_POST['confirmpassword']);	}?>" tabindex="18" onkeypress="javascript:removeError('confirmpassword_Error_css');"/>
                <span class="autocomplete_index help-block alert-error" id="confirmpassword_message"></span>
				<?php if(isset($err['confirmpassword'])){ ?>
				<!-- PHP Validation	-->
              	<div class="alert alert-error show" id="confirmpassword_Error_css">
                	<a class="close">×</a>
					<div id="confirmpassword_Error" class="requiredInformation"><?php echo $err['confirmpassword']; ?></div>
              	</div><!--	End PHP Validation	-->
				<?php
                }
				?>
            </div><!--==/End Confirm Password	==-->
        </div><!--==/End 15th Row	==-->
        <!--==  16th Row  ==-->
        <input name="valid_pass" type="hidden" id="valid_pass" value="">
        <div class="controls row-fluid span12" style="display:<?php echo valid_output($display);?>" id="existing_pass_show">
          <div class="span3"></div>
          <!--==  Old Password  ==-->
          <div class="span6 form-group control-group">
            <label class="control-label">Your Current Password <span class="color-red">*</span></label>
            <input name="oldpassword" id="oldpassword" type="password" class="span12 form-contro" value="<?php if($_POST['oldpassword'] != ''){ echo valid_output($_POST['oldpassword']); }?>" tabindex="19" onkeypress="javascript:removeError('oldpass_Error_css');"/>
              <span class="autocomplete_index help-block alert-error" id="oldpassword_message"></span><?php if(isset($err['OldPass'])){ ?>
        <!-- PHP Validation -->
                <div class="alert alert-error show" id="oldpass_Error_css">
                  <a class="close">×</a>
          <div id="oldpass_Error" class="requiredInformation"><?php echo $err['OldPass']; ?></div>
                </div><!--  End PHP Validation  -->
        <?php
                }
        ?>
        <?php if(isset($err['oldpassword'])){ ?>
        <!-- PHP Validation -->
                <div class="alert alert-error show" id="oldpassword_Error_css">
                  <a class="close">×</a>
          <div id="oldpassword_Error" class="requiredInformation"><?php echo $err['oldpassword']; ?></div>
                </div><!--  End PHP Validation  -->
        <?php
                }
        ?>
            </div><!--==/End Old Password ==-->
            <div class="span3"></div>
        </div><!--==/End 16th Row ==-->
            <div class="controls form-inline text_centre">
            	<div class="span12 form-group control-group">
                <input type="hidden" name="Submit" value="Submit" />

                <input type="hidden" name="ptoken" value="<?php echo $ptoken;?>" id="ptoken" />
				 <input type="hidden" name="selected_flag"  value="<?php if(isset($Users->country) && $Users->country == '13' || (isset($_POST['country']) && $_POST['country'] == '13')){ echo "australia";}else{ echo "international";} ?>" id="selected_flag" />
				<!--<button class="btn-u" type="reset" onclick="javascript:return resetForm();" />Default </button>&nbsp;-->
				<input class="btn-u pull-left" type="button" onclick="javascript:historyBack();" value="Cancel"/>&nbsp;

				<button class="btn-u pull-right" id="btn_save" type="submit"  />Save</button>
                </div>
            </div>
            <div class="modal hide fade small_rates" id="addressRegisterError" data-backdrop="static" data-keyboard="false">
<div class="modal-header">
<h3><?php echo PROFILE_ADDRESSES_WRONG_HEAD; ?></h3>
</div>
<div class="modal-body justy">
<div id="address_display"></div>
<?php
if((isset($_GET['error'])) && $_GET['error'] != ''){
?>
<span class="my_bigger_font"><?php echo $_GET['error']; ?></span>
<?php
}
?>
</div>
<div class="modal-footer"><a href="#" class="btn-u btn-u-primary"  id="closemodal">Close</a></div>
</div>
    </form>
	</div>
    </div><!--/row-fluid-->
</div><!--/container-->
<!--<input type="hidden" name="ulangid" value="<?php echo filter_var($Users['site_language_id'], FILTER_VALIDATE_INT); ?>" />-->

<input type="hidden" name="ulangid" value="1"/>
