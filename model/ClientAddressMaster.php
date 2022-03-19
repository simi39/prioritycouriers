<?php 
/**
  * This is ClientAddressMaster file.  
  * This file contains all the business logic code related to client_address_book table.  
  *   
  * TABLE_NAME:    client_address_book   
  * PRIMARY_KEY :  addressId  
  * TABLE_COLUMNS: userid,title,firstname,surname,company,address1,address2,address3,suburb,state,postcode,email,area_code,phoneno,mobileno,suburbid,country,countryid,isDefault,type,sort_id
  *   
  * @uses By creating object of ClientAddressMaster we can handle or manage different table operation like insert, update, delete and selecting data with criteria from table.  
  *   
  * @package    Specify package to group classes or functions and defines into  
  * @author     AUTHOR_NAME  
  * @copyright  Document Copyright information, e.g. Copyright (c) 2008, Radixweb  
  * @license    Display a hyperlink to a URL for a license, e.g. http://opensource.org/licenses/gpl-license.php GNU Public License  
  * @version    $Id: ClientAddressMaster.php,v 1.0  
  * @link       Display a hyperlink to a URL in the documentation, e.g. http://radixweb.com  
  * @since      Document when (at which version) an element was first added to a package e.g. Version 1.0   
  *   
  */   
  /**  
  * @see ClientAddressData.php for Data class  */ 
  require_once(DIR_WS_MODEL."/ClientAddressData.php");  
  /**  
  * @see RMasterModel.php for extended RMasterModel class  */

  require_once(DIR_LIB_CLASSES_MODELS."/RMasterModel.php"); 

  class ClientAddressMaster extends RMasterModel 
  {     
  /**   
  * Create a null object of ClientAddressMaster   
  *  
  * @return object object $ClientAddressMasterObj   */  
   public function create()  
   {   
  		$ClientAddressMasterObj = new ClientAddressMaster();   
		return  $ClientAddressMasterObj;  
   }
   //create Function End          
   /**  
   * To insert record in client_address_book table   
   * Insert data of columns : userid,title,firstname,surname,company,address1,address2,address3,suburb,state,postcode,email,phoneno,mobileno,suburbid,country,countryid,isDefault,type,sort_id
   *   
   * @param arrayClientAddressData $ClientAddressData   
   * @param bool $ThrowError Whether to throw error or not   
   *    
   * @return int If any error, then Throw Exception otherwise inserted row id  
   */
   
	public function addClientAddress($ClientAddressData, $ThrowError=true)   
	{    
		 //build up insert query     
		 $FinalData = $ClientAddressData->InternalSync(RDataModel::INSERT, "userid","serial_address_id","title","firstname","surname","company","address1","address2","address3","suburb","state","state_code","postcode","email","area_code","phoneno","m_area_code","mobileno","suburbid","country","countryid","isDefault","type","sort_id");     
		 $Query = "INSERT INTO client_address_book $FinalData";
		//echo $Query;
			// exit();
		
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
		 			throw new Exception(' Fail To Add New client_address_book Record');    
		 		}         
		 }    
		 catch(Exception $Exception) 
		 {          
			if($ThrowError == true)
			{      
				$ThrowException = new Exception(' Fail To Add client_address_book Record ');     
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
		     return $this->Connection->LastInsertedId();    
		}     
	}//addClientAddress Function End        
	/**   
	* To update record of client_address_book table   
	* Update data of columns : userid,title,firstname,surname,company,address1,address2,address3,suburb,state,postcode,email,area_code,phoneno,mobileno,suburbid,country,countryid,isDefault,type,sort_id
	*    
	* @param arrayClientAddressData $ClientAddressData    
	* @param bool $ThrowError Whether to throw error or not   
	*    
	* @return bool If any error, then Throw Exception otherwise return true on success and false on failure   */

	public function editClientAddress($ClientAddressData,$ThrowError=true,$admin=false,$emailSave=null)   
	{       
	//build up update query   
	/*if($status=="editAus")
	{
		$UpdateData = $ClientAddressData->InternalSync(RDataModel::UPDATE,title,firstname,surname,company,address1,address2,address3,email,phoneno,mobileno,country,suburbid,isDefault,type,sort_id);
	}
	else if($status=="editInter")
	{
		$UpdateData = $ClientAddressData->InternalSync(RDataModel::UPDATE,title,firstname,surname,company,address1,address2,address3,email,phoneno,mobileno,country,suburbid,suburb,state,postcode,isDefault,type,sort_id);
	}
	*/
	if($admin == true)
	{
		$UpdateData = $ClientAddressData->InternalSync(RDataModel::UPDATE,"firstname","surname","company","address1","address2","address3","suburb","state","state_code","postcode","email","area_code","phoneno","m_area_code","mobileno","suburbid","country","countryid","isDefault","type","sort_id");
		$Query = "UPDATE client_address_book SET $UpdateData WHERE addressId = '$ClientAddressData->addressId'";
	}elseif($emailSave==true)
	{
			
		$UpdateData = $ClientAddressData->InternalSync(RDataModel::UPDATE, "userid","addressId","email");
		$Query = "UPDATE client_address_book SET $UpdateData WHERE userid = '$ClientAddressData->userid' && addressId = ". $ClientAddressData->addressId;
		
	}else{
		$UpdateData = $ClientAddressData->InternalSync(RDataModel::UPDATE, "userid","serial_address_id","title","firstname","surname","company","address1","address2","address3","suburb","state","state_code","postcode","email","area_code","phoneno","m_area_code","mobileno","suburbid","country","countryid","isDefault","type","sort_id");
		$Query = "UPDATE client_address_book SET $UpdateData WHERE userid = '$ClientAddressData->userid' && serial_address_id = ". $ClientAddressData->serial_address_id;
	}
		//echo $Query;
		//exit();
		/**     
		* check that data should be updated perfectly.     
		* if no then throw or return proper error message.     */
		$ThrowException = null;  
		try 
		{
		      $Rs = $this->Connection->Execute($Query);
		      if ( $Rs->AffectedRows() == 0 ) 
		      {     
		      		//throw new Exception(' Fail To Edit client_address_book Record ');
		      		return false;
		      }  
		}//try end   
		catch(Exception $Exception)
		{
		    if($ThrowError == true) 
		    {
		         $ThrowException = new Exception(' Fail To Edit client_address_book Record ');
			} else 
			{     return false;      }      
		}// try-catch end
		if ($ThrowException)
		{
		    throw $ThrowException;    
		} 		    
		else 
		{		    return true;   }     
	}//editClientAddress Function End      
	
/**
* To delete client_address_book data   
*   
* @param int addressId $addressId    
* @param bool $ThrowError Whether to throw or not to throw error   
*    
* @return bool If any error, then Throw Exception otherwise return true on success and false on failure   
*/    
public function deleteClientAddress($addressId,$userId=null, $ThrowError=true)
{
      if(isset($addressId) && ($addressId!=null))
      {            //build up delete query
			if(isset($userId) && ($userId!=null))
			{
				$Query ="DELETE FROM client_address_book WHERE userid = '$userId' AND serial_address_id = " . $addressId;
			}else{
				$Query ="DELETE FROM client_address_book WHERE serial_address_id = " . $addressId;
			}
			//exit();
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
			              $ThrowException = new Exception(' Fail To Delete client_address_book Record');     
			     }         
			     else 
			     {      return false;         }    
			}// try catch end               
			     
		} // if end         
}//deleteClientAddress Function End         


/**   
* GetClientAddress method is used for to get all or selected columns records from client_address_book with searching, sorting and paging criteria.   
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
//$fetch_user_name for the client address book listing on the basis od userid
public function getClientAddress($fieldArr=null, $seaArr=null, $optArr=null, $start=null, $total=null, $ThrowError=true,$fetch_user_name=false,$tot=null,$list_address=false)   
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
	
	$optstring = "";    
	if(is_array($optArr) && !empty($optArr)) 
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
	//echo $whereExtra."</br>";
	//select c.`firstname` as client_firstname,c.`surname` as client_surname,c.`type`,u.firstname as user_firstname,u.lastname as user_lastname from client_address_book as c left join user_master as u on c.userid = u.userid 
	
	if($fetch_user_name==true && $fetch_user_name != ''){
		
			
		 if(isset($list_address)  && ($list_address!="")){ 
			$Query = "select client_address_book.*,countries.countries_id ,countries.countries_name from client_address_book left join countries on countries.countries_id = client_address_book.countryid ".  $whereExtra . $optstring . $limitString;
		 }else{
			$Query = "select client_address_book.*,user_master.firstname as user_firstname,	user_master.lastname as user_lastname from client_address_book left join user_master on client_address_book.userid = user_master.userid ". $optstring . $limitString;
		 }
	}else{
			$Query = "SELECT $fields FROM client_address_book $whereExtra $optstring $limitString";
	}
	
/**
* Build up query     
*/   // $Query = "SELECT $fields FROM client_address_book $whereExtra $optstring $limitString";
//echo $Query;
//echo $Query;exit();

/**
* Execute Query     
* If any error during execution of query it will return false     
*/    
try 
{
     $Rs = $this->Connection->Execute($Query);
       if($tot=='find')
			    {
			    	 	return $Rs->RecordCount();	die();
			    }
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
           $ThrowException = new Exception(' Fail To Get Any Record of client_address_book');
     }       
} // try -catch end
 //Create CategoryData Object          
 
$ClientAddressData = new RModelCollection();
	//assing all fetched records into CategoryData Object          
	
	foreach ($Rs as $Record) 
	{
	      $ClientAddressData->Add(new ClientAddressData($Record));       
	}//foreach end
	return $ClientAddressData;//return the fetched recordset     
}
//getClientAddress function end          

}//class End
