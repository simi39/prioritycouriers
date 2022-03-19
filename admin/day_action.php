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
require_once(DIR_WS_MODEL . "DayNameMaster.php");
require_once(DIR_WS_MODEL . "KmGridMaster.php");
require_once(DIR_WS_RELATED . "system_mail.php");
require_once(DIR_WS_ADMIN_LANGUAGES . DIR_CURRENT_LANGUAGE. '/dayname.php');

/**
	 * Start :: Object declaration
	 */
		$ObjDayNameMaster	= new DayNameMaster();
		$ObjDayNameMaster	= $ObjDayNameMaster->Create();
		$DayNameData		= new DayNameData();
/**
	 * Inclusion and Exclusion Array of Javascript
	 */
	 $arr_css_admin_exclude[] = 'jquery.css';
	 $arr_css_plugin_include[] ='tabbed-panels/css/tabbed_panels.css';
	
$arr_javascript_include[] = "postcode_action.php";
$arr_javascript_include[] = "jquery.dataTables.js";

/*csrf validation*/
$csrf = new csrf();
$csrf->action = "day_action";
if(!isset($_POST['ptoken'])) {
	$ptoken = $csrf->csrfkey();
}

/*csrf validation*/


/*$max_id = mysql_query("select max(day_id) as Id from postcode_locator");
$maximum_id = mysql_fetch_array($max_id);*/
/**
	 * Variable Declaration
	 */
$btnSubmit = ADMIN_BUTTON_SAVE_POSTCODE;
$HeadingLabel = ADMIN_LINK_SAVE_POSTCODE;
$day_id = $_GET['day_id'];
if(!empty($day_id))
{
	$err['day_id'] = isNumeric(valid_input($day_id),ENTER_NUMERIC_VALUES_ONLY);
}
if(!empty($err['day_id']))
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
	if($_GET['Action']!='' &&  $_GET['Action']=='export_kmgrid_csv'){


	$KmGrids = $ObjDayNameMaster->getDayName();	

	
	$filename = DIR_WS_ADMIN_DOCUMENTS."day.csv"; //Balnk CSV File
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

	$data.= "day,\"day_name\"";
	//$data.= PICKUP_FROM.",".DILIVER_TO.",".DISTANCEINKM;
				
	if(isset($KmGrids) && !empty($KmGrids)) {		
		foreach ($KmGrids as $KmGrid) {		
			/*Code for the Currency value in which the order has been done*/

			$day = valid_output($KmGrid['day']);
			$day_name = valid_output($KmGrid['day_name']);
		
			$data.= "\n";
			$data.= '"'.$day.'","'.$day_name.'"';
		}			
	}
	echo $data;
	exit();
}
if($_GET['Action']=='trash'){
	$ObjDayNameMaster->deleteDayName($day_id);
	$UParam = "?pagenum=".$pagenum."&message=".MSG_DELETE_KM_GRID_SUCCESS;
	header('Location: '.FILE_DAY_LISTING.$UParam);
}
if($_GET['Action']=='mtrash'){
	$day_id= $_GET['m_trash_id'];
	$m_t_a=explode(",",$day_id);
	foreach($m_t_a as $val)
	{
		$error = isNumeric(valid_input($val),ENTER_NUMERIC_VALUES_ONLY);
		if(!empty($error))
		{
			logOut();
		}else
		{
			$ObjDayNameMaster->deleteDayName($val);
		}
		
	}
    $UParam = "?pagenum=".$pagenum."&message=".MSG_DELETE_KM_GRID_SUCCESS;
	header('Location: '.FILE_DAY_LISTING.$UParam);	
}
if((isset($_POST['submit']) && $_POST['submit'] != "")){
	/*if(isEmpty(valid_input($_POST['ptoken']), true)){	
			logOut();
	}else{
		$csrf->checkcsrf($_POST['ptoken']);
	}*/
	$err['DayError'] 		 = isEmpty(valid_input($_POST['day_name']), COMMON_NAME_IS_REQUIRED)?isEmpty(valid_input($_POST['day_name']), COMMON_NAME_IS_REQUIRED):checkStr(valid_input($_POST['day_name']));
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
		
		$DayNameData->day_name = trim($_POST['day_name']);
			if($day_id!=''){

			$DayNameData->day = $day_id;

			$ObjDayNameMaster->editDayName($DayNameData);
			$UParam = "?pagenum=".$pagenum."&message=".MSG_EDIT_KMGRID_SUCCESS;
		}else{
			$insertedday_id = $ObjDayNameMaster->addDayName($DayNameData);
			$UParam = "?pagenum=".$pagenum."&message=".MSG_ADD_KMGRID_SUCCESS;
		}
		header('Location:'.FILE_DAY_LISTING.$UParam);
		exit();

	}

}

if(isset($_POST['btnimport']) && $_POST['btnimport']!=''){
	
	/*if(isEmpty(valid_input($_POST['ptoken']), true)){	
		logOut();
	}else{
		$csrf->checkcsrf($_POST['ptoken']);
	}*/
	$message = '';

	$Error = array();

	if(isset($_FILES['csv_file']['name']) && $_FILES['csv_file']['name']!='') {
		$str_ext = substr($_FILES['csv_file']['name'],strrpos($_FILES['csv_file']['name'],'.'));
		if( strtolower($str_ext) != '.csv' ) {
					$Error['csv_file'] = SELECT_UPLOAD_CSV_FILE;
			} else {
			//  Read csv file and making array
			$SyncArray = array(
			'day_name' => 'day_name',
			);


			$Array_Data = readCSVFile($_FILES['csv_file']['tmp_name'], $SyncArray);
			$i = 0;
			$cnt = 0;
			if($Array_Data != '' && !empty($Array_Data)) {				
				$cnt = count($Array_Data);
				foreach ($Array_Data as $key => $record) {
					if(checkStr(valid_input($record['day_name'])))
					{
						$message = checkStr(valid_input($record['day_name']));
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

						$DayNameData->day_name= trim($record['day_name']);
						$fieldArr=array("*");
						$seaByArr = array() ;
						if($DayNameData->day_name!='' ){
						$seaByArr[]=array('Search_On'=>'day_name', 'Search_Value'=>"$DayNameData->day_name", 'Type'=>'string', 'Equation'=>'LIKE', 'CondType'=>'', 'Prefix'=>'', 'Postfix'=>'');
						
						}else{
							break;
						}
						$Data=$ObjDayNameMaster->getDayName($fieldArr, $seaByArr); // Fetch Data
						$totalRecords = $Data[0];
						
						if($totalRecords!='') {
							$alreadyaddedRecord++;
						}
						else{
							$ObjDayNameMaster->addDayName($DayNameData);
							$i = $i+1;
						}
					}
				}	
			} 
			if(empty($message))
			{
				if($i > 0) {
					$message        = MSG_ADD_KMGRID_SUCCESS;
					ob_start();
					header('location:'.FILE_DAY_ACTION.'?pagenum='.$pagenum.'&message='.$message);
					ob_end_flush();
					exit;
				} elseif($cnt == $alreadyaddedRecord  && $alreadyaddedRecord > 0) {
					$message = ERROR_ALREADY_INTERNATIONAL_AVAILABLE_CSV_FILE;
					header('location: '.FILE_DAY_ACTION.'?pagenum='.$pagenum.'&message='.$message);
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
if($day_id!=''){
	$fieldArr=array("*");
	$seaByArr[]=array('Search_On'=>'day', 'Search_Value'=>"$day_id", 'Type'=>'int', 'Equation'=>'=', 'CondType'=>'', 'Prefix'=>'', 'Postfix'=>'');

	$DataPostCode=$ObjDayNameMaster->getDayName($fieldArr,$seaByArr,null,null,null,true,true); // Fetch Data

	$DataPostCode = $DataPostCode[0];

	//Get sign up Address

	//Variable declaration

	$btnSubmit = ADMIN_BUTTON_UPDATE_POSTCODE;
	$HeadingLabel = ADMIN_LINK_UPDATE_POSTCODE;
}
$message= $arr_message[$_GET['message']];
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
<title><?php if ($_GET['day_id']=='') { echo ADMIN_ADD_USER; } else { echo ADMIN_EDIT_USER;}?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<?php
addCSSFileAdmin($arr_css_admin_include, $arr_css_admin_exclude);
addPluginCSSFile($arr_css_plugin_include,$arr_css_plugin_exclude);
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
					<table class="middle_right_content" align="center" border="0" cellpadding="0" cellspacing="0">
							<tr>
								<td align="left" class="breadcrumb">
										<span><a href="<?php echo FILE_WELCOME_ADMIN; ?>"><?php echo ADMIN_HEADER_HOME; ?></a> > <a href="<?php echo FILE_DAY_LISTING; ?>"> <?php echo ADMIN_HEADER_KM_GRID; ?> </a> > <? echo $HeadingLabel; ?></span>
										<div><label class="top_navigation"><a href="<?php echo FILE_DAY_LISTING; ?>"><?php echo ADMIN_COMMON_BACK; ?></a></label></div>
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
												<td class="message_error noprint" align="center"><?php echo valid_output($message); ?></td>
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
																<td><input type="hidden"  id="ptoken" value="<?php echo $ptoken; ?>" name="ptoken"><?php //echo draw_separator($sep_width,$sep_height);?></td>
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
										<input type="hidden" name="Id" value="<?php // echo $maximum_id[0];?>"  />
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
																	<td  colspan="1" align="left" valign="middle"><?php echo ADMIN_DISTANCE;?></td>
																	<td  colspan="1" align="left" valign="middle"  class="message_mendatory"><input type="text" id="day_name" name="day_name" value="<?php if($_POST['day_name'] != ''){ echo valid_output($_POST['day_name']);}else{ echo valid_output($DataPostCode['day_name']); } ?>">&nbsp;*<img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>internal/help_up.gif" class="help_btn" alt="<?php echo ADMIN_DISTANCE;?>"onmouseover="return overlib('<?php echo $Day_Name;?>');" onmouseout="return nd();" /></td>
																	
																</tr>
																<tr>
																	<td align="left" colspan="1" valign="middle">&nbsp;</td>
																	<td align="left" valign="top" colspan="1" class="message_mendatory" id="distance_in_kmError"><?php echo $err['DayError'];  ?></td>
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
											<input type="button"  class="action_button" name="cancel" tabindex="38" value="<?php echo ADMIN_COMMON_BUTTON_CANCEL;?>" onclick="javascript:document.location.href='<?php echo FILE_DAY_LISTING."?pagenum=".$pagenum; ?>';return true;"/>
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
<?php //require_once(DIR_WS_JSCRIPT."/jquery.php"); ?>
