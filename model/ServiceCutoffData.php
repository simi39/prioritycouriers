<?php
/**
 * This is ServiceCutoffCutoffData model file.
 * Create interaction between ServiceCutoffMaster (business logic) and service cutoff table by mapping all fields.
 * PropertyMap method return array which has similar elements of admin_pages table fields and used in controller file.
 * 
 * TABLE_NAME: service_cutoff 
 * LICENSE:    License Information (if any) ...
 * 
 * @uses Create interface between cms_pages table and ServiceCutoffMaster (business logic) files.
 * 
 * @package    ServiceCutoff Managment
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

class ServiceCutoffData extends RDataModel
{		
   /**
    *  To define ServiceCutoffPages data
    *
    * @return array array $PropMap : Each Element associate with table fields for to use as a property of ServiceCutoffMaster object
    */	
    protected function PropertyMap() 
    {
        //define array for mapping all table fields as a CmsMaster object properties.
 		$PropMap = array();

		//assign all category table fields details like name, type and so on into array.
		
		/* Master Table Field */
		$PropMap['auto_id'] 	 = array('Field', 'auto_id', 'auto_id', 'int');
		$PropMap['service_name'] 	 = array('Field', 'service_name', 'service_name', 'string');
		$PropMap['hours'] 	 = array('Field', 'hours', 'hours', 'string');
		$PropMap['minites'] 	 = array('Field', 'minites', 'minites', 'string');
		$PropMap['hr_formate'] 	 = array('Field', 'hr_formate', 'hr_formate', 'string');
		

		return $PropMap;
	}
}