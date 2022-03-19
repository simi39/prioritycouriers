<?php
/**
 * This is InternationalRatesData model file.
 * Create interaction between InternationalMaster (business logic) and international_rates table by mapping all fields.
 * PropertyMap method return array which has similar elements of international_rates table fields and used in controller file.
 * 
 * TABLE_NAME: international_rates 
 * LICENSE:    License Information (if any) ...
 * 
 * @uses Create interface between international_rates table and InternationalMaster (business logic) files.
 * 
 * @package    Specify package to group classes or functions and defines into
 * @author     Radixweb
 * @copyright  Document Copyright information, e.g. Copyright (c) 2008, Radixweb
 * @license    Display a hyperlink to a URL for a license, e.g. http://opensource.org/licenses/gpl-license.php GNU Public License
 * @version    $Id: InternationalRatesData.php,v 1.0
 * @link       Display a hyperlink to a URL in the documentation, e.g. http://radixweb.com
 * @since      Document when (at which version) an element was first added to a package e.g. Version 1.0 
 * 
 */

/**
 * @see RDataModel.php for extended RdataModel class
 */
require_once(DIR_LIB_CLASSES_MODELS."/RDataModel.php");

class InternationalRatesData extends RDataModel
{		
   /**
    *  To define InternationalRates data
    *
    * @return array array $PropMap : Each Element associate with table fields for to use as a property of InternationalMaster object
    */	
    protected function PropertyMap() 
    {
		
        //define array for mapping all table fields as a InternationalMaster object properties.
 		$PropMap = array();
		
		//assign all category table fields details like name, type and so on into array.
		$PropMap['id'] 	 		= array('Field', 'id', 'id', 'int');
		$PropMap['weight_to'] 	 		= array('Field', 'weight_to', 'weight_to', 'float');
		$PropMap['weight_from'] 	 		= array('Field', 'weight_from', 'weight_from', 'float');
		$PropMap['zone'] 	 		= array('Field', 'zone', 'zone', 'string');
		$PropMap['cost'] 	 		= array('Field', 'cost', 'cost', 'float');
		$PropMap['doc_type'] 	 		= array('Field', 'doc_type', 'doc_type', 'string');
		
		
		return $PropMap;
	}
}

?>