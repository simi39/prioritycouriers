<?php

/**
 * This is ConfigurationData model file.
 * Create interaction between ConfigurationMaster (business logic) and configuration_master table by mapping all fields.
 * PropertyMap method return array which has similar elements of configuration_master table fields and used in controller file.
 * 
 * TABLE_NAME: configuration_master 
 * LICENSE:    License Information (if any) ...
 * 
 * @uses Create interface between configuration_master table and ConfigurationMaster (business logic) files.
 * 
 * @package    Specify package to group classes or functions and defines into
 * @author     Radixweb
 * @copyright  Document Copyright information, e.g. Copyright (c) 2008, Radixweb
 * @license    Display a hyperlink to a URL for a license, e.g. http://opensource.org/licenses/gpl-license.php GNU Public License
 * @version    $Id: ConfigurationData.php,v 1.0
 * @link       Display a hyperlink to a URL in the documentation, e.g. http://radixweb.com
 * @since      Document when (at which version) an element was first added to a package e.g. Version 1.0 
 * 
 */

/**
 * @see RDataModel.php for extended RdataModel class
 */
require_once(DIR_LIB_CLASSES_MODELS."/RDataModel.php");
//exit();
class ConfigurationData extends RDataModel
{		
   /**
    *  To define Configuration data
    *
    * @return array array $PropMap : Each Element associate with table fields for to use as a property of ConfigurationMaster object
    */	
    protected function PropertyMap() 
    {
		
        //define array for mapping all table fields as a ConfigurationMaster object properties.
 		$PropMap = array();
		
		//assign all category table fields details like name, type and so on into array.
		$PropMap['configuration_id'] 	= array('Field', 'configuration_id', 'configuration_id', 'int');
		$PropMap['constant_name'] 		= array('Field', 'constant_name', 'constant_name', 'string');
		$PropMap['set_value'] 		 	= array('Field', 'set_value', 'set_value', 'string');
		$PropMap['default_value'] 		= array('Field', 'default_value', 'default_value', 'string');
		$PropMap['element_type'] 		= array('Field', 'element_type', 'element_type', 'string');
		$PropMap['value_limit'] 		= array('Field', 'value_limit', 'value_limit', 'int');
		$PropMap['sort_order'] 		 	= array('Field', 'sort_order', 'sort_order', 'int');
		$PropMap['value_type'] 		 	= array('Field', 'value_type', 'value_type', 'string');
		$PropMap['description'] 		= array('Field', 'description', 'description', 'string');
		$PropMap['site_language_id'] 	= array('Field', 'site_language_id', 'site_language_id', 'int');
		
		return $PropMap;
	}
}

?>