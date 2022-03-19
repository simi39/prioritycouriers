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
		//require_once('pagination_top.php');
		require_once(DIR_WS_MODEL . "PostCodeMaster.php");
		require_once(DIR_WS_MODEL . "KmGridMaster.php");
		require_once(DIR_WS_ADMIN_LANGUAGES . DIR_CURRENT_LANGUAGE. '/kmgrid.php');
		
		/**
	 	* Inclusion and Exclusion Array of Javascript
	 	*/
		$arr_javascript_plugin_include[] = 'datatables/datatables.min.js';

		$arr_css_plugin_include[] = 'datatables/datatables.min.css';
		$arr_css_plugin_include[] = 'datatables/Buttons-1.6.5/css/buttons.dataTables.min.css';
		
	
		$ObjPostCodeMaster	= new PostCodeMaster();
		$ObjPostCodeMaster	= $ObjPostCodeMaster->Create();
		$PostCodeData		= new PostCodeData();
		$ObjKmGridMaster	= new KmGridMaster();
		$ObjKmGridMaster	= $ObjKmGridMaster->Create();
		$KmGridData		= new KmGridData();
		
		if($_REQUEST['pagenum']!=''){
			$pagenum=$_REQUEST['pagenum'];
		}else{
			$pagenum= 1;
		}
	
		$message= $arr_message[$_GET['message']];            
		if(!empty($message))
		{
			$err['message'] = specialcharaChk(valid_input($message));
		}
		if(!empty($err['message']))
		{
			logOut();
		}
		

		$fieldArr = array("*");	
		
		//$DataUser=$ObjKmGridMaster->getKmGrid($fieldArr, null,null,$from,$to, true, true);
	  	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo ADMIN_HEADER_KM_GRID; ?></title>
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
			url: "ajax_kmgrid_listing.php",
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
								<span><a href="<?php echo FILE_WELCOME_ADMIN; ?>"><?php echo ADMIN_HEADER_HOME;?></a> > <?php echo ADMIN_HEADER_KM_GRID; ?></span>
								<div><label class="top_navigation"><a onclick="mtrash('<?php echo FILE_KM_GRID_ACTION;?>','<?php echo ADMIN_USERS_DELETE_CONFIRM; ?>');"><?php echo COMMAN_DELETE; ?></a>
								<label class="top_navigation"><a href="<?php echo FILE_KM_GRID_ACTION; ?>"><?php echo ADMIN_ADD_NEW ; ?></a>
								<a href="<?php echo FILE_KM_GRID_ACTION; ?>?Action=export_kmgrid_csv"><?php echo ADMIN_EXPORT_NEW ; ?></a></label>
							
								</div>

								</td>
							</tr>
							<tr>
								<td class="heading">
								<?php echo ADMIN_HEADER_KM_GRID; ?>
								</td>
							</tr>
							<?php if(!empty($message)) {?>
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
												
													<th width="5%" align="center"><?php echo ADMIN_COMMON_SERIAL_NO; ?></th>
													<th width="15%" align="center"><?php echo PICKUP_FROM; ?></th>
													<th width="20%" align="center"><?php echo DILIVER_TO; ?></th>		
													<th width="10%" align="center" ><?php echo DISTANCEINKM; ?></th>		
													
													
																
												</tr>
											</thead>
											
											<tfoot>
												<tr>
													
													<th align="center"><?php echo ADMIN_COMMON_SERIAL_NO; ?>&nbsp;</th>
													<th align="center"><?php echo PICKUP_FROM; ?>&nbsp;</th>
													<th align="center"><?php echo DILIVER_TO; ?>&nbsp;</th>
													<th align="center"><?php echo DISTANCEINKM; ?>&nbsp;</th>
													
													
													
						
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
