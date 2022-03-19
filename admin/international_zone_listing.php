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
		require_once(DIR_WS_MODEL . "InternationalZonesMaster.php");
		require_once(DIR_WS_ADMIN_LANGUAGES . DIR_CURRENT_LANGUAGE. '/international_zone.php');
		
		/**
	 	* Inclusion and Exclusion Array of Javascript
	 	*/
		$arr_css_plugin_include[] = 'datatables/css/jquery.dataTables.min.css';	
		$arr_javascript_plugin_include[] = 'datatables/js/jquery.dataTables.min.js';
		
	
		$ObjInternationalMaster	= new InternationalZonesMaster();
		$ObjInternationalMaster	= $ObjInternationalMaster->Create();
		$InternationalData		= new InternationalZonesData();
	

	
	
	
	$fieldArr = array("*");	
	$DataUser=$ObjInternationalMaster->getInternationalZones($fieldArr,null,null,$from,$to); // Fetch Data
	
	$message = $arr_message[$_GET['message']];  	
	
    if(!empty($message))
	{
		$err['message'] = specialcharaChk(valid_input($message));
	}
	
	if(!empty($err['message']))
	{
		logOut();
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo ADMIN_HEADER_INTERNATIONAL;?></title>
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
								<span><a href="<?php echo FILE_WELCOME_ADMIN; ?>"><?php echo ADMIN_HEADER_HOME;?></a> > <?php echo ADMIN_HEADER_POSTCODES; ?></span>
								<div><label class="top_navigation"><a onclick="mtrash('<?php echo FILE_INTERNATIONAL_ZONE_ACTION;?>','<?php echo ADMIN_USERS_DELETE_CONFIRM; ?>');"><?php echo COMMAN_DELETE; ?></a>
								<label class="top_navigation"><a href="<?php echo FILE_INTERNATIONAL_ZONE_ACTION; ?>"><?php echo ADMIN_POSTCODE_ADD_NEW ; ?></a>
								<a href="<?php echo FILE_INTERNATIONAL_ZONE_ACTION; ?>?Action=export_international_zone_csv"><?php echo ADMIN_POSTCODE_EXPORT_NEW ; ?></a>
								</label>
								
							
								</div>

								</td>
							</tr>
							<tr>
								<td class="heading">
								<?php echo ADMIN_HEADER_POSTCODES; ?>
								</td>
							</tr>
							<?php if($message!='') {?>
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
													 <th width="5%" align="center"> <input type="checkbox" name="m_trash_main" id="m_trash_all" > </th>
													<th width="5%" align="center"><?php echo ADMIN_COMMON_SERIAL_NO; ?></th>
													<th width="15%" align="center"><?php echo ADMIN_COUNTRY; ?></th>
													<th width="20%" align="center"><?php echo ADMIN_ZONE; ?></th>
													<th width="8%" align="center"><?php echo ADMIN_DAYS; ?></th>
													
													<th width="10%" align="center" ><?php echo ADMIN_COMMON_ACTION; ?></th>				
																
												</tr>
											</thead>
											<tbody>
												<?php
												 	if($DataUser!='') { 
												 		$i = 1;	
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
												<td align="center"> <input type="checkbox" name="m_trash" id="<?php echo $users_details['id'];?>"></td>
													<td align="center"><?php echo $i = 1 +$from;?></td>
													<td><?php echo valid_output($users_details['country']) ; ?></td>
													<td><?php echo valid_output($users_details['zone']);?></td>
													<td><?php echo valid_output($users_details['days']);?></td>
												
													<td align="center" nowrap="nowrap">
														<a href="<?php echo FILE_INTERNATIONAL_ZONE_ACTION; ?>?Action=edit&amp;Id=<?php echo $users_details['id'];?>"><?php echo COMMON_EDIT; ?></a> | 
														<a href="<?php echo FILE_INTERNATIONAL_ZONE_ACTION; ?>?Action=trash&amp;Id=<?php echo $users_details['id'].$URLParameters; ?>" onclick="return confirm('<?php echo ADMIN_USERS_DELETE_CONFIRM; ?>')"><?php echo COMMAN_DELETE; ?></a>												
													</td>
													
												</tr>
												<?php	 $from++;
												}
											 }?>
											</tbody>
											<tfoot>
												<tr>
													<th>&nbsp;</th>
													<th align="center"><?php echo ADMIN_COMMON_SERIAL_NO; ?>&nbsp;</th>
													<th align="center"><?php echo ADMIN_COUNTRY; ?>&nbsp;</th>
													<th align="center"><?php echo ADMIN_ZONE; ?>&nbsp;</th>
													<th align="center"><?php echo ADMIN_DAYS; ?>&nbsp;</th>
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
