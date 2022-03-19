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
require_once(DIR_WS_MODEL . "StePostcodeData.php");
require_once(DIR_WS_MODEL . "StePostCodeMaster.php");
$ObjStePostCodeMaster	= new StePostCodeMaster();
$ObjStePostCodeMaster	= $ObjStePostCodeMaster->Create();
$StePostCodeData		= new StePostcodeData();

$arr_javascript_plugin_include[] = 'datatables/datatables.min.js';

$arr_css_plugin_include[] = 'datatables/datatables.min.css';
$arr_css_plugin_include[] = 'datatables/Buttons-1.6.5/css/buttons.dataTables.min.css';

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

<table width="100%" border="0" cellspacing="0" cellpadding="0" id="main" align="center" >
	<tr>
		<td>
			<?php require_once(DIR_WS_ADMIN_INCLUDES . ADMIN_FILE_HEADER);?>
		</td>
	</tr>		
<!-- Start Middle Content part -->
	<tr>
	
		<td class="middle_content">
			<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0" >
				<tr>
					<td class="middle_left_content">
						<?php 
						// Include the Left Panel
						require_once(DIR_WS_ADMIN_INCLUDES . ADMIN_FILE_LEFT_MENU);
						?>
					</td>
					
					<td valign="top">
						
							<form name="f1" method="POST" action="ste_table.php" id="f1">
							<table>
								<tr>
									<td colspan="4">
										<table border="0" cellspacing="0" cellpadding="0" class="middle_right_content">
										
										<tr>
											<td align="left" class="breadcrumb" colspan="8" width="300px">
												<span><a href="<?php echo FILE_WELCOME_ADMIN; ?>"><?php echo ADMIN_HEADER_HOME;?></a> > <?php echo "STE CITY RATE"; ?></span>
										
											</td>
											</tr>
											
											<tr>
												<td colspan="8" height="50%">&nbsp;</td>
											
											</tr>
											<tr>
											<td>City Tariff</td>
											<td colspan="7" >
											<?php
											$fieldArr = array("DISTINCT Zone");
											$optArr[]	=	array("Order_By" => "Zone");
											$DataStePostCodes=$ObjStePostCodeMaster->getStePostCode($fieldArr,null,$optArr);
											//print_R($DataStePostCodes);
											?>
											<select id="city_tariff" name="city_tariff" size="12" style='width:300px'>
											<option value="ADL" <?php if($scity_tariff=="ADL"){ echo "selected"; } ?>>ADL-Adelaide</option>
											<option value="BRS" <?php if($scity_tariff=="BRS"){ echo "selected"; } ?>>BRS-Brisbane</option>
											<option value="CBR" <?php if($scity_tariff=="CBR"){ echo "selected"; } ?>>CBR-Canberra</option>
											<option value="DRW" <?php if($scity_tariff=="DRW"){ echo "selected"; } ?>>DRW-Darwin</option>
											<option value="HOB" <?php if($scity_tariff=="HOB"){ echo "selected"; } ?>>HOB-Hobart</option>
											<option value="LCN" <?php if($scity_tariff=="LCN"){ echo "selected"; } ?>>LCN-Launceston</option>
											<option value="MEL" <?php if($scity_tariff=="MEL"){ echo "selected"; } ?>>MEL-Melbourne</option>
											<option value="PER" <?php if($scity_tariff=="PER"){ echo "selected"; } ?>>PER-Perth</option>
											<option value="SYD" <?php if($scity_tariff=="SYD"){ echo "selected"; } ?>>SYD-Sydney</option>
											
											<?php
											$includes_zone=array("ADL","BRS","CBR","MEL","PER","SYD","DRW","HOB","LCN");
											
											foreach ($DataStePostCodes as $datacity)
											{
											if($datacity['Zone']!=""){	
												if(!(in_array($datacity['Zone'],$includes_zone)))
												{
												?>
											<option value="<?php echo valid_output($datacity['Zone']); ?>" <?php if($scity_tariff==$datacity['Zone']){ echo "selected"; } ?>><?php echo valid_output($datacity['Zone']); ?></option>	
											
											<?php
												}
											}
											}
											?>							
											
											<option value="ZZZ" <?php if($scity_tariff=="OTH"){ echo "selected"; } ?>>ZZZ</option>
											<option value="AUS" <?php if($scity_tariff=="AUS"){ echo "selected"; } ?>>AUS</option>
											<option value="TNT" <?php if($scity_tariff=="TNT"){ echo "selected"; } ?>>TNT</option>
											</select>
											
												
											
											</td>
											</tr>
											<tr>
												<td colspan="8" height="50%">&nbsp;</td>
											
											</tr>
											<tr>
												<td colspan="8" height="50%">&nbsp;</td>
											
											</tr>
											<tr>
											<td></td>
											<td colspan="7">
											<input type="submit" value="Continue" name="submit">
											
											</td>
											</tr>
										
							</table>
							</form>
							
							
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




