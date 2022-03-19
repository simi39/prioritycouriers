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
		require_once(DIR_WS_MODEL . "SteRatesFormateData.php");
		require_once(DIR_WS_MODEL . "SteRatesFormateMaster.php");
		require_once(DIR_WS_ADMIN_LANGUAGES . DIR_CURRENT_LANGUAGE. '/ste_cal.php');
		$ObjSteRatesFormateMaster	= new SteRatesFormateMaster();
		$ObjSteRatesFormateMaster	= $ObjSteRatesFormateMaster->Create();
		$SteRatesFormatesData		= new SteRatesFormateData();
		
		
		require_once(DIR_WS_MODEL . "SteDetailsData.php");
		require_once(DIR_WS_MODEL . "SteDetailsMaster.php");
		$ObjSteDetailsMaster	= new SteDetailsMaster();
		$ObjSteDetailsMaster	= $ObjSteDetailsMaster->Create();
		$SteDetailsData		= new SteDetailsData();
		
		require_once(DIR_WS_MODEL . "ServiceMaster.php");
		
		$ObjServiceMaster	= new ServiceMaster();
		$ObjServiceMaster	= $ObjServiceMaster->Create();
        $ServiceData= new ServiceData();
		
		$arr_javascript_plugin_include[] = 'datatables/datatables.min.js';

		$arr_css_plugin_include[] = 'datatables/datatables.min.css';
		$arr_css_plugin_include[] = 'datatables/Buttons-1.6.5/css/buttons.dataTables.min.css';
		$auto_id = $_GET["auto_id"];
		if(!empty($auto_id))
		{
			$err['auto_id'] = isNumeric(valid_input($auto_id),ENTER_NUMERIC_VALUES_ONLY);
		}
		if(!empty($err['auto_id']))
		{
			logOut();
		}
		if(!empty($_GET['city_tariff']))
		{
			$err['city_tariff'] = chkCapital(valid_input($_GET['city_tariff']));
		}
		if(!empty($err['city_tariff']))
		{
			logOut();
		}
		if(!empty($_GET['action']))
		{
			$err['action'] = chkStr(valid_input($_GET['action']));
		}
		if(!empty($err['action']))
		{
			logOut();
		}
		if(!empty($_POST['city_tariff']))
		{
			$err['city_tariff'] = chkCapital(valid_input($_POST['city_tariff']));
		}
		if(!empty($err['city_tariff']))
		{
			logOut();
		}
		
    if($_GET["action"]=="delete" && isset($auto_id))
    {    	
    	$fieldArr = array("*");	
		$seaArr = array();
		$seaArr[] = array('Search_On'=>'auto_id',     
				         'Search_Value'=>$auto_id,     
				          'Type'=>'string',     
				          'Equation'=>'LIKE',    
				          'CondType'=>'AND',     
				          'Prefix'=>'',     
				         'Postfix'=>''     );  		       
		$DataSteRatesFormate=$ObjSteRatesFormateMaster->getSteRatesFormate($fieldArr,$seaArr);   	
    	//echo $DataSteRatesFormate[0]['table_name']; exit;	
    	$fieldArr = array("*");
		$seaArr = array();
		$seaArr[] = array(   'Search_On'=>'table_name',
							'Search_Value'=>$DataSteRatesFormate[0]['table_name'],
							'Type'=>'string',
							'Equation'=>'=',
							'CondType'=>'AND',
							'Prefix'=>'',
							'Postfix'=>''     );		
		$DataSteDetails=$ObjSteDetailsMaster->getSteDetails($fieldArr,$seaArr);
		if($DataSteDetails!="")
		{
			foreach($DataSteDetails as $DataSteDetail)
			{
				$ObjSteDetailsMaster->deleteSteDetails($DataSteDetail['auto_id']);
			}
		}
    	
    	
    	$ObjSteRatesFormateMaster->deleteSteRatesFormate($auto_id);
    }
        

	$base_tariff=strtolower($_GET['city_tariff']);	
	$fieldArr = array("*");	
	$seaArr = array();
	$seaArr[] = array('Search_On'=>'table_name',     
			         'Search_Value'=>"in$base_tariff%",     
			          'Type'=>'string',     
			          'Equation'=>'LIKE',    
			          'CondType'=>'AND',     
			          'Prefix'=>'(',     
			         'Postfix'=>''     );  
	$seaArr[] = array('Search_On'=>'table_name',     
			         'Search_Value'=>"bo$base_tariff%",     
			          'Type'=>'string',     
			          'Equation'=>'LIKE',    
			          'CondType'=>'OR',     
			          'Prefix'=>'',     
			         'Postfix'=>''     );  
	$seaArr[] = array('Search_On'=>'table_name',     
			         'Search_Value'=>"out$base_tariff%",     
			          'Type'=>'string',     
			          'Equation'=>'LIKE',    
			          'CondType'=>'OR',     
			          'Prefix'=>'',     
			         'Postfix'=>')'     );		         
	$DataSteRatesFormate=$ObjSteRatesFormateMaster->getSteRatesFormate($fieldArr,$seaArr);

	if(is_array($DataSteRatesFormate[0]) && count($DataSteRatesFormate[0]) == 0)
	{
	header('location:ste_cal.php');	
	}	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo ADMIN_USER?></title>
<script type="text/javascript" src="http://code.jquery.com/jquery-1.7.min.js"></script>
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
							<table>
								<tr>
									<td colspan="4">
										<table border="0" cellspacing="0" cellpadding="0" class="middle_right_content" >										
										<tr>
											<td align="left" class="breadcrumb" colspan="8" width="300px">
												<span><a href="<?php echo FILE_WELCOME_ADMIN; ?>"><?php echo ADMIN_HEADER_HOME;?></a> > <?php echo "STE CITY SERVICE"; ?></span>
										
											</td>
											</tr>
											
											<tr>
												<td colspan="8" height="50%">&nbsp;<br><br><a href="ste_cal.php">New</a>&nbsp;&nbsp;&nbsp;<a href="ste_city_rate.php">Back</a><br><br></td>
											
											</tr>
											<tr><td colspan="8">
											
												<table border="" style="border-solid:1px;">
													<tr>
													
													<td ><strong><?php echo "City"; ?></strong></td>
													
													<td  ><strong><?php echo "Type"; ?></strong></td>
													
													<td ><strong><?php echo "Service"; ?></strong></td>													
													<td ></td>
													<td ></td>
													</tr>
											<?php
											
											foreach($DataSteRatesFormate as $SteRatesFormate)
											{
												if(substr(valid_output($SteRatesFormate['table_name']),0,2)=="in")
												{
													$city_tariff=substr(valid_output($SteRatesFormate['table_name']),2,3);
													$direction=substr(valid_output($SteRatesFormate['table_name']),0,2);
													$service_type=substr(valid_output($SteRatesFormate['table_name']),5,2);
													$base_tariff=strtolower(valid_output($SteRatesFormate['ste_table_name']));
												}
												elseif(substr(valid_output($SteRatesFormate['table_name']),0,2)=="bo")
												{
													$city_tariff=substr(valid_output($SteRatesFormate['table_name']),2,3);
													$direction=substr(valid_output($SteRatesFormate['table_name']),0,2);
													$service_type=substr(valid_output($SteRatesFormate['table_name']),5,2);
													$base_tariff=strtolower(valid_output($SteRatesFormate['ste_table_name']));
												}
												else 
												{
													$city_tariff=substr(valid_output($SteRatesFormate['table_name']),3,3);
													$direction=substr(valid_output($SteRatesFormate['table_name']),0,3);
													$service_type=substr(valid_output($SteRatesFormate['table_name']),6,2);
													$base_tariff=strtolower(valid_output($SteRatesFormate['ste_table_name']));													
												}
													$_POST['price1']=substr(valid_output($SteRatesFormate['format']),0,1);
													$_POST['price2']=substr(valid_output($SteRatesFormate['format']),1,1);
													$_POST['price3']=substr(valid_output($SteRatesFormate['format']),2,1);
													$_POST['ctype1']=substr(valid_output($SteRatesFormate['method']),0,1);
													$_POST['ctype2']=substr(valid_output($SteRatesFormate['method']),1,1);
													$_POST['ctype3']=substr(valid_output($SteRatesFormate['method']),2,1);	
												
													echo "<form name='service' id='service' action='ste_cal.php' method='POST'>";
													?>
													
													<tr>
													
													<td><?php echo strtoupper(valid_output($city_tariff)); ?></td>
													
													<td ><?php if($direction=="in")
													{
														echo "INBOUND";
													}
													elseif($direction=="bo")
													{
														echo "BOTH";
													}
													else {
														echo "OUTBOUND";
													}
														?></td>

													
													<td ><?php 
													$DataService=array();
													$seaByArr=array();
													$fieldArr=array();
													$service_type=strtoupper($service_type);
													$fieldArr=array("service_name");
													$seaByArr[]=array('Search_On'=>'service_code', 'Search_Value'=>$service_type, 'Type'=>'string', 'Equation'=>'=', 'CondType'=>'', 'Prefix'=>'and', 'Postfix'=>'');
												
													$DataService=$ObjServiceMaster->getService($fieldArr,$seaByArr); // Fetch Data
												
													$DataService = $DataService[0];
													
													echo valid_output($DataService['service_name']);
													 ?></td>												
													
													<td height="20px">
													<input type="hidden" name="city_tariff" value="<?php echo strtoupper(valid_output($city_tariff)); ?>">
													<input type="hidden" name="direction" value="<?php echo strtoupper(valid_output($direction)); ?>">	
													<input type="hidden" name="service_type" value="<?php echo strtoupper(valid_output($service_type)); ?>">
													<input type="hidden" name="base_tariff" value="<?php echo valid_output($base_tariff); ?>">
													
													<input type="hidden" name="price1" value="<?php echo $_POST['price1']; ?>">
													<input type="hidden" name="price2" value="<?php echo $_POST['price2']; ?>">
													<input type="hidden" name="price3" value="<?php echo $_POST['price3']; ?>">
													<input type="hidden" name="ctype1" value="<?php echo $_POST['ctype1']; ?>">
													<input type="hidden" name="ctype2" value="<?php echo $_POST['ctype2']; ?>">
													<input type="hidden" name="ctype3" value="<?php echo $_POST['ctype3']; ?>">
													
													<input type="submit" value="View">
													</td>
													<td><a href="?auto_id=<?php echo $SteRatesFormate['auto_id']."&action=delete"; ?>">Delete</a></td>
													</tr>	
													<?php
													echo "</form>";
											}
											
										?>
												</table>
											</td></tr>											
											<tr>
												<td colspan="8" height="50%">&nbsp;</td>
											
											</tr>
											<tr>
												<td colspan="8" height="50%">&nbsp;</td>
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
<?php 
// Column Configuration
//$columnSetting = 'null, null, null,  { "bSortable": false }';
//require_once(DIR_WS_JSCRIPT."/jquery.php");
?>




