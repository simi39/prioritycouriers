<?php
/**
 * This is UserMaster file.
 * This file contains all the business logic code related to user_master table.
 * 
 * TABLE_NAME:    user_master
 * PRIMARY_KEY :  userid
 * TABLE_COLUMNS: "firstname","lastname","email","street_address","suburb","city","postcode","state","country","password","phone_number","user_type_id","corporate_id", "giftcard", "giftcard_id", "address1","address2","address3","facsimile_no"
 * 
 * @uses By creating object of UserMaster we can handle or manage different table operation like insert, update, delete and selecting data with criteria from table.
 * 
 * @package    User Management
 * @author     Radixweb
 * @copyright  Document Copyright information, e.g. Copyright (c) 2008, Radixweb
 * @license    Display a hyperlink to a URL for a license, e.g. http://opensource.org/licenses/gpl-license.php GNU Public License
 * @version    $Id: UserMaster.php,v 1.0
 * @link       Display a hyperlink to a URL in the documentation, e.g. http://radixweb.com
 * @since      Document when (at which version) an element was first added to a package e.g. Version 1.0
 * 
 */

/**
 * @see UserData.php for Data class
 */
require_once(DIR_WS_MODEL . "IPAddressData.php");

/**
 * @see RMasterModel.php for extended RMasterModel class
 */
require_once(DIR_LIB_CLASSES_MODELS."/RMasterModel.php");

class IPAddressMaster extends RMasterModel
{
	/**
	 * Create a null object of UserMaster
	 *
	 * @return object object $UserMasterObj
	 */
	public function create()
	{
		$IPAddressMasterObj = new IPAddressMaster();
		return  $IPAddressMasterObj;
	}//create Function End

	/**
	 * To insert record in login_attempts table
	 * 
	 *
	 * @param arrayUserData $UserData
	 * @param bool $ThrowError Whether to throw error or not
	 * 
	 * @return int If any error, then Throw Exception otherwise inserted row id
	 */
	public function addIPAddress($IPAddressData, $ThrowError=true,$QueryString=null)
	{
		if(empty($QueryString))
		{
			//build up insert query
			$FinalData = $IPAddressData->InternalSync(RDataModel::INSERT,"ip","attempts","lastlogin");
			$Query = "INSERT INTO login_attempts $FinalData";
		}
		else
		{
			$Query = $QueryString;	
		}
		
	 	/**
		  * check that data should be inserted successfully.
		  * if no then throw or return proper error message.
		  */
	 	$ThrowException = null;
 		try {
			$Rs=$this->Connection->Execute($Query);
			if ($Rs->AffectedRows() ==  0) {
				throw new Exception(' Fail To Add New login_attempts Record');
			}
		} catch(Exception $Exception) {
			if($ThrowError == true) {
				$ThrowException = new Exception(' Fail To Add login_attempts Record ');
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
	 * To update record of login_attempts table
	 * Update data of columns : 
	 * 
	 * @param arrayUserData $UserData
	 * @param bool $ThrowError Whether to throw error or not
	 * 
	 * @return bool If any error, then Throw Exception otherwise return true on success and false on failure
	 */
	public function editIPAddress($IPAddressData=null, $QueryString=null, $ThrowError=true)
	{
		
		if($QueryString)
		{
			 $Query = $QueryString ;
		}else{		
			 $UpdateData = $IPAddressData->InternalSync(RDataModel::UPDATE, "attempts","lastlogin");
			 $Query = 'UPDATE login_attempts SET '.$UpdateData.' WHERE ip = "'.$IPAddressData->ip.'"';
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
				//throw new Exception(' Fail To Edit login_attempts Record ');
				return false;
	  		}
		} catch(Exception $Exception) {
			if($ThrowError == true) {
				$ThrowException = new Exception(' Fail To Edit login_attempts Record ');
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
	 public function deleteIPAddress($ip=null,$queryString=null)
	 {
		
		if(isset($queryString) && $queryString!="")
		{
			$Query = "DELETE FROM `login_attempts` WHERE lastlogin <= DATE_SUB(NOW(), ".LOGIN_IP_TIME_PERIOD.");";
		}else
		{
			$Query ="delete from login_attempts where ip = '$ip'";
		}
		$ThrowException = null;
		try {
			$this->Connection->Execute($Query);
		} catch (Exception $Exception) {
			if($ThrowError == true) {
				$ThrowException = new Exception(' Not any Record Found For this Id :'.$ContentId."<br>");
			} else {
				return false;
			}
		}// try catch end
		//exit();	
  		
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
	public function getIPAddress($fieldArr=null, $seaArr=null, $optArr=null, $start=null, $total=null, $QueryString=null, $ThrowError=true)
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
			$Query = "SELECT $fields FROM login_attempts $whereExtra  $optstring $limitString";
		}
		//echo $Query;
		//exit;
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
				$ThrowException = new Exception(' Fail To Get Any Record of login_attempts');
			}
	    } // try -catch end
  		
	    if($QueryString!=''){
    		$UserData = array();
    		//assing all fetched records into CategoryData Object
	   	    foreach ($Rs as $Record) {
			 	$IPAddressData[]=$Record;
		    }//foreach end
	    }else{
		    //Create CategoryData Object
	   	    $IPAddressData = new RModelCollection();
	   	    
	   	    //assing all fetched records into CategoryData Object
	   	    foreach ($Rs as $Record) {
			 	$IPAddressData->Add(new IPAddressData($Record));
		    }//foreach end
	    }
	    
	    return $IPAddressData;//return the fetched recordset		
	}//getUser function end
	
	
	
	
}