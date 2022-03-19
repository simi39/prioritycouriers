<?php
require_once("../lib/common.php");
require_once(DIR_WS_MODEL."InternationalStateMaster.php");
$data['City']=valid_input($_POST['receiver_suburb']);
$data['StateCode']=valid_input($_POST['receiver_state_code']);
$data['PostalCode']=valid_input($_POST['receiver_postcode']); 
//$data['City']='newyork';
//$data['StateCode']='Holtsville';
//$data['PostalCode']='1784';
$ObjInternationalStateMaster	= InternationalStateMaster::Create();
$InternationalStateData		= new InternationalStateData();

$addressList = array();
/*echo "<pre>";
print_r($data);
echo "</pre>";*/
if(count($data)>0){
 $fields = http_build_query($data, '', '&');//die();
 //echo $fields;
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "http://ws05.ffdx.net/UPS_WS/validate_address.asmx/ValidateAddress"); 
	curl_setopt($ch, CURLOPT_POST, TRUE);
	
	curl_setopt($ch, CURLOPT_POSTFIELDS, $fields); 
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE); 
	$result= curl_exec($ch);//var_dump($result);die();
	
	$oldValue = libxml_disable_entity_loader( true );
	$dom = simplexml_load_string($result);
	/*echo "<pre>";
	print_r($dom);
	echo "</pre>";
	exit();*/
	
	
	libxml_disable_entity_loader($oldValue);
	
	//echo count($dom->AddressValidationResult);
	//echo "<pre>";
	///print_r($dom);
	//echo "</pre>";
	//echo in_array($data['PostalCode'], range($dom->AddressValidationResult->PostalCodeLowEnd, $dom->AddressValidationResult->PostalCodeHighEnd));
	//exit();
	if($dom->Response->ResponseStatusCode=='0'){
		$error = $dom->Response->Error->ErrorDescription[0];
		$str = '<table class="table table-striped table-hover dt-responsive" cellspacing="0" width="100%" id="example">';
		$str .= '<thead>';
		$str .='<th class="controlpanel_middle_th" colspan="3"></th>';
		$str .='</thead><tbody>';
		$str.='<tr><td colspan="3">'.$error.'</td></tr>';
		$str .='</tbody></table>';
		echo json_encode($str);
		exit();
	}else{
		if(count($dom->AddressValidationResult) == 1 && $dom->AddressValidationResult->Address->StateProvinceCode == $data['StateCode'] && $dom->AddressValidationResult->Address->City == strtoupper($data['City']) && (in_array($data['PostalCode'], range($dom->AddressValidationResult->PostalCodeLowEnd, $dom->AddressValidationResult->PostalCodeHighEnd))))
		{
			$error = 1;
			
		}else{
			
			$str = '<table class="table table-striped table-hover dt-responsive" cellspacing="0" width="100%" id="example">';
			$str .= '<thead>';
			if(empty($dom->children()))
			{
				$str .='<th class="controlpanel_middle_th">State</th>';
				//$str .='<th class="controlpanel_middle_th">Quality</th>';
				$str .='<th class="controlpanel_middle_th">City</th>';
				$str .='<th class="controlpanel_middle_th">Postcode</th>';
			}else{
				$str .='<th class="controlpanel_middle_th" colspan="3"></th>';
			}
			$str .='</thead><tbody>';
			$interstate ='';
			
			$stateCode ='';
			foreach($dom->children() as $child)
			{
				$seaStateArr = array();
				$optArr   = array();
				$fieldArr = array();
				$addressList[] = $child->Address->StateProvinceCode."\n";
				$stateCode = $child->Address->StateProvinceCode."\n";
				
				if($child->Address->StateProvinceCode!=''){
					$stateCode = trim($child->Address->StateProvinceCode."\n");
					
				}
				$addressListCity[] = $child->Address->City."\n";
				if($child->Address->StateProvinceCode!=''){
					$seaStateArr[]=array('Search_On'=>'state_code', 'Search_Value'=>"$stateCode", 'Type'=>'string', 'Equation'=>'=', 'CondType'=>'', 'Prefix'=>'', 'Postfix'=>'');
					
					$optArr[]=array('Order_By' => 'state','Order_Type' => 'asc');
					$fieldArr = array("state","state_code");
					
					$InternationalStateData = $ObjInternationalStateMaster->getInternationalState($fieldArr,$seaStateArr,$optArr,0,10);
					//$InternationalStateData =$InternationalStateData[0];
					foreach($InternationalStateData as $stateVal){ 
						$interstate = $stateVal['state'];
					}
					
					//echo $interstate."</br>";
				}
				/*
				if($child->Address->StateProvinceCode == $data['StateCode'] && ($child->Address->City) == strtoupper($data['City']){
					foreach (range($child->PostalCodeLowEnd,$child->PostalCodeHighEnd) as $postcode){
						$data['City']
					}
				}*/
				if($child->Address->StateProvinceCode == $data['StateCode'] && ($child->Address->City) == strtoupper($data['City']))
				{
					foreach (range($child->PostalCodeLowEnd,$child->PostalCodeHighEnd) as $postcode){
					if(strlen($postcode)<5)
					{
						if(strlen($postcode) == 3)
						{
							$postcode = '00'.$postcode;
						}else{
							$postcode = '0'.$postcode;
						}
					}else{
						$postcode = $postcode;
					} 
					//echo $postcode."</br>";
					$str .='<tr><td><a href="#" onclick="javascript:return addresstestClick(\''.$interstate.'\',\''.$child->Address->StateProvinceCode.'\',\''.$postcode.'\',\''.ucwords(strtolower($child->Address->City)).'\')">'.$interstate.'</a></td><td>'.ucwords(strtolower($child->Address->City)).'</td><td>'.$postcode.'</td></tr>';
					}
					$flag = 'true';
				}
				if($flag != 'true')
				{
					
					if(($child->Address->City) == strtoupper($data['City']))
					{
						foreach (range($child->PostalCodeLowEnd,$child->PostalCodeHighEnd) as $postcode){
						if(strlen($postcode)<5)
						{
							$postcode = '0'.$postcode;
						}else{
							$postcode = $postcode;
						}
						//echo $postcode."</br>";
						$str .='<tr><td><a href="#" onclick="javascript:return addresstestClick(\''.$interstate.'\',\''.$child->Address->StateProvinceCode.'\',\''.$postcode.'\',\''.ucwords(strtolower($child->Address->City)).'\')">'.$interstate.'</a></td><td>'.ucwords(strtolower($child->Address->City)).'</td><td>'.$postcode.'</td></tr>';
						}
						$cityexit = true;
					}
					
				}
				
			}
			if($flag != 'true' && $cityexit != true){
					$str.='<tr><td id="error_US_clean" colspan="3">'.ERROR_USA_LOCATION.'</td></tr>';
				}
			$str .='</tbody></table>';
			$error = $str;
			
		}
	}
}

echo json_encode($error);
exit();
?>