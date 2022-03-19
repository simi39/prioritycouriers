<?php
	/**
	 * This is EmailTemplateManagerData model file.
	 * Create interaction between EmailTemplateManagerMaster (business logic) and email_template_manager table by mapping all fields.
	 * PropertyMap method return array which has similar elements of email_template_manager table fields and used in controller file.
	 * 
	 * TABLE_NAME: email_template_manager 
	 * 
	 * @uses Create interface between email_template_manager table and EmailTemplateManagerMaster (business logic) files.
	 * 
	 * @package    EmailManager
	 * @author     Kruti<kruti@radixweb.com>
	 * @version    $Id: EmailTemplateManagerData.php,v 1.0
	 * 
	 */
	
	/**
	 * @see RDataModel.php for extended RdataModel class
	 */
	require_once(DIR_LIB_CLASSES_MODELS."/RDataModel.php");
	
	class EmailTemplateManagerData extends RDataModel
	{		
	   /**
	    *  To define EmailTemplateManager data
	    *
	    * @return array array $PropMap : Each Element associate with table fields for to use as a property of EmailTemplateManagerMaster object
	    */	
	    protected function PropertyMap() 
	    {
			
	        //define array for mapping all table fields as a EmailTemplateManagerMaster object properties.
	 		$PropMap = array();
			
			//assign all category table fields details like name, type and so on into array.
			$PropMap['template_id'] 				 = array('Field', 'template_id', 'template_id', 'int');
			$PropMap['template_title'] 				 = array('Field', 'template_title', 'template_title', 'text');
			$PropMap['template_group'] 	             = array('Field', 'template_group', 'template_group', 'text');
			$PropMap['isactive'] 		             = array('Field', 'isactive', 'isactive', 'boolean');						
			$PropMap['template_from_address'] 	 	 = array('Field', 'template_from_address', 'template_from_address', 'string');			
			$PropMap['template_cc_address'] 	 	 = array('Field', 'template_cc_address', 'template_cc_address', 'string');			
			$PropMap['template_subject']             = array('Field', 'template_subject', 'template_subject', 'text');
			$PropMap['template_content']             = array('Field', 'template_content', 'template_content', 'text');
			$PropMap['site_language_id']             = array('Field', 'site_language_id', 'site_language_id', 'int');
			$PropMap['help_content'] 	             = array('Field', 'help_content', 'help_content', 'text');
			$PropMap['total']			 = array('Field', 'total', 'total', 'int');
			$PropMap['template_to_address'] 	 	 = array('Field', 'template_to_address', 'template_to_address', 'string');			
			return $PropMap;
		}
	}
?>