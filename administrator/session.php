<?php
session_start();

include("conn.php");

$sessionID = $_SESSION['SESSIONID'];
$id = $_SESSION['ID'];
$role = $_SESSION['ROLE'];
// echo $sessionID;exit;

$uustatus = "SELECT uu_status FROM u_user WHERE uu_id = '$id'";
$uurole = "SELECT uur_id FROM u_user_role WHERE uur_uu_id = '$id' AND uur_rr_id = '$role'";

$s = "SELECT uull_id, ($uustatus) as uu_status, ($uurole) as role FROM u_user_login_log WHERE uull_uu_id = '$id' AND uull_id = '$sessionID' AND uull_status = 1";
// echo $s;
$result = $conn->query($s);
$numrow = $result->num_rows;
$row = $result->fetch_assoc();

if($numrow == 0){
  session_destroy();
  $d = false;
} else {
  if ($row["uu_status"] == 0 || $row["role"] == "") {
    session_destroy();
    $d = false;
  } else {
    $d = true;
  }
}

// if(!isset($_SESSION['USERNAME']) && empty($_SESSION['USERNAME'])) {
//    // header("Location: login");
//    $status = false;
// } else {
//   if(!$_SESSION["ADMIN"]){
//     // header("Location: login");
//     $status = false;
//   }
//   $status = true;
// }

echo json_encode($d)

?>
