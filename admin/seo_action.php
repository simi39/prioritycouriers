<?php
/**
 * This file is for adding of  Seo Pages for the Seo Management.
 *
 * @author     Radixweb <team.radixweb@gmail.com>
 * @copyright  Copyright (c) 2008, Radixweb
 * @version    1.0
 * @since      1.0
 */
		
/**
 * Include commom file
 */
	require_once("../lib/common.php");
	require_once(DIR_WS_MODEL . "seoPageMaster.php");
	require_once(DIR_WS_ADMIN_LANGUAGES . DIR_CURRENT_LANGUAGE. '/seo.php');
	
	
/**
 * Inclusion and Exclusion Array of Javascript
 */
	$arr_css_plugin_include[] = 'datatables/css/jquery.dataTables.min.css';	
	$arr_javascript_plugin_include[] = 'datatables/js/jquery.dataTables.min.js';
	$arr_javascript_include[] = 'seo_action.php';
	
	$pagenum = ($_GET['pagenum']!="")?($_GET['pagenum']):(1);
	if(!empty($pagenum))
	{
		$err['pagenum'] = isNumeric(valid_input($pagenum),ENTER_NUMERIC_VALUES_ONLY);
	}
	if(!empty($err['pagenum']))
	{
		logOut();
	}
/**
 * Start :: Object declaration
 */
	$objSeoMaster = new seoPageMaster();
	$objSeoMaster = $objSeoMaster->Create();
	$objSeoData  = new seoPageData();
	$Svalidation == false;
	
	/*csrf validation*/
	$csrf = new csrf();
	$csrf->action = "seo_action";
	if(!isset($_POST['ptoken'])) {
		$ptoken = $csrf->csrfkey();
	}

	
	/*csrf validation*/

/**
 * Start :: Variable Declaration and Assignment
 */
	
	$sid           = $_GET['sid'];
	if(!empty($sid))
	{
		$err['sid'] = isNumeric(valid_input($sid),ENTER_NUMERIC_VALUES_ONLY);
	}
	if(!empty($err['sid']))
	{
		logOut();
	}
	$HeadingLabel  = ADMIN_SEO_ADD;
	$buttonLablel  = ADMIN_SEO_BUTTON_ADD;
	$pagename      = trim($_POST['txt_name']);
	$btnseo        = trim($_POST['Submit']);
	$title         = ADMIN_SEO_MANAGEMENT_ADD;
		
	
	$getPgeTitles = $objSeoMaster->getSeoPageTitles();
	
	
	// Add edit action takes place on click of the button
	if(isset($btnseo) && !empty($btnseo)) {
		if(isEmpty(valid_input($_POST['ptoken']), true)){	
			logOut();
		}else{
			//$csrf->checkcsrf($_POST['ptoken']);
		}
		$err['err_name'] = isEmpty($_POST['txt_name'],ADMIN_SEO_PAGENAME_REQUIRE)?isEmpty($_POST['txt_name'],ADMIN_SEO_PAGENAME_REQUIRE):checkStr($_POST['txt_name']);
	    $err['err_title'] 	 = isEmpty($_POST['txt_title'][DEFAULT_LANGUAGE_ARRAY_ID],SEO_PAGE_TITLE_REQUIRE)?isEmpty($_POST['txt_title'][DEFAULT_LANGUAGE_ARRAY_ID],SEO_PAGE_TITLE_REQUIRE):checkHelp($_POST['txt_title'][DEFAULT_LANGUAGE_ARRAY_ID]);
	    $err['err_keywords']   = isEmpty($_POST['keywords'][DEFAULT_LANGUAGE_ARRAY_ID]  ,SEO_PAGE_KEYWORDS_REQUIRE)?isEmpty($_POST['keywords'][DEFAULT_LANGUAGE_ARRAY_ID]  ,SEO_PAGE_KEYWORDS_REQUIRE):checkStr($_POST['keywords'][DEFAULT_LANGUAGE_ARRAY_ID]);
		$err['err_descriptions']    = isEmpty($_POST['description'][DEFAULT_LANGUAGE_ARRAY_ID]  ,SEO_PAGE_DESCRIPTION_REQUIRE)?isEmpty($_POST['description'][DEFAULT_LANGUAGE_ARRAY_ID]  ,SEO_PAGE_DESCRIPTION_REQUIRE):checkHelp($_POST['description'][DEFAULT_LANGUAGE_ARRAY_ID]);
		     	
	    if(!empty($err['err_title'][DEFAULT_LANGUAGE_ARRAY_ID]) ||  !empty($err['err_keywords'][DEFAULT_LANGUAGE_ARRAY_ID]) || !empty($err['err_descriptions'][DEFAULT_LANGUAGE_ARRAY_ID])) {
			$Svalidation=true;
			$ptoken = $csrf->csrfkey();
	    }
	
	 	if($Svalidation == false) { 
			
			$objSeoData->page_name    = $pagename;			
			if(isset($sid) && $sid!='') { 
				
				//Edits data to the site_seo table
				
				$objSeoData->page_id = $sid;
				$objSeoMaster->editseoPage($objSeoData);
			} else {
				
				//Adds data to the site_seo table
			    
				$sid = $objSeoMaster->addseoPage($objSeoData);
			}
			
			$objSeoData= new seoPageData();
			foreach($siteLanguage as $arrID=>$languagesite) {
				$languagesiteid = $languagesite['site_language_id'];
				
				$objSeoData->page_id 		    = $sid;
				if(empty($_POST['txt_title'][$arrID])) {
					$_POST['txt_title'][$arrID]	= $_POST['txt_title'][DEFAULT_LANGUAGE_ARRAY_ID];
				}
				if(empty($_POST['keywords'][$arrID])) {
					$_POST['keywords'][$arrID]	= $_POST['keywords'][DEFAULT_LANGUAGE_ARRAY_ID];
				}
				if(empty($_POST['description'][$arrID])) {
					$_POST['description'][$arrID]	= $_POST['description'][DEFAULT_LANGUAGE_ARRAY_ID];
				}
				$objSeoData->seo_page_title 		= $_POST['txt_title'][$arrID];
				$objSeoData->seo_page_keywords      = $_POST['keywords'][$arrID];
				$objSeoData->seo_page_description   = $_POST['description'][$arrID];
				$objSeoData->site_language_id   = $languagesiteid;
				
				if($_POST['thisaction'][$arrID] == 'edit') {
					
					//EDITS data to the site_seo_description table
					
					$objSeoMaster->editseoPageDescription($objSeoData);
					$message        = MSG_EDIT_SUCCESS;
				} else if($_POST['thisaction'][$arrID] == 'add') {
				    
					//Adds data to the faq_description table
					$objSeoData->page_id 		= $sid;
					$objSeoMaster->addseoPageDescription($objSeoData);
					$message        = MSG_ADD_SUCCESS;
				}
			}
			header("location:".FILE_ADMIN_SEO."?pagenum=".$pagenum."&message=".$message);
			exit;
		}
	}
	
	// Get details for a particular id
	
	if(isset($sid) && $sid!='') {
		$seaArr[] =	array('Search_On'=>'page_id',
						'Search_Value'=>$sid,
						'Type'=>'int',
						'Equation'=>'=',
						'CondType'=>'AND',
						'Prefix'=>'',
						'Postfix'=>'');
		$seoResult    = $objSeoMaster->getseoPage(null,$seaArr);
		$seoResult    = $seoResult[0];
		$HeadingLabel = ADMIN_SEO_EDIT;
		$buttonLablel = ADMIN_SEO_BUTTON_EDIT;
		$title        = ADMIN_SEO_MANAGEMENT_EDIT;
	} 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo $title?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
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
										<span><a href="<?php echo FILE_WELCOME_ADMIN; ?>"><?php echo ADMIN_HEADER_HOME; ?></a> > <a href="<?php echo FILE_ADMIN_SEO;?>"><?php echo ADMIN_HEADER_SEO_MANAGEMENT;?></a> > <?php echo $HeadingLabel; ?></span>
										<div><label class="top_navigation"><a href="<?php echo FILE_ADMIN_SEO; ?>"><?php echo ADMIN_COMMON_BACK; ?></a></label></div>
								</td>
							</tr>
							<tr>
								<td class="heading">
									<?php echo $HeadingLabel; ?>
								</td>
							</tr>
							<tr>
								<td class="message_mendatory" align="right">
									<?php echo ADMIN_COMMAN_REQUIRED_INFO;?>
								</td>
							</tr>
							<tr>
								<td align="center">
									<form name="frmaddseo" action="" method="POST" action="">
									<table width="100%" border="0" cellpadding="0" cellspacing="0" >
										<tr>
											<td align="left" class="TabbedPanelsOuterLbl" width="20%" nowrap valign="top"><?php echo ADMIN_SEO_PAGENAME;?></td>													
											<td width="40%" class="message_mendatory" valign="top" align="left">
											<?php //if ($sid=='') { ?>											  
											<!-- <select name="txt_name" id="txt_name">-->
											 <?php 
										/*	  if ($getPgeTitles != ''){
											  foreach ($getPgeTitles as $pageTitle){	*/?>										  
											<!--  <option value="<?php echo $pageTitle->page_id; ?>">											  
										      <?php /*echo $pageTitle->page_name*/; ?>
										      </option>
									          <?php //}}?>
									          </select>-->
									          <?php // } else {?>
											  <input type="text" name="txt_name" value="<?php if($seoResult != ''){ echo valid_output($seoResult->page_name); } ?>" <?if($_GET["sid"] != ""){?>readonly<?}?>/>&nbsp;*<img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>internal/help_up.gif" class="help_btn" alt="<?php echo ADMIN_SEO_PAGENAME;?>"onmouseover="return overlib('<?php echo $page_name_for_seo;?>');" onmouseout="return nd();" />
											  <?php // } ?>
											  <div class="message_mendatory" id="pageNameError" ><?php if(isset($err['err_pagename'])) { echo $err['err_pagename']; } ?></div>
											</td>
											<td width="40%">&nbsp;</td>
										</tr>
										<tr><td colspan="3">&nbsp;</td></tr>
										<tr>
											<td colspan="3">
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
															if($sid!='') {
																$seoSearchArr = array();
																$seoSearchArr[] = array('Search_On'=>'page_id', 'Search_Value'=>$sid, 'Type'=>'int', 'Equation'=>'=','CondType'=>'AND', 'Prefix'=>'', 'Postfix'=>'');
																$seoSearchArr[] = array('Search_On'=>'site_language_id', 'Search_Value'=>$languagesite['site_language_id'], 'Type'=>'int', 'Equation'=>'=','CondType'=>'AND', 'Prefix'=>'', 'Postfix'=>'');
																$seodata = $objSeoMaster->getseoPageDescription(null,$seoSearchArr);
																if($seodata!= '') {
																	$seodata= $seodata[0];
																	$thisaction = 'edit';
																}
															}
													?>
														<div class="TabbedPanelsContent" >
															<table width="100%" border="0" cellpadding="0" cellspacing="0" >
																<tr>
																	<td colspan="3">&nbsp;</td>
																</tr>
																<tr>
																	<td align="left" class="TabbedPanelsInnerLbl" width="20%" nowrap ><?php echo ADMIN_SEO_PAGETITLE;?></td>
																	<td class="message_mendatory" width="40%" align="left">
																		<input type="text" id="txt_title[<?php echo $arrid; ?>]" name="txt_title[<?php echo $arrid; ?>]" value="<?php if(isset($_POST['txt_title'][$arrid])) { echo valid_output($_POST['txt_title'][$arrid]); } else { echo valid_output($seodata['seo_page_title']); } ?>" /> *<img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>internal/help_up.gif" class="help_btn" alt="<?php echo ADMIN_SEO_PAGETITLE;?>"onmouseover="return overlib('<?php echo $page_title_for_seo;?>');" onmouseout="return nd();" />
																	</td>
												                    <td width="40%">
												                    	<table width="100%" cellspacing="0" cellpadding="0" border="0" align="left">
																      		<tr>
																      	   		<td valign="top" class="TabbedPanelsInnerLbl"><span class="message_mendatory">*</span><b> <?php echo ADMIN_COMMON_NOTE; ?> : </b></td>
																		  		<td  valign="top" ><?php echo SEO_TITLE_INSTRUCTIONS; ?></td>
																			</tr>
																	   	</table>
												                     </td>
																</tr>
																<?php if($languagesite['site_language_id'] == DEFAULT_LANGUAGE_ID) { ?>
																<tr>
																	<td align="left" nowrap >&nbsp;</td>
																	<td class="message_mendatory" id="titleError[<?php echo $arrid;?>]" ><?php if(isset($err['err_title'])) { echo $err['err_title']; } ?></td>
																	<td>&nbsp;</td>
																</tr>
																<?php } else { ?>
																<tr>
																	<td>&nbsp;</td>
																	<td>&nbsp;</td>
																	<td>&nbsp;</td>
																</tr>
																<?php } ?>
																
																<tr>
																	<td class="TabbedPanelsInnerLbl" align="left" nowrap valign="top"><?php echo ADMIN_SEO_KEYWORDS;?></td>
																	<td class="message_mendatory" valign="top" align="left">
																		<textarea  rows="8" cols="30" id="keywords[<?php echo $arrid; ?>]" name="keywords[<?php echo $arrid;?>]"><?php 
																			if(isset($_POST['keywords'][$arrid])) {
													                     		echo valid_output($_POST['keywords'][$arrid]);
													                     	} else {
													                     		echo valid_output($seodata['seo_page_keywords']);
													                     	} ?></textarea> * <img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>internal/help_up.gif" class="help_btn" alt="<?php echo ADMIN_SEO_KEYWORDS;?>"onmouseover="return overlib('<?php echo $keyword_for_seo;?>');" onmouseout="return nd();" />
																	</td>
												                    <td width="40%">
												                    	<table width="100%" cellspacing="0" cellpadding="0" border="0" align="left">
																      		<tr>
																      	   		<td valign="top" class="TabbedPanelsInnerLbl"><span class="message_mendatory">*</span><b><?php echo ADMIN_COMMON_NOTE; ?>: </b></td>
																		  		<td valign="top"><?php echo SEO_KEYWORD_INSTRUCTIONS; ?></td>
																			</tr>
																	   	</table>
												                     </td>
																</tr>
																<?php if($languagesite['site_language_id'] == DEFAULT_LANGUAGE_ID) { ?>
																<tr>
																	<td align="left" nowrap >&nbsp;</td>
																	<td class="message_mendatory" id="keywordError[<?php echo $arrid;?>]" ><?php if(isset($err['err_keywords'])) { echo $err['err_keywords']; } ?></td>
																	<td>&nbsp;</td>
																</tr>
																<?php } else { ?>
																<tr>
																	<td>&nbsp;</td>
																	<td>&nbsp;</td>
																	<td>&nbsp;</td>
																</tr>
																<?php } ?>
																
																<tr>
																	<td class="TabbedPanelsInnerLbl" align="left" nowrap valign="top"><?php echo ADMIN_SEO_DESCRIPTION;?></td>
																	<td class="message_mendatory" valign="top" align="left">
																		<textarea  rows="8" cols="30" id="description[<?php echo $arrid; ?>]" name="description[<?php echo $arrid;?>]"><?php 
																		if(isset($_POST['description'][$arrid])) {
												                     		echo valid_output($_POST['description'][$arrid]);
												                     	} else {
												                     		echo valid_output($seodata['seo_page_description']);
												                     	}?></textarea> *<img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>internal/help_up.gif" class="help_btn" alt="<?php echo ADMIN_SEO_DESCRIPTION;?>"onmouseover="return overlib('<?php echo $description_for_seo;?>');" onmouseout="return nd();" />
																	</td>
												                    <td width="40%">
												                    	<table width="100%" cellspacing="0" cellpadding="0" border="0" align="left">
																      		<tr>
																      	   		<td valign="top" class="TabbedPanelsInnerLbl"><span class="message_mendatory">*</span><b><?php echo ADMIN_COMMON_NOTE; ?> : </b></td>
																		  		<td valign="top" width="85%" ><?php echo SEO_DESC_INSTRUCTIONS; ?></td>
																			</tr>
																	   	</table>
												                    </td>  				
												                </tr>
																<?php if($languagesite['site_language_id'] == DEFAULT_LANGUAGE_ID) { ?>
																<tr>
																	<td align="left" nowrap >&nbsp;</td>
																	<td class="message_mendatory" id="descriptionError[<?php echo $arrid;?>]" ><?php if(isset($err['err_descriptions'])) { echo $err['err_descriptions']; } ?></td>
																	<td>&nbsp;</td>
																</tr>
																<?php } else { ?>
																<tr>
																	<td>&nbsp;</td>
																	<td>&nbsp;</td>
																	<td>&nbsp;</td>
																</tr>
																<?php } ?>
															</table>
															<input type="hidden" name="thisaction[<?php echo $arrid?>]" value="<?php echo $thisaction; ?>" />
														</div>
												<?php } ?>
													</div>
												</div>
											</td>
										</tr>
										<tr>
											<td colspan="3">&nbsp;</td>
										</tr>
										<tr>
											<td align="center" colspan="3">
												<input type="hidden" size="34" id="ptoken" value="<?php echo $ptoken; ?>" name="ptoken">
												<input type="submit" class="action_button" name="Submit" id="Submit" value="<?php echo $buttonLablel; ?>" onclick="return seovalidation();"/>
												<input type="reset"  class="action_button" name="btnreset" value="<?php echo ADMIN_COMMON_BUTTON_RESET;?>"/>
												<input type="button" class="action_button" name="cancel" value="<?php echo ADMIN_COMMON_BUTTON_CANCEL;?>" onclick="javascript:document.location.href='<?php echo FILE_ADMIN_SEO."?pagenum=".$pagenum; ?>';return true;"/>
											</td>
										</tr>
									</table>
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
