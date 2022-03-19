<?php
	require_once(DIR_WS_MODEL . "seoPageMaster.php");
	require_once(DIR_WS_MODEL . "CmsPagesMaster.php");

/**
 * Object Defining
 */
	$objSeoPageMaster = new seoPageMaster();
	$objSeoPageMaster	= $objSeoPageMaster->Create();
	$objCmsPagesMaster = new CmsPagesMaster();
	$objCmsPagesMaster	= $objCmsPagesMaster->Create();
	
	
	$fieldArr = array();
	$sortArr=array();
	$searchArr = array();
	$fieldArr = array("site_seo_description.seo_page_title, site_seo_description.seo_page_keywords,site_seo_description.seo_page_description");
	$sortArr  = array("site_seo.page_id desc");	
	$searchArr[] = " AND site_seo_description.site_language_id = '".SITE_LANGUAGE_ID."'";
	
	if(SEO_ENABLE == true) {
		$searchArr[] = " AND (site_seo.page_name='" . FILE_FILENAME_WITH_EXT . "' OR site_seo.page_name='Standard') ";
	} else {
		$searchArr[] = " AND (site_seo.page_name='Standard') ";
	}

	$metadata = $objSeoPageMaster->getSeoPageDetails($searchArr,$fieldArr,$sortArr);
	
	/*echo "<pre>";
	print_r($metadata);
	echo "</pre>";*/
	//if(count($metadata) > 1) {
	if(is_countable($metadata)) {
		$page_metadata = $metadata[0];
		$standard_metatags = $metadata[1];
	} else {
		$standard_metatags = $metadata[0];
	}
	$title="";
 	$keywords="";
 	$description="";
 
 	if(SEO_ENABLE == true) {
		// Metatags details for CMS Pages
		 	if(isset($_GET['page']) && $_GET['page'] != ""){
				$fieldArrcms = array();$searchArrcms = array();
			 	$fieldArrcms = array("cms_pages_description.seo_page_title, cms_pages_description.seo_page_keywords,cms_pages_description.seo_page_description");
				$searchArrcms[] = " AND cms_pages_description.site_language_id = '".SITE_LANGUAGE_ID."'";
				$searchArrcms[] = " AND cms_pages.page_name = '".$_GET['page']."'";
				$searchArrcms[] = " AND cms_pages.status='1'";
				$metadata = $objCmsPagesMaster->getCmsPagesDetails($searchArrcms,$fieldArrcms);
				$page_metadata = $metadata[0];
		 	}
		 	
		 /**
		  * Checks for the condition and assign values for the title , keywords ,description
		  */
			 if(isset($_GET['pid']) && $_GET['pid'] != "" && $_GET['tempid'] != ""){
			 	
				$fieldArrtemplates = array(); $searchArrtemplates = array();
				$fieldArrtemplates = array("site_master_template_description.keywords");
				$searchArrtemplates[] = " AND site_master_template.template_id = ".$_GET['tempid'];
				$searchArrtemplates[] = " AND site_master_template.products_id = ".$_GET['pid'];
				$searchArrtemplates[] = " AND site_master_template_description.site_language_id = '".SITE_LANGUAGE_ID."'";
			 	$Templatekeywords      = $objTemplateMaster->getSiteTemplateDescriptions($searchArrtemplates,$fieldArrtemplates);
			 	$Template_metadata 	   = $Templatekeywords[0]; 
			 }
		 	
		 /**
		  * Checks for the condition and assign values for the title , keywords ,description
		  */
			 if(isset($_GET['pid']) && $_GET['pid'] != ""){
			 	
				$fieldArrproducts = array(); $searchArrproducts = array();
				$fieldArrproducts = array("products_description.seo_page_title, products_description.seo_page_keywords,products_description.seo_page_description");
				$searchArrproducts[] = " AND products_description.site_language_id = '".SITE_LANGUAGE_ID."'";
				$searchArrproducts[] = " AND products.products_id = ".$_GET['pid'];
			 	$product      = $objProductsMaster->get_product_details(null,null,$fieldArrproducts,null,null,null,null,$searchArrproducts);
			 	$page_metadata 	  = $product[0]; 
			 }
 	}
// Set Page Title
	$title = $page_metadata['seo_page_title'];
	if(empty($title)) {
		$title = $standard_metatags['seo_page_title'];
	}
	
// Set Page Keywords
	//$keywords = $page_metadata['seo_page_keywords'].' '.$Template_metadata['keywords'];
	
	if($_GET['tempid'] != ""){
		$keywords = $page_metadata['seo_page_keywords'].' '.$Template_metadata['keywords'];	
	}else {
		$keywords = $page_metadata['seo_page_keywords'];
	}
	if(empty($keywords)) {
		$keywords = $standard_metatags['seo_page_keywords'];
	}
	
// Set Page Description
	$description = $page_metadata['seo_page_description'];
	if(empty($description)) {
		$description = $standard_metatags['seo_page_description'];
	}
    
	
	$titletag="<title>".strip_tags($title)."</title>\n";
	$titletag.="<meta name=\"Keywords\" content=\"".strip_tags($keywords)."\" >\n";
	$titletag.="<meta name=\"description\" content=\"".strip_tags($description)."\" >\n";
	
	//	$titletag.="<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />\n";
	//	$titletag.="<meta name='resource-type' content='document'>\n";
	//	$titletag.="<meta http-equiv='pragma' content='no-cache'>\n";
		$titletag.="<meta name='revisit-after' content='1 days'>\n";
	//	$titletag.="<meta name='classification' content='Online Design'>\n";
	//	$titletag.="<meta name='MSSmartTagsPreventParsing' content='TRUE'>\n";
		$titletag.="<meta name='robots' content='ALL'>\n";
	//	$titletag.="<meta name='distribution' content='Global'>\n";
		$titletag.="<meta name='dcterms.rightsHolder' content='Copyright © ".SITE_NAME."'>\n"; 
		$titletag.="<meta name='dcterms.dateCopyrighted' content='2010-2022'>\n";
		$titletag.="<meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=no'>\n";
	//	$titletag.="<meta name='author' content='".SITE_URL_WITHOUT_PROTOCOL."'>\n";
	//	$titletag.="<meta name='language' content='en'>\n";
	//	$titletag.="<meta name='doc-type' content='Web Page'>\n";
	//	$titletag.="<meta name='doc-class' content='Completed'>\n";
	
?>