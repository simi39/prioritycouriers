<?php
require_once("../lib/common.php");
require_once(DIR_WS_MODEL . "BookingDetailsMaster.php");
require_once(DIR_WS_MODEL ."CountryMaster.php");
require_once(DIR_WS_MODEL . "UserMaster.php");
require_once(DIR_WS_ADMIN_LANGUAGES . DIR_CURRENT_LANGUAGE. '/sales.php');


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


$arr_css_plugin_include[] = 'datatables/datatables.min.css';
$arr_css_plugin_include[] = 'datatables/Buttons-1.7.0/css/buttons.dataTables.min.css';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo ADMIN_HEADER_SALES_REPORT;?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<?php
addCSSFileAdmin($arr_css_admin_include, $arr_css_admin_exclude);
addJavaScriptFile($arr_javascript_include, $arr_javascript_exclude);
addPluginCSSFile($arr_css_plugin_include,$arr_css_plugin_exclude);
addPluginJavaScriptFile($arr_javascript_plugin_include,$arr_javascript_plugin_exclude);
?>
<script>
/** Date/time filtering function **/
var fromDate, toDate;

/** End Date/time filtering function **/
$(document).ready(function() {
    // Create date inputs
	fromDate = new DateTime($('#fromdt'), {
		format: 'MMMM Do YYYY'
	});
	toDate = new DateTime($('#todt'), {
		format: 'MMMM Do YYYY'
	});

	$('#reportType').on('change', function() { 
		//alert( this.value );
		if(this.value == 2){ // it's a summary report setting
			$("#selectAccountTbl").hide();
		}else if(this.value == 1){// it's a sales report setting
			$("#selectAccountTbl").show();
		} 
	});

	//alert("report type:"+$("#reportType").val());
	

	$("#btnsubmit").click(function() {
		var errorflag = false;
		//alert($("#reportType").val());
		if($("#reportType").val() == 0){
			$("#reportTypeError").html('<?php echo REPORT_TYPE_ERROR; ?>');
			errorflag = true;
		} else  {
			$("#reportTypeError").html("");
			
		}
		if($("#fromdt").val() == ''){
			$("#fromdtError").html('<?php echo FROM_DATE_VALUE_ERROR; ?>');
			errorflag = true;
		} else  {
			$("#fromdtError").html("");
		}
		if($("#todt").val() == ''){
			$("#todtError").html("<?php echo TO_DATE_VALUE_ERROR; ?>");
			errorflag = true;
		} else  {
			$("#todtError").html("");
		}
		
		if($("#reportType").val() == 1){ // To check wheather it's sales report or not
			if($("#user_acc").val() == '<?php echo SELECT_USER_ACC_OPTION; ?>'){
				$("#userAccError").html("<?php echo PLEASE_SELECT_ANY_USER; ?>");
				errorflag = true;
			} else  {
				$("#userAccError").html("");
			}
			var paramStr = "fromDt=" +$("#fromdt").val()+"&toDt="+$("#todt").val()+"&userId="+$('#user_acc').val()+"&reportType="+$("#reportType").val(); 
			var urlStr = '<?php echo DIR_HTTP_RELATED."sales_result.php"; ?>'; 
		} else {
			var paramStr = "fromDt=" +$("#fromdt").val()+"&toDt="+$("#todt").val()+"&reportType="+$("#reportType").val();
			var urlStr = '<?php echo DIR_HTTP_RELATED."summary_result.php"; ?>';
		}
		if(errorflag == false){
			$.ajax({
				type: "POST",
				url: urlStr,
				data: paramStr,
				success: function(response) {
					var json = JSON.parse(response);
					if(json.success){
						console.log(json);
						window.location = json.success;
					}else{
						$("#dataError").html(json.error);
					}
					
				}
			});
		}
		
		//console.log("btn is clicked"+errorflag);
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
								<span><a href="<?php echo FILE_WELCOME_ADMIN; ?>"><?php echo ADMIN_HEADER_HOME;?></a> > <?php echo ADMIN_HEADER_SALES_REPORT; ?></span>
								<div><label class="top_navigation">
								<label class="top_navigation">
								</div>

								</td>
							</tr>
							<tr>
								<td class="heading">
								<?php echo ADMIN_HEADER_SALES_REPORT; ?>
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
											<td colspan="2"><h5>Report Type</h5></td>
											<td colspan="2">
											</td>
										</tr>
										<tr>
											<td colspan="4">
												<table>
													<tr>
														<td colspan="4">
															<select id="reportType" name="reportType">
																<option value="0"><?php echo SELECT_REPORT_TYPE_OPTION; ?></option>
																<option value="1"><?php echo SALES_REPORT; ?></option>
																<option value="2"><?php echo SUMMARY_REPORT; ?></option>
															</select>
														</td>
													</tr>
												</table>
											</td>
										</tr>
										<tr>
											<td colspan="4" id="reportTypeError" class="message_mendatory"></td>
										</tr>
										<tr>
											<td colspan="2">
												<table cellspacing="0" cellpadding="0" border="0">
													
													<tr>
														<td >
															<h5><?php echo SELECT_DATE_RANGE; ?></h5>
														</td>
													</tr>
												</table>
											</td>
											<td></td>
											<td></td>
										</tr>
                                                
										<tr>
            								<td><?php echo FROM_DATE ?>:</td>
            								<td><input type="text" id="fromdt" name="fromdt"></td>
        									<td><?php echo TO_DATE; ?>:</td>
											<td><input type="text" id="todt" name="todt"></td>
                                        </tr>
										<tr>
											<td id="fromdtError" colspan="2" align="left" valign="top" class="message_mendatory"></td>
											<td id="todtError" colspan="2" align="left" valign="top" class="message_mendatory"></td>
										</tr>
        								<tr id="dpUserAcc">
										<td colspan="4">
											<table id="selectAccountTbl">
												<tr>
													<td><?php echo SELECT_ACCOUNT; ?></td>
													<td>
														<select id="user_acc">
															<option><?php echo SELECT_USER_ACC_OPTION; ?></option>
															<option value="all">All</option>
															<?php
															
															$fieldArr = array('userid','firstname');
															$DataUser=$ObjUserMaster->getUser($fieldArr); // Fetch Data
														
															foreach ($DataUser as $users_details) {
																echo $users_details['userid']."---".$users_details['firstname']."</br>";
															?> 
																<option value="<?php echo $users_details['userid']; ?>"><?php echo $users_details['userid']."(".$users_details['firstname'].")"; ?></option>
															<?php
																}
															?>
														</select>
													</td>
												</tr>
												<tr>
													<td colspan="2" align="left" id="userAccError" class="message_mendatory"></td>
												</tr>
											</table>
										</td>
										</tr>
										
										<tr>
											<td colspan="4" align="left"><input type="submit" id="btnsubmit" class="action_button" tabindex="36" name="btnsubmit" value="<?php echo "Search"; ?>" ></td>
										</tr>
                                    	</tbody>
										</table>
										<table width="100%" cellspacing="0" cellpadding="0" class="display" id="sales_rep">
											<thead>
												<th></th>
												<th></th>
												<th></th>
											</thread>
											<tbody>
												<tr>
													<td></td>
													<td id="dataError" align="left" valign="top" class="message_mendatory"></td>
													<td></td>
												</tr>
											</tbody>
											<tfoot>
												<th>&nbsp;</th>
												<th></th>
												<th></th>
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
</body>
</html>
