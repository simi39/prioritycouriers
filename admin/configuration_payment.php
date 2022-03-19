<?php
/**
 * This file is for payment method listing.
 *
 * @author     Radixweb <team.radixweb@gmail.com>
 * @copyright  Copyright (c) 2008, Radixweb
 * @version    1.0
 * @since      1.0
 */

/**
	 * Common File Inclusion
	 */
require_once("../lib/common.php");
require_once(DIR_WS_MODEL . "PaymentMethodMaster.php");
require_once(DIR_WS_ADMIN_LANGUAGES . DIR_CURRENT_LANGUAGE. '/configuration.php');
require_once(DIR_WS_PAYMENT."/payment.php");


/*** Inclusion and Exclusion Array of Javascript
 */
$arr_javascript_plugin_include[] = 'datatables/js/jquery.dataTables.min.js';
$arr_javascript_include[] = 'configuration_payment.php';

/**
	 * Inclusion and Exclusion Array of CSS
	 */
$arr_css_plugin_include[] = 'datatables/css/jquery.dataTables.min.css';	

/*csrf validation*/
$csrf = new csrf();
$csrf->action = "configuration_payment";
if(!isset($_POST['ptoken'])) {
	$ptoken = $csrf->csrfkey();
}

/*csrf validation*/
//$json = 'a:8:{s:17:"txt_pay_method_id";s:1:"2";s:10:"rbd_enable";s:1:"1";s:18:"payment_sort_order";s:1:"1";s:15:"sel_payment_env";s:1:"0";s:15:"txt_customer_id";s:8:"21256011";s:13:"payment_title";a:1:{i:1;s:12:"Eway Payment";}s:6:"ptoken";s:32:"66d3eddc960052eedf39feb84c175ea5";s:13:"btnsubmitship";s:4:"SAVE";}';

/**
	 * Object Declaration
	 */
$ObjPaymentMethodMaster = new PaymentMethodMaster();
$ObjPaymentMethodMaster = $ObjPaymentMethodMaster->create();
$ObjPaymentMethodData = new PaymentMethodData();

/**
	 *  Variable Declaration 
	 */
$payment_default_id = $_GET['payid'];
if(!empty($payment_default_id))
{
	$err['payment_default'] = isNumeric(valid_input($payment_default_id),ENTER_NUMERIC_VALUES_ONLY);
}
if(!empty($err['payment_default']))
{
	logOut();
}
$action = $_GET['action'];
if(!empty($action))
{
	$err['action'] = chkStr(valid_input($action));
}
if(!empty($err['action']))
{
	logOut();
}
$message = $arr_payment_message[$_GET['message']];
if(!empty($message))
{
	$err['message'] = specialcharaChk(valid_input($message));
}
if(!empty($err['message']))
{
	logOut();
}
$status = $_GET['status'];
if(!empty($status))
{
	$err['status'] = chkStr(valid_input($status));
}
if(!empty($err['status']))
{
	logOut();
}
if(isset($_POST[ELEMENT_BUTTON_SAVE])) {
	
	if(isEmpty(valid_input($_POST['ptoken']), true)){	
		logOut();
	}else{
		$csrf->checkcsrf($_POST['ptoken']);
	}
	$_POST=db_prepare_input($_POST);
	
	$PaymentDataArray = array();
	$PaymentDataId = valid_input($_POST['txt_site_payment_id']);	// If already exist, then used to be update
	$payment_method_id = $_POST[ELEMENT_PAYMENT_ID];		// Master Payment Method Id
	$enablePayment = $_POST[ELEMENT_ENABLE];		// Status of Payment Method
	$sort_order = $_POST['payment_sort_order'];
	$payment_title = $_POST['payment_title'][1];
	$err['enablePayment'] = isEmpty($enablePayment, ADMIN_ENABLE_PAYMENT_METHOD)?isEmpty($enablePayment, ADMIN_ENABLE_PAYMENT_METHOD):isNumeric(valid_input($enablePayment),ERROR_ENTER_NUMERIC_VALUE); 
	$err['paymentMethodId'] = isEmpty($payment_method_id, ADMIN_PAYMENT_ID_REQUIRED)?isEmpty($payment_method_id, ADMIN_PAYMENT_ID_REQUIRED):isNumeric(valid_input($payment_method_id),ERROR_ENTER_NUMERIC_VALUE); 
	$err['payment_title'] = isEmpty($payment_title, ADMIN_PAYMENT_TITLE_REQUIRED)?isEmpty($payment_method_id, ADMIN_PAYMENT_TITLE_REQUIRED):checkStr(valid_input($payment_title)); 
	if($_POST['sel_payment_env'] != '')
	{
		$err['sel_payment_env'] = isNumeric(valid_input($_POST['sel_payment_env']),ERROR_ENTER_NUMERIC_VALUE);
	}
	if(!empty($err['sel_payment_env']))
	{
		logOut();
	}
	if($_POST['rbd_enable'] != '')
	{
		$err['rbd_enable'] = isNumeric(valid_input($_POST['rbd_enable']),ERROR_ENTER_NUMERIC_VALUE);
	}
	if(!empty($err['rbd_enable']))
	{
		logOut();
	}
	if($PaymentDataId  != '')
	{
		$err['paymentdataid'] = isNumeric(valid_input($PaymentDataId),ERROR_ENTER_NUMERIC_VALUE);
	}
	if($_POST['txt_customer_id'] != '')
	{
		$err['customerid'] = isNumeric(valid_input($_POST['txt_customer_id']),ERROR_ENTER_NUMERIC_VALUE);
	}
	if($sort_order != '')
	{
		$err['sortOrder'] = isNumeric(valid_input($sort_order),ERROR_ENTER_NUMERIC_VALUE);
	}
	
	$PaymentMethodDetails = json_encode($_POST);		// Payment Method Details
	
	
	/**
		 * Data to be save in to table
		 */
	foreach($err as $key => $Value) {
		if($Value != '') {
			$Svalidation=true;
			$ptoken = $csrf->csrfkey();
		}
	}
	if($Svalidation == false)
	{
		
		$ObjPaymentMethodData->payment_method_id = $payment_method_id;
		$ObjPaymentMethodData->payment_details = $PaymentMethodDetails;
		$ObjPaymentMethodData->default_method = $defaultPayMethodId;
		$ObjPaymentMethodData->status = $enablePayment;
		$ObjPaymentMethodData->sort_order = $sort_order;
		$ObjPaymentMethodMaster->editPaymentMethod($ObjPaymentMethodData);
		header("Location:" . FILE_ADMIN_CONFIG_PAYMENT.'?message='.MSG_EDIT_SUCCESS);
		exit;
	}
		
}

/**
	 * change status
	 */
if(isset($payment_default_id)&& !empty($payment_default_id) && isset($_GET['action']) && $_GET['action']=='change_status'){
	$ObjPaymentMethodData->payment_method_id = $payment_default_id;
	$ObjPaymentMethodData->status = $status;
	$ObjPaymentMethodMaster->editPaymentMethod($ObjPaymentMethodData,true,'status');
	header("Location:" . FILE_ADMIN_CONFIG_PAYMENT.'?message='.MSG_EDIT_SUCCESS);
	exit;
}

/**
	 * Enable payment default selection
	 */
if($action == 'default' && !empty($payment_default_id)) {
	$ObjPaymentMethodData->payment_method_id = $payment_default_id;
	$ObjPaymentMethodData->default_method = 1;
	$ObjPaymentMethodMaster->editPaymentMethod($ObjPaymentMethodData, true, 'default_method');
}
$SortPaymentMethod = array();

$SortPaymentMethod[]	=	array("Order_By" => "status", "Order_Type" => "DESC");
$SortPaymentMethod[]	=	array("Order_By" => "sort_order", "Order_Type" => "ASC");
$PaymentMethodData = $ObjPaymentMethodMaster->GetPaymentMethod(null, null, $SortPaymentMethod);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo WELCOME_NOTE."-"."Payment Managment";?></title>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo HTML_CHARSET; ?>"/>
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
<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
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
					<td class="middle_right_content">
					<!-- Start :  Middle Content-->
						<table border="0" cellpadding="0" cellspacing="0" width="100%">
							<tr>
								<td class="heading">
									<?php echo $pageNameConst; ?>
								</td>
							</tr>
							<tr>
								<td class="breadcrumb">
									<span><a href="<?php echo FILE_WELCOME_ADMIN; ?>"><?php echo ADMIN_HEADER_HOME; ?></a> > <?php echo "Payment Management"; ?></span>
								</td>
							</tr>
							<tr>
								<td colspan="2" class="message_mendatory">
								<?php 
									
									if(isset($err))
									{
										foreach($err as $key => $Value) {
											if($Value != '') {
												echo $Value;
											}
										}
									}
								?>
								
								</td>
							</tr>
							
							<?php if(!empty($message)) { ?>							
							<tr>
								<td class="message_success" align="center"><?php echo valid_output($message) ; ?></td>
							</tr>							
							<?php } ?>							
							<tr>
								<td align="center">	
							<?php	/*shakti*/	 ?>	
							<?php  /*** Start :: Listing Table ***/ ?>
							
									<div id="container">

										
										<table width="100%" cellspacing="0" cellpadding="0" class="display" id="maintable">				
																	
										<thead>
											<tr>
												
												<th width="58%" align="center"><?php echo ADMIN_COMMON_PAYMENT_METHOD;?></th>
												<th width="15%" align="center"><?php echo ADMIN_COMMON_STATUS; ?></th>
												<th width="15%" align="center" class="noprint"><?php echo ADMIN_COMMON_DEFAULT; ?></th>
												<th width="10%" align="center" class="th_last_column"><?php echo ADMIN_COMMON_ACTION; ?></th>								
											</tr>
										</thead>
										<?php
										if($PaymentMethodData != '') {
											$i = 0; $no = 1;
											foreach ($PaymentMethodData as $PaymentMethods) {
												$paymentDetails = json_decode($PaymentMethods['payment_details'],true);

												/** Display title in listing from payment_title column for default language **/
												$paymentTitle = $paymentDetails['payment_title'][DEFAULT_LANGUAGE_ID];

												$selected_payment = '';
												if($PaymentMethods['default_method'] == 1) {
													$selected_payment = 'checked="checked"';
												}
												if($action == 'edit' && $PaymentMethods['payment_method_id'] == $payment_default_id) {
													$select_payment_method = $PaymentMethods;
												}
									     ?>
										<tbody>
											<tr>
													
											 	<!--<td align="left"><?php echo ucwords($PaymentMethods->payment_method_name); ?></td>-->
											 	<td align="left"><?php echo ucwords(valid_output($paymentTitle)); ?></td>
												<?php if($PaymentMethods['status']=='0') {
													$status_img = "<img class='pointer_cursor' onclick='change_status(".$PaymentMethodData[$i]['payment_method_id'].",1);' src='".INACTIVE_IMAGE."' alt='".ADMIN_PAYMENT_INACTIVE_IMG_ALT_TEXT."' title='".ADMIN_PAYMENT_INACTIVE_IMG_TITLE_TEXT."' >";
													$chk_status = ADMIN_COMMON_STATUS_INACTIVE;
												} else {
													$status_img = "<img class='pointer_cursor' onclick='change_status(".$PaymentMethodData[$i]['payment_method_id'].",0);' src='".ACTIVE_IMAGE."' alt='".ADMIN_PAYMENT_ACTIVE_IMG_ALT_TEXT."' title='".ADMIN_PAYMENT_ACTIVE_IMG_TITLE_TEXT."'>";
													$chk_status = ADMIN_COMMON_STATUS_ACTIVE;
													} ?>
												<?php if($PaymentMethods['default_method'] == 1) { ?>
														<td align="center"><?php  echo "----"?></td>
												<?php } else { ?>											    	
											    		<td align="center" id="td_status_<?php echo $PaymentMethods['payment_method_id'];?>"><input type="hidden" value="<?php echo $chk_status;?>" name="<?php echo $chk_status;?>"><?php if($PaymentMethods['status']=='0') {?>
				<a href="<?php echo FILE_ADMIN_CONFIG_PAYMENT . "?action=change_status&payid=" . $PaymentMethods['payment_method_id']."&status=1&#down"; ?>" ><?php echo $chk_status;?> </a>								
												<?php
												} else {?><a href="<?php echo FILE_ADMIN_CONFIG_PAYMENT . "?action=change_status&payid=" . $PaymentMethods['payment_method_id']."&status=0&#down"; ?>" ><?php echo $chk_status;?> </a>																
												<?php



												}?></td>

											    <?php } ?>												
												<?php if($PaymentMethods['status']=='0') { ?>
											    	<td align="center" class="noprint" id="td_default_<?php echo $PaymentMethods['payment_method_id'];?>"><?php echo draw_separator($sep_width,$sep_height);?></td>
											    <?php } else { ?>
											    	<td align="center" class="noprint" id="td_default_<?php echo $PaymentMethods['payment_method_id'];?>" ><input type="radio" name="rdbship" <?php echo $selected_payment; ?> echo value="<?php echo $PaymentMethods['payment_method_id']; ?>" onclick="javascript:document.location.href='<?php echo FILE_ADMIN_CONFIG_PAYMENT; ?>?message=es&action=default&payid='+this.value;return true;" ></td>
											   <?php  } ?>
												<td align="center" class="last_column action" valign="middle"><a href="<?php echo FILE_ADMIN_CONFIG_PAYMENT . "?action=edit&payid=" . $PaymentMethods['payment_method_id']."#down"; ?>" ><?php echo COMMON_EDIT;?> </a>
												</td>
												
											</tr>
										</tbody>
									<?php	$i++; $no++;
											}
									} else { ?>
										<tbody>
											<tr class="odd">
												<td align="left" class="listing_tr_left_top_co"><img src="<?php echo DIR_HTTP_ADMIN_IMAGES; ?>tr_left_bottom_co.gif"  border="0" /></td>
												<td colspan="4" class="message_warning last_column" align="center"><?php echo RECORDS_NOT_FOUND;?></td>
												
											</tr>
										</tbody>
										<?php }?>
									
										<tfoot>
											<tr>
												
												<th class="th_last_column" align="left"></th>
												<th class="th_last_column" align="left"></th>
												<th class="th_last_column" align="left"></th>
												<th class="th_last_column" align="left"></th>
												
											</tr>
										</tfoot>
									</table>
										
										
									</div>
									
							<?php  /*** End :: Listing Table ***/ ?>
							<?php	/*shakti*/	 ?>									
								</td>
							</tr>
							<tr>
								<td><a name="down"></a></td>
							</tr>
							<?php if($action =='edit') { ?>							
							<tr class="noprint">
								<td class="border">
								  <table border="0" cellpadding="0" cellspacing="0" width="100%" >							  		
										<tr>
											<td align="left" class="grayheader"><?php echo ADMIN_HEADER_PAYMENT_CONFIGURATION . " :- " .  ucwords($select_payment_method['payment_method_name']); ?></td>
										</tr>
										<tr>
											<td align="left">
												<?php createPaymentConfigForm($select_payment_method, $siteLanguage,$ptoken); ?>
											</td>
											
										</tr>
										
									</table>
								</td>
							</tr>						
							<?php } ?>
						</table>
					<!-- End :  Middle Content-->
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
<?php if(!empty($action) && !empty($payment_default_id)) { ?>
<script type="text/javascript">
<!--
var default_tab = <?php echo DEFAULT_LANGUAGE_ARRAY_ID; ?>;
var TabbedPanels1 = new Spry.Widget.TabbedPanels("TabbedPanels1");
TabbedPanels1.showPanel(default_tab);
//-->
</script>
<?php } ?>
</body>
</html>
