<?php
$FArray = array(
	FILE_WELCOME_ADMIN => '-1',
	FILE_USERS => '1',
	FILE_USERS_ADD_EDIT => '1',
	FILE_POSTCODE_LISTING => '2',
	FILE_PIOSTCODE_ACTION => '2',
	FILE_SITE_CONSTANT_LISTING => '3',
	FILE_SITE_CONSTANT_ACTION => '3',
	FILE_KM_GRID_LISTING => '4',
	FILE_KM_GRID_ACTION => '4',
	FILE_DAY_LISTING => '5',
	FILE_DAY_ACTION => '5',
	FILE_ITEM_TYPE_LISTING => '6',
	FILE_ITEM_TYPE_ACTION => '6',
	FILE_COUNTRY_LISTING => '7',
	FILE_COUNTRY_ACTION => '7',
	FILE_CLIENT_ADDRESS_BOOK_LISTING => '8',
	FILE_CLIENT_ADDRESS_BOOK_ACTION => '8',
	FILE_BOOKING_DETAILS_LISTING => '9',
	FILE_BOOKING_DISCOUNT_LISTING => '10',
	FILE_BOOKING_ITEM_DETAILS_LISTING => '11',
	FILE_BOOKING_ITEM_DETAILS_ACTION => '11',
	FILE_BOOKING_CANCEL_LISTING => '12',
	FILE_ADMIN_FAQ_CATEGORY => '13',
	FILE_ADMIN_ADD_EDIT_FAQ_CATEGORY => '13',
	FILE_ADMIN_FAQ => '13',
	FILE_ADMIN_ADD_EDIT_FAQ => '13',
	FILE_ADMIN_NEWS_CATEGORY => '14',
	FILE_ADMIN_NEWS => '14',
	FILE_ADMIN_ADD_EDIT_NEWS_CATEGORY => '14',
	FILE_ADMIN_ADD_EDIT_NEWS => '14',
	FILE_QUOTE_CUSTOMER_DETAILS_ITEMS_LISTING => '15',
	FILE_QUOTE_CUSTOMER_DETAILS_ITEMS_ACTION => '15',
	FILE_ADDITIONAL_DETAILS_ITEMS_LISTING => '16',
	/*FILE_TRACKING_EVANT_LISTING => '17',
	FILE_TRACKING_EVANT_ACTION => '17',*/


	/*FILE_COMMERCIAL_INVOICE_LISTING => '10',
	FILE_COMMERCIAL_INVOICE_ACTION => '10',
	FILE_COMMERCIAL_INVOICE_ITEM_DETAILS_LISTING => '11',
	FILE_COMMERCIAL_INVOICE_ITEM_DETAILS_ACTION => '11',*/


	FILE_ADMIN_TESTIMONIAL_ADDEDIT => '17',
	FILE_ADMIN_TESTIMONIAL => '17',
	FILE_ADMIN_FORMS_AND_CALCULATOR => '17',
	FILE_ADMIN_FORMS_AND_CALCULATOR_LISTING => '17',
	FILE_HOLIDAY_ACTION => '17',
	FILE_HOLIDAY_LISTING => '17',
	FILE_ADMIN_HELP_MANAGER => '17',
	FILE_ADMIN_EMAIL_TEMPLATE_MANAGER => '17',
	FILE_ADMIN_ADDEDIT_EMAIL_TEMPLATE => '17',
	FILE_ADMIN_EDIT_EMAIL_TPL_STRUCTURE => '17',
	FILE_ADMIN_BANNER => '17',
	FILE_ADMIN_CMS => '17',
	FILE_ADMIN_ADD_EDIT_CMS => '17',
	FILE_CMS => '17',
	FILE_ADMIN_SEO => '17',
	FILE_ADMIN_SEO_ADDEDIT => '17',
	FILE_ADMIN_SITEMAP_YAHOO => '17',
	FILE_ADMIN_SITEMAP_GOOGLE => '17',
	FILE_ADMIN_ORDERS => '0',
	FILE_ADMIN_COUPONS => '17',
);

?>
<script type="text/javascript">
ddaccordion.init(     {
	headerclass: "headerbar", //Shared CSS class name of headers group
	contentclass: "submenu", //Shared CSS class name of contents group
	revealtype: "click", //Reveal content when user clicks or onmouseover the header? Valid value: "click", "clickgo", or "mouseover"
	mouseoverdelay: 200, //if revealtype="mouseover", set delay in milliseconds before header expands onMouseover
	collapseprev: true, //Collapse previous content (so only one open at any time)? true/false
	defaultexpanded: [0], //index of content(s) open by default [index1, index2, etc] [] denotes no content
	onemustopen: false, //Specify whether at least one header should be open always (so never all headers closed)
	animatedefault: false, //Should contents open by default be animated into view?
	persiststate: true, //persist state of opened contents within browser session?
	toggleclass: ["", "selected"], //Two CSS classes to be applied to the header when it's collapsed and expanded, respectively ["class1", "class2"]
	togglehtml: ["", "", ""], //Additional HTML added to the header when it's collapsed and expanded, respectively  ["position", "html1", "html2"] (see docs)
	animatespeed: "normal", //speed of animation: integer in milliseconds (ie: 200), or keywords "fast", "normal", or "slow"
	oninit:function(headers, expandedindices){ //custom code to run when headers have initalized

	<?php if($FArray[$FileNameWithExt] != '-1' && $FArray[$FileNameWithExt] != '') { ?>
		ddaccordion.expandone('headerbar', <?php echo $FArray[$FileNameWithExt]; ?>);
	<?php } elseif($FArray[$FileNameWithExt] == -1) { ?>
		ddaccordion.collapseall('headerbar');
	<?php } ?>

	},
	onopenclose:function(header, index, state, isuseractivated){ //custom code to run whenever a header is opened or closed
		//do nothing

	}
});
</script>
<div class="urbangreymenu">

	<div class="admin_management">
		<h3 class="headerbar"><?php echo ADMIN_HEADER_ADMIN_MANAGEMENT;?></h3>
	</div>
	<ul class="submenu">
		<li><a href="<?php echo FILE_ADMIN_ADMINISTRATOR;?>" <?php if((FILE_FILENAME_WITH_EXT == FILE_ADMIN_ADMINISTRATOR)||(FILE_FILENAME_WITH_EXT == FILE_ADMIN_ADD_ADMINISTRATOR)){?>class="active"<?php } ?>><?php echo ADMIN_HEADER_ADMIN_MANAGEMENT;?></a></li>
</ul>
<div class="user_management">
		<h3 class="headerbar"><?php echo ADMIN_HEADER_USERS_MANAGEMENT;?></h3>
	</div>
	<ul class="submenu">
		<li><a href="<?php echo FILE_USERS;?>" <?php if(FILE_FILENAME_WITH_EXT == FILE_USERS || FILE_FILENAME_WITH_EXT == FILE_USERS_ADD_EDIT){?>class="active"<?php } ?>><?php echo ADMIN_HEADER_USERS;?></a></li>
		<li><a href="<?php echo FILE_USERTRASH;?>" <?php if(FILE_FILENAME_WITH_EXT == FILE_USERTRASH){?>class="active"<?php } ?>><?php echo ADMIN_HEADER_USERS_TRASHBOX;?></a></li>
	</ul>



<div class="postcode_management">
		<h3 class="headerbar"><?php echo ADMIN_POSTCODE_MANAGEMENT;?></h3>
	</div>
	<ul class="submenu">
		<li><a href="<?php echo FILE_POSTCODE_LISTING;?>" <?php if(FILE_FILENAME_WITH_EXT == FILE_POSTCODE_LISTING || FILE_FILENAME_WITH_EXT == FILE_PIOSTCODE_ACTION){?>class="active"<?php }?>>
		<?php echo ADMIN_POSTCODE_MANAGEMENT;?></a></li>
	</ul>


 <div class="site_management">
                <h3 class="headerbar"><?php echo FILE_SITE_CONSTANT;?></h3>
        </div>
        <ul class="submenu">
                <li><a href="<?php echo FILE_SITE_CONSTANT_LISTING;?>" <?php if(FILE_FILENAME_WITH_EXT == FILE_SITE_CONSTANT_LISTING || FILE_FILENAME_WITH_EXT == FILE_SITE_CONSTANT_ACTION){?>class="active"<?php }?>>
                <?php echo FILE_SITE_CONSTANT;?></a></li>

        </ul>


<div class="kmgrid_management">
		<h3 class="headerbar"><?php echo FILE_KM_GRID_MANAGEMENT;?></h3>
	</div>
	<ul class="submenu">
		<li><a href="<?php echo FILE_KM_GRID_LISTING;?>" <?php if(FILE_FILENAME_WITH_EXT == FILE_KM_GRID_LISTING || FILE_FILENAME_WITH_EXT == FILE_KM_GRID_ACTION){?>class="active"<?php }?>>
		<?php echo FILE_KM_GRID_MANAGEMENT;?></a></li>

	</ul>



<div class="day_management">
		<h3 class="headerbar"><?php echo FILE_DAY_MANAGEMENT;?></h3>
	</div>
	<ul class="submenu">
		<li><a href="<?php echo FILE_DAY_LISTING;?>" <?php if(FILE_FILENAME_WITH_EXT == FILE_DAY_LISTING || FILE_FILENAME_WITH_EXT == FILE_DAY_ACTION){?>class="active"<?php }?>>
		<?php echo FILE_DAY_MANAGEMENT;?></a></li>

	</ul>

<div class="item_type_management">
		<h3 class="headerbar"><?php echo FILE_ITEM_TYPE_MANAGEMENT;?></h3>
	</div>
	<ul class="submenu">
		<li><a href="<?php echo FILE_ITEM_TYPE_LISTING;?>" <?php if(FILE_FILENAME_WITH_EXT == FILE_ITEM_TYPE_LISTING || FILE_FILENAME_WITH_EXT == FILE_ITEM_TYPE_ACTION){?>class="active"<?php }?>><?php echo FILE_ITEM_TYPE_MANAGEMENT;?></a></li>
	</ul>

<div class="country_management">
		<h3 class="headerbar"><?php echo FILE_COUNTRY_MANAGEMENT;?></h3>
	</div>
	<ul class="submenu">
		<li><a href="<?php echo FILE_COUNTRY_LISTING;?>" <?php if(FILE_FILENAME_WITH_EXT == FILE_COUNTRY_LISTING || FILE_FILENAME_WITH_EXT == FILE_COUNTRY_ACTION){?>class="active"<?php }?>>
		<?php echo FILE_COUNTRY_MANAGEMENT;?></a></li>

	</ul>


	<!--<div class="commercial_invoice_management">
		<h3 class="headerbar"><?php echo FILE_COMMERCIAL_INVOICE_MANAGEMENT;?></h3>
	</div>
	<ul class="submenu">
		<li><a href="<?php echo FILE_COMMERCIAL_INVOICE_LISTING;?>" <?php if(FILE_FILENAME_WITH_EXT == FILE_COMMERCIAL_INVOICE_LISTING || FILE_FILENAME_WITH_EXT == FILE_COMMERCIAL_INVOICE_ACTION){ ?>class="active"<?php } ?>>
		<?php echo FILE_COMMERCIAL_INVOICE_MANAGEMENT;?></a></li></ul>



<div class="commercial_invoice_item_management">
		<h3 class="headerbar"><?php echo FILE_COMMERCIAL_INVOICE_ITEM_DETAILS_MANAGEMENT;?></h3>
	</div>
	<ul class="submenu">
		<li><a href="<?php echo FILE_COMMERCIAL_INVOICE_ITEM_DETAILS_LISTING;?>" <?php if(FILE_FILENAME_WITH_EXT == FILE_COMMERCIAL_INVOICE_ITEM_DETAILS_LISTING || FILE_FILENAME_WITH_EXT == FILE_COMMERCIAL_INVOICE_ITEM_DETAILS_ACTION){?>class="active"<?php }?>>
		<?php echo FILE_COMMERCIAL_INVOICE_ITEM_DETAILS_MANAGEMENT;?></a></li>

	</ul>-->

<div class="client_addrtess_book_management">
		<h3 class="headerbar"><?php echo FILE_CLIENT_ADDRESS_BOOK_MANAGEMENT;?></h3>
	</div>
	<ul class="submenu">
		<li><a href="<?php echo FILE_CLIENT_ADDRESS_BOOK_LISTING;?>" <?php if(FILE_FILENAME_WITH_EXT == FILE_CLIENT_ADDRESS_BOOK_LISTING || FILE_FILENAME_WITH_EXT == FILE_CLIENT_ADDRESS_BOOK_ACTION){?>class="active"<?php }?>>
		<?php echo FILE_CLIENT_ADDRESS_BOOK_MANAGEMENT;?></a></li>

	</ul>

<div class="booking_details_management">
		<h3 class="headerbar"><?php echo FILE_BOOKING_DETAILS_MANAGEMENT;?></h3>
	</div>
	<ul class="submenu">
		<li><a href="<?php echo FILE_BOOKING_DETAILS_LISTING;?>"  <?php if(FILE_FILENAME_WITH_EXT == FILE_BOOKING_DETAILS_LISTING || FILE_FILENAME_WITH_EXT == FILE_BOOKING_DETAILS_ACTION){?>class="active"<?php }?>>
		<?php echo FILE_BOOKING_DETAILS_MANAGEMENT;?></a></li>

	</ul>
<!--	this menu added by shailesh on date  28-05-2013-->
<div class="booking_details_management">
		<h3 class="headerbar"><?php echo FILE_BOOKING_DISCOUNT_MANAGEMENT;?></h3>
	</div>
	<ul class="submenu">
		<li><a href="<?php echo FILE_BOOKING_DISCOUNT_LISTING;?>"  <?php if(FILE_FILENAME_WITH_EXT == FILE_BOOKING_DISCOUNT_LISTING || FILE_FILENAME_WITH_EXT == FILE_BOOKING_DISCOUNT_ACTION){?>class="active"<?php }?>>
		<?php echo FILE_BOOKING_DISCOUNT_MANAGEMENT;?></a></li>

	</ul>
<div class="booking_item_details_management">
		<h3 class="headerbar"><?php echo FILE_BOOKING_ITEM_DETAILS_MANAGEMENT;?></h3>
	</div>
	<ul class="submenu">
		<li><a href="<?php echo FILE_BOOKING_ITEM_DETAILS_LISTING;?>"<?php if(FILE_FILENAME_WITH_EXT == FILE_BOOKING_ITEM_DETAILS_LISTING || FILE_FILENAME_WITH_EXT == FILE_BOOKING_ITEM_DETAILS_ACTION){?>class="active"<?php }?>>
		<?php echo FILE_BOOKING_ITEM_DETAILS_MANAGEMENT;?></a></li>

	</ul>
<div class="booking_cancel_management">
		<h3 class="headerbar"><?php echo FILE_BOOKING_CANCEL_MANAGEMENT;?></h3>
	</div>
	<ul class="submenu">
		<li><a href="<?php echo FILE_BOOKING_CANCEL_LISTING;?>"<?php if(FILE_FILENAME_WITH_EXT == FILE_BOOKING_CANCEL_LISTING || FILE_FILENAME_WITH_EXT == FILE_BOOKING_CANCEL_ACTION){?>class="active"<?php }?>>
		<?php echo FILE_BOOKING_CANCEL_MANAGEMENT;?></a></li>

	</ul>


<div class="report_management">
		<h3 class="headerbar"><?php echo ADMIN_HEADER_FAQ_MANAGEMENT;?></h3>
	</div>
	<ul class="submenu">
		<li><a href="<?php echo FILE_ADMIN_FAQ_CATEGORY; ?>" <?php if(FILE_FILENAME_WITH_EXT == FILE_ADMIN_FAQ_CATEGORY){?>class="active"<?php }?>><?php echo ADMIN_HEADER_FAQ_CATEGORY; ?></a></li>
		<li><a href="<?php echo FILE_ADMIN_FAQ; ?>" <?php if(FILE_FILENAME_WITH_EXT == FILE_ADMIN_FAQ){?>class="active"<?php }?>><?php echo ADMIN_HEADER_FAQ; ?></a></li>
	</ul>
<div class="news_management">
		<h3 class="headerbar"><?php echo ADMIN_HEADER_NEWS_MANAGEMENT;?></h3>
	</div>
	<ul class="submenu">
		<li><a href="<?php echo FILE_ADMIN_NEWS_CATEGORY; ?>" <?php if(FILE_FILENAME_WITH_EXT == FILE_ADMIN_NEWS_CATEGORY){?>class="active"<?php }?>><?php echo ADMIN_HEADER_NEWS_CATEGORY; ?></a></li>
		<li><a href="<?php echo FILE_ADMIN_NEWS; ?>" <?php if(FILE_FILENAME_WITH_EXT == FILE_ADMIN_NEWS){?>class="active"<?php }?>><?php echo ADMIN_HEADER_NEWS; ?></a></li>
	</ul>
<div class="client_addrtess_book_management">
		<h3 class="headerbar"><?php echo ADMIN_HEADER_QUOTE_CUSTOMER_DETAILS_MANAGEMENT;?></h3>
	</div>
	<ul class="submenu">
		<li><a href="<?php echo FILE_QUOTE_CUSTOMER_DETAILS_ITEMS_LISTING; ?>" <?php if(FILE_FILENAME_WITH_EXT == FILE_QUOTE_CUSTOMER_DETAILS_ITEMS_LISTING){?>class="active"<?php }?>><?php echo ADMIN_HEADER_QUOTE_CUSTOMER_DETAILS_MANAGEMENT; ?></a></li>
	</ul>
	<div class="miscellaneous_management">
		<h3 class="headerbar"><?php echo ADMIN_HEADER_MISCELLANEOUS;?></h3>
	</div>

	<ul class="submenu">
	<li><a href="<?php echo FILE_ADDITIONAL_DETAILS_ITEMS_LISTING;?>" <?php if((FILE_FILENAME_WITH_EXT == FILE_ADDITIONAL_DETAILS_ITEMS_LISTING)){?>class="active"<?php }?>><?php echo ADMIN_HEADER_ADDITIONAL_DETAIL_ITEMS_MANAGEMENT;?></a></li>
	<li><a href="<?php echo FILE_ADMIN_FORMS_AND_CALCULATOR_LISTING;?>" <?php if((FILE_FILENAME_WITH_EXT == FILE_ADMIN_FORMS_AND_CALCULATOR_LISTING)){?>class="active"<?php }?>><?php echo ADMIN_HEADER_FORMS_AND_CALCULATOR_MANAGEMENT;?></a></li>
	<li><a href="<?php echo FILE_ADMIN_HELP_MANAGER;?>" <?php if((FILE_FILENAME_WITH_EXT == FILE_ADMIN_HELP_MANAGER)){?>class="active"<?php }?>><?php echo ADMIN_HEADER_HELP_MANAGEMENT;?></a></li>
	<li><a href="<?php echo FILE_ADMIN_TESTIMONIAL;?>" <?php if((FILE_FILENAME_WITH_EXT == FILE_ADMIN_TESTIMONIAL)||(FILE_FILENAME_WITH_EXT == FILE_ADMIN_TESTIMONIAL_ADDEDIT)){?>class="active"<?php }?>><?php echo ADMIN_HEADER_TESTIMONIAL_MANAGEMENT;?></a></li>
	<li><a href="<?php echo FILE_ADMIN_EMAIL_TEMPLATE_MANAGER;?>" <?php if((FILE_FILENAME_WITH_EXT == FILE_ADMIN_EMAIL_TEMPLATE_MANAGER)||(FILE_FILENAME_WITH_EXT == FILE_ADMIN_EDIT_EMAIL_TPL_STRUCTURE)){?>class="active"<?php }?>><?php echo ADMIN_HEADER_EMAIL_TEMPLATE;?></a></li>
		<li><a href="<?php echo FILE_ADMIN_BANNER?>" <?php if((FILE_FILENAME_WITH_EXT == FILE_ADMIN_BANNER)||(FILE_FILENAME_WITH_EXT == FILE_ADMIN_BANNER)){?>class="active"<?php }?>><?php echo ADMIN_HEADER_BANNER_MANAGEMENT;?></a></li>
		<li><a href="<?php echo FILE_HOLIDAY_LISTING;?>" <?php if((FILE_FILENAME_WITH_EXT == FILE_HOLIDAY_LISTING)||(FILE_FILENAME_WITH_EXT == FILE_HOLIDAY_ACTION)){?>class="active"<?php }?>><?php echo ADMIN_HEADER_HOLIDAY_MANAGEMENT;?></a></li>
<!--holiday-->

		<li><a href="<?php echo FILE_ADMIN_CMS; ?>" <?php if((FILE_FILENAME_WITH_EXT == FILE_ADMIN_CMS)||(FILE_FILENAME_WITH_EXT == FILE_ADMIN_ADD_EDIT_CMS)){?>class="active"<?php }?>><?php echo ADMIN_HEADER_CONTENT_MANAGEMENT; ?></a></li>
		<?php if(SEO_ENABLE == true) { ?>
		<li><a href="<?php echo FILE_ADMIN_SEO; ?>" <?php if((FILE_FILENAME_WITH_EXT == FILE_ADMIN_SEO)||(FILE_FILENAME_WITH_EXT == FILE_ADMIN_SEO_ADDEDIT)){?>class="active"<?php }?>><?php echo ADMIN_HEADER_SEO_MANAGEMENT; ?></a></li>
		<?php } ?>
		<!--<li><a href="<?php echo FILE_ADMIN_COUPON; ?>" <?php if((FILE_FILENAME_WITH_EXT == FILE_ADMIN_COUPON)||(FILE_FILENAME_WITH_EXT == FILE_ADMIN_COUPON_ADDEDIT)){?>class="active"<?php }?>><?php echo ADMIN_COUPON_LEFTMENU_HEADING; ?></a></li>-->
		<li><a href="<?php echo FILE_STE?>"><?php echo ADMIN_HEADER_CALCULATION_MANAGEMENT;?></a></li>
		<li><a href="<?php echo FILE_STE_SERVICE?>"><?php echo ADMIN_HEADER_SERVICE_MANAGEMENT;?></a></li>
		<li><a href="<?php echo FILE_SERVICE_PAGE?>"><?php echo ADMIN_HEADER_SERVICE_PAGE_MANAGEMENT;?></a></li>
		<li><a href="<?php echo FILE_ADMIN_COUPON?>"><?php echo ADMIN_HEADER_COUPON_MANAGEMENT;?></a></li>
		<li><a href="<?php echo FILE_TABLE; ?>"><?php echo ADMIN_HEADER_TABEL_MANAGEMENT;?></a></li>
		<li><a href="<?php echo FILE_TRANSIT_LIST; ?>"><?php echo ADMIN_HEADER_TRANSIT_MANAGEMENT;?></a></li>
		<li><a href="<?php echo FILE_SUPPLIER_MANAGMENT?>"><?php echo ADMIN_HEADER_SUPLIER_MANAGEMENT;?></a></li>
		<li><a href="<?php echo FILE_CODE_MANAGMENT;?>"><?php echo ADMIN_HEADER_CODE_FORMAT_MANAGEMENT;?></a></li>
		<li><a href="<?php echo FILE_PRODUCT_LABEL_MANAGMENT?>"><?php echo ADMIN_HEADER_PRODUCT_LABEL_MANAGEMENT;?></a></li>
		<li><a href="<?php echo FILE_SERVICE_REPORTS?>"><?php echo ADMIN_SERVICE_REPORT_MANAGEMENT;?></a></li>
		<li><a href="<?php echo FILE_ADMIN_REPORT_SALES?>"><?php echo ADMIN_HEADER_SALES_REPORT;?></a></li>
		<li><a href="<?php echo FILE_WELCOME_ADMIN?>?Action=Logout"><?php echo ADMIN_HEADER_LOGOUT;?></a></li>
	</ul>
</div>
