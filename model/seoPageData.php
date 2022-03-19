<?php
/**
 * This is seoPageData model file.
 * Create interaction between seoPageMaster (business logic) and site_seo and site_seo_description table by mapping all fields.
 * PropertyMap method return array which has similar elements of site_seo_description table fields and used in controller file.
 * 
 * TABLE_NAME: site_seo 
 * LICENSE:    License Information (if any) ...
 * 
 * @uses Create interface between site_seo table and seoPageMaster (business logic) files.
 * 
 * @package    Seo Pages Management
 * @author     Radixweb
 * @copyright  Document Copyright information, e.g. Copyright (c) 2008, Radixweb
 * @license    Display a hyperlink to a URL for a license, e.g. http://opensource.org/licenses/gpl-license.php GNU Public License
 * @version    $Id: seoPageData.php,v 1.0
 * @link       Display a hyperlink to a URL in the documentation, e.g. http://radixweb.com
 * @since      Document when (at which version) an element was first added to a package e.g. Version 1.0 
 * 
 */

/**
 * @see RDataModel.php for extended RdataModel class
 */
require_once(DIR_LIB_CLASSES_MODELS."/RDataModel.php");

class seoPageData extends RDataModel
{
   /**
    *  To define seoPage data
    *
    * @return array array $PropMap : Each Element associate with table fields for to use as a property of seoPageMaster object
    */
    protected function PropertyMap()
    {
        //define array for mapping all table fields as a seoPageMaster object properties.
 		$PropMap = array();

		//assign all category table fields details like name, type and so on into array.
		$PropMap['page_id'] 			= array('Field', 'page_id', 'page_id', 'int');
		$PropMap['page_name'] 		 	= array('Field', 'page_name', 'page_name', 'string');
		$PropMap['seo_page_title'] 		 	= array('Field', 'seo_page_title', 'seo_page_title', 'string');
		$PropMap['seo_page_keywords'] 		= array('Field', 'seo_page_keywords', 'seo_page_keywords', 'string');
		$PropMap['seo_page_description'] 	= array('Field', 'seo_page_description', 'seo_page_description', 'string');
		$PropMap['site_language_id'] 	= array('Field', 'site_language_id', 'site_language_id', 'int');
		
		$PropMap['total'] 				= array('Field', 'total', 'total', 'int');

		return $PropMap;
	}
}