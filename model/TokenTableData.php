<?php
/**
 * This is TokenTableData model file.
 * Create interaction between TokenTableMaster (business logic) and token_table_name table by mapping all fields.
 * PropertyMap method return array which has similar elements of token_table_name table fields and used in controller file.
 * 
 * TABLE_NAME: token_table_name
 * LICENSE:    License Information (if any) ...
 * 
 * @uses Create interface between token_table_name table and TokenTableMaster (business logic) files.
 * 
 * @package    Token Table Management
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

class TokenTableData extends RDataModel
{
   /**
    *  To define TokenTable data
    *
    * @return array array $PropMap : Each Element associate with table fields for to use as a property of UserMaster object
    */
    protected function PropertyMap()
    {
        //define array for mapping all table fields as a TokenTableMaster object properties.
 		$PropMap = array();

		//assign all category table fields details like name, type and so on into array.
		$PropMap['id'] 		= array('Field', 'id', 'id', 'int');
		$PropMap['expiry_token_time'] 		= array('Field', 'expiry_token_time', 'expiry_token_time', 'int');
		$PropMap['sid']		= array('Field', 'sid', 'sid', 'string');
		$PropMap['mykey'] 	= array('Field', 'mykey', 'mykey', 'string');
		$PropMap['stamp'] 	= array('Field', 'stamp', 'stamp', 'string');
		$PropMap['ipaddress'] 	= array('Field', 'ipaddress', 'ipaddress', 'string');
		$PropMap['action'] 	= array('Field', 'action', 'action', 'string');
			
		return $PropMap;
	}
}