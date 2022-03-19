<?php
require_once("../lib/common.php");
require_once(DIR_WS_MODEL ."ClientAddressMaster.php");
require_once(DIR_WS_MODEL ."CountryMaster.php");

$clientAddressMasterObj = ClientAddressMaster::create();
$clientAddressDataObj = new ClientAddressData();
$userid = $_POST['userid'];
if(isset($userid) && $userid!='')
{
	$err['userid'] = isNumeric(valid_input($userid),ERROR_ENTER_NUMERIC_VALUE);
}
if(!empty($err['userid']))
{
	logOut();
}
$firstname = $_POST['firstname'];
if(isset($firstname) && $firstname!='')
{
	$err['firstname'] = checkName(valid_input($firstname));
}
if(!empty($err['firstname']))
{
	logOut();
}
$lastname = $_POST['lastname'];
if(isset($lastname) && $lastname!='')
{
	$err['lastname'] = checkName(valid_input($lastname));
}
if(!empty($err['lastname']))
{
	logOut();
}

$seaArr = array();
$seaArr[]	=	array('Search_On'    => 'userid',
			                      'Search_Value' => $userid,
			                      'Type'         => 'int',
			                      'Equation'     => '=',
			                      'CondType'     => 'AND',
			                      'Prefix'       => '',
			                      'Postfix'      => '');
$seaArr[]	=	array('Search_On'    => 'firstname',
					  'Search_Value' => $firstname,
					  'Type'         => 'string',
					  'Equation'     => '=',
					  'CondType'     => 'AND',
					  'Prefix'       => '',
					  'Postfix'      => '');
$seaArr[]	=	array('Search_On'    => 'surname',
					  'Search_Value' => $lastname,
					  'Type'         => 'string',
					  'Equation'     => '=',
					  'CondType'     => 'AND',
					  'Prefix'       => '',
					  'Postfix'      => '');
$clientAddressData = $clientAddressMasterObj->GetClientAddress('null',$seaArr);
//require_once( DIR_WS_SITE_CURRENT_TEMPLATE . FILE_MAIN_INTERFACE); /* This include once is used for the html integration */
?>
<script>
$(document).ready(function() {
$('#similar_address').DataTable()
.columns.adjust()
.responsive.recalc();
} );
</script>
<table width="100%" class="display" cellspacing="0" id="similar_address" >
	<thead>
        <th class="controlpanel_middle_th"><?php echo ADDRESS_SURNAME;?></th>
				    <th class="controlpanel_middle_th">1</th>
                    <th class="controlpanel_middle_th none">2</th>
                    <th class="controlpanel_middle_th">3</th>
                    <th class="controlpanel_middle_th">4</th>
                    <th class="controlpanel_middle_th">5</th>
                    <th class="controlpanel_middle_th">6</th>
                    <th class="controlpanel_middle_th">7</th>
                    <th class="controlpanel_middle_th none">8</th>
					<th class="controlpanel_middle_th">9</th>
				    <th class="controlpanel_middle_th">10</th>
    </thead>
    <tbody>
 	<?php    if($clientAddressData=="")
	{?>
		<!--<tr>
        	<td class="controlpanel_middle_td" height="5px;" colspan="8" align="center"><?php echo "No Records Found......"; ?></td></tr>-->
	
	<?php } 
	else 
	{?>
	<input type="hidden" name="bookingid" id="bookingid">
	<?php $i=1;$no=1;
	foreach ($clientAddressData as $clientAddress)
	{
		$booking_item_id = $clientAddress['serial_address_id'];?>
		
		<tr class="<?php if($i%2==0){echo "graybanner";}else {echo "lightgraybanner";} ?>">
			
				
			<!--<td class="controlpanel_middle_td"><?php echo  $clientAddress['addressId']; ?></td>-->
				
			<input type="hidden" name="addressId" id="addressId_<?php echo $i; ?>" value="<?php echo  $clientAddress['serial_address_id']; ?>" />
			<td class="controlpanel_middle_td"><span class="surnames_orange">
			<!--<?php //echo FILE_ADDRESS_BOOK."?action=edit&CatId=".$clientAddress->addressId."&country=".$clientAddress->country;?>-->
				<a href="#" id="surnameClick_<?php echo  $clientAddress['serial_address_id']; ?>" onclick="javascript:return surnameClick('<?php echo  $clientAddress['serial_address_id'];?>')"><?php echo strtoupper(chunk_split(valid_output($clientAddress->surname), 14, '<br/>')); ?></a>
		
			</span></td>
		
			<td class="controlpanel_middle_td"><a href=""><?php 
							echo ucwords(valid_output(strtolower($clientAddress->firstname))) ; ?></a></td>
			<td class="controlpanel_middle_td"><?php 
							echo ucwords(strtolower(valid_output($clientAddress->company))); ?></td>
                            <td class="controlpanel_middle_td"><?php 
							echo ucwords(strtolower(valid_output($clientAddress->address1))); ?></td>
                            <td class="controlpanel_middle_td"><?php 
							echo ucwords(strtolower(valid_output($clientAddress->suburb))); ?></td>
                            <td class="controlpanel_middle_td"><?php 
							echo $clientAddress->state;?></td>
                            <td class="controlpanel_middle_td"><?php 
							echo ucwords(filter_var($clientAddress->postcode, FILTER_VALIDATE_INT)); ?></td>
                            <td class="controlpanel_middle_td"><?php echo valid_output(trim($clientAddress['area_code']."".$clientAddress['phoneno'])); ?></td>
                            <td class="controlpanel_middle_td"><?php echo valid_output(trim($clientAddress['m_area_code']."".$clientAddress['mobileno'])); ?></td>
							<td class="controlpanel_middle_td" nowrap><?php 
							echo (valid_output($clientAddress->email)) ; ?></td>
							<td class="controlpanel_middle_td"><?php echo ucwords(strtolower(valid_output(trim($clientAddress['country'])))); ?></td>
			
		</tr>
		
	<?php 
	$i++;
	$no++;
	}
}
?>
	</tbody>
</table>
<script>
function surnameClick(arg)
{
	$("#CatId").val(arg);
	$("#addressbook_detail").submit();
	return false;
	return true;
}
/*
var modTable = $('#similar_address').DataTable();
 alert(modTable);
$('#similar_address').css( 'display', 'table' );
 
modTable.responsive.recalc();

$(document).ready(function() {
    $('#similar_address').DataTable()
	.columns.adjust()
    .responsive.recalc();
} );

$(document).ready(function() {
    $('#similar_address').DataTable( {
        responsive: true
    } );

   
   $( $.fn.dataTable.tables(true) ).DataTable().responsive.recalc();
    
    
} );*/
</script>