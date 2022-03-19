<?php
/**
 * This is BookingDiscountDetailsData model file.
 * Create interaction between BookingDiscountDetailsMaster (business logic) and booking_discount_details table by mapping all fields.
 * PropertyMap method return array which has similar elements of booking_discount_details table fields and used in controller file.
 * 
 * TABLE_NAME: booking_discount_details 
 * LICENSE:    License Information (if any) ...
 * 
 * @uses Create interface between booking_discount_details table and BookingDiscountDetailsMaster (business logic) files.
 * 
 * @package    Specify package to group classes or functions and defines into
 * @author     shailesh Jamanapara
 * @copyright  Document Copyright information, e.g. Copyright (c) 2008, Radixweb
 * @license    Display a hyperlink to a URL for a license, e.g. http://opensource.org/licenses/gpl-license.php GNU Public License
 * @version    $Id: BookingDiscountDetailsData.php,v 1.0
 * @link       Display a hyperlink to a URL in the documentation, e.g. http://radixweb.com
 * @since      Document when (at which version) an element was first added to a package e.g. Version 1.0 
 * 
 */

/**
 * @see RDataModel.php for extended RdataModel class
 */
require_once(DIR_LIB_CLASSES_MODELS."/RDataModel.php");

class BookingDiscountDetailsData extends RDataModel
{		
   /**
    *  To define BookingDiscountDetails data
    *
    * @return array array $PropMap : Each Element associate with table fields for to use as a property of BookingDiscountDetailsMaster object
    */	
    protected function PropertyMap() 
    {
		
        //define array for mapping all table fields as a BookingDiscountDetailsMaster object properties.
 		$PropMap = array();
		
		//assign all category table fields details like name, type and so on into array.
		$PropMap['auto_id'] 	 		= array('Field', 'auto_id', 'auto_id', 'int');
		$PropMap['user_id'] 		 	= array('Field', 'user_id', 'user_id', 'int');
		$PropMap['booking_id'] 		 	= array('Field', 'booking_id', 'booking_id', 'int');
		$PropMap['booking_amt'] 		= array('Field', 'booking_amt', 'booking_amt', 'int');
		$PropMap['coupon_id'] 		 	= array('Field', 'coupon_id', 'coupon_id', 'int');
		$PropMap['coupon_amt'] 		 	= array('Field', 'coupon_amt', 'coupon_amt', 'int');
		$PropMap['nett_due_amt'] 		= array('Field', 'nett_due_amt', 'nett_due_amt', 'int');
		$PropMap['verified_status'] 	= array('Field', 'verified_status', 'verified_status', 'int');
		$PropMap['tracking_status'] 	= array('Field', 'tracking_status', 'tracking_status', 'string');
		$PropMap['payment_done'] 		= array('Field', 'payment_done', 'payment_done', 'string');
		$PropMap['rate'] 		 		= array('Field', 'rate', 'rate', 'int');
		$PropMap['sender_first_name'] 	= array('Field', 'sender_first_name', 'sender_first_name', 'string');
		$PropMap['sender_surname'] 		= array('Field', 'sender_surname', 'sender_surname', 'string');
		
		
		
				
		return $PropMap;
	}
}
?>