<?php
// include("administrator/conn.php");
//
// $_GET = array_map('clean', $_GET);
//
// function clean($a){
//   global $conn;
//   if (!is_array($a)) {
//     return mysqli_real_escape_string($conn,$a);
//   } else {
//     return $a;
//   }
// }
//
// // GET
// // status_id : Payment status. 1= success, 2=pending, 3=fail
// // billcode: Your billcode / permanent link
// // order_id : Your external payment reference no, if specified
//
// if (isset($_GET["status_id"]) && isset($_GET["billcode"]) &&
//     isset($_GET["order_id"]) && isset($_GET["transaction_id"])) {
//   $status_id = $_GET["status_id"];
//   $billcode = $_GET["billcode"];
//   $order_id = $_GET["order_id"];
//   $transaction_id = $_GET["transaction_id"];
//
//   $dataget = array(
//     'billCode' => $billcode,
//     'billpaymentStatus' => $status_id
//   );
//
//   $curl = curl_init();
//
//   curl_setopt($curl, CURLOPT_POST, 1);
//   curl_setopt($curl, CURLOPT_URL, 'https://toyyibpay.com/index.php/api/getBillTransactions');
//   curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
//   curl_setopt($curl, CURLOPT_POSTFIELDS, $dataget);
//
//   $result = curl_exec($curl);
//   $info = curl_getinfo($curl);
//   curl_close($curl);
//   $obj = json_decode($result, true);
//
//   // [{"billName":"eCaque Kek Kukus","billDescription":"eCaque Kek Kukus","billTo":"Juzaili Ahmad Sabri","billEmail":"juzaili.sabri@gmail.com","billPhone":"0192669420","billStatus":"1","billpaymentStatus":"3","billpaymentAmount":"2.00","billpaymentInvoiceNo":"TP604897245141518220420","billPaymentDate":"22-04-2020 18:15:14"}]
//
//   $billStatus = $obj[0]["billStatus"];
//   $billpaymentStatus = $obj[0]["billpaymentStatus"];
//   $billpaymentAmount = $obj[0]["billpaymentAmount"];
//   $billpaymentInvoiceNo = $obj[0]["billpaymentInvoiceNo"];
//   $billPaymentDate = $obj[0]["billPaymentDate"];
//
//   $s = "SELECT er_id FROM e_receipt WHERE MD5(CONCAT('$secretKey',er_id)) = '$order_id'";
//   $res = $conn->query($s);
//   $num = $res->num_rows;
//
//   $date = 'NULL'; if ($status_id == 1) { $date = 'NOW()'; }
//   if ($status_id != 1) { $billpaymentAmount = 0.00; }
//   if ($num != 0) {
//     $u = "UPDATE e_receipt SET
//     er_paymentRefNo = '$order_id',
//     er_paymentStatus = '$billpaymentStatus',
//     er_billcode = '$billcode',
//     er_paymentReceived = '$billpaymentAmount',
//     er_payment_date = $date
//     WHERE MD5(CONCAT('$secretKey',er_id)) = '$order_id'";
//     if ($conn->query($u)) {
//       $ret = "UPDATES SUCCESS";
//     } else {
//       $ret = "UPDATES FAILS";
//     }
//   } else {
//     $ret = "NO ORDER FOUND";
//   }
// } else {
//   $ret = "ERROR VARIABLE";
// }
//
// echo $ret;


?>

<script type="text/javascript"> window.close(); </script>
