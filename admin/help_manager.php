<?php
	require_once("../lib/common.php");
	require_once(DIR_WS_MODEL . "HelpManagerMaster.php");
	define('COMMON_SECURITY_ANSWER_ALPHANUMERIC',"enter alphanumeric value.");
	/**
	 * Inclusion and Exclusion Array of Javascript
	 */
	 //$arr_javascript_include[] = "jquery.dataTables.js";
	$arr_javascript_exclude[] = "common.js";
	$arr_javascript_plugin_include[] = 'datatables/datatables.min.js';

	$arr_css_plugin_include[] = 'datatables/datatables.min.css';
	$arr_css_plugin_include[] = 'datatables/Buttons-1.6.5/css/buttons.dataTables.min.css';
	 
	 /*csrf validation*/
	$csrf = new csrf();
	$csrf->action = "help_manager";
	if(!isset($_POST['ptoken'])) {
		$ptoken = $csrf->csrfkey();
	}
	/*csrf validation*/
	$message = $_GET['msg'];            
	if(!empty($message))
	{
		
		$err['message'] = specialcharaChk(valid_input($message));
	}
	
	if(!empty($err['message']))
	{
		logOut();
	}	
	
	/**
	 * Object Declaration
	 * 
	 */
		$objHelpManagerMaster   = new HelpManagerMaster();
		$objHelpManagerMaster   = $objHelpManagerMaster->create();
		$objHelpManagerData 	 = new HelpManagerData();
        $pagenum = ($_GET['pagenum']!="")?($_GET['pagenum']):(1);
		if(!empty($pagenum))
		{
			$err['pagenum'] = isNumeric(valid_input($pagenum),ENTER_NUMERIC_VALUES_ONLY);
		}
		
		if(!empty($err['pagenum']))
		{
			logOut();
		}
		/*
		echo "<pre>";
		print_R($_POST);
		echo "</pre>"; */
		//exit();
	if(isset($_POST["submit"])) {
		/*
		if(isEmpty(valid_input($_POST['ptoken']), true)){	
			logOut();
		}else{
			$csrf->checkcsrf($_POST['ptoken']);
		}
		*/
		foreach ($_POST["id"] as $key=>$upddata) {
			$err[$key] = checkHelp($upddata);
			$ptoken = $csrf->csrfkey();												
		}
		
		foreach ($err as $key => $val){
			if($val != "") {
				$Svalidation=true;																
				$ptoken = $csrf->csrfkey();												
			}
		}
		
		if($Svalidation == false)
		{
			
			foreach ($_POST["id"] as $key=>$upddata) {
				
				$seaArr = array();
				$seaArr[]	=	array('Search_On'    => 'help_id',
									  'Search_Value' => $key,
									  'Type'         => 'int',
									  'Equation'     => '=',
									  'CondType'     => 'AND',
									  'Prefix'       => '',
									  'Postfix'      => '');			
				$objHelpManagerData = $objHelpManagerMaster->getHelpManager("*",$seaArr);
				$objHelpManagerData=$objHelpManagerData[0];
				$objHelpManagerData->help_id=$key;
				$objHelpManagerData->help_description=valid_output($upddata);
				$objHelpManagerMaster->editHelpManager($objHelpManagerData);
		
			}
			
			header("Location: ".FILE_ADMIN_HELP_MANAGER."?msg=success&pagenum=".$pagenum);
			exit;
		}
	}
	$optArr = array();
	$optArr[]	=	array('Order_By'   => 'page_id',
	                      'Order_Type' => 'asc');
	
	
	$objHelpManagerData = $objHelpManagerMaster->getHelpManager("*",null,$optArr);
		
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo ADMIN_HELP_MANAGEMENT;?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<?php
addPluginCSSFile($arr_css_plugin_include,$arr_css_plugin_exclude);
addCSSFileAdmin($arr_css_admin_include, $arr_css_admin_exclude);
addJavaScriptFile($arr_javascript_include, $arr_javascript_exclude);
addPluginJavaScriptFile($arr_javascript_plugin_include,$arr_javascript_plugin_exclude);
?>
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
										<span><a href="<?php echo FILE_WELCOME_ADMIN; ?>"><?php echo ADMIN_HEADER_HOME; ?></a> > <?php echo ADMIN_HEADER_HELP_MANAGEMENT; ?></span>
										<!--<div><label class="top_navigation"><a href="<?php //echo FILE_ADMIN_ADD_EDIT_CMS;?>"><?php //echo ADMIN_CMS_ADD_NEW_CMS; ?></a></label></div>-->
								</td>
							</tr>
							<tr>
								<td class="heading">
									<?php echo ADMIN_HEADER_HELP_MANAGEMENT; ?>
								</td>
							</tr>
							<?php if(!empty($message)) {?>
							<tr>
								<td class="message_success" align="center"><?php echo valid_output($message) ; ?></td>
							</tr>							
							<?php } ?>
							<tr>
								<td>
								<form method="POST" >
								<table width="100%" cellpadding="0" cellspacing="2">
								<?php $i=0;?>
									<?php
									
									foreach ($objHelpManagerData as $datarow) { 
									if($i!=$datarow->page_id){
										if($datarow->page_id==1){
											echo "<tr><td>&nbsp;</td></tr><tr><td colspan='2' class='filter'><b>Home Page OR Get a Quate Page</b></td></tr>";
										} else if($datarow->page_id==2) {
											echo "<tr><td>&nbsp;</td></tr><tr><td colspan='2' class='filter'><b>Shipment Details Page</b></td></tr>";
										} else if($datarow->page_id==3) {
											echo "<tr><td>&nbsp;</td></tr><tr><td colspan='2' class='filter'><b>Payment Page</b></td></tr>";
										}else if($datarow->page_id==5) {
											echo "<tr><td>&nbsp;</td></tr><tr><td colspan='2' class='filter'><b>Admin Side Page</b></td></tr>";
										}
										$i=$datarow->page_id;	
									}
									?>
									
									<tr>
										<td valign="top" width="15%" style="font-weight:bold;"><?php echo valid_output($datarow->help_heading);?>:</td>
										<td width="85%"><textarea cols="50" rows="5" name="id[<?php echo $datarow->help_id;?>]"><?php echo valid_output($datarow->help_description);?></textarea></td>
									</tr>
									<tr>
										<td valign="top" width="15%" style="font-weight:bold;"></td>
										<td width="85%" class="message_mendatory"><?php echo $err[$datarow->help_id];?></td>
									</tr>
									<?php }?>	
									<tr><td><input type="hidden" size="34" id="ptoken" value="<?php echo $ptoken; ?>" name="ptoken">&nbsp;</td></tr>	
									<tr>
										<td>&nbsp;</td><td><input class="action_button" type="submit" value="Update" name="submit" ></td>
									</tr>
								</table>
								</form>
							</td></tr>					
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
<?php 
	// Column Configuration
	$columnSetting = 'null, null, null, null, { "sType": "html", "bSortable":true }, { "bSortable": false }';
	require_once(DIR_WS_JSCRIPT."internal/jquery.php"); 
?>							
