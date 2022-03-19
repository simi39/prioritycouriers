<?php
/**
 * This is TransitGuideMaster file.
 * This file contains all the business logic code related to transitguide table.
 * 
 * transitguide:    transitguide 
 * PRIMARY_KEY :  auto_id
 * TABLE_COLUMNS: "Postcode_from","Postcode_to","State","Zone","day_add"
 * 
 * @uses By creating object of TransitGuideMaster we can handle or manage different table operation like insert, update, delete and selecting data with criteria from table.
 * 
 * @package    Specify package to group classes or functions and defines into
 * @author     AUTHOR_NAME
 * @copyright  Document Copyright information, e.g. Copyright (c) 2008, Radixweb
 * @license    Display a hyperlink to a URL for a license, e.g. http://opensource.org/licenses/gpl-license.php GNU Public License
 * @version    $Id: TransitGuideMaster.php,v 1.0
 * @link       Display a hyperlink to a URL in the documentation, e.g. http://radixweb.com
 * @since      Document when (at which version) an element was first added to a package e.g. Version 1.0 
 * 
 */
 
/**
 * @see TransitGuideData.php for Data class
 */
require_once(DIR_WS_MODEL."/TransitGuideData.php");

/**
 * @see RMasterModel.php for extended RMasterModel class
 */
require_once(DIR_LIB_CLASSES_MODELS."/RMasterModel.php");

class TransitGuideMaster extends RMasterModel
{	
	
	/**
	 * Create a null object of TransitGuideMaster
	 *
	 * @return object object $TransitGuideMasterObj
	 */	
	public function create()
	{
		$TransitGuideMasterObj = new TransitGuideMaster();
		return  $TransitGuideMasterObj;
	}//create Function End
	      
	/**
	 * To insert record in transitguide table 
	 * Insert data of columns : "Postcode_from","Postcode_to","State","Zone","day_add"
	 *
	 * @param arrayTransitGuideData $TransitGuideData 
	 * @param bool $ThrowError Whether to throw error or not
	 * 
	 * @return int If any error, then Throw Exception otherwise inserted row id
	 */	
	 public function addTransitGuide($TransitGuideData, $ThrowError=true)
	 {
	 		//build up insert query
		 	$FinalData = $TransitGuideData->InternalSync(RDataModel::INSERT, "Postcode_from","Postcode_to","State","Zone","day_add");
		 	$Query = "INSERT INTO transitguide $FinalData"; 
		 	
		 	/**
			  * check that data should be inserted successfully.
			  * if no then throw or return proper error message. 
			  */
		 	$ThrowException = null;
	 		try { 
	 			
				$Rs=$this->Connection->Execute($Query);
				if ($Rs->AffectedRows() ==  0) {
					throw new Exception(' Fail To Add New transitguide Record');
				}
				
			}
			catch(Exception $Exception) {
				
				if($ThrowError == true){
					$ThrowException = new Exception(' Fail To Add transitguide Record ');
				} else {
					return false;	
				}//if-else end
				
			}// try -catch end
								
			if ($ThrowException) {
				throw $ThrowException;
			} else {
				return $this->Connection->LastInsertedId();
			}
		
	}//addTransitGuide Function End
	
	
	
	/**
	 * To update record of transitguide table
	 * Update data of columns : "Postcode_from","Postcode_to","State","Zone","day_add"
	 * 
	 * @param arrayTransitGuideData $TransitGuideData 
	 * @param bool $ThrowError Whether to throw error or not
	 * 
	 * @return bool If any error, then Throw Exception otherwise return true on success and false on failure
	 */	
	public function editTransitGuide($TransitGuideData, $ThrowError=true) 
	{
		 
		//build up update query
		$UpdateData = $TransitGuideData->InternalSync(RDataModel::UPDATE, "Postcode_from","Postcode_to","State","Zone","day_add");         
       	$Query = "UPDATE transitguide SET $UpdateData WHERE auto_id = ". $TransitGuideData->auto_id;      
       	
       	/**
		  * check that data should be updated perfectly.
		  * if no then throw or return proper error message.
		  */
		$ThrowException = null;
		try {
	  		$Rs = $this->Connection->Execute($Query);
	  		if ( $Rs->AffectedRows() == 0 )	{
				//throw new Exception(' Fail To Edit transitguide Record ');
				return false;
	  		}
		}//try end
		catch(Exception $Exception) {
			if($ThrowError == true) {
				$ThrowException = new Exception(' Fail To Edit transitguide Record ');
			 } else {
				return false;	
			 }
    	}// try-catch end
    	
		if ($ThrowException) {
			throw $ThrowException; 
		} else {
			return true;
		}
		
	}//editTransitGuide Function End
	
	
	/**
	 * To delete transitguide data
	 *
	 * @param int auto_id $auto_id 
	 * @param bool $ThrowError Whether to throw or not to throw error
	 * 
	 * @return bool If any error, then Throw Exception otherwise return true on success and false on failure
	 */	 
	public function deleteTransitGuide($auto_id, $ThrowError=true) 
	{
   		if(isset($auto_id) && ($auto_id!=null)) {
 			
   			//build up delete query
   			$Query ="DELETE FROM transitguide WHERE auto_id = " . $auto_id;
 			
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
			    	$ThrowException = new Exception(' Fail To Delete transitguide Record');
				}	
			    else {
					return false;	
			    }
			}// try catch end	
    				
  		} // if end
	  		
	 }//deleteTransitGuide Function End	
	
	 
	 /**
	 * GetTransitGuide method is used for to get all or selected columns records from transitguide with searching, sorting and paging criteria.
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
	 public function getTransitGuide($fieldArr=null, $seaArr=null, $optArr=null, $start=null, $total=null, $ThrowError=true)
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
			$Query = "SELECT $fields FROM transitguide $whereExtra $optstring $limitString";
			
			
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
					$ThrowException = new Exception(' Fail To Get Any Record of transitguide');
				}
		    } // try -catch end
	  
		    //Create CategoryData Object
	   	    $TransitGuideData = new RModelCollection();
	   	    
	   	    //assing all fetched records into CategoryData Object
	   	    foreach ($Rs as $Record) {
			 	$TransitGuideData->Add(new TransitGuideData($Record));
		    }//foreach end
		    
		    return $TransitGuideData;//return the fetched recordset		
	 }//getTransitGuide function end 
	 
	 
	
}//class End

?>