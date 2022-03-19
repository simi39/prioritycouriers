<?php
/**
 * This is SteTableData model file.
 * Create interaction between SteTableMaster (business logic) and ste_table_detail table by mapping all fields.
 * PropertyMap method return array which has similar elements of admin_pages table fields and used in controller file.
 * 
 * TABLE_NAME: ste_table_detail 
 * LICENSE:    License Information (if any) ...
 * 
 * @uses Create interface between cms_pages table and SteTableMaster (business logic) files.
 * 
 * @package    SteTable Managment
 * @author     Radixweb
 * @copyright  Document Copyright information, e.g. Copyright (c) 2008, Radixweb
 * @license    Display a hyperlink to a URL for a license, e.g. http://opensource.org/licenses/gpl-license.php GNU Public License
 * @version    $Id: SteTableData.php,v 1.0
 * @link       Display a hyperlink to a URL in the documentation, e.g. http://radixweb.com
 * @since      Document when (at which version) an element was first added to a package e.g. Version 1.0 
 * 
 */

/**
 * @see RDataModel.php for extended RdataModel class
 */
require_once(DIR_LIB_CLASSES_MODELS."/RDataModel.php");

class SteTableData extends RDataModel
{		
   /**
    *  To define SteTablePages data
    *
    * @return array array $PropMap : Each Element associate with table fields for to use as a property of SteTableMaster object
    */	
    protected function PropertyMap() 
    {
        //define array for mapping all table fields as a SteTableMaster object properties.
 		$PropMap = array();

		//assign all category table fields details like name, type and so on into array.
		
		/* Master Table Field */
		$PropMap['auto_id'] 	 = array('Field', 'auto_id', 'auto_id', 'int');
		$PropMap['table_name'] 	 = array('Field', 'table_name', 'table_name', 'string');
		$PropMap['table_formate'] 	 = array('Field', 'table_formate', 'table_formate', 'int');
		$PropMap['service_type'] 	 = array('Field', 'service_type', 'service_type', 'string');
		$PropMap['start_date'] 	 = array('Field', 'start_date', 'start_date', 'string');
		$PropMap['end_date'] 	 = array('Field', 'end_date', 'end_date', 'string');
		
		return $PropMap;
	}
}