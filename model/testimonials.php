<?php

	/**
	 * include common
	 */
	
	require_once("lib/common.php");
	require_once(DIR_WS_MODEL ."TestimonialMaster.php");
	
	$arr_css_plugin_include[] = 'glyphicons_new/css/glyphicons.css';
	
    // Object Declaration
	$testimonialMstObj = TestimonialMaster::Create();
	$testimonialDataObj= new TestimonialData();	
	if(isset($_POST['btnlogin'])) {
		$auth_result = user_athuentication($_POST['email_signup'], $_POST['password_signup']);
		UnsetSession();
		if(empty($auth_result['error_email']) && empty($auth_result['error_password'])){
			show_page_header(FILE_TESTIMONIAL, false);
			exit();
		}
	}
	$testimonialdata = $testimonialMstObj->getTestimonialdata(SITE_LANGUAGE_ID);


	require_once( DIR_WS_SITE_CURRENT_TEMPLATE . FILE_MAIN_INTERFACE);
	
?>