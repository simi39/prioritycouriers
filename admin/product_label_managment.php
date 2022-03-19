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
require_once(DIR_WS_MODEL . "ProductLabelMaster.php");

require_once(DIR_WS_ADMIN_LANGUAGES . DIR_CURRENT_LANGUAGE. '/product_label.php');
require_once(DIR_WS_MODEL . "SupplierMaster.php");
/**
	        	 * Start :: Object declaration
	        	 */
$ObjProductLabelMaster	= new ProductLabelMaster();
$ObjProductLabelMaster	= $ObjProductLabelMaster->Create();
$ProductLabelData		= new ProductLabelData();

$ObjSupplierMaster	= new SupplierMaster();
$ObjSupplierMaster	= $ObjSupplierMaster->Create();
$SupplierData		= new SupplierData();


$arr_javascript_plugin_include[] = 'datatables/datatables.min.js';

$arr_css_plugin_include[] = 'datatables/datatables.min.css';
$arr_css_plugin_include[] = 'datatables/Buttons-1.6.5/css/buttons.dataTables.min.css';

$fieldArr = array("*");
$DataSupplier=$ObjSupplierMaster->getSupplier($fieldArr);

$supplier_array=array();
foreach($DataSupplier as $DataSupplier)
{
	$supplier_array[$DataSupplier["auto_id"]]=$DataSupplier["supplier_name"];
}


if(!empty($_GET['auto_id']))
{
	$err['auto_id'] = isNumeric(valid_input($_GET['auto_id']),ENTER_NUMERIC_VALUES_ONLY);
}
if(!empty($err['auto_id']))
{
	logOut();
}
if(!empty($_GET['status']))
{
	$err['status'] = isNumeric(valid_input($_GET['status']),ENTER_NUMERIC_VALUES_ONLY);
}
if(!empty($err['status']))
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
if($_GET['Action']=='changestatus' && $_GET['auto_id']!='' )
{		
	$auto_id=trim($_GET['auto_id']);
	$status=trim($_GET['status']);
	$ProductLabelData->auto_id =$auto_id ;
	$ProductLabelData->status = $status;
	$ObjProductLabelMaster->editProductLabel($ProductLabelData,'status');
	if($status==1)
	{
		echo '<img  src="'.DIR_HTTP_ADMIN_IMAGES.'active.png" onclick="change_product_code_status('.$auto_id.',0);">';
	}
	else 
	{
		echo '<img  src="'.DIR_HTTP_ADMIN_IMAGES.'inactive.png" onclick="change_product_code_status('.$auto_id.',1);">';
	}
	exit;
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
$DataProductLabel=$ObjProductLabelMaster->getProductLabel($fieldArr, $seaByArr,null,$from,$to);

	    ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo ADMIN_USER?></title>
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
											<span><a href="<?php echo FILE_DAY_ACTION; ?>"><?php echo ADMIN_HEADER_HOME;?></a>  <?php echo "> ".ADMIN_HEADER_PRODUCT_LABEL_MANAGEMENT; ?></span>
											<div><label class="top_navigation" /><a onclick="mtrash('<?php echo FILE_PRODUCT_LABEL_ACTION;?>','<?php echo ADMIN_USERS_DELETE_CONFIRM; ?>');"><?php echo COMMAN_DELETE; ?></a>
												<label class="top_navigation" /><a href="<?php echo FILE_PRODUCT_LABEL_ACTION; ?>"><?php echo ADMIN_ADD_NEW ; ?></a>
											</div>
										</td>
									</tr>
									<tr>
										<td class="heading">
											<?php echo ADMIN_HEADER_PRODUCT_LABEL_MANAGEMENT; ?>
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
												
													<table width="100%" cellspacing="0" cellpadding="0" class="display" id="maintable">
														<thead>
															<tr>
																<th width="5%" align="center"> <input type="checkbox" name="m_trash_main" id="m_trash_all" /> </th>
																<th width="5%" align="center"><?php echo ADMIN_COMMON_SERIAL_NO; ?></th>
																<th width="5%" align="center"><?php echo ADMIN_PRODUCT_NAME; ?></th>	
																<th width="5%" align="center"><?php echo ADMIN_SUPPLIER_NAME; ?></th>																
																<th width="5%" align="center"><?php echo ADMIN_PRODUCT_CODE; ?></th>																
																<th width="5%" align="center"><?php echo ADMIN_PRODUCT_LABEL_CODE; ?></th>
																<th width="5%" align="center"><?php echo ADMIN_PRODUCT_LABEL_STATUS; ?></th>																	
																<th width="5%" align="center"><?php echo ACTION; ?></th>
															</tr>
														</thead>
														<tbody>
															<?php
															if($DataProductLabel!='') {
																$i = 1;
																$fieldArr = array();
																$fieldArr = array('count(*) as total');

																foreach ($DataProductLabel as $product_details) {

																	$rowClass = 'TableEvenRow';
																	if($rowClass == 'TableEvenRow') {
																		$rowClass = 'TableOddRow';
																	} else {
																		$rowClass = 'TableEvenRow';
																	}

																    ?>
															<tr class="<?php echo $rowClass; ?>">
																<td align="center"> <input type="checkbox" name="m_trash" id="<?php echo $product_details['auto_id'];?>" /></td>
																<td align="center"><?php echo $i = 1 +$from;?></td>
																<td align="center"><?php echo valid_output($product_details["product_name"]); ?></td>
																<td><?php 
																if(array_key_exists($product_details["supplier_id"], $supplier_array))
																{
																	echo $supplier_array[$product_details["supplier_id"]];
																}

																	     ?></td>
																<td><?php echo valid_output($product_details["product_code"]); ?></td>
																<td><?php echo valid_output($product_details["label_code"]); ?></td>
																<td align="center" id="status<?php echo $product_details["auto_id"]; ?>">
																<?php 

																if($product_details["status"]==1)
																{
																				?>
																				<img  src="<?php echo DIR_HTTP_ADMIN_IMAGES; ?>active.png" onclick="change_product_code_status('<?php echo $product_details["auto_id"]; ?>',0);" >
																				<?php

																}
																else
																{
																				?>
																				<img src="<?php echo DIR_HTTP_ADMIN_IMAGES; ?>inactive.png" onclick="change_product_code_status('<?php echo $product_details["auto_id"]; ?>',1);" >
																				<?php

																}
																?>
																</td>																

																<td align="center" nowrap="nowrap">		
																	<a href="<?php echo FILE_PRODUCT_LABEL_ACTION; ?>?Action=edit&amp;auto_id=<?php echo $product_details['auto_id'];?>"><?php echo COMMON_EDIT; ?></a> | <a href="<?php echo FILE_PRODUCT_LABEL_ACTION; ?>?Action=trash&amp;auto_id=<?php echo $product_details['auto_id'].$URLParameters; ?>" onclick="return confirm('<?php echo ADMIN_USERS_DELETE_CONFIRM; ?>')"><?php echo COMMAN_DELETE; ?></a>
																</td>																
															</tr>
															<?php	$from = $from+1;
																}
																   } ?>
														</tbody>
														<tfoot>
															<tr>
																<th><input type="hidden" name="search_srno" value="" class="search_init" /></th>
																<th align="center"><?php echo ADMIN_COMMON_SERIAL_NO; ?>&nbsp;</th>
																<th align="center"><?php echo ADMIN_PRODUCT_NAME; ?>&nbsp;</th>
																<th align="center"><?php echo ADMIN_SUPPLIER_NAME; ?>&nbsp;</th>
																<th align="center"><?php echo ADMIN_PRODUCT_CODE; ?>&nbsp;</th>
																<th align="center"><?php echo ADMIN_PRODUCT_LABEL_CODE; ?>&nbsp;</th>
																<th align="center"><?php echo ADMIN_PRODUCT_LABEL_STATUS; ?>&nbsp;</th>																
																<th align="center"><?php echo ACTION; ?>&nbsp;</th>
															</tr>
														</tfoot>
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

<script type="text/javascript">

function change_product_code_status(id,status)
	{	
		var xmlhttp;
		xmlhttp=ajaxRequest();
		xmlhttp.onreadystatechange=function()
		{
			if (xmlhttp.readyState==4 && xmlhttp.status==200)
			{
				var msg=xmlhttp.responseText;
				$("#status"+id).html(msg);

			}
		}
		xmlhttp.open("POST","?Action=changestatus&auto_id="+id+"&status="+status);
		xmlhttp.send();
	}
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