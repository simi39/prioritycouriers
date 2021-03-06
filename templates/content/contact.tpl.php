<!--=== Breadcrumbs ===-->
<div class="breadcrumbs">
	<div class="container">
        <h1 class="color-green pull-left">Our Contacts</h1>
        <ul class="pull-right breadcrumb">
            <li><a href="<?php echo SITE_INDEX;?>">Home</a> <span class="divider">/</span></li>
            <li class="active">Contact</li>
        </ul>
    </div><!--/container-->
</div><!--/breadcrumbs-->
<!--=== End Breadcrumbs ===-->

<!-- Google Map -->
<!--<div id="map" class="map margin-bottom-40">
	<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3310.820951940446!2d151.17859901544747!3d-33.920007480642006!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x6b12b05688f73bb3%3A0x549f1a225ee9a13a!2s1-3%20Ricketty%20St%2C%20Mascot%20NSW%202020%2C%20Australia!5e0!3m2!1sen!2spl!4v1604664897380!5m2!1sen!2spl" width="100%" height="350" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
</div>--><!---/map-->
<!-- End Google Map -->

<!--=== Content Part ===-->
<div class="container">
	<div class="row-fluid">
		<div class="span9">
            <div class="headline"><h3>Contacts</h3></div>
            <p><span class="message_success"></span></p>
			<p>Please use the form below to email us your query.</p><br />
			<form id="contact-form" autocomplete='off' method="post"/>

           		<div class="form-group control-group">
                <label class="control-label"><?php echo CONTACT_YOUR_NAME; ?></label>
                <input type="text" name="fullname" id="fullname" class="span7 border-radius-none form-control margin_bottom_0_important" <?php if(isset($session_data['firstname']) && $session_data['firstname']!=""){ echo "readonly=readonly";} ?> value="<?php if($_POST['firstname'] != ''){  echo valid_output($_POST['firstname']);} elseif (isset($fullname) && $fullname!='') { echo valid_output(trim($fullname)); } ?>"  tabindex="1" data-toggle="tooltip" title="<?php echo "Enter your Name";?>" data-placement="right"/>
                	<div class="help-block alert-error" id="fullname_message"></div>
                    	<span id="error_fullname"><?php echo $emailerrorval; ?></span>
                </div>
                <div class="form-group control-group">
                <label class="control-label"><?php echo CONTACT_EMAIL_ID; ?> <span class="color-red">*</span></label>
                <input type="text" name="clientemail" id="clientemail" class="span7 border-radius-none form-control margin_bottom_0_important" <?php if(isset($useremailid) && $useremailid!=""){ echo "readonly";} ?> value="<?php if($_POST['clientemail'] != ''){  echo valid_output($_POST['clientemail']);} elseif (isset($useremailid) && $useremailid!='') { echo valid_output(trim($useremailid)); } ?>"  tabindex="2" data-toggle="tooltip" title="<?php echo "Enter Email Address";?>" data-placement="right"/>
                	<div class="help-block alert-error" id="clientemail_message"></div>
                    	<span id="error_fullname"><?php echo $emailerrorval; ?></span>
            	</div>
                <div class="form-group control-group">
                <label><?php echo CONTACT_MESSEGE; ?> <span class="color-red">*</span></label>
                <textarea rows="8" name="enquiry" id="enquiry" class="span10 form-control margin_bottom_0_important" tabindex="3" data-toggle="tooltip" title="<?php echo "Enter Comments";?>" data-placement="right"><?php if(isset($_POST['enquiry']) && $_POST['enquiry']!=''){ echo valid_output($_POST['enquiry']);} ?></textarea>
                	<div class="help-block alert-error" id="enquiry_message"></div>
                    	<span id="error_fullname"><?php echo $emailerrorval; ?></span>
           		</div>
				<!--== 16th Row ==-->
				<div class="input-prepend form-group control-group">
					<div id="captcha_container"></div>
					<span class="alert-error has error help-block" id="reCaptcha_error_message" style="display:none;">
					<a class="close">??</a>
					<small style="display: block;" class="has-error alert-error"><?php echo MSG_CAPTCHA_IS_REQUIRED; ?></small>
					</span>
				</div><!--===/End ReCaptcha Applied ===-->
				<?php
				if(isset($err['recaptcha'])){
				?>
				<!-- ReCaptcha Validation	-->
				<div class="alert alert-error show" id="reCaptchaError_css">
					<a class="close">??</a>
					<div ><?php if(isset($err['recaptcha'])) { echo $err['recaptcha']; }?></div>
				</div><!--	End ReCaptcha Validation	-->
			   <?php
				}
				?>
				<!--== 16th Row ==-->
                <p>
				<input type="hidden" id="ptoken" value="<?php echo $ptoken; ?>" name="ptoken">
				<input type="hidden" value="" id="gcaptcha" name="gcaptcha" />
				<input type="submit" class="btn-u" id="btnsubmit" name="Submit" value="<?php echo COMMON_SEND_MESSAGE; ?>">
				</p>

            </form>
        </div><!--/span9-->

		<div class="span3">
        	<!-- Contacts -->
            <div class="headline"><h3>Contacts</h3></div>
            <ul class="unstyled who margin-bottom-20">
                <!--<li><a href="#"><i class="icon-home"></i><?php echo DEFAULT_PL_ADDRESS_1; ?>, <?php echo DEFAULT_PL_ADDRESS_2; ?></a></li>
				<li class="address_margin"><a href="#"><?php echo DEFAULT_PL_CITY; ?> Australia</a></li>-->
                <li><a href="mailto:<?php echo DEFAULT_INFO_EMAIL; ?>"><i class="icon-envelope-alt"></i><?php echo DEFAULT_INFO_EMAIL; ?></a></li>
                <!--<li><a href="#"><i class="icon-phone-sign"></i><?php echo DEFAULT_PHONE; ?></a></li>-->
                <li><a href="#"><i class="icon-globe"></i>http://prioritycouriers.com.au/</a></li>
            </ul>

        	<!-- Business Hours -->
            <div class="headline"><h3>Business Hours</h3></div>
            <ul class="unstyled">
            	<li><strong>Monday-Friday:</strong> 9am to 5pm</li>
            	<li><strong>Saturday:</strong> Closed</li>
            	<li><strong>Sunday:</strong> Closed</li>
            </ul>
        </div><!--/span3-->
    </div><!--/row-fluid-->

    <div class="row-fluid">
	<div class="span4"></div>
    <div class="span4">
	<!-- Our Clients -->
	<div id="clients-flexslider" class="flexslider home clients">
        <div class="headline"><h3>Our Partners</h3></div>
		<ul class="slides">
			<li>
                <a href="#">
                    <img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>Partners/StarTrackBlue-Logo_60.jpg" alt="" />
                    <img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>Partners/StarTrackBlue-Logo_60.jpg" class="color-img" alt="" />
                </a>
            </li>
			<li>
                <a href="#">
                    <img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>Partners/UPS-Logo_60.jpg" alt="" />
                    <img src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>Partners/UPS-Logo_60.jpg" class="color-img" alt="" />
                </a>
            </li>
		</ul>
	</div><!--/flexslider-->
    </div>
    <div class="span4"></div>
    </div>
</div><!--/container-->
<!--=== End Content Part ===-->
<!-- Contact us success pop up -->
<div class="modal hide fade small_rates" id="Contact">
	<div class="modal-header">
	<h3><?php echo CONTACT_MESSAGE_HEAD; ?></h3>
	</div>
	<div class="modal-body">
	<span class="my_bigger_font"><?php echo CONTACT_SUCCESS_MESSAGE; ?></span>
	</div>
	<div class="modal-footer"><a href="#" class="btn-u btn-u-primary" data-dismiss="modal" id="closemodal">Close</a></div>
</div><!-- End of the pop up -->
