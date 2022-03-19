<?php
/**
 * This is ServicePageData model file.
 * Create interaction between ServicePageMaster (business logic) and service_page_item table by mapping all fields.
 * PropertyMap method return array which has similar elements of service_page_item table fields and used in controller file.
 * 
 * TABLE_NAME: service_page_item 
 * LICENSE:    License Information (if any) ...
 * 
 * @uses Create interface between service_page_item table and ServicePageMaster (business logic) files.
 * 
 * @package    Specify package to group classes or functions and defines into
 * @author     Radixweb
 * @copyright  Document Copyright information, e.g. Copyright (c) 2008, Radixweb
 * @license    Display a hyperlink to a URL for a license, e.g. http://opensource.org/licenses/gpl-license.php GNU Public License
 * @version    $Id: ServicePageData.php,v 1.0
 * @link       Display a hyperlink to a URL in the documentation, e.g. http://radixweb.com
 * @since      Document when (at which version) an element was first added to a package e.g. Version 1.0 
 * 
 */

/**
 * @see RDataModel.php for extended RdataModel class
 */
require_once(DIR_LIB_CLASSES_MODELS."/RDataModel.php");

class ServicePageData extends RDataModel
{		
   /**
    *  To define ServicePage data
    *
    * @return array array $PropMap : Each Element associate with table fields for to use as a property of ServicePageMaster object
    */	
    protected function PropertyMap() 
    {
		
        //define array for mapping all table fields as a ServicePageMaster object properties.
 		$PropMap = array();
		
		//assign all category table fields details like name, type and so on into array.
		$PropMap['id'] 	 		= array('Field', 'id', 'id', 'int');
		$PropMap['service_page_name'] = array('Field', 'service_page_name', 'service_page_name', 'string');
		$PropMap['length_max'] = array('Field', 'length_max', 'length_max', 'int');
        $PropMap['girth_max'] = array('Field', 'girth_max', 'girth_max', 'int');
        return $PropMap;
	}
}

?>