<?php
/**
 * =====================================================
 * 				Start :: Language Configuration			
 * =====================================================
 */

/* -------  Inclusion of Language Master files  ------- */

	require_once(DIR_WS_MODEL."SiteLanguageMaster.php");
	
	
	
/* -------  Language Master files Object Declaration  ------- */
	$ObjSiteLanguageMaster = new SiteLanguageMaster();
	$ObjSiteLanguageMaster = $ObjSiteLanguageMaster->create();
	
	
	$arr_lang_cur = array();
	
	if(isset($__Session))
	{
		if(IS_ADMIN ==false){ 		// Get the Session of frontend side
			$arr_lang_cur = $__Session->GetValue("_Sess_Front_Site_Language");
		} else {		// Get the Session of admin side
			$arr_lang_cur = $__Session->GetValue("_Sess_Admin_Site_Language");
		}
	}
	
	$siteLanguageId = $arr_lang_cur['language_id'];
	
	/* -------  When Language is changed  ------- */
	if((isset($_POST['supporttype']) && !empty($_POST['supporttype'])) || empty($siteLanguageId)) {
		
		$siteLanguageId = $_POST['supporttype'];
		if(IS_ADMIN == true) {
			$siteLanguageId  = 1;	
		}
		$siteLanguageArr = array();
		
		if( empty($siteLanguageId) ) { 	// When Language is not defined
			$siteLanguageArr[]     =	array('Search_On'=>'default_language', 'Search_Value'=>1, 'Type'=>'string', 'Equation'=>'=', 'CondType'=>'AND', 'Prefix'=>'', 'Postfix'=>'');
		} else {
			$siteLanguageArr[]     =	array('Search_On'=>'site_language_id', 'Search_Value'=>$siteLanguageId, 'Type'=>'string', 'Equation'=>'=', 'CondType'=>'AND', 'Prefix'=>'', 'Postfix'=>'');
		}
		$DataSiteLanguage = $ObjSiteLanguageMaster->getSiteLanguage(null, $siteLanguageArr);
		$DataSiteLanguage = $DataSiteLanguage[0];
		
		$siteLanguageId = $DataSiteLanguage['site_language_id'];
		
		$arr_lang_cur = array();
		$arr_lang_cur['language_id'] = $DataSiteLanguage['site_language_id'];
		$arr_lang_cur['language_name'] = $DataSiteLanguage['site_language_name'];
		$arr_lang_cur['language_dir'] = $DataSiteLanguage['folder_name'];
		$arr_lang_cur['language_shortname'] = $DataSiteLanguage['shortname'];
		
		
		if(isset($__Session))
		{
			if(IS_ADMIN == false){  // Setting Front End Session Language
				$__Session->SetValue("_Sess_Front_Site_Language", $arr_lang_cur);
			} else {		// Get the Session of admin side
				$__Session->SetValue("_Sess_Admin_Site_Language", $arr_lang_cur);
			}
			$__Session->Store();
		}
	}
	
/* -------  Get Languages and Currency Configuration of Domain  ------- */
	if(IS_ADMIN == true) {
		$siteLanguageArr = array();
		$siteLanguageArr[]     =	array('Search_On'=>'status', 'Search_Value'=>'1', 'Type'=>'string', 'Equation'=>'=', 'CondType'=>'AND', 'Prefix'=>'', 'Postfix'=>'');

		$DataSiteDomainLanguage = $ObjSiteLanguageMaster->getSiteLanguage(null, $siteLanguageArr);
		$siteLanguage = $DataSiteDomainLanguage;
		$countSiteLanguage       = count($DataSiteDomainLanguage);
		foreach ($DataSiteDomainLanguage as $arrid => $siteAllLanguage ) {
			if( $siteAllLanguage['default_language'] == '1' ) {	// Get Information for Default Language
				
				$siteLanguageSelect = $siteAllLanguage;	// Default Language Information
				define('DEFAULT_LANGUAGE_ARRAY_ID', $arrid);
				define('DEFAULT_LANGUAGE_ID', $siteAllLanguage['site_language_id']);
				break;
				
			}
		}
	}
	
/* -------  Language Constants  ------- */
	define('SITE_LANGUAGE_ID', $arr_lang_cur['language_id']);
	
	define("DIR_CURRENT_LANGUAGE", $arr_lang_cur['language_dir']);
	
	define("CURRENT_LANGUAGE_NAME", $arr_lang_cur['language_name']);
	define("LANGUAGE_ICON", $arr_lang_cur['language_imagename']);
	define("LANGUAGE_SHORTNAME", $arr_lang_cur['language_shortname']);

	//echo DIR_CURRENT_LANGUAGE;
	//exit();

/* -------  Selected Language Directories Path  ------- */
	$lang_path = DIR_WS_LANGUAGES.DIR_CURRENT_LANGUAGE."/";
	define('DIR_WS_CURRENT_LANGUAGE',  $lang_path); //language wise 
	define('DIR_HTTP_LANGUAGES',SITE_URL.'languages/');
	define('DIR_HTTP_CURRENT_LANGUAGE', DIR_HTTP_LANGUAGES."/".DIR_CURRENT_LANGUAGE."/");

/* -------  Selected Language Buttons Directory Path used as submit  ------- */
// This is the define Constact for Current Site Directory 
	define('DIR_HTTP_SITE_CURRENT_TEMPLATE',   DIR_HTTP_TEMPLATES . SITE_TEMPLATE . "/");
	define('DIR_WS_SITE_CURRENT_TEMPLATE',   DIR_WS_TEMPLATES . SITE_TEMPLATE . "/");

// This is the define Constact for Current Site Images Directory
	define('DIR_HTTP_SITE_CURRENT_TEMPLATE_CSS', DIR_HTTP_SITE_CURRENT_TEMPLATE."css/"); 
	define('DIR_WS_SITE_CURRENT_TEMPLATE_CSS', DIR_WS_TEMPLATES."css/");	
	
// This is the define Constact for Current Site Images Directory
	
	//Calendar Directory
	define('DIR_HTTP_CALENDAR_IMAGES', DIR_HTTP_CALENDAR."images/");
	define('DIR_HTTP_CALENDAR_CSS', DIR_HTTP_CALENDAR."css/");
	define('DIR_HTTP_CALENDAR_CONFIG', DIR_HTTP_CALENDAR."config/");
	define('DIR_HTTP_CALENDAR_SCRIPT', DIR_HTTP_CALENDAR."script/");
	define('DIR_WS_CALENDAR_IMAGES', DIR_HTTP_CALENDAR."images/");
	define('DIR_WS_CALENDAR_CSS', DIR_HTTP_CALENDAR."css/");
	define('DIR_WS_CALENDAR_CONFIG', DIR_HTTP_CALENDAR."config/");
	define('DIR_WS_CALENDAR_SCRIPT', DIR_HTTP_CALENDAR."script/");

	
	
/* -------   Site's Languagewise images for path  ------- */
	define('DIR_HTTP_SITE_LANGUAGE_IMAGES', DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES . DIR_CURRENT_LANGUAGE  . "/"); //languagewise buttons
	define('DIR_WS_SITE_LANGUAGE_IMAGES', DIR_WS_SITE_CURRENT_TEMPLATE_IMAGES . DIR_CURRENT_LANGUAGE . "/"); //languagewise buttons

/* -------   Site's buttons for path  ------- */
	define('DIR_WS_SITE_LANGUAGE_BUTTONS',  DIR_WS_SITE_LANGUAGE_IMAGES . "buttons/");      //site's buttons
	define('DIR_HTTP_SITE_LANGUAGE_BUTTONS', DIR_HTTP_SITE_LANGUAGE_IMAGES . "buttons/");  ////site's buttons http
?>