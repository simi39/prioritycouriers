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
		require_once(DIR_WS_MODEL . "UserMaster.php");
		require_once(DIR_WS_MODEL . "CountryMaster.php");
		require_once(DIR_WS_ADMIN_LANGUAGES . DIR_CURRENT_LANGUAGE. '/user.php');
		
		$arr_javascript_plugin_include[] = 'datatables/datatables.min.js';

		$arr_css_plugin_include[] = 'datatables/datatables.min.css';
		$arr_css_plugin_include[] = 'datatables/Buttons-1.6.5/css/buttons.dataTables.min.css';
	
	/**
	 * Start :: Object declaration
	 */
	    $CountryMasterObject   = new CountryMaster();
	    $CountryMasterObject   = $CountryMasterObject->Create();
		/*$ObjOrderMaster	= OrderMaster::Create();*/
		$ObjUserMaster	= new UserMaster();
		$ObjUserMaster	= $ObjUserMaster->Create();
		$UserData		= new UserData();
		
	/**
	  * Start :: Variable Declaration and Assignment 
	  */
		$UId=$_GET['Id'];
		if(!empty($UId))
		{
			$err['uid'] = isNumeric(valid_input($UId),ENTER_NUMERIC_VALUES_ONLY);
		}
		if(!empty($err['uid']))
		{
			logOut();
		}
		$action=  trim($_GET['Action']); 	// action Variable
		if(!empty($_GET['Action']))
		{
			$err['Action'] = chkStr(valid_input($_GET['Action']));
		}
		if(!empty($err['Action']))
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
	 * Restore user for shopping from trash
	 */
		if($action=='restore' && !empty($UId)) {
			$UserData->deleted = 1;
			$UserData->userid = $UId;
			// Array of editable fields
			$changeStatus = array("deleted");
			$ObjUserMaster->editUser($UserData, $changeStatus);
			$message=MSG_RESTORE_SUCCESS;
		}
/**
 * Code For Fetching User Details
 */
	
	$fieldArr = array("user_master. *",
					 "countries.countries_name",
					 "user_master.state"
					 );	
	$seaArr[]=array('Search_On'=>'deleted', 'Search_Value'=>2, 'Type'=>'int', 'Equation'=>'<>', 'CondType'=>'AND', 'Prefix'=>'', 'Postfix'=>'');	
	
	
	$all_user = $ObjUserMaster->getUser('*',null,null,null); // Fetch Data
    $data = $ObjUserMaster->getUserListing($fieldArr,null,null,null,$seaArr,null,false); // Fetch Data
	$all = $ObjUserMaster->getUserListing($fieldArr,null,null,null,$seaArr,null,true); // Fetch Data
	
	$from = $data_result[0];
	$to = $data_result[1];

	$DataUser=$ObjUserMaster->getUserListing($fieldArr,null,$from,$to,$seaArr); // Fetch Data
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo ADMIN_USER?></title>
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
								<span><a href="<?php echo FILE_WELCOME_ADMIN; ?>"><?php echo ADMIN_HEADER_HOME;?></a> > <?php echo ADMIN_HEADER_USERS; ?></span>
								<div><label class="top_navigation"><a href="<?php echo FILE_USERS_ADD_EDIT; ?>"><?php echo ADMIN_USERS_ADD_NEW ; ?></a>
								<a href="<?php echo FILE_USERS_ADD_EDIT; ?>?Action=export"><?php echo ADMIN_EXPORT_NEW ; ?></a>
								</label>
								
							
								</div>

								</td>
							</tr>
						
							<tr>
								<td class="heading">
									<?php echo ADMIN_HEADER_USERS; ?>
								</td>
							</tr>
							<?php if(!empty($message)) {?>
							<tr>
								<td class="message_success" align="center"><?php echo valid_output($message); ?></td>
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
													<th width="15%" align="center"><?php echo ADMIN_USERS_FIELD_NAME; ?></th>
													<th width="20%" align="center"><?php echo ADMIN_USERS_FIELD_EMAIL; ?></th>
													<th width="8%" align="center"><?php echo ADMIN_USERS_FIELD_CITY; ?></th>
													<th width="5%" align="center"><?php echo ADMIN_USERS_FIELD_STATE; ?></th>
													<th width="10%" align="center"><?php echo ADMIN_USERS_IP_ADDRESS; ?></th>
													<th width="10%" align="center"><?php echo ADMIN_USERS_FIELD_LAST_LOGIN; ?></th>
													
													<th width="10%" align="center" ><?php echo ADMIN_COMMON_ACTION; ?></th>										
												</tr>
											</thead>
											<tbody>
												<?php
												$i = 1;	
												 	if($DataUser!='') { 
												 		
														$fieldArr = array();
														$fieldArr = array('count(*) as total');											
		
														foreach ($DataUser as $users_details) {
															
															$rowClass = 'TableEvenRow';
															if($rowClass == 'TableEvenRow') {
																$rowClass = 'TableOddRow';
															} else {
																$rowClass = 'TableEvenRow';
															}
															
												?>
												<tr class="<?php echo $rowClass; ?>">
													<td align="center"><?php echo 1 +$from;?></td>
													<td><?php echo valid_output($users_details['firstname']).' '.valid_output($users_details['lastname']);if($users_details["reseller_no"]!=''){echo '('.valid_output($users_details["reseller_no"]).')' ; }?></td>
													<td><?php echo valid_output($users_details['email']);?></td>
													<td><?php echo valid_output($users_details['city']);?></td>
													<td><?php echo valid_output($users_details['state']);?></td>
													<td><?php echo valid_output($users_details['ip_address']);?></td>
													<td align="center"><?php //echo dateTimeDiff($users_details["last_login_date"]);
												echo valid_output($users_details["last_login_date"]);
												?></td>
													<td align="center" nowrap="nowrap">
														<a href="<?php echo FILE_USERS_ADD_EDIT; ?>?Action=edit&amp;userid=<?php echo $users_details['userid'].$URLParameters; ?>"><?php echo COMMON_EDIT; ?></a> | <a href="<?php echo FILE_USERTRASH; ?>?Action=trash&amp;Id=<?php echo $users_details['userid'].$URLParameters; ?>" onclick="return confirm('<?php echo ADMIN_USERS_DELETE_CONFIRM; ?>')"><?php echo COMMAN_DELETE; ?></a>
														
													</td>
												</tr>
												<?php
												$from++;
												}
											 }?>
											</tbody>
											<tfoot>
												<tr>
													<th align="center"><?php echo ADMIN_COMMON_SERIAL_NO; ?></th>
													<th align="center"><?php echo ADMIN_USERS_FIELD_NAME; ?>&nbsp;</th>
													<th align="center"><?php echo ADMIN_USERS_FIELD_EMAIL; ?>&nbsp;</th>
													<th align="center"><?php echo ADMIN_USERS_FIELD_CITY; ?>&nbsp;</th>
													<th align="center"><?php echo ADMIN_USERS_FIELD_STATE; ?>&nbsp;</th>
													<th align="center"><?php echo ADMIN_USERS_IP_ADDRESS; ?>&nbsp;</th>
													<th align="center"><?php echo ADMIN_USERS_FIELD_LAST_LOGIN; ?>&nbsp;</th>
													<th align="center"><?php echo ADMIN_COMMON_ACTION; ?>&nbsp;</th>
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

