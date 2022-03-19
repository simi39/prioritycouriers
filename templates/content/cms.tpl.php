<?php 
$arr_javascript_plugin_include[] = 'back-to-top.js';
$arr_javascript_below_include[] = 'internal/cms.php';

if(isset($servicesData) && !empty($servicesData)){
	require_once( DIR_WS_CSS . "related/services.php");
}
?>
<!--=== Breadcrumbs ===-->
<div class="breadcrumbs margin-bottom-40">
	<div class="container">
        <h1 class="color-green pull-left"><?php  echo valid_output($cmsData['page_heading']); ?></h1>
        <ul class="pull-right breadcrumb">
            <li><a href="<?php echo SITE_INDEX;?>">Home</a> <span class="divider">/</span></li>
            <li class="active"><?php  echo valid_output($cmsData['page_heading']); ?></li>
        </ul>
    </div><!--/container-->
</div><!--/breadcrumbs-->
<!--=== End Breadcrumbs ===-->
<!--=== Content Part ===-->
<div class="container">	
              			<?php  echo ($cmsData['page_content']); ?>
              			<?php 
							if(file_exists(DIR_WS_CONTENT.$CmsPageName.".tpl.php")) {
								require_once(DIR_WS_CONTENT.$CmsPageName.".tpl.php");								
							}
							
						?>	
</div>