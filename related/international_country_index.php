<?php
/**
	 * This is index file
	 *
	 *
	 * @author     Radixweb <team.radixweb@gmail.com>
	 * @copyright  Copyright (c) 2008, Radixweb
	 * @version    1.0
	 * @since      1.0
	 */
	/**
	 * include common
	 */
	require_once("../lib/common.php");
	require_once(DIR_WS_CURRENT_LANGUAGE . "index.php");
	require_once(DIR_WS_MODEL ."InternationalZonesMaster.php");
	
		
	
	/**
	 *
	 * Object Declaration
	 *
	 */
	$InternationalzonesMasterObj = InternationalZonesMaster::Create();
	$InternationalDataobj= new InternationalZonesData();	
	
	if(isset($_GET) && $_GET['selectedid']!="")
	{
		$err['CountryError'] = isNumeric($_GET['selectedid'],COMMON_NUMERIC_VAL);
	}
	if(!empty($err['CountryError']))
	{
		logOut();
	}
	if(isset($_GET) && $_GET['inter_country']!="")
	{
		$err['InterCountryError'] = isNumeric($_GET['inter_country'],COMMON_NUMERIC_VAL);
	}
	if(!empty($err['InterCountryError']))
	{
		logOut();
	}
	//exit();
	/* For the get_quote calculation when international was selected */
	/* Its included from the ajax code */
	$fieldArr = array("id","country","days");
	$Internationaldata = $InternationalzonesMasterObj->getInternationalZones($fieldArr);
	
	
				$countryOutput.="<label class='control-label'><i class='icon-circle-arrow-down'></i>&nbsp;".COMMON_DELIVERY_OF_ITEM."</label><select name='inter_country' id='inter_country' onchange='postinter(this.value)' class='span12 form-control'><option>SELECT COUNTRY</option>";
	
                       foreach($Internationaldata as $country_val)
                       {
                       	$selectCountryId=$_GET['selecetedid'];
                       $countryname=$country_val["country"]."(".$country_val['days'].")";		
                       
                       $countryOutput.='<option value="'.$country_val->id.'"';
						if(isset($selectCountryId) && $selectCountryId!=''){
							if($country_val->id==$selectCountryId){ $countryOutput.='selected'; } 
							if($country_val->id==COUNTRY_SELECT && $selectCountryId==''){ $countryOutput.='selected';}
							} else {
								if(isset($_GET["inter_country"])){
									$countryOutput.='selected';
								}//elseif($country_val->id==COUNTRY_SELECT) {
									//$countryOutput.='selected';
								//} 
							}
						$countryOutput.='>'.$countryname.'</option>';
                       }
                       $countryOutput.="</select>";
                       echo json_encode(array('valid' => $countryOutput,));
					  // exit();
       
?>