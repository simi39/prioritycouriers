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
require_once(DIR_WS_MODEL ."PostCodeMaster.php");
require_once(DIR_WS_MODEL ."KmGridMaster.php");
require_once(DIR_WS_RELATED."system_mail.php");
require_once(DIR_WS_ADMIN_LANGUAGES . DIR_CURRENT_LANGUAGE. '/kmgrid.php');

/**
	 * Start :: Object declaration
	 */
$ObjPostCodeMaster	= new PostCodeMaster();
$ObjPostCodeMaster	= $ObjPostCodeMaster->Create();
$PostCodeData		= new PostCodeData();
$ObjKmGridMaster	= new KmGridMaster();
$ObjKmGridMaster	= $ObjKmGridMaster->Create();
$KmGridData		= new KmGridData();
/**
	 * Inclusion and Exclusion Array of Javascript
	 */
$arr_javascript_include[] = 'internal/ajex.js';
$arr_javascript_include[] = 'internal/ajax-dynamic-list.js';
$arr_javascript_include[] = "postcode_action.php";
$arr_javascript_include[] = "internal/kmgrid_details.php";

$arr_javascript_plugin_include[] = "overlib.js";
$arr_javascript_plugin_include[] = 'datatables/js/jquery.dataTables.min.js';

/*$max_id = mysql_query("select max(km_grid_id) as Id from postcode_locator");
$maximum_id = mysql_fetch_array($max_id);*/
/**
	 * Variable Declaration
	 */
	 
/*csrf validation*/
$csrf = new csrf();
$csrf->action = "kmgrid";
if(!isset($_POST['ptoken'])) {
	$ptoken = $csrf->csrfkey();
}

/*csrf validation*/

	 
$btnSubmit = ADMIN_BUTTON_SAVE_POSTCODE;
$HeadingLabel = ADMIN_LINK_SAVE_POSTCODE;
$km_grid_id = $_GET['km_grid_id'];
$pagenum = ($_GET['pagenum']!="")?($_GET['pagenum']):(1);
if(!empty($pagenum))
{
	$err['pagenum'] = isNumeric(valid_input($pagenum),ENTER_NUMERIC_VALUES_ONLY);
}
if(!empty($err['pagenum']))
{
	logOut();
}
if(!empty($km_grid_id))
{
	$err['km_grid_id'] = isNumeric(valid_input($km_grid_id),ENTER_NUMERIC_VALUES_ONLY);
}
if(!empty($err['km_grid_id']))
{
	logOut();
}
if((isset($_POST['submit']) && $_POST['submit'] != "")){
	//echo "<pre>";print_r($_POST)."</pre>";
	if(isEmpty(valid_input($_POST['ptoken']), true)){	
		logOut();
	}else{
		//$csrf->checkcsrf($_POST['ptoken']);
	}
	$err['PickUpError'] 		= isEmpty(trim($_POST['fetchpickupid']), COMMON_FETCH_IS_REQUIRED)?isEmpty(trim($_POST['fetchpickupid']), COMMON_FETCH_IS_REQUIRED):isNumeric(valid_input($_POST['fetchpickupid']),ERROR_POSTCODE_REQUIRE_IN_NUMERIC);
	$err['DeliverToError'] 		= isEmpty(trim($_POST['fetchdeliveryid']), COMMON_FETCH_IS_REQUIRED)?isEmpty(trim($_POST['fetchdeliveryid']), COMMON_FETCH_IS_REQUIRED):isNumeric(valid_input($_POST['fetchdeliveryid']),ERROR_POSTCODE_REQUIRE_IN_NUMERIC);
	$err['distance_in_kmError'] = isEmpty(trim($_POST['distance_in_km']), ADMIN_POSTCODE_STATE_IS_REQUIRED)?isEmpty(trim($_POST['distance_in_km']), ADMIN_POSTCODE_STATE_IS_REQUIRED):isNumeric(valid_input($_POST['distance_in_km']),ERROR_POSTCODE_REQUIRE_IN_NUMERIC);
	/* Checking Error Exists */
	foreach($err as $key => $Value) {
		if($Value != '') {
			$Svalidation=true;
			$ptoken = $csrf->csrfkey();
		}
	}
//echo "<pre>";print_r($err);die();
	if($Svalidation==false){
		
		$KmGridData->pickup_id = trim($_POST['fetchpickupid']);
		$KmGridData->delivery_id = trim($_POST['fetchdeliveryid']);
		$KmGridData->distance_in_km = trim($_POST['distance_in_km']);
		
		if($km_grid_id!=''){
			//Edit KM Grid Data*/
			$KmGridData->km_grid_id = $km_grid_id;
			$ObjKmGridMaster->editKmGrid($KmGridData);
			$UParam = "?pagenum=".$pagenum."&message=".MSG_EDIT_KMGRID_SUCCESS;
		}else{
			$insertedkm_grid_id = $ObjKmGridMaster->addKmGrid($KmGridData);
			$UParam = "?pagenum=".$pagenum."&message=".MSG_ADD_KMGRID_SUCCESS;
		}
		header('Location:kmgrid_listing.php'.$UParam);
		exit();
	}
}

/*Export Csv Starts Here : Code for the Export of the PostCodes into csv Format*/
if($_GET['Action']!='' &&  $_GET['Action']=='export_kmgrid_csv'){


	$KmGrids = $ObjKmGridMaster->getKmGrid($fieldArr=null, $seaArr=null, $optArr=null, $start=null, $total=null, $ThrowError=true,$changeData = true);


	$filename = DIR_WS_ADMIN_DOCUMENTS."kmgrid.csv"; //Balnk CSV File
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

	$data.= "pickup_id,\"delivery_id\",\"distance_in_km\"";
	//$data.= PICKUP_FROM.",".DILIVER_TO.",".DISTANCEINKM;

	if(isset($KmGrids) && !empty($KmGrids)) {
		foreach ($KmGrids as $KmGrid) {
			/*Code for the Currency value in which the order has been done*/

			$pickup_id       = valid_output($KmGrid['pickup_id']);
			$delivery_id     = valid_output($KmGrid['delivery_id']);
			$distance_in_km  = $KmGrid['distance_in_km'];

			$data.= "\n";
			$data.= '"'.$pickup_id.'","'.$delivery_id.'","'.$distance_in_km.'"';
		}
	}
	echo $data;
	exit();
}

if($_GET['Action']=='trash'){
	$ObjKmGridMaster->deleteKmGrid($km_grid_id);
	$UParam = "?pagenum=".$pagenum."&message=".MSG_DELETE_KM_GRID_SUCCESS;
	header('Location: '.FILE_KM_GRID_LISTING.$UParam);
}
if($_GET['Action']=='mtrash'){
	$km_grid_id= $_GET['m_trash_id'];
	$m_t_a=explode(",",$km_grid_id);
	
	foreach($m_t_a as $val)
	{
		$error = isNumeric(valid_input($val),ENTER_NUMERIC_VALUES_ONLY);
		if(!empty($error))
		{
			logOut();
		}else
		{
			$ObjKmGridMaster->deleteKmGrid($val);
		}
	}
	$UParam = "?pagenum=".$pagenum."&message=".MSG_DELETE_KM_GRID_SUCCESS;
	header('Location: '.FILE_KM_GRID_LISTING.$UParam);
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
			$message = SELECT_UPLOAD_CSV_FILE;
		} else {
			//  Read csv file and making array
			$SyncArray = array(
			'pickup_id' => 'pickup_id',
			'delivery_id' => 'delivery_id',
			'distance_in_km' => 'distance_in_km',

			);

			$Array_Data = readCSVFile($_FILES['csv_file']['tmp_name'], $SyncArray);
			$i = 0;
			$cnt = 0;
			if($Array_Data != '' && !empty($Array_Data)) {
				$cnt = count($Array_Data);
				foreach ($Array_Data as $key => $record) {
					if(isNumeric(valid_input($record['pickup_id']),ERROR_POSTCODE_REQUIRE_IN_NUMERIC))
					{
						$message = isNumeric(valid_input($record['pickup_id']),ERROR_POSTCODE_REQUIRE_IN_NUMERIC);
						$Svalidation = true;
					}elseif(isNumeric(valid_input($record['delivery_id']),ERROR_POSTCODE_REQUIRE_IN_NUMERIC))
					{
						$message = isNumeric(valid_input($record['delivery_id']),ERROR_POSTCODE_REQUIRE_IN_NUMERIC);
						$Svalidation = true;
					}elseif(isNumeric(valid_input($record['distance_in_km']),ERROR_POSTCODE_REQUIRE_IN_NUMERIC))
					{
						$message = isNumeric(valid_input($record['distance_in_km']),ERROR_POSTCODE_REQUIRE_IN_NUMERIC);
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

						$KmGridData->pickup_id = trim($record['pickup_id']);
						$KmGridData->delivery_id = trim($record['delivery_id']);
						$KmGridData->distance_in_km = trim($record['distance_in_km']);
						$fieldArr=array("*");
						$seaByArr = array() ;
						if($KmGridData->pickup_id!='' && $KmGridData->delivery_id!=''){
							$seaByArr[]=array('Search_On'=>'pickup_id', 'Search_Value'=>"$KmGridData->pickup_id", 'Type'=>'string', 'Equation'=>'=', 'CondType'=>'and', 'Prefix'=>'', 'Postfix'=>'');
							$seaByArr[]=array('Search_On'=>'delivery_id', 'Search_Value'=>"$KmGridData->delivery_id", 'Type'=>'string', 'Equation'=>'=', 'CondType'=>'and', 'Prefix'=>'', 'Postfix'=>'');
						}else{
							break;
						}
						$DataPostCode=$ObjKmGridMaster->getKmGrid($fieldArr, $seaByArr); // Fetch Data

						$totalRecords = $DataPostCode[0];

						if($totalRecords!='') {
							$alreadyaddedRecord++;
						}
						else{
							$ObjKmGridMaster->addKmGrid($KmGridData);
							$i = $i+1;
						}
					}
				}	
			}
			if(empty($message))
			{
				if($i > 0) {
					$message        = MSG_ADD_KMGRID_SUCCESS;
				} elseif($cnt == $alreadyaddedRecord  && $alreadyaddedRecord > 0) {
					$message = ERROR_ALREADY_INTERNATIONAL_AVAILABLE_CSV_FILE;
				}else{
					$message = ERROR_CSV_FILE_FORMAT;
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
$fieldArr=array("*");

if($km_grid_id!=''){
	$seaByArr[]=array('Search_On'=>'km_grid_id', 'Search_Value'=>"$km_grid_id", 'Type'=>'int', 'Equation'=>'=', 'CondType'=>'and', 'Prefix'=>'', 'Postfix'=>'');
	$btnSubmit = ADMIN_BUTTON_UPDATE_POSTCODE;
	$HeadingLabel = ADMIN_LINK_UPDATE_POSTCODE;
	$DataPostCode=$ObjKmGridMaster->getKmGrid($fieldArr, $seaByArr, $optArr=null, $start=null, $total=null, $ThrowError=true,$changeData = true,$counttotal=false);

	$DataPostCode = $DataPostCode[0];

	$fields = array("km.distance_in_km","pc.FullName","pc.Id","km.delivery_id","km.pickup_id");
	$searchByforPostcode[]=array('Search_On'=>'km.km_grid_id', 'Search_Value'=>"$km_grid_id", 'Type'=>'int', 'Equation'=>'=', 'CondType'=>'and', 'Prefix'=>'', 'Postfix'=>'');
	$find_post_code_value = $DataPostCode['pickup_id'].",".$DataPostCode['delivery_id'];
	$DataPostCode=$ObjKmGridMaster->getKmGrid($fields, $searchByforPostcode, $optArr=null, $start=null, $total=null, $ThrowError=true,$changeData = true,$counttotal=false,$find_post_code_value);
	$all_postcode_fullname = array();
	foreach ($DataPostCode as $postcode){
		$id = $postcode['Id'];
		$all_postcode_fullname[$id]=$postcode['FullName'];
	}
	$DataPostCode = $DataPostCode[0];
	
 }

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php if ($_GET['km_grid_id']=='') { echo ADMIN_ADD_USER; } else { echo ADMIN_EDIT_USER;}?></title>
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
					<table class="middle_right_content" align="center" border="0" cellpadding="0" cellspacing="0">
							<tr>
								<td align="left" class="breadcrumb">
										<span><a href="<?php echo FILE_WELCOME_ADMIN; ?>"><?php echo ADMIN_HEADER_HOME; ?></a> > <a href="<?php echo FILE_KM_GRID_LISTING; ?>"> <?php echo ADMIN_HEADER_KM_GRID; ?> </a> > <? echo $HeadingLabel; ?></span>
										<div><label class="top_navigation"><a href="<?php echo FILE_KM_GRID_LISTING; ?>"><?php echo ADMIN_COMMON_BACK; ?></a></label></div>
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
																<td><input type="hidden" id="ptoken" value="<?php echo $ptoken; ?>" name="ptoken"></td>
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
										<input type="hidden" name="km_grid_id" value="<?php echo $_GET['km_grid_id'];?>"  />
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
																	<td  align="left" valign="middle"><?php echo ADMIN_PICKUP_FROM;?></td>
																	
																		<td  align="left" valign="middle"  class="message_mendatory">
																			<input type="hidden" name="current_active_id" id="current_active_id" value=""/>
																			<input type="hidden" name="fetchpickupid" value="<?php echo ($_POST['fetchpickupid']!="")?($_GET['fetchpickupid']):($all_postcode_fullname[$DataPostCode['pickup_id']]);?>" id="fetchpickupid" />
																			<?php
																			$pickupid_cond=	($_POST['fetchpickupid']!="")?($_POST['fetchpickupid']):($all_postcode_fullname[$DataPostCode['pickup_id']]);
																			?>
																			<input type="text" class="change_all_data"  name="pickup" id="pickup"  autocomplete="off" onkeyup="ajax_showOptions(this,'admin_search',event,'<?php echo DIR_HTTP_RELATED."tms_index.php"; ?>','ajax_index_listOfOptions');" style="<?php echo $css;?>" value="<?php if($_POST['pickup']!=""){echo valid_output($_POST['pickup']);}else{if(isset($all_postcode_fullname[$DataPostCode['pickup_id']])){ echo valid_output($all_postcode_fullname[$DataPostCode['pickup_id']]); }}?>"/>
																			&nbsp;*<img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>internal/help_up.gif" class="help_btn" alt="<?php echo ADMIN_DELIVER_TO;?>"onmouseover="return overlib('<?php echo $Deliver_To;?>');" onmouseout="return nd();"  onfocus="if(this.value=='PICK UP SUBURB/POSTCODE'){this.value=''};" />
																			<span  id="deliverResult" name="deliverResult" class="autocomplete_index"></span></br>
																		</td>
																	<td  align="left" valign="middle"><?php echo ADMIN_DELIVER_TO;?></td>
																	<td  align="left" valign="top" class="message_mendatory">
																		<input type="hidden" name="fetchdeliveryid" value="<?php  echo ($_POST['fetchdeliveryid']!="")?($_POST['fetchdeliveryid']):($all_postcode_fullname[$DataPostCode['delivery_id']]);?>" id="fetchdeliveryid" />												
																		<?php
																		//for australia category
																		$deliveryidforaustralia_cond =	($_POST['fetchdeliveryid']!="")?($_POST['fetchdeliveryid']):($all_postcode_fullname[$DataPostCode['delivery_id']]);
																		?>
																		<input type="text" class="change_all_data" name="delivery" id="delivery"  autocomplete="off" onkeyup="ajax_showOptions(this,'admin_search',event,'<?php echo DIR_HTTP_RELATED."tms_index.php"; ?>','ajax_index_listOfOptions');" style="<?php echo $css;?>" value="<?php if($_POST['delivery']!=""){echo valid_output($_POST['delivery']);}else{if(isset($all_postcode_fullname[$DataPostCode['delivery_id']])) { echo valid_output($all_postcode_fullname[$DataPostCode['delivery_id']]); }}?>"/>
																		&nbsp;*<img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>internal/help_up.gif" class="help_btn" alt="<?php echo ADMIN_DELIVER_TO;?>" onmouseover="return overlib('<?php echo $Deliver_To;?>');" onmouseout="return nd();" />
																		<span  id="deliverResult" name="deliverResult" class="autocomplete_index"></span></br>
																	</td>
																</tr>
																<tr>
																	<td align="left" valign="middle">&nbsp;</td>
																	<td align="left" valign="top" class="message_mendatory" id="PickUpError"><?php echo $err['PickUpError'];  ?></td>
																	<td align="left" valign="middle">&nbsp;</td>
																	<td align="left" valign="top" class="message_mendatory" id="DeliverToError"><?php echo $err['DeliverToError'];  ?></td>
																</tr>								

																<tr>
																	<td  colspan="1" align="left" valign="middle"><?php echo ADMIN_DISTANCE;?></td>
																	<td  colspan="1" align="left" valign="middle"  class="message_mendatory"><input type="text" id="distance_in_km" name="distance_in_km" value="<?php  echo ($_POST['distance_in_km']!="")?($_POST['distance_in_km']):($DataPostCode['distance_in_km'])?>">&nbsp;*<img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>internal/help_up.gif" class="help_btn" alt="<?php echo ADMIN_DISTANCE;?>"onmouseover="return overlib('<?php echo $Distance_Km;?>');" onmouseout="return nd();" /></td>
																	
																</tr>
																<tr>
																	<td align="left" colspan="1" valign="middle">&nbsp;</td>
																	<td align="left" valign="top" colspan="1" class="message_mendatory" id="distance_in_kmError"><?php echo $err['distance_in_kmError'];  ?></td>
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
											<input type="submit" class="action_button" tabindex="36" name="submit" value="<?php echo $btnSubmit; ?>" >
											<input type="reset" tabindex="37" name="reset" class="action_button" value="<?php echo ADMIN_COMMON_BUTTON_RESET; ?>" >
											<input type="button"  class="action_button" name="cancel" tabindex="38" value="<?php echo ADMIN_COMMON_BUTTON_CANCEL;?>" onclick="javascript:document.location.href='<?php echo FILE_KM_GRID_LISTING; ?>';return true;"/>
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
<script language="Javascript">
$(document).ready(function(){

	$(".fetch_postcode").keyup(function(){
		var id= $(this).attr('id');
		var postcode_value = trim($(this).val());
		$("#"+id+"_id").val(postcode_value);
		var container_div = $(this).siblings("div:first");
		$.ajax({
			type : 'POST',
			url : '<?php echo DIR_HTTP_RELATED."tms_index.php"; ?>',

			data: {
				search_val : "1",
				letters : trim(postcode_value),
				selection_box:"1",
				id:id,

			},
			success : function(data){

				container_div.html(data);
				var  classname ="."+id;
				$(classname).show();
				$(classname).change(function()
				{
					var ot = "."+id+" option:selected";
					if($(this).attr('rel')=="delivery")
					{
						$("#delivery").val(trim($(ot).text()));
						$("#delivery_id").val($(this).val());
						
						
						
					}
					if($(this).attr('rel')=="pickup")
					{
						$("#pickup").val(trim($(ot).text()));
						$("#pickup_id").val($(this).val());
						console.log("pickup");
						
					}
					$(this).hide();
				});

			}
		});
	});

});


</script>
<?php require_once(DIR_WS_JSCRIPT."internal/jquery.php"); ?>
