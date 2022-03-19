<?php
/**
 * This is NonceData model file.
 * Create interaction between NonceMaster (business logic) and nonce table by mapping all fields.
 * PropertyMap method return array which has similar elements of nonce table fields and used in controller file.
 * 
 * TABLE_NAME: nonce
 * LICENSE:    License Information (if any) ...
 * 
 * @uses Create interface between nonce_name table and NonceMaster (business logic) files.
 * 
 * @package    Nonce Table Management
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

class NonceData extends RDataModel
{
   /**
    *  To define NonceData data
    *
    * @return array array $PropMap : Each Element associate with table fields for to use as a property of UserMaster object
    */
    protected function PropertyMap()
    {
        //define array for mapping all table fields as a TokenTableMaster object properties.
 		$PropMap = array();

		//assign all category table fields details like name, type and so on into array.
		$PropMap['id'] 		= array('Field', 'id', 'id', 'int');
		$PropMap['nonce']	= array('Field', 'nonce', 'nonce', 'string');
		$PropMap['stamp'] 	= array('Field', 'stamp', 'stamp', 'string');
		$PropMap['action'] 	= array('Field', 'action', 'action', 'string');
		$PropMap['used'] 	= array('Field', 'used', 'used', 'string');
		$PropMap['user_id'] 	= array('Field', 'user_id', 'user_id', 'string');
		$PropMap['url'] 	= array('Field', 'url', 'url', 'string');
			
		return $PropMap;
	}
}