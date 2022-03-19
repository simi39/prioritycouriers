<?php
	/**
	 * This file is for display all CMS
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
	  require_once(DIR_WS_MODEL . "CmsPagesMaster.php");
	  require_once(DIR_WS_ADMIN_LANGUAGES . DIR_CURRENT_LANGUAGE. '/cms.php');
	
	/**
	 * Object Declaration
	 * 
	 */	
	$objCmsPageMaster      = new CmsPagesMaster();
	$objCmsPageMaster      = $objCmsPageMaster->Create();
	$objCmsPagesData 	   = new CmsPagesData();
		
		
	/**
	 * Inclusion and Exclusion Array of Javascript
	 */
	$arr_css_plugin_include[] = 'tabbed-panels/css/tabbed_panels.css';
	$arr_javascript_plugin_include[] = 'tabbed-panels/js/tabbed_panels.js';
	//$arr_javascript_include[] = 'cms_action.php';
		
	$arr_css_include[] = DIR_HTTP_ADMIN_CSS.'tabbed_panels.css';
	$arr_css_exclude[] = DIR_HTTP_ADMIN_CSS.'jquery.css';
	/**
	 * Variable Declaration
	 */
	$page_id = $_GET['page_id'];
	if(!empty($page_id))
	{
		$err['page_id'] = isNumeric(valid_input($_GET['page_id']),ENTER_NUMERIC_VALUES_ONLY);
	}
	if(!empty($err['page_id']))
	{
		logOut();
	}
	
	
	$btnSubmit 		= ADMIN_BUTTON_SAVE_CMS;
	$btnReset 		= ADMIN_COMMON_BUTTON_RESET;
	$HeadingLabel 	= ADMIN_CMS_ADD_HEADING;
	
	/*cms data*/
	$page_name 		= $_POST['page_name'];
	$txtstatus 		= $_POST['status'];
	$cmsDesc 		= $_POST['cmsDesc'];
	$page_heading	= $_POST['heading'];
	$seoTitle 		= $_POST['seoTitle'];
	$seoKeywords 	= $_POST['seoKeywords'];
	$seoDescription = $_POST['seoDescription'];
	$Submit 		= $_POST['btnSubmit'];
	$total			= 0;
	if(!empty($txtstatus))
	{
		$err['txtstatus'] = isNumeric(valid_input($txtstatus),ENTER_NUMERIC_VALUES_ONLY);
	}
	if(!empty($err['txtstatus']))
	{
		logOut();
	}
	/*csrf validation*/
	$csrf = new csrf();
	$csrf->action = "cms_action";
	if(!isset($_POST['ptoken'])) {
		//$ptoken = $csrf->csrfkey();
	}
	
	/*csrf validation*/
	if($_GET['pagenum']!=''){
		$pagenum=$_GET['pagenum'];
	}else{
		$pagenum= 1;
	}
	if(!empty($pagenum))
	{
		$err['pagenum'] = isNumeric(valid_input($pagenum),ENTER_NUMERIC_VALUES_ONLY);
	}
	if(!empty($err['pagenum']))
	{
		logOut();
	}
	
	/**
	 * Fetch Data From Table
	 */
		if($page_id !='') { 		
			

			$fieldArr = array("cms_pages.page_id","cms_pages.page_name","cms_pages.status","cms_pages.type","cms_pages.allow_delete","cms_pages_description.page_heading","cms_pages_description.page_content","cms_pages_description.seo_page_title","cms_pages_description.seo_page_keywords","cms_pages_description.seo_page_description");
			$CmsData = $objCmsPageMaster->getCmsDetails ($fieldArr,$page_id);
			$CmsData = $CmsData[0];

			$btnSubmit = ADMIN_BUTTON_UPDATE_CMS;
			$HeadingLabel = ADMIN_CMS_EDIT_HEADING;
			$status = '';
			
		}
		/**
		 * Code for Add/Edit CMSData
		 * 
		 */
		if($Submit!='') {
			/*if(isEmpty(valid_input($_POST['ptoken']), true)){	
				logOut();
			}else{
				$csrf->checkcsrf($_POST['ptoken']);
			}*/
			$defaultHeading 	= $_POST['heading'][DEFAULT_LANGUAGE_ID];
			$defaultDescription = $_POST['cmsDesc'][DEFAULT_LANGUAGE_ID];
			
			$defaultTitle 		= $_POST['seoTitle'][DEFAULT_LANGUAGE_ID];
			$defaultKeyword		= $_POST['seoKeywords'][DEFAULT_LANGUAGE_ID];
			$defaultSeoDescription = $_POST['seoDescription'][DEFAULT_LANGUAGE_ID];
			
			if(!empty($defaultHeading)){
				$err['heading'] = checkHeader($defaultHeading);
			}
			if(!empty($defaultTitle)){
				$err['title'] = checkHelp($defaultTitle);
			}
			if(!empty($defaultKeyword)){
				$err['keyword'] = checkHelp($defaultKeyword);
			}
			if(!empty($defaultSeoDescription)){
				$err['seoDescription'] = checkHelp($defaultSeoDescription);
			}
			$err['pageNameError'] = isEmpty($page_name, PAGE_TITLE_REQUIRED);
			if (!preg_match("/^[0-9a-zA-Z\s\-\_]+$/", $page_name)) {
				$err['pageNameError'] = INVALID_PAGENAME;
			}
			
			/*if(empty($err['pageNameError'])) {
				$objCmsPagesData->allow_delete = 1 ;
				$fieldArr = array("count(*) as total");
				$seaArr[]	=	array('Search_On'=>'page_name','Search_Value'=>$page_name,'Type'=>'string','Equation'=>'=','CondType'=>'AND','Prefix'=>'','Postfix'=>'');
				if(!empty($page_id)) {
					$seaArr[]	=	array('Search_On'=>'page_id','Search_Value'=>$page_id,'Type'=>'string','Equation'=>'!=','CondType'=>'AND','Prefix'=>'','Postfix'=>'');
				}
				$CmsPagesDetails=$objCmsPageMaster->getCmsPages($fieldArr, $seaArr,null,null,null,null,'cms_pages');
				$total = $CmsPagesDetails[0]['total'];
				if($total>0){
					$err['pageNameError'] = PAGE_NAME_EXITS;
				}
			}*/
			
			//Checks if error is set or not 
			foreach($err as $key => $Value)
			{
				if($Value!= '') {
					$Svalidation=true;
					//$ptoken = $csrf->csrfkey();
				}
			}
	
			if($Svalidation == false) {
				
				$objCmsPagesData->page_name = $page_name;
				$objCmsPagesData->status = $txtstatus;
				$objCmsPagesData->allow_delete = 1;
				
				
				
				if (isset($_POST['btnSubmit']))
				{
							
					if($page_id!='') {
						$objCmsPagesData->page_id = $page_id;
						$objCmsPageMaster->editCmsPages($objCmsPagesData);
						$URLParam="?message=".MSG_EDIT_SUCCESS;
					} else {
						$page_id = $objCmsPageMaster->addCmsPages($objCmsPagesData);
						$URLParam="?message=".MSG_ADD_SUCCESS;
					}
				
				}
				foreach ($siteLanguage as $Language) {
					$langId = "";
					$langId = $Language['site_language_id'];
					
					$objCmsPagesData->page_id=$page_id;
					$objCmsPagesData->site_language_id=$langId;
					
					if($cmsDesc[$langId] == "" || $cmsDesc[$langId] == "<br />"){
						$objCmsPagesData->page_content = (($defaultDescription));
					}
					else {
						$objCmsPagesData->page_content = (($cmsDesc[$langId]));			
					}
					$objCmsPagesData->page_heading = $page_heading[$langId]?$page_heading[$langId]:$defaultHeading;
					
					$objCmsPagesData->seo_page_title = $seoTitle[$langId]?$seoTitle[$langId]:$defaultTitle;
					$objCmsPagesData->seo_page_keywords = $seoKeywords[$langId]?$seoKeywords[$langId]:$defaultKeyword;
					$objCmsPagesData->seo_page_description = $seoDescription[$langId]?$seoDescription[$langId]:$defaultSeoDescription;
	
	
					if($_POST['thisaction'][$langId] == 'edit'){
						$objCmsPagesData->page_id = $page_id;
						
						//Edit data of CMS Description
						
						$objCmsPageMaster->editCmsPagesDescription($objCmsPagesData);
						$URLParam="?message=".MSG_EDIT_SUCCESS;
					
					} else {
					//Edit data in CMS Description
						$page_id = $objCmsPageMaster->addCmsPagesDescription($objCmsPagesData);
						$URLParam="?message=".MSG_ADD_SUCCESS;
					}
				}
				if(trim(strtolower($_POST['page_name'])) == 'transit_warranty'){
					$content = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
								<html xmlns="http://www.w3.org/1999/xhtml">
								<head>
									<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
									<title>Welcome to OnlineCouriers.com.au</title>
									<style type="text/css">
									body{ font-family:Arial,Helvetica,sans-serif;font-size:14px;padding:0px;margin:0px;background-color:#ffffff;}
									 ul{list-style-type:none;} .heading {color:#0E68B6;font-size:100%;font-weight:bold;padding:0;} .captionTitle { color: #0E68B6; } .cart_heading{ background-color:#20327F;color:#FFFFFF;height:25px;line-height:20px;}  a.email_link:link, a.email_link:hover, a.email_link:visited, a.email_link:active {font-weight: bold; color: #FFFFFF;text-decoration:underline;} .mail{ border:1px solid #20327F;background-color:#ffffff;
									padding-bottom:15px;} .text_padding{ padding:5px 0px 0px 15px;} .header_bg {background-color:#20327F;margin: 4px;} .footer_bg {background-color:#20327F;margin: 4px; color: #FFFFFF !important; font-size:12px;} .link_padding { padding:2px;color: #FFFFFF } .body_link { color:#FFFFFF;}
									h10 {color:white;float:left;font-size:30px;font-weight:bold;}
									.h10 {color:white;float:left;font-size:30px;font-weight:bold;}
									.body_td{padding:4px;}
									</style>
									</head>
									<body> 
									<table cellspacing="0" border="0" width="1000">
                    				<tr>
                        			<td align="center">
	                        			<table cellpadding="6" cellspacing="0"  width="1000" class="header_bg">
	                        			<tr>
		                        			<td align="left" >
		                        			<a href="'.SITE_URL.'" title="'.SITE_URL.'">
		                        			<img border="0" src="'.DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES.'logo.gif" width="448px"  alt="'.SITE_URL.'" /></a>
		                        			</td>
		                    			</tr>
									</table>
                   					</td>
                    			</tr>
                    			<tr>
                    				<td align="center " class="body_td"><table border = "1" cellpadding="6" cellspacing="0" width="100%" > <tr><td>'.$defaultDescription.'</td></tr></table></td>
                    			</tr>
                    			<tr>
                        			<td align="center">
	                        			<table cellpadding="6" cellspacing="0" border="0" width="1000" > 
	                        			<tr>
		                        			<td align="center" class="footer_bg" > &copy; '. ADMIN_PDF_COPYRIGHT.  '&nbsp; &nbsp;&nbsp;
		                        			<a href="'.SITE_URL.'" title="'.SITE_URL.'" class="footer_bg"> visit: www.onlinecouriers.com.au </a>
		                        			</td>
		                    			</tr>
									</table>
                   					</td>
                    			</tr>
            				</table></body></html>';
					include(DIR_WS_PDF."htmltopdf.php");
					if(file_exists(DIR_WS_PDF."forms/OLC_Transit_Waranty_Policy.pdf")) {
						unlink(DIR_WS_PDF."forms/OLC_Transit_Waranty_Policy.pdf");
					}
					$path_to_pdf=DIR_WS_PDF."forms/OLC_Transit_Waranty_Policy.pdf";
					convert_to_pdf($content, $path_to_pdf,$Header=null,$Footer=null,$LeftMargin=5,$RightMaring=5,$TopMargin=10,$BottomMargin=10);
				}
				header('Location:'.FILE_ADMIN_CMS.$URLParam);
				exit;				
			}
	 }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php if ($_GET['page_id']=='') { echo ADMIN_CMS_MANAGEMENT_ADD; } else { echo ADMIN_CMS_MANAGEMENT_EDIT;}?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<?php 
addPluginCSSFile($arr_css_plugin_include,$arr_css_plugin_exclude);
addCSSFileAdmin($arr_css_admin_include, $arr_css_admin_exclude);
addJavaScriptFile($arr_javascript_include, $arr_javascript_exclude);
addPluginJavaScriptFile($arr_javascript_plugin_include,$arr_javascript_plugin_exclude);
?>
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
					<!-- Start :  Middle Content-->
						<table class="middle_right_content" align="center" border="0" cellpadding="0" cellspacing="0">
							<tr>
								<td align="left" class="breadcrumb">
										<span><a href="<?php echo FILE_WELCOME_ADMIN; ?>"><?php echo ADMIN_HEADER_HOME; ?></a> > <a href="<?php echo FILE_ADMIN_CMS; ?>"><?php echo ADMIN_HEADER_CONTENT_MANAGEMENT;?></a> > <?php echo $HeadingLabel; ?></span>
										<div><label class="top_navigation"><a href="<?php echo FILE_ADMIN_CMS;?>"><?php echo ADMIN_COMMON_BACK; ?></a></label></div>
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
							<form name="frmCms" method="POST" enctype="multipart/form-data">
							<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
							
							<tr>
							<td>
								<table width="100%" align="center" border="0" cellpadding="0" cellspacing="5">
								    <tr>
										<td width="14%" align="left"><?php echo ADMIN_COMMON_PAGE_NAME; ?></td>
										<td align="left"><input type="text" name="page_name" class="register" value="<?php if($CmsData != ''){ echo valid_output($CmsData->page_name) ; } else { echo valid_output($page_name);} ?>" <?php if($page_id !=''){ echo "readonly";}?> /></td>
									</tr>
									<tr>
										<td><input type="hidden" size="34" id="ptoken" value="<?php echo $ptoken; ?>" name="ptoken">&nbsp;</td>
										<td class="message_mendatory" id="pageNameError"><?php if(isset($err['pageNameError'])) { echo $err['pageNameError']; } ?></td>
									</tr>
									<tr>
										<td align="left"><?php echo ADMIN_COMMON_STATUS; ?></td>
										<td align="left">
										<span><input type="radio" name="status" id="status1" value="1" checked='checked'> <label for="status1"><?php echo ADMIN_COMMON_STATUS_ACTIVE;?> </label></span>
										<span><input type="radio" name="status" id="status2" value="0" <?php if($CmsData->status=='0' || $_POST['status']=='0'){ echo "checked=checked";} else { echo ""; }?>><label for="status2"><?php echo ADMIN_COMMON_STATUS_INACTIVE;?></label></span>
									
										</td>
									</tr>
									
									<tr>
										<td>&nbsp;</td>
										<td>&nbsp;</td>
									</tr>
									
								</table>
							</td>
							</tr>
							<tr>
							<td>
							
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
										if(isset($page_id) && $page_id != ''){ 
											// Get The Current Details
											$CmsSearchArr = array();
											$CmsSearchArr[] = array('Search_On'=>'page_id', 'Search_Value'=>$page_id, 'Type'=>'int', 'Equation'=>'=','CondType'=>'AND', 'Prefix'=>'', 'Postfix'=>'');
											$CmsSearchArr[] = array('Search_On'=>'site_language_id', 'Search_Value'=>$languageid, 'Type'=>'int', 'Equation'=>'=','CondType'=>'AND', 'Prefix'=>'', 'Postfix'=>'');
											$CmsDataPage = $objCmsPageMaster->getCmsPages('page_content',$CmsSearchArr,null,null,null,null,'cms_pages_description');
												
											if($CmsDataPage!= '') {
												$CmsDataPage = $CmsDataPage[0];
												$thisaction = 'edit';
										}
									   }
								?>
								<div class="TabbedPanelsContent" >					
								<table width="100%" align="center" border="0" cellpadding="0" cellspacing="10">
							
									<tr>
										<td align="left">
											
											
											<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
												<tr>
													<td align="left" nowrap align="left"><?php echo ADMIN_CMS_PAGE_HEADING;?></td>
													<td class="message_mendatory" valign="top" align="left"><input type="text" name="heading[<?php echo $languagesite['site_language_id']; ?>]" id="heading[<?php echo $arrid;?>]" 
									                    value="<?php  
									                     if($CmsDataPage != '') {
									                     	echo valid_output($CmsDataPage['page_heading']);
									                     } else { echo $page_heading[$languageid];} ?>" class="register"></td>
								                </tr>
								               <tr>
												<td >&nbsp;</td>
												<td class="message_mendatory"><?php if(isset($err['heading']) && $err['heading']!=""){ echo $err['heading'];} ?>&nbsp;</td>
											   </tr>
								                <tr><td colspan="2">&nbsp;</td></tr>
												<tr>
													<td valign="top" align="left"><?php echo ADMIN_CMS_DESCRIPTION; ?></td>
													<td align="left">
													<textarea cols="80" id="cmsDesc[<?php echo $languagesite->site_language_id; ?>]" name="cmsDesc[<?php echo $languagesite->site_language_id; ?>]" rows="10"><?php echo htmlspecialchars($CmsData->page_content); ?></textarea>
													
												</td>
												<script>

												// This call can be placed at any point after the
												// <textarea>, or inside a <head><script> in a
												// window.onload event handler.

												// Replace the <textarea id="editor"> with an CKEditor
												// instance, using default configurations.

												CKEDITOR.replace( 'cmsDesc[<?php echo $languagesite->site_language_id; ?>]' );

												</script>
												</tr>
												<tr><td>&nbsp;</td></tr>
												<?php if(SEO_ENABLE == true && $CmsData->type == 'M') { ?>
												<tr>
													<td colspan="3" class="grayheader" align="center"><?php echo SEO_CONTENT_DESCRIPTION; ?></td>
												</tr>
												<tr><td>&nbsp;</td></tr>
												<tr>
													<td align="left" width="20%" nowrap ><?php echo ADMIN_SEO_PAGETITLE;?></td>
													<td class="message_mendatory"><input type="text" id="seoTitle[<?php echo $arrid; ?>]" name="seoTitle[<?php echo $languagesite['site_language_id'];?>]"  
											                    value="<?php  
											                     if($CmsDataPage != '') {
											                     	echo valid_output($CmsDataPage['seo_page_title']);
											                     }else {echo valid_output($seoTitle[$languageid]);}
											                     ?>" class="register"></td>
											                     
												</tr>
												
												
												
												<tr><td colspan="2">&nbsp;</td></tr>
												<tr><td >&nbsp;</td>
												<td class="message_mendatory"><?php if(isset($err['title']) && $err['title']!=""){ echo $err['title'];} ?>&nbsp;</td>
												</tr>
												<tr>
													<td align="left" nowrap valign="top"><?php echo ADMIN_SEO_KEYWORDS;?></td>
													<td class="message_mendatory" valign="top"><textarea  rows="5" cols="40" id="seoKeywords[<?php echo $arrid; ?>]" name="seoKeywords[<?php echo $languagesite['site_language_id'];?>]"><?php 
														 if($CmsDataPage != '') {
								                     	echo valid_output($CmsDataPage['seo_page_keywords']);
								                     } else { echo valid_output($seoKeywords[$languageid]);}?></textarea></td>
								                </tr>
								                
								                
												<tr><td >&nbsp;</td>
												<td class="message_mendatory"><?php if(isset($err['keyword']) && $err['keyword']!=""){ echo $err['keyword'];} ?>&nbsp;</td>
												</tr>
												<tr><td colspan="2">&nbsp;</td></tr>
												
												<tr>
													<td align="left" nowrap valign="top"><?php echo ADMIN_SEO_DESCRIPTION;?></td>
													<td class="message_mendatory" valign="top"><textarea  rows="5" cols="40" id="seoDescription[<?php echo $arrid; ?>]" name="seoDescription[<?php echo $languagesite['site_language_id'];?>]" ><?php 
														 if($CmsDataPage != '') {
								                     		echo valid_output($CmsDataPage['seo_page_description']);
								                     } else { echo valid_output($seoDescription[$languageid]);} ?></textarea></td>
												</tr>
												
												<tr><td >&nbsp;</td>
												<td class="message_mendatory"><?php if(isset($err['seoDescription']) && $err['seoDescription']!=""){ echo $err['seoDescription'];} ?>&nbsp;</td>
												</tr>
												<tr><td colspan="2">&nbsp;</td></tr>
											<?php }  ?>	
										</table>
											
										</td>
									</tr>
							
								</table><input type="hidden" name="thisaction[<?php echo $languagesite['site_language_id']; ?>]" value="<?php echo $thisaction; ?>" ></div>
								<?php } ?></div>
												</div>
							</td>
							</tr>
							<tr><td>&nbsp;</td></tr>
							<tr>
								<td align="center">
									<input type="submit" name="btnSubmit"  class="action_button" value="<?php echo  $btnSubmit; ?>"  onclick="return cmsValidation();"/>
									<input type="reset" name="btnReset" class="action_button" value="<?php echo $btnReset; ?>" />
									<input type="button" class="action_button" name="cancel" value="<?php echo ADMIN_COMMON_BUTTON_CANCEL;?>" onclick="javascript:document.location.href='<?php echo FILE_ADMIN_CMS; ?>';return true;"/>
								</td>
							</tr>
							<tr><td>&nbsp;</td></tr>
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