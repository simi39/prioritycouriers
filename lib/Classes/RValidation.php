<?php
class Validator 
{
	function Validate($FormId,$ButtonId,$Type,$ParamString,$Msg)
	{	
		switch($Type)
		{
			case 'Required':
				if ($ParamString['Value'] == 0)
				 {
					return false;
				 }
				 else 
				 {
				 	return trim($ParamString['Value']);
				 }
				//return is_null($ParamString['Value'])? false : trim($ParamString['Value']);
				break;
				
			case 'Range': 
				
				$Value = $ParamString['Value6'];
				if (!strlen($ParamString['Value6']))
				{
						return true;
				}	
				$MinValue  = $ParamString['MinValue'];
				$MaxValue  = $ParamString['MaxValue']; 
				$ValueType = $ParamString['ValueType'];
				$ValueType = strtolower($ValueType);
				if ($ValueType == 'integer')
				 {
				 	$Value = intval($Value);
					$Valid = true;
					if (strlen($MinValue))
				 	{
						$Valid = $Valid && ($Value >= intval($MinValue));
					}	
					if (strlen($MaxValue)) 
					{
						$Valid = $Valid && ($Value <= intval($MaxValue));
					}
					return $Valid;
					
				}
			else if ($ValueType == 'double' || $ValueType == 'float') {
			$Value = floatval($Value); 
			$Valid = true;
			if (strlen($MinValue)) {
				$Valid = $Valid && ($Value >= floatval($MinValue));
			}	
			if (strlen($MaxValue)) {
				$Valid = $Valid && ($Value <= floatval($MaxValue));
			}
			if(!strlen($MinValue) && !strlen($MaxValue) && !$Value) {
				$Valid = false;
			}
			return $Valid;
		}
		else if ($ValueType == 'currency') {
			$Valid = true;
			if (preg_match('/[-+]?([0-9]*\.)?[0-9]+([eE][-+]?[0-9]+)?/', $Value, $Matches)) {
				$Value = is_float($Matches[0]);
			}	
			else {
				$Value = 0;
			}	
			if (strlen($MinValue)) {
			
				if (preg_match('/[-+]?([0-9]*\.)?[0-9]+([eE][-+]?[0-9]+)?/', $MinValue, $Matches)) {
					$MinValue = is_float($Matches[0]);
				}	
				else {
					$MinValue = 0;
				}	
				$Valid = $Valid && ($Value >= $MinValue);
			}
			if (strlen($MaxValue)) {
			
				if (preg_match('/[-+]?([0-9]*\.)?[0-9]+([eE][-+]?[0-9]+)?/', $MaxValue, $Matches)) {
					$MaxValue = is_float($Matches[0]);
				}	
				else {
					$MaxValue = 0;
				}	
				$Valid = $Valid && ($Value <= $MinValue);
			}
			return $Valid;
		}
		else if ($ValueType == 'date') {  //Determine if the date is within the specified range.
			
			//Uses RxcParseDate and strtotime to get the date from string.	
		    $Valid = true;
			$DateFormat = $ParamString['DateFormat'];
			
			if (strlen($DateFormat)) {  
			  	$Value = $this->RxcParseDate($Value, $DateFormat);
			  	if (!$Value) {
			  		return false;
			  	}
				else {
					if (strlen($MinValue)) { 
					   $MinValue = $this->RxcParseDate($MinValue, $DateFormat);
					   $Valid = $Valid && ($Value >= $MinValue);   
					}
					if (strlen($MaxValue)) { 
						$MaxValue = $this->RxcParseDate($MaxValue, $DateFormat);
						$Valid = $Valid && ($Value <= $MaxValue);
					}
					return $Valid;
				}
			}
			else {     
				$Value = strtotime($Value);
				if (strlen($MinValue)) {
					$Valid = $Valid && ($Value >= strtotime($MinValue));
				}	
				if (strlen($MaxValue)) {
					$Valid = $Valid && ($Value <= strtotime($MaxValue));
				}	
				return $Valid;
			} 
		}
		else {   //Compare the string with a minimum and a maxiumum value. Uses strcmp for comparision.
			$Valid = true;
			if (strlen($MinValue)) {			
				$Valid = $Valid && (strlen($Value) >= $MinValue);
			}	
			if (strlen($MaxValue)) {
				$Valid = $Valid && (strlen($Value) <= $MaxValue);
			}	
			return $Valid;
		}
			break;
			
		case 'Compare':
			
			$Value = $ParamString['Value1'];
			
			if (!strlen($ParamString['Value1']))
			{
				return true;
			}	
			
			$ValueType = $ParamString['ValueType'];
			$ValueType = strtolower($ValueType);
			$Operator  = $ParamString['Operator'];

		// get compare value
		//$ControlToCompare = $this->GetControlToCompare();
			$ControlToCompare = $ParamString['Value2'];
			
			
			if (strlen($ControlToCompare)) 
			{
				$Control2 = $ControlToCompare;
				$Value2  = $ParamString['Value2'];
			//$Value2   = $Control2->GetValidationPropertyValue();
				if (is_null($Control2))
				{
					return false;
				}	
			}
			else
			{
				$Control2 = $ParamString['Value2'];
			}	
		
		if ($ValueType == 'integer') {
			$Value  = intval($Value);
			$Value2 = intval($Value2);
		}
		else if($ValueType == 'double' || $ValueType == 'float') {
 		
			$Value  = floatval($Value);
			$Value2 = floatval($Value2);
		}
		else if($ValueType == 'currency')
		{
			if (preg_match('/[-+]?([0-9]*\.)?[0-9]+([eE][-+]?[0-9]+)?/', $Value, $Matches)) {
				$Value = floatval($Matches[0]);
			}	
			else {
				$Value = 0;
			}	
			if (preg_match('/[-+]?([0-9]*\.)?[0-9]+([eE][-+]?[0-9]+)?/', $Value2, $Matches)) {
				$Value2 = floatval($Matches[0]);
			}	
			else {
				$Value2 = 0;
			}	
				
		}
		else if($ValueType == 'date')
		{  
			$DateFormat = $ParamString['DateFormat'];
			if (strlen($DateFormat)) { 
				$Value = $this->RxcParseDate($Value, $DateFormat);
				$Value2 = $this->RxcParseDate($Value2, $DateFormat);
			}
			else  {
				$Value  = strtotime($Value);
				$Value2 = strtotime($Value2);
			}
			return $Value;
		}
		if(!empty($Value) && isset($Value) && !empty($Value2) && isset($Value2)) {
			if ($Operator == 'equal') { 
				return $Value == $Value2;
			}	
			else if ($Operator == 'notequal') {
				return $Value != $Value2;
			}	
			else if ($Operator == 'greaterthan') {
				return  $Value > $Value2;
			}	
			else if ($Operator == 'greaterthanequal') {
				return $Value >= $Value2;
			}	
			else if ($Operator == 'lessthan') {
				return $Value < $Value2;
				
			}	
			else if ($Operator == 'lessthanequal') {
				return $Value <= $Value2;
			}	
			else {
				return false;
			}
		}
		
		break;
		
		case 'RegularExpression':
			$Expression = $ParamString['RegularExpression'];
			if(strlen($Expression))
			{
		   		$Value   = $ParamString['Value3'];
				return strlen($Value) ? preg_match("/^$Expression/", $Value) : true;
			}
			else 
			{
				return true;
			}	
			
			break;
			
		}
		
	}

public function RxcParseDate($string, $format)
    { 	 
		
		if(isset($format))
		{
			$format = strtolower($format);
		}
		else
		{
			return false;
		}

		$reg_string = $this->isDate($format);
		$reg_string = str_replace("/","\/",$reg_string);
		if( !preg_match( "/".$reg_string."/", $string, $arDate ))
		{
			return false;
		}
		
		if($format=="dd/mm/yyyy")
		{
			$d = $arDate[1];
			$m = $arDate[2];
			$y = $arDate[3];
		}
		else if($format=="mm/dd/yyyy") 
		{
			 $d = $arDate[2];
			 $m = $arDate[1];
			 $y = $arDate[3];
		}
		else if($format=="mm-dd-yyyy")
		{
			$d = $arDate[2];
			$m = $arDate[1];
			$y = $arDate[3];
		}
		else
		{
			return false;
		}
		if($m && $d && $y)
		{	return mktime(0, 0, 0, $m, $d, $y);	}
		else
		{	return false;	}
   	} 	
	
	public function isDate($format)
	{
		switch (strtolower($format))
		{
			case "dd/mm/yyyy":
				return "(\d{1,2})/(\d{1,2})/(\d{4})";
			case "mm/dd/yyyy":
				return "(\d{1,2})/(\d{1,2})/(\d{4})";
			case "mm-dd-yyyy":
				return "(\d{1,2})-(\d{1,2})-(\d{4})";	
		}
		return false;
	}
		
}
?>