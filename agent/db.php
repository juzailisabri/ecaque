<?php
session_start();
include('../administrator/conn.php');
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

  $where = " AND er_es_id = $uid";

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

    $enc_id = $row["enc_id"];
    $er_fullname = $row["er_fullname"];
    $er_address = $row["er_address"];
    $er_phone = $row["er_phone"];
    $er_postage = $row["er_postage"];
    $er_totalprice = "RM ".$row["er_totalprice"];
    $er_trackingNo = $row["er_trackingNo"];
    $er_date = $row["er_date"];
    $linkid = $row["linkid"];
    $er_payment_date = $row["er_payment_date"];
    $er_packing_date = $row["er_packing_date"];

    $er_payment_dateC = colorFunction($er_payment_date,"text-success","text-muted");
    $er_packing_dateC = colorFunction($er_packing_date,"text-success","text-muted");

    $er_payment_dateCM = colorFunction($er_payment_date,"btn-success","btn-muted");
    $er_packing_dateCM = colorFunction($er_packing_date,"btn-success","btn-muted");

    $link = "receipt?oid=$linkid";

    $nestedData=array();
    $nestedData[] = $row["er_id"];
    $nestedData[] = "<b>$er_fullname</b><br>$er_phone<br>$er_address<br> <sub>Order Date</sub><br>$er_date<br>
                    <button id=\"\" class='btn $er_payment_dateCM btn-sm m-t-10'> <i class='fa fa-money'></i> </button>
                    <button id=\"\" class='btn $er_packing_dateCM btn-sm m-t-10'> <i class='fa fa-cubes'></i> </button>";
    $nestedData[] = "$er_fullname<br>$er_phone<br>$er_address<br>$er_date";
    $nestedData[] = "$er_totalprice ";
    $nestedData[] = "<i class=' $er_payment_dateC '> <i class='fa fa-check'></i> </button>";
    $nestedData[] = "<i class=' $er_packing_dateC '> <i class='fa fa-check'></i> </button>";
    $nestedData[] = '
    <div class="btn-group row w-100">
    <div class="btn-group col-12 p-0">
      <a href="'.$link.'" target="_blank"  class="btn btn-primary w-50">
        <span class="p-t-5 p-b-5">
        <i class="fa fa-edit fs-15"></i>
        </span>
      </a>
      <a href="makepayment?erid='.$enc_id.'" id="makepayment" key="'.$linkid.'" target="_blank"  class="btn btn-primary w-50">
        <span class="p-t-5 p-b-5">
        <i class="fa fa-money fs-15"></i>
        </span>
      </a>
    </div>

    </div>
    <div class="row p-t-10 visible-xs">
      <b>'.$er_totalprice.'</b>
    </div>';

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

  $total["gtotal"] = number_format($gtotal,2);
  $total["gtotalds"] = number_format($gtotalds,2);
  $total["postagetotal"] = number_format($postagetotal,2);
  $total["commision"] = number_format($gtotal - $gtotalds,2);
  $total["gtotalpayment"] = number_format($gtotal + $postagetotal,2);
  $total["gtotalpaymentPay"] = number_format($gtotalds + $postagetotal ,2);

  $arrset["arr"] = $arr;
  $arrset["totals"] = $total;

  return $arrset;
}

if($_POST["func"] == "makeOrder"){
  echo json_encode(makeOrder($_POST));
}

function makeOrder($data){
  global $conn;

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

?>
