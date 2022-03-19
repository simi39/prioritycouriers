<?php
/**
* This file is for create template category
*
* @author     Radixweb <team.radixweb@gmail.com>
* @copyright  Copyright (c) 2008, Radixweb
* @version    1.0
* @since      1.0
*/

/**
 * incluide common file
 */
	require_once("../lib/common.php");	
	require_once(DIR_WS_ADMIN_LANGUAGES . DIR_CURRENT_LANGUAGE. '/faq.php');
	require_once(DIR_WS_MODEL . "FaqCategoryMaster.php");

	
/**
 * Object defining 
 */
	$objFaqCategoryMaster   = new FaqCategoryMaster();
	$objFaqCategoryMaster   = $objFaqCategoryMaster->Create();
	$objFaqCategorydata     = new FaqCategoryData();
	
	$arr_javascript_plugin_include[] = 'datatables/datatables.min.js';

	$arr_css_plugin_include[] = 'datatables/datatables.min.css';
	$arr_css_plugin_include[] = 'datatables/Buttons-1.6.5/css/buttons.dataTables.min.css';

	
/**
 * Variable Declaration 
 */
    $message  = trim($arr_message[$_GET["message"]]);
	if(!empty($message))
	{
		$err['message'] = specialcharaChk(valid_input($message));
	}
	if(!empty($err['message']))
	{
		logOut();
	}	
    $catId    = trim($_GET['CatId']);
	if(!empty($catId))
	{
		$err['CatId'] = isNumeric($catId,ENTER_VALUE_IN_NUMERIC);
	}
	if(!empty($err['CatId']))
	{
		logOut();
	}
	if(!empty($_GET['m_trash_id']))
	{
		$err['m_trash_id'] = isNumeric($_GET['m_trash_id'],ENTER_VALUE_IN_NUMERIC);
	}
	if(!empty($err['m_trash_id']))
	{
		logOut();
	}
	if(!empty($_GET['changestatus']))
	{
		$err['changestatus'] = isNumeric($_GET['changestatus'],ENTER_VALUE_IN_NUMERIC);
	}
	if(!empty($err['changestatus']))
	{
		logOut();
	}
	if(!empty($_GET['deleteid']))
	{
		$err['deleteid'] = isNumeric($_GET['deleteid'],ENTER_VALUE_IN_NUMERIC);
	}
	if(!empty($err['deleteid']))
	{
		logOut();
	}
    $action   = trim($_GET['action']);
	if(!empty($action))
	{
		$err['action'] = chkStr(valid_input($_GET['action']));
	}
	if(!empty($err['action']))
	{
		logOut();
	}
    
    define('ADMIN_NO_RECORDS', 1);
	
	//exit();
	//change status
	if(isset($_GET['CatId'])&& !empty($_GET['CatId'])&& isset($_GET['changestatus']) && $err['CatId']!=""){		
		$objFaqCategorydata->status = $_GET['changestatus'];
		$objFaqCategorydata->faqcat_id = $catId;
		$objFaqCategoryMaster->editFaqCategory($objFaqCategorydata,"update");		
		echo $_GET['changestatus'];
		exit;
	}
	
	//Deleting 	of records
	if($action=="delete" && !empty($_GET['deleteid'])) {
		$objFaqCategoryMaster->deleteFaqCategory($_GET['deleteid']);
		header("Location:".FILE_ADMIN_FAQ_CATEGORY);
		//echo "success";
        exit;
	} 
	
	//multiple delete
	if($_GET['Action']=='mtrash' && !empty($_GET['m_trash_id'])){
		$auto_id= $_GET['m_trash_id'];
		$m_t_a=explode(",",$auto_id);
		foreach($m_t_a as $val)
		{
			$error = isNumeric(valid_input($val),ENTER_NUMERIC_VALUES_ONLY);
			if(!empty($error))
			{
				logOut();
			}else
			{
				$objFaqCategoryMaster->deleteFaqCategory($val);
			}
		}
    }
	
	$query = "SELECT faq_category.*, faq_category_desc.faq_category_name
	FROM faq_category LEFT JOIN faq_category_desc ON faq_category.faqcat_id = faq_category_desc.faqcat_id" ;	
	$FaqCategoryData = $objFaqCategoryMaster->getFaqCategory(null,null,null,null,null,$query);
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo ADMIN_FAQ_CATEGORY_MANAGEMENT_LISTING;?></title>
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
<!-- Start Middle Content part -->
							<tr>								
								<td align="left" class="breadcrumb">
								<span><a href="<?php echo FILE_WELCOME_ADMIN."?pagenum=".$pagenum; ?>"><?php echo ADMIN_HEADER_HOME;?></a> > <?php echo ADMIN_HEADER_FAQ_CATEGORY; ?></span>
								<div><label class="top_navigation"><a onclick="mtrash('<?php echo  FILE_ADMIN_FAQ_CATEGORY."?pagenum=".$pagenum;?>','<?php echo "Are you sure you want to delete ?"; ?>');"><?php echo COMMAN_DELETE; ?></a>
								<label class="top_navigation"><a href="<?php echo FILE_ADMIN_ADD_EDIT_FAQ_CATEGORY."?pagenum=".$pagenum;?>" ><?php echo ADMIN_FAQ_CATEGORY_ADD_LABEL; ?> </a></label></div>
								</td>
							</tr>
							<tr>
								<td class="heading">
									<?php echo ADMIN_HEADER_FAQ_CATEGORY; ?>
								</td>
							</tr>							
							<?php if(!empty($message)) {?>
							<tr>
								<td class="message_success" align="center"><?php echo valid_output($message) ; ?></td>
							</tr>							
							<?php } ?>	
							<tr>
								<td valign="top">
								
							<?php  /*** Start :: Listing Table ***/ ?>
								
									<div id="container">
	
										
										<table border="0" width="100%" cellpadding="0" cellspacing="0" align="center"   class="display" id="maintable">
										<thead>	
											<tr>
											<th width="5%" align="center"> <input type="checkbox" name="m_trash_main" id="m_trash_all" > </th>
												<th width="8%" align="center"><?php echo ADMIN_COMMON_SERIAL_NO; ?></th>
												<th width="10%" align="center"><?php echo ADMIN_FAQ_CATEGORY_NAME; ?></th>												
												<th width="8%" align="center"><?php echo ADMIN_COMMON_SORT_ORDER; ?></th>
												<th width="10%" align="center"><?php echo ADMIN_COMMON_STATUS; ?></th>
												<th width="27%" align="center"><?php echo ADMIN_COMMON_ACTION; ?></th>
											</tr>
											</thead>
											<tbody>
												<?php 
													if(!empty($FaqCategoryData)) {
														$i = 1;
														foreach ($FaqCategoryData as $catdata) { ?>
															<tr>
															<td align="center"> <input type="checkbox" name="m_trash" id="<?php echo $catdata['faqcat_id'];?>"></td>
																<td align="center"><?php echo $i;?></td>
																<td align="center"><?php echo valid_output($catdata['faq_category_name']);?></td>
																<td align="center"><?php echo $catdata['sort_order'];?></td>
																<?php 
																	if($catdata['status'] == "1"){
																		$status=ADMIN_COMMON_STATUS_ACTIVE;
																		$changeStaus='0';
																	}else{
																		$status= ADMIN_COMMON_STATUS_INACTIVE;
																		$changeStaus='1';
																}?>
																<td align="center"><a href="<?php echo FILE_ADMIN_FAQ_CATEGORY?>?pagenum=<?php echo $pagenum;?>&CatId=<?php echo $catdata['faqcat_id'];?>&changestatus=<?php echo $changeStaus;?>" id="status"><?php echo $status;?></a></td>
																<td align="center"><a href="<?php echo FILE_ADMIN_ADD_EDIT_FAQ_CATEGORY;?>?pagenum=<?php echo $pagenum;?>&CatId=<?php echo $catdata['faqcat_id'];?>"><?php echo COMMON_EDIT; ?></a>&nbsp;|&nbsp;<a href="<?php echo FILE_ADMIN_FAQ_CATEGORY;?>?deleteid=<?php echo $catdata['faqcat_id'];?>&action=delete" id="rowDelete"><?php echo COMMAN_DELETE; ?></a></td>
															</tr>
												<?php		$i++; }														
													}
												?>
											</tbody>
											<tfoot>
												<tr>
													<th>&nbsp;</th>
													<th align="center"><?php echo ADMIN_COMMON_SERIAL_NO; ?>&nbsp;</th>
													<th align="center"><?php echo ADMIN_FAQ_CATEGORY_NAME; ?>&nbsp;</th>
													<th><?php echo ADMIN_COMMON_SORT_ORDER; ?>&nbsp;</th>
													<th><?php echo ADMIN_COMMON_STATUS; ?>&nbsp;</th>
													<th><?php echo ADMIN_COMMON_ACTION; ?>&nbsp;</th>
												</tr>
											</tfoot>
										</table>
										
									</div>
								<?php  /*** End :: Listing Table ***/ ?>
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
</td>
</tr>
</table>
</body>
</html>
