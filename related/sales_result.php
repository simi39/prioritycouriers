<?php
/****
 * Code in this file is used to write and save in pdf files
 * whatever parameters are coming from sales.php file
 * 
 */
require_once("../lib/common.php");
require_once(DIR_WS_MODEL . "UserMaster.php");
require_once(DIR_WS_MODEL ."CountryMaster.php");
require_once(DIR_WS_MODEL . "BookingDetailsMaster.php");
require_once(DIR_WS_RELATED.'/vendor/autoload.php');
require_once(DIR_WS_ADMIN_LANGUAGES . DIR_CURRENT_LANGUAGE. '/sales.php');
use Dompdf\Dompdf;

$path_to_pdf = DIR_WS_ONLINEPDF."tmp_pdf/sales_report.pdf";

$ObjBookingDetailsMaster	= new BookingDetailsMaster();
$ObjBookingDetailsMaster	= $ObjBookingDetailsMaster->Create();
$BookingDetailsData		= new BookingDetailsData();

$CountryMasterObj = CountryMaster::create();
$CountryDataObj = new CountryData();

$ObjUserMaster		= new UserMaster();
$ObjUserMaster		= $ObjUserMaster->Create();
$UserData			= new UserData();

if(isset($_REQUEST['fromDt']) && !empty($_REQUEST['fromDt'])){
    $fromDt =  date('Y-m-d', strtotime($_REQUEST['fromDt']));
}

if(isset($_REQUEST['toDt']) && !empty($_REQUEST['toDt'])){
    $toDt =  date('Y-m-d', strtotime($_REQUEST['toDt']));
}

if(isset($_REQUEST['userId']) && !empty($_REQUEST['userId'])){
    $userId =  $_REQUEST['userId'];
}

if(isset($_REQUEST['reportType']) && !empty($_REQUEST['reportType'])){
    $reportType =  $_REQUEST['reportType'];
}
/*
	To set variable for daily sales report
	compare To and From variable of date and 
	then check whether they are equal or not
*/
$hideColumns = false;
if(isset($reportType) && !empty($reportType) && $reportType == 1) {
	$tableHeading = SALES_REPORT;
} elseif(isset($reportType) && !empty($reportType) && $reportType == 2) {
	$tableHeading = SUMMARY_REPORT;
}

if(isset($fromDt) && isset($toDt)) {
	if(strtotime($fromDt) == strtotime($toDt)) {
		$hideColumns = true;
		$tableHeading = DAILY_SALES_REPORT;
	}	
}

if(isset($fromDt) && isset($toDt) && isset($userId) && $hideColumns == false) {
    $fieldArr = array("auto_id","userid","booking_date","CCConnote","total_qty","total_weight","deliveryid","pickupid","total_new_charge","gst_surcharge","total_delivery_fee");
    $optArr = array();
    $seaArr = array();

	
	if (is_numeric($userId)) {
		$seaArr[]=array('Search_On'=>'userid', 'Search_Value'=>$userId, 'Type'=>'int', 'Equation'=>'=', 'CondType'=>'AND', 'Prefix'=>'', 'Postfix'=>'AND booking_date');
		$seaArr[]=array('Search_On'=>'', 'Search_Value'=>$fromDt, 'Type'=>'string', 'Equation'=>'', 'CondType'=>'BETWEEN', 'Prefix'=>'CAST(', 'Postfix'=>'AS DATE)');
	} else {
		//$seaArr[]=array('Search_On'=>'', 'Search_Value'=>'', 'Type'=>'string', 'Equation'=>'', 'CondType'=>'', 'Prefix'=>'', 'Postfix'=>'');
		$seaArr[]=array('Search_On'=>'', 'Search_Value'=>$fromDt, 'Type'=>'string', 'Equation'=>'', 'CondType'=>'AND booking_date BETWEEN', 'Prefix'=>'CAST(', 'Postfix'=>'AS DATE)');
	}
	
	
    $seaArr[] = array('Search_On'=>'', 'Search_Value'=>$toDt, 'Type'=>'string', 'Equation'=>'', 'CondType'=>'AND', 'Prefix'=>'CAST(', 'Postfix'=>'AS DATE)');
   	if (isset($hideColumns) && $hideColumns == true) {
		$optArr[] = array("Order_By" => "auto_id","Order_Type" => "ASC");
	} else {
		$optArr[] = array("Order_By" => "userid","Order_Type" => "ASC");
	}
		
	$bookingDetailsDt=$ObjBookingDetailsMaster->getBookingDetails(null,$seaArr,$optArr);
	/* 
		Below code is to print content in tr body of table
	*/
	/*echo "<pre>";
	print_r($bookingDetailsDt);
	echo "</pre>";
	echo is_countable($bookingDetailsDt)."---".count($bookingDetailsDt)."</br>";
	exit();*/
	if(isset($bookingDetailsDt) && is_countable($bookingDetailsDt) && count($bookingDetailsDt)>0) {
		$trStr = '';
		$totaldeliverfee = 0;
		$i = 0;
		$checkUserId = '';
		/*
			Below Code is related with mentioned description
			According to particular userid 
			keep all the details of booking within that array of
			userid
		*/
		$userBookingDetails = array();
		$i=0;
		$tblHeStr = '';
		foreach($bookingDetailsDt as $bookingDetailsRow) {

			if($checkUserId != $bookingDetailsRow['userid']){
				$i = 0;
			}
			$userBookingDetails[$bookingDetailsRow['userid']][$i]['auto_id'] = $bookingDetailsRow['auto_id'];
			$userBookingDetails[$bookingDetailsRow['userid']][$i]['booking_date'] = $bookingDetailsRow['booking_date'];
			$userBookingDetails[$bookingDetailsRow['userid']][$i]['CCConnote'] = $bookingDetailsRow['CCConnote'];
			$userBookingDetails[$bookingDetailsRow['userid']][$i]['total_qty'] = $bookingDetailsRow['total_qty'];
			$userBookingDetails[$bookingDetailsRow['userid']][$i]['total_weight'] = $bookingDetailsRow['total_weight'];
			$userBookingDetails[$bookingDetailsRow['userid']][$i]['deliveryid'] = $bookingDetailsRow['deliveryid'];
			$userBookingDetails[$bookingDetailsRow['userid']][$i]['pickupid'] = $bookingDetailsRow['pickupid'];
			$userBookingDetails[$bookingDetailsRow['userid']][$i]['total_new_charge'] = $bookingDetailsRow['total_new_charge'];
			$userBookingDetails[$bookingDetailsRow['userid']][$i]['gst_surcharge'] = $bookingDetailsRow['gst_surcharge'];
			$userBookingDetails[$bookingDetailsRow['userid']][$i]['total_delivery_fee'] = $bookingDetailsRow['total_delivery_fee'];
			$checkUserId = $bookingDetailsRow['userid'];
			$i++;
		}
		/*echo "<pre>";
		print_r($userBookingDetails);
		echo "</pre>";
		exit();*/
		if (isset($userBookingDetails) && !empty($userBookingDetails)) {
			$k = 0;
			foreach ($userBookingDetails as $userid => $bookingVal) {
				/*echo "<pre>";
				print_r($bookingVal);
				echo "</pre>";*/
				$fieldArr = array("firstname","lastname","company");
				$usersearch = array();
				$usersearch[]=array('Search_On'=>'userid', 'Search_Value'=>$userid, 'Type'=>'int', 'Equation'=>'=', 'CondType'=>'AND', 'Prefix'=>'', 'Postfix'=>'');
				$DataUservalue =$ObjUserMaster->getUser($FieldArr, $usersearch); // Fetch Data
				$userDetails = $DataUservalue[0];
				if(isset($userDetails['company']) && !empty($userDetails['company'])){
					
					$username = $userDetails['company'];
				}else{
					$username = $userDetails['firstname'].' '.$userDetails['lastname'].' '. $userDetails['company'];
				}
				
				

				$tblHeStr .= '<table cellpadding="0" cellspacing="0" border="0" align="center" class="salesRpt">';
				$tblHeStr .= '<thead>';
				$tblHeStr .= '<tr>';
				if(isset($hideColumns) && !empty($hideColumns)) {
					$tblHeStr .= '<th colspan ="7">';
				} else {
					$tblHeStr .= '<th colspan ="8">';
				}
				
				$tblHeStr .= '<table cellpadding="0" cellspacing="0" border="0">';
				if(isset($hideColumns) && !empty($hideColumns)) {

				} else {
					$tblHeStr .= '<tr><td align="left"><strong>'.$userid.'--'.$username.'</strong></td></tr>';
				}
				$tblHeStr .= '<tr><td align="left"></td></tr>';
				$tblHeStr .= '</table>';
				$tblHeStr .= '</th>';
				$tblHeStr .= '</tr>';
				if(isset($k) && $k == 0) {
					$tblHeStr .= '<tr>';
					$tblHeStr .= '<th align="left"><table><tr><td class="genWhiteSpace">'.TBL_INVOICE_DATE.'</td><td class="genWhiteSpace">'.TBL_INVOICE_NO.'</td></tr></table></th>';
					
					if(isset($hideColumns) && !empty($hideColumns)) {
						
					}else{
						$tblHeStr .= '<th align="left">'.TBL_TRANSCATION_NO.'</th>';
					}
					
					if(isset($hideColumns) && !empty($hideColumns)) {
						$tblHeStr .= '<th align="left"><table><tr><td  align="left">Account No</td><td align="left">Account Name</td></tr></table></th>';
					}else{
						$tblHeStr .= '<th align="left"><table><tr><td  align="left">'.TBL_PIECES.'</td><td align="left">'.TBl_WEIGHT.'</td></tr></table></th>';
					}
					
					if(isset($hideColumns) && !empty($hideColumns)) {
						
					}else{
						$tblHeStr .= '<th align="left" colspan="2">'.TBL_FROM.'</th>';
						$tblHeStr .= '<th align="left" colspan="2">'.TBL_TO.'</th>';
					}
					
					$tblHeStr .= '<th align="right"><table border="0" align="right"><tr><td align="right">'.TBL_AMOUNT.'</td><td align="right">'.TBL_GST.'</td><td align="right">'.TBL_TOTAL.'</td></tr></table></th>';
					$tblHeStr .= '</tr>';
				}
				$tblHeStr .= '</thead>';
				
				$j = 0;
				$tblHeStr .= '<tbody>';
				$totaldeliverfee = array();
				$totalquantity = array();
				$totalweight = array();
				$totalnewcharge = array();
				$totalgst = array();
				foreach($bookingVal as $key => $val) {
					//echo $key."--".$val."</br>";
					$delivername = $bookingVal[$key]['deliveryid'];

					if(isset($bookingVal[$key]['deliveryid']) && is_numeric($bookingVal[$key]['deliveryid'])){

						
						$seabycountryArr[0] = array('Search_On'    => 'countries_id',
						'Search_Value' => $bookingVal[$key]['deliveryid'],
						'Type'         => 'int',
						'Equation'     => '=',
						'CondType'     => 'and ',
						'Prefix'       => '',
						'Postfix'      => '');
						$fieldArrforCountryName = array("countries_name");
						$CountryDataObj = $CountryMasterObj->getCountry($fieldArrforCountryName,$seabycountryArr);
						$CountryDataObj = $CountryDataObj[0];
						$delivername = $CountryDataObj['countries_name'];
					}
					$class = ($key%2 == 0)? 'whiteBackground': 'grayBackground';
					$tblHeStr .= '<tr class='.$class.'>';
					$tblHeStr .= '<td align="left"><table border="0"><tr><td align="left">'.date('Y-m-d', strtotime($bookingVal[$key]['booking_date'])).'</td><td>'.$bookingVal[$key]['auto_id'].'</td></tr></table></td>';
										
					if(isset($hideColumns) && !empty($hideColumns)) {
						//$tblHeStr .= '<td align="left"></td>';
					}else{
						$tblHeStr .= '<td align="left">'.$bookingVal[$key]['CCConnote'].'</td>';
					}
					
					if(isset($hideColumns) && !empty($hideColumns)) {
						$tblHeStr .= '<td  align="left"><table border="0" align="left"><tr><td  align="left">'.$userid.'</td><td  align="left">'.$username.'</td></tr></table></td>';
					}else{
						$tblHeStr .= '<td  align="left"><table border="0"  align="left"><tr><td  align="left">'.$bookingVal[$key]['total_qty'].'</td><td  align="left">'.$bookingVal[$key]['total_weight'].'</td></tr></table></td>';
					}
					
					if(isset($hideColumns) && !empty($hideColumns)) {
					
					}else{
						$tblHeStr .= '<td align="left" class="genWhiteSpace" colspan="2">'.$delivername.'</td>';
						$tblHeStr .= '<td align="left" class="genWhiteSpace" colspan="2">'.$bookingVal[$key]['pickupid'].'</td>';
					}
					
					$tblHeStr .= '<td align="right"><table align="right"><tr><td align="right">'.number_format($bookingVal[$key]['total_new_charge'],2).'</td><td align="right">'.number_format($bookingVal[$key]['gst_surcharge'],2).'</td><td align="right">'.number_format($bookingVal[$key]['total_delivery_fee'],2).'</td></tr></table></td>';
					$tblHeStr .= '</tr>';
					$totaldeliverfee[$userid] += $bookingVal[$key]['total_delivery_fee'];
					$totalquantity[$userid] += $bookingVal[$key]['total_qty'];
					$totalweight[$userid] += $bookingVal[$key]['total_weight'];
					$totalnewcharge[$userid] += $bookingVal[$key]['total_new_charge'];
					$totalgst[$userid] += $bookingVal[$key]['gst_surcharge'];
					$j++;
				}
				$total_new_charge = number_format($totalnewcharge[$userid],2);
				//echo $total_new_charge."</br>";
			//	exit();
				$tblHeStr .= '</tbody>';
				$tblHeStr .= '<tfoot>';
				$tblHeStr .= '<tr>';
				if(isset($hideColumns) && !empty($hideColumns)) {
					//$tblHeStr .= '<td align="left"></td>';
					$tblHeStr .= '<td align="center"><table><tr><td>'.TBL_TOTAL_JOBS.':'.$j.'</td></tr></table></td>';
				}else{
					$tblHeStr .= '<td align="right">'.TBL_TOTAL_JOBS.':'.$j.'</td>';
					$tblHeStr .= '<td align="center"><table><tr><td></td><td></td></tr></table></td>';	
				}
				
				
				if(isset($hideColumns) && !empty($hideColumns)) {
					$tblHeStr .= '<td align="left"><table><tr><td align="left"></td><td align="left"></td></tr></table></td>';			
				}else{
					$tblHeStr .= '<td align="left"><table><tr><td align="left">'.$totalquantity[$userid].'</td><td align="left">'.$totalweight[$userid].'</td></tr></table></td>';
					$tblHeStr .= '<td align="center" colspan="2"></td>';
					$tblHeStr .= '<td align="center" colspan="2"></td>';
					
				}
				$tblHeStr .= '<td align="right"><table align="right"><tr><td align="right">'.$total_new_charge.'</td><td align="right">'.number_format($totalgst[$userid],2).'</td><td align="right">'.number_format($totaldeliverfee[$userid],2).'</td></tr></table></td>';
				$tblHeStr .= '</tr>';
				$tblHeStr .= '</tfoot></table></br>';
				$k++;

			}
			
		}

		if (file_exists($path_to_pdf)) {
			unlink($path_to_pdf);
		}

		toPrintPDFFile($tableHeading,$tblHeStr,$hideColumns);

	}else{
		$errorMsg = RECORDS_NOT_FOUND;
		$data = array("error" => (( $errorMsg )));
		echo json_encode($data);
		exit();
	}
} elseif(isset($fromDt) && isset($toDt) && isset($userId) && $hideColumns == true) {
	
	/*  This is for Daily Sales report 
	 *
	*/

	$fieldArr = array("auto_id","userid","booking_date","CCConnote","total_qty","total_weight","deliveryid","pickupid","total_new_charge","gst_surcharge","total_delivery_fee");
    $optArr = array();
    $seaArr = array();
	if (is_numeric($userId)) {
		$seaArr[]=array('Search_On'=>'userid', 'Search_Value'=>$userId, 'Type'=>'int', 'Equation'=>'=', 'CondType'=>'AND', 'Prefix'=>'', 'Postfix'=>'AND booking_date');
		$seaArr[]=array('Search_On'=>'', 'Search_Value'=>$fromDt, 'Type'=>'string', 'Equation'=>'', 'CondType'=>'BETWEEN', 'Prefix'=>'CAST(', 'Postfix'=>'AS DATE)');
	} else {
		$seaArr[]=array('Search_On'=>'', 'Search_Value'=>$fromDt, 'Type'=>'string', 'Equation'=>'', 'CondType'=>'AND booking_date BETWEEN', 'Prefix'=>'CAST(', 'Postfix'=>'AS DATE)');
	}
	$seaArr[] = array('Search_On'=>'', 'Search_Value'=>$toDt, 'Type'=>'string', 'Equation'=>'', 'CondType'=>'AND', 'Prefix'=>'CAST(', 'Postfix'=>'AS DATE)');
	$optArr[] = array("Order_By" => "auto_id","Order_Type" => "ASC");

	$bookingDetailsDt = $ObjBookingDetailsMaster->getBookingDetails(null,$seaArr,$optArr);
	if(isset($bookingDetailsDt) && is_countable($bookingDetailsDt) && count($bookingDetailsDt)>0) {
		/*echo "<pre>";
		print_r($bookingDetailsDt);
		echo "</pre>";
		exit();
		*/
		$tblHeStr .= '<table cellpadding="0" cellspacing="0" border="0" align="center" class="salesRpt">';
		$tblHeStr .= '<thead>';
		$tblHeStr .= '<tr>';
		$tblHeStr .= '<th colspan ="7">';
		$tblHeStr .= '<table cellpadding="0" cellspacing="0" border="0">';
		$tblHeStr .= '<tr><td align="left"></td></tr>';
		$tblHeStr .= '</table>';
		$tblHeStr .= '</th>';
		$tblHeStr .= '</tr>';
		$tblHeStr .= '<tr>';
		$tblHeStr .= '<th align="left"><table><tr><td class="genWhiteSpace">'.TBL_INVOICE_DATE.'</td><td class="genWhiteSpace">'.TBL_INVOICE_NO.'</td></tr></table></th>';
		$tblHeStr .= '<th align="left"><table><tr><td  align="left">Account No</td><td align="left">Account Name</td></tr></table></th>';
		$tblHeStr .= '<th align="right"><table border="0" align="right"><tr><td align="right">'.TBL_AMOUNT.'</td><td align="right">'.TBL_GST.'</td><td align="right">'.TBL_TOTAL.'</td></tr></table></th>';
		$tblHeStr .= '</tr>';
		$tblHeStr .= '</thead>';
		$tblHeStr .= '<tbody>';
		$k=0;
		$total_new_charge = 0;
		$total_gst = 0;
		$total_delivery_fee = 0;
		foreach($bookingDetailsDt as $bookingDetailsRow) {
			$userid = $bookingDetailsRow['userid'];
			$fieldArr = array("firstname","lastname","company");
			$usersearch = array();
			$usersearch[]=array('Search_On'=>'userid', 'Search_Value'=>$userid, 'Type'=>'int', 'Equation'=>'=', 'CondType'=>'AND', 'Prefix'=>'', 'Postfix'=>'');
			$DataUservalue =$ObjUserMaster->getUser($FieldArr, $usersearch); // Fetch Data
			$userDetails = $DataUservalue[0];
			if(isset($userDetails['company']) && !empty($userDetails['company'])){
				
				$username = $userDetails['company'];
			}else{
				$username = $userDetails['firstname'].' '.$userDetails['lastname'].' '. $userDetails['company'];
			}
				$class = ($k %2 == 0)? 'whiteBackground': 'grayBackground';
				$tblHeStr .= '<tr class='.$class.'>';
				$tblHeStr .= '<td align="left"><table border="0"><tr><td align="left">'.date('Y-m-d', strtotime($bookingDetailsRow['booking_date'])).'</td><td>'.$bookingDetailsRow['auto_id'].'</td></tr></table></td>';
				$tblHeStr .= '<td  align="left"><table><tr><td  align="left">'.$userid.'</td><td align="left">'.$username.'</td></tr></table></td>';
				$tblHeStr .= '<td align="right"><table align="right"><tr><td align="right">'.number_format($bookingDetailsRow['total_new_charge'],2).'</td><td align="right">'.number_format($bookingDetailsRow['gst_surcharge'],2).'</td><td align="right">'.number_format($bookingDetailsRow['total_delivery_fee'],2).'</td></tr></table></td>';
				$tblHeStr .= '</tr>';
				$total_new_charge += $bookingDetailsRow['total_new_charge'];
				$total_gst += $bookingDetailsRow['gst_surcharge'];
				$total_delivery_fee += $bookingDetailsRow['total_delivery_fee'];

				$k++;
		}
		$tblHeStr .= '</tbody>';
		$tblHeStr .= '<tfoot>';
		$tblHeStr .= '<tr>';
		$tblHeStr .= '<td align="center"><table><tr><td>Total jobs:'.$k.'</td></tr></table></td>';
		$tblHeStr .= '<td align="left"><table><tr><td align="left"></td><td align="left"></td></tr></table></td>';
		$tblHeStr .= '<td align="right"><table align="right"><tr><td align="right">'.number_format($total_new_charge,2).'</td><td align="right">'.number_format($total_gst,2).'</td><td align="right">'.number_format($total_delivery_fee,2).'</td></tr></table></td>';
		$tblHeStr .= '</tr>';
		$tblHeStr .= '</tfoot></table></br>';
		
		$hideColumns = true;
		toPrintPDFFile($tableHeading,$tblHeStr,$hideColumns);
	}

} else {
	$errorMsg = RECORDS_NOT_FOUND;
	$data = array("error" => (( $errorMsg )));
	echo json_encode($data);
	exit();
}

function toPrintPDFFile($tableHeading,$tblHeStr,$hideColumns){

	$html='<style type="text/css">
	#outlook a {padding:0;}body{width:100% !important; -webkit-text-size-adjust:100%; -ms-text-size-adjust:100%; margin:0; padding:0;}.ExternalClass {width:100%;}
	.ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div {line-height: 100%;}#backgroundTable {margin:-30px 0 0; padding:0; width:100% !important; line-height: 100% !important; color:#333; font-size: 12px; font-family:"Helvetica Neue",Helvetica,Arial,sans-serif;}img {outline:none; text-decoration:none; -ms-interpolation-mode: bicubic;}
	a img {border:none;}
	.image_fix {display:block;}p {margin: 1em 0;}
	h1, h2, h3, h4, h5, h6 {font-family: "Open Sans", sans-serif; font-weight: normal;}h1 a, h2 a, h3 a, h4 a, h5 a, h6 a {color: blue !important;}
	h1 a:active, h2 a:active,  h3 a:active, h4 a:active, h5 a:active, h6 a:active {
	color: red !important;
	}h1 a:visited, h2 a:visited,  h3 a:visited, h4 a:visited, h5 a:visited, h6 a:visited {
	color: purple !important;
	}table td {border-collapse: collapse; width:100%}
	table { border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt; width:100%}
	a {color: #72c02c; text-decoration:none;}

	a[href^="tel"], a[href^="sms"] {
			text-decoration: none;
			color: blue; /* or whatever your want */
			pointer-events: none;
			cursor: default;
		}

	.mobile_link a[href^="tel"], .mobile_link a[href^="sms"] {
			text-decoration: default;
			color: orange !important;
			pointer-events: auto;
			cursor: default;
		}
	.w_50 {
	width:50%;
	}
	.w_45 {
	width:45%;
	}
	h2 {
	font-size: 31.5px;
	margin-bottom:0;
	text-align:center;
	}
	.bold {
	font-weight: bold;
	}
	.text-right {
	text-align:right;
	}

	.headline {
	margin: 5px 0 10px 0;
	}
	.pad_main {
	padding: 10px 10px 5px 10px;
	}
	.pad_side {
	padding: 0 10px 20px 10px;
	}
	.salesRpt table {
		border-collapse: collapse;
	}
	/*, tfoot*/ 
	.salesRpt thead,tfoot{
		border-bottom-width: thin;
		border-bottom-style: solid;
	}
	.salesRpt tfoot tr td{
		border-top-width: thin;
		border-top-style: solid
	}
	.whiteBackground { background-color: #fff; }
	.grayBackground { background-color: #ccc; }
	.genWhiteSpace{
		white-space: nowrap;
	}
	.pickup{
		white-space: nowrap;
	}

	</style>
	<table cellpadding="0" cellspacing="0" border="0" id="backgroundTable">
	<tr>
		<td>
		<table cellpadding="0" cellspacing="0" border="0" align="center">
			<tr>
			<td valign="top">
				<table cellpadding="0" cellspacing="0" border="0" align="center">
				<tr>
					<td class="pad_main" valign="top">
					<table  cellpadding="0" cellspacing="0" border="0" align="center">
						<tr>
						<td class="w_50" valign="top"></td>
						<td class="w_50" valign="top">
							<table cellpadding="0" cellspacing="0" border="0" align="center">
							<tr>
								<td valign="top">
								<table cellpadding="0" cellspacing="0" border="0" align="center">
									<tr>
									<td class="w_45"></td>
									<td>
										<div class="headline text-right">
										<img src="https://prioritycouriers.com.au/assets/img/Logo/Priority_Couriers-Logo_footer.png" style="width: 200px; /*height: 73px;*/" />
										</div>
									</td>
									</tr>
								</table>
								</td>
							</tr>
							<tr>
								<td>
								
								</td>
							</tr>
							</table>
						</td>
						</tr>
					</table>
					</td>
				</tr>
				</table>
			</td>
			</tr>
			<tr>
			<td class="pad_side" valign="top">
				<h2 class="bold">'.$tableHeading.'</h2>
				</td>
			</tr>
			<tr>
			<td class="pad_main" valign="top">
				<table cellpadding="0" cellspacing="0" border="0" align="center">
				<tr>
					<td valign="top" nowrap>
					'.$tblHeStr.'
					</td>
				</tr>
				<tr>
					<td class="pad_main" valign="top">
					</td>
				</tr>
				</table>
			</td>
			</tr>
		</table>
		</td>
	</tr>
	</table>';
	header('Content-type: application/pdf');
	header('Content-Disposition: attachment; filename="sales_report.pdf"');


	/*readfile($path_to_pdf);
	exit();*/
	try {

	$dompdf = new DOMPDF();
	$dompdf->set_option('isHtml5ParserEnabled', true);
	$dompdf->set_option('isRemoteEnabled', true);
	$dompdf->load_html($html);
	if(isset($hideColumns) && !empty($hideColumns)) {
						
	}else{
		$dompdf->setPaper('A4', 'landscape');
	}

	$dompdf->render();
	$path_to_pdf = DIR_WS_ONLINEPDF."tmp_pdf/sales_report.pdf";
	file_put_contents($path_to_pdf, $dompdf->output());
	}catch (DOMPDF_Exception $e){
	return 'Error during PDF creation: ' . $e->getMessage();
	}
	$url = SITE_URL."related/"."sales_pdf.php";
	$data = array("success" => (( $url )));
	echo json_encode($data);
	exit();
}
?>