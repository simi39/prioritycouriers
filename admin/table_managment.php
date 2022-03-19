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
require_once(DIR_WS_MODEL . "SteTableMaster.php");

require_once(DIR_WS_ADMIN_LANGUAGES . DIR_CURRENT_LANGUAGE. '/table_managment.php');

require_once(DIR_WS_MODEL . "ServiceMaster.php");

$ObjServiceMaster	= new ServiceMaster();
$ObjServiceMaster	= $ObjServiceMaster->Create();
$ServiceData		= new ServiceData();



$ObjSteTableMaster	= new SteTableMaster();
$ObjSteTableMaster	= $ObjSteTableMaster->Create();
$SteTableData		= new SteTableData();

$arr_javascript_plugin_include[] = 'datatables/datatables.min.js';

$arr_css_plugin_include[] = 'datatables/datatables.min.css';
$arr_css_plugin_include[] = 'datatables/Buttons-1.6.5/css/buttons.dataTables.min.css';
if(!empty($_POST["search_text"]))
{
	$err['search_text'] = chkTrk($_POST["search_text"]);
}
if(!empty($err['search_text']))
{
	logOut();
}
if(isset($_POST["search_submit"]) && $_POST["search_text"]!="")
{		
		$fieldArr=array("service_code");
		$seaByArr=array();
		$seaByArr[]=array('Search_On'=>'service_name', 'Search_Value'=>$_POST["search_text"], 'Type'=>'string', 'Equation'=>'=', 'CondType'=>'and', 'Prefix'=>'', 'Postfix'=>'');
		$DataService=$ObjServiceMaster->getService($fieldArr,$seaByArr);
		$DataService=$DataService[0];		
		
		$fieldArr=array("*");
		$seaByArr=array();
		$seaByArr[]=array('Search_On'=>'service_type', 'Search_Value'=>$DataService->service_code, 'Type'=>'string', 'Equation'=>'=', 'CondType'=>'', 'Prefix'=>'and', 'Postfix'=>'');
		$data = $ObjSteTableMaster->getSteTable($fieldArr,$seaByArr);	
}
else {	
	$fieldArr=array("*");
	$data = $ObjSteTableMaster->getSteTable($fieldArr);
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
if(isset($_POST["search_submit"]) && $_POST["search_text"]!="")
{		
		$fieldArr=array("service_code");
		$seaByArr=array();
		$seaByArr[]=array('Search_On'=>'service_name', 'Search_Value'=>$_POST["search_text"], 'Type'=>'string', 'Equation'=>'=', 'CondType'=>'and', 'Prefix'=>'', 'Postfix'=>'');
		$DataService=$ObjServiceMaster->getService($fieldArr,$seaByArr);
		$DataService=$DataService[0];		
		
		$fieldArr=array("*");
		$seaByArr=array();
		$seaByArr[]=array('Search_On'=>'service_type', 'Search_Value'=>$DataService->service_code, 'Type'=>'string', 'Equation'=>'=', 'CondType'=>'', 'Prefix'=>'and', 'Postfix'=>'');
		$DataSteTable=$ObjSteTableMaster->getSteTable($fieldArr, $seaByArr,null,$from,$to);	
}
else {	
	$fieldArr = array("*");
	$DataSteTable=$ObjSteTableMaster->getSteTable($fieldArr, null,null,$from,$to);
}





$service_array=array();
$fieldArr=array("*");
$data = $ObjServiceMaster->getService($fieldArr);
if($data!="")
{
	foreach ($data as $dataservice)
	{
		$service_array[$dataservice['service_code']]= $dataservice['service_name'];
	}
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo ADMIN_USER?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
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
						<table border="0" width="100%" cellpadding="0" cellspacing="0"  align="center" class="middle_right_content">
							<tr>
								<td align="left" class="breadcrumb">
								<span><a href="<?php echo FILE_DAY_ACTION; ?>"><?php echo ADMIN_HEADER_HOME;?></a>  <?php echo "/ Site Table Managment "; ?></span>
								<div><label class="top_navigation"><a onclick="mtrash('<?php echo FILE_TABLE_ACTION;?>','<?php echo "Your related tariffs will also be deleted"; ?>');"><?php echo COMMAN_DELETE; ?></a>
								<label class="top_navigation"><a href="<?php echo FILE_TABLE_ACTION; ?>"><?php echo "ADD" ; ?></a>
								
							
								</div>

								</td>
							</tr>
							<tr>
								<td class="heading">
								<?php echo "Site Table Managment"; ?>
								</td>
							</tr>
							<?php if(!empty($message)) {?>
							<tr>
								<td class="message_success" align="center"><?php echo valid_output($message);  ?></td>
							</tr>							
							<?php } ?>
							<!--  End Searching	-->
							<tr>
								<td>
								
							<?php  /*** Start :: Listing Table ***/ ?>
							
									<div id="container">
										<div style='padding:10px;'>
										<form method="POST" action="">
										<label>Search By Service :</label>										
										&nbsp;&nbsp;&nbsp;&nbsp;
										<input type="text" name="search_text" id="search_text" value="<?php if(isset($_POST["search_text"])){ echo $_POST["search_text"]; } ?>">
										&nbsp;&nbsp;&nbsp;&nbsp;
										<input type="submit" name="search_submit" id="search_submit" value="Search" >
										</form>										
										</div>
										
										<table width="100%" cellspacing="0" cellpadding="0" class="display" id="maintable">
											<thead>
												<tr>
												 <th width="5%" align="center"> <input type="checkbox" name="m_trash_main" id="m_trash_all" > </th>
													<th width="5%" align="center"><?php echo ADMIN_COMMON_SERIAL_NO; ?></th>
													<th width="15%" align="center"><?php echo "Table Name"; ?></th>
													<th width="15%" align="center"><?php echo "City"; ?></th>		
													<th width="15%" align="center"><?php echo "Service"; ?></th>																									
													<th width="5%" align="center"><?php echo "Action"; ?></th>				
												</tr>
											</thead>
											<tbody>
												<?php
												if($DataSteTable!='') {
													$i = 1;
													$fieldArr = array();
													$fieldArr = array('count(*) as total');

													foreach ($DataSteTable as $users_details) {

														$rowClass = 'TableEvenRow';
														if($rowClass == 'TableEvenRow') {
															$rowClass = 'TableOddRow';
														} else {
															$rowClass = 'TableEvenRow';
														}

												?>
												<tr class="<?php echo $rowClass; ?>">
												<td align="center"> <input type="checkbox" name="m_trash" id="<?php echo $users_details['auto_id'];?>"></td>
													<td align="center"><?php echo $i = 1 +$from;?></td>
													<td><?php echo valid_output($users_details['table_name']) ; ?></td>
													<td><?php


													$array_city=array("ADE"=>"Adelaide","BRI"=>"Brisbane","CAN"=>"Canberra","MEL"=>"Melbourne","PER"=>"Perth","SYD"=>"Sydney","DRW"=>"Darwin","HOB"=>"Hobart","LCN"=>"Launceston");
													$zone=strtoupper(substr($users_details['table_name'],0,3));
													$includes_zone=array("ADE","BRI","CAN","MEL","PER","SYD","DRW","HOB","LCN");

													if($zone!=""){
														if(!(in_array($zone,$includes_zone)))
														{
															echo valid_output($zone);
														}
														else
														{
															echo valid_output($array_city[$zone]);
														}
													}

											?>									
											</td>
													<td><?php

													$tblservice=strtoupper(substr(valid_output($users_details['table_name']),3,2));
													if($tblservice!=""){
														echo ucwords(valid_output($service_array[$tblservice]));
													}
											?></td>
													
													<td align="center" nowrap="nowrap">
														<a href="<?php echo FILE_TABLE_ACTION; ?>?pagenum=<?php echo  $pagenum;?>&Action=edit&amp;auto_id=<?php echo $users_details['auto_id'];?>"><?php echo COMMON_EDIT; ?></a> | <a href="<?php echo FILE_TABLE_ACTION; ?>?pagenum=<?php echo  $pagenum;?>&Action=trash&amp;auto_id=<?php echo $users_details['auto_id'].$URLParameters; ?>" onclick="return confirm('<?php echo "Your related tariffs will also be deleted"; ?>')"><?php echo COMMAN_DELETE; ?></a>
														
																											
													</td>
													
												</tr>
												<?php	$from = $from+1;
													}
											 } else 
											 {?>
											<tr>
												 <td width="5%" align="center" colspan="6">  No Table found </td>
											</tr>											 
											 <?php									 	
											 }
											 
											 ?>
											</tbody>
											<tfoot>
												<tr>
													<th></th>
													<th align="center"><?php echo ADMIN_COMMON_SERIAL_NO; ?>&nbsp;</th>
													<th align="center"><?php echo "Table Name"; ?>&nbsp;</th>
													<th align="center"><?php echo "City"; ?>&nbsp;</th>
													<th align="center"><?php echo "Service"; ?>&nbsp;</th>
													<th align="center"><?php echo "Action"; ?>&nbsp;</th>
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
		<td id="footer"><?php require_once(DIR_WS_ADMIN_INCLUDES . ADMIN_FILE_FOOTER);?></td>
	</tr>
</table>
</body>
</html>
