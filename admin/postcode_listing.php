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
		
		require_once(DIR_WS_MODEL . "PostCodeMaster.php");
		require_once(DIR_WS_ADMIN_LANGUAGES . DIR_CURRENT_LANGUAGE. '/postcode.php');
		
	/**
	 * Inclusion and Exclusion Array of Javascript
	 */
		$arr_javascript_plugin_include[] = 'datatables/datatables.min.js';
		$arr_css_plugin_include[] = 'datatables/datatables.min.css';
		$arr_css_plugin_include[] = 'datatables/Buttons-1.6.5/css/buttons.dataTables.min.css';
	
	
	/**
	 * Start :: Object declaration
	 */
	
		$ObjPostCodeMaster	= new PostCodeMaster();
		$ObjPostCodeMaster	= $ObjPostCodeMaster->Create();
		$PostCodeData		= new PostCodeData();
	
/**
 * Code For Fetching User Details
 */
    $message= $_REQUEST['message'];
    $another_array[] = array('Search_On'    => 'firstname',
	                      'Search_Value' => $first_name,
	                      'Type'         => 'string',
	                      'Equation'     => 'NOT LIKE',
	                      'CondType'     => 'AND',
	                      'Prefix'       => '',
	                      'Postfix'      => ''); 
	
    
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo ADMIN_USER?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<?php 
addPluginCSSFile($arr_css_plugin_include,$arr_css_plugin_exclude);
addCSSFileAdmin($arr_css_admin_include, $arr_css_admin_exclude);
addJavaScriptFile($arr_javascript_include, $arr_javascript_exclude);
addPluginJavaScriptFile($arr_javascript_plugin_include,$arr_javascript_plugin_exclude);
?>
<script>
$(document).ready(function() {
	
    $('#maintable').dataTable( {
        processing: true,
		serverSide: true,
		ajax: {
			url: "ajax_postcode_listing.php",
			type: 'GET'
		}
    } );
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
								<span><a href="<?php echo FILE_WELCOME_ADMIN; ?>"><?php echo ADMIN_HEADER_HOME;?></a> > <?php echo ADMIN_HEADER_POSTCODES; ?></span>
								<div><label class="top_navigation"><a onclick="mtrash('<?php echo FILE_PIOSTCODE_ACTION."?pagenum=".$pagenum;?>','<?php echo ADMIN_USERS_DELETE_CONFIRM; ?>');"><?php echo COMMAN_DELETE; ?></a>
								<label  class="top_navigation" >
								<a href="<?php echo FILE_PIOSTCODE_ACTION."?pagenum=".$pagenum; ?>" ><?php echo ADMIN_POSTCODE_ADD_NEW ; ?></a>
								<a href=<?php echo "temp/export.php?request=postcode"; ?>><?php echo ADMIN_POSTCODE_EXPORT_NEW ; ?></a>
								</label>	</div>

								</td>
							</tr>
							<tr>
								<td class="heading">
								<?php echo ADMIN_HEADER_POSTCODES; ?>
								</td>
							</tr>
							<?php if(!empty($message)) {?>
							<tr>
								<td class="message_success" align="center"><?php echo $arr_message[$message] ; ?></td>
							</tr>							
							<?php } ?>
							<!--  End Searching	-->
							<tr>
								<td>
								
							<?php  /*** Start :: Listing Table ***/ ?>
							
									<div id="container">

										<div id="jquery_table"  class="jquery_pagination">
										<table width="100%" cellspacing="0" cellpadding="0" class="display" id="maintable">
											<thead>
												<tr>
												
													<th width="5%" align="center"><?php echo ADMIN_COMMON_SERIAL_NO; ?></th>
													<th width="15%" align="center"><?php echo ADMIN_POSTCODE_FULL_NAME; ?></th>
													<th width="20%" align="center"><?php echo ADMIN_POSTCODE_ZONE; ?></th>
													<th width="8%" align="center"><?php echo ADMIN_POSTCODE_CHARGING_ZONE; ?></th>
													<th width="5%" align="center"><?php echo ADMIN_POSTCODE_TIME_ZONE; ?></th>
													
																
																
												</tr>
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
												
													<td align="center"><?php echo $i = 1 + $from;?></td>
													<td><?php echo $users_details['FullName'] ; ?></td>
													<td><?php echo $users_details['Zone'];?></td>
													<td><?php echo $users_details['charging_zone'];?></td>
													<td><?php echo $users_details['time_zone'];?></td>
													
													
													
												</tr>
												<?php	$from++;
												}
											 }?>
											</tbody>
											<tfoot>
												<tr>
													<th align="center"><?php echo ADMIN_COMMON_SERIAL_NO; ?></th>
													<th align="center"><?php echo ADMIN_POSTCODE_FULL_NAME;?></th>
													<th align="center"><?php echo ADMIN_POSTCODE_ZONE;?></th>
													<th align="center"><?php echo ADMIN_POSTCODE_CHARGING_ZONE;?></th>
													<th align="center"><?php echo ADMIN_POSTCODE_TIME_ZONE;?></th>
													
												</tr>
											</tfoot>
											
										</table>
										
										</div>
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
