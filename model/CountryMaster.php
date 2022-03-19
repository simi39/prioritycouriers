<?php
/**
 * This is CountryMaster file.
 * This file contains all the business logic code related to countries table.
 * 
 * TABLE_NAME:    countries
 * PRIMARY_KEY :  countries_id
 * TABLE_COLUMNS: "countries_name","countries_iso_code_2","countries_iso_code_3","address_format_id"
 * 
 * @uses By creating object of CountryMaster we can handle or manage different table operation like insert, update, delete and selecting data with criteria from table.
 * 
 * @package    Country Management
 * @author     Radixweb
 * @copyright  Document Copyright information, e.g. Copyright (c) 2008, Radixweb
 * @license    Display a hyperlink to a URL for a license, e.g. http://opensource.org/licenses/gpl-license.php GNU Public License
 * @version    $Id: CountryMaster.php,v 1.0
 * @link       Display a hyperlink to a URL in the documentation, e.g. http://radixweb.com
 * @since      Document when (at which version) an element was first added to a package e.g. Version 1.0
 * 
 */

/**
 * @see CountryData.php for Data class
 */
require_once(DIR_WS_MODEL . "CountryData.php");

/**
 * @see RMasterModel.php for extended RMasterModel class
 */
require_once(DIR_LIB_CLASSES_MODELS."/RMasterModel.php");

class CountryMaster extends RMasterModel {
	/**
	 * Create a null object of CountryMaster
	 *
	 * @return object object $CountryMasterObj
	 */
	public function create()
	{
		$CountryMasterObj = new CountryMaster();
		return  $CountryMasterObj;
	}//create Function End

	/**
	 * To insert record in countries table
	 * Insert data of columns : "countries_name","countries_iso_code_2","countries_iso_code_3","address_format_id"
	 *
	 * @param arrayCountryData $CountryData
	 * @param bool $ThrowError Whether to throw error or not
	 * 
	 * @return int If any error, then Throw Exception otherwise inserted row id
	 */
	public function addCountry($CountryData, $ThrowError=true)
	{
		//build up insert query
	 	$FinalData = $CountryData->InternalSync(RDataModel::INSERT, "countries_name","countries_iso_code_2","area_code","address_format_id","zone","days","status","state_validation");
	 $Query = "INSERT INTO countries $FinalData";
//echo	$Query = "INSERT INTO countries $FinalData";exit();
		//echo $Query;
		//exit();
	 	/**
		  * check that data should be inserted successfully.
		  * if no then throw or return proper error message.
		  */
	 	$ThrowException = null;
 		try {
			$Rs=$this->Connection->Execute($Query);
			if ($Rs->AffectedRows() ==  0) {
				throw new Exception(' Fail To Add New countries Record');
			}
		} catch(Exception $Exception) {
			if($ThrowError == true) {
				$ThrowException = new Exception(' Fail To Add countries Record ');
			} else {
				return false;
			}//if-else end
		}// try -catch end

		if ($ThrowException) {
			throw $ThrowException;
		} else {
			return $this->Connection->LastInsertedId();
		}
	}//addCountry Function End

	/**
	 * To update record of countries table
	 * Update data of columns : "countries_name","countries_iso_code_2","countries_iso_code_3","address_format_id"
	 * 
	 * @param arrayCountryData $CountryData
	 * @param bool $ThrowError Whether to throw error or not
	 * 
	 * @return bool If any error, then Throw Exception otherwise return true on success and false on failure
	 */
	public function editCountry($CountryData, $ThrowError=true)
	{
		//build up update query
		$UpdateData = $CountryData->InternalSync(RDataModel::UPDATE, "countries_name","countries_iso_code_2","area_code","address_format_id","zone","days","status","state_validation");
 	$Query = "UPDATE countries SET $UpdateData WHERE countries_id = ". $CountryData->countries_id;
//exit();
       	/**
		  * check that data should be updated perfectly.
		  * if no then throw or return proper error message.
		  */
		$ThrowException = null;
		try {
	  		$Rs = $this->Connection->Execute($Query);
	  		if ( $Rs->AffectedRows() == 0 )	{
				//throw new Exception(' Fail To Edit countries Record ');
				return false;
	  		}
		} catch(Exception $Exception) {
			if($ThrowError == true) {
				$ThrowException = new Exception(' Fail To Edit countries Record ');
			 } else {
				return false;
			 }
    	}// try-catch end

		if ($ThrowException) {
			throw $ThrowException;
		} else {
			return true;
		}
	}//editCountry Function End

	/**
	 * To delete countries data
	 *
	 * @param int countries_id $countries_id
	 * @param bool $ThrowError Whether to throw or not to throw error
	 * 
	 * @return bool If any error, then Throw Exception otherwise return true on success and false on failure
	 */
	public function deleteCountry($countries_id, $ThrowError=true)
	{
   		if(isset($countries_id) && ($countries_id!=null)) {
   			//build up delete query
   			$Query ="DELETE FROM countries WHERE countries_id = " . $countries_id;

 			/**
			  * check that data should be updated perfectly.
			  * if no then throw or return proper error message.
			  */
 			$ThrowException = null;
 			try {
				$this->Connection->Execute($Query);
				return true;
			} catch (Exception $Exception) {
				if($ThrowError == true) {
			    	$ThrowException = new Exception(' Fail To Delete countries Record');
				} else {
					return false;
			    }
			}// try catch end
  		} // if end
	 }//deleteCountry Function End

	 /**
	 * GetCountry method is used for to get all or selected columns records from countries with searching, sorting and paging criteria.
	 *
	 * @param array array $fieldArr contains table field name
	 * @param array array $seaArr contains 7 elements are
	 *     "Search_On"    = Field name on which search the data
	 *     "Search_Value" = Value which is compared with field defined in "Search_On"												 *     "Equation"     = Equation like '=','LIKE','BETWEEN' and so on.
	 *     "Type"         = Field Type like 'string' and 'int' only. apply "string" for all except int, double, long double etc.
	 *     "CondType"	  = Condition Type like "AND", "OR"
	 *     "Prefix" 	  = Prefix may be blank '' or "("
	 *     "Postfix" 	  = Postfix may be blank '' or ")"
	 * @param array array $optArr contains 2 elements are 
	 *     "Order_By"     = Field Name of table for sorting 
	 *     "Order_Type"   = Sorting Type like 'ASC', 'DESC'
	 * @param int integer $start  Starting point to fetch data rows. e.g. $start = 10 then will start fetch rows from 10th row.
	 * @param int integer $total  Total number of rows to display on one page. e.g. $total = 20 then will display 20 records on one page
	 * @param bool $ThrowError Whether to throw error or not
	 * @return array array $ret contains all the record sets by applying searching, sorting, paging criteria.
	 * 
	 */
	public function getCountry($fieldArr=null, $seaArr=null, $optArr=null, $start=null, $total=null, $ThrowError=true)
	{
		/**
		 * Table Columns
		 * If $fieldArr has null value then it will return all records otherwise entered table fields
		 * 
		 * @see below example for to create $fieldArr for to get only selected table fields data
		 * 
		 *     $fieldArr = array("col1", "col2", "col3");
		 */
		
		if(is_array($fieldArr) && !empty($fieldArr)) {
			$fields = implode(", ", $fieldArr);
		} else {
			$fields = "*";
		}
			
		/**
		 * Searching criteria (where condition build up) 
		 *	 
		 * @see below example for how to create $seaArr for multiple condition
		 * 
		 * 		'col1 = 1 AND (col2 LIKE "str2" OR col3 LIKE "str3")'
		 * 
		 *		$seaArr[]	=	array('Search_On'=>'col1',
		 * 									'Search_Value'=>1,
		 * 									'Type'=>'int',
		 * 									'Equation'=>'=',
		 * 									'CondType'=>'AND',
		 * 									'Prefix'=>'',
		 * 									'Postfix'=>''					);
		 * 		$seaArr[]	=	array('Search_On'=>'col2',
		 * 									'Search_Value'=>'str2',
		 * 									'Type'=>'string',
		 * 									'Equation'=>'LIKE',
		 * 									'CondType'=>'AND',
		 * 									'Prefix'=>'(',
		 * 									'Postfix'=>''					);
		 * 		$seaArr[]	=	array('Search_On'=>'col3',
		 * 								 	'Search_Value'=>'str3',
		 * 									'Type'=>'string',
		 * 									'Equation'=>'LIKE',
		 * 									'CondType'=>'OR',
		 * 									'Prefix'=>'',
		 * 									'Postfix'=>')'					);			
		 */			
		
		$whereExtra = "";

		
		/*
		Commented by Smita  9th Nov 2020
		because array was coming as below and it was throwing error Illegal string offset 'Type'"

		Array
		(
		    [Search_On] => countries_id
		    [Search_Value] => 2
		    [Type] => int
		    [Equation] => =
		    [CondType] => AND
		    [Prefix] => 
		    [Postfix] => 
		)
		*/

		

		if(is_array($seaArr[0]) && !empty($seaArr[0])) {
			
			
			
				foreach($seaArr as $key=>$val) {
					
					$wheExt = '';
					if(!empty($val['Search_Value'])){
					
						if(strtolower($val['Type']) != 'string') {
							$wheExt = $val['CondType']." ".$val['Prefix']." ".$val['Search_On']." ".$val['Equation']." '".addslashes($val['Search_Value'])."'"." ".$val['Postfix'];
						} else {				
							$wheExt = $val['CondType']." ".$val['Prefix']." ".$val['Search_On']." ".$val['Equation']." '".addslashes($val['Search_Value'])."'"." ".$val['Postfix'];
						}
					}else{
					
						if(strtolower($val['Type']) != 'string') {
							$wheExt = $val['CondType']." ".$val['Prefix']." ".$val['Search_On']." ".$val['Equation']." '".($val['Search_Value'])."'"." ".$val['Postfix'];
						} else {				
							$wheExt = $val['CondType']." ".$val['Prefix']." ".$val['Search_On']." ".$val['Equation']." '".($val['Search_Value'])."'"." ".$val['Postfix'];
						}
					}
					
					$whereExtra .= " ".$wheExt;
				}
				
				if($whereExtra != "") {
					$whereExtra = "WHERE 1 $whereExtra";
				}
			//}	

			//foreach($seaArr as $key=>$val) {
				
				
		}else{
			if(is_array($seaArr) && !empty($seaArr)) {
				$wheExt = '';
					if(!empty($seaArr['Search_Value'])){
					
						if(strtolower($seaArr['Type']) != 'string') {
							$wheExt = $seaArr['CondType']." ".$seaArr['Prefix']." ".$seaArr['Search_On']." ".$seaArr['Equation']." '".addslashes($seaArr['Search_Value'])."'"." ".$seaArr['Postfix'];
						} else {				
							$wheExt = $seaArr['CondType']." ".$seaArr['Prefix']." ".$seaArr['Search_On']." ".$seaArr['Equation']." '".addslashes($seaArr['Search_Value'])."'"." ".$seaArr['Postfix'];
						}
					}else{
					
						if(strtolower($seaArr['Type']) != 'string') {
							$wheExt = $seaArr['CondType']." ".$seaArr['Prefix']." ".$seaArr['Search_On']." ".$seaArr['Equation']." '".($seaArr['Search_Value'])."'"." ".$seaArr['Postfix'];
						} else {				
							$wheExt = $seaArr['CondType']." ".$seaArr['Prefix']." ".$seaArr['Search_On']." ".$seaArr['Equation']." '".($seaArr['Search_Value'])."'"." ".$seaArr['Postfix'];
						}
					}
					
					$whereExtra .= " ".$wheExt;
				//}
				
				if($whereExtra != "") {
					$whereExtra = "WHERE 1 $whereExtra";
				}
			}
		}
		
		//echo $whereExtra;
		/**
		 * Sorting
		 * 
		 * @see below example how to build up $optArr for sorting
		 * 
		 * 		'ORDER BY col1 ASC, col2 DESC'
		 * 
		 * 		$optArr[]	=	array("Order_By" => "col1",
		 * 								"Order_Type" => "ASC"	);
		 * 		$optArr[]	=	array("Order_By" => "col2",
		 * 								"Order_Type" => "DESC"	);
		 * 
		 */
		$optstring = "";
		if(is_array($optArr) && !empty($optArr)) {
			$optstring .= " ORDER BY ";
					
			$i = &$optKey;		
			foreach ($optArr as $optKey => $optVal) {
				
				if($i != 0) {
					$optstring .= ", ";
				}
				$optstring .= $optVal['Order_By']." ".$optVal['Order_Type'];				
			}				
		} 
		
		/**
		 * Paging
		 */
		$limitString = '';
		if(isset($total) && !is_null($total)) {
			if(is_null($start)) {
				$start = 0;
			}
			$limitString .= "LIMIT ".$total." OFFSET ".$start;
		}							
		
		/**
		 * Build up query
		 */
		  $Query = "SELECT $fields FROM countries $whereExtra $optstring $limitString";
		
		//echo $Query;
		
		/**
		 * Execute Query
		 * If any error during execution of query it will return false
		 */
		try	{
			$Rs = $this->Connection->Execute($Query);
			if ($Rs->RecordCount() == 0 ) { //check whether the record is found or not
				return false;
			}
		}
	    catch (Exception $Exception) {
			if($ThrowError == true) {
				$ThrowException = new Exception(' Fail To Get Any Record of countries');
			}
	    } // try -catch end
  
	    //Create CategoryData Object
   	    $CountryData = new RModelCollection();
   	    /*echo "<pre>";
   	    print_r($Rs);
   	    echo "</pre>";
   	    exit();*/
   	    //assing all fetched records into CategoryData Object
   	    if(isset($Rs) && !empty($Rs)){
   	    	foreach ($Rs as $Record) {
		 		$CountryData->Add(new CountryData($Record));
	    	}//foreach end	
   	    }
   	    
	    
	    return $CountryData;//return the fetched recordset		
	}//getCountry function end
}//class End