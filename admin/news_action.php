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
	require_once(DIR_WS_ADMIN_LANGUAGES . DIR_CURRENT_LANGUAGE. '/news.php');
	require_once(DIR_WS_MODEL . "NewsCategoryMaster.php");	
	require_once(DIR_WS_MODEL . "NewsMaster.php");	
	
	//Object defining 
	$ObjNewsCategoryMaster	= new NewsCategoryMaster();
	$ObjNewsCategoryMaster	= $ObjNewsCategoryMaster->Create();
	$ObjNewsMaster			= new NewsMaster();
	$ObjNewsMaster			= $ObjNewsMaster->Create();
	$ObjNewsCategoryData		= new NewsCategoryData();	
	$ObjNewsData			= new NewsData();
	
	/* Retrive the Post Data */
	$catId         = trim($_GET['CatId']);
	if(!empty($catId))
	{
		$err['catId'] = isNumeric(valid_input($catId),ENTER_NUMERIC_VALUES_ONLY);
	}
	if(!empty($err['catId']))
	{
		logOut();
	}
	$newsId         = trim($_GET['NewsId']);
	if(!empty($newsId))
	{
		$err['newsId'] = isNumeric(valid_input($newsId),ENTER_NUMERIC_VALUES_ONLY);
	}
	if(!empty($err['newsId']))
	{
		logOut();
	}
	$sort          = trim($_POST['sort']);
	$submit        = trim($_POST['Submit']);
    $pagenum = ($_GET['pagenum']!="")?($_GET['pagenum']):(1);
	if(!empty($pagenum))
	{
		$err['pagenum'] = isNumeric(valid_input($pagenum),ENTER_NUMERIC_VALUES_ONLY);
	}
	if(!empty($err['pagenum']))
	{
		logOut();
	}
	/* Setting Page Heading Label, Button Name and Url Parameter */
	$headingLabel	=	(!empty($catId)) ? ADMIN_NEWS_EDIT_HEADING : ADMIN_NEWS_ADD_HEADING;
	$btnSubmit		=	(!empty($catId)) ? ADMIN_NEWS_UPDATE_BUTTON : ADMIN_NEWS_ADD_HEADING;
	$URLParameters	=	(!empty($catId)) ? "?pagenum=".$pagenum."&message=".MSG_EDIT_SUCCESS : "?message=".MSG_ADD_SUCCESS;	
	
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
	$csrf->action = "news_action";
	if($submit == '')
	{
		$ptoken = $csrf->csrfkey();
	}

	
	/*csrf validation*/

	
	/**
	 * Add/Edit NEWS category Data
	 * 
	 */
	if((isset($submit)) &&  $submit != "") {   
		
		if(isEmpty(valid_input($_POST['ptoken']), true)){	
			logOut();
		}else{
			$csrf->checkcsrf($_POST['ptoken']);
		}		
		$defaulNewsCatId	=	$_POST['catid'][DEFAULT_LANGUAGE_ID];
		$newsquestion	=	$_POST['news_question'][DEFAULT_LANGUAGE_ID];
		$newsanswer		=	$_POST['news_answer'][DEFAULT_LANGUAGE_ID];	
		
		/**
		 * Server Side Validation
		 */
		$err['entry_catname'] = isEmpty($defaulNewsCatId, NEWS_CATEGORY_NAME_REQUIRED)?isEmpty($defaulNewsCatId, NEWS_CATEGORY_NAME_REQUIRED):checkStr($defaulNewsCatId);
		$err['entry_question'] = isEmpty($newsquestion, NEWS_TITLE_REQUIRED)?isEmpty($newsquestion, NEWS_TITLE_REQUIRED):chkRestFields($newsquestion);
		$err['entry_answer'] = isEmpty($newsanswer, NEWS_DESCRIPTION_REQUIRED)?isEmpty($newsanswer, NEWS_DESCRIPTION_REQUIRED):'';	
		if($_POST['sort']!="")
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
			$seaArr[]	=	array('Search_On'=>'news_category_name',
								'Search_Value'=>$defaulNewsCatId,
								'Type'=>'string',
								'Equation'=>'LIKE',
								'CondType'=>'AND',
								'Prefix'=>'',
								'Postfix'=>'');
			if(!empty($catId)) {
				$seaArr[]	=	array('Search_On'=>'newscat_id ',
								'Search_Value'=>$catId,
								'Type'=>'int',
								'Equation'=>'!=',
								'CondType'=>'AND',
								'Prefix'=>'',
								'Postfix'=>'');
			}
								
			$countcategory = $ObjNewsCategoryMaster->getNewsCategory($fieldArr,$seaArr,null,null,null,null,null,"news_category_desc");
			$countcategory = $countcategory[0]['total'];  // Total Records
			
			if($countcategory > 0){
				$err['entry_catname'] = NEWS_CATEGORY_NAME_EXITS;
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
			
			$ObjNewsData->sort_order	=	$sort;	
			$ObjNewsData->newscat_id 	=	$_POST['catid'][DEFAULT_LANGUAGE_ID];				
			$ObjNewsData->news_id		=	(!empty($_GET['NewsId'])) ? $_GET['NewsId'] : '';
			$ObjNewsData->status		=	(!empty($_GET['NewsId'])) ? 1 : 1;
			$CurrentNewsCategoryId	= 	(!empty($_GET['NewsId'])) ? $ObjNewsMaster->editNews($ObjNewsData) : $ObjNewsMaster->addNews($ObjNewsData);

			/*
			* Below Code is for Add/Edit Category into site category description table
			*/	
					
		  	foreach($siteLanguage as $languagesite) {
		  		
				$languageid						=	$languagesite['site_language_id'];				
				$ObjNewsData->news_id				=	(!empty($_GET['NewsId'])) ? $_GET['NewsId'] : $CurrentNewsCategoryId ;
				$ObjNewsData->news_question		=	$newsquestion;				
				$ObjNewsData->news_answer			=	$newsanswer;
				$ObjNewsData->site_language_id	=	$languageid;
				
				$ObjNewsData1	= 	(!empty($_GET['NewsId'])) ? $ObjNewsMaster->editNewsDescription($ObjNewsData) : $ObjNewsMaster->addNewsDescription($ObjNewsData);
			}
			header("location:".FILE_ADMIN_NEWS.$URLParameters);
			exit;
		}
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php
if(isset($_GET['CatId']) && !empty($_GET['CatId'])) {
	echo ADMIN_NEWS_MANAGEMENT_EDIT;
} else {
	echo ADMIN_NEWS_MANAGEMENT_ADD;
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
 
<script language="javascript" type="text/javascript" >
var default_tab=0;
function validationNews()	
{	
	var errorflag = false;
	
	if(trim(document.getElementById("news_question["+default_tab+"]").value) == '') {
			document.getElementById("FQuestionError").innerHTML = "<?php echo NEWS_TITLE_REQUIRED;?>";
			errorflag = true;
	} 
	//alert(document.getElementById("news_answer["+default_tab+"]")); return false;
	if(trim(document.getElementById("news_answer["+default_tab+"]").value) == '') {
			document.getElementById("FAnswerError").innerHTML = "<?php echo NEWS_ANSWER_REQUIRED;?>";
			errorflag = true;
	} 

	
	if(errorflag == true){
		TabbedPanels1.showPanel(default_tab);
		return false;	
	}	
	else
		return true;
}
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
										<span><a href="<?php echo FILE_WELCOME_ADMIN; ?>"><?php echo ADMIN_HEADER_HOME; ?></a> > <a href="<?php echo FILE_ADMIN_NEWS; ?>"><?php echo ADMIN_HEADER_NEWS; ?></a> > <?php echo $headingLabel; ?></span>
										<div><label class="top_navigation"><a href="<?php echo FILE_ADMIN_NEWS; ?>"><?php echo ADMIN_COMMON_BACK; ?></a></label></div>
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
															
															/* Retrive News Category */
															$sNews = array();
															$sNews[]   = " AND news_category_desc.site_language_id = '".$languageid."' ";
															$newscategory	= $ObjNewsCategoryMaster->getSiteNewsCategoryDesc($sNews);	
																														
															if(!empty($newsId)) {		
																
																/* Retrive NEWS's */
																$sNewsarr = array();
																$sNewsarr[]   = " AND news_description.news_id = '".$newsId."' ";
																$sNewsarr[]   = " AND news_description.site_language_id = '".$languageid."' ";
																$fieldArr = array("news.news_id","newscat_id","news_description.news_question","news_description.news_answer","news_description.site_language_id","news.status","news.sort_order");
																
																$newsarr	= $ObjNewsMaster->getSiteNewsDesc($sNewsarr,$fieldArr);
																										
																if(!empty($newsarr)) {
																	$thisaction = 'edit';
																	$newsData = $newsarr[0];	
																	$currentsortorder = $newsData['sort_order'];
																}
															}
													?>
													<div class="TabbedPanelsContent" >
													<table width="100%" border="0" cellpadding="0" cellspacing="4" >
														<tr>
															<td class="TabbedPanelsInnerLbl" align="left" width="20%" nowrap ><?php echo ADMIN_NEWS_CATEGORY_NAME; ?></td>
															<td align="left" class="message_mendatory" width="80%">
															<select  name="catid[<?php echo $languageid?>]" id="catid[<?php echo $arrid;?>]">
															<?php
																if(!empty($newscategory)) {																	
																	foreach ($newscategory as $newscatdata) { ?>																		
																		<option value="<?php echo $newscatdata['newscat_id'];?>"																			
																			<?php if($newscatdata['newscat_id'] == $catId) { 
														 						echo "selected";
																			}  ?>>
																		<?php echo valid_output($newscatdata['news_category_name']);?></option>			
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
															<td class="TabbedPanelsInnerLbl" align="left" width="20%" nowrap ><?php echo ADMIN_NEWS_TITLE; ?></td>
															<td align="left" class="message_mendatory" width="80%"><Input type="text" name="news_question[<?php echo $languagesite->site_language_id;?>]" id="news_question[<?php echo $arrid;?>]"  maxlength="255" align="right" class="register" tabindex="6" value="<?php if($_GET['NewsId']!='') { echo valid_output($newsData['news_question']); }?>"> *<img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>internal/help_up.gif" class="help_btn" alt="<?php echo ADMIN_NEWS_TITLE; ?>"onmouseover="return overlib('<?php echo $NewsTitle;?>');" onmouseout="return nd();" /></td>
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
															<td class="TabbedPanelsInnerLbl" align="left" width="20%" nowrap  valign="top"><?php echo ADMIN_NEWS_DESCRIPTION; ?></td>															
																	
															<td align="left" class="message_mendatory" width="80%">
																
																<textarea cols="80" id="news_answer[<?php echo $languagesite->site_language_id; ?>]" name="news_answer[<?php echo $languagesite->site_language_id; ?>]" rows="10"><?php echo htmlspecialchars($newsData['news_answer']); ?></textarea>
																<script>
																CKEDITOR.replace( 'news_answer[<?php echo $languagesite->site_language_id; ?>]' );
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
											<td class="message_mendatory" id="PNameError" ><?php if(isset($err['sort'])) { echo $err['sort']; } ?></td>
										</tr>
										<tr><td colspan="2">&nbsp;</td></tr>
										<tr>
											<td>&nbsp;</td>
											<td>
											<input type="hidden" size="34" id="ptoken" value="<?php echo $ptoken; ?>" name="ptoken">											
											<input type="submit" name="Submit" id="Submit" value="<?php echo $btnSubmit;?>" tabindex="8" class="action_button" onclick="return validationNews();"/>
											<input type="reset" name="btnreset" value="Reset" class="action_button" tabindex="9" onclick="document.tempcat.reset();"/>
											<input type="button"  class="action_button" name="cancel" tabindex="10" value="<?php echo ADMIN_COMMON_BUTTON_CANCEL;?>" onclick="javascript:document.location.href='<?php echo FILE_ADMIN_NEWS; ?>';return true;"/>
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
