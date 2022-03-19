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
require_once(DIR_WS_MODEL . "InternationalZonesMaster.php");
require_once(DIR_WS_RELATED . "system_mail.php");
require_once(DIR_WS_ADMIN_LANGUAGES . DIR_CURRENT_LANGUAGE. '/international_zone.php');
$pagenum = ($_GET['pagenum']!="")?($_GET['pagenum']):(1);
if(!empty($pagenum))
{
	$err['pagenum'] = isNumeric(valid_input($pagenum),ENTER_NUMERIC_VALUES_ONLY);
}
if(!empty($err['pagenum']))
{
	logOut();
}
/*csrf validation*/
$csrf = new csrf();
$csrf->action = "international_zone";
if(!isset($_POST['ptoken'])) {
	$ptoken = $csrf->csrfkey();
}

/*csrf validation*/

 
/**
	 * Start :: Object declaration
	 */
$ObjPostCodeMaster	= new InternationalZonesMaster();
$ObjPostCodeMaster	= $ObjPostCodeMaster->Create();
$PostCodeData		= new InternationalZonesData();
/**
	 * Inclusion and Exclusion Array of Javascript
	 */
$arr_javascript_include[] = "internal/postcode_action.php";
$arr_javascript_plugin_include[] = 'datatables/js/jquery.dataTables.min.js';
$arr_javascript_plugin_include[] = "overlib.js";


/*$max_id = mysql_query("select max(auto_id) as Id from postcode_locator");
$maximum_id = mysql_fetch_array($max_id);*/
/**
	 * Variable Declaration
	 */
	$btnSubmit = ADMIN_BUTTON_SAVE_POSTCODE;
	$HeadingLabel = ADMIN_LINK_SAVE_POSTCODE;
	$auto_id = $_GET['Id'];
	if(!empty($auto_id))
	{
		$err['auto_id'] = isNumeric(valid_input($auto_id),ENTER_NUMERIC_VALUES_ONLY);
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
	if($_GET['Action']!='' &&  $_GET['Action']=='export_international_zone_csv'){


	$InternationalZones = $ObjPostCodeMaster->getInternationalZones();	
	
	$filename = DIR_WS_ADMIN_DOCUMENTS."international_zone.csv"; //Balnk CSV File
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
		$SyncArray = array(
			'country' => 'country',
			'zone' => 'zone',
			'days' => 'days'
			);
$data.= "id,\"country\",\"zone\",\"days\"";
	//$data.= ADMIN_ID.",".ADMIN_COUNTRY.",".ADMIN_ZONE.",".ADMIN_DAYS;
				
	if(isset($InternationalZones) && !empty($InternationalZones)) {		
		foreach ($InternationalZones as $InternationalZone) {		
			/*Code for the Currency value in which the order has been done*/

			$id  = $InternationalZone['id'];
			$country    = valid_output($InternationalZone['country']);
			$zone  = valid_output($InternationalZone['zone']);
			$days = valid_output($InternationalZone['days']);
			$data.= "\n";
			$data.= '"'.$id.'","'.$country.'","'.$zone.'","'.$days.'"';
		}			
	}
	echo $data;
	exit();
}

if($_GET['Action']=='trash'){
	$ObjPostCodeMaster->deleteInternationalZones($auto_id);
	$UParam = "?pagenum=".$pagenum."&message=".MSG_DELETE_POSTCODE_SUCCESS;
	header('Location: '.FILE_INTERNATIONAL_ZONE_LISTING.$UParam);
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
			$ObjPostCodeMaster->deleteInternationalZones($val);
		}
		
	}
   $UParam = "?pagenum=".$pagenum."&message=".MSG_DELETE_POSTCODE_SUCCESS;
	header('Location: '.FILE_INTERNATIONAL_ZONE_LISTING.$UParam);
}
if((isset($_POST['submit']) && submit != "")){
	
	
	if(isEmpty(valid_input($_POST['ptoken']), true)){	
		logOut();
	}else{
		$csrf->checkcsrf($_POST['ptoken']);
	}
	$err['countryError'] =(isEmpty(valid_input($_POST['country']),ADMIN_COUNTRY_IS_REQUIRED))?(isEmpty(valid_input($_POST['country']),ADMIN_COUNTRY_IS_REQUIRED)):(checkName(valid_input($_POST['country'])));
	
	$err['zoneError'] 	= (isEmpty(trim($_POST['zone']),ADMIN_ZONE_IS_REQUIRED))?isEmpty(trim($_POST['zone']),ADMIN_ZONE_IS_REQUIRED):isNumeric(trim($_POST['zone']),COMMON_ZONE_REQUIRE_IN_NUMERIC);
	
	$err['daysError']  =(isEmpty(trim($_POST['days']),ADMIN_DAY_IS_REQUIRED))?isEmpty(trim($_POST['days']),ADMIN_DAY_IS_REQUIRED):isNumeric(trim($_POST['days']),COMMON_DAYS_IN_NUMERIC);
	
	
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
		
		$PostCodeData->country = trim($_POST['country']);
		$PostCodeData->zone = trim($_POST['zone']);
		$PostCodeData->days = trim($_POST['days']);
		if($auto_id!=''){
			//Edit Users
			$PostCodeData->id = $auto_id;

			$ObjPostCodeMaster->editInternationalZones($PostCodeData);
			$UParam = "?pagenum=".$pagenum."&message=".MSG_EDIT_POSTCODE_SUCCESS;
		}else{
			$insertedauto_id = $ObjPostCodeMaster->addInternationalZones($PostCodeData);
			$UParam = "?pagenum=".$pagenum."&message=".MSG_ADD_POSTCODE_SUCCESS;
		}

		header('Location: '.FILE_INTERNATIONAL_ZONE_LISTING.$UParam);

	}

}

if(isset($_POST['btnimport']) && $_POST['btnimport']!=''){
	
	if(isEmpty(valid_input($_POST['ptoken']), true)){	
		logOut();
	}else{
		$csrf->checkcsrf($_POST['ptoken']);
	}
	$message = '';
	$Error = array();

	if(isset($_FILES['csv_file']['name']) && $_FILES['csv_file']['name']!='') {
		$str_ext = substr($_FILES['csv_file']['name'],strrpos($_FILES['csv_file']['name'],'.'));
		if( strtolower($str_ext) != '.csv' ) {
			$message = SELECT_UPLOAD_CSV_FILE;
			$var_tab = 1;

		} else {
			//  Read csv file and making array
	
			$SyncArray = array(
			'country' => 'country',
			'zone' => 'zone',
			'days' => 'days'
			);


			$Array_Data = readCSVFile($_FILES['csv_file']['tmp_name'], $SyncArray);
			
			$i = 0;$cnt=0;
			if($Array_Data != '') {
				$cnt = count($Array_Data);
				foreach ($Array_Data as $key => $record) {
					if(checkName(valid_input($record['country'])))
					{
						$message = checkName(valid_input($record['country']));
						$Svalidation = true;
					}elseif(isNumeric(valid_input($record['zone']),COMMON_ZONE_REQUIRE_IN_NUMERIC))
					{
						$message = isNumeric(valid_input($record['zone']),COMMON_ZONE_REQUIRE_IN_NUMERIC);
						$Svalidation = true;
					}elseif(isNumeric(valid_input($record['days']),COMMON_DAYS_IN_NUMERIC))
					{
						$message = isNumeric(valid_input($record['days']),COMMON_DAYS_IN_NUMERIC);
						$Svalidation = true;
					}
				}
				if($Svalidation == true)
				{
					$ptoken = $csrf->csrfkey();
				}
				if($Svalidation == false)
				{
					foreach ($Array_Data as $key => $record) {
					
						$PostCodeData->country = trim($record['country']);
						$PostCodeData->zone = trim($record['zone']);
						$PostCodeData->days = trim($record['days']);
						



						$fieldArr=array("*");
						$seaByArr = array() ;
						if($PostCodeData->country!=''){
						$seaByArr[]=array('Search_On'=>'country', 'Search_Value'=>"$PostCodeData->country", 'Type'=>'string', 'Equation'=>'LIKE', 'CondType'=>'', 'Prefix'=>'', 'Postfix'=>'');
						}else{
							break;
						}
						$Data=$ObjPostCodeMaster->getInternationalZones($fieldArr, $seaByArr); // Fetch Data

						$totalRecords = $Data[0];


						if($totalRecords!='') {
							$alreadyaddedRecord++;
						}
						else{
							$ObjPostCodeMaster->addInternationalZones($PostCodeData);
							$i = $i+1;
						}
					}
				}
			} 	
			if(empty($message))
			{
				if($i > 0) {
					$message        = MSG_ADD_POSTCODE_SUCCESS;
				} elseif($cnt == $alreadyaddedRecord  && $alreadyaddedRecord > 0) {
					$message = ERROR_ALREADY_INTERNATIONAL_AVAILABLE_CSV_FILE;
				}else{
					$message = ERROR_CSV_FILE_FORMAT;
				}
			}
		}


	}else{
		$message = SELECT_UPLOAD_CSV_FILE;
	}

}

/**
	 * Gets details for the user
	 */
if($auto_id!=''){
	
	$fieldArr=array("*");
	$seaByArr[]=array('Search_On'=>'id', 'Search_Value'=>"$auto_id", 'Type'=>'int', 'Equation'=>'=', 'CondType'=>'', 'Prefix'=>'', 'Postfix'=>'');

	$DataPostCode=$ObjPostCodeMaster->getInternationalZones($fieldArr,$seaByArr); // Fetch Data

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
<title><?php if ($auto_id=='') { echo ADMIN_ADD_USER; } else { echo ADMIN_EDIT_USER;}?></title>
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
										<span><a href="<?php echo FILE_WELCOME_ADMIN; ?>"><?php echo ADMIN_HEADER_HOME; ?></a> > <a href="<?php echo FILE_INTERNATIONAL_ZONE_LISTING."?pagenum=".$pagenum; ?>"> <?php echo ADMIN_HEADER_POSTCODES; ?> </a> > <? echo $HeadingLabel; ?></span>
										<div><label class="top_navigation"><a href="<?php echo FILE_INTERNATIONAL_ZONE_LISTING."?pagenum=".$pagenum; ?>"><?php echo ADMIN_COMMON_BACK; ?></a></label></div>
								</td>
							</tr>
							<tr>
								<td class="heading">
									<?php echo $HeadingLabel; ?>
								</td>
							</tr>
							
											<tr>
											<td colspan="4" align="left" valign="top" class="grayheader">
											<b><?php echo ADMIN_POSTCODE_UPLOAD_CSV;?> : </td>
											</tr>
											<tr><td colspan="4">&nbsp;</td></tr>
											
											<?php
											if($message!='')
											{ ?>
											<tr>
												<td class="message_error noprint" align="center"><?php if($arr_message[$message] != ''){echo valid_output($arr_message[$message]);}else{ echo valid_output($message);} ?></td>
											</tr>
											
											<?php }  ?>		
												
											<tr>
												<td>
													<form name="frmimport" method="POST" action="international_zone_action.php" enctype="multipart/form-data">
													
														<table border="0" width="100%" cellpadding="0" cellspacing="2">
															<tr>
																<td  colspan="2"><?php // echo draw_separator($sep_width,10);?></td>															
															</tr>
															
															<tr>
																<td width="20%" class="form_caption"><?php echo ADMIN_UPLOAD_CSV;?> : </td>
																<td><input type="file" name="csv_file" id="csv_file" ></td>
															</tr>
														
															<tr>
																<td><input type="hidden" id="ptoken" value="<?php echo $ptoken; ?>" name="ptoken"><?php //echo draw_separator($sep_width,$sep_height);?></td>
																<td align="left"><input type="submit" name="btnimport" value="Upload CSV" id="btnimport" class="action_button"></td>
															</tr>
														</table>
													</form>
												</td>
											</tr>

							
							
							
							
							
							
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
																	<td colspan="4" align="left" valign="top" class="grayheader"><b><?php echo ADMIN_USERS_PERSONAL_DETAILS;?> : </b></td>
																</tr>
																<tr><td colspan="4">&nbsp;</td></tr>
																<tr>
																	<td  align="left" valign="middle"><?php echo ADMIN_COUNTRY;?></td>
																	<td  align="left" valign="middle"  class="message_mendatory">
																	<input type="text" id="distance_in_km" name="country" value="<?php if($_POST['country'] != ''){ echo valid_output($_POST['country']);}else{ echo valid_output($DataPostCode["country"]); }?>">
																	&nbsp;*<img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>internal/help_up.gif" class="help_btn" alt="<?php echo ADMIN_COUNTRY;?>"onmouseover="return overlib('<?php echo $Country_Name;?>');" onmouseout="return nd();" /></td>
																	<td  align="left" valign="middle"><?php echo ADMIN_ZONE;?></td>
																	<td  align="left" valign="top" class="message_mendatory">
																	<input type="text" id="distance_in_km" name="zone" value="<?php if($_POST['zone'] != ''){ echo valid_output($_POST['zone']);}else{ echo valid_output($DataPostCode["zone"]); }?>">
																	&nbsp;*<img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>internal/help_up.gif" class="help_btn" alt="<?php echo ADMIN_ZONE;?>"onmouseover="return overlib('<?php echo $Zone;?>');" onmouseout="return nd();" /></td>
																</tr>
																<tr>
																	<td align="left" valign="middle">&nbsp;</td>
																	<td align="left" valign="top" class="message_mendatory" id="countryError"><?php echo $err['countryError'];  ?></td>
																	<td align="left" valign="middle">&nbsp;</td>
																	<td align="left" valign="top" class="message_mendatory" id="zoneError"><?php echo $err['zoneError'];  ?></td>
																</tr>								

																<tr>
																	<td  colspan="1" align="left" valign="middle"><?php echo ADMIN_DAYS;?></td>
																	<td  colspan="1" align="left" valign="middle"  class="message_mendatory">
<input type="text" id="distance_in_km" name="days" value= "<?php if($_POST['days'] != ''){ echo $_POST['days'];}else{ echo valid_output($DataPostCode["days"]); }?>">
																	&nbsp;*<img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>internal/help_up.gif" class="help_btn" alt="<?php echo ADMIN_DAYS;?>"onmouseover="return overlib('<?php echo $Days;?>');" onmouseout="return nd();" /></td>
																	
																</tr>
																<tr>
																	<td align="left" colspan="1" valign="middle">&nbsp;</td>
																	<td align="left" valign="top" colspan="1" class="message_mendatory" id="daysError"><?php echo $err['daysError'];  ?></td>
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
											<input type="submit" class="action_button" tabindex="36" name="submit" value="<?php echo $btnSubmit; ?>"  >
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
