<?php

/**
 * This is FaqCategoryData model file.
 * Create interaction between FaqCategoryMaster (business logic) and faq_category table by mapping all fields.
 * PropertyMap method return array which has similar elements of faq_category table fields and used in controller file.
 * 
 * TABLE_NAME: faq_category 
 * LICENSE:    License Information (if any) ...
 * 
 * @uses Create interface between faq_category table and FaqCategoryMaster (business logic) files.
 * 
 * @package    Faq Management Section
 * @author     Radix
 * @copyright  Document Copyright information, e.g. Copyright (c) 2008, Radixweb
 * @license    Display a hyperlink to a URL for a license, e.g. http://opensource.org/licenses/gpl-license.php GNU Public License
 * @version    $Id: FaqCategoryData.php,v 1.0
 * @link       Display a hyperlink to a URL in the documentation, e.g. http://radixweb.com
 * @since      Document when (at which version) an element was first added to a package e.g. Version 1.0 
 * 
 */

/**
 * @see RDataModel.php for extended RdataModel class
 */
require_once(DIR_LIB_CLASSES_MODELS."/RDataModel.php");

class FaqCategoryData extends RDataModel
{		
   /**
    *  To define FaqCategory data
    *
    * @return array array $PropMap : Each Element associate with table fields for to use as a property of FaqCategoryMaster object
    */	
    protected function PropertyMap() 
    {
		
        //define array for mapping all table fields as a FaqCategoryMaster object properties.
 		$PropMap = array();
		
		//assign all category table fields details like name, type and so on into array.
		$PropMap['faqcat_id'] 	 		= array('Field', 'faqcat_id', 'faqcat_id', 'int');
		$PropMap['status'] 		 		= array('Field', 'status', 'status', 'string');
		$PropMap['sort_order'] 		 	= array('Field', 'sort_order', 'sort_order', 'int');
		$PropMap['faq_category_name'] 	= array('Field', 'faq_category_name', 'faq_category_name', 'string');
		$PropMap['site_language_id'] 	= array('Field', 'site_language_id', 'site_language_id', 'int');
		$PropMap['total'] 				= array('Field', 'total', 'total', 'int');
		
		return $PropMap;
	}
}