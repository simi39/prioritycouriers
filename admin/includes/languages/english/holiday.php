<?php
	define("ADMIN_NEWS_CATEGORY","NEWS Category");
	define("ADMIN_EXPORT_NEW","Export Holiday Details");
	define("ADMIN_UPLOAD_CSV","Upload Fille");
	define("ADMIN_POSTCODE_UPLOAD_CSV","Upload Multiple Holidays");
	define('ADMIN_NEWS_CATEGORY_HEADING', 'NEWS Category');	
	define('ADMIN_NEWS_CATEGORY_NAME', 'Category Name');
	define('ADMIN_HOLIDAY_DATE', 'Holiday Date');
	define('ADMIN_HOLIDAY_END_DATE', 'End Date');
	define('ADMIN_HOLIDAY_STATE', 'State');
	define('ADMIN_HOLIDAY_DESCRIPTION', 'Descriptionn');
	define('ADMIN_HOLIDAY_NAME', 'Name');
	define('ADMIN_NEWS_CATEGORY_ADD_LABEL', 'Add Category');
	define('ADMIN_NEWS_CATEGORY_ADD_HEADING', 'Add Category');
	define('ADMIN_NEWS_CATEGORY_EDIT_HEADING', 'Edit Category');
	define('ADMIN_NEWS_CATEGORY_UPDATE_BUTTON', 'Update Category');
	define('ADMIN_NEWS_CATEGORY_SEARCH_NAME', 'Search by Category Name');
	define('ADMIN_HOLIDAY_TITLE',"Title");
	define("COMMON_SECURITY_ANSWER_ALPHANUMERIC", "Enter alphanumeric characters.");
	
	define('NEWS_CATEGORY_NAME_EXITS', 'NEWS Category already exists');
	define('HOLIDAY_HOLIDAY_DATE_REQUIRED', 'Holiday Date is required');
	define('HOLIDAY_START_DATE_REQUIRED', 'Start Date is required');
	define('HOLIDAY_STATE_REQUIRED', 'State is required');
	define('HOLIDAY_NAME_REQUIRED','Holiday Name is required.');
	define('NEWS_QUESTION_REQUIRED', 'Question is r/**
	 * Enter description here...
	 *
	 */
	equired');
	define('NEWS_ANSWER_REQUIRED', 'Answer is required');

	/* NEWS Question / Answer section*/
	define('ADMIN_HOLIDAYS_ADD_LABEL', 'Add Holidays');
	define('ADMIN_NEWS_ADD_HEADING', 'Add NEWS');
	define('ADMIN_HOLIDAY_EDIT_HEADING', 'Edit Holiday Date');
	define('ADMIN_NEWS_UPDATE_BUTTON', 'Update NEWS');
	define("ADMIN_START_DATE","Start Date");
	define("ADMIN_END_DATE","End Date");
	define('ADMIN_NEWS_SEARCH_NAME', 'Search by NEWS Name');
	define('ADMIN_STARTDATE_REQUIRED', 'Start Date is required');
	define('ADMIN_END_DATE_REQUIRED', 'End date is required.');
	define('ADMIN_DESCRIPTION_REQUIRED', 'Description is required.');
	define('ADMIN_SEARCH_HOLIDAY_CATEGORY_NAME', 'Search Category Name');
	
	
	
	/* define  message  */
	define('MSG_ADD_SUCCESS_FOR_HOLIDAY', 'Date has been added successfully');
	define('MSG_EDIT_SUCCESS_FOR_HOLIDAY','Date has been updated successfully');
	define('MSG_DEL_SUCCESS','Date has been deleted successfully');
	define('ERROR_ALREADY_INTERNATIONAL_AVAILABLE_CSV_FILE','The data of the csv is already exist.');
	define('ERROR_CSV_FILE_FORMAT','The data of the csv is not match with the database field.Please select the valid csv.');
	define('SELECT_UPLOAD_CSV_FILE','Please Select the csv file.');
		
	$arr_message = array (
			MSG_ADD_SUCCESS_FOR_HOLIDAY => 'Date has been added successfully',
			MSG_EDIT_SUCCESS_FOR_HOLIDAY => 'Date has been updated successfully',
			MSG_DEL_SUCCESS => 'Date has been deleted successfully',			
	);
	
	$arr_message_template = array (
			MSG_ADD_SUCCESS_FOR_HOLIDAY => 'NEWS has been added successfully',
			MSG_EDIT_SUCCESS_FOR_HOLIDAY => 'NEWS has been updated successfully',
			MSG_DEL_SUCCESS => 'NEWS has been deleted successfully',			
			MSG_STATUS_SUCCESS => 'Status has been updated successfully',			
	);
	
	$arr_message = array (
	MSG_EDIT_SUCCESS_FOR_HOLIDAY => 'Date has been updated successfully',
	        MSG_ADD_SUCCESS_FOR_HOLIDAY => 'Date has been added successfully',
			ERROR_ALREADY_INTERNATIONAL_AVAILABLE_CSV_FILE => 'The data of the csv is already exist.',
			ERROR_CSV_FILE_FORMAT => 'The data of the csv is not match with the database field.Please select the valid csv.',
			SELECT_UPLOAD_CSV_FILE => "Please Select the csv file."		,
	
		);
	/* end  messages */
?>
