<?php
/**
 * This is CcDetailsData model file.
 * Create interaction between CcdetailsMaster (business logic) and ccdetails table by mapping all fields.
 * PropertyMap method return array which has similar elements of ccdetails table fields and used in controller file.
 * 
 * TABLE_NAME: ccdetails 
 * LICENSE:    License Information (if any) ...
 * 
 * @uses Create interface between ccdetails table and CcdetailsMaster (business logic) files.
 * 
 * @package    credit card number
 * @author     Radixweb
 * @copyright  Document Copyright information, e.g. Copyright (c) 2008, Radixweb
 * @license    Display a hyperlink to a URL for a license, e.g. http://opensource.org/licenses/gpl-license.php GNU Public License
 * @version    $Id: CcDetailsData.php,v 1.0
 * @link       Display a hyperlink to a URL in the documentation, e.g. http://radixweb.com
 * @since      Document when (at which version) an element was first added to a package e.g. Version 1.0 
 * 
 */

/**
 * @see RDataModel.php for extended RdataModel class
 */
require_once(DIR_LIB_CLASSES_MODELS."/RDataModel.php");

class CcDetailsData extends RDataModel
{		
   /**
    *  To define Ccdetails data
    *
    * @return array array $PropMap : Each Element associate with table fields for to use as a property of CcdetailsMaster object
    */	
    protected function PropertyMap() 
    {
		
        //define array for mapping all table fields as a CcdetailsMaster object properties.
 		$PropMap = array();
		
		//assign all category table fields details like name, type and so on into array.
		$PropMap['cc_id'] 	 		= array('Field', 'cc_id', 'cc_id', 'int');
		$PropMap['userid'] 		 	= array('Field', 'userid', 'userid', 'int');
		$PropMap['hname'] 		 	= array('Field', 'hname', 'hname', 'string');
		$PropMap['ccnumber'] 		 	= array('Field', 'ccnumber', 'ccnumber', 'int');
		$PropMap['expdate'] 		 	= array('Field', 'expdate', 'expdate', 'string');
		$PropMap['cardtype'] 		 	= array('Field', 'cardtype', 'cardtype', 'string');
		
		
		return $PropMap;
	}
}