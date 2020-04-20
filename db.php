<?php
session_start();
include('administrator/conn.php');
include('administrator/email.php');
// include('../email.php');

$_POST = array_map('clean', $_POST);

function clean($a){
  global $conn;
  if (!is_array($a)) {
    return mysqli_real_escape_string($conn,$a);
  } else {
    return $a;
  }
}

if($_POST["func"] == "insertAgent"){
  echo json_encode(insertAgent($_POST));
}

function insertAgent($data){
  global $conn;

  $fullname = $data["fullname"];
  $identificationNo = $data["identificationNo"];
  $jantina = $data["jantina"];
  $nationality = $data["nationality"];
  $bangsa = $data["bangsa"];
  $alamat = $data["alamat"];
  $bandar = $data["bandar"];
  $negeri = $data["negeri"];
  $poskod = $data["poskod"];
  $email = $data["email"];
  $phone = $data["phone"];
  $facebook = $data["facebook"];
  $instagram = $data["instagram"];
  $linkedin = $data["linkedin"];


  $s = "SELECT es_id FROM e_stockist WHERE es_icno = '$identificationNo'";
  $res = $conn->query($s);
  $row = $res->fetch_assoc();
  $numr = $res->num_rows;

  if ($numr == 0) {
    $i = "INSERT INTO e_stockist
    (
      es_name,
      es_icno,
      es_rktrn_id,
      es_address,
      es_bandar,
      es_poskod,
      es_rngri_id,
      es_email,
      es_phone,
      es_facebook,
      es_instagram,
      es_linkedin,
      es_dateregister,
      es_rjan_id,
      es_rngra_id,
      es_status
    )
      VALUES
    (
      '$fullname',
      '$identificationNo',
      '$bangsa',
      '$alamat',
      '$bandar',
      '$poskod',
      '$negeri',
      '$email',
      '$phone',
      '$facebook',
      '$instagram',
      '$linkedin',
      NOW(),
      '$jantina',
      '$nationality',
      '1000'
    )";

    // echo $i;exit;

    if ($conn->query($i)) {
      $ret["STATUS"] = true;
      $ret["MSG"] = "Pemohonan pendaftaran anda telah berjaya dihantar. Mohon anda bersabar sementara pihak urusan kami mengesahkan maklumat anda";
      AgentRegistration(0,$email,$fullname,$email);
    } else {
      $ret["STATUS"] = false;
      $ret["MSG"] = "Permohonan gagal dihantar, Sila hubungi pihak urusan eCaque untuk bantuan.";
    }
  } else {
    $ret["STATUS"] = false;
    $ret["MSG"] = "Harap Maaf, No Kad Pengenalan Berikut Telah Didaftarkan di dalam sistem.";
  }



  return $ret;
}

?>
