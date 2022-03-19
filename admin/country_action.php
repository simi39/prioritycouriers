<?php
/**
	* This file is for display user list
	*
	* @author     Radixweb <team.radixweb@gmail.com>
	* @copyright  Copyright (c) 2008, Radixweb
	* @version    1.0
	* @since      1.0
	*/
require_once("../lib/common.php");
require_once('pagination_top.php');
require_once(DIR_WS_MODEL . "CountryMaster.php");
require_once(DIR_WS_ADMIN_LANGUAGES . DIR_CURRENT_LANGUAGE. '/country.php');
$status = array('A'=>'active','I'=>'inactive');

/**
	 * Start :: Object declaration
	 */

		$ObjCountryMaster	= new CountryMaster();
		$ObjCountryMaster	= $ObjCountryMaster->Create();
		$CountryData		= new CountryData();
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
/*csrf validation*/
$csrf = new csrf();
$csrf->action = "country_action";
if(!isset($_POST['ptoken'])) {
	$ptoken = $csrf->csrfkey();
}


/*csrf validation*/


/*$max_id = mysql_query("select max(countries_id) as Id from postcode_locator");
$maximum_id = mysql_fetch_array($max_id);*/
/**
	 * Variable Declaration
	 */
$btnSubmit = ADMIN_BUTTON_SAVE_POSTCODE;
$HeadingLabel = ADMIN_LINK_SAVE_POSTCODE;
$countries_id = $_GET['countries_id'];
if(!empty($countries_id))
{
	$err['countriesid'] = isNumeric(valid_input($countries_id),ENTER_NUMERIC_VALUES_ONLY);
}
if(!empty($err['countriesid']))
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
	if($_GET['Action']!='' &&  $_GET['Action']=='export'){


	$Countries = $ObjCountryMaster->getCountry();	

	
	$filename = DIR_WS_ADMIN_DOCUMENTS."country.csv"; //Balnk CSV File
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
    
    $data = "countries_id,\"countries_name\",\"countries_iso_code_2\",\"zone\",\"days\",\"status\"";
	
	//$data.= PICKUP_FROM.",".DILIVER_TO.",".DISTANCEINKM;
				
	if(isset($Countries) && !empty($Countries)) {		
		foreach ($Countries as $Country) {		
			/*Code for the Currency value in which the order has been done*/

			$countries_id     = $Country['countries_id'];
			$countries_name    = valid_output($Country['countries_name']);
			$countries_iso_code_2 = valid_output($Country['countries_iso_code_2']);
			$zone = valid_output($Country['zone']);
			$days = valid_output($Country['days']);
			$status = valid_output($Country['status']);
			$data.= "\n";
			$data.= '"'.$countries_id.'","'.$countries_name.'","'.$countries_iso_code_2.'","'.$zone.'","'.$days.'","'.$status.'"';
		}			
	}
	echo $data;
	exit();
}
if($_GET['Action']=='trash'){
	$ObjCountryMaster->deleteCountry($countries_id);
	$UParam = "?pagenum=".$pagenum."&message=".MSG_DELETE_COUNTRY_SUCCESS;
	header('Location: '.FILE_COUNTRY_LISTING.$UParam);
}
if($_GET['Action']=='mtrash'){
	$countries_id= $_GET['m_trash_id'];
	$m_t_a=explode(",",$countries_id);
	foreach($m_t_a as $val)
	{
		$error = isNumeric(valid_input($val),ENTER_NUMERIC_VALUES_ONLY);
		if(!empty($error))
		{
			logOut();
		}else
		{
			$ObjCountryMaster->deleteCountry($val);
		}
		
	}
	$UParam = "?pagenum=".$pagenum."&message=".MSG_DELETE_COUNTRY_SUCCESS;
	header('Location: '.FILE_COUNTRY_LISTING.$UParam);
	
	
}
if((isset($_POST['submit']) && $_POST['submit'] != "")){
	if(isEmpty(valid_input($_POST['ptoken']), true)){	
			logOut();
	}else{
		//$csrf->checkcsrf($_POST['ptoken']);
	}
	$err['countries_nameError'] 		 = isEmpty($_POST['countries_name'], COMMON_NAME_IS_REQUIRED)?isEmpty($_POST['countries_name'], COMMON_NAME_IS_REQUIRED):checkStr(valid_input($_POST['countries_name']));
	$err['countries_iso_code_2Error'] 		 = (isEmpty(trim($_POST['countries_iso_code_2']),COMMON_ISO2_IS_REQUIRED))?isEmpty(trim($_POST['countries_iso_code_2']),COMMON_ISO2_IS_REQUIRED):checkLength(trim($_POST['countries_iso_code_2']),2,2,COMMON_ISO2_LENGHT);
	
	$err['statusError']  = isEmpty($_POST['status'], ADMIN_STATUS_IS_REQUIRED);
	$err['area_code_3Error'] 		 = (isEmpty(trim($_POST['area_code']),COMMON_AREA_CODE_IS_REQUIRED))?isEmpty(trim($_POST['area_code']),COMMON_AREA_CODE_IS_REQUIRED):areaCodePattern(valid_input($_POST['area_code']),ERROR_AREA_CODE_INVALID,'1');
	$err['statusError']  = isEmpty($_POST['status'], ADMIN_STATUS_IS_REQUIRED);
	if($_POST['countries_iso_code_2']!="")
	{
		$err['countries_iso_code_2Error'] = checkStr(trim($_POST['countries_iso_code_2']));
	}
	if(isset($_POST['zone']) && $_POST['zone']!="")
	{
		$err['zoneError'] = isNumeric(valid_input($_POST['zone']),ENTER_NUMERIC_VALUES_ONLY);
	}
	if(isset($_POST['days']) && $_POST['days']!="")
	{
		$err['daysError'] = isDays(valid_input($_POST['days']),ENTER_NUMERIC_VALUES_ONLY);
	}
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
		
		
		$CountryData->countries_name = trim($_POST['countries_name']);
		$CountryData->countries_iso_code_2 = trim($_POST['countries_iso_code_2']);
		
		$CountryData->area_code = trim($_POST['area_code']);
		$CountryData->address_format_id = '1';
		$CountryData->zone = $_POST['zone'];
		$CountryData->days = $_POST['days'];
		$CountryData->status = trim($_POST['status']);
		$CountryData->state_validation = trim($_POST['state_validation']);
		if($_GET['countries_id']!=''){
			
			$CountryData->countries_id = $_GET['countries_id'];

			$ObjCountryMaster->editCountry($CountryData);
			$UParam = "?pagenum=".$pagenum."&message=".MSG_EDIT_COUNTRY_SUCCESS;
		}else{
			$insertedcountries_id = $ObjCountryMaster->addCountry($CountryData);
			$UParam = "?pagenum=".$pagenum."&message=".MSG_ADD_COUNTRY_SUCCESS;
		}
		//echo MSG_EDIT_SUCCESS;exit();
		header('Location: '.FILE_COUNTRY_LISTING.$UParam);
		exit();

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
					$Error['csv_file'] = SELECT_UPLOAD_CSV_FILE;
			} else {
			//  Read csv file and making array
			
			
			$SyncArray = array(
			'countries_name' => 'countries_name',
			'countries_iso_code_2' => 'countries_iso_code_2',
			'status' => 'status',
			);


			$Array_Data = readCSVFile($_FILES['csv_file']['tmp_name'], $SyncArray);
			$i = 0;
			
			$cnt = 0;
			if($Array_Data != '' && !empty($Array_Data)) {				
				$cnt = count($Array_Data);
				foreach ($Array_Data as $key => $record) {
					if(checkStr(valid_input($record['countries_name'])))
					{
						$message = checkStr(valid_input($record['countries_name']));
						$Svalidation = true;
					}elseif(checkLength(trim($record['countries_iso_code_2']),2,2,COMMON_ISO2_LENGHT))
					{
						$message = checkLength(trim($record['countries_iso_code_2']),2,2,COMMON_ISO2_LENGHT);
						$Svalidation = true;
					}elseif(isEmpty($record['status'], ADMIN_STATUS_IS_REQUIRED)){
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
							
						$CountryData->countries_name = trim($record['countries_name']);
						$CountryData->countries_iso_code_2 = trim($record['countries_iso_code_2']);
						
						$CountryData->area_code = trim($record['area_code']);
						$CountryData->address_format_id = '1';
						$CountryData->status = trim($record['status']);
					
				
						$fieldArr=array("*");
						$seaByArr = array() ;
						if($CountryData->countries_name!=''){
						$seaByArr[]=array('Search_On'=>'countries_name', 'Search_Value'=>"$CountryData->countries_name", 'Type'=>'string', 'Equation'=>'=', 'CondType'=>'and', 'Prefix'=>'', 'Postfix'=>'');
						}else{
							break;
						}
						$Data=$ObjCountryMaster->getCountry($fieldArr, $seaByArr); // Fetch Data

						$totalRecords = $Data[0];


						if($totalRecords!='') {
							$alreadyaddedRecord++;
						}
						else{
							$ObjCountryMaster->addCountry($CountryData);
							$i = $i+1;
						}
					}
				}
			} 	
			if(empty($message))
			{
				if($i > 0) {
					$message   =MSG_ADD_COUNTRY_SUCCESS;		
					ob_start();
					header('location:'.FILE_COUNTRY_ACTION.'?pagenum='.$pagenum.'&message='.$message);
					ob_end_flush();
					exit;
				} elseif($cnt == $alreadyaddedRecord  && $alreadyaddedRecord > 0) {
					$message = ERROR_ALREADY_INTERNATIONAL_AVAILABLE_CSV_FILE;
					header('location: '.FILE_COUNTRY_ACTION.'?pagenum='.$pagenum.'&message='.$message);
					exit;
				}else{
					$Error['csv_file'] = ERROR_CSV_FILE_FORMAT;
					$auto_id = '';
				}
			}
		}


	}

}

/**
	 * Gets details for the user
	 */
$seaByArr = array();
$fieldArr = array();
if($countries_id!=''){
	$fieldArr=array("*");
	$seaByArr[]=array('Search_On'=>'countries_id', 'Search_Value'=>"$countries_id", 'Type'=>'int', 'Equation'=>'=', 'CondType'=>'and', 'Prefix'=>'', 'Postfix'=>'');

	$DataPostCode=$ObjCountryMaster->getCountry($fieldArr,$seaByArr,null,null,null,true,true); // Fetch Data

	$DataPostCode = $DataPostCode[0];

	//Get sign up Address

	//Variable declaration

	$btnSubmit = ADMIN_BUTTON_UPDATE_POSTCODE;
	$HeadingLabel = ADMIN_LINK_UPDATE_POSTCODE;
}

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
<title><?php if ($_GET['countries_id']=='') { echo ADMIN_ADD_USER; } else { echo ADMIN_EDIT_USER;}?></title>
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
										<span><a href="<?php echo FILE_WELCOME_ADMIN; ?>"><?php echo ADMIN_HEADER_HOME; ?></a> > <a href="<?php echo FILE_COUNTRY_LISTING; ?>"> <?php echo ADMIN_HEADER_POSTCODES; ?> </a> > <? echo $HeadingLabel; ?></span>
										<div><label class="top_navigation"><a href="<?php echo FILE_COUNTRY_LISTING; ?>"><?php echo ADMIN_COMMON_BACK;  ?></a></label></div>
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
											{ 
											?>
											<tr>
												<td class="message_error noprint" align="center"><?php if($message){ echo valid_output($message);} ?></td>
											</tr>
											
											<?php } if(!empty($Error) && $Error['csv_file']!='') {?>
											<tr>
												<td class="message_error noprint" align="center"><?php echo $Error['csv_file'] ; ?></td>
											</tr>
											<?php } ?>		
												
											<tr>
												<td>
													<form name="frmimport" method="POST" action="#" enctype="multipart/form-data">
													
														<table border="0" width="100%" cellpadding="0" cellspacing="2">
															<tr>
																<td  colspan="2"><?php // echo draw_separator($sep_width,10);?></td>															
															</tr>
															
															<tr>
																<td width="20%" class="form_caption"><?php echo ADMIN_UPLOAD_CSV;?> : </td>
																<td><input type="file" name="csv_file" id="csv_file" ></td>
															</tr>
														
															<tr>
																<td><input type="hidden" size="34" id="ptoken" value="<?php echo $ptoken; ?>" name="ptoken"><?php //echo draw_separator($sep_width,$sep_height);?></td>
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
																	<td  align="left" valign="middle"><?php echo COUNTRY_NAME;?></td>
																	<td  align="left" valign="middle"  class="message_mendatory"><input class="textbox" type="text" name="countries_name"  value="<?php if($_POST['countries_name'] != ''){ echo valid_output($_POST['countries_name']);}else{ echo valid_output($DataPostCode["countries_name"]); } ?>" maxlength="50" tabindex="18"/>&nbsp;*<img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>internal/help_up.gif" class="help_btn" alt="<?php echo COUNTRY_NAME;?>" onmouseover="return overlib('<?php echo $Country_Name;?>');" onmouseout="return nd();" /></td>
																	<td  align="left" valign="middle"><?php echo ISOCODE2;?></td>
																	<td  align="left" valign="top" class="message_mendatory"><input class="textbox" type="text" name="countries_iso_code_2"  value="<?php if($_POST['countries_iso_code_2'] != ''){ echo valid_output($_POST['countries_iso_code_2']);}else{ echo valid_output($DataPostCode["countries_iso_code_2"]); } ?>" maxlength="2" tabindex="19"/>&nbsp;*<img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>internal/help_up.gif" class="help_btn" alt="<?php echo ISOCODE2;?>" onmouseover="return overlib('<?php echo $Iso_code_Digit_2;?>');" onmouseout="return nd();" /></td>
																</tr>
																<tr>
																	<td align="left" valign="middle">&nbsp;</td>
																	<td align="left" valign="top" class="message_mendatory" id="countries_nameError"><?php echo $err['countries_nameError'];  ?></td>
																	<td align="left" valign="middle">&nbsp;</td>
																	<td align="left" valign="top" class="message_mendatory" id="countries_iso_code_2Error"><?php echo $err['countries_iso_code_2Error'];  ?></td>
																</tr>
																<tr>
																	<td  align="left" valign="middle"><?php echo ZONE;?></td>
																	<td  align="left" valign="middle"  class="message_mendatory"><input class="textbox" type="text" name="zone"  value="<?php if($_POST['zone'] != ''){ echo valid_output($_POST['zone']);}else{ echo valid_output($DataPostCode["zone"]); } ?>" maxlength="2" tabindex="18"/>&nbsp;</td>
																	<td  align="left" valign="middle"><?php echo DAYS;?></td>
																	<td  align="left" valign="top" class="message_mendatory">
	<input type="text" name="days" id="days" value="<?php if($_POST['days'] != ''){ echo valid_output($_POST['days']);}else{ echo valid_output($DataPostCode["days"]); } ?> "/>																&nbsp;</td>
																</tr>
																<tr>
																	<td align="left" valign="middle">&nbsp;</td>
																	<td align="left" valign="top" class="message_mendatory" id="zoneError"><?php echo $err['zoneError'];  ?></td>
																	<td align="left" valign="middle">&nbsp;</td>
																	<td align="left" valign="top" class="message_mendatory" id="daysError"><?php echo $err['daysError'];  ?></td>
																</tr>
																<tr>
																	<td  align="left" valign="middle"><?php echo AREA_CODE;?></td>
																	<td  align="left" valign="middle"  class="message_mendatory"><input class="textbox" type="text" name="area_code"  value="<?php if($_POST['area_code'] != ''){ echo valid_output($_POST['area_code']);}else{ echo valid_output($DataPostCode["area_code"]); } ?>" maxlength="50" tabindex="18"/>&nbsp;*<img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>internal/help_up.gif" class="help_btn" alt="<?php echo AREA_CODE;?>"  onmouseout="return nd();" /></td>
																	<td  align="left" valign="middle"><?php echo STATUS;?></td>
																	<td  align="left" valign="top" class="message_mendatory">
																	<?php
																	$cont = '';
																	$cont .= "<select name='status'><option value=''> Select Any One</option>"; 
																	foreach ($status as $key=>$value){
																	$cont .=  "<option value='".$key."'";
																	$cont .= (valid_output($key)==valid_output($DataPostCode['status']))?("selected"):("");
																	$cont .= ">".valid_output($value)."</option>";
																		
																	}
																	$cont .="</select>";
																	echo $cont ;
																	?>&nbsp;*<img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>internal/help_up.gif" class="help_btn" alt="<?php echo STATUS;?>"onmouseover="return overlib('<?php echo $Status;?>');" onmouseout="return nd();" /></td>
																</tr>									<tr>
																<td ></td>
																<td class="message_mendatory"><?php  if(isset($err['area_code_3Error'])){ echo $err['area_code_3Error'];} ?></td>
																<td></td><td align="left" valign="top" class="message_mendatory" id="statusError"><?php echo $err['statusError'];  ?></td>
																</tr>
																<tr>
																	<td  align="left" valign="middle"><?php echo STATE_VALIDATION_COMPULSORY;?></td>
																	<td  align="left" valign="middle"  class="message_mendatory"><input class="textbox" type="checkbox" name="state_validation"  value="1" <?php if(isset($DataPostCode->state_validation) && $DataPostCode->state_validation=="1"){echo "checked";}elseif(isset($_POST['state_validation']) && $_POST['state_validation']=="1"){ echo "checked";} ?>/>&nbsp;<img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>internal/help_up.gif" class="help_btn" alt="<?php echo STATE_COMPULSARY_INFO;?>"onmouseover="return overlib('<?php echo STATE_COMPULSARY_INFO;?>');" onmouseout="return nd();" /></td>
																	<td  align="left" valign="middle"></td>
																	<td  align="left" valign="top" class="message_mendatory">
																	&nbsp;*<img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>internal/help_up.gif" class="help_btn" alt="<?php echo STATUS;?>"onmouseover="return overlib('<?php echo $Status;?>');" onmouseout="return nd();" /></td>
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
											<input type="button"  class="action_button" name="cancel" tabindex="38" value="<?php echo ADMIN_COMMON_BUTTON_CANCEL;?>" onclick="javascript:document.location.href='<?php echo FILE_COUNTRY_LISTING."?pagenum=".$pagenum; ?>';return true;"/>
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

