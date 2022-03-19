<!--=== Breadcrumbs ===-->
<div class="breadcrumbs margin-bottom-40">
	<div class="container">
        <h1 class="color-green pull-left"><?php echo PAGE_HEADING_LOGIN; ?></h1>
        <ul class="pull-right breadcrumb">
            <li><a href="<?php echo SITE_INDEX; ?>"><?php echo PAGE_HEADING_HOME; ?></a> <span class="divider">/</span></li>
            <li class="active"><?php echo PAGE_HEADING_LOGIN; ?></li>
        </ul>
    </div><!--/container-->
</div><!--/breadcrumbs-->
<!--=== End Breadcrumbs ===-->
<!--=== Login Block	===-->
<div class="row-fluid">
	<form method="post" id="frmuser"name="frmuser" autocomplete="off" class="log-page" action="<?php echo FILE_LOGIN; ?>">
		<h3><?php echo PAGE_LOGIN_ACCOUNT; ?></h3> 
        <!--==	Email Address	==-->
        <div class="input-prepend form-group control-group">
            <label class="control-label add-on"><i class="icon-user"></i></label>
            <input type="text" class="input-xlarge form-control" name="email_signup" id="email_header" autocomplete="email_signup" placeholder="Email Address" onkeypress="javascript:removeError('error_email_header_css');"  />
			<span class="help-block alert-error" id="email_header_message"></span>
            <?php if(isset($auth_result['error_email'])){ ?>
			<!-- PHP Validation	-->
			<div class="alert alert-error show" id="error_email_header_css">
            	<a class="close">×</a>
				<div  id="error_email_header"><?php  echo $auth_result['error_email'];?></div>
			</div>
			<!--	End PHP Validation	-->
            <?php } ?>
        </div> <!--==/End Email Address	==-->
  		<!--==		Password	==-->
		<div class="input-prepend form-group control-group">
			<label class="add-on control-label"><i class="icon-lock"></i></label>
			<input type="password" class="input-xlarge form-control" name="password_signup" id="password_header" autocomplete="new-password" placeholder="Password" onkeypress="javascript:removeError('error_password_header_css');"  />
			<input type="hidden" name="current_location" id="current_location" value="<?php echo FILE_FILENAME_WITH_EXT;?>">
            <input type="hidden" name="ptoken" id="ptoken" value="<?php echo $ptoken; ?>" />
            <span class="help-block alert-error" id="password_header_message"></span>
			<?php if(isset($auth_result['error_password'])){ ?>
			<!-- PHP Validation	-->
				<div class="alert alert-error show" id="error_password_header_css">
                	<a class="close">×</a>
					<div  id="error_password_header"><?php  echo $auth_result['error_password'];?></div>
				</div>
			<!--	End PHP Validation	-->
			<?php } ?>
		</div><!--== /End Password	==-->
		<!--== Login Button	==-->
		<div class="controls form-inline">
			<input type="hidden" name="btnlogin" value="Login" />
			<!--<input class="btn-u pull-right" name="btnlogin" type="submit" value="Login"  />--><button class="btn-u pull-right" type="submit" id="login_btn">Login</button><br />
		</div><!--==/End Login Button	==-->
        <!--== Forgot Password	==-->
		<hr />
		<h4><?php echo PAGE_LOGIN_FORGET_TXT; ?></h4>
		<p><?php echo PAGE_LOGIN_NOWORRIES_TXT; ?><a class="color-green" href="<?php echo show_page_link(FILE_FORGOT_PASSWORD);?>"><?php echo PAGE_LOGIN_CLICK_HERE_TXT; ?> </a><?php echo PAGE_LOGIN_RESET_TXT; ?></p>
        <hr /><!--==/End Forgot Password	==-->
        <!--==	Existing Account	==-->
        <h4><?php echo PAGE_LOGIN_REGISTRATION_HEAD; ?></h4>
		<!--<a href="<?php //echo show_page_link(FILE_SIGNUP); ?>" class="color-green"></a> -->
		<p class="justy"><?php echo PAGE_LOGIN_REGISTRATION_TXT_1; ?><button class="btn-u pull-right" type="submit" id="registerBtn" value="register" name="registerBtn">Register</button><?php //echo PAGE_LOGIN_REGISTRATION_TXT_2; ?></p>
        <!--==/ EndExisting Account	==-->
	</form>
</div><!--/Login Block-->
