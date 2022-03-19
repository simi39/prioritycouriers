<?php
/**
 * This is BookingDetailsMaster file.
 * This file contains all the business logic code related to booking_details table.
 *
 * TABLE_NAME:    booking_details
 * PRIMARY_KEY :  booking_id
 * TABLE_COLUMNS: booking_id,"pickupid","deliveryid","total_qty","total_weight","volumetric_weight","chargeable_weight","standard_rate","express_rate","priority_rate","overnight_rate","economy_rate","description_of_goods","dangerous_goods","values_of_goods","authority_to_leave","where_to_leave_shipment","additional_cost","service_name","sender_first_name","sender_surname","sender_company_name","sender_address_1","sender_address_2","sender_address_3","sender_suburb","sender_state","sender_postcode","sender_email","sender_contact_no","sender_mobile_no","reciever_firstname","reciever_surname","reciever_company_name","reciever_address_1","reciever_address_2","reciever_address_3","reciever_suburb","reciever_state","reciever_postcode","reciever_email","reciever_contact_no","reciever_mobile_no","date_ready","time_ready,"userid","international_rate","flag","pageid","payment_email"
 *
 * @uses By creating object of BookingDetailsMaster we can handle or manage different table operation like insert, update, delete and selecting data with criteria from table.
 *
 * @package    BookingDetailsPackage
 * @author     Radixweb
 * @copyright  Document Copyright information, e.g. Copyright (c) 2008, Radixweb
 * @license    Display a hyperlink to a URL for a license, e.g. http://opensource.org/licenses/gpl-license.php GNU Public License
 * @version    $Id: BookingDetailsMaster.php,v 1.0
 * @link       Display a hyperlink to a URL in the documentation, e.g. http://radixweb.com
 * @since      Document when (at which version) an element was first added to a package e.g. Version 1.0
 *
 */

/**
 * @see BookingDetailsData.php for Data class
 */
require_once(DIR_WS_MODEL."/BookingDetailsData.php");

/**
 * @see RMasterModel.php for extended RMasterModel class
 */
require_once(DIR_LIB_CLASSES_MODELS."/RMasterModel.php");

class BookingDetailsMaster extends RMasterModel
{

	/**
	 * Create a null object of BookingDetailsMaster
	 *
	 * @return object object $BookingDetailsMasterObj
	 */
	public function create()
	{
		$BookingDetailsMasterObj = new BookingDetailsMaster();
		return  $BookingDetailsMasterObj;
	}//create Function End

	/**
	 * To insert record in booking_details table
	 * Insert data of columns : booking_id,"pickupid","deliveryid","total_qty","total_weight","volumetric_weight","chargeable_weight","standard_rate","express_rate","priority_rate","overnight_rate","economy_rate","description_of_goods","dangerous_goods","values_of_goods","authority_to_leave","where_to_leave_shipment","additional_cost","service_name","sender_first_name","sender_surname","sender_company_name","sender_address_1","sender_address_2","sender_address_3","sender_suburb","sender_state","sender_postcode","sender_email","sender_contact_no","sender_mobile_no","reciever_firstname","reciever_surname","reciever_company_name","reciever_address_1","reciever_address_2","reciever_address_3","reciever_suburb","reciever_state","reciever_postcode","reciever_email","reciever_contact_no","reciever_mobile_no","date_ready","time_ready","userid","international_rate","flag"
	 *
	 * @param arrayBookingDetailsData $BookingDetailsData
	 * @param bool $ThrowError Whether to throw error or not
	 *
	 * @return int If any error, then Throw Exception otherwise inserted row id
	 */
	 public function addBookingDetails($BookingDetailsData, $ThrowError=true,$from_admin=false)
	 {
	 		//build up insert query

	 		if($from_admin==true){

	 			$FinalData = $BookingDetailsData->InternalSync(RDataModel::INSERT,'auto_id', "booking_id","pickupid","deliveryid","distance_in_km","total_qty","total_volume","total_weight","volumetric_weight","chargeable_weight","description_of_goods","dangerousgoods","values_of_goods","currency_codes","export_reason","country_origin","commercial_invoice_provider","authority_to_leave","where_to_leave_shipment","additional_cost","service_name","sender_first_name","sender_surname","sender_company_name","sender_address_1","sender_address_2","sender_address_3","sender_suburb","sender_state","sender_postcode","sender_email","sender_contact_no","sender_mobile_no","reciever_firstname","reciever_surname","reciever_company_name","reciever_address_1","reciever_address_2","reciever_address_3","reciever_suburb","reciever_state","reciever_state_code","reciever_postcode","reciever_email","reciever_contact_no","reciever_mobile_no","date_ready","time_ready","close_time","booking_date","booking_time","pickup_time_zone","delivery_time_zone","userid","international_rate","flag","pageid","pagename","servicepagename","p_id","d_id","commercial_invoice","CCConnote","shipment_number","webservice","tracking_status","goods_nature","sender_area_code","reciever_area_code","sender_mb_area_code","reciever_mb_area_code");

	 		}else{

	 			$FinalData = $BookingDetailsData->InternalSync(RDataModel::INSERT,'auto_id',"booking_id","pickupid","deliveryid","distance_in_km","total_qty","total_volume","total_weight","volumetric_weight","chargeable_weight","delivery_fee","fuel_surcharge","service_surcharge","total_delivery_fee","discount","total_dis_delivery_fee","values_of_goods","currency_codes","export_reason","country_origin","commercial_invoice_provider","total_new_charge","gst_surcharge","total_gst_delivery","rate","description_of_goods","dangerousgoods","authority_to_leave","where_to_leave_shipment","additional_cost","service_name","sender_first_name","sender_surname","sender_company_name","sender_address_1","sender_address_2","sender_address_3","sender_suburb","sender_state","sender_postcode","sender_email","sender_contact_no","sender_mobile_no","reciever_firstname","reciever_surname","reciever_company_name","reciever_address_1","reciever_address_2","reciever_address_3","reciever_suburb","reciever_state","reciever_state_code","reciever_postcode","reciever_email","reciever_contact_no","reciever_mobile_no","date_ready","time_ready","close_time","booking_date","booking_time","pickup_time_zone","delivery_time_zone","userid","international_rate","flag","pageid","pagename","servicepagename","CCConnote","shipment_number","p_id","d_id","commercial_invoice","webservice","payment_email","goods_nature","sender_area_code","reciever_area_code","sender_mb_area_code","reciever_mb_area_code","payment_type","payment_done","transaction_id","delivery_fee_org","fuel_surcharge_org","total_gst_delivery_org","total_delivery_fee_org","pickup_location_type","delivery_location_type");
	 		}

		 	$Query = "INSERT INTO booking_details $FinalData";
			//echo $Query;
			//exit();


		 	/**
			  * check that data should be inserted successfully.
			  * if no then throw or return proper error message.
			  */
		 	$ThrowException = null;
	 		try {

				$Rs=$this->Connection->Execute($Query);
				if ($Rs->AffectedRows() ==  0) {
					throw new Exception(' Fail To Add New booking_details Record');
				}

			}
			catch(Exception $Exception) {

				if($ThrowError == true){
					echo $Query;
					$ThrowException = new Exception(' Fail To Add booking_details Record ');
				} else {
					return false;
				}//if-else end

			}// try -catch end

			if ($ThrowException) {
				throw $ThrowException;
			} else {
				return $this->Connection->LastInsertedId();
			}

	}//addBookingDetails Function End



	/**
	 * To update record of booking_details table
	 * Update data of columns : booking_id,"pickupid","deliveryid","total_qty","total_weight","volumetric_weight","chargeable_weight","standard_rate","express_rate","priority_rate","overnight_rate","economy_rate","description_of_goods","dangerous_goods","transient_warranty","values_of_goods","authority_to_leave","where_to_leave_shipment","additional_cost","service_name","sender_first_name","sender_surname","sender_company_name","sender_address_1","sender_address_2","sender_address_3","sender_suburb","sender_state","sender_postcode","sender_email","sender_contact_no","sender_mobile_no","reciever_firstname","reciever_surname","reciever_company_name","reciever_address_1","reciever_address_2","reciever_address_3","reciever_suburb","reciever_state","reciever_postcode","reciever_email","reciever_contact_no","reciever_mobile_no","date_ready","time_ready","userid","international_rate","flag"
	 *
	 * @param arrayBookingDetailsData $BookingDetailsData
	 * @param bool $ThrowError Whether to throw error or not
	 *
	 * @return bool If any error, then Throw Exception otherwise return true on success and false on failure
	 */
	public function editBookingDetails($BookingDetailsData, $statusChange = null, $ThrowError=true)
	{

		//echo "status:".$statusChange;
		//build up update query
		if($statusChange == "1"){// only for userid update, not effect other values
			$UpdateData = $BookingDetailsData->InternalSync(RDataModel::UPDATE,"userid","pageid");
		}
		else if($statusChange == "service"){// only for userid update, not effect other values
			$UpdateData = $BookingDetailsData->InternalSync(RDataModel::UPDATE,"userid","pageid","service_name","servicepagename");
		}
		else if($statusChange =="2")
		{
				$UpdateData = $BookingDetailsData->InternalSync(RDataModel::UPDATE,"auto_id","booking_id","pickupid","deliveryid","distance_in_km","total_qty","total_volume","total_weight","volumetric_weight","chargeable_weight","description_of_goods","dangerousgoods","values_of_goods","currency_codes","export_reason","country_origin","commercial_invoice_provider","authority_to_leave","where_to_leave_shipment","additional_cost","service_name","sender_first_name","sender_surname","sender_company_name","sender_address_1","sender_address_2","sender_address_3","sender_suburb","sender_state","sender_postcode","sender_email","sender_contact_no","sender_mobile_no","reciever_firstname","reciever_surname","reciever_company_name","reciever_address_1","reciever_address_2","reciever_address_3","reciever_suburb","reciever_state","reciever_state_code","reciever_postcode","reciever_email","reciever_contact_no","reciever_mobile_no","date_ready","time_ready","close_time","booking_date","booking_time","pickup_time_zone","delivery_time_zone","userid","international_rate","flag","commercial_invoice","payment_done","payment_type","pickup_location_type","delivery_location_type");
		}
		else if ($statusChange =="index") //update query for index page
		{
			 $UpdateData = $BookingDetailsData->InternalSync(RDataModel::UPDATE,"auto_id","booking_id","pickupid","deliveryid","distance_in_km","total_qty","total_volume","total_weight","volumetric_weight","chargeable_weight","pickup_time_zone","delivery_time_zone","international_rate","flag","pageid","userid","pagename","p_id","d_id","pro_froma_invoice");

	    }
		else if ($statusChange =="shipping") //update query for domestic shipping page
		{
			 $UpdateData = $BookingDetailsData->InternalSync(RDataModel::UPDATE,"auto_id","booking_id","description_of_goods","dangerousgoods","total_volume","values_of_goods","currency_codes","export_reason","country_origin","commercial_invoice_provider","authority_to_leave","where_to_leave_shipment","additional_cost","pageid","userid","commercial_invoice");

	    }

	    else if ($statusChange =="booking")//update query for booking page
		{
			 $UpdateData = $BookingDetailsData->InternalSync(RDataModel::UPDATE,"auto_id","booking_id","sender_first_name","sender_surname","sender_company_name","sender_address_1","sender_address_2","sender_address_3","sender_suburb","sender_state","sender_postcode","sender_email","sender_contact_no","sender_mobile_no","reciever_firstname","reciever_surname","reciever_company_name","reciever_address_1","reciever_address_2","reciever_address_3","reciever_suburb","reciever_state","reciever_state_code","reciever_postcode","reciever_email","reciever_contact_no","reciever_mobile_no","date_ready","time_ready","close_time","booking_date","booking_time","pickup_time_zone","delivery_time_zone","pageid","userid","commercial_invoice");

	    }
	    else if($statusChange == "pageload"){// only for userid update, not effect other values
			$UpdateData = $BookingDetailsData->InternalSync(RDataModel::UPDATE,"pageid");
		}else if($statusChange == "tracking"){
			$UpdateData = $BookingDetailsData->InternalSync(RDataModel::UPDATE,"tracking_status");
		}
		 else if($statusChange == "curlxml"){// only for userid update, not effect other values
			$UpdateData = $BookingDetailsData->InternalSync(RDataModel::UPDATE,"CCConnote","shipment_number","BookingNumber","webservice","payment_done","payment_type","tracking_status");
		}
		else if($statusChange == "from_admin"){// only for userid update, not effect other values
			//This below code commented by shailesh jamanapara on Date Fri Jun 14 13:57:55 IST 2013
			//$UpdateData = $BookingDetailsData->InternalSync(RDataModel::UPDATE,"pickupid","deliveryid","distance_in_km","total_qty","total_weight","volumetric_weight","chargeable_weight","description_of_goods","dangerous_goods","values_of_goods","authority_to_leave","where_to_leave_shipment","additional_cost","service_name","sender_first_name","sender_surname","sender_company_name","sender_address_1","sender_address_2","sender_address_3","sender_suburb","sender_state","sender_postcode","sender_email","sender_contact_no","sender_mobile_no","reciever_firstname","reciever_surname","reciever_company_name","reciever_address_1","reciever_address_2","reciever_address_3","reciever_suburb","reciever_state","reciever_postcode","reciever_email","reciever_contact_no","reciever_mobile_no","date_ready","time_ready","booking_date","booking_time","pickup_time_zone","delivery_time_zone","userid","international_rate","flag","pro_froma_invoice","payment_done");
			//This variables $UpdateData  value assigned  by shailesh jamanapara Fri Jun 14 13:58:05 IST 2013
		 $UpdateData = $BookingDetailsData->InternalSync(RDataModel::UPDATE,"userid","pickupid","deliveryid","distance_in_km","total_qty","total_volume","total_weight","volumetric_weight","chargeable_weight","rate","description_of_goods","dangerousgoods","values_of_goods","currency_codes","export_reason","country_origin","commercial_invoice_provider","authority_to_leave","where_to_leave_shipment","additional_cost","service_name","sender_first_name","sender_surname","sender_company_name","sender_address_1","sender_address_2","sender_address_3","sender_suburb","sender_state","sender_postcode","sender_email","sender_contact_no","sender_mobile_no","reciever_firstname","reciever_surname","reciever_company_name","reciever_address_1","reciever_address_2","reciever_address_3","reciever_suburb","reciever_state","reciever_state_code","reciever_postcode","reciever_email","reciever_contact_no","reciever_mobile_no","date_ready","time_ready","close_time","booking_date","booking_time","pickup_time_zone","delivery_time_zone","international_rate","flag","commercial_invoice","payment_done","payment_type","CCConnote","pickup_location_type","delivery_location_type");
		}

		else
		{
			 //$UpdateData = $BookingDetailsData->InternalSync(RDataModel::UPDATE,booking_id,"pickupid","deliveryid","distance_in_km","total_qty","total_weight","volumetric_weight","chargeable_weight","description_of_goods","dangerous_goods","values_of_goods","authority_to_leave","where_to_leave_shipment","additional_cost","service_name","sender_first_name","sender_surname","sender_company_name","sender_address_1","sender_address_2","sender_address_3","sender_suburb","sender_state","sender_postcode","sender_email","sender_contact_no","sender_mobile_no","reciever_firstname","reciever_surname","reciever_company_name","reciever_address_1","reciever_address_2","reciever_address_3","reciever_suburb","reciever_state","reciever_postcode","reciever_email","reciever_contact_no","reciever_mobile_no","date_ready","time_ready","booking_date","booking_time","pickup_time_zone","delivery_time_zone","international_rate","flag","pro_froma_invoice","payment_done");
			 $UpdateData = $BookingDetailsData->InternalSync(RDataModel::UPDATE,"pickupid","deliveryid","distance_in_km","total_qty","total_volume","total_weight","volumetric_weight","chargeable_weight","delivery_fee","fuel_surcharge","service_surcharge","total_delivery_fee","discount","total_dis_delivery_fee","values_of_goods","currency_codes","export_reason","country_origin","commercial_invoice_provider","rate","description_of_goods","dangerousgoods","authority_to_leave","where_to_leave_shipment","additional_cost","service_name","sender_first_name","sender_surname","sender_company_name","sender_address_1","sender_address_2","sender_address_3","sender_suburb","sender_state","sender_postcode","sender_email","sender_contact_no","sender_mobile_no","reciever_firstname","reciever_surname","reciever_company_name","reciever_address_1","reciever_address_2","reciever_address_3","reciever_suburb","reciever_state","reciever_state_code","reciever_postcode","reciever_email","reciever_contact_no","reciever_mobile_no","date_ready","time_ready","close_time","booking_date","booking_time","pickup_time_zone","delivery_time_zone","international_rate","flag","commercial_invoice","payment_done","payment_type","transaction_id","delivery_fee_org","fuel_surcharge_org","total_gst_delivery_org","total_delivery_fee_org","pickup_location_type","delivery_location_type");

	    }

   $Query = "UPDATE booking_details SET $UpdateData WHERE auto_id = "."'$BookingDetailsData->auto_id'";
	//echo $Query; exit();
     //
       //        exit();
       	/**
		  * check that data should be updated perfectly.
		  * if no then throw or return proper error message.
		  */
		$ThrowException = null;
		try {
	  		$Rs = $this->Connection->Execute($Query);
	  		if ( $Rs->AffectedRows() == 0 )	{
				//throw new Exception(' Fail To Edit booking_details Record ');
				return false;
	  		}
		}//try end
		catch(Exception $Exception) {
			if($ThrowError == true) {
				//echo $Query;
				$ThrowException = new Exception(' Fail To Edit booking_details Record ');
			 } else {
				return false;
			 }
    	}// try-catch end

		if ($ThrowException) {
			throw $ThrowException;
		} else {
			return true;
		}

	}//editBookingDetails Function End


	/**
	 * To delete booking_details data
	 *
	 * @param int booking_id $booking_id
	 * @param bool $ThrowError Whether to throw or not to throw error
	 *
	 * @return bool If any error, then Throw Exception otherwise return true on success and false on failure
	 */
	public function deleteBookingDetails($booking_id, $ThrowError=true)
	{
   		if(isset($booking_id) && ($booking_id!=null)) {

   			//build up delete query
   			$Query ="DELETE FROM booking_details WHERE auto_id = " . "'$booking_id'";

 			/**
			  * check that data should be updated perfectly.
			  * if no then throw or return proper error message.
			  */
 			$ThrowException = null;
 			try {
				$this->Connection->Execute($Query);
				return true;

			}
			catch (Exception $Exception){
				if($ThrowError == true) {
			    	$ThrowException = new Exception(' Fail To Delete booking_details Record');
				}
			    else {
					return false;
			    }
			}// try catch end

  		} // if end

	 }//deleteBookingDetails Function End


	 /**
	 * GetBookingDetails method is used for to get all or selected columns records from booking_details with searching, sorting and paging criteria.
	 *
	 * @param array array $fieldArr contains table field name
	 * @param array array $seaArr contains 7 elements are
	 *     "Search_On"    = Field name on which search the data
	 *     "Search_Value" = Value which is compared with field defined in "Search_On"												 *     "Equation"     = Equation like '=','LIKE','BETWEEN' and so on.
	 *     "Type"         = Field Type like 'string' and 'int' only. apply "string" for all except int, double, long double etc.
	 *     "CondType"	  = Condition Type like "AND", "OR"
	 *     "Prefix" 	  = Prefix may be blank '' or "("
	 *     "Postfix" 	  = Postfix may be blank '' or ")"
	 * @param array array $optArr contains 2 elements are
	 *     "Order_By"     = Field Name of table for sorting
	 *     "Order_Type"   = Sorting Type like 'ASC', 'DESC'
	 * @param int integer $start  Starting point to fetch data rows. e.g. $start = 10 then will start fetch rows from 10th row.
	 * @param int integer $total  Total number of rows to display on one page. e.g. $total = 20 then will display 20 records on one page
	 * @param bool $ThrowError Whether to throw error or not
	 * @return array array $ret contains all the record sets by applying searching, sorting, paging criteria.
	 *
	 */
	 public function getBookingDetails($fieldArr=null, $seaArr=null, $optArr=null, $start=null, $total=null,$distinct=null, $ThrowError=true,$havingArray=null,$bookingid=null,$tot=null)
	 {

			/**
			 * Table Columns
			 * If $fieldArr has null value then it will return all records otherwise entered table fields
			 *
			 * @see below example for to create $fieldArr for to get only selected table fields data
			 *
			 *     $fieldArr = array("col1", "col2", "col3");
			 */

			if(is_array($fieldArr) && !empty($fieldArr)) {
				$fields = implode(", ", $fieldArr);
			} else {
				$fields = "*";
			}

			/**
			 * Searching criteria (where condition build up)
			 *
			 * @see below example for how to create $seaArr for multiple condition
			 *
			 * 		'col1 = 1 AND (col2 LIKE "str2" OR col3 LIKE "str3")'
			 *
			 *		$seaArr[]	=	array('Search_On'=>'col1',
			 * 									'Search_Value'=>1,
			 * 									'Type'=>'int',
			 * 									'Equation'=>'=',
			 * 									'CondType'=>'AND',
			 * 									'Prefix'=>'',
			 * 									'Postfix'=>''					);
			 * 		$seaArr[]	=	array('Search_On'=>'col2',
			 * 									'Search_Value'=>'str2',
			 * 									'Type'=>'string',
			 * 									'Equation'=>'LIKE',
			 * 									'CondType'=>'AND',
			 * 									'Prefix'=>'(',
			 * 									'Postfix'=>''					);
			 * 		$seaArr[]	=	array('Search_On'=>'col3',
			 * 								 	'Search_Value'=>'str3',
			 * 									'Type'=>'string',
			 * 									'Equation'=>'LIKE',
			 * 									'CondType'=>'OR',
			 * 									'Prefix'=>'',
			 * 									'Postfix'=>')'					);
			 */

			$whereExtra = "";
			if(is_array($seaArr) && !empty($seaArr)) {

				foreach($seaArr as $key=>$val) {

					$wheExt = '';

					if(strtolower($val['Type']) != 'string') {
						$wheExt = $val['CondType']." ".$val['Prefix']." ".$val['Search_On']." ".$val['Equation']." '".addslashes($val['Search_Value'])."'"." ".$val['Postfix'];
					} else {
						$wheExt = $val['CondType']." ".$val['Prefix']." ".$val['Search_On']." ".$val['Equation']." '".addslashes($val['Search_Value'])."'"." ".$val['Postfix'];
					}

					$whereExtra .= " ".$wheExt;
				}

				if($whereExtra != "") {
					$whereExtra = "WHERE true $whereExtra";
				}
			}

			/**
			 * Sorting
			 *
			 * @see below example how to build up $optArr for sorting
			 *
			 * 		'ORDER BY col1 ASC, col2 DESC'
			 *
			 * 		$optArr[]	=	array("Order_By" => "col1",
			 * 								"Order_Type" => "ASC"	);
			 * 		$optArr[]	=	array("Order_By" => "col2",
			 * 								"Order_Type" => "DESC"	);
			 *
			 */
			$optstring = "";
			if(is_array($optArr) && !empty($optArr)) {
				$optstring .= " ORDER BY ";

				$i = &$optKey;
				foreach ($optArr as $optKey => $optVal) {

					if($i != 0) {
						$optstring .= ", ";
					}
					$optstring .= $optVal['Order_By']." ".$optVal['Order_Type'];
				}
			}

			/**
			 * Paging
			 */
			$limitString = '';
			if(isset($total) && !is_null($total)) {
				if(is_null($start)) {
					$start = 0;
				}
				$limitString .= "LIMIT ".$total." OFFSET ".$start;
			}

			/**
			 * Build up query
			 */
			if($distinct=="getquote")
			{
				$Query="SELECT DISTINCT pickupid FROM booking_details $whereExtra";
			}
			else if ($distinct=="getquotedeliver") {

				$Query="SELECT DISTINCT deliveryid,(flag) FROM booking_details $whereExtra";
			}
			else
			{
				$Query = "SELECT $fields FROM booking_details $whereExtra $havingArray $optstring  $limitString";
			}

			//echo $Query;
			//exit;
			

			/**
			 * Execute Query
			 * If any error during execution of query it will return false
			 */
			try	{
				$Rs = $this->Connection->Execute($Query);
				if($tot=='find'){
					return $Rs->RecordCount();die();
				}
				if ($Rs->RecordCount() == 0 ) { //check whether the record is found or not
					return false;
				}
			}
		    catch (Exception $Exception) {
				if($ThrowError == true) {
					$ThrowException = new Exception(' Fail To Get Any Record of booking_details');
				}
		    } // try -catch end

		    //Create CategoryData Object
	   	    $BookingDetailsData = new RModelCollection();
	   	    if($Rs!="")
	   	    {
	   	    //assing all fetched records into CategoryData Object
	   	    foreach ($Rs as $Record) {
			 	$BookingDetailsData->Add(new BookingDetailsData($Record));
		    }//foreach end
	   	    }
		    return $BookingDetailsData;//return the fetched recordset
	 }//getBookingDetails function end



}//class End
?>
