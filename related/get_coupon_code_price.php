<?php
	require_once("../lib/common.php");
	require_once(DIR_WS_CURRENT_LANGUAGE."booking.php");
	
	$BookingDetailsDataObj = $__Session->GetValue("booking_details");
	$BookingDatashow = new stdClass;
	foreach ($BookingDetailsDataObj as $key=>$val) {
		$BookingDatashow->{$key}=valid_output($val);
	}
	//echo $_SESSION['coverage_rate'];
	
	//echo "due amount:".$_SESSION['due_amt'];
	$flag = $BookingDatashow->flag;
	$Action 			= valid_input($_POST['Action']);
	$user_input_code 	= valid_input($_POST['couponCode']);
	$btnCoupon = $_POST['btnCoupon'];
				
	$due_amt 			= valid_input($_SESSION['due_amt']);
	$base_fuel_amt       = valid_input($_SESSION['base_fuel_fee']);
	$transit_amt        = valid_input($BookingDatashow->without_gst_coverage_rate);
	//echo "due amount:".$due_amt;
	$residential_amt = valid_input($BookingDatashow->service_surcharge);
	$total_tansit_gst = $_SESSION['total_transit_gst'];
	
	if($_SESSION['total_gst']!='undefined')
	{
		$gst                = valid_input($_SESSION['total_gst']); 
		$err['gst']         = isFloat($gst,"Please enter float values.");
	}
	$err['action'] 		= chkSmall($Action);
	$err['couponCode'] 	= chkTrk($user_input_code);
	$err['due_amt'] 	= isFloat($due_amt,"Please enter float values.");
	$err['transit_amt'] = isFloat($transit_amt,"Please enter float values.");
	
	
	foreach($err as $key => $Value) {
  		if($Value != '') {
  			$Svalidation=true;
  		}
	}
	
	if(isset($Action) && $Action =='calculate' && $_POST['couponCode']!='' && $Svalidation == false && $btnCoupon=='Redeem'){
		require_once(DIR_WS_MODEL . "CouponMaster.php");
		require_once(DIR_WS_MODEL . "BookingDiscountDetailsMaster.php");
		$ObjCouponMaster 	= CouponMaster::create();
		$ObjCouponData		= new CouponData(); 
		$ObjBookingDisDetMaster	= BookingDiscountDetailsMaster::create();
		$ObjBookingDiscountData	= new BookingDiscountDetailsData();
		
		$current_date = date('Y-m-d');
		$btnSubmit       = ADMIN_COUPON_EDIT;
		$couponArr = array();
		$couponArr[] = array('Search_On'=>'coupon_code', 'Search_Value'=>$user_input_code, 'Type'=>'string', 'Equation'=>'=','CondType'=>'AND', 'Prefix'=>'', 'Postfix'=>'');
		$couponArr[] =	array('Search_On'=>'coupon_start_date','Search_Value'=>$current_date,'Type'=>'string','Equation'=>'<=','CondType'=>'AND','Prefix'=>'','Postfix'=>'');
		$couponArr[] =	array('Search_On'=>'coupon_end_date','Search_Value'=>$current_date,'Type'=>'string','Equation'=>'>=','CondType'=>'AND','Prefix'=>'','Postfix'=>'');
		$ObjCouponData = $ObjCouponMaster->getCoupon(null, $couponArr);

		if($ObjCouponData){
			
			$ObjCouponData 			= $ObjCouponData[0];
			$CouponUsage 			= $ObjCouponData->coupon_usage;
			$coupon_code	 		= $ObjCouponData->coupon_code;
			
			if($CouponUsage == 'One')
			{
				$couponUsedArr = array();
				$couponUsedArr[] = array('Search_On'=>'coupon_id', 'Search_Value'=>$coupon_code, 'Type'=>'string', 'Equation'=>'=','CondType'=>'AND', 'Prefix'=>'', 'Postfix'=>'');
				$ObjBookingDiscountData = $ObjBookingDisDetMaster->getBookingDiscountDetails(null,$couponUsedArr);
				
				$couponCount = count($ObjBookingDiscountData[0]); // It is to check how many times coupon has been used
				
				if($couponCount >= 1)
				{
					$return = "0";
					$calculate = "0";
				}
				else
				{
					$calculate = "1";
				}
			}elseif($CouponUsage == 'EUser' && SES_USER_ID !=0)
			{
				
				$couponUsedArr = array();
				$couponUsedArr[] = array('Search_On'=>'coupon_id', 'Search_Value'=>$coupon_code, 'Type'=>'string', 'Equation'=>'=','CondType'=>'AND', 'Prefix'=>'', 'Postfix'=>'');
				$couponUsedArr[] = array('Search_On'=>'user_id', 'Search_Value'=>SES_USER_ID, 'Type'=>'string', 'Equation'=>'=','CondType'=>'AND', 'Prefix'=>'', 'Postfix'=>'');
				$ObjBookingDiscountData = $ObjBookingDisDetMaster->getBookingDiscountDetails(null,$couponUsedArr);
				$couponCount = count($ObjBookingDiscountData[0]); // It is to check how many times coupon has been used
				
				if($couponCount >= 1)
				{
					$return = "0";
					$calculate = "0";
				}else
				{
					$calculate = "1";
				}
				
			}else{
				$calculate = "1";
			}
			
			if($calculate == "1")
			{			
			
				$coupon_coupon_amount 	= number_format($ObjCouponData->coupon_amount,2, '.', '');
				
				$coupon_type	 		= $ObjCouponData->coupon_type;
				//echo "due amount:".$due_amt."</br>";
				if($coupon_type == 2){
					$discountAmt	= number_format(floatval(floatval($due_amt/100) * $coupon_coupon_amount),2, '.', '');
				}else{
					$discountAmt	= number_format($coupon_coupon_amount,2, '.', '');
				}
				//echo $due_amt."---".$discountAmt."</br>";
				//exit();
				$nett_due_amt 		= number_format(floatval($due_amt - $discountAmt),2, '.', ''); // new base delivery fee after discount
				//echo "base fuel amt:".$base_fuel_amt."net due amt:".$nett_due_amt."</br>";
				
				$fuel_surcharge =calculate_fuel_charge($base_fuel_amt,$nett_due_amt);
				
				$fuel_surcharge = number_format(floatval($fuel_surcharge),2, '.', '');	
				
				$amt_delivery_fee = $nett_due_amt+$fuel_surcharge;
				//echo "after fuel surcharge add:".$amt_delivery_fee;
				
				if($transit_amt){
					$total_new_charges  = number_format(floatval($nett_due_amt),2, '.', '')+$fuel_surcharge+$transit_amt;
				}else{
					$total_new_charges  = number_format(floatval($nett_due_amt),2, '.', '')+$fuel_surcharge;
				}
				if($residential_amt)
				{
					$total_new_charges  = number_format(floatval($nett_due_amt),2, '.', '')+$fuel_surcharge+$residential_amt;
				}
				//echo "after addition of residential"$total_new_charges;
				if($flag == 'australia')
				{
					//$total_gst_delivery =  calculate_gst_charge(GST,$nett_due_amt);
					$total_gst_delivery =  calculate_gst_charge(GST,$total_new_charges);
				}else{
					$total_gst_delivery = 0;
					
				}
				//echo $total_new_charges."after gst delivery fee".$total_gst_delivery;
				//exit();
				$total_gst = $total_gst_delivery+$total_tansit_gst;
				$total_delivery_fee =  number_format(floatval($nett_due_amt),2, '.', '')+$fuel_surcharge+$total_gst_delivery+$residential_amt;
				$total_due = number_format(floatval($total_new_charges + $total_gst),2, '.', '');
				// here we returns couponcode ,coupon amount and type of coupon calculation (Percentage OR Flat amount)
				unset($_SESSION['final_fuel_fee']);
				unset($_SESSION['nett_due_amt']);
				unset($_SESSION['total_new_charges']);
				unset($_SESSION['total_due']);
				unset($_SESSION['discountAmt']);
				unset($_SESSION['couponCode']);
				unset($_SESSION['total_gst']);
				unset($_SESSION['total_tansit_gst']);
				unset($_SESSION['total_gst_delivery']);
				unset($_SESSION['total_delivery_fee']);
				
				$_SESSION['nett_due_amt'] 	= $nett_due_amt; 
				$_SESSION['discountAmt'] 	= $discountAmt; 
				$_SESSION['couponCode'] 	= $user_input_code; 
				$_SESSION['total_new_charges'] = $total_new_charges;
				$_SESSION['final_fuel_fee'] = $fuel_surcharge;
				$_SESSION['total_due'] = $total_due;
				$_SESSION['total_gst'] =  $total_gst;
				$_SESSION['total_tansit_gst'] =  $total_tansit_gst;
				$_SESSION['total_gst_delivery'] = $total_gst_delivery;
				//echo $_SESSION['discountAmt'];
				$_SESSION['total_delivery_fee'] = $total_delivery_fee;
				
				/* Adding values to session */
				$BookingDatashow->discount = $_SESSION['discountAmt'];
				$BookingDatashow->delivery_fee = $_SESSION['nett_due_amt'];
				$BookingDatashow->fuel_surcharge = $_SESSION['final_fuel_fee'];
				$BookingDatashow->total_delivery_fee = $_SESSION['total_delivery_fee'];
				$BookingDatashow->total_gst_delivery = $_SESSION['total_gst_delivery'];
				$BookingDatashow->rate = $total_due;
				$__Session->SetValue("booking_details",$BookingDatashow);
				
				$__Session->Store();
				$BookingDetailsData = $__Session->GetValue("booking_details");
				/*
				echo "<pre>";
				print_R($BookingDetailsData);
				echo "</pre>";
				/* Adding values to session */
				
				$return = $discountAmt."^^^".$nett_due_amt."^^^".$fuel_surcharge."^^^".$total_gst_delivery."^^^".$total_delivery_fee."^^^".$total_new_charges."^^^".$total_gst."^^^".$total_due;
				
			}
		}else{
			$return = "0";
		}
		echo $return;
	}else
	{
		/* Unset values */
		unset($_SESSION['final_fuel_fee']);
		unset($_SESSION['nett_due_amt']);
		unset($_SESSION['total_new_charges']);
		unset($_SESSION['total_due']);
		unset($_SESSION['discountAmt']);
		unset($_SESSION['couponCode']);
		unset($_SESSION['total_gst']);
		unset($_SESSION['total_tansit_gst']);
		unset($_SESSION['total_gst_delivery']);
		unset($_SESSION['total_delivery_fee']);
		
		foreach($err as $key => $Value) {
			if($Value != '') {
				$return = $Value;
				echo "0";
			}
		}
	}
?>