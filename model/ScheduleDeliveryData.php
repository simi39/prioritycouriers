<?php
/**
 * This is ScheduledDeliveryData model file.
 * Create interaction between ScheduleDeliveryMaster (business logic) and scheduled_delivery_australia table by mapping all fields.
 * PropertyMap method return array which has similar elements of scheduled_delivery_australia table fields and used in controller file.
 * 
 * TABLE_NAME: scheduled_delivery_australia 
 * LICENSE:    License Information (if any) ...
 * 
 * @uses Create interface between scheduled_delivery_australia table and ScheduleDeliveryMaster (business logic) files.
 * 
 * @package    Specify package to group classes or functions and defines into
 * @author     Radixweb
 * @copyright  Document Copyright information, e.g. Copyright (c) 2008, Radixweb
 * @license    Display a hyperlink to a URL for a license, e.g. http://opensource.org/licenses/gpl-license.php GNU Public License
 * @version    $Id: ScheduledDeliveryData.php,v 1.0
 * @link       Display a hyperlink to a URL in the documentation, e.g. http://radixweb.com
 * @since      Document when (at which version) an element was first added to a package e.g. Version 1.0 
 * 
 */

/**
 * @see RDataModel.php for extended RdataModel class
 */
require_once(DIR_LIB_CLASSES_MODELS."/RDataModel.php");

class ScheduledDeliveryData extends RDataModel
{		
   /**
    *  To define ScheduledDelivery data
    *
    * @return array array $PropMap : Each Element associate with table fields for to use as a property of ScheduleDeliveryMaster object
    */	
    protected function PropertyMap() 
    {
		
        //define array for mapping all table fields as a ScheduleDeliveryMaster object properties.
 		$PropMap = array();
		
		//assign all category table fields details like name, type and so on into array.
		$PropMap['id'] 	 		= array('Field', 'id', 'id', 'int');
		$PropMap['ready_by'] 	 		= array('Field', 'ready_by', 'ready_by', 'time');
		$PropMap['day'] 	 		= array('Field', 'day', 'day', 'string');
		$PropMap['delivery_by'] 	 		= array('Field', 'delivery_by', 'delivery_by', 'time');
		$PropMap['service_name'] 	 		= array('Field', 'service_name', 'service_name', 'string');
		
		
		return $PropMap;
	}
}

?>