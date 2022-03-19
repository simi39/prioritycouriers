<!--=== Breadcrumbs ===-->
<div class="breadcrumbs margin-bottom-40">
	<div class="container">
        <h1 class="color-green pull-left"><?php echo PAGE_HEADING_FORGOT; ?></h1>
        <ul class="pull-right breadcrumb">
            <li><a href="<?php echo SITE_INDEX;; ?>"><?php echo PAGE_HEADING_HOME; ?></a> <span class="divider">/</span></li>
            <li class="active"><?php echo PAGE_HEADING_FORGOT; ?></li>
        </ul>
    </div><!--/container-->
</div><!--/breadcrumbs-->
<!--=== End Breadcrumbs ===-->

<div class="row-fluid">
	<div class="span3"></div>
    <div class="span6">
    	<blockquote class="margin-bottom-30">
    	<?php echo FORGOT_PASS_INFO;?>
    	</blockquote>
    </div>
    <div class="span3"></div>
</div>
<div class="row-fluid">
<div class="containerBlock">
    <form name="frmlogin" id="frmlogin" method="post" class="log-page" autocomplete="off">
    <h3><?php echo FORGOTPASS_PAGE_HEADING;?></h3>
    <!--=== Email Address ===-->
    <div class="input-prepend form-group control-group">
        <label class="control-label add-on"><i class="icon-user"></i></label>
        <input type="hidden" id="ptoken" value="<?php echo $ptoken; ?>" name="ptoken">
        <input type="text" tabindex="1" class="input-xlarge form-control" name="emailid" id="emailid" placeholder="<?php echo COMMON_EMAIL_ID; ?>" value="<?php if(isset($_POST['emailid'])) {echo valid_output($_POST['emailid']);} else { echo valid_output($UserDetails->emailid);}?>" onkeypress="javascript:removeError('EmailError_css');" />
        <span class="help-block alert-error" id="emailid_message"></span>
    </div><!--===/End Email Address ===-->
	<?php //if(isset($err['email_id'])){ ?>
        <!-- PHP Validation	-->
        <div class="alert alert-error hide" id="EmailError_css">
            <a class="close">×</a> 
            <div id="EmailError"><?php if(isset($err['email_id'])) { echo $err['email_id']; }?></div>
        </div><!--	End PHP Validation	-->
        <?php //} ?>
    <!--===	ReCaptcha Applied  ===-->
    <div class="input-prepend form-group control-group">
        <div id="captcha_container" class="captcha_container"></div>
		<span class="help-block alert-error has-error" id="reCaptcha_error_message" style="display:none;">
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
    
    <?php 
	
	
	//if(isset($err['EmailIdNotExist'])){ ?>
    
       <div class="alert alert-error hide"  id="emailIdNotError">
            <a class="close">×</a>
            <div  id="emailIdNotError">
            <?php //if(isset($err['EmailIdNotExist'])) { echo $err['EmailIdNotExist']; }
				//echo COMMON_LOGIN_ATTEMPTS;
			?>
            </div>
        </div>
    
    <?php //} ?>
    <div class="control-group margin-bottom-40">
    	
       <!-- <button type="submit"  class="btn-u pull-right" name="Submits" value="Submit"  id="Submits" onclick="return Validategetpassword(this.form);" />-->
	   <input type="hidden" value="" id="gcaptcha" name="gcaptcha" />
		<input type="hidden" name="Submits"  value="Submit" />
		<input type="hidden" name="finalval" id="finalval" />
		
		<button class="btn-u pull-right" tabindex="4" type="submit" id="btnsubmit" name="btnsubmit" />Submit</button>
        
    </div>
    <div class="modal hide fade small_rates" id="forgotSuccess" data-backdrop="static" data-keyboard="false">
<div class="modal-header">
<h3><?php echo FORGOTPASS_PAGE_HEADING; ?></h3>
</div>
<div class="modal-body"><?php echo FORGOTPASS_EMAIL_SENT_SUCCESS; ?></div>
<div class="modal-footer">
<span class="control-group white-space form-group my_bigger_font" id="deliveryClose"><a href="#" id="p" class="btn-u pull-right" >Close</a></span></div>
</div>
<div class="modal hide fade small_rates" id="forgotError" data-backdrop="static" data-keyboard="false">
	<div class="modal-header">
		<h3><?php echo FORGOTPASS_PAGE_HEADING; ?></h3>
	</div>
	<div class="modal-body"><?php echo FORGOTPASS_LOGIN_ATTEMPTS; ?></div>
<div class="modal-footer">
<span class="control-group white-space form-group my_bigger_font" id="deliveryClose"><a href="#" id="errorp" class="btn-u pull-right" >Close</a></span></div>
</div>
</form>
</div>
</div><!--/row-fluid-->


