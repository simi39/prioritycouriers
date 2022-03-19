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
$TransitData		= new TransitPriceData();

$ObjSupplierMaster	= new SupplierMaster();
$ObjSupplierMaster	= $ObjSupplierMaster->Create();
$SupplierData		= new SupplierData();

$ObjTranPriceDetailMaster 	= new TransitPriceDetailMaster;
$ObjTranPriceDetailMaster 	= $ObjTranPriceDetailMaster->create();
$TranPriceDetailData			= new TransitPriceDetailData();

$arr_javascript_plugin_include[] = 'datatables/datatables.min.js';

$arr_css_plugin_include[] = 'datatables/datatables.min.css';
$arr_css_plugin_include[] = 'datatables/Buttons-1.6.5/css/buttons.dataTables.min.css';
//$URLParameters = "?transit_id=".$_GET["transit_id"];
$URLParameters = '';
$stateCodeArr = array("ADE"=>"ADE-Adelaide",
																  "BRI"=>"BRI-Brisbane",
																  "CAN"=>"CAN-Canberra",
																  "MEL"=>"MEL-Melbourne",
																  "PER"=>"PER-Perth",
																  "SYD"=>"SYD-Sydney",
																  "DRW"=>"DRW-Darwin",
																  "HOB"=>"HOB-Hobart",
																  "LCN"=>"LCN-Launceston"
															);
$transMetArr = array(1=>"Flat Fee", 2=>"Percentage");
	$fldArr 	= array("*");
	$optArr[] = array('Order_By'=>'tariff_type');
	$DataTransitList = $ObjTranPriceMaster->getTransitPrice($fldArr,null,$optArr);
	
	$status = array("0"=>"Active","1"=>"In-active");

	/*if(!empty($DataTransitList)){
		$DataTransitList = $DataTransitList[0];
		
	}*/
if(!empty($_GET['action']))
{
	$err['action'] = chkStr(valid_input($_GET['action']));
}
if(!empty($err['action']))
{
	logOut();
}
if(!empty($_GET['transitId']))
{
	$err['transitId'] = isNumeric(valid_input($_GET['transitId']),ENTER_NUMERIC_VALUES_ONLY);
}
if(!empty($err['transitId']))
{
	logOut();
}
if(isset($_GET['action']) || $_GET['action'] == 'delete'){
	$ObjTranPriceMaster->deleteTransitPrice($_GET['transitId']);
	header('Location:'.FILE_TRANSIT_LIST);
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
<title><?php echo ADMIN_USER?></title>
<script type="text/javascript" src="http://code.jquery.com/jquery-1.7.min.js"></script>
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
								<span><a href="<?php echo FILE_WELCOME_ADMIN; ?>"><?php echo ADMIN_HEADER_HOME;?></a> > <?php echo ADMIN_HEADER_TRANSIT_LIST; ?></span>
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
							<?php if(!empty($message)) {?>
							<tr>
								<td class="message_success" align="center"><?php echo valid_output($message); ?></td>
							</tr>							
							<?php } ?>
							<!--  End Searching	-->
							<tr>
								<td align="left">
								
							<?php  /*** Start :: Listing Table ***/ ?>
							
									<div id="container">

										<div id="jquery_table"  class="jquery_pagination" style="padding:12px !important">
											<table border="0" width="450px" cellpadding="2" cellspacing="0"  align="left"  style="border-solid:1px;">
												
												<tr>
													<td class="table_hd" colspan="8">
														<table border="1">
																								
												<tr>
													<td class="table_hd"><b>No.</b></td>
													<td class="table_hd"><b>Tariff Type</b></td>
													<td class="table_hd"><b>Goods Nature</b></td>
													<td class="table_hd" colspan="2"><b>Action</b></td>
													<td class="table_hd"><b>Status</b></td>
												</tr>
												<?php 
												$srN0 = 1;
												 if(!empty($DataTransitList))
												{												 
												 foreach($DataTransitList as $recordTrasit){
												 	  $unserializeRecord = json_decode($recordTrasit["status"],true);
													  
													  $fieldArr=array("*");
													  $seaByArr=array();
													  $seaByArr[]=array('Search_On'=>'auto_id', 'Search_Value'=>$recordTrasit['tariff_type'], 'Type'=>'int', 'Equation'=>'=', 'CondType'=>'', 'Prefix'=>'and', 'Postfix'=>'');
														
													  $DataSupplier=$ObjSupplierMaster->getSupplier($fieldArr,$seaByArr); // Fetch Data
													  $DataSupplier = $DataSupplier[0];
													  
												 	?>
												 	<tr>
												 	<td class="table_td"><?php echo $srN0;?></td>
												 	<td class="table_td"><?php echo ucfirst(valid_output($DataSupplier['supplier_name'])); ?></td>
												 	<td class="table_td"><?php echo ucfirst(valid_output($recordTrasit['tariff_goods_nature'])); ?></td>
												 	
												 	<td class="table_td"><a href="<?php echo FILE_ADD_TRANSIT ;?>?action=edit&transitId=<?php echo $recordTrasit["transit_id"]; ?>">Edit</a></td>
												 	<td class="table_td"><a href="<?php echo FILE_TRANSIT_LIST ;?>?action=delete&transitId=<?php echo $recordTrasit["transit_id"]; ?>">Delete</a></td>
												 	<td align="center"><?php 
												 	if($recordTrasit['active'] == 0){ $status_active = "Inactive";}else{$status_active = "Active"; }
												 	echo valid_output($status_active);
												 	 ?></td>	
												 	</tr>
												 	<?php
												 	$srN0++;
													}
												 }
												?>
											</table>	
										
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
<?php 
// Column Configuration
//$columnSetting = 'null, null, null,  { "bSortable": false }';
//require_once(DIR_WS_JSCRIPT."/jquery.php");
?>
