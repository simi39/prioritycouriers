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
        require_once('pagination_top.php');
		require_once(DIR_WS_MODEL . "PostCodeMaster.php");
		require_once(DIR_WS_MODEL . "BookingCancelMaster.php");
        require_once(DIR_WS_RELATED . "system_mail.php");
      // require_once(DIR_WS_ADMIN_LANGUAGES . DIR_CURRENT_LANGUAGE. '/booking_item_detail.php');
        require_once(DIR_WS_ADMIN_LANGUAGES . DIR_CURRENT_LANGUAGE. '/booking_cancel.php');
     
    
/**
	 * Start :: Object declaration
	 */
		$ObjBookingCancelMaster	= new BookingCancelMaster();
		$ObjBookingCancelMaster	= $ObjBookingCancelMaster->Create();
		$BookingCancelData		= new BookingCancelData();
	  
	  /*csrf validation*/
		$csrf = new csrf();
		$csrf->action = "booking_cancel_action";
		if(!isset($_POST['ptoken'])) {
			$ptoken = $csrf->csrfkey();
		}
		

		
		/*csrf validation*/

/**
	 * Inclusion and Exclusion Array of Javascript
	 */
$arr_javascript_include[] = "postcode_action.php";
$arr_css_plugin_include[] = 'datatables/css/jquery.dataTables.min.css';	
		$arr_javascript_plugin_include[] = 'datatables/js/jquery.dataTables.min.js';
$pagenum = ($_GET['pagenum']!="")?($_GET['pagenum']):(1);
if(!empty($pagenum))
{
	$err['pagenum'] = isNumeric(valid_input($pagenum),ENTER_NUMERIC_VALUES_ONLY);
}
if(!empty($err['pagenum']))
{
	logOut();
}

/*$max_id = mysql_query("select max(auto_id) as Id from postcode_locator");
$maximum_id = mysql_fetch_array($max_id);*/
/**
	 * Variable Declaration
	 */
$btnSubmit = ADMIN_BUTTON_SAVE_POSTCODE;
$HeadingLabel ="Save Booking Cancel Detail";
$HeadingEditLabel="Edit Booking Cancel Detail";
$auto_id = $_GET['id'];
//echo $auto_id;
//exit();
if(!empty($auto_id))
{
	$err['auto_id'] = isNumeric(valid_input($auto_id),ENTER_NUMERIC_VALUES_ONLY);
}
if(!empty($err['auto_id']))
{
	logOut();
}

if($_GET['Action']=='trash'){
	$ObjBookingCancelMaster->deleteBookingCancel($auto_id);
	$UParam = "?pagenum=".$pagenum."&message="."Booking Cancel Delete Successfully";
	header('Location:'.FILE_BOOKING_CANCEL_LISTING.$UParam);
}
if($_GET['Action']=='mtrash'){
$auto_id= $_GET['m_trash_id'];
	$m_t_a=explode(",",$auto_id);
	foreach($m_t_a as $val)
	{
		$error = isNumeric(valid_input($val),ENTER_NUMERIC_VALUES_ONLY);
		if(!empty($error))
		{
			logOut();
		}else
		{
			$ObjBookingCancelMaster->deleteBookingCancel($val);
		}
	}
	$UParam = "?pagenum=".$pagenum."&message=".MSG_DELETE_ITEM_SUCCESS;
	header('Location:'.FILE_BOOKING_CANCEL_LISTING.$UParam);
}



if((isset($_POST['submit']) && $_POST['submit'] != "")){
		
		if(isEmpty(valid_input($_POST['ptoken']), true)){	
				logOut();
		}else{
			//$csrf->checkcsrf($_POST['ptoken']);
		}
		$err['booking_id']  = isEmpty($_POST['booking_id'], QUANTITY_IS_REQUIRED)?isEmpty($_POST['booking_id'], QUANTITY_IS_REQUIRED):isNumeric($_POST['booking_id'],ENTER_VALUE_IN_NUMERIC);
		$err['Approved'] 	= isEmpty(trim($_POST['Approved']), ITEM_WEIGHT_REQUIRED)?isEmpty(trim($_POST['Approved']), ITEM_WEIGHT_REQUIRED):isNumeric($_POST['Approved'],ENTER_VALUE_IN_NUMERIC);
		$err['Id'] = isEmpty(trim($_POST['Id']), LENGTH_IS_REQUIRED)?isEmpty(trim($_POST['Id']), LENGTH_IS_REQUIRED):isNumeric($_POST['Id'],ENTER_VALUE_IN_NUMERIC);
		
		foreach($err as $key => $Value) {
			if($Value != '') {
				$Svalidation=true;
				$ptoken = $csrf->csrfkey();
			}
		}
		if($Svalidation==false){
			$BookingCancelData->Approved = trim($_POST['Approved']);		
			$BookingCancelData->booking_id=trim($_POST['booking_id']);

			if($_POST['Id']!=''){
				//Edit Users
				$BookingCancelData->cancellation_id = $_POST['Id'];

				$ObjBookingCancelMaster->editBookingCancel($BookingCancelData);
				$UParam = "?pagenum=".$pagenum."&message=".MSG_EDIT_ITEM_SUCCESS;
			}else{
				$insertedauto_id = $ObjBookingDetailsMaster->addBookingItemDetails($BookingItemDetailsData);
				$UParam = "?pagenum=".$pagenum."&message=".MSG_ADD_ITEM_SUCCESS;
				
			}
			header('Location:'.FILE_BOOKING_CANCEL_LISTING.$UParam);
		}else{
			logOut();
		}
	

}
/**
	 * Gets details for the user
	 */
if($auto_id!=''){
	$fieldArr=array("*");
	$seaByArr[]=array('Search_On'=>'cancellation_id', 'Search_Value'=>"$auto_id", 'Type'=>'int', 'Equation'=>'LIKE', 'CondType'=>'and', 'Prefix'=>'', 'Postfix'=>'');
    $DataCancelBooking=$ObjBookingCancelMaster->getBookingCancel($fieldArr, $seaByArr); // Fetch Data
	$DataCancelBooking=$DataCancelBooking[0];
    
   
   
	//Get sign up Address
    //Variable declaration
    $btnSubmit = ADMIN_BUTTON_UPDATE_POSTCODE;
	$HeadingLabel = ADMIN_LINK_UPDATE_POSTCODE;
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php if ($_GET['auto_id']=='') { echo ADMIN_ADD_USER; } else { echo ADMIN_EDIT_USER;}?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
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
					<!-- Start :  Middle Content-->
						<table class="middle_right_content" align="center" border="0" cellpadding="0" cellspacing="0">
							<tr>
								<td align="left" class="breadcrumb">
										<span><a href="<?php echo FILE_WELCOME_ADMIN; ?>"><?php echo ADMIN_HEADER_HOME; ?></a> > <a href="<?php echo FILE_BOOKING_CANCEL_LISTING; ?>"> <?php echo ADMIN_HEADER_DETAIL; ?> </a> > 
										<? if ($_GET['Action']=='edit') {
											echo "$HeadingEditLabel" ;
										} else {
											echo $HeadingLabel;
										}
											?>

										</span>
										<div><label class="top_navigation"><a href="<?php echo FILE_BOOKING_CANCEL_LISTING; ?>"><?php echo ADMIN_COMMON_BACK; ?></a></label></div>
								</td>
							</tr>
							<tr>
								<td class="heading">
									<? if ($_GET['Action']=='edit') {
											echo "$HeadingEditLabel" ;
										} else {
											echo $HeadingLabel;
										}
											?>
								</td>
							</tr>
							        
											
											<?php
											if($message!='')
											{ ?>
											<tr>
				<td class="message_error noprint" align="center"><?php echo valid_output($arr_message[$message]); ?></td>
											</tr>
											
											
											
											<?php }   ?>			
												
											
							
							<tr>
								<td align="center">
									<?php  /*** Start :: Listing Table ***/ ?>
									<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
										
										<form name="frmuser" method="POST"  action="">
										<input type="hidden" name="Id" value="<?php echo $DataCancelBooking['cancellation_id'];?>"  />
										<input type="hidden" name="booking_id" value="<?php echo $DataCancelBooking['booking_id'];?>"  />
										<tr>
											<td>
												<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
													<tr>
														<td>
															<table width="98%" border="0" cellpadding="0" border="0" cellspacing="0" >
																<tr>
																	<td class="message_mendatory" align="right" colspan="4">
																		<?echo ADMIN_COMMAN_REQUIRED_INFO;?>
																	</td>
																</tr>
																<tr>
																	<td colspan="4" align="left" valign="top" class="grayheader"><b><?php echo "Booking Cancel Detail";?> : </b></td>
																</tr>
																<tr><td colspan="4">&nbsp;</td></tr>
																<tr>
																	<td align="left" valign="middle"  nowrap="nowrap"><?php echo "Booking Cancel Id";?></td>
																	<td  align="left" valign="middle"> <?php echo $DataCancelBooking['cancellation_id']; ?></td>
																
																</tr>
																<tr><td colspan="4">&nbsp;</td></tr>
																<tr>
																	<td align="left" valign="middle"  nowrap="nowrap"><?php echo "Booking Id";?></td>
																	<td  align="left" valign="middle"> <?php echo $DataCancelBooking['CCConnote']; ?></td>
																
																</tr>
																<tr><td colspan="4">&nbsp;</td></tr>
																<tr>
																	<td align="left" valign="middle"  nowrap="nowrap"><?php echo "Status";?></td>
																	<td  align="left" valign="middle" class="message_mendatory">
																	<select name="Approved" id="Approved">
																	<option selected value="0" <?php if($DataCancelBooking['Approved']==0) { echo "selected"; } ?>>Not Approved</option>
																	<option value="1" <?php if($DataCancelBooking['Approved']==1) { echo "selected"; } ?>>Approved</option>																	
																	</select></td>
														
																</tr>
																
																
																
															
																												
															</table>
														</td>
													</tr>
													<tr>
														<td>&nbsp;</td>
													</tr>
												
												</table>
											</td>
										</tr>
										<tr>
											<td>&nbsp;</td>
										</tr>
										<tr>
											<td align="center">
											<?php if ($_GET['Action']=='edit') { ?>
											<input type="submit" class="action_button" tabindex="36" name="submit" value="<?php echo "$btnSubmit";  ?>"  >
<? } else { ?>
<input type="submit" class="action_button" tabindex="36" name="submit" value="<?php echo "submit items";  ?>" onclick="return validate_client(this.form);" > <?php } ?>
											<input type="reset" tabindex="37" name="reset" class="action_button" value="<?php echo ADMIN_COMMON_BUTTON_RESET; ?>" >
											<input type="hidden" size="34" id="ptoken" value="<?php echo $ptoken; ?>" name="ptoken">
											<input type="button"  class="action_button" name="cancel" tabindex="38" value="<?php echo ADMIN_COMMON_BUTTON_CANCEL;?>" onclick="javascript:document.location.href='<?php echo FILE_BOOKING_CANCEL_LISTING."?pagenum=".$pagenum; ?>';return true;"/>
											</td>
										</tr>
										<tr>
											<td>&nbsp;</td>
										</tr>
										</form>
									</table>
									<?php  /*** End :: Listing Table ***/ ?>
								</td>
							</tr>
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
</body>
</html>

