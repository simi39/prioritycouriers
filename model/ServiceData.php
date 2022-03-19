<?php
/**
 * This is ServiceData model file.
 * Create interaction between ServiceMaster (business logic) and service table by mapping all fields.
 * PropertyMap method return array which has similar elements of admin_pages table fields and used in controller file.
 *
 * TABLE_NAME: service
 * LICENSE:    License Information (if any) ...
 *
 * @uses Create interface between cms_pages table and ServiceMaster (business logic) files.
 *
 * @package    Service Managment
 * @author     Radixweb
 * @copyright  Document Copyright information, e.g. Copyright (c) 2008, Radixweb
 * @license    Display a hyperlink to a URL for a license, e.g. http://opensource.org/licenses/gpl-license.php GNU Public License
 * @version    $Id: CmsData.php,v 1.0
 * @link       Display a hyperlink to a URL in the documentation, e.g. http://radixweb.com
 * @since      Document when (at which version) an element was first added to a package e.g. Version 1.0
 *
 */

/**
 * @see RDataModel.php for extended RdataModel class
 */
require_once(DIR_LIB_CLASSES_MODELS."/RDataModel.php");

class ServiceData extends RDataModel
{
   /**
    *  To define ServicePages data
    *
    * @return array array $PropMap : Each Element associate with table fields for to use as a property of ServiceMaster object
    */
    protected function PropertyMap()
    {
        //define array for mapping all table fields as a CmsMaster object properties.
 		$PropMap = array();

		//assign all category table fields details like name, type and so on into array.

		/* Master Table Field */
		$PropMap['auto_id'] 	 = array('Field', 'auto_id', 'auto_id', 'int');
		$PropMap['service_name'] 	 = array('Field', 'service_name', 'service_name', 'string');
    $PropMap['sorting'] 	 = array('Field', 'sorting', 'sorting', 'int');
		$PropMap['service_code'] 	     = array('Field', 'service_code', 'service_code', 'string');
		$PropMap['service_description'] 	 	 = array('Field', 'service_description', 'service_description', 'string');
		$PropMap['type'] 	 = array('Field', 'type', 'type', 'int');
		$PropMap['hours'] 	 = array('Field', 'hours', 'hours', 'string');
		$PropMap['minites'] 	 = array('Field', 'minites', 'minites', 'string');
		$PropMap['hr_formate'] 	 = array('Field', 'hr_formate', 'hr_formate', 'string');
		$PropMap['box_color'] 	 = array('Field', 'box_color', 'box_color', 'string');
		$PropMap['shadow_color'] 	 = array('Field', 'shadow_color', 'shadow_color', 'string');
		$PropMap['surcharge'] = array('Field', 'surcharge', 'surcharge', 'float');
		$PropMap['security_surcharge'] = array('Field', 'security_surcharge', 'security_surcharge', 'float');
		$PropMap['supplier_id'] 	 = array('Field', 'supplier_id', 'supplier_id', 'int');
		$PropMap['deleted'] 	 = array('Field', 'deleted', 'deleted', 'int');
		$PropMap['status'] 	 = array('Field', 'status', 'status', 'int');
		$PropMap['product_code_id'] 	 = array('Field', 'product_code_id', 'product_code_id', 'int');
		$PropMap['service_info'] 		 	= array('Field', 'service_info', 'service_info', 'string');
		$PropMap['supplier_name'] 		 	= array('Field', 'supplier_name', 'supplier_name', 'string');
		$PropMap['service_status_info'] 		 	= array('Field', 'service_status_info', 'service_status_info', 'string');
		$PropMap['qty_min'] = array('Field', 'qty_min', 'qty_min', 'int');
		$PropMap['qty_max'] = array('Field', 'qty_max', 'qty_max', 'int');						
		$PropMap['qty_status'] = array('Field', 'qty_status', 'qty_status', 'int');
		$PropMap['weight_min'] = array('Field', 'weight_min', 'weight_min', 'int');
		$PropMap['weight_max'] = array('Field', 'weight_max', 'weight_max', 'int');
		$PropMap['weight_status'] = array('Field', 'weight_status', 'weight_status', 'int');
		$PropMap['len_min'] = array('Field', 'len_min', 'len_min', 'int');
		$PropMap['len_max'] = array('Field', 'len_max', 'len_max', 'int');
		$PropMap['width_min'] = array('Field', 'width_min', 'width_min', 'int');
		$PropMap['width_max'] = array('Field', 'width_max', 'width_max', 'int');
		$PropMap['height_min'] = array('Field', 'height_min', 'height_min', 'int');
		$PropMap['height_max'] = array('Field', 'height_max', 'height_max', 'int');
		$PropMap['dim_status'] = array('Field', 'dim_status', 'dim_status', 'int');
		return $PropMap;
	}
}
