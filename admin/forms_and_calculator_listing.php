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
	require_once(DIR_WS_MODEL."/FormsCalculatorMaster.php");
	require_once(DIR_WS_ADMIN_LANGUAGES . DIR_CURRENT_LANGUAGE. "/forms_calculator.php");	 
	// Object Declaration
	$FormsCalculatorMasterObj = new FormsCalculatorMaster();
	$FormsCalculatorMasterObj = $FormsCalculatorMasterObj->Create();
	$FormsCalculatorDataObj= new FormsCalculatorData();
	
	$path_forms = SITE_DOCUMENT_ROOT."pdf/forms/";
	$arr_javascript_plugin_include[] = 'datatables/datatables.min.js';

	$arr_css_plugin_include[] = 'datatables/datatables.min.css';
	$arr_css_plugin_include[] = 'datatables/Buttons-1.6.5/css/buttons.dataTables.min.css';
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
		$message = $arr_message[$_GET['message']];            		if(!empty($message))		{			$err['message'] = specialcharaChk(valid_input($message));		}		if(!empty($err['message']))		{			logOut();		}	
		$status      = trim($_GET['changestatus']);		if($status != '')		{			$err['status'] = isNumeric($status,ENTER_VALUE_IN_NUMERIC);		}		if(!empty($err['status']))		{			logOut();		}
		$fid         = trim($_GET['fid']);		if($fid != '')		{			$err['fid'] = isNumeric($fid,ENTER_VALUE_IN_NUMERIC);		}		if(!empty($err['fid']))		{			logOut();		}
		$action	     = trim($_GET['Action']);		if($action != '')		{			$err['action'] = chkStr($action);		}		if(!empty($err['action']))		{			logOut();		}		if($_GET['deleteid'] != '')		{			$err['deleteid'] = isNumeric($_GET['deleteid'],ENTER_VALUE_IN_NUMERIC);		}		if(!empty($err['deleteid']))		{			logOut();		}		
				
	/**
	 * Change status for an id
	 */
		if(isset($fid) && !empty($fid) && isset($status)) {
			$seaArr = array();
			$seaArr[]	=	array('Search_On'    => 'frm_id',
			                      'Search_Value' => $fid,
			                      'Type'         => 'int',
			                      'Equation'     => '=',
			                      'CondType'     => 'AND',
			                      'Prefix'       => '',
			                      'Postfix'      => '');
			
			$FormsCalculatorDataObj= $FormsCalculatorMasterObj->getFormsCalculator("*",$seaArr);
			$FormsCalculatorDataObj=$FormsCalculatorDataObj[0];
			$FormsCalculatorDataObj->status =$status;
			$testimonialId = $FormsCalculatorMasterObj->editFormsCalculator($FormsCalculatorDataObj);			
			header("Location: ".FILE_ADMIN_FORMS_AND_CALCULATOR_LISTING."?message=ss");
			exit;
		}
	
	
	
		
	
	//Deleting 	of records
	if(isset($action) && $action=="del" && !empty($_GET['deleteid'])) {
		$delete_id = $_GET['deleteid'];
		$seaArr = array();
			$seaArr[]	=	array('Search_On'    => 'frm_id',
			                      'Search_Value' => $delete_id,
			                      'Type'         => 'int',
			                      'Equation'     => '=',
			                      'CondType'     => 'AND',
			                      'Prefix'       => '',
			                      'Postfix'      => '');
			
			$FormsCalculatorDataObj= $FormsCalculatorMasterObj->getFormsCalculator("*",$seaArr);
			$FormsCalculatorDataObj=$FormsCalculatorDataObj[0];
			$old_path=$FormsCalculatorDataObj->link_path;
			if($FormsCalculatorMasterObj->deleteFormsCalculator($delete_id)) {
				if (file_exists($path_forms.$old_path)) {
					unlink($path_forms.$old_path);
				}
			}
       	header("Location: ".FILE_ADMIN_FORMS_AND_CALCULATOR_LISTING."?message=ds");
        exit;
	} 	
	
	//Multiple delete
	if($_GET['Action']=='mtrash' && !empty($_GET['m_trash_id'])){
	$auto_id= $_GET['m_trash_id'];
	$m_t_a=explode(",",$auto_id);
	foreach($m_t_a as $val)
	{
		$delete_id = $val;		$error = isNumeric(valid_input($val),ENTER_NUMERIC_VALUES_ONLY);		if(!empty($error))		{			logOut();		}else		{
		$seaArr = array();
			$seaArr[]	=	array('Search_On'    => 'frm_id',
			                      'Search_Value' => $delete_id,
			                      'Type'         => 'int',
			                      'Equation'     => '=',
			                      'CondType'     => 'AND',
			                      'Prefix'       => '',
			                      'Postfix'      => '');
			
			$FormsCalculatorDataObj= $FormsCalculatorMasterObj->getFormsCalculator("*",$seaArr);
			$FormsCalculatorDataObj=$FormsCalculatorDataObj[0];
			$old_path=$FormsCalculatorDataObj->link_path;
			if($FormsCalculatorMasterObj->deleteFormsCalculator($delete_id)) {
				if (file_exists($path_forms.$old_path)) {
					unlink($path_forms.$old_path);
				}
			}       		}
	}	
		header("Location: ".FILE_ADMIN_FORMS_AND_CALCULATOR_LISTING."?message=ds");
        exit;		
   }
	
	//Displays all the records

	$FormsCalculatorDataObj= $FormsCalculatorMasterObj->getFormsCalculator("*");
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo ADMIN_TESTIMONIAL_MANAGEMENT_LISTING?></title>
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
									<span><a href="<?php echo FILE_WELCOME_ADMIN; ?>"><?php echo ADMIN_HEADER_HOME;?></a> > <?php echo ADMIN_HEADER_FORMS_MANAGEMENT; ?></span>
									<div><label class="top_navigation"><a onclick="mtrash('<?php echo   FILE_ADMIN_FORMS_AND_CALCULATOR_LISTING;?>','<?php echo "Are you sure you want to delete ?"; ?>');"><?php echo COMMAN_DELETE; ?></a>
									<label class="top_navigation"><a href="<?php echo FILE_ADMIN_FORMS_AND_CALCULATOR; ?>"><?php echo ADMIN_FORMS_ADD ; ?></a></label></div>
									</td>
								</tr>
								<tr>															
									<td class="heading">
										<?php echo ADMIN_HEADER_FORMS_MANAGEMENT; ?>
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
											<th width="5%" align="center"> <input type="checkbox" name="m_trash_main" id="m_trash_all" > </th>
												<th width="10%" align="center"><?php echo ADMIN_COMMON_SERIAL_NO;?></th>
												<th width="30%" align="center"><?php echo ADMIN_FORMS_TITLE;?></th>
												<th width="30%" align="center"><?php echo ADMIN_FORMS_URL;?></th>
												<th width="10%" align="center"><?php echo ADMIN_COMMON_STATUS;?></th>
												<th width="10%" align="center"><?php echo ADMIN_FORMS_TYPE;?></th>
												<th width="10%" align="center"><?php echo ADMIN_COMMON_ACTION;?></th>
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
											if($FormsCalculatorDataObj!=""){ 			
											foreach ($FormsCalculatorDataObj as $record){ 
												
												if($rowClass == 'TableEvenRow') {
													$rowClass = 'TableOddRow';
												} else {
													$rowClass = 'TableEvenRow';
												}
												?>
											<tr class="<?echo $rowClass?>" >
											<td align="center"> <input type="checkbox" name="m_trash" id="<?php echo $record->frm_id;?>"></td>
												<td align="center"><?php echo $i; $i++; ?></td>
												<td><?php echo $record->title; ?></td>
												<td>
												<?php if($record->link_type==2){?>
													<a href="<?php echo $record->link_url.$record->link_path;?>" target="_blank">
														<?php echo $record->link_url.$record->link_path; ?>
													</a>
													<?php } else {?> 
													<a href="<?php echo $record->link_url;?>" target="_blank">
														<?php echo $record->link_url; ?>
													</a>
												<?php }?>
												</td>
												
												<?php $statusDetails= ADMIN_COMMON_STATUS_INACTIVE;
													  $changeStaus='1';
												      if ($record->status==1){
													  	$statusDetails= ADMIN_COMMON_STATUS_ACTIVE;
													  	$changeStaus='0';
												      }
													  ?>
												<td align="center" class="link_small"><a href="<?php echo FILE_ADMIN_FORMS_AND_CALCULATOR_LISTING; ?>?changestatus=<?php echo $changeStaus; ?>&fid=<?php echo $record->frm_id.$query_string.$URLParameters;?>" id=""><?php echo $statusDetails ?></td>
												<td align="center">
													<?php if($record->link_type==1){ ?>
														Normal Link
													<?php } else if($record->link_type==2){ ?>
														PDF / DOC File
													<?php } else if($record->link_type==3){ ?>
														Print
													<?php }?>
												</td>
												<td align="center" class="link_small"><a href="<?php echo FILE_ADMIN_FORMS_AND_CALCULATOR; ?>?edit=<?php echo $record->frm_id;?><?php echo $query_string; ?><?php echo $URLParameters;?>"><?php echo COMMON_EDIT;?> </a> | <a href="<?php  echo FILE_ADMIN_FORMS_AND_CALCULATOR_LISTING?>?deleteid=<?php echo $record->frm_id;?>&Action=del<?php echo $URLParameters;?>"><?php echo COMMAN_DELETE;?></a></td>
											</tr>
											<?php } }?>
											<tbody>
											<tfoot>
												<tr>
													<th>&nbsp;</th>
													<th align="center"><?php echo ADMIN_COMMON_SERIAL_NO;?>&nbsp;</th>	
													<th align="left"><?php echo ADMIN_FORMS_TITLE;?>&nbsp;</th>
													<th><?php echo ADMIN_FORMS_URL;?>&nbsp;</th>
													<th><?php echo ADMIN_COMMON_STATUS;?>&nbsp;</th>
													<th><?php echo ADMIN_FORMS_TYPE;?>&nbsp;</th>
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

