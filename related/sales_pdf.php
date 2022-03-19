<?php
require_once("../lib/common.php");
require_once(DIR_WS_MODEL ."BookingDetailsMaster.php");
require_once(DIR_WS_MODEL ."BookingItemDetailsMaster.php");

header('Content-type: application/pdf');
header('Content-Disposition: attachment; filename="sales_report.pdf"');
readfile(DIR_WS_ONLINEPDF."tmp_pdf/sales_report.pdf");
?>