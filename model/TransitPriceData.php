<?php
/**
 * This is TransitPriceData model file.
 * Create interaction between TransitPriceMaster (business logic) and transit_warranty table by mapping all fields.
 * PropertyMap method return array which has similar elements of transit_warranty table fields and used in controller file.
 * 
 * TABLE_NAME: transit_warranty 
 * LICENSE:    License Information (if any) ...
 * 
 * @uses Create interface between transit_warranty table and TransitPriceMaster (business logic) files.
 * 
 * @package    Specify package to group classes or functions and defines into
 * @author     Shailesh Jamanapara
 * @copyright  Document Copyright information, e.g. Copyright (c) 2008, Radixweb
 * @license    Display a hyperlink to a URL for a license, e.g. http://opensource.org/licenses/gpl-license.php GNU Public License
 * @version    $Id: TransitPriceData.php,v 1.0
 * @link       Display a hyperlink to a URL in the documentation, e.g. http://radixweb.com
 * @since      Document when (at which version) an element was first added to a package e.g. Version 1.0 
 * 
 */

/**
 * @see RDataModel.php for extended RdataModel class
 */
require_once(DIR_LIB_CLASSES_MODELS."/RDataModel.php");

class TransitPriceData extends RDataModel
{		
   /**
    *  To define TransitPrice data
    *
    * @return array array $PropMap : Each Element associate with table fields for to use as a property of TransitPriceMaster object
    */	
    protected function PropertyMap() 
    {
		
        //define array for mapping all table fields as a TransitPriceMaster object properties.
 		$PropMap = array();
		//basic_rate_type 	basic_rate_amt 	unit_rate_type 	unit_rate_amt 	minimum_rate_type 	minimum_rate_amt 	status
		//assign all category table fields details like name, type and so on into array.
		$PropMap['transit_id'] 	 		= array('Field', 'transit_id', 'transit_id', 'int');
		$PropMap['tariff_type'] 		= array('Field', 'tariff_type', 'tariff_type', 'string');
		$PropMap['tariff_goods_nature'] = array('Field', 'tariff_goods_nature', 'tariff_goods_nature', 'string');
		$PropMap['status'] 		 		= array('Field', 'status', 'status', 'int');
		$PropMap['active'] 		 		= array('Field', 'active', 'active', 'int');
				
		return $PropMap;
	}
}
?>