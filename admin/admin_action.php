<?php
	/**
	 * This file is for add new admin
	 *
	 * @author     Radixweb <team.radixweb@gmail.com>
	 * @copyright  Copyright (c) 2008, Radixweb
	 * @version    1.0
	 * @since      1.0
	 */
	
	/**
	 * include common file
	 */

		require_once("../lib/common.php");
		require_once("../lib/bcrypt.php");
		require_once('pagination_top.php');
		require_once(DIR_WS_MODEL . "AdminLoginMaster.php");
		require_once(DIR_WS_ADMIN_LANGUAGES . DIR_CURRENT_LANGUAGE. '/admin.php');
		 
	/**
	 * Inclusion and Exclusion Array of Javascript
	 */
		$arr_javascript_include[] = FILE_ADMIN_ADD_ADMINISTRATOR;
		$arr_javascript_include[] = 'internal/admin_action.php';
		//$arr_javascript_exclude[] = 'app.js';
		$arr_javascript_plugin_include = array('overlib.js');
		$arr_javascript_plugin_include[] = 'bootstrap/js/bootstrap.min.js';
		$arr_javascript_plugin_include[] = 'ddaccordion/js/ddaccordion.js';
		//$arr_css_exclude[] = DIR_HTTP_ADMIN_CSS.'jquery.css';
		
	
	/**
	 * For creating objects
	 */
		$ObjAdminMaster = new AdminLoginMaster();
		$ObjAdminMaster = $ObjAdminMaster->Create();
		$ObjAdmin		= new AdminLoginData();
		
	
	/**
	 * Variable Declaration and assignment
	 */
		$AdminId            = valid_input($_GET['AdminId']);
		if(!empty($AdminId))
		{
			$err['AdminId'] = isNumeric(valid_input($AdminId),ENTER_NUMERIC_VALUES_ONLY);
		}
		if(!empty($err['AdminId']))
		{
			logOut();
		}
		$buttonName     	= ADMIN_ADD_BUTTON;
		$HeadingLabel   	= ADMIN_ADD_HEADING;
		$username      	    = valid_input($_POST['user_name']);
		$password       	= valid_input($_POST['user_password']);
		$confirm_password 	= valid_input($_POST['user_conf_password']);
		$mail_id        	= valid_input($_POST['user_email']);
		$PostData       	= false;
		/*csrf validation*/
		$csrf = new csrf();
		$csrf->action = "admin_action";
		if(!isset($_POST['ptoken'])) {
			$ptoken = $csrf->csrfkey();
		}
		/*csrf validation*/
		
		
		$seaArr = array();
		if(!empty($AdminId)) {
			$seaArr[]     =	array('Search_On'=>'admin_id', 'Search_Value'=>$AdminId, 'Type'=>'string', 'Equation'=>'=', 'CondType'=>'AND', 'Prefix'=>'', 'Postfix'=>'');
			$ObjAdminData = $ObjAdminMaster->getAdminLogin(null,$seaArr);
			$buttonName   = ADMIN_EDIT_BUTTON;
			$HeadingLabel = ADMIN_EDIT_HEADING;
		}
		if(!empty($_GET['Action']))
		{
			$err['Action'] = chkStr(valid_input($_GET['Action']));
		}
		if(!empty($err['Action']))
		{
			logOut();
		}
	    if($_GET['Action']!='' &&  $_GET['Action']=='export'){


	$Admins = $ObjAdminMaster->getAdminLogin();	
	
	$filename = DIR_WS_ADMIN_DOCUMENTS."admin_login.csv"; //Balnk CSV File
	$file_extension = strtolower(substr(strrchr($filename,"."),1));	//GET EXtension
    
	/**
	 * Genration of CSV File
	 */
	switch( $file_extension ) {
	  case "csv": $ctype = "text/comma-separated-values";break;
	  case "jpg": $ctype="image/jpg"; break;
	  default: $ctype="application/force-download";
	}    
	header("Pragma: public"); // required
	header('Expires: ' . gmdate('D, d M Y H:i:s') . ' GMT');
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Cache-Control: private",false); // required for certain browsers
	header("Content-Type: $ctype");
	header("Content-Disposition: attachment; filename=".basename($filename).";" );
	header("Content-Transfer-Encoding: binary");
	
	ob_clean();
	
	$curr= array("€"=>"�","£"=>"�");
	$data = "";
	$data.= "admin_id,\"superadmin\",\"username\",\"password\",\"mail_id\",\"master_password\"";
				
	if(isset($Admins) && !empty($Admins)) {		
		foreach ($Admins as $Admin) {		
			/*Code for the Currency value in which the order has been done*/
			$admin_id = $Admin['admin_id'];
			$superadmin = $Admin['superadmin'];
			$username = $Admin['username'];
			$password  = $Admin['password'];
			$mail_id  = $Admin['mail_id'];
			$master_password  = $Admin['master_password'];
			
			$data.= "\n";
			$data.= '"'.$admin_id.'","'.$superadmin.'","'.$username.'","'.$password.'","'.$mail_id.'","'.$master_password.'"';
		}			
	}
	echo $data;
	exit();
}

	
		if(!empty($_POST['Submit'])) {
			
			if(isEmpty(valid_input($_POST['ptoken']), true))
			{	
				logOut();
			}
			else
			{
				//$csrf->checkcsrf($_POST['ptoken']);
			}
			$PostData=true;
			
			$err['UserNameError'] = isEmpty($username, ADMIN_ERROR_NAME_REQUIRED);
			
			if(empty($err['UserNameError']))
			{
				$err['UserNameError'] = checkName(trim($username));
			}
			
			if(empty($AdminId)) {
				$err['PasswordError'] 		= isEmpty($password, ADMIN_ERROR_PASSWORD_REQUIRED);
				$err['ConfPasswordError'] 	= isEmpty($confirm_password,ADMIN_CONFIRM_PASSWORD);
				if($err['PasswordError']=="")
				{
					$err['PasswordError'] = checkPassword($password);
				}
				if($err['ConfPasswordError']=="")
				{
					$err['ConfPasswordError'] = checkPassword($confirm_password);
				}
			}
			
			$err['UserEmailError']	   = isEmpty($mail_id, ADMIN_ERROR_EMAIL_REQUIRED);
			if($err['UserEmailError'] == "")
			{
				$err['UserEmailError'] = checkEmailPattern($mail_id,ADMIN_ERROR_EMAIL_INVALID);
			}
			// Start :: Check Admin name already Exists or not
			if(empty($err['UserNameError']) && $ObjAdminData[0]['username'] != $username){
				$seaArr 		= array();
				$seaArr[] 		=	array('Search_On'=>'username', 'Search_Value'=>$username, 'Type'=>'string', 'Equation'=>'=', 'CondType'=>'AND', 'Prefix'=>'', 'Postfix'=>'');
				$admindetails 	= $ObjAdminMaster->getAdminLogin(null,$seaArr);
			
				if(!empty($admindetails) && $admindetails[0]['username'] != ''){
					$err['UserNameError']	=  ADMIN_ERROR_NAME_EXISTS;
				}
			}
		
			//Checks if error is set or not 
			foreach($err as $key => $Value)
			{
				if($Value!= '') {
					$Svalidation=true;
					$ptoken = $csrf->csrfkey();
				}
			}
			
			if($Svalidation == false) {
				$bcrypt = new bcrypt(12);
				$has_pwd  = $bcrypt->genHash($password);
				$ObjAdmin->username=$username;
				
				$ObjAdmin->mail_id=$mail_id;
				$ObjAdmin->superadmin = 0;
				
				if(!empty($AdminId)) {
				/** To Update Administator **/
					$ObjAdmin->admin_id=$_GET['AdminId'] ;
					$ObjAdmin->superadmin=$ObjAdminData[0]['superadmin'];
					$ObjAdminMaster->editAdminLogin($ObjAdmin);
					$UParam="?message=".MSG_EDIT_SUCCESS;
					
				} else {
				/** To Add Administator **/
					$ObjAdmin->password=$has_pwd;
					$ObjAdminMaster->addAdminLogin($ObjAdmin);
					$UParam="?message=".MSG_ADD_SUCCESS;
				}
				header("Location:".FILE_ADMIN_ADMINISTRATOR.$UParam);
				exit;
			}
		}		
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php
if(isset($_GET['AdminId']) && !empty($_GET['AdminId'])) {
	echo ADMIN_TITLE_ADMIN_EDIT;
} else {
	echo ADMIN_TITLE_ADMIN_ADD;
}
?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<style>
.pick_form_textbox_index {
	background:#fff;
	margin-top:5px;
	padding:1px 5px;
	border:1px solid #fc600d;
	width:210px;
	text-align:left;
	font-size:11px;
	color:#f76105;
	font-weight:bold;
}
</style>
<?php 
addPluginCSSFile($arr_css_plugin_include,$arr_css_plugin_exclude);
addCSSFileAdmin($arr_css_admin_include, $arr_css_admin_exclude);
addJavaScriptFile($arr_javascript_include, $arr_javascript_exclude);
addPluginJavaScriptFile($arr_javascript_plugin_include,$arr_javascript_plugin_exclude);
?>

</head>
<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
	<tr>
		<td valign="top">
		<?php require_once(DIR_WS_ADMIN_INCLUDES . ADMIN_FILE_HEADER);?>
		</td>
	</tr>	
<!-- Start Middle Content part -->
	<tr>
		<td class="middle_content">
			<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td class="middle_left_content">
						<?php 
						// Include the Left Panel
						require_once(DIR_WS_ADMIN_INCLUDES . ADMIN_FILE_LEFT_MENU);
						?>
					</td>
					<td valign="top">
						<table class="middle_right_content" align="center" border="0" cellpadding="0" cellspacing="0">
							<tr>
								<td align="left" class="breadcrumb">
										<span><a href="<?php echo FILE_WELCOME_ADMIN; ?>"><?php echo ADMIN_HEADER_HOME; ?></a> > <a href="<?php echo FILE_ADMIN_ADMINISTRATOR; ?>"><?php echo ADMIN_HEADER_ADMIN_MANAGEMENT; ?></a> > <?php echo $HeadingLabel; ?></span>
										<div><label class="top_navigation"><a href="<?php echo FILE_ADMIN_ADMINISTRATOR; ?>"><?php echo ADMIN_COMMON_BACK; ?></a></label></div>
								</td>
							</tr>
							<tr>
								<td class="heading">
									<?php echo $HeadingLabel; ?>
								</td>
							</tr>
							
							
											
											<tr><td colspan="4">&nbsp;</td></tr>
											
																							
											
							<tr><td class="message_mendatory" align="right"><?PHP echo  ADMIN_COMMAN_REQUIRED_INFO;?></td></tr>
							<tr>
																	<td colspan="4" align="left" valign="top" class="grayheader"><b><?php echo ADMIN_USERS_PERSONAL_DETAILS;?> : </b></td>
																</tr>
						    <tr><td colspan="4">&nbsp;</td></tr>
							<tr>
								<td align="left">
									<form name="frmadmin" method="post" action="" autocomplete="off">
									
									<table width="100%" border="0" cellpadding="0" cellspacing="0">
										<tr>
											<td align="left" width="20%"><?php echo ADMIN_LABEL_USERNAME;?></td>
											<td class="message_mendatory" >
											<input type="text"   name="user_name" maxlength="50" value="<?php if($PostData==true) { echo valid_output($username); } else { echo valid_output($ObjAdminData[0]['username']);}?>" >*<img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>internal/help_up.gif" class="help_btn" alt="<?php echo ADMIN_LABEL_USERNAME;?>" onmouseover="return overlib('<?php echo valid_output($User_Name);?>');" onmouseout="return nd();" />
											
											
											<input type="hidden" id="ptoken" value="<?php echo $ptoken; ?>" name="ptoken">
											</td>
										</tr>
										<tr>
											<td>&nbsp;</td>
											<td class="message_mendatory" id="UserNameError"><?php if(isset($err['UserNameError'])) { echo $err['UserNameError']; } ?></td>
										</tr>
										<tr>
											<td align="left"><?php echo ADMIN_COMMON_LABEL_EMAILID;?></td>
											<td class="message_mendatory"><input type="text" name="user_email"  maxlength="50" value="<?php if($PostData==true) {echo $mail_id;} else {echo valid_output($ObjAdminData[0]['mail_id']);}?>"> *<img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>internal/help_up.gif" class="help_btn" alt="<?php echo ADMIN_COMMON_LABEL_EMAILID;?>"onmouseover="return overlib('<?php echo $Email_Address;?>');" onmouseout="return nd();" /></td>
										</tr>
										<tr>
											<td>&nbsp;</td>
											<td class="message_mendatory" id="UserEmailError"><?php if(isset($err['UserEmailError'])) { echo $err['UserEmailError']; } ?></td>
										</tr>
										<?php if(empty($AdminId)) {?>
										<tr>
											<td align="left"  ><?php echo ADMIN_COMMON_LABEL_PASSWORD;?></td>
											<td class="message_mendatory"><input type="password" name="user_password"  maxlength="50" value="<?php if($PostData==true) {echo valid_output($password);} else { echo valid_output($ObjAdminData[0]['password']);}?>"> *<img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>internal/help_up.gif" class="help_btn" alt="<?php echo ADMIN_COMMON_LABEL_PASSWORD;?>"onmouseover="return overlib('<?php echo $Password;?>');" onmouseout="return nd();" /></td>
										</tr>
										<tr>
											<td>&nbsp;</td>
											<td class="message_mendatory" id="PasswordError">&nbsp;<?php if(isset($err['PasswordError'])) { echo $err['PasswordError']; } ?></td>
										</tr>
									   <?php }  else {?>
											<input type="hidden" name="user_password" maxlength="50" value="<?php echo valid_output($ObjAdminData[0]['password']);?>">
										<?php }?>
										
										<?php if(empty($AdminId)) {?>
										<tr>
											<td align="left"  ><?php echo ADMIN_CONFIRM_PASSWORD;?></td>
											<td class="message_mendatory"><input type="password" name="user_conf_password" id="user_conf_password"  maxlength="50" value="<?php if($PostData==true) {echo valid_output($confirm_password);}?>"> *<img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>internal/help_up.gif" class="help_btn" alt="<?php echo ADMIN_CONFIRM_PASSWORD;?>"onmouseover="return overlib('<?php echo $Confirm_Password;?>');" onmouseout="return nd();" /></td>
										</tr>
										<tr>
											<td>&nbsp;</td>
											<td class="message_mendatory" id="ConfPasswordError"><?php if(isset($err['ConfPasswordError'])) { echo $err['ConfPasswordError']; } ?></td>
										</tr>
										<?php } ?>
										<tr>
											<td>&nbsp;</td>
											<td>&nbsp;</td>
										</tr>
										<tr>
											<td>&nbsp;</td>
											<td align="left">
												<input type="submit" class="action_button" name="Submit" id="Submit" value="<?php echo $buttonName; ?>" onclick="return validation();"/>
												<input type="reset"  class="action_button" name="btnreset" value="<?php echo ADMIN_COMMON_BUTTON_RESET;?>"/>
												<input type="button"  class="action_button" name="cancel" value="<?php echo ADMIN_COMMON_BUTTON_CANCEL;?>" onclick="javascript:document.location.href='<?php echo FILE_ADMIN_ADMINISTRATOR; ?>';return true;"/>
											</td>
										</tr>
									</table>
									</form>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
<!-- End Middle Content part -->
	<tr>
		<td id="footer">
			<?php require_once(DIR_WS_ADMIN_INCLUDES . ADMIN_FILE_FOOTER);?>
		</td>
	</tr>
</table>
</body>
</html>
