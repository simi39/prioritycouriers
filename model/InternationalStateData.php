<?php
/**
 * This is InternatioanlStateData model file.
 * Create interaction between InternatioanlStateMaster (business logic) and international_state table by mapping all fields.
 * PropertyMap method return array which has similar elements of international_state table fields and used in controller file.
 * 
 * TABLE_NAME: international_state 
 * LICENSE:    License Information (if any) ...
 * 
 * @uses Create interface between international_state table and InternationalItemTypeMaster (business logic) files.
 * 
 * @package    InternatioanlStateData
 * @author     Radixweb
 * @copyright  Document Copyright information, e.g. Copyright (c) 2008, Radixweb
 * @license    Display a hyperlink to a URL for a license, e.g. http://opensource.org/licenses/gpl-license.php GNU Public License
 * @version    $Id: InternatioanlItemTypeData.php,v 1.0
 * @link       Display a hyperlink to a URL in the documentation, e.g. http://radixweb.com
 * @since      Document when (at which version) an element was first added to a package e.g. Version 1.0 
 * 
 */

/**
 * @see RDataModel.php for extended RdataModel class
 */
require_once(DIR_LIB_CLASSES_MODELS."/RDataModel.php");

class InternationalStateData extends RDataModel
{		
   /**
    *  To define InternatioanlState data
    *
    * @return array array $PropMap : Each Element associate with table fields for to use as a property of InternationalStateMaster object
    */	
    protected function PropertyMap() 
    {
		
        //define array for mapping all table fields as a InternationalItemTypeMaster object properties.
 		$PropMap = array();
		
		//assign all category table fields details like name, type and so on into array.
		$PropMap['id'] 	 		= array('Field', 'id', 'id', 'int');
		$PropMap['state'] 	 		= array('Field', 'state', 'state', 'string');
		$PropMap['state_code'] 	 		= array('Field', 'state_code', 'state_code', 'string');
		
		
		return $PropMap;
	}
}

?>