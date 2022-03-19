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
		require_once(DIR_WS_MODEL . "BookingItemDetailsMaster.php");
        require_once(DIR_WS_RELATED."system_mail.php");
       require_once(DIR_WS_ADMIN_LANGUAGES . DIR_CURRENT_LANGUAGE. '/booking_item_detail.php');
     
     require_once(DIR_WS_MODEL . "ItemTypeMaster.php");
/**
	 * Start :: Object declaration
	 */
		$ObjPostCodeMaster	= new PostCodeMaster();
		$ObjPostCodeMaster	= $ObjPostCodeMaster->Create();
		$PostCodeData		= new PostCodeData();
		$ObjBookingDetailsMaster	= new BookingItemDetailsMaster();
		$ObjBookingDetailsMaster	= $ObjBookingDetailsMaster->Create();
	    $BookingItemDetailsData		= new BookingItemDetailsData();
		$ObjItemTypeMaster	= new ItemTypeMaster();
		$ObjItemTypeMaster	= $ObjItemTypeMaster->Create();
	    $ItemTypeMasterData		= new ItemTypeData();
		
		/*csrf validation*/
		$csrf = new csrf();
		$csrf->action = "booking_item_detail_action";
		if(!isset($_POST['ptoken'])) 
		{
			$ptoken = $csrf->csrfkey();
		}
		

		
		/*csrf validation*/

/**
	 * Inclusion and Exclusion Array of Javascript
	 */
$arr_javascript_include[] = "postcode_action.php";
$arr_javascript_plugin_include[] = 'datatables/datatables.min.js';

$arr_css_plugin_include[] = 'datatables/datatables.min.css';
$arr_css_plugin_include[] = 'datatables/Buttons-1.6.5/css/buttons.dataTables.min.css';

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
$HeadingLabel = ADMIN_ITEM_SAVE_DETAIL;
$HeadingEditLabel=ADMIN_ITEM_EDIT_DETAIL;
$auto_id = $_GET['id'];
//echo $auto_id;
//exit();
if(!empty($auto_id))
{
	$err['auto_id'] = chkTrk($auto_id);
}
if(!empty($err['auto_id']))
{
	logOut();
}
if(!empty($_GET['Action']))
{
	$err['Action'] = chkStr(valid_input($_GET['Action']));
}
if(!empty($err['Action']))
{
	logOut();
}
/*Export Csv Starts Here : Code for the Export of the PostCodes into csv Format*/
	if($_GET['Action']!='' &&  $_GET['Action']=='export_booking_item_detail_csv'){
    
		$BookingItemDetail = $ObjBookingDetailsMaster->getBookingItemDetails();	
	
    $filename = DIR_WS_ADMIN_DOCUMENTS."booking_item_details.csv"; //Blank CSV File
	$file_extension = strtolower(substr(strrchr($filename,"."),1));	//GET EXtension
    
	/**
	 * Genration of CSV File
	 */
	switch( $file_extension ) {
	  case "csv": $ctype = "text/comma-separated-values";break;
	  case "jpg": $ctype="image/jpg"; break;
	  default: $ctype="application/force-download";
	}    
	header("Pragma: public"); // required
	header('Expires: ' . gmdate('D, d M Y H:i:s') . ' GMT');
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Cache-Control: private",false); // required for certain browsers
	header("Content-Type: $ctype");
	header("Content-Disposition: attachment; filename=".basename($filename).";" );
	header("Content-Transfer-Encoding: binary");
	
	ob_clean();
		
	$curr= array("€"=>"�","£"=>"�");
	$data = "";
	
	$data.= "auto_id,\"booking_id\",\"item_type\",\"quantity\",\"item_weight\",\"length\",\"width\",\"height\",\"vol_weight\"";
	//$data.= ADMIN_ID.",".FROM_VEHICLE_SIZE.",".TO_VEHICLE_SIZE.",".BASIC_CHARGE.",".PERKM.",".MINIMUM.",".ZONE;
		
	
	
	if(isset($BookingItemDetail) && !empty($BookingItemDetail)) {		
		foreach ($BookingItemDetail as $BookingItemDetails) {		
			/*Code for the Currency value in which the order has been done*/
			
			$auto_id    = $BookingItemDetails['auto_id'];
			$booking_id = $BookingItemDetails['booking_id'];
			$item_type   = valid_output($BookingItemDetails['item_type']);
			$quantity = $BookingItemDetails['quantity'];
			$item_weight = $BookingItemDetails['item_weight'];
			$length = $BookingItemDetails['length'];
			$width = $BookingItemDetails['width'];
			$height = $BookingItemDetails['height'];
			$vol_weight = $BookingItemDetails['vol_weight'];

			$data.= "\n";
$data.= '"'.$auto_id.'","'.$booking_id.'","'.$item_type.'","'.$quantity.'","'.$item_weight.'","'.$length.'","'.$width.'","'.$height.'","'.$vol_weight.'"';
		}			
	}
	echo $data;
	exit();
}
if($_GET['Action']=='trash'){
	$ObjBookingDetailsMaster->deleteBookingItemDetails($auto_id);
	$UParam = "?pagenum=".$pagenum."&message=".MSG_DELETE_ITEM_SUCCESS;
	header('Location:'.FILE_BOOKING_ITEM_DETAILS_LISTING.$UParam);
}
if($_GET['Action']=='mtrash'){
$auto_id= $_GET['m_trash_id'];
	$m_t_a=explode(",",$auto_id);
	foreach($m_t_a as $val)
	{
		$error = chkTrk($val);
		if(!empty($error))
		{
			logOut();
		}else
		{
			$ObjBookingDetailsMaster->deleteBookingItemDetails($val);
		}
	}
	$UParam = "?pagenum=".$pagenum."&message=".MSG_DELETE_ITEM_SUCCESS;
	header('Location:'.FILE_BOOKING_ITEM_DETAILS_LISTING.$UParam);
}



if((isset($_POST['submit']) && submit != "")){
	
	if(isEmpty(valid_input($_POST['ptoken']), true)){	
		logOut();
	}else{
		$csrf->checkcsrf($_POST['ptoken']);
	}
	$err['from_vehicle_sizeError'] = isEmpty($_POST['booking_id'], BOOKING_ID_IS_REQUIRED)?isEmpty($_POST['booking_id'], BOOKING_ID_IS_REQUIRED):chkTrk($_POST['booking_id']);
	$err['to_vehicle_sizeError'] = isEmpty($_POST['item_type'],ITEM_TYPE_IS_REQUIRED)?isEmpty($_POST['item_type'], ITEM_TYPE_IS_REQUIRED):isNumeric($_POST['item_type'],ITEM_TYPE_IS_REQUIRED);
	if(empty($err['to_vehicle_sizeError']))
	{
		if(isNumeric($_POST['item_type'],ENTER_VALUE_IN_NUMERIC))
		{
			logOut();
		}
	}
	$err['basic_chargeError']  = isEmpty($_POST['quantity'], QUANTITY_IS_REQUIRED)?isEmpty($_POST['quantity'], QUANTITY_IS_REQUIRED):isNumeric($_POST['quantity'],ENTER_VALUE_IN_NUMERIC);
	$err['perkmError'] 			 = isEmpty(trim($_POST['item_weight']), ITEM_WEIGHT_REQUIRED)?isEmpty(trim($_POST['item_weight']), ITEM_WEIGHT_REQUIRED):isNumeric($_POST['item_weight'],ENTER_VALUE_IN_NUMERIC);
	$err['minimumError'] 		 = isEmpty(trim($_POST['length']), LENGTH_IS_REQUIRED)?isEmpty(trim($_POST['length']), LENGTH_IS_REQUIRED):isNumeric($_POST['length'],ENTER_VALUE_IN_NUMERIC);
	$err['zoneError'] 			 = isEmpty(trim($_POST['width']), WIDTH_IS_REQUIRED)?isEmpty(trim($_POST['width']), WIDTH_IS_REQUIRED):isNumeric($_POST['width'],ENTER_VALUE_IN_NUMERIC);
	$err['minimumErr'] 		 = isEmpty(trim($_POST['height']), HEIGHT_IS_REQUIRED)?isEmpty(trim($_POST['height']), HEIGHT_IS_REQUIRED):isNumeric($_POST['height'],ENTER_VALUE_IN_NUMERIC);
	$err['zoneErr'] 			 = isEmpty(trim($_POST['vol_weight']), VOL_WEIGHT_REQUIRED)?isEmpty(trim($_POST['vol_weight']), VOL_WEIGHT_REQUIRED):isNumeric($_POST['vol_weight'],ENTER_VALUE_IN_NUMERIC);
	//echo "<pre>";print_r($_POST);exit();
/**
		 * Checking Error Exists
		 */
	foreach($err as $key => $Value) {
		if($Value != '') {
			$Svalidation=true;
			$ptoken = $csrf->csrfkey();
		}
	}

	if($Svalidation==false){
		
		$BookingItemDetailsData->booking_id = trim($_POST['booking_id']);
		$BookingItemDetailsData->item_type = trim($_POST['item_type']);
		$BookingItemDetailsData->quantity = trim($_POST['quantity']);
		$BookingItemDetailsData->item_weight = trim($_POST['item_weight']);
		$BookingItemDetailsData->length = trim($_POST['length']);
		$BookingItemDetailsData->width = trim($_POST['width']);
		$BookingItemDetailsData->height = trim($_POST['height']);
		$BookingItemDetailsData->vol_weight = trim($_POST['vol_weight']);
		
		

		if($auto_id!=''){
			//Edit Users
			$BookingItemDetailsData->auto_id = $auto_id;

			$ObjBookingDetailsMaster->editBookingItemDetails($BookingItemDetailsData);
			$UParam = "?pagenum=".$pagenum."&message=".MSG_EDIT_ITEM_SUCCESS;
		}else{
			$insertedauto_id = $ObjBookingDetailsMaster->addBookingItemDetails($BookingItemDetailsData);
			$UParam = "?pagenum=".$pagenum."&message=".MSG_ADD_ITEM_SUCCESS;
			
		}
		header('Location:'.FILE_BOOKING_ITEM_DETAILS_LISTING.$UParam);

	}

}


/**
	 * Gets details for the user
	 */
if($auto_id!=''){
	$fieldArr=array("*");
	$seaByArr[]=array('Search_On'=>'auto_id', 'Search_Value'=>"$auto_id", 'Type'=>'int', 'Equation'=>'LIKE', 'CondType'=>'and', 'Prefix'=>'', 'Postfix'=>'');
    $DataPostCode=$ObjBookingDetailsMaster->getBookingItemDetails($fieldArr, $seaByArr); // Fetch Data
    $DataPostCode = $DataPostCode[0];
	//Get sign up Address
    //Variable declaration
    $btnSubmit = ADMIN_BUTTON_UPDATE_POSTCODE;
	$HeadingLabel = ADMIN_LINK_UPDATE_POSTCODE;
}
$Itemdetail = $ObjBookingDetailsMaster->getBookingItemDetails();

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
										<span><a href="<?php echo FILE_WELCOME_ADMIN; ?>"><?php echo ADMIN_HEADER_HOME; ?></a> > <a href="<?php //echo FILE_SAMEDAY_RATES_LISTING; ?>"> <?php echo ADMIN_HEADER_DETAIL; ?> </a> > 
										<? if ($_GET['Action']=='edit') {
											echo "$HeadingEditLabel" ;
										} else {
											echo $HeadingLabel;
										}
											?>

										</span>
										<div><label class="top_navigation"><a href="<?php echo FILE_BOOKING_ITEM_DETAILS_LISTING; ?>"><?php echo ADMIN_COMMON_BACK; ?></a></label></div>
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
							        		<tr><td colspan="4">&nbsp;</td></tr>
											
											<?php
											if($message!='')
											{ ?>
											<tr>
				<td class="message_error noprint" align="center"><?php echo valid_output($message); ?></td>
											</tr>
											
											
											
											<?php } if(!empty($Error) && $Error['csv_file']!='') {?>
											<tr>
												<td class="message_error noprint" align="center"><?php echo $Error['csv_file'] ; ?></td>
											</tr>
											<?php } ?>			
												
											
							<tr>
								<td align="center">
									<?php  /*** Start :: Listing Table ***/ ?>
									<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
										
										<form name="frmuser" method="POST"  action="">

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
																	<td colspan="4" align="left" valign="top" class="grayheader"><b><?php echo ADMIN_ITEM_ITEM_BOOKING_DETAIL;?> : </b></td>
																</tr>
																<tr><td colspan="4">&nbsp;</td></tr>
																<tr>
																	<td  align="left" valign="middle"><?php echo BOOKING_ID;?></td>
	<td  align="left" valign="middle">
	<a href='<?php echo FILE_BOOKING_DETAILS_ACTION."?Action=edit&booking_id=".$DataPostCode['booking_id'];?>'><?php echo valid_output($DataPostCode['booking_id']);?></a>
	<img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>internal/help_up.gif" class="help_btn" alt="<?php echo BOOKING_ID;?>"onmouseover="return overlib('<?php echo $booking_id;?>');" onmouseout="return nd();" /> </td>
																	<td  align="left" valign="middle"><?php echo ITEM_TYPE;?></td>
																		<td align="left" valign="top">
																	<?php
		//$fieldArr1 = array("width");
		$countryOutput = '';
		$ItemType = $ObjItemTypeMaster->getItemType();
		
		$countryOutput.="<select name='item_type'   tabindex='4' id='zone' ><option value=''>SELECT  ITEM TYPE </option>";
		if($ItemType!=''){
		     		foreach($ItemType as $details)
		     		{			 
		     			$cond = ($details["item_id"]==$DataPostCode['item_type'])?("selected"):('');
		     					 $detailname=$details["item_name"];
			 					 $countryOutput.='<option value="'.$details["item_id"].'"';
			 					 $countryOutput .= $cond;
								 $countryOutput.='  >'.valid_output($detailname).'</option>';
	         		} }
		                       	$countryOutput.="</select>";
		                         echo $countryOutput; ?><img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>internal/help_up.gif" class="help_btn" alt="Pickup From"onmouseover="return overlib('<?php echo $item_type;?>');" onmouseout="return nd();" /> 
					</td>
																</tr>
																<tr>
																	<td align="left" valign="middle">&nbsp;</td>
																	<td align="left" valign="top" class="message_mendatory" id="from_vehicle_sizeError"><?php echo $err['from_vehicle_sizeError'];  ?></td>
																	<td align="left" valign="middle">&nbsp;</td>
																	<td align="left" valign="top" class="message_mendatory" id="to_vehicle_sizeError"><?php echo $err['to_vehicle_sizeError'];  ?></td>
																</tr>
																<tr>
																	<td align="left" valign="middle"  nowrap="nowrap"><?php echo QUANTITY;?></td>
																	<td  align="left" valign="middle" class="message_mendatory"><input type="text" name="quantity" class="textbox"  value="<?php if($_POST['quantity'] != ''){ echo $_POST['quantity'];}else{ echo $DataPostCode["quantity"]; } ?>" tabindex="20"/>&nbsp;*<img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>internal/help_up.gif" class="help_btn" alt="<?php echo QUANTITY;?>"onmouseover="return overlib('<?php echo $Quantity;?>');" onmouseout="return nd();" /></td>
																	<td align="left" valign="middle"><?php echo ITEM_WEIGHT;?></td><td  align="left" valign="middle" class="message_mendatory"><input type="text" name="item_weight" class="textbox"  value="<?php if($_POST['item_weight'] != ''){ echo $_POST['item_weight'];}else{ echo $DataPostCode["item_weight"]; } ?>" tabindex="20"/>&nbsp;*<img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>internal/help_up.gif" class="help_btn" alt="<?php echo ITEM_WEIGHT;?>"onmouseover="return overlib('<?php echo $Item_Weight ;?>');" onmouseout="return nd();" /></td>
																</tr>
																<tr>
																	<td align="left" valign="middle">&nbsp;</td>
																	<td align="left" valign="top" class="message_mendatory" id="from_vehicle_sizeError"><?php echo $err['basic_chargeError'];  ?></td>
																	<td align="left" valign="middle">&nbsp;</td>
																	<td align="left" valign="top" class="message_mendatory" id="to_vehicle_sizeError"><?php echo $err['perkmError'];  ?></td>
																</tr>
															
																<tr>
																	<td  align="left" valign="middle"><?php echo ITEM_LENGTH;?></td>
																	<td  align="left" valign="middle" class="message_mendatory"><input name="length" class="textbox" value="<?php if($_POST['length'] != ''){ echo $_POST['length'];}else{ echo $DataPostCode["length"]; } ?>" tabindex="22" />&nbsp;*<img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>internal/help_up.gif" class="help_btn" alt="Pickup From"onmouseover="return overlib('<?php echo $delivery_to;?>');" onmouseout="return nd();" /></td>
																	<td  align="left" valign="middle"><?php echo ITEM_WIDTH;?></td>
																	<td  align="left" valign="middle" class="message_mendatory"><input name="width" class="textbox"  value="<?php if($_POST['width'] != ''){ echo $_POST['width'];}else{ echo $DataPostCode["width"]; } ?>" tabindex="23"/>&nbsp;*<img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>internal/help_up.gif" class="help_btn" alt="Pickup From"onmouseover="return overlib('<?php echo $Item_Width;?>');" onmouseout="return nd();" /></td>
																</tr>
																<tr>
																	<td align="left" valign="middle">&nbsp;</td>
																	<td align="left" valign="middle" class="message_mendatory" id="perkmError" ><?php echo $err['zoneError']; ?></td>
																	<td align="left" valign="middle"></td>
																	<td align="left" valign="middle" class="message_mendatory" id="minimumError"><?php echo $err['minimumError']; ?></td>
																</tr>
																
																<tr>
																	<td  align="left" valign="middle"><?php echo ITEM_HEIGHT;?></td>
																	<td  align="left" valign="middle" class="message_mendatory"><input name="height" class="textbox" value="<?php if($_POST['height'] != ''){ echo $_POST['height'];}else{ echo $DataPostCode["height"]; } ?>" tabindex="22" />&nbsp;*<img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>internal/help_up.gif" class="help_btn" alt="<?php echo ITEM_HEIGHT;?>"onmouseover="return overlib('<?php echo $Item_Height;?>');" onmouseout="return nd();" /></td>
																	<td  align="left" valign="middle"><?php echo ITEM_VOL_WEIGHT;?></td>
																	<td  align="left" valign="middle" class="message_mendatory"><input name="vol_weight" class="textbox"  value="<?php if($_POST['vol_weight'] != ''){ echo $_POST['vol_weight'];}else{ echo $DataPostCode["vol_weight"]; } ?>" tabindex="23"/>&nbsp;*<img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>internal/help_up.gif" class="help_btn" alt="<?php echo ITEM_VOL_WEIGHT;?>"onmouseover="return overlib('<?php echo $Vol_Weight;?>');" onmouseout="return nd();" /></td>
																</tr>
																<tr>
																	<td align="left" valign="middle">&nbsp;</td>
																	<td align="left" valign="middle" class="message_mendatory" id="perkmError" ><?php echo $err['minimumErr']; ?></td>
																	<td align="left" valign="middle">&nbsp;</td>
																	<td align="left" valign="middle" class="message_mendatory" id="minimumErr"><?php echo $err['zoneErr']; ?></td>
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
											<input type="submit" class="action_button" tabindex="36" name="submit" value="<?php echo "$btnSubmit";  ?>" onclick="return validate_client(this.form);" >
<? } else { ?>
<input type="submit" class="action_button" tabindex="36" name="submit" value="<?php echo "submit items";  ?>" onclick="return validate_client(this.form);" > <?php } ?>
											<input type="reset" tabindex="37" name="reset" class="action_button" value="<?php echo ADMIN_COMMON_BUTTON_RESET; ?>" >
											<input type="hidden" size="34" id="ptoken" value="<?php echo $ptoken; ?>" name="ptoken">
											<input type="button"  class="action_button" name="cancel" tabindex="38" value="<?php echo ADMIN_COMMON_BUTTON_CANCEL;?>" onclick="javascript:document.location.href='<?php echo FILE_BOOKING_ITEM_DETAILS_LISTING."?pagenum=".$pagenum; ?>';return true;"/>
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

