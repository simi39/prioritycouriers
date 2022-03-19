<?php
/**
 * This is CmsPagesData model file.
 * Create interaction between CmsPagesMaster (business logic) and site_cms table by mapping all fields.
 * PropertyMap method return array which has similar elements of admin_pages table fields and used in controller file.
 * 
 * TABLE_NAME: postcode_ste 
 * LICENSE:    License Information (if any) ...
 * 

 */

/**
 * @see RDataModel.php for extended RdataModel class
 */

require_once(DIR_LIB_CLASSES_MODELS."/RDataModel.php");
class StePostcodeData extends RDataModel
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
		$PropMap['Postcode'] 	 = array('Field', 'Postcode', 'Postcode', 'string');	
		$PropMap['FullName'] 	 = array('Field', 'FullName', 'FullName', 'string');	
		$PropMap['DirectZone'] 	 = array('Field', 'DirectZone', 'DirectZone', 'string');	
		$PropMap['Zone'] 	 = array('Field', 'Zone', 'Zone', 'string');			
		return $PropMap;
		
	}
}

?>