<?php
/**
 * This is CmsPagesData model file.
 * Create interaction between CmsPagesMaster (business logic) and site_cms table by mapping all fields.
 * PropertyMap method return array which has similar elements of admin_pages table fields and used in controller file.
 * 
 * TABLE_NAME: site_cms 
 * LICENSE:    License Information (if any) ...
 * 
 * @uses Create interface between cms_pages table and CmsPagesMaster (business logic) files.
 * 
 * @package    CMS Management
 * @author     Radixweb
 * @copyright  Document Copyright information, e.g. Copyright (c) 2008, Radixweb
 * @license    Display a hyperlink to a URL for a license, e.g. http://opensource.org/licenses/gpl-license.php GNU Public License
 * @version    $Id: CmsData.php,v 1.0
 * @link       Display a hyperlink to a URL in the documentation, e.g. http://radixweb.com
 * @since      Document when (at which version) an element was first added to a package e.g. Version 1.0 
 * 
 */

/**
 * @see RDataModel.php for extended RdataModel class
 */
require_once(DIR_LIB_CLASSES_MODELS."/RDataModel.php");

class CmsPagesData extends RDataModel
{		
   /**
    *  To define CmsPages data
    *
    * @return array array $PropMap : Each Element associate with table fields for to use as a property of CmsPagesMaster object
    */	
    protected function PropertyMap() 
    {
        //define array for mapping all table fields as a CmsMaster object properties.
 		$PropMap = array();

		//assign all category table fields details like name, type and so on into array.
		
		/* Master Table Field */
		$PropMap['page_id'] 	 = array('Field', 'page_id', 'page_id', 'int');
		$PropMap['page_name'] 	 = array('Field', 'page_name', 'page_name', 'string');
		$PropMap['type'] 	     = array('Field', 'type', 'type', 'string');
		$PropMap['status'] 	 	 = array('Field', 'status', 'status', 'string');
		$PropMap['allow_delete'] = array('Field', 'allow_delete', 'allow_delete', 'string');
		
		/* Detail Table Field */
		
		$PropMap['site_language_id'] 	 	= array('Field', 'site_language_id', 'site_language_id', 'int');
		$PropMap['page_heading'] 		 	= array('Field', 'page_heading', 'page_heading', 'string');
		$PropMap['page_content'] 		 	= array('Field', 'page_content', 'page_content', 'string');
		$PropMap['seo_page_title'] 		 	= array('Field', 'seo_page_title', 'seo_page_title', 'string');
		$PropMap['seo_page_keywords'] 		= array('Field', 'seo_page_keywords', 'seo_page_keywords', 'string');
		$PropMap['seo_page_description'] 	= array('Field', 'seo_page_description', 'seo_page_description', 'string');
		$PropMap['total'] 					= array('Field', 'total', 'total', 'int');

		return $PropMap;
	}
}