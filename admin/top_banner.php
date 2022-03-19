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
require_once(DIR_WS_MODEL."/BannerImageMaster.php");
require_once(DIR_WS_MODEL."/UploadFileMaster.php");
require_once(DIR_LIB_PEAR . "Pager.php");
require_once(DIR_WS_ADMIN_LANGUAGES . DIR_CURRENT_LANGUAGE. '/top_banner.php');



/**
* Inclusion and Exclusion Array of Javascript
*/

$arr_javascript_include[] = "jquery.dataTables.js";
$arr_javascript_plugin_include[] = 'bootstrap/js/bootstrap.min.js';
$arr_javascript_plugin_include[] = 'ddaccordion/js/ddaccordion.js';

$start     = (!empty($_GET['startRow']))?$_GET['startRow']:0;  //Paging Variable
if($start != '')
{
	$err['start'] = isNumeric($start,ENTER_VALUE_IN_NUMERIC);
}
if(!empty($err['start']))
{
	logOut();
}


$message = $arr_message[$_GET['message']];            
if(!empty($message))
{
	$err['message'] = specialcharaChk(valid_input($message));
}
if(!empty($err['message']))
{
	logOut();
}	
$imageId   = $_GET["imageid"];

if($imageId != '')
{
	$err['imageId'] = isNumeric($imageId,ENTER_VALUE_IN_NUMERIC);
}
if(!empty($err['imageId']))
{
	logOut();
}

/*csrf validation*/
$csrf = new csrf();
$csrf->action = "top_banner";
if(!isset($_POST['ptoken'])) {
	$ptoken = $csrf->csrfkey();
}
/*csrf validation*/

if(!empty($_GET['action']))
{
	$err['action'] = chkStr(valid_input($_GET['action']));
}
if(!empty($err['action']))
{
	logOut();
}

if(!empty($_GET['generate']))
{
	$err['generate'] = chkStr(valid_input($_GET['generate']));
}
if(!empty($err['generate']))
{
	logOut();
}

/**
 * Object Declaration
 * 
 */
$ObjUplaodFileMaster = new UplaodFileMaster();
$ObjUplaodFileMaster = $ObjUplaodFileMaster->Create();
$ObjBannarImageMaster = new BannerImageMaster();
$ObjBannarImageMaster = $ObjBannarImageMaster->Create();
$ObjBannarImageData = new BannerImageData();

$UploadImagePath = DIR_IMAGE_FLASHGALLARY_LARGE;
$UploadImagePath_thumb = DIR_IMAGE_FLASHGALLARY_THUMB;
	
/**
 * Delete Uploaded images
 */

	if($_GET['action'] == 'Delete' && $imageId != '') {
		
		$seaArr[]	=	array('Search_On'=>'banner_image_id','Search_Value'=>$imageId,'Type'=>'int','Equation'=>'=','CondType'=>'AND','Prefix'=>'','Postfix'=>'');
		$CurrentGalleryData = $ObjBannarImageMaster->getBannerImage(null,$seaArr);
		
		$orgFilePath = $UploadImagePath . "/" . $CurrentGalleryData[0]['banner_image_name'];
		$thumbFilePath = $UploadImagePath_thumb . "/" . $CurrentGalleryData[0]['banner_image_name'];

		if(file_exists($orgFilePath) && $CurrentGalleryData[0]['banner_image_name'] != '') {
			unlink($orgFilePath);
		}

		if(file_exists($thumbFilePath) && $CurrentGalleryData[0]['banner_image_name'] != '') {
				unlink($thumbFilePath);
		}

		$ObjBannarImageMaster->DeleteBannerImage($imageId);
		header("Location:".FILE_ADMIN_BANNER."?message=".MSG_DEL_SUCCESS);
		exit;
	}
	
/**
 *    Image upload , type validation, converting to jpg images 
 */
	
	if(isset($_POST['btnadddata']) && !empty($_POST['btnadddata'])) {
		
		if(isEmpty(valid_input($_POST['ptoken']), true)){	
				logOut();
		}else{
			$csrf->checkcsrf($_POST['ptoken']);
		}
		
		if(!empty($_POST['uploadlink']))
		{
			$err['link'] = validURL($_POST['uploadlink']);
		}
		
		
		foreach($err as $key => $Value) {
			if($Value != '') {
				$Svalidation=true;
				$ptoken = $csrf->csrfkey();
			}
		}
		if ($Svalidation==false && isset($_FILES['uploadphoto']['name']) && ($_FILES['uploadphoto']['name']) != '') {
			$Arr_extension = array("gif", "jpg", "jpeg", "tif", "tiff");
			$file_validation = $ObjUplaodFileMaster->uploadvalidation('uploadphoto', $Arr_extension, MAX_UPLOAD_SIZE);

			if(empty($file_validation) && $err['link']=="") {
				$Upload_FileName = ''; 
				$image_extension = getimageextension($_FILES['uploadphoto']['name']);

				$Upload_FileName = $ObjUplaodFileMaster->UploadFile('uploadphoto', $UploadImagePath);
				$upload_image_dir_path = $UploadImagePath . $Upload_FileName;

				
				if(strtolower($image_extension)=="tif" || strtolower($image_extension)=="tiff" ) {
					$Upload_FileName = basename($Upload_FileName,".{$image_extension}") .'.jpg';
				}

			    $upload_image_dir_path = $UploadImagePath . "/" . $Upload_FileName;

				$Upload_thumb_img = createthumbImageforflashgallary($upload_image_dir_path,$Upload_FileName,$UploadImagePath_thumb,100,100);

				/*Insert Data in to Banner_Image */
				$ObjBannarImageData->banner_image_name = $Upload_FileName;				
				$ObjBannarImageData->banner_link = $_POST['uploadlink'];
				$ObjBannarImageData->open_target = $_POST['open_target'];
				$ObjBannarImageMaster->AddBannerImage($ObjBannarImageData);

				header("Location:".FILE_ADMIN_BANNER."?message=".MSG_ADD_SUCCESS);
				exit;
			}
		}
	}
		
	$Option=null;
	$resultBanner = $ObjBannarImageMaster->getBannerImage();
	$TotalRes=count($resultBanner);
	if($TotalRes > 0) {
	/**
	 * Code For Paging 
	 */

	
	//$dbpager = new DbPagerAdmin();
	//$PagingResult= $dbpager->CreatePaging($TotalRes, ADMIN_NO_IMAGES_PER_PAGE, ADMIN_NO_PAGE_LINKS, $NotToPassArray);  ////get no of pages through this method
	/*echo "<pre>";
	print_r($resultBanner);
	echo "</pre>";
	exit();*/
	$params1 = array(
    'perPage'    => 3,
    'urlVar'     => 'pageID_articles',  //1st identifier
    'itemData'   => $resultBanner
	);
	$pager1 = & Pager::factory($params1);
	$data1  = $pager1->getPageData();
	$links1 = $pager1->getLinks();
	/**
	 * Code For Fetching Banner Data
	 */	
	$optArr[]	=	array("Order_By" => "banner_image_id","Order_Type" => "ASC");		
	$res = $ObjBannarImageMaster->getBannerImage(null,null,$optArr,$start,ADMIN_NO_IMAGES_PER_PAGE);	
   }
	
if(isset($_GET["generate"]) && !empty($_GET['generate'])) {
	
	$filename = "../data.xml";
	$contents='';
	$contents .= '<?xml version="1.0" encoding="utf-8"?>
	<Banner 	
	bannerWidth="100%"
	bannerHeight="100%"
	bannerBackgroundColor=""
	bannerLoopCount=""
	bannerCornerRadius=""
	buttonsVerticalMargin="0"
	buttonsHorizontalMargin="0"

	textBoldAll=""
	textSize=""
	textColor=""
	textAreaWidth=""
	textLineSpacing="0"	
	textLetterSpacing="-0.5"	
	textMarginLeft="12"
	textMarginBottom="5"
	textBackgroundBlur="yes"
	textBackgroundColor="000000"
	textBackgroundTransparency="20"	
		
	transitionType="1"
	transitionVertical="no"
	transitionDirection="1"
	
	transitionRandomEffects="yes"
	transitionDelayTimeFixed="5" 
	transitionDelayTimePerWord="0.5"
	transitionSpeed="5"
	transitionBlur="no"		
	
	showTimerClock="yes"
	showNextButton="yes"
	showBackButton="yes"
	showNumberButtons="no"
	showNumberButtonsAlways="no"
	showNumberButtonsHorizontal="no"
	showNumberButtonsAscending="yes"
	showPlayPauseOnTimer="no"
	
	alignButtonsLeft="no"
	alignTextTop="no"
	
	autoPlay="yes"	
	imageResizeToFit="yes"
	imageRandomizeOrder="yes"
	>'."\n";
	
	if (!empty($res)) {
		foreach ($res as $Gallery_details) {							
			$contents .= '<item buttonLabel="" image="'.DIR_HTTP_IMAGE_FLASHGALLARY_LARGE_WOSITE.valid_output($Gallery_details->banner_image_name).'" 
		link="'.valid_output($Gallery_details->banner_link).'" 
		target="'.valid_output($Gallery_details->open_target).'" 
		delay="" 
		textBlend="yes" >'."\n";
			$contents .= '</item>'."\n";
		}
	}
	$contents .= '</Banner>';

	if (funFileWright($filename,$contents)) {
		header("Location:".FILE_ADMIN_BANNER."?message=".MSG_PUB_SUCCESS);
		exit;
	}
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<title><?php echo ADMIN_BANNER; ?></title>
<?php 
addCSSFile($arr_css_include,$arr_css_exclude);
addJavaScriptFile($arr_javascript_include,$arr_javascript_exclude);
addPluginJavaScriptFile($arr_javascript_plugin_include,$arr_javascript_plugin_exclude);
?>
<script type="text/javascript">
function popupWindow(url) {
	window.open(url,'popupWindow','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=no,resizable=yes,copyhistory=no,width=10,height=10,top=50,left=50');
}

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
								<span><a href="<?php echo FILE_WELCOME_ADMIN; ?>"><?php echo ADMIN_HEADER_HOME;?></a> > <?php echo ADMIN_HEADER_TOP_BANNER_GALLARY; ?></span>
								</td>
							</tr>
							<tr>
								<td class="heading">
									<?php echo ADMIN_HEADER_TOP_BANNER_GALLARY; ?>
								</td>
							</tr>
							
							<?php if(!empty($message)){  // Start If :: Message Display  ?>
							<tr>
								<td class="message_success" align="center"><?php echo valid_output($message) ; ?></td>
							</tr>
							<tr><td >&nbsp;</td></tr>
							<?php }  // End If :: Message Display  ?>
						<?php if(isset($file_validation['uploadphoto']) && ($file_validation['uploadphoto'] !='')) {?>
						<tr>
							<td  align="center" class="ErrorMessage">
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
												<legend class="filter"><?php echo ADMIN_IMAGE_GALLERY_FILTER_UPLOAD_IMAGE;?></legend>
												<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" height="20" >
												<?php if($err["SelectSec"] != ''){?>
													<tr><td colspan="3"><span class="LoginErrormessage" ><?php echo $err["SelectSec"]; ?></span></td></tr>
												<?php } ?>
													<tr>
														<td align="right" class="caption"><b><?php echo ADMIN_IMAGE_GALLERY_UPLOAD_IMAGE;?> </b>&nbsp;														
														<td align="left"><input name="uploadphoto" type="file" id="uploadphoto" class="formstyle" ></td></td>
														<td align="center"><!--<a href="<?php echo FILE_ADMIN_BANNER; ?>?generate=gallary" class="seeall" /><b style="font-size:15px;"><?=TOP_BANNER_INSTRUCTION3?></b></a><br><?=TOP_BANNER_INSTRUCTION2?>--></td>
													</tr>
													<tr><td colspan="3">&nbsp;</td></tr>
													<tr>
														<td align="right" class="caption"><b>Link </b>&nbsp;</td>
														<td align="left"><input name="uploadlink" type="text" value="<?php if(isset($_POST['uploadlink']) && $_POST['uploadlink']!=""){ echo $_POST['uploadlink'];} ?>" id="uploadlink" class="formstyle" size="35" ></td>
														<td align="center"><?=TOP_BANNER_INSTRUCTION4?></td>
													</tr>
													<tr>
														<td >&nbsp;</td>
														<td colspan="2" class="message_mendatory"><?php if(isset($err['link']) && $err['link'] != ""){ echo $err['link'];} ?>&nbsp;</td>
													</tr>
													<tr>
														<td class="caption" align="right"><b>Open link in </b>&nbsp;</td>
														<td align="left">
															<select name ="open_target" id="open_target">
																<option value="_self">Same Window</a>
																<option value="_blank">New Window</a>
															</select>
														</td> 
														<td align="left">&nbsp;</td>
													</tr>
													<tr><td colspan="3">&nbsp;</td></tr>
													<tr>
														<td align="right"><input type="hidden" size="34" id="ptoken" value="<?php echo $ptoken; ?>" name="ptoken">&nbsp;</td>
														<td align="left" colspan="2"><input name="btnadddata" type="submit" value="Add Banner" class="action_button">&nbsp;<?php echo TOP_BANNER_INSTRUCTION1; ?></td>														
													</tr>	
												</table>
											</fieldset>
											</form>
											
										</td>
									</tr>
									<tr><td>&nbsp;</td></tr>
									<tr>
										<td>
											<table cellpadding="0"  cellspacing="0" class="display">
          						    	 	<?php
									        	if($res != '') { 
													$i = 1;
													$int_temp_cnt= 1;
													$colperrow = ADMIN_NO_IMAGES_PER_ROW;
													//$colClass = 'TableEvenRow';
													$colClass = 'TableEvenRow';
													$rowId = 1;
											 		echo '<tr>';
												 	if($res != '') {
							 							foreach ($res as $Gallery_details) {
							 							if($colClass == 'TableEvenCol') {
															$colClass = 'TableOddCol';
														} else {
															$colClass = 'TableEvenCol';
														}	
							 								
														$thumbPath = DIR_HTTP_IMAGE_FLASHGALLARY_THUMB.$Gallery_details->banner_image_name;
									    		 		$imagePath = DIR_HTTP_IMAGE_FLASHGALLARY_LARGE.$Gallery_details->banner_image_name;
									    		 		
									    		 		$imagePathexploded = explode("images/",$imagePath);
														$imagePathPopup   =  $imagePathexploded[1];
									    		 		if($int_temp_cnt>ADMIN_NO_IMAGES_PER_ROW) {
																		echo '</tr>';
																		echo '<tr>';
																		$int_temp_cnt = 1;
																		$rowId++;
																		if($rowId%2 == 0) {
																			$colClass = 'TableOddCol';
																		} else {
																			$colClass = 'TableEvenCol';
																		}
																	}
												?>
													<td width="<?php echo 100/$colperrow;?>%"  align="center" valign="top" class="<?php echo $colClass; ?>">
														<a href="javascript: void(0)" onclick="popupWindow('../<?php echo FILE_IMAGE_GALLARY_POPUP;?>?imgpath=<?php echo valid_output($imagePathPopup);?>');">
														<img src="<?php echo valid_output($thumbPath);?>" border="0" class="imageborder" /></a>
														<br><?php echo valid_output($Gallery_details->banner_image_name);?>
														<?php if($Gallery_details->banner_link != '') { ?>
															<br>Link :<a href="<?php echo valid_output($Gallery_details->banner_link);?>" target="<?php echo valid_output($Gallery_details->open_target);?>"><?php echo valid_output($Gallery_details->banner_link);?></a>
														<?php } ?>
														<br><a href="<?php echo FILE_ADMIN_BANNER; ?>?imageid=<?php echo $Gallery_details->banner_image_id;?>&action=Delete" class="seeall" onclick="return confirm('Are you sure you want to delete?');">Delete</a>
												    </td>
										 			<?php
													/*if($i%$colperrow == 0){
														echo '</tr>';
													}*/
													$int_temp_cnt++;
													$i++;
														/*if($rowId%2 == 0) {
																$colClass = 'TableOddCol';
															} else {
																$colClass = 'TableEvenCol';
															}	*/							 		
												       } }
													//echo '</tr>';
			 									} else { ?>
			 										<tr>
														<td colspan="3" align="center" class="message_warning"><?php echo RECORDS_NOT_FOUND; ?></td>
													</tr>
												<?php } ?>
				 							</table>
				 						</td>
				 					</tr>							
			 					</table>
			 				</td>
			 			</tr>
			 			<tr>
							<td>&nbsp;</td>
						</tr		
						<?php if($res != ''){?>
						<tr>
							<td align="center"><?php echo $links1;//echo $PagingResult; //  display paging ?></td>
						</tr>
						<tr><td>&nbsp;</td></tr>
						<?php }?>
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
