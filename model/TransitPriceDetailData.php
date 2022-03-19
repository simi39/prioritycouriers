<?php
/**
 * This is TransitPriceDetailData model file.
 * Create interaction between TransitPriceDetailMaster (business logic) and transit_warranty_details table by mapping all fields.
 * PropertyMap method return array which has similar elements of transit_warranty_details table fields and used in controller file.
 * 
 * TABLE_NAME: transit_warranty_details 
 * LICENSE:    License Information (if any) ...
 * 
 * @uses Create interface between transit_warranty_details table and TransitPriceDetailMaster (business logic) files.
 * 
 * @package    Specify package to group classes or functions and defines into
 * @author     Shailesh jamanapara
 * @copyright  Document Copyright information, e.g. Copyright (c) 2008, Radixweb
 * @license    Display a hyperlink to a URL for a license, e.g. http://opensource.org/licenses/gpl-license.php GNU Public License
 * @version    $Id: TransitPriceDetailData.php,v 1.0
 * @link       Display a hyperlink to a URL in the documentation, e.g. http://radixweb.com
 * @since      Document when (at which version) an element was first added to a package e.g. Version 1.0 
 * 
 */

/**
 * @see RDataModel.php for extended RdataModel class
 */
require_once(DIR_LIB_CLASSES_MODELS."/RDataModel.php");

class TransitPriceDetailData extends RDataModel
{		
   /**
    *  To define TransitPriceDetail data
    *
    * @return array array $PropMap : Each Element associate with table fields for to use as a property of TransitPriceDetailMaster object
    */	
    protected function PropertyMap() 
    {
		
        //define array for mapping all table fields as a TransitPriceDetailMaster object properties.
 		$PropMap = array();
		
		//assign all category table fields details like name, type and so on into array.
		$PropMap['id'] 	 		= array('Field', 'id', 'id', 'int');
		$PropMap['transit_master_id'] 		 	= array('Field', 'transit_master_id', 'transit_master_id', 'int');
		$PropMap['transit_method'] 		 	= array('Field', 'transit_method', 'transit_method', 'int');
		$PropMap['percent_of_goods_val'] 		 	= array('Field', 'percent_of_goods_val', 'percent_of_goods_val', 'int');
		$PropMap['transit_flat_fee'] 		 	= array('Field', 'transit_flat_fee', 'transit_flat_fee', 'int');
		$PropMap['transit_basic_fee'] 		 	= array('Field', 'transit_basic_fee', 'transit_basic_fee', 'int');
		$PropMap['transit_min_charge'] 		 	= array('Field', 'transit_min_charge', 'transit_min_charge', 'int');
		
		
		
		return $PropMap;
	}
}
?>