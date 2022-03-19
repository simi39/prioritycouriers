<?php
/**
	* This file is for display user list
	*
	* @author     Radixweb <team.radixweb@gmail.com>
	* @copyright  Copyright (c) 2008, Radixweb
	* @version    1.0
	* @since      1.0
	*/

/**
	 * include common file
	 */
require_once("../lib/common.php");
require_once(DIR_WS_MODEL . "CommercialInvoiceMaster.php");
require_once(DIR_WS_MODEL."CommercialInvoiceItemMaster.php");
require_once(DIR_WS_MODEL . "UserMaster.php");
require_once(DIR_WS_MODEL . "CountryMaster.php");
require_once(DIR_WS_MODEL . "BookingDetailsMaster.php");
require_once(DIR_WS_MODEL . "KmGridMaster.php");
require_once(DIR_WS_ADMIN_LANGUAGES . DIR_CURRENT_LANGUAGE. '/commercial_invoice.php');
/**
 * Start :: Object declaration
*/
$arr_css_plugin_include[] = 'datatables/css/jquery.dataTables.min.css';	
$arr_javascript_plugin_include[] = 'datatables/js/jquery.dataTables.min.js';

$ObjKmGridMaster	= new CommercialInoviceMaster();
$ObjKmGridMaster	= $ObjKmGridMaster->Create();
$CommercialInvoiceData		= new CommercialInvoiceData();
$ObjUserMaster		= new UserMaster();
$ObjUserMaster		= $ObjUserMaster->Create();
$UserData			= new UserData();
$ObjBookingDetailsMaster	= new BookingDetailsMaster();
$ObjBookingDetailsMaster	= $ObjBookingDetailsMaster->Create();
$BookingDetailsData		= new BookingDetailsData();
$CountryMasterObj    = new CountryMaster();
$CountryMasterObj    =$CountryMasterObj->Create();
$CommercialInvoiceItemMasterObj = new CommercialInvoiceItemMaster();
$CommercialInvoiceItemMasterObj = $CommercialInvoiceItemMasterObj->Create();
$CommercialInvoiceItemDataObj = new CommercialInvoiceItemData();		
			
/**
	 * Inclusion and Exclusion Array of Javascript
	 */
$arr_javascript_include[] = "commercial_invoice.php";
$arr_javascript_include[] = 'ajex.js';
$arr_javascript_include[] = 'ajax-dynamic-list.js';
$arr_javascript_include[] = "postcode_action.php";

$pagenum = ($_GET['pagenum']!="")?($_GET['pagenum']):(1);
if(!empty($pagenum))
{
	$err['pagenum'] = isNumeric(valid_input($pagenum),ENTER_NUMERIC_VALUES_ONLY);
}
if(!empty($err['pagenum']))
{
	logOut();
}
/**
	 * Variable Declaration
	 */
$btnSubmit = ADMIN_BUTTON_SAVE_POSTCODE;
$HeadingLabel = ADMIN_LINK_SAVE_POSTCODE;
$commercial_invoice_id = $_GET['commercial_invoice_id'];
if(!empty($commercial_invoice_id))
{
	$err['commercial_invoice'] = isNumeric(valid_input($commercial_invoice_id),ENTER_NUMERIC_VALUES_ONLY);
}
if(!empty($err['commercial_invoice']))
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
/*csrf validation*/
$csrf = new csrf();
$csrf->action = "commerical_inovice";
if(!isset($_POST['ptoken'])) {
	$ptoken = $csrf->csrfkey();
}

/*csrf validation*/


if($_GET['Action']=='trash'){
	$ObjKmGridMaster->deleteCommercialInovice($commercial_invoice_id);
	$UParam = "?pagenum=".$pagenum."&message=".MSG_DELETE_KM_GRID_SUCCESS;
	header('Location: '.FILE_COMMERCIAL_INVOICE_LISTING.$UParam);
}
if($_GET['Action']=='mtrash'){
	$commercial_invoice_id= $_GET['m_trash_id'];
	$m_t_a=explode(",",$commercial_invoice_id);
	foreach($m_t_a as $val)
	{
		$error = isNumeric(valid_input($val),ENTER_NUMERIC_VALUES_ONLY);
		if(!empty($error))
		{
			logOut();
		}else
		{
			$ObjKmGridMaster->deleteCommercialInovice($val);
		}
		
	}
	$UParam = "?pagenum=".$pagenum."&message=".MSG_DELETE_KM_GRID_SUCCESS;
	header('Location: '.FILE_COMMERCIAL_INVOICE_LISTING.$UParam);
}
if((isset($_POST['submit']) && $_POST['submit'] != "")){
	
	if(isEmpty(valid_input($_POST['ptoken']), true)){	
			logOut();
	}else{
		//$csrf->checkcsrf($_POST['ptoken']);
	}
	$err['consignor_nameError']  = isEmpty($_POST['consignor_name'], COMMERCIAL_CONSIGNOR_IS_NAME_REQUIRES)?isEmpty($_POST['consignor_name'], COMMERCIAL_CONSIGNOR_IS_NAME_REQUIRES):checkStr(valid_input($_POST['consignor_name']));
	$err['consignor_suburbError']  = isEmpty($_POST['consignor_suburb'],  COMMERCIAL_CONSIGNOR_SUBURB_IS_REQUIRES)?isEmpty($_POST['consignor_suburb'],  COMMERCIAL_CONSIGNOR_SUBURB_IS_REQUIRES):checkStr(valid_input($_POST['consignor_suburb']));
	$err['consignor_cityError']  = isEmpty($_POST['consignor_city'],  COMMERCIAL_CONSIGNOR_CITY_IS_REQUIRES)?isEmpty($_POST['consignor_city'],  COMMERCIAL_CONSIGNOR_CITY_IS_REQUIRES):checkStr(valid_input($_POST['consignor_city']));
	$err['consignor_postcodeError']  = (isEmpty(trim($_POST['consignor_postcode']),COMMERCIAL_CONSIGNOR_POSTCODE_IS_REQUIRES))?isEmpty(trim($_POST['consignor_postcode']),COMMERCIAL_CONSIGNOR_POSTCODE_IS_REQUIRES):isNumeric(trim($_POST['consignor_postcode']),ERROR_CONSIGNOR_POSTCODE_REQUIRE_IN_NUMERIC);
	
	
	$err['consignor_emailError']  = (isEmpty(trim($_POST['consignor_email']),COMMERCIAL_CONSIGNOR_POSTCODE_IS_REQUIRES))?isEmpty(trim($_POST['consignor_email']),COMMERCIAL_CONSIGNOR_POSTCODE_IS_REQUIRES):checkEmailPattern(trim($_POST['consignor_email']),ERROR_EMAIL_ID_INVALID);
		
	$err['consignee_nameError']  = isEmpty($_POST['consignee_name'],  COMMERCIAL_CONSIGNEE_IS_NAME_REQUIRES)?isEmpty($_POST['consignee_name'],  COMMERCIAL_CONSIGNEE_IS_NAME_REQUIRES):checkStr(valid_input($_POST['consignee_name']));
	$err['consignee_suburbError']  = isEmpty($_POST['consignee_suburb'],  COMMERCIAL_CONSIGNEE_SUBURB_IS_REQUIRES)?isEmpty($_POST['consignee_suburb'],  COMMERCIAL_CONSIGNEE_SUBURB_IS_REQUIRES):checkStr(valid_input($_POST['consignee_suburb']));
	$err['consignee_cityError'] 		 = isEmpty($_POST['consignee_city'],  COMMERCIAL_CONSIGNEE_CITY_IS_REQUIRES)?isEmpty($_POST['consignee_city'],  COMMERCIAL_CONSIGNEE_CITY_IS_REQUIRES):checkStr(valid_input($_POST['consignee_city']));
	$err['consignee_postcodeError']  =(isEmpty(trim($_POST['consignee_postcode']),COMMERCIAL_CONSIGNEE_POSTCODE_IS_REQUIRES))?isEmpty(trim($_POST['consignee_postcode']),COMMERCIAL_CONSIGNEE_POSTCODE_IS_REQUIRES):isNumeric(trim($_POST['consignee_postcode']),ERROR_CONSIGNEE_POSTCODE_REQUIRE_IN_NUMERIC);
	$err['consignee_emailError'] 		 = (isEmpty(trim($_POST['consignee_email']),COMMERCIAL_CONSIGNEE_EMAIL_IS_REQUIRES))?isEmpty(trim($_POST['consignee_email']),COMMERCIAL_CONSIGNEE_EMAIL_IS_REQUIRES):checkEmailPattern(trim($_POST['consignee_email']),ERROR_EMAIL_ID_INVALID);
	$err['booking_idError'] 		 = isEmpty($_POST['booking_id'], COMMERCIAL_BOOKING_ID_IS_REQUIRES)?isEmpty($_POST['booking_id'], COMMERCIAL_BOOKING_ID_IS_REQUIRES):isNumeric(trim($_POST['booking_id']),ENTER_NUMERIC_VALUES_ONLY);
	$err['useridError'] 		 = isEmpty($_POST['userid'], COMMERCIAL_USER_ID_IS_REQUIRES)?isEmpty($_POST['userid'], COMMERCIAL_USER_ID_IS_REQUIRES):isNumeric(trim($_POST['userid']),ENTER_NUMERIC_VALUES_ONLY);
	if($_POST['commercial_name'] != '')
	{
		$err['commercialnameError'] = checkStr($_POST["commercial_name"]);
	}
	if($_POST['country_of_manufacturing'] != '')
	{
		$err['country_of_manufacturing'] = isNumeric(trim($_POST['country_of_manufacturing']),ENTER_NUMERIC_VALUES_ONLY);;
	}
	if(!empty($err['country_of_manufacturing']))
	{
		logOut();
	}
	for($i=1;$i<=5;$i++)	
	{
		if(!empty($_POST["full_description_".$i]))
		{
			$error["full_description_error_".$i] = checkStr($_POST["full_description_".$i]);
		}
		if(!empty($_POST['qty_'.$i]))
		{
			$error['qty_error_'.$i] = isNumeric($_POST['qty_'.$i],'Enter only numeric values.');
		}
		if(!empty($_POST['currency_'.$i]))
		{
			$error['currency_error_'.$i] = chkCapital($_POST['currency_'.$i]);
		}
		if(!empty($_POST['unit_value_'.$i]))
		{
			$error['unit_value_error_'.$i] = isNumeric($_POST['unit_value_'.$i],'Enter only numeric values.');
		}
		if(!empty($_POST['commercial_value_'.$i]))
		{
			$error['commercial_value_error_'.$i] = isNumeric($_POST['commercial_value_'.$i],'Enter only numeric values.');
		}
	}
	if(isset($error) && $error != "")
	{
		foreach($error as $key => $Value) {
			if($Value != '') {
				$Svalidation=true;
				$ptoken = $csrf->csrfkey();
			}
		}
	}	
	/**
		 * Checking Error Exists
		 */
	foreach($err as $key => $Value) {
		if($Value != '') {
			$Svalidation=true;
			$ptoken = $csrf->csrfkey();
		}
	}

	if($Svalidation==false ){
			
		   $CommercialInvoiceData->consignor_name  = trim($_POST['consignor_name']);
		    $CommercialInvoiceData->consignor_company = trim($_POST['consignor_company']);
			$CommercialInvoiceData->consignor_address_1= trim($_POST['consignor_address_1']);
			$CommercialInvoiceData->consignor_address_2= trim($_POST['consignor_address_2']);
			$CommercialInvoiceData->consignor_address_3 = trim($_POST['consignor_address_3']);
			$CommercialInvoiceData->consignor_suburb = trim($_POST['consignor_suburb']);
			$CommercialInvoiceData->consignor_city= trim($_POST['consignor_city']);
			$CommercialInvoiceData->consignor_postcode = trim($_POST['consignor_postcode']);
			$CommercialInvoiceData->consignor_country = trim($_POST['consignor_country']);
			$CommercialInvoiceData->consignor_telephone = trim($_POST['consignor_telephone']);
			$CommercialInvoiceData->consignor_email= trim($_POST['consignor_email']);
			$CommercialInvoiceData->consignee_name  = trim($_POST['consignee_name']);
			$CommercialInvoiceData->consignee_company = trim($_POST['consignee_company']);
			$CommercialInvoiceData->consignee_address_1= trim($_POST['consignee_address_1']);
			$CommercialInvoiceData->consignee_address_2= trim($_POST['consignee_address_2']);
			$CommercialInvoiceData->consignee_address_3 = trim($_POST['consignee_address_3']);
			$CommercialInvoiceData->consignee_suburb = trim($_POST['consignee_suburb']);
			$CommercialInvoiceData->consignee_city= trim($_POST['consignee_city']);
			$CommercialInvoiceData->consignee_postcode = trim($_POST['consignee_postcode']);
			$CommercialInvoiceData->consignee_country = trim($_POST['consignee_country']);
			$CommercialInvoiceData->consignee_telephone = trim($_POST['consignee_telephone']);
			$CommercialInvoiceData->consignee_email= trim($_POST['consignee_email']);
			$CommercialInvoiceData->booking_id= trim($_POST['booking_id']);
			$CommercialInvoiceData->userid= trim($_POST['userid']);
			$CommercialInvoiceData->commercial_invoice_date = trim($_POST['commercial_invoice_date']);
			$CommercialInvoiceData->country_of_manufacturing=trim($_POST['country_of_manufacturing']);
			$CommercialInvoiceData->commercial_name=trim($_POST['commercial_name']);
			$CommercialInvoiceData->commercial_total=trim($_POST['commercial_total_value']);
			$CommercialInoviceDataObj = new stdClass;
			$CommercialInoviceDataObjArray = (array)$CommercialInoviceDataObj;
		
		$find_commercial_values = array();
		
		
			
		if($_GET['commercial_invoice_id']==''){
			$insertedCommercialInvoiceId = $ObjKmGridMaster->addCommercialInovice($CommercialInvoiceData);
				
			$UParam = "?pagenum=$pagegnum&message=".MSG_ADD_KMGRID_SUCCESS;
		}else{
			$fieldArr2=array("commercial_value");
			$seaByArr2[]=array('Search_On'=>'commercial_invoice_id', 'Search_Value'=>"$commercial_invoice_id", 'Type'=>'int', 'Equation'=>'=', 'CondType'=>'and', 'Prefix'=>'', 'Postfix'=>'');
			
			$find_commercial_values=$CommercialInvoiceItemMasterObj->getCommercialInvoiceItem($fieldArr2, $seaByArr2, $optArr=null, $start=null, $total=null, $ThrowError=true,$fetch_unique_commercial_id=false,$tot='find'); // Fetch Data
		
		}
		
	 $minimum_display = 5;
	
	
		
		
		
		
		for($i=1;$i<=$minimum_display;$i++)	
		 {
			
		 	//$CommercialInvoiceItemDataObj = new stdClass;
		 	$CommercialInvoiceItemDataObj->commercial_item_id=$i;
		 	$CommercialInvoiceItemDataObj->id=trim($_POST["id_".$i]);
		 	$CommercialInvoiceItemDataObj->commercial_description = trim($_POST["full_description_".$i]);
		 	$CommercialInvoiceItemDataObj->commercial_qty = trim($_POST["qty_".$i]);
		 	$CommercialInvoiceItemDataObj->commercial_currency =trim($_POST["currency_".$i]);
		 	$CommercialInvoiceItemDataObj->commercial_unit_value =trim($_POST["unit_value_".$i]);
		 	$CommercialInvoiceItemDataObj->commercial_value =trim($_POST["commercial_value_".$i]);
		 	$seaBy12[] = array();
		 	if($_GET['commercial_invoice_id']!='')
		 	{
					$id = $_GET['commercial_invoice_id'];
					
					$fieldArr=array("*");
					$seaBy12[]=array('Search_On'=>'commercial_invoice_id', 'Search_Value'=>"$id", 'Type'=>'int', 'Equation'=>'LIKE', 'CondType'=>'and', 'Prefix'=>'', 'Postfix'=>'');
					$seaBy12[]=array('Search_On'=>'commercial_item_id', 'Search_Value'=>"$CommercialInvoiceItemDataObj->commercial_item_id", 'Type'=>'int', 'Equation'=>'LIKE', 'CondType'=>'and', 'Prefix'=>'', 'Postfix'=>'');
					$FoundCommercialInvoice = $CommercialInvoiceItemMasterObj->getCommercialInvoiceItem($fieldArr=null, $seaBy12, $optArr=null, $start=null, $total=null, $ThrowError=true,$fetch_unique_commercial_id=false,$tot='find'); // Fetch Data
					
					if($FoundCommercialInvoice!=0)
					{
						$CommercialInvoiceItemDataObj->commercial_invoice_id=$_GET['commercial_invoice_id'];
						//echo "<pre>";print_r($CommercialInvoiceItemDataObj);
						//$commercialData=$CommercialInvoiceItemMasterObj->editCommercialInvoiceItem($CommercialInvoiceItemDataObj,true,true);
					}else
					{
						$CommercialInvoiceItemDataObj->commercial_invoice_id=$_GET['commercial_invoice_id'];
						//$commercialData=$CommercialInvoiceItemMasterObj->addCommercialInvoiceItem($CommercialInvoiceItemDataObj);
					}
					$seaBy12 = array();
				
		 	}else {
		 		$CommercialInvoiceItemDataObj->commercial_invoice_id =$insertedCommercialInvoiceId;
		 		//$CommercialInvoiceItemMasterObj->addCommercialInvoiceItem($CommercialInvoiceItemDataObj);
			}
		 
			//$CommercialInvoiceItemDataObjArray[$i-1] = (array)$CommercialInvoiceItemDataObj;
		}
		
		$findCommercialTotal = 0;
		if($_GET['commercial_invoice_id']!='')
			{
			
			
			$id = $_GET['commercial_invoice_id'];
			$fieldArr=array("*");
			$seaBy12 = array();
			$seaBy12[]=array('Search_On'=>'commercial_invoice_id', 'Search_Value'=>"$id", 'Type'=>'int', 'Equation'=>'LIKE', 'CondType'=>'and', 'Prefix'=>'', 'Postfix'=>'');
			//$seaBy12[]=array('Search_On'=>'commercial_item_id', 'Search_Value'=>"$CommercialInvoiceItemDataObj->commercial_item_id", 'Type'=>'int', 'Equation'=>'LIKE', 'CondType'=>'and', 'Prefix'=>'', 'Postfix'=>'');
			$FoundCommercialInvoicedata = $CommercialInvoiceItemMasterObj->getCommercialInvoiceItem($fieldArr=null, $seaBy12); // Fetch Data
			if(!empty($FoundCommercialInvoicedata))
			{
				foreach ($FoundCommercialInvoicedata as $key => $value) {
					$findCommercialTotal += $value['commercial_value'];
				}
			}
			$commercial_invoice_id = $_GET['commercial_invoice_id'];
			$CommercialInvoiceData->commercial_invoice_id = $commercial_invoice_id;
			$CommercialInvoiceData->commercial_total = $findCommercialTotal;
	
			$ObjKmGridMaster->editCommercialInovice($CommercialInvoiceData);
			$UParam = "?pagenum=$pagenum&message=".MSG_EDIT_KMGRID_SUCCESS;
			
			
		}
		
		//die();
		header('Location:'.FILE_COMMERCIAL_INVOICE_LISTING.$UParam);
		exit();

	}

}
if($_GET['Action']!='' &&  $_GET['Action']=='export_commercial_csv'){

     $seaArr[]	=	array('Search_On'=>'booking_id',
												'Search_Value'=>'',
												'Type'=>'string',
												'Equation'=>'!=',
												'CondType'=>'AND',
												'Prefix'=>'',
												'Postfix'=>''					);
	$KmGrids = $ObjKmGridMaster->getCommercialInovice($fieldArr, $seaArr, $optArr=null, $start=null, $total=null, $ThrowError=true);	

	
	$filename = DIR_WS_ADMIN_DOCUMENTS."commercial_invoice.csv"; //Balnk CSV File
	$file_extension = strtolower(substr(strrchr($filename,"."),1));	//GET EXtension
    
	/**
	 * Genration of CSV File
	 */
	switch( $file_extension ) {
	  case "csv": $ctype = "text/x-csv";break;
	  case "jpg": $ctype="image/jpg"; break;
	  default: $ctype="application/force-download";
	}    
	header("Pragma: public"); // required
	header('Expires: ' . gmdate('D, d M Y H:i:s') . ' GMT');
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Cache-Control: private",false); // required for certain browsers
//	header("Content-Type: $ctype");
	header("Content-Disposition: attachment; filename=".basename($filename).";" );
	header("Content-Transfer-Encoding: binary");
	
	ob_clean();

	$curr= array("€"=>"�","£"=>"�");
	$data = "";
	
	$data.= "commercial_invoice_id,\"consignor_name\",\"consignor_company\",\"consignor_address_1\",\"consignor_address_2\",\"consignor_address_3\",\"consignor_suburb\",\"consignor_city\",\"consignor_postcode\",\"consignor_country\",\"consignor_telephone\",\"consignor_email\",\"consignee_name\",\"consignee_company\",\"consignee_address_1\",\"consignee_address_2\",\"consignee_address_3\",\"consignee_suburb\",\"consignee_city\",\"consignee_postcode\",\"consignee_country\",\"consignee_telephone\",\"consignee_email\",\"commercial_invoice_date\",\"commercial_name\",\"commercial_total\",\"country_of_manufacturing\",\"booking_id\",\"userid\"";
	//$data.= PICKUP_FROM.",".DILIVER_TO.",".DISTANCEINKM;
				
	if(isset($KmGrids) && !empty($KmGrids)) {		
		foreach ($KmGrids as $KmGrid) {		
			/*Code for the Currency value in which the order has been done*/
	
			$commercial_invoice_id   = $KmGrid['commercial_invoice_id'];
			$consignor_name  = $KmGrid['consignor_name'];
			$consignor_company = $KmGrid['consignor_company'];
			$consignor_address_1= $KmGrid['consignor_address_1'];
			$consignor_address_2= $KmGrid['consignor_address_2'];
			$consignor_address_3 = $KmGrid['consignor_address_3'];
			$consignor_suburb = $KmGrid['consignor_suburb'];
			$consignor_city= $KmGrid['consignor_city'];
			$consignor_postcode = $KmGrid['consignor_postcode'];
			$consignor_country = $KmGrid['consignor_country'];
			$consignor_telephone = $KmGrid['consignor_telephone'];
			$consignor_email= $KmGrid['consignor_email'];
			$consignee_name  = $KmGrid['consignee_name'];
			$consignee_company = $KmGrid['consignee_company'];
			$consignee_address_1= $KmGrid['consignee_address_1'];
			$consignee_address_2= $KmGrid['consignee_address_2'];
			$consignee_address_3 = $KmGrid['consignee_address_3'];
			$consignee_suburb = $KmGrid['consignee_suburb'];
			$consignee_city= $KmGrid['consignee_city'];
			$consignee_postcode = $KmGrid['consignee_postcode'];
			$consignee_country = $KmGrid['consignee_country'];
			$consignee_telephone = $KmGrid['consignee_telephone'];
			$consignee_email= $KmGrid['consignee_email'];
			$commercial_invoice_date= $KmGrid['commercial_invoice_date'];
			$commercial_name 	 		= $KmGrid['commercial_name'];
			$commercial_total 	 		= $KmGrid['commercial_total'];
			$country_of_manufacturing 	 = $KmGrid['country_of_manufacturing'];
			$booking_id = $KmGrid['booking_id'];
			$userid = $KmGrid['userid'];
			$data.= "\n";
		  
			$data.= '"'.$commercial_invoice_id.'","'.$consignor_name.'","'.$consignor_company.'","'.$consignor_address_1.'","'.$consignor_address_2.'","'.$consignor_address_3.'","'.$consignor_suburb.'","'.$consignor_city.'","'.$consignor_postcode.'","'.$consignor_country.'","'.$consignor_telephone.'","'.$consignor_email.'","'.$consignee_name.'","'.$consignee_company.'","'.$consignee_address_1.'","'.$consignee_address_2.'","'.$consignee_address_3.'","'.$consignee_suburb.'","'.$consignee_city.'","'.$consignee_postcode.'","'.$consignee_country.'","'.$consignee_telephone.'","'.$consignee_email.'","'.$commercial_invoice_date.'","'.$commercial_name.'","'.$commercial_total.'","'.$country_of_manufacturing.'","'.$booking_id.'","'.$userid.'"';
		}			
	}
	echo $data;
	exit();
}

$message=$arr_messages[$_GET['message']];
if(!empty($message))
{
	$err['message'] = specialcharaChk(valid_input($message));
}
if(!empty($err['message']))
{
	logOut();
}	

/**
	 * Gets details for the user
	 */
$seaByArr = array();
$fieldArr = array();
$seaBy = array();
if($commercial_invoice_id!=''){
	$CommercialInvoiceItemDataVal = "";
	$fieldArr=array("*");
	$seaByArr[]=array('Search_On'=>'commercial_invoice_id', 'Search_Value'=>"$commercial_invoice_id", 'Type'=>'int', 'Equation'=>'=', 'CondType'=>'and', 'Prefix'=>'', 'Postfix'=>'');
	$DataPostCode=$ObjKmGridMaster->getCommercialInovice($fieldArr, $seaByArr, $optArr=null, $start=null, $total=null, $ThrowError=true); // Fetch Data
	$CommercialInvoiceData = $DataPostCode[0];
	$seaBy[]=array('Search_On'=>'commercial_invoice_id', 'Search_Value'=>"$commercial_invoice_id", 'Type'=>'int', 'Equation'=>'=', 'CondType'=>'and', 'Prefix'=>'', 'Postfix'=>'');
	$CommercialInvoiceItemDataVal = $CommercialInvoiceItemMasterObj->getCommercialInvoiceItem($fieldArr, $seaBy); // Fetch Data
	$btnSubmit = ADMIN_BUTTON_UPDATE_POSTCODE;
	$HeadingLabel = ADMIN_LINK_UPDATE_POSTCODE;
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php if ($_GET['commercial_invoice_id']=='') { echo ADMIN_ADD_COMMERCIAL_INVOICE_ITEM; } else { echo ADMIN_EDIT_COMMERCIAL_INVOICE_ITEM;}?></title>
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
					
					<td>
					<table class="middle_right_content" align="center" border="0" cellpadding="0" cellspacing="0">
							<tr>
								<td align="left" class="breadcrumb">
										<span><a href="<?php echo FILE_WELCOME_ADMIN; ?>"><?php echo ADMIN_HEADER_HOME; ?></a> > <a href="<?php echo FILE_COMMERCIAL_INVOICE_LISTING; ?>"> <?php echo ADMIN_HEADER_KM_GRID; ?> </a> > <? echo $HeadingLabel; ?></span>
										<div><label class="top_navigation"><a href="<?php echo FILE_COMMERCIAL_INVOICE_LISTING; ?>"><?php echo ADMIN_COMMON_BACK; ?></a></label></div>
								</td>
							</tr>
							<tr>
								<td class="heading">
									<?php echo $HeadingLabel; ?>
								</td>
							</tr>
							
											
											<tr><td colspan="4">&nbsp;</td></tr>
											
											<?php
											if($message!='')
											{ ?>
											<tr>
												<td class="message_error noprint" align="center"><?php echo valid_output($message); ?></td>
											</tr>
											
											<?php }  ?>		
												
											
							<tr>
								<td align="center">
									<?php  /*** Start :: Listing Table ***/ ?>
									<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
										<form name="commerical_invoice" method="POST"  action="#">
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
																<tr><td colspan="2" align="center" ><h2><?php echo COMMERCIAL_CONSIGNOR; ?></h2></td>
																<td colspan="2" align="center" ><h2><?php echo COMMERCIAL_CONSIGNEE; ?></h2></td>
																</tr>
																<tr><td colspan="4">&nbsp;</td></tr>
																
																<tr>
																	<td  align="left" valign="middle" class="firstcoloumConsignor"><?php echo COMMERCIAL_CONSIGNOR_NAME;?>&nbsp;</td>
																	<td  align="left" valign="middle"  class="message_mendatory"><input  type="text" class="secondcoloumConsignor input_consignor "   name="consignor_name" value="<?php if($CommercialInvoiceData['consignor_name']==""){echo valid_output($_POST['consignor_name']);}else{ echo valid_output($CommercialInvoiceData['consignor_name']);}?>" /><span> *</span><img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>help_up.gif" class="help_btn" alt="<?php echo ADMIN_COMMON_FIRSTNAME; ?>"onmouseover="return overlib('<?php echo $Consignor_Name;?>');" onmouseout="return nd();" /></td>
																	<td  align="left" valign="middle" class="firstcoloumConsignor"><?php echo COMMERCIAL_CONSIGNEE_NAME;?></td>
																	<td  align="left" valign="top" class="message_mendatory"><input  type="text" class="secondcoloumConsignor input_consignor " name="consignee_name" value="<?php if($CommercialInvoiceData['consignee_name']==""){echo valid_output($_POST['consignee_name']);}else{ echo valid_output($CommercialInvoiceData['consignee_name']);}?>" /><span> *</span><img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>help_up.gif" class="help_btn" alt="<?php echo ADMIN_COMMON_FIRSTNAME; ?>"onmouseover="return overlib('<?php echo $Consignee_Name;?>');" onmouseout="return nd();" /></td>
																</tr>
																<tr>
																	<td align="left" valign="middle">&nbsp;</td>
																	<td align="left" valign="top" class="message_mendatory firstcoloumConsignor" id="PickUpError"><?php echo $err['consignor_nameError'];  ?></td>
																	<td align="left" valign="middle">&nbsp;</td>
																	<td align="left" valign="top" class="message_mendatory firstcoloumConsignor" id="DeliverToError"><?php echo $err['consignee_nameError'];  ?></td>
																</tr>								

																<tr>
																	<td  align="left" valign="middle" class="firstcoloumConsignor"><?php echo COMMERCIAL_CONSIGNOR_COMPANY_NAME;?></td>
																	<td  align="left" valign="middle"  class="message_mendatory "><input type="text" class="secondcoloumConsignor input_consignor " name="consignor_company" value="<?php if($CommercialInvoiceData['consignor_company']==""){echo valid_output($_POST['consignor_company']);}else{ echo valid_output($CommercialInvoiceData['consignor_company']); }?>"/></td>
																	<td  align="left" valign="middle" class="firstcoloumConsignor"><?php echo COMMERCIAL_CONSIGNEE_COMPANY_NAME;?></td>
																	<td  align="left" valign="top"class="secondcoloumConsignor input_consignor message_mendatory"><input type="text" class="input_consignee" name="consignee_company" value="<?php if($CommercialInvoiceData['consignee_company']==""){echo valid_output($_POST['consignee_company']);}else{ echo valid_output($CommercialInvoiceData['consignee_company']); }?>"/></td>
																</tr>
																<tr>
																	<td align="left" valign="middle"  class="firstcoloumConsignor">&nbsp;</td>
																	<td align="left" valign="top" class="secondcoloumConsignor input_consignor message_mendatory" id="PickUpError"></td>
																	<td align="left" valign="middle"  class="firstcoloumConsignor">&nbsp;</td>
																	<td align="left" valign="top" class="secondcoloumConsignor input_consignor message_mendatory" id="DeliverToError"></td>
																</tr>	
																
																<tr>
																	<td  align="left" valign="middle" class="firstcoloumConsignor"><?php echo COMMERCIAL_CONSIGNOR_COMPANY_ADDRESS_1;?></td>
																	<td  align="left" valign="middle" class="secondcoloumConsignor input_consignor message_mendatory"><input type="text" class="input_consignor" name="consignor_address_1" value="<?php if($CommercialInvoiceData['consignor_address_1']==""){echo valid_output($_POST['consignor_address_1']);}else{echo valid_output($CommercialInvoiceData['consignor_address_1']);} ?>"/></td>
																	<td  align="left" valign="middle" class="firstcoloumConsignor"><?php echo COMMERCIAL_CONSIGNEE_COMPANY_ADDRESS_1;?></td>
																	<td  align="left" valign="top" class="secondcoloumConsignor input_consignor message_mendatory"><input type="text" class="input_consignee" name="consignee_address_1" value="<?php if($CommercialInvoiceData['consignee_address_1']==""){echo valid_output($_POST['consignee_address_1']);}else{echo valid_output($CommercialInvoiceData['consignee_address_1']);} ?>"/></td>
																</tr>
																<tr>
																	<td align="left" valign="middle" class="firstcoloumConsignor">&nbsp;</td>
																	<td align="left" valign="top" class="secondcoloumConsignor input_consignor message_mendatory" id="PickUpError"></td>
																	<td align="left" valign="middle" class="firstcoloumConsignor">&nbsp;</td>
																	<td align="left" valign="top" class="secondcoloumConsignor input_consignor message_mendatory" id="DeliverToError"></td>
																</tr>	
																
																<tr>
																	<td  align="left" valign="middle" class="firstcoloumConsignor"></td>
																	<td  align="left" valign="middle"  class="secondcoloumConsignor input_consignor message_mendatory"><input type="text" class="input_consignor" name="consignor_address_2" value="<?php if($CommercialInvoiceData['consignor_address_2']==""){echo valid_output($_POST['consignor_address_2']);}else{echo valid_output($CommercialInvoiceData['consignor_address_2']);} ?>"/></td>
																	<td  align="left" valign="middle" class="firstcoloumConsignor"></td>
																	<td  align="left" valign="top"class="secondcoloumConsignor input_consignor message_mendatory"><input type="text" class="input_consignee" name="consignee_address_2" value="<?php if($CommercialInvoiceData['consignee_address_2']==""){echo valid_output($_POST['consignee_address_2']);}else{echo valid_output($CommercialInvoiceData['consignee_address_2']);} ?>"/></td></td>
																</tr>
																<tr>
																	<td align="left" valign="middle" class="firstcoloumConsignor">&nbsp;</td>
																	<td align="left" valign="top" class="secondcoloumConsignor input_consignor message_mendatory" id="PickUpError"></td>
																	<td align="left" valign="middle" class="firstcoloumConsignor">&nbsp;</td>
																	<td align="left" valign="top" class="secondcoloumConsignor input_consignor message_mendatory" id="DeliverToError"></td>
																</tr>	
																
																<tr>
																	<td  align="left" valign="middle" class="firstcoloumConsignor"></td>
																	<td  align="left" valign="middle"  class="secondcoloumConsignor input_consignor message_mendatory"><input type="text" class="input_consignor" name="consignor_address_3" value="<?php if($CommercialInvoiceData['consignor_address_3']==""){echo valid_output($_POST['consignor_address_3']);}else{echo valid_output($CommercialInvoiceData['consignor_address_3']);} ?>"/></td>
																	<td  align="left" valign="middle" class="firstcoloumConsignor"></td>
																	<td  align="left" valign="top" class="secondcoloumConsignor input_consignor message_mendatory"><input type="text" class="input_consignee" name="consignee_address_3" value="<?php if($CommercialInvoiceData['consignee_address_3']==""){echo valid_output($_POST['consignee_address_3']);}else{echo valid_output($CommercialInvoiceData['consignee_address_3']);} ?>"/></td>
																</tr>
																<tr>
																	<td align="left" valign="middle" class="firstcoloumConsignor">&nbsp;</td>
																	<td align="left" valign="top" class="secondcoloumConsignor input_consignor message_mendatory" id="PickUpError"></td>
																	<td align="left" valign="middle" class="firstcoloumConsignor">&nbsp;</td>
																	<td align="left" valign="top" class="secondcoloumConsignor input_consignor message_mendatory" id="DeliverToError"></td>
																</tr>	
																
																<tr>
																	<td  align="left" valign="middle" class="firstcoloumConsignor"><?php echo COMMERCIAL_CONSIGNOR_COMPANY_SUBURB;?></td>
																	<td  align="left" valign="middle" class="secondcoloumConsignor input_consignor message_mendatory"><input type="text" class="input_consignor" name="consignor_suburb" value="<?php if($CommercialInvoiceData['consignor_suburb']==""){echo valid_output($_POST['consignor_suburb']);}else{echo valid_output($CommercialInvoiceData['consignor_suburb']);} ?>"/><span> *</span><img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>help_up.gif" class="help_btn" alt="<?php echo ADMIN_COMMON_FIRSTNAME; ?>"onmouseover="return overlib('<?php echo $Consignor_Suburb;?>');" onmouseout="return nd();" /></td>
																	<td  align="left" valign="middle" class="firstcoloumConsignor"><?php echo COMMERCIAL_CONSIGNEE_COMPANY_SUBURB;?></td>
																	<td  align="left" valign="top" class="secondcoloumConsignor input_consignor message_mendatory"><input type="text" class="input_consignee" name="consignee_suburb" value="<?php if($CommercialInvoiceData['consignee_suburb']==""){echo valid_output($_POST['consignee_suburb']);}else{echo valid_output($CommercialInvoiceData['consignee_suburb']);} ?>"/><span> *</span><img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>help_up.gif" class="help_btn" alt="<?php echo ADMIN_COMMON_FIRSTNAME; ?>"onmouseover="return overlib('<?php echo $Consignee_Suburb;?>');" onmouseout="return nd();" /></td>
																</tr>
																<tr>
																	<td align="left" valign="middle" class="firstcoloumConsignor">&nbsp;</td>
																	<td align="left" valign="top" class="message_mendatory secondcoloumConsignor" id="PickUpError"><?php echo $err['consignor_suburbError'];  ?></td>
																	<td align="left" valign="middle" class="firstcoloumConsignor">&nbsp;</td>
																	<td align="left" valign="top" class="message_mendatory secondcoloumConsignor" id="DeliverToError"><?php echo $err['consignee_suburbError'];  ?></td>
																</tr>	
																
																<tr>
																	<td  align="left" valign="middle" class="firstcoloumConsignor"><?php echo COMMERCIAL_CONSIGNOR_COMPANY_CITY;?></td>
																	<td  align="left" valign="middle"  class="secondcoloumConsignor input_consignor message_mendatory"><input type="text" class="input_consignor" name="consignor_city" value="<?php if($CommercialInvoiceData['consignor_city']==""){echo valid_output($_POST['consignor_city']);}else{echo valid_output($CommercialInvoiceData['consignor_city']);} ?>"/><span> *</span><img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>help_up.gif" class="help_btn" alt="<?php echo ADMIN_COMMON_FIRSTNAME; ?>"onmouseover="return overlib('<?php echo $Consignor_City;?>');" onmouseout="return nd();" /></td>
																	<td  align="left" valign="middle" class="firstcoloumConsignor"><?php echo COMMERCIAL_CONSIGNEE_COMPANY_CITY;?></td>
																	<td  align="left" valign="top" class="secondcoloumConsignor input_consignor message_mendatory"><input type="text" class="input_consignor" name="consignee_city" value="<?php if($CommercialInvoiceData['consignee_city']==""){echo valid_output($_POST['consignee_city']);}else{echo valid_output($CommercialInvoiceData['consignee_city']);} ?>"/><span> *</span><img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>help_up.gif" class="help_btn" alt="<?php echo ADMIN_COMMON_FIRSTNAME; ?>"onmouseover="return overlib('<?php echo $Consignee_City;?>');" onmouseout="return nd();" /></td>
																</tr>
																<tr>
																	<td align="left" valign="middle" class="message_mendatory firstcoloumConsignor">&nbsp;</td>
																	<td align="left" valign="top" class="message_mendatory secondcoloumConsignor" id="PickUpError"><?php echo $err['consignor_cityError'];  ?></td>
																	<td align="left" valign="middle" class="message_mendatory firstcoloumConsignor">&nbsp;</td>
																	<td align="left" valign="top" class="message_mendatory secondcoloumConsignor" id="DeliverToError"><?php echo $err['consignee_cityError'];  ?></td>
																</tr>	
																
																<tr>
																	<td  align="left" valign="middle" class="firstcoloumConsignor"><?php echo COMMERCIAL_CONSIGNOR_COMPANY_POSTCODE;?></td>
																	<td  align="left" valign="middle"  class="secondcoloumConsignor input_consignor message_mendatory"><input type="text" class="input_consignor" name="consignor_postcode" value="<?php if($CommercialInvoiceData['consignor_postcode']==""){echo valid_output($_POST['consignor_postcode']);}else{echo valid_output($CommercialInvoiceData['consignor_postcode']);} ?>"/><span> *</span><img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>help_up.gif" class="help_btn" alt="<?php echo COMMERCIAL_CONSIGNOR_COMPANY_POSTCODE; ?>"onmouseover="return overlib('<?php echo $Consignor_Postcode;?>');" onmouseout="return nd();" /></td>
																	<td  align="left" valign="middle" class="firstcoloumConsignor"><?php echo COMMERCIAL_CONSIGNEE_COMPANY_POSTCODE;?></td>
																	<td  align="left" valign="top" class="secondcoloumConsignor input_consignor message_mendatory"><input type="text" class="input_consignor" name="consignee_postcode" value="<?php if($CommercialInvoiceData['consignee_postcode']==""){echo valid_output($_POST['consignee_postcode']);}else{echo valid_output($CommercialInvoiceData['consignee_postcode']);} ?>"/><span> *</span><img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>help_up.gif" class="help_btn" alt="<?php echo COMMERCIAL_CONSIGNEE_COMPANY_POSTCODE; ?>"onmouseover="return overlib('<?php echo $Consignee_Postcode;?>');" onmouseout="return nd();" /></td>
																</tr>
																<tr>
																	<td align="left" valign="middle" class="firstcoloumConsignor">&nbsp;</td>
																	<td align="left" valign="top" class="message_mendatory secondcoloumConsignor" id="PickUpError"><?php echo $err['consignor_postcodeError'];  ?></td>
																	<td align="left" valign="middle" class="firstcoloumConsignor">&nbsp;</td>
																	<td align="left" valign="top" class="message_mendatory secondcoloumConsignor" id="DeliverToError"><?php echo $err['consignee_postcodeError'];  ?></td>
																</tr>	
																
																<tr>
																	<td  align="left" valign="middle" class="firstcoloumConsignor"><?php echo COMMERCIAL_CONSIGNOR_COMPANY_COUNTRY;?></td>
																	<td  align="left" valign="middle"  class="secondcoloumConsignor input_consignor message_mendatory"><input type="text" class="input_consignor" name="consignor_country" value="<?php if($CommercialInvoiceData['consignor_country']==""){echo valid_output($_POST['consignor_country']);}else{echo valid_output($CommercialInvoiceData['consignor_country']);} ?>"/><span> *</span><img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>help_up.gif" class="help_btn" alt="<?php echo ADMIN_COMMON_FIRSTNAME; ?>"onmouseover="return overlib('<?php echo $Consignor_Country;?>');" onmouseout="return nd();" /></td>
																	<td  align="left" valign="middle" class="firstcoloumConsignor"><?php echo COMMERCIAL_CONSIGNEE_COMPANY_COUNTRY;?></td>
																	<td  align="left" valign="top" class="secondcoloumConsignor input_consignor message_mendatory"><input type="text" class="input_consignor" name="consignee_country" value="<?php if($CommercialInvoiceData['consignee_country']==""){echo valid_output($_POST['consignee_country']);}else{echo valid_output($CommercialInvoiceData['consignee_country']);} ?>"/><span> *</span><img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>help_up.gif" class="help_btn" alt="<?php echo ADMIN_COMMON_FIRSTNAME; ?>"onmouseover="return overlib('<?php echo $Consignee_Country;?>');" onmouseout="return nd();" /></td>
																</tr>
																<tr>
																	<td align="left" valign="middle" class="firstcoloumConsignor">&nbsp;</td>
																	<td align="left" valign="top" class="secondcoloumConsignor input_consignor message_mendatory" id="PickUpError"></td>
																	<td align="left" valign="middle" class="firstcoloumConsignor">&nbsp;</td>
																	<td align="left" valign="top" class="secondcoloumConsignor input_consignor message_mendatory" id="DeliverToError"></td>
																</tr>	
																
																<tr>
																	<td  align="left" valign="middle" class="firstcoloumConsignor"><?php echo COMMERCIAL_CONSIGNOR_COMPANY_TELEPHONE;?></td>
																	<td  align="left" valign="middle"  class="secondcoloumConsignor input_consignor message_mendatory"><input type="text" class="input_consignor" name="consignor_telephone" value="<?php if($CommercialInvoiceData['consignor_telephone']==""){echo $_POST['consignor_telephone'];}else{echo $CommercialInvoiceData['consignor_telephone'];} ?>"/></td>
																	<td  align="left" valign="middle" class="firstcoloumConsignor"><?php echo COMMERCIAL_CONSIGNEE_COMPANY_TELEPHONE;?></td>
																	<td  align="left" valign="top" class="secondcoloumConsignor input_consignor message_mendatory"><input type="text" class="input_consignor" name="consignee_telephone" value="<?php if($CommercialInvoiceData['consignee_telephone']==""){echo $_POST['consignee_telephone'];}else{echo $CommercialInvoiceData['consignee_telephone'];} ?>"/></td>
																</tr>
																<tr>
																	<td align="left" valign="middle" class="firstcoloumConsignor">&nbsp;</td>
																	<td align="left" valign="top" class="secondcoloumConsignor input_consignor message_mendatory" id="PickUpError"></td>
																	<td align="left" valign="middle"  class="firstcoloumConsignor" >&nbsp;</td>
																	<td align="left" valign="top" class="secondcoloumConsignor input_consignor message_mendatory" id="DeliverToError"></td>
																</tr>	
																
																<tr>
																	<td  align="left" valign="middle"  class="firstcoloumConsignor"><?php echo COMMERCIAL_CONSIGNOR_COMPANY_EMAIL;?></td>
																	<td  align="left" valign="middle"  class="secondcoloumConsignor input_consignor message_mendatory"><input type="text" class="input_consignor" name="consignor_email" value="<?php if($CommercialInvoiceData['consignor_email']==""){echo valid_output($_POST['consignor_email']);}else{echo valid_output($CommercialInvoiceData['consignor_email']);} ?>"/><span> *</span><img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>help_up.gif" class="help_btn" alt="<?php echo ADMIN_COMMON_FIRSTNAME; ?>"onmouseover="return overlib('<?php echo $Consignor_Email;?>');" onmouseout="return nd();" /></td>
																	<td  align="left" valign="middle"  class="firstcoloumConsignor"><?php echo COMMERCIAL_CONSIGNEE_COMPANY_EMAIL;?></td>
																	<td  align="left" valign="top"class="secondcoloumConsignor input_consignor message_mendatory"><input type="text" class="input_consignor" name="consignee_email" value="<?php if($CommercialInvoiceData['consignee_email']==""){echo valid_output($_POST['consignee_email']);}else{echo valid_output($CommercialInvoiceData['consignee_email']);} ?>"/><span> *</span><img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>help_up.gif" class="help_btn" alt="<?php echo ADMIN_COMMON_FIRSTNAME; ?>"onmouseover="return overlib('<?php echo $Consignee_Email;?>');" onmouseout="return nd();" /></td>
																</tr>
																<tr>
																	<td align="left" valign="middle"  class="firstcoloumConsignor">&nbsp;</td>
																	<td align="left" valign="top"class="message_mendatory secondcoloumConsignor" id="PickUpError"><?php echo $err['consignor_emailError'];  ?></td>
																	<td align="left" valign="middle"  class="firstcoloumConsignor">&nbsp;</td>
																	<td align="left" valign="top" class="message_mendatory secondcoloumConsignor" id="DeliverToError"><?php echo $err['consignee_emailError'];  ?></td>
																</tr>
																<tr>
																	<td  align="left" valign="middle"  class="firstcoloumConsignor"><?php echo COMMERCIAL_USER_ID;?></td>
																	
																	<td  align="left" valign="middle" class="secondcoloumConsignor input_consignor message_mendatory">
																	<?php
		$fieldArr = array("userid","email");
	
		$PostCodedatas = $ObjUserMaster->getUserListing($fieldArr);
		$countryOutput.="<select name='userid'   id='pickup_chargingzone' onchange='javascript:getBookingIdofUser(this.value);' >
		<option value=''>SELECT USER ID</option>";
		if($PostCodedatas!=''){     		
		foreach($PostCodedatas as $country_val)
		     		{			$cond = ($country_val["userid"]==$CommercialInvoiceData['userid'])?("selected"):('');
		     					 $countryname=$country_val["email"];
			 					 $countryOutput.='<option value="'.$country_val["userid"].'"';
			 					 $countryOutput.=$cond;
								 $countryOutput.='  >'.$countryname.'</option>';
	         		} 
		}
		                       	$countryOutput.="</select>";
		                         echo $countryOutput;
					?>
						<span> *</span><img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>help_up.gif" class="help_btn" alt="<?php echo COMMERCIAL_USER_ID; ?>"onmouseover="return overlib('<?php echo $user_id;?>');" onmouseout="return nd();" /></td>											
					<td  align="left" valign="middle"  class="firstcoloumConsignor"><?php echo COMMERCIAL_BOOKING_ID;?></td>
																	<td  align="left" valign="top" class="secondcoloumConsignor input_consignor message_mendatory">
																	<div id="booking_records">
																	<?php
																	
		$countryOutput = '';					
		$fieldArr1 = array("booking_id");
		
		
		if($CommercialInvoiceData['userid']!=''){
			$userid = $CommercialInvoiceData['userid'];
			$BookingSearchDetailArray[] = array('Search_On'=>'userid', 'Search_Value'=>$userid, 'Type'=>'int', 'Equation'=>'=', 'CondType'=>'AND', 'Prefix'=>'', 'Postfix'=>'');				
		}
		
	
		$PostCodedatas = $ObjBookingDetailsMaster->getBookingDetails($fieldArr1,$BookingSearchDetailArray);
		/*
		echo "<pre>";
		print_R($PostCodedatas);
		echo "</pre>";
		exit();
		*/
		$countryOutput.="<select name='booking_id'   id='booking_id_of_user' >
		<option value=''>SELECT BOOKING ID</option>";
		if($PostCodedatas!=''){     		
		foreach($PostCodedatas as $country_val)
		     		{			$cond = ($country_val["booking_id"]==$CommercialInvoiceData['booking_id'])?("selected"):('');
		     					 $countryname= generatebookigid("",$country_val["booking_id"]);
			 					 $countryOutput.='<option value="'.$country_val["booking_id"].'"';
			 					 $countryOutput.=$cond;
								 $countryOutput.='  >'.valid_output($countryname).'</option>';
	         		} 
		}
		                       	$countryOutput.="</select>";
		                         echo $countryOutput;
					?><span> *</span><img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>help_up.gif" class="help_btn" alt="<?php echo ADMIN_COMMON_FIRSTNAME; ?>"onmouseover="return overlib('<?php echo $booking_id;?>');" onmouseout="return nd();" /></div></td>
																</tr>
																<tr>
																	<td align="left" valign="middle" class="firstcoloumConsignor">&nbsp;</td>
																	<td align="left" valign="top" class="message_mendatory secondcoloumConsignor" id="PickUpError"><?php echo $err['useridError'];  ?></td>
																	<td align="left" valign="middle" class="firstcoloumConsignor">&nbsp;</td>
																	<td align="left" valign="top" class="message_mendatory secondcoloumConsignor" id="DeliverToError"><?php echo $err['booking_idError'];  ?></td>
																</tr>	
																
																
																
																
																<tr>
		<td colspan="4" align="center"><h4><?php echo COMMERCIAL_SHIPMENT_DETAILS; ?></h4></td>
	</tr>
	<tr>
		<td colspan="4">
			<table width="100%" border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td align="center" width="40%"><h2><?php echo COMMERCIAL_FULL_DESCRIPTION; ?></h2></td>
					<td align="right" width="10%"><h2><?php echo COMMERCIAL_QUANTITY; ?></h2></td>
					<td align="right" width="20%"><h2><?php echo COMMERCIAL_CURRENCY; ?></h2></td>
					<td align="right" width="10%"><h2><?php echo COMMERCIAL_UNIT_VALUE; ?></h2></td>
					<td align="" width="10%"><h2><?php echo COMMERCIAL_VALUE; ?></h2></td>
				</tr>
				
				<?php
				
				if($CommercialInvoiceItemDataVal=="")
				{	
					for($i=1; $i<=5;$i++)
					{
						$full_description ="full_description_".$i;
						$qty="qty_".$i;
						$currency ="currency_".$i;
						$unit_value="unit_value_".$i;
						$commercial_value="commercial_value_".$i;
				?> 
				<tr>
					<td><input class="input_full_description" type="text" name="<?php echo $full_description; ?>" id="" value="<?php echo valid_output($_POST[$full_description]); ?>" /></td>
					<td><input type="text" name="<?php echo $qty; ?>" id="<?php echo $qty; ?>" class="input_qty"  value="<?php echo valid_output($_POST[$qty]); ?>" maxlength="5" size="5" onchange="javascript:qty_validation();round_up(this.id,this.value,0);" /></td>
					<td align="center">
						<select id="<?php echo $currency; ?>" name="<?php echo $currency; ?>">
							<option <?php if($_POST[$currency]=="INR"){ echo "selected";} ?>>INR</option>
							<option <?php if($_POST[$currency]=="AUD"){ echo "selected";} ?>>AUD</option>
							<option <?php if($_POST[$currency]=="GBP"){ echo "selected";} ?>>GBP</option>
						</select>
					
					</td>
					<td><input type="text"  value="<?php echo $_POST[$unit_value]; ?>"  name="<?php echo $unit_value; ?>" align="right" class="input_value" id="<?php echo valid_output($unit_value); ?>" size="8" onchange="javascript:unit_validation();round_up(this.id,this.value,2);"/></td>
					<td ><input type="text" name="<?php echo $commercial_value; ?>" size="8" readonly id="<?php echo $commercial_value; ?>" onchange="javascript:commercial_value_validation()" value="<?php echo valid_output($_POST[$commercial_value]); ?>"  /></td>
				</tr>
				<tr>
					<td class="message_mendatory"><?php if(isset($error["full_description_error_".$i]) && $error["full_description_error_".$i]!=''){ echo $error["full_description_error_".$i];} ?></td>
					<td class="message_mendatory"><?php if(isset($error["qty_error_".$i]) && $error["qty_error_".$i]!=''){ echo $error["qty_error_".$i];} ?></td>
					<td>&nbsp;</td>
					<td class="message_mendatory"><?php if(isset($error["unit_value_error_".$i]) && $error["unit_value_error_".$i]!=''){ echo $error["unit_value_error_".$i];} ?></td>
					<td class="message_mendatory"><?php if(isset($error["commercial_value_error_".$i]) && $error["commercial_value_error_".$i]!=''){ echo $error["commercial_value_error_".$i];} ?></td>
				</tr>
				<?php }?>
				<?php 
				
				
				}else
					{
						$minimum_display = (count($CommercialInvoiceItemDataVal)<=5)?(5):(count($CommercialInvoiceItemDataVal));
					
						
						
						$CommercialInvoiceItemArray = array();
						$t=1;
						foreach($CommercialInvoiceItemDataVal as $InvoiceItemDataVal){
							//echo "<pre>";print_r($InvoiceItemDataVal['id']);exit();
							$CommercialInvoiceItemArray[$t]['commercial_description'] = $InvoiceItemDataVal['commercial_description'];
							$CommercialInvoiceItemArray[$t]['commercial_currency'] = $InvoiceItemDataVal['commercial_currency'];
							$CommercialInvoiceItemArray[$t]['commercial_unit_value'] = $InvoiceItemDataVal['commercial_unit_value'];
							$CommercialInvoiceItemArray[$t]['commercial_qty'] = $InvoiceItemDataVal['commercial_qty'];
							$CommercialInvoiceItemArray[$t]['commercial_value'] =  $InvoiceItemDataVal['commercial_value'];
							$CommercialInvoiceItemArray[$t]['id'] =  $InvoiceItemDataVal['id'];
							$t = $t+1;
						}
						for($i=1;$i<=$minimum_display;$i++){
							if(!key_exists($i,$CommercialInvoiceItemArray)){
								$CommercialInvoiceItemArray[$i]['commercial_description'] = '';
								$CommercialInvoiceItemArray[$i]['commercial_currency'] = '';
								$CommercialInvoiceItemArray[$i]['commercial_unit_value'] = '';
								$CommercialInvoiceItemArray[$i]['commercial_qty'] = '';
								$CommercialInvoiceItemArray[$i]['commercial_value']= '';
								$CommercialInvoiceItemArray[$i]['id']= '';
							}
						}
						
						for ($count=1;$count<=$minimum_display;$count++){
							$qty[$count]="qty_".$count;
							$currency[$count] ="currency_".$count;
							$unit_value[$count]="unit_value_".$count;
							$commercial_value[$count]="commercial_value_".$count;
							$unique_id[$count]="id_".$count;
							$full_description[$count] ="full_description_".$count;
					?>
				
				<tr>
					<td><input class="input_full_description" type="text" name="<?php echo $full_description[$count]; ?>" id="" value="<?php echo (!isset($CommercialInvoiceItemArray[$count]['commercial_description']))?($_POST[$full_description[$count]]):(valid_output($CommercialInvoiceItemArray[$count]['commercial_description']));?>" /></td>
					<td><input type="text" name="<?php echo $qty[$count]; ?>" id="<?php echo $qty[$count]; ?>" class="input_qty"  value="<?php  echo (!isset($CommercialInvoiceItemArray[$count]['commercial_qty']))?($_POST[$qty[$count]]):($CommercialInvoiceItemArray[$count]['commercial_qty']);?>" maxlength="5" size="5" onchange="javascript:qty_validation(<?php echo $minimum_display;?>);round_up(this.id,this.value,0);" /></td>
					<td align="center">
						<select id="<?php echo $currency[$count]; ?>" name="<?php echo $currency[$count]; ?>">
							<option <?php (!empty($CommercialInvoiceItemArray[$count]['commercial_currency'])?((valid_output($CommercialInvoiceItemArray[$count]['commercial_currency'])=="INR")?("selected"):("")):(""));?>>INR</option>
							<option <?php (!empty($CommercialInvoiceItemArray[$count]['commercial_currency'])?((valid_output($CommercialInvoiceItemArray[$count]['commercial_currency'])=="AUD")?("selected"):("")):(""));?>>AUD</option>
							<option <?php (!empty($CommercialInvoiceItemArray[$count]['commercial_currency'])?((valid_output($CommercialInvoiceItemArray[$count]['commercial_currency'])=="GBP")?("selected"):("")):(""));?>>GBP</option>
						</select>
					
					</td>
					<td><input type="text"  value="<?php echo (!isset($CommercialInvoiceItemArray[$count]['commercial_unit_value']))?($_POST[$unit_value[$count]]):($CommercialInvoiceItemArray[$count]['commercial_unit_value']); ?>"  name="<?php echo $unit_value[$count]; ?>" align="right" class="input_value" id="<?php echo $unit_value[$count]; ?>" size="8" onchange="javascript:unit_validation();round_up(this.id,this.value,2);"/></td>
					<td ><input type="text" name="<?php echo $commercial_value[$count]; ?>" size="8" id="<?php echo $commercial_value[$count]; ?>" onchange="javascript:commercial_value_validation()" value="<?php echo (!isset($CommercialInvoiceItemArray[$count]['commercial_value']))?($_POST[$commercial_value[$count]]):($CommercialInvoiceItemArray[$count]['commercial_value']); ?>"  />
					<input type="hidden" name="<?php echo $unique_id[$count];?>"  id="" value="<?php echo (!empty($CommercialInvoiceItemArray[$count]['id'])?($CommercialInvoiceItemArray[$count]['id']):("")); ?>" />
					</td>
				</tr>
				<?php
						}
					}
					
				 ?>
					
				</tr>
					<tr>
					<td></td>
					<td></td>
					<td></td>
					<td><?php echo COMMERCIAL_TOTAL; ?></td>
					<td><input type="text" name="commercial_total_value" readonly id="commercial_total_value" size="8" value="<?php if($CommercialInvoiceData['commercial_total']==""){echo $_POST['commercial_total_value'];}else{echo $CommercialInvoiceData['commercial_total'];} ?>"  /></td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td><?php echo COMMERCIAL_COUNTRY_MANUFACTURER; ?></td>
		<td ><?php $allCountry = $CountryMasterObj->getCountry();
	$countryOutput='<select name="country_of_manufacturing" id="country_of_manufacturing" tabindex="'.$index.'" ' . $extra_param . ' >
		<option value="">'.COMMON_SELECT_COUNTRY.'</option>';
		if ($allCountry != '') {
			foreach ($allCountry as $Country) {
				$countryOutput.='<option value="'.$Country->countries_id.'"';
				if(isset($selectCountryId)&&$selectCountryId!=''){
					if($Country->countries_id==$selectCountryId){ $countryOutput.='selected'; } 
					if($Country->countries_id==COUNTRY_SELECT && $selectCountryId==''){ $countryOutput.='selected';}
				} else {
					if(isset($_GET["country"])){
						$countryOutput.='selected';
					} elseif($Country->countries_id==COUNTRY_SELECT) {
						$countryOutput.='selected';
					}
				}
				$countryOutput.='>'.valid_output($Country->countries_name).'</option>';
			}
		}
	$countryOutput.='</select>';
	echo $countryOutput; ?></td>
	</tr>
	<tr>
																	<td align="left" valign="middle">&nbsp;</td>
																	<td align="left" valign="top" class="message_mendatory" id="PickUpError"></td>
																	<td align="left" valign="middle">&nbsp;</td>
																	<td align="left" valign="top" class="message_mendatory" id="DeliverToError"></td>
																</tr>	
	<tr>
		
		<td><?php echo COMMERCIAL_SIGNATURE_OF_EXPORTER; ?></td>
		
		<td><?php echo COMMERCIAL_DATE; ?></td>
	</tr>
	
	<tr>
		<td ></td>
		
		<td height="30%"><input type="text" name="commercial_invoice_date" readonly value="<?php if($CommercialInvoiceData['commercial_invoice_date']==""){echo $today = date('d M  Y');}else{echo valid_output($CommercialInvoiceData['commercial_invoice_date']);}  ?>" /></td>
	</tr>
	<tr>
																	<td align="left" valign="middle">&nbsp;</td>
																	<td align="left" valign="top" class="message_mendatory" id="PickUpError"></td>
																	<td align="left" valign="middle">&nbsp;</td>
																	<td align="left" valign="top" class="message_mendatory" id="DeliverToError"></td>
																</tr>	
	<tr>
		<td><?php echo COMMERCIAL_NAME; ?></td>
		<td><input type="text" name="commercial_name" value="<?php if($CommercialInvoiceData['commercial_name']==""){echo valid_output($_POST['commercial_name']);}else{echo valid_output($CommercialInvoiceData['commercial_name']);} ?>" /></td>
		
	</tr>
<tr>
	<td></td>
	<td class="message_mendatory"><?php if(isset($err['commercialnameError']) && $err['commercialnameError'] != ''){ echo $err['commercialnameError'];} ?></td>
	
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
											<input type="hidden" size="34" id="ptoken" value="<?php echo $ptoken; ?>" name="ptoken">
											<input type="submit" class="action_button" tabindex="36" name="submit" value="<?php echo $btnSubmit; ?>" onclick=" return commercial_validation(this.form);" >
											<input type="reset" tabindex="37" name="reset" class="action_button" value="<?php echo ADMIN_COMMON_BUTTON_RESET; ?>" >
											<input type="button"  class="action_button" name="cancel" tabindex="38" value="<?php echo ADMIN_COMMON_BUTTON_CANCEL;?>" onclick="javascript:document.location.href='<?php echo FILE_COMMERCIAL_INVOICE_LISTING.'?pagenum=$'.$pagenum; ?>';return true;"/>
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
<?php //require_once(DIR_WS_JSCRIPT."/jquery.php"); ?>