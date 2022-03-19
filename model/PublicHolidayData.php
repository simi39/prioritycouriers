<?php
/** 
 * This is PublicHolidayData model file.  
 * Create interaction between PublicHolidayMaster (business logic) and public_holiday table by mapping all fields. 
 * PropertyMap method return array which has similar elements of public_holiday table fields and used in controller file. 
 *   
 * TABLE_NAME: public_holiday   
 * LICENSE:    License Information (if any) ...  
 *   
 * @uses Create interface between public_holiday table and PublicHolidayMaster (business logic) files.  
 *   
 * @package    Specify package to group classes or functions and defines into  
 * @author     AUTHOR_NAME  * @copyright  Document Copyright information, e.g. Copyright (c) 2008, Radixweb  
 * @license    Display a hyperlink to a URL for a license, e.g. http://opensource.org/licenses/gpl-license.php GNU Public License  
 * @version    $Id: PublicHolidayData.php,v 1.0  
 * @link       Display a hyperlink to a URL in the documentation, e.g. http://radixweb.com  
 * @since      Document when (at which version) an element was first added to a package e.g. Version 1.0   
 *   
 */  
 /**  
 * @see RDataModel.php for extended RdataModel class  */ 
 
 require_once(DIR_LIB_CLASSES_MODELS."/RDataModel.php");
   class PublicHolidayData extends RDataModel
 {     
	/**     
	*  To define PublicHoliday data     
	*    
	* @return array array $PropMap : Each Element associate with table fields for to use as a property of PublicHolidayMaster object     
	*/     
	protected function PropertyMap()     
	{
		//define array for mapping all table fields as a PublicHolidayMaster object properties.   
        $PropMap = array();      
        //assign all category table fields details like name, type and so on into array.   
		$PropMap['sdate']     = array('Field', 'sdate', 'sdate', 'string'); 
		$PropMap['state']     = array('Field', 'state', 'state', 'string'); 
		$PropMap['name']     = array('Field', 'name', 'name', 'string');      
		$PropMap['dateid']     = array('Field', 'dateid', 'dateid', 'int');           
		return $PropMap;
	}
}
?>