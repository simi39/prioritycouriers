<?php
/**
 * This is InternationalZonesData model file.
 * Create interaction between InternationalZonesMaster (business logic) and international_zones table by mapping all fields.
 * PropertyMap method return array which has similar elements of international_zones table fields and used in controller file.
 * 
 * TABLE_NAME: international_zones
 * LICENSE:    License Information (if any) ...
 * 
 * @uses Create interface between address_book table and AddressMaster (business logic) files.
 * 
 * @package    InternationalZones Management
 * @author     Radixweb
 * @copyright  Document Copyright information, e.g. Copyright (c) 2008, Radixweb
 * @license    Display a hyperlink to a URL for a license, e.g. http://opensource.org/licenses/gpl-license.php GNU Public License
 * @version    $Id: InternationalZonesData.php,v 1.0
 * @link       Display a hyperlink to a URL in the documentation, e.g. http://radixweb.com
 * @since      Document when (at which version) an element was first added to a package e.g. Version 1.0
 * 
 */

/**
 * @see RDataModel.php for extended RdataModel class
 */
require_once(DIR_LIB_CLASSES_MODELS."/RDataModel.php");           // From class section

class InternationalZonesData extends RDataModel
{
   /**
    *  To define Address data
    *
    * @return array array $PropMap : Each Element associate with table fields for to use as a property of AddressMaster object
    */
    protected function PropertyMap()
    {
        //define array for mapping all table fields as a AddressMaster object properties.
 		$PropMap = array();

		//assign all category table fields details like name, type and so on into array.
		$PropMap['id'] 	= array('Field', 'id', 'id', 'int');
		$PropMap['country']  	= array('Field', 'country', 'country', 'string');
		$PropMap['days'] = array('Field', 'days', 'days', 'string');
		$PropMap['zone']        	= array('Field', 'zone', 'zone', 'string');
		return $PropMap;
	}
}