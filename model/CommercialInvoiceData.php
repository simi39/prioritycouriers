<?php
/**
 * This is CommercialInvoiceData model file.
 * Create interaction between CommercialInoviceMaster (business logic) and commercial_invoice table by mapping all fields.
 * PropertyMap method return array which has similar elements of commercial_invoice table fields and used in controller file.
 * 
 * TABLE_NAME: commercial_invoice 
 * LICENSE:    License Information (if any) ...
 * 
 * @uses Create interface between commercial_invoice table and CommercialInoviceMaster (business logic) files.
 * 
 * @package    Specify package to group classes or functions and defines into
 * @author     Radixweb
 * @copyright  Document Copyright information, e.g. Copyright (c) 2008, Radixweb
 * @license    Display a hyperlink to a URL for a license, e.g. http://opensource.org/licenses/gpl-license.php GNU Public License
 * @version    $Id: CommercialInvoiceData.php,v 1.0
 * @link       Display a hyperlink to a URL in the documentation, e.g. http://radixweb.com
 * @since      Document when (at which version) an element was first added to a package e.g. Version 1.0 
 * 
 */

/**
 * @see RDataModel.php for extended RdataModel class
 */
require_once(DIR_LIB_CLASSES_MODELS."/RDataModel.php");

class CommercialInvoiceData extends RDataModel
{		
   /**
    *  To define CommercialInvoice data
    *
    * @return array array $PropMap : Each Element associate with table fields for to use as a property of CommercialInoviceMaster object
    */	
    protected function PropertyMap() 
    {
		
        //define array for mapping all table fields as a CommercialInoviceMaster object properties.
 		$PropMap = array();
		
		//assign all category table fields details like name, type and so on into array.
		$PropMap['commercial_invoice_id'] 	 		= array('Field', 'commercial_invoice_id', 'commercial_invoice_id', 'int');
		$PropMap['consignor_name'] 	 		= array('Field', 'consignor_name', 'consignor_name', 'string');
		$PropMap['consignor_company'] 	 		= array('Field', 'consignor_company', 'consignor_company', 'string');
		$PropMap['consignor_address_1'] 	 		= array('Field', 'consignor_address_1', 'consignor_address_1', 'string');
		$PropMap['consignor_address_2'] 	 		= array('Field', 'consignor_address_2', 'consignor_address_2', 'string');
		$PropMap['consignor_address_3'] 	 		= array('Field', 'consignor_address_3', 'consignor_address_3', 'string');
		$PropMap['consignor_suburb'] 	 		= array('Field', 'consignor_suburb', 'consignor_suburb', 'string');
		$PropMap['consignor_city'] 	 		= array('Field', 'consignor_city', 'consignor_city', 'string');
		$PropMap['consignor_postcode'] 	 		= array('Field', 'consignor_postcode', 'consignor_postcode', 'string');
		$PropMap['consignor_country'] 	 		= array('Field', 'consignor_country', 'consignor_country', 'string');
		$PropMap['consignor_telephone'] 	 		= array('Field', 'consignor_telephone', 'consignor_telephone', 'string');
		$PropMap['consignor_email'] 	 		= array('Field', 'consignor_email', 'consignor_email', 'string');
		$PropMap['consignee_name'] 	 		= array('Field', 'consignee_name', 'consignee_name', 'string');
		$PropMap['consignee_company'] 	 		= array('Field', 'consignee_company', 'consignee_company', 'string');
		$PropMap['consignee_address_1'] 	 		= array('Field', 'consignee_address_1', 'consignee_address_1', 'string');
		$PropMap['consignee_address_2'] 	 		= array('Field', 'consignee_address_2', 'consignee_address_2', 'string');
		$PropMap['consignee_address_3'] 	 		= array('Field', 'consignee_address_3', 'consignee_address_3', 'string');
		$PropMap['consignee_suburb'] 	 		= array('Field', 'consignee_suburb', 'consignee_suburb', 'string');
		$PropMap['consignee_city'] 	 		= array('Field', 'consignee_city', 'consignee_city', 'string');
		$PropMap['consignee_postcode'] 	 		= array('Field', 'consignee_postcode', 'consignee_postcode', 'string');
		$PropMap['consignee_country'] 	 		= array('Field', 'consignee_country', 'consignee_country', 'string');
		$PropMap['consignee_telephone'] 	 		= array('Field', 'consignee_telephone', 'consignee_telephone', 'string');
		$PropMap['consignee_email'] 	 		= array('Field', 'consignee_email', 'consignee_email', 'string');
		$PropMap['commercial_invoice_date'] 	 		= array('Field', 'commercial_invoice_date', 'commercial_invoice_date', 'string');
		$PropMap['commercial_name'] 	 		= array('Field', 'commercial_name', 'commercial_name', 'string');
		$PropMap['commercial_total'] 	 		= array('Field', 'commercial_total', 'commercial_total', 'float');
		$PropMap['country_of_manufacturing'] 	 		= array('Field', 'country_of_manufacturing', 'country_of_manufacturing', 'int');
		$PropMap['booking_id'] 	 		= array('Field', 'booking_id', 'booking_id', 'int');
		$PropMap['userid'] 	 		= array('Field', 'userid', 'userid', 'int');
				
		return $PropMap;
	}
}