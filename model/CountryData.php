<?php
/**
 * This is CountryData model file.
 * Create interaction between CountryMaster (business logic) and countries table by mapping all fields.
 * PropertyMap method return array which has similar elements of countries table fields and used in controller file.
 * 
 * TABLE_NAME: countries
 * LICENSE:    License Information (if any) ...
 * 
 * @uses Create interface between countries table and CountryMaster (business logic) files.
 * 
 * @package    Country Management
 * @author     Radixweb
 * @copyright  Document Copyright information, e.g. Copyright (c) 2008, Radixweb
 * @license    Display a hyperlink to a URL for a license, e.g. http://opensource.org/licenses/gpl-license.php GNU Public License
 * @version    $Id: CountryData.php,v 1.0
 * @link       Display a hyperlink to a URL in the documentation, e.g. http://radixweb.com
 * @since      Document when (at which version) an element was first added to a package e.g. Version 1.0
 * 
 */

/**
 * @see RDataModel.php for extended RdataModel class
 */
require_once(DIR_LIB_CLASSES_MODELS."/RDataModel.php");

class CountryData extends RDataModel
{
   /**
    *  To define Country data
    *
    * @return array array $PropMap : Each Element associate with table fields for to use as a property of CountryMaster object
    */
    protected function PropertyMap()
    {
        //define array for mapping all table fields as a CountryMaster object properties.
 		$PropMap = array();

		//assign all category table fields details like name, type and so on into array.
		$PropMap['countries_id'] 		 	= array('Field', 'countries_id', 'countries_id', 'int');
		$PropMap['countries_name'] 			= array('Field', 'countries_name', 'countries_name', 'string');
		$PropMap['countries_iso_code_2'] 	= array('Field', 'countries_iso_code_2', 'countries_iso_code_2', 'string');
		$PropMap['countries_iso_code_3'] 	= array('Field', 'countries_iso_code_3', 'countries_iso_code_3', 'string');
		$PropMap['area_code'] 	= array('Field', 'area_code', 'area_code', 'string');
		$PropMap['address_format_id'] 		= array('Field', 'address_format_id', 'address_format_id', 'int');		
		$PropMap['status'] 		= array('Field', 'status', 'status', 'string');		
		$PropMap['state_validation'] 		= array('Field', 'state_validation', 'state_validation', 'string');		
		$PropMap['zone'] 		= array('Field', 'zone', 'zone', 'string');		
		$PropMap['days'] 		= array('Field', 'days', 'days', 'string');		

		return $PropMap;
	}
}