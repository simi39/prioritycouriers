<?php
/**
 * This is UserMaster file.
 * This file contains all the business logic code related to user_master table.
 * 
 * TABLE_NAME:    user_master
 * PRIMARY_KEY :  userid
 * TABLE_COLUMNS: "firstname","lastname","email","street_address","suburb","city","postcode","state","country","password","phone_number","user_type_id","corporate_id", "giftcard", "giftcard_id", "address1","address2","address3","facsimile_no"
 * 
 * @uses By creating object of UserMaster we can handle or manage different table operation like insert, update, delete and selecting data with criteria from table.
 * 
 * @package    User Management
 * @author     Radixweb
 * @copyright  Document Copyright information, e.g. Copyright (c) 2008, Radixweb
 * @license    Display a hyperlink to a URL for a license, e.g. http://opensource.org/licenses/gpl-license.php GNU Public License
 * @version    $Id: UserMaster.php,v 1.0
 * @link       Display a hyperlink to a URL in the documentation, e.g. http://radixweb.com
 * @since      Document when (at which version) an element was first added to a package e.g. Version 1.0
 * 
 */

/**
 * @see UserData.php for Data class
 */
require_once(DIR_WS_MODEL . "UserData.php");

/**
 * @see RMasterModel.php for extended RMasterModel class
 */
require_once(DIR_LIB_CLASSES_MODELS."/RMasterModel.php");
require_once(DIR_LIB_PEAR."DB.php");

class UserMaster extends RMasterModel
{
	/**
	 * Create a null object of UserMaster
	 *
	 * @return object object $UserMasterObj
	 */
		/**/
		
	function __construct() {
       $this->Connection = new RDataConnection();	
		//Connect($Type, $User, $Password, $Database, $Host = null, $Port = null)

		$this->Connection->Connect(CONNECTION_TYPE,DATABASE_USERNAME,DATABASE_PASSWORD,DATABASE_NAME,DATABASE_HOST,DATABASE_PORT);
    }

	public function create()
	{
		$UserMasterObj = new UserMaster();
		return  $UserMasterObj;
	}//create Function End

	/**
	 * To insert record in user_master table
	 * Insert data of columns : "firstname","lastname","email","street_address","suburb","city","postcode","state","country","password","phone_number","user_type_id","corporate_id", "giftcard", "giftcard_id","address1","address2","address3","facsimile_no"
	 *
	 * @param arrayUserData $UserData
	 * @param bool $ThrowError Whether to throw error or not
	 * 
	 * @return int If any error, then Throw Exception otherwise inserted row id
	 */
	public function addUser($UserData, $ThrowError=true)
	{
		//build up insert query
	 	$FinalData = $UserData->InternalSync(RDataModel::INSERT, "firstname","lastname","company","email","suburb","postcode","state","state_code","city","street_address","country","password","sender_area_code","phone_number","sender_mb_area_code","mobile_no","user_type_id","corporate_id", "site_language_id", "last_login_date","address1","address2","address3","security_ques_1","security_ans_1","security_ques_2","security_ans_2","ip_address","last_login_attempt_datetime","login_attempt");
	    $Query = "INSERT INTO user_master $FinalData";
		
		//echo $Query;
		//exit();
		
	 	
	 	

	 	/**
		  * check that data should be inserted successfully.
		  * if no then throw or return proper error message.
		  */
	 	$ThrowException = null;
 		try {

			$Rs=$this->Connection->Execute($Query);
			if ($Rs->AffectedRows() ==  0) {
				throw new Exception(' Fail To Add New user_master Record');
			}
		} catch(Exception $Exception) {
			if($ThrowError == true) {
				$ThrowException = new Exception(' Fail To Add user_master Record ');
			} else {
				return false;
			}//if-else end
		}// try -catch end

		if ($ThrowException) {
			throw $ThrowException;
		} else {
			return $this->Connection->LastInsertedId();
		}
	}//addUser Function End
	
	/**
	 * To update record of user_master table
	 * Update data of columns : "firstname","lastname","email","street_address","suburb","city","postcode","state","country","password","phone_number","user_type_id","corporate_id"
	 * 
	 * @param arrayUserData $UserData
	 * @param bool $ThrowError Whether to throw error or not
	 * 
	 * @return bool If any error, then Throw Exception otherwise return true on success and false on failure
	 */
	public function editUser($UserData=null, $changeStatus=null, $ThrowError=true,$QueryString=null)
	{
		
		
		if(empty($QueryString))
		{
		//build up update query
		if (isset($changeStatus) && !empty($changeStatus) && count($changeStatus)>0) {
			
			
			$setDataArr = array();
		/**
		 * Start :: Make Set Data String for specified Data
		 */
			foreach ($changeStatus as $field){
				
				$setDataArr[] = $field . " = '" .$UserData->{$field} . "'";
			}
			/*echo "<pre>";
			print_r($setDataArr);
			echo "</pre>";*/
			/* Commented By Smita 11Dec 2020
			$date_str = "last_login_date = '".date('Y-m-d H:i:s')."'";
			$last_login_attempt_dt = "last_login_attempt_datetime = '".date('Y-m-d H:i:s')."'";
			if(in_array($date_str, $setDataArr))
			{
				$setDataArr2[] = 'last_login_date' . " = NOW()";
				$setDataArr = array_replace($setDataArr,$setDataArr2);
				
				
			}*/
			foreach($changeStatus as $key=> $value){
		    	if(array_key_exists("last_login_date", $changeStatus))
				{
		    		$arr['last_login_date'] = "NOW()";
		    	}

		    	if(array_key_exists("last_login_date", $changeStatus))
				{
		    		$arr['last_login_attempt_datetime'] = "NOW()";
		    	}
			}
			/*echo "<pre>";
			print_r($setDataArr);
			echo "</pre>";*/
			/*
				Commented by Smita 11 Dec 2020
			if(in_array($last_login_attempt_dt, $setDataArr))
			{
				$setDataArr2[] = 'last_login_attempt_datetime' . " = NOW()";
				$setDataArr = array_replace($setDataArr,$setDataArr2);
				
				
			}

			*/
			//exit();
			
			
			/*echo "<pre>";
			print_r($setDataArr);
			echo "</pre>";
			exit();*/
			if(count($setDataArr)>0){
				$setDataString = implode(" , ", $setDataArr);
				
				if (isset($changeStatus[0]) && $changeStatus[0] == 'password') {
					$Query = "UPDATE user_master SET $setDataString WHERE email = '".$UserData->email."'";
				}else
				{
					$Query = "UPDATE user_master SET $setDataString WHERE userid = ".$UserData->userid;
				}
			 	//
			}
			
		}else{
			 $UpdateData = $UserData->InternalSync(RDataModel::UPDATE, "firstname","lastname","company","city","street_address","password","suburb","postcode","state","state_code","country","sender_area_code","phone_number","sender_mb_area_code","mobile_no","user_type_id","corporate_id","site_language_id","last_login_date","email","address1","address2","address3","security_ques_1","security_ans_1","security_ques_2","security_ans_2","login_attempt","ip_address","last_login_attempt_datetime");
       		 $Query = "UPDATE user_master SET $UpdateData WHERE userid = ". $UserData->userid;
       		
		}
		}
		if($QueryString)
		{
			$Query = "UPDATE user_master SET last_login_attempt_datetime = '0000-00-00 00:00:00',login_attempt='0' WHERE last_login_attempt_datetime <= DATE_SUB(NOW(), ".LOGIN_TIME_PERIOD.")";
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
	  		//echo $Rs->AffectedRows();
			//exit();
	  		/*echo "<pre>";
	  		print_r($Rs);
	  		echo "</pre>";
	  		exit();*/
	  		if ( $Rs->AffectedRows() == 0 )	{
				//throw new Exception(' Fail To Edit user_master Record ');
				return false;
	  		}
		} catch(Exception $Exception) {
			//var_dump($Exception);
			if($ThrowError == true) {
				$ThrowException = new Exception(' Fail To Edit user_master Record ');
			 } else {
				return false;
			 }
    	}// try-catch end

		if ($ThrowException) {
			throw $ThrowException;
		} else {
			return true;
		}
	}//editUser Function End
	public function editAdminUser($UserData=null, $changeStatus=null, $ThrowError=true,$QueryString=null)
	{
		
		
		
		if(empty($QueryString)){
		//build up update query
		if (isset($changeStatus) && !empty($changeStatus) && count($changeStatus)>0) {
			
			
			$setDataArr = array();
		/**
		 * Start :: Make Set Data String for specified Data
		 */
			foreach ($changeStatus as $field){
				
				$setDataArr[] = $field . " = '" .$UserData->{$field} . "'";
			}
			$date_str = "last_login_date = '".date('Y-m-d H:i:s')."'";
			
			if(in_array($date_str, $setDataArr))
			{
				$setDataArr2[] = 'last_login_date' . " = NOW()";
				$setDataArr = array_replace($setDataArr,$setDataArr2);
				//print_R($setDataArr);
				
			}
			/*
			echo "<pre>";
			print_R($setDataArr);
			echo "</pre>";
			exit();
			*/
			if(count($setDataArr)>0){
				$setDataString = implode(" , ", $setDataArr);
				
				if (isset($changeStatus[0]) && $changeStatus[0] == 'password') {
					$Query = "UPDATE user_master SET $setDataString WHERE email = '".$UserData->email."'";
				}else
				{
					$Query = "UPDATE user_master SET $setDataString WHERE userid = ".$UserData->userid;
				}
			 	//
			}
			
		}else{
			 $UpdateData = $UserData->InternalSync(RDataModel::UPDATE, "firstname","lastname","company","city","street_address","suburb","postcode","state","state_code","country","sender_area_code","phone_number","sender_mb_area_code","mobile_no","user_type_id","corporate_id","site_language_id","last_login_date","address1","address2","address3","security_ques_1","security_ans_1","security_ques_2","security_ans_2","login_attempt","ip_address","last_login_attempt_datetime");
       		 $Query = "UPDATE user_master SET $UpdateData WHERE userid = ". $UserData->userid;
       		
		}
		}
		// update query for the login attempts...whose time has expired
		
       	/**
		  * check that data should be updated perfectly.
		  * if no then throw or return proper error message.
		  */
		$ThrowException = null;
		try {
	  		$Rs = $this->Connection->Execute($Query);
	  		if ( $Rs->AffectedRows() == 0 )	{
				//throw new Exception(' Fail To Edit user_master Record ');
				return false;
	  		}
		} catch(Exception $Exception) {
			if($ThrowError == true) {
				$ThrowException = new Exception(' Fail To Edit user_master Record ');
			 } else {
				return false;
			 }
    	}// try-catch end

		if ($ThrowException) {
			throw $ThrowException;
		} else {
			return true;
		}
	}//editAdminUser Function End

	 /**
	 * Delete user's all records from different tables
	 *
	 * @param int $ContentId
	 *
	 */
	 public function deleteUser($user_id=null)
	 {
		if( isset($user_id) && ($user_id!=null)) {
			$UserInfoData=array();
			$UserInfoData[] = array('table'=>'user_master', 'field'=>'userid');
			$UserInfoData[] = array('table'=>'user_basket', 'field'=>'user_id');
			$UserInfoData[] = array('table'=>'user_images', 'field'=>'user_id');
			$UserInfoData[] = array('table'=>'user_template', 'field'=>'user_id');
			$UserInfoData[] = array('table'=>'address_book', 'field'=>'user_id');

			foreach ($UserInfoData as $key => $value) {
				$Query ="delete from ". $value['table']  ." where ".$value['field']." = ".$user_id;

				$ThrowException = null;
				try {
					$this->Connection->Execute($Query);
				} catch (Exception $Exception) {
					if($ThrowError == true) {
						$ThrowException = new Exception(' Not any Record Found For this Id :'.$ContentId."<br>");
					} else {
						return false;
					}
				}// try catch end
			}
  		} // if end
	}// Function End

	/**
	 * GetUser method is used for to get all or selected columns records from user_master with searching, sorting and paging criteria.
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
	public function getUser($fieldArr=null, $seaArr=null, $optArr=null, $start=null, $total=null, $QueryString=null, $ThrowError=true)
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
		if($QueryString!=''){
			$Query = $QueryString;
		}else{
			$Query = "SELECT $fields FROM user_master $whereExtra  $optstring $limitString";
		}
		//echo $Query;
		
		//exit;
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
  		
	    if($QueryString!=''){
    		$UserData = array();
    		//assing all fetched records into CategoryData Object
	   	    foreach ($Rs as $Record) {
			 	$UserData[]=$Record;
		    }//foreach end
	    }else{
		    //Create CategoryData Object
	   	    $UserData = new RModelCollection();
	   	    
	   	    //assing all fetched records into CategoryData Object
	   	    foreach ($Rs as $Record) {
			 	$UserData->Add(new UserData($Record));
		    }//foreach end
	    }
	    
	    return $UserData;//return the fetched recordset		
	}//getUser function end
	
	
	/*
	* to fetch data for user listing in admin panel
	*/
		
	public function getUserListing($fieldArr=null, $orderBy = null, $start=null, $total=null, $seaArr=null, $ThrowError=true,$find_total=false)
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
				$limitString .= " LIMIT ".$total." OFFSET ".$start;
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
					$whereExtra = "WHERE 1 $whereExtra";
				}
			}	
			
			/*$Query ="SELECT $fields
						FROM user_master
						LEFT JOIN orders ON user_master.userid = orders.user_id 
						LEFT JOIN countries ON user_master.country = countries.countries_id
						$whereExtra GROUP BY user_master.userid ". $sortString . $limitString;*/
			
			$Query="SELECT $fields FROM user_master LEFT JOIN countries ON user_master.country = countries.countries_id  $whereExtra GROUP BY user_master.userid ". $sortString . $limitString;
			
			if($find_total==true){
			    $Rs = $this->Connection->Execute($Query); 
				return($Rs->RecordCount());
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
					$ThrowException = new Exception(' No Record Found For:'.$order_id."<br>".$Rs);
				} else {
					return false;	
				}// if -else end
				
			}//try-catch end	
						
			return $Rs;
		
	}//getBytemplate_id Function e
	
}