<?php
/**
  * This is NewsMaster file.  
  * This file contains all the business logic code related to news table.  
  *   
  * TABLE_NAME:    news   
  * PRIMARY_KEY :  news_id  
  * TABLE_COLUMNS: "newscat_id","status","sort_order"  
  *   
  * @uses By creating object of NewsMaster we can handle or manage different table operation like insert, update, delete and selecting data with criteria from table.  
  *   
  * @package    Specify package to group classes or functions and defines into  
  * @author     AUTHOR_NAME  
  * @copyright  Document Copyright information, e.g. Copyright (c) 2008, Radixweb  
  * @license    Display a hyperlink to a URL for a license, e.g. http://opensource.org/licenses/gpl-license.php GNU Public License  
  * @version    $Id: NewsMaster.php,v 1.0  
  * @link       Display a hyperlink to a URL in the documentation, e.g. http://radixweb.com  
  * @since      Document when (at which version) an element was first added to a package e.g. Version 1.0   
  *   
  */   
  /**  
  * @see NewsData.php for Data class  */ 
  require_once(DIR_WS_MODEL."/NewsData.php");  
  /**  
  * @see RMasterModel.php for extended RMasterModel class  */

  require_once(DIR_LIB_CLASSES_MODELS."/RMasterModel.php"); 

  class NewsMaster extends RMasterModel 
  {     
  /**   
  * Create a null object of NewsMaster   
  *  
  * @return object object $NewsMasterObj   */  
   public function create()  
   {   
  		$NewsMasterObj = new NewsMaster();   
		return  $NewsMasterObj;  
   }
   //create Function End          
   /**  
   * To insert record in news table   
   * Insert data of columns : "newscat_id","status","sort_order"   
   *   
   * @param arrayNewsData $NewsData   
   * @param bool $ThrowError Whether to throw error or not   
   *    
   * @return int If any error, then Throw Exception otherwise inserted row id  
   */
   
	public function addNews($NewsData, $ThrowError=true)   
	{    
		 //build up insert query     
		 $FinalData = $NewsData->InternalSync(RDataModel::INSERT, "newscat_id","status","sort_order");     
		 $Query = "INSERT INTO news $FinalData";           
		 /**
		 * check that data should be inserted successfully.      
		 * if no then throw or return proper error message.       
		 */     
		 $ThrowException = null;     
		 
		 try 
		 {            
		 		$Rs=$this->Connection->Execute($Query);     
		 		
		 		if ($Rs->AffectedRows() ==  0) 
		 		{      
		 			throw new Exception(' Fail To Add New news Record');    
		 		}         
		 }    
		 catch(Exception $Exception) 
		 {          
			if($ThrowError == true)
			{      
				$ThrowException = new Exception(' Fail To Add news Record ');     
			} 
			else 
			{      
				return false;      
			}//if-else end         
		}// try -catch end             
		if ($ThrowException) 
		{
		     throw $ThrowException;    
		} 
		else
		{
		     return mysql_insert_id();    
		}     
	}//addNews Function End        
	/**   
	* To update record of news table   
	* Update data of columns : "newscat_id","status","sort_order"   
	*    
	* @param arrayNewsData $NewsData    
	* @param bool $ThrowError Whether to throw error or not   
	*    
	* @return bool If any error, then Throw Exception otherwise return true on success and false on failure   */

	public function editNews($NewsData, $ThrowError=true)   
	{       
	//build up update query  
	
	if($statusChange != ""){
			$UpdateData = $NewsData->InternalSync(RDataModel::UPDATE,"status");  
		} else {
			$UpdateData = $NewsData->InternalSync(RDataModel::UPDATE,"newscat_id","sort_order");         
	    }		
		//$UpdateData = $NewsData->InternalSync(RDataModel::UPDATE, "newscat_id","status","sort_order");
		$Query = "UPDATE news SET $UpdateData WHERE news_id = ". $NewsData->news_id;
		
		/**     
		* check that data should be updated perfectly.     
		* if no then throw or return proper error message.     */
		$ThrowException = null;  
		try 
		{
		      $Rs = $this->Connection->Execute($Query);
		      if ( $Rs->AffectedRows() == 0 ) 
		      {     
		      		//throw new Exception(' Fail To Edit news Record ');
		      		return false;
		      }  
		}//try end   
		catch(Exception $Exception)
		{
		    if($ThrowError == true) 
		    {
		         $ThrowException = new Exception(' Fail To Edit news Record ');
			} else 
			{     return false;      }      
		}// try-catch end
		if ($ThrowException)
		{
		    throw $ThrowException;    
		} 		    
		else 
		{		    return true;   }     
	}//editNews Function End      
	
/**
* To delete news data   
*   
* @param int news_id $news_id    
* @param bool $ThrowError Whether to throw or not to throw error   
*    
* @return bool If any error, then Throw Exception otherwise return true on success and false on failure   
*/    
public function deleteNews($news_id, $ThrowError=true)
{
      if(isset($news_id) && ($news_id!=null))
      {            //build up delete query
			$Query ="DELETE FROM news WHERE news_id = " . $news_id;
   			$DesQuery ="DELETE FROM news_description WHERE news_id = " . $news_id;
			/**
			* check that data should be updated perfectly.      
			* if no then throw or return proper error message.       */     
			$ThrowException = null;     
			try 
			{
			      $this->Connection->Execute($Query);
			      return true;             
			}    
			catch (Exception $Exception)
			{
			     if($ThrowError == true) 
			     {
			              $ThrowException = new Exception(' Fail To Delete news Record');     
			     }         
			     else 
			     {      return false;         }    
			}// try catch end               
			     
		} // if end         
}//deleteNews Function End         


/**   
* GetNews method is used for to get all or selected columns records from news with searching, sorting and paging criteria.   
*   
* @param array array $fieldArr contains table field name   
* @param array array $seaArr contains 7 elements are   
*     "Search_On"    = Field name on which search the data   
*     "Search_Value" = Value which is compared with field defined in "Search_On"             
*     "Equation"     = Equation like '=','LIKE','BETWEEN' and so on.   
*     "Type"         = Field Type like 'string' and 'int' only. apply "string" for all except int, double, long double etc.   
*     "CondType"   = Condition Type like "AND", "OR"   
*     "Prefix"    = Prefix may be blank '' or "("   
*     "Postfix"    = Postfix may be blank '' or ")"      
* @param array array $optArr contains 2 elements are    
*     "Order_By"     = Field Name of table for sorting    
*     "Order_Type"   = Sorting Type like 'ASC', 'DESC'   
* @param int integer $start  Starting point to fetch data rows. e.g. $start = 10 then will start fetch rows from 10th row.   
* @param int integer $total  Total number of rows to display on one page. e.g. $total = 20 then will display 20 records on one page   
* @param bool $ThrowError Whether to throw error or not   
* @return array array $ret contains all the record sets by applying searching, sorting, paging criteria.   
*    
*/

public function getNews($fieldArr=null, $seaArr=null, $optArr=null, $start=null, $total=null, $ThrowError=true,$table_name='news')   
{       
	/**     
	* Table Columns     
	* If $fieldArr has null value then it will return all records otherwise entered table fields     
	*      
	* @see below example for to create $fieldArr for to get only selected table fields data     
	*      
	*     $fieldArr = array("col1", "col2", "col3");     */
	if(is_array($fieldArr) && !empty($fieldArr)) 
	{
	     $fields = implode(", ", $fieldArr);    
	} 
	else
	{
	     $fields = "*";    
	}
	/**
	* Searching criteria (where condition build up)      
	*       
	* @see below example for how to create $seaArr for multiple condition     
	*      
	*   'col1 = 1 AND (col2 LIKE "str2" OR col3 LIKE "str3")'     
	*      
	*  $seaArr[] = array('Search_On'=>'col1',     
	*          'Search_Value'=>1,     
	*          'Type'=>'int',     
	*          'Equation'=>'=',     
	*          'CondType'=>'AND',     
	*          'Prefix'=>'',     
	*          'Postfix'=>''     );     
	*   $seaArr[] = array('Search_On'=>'col2',     
	*          'Search_Value'=>'str2',     
	*          'Type'=>'string',     
	*          'Equation'=>'LIKE',    
	 *          'CondType'=>'AND',     
	 *          'Prefix'=>'(',     
	 *          'Postfix'=>''     );     
	 *   $seaArr[] = array('Search_On'=>'col3',     
	 *           'Search_Value'=>'str3',    
	 *          'Type'=>'string',     
	 *          'Equation'=>'LIKE',     
	 *          'CondType'=>'OR',     
	 *          'Prefix'=>'',     
	 *          'Postfix'=>')'     );        
	 */           
	 
	 $whereExtra = "";    
	 
	 if(is_array($seaArr) && !empty($seaArr)) 
	 {
	           foreach($seaArr as $key=>$val) 
	           {
	                       $wheExt = '';            
	                       if(strtolower($val['Type']) != 'string') 
	                       {       
	                       		$wheExt = $val['CondType']." ".$val['Prefix']." ".$val['Search_On']." ".$val['Equation']." '".addslashes($val['Search_Value'])."'"." ".$val['Postfix'];
	                       }
	                       else
	                       {
	                            $wheExt = $val['CondType']." ".$val['Prefix']." ".$val['Search_On']." ".$val['Equation']." '".addslashes($val['Search_Value'])."'"." ".$val['Postfix'];      
	                       }            
	                       
	                       $whereExtra .= " ".$wheExt;     
				}
				if($whereExtra != "")
				{
				      $whereExtra = "WHERE true $whereExtra";     
				}    
	}
	/**
	* Sorting     
	*
	* @see below example how to build up $optArr for sorting     
	*      
	*   'ORDER BY col1 ASC, col2 DESC'     
	*      
	*   $optArr[] = array("Order_By" => "col1",     
	*         "Order_Type" => "ASC" );     
	*   $optArr[] = array("Order_By" => "col2",     
	*         "Order_Type" => "DESC" );     
	*      
	*/    
	
	$optstring = "";    if(is_array($optArr) && !empty($optArr)) 
	{
	     $optstring .= " ORDER BY ";
	     $i = &$optKey;       
	     foreach ($optArr as $optKey => $optVal) 
	     {
	                 if($i != 0) 
	                 {
	                 		$optstring .= ", ";      
	                 }      
	                 $optstring .= $optVal['Order_By']." ".$optVal['Order_Type'];
	                          
	     }
	}         
	/**
	* Paging     
	*/    
	$limitString = '';
	if(isset($total) && !is_null($total)) 
	{
	     if(is_null($start)) 
	     {
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
try 
{
     $Rs = $this->Connection->Execute($Query);
     if ($Rs->RecordCount() == 0 ) 
     { 
     	//check whether the record is found or not     
     	 return false;     
     }    
}
catch (Exception $Exception)
{
     if($ThrowError == true) 
     {
           $ThrowException = new Exception(' Fail To Get Any Record of news');
     }       
} // try -catch end
 //Create CategoryData Object          
 
$NewsData = new RModelCollection();
	//assing all fetched records into CategoryData Object          
	
	foreach ($Rs as $Record) 
	{
	      $NewsData->Add(new NewsData($Record));       
	}//foreach end
	return $NewsData;//return the fetched recordset     
}
//getNews function end 


public function editNewsDescription($SiteNewsData, $ThrowError=true) 
	{
		 //build up update query
		$UpdateData = $SiteNewsData->InternalSync(RDataModel::UPDATE,"news_question","news_answer");         
       	$Query = "UPDATE news_description SET $UpdateData WHERE news_id = '". $SiteNewsData->news_id ."' and site_language_id ='" .$SiteNewsData->site_language_id."' " ;      
       	
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
				$ThrowException = new Exception(' Fail To Edit news_description Record ');
			 } else {
				return false;	
			 }
    	}// try-catch end
    	
		if ($ThrowException) {
			throw $ThrowException; 
		} else {
			return true;
		}
		
	}//editNewsCategoryDescription Function End
	
public function getSiteNewsDesc($option = array(), $fieldArr=null,$orderBy = null, $groupby = null, $start=null, $total=null, $ThrowError=true)
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
			
		$query = "select $fields from news_description LEFT JOIN news ON news_description.news_id = news.news_id WHERE 1 $StrWhere $groupString  $sortString  $limitString";
		
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
	
	function getSiteNews($option = array(), $fieldArr=null,$orderBy = null, $groupby = null, $start=null, $total=null, $ThrowError=true) 
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
			
		$query = "select $fields FROM news_category LEFT JOIN news_category_desc ON news_category.newscat_id = news_category_desc.newscat_id
		LEFT JOIN news ON news_category.newscat_id = news.newscat_id AND news.status = '1'
		LEFT JOIN news_description ON news.news_id = news_description.news_id
		AND news_description.site_language_id = news_category_desc.site_language_id WHERE 1 $StrWhere $groupString  $sortString  $limitString";
		
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

	public function addNewsDescription($SiteNewsData, $ThrowError=true)
	 {
	 		//build up insert query
		 	$FinalData = $SiteNewsData->InternalSync(RDataModel::INSERT, "news_id","news_question","news_answer","site_language_id");
		 	$Query = "INSERT INTO news_description $FinalData"; 
		 	
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
				return mysql_insert_id();
			}
		
	}//addNewsDescription Function End	


   

}//class End
		 
		 
		 
		 
		 
		 
		 

?>