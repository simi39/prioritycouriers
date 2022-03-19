<?php
/**
 * This is BannerImageData model file.
 * Create interaction between BannerImageMaster (business logic) and banner_image table by mapping all fields.
 * PropertyMap method return array which has similar elements of banner_image table fields and used in controller file.
 * 
 * TABLE_NAME: banner_image
 * LICENSE:    License Information (if any) ...
 * 
 * @uses Create interface between banner_image table and BannerImageMaster (business logic) files.
 * 
 * @package    Banner Image Management
 * @author     Radixweb
 * @copyright  Document Copyright information, e.g. Copyright (c) 2008, Radixweb
 * @license    Display a hyperlink to a URL for a license, e.g. http://opensource.org/licenses/gpl-license.php GNU Public License
 * @version    $Id: BannerImageData.php,v 1.0
 * @link       Display a hyperlink to a URL in the documentation, e.g. http://radixweb.com
 * @since      Document when (at which version) an element was first added to a package e.g. Version 1.0
 * 
 */

/**
 * @see RDataModel.php for extended RdataModel class
 */
require_once(DIR_LIB_CLASSES_MODELS."/RDataModel.php");           // From class section

class BannerImageData extends RDataModel
{
   /**
    *  To define BannerImage data
    *
    * @return array array $PropMap : Each Element associate with table fields for to use as a property of BannerImageMaster object
    */
    protected function PropertyMap()
    {
        //define array for mapping all table fields as a BannerImageMaster object properties.
 		$PropMap = array();

		//assign all category table fields details like name, type and so on into array.
		$PropMap['banner_image_id'] 	= array('Field', 'banner_image_id', 'banner_image_id', 'int');
		$PropMap['banner_image_name'] 	= array('Field', 'banner_image_name', 'banner_image_name', 'string');
		$PropMap['banner_link'] 		= array('Field', 'banner_link', 'banner_link', 'string');
		$PropMap['open_target'] 		= array('Field', 'open_target', 'open_target', 'string');

		return $PropMap;
	}
}