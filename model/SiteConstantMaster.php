<?php

/**
 * This is SiteConstantMaster file.
 * This file contains all the business logic code related to site_constant table.
 * 
 * TABLE_NAME:    site_constant 
 * PRIMARY_KEY :  constant_id
 * TABLE_COLUMNS: constant_name,default_value,page_group_name
 * 
 * @uses By creating object of SiteConstantMaster we can handle or manage different table operation like insert, update, delete and selecting data with criteria from table.
 * 
 * @package    Specify package to group classes or functions and defines into
 * @author     Radixweb Teams
 * @copyright  Document Copyright information, e.g. Copyright (c) 2008, Radixweb
 * @license    Display a hyperlink to a URL for a license, e.g. http://opensource.org/licenses/gpl-license.php GNU Public License
 * @version    $Id: SiteConstantMaster.php,v 1.0
 * @link       Display a hyperlink to a URL in the documentation, e.g. http://radixweb.com
 * @since      Document when (at which version) an element was first added to a package e.g. Version 1.0 
 * 
 */
 
/**
 * @see SiteConstantData.php for Data class
 */
require_once(DIR_WS_MODEL."/SiteConstantData.php");

/**
 * @see RMasterModel.php for extended RMasterModel class
 */
require_once(DIR_LIB_CLASSES_MODELS."/RMasterModel.php");

$SiteConstantMasterObj = new SiteConstantMaster();

class SiteConstantMaster extends RMasterModel
{	
	
	/**
	 * Create a null object of SiteConstantMaster
	 *
	 * @return object object $SiteConstantMasterObj
	 */	
	public function create()
	{
		$SiteConstantMasterObj = new SiteConstantMaster();
		return  $SiteConstantMasterObj;
	}//create Function End
	      
	/**
	 * To insert record in site_constant table 
	 * Insert data of columns : constant_name,default_value,page_group_name
	 *
	 * @param arraySiteConstantData $SiteConstantData 
	 * @param bool $ThrowError Whether to throw error or not
	 * 
	 * @return int If any error, then Throw Exception otherwise inserted row id
	 */	
	 public function addSiteConstant($SiteConstantData, $ThrowError=true,$from_admin=false)
	 {
	 		//build up insert query
		 $FinalData = $SiteConstantData->InternalSync(RDataModel::INSERT, "constant_name","front_group_id");
 $Query = "INSERT INTO site_constant $FinalData";
		 
		 	
		 	/**
			  * check that data should be inserted successfully.
			  * if no then throw or return proper error message. 
			  */
		 	$ThrowException = null;
	 		try { 
	 			
				$Rs=$this->Connection->Execute($Query);
				
				if($from_admin==true){
						
						$SiteConstantMasterObj = new SiteConstantMaster();
						$SiteConstantMasterObj->addSiteConstantDescription($SiteConstantData);
					}
				if ($Rs->AffectedRows() ==  0) {
					throw new Exception(' Fail To Add New site_constant Record');
				}
				
			}
			catch(Exception $Exception) {
				
				if($ThrowError == true){
					$ThrowException = new Exception(' Fail To Add site_constant Record ');
				} else {
					return false;	
				}//if-else end
				
			}// try -catch end
								
			if ($ThrowException) {
				throw $ThrowException;
			} else {
				return $this->Connection->LastInsertedId();
			}
		
	}//addSiteConstant Function End
	
	
	
	 public function addSiteConstantDescription($SiteConstantData, $ThrowError=true)
	 {
	 		//build up insert query
		 	$FinalData = $SiteConstantData->InternalSync(RDataModel::INSERT, "constant_id","constant_value","front_group_id");
 $Query = "INSERT INTO site_constant_description $FinalData"; 
		 	
		 	/**
			  * check that data should be inserted successfully.
			  * if no then throw or return proper error message. 
			  */
		 	$ThrowException = null;
	 		try { 
	 			
				$Rs=$this->Connection->Execute($Query);
				if ($Rs->AffectedRows() ==  0) {
					throw new Exception(' Fail To Add New site_constant Record');
				}
				
			}
			catch(Exception $Exception) {
				
				if($ThrowError == true){
					$ThrowException = new Exception(' Fail To Add site_constant Record ');
				} else {
					return false;	
				}//if-else end
				
			}// try -catch end
								
			if ($ThrowException) {
				throw $ThrowException;
			} else {
				return $this->Connection->LastInsertedId();
			}
		
	}//addSiteConstantDescription Function End
	
	
	
	/**
	 * To update record of site_constant table
	 * Update data of columns : constant_name,default_value,page_group_name
	 * 
	 * @param arraySiteConstantData $SiteConstantData 
	 * @param bool $ThrowError Whether to throw error or not
	 * 
	 * @return bool If any error, then Throw Exception otherwise return true on success and false on failure
	 */	
	public function editSiteConstant($SiteConstantData, $ThrowError=true,$constant_id=null) 
	{
		 
		//build up update query
		$UpdateData = $SiteConstantData->InternalSync(RDataModel::UPDATE, "constant_name","front_group_id","constant_value");   
		 if (isset($constant_id)) {
		 	   $UpdateData = $SiteConstantData->InternalSync(RDataModel::UPDATE, "constant_name","constant_value");
               $Query = "UPDATE site_constant,site_constant_description SET $UpdateData WHERE site_constant.constant_id = $constant_id AND site_constant_description.constant_id=$constant_id";
		    } else { $Query = "UPDATE site_constant,site_constant_description SET $UpdateData WHERE constant_id = ". $SiteConstantData->constant_id; 
		    }
       	     
       	
       	/**
		  * check that data should be updated perfectly.
		  * if no then throw or return proper error message.
		  */
		$ThrowException = null;
		try {
	  		$Rs = $this->Connection->Execute($Query);
	  		if ( $Rs->AffectedRows() == 0 )	{
				//throw new Exception(' Fail To Edit site_constant Record ');
				return false;
	  		}
		}//try end
		catch(Exception $Exception) {
			if($ThrowError == true) {
				$ThrowException = new Exception(' Fail To Edit site_constant Record ');
			 } else {
				return false;	
			 }
    	}// try-catch end
    	
		if ($ThrowException) {
			throw $ThrowException; 
		} else {
			return true;
		}
		
	}//editSiteConstant Function End
	
	
	
	public function editSiteConstantDescription($SiteConstantData,$ThrowError=true) 
	{

		//build up update query
		$UpdateData = $SiteConstantData->InternalSync(RDataModel::UPDATE, "constant_value","front_group_id");			       			
		$Query = "UPDATE site_constant_description SET $UpdateData WHERE constant_id = ". $SiteConstantData->constant_id ." AND front_group_id = ". $SiteConstantData->front_group_id;             	
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
		
	}//editSiteConstantDescription Function End
	
	
	
	/**
	 * To delete site_constant data
	 *
	 * @param int constant_id $constant_id 
	 * @param bool $ThrowError Whether to throw or not to throw error
	 * 
	 * @return bool If any error, then Throw Exception otherwise return true on success and false on failure
	 */	 
	public function deleteSiteConstant($constant_id, $ThrowError=true,$from_admin=false) 
	{
   		if(isset($constant_id) && ($constant_id!=null)) {
 			
   			//build up delete query
   			//$Query ="DELETE FROM site_constant WHERE constant_id = " . $constant_id;
 			 $Query ="DELETE site_constant,site_constant_description FROM site_constant INNER JOIN site_constant_description WHERE site_constant.constant_id = " . $constant_id." AND site_constant_description.constant_id = " . $constant_id ;
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
			    	$ThrowException = new Exception(' Fail To Delete site_constant Record');
				}	
			    else {
					return false;	
			    }
			}// try catch end	
    				
  		} // if end
	  		
	 }//deleteSiteConstant Function End	
	
	 
	 public function deleteSiteConstantDescription($constant_id, $ThrowError=true) 
	{
   		if(isset($constant_id) && ($constant_id!=null)) {
 			
   			//build up delete query
   			$Query ="DELETE FROM site_constant_description WHERE constant_id = " . $constant_id;
 			
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
			    	$ThrowException = new Exception(' Fail To Delete site_constant Record');
				}	
			    else {
					return false;	
			    }
			}// try catch end	
    				
  		} // if end
	  		
	 }//deleteSiteConstant Function End	
	 
	 
	 /**
	 * GetSiteConstant method is used for to get all or selected columns records from site_constant with searching, sorting and paging criteria.
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
	 public function getSiteConstant($fieldArr=null, $seaArr=null, $optArr=null, $start=null, $total=null, $ThrowError=true,$constant_id=null,$from_admin=false,$tot=null)
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
			//echo "<pre>";print_r($seaArr);exit();
		//	echo $constant_id;die();
			if (isset($constant_id)) {
			 $Query = "SELECT $fields FROM site_constant LEFT JOIN site_constant_description ON site_constant.constant_id = site_constant_description.constant_id WHERE site_constant_description.constant_id = site_constant.constant_id AND site_constant.constant_id= $constant_id  ";
			}
			else if ($from_admin==true) {
			 $Query = "SELECT $fields FROM site_constant LEFT JOIN site_constant_description ON site_constant.constant_id = site_constant_description.constant_id WHERE site_constant_description.constant_id = site_constant.constant_id $limitString" ;
			}
			else {
			  $Query = "SELECT $fields FROM site_constant $whereExtra $optstring $limitString";
			}
	
	 //echo $Query;exit(); 
			
			
			
			/**
			 * Execute Query
			 * If any error during execution of query it will return false
			 */
			try	{
				$Rs = $this->Connection->Execute($Query);
				if($tot=='find')
			    {
			    	 	return $Rs->RecordCount();	die();
			    }
				if ($Rs->RecordCount() == 0 ) { //check whether the record is found or not
					return false;
				}
			}
		    catch (Exception $Exception) {
				if($ThrowError == true) {
					$ThrowException = new Exception(' Fail To Get Any Record of site_constant');
				}
		    } // try -catch end
	  
		    //Create CategoryData Object
	   	    $SiteConstantData = new RModelCollection();
	   	    
	   	    //assing all fetched records into CategoryData Object
	   	    foreach ($Rs as $Record) {
			 	$SiteConstantData->Add(new SiteConstantData($Record));
		    }//foreach end
		    
		    return $SiteConstantData;//return the fetched recordset		
	 }//getSiteConstant function end 
	 
	 
	 
	 
	 
	 public function getSiteConstantDescription($fieldArr=null, $seaArr=null, $optArr=null, $start=null, $total=null, $ThrowError=true,$constant_id=null)
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
			//echo "<pre>";print_r($seaArr);exit();
			
			  $Query = "SELECT $fields FROM site_constant_description $whereExtra $optstring $limitString";
			 
			// echo $Query;//exit(); 
			
			
			
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
					$ThrowException = new Exception(' Fail To Get Any Record of site_constant');
				}
		    } // try -catch end
	  
		    //Create CategoryData Object
	   	    $SiteConstantData = new RModelCollection();
	   	    
	   	    //assing all fetched records into CategoryData Object
	   	    foreach ($Rs as $Record) {
			 	$SiteConstantData->Add(new SiteConstantData($Record));
		    }//foreach end
		    
		    return $SiteConstantData;//return the fetched recordset		
	 }//getSiteConstant function end 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 /**
	 * GetCmsPages method is used for to get values for the metatags
	 * @param int integer $start  Starting point to fetch data rows. e.g. $start = 10 then will start fetch rows from 10th row.
	 * @param int integer $total  Total number of rows to display on one page. e.g. $total = 20 then will display 20 records on one page
	 * @param bool $ThrowError Whether to throw error or not
	 * @return array array $ret contains all the record sets by applying searching, sorting, paging criteria.
	 * 
	 */
	public function getSiteConstantDetails($option=array(), $fieldArr=null,$orderBy = null, $start=null, $total=null, $ThrowError=true, $language_id=null,$from_admin=false,$seaArr=null)
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
			
			
			
			
			
			if(!empty($language_id)) {
				$StrOnWhere = 'AND site_constant_description.front_group_id='.$language_id;
			}
			
			if($from_admin==true)
			{
			 $Query = "SELECT $fields FROM site_constant_description $whereExtra ";
			
			}else{
					$Query = "SELECT $fields FROM site_constant
						LEFT JOIN  site_constant_description ON site_constant_description.constant_id = site_constant.constant_id $StrOnWhere
					 	WHERE 1 " . $StrWhere . $sortString . $limitString;
			
				
			}
			

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
	
	function get_file_constants_list($filename, $language_id, $fieldArr=null) {
		
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
			
			$Query = "SELECT $fields FROM site_front_pages 
					LEFT JOIN site_constant ON site_constant.front_group_id = site_front_pages.front_group_id OR site_constant.front_group_id =1
					LEFT JOIN site_constant_description ON site_constant_description.constant_id = site_constant.constant_id 
					WHERE site_front_pages.front_pages_name = '" . $filename . "' AND site_constant_description.front_group_id =".$language_id;
			
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
	
}//class End

?>