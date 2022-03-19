<?php
/**
 * This is CouponData model file.
 * Create interaction between CouponMaster (business logic) 
 * PropertyMap method return array which has similar elements of coupon table fields and used in controller file.
 * 
 * TABLE_NAME: coupon 
 * LICENSE:    License Information (if any) ...
 * 
 * @uses Create interface for coupon management files..
 * 
 * @package    Coupon Management
 * @author     Radixweb
 * @copyright  Document Copyright information, e.g. Copyright (c) 2008, Radixweb
 * @license    Display a hyperlink to a URL for a license, e.g. http://opensource.org/licenses/gpl-license.php GNU Public License
 * @version    $Id: CorporateData.php,v 1.0
 * @link       Display a hyperlink to a URL in the documentation, e.g. http://radixweb.com
 * @since      Document when (at which version) an element was first added to a package e.g. Version 1.0 
 * 
 */

/**
 * @see RDataModel.php for extended RdataModel class
 */
require_once(DIR_LIB_CLASSES_MODELS."/RDataModel.php");

class CouponData extends RDataModel
{
   /**
    *  To define Coupon data
    *
    * @return array array $PropMap : Each Element associate with table fields for to use as a property of CorporateMaster object
    */
    protected function PropertyMap() 
    {
        //define array for mapping all table fields as a CorporateMaster object properties.
 		$PropMap = array();

		//assign all category table fields details like name, type and so on into array.
		$PropMap['coupon_id'] 	 		= array('Field', 'coupon_id', 'coupon_id', 'int');
		$PropMap['coupon_name'] 		= array('Field', 'coupon_name', 'coupon_name', 'string');
		$PropMap['coupon_amount'] 		= array('Field', 'coupon_amount', 'coupon_amount', 'string');
		$PropMap['coupon_type'] 		= array('Field', 'coupon_type', 'coupon_type', 'int');
		$PropMap['coupon_code'] 		= array('Field', 'coupon_code', 'coupon_code', 'string');
		$PropMap['coupon_start_date']   = array('Field', 'coupon_start_date', 'coupon_start_date', 'date');
		$PropMap['coupon_end_date']    	= array('Field', 'coupon_end_date', 'coupon_end_date', 'date');
		$PropMap['coupon_status']    	= array('Field', 'coupon_status', 'coupon_status', 'string');
		$PropMap['coupon_usage']    	= array('Field', 'coupon_usage', 'coupon_usage', 'string');
		$PropMap['user_id']    			= array('Field', 'user_id', 'user_id', 'string');
		$PropMap['total']    			= array('Field', 'total', 'total', 'int');
		
		return $PropMap;
	}
}