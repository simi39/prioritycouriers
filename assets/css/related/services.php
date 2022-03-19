<style scoped="scoped" type="text/css">
ul#services-tabs-dynamic {
	margin:0px 2px 0px 0px;
	padding:0px;
}
ul#services-tabs-dynamic li{
	float:left;
	list-style:none;
}
ul#services-tabs-dynamic li a{
	padding:5px 20px;
	margin:2px;
	color:#FFF;
	font-weight:bold;
	font-size:14px;
}
<?php
if(count($servicesData) > 5){
	?>
	ul#services-tabs-dynamic li{
	line-height:30px;
	margin-bottom: 3px;
    margin-top: -4px;
	}
	<?php
}
foreach ($servicesData as $service_details){
	$btName = strtolower($service_details['service_name']);
	$colorCode= $service_details['box_color'];
	?>
	ul#services-tabs-dynamic li.btn-<?php echo valid_output($btName);?> a{
		background:<?php echo valid_output($colorCode); ?>;
	}
	.service-box-dynamic-<?php echo valid_output($btName);?> {
		border:1px solid <?php echo valid_output($colorCode); ?>;
		border-left-width:10px;
		padding:0px 5px;
		margin-bottom:5px;
		clear:both;
	}
	.service-box-dynamic-<?php echo valid_output($btName);?> h2{
		color:<?php echo valid_output($colorCode); ?>;	
	}
	
<?php
}//foreach loop closes here
?>	
</style>