<?php
session_start();
ob_start();
require_once("../lib/common.php");

require_once(DIR_WS_CURRENT_LANGUAGE . "metro.php");
require_once(DIR_WS_MODEL . "ServiceMaster.php");
require_once(DIR_WS_MODEL."PostCodeMaster.php");

$ObjServiceMaster = new ServiceMaster();
$ObjServiceMaster	= $ObjServiceMaster->Create();
$ServiceData		= new ServiceData();

$PostCodeMasterObj = new PostCodeMaster();
$PostCodeMasterObj = $PostCodeMasterObj->create();
$PostCodeDataObj = new PostCodeData();
$BookingDetailsDataObjArray = $__Session->GetValue("booking_details");
//echo "inside metro available service page";
//exit();

$bk_type_hidden = $_POST["booking_type_hidden"];
$total_amt = $_POST['total_amt'];
$ServiceDetailsData = $__Session->GetValue("service_details");
$selectedDate = date('d-m-Y',strtotime($_POST['selectedDate']));
$collectionTime = $_POST['collectionTime'];
$defaultDate = date('d-m-Y',strtotime($_POST['defaultDate']));
$serviceName = $_POST['serviceName'];
/*echo "<pre>";
print_r($_POST);
echo "</pre>";*/
//exit();*/
//echo $serviceName;
//exit();

//echo strtotime($defaultDate)."----".strtotime($selectedDate)."</br>";
/*if(isset($defaultDate) && !empty($defaultDate) && isset($selectedDate) && !empty($selectedDate) && strtotime($defaultDate) == strtotime($selectedDate)){
	$formateddate = date('d-m-Y h:i a',strtotime($_POST['defaultDate']));

	$formatedateArr    = explode(" ",$formateddate);

	$time_hr    = $formatedateArr[1];

	$hr_formate = strtolower($formatedateArr[2]);
	$hrtiming = $time_hr." ".$hr_formate;

	$usertiming = date('h:i a',strtotime($hrtiming));

}else{*/
	$usertiming = date('h:i a',strtotime($collectionTime));
	//$usertiming = "12:00 am";
//}

//echo "usertime:".$usertiming."</br>";
//exit();

$BookingDetailsDataObjArray = $__Session->GetValue("booking_details");
$BookingDetailsDataObjArray["start_date"] = $selectedDate;
$BookingDetailsDataObjArray["date_ready"] = $start_date;
$BookingDetailsDataObjArray["time_ready"] = $collectionTime;
/*$BookingDetailsDataObjArray["time_hr"] = $time_hr;
$BookingDetailsDataObjArray["time_sec"] = $time_sec;
$BookingDetailsDataObjArray["hr_formate"] = $hr_formate;
*/
$__Session->SetValue("booking_details",$BookingDetailsDataObjArray);
$__Session->Store();


$session_data = json_decode($_SESSION['Thesessiondata']['_sess_login_userdetails'],true);
$userid       = $session_data['user_id'];
/*
30 Sep 2014 04:45 PM
*/
$str="";
$k =1;
if(isset($ServiceDetailsData) && !empty($ServiceDetailsData)){


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
 $jsdbtiming = date('h:i A',strtotime($dbtiming));
 $courier_id = $service_val['supplier_id'];
 //echo "service name:".$service_name." select time:".$selectedTime." service cutoff timing:".$dbtiming."</br>";
// echo "usertiming:".$usertiming."dbtiming:".$dbtiming."</br>";
//exit();
	if(isset($final_price)){
		$opacity ="bg_opacity";
		$button = SELECT_SERVICE;
		if((conv($usertiming)!=00) && (conv($usertiming)<=conv($dbtiming)))
		{
			$opacity ="";
			$button = SELECT_SERVICE;
		}
		$priceArr = explode(".",number_format($final_price,2,'.',''));
		$dollarVal = $priceArr[0];
		$centVal = $priceArr[1];
		if(isset($service_code) && $service_code != 'EC'){
			$addclass= '';
			$btn_name = SELECT_SERVICE;
			if(isset($serviceName) && $serviceName == strtolower($service_name)){
				$addclass= 'top-price';
				$btn_name = "SELECTED";
				//echo "add class:".$addclass."</br>";
			}
			//echo $serviceName."---".strtolower($service_name)."</br>";
			//exit();
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
				$str .= '<button type="button" id="addresses_'.$k.'" class="btn-u" id="show" name="selectDt" onclick="riseService(\''.$service_code.'\');showButton();javascript:return ChooseCollectionDate(\''.$k.'\',\''.strtolower(valid_output($service_val->service_name)).'\',\''.$courier_id.'\',\''.number_format($final_price,2,'.','').'\',\''.$jsdbtiming.'\');">'.$button.'</button>';
			}else{
				if(isset($userid) && !empty($userid)){
					//$str .= '<button type="button" class="btn-u" id="show" onclick="javascript:return ChooseCollectionTime('.$k.');">'.COMMON_SELECT_TIME.'</button>';
					//ChooseOrder(\''.strtolower(valid_output($service_val->service_name)).'\',\''.$courier_id.'\',\''.number_format($final_price,2,'.','').'\')
					$str .= '<button id="addresses_'.$k.'" type="button" name="bookNow" class="btn-u" onclick="riseService(\''.$service_code.'\');showButton();javascript:return ChooseService(\''.$k.'\',\''.strtolower(valid_output($service_val->service_name)).'\',\''.$courier_id.'\',\''.number_format($final_price,2,'.','').'\',\''.$jsdbtiming.'\');" >'.$btn_name.'</button>';
				}else{
					$str .= '<button id="addresses_'.$k.'" type="button" class="btn-u" onclick="javascript:return ChooseLogin(\''.$k.'\')" >'.$btn_name.'</button>';
				}

			}
			$str .= '</span>';
			$str .= '</div>';
			$str .= '</div>';

		$str .= '</div>';
		}
	}
	$k++;
}
}
//
//exit();
echo $str;
exit();
?>
