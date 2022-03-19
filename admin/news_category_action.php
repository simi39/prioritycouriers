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
	require_once(DIR_WS_MODEL . "NewsCategoryMaster.php");	
	require_once(DIR_WS_ADMIN_LANGUAGES . DIR_CURRENT_LANGUAGE. '/news.php');
	
	//Object defining 
	$ObjNewsCategoryMaster	= new NewsCategoryMaster();
	$ObjNewsCategoryMaster	= $ObjNewsCategoryMaster->Create();
	$ObjNewsCategoryData		= new NewsCategoryData();
	$pagenum = ($_GET['pagenum']!="")?($_GET['pagenum']):(1);
	if(!empty($pagenum))
	{
		$err['pagenum'] = isNumeric(valid_input($pagenum),ENTER_NUMERIC_VALUES_ONLY);
	}
	if(!empty($err['pagenum']))
	{
		logOut();
	}
	$sort          = trim($_POST['sort']);
	$catId         = trim($_GET['CatId']);
	if(!empty($catId))
	{
		$err['catId'] = isNumeric(valid_input($catId),ENTER_NUMERIC_VALUES_ONLY);
	}
	if(!empty($err['catId']))
	{
		logOut();
	}
	$submit        = trim($_POST['Submit']);
	$headingLabel  = ADMIN_NEWS_CATEGORY_ADD_HEADING;
	$btnSubmit	   = ADMIN_NEWS_CATEGORY_ADD_HEADING;
	$URLParameters = "?pagenum=".$pagenum."&message=".MSG_ADD_SUCCESS;
	
	if($catId != ""){
		$headingLabel  = ADMIN_NEWS_CATEGORY_EDIT_HEADING;
		
		if($_GET["CatId"] != ""){
			$btnSubmit	   = ADMIN_NEWS_CATEGORY_UPDATE_BUTTON;
		}
		
		$URLParameters = "?message=".MSG_EDIT_SUCCESS;
	}
	/*csrf validation*/
	$csrf = new csrf();
	$csrf->action = "news_category_action";
	if(!isset($_POST['ptoken'])) {
		$ptoken = $csrf->csrfkey();
	}

	
	/*csrf validation*/

	
	/**
	 * Inclusion and Exclusion Array of Javascript
	 */
	$arr_javascript_include[] = 'tabbed_panels.js';
	$arr_javascript_include[] = 'template_category_action.php';
	
	$arr_css_include[] = DIR_HTTP_ADMIN_CSS.'tabbed_panels.css';
	$arr_css_exclude[] = DIR_HTTP_ADMIN_CSS.'jquery.css';
	$arr_javascript_plugin_include[] = 'datatables/datatables.min.js';

	$arr_css_plugin_include[] = 'datatables/datatables.min.css';
	$arr_css_plugin_include[] = 'datatables/Buttons-1.6.5/css/buttons.dataTables.min.css';
	
	
	// ** Fetch Data for Defined Fields ** //
	$FieldArr   = array();
	$FieldArr[] ='count(*) as total';
	
	
	//Get the category details
	 if($catId != ""){
	 	$sNewsCategory   = array();
     	$sNewsCategory[] = array('Search_On'=>'newscat_id', 'Search_Value'=>$catId, 'Type'=>'int', 'Equation'=>'=', 'CondType'=>'AND', 'Prefix'=>'', 'Postfix'=>'');
     	$currentNewsDetails = $ObjNewsCategoryMaster->getNewsCategory(null,$sNewsCategory);
     	$currentNewsDetails = $currentNewsDetails[0];
	 }
															   
	/**
	 * Add/Edit News category Data
	 * 
	 */
	if((isset($submit)) &&  $submit != "") {   
		
		if(isEmpty(valid_input($_POST['ptoken']), true)){	
			logOut();
		}else{
			//$csrf->checkcsrf($_POST['ptoken']);
		}	
		$defaultImgCatName = $_POST['catname'][DEFAULT_LANGUAGE_ID];
		
		/**
		 * Server Side Validation
		 */
		$err['entry_catname'] = isEmpty($defaultImgCatName, NEWS_CATEGORY_NAME_REQUIRED)?isEmpty($defaultImgCatName, NEWS_CATEGORY_NAME_REQUIRED):checkStr($defaultImgCatName);
		
		if($_POST['sort'] != "")
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
								'Search_Value'=>$defaultImgCatName,
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
			if($_GET['CatId'] == '')  {				
				$ObjNewsCategoryData->sort_order     = $sort;	
				$ObjNewsCategoryData->status 		= '1';
				$CurrentCategoryId = $ObjNewsCategoryMaster->addNewsCategory($ObjNewsCategoryData);
			}
			
			/**
			 * This Code is for Edit News Category into site template Category table
			 */
			if($_GET['CatId'] != '')  {				
				$ObjNewsCategoryData->newscat_id    = $_GET['CatId'];
				$ObjNewsCategoryData->status 		= 0;
				$ObjNewsCategoryData->sort_order   = $sort;	
				$CurrentCategoryId = $ObjNewsCategoryMaster->editNewsCategory($ObjNewsCategoryData);
			}
			
			/*
			* Below Code is for Add/Edit Category into site category description table
			*/	
					
		  	foreach($siteLanguage as $languagesite) {
		  		
				$languageid =$languagesite['site_language_id'];
				
				if(empty($_POST['catname'][$languageid])) {
					$_POST['catname'][$languageid] = $defaultImgCatName;
				}
				
				$ObjNewsCategoryData->news_category_name	= $_POST['catname'][$languageid];
				$ObjNewsCategoryData->site_language_id	= $languageid;
				$ObjNewsCategoryData->newscat_id			= $CurrentCategoryId;

				//Add News Category
				if($_GET['CatId'] =='') {
					$ImageCategoryData1 = $ObjNewsCategoryMaster->addNewsCategoryDescription($ObjNewsCategoryData);
				}
				
				//Edit News Category
				if($_GET['CatId'] != '')  {
					$ObjNewsCategoryData->newscat_id         = $_GET['CatId'];
					$ImageCategoryData1 = $ObjNewsCategoryMaster->editNewsCategoryDescription($ObjNewsCategoryData);
				}
						
			}
			header("location:".FILE_ADMIN_NEWS_CATEGORY.$URLParameters);
			exit;
		}
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php
if(isset($_GET['CatId']) && !empty($_GET['CatId'])) {
	echo ADMIN_NEWS_CATEGORY_MANAGEMENT_EDIT;
} else {
	echo ADMIN_NEWS_CATEGORY_MANAGEMENT_ADD;
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
function validationNews()	
{
	
	var errorflag = false;
	
	if(trim(document.getElementById("catname["+default_tab+"]").value) == '') {
			document.getElementById("CNameError").innerHTML = "<?php echo NEWS_CATEGORY_NAME_REQUIRED;?>";
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
										<span><a href="<?php echo FILE_WELCOME_ADMIN; ?>"><?php echo ADMIN_HEADER_HOME; ?></a> > <a href="<?php echo FILE_ADMIN_NEWS_CATEGORY; ?>"><?php echo ADMIN_HEADER_NEWS_CATEGORY; ?></a> > <?php echo $headingLabel; ?></span>
										<div><label class="top_navigation"><a href="<?php echo FILE_ADMIN_NEWS_CATEGORY; ?>"><?php echo ADMIN_COMMON_BACK; ?></a></label></div>
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
														<li class="TabbedPanelsTab" tabindex="<?php echo $arrid; ?>" ><?php echo valid_output($languagesite['site_language_name']); ?></li>
													<?php } ?>
													</ul>
													<div class="TabbedPanelsContentGroup" >
													<?php foreach($siteLanguage as $arrid => $languagesite) {
															$languageid =$languagesite['site_language_id'];
															$thisaction = 'add';
															if(isset($catId) && !empty($catId)){
															   $sNewsCategory = array();
															   $sNewsCategory[]   = " AND news_category.newscat_id = '".$catId."' ";
															   $sNewsCategory[]   = " AND news_category_desc.site_language_id = '".$languageid."' ";

															   $newscategory    = $ObjNewsCategoryMaster->getSiteNewsCategoryDesc($sNewsCategory);
															   
																if($newscategory != '') {
																	$thisaction = 'edit';
																	$newscategoryData = $newscategory[0];
																	$currentsortorder = $newscategoryData['sort_order'];
																}
															}																
															 ?>
														<div class="TabbedPanelsContent" >
													<table width="100%" border="0" cellpadding="0" cellspacing="4" >
														<tr>
															<td class="TabbedPanelsInnerLbl" align="left" width="20%" nowrap ><?php echo ADMIN_NEWS_CATEGORY_NAME; ?></td>
															<td align="left" class="message_mendatory" width="80%"><Input type="text" name="catname[<?php echo $languageid?>]" id="catname[<?php echo $arrid;?>]"  maxlength="50" align="right" class="register" tabindex="6" value="<?php if(isset($catnames[$languageid]) && !empty($catnames[$languageid])) {echo $catnames[$languageid];} else if ($_GET['CatId']!='') { echo valid_output($newscategoryData['news_category_name']);}?>"> *<img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>internal/help_up.gif" class="help_btn" alt="<?php echo ADMIN_NEWS_CATEGORY_NAME; ?>"onmouseover="return overlib('<?php echo valid_output($CategoryName);?>');" onmouseout="return nd();" /></td>
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
														<input type="hidden" name="thisaction[<?php echo $languagesite['site_language_id']?>]" value="<?php echo $thisaction; ?>" />
													</table>
												</div>
											<?php 		$i++;
													} ?>
													</div>
												</div>
											</td>
										</tr>
										<tr><td colspan="2">&nbsp;</td></tr>
										<tr>
											<td class="TabbedPanelsOuterLbl" align="left" width="20%"><?php echo ADMIN_COMMON_SORT_ORDER; ?></td>
											<td class="TabbedPanelsOuterLbl message_mendatory"><Input type="text" name="sort" tabindex="7"  maxlength="50"  class="register" value="<?php if(isset($sort) && $sort!='') {echo $sort;} else if ($_GET['CatId']!='') { echo $currentsortorder;}?>"></td>
										</tr>
										<tr>
											<td></td>
											<td class="message_mendatory" id="PNameError" ><?php if(isset($err['sort'])) { echo $err['sort']; } ?></td>
										</tr>
										<tr><td colspan="2">&nbsp;</td></tr>
										<tr>
											<td>&nbsp;</td>
											<td>
											
											<input type="hidden"  id="ptoken" value="<?php echo $ptoken; ?>" name="ptoken">											
											<input type="submit" name="Submit" id="Submit" value="<?php echo $btnSubmit;?>" tabindex="8" class="action_button" onclick="return validationNews();"/>
											<input type="reset" name="btnreset" value="Reset" class="action_button" tabindex="9" onclick="document.tempcat.reset();"/>
											<input type="button"  class="action_button" name="cancel" tabindex="10" value="<?php echo ADMIN_COMMON_BUTTON_CANCEL;?>" onclick="javascript:document.location.href='<?php echo FILE_ADMIN_NEWS_CATEGORY; ?>';return true;"/>
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
