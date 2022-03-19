<?php
	/**
	 * This file is for display all administrator
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
	  require_once(DIR_WS_MODEL."/CouponMaster.php");
	  require_once(DIR_WS_ADMIN_LANGUAGES . DIR_CURRENT_LANGUAGE. '/coupon.php');
	
	  $action	     = trim($_GET['action']);
	  if(!empty($_GET['action']))
		 {
			$err['action'] = chkStr(valid_input($_GET['action']));
		 }
	  if(!empty($err['action'])){
		logOut();
	  }
	  
	 
	  
		
	/**
	 * Inclusion and Exclusion Array of Javascript
	 */
	
    $arr_css_include[] = "jscalendar/calendar-blue.css";
	$arr_javascript_plugin_include[] = 'datatables/datatables.min.js';

	$arr_css_plugin_include[] = 'datatables/datatables.min.css';
	$arr_css_plugin_include[] = 'datatables/Buttons-1.6.5/css/buttons.dataTables.min.css';
	
    //This file included by shailesh jamanapara on date Wed Feb 20 19:46:03 IST 2013
	$arr_javascript_include[] = "masters_listing.php";
    	
	/**
	 * Coupon  Objects Declaration
	 */
	$ObjCouponData      = new CouponData();
	$ObjCouponMaster	= new CouponMaster();	
	$ObjCouponMaster	= $ObjCouponMaster->Create();	
	
	/**
	 * Variable Declaration and assignment
	 */
	$coupon_id=$_GET['coupon_id'];
	if(!empty($coupon_id))
	{
		$err['coupon_id'] = isNumeric(valid_input($coupon_id),ENTER_NUMERIC_VALUES_ONLY);
	}
	if(!empty($err['coupon_id']))
	{
		logOut();
	}
	
	$searchCoupon =trim($_GET['searchCoupon ']); // Searching Record
	if(!empty($_GET['searchCoupon']))
	{
		$err['searchCoupon'] = chkStr(valid_input($_GET['searchCoupon']));
	}
	if(!empty($err['searchCoupon']))
	{
		logOut();
	}
	$sDomainCoupon = CURRENT_SITE_ID;
	
	
	$message = $arr_message[$_GET['message']];            
	if(!empty($message))
	{
		$err['message'] = specialcharaChk(valid_input($message));
	}
	if(!empty($err['message']))
	{
		logOut();
	}	
	
		
	/**
	 * Create Link This variable are not pass in the url.
	 */
	// Not to Pass Variable Array
	$NotToPassQueryArray=array('coupon_id','Submit','message','Action');

	// Paramenters for the URL passing
	$NotToPassArray=$PreferencesObj->NotToPassQueryString($NotToPassQueryArray);
	$URLParameters=$PreferencesObj->GetAddressBarQueryString($NotToPassArray);
	if ($URLParameters!='') {
		$URLParameters="&".$URLParameters;
	}
	// End to create link
	
	if(!empty($_GET['changestatus']))
	{
		$err['changestatus'] = isNumeric(valid_input($_GET['changestatus']),ENTER_NUMERIC_VALUES_ONLY);
	}
	if(!empty($err['changestatus']))
	{
		logOut();
	}	
	/**
	 * change Status
	 */
	 
	if($action=='status' && $_GET['changestatus']!=''){
		
		$ObjCouponData->coupon_status = $_GET['changestatus'];
		$ObjCouponData->coupon_id = $coupon_id;
		$ObjCouponMaster->AlterStatus($ObjCouponData);
		$message = MSG_STATUS_SUCCESS;
        header('Location:coupon_listing.php'.$UParam);
        exit();
	}
	
	/**
	 * Start :: Delete Coupon
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
		$coupon_id = $_GET['deleteid'];
		$ObjCouponMaster->deleteCoupon($coupon_id);
		$message = MSG_DEL_SUCCESS;
		header('Location:coupon_listing.php'.$UParam);
        exit();
		
	}
	// End Delete
	
	
	/**
	 * Retrieving Data From Table
	 */
	
	$all_records = $ObjCouponMaster->getCoupon();
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo  ADMIN_COUPON_HEADING; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
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
			<?php require_once(DIR_WS_ADMIN_INCLUDES."/".ADMIN_FILE_HEADER);?>
		</td>
	</tr>
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
								<td align="left" class="breadcrumb">
								<span><a href="<?php echo FILE_WELCOME_ADMIN; ?>"><?php echo ADMIN_HEADER_HOME;?></a> > <?php echo ADMIN_COUPON_HEADING; ?></span>
								<div><label class="top_navigation"><a href="<?php echo FILE_ADMIN_COUPON_ADDEDIT; ?>"><?php echo ADMIN_ADD_HEADING; ?></a></label></div>
								</td>										
							</tr>
							<tr>	
								<td class="heading">
									<?php echo ADMIN_COUPON_HEADING; ?>
								</td>
							</tr>
							<?php if(!empty($message)) {?>
							<tr>
								<td class="message_success" align="center"><?php echo valid_output($message) ; ?></td>
							</tr>							
							<?php } ?>	
							
							<tr><td align="right" height="20"><a href="<?php echo FILE_ADMIN_COUPON; ?>"><b><?php echo ADMIN_COMMON_ALL_RECORDS; ?></b></a>&nbsp;&nbsp;</td></tr>		
							<tr>
								<td>
								
							<?php  /*** Start :: Listing Table ***/ ?>
									
									<div id="container">
									
										
										<table width="100%" align="center" cellspacing="0" cellpadding="0" class="display" id="maintable">
											<thead>
												<tr>
													<th width="6%" align="center" ><?php echo ADMIN_COMMON_SERIAL_NO;?></th>
													<th width="6%" align="center" ><?php echo COUPON_NAME;?></th>
													<th width="6%" align="center" ><?php echo COUPON_AMOUNT;?></th>
													<th width="6%" align="center" ><?php echo COUPON_CODE;?></th>
													<th width="14%" align="center" ><?php echo COUPON_TYPE;?></th>
													<th width="10%" align="center" ><?php echo COUPON_START_DATE;?></th>
													<th width="10%" align="center" ><?php echo COUPON_END_DATE;?></th>
													<th width="8%" align="center" ><?php echo STATUS;?></th>
													<th width="9%" align="center"><?php echo ADMIN_COMMON_ACTION;?></th>
												</tr>
											</thead>
											<tbody>
										<?php
										    if($all_records!='') { 
											$i = 1;	
											foreach ($all_records as $Record) { 
												$Status= ADMIN_COMMON_STATUS_INACTIVE;
								                $ChangeStatus = 1;
								                if($Record->coupon_status==1){
										            $Status=ADMIN_COMMON_STATUS_ACTIVE;
										            $ChangeStatus = 0 ;
								                }
								              //This array $arrCouponTypes created in common.php  by shailesh jamanapara on Date Tue May 28 15:51:49 IST 2013s
											?>
											<tr class="TableRow<?php echo $i%2; ?>">
												<td align="center"><? echo $i;?></td>
											<td><?php echo valid_output($Record->coupon_name);?></td>
											<td align="center"><?=$Record->coupon_amount;?></td>
											<td align="center"><?php echo valid_output($Record->coupon_code);?></td>
											<td align="center"><?php echo valid_output($arrCouponTypes[$Record->coupon_type]);?></td>
											<td align="center"><?=$Record->coupon_start_date;;?></td>
											<td align="center"><?=$Record->coupon_end_date;;?></td>
											<td align="center"><a href="<?php echo FILE_ADMIN_COUPON."?coupon_id=".$Record->coupon_id."&action=status&changestatus=".$ChangeStatus.$URLParameters; ?>" id="status"><?php echo $Status; ?></a></td>
											<td align="center">
											<a href="<?php echo FILE_ADMIN_COUPON_ADDEDIT;?>?coupon_id=<?php echo $Record['coupon_id'];?><?php echo $URLParameters; ?>"><?php echo COMMON_EDIT;?> </a>
											&nbsp;|&nbsp;<a href="<?php echo FILE_ADMIN_COUPON;?>?deleteid=<?php echo $Record['coupon_id'];?>&action=del<?php echo $URLParameters;?>" id="rowDelete" class="navlink2"><?php echo COMMAN_DELETE;?></a>
											
												</td>
											</tr>
										<?php
											$i++;
											}
										  }	
										?>
										</tbody>	
											
											<tfoot>
												<tr>
													<th><?php echo ADMIN_COMMON_SERIAL_NO;?>&nbsp;</th>
													<th align="left"><?php echo COUPON_NAME;?>&nbsp;</th>
													<th align="left"><?php echo COUPON_AMOUNT;?>&nbsp;</th>
													<th align="left"><?php echo COUPON_CODE;?>&nbsp;</th>
													<th><?php echo COUPON_TYPE;?>&nbsp;</th>
													<th><?php echo COUPON_START_DATE;?>&nbsp;</th>
													<th><?php echo COUPON_END_DATE;?>&nbsp;</th>
													<th><?php echo STATUS;?>&nbsp;</th>
													<th><?php echo ADMIN_COMMON_ACTION;?>&nbsp;</th>
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
		<td id="footer"><?php require_once(DIR_WS_ADMIN_INCLUDES."/".ADMIN_FILE_FOOTER);?></td>
	</tr>
</table>
</body>
</html>
