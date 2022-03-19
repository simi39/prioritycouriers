<?php
/**
 * This is TransitGuideRoadExpressData model file.
 * Create interaction between TransitGuideRoadExpressMaster (business logic) and transitguide_roadexpress table by mapping all fields.
 * PropertyMap method return array which has similar elements of transitguide_roadexpress table fields and used in controller file.
 * 
 * transitguide_roadexpress: transitguide_roadexpress 
 * LICENSE:    License Information (if any) ...
 * 
 * @uses Create interface between transitguide_roadexpress table and TransitGuideRoadExpressMaster (business logic) files.
 * 
 * @package    Specify package to group classes or functions and defines into
 * @author     AUTHOR_NAME
 * @copyright  Document Copyright information, e.g. Copyright (c) 2008, Radixweb
 * @license    Display a hyperlink to a URL for a license, e.g. http://opensource.org/licenses/gpl-license.php GNU Public License
 * @version    $Id: TransitGuideRoadExpressData.php,v 1.0
 * @link       Display a hyperlink to a URL in the documentation, e.g. http://radixweb.com
 * @since      Document when (at which version) an element was first added to a package e.g. Version 1.0 
 * 
 */

/**
 * @see RDataModel.php for extended RdataModel class
 */
require_once(DIR_LIB_CLASSES_MODELS."/RDataModel.php");

class TransitGuideRoadExpressData extends RDataModel
{		
   /**
    *  To define TransitGuideRoadExpress data
    *
    * @return array array $PropMap : Each Element associate with table fields for to use as a property of TransitGuideRoadExpressMaster object
    */	
    protected function PropertyMap() 
    {
		
        //define array for mapping all table fields as a TransitGuideRoadExpressMaster object properties.
 		$PropMap = array();
		
		//assign all category table fields details like name, type and so on into array.
		$PropMap['auto_id'] 	= array('Field', 'auto_id', 'auto_id', 'int');
		$PropMap['State']  	= array('Field', 'State', 'State', 'string');
		$PropMap['Zone'] = array('Field', 'Zone', 'Zone', 'string');
		$PropMap['days']        	= array('Field', 'days', 'days', 'string');
		return $PropMap;		
		
	}
}
?>