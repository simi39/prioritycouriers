<?php /**
 * This is FormsCalculatorData model file.
 * Create interaction between FormsCalculatorMaster (business logic) and forms_calculator table by mapping all fields.
 * PropertyMap method return array which has similar elements of forms_calculator table fields and used in controller file.
 * 
 * TABLE_NAME: forms_calculator 
 * LICENSE:    License Information (if any) ...
 * 
 * @uses Create interface between forms_calculator table and FormsCalculatorMaster (business logic) files.
 * 
 * @package    Forms And Calculator
 * @author     Radixweb
 * @copyright  Document Copyright information, e.g. Copyright (c) 2008, Radixweb
 * @license    Display a hyperlink to a URL for a license, e.g. http://opensource.org/licenses/gpl-license.php GNU Public License
 * @version    $Id: FormsCalculatorData.php,v 1.0
 * @link       Display a hyperlink to a URL in the documentation, e.g. http://radixweb.com
 * @since      Document when (at which version) an element was first added to a package e.g. Version 1.0 
 * 
 */

/**
 * @see RDataModel.php for extended RdataModel class
 */
require_once(DIR_LIB_CLASSES_MODELS."/RDataModel.php");

class FormsCalculatorData extends RDataModel
{		
   /**
    *  To define FormsCalculator data
    *
    * @return array array $PropMap : Each Element associate with table fields for to use as a property of FormsCalculatorMaster object
    */	
    protected function PropertyMap() 
    {
		
        //define array for mapping all table fields as a FormsCalculatorMaster object properties.
 		$PropMap = array();
		
		//assign all category table fields details like name, type and so on into array.
		$PropMap['frm_id'] 	 		= array('Field', 'frm_id', 'frm_id', 'int');
		$PropMap['title'] 		 	= array('Field', 'title', 'title', 'string');
		$PropMap['link_url'] 		 	= array('Field', 'link_url', 'link_url', 'string');
		$PropMap['link_type'] 		 	= array('Field', 'link_type', 'link_type', 'string');
		$PropMap['link_path'] 		 	= array('Field', 'link_path', 'link_path', 'string');	
		$PropMap['status'] 		 	= array('Field', 'status', 'status', 'int');	
		
		return $PropMap;
	}
}