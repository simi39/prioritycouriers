<?php
/**
 * This is ForgotPassEmailIdAddressData model file.
 * Create interaction between ForgotPassEmailIdAddressMaster (business logic) and forgotpass_ipaddress_attempts table by mapping all fields.
 * PropertyMap method return array which has similar elements of forgotpass_email_attempts table fields and used in controller file.
 * 
 * TABLE_NAME: forgotpass_email_attempts

 * LICENSE:    License Information (if any) ...
 * 
 * @uses Create interface between forgotpass_email_attempts table and ForgotPassIPAddressMaster (business logic) files.
 * 
 * @package    ForgotPassEmailIdAddress Management
  
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

class ForgotPassEmailIdAddressData extends RDataModel
{
   /**
    *  To define ForgotPassIPAddress data
    *
    * @return array array $PropMap : Each Element associate with table fields for to use as a property of UserMaster object
    */
    protected function PropertyMap()
    {
        //define array for mapping all table fields as a UserMaster object properties.
 		$PropMap = array();

		//assign all category table fields details like name, type and so on into array.
		$PropMap['emailid'] 		= array('Field', 'emailid', 'emailid', 'string');
		$PropMap['attempts']		= array('Field', 'attempts', 'attempts', 'string');
		$PropMap['lastlogin'] 		= array('Field', 'lastlogin', 'lastlogin', 'string');
		$PropMap['Denied'] 		= array('Field', 'Denied', 'Denied', 'string');
			
		return $PropMap;
	}
}