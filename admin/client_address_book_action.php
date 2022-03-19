<?php
/**
	* This file is for display user list
	*
	* @author     Radixweb <team.radixweb@gmail.com>
	* @copyright  Copyright (c) 2008, Radixweb
	* @version    1.0
	* @since      1.0
	*/
//echo "<pre>";print_r($_POST);die();
require_once("../lib/common.php");
require_once('pagination_top.php');
require_once(DIR_WS_MODEL . "ClientAddressMaster.php");
require_once(DIR_WS_ADMIN_LANGUAGES . DIR_CURRENT_LANGUAGE. '/client_address_book.php');
require_once(DIR_WS_MODEL ."CountryMaster.php");
require_once(DIR_WS_MODEL."PostCodeMaster.php");
require_once(DIR_WS_MODEL . "UserMaster.php");
$pagenum = ($_GET['pagenum']!="")?($_GET['pagenum']):(1);
if(!empty($pagenum))
{
	$err['pagenum'] = isNumeric(valid_input($pagenum),ENTER_NUMERIC_VALUES_ONLY);
}
if(!empty($err['pagenum']))
{
	logOut();
}
if(!empty($_GET['Action']))
{
	$err['Action'] = chkStr(valid_input($_GET['Action']));
}
if(!empty($err['Action']))
{
	logOut();
}

/**
	 * Start :: Object declaration
	 */
		$ObjUserMaster		= new UserMaster();
		$ObjUserMaster		= $ObjUserMaster->Create();
		$UserData			= new UserData();
		
		$PostCodeMasterObj = new PostCodeMaster();
		$PostCodeMasterObj = $PostCodeMasterObj->create();
		$PostCodeDataObj = new PostCodeData();
		
		$objCountryMaster = new CountryMaster();
		$objCountryMaster = $objCountryMaster->Create();
		$objCountryData=new CountryData();

		$ObjClientAddressMaster	= new ClientAddressMaster();
		$ObjClientAddressMaster	= $ObjClientAddressMaster->Create();
		$ClientAddressData		= new ClientAddressData();
/**
	 * Inclusion and Exclusion Array of Javascript
	 */
$title = array('Pickup'=>'Pickup','Delivery'=>'Delivery');
$arr_javascript_include[] = "postcode_action.php";
$arr_javascript_include[] = "client_address_book.js";
$arr_javascript_plugin_include[] = 'datatables/datatables.min.js';

$arr_css_plugin_include[] = 'datatables/datatables.min.css';
$arr_css_plugin_include[] = 'datatables/Buttons-1.6.5/css/buttons.dataTables.min.css';
/*csrf validation*/
$csrf = new csrf();
$csrf->action = "client_address_book";
//die();
if(!isset($_POST['submit'])) {
	$ptoken = $csrf->csrfkey();
}


/*csrf validation*/


/*$max_id = mysql_query("select max(addressId) as Id from postcode_locator");
$maximum_id = mysql_fetch_array($max_id);*/
/**
	 * Variable Declaration
	 */
$btnSubmit = ADMIN_BUTTON_SAVE_POSTCODE;
$HeadingLabel = ADMIN_LINK_SAVE_POSTCODE;
$addressId = $_GET['addressId'];
if(!empty($addressId))
{
	$err['addressId'] = isNumeric(valid_input($addressId),ENTER_NUMERIC_VALUES_ONLY);
}
if(!empty($err['addressId']))
{
	logOut();
}

    $err = array();
/*Export Csv Starts Here : Code for the Export of the PostCodes into csv Format*/
	if($_GET['Action']!='' &&  $_GET['Action']=='export'){


	$Countries = $ObjClientAddressMaster->getClientAddress();	

	$filename = DIR_WS_ADMIN_DOCUMENTS."client_addressbook.csv"; //Balnk CSV File
	$file_extension = strtolower(substr(strrchr($filename,"."),1));	//GET EXtension
    
	/**
	 * Genration of CSV File
	 */
	switch( $file_extension ) {
	  case "csv": $ctype = "text/comma-separated-values";break;
	  case "jpg": $ctype="image/jpg"; break;
	  default: $ctype="application/force-download";
	}    
	header("Pragma: public"); // required
	header('Expires: ' . gmdate('D, d M Y H:i:s') . ' GMT');
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Cache-Control: private",false); // required for certain browsers
	header("Content-Type: $ctype");
	header("Content-Disposition: attachment; filename=".basename($filename).";" );
	header("Content-Transfer-Encoding: binary");
	
	ob_clean();
	
	$curr= array("€"=>"�","£"=>"�");
	$data = "";
    //$data = "countries_id,\"countries_name\",\"countries_iso_code_2\",\"countries_iso_code_3\",\"address_format_id\",\"status\"";

    
     

    $data = "addressId,\"userid\",\"title\",\"firstname\",\"surname\",\"company\",\"address1\",\"address2\",\"address3\",\"suburb\",\"state\",\"postcode\",\"email\",\"area_code\",\"phoneno\",\"mobileno\",\"suburbid\",\"country\",\"countryid\",\"isDefault\",\"type\",\"sort_id\"";
	//$data.= PICKUP_FROM.",".DILIVER_TO.",".DISTANCEINKM;
				
	if(isset($Countries) && !empty($Countries)) {		
		foreach ($Countries as $Country) {		
			/*Code for the Currency value in which the order has been done*/

			$addressId     = $Country['addressId'];
			$userid   = $Country['userid'];
			$title  = valid_output($Country['title']);
			$firstname   = valid_output($Country['firstname']);
			$surname   = valid_output($Country['surname']);
			$company   = valid_output($Country['company']);
			$address1  = valid_output($Country['address1']);
			$address2 = valid_output($Country['address2']);
			$address3  = valid_output($Country['address3']);
			$suburb   = valid_output($Country['suburb']);
			$state = valid_output($Country['state']);
			$postcode= $Country['postcode'];
			$email  = valid_output($Country['email']);
			$phoneno  = $Country['phoneno'];
			$mobileno = $Country['mobileno'];
			$area_code = $Country['area_code'];
			$suburbid = $Country['suburbid'];
			$country = valid_output($Country['country']);
			$countryid = $Country['countryid'];
			$isDefault = $Country['isDefault'];
			$type = $Country['type'];
			$sort_id = $Country['sort_id'];
			//$address_format_id = $Country['address_format_id'];
			
			$data.= "\n";
			
			 $data .= '"'.$addressId.'","'.$userid.'","'.$title.'","'.$firstname.'","'.$surname.'","'.$company.'","'.$address1.'","'.$address2.'","'.$address3.'","'.$suburb.'","'.$state.'","'.$area_code.'",'.$postcode.'","'.$email.'","'.$phoneno.'","'.$mobileno.'","'.$suburbid.'","'.$country.'","'.$countryid.'","'.$isDefault.'","'.$type.'","'.$sort_id.'"';

		}			
	}
	echo $data;
	exit();
}
if($_GET['Action']=='trash'){
	$ObjClientAddressMaster->deleteClientAddress($addressId);
	$UParam = "?pagenum=".$pagenum."&message=".MSG_DELETE_CLIENT_ADDRESS_BOOK_SUCCESS;
	header('Location: '.FILE_CLIENT_ADDRESS_BOOK_LISTING.$UParam);
}
if($_GET['Action']=='mtrash'){
$addressId= $_GET['m_trash_id'];
	$m_t_a=explode(",",$addressId);
	foreach($m_t_a as $val)
	{
		$error = isNumeric(valid_input($val),ENTER_NUMERIC_VALUES_ONLY);
		if(!empty($error))
		{
			logOut();
		}else
		{
			$ObjClientAddressMaster->deleteClientAddress($val);
		}
		
	}
	$UParam = "?pagenum=".$pagenum."&message=".MSG_DELETE_CLIENT_ADDRESS_BOOK_SUCCESS;
	header('Location: '.FILE_CLIENT_ADDRESS_BOOK_LISTING.$UParam);
}
if((isset($_POST['submit']))){
	
	if(isEmpty(valid_input($_POST['ptoken']), true)){	
			logOut();
	}else{
		//$csrf->checkcsrf($_POST['ptoken']);
	}
	
	$err['firstnameError'] 		 = isEmpty($_POST['firstname'], COMMON_FIRSTNAME_IS_REQUIRED)?isEmpty($_POST['firstname'], COMMON_FIRSTNAME_IS_REQUIRED):checkName(valid_input($_POST['firstname']));
	$err['surnameError']  = isEmpty($_POST['surname'], ADMIN_SURNAME_IS_REQUIRED)?isEmpty($_POST['surname'], ADMIN_SURNAME_IS_REQUIRED):checkName(valid_input($_POST['surname']));
	$err['address1Error'] 		 = isEmpty($_POST['address1'], COMMON_ADDRESS_IS_REQUIRED)?isEmpty($_POST['address1'], COMMON_ADDRESS_IS_REQUIRED):chkStreet(valid_input($_POST['address1']));
	$err['suburbError'] 		 = (isEmpty(valid_input($_POST['suburb']),COMMON_SUBURB_IS_REQUIRED))?isEmpty(valid_input($_POST['suburb']),COMMON_SUBURB_IS_REQUIRED):checkName(valid_input($_POST['suburb']));;
	
	
	$err['stateError'] 		 = isEmpty($_POST['state'], COMMON_STATE_IS_REQUIRED)?isEmpty($_POST['state'], COMMON_STATE_IS_REQUIRED):chkState(valid_input($_POST['state']));
	$err['phonenoError'] 		 = isEmpty($_POST['hidden_contact_flag'], COMMON_PHONE_IS_REQUIRED);
	$err['postcodeError'] 		 = 	(isEmpty(($_POST['PostcodeText']),COMMON_POSTCODE_IS_REQUIRED))?isEmpty(($_POST['PostcodeText']),COMMON_POSTCODE_IS_REQUIRED):isNumeric(($_POST['PostcodeText']),ERROR_POSTCODE_REQUIRE_IN_NUMERIC);
	$err['emailError']  = (isEmpty(valid_input($_POST['email']),COMMON_EMAIL_IS_REQUIRED))?isEmpty(valid_input($_POST['email']),COMMON_EMAIL_IS_REQUIRED):checkEmailPattern(valid_input($_POST['email']),ERROR_EMAIL_FORMAT);
	$err['phonenoError'] 		 = 	(isEmpty(valid_input($_POST['phoneno']),COMMON_PHONE_IS_REQUIRED))?isEmpty(valid_input($_POST['phoneno']),COMMON_PHONE_IS_REQUIRED):(isNumeric(valid_input($_POST['phoneno']),ERROR_PHONE_REQUIRE_IN_NUMERIC)?isNumeric(valid_input($_POST['phoneno']),ERROR_PHONE_REQUIRE_IN_NUMERIC):(checkLength(valid_input($_POST['phoneno']), 8, 10,COMMON_PHONE_WITH_LIMIT)));
	$err['mobilenoError'] 		 =(isEmpty(valid_input($_POST['mobileno']),COMMON_MOBILE_IS_REQUIRED))?isEmpty(valid_input($_POST['mobileno']),COMMON_MOBILE_IS_REQUIRED):(isNumeric(valid_input($_POST['mobileno']),ERROR_MOBILE_REQUIRE_IN_NUMERIC)?isNumeric(valid_input($_POST['mobileno']),ERROR_MOBILE_REQUIRE_IN_NUMERIC):(checkLength(valid_input($_POST['mobileno']), 10, 12,COMMON_MOBILE_WITH_LIMIT)));
	
	$err['countryError']  = (isEmpty($_POST['all_country'], COMMON_COUNTRY_IS_REQUIRED))?isEmpty($_POST['all_country'], COMMON_COUNTRY_IS_REQUIRED):(isNumeric(valid_input($_POST['all_country']),ERROR_MOBILE_REQUIRE_IN_NUMERIC));
	$err['sort_idError']  = (isEmpty(valid_input($_POST['sort_id']),COMMON_SORTID_IS_REQUIRED))?isEmpty(valid_input($_POST['sort_id']),COMMON_SORTID_IS_REQUIRED):isNumeric(valid_input($_POST['sort_id']),ERROR_SORTID_REQUIRE_IN_NUMERIC); 
	if($_POST['company'] != '')
	{
		$err['companyError'] = checkName(valid_input($_POST['company']));
	}
	if($_POST['title'] != '')
	{
		$err['titleError'] = chkPages(valid_input($_POST['title']));
	}
		
	if($err['postcodeError']=='' &&  $_POST['temp_postcode']!=""  && $_POST['all_country']=='13')
	{
		$postcode = $_POST['temp_postcode'];
		$seaByArr[]=array('Search_On'=>'Postcode', 'Search_Value'=>"$postcode", 'Type'=>'string', 'Equation'=>'=', 'CondType'=>'', 'Prefix'=>'', 'Postfix'=>'');
	 	$res = $PostCodeMasterObj->getPostCode(array('Postcode'),true, $seaByArr, $optArr=null, $start=null, $total=null, $ThrowError=true,$uniqe_data=false,$display_all_from_admin=false);
		   if($res==0){
		   	$err['postcodeError']  = POSTCODE_NOT_EXIST;
		   }
	}
	/**
		 * Checking Error Exists
		 */
	
	//exit();
	foreach($err as $key => $Value) {
		if($Value != '') {
			$Svalidation=true;
			$ptoken = $csrf->csrfkey();
		}
	}
if($Svalidation==false){
		
		$ClientAddressData->userid = valid_input($_POST['userid']);
		if(empty($_POST['userid'])){
			$ClientAddressData->userid = 0;
		}
		$ClientAddressData->title = valid_input($_POST['title']);
		$ClientAddressData->firstname = valid_input($_POST['firstname']);
		$ClientAddressData->surname = valid_input($_POST['surname']);
		$ClientAddressData->company = valid_input($_POST['company']);
		$ClientAddressData->address1 = valid_input($_POST['address1']);
		$ClientAddressData->address2 = valid_input($_POST['address2']);
		$ClientAddressData->address3 = valid_input($_POST['address3']);
		$ClientAddressData->suburb = valid_input($_POST['suburb']);
		$ClientAddressData->state = valid_input($_POST['state']);
		$postcode = valid_input($_POST['PostcodeText']);
		if($_POST['all_country']=='13'){
			$postcode = valid_input($_POST['temp_postcode']);
		}
		$ClientAddressData->postcode = $postcode;
		$ClientAddressData->email = valid_input($_POST['email']);
		$ClientAddressData->phoneno = valid_input($_POST['phoneno']);
		$ClientAddressData->mobileno = valid_input($_POST['mobileno']);
		$ClientAddressData->area_code = valid_input($_POST['area_code']);
		$ClientAddressData->suburbid = valid_input($_POST['suburbid']);
		$ClientAddressData->country = valid_input($_POST['country_name']);
		$ClientAddressData->countryid = valid_input($_POST['all_country']);
		$ClientAddressData->isDefault = valid_input($_POST['isDefault']);
		if(empty($_POST['isDefault']))
		{
			$ClientAddressData->isDefault = 0;
		}
		
		$ClientAddressData->type = valid_input($_POST['title']);
		$ClientAddressData->sort_id = valid_input($_POST['sort_id']);
		$ClientAddressData->serial_address_id = 1;
		
		if(!empty(valid_input($addressId)))
		{
			$userid = $_POST['userid'];
			$srMaxAdd[]	=	array('Search_On'    => 'addressId',
			                      'Search_Value' => $addressId,
			                      'Type'         => 'int',
			                      'Equation'     => '=',
			                      'CondType'     => 'AND',
			                      'Prefix'       => '',
			                      'Postfix'      => '');
			
			$maxFieldArr = array("serial_address_id");
			$srMaxClientAddressData = $ObjClientAddressMaster->GetClientAddress($maxFieldArr,$srMaxAdd);
			$MaxClientAddressData = $srMaxClientAddressData[0];
			
		}
		if($_GET['addressId']!=''){
			
			$ClientAddressData->addressId = $addressId;
			$ClientAddressData->serial_address_id = $MaxClientAddressData['serial_address_id'];
			$ObjClientAddressMaster->editClientAddress($ClientAddressData,null,true);
			$UParam = "?pagenum=".$pagenum."&message=".MSG_EDIT_CLIENT_ADDRESS_BOOK_SUCCESS;
		}else{
			$insertedaddressId = $ObjClientAddressMaster->addClientAddress($ClientAddressData);
			$UParam = "?pagenum=".$pagenum."&message=".MSG_ADD_CLIENT_ADDRESS_BOOK_SUCCESS;
		}
		//echo MSG_EDIT_SUCCESS;exit();
		header('Location: '.FILE_CLIENT_ADDRESS_BOOK_LISTING.$UParam);
		exit();

	}

}

//echo $message;
/**
	 * Gets details for the user
	 */
$seaByArr = array();
$fieldArr = array();
if($addressId!=''){
	$fieldArr=array("*");
	$seaByArr[]=array('Search_On'=>'addressId', 'Search_Value'=>"$addressId", 'Type'=>'int', 'Equation'=>'=', 'CondType'=>'and', 'Prefix'=>'', 'Postfix'=>'');

	$DataPostCode=$ObjClientAddressMaster->getClientAddress($fieldArr,$seaByArr,null,null,null,true,false); // Fetch Data

	$DataPostCode = $DataPostCode[0];
	//Get sign up Address
	
	//Variable declaration

	$btnSubmit = ADMIN_BUTTON_SAVE_ADDRESSBOOK;
	$HeadingLabel = ADMIN_LINK_UPDATE_ADDRESSBOOK;
	//echo "<pre>";print_r($DataPostCode);
	
}
if($DataPostCode->countryid ==13 ){
        		$css = 'display:block';
        		$css_international = 'display:none';
        	}else{
        		$css = 'display:none';
        		$css_international = 'display:block';
        	}

$countryCode = $objCountryMaster->getCountry();
//$clientAusPostcode=$PostCodeMasterObj->GetPostCode(array("FullName","Postcode","Id","Name"),null);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php if ($_GET['addressId']=='') { echo ADMIN_ADD_USER; } else { echo ADMIN_EDIT_USER;}?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<?php
addCSSFileAdmin($arr_css_admin_include, $arr_css_admin_exclude);
addJavaScriptFile($arr_javascript_include, $arr_javascript_exclude); 
addPluginCSSFile($arr_css_plugin_include,$arr_css_plugin_exclude);
addPluginJavaScriptFile($arr_javascript_plugin_include,$arr_javascript_plugin_exclude);
?>
<script>
$(document).ready(function() {
    $('#maintable').dataTable();
} );
</script> 
</head>
<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
	<tr>
		<td valign="top">
		<?php require_once(DIR_WS_ADMIN_INCLUDES . ADMIN_FILE_HEADER);?>
		</td>
	</tr>	
	<!-- Start Middle Content part -->
	<tr>
		<td class="middle_content">
			<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td class="middle_left_content">
						<?php 
						// Include the Left Panel
						require_once(DIR_WS_ADMIN_INCLUDES . ADMIN_FILE_LEFT_MENU);
						?>
					</td>
					<td valign="top">
					<!-- Start :  Middle Content-->
						<table class="middle_right_content" align="center" border="0" cellpadding="0" cellspacing="0">
							<tr>
								<td align="left" class="breadcrumb">
										<span><a href="<?php echo FILE_WELCOME_ADMIN; ?>"><?php echo ADMIN_HEADER_HOME; ?></a> > <a href="<?php echo FILE_CLIENT_ADDRESS_BOOK_LISTING."?pagenum=".$pagenum; ?>"> <?php echo ADMIN_HEADER_ADDRESS; ?> </a> > <? echo $HeadingLabel; ?></span>
										
								</td>
							</tr>
							<tr>
								<td class="heading">
									<?php echo $HeadingLabel; ?>
								</td>
							</tr>
							
											
											
							<?php
							if($message!='')
							{ ?>
							<tr>
								<td class="message_error noprint" align="center"><?php echo valid_output($message); ?></td>
							</tr>
							<?php } ?>
											
											
							<tr>
								<td align="center">
									<?php  /*** Start :: Listing Table ***/ ?>
									<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
										
										<form name="frmuser" method="POST"  action="">
										<input type="hidden" name="Id" value="<?php echo $_GET['Id'];?>"  />
										<tr>
											<td>
												<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
													<tr>
														<td>
															<table width="98%" border="0" cellpadding="0" border="0" cellspacing="0" >
																<tr>
																	<td class="message_mendatory" align="right" colspan="4">
																		<?echo ADMIN_COMMAN_REQUIRED_INFO;?>
																	</td>
																</tr>
																<tr>
																	<td colspan="4" align="left" valign="top" class="grayheader"><b><?php echo ADMIN_USERS_PERSONAL_DETAILS;?> : </b></td>
																</tr>
																<tr><td colspan="4">&nbsp;</td></tr>
																<tr>
																	<td  align="left" valign="middle"><?php echo USER_ID;?></td>
																	<td  align="left" valign="middle"  >
																	<?php
																	$fieldArr = array("userid","email");
																	$seaByArr = array();
																	
																	$seaByArr[]=array('Search_On'=>'userid', 'Search_Value'=>$DataPostCode['userid'], 'Type'=>'int', 'Equation'=>'=', 'CondType'=>'and', 'Prefix'=>'', 'Postfix'=>'');
																	$ClientAddressData = $ObjUserMaster->getUserListing($fieldArr,null,null,null,$seaByArr);
																	$ClientAddressData = $ClientAddressData[0];
																	echo "<a href='".FILE_USERS_ADD_EDIT."?Action=edit&userid=".$DataPostCode['userid']."'>".$ClientAddressData['email']."</a>";
																	?>
																	
																	&nbsp;*<img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>internal/help_up.gif" class="help_btn" alt="Pickup From"onmouseover="return overlib('<?php echo $user_id;?>');" onmouseout="return nd();" /> </td>
																	
																</tr>
																<tr>
																	<td align="left" valign="middle">&nbsp;</td>
																	<td align="left" valign="top" class="message_mendatory" id="useridError"><?php echo $err['useridError'];  ?></td>
																	<td align="left" valign="middle">&nbsp;</td>
																	<td align="left" valign="top" class="message_mendatory" id="titleError"><?php echo $err['titleError'];  ?></td>
																</tr>
																<tr>
																	<td  align="left" valign="middle"><?php echo FIRST_NAME;?></td>
																	<td  align="left" valign="middle"  class="message_mendatory"><input class="textbox" type="text" name="firstname"  value="<?php if($_POST['firstname'] != ''){ echo valid_output($_POST['firstname']);}else{ echo valid_output($DataPostCode["firstname"]); } ?>" maxlength="50" tabindex="18"/>&nbsp;*<img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>internal/help_up.gif" class="help_btn" alt="<?php echo ADMIN_COMMON_FIRSTNAME; ?>"onmouseover="return overlib('<?php echo $FirstName;?>');" onmouseout="return nd();" /></td>
																	<td  align="left" valign="middle"><?php echo LAST_NAME;?></td>
																	<td  align="left" valign="top" class="message_mendatory"><input class="textbox" type="text" name="surname"  value="<?php if($_POST['surname'] != ''){ echo valid_output($_POST['surname']);}else{ echo valid_output($DataPostCode["surname"]); } ?>" maxlength="15" tabindex="19"/>&nbsp;*<img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>internal/help_up.gif" class="help_btn" alt="<?php echo LAST_NAME; ?>"onmouseover="return overlib('<?php echo $LastName;?>');" onmouseout="return nd();" /></td>
																</tr>
																<tr>
																	<td align="left" valign="middle">&nbsp;</td>
																	<td align="left" valign="top" class="message_mendatory" id="firstnameError"><?php echo $err['firstnameError'];  ?></td>
																	<td align="left" valign="middle">&nbsp;</td>
																	<td align="left" valign="top" class="message_mendatory" id="surnameError"><?php echo $err['surnameError'];  ?></td>
																</tr>
																<tr>
																	<td  align="left" valign="middle"><?php echo COMPANY;?></td>
																	<td  align="left" valign="middle"  class="message_mendatory"><input class="textbox" type="text" name="company"  value="<?php if($_POST['company'] != ''){ echo valid_output($_POST['company']);}else{ echo valid_output($DataPostCode["company"]); } ?>" maxlength="50" tabindex="18"/>&nbsp;*<img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>internal/help_up.gif" class="help_btn" alt="<?php echo COMPANY; ?>"onmouseover="return overlib('<?php echo $CompanyName;?>');" onmouseout="return nd();" /></td>
																	<td  align="left" valign="middle"><?php echo SUBURB;?></td>
																	<td  align="left" valign="top" class="message_mendatory"><input class="textbox" type="text" id="suburb" name="suburb"  value="<?php if($_POST['suburb'] != ''){ echo valid_output($_POST['suburb']);}else{ echo valid_output($DataPostCode["suburb"]); } ?>" maxlength="25" tabindex="19"/>&nbsp;*<img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>internal/help_up.gif" class="help_btn" alt="<?php echo SUBURB; ?>"onmouseover="return overlib('<?php echo $SuburbName;?>');" onmouseout="return nd();" /></td>
																</tr>
																<tr>
																	<td align="left" valign="middle">&nbsp;</td>
																	<td align="left" valign="top" class="message_mendatory" id="companyError"><?php echo $err['companyError'];  ?></td>
																	<td align="left" valign="middle">&nbsp;</td>
																	<td align="left" valign="top" class="message_mendatory" id="suburbError"><?php echo $err['suburbError'];  ?></td>
																</tr>
																<tr>
																	<td  align="left" valign="middle"><?php echo STATE;?></td>
																	<td  align="left" valign="middle"  class="message_mendatory"><input class="textbox" type="text" name="state" id="state" value="<?php if($_POST['state'] != ''){ echo valid_output($_POST['state']);}else{ echo valid_output($DataPostCode["state"]); } ?>" maxlength="50" tabindex="18"/>&nbsp;*<img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>internal/help_up.gif" class="help_btn" alt="<?php echo STATE; ?>"onmouseover="return overlib('<?php echo $StateName;?>');" onmouseout="return nd();" /></td>
																	<td  align="left" valign="middle"><?php echo POSTCODE;?></td>
																	<td  align="left" valign="top" class="message_mendatory">
	
		<input type="text" tabindex="11" name="PostcodeText" id="postcode" class="pick_form_textbox_big" style="<?php echo $css_international;?>"   value="<?php if($_POST['PostcodeText']!=""){echo valid_output($_POST['PostcodeText']);}else{echo valid_output($DataPostCode['postcode']);}?>" />
					
		<input type="text" class="change_all_data"  name="temp_postcode" id="ausPostcode"  autocomplete="off" style="<?php echo $css;?>" onkeyup="ajax_showOptions(this,'admin_search',event,'<?php echo DIR_HTTP_RELATED."tms_index.php"; ?>','ajax_index_listOfOptions');"  value="<?php if($_POST['temp_postcode']!=""){echo valid_output($_POST['temp_postcode']);}else{echo valid_output($DataPostCode['postcode']);}?>"/>
	<span  id="deliverResult" name="deliverResult" class="autocomplete_index"></span></br>
					
																	</td>
       
																</tr>
																<tr>
																	<td align="left" valign="middle">&nbsp;</td>
																	<td align="left" valign="top" class="message_mendatory" id="stateError"><?php echo $err['stateError'];  ?></td>
																	<td align="left" valign="middle">&nbsp;</td>
																	<td align="left" valign="top" class="message_mendatory" id="postcodeError"><?php echo $err['postcodeError'];  ?></td>
																</tr>
																<tr>
																	<td  align="left" valign="middle"><?php echo EMAIL;?></td>
																	<td  align="left" valign="middle"  class="message_mendatory"><input class="textbox" type="text" name="email"  value="<?php if($_POST['email'] != ''){ echo valid_output($_POST['email']);}else{ echo valid_output($DataPostCode["email"]); } ?>" maxlength="50" tabindex="18"/>&nbsp;*<img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>internal/help_up.gif" class="help_btn" alt="<?php echo ADMIN_COMMON_FIRSTNAME; ?>"onmouseover="return overlib('<?php echo $Confirm_Password;?>');" onmouseout="return nd();" /></td>
																	<td  align="left" valign="middle"><?php echo SORT_ID;?></td>
																	<td  align="left" valign="top" class="message_mendatory"><input class="textbox" type="text" name="sort_id"  value="<?php if($_POST['sort_id'] != ''){ echo valid_output($_POST['sort_id']);}else{ echo valid_output($DataPostCode["sort_id"]); } ?>" maxlength="2" tabindex="19"/>&nbsp;*<img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>internal/help_up.gif" class="help_btn" alt="<?php echo SORT_ID; ?>"onmouseover="return overlib('<?php echo $SortId;?>');" onmouseout="return nd();" /></td>
																</tr>
																<tr>
																	<td align="left" valign="middle">&nbsp;</td>
																	<td align="left" valign="top" class="message_mendatory" id="emailError"><?php echo $err['emailError'];  ?></td>
																	<td align="left" valign="middle">&nbsp;</td>
																	<td align="left" valign="top" class="message_mendatory" id="sort_idError"><?php echo $err['sort_idError'];  ?></td>
																</tr>
																<tr>
																	<td  align="left" valign="middle"><?php echo MOBILE_NO;?></td>
																	<td  align="left" valign="middle"  class="message_mendatory"><input class="textbox" type="text" name="mobileno"  value="<?php if($_POST['mobileno'] != ''){ echo valid_output($_POST['mobileno']);}else{ echo valid_output($DataPostCode["mobileno"]); } ?>" maxlength="13" tabindex="18"/>&nbsp;*<img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>internal/help_up.gif" class="help_btn" alt="<?php echo MOBILE_NO; ?>"onmouseover="return overlib('<?php echo $MobileNo;?>');" onmouseout="return nd();" /></td>
																	<td  align="left" valign="middle"><?php echo PHONE_NO;?></td>
																	<td  align="left" valign="top" class="message_mendatory"><input class="textbox" type="text" name="phoneno"  value="<?php if($_POST['phoneno'] != ''){ echo valid_output($_POST['phoneno']);}else{ echo valid_output($DataPostCode["phoneno"]); } ?>" maxlength="12" tabindex="19"/>&nbsp;*<img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>internal/help_up.gif" class="help_btn" alt="<?php echo PHONE_NO; ?>"onmouseover="return overlib('<?php echo $PhoneNO;?>');" onmouseout="return nd();" /></td>
																</tr>
																<tr>
																	<td align="left" valign="middle">&nbsp;</td>
																	<td align="left" valign="top" class="message_mendatory" id="mobilenoError"><?php echo $err['mobilenoError'];  ?></td>
																	<td align="left" valign="middle">&nbsp;</td>
																	<td align="left" valign="top" class="message_mendatory" id="phonenoError"><?php echo $err['phonenoError'];  ?></td>
																</tr>
																
																<tr>
																	<td  align="left" valign="middle"><?php echo COUNTRY;?></td>
																	<td  align="left" valign="middle"  class="message_mendatory">
																	<input type="hidden" name="country_name" id="country_name" value="<?php if($_POST['country_name']!=''){echo valid_output($_POST['country_name']);}else{echo valid_output($Postcode->countries_name);}?>"/>
																	<select class="all_country" id="interPostcode" name="all_country"  onchange="">
															        <option value="">Select Country </option>
																	<?php foreach ($countryCode as $Postcode){?>
															        <option id="<?php  echo $Postcode->countries_id;?>" value="<?php  echo $Postcode->countries_id;?>" <?php if($Postcode->countries_name ==$DataPostCode["country"] || $_POST['all_country'] == $Postcode->countries_id){echo "selected";}?>><?php echo valid_output($Postcode->countries_name);?></option>
															        <?php }?>
															        </select>*<img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>internal/help_up.gif" class="help_btn" alt="<?php echo COUNTRY;?>"onmouseover="return overlib('<?php echo $CountryName;?>');" onmouseout="return nd();" />
															         <input type="hidden" name="country" id="country"> 
																	<td  align="left" valign="middle"><?php echo ADDRESS;?></td>
																	<td  align="left" valign="top" class="message_mendatory">
																		<input class="textbox" type="text" name="address1"  value="<?php if($_POST['address1'] != ''){ echo valid_output($_POST['address1']);}else{ echo valid_output($DataPostCode["address1"]); } ?>" maxlength="25" tabindex="19"/>*<img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>internal/help_up.gif" class="help_btn" alt="<?php echo ADDRESS;?>"onmouseover="return overlib('<?php echo $Address;?>');" onmouseout="return nd();" />
																		</td>
																</tr>
																<tr>
																	<td align="left" valign="middle">&nbsp;</td>
																	<td align="left" valign="top" class="message_mendatory" id="countryError"><?php echo $err['countryError'];  ?></td>
																	<td align="left" valign="middle">&nbsp;</td>
																	<td align="left" valign="top" class="message_mendatory" id="countries_iso_code_2Error"><?php echo $err['address1Error'];  ?></td>
																</tr>
																	<tr>
																	<td  align="left" valign="middle" colspan="2">&nbsp;</td>
																	<td  align="left" valign="middle">&nbsp;</td>
																	<td  align="left" valign="top" class="message_mendatory"><input class="textbox" type="text" name="address2"  value="<?php if($_POST['address2'] != ''){ echo valid_output($_POST['address2']);}else{ echo valid_output($DataPostCode["address2"]); } ?>" maxlength="25" tabindex="19"/></td>
																</tr>
																<tr><td colspan="4">&nbsp;</td></tr>
																</tr>
																	<tr>
																	<td  align="left" valign="middle" colspan="2">&nbsp;</td>
																	<td  align="left" valign="middle">&nbsp;</td>
																	<td  align="left" valign="top" class="message_mendatory"><input class="textbox" type="text" name="address3"  value="<?php if($_POST['address3'] != ''){ echo valid_output($_POST['address3']);}else{ echo valid_output($DataPostCode["address3"]); } ?>" maxlength="25" tabindex="19"/></td>
																</tr>
																									
															</table>
														</td>
													</tr>
													<tr>
														<td>&nbsp;</td>
													</tr>
												
												</table>
											</td>
										</tr>
										<tr>
											<td>&nbsp;</td>
										</tr>
										<tr>
											<td align="center">
											<input type="hidden"  id="ptoken" value="<?php echo $ptoken; ?>" name="ptoken">
											<input type="submit" class="action_button" tabindex="36" name="submit" value="<?php echo $btnSubmit; ?>" onclick="return validate_client(this.form);" >
											<input type="reset" tabindex="37" name="reset" class="action_button" value="<?php echo ADMIN_COMMON_BUTTON_RESET; ?>" >
											<input type="button"  class="action_button" name="cancel" tabindex="38" value="<?php echo ADMIN_COMMON_BUTTON_CANCEL;?>" onclick="javascript:document.location.href='<?php echo FILE_CLIENT_ADDRESS_BOOK_LISTING."?pagenum=".$pagenum; ?>';return true;"/>
											</td>
										</tr>
										<tr>
											<td>&nbsp;</td>
										</tr>
										</form>
									</table>
									<?php  /*** End :: Listing Table ***/ ?>
								</td>
							</tr>
						</table>
					<!-- End :  Middle Content-->
					</td>
				</tr>
			</table>
		</td>
	</tr>
<!-- End Middle Content part -->
	<tr>
		<td id="footer">
			<?php require_once(DIR_WS_ADMIN_INCLUDES . ADMIN_FILE_FOOTER);?>
		</td>
	</tr>
</table>
</body>
</html>

