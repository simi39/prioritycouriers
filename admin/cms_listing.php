<?php


	require_once("../lib/common.php");
	require_once(DIR_WS_MODEL . "CmsPagesMaster.php");
	require_once(DIR_WS_ADMIN_LANGUAGES . DIR_CURRENT_LANGUAGE. '/cms.php');

 	$arr_javascript_plugin_include[] = 'datatables/datatables.min.js';

	$arr_css_plugin_include[] = 'datatables/datatables.min.css';
	$arr_css_plugin_include[] = 'datatables/Buttons-1.7.0/css/buttons.dataTables.min.css';
 	$arr_javascript_exclude[] = "common.js";

	/**
	 * Object Declaration
	 *
	 */
	$objCmsPagesMaster   = new CmsPagesMaster();
	$objCmsPagesMaster   = $objCmsPagesMaster->Create();
	$objCmsPagesData 	 = new CmsPagesData();

	/**
	 * Variable Declaration
	 */

	$message = $arr_message[$_GET['message']];
	if(!empty($message))
	{
		$err['message'] = specialcharaChk(valid_input($message));
	}
	if(!empty($err['message']))
	{
		logOut();
	}
	if(!empty($_GET['page_id']))
	{
		$err['page_id'] = isNumeric(valid_input($_GET['page_id']),ENTER_NUMERIC_VALUES_ONLY);
	}
	if(!empty($err['page_id']))
	{
		logOut();
	}
	if(!empty($_GET['changestatus']))
	{
		$err['changestatus'] = isNumeric(valid_input($_GET['changestatus']),ENTER_NUMERIC_VALUES_ONLY);
	}
	if(!empty($err['changestatus']))
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
	/**
	 * change Status
	 */
	if(isset($_GET['Action']) && $_GET['Action']=='status'){
		$objCmsPagesData->page_id = $_GET['page_id'];
		$objCmsPagesData->status = $_GET['changestatus'];
		$objCmsPagesMaster->editCmsPages($objCmsPagesData, 'status');
		if($_GET['changestatus']==0){
			$message=CMS_INACTIVATED_MESS;
		}else{
			$message=CMS_ACTIVATED_MESS;
		}

	}

	if(!empty($_GET['deleteid']))
	{
		$err['deleteid'] = isNumeric(valid_input($_GET['deleteid']),ENTER_NUMERIC_VALUES_ONLY);
	}
	if(!empty($err['deleteid']))
	{
		logOut();
	}
	/**
	 * Deleting of records
	 */
	 if(isset($_GET['Action']) && $_GET['Action']=='Delete' && !empty($_GET['deleteid'])){
	 	if(isset($_GET['deleteid']) && !empty($_GET['deleteid'])) {
			$objCmsPagesMaster->deleteCmsPages($_GET['deleteid']);
			$rs = $objCmsPagesMaster->deleteCmsPagesDescription($_GET['deleteid']);
			//echo "success";
	    	$message = CMS_DELETE_MESS;
		}
 	}

 	/* Retrive All the Cms Data from cms_pages tabel */
/* 	$SelQuery = "select cp.*, cpd.page_heading from cms_pages as cp left
		join cms_pages_description as cpd on cp.page_id = cpd.page_id GROUP BY cp.page_id";
 	$DataCmsPage = $objCmsPagesMaster->getCmsPages(null,null,null,null,null,$SelQuery);*/





	$fieldArr = array("*");

	$DataCmsPage = $objCmsPagesMaster->getCmsPagesDetails ($optArr,$fieldArr,null,$from,$to,$orderBy);



?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo ADMIN_CMS_MANAGEMENT;?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<?php
addPluginCSSFile($arr_css_plugin_include,$arr_css_plugin_exclude);
addCSSFileAdmin($arr_css_admin_include, $arr_css_admin_exclude);
addJavaScriptFile($arr_javascript_include, $arr_javascript_exclude);
addPluginJavaScriptFile($arr_javascript_plugin_include,$arr_javascript_plugin_exclude);
?>
<script>
$(document).ready(function() {
    $('#maintable').dataTable();
} );
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
										<span><a href="<?php echo FILE_WELCOME_ADMIN; ?>"><?php echo ADMIN_HEADER_HOME; ?></a> > <?php echo ADMIN_HEADER_CONTENT_MANAGEMENT; ?></span>
										<!--<div><label class="top_navigation"><a href="<?php //echo FILE_ADMIN_ADD_EDIT_CMS;?>"><?php //echo ADMIN_CMS_ADD_NEW_CMS; ?></a></label></div>-->
								</td>
							</tr>
							<tr>
								<td class="heading">
									<?php echo ADMIN_HEADER_CONTENT_MANAGEMENT; ?>
								</td>
							</tr>
							<?php if(!empty($message)) {?>
							<tr>
								<td class="message_success" align="center"><?php echo valid_output($message) ; ?></td>
							</tr>
							<?php } ?>
							<tr>
								<td align="center">
									<?php  /*** Start :: Listing Table ***/ ?>
									<div id="container">

										<table border="0" width="100%" class="display" id="maintable" cellpadding="0" cellspacing="0" >
											<thead>
												<tr>
													<th width="10%" align="center"><?php echo ADMIN_COMMON_SERIAL_NO;?></th>
													<th width="25%" align="center"><?php echo ADMIN_CMS_PAGE_HEADING;?></th>
													<th width="25%" align="center"><?php echo ADMIN_CMS_PAGE_NAME;?></th>
													<th width="10%" align="center"><?php echo COMMON_PREVIEW; ?></th>
													<th width="10%" align="center"><?php echo ADMIN_COMMON_STATUS; ?></th>
													<th width="15%" align="center"><?php echo ADMIN_COMMON_ACTION;?></th>
												</tr>
											</thead>
										<?php
										if($DataCmsPage != '' ) {
											$i = 1;
											$rowClass = 'TableEvenRow';
											foreach ($DataCmsPage as $arrid => $cms) {

												$Status = ADMIN_COMMON_STATUS_INACTIVE;
												$ChangeStatus = 1;
												if($cms->status==1){
													$Status = ADMIN_COMMON_STATUS_ACTIVE;
													$ChangeStatus = 0 ;
												}
												if($rowClass == 'TableEvenRow') {
													$rowClass = 'TableOddRow';
												} else {
													$rowClass = 'TableEvenRow';
												}
											?>
												<tr class="<? echo $rowClass?>">
													<td align="center" ><?php echo $i = 1+$from;?></td>
													<td align="left"><?php echo valid_output($cms->page_heading);?></td>
													<td align="left"><?php echo valid_output($cms->page_name);?></td>
													<td align="center"><?php if(valid_output($cms->type) =='M') {?><a href="<?php echo SITE_URL.FILE_CMS."?page=".valid_output($cms->page_name);?>" target="_blank"><?php echo  COMMON_PREVIEW;?></a><?php } else { echo "----";}?></td>
													<td align="center">
														<a href="<?php echo FILE_ADMIN_CMS."?page_id=".$cms->page_id."&Action=status&changestatus=".valid_output($ChangeStatus); ?>" id="status"><?php echo valid_output($Status); ?></a>
													</td>
													<td align="center">
														<a href="<?php echo FILE_ADMIN_ADD_EDIT_CMS."?page_id=".$cms->page_id;?>"><?php echo  COMMON_EDIT;?></a>
														<?php if(valid_output($cms->page_name) != 'index' && $cms->allow_delete == '1') { ?>
														&nbsp;|&nbsp
														<a href="<?php echo FILE_ADMIN_CMS."?deleteid=".$cms->page_id;?>&Action=Delete" id="rowDelete"><?php echo  COMMAN_DELETE;?></a>
														<?php } ?>

													</td>
												</tr>
											<?php
											 $from = $from+1;

											}
										} ?>
											</tbody>
											<tfoot>
												<th><?php echo ADMIN_COMMON_SERIAL_NO;?>&nbsp;</th>
												<th><?php echo ADMIN_CMS_PAGE_HEADING;?>&nbsp;</th>
												<th><?php echo ADMIN_CMS_PAGE_NAME;?>&nbsp;</th>
												<th><?php echo COMMON_PREVIEW; ?>&nbsp;</th>
												<th><?php echo ADMIN_COMMON_STATUS; ?>&nbsp;</th>
												<th><?php echo ADMIN_COMMON_ACTION;?>&nbsp;</th>
											</tfoot>
										</table>

									</div>
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
