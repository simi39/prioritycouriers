<?php

/**
 * Image Management
 * add_image_gallery.php
 */
define("ADMIN_ADD_IMAGE_CATEGORY_HEADING","Add Image Category"); 
define("ADMIN_EDIT_IMAGE_CATEGORY_HEADING","Edit Category"); 
define("ADMIN_ADD_IMAGE_CATEGORY_BUTTON","Save Image Category"); 
define("ADMIN_EDIT_IMAGE_CATEGORY_BUTTON","Update Image Category"); 
define("ADMIN_IMAGE_CATEGORY_NAME","Category Name");
 
/*Search constant*/
define("ADMIN_SEARCH_IMAGE_CATEGORY_NAME","Search Category Name");

/**
 * Image Management
 * add_image_gallery.php
 */

define("ADMIN_IMAGE_GALLERY_FILTER_CATEGORY","Filter By Category");
define("ADMIN_IMAGE_GALLERY_FILTER_UPLOAD_IMAGE","Upload Image");
define("ADMIN_IMAGE_GALLERY_UPLOAD_IMAGE","Upload Image"); 
define("ADMIN_IMAGE_GALLERY_CATEGORY","Category"); 
define("ADMIN_IMAGE_GALLERY_ALL_RECORDS","All Images"); 
//define("ADMIN_IMAGE_GALLERY_FILE_VAILDATION","Upload gif, jpg, jpeg, tif, tiff, bmp, png,eps images only"); 



define('IMAGE_CATEGORY_NAME_EXITS', 'Category Name Already Exists');
define('IMAGE_CATEGORY_NAME_REQUIRED', 'Category Name is required');//JAVASCRIPT VALIDATION
define('IMAGE_CATEGORY_DELETE_CONFIRMATION', 'Are you sure to delete the Category?');
define('IMAGE_GALLARY_DELETE_CONFIRMATION', 'Are you sure you want to delete the Record ?');
define('IMAGE_SEARCH_CATEGORY', 'Search By Category');
define('IMAGES', 'Images');
define('ALLIMAGES', 'All Images');
 

/**
 * Image Management
 * image_category.php
 */

define("ADMIN_IMAGE_SEARCH_CATEGORY_NAME","Search by Category Name");   
define("ADMIN_IMAGE_CATEGORY_ADD_CATEGORY","Add Category");
define("ADMIN_IMAGE_CATEGORY_NAME","Category Name");

/*
* messeges for image category
*/
$arr_message = array (
MSG_ADD_SUCCESS => 'Image Category has been added successfully',
MSG_EDIT_SUCCESS => 'Image Category has been updated successfully',
MSG_DEL_SUCCESS => 'Image Category has been deleted successfully',
);

/*
* messeges for image gallery
*/
$arr_message_gallery = array (
	MSG_ADD_SUCCESS => 'Image has been added successfully',
	MSG_DEL_SUCCESS => 'Image has been deleted successfully',
	MSG_EDIT_SUCCESS => 'Image has been updated successfully',
);


?>
