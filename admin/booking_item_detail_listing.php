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
	require_once(DIR_WS_MODEL . "PostCodeMaster.php");
	//require_once(DIR_WS_MODEL . "SameDayRatesMaster.php");
	require_once(DIR_WS_MODEL . "BookingItemDetailsMaster.php");
	require_once(DIR_WS_ADMIN_LANGUAGES . DIR_CURRENT_LANGUAGE. '/booking_item_detail.php');
	
	$arr_javascript_plugin_include[] = 'datatables/datatables.min.js';

	$arr_css_plugin_include[] = 'datatables/datatables.min.css';
	$arr_css_plugin_include[] = 'datatables/Buttons-1.6.5/css/buttons.dataTables.min.css';

	
	/**
	 * Start :: Object declaration
	 */
	$ObjBookingDetailsMaster	= new BookingItemDetailsMaster();
	$ObjBookingDetailsMaster	= $ObjBookingDetailsMaster->Create();
	$BookingItemDetailsData		= new BookingItemDetailsData();
	
	$message = $arr_message[$_GET['message']];            
	if(!empty($message))
	{
		$err['message'] = specialcharaChk(valid_input($message));
	}
	if(!empty($err['message']))
	{
		logOut();
	}	
	if($_GET['pagenum']!=''){
		$pagenum=$_GET['pagenum'];
	}else{
		$pagenum= 1;
	}
	if(!empty($pagenum))
	{
		$err['pagenum'] = isNumeric(valid_input($pagenum),ENTER_NUMERIC_VALUES_ONLY);
	}
	if(!empty($err['pagenum']))
	{
		logOut();
	}
	
	$fieldArr = array("*");	
	$DataUser=$ObjBookingDetailsMaster->getBookingItemDetails($fieldArr,null,$optArr,$from,$to,null,true); // Fetch Data
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo ADMIN_HEADER_BOOKING_ITEM; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<?php
addCSSFileAdmin($arr_css_admin_include, $arr_css_admin_exclude);
addJavaScriptFile($arr_javascript_include, $arr_javascript_exclude); 
addPluginCSSFile($arr_css_plugin_include,$arr_css_plugin_exclude);
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
								<span><a href="<?php echo FILE_WELCOME_ADMIN; ?>"><?php  echo  ADMIN_HEADER_HOME;?></a> > <?php echo ADMIN_HEADER_BOOKING_ITEM; ?></span>
								<div><label class="top_navigation"><a onclick="mtrash('<?php echo  FILE_BOOKING_ITEM_DETAILS_ACTION;?>','<?php echo ADMIN_USERS_DELETE_CONFIRM; ?>');"><?php echo COMMAN_DELETE; ?></a>
								<label class="top_navigation">
								<a href="<?php echo FILE_BOOKING_ITEM_DETAILS_ACTION; ?>"><?php echo ADMIN_ITEM_ADD_DETAIL ; ?></a>
								<a href="<?php echo FILE_BOOKING_ITEM_DETAILS_ACTION; ?>?Action=export_booking_item_detail_csv"><?php echo ADMIN_EXPORT_NEW ; ?></a>
								</label>
								
							
								</div>

								</td>
							</tr>
							<tr>
								<td class="heading">
								<?php echo ADMIN_HEADER_BOOKING_ITEM; ?>
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
												<th width="5%" align="center"> <input type="checkbox" name="m_trash_main" id="m_trash_all" > </th>
													<th width="5%" align="center"><?php echo Sr; ?></th>
													<th width="5%" align="center"><?php echo "booking id"; ?></th>
													<th width="15%" align="center"><?php echo ADMIN_ITEM_TYPE; ?></th>
													<th width="20%" align="center"><?php echo ADMIN_ITEM_QUANTITY; ?></th>
													<th width="8%" align="center"><?php echo ADMIN_ITEM_ITEM_WEIGHT; ?></th>
													<th width="5%" align="center"><?php echo ADMIN_ITEM_LENGTH; ?></th>
													<th width="5%" align="center"><?php echo ADMIN_ITEM_WIDTH; ?></th>
													<th width="5%" align="center"><?php echo ADMIN_ITEM_HEIGHT; ?></th>
													<th width="5%" align="center"><?php echo ADMIN_ITEM_VOL_WEIGHT; ?></th>
													<th width="10%" align="center" ><?php echo ADMIN_COMMON_ACTION; ?></th>				                                        </tr>
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
													<!--<td align="center"><?php ?></td>-->
													<td align="center"> <input type="checkbox" name="m_trash" id="<?php echo $users_details['auto_id'];?>"></td>
													<td align="center"><?php echo $i = 1+$from; ?></td>
													<td align="center"><?php echo $users_details->booking_id; ?></td>
													<td><?php echo valid_output($users_details->item_name); ?></td>
													<td><?php echo $users_details->quantity;?></td>
													<td><?php echo $users_details->item_weight?></td>
													<td><?php echo $users_details->length?></td>
													<td><?php echo $users_details->width?></td>
													<td><?php echo $users_details->height?></td>
                                                    <td><?php echo $users_details->vol_weight?></td>
													<td align="center" nowrap="nowrap">
														<a href="<?php echo FILE_BOOKING_ITEM_DETAILS_ACTION; ?>?pagenum=<?php echo $pagenum;?>&Action=edit&amp;id=<?php echo $users_details['auto_id'];?>"><?php echo COMMON_EDIT; ?></a> | <a href="<?php echo FILE_BOOKING_ITEM_DETAILS_ACTION; ?>?pagenum=<?php echo $pagenum;?>&Action=trash&amp;id=<?php echo $users_details['auto_id'].$URLParameters; ?>" onclick="return confirm('<?php echo ADMIN_USERS_DELETE_CONFIRM; ?>')"><?php echo COMMAN_DELETE; ?></a>
													</td>
												</tr>
												<?php 
														 $from = $from+1;
														}  
}
												?>
												<!--<?php	
											 ?>-->
											</tbody>
											<tfoot>
												<tr>
													<th>&nbsp;</th>
													<th><?php echo Sr; ?>&nbsp;</th>
													<th align="center"><?php echo "booking id"; ?>&nbsp;</th>
													
													<th align="center"><?php echo ADMIN_ITEM_TYPE; ?>&nbsp;</th>
													<th align="center"><?php echo ADMIN_ITEM_QUANTITY; ?>&nbsp;</th>
													<th align="center"><?php echo ADMIN_ITEM_ITEM_WEIGHT; ?>&nbsp;</th>
													<th align="center"><?php echo ADMIN_ITEM_LENGTH; ?>&nbsp;</th>
													<th align="center"><?php echo ADMIN_ITEM_WIDTH; ?>&nbsp;</th>
													<th align="center"><?php echo ADMIN_ITEM_HEIGHT; ?>&nbsp;</th>
													<th align="center"><?php echo ADMIN_ITEM_VOL_WEIGHT; ?>&nbsp;</th>
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
	<tr>
	<td>
	
	</td>
	</tr>
<!-- End Middle Content part -->
	<tr>
		<td id="footer"><?php require_once(DIR_WS_ADMIN_INCLUDES . ADMIN_FILE_FOOTER);?></td>
	</tr>
</table>
</body>
</html>
