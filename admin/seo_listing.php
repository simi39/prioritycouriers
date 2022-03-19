<?php
	/**
	 * This file is for Seo Management
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
	require_once('pagination_top.php');
	require_once(DIR_WS_MODEL . "seoPageMaster.php");
	require_once(DIR_WS_ADMIN_LANGUAGES . DIR_CURRENT_LANGUAGE. '/seo.php');
	
	/**
	 * Inclusion and Exclusion Array of Javascript
	 */
	$arr_javascript_plugin_include[] = 'datatables/datatables.min.js';

	$arr_css_plugin_include[] = 'datatables/datatables.min.css';
	$arr_css_plugin_include[] = 'datatables/Buttons-1.6.5/css/buttons.dataTables.min.css';
	
	$pagenum = ($_GET['pagenum']!="")?($_GET['pagenum']):(1);	if(!empty($pagenum))	{		$err['pagenum'] = isNumeric(valid_input($pagenum),ENTER_NUMERIC_VALUES_ONLY);	}	if(!empty($err['pagenum']))	{		logOut();	}
	/**
	 * Start :: Object declaration
	 */
	$ObjSeoMaster = new seoPageMaster();
	$ObjSeoMaster = $ObjSeoMaster->Create();
	
	/**
	 * Variable Declaration 
	 */
	$start        = (!empty($_GET['startRow']))?$_GET['startRow']:0;	if(!empty($start))	{		$err['start'] = isNumeric(valid_input($start),ENTER_NUMERIC_VALUES_ONLY);	}	if(!empty($err['start']))	{		logOut();	}
	$sid         = trim($_GET['sid']);	if(!empty($sid))	{		$err['sid'] = isNumeric(valid_input($sid),ENTER_NUMERIC_VALUES_ONLY);	}	if(!empty($err['sid']))	{		logOut();	}
	$action	     = trim($_GET['Action']);	// action Variable	if(!empty($_GET['Action']))	{		$err['Action'] = chkStr(valid_input($_GET['Action']));	}	if(!empty($err['Action']))	{		logOut();	}
		// Message Variable	$message = $arr_message[$_GET['message']];            	if(!empty($message))	{		$err['message'] = specialcharaChk(valid_input($message));	}	if(!empty($err['message']))	{		logOut();	}
	if(!empty($_GET['deleteid']))	{		$err['deleteid'] = isNumeric(valid_input($_GET['deleteid']),ENTER_NUMERIC_VALUES_ONLY);	}	if(!empty($err['deleteid']))	{		logOut();	}
	
	// Start Delete SEO
	    if(isset($action) && $action=="del" && !empty($_GET['deleteid'])) {
	    $delete_id = $_GET['deleteid'];
		$seoId=$ObjSeoMaster->deleteseoPage($delete_id);
        echo "success";
        exit;
	} 	
	
	//Multiple delete
	if($_GET['Action']=='mtrash' && !empty($_GET['m_trash_id'])){
	$auto_id= $_GET['m_trash_id'];
	$m_t_a=explode(",",$auto_id);
			foreach($m_t_a as $val)
			{							$error = isNumeric(valid_input($val),ENTER_NUMERIC_VALUES_ONLY);				if(!empty($error))				{					logOut();				}else				{
					$seoId=$ObjSeoMaster->deleteseoPage($val);				}
		    }
	}
	
	/**
 	 * Code For Fetching SEO Data
 	 */
/*	$sqlQuery= "SELECT * FROM site_seo
                    INNER JOIN site_seo_description ON (site_seo.page_id = site_seo_description.page_id)
                    WHERE site_language_id = ".SITE_LANGUAGE_ID." ORDER BY site_seo.page_id ";
	$seodata = $ObjSeoMaster->getseoPage(null,null,null,null,null,$sqlQuery);
*/
	$seodata1 = $ObjSeoMaster->getseoPageListing();
	$all = $seodata1->RecordCount();
	$data_result = pagination($data,$pagenum,null,$all);

	$data = pagination(null,null,false,$from,$to);
	$fieldArr = array("*");	

	$from = $data_result[0];
	$to = '10';
	

	$fieldArr = array("*");	

	$seodata = $ObjSeoMaster->getseoPageListing ($from,$to);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo ADMIN_SEO_MANAGEMENT; ?></title>
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
					<!-- Start :  Middle Content-->
						<table class="middle_right_content" align="center" border="0" cellpadding="0" cellspacing="0">
							<tr>
								<td align="left" class="breadcrumb">
										<span><a href="<?php echo FILE_WELCOME_ADMIN; ?>"><?php echo ADMIN_HEADER_HOME;?></a> > <?php echo ADMIN_HEADER_SEO_MANAGEMENT; ?></span>
										<div><label class="top_navigation"><a onclick="mtrash('<?php echo   FILE_ADMIN_SEO."?pagenum=".$pagenum;?>','<?php echo "Are you sure you want to delete ?"; ?>');"><?php echo COMMAN_DELETE; ?></a>
										<label class="top_navigation"><a href="seo_action.php?pagenum=<?php echo  $pagenum;?>"><?php echo "<b>".ADMIN_SEO_ADD_NEW."</b>";?></a></label></div>
								</td>
							</tr>
							<tr>
								<td class="heading">
									<?php echo ADMIN_HEADER_SEO_MANAGEMENT; ?>
								</td>
							</tr>
							<?php if(!empty($message)) {?>
							<tr>
								<td class="message_success" align="center"><?php echo valid_output($message); ?></td>
							</tr>							
							<?php } ?>
							<tr>
								<td align="center">
									<?php  /*** Start :: Listing Table ***/ ?>
									<div id="container">
										<div id="jquery_table"  class="jquery_pagination">
										<table border="0" width="100%" class="display" id="maintable" cellpadding="0" cellspacing="0" >
											<thead>
											<tr>
											<th width="5%" align="center"> <input type="checkbox" name="m_trash_main" id="m_trash_all" > </th>
												<th width="12%" align="center"><?php echo ADMIN_COMMON_SERIAL_NO;?></th>
												<th width="10%" align="center"><?php echo ADMIN_SEO_PAGENAME;?></th>
												<th width="30%" align="center"><?php echo ADMIN_SEO_PAGETITLE;?></th>
												<th width="16%" align="center"><?php echo ADMIN_COMMON_ACTION;?></th>
											</tr>
											</thead>
											<tbody>
											<?php
											$i = 1;	
											if(!empty($seodata)) {
												$rowClass = 'TableEvenRow';
												if($_GET["startRow"] > 0) {
													$i = $_GET["startRow"] + 1;
												} else {
													$i=1;
												};
												foreach ($seodata as $record) {
													
													if($rowClass == 'TableEvenRow') {
														$rowClass = 'TableOddRow';
													} else {
														$rowClass = 'TableEvenRow';
													}
											?>
											<tr class="<? echo $rowClass?>" >
											<td align="center"> <input type="checkbox" name="m_trash" id="<?php echo $record['page_id'];?>"></td>
												<td align="center"><?php echo $i = 1+$from;?></td>
												<td><?php echo valid_output($record['page_name']); ?></td>
												<td><?php echo valid_output($record['seo_page_title']); ?></td>
												<td align="center" class="link_small"><a href="<?php echo FILE_ADMIN_SEO_ADDEDIT; ?>?pagenum=<?php echo $pagenum;?>&sid=<?php echo $record['page_id'];?><?php echo $query_string; ?><?php echo $URLParameters;?>"><?php echo COMMON_EDIT;?> </a> <?php if(strtolower(valid_output($record['page_name'])) != "standard"){?>| <a href="<?php echo FILE_ADMIN_SEO; ?>?pagenum=<?php echo $pagenum;?>&deleteid=<?php echo $record['page_id'];?>&Action=del<?php echo $URLParameters;?>" id="rowDelete"><?php echo COMMAN_DELETE;?></a><?php } ?></td>
											</tr>
											<?php
											$from = $from+1;
												}
											}else{
												echo "<tr class='TableOddRow'><td colspan='4'>Data is not available.</td></tr>";
												
											} ?>
											</tbody>
											<tfoot>
												<tr>
													<th><input type="hidden" name="indexno" class="search_init" value="" /></th>						<th align="center">&nbsp;</th>	
													<th align="left"><input type="text" name="search_page" value="<?php echo ADMIN_SEO_PAGENAME;?>"  title="<?php echo ADMIN_SEARCH_SEO_PAGENAME; ?>"class="search_init" /></th>
													<th align="left"><input type="text" name="search_title" value="<?php echo ADMIN_SEO_PAGETITLE;?>" title="<?php echo ADMIN_SEARCH_SEO_PAGETITLE; ?>"class="search_init" /></th>
													<th>&nbsp;</th>
													
												</tr>
											</tfoot>
										</table>
										</div>
									</div>
									<?php  /*** End :: Listing Table ***/ ?>
								</td>
								<tr>
							<td>
							<?php 
						echo pagination($seodata,$pagenum,true,$all);?>
							</td>
							</tr>
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
</body>
</html>
<?php 
	// Column Configuration
	//$columnSetting = 'null, null, null, { "bSortable": false }';
	//require_once(DIR_WS_JSCRIPT."/jquery.php"); 
?>
