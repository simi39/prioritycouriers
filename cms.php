<?php
/**
	 * This is index file
	 *
	 *
	 * @author     Radixweb <team.radixweb@gmail.com>
	 * @copyright  Copyright (c) 2008, Radixweb
	 * @version    1.0
	 * @since      1.0
	 */
	/**
	 * include common
	 */
	require_once("lib/common.php");
	require_once(DIR_WS_MODEL."CmsPagesMaster.php");
	require_once(DIR_WS_CURRENT_LANGUAGE . "cms.php");
	require_once(DIR_WS_CURRENT_LANGUAGE . "user.php");
//	require_once(DIR_WS_CURRENT_LANGUAGE . "sameday_rates.php");
	
	$arr_css_plugin_include[] = 'glyphicons/css/glyphicons.css';
	$arr_javascript_plugin_below_include[] = 'gmap/gmaps.js';
	$arr_javascript_below_include[] = 'internal/tracking.php';
	/**
	 * making object
	 */
	
	// print_R($_GET);
	// exit();
	$ObjCmsPagesMaster	= CmsPagesMaster::Create();
	if(empty($CmsPageName)) {
		$CmsPageName = trim($_GET['page']);
		$file = str_replace('../', '', $CmsPageName);/*if some page path is included validation for that is applied*/
		
		if(!isset($file))
		{
			$error =true;
		}
		$error = chkPages($CmsPageName);/*only small,capital and underscore is applied */
		
		if(isset($error))
		{
			//show_page_header(FILE_INDEX, false);
			header("Location:".SITE_INDEX);
			exit();	
			
		}
	}
	/*
	$csrf = new csrf();
	if(!isset($_POST['btnlogin']))
	{
		$csrf->action = "cms";
		/*csrf validation*/
		//$ptoken = $csrf->csrfkey();
		/*csrf validation*/	
	//} 

	
	if(isset($_POST['btnlogin'])) {
		/*
		if(isEmpty(valid_input($_POST['ptoken']), true))
		{	
			logOut();
		}
		else
		{
			$csrf->checkcsrf($_POST['ptoken']);
		}
		*/
		$auth_result = user_athuentication($_POST['email_signup'], $_POST['password_signup']);
		UnsetSession();
		if(empty($auth_result['error_email']) && empty($auth_result['error_password'])){
			show_page_header(FILE_GET_QUOTE, false);
			exit();
		}
	}
	
	
	
	if(empty($CmsPageName)) {
		//show_page_header(FILE_INDEX);
		header("Location:".SITE_INDEX);
		exit();	
		
	}
	/*
	if(file_exists(SITE_DOCUMENT_ROOT.$CmsPageName.".php")) {
		require_once(SITE_DOCUMENT_ROOT.$CmsPageName.".php");
	} 
	*/
	/**
	 * featching data from table  decode_str()
	 */
	$fieldArr = array("cms_pages.*, cms_pages_description.page_heading , cms_pages_description.page_content");
	$searchArr = array();
	$searchArr[] = " AND cms_pages_description.site_language_id = '".SITE_LANGUAGE_ID."'";
	$searchArr[] = " AND cms_pages.page_name = '".$CmsPageName ."'";
	$searchArr[] = " OR cms_pages.page_name = '".$CmsPageName ."'";
	$searchArr[] = " AND cms_pages.status='1'";
	$DataCmsMaster = $ObjCmsPagesMaster->getCmsPagesDetails($searchArr, $fieldArr);
	//This condition added by shailesh jamanapara on date Sat Jun 08 11:59:26 IST 2013
	if($CmsPageName == "services"){
		require_once(DIR_WS_MODEL . "ServiceMaster.php");
		require_once(DIR_WS_ADMIN_LANGUAGES . DIR_CURRENT_LANGUAGE. '/service.php');
		require_once(DIR_WS_MODEL . "SupplierMaster.php");
		//require_once( DIR_WS_SITE_CURRENT_TEMPLATE . "css/services.php");
		$ObjServiceMaster	= ServiceMaster::Create();
		$ServiceData		= new ServiceData();
		$fieldArr=array("*");
		$seaByArr=array();
		$seaByArr[]=array('Search_On'=>'status', 'Search_Value'=>'1', 'Type'=>'string', 'Equation'=>'=', 'CondType'=>'', 'Prefix'=>'and', 'Postfix'=>'');
		$servicesData = $ObjServiceMaster->getService($fieldArr,$seaByArr);
	}
	
	
	if(!empty($DataCmsMaster)) {
		$cmsData = $DataCmsMaster[0];
	} else {
		//show_page_header(FILE_INDEX);
		header("Location:".SITE_INDEX);
		exit();	
		
	}
	
	define("TITLE",$cmsData['page_heading']);
	
	require_once( DIR_WS_SITE_CURRENT_TEMPLATE . FILE_MAIN_INTERFACE);
?>
