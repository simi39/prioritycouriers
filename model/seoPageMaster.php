<?php
/**
 * This is seoPageMaster file.
 * This file contains all the business logic code related to site_seo and site_seo_description table.
 * 
 * TABLE_NAME:    site_seo,site_seo_description
 * PRIMARY_KEY :  page_id
 * TABLE_COLUMNS: "page_name","page_title","page_keywords","page_description","site_language_id"
 * 
 * @uses By creating object of seoPageMaster we can handle or manage different table operation like insert, update, delete and selecting data with criteria from table.
 * 
 * @package    Seo Pages Management
 * @author     Radixweb
 * @copyright  Document Copyright information, e.g. Copyright (c) 2008, Radixweb
 * @license    Display a hyperlink to a URL for a license, e.g. http://opensource.org/licenses/gpl-license.php GNU Public License
 * @version    $Id: seoPageMaster.php,v 1.0
 * @link       Display a hyperlink to a URL in the documentation, e.g. http://radixweb.com
 * @since      Document when (at which version) an element was first added to a package e.g. Version 1.0
 * 
 */

/**
 * @see seoPageData.php for Data class
 */
require_once(DIR_WS_MODEL . "seoPageData.php");

/**
 * @see RMasterModel.php for extended RMasterModel class
 */
require_once(DIR_LIB_CLASSES_MODELS."/RMasterModel.php");

class seoPageMaster extends RMasterModel
{
	/**
	 * Create a null object of seoPageMaster
	 *
	 * @return object object $seoPageMasterObj
	 */
	public function create()
	{
		$seoPageMasterObj = new seoPageMaster();
		return  $seoPageMasterObj;
	}//create Function End

	/**
	 * To insert record in seo_page_master table
	 * Insert data of columns : "page_name","page_title","page_keywords","page_description"
	 *
	 * @param arrayseoPageData $seoPageData
	 * @param bool $ThrowError Whether to throw error or not
	 * 
	 * @return int If any error, then Throw Exception otherwise inserted row id
	 */
	 public function addseoPage($seoPageData, $ThrowError=true)
	 {
		//build up insert query
	 	$FinalData = $seoPageData->InternalSync(RDataModel::INSERT, "page_name");
	 	$Query = "INSERT INTO site_seo $FinalData";

	 	/**
		  * check that data should be inserted successfully.
		  * if no then throw or return proper error message. 
		  */
	 	$ThrowException = null;
 		try {
			$Rs=$this->Connection->Execute($Query);
			if ($Rs->AffectedRows() ==  0) {
				throw new Exception(' Fail To Add New site_seo Record');
			}
		} catch(Exception $Exception) {
			if($ThrowError == true) {
				$ThrowException = new Exception(' Fail To Add site_seo Record ');
			} else {
				return false;
			}//if-else end
		}// try -catch end

		if ($ThrowException) {
			throw $ThrowException;
		} else {
			return $this->Connection->LastInsertedId();
		}
	}//addseoPage Function End

	
	/**
	 * To insert record in seo_page_master table
	 * Insert data of columns : "page_name","page_title","page_keywords","page_description"
	 *
	 * @param arrayseoPageData $seoPageData
	 * @param bool $ThrowError Whether to throw error or not
	 * 
	 * @return int If any error, then Throw Exception otherwise inserted row id
	 */
	 public function addseoPageDescription($seoPageData, $ThrowError=true)
	 {
		//build up insert query
	 	$FinalData = $seoPageData->InternalSync(RDataModel::INSERT, "page_id","seo_page_title","seo_page_keywords","seo_page_description","site_language_id");
	 	$Query = "INSERT INTO site_seo_description $FinalData";

	 	/**
		  * check that data should be inserted successfully.
		  * if no then throw or return proper error message. 
		  */
	 	$ThrowException = null;
 		try {
			$Rs=$this->Connection->Execute($Query);
			if ($Rs->AffectedRows() ==  0) {
				throw new Exception(' Fail To Add New site_seo_description Record');
			}
		} catch(Exception $Exception) {
			if($ThrowError == true) {
				$ThrowException = new Exception(' Fail To Add site_seo_description Record ');
			} else {
				return false;
			}//if-else end
		}// try -catch end

		if ($ThrowException) {
			throw $ThrowException;
		} else {
			return $this->Connection->LastInsertedId();
		}
	}//addseoPage Function End
	
	
	/**
	 * To update record of seo_page_master table
	 * Update data of columns : "page_name","page_title","page_keywords","page_description"
	 * 
	 * @param arrayseoPageData $seoPageData 
	 * @param bool $ThrowError Whether to throw error or not
	 * 
	 * @return bool If any error, then Throw Exception otherwise return true on success and false on failure
	 */
	public function editseoPage($seoPageData, $ThrowError=true)
	{
		//build up update query
		$UpdateData = $seoPageData->InternalSync(RDataModel::UPDATE, "page_name");
       	$Query = "UPDATE site_seo SET $UpdateData WHERE page_id = ". $seoPageData->page_id;

       	/**
		  * check that data should be updated perfectly.
		  * if no then throw or return proper error message.
		  */
		$ThrowException = null;
		try {
	  		$Rs = $this->Connection->Execute($Query);
	  		if ( $Rs->AffectedRows() == 0 )	{
				//throw new Exception(' Fail To Edit seo_page_master Record ');
				return false;
	  		}
		} catch(Exception $Exception) {
			if($ThrowError == true) {
				$ThrowException = new Exception(' Fail To Edit site_seo Record ');
			 } else {
				return false;
			 }
    	}// try-catch end

		if ($ThrowException) {
			throw $ThrowException;
		} else {
			return true;
		}
	}//editseoPage Function End
	
	
	
	/**
	 * To update record of seo_page_master table
	 * Update data of columns : "page_name","page_title","page_keywords","page_description"
	 * 
	 * @param arrayseoPageData $seoPageData 
	 * @param bool $ThrowError Whether to throw error or not
	 * 
	 * @return bool If any error, then Throw Exception otherwise return true on success and false on failure
	 */
	public function editseoPageDescription($seoPageData, $ThrowError=true)
	{
		//build up update query
		$UpdateData = $seoPageData->InternalSync(RDataModel::UPDATE, "seo_page_title","seo_page_keywords","seo_page_description");
       	$Query = "UPDATE site_seo_description SET $UpdateData WHERE site_language_id =".$seoPageData->site_language_id." and page_id = ". $seoPageData->page_id;

       	/**
		  * check that data should be updated perfectly.
		  * if no then throw or return proper error message.
		  */
		$ThrowException = null;
		try {
	  		$Rs = $this->Connection->Execute($Query);
	  		if ( $Rs->AffectedRows() == 0 )	{
				//throw new Exception(' Fail To Edit seo_page_master Record ');
				return false;
	  		}
		} catch(Exception $Exception) {
			if($ThrowError == true) {
				$ThrowException = new Exception(' Fail To Edit site_seo_description Record ');
			 } else {
				return false;
			 }
    	}// try-catch end

		if ($ThrowException) {
			throw $ThrowException;
		} else {
			return true;
		}
	}//editseoPage Function End
	
	

	/**
	 * To delete seo_page_master data
	 *
	 * @param int page_id $page_id
	 * @param bool $ThrowError Whether to throw or not to throw error
	 * 
	 * @return bool If any error, then Throw Exception otherwise return true on success and false on failure
	 */
	
	public function deleteseoPage($page_id, $ThrowError=true) 
	{
   		if(isset($page_id) && ($page_id!=null)) {
   			//build up delete query
   			$Query ="DELETE FROM site_seo WHERE page_id = " . $page_id;
			//build up delete query from faq_description
   			$SEO_DES_Query ="DELETE FROM site_seo_description WHERE page_id = " . $page_id;
 			/**
			  * check that data should be updated perfectly.
			  * if no then throw or return proper error message.
			  */
 			$ThrowException = null;
 			try {
				$this->Connection->Execute($Query);
				$this->Connection->Execute($SEO_DES_Query);
				return true;
			} catch (Exception $Exception) {
				if($ThrowError == true) {
			    	$ThrowException = new Exception(' Fail To Delete site_seo Record');
				} else {
					return false;
			    }
			}// try catch end
  		} // if end
	 }//deleteSeo Function End
	 
	 
	 /**
	 * Get Page details from id
	 *
	 * @param int $Option
	 * 
	 * @param bool $ThrowError Whether to throw or not to throw error
	 * 
	 * @return country data
	 */
	public function getseoData($Option,$ThrowError=true)
	{
//start
      $Query = "select * from page_master where 1 ";
	  if($Option['page_id'] != null && $Option['page_id'] != "")
		{
			$Query.=" and page_id = '".$Option['page_id']."'";
		}
		if($Option['page_name'] != null && $Option['page_name'] != "")
		{
			$Query.=" and page_name = '".$Option['page_name']."' or page_name='Standard'";
		}	
			$Query .= " ORDER BY page_id DESC ";
			
			$ThrowException = null;
		 	try {
				$Rs = $this->Connection->Execute($Query);
				if ($Rs->RecordCount() == 0 )
				{ 	return false;
				}
		 	 }
		 	 catch (Exception $Exception){
						if($ThrowError == true) {
								return false;
						}
			}// try-catch end
			if ($ThrowException) {
				throw $ThrowException;
			}//if  end
		
			return($Rs[0]);

	}//Function End
	 
	 
	
	 /**
	 * GetseoPage method is used for to get all or selected columns records from seo_page_master with searching, sorting and paging criteria.
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
	public function getseoPage($fieldArr=null, $seaArr=null, $optArr=null, $start=null, $total=null, $QueryString=null, $ThrowError=true)
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
		if(!empty($QueryString)){
			$Query = $QueryString;
		} else {
			$Query = "SELECT $fields FROM site_seo $whereExtra $optstring $limitString";
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
				$ThrowException = new Exception(' Fail To Get Any Record of site_seo');
			}
	    } // try -catch end
	  
	    //Create CategoryData Object
		if(!empty($QueryString)){
		    $seoPageData = array();
		    //assing all fetched records into Array
	   	    foreach ($Rs as $Record) {
			 	$seoPageData[] = $Record;
		    }//foreach end
		} else {
		    $seoPageData = new RModelCollection();
		    
		    //assing all fetched records into CategoryData Object
		    foreach ($Rs as $Record) {
		 		$seoPageData->Add(new seoPageData($Record));
	    	}//foreach end
		}

	    return $seoPageData;//return the fetched recordset		
	}//getseoPage function end 
	
	
	
	/**
	 * GetseoPage method is used for to get all or selected columns records from seo_page_master with searching, sorting and paging criteria.
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
	public function getseoPageDescription($fieldArr=null, $seaArr=null, $optArr=null, $start=null, $total=null, $QueryString=null, $ThrowError=true)
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
		if(!empty($QueryString)){
			$Query = $QueryString;
		} else {
			$Query = "SELECT $fields FROM site_seo_description $whereExtra $optstring $limitString";
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
				$ThrowException = new Exception(' Fail To Get Any Record of site_seo_description');
			}
	    } // try -catch end
	  
	    //Create CategoryData Object
		if(!empty($QueryString)){
		    $seoPageData = array();
		    //assing all fetched records into Array
	   	    foreach ($Rs as $Record) {
			 	$seoPageData[] = $Record;
		    }//foreach end
		} else {
		    $seoPageData = new RModelCollection();
		    
		    //assing all fetched records into CategoryData Object
		    foreach ($Rs as $Record) {
		 		$seoPageData->Add(new seoPageData($Record));
	    	}//foreach end
		}

	    return $seoPageData;//return the fetched recordset		
	}//getseoPage function end 

	public function getseoPageListing($from=0,$to=9)
	{
		$limit = "";
		if($from!="" && $to!=""){
			$limit = "LIMIT $from,$to";
		}
		$Query = "SELECT * FROM site_seo
                    INNER JOIN site_seo_description ON (site_seo.page_id = site_seo_description.page_id)
                    WHERE site_language_id ='".SITE_LANGUAGE_ID."' ORDER BY site_seo.page_id  $limit";
		try	{
			$Rs = $this->Connection->Execute($Query);
			if ($Rs->RecordCount() == 0 ) { //check whether the record is found or not
				return false;
			}
		} catch (Exception $Exception) {
			if($ThrowError == true) {
				$ThrowException = new Exception(' Fail To Get Any Record of site_seo_description');
			}
	    } // try -catch end
	    return $Rs;
	}
	
	
	public function getSeoPageDetails($option=array(), $fieldArr=null,$orderBy = null, $start=null, $total=null, $ThrowError=true)
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
			
			$Query = "SELECT $fields FROM site_seo
						LEFT JOIN site_seo_description on site_seo_description.page_id = site_seo.page_id 
					 	WHERE 1 " . $StrWhere . $sortString . $limitString;
			
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
	}//getseoPageDetails end
	
	
	/**
	 * get page titles for dropdown in seo action page
	 *
	 * @param array $option for passing search array
	 * @param array $fieldArr for no fields to be retieved
	 * @param array $orderBy
	 * @param int $start
	 * @param int $total
	 * @param bool $ThrowError Whether to throw error or not
	 * @return array that return all the page titles required for seo
	 */
		public function getSeoPageTitles($option=array(), $fieldArr=null,$orderBy = null, $start=null, $total=null, $ThrowError=true)
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
			else {
				$StrWhere =" AND page_id NOT 
						IN (SELECT page_id FROM site_seo_description)";
			}
			
			
			$Query = " SELECT *FROM site_seo WHERE 1 " . $StrWhere . $sortString . $limitString;
			
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
	}
	//getseoPagetitles end
	
}//class End