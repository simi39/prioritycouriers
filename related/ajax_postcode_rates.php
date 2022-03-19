<?php
require_once("../lib/common.php");
require_once(DIR_WS_RELATED.'system_mail.php');
require_once(DIR_WS_CURRENT_LANGUAGE . "booking.php");

$pickup  = valid_input($_POST['pickup']);
$deliver = valid_input($_POST['deliver']);
if($pickup != "PICK UP SUBURB/POSTCODE")
{
	$o_st_city_zone = getDirectZoneFromSt($pickup);
}
if($deliver != "ENTER SUBURB OR POSTCODE")
{
	$d_st_city_zone = getDirectZoneFromSt($deliver);
}
//echo "destination:".$d_st_city_zone ;
//exit();
//echo $o_st_city_zone."---".$d_st_city_zone;
$metrozones = explode(",",zones_within_australia); /*Used to create array for the zones within australia. */
/*
$mystring = 'abc';
$findme   = 'a';
$pos = strpos($mystring, $findme);

// The !== operator can also be used.  Using != would not work as expected
// because the position of 'a' is 0. The statement (0 != false) evaluates 
// to false.
if ($pos !== false) {
     echo "The string '$findme' was found in the string '$mystring'";
         echo " and exists at position $pos";
} else {
     echo "The string '$findme' was not found in the string '$mystring'";
}
*/
if(!empty($metrozones))
{
	foreach($metrozones as $metrozone)
	{		
		
		if(!empty($metrozone) && !empty($o_st_city_zone) && strpos($metrozone,$o_st_city_zone)!== false)
		{
			$o_metro_valid_state_arr = explode("-",$metrozone);
			$o_metro_valid_state = $o_metro_valid_state_arr[0];
		}
		if(!empty($metrozone) && !empty($d_st_city_zone) && strpos($metrozone,$d_st_city_zone)!== false)
		{
			$d_metro_valid_state_arr = explode("-",$metrozone);
			$d_metro_valid_state = $d_metro_valid_state_arr[0];
		}
	}
}

if(empty($o_metro_valid_state) && empty($d_metro_valid_state))
{
	$o_metro_valid_state = $o_st_city_zone;	
	$d_metro_valid_state = $d_st_city_zone;
}
//echo $o_metro_valid_state."---".$d_metro_valid_state;
if($o_metro_valid_state == $d_metro_valid_state)
{
	//echo $o_metro_valid_state."---".$d_metro_valid_state;
	$metroresult = totalServices($o_metro_valid_state,$d_metro_valid_state);
	if($metroresult != "")
	{
		$metro_no = mysqli_num_rows($metroresult);
	}
	if($metro_no ==0)
	{
		$err['no_service_available'] = NO_SERVICE_AVAILABLE;
	}
	/*
	echo "<pre>";
	print_R($metroresult);
	echo "</pre>"; */
	if($metro_no!=0){
		while($row = mysqli_fetch_array($metroresult)){
			$ser_code = $row['service_code'];
			//echo $ser_code;
			
			$code_format_id = 10;
			$service_val = getServiceData($ser_code,$code_format_id);
			$service_val = $service_val[0];
			/*echo "<pre>";
			print_r($service_val);
			echo "</pre>";*/
			
			
			if(!empty($service_val))
			{
				$service = strtolower($service_val->service_code);
				
				/* condition for outbound */
				if($o_metro_valid_state!='')
				{
					$base_tariff = strtolower($o_metro_valid_state.$service);
					
					$base_tariff = outboundDir($base_tariff);
					$tbl = checkTableExit($base_tariff);
					
					if($tbl)
					{
						$result_val=json_encode('true');
						
					}
				}
				/* condition for inbound */
				if($d_metro_valid_state!='')
				{
					$base_tariff = strtolower($d_metro_valid_state.$service);
					$base_tariff = inboundDir($base_tariff);
					$tbl = checkTableExit($base_tariff);
					
					if($tbl)
					{
						$result_val= json_encode('true');
						
					}
				}
				/* condition for both */
				if(empty($tbl))
				{
					$base_tariff = strtolower($o_metro_valid_state.$service);
					$base_tariff = bothDir($base_tariff);
					$tbl = checkTableExit($base_tariff);
					
					if($tbl)
					{
						$result_val= json_encode('true');
						
					}
				}
				/* condition for zzz */
				if(empty($tbl))
				{
					$base_tariff = strtolower('zzz'.$service);
					$base_tariff = bothDir($base_tariff);
					$tbl = checkTableExit($base_tariff);
					
					if($tbl)
					{
						$result_val=json_encode('true');
						
					}
				}
				/*
				if(empty($tbl))
				{
					postcode_not_present($pickup,$deliver);
					echo json_encode('false');
					exit();
				} */
			}
		}
	}
}else{
	$code_format_id = 0;
	//echo $o_st_city_zone."---".$d_st_city_zone;
	if(!empty($o_st_city_zone) && !empty($d_st_city_zone))
	{
		$result = totalServices('','',$code_format_id);
	}
	if($result != "")
	{
		$no = mysqli_num_rows($result);
	}
	if($no ==0)
	{
		$err['no_service_available'] = NO_SERVICE_AVAILABLE;
	
	}
	if($no!=0)
	{
		while($row = mysqli_fetch_array($result)){
			$ser_code = $row['service_code'] ;
			$service_val = getServiceData($ser_code,$code_format_id,$cond_metro);
			$service_val = $service_val[0];
			if(!empty($service_val))
			{
				$service = strtolower($service_val['service_code']);
				$base_tariff = $city.$service;
				$base_tariff_destination = $d_st_city_zone.$service;
				$base_tariff = strtolower('aus'.$service);
				$base_tariff = bothDir($base_tariff);
				$tbl = checkTableExit($base_tariff);
				$rate_exit =  ajax_cal_val($tbl,$o_st_city_zone,$d_st_city_zone);
				//echo "rate".$rate_exit;
				if($rate_exit!=0)
				{
					$result_val= json_encode('true');
					//exit();
				}
				if(empty($rate_exit))
				{
					$base_tariff = strtolower('zzz'.$service);
					$base_tariff = bothDir($base_tariff);
					$tbl = checkTableExit($base_tariff);
					//echo "table:".$base_tariff;
					if($tbl)
					{
						$result_val = json_encode('true');
						
					}
				}
				/*
				if($rate_exit == 0)
				{
					postcode_not_present($pickup,$deliver);
					$result_val = json_encode('false');
					
				} */
			}
		}
	}
}

if(empty($result_val))
{
	postcode_not_present($pickup,$deliver);
	echo json_encode('false');
	exit();
} 
echo json_encode($result_val);
exit();
?>