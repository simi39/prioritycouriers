<?php
/**
 * This is ItemTypeData model file.
 * Create interaction between ItemTypeMaster (business logic) and item_type table by mapping all fields.
 * PropertyMap method return array which has similar elements of item_type table fields and used in controller file.
 * 
 * TABLE_NAME: item_type 
 * LICENSE:    License Information (if any) ...
 * 
 * @uses Create interface between item_type table and ItemTypeMaster (business logic) files.
 * 
 * @package    Specify package to group classes or functions and defines into
 * @author     Radixweb
 * @copyright  Document Copyright information, e.g. Copyright (c) 2008, Radixweb
 * @license    Display a hyperlink to a URL for a license, e.g. http://opensource.org/licenses/gpl-license.php GNU Public License
 * @version    $Id: ItemTypeData.php,v 1.0
 * @link       Display a hyperlink to a URL in the documentation, e.g. http://radixweb.com
 * @since      Document when (at which version) an element was first added to a package e.g. Version 1.0 
 * 
 */

/**
 * @see RDataModel.php for extended RdataModel class
 */
require_once(DIR_LIB_CLASSES_MODELS."/RDataModel.php");

class ItemTypeData extends RDataModel
{		
   /**
    *  To define ItemType data
    *
    * @return array array $PropMap : Each Element associate with table fields for to use as a property of ItemTypeMaster object
    */	
    protected function PropertyMap() 
    {
		
        //define array for mapping all table fields as a ItemTypeMaster object properties.
 		$PropMap = array();
		
		//assign all category table fields details like name, type and so on into array.
		$PropMap['item_id'] = array('Field', 'item_id', 'item_id', 'int');
		$PropMap['item_name'] = array('Field', 'item_name', 'item_name', 'string');
		$PropMap['type'] = array('Field', 'type', 'type', 'string');
		$PropMap['sorting'] = array('Field', 'sorting', 'sorting', 'string');
		
		
		return $PropMap;
	}
}
?>