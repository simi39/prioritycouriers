<?php
/**
 * This is CouponMaster file.
 * This file contains all the business logic code related to corporate_user table.
 * 
 * TABLE_NAME:    coupon
 * PRIMARY_KEY :  coupon_id
 * TABLE_COLUMNS: "coupon_name","coupon_amount","coupon_code","coupon_start_date","coupon_end_date","coupon_status","coupon_usage".
 * 
 * @uses By creating object of CouponMaster we can handle or manage different table operation like insert, update, delete and selecting data with criteria from table.
 * 
 * @package    Coupon Management
 * @author     Radixweb
 * @copyright  Document Copyright information, e.g. Copyright (c) 2008, Radixweb
 * @license    Display a hyperlink to a URL for a license, e.g. http://opensource.org/licenses/gpl-license.php GNU Public License
 * @version    $Id: CouponMaster.php,v 1.0
 * @link       Display a hyperlink to a URL in the documentation, e.g. http://radixweb.com
 * @since      Document when (at which version) an element was first added to a package e.g. Version 1.0 
 * 
 */

/**
 * @see CouponData.php for Data class
 */
require_once(DIR_WS_MODEL."/CouponData.php");

/**
 * @see RMasterModel.php for extended RMasterModel class
 */
require_once(DIR_LIB_CLASSES_MODELS."/RMasterModel.php");

class CouponMaster extends RMasterModel
{
	/**
	 * Create a null object of CorporateMaster
	 *
	 * @return object object $CorporateMasterObj
	 */
	public function create()
	{
		$CouponMasterObj = new CouponMaster();
		return  $CouponMasterObj;
	}//create Function End

	/**
	 * To insert record in corporate_user table 
	 * Insert data of columns : "corporate_name","corporate_logo_image","corporate_footer_image","corporate_description","sort_order","status"
	 *
	 * @param arrayCorporateData $CorporateData 
	 * @param bool $ThrowError Whether to throw error or not
	 * 
	 * @return int If any error, then Throw Exception otherwise inserted row id
	 */
	public function addCoupon($CouponData, $ThrowError=true)
	{
		//build up insert query
	 	$FinalData = $CouponData->InternalSync(RDataModel::INSERT, "coupon_name","coupon_amount","coupon_type","coupon_code","coupon_start_date","coupon_end_date","coupon_status","coupon_usage");
	 	$Query = "INSERT INTO coupon $FinalData"; 
	 	
	 	/**
		  * check that data should be inserted successfully.
		  * if no then throw or return proper error message. 
		  */
	 	$ThrowException = null;
 		try { 
			$Rs=$this->Connection->Execute($Query);
			if ($Rs->AffectedRows() ==  0) {
				throw new Exception(' Fail To Add New Coupon Record');
			}
		} catch(Exception $Exception) {
			if($ThrowError == true) {
				$ThrowException = new Exception(' Fail To Add Coupon Record ');
			} else {
				return false;	
			}//if-else end
		}// try -catch end
							
		if ($ThrowException) {
			throw $ThrowException;
		} else {
			return $this->Connection->LastInsertedId();
		}
	}//addCorporate Function End
	
	/**
	 * To update record of corporate_user table
	 * Update data of columns : "corporate_name","corporate_logo_image","corporate_footer_image","corporate_description","sort_order","status"
	 * 
	 * @param arrayCorporateData $CorporateData 
	 * @param bool $ThrowError Whether to throw error or not
	 * 
	 * @return bool If any error, then Throw Exception otherwise return true on success and false on failure
	 */
	public function editCoupon($CouponData,$statusChange=null,$userid=null,$footerImage=false,$ThrowError=true) 
	{
		//build up update query
		
		//build up update query
		if(!is_null($statusChange)){
			/*if(is_array($statusChange)){
				$statusChange = '"' . implode('", "', $statusChange) . '"';
			}*/
			$UpdateData =  $CouponData->InternalSync(RDataModel::UPDATE, "$statusChange");
		}
		elseif(!is_null($userid)){
			/*if(is_array($statusChange)){
				$statusChange = '"' . implode('", "', $statusChange) . '"';
			}*/
			$UpdateData =  $CouponData->InternalSync(RDataModel::UPDATE, "user_id");
		}
		else{
			$UpdateData = $CouponData->InternalSync(RDataModel::UPDATE,"coupon_name","coupon_amount","coupon_type","coupon_code","coupon_start_date","coupon_end_date","coupon_usage");
		}
		
		$Query = "UPDATE coupon SET $UpdateData WHERE coupon_id = ". $CouponData->coupon_id;

       	/**
		  * check that data should be updated perfectly.
		  * if no then throw or return proper error message.
		  */
		$ThrowException = null;
		try {
	  		$Rs = $this->Connection->Execute($Query);
	  		if ( $Rs->AffectedRows() == 0 )	{
				//throw new Exception(' Fail To Edit corporate_user Record ');
				return false;
	  		}
		} catch(Exception $Exception) {
			if($ThrowError == true) {
				$ThrowException = new Exception(' Fail To Edit Coupon Record ');
			 } else {
				return false;
			 }
    	}// try-catch end

		if ($ThrowException) {
			throw $ThrowException;
		} else {
			return true;
		}
	}//editCorporate Function End

	/**
	 * To delete corporate_user data
	 *
	 * @param int corporate_id $corporate_id 
	 * @param bool $ThrowError Whether to throw or not to throw error
	 * 
	 * @return bool If any error, then Throw Exception otherwise return true on success and false on failure
	 */
	public function deleteCoupon($coupon_id, $ThrowError=true)
	{
   		if(isset($coupon_id) && ($coupon_id!=null)) {
			//build up delete query
   			$Query ="DELETE FROM coupon WHERE coupon_id = " . $coupon_id;

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
			    	$ThrowException = new Exception(' Fail To Delete Coupon Record');
				} else {
					return false;
			    }
			}// try catch end	
  		} // if end
	 }//deleteCorporate Function End	
	 
	 /**
	 * GetCorporate method is used for to get all or selected columns records from corporate_user with searching, sorting and paging criteria.
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
	public function getCoupon($fieldArr=null, $seaArr=null, $optArr=null, $start=null, $total=null,$QueryString=null, $ThrowError=true)
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
		$Query = "SELECT $fields FROM coupon $whereExtra $optstring $limitString";
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
				$ThrowException = new Exception(' Fail To Get Any Record of Coupon');
			}
	    } // try -catch end
  
	    //Create CategoryData Object
   	    $CouponData = new RModelCollection();
   	    
   	    //assing all fetched records into CategoryData Object
   	    foreach ($Rs as $Record) {
		 	$CouponData->Add(new CouponData($Record));
	    }//foreach end
		    
	    return $CouponData;//return the fetched recordset		
	}//getCorporate function end 
	
	
	/**
	 * Change the status
	 *
	 * @param $Ids use which record u want change status
	 * 
	 * @param $Status use for status name
	 * 
	 * @param bool $ThrowError Whether to throw or not to throw error
	 * 
	 * @return If any error, then Throw Exception
	 */	
public function AlterStatus($ObjCouponData,$ThrowError=true) 
	{//start
	
		//check that data should be updated perfectly.
		//if no then throw or return proper error message.
		$UpdateData = $ObjCouponData->InternalSync(RDataModel::UPDATE, "coupon_status");
		$Query = "UPDATE coupon SET $UpdateData WHERE coupon_id = ". $ObjCouponData->coupon_id;
			
		
		//$Query="update coupon set coupon_status = '".$Status."' where coupon_id IN($Ids1)";
		
		$ThrowException = null;
		try	{
				$Rs = $this->Connection->Execute($Query);
				if ( $Rs->AffectedRows() == 0 ) 
				{
					throw new Exception('Not any Record Change');
				}
			}
			catch (Exception $Exception)	{
						if($ThrowError == true) {
								$ThrowException = new Exception('Not any Record Change');
						}	
						else {
								return false;	
						}
			// if -else end	
			}// try-catch end	

	}//
	
	
	public function Fromcode($couponcode=null, $ThrowError=true)
	{
		/**
		 * Table Columns
		 * If $fieldArr has null value then it will return all records otherwise entered table fields
		 * 
		 * @see below example for to create $fieldArr for to get only selected table fields data
		 * 
		 *     $fieldArr = array("col1", "col2", "col3");
		 */
		
		
		 if(isset($couponcode) && ($couponcode!=null)) {
	   		$current_date = date("Y-m-d H:i:s");
			$Query = "select * from coupon where coupon_code='".$couponcode."' AND coupon_status!='0' AND coupon_end_date >= '".$current_date."' ";
			
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
		 }// if bracket 
		 else{
				return false;
		 }// if - else end
	}//getCorporate function end 
	
	
	/**
	 * Change the status
	 *
	 * @param $Ids use which record u want change status
	 * 
	 * @param $Status use for status name
	 * 
	 * @param bool $ThrowError Whether to throw or not to throw error
	 * 
	 * @return If any error, then Throw Exception
	 */	
	public function changeStatus($Ids,$Status,$ThrowError=true) 
	{//start
	
		//check that data should be updated perfectly.
		//if no then throw or return proper error message.
			
		$Ids1="";
		foreach ($Ids as $Key => $Value) {
			$Ids1 .= ','.$Value; 
		}
		$Ids1= trim($Ids1,",");
		$Query="update coupon set coupon_status = '".$Status."' where coupon_id IN($Ids1)";
		
		$ThrowException = null;
		try	{
				$Rs = $this->Connection->Execute($Query);
				if ( $Rs->AffectedRows() == 0 ) 
				{
					throw new Exception('Not any Record Change');
				}
			}
			catch (Exception $Exception)	{
						if($ThrowError == true) {
								$ThrowException = new Exception('Not any Record Change');
						}	
						else {
								return false;	
						}
			// if -else end	
			}// try-catch end	

	}//
	
}//class End