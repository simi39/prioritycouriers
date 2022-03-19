<?php

/**
* This file is upload image
*
* @author     Radixweb <team.radixweb@gmail.com>
* @copyright  Copyright (c) 2008, Radixweb
* @version    1.0
* @since      1.0
*/

/**
 * Common File Inclusion
 * 
 */
require_once("../lib/common.php");
require_once(DIR_WS_MODEL."/FormsCalculatorMaster.php");
require_once(DIR_WS_MODEL."/UploadFileMaster.php");
require_once(DIR_WS_ADMIN_LANGUAGES . DIR_CURRENT_LANGUAGE. "/forms_calculator.php");	 
/**
* Inclusion and Exclusion Array of Javascript
*/

$arr_css_plugin_include[] = 'datatables/css/jquery.dataTables.min.css';	
$arr_javascript_plugin_include[] = 'datatables/js/jquery.dataTables.min.js';
$start     = (!empty($_GET['startRow']))?$_GET['startRow']:0;  //Paging Variable
if($start != '')
{
	$err['start'] = isNumeric($start,ENTER_VALUE_IN_NUMERIC);
}
if(!empty($err['start']))
{
	logOut();
}
$action	     = trim($_GET['edit']);
if($action != '')
{
	$err['action'] = chkStr($action);
}
if(!empty($err['action']))
{
	logOut();
}
$message = $arr_message[$_GET['message']];// Message Variable            
if(!empty($message))
{
	$err['message'] = specialcharaChk(valid_input($message));
}
if(!empty($err['message']))
{
	logOut();
}

/*csrf validation*/
$csrf = new csrf();
$csrf->action = "forms_calulator";
if(!isset($_POST['ptoken'])) {
	$ptoken = $csrf->csrfkey();
}


/*csrf validation*/


/**
 * Object Declaration
 * 
 */
$ObjUplaodFileMaster = new UplaodFileMaster();
$ObjUplaodFileMaster = $ObjUplaodFileMaster->Create();
$ObjFormsCalculatorMaster = new FormsCalculatorMaster();
$ObjFormsCalculatorMaster = $ObjFormsCalculatorMaster->create();
$ObjFormsCalculatorData = new FormsCalculatorData();

$path_forms=SITE_DOCUMENT_ROOT."pdf/forms/";

$err['title'] = isEmpty($_POST["title"], LINK_NAME_REQUIRED)?isEmpty($_POST["title"], LINK_NAME_REQUIRED):checkStr($_POST["title"]);
$err['url'] = isEmpty($_POST["url"], ADMIN_URL_REQUIRED)?isEmpty($_POST["url"], ADMIN_URL_REQUIRED):validURL(valid_input($_POST["url"]));	
if($_POST['link_type'] != '')
{
	$err['link_type'] = isNumeric($_POST['link_type'],ENTER_VALUE_IN_NUMERIC);
}
if(!empty($err['link_type']))
{
	logOut();
}
foreach ($err as $key => $val){
	if($val != "") {
		$Svalidation=true;																
		$ptoken = $csrf->csrfkey();					
	}
}
/*
echo "<pre>";
print_R($err);
echo "</pre>";
*/
//exit();
if(isset($_POST['btnadddata']) && !empty($_POST['btnadddata']) && isset($_POST["edit"]) && $Svalidation == false) {
	if(isEmpty(valid_input($_POST['ptoken']), true)){	
			logOut();
	}else{
		//$csrf->checkcsrf($_POST['ptoken']);
	}
	$seaArr[]	=	array('Search_On'    => 'frm_id',
	                      'Search_Value' => (int)$_POST["edit"],
	                      'Type'         => 'int',
	                      'Equation'     => '=',
	                      'CondType'     => 'AND',
	                      'Prefix'       => '',
	                      'Postfix'      => '');
	$ObjFormsCalculatorData = $ObjFormsCalculatorMaster->getFormsCalculator("*",$seaArr);
	$ObjFormsCalculatorData=$ObjFormsCalculatorData[0];
	$ObjFormsCalculatorData->title=$_POST["title"];
	$ObjFormsCalculatorData->link_url=$_POST["url"];
	$ObjFormsCalculatorData->link_type=$_POST["link_type"];
	if($_POST["link_type"]==2) {
		if (isset($_FILES['uploadphoto']['name']) && ($_FILES['uploadphoto']['name']) != '') {
			$Arr_extension = array("pdf", "PDF","DOC","doc");
			$file_validation = $ObjUplaodFileMaster->uploadvalidation('uploadphoto', $Arr_extension, MAX_UPLOAD_SIZE);
			//print_r($file_validation);
			//exit;
			if(empty($file_validation)) {
				$fp=file($_FILES['uploadphoto']['tmp_name']);
				$old_path=$ObjFormsCalculatorData->link_path;
				$ObjFormsCalculatorData->link_path=$ObjUplaodFileMaster->UploadFile('uploadphoto',$path_forms);
				$ObjUplaodFileMaster->DeleteFile($old_path,$path_forms); //remove file
			} else {
				header("Location: ".FILE_ADMIN_FORMS_AND_CALCULATOR_LISTING."?pagenum=".$pagenum."&message=ur&edit=".$_POST["edit"]);
				exit;
			}
		} else if($_POST["path"]=="") {
			header("Location: ".FILE_ADMIN_FORMS_AND_CALCULATOR_LISTING."?pagenum=".$pagenum."&message=upr&edit=".$_POST["edit"]);
			exit;
		}
	}	
	$ObjFormsCalculatorMaster->editFormsCalculator($ObjFormsCalculatorData);
	header("Location: ".FILE_ADMIN_FORMS_AND_CALCULATOR_LISTING."?pagenum=".$pagenum."&message=es");
	exit;
	
} else if(isset($_POST['btnadddata']) && !empty($_POST['btnadddata']) && $Svalidation == false) {
	if(isEmpty(valid_input($_POST['ptoken']), true)){	
				logOut();
	}else{
		//$csrf->checkcsrf($_POST['ptoken']);
	}
	$ObjFormsCalculatorData->title=$_POST["title"];
	$ObjFormsCalculatorData->link_url=$_POST["url"];
	$ObjFormsCalculatorData->link_type=$_POST["link_type"];
	if($_POST["link_type"]==2) {
		if (isset($_FILES['uploadphoto']['name']) && ($_FILES['uploadphoto']['name']) != '') {
			$Arr_extension = array("pdf", "PDF","DOC","doc");
			$file_validation = $ObjUplaodFileMaster->uploadvalidation('uploadphoto', $Arr_extension, MAX_UPLOAD_SIZE);
			//print_r($file_validation);
			//exit;
			if(empty($file_validation)) {
				$fp=file($_FILES['uploadphoto']['tmp_name']);
				$ObjFormsCalculatorData->link_path=$ObjUplaodFileMaster->UploadFile('uploadphoto',$path_forms);
			} else {
				header("Location: ".FILE_ADMIN_FORMS_AND_CALCULATOR_LISTING."?pagenum=".$pagenum."&message=ur");
				exit;
			}
		} else if($_POST["path"]=="") {
			header("Location: ".FILE_ADMIN_FORMS_AND_CALCULATOR_LISTING."?pagenum=".$pagenum."&message=upr");
			exit;
		}
	}
	$ObjFormsCalculatorData->status=1;
	$ObjFormsCalculatorMaster->addFormsCalculator($ObjFormsCalculatorData);
	header("Location: ".FILE_ADMIN_FORMS_AND_CALCULATOR_LISTING."?pagenum=".$pagenum."&message=as");
	exit;
} else {
		$seaArr[]	=	array('Search_On'    => 'frm_id',
	                      'Search_Value' => (int)$_GET["edit"],
	                      'Type'         => 'int',
	                      'Equation'     => '=',
	                      'CondType'     => 'AND',
	                      'Prefix'       => '',
	                      'Postfix'      => '');
	$ObjFormsCalculatorData = $ObjFormsCalculatorMaster->getFormsCalculator("*",$seaArr);
	$ObjFormsCalculatorData=$ObjFormsCalculatorData[0];
}
		
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<title><?php echo ADMIN_FORMS_AND_CALCULATOR_MANAGEMENT;?></title>
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
 
<script language="javascript" type="text/javascript">
function pdf(abc) {
	if(abc==2) {
		document.getElementById("url").setAttribute("readonly","true");
		document.getElementById("url").value="<?php echo DIR_HTTP_PDF.'forms/';?>"
		document.getElementById("upl").style.visibility="visible";
		document.getElementById("upld").style.visibility="visible";
	} else {
		document.getElementById("url").removeAttribute("readonly","");
		document.getElementById("url").value="";
		document.getElementById("upl").style.visibility="hidden";
		document.getElementById("upld").style.visibility="hidden";
	}
}
function checkfrm() {
	if(document.getElementById("title").value=="") {
		alert("Please Enter Title");
		document.getElementById("title").focus();
		return false;
	} else if(document.getElementById("url").value=="") {
		alert("Please Enter URL");
		document.getElementById("url").focus();
		return false;
	} else if(!isValidURL(document.getElementById("url").value)) {
		alert("Please Enter Valid URL");
		document.getElementById("url").focus();
		return false;
	} else if(document.getElementById("path").value == "" && document.getElementById("link_type").value==2 && document.getElementById("uploadphoto").value == "") {
		alert("Upload File");
		document.getElementById("uploadphoto").focus();
		return false;
	}
}
function isValidURL(url){
    var RegExp = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/;
    if(RegExp.test(url)){
        return true;
    }else{
        return false;
    }
}
</script>
<?php if($ObjFormsCalculatorData->link_type != 2) {?>
<style type="text/css">
#upl, #upld { visibility:hidden;}
</style>
<?php }?>
<style type="text/css">
input[type="text"]{width:500px !important;}
</style>
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
								<span><a href="<?php echo FILE_WELCOME_ADMIN; ?>"><?php echo ADMIN_HEADER_HOME;?></a> ><?php echo ADMIN_HEADER_FORMS_AND_CALCULATOR_MANAGEMENT;?></span>
								<div><label class="top_navigation"><a href="<?php echo FILE_ADMIN_FORMS_AND_CALCULATOR_LISTING;?>">Back</a></label></div>
								</td>
							</tr>
							<tr>
								<td class="heading">&nbsp;</td>
							</tr>
							
							<?php if(!empty($message)){  // Start If :: Message Display  ?>
							<tr>
								<td class="message_success" align="center">
							
								<?php echo valid_output($message) ; ?></td>
							</tr>
							<tr><td >&nbsp;</td></tr>
							<?php }  // End If :: Message Display  ?>
						<?php if(isset($file_validation['uploadphoto']) && ($file_validation['uploadphoto'] !='')) {?>
						<tr>
							<td  align="center" class="ErrorMessage message_success">
							<?php if ($file_validation['uploadphoto'] == 'extError') { echo UPLOAD_GALLERY_EXT_ERROR; }?>
							<?php if ($file_validation['uploadphoto'] == 'sizeError') { echo UPLOAD_GALLERY_SIZE_ERROR; }?>
							<?php if ($file_validation['uploadphoto'] == 'ExistError') { echo UPLOAD_GALLERY_EXIST_ERROR; }?>
							<?php if ($file_validation['uploadphoto'] == 'uploadError') { echo UPLOAD_GALLERY_ERROR; }?>
							</td>
						</tr>
						<tr><td>&nbsp;</td></tr>
						<?php }?>
						
						<tr>
							<td align="left">
								<table border="0" width="100%" cellspacing="0" cellpadding="0" summary="Layout Purposes" align="center">
									<tr>
										<td class="tableborcolor" valign="top" >											
											<form name="advertiseadd" action="" method="POST" enctype="multipart/form-data"> 
											<fieldset>
												<legend class="filter"><?php if(isset($_GET["edit"])) {echo "Edit";} else { echo "Add";}?> Forms And Calculator</legend>
												<table width="100%" border="0" cellspacing="2" cellpadding="0" align="center" height="20" >
												<?php if($err["SelectSec"] != ''){?>
													<tr><td colspan="3"><span class="message_mendatory" ><?php echo $err["SelectSec"]; ?></span></td></tr>
												<?php } ?>
												<tr>
													<td align="right"><b>Link Title</b>&nbsp;</td>
													<td><input type="text" name="title" id="title" value="<?php if($ObjFormsCalculatorData->title!=''){echo valid_output($ObjFormsCalculatorData->title);}else{ echo valid_output($_POST['title']);}?>"></td>
												</tr>
												<tr>
													<td></td>
													<td class="message_mendatory"><?php if(isset($err['title']) && $err['title']!=""){ echo $err['title'];} ?></td>
												</tr>							
												<tr>
													<td align="right"><b>Type</b></td>
													<td><select name="link_type" id="link_type" onchange="pdf(this.value)">
															<option value="1" <?php if($ObjFormsCalculatorData->link_type=="1"){ echo "selected";}?>>Normal Link</option>
															<option value="2" <?php if($ObjFormsCalculatorData->link_type=="2"){ echo "selected";}?>>PDF / DOC File</option>
															<?php //<option value="3" onclick="javascript:pdf(2);" <?php if($ObjFormsCalculatorData->link_type=="3"){ echo "selected";}>>Print</option> ?>
														</select></td>
												</tr>
												
												<tr>
													<td align="right"><b>Link URL</b>&nbsp;</td>
													<td><input type="text" name="url" id="url" value="<?php echo valid_output($ObjFormsCalculatorData->link_url.$ObjFormsCalculatorData->link_path);?>" ></td>
												</tr>
												<tr>
													<td></td>
													<td class="message_mendatory"><?php if(isset($err['url']) && $err['url']!=""){ echo $err['url'];} ?></td>
												</tr>							
													<tr>
														<td align="right" class="caption"><div id="upl"><b>Upload File</b>&nbsp;</div>														
														<td align="left"><div id="upld"><input name="uploadphoto" type="file" id="uploadphoto" class="formstyle" ></div></td></td>
														<td align="center"><!--<a href="<?php //echo FILE_ADMIN_BANNER; ?>?generate=gallary" class="seeall" /><b style="font-size:15px;"><? //TOP_BANNER_INSTRUCTION3?></b></a><br><? //TOP_BANNER_INSTRUCTION2?>--></td>
													</tr>
													
													<tr>
														<td align="right">&nbsp;</td>
														<td align="left" colspan="2">
														<input type="hidden" size="34" id="ptoken" value="<?php echo $ptoken; ?>" name="ptoken">
														<?php if(isset($_GET["edit"])) { ?>
														<input type="hidden" name="edit" id="edit" value="<?php echo valid_output($_GET["edit"]);?>">
														<input type="hidden" name="path" value="<?php echo $ObjFormsCalculatorData->link_path;?>" id="path">
														<input name="btnadddata" type="submit" value="Update" onclick="return checkfrm();" class="action_button">
														<?php } else {?>
														<input name="btnadddata" type="submit" value="Save" onclick="return checkfrm();" class="action_button"> <?php }?>
														<input name="btnadddata" type="reset" onclick="javascript:document.location='<?php echo FILE_ADMIN_FORMS_AND_CALCULATOR_LISTING;?>'" value="Cancel" class="action_button">
														</td>
													</tr>	
												</table>
											</fieldset>
											</form>
											
										</td>
									</tr>
									<tr><td>&nbsp;</td></tr>
			 					</table>
			 				</td>
			 			</tr>
			 			<tr>
							<td>&nbsp;</td>
						</tr		
					</table>
				</td>
	       	</tr>
		    </table>
				</td>
	       	</tr>
	<tr><td id="footer"><?php require_once(DIR_WS_ADMIN_INCLUDES . ADMIN_FILE_FOOTER);?></td></tr>
</table>
</body>
</html>
