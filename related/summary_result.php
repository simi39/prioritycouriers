<?php
/****
 * Code in this file is used to write and save in pdf files
 * whatever parameters are coming from sales.php file
 * 
 */
require_once("../lib/common.php");
require_once(DIR_WS_MODEL . "UserMaster.php");
require_once(DIR_WS_MODEL . "BookingDetailsMaster.php");
require_once(DIR_WS_RELATED.'/vendor/autoload.php');
require_once(DIR_WS_ADMIN_LANGUAGES . DIR_CURRENT_LANGUAGE. '/sales.php');
use Dompdf\Dompdf;

$path_to_pdf = DIR_WS_ONLINEPDF."tmp_pdf/sales_report.pdf";

$ObjBookingDetailsMaster	= new BookingDetailsMaster();
$ObjBookingDetailsMaster	= $ObjBookingDetailsMaster->Create();
$BookingDetailsData		= new BookingDetailsData();

$ObjUserMaster		= new UserMaster();
$ObjUserMaster		= $ObjUserMaster->Create();
$UserData			= new UserData();


if(isset($_REQUEST['fromDt']) && !empty($_REQUEST['fromDt'])){
    $fromDt =  date('Y-m-d', strtotime($_REQUEST['fromDt']));
}

if(isset($_REQUEST['toDt']) && !empty($_REQUEST['toDt'])){
    $toDt =  date('Y-m-d', strtotime($_REQUEST['toDt']));
}

if(isset($_REQUEST['reportType']) && !empty($_REQUEST['reportType'])){
    $reportType =  $_REQUEST['reportType'];
}

if(isset($reportType) && !empty($reportType) && $reportType == 2) {
	$tableHeading = SUMMARY_REPORT;
}

if(isset($fromDt) && isset($toDt) && isset($reportType) && $reportType == 2) {
    $fieldArr = array("auto_id","COUNT(auto_id) as total_jobs","userid","SUM(total_new_charge) as total_new_charge","SUM(gst_surcharge) as gst_surcharge","SUM(total_delivery_fee) as total_delivery_fee");
    $optArr = array();
    $seaArr = array();

    $seaArr[]=array('Search_On'=>'', 'Search_Value'=>$fromDt, 'Type'=>'string', 'Equation'=>'', 'CondType'=>'AND booking_date BETWEEN', 'Prefix'=>'CAST(', 'Postfix'=>'AS DATE)');
    $seaArr[]=array('Search_On'=>'', 'Search_Value'=>$toDt, 'Type'=>'string', 'Equation'=>'', 'CondType'=>'AND', 'Prefix'=>'CAST(', 'Postfix'=>'AS DATE) GROUP BY userid');
    $bookingDetailsDt=$ObjBookingDetailsMaster->getBookingDetails($fieldArr,$seaArr,$optArr);

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
       /* echo "<pre>";
        print_r($bookingDetailsDt);
        echo "</pre>";
        exit();*/
		foreach($bookingDetailsDt as $bookingDetailsRow) {

			if($checkUserId != $bookingDetailsRow['userid']){
				$i = 0;
			}
            /*echo  $bookingDetailsRow['total_jobs'];
            echo "<pre>";
            print_r($bookingDetailsRow);
            echo "</pre>";*/
			$userBookingDetails[$bookingDetailsRow['userid']][$i]['auto_id'] = $bookingDetailsRow['auto_id'];
			$userBookingDetails[$bookingDetailsRow['userid']][$i]['total_jobs'] = $bookingDetailsRow['total_jobs'];
			$userBookingDetails[$bookingDetailsRow['userid']][$i]['total_new_charge'] = $bookingDetailsRow['total_new_charge'];
			$userBookingDetails[$bookingDetailsRow['userid']][$i]['total_gst'] = $bookingDetailsRow['gst_surcharge'];
			$userBookingDetails[$bookingDetailsRow['userid']][$i]['total_delivery_fee'] = $bookingDetailsRow['total_delivery_fee'];
			$checkUserId = $bookingDetailsRow['userid'];
			$i++;
		}
        //exit();
        if (isset($userBookingDetails) && !empty($userBookingDetails)) {
			$k = 0;
            foreach ($userBookingDetails as $userid => $bookingVal) {
				$class = ($k%2 == 0)? 'whiteBackground': 'grayBackground';
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
				if(isset($k) && $k == 0){
					$tblHeStr .= '<thead>';
					$tblHeStr .= '<tr>';
					$tblHeStr .= '<th align="left">'.TBL_ACCOUNT_NO.'</th>';
					$tblHeStr .= '<th align="left">'.TBL_ACCOUNT_NAME.'</th>';
					$tblHeStr .= '<th align="left">'.TBL_TOTAL_JOBS.'</th>';
					$tblHeStr .= '<th align="right"><table border="0" align="right"><tr><td align="right">'.TBL_AMOUNT.'</td><td align="right">'.TBL_GST.'</td><td align="right">'.TBL_TOTAL.'</td></tr></table></th>';
					$tblHeStr .= '</tr>';
					$tblHeStr .= '</thead>';
				}
                $j = 0;
				$tblHeStr .= '<tbody>';
				$totaldeliverfee = array();
				$totalquantity = array();
				$totalweight = array();
				$totalnewcharge = array();
				$totalgst = array();
                foreach($bookingVal as $key => $val) {
                    
                    $tblHeStr .= '<tr class='.$class.'>';
					$tblHeStr .= '<td>'.$userid.'</td>';
					$tblHeStr .= '<td>'.$username.'</td>';
					$tblHeStr .= '<td>'.$bookingVal[$key]['total_jobs'].'</td>';
                    $tblHeStr .= '<td align="right"><table align="right"><tr><td align="right">'.number_format($bookingVal[$key]['total_new_charge'],2).'</td><td align="right">'.number_format($bookingVal[$key]['total_gst'],2).'</td><td align="right">'.number_format($bookingVal[$key]['total_delivery_fee'],2).'</td></tr></table></td>';
					$tblHeStr .= '</tr>';
                }

                $tblHeStr .= '</tbody>';
				$tblHeStr .= '<tfoot>';
				$tblHeStr .= '<tr>';
				$tblHeStr .= '<td></td>';
				$tblHeStr .= '<td></td>';
				$tblHeStr .= '<td></td>';
                $tblHeStr .= '<td align="right"><table align="right"><tr><td align="right"></td><td align="right"></td><td align="right"></td></tr></table></td>';
				$tblHeStr .= '</tr>';
				$tblHeStr .= '</tfoot></table></br>';
				$k++;
            }
			
        }
        if (file_exists($path_to_pdf)) {
			unlink($path_to_pdf);
		}

		
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
.salesRpt thead, tfoot {
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
/*if(isset($hideColumns) && !empty($hideColumns)) {
					
}else{
	$dompdf->setPaper('A4', 'landscape');
}
*/
$dompdf->render();
file_put_contents($path_to_pdf, $dompdf->output());
}catch (DOMPDF_Exception $e){
return 'Error during PDF creation: ' . $e->getMessage();
}
$url = SITE_URL."related/"."sales_pdf.php";
$data = array("success" => (( $url )));
echo json_encode($data);

//echo $str;
exit();
    }else{
		$errorMsg = RECORDS_NOT_FOUND;
		$data = array("error" => (( $errorMsg )));
		echo json_encode($data);
		exit();
	}
} else {
   
    $errorMsg = RECORDS_NOT_FOUND;
	$data = array("error" => (( $errorMsg )));
	echo json_encode($data);
	exit();
}
?>