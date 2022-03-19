<?php
	/**
	 * This file is for add new category
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
	require_once('pagination_top.php');
	require_once(DIR_WS_ADMIN_LANGUAGES . DIR_CURRENT_LANGUAGE. '/faq.php');
	require_once(DIR_WS_MODEL . "FaqCategoryMaster.php");	
	require_once(DIR_WS_MODEL . "FaqMaster.php");	
	$pagenum = ($_GET['pagenum']!="")?($_GET['pagenum']):(1);
	if(!empty($pagenum))
	{
		$err['pagenum'] = isNumeric(valid_input($pagenum),ENTER_NUMERIC_VALUES_ONLY);
	}
	if(!empty($err['pagenum']))
	{
		logOut();
	}
	//Object defining 
	$ObjFaqCategoryMaster	= new FaqCategoryMaster();
	$ObjFaqCategoryMaster	= $ObjFaqCategoryMaster->Create();
	$ObjFaqMaster			= new FaqMaster();
	$ObjFaqMaster			= $ObjFaqMaster->Create();
	$ObjFaqCategoryData		= new FaqCategoryData();	
	$ObjFaqData				= new FaqData();
	
	/* Retrive the Post Data */
	$catId         = trim($_GET['CatId']);
	if(!empty($catId))
	{
		$err['CatId'] = isNumeric($catId,ENTER_VALUE_IN_NUMERIC);
	}
	if(!empty($err['CatId']))
	{
		logOut();
	}
	$faqId         = trim($_GET['FaqId']);
	if(!empty($faqId))
	{
		$err['faqId'] = isNumeric($faqId,ENTER_VALUE_IN_NUMERIC);
	}
	if(!empty($err['faqId']))
	{
		logOut();
	}
	$sort          = trim($_POST['sort']);
	$submit        = trim($_POST['Submit']);

	/* Setting Page Heading Label, Button Name and Url Parameter */
	$headingLabel	=	(!empty($catId)) ? ADMIN_FAQ_EDIT_HEADING : ADMIN_FAQ_ADD_HEADING;
	$btnSubmit		=	(!empty($catId)) ? ADMIN_FAQ_UPDATE_BUTTON : ADMIN_FAQ_ADD_HEADING;
	$URLParameters	=	(!empty($catId)) ? "?pagenum=".$pagenum."&message=".MSG_EDIT_SUCCESS : "?pagenum=".$pagenum."&message=".MSG_ADD_SUCCESS;	
	
	/**
	 * Inclusion and Exclusion Array of Javascript
	 */
	$arr_javascript_include[] = 'tabbed_panels.js';
	$arr_javascript_include[] = 'cms_action.php';
		
	$arr_css_include[] = DIR_HTTP_ADMIN_CSS.'tabbed_panels.css';
	$arr_css_exclude[] = DIR_HTTP_ADMIN_CSS.'jquery.css';
	//$arr_css_exclude[] = DIR_HTTP_ADMIN_CSS.'jquery.css';
	$arr_javascript_plugin_include[] = 'datatables/datatables.min.js';

	$arr_css_plugin_include[] = 'datatables/datatables.min.css';
	$arr_css_plugin_include[] = 'datatables/Buttons-1.6.5/css/buttons.dataTables.min.css';
	/*csrf validation*/
	$csrf = new csrf();
	$csrf->action = "faq_action";
	if(!isset($_POST['ptoken'])) {
		$ptoken = $csrf->csrfkey();
	}

	
	/*csrf validation*/

	
	/**
	 * Add/Edit Faq category Data
	 * 
	 */
	if((isset($submit)) &&  $submit != "") {   
		if(isEmpty(valid_input($_POST['ptoken']), true))
		{	
			logOut();
		}
		else
		{
			//$csrf->checkcsrf($_POST['ptoken']);
		}				
		$defaulFaqCatId	=	$_POST['catid'][DEFAULT_LANGUAGE_ID];
		$faqquestion	=	$_POST['faq_question'][DEFAULT_LANGUAGE_ID];
		$faqanswer		=	$_POST['faq_answer'][DEFAULT_LANGUAGE_ID];	
		
		/**
		 * Server Side Validation
		 */
		$err['entry_catname'] = isEmpty($defaulFaqCatId, FAQ_CATEGORY_NAME_REQUIRED)?isEmpty($defaulFaqCatId, FAQ_CATEGORY_NAME_REQUIRED):isNumeric($defaulFaqCatId,ENTER_VALUE_IN_NUMERIC);
		$err['entry_question'] = isEmpty($faqquestion, FAQ_QUESTION_REQUIRED)?isEmpty($faqquestion, FAQ_QUESTION_REQUIRED):chkRestFields($faqquestion);
		$err['entry_answer'] = isEmpty($faqanswer, FAQ_ANSWER_REQUIRED)?isEmpty($faqanswer, FAQ_ANSWER_REQUIRED):'';	
		if(isset($_POST['sort']) && $_POST['sort']!='')
		{
			$err['sort'] = isNumeric($_POST['sort'],ENTER_VALUE_IN_NUMERIC);
		}
		
		if(empty($err['entry_catname'])) {
			
			$fieldArr = array("count(*) as total");
			$seaArr[]	=	array('Search_On'=>'site_language_id',
								'Search_Value'=>DEFAULT_LANGUAGE_ID,
								'Type'=>'int',
								'Equation'=>'=',
								'CondType'=>'AND',
								'Prefix'=>'',
								'Postfix'=>'');
			$seaArr[]	=	array('Search_On'=>'faq_category_name',
								'Search_Value'=>$defaulFaqCatId,
								'Type'=>'string',
								'Equation'=>'LIKE',
								'CondType'=>'AND',
								'Prefix'=>'',
								'Postfix'=>'');
			if(!empty($catId)) {
				$seaArr[]	=	array('Search_On'=>'faqcat_id ',
								'Search_Value'=>$catId,
								'Type'=>'int',
								'Equation'=>'!=',
								'CondType'=>'AND',
								'Prefix'=>'',
								'Postfix'=>'');
			}
								
			$countcategory = $ObjFaqCategoryMaster->getFaqCategory($fieldArr,$seaArr,null,null,null,null,null,"faq_category_desc");
			$countcategory = $countcategory[0]['total'];  // Total Records
			
			if($countcategory > 0){
				$err['entry_catname'] = FAQ_CATEGORY_NAME_EXITS;
			}
		}
		
		foreach ($err as $key => $val){
			if($val != "") {
				$Svalidation=true;
				$ptoken = $csrf->csrfkey();				
			}
		}
	    // End of server side validation
	    
		if($Svalidation == false) {
			
			
			/**
			 * This Code is for Add Category & its SubCategory into site template Category table
			 * 
			 * Parent Id 0 means Add main Category & not 0 means sub category
			 */
			
			$ObjFaqData->sort_order	=	$sort;	
			$ObjFaqData->faqcat_id 	=	$_POST['catid'][DEFAULT_LANGUAGE_ID];				
			$ObjFaqData->faq_id		=	(!empty($_GET['FaqId'])) ? $_GET['FaqId'] : '';
			$ObjFaqData->status		=	(!empty($_GET['FaqId'])) ? 1 : 1;
			$CurrentFaqCategoryId	= 	(!empty($_GET['FaqId'])) ? $ObjFaqMaster->editFaq($ObjFaqData) : $ObjFaqMaster->addFaq($ObjFaqData);

			/*
			* Below Code is for Add/Edit Category into site category description table
			*/	
					
		  	foreach($siteLanguage as $languagesite) {
		  		
				$languageid						=	$languagesite['site_language_id'];				
				$ObjFaqData->faq_id				=	(!empty($_GET['FaqId'])) ? $_GET['FaqId'] : $CurrentFaqCategoryId ;
				$ObjFaqData->faq_question		=	$faqquestion;				
				$ObjFaqData->faq_answer			=	$faqanswer;
				$ObjFaqData->site_language_id	=	$languageid;
				
				$ObjFaqData1	= 	(!empty($_GET['FaqId'])) ? $ObjFaqMaster->editFaqDescription($ObjFaqData) : $ObjFaqMaster->addFaqDescription($ObjFaqData);
			}
			header("location:".FILE_ADMIN_FAQ.$URLParameters);
			exit;
		}
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php
if(isset($_GET['CatId']) && !empty($_GET['CatId'])) {
	echo ADMIN_FAQ_MANAGEMENT_EDIT;
} else {
	echo ADMIN_FAQ_MANAGEMENT_ADD;
}
?></title>
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
 
<script src="<?php echo DIR_HTTP_FCKEDITOR.'ckeditor.js'; ?>"></script>
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
						<table class="middle_right_content" align="center" border="0" cellpadding="0" cellspacing="0">
							<tr>
								<td align="left" class="breadcrumb">
										<span><a href="<?php echo FILE_WELCOME_ADMIN; ?>"><?php echo ADMIN_HEADER_HOME; ?></a> > <a href="<?php echo FILE_ADMIN_FAQ; ?>"><?php echo ADMIN_HEADER_FAQ; ?></a> > <?php echo $headingLabel; ?></span>
										<div><label class="top_navigation"><a href="<?php echo FILE_ADMIN_FAQ; ?>"><?php echo ADMIN_COMMON_BACK; ?></a></label></div>
								</td>
							</tr>
							<tr>
								<td class="heading">
									<?php echo $headingLabel; ?>
								</td>
							</tr>
							
							<tr>
								<td align="left">
								<!-- Middle Content -->
								<form name="tempcat" method="POST" action="">
									<table width="100%" border="0" cellpadding="0" cellspacing="0">
									
										<tr>
											<td colspan="2">&nbsp;</td>
										</tr>
										
										<tr>
											<td colspan="2" valign="top">
											
											<div id="TabbedPanels1" class="TabbedPanels" >
													<ul class="TabbedPanelsTabGroup">
													<?php 
													foreach($siteLanguage as $arrid => $languagesite) { ?>
														<li class="TabbedPanelsTab" tabindex="<?php echo $arrid; ?>" ><?php echo $languagesite['site_language_name']; ?></li>
													<?php } ?>
													</ul>
													<div class="TabbedPanelsContentGroup" >
													<?php foreach($siteLanguage as $arrid => $languagesite) {
															$languageid =$languagesite['site_language_id'];
															$thisaction = 'add';
															
															/* Retrive FAQ Category */
															$sFaq = array();
															$sFaq[]   = " AND faq_category_desc.site_language_id = '".$languageid."' ";
															$faqcategory	= $ObjFaqCategoryMaster->getSiteFaqCategoryDesc($sFaq);	
																														
															if(!empty($faqId)) {		
																
																/* Retrive FAQ's */
																$sFaqarr = array();
																$sFaqarr[]   = " AND faq_description.faq_id = '".$faqId."' ";
																$sFaqarr[]   = " AND faq_description.site_language_id = '".$languageid."' ";
																$fieldArr = array("faq.faq_id","faqcat_id","faq_description.faq_question","faq_description.faq_answer","faq_description.site_language_id","faq.status","faq.sort_order");
																
																$faqarr	= $ObjFaqMaster->getSiteFaqDesc($sFaqarr,$fieldArr);
																										
																if(!empty($faqarr)) {
																	$thisaction = 'edit';
																	$faqData = $faqarr[0];	
																	$currentsortorder = $faqData['sort_order'];
																}
															}
													?>
													<div class="TabbedPanelsContent" >
													<table width="100%" border="0" cellpadding="0" cellspacing="4" >
														<tr>
															<td class="TabbedPanelsInnerLbl" align="left" width="20%" nowrap ><?php echo ADMIN_FAQ_CATEGORY_NAME; ?></td>
															<td align="left" class="message_mendatory" width="80%">
															<select  name="catid[<?php echo $languageid?>]" id="catid[<?php echo $arrid;?>]">
															<?php
																if(!empty($faqcategory)) {																	
																	foreach ($faqcategory as $faqcatdata) { ?>																		
																		<option value="<?php echo $faqcatdata['faqcat_id'];?>"																			
																			<?php if($faqcatdata['faqcat_id'] == $catId) { 
														 						echo "selected";
																			}  ?>>
																		<?php echo $faqcatdata['faq_category_name'];?></option>			
															<?php																		
																	 }
																}
															?>
															</select>
														</tr>
														<?php if($languagesite['site_language_id'] == DEFAULT_LANGUAGE_ID) { ?>
														<tr>
															<td>&nbsp;</td>
															<td class="message_mendatory" id="CNameError"><?php if(!empty($err['entry_catname'])) {echo $err['entry_catname'];} ?></td>
														</tr>
														<?php } else { ?>
																<tr>
																	<td>&nbsp;</td>
																	<td>&nbsp;</td>
																</tr>
														<?php } ?>														
														<tr>
															<td class="TabbedPanelsInnerLbl" align="left" width="20%" nowrap ><?php echo ADMIN_FAQ_QUESTION; ?></td>
															<td align="left" class="message_mendatory" width="80%"><Input type="text" name="faq_question[<?php echo $languageid?>]" id="faq_question[<?php echo $arrid;?>]"  maxlength="255" align="right" class="register" tabindex="6" value="<?php if($_GET['FaqId']!='') { echo $faqData['faq_question']; }?>"> *<img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>internal/help_up.gif" class="help_btn" alt="<?php echo ADMIN_FAQ_QUESTION; ?>"onmouseover="return overlib('<?php echo $QuestionRequire;?>');" onmouseout="return nd();" /></td>
														</tr>	
														<?php if($languagesite['site_language_id'] == DEFAULT_LANGUAGE_ID) { ?>
														<tr>
															<td>&nbsp;</td>
															<td class="message_mendatory" id="FQuestionError"><?php if(!empty($err['entry_question'])) {echo $err['entry_question'];} ?></td>
														</tr>
														<?php } else { ?>
																<tr>
																	<td>&nbsp;</td>
																	<td>&nbsp;</td>   
																</tr>
														<?php } ?>		
																																					
														<tr>
															<td class="TabbedPanelsInnerLbl" align="left" width="20%" nowrap  valign="top"><?php echo ADMIN_FAQ_ANSWER; ?></td>															
																
															<td align="left" class="message_mendatory" width="80%">
																
																<textarea cols="80" id="faq_answer[<?php echo $languagesite->site_language_id; ?>]" name="faq_answer[<?php echo $languagesite->site_language_id; ?>]" rows="10"><?php echo htmlspecialchars($faqData['faq_answer']); ?></textarea>
																<script>
																CKEDITOR.replace( 'faq_answer[<?php echo $languagesite->site_language_id; ?>]' );
																</script>
															</td>																												
														</tr>	
														<?php if($languagesite['site_language_id'] == DEFAULT_LANGUAGE_ID) { ?>
														<tr>
															<td>&nbsp;</td>
															<td class="message_mendatory" id="FAnswerError"><?php if(!empty($err['entry_answer'])) {echo $err['entry_answer'];} ?></td>
														</tr>
														<?php } else { ?>
																<tr>
																	<td>&nbsp;</td>
																	<td>&nbsp;</td>
																</tr>
														<?php } ?>																											
														
														<input type="hidden" name="thisaction[<?php echo $languagesite['site_language_id']?>]" value="<?php echo $thisaction; ?>" />
													</table>
												</div>
												<?php 		$i++;
														}
												 ?>
													</div>
												</div>
											</td>
										</tr>
										<tr><td colspan="2">&nbsp;</td></tr>
										<tr>
											<td class="TabbedPanelsOuterLbl" align="left" width="20%"><?php echo ADMIN_COMMON_SORT_ORDER; ?></td>
											<td class="TabbedPanelsOuterLbl message_mendatory"><Input type="text" name="sort" tabindex="7"  maxlength="50" size="10" class="register" value="<?php if(isset($sort) && $sort!='') {echo $sort;} else if ($_GET['CatId']!='') { echo $currentsortorder;}?>"></td>
										</tr>
										<tr>
											<td></td>
											<td class="message_mendatory" id="PNameError" ><?php if(isset($err['sort']) && $err['sort'] != '') { echo $err['sort']; } ?></td>
										</tr>
										<tr><td colspan="2">&nbsp;</td></tr>
										<tr>
											<td>&nbsp;</td>
											<td>
											<input type="hidden" size="34" id="ptoken" value="<?php echo $ptoken; ?>" name="ptoken">	
											<input type="submit" name="Submit" id="Submit" value="<?php echo $btnSubmit;?>" tabindex="8" class="action_button" onclick="return validationFaq();"/>
											<input type="reset" name="btnreset" value="Reset" class="action_button" tabindex="9" onclick="document.tempcat.reset();"/>
											<input type="button"  class="action_button" name="cancel" tabindex="10" value="<?php echo ADMIN_COMMON_BUTTON_CANCEL;?>" onclick="javascript:document.location.href='<?php echo FILE_ADMIN_FAQ; ?>';return true;"/>
											</td>
										</tr>
										<tr><td colspan="2">&nbsp;</td></tr>
									
									</table>
									</form>
									<!-- End of Middle Content -->
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
