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
require_once(DIR_WS_MODEL . "ItemTypeMaster.php");
require_once(DIR_WS_RELATED."system_mail.php");
require_once(DIR_WS_ADMIN_LANGUAGES . DIR_CURRENT_LANGUAGE. '/item_type.php');

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
$ObjPostCodeMaster	= new ItemTypeMaster();
$ObjPostCodeMaster	= $ObjPostCodeMaster->Create();
$PostCodeData		= new ItemTypeData();
/**
	 * Inclusion and Exclusion Array of Javascript
	 */
//$arr_javascript_include[] = "internal/postcode_action.php";
//$arr_javascript_include[] = 'internal/jquery.php';
$$arr_javascript_plugin_include[] = 'datatables/datatables.min.js';

$arr_css_plugin_include[] = 'datatables/datatables.min.css';
$arr_css_plugin_include[] = 'datatables/Buttons-1.6.5/css/buttons.dataTables.min.css';
	

/*csrf validation*/
$csrf = new csrf();
$csrf->action = "item_type_action";
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
$item_id = $_GET['item_id'];
if(!empty($item_id))
{
	$err['item_id'] = isNumeric(valid_input($item_id),ENTER_NUMERIC_VALUES_ONLY);
}
if(!empty($err['item_id']))
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




	$InternationalZones = $ObjPostCodeMaster->getItemType();	

	$filename = DIR_WS_ADMIN_DOCUMENTS."item_type.csv"; //Balnk CSV File
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
	//header("Content-Type: $ctype");
	header("Content-Disposition: attachment; filename=".basename($filename).";" );
	header("Content-Transfer-Encoding: binary");
	header("Content-type:text/octect-stream");
	
	ob_clean();
	
	$curr= array("€"=>"�","£"=>"�");
	$data = "";
	$data.= "item_id,\"item_name\",\"type\",\"sorting\"";
				
	if(isset($InternationalZones) && !empty($InternationalZones)) {		
		foreach ($InternationalZones as $InternationalZone) {		
			/*Code for the Currency value in which the order has been done*/
			$item_id = $InternationalZone['item_id'];
			$item_name  = valid_output($InternationalZone['item_name']);
			$type    = valid_output($InternationalZone['type']);
			$sorting = valid_output($InternationalZone['sorting']);
			$data.= "\n";
			$data.= '"'.$item_id.'","'.$item_name.'","'.$type.'","'.$sorting.'"';
		}			
	}
	echo $data;
	exit();
}
if($_GET['Action']=='trash'){
	$ObjPostCodeMaster->deleteItemType($item_id);
	$UParam = "?pagenum=".$pagenum."&message=".MSG_DELETE_POSTCODE_SUCCESS;
	header('Location: '.FILE_ITEM_TYPE_LISTING.$UParam);
}


if($_GET['Action']=='mtrash'){
	$item_id = $_GET['m_trash_id'];
	$m_t_a=explode(",",$item_id);
	foreach($m_t_a as $val)
	{
		$error = isNumeric(valid_input($val),ENTER_NUMERIC_VALUES_ONLY);
		if(!empty($error))
		{
			logOut();
		}else
		{
			$ObjPostCodeMaster->deleteItemType($val);
		}
		
	}
	$UParam = "?pagenum=".$pagenum."&message=".MSG_DELETE_POSTCODE_SUCCESS;
	header('Location: '.FILE_ITEM_TYPE_LISTING.$UParam);
	
	
}
if((isset($_POST['submit']) && $_POST['submit'] != "")){

	if(isEmpty(valid_input($_POST['ptoken']), true)){	
		logOut();
	}else{
		//$csrf->checkcsrf($_POST['ptoken']);
	}
	$err['item_nameError'] 	= isEmpty(valid_input($_POST['item_name']), ADMIN_ITEM_IS_REQUIRED)?isEmpty(valid_input($_POST['item_name']), ADMIN_ITEM_IS_REQUIRED):checkHelp(valid_input($_POST['item_name']));
	$err['typeError']  = isEmpty(valid_input($_POST['type']), ADMIN_TYPE_IS_REQUIRED)?isEmpty(valid_input($_POST['type']), ADMIN_TYPE_IS_REQUIRED):checkStr(valid_input($_POST['type']));
	$err['sortingError']  = isEmpty(valid_input($_POST['sorting_no']), ADMIN_TYPE_IS_REQUIRED)?isEmpty(valid_input($_POST['sorting_no']), ADMIN_TYPE_IS_REQUIRED):isNumeric(valid_input($_POST['sorting_no']),ENTER_NUMERIC_VALUES_ONLY);

	
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
		
		$PostCodeData->item_name = trim($_POST['item_name']);
		$PostCodeData->type = trim($_POST['type']);
		$PostCodeData->sorting = trim($_POST['sorting_no']);
		if($item_id!=''){
			//Edit Users
			$PostCodeData->item_id = $item_id;
			$PostCodeData->sorting = trim($_POST['sorting_no']);

			$ObjPostCodeMaster->editItemType($PostCodeData);
			$UParam = "?pagenum=".$pagenum."&message=".MSG_EDIT_POSTCODE_SUCCESS;
		}else{
			$inserteditem_id = $ObjPostCodeMaster->addItemType($PostCodeData);
			$UParam = "?pagenum=".$pagenum."&message=".MSG_ADD_POSTCODE_SUCCESS;
		}

		header('Location: '.FILE_ITEM_TYPE_LISTING.$UParam);

	}

}

if(isset($_POST['btnimport']) && $_POST['btnimport']!=''){
	if(isEmpty(valid_input($_POST['ptoken']), true)){	
		logOut();
	}else{
		//$csrf->checkcsrf($_POST['ptoken']);
	}
	$message = '';
	$Error = array();

	if(isset($_FILES['csv_file']['name']) && $_FILES['csv_file']['name']!='') {
		$str_ext = substr($_FILES['csv_file']['name'],strrpos($_FILES['csv_file']['name'],'.'));
		if( strtolower($str_ext) != '.csv' ) {
			$Error['csv_file'] = ERROR_UPLOAD_CSV_FILE;
			$var_tab = 1;

		} else {
			//  Read csv file and making array
	
			$SyncArray = array(
			'item_name' => 'item_name',
			'type' => 'type',
			'sorting' => 'sorting'
			);
$Array_Data = array();

			$Array_Data = readCSVFile($_FILES['csv_file']['tmp_name'], $SyncArray);
//echo "<pre>";print_r($Array_Data);exit();
			$i = 0;$cnt=0;
			if($Array_Data != '') {
				$cnt = count($Array_Data);
				foreach ($Array_Data as $key => $record)
				{
					if(checkStr(valid_input($record['item_name'])))
					{
						$message = checkStr(valid_input($record['item_name']));
						$Svalidation = true;
					}elseif(checkStr(valid_input($record['type'])))
					{
						$message = checkStr(valid_input($record['type']));
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
					
						$PostCodeData->item_name = trim($record['item_name']);
						$PostCodeData->type = trim($record['type']);
						$PostCodeData->sorting = trim($record['sorting']);
						$fieldArr=array("*");
						$seaByArr = array() ;
						if($PostCodeData->item_name!=''){
						$seaByArr[]=array('Search_On'=>'item_name', 'Search_Value'=>"$PostCodeData->item_name", 'Type'=>'string', 'Equation'=>'LIKE', 'CondType'=>'', 'Prefix'=>'and', 'Postfix'=>'');
						}else{
							break;
						}
						$DataPostCode=$ObjPostCodeMaster->getItemType($fieldArr, $seaByArr); // Fetch Data

						$totalRecords = $DataPostCode[0];


						if($totalRecords!='') {
							$alreadyaddedRecord++;
						}
						else{
							$ObjPostCodeMaster->addItemType($PostCodeData);
							$i = $i+1;
						}
					}
				}
			} 	
			
			if(empty($message))
			{
				if($i > 0) {
					$message        = MSG_ADD_POSTCODE_SUCCESS;
					ob_start();
					header('location: '.FILE_ITEM_TYPE_ACTION.'?pagenum='.$pagenum.'&message='.$message);
					ob_end_flush();
					exit();
				} elseif($cnt == $alreadyaddedRecord  && $alreadyaddedRecord > 0) {
					$message = ERROR_ALREADY_INTERNATIONAL_AVAILABLE_CSV_FILE;
					header('location: '.FILE_ITEM_TYPE_ACTION.'?pagenum='.$pagenum.'&message='.$message);
					exit;
				}else{
					
					$Error['csv_file'] = ERROR_CSV_FILE_FORMAT;
					$item_id = '';
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
if($item_id!=''){
	
	$fieldArr=array("*");
	$seaByArr[]=array('Search_On'=>'item_id', 'Search_Value'=>"$item_id", 'Type'=>'int', 'Equation'=>'=', 'CondType'=>'', 'Prefix'=>'and', 'Postfix'=>'');

	$DataPostCode=$ObjPostCodeMaster->getItemType($fieldArr,$seaByArr); // Fetch Data

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
<title><?php if ($_GET['item_id']=='') { echo ADMIN_ADD_USER; } else { echo ADMIN_EDIT_USER;}?></title>
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
										<span><a href="<?php echo FILE_WELCOME_ADMIN; ?>"><?php echo ADMIN_HEADER_HOME; ?></a> > <a href="<?php echo FILE_ITEM_TYPE_LISTING.'?pagenum='.$pagenum; ?>"> <?php echo ADMIN_HEADER_POSTCODES; ?> </a> > <? echo $HeadingLabel; ?></span>
										<div><label class="top_navigation"><a href="<?php echo FILE_ITEM_TYPE_LISTING.'?pagenum='.$pagenum; ?>"><?php echo ADMIN_COMMON_BACK; ?></a></label></div>
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
													<form name="frmimport" method="POST" action="<?php echo FILE_ITEM_TYPE_ACTION;?>" enctype="multipart/form-data">
													
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
										
										<tr>
											<td>
												<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
													<tr>
														<td>
															<table width="98%" border="0" cellpadding="0" cellspacing="0" >
																<tr>
																	<td class="message_mendatory" align="right" colspan="4">
																		<?echo ADMIN_COMMAN_REQUIRED_INFO;?>
																	</td>
																</tr>
																<tr>
																	<td colspan="4" align="left" valign="top" class="grayheader"><b><?php echo ADMIN_USERS_PERSONAL_DETAILS;?> : </b></td>
																</tr>
																<tr><td colspan="4">&nbsp;</td></tr>
																<?php
																	$service_page_name = ($_POST['type']!="")?(valid_output($_POST['type'])):(valid_output($DataPostCode['type']));
																	
																?>
																<tr>
																	<td  align="left" valign="middle"><?php echo ADMIN_ITEM_NAME;?></td>
																	<td  align="left" valign="middle"  class="message_mendatory">
																	<input type="text" id="item_name" name="item_name" value="<?php if($_POST['item_name'] != ''){ echo valid_output($_POST['item_name']);}else{ echo valid_output($DataPostCode["item_name"]); }?>">
																	&nbsp;*<img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>internal/help_up.gif" class="help_btn" alt="<?php echo ADMIN_COUNTRY;?>"onmouseover="return overlib('<?php echo $Item_Name;?>');" onmouseout="return nd();" /></td>
																	<td  align="left" valign="middle"><?php echo ADMIN_SERVICE_PAGE_TYPE;?></td>
																	<td  align="left" valign="top" class="message_mendatory">
																	<select name="type" id="type" <?php echo $readonly; ?> >
																	<option><?php echo ADMIN_SELECT_SERVICE_PAGE_ITEM; ?></option>
																	<option <?php if($service_page_name == 'domestic'){ echo "selected='selected'";} ?>>domestic</option>
																	<!--<option <?php if($service_page_name == 'sameday'){ echo "selected='selected'";} ?>>sameday</option>
																	<option <?php if($service_page_name == 'overnight'){ echo "selected='selected'";} ?>>overnight</option>-->
																	<option <?php if($service_page_name == 'international'){ echo "selected='selected'";} ?>>international</option>
																	</select>
																	<!--<input type="text" id="type" name="type" value="<?php if($_POST['type'] != ''){ echo valid_output($_POST['type']);}else{ echo valid_output($DataPostCode["type"]); }?>">-->
																	&nbsp;*<img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>internal/help_up.gif" class="help_btn" alt="<?php echo ADMIN_ZONE;?>"onmouseover="return overlib('<?php echo $Zone;?>');" onmouseout="return nd();" /></td>
																</tr>
																
																<tr>
																	<td align="left" valign="middle">&nbsp;</td>
																	<td align="left" valign="top" class="message_mendatory" id="countryError"><?php echo $err['item_nameError'];  ?></td>
																	<td align="left" valign="middle">&nbsp;</td>
																	<td align="left" valign="top" class="message_mendatory" id="typeError"><?php echo $err['typeError'];  ?></td>
																</tr>	
																<tr>
																<td align="left" valign="middle">Sorting Value&nbsp;</td>
																<td  align="left" valign="middle"  class="message_mendatory">
																	<input type="text" id="sorting_no" name="sorting_no" value="<?php if($_POST['sorting_no'] != ''){ echo valid_output($_POST['sorting_no']);}else{ echo valid_output($DataPostCode["sorting"]); }?>">&nbsp;*<img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>internal/help_up.gif" class="help_btn" alt="<?php echo ADMIN_COUNTRY;?>"onmouseover="return overlib('<?php echo "Enter Sorting Number";?>');" onmouseout="return nd();" /></td>
																	<td></td>
																	<td></td>
																	
																</tr>
															
																<tr>
																	<td align="left" valign="middle">&nbsp;</td>
																	<td align="left" valign="top" class="message_mendatory" id="sortingError"><?php echo $err['sortingError'];  ?></td>
																	<td align="left" valign="middle">&nbsp;</td>
																	<td align="left" valign="top" class="message_mendatory" ></td>
																</tr>												
															</table>
														</td>
													</tr>
													<tr>
														<td><input type="hidden"  id="ptoken" value="<?php echo $ptoken; ?>" name="ptoken">&nbsp;</td>
													</tr>
												
												</table>
											</td>
										</tr>
										<tr>
											<td>&nbsp;</td>
										</tr>
										<tr>
											<td align="center">
											<input type="submit" class="action_button" tabindex="36" name="submit" value="<?php echo $btnSubmit; ?>" onclick="return validate_client(this.form);" >
											<input type="reset" tabindex="37" name="reset" class="action_button" value="<?php echo ADMIN_COMMON_BUTTON_RESET; ?>" >
											<input type="button"  class="action_button" name="cancel" tabindex="38" value="<?php echo ADMIN_COMMON_BUTTON_CANCEL;?>" onclick="javascript:document.location.href='<?php echo FILE_ITEM_TYPE_LISTING.'?pagenum='.$pagenum; ?>';return true;"/>
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

<script>
function validate_client()
{
	
	if($("#item_name").val() == "")
	{
		$("#countryError").html("Please enter any value.");
		return false;
	}else if($("#type").val() == '<?php echo ADMIN_SELECT_SERVICE_PAGE_ITEM; ?>')
	{
		$("#typeError").html("Please enter any value.");
		return false;
	}else{
	   return true;
	}
}
</script>