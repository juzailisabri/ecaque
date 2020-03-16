<?php
session_start();
include('conn.php');
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

    $q = "SELECT uu_password, uu_id, uu_email, uu_fullname, uu_status
    FROM u_user WHERE uu_email = '$mmemail'";
    $result = $conn->query($q);
    $number = $result->num_rows;
    $row = $result->fetch_assoc();

    if($number != 0){
      $status["AASTATUS"] = true;
      if($row["uu_status"] == 2){
        $status["AAS"] = false;
      } else if($row["uu_status"] == 1001){
          $status["AAS"] = true;
          $status["AASTATUS"] = true;
          $status["EV"] = true;
          if($row["uu_password"] == $password) {

            $uuid = $row["uu_id"];
            $status["AAP"] = true;
            $status["MSG"] = "";

            $_SESSION['ID'] = $row["uu_id"];
            $_SESSION['USERNAME'] = $row["uu_email"];
            $_SESSION['FULLNAME'] = $row["uu_fullname"];
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

if($_POST["func"] == "getStokist"){
  echo json_encode(getStokist($_POST));
}

function getStokist($data){
  global $conn;

  $columns = array(
    // datatable column index  => database column name
    0 => 'es_id',
    1 => 'es_name',
    2 => 'es_phone',
    3 => 'es_dateregister',
    4 => 'es_id'
  );

  $where = "";

  if (isset($data["negeri"]) && $data["negeri"] != '') {
    $where .= "AND es_rngri_id = ".$data["negeri"]." ";
  }

  if (isset($data["status"]) && $data["status"] != '') {
    $where .= "AND es_status = '".$data["status"]."' ";
  }

  $sql = "SELECT COUNT(es_id) as count FROM e_stockist WHERE TRUE $where";

  $result = $conn->query($sql);
  $row = $result->fetch_assoc();
  $numrows = $row["count"];
  $totalData = $numrows;

  $sql = "SELECT
  SHA2(es_id,256) as enc_id,
  es_id,
  es_name,
  es_icno,
  es_rktrn_id,
  es_address,
  es_bandar,
  es_poskod,
  rngri_name,
  es_email,
  es_phone,
  es_facebook,
  es_instagram,
  es_linkedin,
  es_dateregister,
  es_dateapproved,
  es_approvedby
  FROM e_stockist
  LEFT JOIN ref_negeri ON rngri_id = es_rngri_id
  WHERE TRUE $where
  ";

  if(!empty($data['search'])) {
    $search = $data['search'];
    $sql.=" AND (es_name  LIKE '%".$search."%' ";
    $sql.=" OR es_icno LIKE '%".$search."%'";
    $sql.=" OR es_email LIKE '%".$search."%')";

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
    $nestedData=array();
    $nestedData[] = $row["es_id"];
    $nestedData[] = $row["es_name"]."<br>".$row["es_icno"]."<br>".$row["es_email"]."<br>".$row["es_phone"]."<br>".$row["rngri_name"]."<br>".$row["es_dateregister"];
    $nestedData[] = $row["es_name"]."<br>".$row["es_icno"]."<br>";
    $nestedData[] = $row["es_email"]."<br>".$row["es_phone"]."<br>";
    $nestedData[] = $row["es_dateregister"];
    $nestedData[] = $row["rngri_name"];
    $nestedData[] = '
    <div class="btn-group row w-100">
      <div class="btn-group col-6 p-0">
        <button id="edituser" key="'.$row["enc_id"].'" type="button" class="btn btn-primary w-100">
          <span class="p-t-5 p-b-5">
          <i class="fa fa-edit fs-15"></i>
          </span>
        </button>
      </div>
      <div class="btn-group col-6 p-0">
        <button id="resetUser" key="'.$row["enc_id"].'" type="button" class="btn btn-danger w-100">
          <span class="p-t-5 p-b-5">
          <i class="fa fa-refresh fs-15"></i>
          </span>
        </button>
      </div>
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

if($_POST["func"] == "getStokistDetail"){
  echo json_encode(getStokistDetail($_POST));
}

function getStokistDetail($data){
  global $conn;
  $esid = $data["esid"];

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
  WHERE SHA2(es_id,256) = '$esid'";

  $arr = [];
  $result = $conn->query($s);
  while ($row = $result->fetch_assoc())
  {
    $arr[] = $row;
  }
  return $arr;
}

if($_POST["func"] == "insertStokist"){
  echo json_encode(insertStokist($_POST));
}

function insertStokist($data){
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

  if ($conn->query($i)) {
    $ret["STATUS"] = true;
    $ret["MSG"] = "Stokist Berjaya Didaftarkan, sila verify stokist dalam senarai pending verification";
  } else {
    $ret["STATUS"] = false;
    $ret["MSG"] = "Stokist Tidak Berjaya Didaftarkan, sila hubungi pihak admin sistem";
  }

  return $ret;
}

if($_POST["func"] == "updateStockist"){
  echo json_encode(updateStockist($_POST));
}

function updateStockist($data){
  global $conn;

  $esid = $data["esid"];
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

  $i = "UPDATE e_stockist SET

    es_name = '$fullname',
    es_icno = '$identificationNo',
    es_rktrn_id = '$bangsa',
    es_address = '$alamat',
    es_bandar = '$bandar',
    es_poskod = '$poskod',
    es_rngri_id = '$negeri',
    es_email = '$email',
    es_phone = '$phone',
    es_facebook = '$facebook',
    es_instagram = '$instagram',
    es_linkedin = '$linkedin',
    es_rjan_id = '$jantina',
    es_rngra_id = '$nationality'

  WHERE SHA2(es_id,256) = '$esid'";

  if ($conn->query($i)) {
    $ret["STATUS"] = true;
    $ret["MSG"] = "Stokist Berjaya Dikemaskini, sila verify stokist dalam senarai pending verification";
  } else {
    $ret["STATUS"] = false;
    $ret["MSG"] = "Stokist Tidak Berjaya Dikemaskini, sila hubungi pihak admin sistem";
  }

  return $ret;
}

if($_POST["func"] == "getStokistOrder"){
  echo json_encode(getStokistOrder($_POST));
}

function getStokistOrder($data){
  global $conn;

  $columns = array(
    // datatable column index  => database column name
    0 => 'eos_id',
    1 => 'es_name',
    2 => 'es_name',
    3 => 'es_email',
    4 => 'total',
    5 => 'eos_datepickup'
  );

  $where = "";

  if (isset($data["negeri"]) && $data["negeri"] != '') {
    $where .= "AND es_rngri_id = ".$data["negeri"]." ";
  }

  if (isset($data["status"]) && $data["status"] != '') {
    $where .= "AND es_status = '".$data["status"]."' ";
  }

  if (isset($data["statusOrder"]) && $data["statusOrder"] != '') {
    $where .= "AND eos_status = '".$data["statusOrder"]."' ";
  }

  $sql = "SELECT COUNT(eos_id) as count FROM e_orderstock  LEFT JOIN e_stockist ON es_id = eos_es_id WHERE TRUE $where";

  $result = $conn->query($sql);
  $row = $result->fetch_assoc();
  $numrows = $row["count"];
  $totalData = $numrows;

  $sql = "SELECT
  SHA2(es_id,256) as enc_id,
  SHA2(eos_id,256) as enc_id2,
  eos_id,
  es_id,
  es_name,
  es_icno,
  es_rktrn_id,
  es_address,
  es_bandar,
  es_poskod,
  rngri_name,
  es_email,
  es_phone,
  es_facebook,
  es_instagram,
  es_linkedin,
  es_dateregister,
  es_dateapproved,
  es_approvedby,
  eos_dateorder,
  eos_datepickup,
  (SELECT SUM(eosp_quantity) FROM e_orderstockproduct WHERE eosp_eos_id = eos_id) as quantity,
  (SELECT SUM(eosp_price * eosp_quantity) FROM e_orderstockproduct WHERE eosp_eos_id = eos_id) as total
  FROM e_orderstock
  LEFT JOIN e_stockist ON es_id = eos_es_id
  LEFT JOIN ref_negeri ON rngri_id = es_rngri_id
  WHERE TRUE $where
  ";

  if(!empty($data['search'])) {
    $search = $data['search'];
    $sql.=" AND (es_name  LIKE '%".$search."%' ";
    $sql.=" OR es_icno LIKE '%".$search."%'";
    $sql.=" OR es_email LIKE '%".$search."%')";

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

    $es_name = $row["es_name"];
    $es_icno = $row["es_icno"];
    $es_email = $row["es_email"];
    $es_phone = $row["es_phone"];
    $eos_quantity = $row["quantity"];
    $eos_dateorder = $row["eos_dateorder"];
    $eos_datepickup = $row["eos_datepickup"];
    $total = "RM ".$row["total"];
    $quantity = $row["quantity"];

    $nestedData=array();
    $nestedData[] = $row["eos_id"];
    $nestedData[] = "<b>$es_name</b><br>
    $es_phone<br>
    <sub>Quantity</sub><br>$eos_quantity Pieces<br>
    <sub>Order Date</sub><br>$eos_dateorder<br>
    <sub>Pickup Date</sub><br> $eos_datepickup";

    $nestedData[] = $row["es_name"]."<br>".$row["es_icno"]."<br>";
    $nestedData[] = $row["es_email"]."<br>".$row["es_phone"]."<br>";
    $nestedData[] = "$total <br> ($quantity pieces) ";
    $nestedData[] = "<small>Order Date</small><br>$eos_dateorder<br>
    <small>Pickup Date</small><br> $eos_datepickup";
    $nestedData[] = '

    <div class="btn-group row w-100">
      <div class="btn-group col-6 p-0">
        <button id="edituser" key="'.$row["enc_id"].'" type="button" class="btn btn-primary w-100">
          <span class="p-t-5 p-b-5">
          <i class="fa fa-user fs-15"></i>
          </span>
        </button>
      </div>
      <div class="btn-group col-6 p-0">
        <button id="editOrder" key="'.$row["enc_id2"].'" type="button" class="btn btn-success w-100">
          <span class="p-t-5 p-b-5">
          <i class="fa fa-edit fs-15"></i>
          </span>
        </button>
      </div>
    </div>
    <div class="row p-t-10">
      <b>'.$total.'</b>
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


if($_POST["func"] == "insertOrder"){
  echo json_encode(insertOrder($_POST));
}

function insertOrder($data){
  global $conn;

  $stokist = $data["stokist"];
  $orderDate = convertdate($data["orderDate"]);
  $pickupDate = convertdate($data["pickupDate"]);
  $JenisPenghantaran = $data["JenisPenghantaran"];
  (isset($data["tempatPenghantaran"]))?$tempatPenghantaran = $data["tempatPenghantaran"]:$tempatPenghantaran = "";
  (isset($data["tempatOthers"]))?$tempatOthers = $data["tempatOthers"]:$tempatOthers = "";
  (isset($data["deliveryCharges"]))?$deliveryCharges = $data["deliveryCharges"]:$deliveryCharges = 0;
  $rpid = $data["rpid"];
  $rpprice = $data["rpprice"];
  $quantity = $data["quantity"];
  $setStatus = $data["setStatus"];

  $i = "INSERT INTO e_orderstock (eos_es_id,eos_dateorder,eos_datepickup,eos_rjp_id,eos_rtp_id,eos_otherPlace,eos_deliveryCharges,eos_status)
  VALUES ('$stokist','$orderDate','$pickupDate','$JenisPenghantaran','$tempatPenghantaran','$tempatOthers',$deliveryCharges,'$setStatus')";

  if ($conn->query($i)) {
    $eosid = $conn->insert_id;

    foreach ($rpprice as $key => $value) {
      $vrpid = $rpid[$key];
      $vrpprice = $rpprice[$key];
      $vquantity = $quantity[$key];
      if ($vquantity > 0) {
        $insertvalue[$key] = "($vrpid,$eosid,$vquantity,1,$vrpprice)";
      }
    }

    $insertvalueStr = implode(",",$insertvalue);
    $i = "INSERT INTO e_orderstockproduct (eosp_rp_id,eosp_eos_id,eosp_quantity,eosp_status,eosp_price)
    VALUES $insertvalueStr";
    if ($conn->query($i)) {
      $ret["STATUS"] = true;
      $ret["MSG"] = "Pesanan Stokist Berjaya Didaftarkan, sila verify stokist dalam senarai pending verification";
    } else {
      $ret["STATUS"] = false;
      $ret["MSG"] = "[01]Pesanan Stokist Tidak Berjaya Didaftarkan, sila hubungi pihak admin sistem";
    }
  } else {
    $ret["STATUS"] = false;
    $ret["MSG"] = "[02]Pesanan Stokist Tidak Berjaya Didaftarkan, sila hubungi pihak admin sistem";
  }

  return $ret;
}

if($_POST["func"] == "updateOrderStock"){
  echo json_encode(updateOrderStock($_POST));
}

function updateOrderStock($data){
  global $conn;

  $changetable = $data["CHANGESTABLEPRODUCT"];
  $eosid = $data["eosid"];
  $stokist = $data["stokist"];
  $orderDate = convertdate($data["orderDate"]);
  $pickupDate = convertdate($data["pickupDate"]);
  $JenisPenghantaran = $data["JenisPenghantaran"];
  (isset($data["tempatPenghantaran"]))?$tempatPenghantaran = $data["tempatPenghantaran"]:$tempatPenghantaran = "";
  (isset($data["tempatOthers"]))?$tempatOthers = $data["tempatOthers"]:$tempatOthers = "";
  (isset($data["deliveryCharges"]))?$deliveryCharges = $data["deliveryCharges"]:$deliveryCharges = 0;
  $rpid = $data["rpid"];
  $rpprice = $data["rpprice"];
  $quantity = $data["quantity"];
  $setStatus = $data["setStatus"];

  $i = "UPDATE e_orderstock SET
  eos_es_id = '$stokist',
  eos_dateorder = '$orderDate',
  eos_datepickup = '$pickupDate',
  eos_rjp_id = '$JenisPenghantaran',
  eos_rtp_id = '$tempatPenghantaran',
  eos_otherPlace = '$tempatOthers',
  eos_deliveryCharges = $deliveryCharges,
  eos_status = '$setStatus'
  WHERE SHA2(eos_id,256) = '$eosid'";

  if ($conn->query($i)) {
    if ($changetable) {
      $eosidq = "SELECT eos_id FROM e_orderstock WHERE SHA2(eos_id,256) = '$eosid'";
      $d = "DELETE FROM e_orderstockproduct WHERE SHA2(eosp_eos_id,256) = '$eosid'";
      if ($conn->query($d)) {
        foreach ($rpprice as $key => $value) {
          $vrpid = $rpid[$key];
          $vrpprice = $rpprice[$key];
          $vquantity = $quantity[$key];
          if ($vquantity > 0) {
            $insertvalue[$key] = "($vrpid,($eosidq),$vquantity,1,$vrpprice)";
          }
        }

        $insertvalueStr = implode(",",$insertvalue);
        $i = "INSERT INTO e_orderstockproduct (eosp_rp_id,eosp_eos_id,eosp_quantity,eosp_status,eosp_price)
        VALUES $insertvalueStr";
        if ($conn->query($i)) {
          $ret["STATUS"] = true;
          $ret["MSG"] = "Pesanan Stokist Berjaya Dikemaskini, sila verify stokist dalam senarai pending verification";
        } else {
          $ret["STATUS"] = false;
          $ret["MSG"] = "[03] Pesanan Stokist Tidak Berjaya Dikemaskini, sila hubungi pihak admin sistem";
        }
      } else {
        $ret["STATUS"] = false;
        $ret["MSG"] = "[02D] Pesanan Stokist Tidak Berjaya Dikemaskini, sila hubungi pihak admin sistem";
      }
    } else {
      $ret["STATUS"] = true;
      $ret["MSG"] = "Pesanan Stokist Berjaya Dikemaskini, sila verify stokist dalam senarai pending verification";
    }
  } else {
    $ret["STATUS"] = false;
    $ret["MSG"] = "[01] Pesanan Stokist Tidak Berjaya Dikemaskini, sila hubungi pihak admin sistem";
  }

  return $ret;
}

if($_POST["func"] == "getStokistOrderDetail"){
  echo json_encode(getStokistOrderDetail($_POST));
}

function getStokistOrderDetail($data){
  global $conn;
  $eosid = $data["eosid"];

  $s = "SELECT
  SHA2(eos_id,256) as enc_id,
  eos_es_id,
  DATE_FORMAT(eos_dateorder,'%d-%m-%Y') as eos_dateorder,
  DATE_FORMAT(eos_datepickup,'%d-%m-%Y') as eos_datepickup,
  eos_rjp_id,
  eos_rtp_id,
  eos_otherPlace,
  eos_deliveryCharges,
  eos_status
  FROM e_orderstock
  WHERE SHA2(eos_id,256) = '$eosid'";

  $arr1 = [];
  $result = $conn->query($s);
  while ($row = $result->fetch_assoc())
  {
    $arr1[] = $row;
  }

  $s = "SELECT
  SHA2(eosp_id,256) as enc_id,
  eosp_rp_id,
  eosp_quantity,
  eosp_price
  FROM e_orderstockproduct
  WHERE SHA2(eosp_eos_id,256) = '$eosid'";

  $arr2 = [];
  $result = $conn->query($s);
  while ($row = $result->fetch_assoc())
  {
    $arr2[] = $row;
  }

  $arr["EOS"] = $arr1;
  $arr["EOSP"] = $arr2;

  return $arr;
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

if($_POST["func"] == "getStockRecord"){
  echo json_encode(getStockRecord($_POST));
}

function getStockRecord($data){
  global $conn;

  $columns = array(
    // datatable column index  => database column name
    0 => 'esr_id',
    1 => 'rp_name',
    2 => 'rp_name',
    3 => 'esr_datetime',
    4 => 'esr_quantity',
    5 => 'uu_fullname',
    6 => 'esr_id'
  );

  $where = "";

  $sql = "SELECT COUNT(esr_id) as count FROM e_stockrecord WHERE TRUE $where";

  $result = $conn->query($sql);
  $row = $result->fetch_assoc();
  $numrows = $row["count"];
  $totalData = $numrows;

  $sql = "SELECT
  SHA2(esr_id,256) as enc_id,
  esr_id,
  rp_name,
  esr_quantity,
  uu_fullname,
  esr_datetime
  FROM e_stockrecord
  LEFT JOIN ref_product ON rp_id = esr_rp_id
  LEFT JOIN u_user ON uu_id = esr_uu_id
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
    $esr_id = $row["esr_id"];
    $rp_name = $row["rp_name"];
    $esr_quantity = $row["esr_quantity"];
    $uu_fullname = $row["uu_fullname"];
    $esr_datetime = $row["esr_datetime"];

    $nestedData=array();
    $nestedData[] = $esr_id;
    $nestedData[] = "<b>$rp_name</b><br><sub>Quantity</sub><br>$esr_quantity Pieces
    <br><sub>Stock Keeper</sub><br>$uu_fullname";
    $nestedData[] = $rp_name;
    $nestedData[] = $esr_datetime;
    $nestedData[] = $esr_quantity;
    $nestedData[] = $uu_fullname;
    $nestedData[] = '
    <div class="btn-group row w-50">
      <div class="btn-group col-12 p-0">
        <button id="editStock" key="'.$row["enc_id"].'" type="button" class="btn btn-success w-100">
          <span class="p-t-5 p-b-5">
          <i class="fa fa-edit fs-15"></i>
          </span>
        </button>
      </div>
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

if($_POST["func"] == "insertStok"){
  echo json_encode(insertStok($_POST));
}

function insertStok($data){
  global $conn;

  $uuid = $_SESSION['ID'];

  $product = $data["product"];
  $quantity = $data["quantity"];

  $i = "INSERT INTO e_stockrecord
  (
    esr_rp_id,
    esr_quantity,
    esr_status,
    esr_uu_id,
    esr_datetime
  )
    VALUES
  (
    $product,
    $quantity,
    '3001',
    $uuid,
    NOW()
  )";

  if ($conn->query($i)) {
    $ret["STATUS"] = true;
    $ret["MSG"] = "Stok Berjaya Dimasukkan";
  } else {
    $ret["STATUS"] = false;
    $ret["MSG"] = "Stok Tidak Berjaya Dimasukkan, sila hubungi pihak admin sistem";
  }

  return $ret;
}

if($_POST["func"] == "updateStock"){
  echo json_encode(updateStock($_POST));
}

function updateStock($data){
  global $conn;

  $esrid = $data["esrid"];
  $uuid = $_SESSION['ID'];
  $product = $data["product"];
  $quantity = $data["quantity"];

  $i = "UPDATE e_stockrecord
  SET
    esr_rp_id = $product,
    esr_quantity = $quantity,
    esr_status = '3001',
    esr_uu_id = $uuid
  WHERE SHA2(esr_id,256) = '$esrid' ";

  if ($conn->query($i)) {
    $ret["STATUS"] = true;
    $ret["MSG"] = "Stok Berjaya Dikemaskini";
  } else {
    $ret["STATUS"] = false;
    $ret["MSG"] = "Stok Tidak Berjaya Dikemaskini, sila hubungi pihak admin sistem";
  }
  return $ret;
}

if($_POST["func"] == "getStockDetail"){
  echo json_encode(getStockDetail($_POST));
}

function getStockDetail($data){
  global $conn;
  $esrid = $data["esrid"];

  $s = "SELECT
  esr_rp_id,
  esr_quantity
  FROM e_stockrecord
  WHERE SHA2(esr_id,256) = '$esrid'";

  $arr = [];
  $result = $conn->query($s);
  while ($row = $result->fetch_assoc())
  {
    $arr[] = $row;
  }

  return $arr;
}
?>
