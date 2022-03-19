<?php /**
 * This is SiteLanguageData model file.
 * Create interaction between SiteLanguageMaster (business logic) and TABLE_NAME table by mapping all fields.
 * PropertyMap method return array which has similar elements of TABLE_NAME table fields and used in controller file.
 * 
 * TABLE_NAME: TABLE_NAME 
 * LICENSE:    License Information (if any) ...
 * 
 * @uses Create interface between TABLE_NAME table and SiteLanguageMaster (business logic) files.
 * 
 * @package    Specify package to group classes or functions and defines into
 * @author     radixweb
 * @copyright  Document Copyright information, e.g. Copyright (c) 2008, Radixweb
 * @license    Display a hyperlink to a URL for a license, e.g. http://opensource.org/licenses/gpl-license.php GNU Public License
 * @version    $Id: SiteLanguageData.php,v 1.0
 * @link       Display a hyperlink to a URL in the documentation, e.g. http://radixweb.com
 * @since      Document when (at which version) an element was first added to a package e.g. Version 1.0 
 * 
 */

/**
 * @see RDataModel.php for extended RdataModel class
 */
require_once(DIR_LIB_CLASSES_MODELS."/RDataModel.php");

class SiteLanguageData extends RDataModel
{		
   /**
    *  To define SiteLanguage data
    *
    * @return array array $PropMap : Each Element associate with table fields for to use as a property of SiteLanguageMaster object
    */	
    protected function PropertyMap() 
    {
		
        //define array for mapping all table fields as a SiteLanguageMaster object properties.
 		$PropMap = array();
		
		//assign all category table fields details like name, type and so on into array.
		$PropMap['site_language_id'] 	 	= array('Field', 'site_language_id', 'site_language_id', 'int');
		$PropMap['site_language_name'] 	= array('Field', 'site_language_name', 'site_language_name', 'string');
		$PropMap['shortname'] 	 	= array('Field', 'shortname', 'shortname', 'string');
		$PropMap['folder_name'] 	 	= array('Field', 'folder_name', 'folder_name', 'string');
		$PropMap['image_name'] 	 	= array('Field', 'image_name', 'image_name', 'string');
		$PropMap['default_language'] 	 	= array('Field', 'default_language', 'default_language', 'string');
		$PropMap['status'] 	 	= array('Field', 'status', 'status', 'string');
		
		return $PropMap;
	}
}?>