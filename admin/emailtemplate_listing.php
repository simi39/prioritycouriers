<?php
	/**
	 * This file is for display all administrator
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
	 require_once(DIR_WS_MODEL . "EmailTemplateManagerMaster.php");
	 require_once(DIR_WS_ADMIN_LANGUAGES . DIR_CURRENT_LANGUAGE. '/emailtemplate.php');
	/**
	 * Inclusion and Exclusion Array of Javascript
	 */
	 $arr_javascript_plugin_include[] = 'datatables/datatables.min.js';

	$arr_css_plugin_include[] = 'datatables/datatables.min.css';
	$arr_css_plugin_include[] = 'datatables/Buttons-1.6.5/css/buttons.dataTables.min.css';
		
	 $arr_javascript_exclude[] = "common.js";

	 $objEmailTemplateManagerMaster = new EmailTemplateManagerMaster();
	 $objEmailTemplateManagerMaster = $objEmailTemplateManagerMaster->Create();
	 $Action = null;
	 
	 
	$message = $arr_message[$_GET['message']];            
	if(!empty($message))
	{
		$err['message'] = specialcharaChk(valid_input($message));
	}
	if(!empty($err['message']))
	{
		logOut();
	}
	
	if(!empty($_GET['Action'])) {
		$Action=$_GET['Action'];
	}
	if(!empty($Action))
	{
		$err['Action'] = chkStr(valid_input($_GET['Action']));
	}
	if(!empty($err['Action']))
	{
		logOut();
	}
	if(!empty($_GET['template_id']))
	{
		$err['template_id'] = isNumeric(valid_input($_GET['template_id']),ENTER_NUMERIC_VALUES_ONLY);
	}
	if(!empty($err['template_id']))
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
    //change status
   	if(isset($_GET['template_id'])&& !empty($_GET['template_id'])&& isset($_GET['changestatus'])) {

		$templateIdArray = array($_GET['template_id']);
		$objEmailTemplateManagerMaster->ToggleState($templateIdArray,$_GET['changestatus']);
		if($_GET['changestatus']==0){
			$message=EMAIL_INACTIVATED_MESS;
		}else{
			$message=EMAIL_ACTIVATED_MESS;
		}
		exit;
	}

	/**
	 * Delete Email Content
	 */
	if(!empty($_GET['deleteid']))
	{
		$err['deleteid'] = isNumeric(valid_input($_GET['deleteid']),ENTER_NUMERIC_VALUES_ONLY);
	}
	if(!empty($err['deleteid']))
	{
		logOut();
	}
	if(isset($_GET['Action']) && $_GET['Action']=='Delete' && !empty($_GET['deleteid']))
	{
		if(isset($_GET['deleteid']))
		{
			$objEmailTemplateManagerMaster->deleteEmailTemplate($_GET['deleteid']);
			$objEmailTemplateManagerMaster->deleteEmailTemplateDesc($_GET['deleteid']);
			$Action='Delete';
			$message = CMS_DELETE_MESS;
			exit;
		}
	}
		
	/**
	 * Get the Email Contents
	 * 
	 */
	$orderBy = array("email_template_manager.template_id DESC");
	$emailDocumentData = $objEmailTemplateManagerMaster->getEmailTemplateDetails(null, SITE_LANGUAGE_ID, null, $orderBy);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo ADMIN_EMAIL_MANAGEMENT; ?></title>
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
						 <table class="middle_right_content" align="center" border="0" cellpadding="0" cellspacing="0"> 
							<tr>																		
								<td align="left" class="breadcrumb">
									<span><a href="<?php echo FILE_WELCOME_ADMIN; ?>"><?php echo ADMIN_HEADER_HOME;?></a> > <?php echo ADMIN_HEADER_EMAIL_TEMPLATE; ?></span>							
						        </td>										
							</tr>
							<tr>	
								<td class="heading">
									<?php echo ADMIN_HEADER_EMAIL_TEMPLATE; ?>
								</td>
							</tr>
							<?php if(!empty($message)) {?>
							<tr>
								<td class="message_success" align="center"><?php echo valid_output($message); ?></td>
							</tr>							
							<?php } ?>								
							<tr>
								<td>
								
							<?php  /*** Start :: Listing Table ***/ ?>
								
								
									<div id="container">
										
											<table cellpadding="5px" cellspacing="0" border="0" width="100%" class="display" id="maintable">
												<thead>
													<tr>
														<th width="10%" align="center" ><?php echo ADMIN_COMMON_SERIAL_NO;?></th>
														<th width="15%" align="center" ><?php echo ADMIN_EMAIL_DOCUMENT_TITLE;?></th>
														<th width="27%" align="center" ><?php echo ADMIN_EMAIL_DOCUMENT_SUBJECT;?></th>
														<th width="12%" align="center" ><?php echo ADMIN_EMAIL_DOCUMENT_FROM_ADDRESS;?></th>
														<th width="12%" align="center" ><?php echo ADMIN_COMMON_STATUS;?></th>
														<th width="10%" align="center" ><?php echo ADMIN_EMAIL_DOCUMENT_ACTION;?></th>
														
													</tr>
												</thead>
												<tbody>
											<?php	
												//////////// getting particular id record ///////////////////////////////////
												if($emailDocumentData!='') { 
												?>
												
												<?php	$i = 1;	
													$rowClass = 'TableEvenRow';
													foreach ($emailDocumentData as $currentcontent) { 
														
														if($rowClass == 'TableEvenRow') {
															$rowClass = 'TableOddRow';
														} else {
															$rowClass = 'TableEvenRow';
														}
												?>
													<tr class="<?php echo $rowClass; ?>">
														<td align="center"><?php echo $i; ?></td>														
														<td align="left"><?php echo valid_output($currentcontent->template_title);?></td>
														
														<td align="left"><?php echo valid_output($currentcontent->template_subject);?></td>
														<td align="left"><?php echo htmlspecialchars($currentcontent->template_from_address);?></td>
														<?php if($currentcontent->isactive=='0'){
															$status= ADMIN_COMMON_STATUS_INACTIVE;
															$changeStaus='1';
														}else{
															$status=ADMIN_COMMON_STATUS_ACTIVE;
															$changeStaus='0';
														}?>
														<td align="center"><a href="<?php echo FILE_ADMIN_EMAIL_TEMPLATE_MANAGER."?template_id=".$currentcontent->template_id."&changestatus=".$changeStaus;?>" id="status" ><?php echo $status;?></a></td>
														<td align="center">
														<a href="<?php echo FILE_ADMIN_ADDEDIT_EMAIL_TEMPLATE."?template_id=".$currentcontent->template_id; ?>"><?php echo COMMON_EDIT;?></a>
														&nbsp;
													
														</td>
													</tr>
												
												<?php
													$i++;
													}
												} ?>
												</tbody>
												<tfoot>
													<tr>
														<th align="left"><?php echo ADMIN_COMMON_SERIAL_NO;?>&nbsp;</th>
														<th align="left"><?php echo ADMIN_EMAIL_DOCUMENT_TITLE;?>&nbsp;</th>
														<th align="left"><?php echo ADMIN_EMAIL_DOCUMENT_SUBJECT;?>&nbsp;</th>
														<th><?php echo ADMIN_EMAIL_DOCUMENT_FROM_ADDRESS;?>&nbsp;</th>
														<th><?php echo ADMIN_COMMON_STATUS;?>&nbsp;</th>
														<th><?php echo ADMIN_EMAIL_DOCUMENT_ACTION;?></th>
													</tr>
												</tfoot>
											</table>
										
									</div>
									
									
							<?php  /*** End :: Listing Table ***/ ?>
							
								</td>
							</tr>
						</table>
					</td>
				<tr>
			</table>
		</td>
	</tr>
<!-- End Middle Content part -->
	<tr><td id="footer"><?php require_once(DIR_WS_ADMIN_INCLUDES . ADMIN_FILE_FOOTER);?></td></tr>
</table>
</body>
</html>
