<?php

/**
 * This is ConfigurationMaster file.
 * This file contains all the business logic code related to configuration_master table.
 * 
 * TABLE_NAME:    configuration_master 
 * PRIMARY_KEY :  configuration_id
 * TABLE_COLUMNS: "constant_name","sort_order"
 * 
 * @uses By creating object of ConfigurationMaster we can handle or manage different table operation like insert, update, delete and selecting data with criteria from table.
 * 
 * @package    Specify package to group classes or functions and defines into
 * @author     Radixweb
 * @copyright  Document Copyright information, e.g. Copyright (c) 2008, Radixweb
 * @license    Display a hyperlink to a URL for a license, e.g. http://opensource.org/licenses/gpl-license.php GNU Public License
 * @version    $Id: ConfigurationMaster.php,v 1.0
 * @link       Display a hyperlink to a URL in the documentation, e.g. http://radixweb.com
 * @since      Document when (at which version) an element was first added to a package e.g. Version 1.0 
 * 
 */
 
/**
 * @see ConfigurationData.php for Data class
 */


require_once(DIR_WS_MODEL . "ConfigurationData.php");

/**
 * @see RMasterModel.php for extended RMasterModel class
 */
require_once(DIR_LIB_CLASSES_MODELS."/RMasterModel.php");

class ConfigurationMaster extends RMasterModel
{	
	
	/**
	 * Create a null object of ConfigurationMaster
	 *
	 * @return object object $ConfigurationMasterObj
	 */	
	public function create()
	{
		$ConfigurationMasterObj = new ConfigurationMaster();
		return  $ConfigurationMasterObj;
	}//create Function End
	      
	/**
	 * To insert record in configuration_master table 
	 * Insert data of columns : "constant_name","sort_order"
	 *
	 * @param arrayConfigurationData $ConfigurationData 
	 * @param bool $ThrowError Whether to throw error or not
	 * 
	 * @return int If any error, then Throw Exception otherwise inserted row id
	 */	
	 public function addConfiguration($ConfigurationData, $ThrowError=true)
	 {
	 		//build up insert query
		 	$FinalData = $ConfigurationData->InternalSync(RDataModel::INSERT, "constant_name","default_value","set_value","sort_order","element_type","value_limit","value_type");
		 	$Query = "INSERT INTO configuration_master $FinalData"; 
		 	
		 	/**
			  * check that data should be inserted successfully.
			  * if no then throw or return proper error message. 
			  */
		 	$ThrowException = null;
	 		try { 
	 			
				$Rs=$this->Connection->Execute($Query);
				if ($Rs->AffectedRows() ==  0) {
					throw new Exception(' Fail To Add New configuration_master Record');
				}
				
			}
			catch(Exception $Exception) {
				
				if($ThrowError == true){
					$ThrowException = new Exception(' Fail To Add configuration_master Record ');
				} else {
					return false;	
				}//if-else end
				
			}// try -catch end
								
			if ($ThrowException) {
				throw $ThrowException;
			} else {
				return $this->Connection->LastInsertedId();
			}
		
	}//addConfiguration Function End
	
	/**
	 * To insert record in configuration_master table 
	 * Insert data of columns : "constant_name","sort_order"
	 *
	 * @param arrayConfigurationData $ConfigurationData 
	 * @param bool $ThrowError Whether to throw error or not
	 * 
	 * @return int If any error, then Throw Exception otherwise inserted row id
	 */	
	 public function addConfigurationDescription($ConfigurationData, $ThrowError=true)
	 {
	 		//build up insert query
		 	$FinalData = $ConfigurationData->InternalSync(RDataModel::INSERT, "configuration_id","description","site_language_id");
		 	$Query = "INSERT INTO configuration_description $FinalData"; 
		 	
		 	/**
			  * check that data should be inserted successfully.
			  * if no then throw or return proper error message. 
			  */
		 	$ThrowException = null;
	 		try { 
	 			
				$Rs=$this->Connection->Execute($Query);
				if ($Rs->AffectedRows() ==  0) {
					throw new Exception(' Fail To Add New configuration_description Record');
				}
				
			}
			catch(Exception $Exception) {
				
				if($ThrowError == true){
					$ThrowException = new Exception(' Fail To Add configuration_description Record ');
				} else {
					return false;	
				}//if-else end
				
			}// try -catch end
								
			if ($ThrowException) {
				throw $ThrowException;
			} else {
				return $this->Connection->LastInsertedId();
			}
		
	}//addConfiguration Function End
	
	
	/**
	 * To update record of configuration_master table
	 * Update data of columns : "constant_name","sort_order"
	 * 
	 * @param arrayConfigurationData $ConfigurationData 
	 * @param bool $ThrowError Whether to throw error or not
	 * 
	 * @return bool If any error, then Throw Exception otherwise return true on success and false on failure
	 */	
	public function editConfiguration($ConfigurationData, $ThrowError=true, $changeFieldName=null) 
	{
		 
		//build up update query
		if(!empty($changeFieldName)) {
			$UpdateData = $ConfigurationData->InternalSync(RDataModel::UPDATE, "set_value");
	       	$Query = "UPDATE configuration_master SET $UpdateData WHERE configuration_id = ". $ConfigurationData->configuration_id;
		} else {
			$UpdateData = $ConfigurationData->InternalSync(RDataModel::UPDATE, "constant_name","default_value","set_value","sort_order","element_type","value_limit","value_type");         
	       	$Query = "UPDATE configuration_master SET $UpdateData WHERE configuration_id = ". $ConfigurationData->configuration_id;
		}
       	
       	/**
		  * check that data should be updated perfectly.
		  * if no then throw or return proper error message.
		  */
		$ThrowException = null;
		try {
	  		$Rs = $this->Connection->Execute($Query);
	  		if ( $Rs->AffectedRows() == 0 )	{
				//throw new Exception(' Fail To Edit configuration_master Record ');
				return false;
	  		}
		}//try end
		catch(Exception $Exception) {
			if($ThrowError == true) {
				$ThrowException = new Exception(' Fail To Edit configuration_master Record ');
			 } else {
				return false;	
			 }
    	}// try-catch end
    	
		if ($ThrowException) {
			throw $ThrowException; 
		} else {
			return true;
		}
		
	}//editConfiguration Function End
	
	
	
	
	/**
	 * To update record of configuration_master table
	 * Update data of columns : "constant_name","sort_order"
	 * 
	 * @param arrayConfigurationData $ConfigurationData 
	 * @param bool $ThrowError Whether to throw error or not
	 * 
	 * @return bool If any error, then Throw Exception otherwise return true on success and false on failure
	 */	
	public function editConfigurationDescription($ConfigurationData, $ThrowError=true) 
	{
		 
		//build up update query
		$UpdateData = $ConfigurationData->InternalSync(RDataModel::UPDATE, "description");
       		$Query = "UPDATE configuration_description SET $UpdateData WHERE configuration_id = ". $ConfigurationData->configuration_id . " AND site_language_id = " . $ConfigurationData->site_language_id;
       	
       	/**
		  * check that data should be updated perfectly.
		  * if no then throw or return proper error message.
		  */
		$ThrowException = null;
		try {
	  		$Rs = $this->Connection->Execute($Query);
	  		if ( $Rs->AffectedRows() == 0 )	{
				//throw new Exception(' Fail To Edit configuration_description Record ');
				return false;
	  		}
		}//try end
		catch(Exception $Exception) {
			if($ThrowError == true) {
				$ThrowException = new Exception(' Fail To Edit configuration_description Record ');
			 } else {
				return false;	
			 }
    	}// try-catch end
    	
		if ($ThrowException) {
			throw $ThrowException; 
		} else {
			return true;
		}
		
	}//editConfiguration Function End
	
	/**
	 * To delete configuration_master data
	 *
	 * @param int configuration_id $configuration_id 
	 * @param bool $ThrowError Whether to throw or not to throw error
	 * 
	 * @return bool If any error, then Throw Exception otherwise return true on success and false on failure
	 */	 
	public function deleteConfiguration($configuration_id, $ThrowError=true) 
	{
   		if(isset($configuration_id) && ($configuration_id!=null)) {
 			
   			//build up delete query
   			$Query ="DELETE FROM configuration_master WHERE configuration_id = " . $configuration_id;
   			$QueryDesc ="DELETE FROM configuration_description WHERE configuration_id = " . $configuration_id;
 			
 			/**
			  * check that data should be updated perfectly.
			  * if no then throw or return proper error message. 
			  */
 			$ThrowException = null;
 			try {	
				$this->Connection->Execute($Query);
				$this->Connection->Execute($QueryDesc);
				return true;
   					
			}
			catch (Exception $Exception){
				if($ThrowError == true) {
			    	$ThrowException = new Exception(' Fail To Delete configuration_master Record');
				}	
			    else {
					return false;	
			    }
			}// try catch end	
    				
  		} // if end
	  		
	 }//deleteConfiguration Function End	
	
	 
	 /**
	 * GetConfiguration method is used for to get all or selected columns records from configuration_master with searching, sorting and paging criteria.
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
	 public function getConfiguration($fieldArr=null, $seaArr=null, $optArr=null, $start=null, $total=null, $QueryString=null, $ThrowError=true)
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
			if(is_array($seaArr) && !empty($seaArr)) {
				
				foreach($seaArr as $key=>$val) {
					
					$wheExt = '';
					
					if(strtolower($val['Type']) != 'string') {
						$wheExt = $val['CondType']." ".$val['Prefix']." ".$val['Search_On']." ".$val['Equation']." '".addslashes($val['Search_Value'])."'"." ".$val['Postfix'];
					} else {				
						$wheExt = $val['CondType']." ".$val['Prefix']." ".$val['Search_On']." ".$val['Equation']." '".addslashes($val['Search_Value'])."'"." ".$val['Postfix'];
					}
					
					$whereExtra .= " ".$wheExt;
				}
				
				if($whereExtra != "") {
					$whereExtra = "WHERE 1 $whereExtra";
				}
			}	
			
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
			if(!empty($QueryString)) {
				$Query = $QueryString;
			} else {
				$Query = "SELECT $fields FROM configuration_master $whereExtra $optstring $limitString";
			}
			
			
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
					$ThrowException = new Exception(' Fail To Get Any Record of configuration_master');
				}
		    } // try -catch end
	  
		    if(!empty($QueryString)) {
		    	$ConfigurationData = array();
		    	
		    	//assing all fetched records into  ConfigurationData Object
		   	foreach ($Rs as $Record) {
			 	$ConfigurationData[] = $Record;
			}//foreach end	
		    	
		    } else {
		    	//Create  ConfigurationData Object
		   	$ConfigurationData = new RModelCollection();
		   	    
		   	//assing all fetched records into ConfigurationData Object
		   	foreach ($Rs as $Record) {
			 	$ConfigurationData->Add(new ConfigurationData($Record));
			}//foreach end	
		    }
		    
		    return $ConfigurationData;//return the fetched recordset		
	 }//getConfiguration function end 

	public function getConfigurationDetails ($fieldArr=null)
	{
		if(is_array($fieldArr) && !empty($fieldArr)) {
			$fields = implode(", ", $fieldArr);
		} else {
			$fields = "*";
		}

		$Query = "SELECT $fields FROM configuration_master 
				LEFT JOIN configuration_description ON configuration_description.configuration_id = configuration_master.configuration_id
				WHERE 1 AND configuration_description.site_language_id = " . SITE_LANGUAGE_ID . " ORDER BY sort_order";

		try	{
			$Rs = $this->Connection->Execute($Query);
			if ($Rs->RecordCount() == 0 ) { //check whether the record is found or not
				return false;
			}
		} catch (Exception $Exception) {
			if($ThrowError == true) {
				$ThrowException = new Exception(' Fail To Get Any Record of cms_pages');
			}
		} // try -catch end
		return $Rs;
	}
	
}//class End

?>