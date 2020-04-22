<?php
include("administrator/conn.php");

// POST
// refno : Payment reference no
// status : Payment status. 1= success, 2=pending, 3=fail
// reason : Reason for the status received
// billcode : Your billcode / permanent link
// order_id : Your external payment reference no, if specified
// amount : Payment amount received

$_POST = array_map('clean', $_POST);

function clean($a){
  global $conn;
  if (!is_array($a)) {
    return mysqli_real_escape_string($conn,$a);
  } else {
    return $a;
  }
}

if (isset($_POST["refno"]) && isset($_POST["status"]) &&
    isset($_POST["reason"]) && isset($_POST["billcode"]) &&
    isset($_POST["order_id"]) && isset($_POST["amount"])) {

  $refno = $_POST["refno"];
  $status = $_POST["status"];
  $reason = $_POST["reason"];
  $billcode = $_POST["billcode"];
  $amount = $_POST["amount"];

  $date = 'NULL'; if ($status == 1) { $date = 'NOW()'; }

  $order_id = $_POST["order_id"];

  $s = "SELECT er_id FROM e_receipt WHERE MD5(CONCAT('$secretKey',er_id)) = '$order_id'";
  $res = $conn->query($s);
  $num = $res->num_rows;

  if ($num != 0) {
    $u = "UPDATE e_receipt SET
    er_paymentRefNo = '$refno',
    er_paymentStatus = '$status',
    er_paymentReason = '$reason',
    er_billcode = '$billcode',
    er_paymentReceived = '$amount',
    er_payment_date = $date
    WHERE MD5(CONCAT('$secretKey',er_id)) = '$order_id'";

    if ($conn->query($u)) {
      $ret = "UPDATES SUCCESS";
    } else {
      $ret = "UPDATES FAILS";
    }
  } else {
    $ret = "NO ORDER FOUND";
  }
} else {
  $ret = "ERROR VARIABLE";
}

echo $ret;
?>

<!-- <script type="text/javascript"> window.close(); </script> -->
