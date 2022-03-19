<?php
#Header
define("COMMON_HOME","Home");

/*## COMMON CONSTANTS ##*/
define("COMMON_FULLNAME", "Name");
define("COMMON_FIRSTNAME", "First Name");
define("COMMON_LASTNAME", "Last Name");
define("COMMON_EMAIL_ID", "Email Address");
define("COMMON_EMAIL_TOPIC", "Email Topic");
define("COMMON_STREET", "Street");
define("COMMON_SUBURB", "Suburb/City");
define("COMMON_CITY", "City");
define("COMMON_STATE", "State");
define("COMMON_COUNTRY", "Country");
define("COMMON_ZIPCODE", "PostCode");
define("COMMON_US_ZIPCODE", "ZipCode");
define("COMMON_PHONE", "Phone No");
define("COMMON_AREA_CODE", "Area Code");
define("COMMON_CONTACT_NUMBER", "Contact Number");
define("COMMON_CONTACT_NUMBER_2", "Alternative Number");
define("COMMON_MOBILE_PHONE", "Contact Number");
define("COMMON_COMPANY_NAME", "Company");
define("COMMON_ADDRESS", "Address");
define("COMMON_FACSIMILE_NO", "Facsimile No");
define("COMMON_SECURITY_QUESTION", "Security Questions");
define("COMMON_SECURITY_ANSWER", "Your Answer");
define("SELECT_UPLOAD_CSV_FILE","Select Upload CSV file");

/*## COMMON CONSTANTS FOR VALIDATIONS ##*/

define("COMMON_FIRSTNAME_IS_REQUIRED", "First Name is required");
define("COMMON_LASTNAME_IS_REQUIRED", "Last Name is required");
define("COMM0N_CITY_IS_REQUIRED", "City is required");
define("COMM0N_SUBURB_IS_REQUIRED", "Suburb is required");
define("COMM0N_ZIPCODE_IS_REQUIRED", "Postcode is required");
define("COMM0N_ZIPCODE_IS_NUMERIC", "Enter only numeric values (0-9)");
define("COMM0N_STATE_IS_REQUIRED", "State is required");
define("COMM0N_COUNTRY_IS_REQUIRED", "Country is required");
define("COMM0N_COMPANY_NAME_IS_REQUIRED", "Company Name is required");
define("COMMON_PHONE_IS_REQUIRED", "Contact Number is required");
define("COMMON_AREA_CODE_IS_REQUIRED", "Area Code is required");
define("COMMON_ADDRESS_IS_REQUIRED", "Address is required");
define("COMMON_SECURITY_QUESTION_IS_REQUIRED", "Security question is required");
define("COMMON_SECURITY_ANSWER_IS_REQUIRED", "Security answer is required");
define("COMMON_SECURITY_ANSWER_ALPHANUMERIC", "Enter alphanumeric characters only (a-z A-Z 0-9)");
define("COMMON_NAME_ALPHABETHS", "Enter allowed characters only<br />(a-z A-Z ')");
define("COMMON_SUBURB_CHARACTERS", "Enter allowed characters only<br />(a-z A-Z -)");
define("COMMON_GENERIC", "You are using forbiden characters");
define("COMMON_COMPANY_CHARACTERS", "Enter allowed characters only<br />(a-z A-Z 0-9 ' , _ .-/)");
define("COMMON_ADDRESS_CHARACTERS", "Enter allowed characters only (a-z A-Z &acute; - /)");
define("COMMON_PASSWORD_MINIMUM_LENGTH", "Password minimum length is 6 characters");
define("COMMON_CAPITAL_LETTERS","Enter only capital letters (A-Z)");
define("COMMON_EXISTING_PASSWORD","Enter Old Password");
define("COMMON_VALID_FAX_NO","Enter valid Facsimile number (+ 0-9)");
/*## user_registration.php ##*/
define("COMMON_EMAIL_PASSWORD","Either the email address or password you entered is incorrect. Please try again.");
define("COMMON_LOGIN_ATTEMPTS","You have been temporarly blocked from using this feature. If you believe this is a mistake, please contact our friendly support team at 1300 82 44 23.");
//define("COMMON_INVALID_USER", "Invalid User");
define("COMMON_FORGOT_PASSWORD", "Forgot Password?");
define("COMMON_PASSWORD", "Password");
define("COMMON_NEW_PASSWORD", "Enter New Password");
define("COMMON_CONFIRM_PASSWORD", "Confirm Password");
define("MSG_CAPTCHA_IS_REQUIRED", "To continue, check the box above and follow the instructions.");
define("COMMON_NEWLETTER_SEND", "Send Newsletters");
define("COMMON_NUMERIC_VAL","Enter numeric values");


/*## user_changepassword.php ##*/
define("INVALID_USER","Your link has expired.");
define("USER_PASSWORD_NOT_MATCH", "Current Password entered does not match with User password");
define("USER_PASSWORD_SAME", "New password and old password are identical");
define("MESSAGE_CHANGE_PASSWORD_SUCCESS", "Your password has been changed successfully. You can now sign in with your new password.");
define("CURRENT_AND_CONFIRM_PASSWORD_SAME", "Passwords don't match. Please try again.");
define("NEWPASSWORD_IS_REQUIRED", "New Password is required.");
define("MESSAGE_CHANGE_PASSWORD_SUCCESS	
", "Your Password has been changed please use login window to login again.");

/*## addressnew.php ##*/
define("ADDRESSNEW_PAGE_ADDNEWADDRESS", "Add New Address");
define("ADDRESSNEW_PAGE_EDITADDRESS", "Edit Address");
define("LABEL_SELECT_FROM_LIST", "Select Address From List");

/*## signup.php ##*/
	define("SIGNUP", "Sign Up");
	define("SIGNUP_RETURN_CUSTOMER", "I am a Returning Customer");
	define("SIGNUP_LOGIN", "Login");
	define("SIGNUP_SUBSCRIBE_NEWSLETTER", "Subscribe for News Letter");
	//define("SIGNUP_NOTE", "Please double check the e-mail address you have entered. This is the address to which we will send your order and shipping confirmations. It also serves as your unique username. By clicking on the 'Submit' button, you agree to iPrintUS terms of use.");
	define("SIGNUP_NOTE_TERMS_OF_USE", "Terms of Use");
	define("SIGNUP_NOTE1", "If you already have an account with us, then please login at login page ");
	define("SIGNUP_TERMS", "For a complete description, please read our ");
	define("SIGNUP_PERSONAL_DETAILS", "Personal Details");
	define("SIGNUP_LOGIN_INFO", "Log-In Information");
	define("SIGNUP_PRIVACY_POLICIES", SITE_NAME . " Privacy and Security Policy");
	define("SIGNUP_ACCOUNT", SITE_NAME . " Account");
	define("SIGNUP_CLUB", "Join the " . SITE_NAME . " Club");
	define("SIGNUP_PRIVACY_POLICY", SITE_NAME . " Privacy and Security Policy");
	define("SIGNUP_LOGIN_TEXT", '<span class="link">If you already have an account with us, then please login at the <a href="javascript:void(0);" onclick="DisplaySignInForm();">login page</a></span>');
	define("SIGNUP_CUSTOMER_LOGIN","Customer Login");
	define("SIGNUP_CUSTOMER_NEW","Registration");	

/*## profile.php ##*/	
	define("PROFILE_PAGE_NAME","Profile");
	define("PROFILE_PAGE_EDIT","Edit your details");
	define("PROFILE_FIELD_REQUIRED","This field can not be empty.");
	define("PROFILE_ILLEGAL_CHARACTERS","You are using illegal characters.");
	define("PROFILE_STATE_NOT_FOUND","State not found.");
	define("PROFILE_ADDRESSES_WRONG_HEAD","Wrong Addresses.");
	define("PROFILE_ALLOWED_CHARACTERS_NAMES","Use only <strong>a</strong>-<strong>z</strong> <strong>A</strong>-	<strong>Z</strong> <strong>&acute;</strong>.");
	define("PROFILE_EMAIL_VALID","Make sure you`re using a valid email address format e.g. <strong>info@prioritycouriers.com.au</strong>");
	define("PROFILE_ALLOWED_CHARACTERS_DIGITS","Use only <strong>0</strong>-<strong>9</strong>.");
	define("PROFILE_CORRECT_PHONE_LENGTH",'Please include landline or mobile prefix. No spaces are allowed e.g.<ul><li>0122223333</li><li>0411222333</li></ul>');
	define("PROFILE_CORRECT_AREACODE_LENGTH",'Please include landline or mobile prefix.Spaces are allowed e.g.<ul><li>+0122</li><li>0411</li></ul>');
	define("PROFILE_AREACODE_ALLOWED_CHARACTERS_DIGITS","Use only <strong>+</strong><strong>0</strong>-<strong>9</strong>.");
	define("PROFILE_CORRECT_PHONE_LENGTH_MAX",'The number cannot contain more than 17 digits.');

	define("PROFILE_FIRSTNAME_REQUIRED","Your first name is required.");
	define("PROFILE_LASTNAME_REQUIRED","Your surname is required.");
	define("PROFILE_ADDRESS1_REQUIRED","Your address is required.");
	define("PROFILE_COUNTRY_REQUIRED","Your country is required.");
	define("PROFILE_SUBURB_REQUIRED","Your suburb or city is required.");
	define("PROFILE_STATE_REQUIRED","Your state is required.");
	define("PROFILE_POSTCODE_REQUIRED","Your postcode is required.");
	define("PROFILE_POSTCODE_CORRECT","Enter a valid postcode.");
	define("PROFILE_EMAIL_REQUIRED","Your email is required.");
	define("PROFILE_PASSWORD_REQUIRED","Password is required.");
	define("PROFILE_PASSWORD_CONFIRM_REQUIRED","Password confirmation is required.");
	define("PROFILE_OLD_PASSWORD_REQUIRED","Your old password is required to save the changes.");
	define("PROFILE_CONTACTNO_REQUIRED","Your contact number is required.");
	define("PROFILE_AREACODE_REQUIRED","Your area code is required.");
	define("PROFILE_SECURITY_QUESTION","Your security question is required.");
	define("PROFILE_SECURITY_ANSWER","Your security answer is required.");
	define("PROFILE_RIGHT_PASSWORD","Your password needs to contain at least one lowercase <strong>a-z</strong>, one uppercase <strong>A-Z</strong> and one digit <strong>0-9</strong>.");
	define("PROFILE_PASSWORD_LENGTH","Your password needs to be at least <strong>8</strong> characters long.");
	define("PROFILE_PASSWORD_CONFIRM","The password and its confirm are not the same.");
	define("PROFILE_OLD_PASSWORD_LENGTH","Your old password is at least <strong>8</strong> characters long.");
	
	//mail for forgotpassword
	define("FORGOT_SUBJECT","Your ". SITE_NAME . " Password");
	define("FORGOT_STATEMENT1","Your new password is");
	define("FORGOT_STATEMENT2","You can change your password on Your");
	define("FORGOT_STATEMENT3","Design a unique identity for yourself and your business - log on to ");
	
	//mail for forgotpassword
	define("CHANGE_PASSWORD_SUBJECT","Your " . SITE_NAME . " Password");
	define("CHANGE_PASSWORD_STATEMENT1","Your new password is");
	define("CHANGE_PASSWORD_STATEMENT2","You can change your password on Your");
	define("CHANGE_PASSWORD_STATEMENT3","Design a unique identity for yourself and your business - log on to ");
	
	/*## forgotpassword.php ##*/
	define("FORGOTPASS_EMAIL_SENT_SUCCESS", "A confirmation email including a link to reset your password has been sent to your designated email address.");
	define("CHANGE_PASSWORD_HEADER", "Password Change Confirmation");
	
	define("MSG_CONFIRM_MODIFICATION", "Are you sure you want to change address?");
	define("TELLAFRIEND_MESSAGE_SENT_SUCCESS","Thanks for contacting us.");
	define("COMMON_NAME_IS_REQUIRED","Name is required");
	define("COMMON_EMAIL_ID_IS_REQUIRED","Email is required");
	define("COMMON_COMMENT_IS_REQUIRED","Comment is required");
	define("COMMON_CONFIRM_PASSWORD_DIFFERENT_ERROR","Password does not match the confirm password");
	define("ERROR_ENTER_NUMERIC_VALUE","Enter only numeric values (0-9)");
	define("ERROR_AREA_CODE_INVALID", "Enter only numeric values (0-9)");
	
	define("REGISTRATION_MESSAGE_HEAD", "Registration Confirmation");
	define("REGISTRATION_MESSAGE","<div class='information_pop-up'>Thank you for registering with Priority Couriers.</div><br /><div class='information_pop-up_content'>You can now sign in and start using Priority Couriers premium features. Additional information has been sent to the email used during registration process.</div>");
	define("ENTER_CHARACTER","At least 2 characters <br />are required");
	define("TERMS_AND_CONDITION","Please confirm the terms and condition");
	define("MSG_ERROR_IN_CAPTCHA", "Please check the reCAPTCHA box below to proceed to the next stage in resetting your password.");
	define("ERROR_US_POSTCODE","Please enter your ZIP code containg 5 digits only. If your ZIP code contains 4 digits put 0 in front e.g. <strong>01234</strong>.");
	define("SUBURB_NOT_FOUND","Respective suburb not found.");
?>