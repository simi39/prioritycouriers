<?php
	/**
	 * This is newsletters file
	 * 
	 * @author     Radixweb <team.radixweb@gmail.com>
	 * @copyright  Copyright (c) 2008, Radixweb
	 * @version    1.0
	 * @since      1.0
	 */
	
	/**
	 * include common
	 */
	require_once("../lib/common.php");
	require_once(DIR_WS_MODEL . "EmailTemplateManagerMaster.php");
	require_once(DIR_WS_ADMIN_LANGUAGES . DIR_CURRENT_LANGUAGE. '/emailtemplate.php');
	
	 $pagenum = ($_POST['pagenum']!="")?($_POST['pagenum']):(1);
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
	$arr_javascript_include[] = 'tabbed_panels.js';
	$arr_javascript_include[] = 'emailtemplate_action.php';

	$arr_css_include[] = DIR_HTTP_ADMIN_CSS.'tabbed_panels.css';
	$arr_css_exclude[] = DIR_HTTP_ADMIN_CSS.'jquery.css';
	 /* Object Declaration section */
    $objEmailTemplateManagerMaster = new EmailTemplateManagerMaster();
    $objEmailTemplateManagerMaster = $objEmailTemplateManagerMaster->Create();
    $objEmailTemplateManagerData   = new EmailTemplateManagerData();
 
    $buttonValue     = ADMIN_EMAIL_SAVE_BUTTON;
	$HeadingLabel   = ADMIN_EMAILTEMPLATE_HEADER_ADD;

    $templateData = null;
    
	/*csrf validation*/
	$csrf = new csrf();
	$csrf->action = "emailtemplate_action";
	if(!isset($_POST['ptoken'])) {
		$ptoken = $csrf->csrfkey();
	}
	/*csrf validation*/

	if(!empty($_GET['template_id']))
	{
		$err['template_id'] = isNumeric(valid_input($_GET['template_id']),ENTER_NUMERIC_VALUES_ONLY);
	}
	if(!empty($err['template_id']))
	{
		logOut();
	}
    /* Getting Document info by id */
    if(isset($_GET['template_id']) && $_GET['template_id'] != '')
    {
    	
    	$templateSearchArr[] = array(
    						  'Search_On'    => 'template_id',
		                      'Search_Value' => $_GET['template_id'],
		                      'Type'         => 'int',
		                      'Equation'     => '=',
		                      'CondType'     => 'AND',
		                      'Prefix'       => '',
		                      'Postfix'      => '');
    	$templateDataTmp = $objEmailTemplateManagerMaster->getEmailTemplate(null,$templateSearchArr);
    	$templateData 	 = $templateDataTmp[0];
    	$buttonValue     = ADMIN_EMAIL_UPDATE_BUTTON;
		$HeadingLabel   = ADMIN_EMAILTEMPLATE_HEADER_EDIT;
    }
     
    
    /* Add/Edit email template information */
    if(isset($_POST['Submit']) && $_POST['Submit'] != "")
    {
    	if(isEmpty(valid_input($_POST['ptoken']), true)){	
			logOut();
		}else{
			//$csrf->checkcsrf($_POST['ptoken']);
		}
    	// Server Side Validation
    	$err['TitleError'] 	 = isEmpty(trim($_POST['template_title']), ADMIN_COMMON_EMAIL_IS_REQUIRED)?isEmpty(trim($_POST['template_title']), ADMIN_COMMON_EMAIL_IS_REQUIRED):checkStr(trim($_POST['template_title']));	
    	
		/*if($_POST['template_from_address']!='') {
		$err['FromAddError'] = checkEmailPattern(trim($_POST['template_from_address']), ADMIN_EMAIL_ERROR);
		}*/
		if($_POST['template_from_to']!='') {
		$err['template_from_toError'] = checkEmailPattern(trim($_POST['template_from_to']), ADMIN_EMAIL_ERROR);
		}
		
		
		
		if(!empty($_POST['template_from_to']))
		{
		   $cc_mail = explode(",",$_POST['template_from_to']);
		   
		   if($cc_mail)
		   { 
			   $count_cc = count($cc_mail);
			   	 for ($cc_i = 0; $cc_i < $count_cc; $cc_i++ )
			   		{
			   			$err['template_from_toError'] = checkEmailPattern(trim($cc_mail[$cc_i]),ADMIN_EMAIL_ERROR);
			   		}
		   }
		   else 
		   {
		   		$err['template_from_toError'] = checkEmailPattern(trim($_POST['template_from_to']),ADMIN_EMAIL_ERROR);		
		   } 
		
		}
		
		if(!empty($_POST['template_from_cc']))
		{
		   $cc_mail = explode(",",$_POST['template_from_cc']);
	
		   if($cc_mail)
		   { 
			   $count_cc = count($cc_mail);
			   	 for ($cc_i = 0; $cc_i < $count_cc; $cc_i++ )
			   		{
			   			$err['template_from_ccError'] = checkEmailPattern(trim($cc_mail[$cc_i]),ADMIN_EMAIL_ERROR);
			   		
			   		}
			 
		   }
		   else 
		   {
		   		$err['template_from_ccError'] = checkEmailPattern(trim($_POST['template_from_cc']),ADMIN_EMAIL_ERROR);		
		   } 
		
		}
		
		$defaultSubject = $_POST['template_subject'][DEFAULT_LANGUAGE_ID];;
		if(!empty($defaultSubject))
		{
			$err['subject'] = checkHelp($defaultSubject);
		}
		if(!empty($_GET['template_status']))
		{
			$err['template_status'] = isNumeric(valid_input($_GET['template_status']),ENTER_NUMERIC_VALUES_ONLY);
		}
		if(!empty($err['template_status']))
		{
			logOut();
		}
		foreach($err as $key => $Value) {
			if($Value != '') {
				$Svalidation=true;
				$csrf->action = "emailtemplate_action";
			}
	    }
    	//End of sercer side validation
	    
	    
		if($Svalidation == false) { 
			
			$objEmailTemplateManagerData->isactive        		   = $_POST['template_status'];
			$objEmailTemplateManagerData->template_title   		   = $_POST['template_title'];
			$objEmailTemplateManagerData->template_id	  		   = $_GET['template_id'];
			$objEmailTemplateManagerData->template_from_address	   = $_POST['template_from_address'];	
			$objEmailTemplateManagerData->template_cc_address	   = $_POST['template_from_cc'];	
			$objEmailTemplateManagerData->template_to_address	   = $_POST['template_from_to'];	
			$template_id="";
			//print_R($_POST);
			if(isset($_GET['template_id']) && $_GET['template_id'] != '') {
				$URLParameters = "?pagenum=".$pagenum."&message=".MSG_ADD_SUCCESS;
				//Edit Email Template
				$objEmailTemplateManagerMaster->editEmailTemplate($objEmailTemplateManagerData);
			}
			else {
				$URLParameters = "?pagenum=".$pagenum."&message=".MSG_ADD_SUCCESS;
				//Add Email Template 		
				$emailTemplateId = $objEmailTemplateManagerMaster->addEmailTemplate($objEmailTemplateManagerData);	
				 $template_id = $emailTemplateId;
			}

			$defaultContent = $_POST['template_content'][DEFAULT_LANGUAGE_ID];		
			$defaultSubject = $_POST['template_subject'][DEFAULT_LANGUAGE_ID];
					
			if($siteLanguage != ""){
				
					foreach ($siteLanguage as $language){
						
						$objEmailTemplateManagerData   = new EmailTemplateManagerData();
						$objEmailTemplateManagerData->template_id		=	($template_id!="")?($template_id):($_GET['template_id']);
						$objEmailTemplateManagerData->site_language_id	=	$language->site_language_id;
						
						
						if($_POST['template_content'][$language->site_language_id] == "" || $_POST['template_content'][$language->site_language_id] == "<br />"){
							$objEmailTemplateManagerData->template_content 	= 	$defaultContent;
						}
						else {
							$objEmailTemplateManagerData->template_content 	= 	$_POST['template_content'][$language->site_language_id];
						}
						
						$objEmailTemplateManagerData->template_subject 	= 	$_POST['template_subject'][$language->site_language_id]?$_POST['template_subject'][$language->site_language_id]:$defaultSubject;
												
						
						/**
						 * Count the email description for current site lanuage id & template id
						 */
						$FieldArr = array();
						$FieldArr[]='count(*) as total'; // To Count Total Data
						$mailArr = array();
						$mailArr[] =	array('Search_On'=>'site_language_id', 'Search_Value'=>$language->site_language_id, 'Type'=>'string', 'Equation'=>'=', 'CondType'=>'AND', 'Prefix'=>'', 'Postfix'=>'');
						$mailArr[] =	array('Search_On'=>'template_id', 'Search_Value'=>$_GET["template_id"], 'Type'=>'string', 'Equation'=>'=', 'CondType'=>'AND', 'Prefix'=>'', 'Postfix'=>'');
						$currentDescription=$objEmailTemplateManagerMaster->getEmailTemplateDesc($FieldArr,$mailArr);
						$TotalDescription = $currentDescription[0]['total'];
									

						//Edit & Add data into email template description table					
						
						//echo "<pre>";print_r($objEmailTemplateManagerData);die();
						if($_POST['thisaction'][$language->site_language_id] == 'edit'){
							
							if($TotalDescription > 0){
								$objEmailTemplateManagerMaster->editEmailTemplateDesc($objEmailTemplateManagerData);
							}
							else {
								$InsertData = $objEmailTemplateManagerMaster->addEmailTemplateDesc($objEmailTemplateManagerData);
							}
						
						} elseif($_POST['thisaction'][$language->site_language_id] == 'add') {
			  				$InsertData = $objEmailTemplateManagerMaster->addEmailTemplateDesc($objEmailTemplateManagerData);
						}
					
					}
			}
			header("location:".FILE_ADMIN_EMAIL_TEMPLATE_MANAGER.$URLParameters);
			exit;
		}
    }
    
    
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php if(isset($_GET['template_id']) && !empty($_GET['template_id'])){ echo ADMIN_EMAIL_EDIT;}else { echo ADMIN_EMAIL_ADD; }?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<?php 
addPluginCSSFile($arr_css_plugin_include,$arr_css_plugin_exclude);
addCSSFileAdmin($arr_css_admin_include, $arr_css_admin_exclude);
addJavaScriptFile($arr_javascript_include, $arr_javascript_exclude);
addPluginJavaScriptFile($arr_javascript_plugin_include,$arr_javascript_plugin_exclude);
?>
</head>
<body><table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
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
										<span><a href="<?php echo FILE_WELCOME_ADMIN; ?>"><?php echo ADMIN_HEADER_HOME; ?></a> > <a href="<?php echo FILE_ADMIN_EMAIL_TEMPLATE_MANAGER."?pagenum=".$pagenum; ?>"><?php echo ADMIN_HEADER_EMAIL_TEMPLATE;?></a> > <?php echo $HeadingLabel; ?></span>
										<div><label class="top_navigation"><a href="<?php echo FILE_ADMIN_EMAIL_TEMPLATE_MANAGER."?pagenum=".$pagenum;?>"><?php echo ADMIN_COMMON_BACK; ?></a></label></div>
								</td>
							</tr>
							<tr>
								<td class="heading">
									<?php echo $HeadingLabel; ?>
								</td>
							</tr>
							<tr>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td align="center">
									<form name="fromemailtemplate" method="POST" action="" >
										<table width="100%" border="0" cellpadding="0" cellspacing="0">
											<tr>
												<td width="16%" align="left"><?php echo ADMIN_EMAIL_DOCUMENT_TITLE?></td>
												<td align="left" class="message_mendatory"><input name="template_title" id="template_title" type="text"  size="50"  value="<?php if(isset($templateData->template_title)){echo valid_output($templateData->template_title);}?>" maxlength="255" <?if(isset($_GET['template_id']) && $_GET['template_id'] != ""){?>readonly<?}?>/>&nbsp;*</td>
											</tr>
											<tr>
												<td>&nbsp;</td>
												<td align="left" id="TitleError" class="message_mendatory"><?php echo $err['TitleError']; ?></td>
											</tr>
											<tr>
												<td align="left" ><?php echo ADMIN_EMAIL_DOCUMENT_FROM_ADDRESS;?></td>
												<td align="left" class="message_mendatory"><input name="template_from_address" id="template_from_address" type="text"  size="50"  value="<?php if(isset($templateData->template_from_address)){echo valid_output($templateData->template_from_address);}?>" maxlength="255" />&nbsp;</td>
											</tr>
											<tr>
												<td>&nbsp;</td>
												<td align="left" id="FromAddError" class="message_mendatory"><?php echo $err['FromAddError']; ?></td>
											</tr>
											<tr>
												<td align="left"><?php echo ADMIN_EMAIL_DOCUMENT_TO;?></td>
												<td align="left" class=""><input name="template_from_to" id="template_from_to" type="text"  size="50"  value="<?php if(isset($templateData->template_to_address)){echo valid_output($templateData->template_to_address);}?>" maxlength="255" />&nbsp;
												<?php echo ADMIN_MULTIPLE_EMAIL_ID_HELP;?>
												</td>
											</tr>
											<tr>
												<td>&nbsp;</td>
												<td align="left" valign="middle" id="ToAddError" class="message_mendatory"><?php echo $err['template_from_toError']; ?></td>
											</tr>
											<tr>
												<td align="left"><?php echo ADMIN_EMAIL_DOCUMENT_CC;?></td>
												<td align="left" class=""><input name="template_from_cc" id="template_from_cc" type="text"  size="50"  value="<?php if(isset($templateData->template_from_address)){echo valid_output($templateData->template_cc_address);}?>" maxlength="255" />&nbsp;
												<?php echo ADMIN_MULTIPLE_EMAIL_ID_HELP;?>
												</td>
											</tr>
											<tr>
												<td>&nbsp;</td>
												<td align="left" valign="middle" id="template_from_ccError" class="message_mendatory"><?php echo $err['template_from_ccError']; ?></td>
											</tr>
											
											<tr>
												<td align="left"><?=ADMIN_COMMON_STATUS?></td>
												<td align="left">
													<span><input type="radio" name="template_status" id="template_status" value="1" checked='checked'><? echo ADMIN_COMMON_STATUS_ACTIVE;?></span>
													<span><input type="radio" name="template_status" id="template_status" value="0" <?php if($templateData->isactive == "0" || $_POST['status']=='0'){ echo "checked=checked";} else { echo ""; }?>><? echo ADMIN_COMMON_STATUS_INACTIVE;?></span>
											   	</td>
											</tr>
											<tr>
												<td>&nbsp;</td>
												<td>&nbsp;</td>
											</tr>
											<tr>
												<td colspan="2" >
													<div id="TabbedPanels1" class="TabbedPanels" >
														<ul class="TabbedPanelsTabGroup">
													<?php foreach($siteLanguage as $arrid => $languagesite) { ?>
															<li class="TabbedPanelsTab" tabindex="<?php echo $arrid; ?>" ><?php echo valid_output($languagesite['site_language_name']); ?></li>
													<?php } ?>
														</ul>
														<div class="TabbedPanelsContentGroup" >
													<?php foreach($siteLanguage as $arrid => $languagesite) {
																$languageid =$languagesite['site_language_id'];
																$thisaction = 'add';
																if(isset($_GET["template_id"])&&$_GET["template_id"]!=''){
																	// Get The Current Details
																	$mailArr = array();
																	$mailArr[] =	array('Search_On'=>'site_language_id', 'Search_Value'=>$languagesite->site_language_id, 'Type'=>'string', 'Equation'=>'=', 'CondType'=>'AND', 'Prefix'=>'', 'Postfix'=>'');
																	$mailArr[] =	array('Search_On'=>'template_id', 'Search_Value'=>$_GET["template_id"], 'Type'=>'string', 'Equation'=>'=', 'CondType'=>'AND', 'Prefix'=>'', 'Postfix'=>'');
																	$currentDescription=$objEmailTemplateManagerMaster->getEmailTemplateDesc(null,$mailArr);
																	$emailTemplateDescription=array();
																	//$emailTemplateDescription =$currentDescription[0];
																	if($currentDescription!= '') {
																		$emailTemplateDescription = $currentDescription[0];
																		$thisaction = 'edit';
																	}
															   }
														?>
															<div class="TabbedPanelsContent" >
																<table width="100%" border="0" cellpadding="0" cellspacing="0" >
														  			<tr>
																		<td colspan="2">&nbsp;</td>
																	</tr>
													  				<tr>
																		<td align="left" width="20%" nowrap ><?php echo ADMIN_EMAIL_DOCUMENT_SUBJECT;?></Td>
																		<td align="left" class="message_mendatory"><Input type="text" name="template_subject[<?php echo $languagesite['site_language_id'];?>]" id="template_subject[<?php echo $arrid; ?>]"  size="50" align="right" class="register"  value="<?php if(isset($emailTemplateDescription->template_subject)){echo valid_output($emailTemplateDescription->template_subject);}?>">&nbsp;*</td>
																	</tr>
																	<tr>
																		<td>&nbsp;</td>
																		<td class="message_mendatory" id="subjecterror"><?php if(isset($err['subject'])&& $err['subject']!=""){ echo $err['subject'];} ?>&nbsp;</td>
																	</tr>
																	
																	<tr>
																		<td align="left" valign="top"><?php echo ADMIN_EMAIL_DOCUMENT_CONTENT;?></TD>
																		<td align="left">
																		
																	<textarea cols="80" id="template_content[<?php echo $languagesite->site_language_id; ?>]" name="template_content[<?php echo $languagesite->site_language_id; ?>]" rows="10"><?php echo htmlspecialchars($emailTemplateDescription->template_content); ?></textarea>			
																		<script>

												// This call can be placed at any point after the
												// <textarea>, or inside a <head><script> in a
												// window.onload event handler.

												// Replace the <textarea id="editor"> with an CKEditor
												// instance, using default configurations.

												CKEDITOR.replace( 'template_content[<?php echo $languagesite->site_language_id; ?>]' );

												</script>
																		</td>
																	</tr>
																	<tr>
																		<td>&nbsp;</td>
																		<td>&nbsp;</td>
																	</tr>
														  		</table>
																<input type="hidden" name="thisaction[<?php echo $languagesite['site_language_id']?>]" value="<?php echo $thisaction; ?>" />
															</div>
													<?php } ?>
														</div>
													</div>
												</td>
											</tr>
											<tr>
												<td>&nbsp;</td>
												<td>&nbsp;</td>
											</tr>
											<?php if(!empty($templateData->template_cc_address))
												{
												   $cc_mail = explode(",",valid_output($templateData->template_cc_address));
												   $count=count($cc_mail);
												   
												}?>
											<tr>
												<td valign="top" align="left"><?php echo ADMIN_EMAIL_CONTENT_HELP; ?> </td>
												<td align="left"><?php  echo valid_output($emailTemplateDescription['help_content']); ?></td>
											</tr>
											<tr>
												<td>&nbsp;</td>
												<td>&nbsp;</td>
											</tr>	
											<tr>
												<td align="center" colspan="2">
													<input type="hidden" size="34" id="ptoken" value="<?php echo $ptoken; ?>" name="ptoken">
													<input type="submit" class="action_button" name="Submit" id="Submit" value="<?php echo $buttonValue; ?>" onclick="return validationEmailTemplate('<?php echo $count;?>');"/>
													<input type="reset"  class="action_button" name="btnreset" value="<?php echo ADMIN_COMMON_BUTTON_RESET;?>"/>
													<input type="button" class="action_button" name="cancel" value="<?php echo ADMIN_COMMON_BUTTON_CANCEL;?>" onclick="javascript:document.location.href='<?php echo FILE_ADMIN_EMAIL_TEMPLATE_MANAGER."?pagenum=".$pagenum; ?>';return true;"/>
												</td>
											</tr>
										</table>
									</form>
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

<script type="text/javascript">
<!--
var default_tab = <?php echo DEFAULT_LANGUAGE_ARRAY_ID; ?>;
var TabbedPanels1 = new Spry.Widget.TabbedPanels("TabbedPanels1");
TabbedPanels1.showPanel(default_tab);
//-->
</script>
</body>
</html>