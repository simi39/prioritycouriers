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
require_once(DIR_WS_ADMIN_LANGUAGES . DIR_CURRENT_LANGUAGE. '/ste_cal.php');
require_once(DIR_WS_MODEL . "SteRatesFormateData.php");
require_once(DIR_WS_MODEL . "SteRatesFormateMaster.php");
$ObjSteRatesFormateMaster	= new SteRatesFormateMaster();
$ObjSteRatesFormateMaster	= $ObjSteRatesFormateMaster->Create();
$SteRatesFormatesData		= new SteRatesFormateData();

require_once(DIR_WS_MODEL . "SteDetailsData.php");
require_once(DIR_WS_MODEL . "SteDetailsMaster.php");
$ObjSteDetailsMaster	= new SteDetailsMaster();
$ObjSteDetailsMaster	= $ObjSteDetailsMaster->Create();
$SteDetailsData		= new SteDetailsData();

require_once(DIR_WS_MODEL . "SteRateData.php");
require_once(DIR_WS_MODEL . "SteRateMaster.php");
$ObjSteRateMaster	= new SteRateMaster();
$ObjSteRateMaster	= $ObjSteRateMaster->Create();
$SteRateData		= new SteRateData();

require_once(DIR_WS_MODEL . "ServiceMaster.php");

$ObjServiceMaster	= new ServiceMaster();
$ObjServiceMaster	= $ObjServiceMaster->Create();
$ServiceData		= new ServiceData();


require_once(DIR_WS_MODEL . "StePostcodeData.php");
require_once(DIR_WS_MODEL . "StePostCodeMaster.php");
$ObjStePostCodeMaster	= new StePostCodeMaster();
$ObjStePostCodeMaster	= $ObjStePostCodeMaster->Create();
$StePostCodeData		= new StePostcodeData();

require_once(DIR_WS_MODEL . "SteTableMaster.php");
$ObjSteTableMaster	= new SteTableMaster();
$ObjSteTableMaster	= $ObjSteTableMaster->Create();
$SteTableData		= new SteTableData();

require_once(DIR_WS_MODEL . "SteTableMaster.php");
global $con;


$arr_javascript_plugin_include[] = 'datatables/datatables.min.js';

$arr_css_plugin_include[] = 'datatables/datatables.min.css';
$arr_css_plugin_include[] = 'datatables/Buttons-1.6.5/css/buttons.dataTables.min.css';
if(!empty($_GET['action']))
{
	$err['action'] = chkStr(valid_input($_GET['action']));
}
if(!empty($err['action']))
{
	logOut();
}
if($_GET['action']=="findprice")
{
	$direction = $_GET['direction'];
	$city = $_GET["city"];
	$service_type = $_GET["service_type"];
	$type=$_GET["type"];
	$ctype=$_GET["ctype"];
	if(!empty($direction))
	{
		$err['direction'] = checkStr($direction);
	}
	if(!empty($city))
	{
		$err['city'] = checkStr($city);
	}
	if(!empty($service_type))
	{
		$err['service_type'] = checkStr($service_type);
	}
	if(!empty($type))
	{
		$err['type'] = checkStr($type);
	}
	if(!empty($ctype))
	{
		$err['ctype'] = checkStr($ctype);
	}
	$find_tabel=strtolower($direction.substr($city,0,3).substr($service_type,0,2));
	
	
	{
		$fieldArr = array("*");
		$seaArr = array();
		$seaArr[] = array('Search_On'=>'table_name',
		'Search_Value'=>$find_tabel,
		'Type'=>'string',
		'Equation'=>'=',
		'CondType'=>'AND',
		'Prefix'=>'',
		'Postfix'=>'');
		$seaArr[] = array('Search_On'=>'method',
		'Search_Value'=>$ctype,
		'Type'=>'string',
		'Equation'=>'=',
		'CondType'=>'AND',
		'Prefix'=>'',
		'Postfix'=>'');
		$DataSteDetails=$ObjSteDetailsMaster->getSteDetails($fieldArr,$seaArr);
	}
	if($DataSteDetails!="")
	{
		foreach($DataSteDetails as $DataSteDetail)
		{
			if($type==0)
			{
				echo $DataSteDetail['Specific_minimum_charger'];
			}
			elseif($type==1)
			{
				echo $DataSteDetail['Basic_charge'];
			}
			elseif($type==2)
			{
				echo $DataSteDetail['Kilo_rate'];
			}
		}
	}
	else
	{
		echo "";
	}
	exit;
}
/*csrf validation*/
$csrf = new csrf();
$csrf->action = "ste_cal";

if(!isset($_POST['calculate_vale'])) {
	$ptoken = $csrf->csrfkey();
}
/*csrf validation*/

if(isset($_POST['calculate_vale']))
{
	
	if(isEmpty(valid_input($_POST['ptoken']), true)){	
		logOut();
	}else{
		//$csrf->checkcsrf($_POST['ptoken']);
	}
	
	$sbase_tariff=$_POST['base_tariff']; /// this will be the table name which we are going to take as common.
	$sservice_type=$_POST['service_type'];
	$scity_tariff=$_POST['city_tariff'];
	$direction=$_POST['direction'];
	$err['base_tariff'] = isEmpty(trim($_POST['base_tariff']),ADMIN_BASE_TARIFF_REQUIRED)?isEmpty(trim($_POST['base_tariff']),ADMIN_BASE_TARIFF_REQUIRED): checkStr($sbase_tariff);
	$err['service_type'] = isEmpty(trim($_POST['service_type']),ADMIN_SERVICE_TYPE_REQUIRED)?isEmpty(trim($_POST['service_type']),ADMIN_SERVICE_TYPE_REQUIRED): checkStr($sservice_type);
	$err['city_tariff'] = isEmpty(trim($_POST['city_tariff']),ADMIN_CITY_TARIFF_REQUIRED)?isEmpty(trim($_POST['city_tariff']),ADMIN_CITY_TARIFF_REQUIRED): checkStr($scity_tariff);
	$err['direction'] = isEmpty(trim($_POST['direction']),ADMIN_DIRECTION_IS_REQUIRED)?isEmpty(trim($_POST['direction']),ADMIN_DIRECTION_IS_REQUIRED): checkStr($direction);
	$err['rate1'] = isEmpty(trim($_POST['rate1']),ADMIN_RATE_1_IS_REQUIRED)?isEmpty(trim($_POST['rate1']),ADMIN_RATE_1_IS_REQUIRED): isNumFloat(trim($_POST['rate1']),ADMIN_RATE_1_IS_VALIDATION);
	$err['rate2'] = isEmpty(trim($_POST['rate2']),ADMIN_RATE_2_IS_REQUIRED)?isEmpty(trim($_POST['rate2']),ADMIN_RATE_2_IS_REQUIRED): isNumFloat(trim($_POST['rate2']),ADMIN_RATE_2_IS_VALIDATION);
	$err['rate3'] = isEmpty(trim($_POST['rate3']),ADMIN_RATE_3_IS_REQUIRED)?isEmpty(trim($_POST['rate3']),ADMIN_RATE_3_IS_REQUIRED): isNumFloat(trim($_POST['rate3']),ADMIN_RATE_3_IS_VALIDATION);
	if($_POST['ctype1']!='')
	{
		$err['ctype1'] = isNumeric($_POST['ctype1'],ADMIN_RATE_1_IS_VALIDATION);
	}
	
	if($_POST['ctype2']!='')
	{
		$err['ctype2'] = isNumeric($_POST['ctype2'],ADMIN_RATE_1_IS_VALIDATION);
	}
	if($_POST['ctype3']!='')
	{
		$err['ctype3'] = isNumeric($_POST['ctype3'],ADMIN_RATE_1_IS_VALIDATION);
	}
	if($_POST['price1']!='')
	{
		$err['price1'] = isNumeric($_POST['price1'],ADMIN_RATE_1_IS_VALIDATION);
	}
	if($_POST['price2']!='')
	{
		$err['price2'] = isNumeric($_POST['price2'],ADMIN_RATE_1_IS_VALIDATION);
	}
	if($_POST['price3']!='')
	{
		$err['price3'] = isNumeric($_POST['price3'],ADMIN_RATE_1_IS_VALIDATION);
	}
	
	foreach($err as $key => $Value) {
  		if($Value != '') {
  			$error_exist=1;
			$ptoken = $csrf->csrfkey();
  		}
	}
	
	$base_tariff=$direction.substr($_POST['city_tariff'],0,3).substr($_POST['service_type'],0,2);
	$base_tariff=strtolower($base_tariff);
	
	$flag=mysqli_num_rows( mysqli_query($con,"SHOW TABLES LIKE '".$base_tariff."'"));
	//echo $base_tariff.$flag;exit;
	$error_exist=0;
	
	$check_table=substr($_POST['city_tariff'],0,3).substr($_POST['service_type'],0,2);
	//$check_table=strtolower($check_table);
	$check_table=strtolower($direction.$check_table);
	//current check table is sydpm so we can change that and can take as insydec present or not adding $direction in $check_table
	
	
	//exit();
	//$sql = mysql_query("select * from ste_rates_formate where ste_table_name='".$check_table."'");
	$sql = mysqli_query($con,"select * from ste_rates_formate where table_name='".$check_table."'");
	$no=mysqli_num_rows($sql);
	//echo "number:".$no;
	
	
	/*
	if($no == 1)
	{
		$error_exist=1;
	}
	*/
	if($no==2)
	{
		if($direction == "BO")
		{
			$error_exist=1;
		}
	}
	elseif($no==1)
	{
		while($row = mysqli_fetch_array($sql)) {
			$tabel_di=substr($row["table_name"],0,2);
			
			if($tabel_di == "in" || $tabel_di == "ou")
			{
					if($direction == "BO")
					{
						$error_exist=1;
					}
			}
			elseif($tabel_di == "bo")
			{
				if($direction == "IN" || $direction == "OUT")
				{
					$error_exist=1;
				}
			}
		}
	}
	
	
	if($error_exist==0)
	{
		
		if($_POST['rate1']!="")
		{

			$sql = mysqli_query($con,"select * from ste_details where table_name='".$base_tariff."' and method=".$_POST['ctype1']);
			$no=mysqli_num_rows($sql);
			
			
			if($no==0)
			{
				$sql = mysqli_query($con,"insert into ste_details(table_name,method) values('".$base_tariff."','".$_POST['ctype1']."')");
				$sql = mysqli_query($con,"select * from ste_details where table_name='".$base_tariff."' and method=".$_POST['ctype1']);
			}
			while($row = mysqli_fetch_array($sql)) {

				$id=$row['auto_id'];
				if($_POST['price1']==0)
				{
					mysqli_query($con,"UPDATE ste_details SET Specific_minimum_charger = ".$_POST['rate1']." , method = ".$_POST['ctype1']." WHERE auto_id =".$id."");

				}
				elseif($_POST['price1']==1)
				{
					mysqli_query($con,"update ste_details set Basic_charge=".$_POST['rate1']." , method=".$_POST['ctype1']." where auto_id=".$id);

				}
				elseif($_POST['price1']==2)
				{
					mysqli_query($con,"update ste_details set Kilo_rate=".$_POST['rate1']." , method=".$_POST['ctype1']." where auto_id=".$id);
				}
			}


		}
		if($_POST['rate2']!="")
		{
			$sql = mysqli_query($con,"select * from ste_details where table_name='".$base_tariff."' and method=".$_POST['ctype2']);
			$no = mysqli_num_rows($sql);
			if($no==0)
			{
				$sql = mysqli_query($con,"insert into ste_details(table_name,method) values('".$base_tariff."','".$_POST['ctype2']."')");
				$sql = mysqli_query($con,"select * from ste_details where table_name='".$base_tariff."' and method=".$_POST['ctype2']);
			}
			while($row = mysqli_fetch_array($sql)) {

				$id=$row['auto_id'];
				if($_POST['price2']==0)
				{

					mysqli_query($con,"UPDATE ste_details SET Specific_minimum_charger = ".$_POST['rate2']." , method = ".$_POST['ctype2']." WHERE auto_id =".$id."");

				}
				elseif($_POST['price2']==1)
				{
					mysqli_query($con,"update ste_details set Basic_charge=".$_POST['rate2']." , method=".$_POST['ctype2']." where auto_id=".$id);

				}
				elseif($_POST['price2']==2)
				{
					mysqli_query($con,"update ste_details set Kilo_rate=".$_POST['rate2']." , method=".$_POST['ctype2']." where auto_id=".$id);
				}
			}
		}
		if($_POST['rate3']!="")
		{
			$sql = mysqli_query($con,"select * from ste_details where table_name='".$base_tariff."' and method=".$_POST['ctype3']);
			$no=mysqli_num_rows($sql);
			if($no==0)
			{
				$sql = mysqli_query($con,"insert into ste_details(table_name,method) values('".$base_tariff."','".$_POST['ctype3']."')");
				$sql = mysqli_query($con,"select * from ste_details where table_name='".$base_tariff."' and method=".$_POST['ctype3']);
			}
			while($row = mysqli_fetch_array($sql)) {
				//print_R($row);
				$id=$row['auto_id'];
				if($_POST['price3']==0)
				{

					mysqli_query($con,"UPDATE ste_details SET Specific_minimum_charger = ".$_POST['rate3']." , method = ".$_POST['ctype3']." WHERE auto_id =".$id."");

				}
				elseif($_POST['price3']==1)
				{
					mysqli_query($con,"update ste_details set Basic_charge=".$_POST['rate3']." , method=".$_POST['ctype3']." where auto_id=".$id);

				}
				elseif($_POST['price3']==2)
				{
					mysqli_query($con,"update ste_details set Kilo_rate=".$_POST['rate3']." , method=".$_POST['ctype3']." where auto_id=".$id);
				}
			}
		}
		
		$sql = mysqli_query($con,"select * from ste_rates_formate where table_name='".$base_tariff."'");
		$no=mysqli_num_rows($sql);
		if($no==0)
		{
			$sql = mysqli_query($con,"insert into ste_rates_formate(table_name,format,method,ste_table_name,service_code) values('".$base_tariff."','".$_POST['price1'].$_POST['price2'].$_POST['price3']."','".$_POST['ctype1'].$_POST['ctype2'].$_POST['ctype3']."','".$sbase_tariff."','".$_POST['service_type']."')");
		}
		else {

			mysqli_query($con,"update ste_rates_formate set format='".$_POST['price1'].$_POST['price2'].$_POST['price3']."' , method='".$_POST['ctype1'].$_POST['ctype2'].$_POST['ctype3']."' , ste_table_name='".$sbase_tariff."', service_code='".$_POST['service_type']."' where table_name='".$base_tariff."'");
		}
	}

}



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
 
<script type="text/javascript">
$(document).ready(function(){
	get_price();
	var city_val = $("#city_tariff").val();
	
	
	
	function get_price()
	{
		price(1,$("#price1").val(),$("#ctype1").val());
		price(2,$("#price2").val(),$("#ctype2").val());
		price(3,$("#price3").val(),$("#ctype3").val());
	}
	$("#city_tariff").change(function(){
		get_price();
		var city_val = $("#city_tariff").val();
		
	});
	$("#direction").change(function(){
		get_price();
	});
	$("#service_type").change(function(){
		get_price();
	});
	$("#ctype1").change(function(){
		price(1,$("#price1").val(),$("#ctype1").val());
	});
	$("#ctype2").change(function(){
		price(2,$("#price2").val(),$("#ctype2").val());
	});
	$("#ctype3").change(function(){
		price(3,$("#price3").val(),$("#ctype3").val());
	});
	$("#base_tarrif_hidden").change(function(){ 
		get_price();

	});



	$("#c_cal").click(function(){
		var o_city=$("#o_city").val();
		var d_city=$("#d_city").val();
		var cal_type=$("#ctype").val();
		var xmlhttp;
		xmlhttp=ajaxRequest();
		xmlhttp.onreadystatechange=function()
		{
			if (xmlhttp.readyState==4 && xmlhttp.status==200)
			{
				var msg=xmlhttp.responseText;
				alert(msg);
			}
		}
		xmlhttp.open("GET","ste_cal.php?action=ajax&o_city="+o_city+"&d_city="+d_city+"&kg="+$("#c_kg").val()+"&ctype="+cal_type);
		xmlhttp.send();
	});


	$("#export").click(function(){

		if($("#base_tarrif_hidden").val()!="")
		{
			window.open("<?php echo SITE_ADMIN_URL;?>"+"ste_cal.php?action=export&table="+$("#base_tarrif_hidden").val()+"&direction="+$("#direction").val());
			return false;
		}
		else
		{
			alert("Select Service");
		}
	});


	$("#calculate").click(function(){ 
		if($("#city_tariff").val()==0)
		{
			$("#err_city_tariff").html("Select City tariff");
			return false;
		}
		if($("#direction").val()==0)
		{
			$("#err_direction").html("Select direction");
			return false;
		}
		if($("#service_type").val()==0)
		{
			$("#err_service_type").html("Select Service type");
			return false;
		}
		
		if($("#base_tarrif_hidden").val()==0)
		{
			$("#err_base_tariff").html("Select Base Tarrif");
			return false;
		}
		
		
		if($("#rate1").val() == '')
		{
			$("#err_rate1").html("Please enter rate1 value.");
			$("#rate1").focus();
			return false;
		}else
		{
			if(isNaN($("#rate1").val()) == true)
			{
				$("#err_rate1").html("Please enter numeric value.");
				return false;
			}
			
		}
		if($("#rate2").val() == '')
		{
			$("#err_rate2").html("Please enter rate2 value.");
			$("#rate2").focus();
			return false;
		}else
		{
			if(isNaN($("#rate2").val()) == true)
			{
				$("#err_rate2").html("Please enter numeric value.");
				return false;
			}
		}
		if($("#rate3").val() == '')
		{
			$("#err_rate3").html("Please enter rate3 value.");
			$("#rate3").focus();
			return false;
		}else
		{
			if(isNaN($("#rate3").val()) == true)
			{
				$("#err_rate3").html("Please enter numeric value.");
				return false;
			}
		}
		//alert(check_cal_method());
		//return false;
		if(check_cal_method())
		{
			$("#calculate_vale").val("");
			$("#f1").submit();

		}
		else
		{
			$("#err_change_type").html("Plz change charge type");
			return false;
		}
		

	});
	$("#o_city").focus(function(){
		var o_city=$(this).val();
		if(o_city=="Origin City")
		{
			$(this).val("");
		}

	});
	$("#o_city").blur(function(){
		var o_city=$(this).val();
		if(o_city=="")
		{
			$(this).val("Origin City");
		}
	});
	$("#d_city").focus(function(){

		var d_city=$(this).val();
		if(d_city=="Destination City")
		{
			$(this).val("");
		}
	});
	$("#d_city").blur(function(){
		var d_city=$(this).val();
		if(d_city=="")
		{
			$(this).val("Destination City");
		}
	});
	$("#c_kg").focus(function(){
		var c_kg=$(this).val();
		if(c_kg=="Kg")
		{
			$(this).val("");
		}
	});
	$("#c_kg").blur(function(){
		var c_kg=$(this).val();
		if(c_kg=="")
		{
			$(this).val("Kg");
		}
	});

	$("#o_city").keyup(function(){
		showResult($("#o_city").val(),1);
	});
	$("#d_city").keyup(function(){
		showResult($("#d_city").val(),2);
	});
	$("#price1").change(function(){
		price(1,$(this).val(),$("#ctype1").val());
	});
	$("#price2").change(function(){
		price(2,$(this).val(),$("#ctype2").val());
	});
	$("#price3").change(function(){
		price(3,$(this).val(),$("#ctype3").val());
	});
});
function price(textbox,type,ctype)
{
	var city=$("#city_tariff").val();
	var direction=$("#direction").val();
	var service_type=$("#service_type").val();
	var xmlhttp;
	xmlhttp=ajaxRequest();
	xmlhttp.onreadystatechange=function()
	{
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			var msg=xmlhttp.responseText;
			if(textbox==1)
			{
				$("#rate1").val(msg);
			}
			else if(textbox==2)
			{
				$("#rate2").val(msg);
			}
			else if(textbox==3)
			{
				$("#rate3").val(msg);
			}
		}
	}
	xmlhttp.open("GET","ste_cal.php?action=findprice&city="+city+"&type="+type+"&ctype="+ctype+"&direction="+direction+"&service_type="+service_type);
	xmlhttp.send();
}
function showResult(val,divid)
{
	
	var xmlhttp;
	xmlhttp=ajaxRequest();
	xmlhttp.onreadystatechange=function()
	{
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			var msg=xmlhttp.responseText;
			
			if(divid==1)
			{
				if(msg!="")
				{
					$("#o_city_livesearch").css("border","1px solid");
					$("#o_city_livesearch").css("display","block");                
					$("#o_city_livesearch").html(msg);
					$("#o_city_livesearch span").live("click", function(){ $("#o_city").val($(this).html()); $("#o_city_livesearch").css("display","none"); });
				}
				else
				{
					$("#o_city_livesearch").html("");
					$("#o_city_livesearch").css("display","none");
				}
			}
			if(divid==2)
			{
				if(msg!="")
				{
					$("#d_city_livesearch").css("border","1px solid");
					$("#d_city_livesearch").css("display","block");
					$("#d_city_livesearch").html(msg);
					$("#d_city_livesearch span").live("click", function(){ $("#d_city").val($(this).html()); $("#d_city_livesearch").css("display","none"); });

				}
				else
				{
					$("#d_city_livesearch").html("");
					$("#d_city_livesearch").css("display","none");
				}
			}
			return false;

		}
	}
	xmlhttp.open("GET","ste_cal.php?action=searchkey&key="+val,true);
	xmlhttp.send();
}
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

/*
var city=$("#city_tariff").val();
var direction=$("#direction").val();
var service_type=$("#service_type").val();
var xmlhttp;
xmlhttp=ajaxRequest();
xmlhttp.onreadystatechange=function()
{
if (xmlhttp.readyState==4 && xmlhttp.status==200)
{
var msg=xmlhttp.responseText;
$("#base_tarrif_hidden").val(table_name);
$("#base_tarrif_hidden option").each(function () {
var str;
str = $(this).text();
alert(msg);
if(str==msg)
{
$(this).attr("selected","selected");
}
});

}
}
xmlhttp.open("GET","ste_cal.php?action=findtable&city="+city+"&type="+type+"&direction="+direction+"&service_type="+service_type);
xmlhttp.send();

*/
function find_table_name()
{
	if(($("#service_type").val()!=0) && ($("#city_tariff").val()!=0))
	{
		var table_name=$("#city_tariff").val()+$("#service_type").val();



		$("#base_tarrif_hidden").val(table_name);
		$("#base_tarrif_hidden option").each(function () {
			var str;
			str = $(this).text();
			if(str==table_name)
			{
				$(this).attr("selected","selected");
			}
		});

		//$("#base_tariff").html("<b>"+table_name+"</b>");
	}
	else
	{
		$("#base_tarrif_hidden").val("");
		$("#base_tariff").html("");
	}
	price(1,$("#price1").val(),$("#ctype1").val());
	price(2,$("#price2").val(),$("#ctype2").val());
	price(3,$("#price3").val(),$("#ctype3").val());
}

function check_cal_method()
{
	if((($("#rate1").val()!="") && ($("#rate2").val()=="") && ($("#rate3").val()=="") ) || (($("#rate2").val()!="") && ($("#rate1").val()=="") && ($("#rate3").val()=="") ) || (($("#rate3").val()!="") && ($("#rate1").val()=="") && ($("#rate2").val()=="") ) )
	{
		return true;
	}
	else
	{
		if(($("#price1").val()==($("#price2").val())) ||  ($("#price1").val()==($("#price3").val())) || ($("#price3").val()==($("#price2").val())))
		{
			return false
		}
		else
		{
			return true;
		}
	}
}
<?php if($error_exist==1) { ?>

alert("Service Direction Conflict With Other Service Direction");
<?php } ?>



</script>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

</head>
<body>
<?php
if(isset($_POST["city_tariff"]))
{	/*echo "<pre>";
	print_r($_POST);*/

	$scity_tariff=$_POST["city_tariff"];
	$sdirection=$_POST["direction"];
	$sservice_type=$_POST["service_type"];
	$sbase_tariff=$_POST["base_tariff"];
	$sql = mysqli_query($con,"select * from ste_rates_formate where table_name='".$sdirection.$sbase_tariff."'");
	$no=mysqli_num_rows($sql);
	if($no!=0)
	{
		while($row = mysqli_fetch_array($sql)) {

			$_POST['price1']=substr($row['format'],0,1);
			$_POST['price2']=substr($row['format'],1,1);
			$_POST['price3']=substr($row['format'],2,1);
			$_POST['ctype1']=substr($row['method'],0,1);
			$_POST['ctype2']=substr($row['method'],1,1);
			$_POST['ctype3']=substr($row['method'],2,1);
		}


	}
}
?>

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
									<td colspan="4"><form name="f1" method="POST" action="" id="f1">
										<table border="0" cellspacing="0" cellpadding="0" class="middle_right_content">
										
										<tr>
											<td align="left" class="breadcrumb" colspan="8">
												<span><a href="<?php echo FILE_WELCOME_ADMIN; ?>"><?php echo ADMIN_HEADER_HOME;?></a> > <?php echo "STE CALCULATION"; ?></span>
												<div><label class="top_navigation"><a href="ste_table.php?city_tariff=<?php echo $_POST["city_tariff"]; ?>">Back</a>													
												</label>
												</div>
												</td>
											</tr>
											
											<tr>
												<td colspan="8" height="50%"><input type="hidden" size="34" id="ptoken" value="<?php echo $ptoken; ?>" name="ptoken">&nbsp;</td>
											
											</tr>
											<tr>
												<td colspan="8">
													<table border="0">
														<tr>
											<td>City Tariff</td>
											<td>&nbsp;</td>
											<td>Service Type</td>
											<td>&nbsp;</td>
											<td>Direction</td>
											<td>&nbsp;</td>
											<td>Base Tariff</td>
											<td>&nbsp;</td>
											</tr>
											
											<tr>
											<td>
											
											<?php

											$fieldArr = array("DISTINCT Zone");
											$DataStePostCodes=$ObjStePostCodeMaster->getStePostCode($fieldArr);
											//print_R($DataStePostCodes);
											?>
											<select id="city_tariff" name="city_tariff">
											<option value="0" selected>Select</option>
											<!--<?php
											foreach ($DataStePostCodes as $datacity)
											{
											if($datacity['Zone']!=""){	?>
											<option value="<?php echo $datacity['Zone']; ?>" <?php if($scity_tariff==$datacity['Zone']){ echo "selected"; } ?>><?php echo $datacity['Zone']; ?></option>	
											
											<?php
											}
											}
											?>-->
												
											<option value="ADL" <?php if($scity_tariff=="ADL"){ echo "selected"; } ?>>ADL-Adelaide</option>
											<option value="BRS" <?php if($scity_tariff=="BRS"){ echo "selected"; } ?>>BRS-Brisbane</option>
											<option value="CBR" <?php if($scity_tariff=="CBR"){ echo "selected"; } ?>>CBR-Canberra</option>
											<option value="MEL" <?php if($scity_tariff=="MEL"){ echo "selected"; } ?> >MEL-Melbourne</option>
											<option value="PER" <?php if($scity_tariff=="PER"){ echo "selected"; } ?>>PER-Perth</option>
											<option value="SYD" <?php if($scity_tariff=="SYD"){ echo "selected"; } ?>>SYD-Sydney</option>
											<option value="DAR" <?php if($scity_tariff=="DAR"){ echo "selected"; } ?>>DAR-Darwin</option>
											<option value="HOB" <?php if($scity_tariff=="HOB"){ echo "selected"; } ?>>HOB-Hobart</option>
											<option value="LCN" <?php if($scity_tariff=="LCN"){ echo "selected"; } ?>>LCN-Launceston</option>
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
											<option value="ZZZ" <?php if($scity_tariff=="ZZZ"){ echo "selected"; } ?>>zzz</option>
											<option value="AUS" <?php if($scity_tariff=="AUS"){ echo "selected"; } ?>>aus</option>
											<option value="TNT" <?php if($scity_tariff=="TNT"){ echo "selected"; } ?>>tnt</option>
											</select>
											</td>
											<td>&nbsp;</td>
											<td >
											<select id="service_type" name="service_type">
											<option value="0">Select</option>	
											<?php

											$fieldArr=array("*");
											$data = $ObjServiceMaster->getService($fieldArr);
											foreach ($data as $dataservice)
											{?>
											<option value="<?php echo valid_output($dataservice['service_code']); ?>" <?php if($sservice_type==$dataservice['service_code']){ echo "selected"; } ?>><?php echo valid_output($dataservice['service_name']); ?></option>	
											
											<?php

											}
											?>
											</select>											
											</td>
											<td>&nbsp;</td>
											<td> 
											<div id="all_dir">
												<select id="direction" name="direction">											
												<option value="IN" <?php if($sdirection=="IN"){ echo "selected"; } ?>>Inbound</option>
												<option value="OUT" <?php if($sdirection=="OUT"){ echo "selected"; } ?>>Outbound</option>
												<option value="BO" <?php if($sdirection=="BO"){ echo "selected"; } ?>>Both</option>
												</select>
											</div>
											<!--<div id="both_dir">
												<select id="zzz_direction" name="direction">
												<option value="BO" <?php if($sdirection=="BO"){ echo "selected"; } ?>>Both</option>
												</select>
											</div>		-->
											</td>
											<td>&nbsp;</td>
											<td>
											<select id="base_tarrif_hidden" name="base_tariff">
											<option value="0">Select</option>	
											<?php 

											$sql=mysqli_query($con,"select * from ste_table_detail");

											while($row = mysqli_fetch_array($sql)) {
												$table=$row['table_name'];
											?>
											<option value="<?php echo $table; ?>" <?php if($sbase_tariff==$table){ echo "selected"; } ?>><?php echo valid_output($table); ?></option>
											<?php										
											}
											?>							
											</select>
											<!--<div id="base_tariff"><?php if(isset($base_tariff)){ echo strtoupper($base_tariff); } ?></div><input type="hidden" id="base_tarrif_hidden" name="base_tariff" value="<?php if(isset($base_tariff)){ echo strtoupper($base_tariff); } ?>">-->
											</td>
											<td>&nbsp;</td>
											</tr>
											<tr>
												<td class="message_mendatory" colspan="2" id="err_city_tariff"><?php echo $err['city_tariff'];?>&nbsp;</td>
												<td class="message_mendatory" colspan="2" id="err_service_type"><?php echo $err['service_type']; ?>&nbsp;</td>
												<td  class="message_mendatory" colspan="2" id="err_direction"><?php echo $err['direction']; ?>&nbsp;</td>
												<td  class="message_mendatory" colspan="2" id="err_base_tariff"><?php echo $err['base_tariff']; ?></td>
											</tr>
													
													</table>
												</td>
											</tr>
											
											<tr><td colspan="8">&nbsp;</td></tr>
											<tr>
											<td colspan="8" class="breadcrumb"></td>
											</tr>
											
											<tr><td colspan="8" id="err_change_type" class="message_mendatory">&nbsp;</td></tr>
											<tr>
												<td  width="100px"> </td>
												<td colspan="2" width="125px">Calculation Method </td>
												<td width="10px"></td>
												<td colspan="1" width="125px">Rate</td>												
												<td colspan="3"  align="left"></td>
												
												
											</tr>
											
											<tr>
												<td>
													<select name="price1" id="price1">
													<option value="0" <?php if($_POST['price1']=="0"){ echo "selected";}?>>Minimum</option>
													<option value="1" <?php if($_POST['price1']=="1"){ echo "selected";}?>>Basic</option>
													<option value="2" <?php if($_POST['price1']=="2"){ echo "selected";}?>>Unit</option>
													
													</select>
												
												</td>
												<td colspan="2">
												<div id="ctype1_div">
												<select  id="ctype1" name="ctype1">
													<option value="1"<?php if($_POST['ctype1']==1){ echo "selected";}?>>Percentage</option>
													<option value="2"<?php if($_POST['ctype1']==2){ echo "selected";}?>>Flat Charge Calculator</option>
												</select>
												</div>
												</td>
												<td width="10px"></td>
												<td colspan="2"><input type="text" id="rate1" value="<?php echo valid_output($_POST['rate1']); ?>" name="rate1" /></td>
												<td></td>
												
												<td></td>
											</tr>
											<tr>
												<td class="message_mendatory"><?php echo $err['price1'];?></td>
												<td colspan='2' class="message_mendatory"><?php echo $err['ctype1'];?></td>
												<td></td>
												<td colspan='2' class="message_mendatory" id="err_rate1"><?php echo $err['rate1'];?></td>
											</tr>

											<tr>
												<td>
													<select name="price2" id="price2">
													<option value="0" <?php if($_POST['price2']=="0"){ echo "selected";}?>>Minimum</option>
													<option value="1" <?php if($_POST['price2']=="1"){ echo "selected";}?>>Basic</option>
													<option value="2" <?php if($_POST['price2']=="2"){ echo "selected";}?>>Unit</option>
													</select>
												
												</td>
												<td colspan="2">
												<div id="ctype2_div">
												<select  id="ctype2" name="ctype2">
													<option value="1" <?php if($_POST['ctype2']==1){ echo "selected";}?>>Percentage</option>
													<option value="2" <?php if($_POST['ctype2']==2){ echo "selected";}?>>Flat Charge Calculator</option>
												</select>
												</div>
												</td><td width="10px"></td>
								<td colspan="2"><input type="text" id="rate2" value="<?php echo $_POST['rate2']; ?>" name="rate2" /></td>
								
												<td></td>
												<td></td>
											</tr>
<tr>
												<td class="message_mendatory"><?php echo $err['price2'];?></td>
												<td colspan='2' class="message_mendatory"><?php echo $err['ctype2'];?></td>
												<td></td>
												<td colspan='2' class="message_mendatory" id="err_rate2"><?php echo $err['rate2'];?></td>
											</tr>

											<tr>
												<td>
													<select name="price3" id="price3">
													<option value="0" <?php if($_POST['price3']=="0"){ echo "selected";}?>>Minimum</option>
													<option value="1" <?php if($_POST['price3']=="1"){ echo "selected";}?>>Basic</option>
													<option value="2" <?php if($_POST['price3']=="2"){ echo "selected";}?>>Unit</option>
													</select>
												
												</td>
												<td colspan="2">
												<div id="ctype3_div">
												<select  id="ctype3" name="ctype3">								
												<option value="1" <?php if($_POST['ctype3']==1){ echo "selected";}?>>Percentage</option>
												<option value="2" <?php if($_POST['ctype3']==2){ echo "selected";}?>>Flat Charge Calculator</option>
												</select></div>
								</td><td width="10px"></td>
								<td colspan="2"><input type="text" id="rate3" value="<?php echo valid_output($_POST['rate3']); ?>" name="rate3" /></td>
								
												<td></td>
												<td>
												
												</td>
											</tr>
<tr>
												<td class="message_mendatory"><?php echo $err['price3'];?></td>
												<td colspan='2' class="message_mendatory"><?php echo $err['ctype3'];?></td>
												<td></td>
												<td colspan='2' class="message_mendatory" id="err_rate3"><?php echo $err['rate3'];?></td>
											</tr>
											
											<tr>
											<td></td>
											<td></td>
											<td></td>
											<td colspan='5'>
											
											&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input id="calculate" type="button" value="SAVE" name="calculate" >
												&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="hidden" value="calculate_vale" name="calculate_vale" id="c_cal"></td>
											</tr>
											<tr>
												<td colspan='8'>
													
												</td>
											</tr>
										
										</table>
										</form>
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
<script>
function valid()
{
	var errorflag = false;
	if(document.getElementById('rate1').value=="")
	{
		alert("Please enter rate1 value.");
		document.getElementById('rate1').focus();
		errorflag = true;		
	}
	if(errorflag == true){
		return false;
	}else{
		document.getElementById("f1").submit();
	}
	
}
</script>