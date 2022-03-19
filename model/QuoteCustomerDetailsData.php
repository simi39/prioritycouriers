<?php 
/** 
 * This is ClientAddressData model file.  
 * Create interaction between ClientAddressMaster (business logic) and client_address_book table by mapping all fields. 
 * PropertyMap method return array which has similar elements of client_address_book table fields and used in controller file. 
 *   
 * TABLE_NAME: client_address_book   
 * LICENSE:    License Information (if any) ...  
 *   
 * @uses Create interface between client_address_book table and ClientAddressMaster (business logic) files.  
 *   
 * @package    Specify package to group classes or functions and defines into  
 * @author     AUTHOR_NAME  * @copyright  Document Copyright information, e.g. Copyright (c) 2008, Radixweb  
 * @license    Display a hyperlink to a URL for a license, e.g. http://opensource.org/licenses/gpl-license.php GNU Public License  
 * @version    $Id: ClientAddressData.php,v 1.0  
 * @link       Display a hyperlink to a URL in the documentation, e.g. http://radixweb.com  
 * @since      Document when (at which version) an element was first added to a package e.g. Version 1.0   
 *   
 */  
 /**  
 * @see RDataModel.php for extended RdataModel class  */ 
 
 require_once(DIR_LIB_CLASSES_MODELS."/RDataModel.php");
   class QuoteCustomerDetailsData extends RDataModel
 {     
	/**     
	*  To define ClientAddress data     
	*    
	* @return array array $PropMap : Each Element associate with table fields for to use as a property of QuoteCustomerDetailsMaster object     
	*/     
	protected function PropertyMap()     
	{
		//define array for mapping all table fields as a QuoteCustomerDetailsMaster object properties.   
        $PropMap = array();      
        //assign all category table fields details like name, type and so on into array.   
		$PropMap['id']     	= array('Field', 'id', 'id', 'int'); 
		$PropMap['first_name']  	= array('Field', 'first_name', 'first_name', 'string'); 
		$PropMap['last_name']   	= array('Field', 'last_name', 'last_name', 'string'); 
		$PropMap['company']     	= array('Field', 'company', 'company', 'string'); 
		$PropMap['first_address']     	= array('Field', 'first_address', 'first_address', 'string'); 
		$PropMap['second_address']     	= array('Field', 'second_address', 'second_address', 'string'); 
		$PropMap['third_address']     	= array('Field', 'third_address', 'third_address', 'string'); 
		$PropMap['suburb']     		= array('Field', 'suburb', 'suburb', 'string'); 
		$PropMap['state']     		= array('Field', 'state', 'state', 'string'); 
		$PropMap['postcode']     	= array('Field', 'postcode', 'postcode', 'string');
		$PropMap['country']     	= array('Field', 'country', 'country', 'string');  
		$PropMap['email_id']     		= array('Field', 'email_id', 'email_id', 'string'); 
		$PropMap['contact_phone']     	= array('Field', 'contact_phone', 'contact_phone', 'string'); 
		$PropMap['phone_no']     	= array('Field', 'phone_no', 'phone_no', 'string'); 
		//This variables $PropMap['area_code']  value assigned  by shailesh jamanapara Wed Jun 19 19:48:04 IST 2013
		$PropMap['account_number'] 		= array('Field', 'account_number', 'account_number', 'string');
		
		
		return $PropMap;
	}
}