<?php
session_start();
ob_start();
require_once("../lib/common.php");

require_once(DIR_WS_CURRENT_LANGUAGE . "interstate.php");
require_once(DIR_WS_MODEL . "ServiceMaster.php");
require_once(DIR_WS_MODEL."PostCodeMaster.php");

$ObjServiceMaster = new ServiceMaster();
$ObjServiceMaster	= $ObjServiceMaster->Create();
$ServiceData		= new ServiceData();

$PostCodeMasterObj = new PostCodeMaster();
$PostCodeMasterObj = $PostCodeMasterObj->create();
$PostCodeDataObj = new PostCodeData();
$BookingDetailsDataObjArray = $__Session->GetValue("booking_details");

$bk_type_hidden = $_POST["booking_type_hidden"];
$total_amt = $_POST['total_amt'];
$ServiceDetailsData = $__Session->GetValue("service_details");
//$selectedTime = $_POST['selectedTime'];
$selectedDate = date('d-m-Y',strtotime($_POST['selectedDate']));
$defaultDate = date('d-m-Y',strtotime($_POST['defaultDate']));
$notime = 'false';
$serviceName = $_POST['serviceName'];
//echo $selectedDate."---".$defaultDate."</br>";
/*
Important Note:
user time is taken as 7:00 AM because when a person clicks on SELECT SERVICE
he always sees next business day with starting time of booking.
In interstate there is no consideration of ready time and close time with cutoff time
to show services. Because interstate jobs can be delivered in 2 days also or 3 days depending on place they have selected
Therefore always zone date and current time is considered to show available services for Today option of collection time.

*/

if(isset($defaultDate) && !empty($defaultDate) && isset($selectedDate) && !empty($selectedDate) && strtotime($defaultDate) == strtotime($selectedDate)){
	$formateddate = date('d-m-Y h:i a',strtotime($_POST['defaultDate']));

	$formatedateArr    = explode(" ",$formateddate);

	$time_hr    = $formatedateArr[1];
	$hr_formate = strtolower($formatedateArr[2]);
	$hrtiming = $time_hr." ".$hr_formate;
	$usertiming = date('h:i a',strtotime($hrtiming));

}else{
	//$notime = 'true';
	$usertiming = '7:00 am';
}
//echo $usertiming."</br>";
/*
if(isset($_POST['defaultDate']) && !empty($_POST['defaultDate'])){
	$defaultDateArr = explode(" ",$_POST['defaultDate']);
	$defaultDt = $defaultDateArr[0];
	if(isset($selectedTime) && !empty($selectedTime))
	{
		$dateArr    = explode(" ",$selectedTime);
		$selectedDt = $dateArr[0];
	}
	if(isset($defaultDt) && !empty($defaultDt) && isset($selectedDt) && !empty($selectedDt) && $defaultDt == $selectedDt){
		$formateddate = date('d F Y h:i:s a',strtotime($_POST['defaultDate']));
		//echo "formate date:".$formateddate."</br>";
		$formatedateArr    = explode(" ",$formateddate);
		$time_hr    = $formatedateArr[0];
		$time_sec   = $formatedateArr[1];
		$hr_formate = strtolower($formatedateArr[4]);
		$usertiming = $time_hr.":".$time_sec." ".$hr_formate;

	}else{
		$usertiming = "12:00 am";
	}

}else{
	if(isset($selectedTime) && !empty($selectedTime))
	{
		$dateArr    = explode(" ",$selectedTime);

		$timeArr    = explode(":",$dateArr[3]);
		$start_date = $selectedTime;
		$time_hr    = $timeArr[0];
		$time_sec   = $timeArr[1];
		$hr_formate = strtolower($dateArr[4]);
		$usertiming = $time_hr.":".$time_sec." ".$hr_formate;

	}else{
		$usertiming = "12:00 am";
	}
}
*/
//echo "selected Time:".$selectedTime;
//exit();


$BookingDetailsDataObjArray = $__Session->GetValue("booking_details");
$BookingDetailsDataObjArray["start_date"] = $selectedDate;
$BookingDetailsDataObjArray["date_ready"] = $start_date;
$BookingDetailsDataObjArray["time_ready"] = $collectionTime;
$__Session->SetValue("booking_details",$BookingDetailsDataObjArray);
$__Session->Store();


$session_data = json_decode($_SESSION['Thesessiondata']['_sess_login_userdetails'],true);
$userid       = $session_data['user_id'];
/*
30 Sep 2014 04:45 PM
*/
$str="";
$k =1;
for($i=0;$i<count($ServiceDetailsData);$i++)
{

 $fieldArr =array();
 $fieldArr=array("auto_id","supplier_id","service_name","service_info","service_status_info","service_description","box_color","hours","minites","hr_formate");
 //echo $ServiceDetailsData[$i]['service_code'];
 $seaByArr=array();

 $service_name = valid_output($ServiceDetailsData[$i]['service_name']);
 $service_code = valid_output($ServiceDetailsData[$i]['service_code']);
 //echo "service code:".$service_code;
 //exit();
 $seaByArr[]=array('Search_On'=>'service_name', 'Search_Value'=>"$service_name", 'Type'=>'string', 'Equation'=>'=', 'CondType'=>'and', 'Prefix'=>'', 'Postfix'=>'');
 $seaByArr[]=array('Search_On'=>'service_code', 'Search_Value'=>"$service_code", 'Type'=>'string', 'Equation'=>'=', 'CondType'=>'and', 'Prefix'=>'', 'Postfix'=>'');
 //$optArr[]	=	array("Order_By" => "col1","Order_Type" => "ASC"	);
 $service_data = $ObjServiceMaster->getService($fieldArr,$seaByArr);
 $service_val = $service_data[0];

 $final_price = ($ServiceDetailsData[$i]['service_rate']);
 $time_hr1=valid_output($service_val['hours']);
 $time_sec1=valid_output($service_val['minites']);
 $hr_formate1=valid_output($service_val['hr_formate']);
 $dbtiming   = $time_hr1.":".$time_sec1." ".$hr_formate1;
 $courier_id = $service_val['supplier_id'];
 //echo "service name:".$service_name." select time:".$selectedTime." service cutoff timing:".$dbtiming."</br>";

	if(isset($final_price)){
		$opacity ="bg_opacity";
		$button = SELECT_SERVICE;
		//echo 'current:'.($usertiming)."----dbtime:".($dbtiming)."</br>";
		//echo strtotime($usertiming)."----".strtotime($dbtiming)."</br>";
		if((strtotime($usertiming)<=strtotime($dbtiming)))
		{

			$opacity ="";
			$button = SELECT_SERVICE;
		}
		/*if(isset($notime) && $notime == 'true'){
			$opacity ="";
		}*/
		$priceArr = explode(".",number_format($final_price,2,'.',''));
		$dollarVal = $priceArr[0];
		$centVal = $priceArr[1];
		$addclass= '';
		$btn_name = SELECT_SERVICE;
		if(isset($serviceName) && $serviceName == strtolower($service_name)){
			$addclass= 'top-price';
			$btn_name = "SELECTED";
			//echo "add class:".$addclass."</br>";
		}
			$str .= '<div id="'.$service_code.'" class="span4 pricing hover-effect '.$addclass.'">';
			$str .= '<div class="pricing-head '.$opacity.'">';
			$str .= '<h3>'.strtoupper(valid_output($service_val["service_name"])).'</h3>';
			$str .= '<h4><i>$</i>'.$dollarVal.'<i>.'.$centVal.'</i></h4>';
			$str .= '</div>';
			$str .= '<div class="details-link">'.$service_val['service_info'].'</div>';
			$str .= '<div class="pricing-footer form-group">';
			$str .= '<div class="input-group date width_100" id="datetimepicker'.$k.'">';
			$str .= '<p class="'.$opacity.'">'.COMMON_INCLUDE_GST.'</p>';
			$str .= '<input type="hidden" class="form-control"  id="dtp_input'.$k.'"  />';
			$str .= '<span class="input-group-addon input-group-addon-go">';
			if($opacity)
			{
				$str .= '<button type="button" class="btn-u" id="show" name="selectDt" onclick="riseService(\''.$service_code.'\');showButton();javascript:return ChooseInterStateCollectionDate(\''.$k.'\',\''.strtolower(valid_output($service_val->service_name)).'\',\''.$courier_id.'\',\''.number_format($final_price,2,'.','').'\');">'.$button.'</button>';
			}else{
				if(isset($userid) && !empty($userid)){
					$str .= '<button id="addresses_'.$k.'" type="button" class="btn-u" onclick="riseService(\''.$service_code.'\');showButton();javascript:return ChooseInterService(\''.strtolower(valid_output($service_val->service_name)).'\',\''.$courier_id.'\',\''.number_format($final_price,2,'.','').'\')" >'.$btn_name.'</button>';
				}else{
					$str .= '<button id="addresses_'.$k.'" type="button" class="btn-u" onclick="javascript:return ChooseLogin(\''.$k.'\')" >'.$btn_name.'</button>';
				}

			}
			$str .= '</span>';
			$str .= '</div>';
			$str .= '</div>';

		$str .= '</div>';
	}
	$k++;
}
//
//exit();
echo $str;
exit();
?>
