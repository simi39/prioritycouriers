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
	require_once('pagination_top.php');
	require_once(DIR_WS_RELATED."system_mail.php");
	require_once(DIR_WS_ADMIN_LANGUAGES . DIR_CURRENT_LANGUAGE. '/product_label.php');
	
	
	require_once(DIR_WS_MODEL . "ProductLabelMaster.php");	
	require_once(DIR_WS_MODEL . "SupplierMaster.php");
	/**
		    	 * Start :: Object declaration
		    	 */
	$ObjProductLabelMaster	= new ProductLabelMaster();
	$ObjProductLabelMaster	= $ObjProductLabelMaster->Create();
	$ProductLabelData		= new ProductLabelData();	
	
	
	$ObjSupplierMaster	= new SupplierMaster();
	$ObjSupplierMaster	= $ObjSupplierMaster->Create();
	$SupplierData		= new SupplierData();
	
		
	$fieldArr = array("*");
	$DataSupplier=$ObjSupplierMaster->getSupplier($fieldArr);
	
	$pagenum = ($_GET['pagenum']!="")?($_GET['pagenum']):(1);
	if(!empty($pagenum))
	{
		$err['pagenum'] = isNumeric(valid_input($pagenum),ENTER_NUMERIC_VALUES_ONLY);
	}
	if(!empty($err['pagenum']))
	{
		logOut();
	}
	
	/**
		    	 * Inclusion and Exclusion Array of Javascript
		    	 */
	
	$arr_javascript_plugin_include[] = 'datatables/datatables.min.js';

	$arr_css_plugin_include[] = 'datatables/datatables.min.css';
	$arr_css_plugin_include[] = 'datatables/Buttons-1.6.5/css/buttons.dataTables.min.css';
	/*csrf validation*/
	$csrf = new csrf();
	$csrf->action = "product_label";
	if(!isset($_POST['ptoken'])) {
		$ptoken = $csrf->csrfkey();
	}
	/*csrf validation*/

	/**
		    	 * Variable Declaration
		    	 */
	
	$auto_id = $_GET['auto_id'];
	if(!empty($auto_id))
	{
		$err['auto_id'] = isNumeric(valid_input($auto_id),ENTER_NUMERIC_VALUES_ONLY);
	}
	if(!empty($err['auto_id']))
	{
		logOut();
	}
	if($auto_id!="")
	{
		$btnSubmit = ADMIN_BUTTON_UPDATE_PRODUCT_LABEL;
		$HeadingLabel = ADMIN_LINK_UPDATE_PRODUCT_LABEL;
	}
	else
	{
		$btnSubmit = ADMIN_BUTTON_SAVE_PRODUCT_LABEL;
		$HeadingLabel = ADMIN_LINK_SAVE_PRODUCT_LABEL;
	}

	if(!empty($_GET['Action']))
	{
		$err['Action'] = chkStr(valid_input($_GET['Action']));
	}
	if(!empty($err['Action']))
	{
		logOut();
	}
	if($_GET['Action']=='trash')
	{		
		$ObjProductLabelMaster->deleteProductLabel($auto_id);
		$UParam = "?pagenum=".$pagenum."&message=".MSG_DELETE_PRODUCT_LABEL_SUCCESS;
		header('Location: '.FILE_PRODUCT_LABEL_MANAGMENT.$UParam);
	}
	
	
	if($_GET['Action']=='mtrash'){
		$auto_id = $_GET['m_trash_id'];
		$m_t_a=explode(",",$auto_id);
		foreach($m_t_a as $val)
		{	
			$error = isNumeric(valid_input($val),ENTER_NUMERIC_VALUES_ONLY);
			if(!empty($error))
			{
				logOut();
			}else
			{
				$ObjProductLabelMaster->deleteProductLabel($val);
			}			
		}
		$UParam = "?pagenum=".$pagenum."&message=".MSG_DELETE_PRODUCT_LABEL_SUCCESS;
		header('Location: '.FILE_PRODUCT_LABEL_MANAGMENT.$UParam);
	
	
	}
	
	if((isset($_POST['submit']) && $_POST['submit'] != "")){
		
		if(isEmpty(valid_input($_POST['ptoken']), true)){	
			logOut();
		}else{
			//$csrf->checkcsrf($_POST['ptoken']);
		}
		$err['ProductNameError'] 		 = isEmpty(strtoupper($_POST['product_name']), ADMIN_PRODUCT_NAME_IS_REQUIRED)?isEmpty(strtoupper($_POST['product_name']), ADMIN_PRODUCT_NAME_IS_REQUIRED):checkStr($_POST['product_name']);
		$err['SupplierNameError'] 		 = isEmpty(strtoupper($_POST['supplier_id']), ADMIN_SUPPLIER_NAME_IS_REQUIRED)?isEmpty(strtoupper($_POST['supplier_id']), ADMIN_SUPPLIER_NAME_IS_REQUIRED):isNumeric(valid_input($_POST['supplier_id']),ENTER_NUMERIC_VALUES_ONLY);
		$err['ProductCodeError'] 		 = isEmpty(strtoupper($_POST['product_code']), ADMIN_PRODUCT_CODE_IS_REQUIRED)?isEmpty(strtoupper($_POST['product_code']), ADMIN_PRODUCT_CODE_IS_REQUIRED):checkStr($_POST['product_code']);
		$err['ProductLabelError'] 		 = isEmpty(strtoupper($_POST['label_code']), ADMIN_PRODUCT_LABEL_CODE_IS_REQUIRED)?isEmpty(strtoupper($_POST['label_code']), ADMIN_PRODUCT_LABEL_CODE_IS_REQUIRED):checkStr($_POST['label_code']);
		
		
		/**
		    		 * Checking Error Exists
		    		 */
		foreach($err as $key => $Value) {
			if($Value != '') {
				$Svalidation=true;
				$csrf->checkcsrf($_POST['ptoken']);
			}
		}
	
		if($Svalidation==false){
			
			$ProductLabelData->product_name = strtoupper(trim($_POST['product_name']));
			$ProductLabelData->supplier_id = strtoupper(trim($_POST['supplier_id']));
			$ProductLabelData->product_code = trim(strtoupper($_POST['product_code']));
			$ProductLabelData->label_code = trim(strtoupper($_POST['label_code']));
			$ProductLabelData->description = trim($_POST['description']);
			
			if($auto_id!=''){
				
				//Edit Users
				$ProductLabelData->status = trim($_POST['status']);
				$ProductLabelData->auto_id = $auto_id;
				
				$ObjProductLabelMaster->editProductLabel($ProductLabelData);
				$UParam = "?pagenum=".$pagenum."&message=".MSG_EDIT_PRODUCT_LABEL_SUCCESS;
			}else{
				$insertedauto_id = $ObjProductLabelMaster->addProductLabel($ProductLabelData);
				$UParam = "?pagenum=".$pagenum."&message=".MSG_ADD_PRODUCT_LABEL_SUCCESS;
			}
			header('Location: '.FILE_PRODUCT_LABEL_MANAGMENT.$UParam);
	
		}
	
	}	

	/**
		    	 * Gets details for the user
		    	 */
	
	if($auto_id!=''){
	
		$fieldArr=array("*");
		$seaByArr=array();
		$seaByArr[]=array('Search_On'=>'auto_id', 'Search_Value'=>$auto_id, 'Type'=>'int', 'Equation'=>'=', 'CondType'=>'', 'Prefix'=>'and', 'Postfix'=>'');
	
		$DataService=$ObjProductLabelMaster->getProductLabel($fieldArr,$seaByArr); // Fetch Data
	
		$DataService = $DataService[0];
	
		//Get sign up Address
	
		//Variable declaration
	
		$btnSubmit = ADMIN_BUTTON_UPDATE_PRODUCT_LABEL;
		$HeadingLabel = ADMIN_LINK_UPDATE_PRODUCT_LABEL;
	}
	
	
		    ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title><?php if ($_GET['auto_id']=='') { echo ADMIN_ADD_USER; } else { echo ADMIN_EDIT_USER;}?></title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<script src="<?php echo DIR_HTTP_FCKEDITOR.'ckeditor.js'; ?>"></script>
		<?php
		addCSSFileAdmin($arr_css_admin_include, $arr_css_admin_exclude);
		addJavaScriptFile($arr_javascript_include, $arr_javascript_exclude); 
		addPluginCSSFile($arr_css_plugin_include,$arr_css_plugin_exclude);
		addPluginJavaScriptFile($arr_javascript_plugin_include,$arr_javascript_plugin_exclude);
		?>
		<script>
		$(document).ready(function() {
			$('#maintable').dataTable();
		} );
		</script> 
 
					
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
								<!-- Start :  Middle Content-->
								<table class="middle_right_content" align="center" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td align="left" class="breadcrumb">
											<span><a href="<?php echo FILE_WELCOME_ADMIN; ?>"><?php echo ADMIN_HEADER_HOME; ?></a> > <a href="<?php echo FILE_PRODUCT_LABEL_MANAGMENT.'?pagenum='.$pagenum; ?>"> <?php echo ADMIN_HEADER_PRODUCT_LABEL_MANAGEMENT; ?> </a> > <? echo $HeadingLabel; ?></span>
											<div><label class="top_navigation"><a href="<?php echo FILE_PRODUCT_LABEL_MANAGMENT.'?pagenum='.$pagenum; ?>"><?php echo ADMIN_COMMON_BACK; ?></a></label></div>
										</td>
									</tr>
									<tr>
										<td align="center">
											<?php  /*** Start :: Listing Table ***/ ?>
											<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
												<form name="frmuser" method="POST" action="">
													<input type="hidden" name="Id1" value="<?php //echo $maximum_id[0] || $_GET['Id'];?>" />
													<tr>
														<td>
															<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td>
																		<table width="98%" border="0" cellpadding="0" border="0" cellspacing="0">
																			<tr>
																				<td class="message_mendatory" align="right" colspan="4">
																					<?echo ADMIN_COMMAN_REQUIRED_INFO;?>
																				</td>
																			</tr>
																			<tr>
																				<td align="left" valign="middle"><?php echo ADMIN_PRODUCT_NAME; ?><span class="message_mendatory">*</span></td>
																				<td align="left" valign="middle" class="message_mendatory">
																					<input type="text" id="product_name" name="product_name" value="<?php if(strtoupper($_POST['product_name']) != ''){ echo strtoupper($_POST['product_name']);}else{ echo valid_output($DataService["product_name"]); }?>" />
																					&nbsp; <span class="message_mendatory"><?php if($err['ProductNameError']!=""){ echo $err['ProductNameError']; } ?></span>
																				</td>
																				<td align="left" valign="top" class="message_mendatory"></td>
																				<td align="left" valign="top" class="message_mendatory">
																				</td>
																			</tr>
																			<tr>
																				<td colspan="4">&nbsp;</td>
																			</tr>
																			<tr>
																				<td align="left" valign="middle"><?php echo ADMIN_SUPPLIER_NAME;?><span class="message_mendatory">*</span></td>
																				<td align="left" valign="middle">
																					<select name="supplier_id" id="supplier_id">
																						<option value="">Select</option>
																						<?php
																							foreach($DataSupplier as $supplier)
																							{
																								?>
																						<option value="<?php echo $supplier["auto_id"]; ?>" <?php if($DataService['supplier_id']==$supplier["auto_id"]){ echo "selected"; }elseif($_POST['supplier_id']==$supplier["auto_id"]){ echo "selected"; } ?>><?php echo valid_output($supplier["supplier_name"]); ?></option>
																						<?php
																							}
																								 ?>                                                                                       
																					</select>
																					&nbsp; <span class="message_mendatory"><?php if($err['SupplierNameError']!=""){ echo $err['SupplierNameError']; } ?></span>
																				</td>	
																				<td align="left" valign="top" class="message_mendatory"></td>
																				<td align="left" valign="top" class="message_mendatory"></td>
																			</tr>
																			<tr>
																				<td align="left" valign="middle" colspan="4"><br /></td>
																			</tr>
																			<tr>
																				<td align="left" valign="middle"><?php echo ADMIN_PRODUCT_CODE; ?><span class="message_mendatory">*</span></td>
																				<td align="left" valign="middle" class="message_mendatory">
																					<input type="text" id="product_code" name="product_code" value="<?php if(strtoupper($_POST['product_code']) != ''){ echo strtoupper($_POST['product_code']);}else{ echo valid_output($DataService["product_code"]); }?>" />
																					&nbsp; <span class="message_mendatory"><?php if($err['ProductCodeError']!=""){ echo $err['ProductCodeError']; } ?></span>
																				</td>
																				<td align="left" valign="top" class="message_mendatory"></td>
																				<td align="left" valign="top" class="message_mendatory">
																				</td>
																			</tr>
																			<tr>
																				<td align="left" valign="middle" colspan="4"><br /></td>
																			</tr>
																			<tr>
																				<td align="left" valign="middle"><?php echo ADMIN_PRODUCT_LABEL_CODE; ?><span class="message_mendatory">*</span></td>
																				<td align="left" valign="middle">
																				<input type="text" id="label_code" name="label_code" value="<?php if(strtoupper($_POST['label_code']) != ''){ echo strtoupper($_POST['label_code']);}else{ echo valid_output($DataService["label_code"]); }?>" />
																				&nbsp; <span class="message_mendatory"><?php if($err['ProductLabelError']!=""){ echo $err['ProductLabelError']; } ?></span>																						
																				</td>
																				<td align="left" valign="top" class="message_mendatory"></td>
																				<td align="left" valign="top" class="message_mendatory">
																				</td>
																			</tr>
																			<tr>
																				<td align="left" valign="middle" colspan="4"><br /></td>
																			</tr>																																					
																			<tr>
																				<td align="left" valign="middle" colspan="4"><br /></td>
																			</tr>
																			
																			<tr>
																				<td align="left" valign="middle"><?php echo ADMIN_PRODUCT_LABEL_DESCRIPTION; ?></td>
																				<td align="left" valign="middle" class="message_mendatory" colspan="2">
																					<?php 
																						if(isset($DataService["description"]) && !empty($auto_id)) {
																							$description=($DataService["description"]);
																						
																						}
																						elseif($_POST["description"]!=""){
																							$description=$_POST["description"];
																						}else{
																							$description='';
																						}
																						
																							          //$oFCKeditor->Create();?>
																				<textarea cols="80" id="description" name="description" rows="10"><?php echo htmlspecialchars($description); ?></textarea>
																				<script>
																				CKEDITOR.replace('description');
																				</script>
																				</td>
																				<td align="left" valign="top" class="message_mendatory">
																				</td>
																			</tr>
																			<tr>
																				<td align="left" valign="middle" colspan="4"><br /></td>
																			</tr>
																			<tr>
																				<td align="left" valign="middle" colspan="4"><br /></td>
																			</tr>
																			<tr>
																				<td align="left" valign="middle"><?php echo ADMIN_PRODUCT_LABEL_STATUS; ?><span class="message_mendatory">*</span></td>
																				<td align="left" valign="middle">
																				<input type="radio" name="status" id="status1" value="1" checked <?php if(($_POST['status']) == '1'){ echo "checked";}?> <?php if(($DataService['status']) == '1'){ echo "checked";}?> > <label for="status1" > Active </label> </input>
																				<input type="radio" name="status" value="0" id="status2" <?php if(($_POST['status']) == '0'){ echo "checked";}?> <?php if(($DataService['status']) == '0'){ echo "checked";}?>> <label for="status2" > Inactive </label></input>																																									
																				</td>
																				<td align="left" valign="top" class="message_mendatory"></td>
																				<td align="left" valign="top" class="message_mendatory">
																				</td>
																			</tr>
																			
																			<tr>
																				<td align="left" valign="middle" colspan="4"><br /></td>
																			</tr>
																		</table>
																	</td>
																</tr>
																<tr>
																	<td>&nbsp;</td>
																</tr>
															</table>
														</td>
													</tr>
													<tr>
														<td>&nbsp;</td>
													</tr>
													<tr>
														<td align="left">
															<input type="hidden" size="34" id="ptoken" value="<?php echo $ptoken; ?>" name="ptoken">
															<input type="submit" class="action_button" tabindex="36" name="submit" value="<?php echo $btnSubmit; ?>" onclick="return validate_client(this.form);" />
															<input type="reset" tabindex="37" name="reset" class="action_button" value="<?php echo ADMIN_COMMON_BUTTON_RESET; ?>" />
															<input type="button" class="action_button" name="cancel" tabindex="38" value="<?php echo ADMIN_COMMON_BUTTON_CANCEL;?>" onclick="javascript:document.location.href='<?php echo FILE_PRODUCT_LABEL_MANAGMENT.'?pagenum='.$pagenum; ?>';return true;" />
														</td>
													</tr>
													<tr>
														<td>&nbsp;</td>
													</tr>
												</form>
											</table>
											<?php  /*** End :: Listing Table ***/ ?>
										</td>
									</tr>
								</table>
								<!-- End :  Middle Content-->
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

<?php if($auto_id!="")
{
	?>
}
<script type="text/javascript">
	$(document).ready(function(){		
		// $("#service_id").attr('readonly', true);	
	});	
</script>
<?php } ?>