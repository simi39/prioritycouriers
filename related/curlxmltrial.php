<?php
session_start();
require_once("../lib/common.php");
require_once(DIR_WS_LIB ."functions.php");
require_once(DIR_WS_MODEL ."PostCodeMaster.php");
require_once(DIR_WS_MODEL ."InternationalZonesMaster.php");
require_once(DIR_WS_MODEL . "ServiceMaster.php");
require_once(DIR_WS_MODEL . "ProductLabelMaster.php");
/*
	We are not using this file because there is no address verification from ffdex integration
*/
/**
* Initialize the cURL session
*/
//$BookingDetailsMasterObj = BookingDetailsMaster::create();
//$BookingDetailsDataObj = new BookingDetailsData();

$PostCodeMasterObj = PostCodeMaster::create();
$PostCodedataObj = new PostCodeData();

$InternationalzonesMasterObj = InternationalZonesMaster::Create();
$InternationalDataobj= new InternationalZonesData();

$ObjServiceMaster	= ServiceMaster::Create();
$ServiceData		= new ServiceData();

$ObjProductLabelMaster	= ProductLabelMaster::Create();
$ProductLabelData		= new ProductLabelData();


$BookingDetailsDataObj = $__Session->GetValue("booking_details");
$bookingxmlval = new stdClass;
/*echo "<pre>";
print_r($BookingDetailsDataObj);
echo "</pre>";*/
foreach ($BookingDetailsDataObj as $key=>$val) {
	$bookingxmlval->{$key}=$val;
	$$key=$val;
}

$BookingItemDetailsDataObj = $__Session->GetValue("booking_details_items");
if (!empty($BookingItemDetailsDataObj)) {
    $BookingItemDetailsData = new stdClass;
    foreach ($BookingItemDetailsDataObj as $key => $val) {
        $BookingItemDetailsData1 = new stdClass;
        foreach ($val as $kky => $val1) {
            $BookingItemDetailsData1->{$kky} = $val1;
        }
        $BookingItemDetailsData->{$key} = $BookingItemDetailsData1;
    }
}
$bookingidXml = generatebookigid($bookingxmlval);
$__Session->SetValue("booking_id",$bookingidXml);
$__Session->Store();
if($bookingxmlval->flag=="australia")
{
	//$bookingidXml="OCDMS000".$bookingxmlval->booking_id;
	$deliverid=$bookingxmlval->deliveryid;
	$deliverseaArr[0] = array('Search_On'    => 'FullName',
	                      'Search_Value' => $deliverid,
	                      'Type'         => 'string',
	                      'Equation'     => '=',
	                      'CondType'     => '',
	                      'Prefix'       => '',
	                      'Postfix'      => '');
	$PostCodedataObj=$PostCodeMasterObj->getPostCode(null,null,$deliverseaArr);
	$PostCodedata=$PostCodedataObj[0];

	$receivercountrycode="AU";
	$receiverLocName=$PostCodedata->Name;
	$receiverLocPostcode=$PostCodedata->Postcode;
	$receiverState=$PostCodedata->State;
	$receiverZone=$PostCodedata->Zone;
}
else
{
	//$bookingidXml="ICNT000".$bookingxmlval->booking_id;
	$deliverid=$bookingxmlval->deliveryid;
	$deliverseaArr[0] = array('Search_On'    => 'id',
	                      'Search_Value' => $deliverid,
	                      'Type'         => 'int',
	                      'Equation'     => '=',
	                      'CondType'     => '',
	                      'Prefix'       => '',
	                      'Postfix'      => '');
	$InternationalDataobj=$InternationalzonesMasterObj->getInternationalZones(null,$deliverseaArr);
	$interCodedata=$InternationalDataobj[0];

	//$receivercountrycode=$interCodedata->country;
	$receivercountrycode="AU";
	$receiverLocName=$bookingxmlval->reciever_suburb;
	$receiverLocPostcode=$bookingxmlval->reciever_postcode;
	$receiverState=$bookingxmlval->reciever_state;
	$receiverZone=$interCodedata->zone;


}
$datetime=$bookingxmlval->date_ready." ".$bookingxmlval->time_ready;
$total_weight=$bookingxmlval->total_weight;
$total_qty=$bookingxmlval->total_qty;
$senderName=$bookingxmlval->sender_first_name." ".$bookingxmlval->sender_surname;
$service_name=$bookingxmlval->service_name;
if(empty($service_name)){
	$service_name="international";
}
if($service_name=="international")
{
	$service_name="DEE";
}
else {

	$fieldArr=array("*");
	$ServiceSear=array();
	$ServiceSear[]= array('Search_On'=>'service_name', 'Search_Value'=>$service_name, 'Type'=>'string', 'Equation'=>'=', 'CondType'=>'AND', 'Prefix'=>'', 'Postfix'=>'');
	$service_data = $ObjServiceMaster->getService($fieldArr,$ServiceSear);
	$service_data=$service_data[0];
	$product_code_id=$service_data["product_code_id"];


	$fieldArr=array("*");
	$seaByArr=array();
	$seaByArr[]=array('Search_On'=>'auto_id', 'Search_Value'=>$product_code_id, 'Type'=>'int', 'Equation'=>'=', 'CondType'=>'', 'Prefix'=>'and', 'Postfix'=>'');
	$DataService=$ObjProductLabelMaster->getProductLabel($fieldArr,$seaByArr); // Fetch Data

	$DataService = $DataService[0];
	$service_name=$DataService["product_code"];

}

$senderaddress1=$bookingxmlval->sender_address_1;
$senderaddress2=$bookingxmlval->sender_address_2;
$senderaddress3=$bookingxmlval->sender_address_3;
$senderPhoneNO=$bookingxmlval->sender_contact_no;
$senderEmail=$bookingxmlval->sender_email;
$pickupid=$bookingxmlval->pickupid;
$pickupseaArr[] = array('Search_On'    => 'FullName',
                      'Search_Value' => $pickupid,
                      'Type'         => 'string',
                      'Equation'     => '=',
                      'CondType'     => '',
                      'Prefix'       => '',
                      'Postfix'      => '');
$PostCodedataObj=$PostCodeMasterObj->getPostCode(null,null,$pickupseaArr);
$PostCodedata=$PostCodedataObj[0];

$senderLocName=$PostCodedata->Name;
$senderLocPostcode=$PostCodedata->Postcode;
$senderState=$PostCodedata->State;
$senderZone=$PostCodedata->Zone;

///Receiver
$receiverName=$bookingxmlval->reciever_firstname." ".$bookingxmlval->reciever_surname;
$receiverAddress1=$bookingxmlval->reciever_address_1;
$receiverAddress2=$bookingxmlval->reciever_address_2;
$receiverAddress3=$bookingxmlval->reciever_address_3;
$receiverPhoneNo=$bookingxmlval->reciever_contact_no;
$receiverEmail=$bookingxmlval->reciever_email;
$goodDescription=$bookingxmlval->description_of_goods;
$valueOfGoods=$bookingxmlval->values_of_goods;

//$ch = curl_init();
//
//echo "reciever code:".$receivercountrycode;

$xmlString=("<?xml version='1.0' encoding='ISO-8859-1' ?><WSGET><AccessRequest><WSVersion>WS1.1</WSVersion><FileType>19</FileType><Action>upload</Action><EntityID>6FC39A3131DD95C2CB2DF21A9784FE3B</EntityID><EntityPIN>WS_EPORTAL</EntityPIN><MessageID>".$bookingidXml."</MessageID><AccessID>PRIORITY_ID</AccessID><AccessPIN>ngy8jo9</AccessPIN><CreatedDateTime>".$datetime."</CreatedDateTime><CarrierSID>822</CarrierSID></AccessRequest><CMDetail><CC><CCLabelReq>Y</CCLabelReq><CCAccCardCode>".$bookingidXml."</CCAccCardCode><CCCustDeclaredWeight>".$total_weight."</CCCustDeclaredWeight><CCWeightMeasure>Kgs</CCWeightMeasure><CCNumofItems>".$total_qty."</CCNumofItems><CCSTypeCode>".$service_name."</CCSTypeCode><CCSenderName>".$senderName."</CCSenderName><CCSenderAdd1>".$senderaddress1."</CCSenderAdd1><CCSenderAdd2>".$senderaddress2."</CCSenderAdd2><CCSenderAdd3>".$senderaddress3."</CCSenderAdd3><CCSenderLocCode>BNE</CCSenderLocCode><CCSenderLocName>".$senderLocName."</CCSenderLocName><CCSenderLocState>".$senderState."</CCSenderLocState><CCSenderLocPostcode>".$senderLocPostcode."</CCSenderLocPostcode><CCSenderLocCtryCode>BNE</CCSenderLocCtryCode><CCSenderContact>".$senderName."</CCSenderContact><CCSenderPhone>".$senderPhoneNO."</CCSenderPhone><CCSenderEmail>".$senderEmail."</CCSenderEmail><CCReceiverName>".$receiverName."</CCReceiverName><CCReceiverAdd1>".$receiverAddress1."</CCReceiverAdd1><CCReceiverAdd2>".$receiverAddress2."</CCReceiverAdd2><CCReceiverAdd3>".$receiverAddress3."</CCReceiverAdd3><CCReceiverLocCode>BNE</CCReceiverLocCode><CCReceiverLocName>".$receiverLocName."</CCReceiverLocName><CCReceiverLocState>".$receiverState."</CCReceiverLocState><CCReceiverLocPostcode>".$receiverLocPostcode."</CCReceiverLocPostcode><CCReceiverLocCtryCode>".$receivercountrycode."</CCReceiverLocCtryCode><CCReceiverContact>".$receiverName."</CCReceiverContact><CCReceiverPhone>".$receiverPhoneNo."</CCReceiverPhone><CCReceiverEmail>".$receiverEmail."</CCReceiverEmail><CCWeight>".$total_weight."</CCWeight><CCSenderRef1></CCSenderRef1><CCSenderRef2></CCSenderRef2><CCSenderRef3></CCSenderRef3><CCCustomsValue>0.0000</CCCustomsValue><CCCustomsCurrencyCode>AUD</CCCustomsCurrencyCode><CCClearanceRef></CCClearanceRef><CCCubicLength>10</CCCubicLength><CCCubicWidth>10</CCCubicWidth><CCCubicHeight>10</CCCubicHeight><CCCubicMeasure>Kgs</CCCubicMeasure><CCCODAmount>100.0000</CCCODAmount><CCCODCurrCode>USD</CCCODCurrCode><CCBag>3</CCBag><CCNotes></CCNotes><CCSystemNotes></CCSystemNotes><CCOriginLocCode>BNE</CCOriginLocCode><CCBagNumber></CCBagNumber><CCCubicWeight>0</CCCubicWeight><CCDeadWeight>0</CCDeadWeight><CCDeliveryInstructions></CCDeliveryInstructions><CCGoodsDesc>".$goodDescription."</CCGoodsDesc><CCSenderFax></CCSenderFax><CCReceiverFax></CCReceiverFax><CCGoodsOriginCtryCode>BNE</CCGoodsOriginCtryCode><CCReasonExport>PERMANENT</CCReasonExport><CCShipTerms>DDU</CCShipTerms><CCDestTaxes></CCDestTaxes><CCManNoOfShipments>1</CCManNoOfShipments><CCSecurity>0.0000</CCSecurity><CCInsurance>0.0000</CCInsurance><CCInsuranceCurrCode>USD</CCInsuranceCurrCode><CCSerialNo></CCSerialNo><CCReceiverPhone2></CCReceiverPhone2><CCCreateJob>Y</CCCreateJob><CCSurcharge></CCSurcharge><CCIsValidate>Y</CCIsValidate></CC></CMDetail></WSGET>");


$data = array();
//$data['Username']='pmgusr';
//data['Password']='p@ssw0rd88';
$data['Username']='9B948D40DCF977EE65A95A424A543A34';
$data['Password']='EE4C5439A0CEB17D7159D53D08ADA548';
$data['xmlStream']=$xmlString;
$data['LevelConfirm']='detail';

$post_str = '';
foreach($data as $key=>$val) {
	$post_str .= $key.'='.$val.'&';
}
$post_str = substr($post_str, 0, -1);
//echo $post_str;
$ch = curl_init();
//original linkcurl_setopt($ch, CURLOPT_URL, 'http://ws05.ffdx.net/getshipping_ws/v8/service_getshipping.asmx/UploadCMawbWithLabelToServer');
curl_setopt($ch, CURLOPT_URL, 'https://ws05.ffdx.net/ffdx_ws/v12/service_customer.asmx/UploadCMawbWithLabelToServer');
curl_setopt($ch, CURLOPT_POST, TRUE);
curl_setopt($ch, CURLOPT_POSTFIELDS, $post_str);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
$result = curl_exec($ch);
curl_close($ch);

$pxml = simplexml_load_string($result);
$result = xml2array($pxml);


$storeData=$result['WSGET']['Validation_attr']['status'];

if($storeData=="SUCCESS") {
	if(isset($_GET['Action']) && $_GET['Action']=='edit') {
			//echo "inside";
			show_page_header(FILE_CHECKOUT,true);
			exit();
	}else{
			show_page_header(FILE_ADDITIONAL_DETAILS,true);
			exit();
	}
}
else
{
	$message=$result['WSGET']['Validation']['Message'];
	if(defined('SES_USER_ID')){
		show_page_header(FILE_BOOKING_WITH_ADDRESS."?error="." CCTYPE ERROR : ".$message,true);
		exit();

	}else{
		show_page_header(FILE_ADDRESSES."?error="." CCTYPE ERROR : ".$message,true);
		exit();
	}
}


?>
