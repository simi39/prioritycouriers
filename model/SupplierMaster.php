<?php

/**
 * This is SupplierMaster file.
 * This file contains all the business logic code related to supplier_detail table.
 * 
 * TABLE_NAME:    supplier_detail 
 * PRIMARY_KEY :  auto_id
 * TABLE_COLUMNS: "supplier_name","code","fuel_charge","code_formate"
 *  
 * 
 * @uses By creating object of SupplierMaster we can handle or manage different table operation like insert, update, delete and selecting data with criteria from table.
 * 
 * @package    Supplier Managment
 * @author     Radix
 * @copyright  Document Copyright information, e.g. Copyright (c) 2008, Radixweb
 * @license    Display a hyperlink to a URL for a license, e.g. http://opensource.org/licenses/gpl-license.php GNU Public License
 * @version    $Id: SupplierMaster.php,v 1.0
 * @link       Display a hyperlink to a URL in the documentation, e.g. http://radixweb.com
 * @since      Document when (at which version) an element was first added to a package e.g. Version 1.0 
 * 
 */
 
/**
 * @see SupplierData.php for Data class
 */
require_once(DIR_WS_MODEL."/SupplierData.php");

/**
 * @see RMasterModel.php for extended RMasterModel class
 */
require_once(DIR_LIB_CLASSES_MODELS."/RMasterModel.php");
require_once(DIR_LIB_PEAR."DB.php");

class SupplierMaster extends RMasterModel
{	
	
	/**
	 * Create a null object of SupplierMaster
	 *
	 * @return object object $SupplierMasterObj
	 */	

	function __construct() {
       $this->Connection = new RDataConnection();	
		//Connect($Type, $User, $Password, $Database, $Host = null, $Port = null)

		$this->Connection->Connect(CONNECTION_TYPE,DATABASE_USERNAME,DATABASE_PASSWORD,DATABASE_NAME,DATABASE_HOST,DATABASE_PORT);
    }

	public function create()
	{
		$SupplierMasterObj = new SupplierMaster();
		return  $SupplierMasterObj;
	}//create Function End
	      
	/**
	 * To insert record in supplier_detail table 
	 * Insert data of columns : "supplier_name","code","fuel_charge"
	 *
	 * @param arraySupplierData $SupplierData 
	 * @param bool $ThrowError Whether to throw error or not
	 * 
	 * @return int If any error, then Throw Exception otherwise inserted row id
	 */	
	 public function addSupplier($SupplierData, $ThrowError=true)
	 {
	 		//build up insert query
 		 	$FinalData = $SupplierData->InternalSync(RDataModel::INSERT, "supplier_name","code","fuel_charge","code_formate");
		 	$Query = "INSERT INTO supplier_detail $FinalData"; 
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
					throw new Exception(' Fail To Add New supplier_detail Record');
				}
				
			}
			catch(Exception $Exception) {
				
				if($ThrowError == true){
					$ThrowException = new Exception(' Fail To Add supplier_detail Record ');
				} else {
					return false;	
				}//if-else end
				
			}// try -catch end
								
			if ($ThrowException) {
				throw $ThrowException;
			} else {
				return $this->Connection->LastInsertedId();
			}
		
	}//addSupplier Function End
	
	
	
	/**
	 * To update record of supplier_detail table
	 * Update data of columns : "supplier_name","code","fuel_charge"
	 * 
	 * @param arraySupplierData $SupplierData 
	 * @param bool $ThrowError Whether to throw error or not
	 * 
	 * @return bool If any error, then Throw Exception otherwise return true on success and false on failure
	 */	
	public function editSupplier($SupplierData, $statusChange=null, $ThrowError=true) 
	{
		 
		//build up update query
		if($statusChange == true) {
 			$UpdateData = $SupplierData->InternalSync(RDataModel::UPDATE, "status");
 		} else {
			$UpdateData = $SupplierData->InternalSync(RDataModel::UPDATE, "supplier_name","code","fuel_charge","code_formate");
	        	$Query = "UPDATE supplier_detail SET $UpdateData WHERE auto_id = ". $SupplierData->auto_id;
 		}
 		
       	/**
		  * check that data should be updated perfectly.
		  * if no then throw or return proper error message.
		  */
		$ThrowException = null;
		try {
	  		$Rs = $this->Connection->Execute($Query);
	  		if ( $Rs->AffectedRows() == 0 )	{
				//throw new Exception(' Fail To Edit supplier_detail Record ');
				return false;
	  		}
		}//try end
		catch(Exception $Exception) {
			if($ThrowError == true) {
				$ThrowException = new Exception(' Fail To Edit supplier_detail Record ');
			 } else {
				return false;	
			 }
    	}// try-catch end
    	
		if ($ThrowException) {
			throw $ThrowException; 
		} else {
			return true;
		}
		
	}//editSupplier Function End
	
	
	
	/**
	 * To delete supplier_detail data
	 *
	 * @param int auto_id $auto_id 
	 * @param bool $ThrowError Whether to throw or not to throw error
	 * 
	 * @return bool If any error, then Throw Exception otherwise return true on success and false on failure
	 */	 
	public function deleteSupplier($auto_id, $ThrowError=true) 
	{
   		if(isset($auto_id) && ($auto_id!=null)) {
 			
   			//build up delete query
   			$Query ="DELETE FROM supplier_detail WHERE auto_id = " . $auto_id;
 			
 			/**
			  * check that data should be updated perfectly.
			  * if no then throw or return proper error message. 
			  */
 			$ThrowException = null;
 			try {	
				$this->Connection->Execute($Query);
				return true;
   					
			}
			catch (Exception $Exception){
				if($ThrowError == true) {
			    	$ThrowException = new Exception(' Fail To Delete supplier_detail Record');
				}	
			    else {
					return false;	
			    }
			}// try catch end	
    				
  		} // if end
	  		
	 }//deleteSupplier Function End	
	
	 
	 	 
	 /**
	 * GetSupplier method is used for to get all or selected columns records from supplier_detail with searching, sorting and paging criteria.
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
	 public function getSupplier($fieldArr=null, $seaArr=null, $optArr=null, $start=null, $total=null, $QueryString=null , $TableName=null, $ThrowError=true)
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
					$whereExtra = "WHERE true $whereExtra";
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
				if($TableName=="")
				{
					$Query = "SELECT $fields FROM supplier_detail $whereExtra $optstring $limitString";		
				}
				else {
					$Query = "SELECT $fields FROM $TableName $whereExtra $optstring $limitString";		
				}
					
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
					$ThrowException = new Exception(' Fail To Get Any Record of supplier_detail');
				}
		    } // try -catch end
	  
		    //Create CategoryData Object
	   	    $SupplierData = new RModelCollection();
	   	    if($Rs!="")
	   	    {
	   	    //assing all fetched records into CategoryData Object
	   	    foreach ($Rs as $Record) {
			 	$SupplierData->Add(new SupplierData($Record));
		    }//foreach end
	   	    }
		    
		    return $SupplierData;//return the fetched recordset		
	 }//getSupplier function end 

	
	
}//class End