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
		require_once(DIR_WS_MODEL . "tracking_evantMaster.php");
		require_once(DIR_WS_ADMIN_LANGUAGES . DIR_CURRENT_LANGUAGE. '/tracking_evant.php');
		
		/**
	 	* Inclusion and Exclusion Array of Javascript
	 	*/
		$arr_css_plugin_include[] = 'datatables/css/jquery.dataTables.min.css';	
		$arr_javascript_plugin_include[] = 'datatables/js/jquery.dataTables.min.js';
		
		
		$ObjKmGridMaster	= new tracking_evantMaster();
		$ObjKmGridMaster	= $ObjKmGridMaster->Create();
		$KmGridData		= new tracking_evantData();
		
	
	
	
	$message = $arr_message[$_GET['message']];            
	if(!empty($message))
	{
		$err['message'] = specialcharaChk(valid_input($message));
	}
	if(!empty($err['message']))
	{
		logOut();
	}
	$fieldArr = array("*");	

	$DataUser=$ObjKmGridMaster->gettracking_evant($fieldArr, null,null,null,null, true, true);
	  	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo ADMIN_HEADER_TRACKING; ?></title>
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
								<span><a href="<?php echo FILE_WELCOME_ADMIN; ?>"><?php echo ADMIN_HEADER_HOME;?></a> > <?php echo ADMIN_HEADER_KM_GRID; ?></span>
								<div><label class="top_navigation"><a onclick="mtrash('<?php echo  FILE_TRACKING_EVANT_ACTION;?>','<?php echo ADMIN_USERS_DELETE_CONFIRM; ?>');"><?php echo COMMAN_DELETE; ?></a>
								<label class="top_navigation"><a href="<?php echo FILE_TRACKING_EVANT_ACTION; ?>"><?php echo ADMIN_ADD_NEW ; ?></a>
								<a href="<?php echo FILE_TRACKING_EVANT_ACTION; ?>?Action=export"><?php echo ADMIN_EXPORT_NEW ; ?></a></label>
							
								</div>

								</td>
							</tr>
							<tr>
								<td class="heading">
								<?php echo ADMIN_HEADER_TRACKING; ?>
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
												<th width="5%" align="center"> <input type="checkbox" name="m_trash_main" id="m_trash_all" > </th>
													<th width="5%" align="center"><?php echo ADMIN_COMMON_SERIAL_NO; ?></th>
													<th width="15%" align="center"><?php echo EVENT_ID; ?></th>
													<th width="15%" align="center"><?php echo DESCRIPTION; ?></th>
													<th width="5%" align="center"><?php echo ACTION; ?></th>
													
																
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
												<td align="center"> <input type="checkbox" name="m_trash" id="<?php echo $users_details['tracking_evant_id'];?>"></td>
													<td align="center"><?php echo $i = 1 +$from;?></td>
													<td><?php echo valid_output($users_details['eventid']); ?></td>
													<td><?php echo valid_output($users_details['description']); ?></td>
													
													
													
													<td align="center" nowrap="nowrap">
														<a href="<?php echo FILE_TRACKING_EVANT_ACTION; ?>?Action=edit&amp;tracking_evant_id=<?php echo $users_details['tracking_evant_id'];?>"><?php echo COMMON_EDIT; ?></a> | <a href="<?php echo FILE_TRACKING_EVANT_ACTION; ?>?pagenum=<?php echo  $pagenum;?>&Action=trash&amp;tracking_evant_id=<?php echo $users_details['tracking_evant_id'].$URLParameters; ?>" onclick="return confirm('<?php echo ADMIN_USERS_DELETE_CONFIRM; ?>')"><?php echo COMMAN_DELETE; ?></a>
														
																											
													</td>
													
												</tr>
												<?php	$from = $from+1;
												}
											 }?>
											</tbody>
											<tfoot>
												<tr>
													<th>&nbsp;</th>
													<th align="center"><?php echo ADMIN_COMMON_SERIAL_NO; ?>&nbsp;</th>
													<th align="center"><?php echo EVENT_ID; ?>&nbsp;</th>
													<th align="center"><?php echo DESCRIPTION; ?>&nbsp;</th>
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
