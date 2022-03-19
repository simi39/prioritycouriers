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
require_once(DIR_WS_ADMIN_LANGUAGES . DIR_CURRENT_LANGUAGE. '/supplier.php');

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
$message = $arr_message[$_GET['message']];            
if(!empty($message))
{
	$err['message'] = specialcharaChk(valid_input($message));
}
if(!empty($err['message']))
{
	logOut();
}	


$fieldArr = array("*");
$DataSupplier=$ObjSupplierMaster->getSupplier($fieldArr, null,null,$from,$to);



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
                                <table border="0" width="100%" cellpadding="0" cellspacing="0" align="center" class="middle_right_content">
                                    <tr>
                                        <td align="left" class="breadcrumb">
                                            <span><a href="<?php echo FILE_WELCOME_ADMIN; ?>"><?php echo ADMIN_HEADER_HOME;?></a>  <?php echo "/ Supplier Managment "; ?></span>
                                            <div><label class="top_navigation" /><a onclick="mtrash('<?php echo FILE_SUPPLIER_MANAGMENT_ACTION;?>','<?php echo ADMIN_USERS_DELETE_CONFIRM; ?>');"><?php echo COMMAN_DELETE; ?></a>
                                                <label class="top_navigation" /><a href="<?php echo FILE_SUPPLIER_MANAGMENT_ACTION; ?>"><?php echo "ADD" ; ?></a>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="heading">
                                            <?php echo "Supplier Managment"; ?>
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
                                                
                                                    <table width="100%" cellspacing="0" cellpadding="0" class="display" id="maintable">
                                                        <thead>
                                                            <tr>
                                                                <th width="5%" align="center"> <input type="checkbox" name="m_trash_main" id="m_trash_all" /> </th>
                                                                <th width="5%" align="center"><?php echo ADMIN_COMMON_SERIAL_NO; ?></th>
                                                                <th width="15%" align="center"><?php echo "Supplier Name"; ?></th>
                                                                <th width="15%" align="center"><?php echo "Supplier Code"; ?></th>
																 <th width="15%" align="center"><?php echo "Table Formate"; ?></th>
                                                                <th width="5%" align="center"><?php echo "Action"; ?></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            if($DataSupplier!='') {
                                                            	$i = 1;
                                                            	$fieldArr = array();
                                                            	$fieldArr = array('count(*) as total');

                                                            	foreach ($DataSupplier as $supplier_details) {

                                                            		$rowClass = 'TableEvenRow';
                                                            		if($rowClass == 'TableEvenRow') {
                                                            			$rowClass = 'TableOddRow';
                                                            		} else {
                                                            			$rowClass = 'TableEvenRow';
                                                            		}
		
		//echo "code formate".$supplier_details['code_formate']."</br>";
		//exit();
		
		$fieldArr=array("code_name");
		$seaByArr=array();
		$code_val = $supplier_details['code_formate'];
		$seaByArr[]=array('Search_On'=>'code_val', 'Search_Value'=>$code_val, 'Type'=>'string', 'Equation'=>'=', 'CondType'=>'', 'Prefix'=>'and', 'Postfix'=>'');

		$DataCode=$ObjCodeMaster->getCode($fieldArr,$seaByArr); // 
        $DataCode = $DataCode[0];                                                      
															 ?>
                                                            <tr class="<?php echo $rowClass; ?>">
                                                                <td align="center"> <input type="checkbox" name="m_trash" id="<?php echo $supplier_details['auto_id'];?>" /></td>
                                                                <td align="center"><?php echo $i = 1 +$from;?></td>
                                                                <td><?php echo valid_output($supplier_details['supplier_name']) ; ?></td>
                                                                 <td><?php echo valid_output($supplier_details['code']) ; ?></td>
																  <td><?php echo $DataCode['code_name']; ?></td>
                                                                <td align="center" nowrap="nowrap">
                                                                    <a href="<?php echo FILE_SUPPLIER_MANAGMENT_ACTION; ?>?Action=edit&amp;auto_id=<?php echo $supplier_details['auto_id'];?>"><?php echo COMMON_EDIT; ?></a> | <a href="<?php echo FILE_SUPPLIER_MANAGMENT_ACTION; ?>?Action=trash&amp;auto_id=<?php echo $supplier_details['auto_id'].$URLParameters; ?>" onclick="return confirm('<?php echo ADMIN_USERS_DELETE_CONFIRM; ?>')"><?php echo COMMAN_DELETE; ?></a>
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
                                                                <th><input type="hidden" name="search_srno" value="" class="search_init" /></th>
                                                                <th align="center"><?php echo ADMIN_COMMON_SERIAL_NO; ?>&nbsp;</th>
                                                                <th align="center"><?php echo "Supplier Name"; ?>&nbsp;</th>
                                                                <th align="center"><?php echo "Supplier Code"; ?>&nbsp;</th>
																<th align="center"><?php echo "Code Format"; ?>&nbsp;</th>
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
