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
   class ClientAddressData extends RDataModel
 {     
	/**     
	*  To define ClientAddress data     
	*    
	* @return array array $PropMap : Each Element associate with table fields for to use as a property of ClientAddressMaster object     
	*/     
	protected function PropertyMap()     
	{
		//define array for mapping all table fields as a ClientAddressMaster object properties.   
        $PropMap = array();      
        //assign all category table fields details like name, type and so on into array.   
		$PropMap['addressId']     	= array('Field', 'addressId', 'addressId', 'int'); 
		$PropMap['userid']     		= array('Field', 'userid', 'userid', 'int'); 
		$PropMap['serial_address_id']   = array('Field', 'serial_address_id', 'serial_address_id', 'int'); 
		$PropMap['address_id']   = array('Field', 'address_id', 'address_id', 'int'); 
		$PropMap['title']     		= array('Field', 'title', 'title', 'string'); 
		$PropMap['user_firstname']  = array('Field', 'user_firstname', 'user_firstname', 'string'); 
		$PropMap['user_lastname']   = array('Field', 'user_lastname', 'user_lastname', 'string'); 
		$PropMap['firstname']     	= array('Field', 'firstname', 'firstname', 'string'); 
		$PropMap['surname']     	= array('Field', 'surname', 'surname', 'string'); 
		$PropMap['company']     	= array('Field', 'company', 'company', 'string'); 
		$PropMap['address1']     	= array('Field', 'address1', 'address1', 'string'); 
		$PropMap['address2']     	= array('Field', 'address2', 'address2', 'string'); 
		$PropMap['address3']     	= array('Field', 'address3', 'address3', 'string'); 
		$PropMap['suburb']     		= array('Field', 'suburb', 'suburb', 'string'); 
		$PropMap['state']     		= array('Field', 'state', 'state', 'string'); 
		$PropMap['state_code']     		= array('Field', 'state_code', 'state_code', 'string'); 
		$PropMap['postcode']     	= array('Field', 'postcode', 'postcode', 'string'); 
		$PropMap['email']     		= array('Field', 'email', 'email', 'string'); 
		$PropMap['phoneno']     	= array('Field', 'phoneno', 'phoneno', 'string'); 
		$PropMap['mobileno']     	= array('Field', 'mobileno', 'mobileno', 'string'); 
		$PropMap['suburbid']     	= array('Field', 'suburbid', 'suburbid', 'string'); 
		$PropMap['country']     	= array('Field', 'country', 'country', 'string'); 
		$PropMap['countryid']     	= array('Field', 'countryid', 'countryid', 'string'); 
		$PropMap['isDefault']     	= array('Field', 'isDefault', 'isDefault', 'string'); 
		$PropMap['type']     		= array('Field', 'type', 'type', 'string'); 
		$PropMap['sort_id']     	= array('Field', 'sort_id', 'sort_id', 'int'); 
		//This variables $PropMap['area_code']  value assigned  by shailesh jamanapara Wed Jun 19 19:48:04 IST 2013
		$PropMap['area_code'] 		= array('Field', 'area_code', 'area_code', 'string');
		$PropMap['m_area_code'] 	= array('Field', 'm_area_code', 'm_area_code', 'string');
		
		
		return $PropMap;
	}
}