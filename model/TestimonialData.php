<?php

/**
 * This is TestimonialData model file.
 * Create interaction between TestimonialMaster (business logic) and testimonial table by mapping all fields.
 * PropertyMap method return array which has similar elements of testimonial table fields and used in controller file.
 * 
 * TABLE_NAME: testimonial 
 * LICENSE:    License Information (if any) ...
 * 
 * @uses Create interface between testimonial table and TestimonialMaster (business logic) files.
 * 
 * @package    Testimonial Management
 * @author     Radixweb
 * @copyright  Document Copyright information, e.g. Copyright (c) 2008, Radixweb
 * @license    Display a hyperlink to a URL for a license, e.g. http://opensource.org/licenses/gpl-license.php GNU Public License
 * @version    $Id: TestimonialData.php,v 1.0
 * @link       Display a hyperlink to a URL in the documentation, e.g. http://radixweb.com
 * @since      Document when (at which version) an element was first added to a package e.g. Version 1.0 
 * 
 */

/**
 * @see RDataModel.php for extended RdataModel class
 */
require_once(DIR_LIB_CLASSES_MODELS."/RDataModel.php");

class TestimonialData extends RDataModel
{		
   /**
    *  To define Testimonial data
    *
    * @return array array $PropMap : Each Element associate with table fields for to use as a property of TestimonialMaster object
    */	
    protected function PropertyMap() 
    {
		
        //define array for mapping all table fields as a TestimonialMaster object properties.
 		$PropMap = array();
		
		//assign all category table fields details like name, type and so on into array.
		$PropMap['testimonial_id'] 	 		= array('Field', 'testimonial_id', 'testimonial_id', 'int');
		$PropMap['status'] 	 				= array('Field', 'status', 'status', 'int');
		$PropMap['sortorder'] 	 			= array('Field', 'sortorder', 'sortorder', 'int');
		$PropMap['site_id'] 	 			= array('Field', 'site_id', 'site_id', 'int');
		
		$PropMap['testimonial_title'] 	 	= array('Field', 'testimonial_title', 'testimonial_title', 'string');
		$PropMap['testimonial_description'] = array('Field', 'testimonial_description', 'testimonial_description', 'string');
		$PropMap['site_language_id'] 	 	= array('Field', 'site_language_id', 'site_language_id', 'int');
		
		$PropMap['total'] 			        = array('Field', 'total', 'total', 'int');
		return $PropMap;
	}
}


?>