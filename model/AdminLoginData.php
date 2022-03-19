<?php
/**
 * This is AdminLoginData model file.
 * Create interaction between AdminLoginMaster (business logic) and Admin table by mapping all fields.
 * PropertyMap method return array which has similar elements of Admin table fields and used in controller file.
 * 
 * TABLE_NAME: Admin 
 * LICENSE:    License Information (if any) ...
 * 
 * @uses Create interface between Admin table and AdminLoginMaster (business logic) files.
 * 
 * @package    Administrator Management
 * @author     Radixweb
 * @copyright  Document Copyright information, e.g. Copyright (c) 2008, Radixweb
 * @license    Display a hyperlink to a URL for a license, e.g. http://opensource.org/licenses/gpl-license.php GNU Public License
 * @version    $Id: AdminLoginData.php,v 1.0
 * @link       Display a hyperlink to a URL in the documentation, e.g. http://radixweb.com
 * @since      Document when (at which version) an element was first added to a package e.g. Version 1.0 
 * 
 */

/**
 * @see RDataModel.php for extended RdataModel class
 */
require_once(DIR_LIB_CLASSES_MODELS."/RDataModel.php");

class AdminLoginData extends RDataModel
{
   /**
    *  To define AdminLogin data
    * @return array array $PropMap : Each Element associate with table fields for to use as a property of AdminLoginMaster object
    */
    protected function PropertyMap()
    {
        //define array for mapping all table fields as a AdminLoginMaster object properties.
 		$PropMap = array();

		//assign all category table fields details like name, type and so on into array.
		$PropMap['admin_id'] 		= array('Field', 'admin_id', 'admin_id', 'int');
		$PropMap['username'] 	= array('Field', 'username', 'username', 'string');
		$PropMap['password'] 		= array('Field', 'password', 'password', 'string');
		$PropMap['mail_id'] 		= array('Field', 'mail_id', 'mail_id', 'string');
		$PropMap['superadmin'] 	= array('Field', 'superadmin', 'superadmin', 'int');
		$PropMap['master_password']	= array('Field', 'master_password', 'master_password', 'string');
		$PropMap['total'] 		= array('Field', 'total', 'total', 'int');

		return $PropMap;
	}
}