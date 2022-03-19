<?php

	/**
	 * This file is for adding of  Faq's for the Faq Management.
	 *
	 *
	 * @author     Radixweb <team.radixweb@gmail.com>
	 * @copyright  Copyright (c) 2008, Radixweb
	 * @version    1.0
	 */
		
	/**
	 * Include commom file
	 */
	require_once("../lib/common.php");
	
	require_once(DIR_WS_MODEL."/PublicHolidayMaster.php");
	require_once(DIR_WS_ADMIN_LANGUAGES . DIR_CURRENT_LANGUAGE. "/holiday.php");
	
	/**
	 *Include Necessary files
	 */
	$arr_css_admin_exclude[] = 'jquery.css';
	$arr_css_plugin_include[] ='bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css';
	$arr_css_plugin_include[] = 'glyphicons_new/css/glyphicons.css';
	$arr_css_plugin_include[] ='tabbed-panels/css/tabbed_panels.css';
	$arr_css_admin_include[] = 'custom-style.css';
	
	$arr_javascript_plugin_include[] = 'bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js';
	$arr_javascript_plugin_include[] = 'moment/js/moment-with-locales.min.js';
	$arr_javascript_plugin_include[] = 'bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js';
	$arr_javascript_include[] = 'internal/holiday_validation.php';
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
	 * Object Declaration
	 */
	$publicholidayMasterObj = new PublicHolidayMaster();
	$publicholidayMasterObj = $publicholidayMasterObj->create();
	$publicholidayData= new PublicHolidayData();
	
	/*csrf validation*/
	/*$csrf = new csrf();
	$csrf->action = "add_holidayaction";
	if(!isset($_POST['ptoken'])) {
		$ptoken = $csrf->csrfkey();
	}
*/
	
	/*csrf validation*/

	
	/**
	 * To create link 
	 */
	$preferences = new Preferences(); 
	$URLParameters=$preferences->GetAddressBarQueryString($NotToPass);
	if ($URLParameters!='') {
		$URLParameters="&".$URLParameters;
	}
	
	/**
	 * Variable Declaration 
	 */
	$hid           = trim($_GET['hid']);
	$subheading    = ADMIN_HOLIDAYS_ADD_LABEL;
	$btnholiday = trim($_POST['btnholiday']);
	
	if(!empty($hid))
	{
		$err['hid'] = isNumeric(valid_input($hid),ENTER_NUMERIC_VALUES_ONLY);
	}
	if(!empty($err['hid']))
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
	
	// Add edit action takes place on click of the button
	
	if($_GET['Action']!='' &&  $_GET['Action']=='export'){


	$publicholidays = $publicholidayMasterObj->getPublicHoliday();	
	
	$filename = DIR_WS_ADMIN_DOCUMENTS."holiday.csv"; //Balnk CSV File
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
	$data.= "dateid,\"sdate\",\"state\",\"name\"";
				
	if(isset($publicholidays) && !empty($publicholidays)) {		
		foreach ($publicholidays as $publicholiday) {		
			/*Code for the Currency value in which the order has been done*/
			$dateid = valid_output($publicholiday['dateid']);
			$sdate = valid_output($publicholiday['sdate']);
			$state = valid_output($publicholiday['state']);
			$description  = valid_output($publicholiday['name']);
			
			$data.= "\n";
			$data.= '"'.$dateid.'","'.$sdate.'","'.$state.'","'.$description.'"';
		}			
	}
	echo $data;
	exit();
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
					$message = SELECT_UPLOAD_CSV_FILE;
			} else {
			//  Read csv file and making array
			
			
			$SyncArray = array(
			'sdate' => 'sdate',
			'state' => 'state',
			'name' => 'name',
			
			);


			$Array_Data = readCSVFile($_FILES['csv_file']['tmp_name'], $SyncArray);
			$i = 0;
			$cnt = 0;
			if($Array_Data != '' && !empty($Array_Data)) {				
				$cnt = count($Array_Data);
				foreach ($Array_Data as $key => $record) {
					if(checkStr(valid_input($record['sdate'])))
					{
						$message = checkStr(valid_input($record['sdate']));
						echo "inside sdate";
						$Svalidation = true;
					}elseif(isEmpty($record['state'],HOLIDAY_STATE_REQUIRED))
					{
						$message = HOLIDAY_STATE_REQUIRED;
						echo "inside state";
						$Svalidation = true;
					}elseif(isEmpty($record['name'],HOLIDAY_NAME_REQUIRED))
					{
						$message = HOLIDAY_NAME_REQUIRED;
						echo "inside name";
						$Svalidation = true;
					}
				}
				if($Svalidation == true)
				{
					//$ptoken = $csrf->csrfkey();
				}
				//echo "validation:".$Svalidation;
				//exit();
				if($Svalidation == false)
				{
					foreach ($Array_Data as $key => $record) {
											
						$publicholidayData->sdate = trim($record['sdate']);
						$publicholidayData->state = trim($record['state']);
						$publicholidayData->name = trim($record['name']);
										
						$fieldArr=array("*");
						$seaByArr = array() ;
						if($publicholidayData->sdate!='' && $publicholidayData->sdate!=''){
						$seaByArr[]=array('Search_On'=>'sdate', 'Search_Value'=>"$publicholidayData->sdate", 'Type'=>'string', 'Equation'=>'=', 'CondType'=>'and', 'Prefix'=>'', 'Postfix'=>'');
						$seaByArr[]=array('Search_On'=>'state', 'Search_Value'=>"$publicholidayData->state", 'Type'=>'string', 'Equation'=>'=', 'CondType'=>'and', 'Prefix'=>'', 'Postfix'=>'');
						}else{
							break;
						}
						$DataPostCode=$publicholidayMasterObj->getPublicHoliday($fieldArr, $seaByArr); // Fetch Data

						$totalRecords = $DataPostCode[0];


						if($totalRecords!='') {
							$alreadyaddedRecord++;
						}
						else{
							$publicholidayMasterObj->addPublicHoliday($publicholidayData);
							$i = $i+1;
						}
					}
				}
			} 
			if(empty($message))		
			{
				if($i > 0) {
					$message        = MSG_ADD_SUCCESS_FOR_HOLIDAY;
					ob_start();
					header('location:'.FILE_HOLIDAY_ACTION.'?pagenum='.$pagenum.'&message='.$message);
					ob_end_flush();
					exit;
				} elseif($cnt == $alreadyaddedRecord  && $alreadyaddedRecord > 0) {
					$message = ERROR_ALREADY_INTERNATIONAL_AVAILABLE_CSV_FILE;
					header('location: '.FILE_HOLIDAY_ACTION.'?pagenum='.$pagenum.'&message='.$message);
					exit;
				}else{
					$message = ERROR_CSV_FILE_FORMAT;
					$auto_id = '';
				}
			}
		}


	}

}
if(isset($btnholiday) && !empty($btnholiday)){

	/*if(isEmpty(valid_input($_POST['ptoken']), true)){	
			logOut();
	}else{
		$csrf->checkcsrf($_POST['ptoken']);
	}	*/
	 $sdate = $_POST['txt_sdate'][1];
	 
	 $description=$_POST['txt_name'];
	 $state = $_POST['state'];

		//echo "description:".$description;
	
		
			$Svalidation = false;
			$err['err_start']	= isEmpty($sdate, ADMIN_STARTDATE_REQUIRED)?isEmpty($sdate, ADMIN_STARTDATE_REQUIRED):checkStr($sdate); 
			if(isset($_POST['state']) && $_POST['state'] == 'Please Select State')
			{
				$err['err_state'] =  HOLIDAY_STATE_REQUIRED;
			}
			$err['err_name']	= isEmpty(valid_input($_POST['txt_name']), HOLIDAY_NAME_REQUIRED); 
			//$err['err_name']		= $description ?? HOLIDAY_NAME_REQUIRED;
			
			/*$err['err_desc']	= isEmpty($description, ADMIN_DESCRIPTION_REQUIRED)?isEmpty($description, ADMIN_DESCRIPTION_REQUIRED):specialcharaChk($description);*/
			
			
			if(!empty($err['err_start']) ||  !empty($err['err_state'])||  !empty($err['err_name'])){
				$Svalidation=true;
				//$ptoken = $csrf->csrfkey();
			}
		$message1 = '';
		if($Svalidation == false)
		{ 
			
			$publicholidayData->sdate  = $sdate;
			$publicholidayData->state  = $state;
			$publicholidayData->name   = $description;
			if(isset($hid) && $hid!=''){
				//Edits data to the testimonial table
				$publicholidayData->dateid = $hid;
				$edit = $publicholidayMasterObj->editPublicHoliday($publicholidayData);
				
				if($edit){
					
				 $message1  = MSG_EDIT_SUCCESS_FOR_HOLIDAY;}
			}else {
				//Adds data to the testimonial table
				
				
			    $hid = $publicholidayMasterObj->addPublicHoliday($publicholidayData);
			    if($hid){
			     $message1  = MSG_ADD_SUCCESS_FOR_HOLIDAY;}
			}
			
			header("location:".FILE_HOLIDAY_LISTING."?pagenum=".$pagenum."&message=".$message1);
			exit;
		}
	}
	
	/* Get details for a particular id*/
	if(isset($hid) && $hid!='') {
		$seaArr[] =	array('Search_On'=>'dateid',
						'Search_Value'=>$hid,
						'Type'=>'int',
						'Equation'=>'=',
						'CondType'=>'AND',
						'Prefix'=>'',
						'Postfix'=>'');
		$publicholidayData    = $publicholidayMasterObj->getPublicHoliday(null,$seaArr);
		$publicholidayData    = $publicholidayData[0];		
		$subheading   = ADMIN_HOLIDAY_EDIT_HEADING;
		//$title        = ADMIN_TESTIMONIAL_MANAGEMENT_EDIT;

	} 
	   
	 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo ADMIN_HEADER_HOLIDAY_MANAGEMENT; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<?php
addCSSFileAdmin($arr_css_admin_include, $arr_css_admin_exclude);
addPluginCSSFile($arr_css_plugin_include,$arr_css_plugin_exclude);
addJavaScriptFile($arr_javascript_include, $arr_javascript_exclude);
addPluginJavaScriptFile($arr_javascript_plugin_include,$arr_javascript_plugin_exclude);
?>
</head>
<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0" id="main" align="center">
	<tr>
		<td valign="top">
		<?php require_once(DIR_WS_ADMIN_INCLUDES . ADMIN_FILE_HEADER);?>
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
						<table border="0" class="middle_right_content" width="100%" cellpadding="0" cellspacing="0"  align="center">
						    <tr>
								<td align="left" class="breadcrumb">
										<span><a href="<?php echo FILE_WELCOME_ADMIN; ?>"><?php echo ADMIN_HEADER_HOME; ?></a> > <a href="<?php echo FILE_HOLIDAY_LISTING."?pagenum=".$pagenum; ?>"><?php echo ADMIN_HEADER_HOLIDAY_MANAGEMENT;?></a> > <?php echo $subheading; ?></span>
										<div><label class="top_navigation"><a href="<?php echo FILE_HOLIDAY_LISTING."?pagenum=".$pagenum;?>"><?php echo ADMIN_COMMON_BACK; ?></a></label></div>
								</td>
							</tr>
							<tr>
								<td class="heading">
									<?php echo $subheading; ?>
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
												<td class="message_error noprint" align="center"><?php if($arr_message[$message]!=""){echo valid_output($arr_message[$message]);}else{ echo valid_output($message);} ?></td>
											</tr>
											
											<?php }  ?>		
												
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
							<tr><td class="message_mendatory" align="right"><?PHP echo  ADMIN_COMMAN_REQUIRED_INFO;?></td></tr>
							<tr>
								<td align="left">
									<form name="frmaddholiday" action="" method="POST" enctype="multipart/form-data" >
									<table border="0" width="100%" cellpadding="0" cellspacing="0"  align="center">
										
										<tr>
											<td colspan="2">
												<div id="TabbedPanels1" class="TabbedPanels" >
												<ul class="TabbedPanelsTabGroup">
												   <?php foreach($siteLanguage as $arrid => $languagesite) { ?>
													<li class="TabbedPanelsTab" tabindex="<?php echo $arrid; ?>" ><?php echo $languagesite['site_language_name']?></li>
													<?php } ?>
												</ul>
												<div class="TabbedPanelsContentGroup" >
												 <?php 
												 		$i=0;
														foreach($siteLanguage as $arrid => $languagesite) {
														$languagesiteid = $languagesite['site_language_id'];
												  		$hvalue = 'add';
												  	   	if($tid!=''){
														// when Editing Cms Record
														
														$testimonialSearchArr = array();
														$testimonialSearchArr[] = array('Search_On'=>'testimonial_id', 'Search_Value'=>$tid, 'Type'=>'int', 'Equation'=>'=','CondType'=>'AND', 'Prefix'=>'', 'Postfix'=>'');
														$testimonialSearchArr[] = array('Search_On'=>'site_language_id', 'Search_Value'=>$languagesite['site_language_id'], 'Type'=>'int', 'Equation'=>'=','CondType'=>'AND', 'Prefix'=>'', 'Postfix'=>'');
														$testimonialdata = $testimonialMstObj->getTestimonialDescription(null,$testimonialSearchArr);
														if($testimonialdata!= '') {
															$testimonialdata= $testimonialdata[0];
															$hvalue = 'edit';
														}
													} ?>
													<div class="TabbedPanelsContent" >
													<input type="hidden" name="thisaction[<?php echo $languagesite->site_language_id; ?>]" value="<?php echo $hvalue; ?>" >
													<table width="100%" border="0" cellpadding="0" cellspacing="0" >
														<tr><td colspan="3">&nbsp;</td></tr>
														<tr>
															<td align="left"  ><?php echo ADMIN_HOLIDAY_DATE;?></td>
															
													<?php 
														$txtquestion = $testimonialdata['testimonial_title'];
													 	if(isset($_POST['txtquestion[' .$languagesiteid.']'])) {
											                     			$txtquestion = $_POST['txtquestion[' .$languagesiteid.']'];
											                     		}
											                     	?>
													<td align="left" valign="top">
													
													<div class="form-group">
													<div class='input-group date'  id='datetimepicker6'>
													<label class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></label>
													<input type='hidden' class="form-control" id="dtp_input1" />
													
													 </div>
                                            </div>
													</td>											
												<td><input readonly type="text" id="txt_sdate" name="txt_sdate[<?php echo $languagesiteid;?>]" value="<?php  echo valid_output($publicholidayData['sdate']); ?>" class="register"><span> *<img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>internal/help_up.gif" class="help_btn" alt="<?php echo ADMIN_HOLIDAY_DATE;?>"onmouseover="return overlib('<?php echo valid_output($Start_Date);?>');" onmouseout="return nd();" /></span>
                                           
                                            </td>
											
														</tr>
														<tr>
															<td align="left" >&nbsp;</td><td align="left" >&nbsp;</td>
															<td class="message_mendatory" colspan="2" id="textsdateError"><?php if(isset($err['err_start'])) { echo $err['err_start']; } ?></td>
														</tr>
														<tr>
															<td align="left" valign="top"><?php echo ADMIN_HOLIDAY_STATE;?></td>
															<td></td>
														<td align="left" valign="top" class="message_mendatory">
															<select id="state" name="state">
																<option>Please Select State</option>
																<option <?php if(isset($publicholidayData->state) && $publicholidayData->state=='ACT'){ echo "selected";} ?>>ACT</option>
																<option <?php if(isset($publicholidayData->state) && $publicholidayData->state=='NSW'){ echo "selected";} ?>>NSW</option>
																<option <?php if(isset($publicholidayData->state) && $publicholidayData->state=='NT'){ echo "selected";} ?>>NT</option>
																<option <?php if(isset($publicholidayData->state) && $publicholidayData->state=='QLD'){ echo "selected";} ?>>QLD</option>
																<option <?php if(isset($publicholidayData->state) && $publicholidayData->state=='SA'){ echo "selected";} ?>>SA</option>
																<option <?php if(isset($publicholidayData->state) && $publicholidayData->state=='TAS'){ echo "selected";} ?>>TAS</option>
																<option <?php if(isset($publicholidayData->state) && $publicholidayData->state=='VLC'){ echo "selected";} ?>>VLC</option>
																<option <?php if(isset($publicholidayData->state) && $publicholidayData->state=='WA'){ echo "selected";} ?>>WA</option>
															</select>
															</td>
														</tr>
														<tr>
															<td align="left" >&nbsp;</td><td align="left" >&nbsp;</td>
															<td class="message_mendatory" colspan="2" id="stateError"><?php if(isset($err['err_state'])) { echo $err['err_state']; } ?></td>
														</tr> 
														<tr>
															<td align="left" valign="top"><?php echo ADMIN_HOLIDAY_NAME;?></td><td width="50px;"> </td>
															<td class="message_mendatory" valign="top">
															<textarea id="txt_name" name="txt_name" style="width:250px;" class="register"><?php echo ($publicholidayData['name']);?></textarea><span> *<img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>internal/help_up.gif" class="help_btn" alt="<?php echo ADMIN_HOLIDAY_NAME;?>"onmouseover="return overlib('<?php echo $Description;?>');" onmouseout="return nd();" /></span></td>
														</tr>
														<tr>
															<td align="left" >&nbsp;</td><td align="left" >&nbsp;</td>
															<td class="message_mendatory" colspan="2" align="left" id="nameError"><?php if(isset($err['err_name'])) { echo $err['err_name']; } ?></td>
														</tr>
														
													</table>
												  </div>
												  <?php $i++;												
													}?>												      
												</div>
											</div>
											</td>
										</tr>
										<tr><td colspan="2">&nbsp;</td></tr>
										<tr>
											<td align="left" width="18%" nowrap >&nbsp;</td>
											<td>&nbsp;</td>
										</tr>
										<tr>
											<td align="left" width="18%" nowrap >&nbsp;</td>
											<td align="left">
										<?php if(isset($hid) && $hid!='') {?>
											<input type="submit" class="action_button" name="btnholiday" value="<?php echo $subheading;?>" onclick="" >
										<?php } else {?>
									    	<input type="submit" class="action_button" name="btnholiday" value="<?php echo $subheading;?>" onclick="//javascript:return validation();" >
										<?php } ?>
											<input type="reset" class="action_button" name="btnreset" value="<?php echo ADMIN_COMMON_BUTTON_RESET?>" >
											<input type="hidden" size="34" id="ptoken" value="<?php echo $ptoken; ?>" name="ptoken">
											<input type="button"  class="action_button" name="cancel" tabindex="10" value="<?php echo ADMIN_COMMON_BUTTON_CANCEL;?>" onclick="javascript:document.location.href='<?php echo FILE_HOLIDAY_LISTING."?pagenum=".$pagenum; ?>';return true;"/>
											</td>
										</tr>
									    <tr>
											<td>&nbsp;</td>
											<td><input type="hidden" id="dateArr" value="<?php echo $date_arr; ?>" />&nbsp;</td>
										</tr>
									</table>
									</form>
								</td>
							</tr>
			   			</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr><td id="footer"><?php require_once(DIR_WS_ADMIN_INCLUDES."/".ADMIN_FILE_FOOTER);?></td></tr>
</table>

<script type="text/javascript">
//var first = moment().format('DD MMMM YYYY');
var dat = $("#dateArr").val();
var dateTest = dat.split(",");
var dateArr = [];
for(var i=0;i<dateTest.length;i++)
{
	dateArr[i] = dateTest[i];
}
/* 
$('#datetimepicker7').datetimepicker({
	weekStart: 1,
	defaultDate: new Date(),
	format: 'DD MMMM YYYY',					
	pickTime: false,
	todayHighlight: 1,
	showToday: true,
	setStartDate: 'DD MMMM YYYY',
	minDate:first,
	daysOfWeekDisabled: '0,6',
	disabledDates: [<?php echo $date_arr;?>]
});*/
//var d = $("#defaultDate").val();
var defaultDateset;
//var m = $("#minDate").val();
var minDate;
if(trim(defaultDateset) == "")
{	
	defaultDateset = moment().format();
}
if(trim(minDate) == "")
{
	minDate = moment().format();
}
$('#datetimepicker7').datetimepicker({
	date: defaultDateset,
	minDate: minDate,
	format: 'DD MMMM YYYY',
	daysOfWeekDisabled: [0,6],
	sideBySide: true,
	widgetPositioning: {
		horizontal: 'left'
	},
	showClose: true,
	ignoreReadonly:true,
	locale: 'en',
	disabledDates:dateArr
});

$("#datetimepicker7").on("dp.change",function (e) { 
	$('#txt_edate').val($('#dtp_input2').val());
});

//var first = moment().format('DD MMMM YYYY');

$('#datetimepicker6').datetimepicker({
	date: defaultDateset,
	minDate: minDate,
	format: 'DD MMMM YYYY',
	daysOfWeekDisabled: [0,6],
	sideBySide: true,
	widgetPositioning: {
		horizontal: 'left'
	},
	ignoreReadonly:true,
	showClose: true,
	locale: 'en',
	disabledDates:dateArr
});

$("#datetimepicker6").on("dp.change",function (e) { 
	$('#txt_sdate').val($('#dtp_input1').val());
});
</script>
</body>
</html>
