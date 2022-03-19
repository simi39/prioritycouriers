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
require_once(DIR_WS_MODEL . "TransitPriceMaster.php");
require_once(DIR_WS_ADMIN_LANGUAGES . DIR_CURRENT_LANGUAGE. '/transit_cal.php');
require_once(DIR_WS_MODEL . "TransitPriceDetailMaster.php");
require_once(DIR_WS_MODEL . "SupplierMaster.php");	
require_once(DIR_WS_MODEL . "SupplierData.php");


$ObjTranPriceMaster	=	new TransitPriceMaster();
$ObjTranPriceMaster	=	$ObjTranPriceMaster->create();
$TranPriceData		= new TransitPriceData();

$ObjSupplierMaster	= new SupplierMaster();
$ObjSupplierMaster	= $ObjSupplierMaster->Create();
$SupplierData		= new SupplierData();

$ObjTranPriceDetailMaster 	= new TransitPriceDetailMaster();
$ObjTranPriceDetailMaster 	= $ObjTranPriceDetailMaster->create();
$TranPriceDetailData			= new TransitPriceDetailData();
$arr_javascript_plugin_include[] = 'datatables/datatables.min.js';

$arr_css_plugin_include[] = 'datatables/datatables.min.css';
$arr_css_plugin_include[] = 'datatables/Buttons-1.6.5/css/buttons.dataTables.min.css';
/*csrf validation*/
$csrf = new csrf();
$csrf->action = "add_transit_cal";
if(!isset($_POST['ptoken']))
{
	$ptoken = $csrf->csrfkey();
}
/*csrf validation*/

$transitId = $_GET['transitId'];
$err['transitId'] = isNumeric($transitId,ENTER_ONLY_NUMERIC_VALUE);
if(isset($err['transitId']) && $err['transitId']!='')
{
	echo $err['transitId'];
	exit();
}
$countitem = 1;
if(!empty($_GET['action']))
{
	$err['action'] = chkStr(valid_input($_GET['action']));
}
if(!empty($err['action']))
{
	logOut();
}

if(isset($_POST['submit']) && $_POST['submit'] == 'Save')
{
	
	if(isEmpty(valid_input($_POST['ptoken']), true)){	
		logOut();
	}else{
		//$csrf->checkcsrf($_POST['ptoken']);
	}
	
	$Validation = true;
	$countitem = count($_POST['param1_unit_type']);
	
	$err =  array();
	
	
		$unitType = array();
		for($i=1;$i<4;$i++)
		{
			for($j=0;$j<$countitem;$j++)
			{
				$unitTypeTag = $_POST["param".$i."_unit_type"][$j];
				$unitType['range_from'][$j] = $_POST["range_from"][$j];
				$unitType['range_to'][$j] = $_POST["range_to"][$j];
				$unitType['unit'.$i][$j] = $_POST["param".$i."_unit_type"][$j];
				$unitType['param'.$i][$j] = $_POST["param".$i."_unit_type"][$j];
				$unitType[$unitTypeTag] = array();
				$unitType[$unitTypeTag]["rate_type"] 	= $_POST["param".$i."_rate_type"];   	
				$unitType[$unitTypeTag]["amount"] 		= $_POST["param".$i."_amount"];
				
				
					if(empty($unitType['range_from'][$j]))
					{
						$unitType["rangeFromError"][$j] = ENTER_RANGE_FROM;
						
					}
					
					if(!empty($unitType['range_from'][$j]))
					{
						$unitType["rangeFromError"][$j] = isNumeric($unitType['range_from'][$j],ENTER_NUMERIC_VALUES_ONLY);
						
					}
					if(empty($unitType['range_to'][$j]))
					{
						$unitType["rangeToError"][$j] = ENTER_RANGE_TO;
						
					}
					if(!empty($unitType['range_to'][$j]))
					{
						$unitType["rangeToError"][$j] = isNumeric($unitType['range_to'][$j],ENTER_NUMERIC_VALUES_ONLY);
						
					}
				
				if(!empty($_POST["param".$i."_unit_type"][$j]))
				{
					$unitType["param".$i."UnitTypeError"][$j] = 	checkName($_POST["param".$i."_unit_type"][$j]);		
					
				}
				if(empty($_POST["param".$i."_rate_type"][$j]))
				{
					$unitType["param".$i."RateTypeError"][$j] 	= "Rate type of " .ucfirst($_POST["param".$i."_unit_type"][$j])." Required";	
					
				}
				
				if(!empty($_POST["param".$i."_rate_type"][$j]))
				{
					$unitType["param".$i."RateTypeError"][$j] = isNumeric($_POST["param".$i."_rate_type"][$j],ENTER_NUMERIC_VALUES_ONLY);
					
				}
				if(($_POST["param".$i."_amount"][$j])==""){
					$unitType["param".$i."AmtError"][$j]  		= "Amount of " .ucfirst($_POST["param".$i."_unit_type"][$j])." Required";
					
				}
				if(!empty($_POST["param".$i."_amount"][$j]))			
				{
					$unitType["param".$i."AmtError"][$j]  		= isFloat(($_POST["param".$i."_amount"][$j]),"Please enter numeric value.");
					
				}
			}
		}
		
		$serializeUnit = json_encode($unitType);
	
	
	
	$tariff_type 	= $_POST['tariff_type']; 
	$goods_nature 	= $_POST['goods_nature'];
	
	$active 		= $_POST["active"];
	if(!empty($_POST['active']))
	{
		$err['active'] = isNumeric(valid_input($_POST['active']),ENTER_NUMERIC_VALUES_ONLY);
	}
	if(!empty($err['active']))
	{
		logOut();
	}
	
	$err['tariffErr'] 		 = isEmpty(valid_input($tariff_type),TERRIF_TYPE_IS_REQUIRED)?isEmpty(valid_input($tariff_type),TERRIF_TYPE_IS_REQUIRED):isNumeric(valid_input($tariff_type),ENTER_NUMERIC_VALUES_ONLY);
	$err['goodsTypeErr'] 	 = isEmpty(valid_input($goods_nature),GOODS_TYPE_IS_REQUIRED)?isEmpty(valid_input($goods_nature),GOODS_TYPE_IS_REQUIRED):checkStr($goods_nature);
	
	
	for($l=0;$l<$countitem;$l++)
	{
		$error['unitTypeErr'][$l] 	 = isEmpty($unitType["unit"]["rate_type"][$l],1);
		$error['unitAmtErr'][$l] 		 = isEmpty($unitType["unit"]["amount"][$l],1);
		$error['basicTypeErr'][$l] 	 = isEmpty($unitType["basic"]["rate_type"][$l],1);
		$error['basicAmtErr'][$l] 	 = isEmpty($unitType["basic"]["amount"][$l],1);
		$error['minimumTypeErr'][$l] 	 = isEmpty($unitType["minimum"]["rate_type"][$l],1);
		$error['minimumAmtErr'][$l] 	 = isEmpty($unitType["minimum"]["amount"][$l],1);
		
	}
	foreach ($error as $Ekey){
		
		foreach($Ekey as $key=> $val)
		{
			if($val == 1){
				$Validation = false;
			}
		}
	}
	//exit();
	foreach ($err as $Ekey=> $Eval){
		
		if($Eval != ""){
			$Validation = false;
		}
	}
	if($Validation == false)
	{
		$ptoken = $csrf->csrfkey();
	}
	
	if($Validation ==  true){
		
		$fldArr = array("*");
		$seaArr = Array();
		$seaArr[] = array('Search_On'=>'tariff_type',
						'Search_Value'=>valid_input($tariff_type),
						'Type'=>'string',
						'Equation'=>'=',
						'CondType'=>'AND',
						'Prefix'=>'',
						'Postfix'=>'');
		$seaArr[] = array('Search_On'=>'tariff_goods_nature',
						'Search_Value'=>valid_input($goods_nature),
						'Type'=>'string',
						'Equation'=>'=',
						'CondType'=>'AND',
						'Prefix'=>'',
						'Postfix'=>'');
		
		$chkEntry = $ObjTranPriceMaster->getTransitPrice($fldArr,$seaArr,null,null,null,null,$query);
		$chkEntry = $chkEntry[0];
		
		$TranPriceData->tariff_type			 = $_POST['tariff_type'];
		$TranPriceData->tariff_goods_nature  = $_POST['goods_nature'];
		
		$TranPriceData->status			=  $serializeUnit ;
		$TranPriceData->active			=  $active ;
		
		
		if(isset($transitId) && $transitId != "")
		{			
			$TranPriceData->transit_id 	=  $transitId;
			$ObjTranPriceMaster->editTransitPrice($TranPriceData,true,true);
			
		}else
		{	
			if(is_array($chkEntry) && count($chkEntry) >=1){
					$err["price_exists"] = PRICE_EXIT_FOR_NATURE_OF_GOODS;
					$ptoken = $csrf->csrfkey();
			}else{	
				$ObjTranPriceMaster->addTransitPrice($TranPriceData,null);
			}
		}
		
		if($err["price_exists"] == "")
		{
			header("location:".FILE_TRANSIT_LIST."?transitId=".$insertId."&action=Add");
			exit;
		}
		
	}
}



if(isset($transitId) && $transitId != "")
{
	$seaArr = Array();
	$fldArr = array("*");
	$seaArr[] = array('Search_On'=>'transit_id ',
						'Search_Value'=>valid_input($transitId),
						'Type'=>'string',
						'Equation'=>'=',
						'CondType'=>'AND',
						'Prefix'=>'',
						'Postfix'=>'');
	$TranPriceData = $ObjTranPriceMaster->getTransitPrice($fldArr,$seaArr);
	if(!empty($TranPriceData)){
		$TranPriceData = $TranPriceData[0];
	}
	$unserializeUnit = 	json_decode($TranPriceData['status'],true);
	$countitem = count($unserializeUnit['unit1']);
	
	if(is_array($chkEntry) && count($chkEntry) >=1){
		$err["price_exists"] = PRICE_EXIT_FOR_NATURE_OF_GOODS;
		$ptoken = $csrf->csrfkey();
		exit();
	}
	
}

?>
<?php
$fieldArr=array("auto_id","supplier_name");
$DataSupplier = $ObjSupplierMaster->getSupplier($fieldArr);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo ADMIN_USER?></title>
<!--<script type="text/javascript" src="http://code.jquery.com/jquery-1.7.min.js"></script>-->
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
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
 
<script>

function valid_transit()
{
	
	if($("#tariff_type").val() == 'Select'){
		$("#err_tariff_type").html("Please select any tariff type.");
		return false;
	}else{
		$("#err_tariff_type").html("");
	}
	
	if($("#goods_nature").val() == 'Select'){
		$("#err_goods_nature").html("Please select any nature of goods.");
		return false;
	}else{
		$("#err_goods_nature").html("");
	}
	
		
}



function addTariffTbl()
{
	var tblTariffData,tblTariffBody,totTariffDataRows;
	tblTariffData = document.getElementById("tariffTbl");
	tblTariffBody = tblTariffData.tBodies[0];
	totTariffDataRows = tblTariffData.rows.length;
	var newRowNo = totTariffDataRows + 1;
	
	var firstRowNo = totTariffDataRows + 2;
	var firstDummy = dummy;
	var errFirstRowNo = totTariffDataRows + 3;
	var errFirstDummy = dummy;
	
	var secRowNo = totTariffDataRows + 4;
	var secDummy = dummy;
	var errSecRowNo = totTariffDataRows + 5;
	var errSecDummy = dummy;
	
	var thirdRowNo = totTariffDataRows + 6;
	var thirdDummy = dummy;
	var errThirdRowNo = totTariffDataRows + 7;
	var errThirdDummy = dummy;
	
	if(newRowNo > dummy)
	{
		dummy = newRowNo;
	}
	if(firstRowNo > firstDummy)
	{
		firstDummy = firstRowNo;
	}
	if(errFirstRowNo > errFirstDummy)
	{
		errFirstDummy = errFirstRowNo;
	}
	if(secRowNo > secDummy)
	{
		secDummy = secRowNo;
	}
	if(errSecRowNo > errSecDummy)
	{
		errSecDummy = errSecRowNo;
	}
	if(thirdRowNo > thirdDummy)
	{
		thirdDummy = thirdRowNo;
	}
	if(errThirdRowNo > errThirdDummy)
	{
		errThirdDummy = errThirdRowNo;
	}
	
	var newtblTariffDataRow = tblTariffBody.insertRow(newRowNo-1);
	var firsttblTariffDataRow = tblTariffBody.insertRow(firstRowNo-1);
	var errFirstTariffDataRow = tblTariffBody.insertRow(errFirstRowNo-1);
	var sectblTariffDataRow = tblTariffBody.insertRow(secRowNo-1);
	var errSecTariffDataRow = tblTariffBody.insertRow(errSecRowNo-1);
	var thirdtblTariffDataRow = tblTariffBody.insertRow(thirdRowNo-1);
	var errThirdTariffDataRow = tblTariffBody.insertRow(errThirdRowNo-1);
		
	var Range ="<td><table><tr><td><?php echo RANGE_FROM; ?></td><td><input type='text' name='range_from[]' id='range_from_"+dummy+"'  /></td><td><?php echo RANGE_TO; ?></td><td><input type='text' name='range_to[]' id='range_to_"+dummy+"'/></td></tr><tr><td></td><td></td><td></td><td></td></tr></table></td>";
	var CellData = [Range];
	for (var i = 0; i < CellData.length; i++) {
		newCell = newtblTariffDataRow.insertCell(i);
		newCell.innerHTML = CellData[i];
		
		tblTariffBody.rows[newRowNo-1].cells[0].colSpan = 3;
		newtblTariffDataRow.id =dummy;
	}
	
	var firstUnit = '<select id="param1_unit_type'+dummy+'" name="param1_unit_type[]"><option value="basic" <?php if($teriffType1 == "basic") echo "selected";?>>Basic</option><option value="unit" <?php if($teriffType1 == "unit") echo "selected";?>>Unit</option><option value="minimum" <?php if($teriffType1 == "minimum") echo "selected";?>>Minimum</option></select>';
	var firstRate = '<select name="param1_rate_type[]" id="param1_rate_type_'+dummy+'" style="width:144px"><option value="0">Select</option><option value="1" <?php if($teriffRateType1 == 1) echo "selected";?>>Flat</option><option value="2" <?php if($teriffRateType1 == 2) echo "selected";?>>Percentage</option></select>';
	var firstAmount = '<input type="text" name="param1_amount[]" value="<?php echo valid_input($teriffAmt1);?>" id="param1_amount_'+dummy+'" style="width:72px;">';
	var firstCellData = [firstUnit,firstRate,firstAmount];
	for (var j = 0; j < firstCellData.length; j++) {
		newCell = firsttblTariffDataRow.insertCell(j);
		newCell.innerHTML = firstCellData[j];
		tblTariffBody.rows[newRowNo-1].cells[0].colSpan = 3;
		firsttblTariffDataRow.id = firstDummy;
	}
	var errFirstUnit = '&nbsp;';
	var errFirstRate = '&nbsp;';
	var errFirstAmount = '&nbsp;';
	var errFirstCellData = [errFirstUnit,errFirstRate,errFirstAmount];
	for (var k = 0; k < errFirstCellData.length; k++) {
		newCell = errFirstTariffDataRow.insertCell(k);
		newCell.innerHTML = errFirstCellData[k];
		tblTariffBody.rows[newRowNo-1].cells[0].colSpan = 3;
		errFirstTariffDataRow.id = errFirstDummy;
	}
	
	var secUnit = '<select id="param2_unit_type_'+secDummy+'" name="param2_unit_type[]"><option value="basic" <?php if($teriffType2 == "basic") echo "selected";?>>Basic</option><option value="unit" <?php if($teriffType2 == "unit") echo "selected";?>>Unit</option><option value="minimum" <?php if($teriffType2 == "minimum") echo "selected";?>>Minimum</option></select>';
	var secRate = '<select name="param2_rate_type[]" id="param2_rate_type_'+secDummy+'" style="width:144px"><option value="0">Select</option><option value="1" <?php if($teriffRateType1 == 1) echo "selected";?>>Flat</option><option value="2" <?php if($teriffRateType1 == 2) echo "selected";?>>Percentage</option></select>';
	var secAmount = '<input type="text" name="param2_amount[]" value="<?php echo valid_input($teriffAmt2);?>" id="param2_amount_'+secDummy+'" style="width:72px;">';
	var secCellData = [secUnit,secRate,secAmount];
	for (var l = 0; l < secCellData.length; l++) {
		newCell = sectblTariffDataRow.insertCell(l);
		newCell.innerHTML = secCellData[l];
		tblTariffBody.rows[newRowNo-1].cells[0].colSpan = 3;
		sectblTariffDataRow.id = secDummy;
	}
	
	var errSecUnit = '&nbsp;';
	var errSecRate = '&nbsp;';
	var errSecAmount = '&nbsp;';
	var errSecCellData = [errSecUnit,errSecRate,errSecAmount];
	for (var m = 0; m < errSecCellData.length; m++) {
		newCell = errSecTariffDataRow.insertCell(m);
		newCell.innerHTML = errSecCellData[m];
		tblTariffBody.rows[newRowNo-1].cells[0].colSpan = 3;
		errSecTariffDataRow.id = errSecDummy;
	}
	
	var thirdUnit = '<select id="param3_unit_type_'+thirdDummy+'" name="param3_unit_type[]"><option value="basic" <?php if($teriffType1 == "basic") echo "selected";?>>Basic</option><option value="unit" <?php if($teriffType3 == "unit") echo "selected";?>>Unit</option><option value="minimum" <?php if($teriffType3 == "minimum") echo "selected";?>>Minimum </option></select>';
	var thirdRate = '<select name="param3_rate_type[]" id="param3_rate_type_'+thirdDummy+'" style="width:144px"><option value="0">Select</option><option value="1" <?php if($teriffRateType1 == 1) echo "selected";?>>Flat</option><option value="2" <?php if($teriffRateType1 == 2) echo "selected";?>>Percentage</option></select>';
	var thirdAmount = '<input type="text" name="param3_amount[]" value="<?php echo valid_input($teriffAmt3);?>" id="param3_amount_'+thirdDummy+'" style="width:72px">';
	var thirdDelete = '<input type="button" value="REMOVE" name="deleteSizeData[]" class="btn"  onclick="DelTariffTableDataRow('+dummy+','+firstDummy+','+errFirstDummy+','+secDummy+','+errSecDummy+','+thirdDummy+','+errThirdDummy+');"	/>';
	var thirdCellData = [thirdUnit,thirdRate,thirdAmount,thirdDelete];
	for (var n = 0; n < thirdCellData.length; n++) {
		newCell = thirdtblTariffDataRow.insertCell(n);
		newCell.innerHTML = thirdCellData[n];
		tblTariffBody.rows[newRowNo-1].cells[0].colSpan = 3;
		thirdtblTariffDataRow.id = thirdDummy;
	}
	
	var errThirdUnit = '&nbsp;';
	var errThirdRate = '&nbsp;';
	var errThirdAmount = '&nbsp';
	var errThirdCellData = [errThirdUnit,errThirdRate,errThirdAmount];
	for (var r = 0; r < errThirdCellData.length; r++) {
		newCell = errThirdTariffDataRow.insertCell(r);
		newCell.innerHTML = errThirdCellData[r];
		tblTariffBody.rows[newRowNo-1].cells[0].colSpan = 3;
		errThirdTariffDataRow.id = errThirdDummy;
	}
}
function DelTariffTableDataRow(Rowno,firstRowno,errFirstDummyRow,secRowno,errSecDummyRow,thirdRowNo,errThirdDummyRow){
	var tblSizeTypeData, tblSizeTypeDataBody;
	tblSizeTypeData = document.getElementById("tariffTbl");

	tblSizeTypeDataBody = tblSizeTypeData.tBodies[0];
	var tbl = document.getElementById('tariffTbl');
	var lastRow = tbl.rows.length;
	var no_rows = 1;
	//alert("Rowno"+Rowno+"firstRowno"+firstRowno);
	
	for (var i=1;i<lastRow;i++)
	{
		var Rowid = tblSizeTypeDataBody.rows[i].id;
		no_rows = i;
		if (Rowid == Rowno)
		{
			document.getElementById("tariffTbl").deleteRow(i);
			no_rows = no_rows-1;
			break;
		}
		
	}
	for (var i=1;i<lastRow;i++)
	{
		var Rowid = tblSizeTypeDataBody.rows[i].id;
		no_rows = i;
		if (Rowid == firstRowno)
		{
			document.getElementById("tariffTbl").deleteRow(i);
			no_rows = no_rows-1;
			break;
		}
	}
	for (var i=1;i<lastRow;i++)
	{
		var Rowid = tblSizeTypeDataBody.rows[i].id;
		no_rows = i;
		if (Rowid == errFirstDummyRow)
		{
			document.getElementById("tariffTbl").deleteRow(i);
			no_rows = no_rows-1;
			break;
		}
	}
	for (var i=1;i<lastRow;i++)
	{
		var Rowid = tblSizeTypeDataBody.rows[i].id;
		no_rows = i;
		if (Rowid == secRowno)
		{
			document.getElementById("tariffTbl").deleteRow(i);
			no_rows = no_rows-1;
			break;
		}
	}
	for (var i=1;i<lastRow;i++)
	{
		var Rowid = tblSizeTypeDataBody.rows[i].id;
		no_rows = i;
		if (Rowid == errSecDummyRow)
		{
			document.getElementById("tariffTbl").deleteRow(i);
			no_rows = no_rows-1;
			break;
		}
	}
	for (var i=1;i<lastRow;i++)
	{
		var Rowid = tblSizeTypeDataBody.rows[i].id;
		no_rows = i;
		if (Rowid == thirdRowNo)
		{
			document.getElementById("tariffTbl").deleteRow(i);
			no_rows = no_rows-1;
			break;
		}
	}
	for (var i=1;i<lastRow;i++)
	{
		var Rowid = tblSizeTypeDataBody.rows[i].id;
		no_rows = i;
		if (Rowid == errThirdDummyRow)
		{
			document.getElementById("tariffTbl").deleteRow(i);
			no_rows = no_rows-1;
			break;
		}
	}

}
function CancelChgs() {
    var x;
    if (confirm("Do you want to save these changes?") == true) {
        x = 1;
		 $("#cnfChanges").val(x);
		 return true;
		//window.location="add_transit_cal.php?action=edit&transitId="+<?php echo $_GET['transitId']; ?>;
    } else {
        x = 0;
		 $("#cnfChanges").val(x);
		return false
    }
   
		
}
</script>
</head>
<body>

<table width="100%" border="0" cellspacing="0" cellpadding="0" id="main" align="center" >
	<tr>
		<td>
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
						<table border="0" width="100%" cellpadding="0" cellspacing="0"  align="left" class="">
							<tr>
								<td align="left" class="breadcrumb">
								<span><a href="<?php echo FILE_WELCOME_ADMIN; ?>"><?php echo ADMIN_HEADER_HOME;?></a> > <a href="<?php echo FILE_TRANSIT_LIST; ?>"><?php echo ADMIN_HEADER_TRANSIT_LIST; ?></a></span>
								<div><label class="top_navigation">
								<label class="top_navigation"><a href="<?php echo FILE_ADD_TRANSIT; ?>"><?php echo ADMIN_ADD_NEW ; ?></a>
														
								</label>
							
								</div>

								</td>
							</tr>
							<tr>
								<td class="heading">
								<?php echo ADMIN_HEADER_TRANSIT_LIST; ?>
								</td>
							</tr>
							<?php if(!empty($err)) {?>
							<tr>
								<td class="message_mendatory" align="center"><?php echo valid_output($err['price_exists']); ?></td>
							</tr>							
							<?php } ?>
							<!--  End Searching	-->
							<tr>
								<td align="left">
								
							<?php  /*** Start :: Listing Table ***/ ?>
							
									<div id="container">

										<div id="jquery_table"  class="jquery_pagination" style="padding:12px !important">
											<form name="add_transit_cal" id="add_transit_cal" method="post" >
											<table width="100%" cellpadding="2" cellspacing="0"  align="left"  class="display" id="maintable">
												
												<tr>
													<td class="table_hd" colspan="8">
														<table>
															<tr>
																<td colspan="4" class="grayheader"><?php echo SELECT_CALCULATION_TYPE; ?></td>
															</tr>
															<tr>
																<td class="table_hd" colspan="2"><?php echo TARIFF_TYPE; ?></td>
																
																<td class="table_hd" colspan="2" >
																<select id="tariff_type" name="tariff_type" >
																<option  selected>Select</option>
																<?php 
																	if($DataSupplier!='')
																	{
																		foreach ($DataSupplier as $supplier_details) 
																		{		
																			
																?>
																	<option value="<?php echo $supplier_details['auto_id']; ?>" <?php if(isset($_POST['tariff_type']) && $_POST['tariff_type'] == $supplier_details['auto_id']){ echo "selected";}elseif($TranPriceData['tariff_type']==$supplier_details['auto_id']){ echo "selected";	} ?>><?php echo valid_output($supplier_details['supplier_name']); ?></option>
																<?php
																		}
																	}
																?>
																</select>
																</td>
																</tr>
																
																<tr>
																	<td class="message_mendatory" colspan="2"></td>
																	<td class="message_mendatory" colspan="2" id="err_tariff_type"><?php if(isset($err['tariffErr']) && $err['tariffErr']!=""){ echo $err['tariffErr'];} ?></td>
																</tr>
																<?php if($_POST["goods_nature"] == ""){$goods_nature = $TranPriceData["tariff_goods_nature"] ;}else{$goods_nature = $_POST["goods_nature"]; } ?>
																<tr>
																	<td class="table_hd" colspan="2"><?php echo NATURE_OF_GOODS; ?></td>
																	<td class="table_hd" colspan="2">
																	<select id="goods_nature" name="goods_nature">
																	<option>Select</option>	
																	<option value="commercial" <?php if(valid_input($goods_nature) == "commercial"){ echo "selected = 'selected'";}?>> Commercial </option>
																	<option value="document" <?php if(valid_input($goods_nature) == "document"){ echo "selected = 'selected'";}?>> Document </option>
																	<option value="personal_effects" <?php if(valid_input($goods_nature) == "personal_effects"){ echo "selected = 'selected'";}?>> Personal Effects </option>
																	</select>	
																	</td>
																	
																</tr>
																<tr>
																	<td class="message_mendatory" colspan="2"></td>
																	<td class="message_mendatory" colspan="2" id="err_goods_nature"><?php if(isset($err['goodsTypeErr']) && $err['goodsTypeErr']!=""){ echo $err['goodsTypeErr'];} ?></td>
																</tr>
																
																<tr>
																	<td class="table_hd" colspan="2"><?php echo TARIFF_STATUS; ?></td>
																	<td class="table_hd"><input type="radio" name="active" value="1"  <?php if($TranPriceData["active"] == "1"){ echo "checked"; }elseif($_POST["active"]=="1"){ echo "checked"; } ?> checked>Active</input></td>
																	<td class="table_hd"><input type="radio" name="active" value="0"  <?php if($TranPriceData["active"] == "0"){ echo "checked"; }elseif($_POST["active"]=="0"){ echo "checked"; } ?>>In-active</input></td>
																	<td class="table_hd"></td>
																</tr>
																<tr>
																	<td colspan="4" class="grayheader"><?php echo ENTER_TARIFF_TABLE; ?></td>
																</tr>
																
																<tr>
																	<td colspan="4">
																		<table id="tariffTbl" border="0" cellpadding="0" cellspacing="0" >
																			<?php 
																				
																				for($k=0;$k<$countitem;$k++)
																				{
																					
																					if($_POST["param1_unit_type"][$k] == ""){$teriffType1[$k] = $unserializeUnit["param1"][$k] ;}else{$teriffType1[$k] = $_POST["param1_unit_type"][$k]; }
																					if($_POST["param2_unit_type"][$k] == ""){$teriffType2[$k] = $unserializeUnit["param2"][$k] ;}else{$teriffType2[$k] = $_POST["param2_unit_type"][$k]; }
																					if($_POST["param3_unit_type"][$k] == ""){$teriffType3[$k] = $unserializeUnit["param3"][$k] ;}else{$teriffType3[$k] = $_POST["param3_unit_type"][$k]; }
																					
																					if($_POST["param1_rate_type"][$k] == ""){$teriffRateType1[$k] = $unserializeUnit[$unserializeUnit["param1"][$k]]["rate_type"][$k] ;}else{$teriffRateType1[$k] = $_POST["param1_rate_type"][$k]; }
																					if($_POST["param2_rate_type"][$k] == ""){$teriffRateType2[$k] = $unserializeUnit[$unserializeUnit["param2"][$k]]["rate_type"][$k] ;}else{$teriffRateType2[$k] = $_POST["param2_rate_type"][$k]; }
																					if($_POST["param3_rate_type"][$k] == ""){$teriffRateType3[$k] = $unserializeUnit[$unserializeUnit["param3"][$k]]["rate_type"][$k] ;}else{$teriffRateType3[$k] = $_POST["param3_rate_type"][$k]; }
																					if($_POST["param1_amount"][$k] == ""){$teriffAmt1[$k] = $unserializeUnit[$unserializeUnit["param1"][$k]]["amount"][$k] ;}else{$teriffAmt1[$k] = $_POST["param1_amount"][$k]; }
																					if($_POST["param2_amount"][$k] == ""){$teriffAmt2[$k] = $unserializeUnit[$unserializeUnit["param2"][$k]]["amount"][$k] ;}else{$teriffAmt2[$k] = $_POST["param2_amount"][$k]; }
																					if($_POST["param3_amount"][$k] == ""){$teriffAmt3[$k] = $unserializeUnit[$unserializeUnit["param3"][$k]]["amount"][$k] ;}else{$teriffAmt3[$k] = $_POST["param3_amount"][$k]; }
																					if($_POST['range_from'][$k] == ""){$range_from[$k] = $unserializeUnit["range_from"][$k];}else{ $range_from[$k] = $_POST['range_from'][$k];}
																					if($_POST['range_to'][$k] == ""){$range_to[$k] = $unserializeUnit["range_to"][$k];}else{ $range_to[$k] = $_POST['range_to'][$k];}
																					
																					
																					
																				
																				
																			?>
																			
																			<tr>
																				<td colspan="3">
																				<table id="rngTbl" >
																						
																						<tr>
																							<td><?php echo RANGE_FROM; ?></td>
																							<td><input type="text" name="range_from[]" id="range_from" value="<?php echo $range_from[$k];  ?>"/></td>
																							<td><?php echo RANGE_TO; ?></td>
																							<td><input type="text" name="range_to[]" id="range_to" value="<?php echo $range_to[$k]; ?>"/></td>
																						</tr>
																						<tr>
																							<td></td>
																							<td class="message_mendatory"><?php if(isset($unitType["rangeFromError"][$k]) && $unitType["rangeFromError"][$k] != ""){ echo $unitType["rangeFromError"][$k];}?></td>
																							<td></td>
																							<td class="message_mendatory"><?php if(isset($unitType["rangeToError"][$k]) && $unitType["rangeToError"][$k] != ""){ echo $unitType["rangeToError"][$k];}?></td>
																						</tr>
																						
																					</table>
																				</td>
																			</tr>
																			
																			<tr>
																				<td>
																					<select id="param1_unit_type" name="param1_unit_type[]">
																					<option value="basic" <?php if($teriffType1[$k] == "basic") echo "selected";?>>Basic</option>
																					<option value="unit" <?php if($teriffType1[$k] == "unit") echo "selected";?>>Unit</option>
																					<option value="minimum" <?php if($teriffType1[$k] == "minimum") echo "selected";?>>Minimum</option>
																					</select>
																				</td>
																				<td>
																					<select name="param1_rate_type[]" id="param1_rate_type" style="width:144px">
																					<option value="0">Select</option>								
																					<option value="1" <?php if($teriffRateType1[$k] == 1) echo "selected";?>>Flat</option>								
																					<option value="2" <?php if($teriffRateType1[$k] == 2) echo "selected";?>>Percentage</option>								
																					</select>
																				</td>
																				<td>
																					<input type="text" name="param1_amount[]" value="<?php echo valid_input($teriffAmt1[$k]);?>" id="param1_amount" style="width:72px;">
																				</td>
																			</tr>
																			<tr>
																				<td id="err_param1_unit_type" class="message_mendatory"><?php if(isset($err) && isset($unitType["param1UnitTypeError"][$k])){ echo $unitType["param1UnitTypeError"][$k];} ?>&nbsp;</td>
																				<td id="err_param1_rate_type" class="message_mendatory"><?php if(isset($err) && isset($unitType["param1RateTypeError"][$k])){ echo $unitType["param1RateTypeError"][$k];} ?></td>
																				<td id="err_param1_amount" class="message_mendatory"><?php if(isset($err) && isset($unitType["param1AmtError"][$k])){ echo $unitType["param1AmtError"][$k];}	?></td>
																			</tr>
																			<tr>
																				<td>
																					<select id="param2_unit_type" name="param2_unit_type[]">
																					<option value="basic" <?php if($teriffType2[$k] == "basic") echo "selected";?>>Basic</option>
																					<option value="unit" <?php if($teriffType2[$k] == "unit") echo "selected";?>>Unit</option>
																					<option value="minimum" <?php if($teriffType2[$k] == "minimum") echo "selected";?>>Minimum </option>
																					</select>
																				</td>
																				<td>
																					<select name="param2_rate_type[]" id="param2_rate_type" style="width:144px">
																					<option value="0">  Select </option>								
																					<option value="1" <?php if($teriffRateType2[$k] == 1) echo "selected";?>>  Flat </option>								
																					<option value="2" <?php if($teriffRateType2[$k] == 2) echo "selected";?>>  Percentage </option>								
																					</select>
																				</td>
																				<td>
																					<input type="text" name="param2_amount[]" value="<?php echo valid_input($teriffAmt2[$k]);?>" id="param2_amount" style="width:72px;">
																				</td>
																			</tr>
																			<tr>
																				<td class="message_mendatory"><?php if(isset($err) && isset($unitType["param2UnitTypeError"][$k])){ echo $unitType["param2UnitTypeError"][$k];} ?></td>
																				<td id="err_param2_rate_type" class="message_mendatory"><?php if(isset($err) && isset($unitType["param2RateTypeError"][$k])){ echo $unitType["param2RateTypeError"][$k];}	?></td>
																				<td id="err_param2_amount" class="message_mendatory"><?php if(isset($err) && isset($unitType["param2AmtError"][$k])){ echo $unitType["param2AmtError"][$k];}	?></td>
																			</tr>
																			<tr>
																				<td>
																					<select id="param3_unit_type" name="param3_unit_type[]">
																					<option value="basic" <?php if($teriffType1[$k] == "basic") echo "selected";?>>Basic</option>
																					<option value="unit" <?php if($teriffType3[$k] == "unit") echo "selected";?>>Unit</option>
																					<option value="minimum" <?php if($teriffType3[$k] == "minimum") echo "selected";?>>Minimum </option>
																					</select>
																				</td>
																				<td>
																				<select name="param3_rate_type[]" id="param3_rate_type" style="width:144px">
																				<option value="0"> Select </option>								
																				<option value="1" <?php if($teriffRateType3[$k] == 1) echo "selected";?>> Flat </option>
																				<option value="2" <?php if($teriffRateType3[$k] == 2) echo "selected";?>> Percentage </option>
																				</select>
																				</td>
																				<td>
																					<input type="text" name="param3_amount[]" value="<?php echo valid_input($teriffAmt3[$k]);?>" id="param3_amount" style="width:72px">
																				</td>
																				
																			</tr>
																			
																			<tr>
																				<td class="message_mendatory"><?php if(isset($err) && isset($unitType["param3UnitTypeError"][$k])){ echo $unitType["param3UnitTypeError"][$k];} ?></td>
																				<td  class="message_mendatory" id="err_param3_rate_type"><?php if(isset($err) && isset($unitType["param3RateTypeError"][$k])){ echo $unitType["param3RateTypeError"][$k];}	?></td>
																				<td class="message_mendatory" colspan="3" id="err_param3_amount"><?php if(isset($err) && isset($unitType["param3AmtError"][$k])){ echo $unitType["param3AmtError"][$k];}?></td>
																			</tr>
																			<?php } ?>
																		</table>
																	</td>
																</tr>
																
																
																<tr>
																	<td colspan="4" class="grayheader">
																	
																	<div id="addTbl" >
																		<input type="button" class="action_button" value="ADD ROW +" name="Add Item" onclick="addTariffTbl();">
																	</div>
																	</td>
																</tr>
																<tr>
																	<td class="table_hd" colspan="2"><input type="hidden" id="ptoken" value="<?php echo $ptoken; ?>" name="ptoken"></td>
																	<td class="table_hd">
																	
																	<input type="submit" name="submit" value="Save" class="action_button" onclick="JavaScript:return valid_transit();"/></td>
																	
																	<td  class="table_hd"><input type="hidden" name="cnfChanges" id="cnfChanges" />
																	</td>
																</tr>
																
														</table>
													</td>
												</tr>
											</table>	
											</form>
										</div>
									</div>
									
							<?php  /*** End :: Listing Table ***/ ?>
									
								</td>
							</tr>
							<!--<tr>
							<td>
							<?php 
						echo pagination($DataUser,$pagenum,true,$all);?>
							</td>
							</tr>-->
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
<!-- End Middle Content part -->
	<tr>
		<td id="footer"><?php require_once(DIR_WS_ADMIN_INCLUDES . ADMIN_FILE_FOOTER);?></td>
	</tr>
</table>
</body>
</html>

