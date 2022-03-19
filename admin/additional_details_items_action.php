<?php
	/**
	 * This file is for add new category
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
	require_once(DIR_WS_MODEL . "AdditionalDetailItemsMaster.php");	
	require_once(DIR_WS_ADMIN_LANGUAGES . DIR_CURRENT_LANGUAGE. '/additional_detail_items.php');
	
	//Object defining 
	$AdditionalDetailItemsMaster	= new AdditionalDetailItemsMaster();
	$AdditionalDetailItemsMaster	= $AdditionalDetailItemsMaster->Create();
	$AdditionalDetailItemsData		= new AdditionalDetailItemsData();
	
	$arr_css_plugin_include[] = 'datatables/css/jquery.dataTables.min.css';	
	$arr_javascript_plugin_include[] = 'datatables/js/jquery.dataTables.min.js';
	$pagenum = ($_GET['pagenum']!="")?($_GET['pagenum']):(1);
	if(!empty($pagenum))
	{
		$err['pagenum'] = isNumeric(valid_input($pagenum),ENTER_NUMERIC_VALUES_ONLY);
	}
	if(!empty($err['pagenum']))
	{
		logOut();
	}
	
	$Id         = trim($_GET['Id']);
	
	if(!empty($Id))
	{
		$err['Id'] = isNumeric(valid_input($Id),ENTER_NUMERIC_VALUES_ONLY);
	}
	if(!empty($err['Id']))
	{
		logOut();
	}
	$submit        = trim($_POST['Submit']);
	$headingLabel  = ADDITIONAL_DETAIL_ITEMS_ADD;
	$btnSubmit	   = ADDITIONAL_DETAIL_ITEMS_ADD;
	$URLParameters = "?pagenum=".$pagenum."&message=".MSG_ADD_SUCCESS;
	
	/*csrf validation*/
	$csrf = new csrf();
	$csrf->action = "additional_details_items_action";
	if(!isset($_POST['ptoken'])) {
		$ptoken = $csrf->csrfkey();
	}

	
	/*csrf validation*/
	if($Id != ""){
		$headingLabel  = ADMIN_ITEM_NAME_MANAGEMENT_EDIT;
		
		if($_GET["Id"] != ""){
			$btnSubmit	   = ADMIN_ITEM_NAME_UPDATE_BUTTON;
		}
		
		$URLParameters = "?pagenum=".$pagenum."&message=".MSG_EDIT_SUCCESS;
	}
	/**
	 * Inclusion and Exclusion Array of Javascript
	 */
	$arr_javascript_include[] = 'tabbed_panels.js';
	$arr_javascript_include[] = 'template_category_action.php';
	
	$arr_css_include[] = DIR_HTTP_ADMIN_CSS.'tabbed_panels.css';
	$arr_css_exclude[] = DIR_HTTP_ADMIN_CSS.'jquery.css';
	
	// ** Fetch Data for Defined Fields ** //
	$FieldArr   = array();
	$FieldArr[] ='count(*) as total';
	
	
	//Get the items name details
	 if($Id != ""){
	 	$sItemName   = array();
     	$sItemName[] = array('Search_On'=>'id', 'Search_Value'=>$Id, 'Type'=>'int', 'Equation'=>'=', 'CondType'=>'AND', 'Prefix'=>'', 'Postfix'=>'');
     	$currentItemDetails = $AdditionalDetailItemsMaster->getAdditionalDetailItems(null,$sItemName);
     	$currentItemDetails = $currentItemDetails[0];
	 }
		//print_R($currentItemDetails);													   
	/**
	 * Add/Edit Faq category Data
	 * 
	 */
	if((isset($submit)) &&  $submit != "") {   

		if(isEmpty(valid_input($_POST['ptoken']), true)){	
			logOut();
		}else{
			//$csrf->checkcsrf($_POST['ptoken']);
		}
		$defaultItemName = $_POST['item_name'];
		
		/**
		 * Server Side Validation
		 */
		$err['entry_itemname'] = isEmpty($defaultItemName, ITEM_NAME_REQUIRED)?isEmpty($defaultItemName, ITEM_NAME_REQUIRED):chkRestFields($defaultItemName);
		
		if(empty($err['entry_itemname'])) {
			
			$fieldArr = array("count(*) as total");
			
			$seaArr[]	=	array('Search_On'=>'item_type',
								'Search_Value'=>$defaultItemName,
								'Type'=>'string',
								'Equation'=>'LIKE',
								'CondType'=>'AND',
								'Prefix'=>'',
								'Postfix'=>'');
			if(!empty($Id)) {
				$seaArr[]	=	array('Search_On'=>'id',
								'Search_Value'=>$Id,
								'Type'=>'int',
								'Equation'=>'!=',
								'CondType'=>'AND',
								'Prefix'=>'',
								'Postfix'=>'');
			}
								
			$countitemname = $AdditionalDetailItemsMaster->getAdditionalDetailItems($fieldArr,$seaArr);
			$countitemname = $countitemname[0]['total'];  // Total Records
			
			if($countitemname > 0){
				$err['entry_itemname'] = ITEM_NAME_EXITS;
			}
		}
		
		foreach ($err as $key => $val){
			if($val != "") {
				$Svalidation=true;
				$ptoken = $csrf->csrfkey();
			}
		}
	    // End of server side validation
	   
		if($Svalidation == false) {
			
			if(isEmpty(valid_input($_POST['ptoken']), true)){	
					logOut();
			}else{
				//$csrf->checkcsrf($_POST['ptoken']);
			}
			/**
			 * This Code is for Add Item Name into site Item name table
			 * 
			 * 
			 */
			if($_GET['Id'] == '')  {				
				
				$AdditionalDetailItemsData->status 		= '1';
				$AdditionalDetailItemsData->item_type 		= $defaultItemName;
				$CurrentItemId = $AdditionalDetailItemsMaster->addAdditionalDetailItems($AdditionalDetailItemsData);
			}
			
			/**
			 * This Code is for Edit Faq Category into site template Category table
			 */
			if($_GET['Id'] != '')  {				
				$AdditionalDetailItemsData->id    = $_GET['Id'];
				$AdditionalDetailItemsData->item_type 		= $defaultItemName;
				$AdditionalDetailItemsData->status 		= 0;
				$CurrentCategoryId = $AdditionalDetailItemsMaster->editAdditionalDetailItems($AdditionalDetailItemsData);
			}
			
						
			
			header("location:".FILE_ADDITIONAL_DETAILS_ITEMS_LISTING.$URLParameters);
			exit;
		}
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php
if(isset($_GET['Id']) && !empty($_GET['Id'])) {
	echo ADMIN_ITEM_NAME_MANAGEMENT_EDIT;
} else {
	echo ADMIN_ITEM_NAME_MANAGEMENT_ADD;
}
?></title>
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
 
<script language="javascript" type="text/javascript" >
function validationitems()	
{
	
	var errorflag = false;
	
	if(trim($("#item_name").val()) == '') {
			$("#itemNameError").html("<?php echo ITEM_NAME_REQUIRED;?>");
			errorflag = true;
	} 
	
	if(errorflag == true){
		return false;	
	}	
	else
		return true;
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
						<table class="middle_right_content" align="center" border="0" cellpadding="0" cellspacing="0">
							<tr>
								<td align="left" class="breadcrumb">
										<span><a href="<?php echo FILE_WELCOME_ADMIN; ?>"><?php echo ADMIN_HEADER_HOME; ?></a> > <a href="<?php echo FILE_ADDITIONAL_DETAILS_ITEMS_LISTING; ?>"><?php echo ADMIN_ADDITIONAL_DETAIL_ITEMS_MANAGEMENT; ?></a> > <?php echo $headingLabel; ?></span>
										<div><label class="top_navigation"><a href="<?php echo FILE_ADDITIONAL_DETAILS_ITEMS_LISTING; ?>"><?php echo ADMIN_COMMON_BACK; ?></a></label></div>
								</td>
							</tr>
							<tr>
								<td class="heading">
									<?php echo $headingLabel; ?>
								</td>
							</tr>
							
							<tr>
								<td align="left">
								<!-- Middle Content -->
								<form name="additional_details_items" method="POST" id="additional_details_items" action="">
									<table width="100%" border="0" cellpadding="0" cellspacing="0">
									
										<tr>
											<td colspan="2">&nbsp;</td>
										</tr>
										
										<tr>
										<td colspan="2" valign="top">
											<table width="100%" border="0" cellpadding="0" cellspacing="0">
											<tr>
											<td><?php echo ADDITIONAL_DETAIL_ITEM_NAME; ?></td>
											<td><input type="text" name="item_name" id="item_name"value="<?php if($currentItemDetails->item_type){ echo $currentItemDetails->item_type; }?>"></td>
											</tr>
											<tr>
											<td></td>
											<td id="itemNameError" class="message_mendatory"><?php if(isset($err['entry_itemname']) && $err['entry_itemname']!=""){ echo $err['entry_itemname'];}?></td>
											</tr>
											</table>
										</td>
										</tr>
										<tr><td colspan="2">&nbsp;</td></tr>
										<tr>
											<td>&nbsp;</td>
											<td>
											<input type="hidden" size="34" id="ptoken" value="<?php echo $ptoken; ?>" name="ptoken">											
											<input type="submit" name="Submit" id="Submit" value="<?php echo $btnSubmit;?>" tabindex="8" class="action_button" onclick="return validationitems();"/>
											<input type="reset" name="btnreset" value="Reset" class="action_button" tabindex="9" onclick="document.additional_details_items.reset();"/>
											<input type="button"  class="action_button" name="cancel" tabindex="10" value="<?php echo ADMIN_COMMON_BUTTON_CANCEL;?>" onclick="javascript:document.location.href='<?php echo FILE_ADDITIONAL_DETAILS_ITEMS_LISTING; ?>';return true;"/>
											</td>
										</tr>
										<tr><td colspan="2">&nbsp;</td></tr>
									
									</table>
									</form>
									<!-- End of Middle Content -->
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
