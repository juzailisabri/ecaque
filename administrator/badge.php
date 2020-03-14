<?php
session_start();
include("../conn.php");

if(!isset($_SESSION['USERNAME']) && empty($_SESSION['USERNAME'])) {
   // header("Location: login");
   $status["STATUS"] = false;
} else {
  if(!$_SESSION["ADMIN"]){
    // header("Location: login");
    $status["STATUS"] = false;
  } else {
    $status["STATUS"] = true;

    if($_SESSION["ROLE"] == 4){
      $status["SENARAIKELUAR"] = senaraiKeluar();
      $status["QMINBOX"] = senaraiQMinbox();
    }
  }
}

// Housing Department

function senaraiKeluar(){
  global $conn;


  $s = "SELECT COUNT(fa_id) as COUNTER
  FROM f_application
  LEFT JOIN a_applicant ON fa_aa_id = aa_id
  LEFT JOIN ref_pangkat ON fa_rp_id = rp_id
  LEFT JOIN ref_status ON fa_status = rs_id
  WHERE fa_status = 103 AND ISNULL(fa_checkout_date) AND !ISNULL(fa_hh_id) AND !ISNULL(fa_checkin_date)
  AND
  ((DATEDIFF(NOW(),aa_birthday)/365 >= rp_retire) OR fa_id IN (SELECT fer_fa_id FROM f_exit_request WHERE fer_status = 1))";

  $arr = [];
  $result = $conn->query($s);
  $row = $result->fetch_assoc();

  return $row["COUNTER"];
}

function senaraiQMinbox(){
  global $conn;
  global $cfg_qm_inbox;
  $pasukan = $_SESSION["PASUKAN"];
  $statusqm = implode(",",$cfg_qm_inbox);

  $s = "SELECT COUNT(fa_id) as COUNTER
  FROM f_application
  LEFT JOIN a_applicant ON fa_aa_id = aa_id
  LEFT JOIN ref_pangkat ON fa_rp_id = rp_id
  LEFT JOIN ref_status ON fa_status = rs_id
  WHERE fa_rpsk_id = '$pasukan' AND fa_status IN ($statusqm)";

  $arr = [];
  $result = $conn->query($s);
  $row = $result->fetch_assoc();

  return $row["COUNTER"];
}

echo json_encode($status)

?>
