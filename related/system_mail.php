<?php
	/**
	 * This file is load the card and Display card
	 *
	 * This file shows the card lising. we can select card from this. This is also apply search criteria.This file load studio & Display the card in studio
	 *
	 *
	 * @author     Radixweb <team.radixweb@gmail.com>
	 * @copyright  Copyright (c) 2008, Radixweb
	 * @version    1.0
	 * @since      1.0
	 */
	
	/**
	 * Common File Inclusion
	 * 
	 */
	require_once("common.php");
	require_once(DIR_WS_CURRENT_LANGUAGE . "system_mail.php");
	require_once(DIR_WS_MODEL . "UserMaster.php");
	require_once(DIR_WS_LIB."filenames.php");
	require_once(DIR_WS_LIB."ft-nonce-lib.php");
	require_once(DIR_WS_ADMIN_INCLUDES."filenames.php");
	require_once(DIR_WS_MODEL . "EmailTemplateManagerMaster.php");
	require_once(DIR_WS_MODEL . "BookingDetailsMaster.php");
	require_once(DIR_WS_MODEL . "CountryMaster.php");
	
	
	$objDocumentMaster = EmailTemplateManagerMaster::Create();
	
	
/**
 * This Function is executed when registration of user is done
 *
 * @param object $siteobj
 * @param sting $db
 */


function SendMailContent($toEmailID,$EmailKey,$FindArray="",$ReplaceArray="",$CCEmailID="",$BCCEmailID="",$fromEmail="",$attachment="") {
	$UserMasterObj    = UserMaster::Create();
    $UserDataObj = new UserData();
	$preferencesObj= new Preferences();
	$language_id = SITE_LANGUAGE_ID;
	global $objDocumentMaster;
		

	
	if(isset($_SESSION['Thesessiondata']['_sess_login_userdetails'])){
			$session_data = json_decode($_SESSION['Thesessiondata']['_sess_login_userdetails'],true);
			$userid = $session_data['user_id'];	
			$userSeaArr[]     = array('Search_On'=>'email', 'Search_Value'=>$toEmailID, 'Type'=>'string', 'Equation'=>'=', 'CondType'=>'AND', 'Prefix'=>'','Postfix'=>'');
			$Users            = $UserMasterObj->getUser(null, $userSeaArr);
			$password            = $Users[0]->password;
			if($userid!='' && $password!='')
			{
				$password = base64_encode($password);
				$password = rawurlencode($password);
				$myaccount_link = '<a href="'.show_page_link(FILE_SIGNUP).'?temp_value=set'.$userid.'&email='.$toEmailID.'&password='.$password.'" class="email_link">'.MAIL_HEADER_MYACCOUNT."</a>";
			}
}
	
	
	/*
	exit();
	if($userid != ""){
	$myaccount_link = '<a href="'.show_page_link(FILE_SIGNUP).'userid?'.$userid.'" class="email_link">'.MAIL_HEADER_MYACCOUNT."</a>";
	}*/
	
	$orderByArr = array("email_template_manager.template_id DESC");
	$objDocumentData = $objDocumentMaster->getEmailTemplateDetails($EmailKey,$language_id,null,$orderByArr);
	
	/**
	 * Replace the Variable Data
	 */
	$EmailContent = "";
	$EmailSubject = "";
	//dprint($objDocumentData);
	if($fromEmail != '') { 
		$fromEmailId = htmlentities($fromEmail);
		
	} else if($objDocumentData[0]->template_from_address!="") {
		$fromEmailId = htmlentities($objDocumentData[0]->template_from_address);
		
	} else {
		$fromEmailId = htmlentities(SITE_FROM_EMAIL_ID);
		
	}
	
	
	//dprint($objDocumentData);
	if($objDocumentData != "") {
		if($objDocumentData[0]->template_content!="") {
			$EmailContent = str_replace($FindArray,$ReplaceArray,$objDocumentData[0]->template_content);
		}
		if($objDocumentData[0]->template_subject!="") {
			$EmailSubject = str_replace($FindArray,$ReplaceArray,$objDocumentData[0]->template_subject);
		}
	}
	
	
	// This is for the To address.
	if($objDocumentData[0]->template_to_address != "") {
		if($toEmailID != ""){
			$toEmailID .= " , ".$objDocumentData[0]->template_to_address;	
		}
		else {
			$toEmailID = $objDocumentData[0]->template_to_address;	
		}
		
	}
	//echo $EmailContent;
	//exit();
	// This is for the To address.
	if($objDocumentData[0]->template_cc_address != "") {
		$CCEmailIDStr = $objDocumentData[0]->template_cc_address;
	} else {
		$CCEmailIDStr = $CCEmailID;
	}
	
	$CCEmailID  = array();
	if($CCEmailIDStr != ""){
		$CCEmailIDArr = explode(",",$CCEmailIDStr);
		if(!empty($CCEmailIDArr)){
			for ($i=0;$i<count($CCEmailIDArr);$i++){
				if($CCEmailIDArr[$i] != ""){
					$CCEmailID[] = $CCEmailIDArr[$i];
				}
			}
		}
	}
	if(!empty($connoate_number)){
		$bookingid = $connoate_number;
	}else {
		$bookingid = generatebookigid("",$bookingid);
	}
	
	$content = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
				<html xmlns="http://www.w3.org/1999/xhtml">
				<head>
					<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
					<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
					<title>Your Message Subject or Title</title>
					<style type="text/css">#outlook a {padding:0;}
						body{width:100% !important; -webkit-text-size-adjust:100%; -ms-text-size-adjust:100%; margin:0; padding:0;}
						.ExternalClass {width:100%;}
						.ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div {line-height: 100%;}
						#backgroundTable {margin:0; padding:0; width:100% !important; line-height: 100% !important;}
						img {outline:none; text-decoration:none; -ms-interpolation-mode: bicubic;}
						a img {border:none;}
						.image_fix {display:block;}
						p {margin: 1em 0;}
						h1, h2, h3, h4, h5, h6 {color: #686868 !important; font-family: "Open Sans", sans-serif; font-weight: normal !important;}
						h1 a, h2 a, h3 a, h4 a, h5 a, h6 a {color: blue !important;}
						h1 a:active, h2 a:active,  h3 a:active, h4 a:active, h5 a:active, h6 a:active {
							color: red !important;
						 }
						h1 a:visited, h2 a:visited,  h3 a:visited, h4 a:visited, h5 a:visited, h6 a:visited {
							color: purple !important;
						}
						table td {border-collapse: collapse;}
						table { border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt; }
						a {color: #72c02c; text-decoration:none;}
						@media only screen and (max-device-width: 480px) {
							a[href^="tel"], a[href^="sms"] {
										text-decoration: none;
										color: black;
										pointer-events: none;
										cursor: default;
									}

							.mobile_link a[href^="tel"], .mobile_link a[href^="sms"] {
										text-decoration: default;
										color: orange !important;
										pointer-events: auto;
										cursor: default;
									}
						}
						@media only screen and (min-device-width: 768px) and (max-device-width: 1024px) {
							a[href^="tel"], a[href^="sms"] {
										text-decoration: none;
										color: blue;
										pointer-events: none;
										cursor: default;
									}

							.mobile_link a[href^="tel"], .mobile_link a[href^="sms"] {
										text-decoration: default;
										color: orange !important;
										pointer-events: auto;
										cursor: default;
									}
						}

						@media only screen and (-webkit-min-device-pixel-ratio: 2) {}
						@media only screen and (-webkit-device-pixel-ratio:.75){}
						@media only screen and (-webkit-device-pixel-ratio:1){}
						@media only screen and (-webkit-device-pixel-ratio:1.5){}
						.bg-light { 
							padding:10px 15px; 
							border-radius:3px;
							margin-bottom:10px; 
							background:#fcfcfc; 
							border:solid 1px #fcfcfc;
							}
						.bg-light:hover { 
							border:solid 1px #e5e5e5;
							}
						blockquote {
							padding: 0 0 0 15px;
							margin: 0 0 20px;
							border-left: 5px solid #eee;
							font-size: 17.5px;
							font-weight: 300;
							line-height: 1.25;
							}
						blockquote:hover {
							border-left: 5px solid #72c02c;
							}
						blockquote p {
							color: #555;
							font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;
							}
						.standard_font {
							padding: 0 0 0 15px;
							margin: 0 0 20px;
							font-size: 17.5px;
							font-weight: 300;
							line-height: 1.25;
							color: #555;
							font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;
							}
						.justy {
							text-align: justify;
							}
						.my_green {
							color: #72c02c;
							}
						.my_red {
							color:#F00;
							}
						.muted {
							color: #999;
							}
						.text-right {
							text-align:right;
							float:right;
							}
						.text-center {
							text-align:center;
							}
						.hr_dashed {
							background: transparent;
							color: transparent;
							border-left: none;
							border-right: none;
							border-top: none;
							border-bottom: 2px dashed #72c02c;
							}
						.footer {
							margin-top: 40px;
							padding: 20px 10px;
							background: #585f69;
							color: #dadada;
							}
						.footer h4, .footer h3 {
							color: #e4e4e4 !important;
							background: none;
							text-shadow: none;
							font-weight:lighter !important;
							}
						.copyright {
							font-size: 12px;
							padding: 5px 10px;
							background: #3e4753;
							border-top: solid 1px #777;
							color: #dadada;
							}
						address {
							display: block;
							margin-bottom: 20px;
							font-style:normal;
							line-height: 20px;
							color: #dadada;
							font-size: 13px;
							font-weight:lighter !important;
							}
						.social_googleplus {
							background: url(http://prioritycouriers.com.au/assets/img/icons/social/googleplus.png) no-repeat;
							width: 28px;
							height: 28px;
							display: block;
							}
						.social_googleplus:hover {
							background-position: 0px -38px;
							}
						.my_bigger_font {
							font-size: 16px;
							font-weight: 300;
							line-height: 1.25;
							}
					</style>
					<!--[if IEMobile 7]>
					<style type="text/css">

					</style>
					<![endif]-->

					<!-- ***********************************************
					****************************************************
					END MOBILE TARGETING
					****************************************************
					************************************************ -->

					<!--[if gte mso 9]>
					<style>
						/* Target Outlook 2007 and 2010 */
					</style>
					<![endif]-->
				</head>
				<body>
					<table cellpadding="0" cellspacing="0" border="0" id="backgroundTable">
					<tr>
						<td>
						<table cellpadding="0" cellspacing="0" border="0" align="center">
							<tr>
								<td width="800" valign="top" style="padding-left:20px;">
									<img src="http://prioritycouriers.com.au/assets/img/Logo/Priority_Couriers-Logo_header.png"/>
								</td>
							</tr>
							<tr>
								<td width="800" valign="top" height="20">
								</td>
							</tr>
						</table>
						<!--	Email Content	-->
							{$MAIN_CONTENT}
						<!--/End	Email Content	-->
						<table cellpadding="0" cellspacing="0" border="0" align="center">
        					<tr>
            					<td width="450" valign="top">
                				<h4 style="border-bottom: 2px solid #72c02c; font-size: 24.5px;">Got a question about your booking?</h4>
                				</td>
                				<td width="350" valign="top">
                				<h3 style="border-bottom: 1px dotted #e4e9f0; font-size: 24.5px; margin-right:30px;">&nbsp;</h3>	
                				</td>
            				</tr>
        				</table>
        				<table cellpadding="0" cellspacing="0" border="0" align="center">
        					<tr>
            					<td width="800" valign="top">
                				<p class="justy standard_font">Check our online help section for the most common answers at <a href="http://prioritycouriers/faq.php" title="Priority Couriers - FAQ">http://prioritycouriers/faq.php</a><br />.</p>
                				</td>
            				</tr>
        				</table>
                    	<table cellpadding="0" cellspacing="0" border="0" align="center">
							<tr>
								<td width="800" valign="top" class="footer">
									<table cellpadding="0" cellspacing="0" border="0" align="center">
										<tr>
											<td width="400" valign="top">
												<table cellpadding="0" cellspacing="0" border="0" align="center">
													<tr>
														<td width="200" valign="top">
														<h3 style="border-bottom: 2px solid #72c02c; font-size: 24.5px;">Stay Conected</h3>
														</td>
														<td width="150" valign="bottom">
														<h3 style="border-bottom: 1px dotted #e4e9f0; font-size: 24.5px; margin-right:30px;">&nbsp;</h3>
														</td>
														<td width="50" valign="bottom"></td>
													</tr>
												</table>
												<table cellpadding="0" cellspacing="0" border="0" align="center">
													<tr>
														<td width="28" valign="top">
															<a href="https://plus.google.com/101192730485013023140/about" target="_blank" data-original-title="Goole Plus" class="social_googleplus"></a>
														</td>
														<td width="372" valign="top"></td>
													</tr>
												</table>
											</td>
											<td width="400" valign="top">
												<table cellpadding="0" cellspacing="0" border="0" align="center">
													<tr>
														<td width="150" valign="top">
														<h3 style="border-bottom: 2px solid #72c02c; font-size: 24.5px;">Contact Us</h3>
														</td>
														<td width="200" valign="bottom">
														<h3 style="border-bottom: 1px dotted #e4e9f0; font-size: 24.5px; margin-right:30px;">&nbsp;</h3>
														</td>
														<td width="50" valign="bottom"></td>
													</tr>
												</table>
												<table cellpadding="0" cellspacing="0" border="0" align="center">
													<tr>
														<td width="400" valign="top">
															<address>
															Email: <a href="mailto:info@prioritycouriers.com.au" class="">info@prioritycouriers.com.au</a>
															 </address>
														</td>
													</tr>
												</table>
											</td>
										</tr>
									</table>	
								</td>
							</tr>
							<tr>
								<td width="800" valign="top" class="copyright">
									<p>&copy; 2014 Copyright Priority Couiriers. ALL Rights Reserved.&nbsp;&nbsp;&nbsp;<a href="http://prioritycouriers.com.au/cms.php?page=privacy-policy" title="Learn more about our Privacy Policy">Privacy Policy</a>&nbsp;&nbsp;<span class="my_green">|</span>&nbsp;&nbsp;<a href="http://prioritycouriers.com.au/cms.php?page=terms-conditions" title="Our Terms of Service">Terms of Service</a></p>
								</td>
							</tr>
						</table>
						</td>
					</tr>
					</table>
						</td>
					</tr>
					</table>
				</body>
				</html>';
	
	
	/*$EmailTemplate = str_replace('{$SITE_URL}', SITE_URL, $EmailTemplateFile);
	$EmailTemplate = str_replace('{$LOGO_IMG_PATH}', DIR_HTTP_SITE_LANGUAGE_IMAGES, $EmailTemplate);
	$EmailTemplate = str_replace('{$LOGO_IMG_PATH}', "<img border=0 src='".DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES."logo.gif' width='508px' height='75px'   /><br><br><br>", $EmailTemplate);
	if((!empty($EmailKey)) && ($EmailKey == "BOOKING_CONFIRMATION" || $EmailKey == "SIGNUP_REGISTRATION" )){
		$EmailTemplate = str_replace('{$BODY_CONTENT}',$ReplaceArray[1],$EmailTemplate);
	}else {
		$EmailTemplate = str_replace('{$BODY_CONTENT}',$EmailContent,$EmailTemplate);
	}
	//echo $EmailTemplate;exit;
	if(!empty($EmailKey) && $EmailKey == "BOOKING_CONFIRMATION"){
		$EmailTemplate = str_replace('{$booking_date}',$booking_date,$EmailTemplate);
		$EmailTemplate = str_replace('{$booking_id}',$bookingid,$EmailTemplate);
		$EmailTemplate = str_replace('{$LINK_USER_ACCOUNT}',$myaccount_link,$EmailTemplate);
		$EmailTemplate = str_replace('{$LINK_USER_BOOKING_ID}',$bookingid,$EmailTemplate);
	}*/
	$EmailTemplate = str_replace('{$MAIN_CONTENT}',$EmailContent,$content);
	$EmailTemplateFile = $EmailContent;
	
	//$EmailTemplate = str_replace('{$booking_date}',$booking_date,$EmailTemplate);
	
	//echo $EmailContent; die('test die');
	$toEmailIDArr = array();
	
	if($toEmailID != "") {
		$toEmailIDArr = explode(",",$toEmailID);
	}
	else {
		return false;
	}
	/*$EmailTemplate = '<style type="text/css"> 
				ul{
					list-style-type:none;
				}
			</style>'.*/
	//echo $EmailTemplate;
	
	/*echo "<pre>";
	print_r($EmailTemplate);
	echo "</pre>";
	exit();*/
	//$toEmailID = 'info@'
	if(is_array($toEmailIDArr)) {
		while(list($key,$ToEmail) = each($toEmailIDArr)) {
			$MailSend = $preferencesObj->SendMail($EmailSubject,$fromEmailId,$ToEmail,$CCEmailID,$BCCEmailID,'HTML',$EmailTemplate,$attachment,'');
			
		}
	}


	return $MailSend;
}
function Send_Existing_User_Mail($siteobj)
{
	$Email_Key = "EXISTING_EMAIL_ID_TRY";
	$privacy_link = '';
	/**
	 * assign values to the variables which are used in template.
	 */
	
	$findVar = array();		
	$findVar[]= '{$customername}';
	

	
	$assignVar  = array();		
	$assignVar[] = $siteobj->firstname;
	
	$toEmail = $siteobj->email;

	SendMailContent($toEmail,$Email_Key,$findVar,$assignVar);
}
function Send_Existing_User_Mail_To_Admin()
{
	require_once(DIR_WS_MODEL . "CountryMaster.php");
	
	//$quest_arr = array("1"=>"What was your childhood nickname?","2"=>"What is the name of your favorite childhood friend?","3"=>"What is your mother's maiden name?","4"=>"In what city or town was your first job?","5"=>"What is your boss's name?");
	$quest_arr = array("1"=>"Mother's middle name?","2"=>"First street you grew up in?","3"=>"Favourite teacher's name?","4"=>"First company you worked for?","5"=>"First manager's name?");
	if(!empty($_POST['country']))
	{
		
		$countrySeaArr[] = array('Search_On'=>'countries_id', 'Search_Value'=>$_POST['country'], 'Type'=>'string', 'Equation'=>'=', 'CondType'=>'AND', 'Prefix'=>'','Postfix'=>'');
		$fieldArr = array('countries_name');
		$CountryMasterObj  = CountryMaster::Create();
		$allCountry = $CountryMasterObj->getCountry($fieldArr,$countrySeaArr);
		$allCountry = $allCountry[0];
		$country_name =  $allCountry['countries_name'];
	}
	
	if(!empty($quest_arr))
	{		
		foreach($quest_arr as $key => $val)
		{
			if($key == $_POST['security_ques'])
			{
				$question = $val;
			}
		}
	}
	
	$Email_Key = "EXISTING_EMAIL_ID_TRY_BY_USER";
	$privacy_link = '';
	/**
	 * assign values to the variables which are used in template.
	 */
	
	$findVar = array();		
	$findVar[]= '{$firstname}';
	$findVar[]= '{$lastname}';
	$findVar[]= '{$company}';
	$findVar[]= '{$address1}';
	$findVar[]= '{$address2}';
	$findVar[]= '{$address3}';
	$findVar[]= '{$country_name}';
	$findVar[]= '{$suburb}';
	$findVar[]= '{$state}';
	$findVar[]= '{$postcode}';
	$findVar[]= '{$sender_area_code}';
	$findVar[]= '{$phone}';
	$findVar[]= '{$sender_mb_area_code}';
	$findVar[]= '{$mobile_phone}';
	$findVar[]= '{$facsimile_no}';
	$findVar[]= '{$email}';
	$findVar[]= '{$question}';
	$findVar[]= '{$security_ans}';
	$findVar[]= '{$ipaddress}';
	
	
	
	$assignVar  = array();		
	$assignVar[] = $_POST['firstname'];
	$assignVar[] = $_POST['lastname'];
	$assignVar[] = $_POST['company_reg'];
	$assignVar[] = $_POST['address1'];
	$assignVar[] = $_POST['address2'];
	$assignVar[] = $_POST['address3'];
	$assignVar[] = $country_name;
	$assignVar[] = $_POST['suburb'];
	$assignVar[] = $_POST['state'];
	$assignVar[] = $_POST['postcode'];
	$assignVar[] = $_POST['sender_area_code'];
	$assignVar[] = $_POST['phone'];
	$assignVar[] = $_POST['sender_mb_area_code'];
	$assignVar[] = $_POST['mobile_phone'];
	$assignVar[] = $_POST['facsimile_no'];
	$assignVar[] = $_POST['email'];
	$assignVar[] = $question;
	$assignVar[] = $_POST['security_ans'];
	//$assignVar[] = $_SERVER['REMOTE_ADDR'];
	$assignVar[] = $_SERVER['HTTP_X_FORWARDED_FOR'];
	
	$toEmail = 'admin@prioritycouriers.com.au';

	SendMailContent($toEmail,$Email_Key,$findVar,$assignVar);
}
/**
 * While user registration this function is used
 *
 */
function Send_New_User_Registration_Mail($siteobj)
{
	$Email_Key = "SIGNUP_REGISTRATION";
	$privacy_link = '';
	/**
	 * assign values to the variables which are used in template.
	 */
	
		$findVar = array();		
		$findVar[]= '{$customername}';
		//$findVar[]= '{$password}';
		//$findVar[]= '{$customeremail}';
		$findVar[]= '{$link}';

		
		$assignVar  = array();		
		$assignVar[] = $siteobj->firstname;
		//$assignVar[] = $siteobj->password;
		//$assignVar[] = $siteobj->email;
		//$id = generateEncodedId($siteobj->userid);
		//define("KEY", "\xc8\xd9\xb9\x06\xd9\xe8\xc9\xd2"); 
		define("KEY", "\xa8\xd9\xe9\x07\xe9\xe2\xd9\xd4"); 
	    //$id = encrypt($UserDetails['userid'],KEY);
	    $id = $UserDetails['userid'];
		//$assignVar[] = ft_create_nonce_one_time('chg_pass',$siteobj->userid);
		//echo $siteobj['password'];
		//exit();
		
		
		$toEmail = $siteobj->email;
	
		SendMailContent($toEmail,$Email_Key,$findVar,$assignVar);
}
// (check complete)

/**
 * This Function is executed when the change password is done from front side
 *
 */
function Change_Password($userDetails=null)
{
	$Email_Key = "PASSWORD_CHANGE";
	
		$findVar = array();		
		$findVar[]= '{$customername}';
		$findVar[]= '{$newpassword}';
		
		$assignVar  = array();		
		$assignVar[] = $userDetails['firstname'];
		$assignVar[] = $userDetails['password'];
	
		$toEmail = $userDetails['email'];
	
	SendMailContent($toEmail,$Email_Key,$findVar,$assignVar);
		
	
}
// Change Password Function End (check complete)

/**
 * This Function is executed when the contactus form is submitted
 */
function Enquiry_Mail($FullName='',$UserId='', $EmailAddress='',$EnquiryNo='',$Enquiry=''){
   $Email_Key = "CONTACT_US_ADMIN";
	
		$findVar = array();
		$findVar[] = '{$customername}';
		$findVar[] = '{$emailid}';
		$findVar[] = '{$comments}';
		$findVar[] = '{$userid}';
		$assignVar  = array();		
		$assignVar[] = $FullName;
		$assignVar[] = $EmailAddress;
		$assignVar[] = $EnquiryNo;
		//$assignVar[] = $Enquiry;
		if(empty($UserId))
		{
			$UserId = 'One off User';
		}
		$assignVar[] = $UserId;
	
		$toEmail = SITE_FROM_EMAIL_ID;
	
	SendMailContent($toEmail,$Email_Key,$findVar,$assignVar);
}
// End of the Enquiry Mail Functions (check complete)


function Enquiry_Mail_Client($FullName='',$EmailAddress='',$pagename=''){
	if($pagename=="feedback")
	{
		$Email_Key = "FEEDBACK_USER";
	}
	else 
	{
   		$Email_Key = "CONTACT_US_USER";
	}
	
		$findVar = array();
		$findVar[] = '{$customername}';
		$assignVar  = array();
		$assignVar[] = $FullName;
		$toEmail = $EmailAddress;
	
	SendMailContent($toEmail,$Email_Key,$findVar,$assignVar);
}
// End of the Enquiry Mail Functions (check complete)


/**
 * This Function is executed when the feedback form is submitted
 */
function Feedback_Mail($FullName='', $EmailAddress='',$Enquiry=''){
	   $Email_Key = "FEEDBACK_ADMIN";
	
		$findVar = array();
		$findVar[]= '{$customername}';
		$findVar[]= '{$emailid}';
		$findVar[]= '{$comments}';
		
		$assignVar  = array();		
		$assignVar[] = $FullName;
		$assignVar[] = $EmailAddress;
		$assignVar[] = $Enquiry;
	
		$toEmail = SITE_FROM_EMAIL_ID;
//	$toEmail= "parag.kuhikar@radixweb.com";	
	SendMailContent($toEmail,$Email_Key,$findVar,$assignVar);
}
//End of feedback mail

/*
* Starting of feedback mail client
*/

function Feedback_Mail_Client($FullName='',$EmailAddress=''){
   $Email_Key = "FEEDBACK_USER";
	
		$findVar = array();
		$findVar[]= '{$customername}';
		
		$assignVar  = array();
		$assignVar[] = $FullName;
		$toEmail = $EmailAddress;
	
	SendMailContent($toEmail,$Email_Key,$findVar,$assignVar);
}
// End of the feedback mail client Functions (check complete)




/**
 * This Function is executed when the Free Sample form is submitted and sen mail to client
 */
function Free_Quote_Admin($freeQuoteData=array()){
  		$Email_Key = "FREE_QUOTE_ADMIN";
	
		$findVar = array();
		$findVar[]= '{$name}';
		$findVar[]= '{$phone}';
		$findVar[]= '{$email}';
		$findVar[]= '{$enquiry}';
		
		$assignVar  = array();		
		$assignVar[] = $freeQuoteData["name"];
		$assignVar[] = $freeQuoteData["phone"];
		$assignVar[] = $freeQuoteData["email"];
		$assignVar[] = $freeQuoteData["enquiry"];
		$toEmail = SITE_FROM_EMAIL_ID;
	
	SendMailContent($toEmail,$Email_Key,$findVar,$assignVar);
}

// End of the Free Sample  Functions


/**
 * This Function is executed when Free Sample at front side
 *
 */
function Free_Quote_User($freeQuoteData=array())
{
	$Email_Key = "FREE_QUOTE_USER";
	
	$findVar = array();		
	$findVar[]= '{$customername}';

	
	$assignVar  = array();		
	$assignVar[] = $freeQuoteData["name"];
	
	$toEmail = $freeQuoteData['email'];
	$FromEmail = $freeQuoteData['from_email'];
	
	SendMailContent($toEmail,$Email_Key,$findVar,$assignVar,'','',$FromEmail);
}
// End of Free Sample


/**
 * This Function is executed when the Free Sample form is submitted and sen mail to client
 */
function Custom_Quote_Admin($customQuoteData=array()){
  		$Email_Key = "CUSTOM_QUOTE_ADMIN";
	
		$findVar = array();
		$findVar[]= '{$name}';
		$findVar[]= '{$company}';
		$findVar[]= '{$street}';
		$findVar[]= '{$city}';	
		$findVar[]= '{$state}';
		$findVar[]= '{$zip}';
		$findVar[]= '{$phone}';
		$findVar[]= '{$ext}';
		$findVar[]= '{$email}';
		$findVar[]= '{$projectDetails}';
		
		$assignVar  = array();		
		$assignVar[] = $customQuoteData["name"];
		$assignVar[] = $customQuoteData["company"];
		$assignVar[] = $customQuoteData["street"];
		$assignVar[] = $customQuoteData["city"];		
		$assignVar[] = $customQuoteData["state"];
		$assignVar[] = $customQuoteData["zip"];
		$assignVar[] = $customQuoteData["phone"];
		$assignVar[] = $customQuoteData["ext"];
		$assignVar[] = $customQuoteData["email"];
		$assignVar[] = $customQuoteData["projectDetails"];
	
		$toEmail = SITE_FROM_EMAIL_ID;
	
	SendMailContent($toEmail,$Email_Key,$findVar,$assignVar);
}

// End of the Free Sample  Functions


/**
 * This Function is executed when Free Sample at front side
 *
 */
function Custom_Quote_User($customQuoteData=array())
{
	$Email_Key = "CUSTOM_QUOTE_USER";
	
	$findVar = array();		
	$findVar[]= '{$customername}';

	
	$assignVar  = array();		
	$assignVar[] = $customQuoteData["name"];
	
	$toEmail = $customQuoteData['email'];
	
	SendMailContent($toEmail,$Email_Key,$findVar,$assignVar);
}
// End of Free Sample


/**
 * This Function is executed when user forgot password at front side
 *
 */
function Forgot_Password($UserDetails=null,$new_pwd =null)
{
	$Email_Key = "FORGOT_PASSWORD";
	$findVar = array();		
	$findVar[]= '{$customername}';
	$findVar[]= '{$ipaddress}';
	
	$findVar[]= '{$link}';
	define('FT_NONCE_DURATION',100);
	$assignVar  = array();		
	$assignVar[] = $UserDetails['firstname'];
	define("KEY", "\xa8\xd9\xe9\x07\xe9\xe2\xd9\xd4"); 
	//$id = encrypt($UserDetails['userid'],KEY);
	$id = $UserDetails['userid'];
	$assignVar[] = $_SERVER['HTTP_X_FORWARDED_FOR'];//IP is pass from proxy Nginx
	$assignVar[] = ft_create_nonce_one_time('chg_pass',$UserDetails['userid']);
	
	$toEmail = $UserDetails['email'];
	SendMailContent($toEmail,$Email_Key,$findVar,$assignVar);
}
// End of Forgot Password(check complete)

/**
 * This Function is executed when user subscribes
 *
 */
function newsletter_subscription($email)
{
	$Email_Key = "NEWSLETTER_SUBSCRIPTION";
	
	$findVar = array();		
	$findVar[]= '{$email}';
	
	
	$assignVar  = array();		
	$assignVar[] = $email;
	
	
	$toEmail = $email;
	
	SendMailContent($toEmail,$Email_Key,$findVar,$assignVar);
}
// End of newsletter(check complete)


function Send_Information_To_Friend_Mail($UserMail,$ToMail,$subject,$messageOfMail) 
{
	$Email_Key = "TELL_FRIEND";
	
	$findVar = array();		
	$findVar[]= '{$sendermail}';
	$findVar[]= '{$MESSEGE}';
	
	
	
	$assignVar  = array();
	$assignVar[] = $UserMail;		
	$assignVar[] = $messageOfMail;
	
		
	SendMailContent($ToMail,$Email_Key,$findVar,$assignVar);
}


/** 
 * USED IN FRONT END AFTER COMPLETION OF THE ORDER
 * @param unknown_type $OrderDetails
 * @param unknown_type $PaymentDetails
 * @param unknown_type $insertedOrdId
 * @param unknown_type $PaymentMethod
 */
function Order_Completion_Front($OrderDetails=null,$insertedOrdId=null,$Shipping_Address,$Billing_Address,$paymentdetails,$basket_arr,$paymentInformation) {

		$ObjProductMaster = ProductsMaster::Create();
		$PaypalinfoMasterObj       = PaypalinfoMaster::Create();
		$PreferencesObj     = new Preferences();
		
		$orderDetailsLink = SITE_URL.FILE_ORDERS_DETAILS."?OrderId=".$insertedOrdId;
		$ord_Date = $PreferencesObj->SetDateFormat($OrderDetails->orders_date_finished,"F d, Y"); // Get Order Date 
		
		$shipppingDetails ="<table  border='0'  width='100%' cellpadding='0' cellspacing='0'>
								<tr >
									<td valign='top'>".									
									getAddressDetailsTable($Shipping_Address)."
									</td>
								</tr>								
							</table>";
		$billingDetails ="<table  border='0'  width='100%' cellpadding='0' cellspacing='0'>
								<tr >
									<td valign='top'>".									
									getAddressDetailsTable($Billing_Address)."
									</td>
								</tr>								
							</table>";
		
		
			
			$paymentdetails= "<table  border='0'  width='100%' cellpadding='0' cellspacing='0'>
								<tr >
									<td valign='top'>									
									<div>
									<div>".$paymentdetails."</div>
									</div>
									</td>
								</tr>								
							</table>";
			
		
		
		// ******************************* This part get the Cart details ****************************//
			
			$Mail_Messege="<table  border='0'  width='100%' cellpadding='0' cellspacing='0'>
						<tr>
						    <td align='left width='35%' class='cart_heading' style='padding-left:5px;'><strong>".COMMON_PRODUCTS."</strong></td>
							<td align='left' width='35%' class='cart_heading'><strong>".COMMON_ADD_INFORMATION."</strong></td>
							<td align='center' width='15%' class='cart_heading'><strong>".COMMON_QUANTITY."</strong></td>
							<td align='right' width='15%' class='cart_heading' style='padding-right:5px;'><strong>".COMMON_PRICE."</strong></td>
						</tr>";
			foreach ($basket_arr as $pos => $basket) {
				if(isset($basket['features_details']) && isset($basket['products_title'])) {	// Order Product Table Additional Information Details
					$arr_additional_info = json_decode($basket['features_details'],true);
					$product_title = $basket['products_title'];
					$design_name = $basket['products_name'];
					$price = $basket['products_price'];
				} else {
					$arr_additional_info = $basket['additional_info'];
					$product_title = $basket['product_title'];
					$design_name = $basket['design_name'];
					$price = $basket['price'];
				}
				$cnaddtionalinfo = count($arr_additional_info);
				
				$Mail_Messege .= "<tr>				
				<td align='left' valign='top' >".$product_title."<br />";
				$Mail_Messege .= ucfirst($design_name);				
				$Mail_Messege .= "</td><td align='left' valign='top'>";
				if(!empty($arr_additional_info)) {
									$Mail_Messege .= PRODUCT_ADDITONAL_OPT_LABEL;
									$Mail_Messege .= "<OL>";
									$htmlfeaturedPrice = '<ul>';
									foreach ($arr_additional_info as $addOption) {
										$Mail_Messege .= "<li>".$addOption['Heading'] ." : " .$addOption['AttributeValue']."</li>";
										$option_price = '&nbsp;';
										if(!empty($addOption['option_price'])) {
											$option_price = currency_format($addOption['option_price']);
											$htmlfeaturedPrice .= "<li>".$option_price."</li>";
										}
										
									}
									$htmlfeaturedPrice .= '</ul>';
									$Mail_Messege .= "</OL>";
									
								} else { /*loop for additional option ends here*/
									$Mail_Messege .="---------";
								}
				
				
				$Mail_Messege .= "</td>
							<td align='center' valign='top'>".$basket['quantity']."</td>
							<td align='right' valign='top'>".currency_format($price).$htmlfeaturedPrice."</td>
						</tr>"; 
			}
				
			$Mail_Messege .= "</table>";
			
		// ******************************* End of Cart details ****************************//
		
		// ******************************* Calculation of Prices ****************************//
		
			$order_amount =currency_format($paymentInformation->order_ammount);
			$shipping_amount =currency_format($paymentInformation->shipping_ammount);
			$city_tax_amount =currency_format($paymentInformation->city_tax_amount);
			$total_amount =currency_format($paymentInformation->total_ammount);
			$transaction_id = $paymentInformation->transactionid;
			if($transaction_id != ''){
				$transactionId = $transaction_id;
			}else{
				$transactionId = '---------';
			}
					
			$shipping_type =$OrderDetails->shipping_type_name;
			
			
		// ******************************* End of Calculation of Prices ****************************//
		
		//********************Paypal Info***********************************//
			 /*$searcharr[]   = array();
			 $searcharr[]   = array('Search_On'=>'orderid','Search_Value'=>$insertedOrdId,'Type'=>'int','Equation'=>'=','CondType'=>'AND','Prefix'=>'','Postfix'=>'');
		     $payPalDetails = $PaypalinfoMasterObj->getPaymentDetails(null,$searcharr);
		     $payPalDetails = $payPalDetails[0];
		     $transactionId = $payPalDetails['txn_id'];
			 $Paypal_amount = $payPalDetails['payment_gross'];*/
		
		
	$Email_Key = "ORDER_CONFIRMATION";
	$findVar = array();	
	
	$findVar[]= '{$orderdate}';
	$findVar[]= '{$customername}';
	$findVar[]= '{$orderid}';	
	$findVar[]= '{$shipping_type}';	
	$findVar[]= '{$shippingAddress}';
	$findVar[]= '{$billingAddress}';
	$findVar[]= '{$paymentMethod}';
	$findVar[]= '{$card_details}';
	$findVar[]= '{$subtotal}';
	$findVar[]= '{$shippingcharge}';
	$findVar[]= '{$tax_amount}';
	$findVar[]= '{$total_amount}';
	$findVar[]= '{$paymentDate}';	
	$findVar[]= '{$user_orderdetails_link}';
	$findVar[]= '{$transactionId}';
	$findVar[]= '{$payment_amount}';
	
	
	$assignVar  = array();	
	$assignVar[] = $ord_Date;
	$assignVar[] = $OrderDetails->customers_name;
	$assignVar[] = $insertedOrdId;	
	$assignVar[] = $shipping_type;
	$assignVar[] = $shipppingDetails;
	$assignVar[] = $billingDetails;
	$assignVar[] = $paymentdetails;
	$assignVar[] = $Mail_Messege;
	$assignVar[] = $order_amount;
	$assignVar[] = $shipping_amount;
	$assignVar[] = $city_tax_amount;
	$assignVar[] = $total_amount;
	$assignVar[] = $Pay_Date;	
	/*$assignVar[] = $orderHistory;*/
	$assignVar[] = $orderDetailsLink;
	$assignVar[] = $transactionId;
	$assignVar[] = $total_amount;
	
	
	
	$toEmail = $OrderDetails->customers_email_address;
	
	SendMailContent($toEmail,$Email_Key,$findVar,$assignVar);
}
	
/**
 * This function is executed when user make order may be online or through cheque (ADMIN)
 *
 * @param object $OrderDetails
 * @param object $PaymentDetails
 * @param object $OrderProductDetails
 * @param int 	 $insertedOrdId
 * @param int 	 $OrderStatus1
 * @param string $processstatus
 * @param string $processstatusmessage
 */

function Order_Completion($OrderDetails=null,$OrderProductDetails=null,$insertedOrdId=null,$OrderStatus1=null,$processstatus=null,$processstatusmessage=null, $comment, $languageId=SITE_LANGUAGE_ID)
{
	$ObjProductMaster   = ProductsMaster::Create();
	$PreferencesObj     = new Preferences();
	$i=1;
	if($OrderProductDetails != ''){
		foreach ($OrderProductDetails as $List){
		/**
		 * For fetching product name
		 */
		$CardType=$List->products_title;
		 $ProductNew .= "<table cellspacing='0' cellpadding='0' border='0' width='100%'>
		 <tr><td>".$List->products_name."</td></tr>
		 <tr><td>".$List->products_quantity."&nbsp;X&nbsp;".$CardType."&nbsp;[".$List->productsize."]".$OtherFeature."</td></tr>
		 <tr><td height='10'></td></tr>
		 </table>";
		 $i = $i+1;
		} 
	}
	
	
	if($OrderDetails->airway_bill_number != '' && $OrderDetails->courirer_company_name != '') {
	
		$Mail_Messege="<table  border='0'  width='100%' cellpadding='0' cellspacing='0'>
						<tr>
						    <td align='left'>Your Order has been shipped through ".$OrderDetails->courirer_company_name." and tracking number is " .$OrderDetails->airway_bill_number."</td>
						</tr>
					   </table>";
	}
	 if($OrderStatus1 != "")
	 {
		$Name=$OrderDetails->delivery_name;
		$street_add=$OrderDetails->delivery_street_address;
		$Suburb=$OrderDetails->delivery_suburb;
		$city=$OrderDetails->delivery_city;
		$postcode=$OrderDetails->delivery_postcode;
		$state=$OrderDetails->delivery_state;
		$country=$OrderDetails->delivery_country;
	 }
	
	 $status=$processstatus[$OrderStatus1];	
						
					
					
	$Email_Key = "ORDER_PROCEDINGS";
	$findVar = array();		
	$findVar[]= '{$customername}';
	$findVar[]= '{$orderid}';
	$findVar[]= '{$paymentStatusDeatils}';
	$findVar[]= '{$shippingdetails}';
	$findVar[]= '{$orderDetails}';
	$findVar[]= '{$comments}';
	
	
	$assignVar  = array();		
	$assignVar[] = $OrderDetails->customers_name;
	$assignVar[] = $insertedOrdId;
	$assignVar[] = $status;
	$assignVar[] = $Mail_Messege;
	$assignVar[] = $ProductNew;
	$assignVar[] = $comment;
	
	
	$toEmail = $OrderDetails->customers_email_address;
	
	//SendMailContent($toEmail,$Email_Key,$findVar,$assignVar,null, null, $languageId=SITE_LANGUAGE_ID);
	SendMailContent($toEmail,$Email_Key,$findVar,$assignVar);
}
function postcode_not_present($pickup,$deliver)
{
	$Mail_message='<!-- Content Starts Here -->
        				<table cellpadding="0" cellspacing="0" border="0" align="center">
            <tr>
				<td width="800" valign="top" style="padding: 10px 0 6px; box-shadow: inset 0 0 4px #eee; background: url(http://prioritycouriers.com.au/assets/img/breadcrumbs.png) repeat;">
                	<h1 class="pull-left" style="font-size: 30px; text-shadow: 0 1px 0 #f1efef; padding-left:20px;">Rates are not available</h1>
               	</td>
			</tr>
            <tr>
            	<td width="800" valign="top" height="20">
                </td>
            </tr>
            <tr>
            	<td width="800" valign="top" class="bg-light">
                    <table cellpadding="0" cellspacing="0" border="0" align="center">
                        <tr>
                            <td width="800" valign="top" style="padding-left:20px;">
                            	<blockquote>
                                	<p class="justy">The rates are not available for these postcodes: <span class="my_green">'.$pickup.'</span>, <span class="my_green">'.$deliver.'</span>.</p>
                                </blockquote>
                            </td>
                        </tr>
                 	</table>
            	</td>
          	</tr>
		</table>';
	$toEmail = 'admin@prioritycouriers.com.au';
	$Email_Key = "RATES_NOT_AVAILABLE";
	$findVar = array();		
	$findVar[]= '{$mailmessage}';
	$assignVar  = array();
	$assignVar[] = $Mail_message;
	SendMailContent($toEmail,$Email_Key,$findVar,$assignVar,"","","",$attachmentVar);
	
}
function Booking_Confirmation($bookingid,$cardnumber,$service_name_code=null,$auto_id=null)
{
	global $__Session;
	$BookingDetailsMasterObj = BookingDetailsMaster::create();
	$BookingDetailsDataObj = new BookingDetailsData();
	$CountryMasterObj = CountryMaster::create();
	$CountryDataObj = new CountryData();
	//This variables $ObjBookingDisDetMaster and $ObjBookingDiscountData value assigned  by shailesh jamanapara Mon Jun 10 13:57:10 IST 2013
	
	$ObjBookingDisDetMaster		=BookingDiscountDetailsMaster::create();
	$ObjBookingDiscountData		=new BookingDiscountDetailsData();
	
	
	$InternationalZoneMasterObj= InternationalZonesMaster::create();
	$InternationalZoneData = new InternationalZonesData();
	$cardnumber=substr($cardnumber, 12, 4);
	$cardnumber="************".$cardnumber;
	$Email_Key = "BOOKING_CONFIRMATION";
	$findVar = array();		
	$findVar[]= '{$customername}';
	$findVar[]= '{$mailmessage}';
	$fieldArr = array();
	$seaArr[0] = array('Search_On'    => 'booking_id',
	                      'Search_Value' => $bookingid,
	                      'Type'         => 'string',
	                      'Equation'     => '=',
	                      'CondType'     => 'and',
	                      'Prefix'       => '',
	                      'Postfix'      => ''); 
	$fieldArr = array("*");
	
	$BookingDetailsDataObj = $BookingDetailsMasterObj->getBookingDetails($fieldArr,$seaArr);
	$BookingDetailsData = $BookingDetailsDataObj[0];
	$tamount = $BookingDetailsData['rate'];
	//$setid = $BookingDetailsData['auto_id'];
	
	$fieldDiscArr = array("*");
	$seaDiscArr = array();
	$seaDiscArr[0] = array('Search_On'    => 'booking_id',
	                      'Search_Value' => $bookingid,
	                      'Type'         => 'int',
	                      'Equation'     => '=',
	                      'CondType'     => 'and',
	                      'Prefix'       => '',
	                      'Postfix'      => '');
	$ObjBookingDiscountData = $ObjBookingDisDetMaster->getBookingDiscountDetails($fieldDiscArr, $seaDiscArr);
	$ObjBookingDiscountData = $ObjBookingDiscountData[0];
	
	/*$tamount = ceil($BookingDetailsData[$BookingDetailsData['service_name'].'_rate'])+get_payment_due();*/
	 
	 
	 
	//$contry_name = $BookingDetailsData['deliveryid'];
	$contry_name = 'Australia';
	$fieldArrforCountryName  = array('countries_name');
	/* these two values below are when postcode are selected from australia */
	$receiver_suburb = ucwords($BookingDetailsData["reciever_suburb"]);
	$sender_suburb = ucwords($BookingDetailsData["sender_suburb"]);
	if(is_numeric($BookingDetailsData['deliveryid'])){
		$countries_id = $BookingDetailsData['deliveryid'];
		$seabycountryArr[0] = array('Search_On'    => 'countries_id',
							  'Search_Value' => $countries_id,
							  'Type'         => 'string',
							  'Equation'     => 'LIKE',
							  'CondType'     => 'and ',
							  'Prefix'       => '',
							  'Postfix'      => ''); 
		$CountryDataObj = $CountryMasterObj->getCountry($fieldArrforCountryName,$seabycountryArr);
		$CountryDataObj = $CountryDataObj[0];
		$contry_name = $CountryDataObj['countries_name'];
		$receiver_suburb = ucwords($BookingDetailsData["reciever_suburb"]).", ".$contry_name;
		$sender_suburb = ucwords($BookingDetailsData["sender_suburb"]).", Australia";
	}
	
	$commercial_invoice = $BookingDetailsData['commercial_invoice'];
	$connoate_number = $BookingDetailsData['CCConnote'];
	
	
	$courier_name = $BookingDetailsData['webservice'];
	$Mail_message='<!-- Content Starts Here -->
        				<table cellpadding="0" cellspacing="0" border="0" align="center">
							<tr>
								<td width="800" valign="top" style="padding: 10px 0 6px; box-shadow: inset 0 0 4px #eee; background: url(http://prioritycouriers.com.au/assets/img/breadcrumbs.png) repeat;">
									<h1 class="pull-left" style="font-size: 30px; text-shadow: 0 1px 0 #f1efef; padding-left:20px;">Your Booking Summary</h1>
								</td>
							</tr>
							<tr>
								<td width="800" valign="top" height="20">
								</td>
							</tr>
							<tr>
								<td width="800" valign="top" class="bg-light">
									<table cellpadding="0" cellspacing="0" border="0" align="center">
										<tr>
											<td width="300" valign="top" style="padding-left:20px;">
												<h3 style="border-bottom: 2px solid #72c02c; font-size: 24.5px;"></h3>
											</td>
											<td width="500" valign="top">
												<h3 style="border-bottom: 1px dotted #e4e9f0; font-size: 24.5px;">&nbsp;</h3>
											</td>
										</tr>
									</table>
									<table cellpadding="0" cellspacing="0" border="0" align="center">
										<tr>
											<td width="800" valign="top" style="padding-left:20px;">
												<blockquote>
													<p class="justy">We are happy to inform you that your booking was successful. Your tracking number is <span class="my_green">'.$connoate_number.'</span>. Attached are your consignment note and receipt.</p>
												</blockquote>
											</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td width="800" valign="top">
									<table cellpadding="0" cellspacing="0" border="0" align="center">
										<tr>
											<td width="800" valign="top" height="20">
											</td>
										</tr>
										
									</table>
									<table cellpadding="0" cellspacing="0" border="0" align="center">
										<tr>
											<td width="100" valign="top"></td>
											<td width="600" valign="top" class="bg-light">
												<table cellpadding="0" cellspacing="0" border="0" align="center">
													<tr>
														<td width="300" valign="top" class="muted">Tracking Number:</td>
														<td width="300" valign="top" class="my_green text-right">'.$connoate_number.'</td>
													</tr>
													
													<tr>
														<td width="300" valign="top" class="muted">Ready for collection: </td>
														<td width="300" valign="top" class="my_green text-right">'. $BookingDetailsData["date_ready"].'</td>
													</tr>
													<tr>
														<td width="300" valign="top" class="muted">Weight:</td>
														<td width="300" valign="top" class="my_green text-right">'. $BookingDetailsData["chargeable_weight"].'Kg</td>
													</tr>
													<tr>
														<td width="300" valign="top" class="muted">Courier Name:</td>
														<td width="300" valign="top" class="my_green text-right">'.$courier_name.'</td>
													</tr>
													<tr>
														<td width="300" valign="top" class="muted">Service Type:</td>
														<td width="300" valign="top" class="my_green text-right">'.ucwords($BookingDetailsData["service_name"]).'</td>
													</tr>
													<tr>
														<td width="300" valign="top" class="muted">Quantity:</td>
														<td width="300" valign="top" class="my_green text-right">'.$BookingDetailsData["total_qty"].'</td>
													</tr>
													<tr>
														<td width="300" valign="top" class="muted">Sender:</td>
														<td width="300" valign="top" class="my_green text-right">'.$BookingDetailsData["sender_first_name"].' '.$BookingDetailsData["sender_surname"].'</td>
													</tr>
													<tr>
														<td width="300" valign="top" class="muted">Receiver:</td>
														<td width="300" valign="top" class="my_green text-right">'.$BookingDetailsData["reciever_firstname"].' '.$BookingDetailsData["reciever_surname"].'</td>
													</tr>

													<tr>
														<td width="300" valign="top" class="muted">Pickup Location:</td>
														<td width="300" valign="top" class="my_green text-right">'.$sender_suburb.'</td>
													</tr>
													<tr>
														<td width="300" valign="top" class="muted">Delivery Location:</td>
														<td width="300" valign="top" class="my_green text-right">'.$receiver_suburb.'</td>
													</tr>
												</table>
												<table cellpadding="0" cellspacing="0" border="0" align="center">
													<tr>
														<td width="600" valign="top" class="hr_dashed">&nbsp;</td>
													</tr>
													<tr>
														<td width="600" valign="top" height="10"></td>
													</tr>
												</table>
												<table cellpadding="0" cellspacing="0" border="0" align="center">
													<tr>
														<td width="300" valign="top" class="muted">GST:</td>
														<td width="300" valign="top" class="my_green text-right">$'.number_format($BookingDetailsData['gst_surcharge'], 2, '.', '').'</td>
													</tr>
													<tr>
														<td width="300" valign="top" class="muted">Amount Paid (includes GST):</td>
														<td width="300" valign="top" class="my_green text-right">$'.number_format($BookingDetailsData['rate'], 2, '.', '').'</td>
													</tr>
												</table>     
											</td>
											<td width="100" valign="top"></td>
										</tr>
									</table>
								</td>
							</tr>
							
							<tr>
								<td width="800" valign="top" height="20">
								</td>
							</tr>
						</table><!--/End Content Ends Here -->';
	
	$service_name = $BookingDetailsData['service_name'];
	$assignVar  = array();		
	
	$assignVar[] = $BookingDetailsData['sender_first_name'];
	$assignVar[] = $Mail_message;
	if($BookingDetailsData['payment_email']!="")
	{
	    $toEmail = $BookingDetailsData['sender_email'].",".$BookingDetailsData['payment_email'];
	}
	else {
		$toEmail = $BookingDetailsData['sender_email'];
	}
	$filename = $bookingid.".pdf";
	$bookingid = $BookingDetailsData['booking_id'];
	$auto_id = $BookingDetailsData['auto_id'];
	
	$attachmentVar  = array();
	$service_name = ucwords($service_name);
	if($service_name_code=='ED' || $service_name_code=='EN')
	{
		$attachmentVar[] = DIR_WS_ONLINEPDF."UPS/connoate/TrackingLabel_".$filename;
		$attachmentVar[] = DIR_WS_ONLINEPDF."UPS/consignment/ConsignmentNote_".$filename;
	}elseif($service_name_code=='DE')
	{		
		$attachmentVar[] = DIR_WS_ONLINEPDF."StarTrack/connoate/TrackingLabel"."_".$bookingid.".pdf";
		$attachmentVar[] = DIR_WS_ONLINEPDF."StarTrack/consignment/ConsignmentNote"."_".$bookingid.".pdf";
		//$attachmentVar[] = DIR_WS_ONLINEPDF."driver_manifest/Driver_Manifest_$service_name"."_".$bookingid.".pdf";
	}elseif($service_name_code=='DP')
	{
		$code = strtolower($service_name_code);
		$attachmentVar[] = DIR_WS_ONLINEPDF."StarTrack/connoate/TrackingLabel"."_".$bookingid.".pdf";
		$attachmentVar[] = DIR_WS_ONLINEPDF."StarTrack/consignment/ConsignmentNote"."_".$bookingid.".pdf";
		//$attachmentVar[] = DIR_WS_ONLINEPDF."driver_manifest/Driver_Manifest_$service_name"."_".$bookingid.".pdf";
	}
	else
	{
		$code = strtolower($service_name_code);
		$attachmentVar[] = DIR_WS_ONLINEPDF."DirectCourier/connoate/TrackingLabel"."_".$bookingid.".pdf";
		$attachmentVar[] = DIR_WS_ONLINEPDF."DirectCourier/consignment/ConsignmentNote"."_".$bookingid.".pdf";
	}
	
	$attachmentVar[] = DIR_WS_ONLINEPDF."receipt/TaxInvoice".$auto_id.".pdf";
	
	/*if($BookingDetailsData['tansient_warranty'] && $BookingDetailsData['tansient_warranty'] == 'yes'){
		$attachmentVar[] =  DIR_WS_ONLINEPDF."forms/OLC_Transit_Waranty_Policy.pdf";
	}*/
	//echo "invoice provider:".$BookingDetailsData['commercial_invoice_provider']."</br>";
	//exit();
	if(isset($BookingDetailsData['commercial_invoice_provider']) && $BookingDetailsData['commercial_invoice_provider']=='002')
	{
		$attachmentVar[] = DIR_WS_ONLINEPDF."commercial_invoice/Commercial_Invoice_".$bookingid.".pdf";
	}
	/*echo "<pre>";
	print_r($attachmentVar);
	echo "</pre>";
	exit();*/
	$__Session->ClearValue("booking_details");
	$__Session->ClearValue("booking_details_items");
	$__Session->ClearValue("booking_id");
	$__Session->ClearValue("client_address_dilivery");
	$__Session->ClearValue("client_address_pickup");
	$__Session->ClearValue("commercial_invoice_id");
	$__Session->ClearValue("commercial_invoice");
	$__Session->ClearValue("commercial_invoice_item");
	$__Session->Store();
	//$toEmail = 'imageshack666@gmail.com';
	//echo "test:".$toEmail;
	//exit();
	SendMailContent($toEmail,$Email_Key,$findVar,$assignVar,"","","",$attachmentVar);
}
// Booking confirmation to be sent to admin user
function Admin_Booking_Confirmation($bookingid,$cardnumber,$service_name_code=null,$auto_id=null)
{
	global $__Session;
	$BookingDetailsMasterObj = BookingDetailsMaster::create();
	$BookingDetailsDataObj = new BookingDetailsData();
	$CountryMasterObj = CountryMaster::create();
	$CountryDataObj = new CountryData();
	//This variables $ObjBookingDisDetMaster and $ObjBookingDiscountData value assigned  by shailesh jamanapara Mon Jun 10 13:57:10 IST 2013
	
	$ObjBookingDisDetMaster		=BookingDiscountDetailsMaster::create();
	$ObjBookingDiscountData		=new BookingDiscountDetailsData();
	
	
	$InternationalZoneMasterObj= InternationalZonesMaster::create();
	$InternationalZoneData = new InternationalZonesData();
	$cardnumber=substr($cardnumber, 12, 4);
	$cardnumber="************".$cardnumber;
	$Email_Key = "BOOKING_CONFIRMATION";
	$findVar = array();		
	$findVar[]= '{$customername}';
	$findVar[]= '{$mailmessage}';
	$fieldArr = array();
	$seaArr[0] = array('Search_On'    => 'booking_id',
	                      'Search_Value' => $bookingid,
	                      'Type'         => 'string',
	                      'Equation'     => '=',
	                      'CondType'     => 'and',
	                      'Prefix'       => '',
	                      'Postfix'      => ''); 
	$fieldArr = array("*");
	
	$BookingDetailsDataObj = $BookingDetailsMasterObj->getBookingDetails($fieldArr,$seaArr);
	$BookingDetailsData = $BookingDetailsDataObj[0];
	$tamount = $BookingDetailsData['rate'];
	//$setid = $BookingDetailsData['auto_id'];
	
	$fieldDiscArr = array("*");
	$seaDiscArr = array();
	$seaDiscArr[0] = array('Search_On'    => 'booking_id',
	                      'Search_Value' => $bookingid,
	                      'Type'         => 'int',
	                      'Equation'     => '=',
	                      'CondType'     => 'and',
	                      'Prefix'       => '',
	                      'Postfix'      => '');
	$ObjBookingDiscountData = $ObjBookingDisDetMaster->getBookingDiscountDetails($fieldDiscArr, $seaDiscArr);
	$ObjBookingDiscountData = $ObjBookingDiscountData[0];
	
	/*$tamount = ceil($BookingDetailsData[$BookingDetailsData['service_name'].'_rate'])+get_payment_due();*/
	 
	//$contry_name = $BookingDetailsData['deliveryid']; 
	$contry_name = 'Australia'; 
		
	if(is_numeric($BookingDetailsData['deliveryid'])){
		
		$countries_id = $BookingDetailsData['deliveryid'];
		$fieldArrforCountryName  = array('countries_name');
		$seabycountryArr[0] = array('Search_On'    => 'countries_id',
								  'Search_Value' => $countries_id,
								  'Type'         => 'string',
								  'Equation'     => '=',
								  'CondType'     => 'And',
								  'Prefix'       => '',
								  'Postfix'      => ''); 
		$CountryDataObj = $CountryMasterObj->getCountry($fieldArrforCountryName,$seabycountryArr);
		$CountryDataObj = $CountryDataObj[0];
		$contry_name = $CountryDataObj['countries_name'];
		$sender_cnt_tr ='<tr>
<td width="300" valign="top" class="muted">Country</td>
<td width="300" valign="top" class="my_green text-right">Australia</td>
</tr>';
		$receiver_cnt_tr = '<tr>
<td width="300" valign="top" class="muted">Country:</td>
<td width="300" valign="top" class="my_green text-right">'.ucwords($contry_name).'</td>
</tr>';
	} 
	$connoate_number = $BookingDetailsData['CCConnote'];
	$courier_name = $BookingDetailsData['webservice'];
	$Mail_message='<!-- Content Starts Here -->
        				<table cellpadding="0" cellspacing="0" border="0" align="center">
            <tr>
				<td width="800" valign="top" style="padding: 10px 0 6px; box-shadow: inset 0 0 4px #eee; background: url(http://prioritycouriers.com.au/assets/img/breadcrumbs.png) repeat;">
                	<h1 class="pull-left" style="font-size: 30px; text-shadow: 0 1px 0 #f1efef; padding-left:20px;">New Booking</h1>
               	</td>
			</tr>
            <tr>
            	<td width="800" valign="top" height="20">
                </td>
            </tr>
            <tr>
            	<td width="800" valign="top" class="bg-light">
                    <table cellpadding="0" cellspacing="0" border="0" align="center">
                        <tr>
                            <td width="800" valign="top" style="padding-left:20px;">
                            	<blockquote>
                                	<p class="justy">Someone just made a new booking. All the details are contained below. The tracking number is <span class="my_green">'. $connoate_number.'</span> and the invoice number is <span class="my_green">'. $BookingDetailsData["transaction_id"].'</span>.</p>
                                </blockquote>
                            </td>
                        </tr>
                 	</table>
            	</td>
          	</tr>
            <tr>
            	<td width="800" valign="top">
                	<table cellpadding="0" cellspacing="0" border="0" align="center">
                    	<tr>
                        	<td width="800" valign="top" height="20">
                            </td>
                      	</tr>
                  	</table>
                    <table cellpadding="0" cellspacing="0" border="0" align="center">
                    	<tr>
                			<td width="100" valign="top"></td>
                			<td width="600" valign="top" class="bg-light">
                            	<table cellpadding="0" cellspacing="0" border="0" align="center">
                                	<tr>
                                        <td width="600" valign="top" class="my_bigger_font text-center">Booking Data</td>
                                   	</tr>
                               	</table>
                    			<table cellpadding="0" cellspacing="0" border="0" align="center">
                        			<tr>
                            			<td width="300" valign="top" class="muted">Tracking Number:</td>
                            			<td width="300" valign="top" class="my_green text-right">'. $BookingDetailsData["CCConnote"].'</td>
                            		</tr>
                                    <tr>
                            			<td width="300" valign="top" class="muted">Ready for collection: </td>
                            			<td width="300" valign="top" class="my_green text-right">'. $BookingDetailsData["date_ready"].'</td>
                            		</tr>
                                    <tr>
                            			<td width="300" valign="top" class="muted">Quantity:</td>
                            			<td width="300" valign="top" class="my_green text-right">'. $BookingDetailsData["total_qty"].'</td>
                            		</tr>
                                    <tr>
                            			<td width="300" valign="top" class="muted">Total Weight:</td>
                            			<td width="300" valign="top" class="my_green text-right">'. $BookingDetailsData["total_weight"].'Kg</td>
                            		</tr>
                                    <tr>
                            			<td width="300" valign="top" class="muted">Volumetric Weight:</td>
                            			<td width="300" valign="top" class="my_green text-right">'. $BookingDetailsData["volumetric_weight"].'Kg</td>
                            		</tr>
                                    <tr>
                            			<td width="300" valign="top" class="muted">Chargable Weight:</td>
                            			<td width="300" valign="top" class="my_green text-right">'. $BookingDetailsData["chargeable_weight"].'Kg</td>
                            		</tr>
                                    <tr>
                            			<td width="300" valign="top" class="muted">Courier Name:</td>
                            			<td width="300" valign="top" class="my_green text-right">'.ucwords($BookingDetailsData["webservice"]).'</td>
                            		</tr>
                                    <tr>
                            			<td width="300" valign="top" class="muted">Service Type:</td>
                            			<td width="300" valign="top" class="my_green text-right">'.ucwords($BookingDetailsData["service_name"]).'</td>
                            		</tr>
                                    <tr>
                            			<td width="300" valign="top" class="muted">Goods Description:</td>
                            			<td width="300" valign="top" class="my_green text-right">'.ucwords($BookingDetailsData["description_of_goods"]).'</td>
                            		</tr>
                                    
                               		<tr>
                            			<td width="300" valign="top" class="muted">Authority to Leave:</td>
                            			<td width="300" valign="top" class="my_green text-right">'.ucwords($BookingDetailsData["authority_to_leave"]).'</td>
                            		</tr>
                                    <tr>
                            			<td width="300" valign="top" class="muted">Placement Location:</td>
                            			<td width="300" valign="top" class="my_green text-right">'.ucwords($BookingDetailsData["where_to_leave_shipment"]).'</td>
                            		</tr>
                                </table>
                                <table cellpadding="0" cellspacing="0" border="0" align="center">
                                	<tr>
                                    	<td width="600" valign="top" class="hr_dashed">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td width="600" valign="top" height="10"></td>
                                   	</tr>
                                    <tr>
                                        <td width="600" valign="top" class="my_bigger_font text-center">Sender</td>
                                   	</tr>
                               	</table>
                                <table cellpadding="0" cellspacing="0" border="0" align="center">
                                    <tr>
                            			<td width="300" valign="top" class="muted">First Name:</td>
                            			<td width="300" valign="top" class="my_green text-right">'.ucwords($BookingDetailsData['sender_first_name']).'</td>
                            		</tr>
                                    <tr>
                            			<td width="300" valign="top" class="muted">Last Name:</td>
                            			<td width="300" valign="top" class="my_green text-right">'.ucwords($BookingDetailsData['sender_surname']).'</td>
                            		</tr>
                                    <tr>
                            			<td width="300" valign="top" class="muted">Company:</td>
                            			<td width="300" valign="top" class="my_green text-right">'.ucwords($BookingDetailsData['sender_company_name']).'</td>
                            		</tr>
                                    <tr>
                            			<td width="300" valign="top" class="muted">Address:</td>
                            			<td width="300" valign="top" class="my_green text-right">'.ucwords($BookingDetailsData['sender_address_1']).'</td>
                            		</tr>
                                    <tr>
                            			<td width="300" valign="top" class="muted"></td>
                            			<td width="300" valign="top" class="my_green text-right">'.ucwords($BookingDetailsData['sender_address_2']).'</td>
                            		</tr>
                                    <tr>
                            			<td width="300" valign="top" class="muted"></td>
                            			<td width="300" valign="top" class="my_green text-right">'.ucwords($BookingDetailsData['sender_address_3']).'</td>
                            		</tr>'.
									$sender_cnt_tr.'
                                    <tr>
                            			<td width="300" valign="top" class="muted">Suburb/City:</td>
                            			<td width="300" valign="top" class="my_green text-right">'.ucwords($BookingDetailsData['sender_suburb']).'</td>
                            		</tr>
                                    <tr>
                            			<td width="300" valign="top" class="muted">State:</td>
                            			<td width="300" valign="top" class="my_green text-right">'.ucwords($BookingDetailsData['sender_state']).'</td>
                            		</tr>
                                    <tr>
                            			<td width="300" valign="top" class="muted">Postcode:</td>
                            			<td width="300" valign="top" class="my_green text-right">'.ucwords($BookingDetailsData['sender_postcode']).'</td>
                            		</tr>
                                    <tr>
                            			<td width="300" valign="top" class="muted">E-mail:</td>
                            			<td width="300" valign="top" class="my_green text-right">'.$BookingDetailsData['sender_email'].'</td>
                            		</tr>
                                    <tr>
                            			<td width="300" valign="top" class="muted">Contact Nr:</td>
                            			<td width="300" valign="top" class="my_green text-right">'.ucwords($BookingDetailsData['sender_contact_no']).'</td>
                            		</tr>
                                    <tr>
                            			<td width="300" valign="top" class="muted">Additional Contact Nr:</td>
                            			<td width="300" valign="top" class="my_green text-right">'.ucwords($BookingDetailsData['sender_mobile_no']).'</td>
                            		</tr>
                              	</table>
                                <table cellpadding="0" cellspacing="0" border="0" align="center">
                                	<tr>
                                    	<td width="600" valign="top" class="hr_dashed">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td width="600" valign="top" height="10"></td>
                                   	</tr>
                                    <tr>
                                        <td width="600" valign="top" class="my_bigger_font text-center">Receiver</td>
                                   	</tr>
                               	</table>
                                <table cellpadding="0" cellspacing="0" border="0" align="center">
                                    <tr>
                            			<td width="300" valign="top" class="muted">First Name:</td>
                            			<td width="300" valign="top" class="my_green text-right">'.ucwords($BookingDetailsData['reciever_firstname']).'</td>
                            		</tr>
                                    <tr>
                            			<td width="300" valign="top" class="muted">Last Name:</td>
                            			<td width="300" valign="top" class="my_green text-right">'.ucwords($BookingDetailsData['reciever_surname']).'</td>
                            		</tr>
                                    <tr>
                            			<td width="300" valign="top" class="muted">Company:</td>
                            			<td width="300" valign="top" class="my_green text-right">'.ucwords($BookingDetailsData['reciever_company_name']).'</td>
                            		</tr>
                                    <tr>
                            			<td width="300" valign="top" class="muted">Address:</td>
                            			<td width="300" valign="top" class="my_green text-right">'.ucwords($BookingDetailsData['reciever_address_1']).'</td>
                            		</tr>
                                    <tr>
                            			<td width="300" valign="top" class="muted"></td>
                            			<td width="300" valign="top" class="my_green text-right">'.ucwords($BookingDetailsData['reciever_address_2']).'</td>
                            		</tr>
                                    <tr>
                            			<td width="300" valign="top" class="muted"></td>
                            			<td width="300" valign="top" class="my_green text-right">'.ucwords($BookingDetailsData['reciever_address_3']).'</td>
                            		</tr>'.							 $receiver_cnt_tr.'
                                    <tr>
                            			<td width="300" valign="top" class="muted">Suburb/City:</td>
                            			<td width="300" valign="top" class="my_green text-right">'.ucwords($BookingDetailsData['reciever_suburb']).'</td>
                            		</tr>
                                    <tr>
                            			<td width="300" valign="top" class="muted">State:</td>
                            			<td width="300" valign="top" class="my_green text-right">'.ucwords($BookingDetailsData['reciever_state']).'</td>
                            		</tr>
                                    <tr>
                            			<td width="300" valign="top" class="muted">Postcode:</td>
                            			<td width="300" valign="top" class="my_green text-right">'.ucwords($BookingDetailsData['reciever_postcode']).'</td>
                            		</tr>
                                    <tr>
                            			<td width="300" valign="top" class="muted">E-mail:</td>
                            			<td width="300" valign="top" class="my_green text-right">'.$BookingDetailsData['reciever_email'].'</td>
                            		</tr>
                                    <tr>
                            			<td width="300" valign="top" class="muted">Contact Nr:</td>
                            			<td width="300" valign="top" class="my_green text-right">'.ucwords($BookingDetailsData['reciever_contact_no']).'</td>
                            		</tr>
                                    <tr>
                            			<td width="300" valign="top" class="muted">Additional Contact Nr:</td>
                            			<td width="300" valign="top" class="my_green text-right">'.ucwords($BookingDetailsData['reciever_mobile_no']).'</td>
                            		</tr>
                              	</table>
                                <table cellpadding="0" cellspacing="0" border="0" align="center">
                                	<tr>
                                    	<td width="600" valign="top" class="hr_dashed">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td width="600" valign="top" height="10"></td>
                                   	</tr>
                                    <tr>
                                        <td width="600" valign="top" class="my_bigger_font text-center">Fees</td>
                                   	</tr>
                               	</table>
                                <table cellpadding="0" cellspacing="0" border="0" align="center"> 
                                    <tr>
                            			<td width="300" valign="top" class="muted">Payment Type:</td>
                            			<td width="300" valign="top" class="my_green text-right">'.ucwords($BookingDetailsData['payment_type']).'</td>
                            		</tr>
                                    <tr>
                            			<td width="300" valign="top" class="muted">Value of Goods</td>
                            			<td width="300" valign="top" class="my_green text-right">$'.$BookingDetailsData['values_of_goods'].'</td>
                            		</tr>
                                    <tr>
                            			<td width="300" valign="top" class="hr_dashed">&nbsp;</td></td>
                            			<td width="300" valign="top" class="hr_dashed">&nbsp;</td>
                            		</tr>
                                    <tr>
                            			<td width="300" valign="top" class="muted">Total GST:</td>
                            			<td width="300" valign="top" class="my_green text-right">$'.$BookingDetailsData['gst_surcharge'].'</td>
                            		</tr>
                                    <tr>
                            			<td width="300" valign="top" class="muted">Amount Paid (includes GST):</td>
                            			<td width="300" valign="top" class="my_green text-right">$'.$BookingDetailsData['rate'].'</td>
                            		</tr>
                               	</table>     
                            </td>
                            <td width="100" valign="top"></td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
            	<td width="800" valign="top" height="20">
                </td>
            </tr>
     	</table><!--/End Content Ends Here -->';
	
	$service_name = $BookingDetailsData['service_name'];
	$assignVar  = array();		
	
	$assignVar[] = $BookingDetailsData['sender_first_name'];
	$assignVar[] = $Mail_message;
	/*
	if($BookingDetailsData['payment_email']!="")
	{
	    $toEmail = $BookingDetailsData['sender_email'].",".$BookingDetailsData['payment_email'];
	}
	else {
		$toEmail = $BookingDetailsData['sender_email'];
	}
	$toEmail = ""*/;
	$filename = $BookingDetailsData['CCConnote'].".jpeg";
	$bookingid = $BookingDetailsData['booking_id'];
	
	
	$__Session->ClearValue("booking_details");
	$__Session->ClearValue("booking_details_items");
	$__Session->ClearValue("booking_id");
	$__Session->ClearValue("client_address_dilivery");
	$__Session->ClearValue("client_address_pickup");
	$__Session->ClearValue("commercial_invoice_id");
	$__Session->ClearValue("commercial_invoice");
	$__Session->ClearValue("commercial_invoice_item");
	$__Session->Store();
	$toEmail = 'admin@prioritycouriers.com.au';
	//$toEmail = 'smita.mahata@gmail.com';
	SendMailContent($toEmail,$Email_Key,$findVar,$assignVar,"","","","");
}
// Booking confirmation to be sent to admin user

//This function Booking_Cancel added shailesh jamanapara on date Thu Apr 18 20:39:27 IST 2013
//This function performs sending mail to the client and site admin when booking cancel request is submitted by users. 
function Booking_Cancel($bookingid,$service_name_code=null)
{
	
	$BookingDetailsMasterObj = BookingDetailsMaster::create();
	$BookingDetailsDataObj = new BookingDetailsData();
	$CountryMasterObj = CountryMaster::create();
	$CountryDataObj = new CountryData();
	
	$InternationalZoneMasterObj= InternationalZonesMaster::create();
	$InternationalZoneData = new InternationalZonesData();
	$cardnumber=substr($cardnumber, 12, 4);
	
	$Email_Key = "BOOKING_CANCEL";
	$findVar = array();		
	$findVar[]= '{$customername}';
	$findVar[]= '{$booking_id}';
	$findVar[]= '{$mailmessage}';
	$findVar[]= '{$booking_date}';
	
	$seaArr[0] = array('Search_On'    => 'booking_id',
	                      'Search_Value' => $bookingid,
	                      'Type'         => 'int',
	                      'Equation'     => '=',
	                      'CondType'     => 'and',
	                      'Prefix'       => '',
	                      'Postfix'      => ''); 
	$fieldArr = array("*");
	
	$BookingDetailsDataObj = $BookingDetailsMasterObj->getBookingDetails($fieldArr,$seaArr);
	$BookingDetailsData = $BookingDetailsDataObj[0];
	
	/*$tamount = ceil($BookingDetailsData[$BookingDetailsData['service_name'].'_rate'])+get_payment_due();*/
	$site_url = '<a href='.substr(SITE_URL,0,-1).'>'.substr(SITE_URL,0,-1).'</a>';
	 $contry_name = $BookingDetailsData['deliveryid'];

	if(is_numeric($BookingDetailsData['deliveryid'])){
		
		$fieldArrforCountryName  = array('countries_name');
		$countries_id = $BookingDetailsData['deliveryid'];
		if(strtolower($BookingDetailsData['flag'])=="australia"){
			$seabycountryArr[0] = array('Search_On'    => 'countries_id',
		                      'Search_Value' => $countries_id,
		                      'Type'         => 'string',
		                      'Equation'     => 'LIKE',
		                      'CondType'     => 'and ',
		                      'Prefix'       => '',
		                      'Postfix'      => ''); 
		$CountryDataObj = $CountryMasterObj->getCountry($fieldArrforCountryName,$seabycountryArr);
		$CountryDataObj = $CountryDataObj[0];
		$contry_name = $CountryDataObj['countries_name'];
		}else{
			$seaArr[0] = array('Search_On'    => 'id',
		                      'Search_Value' => $countries_id,
		                      'Type'         => 'string',
		                      'Equation'     => '=',
		                      'CondType'     => '',
		                      'Prefix'       => '',
		                      'Postfix'      => ''); 
		$CountryDataObj=$InternationalZoneMasterObj->getInternationalZones('null',$seaArr);
		$CountryDataObj=$CountryDataObj[0];
		
		$contry_name = $CountryDataObj['country'];
		}
		
	}
	
	$connoate_number = $BookingDetailsData['CCConnote'];
	
	$Mail_message='<table cellpadding="1" cellspacing="0" border="" width="996">
	<tr>
	<td width="100%" class="header_bg" colspan="2"> <h4>Booking  Ref:'. $BookingDetailsData['CCConnote'].'</h3></td>
	</tr>
	<tr>
		<td>Booking Cancelled on Date:</td>
		<td>'.date("m-d-YY").'</td>
	</tr>
	<tr>
		<td colspan="2">Booking Details</td>
		
	</tr>
	<tr><td colspan="2">&nbsp;</td></tr>
	<tr>
		<td>
			<table cellpadding="2" cellspacing="0" width="348">
				<tr><td colspan="2" style="bgcolor:#cccccc">Contact Detail</td></tr>
				<tr><td class="controlpanel_middle_td">Name</td><td class="controlpanel_middle_td">'.strtoupper($BookingDetailsData['sender_first_name'])." ".strtoupper($BookingDetailsData['sender_surname']).'</td></tr>
				<tr>
				<td class="controlpanel_middle_td" >Address</td>
				<td class="controlpanel_middle_td">'.strtoupper(($BookingDetailsData['sender_address_1'])?($BookingDetailsData['sender_address_1']):("<br />")).'</td></tr><tr>
				<td class="controlpanel_middle_td" ></td>
				<td class="controlpanel_middle_td">'.strtoupper(($BookingDetailsData['sender_address_2'])?($BookingDetailsData['sender_address_2']):("<br />")).'</td></tr><tr>
				<td class="controlpanel_middle_td" ></td>
				<td class="controlpanel_middle_td">'.strtoupper(($BookingDetailsData['sender_address_3'])?($BookingDetailsData['sender_address_3']):("<br />")).'</td>
				</tr>
				<tr>
				<td class="controlpanel_middle_td"></td>
				<td class="controlpanel_middle_td">'.strtoupper($BookingDetailsData['sender_suburb']).",".strtoupper($BookingDetailsData['sender_state']).",".strtoupper($BookingDetailsData['sender_postcode']).'</td>
				</tr>
			</table>
		</td>
		<td>
			<table border="0" cellpadding="2" cellspacing="0" width="372px" padding="4px" >
				<tr><td colspan="2">Receiver Detail</td></tr>
				<tr><td>Name</td><td>'.strtoupper($BookingDetailsData['reciever_firstname'])." ".strtoupper($BookingDetailsData['reciever_surname']).'</td>
				</tr>
				
				<tr>
				<td class="controlpanel_middle_td" >Address</td>
				<td class="controlpanel_middle_td">'.strtoupper(($BookingDetailsData['reciever_address_1'])?($BookingDetailsData['reciever_address_1']):("<br />")).'</td></tr><tr>
				<td class="controlpanel_middle_td" ></td>
				<td class="controlpanel_middle_td">'.strtoupper(($BookingDetailsData['reciever_address_2'])?($BookingDetailsData['reciever_address_2']):("<br />")).'</td></tr><tr>
				<td class="controlpanel_middle_td" ></td>
				<td class="controlpanel_middle_td">'.strtoupper(($BookingDetailsData['reciever_address_2'])?($BookingDetailsData['reciever_address_3']):("<br />")).'</td>
				</tr>
				
				<tr><td></td><td>'.strtoupper($BookingDetailsData['reciever_suburb']).",".strtoupper($BookingDetailsData['reciever_state']).",".strtoupper($BookingDetailsData['reciever_postcode']).'</td></tr>
			</table>
		</td>
	</tr>
	<tr>
		<td>	
			<table border="0" cellpadding="2" cellspacing="0" width="348" >
				<tr><td colspan="2">Your Shipment Detail</td></tr>
				<tr><td>Service</td><td>'.strtoupper($BookingDetailsData['service_name']).'</td></tr>
				<tr><td>From</td><td>'.strtoupper($BookingDetailsData['pickupid']).'</td></tr>
				<tr><td>To</td><td>'.strtoupper($contry_name).'</td></tr>
			</table>
		</td>
		<td>
			<table border="0" cellpadding="2" cellspacing="0" width="372px">
				<tr><td colspan="2">Booking Detail</td></tr>
				<tr><td>Booking Date:</td><td>'.strtoupper($BookingDetailsData['booking_date']).'</td></tr>
				<tr><td></td></tr>
				<tr><td></td></tr>
			</table>
		</td>		
		
	</tr>	
	
</table>
<span>
<small>Website: '.$site_url.'</small>
</span><BR>
';
	
	//echo $Mail_message;exit;
	$assignVar  = array();		
	$assignVar[] = $BookingDetailsData['sender_first_name'];
	$assignVar[] = $BookingDetailsData['CCConnote'];
	$assignVar[] = $Mail_message;
	//This below code commented by shailesh jamanapara on Date Tue Feb 05 19:44:53 IST 2013 
	/*if($BookingDetailsData['payment_email']!="")
	{
	$toEmail = $BookingDetailsData['sender_email'].",".$BookingDetailsData['payment_email'];
	}
	else {
		$toEmail = $BookingDetailsData['sender_email'];
	}*/
	$toEmail = $BookingDetailsData['sender_email'];
	/*$filename = $BookingDetailsData['CCConnote'].".jpeg";
	$attachmentVar  = array();
	$attachmentVar[] =DIR_WS_PDF."consignment/".$filename;	
	*/
	
	SendMailContent($toEmail,$Email_Key,$findVar,$assignVar,"","","",$attachmentVar,$connoate_number,$BookingDetailsData['booking_date']);
}
?>
