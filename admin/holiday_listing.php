<?php



	/**

	 * This file is for Listing of the Faq Management

	 *

	 *

	 * @author     Radixweb <team.radixweb@gmail.com>

	 * @copyright  Copyright (c) 2008, Radixweb

	 * @version    1.0

	 */

		

	//Include commom file

	require_once("../lib/common.php");
	
	require_once(DIR_WS_MODEL."/PublicHolidayMaster.php");

	require_once(DIR_WS_ADMIN_LANGUAGES . DIR_CURRENT_LANGUAGE. "/holiday.php");
	
	/**
	 * Inclusion and Exclusion Array of Javascript
	 */
	$arr_javascript_plugin_include[] = 'datatables/datatables.min.js';

	$arr_css_plugin_include[] = 'datatables/datatables.min.css';
	$arr_css_plugin_include[] = 'datatables/Buttons-1.6.5/css/buttons.dataTables.min.css';
	 

	// Object Declaration

	$publicholidayMasterObj = new PublicHolidayMaster();
	
	$publicholidayMasterObj = $publicholidayMasterObj->create();

	$publicholidayDataObj= new PublicHolidayMaster();

	

	

	// Not to Pass Variable Array

	$notToPassQueryArray=array('faqid','tid','changestatus','Submit','message','Action');

	//Paramenters for the URL passing	
	$preferences = new Preferences();
	$notToPassArray=$preferences->NotToPassQueryString($notToPassQueryArray);

	$URLParameters=$preferences->GetAddressBarQueryString($notToPassArray);

	if ($URLParameters!='') {

		$URLParameters="&".$URLParameters;

	}



	/**

	 * Variable Declaration 

	 */

	$message     = trim($arr_message[$_GET["message"]]);
	$action	     = trim($_GET['Action']);
	$search_para = trim($_GET['searchque']);
	
	
	if(!empty($message))
	{
		$err['message'] = specialcharaChk(valid_input($message));
	}
	if(!empty($err['message']))
	{
		logOut();
	}
	
	if(!empty($action))
	{
		$err['Action'] = chkStr(valid_input($action));
	}
	if(!empty($err['Action']))
	{
		logOut();
	}
	if(!empty($search_para))
	{
		$err['search_para'] = specialcharaChk(valid_input($search_para));
	}
	if(!empty($err['search_para']))
	{
		logOut();
	}
	if(isset($search_para) && $search_para!='') {
		$searching=" AND testimonial_description LIKE '%$search_para%'";
	}
	
	$delete_id = $_GET['delid'];
	if(!empty($delete_id))
	{
		$err['delete_id'] = isNumeric(valid_input($delete_id),ENTER_NUMERIC_VALUES_ONLY);
	}
	if(!empty($err['delete_id']))
	{
		logOut();
	}
	//Deleting 	of records
	if(isset($action) && $action=="delete" && !empty($delete_id)) {
		$publicholidaydata=$publicholidayMasterObj->deletePublicHoliday($delete_id);		
       	header('Location:holiday_listing.php'.$UParam);
        exit();
	} 	


	//Displays all the records
	//$publicholidaydata = $publicholidayMasterObj->getPublicHoliday(nul,null,null,null,null,null);
	
	$all_records=$publicholidayMasterObj->getPublicHoliday($fieldArr, null,null,null,null, true, true);
	  	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo ADMIN_HEADER_HOLIDAY_MANAGEMENT?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<?php
addPluginCSSFile($arr_css_plugin_include,$arr_css_plugin_exclude);
addCSSFileAdmin($arr_css_admin_include, $arr_css_admin_exclude);
addJavaScriptFile($arr_javascript_include, $arr_javascript_exclude);
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

  <tr><td valign="top"><?php require_once(DIR_WS_ADMIN_INCLUDES . ADMIN_FILE_HEADER);?></td></tr>

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

		      	 <table border="0" width="100%" cellpadding="0" cellspacing="0"  align="center">

			   		<tr>			   			

   						<td valign="top">

							<table border="0" width="100%" cellpadding="0" cellspacing="0"  align="center" class="middle_right_content">

								

								<tr>

								<td align="left" class="breadcrumb">

								<span><a href="<?php echo FILE_WELCOME_ADMIN; ?>"><?php echo ADMIN_HEADER_HOME;?></a> > <?php echo ADMIN_HEADER_HOLIDAY_MANAGEMENT; ?></span>

								<div><label class="top_navigation"><a href="<?php echo FILE_HOLIDAY_ACTION; ?>"><?php echo ADMIN_HOLIDAYS_ADD_LABEL ; ?></a>

								<a href="<?php echo FILE_HOLIDAY_ACTION; ?>?Action=export"><?php echo ADMIN_EXPORT_NEW ; ?></a></label>

							

								</div>



								</td>

							</tr>

								

								<tr>															

									<td class="heading">

										<?php echo ADMIN_HEADER_HOLIDAY_MANAGEMENT; ?>

									</td>

								</tr>

										

							<?php if(!empty($message)) {?>

								<tr>

									<td class="message_success" align="center"><?php echo valid_output($message) ; ?></td>

								</tr>

								<tr><td>&nbsp;</td></tr>

							<?php } ?>										

								

								<tr>

									<td colspan="2">

									<div id="container">



									
										<table border="0" width="100%" cellpadding="0" cellspacing="0" align="center" class="display" id="maintable">

											<thead>

											<tr>

												<th width="8%" align="center"><?php echo ADMIN_COMMON_SERIAL_NO;?></th>
												<th width="52%" align="center"><?php echo ADMIN_HOLIDAY_TITLE;?></th>
												<th width="15%" align="center"><?php echo ADMIN_HOLIDAY_DATE;?></th>
												<th width="10%" align="center"><?php echo ADMIN_HOLIDAY_STATE;?></th>
												<th width="18%" align="center"><?php echo ADMIN_COMMON_ACTION;?></th>

											</tr>

											</thead>

											<tbody>

											<?php 

											$rowClass = 'TableEvenRow';

											if($_GET["startRow"] > 0){

															$i = $_GET["startRow"] + 1;

														}

														else {

															$i=1;

														};

											if($all_records){ 			

											foreach ($all_records as $record){ 

												

												if($rowClass == 'TableEvenRow') {

													$rowClass = 'TableOddRow';

												} else {

													$rowClass = 'TableEvenRow';

												}

												?>

											<tr class="<?echo $rowClass?>" >

												<td align="center"><?php echo $i; $i++; ?></td>

												<td><?php echo $record['name']; ?></td>

												<td align="center" class="link_small"><?php echo valid_output($record['sdate']);?></td>

												<td align="center"><?php echo valid_output($record['state']);?></td>

												<td align="center" class="link_small"><a href="<?php echo FILE_HOLIDAY_ACTION; ?>?hid=<?php echo $record['dateid'];?><?php echo $query_string; ?><?php echo $URLParameters;?>"><?php echo COMMON_EDIT;?> </a> | 

												<a href="<?php echo FILE_HOLIDAY_LISTING; ?>?delid=<?php echo $record['dateid'];?>&Action=delete<?php echo $URLParameters;?>" id="rowDelete"><?php echo COMMAN_DELETE;?></a></td>

											</tr>

											<?php $from = $from+1; } }?>

											<tbody>

											<tfoot>

												<tr>

													

													<th align="left"><?php echo ADMIN_COMMON_SERIAL_NO;?>&nbsp;</th>

													<th align="left"><?php echo ADMIN_HOLIDAY_TITLE;?>&nbsp;</th>

													<th align="left"><?php echo ADMIN_HOLIDAY_DATE;?>&nbsp;</th>

													<th><?php echo ADMIN_HOLIDAY_STATE;?>&nbsp;</th>
													<th><?php echo ADMIN_COMMON_ACTION;?>&nbsp;</th>

												</tr>

											</tfoot>

										</table>

									

									</div>

									

									</td>

								</tr>
								
   							</table>

	   						</td>

	   					</tr>

	   				</table>

	  			</td>

	        </tr>

	     </table>

	  </td>

  </tr>

  <tr>

  		<td id="footer">

  		<?php require_once(DIR_WS_ADMIN_INCLUDES."/".ADMIN_FILE_FOOTER);?></td>

  </tr>

</table>

</body>

</html>


