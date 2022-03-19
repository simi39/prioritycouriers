<?php
/**
	 * This file is for add new admin
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
require_once(DIR_WS_MODEL . "SiteConstantMaster.php");
require_once(DIR_WS_ADMIN_LANGUAGES . DIR_CURRENT_LANGUAGE. '/site_constant.php');
/**
	 * Inclusion and Exclusion Array of Javascript
	 */
//$arr_javascript_include[] = "internal/".FILE_ADMIN_ADD_ADMINISTRATOR;
$arr_javascript_plugin_include[] = "overlib.js";
$arr_css_exclude[] = DIR_HTTP_ADMIN_CSS.'jquery.css';

/**
	 * For creating objects
	 */
$ObjConstantMaster	= new SiteConstantMaster();
$ObjConstantMaster	= $ObjConstantMaster->Create();
$SiteConstantData		=  new SiteConstantData();


/*csrf validation*/
$csrf = new csrf();
$csrf->action = "site_constant";
if(!isset($_POST['ptoken'])) {
	//$ptoken = $csrf->csrfkey();
}

/*csrf validation*/


/**
	 * Variable Declaration and assignment
	 */
$constant_id    = trim($_GET['constant_id']);
if(!empty($constant_id))
{
	$err['constant_id'] = isNumeric(valid_input($constant_id),ENTER_NUMERIC_VALUES_ONLY);
}
if(!empty($err['constant_id']))
{
	logOut();
}

$pagenum = ($_GET['pagenum']!="")?($_GET['pagenum']):(1);
if(!empty($pagenum))
{
	$err['pagenum'] = isNumeric(valid_input($pagenum),ENTER_NUMERIC_VALUES_ONLY);
}
if(!empty($err['pagenum']))
{
	logOut();
}
$AdminId = $_GET['AdminId'];
if(!empty($AdminId))
{
	$err['AdminId'] = isNumeric(valid_input($AdminId),ENTER_NUMERIC_VALUES_ONLY);
}
if(!empty($err['AdminId']))
{
	logOut();
}

if(!empty($_GET['Action']))
{
	$err['Action'] = chkStr(valid_input($_GET['Action']));
}
if(!empty($err['Action']))
{
	logOut();
}
$buttonName     	= ADMIN_ADD_BUTTON;
$HeadingLabel   	= ADMIN_ADD_HEADING;
$constantName       = trim($_POST['constant_name']);
$constantValue   	= trim($_POST['constant_value']);
$PostData       	= false;
if($_GET['Action']=='trash'){
	$ObjConstantMaster->deleteSiteConstant($constant_id);
	$UParam = "?pagenum=".$pagenum."&message=".MSG_DELETE_CONSTANT_SUCCESS;
	header('Location:'.FILE_SITE_CONSTANT_LISTING.$UParam);
}
if($_GET['Action']=='mtrash'){
	$constant_id= $_GET['m_trash_id'];
	$m_t_a=explode(",",$constant_id);
	foreach($m_t_a as $val)
	{
		if(!empty($val))
		{
			$error = isNumeric(valid_input($val),ENTER_NUMERIC_VALUES_ONLY);
			if(!empty($error))
			{
				logOut();
			}else
			{
				$ObjConstantMaster->deleteSiteConstant($val);
			}
		}
		
	}
	$UParam = "?pagenum=".$pagenum."&message=".MSG_DELETE_CONSTANT_SUCCESS;
	//header('Location:'.FILE_SITE_CONSTANT_LISTING.$UParam);
}
$seaArr = array();
if(!empty($constant_id))
{
	$seaArr[]     =	array('Search_On'=>'constant_id', 'Search_Value'=>$constant_id, 'Type'=>'int', 'Equation'=>'=', 'CondType'=>'AND', 'Prefix'=>'', 'Postfix'=>'');
	$ObjConstantMasterData = $ObjConstantMaster->getSiteConstant(null,$seaArr,null,null,null,true,$constant_id,false);
	$buttonName   = ADMIN_EDIT_BUTTON;
	$HeadingLabel = ADMIN_EDIT_HEADING;
}
 

if(!empty($_POST['Submit']))
{
	/*if(isEmpty(valid_input($_POST['ptoken']), true)){	
			logOut();
	}else{
		$csrf->checkcsrf($_POST['ptoken']);
	}*/
	$PostData=true;
	$err['UserNameError'] = isEmpty($constantName, ADMIN_ERROR_ID_REQUIRED)?isEmpty($constantName, ADMIN_ERROR_ID_REQUIRED):chkRestFields($constantName);
	$err['UserEmailError'] = isEmpty($constantValue, ADMIN_ERROR_VALUE_REQUIRED)?isEmpty($constantValue, ADMIN_ERROR_VALUE_REQUIRED):specialcharaChk($constantValue);

	if($constantName=='transit_warranty' || $constantName=='services_volumetric_charges'){
		if(isNumeric(trim($constantValue),ERROR_NUMERIC)){
			$err['UserEmailError'] = $constantName.ERROR_NUMERIC;
		}
	}
	if($constantName=='acl_constant'){
		if(isNumeric(trim($constantValue),ERROR_NUMERIC)){
			$err['UserEmailError'] = $constantName.ERROR_NUMERIC;
		}
	}
	if($constantName=='minimum_charge' ){
		$array = explode("%",trim($constantValue));
		if(count($array)!=2){
			$err['UserEmailError'] = ERROR_MINIMUM_CHARGE;
		}
		if(count($array)==2){
			if(isNumeric(trim($array[0]),ERROR_NUMERIC)){
				$err['UserEmailError'] = ERROR_NUMERIC;
			}
			if(is_integer(trim($array[0]))){
				$err['UserEmailError'] = $array[0].ERROR_NUMERIC;
			}
			if(trim($array[0])=='0'){
				$err['UserEmailError'] = ERROR_MINIMUM_CHARGE_NOT_ZERO;
			}

			if(intval($array[0])>100){
				$err['UserEmailError'] = ERROR_MINIMUM_CHARGE_LESS_THAN_HUNDRED;
			}
		}

	}
	//Checks if error is set or not
	foreach($err as $key => $Value)
	{
		if($Value!= '') {
			$Svalidation=true;
			$csrf->action = "site_constant";
		}
	}
	
	if($Svalidation == false)
	{
		
		$SiteConstantData->constant_name=$constantName;
		$SiteConstantData->constant_value=$constantValue;
		$SiteConstantData->front_group_id='1';
		$seaArr[]     =	array('Search_On'=>'constant_name', 'Search_Value'=>$constantName, 'Type'=>'string', 'Equation'=>'LIKE', 'CondType'=>'AND', 'Prefix'=>'', 'Postfix'=>'');
		$ObjConstantMasterData = $ObjConstantMaster->getSiteConstant(null,$seaArr,null,null,null,true,null,false);
		if(!empty($constant_id))
		{	$ObjConstantMaster->editSiteConstant($SiteConstantData,true,$constant_id);
		$UParam="?pagenum=".$pagenum."&message=".MSG_EDIT_CONSTANT_SUCCESS;
		
		header("Location:".FILE_SITE_CONSTANT_LISTING.$UParam);
		exit();
		} else
		{
			if($ObjConstantMasterData==false || count($ObjConstantMasterData)==0)
			{
				$id = $ObjConstantMaster->addSiteConstant($SiteConstantData);
				$SiteConstantData->constant_id=$id;
				$ObjConstantMaster->addSiteConstantDescription($SiteConstantData);
				$UParam="?pagenum=".$pagenum."&message=".MSG_ADD_CONSTANT_SUCCESS;
				header("Location:".FILE_SITE_CONSTANT_LISTING.$UParam);
				exit;
			}else{
				$err['UserNameError'] = ADMIN_CONSTANT_EXIST;
			}

		}

	}
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php
if(isset($_GET['AdminId']) && !empty($_GET['AdminId'])) {
	echo ADMIN_TITLE_ADMIN_EDIT;
} else {
	echo ADMIN_TITLE_ADMIN_ADD;
}
?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<?php 
addPluginCSSFile($arr_css_plugin_include,$arr_css_plugin_exclude);
addCSSFileAdmin($arr_css_admin_include, $arr_css_admin_exclude);
addJavaScriptFile($arr_javascript_include, $arr_javascript_exclude);
addPluginJavaScriptFile($arr_javascript_plugin_include,$arr_javascript_plugin_exclude);
?>
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
										<span><a href="<?php echo FILE_WELCOME_ADMIN; ?>"><?php echo ADMIN_HEADER_HOME; ?></a> > <a href="<?php echo FILE_SITE_CONSTANT_LISTING."?pagenum=".$pagegnum; ?>"><?php echo ADMIN_CONSTANT_MANAGEMENT; ?></a> > <?php echo $HeadingLabel; ?></span>
										<div><label class="top_navigation"><a href="<?php echo FILE_SITE_CONSTANT_LISTING."?pagenum=".$pagenum; ?>"><?php echo ADMIN_COMMON_BACK; ?></a></label></div>
								</td>
							</tr>
							<tr>
								<td class="heading">
									<?php echo $HeadingLabel; ?>
								</td>
							</tr>
													
											<tr><td class="message_mendatory" align="right"><?PHP echo  ADMIN_COMMAN_REQUIRED_INFO;?></td></tr>
							<tr>
																	<td colspan="4" align="left" valign="top" class="grayheader"><b><?php echo ADMIN_CONSTANT_DETAILS;?>  </b></td>
																</tr>
						    <tr><td colspan="4">&nbsp;</td></tr>
							<tr>
								<td align="left">
									<form name="frmadmin" method="post" >
									<table width="100%" border="0" cellpadding="0" cellspacing="0">
										<tr>
											<td align="left" width="20%"><?php echo ADMIN_CONSTANT_NAME;?></td>
											<td class="message_mendatory"><input type="text" name="constant_name"  class="long-form" maxlength="50" value="<?php if($PostData==true) { echo valid_output($constantName); } else { echo valid_output($ObjConstantMasterData[0]['constant_name']);}?>"> *<img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>internal/help_up.gif" class="help_btn" alt="<?php echo ADMIN_CONSTANT_NAME;?>"onmouseover="return overlib('<?php echo $siteconstatntname;?>');" onmouseout="return nd();" /></td>
										</tr>
										<tr>
											<td>&nbsp;</td>
											<td class="message_mendatory" id="UserNameError"><?php if(isset($err['UserNameError'])) { echo $err['UserNameError']; } ?></td>
										</tr>
										<tr>
											<td align="left"><?php echo ADMIN_CONSTANT_VALUE;?></td>
											<td class="message_mendatory">
											<textarea name="constant_value" id="constant_value" cols="48" rows="6"><?php if($PostData==true) {echo valid_output($constantValue);} else {echo valid_output($ObjConstantMasterData[0]['constant_value']);}?></textarea>	
                                            <script>
																				CKEDITOR.replace('constant_value');
																				</script>	
                                         *<img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>internal/help_up.gif" class="help_btn" alt="<?php echo ADMIN_CONSTANT_VALUE;?>"onmouseover="return overlib('<?php echo $siteconstantvalue;?>');" onmouseout="return nd();" />
											
											</td>
										</tr>
										<tr>
											<td>&nbsp;</td>
											<td class="message_mendatory" id="UserEmailError"><?php if(isset($err['UserEmailError'])) { echo $err['UserEmailError']; } ?></td>
										</tr>
										
										
										
										<tr>
											<td>&nbsp;</td>
											<td>&nbsp;</td>
										</tr>
										<tr>
											<td>&nbsp;</td>
											<td align="left">
												<input type="hidden" size="34" id="ptoken" value="<?php echo $ptoken; ?>" name="ptoken">
												<input type="submit" class="action_button" name="Submit" id="Submit" value="<?php echo $buttonName; ?>" />
												<input type="reset"  class="action_button" name="btnreset" value="<?php echo ADMIN_COMMON_BUTTON_RESET;?>"/>
												<input type="button"  class="action_button" name="cancel" value="<?php echo ADMIN_COMMON_BUTTON_CANCEL;?>" onclick="javascript:document.location.href='<?php echo FILE_SITE_CONSTANT_LISTING."?pagenum=".$pagenum; ?>';return true;"/>
											</td>
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
<!-- End Middle Content part -->
	<tr>
		<td id="footer">
			<?php require_once(DIR_WS_ADMIN_INCLUDES . ADMIN_FILE_FOOTER);?>
		</td>
	</tr>
</table>
</body>
</html>
