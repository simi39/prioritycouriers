<?php
/**
 * This is BookingCancelData model file.
 * Create interaction between BookingCancelMaster_PREFIXMaster (business logic) and TABLE_NAME table by mapping all fields.
 * PropertyMap method return array which has similar elements of TABLE_NAME table fields and used in controller file.
 * 
 * TABLE_NAME: booking_cancel 
 * LICENSE:    License Information (if any) ...
 * 
 * @uses Create interface between TABLE_NAME table and MASTER_CLASS_NAME_PREFIXMaster (business logic) files.
 * 
 * @package    Specify package to group classes or functions and defines into
 * @author     AUTHOR_NAME
 * @copyright  Document Copyright information, e.g. Copyright (c) 2008, Radixweb
 * @license    Display a hyperlink to a URL for a license, e.g. http://opensource.org/licenses/gpl-license.php GNU Public License
 * @version    $Id: BookingCancelData.php,v 1.0
 * @link       Display a hyperlink to a URL in the documentation, e.g. http://radixweb.com
 * @since      Document when (at which version) an element was first added to a package e.g. Version 1.0 
 * 
 */

/**
 * @see RDataModel.php for extended RdataModel class
 */
require_once(DIR_LIB_CLASSES_MODELS."/RDataModel.php");

class BookingCancelData extends RDataModel
{		
   /**
    *  To define BookingCancel data
    *
    * @return array array $PropMap : Each Element associate with table fields for to use as a property of MASTER_CLASS_NAME_PREFIXMaster object
    */	
    protected function PropertyMap() 
    {
		
        //define array for mapping all table fields as a MASTER_CLASS_NAME_PREFIXMaster object properties.
 		$PropMap = array();
		
		//assign all category table fields details like name, type and so on into array.
		$PropMap['cancellation_id'] 	 		= array('Field', 'cancellation_id', 'cancellation_id', 'int');
		$PropMap['booking_id'] 	 		= array('Field', 'booking_id', 'booking_id', 'int');
		$PropMap['CCConnote'] 	 		= array('Field', 'CCConnote', 'CCConnote', 'string');
		$PropMap['Approved'] 	 		= array('Field', 'Approved', 'Approved', 'string');
		
		
		return $PropMap;
	}
}
?>