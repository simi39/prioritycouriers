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
	require_once(DIR_WS_MODEL . "BookingDetailsMaster.php");
	require_once(DIR_WS_MODEL ."CountryMaster.php");
	require_once(DIR_WS_ADMIN_LANGUAGES . DIR_CURRENT_LANGUAGE. '/booking_detail.php');
	
	
	$ObjBookingDetailsMaster	= new BookingDetailsMaster();
	$ObjBookingDetailsMaster	= $ObjBookingDetailsMaster->Create();
	$BookingDetailsData		= new BookingDetailsData();
	$CountryMasterObj = new CountryMaster();
	$CountryMasterObj = $CountryMasterObj->Create();
	//$InternationalZoneData = new InternationalZonesData();
		
	$arr_javascript_plugin_include[] = 'datatables/datatables.min.js';

	$arr_css_plugin_include[] = 'datatables/datatables.min.css';
	$arr_css_plugin_include[] = 'datatables/Buttons-1.6.5/css/buttons.dataTables.min.css';
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
	$fieldArr = array("*");	
	$optArr = array();
	$optArr[]	=	array("Order_By" => "booking_id",
						  "Order_Type" => "DESC");
	$DataUser=$ObjBookingDetailsMaster->getBookingDetails(null,null,$optArr,$from,$to);
	  	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo ADMIN_HEADER_BOOKING_DETAIL;?></title>
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
								<span><a href="<?php echo FILE_WELCOME_ADMIN; ?>"><?php echo ADMIN_HEADER_HOME;?></a> > <?php echo ADMIN_HEADER_BOOKING_DETAIL; ?></span>
								<div><label class="top_navigation"><a onclick="mtrash('<?php echo  FILE_BOOKING_DETAILS_ACTION;?>','<?php echo ADMIN_USERS_DELETE_CONFIRM; ?>');"><?php echo COMMAN_DELETE; ?></a>
								<label class="top_navigation"><!--<a href="<?php echo FILE_BOOKING_DETAILS_ACTION; ?>"><?php echo ADMIN_ADD_NEW ; ?>--></a>
								<a href="<?php echo FILE_BOOKING_DETAILS_ACTION; ?>?Action=export"><?php echo ADMIN_EXPORT_NEW ; ?></a></label>
							
								</div>

								</td>
							</tr>
							<tr>
								<td class="heading">
								<?php echo ADMIN_HEADER_BOOKING_DETAIL; ?>
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
													<th width="5%" align="center"><?php echo CCCONNOTE; ?></th>
													<th width="15%" align="center"><?php echo PICKUP_FROM; ?></th>
													<th width="20%" align="center"><?php echo DILIVER_TO; ?></th>		
													<th width="10%" align="center"><?php echo SERVICE; ?></th>		
													<th width="5%" align="center"><?php echo DATE_READY; ?></th>
													<th width="15%" align="center"><?php echo TIME_READY; ?></th>
													<th width="20%" align="center"><?php echo BOOKING_DATE; ?></th>		
													<th width="10%" align="center" ><?php echo BOOKING_TIME; ?></th>		
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
												<td align="center"> <input type="checkbox" name="m_trash" id="<?php echo $users_details['booking_id'];?>"></td>
													<td align="center"><?php echo $i = 1 +$from;?></td>
													<td align="center"><?php echo $users_details['CCConnote'];?></td>
													<td><?php echo valid_output($users_details['pickupid']); ?></td>
													<td><?php 
													
													$fieldArrforCountryName  = array("countries_name");
													$countries_id = $users_details['deliveryid'];
													if(is_numeric($users_details['deliveryid'])){
														$seaArr[0] = array('Search_On'    => 'countries_id',
																		  'Search_Value' => $countries_id,
																		  'Type'         => 'string',
																		  'Equation'     => '=',
																		  'CondType'     => 'AND',
																		  'Prefix'       => '',
																		  'Postfix'      => ''); 
													$CountryDataObj=$CountryMasterObj->getCountry('null',$seaArr);
													$CountryDataObj=$CountryDataObj[0];
													
													echo $users_details['deliveryid'] = $CountryDataObj['countries_name'];
													}else{
														echo valid_output($users_details['deliveryid']);
													}
													
																								
													?>
													
													
													</td>
													<td><?php echo valid_output($users_details['service_name']);?></td>
													
													<td><?php echo valid_output($users_details['date_ready']);?></td>
													<td><?php echo valid_output($users_details['time_ready']);?></td>
													<td><?php echo valid_output($users_details['booking_date']);?></td>
													<td><?php echo valid_output($users_details['booking_time']);?></td>
													
													<td align="center" nowrap="nowrap">
														<a href="<?php echo FILE_BOOKING_DETAILS_ACTION; ?>?Action=edit&amp;auto_id=<?php echo $users_details['auto_id'];?>"><?php echo COMMON_EDIT; ?></a> | <a href="<?php echo FILE_BOOKING_DETAILS_VIEW; ?>?auto_id=<?php echo $users_details['auto_id'];?>"><?php echo VIEW_BOOKING_DETAILS; ?></a> | <a href="<?php echo FILE_BOOKING_DETAILS_ACTION; ?>?Action=trash&amp;auto_id=<?php echo $users_details['auto_id'].$URLParameters; ?>" onclick="return confirm('<?php echo ADMIN_USERS_DELETE_CONFIRM; ?>')"><?php echo COMMAN_DELETE; ?></a>
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
													<th>&nbsp;</th>
													<th align="center"><?php echo PICKUP_FROM; ?>&nbsp;</th>
													<th align="center"><?php echo DILIVER_TO; ?>&nbsp;</th>
													
													<th align="center"><?php echo SERVICE; ?>&nbsp;</th>
													<th align="center"><?php echo DATE_READY; ?>&nbsp;</th>
													<th align="center"><?php echo TIME_READY; ?>&nbsp;</th>
													<th align="center"><?php echo BOOKING_DATE; ?>&nbsp;</th>
													<th align="center"><?php echo BOOKING_TIME; ?>&nbsp;</th>
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
