<!--=== Breadcrumbs ===-->
<div class="breadcrumbs margin-bottom-40">
	<div class="container">
        <h1 class="color-green pull-left"><?php echo HEADING_USER_CHANGE_PASSWORD; ?></h1>
        <ul class="pull-right breadcrumb">
            <li><a href="<?php echo SITE_INDEX; ?>"><?php echo PAGE_HEADING_HOME; ?></a> <span class="divider">/</span></li>
            <li class="active"><?php echo PAGE_HEADING_CHANGEPASSWORD; ?></li>
        </ul>
    </div><!--/container-->
</div><!--=== End Breadcrumbs ===-->
<!--=== Change Pass Info ===-->
<div class="row-fluid">
    <div class="span12 margin-bottom-30">
    	<blockquote class="change-pass">
    	<?php echo RESET_PASS_INFO;?>
    	</blockquote>
    </div>
</div><!--===/End Change Pass Info ===-->
<div class="row-fluid">
		<form name="frmchangepassword" id="frmchangepassword" method="post" class="log-page" autocomplete="off">
		<h3><?php echo CHANGEPASSWORD_ENTER_NEW_PASS;?></h3>
		<div class="controls">
			
		</div>
		<div class="input-prepend form-group control-group">
			<label class="control-label add-on"><i class="icon-lock"></i></label>
			<input type="hidden" id="ptoken" value="<?php echo $ptoken; ?>" name="ptoken">
			<input  type="password" class="input-xlarge form-control" name="Change_Pass" id="Change_Pass"  value="<?php  if(isset($_POST['Change_Pass']) && $_POST['Change_Pass'] != ''){ echo valid_output($_POST['Change_Pass']); } ?>" onkeypress="javascript:removeError('newName_Error_css');"/>
			<span class="help-block alert-error" id="newpass_message"></span>
		</div>
		<?php
			if(isset($err['ChangePs'])){
			?>
			<!-- PHP Validation	-->
			<div class="alert alert-error show" id="newName_Error_css">
				<a class="close">×</a> 
				<div id="NewNameError"><?php echo $err['ChangePs'];?></div>
			</div><!--	End PHP Validation	-->
		<?php
		}
		?>
		
		<div class="input-prepend form-group control-group">
			<label class="control-label add-on"><i class="icon-lock"></i></label>
			<input class="input-xlarge form-control" type="password" name="Conf_Pass"  id="Conf_Pass" value="<?php if(isset($_POST['Conf_Pass']) && $_POST['Conf_Pass'] != ''){ echo valid_output($_POST['Conf_Pass']); } ?>" onkeypress="javascript:removeError('confName_Error_css');" />
			<span class="autocomplete_index help-block alert-error" id="confpass_message"></span>
		</div>
		<?php
			if(isset($err['ConPs']) && $err['ConPs']!=""){
			?>
			<!-- PHP Validation	-->
			<div class="alert alert-error show" id="confName_Error_css">
				<a class="close">×</a> 
				<div id="ConfNameError"><?php echo $err['ConPs'];?></div>
			</div><!--	End PHP Validation	-->
			<?php
			}
			?>
		
		<div class="controls form-inline">
			<input type="hidden" name="nonce_auth" value="<?php echo $auth; ?>"/>
			<input type="hidden"  class="btn-u pull-right" name="Submits" value="Submit"  id="Submits"  />
			<button class="btn-u pull-right" type="submit"  />Save</button>
			<input type="reset" class="btn-u pull-left" name="reset" value="Reset" />
		</div>
		<!-- Modal is defined here -->
		<div class="modal hide fade small_rates" id="successBox" data-backdrop="static" data-keyboard="false">
		<div class="modal-header">
		<h3><?php echo CHANGE_PASSWORD_HEADER; ?></h3>
		</div>
		<div class="modal-body"><?php echo MESSAGE_CHANGE_PASSWORD_SUCCESS; ?></div>
		<div class="modal-footer"><a href="#" id="p" class="btn-u pull-right" data-dismiss="modal">Close</a>	</div>
		</div>
		<!-- Modal is defined here -->
		<br>
		<hr>
	</form>
</div><!--/row-fluid-->