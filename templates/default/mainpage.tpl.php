<!DOCTYPE html>
<!--[if IE 7]> <html lang="en" class="ie7"> <![endif]-->  
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->  
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->  
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]--><head>
    <?php echo $titletag; ?>

    <!-- Meta -->
    <meta charset="utf-8" />
	<meta http-equiv="Pragma" content="no-cache">
	<meta http-equiv="no-cache">
	<meta http-equiv="Expires" content="-1"> 
	<meta http-equiv="Cache-Control" content="no-cache">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="" />
    <meta name="author" content="" />
	<!-- CSS Global Compulsory -->
    <link rel="stylesheet" href="<?php echo DIR_HTTP_PLUGINS; ?>bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" href="<?php echo DIR_HTTP_CSS; ?>style.css" />
    <link rel="stylesheet" href="<?php echo DIR_HTTP_CSS; ?>headers/header.css" />
    <link rel="stylesheet" href="<?php echo DIR_HTTP_PLUGINS; ?>bootstrap/css/bootstrap-responsive.min.css" />
    <link rel="stylesheet" href="<?php echo DIR_HTTP_CSS; ?>style_responsive.css" />
	<link rel="stylesheet" href="<?php echo DIR_HTTP_CSS; ?>print.css" media="print" />
    <!--<link rel="shortcut icon" href="#" />-->
    <link rel="shortcut icon" href="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>favicon/favicon.ico" /> 
          
    <!-- Plugin Styles -->
	<?php 
	addPluginCSSFile($arr_css_plugin_include,$arr_css_plugin_exclude);
	?>
	<!-- Additional Styles -->
	<?php 
	addCSSFile($arr_css_include,$arr_css_exclude);
	?>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    
    

<!-- Framekiller -->
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

<!-- End Framekiller -->

</head>	

<body class="no-js">

<!-- Header Start -->
	<?php require_once(DIR_WS_SITE_CURRENT_TEMPLATE . FILE_HEADER );  ?>
<!-- Header End -->
<?php
$arr_get_quote_middle_content_only = array(FILE_CMS,FILE_CONTACT,FILE_FORGOT_PASSWORD,FILE_INDEX,FILE_FAQ,FILE_LATEST_NEWS,FILE_TESTIMONIAL,FILE_MY_PAYMENT_DETAILS,FILE_SERVICES);
?>
<!--=== Slider ===-->
<?php 
if(FILE_FILENAME_WITH_EXT == FILE_INDEX){ 
	require_once(DIR_WS_SITE_CURRENT_TEMPLATE . FILE_BANNER);
} 
?>
<!--=== End Slider ===-->


<!--=== Content Part ===-->
<?php require_once( DIR_WS_CONTENT . "/" . FILE_TEMPLATE_FILENAME ); ?>
<!--/container-->		
<!-- End Content Part -->

<!--=== Footer ===-->
<?php require_once( DIR_WS_SITE_CURRENT_TEMPLATE . FILE_FOOTER ); ?>
<!--=== End Footer ===-->

<!-- Java Scripts -->
<?php
addJavaScriptFile($arr_javascript_include,$arr_javascript_exclude);
?>

<script src="https://jonthornton.github.io/jquery-timepicker/jquery.timepicker.js"></script>
<link href="https://jonthornton.github.io/jquery-timepicker/jquery.timepicker.css" rel="stylesheet" />

<!-- Java Script Plugins -->
<?php
addPluginJavaScriptFile($arr_javascript_plugin_include,$arr_javascript_plugin_exclude);
?>
<!-- Java Script Below -->
<?php
addJavaScriptFileBelow($arr_javascript_below_include,$arr_javascript_below_exclude);
?>
<!-- Java Script Plugin Below -->
<?php
addPluginJavaScriptFileBelow($arr_javascript_plugin_below_include,$arr_javascript_plugin_below_exclude);
?>

<!--[if lt IE 9]>
    <script type="text/javascript" src="<?php echo DIR_HTTP_JSCRIPT; ?>respond.js"></script>
<![endif]-->
<div class="modal hide fade small_rates" id="sessionConfirm" data-backdrop="static" data-keyboard="false">
<div class="modal-header">
<h3><?php echo "Warning!"; ?></h3>
</div>
<div class="modal-body">
<span class="my_bigger_font justy"><?php 
if(FILE_FILENAME_WITH_EXT == FILE_EWAY_PAYMENT)
{ echo BOOING_SUCCESS_SESSION;}else{
echo SESSION_EXPIRY_MESSAGE;} ?></span>
</div>
<div class="modal-footer"><a href="#" id="session_cls" class="btn-u btn-u-primary" >Close</a>	</div>
</div>
<!-- If JS is disabled or NoScript etc enabled -->
<?php echo NO_JAVASCRIPT_ENABLED; ?>
<!-- /End NoScript message	-->
</body>
</html>	