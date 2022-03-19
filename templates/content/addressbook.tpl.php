<?php
if($_GET['action']=="delete" && !empty($_GET['deleteid'])) {
			echo "<script src='".SITE_URL."/assets/js/jquery.min.js'></script><script type='text/javascript' src='".SITE_URL."assets/plugins/bootstrap/js/bootstrap.min.js'></script><script type='text/javascript'>
				$(document).ready(function(){
					$('#successBox').modal('show');

				});
			</script>";
}
if($_GET['type'] != '')
{
	$err['type'] = chkStr($_GET['type']);
}
if(!empty($err['type']))
{
	logOut();
}

if($AddressCnt){
?>

<?php
}
?>
<?php

if($error)
{

	echo "<script src='".SITE_URL."/assets/js/jquery.min.js'></script><script type='text/javascript' src='".SITE_URL."assets/plugins/bootstrap/js/bootstrap.min.js'></script><script type='text/javascript'>
		$(document).ready(function(){
			$('#errorBox').modal('show');

		});

		</script>";
}
?>

<!--=== Breadcrumbs ===-->
<div class="breadcrumbs margin-bottom-60">
	<div class="container">
        <h1 class="pull-left"><?php echo COMMON_ADDRESS_BOOK; ?></h1>
        <ul class="pull-right breadcrumb">
            <li><a href="<?php echo SITE_INDEX;?>"><?php echo COMMON_HOME; ?></a> <span class="divider">/</span></li>
            <li class="active"><?php echo COMMON_ADDRESS_BOOK; ?></li>
        </ul>
    </div><!--/container-->
</div><!--/breadcrumbs-->
<!--=== End Breadcrumbs ===-->
<!--=== Content Part ===-->
<div class="container">
		<div class="row">
		<?php

		if($error)
		{
			$err['error'] = specialcharaChk($error);
		}
		if($err['error'])
		{
			logOut();
		}


		?>
	</div>
	<div class="row-fluid">
		<?php/* if (isset($_SERVER['HTTP_REFERER']) && ($_SERVER['HTTP_REFERER']==SITE_URL.'addresses.php')) {*/?>
		<?php if(isset($_GET["type"])) { ?>
		<div class="headline text_centre">
			<h4 class="my_green">
				<em>Please click a <span class="bold">surname</span> to import the address to your booking form</em>
			</h4>
		</div>
		<?php } else {}?>
	</div>
		<form name="addressbook" id="addressbook" method="post">
			<div id="more_light" class="span12 margin-bottom-40 margin-left_0">
			<input type="hidden" size="34" id="ptoken" value="<?php echo $ptoken; ?>" name="ptoken">

			<table class="table table-striped table-hover dt-responsive" cellspacing="0" width="100%" id="example">
				<thead>
					<tr>
					<th class="controlpanel_middle_th"></th>
					<th class="controlpanel_middle_th"><?php echo ADDRESS_SURNAME;?></th>
				    <th class="controlpanel_middle_th"><?php echo ADDRESS_FIRST_NAME;?></th>
                    <th class="controlpanel_middle_th"><?php echo ADDRESS_COMPANY;?></th>
                    <th class="controlpanel_middle_th"><?php echo ADDRESS_STREET;?></th>
                    <th class="controlpanel_middle_th"><?php echo ADDRESS_SUBURB;?></th>
                    <th class="controlpanel_middle_th"><?php echo ADDRESS_STATE;?></th>
                    <th class="controlpanel_middle_th"><?php echo ADDRESS_POSTCODE;?></th>
                    <!--<th class="controlpanel_middle_th none"><?php echo ADDRESS_CONTACT_NUMBER;?></th>
                    <th class="controlpanel_middle_th none"><?php echo ADDRESS_MOBILE_NUMBER;?></th>
					<th class="controlpanel_middle_th none"><?php echo ADDRESS_EMAIL_ID;?></th>-->
				    <th class="controlpanel_middle_th"><?php echo ADDRESS_COUNTRY;?></th>
						<?php if(isset($_GET["type"])) {	?>

						<?php } else {?>
							<th class="controlpanel_middle_th all"><?php echo ADDRESS_ACTION;?></th>
						<?php
							}
						?>
				</tr>
				</thead>
				<tbody>
					<?php

						if($clientAddressData)
						{
							$i=1;$no=1;
							foreach ($clientAddressData as $clientAddress)
							{
								$booking_item_id = $clientAddress['addressId'];

					?>
							<tr class="<?php if($i%2==0){echo "graybanner";}else {echo "lightgraybanner";} ?>">
							<td></td>
							<td class="controlpanel_middle_td">
							<?php if(isset($_GET["type"])) {	?>
								<a href="#" onclick="javascript:return addError('<?php echo filter_var($clientAddress->addressId,FILTER_VALIDATE_INT); ?>','<?php echo trim($clientAddress->country); ?>','<?php echo valid_output($_GET["type"]); ?>');">
								<?php echo ucwords(chunk_split(valid_output($clientAddress->surname), 14, '<br/>')); ?>
								</a>
								<?php } else {?>
										<?php echo ucwords(chunk_split(valid_output($clientAddress->surname), 14, '<br/>'));  ?>
								<?php }?>

								</td>

							<td class="controlpanel_middle_td"><?php echo ucwords(valid_output($clientAddress->firstname)) ; ?></td>
                            <td class="controlpanel_middle_td"><?php echo ucwords(ucwords(valid_output($clientAddress->company))); ?></td>
                            <td class="controlpanel_middle_td"><?php echo ucwords(ucwords(valid_output($clientAddress->address1))); ?></td>
                            <td class="controlpanel_middle_td"><?php echo ucwords(ucwords(valid_output($clientAddress->suburb))); ?></td>
                            <td class="controlpanel_middle_td"><?php echo valid_output($clientAddress->state);?></td>
							<?php

							 if($clientAddress->country == 'Australia')
							 {
								 $postcode = filter_var($clientAddress->postcode, FILTER_VALIDATE_INT);
							 }else{
								 $postcode = $clientAddress->postcode;
								 $err_int_postcode = filter_var($postcode, FILTER_CALLBACK, array('options' => function($postcode) {
									return chkStreet($postcode);
								}));
								if(is_string($err_int_postcode))
								{
									$err['postcode'] = $err_int_postcode;
								}else{
									$postcode = $clientAddress->postcode;
								}
							 }
							?>
                            <td class="controlpanel_middle_td"><?php echo ucwords($postcode); ?></td>
                            <!--<td class="controlpanel_middle_td"><?php echo valid_output(trim($clientAddress['area_code']."".$clientAddress['phoneno'])); ?></td>
                            <td class="controlpanel_middle_td"><?php if(isset($clientAddress['mobileno'])&& $clientAddress['mobileno']!=""){echo valid_output(trim($clientAddress['m_area_code']."".$clientAddress['mobileno']));} ?></td>
							<td class="controlpanel_middle_td" nowrap><?php echo (valid_output($clientAddress->email)) ; ?></td>-->
							<td class="controlpanel_middle_td"><?php echo ucwords(valid_output(trim($clientAddress['country']))); ?></td>
							<?php if(isset($_GET["type"])) { ?>

							<?php } else {?>
								<td align="center" class="last_column action">
									<!--<?php if(isset($_GET["type"])) {	?>
										<a href="#" onclick="javascript:return addError('<?php echo filter_var($clientAddress->addressId,FILTER_VALIDATE_INT); ?>','<?php echo trim($clientAddress->country); ?>','<?php echo valid_output($_GET["type"]); ?>');">
										<?php echo ADD_TO_ADDRESSES; ?>
									</a> | &nbsp;
									<?php }?>-->
									<a href="<?php echo FILE_ADDRESS_BOOK;?>?CatId=<?php echo filter_var($clientAddress['serial_address_id'],FILTER_VALIDATE_INT);?>"><i class="icon-edit"></i>&nbsp;<?php echo ADDRESS_EDIT; ?></a> | <i class="icon-trash"></i>&nbsp;<a href="<?php echo FILE_ADDRESS_BOOK_LISTING; ?>?action=delete&amp;deleteid=<?php echo filter_var($clientAddress['serial_address_id'],FILTER_VALIDATE_INT);?>" onclick="return confirm('<?php echo ADDRESSES_DELETE_CONFIRM; ?>')"><?php echo ADDRESS_DELETE; ?></a></td>
							<?php
								}
							?>
						</tr>
					<?php
						$i++;
						$no++;
							}
						}
					?>
				</tbody>
			</table>
			</div>
		</form>
		<div class="span12 margin-left_0">
			<?php if(isset($_GET["type"])) {	?>
				<input type="button" onclick="document.location='addresses.php'" class="btn-u btn-u-large pull-left" name="BackButton" value="Back">
			<?php } else {}?>
			<?php if(isset($_GET["type"])) {?>

			<?php } else {?>
			<input type="button" onclick="document.location='addressbook-details.php'"class="btn-u btn-u-large pull-right" name="Add New Address" id="Add_New_Address" value="Add new Address">
			<?php  } ?>
		</div>
	</div>
</div>
<!--DIV confirmBox starts here-->
<div class="modal hide fade small_rates" id="confirmBox">
	<div class="modal-header">
		<h3>Delete Address</h3>
	</div>
	<div class="modal-body">
    	<div id="message"></div>
        <div id="message2"></div>
        <div class="btn btn-primary pull-left" id="no">No</div>
        <div class="btn btn-primary pull-right" id="yes">Yes</div>
    </div>
    <div class="modal-footer"></div>
</div>
<!--DIV error msg box starts here-->
<div class="modal hide fade small_rates" id="errorBox">
	<div class="modal-header">
		<h3><?php echo ADDRESSBOOK_WRONG_SUB_HEAD;?></h3>
	</div>
	<div class="modal-body my_bigger_font" id="msgContent">
    	<?php echo valid_output($error); ?>
    </div>
    <div class="modal-footer"><a href="#" class="btn-u btn-u-primary" data-dismiss="modal" id="closemodal">Close</a></div>
</div>

<!--DIV error msg box starts here-->
<div class="modal hide fade small_rates" id="successBox">
	<div class="modal-header">
		<h3><?php echo ADDRESSBOOK_SUCCESS_SUB_HEAD;?></h3>
	</div>
	<div class="modal-body my_bigger_font" id="msgContent">
    	<?php echo ADDRESSES_DELETE_SUCCESSFULLY; ?>
    </div>
    <div class="modal-footer"><a href="#" class="btn-u btn-u-primary" data-dismiss="modal" id="closemodal">Close</a></div>
</div>
