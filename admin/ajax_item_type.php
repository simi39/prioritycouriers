<?php
require_once("../lib/common.php");
require_once(DIR_WS_ADMIN_LANGUAGES . DIR_CURRENT_LANGUAGE. '/servicepage.php');

$service_page_type = $_POST['service_page_type'];
$admin = 1;
if(isset($service_page_type) && $service_page_type!="international"){
	echo getItemType($item,'2',$extra_para,null,$service_page_type,$admin); 
}else{
	echo getItemType($item,'2', $extra_para,null,'inter',$admin);
}
?>