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
	//$reference_number = '466000024556';
	
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
	$webservice = $BookingDetailsData['webservice'];
	$address_1 = $BookingDetailsData['reciever_address_1'];
	$address_2 = $BookingDetailsData['reciever_address_2'];
	$address_3 = $BookingDetailsData['reciever_address_3'];
	//echo $pickupid."---".$deliverid;
	$seabycountryArr[0] = array('Search_On'    => 'countries_id',
		'Search_Value' => $deliverid,
		'Type'         => 'int',
		'Equation'     => '=',
		'CondType'     => 'and ',
		'Prefix'       => '',
		'Postfix'      => '');
	$fieldArrforCountryName = array("countries_name","countries_iso_code_2");
	$CountryDataObj = $CountryMasterObj->getCountry($fieldArrforCountryName,$seabycountryArr);
	$CountryDataObj = $CountryDataObj[0];
	$countries_name= $CountryDataObj['countries_name'];
	$country_code = $CountryDataObj['countries_iso_code_2'];
	if($flag == 'international')
	{
		$interLocationName = $BookingDetailsData['reciever_suburb'].", ".$country_code;
	}
	/* To fetch pickup id and deliver id from database */
	
	
	//$reference_number = '466000021012';
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
	
	exit(); */
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
	$old_event_id = '';
	$pre_country = '';
	$pre_loc = '';
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
		
		
		$originalLocName = $result['WSGET']['Event'][$i]['UpdateEntityLocationName'];
		//$pos = array_search(',',$originalLocName);
		
		if(!empty($originalLocName))
		{
			$pos = strrpos($originalLocName,',');
			$UpdateEntityLocationName[$i]=($result['WSGET']['Event'][$i]['UpdateEntityLocationName']);
			if($pos !== false){
				//echo $result['WSGET']['Event'][$i]['UpdateEntityLocationName']."</br>";
				$locArr = explode(",",$result['WSGET']['Event'][$i]['UpdateEntityLocationName']);				
				$geoLocReplaceName = $locArr[0];
				if($flag == 'international')
				{
					$locReplaceName = $geoLocReplaceName;
				}else{
					$locReplaceName = $result['WSGET']['Event'][$i]['UpdateEntityLocationName'];
				}
				
			}else{
				$locReplaceName = $originalLocName;
			}
		}
		$locName = $UpdateEntityLocationName[$i];
		if(!empty($UpdateEntityCountry[$i]))
		{
			if($flag == 'international')
			{
				$locReplaceName = $locReplaceName.", ".$UpdateEntityCountry[$i];
			}else{
				$locReplaceName = $locReplaceName;
			}
		}else{
			$locReplaceName = $originalLocName;
		}
		//echo $locReplaceName."</br>";
		
			
		$seaArr[0] = array('Search_On'    => 'eventid',
		'Search_Value' => $EventID[$i],
		'Type'         => 'int',
		'Equation'     => '=',
		'CondType'     => 'and',
		'Prefix'       => '',
		'Postfix'      => '');
		$EventIdDes=$trackingEvantMasterObj->gettracking_evant(null,$seaArr);
		$EventIdDes=$EventIdDes[0];
		$pos = strpos($EventDateTime[$i], '06:00:00 PM');
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
					$loctionName = $interLocationName;
				}else{
					
					$deliveredArr = explode(" ",$deliverid);
					if(count($deliveredArr)==2)
					 {
						 $loctionName = $deliveredArr[0];
					 }elseif(count($deliveredArr)==3)
					 {
						 $loctionName = $deliveredArr[0].", ".$deliveredArr[1];
					 }elseif(count($deliveredArr)==4)
					 {
						 $loctionName = $deliveredArr[0]." ".$deliveredArr[1].", ".$deliveredArr[2];
					 }else{
						$loctionName = $deliveredArr[0];
					 }
					
				}	
				
			}
				if($flag == 'australia')
				{
					if($webservice == 'Messenger Post')
					{
						$loctionName  = $address_1.' '.$address_2.' '.$address_3.','.$loctionName;
					}else{
						$loctionName  = $loctionName.',Australia';
					}
				}
				$test['info'][$i] = array("desc"=>$EventIdDes->description,"time"=>date('d-m-Y H:i',strtotime($EventDateTime[$i])),"st"=>'Delivered', "rm"=>end($Remarks),"loc"=>$loctionName,"cnt"=>$UpdateEntityCountry[$i],'id'=>$j);
				$geo_loc = str_replace(" ","+",$geoLocReplaceName);
				if(empty($geoLocReplaceName))
				{
					$geo_loc = str_replace(" ","+",$loctionName);
				}else{
					$geo_loc = str_replace(" ","+",$geoLocReplaceName);
				}
				////echo $geo_loc;
				//exit();
				if($flag == 'australia')
				{
					
					$geo_loc  = $geo_loc.',Australia';
					
				}
				if(empty($UpdateEntityCountry[$i]))
				{
					
					$geocode_stats = file_get_contents("http://maps.googleapis.com/maps/api/geocode/json?address=$geo_loc&sensor=false");
				}else{
					
					
					$geocode_stats = file_get_contents("http://maps.googleapis.com/maps/api/geocode/json?address=$geo_loc,+$UpdateEntityCountry[$i]&sensor=false");
				
				}
				//echo $geocode_stats."</br>";
				$output_deals = json_decode($geocode_stats);
				$latLng = $output_deals->results[0]->geometry->location;
				$lat = $latLng->lat;
				$lng = $latLng->lng;
				if($webservice == 'Messenger Post')
				{
					$zoom = 14;
					$service = '1';
				}
				$test['points'][$j] = array('latLng' => array($lat,$lng,$zoom,$service),'locName' => array($loctionName));
				
			
			
		}elseif($EventID[$i] == 2)
		{
			//$loctionName = $UpdateEntityLocationName[$i];
			$loctionName = $locReplaceName;
			if($pickupid)
			{
				 $pickupArr = explode(" ",$pickupid);
				
				 if(count($pickupArr)==2)
				 {
					 $loctionName = $pickupArr[0];
				 }elseif(count($pickupArr)==3)
				 {
					 $loctionName = $pickupArr[0].", ".$pickupArr[1];
				 }elseif(count($pickupArr)==4)
				 {
					 $loctionName = $pickupArr[0]." ".$pickupArr[1].",  ".$pickupArr[2];
				 }else{
					$loctionName = $pickupArr[0];
				 }
			}
			
			$test['info'][$i] = array("desc"=>$EventIdDes->description,"time"=>date('d-m-Y H:i',strtotime($EventDateTime[$i])),"st"=>'Collection', "rm"=>end($Remarks),"loc"=>$loctionName,"cnt"=>$UpdateEntityCountry[$i],'id'=>$j);
			//$test['info'][$i] = array("desc"=>$EventIdDes->description,"time"=>$EventDateTime[$i],"st"=>'Delivered', "rm"=>end($Remarks),"loc"=>$loctionName,"cnt"=>$UpdateEntityCountry[$i]);
			//echo "geo loct:".$geoLocReplaceName;
			//echo "loct name:".$loctionName;
			if(empty($geoLocReplaceName))
			{
				$geo_loc = str_replace(" ","+",$loctionName);
			}else{
				$geo_loc = str_replace(" ","+",$geoLocReplaceName);
			}
			
			
			if($flag == 'australia')
			{
				$geo_loc  = $geo_loc.',Australia';
			}
			if(empty($UpdateEntityCountry[$i]))
			{
				
				$geocode_stats = file_get_contents("http://maps.googleapis.com/maps/api/geocode/json?address=$geo_loc&sensor=false");
			}else{
				
				$geocode_stats = file_get_contents("http://maps.googleapis.com/maps/api/geocode/json?address=$geo_loc,+$UpdateEntityCountry[$i]&sensor=false");
			
			}
			//echo $geocode_stats."</br>";
			$output_deals = json_decode($geocode_stats);
			$latLng = $output_deals->results[0]->geometry->location;
			$lat = $latLng->lat;
			$lng = $latLng->lng;
			if($webservice != 'Messenger Post')
			{
				$zoom = 1;
				$service = '2';
			}
			$test['points'][$j] = array('latLng' => array($lat,$lng,$zoom,$service),'locName' => array($loctionName));
			
			
		}elseif($EventID[$i] == 3 && $UpdateEntityLocationName[$i] == 'Sydney' && $pos!=''){
			
		}elseif($EventID[$i] == 90){
			//$test['info'][$i] = array($EventIdDes->description,$EventDateTime[$i],'In Progress', end($Remarks),$locReplaceName,$UpdateEntityCountry[$i]);
		}elseif($EventID[$i] == 91){
			/* booking arranged location name will be empty */
			//$old_loc = '';
			$test['info'][$i] = array("desc"=>$EventIdDes->description,"time"=>date('d-m-Y H:i',strtotime($EventDateTime[$i])),"st"=>'Booked', "rm"=>end($Remarks),"loc"=>'',"cnt"=>$UpdateEntityCountry[$i],'id'=>$j);
			
		}else{
			
			if(empty($UpdateEntityCountry[$i]) && empty($locReplaceName))
			{
				/* this condition is when last row above delivered place is empty with location and country name */
				$UpdateEntityCountry[$i] = $pre_country;
				$locReplaceName = $pre_loc;
							
			}
			if($pre_loc == $locReplaceName)
			{
				$j = $oldcnt;
				$infoLocReplaceName = '';
			}else{
				$infoLocReplaceName = $locReplaceName;
			}
			$test['info'][$i] = array("desc"=>$EventIdDes->description,"time"=>date('d-m-Y H:i',strtotime($EventDateTime[$i])),"st"=>'In Transit', "rm"=>end($Remarks),"loc"=>$infoLocReplaceName,"cnt"=>$UpdateEntityCountry[$i],'id'=>$j);
			$geo_loc = str_replace(" ","+",$geoLocReplaceName);
			if(empty($geoLocReplaceName))
			{
				$geo_loc = str_replace(" ","+",$locReplaceName);
			}else{
				$geo_loc = str_replace(" ","+",$geoLocReplaceName);
			}
			if($flag == 'australia')
			{
				$geo_loc  = $geoLocReplaceName.',Australia';
				
			}
			//echo $flag."</br>";
			//exit();
			//echo $lat."--".$lng."---".$locReplaceName."</br>";
			//echo $infoLocReplaceName."</br>";
			if(empty($UpdateEntityCountry[$i]))
			{
				
				$geocode_stats = file_get_contents("http://maps.googleapis.com/maps/api/geocode/json?address=$geo_loc&sensor=false");
			}else{
				
				//echo $geocode_stats = "http://maps.googleapis.com/maps/api/geocode/json?address=$geo_loc,+$UpdateEntityCountry[$i]&sensor=false";
				 $geocode_stats = file_get_contents("http://maps.googleapis.com/maps/api/geocode/json?address=$geo_loc,+$UpdateEntityCountry[$i]&sensor=false");
			
			}
			// $geocode_stats."</br>";
			$output_deals = json_decode($geocode_stats);
			$latLng = $output_deals->results[0]->geometry->location;
			
			$lat = $latLng->lat;
			$lng = $latLng->lng;
			//$geoLoc = $locReplaceName;
			if($webservice != 'Messenger Post')
			{
				$zoom = 1;
				$service = '2';
			}
			$test['points'][$j] = array('latLng' => array($lat,$lng,$zoom,$service),'locName' => array($locReplaceName));

			
		}
		}
		//exit();
		//$locName = $old_loc;
		//echo $old_event_id."--".$locName."</br>";
		$pre_country = $UpdateEntityCountry[$i];
		$pre_loc = $locReplaceName;
		$oldcnt = $j;
		$j++;
		
		//echo date_format($EventDateTime[$i], 'd/m/Y H:i:s');
	}
	
	//exit();
	//array_splice($test['points'],1,1,array('Item2a','Item2b'));
	if(!empty($test['points']))
	{
		$new_test['points'] = array_values($test['points']);
	}
	if(!empty($test['info']))
	{
		$info_points['info'] = array_values(array_reverse($test['info']));
	}
	
	$m=1;
	$oldPlace = '';
	
	for($k=0;$k<=sizeof($new_test['points'])-1;$k++)
	{
		
		if(!empty($new_test['points'][$k]['locName'][0]) && $oldPlace!=$new_test['points'][$k]['locName'][0])
		{
			$repl_points['points'][$m] = $new_test['points'][$k];
			//echo $new_test['points'][$k]['locName'][0];
			$m++;
		}
		$oldPlace = $new_test['points'][$k]['locName'][0];
			
	}
	$s=1;
	/*
	echo "<pre>";
	print_r($repl_points);
	echo "</pre>";
	exit(); */
	//echo "total info points:".sizeof($info_points['info']);
	for($t=0;$t<=sizeof($info_points['info'])-1;$t++)
	{
		$replaceInfo['info'][$s] = $info_points['info'][$t];
		$s++;
	}
	
	 
	$total_info['total_info'] = $s-1;
	
	
	if(!empty($replaceInfo) && !empty($repl_points) && !empty($total_info))
	{
		$res = array_merge($replaceInfo, $repl_points,$total_info);
	}
	
	header("Content-Type: application/json");
	echo json_encode($res);
	exit();
}
?>