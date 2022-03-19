<?php
/**
 * This is CmsPagesData model file.
 * Create interaction between CmsPagesMaster (business logic) and site_cms table by mapping all fields.
 * PropertyMap method return array which has similar elements of admin_pages table fields and used in controller file.
 * 
 * TABLE_NAME: ste_rates 
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
class SteRateData extends RDataModel
{
	/**
    *  To define PostCode Locator
    *
    * @return array array $PropMap : Each Element associate with table fields for to use as a property of PostCode Locator object
    */	
	
	protected function PropertyMap() 
	{
		//define array for mapping all table fields as a PostCode Locator object properties.
		$PropMap = array();
		//assign all category table fields details like name, type and so on into array.
		
		/* Master Table Field */
		$PropMap['auto_id'] 	 = array('Field', 'auto_id', 'auto_id', 'int');
		$PropMap['Suburb'] 	 = array('Field', 'Suburb', 'Suburb', 'string');
		$PropMap['Postcode'] 	 = array('Field', 'Postcode', 'Postcode', 'string');
		$PropMap['Nearest_depot'] 	 = array('Field', 'Nearest_depot', 'Nearest_depot', 'string');
		$PropMap['Direct_zone'] 	 = array('Field', 'Direct_zone', 'Direct_zone', 'string');
		$PropMap['Ofwd_Zone'] 	 = array('Field', 'Ofwd_Zone', 'Ofwd_Zone', 'string');
		$PropMap['Lead_days'] 	 = array('Field', 'Lead_days', 'Lead_days', 'int');
		$PropMap['Cubic_conv_factor'] = array('Field', 'Cubic_conv_factor', 'Cubic_conv_factor', 'float');
		$PropMap['Specific_minimum_charger'] = array('Field', 'Specific_minimum_charger', 'Specific_minimum_charger', 'float');
		$PropMap['Basic_charge'] = array('Field', 'Basic_charge', 'Basic_charge', 'float');
		$PropMap['Kilo_rate'] = array('Field', 'Kilo_rate', 'Kilo_rate', 'float');
		return $PropMap;
		
	}
}

?>