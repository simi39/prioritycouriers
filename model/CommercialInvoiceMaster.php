<?php
/**
 * This is CommercialInoviceMaster file.
 * This file contains all the business logic code related to commercial_invoice table.
 * 
 * TABLE_NAME:    commercial_invoice 
 * PRIMARY_KEY :  commercial_invoice_id
 * TABLE_COLUMNS: commercial_invoice_id,"consignor_name","consignor_company","consignor_address_1","consignor_address_2","consignor_address_3","consignor_suburb","consignor_city","consignor_postcode","consignor_country","consignor_telephone","consignor_email","consignee_name","consignee_company","consignee_address_1","consignee_address_2","consignee_address_3","consignee_suburb","consignee_city","consignee_postcode","consignee_country","consignee_telephone","commercial_invoice_date","commercial_name","commercial_total"
 * 
 * @uses By creating object of CommercialInoviceMaster we can handle or manage different table operation like insert, update, delete and selecting data with criteria from table.
 * 
 * @package    Specify package to group classes or functions and defines into
 * @author     Radixweb
 * @copyright  Document Copyright information, e.g. Copyright (c) 2008, Radixweb
 * @license    Display a hyperlink to a URL for a license, e.g. http://opensource.org/licenses/gpl-license.php GNU Public License
 * @version    $Id: CommercialInoviceMaster.php,v 1.0
 * @link       Display a hyperlink to a URL in the documentation, e.g. http://radixweb.com
 * @since      Document when (at which version) an element was first added to a package e.g. Version 1.0 
 * 
 */
 
/**
 * @see CommercialInvoiceData.php for Data class
 */
require_once(DIR_WS_MODEL."/CommercialInvoiceData.php");
require_once(DIR_WS_MODEL."/CommercialInvoiceItemMaster.php");


/**
 * @see RMasterModel.php for extended RMasterModel class
 */
require_once(DIR_LIB_CLASSES_MODELS."/RMasterModel.php");

class CommercialInoviceMaster extends RMasterModel
{	
	
	/**
	 * Create a null object of CommercialInoviceMaster
	 *
	 * @return object object $CommercialInoviceMasterObj
	 */	
	public function create()
	{
		$CommercialInoviceMasterObj = new CommercialInoviceMaster();
		return  $CommercialInoviceMasterObj;
	}//create Function End
	      
	/**
	 * To insert record in commercial_invoice table 
	 * Insert data of columns : commercial_invoice_id,"consignor_name","consignor_company","consignor_address_1","consignor_address_2","consignor_address_33,"consignor_suburb","consignor_city","consignor_postcode","consignor_country","consignor_telephone","consignor_email","consignee_name","consignee_company","consignee_address_1","consignee_address_2","consignee_address_3","consignee_suburb","consignee_city","consignee_postcode","consignee_country","consignee_telephone","commercial_invoice_date","commercial_name","commercial_total"
	 *
	 * @param arrayCommercialInvoiceData $CommercialInvoiceData 
	 * @param bool $ThrowError Whether to throw error or not
	 * 
	 * @return int If any error, then Throw Exception otherwise inserted row id
	 */	
	 public function addCommercialInovice($CommercialInvoiceData, $ThrowError=true)
	 {
	 		//build up insert query
		 	$FinalData = $CommercialInvoiceData->InternalSync(RDataModel::INSERT, commercial_invoice_id,"consignor_name","consignor_company","consignor_address_1","consignor_address_2","consignor_address_3","consignor_suburb","consignor_city","consignor_postcode","consignor_country","consignor_telephone","consignor_email","consignee_name","consignee_company","consignee_address_1","consignee_address_2","consignee_address_3","consignee_suburb","consignee_city","consignee_postcode","consignee_country","consignee_telephone","consignee_email","commercial_invoice_date","commercial_name","commercial_total","country_of_manufacturing","booking_id","userid");
		 	 $Query = "INSERT INTO commercial_invoice $FinalData"; 
		 //	exit();
		 	/**
			  * check that data should be inserted successfully.
			  * if no then throw or return proper error message. 
			  */
		 	$ThrowException = null;
	 		try { 
	 			
				$Rs=$this->Connection->Execute($Query);
				if ($Rs->AffectedRows() ==  0) {
					throw new Exception(' Fail To Add New commercial_invoice Record');
				}
				
			}
			catch(Exception $Exception) {
				
				if($ThrowError == true){
					$ThrowException = new Exception(' Fail To Add commercial_invoice Record ');
				} else {
					return false;	
				}//if-else end
				
			}// try -catch end
								
			if ($ThrowException) {
				throw $ThrowException;
			} else {
				return $this->Connection->LastInsertedId();
			}
		
	}//addCommercialInovice Function End
	
	
	
	/**
	 * To update record of commercial_invoice table
	 * Update data of columns : commercial_invoice_id,"consignor_name","consignor_company","consignor_address_1","consignor_address_2","consignor_address_33,"consignor_suburb","consignor_city","consignor_postcode","consignor_country","consignor_telephone","consignor_email","consignee_name","consignee_company","consignee_address_1","consignee_address_2","consignee_address_3","consignee_suburb","consignee_city","consignee_postcode","consignee_country","consignee_telephone","commercial_invoice_date","commercial_name","commercial_total"
	 * 
	 * @param arrayCommercialInvoiceData $CommercialInvoiceData 
	 * @param bool $ThrowError Whether to throw error or not
	 * 
	 * @return bool If any error, then Throw Exception otherwise return true on success and false on failure
	 */	
	public function editCommercialInovice($CommercialInvoiceData, $ThrowError=true,$update_single_entry=false) 
	{
		/*echo "<pre>";
		print_r($CommercialInvoiceData);
		echo "</pre>";
		exit;*/
		 
		//build up update query
		/*$UpdateData = $CommercialInvoiceData->InternalSync(RDataModel::UPDATE, commercial_invoice_id);*/
		if($update_single_entry==true){
				$UpdateData = $CommercialInvoiceData->InternalSync(RDataModel::UPDATE, commercial_invoice_id,"commercial_total");    
		}else
		{
				$UpdateData = $CommercialInvoiceData->InternalSync(RDataModel::UPDATE, commercial_invoice_id,"consignor_name","consignor_company","consignor_address_1","consignor_address_2","consignor_address_3","consignor_suburb","consignor_city","consignor_postcode","consignor_country","consignor_telephone","consignor_email","consignee_name","consignee_company","consignee_address_1","consignee_address_2","consignee_address_3","consignee_suburb","consignee_city","consignee_postcode","consignee_country","consignee_telephone","commercial_invoice_date","commercial_name","commercial_total","country_of_manufacturing","booking_id","userid");    
		}
		
	  $Query = "UPDATE commercial_invoice SET $UpdateData WHERE commercial_invoice_id = ".$CommercialInvoiceData->commercial_invoice_id;    

       	/**
		  * check that data should be updated perfectly.
		  * if no then throw or return proper error message.
		  */
		$ThrowException = null;
		try {
	  		$Rs = $this->Connection->Execute($Query);
	  		if ( $Rs->AffectedRows() == 0 )	{
				//throw new Exception(' Fail To Edit commercial_invoice Record ');
				return false;
	  		}
		}//try end
		catch(Exception $Exception) {
			if($ThrowError == true) {
				$ThrowException = new Exception(' Fail To Edit commercial_invoice Record ');
			 } else {
				return false;	
			 }
    	}// try-catch end
    	
		if ($ThrowException) {
			throw $ThrowException; 
		} else {
			return true;
		}
		
	}//editCommercialInovice Function End
	
	
	/**
	 * To delete commercial_invoice data
	 *
	 * @param int commercial_invoice_id $commercial_invoice_id 
	 * @param bool $ThrowError Whether to throw or not to throw error
	 * 
	 * @return bool If any error, then Throw Exception otherwise return true on success and false on failure
	 */	 
	public function deleteCommercialInovice($commercial_invoice_id, $ThrowError=true) 
	{
   		if(isset($commercial_invoice_id) && ($commercial_invoice_id!=null)) {
 			
   			//build up delete query
   			$Query ="DELETE FROM commercial_invoice WHERE commercial_invoice_id = " . $commercial_invoice_id;
 			
 			/**
			  * check that data should be updated perfectly.
			  * if no then throw or return proper error message. 
			  */
 			$ThrowException = null;
 			try {	
				$result = $this->Connection->Execute($Query);
				if($result){
					$CommercialInvoiceItemMasterObj = CommercialInvoiceItemMaster::Create();
					$CommercialInvoiceItemDataObj = new CommercialInvoiceItemData();		
					$CommercialInvoiceItemMasterObj->deleteCommercialInvoiceItem2($commercial_invoice_id);		
				}
				return true;
   					
			}
			catch (Exception $Exception){
				if($ThrowError == true) {
			    	$ThrowException = new Exception(' Fail To Delete commercial_invoice Record');
				}	
			    else {
					return false;	
			    }
			}// try catch end	
    				
  		} // if end
	  		
	 }//deleteCommercialInovice Function End	
	
	 
	 /**
	 * GetCommercialInovice method is used for to get all or selected columns records from commercial_invoice with searching, sorting and paging criteria.
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
	 public function getCommercialInovice($fieldArr=null, $seaArr=null, $optArr=null, $start=null, $total=null, $ThrowError=true,$fetch_unique_commercial_invloice_id=false,$tot=null)
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
			//echo $not_fetch_unique_commercial_invloice_id;exit();
			
			$Query = "SELECT $fields FROM commercial_invoice $whereExtra $optstring $limitString";				
			
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
					$ThrowException = new Exception(' Fail To Get Any Record of commercial_invoice');
				}
		    } // try -catch end
	  
		    //Create CategoryData Object
	   	    $CommercialInvoiceData = new RModelCollection();
	   	    
	   	    //assing all fetched records into CategoryData Object
	   	    foreach ($Rs as $Record) {
			 	$CommercialInvoiceData->Add(new CommercialInvoiceData($Record));
		    }//foreach end
		    
		    return $CommercialInvoiceData;//return the fetched recordset		
	 }//getCommercialInovice function end 
	 
	 	
	
}//class End
?>