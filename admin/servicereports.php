<?php
require_once("../lib/common.php");
require_once(DIR_WS_MODEL . "ServiceMaster.php");
require_once(DIR_WS_ADMIN_LANGUAGES . DIR_CURRENT_LANGUAGE. '/servicereport.php');
require_once(DIR_WS_MODEL . "SupplierMaster.php");
require_once(DIR_WS_MODEL . "ProductLabelMaster.php");
	
	
$arr_css_respons_include[] = DIR_HTTP_CSS.'addressBookListing-compact.css';
/*
Commented by Smita 4 Feb 2021
$arr_css_plugin_include[] = 'datatables/css/jquery.dataTables.min.css';
$arr_css_plugin_include[] = 'datatables/extensions/Bootstrap-Integration/css/dataTables.bootstrap.css';
$arr_css_plugin_include[] = 'datatables/extensions/Responsive/css/dataTables.responsive.css';
$arr_css_plugin_include[] = 'datatables/extensions/TableTools/css/dataTables.tableTools.min.css';
$arr_javascript_plugin_include[] = 'datatables/js/jquery.dataTables.min.js';

$arr_javascript_plugin_include[] = 'datatables/extensions/Bootstrap-Integration/js/dataTables.bootstrap.js';
$arr_javascript_plugin_include[] = 'datatables/extensions/Responsive/js/dataTables.responsive.min.js';
$arr_javascript_plugin_include[] = 'datatables/extensions/TableTools/js/dataTables.tableTools.min.js';*/
$arr_javascript_plugin_include[] = 'datatables/datatables.min.js';

$arr_css_plugin_include[] = 'datatables/datatables.min.css';
$arr_css_plugin_include[] = 'datatables/Buttons-1.6.5/css/buttons.dataTables.min.css';

/**

	        	 * Start :: Object declaration
	        	 */

$ObjSupplierMaster	= new SupplierMaster();
$ObjSupplierMaster	= $ObjSupplierMaster->Create();
$SupplierData		= new SupplierData();

$ObjServiceMaster	= new ServiceMaster();
$ObjServiceMaster   = $ObjServiceMaster->Create();
$ServiceData		= new ServiceData();

$ObjProductLabelMaster	= new ProductLabelMaster();
$ObjProductLabelMaster	= $ObjProductLabelMaster->Create();
$ProductLabelData		= new ProductLabelData();

$fieldArr = array("*");
$DataSuppliers=$ObjSupplierMaster->getSupplier($fieldArr);

$supplier_array=array();
foreach($DataSuppliers as $DataSupplier)
{
	$supplier_array[$DataSupplier["auto_id"]]=$DataSupplier["supplier_name"];
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

$fieldArr = array("*");
$seaByArr=array();
//$seaByArr[]=array('Search_On'=>'deleted', 'Search_Value'=>1, 'Type'=>'int', 'Equation'=>'=', 'CondType'=>'', 'Prefix'=>'and', 'Postfix'=>'');
$DataService=$ObjServiceMaster->getService($fieldArr, $seaByArr,null,$from,$to);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo ADMIN_SERVICE_TITLE; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<?php 
addPluginCSSFile($arr_css_plugin_include,$arr_css_plugin_exclude);
addCSSFileAdmin($arr_css_admin_include, $arr_css_admin_exclude);
addJavaScriptFile($arr_javascript_include, $arr_javascript_exclude);
addPluginJavaScriptFile($arr_javascript_plugin_include,$arr_javascript_plugin_exclude);
?>
<script>
$(document).ready(function() {
    $('#example').DataTable( { 
        responsive: true,
		dom: 'T<"clear">lfr<"toolbar-DT">tip',
        tableTools: {
			"sSwfPath": "assets/plugins/datatables/extensions/TableTools/swf/copy_csv_xls_pdf.swf",
			"sRowSelect": "os",
            "aButtons": [
                "copy",
                "csv",
                "xls",
                {
                    "sExtends": "pdf",
                    "sPdfOrientation": "landscape",
                    "sPdfMessage": "Your custom message would go here."
                },
                "print"
            ]
        },
    } );
	
} );
</script> 
</head>
<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0" id="main" align="center">
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
<table border="0" width="100%" cellpadding="0" cellspacing="0" align="center" class="middle_right_content">
<tr>
<td align="left" class="breadcrumb">
	<span><a href="<?php echo FILE_DAY_ACTION; ?>"><?php echo ADMIN_HEADER_HOME;?></a>  <?php echo "> ".ADMIN_SERVICE_REPORT_MANAGEMENT; ?></span>
	<div><label class="top_navigation" /><a onclick="mtrash('<?php echo FILE_STE_SERVICE_ACTION;?>','<?php echo ADMIN_USERS_DELETE_CONFIRM; ?>');"><?php echo COMMAN_DELETE; ?></a>
		<label class="top_navigation" /><a href="<?php echo FILE_STE_SERVICE_ACTION; ?>"><?php echo ADMIN_ADD_NEW ; ?></a>
	</div>
</td>
</tr>
<tr>
<td class="heading">
	<?php echo ADMIN_SERVICE_REPORT_MANAGEMENT; ?>
</td>
</tr>
<?php if(!empty($message)) {?>
<tr>
<td class="message_success" align="center"><?php echo valid_output($message);  ?></td>
</tr>
<?php } ?>
<tr>
<td class="heading">

</td>
</tr>
<!--  End Searching	-->
<tr>
<td>
	<?php  /*** Start :: Listing Table ***/ ?>
	<div id="container">
	<table class="table table-striped table-hover dt-responsive" cellspacing="0" width="100%" id="example">
<thead>
<th class="controlpanel_middle_th"></th>
<th class="controlpanel_middle_th"><?php echo ADMIN_SERVICE_NAME;?></th>
<th class="controlpanel_middle_th none"><?php echo ADMIN_SERVICE_TYPE;?></th>
<th class="controlpanel_middle_th"><?php echo ADMIN_SUPPLIER_NAME;?></th>
<th class="controlpanel_middle_th"><?php echo ADMIN_SERVICE_CODE;?></th>
<th class="controlpanel_middle_th"><?php echo ADMIN_PRODUCT_CODE;?></th>
<th class="controlpanel_middle_th"><?php echo ADMIN_SERVICE_STATUS;?></th>
</thead>
<tbody>
<?php

if($DataService!='') {
$i = 1;
$fieldArr = array();
$fieldArr = array('count(*) as total');

foreach ($DataService as $service_details) {

	
?>
<?php 

if(valid_output($service_details['status']))
{
	$status ="Active";
}else{
	$status ="InActive";
}
?>
<tr class="<?php if($i%2==0){echo "graybanner";}else {echo "lightgraybanner";} ?>">
<td></td>
<td class="controlpanel_middle_td"><?php 
echo ucwords(valid_output($service_details->service_name)) ; ?></td>

<td class="controlpanel_middle_td">
<?php if($service_details['type']==0){ echo ADMIN_SERVICE_TYPE_ROAD;}else
{ echo ADMIN_SERVICE_TYPE_AIR;} ?></td>
<td class="controlpanel_middle_td"><?php if(array_key_exists($service_details["supplier_id"], $supplier_array))
{
	echo $supplier_array[$service_details["supplier_id"]];
}?></td>
<td class="controlpanel_middle_td"><?php echo valid_output($service_details['service_code']) ; ?></td>
<td class="controlpanel_middle_td"><?php echo valid_output($service_details['service_code']) ; ?></td>
<td class="controlpanel_middle_td"><?php echo valid_output($status) ; ?></td>
	
</tr>
<?php
$i++;
$no++;
}
}
?>
</tbody>
</table>	
			
		
	</div>
	<?php  /*** End :: Listing Table ***/ ?>
</td>
</tr>

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