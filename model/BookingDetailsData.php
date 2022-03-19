<?php
/**
 * This is BookingDetailsData model file.
 * Create interaction between BookingDetailsMaster (business logic) and booking_details table by mapping all fields.
 * PropertyMap method return array which has similar elements of booking_details table fields and used in controller file.
 *
 * TABLE_NAME: booking_details
 * LICENSE:    License Information (if any) ...
 *
 * @uses Create interface between booking_details table and BookingDetailsMaster (business logic) files.
 *
 * @package    Specify package to group classes or functions and defines into
 * @author     AUTHOR_NAME
 * @copyright  Document Copyright information, e.g. Copyright (c) 2008, Radixweb
 * @license    Display a hyperlink to a URL for a license, e.g. http://opensource.org/licenses/gpl-license.php GNU Public License
 * @version    $Id: BookingDetailsData.php,v 1.0
 * @link       Display a hyperlink to a URL in the documentation, e.g. http://radixweb.com
 * @since      Document when (at which version) an element was first added to a package e.g. Version 1.0
 *
 */

/**
 * @see RDataModel.php for extended RdataModel class
 */
require_once(DIR_LIB_CLASSES_MODELS."/RDataModel.php");

class BookingDetailsData extends RDataModel
{
   /**
    *  To define BookingDetails data
    *
    * @return array array $PropMap : Each Element associate with table fields for to use as a property of BookingDetailsMaster object
    */
    protected function PropertyMap()
    {

        //define array for mapping all table fields as a BookingDetailsMaster object properties.
 		$PropMap = array();

		//assign all category table fields details like name, type and so on into array.
		$PropMap['booking_id'] 	 			= array('Field', 'booking_id', 'booking_id', 'string');
		$PropMap['auto_id'] 	 			= array('Field', 'auto_id', 'auto_id', 'int');
		$PropMap['total_jobs'] 	 			= array('Field', 'total_jobs', 'total_jobs', 'int');
		$PropMap['tracking_status'] 	 	= array('Field', 'tracking_status', 'tracking_status', 'string');
		$PropMap['webservice'] 	 			= array('Field', 'webservice', 'webservice', 'string');
		$PropMap['payment_done'] 	 		= array('Field', 'payment_done', 'payment_done', 'string');
		$PropMap['payment_type'] 	 		= array('Field', 'payment_type', 'payment_type', 'string');
		$PropMap['transaction_id'] 	 		= array('Field', 'transaction_id', 'transaction_id', 'string');
		$PropMap['pickupid'] 	 			= array('Field', 'pickupid', 'pickupid', 'string');
		$PropMap['deliveryid'] 	 			= array('Field', 'deliveryid', 'deliveryid', 'string');
		$PropMap['distance_in_km'] 	 		= array('Field', 'distance_in_km', 'distance_in_km', 'string');
		$PropMap['total_qty'] 	 			= array('Field', 'total_qty', 'total_qty', 'int');
		$PropMap['total_volume'] 	 		= array('Field', 'total_volume', 'total_volume', 'float');
		$PropMap['total_weight'] 	 		= array('Field', 'total_weight', 'total_weight', 'float');
		$PropMap['volumetric_weight'] 		= array('Field', 'volumetric_weight', 'volumetric_weight', 'float');
		$PropMap['chargeable_weight'] 		= array('Field', 'chargeable_weight', 'chargeable_weight', 'float');
		$PropMap['delivery_fee'] 	    	= array('Field', 'delivery_fee', 'delivery_fee', 'float');
		$PropMap['fuel_surcharge'] 	    	= array('Field', 'fuel_surcharge', 'fuel_surcharge', 'float');
		$PropMap['total_gst_delivery'] 	    	= array('Field', 'total_gst_delivery', 'total_gst_delivery', 'float');
		$PropMap['service_surcharge'] 	    = array('Field', 'service_surcharge', 'service_surcharge', 'float');
		$PropMap['total_delivery_fee'] 	    = array('Field', 'total_delivery_fee', 'total_delivery_fee', 'float');
		$PropMap['discount'] 	            = array('Field', 'discount', 'discount', 'float');
		$PropMap['total_dis_delivery_fee'] 	= array('Field', 'total_dis_delivery_fee', 'total_dis_delivery_fee', 'float');
		$PropMap['currency_codes'] 	    = array('Field', 'currency_codes', 'currency_codes', 'string');
    	$PropMap['values_of_goods'] 	    = array('Field', 'values_of_goods', 'values_of_goods', 'float');
		$PropMap['total_new_charge'] 	    = array('Field', 'total_new_charge', 'total_new_charge', 'float');
		$PropMap['gst_surcharge'] 	        = array('Field', 'gst_surcharge', 'gst_surcharge', 'float');
		$PropMap['rate'] 	    			= array('Field', 'rate', 'rate', 'float');
		$PropMap['description_of_goods'] 	= array('Field', 'description_of_goods', 'description_of_goods', 'string');
		$PropMap['dangerousgoods'] 	    = array('Field', 'dangerousgoods', 'dangerousgoods', 'tinyint');
		$PropMap['authority_to_leave'] 	    = array('Field', 'authority_to_leave', 'authority_to_leave', 'int');
		$PropMap['where_to_leave_shipment'] = array('Field', 'where_to_leave_shipment', 'where_to_leave_shipment', 'string');
		$PropMap['additional_cost']         = array('Field', 'additional_cost', 'additional_cost', 'float');
		$PropMap['service_name']            = array('Field', 'service_name', 'service_name', 'string');
		$PropMap['sender_first_name']            = array('Field', 'sender_first_name', 'sender_first_name', 'string');
		$PropMap['sender_surname']            = array('Field', 'sender_surname', 'sender_surname', 'string');
		$PropMap['sender_company_name']            = array('Field', 'sender_company_name', 'sender_company_name', 'string');
		$PropMap['sender_address_1']            = array('Field', 'sender_address_1', 'sender_address_1', 'string');
		$PropMap['sender_address_2']            = array('Field', 'sender_address_2', 'sender_address_2', 'string');
		$PropMap['sender_address_3']            = array('Field', 'sender_address_3', 'sender_address_3', 'string');
		$PropMap['sender_suburb']            = array('Field', 'sender_suburb', 'sender_suburb', 'string');
		$PropMap['sender_state']            = array('Field', 'sender_state', 'sender_state', 'string');
		$PropMap['sender_postcode']            = array('Field', 'sender_postcode', 'sender_postcode', 'string');
		$PropMap['sender_email']            = array('Field', 'sender_email', 'sender_email', 'string');
		$PropMap['sender_contact_no']            = array('Field', 'sender_contact_no', 'sender_contact_no', 'string');
		$PropMap['sender_mobile_no']            = array('Field', 'sender_mobile_no', 'sender_mobile_no', 'string');
		$PropMap['reciever_firstname']            = array('Field', 'reciever_firstname', 'reciever_firstname', 'string');
		$PropMap['reciever_surname']            = array('Field', 'reciever_surname', 'reciever_surname', 'string');
		$PropMap['reciever_company_name']            = array('Field', 'reciever_company_name', 'reciever_company_name', 'string');
		$PropMap['reciever_address_1']            = array('Field', 'reciever_address_1', 'reciever_address_1', 'string');
		$PropMap['reciever_address_2']            = array('Field', 'reciever_address_2', 'reciever_address_2', 'string');
		$PropMap['reciever_address_3']            = array('Field', 'reciever_address_3', 'reciever_address_3', 'string');
		$PropMap['reciever_suburb']            = array('Field', 'reciever_suburb', 'reciever_suburb', 'string');
		$PropMap['reciever_state']            = array('Field', 'reciever_state', 'reciever_state', 'string');
		$PropMap['reciever_state_code']            = array('Field', 'reciever_state_code', 'reciever_state_code', 'string');
		$PropMap['reciever_postcode']            = array('Field', 'reciever_postcode', 'reciever_postcode', 'string');
		$PropMap['reciever_email']            = array('Field', 'reciever_email', 'reciever_email', 'string');
		$PropMap['reciever_contact_no']            = array('Field', 'reciever_contact_no', 'reciever_contact_no', 'string');
		$PropMap['reciever_mobile_no']            = array('Field', 'reciever_mobile_no', 'reciever_mobile_no', 'string');
		$PropMap['date_ready']            = array('Field', 'date_ready', 'date_ready', 'string');
		$PropMap['time_ready']            = array('Field', 'time_ready', 'time_ready', 'string');
		$PropMap['close_time']            = array('Field', 'close_time', 'close_time', 'string');
		$PropMap['booking_date']            = array('Field', 'booking_date', 'booking_date', 'string');
		$PropMap['booking_time']            = array('Field', 'booking_time', 'booking_time', 'string');
		$PropMap['userid']     = array('Field', 'userid', 'userid', 'int');
		$PropMap['pickup_time_zone']            = array('Field', 'pickup_time_zone', 'pickup_time_zone', 'string');
		$PropMap['delivery_time_zone']     = array('Field', 'delivery_time_zone', 'delivery_time_zone', 'string');
		$PropMap['flag']     = array('Field', 'flag', 'flag', 'string');
		$PropMap['international_rate']     = array('Field', 'international_rate', 'international_rate', 'string');
		$PropMap['pageid']     = array('Field', 'pageid', 'pageid', 'int');
		$PropMap['pagename']     = array('Field', 'pagename', 'pagename', 'string');
		$PropMap['servicepagename']     = array('Field', 'servicepagename', 'servicepagename', 'string');
		$PropMap['CCConnote']     = array('Field', 'CCConnote', 'CCConnote', 'string');
		$PropMap['shipment_number']     = array('Field', 'shipment_number', 'shipment_number', 'string');
		$PropMap['BookingNumber']     = array('Field', 'BookingNumber', 'BookingNumber', 'string');
		$PropMap['p_id']     = array('Field', 'p_id', 'p_id', 'string');
		$PropMap['d_id']     = array('Field', 'd_id', 'd_id', 'string');
		$PropMap['commercial_invoice']     = array('Field', 'commercial_invoice', 'commercial_invoice', 'string');
    	$PropMap['export_reason']     = array('Field', 'export_reason', 'export_reason', 'tinyint');
    	$PropMap['country_origin']     = array('Field', 'country_origin', 'country_origin', 'tinyint');
    	$PropMap['commercial_invoice_provider']     = array('Field', 'commercial_invoice_provider', 'commercial_invoice_provider', 'tinyint');
		$PropMap['payment_email']     = array('Field', 'payment_email', 'payment_email', 'string');
		$PropMap['goods_nature']     = array('Field', 'goods_nature', 'goods_nature', 'string');
		$PropMap['sender_area_code']     = array('Field', 'sender_area_code', 'sender_area_code', 'string');
		$PropMap['reciever_area_code']     = array('Field', 'reciever_area_code', 'reciever_area_code', 'string');
		$PropMap['sender_mb_area_code']     = array('Field', 'sender_mb_area_code', 'sender_mb_area_code', 'string');
		$PropMap['reciever_mb_area_code']     = array('Field', 'reciever_mb_area_code', 'reciever_mb_area_code', 'string');
		$PropMap['delivery_fee_org']     = array('Field', 'delivery_fee_org', 'delivery_fee_org', 'float');
		$PropMap['fuel_surcharge_org']     = array('Field', 'fuel_surcharge_org', 'fuel_surcharge_org', 'float');
		$PropMap['total_gst_delivery_org']     = array('Field', 'total_gst_delivery_org', 'total_gst_delivery_org', 'float');
		$PropMap['total_delivery_fee_org']     = array('Field', 'total_delivery_fee_org', 'total_delivery_fee_org', 'string');
		$PropMap['pickup_location_type']     = array('Field', 'pickup_location_type', 'pickup_location_type', 'int');
		$PropMap['delivery_location_type']     = array('Field', 'delivery_location_type', 'delivery_location_type', 'int');

		return $PropMap;
	}
}
?>
