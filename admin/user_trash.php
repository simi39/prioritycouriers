<?php
	/**
	* This file is for display user list
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
	require_once(DIR_WS_MODEL . "UserMaster.php");
	require_once(DIR_WS_MODEL . "AddressMaster.php");
	require_once(DIR_WS_MODEL . "CountryMaster.php");
	require_once(DIR_WS_ADMIN_LANGUAGES . DIR_CURRENT_LANGUAGE. '/user.php');

	/**
	 * Start :: Object declaration
	 */
    $CountryMasterObject   = new CountryMaster();
    $CountryMasterObject   = $CountryMasterObject->Create();
	$ObjUserMaster		= new UserMaster();
	$ObjUserMaster		= $ObjUserMaster->Create();
	$UserData			= new UserData();
	$ObjAddressMaster   = new AddressMaster();
	$ObjAddressMaster   = $ObjAddressMaster->Create();
	$ObjAddress	        = new AddressData();

	
	/**
	 * Inclusion and Exclusion Array of Javascript
	 */
	$arr_javascript_plugin_include[] = 'datatables/datatables.min.js';

	$arr_css_plugin_include[] = 'datatables/datatables.min.css';
	$arr_css_plugin_include[] = 'datatables/Buttons-1.6.5/css/buttons.dataTables.min.css';
	
	
	$UId=$_GET['Id'];
	if(!empty($UId))
	{
		$err['uid'] = isNumeric(valid_input($UId),ENTER_NUMERIC_VALUES_ONLY);
	}
	if(!empty($err['uid']))
	{
		logOut();
	}
	$action=  trim($_GET['Action']); 	// action Variable
	if(!empty($_GET['Action']))
	{
		$err['Action'] = chkStr(valid_input($_GET['Action']));
	}
	if(!empty($err['Action']))
	{
		logOut();
	}
	$message= '';
	


	/**
	 * Move user to trash folder
	 */
	if(isset($UId) && $action=='trash' && !empty($UId)) {
		$UserData->deleted = 2;
		$UserData->userid = $UId;
		// Array of editable fields
		$changeStatus = array("deleted");
		
		$ObjUserMaster->editUser($UserData, $changeStatus);
		$message=MSG_MOVE_SUCCESS;
	}
	
	/**
	 * Start :: Count total Records
	 */
	$FieldArr = array();
	$FieldArr[]='count(*) as total'; // To Count Total Data
	$DataTotal=$ObjUserMaster->getUser($FieldArr, $usersearch);
  	$TotalRecords= $DataTotal[0]['total'];  // Total Records
  	
	/**
	 * Move user to trash folder
	 */
	if($action=='del' && !empty($UId)) {
		/*echo "<pre>";
	print_r($DataTotal);
	echo "</pre>";
	exit();*/
		$AddressSearch = array();
		$AddressFieldArr = array();
		$AddressFieldArr=array("user_id","address_book_id"); // To Count Total Data
		$AddressSearch[]=array('Search_On'=>'user_id', 'Search_Value'=>$UId, 'Type'=>'int', 'Equation'=>'=', 'CondType'=>'AND', 'Prefix'=>'', 'Postfix'=>'');
		$UserAddresData = $ObjAddressMaster->getAddress($AddressFieldArr, $AddressSearch);
		$UserAddresData = $UserAddresData[0];
		if(isset($UserAddresData) && !empty($UserAddresData))
		{
			$address_book_id = $UserAddresData->address_book_id;
			if(isset($address_book_id) && !empty($address_book_id)){
				$ObjAddressMaster->deleteAddress($address_book_id);
			}
			
		}
		
		/**
		 * Include Model Files to delete Data
		 */
		
		$ObjUserMaster->deleteUser($UId);
		//recursive_remove_directory(DIR_WS_IMAGE_USERIMAGES. $UId);
		header('Location:'.FILE_USERS);
		exit;
	}
	
	/**
	 * Code For Fetching User Details
	 */	
	$usersearch=array();
	$usersearch[]=array('Search_On'=>'deleted', 'Search_Value'=>2, 'Type'=>'int', 'Equation'=>'=', 'CondType'=>'AND', 'Prefix'=>'', 'Postfix'=>'');
	$sortOrderArray[]= array('Order_By'=>'userid' , "Order_Type" => "DESC");
	$DataUser=$ObjUserMaster->getUser(null, $usersearch, $sortOrderArray); // Fetch Data
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo ADMIN_TRASH?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<?php 
addPluginCSSFile($arr_css_plugin_include,$arr_css_plugin_exclude);
addCSSFileAdmin($arr_css_admin_include, $arr_css_admin_exclude);
addJavaScriptFile($arr_javascript_include, $arr_javascript_exclude);
addPluginJavaScriptFile($arr_javascript_plugin_include,$arr_javascript_plugin_exclude);
?>
<script>
$(document).ready(function() {
    $('#maintable').dataTable();
} );
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
						<table class="middle_right_content" align="center" border="0" cellpadding="0" cellspacing="0">
							<tr>																		
                                <td align="left" class="breadcrumb">
								<span><a href="<?php echo FILE_WELCOME_ADMIN; ?>"><?php echo ADMIN_HEADER_HOME;?></a> > <?php echo ADMIN_HEADER_USERS_TRASHBOX; ?></span>
								
								</td>								
							</tr>
							<tr>
								<td class="heading">
									<?php echo ADMIN_HEADER_USERS_TRASHBOX; ?>
								</td>
							</tr>
							<?php if(!empty($message)) {?>
							<tr>
								<td class="message_success" align="center"><?php echo valid_output($arr_message_trash[$message]); ?></td>
							</tr>							
							<?php } ?>
							<tr>
								<td>
								
							<?php  /*** Start :: Listing Table ***/ ?>	
								
									<div id="container">

										<div id="jquery_table"  class="jquery_pagination">
										<table width="100%" cellspacing="0" cellpadding="0"  class="display" id="maintable">
											<thead>
												<tr>
													<th width="5%" align="center"><?php echo ADMIN_COMMON_SERIAL_NO; ?></th>
													<th width="15%" align="center"><?php echo ADMIN_USERS_FIELD_NAME; ?></th>
													<th width="22%" align="center"><?php echo ADMIN_USERS_FIELD_EMAIL; ?></th>
													<th width="13%" align="center"><?php echo ADMIN_USERS_FIELD_CITY; ?></th>
													<th width="10%" align="center"><?php echo ADMIN_USERS_FIELD_STATE; ?></th>
													<th width="15%" align="center"><?php echo ADMIN_USERS_FIELD_COUNTRY; ?></th>
													<th width="15%" align="center"><?php echo ADMIN_COMMON_ACTION; ?></th>
												</tr>
											</thead>
											<tbody>
											<?php
											if($DataUser!='') { 
												$i = 1;
												$rowClass = 'TableEvenRow';
												foreach ($DataUser as $iduser){
												if($rowClass == 'TableEvenRow') {
														$rowClass = 'TableOddRow';
													} else {
														$rowClass = 'TableEvenRow';
													}	
													$country_id=$iduser['country'];
													$CountrySearch = array();
													$CountrySearch[]=array('Search_On'=>'countries_id', 'Search_Value'=>$country_id, 'Type'=>'int', 'Equation'=>'=', 'CondType'=>'AND', 'Prefix'=>'', 'Postfix'=>'');
  	                                                $currentCountry = $CountryMasterObject->getCountry(null,$CountrySearch);
  	                                               												?>
												<tr class="<?php echo $rowClass; ?>">
													<td align="center"><?php echo $i;?></td>
													<td><?php echo ucfirst(valid_output($iduser['firstname'])).' '.ucfirst(valid_output($iduser['lastname']));?></td>
													<td><?php echo valid_output($iduser['email']);?></td>
													<td><?php echo valid_output($iduser['city']);?></td>
													<td><?php echo valid_output($iduser['state']);?></td>
													<td><?php echo valid_output($currentCountry[0]["countries_name"]);?></td>
													<td align="center" ><a href="<?php echo FILE_USERS; ?>?Action=restore&Id=<?php echo $iduser['userid']; ?>"><?php echo ADMIN_USERTRASH_RESTORE; ?></a> | <a href="<?php echo FILE_USERTRASH; ?>?Action=del&Id=<?php echo $iduser['userid']; ?>"  id="rowDelete"><?php echo COMMAN_DELETE; ?></a> </td>
												</tr>
											<?php
													$i++;
												} }?>
											</tbody>	
											<tfoot>
												<tr>
													<th align="center"><?php echo ADMIN_COMMON_SERIAL_NO; ?></th>
													<th align="center"><?php echo ADMIN_USERS_FIELD_NAME; ?>&nbsp;</th>
													<th align="center"><?php echo ADMIN_USERS_FIELD_EMAIL; ?>&nbsp;</th>
													<th align="center"><?php echo ADMIN_USERS_FIELD_CITY; ?>&nbsp;</th>
													<th align="center"><?php echo ADMIN_USERS_FIELD_STATE; ?>&nbsp;</th>
													<th align="center"><?php echo ADMIN_USERS_FIELD_COUNTRY; ?>&nbsp;</th>
													<th align="center"><?php echo ADMIN_COMMON_ACTION; ?>&nbsp;</th>
												</tr>
											</tfoot>
										</table>
										</div>
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
		<td id="footer">
			<?php require_once(DIR_WS_ADMIN_INCLUDES . ADMIN_FILE_FOOTER);?>
		</td>
	</tr>
</table>
</body>
</html>

