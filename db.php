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

if($_POST["func"] == "whatsappOrder"){
  echo json_encode(whatsappOrder($_POST));
}


function whatsappOrder($data){
  global $conn;
  global $rootdir;

  $name = $data["fullname"];
  $address = $data["address"];
  $clientPhone = $data["phone"];
  $q = $data["quantityOrder"];

  $phone = "+60194313041";

  $s = "SELECT * FROM ref_product WHERE rp_id = 1";
  $res = $conn->query($s);
  $row = $res->fetch_assoc();

  $freepostage = $row["rp_freepostagequantity"];
  $rp_postage = $row["rp_postage"];
  $rp_price = $row["rp_price"];
  $rp_name = $row["rp_name"];
  $postagefee = number_format(0.00,2);
  $total = 0.00;

  if ($q <= $freepostage) { number_format($postagefee = $rp_postage * $q,2); }
  $total = number_format($postagefee + ($q * $rp_price), 2);

  $arr["rp_price"] = number_format($rp_price, 2);
  $arr["postagefee"] = number_format($postagefee, 2);
  $arr["total"] = number_format($total, 2);
  $arr["STATUS"] = true;

  return $arr;
}

if($_POST["func"] == "OrderNow"){
  echo json_encode(OrderNow($_POST));
}

function OrderNow($data){
  global $conn;
  global $rootdir;

  $name = $data["fullname"];
  $address = $data["address"];
  $clientPhone = $data["phone"];
  $q = $data["quantityOrder"];
  $ref = "#";
  $phone = "+60194313041";

  $s = "SELECT * FROM ref_product WHERE rp_id = 1";
  $res = $conn->query($s);
  $row = $res->fetch_assoc();

  $rpid = $row["rp_id"];
  $freepostage = $row["rp_freepostagequantity"];
  $rp_postage = $row["rp_postage"];
  $rp_price = $row["rp_price"];
  $rp_name = $row["rp_name"];
  $postagefee = number_format(0.00,2);
  $total = 0.00;

  if ($q <= $freepostage) { number_format($postagefee = $rp_postage * $q,2); }
  $total = number_format($postagefee + ($q * $rp_price), 2);

  $er_fullname = $data["fullname"];
  $er_address = $data["address"];
  $er_phone = $data["phone"];
  $er_rjp_id = $data["jenisPenghantaran"];
  $er_postage = $postagefee;
  $er_totalprice = $total;
  $link1 = "";


  $i = "INSERT INTO e_receipt (er_date,er_fullname,er_address,er_phone,er_rjp_id,er_postage,er_totalprice)
  VALUES (NOW(),'$er_fullname','$er_address','$er_phone',$er_rjp_id,$er_postage,$er_totalprice)";

  if ($conn->query($i)) {
    $ref = $conn->insert_id;
    $refNumber = secretKey($ref);
    $i2 = "INSERT INTO e_receipt_detail (erd_er_id,erd_rp_id,erd_quantity,erd_rp_price,erd_datetime)
    VALUES ($ref,$rpid,$q,$rp_price,NOW())";
    if ($conn->query($i2)) {
      $url = "http://".$_SERVER["HTTP_HOST"]."$rootdir/status?oid=$refNumber";

$text = "
Hi eCaque, %0D%0D
Saya berminat untuk membeli kek dari eCaque Enterprise. Butiran adalah seperti berikut:- %0D
_______ %0D
Nama : *$name* %0D
Alamat : *$address* %0D
No Telefon : *$clientPhone* %0D
_______ %0D
Barang : *$rp_name* %0D
Kuantiti : *$q* %0D
Caj Penghantaran : RM *$postagefee* %0D
Jumlah Bayaran : RM *$total* %0D
Jenis Penghantaran : %0D
_________%0D
Status dan Resit : %0D
$url
";
      $link1 = "https://api.whatsapp.com/send?phone=$phone&text=$text";
      $arr["STATUS"] = true;
      $arr["MSG"] = "OK";
    } else {
      $arr["STATUS"] = false;
      $arr["MSG"] = "ERROR D";
    }
  } else {
    $arr["STATUS"] = false;
    $arr["MSG"] = "ERROR M";
  }

  $arr["link"] = trim($link1);

  return $arr;
}

function secretKey($str){
  global $secretKey;
  return hash('MD5', $secretKey.$str);
}


?>
