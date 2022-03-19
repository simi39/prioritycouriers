<?php
/**
 * This is CodeData model file.
 * Create interaction between CodeMaster (business logic) and supplier_detail table by mapping all fields.
 * PropertyMap method return array which has similar elements of admin_pages table fields and used in controller file.
 * 
 * TABLE_NAME: supplier_detail 
 * LICENSE:    License Information (if any) ...
 * 
 * @uses Create interface between cms_pages table and SupplierMaster (business logic) files.
 * 
 * @package    Code Format Managment
  * @since      Document when (at which version) an element was first added to a package e.g. Version 1.0 
 * 
 */

/**
 * @see RDataModel.php for extended RdataModel class
 */
require_once(DIR_LIB_CLASSES_MODELS."/RDataModel.php");

class CodeData extends RDataModel
{		
   /**
    *  To define CodePages data
    *
    * @return array array $PropMap : Each Element associate with table fields for to use as a property of CodeMaster object
    */	
    protected function PropertyMap() 
    {
        //define array for mapping all table fields as a SupplierMaster object properties.
 		$PropMap = array();

		//assign all category table fields details like name, type and so on into array.
		
		/* Master Table Field */
		$PropMap['auto_id'] 	 = array('Field', 'auto_id', 'auto_id', 'int');
		$PropMap['code_name'] 	 = array('Field', 'code_name', 'code_name', 'string');
		$PropMap['code_val'] 	 = array('Field', 'code_val', 'code_val', 'int');
		
		return $PropMap;
	}
}