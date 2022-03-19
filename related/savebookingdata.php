<?php
	require_once(DIR_WS_MODEL ."ClientAddressMaster.php");

	$objClientAddressMaster = ClientAddressMaster::Create();
	$objClientAddressData=new ClientAddressData();

	$BookingDetailsMasterObj = BookingDetailsMaster::create();
	$BookingDetailsDataObj = new BookingDetailsData();

	$BookingItemDetailsMasterObj = BookingItemDetailsMaster::create();
	$BookingItemDetailsDataObj = new BookingItemDetailsData();

	$ObjBookingDisDetMaster		=BookingDiscountDetailsMaster::create();
	$ObjBookingDiscountData		=new BookingDiscountDetailsData();

	require_once(DIR_WS_MODEL . "ServiceMaster.php");
	require_once(DIR_WS_CURRENT_LANGUAGE . "savebookingdata.php");

	$ServiceMasterObj = ServiceMaster::create();
	$ServiceDataObj   = new ServiceData();

	//Get Booking Data From Session
	$delivery_address_flag = $__Session->GetValue("delivery_address_flag");
	$pickup_address_flag = $__Session->GetValue("pickup_address_flag");
	$BookingDetailsData = $__Session->GetValue("booking_details");
	/*echo "<pre>";
	print_r($_SESSION);
	echo "</pre>";
	exit();*/
	if(isset($_SESSION['set_pkp_addressbook']) && $_SESSION['set_pkp_addressbook']==1 && (isset($payment_success) && $payment_success == true))
	{
		$objClientPkpAddressDataArray = $__Session->GetValue("client_address_pickup");

			if(is_array($objClientPkpAddressDataArray)) {

					$objClientPkpAddressData =  new ClientAddressData();

						foreach ($objClientPkpAddressDataArray as $key=>$val) {

								$objClientPkpAddressData->{$key}=$val;
						}

			}
		/*Start for the logic of serial_address_id */
		$srExitAdd[]	=	array('Search_On'    => 'userid',
							  'Search_Value' => $userid,
							  'Type'         => 'int',
							  'Equation'     => '=',
							  'CondType'     => 'AND',
							  'Prefix'       => '',
							  'Postfix'      => '');
		$srExitClientAddressData = $objClientAddressMaster->GetClientAddress('null',$srExitAdd);
		//$srExitClientAddressData = $srExitClientAddressData[0];

		if(!empty($srExitClientAddressData))
		{
			$count = count($srExitClientAddressData);
		}

		if($count == 0)
		{
			$objClientPkpAddressData->serial_address_id = 1;
		}else
		{

			$i =1;
			$serialArr = array();
			$unproperSerialArr = array();
			foreach($srExitClientAddressData as $key){
				$serialArr[] = $i;
				$unproperSerialArr[] = $key['serial_address_id'];
				$i++;
			}

			$new_list=array_diff($serialArr,$unproperSerialArr);
			foreach($new_list as $j)
			{
				$objClientPkpAddressData->serial_address_id = $j;
			}

			if(empty($objClientPkpAddressData->serial_address_id))
			{

				$srMaxAdd  = array();
				$srMaxAdd[]	=	array('Search_On'    => 'userid',
							  'Search_Value' => $userid,
							  'Type'         => 'int',
							  'Equation'     => '=',
							  'CondType'     => 'AND',
							  'Prefix'       => '',
							  'Postfix'      => '');

				$maxFieldArr = array("max(serial_address_id) as address_id");
				$srMaxClientAddressData = $objClientAddressMaster->GetClientAddress($maxFieldArr,$srMaxAdd);
				$srMaxClientAddressData = $srMaxClientAddressData[0];
				$objClientPkpAddressData->serial_address_id = $srMaxClientAddressData['address_id']+1;

			}
		}


		/*End for the logic of serial_address_id */
		$objClientPkpAddressData->userid=(int)$userid;
		
		$objClientAddressMaster->addClientAddress($objClientPkpAddressData);
	}
	// if(isset($payment_success) && $payment_success == true){
	
	if(isset($_SESSION['set_del_addressbook']) && $_SESSION['set_del_addressbook']==1 && (isset($payment_success) && $payment_success == true))
	{
		$objClientDelAddressDataArray = $__Session->GetValue("client_address_dilivery");

			if(is_array($objClientDelAddressDataArray)) {

				$objClientDelAddressData =  new ClientAddressData();

					foreach ($objClientDelAddressDataArray as $key=>$val) {

						$objClientDelAddressData->{$key}=valid_output($val);
					}

			}

			/*Start for the logic of serial_address_id */
			$srExitAdd[]	=	array('Search_On'    => 'userid',
			                      'Search_Value' => $userid,
			                      'Type'         => 'int',
			                      'Equation'     => '=',
			                      'CondType'     => 'AND',
			                      'Prefix'       => '',
			                      'Postfix'      => '');
			$srExitClientAddressData = $objClientAddressMaster->GetClientAddress('null',$srExitAdd);
			//$srExitClientAddressData = $srExitClientAddressData[0];

			if(!empty($srExitClientAddressData))
			{
				$count = count($srExitClientAddressData);
			}

			if($count == 0)
			{
				$objClientDelAddressData->serial_address_id = 1;
			}else
			{

				$i =1;
				$serialArr = array();
				$unproperSerialArr = array();
				foreach($srExitClientAddressData as $key){
					$serialArr[] = $i;
					$unproperSerialArr[] = $key['serial_address_id'];
					$i++;
				}
				$new_list=array_diff($serialArr,$unproperSerialArr);
				foreach($new_list as $j)
				{
					$objClientDelAddressData->serial_address_id = $j;
				}

				if(empty($objClientDelAddressData->serial_address_id))
				{
					$srMaxAdd  = array();
					$srMaxAdd[]	=	array('Search_On'    => 'userid',
			                      'Search_Value' => $userid,
			                      'Type'         => 'int',
			                      'Equation'     => '=',
			                      'CondType'     => 'AND',
			                      'Prefix'       => '',
			                      'Postfix'      => '');

					$maxFieldArr = array("max(serial_address_id) as address_id");
					$srMaxClientAddressData = $objClientAddressMaster->GetClientAddress($maxFieldArr,$srMaxAdd);
					$srMaxClientAddressData = $srMaxClientAddressData[0];
					$objClientDelAddressData->serial_address_id = $srMaxClientAddressData['address_id']+1;

				}
			}

			/*End for the logic of serial_address_id */

			$objClientDelAddressData->userid=(int)$userid;
			
			$objClientAddressMaster->addClientAddress($objClientDelAddressData);
			
	}
	//exit();
	//This variable declared by shailesh jamanapara on Date Thu Jun 13 12:44:54 IST 2013
	//$BookingDetailsData['date_ready'] = valid_output($BookingDetailsData['start_date']);
	$BookingDetailsData['date_ready'] = date("Y-m-d",strtotime($BookingDetailsData['date_ready']));
	$BookingDetailsData['time_ready'] = $BookingDetailsData['time_ready'];
	$BookingDetailsData['close_time'] = $BookingDetailsData['close_time'];

	//Convert in Object for insert in db
	unset($BookingDetailsData['prc']);
	unset($BookingDetailsData['drc']);
	unset($BookingDetailsData['start_date']);
	unset($BookingDetailsData['min_date']);
	unset($BookingDetailsData['time_hr']);
	unset($BookingDetailsData['time_sec']);
	unset($BookingDetailsData['hr_formate']);
	//unset($BookingDetailsData['without_gst_coverage_rate']);
	//unset($BookingDetailsData['goods_nature']);
	//unset($BookingDetailsData['sender_area_code']);
	//unset($BookingDetailsData['reciever_area_code']);
	unset($BookingDetailsData['standard_rate']);

	////if($BookingDetailsData['servicepagename']=="domestic")
	 if($BookingDetailsData['servicepagename']=="overnight" || $BookingDetailsData['servicepagename']=="sameday")
	{
		//$BookingDetailsDataObj->rate=$BookingDetailsData[$BookingDetailsData['rate']];
		$BookingDetailsDataObj->rate=$BookingDetailsData['rate'];

		unset($BookingDetailsData['overnight_rate']);
		unset($BookingDetailsData['economy_rate']);



			$fieldArr=array("*");
			$seaByArr=array();
			$service_data=$ServiceMasterObj->getService($fieldArr,$seaByArr);
			foreach($service_data as $service_val)
			{
				unset($BookingDetailsData[strtolower($service_val->service_name)."_rate"]);
				unset($BookingDetailsData[strtolower($service_val->service_name)."_supplier"]);
			}

	}else{
		$BookingDetailsData['rate']=$BookingDetailsData[$BookingDetailsData['service_name']."_rate"];

	}
	/*echo "<pre>";
	print_r($BookingDetailsData);
	echo "</pre>";
	exit();*/
	foreach ($BookingDetailsData as $key=>$val) {
		$BookingDetailsDataObj->{$key}=valid_output($val);

	}
	//echo "bookingid:".$__Session->GetValue("booking_id");

	//exit();
	$pickupseaArr[0] = array('Search_On'    => 'id',
                      'Search_Value' => (int)$BookingDetailsDataObj->p_id,
                      'Type'         => 'string',
                      'Equation'     => '=',
                      'CondType'     => '',
                      'Prefix'       => '',
                      'Postfix'      => '');
	$PostCodeDataObj = $PostCodeMasterObj->getPostCode('null',false,$pickupseaArr);
	$Pickupvalue=$PostCodeDataObj[0];



	if(isset($userid) && $userid!="") {
		$BookingDetailsDataObj->userid=(int)$userid;		//userid for db
	} else {
		$BookingDetailsDataObj->userid=0;
	}

	//Get Booking ItemData From Session
	$BookingItemDetailsData = $__Session->GetValue("booking_details_items");
	$t=0;
	if(isset($BookingItemDetailsData))
	{
		foreach ($BookingItemDetailsData as $key=>$BookingItemDetails1) {
		unset($BookingItemDetailsData[$t]['weight_status']);
		unset($BookingItemDetailsData[$t]['qty_status']);
		unset($BookingItemDetailsData[$t]['dim_status']);
	 $t++;
	}
	}
	//echo "auto id:".$__Session->GetValue("auto_id")."</br>";
	if($__Session->GetValue("auto_id") == '')  {


		if($_POST['payment_email']!='')
		{
			$BookingDetailsDataObj['payment_email']=$_POST['payment_email'];
		}

		if($BookingDetailsDataObj['rate'])
		{
			$err['rate'] = isFloat(valid_input($BookingDetailsDataObj['rate']),"Please enter float values.");
		}
		if($BookingDetailsDataObj['flag'])
		{
			$err['flag'] = chkStr(valid_input($BookingDetailsDataObj['flag']));
		}
		if($BookingDetailsDataObj['payment_done'])
		{
			$err['payment_done'] = chkStr(valid_input($BookingDetailsDataObj['payment_done']));
		}
		if($BookingDetailsDataObj['pickupid'])
		{
			$err['pickupid'] = chkStr(valid_input($BookingDetailsDataObj['pickupid']));
		}
		if($BookingDetailsDataObj['deliveryid'])
		{
			$err['deliveryid'] = chkStr(valid_input($BookingDetailsDataObj['deliveryid']));
		}
		if($BookingDetailsDataObj['p_id'])
		{
			$err['p_id'] = isNumeric($BookingDetailsDataObj['p_id'],COMMON_NUMERIC_VAL);
		}
		if($BookingDetailsDataObj['d_id'])
		{
			$err['d_id'] = isNumeric($BookingDetailsDataObj['d_id'],COMMON_NUMERIC_VAL);
		}
		if($BookingDetailsDataObj['total_qty'])
		{
			$err['total_qty'] = isFloat($BookingDetailsDataObj['total_qty'],COMMON_NUMERIC_VAL);
		}
		if($BookingDetailsDataObj['total_weight'])
		{
			$err['total_weight'] = isFloat($BookingDetailsDataObj['total_weight'],COMMON_NUMERIC_VAL);
		}
		if($BookingDetailsDataObj['volumetric_weight'])
		{
			$err['volumetric_weight'] = isFloat($BookingDetailsDataObj['volumetric_weight'],COMMON_NUMERIC_VAL);
		}
		if($BookingDetailsDataObj['chargeable_weight'])
		{
			$err['chargeable_weight'] = isFloat($BookingDetailsDataObj['chargeable_weight'],COMMON_NUMERIC_VAL);
		}
		if($BookingDetailsDataObj['pickup_time_zone'])
		{
			$err['pickup_time_zone'] = chkbrkts($BookingDetailsDataObj['pickup_time_zone']);
		}
		if($BookingDetailsDataObj['delivery_time_zone'])
		{
			$err['delivery_time_zone'] = chkbrkts($BookingDetailsDataObj['delivery_time_zone']);
		}
		if($BookingDetailsDataObj['pageid'])
		{
			$err['pageid'] = isNumeric($BookingDetailsDataObj['pageid'],COMMON_NUMERIC_VAL);
		}
		if($BookingDetailsDataObj['pagename'])
		{
			$err['pagename'] = chkStr($BookingDetailsDataObj['pagename']);
		}
		if($BookingDetailsDataObj['servicepagename'])
		{
			$err['servicepagename'] = chkStr($BookingDetailsDataObj['servicepagename']);
		}
		if($BookingDetailsDataObj['service_name'])
		{
			$err['service_name'] = chkStr($BookingDetailsDataObj['service_name']);
		}
		if($BookingDetailsDataObj['description_of_goods'])
		{
			$err['description_of_goods'] = checkStr($BookingDetailsDataObj['description_of_goods']);
		}
		
		if($BookingDetailsDataObj['values_of_goods'])
		{
			$err['values_of_goods'] = isFloat($BookingDetailsDataObj['values_of_goods'],"Please enter float values.");
		}
		if($BookingDetailsDataObj['authority_to_leave'])
		{
			$err['authority_to_leave'] = checkStr($BookingDetailsDataObj['authority_to_leave']);
		}
		if($BookingDetailsDataObj['where_to_leave_shipment'])
		{
			$err['where_to_leave_shipment'] = checkStr($BookingDetailsDataObj['where_to_leave_shipment']);
		}
		if($BookingDetailsDataObj['additional_cost'])
		{
			$err['additional_cost'] = isFloat($BookingDetailsDataObj['additional_cost'],"Please enter float values.");
		}
		
		if($BookingDetailsDataObj['goods_nature'])
		{
			$err['goods_nature'] = checkStr($BookingDetailsDataObj['goods_nature']);
		}
		if($BookingDetailsDataObj['sender_first_name'])
		{
			$err['sender_first_name'] = checkName($BookingDetailsDataObj['sender_first_name']);
		}
		if($BookingDetailsDataObj['sender_surname'])
		{
			$err['sender_surname'] = checkName($BookingDetailsDataObj['sender_surname']);
		}
		if($BookingDetailsDataObj['sender_company_name'])
		{
			$err['sender_company_name'] = checkStr($BookingDetailsDataObj['sender_company_name']);
		}

		if($BookingDetailsDataObj['sender_address_1'])
		{

			$err['sender_address_1'] = chkStreetSessionData($BookingDetailsDataObj["sender_address_1"]);

		}
		if($BookingDetailsDataObj['sender_address_2'])
		{
			$err['sender_address_2'] = chkStreetSessionData($BookingDetailsDataObj['sender_address_2']);
		}
		if($BookingDetailsDataObj['sender_address_3'])
		{
			$err['sender_address_3'] = chkStreetSessionData($BookingDetailsDataObj['sender_address_3']);
		}
		if($BookingDetailsDataObj['sender_address_3'])
		{
			$err['sender_address_3'] = chkStreet($BookingDetailsDataObj['sender_address_3']);
		}
		if($BookingDetailsDataObj['sender_suburb'])
		{
			$err['sender_suburb'] = checkSuburb($BookingDetailsDataObj['sender_suburb']);
		}
		if($BookingDetailsDataObj['sender_state'])
		{
			$err['sender_state'] = chkState($BookingDetailsDataObj['sender_state']);
		}
		if($BookingDetailsDataObj['sender_postcode'])
		{
			$err['sender_postcode'] = isNumeric($BookingDetailsDataObj['sender_postcode'],ERROR_ENTER_NUMERIC_VALUE);
		}
		if($BookingDetailsDataObj['sender_email'])
		{
			$err['sender_email'] = checkEmailPattern($BookingDetailsDataObj['sender_email'],BOOKING_SENDER_EMAIL_VALID);
		}
		if($BookingDetailsDataObj['sender_contact_no'])
		{
			$err['sender_contact_no'] = areaCodePattern($BookingDetailsDataObj['sender_contact_no'],BOOKING_SENDER_CONTACTNO_ERROR,'0');
		}
		if($BookingDetailsDataObj['sender_area_code'])
		{
			$err['sender_area_code'] = areaCodePattern($BookingDetailsDataObj['sender_area_code'],BOOKING_SENDER_AREACODE_ERROR,'1');
		}
		if($BookingDetailsDataObj['flag'])
		{
			$flag = $BookingDetailsDataObj['flag'];
		}
		if($BookingDetailsDataObj['sender_mb_area_code'])
		{
			$err['sender_mb_area_code'] = areaCodePattern($BookingDetailsDataObj['sender_mb_area_code'],BOOKING_SENDER_AREACODE_ERROR,'1');
		}
		if($BookingDetailsDataObj['reciever_mb_area_code'])
		{
			$err['reciever_mb_area_code'] = areaCodePattern($BookingDetailsDataObj['reciever_mb_area_code'],BOOKING_SENDER_AREACODE_ERROR,'1');
		}
		if($BookingDetailsDataObj['sender_mobile_no'])
		{
			$err['sender_mobile_no'] = areaCodePattern($BookingDetailsDataObj['sender_mobile_no'],BOOKING_SENDER_AREACODE_ERROR,'0');
		}
		if($BookingDetailsDataObj['reciever_firstname'])
		{
			$err['reciever_firstname'] = checkName($BookingDetailsDataObj['reciever_firstname']);
		}
		if($BookingDetailsDataObj['reciever_surname'])
		{
			$err['reciever_surname'] = checkName($BookingDetailsDataObj['reciever_surname']);
		}
		if($BookingDetailsDataObj['reciever_company_name'])
		{
			$err['reciever_company_name'] = checkStr($BookingDetailsDataObj['reciever_company_name']);
		}
		if($BookingDetailsDataObj['reciever_address_1'])
		{
			$err['reciever_address_1'] = chkStreetSessionData(htmlspecialchars_decode($BookingDetailsDataObj['reciever_address_1']));
		}
		if($BookingDetailsDataObj['reciever_address_2'])
		{
			$err['reciever_address_2'] = chkStreetSessionData($BookingDetailsDataObj['reciever_address_2']);
		}
		if($BookingDetailsDataObj['reciever_address_3'])
		{
			$err['reciever_address_3'] = chkStreetSessionData($BookingDetailsDataObj['reciever_address_3']);
		}
		if($BookingDetailsDataObj['reciever_suburb'])
		{
			$err['reciever_suburb'] = checkSuburb($BookingDetailsDataObj['reciever_suburb']);
		}
		if($BookingDetailsDataObj['reciever_state'])
		{
			$err['reciever_state'] = chkState($BookingDetailsDataObj['reciever_state']);
		}
		if($flag == 'international' && $BookingDetailsDataObj['reciever_postcode'])
		{
			$err['reciever_postcode'] = chkStreet($BookingDetailsDataObj['reciever_postcode'],ERROR_ENTER_NUMERIC_VALUE);
		}else{
			$err['reciever_postcode'] = isNumeric($BookingDetailsDataObj['reciever_postcode'],ERROR_ENTER_NUMERIC_VALUE);
		}
		if($BookingDetailsDataObj['reciever_email'])
		{
			$err['reciever_email'] = checkEmailPattern($BookingDetailsDataObj['reciever_email'],BOOKING_SENDER_EMAIL_VALID);
		}
		if($BookingDetailsDataObj['reciever_contact_no'])
		{
			$err['reciever_contact_no'] = areaCodePattern($BookingDetailsDataObj['reciever_contact_no'],BOOKING_SENDER_AREACODE_ERROR,'0');
		}
		if($BookingDetailsDataObj['reciever_area_code'])
		{
			$err['reciever_area_code'] = areaCodePattern($BookingDetailsDataObj['reciever_area_code'],BOOKING_SENDER_AREACODE_ERROR,'1');
		}
		if($BookingDetailsDataObj['reciever_mobile_no'])
		{
			$err['reciever_mobile_no'] = areaCodePattern($BookingDetailsDataObj['reciever_mobile_no'],BOOKING_SENDER_AREACODE_ERROR,'0');
		}

		/*
		if($BookingDetailsDataObj['time_ready'])
		{
			$err['time_ready'] = chkRestFields($BookingDetailsDataObj['time_ready']);
		}*/
		/*if($BookingDetailsDataObj['booking_date'])
		{
			$err['booking_date'] = chkStr($BookingDetailsDataObj['booking_date']);
		}*/
		if($BookingDetailsDataObj['booking_time'])
		{
			$err['booking_time'] = chkRestFields($BookingDetailsDataObj['booking_time']);
		}
		if($BookingDetailsDataObj['delivery_fee'])
		{
			$err['delivery_fee'] = isFloat($BookingDetailsDataObj['delivery_fee'],"Please enter float values.");
		}
		if($BookingDetailsDataObj['fuel_surcharge'])
		{
			$err['fuel_surcharge'] = isFloat($BookingDetailsDataObj['fuel_surcharge'],"Please enter float values.");
		}
		/*
		if($BookingDetailsDataObj['security_surcharge'])
		{
			$err['security_surcharge'] = isFloat($BookingDetailsDataObj['security_surcharge'],"Please enter float values.");
		}*/
		if($BookingDetailsDataObj['service_surcharge'])
		{
			$err['service_surcharge'] = isFloat($BookingDetailsDataObj['service_surcharge'],"Please enter float values.");
		}
		if($BookingDetailsDataObj['total_delivery_fee'])
		{
			$err['total_delivery_fee'] = isFloat($BookingDetailsDataObj['total_delivery_fee'],"Please enter float values.");
		}
		if($BookingDetailsDataObj['discount'])
		{
			$err['discount'] = isFloat($BookingDetailsDataObj['discount'],"Please enter float values.");
		}
		if($BookingDetailsDataObj['total_dis_delivery_fee'])
		{
			$err['total_dis_delivery_fee'] = isFloat($BookingDetailsDataObj['total_dis_delivery_fee'],"Please enter float values.");
		}
		if($BookingDetailsDataObj['total_new_charge'])
		{
			$err['total_new_charge'] = isFloat($BookingDetailsDataObj['total_new_charge'],"Please enter float values.");
		}
		if($BookingDetailsDataObj['gst_surcharge'])
		{
			$err['gst_surcharge'] = isFloat($BookingDetailsDataObj['gst_surcharge'],"Please enter float values.");
		}
		/*
		if($BookingDetailsDataObj['date_ready'])
		{
			$err['date_ready'] = chkStr($BookingDetailsDataObj['date_ready']);
		}*/
		if($BookingDetailsDataObj['userid'])
		{
			$err['userid'] = isNumeric($BookingDetailsDataObj['userid'],ERROR_ENTER_NUMERIC_VALUE);
		}



		if(isset($err))
		{
			foreach($err as $key => $Value) {
				if($Value != '') {
					$Svalidation=true;
					logOut();
				}
			}
		}
		$booking_id=$__Session->GetValue("booking_id");
		//echo "bookingId:".$booking_id;
		//exit();
		//$BookingDetailsDataObj['booking_id'] = $booking_id;
		//insert in booking table


		$BookingDetailsDataID = $BookingDetailsMasterObj->addBookingDetails($BookingDetailsDataObj);
		$autoId = $BookingDetailsDataID;
		//echo "autoid:".$autoId."</br>";
		//exit();
		//This variables $BookingDicsountDetailsData  value assigned  by shailesh jamanapara Fri May 31 16:16:31 IST 2013

				$ObjBookingDiscountData->user_id 			= (int)$userid;
				$ObjBookingDiscountData->booking_id			= $booking_id;
				$ObjBookingDiscountData->booking_amt 		= $BookingDetailsDataObj->rate;
				//echo "<pre>";print_r($_SESSION);die();
				$ObjBookingDiscountData->coupon_id = 0;
				if(isset($_SESSION['couponCode']) && !empty($_SESSION['couponCode'])){
					$ObjBookingDiscountData->coupon_id 			= valid_output($_SESSION['couponCode']);
				}
				$ObjBookingDiscountData->coupon_amt = 0;
				if(isset($_SESSION['discountAmt']) && !empty($_SESSION['discountAmt'])){
					$ObjBookingDiscountData->coupon_amt 		= valid_output($_SESSION['discountAmt']);
				}
				$ObjBookingDiscountData->nett_due_amt = 0;
				if(isset($_SESSION['nett_due_amt']) && !empty($_SESSION['nett_due_amt'])){
					$ObjBookingDiscountData->nett_due_amt 		= valid_output($_SESSION['nett_due_amt']);
				}

				$ObjBookingDiscountData->verified_status	= 0;
				$ObjBookingDisDetMaster->addBookingDiscountDetails($ObjBookingDiscountData);
		$__Session->SetValue("auto_id",$BookingDetailsDataID);
		$__Session->SetValue("booking_id",$booking_id);
		$__Session->Store();
		/*echo "<pre>";
		print_r($BookingItemDetailsData);
		echo "</pre>";*/
		if(is_array($BookingItemDetailsData)) {
			//Convert in Object for insert in db
			foreach ($BookingItemDetailsData as $key=>$BookingItemDetails1) {
				/*echo "<pre>";
				print_r($BookingItemDetails1);
				echo "</pre>";*/
				$BookingItemDetails2 = new BookingItemDetailsData();
				$BookingItemDetails2->booking_id = $booking_id;
				$BookingItemDetails2->invoice_id = str_pad($autoId, 8, '67000000', STR_PAD_LEFT);
				$BookingItemDetails2->CCConnote = (int)$BookingDetailsDataObj->CCConnote;
				//$BookingItemDetails2->{$key}=($BookingItemDetails1);
				foreach ($BookingItemDetails1 as $key1=>$val) {
					$BookingItemDetails2->{$key1}=valid_output($val);
					
				}
				/*echo "<pre>";
		print_r($BookingItemDetails2);
		echo "</pre>";*/
				$__Session->SetValue("invoice_id",str_pad($autoId, 8, '67000000', STR_PAD_LEFT));
				$__Session->Store();

				$BookingItemDetailsMasterObj->addBookingItemDetails($BookingItemDetails2);
			}
			
		//exit();
			
		}
	} else {

		$booking_id=$__Session->GetValue("booking_id");
		$autoId = $__Session->GetValue("auto_id");
		//echo "booking id:".$booking_id;
		//update in booking table
		//$BookingDetailsDataObj->booking_id = $booking_id;
		$BookingDetailsDataObj->auto_id = $autoId;
		
		//echo "test".$BookingDetailsDataObj->booking_id;
		//exit();
		$BookingDetailsDataID = $BookingDetailsMasterObj->editBookingDetails($BookingDetailsDataObj);

		//delete booking items from db, it can't be update with no uniqe so...
		$BookingItemDetailsMasterObj->deleteBookingItemDetails($booking_id);
		if(is_array($BookingItemDetailsData)) {
			//Convert in Object for insert in db
			foreach ($BookingItemDetailsData as $key=>$BookingItemDetails1) {
				$BookingItemDetails2 = new BookingItemDetailsData();
				$BookingItemDetails2->booking_id=$booking_id;
				$BookingItemDetails2->invoice_id = str_pad($autoId, 8, '67000000', STR_PAD_LEFT);
				$BookingItemDetails2->CCConnote=(int)$BookingDetailsDataObj->CCConnote;
				foreach ($BookingItemDetails1 as $key1=>$val) {
					$BookingItemDetails2->{$key1}=valid_output($val);
				}
				$__Session->SetValue("invoice_id",str_pad($autoId, 8, '67000000', STR_PAD_LEFT));
				$__Session->Store();

				$BookingItemDetailsMasterObj->addBookingItemDetails($BookingItemDetails2);
			}
			
		}
	}


	

?>
