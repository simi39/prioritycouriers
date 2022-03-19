<?php
/**
 * This is DayNameData model file.
 * Create interaction between DayNameMaster (business logic) and dayname table by mapping all fields.
 * PropertyMap method return array which has similar elements of dayname table fields and used in controller file.
 * 
 * TABLE_NAME: dayname 
 * LICENSE:    License Information (if any) ...
 * 
 * @uses Create interface between dayname table and DayNameMaster (business logic) files.
 * 
 * @package    Specify package to group classes or functions and defines into
 * @author     Radixweb
 * @copyright  Document Copyright information, e.g. Copyright (c) 2008, Radixweb
 * @license    Display a hyperlink to a URL for a license, e.g. http://opensource.org/licenses/gpl-license.php GNU Public License
 * @version    $Id: DayNameData.php,v 1.0
 * @link       Display a hyperlink to a URL in the documentation, e.g. http://radixweb.com
 * @since      Document when (at which version) an element was first added to a package e.g. Version 1.0 
 * 
 */

/**
 * @see RDataModel.php for extended RdataModel class
 */
require_once(DIR_LIB_CLASSES_MODELS."/RDataModel.php");

class DayNameData extends RDataModel
{		
   /**
    *  To define DayName data
    *
    * @return array array $PropMap : Each Element associate with table fields for to use as a property of DayNameMaster object
    */	
    protected function PropertyMap() 
    {
		
        //define array for mapping all table fields as a DayNameMaster object properties.
 		$PropMap = array();
		
		//assign all category table fields details like name, type and so on into array.
		$PropMap['day'] 	 		= array('Field', 'day', 'day', 'int');
		$PropMap['day_name'] 	 	= array('Field', 'day_name', 'day_name', 'string');
		
		
		return $PropMap;
	}
}

?>