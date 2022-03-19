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
		require_once(DIR_WS_MODEL . "CommercialInvoiceItemMaster.php");
		require_once(DIR_WS_ADMIN_LANGUAGES . DIR_CURRENT_LANGUAGE. '/commercial_invoioce_item_detail.php');
		/*require_once(DIR_WS_ADMIN_LANGUAGES . DIR_CURRENT_LANGUAGE. '/user.php');*/	
		
	
	/**
	 * Start :: Object declaration
	 */
	$arr_css_plugin_include[] = 'datatables/css/jquery.dataTables.min.css';	
	$arr_javascript_plugin_include[] = 'datatables/js/jquery.dataTables.min.js';
		/*$ObjOrderMaster	= OrderMaster::Create();*/
	$ObjCommercialInvoiceItemMaster	= new CommercialInvoiceItemMaster();
	$ObjCommercialInvoiceItemMaster	= $ObjCommercialInvoiceItemMaster->Create();

	//declaration for pagination start 
	$fieldArr = array("*");	
 	
	
	$message= $arr_message[$_GET['message']];           
	if(!empty($message))
	{
		$err['message'] = specialcharaChk(valid_input($message));
	}
	if(!empty($err['message']))
	{
		logOut();
	}
	$optArrt[]	=	array('Order_By'   => 'commercial_invoice_id');
	$CommercialInvoiceItem=$ObjCommercialInvoiceItemMaster->getCommercialInvoiceItem($fieldArr, null,$optArrt,$from,$to, true, false);
	
	//declaration for pagination end 
  	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo ADMIN_HEADER_COMMERCIAL_ITEM;?></title>
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
<script src="<?php echo DIR_HTTP_MEDIA."js/jquery.dataTables.min.js"; ?>"></script>

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
						<table border="0" width="100%" cellpadding="0" cellspacing="0"  align="center" class="middle_right_content">
							<tr>
								<td align="left" class="breadcrumb">
								<span><a href="<?php echo FILE_WELCOME_ADMIN; ?>"><?php echo ADMIN_HEADER_HOME;?></a> > <?php echo ADMIN_HEADER_COMMERCIAL_ITEM; ?></span>
								<div><label class="top_navigation"><a onclick="mtrash('<?php echo  FILE_COMMERCIAL_INVOICE_ITEM_DETAILS_ACTION;?>','<?php echo ADMIN_USERS_DELETE_CONFIRM; ?>');"><?php echo COMMAN_DELETE; ?></a>
								<label class="top_navigation"><a href="<?php echo FILE_COMMERCIAL_INVOICE_ITEM_DETAILS_ACTION; ?>"><?php echo ADMIN_ADD_NEW ; ?></a>
								<a href="<?php echo FILE_COMMERCIAL_INVOICE_ITEM_DETAILS_ACTION; ?>?Action=export"><?php echo ADMIN_EXPORT_NEW ; ?></a></label>
							
								</div>

								</td>
							</tr>
							<tr>
								<td class="heading">
								<?php echo ADMIN_HEADER_COMMERCIAL_ITEM; ?>
								</td>
							</tr>
							<?php if(!empty($message)) {?>
							<tr>
								<td class="message_success" align="center"><?php echo valid_output($message) ; ?></td>
							</tr>							
							<?php } ?>
							<!--  End Searching	-->
							<tr>
								<td>
								
							<?php  /*** Start :: Listing Table ***/ ?>
							
									<div id="container">

										<div id="jquery_table"  class="jquery_pagination">
										<table width="100%" cellspacing="0" cellpadding="0" class="display" id="maintable">
											<thead>
												<tr>
												<th width="5%" align="center"> <input type="checkbox" name="m_trash_main" id="m_trash_all" > </th>
													<th width="5%" align="center"><?php echo ADMIN_COMMON_SERIAL_NO; ?></th>
													<th width="5%" align="center"><?php echo COMMERCIAL_INVOICE_ID; ?></th>
													<th width="5%" align="center"><?php echo COMMERCIAL_ITEM_ID; ?></th>
													<th width="15%" align="center"><?php echo COMMERCIAL_DESCRIPTION; ?></th>
													<th width="20%" align="center"><?php echo COMMERCIAL_QNT; ?></th>		
													<th width="10%" align="center" ><?php echo COMMERCIAL_CURRENCY; ?></th>	
													<th width="20%" align="center"><?php echo COMMERCIAL_UNIT_VALUE; ?></th>		
													<th width="10%" align="center" ><?php echo COMMERCIAL_VALUE; ?></th>		
													<th width="5%" align="center"><?php echo ACTION; ?></th>
													
																
												</tr>
											</thead>
											<tbody>
												<?php
												 	if($CommercialInvoiceItem!='') { 
												 		$i = 1;	
														$fieldArr = array();
														$fieldArr = array('count(*) as total');						
		
														foreach ($CommercialInvoiceItem as $commercial_invoice_item) {
															
															$rowClass = 'TableEvenRow';
															if($rowClass == 'TableEvenRow') {
																$rowClass = 'TableOddRow';
															} else {
																$rowClass = 'TableEvenRow';
															}
															
												?>
												<tr class="<?php echo $rowClass; ?>">
													<td align="center"> <input type="checkbox" name="m_trash" id="<?php echo $commercial_invoice_item['id'];?>"></td>
													<td align="center"><?php echo $i = 1 +$from;?></td>
													<td><?php echo $commercial_invoice_item['commercial_invoice_id'] ; ?></td>
													<td><?php echo $commercial_invoice_item['commercial_item_id'] ; ?></td>
													<td><?php echo valid_output($commercial_invoice_item['commercial_description']); ?></td>
													<td><?php echo $commercial_invoice_item['commercial_qty'];?></td>
													<td><?php  echo valid_output($commercial_invoice_item['commercial_currency']);?></td>
													<td><?php echo valid_output($commercial_invoice_item['commercial_unit_value']);?></td>
													<td><?php echo $commercial_invoice_item['commercial_value'];?></td>
													
													
													<td align="center" nowrap="nowrap">
														<a href="<?php echo FILE_COMMERCIAL_INVOICE_ITEM_DETAILS_ACTION; ?>?pagenum=<?php echo $pagenum;?>&Action=edit&amp;id=<?php echo $commercial_invoice_item['id'];?>"><?php echo COMMON_EDIT; ?></a> | <a href="<?php echo FILE_COMMERCIAL_INVOICE_ITEM_DETAILS_ACTION; ?>?pagenum=<?php echo $pagenum;?>&Action=trash&amp;id=<?php echo $commercial_invoice_item['id']; ?>&amp;commercial_item_id=<?php echo $commercial_invoice_item['commercial_item_id'].$URLParameters; ?>" onclick="return confirm('<?php echo ADMIN_USERS_DELETE_CONFIRM; ?>')"><?php echo COMMAN_DELETE; ?></a>
													</td>
													
												</tr>
												<?php	$from = $from+1;
												}
											 }?>
											</tbody>
											<tfoot>
												<tr>
													<th>&nbsp;</th>					
													<th align="center"><?php echo ADMIN_COMMON_SERIAL_NO; ?>&nbsp;</th>
													<th align="center"><?php echo COMMERCIAL_INVOICE_ID; ?>&nbsp;</th>
													<th align="center"><?php echo COMMERCIAL_ITEM_ID; ?>&nbsp;</th>
													<th align="center"><?php echo COMMERCIAL_DESCRIPTION; ?>&nbsp;</th>
													<th align="center"><?php echo COMMERCIAL_QNT; ?>&nbsp;</th>
													<th align="center"><?php echo COMMERCIAL_CURRENCY; ?>&nbsp;</th>
													<th align="center"><?php echo COMMERCIAL_UNIT_VALUE; ?>&nbsp;</th>
													<th align="center"><?php echo COMMERCIAL_VALUE; ?>&nbsp;</th>
													<th align="center"><?php echo ACTION; ?>&nbsp;</th>
													
													
						
												</tr>
											</tfoot>
											
										</table>
										
										</div>
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
