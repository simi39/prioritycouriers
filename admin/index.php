<?php
	/**
	* This is index for login admin
	*
	* @author     Radixweb <team.radixweb@gmail.com>
	* @copyright  Copyright (c) 2008, Radixweb
	* @version    1.0
	* @since      1.0
	*/
	session_start();
		
	require_once("../lib/common.php");
	require_once("../lib/bcrypt.php");
	require_once(DIR_WS_MODEL."/AdminLoginMaster.php");
	require_once(DIR_WS_ADMIN_LANGUAGES . DIR_CURRENT_LANGUAGE. '/index.php');
	require_once(DIR_WS_ADMIN_LANGUAGES . DIR_CURRENT_LANGUAGE. '/admin.php');
	/**
	 * Inclusion and Exclusion Array of Javascript
	 */
	$arr_javascript_include[] = 'internal/admin_index.php';
	//$arr_javascript_exclude[] = 'jquery.min.js';
	//$arr_javascript_exclude[] = 'jquery-migrate.min.js';
	//$arr_javascript_plugin_exclude[] = "bootstrap/js/bootstrap.min.js";
	//$arr_javascript_plugin_exclude[] = "ddaccordion.js";
	//$arr_css_admin_exclude[] = 'jquery.css';
	/**
	 * Object Declaration
	 */
	$LoginObj =  new AdminLoginMaster();
	$LoginObj =  $LoginObj->Create();
	
	/*csrf validation*/
	$csrf = new csrf();

	$csrf->action = "admin_index";

	/*
	if(!($_POST['ptoken'])) {
		
		$ptoken = $csrf->csrfkey();
		
	}
	exit();*/

	/*csrf validation*/

	//echo $Url;
	
	//Variable defining
    $username = valid_input($_POST['username']);
    $bcrypt = new bcrypt(12);
	$has_pwd  = $bcrypt->genHash($_POST['password']);
	
    $submit   = valid_input($_POST['submit']);
    $password = $_POST['password'];
	
	//On form Submittion
	if(isset($submit) && ($submit == 'Login')) {
		
		/*if(isEmpty(valid_input($_POST['ptoken']), true)){	

			logOut();
		}else{
			
			$csrf->checkcsrf($_POST['ptoken']);
		}
*/

				
		//$clientip = $_SERVER['REMOTE_ADDR'];
		$clientip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		$result = checkIPAddress($clientip); // check the ip address for ban
		
		if($result == 1)
		{
		  $err['Loginattempts'] = COMMON_LOGIN_ATTEMPTS;
		  //exit();
		}
		if(empty($username)) {
			$err['username'] = isEmpty($username, ADMIN_ERROR_NAME_REQUIRED);
		}
		if(!empty($username)){
			$err['username'] = checkName(valid_output($username));
		}
		if(empty($password)) {
			$err['password'] = isEmpty($password, ADMIN_ERROR_PASSWORD_REQUIRED);
		}
		
		if($username != '' && $password != '') {
			$Option = array('UserName'=>$username,'Password'=>$password);
			
			$seaArr[]	=	
				array('Search_On'=>'username',
				'Search_Value'=>$username,
				'Type'=>'string',
				'Equation'=>'LIKE binary',
				'CondType'=>'AND',
				'Prefix'=>'',
				'Postfix'=>''
			);
				
			//Gets details for the user name and password
			$AuthAdmin = $LoginObj->getAdminLogin(null,$seaArr);
			$HashFromDB = $AuthAdmin[0]['password'];
			//echo $bcrypt->verify('admin', ':$2y$12$Iu8PjFAmEzAaYwyuNszKred9xa/67lt1JadKsqa3SVisHLIWzlUQe');
			//exit();
			
			$pass_error = $bcrypt->verify($password, $HashFromDB);
			//echo "pass erorr:".$pass_error;
		//	exit();
			if(empty($pass_error))
			{
				$err['LoginId'] = EMAIL_DOESNOT_EXIST;
				//exit();
			}
			foreach($err as $key => $Value) {
				if($Value != '') {
					$Svalidation=true;
					$csrf->action = "admin_index";
					$ptoken = $csrf->csrfkey();
					//exit();
				}
			}
			//If Record Found for Username & PassWord Then Session Start
			if($AuthAdmin[0]['username']!="" && $Svalidation==false) {
				
				$AdminLoginArray['LoginName'] = valid_output($AuthAdmin[0]['username']);
				$AdminLoginArray['Loginid'] = $AuthAdmin[0]['admin_id'];
				$AdminLoginArray['SuperAdmin'] = $AuthAdmin[0]['superadmin'];
				$__Session->SetValue("_Sess_Admin_Login",$AdminLoginArray);
				$__Session->Store();
				
				//admin_setcookie();
				//session_regenerate_id(true);
				header("location:".FILE_WELCOME_ADMIN);
				exit;
				
			}else
			{
				addIPAttempts($clientip);
			}			
		}
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo ADMIN_LOGIN?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<?php
addPluginCSSFile($arr_css_plugin_include,$arr_css_plugin_exclude);
addCSSFileAdmin($arr_css_admin_include, $arr_css_admin_exclude);
addJavaScriptFile($arr_javascript_include, $arr_javascript_exclude);
addPluginJavaScriptFile($arr_javascript_plugin_include,$arr_javascript_plugin_exclude);
?>
</head>
<body>
		<form method="POST" name="adminfrmlogin" id="adminfrmlogin" action="index.php" autocomplete="off">
			<table id="a-t" border="0" cellpadding="0" cellspacing="0" height="150" width="300" align="center">
				<tr>
					<td align="left" class="loginbox-caption">&nbsp;</td>
					<td id="input">&nbsp;</td>
				</tr>
				<?php if(isset($err['LoginId'])) { ?>
				<tr>
					<td colspan="2" align="center" class="message_mendatory" height="20" valign="middle"><?php echo $err['LoginId']; ?></td>
				</tr>
				<?php }elseif(isset($err['Loginattempts'])){ ?>
				<tr>
					<td colspan="2" align="center" class="message_mendatory" height="20" valign="middle"><?php echo $err['Loginattempts']; ?></td>
				</tr>
				<?php
				}
				?>
				<tr>
					<td width="100" align="left"><?php echo ADMIN_INDEX_USER_NAME;?></td>
					<td width="130" class="message_mendatory" align="left"><input tabindex="0" type="text" name="username" id="username" maxlength="225"  value="<?php if(isset($username)){echo valid_output($username);}?>"/></td>
				</tr>
				<tr>
					<td width="100">&nbsp;</td>
					<td width="130" id="usernameError" class="message_mendatory" align="left">
					<?php 
					 if(isset($err['username'])){	echo $err['username']; }
					?>
					</td>
				</tr>
				
				<tr>
					<td width="100" align="left"><?php echo ADMIN_INDEX_PASSWORD;?></td>
					<td width="130" class="message_mendatory" align="left"><input type="password" name="password" maxlength="255" value="<?php if(isset($password)){echo valid_output($password);}?>"/></td>
				</tr>
				<tr>
					<td align="left" width="100">&nbsp;</td>
					<td align="left" id="passwordError"  class="message_mendatory" width="130"><?php 
					 if(isset($err['password'])){	echo $err['password']; }
					?>&nbsp;</td>
				</tr>
				<tr>
					<td colspan="2" align="center">
					<input type="hidden" size="34" id="ptoken" value="<?php echo $ptoken; ?>" name="ptoken">
					<input type="submit" class="btn-u" name="submit" value="<?php echo ADMIN_INDEX_LOGIN;?>" onclick="javascript:return validatelogin();"/></td>
				</tr>
				<tr>
					<td colspan="2">&nbsp;</td>
				</tr>
				<tr>
					<td colspan="2" align="right" class="forgot_pwd">
									
					</td>
				</tr>
				<tr>
					<td colspan="2">&nbsp;</td>
				</tr>
			</table>
		</form>
</body>
</html>

