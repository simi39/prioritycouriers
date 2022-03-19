<?php
/**
 * This is KmGridData model file.
 * Create interaction between KmGridMaster (business logic) and km_grid table by mapping all fields.
 * PropertyMap method return array which has similar elements of km_grid table fields and used in controller file.
 * 
 * TABLE_NAME: km_grid 
 * LICENSE:    License Information (if any) ...
 * 
 * @uses Create interface between km_grid table and KmGridMaster (business logic) files.
 * 
 * @package    KmGrid
 * @author     Radixweb
 * @copyright  Document Copyright information, e.g. Copyright (c) 2008, Radixweb
 * @license    Display a hyperlink to a URL for a license, e.g. http://opensource.org/licenses/gpl-license.php GNU Public License
 * @version    $Id: KmGridData.php,v 1.0
 * @link       Display a hyperlink to a URL in the documentation, e.g. http://radixweb.com
 * @since      Document when (at which version) an element was first added to a package e.g. Version 1.0 
 * 
 */

/**
 * @see RDataModel.php for extended RdataModel class
 */
require_once(DIR_LIB_CLASSES_MODELS."/RDataModel.php");

class KmGridData extends RDataModel
{		
   /**
    *  To define KmGrid data
    *
    * @return array array $PropMap : Each Element associate with table fields for to use as a property of KmGridMaster object
    */	
    protected function PropertyMap() 
    {
		
        //define array for mapping all table fields as a KmGridMaster object properties.
 		$PropMap = array();
		
		//assign all category table fields details like name, type and so on into array.
		 
		    $PropMap['Id'] 	 		= array('Field', 'Id', 'Id', 'int');
		    $PropMap['FullName'] 	 		= array('Field', 'FullName', 'FullName', 'string');
			$PropMap['km_grid_id'] 	 		= array('Field', 'km_grid_id', 'km_grid_id', 'int');
			$PropMap['pickup_id'] 	 		= array('Field', 'pickup_id', 'pickup_id', 'int');
			$PropMap['delivery_id'] 	 		= array('Field', 'delivery_id', 'delivery_id', 'int');
			$PropMap['distance_in_km'] 	 		= array('Field', 'distance_in_km', 'distance_in_km', 'int');
				
		
		return $PropMap;
	}
}


?>