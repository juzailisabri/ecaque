<?php
session_start();
include('../administrator/conn.php');
include('../administrator/email.php');

$_POST = array_map('clean', $_POST);

function clean($a){
  global $conn;
  if (!is_array($a)) {
    return mysqli_real_escape_string($conn,$a);
  } else {
    return $a;
  }
}

function convertdate($date){
  if($date != '' && $date != null){
    $date = explode("-",$date);
    $date = $date[2]."-".$date[1]."-".$date[0];
  } else {
    $date = '';
  }
  return $date;
}

function convertdatetime($date){
  $datetime = explode(" ",$date);
  $date = explode("-",$datetime[0]);
  $date = $date[2]."-".$date[1]."-".$date[0];

  return $date." ".$datetime[1];
}

function colorFunction($var,$on,$off){
  if($var == ""){
    return $off;
  } else {
    return $on;
  }
}

if($_POST["func"] == "Login"){
  echo json_encode(loginUser($_POST));
}

function loginUser($data){
  global $conn;
  global $cfg_salt;

  $status["AAS"] = false;
  $status["AAP"] = false;
  $status["AASTATUS"] = false;
  $status["STATUS"] = false;
  // echo $data["password"];

  if(isset($data["email"]) && isset($data["password"])){
    $mmemail = mysqli_real_escape_string($conn,$data["email"]);
    $mmpassword = mysqli_real_escape_string($conn,$data["password"]);
    $password = $cfg_salt.$mmpassword;
    $password = hash('sha256', $password);
    $status["PA"] = $password;
    // 69C62E906A15C66DBB13CDE5897678164192B1CE4309F6F5D6DEA90BB389D3F98c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918

    $q = "SELECT es_password, es_id, es_email, es_name, es_status
    FROM e_stockist WHERE es_email = '$mmemail'";
    $result = $conn->query($q);
    $number = $result->num_rows;
    $row = $result->fetch_assoc();

    if($number != 0){
      $status["AASTATUS"] = true;
      if($row["es_status"] == 9){
        $status["AAS"] = false;
      } else if($row["es_status"] == 1001){
          $status["AAS"] = true;
          $status["AASTATUS"] = true;
          $status["EV"] = true;
          if($row["es_password"] == $password) {
            $uuid = $row["es_id"];
            $status["AAP"] = true;
            $status["MSG"] = "";

            $_SESSION['AGENT']['ID'] = $row["es_id"];
            $_SESSION['AGENT']['USERNAME'] = $row["es_email"];
            $_SESSION['AGENT']['FULLNAME'] = $row["es_name"];
            $status["STATUS"] = true;
          } else {
            $status["AAP"] = false;
            $status["MSG"] = "Harap Maaf, Sila periksa katalaluan anda.";
          }
      } else {
        $status["AASTATUS"] = false;
        $status["MSG"] = "Harap Maaf, Akaun Anda Tidak Aktif. Sila hubungi admin sistem untuk aktifkan akaun anda";
      }
    } else {
      $status["MSG"] = "Harap Maaf, Tiada Rekod Pengguna dalam pengkalan data";
    }
  } else {
    $status["AAS"] = false;
    $status["AAP"] = false;
    $status["AASTATUS"] = false;
  }

  return $status;
}

if($_POST["func"] == "updateForgotPassword"){
  echo json_encode(updateForgotPassword($_POST));
}

function updateForgotPassword($data){
  global $conn;
  global $cfg_salt;
  global $secretKey;

  $esfp = mysqli_real_escape_string($conn,$data["esfp"]);
  $mmpassword = mysqli_real_escape_string($conn,$data["password"]);
  $password = $cfg_salt.$mmpassword;
  $password = hash('sha256', $password);

  $s = "SELECT esfp_es_id FROM e_stokist_forgotpassword WHERE
  SHA2(CONCAT('$secretKey',esfp_id),256) = '$esfp' AND esfp_status = 0";
  $res = $conn->query($s);
  $row = $res->fetch_assoc();
  $esid = $row["esfp_es_id"];

  $u = "UPDATE e_stockist SET es_password = '$password' WHERE es_id = ($esid)";
  if ($conn->query($u)) {
    $u = "UPDATE e_stokist_forgotpassword SET esfp_status = 1 WHERE esfp_es_id = ($esid)";
    if ($conn->query($u)) {
      $status["STATUS"] = true;
      $status["MSG"] = "Katalaluan Berjaya Dikemaskini";
    } else {
      $status["STATUS"] = false;
      $status["MSG"] = "Katalaluan Tidak Berjaya Dikemaskini (E1)";
    }
  } else {
    $status["STATUS"] = false;
    $status["MSG"] = "Katalaluan Tidak Berjaya Dikemaskini";
  }

  return $status;
}

if($_POST["func"] == "logout"){
  session_destroy();
  $status["LO"] = true;
  echo json_encode($status);
}

if($_POST["func"] == "getReceipt"){
  echo json_encode(getReceipt($_POST));
}

function getReceipt($data){
  global $conn;
  global $secretKey;

  $uid = $_SESSION["AGENT"]["ID"];

  $columns = array(
    // datatable column index  => database column name
    0 => 'er_id',
    1 => 'er_fullname',
    2 => 'er_fullname',
    3 => 'er_totalprice',
    4 => 'er_totalprice',
    5 => 'er_totalprice'
  );

  $where = " AND er_es_id = $uid AND er_devtest IS NULL ";

  if (isset($data["statusOrder"]) && $data["statusOrder"] != '') {
    $staorder["3001"] = "AND er_payment_date IS NULL AND er_packing_date IS NULL ";
    $staorder["3002"] = "AND er_payment_date IS NULL ";
    $staorder["3003"] = "AND er_payment_date IS NOT NULL AND er_packing_date IS NULL";
    $staorder["3004"] = "AND er_payment_date IS NOT NULL AND er_packing_date IS NOT NULL AND er_trackingNo IS NOT NULL ";

    $statusOrder = $data["statusOrder"];
    $str = $staorder[$statusOrder];

    $where .= " $str ";
  }

  if (isset($data["search"]) && $data["search"] != '') {
    $search = $data['search'];
    $where .= " AND (er_fullname  LIKE '%".$search."%' ";
    $where .= " OR er_phone LIKE '%".$search."%'";
    $where .= " OR er_address LIKE '%".$search."%'";
    $where .= " OR er_id LIKE '%".$search."%'";
    $where .= " OR CONCAT(DATE_FORMAT(er_date,'%Y'),DATE_FORMAT(er_date,'%m'),LPAD(er_id, 8, '0')) = '".$search."'";
    $where .= " OR MD5(CONCAT('$secretKey',er_id)) = '$search') ";
  }

  // if (isset($data["statusOrder"]) && $data["statusOrder"] != '') {
  //   $where .= "AND eos_status = '".$data["statusOrder"]."' ";
  // }

  $sql = "SELECT COUNT(er_id) as count FROM e_receipt WHERE TRUE $where";

  $result = $conn->query($sql);
  $row = $result->fetch_assoc();
  $numrows = $row["count"];
  $totalData = $numrows;

  $sql = "SELECT
  MD5(CONCAT('$secretKey',er_id)) as linkid,
  SHA2(er_id,256) as enc_id,
  er_id,
  er_date,
  er_fullname,
  er_address,
  er_phone,
  er_rjp_id,
  er_postage,
  er_totalprice,
  er_trackingNo,
  er_rdc_id,
  er_payment_date,
  er_packing_date,
  er_dispatch_date,
  DATE_FORMAT(er_date,'%Y') as invyear,
  DATE_FORMAT(er_date,'%m') as invmonth,
  er_status
  FROM e_receipt
  WHERE TRUE $where
  ";

  $sql.=" ORDER BY ". $columns[$data['order'][0]['column']]." ".$data['order'][0]['dir']." LIMIT ".$data['start']." ,".$data['length']."   ";
  $result = $conn->query($sql);
  $numrows = $result->num_rows;
  $totalFiltered = $numrows;

  $x = 1;
  $datadb = array();
  while ($row = $result->fetch_assoc()) {

    $invyear = $row["invyear"];
    $invmonth = $row["invmonth"];
    $er_id = sprintf("%08d", $row["er_id"]);
    $invcode = "INV-$invyear$invmonth$er_id";

    $enc_id = $row["enc_id"];
    $er_fullname = $row["er_fullname"];
    $er_address = $row["er_address"];
    $er_phone = $row["er_phone"];
    $er_postage = $row["er_postage"];
    $er_totalprice = "RM ".number_format($row["er_totalprice"]+$er_postage,2);
    $er_trackingNo = $row["er_trackingNo"];
    $er_date = $row["er_date"];
    $linkid = $row["linkid"];
    $er_payment_date = $row["er_payment_date"];
    $er_packing_date = $row["er_packing_date"];

    $er_payment_dateC = colorFunction($er_payment_date,"text-success","text-muted");
    $er_packing_dateC = colorFunction($er_packing_date,"text-success","text-muted");

    $er_payment_dateCM = colorFunction($er_payment_date,"btn-success","btn-muted");
    $er_payment_dateCM2 = colorFunction($er_payment_date,"btn-success","btn-danger");
    $er_packing_dateCM = colorFunction($er_packing_date,"btn-success","btn-muted");
    $paymentStatus = colorFunction($er_payment_date,"PAID","UNPAID");
    $er_trackingNotext = colorFunction($er_trackingNo,$er_trackingNo,"-");

    $link = "receipt?oid=$linkid";

    $nestedData=array();
    $nestedData[] = $row["er_id"];
    $nestedData[] = "<b>$invcode</b><br><b>$er_fullname</b><br>$er_phone<br>$er_address<br> <sub>Order Date</sub><br>$er_date<br><sub>Tracking No</sub><br>$er_trackingNotext
                    ";
    $nestedData[] = "<b>$invcode</b><br>$er_fullname<br>$er_phone<br>$er_address<br>$er_date";
    $nestedData[] = "$er_totalprice ";
    $nestedData[] = "<i class=' $er_payment_dateC '> <i class='fa fa-check'></i> </button>";
    $nestedData[] = "<i class=' $er_packing_dateC '> <i class='fa fa-check'></i> </button>";

    if ($er_payment_date == "") {
      $buttonarray[0] = "<a id=\"makepayment\" key=\"$linkid\" link=\"makepayment?erid=$enc_id\" class=\"dropdown-item\" href=\"#\">Pay</a>";
    } else {
      $buttonarray[0] = "";
    }
    $buttonarray[1] = "<a href=\"$link\" target=\"ecaqueReceipt\" class=\"dropdown-item\" href=\"#\">Receipt</a>";
    $btnaction = dropdownButtonstyle1($paymentStatus,$er_payment_dateCM2,$buttonarray);

    $nestedData[] = "
    $btnaction
    </div>
    <div class=\"row p-t-10 visible-xs\">
      <b>$er_totalprice</b>
    </div>";

    $datadb[] = $nestedData;
    $x++;
  }

  error_log(print_r($data,true),0);

  $json_data = array(
    "draw"            => intval( $data['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw.
    "recordsTotal"    => intval( $totalFiltered),  // total number of records
    "recordsFiltered" => intval( $totalData ), // total number of records after searching, if there is no searching then totalFiltered = totalData
    "data"            => $datadb
  );

  return $json_data;
}

function dropdownButtonstyle1($title,$color,$buttonarray){
  $sub = "";
  foreach ($buttonarray as $key => $value) {
    $sub = $sub.$buttonarray[$key];
  }
  $html = "<div class=\"dropdown dropdown-default\" style=\"width: 100%;\">
  <button aria-label=\"\" class=\"btn dropdown-toggle text-center $color\" type=\"button\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\" style=\"width: 100%;\">
    <b>$title</b>
  </button>
  <div class=\"dropdown-menu\" style=\"width: 100%; will-change: transform;\">
    $sub
  </div>
  </div>";

  return $html;
}

if($_POST["func"] == "getReceiptDetail"){
  echo json_encode(getReceiptDetail($_POST));
}

function getReceiptDetail($data){
  global $conn;
  global $secretKey;

  $id = $data["er_id"];
  $s = "SELECT
  MD5(CONCAT('$secretKey',er_id)) as linkid,
  SHA2(er_id,256) as enc_id,
  er_id,
  er_date,
  er_fullname,
  er_address,
  er_phone,
  er_rjp_id,
  er_postage,
  er_totalprice,
  er_trackingNo,
  er_rdc_id,
  er_payment_date,
  er_packing_date,
  er_dispatch_date,
  er_status,
  er_rb_id,
  er_bankref
  FROM e_receipt
  WHERE SHA2(er_id,256) = '$id'";

  $arr = [];
  $result = $conn->query($s);
  while ($row = $result->fetch_assoc())
  {
    $arr[] = $row;
  }

  return $arr[0];
}

if($_POST["func"] == "getProduct"){
  echo json_encode(getProduct($_POST));
}

function getProduct($data){
  global $conn;

  $columns = array(
    // datatable column index  => database column name
    0 => 'rp_name',
    1 => 'rp_name',
    2 => 'rp_name'
  );

  $where = "";

  $sql = "SELECT COUNT(rp_id) as count FROM ref_product WHERE TRUE $where";

  $result = $conn->query($sql);
  $row = $result->fetch_assoc();
  $numrows = $row["count"];
  $totalData = $numrows;

  $sql = "SELECT
  rp_id,
  rp_name,
  rp_desc,
  rp_price
  FROM ref_product
  WHERE TRUE $where
  ";

  if(!empty($data['search'])) {
    $sql.=" ORDER BY ". $columns[$data['order'][0]['column']]." ".$data['order'][0]['dir']." LIMIT ".$data['start']." ,".$data['length']."   ";

    $result = $conn->query($sql);
    $numrows = $result->num_rows;
    $totalFiltered = $numrows;
  } else {
    $sql.=" ORDER BY ". $columns[$data['order'][0]['column']]." ".$data['order'][0]['dir']." LIMIT ".$data['start']." ,".$data['length']."   ";
    $result = $conn->query($sql);
    $numrows = $result->num_rows;
    $totalFiltered = $numrows;
  }

  $x = 1;
  $datadb = array();
  while ($row = $result->fetch_assoc()) {
    $price = $row["rp_price"];
    $rpid = $row["rp_id"];
    $nestedData=array();
    $nestedData[] = $row["rp_name"]."<br>";
    $nestedData[] = "<input id=\"quantity[]\" name=\"quantity[]\" key=\"$rpid\" type=\"text\" class=\"form-control text-center\" placeholder=\"\">";
    $nestedData[] = "<input id=\"price[]\" name=\"price[]\" key=\"$rpid\" type=\"text\" value=\"$price\" class=\"form-control text-center\" placeholder=\"$price\">";


    $datadb[] = $nestedData;
    $x++;
  }

  error_log(print_r($data,true),0);

  $json_data = array(
    "draw"            => intval( $data['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw.
    "recordsTotal"    => intval( $totalFiltered),  // total number of records
    "recordsFiltered" => intval( $totalData ), // total number of records after searching, if there is no searching then totalFiltered = totalData
    "data"            => $datadb
  );

  return $json_data;
}

if($_POST["func"] == "calculateOrder"){
  echo json_encode(calculateOrder($_POST));
}

function calculateOrder($data){
  global $conn;
  global $rootdir;
  $rpid = $data["rpid"];
  $quantity = $data["quantity"];

  $s = "SELECT * FROM ref_product WHERE rp_status = 1";
  $res = $conn->query($s);

  $arr = [];
  while ($row = $res->fetch_assoc()) {
    $arr[$row["rp_id"]] = $row;
  }

  $gtotal = 0.00;
  $postagetotal = 0.00;
  $gtotalds = 0.00;

  foreach ($rpid as $key => $value) {
    $freepostagequantity = $arr[$rpid[$key]]["rp_freepostagequantity"];
    $rp_price = $arr[$rpid[$key]]["rp_price"];
    $arr[$rpid[$key]]["rp_postage"] = $quantity[$key] * $arr[$rpid[$key]]["rp_postage"];
    $arr[$rpid[$key]]["rp_total_ds"] = $quantity[$key] * $arr[$rpid[$key]]["rp_price_ds"];
    $arr[$rpid[$key]]["rp_total"] = $quantity[$key] * $arr[$rpid[$key]]["rp_price"];
    $arr[$rpid[$key]]["quantity"] = $quantity[$key];
    $gtotal = $gtotal + $arr[$rpid[$key]]["rp_total"];
    $gtotalds = $gtotalds + $arr[$rpid[$key]]["rp_total_ds"];
    if ($quantity[$key] >= $freepostagequantity) {
      $arr[$rpid[$key]]["rp_postage"] = 0.00;
    }
    $postagetotal = $postagetotal + $arr[$rpid[$key]]["rp_postage"];
  }

  $total["gtotal"] = ($gtotal);
  $total["gtotalds"] = ($gtotalds);
  $total["postagetotal"] = ($postagetotal);
  $total["commision"] = ($gtotal - $gtotalds);
  $total["gtotalpayment"] = ($gtotal + $postagetotal);
  $total["gtotalpaymentPay"] = ($gtotalds + $postagetotal);

  $arrset["arr"] = $arr;
  $arrset["totals"] = $total;

  return $arrset;
}

if($_POST["func"] == "makeOrder"){
  echo json_encode(makeOrder($_POST));
}

function makeOrder($data){
  global $conn;
  global $secretKey;

  $calc = calculateOrder($data);
  $productlist = $calc["arr"];
  $totals = $calc["totals"];

  $er_fullname = $data["fullname"];
  $er_address = $data["address"];
  $er_phone = $data["phone"];
  $er_rjp_id = $data["JenisPenghantaran"];
  $er_postage = $totals["postagetotal"];
  $er_totalprice = $totals["gtotalpaymentPay"];
  $uuid = $_SESSION["AGENT"]["ID"];

  $i = "INSERT INTO e_receipt (er_date,er_fullname,er_address,er_phone,er_rjp_id,er_postage,er_totalprice,er_es_id)
  VALUES (NOW(),'$er_fullname','$er_address','$er_phone',$er_rjp_id,$er_postage,$er_totalprice,$uuid)";

  if ($conn->query($i)) {
    $insertid = $conn->insert_id;
    $iconcat = [];
    foreach ($productlist as $key => $value) {
      $rpid = $productlist[$key]["rp_id"];
      $q = $productlist[$key]["quantity"];
      $rp_price = $productlist[$key]["rp_price_ds"];
      $str = "($insertid,$rpid,$q,$rp_price,NOW())";
      if ($q > 0) { array_push($iconcat,$str); }
    }

    $values = implode(",",$iconcat);

    $i2 = "INSERT INTO e_receipt_detail (erd_er_id,erd_rp_id,erd_quantity,erd_rp_price,erd_datetime)
    VALUES $values";

    if ($conn->query($i2)) {
      $ret["STATUS"] = true;
      $erid = hash('sha256', $insertid);
      $eridmd5 = md5($secretKey.$insertid);
      $ret["LINK"] = "makepayment?erid=$erid";
      // $ret["KEY"] = $erid;
      $ret["KEYMD5"] = $eridmd5;
      $ret["MSG"] = "Pesanan anda berjaya dihantar. Terima Kasih";
    } else {
      $ret["STATUS"] = false;
      $ret["MSG"] = "Harap Maaf, Pesanan Gagal Didaftarkan (ERD)";
    }
  } else {
    $ret["STATUS"] = false;
    $ret["MSG"] = "Harap Maaf, Pesanan Gagal Didaftarkan (ER)";
  }

  return $ret;
}

if($_POST["func"] == "checkPayment"){
  echo json_encode(checkPayment($_POST));
}

function checkPayment($data){
  global $conn;
  global $secretKey;

  $id = $data["er_id"];
  $s = "SELECT
  er_paymentStatus,
  er_paymentRefNo
  FROM e_receipt
  WHERE MD5(CONCAT('$secretKey',er_id)) = '$id'";

  $result = $conn->query($s);
  $row = $result->fetch_assoc();
  $payment = $row;
  $stat = [];

  if ($payment["er_paymentStatus"] != "") {

    $er_paymentStatus = $row["er_paymentStatus"];
    $er_paymentRefNo = $row["er_paymentRefNo"];

    $stat["STATUS"] = true;
    if ($payment["er_paymentStatus"] == 1) {
      $stat["MSG"] = "Pembayaran Anda Berjaya Diterima. Nombor Transaksi adalah [$er_paymentRefNo]";
      $stat["TITLE"] = "Berjaya";
      $stat["TYPE"] = "success";
    } else if ($payment["er_paymentStatus"] == 2) {
      $stat["MSG"] = "Pembayaran Anda Berjaya Masih Pending";
      $stat["TITLE"] = "Pending";
      $stat["TYPE"] = "warning";
    } else if ($payment["er_paymentStatus"] == 3) {
      $stat["MSG"] = "Pembayaran Anda Tidak Berjaya Diterima";
      $stat["TITLE"] = "Tidak Berjaya";
      $stat["TYPE"] = "warning";
      // FAIL
    } else {
      $stat["MSG"] = "";
      $stat["TITLE"] = "";
      $stat["TYPE"] = "";
    }
  }

  return $stat;
}

if($_POST["func"] == "forgotPassword"){
  echo json_encode(forgotPassword($_POST));
}

function forgotPassword($data){
  global $conn;
  global $secretKey;

  $email = $data["emailfp"];

  $s = "SELECT es_id,es_name,es_email FROM e_stockist WHERE es_email = '$email'";
  $result = $conn->query($s);
  $row = $result->fetch_assoc();
  $es_id = $row["es_id"];
  $es_name = $row["es_name"];
  $es_email = $row["es_email"];

  $u = "UPDATE e_stokist_forgotpassword SET esfp_status = 1 WHERE esfp_es_id = $es_id";
  $conn->query($u);

  $i = "INSERT INTO e_stokist_forgotpassword (esfp_es_id,esfp_datetime) VALUES ($es_id,NOW())";
  if ($conn->query($i)) {
    $esfpid = $conn->insert_id;
    $esfpid = hash('sha256', $secretKey.$esfpid);

    if (forgotPasswordEmail($es_email,$es_name,$esfpid)) {
      $ret["STATUS"] = true;
      $ret["MSG"] = "Email Telah Berjaya Dihantar ke $email";
    } else {
      $ret["STATUS"] = false;
      $ret["MSG"] = "Email Tidak Berjaya Dihantar ke $email. Sila hubungi pihak eCaque untuk bantuan (ERR-EM)";
    }
  } else {
    $ret["STATUS"] = false;
    $ret["MSG"] = "Email Tidak Berjaya Dihantar ke $email. Sila hubungi pihak eCaque untuk bantuan (ERR-INS)";
  }

  return $ret;
}

if($_POST["func"] == "getStokistDetail"){
  echo json_encode(getStokistDetail($_POST));
}

function getStokistDetail($data){
  global $conn;
  $esid = $_SESSION["AGENT"]["ID"];

  $s = "SELECT
  SHA2(es_id,256) as enc_id,
  es_id,
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
  es_rjan_id,
  es_rngra_id,
  es_dateregister,
  es_dateapproved,
  es_approvedby
  FROM e_stockist
  WHERE es_id = '$esid'";

  $arr = [];
  $result = $conn->query($s);
  while ($row = $result->fetch_assoc())
  {
    $arr[] = $row;
  }
  return $arr;
}

if($_POST["func"] == "updateProfile"){
  echo json_encode(updateProfile($_POST));
}

function updateProfile($data){
  global $conn;
  global $secretKey;
  global $cfg_salt;
  $addcol = "";
  $esid = $_SESSION["AGENT"]["ID"];

  if (isset($data["password"]) && isset($data["oldpassword"]) &&
      $data["password"] != "" && $data["oldpassword"] != "") {
    // CHANGE PASSWORD
    $password = $data["password"];
    $oldpassword = $data["oldpassword"];

    $s = "SELECT es_password FROM e_stockist WHERE es_id = $esid";
    $result = $conn->query($s);
    $row = $result->fetch_assoc();

    $oldpassword = $cfg_salt.$oldpassword;
    $oldpassword = hash('sha256', $oldpassword);

    $password = $cfg_salt.$password;
    $password = hash('sha256', $password);

    if ($row["es_password"] == $oldpassword) {
      $addcol = "es_password = '$password',";
    }
  }

  $fullname = $data["fullname"];
  // $identificationNo = $data["identificationNo"];
  $jantina = $data["jantina"];
  $nationality = $data["nationality"];
  $bangsa = $data["bangsa"];
  $alamat = $data["alamat"];
  $bandar = $data["bandar"];
  $negeri = $data["negeri"];
  $poskod = $data["poskod"];
  // $email = $data["email"];
  $phone = $data["phone"];
  $facebook = $data["facebook"];
  $instagram = $data["instagram"];
  $linkedin = $data["linkedin"];

  $i = "UPDATE e_stockist SET
    $addcol
    es_name = '$fullname',
    es_rktrn_id = '$bangsa',
    es_address = '$alamat',
    es_bandar = '$bandar',
    es_poskod = '$poskod',
    es_rngri_id = '$negeri',
    es_phone = '$phone',
    es_facebook = '$facebook',
    es_instagram = '$instagram',
    es_linkedin = '$linkedin',
    es_rjan_id = '$jantina',
    es_rngra_id = '$nationality'

  WHERE es_id = '$esid'";

  if ($conn->query($i)) {
    $ret["STATUS"] = true;
    $ret["MSG"] = "Profil Berjaya Dikemaskini";
  } else {
    $ret["STATUS"] = false;
    $ret["MSG"] = "Profil Tidak Berjaya Dikemaskini, sila hubungi pihak admin sistem";
  }

  return $ret;
}

if($_POST["func"] == "getDashboard"){
  echo json_encode(getDashboard($_POST));
}

function getDashboard($data){
  global $conn;
  $id= $_SESSION["AGENT"]["ID"];


  $s1 = "SELECT SUM(er_totalprice) as total FROM e_receipt WHERE er_payment_date IS NOT NULL AND er_devtest IS NULL AND er_es_id = $id";
  $s2 = "SELECT COUNT(er_id) as pendingpayment FROM e_receipt WHERE er_payment_date IS NULL AND er_devtest IS NULL AND er_es_id = $id";
  $s3 = "SELECT COUNT(er_id) as pendingdelivery FROM e_receipt WHERE er_payment_date IS NOT NULL AND er_packing_date IS NULL AND er_devtest IS NULL AND er_es_id = $id";
  $s4 = "SELECT COUNT(es_id) as agentCount FROM e_stockist WHERE es_status = 1001";
  $s5 = "SELECT COUNT(es_id) as agentCount FROM e_stockist WHERE es_status = 1000";

  $s = "SELECT
  ($s1) as s1,
  ($s2) as s2,
  ($s3) as s3,
  ($s4) as s4,
  ($s5) as s5
  ";

  $arr = [];
  $result = $conn->query($s);
  while ($row = $result->fetch_assoc())
  {
    $row["t1"] = getDashboardSales();
    $row["t2"] = getDashboardCakeNeeded();
    $arr[] = $row;
  }

  return $arr[0];
}

function getDashboardSales(){
  global $conn;
  $id= $_SESSION["AGENT"]["ID"];

  $s = "SELECT
  er_id,
	er_fullname,
	CONCAT(
	'INV-', DATE_FORMAT( er_date, '%Y' ), DATE_FORMAT( er_date, '%m' ), LPAD( er_id, 8, '0' ) ) AS invCode,
	DATE_FORMAT( er_payment_date, '%d-%m-%Y %h:%i' ) as paymentdate,
  (er_totalprice) as totalpayment
  FROM e_receipt
  LEFT JOIN e_stockist ON es_id = er_es_id
  WHERE er_payment_date IS NOT NULL AND er_devtest IS NULL AND er_es_id = $id ORDER BY er_payment_date DESC LIMIT 0,10";

  $arr = [];
  $result = $conn->query($s);

  $tablebody = "";
  while ($row = $result->fetch_assoc())
  {
    $code = $row["invCode"];
    $name = $row["er_fullname"];
    $total = $row["totalpayment"];
    $tablebody .= formatDashboardSalesTr($code,$name,$total);
    $arr[] = $row;
  }

  return $tablebody;
}

function getDashboardCakeNeeded(){
  global $conn;
  $id= $_SESSION["AGENT"]["ID"];

  $s = "SELECT rp_name, SUM(erd_quantity) as totalneeded FROM e_receipt_detail
  LEFT JOIN e_receipt ON er_id = erd_er_id
  LEFT JOIN ref_product ON rp_id = erd_rp_id
  WHERE
  er_payment_date IS NOT NULL AND er_packing_date IS NULL AND er_devtest IS NULL AND er_es_id = $id AND rp_status = 1
  GROUP BY rp_id";

  $arr = [];
  $result = $conn->query($s);

  $tablebody = "";
  while ($row = $result->fetch_assoc())
  {
    $code = $row["rp_name"];
    $name = $row["totalneeded"];
    $tablebody .= formatDashboardSalesTr2($code,$name);
    $arr[] = $row;
  }

  return $tablebody;
}

function formatDashboardSalesTr2($code,$total){
  return "
  <tr>
    <td class=\"font-montserrat all-caps fs-12 w-75\">$code</td>
    <td class=\"w-25 text-center\">
      <span class=\"font-montserrat fs-18 \"><b>$total</b></span>
    </td>
  </tr>";
}

function formatDashboardSalesTr($code,$name,$total){
  return "<tr>
    <td class=\"font-montserrat all-caps fs-12 w-50\">$code</td>
    <td class=\"text-right b-r b-dashed b-grey w-25\">
      <span class=\"hint-text small\">$name</span>
    </td>
    <td class=\"w-25 text-right\">
      <span class=\"font-montserrat fs-18 \"> <sup class=\"p-r-5\">MYR </sup><b>$total</b></span>
    </td>
  </tr>";
}
?>
