<?php
require_once("../lib/common.php");
require_once(DIR_WS_MODEL ."BookingDetailsMaster.php");
require_once(DIR_WS_MODEL."tracking_evantMaster.php");
require_once(DIR_WS_MODEL ."CountryMaster.php");

$trackingEvantMasterObj=tracking_evantMaster::create();
$trackingEvantDataObj= new  tracking_evantData();

$BookingDetailsMasterObj = BookingDetailsMaster::create();
$BookingDetailsDataObj = new BookingDetailsData();


$CountryMasterObj = CountryMaster::create();
$CountryDataObj = new CountryData();

if(isset($_POST['referenceId']) && $_POST['referenceId']!="")
{
	$reference_number = $_POST['referenceId'];
	//$reference_number = '466000014535';
	
	/* To fetch pickup id and deliver id from database */
	$seaArr=array();
	$seaArr[]=array('Search_On'    => 'CCConnote',
	                     'Search_Value' => $reference_number,
	                     'Type'         => 'string',
	                     'Equation'     => '=',
	                     'CondType'     => 'and',
	                     'Prefix'       => '',
                     	 'Postfix'      => ''); 
	$BookingDetailsData = $BookingDetailsMasterObj->getBookingDetails('null',$seaArr);
	$BookingDetailsData=$BookingDetailsData[0];
	$pickupid = $BookingDetailsData['pickupid'];
	$deliverid = $BookingDetailsData['deliveryid'];
	$flag = $BookingDetailsData['flag'];
	//echo $pickupid."---".$deliverid;
	$seabycountryArr[0] = array('Search_On'    => 'countries_id',
		'Search_Value' => $deliverid,
		'Type'         => 'int',
		'Equation'     => '=',
		'CondType'     => 'and ',
		'Prefix'       => '',
		'Postfix'      => '');
	$fieldArrforCountryName = array("countries_name");
	$CountryDataObj = $CountryMasterObj->getCountry($fieldArrforCountryName,$seabycountryArr);
	$CountryDataObj = $CountryDataObj[0];
	$countries_name= $CountryDataObj['countries_name'];
	
	/* To fetch pickup id and deliver id from database */
	
	
	//$reference_number = '466000005144';
	$xmlString=("<?xml version='1.0' encoding='ISO-8859-1' ?><WSGET><AccessRequest><WSVersion>WS1.0</WSVersion><FileType>2</FileType><Action>download</Action><EntityID>PMG_001</EntityID><EntityPIN>p3gp455</EntityPIN><MessageID>0001</MessageID><AccessID>PRIORITY_ID</AccessID><AccessPIN>ngy8jo9</AccessPIN><CreatedDateTime>2014/10/04 12:00:00 AM</CreatedDateTime></AccessRequest><ReferenceNumber>".$reference_number."</ReferenceNumber></WSGET>");
	//echo $xmlString; //460000153211
	//exit();
	$data = array();
	$data['Username']='BC333B4EC0CA9DBB157A6F020D7B5953';
	$data['Password']='B8AFCCF7FF7BE570F38FAA3B302B1B57';
	$data['xmlStream']=$xmlString;
	$data['LevelConfirm']='detail';

	$post_str = '';
	foreach($data as $key=>$val) {
		$post_str .= $key.'='.$val.'&';
	}
	$post_str = substr($post_str, 0, -1);


	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, 'http://ws05.ffdx.net/ffdx_ws/v11/service_ffdx.asmx/WSDataTransfer');
	curl_setopt($ch, CURLOPT_POST, TRUE);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $post_str);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	$result = curl_exec($ch);
	curl_close($ch);

	$pxml = simplexml_load_string($result);
	$result = xml2array($pxml);
	
	/*
	echo "<pre>";
	print_R($result);
	echo "</pre>";
	*/
	
	$polygonArr = array();
	$locName = "";
	$replace = array(
			' ' => '+',
			'TBA' => 'Sydney'
			);
	$reverseReplace = array('+' => ' ');
	$countryReplace = array('01' => 'Au');
	$j=1;
	$rest = array();
	for($i=0;$i<count($result['WSGET']['Event']);$i++)
	{
		$EventDateTime[$i]=($result['WSGET']['Event'][$i]['EventDateTime']);
		$UpdateEntityLocationName[$i]=($result['WSGET']['Event'][$i]['UpdateEntityLocationName']);
		if($UpdateEntityLocationName[$i] == 'TBA')
		{
			$UpdateEntityCountry[$i] = str_replace_assoc($countryReplace,$result['WSGET']['Event'][$i]['UpdateEntityCountry']);
		}else{
			$UpdateEntityCountry[$i]=($result['WSGET']['Event'][$i]['UpdateEntityCountry']);
			
		}
		
		$UpdateEntityLocationName[$i] = str_replace_assoc($replace,$UpdateEntityLocationName[$i]); 
		
		$EventID[$i]= ($result['WSGET']['Event'][$i]['EventID']);
		$Remarks[$i]=($result['WSGET']['Event'][$i]['Remarks']);
		
		
		if(!empty($UpdateEntityLocationName[$i]) && $UpdateEntityLocationName[$i] != 'New+South+Wales+Other' && $locName != $UpdateEntityLocationName[$i]){
			
		    //echo $UpdateEntityLocationName[$i]."</br>";
			if(empty($UpdateEntityCountry[$i]))
			{
				$geocode_stats = file_get_contents("http://maps.googleapis.com/maps/api/geocode/json?address=$UpdateEntityLocationName[$i]&sensor=false");
			}else{
				
				$geocode_stats = file_get_contents("http://maps.googleapis.com/maps/api/geocode/json?address=$UpdateEntityLocationName[$i],+$UpdateEntityCountry[$i]&sensor=false");
			
			}
			//echo $geocode_stats."</br>";
			$output_deals = json_decode($geocode_stats);
			$latLng = $output_deals->results[0]->geometry->location;
			$lat = $latLng->lat;
			$lng = $latLng->lng;
			$UpdateEntityLocationName[$i] = str_replace_assoc($reverseReplace,$UpdateEntityLocationName[$i]); 
			
			$test['points'][$j] = array('latLng' => array($lat,$lng),'locName' => array($UpdateEntityLocationName[$i]));
			
			
			$j++;
		}
		$originalLocName = $result['WSGET']['Event'][$i]['UpdateEntityLocationName'];
		//$pos = array_search(',',$originalLocName);
		
		if(!empty($originalLocName))
		{
			$pos = strrpos($originalLocName,',');
			$UpdateEntityLocationName[$i]=($result['WSGET']['Event'][$i]['UpdateEntityLocationName']);
			if($pos !== false){
				$locArr = explode(",",$result['WSGET']['Event'][$i]['UpdateEntityLocationName']);
				$locReplaceName = $locArr[0];
			}else{
				$locReplaceName = $originalLocName;
			}
		}
		
		if(!empty($UpdateEntityCountry[$i]))
		{
			if($flag == 'international')
			{
				$locReplaceName = $locReplaceName."-".$UpdateEntityCountry[$i];
			}else{
				$locReplaceName = $locReplaceName;
			}
		}else{
			$locReplaceName = $originalLocName;
		}
		//echo $locReplaceName;
		
		$locName = $UpdateEntityLocationName[$i];
		$seaArr[0] = array('Search_On'    => 'eventid',
		'Search_Value' => $EventID[$i],
		'Type'         => 'int',
		'Equation'     => '=',
		'CondType'     => 'and',
		'Prefix'       => '',
		'Postfix'      => '');
		$EventIdDes=$trackingEvantMasterObj->gettracking_evant(null,$seaArr);
		$EventIdDes=$EventIdDes[0];
		if($UpdateEntityLocationName[$i]!='New+South+Wales+Other'){
		if($EventID[$i] == 1)
		{
			//$loctionName = $UpdateEntityLocationName[$i];
			$loctionName = $locReplaceName;
			if($deliverid)
			{
				$loctionName = $deliverid;
				if($countries_name && $flag =='international')
				{
					$loctionName = $countries_name;
				}else{
					
					$deliveredArr = explode(" ",$deliverid);
					$loctionName = $deliveredArr[0]." ".$deliveredArr[1];
				}	
				
			}
			$test['info'][$i] = array($EventIdDes->description,$EventDateTime[$i],'Delivered', end($Remarks),$loctionName,$UpdateEntityCountry[$i]);
		}elseif($EventID[$i] == 2)
		{
			//$loctionName = $UpdateEntityLocationName[$i];
			$loctionName = $locReplaceName;
			if($pickupid)
			{
				 $pickupArr = explode(" ",$pickupid);
				 $loctionName = $pickupArr[0]." ".$pickupArr[1];
			}
			$test['info'][$i] = array($EventIdDes->description,$EventDateTime[$i],'Collection', end($Remarks),$loctionName,$UpdateEntityCountry[$i]);
		}elseif($EventID[$i] == 90){
			//$test['info'][$i] = array($EventIdDes->description,$EventDateTime[$i],'In Progress', end($Remarks),$locReplaceName,$UpdateEntityCountry[$i]);
		}elseif($EventID[$i] == 91){
			/* booking arranged location name will be empty */
			$test['info'][$i] = array($EventIdDes->description,$EventDateTime[$i],'Booked', end($Remarks),'',$UpdateEntityCountry[$i]);
		}else{
			
			$test['info'][$i] = array($EventIdDes->description,$EventDateTime[$i],'In Transit', end($Remarks),$locReplaceName,$UpdateEntityCountry[$i]);
		}
		}
	}
	/*
	echo "<pre>";
	print_R($test);
	echo "</pre>";
	exit();
	*/
	
	
	//$res = array_merge($test, $array2);
	
	
	header("Content-Type: application/json");
	echo json_encode($test);
	exit();
}
?>