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
	require_once(DIR_WS_MODEL . "BookingDetailsMaster.php");
	require_once(DIR_WS_MODEL ."CountryMaster.php");
	require_once(DIR_WS_MODEL . "UserMaster.php");
	require_once(DIR_WS_ADMIN_LANGUAGES . DIR_CURRENT_LANGUAGE. '/booking_detail.php');


	$ObjBookingDetailsMaster	= new BookingDetailsMaster();
	$ObjBookingDetailsMaster	= $ObjBookingDetailsMaster->Create();
	$BookingDetailsData		= new BookingDetailsData();
	$CountryMasterObj = new CountryMaster();
	$CountryMasterObj = $CountryMasterObj->Create();
	//$InternationalZoneData = new InternationalZonesData();

	$ObjUserMaster	= new UserMaster();
	$ObjUserMaster	= $ObjUserMaster->Create();
	$UserData		= new UserData();

	$arr_javascript_plugin_include[] = 'datatables/datatables.min.js';
	$arr_javascript_plugin_include[] = 'datatables/DateTime-1.0.3/js/dataTables.dateTime.min.js';
	$arr_javascript_plugin_include[] = 'datatables/datatables/Buttons-1.7.0/js/dataTables.buttons.min.js';
	$arr_javascript_plugin_include[] = 'datatables/datatables/datatables/JSZip-2.5.0/jszip.min.js';
	$arr_javascript_plugin_include[] = 'datatables/datatables/datatables/pdfmake-0.1.36/pdfmake.min.js';
	$arr_javascript_plugin_include[] = 'datatables/datatables/datatables/pdfmake-0.1.36/vfs_fonts.js';
	$arr_javascript_plugin_include[] = 'datatables/datatables/Buttons-1.7.0/js/buttons.html5.min.js';

	$arr_css_plugin_include[] = 'datatables/datatables.min.css';
	$arr_css_plugin_include[] = 'datatables/Buttons-1.7.0/css/buttons.dataTables.min.css';
	$message = $arr_message[$_GET['message']];
	if(!empty($message))
	{
		$err['message'] = specialcharaChk(valid_input($message));
	}
	if(!empty($err['message']))
	{
		logOut();
	}
	$fieldArr = array("*");
	$optArr = array();
	//$optArr[]	=	array("Order_By" => "booking_date", "booking_time",
		//				  "Order_Type" => "DESC");
	$DataUser=$ObjBookingDetailsMaster->getBookingDetails(null,null,$optArr,$from,$to);
	/*echo "<pre>";
	print_r($DataUser);
	echo "</pre>";
*/

	//$seaArr[]=array('Search_On'=>'userid', 'Search_Value'=>'169', 'Type'=>'int', 'Equation'=>'=', 'CondType'=>'AND', 'Prefix'=>'', 'Postfix'=>'');

	//$testUserData = $ObjUserMaster->getUser('*',$seaArr,null,null,null); // Fetch Data
	/*echo "<pre>";
	print_r($UserData);
	echo "</pre>";*/
	//$testdetailsuser = $testUserData[0];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo ADMIN_HEADER_BOOKING_DETAIL;?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<?php
addCSSFileAdmin($arr_css_admin_include, $arr_css_admin_exclude);
addJavaScriptFile($arr_javascript_include, $arr_javascript_exclude);
addPluginCSSFile($arr_css_plugin_include,$arr_css_plugin_exclude);
addPluginJavaScriptFile($arr_javascript_plugin_include,$arr_javascript_plugin_exclude);
?>

<script>
/** Date/time filtering function **/
var minDate, maxDate;

// Custom filtering function which will search data in column four between two values
$.fn.dataTable.ext.search.push(
    function( settings, data, dataIndex ) {
        var min = minDate.val();
        var max = maxDate.val();
        var date = new Date( data[1] );

        if (
            ( min === null && max === null ) ||
            ( min === null && date <= max ) ||
            ( min <= date   && max === null ) ||
            ( min <= date   && date <= max )
        ) {
            return true;
        }
        return false;
    }
);
/** End Date/time filtering function **/
$(document).ready(function() {

	// Create date inputs
	minDate = new DateTime($('#min'), {
		format: 'MMMM Do YYYY'
	});
	maxDate = new DateTime($('#max'), {
		format: 'MMMM Do YYYY'
	});

	// DataTables initialisation
	var table = $('#seles_rep').DataTable();

	// Refilter the table
	$('#min, #max').on('change', function () {
		table.draw();
	});

  $('#seles_rep').DataTable( {
			destroy: true,
			select: true,
			dom: 'Bfrtip',
			lengthMenu: [
				[ 25, 50, 100, -1 ],
				[ '25 rows', '50 rows', '100 rows', 'Show all' ]
			],
			buttons: [
				'pageLength',
				'copyHtml5',
				'excelHtml5',
				'csvHtml5',
				'pdfHtml5'
			],
			"order": [[ 2, 'desc' ]],
			//"pageLength": 50,
			"footerCallback": function ( row, data, start, end, display ) {
				var api = this.api(), data;

				// Remove the formatting to get integer data for summation
				var intVal = function ( i ) {
					return typeof i === 'string' ?
						i.replace(/[\$,]/g, '')*1 :
						typeof i === 'number' ?
								i : 0;
				};
				// Total over all pages
				total5 = api
					.column( 5 )
					.data()
					.reduce( function (a, b) {
						return (intVal(a) + intVal(b)).toFixed(2);
					}, 0 );

				total6 = api
					.column( 6 )
					.data()
					.reduce( function (a, b) {
						return (intVal(a) + intVal(b)).toFixed(2);
					}, 0 );
				total7 = api
					.column( 7 )
					.data()
					.reduce( function (a, b) {
						return (intVal(a) + intVal(b)).toFixed(2);
					}, 0 );
				total8 = api
					.column( 8 )
					.data()
					.reduce( function (a, b) {
						return (intVal(a) + intVal(b)).toFixed(2);
					}, 0 );
				// Total over this page
				pageTotal5 = api
					.column( 5, { page: 'current'} )
					.data()
					.reduce( function (a, b) {
						return (intVal(a) + intVal(b)).toFixed(2);
					}, 0 );
				pageTotal6 = api
					.column( 6, { page: 'current'} )
					.data()
					.reduce( function (a, b) {
						return (intVal(a) + intVal(b)).toFixed(2);
					}, 0 );
				pageTotal7 = api
					.column( 7, { page: 'current'} )
					.data()
					.reduce( function (a, b) {
						return (intVal(a) + intVal(b)).toFixed(2);
					}, 0 );
				pageTotal8 = api
					.column( 8, { page: 'current'} )
					.data()
					.reduce( function (a, b) {
						return (intVal(a) + intVal(b)).toFixed(2);
					}, 0 );

				// Update footer
				$( api.column( 5 ).footer() ).html(
					'$'+pageTotal5 +'</br>$'+ total5
				);
				$( api.column( 6 ).footer() ).html(
					'$'+pageTotal6 +'</br>$'+ total6
				);
				$( api.column( 7 ).footer() ).html(
					'$'+pageTotal7 +'</br>$'+ total7
				);
				$( api.column( 8 ).footer() ).html(
					'$'+pageTotal8 +'</br>$'+ total8
				);
			}
		});
});
</script>


</head>
<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0" id="main" align="center">
	<tr>
		<td>
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
						<table border="0" width="100%" cellpadding="0" cellspacing="0"  align="center" class="middle_right_content">
							<tr>
								<td align="left" class="breadcrumb">
								<span><a href="<?php echo FILE_WELCOME_ADMIN; ?>"><?php echo ADMIN_HEADER_HOME;?></a> > <?php echo ADMIN_HEADER_BOOKING_DETAIL; ?></span>
								<div><label class="top_navigation"><a onclick="mtrash('<?php echo  FILE_BOOKING_DETAILS_ACTION;?>','<?php echo ADMIN_USERS_DELETE_CONFIRM; ?>');"><?php echo COMMAN_DELETE; ?></a>
								<label class="top_navigation"><!--<a href="<?php echo FILE_BOOKING_DETAILS_ACTION; ?>"><?php echo ADMIN_ADD_NEW ; ?>--></a>
								<a href="<?php echo FILE_BOOKING_DETAILS_ACTION; ?>?Action=export"><?php echo ADMIN_EXPORT_NEW ; ?></a></label>

								</div>

								</td>
							</tr>
							<tr>
								<td class="heading">
								<?php echo ADMIN_HEADER_BOOKING_DETAIL; ?>
								</td>
							</tr>
							<?php if(!empty($message)) {?>
							<tr>
								<td class="message_success" align="center"><?php echo valid_output($message); ?></td>
							</tr>
							<?php } ?>
							<!--  End Searching	-->
							<tr>
								<td>

							<?php  /*** Start :: Listing Table ***/ ?>

									<div id="container">

										<table cellspacing="5" cellpadding="5" border="0">
        							<tbody>
												<tr>
													<td>
														<table cellspacing="0" cellpadding="0" border="0">
															<tr>
																<td>
																	<h5>Select the date range</h5>
																</td>
															</tr>
														</table>
													</td>
												</tr>
												<tr>
            							<td>Minimum date:</td>
            							<td><input type="text" id="min" name="min"></td>
        								</tr>
        								<tr>
            							<td>Maximum date:</td>
            							<td><input type="text" id="max" name="max"></td>
        								</tr>
											</tbody>
										</table>
										<table width="100%" cellspacing="0" cellpadding="0" class="display" id="seles_rep">
											<thead>
												<tr>
												<th align="center"> <input type="checkbox" name="m_trash_main" id="m_trash_all" > </th>
													<th align="center"><?php echo ADMIN_SALES_REPORT_INVOICE_DATE; ?></th>
													<!--<th width="5%" align="center"><?php echo ADMIN_COMMON_SERIAL_NO; ?></th>-->
													<th align="center"><?php echo ADMIN_SALES_REPORT_INVOICE_NO; ?></th>
													<th align="center"><?php echo ADMIN_SALES_REPORT_ACCOUNT_NO; ?></th>
													<th align="center"><?php echo ADMIN_SALES_REPORT_NAME; ?></th>
													<th align="center"><?php echo ADMIN_SALES_REPORT_DELIVERY_FEE; ?></th>
													<th align="center"><?php echo ADMIN_SALES_REPORT_FUEL_SURCHARGE; ?></th>
													<th align="center"><?php echo ADMIN_SALES_REPORT_GST; ?></th>
													<th align="center"><?php echo ADMIN_SALES_REPORT_TOTAL; ?></th>
													<th align="center"><?php echo ADMIN_SALES_REPORT_INVOICE; ?></th>
													<th align="center"><?php echo ACTION; ?></th>


												</tr>
											</thead>
											<tbody>
												<?php
												 	if($DataUser!='') {
												 		$i = 1;
														$fieldArr = array();
														$fieldArr = array('count(*) as total');

														foreach ($DataUser as $users_details) {
															$seaArr = array();
															$rowClass = 'TableEvenRow';
															if($rowClass == 'TableEvenRow') {
																$rowClass = 'TableOddRow';
															} else {
																$rowClass = 'TableEvenRow';
															}
															$seaArr[]=array('Search_On'=>'userid', 'Search_Value'=>$users_details['userid'], 'Type'=>'int', 'Equation'=>'=', 'CondType'=>'AND', 'Prefix'=>'', 'Postfix'=>'');

															$UserData = $ObjUserMaster->getUser('*',$seaArr,null,null,null); // Fetch Data
															$detailsuser = $UserData[0];
															//echo $users_details['userid']."---".$detailsuser->firstname."</br>";
												?>
												<tr class="<?php echo $rowClass; ?>">
												<td align="center"> <input type="checkbox" name="m_trash" id="<?php echo $users_details['booking_id'];?>"></td>
													<td align="center"><?php echo date("Y/m/d", strtotime($users_details['booking_date']));?></td>
													<!--<td align="center"><?php echo $i = 1 +$from;?></td>-->
													<td align="center"><?php echo $users_details['auto_id'];?></td>
													<td align="center"><?php echo valid_output($users_details['userid']); ?></td>
													<td align="center"><?php if (isset($detailsuser->company)&&!empty($detailsuser->company)){echo $detailsuser->company;}else{echo $detailsuser->firstname.'&nbsp;'.$detailsuser->lastname;}?></td></td>
													<td align="right"><?php echo "$". valid_output($users_details['delivery_fee']);?></td>
													<td align="right"><?php echo "$". valid_output($users_details['fuel_surcharge']);?></td>
													<td align="right"><?php echo "$". valid_output($users_details['total_gst_delivery']);?></td>
													<td align="right"><?php echo "$". valid_output($users_details['rate']);?></td>
													<td align="center">
														<?php if(file_exists(DIR_WS_ONLINEPDF."receipt/Completion_Receipt_PC".$users_details['auto_id'].".pdf")) { ?>
															<a href="<?php echo DIR_HTTP_RELATED."completion_receipt.php?nr=".$users_details['booking_id'];  ?>" target=_new><?php echo "Inv-".$users_details['auto_id']; ?></a>
														<?php } else echo "No Invoice"; ?></br>
														<?php if(file_exists(DIR_WS_ONLINEPDF."commercial_invoice/Commercial_Invoice_".$users_details['booking_id'].".pdf")) { ?>
															<a href="<?php echo DIR_HTTP_RELATED."commercial_invoice.php?nr=".$users_details['booking_id']; ?>" target=_new><?php echo "Comm-Inv-".$users_details['auto_id']; ?></a>
														<?php } ?>
													</td>

													<td align="center" nowrap="nowrap">
														<a href="<?php echo FILE_BOOKING_DETAILS_ACTION; ?>?Action=edit&amp;auto_id=<?php echo $users_details['auto_id'];?>"><?php echo COMMON_EDIT; ?></a> | <a href="<?php echo FILE_BOOKING_DETAILS_ACTION; ?>?Action=trash&amp;auto_id=<?php echo $users_details['auto_id'].$URLParameters; ?>" onclick="return confirm('<?php echo ADMIN_USERS_DELETE_CONFIRM; ?>')"><?php echo COMMAN_DELETE; ?></a>


													</td>

												</tr>
												<?php	$from = $from+1;
												}
											 }?>
											</tbody>
											<!--<tfoot>
												<tr>
													<th>&nbsp;</th>
													<th align="center"><?php echo ADMIN_COMMON_SERIAL_NO; ?>&nbsp;</th>
													<th>&nbsp;</th>
													<th align="center"><?php echo PICKUP_FROM; ?>&nbsp;</th>
													<th align="center"><?php echo DILIVER_TO; ?>&nbsp;</th>

													<th align="center"><?php echo SERVICE; ?>&nbsp;</th>
													<th align="center"><?php echo DATE_READY; ?>&nbsp;</th>
													<th align="center"><?php echo TIME_READY; ?>&nbsp;</th>
													<th align="center"><?php echo BOOKING_DATE; ?>&nbsp;</th>
													<th align="center"><?php echo BOOKING_TIME; ?>&nbsp;</th>
													<th align="center"><?php echo ACTION; ?>&nbsp;</th>



												</tr>
											</tfoot>-->
											<tfoot>
												<tr>
													<th colspan="5" align="right">Total:</br>Grand Total:</th>
													<th align="right"></th>
													<th align="right"></th>
													<th align="right"></th>
													<th align="right"></th>
													<th colspan="2"></th>
												</tr>
									 		</tfoot>

										</table>


									</div>

							<?php  /*** End :: Listing Table ***/ ?>

								</td>
							</tr>

						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
<!-- End Middle Content part -->
	<tr>
		<td id="footer"><?php require_once(DIR_WS_ADMIN_INCLUDES . ADMIN_FILE_FOOTER);?></td>
	</tr>
</table>
<?php

//echo $testdetailsuser->auto_id."</br>";
/*echo "<pre>";
print_r($users_details);
echo "</pre>";*/
/*if (isset($users_details['auto_id']) && $users_details['auto_id']='683') {
echo "<pre>";
print_r($testdetailsuser);
//print_r($autoId);
echo "</pre>";

}*/
 ?>
</body>
</html>
