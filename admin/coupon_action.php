<?php
	/**
	 * This file is for add new admin
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
	require_once(DIR_WS_MODEL."/CouponMaster.php");
	require_once(DIR_WS_ADMIN_LANGUAGES . DIR_CURRENT_LANGUAGE. '/coupon.php');
		 
	/**
	 * Inclusion and Exclusion Array of Javascript
	 */
	$arr_javascript_include[] = FILE_ADMIN_COUPON_ADDEDIT;
	
	$arr_css_admin_exclude[] = 'jquery.css';
	$arr_css_plugin_include[] ='bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css';
	$arr_css_plugin_include[] = 'glyphicons_new/css/glyphicons.css';
	$arr_css_plugin_include[] ='tabbed-panels/css/tabbed_panels.css';
	$arr_css_admin_include[] = 'custom-style.css';
	$arr_javascript_plugin_include[] = 'moment/js/moment-with-locales.min.js';
	$arr_javascript_plugin_include[] = 'bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js';
	$arr_javascript_plugin_include[] = 'bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js';
	$arr_javascript_plugin_include[] = 'tabbed-panels/js/tabbed_panels.js';
	
	
	
	/**
	 * For creating objects
	 */
	 $ObjCouponData      = new CouponData();
	 $ObjCouponMaster	= new CouponMaster();
	 $ObjCouponMaster	= $ObjCouponMaster->Create();
	
	/*csrf validation*/
	$csrf = new csrf();
	$csrf->action = "coupon_action";
	if(!isset($_POST['ptoken'])) {
		$ptoken = $csrf->csrfkey();
	}
	/*csrf validation*/
	
	/**
	 * Variable Declaration
	 */
	
    $coupon_id      = $_GET['coupon_id'];
	$AdminId = $_GET['AdminId'];
	if(!empty($coupon_id))
	{
	   $err['coupon_id'] = isNumeric(valid_input($coupon_id),ENTER_NUMERIC_VALUES_ONLY);
	}
	if(!empty($err['coupon_id']))
	{
	  logOut();
	}
	if(!empty($coupon_id))
	{
	   $err['coupon_id'] = isNumeric(valid_input($coupon_id),ENTER_NUMERIC_VALUES_ONLY);
	}
	if(!empty($err['coupon_id']))
	{
	  logOut();
	}
    $coupon_name	= $_POST['coupon_name'];
	$coupon_amount	= $_POST['coupon_amount'];
	$coupon_type	= $_POST['coupon_type'];
	$coupon_code 	= $_POST['coupon_code'];
	$coupon_usage	= $_POST['coupon_usage'];
	$coupon_start_date		 = $_POST['coupon_start_date'];
	$coupon_end_date		 = $_POST['coupon_end_date'];
	$buttonName     = ADMIN_ADD_BUTTON;
	$HeadingLabel   = ADMIN_ADD_HEADING;	
        
	
	/**
	 * Get the data from coupon id
	 */
	if(isset($_GET['coupon_id']) && $_GET['coupon_id'] != '')
	{
		$btnSubmit       = ADMIN_COUPON_EDIT;
		$couponArr = array();
		$couponArr[] = array('Search_On'=>'coupon_id', 'Search_Value'=>$_GET['coupon_id'], 'Type'=>'int', 'Equation'=>'=','CondType'=>'AND', 'Prefix'=>'', 'Postfix'=>'');
		$ObjAddressData = $ObjCouponMaster->getCoupon(null, $couponArr);
		$ObjAddressData = $ObjAddressData[0];
		$coupon_status	 = $ObjAddressData->coupon_status;
		$buttonName   = ADMIN_EDIT_BUTTON;
		$HeadingLabel = ADMIN_EDIT_HEADING;
	}
			
	/**
	 * Add/Edit coupon data
	 */	
	if(!empty($_POST['Submit'])) {  
		
		if(isEmpty(valid_input($_POST['ptoken']), true)){	
			logOut();
		}else{
			//$csrf->checkcsrf($_POST['ptoken']);
		}
		$err['coupon_name']			= isEmpty($coupon_name, ADMIM_COUPON_NAME_REQUIRE)?isEmpty($coupon_name, ADMIM_COUPON_NAME_REQUIRE):chkRestFields($coupon_name);
		$err['coupon_amount']		= isEmpty($coupon_amount, ADMIM_COUPON_AMOUNT_REQUIRE)?isEmpty($coupon_amount, ADMIM_COUPON_AMOUNT_REQUIRE):isFloat($coupon_amount, ENTER_FLOAT_VALUE);
		if($_POST['coupon_code'] != '')
		{
			$err['coupon_code'] = checkStr($_POST['coupon_code']);
		}
		$err['coupon_start_date']	= isEmpty($coupon_start_date, ADMIM_COUPON_START_DATE_REQUIRE)?isEmpty($coupon_start_date, ADMIM_COUPON_START_DATE_REQUIRE):checkStr($coupon_start_date);
		$err['coupon_end_date']	 	= isEmpty($coupon_end_date, ADMIM_COUPON_END_DATE_REQUIRE)?isEmpty($coupon_end_date, ADMIM_COUPON_END_DATE_REQUIRE):checkStr($coupon_end_date);
		if($_POST['coupon_usage']!="")
		{
			if(chkTrk($_POST['coupon_usage']))
			{
				logOut();
			}
		}
		
		foreach($err as $key => $Value) {
			if($Value != '') {
				$Svalidation=true;
				$ptoken = $csrf->csrfkey();
			}
		}
		
		/*if($_POST['coupon_code']!='' && empty($_GET['coupon_id']) && $_GET['coupon_id'] == '')	
		{
		
			$couponArr = array();
			$couponArr[] = array('Search_On'=>'coupon_code', 'Search_Value'=>$_POST['coupon_code'], 'Type'=>'string', 'Equation'=>'!=','CondType'=>'AND', 'Prefix'=>'', 'Postfix'=>'');
			$Objcoup = $ObjCouponMaster->getCoupon(null, $couponArr);
			if($Objcoup!=''){
			$err['coupon_code']		= ADMIM_COUPON_CODE_EXISTS;
				$Svalidation=true;
			}
		}
		*/
		if($_POST['coupon_code'] !='')	
		{
			$couponArr = array();
			
			if(isset($_POST['coupon_id']) && $_POST['coupon_id'] != '') {
				$couponArr[] = array('Search_On'=>'coupon_id', 'Search_Value'=>$_POST['coupon_id'], 'Type'=>'string', 'Equation'=>'!=','CondType'=>'AND', 'Prefix'=>'', 'Postfix'=>'');				
			}
			
			$couponArr[] = array('Search_On'=>'coupon_code', 'Search_Value'=>$_POST['coupon_code'], 'Type'=>'string', 'Equation'=>'=','CondType'=>'AND', 'Prefix'=>'', 'Postfix'=>'');
			
			$Objcoup = $ObjCouponMaster->getCoupon(null, $couponArr);
			if($Objcoup!=''){
			$err['coupon_code']		= ADMIM_COUPON_CODE_EXISTS;
				$Svalidation=true;
			}
		}
			
		
		if ($Svalidation==false) 
		{	
			
			if($coupon_code=='')
			{
				do 
				{
					$coupon_code = generateRandomNo(8);
					$Option['coupon_code']=$coupon_code;
					$couponArr = array();
					$couponArr[] = array('Search_On'=>'coupon_code', 'Search_Value'=>$coupon_code, 'Type'=>'string', 'Equation'=>'=','CondType'=>'AND', 'Prefix'=>'', 'Postfix'=>'');
					$Objcoup = $ObjCouponMaster->getCoupon(null, $couponArr);
									
				}while ($Objcoup!='');
			
			}
		
			// Coupon Data
			$ObjCouponData->coupon_name=$coupon_name;
			$ObjCouponData->coupon_amount=$coupon_amount;
			$ObjCouponData->coupon_type=$coupon_type;
			$ObjCouponData->coupon_code=$coupon_code;
			$ObjCouponData->coupon_start_date=date('Y-m-d',strtotime($coupon_start_date));
			$ObjCouponData->coupon_end_date=date('Y-m-d',strtotime($coupon_end_date));
			$ObjCouponData->coupon_usage=$coupon_usage;		
		
			if(isset($_POST['coupon_id']) && $_POST['coupon_id'] != '')
			{
				$ObjCouponData->coupon_status=$coupon_status;		
				$ObjCouponData->coupon_id=$_POST['coupon_id'];
				$ObjCouponMaster->editCoupon($ObjCouponData);
				header("location:".FILE_ADMIN_COUPON."?message=".MSG_EDIT_SUCCESS);
				exit;
			}
			else
			{
				$coupon_status			 = '0';
				$ObjCouponData->coupon_status=$coupon_status;			
				$ObjCouponMaster->Addcoupon($ObjCouponData);
				header("location:".FILE_ADMIN_COUPON."?message=".MSG_ADD_SUCCESS);
				exit;
			}
		  		
		}
	
	}		
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php
if(isset($_GET['AdminId']) && !empty($_GET['AdminId'])) {
	echo ADMIN_TITLE_COUPON_EDIT;
} else {
	echo ADMIN_TITLE_COUPON_ADD;
}
?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<?php
addCSSFileAdmin($arr_css_admin_include, $arr_css_admin_exclude);
addPluginCSSFile($arr_css_plugin_include,$arr_css_plugin_exclude);
addJavaScriptFile($arr_javascript_include, $arr_javascript_exclude);
addPluginJavaScriptFile($arr_javascript_plugin_include,$arr_javascript_plugin_exclude);
?>
</head>
<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
	<tr>
		<td valign="top">
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
						<table class="middle_right_content" align="center" border="0" cellpadding="0" cellspacing="0">
							<tr>
								<td align="left" class="breadcrumb">
										<span><a href="<?php echo FILE_WELCOME_ADMIN; ?>"><?php echo ADMIN_HEADER_HOME; ?></a> > <a href="<?php echo FILE_ADMIN_COUPON; ?>"><?php echo ADMIN_COUPON_HEADING; ?></a> > <?php echo $HeadingLabel; ?></span>
										<div><label class="top_navigation"><a href="<?php echo FILE_ADMIN_COUPON; ?>"><?php echo ADMIN_COMMON_BACK; ?></a></label></div>
								</td>
							</tr>
							<tr>
								<td class="heading">
									<?php echo $HeadingLabel; ?>
								</td>
							</tr>
							<tr>
								<td class="message_mendatory" align="right">
									<?php echo ADMIN_COMMAN_REQUIRED_INFO; ?>
								</td>
							</tr>
							<tr>
								<td align="left">
								<table width="99%" border="0" cellpadding="0" cellspacing="0">
									<form name="coupon" method="post" action="">
									
						                <tr>
						                  <td colspan="3">&nbsp;</td>
						                </tr>
						                <TR >
						                  <Td class="input-text" align="left" width="20%" nowrap ><?php echo COUPON_NAME;?> :</Td>
						                  <TD width="30%" align="left" valign="top"><Input type="text" name="coupon_name" id="coupon_name"  maxlength="50" align="right" class="register"  value="<?php if($_POST['coupon_name'] != ''){ echo valid_output($_POST['coupon_name']);} elseif ($ObjAddressData!='') { echo valid_output($ObjAddressData->coupon_name); }?>" >
										  <input type="hidden" name="coupon_id" id="coupon_id" value="<?php if($_POST['coupon_id'] != ''){ echo $_POST['coupon_id'];} elseif ($ObjAddressData!='') { echo $ObjAddressData->coupon_id; }?>"  />
						                  <span class="message_mendatory"> * </span></td>
						                  <TD align="left" width="58%"><?PHP echo  ADMIN_COUPON_MANAGEMENT_HELPTEXT1;?> :</td>
						                </TR>
						                <tr>
						                  <td></td>
						                  <td class="message_mendatory" id="CNameError" height="12"><?php if(isset($err['coupon_name'])) {echo $err['coupon_name'];}  ?></td>
						                  <td  id="">&nbsp;</td>
						                </tr>
						                <TR>
						                  <TD class="input-text" align="left"  ><?php echo COUPON_AMOUNT; ?> :</TD>
						                  <TD><Input type="text" name="coupon_amount" id="coupon_amount"  maxlength="50"  class="register" value="<?php if($_POST['coupon_amount'] != ''){ echo $_POST['coupon_amount'];} elseif ($ObjAddressData!='') { echo valid_output($ObjAddressData->coupon_amount); }?>">
						                  <span class="message_mendatory"> * </span>
						                  <input type="radio" name="coupon_type" id="coupon_type" checked="checked" value="1">  Amount ($).
						                  <input type="radio" name="coupon_type" id="coupon_type" value="2"<?php if($ObjAddressData->coupon_type == 2){ echo 'checked="checked"';} ?> >  Percentage (%).
						                  </td>
						                  <TD><?PHP echo  ADMIN_COUPON_MANAGEMENT_HELPTEXT2;?></td>
						                </TR>
						               
						                <tr>
						                  <td></td>
						                  <td class="message_mendatory" id="CAmountError"  height="12"><?php if(isset($err['coupon_amount'])) { echo $err['coupon_amount']; } ?></td>
						                  <td class="message_mendatory" id="">&nbsp;</td>
						                </tr>
						                <tr>
						                  <td class="input-text" align="left" ><?php echo COUPON_CODE;?> :</td>
						                  <td class="message_mendatory" id=""  height="12"><input type="text" name="coupon_code"  id="coupon_code" maxlength="50"  class="register"value="<?php if($_POST['coupon_code'] != ''){ echo valid_output($_POST['coupon_code']);} elseif ($ObjAddressData!='') { echo valid_output($ObjAddressData->coupon_code); }?>" /></td>
						                  <td ><?PHP echo  ADMIN_COUPON_MANAGEMENT_HELPTEXT3;?></Td>
						                </tr>
						                <tr>
						                  <td></td>
						                  <td class="message_mendatory" id="CCodeError"  height="12"><?php if(isset($err['coupon_code'])) { echo $err['coupon_code']; } ?></td>
						                  <td class="message_mendatory" id="">&nbsp;</td>
						                </tr>
						                <tr>
						                  <td class="input-text" align="left" ><?php echo COUPON_START_DATE;?> :</td>
						                  <td class="message_mendatory" id=""  height="12">
                                           <label>
                                          <div class="form-group">
                							<div class='input-group date'  id='datetimepicker6' data-link-field="dtp_input1"  >
                							
                							<input type='hidden' class="form-control" id="dtp_input1" />
						                  <label class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></label>
						                  </label>
                                          <input type="text" name="coupon_start_date" id="coupon_start_date"  maxlength="50"  class="register"value="<?php if($_POST['coupon_start_date'] != ''){ echo $_POST['coupon_start_date'];} elseif ($ObjAddressData!='') { echo $ObjAddressData->coupon_start_date; }?>"  readonly="" /><span class="message_mendatory"> * </span>
						                 </div>
                                         </div>
						                   </td>
						                  <td ><?PHP echo  ADMIN_COUPON_MANAGEMENT_HELPTEXT4;?></td>
						                </tr>
						                <tr>
						                  <td></td>
						                  <td class="message_mendatory" id="CSDateError"  height="12"><?php if(isset($err['coupon_start_date'])) { echo $err['coupon_start_date']; } ?></td>
						                  <td class="message_mendatory" id="">&nbsp;</td>
						                </tr>
						                <tr>
						                  <td class="input-text" align="left" ><?php echo COUPON_END_DATE;?> :</td>
						                  <td class="message_mendatory" id=""  height="12">
                                          <label>
                                          <div class="form-group">
                							<div class='input-group date'  id='datetimepicker7' data-link-field="dtp_input2"  >
                							
                							<input type='hidden' class="form-control" id="dtp_input2" />
                                             <label class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></label>
                                            <?php 
											
											?>
                                          <input type="text" name="coupon_end_date" id="coupon_end_date"  maxlength="50"  class="register" value="<?php if($_POST['coupon_end_date'] != ''){ echo date('Y-m-d',$_POST['coupon_end_date']);} elseif ($ObjAddressData!='') { echo $ObjAddressData->coupon_end_date; }?>"   readonly=""/><span class="message_mendatory"> * </span>
						                  
						                   </td>
						                  <td ><?PHP echo  ADMIN_COUPON_MANAGEMENT_HELPTEXT5;?></td>
						                </tr>
						                <tr>
						                  <td></td>
						                  <td class="message_mendatory" id="CEDateError"  height="12"><?php if(isset($err['coupon_end_date'])) { echo $err['coupon_end_date']; } ?></td>
						                  <td class="message_mendatory" id="">&nbsp;</td>
						                </tr>
						                
						                               
						                <tr>
						                	<td class="input-text" align="left" ><?php echo COUPON_USAGE;?> :</td>
						                  	<td id=""  height="12">
						                  		<input type="radio" name="coupon_usage" id="coupon_usage" value="One" <?php if ($ObjAddressData->coupon_usage == "One" || empty($_GET['couponid'])) {?> checked <?php }?> >One Time<br>
						                  		<input type="radio" name="coupon_usage" id="coupon_usage" value="EUser" <?php if ($ObjAddressData->coupon_usage == "EUser") {?> checked <?php }?>>One Time For Each Customer<br>
						                  		<input type="radio" name="coupon_usage" id="coupon_usage" value="More" <?php if ($ObjAddressData->coupon_usage == "More") {?> checked <?php }?>>More Than One Time
						                  	</td>
						                  	<td align="left" valign="top"><?PHP echo  ADMIN_COUPON_MANAGEMENT_HELPTEXT6;?></td> 
										</tr>
						                <tr>
						                  <td>&nbsp;</td>
						                  <td>&nbsp;</td>
						                  <td>&nbsp;</td>
											</tr>
						                  <td><input type="hidden" id="dateArr" value="<?php echo $date_arr; ?>" />&nbsp;</td>
						                  <td colspan="2">
											<input type="hidden" size="34" id="ptoken" value="<?php echo $ptoken; ?>" name="ptoken">
						                   <input type="submit" class="action_button" name="Submit" id="Submit" value="<?php echo $buttonName; ?>" />
										   <input type="reset"  class="action_button" name="btnreset" value="<?php echo ADMIN_COMMON_BUTTON_RESET;?>"/>
										  <input type="button"  class="action_button" name="cancel" value="<?php echo ADMIN_COMMON_BUTTON_CANCEL;?>" onclick="javascript:document.location.href='<?php echo FILE_ADMIN_COUPON; ?>';return true;"/>
						                    &nbsp;</td>
						                </tr>
						              </form>
						         </table>
								
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
		<td id="footer">
			<?php require_once(DIR_WS_ADMIN_INCLUDES . ADMIN_FILE_FOOTER);?>
		</td>
	</tr>
</table>
</body>
</html>
<script language="javascript" type="text/javascript">
function compareDate(){
	var DateToValue = $("#coupon_start_date").val();
      var DateFromValue = $("#coupon_end_date").val();

      if (Date.parse(DateToValue) <= Date.parse(DateFromValue)) {
       alert("End date must next of start date");
       $("#coupon_end_date").focus();
      }
	
}
</script>
<script type="text/javascript">
var dat = $("#dateArr").val();
var dateTest = dat.split(",");
var dateArr = [];
for(var i=0;i<dateTest.length;i++)
{
	dateArr[i] = dateTest[i];
}
var defaultDateset;

var minDate;
if(trim(defaultDateset) == "")
{	
	defaultDateset = moment().format();
}
if(trim(minDate) == "")
{
	minDate = moment().format();
}
if($("#coupon_start_date").val()!="")
{
	var start_date = $("#coupon_start_date").val();
}else{
	var start_date = moment().format();
}
if($("#coupon_end_date").val()!="")
{
	var end_date = $("#coupon_end_date").val();
}else{
	var end_date = moment().format();
}

$('#datetimepicker7').datetimepicker({
	date: end_date,
	minDate: minDate,
	format: 'YYYY-MM-DD',
	daysOfWeekDisabled: [0,6],
	sideBySide: true,
	widgetPositioning: {
		horizontal: 'left'
	},
	showClose: true,
	locale: 'en',
	ignoreReadonly:true,
	disabledDates:dateArr
});


$("#datetimepicker7").on("dp.change",function (e) { 
	$('#start_date').val($('#dtp_input2').val());
});

//var first = moment().format('DD MMMM YYYY');

$('#datetimepicker6').datetimepicker({
	date: start_date,
	minDate: minDate,
	format: 'YYYY-MM-DD',
	daysOfWeekDisabled: [0,6],
	sideBySide: true,
	widgetPositioning: {
		horizontal: 'left'
	},
	showClose: true,
	ignoreReadonly:true,
	locale: 'en',
	disabledDates:dateArr
});

$("#datetimepicker6").on("dp.change",function (e) { 
	$('#start_date').val($('#dtp_input1').val());
});
</script>