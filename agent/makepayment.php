<?php
session_start();
include("../pay.php");
include("../administrator/conn.php");

if (isset($_GET["erid"]) && $_GET["erid"] != "") {

} else {
  header("location: index");
}

$erid = $_GET["erid"];
$uid = $_SESSION["AGENT"]["ID"];
$s = "SELECT es_name, es_email, es_phone FROM e_stockist WHERE es_id = '$uid'";

$res = $conn->query($s);
$row = $res->fetch_assoc();

$es_name = $row["es_name"];
$es_email = $row["es_email"];
$es_phone = $row["es_phone"];

$s2 = "SELECT er_id,
MD5(CONCAT('$secretKey',er_id)) as refNo,
DATE_FORMAT(er_date,'%Y') as invyear,
DATE_FORMAT(er_date,'%m') as invmonth,
(er_postage + er_totalprice) as totalpay,
er_paymentStatus
FROM e_receipt WHERE SHA2(er_id,256) = '$erid'";

$res2 = $conn->query($s2);
$row2 = $res2->fetch_assoc();

if ($row2["er_paymentStatus"] != "1") {
  $u = "UPDATE e_receipt SET er_paymentStatus = NULL WHERE SHA2(er_id,256) = '$erid' AND er_paymentStatus IN('3','2')";
  $conn->query($u);

  $invcode = $row2["refNo"];
  $totalpay = $row2["totalpay"];
  // $totalpay = 2;
  $totalpay = $totalpay * 100; // CONVER FROM RINGGIT TO CENT

  $url = makePayment("eCaque Kek Kukus","eCaque Kek Kukus",$invcode,$es_name,$es_email,$es_phone,$totalpay);
  header("location: $url");
  exit;
}

// $er_id = sprintf("%08d", $row2["er_id"]);
// $invyear = $row2["invyear"];
// $invmonth = $row2["invmonth"];
// $invcode = "INV-$invyear$invmonth$er_id";

?>
<script type="text/javascript"> window.close(); </script>
