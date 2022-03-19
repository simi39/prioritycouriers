<?php

/**
 * This is SiteConstantData model file.
 * Create interaction between SiteConstantMaster (business logic) and TABLE_NAME table by mapping all fields.
 * PropertyMap method return array which has similar elements of TABLE_NAME table fields and used in controller file.
 * 
 * TABLE_NAME: TABLE_NAME 
 * LICENSE:    License Information (if any) ...
 * 
 * @uses Create interface between TABLE_NAME table and SiteConstantMaster (business logic) files.
 * 
 * @package    Specify package to group classes or functions and defines into
 * @author     Radixweb Team
 * @copyright  Document Copyright information, e.g. Copyright (c) 2008, Radixweb
 * @license    Display a hyperlink to a URL for a license, e.g. http://opensource.org/licenses/gpl-license.php GNU Public License
 * @version    $Id: SiteConstantData.php,v 1.0
 * @link       Display a hyperlink to a URL in the documentation, e.g. http://radixweb.com
 * @since      Document when (at which version) an element was first added to a package e.g. Version 1.0 
 * 
 */

/**
 * @see RDataModel.php for extended RdataModel class
 */
require_once(DIR_LIB_CLASSES_MODELS."/RDataModel.php");

class SiteConstantData extends RDataModel
{		
   /**
    *  To define SiteConstan data
    *
    * @return array array $PropMap : Each Element associate with table fields for to use as a property of SiteConstantMaster object
    */	
    protected function PropertyMap() 
    {
		
        //define array for mapping all table fields as a SiteConstantMaster object properties.
 		$PropMap = array();
		
		//assign all category table fields details like name, type and so on into array.
		$PropMap['auto_id'] 	 		= array('Field', 'auto_id', 'auto_id', 'int');
		$PropMap['constant_name'] 	 		= array('Field', 'constant_name', 'constant_name', 'string');
		$PropMap['constant_id'] 	 		= array('Field', 'constant_id', 'constant_id', 'int');
		$PropMap['constant_value'] 	 		= array('Field', 'constant_value', 'constant_value', 'int');
		$PropMap['front_group_id'] 	 	    = array('Field', 'front_group_id', 'front_group_id', 'int');
		
		
		
		
		return $PropMap;
	}
}

?>