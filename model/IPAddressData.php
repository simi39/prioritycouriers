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

class IPAddressData extends RDataModel
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
		$PropMap['ip'] 		= array('Field', 'ip', 'ip', 'string');
		$PropMap['attempts']		= array('Field', 'attempts', 'attempts', 'string');
		$PropMap['lastlogin'] 		= array('Field', 'lastlogin', 'lastlogin', 'string');
		$PropMap['Denied'] 		= array('Field', 'Denied', 'Denied', 'string');
			
		return $PropMap;
	}
}