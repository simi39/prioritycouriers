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
require_once(DIR_WS_ADMIN_LANGUAGES . DIR_CURRENT_LANGUAGE. '/code.php');


require_once(DIR_WS_MODEL . "CodeData.php");
require_once(DIR_WS_MODEL . "CodeMaster.php");
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

$btnSubmit = ADMIN_BUTTON_SAVE_CODE;
$HeadingLabel = ADMIN_LINK_SAVE_CODE;
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

	$ObjCodeMaster->deleteCode($auto_id);
	$UParam = "?pagenum=".$pagenum."&message=".MSG_DELETE_CODE_SUCCESS;
	header('Location: '.FILE_CODE_MANAGMENT.$UParam);
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
			$ObjCodeMaster->deleteCode($val);
		}
	}
	$UParam = "?pagenum=".$pagenum."&message=".MSG_DELETE_CODE_SUCCESS;
	header('Location: '.FILE_CODE_MANAGMENT.$UParam);


}
/*csrf validation*/
$csrf = new csrf();
$csrf->action = "code_action";
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
	
	$err['codeError'] = isEmpty($_POST['code'], ADMIN_CODE_NAME_IS_REQUIRED)?isEmpty($_POST['code'], ADMIN_CODE_NAME_IS_REQUIRED):checkStr($_POST['code']);
	$err['codeValError'] = isEmpty($_POST['code_val'], ADMIN_CODE_VALUE_IS_REQUIRED)?isEmpty($_POST['code_val'], ADMIN_CODE_VALUE_IS_REQUIRED):isNumeric($_POST['code_val'],ADMIN_CODE_VALUE_IS_NUMERIC);
	$code_name=ucfirst($_POST['code']);
	$code_name=$_POST['code'];
	
	if($auto_id==''){

		$fieldArr=array("*");
		$seaByArr=array();
		$seaByArr[]=array('Search_On'=>'code_name', 'Search_Value'=>$code_name, 'Type'=>'string', 'Equation'=>'=', 'CondType'=>'', 'Prefix'=>'and', 'Postfix'=>'');

		$DataCode=$ObjCodeMaster->getCode($fieldArr,$seaByArr); // Fetch Data

		$DataCode = $DataCode[0];
		if(!empty($DataCode))
		{
			$err['codeError'] 		 = ADMIN_CODE_EXIST;
		}

		if($code_name!="interstate")
		{
			$err['codeError'] 		 = isEmpty($code_name, ADMIN_CODE_NAME_IS_REQUIRED)?isEmpty($code_name, ADMIN_CODE_NAME_IS_REQUIRED):checkStr($code_name);

			$fieldArr=array("*");
			$seaByArr=array();
			$seaByArr[]=array('Search_On'=>'code_name', 'Search_Value'=>$code_name, 'Type'=>'string', 'Equation'=>'=', 'CondType'=>'', 'Prefix'=>'and', 'Postfix'=>'');

			$DataCode=$ObjCodeMaster->getCode($fieldArr,$seaByArr); // Fetch Data

			$DataCode = $DataCode[0];
			if(!empty($DataCode))
			{
				$err['codeError'] 		 = ADMIN_CODE_EXIST;
			}
		}


	}
	else {
		if($code_name)
		{
			$fieldArr=array("*");
			$seaByArr=array();
			$seaByArr[]=array('Search_On'=>'code_name', 'Search_Value'=>$code_name, 'Type'=>'string', 'Equation'=>'=', 'CondType'=>'', 'Prefix'=>'and', 'Postfix'=>'');
			$seaByArr[]=array('Search_On'=>'auto_id', 'Search_Value'=>$auto_id, 'Type'=>'int', 'Equation'=>'!=', 'CondType'=>'', 'Prefix'=>'and', 'Postfix'=>'');

			$DataCode=$ObjCodeMaster->getCode($fieldArr,$seaByArr); // Fetch Data
			if($DataCode)
			{
				$DataCode = $DataCode[0];
			}
			if(!empty($DataCode))
			{
				$err['codeError'] 		 = ADMIN_CODE_EXIST;
			}


			if($code_name!="interstate")
			{
				$err['codeError'] 		 = isEmpty($code_name, ADMIN_CODE_NAME_IS_REQUIRED)?isEmpty($code_name, ADMIN_CODE_NAME_IS_REQUIRED):checkStr($code_name);

				$fieldArr=array("*");
				$seaByArr=array();
				$seaByArr[]=array('Search_On'=>'code_name', 'Search_Value'=>$code_name, 'Type'=>'string', 'Equation'=>'=', 'CondType'=>'', 'Prefix'=>'and', 'Postfix'=>'');
				$seaByArr[]=array('Search_On'=>'auto_id', 'Search_Value'=>$auto_id, 'Type'=>'int', 'Equation'=>'!=', 'CondType'=>'', 'Prefix'=>'and', 'Postfix'=>'');

				$DataCode=$ObjCodeMaster->getCode($fieldArr,$seaByArr); // Fetch Data
				if($DataCode){
					$DataCode = $DataCode[0];
				}
				if(!empty($DataCode))
				{
					$err['codeError'] 		 = ADMIN_CODE_EXIST;
				}
			}
		}
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
		
		$CodeData->code_name = ucwords(trim($code_name));
		$CodeData->code_val = $_POST['code_val'];
		

		if($auto_id!='')
		{
			$CodeData->auto_id = $auto_id;
			$ObjCodeMaster->editCode($CodeData);
			$UParam = "?pagenum=".$pagenum."&message=".MSG_EDIT_CODE_SUCCESS;
		}
		else
		{
			$auto_id=$ObjCodeMaster->addCode($CodeData);
			$UParam = "?pagenum=".$pagenum."&message=".MSG_ADD_CODE_SUCCESS;
		}
		header('Location: '.FILE_CODE_MANAGMENT.$UParam);


	}
}

/**
            	 * Gets details for the user
            	 */

if($auto_id!=''){

	$fieldArr=array("*");
	$seaByArr=array();
	$seaByArr[]=array('Search_On'=>'auto_id', 'Search_Value'=>$auto_id, 'Type'=>'int', 'Equation'=>'=', 'CondType'=>'', 'Prefix'=>'and', 'Postfix'=>'');

	$DataCode=$ObjCodeMaster->getCode($fieldArr,$seaByArr); // Fetch Data

	$DataCode = $DataCode[0];

	//Get sign up Address

	//Variable declaration

	$btnSubmit = ADMIN_BUTTON_UPDATE_CODE;
	$HeadingLabel = ADMIN_LINK_UPDATE_CODE;
}

            ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title><?php if ($_GET['auto_id']=='') { echo ADMIN_ADD_CODE; } else { echo ADMIN_EDIT_CODE;}?></title>
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
                                            <span><a href="<?php echo FILE_WELCOME_ADMIN; ?>"><?php echo ADMIN_HEADER_HOME; ?></a> > <a href="<?php echo FILE_CODE_MANAGMENT.'?pagenum='.$pagenum; ?>"> <?php echo ADMIN_HEADER_CODE; ?> </a> > <? echo $HeadingLabel; ?></span>
                                            <div><label class="top_navigation"><a href="<?php echo FILE_CODE_MANAGMENT.'?pagenum='.$pagenum; ?>"><?php echo ADMIN_COMMON_BACK; ?></a></label></div>
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
                                                                           
                                                                            <tr>
                                                                                <td colspan="4">&nbsp;</td>
                                                                            </tr>
                                                                            
                                                                            <tr>
                                                                                <td align="left" valign="middle" colspan="4"><br /></td>
                                                                            </tr>
                                                                             <tr>
                                                                                <td align="left" valign="middle"><?php echo CODE_NAME;?></td>
                                                                                <td align="left" valign="middle" class="message_mendatory">
                                                                                    <input type="text" id="code" name="code" value="<?php if($_POST['code'] != ''){ echo $_POST['code'];}else{ echo valid_output($DataCode["code_name"]); }?>" />
                                                                                    
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
                                                                                <td align="left" valign="middle"><?php echo CODE_VALUE;?></td>
                                                                                <td align="left" valign="middle" class="message_mendatory">
                                                                                    <input type="text" id="code_val" name="code_val" value="<?php if($_POST['code_val'] != ''){ echo $_POST['code_val'];}else{ echo valid_output($DataCode["code_val"]); }?>" />                                                                                  
                                                                                    <span class="message_mendatory"><?php echo $err['codeValError'];  ?></span>
                                                                                </td>
                                                                                <td align="left" valign="top" class="message_mendatory"></td>
                                                                                <td align="left" valign="top" class="message_mendatory">
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
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
                                                            <input type="button" class="action_button" name="cancel" tabindex="38" value="<?php echo ADMIN_COMMON_BUTTON_CANCEL;?>" onclick="javascript:document.location.href='<?php echo FILE_CODE_MANAGMENT.'?pagenum='.$pagenum; ?>';return true;" />
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