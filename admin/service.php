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
require_once(DIR_WS_MODEL . "ServiceMaster.php");
require_once(DIR_WS_ADMIN_LANGUAGES . DIR_CURRENT_LANGUAGE. '/service.php');
require_once(DIR_WS_MODEL . "SupplierMaster.php");

$arr_javascript_plugin_include[] = 'datatables/datatables.min.js';
$arr_javascript_plugin_include[] = 'datatables/RowReorder/JS/dataTables.rowReorder.min.js';

$arr_css_plugin_include[] = 'datatables/datatables.min.css';
$arr_css_plugin_include[] = 'datatables/Buttons-1.7.0/css/buttons.dataTables.min.css';
$arr_css_plugin_include[] = 'datatables/RowReorder/CSS/rowReorder.dataTables.min.css';
//$arr_javascript_exclude[] = "common.js";

/**

	        	 * Start :: Object declaration
	        	 */

$ObjSupplierMaster	= new SupplierMaster();
$ObjSupplierMaster	= $ObjSupplierMaster->Create();
$SupplierData		= new SupplierData();

$ObjServiceMaster	= new ServiceMaster();
$ObjServiceMaster   = $ObjServiceMaster->Create();
$ServiceData		= new ServiceData();

$fieldArr = array("*");
$DataSuppliers=$ObjSupplierMaster->getSupplier($fieldArr);

$supplier_array=array();
foreach($DataSuppliers as $DataSupplier)
{
	$supplier_array[$DataSupplier["auto_id"]]=$DataSupplier["supplier_name"];
}


$fieldArr = array("*");
$seaByArr=array();
//$seaByArr[]=array('Search_On'=>'deleted', 'Search_Value'=>1, 'Type'=>'int', 'Equation'=>'=', 'CondType'=>'', 'Prefix'=>'and', 'Postfix'=>'');

$DataService=$ObjServiceMaster->getService($fieldArr, $seaByArr,null,$from,$to);

$message= $arr_messages[$message];
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
    $('#maintable').DataTable({
			rowReorder: true
		});
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
											<span><a href="<?php echo FILE_DAY_ACTION; ?>"><?php echo ADMIN_HEADER_HOME;?></a>  <?php echo "> ".ADMIN_HEADER_SERVICE_MANAGEMENT; ?></span>
											<div><label class="top_navigation" /><a onclick="mtrash('<?php echo FILE_STE_SERVICE_ACTION;?>','<?php echo ADMIN_USERS_DELETE_CONFIRM; ?>');"><?php echo COMMAN_DELETE; ?></a>
												<label class="top_navigation" /><a href="<?php echo FILE_STE_SERVICE_ACTION; ?>"><?php echo ADMIN_ADD_NEW ; ?></a>
											</div>
										</td>
									</tr>
									<tr>
										<td class="heading">
											<?php echo ADMIN_HEADER_SERVICE_MANAGEMENT; ?>
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
																<th width="5%" align="center"><?php echo ADMIN_SERVICE_SORTING; ?></th>
																<th width="15%" align="center"><?php echo ADMIN_SERVICE_NAME; ?></th>
																<th width="5%" align="center"><?php echo ADMIN_SERVICE_TYPE; ?></th>
																<th width="5%" align="center"><?php echo ADMIN_SUPPLIER_NAME; ?></th>
																<th width="5%" align="center"><?php echo ADMIN_SERVICE_CODE; ?></th>
																<th width="5%" align="center"><?php echo ADMIN_SERVICE_STATUS; ?></th>
																<th width="3%" align="center"><?php echo ADMIN_SERVICE_BOX_COLOR; ?></th>
																<th width="10%" align="center"><?php echo ACTION; ?></th>
															</tr>
														</thead>
														<tbody>
															<?php
															if($DataService!='') {
																$i = 1;
																$fieldArr = array();
																$fieldArr = array('count(*) as total');

																foreach ($DataService as $users_details) {

																	$rowClass = 'TableEvenRow';
																	if($rowClass == 'TableEvenRow') {
																		$rowClass = 'TableOddRow';
																	} else {
																		$rowClass = 'TableEvenRow';
																	}

																    ?>

															<tr class="<?php echo $rowClass; ?>">
																<td align="center"> <input type="checkbox" name="m_trash" id="<?php echo $users_details['auto_id'];?>" /></td>
																<td align="center"><?php echo $i = 1 +$from;?></td>
																<td><?php echo valid_output($users_details['sorting']) ; ?></td>
																<td><?php echo valid_output($users_details['service_name']) ; ?></td>
																<td><?php if($users_details['type']==0)
																{
																	echo ADMIN_SERVICE_TYPE_ROAD;
																}
																else
																{
																	echo ADMIN_SERVICE_TYPE_AIR;
																}
																 ?></td>
																<td><?php
																if(array_key_exists($users_details["supplier_id"], $supplier_array))
																{
																	echo $supplier_array[$users_details["supplier_id"]];
																}
																if(valid_output($users_details['status']))
																{
																	$status ="Active";
																}else{
																	$status ="InActive";
																}
																?></td>
																<td><?php echo valid_output($users_details['service_code']) ; ?></td>
																<td><?php echo valid_output($status) ; ?></td>
																<td align="center"><div style="width:10px;height:10px;background-color: <?php echo valid_output($users_details['box_color']); ?>;"></div></td>
																<td align="center" nowrap="nowrap">
																<?php if($users_details['deleted']==1) {											?>

																	<a href="<?php echo FILE_STE_SERVICE_ACTION; ?>?Action=edit&amp;auto_id=<?php echo $users_details['auto_id'];?>"><?php echo COMMON_EDIT; ?></a> | <a href="<?php echo FILE_STE_SERVICE_ACTION; ?>?Action=trash&amp;auto_id=<?php echo $users_details['auto_id'].$URLParameters; ?>" onclick="return confirm('<?php echo ADMIN_USERS_DELETE_CONFIRM; ?>')"><?php echo COMMAN_DELETE; ?></a>
																<?php } else { ?>
																<a href="<?php echo FILE_STE_SERVICE_ACTION; ?>?Action=readd&amp;auto_id=<?php echo $users_details['auto_id'];?>"><?php echo ADMIN_SERVICE_READD; ?></a> | <a href="<?php echo FILE_STE_SERVICE_ACTION; ?>?Action=pdelete&amp;auto_id=<?php echo $users_details['auto_id'].$URLParameters; ?>" onclick="return confirm('<?php echo ADMIN_USERS_DELETE_PERMINATE_CONFIRM; ?>')"><?php echo ADMIN_SERVICE_PERMINATE_DELETE; ?></a>
																<?php }?>

																	</td>
															</tr>
															<?php	$from = $from+1;
																}
																   }?>
														</tbody>
														<tfoot>
															<tr>
																<th><input type="hidden" name="search_srno" value="" class="search_init" /></th>
																<th align="center"><?php echo ADMIN_COMMON_SERIAL_NO; ?>&nbsp;</th>
																<th align="center"><?php echo ADMIN_SERVICE_SORTING; ?>&nbsp;</th>
																<th align="center"><?php echo ADMIN_SERVICE_NAME; ?>&nbsp;</th>
																<th align="center"><?php echo ADMIN_SERVICE_TYPE; ?>&nbsp;</th>
																<th align="center"><?php echo ADMIN_SUPPLIER_NAME; ?>&nbsp;</th>
																<th align="center"><?php echo ADMIN_SERVICE_CODE; ?>&nbsp;</th>
																<th align="center"><?php echo ADMIN_SERVICE_STATUS; ?>&nbsp;</th>
																<th align="center"><?php echo ADMIN_SERVICE_BOX_COLOR; ?>&nbsp;</th>
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
