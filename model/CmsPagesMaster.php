<?php

/**
 * This is CmsPagesMaster file.
 * This file contains all the business logic code related to cms_pages table.
 * 
 * TABLE_NAME:    cms_pages 
 * PRIMARY_KEY :  page_id
 * TABLE_COLUMNS: "page_name","status"
 * 
 * @uses By creating object of CmsPagesMaster we can handle or manage different table operation like insert, update, delete and selecting data with criteria from table.
 * 
 * @package    Content Management System
 * @author     Radix
 * @copyright  Document Copyright information, e.g. Copyright (c) 2008, Radixweb
 * @license    Display a hyperlink to a URL for a license, e.g. http://opensource.org/licenses/gpl-license.php GNU Public License
 * @version    $Id: CmsPagesMaster.php,v 1.0
 * @link       Display a hyperlink to a URL in the documentation, e.g. http://radixweb.com
 * @since      Document when (at which version) an element was first added to a package e.g. Version 1.0 
 * 
 */
 
/**
 * @see CmsPagesData.php for Data class
 */
require_once(DIR_WS_MODEL."/CmsPagesData.php");

/**
 * @see RMasterModel.php for extended RMasterModel class
 */
require_once(DIR_LIB_CLASSES_MODELS."/RMasterModel.php");

class CmsPagesMaster extends RMasterModel
{	
	
	/**
	 * Create a null object of CmsPagesMaster
	 *
	 * @return object object $CmsPagesMasterObj
	 */	
	public function create()
	{
		$CmsPagesMasterObj = new CmsPagesMaster();
		return  $CmsPagesMasterObj;
	}//create Function End
	      
	/**
	 * To insert record in cms_pages table 
	 * Insert data of columns : "page_name","status"
	 *
	 * @param arrayCmsPagesData $CmsPagesData 
	 * @param bool $ThrowError Whether to throw error or not
	 * 
	 * @return int If any error, then Throw Exception otherwise inserted row id
	 */	
	 public function addCmsPages($CmsPagesData, $ThrowError=true)
	 {
	 		//build up insert query
 		 	$FinalData = $CmsPagesData->InternalSync(RDataModel::INSERT, "page_name","status","allow_delete");
		 	$Query = "INSERT INTO cms_pages $FinalData"; 
		 	
		 	/**
			  * check that data should be inserted successfully.
			  * if no then throw or return proper error message. 
			  */
		 	$ThrowException = null;
	 		try { 
	 			
				$Rs=$this->Connection->Execute($Query);
				if ($Rs->AffectedRows() ==  0) {
					throw new Exception(' Fail To Add New cms_pages Record');
				}
				
			}
			catch(Exception $Exception) {
				
				if($ThrowError == true){
					$ThrowException = new Exception(' Fail To Add cms_pages Record ');
				} else {
					return false;	
				}//if-else end
				
			}// try -catch end
								
			if ($ThrowException) {
				throw $ThrowException;
			} else {
				return $this->Connection->LastInsertedId();
			}
		
	}//addCmsPages Function End
	
	
	 public function addCmsPagesDescription($CmsPagesData, $ThrowError=true)
	 {
	 		//build up insert query
		 	$FinalData = $CmsPagesData->InternalSync(RDataModel::INSERT, "page_id","site_language_id","page_heading","page_content","seo_page_title","seo_page_keywords","seo_page_description");
		 	$Query = "INSERT INTO cms_pages_description $FinalData"; 
		 	
		 	/**
			  * check that data should be inserted successfully.
			  * if no then throw or return proper error message. 
			  */
		 	$ThrowException = null;
	 		try { 
	 			
				$Rs=$this->Connection->Execute($Query);
				if ($Rs->AffectedRows() ==  0) {
					throw new Exception(' Fail To Add New cms_pages Record');
				}
				
			}
			catch(Exception $Exception) {
				
				if($ThrowError == true){
					$ThrowException = new Exception(' Fail To Add cms_pages Record ');
				} else {
					return false;	
				}//if-else end
				
			}// try -catch end
								
			if ($ThrowException) {
				throw $ThrowException;
			} else {
				return $this->Connection->LastInsertedId();
			}
		
	}//addCmsPagesDescription Function End

	
	
	/**
	 * To update record of cms_pages table
	 * Update data of columns : "page_name","status"
	 * 
	 * @param arrayCmsPagesData $CmsPagesData 
	 * @param bool $ThrowError Whether to throw error or not
	 * 
	 * @return bool If any error, then Throw Exception otherwise return true on success and false on failure
	 */	
	public function editCmsPages($CmsPagesData, $statusChange=null, $ThrowError=true) 
	{
		 
		//build up update query
		if($statusChange == true) {
 			$UpdateData = $CmsPagesData->InternalSync(RDataModel::UPDATE, "status");
 		} else {
			$UpdateData = $CmsPagesData->InternalSync(RDataModel::UPDATE, "page_name","status");
	        	
 		}
 		$Query = "UPDATE cms_pages SET $UpdateData WHERE page_id = ". $CmsPagesData->page_id;
       	/**
		  * check that data should be updated perfectly.
		  * if no then throw or return proper error message.
		  */
		$ThrowException = null;
		try {
	  		$Rs = $this->Connection->Execute($Query);
	  		if ( $Rs->AffectedRows() == 0 )	{
				//throw new Exception(' Fail To Edit cms_pages Record ');
				return false;
	  		}
		}//try end
		catch(Exception $Exception) {
			if($ThrowError == true) {
				$ThrowException = new Exception(' Fail To Edit cms_pages Record ');
			 } else {
				return false;	
			 }
    	}// try-catch end
    	
		if ($ThrowException) {
			throw $ThrowException; 
		} else {
			return true;
		}
		
	}//editCmsPages Function End
	
	
	public function editCmsPagesDescription($CmsPagesData, $ThrowError=true) 
	{
		 
		//build up update query
		$UpdateData = $CmsPagesData->InternalSync(RDataModel::UPDATE, "site_language_id","page_heading","page_content","seo_page_title","seo_page_keywords","seo_page_description");		
	    $Query = "UPDATE cms_pages_description SET $UpdateData WHERE page_id = ". $CmsPagesData->page_id ." AND site_language_id = ". $CmsPagesData->site_language_id;      
//exit;
       	/**
		  * check that data should be updated perfectly.
		  * if no then throw or return proper error message.
		  */
		$ThrowException = null;
		try {
	  		$Rs = $this->Connection->Execute($Query);
	  		if ( $Rs->AffectedRows() == 0 )	{
				//throw new Exception(' Fail To Edit cms_pages Record ');
				return false;
	  		}
		}//try end
		catch(Exception $Exception) {
			if($ThrowError == true) {
				$ThrowException = new Exception(' Fail To Edit cms_pages Record ');
			 } else {
				return false;	
			 }
    	}// try-catch end
    	
		if ($ThrowException) {
			throw $ThrowException; 
		} else {
			return true;
		}
		
	}//editCmsPages Function End

	
	/**
	 * To delete cms_pages data
	 *
	 * @param int page_id $page_id 
	 * @param bool $ThrowError Whether to throw or not to throw error
	 * 
	 * @return bool If any error, then Throw Exception otherwise return true on success and false on failure
	 */	 
	public function deleteCmsPages($page_id, $ThrowError=true) 
	{
   		if(isset($page_id) && ($page_id!=null)) {
 			
   			//build up delete query
   			$Query ="DELETE FROM cms_pages WHERE page_id = " . $page_id;
 			
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
			    	$ThrowException = new Exception(' Fail To Delete cms_pages Record');
				}	
			    else {
					return false;	
			    }
			}// try catch end	
    				
  		} // if end
	  		
	 }//deleteCmsPages Function End	
	
	 
	public function deleteCmsPagesDescription($page_id, $ThrowError=true) 
	{
   		if(isset($page_id) && ($page_id!=null)) {
 			
   			//build up delete query   			
   			$Query ="DELETE FROM cms_pages_description WHERE page_id = " . $page_id;
 			
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
			    	$ThrowException = new Exception(' Fail To Delete cms_pages Record');
				}	
			    else {
					return false;	
			    }
			}// try catch end	
    				
  		} // if end
	  		
	 }//deleteCmsPages Function End	
	 	 
	 /**
	 * GetCmsPages method is used for to get all or selected columns records from cms_pages with searching, sorting and paging criteria.
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
	 public function getCmsPages($fieldArr=null, $seaArr=null, $optArr=null, $start=null, $total=null, $QueryString=null , $TableName=null, $ThrowError=true)
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
				$Query = "SELECT $fields FROM $TableName $whereExtra $optstring $limitString";			
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
					$ThrowException = new Exception(' Fail To Get Any Record of cms_pages');
				}
		    } // try -catch end
	  
		    //Create CategoryData Object
	   	    $CmsPagesData = new RModelCollection();
	   	    
	   	    //assing all fetched records into CategoryData Object
	   	    foreach ($Rs as $Record) {
			 	$CmsPagesData->Add(new CmsPagesData($Record));
		    }//foreach end
		    
		    return $CmsPagesData;//return the fetched recordset		
	 }//getCmsPages function end 

	public function getCmsDetails ($fieldArr,$page_id=null,$language=null)
	{
		if(is_array($fieldArr) && !empty($fieldArr)) {
			$fields = implode(", ", $fieldArr);
		} else {
			$fields = "*";
		}
		
		if ($page_id != "" && $language != "")
		{
			$Query  = "SELECT $fields FROM cms_pages_description 
						WHERE cms_pages_description.site_language_id = " . $language . " AND cms_pages_description.page_id = '$page_id' ";
		} elseif ($page_id) {
			$Query = 'select '.$fields.'  from cms_pages left 
						join cms_pages_description on cms_pages_description.page_id = cms_pages.page_id where cms_pages.page_id = ' . $page_id ;
		} else {
			$Query = "select $fields from cms_pages left join cms_pages_description on cms_pages.page_id = cms_pages_description.page_id GROUP BY cms_pages.page_id";
		}

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
	
	/**
	 * GetCmsPages method is used for to get values for the metatags
	 * @param int integer $start  Starting point to fetch data rows. e.g. $start = 10 then will start fetch rows from 10th row.
	 * @param int integer $total  Total number of rows to display on one page. e.g. $total = 20 then will display 20 records on one page
	 * @param bool $ThrowError Whether to throw error or not
	 * @return array array $ret contains all the record sets by applying searching, sorting, paging criteria.
	 * 
	 */
	public function getCmsPagesDetails($option=array(), $fieldArr=null,$orderBy = null, $start=null, $total=null, $ThrowError=true)
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
				$limitString .= "LIMIT ".$total." OFFSET ".$start;
			}
			
			if(is_array($option) && !empty($option)) {
				foreach($option as $val) {
					$StrWhere .= $val;
				}
			}
			
		    $Query = "SELECT $fields FROM cms_pages
						LEFT JOIN  cms_pages_description ON cms_pages_description.page_id = cms_pages.page_id 
					 	WHERE 1 " . $StrWhere . $sortString . $limitString;
		
			//echo $Query;
			//exit();
			$ThrowException = null;
			try	{
				$Rs = $this->Connection->Execute($Query); 
				if ($Rs->RecordCount() == 0 ) {
					return false;
				}
			}
			catch (Exception $Exception) {
				if($ThrowError == true) {
					$ThrowException = new Exception(' No Record Found For:'.$product_id."<br>".$Rs);
				} else {
					return false;	
				}// if -else end
				
			}//try-catch end	
						
			return $Rs;
	}//getCmsPagesDetails end
	
}//class End