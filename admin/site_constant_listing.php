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

		require_once(DIR_WS_MODEL . "SiteConstantMaster.php");

		require_once(DIR_WS_ADMIN_LANGUAGES . DIR_CURRENT_LANGUAGE. '/site_constant.php');
	/**
	 * Inclusion and Exclusion Array of Javascript
	 */
		$arr_javascript_plugin_include[] = 'datatables/datatables.min.js';

		$arr_css_plugin_include[] = 'datatables/datatables.min.css';
		$arr_css_plugin_include[] = 'datatables/Buttons-1.7.0/css/buttons.dataTables.min.css';	


		$ObjConstantMaster	= new SiteConstantMaster();
		$ObjConstantMaster	= $ObjConstantMaster->Create();
		$SiteConstantData		=  new SiteConstantData();



	$fieldArr = array("*");
	$DataUser=$ObjConstantMaster->getSiteConstant($fieldArr,null,null,$from,$to, true,null,true); // Fetch Data


	$message= $arr_messages[$message];
	if(!empty($message))
	{
		$err['message'] = specialcharaChk(valid_input($message));
	}

	if(!empty($err['message']))
	{
		logOut();
	}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo ADMIN_HEADER_SITE?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
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
								<span><a href="<?php echo FILE_WELCOME_ADMIN; ?>"><?php echo ADMIN_HEADER_HOME;?></a> > <?php echo ADMIN_HEADER_SITE; ?></span>
								<div><label class="top_navigation"><a onclick="mtrash('<?php echo FILE_SITE_CONSTANT_ACTION;?>','<?php echo ADMIN_USERS_DELETE_CONFIRM; ?>');"><?php echo COMMAN_DELETE; ?></a>
								<label class="top_navigation"><a href="<?php echo FILE_SITE_CONSTANT_ACTION; ?>"><?php echo ADMIN_ADD_NEW ; ?></a>
								<a href="<?php echo FILE_SITE_CONSTANT_ACTION; ?>?Action=export_international_zone_csv"><?php echo ADMIN_EXPORT_NEW ; ?></a>
								</label>


								</div>

								</td>
							</tr>
							<tr>
								<td class="heading">
								<?php echo ADMIN_HEADER_SITE; ?>
								</td>
							</tr>
							<?php if($message!='') {?>
							<tr>
								<td class="message_success" align="center"><?php echo valid_output($message); ?></td>
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
												<th  align="center"> <input type="checkbox" name="m_trash_main" id="m_trash_all" > </th>
													<th align="center"><?php echo ADMIN_COMMON_SERIAL_NO; ?></th>
													 <th  align="center"><?php echo ADMIN_CONSTANT_NAME; ?></th>
													<th  align="center"><?php echo ADMIN_CONSTANT_ID; ?></th>

													<th  align="center"><?php echo ADMIN_CONSTANT_FRONT_GROUP_ID; ?></th>
													<th  align="center" ><?php echo ADMIN_COMMON_ACTION; ?></th>				</tr>
											</thead>
											<tbody>
												<?php
												 	if($DataUser!='') {
												 		$i = 1;
														$fieldArr = array();
														$fieldArr = array('count(*) as total');

														foreach ($DataUser as $users_details) {

															$rowClass = 'TableEvenRow';
															if($rowClass == 'TableEvenRow') {
																$rowClass = 'TableOddRow';
															} else {
																$rowClass = 'TableEvenRow';
															}

												?>
												<tr class="<?php echo $rowClass; ?>">
												<td align="center"> <input type="checkbox" name="m_trash" id="<?php echo $users_details['constant_id'];?>"></td>
													<td align="center"><?php echo $i = 1 +$from;?></td>
													<td><?php echo valid_output($users_details['constant_name']);?></td>
													<td><?php echo valid_output($users_details['constant_value']); ?></td>

												    <td><?php echo $users_details['front_group_id'];?></td>

													<td align="center" nowrap="nowrap">
														<a href="<?php echo FILE_SITE_CONSTANT_ACTION; ?>?Action=edit&amp;constant_id=<?php echo $users_details['constant_id'];?>"><?php echo COMMON_EDIT; ?></a> |
														<a href="<?php echo FILE_SITE_CONSTANT_ACTION; ?>?Action=trash&amp;constant_id=<?php echo $users_details['constant_id'].$URLParameters; ?>" onclick="return confirm('<?php echo ADMIN_USERS_DELETE_CONFIRM; ?>')"><?php echo COMMAN_DELETE; ?></a>
													</td>
												</tr>
												<?php	 $from++;
												}
											 }?>
											</tbody>
											<tfoot>
												<tr>
													<th align="center">&nbsp;</th>
													<th align="center"><?php echo ADMIN_COMMON_SERIAL_NO; ?>&nbsp;</th>
													<th align="center"><?php echo ADMIN_CONSTANT_NAME; ?>&nbsp;</th>
													<th align="center"><?php echo ADMIN_CONSTANT_ID; ?>&nbsp;</th>
													<th align="center"><?php echo ADMIN_CONSTANT_FRONT_GROUP_ID; ?>&nbsp;</th>
													<th align="center"><?php echo ADMIN_COMMON_ACTION; ?>&nbsp;</th>
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
