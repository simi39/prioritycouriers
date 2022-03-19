<!--=== Top ===-->
<?php
 //echo show_page_link(FILE_LOGIN);
 //echo SITE_URL;
?>
<div class="top">
    <div class="container">
    	<ul class="loginbar pull-right">
                <li><a href="mailto:<?php echo DEFAULT_INFO_EMAIL; ?>"><i class="icon-envelope-alt"></i> <?php echo DEFAULT_INFO_EMAIL; ?></a></li>
                <li class="devider">&nbsp;</li>
            	<!--<li><a><i class="icon-phone-sign"></i></a></li
                <li class="devider">&nbsp;</li>><?php echo show_page_link(FILE_LOGIN); ?>-->
            	<?php if(defined('SES_USER_ID')){ ?>
                <li><?php echo USER_WELCOME_NOTE . "&nbsp;<strong class='my_green'>&nbsp;" . ucfirst(SES_USER_FIRSTNAME) . " </strong>" ;//. ucfirst(SES_USER_LASTNAME) . ""; ?></li>
				<li class="devider">&nbsp;</li>
				<li><a href="<?php echo show_page_link(FILE_LOGIN).'?action=logout'; ?>"  class="login-btn"><?php echo HEADING_USER_LOGOUT; ?></a></li>
				<?php }else{ ?>
				<li><a href="<?php echo show_page_link(FILE_LOGIN); ?>" class="login-btn"><?php //echo show_page_link(FILE_LOGIN); ?>Login/Register</a></li>
				<?php } ?>
        </ul>
    </div>
</div><!--/top-->
<?php
//echo show_page_link(FILE_LOGIN);
//exit();
?>
<!--=== End Top ===-->

<!--=== Header ===-->
<div class="header">
    <div class="container">
        <!-- Logo -->
        <div class="logo">
            <a href="<?php echo SITE_INDEX;?>"><img id="logo-header" src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>Logo/Priority_Couriers-Logo_header.png" alt="Logo" /></a>
        </div><!-- /logo -->

        <!-- Menu -->
        <div class="navbar">
          <div class="navbar-inner">
            <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </a><!-- /nav-collapse -->
            <div class="nav-collapse collapse">
              <ul class="nav top-2 pull-right">
                <?php if(!defined('SES_USER_ID')){ ?>
                  <li class="<?php if(FILE_FILENAME_WITH_EXT == FILE_INDEX){ echo 'active';} ?>">
                    <a href="<?php echo SITE_INDEX;?>">Home</a>
                  </li>
                <?php }
                if(defined('SES_USER_ID')){ ?>
                  <li class="<?php if(FILE_FILENAME_WITH_EXT == FILE_BOOKING){ echo 'active';} ?>">
                    <a href="<?php echo show_page_link(FILE_BOOKING);?>"><?php echo NAVIGATION_BOOKING;?></a>
                  </li>
                <?php } ?>
                <li class="<?php if(isset($_SERVER['REQUEST_URI']) && (strpos($_SERVER['REQUEST_URI'],'services')!==false)){ echo 'active';} ?>">
                  <a href="<?php echo show_page_link(FILE_CMS .'?page=services');?>"><?php echo NAVIGATION_SERVICES;?></a>
                </li>
                <li class="<?php if(isset($_SERVER['REQUEST_URI']) && (strpos($_SERVER['REQUEST_URI'],'how-to-quote')!==false)){ echo 'active';} ?>">
                  <a href="<?php echo show_page_link(FILE_CMS .'?page=how-to-quote');?>"><?php echo NAVIGATION_HOWTO;?></a>
                </li>

                        <li class="<?php if(isset($_SERVER['REQUEST_URI']) && ((strpos($_SERVER['REQUEST_URI'],'faq')!==false) || (strpos($_SERVER['REQUEST_URI'],'terms-conditions')!==false) || (strpos($_SERVER['REQUEST_URI'],'privacy-policy')!==false))){ echo 'active';} ?>">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">More
                                <b class="caret"></b>
                            </a>
                            <ul class="dropdown-menu">
                            	<li><a href="<?php echo show_page_link(FILE_CMS .'?page=faq');?>" title="Check our FAQ"><?php echo NAVIGATION_FAQ;?></a></li>
                                <!--	Add Testimonials aka when linked with social-media
                                <li><a href="<?php echo show_page_link(FILE_TESTIMONIAL);?>" title="People say about us"><?php echo TESTIMONIAL_HEADER;?></a></li>
                                <--	///////////	-->
                                <li><a href="<?php echo show_page_link(FILE_CMS .'?page=terms-conditions');?>" title="Our Terms of Service"><?php echo NAVIGATION_TERMS;?></a></li>
                                <li><a href="<?php echo show_page_link(FILE_CMS .'?page=privacy-policy');?>" title="Learn more about our Privacy Policy"><?php echo NAVIGATION_PRIVACY_POLICY;?></a></li>
                            </ul>
                            <b class="caret-out"></b>
                        </li>
                        <li>
                            <a href="blog">Blog</a>
                        </li>
                        <li class="<?php if(FILE_FILENAME_WITH_EXT == FILE_CONTACT){ echo 'active';}else{ echo 'test';} ?>">
                            <a href="<?php echo show_page_link(FILE_CONTACT);?>">Contact</a>
                        </li>
                          <?php // Tracking is temporarily disbaled //
                            if (isset($_SERVER['HTTP_REFERER']) && ($_SERVER['HTTP_REFERER']==SITE_URL.'zombie.php')) {?>
                              <li id="TandT"><a class="search" id="search-anchor" title="Track &amp; Trace"><span class="search-btn t_n_t"><?php echo NAVIGATION_TRACK_TRACE;?></span></a></li>
                          <?php } ?>
                    </ul>

                    <div id="search-open-tab" class="search-open">
                        <div class="input-append">
                            <form id="geocoding_form" method="post" autocomplete="off">
                            	<div class="form-group form-search">
                                <input type="tel" class="span3 form-control" placeholder="Enter Tracking Number" name="referenceId" id="referenceId"/>

                                <button type="submit" class="btn-u">Go</button>
								<!--<input type="submit" class="btn-u" value="Go"  />-->
                                	<div class="help-block alert-error" id="referenceId_message"></div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div><!-- /nav-collapse -->
            </div><!-- /navbar-inner -->
        </div><!-- /navbar -->
        <!--==	Sign-In	Users Navs	==-->
		<?php if(defined('SES_USER_ID')){ ?>

        	<div class="span12 margin-bottom-10">
            </div>
            <div class="span12 margin-left_0">
        		<ul class="nav nav-tabs nav-justified pull-right">
  					<li role="presentation" class="<?php if(FILE_FILENAME_WITH_EXT == FILE_BOOKING_RECORDS){ echo 'active';} ?>"><a href="<?php echo show_page_link(FILE_BOOKING_RECORDS);?>">Booking History</a></li>
                    <!--<li role="presentation" class="<?php if(FILE_FILENAME_WITH_EXT == FILE_QUOTE_CUSTOMER_DETAILS){ echo 'active';} ?>"><a href="<?php echo show_page_link(FILE_QUOTE_CUSTOMER_DETAILS);?>">Add Quote Customer Details </a></li>
                    <li role="presentation" class="<?php if(FILE_FILENAME_WITH_EXT == FILE_MAKE_CUSTOMER_QUOTE_DETAILS){ echo 'active';} ?>"><a href="<?php echo show_page_link(FILE_MAKE_CUSTOMER_QUOTE_DETAILS);?>">Make Customer Quote</a></li>-->
                    <li role="presentation" class="<?php if(FILE_FILENAME_WITH_EXT == FILE_ADDRESS_BOOK_LISTING || FILE_FILENAME_WITH_EXT == FILE_ADDRESS_BOOK){ echo 'active';}	?>">
                    	<?php
			 			if(isset($fromBookingSess) && $fromBookingSess == 1){
						?>
                        <a href="#">Address Book</a>
                        <?php
						}else{
			 			?>
						<a href="<?php echo show_page_link(FILE_ADDRESS_BOOK_LISTING) ;?>">Address Book</a>
						<?php
						}
						?>
                    </li>
                    <li role="presentation" class="<?php if(FILE_FILENAME_WITH_EXT == FILE_PROFILE){ echo 'active';}?>"><a href="<?php echo show_page_link(FILE_PROFILE);?>">Profile</a></li>
  				</ul>
          	</div>

     	<?php } ?>
        <!--==/End	Sign-In	Users Navs	==-->
    </div><!-- /container -->
</div><!--/header -->
<!--=== End Header ===-->
