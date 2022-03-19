<?php
	/**
	 * This is EmailTemplateManagerMaster file.
	 * This file contains all the business logic code related to email_template_manager table.
	 * 
	 * TABLE_NAME:    email_template_manager 
	 * PRIMARY_KEY :  template_id
	 * TABLE_COLUMNS: "template_subject","template_content","template_group","isactive",""
	 * 
	 * @uses By creating object of EmailTemplateManagerMaster we can handle or manage different table operation like insert, update, delete and selecting data with criteria from table.
	 * 
	 * @package    EmailManager
	 * @author     Nupur
	 * @version    $Id: EmailTemplateManagerMaster.php,v 1.0
	 * 
	 */
	 
	/**
	 * @see EmailTemplateManagerData.php for Data class
	 */
	//require_once($ModulePaths['MODULE_MODEL_PATH'][1]."/EmailTemplateManagerData.php");
	
	/**
	 * @see RMasterModel.php for extended RMasterModel class
	 */
	
	require_once(DIR_WS_MODEL . "EmailTemplateManagerData.php");
	require_once(DIR_LIB_CLASSES_MODELS."/RMasterModel.php");
	
	class EmailTemplateManagerMaster extends RMasterModel
	{	
		
		/**
		 * Create a null object of EmailTemplateManagerMaster
		 *
		 * @return object object $EmailTemplateManagerMasterObj
		 */	
		public function create()
		{
			$EmailTemplateManagerMasterObj = new EmailTemplateManagerMaster();
			return  $EmailTemplateManagerMasterObj;
		}//create Function End
		      
		/**
		 * To insert record in email_template_manager table 
		 * Insert data of columns :  "template_title","template_group","isactive","ismail"
		 *
		 * @param arrayEmailTemplateManagerData $EmailTemplateManagerData 
		 * @param bool $ThrowError Whether to throw error or not
		 * 
		 * @return int If any error, then Throw Exception otherwise inserted row id
		 */	
		 public function addEmailTemplate($EmailTemplateManagerData, $ThrowError=true)
		 {
		 		//build up insert query
			 	$FinalData = $EmailTemplateManagerData->InternalSync(RDataModel::INSERT, "template_title","template_group","isactive","template_from_address", "template_cc_address");
			 	$Query = "INSERT INTO email_template_manager $FinalData"; 
			 	
			 	/**
				  * check that data should be inserted successfully.
				  * if no then throw or return proper error message. 
				  */
			 	$ThrowException = null;
		 		try { 
		 			
					$Rs=$this->Connection->Execute($Query);
					if ($Rs->AffectedRows() ==  0) {
						throw new Exception(' Fail To Add New email_template_manager Record');
					}
					
				}
				catch(Exception $Exception) {
					
					if($ThrowError == true){
						$ThrowException = new Exception(' Fail To Add email_template_manager Record ');
					} else {
						return false;	
					}//if-else end
					
				}// try -catch end
									
				if ($ThrowException) {
					throw $ThrowException;
				} else {
					return $this->Connection->LastInsertedId();
				}
			
		}//addEmailTemplate Function End
		
		
		/**
		 * To insert record in email_template_manager_description table 
		 * Insert data of columns : "template_subject","template_content","site_language_id"
		 *
		 * @param arrayEmailTemplateManagerData $EmailTemplateManagerData 
		 * @param bool $ThrowError Whether to throw error or not
		 * 
		 * @return int If any error, then Throw Exception otherwise inserted row id
		 */	
		 public function addEmailTemplateDesc($EmailTemplateManagerDescData, $ThrowError=true)
		 { 
		 		//build up insert query
			 	$FinalData = $EmailTemplateManagerDescData->InternalSync(RDataModel::INSERT,"template_id","template_subject","template_content","site_language_id");
			 	$Query = "INSERT INTO email_template_manager_description $FinalData"; 
			 	
			 	/**
				  * check that data should be inserted successfully.
				  * if no then throw or return proper error message. 
				  */
			 	$ThrowException = null;
		 		try { 
		 			
					$Rs=$this->Connection->Execute($Query);
					if ($Rs->AffectedRows() ==  0) {
						throw new Exception(' Fail To Add New email_template_manager_description Record');
					}
					
				}
				catch(Exception $Exception) {
					
					if($ThrowError == true){
						$ThrowException = new Exception(' Fail To Add email_template_manager_description Record ');
					} else {
						return false;	
					}//if-else end
					
				}// try -catch end
									
				if ($ThrowException) {
					throw $ThrowException;
				} else {
					return $this->Connection->LastInsertedId();
				}
			
		}//addEmailTemplate Function End
		
		
		/**
		 * To update record of email_template_manager table
		 * Update data of columns : "template_title","isactive","ismail"
		 * 
		 * @param arrayEmailTemplateManagerData $EmailTemplateManagerData 
		 * @param bool $ThrowError Whether to throw error or not
		 * 
		 * @return bool If any error, then Throw Exception otherwise return true on success and false on failure
		 */	
		public function editEmailTemplate($EmailTemplateManagerData, $ThrowError=true,$sqlQuery=null) 
		{
			 
			//build up update query
			if(isset($sqlQuery) && !empty($sqlQuery)){
				$Query = $sqlQuery;
			} else {
				$UpdateData = $EmailTemplateManagerData->InternalSync(RDataModel::UPDATE, "template_title","isactive","template_from_address", "template_cc_address", "template_to_address");         
		       	$Query = "UPDATE email_template_manager SET $UpdateData WHERE template_id = ". $EmailTemplateManagerData->template_id;      
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
					//throw new Exception(' Fail To Edit email_template_manager Record ');
					return false;
		  		}
			}//try end
			catch(Exception $Exception) {
				if($ThrowError == true) {
					$ThrowException = new Exception(' Fail To Edit email_template_manager Record ');
				 } else {
					return false;	
				 }
	    	}// try-catch end
	    	
			if ($ThrowException) {
				throw $ThrowException; 
			} else {
				return true;
			}
			
		}//editEmailTemplate Function End
		
		
		
		
		/**
		 * To update record of email_template_manager_description table
		 * Update data of columns : "template_subject","template_content","site_language_id"
		 * 
		 * @param arrayEmailTemplateManagerData $EmailTemplateManagerData 
		 * @param bool $ThrowError Whether to throw error or not
		 * 
		 * @return bool If any error, then Throw Exception otherwise return true on success and false on failure
		 */	
		public function editEmailTemplateDesc($EmailTemplateManagerDescData, $ThrowError=true) 
		{
			 
			//build up update query
			$UpdateData = $EmailTemplateManagerDescData->InternalSync(RDataModel::UPDATE, "template_subject","template_content");         
	        $Query = "UPDATE email_template_manager_description SET $UpdateData WHERE template_id = '". $EmailTemplateManagerDescData->template_id."' and site_language_id = '".$EmailTemplateManagerDescData->site_language_id."'";      
			
	       	/**
			  * check that data should be updated perfectly.
			  * if no then throw or return proper error message.
			  */
			$ThrowException = null;
			try {
		  		$Rs = $this->Connection->Execute($Query);
		  		if ( $Rs->AffectedRows() == 0 )	{
					//throw new Exception(' Fail To Edit email_template_manager Record ');
					return false;
		  		}
			}//try end
			catch(Exception $Exception) {
				if($ThrowError == true) {
					$ThrowException = new Exception(' Fail To Edit email_template_manager_description Record ');
				 } else {
					return false;	
				 }
	    	}// try-catch end
	    	
			if ($ThrowException) {
				throw $ThrowException; 
			} else {
				return true;
			}
			
		}//editEmailTemplate Function End
		
		
		
		/**
		 * To delete email_template_manager data
		 *
		 * @param int template_id $template_id 
		 * @param bool $ThrowError Whether to throw or not to throw error
		 * 
		 * @return bool If any error, then Throw Exception otherwise return true on success and false on failure
		 */	 
		public function deleteEmailTemplate($template_id, $ThrowError=true,$multiDelete = null) 
		{
	   		if(isset($template_id) && ($template_id!=null) || (isset($multiDelete) && $multiDelete != '' ) ) {
	 			
	   			//build up delete query
	   			if(isset($template_id) && $template_id!=null ){
	   			     $Query ="DELETE FROM email_template_manager WHERE template_id = " . $template_id;
	   			} elseif (isset($multiDelete) && $multiDelete != '' ) {
	   			    $t_id=implode(",",$template_id);
    		        $Query = "DELETE FROM email_template_manager WHERE template_id IN (".$t_id.")";
	   			}
	 			
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
				    	$ThrowException = new Exception(' Fail To Delete email_template_manager Record');
					}	
				    else {
						return false;	
				    }
				}// try catch end	
	    				
	  		} // if end
		  		
		 }//deleteEmailTemplate Function End	
		 

		 /**
		 * To delete email_template_manager_description data
		 *
		 * @param int template_id $template_id 
		 * @param bool $ThrowError Whether to throw or not to throw error
		 * 
		 * @return bool If any error, then Throw Exception otherwise return true on success and false on failure
		 */	 
		public function deleteEmailTemplateDesc($template_id, $ThrowError=true,$multiDelete = null) 
		{
	   		if(isset($template_id) && ($template_id!=null) || (isset($multiDelete) && $multiDelete != '' ) ) {
	 			
	   			//build up delete query
	   			if(isset($template_id) && $template_id!=null ){
	   			     $Query ="DELETE FROM email_template_manager_description WHERE template_id = " . $template_id;
	   			} elseif (isset($multiDelete) && $multiDelete != '' ) {
	   			    $t_id=implode(",",$template_id);
    		        $Query = "DELETE FROM email_template_manager_description WHERE template_id IN (".$t_id.")";
	   			}
	 			
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
				    	$ThrowException = new Exception(' Fail To Delete email_template_manager_description Record');
					}	
				    else {
						return false;	
				    }
				}// try catch end	
	    				
	  		} // if end
		  		
	 }//deleteEmailTemplateDesc Function End
		 
	/**
	  *
	  *Toggel the EmailDocument status
	  *
	  * @param array $EmailDocument_List
	  * @param boolean $State
	  * @param stsr $ThrowError
	  * @return return boolean
	  */
       public function ToggleState($Page_List,$State,$ThrowError=true)
       {
    
    		$p_id = implode(",",$Page_List);
    		$Query = "UPDATE email_template_manager SET isactive ='".$State."' WHERE template_id IN (".$p_id.")";
        	//echo s$Query;
    	   	$ThrowException = null;
    	   	try	{
    	        	$Rs = $this->Connection->Execute($Query);
    				if ( $Rs->AffectedRows() == 0 ) {
    					throw new Exception(' Fail To Edit Any Record ');
    				}
    	   	}
       		catch(Exception $Exception)	{
    			if($ThrowError == true) {
    				$ThrowException = new Exception(' Fail To Edit Any Record ');
    			}
    			else {
    					return false;
    			}
    		}
    	}
	 
	 
	 /**
	 * GetEmailTemplateManager method is used for to get all or selected columns records from email_template_manager with searching, sorting and paging criteria.
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
	public function getEmailTemplate($fieldArr=null, $seaArr=null, $optArr=null, $start=null, $total=null, $QueryString=null, $ThrowError=true)
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
		if(!empty($QueryString)) {
			$Query = $QueryString;
		} else {
			$Query = "SELECT $fields FROM email_template_manager $whereExtra $optstring $limitString";
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
				$ThrowException = new Exception(' Fail To Get Any Record of user_master');
			}
	    } // try -catch end

	    if(!empty($QueryString)){
	    	
	    	$EmailTemplateManagerData = array();
	    	foreach ($Rs as $Record) {
	    		$EmailTemplateManagerData[]=$Record;
	    	}
	    	
	    } else {
		    //Create CategoryData Object
	   	    $EmailTemplateManagerData = new RModelCollection();
	   	    
	   	    //assing all fetched records into CategoryData Object
	   	    foreach ($Rs as $Record) {
			 	$EmailTemplateManagerData->Add(new EmailTemplateManagerData($Record));
		    }//foreach end
	    }
	    
	    return $EmailTemplateManagerData;//return the fetched recordset		
	}//getUser function end
	
	
	
	 /**
	 * GetEmailTemplateManager method is used for to get all or selected columns records from email_template_manager_description with searching, sorting and paging criteria.
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
	public function getEmailTemplateDesc($fieldArr=null, $seaArr=null, $optArr=null, $start=null, $total=null, $QueryString=null, $ThrowError=true)
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
		if(!empty($QueryString)) {
			$Query = $QueryString;
		} else {
			$Query = "SELECT $fields FROM email_template_manager_description $whereExtra $optstring $limitString";
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
				$ThrowException = new Exception(' Fail To Get Any Record of email_template_manager_description');
			}
	    } // try -catch end

	    if(!empty($QueryString)){
	    	
	    	$EmailTemplateManagerDescData = array();
	    	foreach ($Rs as $Record) {
	    		$EmailTemplateManagerDescData[]=$Record;
	    	}
	    	
	    } else {
		    //Create CategoryData Object
	   	    $EmailTemplateManagerDescData = new RModelCollection();
	   	    
	   	    //assing all fetched records into CategoryData Object
	   	    foreach ($Rs as $Record) {
			 	$EmailTemplateManagerDescData->Add(new EmailTemplateManagerData($Record));
		    }//foreach end
	    }
	    
	    return $EmailTemplateManagerDescData;//return the fetched recordset		
	}//getUser function end
	
	
	
	public function getEmailTemplateDetails($EmailKey=null, $language_id=null,$fieldArr=null,$orderBy = null, $start=null, $total=null, $ThrowError=true)
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
			
			$StrWhere = '';
			if(!is_null($EmailKey)) {
								
				$StrWhere .= " AND email_template_manager.template_title = '".$EmailKey."'";
			}
			
			if(!is_null($language_id)) {
				$StrWhere .= " AND email_template_manager_description.site_language_id = ".$language_id;
			}
			
			$Query = " SELECT $fields from email_template_manager
						LEFT JOIN email_template_manager_description ON  email_template_manager_description.template_id = email_template_manager.template_id
						WHERE 1 " . $StrWhere. $sortString;
			
			$ThrowException = null;
			try	{
				$Rs = $this->Connection->Execute($Query); 
				if ($Rs->RecordCount() == 0 ) {
					return false;
				}
			}
			catch (Exception $Exception) {
				if($ThrowError == true) {
					$ThrowException = new Exception(' No Record Found For:'.$product_addopt_id."<br>".$Rs);
				} else {
					return false;	
				}// if -else end
				
			}//try-catch end	
						
			return $Rs;
	}//getEmailTemplateDetails ends here
	
	
	}//class End
?>