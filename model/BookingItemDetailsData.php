<?php
/**
 * This is BookingItemDetailsData model file.
 * Create interaction between BookingItemDetailsMaster (business logic) and booking_item_details table by mapping all fields.
 * PropertyMap method return array which has similar elements of booking_item_details table fields and used in controller file.
 * 
 * TABLE_NAME: booking_item_details 
 * LICENSE:    License Information (if any) ...
 * 
 * @uses Create interface between booking_item_details table and BookingItemDetailsMaster (business logic) files.
 * 
 * @package    Specify package to group classes or functions and defines into
 * @author     Radixweb
 * @copyright  Document Copyright information, e.g. Copyright (c) 2008, Radixweb
 * @license    Display a hyperlink to a URL for a license, e.g. http://opensource.org/licenses/gpl-license.php GNU Public License
 * @version    $Id: BookingItemDetailsData.php,v 1.0
 * @link       Display a hyperlink to a URL in the documentation, e.g. http://radixweb.com
 * @since      Document when (at which version) an element was first added to a package e.g. Version 1.0 
 * 
 */

/**
 * @see RDataModel.php for extended RdataModel class
 */
require_once(DIR_LIB_CLASSES_MODELS."/RDataModel.php");

class BookingItemDetailsData extends RDataModel
{		
   /**
    *  To define BookingItemDetails data
    *
    * @return array array $PropMap : Each Element associate with table fields for to use as a property of BookingItemDetailsMaster object
    */	
    protected function PropertyMap() 
    {
		
        //define array for mapping all table fields as a BookingItemDetailsMaster object properties.
 		$PropMap = array();
 		$PropMap['item_name'] 	 		    = array('Field', 'item_name', 'item_name', 'string');
		
		//assign all category table fields details like name, type and so on into array.
		$PropMap['auto_id'] 	 		    = array('Field', 'auto_id', 'auto_id', 'int');
		$PropMap['booking_id'] 	 		    = array('Field', 'booking_id', 'booking_id', 'int');
		$PropMap['invoice_id'] 	 		    = array('Field', 'invoice_id', 'invoice_id', 'int');
		$PropMap['CCConnote'] 	 		    = array('Field', 'CCConnote', 'CCConnote', 'string');
		$PropMap['item_type'] 	 		    = array('Field', 'item_type', 'item_type', 'string');
		$PropMap['quantity'] 	 		    = array('Field', 'quantity', 'quantity', 'int');
		$PropMap['item_weight'] 	 		= array('Field', 'item_weight', 'item_weight', 'string');
		$PropMap['length'] 	 		        = array('Field', 'length', 'length', 'string');
		$PropMap['width'] 	 		        = array('Field', 'width', 'width', 'string');
		$PropMap['height'] 	 		        = array('Field', 'height', 'height', 'string');
		$PropMap['vol_weight'] 	 		    = array('Field', 'vol_weight', 'vol_weight', 'string');
		return $PropMap;
	}
}
?>