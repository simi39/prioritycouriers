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
		require_once(DIR_WS_MODEL . "CommercialInvoiceMaster.php");
		require_once(DIR_WS_ADMIN_LANGUAGES . DIR_CURRENT_LANGUAGE. '/commercial_invoice.php');
	
	/**
	 * Start :: Object declaration
	 */
	/*$arr_css_plugin_include[] = 'datatables/css/jquery.dataTables.min.css';	
	$arr_javascript_plugin_include[] = 'datatables/js/jquery.dataTables.min.js';*/
	$arr_javascript_plugin_include[] = 'datatables/datatables.min.js';

	$arr_css_plugin_include[] = 'datatables/datatables.min.css';
	$arr_css_plugin_include[] = 'datatables/Buttons-1.6.5/css/buttons.dataTables.min.css';
		/*$ObjOrderMaster	= OrderMaster::Create();*/
	$ObjKmGridMaster	= new CommercialInoviceMaster();
	$ObjKmGridMaster	= $ObjKmGridMaster->Create();
	$CommercialInvoiceData		= new CommercialInvoiceData();
	
	$seaArray[] = array('Search_On'=>'booking_id', 'Search_Value'=>'null', 'Type'=>'string', 'Equation'=>'!=', 'CondType'=>'AND', 'Prefix'=>'', 'Postfix'=>'');	
	
	$message= $arr_messages[$_GET['message']];
	if(!empty($message))
	{
		$err['message'] = specialcharaChk(valid_input($message));
	}
	if(!empty($err['message']))
	{
		logOut();
	}	
	$fieldArr = array("*");	
	$DataUser=$ObjKmGridMaster->getCommercialInovice($fieldArr, $seaArray,null,$from,$to, true);
  	//echo DIR_HTTP_MEDIA;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo ADMIN_HEADER_COMMERCIAL; ?></title>
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
<!--<link rel="stylesheet" type="text/css" href="<?php echo DIR_HTTP_MEDIA."css/jquery.dataTables.min.css"; ?>"> -->

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
								<span><a href="<?php echo FILE_WELCOME_ADMIN; ?>"><?php echo ADMIN_HEADER_HOME;?></a> > <?php echo ADMIN_HEADER_COMMERCIAL; ?></span>
								<div><label class="top_navigation"><a onclick="mtrash('<?php echo  FILE_COMMERCIAL_INVOICE_ACTION;?>','<?php echo ADMIN_USERS_DELETE_CONFIRM; ?>');"><?php echo COMMAN_DELETE; ?></a>
								<label class="top_navigation"><a href="<?php echo FILE_COMMERCIAL_INVOICE_ACTION; ?>"><?php echo ADMIN_ADD_NEW ; ?></a>
								<a href="<?php echo FILE_COMMERCIAL_INVOICE_ACTION; ?>?Action=export_kmgrid_csv"><?php echo ADMIN_EXPORT_NEW ; ?></a></label>
							
								</div>

								</td>
							</tr>
							<tr>
								<td class="heading">
								<?php echo ADMIN_HEADER_COMMERCIAL; ?>
								</td>
							</tr>
							<?php if(!empty($message)) {?>
							<tr>
								<td class="message_success" align="center"><?php echo valid_output($message); ?></td>
							</tr>							
							<?php } ?>
							<!--  End Searching	-->
							<tr>
								<td>
								
							<?php  /*** Start :: Listing Table ***/ ?>
							
									<div id="container">

										
										<table width="100%" cellspacing="0" cellpadding="0" class="display" id="maintable">
											<thead>
												<tr>
												<th width="5%" align="center"> <input type="checkbox" name="m_trash_main" id="m_trash_all" > </th>
													<th width="5%" align="center"><?php echo ADMIN_COMMON_SERIAL_NO; ?></th>
													<th width="15%" align="center"><?php echo COMMERCIAL_INVOICE_ID; ?></th>
													<th width="15%" align="center"><?php echo PICKUP_FROM; ?></th>
													<th width="20%" align="center"><?php echo DILIVER_TO; ?></th>		
													<th width="10%" align="center" ><?php echo DISTANCEINKM; ?></th>		
													<th width="5%" align="center"><?php echo ACTION; ?></th>
													
																
												</tr>
											</thead>
											<tbody>
												<?php
												 	if($DataUser!='') { 
												 		$i = 1;	
														$fieldArr = array();
														$fieldArr = array('count(*) as total');						
		
														foreach ($DataUser as $users_details) {
															
															$rowClass = 'TableEvenRow';
															if($rowClass == 'TableEvenRow') {
																$rowClass = 'TableOddRow';
															} else {
																$rowClass = 'TableEvenRow';
															}
															
												?>
												<tr class="<?php echo $rowClass; ?>">
												<td align="center"> <input type="checkbox" name="m_trash" id="<?php echo $users_details['commercial_invoice_id'];?>"></td>
													<td align="center"><?php echo $i = 1 +$from;?></td>
													<td><?php echo valid_output($users_details['commercial_invoice_id']); ?></td>
													<td><?php echo valid_output($users_details['consignor_name']); ?></td>
													<td><?php echo valid_output($users_details['consignee_name']);?></td>
													<td><?php echo generatebookigid("",$users_details['booking_id']);?></td>
													
													
													<td align="center" nowrap="nowrap">
														<a href="<?php echo FILE_COMMERCIAL_INVOICE_ACTION; ?>?pagenum=<?php echo  $pagenum;?>&Action=edit&amp;commercial_invoice_id=<?php echo $users_details['commercial_invoice_id'];?>"><?php echo COMMON_EDIT; ?></a> | <a href="<?php echo FILE_COMMERCIAL_INVOICE_ACTION; ?>?pagenum=<?php echo  $pagenum;?>&Action=trash&amp;commercial_invoice_id=<?php echo $users_details['commercial_invoice_id'].$URLParameters; ?>" onclick="return confirm('<?php echo ADMIN_USERS_DELETE_CONFIRM; ?>')"><?php echo COMMAN_DELETE; ?></a>
														
																											
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
													<th align="center"><?php echo PICKUP_FROM; ?>&nbsp;</th>
													<th align="center"><?php echo DILIVER_TO; ?>&nbsp;</th>
													<th align="center"><?php echo DISTANCEINKM; ?>&nbsp;</th>
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

