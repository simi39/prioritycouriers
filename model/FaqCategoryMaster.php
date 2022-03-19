<?php
/**
 * This is FaqCategoryMaster file.
 * This file contains all the business logic code related to faq_category table.
 * 
 * TABLE_NAME:    faq_category 
 * PRIMARY_KEY :  faqcat_id
 * TABLE_COLUMNS: "status","sort_order"
 * 
 * @uses By creating object of FaqCategoryMaster we can handle or manage different table operation like insert, update, delete and selecting data with criteria from table.
 * 
 * @package    Faq Manangement Section
 * @author     Radix
 * @copyright  Document Copyright information, e.g. Copyright (c) 2008, Radixweb
 * @license    Display a hyperlink to a URL for a license, e.g. http://opensource.org/licenses/gpl-license.php GNU Public License
 * @version    $Id: FaqCategoryMaster.php,v 1.0
 * @link       Display a hyperlink to a URL in the documentation, e.g. http://radixweb.com
 * @since      Document when (at which version) an element was first added to a package e.g. Version 1.0 
 * 
 */
 
/**
 * @see FaqCategoryData.php for Data class
 */
require_once(DIR_WS_MODEL."/FaqCategoryData.php");

/**
 * @see RMasterModel.php for extended RMasterModel class
 */
require_once(DIR_LIB_CLASSES_MODELS."/RMasterModel.php");

class FaqCategoryMaster extends RMasterModel
{	
	
	/**
	 * Create a null object of FaqCategoryMaster
	 *
	 * @return object object $FaqCategoryMasterObj
	 */	
	public function create()
	{
		$FaqCategoryMasterObj = new FaqCategoryMaster();
		return  $FaqCategoryMasterObj;
	}//create Function End
	      
	/**
	 * To insert record in faq_category table 
	 * Insert data of columns : ""status,"sort_order"
	 *
	 * @param arrayFaqCategoryData $FaqCategoryData 
	 * @param bool $ThrowError Whether to throw error or not
	 * 
	 * @return int If any error, then Throw Exception otherwise inserted row id
	 */	
	 public function addFaqCategory($FaqCategoryData, $ThrowError=true)
	 {
	 		//build up insert query
		 	$FinalData = $FaqCategoryData->InternalSync(RDataModel::INSERT, "status","sort_order");
		 	$Query = "INSERT INTO faq_category $FinalData"; 
		 	
		 	/**
			  * check that data should be inserted successfully.
			  * if no then throw or return proper error message. 
			  */
		 	$ThrowException = null;
	 		try { 
	 			
				$Rs=$this->Connection->Execute($Query);
				if ($Rs->AffectedRows() ==  0) {
					throw new Exception(' Fail To Add New faq_category Record');
				}
				
			}
			catch(Exception $Exception) {
				
				if($ThrowError == true){
					$ThrowException = new Exception(' Fail To Add faq_category Record ');
				} else {
					return false;	
				}//if-else end
				
			}// try -catch end
								
			if ($ThrowException) {
				throw $ThrowException;
			} else {
				return $this->Connection->LastInsertedId();
			}
		
	}//addFaqCategory Function End
	
	 public function addFaqCategoryDescription($SiteFaqCategoryData, $ThrowError=true)
	 {
	 		//build up insert query
		 	$FinalData = $SiteFaqCategoryData->InternalSync(RDataModel::INSERT, "faqcat_id","faq_category_name","site_language_id");
		 	$Query = "INSERT INTO faq_category_desc $FinalData"; 
		 	
		 	/**
			  * check that data should be inserted successfully.
			  * if no then throw or return proper error message. 
			  */
		 	$ThrowException = null;
	 		try { 
	 			
				$Rs=$this->Connection->Execute($Query);
				if ($Rs->AffectedRows() ==  0) {
					return false;
				}
				
			}
			catch(Exception $Exception) {
				
				if($ThrowError == true){
					$ThrowException = new Exception(' Fail To Add site_template_category_description Record ');
				} else {
					return false;	
				}//if-else end
				
			}// try -catch end
								
			if ($ThrowException) {
				throw $ThrowException;
			} else {
				return $this->Connection->LastInsertedId();
			}
		
	}//addFaqCategoryDescription Function End	
	
	/**
	 * To update record of faq_category table
	 * Update data of columns : ""status,"sort_order"
	 * 
	 * @param arrayFaqCategoryData $FaqCategoryData 
	 * @param bool $ThrowError Whether to throw error or not
	 * 
	 * @return bool If any error, then Throw Exception otherwise return true on success and false on failure
	 */	
	public function editFaqCategory($FaqCategoryData, $statusChange="", $ThrowError=true) 
	{
		//build up update query 
		if($statusChange != ""){
			$UpdateData = $FaqCategoryData->InternalSync(RDataModel::UPDATE,"status");  
		} else {
			$UpdateData = $FaqCategoryData->InternalSync(RDataModel::UPDATE,"sort_order");         
	    }		
		
       	$Query = "UPDATE faq_category SET $UpdateData WHERE faqcat_id = ". $FaqCategoryData->faqcat_id;      
       	
       	/**
		  * check that data should be updated perfectly.
		  * if no then throw or return proper error message.
		  */
		$ThrowException = null;
		try {
	  		$Rs = $this->Connection->Execute($Query);
	  		if ( $Rs->AffectedRows() == 0 )	{
				//throw new Exception(' Fail To Edit faq_category Record ');
				return false;
	  		}
		}//try end
		catch(Exception $Exception) {
			if($ThrowError == true) {
				$ThrowException = new Exception(' Fail To Edit faq_category Record ');
			 } else {
				return false;	
			 }
    	}// try-catch end
    	
		if ($ThrowException) {
			throw $ThrowException; 
		} else {
			return true;
		}
		
	}//editFaqCategory Function End
	
	
	
	public function editFaqCategoryDescription($SiteFaqCategoryData, $ThrowError=true) 
	{
		 //build up update query
		$UpdateData = $SiteFaqCategoryData->InternalSync(RDataModel::UPDATE,"faq_category_name");         
       	$Query = "UPDATE faq_category_desc SET $UpdateData WHERE faqcat_id = '". $SiteFaqCategoryData->faqcat_id ."' and site_language_id ='" .$SiteFaqCategoryData->site_language_id."' " ;      
       	
       	/**
		  * check that data should be updated perfectly.
		  * if no then throw or return proper error message.
		  */
		$ThrowException = null;
		try {
	  		$Rs = $this->Connection->Execute($Query);
	  		if ( $Rs->AffectedRows() == 0 )	{
				return false;
	  		}
		}//try end
		catch(Exception $Exception) {
			if($ThrowError == true) {
				$ThrowException = new Exception(' Fail To Edit faq_category_desc Record ');
			 } else {
				return false;	
			 }
    	}// try-catch end
    	
		if ($ThrowException) {
			throw $ThrowException; 
		} else {
			return true;
		}
		
	}//editFaqCategoryDescription Function End
		
	/**
	 * To delete faq_category data
	 *
	 * @param int faqcat_id $faqcat_id 
	 * @param bool $ThrowError Whether to throw or not to throw error
	 * 
	 * @return bool If any error, then Throw Exception otherwise return true on success and false on failure
	 */	 
	public function deleteFaqCategory($faqcat_id, $ThrowError=true) 
	{
   		if(isset($faqcat_id) && ($faqcat_id!=null)) {
 			
   			//build up delete query
   			$Query ="DELETE FROM faq_category WHERE faqcat_id = " . $faqcat_id;
   			$DesQuery ="DELETE FROM faq_category_desc WHERE faqcat_id = " . $faqcat_id;
 			
 			/**
			  * check that data should be updated perfectly.
			  * if no then throw or return proper error message. 
			  */
 			$ThrowException = null;
 			try {	
				$this->Connection->Execute($Query);
				$this->Connection->Execute($DesQuery);
				return true;
   					
			}
			catch (Exception $Exception){
				if($ThrowError == true) {
			    	$ThrowException = new Exception(' Fail To Delete faq_category Record');
				}	
			    else {
					return false;	
			    }
			}// try catch end	
    				
  		} // if end
	  		
	 }//deleteFaqCategory Function End	
	
	 
	 /**
	 * GetFaqCategory method is used for to get all or selected columns records from faq_category with searching, sorting and paging criteria.
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
	 
	 public function getFaqCategory($fieldArr=null, $seaArr=null, $optArr=null, $start=null, $total=null, $QueryString=null, $ThrowError=true, $table_name='faq_category')
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
	    	if(!empty($QueryString)){
				$Query = $QueryString;
			} else {
				$Query = "SELECT $fields FROM $table_name $whereExtra $optstring $limitString";
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
					$ThrowException = new Exception(' Fail To Get Any Record of Admin');
				}
		    } // try -catch end
	 	   if(!empty($QueryString)){
			    $FaqCategoryData = array();
			    //assing all fetched records into Array
		   	    foreach ($Rs as $Record) {
				 	$FaqCategoryData[] = $Record;
			    }//foreach end
			} else {
			    //Create CategoryData Object
		   	    $FaqCategoryData = new RModelCollection();
		   	    
		   	    //assing all fetched records into CategoryData Object
		   	    foreach ($Rs as $Record) {
				 	$FaqCategoryData->Add(new FaqCategoryData($Record));
			    }//foreach end
			}
		    
		    return $FaqCategoryData;//return the fetched recordset		
	 }//getFaqCategory function end 
	 
	 public function getSiteFaqCategoryDesc($option = array(), $fieldArr=null,$orderBy = null, $groupby = null, $start=null, $total=null, $ThrowError=true)
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
			
		$query = "select $fields from faq_category_desc LEFT JOIN faq_category ON faq_category_desc.faqcat_id = faq_category.faqcat_id WHERE 1 $StrWhere $groupString  $sortString  $limitString";
		
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