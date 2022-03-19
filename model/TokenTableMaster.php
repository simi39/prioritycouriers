<?php
/**
 * This is TokenTableMaster file.
 * This file contains all the business logic code related to token_table_name table.
 * 
 * TABLE_NAME:    token_table_name
 * PRIMARY_KEY :  userid
 * TABLE_COLUMNS: "firstname","lastname","email","street_address","suburb","city","postcode","state","country","password","phone_number","user_type_id","corporate_id", "giftcard", "giftcard_id", "address1","address2","address3","facsimile_no"
 * 
 * @uses By creating object of UserMaster we can handle or manage different table operation like insert, update, delete and selecting data with criteria from table.
 * 
 * @package    User Management
 * @author     Radixweb
 * @copyright  Document Copyright information, e.g. Copyright (c) 2008, Radixweb
 * @license    Display a hyperlink to a URL for a license, e.g. http://opensource.org/licenses/gpl-license.php GNU Public License
 * @version    $Id: TokenTableMaster.php,v 1.0
 * @link       Display a hyperlink to a URL in the documentation, e.g. http://radixweb.com
 * @since      Document when (at which version) an element was first added to a package e.g. Version 1.0
 * 
 */

/**
 * @see TokenTableData.php for Data class
 */
require_once(DIR_WS_MODEL . "TokenTableData.php");

/**
 * @see RMasterModel.php for extended RMasterModel class
 */
require_once(DIR_LIB_CLASSES_MODELS."/RMasterModel.php");

class TokenTableMaster extends RMasterModel
{
	/**
	 * Create a null object of TokenTableMaster
	 *
	 * @return object object $TokenTableMasterObj
	 */
	public function create()
	{
		$TokenTableMasterObj = new TokenTableMaster();
		return  $TokenTableMasterObj;
	}//create Function End

	/**
	 * To insert record in token_table_name table
	 * 
	 *
	 * @param arrayTokenTableData $TokenTableData
	 * @param bool $ThrowError Whether to throw error or not
	 * 
	 * @return int If any error, then Throw Exception otherwise inserted row id
	 */
	public function addTokenTable($TokenTableData, $ThrowError=true,$QueryString=null)
	{
		if(empty($QueryString))
		{
			//build up insert query
			$FinalData = $TokenTableData->InternalSync(RDataModel::INSERT,"id","sid","mykey","ipaddress","stamp","action","expiry_token_time");
			$Query = "INSERT INTO token_table_name $FinalData";
		}
		else
		{
			$Query = $QueryString;	
		}
		//echo $Query;
		//exit();
	 	/**
		  * check that data should be inserted successfully.
		  * if no then throw or return proper error message.
		  */
	 	$ThrowException = null;
 		try {
			$Rs = $this->Connection->Execute($Query);
			
			if ($Rs->AffectedRows() ==  0) {
				throw new Exception(' Fail To Add New token_table_name Record');
			}
		} catch(Exception $Exception) {
			if($ThrowError == true) {
				$ThrowException = new Exception(' Fail To Add token_table_name Record ');
			} else {
				return false;
			}//if-else end
		}// try -catch end

		if ($ThrowException) {
			throw $ThrowException;
		} else {
			return $this->Connection->LastInsertedId();
		}
	}//addUser Function End
	
	/**
	 * To update record of token_table_name table
	 * Update data of columns : 
	 * 
	 * @param arrayTokenTable $TokenTableData
	 * @param bool $ThrowError Whether to throw error or not
	 * 
	 * @return bool If any error, then Throw Exception otherwise return true on success and false on failure
	 */
	public function editTokenTable($TokenTableData=null, $QueryString=null, $ThrowError=true)
	{
		
		if($QueryString)
		{
			 $Query = $QueryString ;
		}else{		
			 $UpdateData = $TokenTableData->InternalSync(RDataModel::UPDATE, "sid","mykey","ipaddress","stamp","action","expiry_token_time");
			 $Query = 'UPDATE token_table_name SET '.$UpdateData.' WHERE ip = "'.$TokenTableData->id.'"';
		}
		//echo $Query;
		//exit();
		
		
       	/**
		  * check that data should be updated perfectly.
		  * if no then throw or return proper error message.
		  */
		$ThrowException = null;
		try {
	  		$Rs = $this->Connection->Execute($Query);
	  		if ( $Rs->AffectedRows() == 0 )	{
				//throw new Exception(' Fail To Edit token_table_name Record ');
				return false;
	  		}
		} catch(Exception $Exception) {
			if($ThrowError == true) {
				$ThrowException = new Exception(' Fail To Edit token_table_name Record ');
			 } else {
				return false;
			 }
    	}// try-catch end

		if ($ThrowException) {
			throw $ThrowException;
		} else {
			return true;
		}
	}//editUser Function End

	 /**
	 * Delete user's all records from different tables
	 *
	 * @param int $ContentId
	 *
	 */
	 public function deleteTokenTable($id=null,$fieldname=null,$withoutIP=null,$expiry_time_token=null)
	 {
		//$ipaddress = $_SERVER['REMOTE_ADDR'];
		$ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
		if($withoutIP == true)
		{
			$Query ="delete from token_table_name where $fieldname '$id'";
		}else{
			$Query ="delete from token_table_name where $fieldname '$id' and ipaddress = '$ipaddress' ";
		}
		if($expiry_time_token)
		{
			$Query .=" and expiry_token_time = '$expiry_time_token'";
		}
		//echo $Query;
		//exit();
		
		$ThrowException = null;
		try {
			$this->Connection->Execute($Query);
			//print_R($car);
		} catch (Exception $Exception) {
			if($ThrowError == true) {
				$ThrowException = new Exception(' Not any Record Found For this Id :'.$id."<br>");
			} else {
				return false;
			}
		}// try catch end
		if ($ThrowException) {
			throw $ThrowException;
		} else {
			return true;
		}	
  		
	}// Function End
	
	 /**
	 * Delete user's all records from different tables
	 *
	 * @param int $ContentId
	 *
	 */
	 public function deleteRestTokenTable($id=null,$fieldname=null)
	 {
		
		$Query ="delete from token_table_name where $fieldname '$id'";
		
		//echo $Query;
		//exit();
		
		$ThrowException = null;
		try {
			$this->Connection->Execute($Query);
			//print_R($car);
		} catch (Exception $Exception) {
			if($ThrowError == true) {
				$ThrowException = new Exception(' Not any Record Found For this Id :'.$id."<br>");
			} else {
				return false;
			}
		}// try catch end
		if ($ThrowException) {
			throw $ThrowException;
		} else {
			return true;
		}	
  		
	}// Function End

	/**
	 * GetUser method is used for to get all or selected columns records from user_master with searching, sorting and paging criteria.
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
	public function getTokenTable($fieldArr=null, $seaArr=null, $optArr=null, $start=null, $total=null, $QueryString=null, $ThrowError=true)
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
		if($QueryString!=''){
			$Query = $QueryString;
		}else{
			$Query = "SELECT $fields FROM token_table_name $whereExtra  $optstring $limitString";
		}
		
		//echo $Query;
		/**
		 * Execute Query
		 * If any error during execution of query it will return false
		 */
		try	{
			$Rs = $this->Connection->Execute($Query);
			//print_R($Rs);
			//exit();
			if ($Rs->RecordCount() == 0 ) { //check whether the record is found or not
				return false;
			}
		}
	    catch (Exception $Exception) {
			if($ThrowError == true) {
				$ThrowException = new Exception(' Fail To Get Any Record of token_table_name');
			}
	    } // try -catch end
  		
	    if($QueryString!=''){
    		$TokenTableData = array();
    		//assing all fetched records into CategoryData Object
	   	    foreach ($Rs as $Record) {
			 	$TokenTableData[]=$Record;
		    }//foreach end
	    }else{
		    //Create CategoryData Object
	   	    $TokenTableData = new RModelCollection();
	   	    
	   	    //assing all fetched records into CategoryData Object
	   	    foreach ($Rs as $Record) {
			 	$TokenTableData->Add(new TokenTableData($Record));
		    }//foreach end
	    }
	    
	    return $TokenTableData;//return the fetched recordset		
	}//getUser function end
	
	
	
	
}