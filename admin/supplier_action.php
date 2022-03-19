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
require_once(DIR_WS_ADMIN_LANGUAGES . DIR_CURRENT_LANGUAGE. '/supplier.php');
require_once(DIR_WS_MODEL . "SupplierData.php");
require_once(DIR_WS_MODEL . "SupplierMaster.php");
require_once(DIR_WS_MODEL . "CodeMaster.php");

$ObjSupplierMaster	= new SupplierMaster();
$ObjSupplierMaster	= $ObjSupplierMaster->Create();
$SupplierData		= new SupplierData();

$ObjCodeMaster	= new CodeMaster();
$ObjCodeMaster	= $ObjCodeMaster->Create();
$CodeData		= new CodeData();


$arr_javascript_plugin_include[] = 'datatables/datatables.min.js';

$arr_css_plugin_include[] = 'datatables/datatables.min.css';
$arr_css_plugin_include[] = 'datatables/Buttons-1.6.5/css/buttons.dataTables.min.css';
$pagenum = ($_GET['pagenum']!="")?($_GET['pagenum']):(1);
if($_GET['pagenum']!=''){
	$pagenum=$_GET['pagenum'];
}else{
	$pagenum= 1;
}
if(!empty($pagenum))
{
	$err['pagenum'] = isNumeric(valid_input($pagenum),ENTER_NUMERIC_VALUES_ONLY);
}
if(!empty($err['pagenum']))
{
	logOut();
}
$arr_javascript_include[] = "jquery.dataTables.js";

$btnSubmit = ADMIN_BUTTON_SAVE_SUPPLIER;
$HeadingLabel = ADMIN_LINK_SAVE_SUPPLIER;
$auto_id = $_GET['auto_id'];
if(!empty($auto_id))
{
	$err['auto_id'] = isNumeric(valid_input($auto_id),ENTER_NUMERIC_VALUES_ONLY);
}
if(!empty($err['auto_id']))
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
if($_GET['Action']=='trash'){

	$ObjSupplierMaster->deleteSupplier($auto_id);
	$UParam = "?pagenum=".$pagenum."&message=".MSG_DELETE_SUPPLIER_SUCCESS;
	header('Location: '.FILE_SUPPLIER_MANAGMENT.$UParam);
}


if($_GET['Action']=='mtrash'){
	$auto_id = $_GET['m_trash_id'];
	$m_t_a=explode(",",$auto_id);
	foreach($m_t_a as $val)
	{
		$error = isNumeric(valid_input($val),ENTER_NUMERIC_VALUES_ONLY);
		if(!empty($error))
		{
			logOut();
		}else
		{
			$ObjSupplierMaster->deleteSupplier($val);
		}
	}
	$UParam = "?pagenum=".$pagenum."&message=".MSG_DELETE_SUPPLIER_SUCCESS;
	header('Location: '.FILE_SUPPLIER_MANAGMENT.$UParam);


}
/*csrf validation*/
$csrf = new csrf();
$csrf->action = "supplier_action";
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
	
	$err['supplierError'] = isEmpty($_POST['supplier_name'], ADMIN_SUPPLIER_IS_REQUIRED)?isEmpty($_POST['supplier_name'], ADMIN_SUPPLIER_IS_REQUIRED):checkStr($_POST['supplier_name']);
	$supplier_name=ucfirst($_POST['supplier_name']);
	$supplier_code=$_POST['code'];
	if(isset($_POST['code_formate']) && $_POST['code_formate']=="")
	{
		$err['codeFormatError'] = ERROR_SELECT_CODE_FORMAT;
	}
	if($auto_id==''){

		$fieldArr=array("*");
		$seaByArr=array();
		$seaByArr[]=array('Search_On'=>'supplier_name', 'Search_Value'=>$supplier_name, 'Type'=>'string', 'Equation'=>'=', 'CondType'=>'', 'Prefix'=>'and', 'Postfix'=>'');

		$DataSupplier=$ObjSupplierMaster->getSupplier($fieldArr,$seaByArr); // Fetch Data

		$DataSupplier = $DataSupplier[0];
		if(!empty($DataSupplier))
		{
			$err['supplierError'] 		 = ADMIN_SUPPLIER_EXIST;
		}

		if($supplier_name!="Startrack")
		{
			$err['codeError'] 		 = isEmpty($supplier_code, ADMIN_SUPPLIER_CODE_IS_REQUIRED)?isEmpty($supplier_code, ADMIN_SUPPLIER_CODE_IS_REQUIRED):checkStr($supplier_code);

			$fieldArr=array("*");
			$seaByArr=array();
			$seaByArr[]=array('Search_On'=>'code', 'Search_Value'=>$supplier_code, 'Type'=>'string', 'Equation'=>'=', 'CondType'=>'', 'Prefix'=>'and', 'Postfix'=>'');

			$DataSupplier=$ObjSupplierMaster->getSupplier($fieldArr,$seaByArr); // Fetch Data

			$DataSupplier = $DataSupplier[0];
			if(!empty($DataSupplier))
			{
				$err['codeError'] 		 = ADMIN_SUPPLIER_CODE_EXIST;
			}
		}


	}
	else {

		$fieldArr=array("*");
		$seaByArr=array();
		$seaByArr[]=array('Search_On'=>'supplier_name', 'Search_Value'=>$supplier_name, 'Type'=>'string', 'Equation'=>'=', 'CondType'=>'', 'Prefix'=>'and', 'Postfix'=>'');
		$seaByArr[]=array('Search_On'=>'auto_id', 'Search_Value'=>$auto_id, 'Type'=>'int', 'Equation'=>'!=', 'CondType'=>'', 'Prefix'=>'and', 'Postfix'=>'');

		$DataSupplier=$ObjSupplierMaster->getSupplier($fieldArr,$seaByArr); // Fetch Data

		$DataSupplier = $DataSupplier[0];
		if(!empty($DataSupplier))
		{
			$err['supplierError'] 		 = ADMIN_SUPPLIER_EXIST;
		}


		if($supplier_name!="Startrack")
		{
			$err['codeError'] 		 = isEmpty($supplier_code, ADMIN_SUPPLIER_CODE_IS_REQUIRED)?isEmpty($supplier_code, ADMIN_SUPPLIER_CODE_IS_REQUIRED):checkStr($supplier_code);

			$fieldArr=array("*");
			$seaByArr=array();
			$seaByArr[]=array('Search_On'=>'code', 'Search_Value'=>$supplier_code, 'Type'=>'string', 'Equation'=>'=', 'CondType'=>'', 'Prefix'=>'and', 'Postfix'=>'');
			$seaByArr[]=array('Search_On'=>'auto_id', 'Search_Value'=>$auto_id, 'Type'=>'int', 'Equation'=>'!=', 'CondType'=>'', 'Prefix'=>'and', 'Postfix'=>'');

			$DataSupplier=$ObjSupplierMaster->getSupplier($fieldArr,$seaByArr); // Fetch Data

			$DataSupplier = $DataSupplier[0];
			if(!empty($DataSupplier))
			{
				$err['codeError'] 		 = ADMIN_SUPPLIER_CODE_EXIST;
			}
		}

	}
	
		
	if($_POST['fuel_charge'] != '')
	{
		$err['fuelChargeError'] = isFloat($_POST['fuel_charge'],"Enter float values.");
	}
	
	/**
            		 * Checking Error Exists
            		 */
	foreach($err as $key => $Value) {
		if($Value != '') {
			$Svalidation=true;
			$ptoken = $csrf->csrfkey();
		}
	}

	if($Svalidation==false){
		
		$SupplierData->supplier_name = ucwords(trim($supplier_name));
		if($supplier_name=="startrack")
		{
			$SupplierData->code ="";
		}
		else {
			$SupplierData->code = strtolower(trim($supplier_code));
		}
		$SupplierData->fuel_charge = strtolower(trim($_POST["fuel_charge"]));
		$SupplierData->code_formate = trim($_POST["code_formate"]);
		if($auto_id!='')
		{
			$SupplierData->auto_id = $auto_id;
			$ObjSupplierMaster->editSupplier($SupplierData);
			$UParam = "?pagenum=".$pagenum."&message=".MSG_EDIT_SUPPLIER_SUCCESS;
		}
		else
		{
			$auto_id=$ObjSupplierMaster->addSupplier($SupplierData);
			$UParam = "?pagenum=".$pagenum."&message=".MSG_ADD_SUPPLIER_SUCCESS;
		}
		header('Location: '.FILE_SUPPLIER_MANAGMENT.$UParam);


	}
}

/**
            	 * Gets details for the user
            	 */

if($auto_id!=''){

	$fieldArr=array("*");
	$seaByArr=array();
	$seaByArr[]=array('Search_On'=>'auto_id', 'Search_Value'=>$auto_id, 'Type'=>'int', 'Equation'=>'=', 'CondType'=>'', 'Prefix'=>'and', 'Postfix'=>'');

	$DataSupplier=$ObjSupplierMaster->getSupplier($fieldArr,$seaByArr); // Fetch Data

	$DataSupplier = $DataSupplier[0];

	//Get sign up Address

	//Variable declaration

	$btnSubmit = ADMIN_BUTTON_UPDATE_SUPPLIER;
	$HeadingLabel = ADMIN_LINK_UPDATE_SUPPLIER;
}

            ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title><?php if ($_GET['auto_id']=='') { echo ADMIN_ADD_USER; } else { echo ADMIN_EDIT_USER;}?></title>
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
                                            <span><a href="<?php echo FILE_WELCOME_ADMIN; ?>"><?php echo ADMIN_HEADER_HOME; ?></a> > <a href="<?php echo FILE_SUPPLIER_MANAGMENT.'?pagenum='.$pagenum; ?>"> <?php echo ADMIN_HEADER_SUPPLIER; ?> </a> > <? echo $HeadingLabel; ?></span>
                                            <div><label class="top_navigation"><a href="<?php echo FILE_SUPPLIER_MANAGMENT.'?pagenum='.$pagenum; ?>"><?php echo ADMIN_COMMON_BACK; ?></a></label></div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="center">
                                            <?php  /*** Start :: Listing Table ***/ ?>
                                            <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
                                                <form name="frmtable" method="POST" action="" enctype="multipart/form-data" id="frmtable">
                                                    <input type="hidden" name="Id1" value="<?php //echo $maximum_id[0] || $_GET['Id'];?>" />
                                                    <tr>
                                                        <td>
                                                            <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
                                                                <tr>
                                                                    <td>
                                                                        <table width="98%" border="0" cellpadding="0" border="0" cellspacing="0">
                                                                            <tr>
                                                                                <td class="message_mendatory" align="right" colspan="4">
                                                                                    <?php echo ADMIN_COMMAN_REQUIRED_INFO;?>
                                                                                </td>
                                                                            </tr>
                                                                            <?php if(!empty($err))
                                                                            {
                                                                            	foreach ($err as $err_val)
                                                                            	{
                                                                                    	?>
                                                                            <tr>
                                                                                <td colspan="4" class="message_mendatory" align="left"><?php echo valid_output($err_val); ?></td>
                                                                            </tr>
                                                                            <?php
                                                                            	}
                                                                            }
                                                                                   ?>
                                                                            <tr>
                                                                                <td colspan="4">&nbsp;</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td align="left" valign="middle"><?php echo "Supplier Name";?></td>
                                                                                <td align="left" valign="middle" class="message_mendatory">
                                                                                    <input type="text" id="supplier_name" name="supplier_name" value="<?php if($_POST['supplier_name'] != ''){ echo $_POST['supplier_name'];}else{ echo valid_output($DataSupplier["supplier_name"]); }?>" />
                                                                                    &nbsp;*<img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>internal/help_up.gif" class="help_btn" alt="<?php echo "Supplier Name";?>" onmouseover="return overlib('<?php echo "Supplier Name";;?>');" onmouseout="return nd();" />
                                                                                    <span class="message_mendatory"><?php echo $err['supplierError'];  ?></span>
                                                                                </td>
                                                                                <td align="left" valign="top" class="message_mendatory" id="countryError"></td>
                                                                                <td align="left" valign="top" class="message_mendatory">
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td align="left" valign="middle" colspan="4"><br /></td>
                                                                            </tr>
                                                                             <tr>
                                                                                <td align="left" valign="middle"><?php echo "Supplier Code";?></td>
                                                                                <td align="left" valign="middle" class="message_mendatory">
                                                                                    <input type="text" id="code" name="code" value="<?php if($_POST['code'] != ''){ echo $_POST['code'];}else{ echo valid_output($DataSupplier["code"]); }?>" />
                                                                                    &nbsp;*<img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>internal/help_up.gif" class="help_btn" alt="<?php echo "Supplier Name";?>" onmouseover="return overlib('<?php echo "Supplier Code";;?>');" onmouseout="return nd();" />
                                                                                    <span class="message_mendatory"><?php echo $err['codeError'];  ?></span>
                                                                                </td>
                                                                                <td align="left" valign="top" class="message_mendatory"></td>
                                                                                <td align="left" valign="top" class="message_mendatory">
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td align="left" valign="middle" colspan="4"><br /></td>
                                                                            </tr>
                                                                             <tr>
                                                                                <td align="left" valign="middle"><?php echo "Fuel Charge";?></td>
                                                                                <td align="left" valign="middle" class="message_mendatory">
                                                                                    <input type="text" id="fuel_charge" name="fuel_charge" value="<?php if($_POST['fuel_charge'] != ''){ echo $_POST['fuel_charge'];}else{ echo valid_output($DataSupplier["fuel_charge"]); }?>" />                                                                                  
                                                                                    <span class="message_mendatory"><?php echo $err['fuelChargeError'];  ?></span>
                                                                                </td>
                                                                                <td align="left" valign="top" class="message_mendatory"></td>
                                                                                <td align="left" valign="top" class="message_mendatory">
                                                                                </td>
                                                                            </tr>
																			<tr>
                                                                                <td align="left" valign="middle" colspan="4"><br /></td>
                                                                            </tr>
      <tr>
       <?php
			$fieldArr = array("code_name","code_val","auto_id");
			$DataCode=$ObjCodeMaster->getCode($fieldArr);
		?>                                                              <td align="left" valign="middle"><?php echo "Table Format";?></td>
                                                                                 <td align="left" valign="middle" class="message_mendatory">
         <select id="code_formate" name="code_formate">                                                              <option value="" selected><?php echo ADMIN_SERVICE_SELECT; ?>		</option>
		<?php
			if($DataCode!='')
			{
				foreach ($DataCode as $code_details) 
				{
		?>
		<option value="<?php echo $code_details['code_val']; ?>"<?php if($DataSupplier["code_formate"]==$code_details['code_val']){ echo "selected"; }elseif($_POST["code_formate"]==$code_details['code_val']){ echo "selected"; } ?>><?php echo valid_output($code_details['code_name']); ?></option>
		<?php
				}
			}
		?>
		</select>
		<span class="message_mendatory"><?php echo $err['codeFormatError'];  ?></span>
                                                                                </td>
                                                                                <td align="left" valign="top" class="message_mendatory"></td>
                                                                                <td align="left" valign="top" class="message_mendatory">
                                                                                </td>
                                                                            </tr>                                                                      <tr>
                                                                                <td align="left" valign="middle" colspan="4"><br /></td>
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
                                                        <td align="left">
															<input type="hidden" size="34" id="ptoken" value="<?php echo $ptoken; ?>" name="ptoken">
                                                            <input type="submit" class="action_button" tabindex="36" name="submit" value="<?php echo $btnSubmit; ?>" onclick="return validate_client(this.form);" />
                                                            <input type="reset" tabindex="37" name="reset" class="action_button" value="<?php echo ADMIN_COMMON_BUTTON_RESET; ?>" />
                                                            <input type="button" class="action_button" name="cancel" tabindex="38" value="<?php echo ADMIN_COMMON_BUTTON_CANCEL;?>" onclick="javascript:document.location.href='<?php echo FILE_SUPPLIER_MANAGMENT.'?pagenum='.$pagenum; ?>';return true;" />
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