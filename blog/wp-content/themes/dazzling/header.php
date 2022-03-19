<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package dazzling
 */
 session_start();
 //echo DIR_WS_LIB;
 require_once("../lib/common.php");
 
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<!-- favicon -->
<?php if ( of_get_option( 'custom_favicon' ) ) { ?>
<link rel="icon" href="<?php echo of_get_option( 'custom_favicon' ); ?>" />
<?php } ?>

<!--[if IE]><?php if ( of_get_option( 'custom_favicon' ) ) { ?><link rel="shortcut icon" href="<?php echo of_get_option( 'custom_favicon' ); ?>" /><?php } ?><![endif]-->

<?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>
<div id="page" class="hfeed site">
	<!--==	Header Wrapper	==-->
	<div id="head-wrap">
		<!--=== Top ===-->    
        <div class="top">
            <div class="container">
                <ul class="loginbar pull-right">
                        <li><a href="mailto:<?php echo DEFAULT_INFO_EMAIL; ?>"><i class="icon-envelope-alt"></i> <?php echo DEFAULT_INFO_EMAIL; ?></a></li> 
                        <li class="devider">&nbsp;</li>
                        <li><a><i class="icon-phone-sign"></i> <?php echo DEFAULT_PHONE; ?></a></li>
                        <li class="devider">&nbsp;</li>
                        <?php if(defined('SES_USER_ID')){ ?>
                        <li><?php echo USER_WELCOME_NOTE . "&nbsp;<strong class='my_green'>&nbsp;" . ucfirst(SES_USER_FIRSTNAME) . " </strong>" ;//. ucfirst(SES_USER_LASTNAME) . ""; ?></li>
                        <li class="devider">&nbsp;</li>
                        <li><a href="<?php echo SITE_INDEX; ?>"  class="login-btn"><?php echo HEADING_USER_LOGOUT; ?></a></li>
                        <?php }else{ ?>
                        <li><a href="<?php echo show_page_link(FILE_LOGIN); ?>" class="login-btn">Login/Registration</a></li>
                        <?php } ?>
                </ul>
            </div>      
        </div><!--/top-->
		<!--=== End Top ===-->

		<!--=== Header ===-->
        <div class="header">               
            <div class="container"> 
                <!-- Logo -->       
                <div class="logo">                                             
                    <a href="<?php echo SITE_INDEX;?>"><img id="logo-header" src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>Logo/Priority_Couriers-Logo_header.png" alt="Priority Couriers - Logo" /></a>
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
                                <li>
                                    <a href="<?php echo SITE_INDEX;?>">Home</a>                      
                                </li>
                                <li class="<?php if(FILE_FILENAME_WITH_EXT == FILE_BOOKING){ echo 'active';} ?>">
                                    <a href="<?php echo show_page_link(FILE_BOOKING);?>"><?php echo NAVIGATION_BOOKING;?></a>                      
                                </li>
                                <li class="<?php if(FILE_FILENAME_WITH_EXT == FILE_CMS){ echo 'active';} ?>">
                                    <a href="<?php echo show_page_link(FILE_CMS .'?page=services');?>"><?php echo NAVIGATION_SERVICES;?></a>                      
                                </li>
                                <li>
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">More
                                        <b class="caret"></b>                            
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><a href="<?php echo show_page_link(FILE_CMS .'?page=faq');?>" title="Check our FAQ"><?php echo NAVIGATION_FAQ;?></a></li>
                                        <li><a href="<?php echo show_page_link(FILE_TESTIMONIAL);?>" title="People say about us"><?php echo TESTIMONIAL_HEADER;?></a></li>
                                        <li><a href="<?php echo show_page_link(FILE_CMS .'?page=terms-conditions');?>" title="Our Terms of Service"><?php echo NAVIGATION_TERMS;?></a></li>
                                        <li><a href="<?php echo show_page_link(FILE_CMS .'?page=privacy-policy');?>" title="Learn more about our Privacy Policy"><?php echo NAVIGATION_PRIVACY_POLICY;?></a></li>
                                    </ul>
                                    <b class="caret-out"></b>                        
                                </li>
                                <li class="<?php if(FILE_FILENAME_WITH_EXT == FILE_INDEX){ echo 'active';} ?>">
                                    <a href="../blog">Blog</a>                      
                                </li>
                                <li class="<?php if(FILE_FILENAME_WITH_EXT == FILE_CONTACT){ echo 'active';}else{ echo 'test';} ?>">
                                    <a href="<?php echo show_page_link(FILE_CONTACT);?>">Contact</a>                      
                                </li>
                                <li id="TandT"><a class="search" id="search-anchor" title="Track &amp; Trace"><span class="search-btn t_n_t"><?php echo NAVIGATION_TRACK_TRACE;?></span></a></a></li>                               
                            </ul>
                            
                            <div id="search-open-tab" class="search-open">
                                <div class="input-append">
                                    <form id="geocoding_form" method="post" autocomplete="off"/>
                                        <div class="form-group form-search">
                                        <input type="text" class="span3 form-control" placeholder="Search" name="referenceId" id="referenceId"/>
                                        
                                        <!--<button type="submit" class="btn-u">Go</button>-->
                                        <input type="submit" class="btn-u" value="Go" />
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
	</div><!--==/End Header Wrapper	==-->      
<!--=== End Header ===-->
