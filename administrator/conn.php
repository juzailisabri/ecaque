<?php

if ($_SERVER["HTTP_HOST"] == "localhost" || $_SERVER["HTTP_HOST"] == "developer.dyndns.org") {
  $servername = "localhost";
  $username = "root";
  $password = "";
  $database = "ecaque";
  $rootdir = "/ecaque";
  $http = "http";
  $callback = "$http://".$_SERVER["HTTP_HOST"]."$rootdir/paycallback";
  $returnUrl = "$http://".$_SERVER["HTTP_HOST"]."$rootdir/payreturn";
  $baseurl = "$http://developer.dyndns.org/ecaque";
} else {
  $servername = "localhost";
  $username = "ecaquemy";
  $password = "C9:hMJmj!34k6P";
  $database = "ecaquemy_ecaque";
  $rootdir = "";
  $http = "https";
  $callback = "$http://".$_SERVER["HTTP_HOST"]."$rootdir/paycallback";
  $returnUrl = "$http://".$_SERVER["HTTP_HOST"]."$rootdir/payreturn";
  $baseurl = "$http://ecaque.my";
}

$toyyiburl = "https://toyyibpay.com/";
// Create connection
$conn = new mysqli($servername, $username, $password, $database);
$conn->query("SET lc_time_names = 'ms_MY'");
mysqli_set_charset($conn,"utf8");
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
  $status["DB"] = false;
} else {
  $status["DB"] = true;
}

$emailacc = "no-reply";
$emailaccpass = "a}TdE@f2Uku%";
$emailhost = "ecaque.my";

$secretKey = "my3c4qu3";
// PASSWORD CONFIGURATION
$cfg_salt = hash('sha256', $secretKey);

// FORM CONFIGURATION
$cfg_enable_form_status = array('1001','102','1002','1004','1005','1006','1007');
$cfg_pre_cancel_status = array('1001','1002','1004','1006');
$cfg_pre_tangguh_status = array('1005');
$cfg_pre_penolakan_status = array('1005','102');
$cfg_pre_terima_status = array('1005');
$cfg_pre_keluar_status = array('103');
$cfg_qm_inbox = array('1001');
$cfg_qm_outbox = array('1002','1003');


?>
