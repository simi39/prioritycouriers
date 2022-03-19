<?php
require_once("../lib/common.php");
require_once('pagination_top.php');
require_once(DIR_WS_RELATED."system_mail.php");
require_once(DIR_WS_ADMIN_LANGUAGES . DIR_CURRENT_LANGUAGE. '/service.php');

require_once(DIR_WS_MODEL . "SupplierMaster.php");
require_once(DIR_WS_MODEL . "ServiceMaster.php");
require_once(DIR_WS_MODEL . "SteTableMaster.php");
require_once(DIR_WS_MODEL . "SteRatesFormateData.php");
require_once(DIR_WS_MODEL . "SteRatesFormateMaster.php");
require_once(DIR_WS_MODEL . "SteDetailsData.php");
require_once(DIR_WS_MODEL . "SteDetailsMaster.php");
require_once(DIR_WS_MODEL . "ProductLabelMaster.php");
/**
		    	 * Start :: Object declaration
		    	 */
$ObjSupplierMaster	= new SupplierMaster();
$ObjSupplierMaster	= $ObjSupplierMaster->Create();
$SupplierData		= new SupplierData();


$ObjServiceMaster	= new ServiceMaster();
$ObjServiceMaster	= $ObjServiceMaster->Create();
$ServiceData		= new ServiceData();

$ObjSteTableMaster	= new SteTableMaster();
$ObjSteTableMaster	= $ObjSteTableMaster->Create();
$SteTableData		= new SteTableData();

$ObjSteRatesFormateMaster	= new SteRatesFormateMaster();
$ObjSteRatesFormateMaster	= $ObjSteRatesFormateMaster->Create();
$SteRatesFormatesData		= new SteRatesFormateData();

$ObjSteDetailsMaster	= new SteDetailsMaster();
$ObjSteDetailsMaster	= $ObjSteDetailsMaster->Create();
$SteDetailsData		= new SteDetailsData();

$ObjProductLabelMaster	= new ProductLabelMaster();
$ObjProductLabelMaster	= $ObjProductLabelMaster->Create();
$ProductLabelData		= new ProductLabelData();
global $con;

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
		    	 * Inclusion and Exclusion Array of Javascript
		    	 */

$arr_javascript_plugin_include[] = 'jscolor/jscolor.js';

/*csrf validation*/
$csrf = new csrf();
$csrf->action = "service_action";
if(!isset($_POST['ptoken'])) {
	$ptoken = $csrf->csrfkey();
}


/*csrf validation*/

/**
		    	 * Variable Declaration
		    	 */

$auto_id = $_GET['auto_id'];
if(!empty($auto_id))
{
	$err['auto_id'] = isNumeric(valid_input($auto_id),ENTER_NUMERIC_VALUES_ONLY);
}
if(!empty($err['auto_id']))
{
	logOut();
}
if($auto_id!="")
{
	$btnSubmit = ADMIN_BUTTON_UPDATE_SERVICE;
	$HeadingLabel = ADMIN_LINK_UPDATE_SERVICE;
}
else
{
	$btnSubmit = ADMIN_BUTTON_SAVE_SERVICE;
	$HeadingLabel = ADMIN_LINK_SAVE_SERVICE;
}
if(!empty($_GET["supplier_id"]))
{
	$err['supplier_id'] = isNumeric(valid_input($_GET["supplier_id"]),ENTER_NUMERIC_VALUES_ONLY);
}
if(!empty($err['supplier_id']))
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
if($_GET['Action']=="findproductcode")
{
	$fieldArr=array("*");
	$seaByArr=array();
	$seaByArr[]=array('Search_On'=>'supplier_id', 'Search_Value'=>$_GET["supplier_id"], 'Type'=>'int', 'Equation'=>'=', 'CondType'=>'', 'Prefix'=>'and', 'Postfix'=>'');
	$DataProducts=$ObjProductLabelMaster->getProductLabel($fieldArr,$seaByArr);
	echo '<option selected="" value="">Select</option>';
	foreach($DataProducts as $DataProduct)
	{
	echo '<option value="'.$DataProduct["auto_id"].'">'.valid_output($DataProduct["product_code"]).'</option>';
	}
	exit;
}


if($_GET['Action']=='readd')
{
	$ServiceData->auto_id = $auto_id;
	$ServiceData->deleted = 1;
	$ObjServiceMaster->editService($ServiceData,"deleted");
	$UParam = "?pagenum=".$pagenum."&message=".MSG_READD_SERVICE_SUCCESS;
	header('Location: '.FILE_STE_SERVICE.$UParam);
}
if($_GET['Action']=='pdelete')
{
	$fieldArr=array("service_code");
	$seaByArr=array();
	$seaByArr[]=array('Search_On'=>'auto_id', 'Search_Value'=>$auto_id, 'Type'=>'int', 'Equation'=>'=', 'CondType'=>'', 'Prefix'=>'and', 'Postfix'=>'');
	$data = $ObjServiceMaster->getService($fieldArr,$seaByArr);
	$data =$data[0];

	$fieldArr=array("*");
	$seaByArr=array();
	$seaByArr[]=array('Search_On'=>'service_type', 'Search_Value'=>$data->service_code, 'Type'=>'string', 'Equation'=>'=', 'CondType'=>'', 'Prefix'=>'and', 'Postfix'=>'');
	$DataSteTable=$ObjSteTableMaster->getSteTable($fieldArr,$seaByArr);
	if($DataSteTable!="")
	{
		foreach($DataSteTable as $table)
		{
			mysqli_query($con,"DROP TABLE ".$table->table_name);

			$seaByArr=array();
			$seaByArr[]=array('Search_On'=>'ste_table_name', 'Search_Value'=>$table->table_name, 'Type'=>'string', 'Equation'=>'=', 'CondType'=>'', 'Prefix'=>'and', 'Postfix'=>'');
			$ObjSteRatesFormateMaster->deleteSteRatesFormateMultiple($seaByArr);

			$seaByArr=array();
			$seaByArr[]=array('Search_On'=>'table_name', 'Search_Value'=>"in".$table->table_name, 'Type'=>'string', 'Equation'=>'=', 'CondType'=>'and', 'Prefix'=>'(', 'Postfix'=>'');
			$seaByArr[]=array('Search_On'=>'table_name', 'Search_Value'=>"out".$table->table_name, 'Type'=>'string', 'Equation'=>'=', 'CondType'=>'or', 'Prefix'=>'', 'Postfix'=>'');
			$seaByArr[]=array('Search_On'=>'table_name', 'Search_Value'=>"bo".$table->table_name, 'Type'=>'string', 'Equation'=>'=', 'CondType'=>'or', 'Prefix'=>'', 'Postfix'=>')');
			$ObjSteDetailsMaster->deleteSteDetailsMultiple($seaByArr);

			$ObjSteTableMaster->deleteSteTable($table->auto_id);
		}
	}

	$ObjServiceMaster->deleteService($auto_id);
	$UParam = "?pagenum=".$pagenum."&message=".MSG_DELETE_SERVICE_SUCCESS;
	header('Location: '.FILE_STE_SERVICE.$UParam);



}

if($_GET['Action']=='trash')
{
	$ServiceData->auto_id = $auto_id;
	$ServiceData->deleted = 0;
	$ObjServiceMaster->editService($ServiceData,"deleted");
	$UParam = "?pagenum=".$pagenum."&message=".MSG_DELETE_SERVICE_SUCCESS;
	header('Location: '.FILE_STE_SERVICE.$UParam);
}


if($_GET['Action']=='mtrash'){
	$auto_id = $_GET['m_trash_id'];
	$m_t_a=explode(",",$auto_id);
	foreach($m_t_a as $val)
	{
		$error = isNumeric(valid_input($val),ENTER_NUMERIC_VALUES_ONLY);
		if(!empty($error))
		{
			logOut();
		}else
		{
			$ServiceData->auto_id = $val;
			$ServiceData->deleted = 0;
			$ObjServiceMaster->editService($ServiceData,"deleted");
		}
	}
	$UParam = "?pagenum=".$pagenum."&message=".MSG_DELETE_SERVICE_SUCCESS;
	header('Location: '.FILE_STE_SERVICE.$UParam);


}

if((isset($_POST['submit']) && $_POST['submit'] != "")){
	
	if(isEmpty(valid_input($_POST['ptoken']), true)){
		logOut();
	}else{
		//$csrf->checkcsrf($_POST['ptoken']);
	}

	$err['ServiceNameError'] = isEmpty(strtoupper($_POST['service_name']), ADMIN_SERVICE_IS_REQUIRED)?isEmpty(strtoupper($_POST['service_name']), ADMIN_SERVICE_IS_REQUIRED):checkStr($_POST['service_name']);
	$err['SortingError'] = isEmpty(($_POST['sorting']), ADMIN_SORTING_IS_REQUIRED)?isEmpty(($_POST['sorting']), ADMIN_SORTING_IS_REQUIRED):checkEmpty($_POST['sorting']);
	$err['ServiceCodeError'] = isEmpty(strtoupper($_POST['service_code']), ADMIN_SERVICE_CODE_IS_REQUIRED)?isEmpty(strtoupper($_POST['service_code']), ADMIN_SERVICE_CODE_IS_REQUIRED):chkCapital($_POST['service_code']);
	if($_POST['surcharge'])
	{
		$err['surchargeError'] = isFloat($_POST['surcharge'],ADMIN_ENTER_ONLY_FLOATING_VALUE);
	}

	if($_POST['security_surcharge'])
	{
		$err['securitySurchargeError'] = isFloat($_POST['security_surcharge'],ADMIN_ENTER_ONLY_FLOATING_VALUE);
	}

	$err['TimeError'] = isEmpty($_POST['time_hr'], ADMIN_SERVICE_TIME_IS_REQUIRED)?isEmpty($_POST['time_hr'], ADMIN_SERVICE_TIME_IS_REQUIRED):isNumeric($_POST['time_hr'],COMMON_NUMERIC_VAL);
	$err['TimeError']  = isEmpty($_POST['time_sec'], ADMIN_SERVICE_TIME_IS_REQUIRED)?isEmpty($_POST['time_sec'], ADMIN_SERVICE_TIME_IS_REQUIRED):isNumeric($_POST['time_sec'],COMMON_NUMERIC_VAL);
	$err['ProductError'] = isEmpty($_POST['product_code_id'], ADMIN_PRODUCT_CODE_IS_REQUIRED)?isEmpty($_POST['product_code_id'], ADMIN_PRODUCT_CODE_IS_REQUIRED):isNumeric($_POST['time_sec'],COMMON_NUMERIC_VAL);;
	if(isset($_POST['qty_status']) && $_POST['qty_status'] == 1)
	{
		$err['QtyMinError'] = isEmpty($_POST['qty_min'], ADMIN_SERVICE_MIN_QTY_IS_REQUIRED)?isEmpty($_POST['qty_min'], ADMIN_SERVICE_MIN_QTY_IS_REQUIRED):isNumeric($_POST['qty_min'],COMMON_NUMERIC_VAL);
		$err['QtyMaxError'] = isEmpty($_POST['qty_max'], ADMIN_SERVICE_MAX_QTY_IS_REQUIRED)?isEmpty($_POST['qty_max'], ADMIN_SERVICE_MAX_QTY_IS_REQUIRED):isNumeric($_POST['qty_max'],COMMON_NUMERIC_VAL);
	}
	if(isset($_POST['weight_status']) && $_POST['weight_status'] == 1)
	{
		$err['WeightMinError'] = isEmpty($_POST['weight_max'], ADMIN_SERVICE_MAX_WEIGHT_IS_REQUIRED)?isEmpty($_POST['weight_max'], ADMIN_SERVICE_MAX_WEIGHT_IS_REQUIRED):isFloat($_POST['weight_max'],ENTER_FLOAT_VALUES_ONLY);
		$err['WeightMaxError'] = isEmpty($_POST['weight_min'], ADMIN_SERVICE_MIN_WEIGHT_IS_REQUIRED)?isEmpty($_POST['weight_min'], ADMIN_SERVICE_MIN_WEIGHT_IS_REQUIRED):isFloat($_POST['weight_min'],ENTER_FLOAT_VALUES_ONLY);
	}
	if(isset($_POST['dim_status']) && $_POST['dim_status'] == 1)
	{
		$err['LengthMinError'] = isEmpty($_POST['len_min'], ADMIN_SERVICE_MAX_LENGTH_IS_REQUIRED)?isEmpty($_POST['len_min'], ADMIN_SERVICE_MIN_LENGTH_IS_REQUIRED):isNumeric($_POST['len_min'],COMMON_NUMERIC_VAL);
		$err['LengthMaxError'] = isEmpty($_POST['len_max'], ADMIN_SERVICE_MIN_LENGTH_IS_REQUIRED)?isEmpty($_POST['len_max'], ADMIN_SERVICE_MAX_LENGTH_IS_REQUIRED):isNumeric($_POST['len_max'],COMMON_NUMERIC_VAL);
		$err['WidthMinError'] = isEmpty($_POST['width_min'], ADMIN_SERVICE_MAX_WIDTH_IS_REQUIRED)?isEmpty($_POST['width_min'], ADMIN_SERVICE_MIN_WIDTH_IS_REQUIRED):isNumeric($_POST['width_min'],COMMON_NUMERIC_VAL);
		$err['WidthMaxError'] = isEmpty($_POST['width_max'], ADMIN_SERVICE_MIN_WIDTH_IS_REQUIRED)?isEmpty($_POST['width_max'], ADMIN_SERVICE_MAX_WIDTH_IS_REQUIRED):isNumeric($_POST['width_max'],COMMON_NUMERIC_VAL);
		$err['HeightMinError'] = isEmpty($_POST['height_min'], ADMIN_SERVICE_MAX_HEIGHT_IS_REQUIRED)?isEmpty($_POST['height_min'], ADMIN_SERVICE_MIN_HEIGHT_IS_REQUIRED):isNumeric($_POST['height_min'],COMMON_NUMERIC_VAL);
		$err['HeightMaxError'] = isEmpty($_POST['height_max'], ADMIN_SERVICE_MIN_HEIGHT_IS_REQUIRED)?isEmpty($_POST['height_max'], ADMIN_SERVICE_MAX_HEIGHT_IS_REQUIRED):isNumeric($_POST['height_max'],COMMON_NUMERIC_VAL);
	}
	if(isset($_POST['qty_status']) && $_POST['qty_status'] == 1 && empty($err['QtyMinError']) && empty($err['QtyMaxError']))
	{
		if($_POST['qty_max']<=$_POST['qty_min'])
		{
			$err['QtyMaxError'] = ADMIN_SERVICE_MAX_QTY_GREATER;
		}
	}
	if(isset($_POST['weight_status']) && $_POST['weight_status'] == 1 && empty($err['WeightMinError']) && empty($err['WeightMaxError']))
	{
		if($_POST['weight_max']<=$_POST['weight_min'])
		{
			$err['WeightMaxError'] = ADMIN_SERVICE_MAX_WEIGHT_GREATER;
		}
	}
	if(isset($_POST['dim_status']) && $_POST['dim_status'] == 1)
	{
		if(empty($err['LengthMinError']) && empty($err['LengthMaxError']))
		{
			if($_POST['len_max']<=$_POST['len_min'])
			{
				$err['LengthMaxError'] = ADMIN_SERVICE_MAX_LENGTH_GREATER;
			}
		}
		if(empty($err['WidthMinError']) && empty($err['WidthMaxError']))
		{
			if($_POST['width_max']<=$_POST['width_min'])
			{
				$err['WidthMaxError'] = ADMIN_SERVICE_MAX_WIDTH_GREATER;
			}
		}
		if(empty($err['HeightMinError']) && empty($err['HeightMaxError']))
		{
			if($_POST['height_max']<=$_POST['height_min'])
			{
				$err['HeightMaxError'] = ADMIN_SERVICE_MAX_HEIGHT_GREATER;
			}
		}
	}
	if($auto_id!="")
	{
		$servicename=trim(($_POST['service_name']));
		$servicecode=trim(strtoupper($_POST['service_code']));
		$fieldArr=array("service_name,service_code");
		$seaByArr=array();
		$seaByArr[]=array('Search_On'=>'auto_id', 'Search_Value'=>$auto_id, 'Type'=>'int', 'Equation'=>'!=', 'CondType'=>'and', 'Prefix'=>'', 'Postfix'=>'');
		$seaByArr[]=array('Search_On'=>'service_name', 'Search_Value'=>$servicename, 'Type'=>'string', 'Equation'=>'=', 'CondType'=>'and', 'Prefix'=>'(', 'Postfix'=>'');
		$seaByArr[]=array('Search_On'=>'service_code', 'Search_Value'=>$servicecode, 'Type'=>'string', 'Equation'=>'=', 'CondType'=>'', 'Prefix'=>'or', 'Postfix'=>')');
		$DataService=$ObjServiceMaster->getService($fieldArr,$seaByArr);
		$DataService = $DataService[0];
		//echo count($DataService);exit;
		if (is_array($DataService) && count($DataService) > 0)
		{
			/*
			if($DataService["service_name"]==$servicename)
			{
				$err['ServiceNameError'] = ADMIN_SERVICE_IS_EXIST;
			}*/
			if($DataService["service_code"]==$servicecode)
			{
				$err['ServiceCodeError'] = ADMIN_SERVICE_CODE_IS_EXIST;
			}
		}
	}
	else
	{
		$err['SupplierNameError'] 		 = isEmpty($_POST['supplier'], ADMIN_SERVICE_SUPPLIER_NAME_IS_REQUIRED);
		$err['ServiceTypeError'] 		 = isEmpty($_POST['type'], ADMIN_SERVICE_TYPE_IS_REQUIRED);

		$servicename=trim(strtoupper($_POST['service_name']));
		$servicecode=trim(strtoupper($_POST['service_code']));
		$fieldArr=array("auto_id,service_name,service_code,deleted");
		$seaByArr=array();
		$seaByArr[]=array('Search_On'=>'service_name', 'Search_Value'=>$servicename, 'Type'=>'string', 'Equation'=>'=', 'CondType'=>'and', 'Prefix'=>'(', 'Postfix'=>'');
		$seaByArr[]=array('Search_On'=>'service_code', 'Search_Value'=>$servicecode, 'Type'=>'string', 'Equation'=>'=', 'CondType'=>'', 'Prefix'=>'or', 'Postfix'=>')');
		$DataService=$ObjServiceMaster->getService($fieldArr,$seaByArr);
		$DataService = $DataService[0];
		/*echo "total count:".count($DataService)."</br>";
		exit();*/
		//if(count($DataService)!=0)
		if (is_array($DataService) && count($DataService) > 0)
		{
			/*
			if($DataService["service_name"]==$servicename)
			{
				$err['ServiceNameError'] = ADMIN_SERVICE_IS_EXIST;
			}*/
			if($DataService["service_code"]==$servicecode)
			{
				$err['ServiceCodeError'] = ADMIN_SERVICE_CODE_IS_EXIST;
			}
			if(($DataService["deleted"]==0) && ($DataService["service_name"]==$servicename) && ($DataService["service_code"]==$servicecode))
			{
				unset($err['ServiceNameError']);
				unset($err['ServiceCodeError']);

				$ServiceData->auto_id = $DataService["auto_id"];
				$ServiceData->deleted = 1;
				$ObjServiceMaster->editService($ServiceData,"deleted");
				$auto_id=$DataService["auto_id"];
			}

		}
	}

	/**
	 * Checking Error Exists
	*/
	/*
	echo "<pre>";
	print_R($err);
	echo "</pre>";
	exit();*/
	foreach($err as $key => $Value) {
		if($Value != '') {
			$Svalidation=true;
			$ptoken = $csrf->csrfkey();
		}
	}

	if($Svalidation==false){

		$ServiceData->service_name = strtoupper(trim($_POST['service_name']));
		$ServiceData->sorting = $_POST['sorting'];
		$ServiceData->service_code = trim(strtoupper($_POST['service_code']));
		$ServiceData->service_description = trim($_POST['service_description']);


		$ServiceData->hours = trim($_POST['time_hr']);
		$ServiceData->minites = trim($_POST['time_sec']);
		$ServiceData->hr_formate = trim($_POST['hr_formate']);
		$ServiceData->box_color ="#".trim($_POST['box_color']);
		$ServiceData->shadow_color ="";//trim($_POST['shadow_color']);
		$ServiceData->surcharge =$_POST['surcharge'];
		$ServiceData->security_surcharge =$_POST['security_surcharge'];
		$ServiceData->status =$_POST['status'];
		$ServiceData->product_code_id=$_POST['product_code_id'];
		$ServiceData->service_info=$_POST['service_info'];
		$ServiceData->service_status_info=$_POST['service_status_info'];
		$ServiceData->qty_min = $_POST['qty_min'];
		$ServiceData->qty_max = $_POST['qty_max'];
		$ServiceData->qty_status = $_POST['qty_status'];
		$ServiceData->weight_min = $_POST['weight_min'];
		$ServiceData->weight_max = $_POST['weight_max'];
		$ServiceData->weight_status = $_POST['weight_status'];
		$ServiceData->len_min = $_POST['len_min'];
		$ServiceData->len_max = $_POST['len_max'];
		$ServiceData->width_min = $_POST['width_min'];
		$ServiceData->width_max = $_POST['width_max'];
		$ServiceData->height_min = $_POST['height_min'];
		$ServiceData->height_max = $_POST['height_max'];
		$ServiceData->dim_status = $_POST['dim_status'];
		if($auto_id!=''){

			//Edit Users

			$ServiceData->auto_id = $auto_id;
			$ObjServiceMaster->editService($ServiceData);
			$UParam = "?pagenum=".$pagenum."&message=".MSG_EDIT_SERVICE_SUCCESS;
		}else{

			$ServiceData->supplier_id =trim($_POST['supplier']);
			$ServiceData->type = $_POST['type'];

			$insertedauto_id = $ObjServiceMaster->addService($ServiceData);
			$UParam = "?pagenum=".$pagenum."&message=".MSG_ADD_SERVICE_SUCCESS;
		}
		header('Location: '.FILE_STE_SERVICE.$UParam);

	}

}

$fieldArr = array("*");
$DataSupplier=$ObjSupplierMaster->getSupplier($fieldArr);


/**
		    	 * Gets details for the user
		    	 */

if($auto_id!=''){

	$fieldArr=array("*");
	$seaByArr=array();
	$seaByArr[]=array('Search_On'=>'auto_id', 'Search_Value'=>$auto_id, 'Type'=>'int', 'Equation'=>'=', 'CondType'=>'', 'Prefix'=>'and', 'Postfix'=>'');

	$DataService=$ObjServiceMaster->getService($fieldArr,$seaByArr); // Fetch Data

	$DataService = $DataService[0];

	//Get sign up Address

	//Variable declaration

	$btnSubmit = ADMIN_BUTTON_UPDATE_SERVICE;
	$HeadingLabel = ADMIN_LINK_UPDATE_SERVICE;
}
else {
	unset($DataService);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php if ($_GET['auto_id']=='') { echo ADMIN_ADD_USER; } else { echo ADMIN_EDIT_USER;}?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<?php
addPluginCSSFile($arr_css_plugin_include,$arr_css_plugin_exclude);
addCSSFileAdmin($arr_css_admin_include, $arr_css_admin_exclude);
addJavaScriptFile($arr_javascript_include, $arr_javascript_exclude);
addPluginJavaScriptFile($arr_javascript_plugin_include,$arr_javascript_plugin_exclude);
?>
<script language="javascript" type="text/javascript">
function validate_service(arg)
{
	var service_info = CKEDITOR.instances['service_info'].getData();

	if(service_info.length > 12000){

		alert('Character length exceeds limit \n You can enter only 12000 characters');
		return false;
	}else
	{
		return true;
	}

}
function hideQty(arg)
{
	if(arg==1)
	{
		$("#qty_min").attr('readonly', false);
		$("#qty_max").attr('readonly', false);
	}else{
		$("#qty_min").val(0);
		$("#qty_max").val(0);
		$("#qty_min").attr('readonly', true);
		$("#qty_max").attr('readonly', true);
	}
}
function hideWeight(arg)
{
	if(arg==1)
	{
		$("#weight_min").attr('readonly', false);
		$("#weight_max").attr('readonly', false);
	}else{
		$("#weight_min").val(0);
		$("#weight_max").val(0);
		$("#weight_min").attr('readonly', true);
		$("#weight_max").attr('readonly', true);
	}
}
function hideDim(arg)
{
	if(arg==1)
	{
		$("#len_min").attr('readonly', false);
		$("#len_max").attr('readonly', false);
		$("#width_min").attr('readonly', false);
		$("#width_max").attr('readonly', false);
		$("#height_min").attr('readonly', false);
		$("#height_max").attr('readonly', false);

	}else{
		$("#len_min").val(0);
		$("#len_max").val(0);
		$("#width_min").val(0);
		$("#width_max").val(0);
		$("#height_min").val(0);
		$("#height_max").val(0);
		$("#len_min").attr('readonly', true);
		$("#len_max").attr('readonly', true);
		$("#width_min").attr('readonly', true);
		$("#width_max").attr('readonly', true);
		$("#height_min").attr('readonly', true);
		$("#height_max").attr('readonly', true);
	}
}

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
											<span><a href="<?php echo FILE_WELCOME_ADMIN; ?>"><?php echo ADMIN_HEADER_HOME; ?></a> > <a href="<?php echo FILE_STE_SERVICE.'?pagenum='.$pagenum; ?>"> <?php echo ADMIN_HEADER_SERVICE_MANAGEMENT; ?> </a> > <? echo $HeadingLabel; ?></span>
											<div><label class="top_navigation"><a href="<?php echo FILE_STE_SERVICE.'?pagenum='.$pagenum; ?>"><?php echo ADMIN_COMMON_BACK; ?></a></label></div>
										</td>
									</tr>
									<tr>
										<td align="center">
											<?php  /*** Start :: Listing Table ***/ ?>
											<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
												<form name="frmuser" method="POST" action="">
													<input type="hidden" name="Id1" value="<?php //echo $maximum_id[0] || $_GET['Id'];?>" />
													<tr>
														<td>
															<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td>
																		<table width="98%" cellpadding="0" border="0" cellspacing="0">
																			<tr>
																				<td class="message_mendatory" align="right" colspan="4">
																					<?echo ADMIN_COMMAN_REQUIRED_INFO;?>
																				</td>
																			</tr>
																			<tr>
																				<td colspan="4">&nbsp;</td>
																			</tr>
																			<tr>
																				<td align="left" valign="middle"><?php echo ADMIN_SERVICE_NAME;?><span class="message_mendatory">*</span></td>
																				<td align="left" valign="middle">
																					<input type="text" id="service_name" name="service_name" value="<?php if(strtoupper($_POST['service_name']) != ''){ echo strtoupper(valid_output($_POST['service_name']));}else{ echo valid_output($DataService["service_name"]); }?>" />
																					&nbsp;<img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>internal/help_up.gif" class="help_btn" alt="<?php echo ADMIN_SERVICE_HELP_SERVICE_NAME; ?>" onmouseover="return overlib('<?php echo ADMIN_SERVICE_HELP_SERVICE_NAME;?>');" onmouseout="return nd();" /> &nbsp; <span class="message_mendatory"><?php if($err['ServiceNameError']!=""){ echo $err['ServiceNameError']; } ?></span>
																				</td>
																				<td align="left" valign="top" class="message_mendatory"></td>
																				<td align="left" valign="top" class="message_mendatory"></td>
																			</tr>
																			<tr>
																				<td align="left" valign="middle" colspan="4"><br /></td>
																			</tr>
																			<tr>
																				<td colspan="4">&nbsp;</td>
																			</tr>
																			<tr>
																				<td align="left" valign="middle"><?php echo ADMIN_SERVICE_SORTING;?><span class="message_mendatory">*</span></td>
																				<td align="left" valign="middle">
																					<input type="text" id="sorting" name="sorting" value="<?php if($_POST['sorting'] != ''){ echo valid_output($_POST['sorting']);}else{ echo valid_output($DataService["sorting"]); }?>" />
																					&nbsp;<img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>internal/help_up.gif" class="help_btn" alt="<?php echo ADMIN_SERVICE_HELP_SORTING; ?>" onmouseover="return overlib('<?php echo ADMIN_SERVICE_HELP_SORTING;?>');" onmouseout="return nd();" /> &nbsp; <span class="message_mendatory"><?php if($err['SortingError']!=""){ echo $err['SortingError']; } ?></span>
																				</td>
																				<td align="left" valign="top" class="message_mendatory"></td>
																				<td align="left" valign="top" class="message_mendatory"></td>
																			</tr>
																			<tr>
																				<td align="left" valign="middle" colspan="4"><br /></td>
																			</tr>
																			<tr>
																				<td align="left" valign="middle"><?php echo ADMIN_SERVICE_CODE; ?><span class="message_mendatory">*</span></td>
																				<td align="left" valign="middle" class="message_mendatory">
																					<input type="text" id="service_code" name="service_code" value="<?php if(strtoupper($_POST['service_code']) != ''){ echo strtoupper(valid_output($_POST['service_code']));}else{ echo valid_output($DataService["service_code"]); }?>" />
																					&nbsp;<img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>internal/help_up.gif" class="help_btn" alt="<?php echo ADMIN_SERVICE_HELP_SERVICE_CODE;?>" onmouseover="return overlib('<?php echo ADMIN_SERVICE_HELP_SERVICE_CODE;?>');" onmouseout="return nd();" />
																					&nbsp; <span class="message_mendatory"><?php if($err['ServiceCodeError']!=""){ echo $err['ServiceCodeError']; } ?></span>
																				</td>
																				<td align="left" valign="top" class="message_mendatory"></td>
																				<td align="left" valign="top" class="message_mendatory">
																				</td>
																			</tr>
																			<tr>
																				<td align="left" valign="middle" colspan="4"><br /></td>
																			</tr>
																			<tr>
																				<td align="left" valign="middle"><?php echo ADMIN_SUPPLIER_NAME; ?><span class="message_mendatory">*</span></td>
																				<td align="left" valign="middle">
																					<select name="supplier" id="supplier">
																						<option value="">Select</option>
																						<?php
																						foreach($DataSupplier as $supplier)
																						{
																								?>
																						<option value="<?php echo $supplier["auto_id"]; ?>" <?php if($DataService['supplier_id']==$supplier["auto_id"]){ echo "selected"; }elseif($_POST['supplier']==$supplier["auto_id"]){ echo "selected"; } ?>><?php echo valid_output($supplier["supplier_name"]); ?></option>
																						<?php
																						}
																								 ?>
																					</select>
																					&nbsp; <span class="message_mendatory"><?php if($err['SupplierNameError']!=""){ echo $err['SupplierNameError']; } ?></span>
																				</td>
																				<td align="left" valign="top" class="message_mendatory"></td>
																				<td align="left" valign="top" class="message_mendatory">
																				</td>
																			</tr>
																				<tr>
																				<td align="left" valign="middle" colspan="4"><br /></td>
																			</tr>
																			<tr>
																				<td align="left" valign="middle"><?php echo ADMIN_PRODUCT_CODE; ?><span class="message_mendatory">*</span></td>
																				<td align="left" valign="middle">
																				<?php
																				if($DataService['supplier_id']!="")
																				{
																					$supplier_id=$DataService['supplier_id'];
																				}
																				if($_POST['supplier']!="")
																				{
																					$supplier_id=$_POST['supplier'];
																				}
																				$fieldArr=array("*");
																				$seaByArr=array();
																				//$seaByArr[]=array('Search_On'=>'supplier_id', 'Search_Value'=>$supplier_id, 'Type'=>'int', 'Equation'=>'=', 'CondType'=>'', 'Prefix'=>'and', 'Postfix'=>'');

																				$DataProducts=$ObjProductLabelMaster->getProductLabel($fieldArr,$seaByArr); // Fetch Data
/*
			echo "<pre>";
					print_R($DataProducts);
					echo "</pre>";
					exit();		*/															?>
																					<select name="product_code_id" id="product_code_id">
																						<option value="" selected >Select</option>
																						<?php
					if(!empty($DataProducts)){
					foreach($DataProducts as $DataProduct)
																						{
																								?>
																						<option value="<?php echo $DataProduct["auto_id"]; ?>" <?php if($_POST['product_code_id']==$DataProduct["auto_id"]){ echo "selected"; }elseif($DataService['product_code_id']==$DataProduct["auto_id"]){ echo "selected"; } ?>><?php echo valid_output($DataProduct["product_code"]); ?></option>
																						<?php
																						}
					}																			 ?>
																					</select>
																					&nbsp; <span class="message_mendatory"><?php if($err['ProductError']!=""){ echo $err['ProductError']; } ?></span>
																				</td>
																				<td align="left" valign="top" class="message_mendatory"></td>
																				<td align="left" valign="top" class="message_mendatory">
																				</td>
																			</tr>
																			<tr>
																				<td align="left" valign="middle" colspan="4"><br /></td>
																			</tr>
																			<tr>
																				<td align="left" valign="middle"><?php echo ADMIN_SERVICE_TYPE; ?><span class="message_mendatory">*</span></td>
																				<td align="left" valign="middle" class="message_mendatory">
																					<select name="type" id="type">
																						<option value="" selected>Select</option>
																						<option value="0" <?php if($DataService['type']=="0"){ echo "selected"; }elseif($_POST['type']=="0"){ echo "selected"; } ?>>Road</option>
																						<option value="1" <?php if($DataService['type']=="1"){ echo "selected"; }elseif($_POST['type']=="1"){ echo "selected"; } ?>>Air</option>
																					</select>
																					&nbsp; <span class="message_mendatory"><?php if($err['ServiceTypeError']!=""){ echo $err['ServiceTypeError']; } ?></span>
																				</td>
																				<td align="left" valign="top" class="message_mendatory"></td>
																				<td align="left" valign="top" class="message_mendatory">
																				</td>
																			</tr>
																			<tr>
																				<td align="left" valign="middle" colspan="4"><br /></td>
																			</tr>
																			<tr>
																				<td align="left" valign="middle"><?php echo ADMIN_SERVICE_SURCHARGE; ?></td>
																				<td align="left" valign="middle" class="message_mendatory" colspan="3">
																					<input id="surcharge" name="surcharge" type="text" value="<?php if($DataService["surcharge"] == ''){ echo "0.00";}else{ echo valid_output($DataService["surcharge"]); }?>" />
																				</td>
																			</tr>
																			<tr>
																				<td align="left" valign="middle" ><br /></td>
																				<td align="left" valign="middle" colspan="3" class="message_mendatory"><?php if(isset($err['surchargeError']) && $err['surchargeError']!= ''){ echo $err['surchargeError'];} ?><br /></td>
																			</tr>
																			<tr>
																				<td align="left" valign="middle"><?php echo ADMIN_SECURITY_SURCHARGE; ?></td>
																				<td align="left" valign="middle" class="message_mendatory" colspan="3">
																					<input id="security_surcharge" name="security_surcharge" type="text" value="<?php if($DataService["security_surcharge"] == ''){ echo "0.00";}else{ echo valid_output($DataService["security_surcharge"]); }?>" />
																				</td>
																			</tr>
																			<tr>
																				<td align="left" valign="middle" ><br /></td>
																				<td align="left" valign="middle" colspan="3" class="message_mendatory"><?php if(isset($err['securitySurchargeError']) && $err['securitySurchargeError']!= ''){ echo $err['securitySurchargeError'];} ?><br /></td>
																			</tr>
																			<tr>
																				<td align="left" valign="middle"><?php echo ADMIN_SERVICE_CUTOFF; ?><span class="message_mendatory">*</span></td>
																				<td align="left" valign="middle">
																					<select class="pick_form_textbox_big" name="time_hr" id="time_hr">
																						<option value="" <?php if($time_hr=="") {?>selected<?php }?>>hh</option>
																						<?php
																						$time_hr=$DataService["hours"];
																						$time_sec=$DataService["minites"];
																						$hr_formate=$DataService["hr_formate"];

																						for($i=1; $i<13; $i++)
																								    {?>
																						<option value="<?php echo $i;?>" <?php if ( $time_hr == $i ){ echo "selected"; }elseif($i==$_POST["time_hr"]){echo "selected";}  ?>><?php echo $i; ?></option>
																						<?php
																								    }
																							?>
																					</select>
																					<select class="pick_form_textbox_big" style="width:60px" name="time_sec" id="time_sec">
																						<option value="" <?php if ( $time_sec=="mm" )echo "selected";  ?>>mm</option>
																						<option value="00" <?php if ( $time_sec=="00" ) { echo "selected"; }elseif($_POST['time_sec']=="00"){ echo "selected"; }  ?>>00</option>
				<option value="05" <?php if ( $time_sec=="05" ){ echo "selected"; }elseif($_POST['time_sec']=="05"){ echo "selected"; }  ?>>05</option>
				<option value="10" <?php if ( $time_sec=="10" ){ echo "selected"; }elseif($_POST['time_sec']=="10"){ echo "selected"; }  ?>>10</option>																	<option value="15" <?php if ( $time_sec=="15" ){ echo "selected"; }elseif($_POST['time_sec']=="15"){ echo "selected"; }  ?>>15</option>
				<option value="20" <?php if ( $time_sec=="20" ){ echo "selected"; }elseif($_POST['time_sec']=="20"){ echo "selected"; }  ?>>20</option>
					<option value="25" <?php if ( $time_sec=="25" ){ echo "selected"; }elseif($_POST['time_sec']=="25"){ echo "selected"; }  ?>>25</option>																	<option value="30" <?php if ( $time_sec=="30" ){ echo "selected"; }elseif($_POST['time_sec']=="30"){ echo "selected"; }  ?>>30</option>
					<option value="35" <?php if ( $time_sec=="35" ){ echo "selected"; }elseif($_POST['time_sec']=="35"){ echo "selected"; }  ?>>35</option>
					<option value="40" <?php if ( $time_sec=="40" ){ echo "selected"; }elseif($_POST['time_sec']=="40"){ echo "selected"; }  ?>>40</option>															<option value="45" <?php if ( $time_sec=="45" ){ echo "selected"; }elseif($_POST['time_sec']=="45"){ echo "selected"; }  ?>>45</option>
					<option value="50" <?php if ( $time_sec=="50" ){ echo "selected"; }elseif($_POST['time_sec']=="50"){ echo "selected"; }  ?>>50</option>
					<option value="55" <?php if ( $time_sec=="55" ){ echo "selected"; }elseif($_POST['time_sec']=="55"){ echo "selected"; }  ?>>55</option>
																					</select>
																					<select class="pick_form_textbox_big" style="width:60px" name="hr_formate" id="hr_formate">
																						<option value="am" <?php  if ($hr_formate=="am"){echo "selected";}elseif($_POST['hr_formate']=="am"){echo "selected";}?>>am</option>
																						<option value="pm" <?php  if ($hr_formate=="pm"){echo "selected";}elseif($_POST['hr_formate']=="pm"){echo "selected";}?>>pm</option>
																					</select>
																					&nbsp; <span class="message_mendatory"><?php if($err['TimeError']!=""){ echo $err['TimeError']; } ?></span>
																				</td>
																				<td align="left" valign="top" class="message_mendatory"></td>
																				<td align="left" valign="top" class="message_mendatory">
																				</td>
																			</tr>
																			<tr>
																				<td align="left" valign="middle" colspan="4"><br /></td>
																			</tr>
																			<tr>
																				<td align="left" valign="middle"><?php echo ADMIN_SERVICE_BOX_COLOR; ?></td>
																				<td align="left" valign="middle" class="message_mendatory" colspan="3">
																					<input id="box_color" name="box_color" type="text" value="<?php if($DataService["box_color"] == ''){ echo "#333399";}elseif($_POST["box_color"]!=""){ echo valid_output($_POST["box_color"]); }else{ echo valid_output($DataService["box_color"]); }?>" class="color" />
																				</td>
																			</tr>
																			<tr>
																				<td align="left" valign="middle" colspan="4"><br /></td>
																			</tr>
																			<tr>
																				<td align="left" valign="middle"><?php echo ADMIN_SERVICE_QUANTITY_MINIMUM; ?></td>
																				<td align="left" valign="middle" colspan="3">
																					<table>
																					<?php
																					$qty_min = ($_POST['qty_min']!="")?(filter_var($_POST['qty_min'],FILTER_VALIDATE_INT)):(filter_var($DataService['qty_min'],FILTER_VALIDATE_INT));
																					if(isset($_POST['qty_status']) && $_POST['qty_status']==0)
																					{
																						$qty_readonly = 'readonly';
																					}elseif(isset($DataService['qty_status']) && $DataService['qty_status']==0){
																						$qty_readonly = 'readonly';
																					}

																					?>
																					<tr>
																						<td align="left" valign="middle"><input type="text" name="qty_min" id="qty_min"  value="<?php echo $qty_min; ?>" <?php echo $qty_readonly; ?> /></td>
																						<td align="left" valign="middle"><?php echo ADMIN_SERVICE_QUANTITY_MAXIMUM; ?></td>
																						<td align="left" valign="middle"><input type="text" name="qty_max" id="qty_max"  value="<?php echo ($_POST['qty_max']!="")?(filter_var($_POST['qty_max'],FILTER_VALIDATE_INT)):(filter_var($DataService['qty_max'],FILTER_VALIDATE_INT));?>" <?php echo $qty_readonly; ?> /></td>
																						<td align="left" valign="middle"></td>
																					</tr>
																					<tr>
																						<td align="left" valign="middle" class="message_mendatory"><?php if(isset($err['QtyMinError']) && $err['QtyMinError']!=""){ echo $err['QtyMinError'];} ?></td>
																						<td align="left" valign="middle" class="message_mendatory">&nbsp;</td>
																						<td align="left" valign="middle" class="message_mendatory"><?php if(isset($err['QtyMaxError']) && $err['QtyMaxError']!=""){ echo $err['QtyMaxError'];} ?></td>
																						<td align="right" valign="middle" class="message_mendatory">&nbsp;</td>
																						</tr>
																					</table>
																				</td>
																			</tr>

																			<tr>
																				<td align="left" valign="middle"><?php echo ADMIN_SERVICE_QUANTITY_STATUS; ?></td>
																				<td align="left" valign="middle" colspan="3">
																					<table>
																					<tr>
																						<td align="left" valign="middle"><input type="radio" name="qty_status" onclick="hideQty(this.value);" value="1" id="qty_status1"  <?php if($DataService["qty_status"] == "1"){ echo "checked"; }elseif($_POST["qty_status"]=="1"){ echo "checked"; } ?> checked> </td>
																						<td align="left" valign="middle"><label for="qty_status1" >Active </label></input></td>
																						<td align="left" valign="middle"><input type="radio" name="qty_status" onclick="hideQty(this.value);" id="qty_status2" value="0"  <?php if($DataService["qty_status"] == "0"){ echo "checked"; }elseif($_POST["qty_status"]=="0"){ echo "checked"; } ?>></td>
																						<td align="left" valign="middle"><label for="qty_status2" > In - Active </label></input></td>

																					</tr>
																					</table>
																				</td>
																			</tr>
																			<tr>
																				<td align="left" valign="middle" colspan="4"></td>
																			</tr>
																			<tr>
																				<td align="left" valign="middle"><?php echo ADMIN_SERVICE_WEIGHT_MINIMUM; ?></td>
																				<td align="left" valign="middle" colspan="3">
																					<table>
																					<?php
																					if(isset($_POST['weight_status']) && $_POST['weight_status']==0)
																					{
																						$weight_readonly = 'readonly';
																					}elseif(isset($DataService['weight_status']) && $DataService['weight_status']==0){
																						$weight_readonly = 'readonly';
																					}
																					?>
																					<tr>
																						<td align="left" valign="middle"><input type="text" name="weight_min" id="weight_min"  value="<?php  echo ($_POST['weight_min']!="")?(filter_var($_POST['weight_min'],FILTER_VALIDATE_FLOAT)):(filter_var($DataService['weight_min'],FILTER_VALIDATE_FLOAT));?>" <?php echo $weight_readonly; ?> /></td>
																						<td align="left" valign="middle"><?php echo ADMIN_SERVICE_WEIGHT_MAXIMUM; ?></td>
																						<td align="left" valign="middle"><input type="text" name="weight_max" id="weight_max"  value="<?php  echo ($_POST['weight_max']!="")?(filter_var($_POST['weight_max'],FILTER_VALIDATE_FLOAT)):(filter_var($DataService['weight_max'],FILTER_VALIDATE_FLOAT));?>" <?php echo $weight_readonly; ?> /></td>
																						<td align="left" valign="middle"></td>
																					</tr>
																					<tr>
																						<td align="left" valign="middle" class="message_mendatory" ><?php if(isset($err['WeightMinError']) && $err['WeightMinError']!=""){ echo $err['WeightMinError'];} ?></td>
																						<td align="left" valign="middle" class="message_mendatory" ><br /></td>
																						<td align="left" valign="middle" class="message_mendatory" ><?php if(isset($err['WeightMaxError']) && $err['WeightMaxError']!=""){ echo $err['WeightMaxError'];} ?><br /></td>
																						<td align="left" valign="middle" class="message_mendatory" ><br /></td>
																					</tr>
																					</table>
																				</td>
																			</tr>


																			<tr>
																				<td align="left" valign="middle"><?php echo ADMIN_SERVICE_WEIGHT_STATUS; ?></td>
																				<td align="left" valign="middle" colspan="3">
																					<table>
																					<tr>
																						<td align="left" valign="middle"><input type="radio" name="weight_status" onclick="hideWeight(this.value)" value="1" id="weight_status1"  <?php if($DataService["weight_status"] == "1"){ echo "checked"; }elseif($_POST["weight_status"]=="1"){ echo "checked"; } ?> checked> </td>
																						<td align="left" valign="middle"><label for="weight_status1" >Active </label></input></td>
																						<td align="left" valign="middle"><input type="radio" name="weight_status" onclick="hideWeight(this.value)" id="weight_status2" value="0"  <?php if($DataService["weight_status"] == "0"){ echo "checked"; }elseif($_POST["weight_status"]=="0"){ echo "checked"; } ?>></td>
																						<td align="left" valign="middle"><label for="weight_status2" > In - Active </label></input></td>

																					</tr>
																					</table>
																				</td>
																			</tr>
																			<tr>
																				<td align="left" valign="middle" colspan="4"><br /></td>
																			</tr>
																			<?php
																				if(isset($_POST['dim_status']) && $_POST['dim_status']==0)
																				{
																					$dim_readonly = 'readonly';
																				}elseif(isset($DataService['dim_status']) && $DataService['dim_status']==0){
																					$dim_readonly = 'readonly';
																				}
																			?>
																			<tr>
																				<td align="left" valign="middle"><?php echo ADMIN_SERVICE_LENGTH_MINIMUM; ?></td>
																				<td align="left" valign="middle" colspan="3">
																					<table>
																					<tr>
																						<td align="left" valign="middle"><input type="text" name="len_min" id="len_min"  value="<?php  echo ($_POST['len_min']!="")?(filter_var($_POST['len_min'],FILTER_VALIDATE_INT)):(filter_var($DataService['len_min'],FILTER_VALIDATE_INT));?>" <?php echo $dim_readonly; ?> /></td>
																						<td align="left" valign="middle"><?php echo ADMIN_SERVICE_LENGTH_MAXIMUM; ?></td>
																						<td align="left" valign="middle"><input type="text" name="len_max" id="len_max"  value="<?php  echo ($_POST['len_max']!="")?(filter_var($_POST['len_max'],FILTER_VALIDATE_INT)):(filter_var($DataService['len_max'],FILTER_VALIDATE_INT));?>" <?php echo $dim_readonly; ?> /></td>
																						<td align="left" valign="middle"></td>
																					</tr>
																					<tr>
																						<td align="left" valign="middle" class="message_mendatory" ><?php if(isset($err['LengthMinError']) && $err['LengthMinError']!=""){ echo $err['LengthMinError'];} ?></td>
																						<td align="left" valign="middle" class="message_mendatory" ><br /></td>
																						<td align="left" valign="middle" class="message_mendatory" ><?php if(isset($err['LengthMaxError']) && $err['LengthMaxError']!=""){ echo $err['LengthMaxError'];} ?><br /></td>
																						<td align="left" valign="middle" class="message_mendatory" ><br /></td>
																					</tr>
																					</table>
																				</td>
																			</tr>
																			<tr>
																				<td align="left" valign="middle" colspan="4"><br /></td>
																			</tr>
																			<tr>
																				<td align="left" valign="middle"><?php echo ADMIN_SERVICE_WIDTH_MINIMUM; ?></td>
																				<td align="left" valign="middle" colspan="3">
																					<table>
																					<tr>

																						<td align="left" valign="middle"><input type="text" name="width_min" id="width_min"  value="<?php  echo ($_POST['width_min']!="")?(filter_var($_POST['width_min'],FILTER_VALIDATE_INT)):(filter_var($DataService['width_min'],FILTER_VALIDATE_INT));?>" <?php echo $dim_readonly; ?> /></td>
																						<td align="left" valign="middle"><?php echo ADMIN_SERVICE_WIDTH_MAXIMUM; ?></td>
																						<td align="left" valign="middle"><input type="text" name="width_max" id="width_max"  value="<?php  echo ($_POST['width_max']!="")?(filter_var($_POST['width_max'],FILTER_VALIDATE_INT)):(filter_var($DataService['width_max'],FILTER_VALIDATE_INT));?>" <?php echo $dim_readonly; ?> /></td>
																						<td align="left" valign="middle"></td>
																					</tr>
																					<tr>
																						<td align="left" valign="middle" class="message_mendatory" ><?php if(isset($err['WidthMinError']) && $err['WidthMinError']!=""){ echo $err['WidthMinError'];} ?></td>
																						<td align="left" valign="middle" class="message_mendatory" ><br /></td>
																						<td align="left" valign="middle" class="message_mendatory" ><?php if(isset($err['WidthMaxError']) && $err['WidthMaxError']!=""){ echo $err['WidthMaxError'];} ?><br /></td>
																						<td align="left" valign="middle" class="message_mendatory" ><br /></td>
																					</tr>
																					</table>
																				</td>
																			</tr>
																			<tr>
																				<td align="left" valign="middle" colspan="4"><br /></td>
																			</tr>
																			<tr>
																				<td align="left" valign="middle"><?php echo ADMIN_SERVICE_HEIGHT_MINIMUM; ?></td>
																				<td align="left" valign="middle" colspan="3">
																					<table>
																					<tr>

																						<td align="left" valign="middle"><input type="text" name="height_min" id="height_min"  value="<?php  echo ($_POST['height_min']!="")?(filter_var($_POST['height_min'],FILTER_VALIDATE_INT)):(filter_var($DataService['height_min'],FILTER_VALIDATE_INT));?>" <?php echo $dim_readonly; ?> /></td>
																						<td align="left" valign="middle"><?php echo ADMIN_SERVICE_HEIGHT_MAXIMUM; ?></td>
																						<td align="left" valign="middle"><input type="text" name="height_max" id="height_max"  value="<?php  echo ($_POST['height_max']!="")?(filter_var($_POST['height_max'],FILTER_VALIDATE_INT)):(filter_var($DataService['height_max'],FILTER_VALIDATE_INT));?>" <?php echo $dim_readonly; ?> /></td>
																						<td align="left" valign="middle"></td>
																					</tr>
																					<tr>
																						<td align="left" valign="middle" class="message_mendatory" ><?php if(isset($err['HeightMinError']) && $err['HeightMinError']!=""){ echo $err['HeightMinError'];} ?></td>
																						<td align="left" valign="middle" class="message_mendatory" ><br /></td>
																						<td align="left" valign="middle" class="message_mendatory" ><?php if(isset($err['HeightMaxError']) && $err['HeightMaxError']!=""){ echo $err['HeightMaxError'];} ?><br /></td>
																						<td align="left" valign="middle" class="message_mendatory" ><br /></td>
																					</tr>
																					</table>
																				</td>
																			</tr>
																			<tr>
																				<td align="left" valign="middle" colspan="4"><br /></td>
																			</tr>
																			<tr>
																				<td align="left" valign="middle"><?php echo ADMIN_SERVICE_DIMENSION_STATUS; ?></td>
																				<td align="left" valign="middle" colspan="3">
																					<table>
																					<tr>
																						<td align="left" valign="middle"><input type="radio" name="dim_status" value="1" id="dim_status1" onclick="hideDim(this.value)"  <?php if($DataService["dim_status"] == "1"){ echo "checked"; }elseif($_POST["len_status"]=="1"){ echo "checked"; } ?> checked> </td>
																						<td align="left" valign="middle"><label for="len_status1" >Active </label></input></td>
																						<td align="left" valign="middle"><input type="radio" name="dim_status" id="dim_status2" value="0" onclick="hideDim(this.value)"  <?php if($DataService["dim_status"] == "0"){ echo "checked"; }elseif($_POST["len_status"]=="0"){ echo "checked"; } ?>></td>
																						<td align="left" valign="middle"><label for="len_status2" > In - Active </label></input></td>

																					</tr>
																					</table>
																				</td>
																			</tr>
																			<tr>
																				<td align="left" valign="middle" colspan="4"><br /></td>
																			</tr>
																			<tr>
																				<td align="left" valign="middle"><?php echo ADMIN_SERVICE_STATUS; ?></td>
																				<td align="left" valign="middle">
																				<table>
																					<tr>
																						<td><input type="radio" name="status" value="1" id="status1"  <?php if($DataService["status"] == "1"){ echo "checked"; }elseif($_POST["status"]=="1"){ echo "checked"; } ?> checked> </input></td>
																						<td><label for="status1" >Active </label></td>
																						<td><input type="radio" name="status" id="status2" value="0"  <?php if($DataService["status"] == "0"){ echo "checked"; }elseif($_POST["status"]=="0"){ echo "checked"; } ?>></input></td>
																						<td><label for="status2" > In - Active </label></td>
																					</tr>
																				</table>
																			</td>
																			</tr>
																			<tr>
																				<td align="left" valign="middle" colspan="4"><br /></td>
																			</tr>

																			<tr>
																				<td align="left" valign="middle"><?php echo ADMIN_SERVICE_INFO; ?></td>
																				<td align="left" valign="middle"  colspan="3">
																				<textarea name="service_info" id="service_info" cols="48" rows="5" >
																				<?php if(isset($DataService["service_info"])){echo htmlspecialchars($DataService["service_info"]);} ?>
																				</textarea>
																				<script>
																				CKEDITOR.replace('service_info');
																				</script>
																				</td>
																			</tr>
																			<tr>
																				<td align="left" valign="middle">

																				<br/></td>
																				<td class="message_mendatory" colspan="3"><?php if(isset($err['ServiceInfoError']) && $err['ServiceInfoError']!=''){ echo $err['ServiceInfoError'];} ?></td>
																			</tr>
																			<tr>
																				<td align="left" valign="middle"><?php echo ADMIN_SERVICE_INFO_STATUS; ?></td>
																				<td align="left" valign="middle"  colspan="3">
																				<input type="radio" name="service_status_info" value="1" id="service_status_info1"  <?php if($DataService["service_status_info"] == "1"){ echo "checked"; }elseif($_POST["service_status_info"]=="1"){ echo "checked"; } ?> checked> <label for="status1" >Active </label></input>
																				<input type="radio" name="service_status_info" id="service_status_info2" value="0"  <?php if($DataService["service_status_info"] == "0"){ echo "checked"; }elseif($_POST["service_status_info"]=="0"){ echo "checked"; } ?>><label for="status2" > In - Active </label></input>
																				</td>
																			</tr>

																			<tr>
																				<td align="left" valign="middle" colspan="4"><br /></td>
																			</tr>

																			<tr>
																				<td align="left" valign="middle"><?php echo ADMIN_SERVICE_DESCRIPTION; ?></td>
																				<td align="left" valign="middle" class="message_mendatory" colspan="2">
																					<?php
																					if(isset($DataService["service_description"]) && !empty($auto_id)) {
																						$service_des=stripslashes($DataService["service_description"]);

																					}
																					elseif($_POST["service_description"]!=""){
																						$service_des=$_POST["service_description"];
																					}else{
																						$service_des='';
																					}

																					//$oFCKeditor->Create();?>
																				<textarea cols="80" id="service_description" name="service_description" rows="10"><?php echo htmlspecialchars($service_des); ?></textarea>
																				<script>
																				CKEDITOR.replace('service_description');
																				</script>
																				</td>
																				<td align="left" valign="top" class="message_mendatory">
																				</td>
																			</tr>
																			<tr>
																				<td align="left" valign="middle" colspan="4"><br /></td>
																			</tr>

																			<tr>
																				<td align="left" valign="middle" colspan="4"><br /></td>
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
														<td align="left">
															<input type="hidden" size="34" id="ptoken" value="<?php echo $ptoken; ?>" name="ptoken">
															<input type="submit" class="action_button" tabindex="36" name="submit" value="<?php echo $btnSubmit; ?>" onclick="return validate_service(this.form);" />
															<input type="reset" tabindex="37" name="reset" class="action_button" value="<?php echo ADMIN_COMMON_BUTTON_RESET; ?>" />
															<input type="button" class="action_button" name="cancel" tabindex="38" value="<?php echo ADMIN_COMMON_BUTTON_CANCEL;?>" onclick="javascript:document.location.href='<?php echo FILE_STE_SERVICE.'?pagenum='.$pagenum; ?>';return true;" />
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
<?php if($auto_id!="")
{
	?>
<script type="text/javascript">

$(document).ready(function(){
	$("#service_name").attr('readonly', true);
	$("#service_code").attr('readonly', true);
	$("#supplier").attr("disabled", true);
	$("#type").attr("disabled", true);
});
</script>
<?php } else {
	?>
<script type="text/javascript">
$(document).ready(function(){

	$("#supplier").change(function(){
		var supplier_id=$("#supplier").val();
		var xmlhttp;
		xmlhttp=ajaxRequest();
		xmlhttp.onreadystatechange=function()
		{
			if (xmlhttp.readyState==4 && xmlhttp.status==200)
			{
				var msg=xmlhttp.responseText;
				$("#product_code_id").html(msg);

			}
		}
		xmlhttp.open("POST","service_action.php?Action=findproductcode&supplier_id="+supplier_id);
		xmlhttp.send();

	});
});
function ajaxRequest(){
	var activexmodes=["Msxml2.XMLHTTP", "Microsoft.XMLHTTP"] //activeX versions to check for in IE
	if (window.ActiveXObject){ //Test for support for ActiveXObject in IE first (as XMLHttpRequest in IE7 is broken)
		for (var i=0; i<activexmodes.length; i++){
			try{
				return new ActiveXObject(activexmodes[i])
			}
			catch(e){

				//suppress error
			}
		}
	}
	else if (window.XMLHttpRequest) // if Mozilla, Safari etc
	return new XMLHttpRequest()
	else
	return false;
}
</script>
<?php
}?>
