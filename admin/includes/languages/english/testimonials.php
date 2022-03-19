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
	require_once(DIR_WS_MODEL."/TestimonialMaster.php");
	
    // Object Declaration
	$testimonialMstObj = TestimonialMaster::Create();
	$testimonialDataObj= new TestimonialData();
	$sqlQuery= "SELECT * FROM testimonial
                    INNER JOIN testimonial_description ON (testimonial.testimonial_id = testimonial_description.testimonial_id)
                    WHERE site_language_id = ".SITE_LANGUAGE_ID." and testimonial.status = '1' and site_id=".CURRENT_SITE_ID." ORDER BY testimonial.sortorder,testimonial_description.testimonial_description";
	$testimonialdata = $testimonialMstObj->getTestimonial(null,null,null,null,null,$sqlQuery);
	require_once(DIR_WS_LIB."/file_function.php");
	
?>
