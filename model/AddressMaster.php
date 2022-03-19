<?php
/**
 * This is AddressMaster file.
 * This file contains all the business logic code related to address_book table.
 * 
 * TABLE_NAME:    address_book
 * PRIMARY_KEY :  address_book_id
 * TABLE_COLUMNS: "user_id","gender","firstname","lastname","street_address","suburb","postcode","city","state","country","default_address","from_signup"
 * 
 * @uses By creating object of AddressMaster we can handle or manage different table operation like insert, update, delete and selecting data with criteria from table.
 * 
 * @package    User Address Management
 * @author     Radixweb
 * @copyright  Document Copyright information, e.g. Copyright (c) 2008, Radixweb
 * @license    Display a hyperlink to a URL for a license, e.g. http://opensource.org/licenses/gpl-license.php GNU Public License
 * @version    $Id: AddressMaster.php,v 1.0
 * @link       Display a hyperlink to a URL in the documentation, e.g. http://radixweb.com
 * @since      Document when (at which version) an element was first added to a package e.g. Version 1.0
 * 
 */

/**
 * @see AddressData.php for Data class
 */
require_once(DIR_WS_MODEL . "AddressData.php");

/**
 * @see RMasterModel.php for extended RMasterModel class
 */
require_once(DIR_LIB_CLASSES_MODELS."/RMasterModel.php");

class AddressMaster extends RMasterModel {
	/**
	 * Create a null object of FoodGlossaryMaster
	 *
	 * @return FoodGlossaryMaster $FoodGlossaryMasterObj
	 */
	public function Create() {
		$AddressMasterObj = new AddressMaster();
		return  $AddressMasterObj;
	}

	/**
	 * To insert record in address_book table
	 * Insert data of columns : "user_id","gender","firstname","lastname","street_address","suburb","postcode","city","state","country","default_address","from_signup"
	 *
	 * @param arrayAddressData $AddressData
	 * @param bool $ThrowError Whether to throw error or not
	 * 
	 * @return int If any error, then Throw Exception otherwise inserted row id
	 */
	public function addAddress($AddressData, $ThrowError=true)
	{
		//build up insert query
	 	$FinalData = $AddressData->InternalSync(RDataModel::INSERT, "user_id","account_no","firstname","lastname","street_address","suburb","postcode","city","state","state_code","country","sender_area_code","phone_number","default_address","from_signup");
	 	$Query = "INSERT INTO address_book $FinalData";
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
				throw new Exception(' Fail To Add New address_book Record');
			}
		} catch(Exception $Exception) {
			if($ThrowError == true) {
				$ThrowException = new Exception(' Fail To Add address_book Record ');
			} else {
				return false;	
			}//if-else end
		}// try -catch end

		if ($ThrowException) {
			throw $ThrowException;
		} else {
			return $this->Connection->LastInsertedId();
		}
	}//addAddress Function End

	/**
	 * To update record of address_book table
	 * Update data of columns : "user_id","gender","firstname","lastname","street_address","suburb","postcode","city","state","country","default_address","from_signup"
	 * 
	 * @param arrayAddressData $AddressData 
	 * @param bool $ThrowError Whether to throw error or not
	 * 
	 * @return bool If any error, then Throw Exception otherwise return true on success and false on failure
	 */	
	public function editAddress($AddressData=null, $ChangeProfile=null, $changeDefault=null, $ThrowError=true)
	{
		//build up update query
		if($ChangeProfile != ''){
			$UpdateData =$AddressData->InternalSync(RDataModel::UPDATE,"firstname","lastname","street_address","suburb","postcode","city","state","state_code","country","sender_area_code","phone_number","default_address","from_signup");
			$Query = "update address_book  SET $UpdateData WHERE user_id =". $AddressData->user_id." and from_signup = '1'";
		} elseif (isset($changeDefault)) {
			$Query = "update address_book SET default_address = CASE address_book_id WHEN ".$changeDefault['address_book_id']." THEN '1' ELSE '0' END where user_id=".$changeDefault['user_id'];
		} else {
			$UpdateData = $AddressData->InternalSync(RDataModel::UPDATE, "user_id","firstname","lastname","street_address","suburb","postcode","city","state","country","sender_area_code","phone_number","default_address","from_signup");         
       			$Query = "UPDATE address_book SET $UpdateData WHERE address_book_id = ". $AddressData->address_book_id;
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
				//throw new Exception(' Fail To Edit address_book Record ');
				return false;
	  		}
		} catch(Exception $Exception) {
			if($ThrowError == true) {
				$ThrowException = new Exception(' Fail To Edit address_book Record ');
			 } else {
				return false;	
			 }
    	}// try-catch end
    	
		if ($ThrowException) {
			throw $ThrowException; 
		} else {
			return true;
		}
	}//editAddress Function End

	/**
	 * To delete address_book data
	 *
	 * @param int address_book_id $address_book_id
	 * @param bool $ThrowError Whether to throw or not to throw error
	 * 
	 * @return bool If any error, then Throw Exception otherwise return true on success and false on failure
	 */
	public function deleteAddress($address_book_id, $ThrowError=true)
	{
   		if(isset($address_book_id) && ($address_book_id!=null)) {
   			//build up delete query
   			$Query ="DELETE FROM address_book WHERE address_book_id = " . $address_book_id;

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
			    	$ThrowException = new Exception(' Fail To Delete address_book Record');
				} else {
					return false;
			    }
			}// try catch end
  		} // if end
	}//deleteAddress Function End

	/**
	 * GetAddress method is used for to get all or selected columns records from address_book with searching, sorting and paging criteria.
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
	public function getAddress($fieldArr=null, $seaArr=null, $optArr=null, $start=null, $total=null, $ThrowError=true)
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
		  $Query = "SELECT $fields FROM address_book $whereExtra $optstring $limitString";
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
				$ThrowException = new Exception(' Fail To Get Any Record of address_book');
			}
	    } // try -catch end
  
	    //Create CategoryData Object
   	    $AddressData = new RModelCollection();
   	    
   	    //assing all fetched records into CategoryData Object
   	    foreach ($Rs as $Record) {
		 	$AddressData->Add(new AddressData($Record));
	    }//foreach end
	    
	    return $AddressData;//return the fetched recordset		
	}//getAddress function end
	
	public function getAddressList($option = array(), $fieldArr=null,$orderBy = null, $groupby = null, $start=null, $total=null, $ThrowError=true)
	{
		
		
		/**
		 * Table Columns
		 * If $fieldArr has null value then it will return all records otherwise entered table fields
		 * 
		 * @see below example for to create $fieldArr for to get only selected table fields data
		 * 
		 *     $fieldArr = array("col1", "col2", "col3");
		 */
		
		// Display fields
		if(is_array($fieldArr) && !empty($fieldArr)) {
			$fields = implode(", ", $fieldArr);
		} else {
			$fields = "*";
		}
		
		//Order By
		if(!empty($orderBy)){
			$sortString = " ORDER BY ".implode(", ", $orderBy);
		}
		
		//Group By
		if(!empty($groupby)){
			$groupString = " GROUP BY ".implode(", ", $groupby);
		}
		
		/**
		 * Paging
		 */
		$limitString = '';
		if(isset($total) && !is_null($total)) {
			if(is_null($start)) {
				$start = 0;
			}
			$limitString .= " LIMIT ".$total." OFFSET ".$start;
		}
			
		/**
		 *  Search as per Field
		 */
		$StrWhere = '';
		if(is_array($option) && !empty($option)) {
			
			foreach($option as $val) {
					$StrWhere .= $val;
				}
			
		}
			
		$query = "SELECT $fields FROM address_book 
					LEFT JOIN countries ON countries.countries_id = address_book.country
					WHERE 1 $StrWhere $groupString  $sortString  $limitString";
		
		try	{
			$Rs = $this->Connection->Execute($query);
			if ($Rs->RecordCount() == 0 ) { //check whether the record is found or not
				return false;
			}
		}
	    catch (Exception $Exception) {
			if($ThrowError == true) {
				$ThrowException = new Exception(' Fail To Get Any Record of Admin');
			}
	    }
	    return $Rs;
	}
}//class End