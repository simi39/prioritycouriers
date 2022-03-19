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
require_once(DIR_WS_RELATED."system_mail.php");
require_once(DIR_WS_ADMIN_LANGUAGES . DIR_CURRENT_LANGUAGE. '/english.php');
require_once(DIR_WS_ADMIN_LANGUAGES . DIR_CURRENT_LANGUAGE. '/postcode.php');
$pagenum = ($_GET['pagenum']!="")?($_GET['pagenum']):(1);
if(!empty($pagenum))
{
	$err['pagenum'] = isNumeric(valid_input($pagenum),ENTER_NUMERIC_VALUES_ONLY);
}
if(!empty($err['pagenum']))
{
	logOut();
}

/**
	 * Start :: Object declaration
	 */
$ObjPostCodeMaster	= new PostCodeMaster();
$ObjPostCodeMaster	= $ObjPostCodeMaster->Create();
$PostCodeData		= new PostCodeData();
/**
	 * Inclusion and Exclusion Array of Javascript
	 */
$arr_javascript_include[] = 'internal/postcode_action.php';
$arr_javascript_plugin_include[] = 'overlib.js';
$arr_javascript_plugin_include[] = 'datatables/js/jquery.dataTables.min.js';

global $con;
$max_id = mysqli_query($con,"select max(auto_id) as Id from postcode_locator");
$maximum_id = mysqli_fetch_array($max_id);
/**
	 * Variable Declaration
	 */
$btnSubmit = ADMIN_BUTTON_SAVE_POSTCODE;
$HeadingLabel = ADMIN_LINK_SAVE_POSTCODE;
$auto_id = $_GET['auto_id'];
$message = $_GET['message'];
if(!empty($auto_id))
{
	$err['auto_id'] = isNumeric(valid_input($auto_id),ENTER_NUMERIC_VALUES_ONLY);
}
if(!empty($err['auto_id']))
{
	logOut();
}

//echo "test";
//exit();
/*csrf validation*/
$csrf = new csrf();
$csrf->action = "postcode_action";
/*if(!isset($_POST['ptoken'])) {
	$ptoken = $csrf->csrfkey();
}*/
/*csrf validation*/

if(!empty($_GET['Action']))
{
	$err['Action'] = chkStr(valid_input($_GET['Action']));
}
if(!empty($err['Action']))
{
	logOut();
}

if(!empty($message))
{
	$err['message'] = chkStr(valid_input($message));
}
if(!empty($err['message']))
{
	logOut();
}

/*Export Csv Starts Here : Code for the Export of the PostCodes into csv Format*/
	if($_GET['Action']!='' &&  $_GET['Action']=='export_postcode_csv'){
	
	$PostCodesData = $ObjPostCodeMaster->getPostCode(null,false, null,null,null, null, true,false);	
	$filename = DIR_WS_ADMIN_DOCUMENTS."postcode.csv"; //Balnk CSV File
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

	$data.= "auto_id,\"Id\",\"FullName\",\"Name\",\"Postcode\",\"State\",\"Zone\",\"charging_zone\",\"time_zone\"";
	//$data.= ADMIN_POSTCODE_ID.",".ADMIN_POSTCODE_FULL_NAME.",".ADMIN_POSTCODE_ZONE.",".ADMIN_POSTCODE_CHARGING_ZONE.",".ADMIN_POSTCODE_TIME_ZONE;
	if(isset($PostCodesData) && !empty($PostCodesData)) {		
		foreach ($PostCodesData as $PostCode) {		
			/*Code for the Currency value in which the order has been done*/
			$auto_id          = valid_output($PostCode['auto_id']);
			$Id          = valid_output($PostCode['Id']);
			$FullName       = valid_output($PostCode['FullName']);
			$Name = valid_output($PostCode['Name']);
			$Postcode = valid_output($PostCode['Postcode']);
			$State = valid_output($PostCode['State']);
			$Zone     = valid_output($PostCode['Zone']);
			$charging_zone = valid_output($PostCode['charging_zone']);
			$time_zone = valid_output($PostCode['time_zone']);

			$data.= "\n";
			$data.= '"'.$auto_id.'","'.$Id.'","'.$FullName.'","'.$Name.'","'.$Postcode.'","'.$State.'","'.$Zone.'","'.$charging_zone.'","'.$time_zone.'"';
		}			
	}
	echo $data;
	exit();
}

if($_GET['Action']=='trash'){
	$ObjPostCodeMaster->deletePostCode($auto_id);
	$UParam = "?pagenum=".$pagenum."&message=".MSG_DELETE_POSTCODE_SUCCESS;
	header('Location: '.FILE_POSTCODE_LISTING.$UParam);
}
if($_GET['Action']=='mtrash'){
$auto_id= $_GET['m_trash_id'];
	$m_t_a=explode(",",$auto_id);
	if(!empty($m_t_a))
	{
		$err['m_t_a'] = isNumeric(valid_input($m_t_a),ENTER_NUMERIC_VALUES_ONLY);
	}
	if(!empty($err['m_t_a']))
	{
		logOut();
	}

	foreach($m_t_a as $val)
	{
		$ObjPostCodeMaster->deletePostCode($val);
	}
 	$UParam = "?pagenum=".$pagenum."&message=".MSG_DELETE_POSTCODE_SUCCESS;
	header('Location: '.FILE_POSTCODE_LISTING.$UParam);
}

if((isset($_POST['submit']) && $_POST['submit'] != "")){
	
	/*if(isEmpty(valid_input($_POST['ptoken']), true)){	
		logOut();
	}else{
		$csrf->checkcsrf($_POST['ptoken']);
	}*/
	$err['IdError'] = (isEmpty(valid_input($_POST['Id']),COMMON_ID_IS_REQUIRED))?isEmpty(valid_input($_POST['Id']),COMMON_ID_IS_REQUIRED):isNumeric(valid_input($_POST['Id']),COMMON_NUMERIC_VALUE);
	$err['NameError'] 		 	 = (isEmpty(valid_input($_POST['Name']), COMMON_NAME_IS_REQUIRED))?isEmpty(valid_input($_POST['Name']), COMMON_NAME_IS_REQUIRED):chkStr(valid_input($_POST['Name']));
	$err['PostcodeError'] 		 = (isEmpty(valid_input($_POST['Postcode']),COMMON_POSTCODE_IS_REQUIRED))?isEmpty(valid_input($_POST['Postcode']),COMMON_POSTCODE_IS_REQUIRED):isNumeric(valid_input($_POST['Postcode']),ERROR_POSTCODE_REQUIRE_IN_NUMERIC);
	$err['StateError']  		 = isEmpty(valid_input($_POST['State']), ADMIN_POSTCODE_STATE_IS_REQUIRED)?isEmpty(valid_input($_POST['State']), ADMIN_POSTCODE_STATE_IS_REQUIRED):chkCapital(valid_input($_POST['State']));
	$err['charging_zoneError'] 	 = isEmpty(valid_input($_POST['charging_zone']), COMMON_CHARGING_ZONE_IS_REQUIRED)?isEmpty(valid_input($_POST['charging_zone']), COMMON_CHARGING_ZONE_IS_REQUIRED):chkStr(valid_input($_POST['charging_zone']));
	$err['time_zoneError'] 		 = isEmpty(valid_input($_POST['time_zone']), COMMON_TIME_ZONE_IS_REQUIRED)?isEmpty(valid_input($_POST['time_zone']), COMMON_TIME_ZONE_IS_REQUIRED):specialcharaChk(valid_input($_POST['time_zone']));
	$err['ZoneError'] 			 = isEmpty(valid_input($_POST['Zone']), COMMON_ZONE_IS_REQUIRED)?isEmpty(valid_input($_POST['Zone']), COMMON_ZONE_IS_REQUIRED):specialcharaChk(valid_input($_POST['Zone']));
	

	/**
		 * Checking Error Exists
		 */
	foreach($err as $key => $Value) {
		if($Value != '') {
			$Svalidation=true;
			$csrf->action = "postcode_action";
		}
	}

	if($Svalidation==false){
		
		if(isset($_GET['Id']) && !empty($_GET['Id']))
		{
			$PostCodeData->Id = valid_input($_GET['Id']);
		}else{
			$PostCodeData->Id = '1';
		}
		
		$PostCodeData->Name = valid_input($_POST['Name']);
		$PostCodeData->Postcode = valid_input($_POST['Postcode']);
		$PostCodeData->State = valid_input($_POST['State']);
		$PostCodeData->Zone = valid_input($_POST['Zone']);
		$PostCodeData->charging_zone = valid_input($_POST['charging_zone']);
		$PostCodeData->time_zone = valid_input($_POST['time_zone']);
		$PostCodeData->FullName = valid_input($_POST['Name'])." ".valid_input($_POST['State'])." ".valid_input($_POST['Postcode']);

		if($auto_id!=''){
			//Edit Users
			$PostCodeData->auto_id = $auto_id;

			$ObjPostCodeMaster->editPostCode($PostCodeData);
			$UParam = "?pagenum=".$pagenum."&message=".MSG_EDIT_POSTCODE_SUCCESS;
		}else{
			$insertedauto_id = $ObjPostCodeMaster->addPostCode($PostCodeData);
			$UParam = "?pagenum=".$pagenum."&message=".MSG_ADD_POSTCODE_SUCCESS;
		}

		header('Location:'.FILE_POSTCODE_LISTING.$UParam);

	}

}


/**
	 * Gets details for the user
	 */
if($auto_id!=''){
	$fieldArr=array("*");
	$seaByArr[]=array('Search_On'=>'auto_id', 'Search_Value'=>"$auto_id", 'Type'=>'int', 'Equation'=>'=', 'CondType'=>'', 'Prefix'=>'', 'Postfix'=>'');

	$DataPostCode=$ObjPostCodeMaster->getPostCode($fieldArr,false, $seaByArr); // Fetch Data

	$DataPostCode = $DataPostCode[0];
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
addPluginCSSFile($arr_css_plugin_include,$arr_css_plugin_exclude);
addCSSFileAdmin($arr_css_admin_include, $arr_css_admin_exclude);
addJavaScriptFile($arr_javascript_include, $arr_javascript_exclude);
addPluginJavaScriptFile($arr_javascript_plugin_include,$arr_javascript_plugin_exclude);
?>
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
										<span><a href="<?php echo FILE_WELCOME_ADMIN; ?>"><?php echo ADMIN_HEADER_HOME; ?></a> > <a href="<?php echo FILE_POSTCODE_LISTING."?pagenum=".$pagenum; ?>"> <?php echo ADMIN_HEADER_POSTCODES; ?> </a> > <? echo $HeadingLabel; ?></span>
										<div><label class="top_navigation"><a href="<?php echo FILE_POSTCODE_LISTING."?pagenum=".$pagenum; ?>"><?php echo ADMIN_COMMON_BACK; ?></a></label></div>
								</td>
							</tr>
							<tr>
								<td class="heading">
									<?php echo $HeadingLabel; ?>
								</td>
							</tr>
							
											
											<tr><td colspan="4">&nbsp;</td></tr>
											
											<?php
											if($message!='')
											{ ?>
											<tr>
												<td class="message_error noprint" align="center"><?php if($arr_message[$message]==''){echo valid_output($arr_message[$message]) ;}else{ echo valid_output($message);} ?></td>
											</tr>
											
											<?php }  ?>		
												
											
							<tr>
								<td align="center">
									<?php  /*** Start :: Listing Table ***/ ?>
									<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
										
										<form name="frmuser" method="POST"  action="">
										<input type="hidden" name="Id" value="<?php echo $maximum_id[0];?>"  />
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
																	<td colspan="4" align="left" valign="top" class="grayheader"><b><?php echo ADMIN_USERS_PERSONAL_DETAILS;?> : </b></td>
																</tr>
																<tr><td colspan="4">&nbsp;</td></tr>
																<tr>
																	<td  align="left" valign="middle"><?php echo ADMIN_POSTCODE_FULL_NAME;?></td>
																	<td  align="left" valign="middle"  class="message_mendatory"><input class="textbox" type="text" name="Name"  value="<?php if($_POST['Name'] != ''){ echo valid_output($_POST['Name']);}else{ echo valid_output($DataPostCode["Name"]); } ?>" maxlength="50" tabindex="18"/>&nbsp;*<img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>internal/help_up.gif" class="help_btn" alt="<?php echo ADMIN_POSTCODE_FULL_NAME;?>"onmouseover="return overlib('<?php echo $Full_Name;?>');" onmouseout="return nd();" /> </td>
																	<td  align="left" valign="middle"><?php echo ADMIN_HEADER_POSTCODES;?></td>
																	<td  align="left" valign="top" class="message_mendatory"><input class="textbox" type="text" name="Postcode"  value="<?php if($_POST['Postcode'] != ''){ echo valid_output($_POST['Postcode']);}else{ echo valid_output($DataPostCode["Postcode"]); } ?>" maxlength="50" tabindex="19"/>&nbsp;*<img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>internal/help_up.gif" class="help_btn" alt="<?php echo ADMIN_HEADER_POSTCODES;?>"onmouseover="return overlib('<?php echo $PostCodes;?>');" onmouseout="return nd();" /> </td>
																</tr>
																<tr>
																	<td align="left" valign="middle">&nbsp;</td>
																	<td align="left" valign="top" class="message_mendatory" id="NameError"><?php echo $err['NameError'];  ?></td>
																	<td align="left" valign="middle">&nbsp;</td>
																	<td align="left" valign="top" class="message_mendatory" id="PostcodeError"><?php echo $err['PostcodeError'];  ?></td>
																</tr>
																<tr>
																	<td align="left" valign="middle"  nowrap="nowrap"><?php echo ADMIN_USERS_FIELD_STATE;?></td>
																	<td  align="left" valign="middle" class="message_mendatory"><input name="State" class="textbox" maxlength="3" value="<?php if($_POST['State'] != ''){ echo valid_output($_POST['State']);}else{ echo valid_output($DataPostCode["State"]); } ?>" tabindex="20"/>&nbsp;*<img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>internal/help_up.gif" class="help_btn" alt="<?php echo ADMIN_USERS_FIELD_STATE;?>"onmouseover="return overlib('<?php echo $State;?>');" onmouseout="return nd();" /> </td>
																	<td align="left" valign="middle"><?php echo ADMIN_POSTCODE_ZONE;?></td>
																	<td align="left" valign="top"><input name="Zone" class="textbox" maxlength="3" value="<?php if($_POST['Zone'] != ''){ echo valid_output($_POST['Zone']);}else{ echo valid_output($DataPostCode["Zone"]); } ?>"  tabindex="21" />&nbsp;<img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>internal/help_up.gif" class="help_btn" alt="<?php echo ADMIN_POSTCODE_ZONE;?>"onmouseover="return overlib('<?php echo $Zone;?>');" onmouseout="return nd();" /> </td>
																</tr>
																<tr>
																	<td align="left" valign="middle">&nbsp;</td>
																	<td align="left" valign="top" class="message_mendatory" id="NameError"><?php echo $err['StateError'];  ?></td>
																	<td align="left" valign="middle">&nbsp;</td>
																	<td align="left" valign="top" class="message_mendatory" id="PostcodeError"><?php echo $err['ZoneError'];  ?></td>
																</tr>
															
																<tr>
																	<td  align="left" valign="middle"><?php echo ADMIN_POSTCODE_CHARGING_ZONE;?></td>
																	<td  align="left" valign="middle" class="message_mendatory"><input name="charging_zone" class="textbox" value="<?php if($_POST['charging_zone'] != ''){ echo valid_output($_POST['charging_zone']);}else{ echo valid_output($DataPostCode["charging_zone"]); } ?>" tabindex="22" />&nbsp;*<img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>internal/help_up.gif" class="help_btn" alt="<?php echo ADMIN_POSTCODE_CHARGING_ZONE;?>"onmouseover="return overlib('<?php echo $Charging_Zone;?>');" onmouseout="return nd();" /> </td>
																	<td  align="left" valign="middle"><?php echo ADMIN_POSTCODE_TIME_ZONE;?></td>
																	<td  align="left" valign="middle" class="message_mendatory"><input name="time_zone" class="textbox"  value="<?php if($_POST['time_zone'] != ''){ echo valid_output($_POST['time_zone']);}else{ echo valid_output($DataPostCode["time_zone"]); } ?>" tabindex="23"/>&nbsp;*<img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>internal/help_up.gif" class="help_btn" alt="<?php echo ADMIN_POSTCODE_TIME_ZONE;?>"onmouseover="return overlib('<?php echo $Time_Zone;?>');" onmouseout="return nd();" /> </td>
																</tr>
																<tr>
																	<td align="left" valign="middle">&nbsp;</td>
																	<td align="left" valign="middle" class="message_mendatory" id="charging_zoneError" ><?php echo $err['charging_zoneError']; ?></td>
																	<td align="left" valign="middle">&nbsp;</td>
																	<td align="left" valign="middle" class="message_mendatory" id="time_zoneError"><?php echo $err['time_zoneError']; ?></td>
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
											<input type="hidden" size="34" id="ptoken" value="<?php echo $ptoken; ?>" name="ptoken">
											<input type="submit" class="action_button" tabindex="36" name="submit" value="<?php echo $btnSubmit; ?>" onclick="return validate_client(this.form);" >
											<input type="reset" tabindex="37" name="reset" class="action_button" value="<?php echo ADMIN_COMMON_BUTTON_RESET; ?>" >
											<input type="button"  class="action_button" name="cancel" tabindex="38" value="<?php echo ADMIN_COMMON_BUTTON_CANCEL;?>" onclick="javascript:document.location.href='<?php echo FILE_POSTCODE_LISTING."?pagenum=".$pagenum; ?>';return true;"/>
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
<?php require_once(DIR_WS_JSCRIPT."internal/jquery.php"); ?>
