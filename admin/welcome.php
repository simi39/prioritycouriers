<?php
/**
 * This file is for welcome page
 *
 * @author     Radixweb <team.radixweb@gmail.com>
 * @copyright  Copyright (c) 2008, Radixweb
 * @version    1.0
 * @since      1.0
*/

/**
 * include common file
 */	
 
	session_start();
	
	require_once("../lib/common.php");

	require_once(DIR_WS_MODEL . "UserMaster.php");	
	require_once(DIR_WS_ADMIN_LANGUAGES . DIR_CURRENT_LANGUAGE. '/welcome.php');	
	//session_regenerate_id(true);	
	
/**
 * create object
 */
	$ObjUserMaster	= new UserMaster();
	$ObjUserMaster	= $ObjUserMaster->Create();



//Variable defination
$message		= valid_output($_GET['message']);
if(!empty($message)){	
	$err['MessageError'] = specialcharaChk($message);
}
if(!empty($err['MessageError'])){	
	logOut();
}

/*
echo "<pre>";
print_R($_GET);
echo "</pre>";*/
//exit();
 
if(isset($_GET['Action']) && $_GET['Action'] == 'Logout') {
	//admin_deletecookie();
	
	$csrf = new csrf();
	$csrf->cleanOldSession();
	$csrf->logout();
	unsetAdminSession();
	show_page_header(SITE_ADMIN_DIRECTORY.FILE_ADMIN_INDEX,false);
	exit();	
}
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo ADMIN_WELCOME_HEADING;?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<?php
addCSSFileAdmin($arr_css_admin_include, $arr_css_admin_exclude);
addPluginCSSFile($arr_css_plugin_include,$arr_css_plugin_exclude);
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
								<td align="center" class="heading">
									<?php echo ADMIN_WELCOME_HEADER_NOTE;?>
								</td>
							</tr>
							<tr>
								<td align="left">
									<table width="100%" align="center" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td width="44%" valign="top">
												<fieldset class="dashboard_field">
													<legend>
														<span class="dashboard_lable"><?php echo ADMIN_WELCOME_RECENT_USERS;?></span> (<a href='<?php echo FILE_USERS; ?>' class="blue_link"><?php echo ADMIN_WELCOME_VIEW_USERS;?></a>|<a href="<?php echo FILE_USERS_ADD_EDIT;?>" class="blue_link"><?php echo ADMIN_WELCOME_ADD;?></a>) </legend>
														<?php //Displays recent users 
														$userseaArr[]=array('Search_On'=>'deleted', 'Search_Value'=>2, 'Type'=>'int', 'Equation'=>'<>', 'CondType'=>'AND', 'Prefix'=>'', 'Postfix'=>'');	
														$optArr[]     =	array('Order_By'=>'userid', 'Order_Type'=>'DESC');
														$res = $ObjUserMaster->getUser(NULL,$userseaArr,$optArr);
														$i = 1;	
														if($res != '')	{
														?>
															<ul class="dashboard_ul">
														<?php	foreach ($res as $users_details) { ?>
																
																	<li><?php echo valid_output($users_details['firstname']).' '.valid_output($users_details['lastname']);?>&nbsp;&nbsp;&nbsp;[<?php echo valid_output($users_details['email']);?>]&nbsp;&nbsp;[<a href="<?php echo FILE_USERS_ADD_EDIT;?>?Action=edit&userid=<?php echo $users_details['userid'];?>" ><?php echo COMMON_EDIT;?></a>]</li>
																<?php 	$i++;
																	if ($i==6) {
																		break;
																	}
															} ?>
															</ul>
														<?php }	?>
												</fieldset>
											</td>
											<td width="2%">&nbsp;</td>
											<td width="44%" valign="top">
												
											</td>
										</tr>
										
										<tr>
											<td width="40%" valign="top">
											
											</td>
											<td width="1%" >&nbsp;</td>
											<td width="45%" valign="top">
											
											</td>
										</tr>
										<tr>
											<td width="40%" valign="top" class="icon">
											
											</td>
										</tr>
									</table>
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
