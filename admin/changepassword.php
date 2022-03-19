<?php
	/**
	 * This file is for changepassword for admin
	 *
	 * @author     Radixweb <team.radixweb@gmail.com>
	 * @copyright  Copyright (c) 2008, Radixweb
	 * @version    1.0
	 * @since      1.0
	 */
	
	/**
	 * include common file
	 * 
	 */
	require_once("../lib/common.php");
	require_once(DIR_WS_MODEL . "AdminLoginMaster.php");
	require_once(DIR_WS_ADMIN_LANGUAGES . DIR_CURRENT_LANGUAGE. '/changepassword.php'); 
	require_once(DIR_WS_RELATED."system_mail.php");
	
	
	//Object of AdminMaster
	$UserLoginMasterObj = AdminLoginMaster::Create();
	$UserLoginDataObj   = new AdminLoginData();
	
	
	/**
	 * Inclusion and Exclusion Array of Javascript
	 */
	$arr_javascript_include[] = 'user_action.php';
	$arr_css_exclude[] = DIR_HTTP_ADMIN_CSS.'jquery.css';
	
	//Variable declaration
	$submit      = trim($_POST['Submit']);
	$currPass    = trim($_POST['Curr_Pass']);
	$changePass  = trim($_POST['Change_Pass']);
	$confPass    = trim($_POST['Conf_Pass']);
	$Svalidation = false;
	/*csrf validation*/	$csrf = new csrf();	if(!isset($_POST['ptoken'])) {		$csrf->action = "changepass";		$ptoken = $csrf->csrfkey();	}	/*csrf validation*/	
    //Get details for the admin     
	$AdminId = ADMIN_USERID;
	$fieldArr = array("password");
	$seaArr[]	=	array('Search_On'=>'admin_id',
					'Search_Value'=>$AdminId,
					'Type'=>'string',
					'Equation'=>'=',
					'CondType'=>'AND',
					'Prefix'=>'',
					'Postfix'=>''
					);
	$admindetails = $UserLoginMasterObj->getAdminLogin($fieldArr,$seaArr);
	$UserOldPassword = $admindetails[0]['password'];
		
	/************************* Code for change password *************************/
	if(isset($submit) && $submit != '') {
		//Server Side Validation
	    $err['OldPs']= isEmpty(trim($currPass),ADMIN_CURRENT_PASSWORD);
	    $err['ChangePs']= isEmpty(trim($changePass),ADMIN_NEW_PASSWORD);
	    $err['ConPs']= isEmpty(trim($confPass),ADMIN_CONFIRM_PASSWORD);
	    foreach($err as $key => $Value){
			if($Value != '') {
				$Svalidation=true;
			}
		}
		if($Svalidation == false) {			if(isEmpty(valid_input($_POST['ptoken']), true)){					logOut();			}else{				$csrf->checkcsrf($_POST['ptoken']);			}
		//If Enterd PassWord & Current Password are not same then change password else throw header
			if($UserOldPassword == $currPass) {
				$OldPass=$UserOldPassword;
	 			$NewPass=trim($changePass);
				//If Old & new password not same then change password else throw error
 					if($OldPass != $NewPass) {
	 					$UserLoginDataObj->password = $NewPass;
	 					$UserLoginDataObj->admin_id = $AdminId;
						//Method to  change password
	 					$UserLoginMasterObj->editAdminLogin($UserLoginDataObj,true);
	 					
	 					$adminSearchArr = array();
						$adminSearchArr[] = array('Search_On'=>'admin_id', 'Search_Value'=>$AdminId, 'Type'=>'int', 'Equation'=>'=', 'CondType'=>'AND', 'Prefix'=>'','Postfix'=>'');
						$adminDetails = $UserLoginMasterObj->getAdminLogin(null,$adminSearchArr);
						$adminDetails= $adminDetails[0];
						$adminDetailsArray['firstname'] = $adminDetails['username'] ;
						$adminDetailsArray['password'] = $NewPass;
						$adminDetailsArray['email'] = $adminDetails['mail_id'] ;
						Change_Password($adminDetailsArray);
	 					$UParam="?message=Success";
 				
 					} else {
		 				if($Svalidation == false) {
		 					$UParam="?message=Same";
 						}
 					}
			} else {
	 			if($Svalidation == false) {
	 				$UParam="?message=Error";
 				}
 			}
	 		header("Location:".FILE_CHANGE_PASSWORD.$UParam);
	 		exit;
		}
	}
	
	//When the cancel button is pressed
	if(isset($_POST['Cancel']) && $_POST['Cancel'] = 'Cancel')	{
		header("Location:".ADMIN_FILE_LOGIN);
		exit;
	}
	/*************************End of  Code for change password *************************/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo ADMIN_CHANGE_PASSWORD;?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<?php 
addCSSFile($arr_css_include,$arr_css_exclude);
addJavaScriptFile($arr_javascript_include,$arr_javascript_exclude);
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
					<!-- Start :  Middle Content-->
					<table class="middle_right_content" align="center" border="0" cellpadding="0" cellspacing="0">
						<tr>
						<td align="left" class="breadcrumb">
								<span><a href="<?php echo FILE_WELCOME_ADMIN; ?>"><?php echo ADMIN_HEADER_ADMIN_MANAGEMENT; ?></a> > <? echo ADMIN_HEADER_CHANGEPASSWORD; ?></span>
								<div><label class="top_navigation"><a href="<?php echo FILE_WELCOME_ADMIN; ?>"><?php echo ADMIN_COMMON_BACK; ?></a></label></div>
						</td>
						</tr>
						<tr>
							<td class="heading">
								<?php echo ADMIN_HEADER_CHANGEPASSWORD; ?>
							</td>
						</tr>
						<tr>
						<td align="center">
						<form action="#" method="POST" name="changepass">
						<table width="100%" border="0" cellspacing="0" cellpadding="0"  align="center">
							<tr>
							<?php 
							//Message display.
							if($_GET['message']=='Same') {
								echo "<td class='message_error' align='center'>".ADMIN_NEW_AND_CURRENT_PASSWORD_BE_DIFFERENT;
							} elseif($_GET['message']=='Error') {
								echo "<td class='message_error' align='center'>".ADMIN_PASSWORD_NOT_MATCH; 
							} elseif($_GET['message']=='Success') {
								echo "<td class='message_success' align='center'>".ADMIN_PASSWORD_CHANGE;
							} 
							 ?>
							</td>
							</tr>
							<tr><td >&nbsp;</td></tr>
							<tr><td  class="message_mendatory" align="right"><?php echo ADMIN_COMMAN_REQUIRED_INFO;?> &nbsp;</td></tr>
							<tr>
							<td>
								<table border="0" width="100%" cellspacing="0" cellpadding="0">
									<tr>
										<td align="left"><?php echo ADMIN_CURRENT_PASSWORD;?></td>
										<td align="left" width="75%" class="message_mendatory"><input type="password" name="Curr_Pass" id="Curr_Pass" value="<?php if(isset($currPass) && $currPass != ''){ echo valid_output($currPass); }?>" class="login"/> *</td>
									</tr>
									<tr>
										<td>&nbsp;</td>
										<td class="message_mendatory" id="CNameError" align="left"><?php if(isset($err['OldPs'])) { echo $err['OldPs']; }  ?></td>
									</tr>
									<tr>
										<td align="left" ><?php echo ADMIN_NEW_PASSWORD;?></td>
										<td align="left" class="message_mendatory" width="75%" ><input type="password" name="Change_Pass" id="Change_Pass" value="<?php if(isset($changePass) && $changePass != ''){ echo valid_output($changePass); } ?>" class="login"/> *</td>
									</tr>
									<tr>
										<td>&nbsp;</td>
										<td class="message_mendatory" id="NewNameError" align="left"><?php if(isset($err['ChangePs'])) { echo $err['ChangePs']; } ?></td>
									</tr>
									<tr>
										<td  align="left" ><?php echo ADMIN_CONFIRM_PASSWORD;?></td>
										<td align="left"  class="message_mendatory" width="75%"><input type="password" name="Conf_Pass" id="Conf_Pass" value="<?php if(isset($confPass) && $confPass != ''){ echo valid_output($confPass); } ?>" class="login"/> *</td>
									</tr>
									<tr>
										<td>&nbsp;</td>
										<td class="message_mendatory" id="ConfNameError" align="left"><?php if(isset($err['ConPs'])) { echo $err['ConPs']; } ?></td>
									</tr>
									<tr>
										<td>&nbsp;</td>
										<td height="30">&nbsp;</td>
									</tr>
									<tr>
										<td></td>
										<td align="left">										<input type="hidden" size="34" id="ptoken" value="<?php echo $ptoken; ?>" name="ptoken">
										<input type="submit" class="action_button" name="Submit" id="Submit" value="<?PHP ECHO ADMIN_CHANGE_PASSWORD_BUTTON;?>" onclick="return PassWordValidation();"/>
										<input type="reset"  class="action_button" name="btnreset" id="Cancel" value="<?php echo ADMIN_COMMON_BUTTON_RESET?>" onclick="document.changepass.reset();"/>
										<input type="button"  class="action_button" name="cancel" tabindex="38" value="<?php echo ADMIN_COMMON_BUTTON_CANCEL;?>" onclick="javascript:document.location.href='<?php echo FILE_WELCOME_ADMIN; ?>';return true;"/>
										</td>
									</tr>
									<tr>
										<td>&nbsp;</td>
										<td height="30">&nbsp;</td>
									</tr>
								</table>
							</td>
							</tr>
						</table>
						</form>
						</td>
						</tr>
					</table>
					<!-- End :  Middle Content-->
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
