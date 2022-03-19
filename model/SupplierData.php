<?php
/**
 * This is SupplierData model file.
 * Create interaction between SupplierMaster (business logic) and supplier_detail table by mapping all fields.
 * PropertyMap method return array which has similar elements of admin_pages table fields and used in controller file.
 * 
 * TABLE_NAME: supplier_detail 
 * LICENSE:    License Information (if any) ...
 * 
 * @uses Create interface between cms_pages table and SupplierMaster (business logic) files.
 * 
 * @package    Supplier Managment
 * @author     Radixweb
 * @copyright  Document Copyright information, e.g. Copyright (c) 2008, Radixweb
 * @license    Display a hyperlink to a URL for a license, e.g. http://opensource.org/licenses/gpl-license.php GNU Public License
 * @version    $Id: SupplierData.php,v 1.0
 * @link       Display a hyperlink to a URL in the documentation, e.g. http://radixweb.com
 * @since      Document when (at which version) an element was first added to a package e.g. Version 1.0 
 * 
 */

/**
 * @see RDataModel.php for extended RdataModel class
 */
require_once(DIR_LIB_CLASSES_MODELS."/RDataModel.php");

class SupplierData extends RDataModel
{		
   /**
    *  To define SupplierPages data
    *
    * @return array array $PropMap : Each Element associate with table fields for to use as a property of SupplierMaster object
    */	
    protected function PropertyMap() 
    {
        //define array for mapping all table fields as a SupplierMaster object properties.
 		$PropMap = array();

		//assign all category table fields details like name, type and so on into array.
		
		/* Master Table Field */
		$PropMap['auto_id'] 	 = array('Field', 'auto_id', 'auto_id', 'int');
		$PropMap['supplier_name'] 	 = array('Field', 'supplier_name', 'supplier_name', 'string');
		$PropMap['code'] 	 = array('Field', 'code', 'code', 'string');
		$PropMap['fuel_charge'] 	 = array('Field', 'fuel_charge', 'fuel_charge', 'string');
		$PropMap['code_formate'] 	 = array('Field', 'code_formate', 'code_formate', 'int');
		
		return $PropMap;
	}
}