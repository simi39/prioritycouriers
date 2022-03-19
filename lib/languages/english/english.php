<?php
	/******************************* Variable  Define *********************************/
	define("SITE_NAME","Priority Couriers");
	define("WELCOME_NOTE","Welcome to " . SITE_NAME);
	define("IMAGEWIDTH_MM","mm");
	define("DEFAULT_MOTTO","Unit 1");

	/*********************************************  Constants here are used for the mailing  ***********************************/
	//Alter tag for the submit and reset button
	define("ADDRESSNEW_PAGE_ALT_SUBMIT","Submit");
	define("ADDRESSNEW_PAGE_ALT_RESET","Reset");
	define("COMMON_CLOSE", "Close");

	define("SELECT_ONE_TYPE","Select Package Type");
	//Mail constants

	define("ACCOUNT","Account Page");


	/* for contact us and feedback page */
	define("CONTACTUS_NOTE", "You can also use the form below to contact us.");
	define("USER_WELCOME_NOTE", "Welcome");
	define("LOGGED_IN_MESSAGE","has logged in");

	define("NAVIGATION_ADDITIONAL","Additional Links");
	define("NAVIGATION_UTILITIES","Utilities");
	define("NAVIGATION_COURIERS","Online Couriers");
	define("COMMON_MESSAGE_IS_REQUIRED","Enquiry is Required");



	//#####  Start :: FOOTER MENU  #######/
	define("NAVIGATION_READ","&copy; 2015 Copyright Priority Couriers");
	define("NAVIGATION_BOOKING","Create Shipment");
	define("NAVIGATION_BOOK_NOW","Book Now");
	define("NAVIGATION_DISCLAIMER","Disclaimer");
	define("NAVIGATION_TERMS","Terms of Service");
	define("NAVIGATION_ABOUTUS","About Us");
	define("NAVIGATION_HOWTO","How to book a delivery");
	define("NAVIGATION_FAQ","FAQ's");
    define("NAVIGATION_SERVICES","Services");
    define("NAVIGATION_FEEDBACK","Feedback");
	define("NAVIGATION_PRIVACY_POLICY","Privacy Policy");
	define("NAVIGATION_QUICK_TRACKING","Quick tracking");
	define("NAVIGATION_NEW_ACCOUNT","New Account");
	define("NAVIGATION_FORGOT","Forgot Password");
	define("NAVIGATION_FORMS_LINKS","Forms &amp; Links");
    define("NAVIGATION_GUIDES","Packaging and Labelling Guidelines");
	define("NAVIGATION_DANGEROUS_GOODS","Dangerous Goods");
	define("NAVIGATION_PROHIBITED_ITEMS","Prohibited Items");
	define("NAVIGATION_TRANSIT_WARRANTY","Transit Warranty");
	define("NAVIGATION_TRACK_TRACE","Track &amp; Trace");
	define("ERROR_ALPHABETS_ONLY","Enter only alphabets (a-z A-Z ')");
	define("ERROR_CHKBRKTS_ONLY","Enter only allowed characters");
	define("ERROR_SMALL_ALPHABETS_ONLY","Enter only lower case alphabets (a-z)");
	$current_year = date('Y');
	define("NAVIGATION_COPYRIGHT","©$current_year OnlineCouriers.com.au");




	define("HEADING_USER_MYACCOUNT","My Account");
	define("HEADING_USER_PROFILE","My Profile");
	define("HEADING_USER_CHANGE_PASSWORD", "Change Password");
	define("COMMON_FORGOT_PASSWORD", "Forgot Password?");
	// other links
		define("HEADING_USER_LOGOUT","Logout");




	/**** Paging Constants ****/
	define("PAGING_COMMON_FIRST", "&laquo;  First");
	define("PAGING_COMMON_FIRST_COMMENT", "Click here to View First Page Record");

	define("PAGING_COMMON_PREVIOUS", "&laquo;  Previous");
	define("PAGING_COMMON_PREVIOUS_COMMENT", "Click here to View Previous Set of Page");

	define("PAGING_COMMON_NEXT", "Next  &raquo;");
	define("PAGING_COMMON_NEXT_COMMENT", "Click here to View Next Set of Page");

	define("PAGING_COMMON_LAST", "Last  &raquo;");
	define("PAGING_COMMON_LAST_COMMENT", "Click here to View Last Page Record");



	define("COMMON_SELECT_COUNTRY","Select Country");
	define("COMMON_DELETE","Delete");
	define("COMMON_EDIT","Edit");
	define("COMMON_VIEW","View");
	define("COMMON_BACK","Back");
	define("COMMON_REMOVE","Remove");
	define("COMMON_SELECT","Select");


	define("COMMON_ADD_INFORMATION","Additional Information");
	define("LOGIN_ALERT","Email Address is required");
	define("INVALID_LOGIN_ALERT","Entered information is incorrect.");
	define("PASSWORD_ALERT","Password is required");
	define("COMMON_EMAIL_ID","Email Address");
	define("COMMON_PASSWORD","Password");
	define("COMMON_INVALID_USER", "Invalid User");




	define("COMMON_ALERT_DELETE","Are you sure you want to delete ?");
	define("COMMON_MORE","More..");


	define("COMMON_PREVIOUS","Previous");// used in dbpager
	define("COMMON_BACK","Check Preview Before Proceeding");
	define("COMMON_SERIAL_NO","Sr#");

	define("COMMON_LABEL_ACTION", "Action");
	define("COMMON_REQUIRED_INFOMATION", "* Required Information");

	define("COMMON_LOGIN", "Login");
	define("COMMON_SELECT", "Select");

/*## End :: Common Label constant ##*/


//Re Defined Constant


//Name
	define("COMMON_FULLNAME_IS_REQUIRED", "Full Name is required");

	//Email
	define("ERROR_EMAIL_ID_IS_REQUIRED", "Email Address is required");
	define("ERROR_EMAIL_ID_INVALID", "The format of the e-mail address isn&acute;t correct.");
	define("COMMON_EMAIL_EXITS", "Somthing is not right. Please try again.");
	define("COMMON_EMAIL_NOT_EXITS", "Email Address does not exists");
	define("COMMON_EMAIL_ADDED", "Email Address added successfuly");

	/*Changepassword*/
	define("CONFIRM_PASSWORD_IS_REQUIRED", "Confirm Password is required");
   	define("CHANGEPASS_CURRENT_PASSWORD", "Current Password");
    define("CHANGEPASS_NEW_PASSWORD", "New Password");
    define("CHANGEPASS_CONFIRM_PASSWORD", "Confirm Password");



	define("COMMON_FIRSTNAME_IS_REQUIRED","First Name is required");
	define("COMMON_LASTNAME_IS_REQUIRED","Last Name is required");
	define("COMMON_STREET_IS_REQUIRED","Street Address is required");
	define("COMMON_CITY_IS_REQUIRED","City is required");
	define("COMMON_ZIPCODE_IS_REQUIRED","Post Code is required");
	define("COMMON_STREET_IS_REQUIRED", "Street Address is required");
	define("COMMON_STATE_IS_REQUIRED","State is required");
	define("COMMON_COUNTRY_IS_REQUIRED","Country is required");

	define("COMMON_EMAIL_IS_REQUIRED","Email Address  is required");
	define("COMMON_TITLE_IS_REQUIRED","Title is required");
	define("COMMON_EMAIL_EXISTS","Somthing is not right. Please try again.");
	define("COMMON_TITLE_EXISTS","This Title already exist");
	define("COMMON_ZONE_EXISTS","This zone already exist");
	define("COMMON_PASSWORD_IS_REQUIRED","Password is required");
	define("COMMON_CONFIRM_PASSWORD_IS_REQUIRED","Confirm Password is required");


	//Password
	define("ERROR_PASSWORD_REQUIRE", "Password is required");
	define("COMMON_NEW_PASSWORD_AND_CONFIRM_PASSWORD_SAME", "Password and Confirm password should be identical");
	define("COMMON_CURRENT_PASSWORD_IS_REQUIRED", "Current Password is required");
	define("COMMON_NEW_PASSWORD_IS_REQUIRED", "New Password is required");
	define("COMMON_EMAIL_PASSWORD" , "Somthing is not right. Please try again.");

	//subscription of newsletter
	/*define("COMMON_NEWSLETTER_SUBSCRIPTION", "Subscribe here:-");
	define("COMMON_NEWSLETTER_SUBSCRIPTION_EMAIL", "Enter Email Address");
	define("UNSUBSCRIBE", "<a href='thankuser.com'>".'unsubscribe'."</a>");
	*/
	define('DATA_NOT_FOUND', 'Data Not Found');


	define("NAVIGATION_HOME","Home Page");



	define("NAVIGATION_CONTACT_US","Contact Us");
	define("NAVIGATION_LATEST_NEWS","Latest News");
	define("NAVIGATION_HELP","Help Center");

	define('TESTIMONIAL_MORE','More..');
	define('TESTIMONIAL_HEADER','Testimonials');
	define('FREE_QUOTE_HEADER','Request Free Quote');

	define('FAQ_BACK_TO_TOP','Back to Top');
	define('NEWS_BACK_TO_TOP','Back to Top');
	define('NEWS_TITLE_REQUIRED','Title is required');
	define('NEWS_DESCRIPTION_REQUIRED','Description is required');

	define('FAQ_BACK_TO_TOP','Back to Top');
	define('NEWS_BACK_TO_TOP','Back to Top');
	define('NEWS_TITLE_REQUIRED','Title is required');
	define('NEWS_DESCRIPTION_REQUIRED','Description must required');
	define("COMMON_INVALID_STAFF_NO_ERROR","Staff No. is invalid");
	define("ERROR_STAFF_NO_IS_REQUIRED","Staff No. is required");
	define("USER_COMMON_ACTION","Action");
	define("BOOKING_OPTION_VIEW_SHIPMENT"," BOOKING VIDEO");
	define("COMMON_EXQUIRY_IS_REQUIRED","Enquiry is required");
	define("ENTER_ONLY_CAPITALS","Enter only capital letters(A-Z).");
	define("ENTER_ONLY_SMALL_CAPITALS","Enter only small and capital letters(a-z,A-Z).");

//##### :: PAGE HEADERS :: elswere undefined  #######/

	define("PAGE_HEADING_FAQ","Frequently Asked Questions");
	define("PAGE_HEADING_SITEMAP","Sitemap");
	define("PAGE_HEADING_HOME","Home");

/* ----	Top -----*/


/* ----	Contact -----*/
	define("DEFAULT_PL_ADDRESS_1","Unit 5");
	define("DEFAULT_PL_ADDRESS_2","41-43 Green St");
	define("DEFAULT_PL_CITY","Banksmeadow NSW 2019");
	define("DEFAULT_INFO_EMAIL","info&#64;prioritycouriers.com.au");
	define("DEFAULT_PHONE","1300 82 44 23");
	define("ERROR_SUBURB_ONLY","Enter only alphabets (a-z A-Z 0-9' space)");
	define("SUBURB_NOT_FOUND","Respective suburb not found.");

/*--Footer--- */
define("NEWSLETTER_SUBSCRIPTION_MESSAGE_HEAD","Newsletter Subscription");
define("NEWSLETTER_SUCCESS_AVAIL_MESSAG","Thank your for your subscription.");
define("EMAIL_ID_NOT_PROPER","Make sure you`re using a valid email address format e.g. <strong>info@prioritycouriers.com.au</strong>");
/*--Generic--- */
define("ERROR_FIELD_REQUIRED","This field is required.");
define("ERROR_CHECKBOX_REQUIRED","Please select checkbox.");
?>
