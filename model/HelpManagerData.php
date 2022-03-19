<?php /**
 * This is HelpManagerData model file.
 * Create interaction between HelpManagerMaster (business logic) and help_manager table by mapping all fields.
 * PropertyMap method return array which has similar elements of help_manager table fields and used in controller file.
 * 
 * TABLE_NAME: help_manager 
 * LICENSE:    License Information (if any) ...
 * 
 * @uses Create interface between help_manager table and HelpManagerMaster (business logic) files.
 * 
 * @package    help manager
 * @author     Radixweb
 * @copyright  Document Copyright information, e.g. Copyright (c) 2008, Radixweb
 * @license    Display a hyperlink to a URL for a license, e.g. http://opensource.org/licenses/gpl-license.php GNU Public License
 * @version    $Id: HelpManagerData.php,v 1.0
 * @link       Display a hyperlink to a URL in the documentation, e.g. http://radixweb.com
 * @since      Document when (at which version) an element was first added to a package e.g. Version 1.0 
 * 
 */

/**
 * @see RDataModel.php for extended RdataModel class
 */
require_once(DIR_LIB_CLASSES_MODELS."/RDataModel.php");

class HelpManagerData extends RDataModel
{		
   /**
    *  To define HelpManager data
    *
    * @return array array $PropMap : Each Element associate with table fields for to use as a property of HelpManagerMaster object
    */	
    protected function PropertyMap() 
    {
		
        //define array for mapping all table fields as a HelpManagerMaster object properties.
 		$PropMap = array();
		
		//assign all category table fields details like name, type and so on into array.
		$PropMap['help_id'] 	 		= array('Field', 'help_id', 'help_id', 'int');
		$PropMap['help_heading'] 		 	= array('Field', 'help_heading', 'help_heading', 'string');
		$PropMap['help_code'] 		 	= array('Field', 'help_code', 'help_code', 'string');
		$PropMap['help_description'] 		 	= array('Field', 'help_description', 'help_description', 'string');
		$PropMap['page_id'] 		 	= array('Field', 'page_id', 'page_id', 'int');
		
		return $PropMap;
	}
}