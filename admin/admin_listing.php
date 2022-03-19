<?php
	/**
	* This file is for display user list
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
		require_once(DIR_WS_MODEL . "AdminLoginMaster.php");
	    require_once(DIR_WS_MODEL . "CountryMaster.php");
		require_once(DIR_WS_ADMIN_LANGUAGES . DIR_CURRENT_LANGUAGE. '/admin.php');
		
	    /*$arr_css_plugin_include[] = 'datatables/css/jquery.dataTables.min.css';	
	    $arr_javascript_plugin_include[] = 'datatables/js/jquery.dataTables.min.js';*/
	    $arr_javascript_plugin_include[] = 'datatables/datatables.min.js';

		$arr_css_plugin_include[] = 'datatables/datatables.min.css';
		$arr_css_plugin_include[] = 'datatables/Buttons-1.6.5/css/buttons.dataTables.min.css';
			
	    $AdminLoginMasterObj	= new CountryMaster();
	    $AdminLoginMasterObj	= $AdminLoginMasterObj->Create();
		$CountryData		= new CountryData();
		
		
		$AdminLoginMasterObj	= new AdminLoginMaster();
		$AdminLoginMasterObj	= $AdminLoginMasterObj->Create();
		
		
	    $AId = $_GET['AdminId'];
		if(!empty($AId))
		{
			$err['AId'] = isNumeric(valid_input($AId),ENTER_NUMERIC_VALUES_ONLY);
		}
		if(!empty($err['AId']))
		{
			logOut();
		}
		$action = valid_input($_GET['Action']); // Action Variable
		if(!empty($_GET['Action']))
		{
			$err['Action'] = chkStr(valid_input($_GET['Action']));
		}
		if(!empty($err['Action']))
		{
			logOut();
		}
		$searchadmin = valid_input($_GET['searchadmin']); // Searching Record		
		if(!empty($searchadmin))
		{
			$err['searchadmin'] = chkStr(valid_input($searchadmin));
		}
		if(!empty($err['$searchadmin']))
		{
			logOut();
		}
		
		
		$message = valid_input($arr_message[$_GET["message"]]);
		if(!empty($message))
		{
			$err['MessageError'] = specialcharaChk($message);
		}
		if(!empty($err['MessageError']))
		{
			logOut();
		}
	
	
		
	/**
	 * Start :: Delete User
	 */
		if(!empty($_GET['deleteid']))
		{
			$err['deleteid'] = isNumeric(valid_input($_GET['deleteid']),ENTER_NUMERIC_VALUES_ONLY);
		}
		if(!empty($err['deleteid']))
		{
			logOut();
		}
		if($action == "del" && !empty($_GET['deleteid'])) {
			$AId = $_GET['deleteid'];
			$AdminLoginMasterObj->deleteAdminLogin($AId);
			$message = MSG_DEL_SUCCESS;
			header('location: '.FILE_ADMIN_ADMINISTRATOR.'?message='.$message);
			exit();
			
		}
	
	
	$all_records=$AdminLoginMasterObj->getAdminLogin($fieldArr, null,null,$from,10, true, true);
	  	
	?>
	
	
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo TITLE?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<?php 
addPluginCSSFile($arr_css_plugin_include,$arr_css_plugin_exclude);
addCSSFileAdmin($arr_css_admin_include, $arr_css_admin_exclude);
addJavaScriptFile($arr_javascript_include, $arr_javascript_exclude);
addPluginJavaScriptFile($arr_javascript_plugin_include,$arr_javascript_plugin_exclude);
?>
<script>
$(document).ready(function() {
    $('#maintable').dataTable();
} );
</script>
</head>
<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0" id="main" align="center">
	<tr>
		<td>
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
						<table border="0" width="100%" cellpadding="0" cellspacing="0"  align="center" class="middle_right_content">
							<tr>
								<td align="left" class="breadcrumb">
								<span><a href="<?php echo FILE_WELCOME_ADMIN; ?>"><?php echo ADMIN_HEADER_HOME;?></a> > <?php echo ADMIN_HEADER_ADMIN_MANAGEMENT; ?></span>
								<div><label class="top_navigation"><a href="<?php echo FILE_ADMIN_ADD_ADMINISTRATOR; ?>"><?php echo ADMIN_ADMINISTRATOR_ADD_NEW_ADMIN ; ?></a>
								
								</label>
								
							
								</div>

								</td>
							</tr>
							<tr>
								<td class="heading">
									<?php echo ADMIN_HEADER_ADMIN_MANAGEMENT; ?>
								</td>
							</tr>
							<?php if(!empty($message)) {?>
							<tr>
								<td class="message_success" align="center"><?php echo valid_output($message) ; ?></td>
							</tr>							
							<?php } ?>
							<!--  End Searching	-->
							<tr>
								<td>
								
							<?php  /*** Start :: Listing Table ***/ ?>
							
									<div id="container">

										
										<table width="100%" cellspacing="0" cellpadding="0" class="display" id="maintable">
											<thead>
												<tr>
													<th width="5%" align="center"><?php echo ADMIN_COMMON_SERIAL_NO; ?></th>
													<th width="15%" align="center"><?php echo ADMIN_LABEL_USERNAME; ?></th>
													<th width="20%" align="center"><?php echo ADMIN_COMMON_EMAIL; ?></th>		
													<th width="5%" align="center"><?php echo ACTION; ?></th>
													
																
												</tr>
											</thead>
											<tbody>
												<?php
												 	if($all_records!='') { 
												 		$i = 1;	
														$fieldArr = array();
														$fieldArr = array('count(*) as total');						
		
														foreach ($all_records as $users_details) {
															
															$rowClass = 'TableEvenRow';
															if($rowClass == 'TableEvenRow') {
																$rowClass = 'TableOddRow';
															} else {
																$rowClass = 'TableEvenRow';
															}
															
												?>
												<tr class="<?php echo $rowClass; ?>">
													<td align="center"><?php echo $i = 1 +$from;?></td>
													<td><?php echo ucfirst(valid_output($users_details['username'])); ?></td>
													<td><?php echo valid_output($users_details['mail_id']);?></td>
													
													
													<td align="center">
														<a href="<?php echo FILE_ADMIN_ADD_ADMINISTRATOR;?>?AdminId=<?php echo $users_details['admin_id'];?><?php echo $URLParameters; ?>"><?php echo COMMON_EDIT;?> </a>
													<?php if($users_details['superadmin']==0) { ?>
														&nbsp;|&nbsp;<a href="<?php echo FILE_ADMIN_ADMINISTRATOR;?>?deleteid=<?php echo $users_details['admin_id'];?>&Action=del" ><?php echo COMMAN_DELETE;?></a>
													<?php } ?>
														</td>
													
												</tr>
												<?php	$from = $from+1;
												}
											 }?>
											</tbody>
											<tfoot>
												<tr>
													<th align="center"><?php echo ADMIN_COMMON_SERIAL_NO; ?></th>
													<th align="center"><?php echo ADMIN_LABEL_USERNAME; ?></th>
													<th align="center"><?php echo ADMIN_COMMON_EMAIL; ?></th>
													<th align="center"><?php echo ACTION; ?>&nbsp;</th>
													
													
						
												</tr>
											</tfoot>
											
										</table>
										
										
									</div>
									
							<?php  /*** End :: Listing Table ***/ ?>
									
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
		<td id="footer"><?php require_once(DIR_WS_ADMIN_INCLUDES . ADMIN_FILE_FOOTER);?></td>
	</tr>
</table>
</body>
</html>
