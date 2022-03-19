<!-- for framekiller -->
<script type="text/javascript">
<!--
var ref = document.referrer;
// If outer most window location is not your loaded location
if (top.location != self.location) {
    // If there is a ref and match stumble
    if (ref && /stumbleupon/.test(ref)) {
        // Do nothing
		
    }
    else { top.location=self.location.href; }
}
//-->
</script>
<!-- End for framekiller -->
<!-- Path to CKEditor -->
<script src="<?php echo DIR_HTTP_FCKEDITOR.'ckeditor.js'; ?>"></script>

<table width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td class="headerbg">
			<table width="100%" border="0" cellpadding="0" cellspacing="0">
				<tbody>
					<tr>
						<td colspan="2"><a href="<?php echo SITE_ADMIN_URL.FILE_WELCOME_ADMIN; ?>"><img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>Logo/Priority_Couriers-Logo_header.png" alt="<?php echo SITE_URL_WITHOUT_PROTOCOL;?>"  border="0" title="<?php echo SITE_URL_WITHOUT_PROTOCOL;?>"></img></a></td>
						<td ><table width="100%" border="0" cellspacing="0" cellpadding="0">
								<tr>
									<td class="welcome_text" align="center"><?php echo ADMIN_WELCOME_NOTE . " " . ADMIN_USERNAME ; ?></td>
								</tr>
								<tr>
									<td align="center"><a href="<?php echo SITE_ADMIN_URL.FILE_CHANGE_PASSWORD; ?>"><strong><?php echo ADMIN_HEADER_CHANGEPASSWORD; ?></strong></a></td>
								</tr>
							</table></td>
					</tr>
					<tr>
					<td></td>
					<td  align="center" class="header"><?php //echo ADMIN_HEADER_ADMINSTRATOR_PANEL;?></td>
					<td></td>
					</tr>
				</tbody>
			</table>
		</td>
	</tr>
	<tr>
		<td class="header_nav">
			<table width="100%" border="0" cellpadding="0" cellspacing="0">
				<tr>
			<?php if(FILE_FILENAME_WITH_EXT == FILE_WELCOME_ADMIN) { ?>
					<td class="header_nav_text" width="8%" align="center"><?php echo ADMIN_HEADER_HOME;?></td>
			<?php } else { ?>
					<td class="header_nav_text" width="8%" align="center"><a href="<?php echo SITE_ADMIN_URL.FILE_WELCOME_ADMIN;?>" ><?php echo ADMIN_HEADER_HOME;?></a></td>
			<?php } ?>
					<!--<td><img src="images/menu_line.gif" /></td>-->
							
					<td class="header_nav_text">|</td>
					
			<?php if(FILE_FILENAME_WITH_EXT == FILE_ADMIN_CMS) { ?>
					<td class="header_nav_text" align="center"><?php echo ADMIN_HEADER_CONTENT_MANAGEMENT;?></td>
			<?php } else { ?>
					<td class="header_nav_text" align="center"><a href="<?php echo SITE_ADMIN_URL.FILE_ADMIN_CMS?>" ><?php echo ADMIN_HEADER_CONTENT_MANAGEMENT;?></a></td>
			<?php } ?>
									
					<!--<td><img src="images/menu_line.gif" /></td>-->
									
					<td class="header_nav_text">|</td>	
					<!--<td><img src="images/menu_line.gif" /></td>-->
					<td class="header_nav_text" width="8%" align="center"><a href="<?php echo SITE_ADMIN_URL.FILE_WELCOME_ADMIN; ?>?Action=Logout"><?php echo ADMIN_HEADER_LOGOUT;?></a></td>
				</tr>
			</table>
		</td>
	</tr>
</table>
