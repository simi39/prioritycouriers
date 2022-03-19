<?php
/**
 * This is ProductLabelData model file.
 * Create interaction between ProductLabelMaster (business logic) and product_managment table by mapping all fields.
 * PropertyMap method return array which has similar elements of admin_pages table fields and used in controller file.
 * 
 * TABLE_NAME: product_managment 
 * LICENSE:    License Information (if any) ...
 * 
 * @uses Create interface between cms_pages table and ProductLabelMaster (business logic) files.
 * 
 * @package    ProductLabel Managment
 * @author     Radixweb
 * @copyright  Document Copyright information, e.g. Copyright (c) 2008, Radixweb
 * @license    Display a hyperlink to a URL for a license, e.g. http://opensource.org/licenses/gpl-license.php GNU Public License
 * @version    $Id: CmsData.php,v 1.0
 * @link       Display a hyperlink to a URL in the documentation, e.g. http://radixweb.com
 * @since      Document when (at which version) an element was first added to a package e.g. Version 1.0 
 * 
 */

/**
 * @see RDataModel.php for extended RdataModel class
 */
require_once(DIR_LIB_CLASSES_MODELS."/RDataModel.php");

class ProductLabelData extends RDataModel
{		
   /**
    *  To define ProductLabelPages data
    *
    * @return array array $PropMap : Each Element associate with table fields for to use as a property of ProductLabelMaster object
    */	
    protected function PropertyMap() 
    {
        //define array for mapping all table fields as a CmsMaster object properties.
 		$PropMap = array();

		//assign all category table fields details like name, type and so on into array.
		
		/* Master Table Field */
		$PropMap['auto_id'] 	 = array('Field', 'auto_id', 'auto_id', 'int');
		$PropMap['product_name'] 	 = array('Field', 'product_name', 'product_name', 'string');
		$PropMap['supplier_id'] 	 = array('Field', 'supplier_id', 'supplier_id', 'int');
		$PropMap['product_code'] 	 = array('Field', 'product_code', 'product_code', 'string');
		$PropMap['label_code'] 	 = array('Field', 'label_code', 'label_code', 'string');
		$PropMap['description'] 	 = array('Field', 'description', 'description', 'string');
		$PropMap['status'] 	 = array('Field', 'status', 'status', 'string');			
		return $PropMap;
	}
}