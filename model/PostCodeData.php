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
class PostCodeData extends RDataModel
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
		$PropMap['Id'] 	 = array('Field', 'Id', 'Id', 'int');
		$PropMap['FullName'] 	 = array('Field', 'FullName', 'FullName', 'string');
		$PropMap['Name'] 	 = array('Field', 'Name', 'Name', 'string');
		$PropMap['Postcode'] 	 = array('Field', 'Postcode', 'Postcode', 'string');
		$PropMap['State'] 	 = array('Field', 'State', 'State', 'string');
		$PropMap['Zone'] 	 = array('Field', 'Zone', 'Zone', 'string');
		$PropMap['charging_zone'] = array('Field', 'charging_zone', 'charging_zone', 'string');
		$PropMap['time_zone'] = array('Field', 'time_zone', 'time_zone', 'string');
		return $PropMap;
		
	}
}

?>