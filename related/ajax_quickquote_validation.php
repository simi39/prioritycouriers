<?php
require_once("../lib/common.php");
require_once(DIR_WS_CURRENT_LANGUAGE . "index.php");
require_once(DIR_WS_MODEL . "ServicePageMaster.php");
$ObjServicePageMaster	= ServicePageMaster::Create();
$ServicePageData		= new ServicePageData();
$err = array();
$dimArr = $_POST['dimArr'];
$item_type = $_POST['item_type'];
$service_item_type = $_POST['service_item_type'];
$item_change = $_POST['item_change'];
$row_no = $_POST['row_num'];

if(isset($item_type) && $item_type != "")
{
	$err['item_type'] = isNumeric($item_type,COMMON_NUMERIC_VAL);
}
if(isset($service_item_type) && $service_item_type != "")
{
	$err['service_item_type'] = chkSmall($service_item_type);
}
if(isset($item_change) && $item_change !="")
{
	$err['item_change'] = chkSmall($item_change);
}
if(isset($row_no) && $row_no != "")
{
	$err['row_no'] = isNumeric($row_no,COMMON_NUMERIC_VAL);
}
if(isset($dimArr) && !empty($dimArr))
{
	foreach($dimArr as $k => $v) {
		if(isset($k) && $k!="")
		{
			$dimKey = explode("_",$k);
			if($dimKey[0] == 'weight')
			{
				$err["weight_".$dimKey[1]] = isFloat($dimArr["weight_".$dimKey[1]],COMMON_FLOAT_VAL);
			}else
			{
				$err[$k] = isNumeric($v,COMMON_NUMERIC_VAL);
			}
		
		}
	
	}
}

if(isset($err) && !empty($err))
{
	foreach($err as $key => $Value) {
		if($Value != '') {
			echo '#getValidError=>'.$key."==".$Value;
			$Svalidation=true;
		}
	}
}

$itemstr = '';
if(isset($item_change) && $item_change == true && $Svalidation == false)
{
	
	$fieldArr=array("*");
	$seaArr = array();
	$seaArr[]=array('Search_On'=>'service_page_name', 'Search_Value'=>$service_item_type, 'Type'=>'string', 'Equation'=>'=', 'CondType'=>'AND', 'Prefix'=>'', 'Postfix'=>'');	
	$seaArr[]=array('Search_On'=>'item_type', 'Search_Value'=>$item_type, 'Type'=>'string', 'Equation'=>'=', 'CondType'=>'AND', 'Prefix'=>'', 'Postfix'=>'');	
	$data = $ObjServicePageMaster->getServicePageName($fieldArr,$seaArr);
	
	if(!empty($data))
	{
		foreach ($data as $servicePageDetail)
		{
			if($servicePageDetail['qty_status']=='0')
			{
				if($service_item_type == 'international')
				{
					$itemstr.='#qty_item_'.$row_no.'=>inactive$';
				}else{
					$itemstr.='#Item_qty_'.$row_no.'=>inactive$';
				}
				
			}else{
				if($service_item_type == 'international')
				{
					$itemstr.='#qty_item_'.$row_no.'=>active$';
				}else{
					$itemstr.='#Item_qty_'.$row_no.'=>active$';
				}
			}
			if($servicePageDetail['weight_status']=='0')
			{
				if($service_item_type == 'international')
				{
					$itemstr.='#weight_item_'.$row_no.'=>inactive$';
				}else{
					$itemstr.='#Item_weight_'.$row_no.'=>inactive$';
				}
				
			}else{
				if($service_item_type == 'international')
				{
					$itemstr.='#weight_item_'.$row_no.'=>active$';
				}else{
					$itemstr.='#Item_weight_'.$row_no.'=>active$';
				}
			}
			if($servicePageDetail['dim_status']=='0')
			{
				if($service_item_type == 'international')
				{
					$itemstr.='#length_item_'.$row_no.'=>inactive$';
					$itemstr.='#width_item_'.$row_no.'=>inactive$';
					$itemstr.='#height_item_'.$row_no.'=>inactive$';
				}else{
					$itemstr.='#Item_length_'.$row_no.'=>inactive$';
					$itemstr.='#Item_width_'.$row_no.'=>inactive$';
					$itemstr.='#Item_height_'.$row_no.'=>inactive$';
				}
				
			}else
			{
				if($service_item_type == 'international')
				{
					$itemstr.='#length_item_'.$row_no.'=>active$';
					$itemstr.='#width_item_'.$row_no.'=>active$';
					$itemstr.='#height_item_'.$row_no.'=>active$';
				}else{
					$itemstr.='#Item_length_'.$row_no.'=>active$';
					$itemstr.='#Item_width_'.$row_no.'=>active$';
					$itemstr.='#Item_height_'.$row_no.'=>active$';
				}
			}
			
			
			
		}
	}else{
		if($service_item_type == 'international')
		{
			$itemstr = 'qty_item_'.$row_no.'=>active$#weight_item_'.$row_no.'=>active$#length_item_'.$row_no.'=>active$#width_item_'.$row_no.'=>active$#height_item_'.$row_no.'=>active$';
		}else{
			$itemstr = 'Item_qty_'.$row_no.'=>active$#Item_weight_'.$row_no.'=>active$#Item_length_'.$row_no.'=>active$#Item_width_'.$row_no.'=>active$#Item_height_'.$row_no.'=>active$';
		}
	}
echo $itemstr;
exit();
}

$errData = array();
if(isset($dimArr) && !empty($dimArr) && $Svalidation == false)
{
	
	foreach($dimArr as $k => $v) {
	
		if(isset($k) && $k!="")
		{
			$dimKey = explode("_",$k);
			if($service_item_type == 'international')
			{
				$item_type = $item_type;
			}else{
				$item_type = $item_type;
			}
			
			if($dimKey[0] == 'weight')
			{
				//echo $service_item_type."---item type".$item_type;
				$fieldArr=array("*");
				$seaArr = array();
				$seaArr[]=array('Search_On'=>'service_page_name', 'Search_Value'=>$service_item_type, 'Type'=>'string', 'Equation'=>'=', 'CondType'=>'AND', 'Prefix'=>'', 'Postfix'=>'');	
				$seaArr[]=array('Search_On'=>'item_type', 'Search_Value'=>$item_type, 'Type'=>'string', 'Equation'=>'=', 'CondType'=>'AND', 'Prefix'=>'', 'Postfix'=>'');	
				$data = $ObjServicePageMaster->getServicePageName($fieldArr,$seaArr);
				
				if(!empty($data))
				{
					
					foreach ($data as $servicePageDetail)
					{
						
						$weight = $dimArr["weight_".$dimKey[1]]; 
						$length = $dimArr["length_".$dimKey[1]]; 
						$width = $dimArr["width_".$dimKey[1]]; 
						$height = $dimArr["height_".$dimKey[1]]; 
						
						
						if(isset($weight) && $servicePageDetail['weight_min']!="" && $servicePageDetail['weight_max']!="")
						{
							//echo "weight:".$weight."weight min".$servicePageDetail['weight_min']."weight max".$servicePageDetail['weight_max']."</br>";
							if($servicePageDetail['weight_status']=='1' && (trim($weight)<$servicePageDetail['weight_min'] || trim($weight)>$servicePageDetail['weight_max']))
							{
								$weight_min = $servicePageDetail['weight_min'];
								$weight_max = $servicePageDetail['weight_max'];
								$weight_err = 'Weight limit:<br />'.$weight_min.' kg to '.$weight_max.' kg';
							}else{
								$weight_err = 'active';
							}
						}
						if(isset($length)  && $servicePageDetail['length_min']!="" && $servicePageDetail['length_max']!="")
						{
							if($servicePageDetail['dim_status']=='1' && (trim($length)<$servicePageDetail['length_min'] || trim($length)>$servicePageDetail['length_max']))
							{
								$length_min = $servicePageDetail['length_min'];
								$length_max = $servicePageDetail['length_max'];
								$length_err = 'Length limit:<br />'.$length_min.' cm to '.$length_max.' cm';
	  
							}else{
								$length_err ='active';
							}
						}
						if(isset($width)  && $servicePageDetail['width_min']!="" && $servicePageDetail['width_max']!="")
						{
							if($servicePageDetail['dim_status']=='1' && (trim($width)<$servicePageDetail['width_min'] || trim($width)>$servicePageDetail['width_max']))
							{
								$width_min = $servicePageDetail['width_min'];
								$width_max = $servicePageDetail['width_max'];
								$width_err = 'Width limit:<br />'.$width_min.' cm to '.$width_max.' cm';
	  
							}else{
								$width_err = 'active';
							}
						}
						if(isset($height)  && $servicePageDetail['height_min'] && $servicePageDetail['height_max'])
						{
							if($servicePageDetail['dim_status']=='1' && (trim($height)<$servicePageDetail['height_min'] || trim($height)>$servicePageDetail['height_max']))
							{
								$height_min = $servicePageDetail['height_min'];
								$height_max = $servicePageDetail['height_max'];
								$height_err = 'Height limit:<br />'.$height_min.' cm to '.$height_max.' cm';
	  
							}else{
								$height_err ='active';
							}
						}
						$row_data = array(
						'id' =>$dimKey[1],
						'weight' => $weight_err,
						'length' => $length_err,
						'width' => $width_err,
						'height' => $height_err,
						);
						
						array_push($errData, $row_data);
					}

				}
			}
		}
  }
  
}

echo json_encode($errData);
exit();

?>