<?php

/**
 * This function will return select box for country used in addressnew.php,profile.php
 *
 * @param unknown_type $CountryMasterObj object for company details
 * @return string
 */
function getDropeCountry($selectCountryId,$index=null, $extra_param=null,$name=null) {

	require_once(DIR_WS_MODEL . "CountryMaster.php");

	$CountryMasterObj = new CountryMaster();
	$CountryMasterObj = $CountryMasterObj->Create();
	$seaArr=array();
	$seaArr[] = array('Search_On'=>'status','Search_Value'=>'A', 'Type'=>'string', 'Equation'=>'=', 'CondType'=>'AND', 'Prefix'=>'', 'Postfix'=>'');
	$allCountry = $CountryMasterObj->getCountry(null,$seaArr);
	if(empty($name))
	{
		$name = 'country';
		$id = 'country';
	}
	$id = $name;

	$countryOutput='<select name="'.$name.'" id="'.$id.'" tabindex="'.$index.'" ' . $extra_param . ' >
		<option value="">'.COMMON_SELECT_COUNTRY.'</option>';
		if ($allCountry != '') {
			foreach ($allCountry as $Country) {
				$countryOutput.='<option value="'.$Country->countries_id.'"';
				if(isset($selectCountryId)&&$selectCountryId!=''){
					if($Country->countries_id==$selectCountryId){ $countryOutput.='selected'; }
					if($Country->countries_id==COUNTRY_SELECT && $selectCountryId==''){ $countryOutput.='selected';}
				} else {
					if(isset($_POST["country"])){
						$countryOutput.='selected';
					}elseif($Country->countries_id==COUNTRY_SELECT) {
						$countryOutput.='selected';
					}
				}
				$countryOutput.='>'.$Country->countries_name.'</option>';
			}
		}
	$countryOutput.='</select>';
	return $countryOutput;
}

function getItemType($selectItemId,$index=null, $extra_param=null,$item_name=null,$country=null,$admin=null)
{
	require_once(DIR_WS_MODEL . "ItemTypeMaster.php");
	require_once(DIR_WS_MODEL . "InternationalItemTypeMaster.php");
	define("SELECT_ONE_TYPE","Select Package Type");
	define("ITEM_SELECT","Select Item");
	//Mail constants

	$ItemTypeMasterObj = new ItemTypeMaster();
	$ItemTypeMasterObj = $ItemTypeMasterObj->create();

	//$package_type = "Select the type of package you are sending.";
	if($country=="inter"){
		if($item_name!="")
		{
			$itemname="inter_ShippingType[]";
			 $itemid="inter_ShippingType_".$item_name;
		}
		else
		{
			$itemname="inter_ShippingType[]";
			$itemid="inter_ShippingType_1";

		}

	}else{
		if($item_name!="")
		{
			$itemname="selShippingType[]";
			 $itemid="selShippingType_".$item_name;
		}
		else
		{
			$itemname="selShippingType[]";
			$itemid="selShippingType_1";

		}
	}
	if($country=="inter")

		$item_row=explode("_",$itemname);

		if($country=="inter")
		{
			$seaArr[] = array('Search_On'    => 'type',
			                      'Search_Value' => 'international',
			                      'Type'         => 'string',
			                      'Equation'     => '=',
			                      'CondType'     => 'AND',
			                      'Prefix'       => '',
			                      'Postfix'      => '');
		}else{
			$seaArr[] = array('Search_On'    => 'type',
			                      'Search_Value' => $country,
			                      'Type'         => 'string',
			                      'Equation'     => '=',
			                      'CondType'     => 'AND',
			                      'Prefix'       => '',
			                      'Postfix'      => '');
		}
		$optArr[]	=	array("Order_By" => "sorting",
									"Order_Type" => "ASC");
		$allItem = $ItemTypeMasterObj->getItemType(null,$seaArr,$optArr);

		//$ItemOutput ='<select name="'.$itemname.'" id="'.$itemname.'" tabindex="'.$index.'" ' . $extra_param . ' onchange="aust_item(this.value,'.$item_row[1].')" >
		/*if($admin == "")
		{
			$changecondition = 'onchange="return display_size(this.value,1)"';
		}*/
		if($item_name==''){

			if($country=="inter")
			{

				$ItemOutput ='<select  name="'.$itemname.'" id="'.$itemid.'" tabindex="'.$index.'" '.$extra_param.'>
		<option value="">'.SELECT_ONE_TYPE.'</option>';

			}
			else
			{

				/*$ItemOutput ='<select name="'.$itemname.'"  id="'.$itemid.'" tabindex="'.$index.'" ' . $extra_param . ' '.$changecondition.'><option value="">'.SELECT_ONE_TYPE.'</option>';*/
				$ItemOutput ='<select name="'.$itemname.'"  id="'.$itemid.'" tabindex="'.$index.'" ' . $extra_param . '><option value="">'.SELECT_ONE_TYPE.'</option>';
			}

		if ($allItem != '') {
				foreach ($allItem as $Item) {
					$ItemOutput.='<option value="'.$Item->item_id.'"';
					if(isset($selectItemId)&&$selectItemId!=''){
						if($Item->item_id==$selectItemId){ $ItemOutput.='selected'; }
						if($Item->item_id==ITEM_SELECT && $selectItemId==''){  $ItemOutput.='selected'; }
					} else {
						if(isset($_POST["item_1"])){
							$ItemOutput.='selected';
						} elseif($Item->item_id==ITEM_SELECT) {
							$ItemOutput.='selected';
						}
					}
					$ItemOutput.='>'.$Item->item_name.'</option>';
				}
			}

		$ItemOutput.='</select>';
		return $ItemOutput;

		}
		else {
			if($country=="inter")
			{
				$ItemOutput ='<select name="'.$itemname.'" id="'.$itemid.'" tabindex="'.$index.'" ' . $extra_param . ' >
		<option value="">'.SELECT_ONE_TYPE.'</option>';
			}
			else
			{
							$ItemOutput ='<select name="'.$itemname.'" id="'.$itemid.'" tabindex="'.$index.'" ' . $extra_param . ' onchange="return display_size(this.value,'.$item_name.')" ><option value="">'.SELECT_ONE_TYPE.'</option>';
			}

		if ($allItem != '') {
				foreach ($allItem as $Item) {
					$ItemOutput.='<option value="'.$Item->item_id.'"';
					if(isset($selectItemId)&&$selectItemId!=''){
						if($Item->item_id==$selectItemId){ $ItemOutput.='selected'; }
						if($Item->item_id==ITEM_SELECT && $selectItemId==''){  $ItemOutput.='selected'; }
					} else {
						if(isset($_POST["item_1"])){
							$ItemOutput.='selected';
						} elseif($Item->item_id==ITEM_SELECT) {
							$ItemOutput.='selected';
						}
					}
					$ItemOutput.='>'.$Item->item_name.'</option>';
				}
			}
		$ItemOutput.='</select>';
		return $ItemOutput;

		}

}



function getItemTypeIndex($selectItemId,$index=null, $extra_param=null,$item_name=null,$country=null)
{
	require_once(DIR_WS_MODEL . "ItemTypeMaster.php");

	if($country=="inter")
	{
		if($item_name!="")
		{
			$itemname="inter_ShippingType[]";
			 $itemid="inter_ShippingType_".$item_name;
		}
		else
		{
			$itemname="inter_ShippingType[]";
			$itemid="inter_ShippingType_1";

		}

	}else
	{
		if($item_name!="")
		{
			$itemname="selShippingType[]";
			 $itemid="selShippingType_".$item_name;
		}
		else
		{
			$itemname="selShippingType[]";
			$itemid="selShippingType_1";

		}
	}

	$item_row=explode("_",$itemname);
	$seaArr = array();
	if($country=="inter")
	{
		$seaArr[] = array('Search_On'    => 'type',
							  'Search_Value' => 'international',
							  'Type'         => 'string',
							  'Equation'     => '=',
							  'CondType'     => 'AND',
							  'Prefix'       => '',
							  'Postfix'      => '');
	}else{

		$seaArr[] = array('Search_On'    => 'type',
						  'Search_Value' => $country,
						  'Type'         => 'string',
						  'Equation'     => '=',
						  'CondType'     => 'AND',
						  'Prefix'       => '',
						  'Postfix'      => '');
	}
		$seaArr[] = array('Search_On'    => 'item_name',
						  'Search_Value' => QUICKQUOTE,
						  'Type'         => 'string',
						  'Equation'     => '=',
						  'CondType'     => 'AND',
						  'Prefix'       => '',
						  'Postfix'      => '');
	$ItemTypeMasterObj = new ItemTypeMaster();
	$ItemTypeMasterObj = $ItemTypeMasterObj->create();
	$allItem = $ItemTypeMasterObj->getItemType('null',$seaArr);
	$allItem = $allItem[0];
	if($item_name=='' && $allItem != ''){
		$ItemOutput ='<input type="hidden" name="'.$itemname.'" id="'.$itemid.'" value="'.$allItem['item_id'].'"/>';
		return $ItemOutput;
	}
}

function draw_separator($width = '100%', $height = '1') {
	return '<img src="' . DIR_HTTP_COMMONIMAGES. 'pixel_trans.gif" border="0" width="'.$width.'" height="'.$height.'" />';
}
function booking_id_drop_down_box($userid){

	require_once(DIR_WS_MODEL ."BookingDetailsMaster.php");

	$BookingDetailsMasterObj = new BookingDetailsMaster();
	$BookingDetailsMasterObj = $BookingDetailsMasterObj->create();
	$BookingDetailsDataObj = new BookingDetailsData();


	/**
	 *
	 * Just to track the couriers(for tracking numbers)
	 *
	 */
	$seaArrTrack[] = array('Search_On'    => 'userid',
	'Search_Value' => $userid,
	'Type'         => 'int',
	'Equation'     => '=',
	'CondType'     => 'AND',
	'Prefix'       => '',
	'Postfix'      => '');
	$seaArrTrack[] = array('Search_On'    => 'CCConnote',
	'Search_Value' => "null",
	'Type'         => 'string',
	'Equation'     => '!=',
	'CondType'     => 'AND',
	'Prefix'       => '',
	'Postfix'      => '');
	$trackingfieldArr = ("CCConnote");
	$trackingNumberDetail= $BookingDetailsMasterObj->getBookingDetails($trackingfieldArr,$seaArrTrack);
	if($trackingNumberDetail=="")
	{
		$trackingNumberDetail=0;
	}
	return $trackingNumberDetail;
}

function lightBoxCmsDesc($cmsDetail)
{
	$htmloutput ='<div class="modal hide fade" id="div_'.valid_output($cmsDetail->page_name).'">
	<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal">×</button>
	<h3>'.valid_output($cmsDetail->page_heading).'</h3>
	</div>
	<div class="modal-body"><p>'.$cmsDetail->page_content.'</p></div>
	<div class="modal-footer"><a href="#" class="btn-u" data-dismiss="modal">Close</a></div>
   </div>';
   return $htmloutput;

}
function convertToPDF($content='',$path_to_pdf,$html_url='')
{
	require_once(DIR_WS_PDF.'html2pdf.class.php');
	if(!empty($html_url))
	{
		$standard_content = fopen($html_url, "rb");
		$content = stream_get_contents($standard_content);
	}
	try
    {
        $html2pdf = new HTML2PDF('P', 'A4', 'en', true, 'UTF-8', array(15, 5, 15, 5));
        $html2pdf->pdf->SetDisplayMode('fullpage');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        $html2pdf->Output($path_to_pdf,'F');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }

}
function convertToDOMPDF($content='')
{
	require_once(DIR_WS_PDF.'dompdf/dompdf_config.inc.php');
	$dompdf = new DOMPDF();
	$dompdf->load_html($content);
	$dompdf->render();
	$dompdf->stream("sample.pdf");

}
function convertToTCPDF($content='',$path_to_pdf,$html_url='')
{
	require_once(DIR_WS_PDF.'tcpdf/examples/tcpdf_include.php');
	// create new PDF document
	$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

	$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('TCPDF Example 061');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 061', PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font
$pdf->SetFont('helvetica', '', 10);

// add a page
$pdf->AddPage();

	// Set some content to print

	$html = <<<EOD
$content
EOD;

	// Print text using writeHTMLCell()
	//$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
	$pdf->writeHTML($html, true, false, true, false, '');

	// ---------------------------------------------------------

	// Close and output PDF document
	// This method has several options, check the source code documentation for more information.
	//$pdf->Output($path_to_pdf, 'FD');
	$pdf->Output($path_to_pdf, 'I');
}
?>
