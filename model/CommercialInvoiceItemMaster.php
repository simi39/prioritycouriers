<?php
/**
 * This is CommercialInvoiceItemMaster file.
 * This file contains all the business logic code related to commercial_invoice_item_details table.
 * 
 * TABLE_NAME:    commercial_invoice_item_details 
 * PRIMARY_KEY :  commercial_item_id
 * TABLE_COLUMNS: commercial_item_id,"commercial_invoice_id","commercial_description","commercial_qty","commercial_currency","commercial_unit_value","commercial_value"
 * 
 * @uses By creating object of CommercialInvoiceItemMaster we can handle or manage different table operation like insert, update, delete and selecting data with criteria from table.
 * 
 * @package    Specify package to group classes or functions and defines into
 * @author     Radixweb
 * @copyright  Document Copyright information, e.g. Copyright (c) 2008, Radixweb
 * @license    Display a hyperlink to a URL for a license, e.g. http://opensource.org/licenses/gpl-license.php GNU Public License
 * @version    $Id: CommercialInvoiceItemMaster.php,v 1.0
 * @link       Display a hyperlink to a URL in the documentation, e.g. http://radixweb.com
 * @since      Document when (at which version) an element was first added to a package e.g. Version 1.0 
 * 
 */
 
/**
 * @see CommercialInvoiceItemData.php for Data class
 */



require_once(DIR_WS_MODEL."/CommercialInvoiceItemData.php");

/**
 * @see RMasterModel.php for extended RMasterModel class
 */
require_once(DIR_LIB_CLASSES_MODELS."/RMasterModel.php");

class CommercialInvoiceItemMaster extends RMasterModel
{	
	
	/**
	 * Create a null object of CommercialInvoiceItemMaster
	 *
	 * @return object object $CommercialInvoiceItemMasterObj
	 */	
	public function create()
	{
		$CommercialInvoiceItemMasterObj = new CommercialInvoiceItemMaster();
		return  $CommercialInvoiceItemMasterObj;
	}//create Function End
	      
	/**
	 * To insert record in commercial_invoice_item_details table 
	 * Insert data of columns : commercial_item_id,"commercial_invoice_id","commercial_description","commercial_qty","commercial_currency","commercial_unit_value","commercial_value"
	 *
	 * @param arrayCommercialInvoiceItemData $CommercialInvoiceItemData 
	 * @param bool $ThrowError Whether to throw error or not
	 * 
	 * @return int If any error, then Throw Exception otherwise inserted row id
	 */	
	 public function addCommercialInvoiceItem($CommercialInvoiceItemData, $ThrowError=true)
	 {
	 		//build up insert query
		 	$FinalData = $CommercialInvoiceItemData->InternalSync(RDataModel::INSERT, commercial_item_id,"commercial_invoice_id","commercial_description","commercial_qty","commercial_currency","commercial_unit_value","commercial_value");
		 	$Query = "INSERT INTO commercial_invoice_item_details $FinalData"; 
		 	
		 	/**
			  * check that data should be inserted successfully.
			  * if no then throw or return proper error message. 
			  */
		 	$ThrowException = null;
	 		try { 
	 			
				$Rs=$this->Connection->Execute($Query);
				if ($Rs->AffectedRows() ==  0) {
					throw new Exception(' Fail To Add New commercial_invoice_item_details Record');
				}
				
			}
			catch(Exception $Exception) {
				
				if($ThrowError == true){
					$ThrowException = new Exception(' Fail To Add commercial_invoice_item_details Record ');
				} else {
					return false;	
				}//if-else end
				
			}// try -catch end
								
			if ($ThrowException) {
				throw $ThrowException;
			} else {
				return $this->Connection->LastInsertedId();
			}
		
	}//addCommercialInvoiceItem Function End
	
	
	
	/**
	 * To update record of commercial_invoice_item_details table
	 * Update data of columns : commercial_item_id,"commercial_invoice_id","commercial_description","commercial_qty","commercial_currency","commercial_unit_value","commercial_value"
	 * 
	 * @param arrayCommercialInvoiceItemData $CommercialInvoiceItemData 
	 * @param bool $ThrowError Whether to throw error or not
	 * 
	 * @return bool If any error, then Throw Exception otherwise return true on success and false on failure
	 */	
	public function editCommercialInvoiceItem($CommercialInvoiceItemData, $ThrowError=true,$edit_single_entry=false) 
	{
			$UpdateData = $CommercialInvoiceItemData->InternalSync(RDataModel::UPDATE, commercial_item_id,"commercial_invoice_id","commercial_description","commercial_qty","commercial_currency","commercial_unit_value","commercial_value");  
		
			
			//called in commercial_invoioce_item_detail_action.php for not_commercial_invoice_id line number:145
		
		if($edit_single_entry=='not_commercial_invoice_id'){
			$Update = $CommercialInvoiceItemData->InternalSync(RDataModel::UPDATE,"commercial_item_id","commercial_invoice_id","commercial_description","commercial_qty","commercial_currency","commercial_unit_value","commercial_value");        			 
			$Query = "UPDATE commercial_invoice_item_details SET $Update WHERE  id =". $CommercialInvoiceItemData->id;
		}	
		elseif($edit_single_entry=='true'){
			
	  		$Query = "UPDATE commercial_invoice_item_details SET $UpdateData WHERE  id =". $CommercialInvoiceItemData->id;  //
		}else
		{
		
			$Query = "UPDATE commercial_invoice_item_details SET $UpdateData 
       		WHERE commercial_item_id = ". $CommercialInvoiceItemData->commercial_item_id." and commercial_invoice_id =". $CommercialInvoiceItemData->commercial_invoice_id;  //
		 }
		//echo $Query;//exit();
		//build up update query
	   	
       	/**
		  * check that data should be updated perfectly.
		  * if no then throw or return proper error message.
		  */
		$ThrowException = null;
		try {
	  		$Rs = $this->Connection->Execute($Query);
	  		if ( $Rs->AffectedRows() == 0 )	{
				//throw new Exception(' Fail To Edit commercial_invoice_item_details Record ');
				return false;
	  		}
		}//try end
		catch(Exception $Exception) {
			if($ThrowError == true) {
				$ThrowException = new Exception(' Fail To Edit commercial_invoice_item_details Record ');
			 } else {
				return false;	
			 }
    	}// try-catch end
    	
		if ($ThrowException) {
			throw $ThrowException; 
		} else {
			return true;
		}
		
	}//editCommercialInvoiceItem Function End
	
	
	/**
	 * To delete commercial_invoice_item_details data
	 *
	 * @param int commercial_item_id $commercial_item_id 
	 * @param bool $ThrowError Whether to throw or not to throw error
	 * 
	 * @return bool If any error, then Throw Exception otherwise return true on success and false on failure
	 */	 
	public function deleteCommercialInvoiceItem($commercial_item_id, $ThrowError=true) 
	{
   		if(isset($commercial_item_id) && ($commercial_item_id!=null)) {
 			
   			//build up delete query
   			$Query ="DELETE FROM commercial_invoice_item_details WHERE commercial_item_id = " . $commercial_item_id;
 			
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
			    	$ThrowException = new Exception(' Fail To Delete commercial_invoice_item_details Record');
				}	
			    else {
					return false;	
			    }
			}// try catch end	
    				
  		} // if end
	  		
	 }//deleteCommercialInvoiceItem Function End
	 
	 public function deleteCommercialInvoiceItem2($commercial_invoice_id, $ThrowError=true,$commercial_item_id=0,$id=null) 
	{
   		if(isset($commercial_invoice_id) && ($commercial_invoice_id!=null)) {
 			
   			$cond = ($commercial_item_id!="" && $commercial_item_id!=0)?(" and commercial_item_id = ".$commercial_item_id):("");
   			if($id!=''){
   				$Query ="DELETE FROM commercial_invoice_item_details WHERE id = " . $id;
   			
   			}else{
   			$Query ="DELETE FROM commercial_invoice_item_details WHERE commercial_invoice_id = " . $commercial_invoice_id . $cond;
   				
   			}
   			//build up delete query
   			 
 		//	exit();
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
			    	$ThrowException = new Exception(' Fail To Delete commercial_invoice_item_details Record');
				}	
			    else {
					return false;	
			    }
			}// try catch end	
    				
  		} // if end
	  		
	 }//deleteCommercialInvoiceItem2 Function End	
	
	 
	 /**
	 * GetCommercialInvoiceItem method is used for to get all or selected columns records from commercial_invoice_item_details with searching, sorting and paging criteria.
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
	 public function getCommercialInvoiceItem($fieldArr=null, $seaArr=null, $optArr=null, $start=null, $total=null, $ThrowError=true,$fetch_unique_commercial_id=false,$tot=null)
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
			if($fetch_unique_commercial_id=='fetch'){
			$Query="SELECT DISTINCT commercial_invoice_id FROM commercial_invoice_item_details $whereExtra $optstring";	
			}else{
			 $Query = "SELECT $fields FROM commercial_invoice_item_details $whereExtra $optstring $limitString";				
			}
			
			//echo $Query;
			
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
					$ThrowException = new Exception(' Fail To Get Any Record of commercial_invoice_item_details');
				}
		    } // try -catch end
	  
		    //Create CategoryData Object
	   	    $CommercialInvoiceItemData = new RModelCollection();
	   	    
	   	    //assing all fetched records into CategoryData Object
	   	    foreach ($Rs as $Record) {
			 	$CommercialInvoiceItemData->Add(new CommercialInvoiceItemData($Record));
		    }//foreach end
		    
		    return $CommercialInvoiceItemData;//return the fetched recordset		
	 }//getCommercialInvoiceItem function end 
	 
	 
	
}//class End