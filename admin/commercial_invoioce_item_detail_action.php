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
require_once(DIR_WS_MODEL . "CommercialInvoiceMaster.php");
require_once(DIR_WS_MODEL."CommercialInvoiceItemMaster.php");

$arr_javascript_include[] = "commercial_invoice.php";
$arr_javascript_include[] = 'ajex.js';
$arr_javascript_include[] = 'ajax-dynamic-list.js';
$pagenum = ($_GET['pagenum']!="")?($_GET['pagenum']):(1);
if(!empty($pagenum))
{
	$err['pagenum'] = isNumeric(valid_input($pagenum),ENTER_NUMERIC_VALUES_ONLY);
}
if(!empty($err['pagenum']))
{
	logOut();
}
require_once(DIR_WS_ADMIN_LANGUAGES . DIR_CURRENT_LANGUAGE. '/commercial_invoioce_item_detail.php');

/**
* Start :: Object declaration
*/
$ObjCommercialInvoiceMaster	= new CommercialInoviceMaster();
$ObjCommercialInvoiceMaster	= $ObjCommercialInvoiceMaster->Create();
$CommercialInvoiceData		= new CommercialInvoiceData();

$CommercialInvoiceItemMasterObj = new CommercialInvoiceItemMaster();
$CommercialInvoiceItemMasterObj = $CommercialInvoiceItemMasterObj->Create();
$CommercialInvoiceItemDataObj = new CommercialInvoiceItemData();		

/*csrf validation*/
$csrf = new csrf();
$csrf->action = "commercial_invocie_item";
if(!isset($_POST['ptoken'])) {
	$ptoken = $csrf->csrfkey();
}

/*csrf validation*/

/**
* Inclusion and Exclusion Array of Javascript
*/
$arr_javascript_include[] = "postcode_action.php";
/**
	 * Start :: Object declaration
	 */
	$arr_css_plugin_include[] = 'datatables/css/jquery.dataTables.min.css';	
	$arr_javascript_plugin_include[] = 'datatables/js/jquery.dataTables.min.js';

		$btnSubmit = ADMIN_BUTTON_SAVE_POSTCODE;
		$HeadingLabel = ADMIN_LINK_SAVE_POSTCODE;
		$id = $_GET['id'];
		$commercial_item_id = $_GET['commercial_item_id'];
		if(!empty($commercial_item_id))
		{
			$err['commercial_item'] = isNumeric(valid_input($commercial_item_id),ENTER_NUMERIC_VALUES_ONLY);
		}
		if(!empty($err['commercial_item']))
		{
			logOut();
		}
		if(!empty($id))
		{
			$err['id'] = isNumeric(valid_input($id),ENTER_NUMERIC_VALUES_ONLY);
		}
		if(!empty($err['id']))
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
		//$arr_message
		if($_GET['Action']=='trash')
		{
				$fieldArr1=array("commercial_value,commercial_invoice_id");
				$seaByArr1[]=array('Search_On'=>'id', 'Search_Value'=>"$id", 'Type'=>'int', 'Equation'=>'=', 'CondType'=>'and', 'Prefix'=>'', 'Postfix'=>'');
				$find_commercial_value_and_ids=$CommercialInvoiceItemMasterObj->getCommercialInvoiceItem($fieldArr1, $seaByArr1); // Fetch Data	
				$find_commercial_value_and_id = $find_commercial_value_and_ids[0];
				
				$deleted_commecrcial_invoice_id = $find_commercial_value_and_id['commercial_invoice_id'];
				$deleted_commercial_value = $find_commercial_value_and_id['commercial_value'];
				
				
				$fieldArr=array("commercial_total");
				$seaByArr[]=array('Search_On'=>'commercial_invoice_id', 'Search_Value'=>"$deleted_commecrcial_invoice_id", 'Type'=>'int', 'Equation'=>'=', 'CondType'=>'and', 'Prefix'=>'', 'Postfix'=>'');
			
				$find_all_data=$ObjCommercialInvoiceMaster->getCommercialInovice($fieldArr, $seaByArr, $optArr=null, $start=null, $total=null, $ThrowError=true); // Fetch Data

				if(!empty($find_all_data)){$total = $find_all_data[0]['commercial_total'];}else{$total = 0;}
				
				
			 	$commercial_total_for_invloice = $total -$deleted_commercial_value;
	
				$CommercialInvoiceData->commercial_total = $commercial_total_for_invloice;
				$CommercialInvoiceData->commercial_invoice_id = $deleted_commecrcial_invoice_id;
				$ObjCommercialInvoiceMaster->editCommercialInovice($CommercialInvoiceData,true,true);
				
				//find all the invoice items for the commercial invoice id
				$seaByArr3[]=array('Search_On'=>'commercial_invoice_id', 'Search_Value'=>"$deleted_commecrcial_invoice_id", 'Type'=>'int', 'Equation'=>'=', 'CondType'=>'and', 'Prefix'=>'', 'Postfix'=>'');
				
				$find_values=$CommercialInvoiceItemMasterObj->getCommercialInvoiceItem($fieldArr1, $seaByArr3); // Fetch Data	
				
				
				
				if(count($find_values)<=5){
					$CommercialInvoiceItemDataObj->commercial_item_id=1;
					$CommercialInvoiceItemDataObj->commercial_invoice_id=$commercial_item_id;
					$CommercialInvoiceItemDataObj->commercial_description='';
					$CommercialInvoiceItemDataObj->commercial_qty=0;
					$CommercialInvoiceItemDataObj->commercial_currency='';
					$CommercialInvoiceItemDataObj->commercial_unit_value=0;
					$CommercialInvoiceItemDataObj->commercial_value=0;
					$CommercialInvoiceItemDataObj->id = $id;
					$CommercialInvoiceItemMasterObj->editCommercialInvoiceItem($CommercialInvoiceItemDataObj,true,'not_commercial_invoice_id');
					$UParam = "?pagenum=".$pagenum."&message=".MSG_DELETE_COMMERCIAL_ITEM_SUCCESS;
				}else {
					$CommercialInvoiceItemMasterObj->deleteCommercialInvoiceItem2($deleted_commecrcial_invoice_id,true,$commercial_item_id,$id);
					$UParam = "?pagenum=".$pagenum."&message=".MSG_DELETE_KM_GRID_SUCCESS;
				}
			header('Location: '.FILE_COMMERCIAL_INVOICE_ITEM_DETAILS_LISTING.$UParam);
		
		}
if($_GET['Action']=='mtrash'){
	$commercial_invoice_id= $_GET['m_trash_id'];
	$m_t_a=explode(",",$commercial_invoice_id);
	foreach($m_t_a as $val)
	{
		$error = isNumeric(valid_input($val),ENTER_NUMERIC_VALUES_ONLY);
		if(!empty($error))
		{
			logOut();
		}else
		{
			$fieldArr1=array("commercial_value,commercial_invoice_id");
			$seaByArr1[]=array('Search_On'=>'id', 'Search_Value'=>"$val", 'Type'=>'int', 'Equation'=>'=', 'CondType'=>'and', 'Prefix'=>'', 'Postfix'=>'');
			$find_commercial_value_and_ids=$CommercialInvoiceItemMasterObj->getCommercialInvoiceItem($fieldArr1, $seaByArr1); // Fetch Data	
			$find_commercial_value_and_id = $find_commercial_value_and_ids[0];
			
			$deleted_commecrcial_invoice_id = $find_commercial_value_and_id['commercial_invoice_id'];
			$deleted_commercial_value = $find_commercial_value_and_id['commercial_value'];
			
			
			$fieldArr=array("commercial_total");
			$seaByArr[]=array('Search_On'=>'commercial_invoice_id', 'Search_Value'=>"$deleted_commecrcial_invoice_id", 'Type'=>'int', 'Equation'=>'=', 'CondType'=>'and', 'Prefix'=>'', 'Postfix'=>'');
		
			$find_all_data=$ObjCommercialInvoiceMaster->getCommercialInovice($fieldArr, $seaByArr, $optArr=null, $start=null, $total=null, $ThrowError=true); // Fetch Data

			if(!empty($find_all_data)){$total = $find_all_data[0]['commercial_total'];}else{$total = 0;}
			
			
			$commercial_total_for_invloice = $total -$deleted_commercial_value;

			$CommercialInvoiceData->commercial_total = $commercial_total_for_invloice;
			$CommercialInvoiceData->commercial_invoice_id = $deleted_commecrcial_invoice_id;
			$ObjCommercialInvoiceMaster->editCommercialInovice($CommercialInvoiceData,true,true);
			
			//find all the invoice items for the commercial invoice id
			$seaByArr3[]=array('Search_On'=>'commercial_invoice_id', 'Search_Value'=>"$deleted_commecrcial_invoice_id", 'Type'=>'int', 'Equation'=>'=', 'CondType'=>'and', 'Prefix'=>'', 'Postfix'=>'');
			
			$find_values=$CommercialInvoiceItemMasterObj->getCommercialInvoiceItem($fieldArr1, $seaByArr3); // Fetch Data	
			
			
			
			if(count($find_values)<=5){
				$CommercialInvoiceItemDataObj->commercial_item_id=1;
				$CommercialInvoiceItemDataObj->commercial_invoice_id=$commercial_item_id;
				$CommercialInvoiceItemDataObj->commercial_description='';
				$CommercialInvoiceItemDataObj->commercial_qty=0;
				$CommercialInvoiceItemDataObj->commercial_currency='';
				$CommercialInvoiceItemDataObj->commercial_unit_value=0;
				$CommercialInvoiceItemDataObj->commercial_value=0;
				$CommercialInvoiceItemDataObj->id = $id;
				$CommercialInvoiceItemMasterObj->editCommercialInvoiceItem($CommercialInvoiceItemDataObj,true,'not_commercial_invoice_id');
				$UParam = "?pagenum=".$pagenum."&message=".MSG_DELETE_COMMERCIAL_ITEM_SUCCESS;
			}else {
				$CommercialInvoiceItemMasterObj->deleteCommercialInvoiceItem2($deleted_commecrcial_invoice_id,true,$commercial_item_id,$id);
				$UParam = "?pagenum=".$pagenum."&message=".MSG_DELETE_KM_GRID_SUCCESS;
			}
		}
			
	}
	//$UParam = "?pagenum=".$pagenum."&message=".MSG_DELETE_KM_GRID_SUCCESS;
	header('Location: '.FILE_COMMERCIAL_INVOICE_LISTING.$UParam);
}
		
		
		
			
			if((isset($_POST['submit']) && submit != ""))
			{		
					if(isEmpty(valid_input($_POST['ptoken']), true)){	
						logOut();
					}else{
						$csrf->checkcsrf($_POST['ptoken']);
					}
					$err['commercial_invoice_id']	 = (isEmpty(trim($_POST['commercial_invoice_id']),ERROR_COMMERCIAL_REQUIRE))?(isEmpty(trim($_POST['commercial_invoice_id']),ERROR_COMMERCIAL_REQUIRE)):isNumeric(trim($_POST['commercial_invoice_id']),ERROR_COMMERCIAL_ITEM_REQUIRE_IN_NUMERIC);
					$err['commercial_item_id']	= (isEmpty(trim($_POST['commercial_item_id']),ERROR_COMMERCIAL_ITEM_REQUIRE))?isEmpty(trim($_POST['commercial_item_id']),ERROR_COMMERCIAL_ITEM_REQUIRE):isNumeric(trim($_POST['commercial_item_id']),ERROR_COMMERCIAL_ITEM_REQUIRE_IN_NUMERIC);
					if($_POST['origional_invoice_id']!='')
					{
						$err['origional_invoice_id'] = isNumeric(trim($_POST['origional_invoice_id']),ERROR_COMMERCIAL_ITEM_REQUIRE_IN_NUMERIC);
					}
					if(!empty($err['origional_invoice_id']))
					{
						logOut();
					}
					if($_POST['commercial_currency']!='')
					{
						$err['commercial_currency'] = chkCapital(trim($_POST['commercial_currency']));
					}
					if(!empty($err['commercial_currency']))
					{
						logOut();
					}
					if($_POST['commercial_description']!='')
					{
						$err['commercial_description'] = checkStr(valid_input($_POST['commercial_description']));
					}
					if($_POST['commercial_qty'] != '' )
					{
						$err['commercial_qty'] = isNumeric(trim($_POST['commercial_qty']),COMMERCIAL_IS_NUMERIC);
					}
					if($_POST['commercial_unit_value'] != '' )
					{
						$err['commercial_unit_value'] = isNumeric(trim($_POST['commercial_unit_value']),COMMON_SECURITY_ANSWER_ALPHANUMERIC);
					}
					foreach($err as $key => $Value) {
						if($Value != '') {
							$Svalidation=true;
							$ptoken = $csrf->csrfkey();
						}
					}
					if($Svalidation==false)
					{
							
						    $origional_invoice_id = $_GET['origional_invoice_id'];
							$find_commercial_invoice_id = $_POST["commercial_invoice_id"];
							$commercial_total_for_invloice = 0;	
							$seaByCommercialId = array();
							$commercial_total_array = array();
							$seaByArr11 = array();
							$CommercialInvoiceItemDataObj->commercial_item_id=trim($_POST["commercial_item_id"]);
							$fieldArr1=array("commercial_value");
							$seaByArr11[]=array('Search_On'=>'commercial_invoice_id', 'Search_Value'=>"$find_commercial_invoice_id", 'Type'=>'int', 'Equation'=>'=', 'CondType'=>'and', 'Prefix'=>'', 'Postfix'=>'');
							$seaByArr11[]=array('Search_On'=>'commercial_item_id', 'Search_Value'=>"$CommercialInvoiceItemDataObj->commercial_item_id", 'Type'=>'int', 'Equation'=>'=', 'CondType'=>'and', 'Prefix'=>'', 'Postfix'=>'');
							$find_commercial_value_for_existing_commercial_invoice_id=$CommercialInvoiceItemMasterObj->getCommercialInvoiceItem($fieldArr1, $seaByArr11); // Fetch Data
							$find_commercial_invoice_id = $_POST["commercial_invoice_id"];
							if(!empty($find_commercial_value_for_existing_commercial_invoice_id)){  $err['commercial_item_id'] = ERROR_COMMERCIAL_ITEM_EXIST;
							}else
							{
								
									if($id!='')
									{
										  
										    if($origional_invoice_id!=$find_commercial_invoice_id)
										    {
												   $fieldArr21 = array();$seaByArr31=array();
												   $main_id = $id;
												   $fieldArr21=array("*");
												   $seaByArr31[]=array('Search_On'=>'commercial_invoice_id', 'Search_Value'=>"$origional_invoice_id", 'Type'=>'int', 'Equation'=>'=', 'CondType'=>'and', 'Prefix'=>'', 'Postfix'=>'');
												   $toal_find_commercial_value=$CommercialInvoiceItemMasterObj->getCommercialInvoiceItem($fieldArr21, $seaByArr31); // Fetch Data
													//$toal_find_commercial_value = $toal_find_commercial_value[0];
													if (!empty($toal_find_commercial_value)) 
													{
													//	echo "<pre>";print_r($toal_find_commercial_value);die();
														
														foreach ($toal_find_commercial_value as $key => $Value)
														{
															 $commercial_total += $Value['commercial_value'];
														}
													}
												
												if(!empty($toal_find_commercial_value))
												{
													$delete = trim($_POST["commercial_qty"] * $_POST["commercial_unit_value"]);
													$updatedValueOfCommercialTotalOfMainInvoiceId1 = $commercial_total -$delete;
													$CommercialInvoiceData->commercial_total = $updatedValueOfCommercialTotalOfMainInvoiceId1;
													$CommercialInvoiceData->commercial_invoice_id = $origional_invoice_id;
													$commercialInvoice = $ObjCommercialInvoiceMaster->editCommercialInovice($CommercialInvoiceData,true,true);
												}
										    }
										
										    
										
									}
									
									$CommercialInvoiceItemDataObj->commercial_invoice_id =trim($_POST["commercial_invoice_id"]);
									$CommercialInvoiceItemDataObj->commercial_description =trim($_POST["commercial_description"]);
									$CommercialInvoiceItemDataObj->commercial_qty =trim($_POST["commercial_qty"]);
									$CommercialInvoiceItemDataObj->commercial_currency =trim($_POST["commercial_currency"]);
									$CommercialInvoiceItemDataObj->commercial_unit_value =trim($_POST["commercial_unit_value"]);
									$CommercialInvoiceItemDataObj->commercial_value =trim($_POST["commercial_qty"] * $_POST["commercial_unit_value"]);
									
									
									
									
									
									
									if($id!='')
									{
											$CommercialInvoiceItemDataObj->id=$id;
											$commercialInvoice=$CommercialInvoiceItemMasterObj->editCommercialInvoiceItem($CommercialInvoiceItemDataObj,true,true);
											$commercialInvoice = mysql_affected_rows();
											if ( $commercialInvoice>0) {$message=MSG_EDIT_KMGRID_SUCCESS;}
				
									}else 
									{
											$commercialInvoiceId = $CommercialInvoiceItemMasterObj->addCommercialInvoiceItem($CommercialInvoiceItemDataObj);
											$commercialInvoice = $commercialInvoiceId;
											if($commercialInvoice){$message=MSG_ADD_COMMERCIAL_SUCCESS;}
									}
									
								//	echo "<pre>";print_r($commercial_total_for_invloice);
									if($commercialInvoice!=""){
											$fieldArr1=array("commercial_value");
											$seaByArr1[]=array('Search_On'=>'commercial_invoice_id', 'Search_Value'=>"$find_commercial_invoice_id", 'Type'=>'int', 'Equation'=>'=', 'CondType'=>'and', 'Prefix'=>'', 'Postfix'=>'');
											$find_commercial_value=$CommercialInvoiceItemMasterObj->getCommercialInvoiceItem($fieldArr1, $seaByArr1); // Fetch Data
											
											if (!empty($find_commercial_value)) {
											//echo "<pre>";print_r($find_commercial_value);die();
											
											foreach ($find_commercial_value as $key => $Value)
											{
												 $commercial_total_for_invloice += $Value['commercial_value'];
											}
											}
										
											$CommercialInvoiceData->commercial_total = $commercial_total_for_invloice;
											$CommercialInvoiceData->commercial_invoice_id = $find_commercial_invoice_id;
											$commercialInvoice = $ObjCommercialInvoiceMaster->editCommercialInovice($CommercialInvoiceData,true,true);
											$commercialInvoice = mysql_affected_rows();
											
											if($commercialInvoice>0){$message=MSG_EDIT_KMGRID_SUCCESS;}
											
											
									}
								header('Location:'.FILE_COMMERCIAL_INVOICE_ITEM_DETAILS_LISTING."?pagenum=".$pagenum."&message=".$message);
							exit();
							}
							
							
							
					
					}
					/*}*/
					
			}
	$seaByArr = array();
	$fieldArr = array();
	$seaBy = array();
	if($id!='')
	{
		$fieldArr=array("*");
		$seaBy[]=array('Search_On'=>'id', 'Search_Value'=>"$id", 'Type'=>'int', 'Equation'=>'=', 'CondType'=>'and', 'Prefix'=>'', 'Postfix'=>'');
		$CommercialInvoice = $CommercialInvoiceItemMasterObj->getCommercialInvoiceItem($fieldArr, $seaBy); // Fetch Data
		$CommercialInvoiceDatas = $CommercialInvoice[0];
		
		$btnSubmit = ADMIN_BUTTON_UPDATE_POSTCODE;
		$HeadingLabel = ADMIN_LINK_UPDATE_POSTCODE;
	}
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php if ($_GET['commercial_invoice_id']=='') { echo ADMIN_ADD_USER; } else { echo ADMIN_EDIT_USER;}?></title>
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
				<span><a href="<?php echo FILE_WELCOME_ADMIN; ?>"><?php echo ADMIN_HEADER_HOME; ?></a> > <a href="<?php echo FILE_COMMERCIAL_INVOICE_ITEM_DETAILS_LISTING."?pagenum=".$pagenum; ?>"> <?php echo ADMIN_HEADER_KM_GRID; ?> </a> > <? echo $HeadingLabel; ?></span>
				<div><label class="top_navigation"><a href="<?php echo FILE_COMMERCIAL_INVOICE_ITEM_DETAILS_LISTING."?pagenum=".$pagenum; ?>"><?php echo ADMIN_COMMON_BACK; ?></a></label></div>
		</td>
	</tr>
	<tr>
		<td class="heading">
			<?php echo $HeadingLabel; ?>
		</td>
	</tr>
	
					
					
					<?php
					if($message!='')
					{ ?>
					<tr>
						<td class="message_error noprint" align="center"><?php echo $arr_message[$message] ; ?>
						<?php } ?>
						</td>
					</tr>
					
					
	<tr>
		<td align="center">
			<?php  /*** Start :: Listing Table ***/ ?>
			
			<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
				
				<form name="frmuser" method="POST"  action="">
				<input type="hidden" name="Id" value="<?php echo $id;?>"  />
				<input type="hidden" name="origional_invoice_id" value="<?php echo $CommercialInvoiceDatas['commercial_invoice_id'];?>"  />
				
				<tr>
					<td>
						<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
							<tr>
								<td>
									<table width="98%" border="0" cellpadding="0" border="0" cellspacing="0" >
										<tr>
											<td class="message_mendatory" align="right" colspan="4">
												<?echo ADMIN_COMMAN_REQUIRED_INFO;?>
											</td>
										</tr>
										<tr>
											<td colspan="4" align="left" valign="top" class="grayheader"><b><?php echo ADMIN_USERS_PERSONAL_DETAILS;?> : </b></td>
										</tr>
										<tr><td colspan="4">&nbsp;</td></tr>
										<tr>
											<td  align="left" valign="middle"><?php echo COMMERCIAL_INVOICE_ID;?></td>
											<td  align="left" valign="middle"  class="message_mendatory">
											<?php
														$field=array("commercial_invoice_id");
														$optArr2[]	=	array("Order_By" => "commercial_invoice_id");
														$CommercialInvoiceId=$ObjCommercialInvoiceMaster->getCommercialInovice($field,null,$optArr2,null, null, true,true);	
												
														$countryOutput.="<select name='commercial_invoice_id'   id='pickup_chargingzone' onchange='javascript:getBookingIdofUser(this.value);' >
														<option value=''>SELECT COMMERCIAL INVOICE ID</option>";
														if($CommercialInvoiceId!=''){     		
														foreach($CommercialInvoiceId as $commercial_invoice)
																{			$cond = ($commercial_invoice["commercial_invoice_id"]==$CommercialInvoiceDatas['commercial_invoice_id'])?("selected"):('');
																			 $countryname=$commercial_invoice["commercial_invoice_id"];
																			 $countryOutput.='<option value="'.$commercial_invoice["commercial_invoice_id"].'"';
																			 $countryOutput.=$cond;
																		 $countryOutput.='  >'.$countryname.'</option>';
																} 
														}
										               	$countryOutput.="</select>";
										                echo $countryOutput;
											?>
											&nbsp;*<img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>help_up.gif" class="help_btn" alt="<?php echo COMMERCIAL_INVOICE_ID;?>"onmouseover="return overlib('<?php echo $Commercial_Invoice_Id;?>');" onmouseout="return nd();" /> </td>
											<td  align="left" valign="middle"><?php echo COMMERCIAL_ITEM_ID;?></td>
											<td  align="left" valign="top" class="message_mendatory">
											<input type="text" name="commercial_item_id" id="commercial_item_id" value="<?php if($_POST['commercial_item_id'] != ''){ echo $_POST['commercial_item_id'];}else{ echo $CommercialInvoiceDatas["commercial_item_id"]; } ?>"/>
											&nbsp;*<img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>help_up.gif" class="help_btn" alt="<?php echo COMMERCIAL_ITEM_ID;?>"onmouseover="return overlib('<?php echo $Item_Id;?>');" onmouseout="return nd();" /></td>
										</tr>
										
										<tr>
											<td align="left" valign="middle">&nbsp;</td>
											<td align="left" valign="top" class="message_mendatory" id="from_vehicle_sizeError"><?php echo $err['commercial_invoice_id'];  ?></td>
											<td align="left" valign="middle">&nbsp;</td>
											<td align="left" valign="top" class="message_mendatory" id="to_vehicle_sizeError"><?php echo $err['commercial_item_id'];  ?></td>
										</tr>
										
										<tr>
											<td align="left" valign="middle"  nowrap="nowrap"><?php echo COMMERCIAL_FULL_DESCRIPTION;?></td>
											<td  align="left" valign="middle" class="message_mendatory"><input name="commercial_description" class="textbox"  value="<?php if($_POST['commercial_description'] != ''){ echo valid_output($_POST['commercial_description']);}else{ echo valid_output($CommercialInvoiceDatas["commercial_description"]); } ?>" tabindex="20"/>&nbsp;</td>
											<td align="left" valign="middle"><?php echo COMMERCIAL_QUANTITY;?></td>
											<td align="left" valign="top">
											<input name="commercial_qty" class="textbox"  value="<?php if($_POST['commercial_qty'] != ''){ echo valid_output($_POST['commercial_qty']);}else{ echo valid_output($CommercialInvoiceDatas["commercial_qty"]); } ?>" tabindex="20"/>&nbsp;</td>
										<tr>
											<td>&nbsp;</td>			
											<td class="message_mendatory"><?php if(isset($err['commercial_description']) && $err['commercial_description']!=''){ echo $err['commercial_description'];} ?></td>			
											<td class="message_mendatory">&nbsp;</td>
											<td class="message_mendatory"><?php if(isset($err['commercial_qty']) && $err['commercial_qty']!=''){ echo $err['commercial_qty'];} ?>&nbsp;</td>
											<td class="message_mendatory"></td>
										</tr>
									
										<tr>
											<td  align="left" valign="middle"><?php echo COMMERCIAL_CURRENCY;?></td>
											<td  align="left" valign="middle" class="message_mendatory">
											
											<?php
														$currency_array=array("INR","AUD","GBP");
														
														$currencyOutput ="<select name='commercial_currency'>
														<option value=''>SELECT CURRENCY</option>";
															
														foreach($currency_array as $key)
																{			$cond = ($key==$CommercialInvoiceDatas['commercial_currency'])?("selected"):('');
																			 
																			 $currencyOutput.='<option value="'.$key.'"';
																			 $currencyOutput.=$cond;
																		 $currencyOutput.='  >'.$key.'</option>';
																} 
														
										               	$currencyOutput.="</select>";
										                echo $currencyOutput;
											?>
											&nbsp;</td>
											<td  align="left" valign="middle"><?php echo COMMERCIAL_UNIT_VALUE;?></td>
											<td  align="left" valign="middle" class="message_mendatory"><input name="commercial_unit_value" class="textbox"  value="<?php if($_POST['commercial_unit_value'] != ''){ echo valid_output($_POST['commercial_unit_value']);}else{ echo valid_output($CommercialInvoiceDatas["commercial_unit_value"]); } ?>" tabindex="23"/>&nbsp;</td>
										</tr>
										<tr>
											<td>&nbsp;</td>			
											<td>&nbsp;</td>			
											<td>&nbsp;</td>			
											<td class="message_mendatory"><?php if(isset($err['commercial_unit_value']) && $err['commercial_unit_value']!=''){ echo $err['commercial_unit_value'];} ?></td>			
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
					<input type="hidden" size="34" id="ptoken" value="<?php echo $ptoken; ?>" name="ptoken">
					<input type="submit" class="action_button" tabindex="36" name="submit" value="<?php echo $btnSubmit; ?>" onclick=" return commercial_validation(this.form);" >
					<input type="reset" tabindex="37" name="reset" class="action_button" value="<?php echo ADMIN_COMMON_BUTTON_RESET; ?>" >
					<input type="button"  class="action_button" name="cancel" tabindex="38" value="<?php echo ADMIN_COMMON_BUTTON_CANCEL;?>" onclick="javascript:document.location.href='<?php echo FILE_COMMERCIAL_INVOICE_ITEM_DETAILS_LISTING."?pagenum=".$pagenum; ?>';return true;"/>
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
				</tr>
				</form>
			</table>
			<?php  /*** End :: Listing Table ***/ ?>
		</td>
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

