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
require_once(DIR_WS_MODEL . "SteTableMaster.php");
require_once(DIR_WS_RELATED."system_mail.php");
require_once(DIR_WS_ADMIN_LANGUAGES . DIR_CURRENT_LANGUAGE. '/table_managment.php');
set_time_limit(0);
require_once(DIR_WS_MODEL . "CodeMaster.php");
require_once(DIR_WS_MODEL . "SteRatesFormateData.php");
require_once(DIR_WS_MODEL . "SteRatesFormateMaster.php");
require_once(DIR_WS_MODEL . "SteDetailsData.php");
require_once(DIR_WS_MODEL . "SteDetailsMaster.php");
require_once(DIR_WS_MODEL . "SteRateData.php");
require_once(DIR_WS_MODEL . "SteRateMaster.php");
require_once(DIR_WS_MODEL . "StePostcodeData.php");
require_once(DIR_WS_MODEL . "StePostCodeMaster.php");
require_once(DIR_WS_MODEL . "ServiceMaster.php");

/**
 * Start :: Object declaration
*/

$ObjSteTableMaster	= new SteTableMaster();
$ObjSteTableMaster	= $ObjSteTableMaster->Create();
$SteTableData		= new SteTableData();

$ObjSteRatesFormateMaster	= new SteRatesFormateMaster();
$ObjSteRatesFormateMaster	= $ObjSteRatesFormateMaster->Create();
$SteRatesFormatesData		= new SteRatesFormateData();


$ObjSteDetailsMaster	= new SteDetailsMaster();
$ObjSteDetailsMaster	= $ObjSteDetailsMaster->Create();
$SteDetailsData		= new SteDetailsData();


$ObjSteRateMaster	= new SteRateMaster();
$ObjSteRateMaster	= $ObjSteRateMaster->Create();
$SteRateData		= new SteRateData();

$ObjStePostCodeMaster	= new StePostCodeMaster();
$ObjStePostCodeMaster	= $ObjStePostCodeMaster->Create();
$StePostCodeData		= new StePostcodeData();


$ObjServiceMaster	= new ServiceMaster();
$ObjServiceMaster	= $ObjServiceMaster->Create();
$ServiceData		= new ServiceData();

$ObjCodeMaster	= new CodeMaster();
$ObjCodeMaster	= $ObjCodeMaster->Create();
$CodeData		= new CodeData();
global $con;
$pagenum = ($_GET['pagenum']!="")?($_GET['pagenum']):(1);
if(!empty($pagenum))
{
	$err['pagenum'] = isNumeric(valid_input($pagenum),ENTER_NUMERIC_VALUES_ONLY);
}
if(!empty($err['pagenum']))
{
	logOut();
}
/**
				 * Inclusion and Exclusion Array of Javascript
				 */
$arr_javascript_include[] = "postcode_action.php";

	$arr_css_admin_exclude[] = 'jquery.css';
	$arr_css_plugin_include[] ='bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css';
	$arr_css_plugin_include[] = 'glyphicons_new/css/glyphicons.css';
	$arr_css_plugin_include[] ='tabbed-panels/css/tabbed_panels.css';
	$arr_css_admin_include[] = 'custom-style.css';
	
	$arr_javascript_plugin_include[] = 'bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js';
	$arr_javascript_plugin_include[] = 'moment/js/moment-with-locales.min.js';
	$arr_javascript_plugin_include[] = 'bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js';


/*csrf validation*/
$csrf = new csrf();
$csrf->action = "table_action";
if(!isset($_POST['ptoken'])) {
	$ptoken = $csrf->csrfkey();
}

/*csrf validation*/


/**
				 * Variable Declaration
				 */
$btnSubmit = ADMIN_BUTTON_SAVE_STE_TABLE;
$HeadingLabel = ADMIN_LINK_SAVE_STE_TABLE;

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
if($auto_id!=''){

	$fieldArr=array("*");
	$seaByArr[]=array('Search_On'=>'auto_id', 'Search_Value'=>$auto_id, 'Type'=>'int', 'Equation'=>'=', 'CondType'=>'', 'Prefix'=>'and', 'Postfix'=>'');

	$DataSteTable=$ObjSteTableMaster->getSteTable($fieldArr,$seaByArr); // Fetch Data

	$DataSteTable = $DataSteTable[0];
	$servicetype = $DataSteTable['service_type'];
	$table_name = $DataSteTable['table_name'];
	$start_date = $DataSteTable['start_date'];
	//start_date = date('d M Y', strtotime($start_date)); 	
	$end_date = $DataSteTable['end_date'];
	//$end_date = date('d M Y', strtotime($end_date)); 	
	
	//Get sign up Address

	//Variable declaration

	$btnSubmit = ADMIN_BUTTON_UPDATE_STE_TABLE;
	$HeadingLabel = ADMIN_LINK_UPDATE_STE_TABLE;
}

if($_GET['Action']=='trash'){

//echo "inside action";

	$fieldArr = array();
	$seaByArr = array();
	$fieldArr=array("*");
	$seaByArr[]=array('Search_On'=>'auto_id', 'Search_Value'=>$auto_id, 'Type'=>'int', 'Equation'=>'=', 'CondType'=>'AND', 'Prefix'=>'', 'Postfix'=>'');
	
	$DataSteTable=$ObjSteTableMaster->getSteTable($fieldArr,$seaByArr); // Fetch Data
	//exit();
	$DataSteTable = $DataSteTable[0];
	$table_drop=mysqli_query($con,"DROP TABLE `".$DataSteTable['table_name']."`");
	
	$fieldArr = array("auto_id");
	$seaArr= array();
	$seaArr[] = array(  'Search_On'=>'table_name',
	'Search_Value'=>"in".$DataSteTable['table_name'],
	'Type'=>'string',
	'Equation'=>'=',
	'CondType'=>'AND',
	'Prefix'=>'(',
	'Postfix'=>''     );
	$seaArr[] = array(  'Search_On'=>'table_name',
	'Search_Value'=>"out".$DataSteTable['table_name'],
	'Type'=>'string',
	'Equation'=>'=',
	'CondType'=>'OR',
	'Prefix'=>'',
	'Postfix'=>')'     );
	//echo "table name:".$DataSteTable['table_name'];
	$DataSteDetails=$ObjSteDetailsMaster->getSteDetails($fieldArr,$seaArr);
	if($DataSteDetails!="")
	{
		foreach($DataSteDetails as $DataSteDetail)
		{
			$ObjSteDetailsMaster->deleteSteDetails($DataSteDetail["auto_id"]);
		}
	}

	$DataSteRateFormats=$ObjSteRatesFormateMaster->getSteRatesFormate($fieldArr,$seaArr);
	if($DataSteRateFormats!="")
	{
		foreach($DataSteRateFormats as $DataSteRateFormat)
		{
			$ObjSteRatesFormateMaster->deleteSteRatesFormate($DataSteRateFormat["auto_id"]);
		}
	}

	$ObjSteTableMaster->deleteSteTable($auto_id);
	$UParam = "?pagenum=".$pagenum."&message=".MSG_DELETE_STE_TABLE_SUCCESS;
	header('Location: '.FILE_TABLE.$UParam);
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
			$DataSteTable =array("");
			$seaByArr=array();
			$fieldArr=array("*");
			$seaByArr[]=array('Search_On'=>'auto_id', 'Search_Value'=>$val, 'Type'=>'int', 'Equation'=>'=', 'CondType'=>'', 'Prefix'=>'and', 'Postfix'=>'');
			$DataSteTable=$ObjSteTableMaster->getSteTable($fieldArr,$seaByArr); // Fetch Data
			$DataSteTable = $DataSteTable[0];
			$table_drop=mysqli_query($con,"DROP TABLE `".$DataSteTable['table_name']."`");

			$fieldArr = array("auto_id");
			$seaArr= array("");
			$seaArr[] = array(  'Search_On'=>'table_name',
			'Search_Value'=>"in".$DataSteTable['table_name'],
			'Type'=>'string',
			'Equation'=>'=',
			'CondType'=>'AND',
			'Prefix'=>'(',
			'Postfix'=>''     );
			$seaArr[] = array(  'Search_On'=>'table_name',
			'Search_Value'=>"out".$DataSteTable['table_name'],
			'Type'=>'string',
			'Equation'=>'=',
			'CondType'=>'OR',
			'Prefix'=>'',
			'Postfix'=>')'     );
			$DataSteDetails=$ObjSteDetailsMaster->getSteDetails($fieldArr,$seaArr);
			if($DataSteDetails!="")
			{
				foreach($DataSteDetails as $DataSteDetail)
				{
					$ObjSteDetailsMaster->deleteSteDetails($DataSteDetail["auto_id"]);
				}
			}
			$DataSteRateFormats=$ObjSteRatesFormateMaster->getSteRatesFormate($fieldArr,$seaArr);
			if($DataSteRateFormats!="")
			{
				foreach($DataSteRateFormats as $DataSteRateFormat)
				{
					$ObjSteRatesFormateMaster->deleteSteRatesFormate($DataSteRateFormat["auto_id"]);
				}
			}
			$ObjSteTableMaster->deleteSteTable($val);
		}
	}
	$UParam = "?pagenum=".$pagenum."&message=".MSG_DELETE_STE_TABLE_SUCCESS;
	header('Location: '.FILE_TABLE.$UParam);


}
if((isset($_POST['submit']) && $_POST['submit'] != "")){
	/*if(isEmpty(valid_input($_POST['ptoken']), true)){	
		logOut();
	}else{
		$csrf->checkcsrf($_POST['ptoken']);
	}*/
	
	$city_tariff=valid_input($_POST['city_tariff']);
	$service_type=valid_input($_POST['service_type']);
	$start_date=valid_input($_POST['start_date']);
	$start_date=date('Y-m-d H:i:s', strtotime($start_date)); 
	//$start_date=$start_date)); 
	$end_date=valid_input($_POST['end_date']);
	$end_date=date('Y-m-d H:i:s', strtotime($end_date)); 
	//$end_date=date('d M Y', strtotime($end_date)); 
	
	if(!empty($city_tariff))
	{
		$err['CityNameError'] = chkStr($city_tariff);
	}
	
	if(!empty($service_type))
	{
		$err['ServiceError'] = chkStr($service_type);
	}
	/*
	if(!empty($start_date))
	{
		$err['Startdate'] = chkStr($start_date);
	}
	if(!empty($end_date))
	{
		$err['Enddate'] = chkStr($end_date);
	}*/
	if(strtotime($start_date) > strtotime($end_date))
	{
		$err['Startdate'] = "Enter your start date greater than end date";
	}
	//This below code commented by shailesh jamanapara on Date Thu May 30 19:48:19 IST 2013 
	//$table_formate=valid_input($_POST['table_formate']);
	//This condition added by shailesh jamanapara on date Thu May 30 19:48:28 IST 2013
	if(isset($auto_id) && !empty($auto_id)){
		$table_formate = $_POST['hidden_table_formate'];
	}else{
		$table_formate=valid_input($_POST['table_formate']);
	}
	
	$table_name=valid_input($_POST['table_name']);
	if(!empty($table_name))
	{
		$err['tablenameError'] = checkStr($table_name);
	}
	
	if(!empty($_FILES['file']['tmp_name']))
	{
		$filename=$_FILES['file']['tmp_name'];
		$err['FileError'] = specialcharaChk($filename);
	}

	$upload_complete=0;
	
	$i=0;
	if($filename!="")
	{
		$handle = fopen("$filename", "r");
		while ((($data = fgetcsv($handle, 1000, ",")) !== FALSE) && $i==0)

		{
			$column_csv=count($data);
			$i++;
		}
		
		if($table_formate==3)/* for messenger post count */
		{
			//echo $column_csv;
			//exit();
			if($column_csv!=4)
			{
				$err['FileError'] = ADMIN_FILE_COLUMN_NOT_MATCH_CSV;
			}
		}
		
		if($table_formate==0)/* for startrack count */
		{
			if($column_csv!=6)
			{
				$err['FileError'] = ADMIN_FILE_COLUMN_NOT_MATCH_CSV;
			}
		}
		
		if($table_formate==4)/* for international count */
		{
			
			if($column_csv!=6)
			{
				$err['FileError'] = ADMIN_FILE_COLUMN_NOT_MATCH_CSV;
			}
		}
	}
		
	$err['TableNameError'] = isEmpty($_POST['table_name'], ADMIN_TABLE_NAME_IS_REQUIRED)?isEmpty($_POST['table_name'], ADMIN_TABLE_NAME_IS_REQUIRED):checkStr($_POST['table_name']);
	if($err['FileError']=="")
	{
		if($auto_id=='')
		{
			$err['FileError'] = isEmpty($_FILES['file']['name'], ADMIN_FILE_IS_REQUIRED);
		}
	}
	if($_FILES['file']['name']!="")
	{
		$file_extension=end(explode('.',$_FILES['file']['name']));
		if($file_extension!="csv")
		{
			$err['FileError'] =ADMIN_FILE_FORMATE_CSV;
		}
	}


	if($auto_id=='')
	{
		$err['CityNameError'] 		 = isEmpty($city_tariff, ADMIN_CITY_IS_REQUIRED);
		//$err['ServiceError'] 		 = isEmpty($service_type, ADMIN_SERVICE_IS_REQUIRED);
		$err['TableFormateError'] 	 = isEmpty($table_formate, ADMIN_TABLE_FORMATE_IS_REQUIRED);
		//echo mysqli_num_rows(mysqli_query($con,"SHOW TABLES LIKE '".$table_name."'"));
		//exit();
		
		if(mysqli_num_rows(mysqli_query($con,"SHOW TABLES LIKE '".$table_name."'"))==1)
		{
			$err['TableNameError']= ADMIN_TABLE_NAME_IS_EXIST;
		}
		

	}
	else
	{
		//echo mysql_query("SHOW TABLES LIKE '".$table_name."'");
		
			if(mysqli_num_rows(mysqli_query($con,"SHOW TABLES LIKE '".$table_name."'"))==1)
			{
				$table_exist=1;
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
/*echo "<pre>";
	print_r($_POST);
	echo "</pre>";
	echo "<pre>";
	print_r($err);
	echo "</pre>";

	echo "validation error:".$Svalidation;
	exit();*/
	if($Svalidation==false){
		
		if($table_formate==3)
		{
			
			if($table_exist!=1)
			{		
		
			$table_query = "CREATE TABLE $table_name (
											  `id` int(12) NOT NULL auto_increment,
											  `from_weight` int(12) NOT NULL,
											  `to_weight` int(12) NOT NULL,
											  `basic_charge` float NOT NULL,
											  `perkm` float NOT NULL,
											   PRIMARY KEY  (`id`)
											) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;";
			//echo $table_query;
			$table_cretae=mysqli_query($con,$table_query); 																			//old direct table formate
				/*$table_cretae=mysql_query("CREATE TABLE $table_name (
											  `id` int(12) NOT NULL auto_increment,
											  `from_weight` int(12) NOT NULL,
											  `to_weight` int(12) NOT NULL,
											  `basic_charge` float NOT NULL,
											  `perkm` float NOT NULL,
											   PRIMARY KEY  (`id`)
											) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;");*/
				//echo "table create:".$table_cretae;
				if (!$table_cretae) {
					die('Invalid query: ' . mysqli_error());
				}
				//exit();
				if($table_cretae==1)
				{
					$table_exist=1;
				}
			}
			else
			{
				$tabel_record_delete=mysqli_query($con,"delete from $table_name");
				if($tabel_record_delete==1)
				{
					$table_exist=1;
				}

			}
			if($table_exist==1 && $filename!="")
			{
				$handle = fopen("$filename", "r");

				while (($data = fgetcsv($handle, 1000, ",")) !== FALSE)
				{

					$data[0]=str_replace("'"," ",$data[0]);
					$data[1]=str_replace("'"," ",$data[1]);
					$data[2]=str_replace("'"," ",$data[2]);
					$data[3]=str_replace("'"," ",$data[3]);
					if(!empty($data[0]))
					{
						$err['from_weight'] = isNumeric(valid_input($data[0]),ENTER_NUMERIC_VALUES_ONLY);
					}
					if(!empty($data[1]))
					{
						$err['to_weight'] = isNumeric(valid_input($data[1]),ENTER_NUMERIC_VALUES_ONLY);
					}
					if(!empty($data[2]))
					{
						$err['basic_charge'] = isFloat(valid_input($data[2]),ENTER_NUMERIC_VALUES_ONLY);
					}
					if(!empty($data[3]))
					{
						$err['perkm'] = isFloat(valid_input($data[3]),ENTER_NUMERIC_VALUES_ONLY);
					}
					foreach($err as $key => $Value) {
						if($Value != '') {
							logOut();
						}
					}			
					
					$import="INSERT into $table_name(from_weight,to_weight,basic_charge,perkm) values($data[0],$data[1],$data[2],$data[3])";
					mysqli_query($con,$import) or die(mysqli_error());

				}

				fclose($handle);

				$upload_complete=1;
			}
		}
		else if($table_formate==0 || $table_formate==2)
		{

			
			if($table_exist!=1)
			{																					//starttrack table formate
				$table_cretae=mysqli_query($con,"CREATE TABLE IF NOT EXISTS $table_name (
												  `auto_id` int(255) NOT NULL auto_increment,
												  `From_zone` varchar(150) NOT NULL,
												  `To_zone` varchar(8) NOT NULL,
												  `Charging_zone` varchar(50) default NULL,
												  `Specific_minimum_charger` float(9,2) default NULL,
												  `Basic_charge` float(9,2) default NULL,
												  `Kilo_rate` float(9,2) default NULL,
												  PRIMARY KEY  (`auto_id`)
												) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19637 ;");
				if($table_cretae==1)
				{
					$table_exist=1;
				}
			}
			else
			{
				$tabel_record_delete=mysqli_query($con,"delete from $table_name");
				if($tabel_record_delete==1)
				{
					$table_exist=1;
				}

			}
			if($table_exist==1 && $filename!='')
			{
				$handle = fopen("$filename", "r");

				while (($data = fgetcsv($handle, 1000, ",")) !== FALSE)

				{

					$data[0]=str_replace("'"," ",$data[0]);
					$data[1]=str_replace("'"," ",$data[1]);
					$data[2]=str_replace("'"," ",$data[2]);
					$data[3]=str_replace("'"," ",$data[3]);
					$data[4]=str_replace("'"," ",$data[4]);
					
					
					if(!empty($data[0]))
					{
						$err['from'] = specialcharaChk(valid_input($data[0]));
					}
					if(!empty($data[1]))
					{
						$err['to'] = specialcharaChk(valid_input($data[1]));
					}
					
					
					if(!empty($data[2]))
					{
						$err['charging_zone'] = isNumeric(valid_input($data[2]),ENTER_NUMERIC_VALUES_ONLY);
					}
					
					if(!empty($data[3]))
					{
						$err['specific'] = isFloat(valid_input($data[3]),ENTER_NUMERIC_VALUES_ONLY);
					}
					if(!empty($data[4]))
					{
						$err['basic'] = isFloat(valid_input($data[4]),ENTER_NUMERIC_VALUES_ONLY);
					}
					if(!empty($data[5]))
					{
						$err['kilo_rate'] = isFloat(valid_input($data[5]),ENTER_NUMERIC_VALUES_ONLY);
					}
					
					foreach($err as $key => $Value) {
						if($Value != '') {
							logOut();
						}
					}
					
				    $import="INSERT into $table_name(From_zone,To_zone,Charging_zone,Specific_minimum_charger,Basic_charge,Kilo_rate) values('$data[0]','$data[1]','$data[2]','$data[3]','$data[4]','$data[5]')";
					mysqli_query($con,$import) or die(mysqli_error());

				}

				fclose($handle);

				$upload_complete=1;
			}

		}else if($table_formate==4)
		{
			if($table_exist!=1)
			{		
				
				//international table formate
				$table_cretae=mysqli_query($con,"CREATE TABLE IF NOT EXISTS $table_name (
												  `id` int(255) NOT NULL auto_increment,
												  `weight_from` float NOT NULL,
												  `weight_to` float NOT NULL,
												  `zone` varchar(255) NOT NULL,
												  `cost` float NOT NULL,
												  `doc_type` varchar(50) default NULL,
												  `multi` int(11) default 0,
												   PRIMARY KEY(`id`)
												) ENGINE=InnoDB  DEFAULT CHARSET=latin1  ;");
												
				if($table_cretae==1)
				{
					$table_exist=1;
				}
			}
			else
			{
				$tabel_record_delete=mysqli_query($con,"delete from $table_name");
				if($tabel_record_delete==1)
				{
					$table_exist=1;
				}

			}
			if($table_exist==1 && $filename!='')
			{
				$handle = fopen("$filename", "r");

				while (($data = fgetcsv($handle, 1000, ",")) !== FALSE)

				{

					$data[0]=str_replace("'"," ",$data[0]);
					$data[1]=str_replace("'"," ",$data[1]);
					$data[2]=str_replace("'"," ",$data[2]);
					$data[3]=str_replace("'"," ",$data[3]);
					$data[4]=str_replace("'"," ",$data[4]);
					$data[5]=str_replace("'"," ",$data[5]);
					if(!empty($data[0]))
					{
						$err['weight_from'] = isFloat(valid_input($data[0]),ENTER_NUMERIC_VALUES_ONLY);
					}
					if(!empty($data[1]))
					{
						$err['weight_to'] = isFloat(valid_input($data[1]),ENTER_NUMERIC_VALUES_ONLY);
					}
					if(!empty($data[2]))
					{
						$err['zone'] = isFloat(valid_input($data[2]),ENTER_NUMERIC_VALUES_ONLY);
					}
					if(!empty($data[3]))
					{
						$err['cost'] = isFloat(valid_input($data[3]),ENTER_NUMERIC_VALUES_ONLY);
					}
					if(!empty($data[4]))
					{
						$err['doc_type'] = isNumeric(valid_input($data[4]),ENTER_NUMERIC_VALUES_ONLY);
					}
					
					foreach($err as $key => $Value) {
						if($Value != '') {
							logOut();
						}
					}	
					$import="INSERT into $table_name(weight_from,weight_to,zone,cost,doc_type,multi) values('$data[0]','$data[1]','$data[2]','$data[3]','$data[4]','$data[5]')";
					
					mysqli_query($con,$import) or die(mysqli_error());

				}

				fclose($handle);

				$upload_complete=1;
			}

		}
		else if($table_formate==5)
		{
			//echo "table exist:".$table_exist."</br>";
			if($table_exist!=1)
			{		
				
				//DIRECT COURIER table formate
				$table_query = "CREATE TABLE $table_name (
											  `id` int(12) NOT NULL auto_increment,
											  `from_weight` int(12) NOT NULL,
											  `to_weight` int(12) NOT NULL,
											  `minimum_charge` float(9,2) DEFAULT NULL,
											  `basic_charge` float(9,2) DEFAULT NULL,
											  `perkm` float(9,4) NOT NULL,
											   PRIMARY KEY  (`id`)
											) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;";
				$table_cretae=mysqli_query($con,$table_query); 																			//old direct table formate

				if (!$table_cretae) {
					die('Invalid query: ' . mysqli_error());
				}								
				if($table_cretae==1)
				{
					$table_exist=1;
				}
			}
			else
			{
				$tabel_record_delete=mysqli_query($con,"delete from $table_name");
				if($tabel_record_delete==1)
				{
					$table_exist=1;
				}

			}
			if($table_exist==1 && $filename!='')
			{
				$handle = fopen("$filename", "r");
				$data = fgetcsv($handle, 1000, ",");
				
				while (($data = fgetcsv($handle, 1000, ",")) !== FALSE)

				{

					$data[0]=str_replace("'"," ",$data[0]);
					$data[1]=str_replace("'"," ",$data[1]);
					$data[2]=str_replace("'"," ",$data[2]);
					$data[3]=str_replace("'"," ",$data[3]);
					$data[4]=str_replace("'"," ",$data[4]);

					if(!empty($data[0]))
					{
						$err['from_weight'] = isNumeric(valid_input($data[0]),ENTER_NUMERIC_VALUES_ONLY);
					}
					if(!empty($data[1]))
					{
						$err['to_weight'] = isNumeric(valid_input($data[1]),ENTER_NUMERIC_VALUES_ONLY);
					}
					/*if(!empty($data[2]))
					{
						$err['minimum_charge'] = isFloat(valid_input($data[2]),ENTER_NUMERIC_VALUES_ONLY);
					}*/
					if(empty($data[2]))
					{
						$data[2] ='NULL';
					}
					if(empty($data[3]))
					{
						$data[3] ='NULL';
						//$err['basic_charge'] = isFloat(valid_input($data[3]),ENTER_NUMERIC_VALUES_ONLY);
					}
					if(!empty($data[4]))
					{
						$err['perkm'] = isFloat(valid_input($data[4]),ENTER_NUMERIC_VALUES_ONLY);
					}
					
					
					foreach($err as $key => $Value) {
						if($Value != '') {
							logOut();
						}
					}	
					$import="INSERT into $table_name(from_weight,to_weight,minimum_charge,basic_charge,perkm) values($data[0],$data[1],$data[2],$data[3],$data[4])";
					//echo $import."</br>";
					$result = mysqli_query($con,$import) or die(mysqli_error());
					/*echo "<pre>";
					print_r($result);
					echo "</pre>";*/
				}

				fclose($handle);

				$upload_complete=1;
			}

		}
	/*echo "table formate:".$table_formate;
	echo "<pre>";
	print_r($err);
	echo "</pre>";
	exit();*/
		if($upload_complete==1)
		{
			if($auto_id=='')
			{
				$SteTableData->auto_id = $auto_id;
				$SteTableData->table_formate = $table_formate;
				$SteTableData->table_name = $table_name;
				$SteTableData->service_type = $service_type;
				$SteTableData->start_date = $start_date;
				$SteTableData->end_date = $end_date;
				$auto_id=$ObjSteTableMaster->addSteTable($SteTableData);

				$UParam = "?pagenum=".$pagenum."&message=".MSG_ADD_TABLE_SUCCESS;

			}
			header('Location: '.FILE_TABLE.$UParam);
		}else if(isset($_POST['Action']) && $_POST['Action'] == 'edit')
		{
			$SteTableData->auto_id = $auto_id;
			$SteTableData->table_formate = $table_formate;
			$SteTableData->table_name = $table_name;
			$SteTableData->start_date = $start_date;
			$SteTableData->end_date = $end_date;
			$auto_id=$ObjSteTableMaster->editSteTable($SteTableData);
			$UParam = "?pagenum=".$pagenum."&message=".MSG_EDIT_TABLE_SUCCESS;
			header('Location: '.FILE_TABLE.$UParam);
		}

	}
}

$fieldArr = array("*");
$DataCode=$ObjCodeMaster->getCode($fieldArr);

/**
				 * Gets details for the user
				 */



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
											<span><a href="<?php echo FILE_WELCOME_ADMIN; ?>"><?php echo ADMIN_HEADER_HOME; ?></a> > <a href="<?php echo FILE_TABLE.'?pagenum='.$pagenum; ?>"> <?php echo ADMIN_HEADER_STE_TABLE; ?> </a> > <? echo $HeadingLabel; ?></span>
											<div><label class="top_navigation"><a href="<?php echo FILE_TABLE.'?pagenum='.$pagenum; ?>"><?php echo ADMIN_COMMON_BACK; ?></a></label></div>
										</td>
									</tr>
									<tr>
										<td align="center">
											<?php  /*** Start :: Listing Table ***/ ?>
											<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
												<form name="frmtable" id="frmtable" method="POST" action="" enctype="multipart/form-data">
													<input type="hidden" name="Id1" value="<?php //echo $maximum_id[0] || $_GET['Id'];?>" />
													<tr>
														<td>
															<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td>
																		<table width="98%" cellpadding="0" border="0" cellspacing="0">
																			<tr>
																				<td class="message_mendatory" align="right" colspan="4">
																					<?echo ADMIN_COMMAN_REQUIRED_INFO;?>
																				</td>
																			</tr>
																			<tr>
																				<td colspan="4">&nbsp;</td>
																			</tr>
																			<tr>
																				<td align="left" valign="middle"><?php echo ADMIN_SERVICE_CITY;?><span class="message_mendatory">*</span></td>
																				<td align="left" valign="middle">
																					<?php
																					$scity_tariff=strtoupper(substr($DataSteTable["table_name"],0,3));
																					if($_POST["city_tariff"]!=""){  $scity_tariff=$_POST["city_tariff"]; }
																					$fieldArr = array("DISTINCT Zone");
																					$DataStePostCodes=$ObjStePostCodeMaster->getStePostCode($fieldArr);
																					//print_R($DataStePostCodes);
																								?>
																					<?php
																					$includes_zone=array("ADE","BRI","CAN","MEL","PER","SYD","DRW","HOB","LCN");
																					$option="";
																					foreach ($DataStePostCodes as $datacity)
																					{
																						if($datacity['Zone']!="")
																						{
																							if(!(in_array($datacity['Zone'],$includes_zone)))
																							{
																								if($scity_tariff==$datacity['Zone']){

																									$option=$option.'<option value="'.valid_output($datacity['Zone']).'" selected >'.valid_output($datacity['Zone']).'</option>';

																								} else {

																									$option=$option.'<option value='.valid_output($datacity['Zone']).' >'.valid_output($datacity['Zone']).'</option>';
																								}

																							}

																						}

																					} 
																								?>
																					<select id="city_tariff" name="city_tariff">
																						<option value=""><?php echo ADMIN_SERVICE_SELECT; ?></option>
																						<option value="ADE" <?php if($scity_tariff=="ADE"){ echo "selected"; } ?>>ADE-Adelaide</option>
																						<option value="BNE" <?php if($scity_tariff=="BNE"){ echo "selected"; } ?>>BNE-Brisbane</option>
																						<option value="CBR" <?php if($scity_tariff=="CBR"){ echo "selected"; } ?>>CBR-Canberra</option>
																						<option value="MEL" <?php if($scity_tariff=="MEL"){ echo "selected"; } ?>>MEL-Melbourne</option>
																						<option value="PER" <?php if($scity_tariff=="PER"){ echo "selected"; } ?>>PER-Perth</option>
																						<option value="SYD" <?php if($scity_tariff=="SYD"){ echo "selected"; } ?>>SYD-Sydney</option>
																						<option value="DRW" <?php if($scity_tariff=="DRW"){ echo "selected"; } ?>>DRW-Darwin</option>
																						<option value="HOB" <?php if($scity_tariff=="HOB"){ echo "selected"; } ?>>HOB-Hobart</option>
																						<option value="LCN" <?php if($scity_tariff=="LCN"){ echo "selected"; } ?>>LCN-Launceston</option>
																						<?php echo $option; ?>	
																						<option value="ZZZ" <?php if($scity_tariff=="ZZZ"){ echo "selected"; } ?>>zzz</option>																	
																						<option value="AUS" <?php if($scity_tariff=="AUS"){ echo "selected"; } ?>>aus</option>																	
				<option value="TNT" <?php if($scity_tariff=="TNT"){ echo "selected"; } ?>>tnt</option>																	
																					</select>
																					&nbsp; <span class="message_mendatory" id="err_city_tariff"><?php if($err['CityNameError']!=""){ echo $err['CityNameError']; } ?></span>
																				</td>
																				<td align="left" valign="top" class="message_mendatory"></td>
																				<td align="left" valign="top" class="message_mendatory">
																				</td>
																			</tr>
																			
																			<tr>
																				<td colspan="4">&nbsp;</td>
																			</tr>
																			<tr>
																				<td align="left" valign="middle"><?php echo ADMIN_SERVICE_TABLE_FORMATE;?><span class="message_mendatory">*</span></td>
																				<td align="left" valign="middle">
																				<?php
																					$fieldArr = array("code_name","code_val","auto_id");
																					$DataCode=$ObjCodeMaster->getCode($fieldArr);
																				?>
																				<div id="table_formate_div">																				
				<?php
					
				?>
				<select id="table_formate" name="table_formate">																						
				<option value="" selected><?php echo ADMIN_SERVICE_SELECT; ?></option>
				<?php
				if($DataCode!='') {	
					foreach ($DataCode as $code_details) 
					{
				?>
					<option value="<?php echo $code_details['code_val']; ?>" <?php if($DataSteTable["table_formate"]==$code_details['code_val']){ echo "selected"; }elseif($_POST["table_formate"]==$code_details['code_val']){ echo "selected"; } ?>><?php echo valid_output($code_details['code_name']); ?></option>
					<?php
						}
					}
					?>
					</select>
					<?php
					if(isset($auto_id) && $auto_id !== ''){
						echo "<input type='hidden' id='hidden_table_formate' name='hidden_table_formate' value='". valid_output($DataSteTable["table_formate"])."' >";
						echo "<input type='hidden' id='auto_id' name='auto_id' value='". $auto_id."' >";
					}
					?>
					</div>
						&nbsp; <span class="message_mendatory" id="err_table_formate"><?php if($err['TableFormateError']!=""){ echo $err['TableFormateError']; } ?></span>
					</td>
					<td align="left" valign="top"></td>
					<td align="left" valign="top">
					</td>
				</tr>
				<tr>
					<td colspan="4">&nbsp;</td>
				</tr>
				<?php
					if($DataSteTable["table_name"]!="")
					{
						$readonly ='readonly';
					}
				?>
				<tr>
				<td align="left" valign="middle"><?php echo ADMIN_SERVICE_TABLE_NAME;?><span class="message_mendatory">*</span></td>
				<td align="left" valign="middle" class="message_mendatory">
					<input type="text" id="table_name" name="table_name" <?php echo $readonly; ?> value="<?php if($_POST['table_name'] != ''){ echo valid_output($_POST['table_name']);}else{ echo valid_output($DataSteTable["table_name"]); }?>" />
					&nbsp;<img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>internal/help_up.gif" class="help_btn" alt="<?php echo ADMIN_SERVICE_HELP_TABLE_NAME;?>" onmouseover="return overlib('<?php echo ADMIN_SERVICE_HELP_TABLE_NAME;?>');" onmouseout="return nd();" />
					&nbsp; <span class="message_mendatory" id="err_table_name"><?php if($err['TableNameError']!=""){ echo $err['TableNameError']; } ?></span>
				</td>
				<td align="left" valign="top" class="message_mendatory" ></td>
				<td align="left" valign="top" class="message_mendatory">
				</td>
			</tr>
			<tr>
				<td align="left" valign="middle" colspan="4"><br /></td>
			</tr>
			<tr>
				<td align="left" valign="middle"><?php echo ADMIN_SERVICE_FILE;?></td>
				<td align="left" valign="middle" class="message_mendatory">
					<input type="file" name="file" id="file" />	
					&nbsp; <span class="message_mendatory"><?php if($auto_id!='' && $DataSteTable["table_name"]!=''){ echo valid_output($DataSteTable["table_name"]).".csv is Already uploaded"; } ?><?php if($err['FileError']!=""){ echo $err['FileError']; } ?></span>	
				</td>
				<td align="left" valign="top" class="message_mendatory" id="countryError"></td>
				<td align="left" valign="top" class="message_mendatory">
				</td>
			</tr>
			<tr>
				<td align="left" valign="middle" colspan="4"><br /></td>
			</tr>
			<tr>
				<td align="left" valign="middle"><?php echo ADMIN_START_DATE;?></td>
				<td align="left" valign="middle" class="message_mendatory">
               
                                            <div class="form-group">
                							<div class='input-group date'  id='datetimepicker6' data-link-field="dtp_input1"  >

                							<input type='hidden' class="form-control" id="dtp_input1" />
                                            <label class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></label>
                                           
																					<input type="text" readonly name="start_date" id="start_date" value="<?php if(isset($start_date) && $start_date!=''){ echo valid_output($start_date);} ?>" />
                                                                                    </div>
                                                                                    </div>
																					<span class="message_mendatory" id="startDateError"></span>
																				</td>
																				<td align="left" valign="top" class="message_mendatory" ><?php if(isset($err['Startdate'])){ echo $err['Startdate'];} ?></td>
																				<td align="left" valign="top" class="message_mendatory">
																				</td>
																			</tr>
																			<tr>
																				<td align="left" valign="middle" colspan="4"><br /></td>
																			</tr>
																			<tr>
																				<td align="left" valign="middle"><?php echo ADMIN_END_DATE;?></td>
																				<td align="left" valign="middle" class="message_mendatory">
                                                                                
                                            <div class="form-group">
                							<div class='input-group date'  id='datetimepicker7' data-link-field="dtp_input2"  >
                							
                							<input type='hidden' class="form-control" id="dtp_input2" />
                                            <label class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></label>
																					<input type="text" readonly name="end_date" id="end_date" value="<?php if(isset($end_date) && $end_date!=''){ echo valid_output($end_date);} ?>" />
																					</div>
                                                                                    </div>
																				<span class="message_mendatory" id="endDateError"></span>
																				</td>
																				<td align="left" valign="top" class="message_mendatory" ><?php if(isset($err['Enddate'])){ echo $err['Enddate'];} ?></td>
																				<td align="left" valign="top" class="message_mendatory">
																				</td>
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
															<input type="submit" class="action_button" tabindex="36" name="submit" value="<?php echo $btnSubmit; ?>" />
															<input type="reset" tabindex="37" name="reset" class="action_button" value="<?php echo ADMIN_COMMON_BUTTON_RESET; ?>" />
															<input type="button" class="action_button" name="cancel" tabindex="38" value="<?php echo ADMIN_COMMON_BUTTON_CANCEL;?>" onclick="javascript:document.location.href='<?php echo FILE_TABLE.'?pagenum='.$pagenum; ?>';return true;" />
														</td>
													</tr>
													<tr>
														<td><input type="hidden" id="dateArr" value="<?php echo $date_arr; ?>" />&nbsp;</td>
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
<?php //require_once(DIR_WS_JSCRIPT."/jquery.php"); ?>
<script type="text/javascript">
$(document).ready(function(){
	$("#city_tariff").change(function(){
		change_table_name();
	});
	$("#service_type").change(function(){
		change_table_name();
	});
	$("#table_formate").change(function(){
		change_table_name();
	});
	$("#frmtable").submit(function(){
		
		if($("#city_tariff").val()=="")
		{
			$("#err_city_tariff").html("<?php echo ADMIN_CITY_IS_REQUIRED; ?>");
			return false;
		}
		/*else if( $("#service_type").val()=="" )
		{
			alert("<?php echo ADMIN_SERVICE_IS_REQUIRED; ?>");
			return false;
		}*/
		else if( $("#table_formate").val()=="")
		{
			$("#err_table_formate").html("<?php echo ADMIN_TABLE_FORMATE_IS_REQUIRED; ?>");
			return false;
		}
		else if( $("#table_name").val()=="")
		{
			$("#err_table_name").html("<?php echo ADMIN_TABLE_NAME_IS_REQUIRED; ?>");
			return false;
		}
		else if($("#start_date").val()=="")
		{
			$("#startDateError").html("<?php echo ADMIN_START_DATE_IS_REQUIRED; ?>");
			return false;
		}
		else if($("#end_date").val()=="")
		{
			$("#endDateError").html("<?php echo ADMIN_END_DATE_IS_REQUIRED; ?>");
			return false;
		}
		else
		{
			//change_table_name();
			return true;
		}
	});




});
function ajaxRequest(){
	var activexmodes=["Msxml2.XMLHTTP", "Microsoft.XMLHTTP"] //activeX versions to check for in IE
	if (window.ActiveXObject){ //Test for support for ActiveXObject in IE first (as XMLHttpRequest in IE7 is broken)
		for (var i=0; i<activexmodes.length; i++){
			try{
				return new ActiveXObject(activexmodes[i])
			}
			catch(e){

				//suppress error
			}
		}
	}
	else if (window.XMLHttpRequest) // if Mozilla, Safari etc
	return new XMLHttpRequest()
	else
	return false;
}
function change_table_name()
{
	if($("#city_tariff").val()!="" && $("#service_type").val()!="" && $("#table_formate").val()!="" )
	{
		var table_formate=$("#table_formate").val();
		if(table_formate==1)
		{
			var table_name=$("#city_tariff").val()+$("#service_type").val();
		}
		else if(table_formate==2)
		{
			var table_name=$("#city_tariff").val()+$("#service_type").val();
		}
		else
		{
			$("#table_formate_value").val("");
			$("#table_name").val("");
			return false;
		}
		
		$("#table_formate_value").val(table_formate);
		//$("#table_name").val(table_name.toLowerCase());
	}
	else
	{
		$("#table_name").val("");
		return false;
	}
}
<?php if($auto_id!="") { ?>
$("#city_tariff").attr("disabled", true);
$("#service_type").attr("disabled", true);
$("#table_formate").attr("disabled", true);
//$("#table_name").attr('readonly', true);
<?php } ?>
</script>
<script type="text/javascript">
var dat = $("#dateArr").val();
var dateTest = dat.split(",");
var dateArr = [];
for(var i=0;i<dateTest.length;i++)
{
	dateArr[i] = dateTest[i];
}
var defaultDateset;
var minDate;
if(trim(defaultDateset) == "")
{	
	defaultDateset = moment().format();
}
if(trim(minDate) == "")
{
	minDate = moment().format();
}
$('#datetimepicker7').datetimepicker({
	date: defaultDateset,
	minDate: minDate,
	format: 'DD MMMM YYYY',
	daysOfWeekDisabled: [0,6],
	sideBySide: true,
	widgetPositioning: {
		horizontal: 'left'
	},
	showClose: true,
	ignoreReadonly:true,
	locale: 'en',
	disabledDates:dateArr
});

$("#datetimepicker7").on("dp.change",function (e) { 
	$('#start_date').val($('#dtp_input2').val());
});

//var first = moment().format('DD MMMM YYYY');

 
$('#datetimepicker6').datetimepicker({
	date: defaultDateset,
	minDate: minDate,
	format: 'DD MMMM YYYY',
	daysOfWeekDisabled: [0,6],
	sideBySide: true,
	widgetPositioning: {
		horizontal: 'left'
	},
	showClose: true,
	ignoreReadonly:true,
	locale: 'en',
	disabledDates:dateArr
});

$("#datetimepicker6").on("dp.change",function (e) { 
	$('#start_date').val($('#dtp_input1').val());
});
</script>