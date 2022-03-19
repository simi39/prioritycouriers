<?php
/**
 * This is InternatioanlItemTypeData model file.
 * Create interaction between InternationalItemTypeMaster (business logic) and international_items table by mapping all fields.
 * PropertyMap method return array which has similar elements of international_items table fields and used in controller file.
 * 
 * TABLE_NAME: international_items 
 * LICENSE:    License Information (if any) ...
 * 
 * @uses Create interface between international_items table and InternationalItemTypeMaster (business logic) files.
 * 
 * @package    InternationalItemType
 * @author     Radixweb
 * @copyright  Document Copyright information, e.g. Copyright (c) 2008, Radixweb
 * @license    Display a hyperlink to a URL for a license, e.g. http://opensource.org/licenses/gpl-license.php GNU Public License
 * @version    $Id: InternatioanlItemTypeData.php,v 1.0
 * @link       Display a hyperlink to a URL in the documentation, e.g. http://radixweb.com
 * @since      Document when (at which version) an element was first added to a package e.g. Version 1.0 
 * 
 */

/**
 * @see RDataModel.php for extended RdataModel class
 */
require_once(DIR_LIB_CLASSES_MODELS."/RDataModel.php");

class InternationalItemTypeData extends RDataModel
{		
   /**
    *  To define InternatioanlItemType data
    *
    * @return array array $PropMap : Each Element associate with table fields for to use as a property of InternationalItemTypeMaster object
    */	
    protected function PropertyMap() 
    {
		
        //define array for mapping all table fields as a InternationalItemTypeMaster object properties.
 		$PropMap = array();
		
		//assign all category table fields details like name, type and so on into array.
		$PropMap['item_id'] 	 		= array('Field', 'item_id', 'item_id', 'int');
		$PropMap['item_name'] 	 		= array('Field', 'item_name', 'item_name', 'string');
		
		
		return $PropMap;
	}
}

?>