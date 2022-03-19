<!--=== Breadcrumbs ===-->
	<div class="breadcrumbs margin-bottom-50">
    	<div class="controlContainer container">
            <h1 class="color-green pull-left"><?php echo SIGNUP_CUSTOMER_NEW; ?></h1>
            <ul class="pull-right breadcrumb">
                <li><a href="<?php echo SITE_INDEX;?>">Home</a> <span class="divider">/</span></li>
                <li><a href="">Pages</a> <span class="divider">/</span></li>
                <li class="active">Registration</li>
            </ul>
        </div><!--/container-->
    </div><!--/breadcrumbs-->
	<!--Container-->
	<div class="container">		
		<div class="row-fluid margin-bottom-10">
		<div class="containerBlock">
        	<form id="registration" autocomplete='off' class="reg-page" method="post" action="<?php echo FILE_SIGNUP; ?>">
            	<h3>Register a new account</h3>
				<!--==	1st Row	==-->
                <div class="controls">
                	<!--==	FirstName	==-->
              		<div class="span6 form-group control-group">
                   	<label class="control-label"><?php echo COMMON_FIRSTNAME; ?> <span class="color-red">*</span></label>
                   	<input type="text" class="span12 form-control" name="firstname" value="<?php if($_POST['firstname'] != ''){ echo valid_output($_POST['firstname']);} ?>" id="firstname_reg" tabindex="1" onkeypress="javascript:removeError('error_firstname_reg_css');"/><br />
                    	<span class="help-block alert-error" id="firstname_reg_message"></span>
                        <?php
                		if(isset($err['firstname'])){
                		?>
                		<!-- PHP Validation	-->
                 		<div class="alert alert-error show" id="error_firstname_reg_css"> 
                        	<a class="close">×</a>
                            <div id="error_firstname_reg"><?php echo $err['firstname'];?></div>
                        </div><!--	End PHP Validation	-->
                        <?php
                		}
                		?>
                    </div><!--==/End FirstName	==-->
                    <!--==	LastName	==-->
                    <div class="span6 form-group control-group">
                  	<label class="control-label"><?php echo COMMON_LASTNAME; ?> <span class="color-red">*</span></label>
                  	<input type="text" class="span12 form-control" name="lastname" value="<?php if($_POST['lastname'] != ''){ echo valid_output($_POST['lastname']);}  ?>" id="lastname_reg" tabindex="2" onkeypress="javascript:removeError('error_lastname_reg_css');" /><br />
                        <span class="help-block alert-error" id="lastname_reg_message"></span>
                        <?php 
						if(isset($err['lastname'])){
						?>
                        <!-- PHP Validation	-->
                        <div class="alert alert-error show" id="error_lastname_reg_css"> 
                        	<a class="close">×</a>
                            <div id="error_lastname_reg"><?php  echo $err['lastname'];?></div>
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
                    <input type="text" class="span12 form-control" id="company_reg" name="company_reg" onkeypress="javascript:removeError('error_company_reg_css');" /><br />
                    	<span class="help-block alert-error" id="company_reg_message"></span>
                        <?php 
						if(isset($err['company_reg'])){
						?>
                        <!-- PHP Validation	-->
                        <div class="alert alert-error show" id="error_company_reg_css">
                        	<a class="close">×</a>
                            <div id="error_company_reg"><?php  echo $err['company_reg'];?></div>
                        </div><!--	End PHP Validation	-->
                        <?php
                		}
                		?>
                    </div><!--==/End Company	==-->
              	</div><!--==/End 2nd Row	==-->
                <!--==	3nd Row	==-->
                <div class="controls">
                	<!--==	Address 1	==-->
                    <div class="span12 form-group control-group"> 
                    <label class="control-label"><?php echo COMMON_ADDRESS; ?> <span class="color-red">*</span></label>
                    <input type="text" class="span12 form-control" name="address1" value="<?php if($_POST['address1'] != ''){ echo valid_output($_POST['address1']); } ?>" id="address1_reg" tabindex="3" onkeypress="javascript:removeError('error_address1_reg_css');" /><br />
                    	<span class="help-block alert-error" id="address1_reg_message"></span>
                        <?php 
						if(isset($err['address1'])){
						?>
                        <!-- PHP Validation	-->
                    	<div class="alert alert-error show" id="error_address1_reg_css">
                        	<a class="close">×</a> 
                            <div id="error_address1_reg"><?php  echo $err['address1'];?></div>
                        </div><!--	End PHP Validation	-->
                        <?php
                		}
                		?>
                    </div><!--==/End Address 1	==-->
                </div><!--==/End 3nd Row	==-->
                <!--==	4th Row	==-->
                <div class="controls">
                	<!--==	Address 2	==-->
                    <div class="span12 form-group control-group">
                    <label></label>
                    <input type="text" class="span12 form-control" name="address2" value="<?php if($_POST['address2'] != ''){ echo valid_output($_POST['address2']); }  ?>" id="address2_reg" onkeypress="javascript:removeError('error_address2_reg_css');" tabindex="4"/><br />
                    <span class="help-block alert-error" id="address2_reg_message"></span>
                    	<?php 
						if(isset($err['address2'])){
						?>
                        <!-- PHP Validation	-->
                    	<div class="alert alert-error show" id="error_address2_reg_css">
                        	<a class="close">×</a> 
                            <div id="error_address2_reg"><?php  echo $err['address2'];?></div>
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
                    <input type="text" class="span12 form-control" name="address3" value="<?php if($_POST['address3'] != ''){ 	echo valid_output($_POST['address3']); }  ?>" id="address3_reg" tabindex="5" onkeypress="javascript:removeError('error_address3_reg_css');" /><br />
                    	<span class="help-block alert-error" id="address3_reg_message"></span>
                        <?php 
						if(isset($err['address3'])){
						?>
                        <!-- PHP Validation	-->
                    	<div class="alert alert-error show" id="error_address3_reg_css">
                        	<a class="close">×</a> 
                            <div id="error_address3_reg"><?php  echo $err['address3'];?></div>
                        </div><!--	End PHP Validation	-->
                        <?php
                		}
                		?>
                    </div><!--==/End Address 3	==-->
               	</div><!--==/End 5th Row	==-->
                <!--==	6th Row	==-->
                <div class="controls">
                	<!--==	Country	==-->
                    <div class="span12 form-group control-group">
                    <label class="control-label"><?php echo COMMON_COUNTRY; ?> <span class="color-red">*</span></label>
                    	<?php $country='';
						
  				if($_POST['country'] != ''){ 
  					$country=valid_output($_POST['country']);
  					echo getDropeCountry($country,'9', ' class="span12" onchange="choose_country(\'country\');"'); 
  				}
  				else {
  					echo getDropeCountry('13','9', ' class="span12" onchange="choose_country(\'country\');"'); 
  				}
  			    ?>
                <input type="hidden" class="span12 form-control" name="changed_cntry" id="changed_cntry" value="<?php echo filter_var('13', FILTER_VALIDATE_INT); ?>" /><br />
                	<span class="help-block alert-error" id="changed_cntry_message"></span>
                		<?php if(isset($err['country'])){ ?>
						<div class="alert alert-error show" id="error_country_css">
                        <a class="close">×</a> 
                            <div id="error_country"><?php echo $err['country']; ?></div>
                        </div>
						<?php } ?>
                    </div><!--==/End Country	==-->
             	</div><!--==/End 6th Row	==-->
                <!--==	7th Row	==-->
                <div class="controls">
                	<!--==	Suburb	==-->
                    <div class="span12 form-group control-group">
                    <label class="control-label"><?php echo COMMON_SUBURB; ?> <span class="color-red">*</span></label>
                    <input type="text" class="span12 form-control" name="suburb" autocomplete="off" value="<?php if($_POST['suburb'] != ''){ echo valid_output($_POST['suburb']);}  ?>" id="suburb_reg"  tabindex="6" onkeypress="javascript:removeError('error_suburb_reg_css');" />
					 <input type="hidden"  id="fsuburb" name="fsuburb" />
					<br />
                    	<span class="help-block alert-error" id="suburb_reg_message"></span>
                         <?php 
						if(isset($err['suburb'])){
						?>
                        <!-- PHP Validation	-->
                    	<div class="alert alert-error show" id="error_suburb_reg_css">
                        <a class="close">×</a> 
                            <div id="error_suburb_reg"><?php  echo $err['suburb'];?></div>
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
                  	<input type="text" class="span12 form-control" name="state" value="<?php if($_POST['state'] != ''){ echo valid_output($_POST['state']);} ?>" id="state_reg" tabindex="7" onkeyup="ajax_showOptions(this,'search_val',event,'<?php echo DIR_HTTP_RELATED; ?>inter_state_val.php','ajax_index_listOfOptions'),removeError('pickupError_css');" onkeypress="javascript:removeError('error_state_reg_css');" /><br />
					<input type="hidden" name="register_state_code" id="register_state_code" value="<?php echo $deliaddress->state_code;  ?>"  />
                  		<span class="help-block alert-error" id="state_reg_message"></span>
                         <?php 
						if(isset($err['state'])){
						?>
                        <!-- PHP Validation	-->
                        <div class="alert alert-error show" id="error_state_reg_css">
                        <a class="close">×</a> 
                            <div id="error_state_reg"><?php  echo $err['state'];?></div>
                        </div><!--	End PHP Validation	-->
                        <?php
                		}
                		?>
                    </div><!--==/End State	==-->
                    <!--==	Postcode	==-->
                    <div class="span6 form-group control-group">
                  	<label class="control-label" id="pstlbl"><?php echo COMMON_ZIPCODE; ?><span class="color-red">*</span></label><br />
                  	<input type="text" class="span12 form-control" name="postcode" value="<?php if($_POST['postcode'] != ''){ echo filter_var($_POST['postcode'], FILTER_VALIDATE_INT);} ?>" id="postcode_reg" tabindex="8"  /><br />
                    	<span class="help-block alert-error" id="postcode_reg_message"></span>
                         <?php 
						if(isset($err['postcode'])){
						?>
                        <!-- PHP Validation	-->
                        <div class="alert alert-error show" id="error_postcode_reg_css">
                        <a class="close">×</a> 
                            <div id="error_postcode_reg"><?php  echo $err['postcode'];?></div>
                        </div><!--	End PHP Validation	-->
                        <?php
                		}
                		?>
                    </div><!--==/End Postcode	==-->
      			</div><!--==/End 8th Row	==-->
                <!--	Divider	-->
            	<div class="span12 margin-left_0 ">
            		<div class="margin_bottom_20_important">&nbsp;</div>
            	</div><!--/End Divider	-->
                <!--==	9th Row	==-->
                <div class="controls">
				<div class="span6 form-group control-group">
					<label class="control-label"><?php echo COMMON_AREA_CODE; ?><span class="color-red">*</span></label></br>
                   	<input type="tel"   name="sender_area_code" id="sender_area_code" class="span6 form-control" value="<?php if($_POST['sender_area_code'] != ''){ echo valid_output($_POST['sender_area_code']); }else{ echo "61";} ?>" tabindex="9" onkeypress="javascript:removeError('error_area_code_reg_css');">
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
                  	<input type="tel" class="span12 form-control" name="phone" value="<?php if($_POST['phone'] != ''){ echo filter_var($_POST['phone'], FILTER_VALIDATE_INT);} ?>" id="phone_reg" tabindex="10" onkeypress="javascript:removeError('error_phone_reg_css');" /><br />
                        <span class="help-block alert-error" id="phone_reg_message"></span>
                        <?php 
						if(isset($err['phone'])){
						?>
                        <!-- PHP Validation	-->
                        <div class="alert alert-error show" id="error_phone_reg_css">
                        	<a class="close">×</a> 
                            <div id="error_phone_reg"><?php  echo $err['phone'];?></div>
                        </div><!--	End PHP Validation	-->
                        <?php
                		}
						?>
                    </div><!--==/End Contact Number	==-->
					</div>
					<div class="controls">
                    <!--==	Alternative Number	==-->
					<div class="span6 form-group control-group">
					<label class="control-label"><?php echo COMMON_AREA_CODE; ?></label></br>
                   	<input type="tel"  name="sender_mb_area_code" id="sender_mb_area_code"  class="span6 form-control" value="<?php if($_POST['sender_mb_area_code'] != ''){ echo valid_output($_POST['sender_mb_area_code']); }else{ echo "61";} ?>" tabindex="11" onkeypress="javascript:removeError('error_mb_area_code_reg_css');">
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
					<input type="tel" class="span12 form-control" name="mobile_phone" value="<?php if($_POST['mobile_phone'] != ''){ echo filter_var($_POST['mobile_phone'], FILTER_VALIDATE_INT); } ?>" id="mobile_phone_reg" tabindex="12" onkeypress="javascript:removeError('error_mobile_phone_reg_css');"/><br />
                    	<span class="help-block alert-error" id="mobile_phone_reg_message"></span>
                        <?php 
						if(isset($err['mobile_phone'])){
						?>
                        <!-- PHP Validation	-->
                        <div class="alert alert-error show" id="error_mobile_phone_reg_css">
                        	<a class="close">×</a> 
                            <div id="error_mobile_phone_reg"><?php  echo $err['mobile_phone'];?></div>
                        </div><!--	End PHP Validation	-->
                        <?php
                		}
						?>
                    </div><!--==/End Alternative Number	==-->
                </div><!--==/End 9th Row	==-->
                <!--==	10th Row	==-->
                <div class="controls">
                	<!--==	Email	==--> 
                	<div class="span12 form-group control-group"> 
                    <label class="control-label"><?php echo COMMON_EMAIL_ID; ?> <span class="color-red">*</span></label>
                    <input type="text" class="span12 form-control" name="email" value="<?php if($_POST['email'] != ''){ echo htmlentities($_POST['email']);	}?>" id="email_reg" tabindex="13" /><br />
                    	<span class="help-block alert-error" id="email_reg_message"></span>
                        <?php 
						if(isset($err['EmailId'])){
						?>
                        <!-- PHP Validation	-->
                    	<div class="alert alert-error show" id="error_email_reg_css">
                        	<a class="close">×</a> 
                            <div id="error_email_reg"><?php  echo $err['EmailId'];?></div>
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
                    <select class="span12 form-control" name="security_ques_1" id="security_ques_reg_1" tabindex="14" onkeypress="javascript:removeError('error_security_ques_reg_css_1');">
		<option value=''>Select Security Question</option>
									<?php
									foreach($quest_arr_1 as $key => $val)
									{
																				
										$selected ="selected='selected'";
										
									?>
									<option value='<?php echo $key; ?>' <?php if($_POST['security_ques_1'] == $key){echo $selected;}?>><?php echo valid_output($val); ?></option>
									<?php
									}
									?>
					</select><br />
                    	<span class="help-block alert-error" id="security_ques_reg_message_1"></span>
                        <?php 
						if(isset($err['securityQuesError_1'])){
						?>
                        <!-- PHP Validation	-->			
                    	<div class="alert alert-error show" id="error_security_ques_reg_css_1">
                        	<a class="close">×</a> 
                            <div id="error_security_ques_reg"><?php echo $err['securityQuesError_1']; ?></div>
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
                    <input type="text" class="span12 form-control" name="security_ans_1" value="<?php echo valid_output($_POST['security_ans_1']);?>" id="security_ans_reg_1" tabindex="15"  onkeypress="javascript:removeError('error_security_ans_reg_css_1');"/><br />
                    	<span class="help-block alert-error" id="security_ans_reg_message_1"></span>
                         <?php 
						if(isset($err['securityAnsError_1'])){
						?>
                        <!-- PHP Validation	-->	
                    	<div class="alert alert-error show" id="error_security_ans_reg_css_1">
                        	<a class="close">×</a> 
                            <div id="error_security_ans_reg_1"><?php echo $err['securityAnsError_1']; ?></div>
                        </div><!--	End PHP Validation	-->
						<?php
                		} 
						?>
                    </div><!--==Security Answer	==-->
                </div><!--==/End 12th Row	==-->
				<!--==13th Row	==-->
                <div class="controls">
                	<!--==	Security Question	==-->
                	<div class="span12 form-group control-group">
                	<label class="control-label"><?php echo COMMON_SECURITY_QUESTION; ?> <span class="color-red">*</span></label>
                    <select class="span12 form-control" name="security_ques_2" id="security_ques_reg_2" tabindex="14" onkeypress="javascript:removeError('error_security_ques_reg_css_2');">
		<option value=''>Select Security Question</option>
									<?php
									foreach($quest_arr_2 as $key => $val)
									{
																				
										$selected ="selected='selected'";
										
									?>
									<option value='<?php echo $key; ?>' <?php if($_POST['security_ques_2'] == $key){echo $selected;}?>><?php echo valid_output($val); ?></option>
									<?php
									}
									?>
					</select><br />
                    	<span class="help-block alert-error" id="security_ques_reg_message_2"></span>
                        <?php 
						if(isset($err['securityQuesError_2'])){
						?>
                        <!-- PHP Validation	-->			
                    	<div class="alert alert-error show" id="error_security_ques_reg_css_2">
                        	<a class="close">×</a> 
                            <div id="error_security_ques_reg_2"><?php echo $err['securityQuesError_2']; ?></div>
                        </div><!--	End PHP Validation	-->
						<?php
                		} 
						?>
                    </div><!--==/End Security Question	==-->
             	</div><!--==/End 13th Row	==-->
				<!--==14th Row	==-->
                <div class="controls">
                	<!--==Security Answer 2 Set	==-->
                    <div class="span12 form-group control-group">
                    <label class="control-label"><?php echo COMMON_SECURITY_ANSWER; ?> <span class="color-red">*</span></label>
                    <input type="text" class="span12 form-control" name="security_ans_2" value="<?php echo valid_output($_POST['security_ans_2']);?>" id="security_ans_reg_2" tabindex="15"  onkeypress="javascript:removeError('error_security_ans_reg_css_2');"/><br />
                    	<span class="help-block alert-error" id="security_ans_reg_message_2"></span>
                         <?php 
						if(isset($err['securityAnsError_2'])){
						?>
                        <!-- PHP Validation	-->	
                    	<div class="alert alert-error show" id="error_security_ans_reg_css_2">
                        	<a class="close">×</a> 
                            <div id="error_security_ans_reg_2"><?php echo $err['securityAnsError_2']; ?></div>
                        </div><!--	End PHP Validation	-->
						<?php
                		} 
						?>
                    </div><!--==Security Answer	2 Set ==-->
                </div><!--==/End 14th Row	==-->
                <!--==	15th Row	==-->
				<div class="controls">
                	<!--==	Password	==-->
                    <div class="span6 form-group control-group">
                   	<label class="control-label">Password <span class="color-red">*</span></label>
                    <input type="password" class="span12 form-control" name="password" value="<?php if($_POST['password'] != ''){ echo valid_output($_POST['password']);}?>" id="password_reg" tabindex="16" onkeypress="javascript:removeError('error_password_reg_css');"/><br />
                  		<span class="help-block alert-error" id="password_reg_message"></span>
                       	<?php 
						if(isset($err['Pass'])){
						?>
                        <!-- PHP Validation	-->
                   		<div class="alert alert-error show" id="error_password_reg_css">
                       		<a class="close">×</a> 
                          	<div id="error_password_reg"><?php if(isset($err['Pass'])){echo $err['Pass'];} ?></div>
                      	</div><!--	End PHP Validation	-->
						<?php
                		} 
						?>
                    </div><!--==/End Password	==-->
                    <!--==	Confirm Password	==-->
                    <div class="span6 form-group control-group">
                  	<label class="control-label">Confirm Password <span class="color-red">*</span></label>
                	 <input type="password" class="span12 form-control" name="confirmpassword" value="<?php if($_POST['confirmpassword'] != ''){ echo valid_output($_POST['confirmpassword']);	}?>" id="confirmpassword_reg" tabindex="17" onkeypress="javascript:removeError('error_password_reg_css');"/><br />
                     	<span class="help-block alert-error" id="confirmpassword_reg_message"></span>
                        <?php 
						if(isset($err['ConfPass'])){
						?>
                        <!-- PHP Validation	-->			
                    	<div class="alert alert-error show" id="error_confirmpassword_reg_css">
                        	<a class="close">×</a> 
                            	<div id="error_confirmpassword_reg"><?php echo $err['ConfPass']; ?></div>
                        </div><!--	End PHP Validation	-->
						<?php
                		} 
						?>
                    </div><!--==/End Confirm Password	==-->
                </div><!--==/End 15th Row	==-->
				<!--== 16th Row ==-->
				<div class="input-prepend form-group control-group">
					<div id="captcha_container" class="captcha_container"></div>
					<span class="alert-error has error help-block" id="reCaptcha_error_message" style="display:none;">
					<a class="close">×</a>
					<small style="display: block;" class="has-error alert-error"><?php echo MSG_CAPTCHA_IS_REQUIRED; ?></small>
					</span>
				</div><!--===/End ReCaptcha Applied ===-->
				<?php 
				if(isset($err['recaptcha'])){
				?>
				<!-- ReCaptcha Validation	-->
				<div class="alert alert-error show" id="reCaptchaError_css">
					<a class="close">×</a>
					<div ><?php if(isset($err['recaptcha'])) { echo $err['recaptcha']; }?></div>
				</div><!--	End ReCaptcha Validation	-->
			   <?php
				}
				?>
				<!--== 16th Row ==-->
                <!--==	17th Row	==-->
				<div class="controls form-inline">	
                	<!--==	Terms & Conditions Checkbox	==-->
                    <div class="span8 form-group control-group">
					<label class="checkbox"><input type="checkbox" class="form-control" name="terms_cond" id="terms_cond" <?php if(isset($_POST['terms_cond']) && $_POST['terms_cond']!=""){echo "checked";}?> />&nbsp; I read <a id="popup" class="details-link" data-toggle="modal" href="#<?php echo "div_terms-conditions"; ?>"><strong class="my_green">Terms and Conditions</strong></a>
                    	<?php
						$CmsPageName = "terms-conditions";
						$Terms_Conditions = cmsPageContent($CmsPageName);
						echo lightBoxCmsDesc($Terms_Conditions);
						?>
                    </label>
						<span class="help-block alert-error" id="terms_n_cond_message"></span>
						<?php 
						if(isset($err['terms_cond'])){
						?>
                        <!-- PHP Validation	-->			
                    	<div class="alert alert-error show" id="error_terms_cond_css">
                        	<a class="close">×</a> 
                            <div id="error_terms_cond"><?php echo $err['terms_cond']; ?></div>
                        </div><!--	End PHP Validation	-->
						<?php
						} 
						?>
                    </div><!--==/ End Terms & Conditions Checkbox	==-->
                    <!--==	Submit Button	==-->
                    <div class="span4">
                    <button class="btn-u pull-right" type="submit" id="btn_submit" name="btn_submit" />Register</button>
					 <input type="hidden" value="" id="gcaptcha" name="gcaptcha" />
					 
					 <input type="hidden" name="selected_flag"  value="<?php echo "australia"; ?>" id="selected_flag" />
					<input type="hidden" name="ptoken" id="ptoken" value="<?php echo $ptoken; ?>" />
					<input type="hidden" name="finalval" id="finalval" />
					<input type="hidden" name="submit_form" id="submit_form" value="save"/>
                    </div><!--==/End Submit Button	==-->
                </div><!--==/End 16th Row	==-->
                <hr />
				<div class="modal hide fade small_rates" id="confirmBox" data-backdrop="static" data-keyboard="false">
				<div class="modal-body">
					<div class="headline">
					<h3><?php echo REGISTRATION_MESSAGE_HEAD; ?></h3>
					</div>
					<div class="my_bigger_font justy"><?php echo REGISTRATION_MESSAGE; ?></div>
				</div>      
				<div class="modal-footer"><a href="#" id="p" class="btn-u">Sign in</a>	</div>
				</div>
				 
                <!--==	Existing Account	==-->
                <div class="span12">
				<p>Already Signed Up? Click <a href="<?php echo show_page_link(FILE_LOGIN); ?>" class="color-green">Sign In</a> to login your account.</p>
                </div><!--==/ EndExisting Account	==-->
				<!-- success message -->
</form>
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
           
        </div><!--/row-fluid-->
	</div><!--/container-->
<!--=== End Content Part ===-->
