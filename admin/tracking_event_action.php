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
require_once(DIR_WS_MODEL . "tracking_evantMaster.php");
require_once(DIR_WS_RELATED."system_mail.php");
require_once(DIR_WS_ADMIN_LANGUAGES . DIR_CURRENT_LANGUAGE. '/tracking_evant.php');
$arr_javascript_include[] = 'booking.js';
$arr_javascript_include[] = 'pickup.js';
//$arr_javascript_include[] = 'mod_date.js';
$arr_javascript_include[] = 'xc2_inpage.js';
$arr_javascript_include[] = 'xc2_default.js';

$pagenum = ($_GET['pagenum']!="")?($_GET['pagenum']):(1);

if(!empty($pagenum))
{
	$err['pagenum'] = isNumeric(valid_input($pagenum),ENTER_NUMERIC_VALUES_ONLY);
}
if(!empty($err['pagenum']))
{
	logOut();
}
$arr_css_include[] = DIR_HTTP_SITE_CURRENT_TEMPLATE_CSS.'default.css';

/**
	 * Start :: Object declaration
	 */
$Objtracking_evantMaster	= new tracking_evantMaster();
$Objtracking_evantMaster	= $Objtracking_evantMaster->Create();
$tracking_evantData		= new tracking_evantData();
/**
	 * Inclusion and Exclusion Array of Javascript
	 */
$arr_javascript_include[] = "postcode_action.php";
$arr_javascript_plugin_include[] = "overlib.js";
$arr_javascript_plugin_include[] = 'datatables/js/jquery.dataTables.min.js';

/*csrf validation*/
$csrf = new csrf();
$csrf->action = "add_addressbook";
if(!isset($_POST['ptoken'])) {
	$ptoken = $csrf->csrfkey();
}

/*csrf validation*/


/*$max_id = mysql_query("select max(auto_id) as Id from postcode_locator");
$maximum_id = mysql_fetch_array($max_id);*/
/**
	 * Variable Declaration
	 */
$btnSubmit = ADMIN_BUTTON_SAVE_POSTCODE;
$HeadingLabel = ADMIN_LINK_SAVE_POSTCODE;
$tracking_evant_id = $_GET['tracking_evant_id'];
if(!empty($tracking_evant_id))
{
	$err['tracking_evant'] = isNumeric(valid_input($tracking_evant_id),ENTER_NUMERIC_VALUES_ONLY);
}
if(!empty($err['tracking_evant']))
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


	$ScheduleDeliveries = $Objtracking_evantMaster->gettracking_evant();	
	
	$filename = DIR_WS_ADMIN_DOCUMENTS."tracking_evant.csv"; //Balnk CSV File
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
	$data.= "tracking_evant_id,\"eventid\",\"description\"";
				
	if(isset($ScheduleDeliveries) && !empty($ScheduleDeliveries)) {		
		foreach ($ScheduleDeliveries as $ScheduleDelivery) {		
			/*Code for the Currency value in which the order has been done*/
			$tracking_evant_id = valid_output($ScheduleDelivery['tracking_evant_id']);
			$eventid = valid_output($ScheduleDelivery['eventid']);
			$description  = valid_output($ScheduleDelivery['description']);
			
			$data.= "\n";
			$data.= '"'.$tracking_evant_id.'","'.$eventid.'","'.$description.'"';
		}			
	}
	echo $data;
	exit();
}
if($_GET['Action']=='trash'){
	$Objtracking_evantMaster->deletetracking_evant($tracking_evant_id);
	$UParam = "?pagenum=".$pagenum."&message=".MSG_DELETE_POSTCODE_SUCCESS;
	header('Location: '.FILE_TRACKING_EVANT_LISTING.$UParam);
}
if($_GET['Action']=='mtrash'){
	$tracking_evant_id= $_GET['m_trash_id'];
	$m_t_a=explode(",",$tracking_evant_id);
	foreach($m_t_a as $val)
	{
		$error = isNumeric(valid_input($val),ENTER_NUMERIC_VALUES_ONLY);
		if(!empty($error))
		{
			logOut();
		}else
		{
			$Objtracking_evantMaster->deletetracking_evant($val);
		}
		
	}
		$UParam = "?pagenum=".$pagenum."&message=".MSG_DELETE_POSTCODE_SUCCESS;
	header('Location: '.FILE_TRACKING_EVANT_LISTING.$UParam);
}
if((isset($_POST['submit']) && submit != "")){
	if(isEmpty(valid_input($_POST['ptoken']), true)){	
		logOut();
	}else{
		$csrf->checkcsrf($_POST['ptoken']);
	}
	$event_id = $_POST['eventid'];
	$err['eventidError']  = (isEmpty(valid_input($event_id),COMMON_EVENT_IS_REQUIRED))?isEmpty(trim($event_id),COMMON_EVENT_IS_REQUIRED):isNumeric(valid_input($event_id),COMMON_EVENT_NUMERIC);
	$err['descriptionError'] = isEmpty(valid_input($_POST['description']), COMMON_DESCRIPTION_IS_REQUIRED)?isEmpty(trim($_POST['description']), COMMON_DESCRIPTION_IS_REQUIRED):checkStr(valid_input($_POST['description']));
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

		
		
          if($tracking_evant_id!=""){
          	$seaByArr[]=array('Search_On'=>'tracking_evant_id', 'Search_Value'=>"$tracking_evant_id", 'Type'=>'int', 'Equation'=>'!=', 'CondType'=>'and', 'Prefix'=>'', 'Postfix'=>'');
          }
          	$seaByArr[]=array('Search_On'=>'eventid', 'Search_Value'=>"$event_id", 'Type'=>'int', 'Equation'=>'=', 'CondType'=>'and', 'Prefix'=>'', 'Postfix'=>'');
			$DataPostCode=$Objtracking_evantMaster->gettracking_evant($fieldArr,$seaByArr); // Fetch Data
			$totalRecordsForTracking = $DataPostCode[0];
			
			$tracking_evantData->eventid = valid_input($_POST['eventid']);
			$tracking_evantData->description = valid_input($_POST['description']);
		
		if($tracking_evant_id!='' ){
			//Edit Users
			if($totalRecordsForTracking==''){
			$tracking_evantData->tracking_evant_id = $tracking_evant_id;
			$Objtracking_evantMaster->edittracking_evant($tracking_evantData);
			$UParam = "?pagenum=".$pagenum."&message=".MSG_EDIT_POSTCODE_SUCCESS;
			$url = FILE_TRACKING_EVANT_LISTING;
			}else{
				$url = FILE_TRACKING_EVANT_ACTION;
				$UParam = "?pagenum=".$pagenum."&tracking_evant_id=$tracking_evant_id&message=".MSG_EDIT_POSTCODE_FAILURE;
			}
			
		}else{
			if($totalRecordsForTracking==''){	
			$insertedtracking_evant_id = $Objtracking_evantMaster->addtracking_evant($tracking_evantData);
			$UParam = "?pagenum=".$pagenum."&message=".MSG_ADD_POSTCODE_SUCCESS;
			$url = FILE_TRACKING_EVANT_LISTING;
			}
			else{
				$url = FILE_TRACKING_EVANT_ACTION;
				$UParam = "?pagenum=".$pagenum."&tracking_evant_id=$tracking_evant_id&message=".MSG_EDIT_POSTCODE_FAILURE;
			}
		}

		header('Location:'.$url.$UParam);

	}

}

if(isset($_POST['btnimport']) && $_POST['btnimport']!=''){
	$message = '';
	$Error = array();
	if(isEmpty(valid_input($_POST['ptoken']), true)){	
		logOut();
	}else{
		$csrf->checkcsrf($_POST['ptoken']);
	}
	if(isset($_FILES['csv_file']['name']) && $_FILES['csv_file']['name']!='') {
		$str_ext = substr($_FILES['csv_file']['name'],strrpos($_FILES['csv_file']['name'],'.'));
		if( strtolower($str_ext) != '.csv' ) {
			$Error['csv_file'] = SELECT_UPLOAD_CSV_FILE;
			$var_tab = 1;

		} else {
			//  Read csv file and making array

			$SyncArray = array(
			'eventid' => 'eventid',
			'description' => 'description',
			);


			$Array_Data = readCSVFile($_FILES['csv_file']['tmp_name'], $SyncArray);
			$cnt = 0;
			if($Array_Data != '') {
				$cnt = count($Array_Data);
				foreach ($Array_Data as $key => $record) {
					if(isNumeric(valid_input($record['eventid']),COMMON_EVENT_NUMERIC))
					{
						$message = isNumeric(valid_input($record['eventid']),COMMON_EVENT_NUMERIC);
						$Svalidation = true;
					}elseif(checkStr(valid_input($record['description'])))
					{
						$message = checkStr(valid_input($record['description']));
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
						$tracking_evantData->eventid = trim($record['eventid']);
						$tracking_evantData->description = trim($record['description']);
						
						$fieldArr=array("*");
						$seaByArr = array() ;
						if($tracking_evantData->eventid != ''){
						$seaByArr[]=array('Search_On'=>'eventid', 'Search_Value'=>"$tracking_evantData->eventid", 'Type'=>'int', 'Equation'=>'LIKE', 'CondType'=>'and', 'Prefix'=>'', 'Postfix'=>'');
						}else{
							break;
						}
						$DataPostCode=$Objtracking_evantMaster->gettracking_evant($fieldArr,$seaByArr); // Fetch Data

						$totalRecords = $DataPostCode[0];


						if($totalRecords!='') {
							$alreadyaddedRecord++;
						}
						else{
							$Objtracking_evantMaster->addtracking_evant($tracking_evantData);
							$i = $i+1;
						}
					}
				}
			}
			if($Svalidation == false)
			{
				if($i > 0) {
					$message        = MSG_ADD_POSTCODE_SUCCESS;
					$var_tab = 1;
					ob_start();				
					header("Location:".FILE_TRACKING_EVANT_ACTION.'?paegnum='.$pagenum.'&message='.$message);
					ob_end_flush();
					exit;
				} elseif($cnt == $alreadyaddedRecord  && $alreadyaddedRecord > 0) {
					$message = ERROR_ALREADY_INTERNATIONAL_AVAILABLE_CSV_FILE;
					header('location: '.FILE_TRACKING_EVANT_ACTION.'?paegnum='.$pagenum.'&message='.$message);
					exit;
				}else{
					$Error['csv_file'] = ERROR_CSV_FILE_FORMAT;
					$tracking_evant_id = '';
					
				} 
			}
		}
	}else{
		$Error['csv_file'] = SELECT_UPLOAD_CSV_FILE;
	}

}

/**
	 * Gets details for the user
	 */
if($tracking_evant_id!=''){
	$fieldArr=array("*");
	$seaByArr[]=array('Search_On'=>'tracking_evant_id', 'Search_Value'=>"$tracking_evant_id", 'Type'=>'string', 'Equation'=>'=', 'CondType'=>'and', 'Prefix'=>'', 'Postfix'=>'');

	$DataPostCode=$Objtracking_evantMaster->gettracking_evant($fieldArr, $seaByArr); // Fetch Data

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
<title><?php if ($_GET['tracking_evant_id']=='') { echo ADMIN_ADD_USER; } else { echo ADMIN_EDIT_USER;}?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<?php 
addPluginCSSFile($arr_css_plugin_include,$arr_css_plugin_exclude);
addCSSFileAdmin($arr_css_admin_include, $arr_css_admin_exclude);
addJavaScriptFile($arr_javascript_include, $arr_javascript_exclude);
addPluginJavaScriptFile($arr_javascript_plugin_include,$arr_javascript_plugin_exclude);
?>
</head>
<body >
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
										<span><a href="<?php echo FILE_WELCOME_ADMIN; ?>"><?php echo ADMIN_HEADER_HOME; ?></a> > <a href="<?php echo FILE_TRACKING_EVANT_LISTING."?pagegnum=".$pagenum; ?>"> <?php echo ADMIN_HEADER_POSTCODES; ?> </a> > <? echo $HeadingLabel; ?></span>
										<div><label class="top_navigation"><a href="<?php echo FILE_TRACKING_EVANT_LISTING."?pagegnum=".$pagenum; ?>"><?php echo ADMIN_COMMON_BACK; ?></a></label></div>
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
												<td class="message_error noprint" align="center"><?php if($message!=''){ echo valid_output($message);}  ?></td>
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
										<input type="hidden" name="tracking_evant_id" value="<?php echo $_GET['tracking_evant_id'];?>"  />
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
																	<td align="left" valign="middle"  nowrap="nowrap"><?php echo EVENT_ID;?></td>
																	
																	<td  align="left" valign="middle" class="message_mendatory">
																	<input name="eventid" class="textbox"  value="<?php if($_POST['eventid'] != ''){ echo $_POST['eventid'];}else{ echo $DataPostCode["eventid"]; } ?>" tabindex="20"/>&nbsp;*<img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>internal/help_up.gif" class="help_btn" alt="<?php echo EVENT_ID;?>"onmouseover="return overlib('<?php echo $Event_Id;?>');" onmouseout="return nd();" />
																	</td>
																	<td align="left" valign="middle"><?php echo DESCRIPTION;?></td>
																	<td align="left" valign="top">
																	<input name="description" class="textbox"  value="<?php if($_POST['description'] != ''){ echo valid_output($_POST['description']);}else{ echo valid_output($DataPostCode["description"]); } ?>" tabindex="20"/>&nbsp;*	<img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>internal/help_up.gif" class="help_btn" alt="<?php echo DESCRIPTION;?>"onmouseover="return overlib('<?php echo $Description;?>');" onmouseout="return nd();" />
																	</td>
																</tr>
																<tr>
																	<td align="left" valign="middle">&nbsp;</td>
																	<td align="left" valign="top" class="message_mendatory" id="ready_byError"><?php echo $err['eventidError'];  ?></td>
																	<td align="left" valign="middle">&nbsp;</td>
																	<td align="left" valign="top" class="message_mendatory" id="descriptionError"><?php echo $err['descriptionError'];  ?></td>
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
											<input type="button"  class="action_button" name="cancel" tabindex="38" value="<?php echo ADMIN_COMMON_BUTTON_CANCEL;?>" onclick="javascript:document.location.href='<?php echo FILE_TRACKING_EVANT_LISTING."?pagegnum=".$pagenum; ?>';return true;"/>
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
