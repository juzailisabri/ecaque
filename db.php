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
  global $cfg_salt;

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

  $mmpassword = mysqli_real_escape_string($conn,$data["password"]);
  $password = $cfg_salt.$mmpassword;
  $password = hash('sha256', $password);



  $s = "SELECT es_id FROM e_stockist WHERE es_icno = '$identificationNo'";
  $res = $conn->query($s);
  $row = $res->fetch_assoc();
  $numr = $res->num_rows;

  if ($numr == 0) {
    $i = "INSERT INTO e_stockist
    (
      es_password,
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
      '$password',
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
  global $secretKey;

  $rpid = $data["rpid"];
  $name = $data["fullname"];
  $address = $data["address"];
  $clientPhone = $data["phone"];
  $q = $data["quantityOrder"];

  $phone = "60194313041";

  $s = "SELECT * FROM ref_product WHERE SHA2(CONCAT('$secretKey',rp_id),256) = '$rpid'";
  $res = $conn->query($s);
  $row = $res->fetch_assoc();

  $rpname = $row["rp_name"];
  $freepostage = $row["rp_freepostagequantity"];
  $rp_postage = $row["rp_postage"];
  $rp_price = $row["rp_price"];
  $rp_name = $row["rp_name"];
  $postagefee = number_format(0.00,2);
  $total = 0.00;

  if ($q < $freepostage) { number_format($postagefee = $rp_postage * $q,2); }
  $total = number_format($postagefee + ($q * $rp_price), 2);

  $arr["rp_name"] = $rpname;
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
  global $secretKey;

  $rpid = $data["rpid"];
  $name = $data["fullname"];
  $address = $data["address"];
  $clientPhone = $data["phone"];
  $q = $data["quantityOrder"];
  $ref = "#";
  $phone = "60194313041";

  $s = "SELECT * FROM ref_product WHERE SHA2(CONCAT('$secretKey',rp_id),256) = '$rpid'";
  $res = $conn->query($s);
  $row = $res->fetch_assoc();

  $rpid = $row["rp_id"];
  $freepostage = $row["rp_freepostagequantity"];
  $rp_postage = $row["rp_postage"];
  $rp_price = $row["rp_price"];
  $rp_name = $row["rp_name"];
  $postagefee = number_format(0.00,2);
  $total = 0.00;

  if ($q < $freepostage) { number_format($postagefee = $rp_postage * $q,2); }
  $total = number_format($postagefee + ($q * $rp_price), 2);

  $er_fullname = $data["fullname"];
  $er_address = $data["address"];
  $er_phone = $data["phone"];
  $er_rjp_id = $data["jenisPenghantaran"];
  $er_postage = $postagefee;
  $er_totalprice = $total;
  $link1 = "";

  $s = "SELECT rjp_name FROM ref_jenisPenghantaran WHERE rjp_id = $er_rjp_id";
  $res = $conn->query($s);
  $row = $res->fetch_assoc();
  $rjp_name = $row["rjp_name"];

  $i = "INSERT INTO e_receipt (er_date,er_fullname,er_address,er_phone,er_rjp_id,er_postage,er_totalprice)
  VALUES (NOW(),'$er_fullname','$er_address','$er_phone',$er_rjp_id,$er_postage,$er_totalprice)";

  if ($conn->query($i)) {
    $ref = $conn->insert_id;
    $refNumber = secretKey($ref);
    $i2 = "INSERT INTO e_receipt_detail (erd_er_id,erd_rp_id,erd_quantity,erd_rp_price,erd_datetime)
    VALUES ($ref,$rpid,$q,$rp_price,NOW())";
    if ($conn->query($i2)) {
      $url = "http://".$_SERVER["HTTP_HOST"]."$rootdir/status?oid=$refNumber";
      $removeChar = array('\r','\n');
      $addressWhatsapp = str_replace($removeChar, "", $address);
$text = "
Hi eCaque, %0a%0a
Saya berminat untuk membeli kek dari eCaque Enterprise. Butiran adalah seperti berikut:- %0a
_______ %0a
Nama : *$name* %0a
Alamat : *$addressWhatsapp* %0a
No Telefon : *$clientPhone* %0a
_______ %0a
Barang : *$rp_name* %0a
Kuantiti : *$q* %0a
Caj Penghantaran : RM *$postagefee* %0a
Jumlah Bayaran : RM *$total* %0a
Jenis Penghantaran : *$rjp_name* %0a
_________%0a
Status dan Resit : %0a
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

if($_POST["func"] == "getStokistList"){
  echo json_encode(getStokistList($_POST));
}

function getStokistList($data){
  global $conn;

  $s = "SELECT rngri_id, rngri_name FROM ref_negeri WHERE rngri_status = 1 AND rngri_id IN (SELECT es_rngri_id FROM e_stockist WHERE es_status = 1001 GROUP BY es_rngri_id)";
  $negeri = [];
  $result = $conn->query($s);
  while ($row = $result->fetch_assoc())
  {
    $negeri[$row["rngri_id"]]["list"] = [];
    $negeri[$row["rngri_id"]] = $row;
  }

  $s = "SELECT es_name, es_bandar, rngri_name, es_phone, es_email, rngri_id FROM e_stockist
  LEFT JOIN ref_negeri ON rngri_id = es_rngri_id WHERE es_status = 1001";
  $arr = [];
  $result = $conn->query($s);
  while ($row = $result->fetch_assoc())
  {
    $es_name = $row["es_name"];
    $es_bandar = $row["es_bandar"];
    $rngri_name = $row["rngri_name"];
    $es_phone = convertPhone($row["es_phone"]);
    $es_email = $row["es_email"];
    $link = agentButtonLink($es_phone,$row["es_name"]);
    $row["html"] = dropshiplistformat($es_name,$es_bandar,$rngri_name,$es_phone,$es_email,$link);
    $negeri[$row["rngri_id"]]["list"][] = $row;
  }

  // return $negeri;
  return formatlistDropship($negeri);
}

function convertPhone($es_phone){
  if ($es_phone[0] == "0") {
    $es_phone = "+6".$es_phone;
  } else if ($es_phone[0] == "6") {
    $es_phone = "".$es_phone;
  } else {
    $es_phone = "+60".$es_phone;
  }

  return $es_phone;
}

function dropshiplistformat($es_name,$es_bandar,$rngri_name,$es_phone,$es_email,$link){
  $html =
  "<div class=\"col-sm-4 m-t-30\" style=\"height:180px\">
    <div class=\"p-r-40 md-pr-30\">
      <h6 class=\"block-title p-b-5 text-success\">$es_name <i class=\"pg-arrowa_right m-l-10\"></i></h6>
      <p class=\"p-l-10 no-margin text-uppercase\">$es_bandar, $rngri_name</p>
      <p class=\"p-l-10 no-margin black font-arial bold no-padding\">$es_phone</p>
      <p class=\"p-l-10 no-margin muted font-arial small-text no-padding\">$es_email</p>
      <a type=\"button\" href=\"$link\" target=\"_blank\" class=\"m-t-10 m-l-10 btn btn-success\" name=\"button\">Whatsapp Now</a>
    </div>
    <div class=\"visible-xs b-b b-grey-light m-t-30 m-b-30\"></div>
  </div>";

  return $html;
}

function dropshipheading($heading){
  $html ="
  <div class=\"row hidden-xs\">
  <div class=\"col-lg-12 \">
    <hr>
  </div>
  </div>
  <div class=\"row m-t-10\">
    <div class=\"col-lg-12\">
      <h3 class=\"font-montserrat text-uppercase p-l-15\">$heading</h3>
    </div>
  </div>";

  return $html;
}

function agentButtonLink($phone,$name){
  $text = "
  Hi $name, %0a%0a
  Saya berminat untuk membeli kek dari eCaque Enterprise. Butiran adalah seperti berikut:- %0a
  _______ %0a
  Nama :  %0a
  Alamat :  %0a
  No Telefon :  %0a
  _______ %0a
  Barang : *Kek Kukus eCaque 1Kg* %0a
  Kuantiti : ** %0a
  Jenis Penghantaran : Postage%0a
  ";
  $link1 = "https://api.whatsapp.com/send?phone=$phone&text=$text";

  return $link1;
}

function formatlistDropship($negeri){
  // print_r($negeri);
  $html = "";
  foreach ($negeri as $key => $value) {
    $html = $html.dropshipheading($negeri[$key]["rngri_name"]);
    if (isset($negeri[$key]["list"])) {
      $list = $negeri[$key]["list"];
      foreach ($list as $key2 => $value2) {
        $html = $html.$list[$key2]["html"];
      }
    }

  }

  return $html;
}


?>
