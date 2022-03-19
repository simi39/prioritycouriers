<?php
/** 
 * This is NewsLetterData model file.  
 * Create interaction between NewsLetterMaster (business logic) and news table by mapping all fields. 
 * PropertyMap method return array which has similar elements of newsletter table fields and used in controller file. 
 *   
 * TABLE_NAME: newsletter   
 * LICENSE:    License Information (if any) ...  
 *   
 * @uses Create interface between newsletter table and NewsLetterMaster (business logic) files.  
 *   
 * @package    Specify package to group classes or functions and defines into  
 * @author     AUTHOR_NAME  * @copyright  Document Copyright information, e.g. Copyright (c) 2008, Radixweb  
 * @license    Display a hyperlink to a URL for a license, e.g. http://opensource.org/licenses/gpl-license.php GNU Public License  
 * @version    $Id: NewsData.php,v 1.0  
 * @link       Display a hyperlink to a URL in the documentation, e.g. http://radixweb.com  
 * @since      Document when (at which version) an element was first added to a package e.g. Version 1.0   
 *   
 */  
 /**  
 * @see RDataModel.php for extended RdataModel class  */ 
 
 require_once(DIR_LIB_CLASSES_MODELS."/RDataModel.php");  class NewsLetterData extends RDataModel
 {     
	/**     
	*  To define News data     
	*    
	* @return array array $PropMap : Each Element associate with table fields for to use as a property of NewsMaster object     
	*/     
	protected function PropertyMap()     
	{
		//define array for mapping all table fields as a NewsMaster object properties.   
        $PropMap = array();      
        //assign all category table fields details like name, type and so on into array.   
		$PropMap['id']     = array('Field', 'id', 'id', 'int'); 
		$PropMap['email_id']     = array('Field', 'email_id', 'email_id', 'int'); 
		$PropMap['status']     = array('Field', 'status', 'status', 'string'); 
		             
		return $PropMap;
	}
}
?>