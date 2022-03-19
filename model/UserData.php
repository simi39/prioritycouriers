<?php
/**
 * This is UserData model file.
 * Create interaction between UserMaster (business logic) and user_master table by mapping all fields.
 * PropertyMap method return array which has similar elements of user_master table fields and used in controller file.
 * 
 * TABLE_NAME: user_master
 * LICENSE:    License Information (if any) ...
 * 
 * @uses Create interface between user_master table and UserMaster (business logic) files.
 * 
 * @package    User Management
 * @author     Radixweb
 * @copyright  Document Copyright information, e.g. Copyright (c) 2008, Radixweb
 * @license    Display a hyperlink to a URL for a license, e.g. http://opensource.org/licenses/gpl-license.php GNU Public License
 * @version    $Id: UserData.php,v 1.0
 * @link       Display a hyperlink to a URL in the documentation, e.g. http://radixweb.com
 * @since      Document when (at which version) an element was first added to a package e.g. Version 1.0
 * 
 */

/**
 * @see RDataModel.php for extended RdataModel class
 */
require_once(DIR_LIB_CLASSES_MODELS."/RDataModel.php");

class UserData extends RDataModel
{
   /**
    *  To define User data
    *
    * @return array array $PropMap : Each Element associate with table fields for to use as a property of UserMaster object
    */
    protected function PropertyMap()
    {
        //define array for mapping all table fields as a UserMaster object properties.
 		$PropMap = array();

		//assign all category table fields details like name, type and so on into array.
		$PropMap['userid'] 		= array('Field', 'userid', 'userid', 'int');
		$PropMap['firstname']		= array('Field', 'firstname', 'firstname', 'string');
		$PropMap['lastname'] 		= array('Field', 'lastname', 'lastname', 'string');
		$PropMap['company'] 		= array('Field', 'company', 'company', 'string');
		$PropMap['email'] 		= array('Field', 'email', 'email', 'string');
		$PropMap['password'] 		= array('Field', 'password', 'password', 'string');
		$PropMap['street_address'] 	= array('Field', 'street_address', 'street_address', 'string');
		$PropMap['suburb'] 		= array('Field', 'suburb', 'suburb', 'string');
		$PropMap['city'] 		= array('Field', 'city', 'city', 'string');
		$PropMap['postcode'] 		= array('Field', 'postcode', 'postcode', 'string');
		$PropMap['state'] 		= array('Field', 'state', 'state', 'string');
		$PropMap['state_code'] 		= array('Field', 'state_code', 'state_code', 'string');
		$PropMap['country'] 		= array('Field', 'country', 'country', 'string');
		$PropMap['deleted']		= array('Field', 'deleted', 'deleted', 'string');
		$PropMap['sender_area_code']		= array('Field', 'sender_area_code', 'sender_area_code', 'string');
		$PropMap['phone_number']    	= array('Field', 'phone_number', 'phone_number', 'string');
		$PropMap['sender_mb_area_code']		= array('Field', 'sender_mb_area_code', 'sender_mb_area_code', 'string');
		$PropMap['mobile_no']= array('Field', 'mobile_no', 'mobile_no', 'string');
		$PropMap['user_type_id']	= array('Field', 'user_type_id', 'user_type_id', 'int');
		$PropMap['corporate_id']    	= array('Field', 'corporate_id', 'corporate_id', 'int');
		$PropMap['site_language_id']	= array('Field', 'site_language_id', 'site_language_id', 'int');		
		$PropMap['last_login_date'] 	= array('Field', 'last_login_date', 'last_login_date', 'string');		
		$PropMap['total']    		= array('Field', 'total', 'total', 'int');
		$PropMap['address1'] 		 	= array('Field', 'address1', 'address1', 'string');
		$PropMap['address2'] 		 	= array('Field', 'address2', 'address2', 'string');
		$PropMap['address3'] 		 	= array('Field', 'address3', 'address3', 'string');
		$PropMap['area_code'] 		 	= array('Field', 'area_code', 'area_code', 'area_code');
		$PropMap['password_status'] 		 	= array('Field', 'password_status', 'password_status', 'password_status');
		$PropMap['security_ques_1'] 		 	= array('Field', 'security_ques_1', 'security_ques_1', 'security_ques_1');
		$PropMap['security_ans_1'] 		 	= array('Field', 'security_ans_1', 'security_ans_1', 'security_ans_1');
		$PropMap['security_ques_2'] 		 	= array('Field', 'security_ques_2', 'security_ques_2', 'security_ques_2');
		$PropMap['security_ans_2'] 		 	= array('Field', 'security_ans_2', 'security_ans_2', 'security_ans_2');
		$PropMap['login_attempt'] 		 	= array('Field', 'login_attempt', 'login_attempt', 'login_attempt');
		$PropMap['last_login_attempt_datetime'] 		 	= array('Field', 'last_login_attempt_datetime', 'last_login_attempt_datetime', 'last_login_attempt_datetime');
		$PropMap['ip_address'] 		 	= array('Field', 'ip_address', 'ip_address', 'ip_address');
		$PropMap['Denied'] 		 	= array('Field', 'Denied', 'Denied', 'Denied');
		
		return $PropMap;
	}
}