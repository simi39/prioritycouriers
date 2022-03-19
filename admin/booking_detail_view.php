<?php
require_once("../lib/common.php");
require_once(DIR_WS_MODEL . "BookingDetailsMaster.php");
require_once(DIR_WS_MODEL . "BookingItemDetailsMaster.php");
require_once(DIR_WS_MODEL . "UserMaster.php");
require_once(DIR_WS_ADMIN_LANGUAGES . DIR_CURRENT_LANGUAGE. '/booking_detail.php');


$arr_css_admin_exclude[] = 'jquery.css';
$arr_css_plugin_include[] ='tabbed-panels/css/tabbed_panels.css';
$arr_css_admin_include[] = 'custom-style.css';

$arr_javascript_plugin_include[] = 'bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js';

$arr_javascript_include[] ='booking_details.php';

$ObjUserMaster	= new UserMaster();
$ObjUserMaster	= $ObjUserMaster->Create();
$UserData		= new UserData();

$ObjBookingDetailsMaster	= new BookingDetailsMaster();
$ObjBookingDetailsMaster	= $ObjBookingDetailsMaster->Create();
$BookingDetailsData		= new BookingDetailsData();

$ObjBookingItemDetailsMaster	= new BookingItemDetailsMaster();
$ObjBookingItemDetailsMaster	= $ObjBookingItemDetailsMaster->Create();
$BookingItemDetailsData		= new BookingItemDetailsData();



$auto_id = $_GET['auto_id'];

if(isset($auto_id) && !empty($auto_id)){
	$seaByArr = array();
	$fieldArr = array("userid","booking_id","CCConnote","delivery_fee","close_time","date_ready","time_ready","total_qty","total_weight","service_name","total_gst_delivery","total_delivery_fee","sender_first_name"
,"sender_surname","sender_company_name","sender_address_1","sender_address_2","sender_address_3","sender_suburb","sender_state","sender_postcode","sender_email","sender_area_code","sender_contact_no","sender_mobile_no","sender_mb_area_code",
"reciever_firstname","reciever_surname","reciever_company_name","reciever_address_1","reciever_address_2","reciever_address_3","deliveryid","reciever_suburb","reciever_state"
,"reciever_postcode","reciever_area_code","flag","reciever_area_code","reciever_contact_no","reciever_mb_area_code","reciever_mobile_no");
	$seaByArr[] = array('Search_On'=>'auto_id', 'Search_Value'=>"$auto_id", 'Type'=>'int', 'Equation'=>'=', 'CondType'=>'and', 'Prefix'=>'', 'Postfix'=>'');
	$BookingDetails = $ObjBookingDetailsMaster->getBookingDetails($fieldArr,$seaByArr); // Fetch Data
	$BookingDetails =$BookingDetails[0];
	$userid = $BookingDetails['userid'];
	$bookingid = $BookingDetails['booking_id'];
	$connoate = $BookingDetails['CCConnote'];
	//echo "connoate:".$connoate;

	$userSearByArr = array();
	$userSearByArr[] = array('Search_On'=>'userid', 'Search_Value'=>"$userid", 'Type'=>'int', 'Equation'=>'=', 'CondType'=>'and', 'Prefix'=>'', 'Postfix'=>'');
	$UserData = $ObjUserMaster->getUser('*',$userSearByArr);
	$UserData = $UserData[0];
	
	$itemFieldArr = array("*");
	$itemSeaByArr[] = array('Search_On'=>'CCConnote', 'Search_Value'=>"$connoate", 'Type'=>'int', 'Equation'=>'=', 'CondType'=>'and', 'Prefix'=>'', 'Postfix'=>'');
    $BookingItemDetailsData = $ObjBookingItemDetailsMaster->getBookingItemDetails($itemFieldArr, $itemSeaByArr); // Fetch Data
    //$BookingItemDetailsData = $BookingItemDetailsData[0];
	$dimensionsStr = "";
	if (isset($BookingItemDetailsData) && !empty($BookingItemDetailsData)) {
		foreach ($BookingItemDetailsData as $key => $val) {
			$dimensionsStr .= $val['quantity'] ." &#64; ". $val['item_weight'] ."kg ". $val['length'] . "cm x ". $val['width'] ."cm x ". $val['height'] ."cm <br>";
		}
	}
	//echo $dimensionsStr;
	//echo $UserData->firstname;
	//echo "bookingid:".$bookingid."userid:".$userid."</br>";
	/*echo "<pre>";
	print_r($BookingItemDetailsData);
	echo "</pre>";*/
	//exit();
	//$BookingDetail = $BookingDetails[0];

	/*
	echo "userid:".$userid;*/
	/*$fieldArr = array("userid","email");
	$PostCodedatas = $ObjUserMaster->getUserListing($fieldArr);
	*/
}else{
	//redirect to listing page
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title></title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	<?php
		addCSSFileAdmin($arr_css_admin_include, $arr_css_admin_exclude);
		addPluginCSSFile($arr_css_plugin_include,$arr_css_plugin_exclude);
		addJavaScriptFile($arr_javascript_include, $arr_javascript_exclude);
		addPluginJavaScriptFile($arr_javascript_plugin_include,$arr_javascript_plugin_exclude);
	?>
</head>
<body>
<table width="100%" border="1" cellspacing="0" cellpadding="0" align="center">
	<tr>
		<td valign="top">
		<?php require_once(DIR_WS_ADMIN_INCLUDES . ADMIN_FILE_HEADER);?>
		</td>
	</tr>
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
						<table class="middle_right_content" align="center" border="0" cellpadding="0" cellspacing="0">
							<tr>
								<td align="left" class="breadcrumb">
									<span><a href="<?php echo FILE_WELCOME_ADMIN; ?>"><?php echo ADMIN_HEADER_HOME; ?></a> > <a href="<?php echo FILE_BOOKING_DETAILS_LISTING; ?>"> <?php echo ADMIN_HEADER_BOOKING_DETAIL; ?> </a> > <? echo $HeadingLabel; ?></span>
									<div><label class="top_navigation"><a href="<?php echo FILE_BOOKING_DETAILS_LISTING; ?>"><?php echo ADMIN_COMMON_BACK; ?></a></label></div>
								</td>
							</tr>
							<tr>
								<td class="heading">
									<?php echo $HeadingLabel; ?>
								</td>
							</tr>
							<tr>
								<td colspan="4">&nbsp;</td>
							</tr>
							<tr>
								<td align="center" colspan="4">
									<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td  align="left" valign="middle" class="heading"><?php echo USERNAME;?>&nbsp;</td>
										<td  align="left" valign="middle"><?php ?></td>
										<td  align="left" valign="middle"></td>
										<td  align="left" valign="top"></td>
									</tr>
									<tr>
										<td  align="left" valign="middle">
										<?php 
											if(isset($UserData->firstname) && !empty($UserData->firstname)) { 
												echo $UserData->firstname."  ".$UserData->lastname;
											} 
										?>
										</td>
										<td  align="left" valign="middle"></td>
										<td  align="left" valign="middle"></td>
										<td  align="left" valign="top"></td>
									</tr>
									<tr>
										<td  align="left" valign="middle" class="heading"><?php echo VIEW_COLLECTION_AND_DELIVERY; ?></td>
										<td  align="left" valign="middle" class="heading"><?php echo VIEW_DESCRIPTION_OF_GOODS; ?></td>
										<td  align="left" valign="middle" colspan="2" class="heading"><?php echo VIEW_FEES_AND_CHARGES; ?></td>
										
									</tr>
									<tr>
										<td  align="left" valign="middle" class="heading"><?php echo VIEW_COLLECTION_DATE_TIME; ?></td>
										<td  align="left" valign="middle" class="heading"><?php echo VIEW_PIECES_AND_WEIGHT; ?></td>
										<td  align="left" valign="top" class="heading"><?php echo VIEW_DELIVERY_CHARGE; ?></td>
										<td  align="right" valign="middle">$<?php if(isset($BookingDetails['delivery_fee']) && !empty($BookingDetails['delivery_fee'])){ echo number_format($BookingDetails['delivery_fee'],2, '.', ''); } ?></td>
									</tr>
									<?php
										$close_time = '';
										if(isset($BookingDetails['close_time']) && !empty($BookingDetails['close_time'])){
											$close_time = "-".$BookingDetails['close_time'];
										}
									?>
									<tr>
										<td  align="left" valign="middle">
											<?php 
												if (isset($BookingDetails['date_ready']) && isset($BookingDetails['time_ready']) && isset($close_time)) {
													echo date('l jS F Y',strtotime($BookingDetails['date_ready']))." at ".$BookingDetails['time_ready'].$close_time;
												}
											?>
										</td>
										<td  align="left" valign="middle">
											<?php
												if(isset($BookingDetails['total_qty']) && !empty($BookingDetails['total_qty']) && isset($BookingDetails['total_weight']) && !empty($BookingDetails['total_weight'])){
													echo filter_var($BookingDetails['total_qty'],FILTER_VALIDATE_FLOAT)." &#64; ".filter_var($BookingDetails['total_weight'],FILTER_VALIDATE_FLOAT)." kg";
												}
												  
											?> 
										</td>
										<td  align="left" valign="top" class="heading">
											<?php 
												if(isset($BookingDetails['service_name']) && !empty($BookingDetails['service_name']) && $BookingDetails['service_name'] !="international") {
													 echo VIEW_GST;
												} 
											?>
										</td>
										<td  align="right" valign="middle">
											<?php 
												if(isset($BookingDetails['total_gst_delivery']) && !empty($BookingDetails['total_gst_delivery'])) {
													 echo "$".number_format($BookingDetails['total_gst_delivery'],2, '.', '');
												} 
											?>
										</td>
									</tr>
									<tr>
										<td  align="left" valign="middle" class="heading">
											<table width="100%" border="0" cellspacing="0" cellpadding="0">
												<tr>
													<td><?php echo VIEW_SERVICE_NAME; ?></td>
													<td><?php echo VIEW_CONNOATE_NUMBER; ?></td>
												</tr>
											</table>
										</td>
										<td  align="left" valign="middle">
											<?php
												if(isset($dimensionsStr) && !empty($dimensionsStr)) {
													echo $dimensionsStr;
												}
											?>
										</td>
										<td  align="left" valign="top" class="heading"><?php echo VIEW_TOTAL_DELIVERY_CHARGE; ?></td>
										<td  align="right" valign="middle">
											<?php 
												if(isset($BookingDetails['total_delivery_fee']) && $BookingDetails['total_delivery_fee']!=0) {
													echo "$".number_format($BookingDetails['total_delivery_fee'], 2, '.', '');
												}
											?>
										</td>
									</tr>
									<tr>
										<td  align="left" valign="middle">
										<table width="100%" border="0" cellspacing="0" cellpadding="0">
												<tr>
													<td align="left">
														<?php 

														if(isset($BookingDetails['service_name']) && $BookingDetails['service_name']=="international"){
															if(isset($BookingItemDetailsData[0]['item_type']) && $BookingItemDetailsData[0]['item_type'] == '5'){
																$international_item_type = 'Non-Documents';
															}else{
																$international_item_type = 'Documents';
															} 
															$service_name = ucfirst(valid_output($BookingDetails['service_name']))." ".$international_item_type." ";
														}else{
															$service_name = ucfirst(valid_output($BookingDetails['service_name']));
														}
														if(isset($service_name) && !empty($service_name)) {
															echo $service_name;
														}
														?>
													</td>
													<td align="left">
														<?php 
															if(isset($BookingDetails['CCConnote']) && !empty($BookingDetails['CCConnote'])){
																echo $BookingDetails['CCConnote'];
															} 
														?>
													</td>
												</tr>
											</table>
											
										</td>
										<td  align="left" valign="middle">
										</td>
										<td  align="left" valign="top" class="heading">
											<?php echo VIEW_TOTAL_PAYABLE_AMOUNT; ?>
										</td>
										<td  align="right" valign="middle">$
										<?php
											if(isset($BookingDetails['total_delivery_fee']) && $BookingDetails['total_delivery_fee']!=0) {
													echo number_format($BookingDetails['total_delivery_fee'], 2, '.', '');
												}
										?>
										</td>
									</tr>
									
									<tr>
										<td  align="left" valign="top" class="heading">
											<?php 
												echo VIEW_FROM;
											?>
										</td>
										<td  align="left" valign="top"></td>
										<td  align="left" valign="top"></td>
										<td  align="left" valign="top"></td>
									</tr>
									<tr>
										<td>
										<?php
											echo ucfirst(valid_output($BookingDetails['sender_first_name']))." ".$BookingDetails['sender_surname']."</h5></br>";
											if(isset($BookingDetails['sender_company_name']) && !empty($BookingDetails['sender_company_name'])){
													echo valid_output($BookingDetails['sender_company_name'])."</br>";
											}
											if(isset($BookingDetails['sender_address_1']) && !empty($BookingDetails['sender_address_1'])){
													echo valid_output($BookingDetails['sender_address_1'])."</br>";
											}
											if(isset($BookingDetails['sender_address_2']) && !empty($BookingDetails['sender_address_2'])){
													echo valid_output($BookingDetails['sender_address_2'])."</br>";
											}
											if(isset($BookingDetails['sender_address_3']) && !empty($BookingDetails['sender_address_3'])){
													echo valid_output($BookingDetails['sender_address_3'])."</br>";
											}
											echo valid_output($BookingDetails['sender_suburb'])." ".valid_output($BookingDetails['sender_state'])." ".valid_output($BookingDetails['sender_postcode'])."</br>";
							/*				if(isset($BookingDatashow->flag) && ($BookingDatashow->flag=="australia")) { */
												echo "Australia</br>";
							/*				}*/
											echo valid_output($BookingDetails['sender_email'])."</br>";
											if(isset($BookingDetails['sender_contact_no']) && !empty($BookingDetails['sender_contact_no'])){
													echo valid_output($BookingDetails['sender_area_code'])." ".valid_output($BookingDetails['sender_contact_no'])."</br>";
											}
											if(isset($BookingDetails['sender_mobile_no']) && !empty($BookingDetails['sender_mobile_no'])){
													echo valid_output($BookingDetails['sender_mb_area_code'])." ".valid_output($BookingDetails['sender_mobile_no'])."</br>";
											}
										?>
										</td>
										<td  align="left" valign="top"></td>
										<td  align="left" valign="top"></td>
										<td  align="left" valign="top"></td>
									</tr>
									<tr>
										<td align="left" valign="top" colspan="4">
											<table>
												<tr>
													<td align="left" valign="top" class="heading"><?php echo VIEW_SENDER_ADDRESS_COUNTRY; ?></td>
													<td align="left" valign="top" class="heading"><?php echo VIEW_SENDER_ADDRESS_SUBURB_CITY; ?></td>
												</tr>
												<tr>
													<td><?php echo "Australia"; ?></td>
													<td>
														<?php 
															if(isset($BookingDetails['sender_suburb']) && !empty($BookingDetails['sender_suburb'])) {
																echo valid_output($BookingDetails['sender_suburb']);
															}
															 
														?>
													</td>
												</tr>
											</table>
										</td>
									</tr>
									<tr>
										<td align="left" valign="top" colspan="4">
											<table>
												<tr>
													<td align="left" valign="top" class="heading"><?php echo VIEW_SENDER_ADDRESS_SUBURB_STATE; ?></td>
													<td>&nbsp;</td>
													<td align="left" valign="top" class="heading"><?php echo VIEW_SENDER_ADDRESS_SUBURB_POSTCODE; ?></td>
												</tr>
												<tr>
													<td>
														<?php 
															if(isset($BookingDetails['sender_state']) && !empty($BookingDetails['sender_state'])) {
																echo $BookingDetails['sender_state'];
															}
															 
														?>
													</td>
													<td>&nbsp;</td>
													<td>
														<?php 
															if(isset($BookingDetails['sender_postcode']) && !empty($BookingDetails['sender_postcode'])) {
																echo valid_output($BookingDetails['sender_postcode']);
															}
															 
														?>
													</td>
												</tr>
											</table>
										</td>
									</tr>	
									<tr>
										<td align="left" valign="top" colspan="4">
											<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
												<tr>
													<td align="left" valign="top" class="heading"><?php echo VIEW_SENDER_CONTACT_NUMBER; ?></td>
													<td class="heading"><?php echo VIEW_SENDER_EMAIL; ?></td>
													<td align="left" valign="top" class="heading"><?php echo VIEW_SENDER_ALTERNATE_NUMBER; ?></td>
												</tr>
												<tr>
													<td>
														<?php 
															if(isset($BookingDetails['sender_area_code']) && !empty($BookingDetails['sender_area_code']) && (isset($BookingDetails['sender_contact_no']) && !empty($BookingDetails['sender_contact_no']))) {
																echo $BookingDetails['sender_area_code']." ".valid_output($BookingDetails['sender_contact_no']);
															}
															 
														?>
													</td>
													<td>
														<?php 
															if(isset($BookingDetails['sender_email']) && !empty($BookingDetails['sender_email'])) {
																echo $BookingDetails['sender_email'];
															}
															 
														?>
													</td>
													<td>
														<?php 
															if(isset($BookingDetails['sender_mb_area_code']) && !empty($BookingDetails['sender_mb_area_code']) && (isset($BookingDetails['sender_mobile_no']) && !empty($BookingDetails['sender_mobile_no']))) {
																echo valid_output($BookingDetails['sender_mb_area_code'])." ".valid_output($BookingDetails['sender_mobile_no']);
															}
															 
														?>
													</td>
												</tr>
											</table>
										</td>
									</tr>
									<tr>
										<td  align="left" valign="top" class="heading">
											<?php 
												echo VIEW_TO;
											?>
										</td>
										<td  align="left" valign="top"></td>
										<td  align="left" valign="top"></td>
										<td  align="left" valign="top"></td>
									</tr>
									<tr>
										<td  align="left" valign="top">
										<?php
											echo ucfirst(valid_output($BookingDetails['reciever_firstname']))." ".valid_output($BookingDetails['reciever_surname'])."</h5></br>";
											if(isset($BookingDetails['reciever_company_name']) && !empty($BookingDetails['reciever_company_name'])){
												echo valid_output($BookingDetails['reciever_company_name'])."</br>";
											}
											if(isset($BookingDetails['reciever_address_1']) && !empty($BookingDetails['reciever_address_1'])){
													echo valid_output($BookingDetails['reciever_address_1'])."</br>";
											}
											if(isset($BookingDetails['reciever_address_2']) && !empty($BookingDetails['reciever_address_2'])){
													echo valid_output($BookingDetails['reciever_address_2'])."</br>";
											}
											if(isset($BookingDetails['reciever_address_3']) && !empty($BookingDetails['reciever_address_3'])){
													echo valid_output($BookingDetails['reciever_address_3'])."</br>";
											}

											if($BookingDetails['service_name']=="international")
											{
													if(is_numeric($BookingDetails['deliveryid'])){echo valid_output($countries_name)."</br>";}
											}
											echo $BookingDetails['reciever_suburb']." ".valid_output($BookingDetails['reciever_state'])." ".valid_output($BookingDetails['reciever_postcode'])."</br>";
											if(isset($BookingDetails['flag']) && ($BookingDetails['flag']=="australia")) {
												echo "Australia</br>";
											}
											echo valid_output($BookingDetails['reciever_area_code'])." ".valid_output($BookingDetails['reciever_contact_no'])."</br>";
											if($BookingDetails['reciever_mobile_no']){
													echo valid_output($BookingDetails['reciever_mb_area_code'])." ".valid_output($BookingDetails['reciever_mobile_no']);
											}
										?>
										</td>
										<td  align="left" valign="top"></td>
										<td  align="left" valign="top"></td>
										<td  align="left" valign="top"></td>
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
</table>
</body>
</html>
