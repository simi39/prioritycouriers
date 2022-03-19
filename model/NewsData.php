<?php
/** 
 * This is NewsData model file.  
 * Create interaction between NewsMaster (business logic) and news table by mapping all fields. 
 * PropertyMap method return array which has similar elements of news table fields and used in controller file. 
 *   
 * TABLE_NAME: news   
 * LICENSE:    License Information (if any) ...  
 *   
 * @uses Create interface between news table and NewsMaster (business logic) files.  
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
 
 require_once(DIR_LIB_CLASSES_MODELS."/RDataModel.php");  class NewsData extends RDataModel
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
		$PropMap['news_id']     = array('Field', 'news_id', 'news_id', 'int'); 
		$PropMap['newscat_id']     = array('Field', 'newscat_id', 'newscat_id', 'int'); 
		$PropMap['status']     = array('Field', 'status', 'status', 'string'); 
		$PropMap['sort_order']     = array('Field', 'sort_order', 'sort_order', 'int'); 
		$PropMap['news_question']     = array('Field', 'news_question', 'news_question', 'string'); 
		$PropMap['news_answer']     = array('Field', 'news_answer', 'news_answer', 'string'); 
		$PropMap['site_language_id']     = array('Field', 'site_language_id', 'site_language_id', 'int'); 
		$PropMap['total']     = array('Field', 'total', 'total', 'int'); 
		               
		return $PropMap;
	}
}
?>