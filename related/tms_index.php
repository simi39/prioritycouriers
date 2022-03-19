<?php
require_once("../lib/common.php");
require_once(DIR_WS_MODEL ."PostCodeMaster.php");
require_once(DIR_WS_MODEL . "BookingDetailsMaster.php");
/* Objects declaration */
$PostCodeMasterObj	= PostCodeMaster::Create();
$PostCodeData	= new PostCodeData();
$ObjBookingDetailsMaster	= BookingDetailsMaster::Create();
$BookingDetailsData		= new BookingDetailsData();
/* Objects declaration */

define("COMMON_SECURITY_ANSWER_ALPHANUMERIC","Please enter alphanumeric values.");

if(isset($_GET) && $_GET['flag']=='international')
{
	echo json_encode(array(
				'valid' => 'true',
			));
	exit();
} 
if(isset($_GET) && !empty($_GET["letters"])){
	$q = addslashes(valid_input($_GET["letters"]));
	
	if(preg_match("/[^a-zA-Z0-9\s]/", $q))
	{
		echo COMMON_SECURITY_ANSWER_ALPHANUMERIC;
		exit();
	}
	
	if($q != "" && empty($valid)){
		$seaByArr = array();
		$optArr   = array();
		$fieldArr = array();
		//echo $q."---".$_GET["chksuburb"];
		if(isset($_GET) && !empty($_GET["chksuburb"]))
		{
			if(!is_numeric($q)){
				$seaByArr[]=array('Search_On'=>'FullName', 'Search_Value'=>"$q", 'Type'=>'string', 'Equation'=>'LIKE', 'CondType'=>'', 'Prefix'=>'', 'Postfix'=>'');
			}else{		
				/*$seaByArr[]=array('Search_On'=>'Postcode', 'Search_Value'=>"$q", 'Type'=>'string', 'Equation'=>'LIKE', 'CondType'=>'', 'Prefix'=>'', 'Postfix'=>'');*/
				echo json_encode(array(
				'valid' => 'false',
				));
				exit();
			}
		}else{
			if(!is_numeric($q)){
				$seaByArr[]=array('Search_On'=>'FullName', 'Search_Value'=>"$q%", 'Type'=>'string', 'Equation'=>'LIKE', 'CondType'=>'', 'Prefix'=>'', 'Postfix'=>'');
			}else{		
				$seaByArr[]=array('Search_On'=>'Postcode', 'Search_Value'=>"$q%", 'Type'=>'string', 'Equation'=>'LIKE', 'CondType'=>'', 'Prefix'=>'', 'Postfix'=>'');
			}
		}
		$optArr[]=	array('Order_By' => 'FullName','Order_Type' => 'asc');
		$fieldArr = array("FullName","Id","Name","Postcode","Zone","charging_zone");
		//$PostCodeData = $PostCodeMasterObj->getPostCode($fieldArr,false,$seaByArr,$optArr,0,10);
		$PostCodeData = $PostCodeMasterObj->getPostCode($fieldArr,false,$seaByArr,$optArr);
		
		if(!empty($PostCodeData)){
    		foreach($PostCodeData as $postcodeval){ 
    			$return_data .= $postcodeval['FullName'].",";
    		}
			if(isset($_GET) && !empty($_GET["chksuburb"]))
			{
				echo json_encode(array(
					'valid' => 'true',
				));
			}else{
				echo $return_data;
			}
		}else{
			echo json_encode(array(
				'valid' => 'false',
			));
		}
	}
	
}else{
	echo json_encode(array(
		'valid' => 'false',
	));
}
?>
<?php
$fieldArr = array("userid","email");
$userid = $_GET['userid'];
if(!empty($userid))
{
	if(isNumeric(trim($userid),ERROR_CONSIGNEE_POSTCODE_REQUIRE_IN_NUMERIC))
	{
		$error = ERROR_CONSIGNEE_POSTCODE_REQUIRE_IN_NUMERIC;
	}
	if(empty($error))
	{
		$countryOutput = '';					
		$fieldArr1 = array("booking_id");


		if($userid!=''){
			$userid = $userid;
			$BookingSearchDetailArray[] = array('Search_On'=>'userid', 'Search_Value'=>$userid, 'Type'=>'int', 'Equation'=>'=', 'CondType'=>'AND', 'Prefix'=>'', 'Postfix'=>'');				
		}


		$PostCodedatas = $ObjBookingDetailsMaster->getBookingDetails($fieldArr1,$BookingSearchDetailArray);
		/*
		echo "<pre>";
		print_R($PostCodedatas);
		echo "</pre>";
		exit();
		*/
		$countryOutput.="<select name='booking_id'   id='booking_id_of_user'>
		<option value=''>SELECT BOOKING ID</option>";
		if($PostCodedatas!=''){     		
		foreach($PostCodedatas as $country_val)
				{	
					$cond = ($country_val["booking_id"]==$CommercialInvoiceData['booking_id'])?("selected"):('');
					$countryname= generatebookigid("",$country_val["booking_id"]);
					$countryOutput.='<option value="'.$country_val["booking_id"].'"';
					$countryOutput.=$cond;
					$countryOutput.='  >'.$countryname.'</option>';
				} 
		}
		$countryOutput.="</select>";
		 echo $countryOutput;
		
	}else{
		echo $error;
	}
}
?>