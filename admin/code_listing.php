<?php
/*
 * include common file
 */
require_once("../lib/common.php");
require_once(DIR_WS_ADMIN_LANGUAGES . DIR_CURRENT_LANGUAGE. '/code.php');

require_once(DIR_WS_MODEL . "CodeMaster.php");

$ObjCodeMaster	= new CodeMaster();
$ObjCodeMaster	= $ObjCodeMaster->Create();
$CodeData		= new CodeData();

$arr_css_plugin_include[] = 'datatables/css/jquery.dataTables.min.css';	
$arr_javascript_plugin_include[] = 'datatables/js/jquery.dataTables.min.js';
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
$DataCode=$ObjCodeMaster->getCode($fieldArr, null,null,$from,$to);

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
                                            <span><a href="<?php echo FILE_WELCOME_ADMIN; ?>"><?php echo ADMIN_HEADER_HOME;?></a>  <?php echo "/".CODE_FORMAT_MANAGEMENT; ?></span>
                                            <div><label class="top_navigation" /><a onclick="mtrash('<?php echo FILE_CODE_MANAGMENT_ACTION;?>','<?php echo ADMIN_USERS_DELETE_CONFIRM; ?>');"><?php echo COMMAN_DELETE; ?></a>
                                                <label class="top_navigation" /><a href="<?php echo FILE_CODE_MANAGMENT_ACTION; ?>"><?php echo "ADD" ; ?></a>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="heading">
                                            <?php echo CODE_FORMAT_MANAGEMENT; ?>
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
                                                                <th width="15%" align="center"><?php echo CODE_NAME; ?></th>
                                                                <th width="15%" align="center"><?php echo CODE_VALUE; ?></th>
                                                                <th width="5%" align="center"><?php echo "Action"; ?></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            if($DataCode!='') {
                                                            	$i = 1;
                                                            	$fieldArr = array();
                                                            	$fieldArr = array('count(*) as total');

                                                            	foreach ($DataCode as $code_details) {

                                                            		$rowClass = 'TableEvenRow';
                                                            		if($rowClass == 'TableEvenRow') {
                                                            			$rowClass = 'TableOddRow';
                                                            		} else {
                                                            			$rowClass = 'TableEvenRow';
                                                            		}

                                                                ?>
                                                            <tr class="<?php echo $rowClass; ?>">
                                                                <td align="center"> <input type="checkbox" name="m_trash" id="<?php echo $code_details['auto_id'];?>" /></td>
                                                                <td align="center"><?php echo $i = 1 +$from;?></td>
                                                                <td><?php echo valid_output($code_details['code_name']) ; ?></td>
                                                                 <td><?php echo valid_output($code_details['code_val']) ; ?></td>
                                                                <td align="center" nowrap="nowrap">
                                                                    <a href="<?php echo FILE_CODE_MANAGMENT_ACTION; ?>?Action=edit&amp;auto_id=<?php echo $code_details['auto_id'];?>"><?php echo COMMON_EDIT; ?></a> | <a href="<?php echo FILE_CODE_MANAGMENT_ACTION; ?>?Action=trash&amp;auto_id=<?php echo $code_details['auto_id'].$URLParameters; ?>" onclick="return confirm('<?php echo ADMIN_CODE_DELETE_CONFIRM; ?>')"><?php echo COMMAN_DELETE; ?></a>
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
                                                                <th align="center"><?php echo CODE_NAME; ?>&nbsp;</th>
                                                                <th align="center"><?php echo CODE_VALUE; ?>&nbsp;</th>
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
