<?php
/**
 * This is CommercialInvoiceItemData model file.
 * Create interaction between CommercialInvoiceItemMaster (business logic) and commercial_invoice_item_details table by mapping all fields.
 * PropertyMap method return array which has similar elements of commercial_invoice_item_details table fields and used in controller file.
 * 
 * TABLE_NAME: commercial_invoice_item_details 
 * LICENSE:    License Information (if any) ...
 * 
 * @uses Create interface between commercial_invoice_item_details table and CommercialInvoiceItemMaster (business logic) files.
 * 
 * @package    Specify package to group classes or functions and defines into
 * @author     Radixweb
 * @copyright  Document Copyright information, e.g. Copyright (c) 2008, Radixweb
 * @license    Display a hyperlink to a URL for a license, e.g. http://opensource.org/licenses/gpl-license.php GNU Public License
 * @version    $Id: CommercialInvoiceItemData.php,v 1.0
 * @link       Display a hyperlink to a URL in the documentation, e.g. http://radixweb.com
 * @since      Document when (at which version) an element was first added to a package e.g. Version 1.0 
 * 
 */

/**
 * @see RDataModel.php for extended RdataModel class
 */
require_once(DIR_LIB_CLASSES_MODELS."/RDataModel.php");

class CommercialInvoiceItemData extends RDataModel
{		
   /**
    *  To define CommercialInvoiceItem data
    *
    * @return array array $PropMap : Each Element associate with table fields for to use as a property of CommercialInvoiceItemMaster object
    */	
    protected function PropertyMap() 
    {
		
        //define array for mapping all table fields as a CommercialInvoiceItemMaster object properties.
 		$PropMap = array();
		
		//assign all category table fields details like name, type and so on into array.
		$PropMap['id'] 	 		= array('Field', 'id', 'id', 'int');
		$PropMap['commercial_item_id'] 	 		= array('Field', 'commercial_item_id', 'commercial_item_id', 'int');
		$PropMap['commercial_invoice_id'] 	 		= array('Field', 'commercial_invoice_id', 'commercial_invoice_id', 'int');
		$PropMap['commercial_description'] 	 		= array('Field', 'commercial_description', 'commercial_description', 'longtext');
		$PropMap['commercial_qty'] 	 		= array('Field', 'commercial_qty', 'commercial_qty', 'int');
		$PropMap['commercial_currency'] 	 		= array('Field', 'commercial_currency', 'commercial_currency', 'string');
		$PropMap['commercial_unit_value'] 	 		= array('Field', 'commercial_unit_value', 'commercial_unit_value', 'float');		$PropMap['commercial_value'] 	 		= array('Field', 'commercial_value', 'commercial_value', 'float');
		
		
		return $PropMap;
	}
}