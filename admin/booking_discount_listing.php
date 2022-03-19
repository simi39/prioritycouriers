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
		require_once(DIR_WS_MODEL . "BookingDiscountDetailsMaster.php");
		require_once(DIR_WS_MODEL . "InternationalZonesMaster.php");
		require_once(DIR_WS_ADMIN_LANGUAGES . DIR_CURRENT_LANGUAGE. '/booking_discount.php');
		
		if(!empty($_GET['action']))
		{
			$err['action'] = chkStr(valid_input($_GET['action']));
		}
		if(!empty($err['action']))
		{
			logOut();
		}
		
		if(isset($_GET['action']) && $_GET['action']=='change_paging_count' && !empty($pagenum)){
			unset($_SESSION['total_rows']);
			$page_rows = $_GET['total_rows'];
			$_SESSION['total_rows'] = $page_rows; 
		}
		
		
		//require_once(DIR_WS_ADMIN_LANGUAGES . DIR_CURRENT_LANGUAGE. '/user.php');
		
		
	
		
		//This file included by shailesh jamanapara on date Wed Feb 20 19:22:30 IST 2013
		$arr_javascript_include[] = "masters_listing.php";
	

		$ObjBookingDsiDetMaster		= new BookingDiscountDetailsMaster();
		$ObjBookingDsiDetMaster		= $ObjBookingDsiDetMaster->create();
		$ObjBookingDiscountData		= new BookingDiscountDetailsData();
		$InternationalZoneMasterObj = new InternationalZonesMaster();
		$InternationalZoneMasterObj = $InternationalZoneMasterObj->create();
		$InternationalZoneData = new InternationalZonesData();
		
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
	$paymentStatus = array('true'=>"Done","false"=>"Pending");
	$discountStatus = array(0=>"Pending",1 =>"Under verification",2=>"Verification Approved",3 =>"Rejected");
	$fieldArr 	= array("booking_discount_details.auto_id,
						booking_discount_details.user_id,
						booking_discount_details.booking_id,
						booking_discount_details.booking_amt,
						booking_discount_details.coupon_id,
						booking_discount_details.coupon_amt,
						booking_discount_details.nett_due_amt,
						booking_discount_details.verified_status,
						booking_details.tracking_status, 	
						booking_details.payment_done, 
						booking_details.rate,
						booking_details.sender_first_name,
						booking_details.sender_surname"
						);	
	$seaArr = array();
	$optArr =array();
	$optArr[]	=	array("Order_By" => "booking_discount_details.auto_id",
			 								"Order_Type" => "DESC");
	$DataUser=$ObjBookingDsiDetMaster->getBookingDiscountListDetails($fieldArr,$seaArr, $optArr, $start, $total,true);
	  	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo TITLE; ?></title>
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
								<span><a href="<?php echo FILE_WELCOME_ADMIN; ?>"><?php echo ADMIN_HEADER_HOME;?></a> > <?php echo ADMIN_HEADER_BOOKING_DISCOUNT_DETAIL; ?></span>
								<div><label class="top_navigation"><a onclick="mtrash('<?php echo  FILE_BOOKING_DETAILS_ACTION;?>','<?php echo ADMIN_USERS_DELETE_CONFIRM; ?>');"><?php echo COMMAN_DELETE; ?></a>
								<label class="top_navigation"><a href="<?php echo FILE_BOOKING_DETAILS_ACTION; ?>"><?php echo ADMIN_ADD_NEW ; ?></a>
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
													<th width="4%"  style="width: 60px;" align="center"><?php  echo 'Booking#'; ?></th>
													<th width="4%" align="center"><?php  echo 'Due Amount($)'; ?></th>
													<th width="4%" align="center"><?php  echo 'Coupon #'; ?></th>
													<th width="4%" align="center"><?php  echo 'Discount Amount($)'; ?></th>		
													<th width="4%" align="center" ><?php echo 'Nett Due Amount'; ?></th>		
													<th width="4%" align="center" ><?php echo 'Booking Status'; ?></th>		
													<th width="4%" align="center"><?php  echo 'Payment'; ?></th>
													<th width="4%" align="center"><?php echo 'Discount Status'; ?></th>
													<th width="40%" align="center"><?php echo 'User Name'; ?></th>		
													<th width="10%" align="center" ><?php echo 'Action'; ?></th>		
													
																
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
													<td align="center"><?php echo $i = 1 +$from;?></td>
													<td><?php echo $users_details['booking_id'];?></td>
													<td align="right"><?php echo floatval($users_details['booking_amt']);?></td>
													<td align="right"><?php echo $users_details['coupon_id'];?></td>
													<td align="right"><?php echo floatval($users_details['coupon_amt']);?></td>
													<td align="right"><?php echo floatval($users_details['nett_due_amt']);?></td>
													<td align="center"><?php echo valid_output($users_details['tracking_status']);?></td>
													<td align="center"><?php echo valid_output($paymentStatus[$users_details['payment_done']]);?></td>
													<td align="center"><?php echo valid_output($discountStatus[$users_details['verified_status']]);?></td>
													<td align="left"><?php echo valid_output($users_details['sender_surname']) . " ". valid_output($users_details['sender_first_name']);?></td>
													<td align="center" nowrap="nowrap">
														<a href="<?php echo FILE_BOOKING_DISCOUNT_ACTION; ?>?Action=edit&amp;booking_id=<?php echo $users_details['booking_id'];?>"><?php echo COMMON_EDIT; ?></a> | <a href="<?php echo FILE_BOOKING_DISCOUNT_ACTION; ?>?Action=trash&amp;booking_id=<?php echo $users_details['booking_id'].$URLParameters; ?>" onclick="return confirm('<?php echo ADMIN_USERS_DELETE_CONFIRM; ?>')"><?php echo COMMAN_DELETE; ?></a>
														
																											
													</td>
													
												</tr>
												<?php	$from = $from+1;
												}
											 }?>
											</tbody>
											<tfoot>
												<tr>
													<th>&nbsp;</th>					<!--<th align="center">&nbsp;</th>-->
													<th><?php  echo 'Booking#'; ?>&nbsp;</th>
													<th><?php  echo 'Due Amount($)'; ?>&nbsp;</th>
													<th align="center"><?php  echo 'Coupon #'; ?>&nbsp;</th>
													<th align="center"><?php  echo 'Discount Amount($)'; ?>&nbsp;</th>
													<th align="center"><?php echo 'Nett Due Amount'; ?>&nbsp;</th>
													<th align="center"><?php echo 'Booking Status'; ?>&nbsp;</th>
													<th align="center"><?php  echo 'Payment'; ?>&nbsp;</th>
													<th align="center"><?php echo 'Discount Status'; ?>&nbsp;</th>
													<th align="center"><?php echo 'User Name'; ?>&nbsp;</th>
													<th align="center"><?php echo 'Action'; ?>&nbsp;</th>
													
													
						
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
