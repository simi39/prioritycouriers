<?php
$servername = "localhost";
$username = "qantasgr_pl1";
$password = "'2ZAtk][q1Y7YzY#";
$dbname = "qantasgr_pl";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
$exp = time() - (15 * 60);
$expiry_time_taken = 15;
$sql = "delete from token_table_name where stamp < '$exp' and expiry_token_time = '$expiry_time_taken'";
$result = mysqli_query($conn, $sql);

$oldexp = time() - (24 * 60 * 60);
$expiry_24_time_taken = 24;
$sql_2 = "delete from token_table_name where stamp < '$oldexp' and expiry_token_time = '$expiry_24_time_taken'";
$result_2 = mysqli_query($conn, $sql_2);


$sql_3= "DELETE FROM `login_attempts` WHERE lastlogin <= DATE_SUB(NOW(), INTERVAL 30 MINUTE)";
$result_3 = mysqli_query($conn, $sql_3);


$sql_4= "DELETE FROM `forgotpass_email_attempts` WHERE lastlogin <= DATE_SUB(NOW(), INTERVAL 30 MINUTE)";
$result_4 = mysqli_query($conn, $sql_4);


$sql_5= "DELETE FROM `forgotpass_ipaddress_attempts` WHERE lastlogin <= DATE_SUB(NOW(), INTERVAL 30 MINUTE)";
$result_5 = mysqli_query($conn, $sql_5);

mysqli_close($conn);
?>
