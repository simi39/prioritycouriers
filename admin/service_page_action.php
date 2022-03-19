<?php
    /**
	* This file is for display user list
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
    require_once(DIR_WS_MODEL . "ServicePageMaster.php");
    require_once(DIR_WS_ADMIN_LANGUAGES . DIR_CURRENT_LANGUAGE. '/servicepage.php');
    /**
     * Start :: Object declaration
     */

    $ObjServicePageMaster	= new ServicePageMaster();
    $ObjServicePageMaster	= $ObjServicePageMaster->Create();
    $ServicePageData		= new ServicePageData();

    $btnSubmit = ADMIN_BUTTON_SAVE_SERVICE_PAGE;
    $HeadingLabel = ADMIN_SAVE_SERVICE_PAGE;
    $id = $_GET['id'];
    if(!empty($id))
    {
        $err['id'] = isNumeric(valid_input($id),ENTER_NUMERIC_VALUES_ONLY);
        $readonly = 'readonly';
    }
    if(!empty($err['id']))
    {
        logOut();
    }

    /*csrf validation*/
    $csrf = new csrf();
    $csrf->action = "add_service_page";
    if(!isset($_POST['ptoken'])) {
        $ptoken = $csrf->csrfkey();
    }
    /*csrf validation*/
    if((isset($_POST['submit']) && $_POST['submit'] != "")){
        if(isEmpty(valid_input($_POST['ptoken']), true)){	
            logOut();
        }else{
            //$csrf->checkcsrf($_POST['ptoken']);
        }
        if(isset($_POST['service_page_name']))
        {
            $err['servicePageError'] = isEmpty(trim($_POST['service_page_name']), PLEASE_ENTER_SERVICE_PAGENAME)?isEmpty(trim($_POST['service_page_name']), PLEASE_ENTER_SERVICE_PAGENAME):chkSmall(valid_input($_POST['service_page_name']));
        }
        $err['len_maxErr'] = isEmpty(trim($_POST['len_max']), PLEASE_ENTER_LENGTH_MAX_VAL)?isEmpty(trim($_POST['len_max']), PLEASE_ENTER_LENGTH_MAX_VAL):isNumeric(valid_input($_POST['len_max']),ENTER_NUMERIC_VALUES_ONLY);
        $err['girth_maxErr'] = isEmpty(trim($_POST['girth_max']), PLEASE_ENTER_GIRTH_MAX_VAL)?isEmpty(trim($_POST['girth_max']), PLEASE_ENTER_GIRTH_MAX_VAL):isNumeric(valid_input($_POST['girth_max']),ENTER_NUMERIC_VALUES_ONLY);
        /*echo "<pre>";
        print_r($err);
        echo "</pre>";
        exit();*/
        foreach($err as $key => $Value) {
            if($Value != '') {
                $Svalidation=true;
                $ptoken = $csrf->csrfkey();
            }
        }
        if($Svalidation==false){
            $service_page_name = trim($_POST['service_page_name']);
			//$fieldArr = array('count(*) as total');
            $seaByArr[]=array('Search_On'=>'service_page_name', 'Search_Value'=>"$service_page_name", 'Type'=>'int', 'Equation'=>'=', 'CondType'=>'and', 'Prefix'=>'', 'Postfix'=>'');
            $btnSubmit = ADMIN_BUTTON_UPDATE_SERVICEPAGE;
		    $HeadingLabel = ADMIN_LINK_UPDATE_SERVICEPAGE;
			$TotalDataServicePage = $ObjServicePageMaster->getServicePageName($fieldArr, $seaByArr, $optArr=null, $start=null, $total=null, $ThrowError=true,$counttotal=true);
           // echo "total data service:".$TotalDataServicePage;
			if (isset($TotalDataServicePage) && $TotalDataServicePage == 1 && $id==''){
                $errmessage = DATA_EXITS;
                $ptoken = $csrf->csrfkey();
            }else{
                $ServicePageData->service_page_name = trim($_POST['service_page_name']);
                $ServicePageData->length_max = trim($_POST['len_max']);
			    $ServicePageData->girth_max = trim($_POST['girth_max']);
                if($id!=''){
                    //Edit Service Page Data*/
                    $ServicePageData->id = $id;
                    $ObjServicePageMaster->editServicePageName($ServicePageData);
                    $UParam = "?pagenum=".$pagenum."&message=".MSG_EDIT_SERVICEPAGE_SUCCESS;
                }else{
                    $inserted_id = $ObjServicePageMaster->addServicePageName($ServicePageData);
                   // echo "successfully inserted".$inserted_id."</br>";
                    $UParam = "?message=".MSG_ADD_SERVICEPAGE_SUCCESS;
                }
				//echo FILE_SERVICE_PAGE.$UParam;
				//exit();
                header('Location:'.FILE_SERVICE_PAGE.$UParam);
                exit();
            }
        }
    }
	if($_GET['Action']=='trash'){
		$ObjServicePageMaster->deleteServicePageName($id);
		$UParam = "?pagenum=".$pagenum."&message=".MSG_DELETE_SERVICEPAGE_GRID_SUCCESS;
		header('Location: '.FILE_SERVICE_PAGE.$UParam);
	}
	
	if($_GET['Action']=='mtrash'){
		$service_page_id= $_GET['m_trash_id'];
		$m_t_a=explode(",",$service_page_id);
		
		foreach($m_t_a as $val)
		{
			$error = isNumeric(valid_input($val),ENTER_NUMERIC_VALUES_ONLY);
			if(!empty($error))
			{
				logOut();
			}else
			{
				$ObjServicePageMaster->deleteServicePageName($val);
			}
		}
		$UParam = "?pagenum=".$pagenum."&message=".MSG_DELETE_SERVICEPAGE_GRID_SUCCESS;
		header('Location: '.FILE_SERVICE_PAGE.$UParam);
	}
	$seaByArr = array();
	$fieldArr = array();
	$fieldArr=array("*");
	
	if($id!=''){
		//echo "id:".$id;
		$seaByArr[]=array('Search_On'=>'id', 'Search_Value'=>"$id", 'Type'=>'int', 'Equation'=>'=', 'CondType'=>'and', 'Prefix'=>'', 'Postfix'=>'');
		$btnSubmit = ADMIN_BUTTON_UPDATE_SERVICEPAGE;
		$HeadingLabel = ADMIN_LINK_UPDATE_SERVICEPAGE;
		$DataServicePage=$ObjServicePageMaster->getServicePageName($fieldArr, $seaByArr, $optArr=null, $start=null, $total=null, $ThrowError=true);
		$DataServicePage = $DataServicePage[0];
	}	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php if ($_GET['km_grid_id']=='') { echo ADMIN_ADD_SERVICE_PAGE; } else { echo ADMIN_EDIT_SERVICE_PAGE;}?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<?php 
addPluginCSSFile($arr_css_plugin_include,$arr_css_plugin_exclude);
addCSSFileAdmin($arr_css_admin_include, $arr_css_admin_exclude);
addJavaScriptFile($arr_javascript_include, $arr_javascript_exclude);
addPluginJavaScriptFile($arr_javascript_plugin_include,$arr_javascript_plugin_exclude);
?>
<script>
function validServicePage()
{

    if($("#service_page_name").val() == "<?php echo ADMIN_PLEASE_SELECT_SERVICE_ITEM; ?>")
	{
		$("#servicepagenameErr").html("<?php echo PLEASE_ENTER_SERVICE_PAGENAME; ?>");
		return false;
	}else{
		$("#servicepagenameErr").html("");
	}
    if(($("#len_max").val()) == "")
	{
		$("#len_maxErr").html("<?php echo PLEASE_ENTER_LENGTH_MAX_VAL; ?>");
		return false;
	}else{
		$("#len_maxErr").html("");
	}	
    if(($("#girth_max").val()) == "")
	{
		$("#girth_maxErr").html("<?php echo PLEASE_ENTER_GIRTH_MAX_VAL; ?>");
		return false;
	}else{
		$("#girth_maxErr").html("");
	}

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
					<form name="service_page" id="service_page" method="POST" onsubmit="javascript:return validServicePage();" >
					<table class="middle_right_content" align="center" border="0" cellpadding="0" cellspacing="0">
							<tr>
								<td align="left" class="breadcrumb">
										<span><a href="<?php echo FILE_WELCOME_ADMIN; ?>"><?php echo ADMIN_HEADER_HOME; ?></a> > <a href="<?php echo FILE_SERVICE_PAGE; ?>"> <?php echo ADMIN_HEADER_SERVICE_PAGE; ?> </a> > <? echo $HeadingLabel; ?></span>
										<div><label class="top_navigation"><a href="<?php echo FILE_SERVICE_PAGE; ?>"><?php echo ADMIN_COMMON_BACK; ?></a></label></div>
								</td>
							</tr>
							<tr>
								<td class="heading">
									<?php echo $HeadingLabel; ?>
								</td>
							</tr>
								<tr>
									<td class="message_mendatory"><?php echo $errmessage; ?></td>
								</tr>	
							   <tr>
								<td align="center">
									<?php  /*** Start :: Listing Table ***/ ?>
									<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
										
										
										
										<tr>
											<td>
												<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
													<tr>
														<td>
															<table width="100%" border="0" cellpadding="0" border="0" cellspacing="0" >
																<tr>
																	<td class="message_mendatory" align="right" colspan="2">
																		<?echo ADMIN_COMMAN_REQUIRED_INFO;?>
																	</td>
																</tr>
																<?php
																/*echo "<pre>";
																print_r($DataServicePage);
																echo "</pre>";*/
																	$service_page_name = ($_POST['service_page_name']!="")?(valid_output($_POST['service_page_name'])):(valid_output($DataServicePage['service_page_name']));
																?>
																<tr>
																	<td class="form_caption" width="10%"><?php echo ADMIN_SERVICE_PAGE_NAME; ?></td>
																	<td class="message_mendatory">
																	<select name="service_page_name" id="service_page_name" <?php //echo $readonly; ?>>
																	<option><?php echo ADMIN_PLEASE_SELECT_SERVICE_ITEM; ?></option>
																	<option <?php if($service_page_name == 'domestic'){ echo "selected='selected'";} ?>>domestic</option>
																	<option <?php if($service_page_name == 'sameday'){ echo "selected='selected'";} ?>>sameday</option>
																	<option <?php if($service_page_name == 'overnight'){ echo "selected='selected'";} ?>>overnight</option>
																	<option <?php if($service_page_name == 'international'){ echo "selected='selected'";} ?>>international</option>
																	</select>
																															
																</tr>
																<tr>
																	<td class="form_caption" width="10%">&nbsp;</td>
																	<td id="servicepagenameErr" class="message_mendatory"><?php if(isset($err['servicePageError']) && $err['servicePageError']!=""){ echo $err['servicePageError'];} ?></td>
																</tr>
											    				<tr>
																	<td class="form_caption" width="10%"><?php echo ADMIN_SERVICE_PAGE_LENGTH_MAXIMUM; ?></td>
																	<td class="message_mendatory" ><input type="text" id="len_max" name="len_max" value="<?php  echo ($_POST['len_max']!="")?(filter_var($_POST['len_max'],FILTER_VALIDATE_INT)):(filter_var($DataServicePage['length_max'],FILTER_VALIDATE_INT));?>" <?php echo $dim_readonly; ?> />&nbsp;*</td>
																</tr>
																<tr>
																	<td class="form_caption" width="10%">&nbsp;</td>
																	<td class="message_mendatory" id="len_maxErr"><?php if(isset($err['len_maxErr']) && $err['len_maxErr']!=""){ echo $err['len_maxErr'];} ?></td>
																</tr>
																
																<tr>
																	<td class="form_caption" width="10%"><?php echo ADMIN_SERVICE_PAGE_GIRTH_MAXIMUM; ?></td>
																	<td class="message_mendatory" ><input type="text" id="girth_max" name="girth_max" value="<?php  echo ($_POST['girth_max']!="")?(filter_var($_POST['girth_max'],FILTER_VALIDATE_INT)):(filter_var($DataServicePage['girth_max'],FILTER_VALIDATE_INT));?>" <?php echo $dim_readonly; ?> />&nbsp;*</td>
																</tr>
																<tr>
																	<td class="form_caption" width="10%">&nbsp;</td>
																	<td class="message_mendatory" id="girth_maxErr"><?php if(isset($err['girth_maxErr']) && $err['girth_maxErr']!=""){ echo $err['girth_maxErr'];} ?></td>
																</tr>

															</table>
														</td>
													</tr>
													<tr>
														<td>&nbsp;</td>
													</tr>
												
												</table>
											</td>
										</tr>
										<tr>
											<td>&nbsp;</td>
										</tr>
										<tr>
											<td align="center">
											<input type="hidden"  id="ptoken" value="<?php echo $ptoken; ?>" name="ptoken">
											<input type="submit" class="action_button" tabindex="36" name="submit" value="<?php echo $btnSubmit; ?>" >
											<input type="reset" tabindex="37" name="reset" class="action_button" value="<?php echo ADMIN_COMMON_BUTTON_RESET; ?>" >
											<input type="button"  class="action_button" name="cancel" tabindex="38" value="<?php echo ADMIN_COMMON_BUTTON_CANCEL;?>" onclick="javascript:document.location.href='<?php echo FILE_SERVICE_PAGE; ?>';return true;"/>
											</td>
										</tr>
										<tr>
											<td>&nbsp;</td>
										</tr>
										
									</table>
									<?php  /*** End :: Listing Table ***/ ?>
								</td>
							</tr>
						</table>
						</form>
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
</body>
</html>