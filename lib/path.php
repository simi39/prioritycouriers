<?php
/*
* init paths for libs & all directories path(from root path) are define in this file
*
*/

//  DEFINE THE SITE URL
$Url = $_SERVER['HTTP_HOST'];
//echo $Url;
$CurrentProtocol = "https://";
//echo $_SERVER['DOCUMENT_ROOT'];
//exit();
define('SITE_PROTOCOL',$CurrentProtocol); //$_root_path
define('SITE_INDEX',SITE_PROTOCOL.$Url);
//echo $_SERVER['DOCUMENT_ROOT'];
define('SITE_DIRECTORY',"/");  // If site hosten in particular directory then set it. If site upload on Root then put it Slash (/) Only
define('SITE_ADMIN_DIRECTORY', "admin/");  //  Admin Directory Name
define('SITE_DESIGNER_DIRECTORY', "designer/");  //  Admin Directory Name
define('SITE_BLOG_DIRECTORY', "blog/");  //  Blog Directory Name

/// Front side Site Path constant
define('SITE_URL',SITE_PROTOCOL.$_SERVER['HTTP_HOST'] .SITE_DIRECTORY);  //Site URL with Protocol
define('SITE_URL',SITE_PROTOCOL.$Url .SITE_DIRECTORY);  //Site URL with Protocol
define('SITE_URL_WITHOUT_PROTOCOL', $_SERVER['HTTP_HOST'] . SITE_DIRECTORY);	//Site URL Without Protocol
define('SITE_URL_WITHOUT_PROTOCOL', $Url . SITE_DIRECTORY);	//Site URL Without Protocol
define('SITE_DOCUMENT_ROOT', $_SERVER['DOCUMENT_ROOT'] . SITE_DIRECTORY);
//define('SITE_DOCUMENT_ROOT', '/var/www/prioritycouriers.com.au' . SITE_DIRECTORY);

// Admin side path contsant
define('SITE_ADMIN_URL', SITE_URL . SITE_ADMIN_DIRECTORY);  //  define Admin side Absolute path
define('DIR_WS_ADMIN', SITE_DOCUMENT_ROOT . SITE_ADMIN_DIRECTORY);  // Admin side real/physiscal path

/******** Front side paths *********/
//echo SITE_URL;
//exit();
// CSS path
define('DIR_HTTP_ASSETS',SITE_URL.'assets/'); //home for javascript, css, images, plugins
define('DIR_WS_ASSETS',SITE_DOCUMENT_ROOT.'assets/'); //home for javascript, css, images, plugins
define('DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES', SITE_URL."assets/img/");
define('DIR_WS_SITE_CURRENT_TEMPLATE_IMAGES', SITE_DOCUMENT_ROOT."assets/img/");

define('DIR_HTTP_JSCRIPT',DIR_HTTP_ASSETS.'js/');
define('DIR_WS_JSCRIPT',DIR_WS_ASSETS.'js/');

define('DIR_HTTP_RELATED',SITE_URL.'related/');
define('DIR_WS_RELATED',SITE_DOCUMENT_ROOT.'related/');

define('DIR_HTTP_RECAPTCHA',SITE_URL.'related/recaptcha/');
define('DIR_WS_RECAPTCHA',SITE_DOCUMENT_ROOT.'related/recaptcha/');

define('DIR_HTTP_AJAX',SITE_URL.'ajax/');
define('DIR_WS_AJAX',SITE_DOCUMENT_ROOT.'ajax/');

define('DIR_HTTP_MEDIA',SITE_URL.'media/');
define('DIR_WS_MEDIA',SITE_DOCUMENT_ROOT.'media/');

//calendar path
define('DIR_HTTP_CALENDAR',SITE_URL.'calendar/');
define('DIR_WS_CALENDAR',SITE_DOCUMENT_ROOT.'calendar/');


/******** Admin paths *********/
define('DIR_HTTP_ADMIN_CSS', SITE_ADMIN_URL .'css/');  //  define the absolute path for stylesheet
define('DIR_HTTP_ADMIN_IMAGES', SITE_ADMIN_URL .'images/');  //  define the absolute path for stylesheet
define('DIR_WS_ADMIN_INCLUDES', DIR_WS_ADMIN."includes/");
define('DIR_WS_ADMIN_DOCUMENTS', DIR_WS_ADMIN."documents/");
define('DIR_WS_ADMIN_LANGUAGES', DIR_WS_ADMIN_INCLUDES.'languages/');

//echo $_SERVER['DOCUMENT_ROOT'];
/******************All Main Directory path********************/
///  Design Template Path
define('DIR_HTTP_TEMPLATES', SITE_URL.'templates/');
define('DIR_WS_TEMPLATES', SITE_DOCUMENT_ROOT.'templates/');
define('DIR_HTTP_PDF',SITE_URL.'pdf/');
define('DIR_WS_PDF',SITE_DOCUMENT_ROOT.'pdf/');
define('DIR_HTTP_RELATED_PDF',SITE_URL.'related/vendor/dompdf/');
define('DIR_WS_RELATED_PDF',SITE_DOCUMENT_ROOT.'related/vendor/dompdf/');
define('DIR_HTTP_CSS',DIR_HTTP_ASSETS.'css/'); //CSS Correct path
define('DIR_WS_CSS',DIR_WS_ASSETS.'css/'); //CSS Correct path
define('DIR_HTTP_PLUGINS',DIR_HTTP_ASSETS.'plugins/'); //home for plugins
define('DIR_WS_PLUGINS',DIR_WS_ASSETS.'plugins/'); //home plugins


define('DIR_HTTP_VENDOR',SITE_URL.'related/vendor/');
define('DIR_WS_VENDOR',SITE_DOCUMENT_ROOT.'related/vendor/');


//define('DIR_WS_ONLINEPDF','/home/qantasgr/public_html/prioritycouriers-PDF/');
define('DIR_WS_ONLINEPDF','/var/www/prioritycouriers-PDF/');

// TPL file path
define('DIR_WS_CONTENT'	, DIR_WS_TEMPLATES .'content/');
define('DIR_HTTP_CONTENT', DIR_HTTP_TEMPLATES .'content/');

// PDF file path
define('DIR_WS_PDF' , DIR_WS_PDF.'pdf/');
define('DIR_HTTP_PDF' , DIR_HTTP_PDF.'pdf/');

/******************All Main Directory path********************/

define('DIR_WS_LIB', SITE_DOCUMENT_ROOT.'lib/');
define('DIR_WS_MODEL', SITE_DOCUMENT_ROOT.'model/');
define('DIR_WS_PAYMENT',SITE_DOCUMENT_ROOT.'related/payment/');
// Directory for Payment Modules
//define('DIR_LIB_PEAR',"C:/xampp_new/php/pear/");
define('DIR_LIB_PEAR',DIR_WS_LIB."pear/");
define('DIR_WS_LANGUAGES', DIR_WS_LIB.'languages/');


##############		Store Image PAth Added By Developer   ###########

// This is used for language image and also put same language name in the config.php LANGUAGES
define('DIR_HTTP_IMAGES',SITE_URL . 'images/');
define('DIR_WS_IMAGES', SITE_DOCUMENT_ROOT."images/");

/* for uploading the banner images */
define('DIR_IMAGE_FLASHGALLARY_LARGE',DIR_WS_IMAGES.'flashgallary/large');
define('DIR_HTTP_IMAGE_FLASHGALLARY_LARGE',DIR_HTTP_IMAGES.'flashgallary/large/');
define('DIR_IMAGE_FLASHGALLARY_THUMB',DIR_WS_IMAGES.'flashgallary/thumb');
define('DIR_HTTP_IMAGE_FLASHGALLARY_THUMB',DIR_HTTP_IMAGES.'flashgallary/thumb/');

/******************Sub Directory Path**********************/
define('DIR_LIB_CLASSES',DIR_WS_LIB .'Classes/');
define('DIR_LIB_CLASSES_DATA',DIR_LIB_CLASSES .'Data/');
define('DIR_LIB_CLASSES_EXCEPTION',DIR_LIB_CLASSES .'Exception/');
define('DIR_LIB_CLASSES_JS',DIR_LIB_CLASSES .'JavaScript/');
define('DIR_LIB_CLASSES_MODELS',DIR_LIB_CLASSES .'Models/');
define('DIR_LIB_CLASSES_PHPMAILER',DIR_LIB_CLASSES .'PhpMailer/');


/****************End Sub-Directory List***********************/

define('DIR_HTTP_FCKEDITOR', DIR_HTTP_PLUGINS . "ckeditor/");
define('DIR_WS_FCKEDITOR', DIR_WS_PLUGINS."ckeditor/");

define('DIR_WS_PAYMENT', SITE_DOCUMENT_ROOT.'payment/');
define('DIR_HTTP_TEMPLATES_IMG', DIR_HTTP_TEMPLATES.'default/images/');
define('DIR_WS_TEMPLATES_IMG', DIR_WS_TEMPLATES.'default/images/');

//Paypal changes by smita 27th Nov 2020
define('SITE_PAYPAL_API_DIRECTORY', "paypal_api/"); 
define('DIR_WS_PAYPAL_API', SITE_DOCUMENT_ROOT . SITE_PAYPAL_API_DIRECTORY);  // Admin side real/physiscal path
// Setting include path
$separator = ":";
if( strtoupper(substr(PHP_OS, 0, 3)) === 'WIN' )
	$separator = ";";

$include_path = '.';
$include_path = ini_get('include_path');
$include_path .= $separator.realpath(DIR_WS_LIB);
$include_path .= $separator.realpath(DIR_WS_LIB.'pear/');
$include_path .= $separator.realpath(DIR_LIB_CLASSES_EXCEPTION);
ini_set('include_path', $include_path);
?>
