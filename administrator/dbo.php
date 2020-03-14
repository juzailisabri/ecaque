<?php session_start();

require_once('conn.php');

$_POST = array_map('clean', $_POST);

function clean($a){
  global $conn;
  if (!is_array($a)) {
    return mysqli_real_escape_string($conn,$a);
  } else {
    return $a;
  }
}
// SEARCH DUPLICATION

$fullname = $_POST["fullname"];
$notentera = $_POST["notentera"];
$birthdate = convertdate($_POST["birthdate"]);
$phone = $_POST["phone"];
$email = $_POST["email"];
$uname = $_POST["uname"];
$pass = $_POST["pass"];
$pass2 = $_POST["pass2"];

$q = "SELECT aa_id, aa_id_no, aa_status FROM a_applicant WHERE aa_id_no = '$notentera' OR aa_username = '$uname'";
$res = $conn->query($q);
$row = $res->fetch_assoc();
$trow = $res->num_rows;
if($trow == 0 ) {
  $pass = hash('sha256', $cfg_salt.$pass);

  $insertSQL = "INSERT INTO a_applicant
  (
    aa_name,
    aa_id_no,
    aa_birthday,
    aa_phone,
    aa_email,
    aa_register_date,
    aa_username,
    aa_password,
    aa_status
  )
  VALUES
  (
    '$fullname',
    '$notentera',
    '$birthdate',
    '$phone',
    '$email',
    NOW(),
    '$uname',
    '$pass',
    '1'
  )";

  if ($conn->query($insertSQL)) {
    $status["STATUS"] = true;
    $status["MSG"] = "Pendaftaran Berjaya Dihantar";
  } else {
    $status["STATUS"] = false;
    $status["MSG"] = "Pendaftaran Gagal Dihantar";
  }

} else {
  $status["STATUS"] = false;
  $status["MSG"] = "No. Tentera / Username sudah didaftarkan di dalam pengkalan data RKAT";
  $status["ERRCODE"] = "DP01";
}

echo json_encode($status);

function convertdate($date){
  $date = explode("-",$date);
  $date = $date[2]."-".$date[1]."-".$date[0];

  return $date;
}

function convertdatetime($date){
  $datetime = explode(" ",$date);
  $date = explode("-",$datetime[0]);
  $date = $date[2]."-".$date[1]."-".$date[0];

  return $date." ".$datetime[1];
}

 ?>
