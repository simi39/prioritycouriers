<?php
/**
 * This is AddressData model file.
 * Create interaction between AddressMaster (business logic) and address_book table by mapping all fields.
 * PropertyMap method return array which has similar elements of address_book table fields and used in controller file.
 * 
 * TABLE_NAME: address_book
 * LICENSE:    License Information (if any) ...
 * 
 * @uses Create interface between address_book table and AddressMaster (business logic) files.
 * 
 * @package    User Address Management
 * @author     Radixweb
 * @copyright  Document Copyright information, e.g. Copyright (c) 2008, Radixweb
 * @license    Display a hyperlink to a URL for a license, e.g. http://opensource.org/licenses/gpl-license.php GNU Public License
 * @version    $Id: AddressData.php,v 1.0
 * @link       Display a hyperlink to a URL in the documentation, e.g. http://radixweb.com
 * @since      Document when (at which version) an element was first added to a package e.g. Version 1.0
 * 
 */

/**
 * @see RDataModel.php for extended RdataModel class
 */
require_once(DIR_LIB_CLASSES_MODELS."/RDataModel.php");           // From class section

class AddressData extends RDataModel
{
   /**
    *  To define Address data
    *
    * @return array array $PropMap : Each Element associate with table fields for to use as a property of AddressMaster object
    */
    protected function PropertyMap()
    {
        //define array for mapping all table fields as a AddressMaster object properties.
 		$PropMap = array();

		//assign all category table fields details like name, type and so on into array.
		$PropMap['address_book_id'] 	= array('Field', 'address_book_id', 'address_book_id', 'int');
		$PropMap['user_id'] 		 	= array('Field', 'user_id', 'user_id', 'int');
		$PropMap['account_no'] 		 	= array('Field', 'account_no', 'account_no', 'int');		
		$PropMap['firstname']        	= array('Field', 'firstname', 'firstname', 'string');
		$PropMap['lastname'] 	    	= array('Field', 'lastname', 'lastname', 'string');
		$PropMap['street_address']      = array('Field', 'street_address', 'street_address', 'string');
		$PropMap['suburb'] 		        = array('Field', 'suburb', 'suburb', 'string');
		$PropMap['postcode'] 		    = array('Field', 'postcode', 'postcode', 'string');
		$PropMap['city'] 		 	    = array('Field', 'city', 'city', 'string');
		$PropMap['state'] 		        = array('Field', 'state', 'state', 'string');
		$PropMap['state_code'] 		        = array('Field', 'state_code', 'state_code', 'string');
		$PropMap['country'] 		    = array('Field', 'country', 'country', 'string');
		$PropMap['sender_area_code'] 	= array('Field', 'sender_area_code', 'sender_area_code', 'string');
		$PropMap['phone_number'] 		= array('Field', 'phone_number', 'phone_number', 'string');
		$PropMap['default_address'] 	= array('Field', 'default_address', 'default_address', 'string');
		$PropMap['from_signup'] 		= array('Field', 'from_signup', 'from_signup', 'string'); 
		$PropMap['total'] 				= array('Field', 'total', 'total', 'int');

		return $PropMap;
	}
}