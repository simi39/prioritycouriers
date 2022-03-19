<?php

	/**
	 * This file is for adding of  Faq's for the Faq Management.
	 *
	 *
	 * @author     Radixweb <team.radixweb@gmail.com>
	 * @copyright  Copyright (c) 2008, Radixweb
	 * @version    1.0
	 */
		
	/**
	 * Include commom file
	 */
	require_once("../lib/common.php");
	require_once(DIR_WS_MODEL."/TestimonialMaster.php");
	require_once(DIR_WS_ADMIN_LANGUAGES . DIR_CURRENT_LANGUAGE. "/testimonial.php");
	 
    /**
     * Fck details
     */
	$sBasePath = DIR_HTTP_FCKEDITOR;
	
	/**
	 * Object Declaration
	 */
	$testimonialMstObj = new TestimonialMaster();
	$testimonialMstObj = $testimonialMstObj->Create();
	$testimonialDataObj= new TestimonialData();
	
	/**
	 * To create link 
	 */
	$pagenum = ($_GET['pagenum']!="")?($_GET['pagenum']):(1);
	if(!empty($pagenum))
	{
		$err['pagenum'] = isNumeric(valid_input($pagenum),ENTER_NUMERIC_VALUES_ONLY);
	}
	if(!empty($err['pagenum']))
	{
		logOut();
	}
	$preference = new Preferences();
	$URLParameters=$preference->GetAddressBarQueryString($NotToPass);
	if ($URLParameters!='') {
		$URLParameters="&".$URLParameters;
	}
	
	/**
	 * Variable Declaration 
	 */
	$tid           = trim($_GET['tid']);
	if(!empty($tid))
	{
		$err['tid'] = isNumeric(valid_input($tid),ENTER_NUMERIC_VALUES_ONLY);
	}
	if(!empty($err['tid']))
	{
		logOut();
	}
	$subheading    = ADMIN_TESTIMONIAL_ADD;
	$status        = $_POST['status'];
	if(!empty($status))
	{
		$err['status'] = isNumeric(valid_input($status),ENTER_NUMERIC_VALUES_ONLY);
	}
	if(!empty($err['status']))
	{
		logOut();
	}
	$sortorder	   = trim($_POST['txtsortorder']);
	
	$btntestimonial = trim($_POST['btntestimonial']);
	$title         = ADMIN_TESTIMONIAL_MANAGEMENT_ADD;
	
	/*csrf validation*/
	$csrf = new csrf();
	$csrf->action = "testimonial_action";
	if(!isset($_POST['ptoken']))
	{
		$ptoken = $csrf->csrfkey();
	}

	
	/*csrf validation*/

	
	/**
	 *Include Necessary files
	 */
	
	$arr_javascript_include[] = 'testimonial_action.php';
	$arr_css_exclude[] = DIR_HTTP_ADMIN_CSS.'jquery.css';
	$arr_javascript_plugin_include[] = 'datatables/datatables.min.js';

	$arr_css_plugin_include[] = 'datatables/datatables.min.css';
	$arr_css_plugin_include[] = 'datatables/Buttons-1.6.5/css/buttons.dataTables.min.css';
	// Add edit action takes place on click of the button
	if(isset($btntestimonial) && !empty($btntestimonial)){
		if(isEmpty(valid_input($_POST['ptoken']), true)){	
			logOut();
		}else{
			//$csrf->checkcsrf($_POST['ptoken']);
		}
		$testimonial_title = $_POST['txt_title'];
		$description = $_POST['description'];
		if($_POST['txtsortorder']!="")
		{
			$err['txtsortorder'] = isNumeric($_POST['txtsortorder'],ENTER_NUMERIC_VALUES_ONLY);
		}
		
		$Svalidation = false;
		foreach($siteLanguage as $languagesite) {
			
			$languagesiteid = $languagesite['site_language_id'];
			
			if($description[$languagesiteid]=="<br/>"){
				$languageDescription ="";
			}else {
				$languageDescription = $description[$languagesiteid];
			}
			
			$err['err_question'][$languagesiteid]	= isEmpty( $testimonial_title[$languagesiteid], ADMIN_TESTIMONIAL_REQUIRED )?isEmpty( $testimonial_title[$languagesiteid], ADMIN_TESTIMONIAL_REQUIRED ):checkStr($testimonial_title[$languagesiteid]);     
			$err['err_answer'][$languagesiteid]		= isEmpty( $description[$languagesiteid], ADMIN_TESTIMONIAL_DESCRIPTION_REQUIRED );
			
			if(!empty($err['err_answer'][$languagesiteid]) ||  !empty($err['err_question'][$languagesiteid]) || !empty($err['txtsortorder'][$languagesiteid])){
				$Svalidation=true;
				$ptoken = $csrf->csrfkey();
			}
		 }
		
				
		if($Svalidation == false)
		{ 
			if(empty($status)){
				$status =0;
			}

			$testimonialDataObj->status       = $status;
			$testimonialDataObj->sortorder    = $sortorder;
			$testimonialDataObj->site_id      = SELECT_SITE_DOMAIN_ID;
			if(isset($tid) && $tid!=''){
				//Edits data to the testimonial table
				$testimonialDataObj->testimonial_id = $tid;
				$testimonialMstObj->editTestimonial($testimonialDataObj);
			}else {
				//Adds data to the testimonial table
			    $tid = $testimonialMstObj->addTestimonial($testimonialDataObj);
			}
			
			$testimonialDataObj = new TestimonialData();
			foreach($siteLanguage as $languagesite) {
				
				$languagesiteid 						     = $languagesite['site_language_id'];
				$testimonialDataObj->testimonial_id 	 	 = $tid;				
				$testimonialDataObj->testimonial_title 		 = $testimonial_title[$languagesiteid];
				$testimonialDataObj->testimonial_description = $description[$languagesiteid];
				$testimonialDataObj->site_language_id        = $languagesiteid;
				
				if($_POST['thisaction'][$languagesiteid] == 'edit'){
					/*Edit data to the faq_description table*/
					$testimonialMstObj->editTestimonialDescription($testimonialDataObj);
					$message        = MSG_EDIT_SUCCESS;
				}elseif($_POST['thisaction'][$languagesiteid] == 'add'){
				    /*Adds data to the faq_description table*/
					$testimonialMstObj->addTestimonialDescription($testimonialDataObj);
					$message        = MSG_ADD_SUCCESS;
				}
				
			}
			header("location:".FILE_ADMIN_TESTIMONIAL."?pagenum=".$pagenum."&message=".$message);
			exit;
		}
	}
	
	/* Get details for a particular id*/
	if(isset($tid) && $tid!='') {
		$seaArr[] =	array('Search_On'=>'testimonial_id',
						'Search_Value'=>$tid,
						'Type'=>'int',
						'Equation'=>'=',
						'CondType'=>'AND',
						'Prefix'=>'',
						'Postfix'=>'');
		$testimonialResult    = $testimonialMstObj->getTestimonial(null,$seaArr);
		$testimonialResult    = $testimonialResult[0];		
		$subheading   = ADMIN_TESTIMONIAL_EDIT;
		$title        = ADMIN_TESTIMONIAL_MANAGEMENT_EDIT;
	} 
	   
	 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo $title; ?></title>
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
<table width="100%" border="0" cellspacing="0" cellpadding="0" id="main" align="center">
	<tr>
		<td valign="top">
		<?php require_once(DIR_WS_ADMIN_INCLUDES . ADMIN_FILE_HEADER);?>
		</td>
	</tr>
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
						<table border="0" class="middle_right_content" width="100%" cellpadding="0" cellspacing="0"  align="center">
						    <tr>
								<td align="left" class="breadcrumb">
										<span><a href="<?php echo FILE_WELCOME_ADMIN; ?>"><?php echo ADMIN_HEADER_HOME; ?></a> > <a href="<?php echo FILE_ADMIN_TESTIMONIAL."?pagenum=".$pagenum; ?>"><?php echo ADMIN_HEADER_TESTIMONIAL_MANAGEMENT;?></a> > <?php echo $subheading; ?></span>
										<div><label class="top_navigation"><a href="<?php echo FILE_ADMIN_TESTIMONIAL."?pagenum=".$pagenum;?>"><?php echo ADMIN_COMMON_BACK; ?></a></label></div>
								</td>
							</tr>
							<tr>
								<td class="heading">
									<?php echo $subheading; ?>
								</td>
							</tr>										
							<tr><td class="message_mendatory" align="right"><?PHP echo  ADMIN_COMMAN_REQUIRED_INFO;?></td></tr>
							<tr>
								<td align="left">
									<form name="frmaddtestimonial" action="" method="POST" enctype="multipart/form-data" >
									<table border="0" width="100%" cellpadding="0" cellspacing="0"  align="center">
										
										<tr>
											<td colspan="2">
												<div id="TabbedPanels1" class="TabbedPanels" >
												<ul class="TabbedPanelsTabGroup">
												   <?php foreach($siteLanguage as $arrid => $languagesite) { ?>
													<li class="TabbedPanelsTab" tabindex="<?php echo $arrid; ?>" ><?php echo valid_output($languagesite['site_language_name']);?></li>
													<?php } ?>
												</ul>
												<div class="TabbedPanelsContentGroup" >
												 <?php 
												 		$i=0;
														foreach($siteLanguage as $arrid => $languagesite) {
														$languagesiteid = $languagesite['site_language_id'];
												  		$hvalue = 'add';
												  	   	if($tid!=''){
														// when Editing Cms Record
														
														$testimonialSearchArr = array();
														$testimonialSearchArr[] = array('Search_On'=>'testimonial_id', 'Search_Value'=>$tid, 'Type'=>'int', 'Equation'=>'=','CondType'=>'AND', 'Prefix'=>'', 'Postfix'=>'');
														$testimonialSearchArr[] = array('Search_On'=>'site_language_id', 'Search_Value'=>$languagesite['site_language_id'], 'Type'=>'int', 'Equation'=>'=','CondType'=>'AND', 'Prefix'=>'', 'Postfix'=>'');
														$testimonialdata = $testimonialMstObj->getTestimonialDescription(null,$testimonialSearchArr);
														if($testimonialdata!= '') {
															$testimonialdata= $testimonialdata[0];
															$hvalue = 'edit';
														}
													} ?>
													<div class="TabbedPanelsContent" >
													<input type="hidden" name="thisaction[<?php echo $languagesite->site_language_id; ?>]" value="<?php echo $hvalue; ?>" >
													<table width="100%" border="0" cellpadding="0" cellspacing="0" >
														<tr><td colspan="2">&nbsp;</td></tr>
														<tr>
															<td align="left" width="19%" nowrap ><?php echo ADMIN_TESTIMONIAL_TITLE;?></td>
													<?php 
														$txtquestion = $testimonialdata['testimonial_title'];
													 	if(isset($_POST['txtquestion[' .$languagesiteid.']'])) {
											                     			$txtquestion = $_POST['txtquestion[' .$languagesiteid.']'];
											                     		}
											                     	?>
															<td class="message_mendatory" width="81%"><input type="text" id="txt_title" name="txt_title[<?php echo $languagesiteid;?>]" style="width:250px;" value="<?php  echo valid_output($txtquestion); ?>" class="register"><span> *</span></td>
														</tr>
														<tr>
															<td align="left" >&nbsp;</td>
															<td class="message_mendatory" id="testimonialNameError"><?php if(isset($err['err_question'][$i+1])) { echo $err['err_question'][$i+1]; } ?></td>
														</tr>
														<tr>
															<td align="left" valign="top"><?php echo ADMIN_TESTIMONIAL_DESCRIPTION;?></td>
															<td class="message_mendatory" valign="top">
															<?php
																
																if(isset($_POST['description['.$languagesiteid.']'])) {
																	$testimonial_desc = $description[$languagesiteid];
																}else{
														         	$testimonial_desc = $testimonialdata['testimonial_description'];
															    }
															         	
														        ?>
																<textarea cols="80" id="description[<?php echo $languagesiteid; ?>]" name="description[<?php echo $languagesiteid; ?>]" rows="10"><?php echo htmlspecialchars($testimonial_desc); ?></textarea>
																<script>
																CKEDITOR.replace( 'description[<?php echo $languagesiteid; ?>]' );
																</script>
																</td>
														</tr>
														<tr>
															<td align="left" nowrap >&nbsp;</td>
															<td class="message_mendatory" id="descError"><?php if(isset($err['err_answer'][$i+1])) { echo $err['err_answer'][$i+1]; } ?></td>
														</tr>
													</table>
												  </div>
												  <?php $i++;												
													}?>												      
												</div>
											</div>
											</td>
										</tr>
										<tr><td colspan="2">&nbsp;</td></tr>												
										
										<tr>
											<td align="left" width="20%" nowrap ><?php echo ADMIN_COMMON_STATUS;?></td>
											<td width="80%">
											<select name="status" >
												<option value="1"  selected ><?php echo ADMIN_COMMON_STATUS_ACTIVE;?></option>
												<option value="0" <?php if($testimonialResult['status']==0 && $testimonialResult['status']!=null) {?> selected <?php }?>><?php echo ADMIN_COMMON_STATUS_INACTIVE;?></option>
											</select>
											</td>
										</tr>
										<tr>
											<td align="left" width="18%" nowrap >&nbsp;</td>
											<td class="message_mendatory" id="statusError" ><? if(isset($err['Answer'])) { echo $err['Answer']; } ?></td>
										</tr>
										<tr>
											<td align="left" width="18%" nowrap ><?php echo ADMIN_COMMON_SORT_ORDER;?></td>
											<td><input type="text" style="width:30px;" name="txtsortorder" value="<?php echo $testimonialResult['sortorder']; ?>" class="register"></td>
										</tr>
										<tr>
											<td align="left" width="18%" nowrap >&nbsp;</td>
											<td class="message_mendatory"><?php if(isset($err['txtsortorder']) && $err['txtsortorder']!=""){ echo $err['txtsortorder']; } ?>&nbsp;</td>
										</tr>
										<tr>
											<td align="left" width="18%" nowrap >&nbsp;</td>
											<td align="left">
										<?php if(isset($fid) && $fid!='') {?>
											<input type="submit" class="action_button" name="btntestimonial" value="<?php echo $subheading;?>" onclick="return validation();" >
										<?php } else {?>
									    	<input type="submit" class="action_button" name="btntestimonial" value="<?php echo $subheading;?>" onclick="return validation();" >
										<?php } ?>
											<input type="hidden" size="34" id="ptoken" value="<?php echo $ptoken; ?>" name="ptoken">
											<input type="reset" class="action_button" name="btnreset" value="<?php echo ADMIN_COMMON_BUTTON_RESET?>" >
											<input type="button"  class="action_button" name="cancel" tabindex="10" value="<?php echo ADMIN_COMMON_BUTTON_CANCEL;?>" onclick="javascript:document.location.href='<?php echo FILE_ADMIN_TESTIMONIAL."?pagenum=".$pagenum; ?>';return true;"/>
											</td>
										</tr>
									    <tr>
											<td>&nbsp;</td>
											<td>&nbsp;</td>
										</tr>
									</table>
									</form>
								</td>
							</tr>
			   			</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr><td id="footer"><?php require_once(DIR_WS_ADMIN_INCLUDES."/".ADMIN_FILE_FOOTER);?></td></tr>
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
