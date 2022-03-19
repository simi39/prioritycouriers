<?php 
/** 
 * This is tracking_evantData model file.  
 * Create interaction between tracking_evantMaster (business logic) and tracking_evant table by mapping all fields. 
 * PropertyMap method return array which has similar elements of tracking_evant table fields and used in controller file. 
 *   
 * TABLE_NAME: tracking_evant   
 * LICENSE:    License Information (if any) ...  
 *   
 * @uses Create interface between tracking_evant table and tracking_evantMaster (business logic) files.  
 *   
 * @package    Specify package to group classes or functions and defines into  
 * @author     AUTHOR_NAME  * @copyright  Document Copyright information, e.g. Copyright (c) 2008, Radixweb  
 * @license    Display a hyperlink to a URL for a license, e.g. http://opensource.org/licenses/gpl-license.php GNU Public License  
 * @version    $Id: tracking_evantData.php,v 1.0  
 * @link       Display a hyperlink to a URL in the documentation, e.g. http://radixweb.com  
 * @since      Document when (at which version) an element was first added to a package e.g. Version 1.0   
 *   
 */  
 /**  
 * @see RDataModel.php for extended RdataModel class  */ 
 
 require_once(DIR_LIB_CLASSES_MODELS."/RDataModel.php"); 
  class tracking_evantData extends RDataModel
 {     
	/**     
	*  To define tracking_evant data     
	*    
	* @return array array $PropMap : Each Element associate with table fields for to use as a property of tracking_evantMaster object     
	*/     
	protected function PropertyMap()     
	{
		//define array for mapping all table fields as a tracking_evantMaster object properties.   
        $PropMap = array();      
        //assign all category table fields details like name, type and so on into array.   
		$PropMap['tracking_evant_id']     = array('Field', 'tracking_evant_id', 'tracking_evant_id', 'int`'); 
        $PropMap['eventid']     = array('Field', 'eventid', 'eventid', 'int`'); 
		$PropMap['description']     = array('Field', 'description', 'description', 'string'); 		               
		return $PropMap;
	}
}
?>