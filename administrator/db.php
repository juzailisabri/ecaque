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

  $sql = "SELECT COUNT(es_id) as count FROM e_stockist WHERE TRUE ";

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
  WHERE TRUE
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

//
// function getPermohonanFormKaunter($data){
//   global $conn;
//   $icno = $data["icno"];
//
//   $s = "SELECT *,
//   (SELECT rngri_name FROM ref_negeri WHERE rngri_id = pt2_negeri_pemohon) as negeri_pemohon,
//   (SELECT rdae_name FROM ref_daerah WHERE rdae_id = pt2_daerah_pemohon) as daerah_pemohon,
//   (SELECT ript_name FROM ref_ipt WHERE ript_id = pt3_ins_ipts) as ipts,
//   (SELECT ript_name FROM ref_ipt WHERE ript_id = pt3_nama_institusi) as ipta,
//   SHA2(aap_id, 256) as enc_id
//
//   FROM a_applicant_permohonan
//   WHERE pt2_no_kp_pemohon = '$icno' AND status_permohonan = '0001' AND kaunter_application_stat = '1000'";
//
//   $arr = [];
//   $result = $conn->query($s);
//   while ($row = $result->fetch_assoc())
//   {
//     $aap_id = $row["aap_id"];
//     $jenis = $row["pt3_jenis_ipt"];
//     $university = "";
//     if ($jenis == '1') {
//       $university = $row["ipta"];
//     } else if ($jenis == '2') {
//       if($row["pt3_ins_ipts"] == "-1"){
//         $university = $row["pt3_ins_ipts_lain"];
//       } else {
//         $university = $row["ipts"];
//       }
//     } else if ($jenis == '3') {
//       $university = $row["pt3_ins_uln"];
//     }
//
//     $row["fulladdress"] = addCommaAddress($row["pt2_alamat_pemohon"]).addCommaAddress($row["pt2_alamat_pemohon2"]).addCommaAddress($row["pt2_alamat_pemohon3"]).($row["pt2_poskod_pemohon"])." ".addCommaAddress($row["daerah_pemohon"]).($row["negeri_pemohon"]);
//     $row["university"] =  $university;
//     $arr[] = $row;
//   }
//
//   return $arr;
// }
//
// if($_POST["func"] == "getPermohonanForm"){
//   $data["P"] = getPermohonanForm($_POST);
//   $data["A"] = getattachment($_POST);
//   $data["S"] = getStatusLog($_POST);
//   echo json_encode($data);
// }
//
// function addCommaAddress($data){
//   if(trim($data) != ""){
//     return $data.", <br>";
//   }
// }
//
// function getPermohonanForm($data){
//   global $conn;
//   $icno = $data["icno"];
//
//   $s = "SELECT *,
//   (SELECT rngri_name FROM ref_negeri WHERE rngri_id = pt2_negeri_pemohon) as negeri_pemohon,
//   (SELECT rdae_name FROM ref_daerah WHERE rdae_id = pt2_daerah_pemohon) as daerah_pemohon,
//   (SELECT ript_name FROM ref_ipt WHERE ript_id = pt3_ins_ipts) as ipts,
//   (SELECT ript_name FROM ref_ipt WHERE ript_id = pt3_nama_institusi) as ipta,
//   SHA2(aap_id, 256) as enc_id
//
//   FROM a_applicant_permohonan
//   WHERE pt2_no_kp_pemohon = '$icno'";
//
//   $arr = [];
//   $result = $conn->query($s);
//   while ($row = $result->fetch_assoc())
//   {
//     $aap_id = $row["aap_id"];
//     $jenis = $row["pt3_jenis_ipt"];
//     $university = "";
//     if ($jenis == '1') {
//       $university = $row["ipta"];
//     } else if ($jenis == '2') {
//       if($row["pt3_ins_ipts"] == "-1"){
//         $university = $row["pt3_ins_ipts_lain"];
//       } else {
//         $university = $row["ipts"];
//       }
//     } else if ($jenis == '3') {
//       $university = $row["pt3_ins_uln"];
//     }
//
//     $row["fulladdress"] = addCommaAddress($row["pt2_alamat_pemohon"]).addCommaAddress($row["pt2_alamat_pemohon2"]).addCommaAddress($row["pt2_alamat_pemohon3"]).($row["pt2_poskod_pemohon"])." ".addCommaAddress($row["daerah_pemohon"]).($row["negeri_pemohon"]);
//     $row["university"] =  $university;
//     $arr[] = $row;
//   }
//
//   return $arr;
// }
//
// function getStatusLog($data){
//   global $conn;
//   $icno = $data["icno"];
//
//   $s = "SELECT asl_id, rs_name, rs_icon, rs_color, uu_fullname, aa_fullname, asl_note, DATE_FORMAT(asl_datetime, '%h:%i %d/%m/%Y') as asl_datetime FROM a_status_log
//   LEFT JOIN u_user ON uu_id = asl_uu_id
//   LEFT JOIN a_applicant ON aa_id = asl_aa_id
//   LEFT JOIN ref_status ON rs_id = asl_rs_id
//   WHERE asl_aap_id = (SELECT aap_id FROM a_applicant_permohonan WHERE pt2_no_kp_pemohon =  '$icno' LIMIT 0,1) ORDER BY asl_id";
//
//   $arr = [];
//   $result = $conn->query($s);
//   while ($row = $result->fetch_assoc())
//   {
//     $row["div"] = statusDiv($row);
//     $arr[] = $row;
//   }
//
//   return $arr;
// }
//
// function statusDiv($data){
//   $rs_color = $data["rs_color"];
//   $rs_icon = $data["rs_icon"];
//   $fullname = '';
//   $uu_fullname = $data["uu_fullname"];
//   $aa_fullname= $data["aa_fullname"];
//   if($uu_fullname == null){
//     $fullname = '<b>(PEMOHON)</b> '.$aa_fullname;
//   } else {
//     $fullname = $uu_fullname;
//   }
//   $rs_name = $data["rs_name"];
//   $asl_datetime = $data["asl_datetime"];
//   $aslnote = nl2br($data["asl_note"]);
//
//   $html = "
//   <div class='col-lg-12 p-t-10'>
//     <div class='d-flex'>
//       <span id='permohonanDihantar' type='icon-color' class='icon-thumbnail bg-$rs_color pull-left text-white'> <i id='' type='icon' class='fa fa-$rs_icon'></i> </span>
//       <div class='flex-1 full-width overflow-ellipsis'>
//         <p class='hint-text all-caps font-montserrat  small no-margin overflow-ellipsis '>$fullname</p>
//         <h6 class='no-margin overflow-ellipsis ' id='permohonanDihantar' type='status'>$rs_name</h6>
//         <p>$aslnote</p>
//         <small id='permohonanDihantar' type='date'>$asl_datetime</small>
//       </div>
//       </div>
//       <hr>
//   </div>";
//
//   return $html;
// }
//
// if($_POST["func"] == "getPermohonanFormStatus"){
//   $data["P"] = getPermohonanFormStatus($_POST);
//   // $data["A"] = getattachment($_POST);
//   echo json_encode($data);
// }
//
// function getPermohonanFormStatus($data){
//   global $conn;
//   $icno = $data["icno"];
//
//   $ss = "SELECT * FROM ref_status";
//   $result = $conn->query($ss);
//
//   $statusdb[""] = [];
//   while ($row = $result->fetch_assoc()) {
//     $statusdb[$row["rs_id"]] = $row;
//   }
//
//   $s = "SELECT
//   pt2_nama_pemohon, pt2_no_kp_pemohon, pt2_no_telefon_pemohon, pt2_emel_pemohon, pt2_no_hp_pemohon,
//   pt3_jenis_ipt, pt3_ins_ipts, pt3_ins_ipts_lain, pt3_ins_uln,
//   pt2_alamat_pemohon, pt2_alamat_pemohon2, pt2_alamat_pemohon3, pt2_poskod_pemohon,
//   status_permohonan, kaunter_document_stat, kaunter_application_stat,
//   penyedia_stat, penyemak_stat, pelulus_stat, pembayaran_hpipt_stat, pembayaran_sd_stat,
//   tarikh_permohonan, kaunter_date, penyedia_date, penyemak_date, pelulus_date,
//   pembayaran_hpipt_date, pembayaran_sd_date,
//   (SELECT rngri_name FROM ref_negeri WHERE rngri_id = pt2_negeri_pemohon) as negeri_pemohon,
//   (SELECT rdae_name FROM ref_daerah WHERE rdae_id = pt2_daerah_pemohon) as daerah_pemohon,
//   (SELECT ript_name FROM ref_ipt WHERE ript_id = pt3_ins_ipts) as ipts,
//   (SELECT ript_name FROM ref_ipt WHERE ript_id = pt3_nama_institusi) as ipta,
//   SHA2(aap_id, 256) as enc_id
//
//   FROM a_applicant_permohonan
//   WHERE pt2_no_kp_pemohon = '$icno'";
//
//   $arr = [];
//   $result = $conn->query($s);
//   while ($row = $result->fetch_assoc())
//   {
//     $jenis = $row["pt3_jenis_ipt"];
//     $university = "";
//     if ($jenis == '1') {
//       $university = $row["ipta"];
//     } else if ($jenis == '2') {
//       if($row["pt3_ins_ipts"] == "-1"){
//         $university = $row["pt3_ins_ipts_lain"];
//       } else {
//         $university = $row["ipts"];
//       }
//     } else if ($jenis == '3') {
//       $university = $row["pt3_ins_uln"];
//     }
//
//     $row["status_permohonan"] = $statusdb[$row["status_permohonan"]];
//     $row["kaunter_document_stat"] = $statusdb[$row["kaunter_document_stat"]];
//     $row["kaunter_application_stat"] = $statusdb[$row["kaunter_application_stat"]];
//     $row["penyedia_stat"] = $statusdb[$row["penyedia_stat"]];
//     $row["penyemak_stat"] = $statusdb[$row["penyemak_stat"]];
//     $row["pelulus_stat"] = $statusdb[$row["pelulus_stat"]];
//     $row["pembayaran_hpipt_stat"] = $statusdb[$row["pembayaran_hpipt_stat"]];
//     $row["pembayaran_sd_stat"] = $statusdb[$row["pembayaran_sd_stat"]];
//
//     $row["fulladdress"] = addCommaAddress($row["pt2_alamat_pemohon"]).addCommaAddress($row["pt2_alamat_pemohon2"]).addCommaAddress($row["pt2_alamat_pemohon3"]).($row["pt2_poskod_pemohon"])." ".addCommaAddress($row["daerah_pemohon"]).($row["negeri_pemohon"]);
//     $row["university"] =  $university;
//     $arr[] = $row;
//   }
//   return $arr;
// }
//
// if($_POST["func"] == "getPermohonanFormCounter"){
//   $permohonan = getPermohonanFormCounter($_POST);
//   $data["P"] = $permohonan["DATA"];
//   $data["STATUS"] = $permohonan["UPDATE"];
//   $data["A"] = getattachment($_POST);
//   echo json_encode($data);
// }
//
// function getPermohonanFormCounter($data){
//   global $conn;
//   $icno = $data["icno"];
//
//   $s = "SELECT *, SHA2(aap_id, 256) as enc_id
//
//   FROM a_applicant_permohonan
//   WHERE pt2_no_kp_pemohon = '$icno' AND status_permohonan = '0001'";
//
//   $arr = [];
//   $result = $conn->query($s);
//   $row = $result->fetch_assoc();
//   $arr[] = $row;
//
//   $status["UPDATE"] = true;
//   if($row["kaunter_application_stat"] == "1000"){
//     $status["UPDATE"] = true;
//   } else if ($row["kaunter_application_stat"] == "1001" || $row["kaunter_application_stat"] == "1002" || $row["kaunter_application_stat"] == "1003"){
//     $status["UPDATE"] = false;
//   }
//   $status["DATA"] = $arr;
//
//   return $status;
// }
//
// function getattachment($data){
//   global $conn;
//   $icno = $data["icno"];
//
//   $sid = "SELECT aa_id FROM a_applicant WHERE aa_username = '$icno'";
//   $result = $conn->query($sid);
//   $row = $result->fetch_assoc();
//   $aaid = $row["aa_id"];
//
//   $s = "SELECT *, SHA2(apa_id, 256) as enc_id
//   FROM a_permohonan_attach
//   WHERE apa_aa_id = '$aaid'";
//
//   $arr = [];
//   $result = $conn->query($s);
//   while ($row = $result->fetch_assoc())
//   {
//     $filename = $row["apa_rename"];
//     $row["url"] = "../attachment/$icno/$filename";
//     $arr[] = $row;
//   }
//   return $arr;
// }
//
// if($_POST["func"] == "c-readStatus"){
//   echo json_encode(cReadStatus($_POST));
// }
//
// function cReadStatus($data){
//   global $conn;
//   $s = "SELECT sc_name, sc_status, sc_note FROM s_config WHERE sc_id = 1";
//   $arr = [];
//   $result = $conn->query($s);
//   while ($row = $result->fetch_assoc())
//   {
//     $arr[] = $row;
//   }
//   return $arr;
// }
//
// if($_POST["func"] == "cUpdateSysStatus"){
//   echo json_encode(cUpdateSysStatus($_POST));
// }
//
// function cUpdateSysStatus($data){
//   global $conn;
//
//   $id = $_SESSION["ID"];
//
//   $note = $data["s-note"];
//   $statusstr = $data["s-status"];
//
//   $u = "UPDATE s_config SET
//   sc_status = '$statusstr',
//   sc_note = '$note'
//   WHERE sc_id = 1";
//
//   if ($conn->query($u)) {
//     $status["STATUS"] = true;
//   } else {
//     $status["STATUS"] = false;
//   }
//
//   return $status;
// }
//
//
// if($_POST["func"] == "kaunterDecision"){
//   echo json_encode(kaunterDecision($_POST));
// }
//
// function kaunterDecision($data){
//   global $conn;
//
//   $id = $_SESSION["ID"];
//
//   $aapid = $data["aapid"];
//   $dokumenradio = $data["dokumenradio"];
//   $DokumenSebab = $data["DokumenSebab"];
//   $statusresult = $data["statusresult"];
//   $Tidaklayaksebab = $data["Tidaklayaksebab"];
//
//   // SHA2(aap_id, 256)
//
//   $u = "UPDATE a_applicant_permohonan SET
//   kaunter_document_stat = '$dokumenradio',
//   kaunter_document_note = '$DokumenSebab',
//   kaunter_application_stat = '$statusresult',
//   kaunter_application_note = '$Tidaklayaksebab',
//   kaunter_uu_id = '$id',
//   kaunter_date = NOW()
//   WHERE SHA2(aap_id, 256) = '$aapid'";
//
//   if ($conn->query($u)) {
//     $status["STATUS"] = true;
//     $status["STATUSLOG"] = adminLog($aapid, $DokumenSebab, $dokumenradio);
//     $status["STATUSLOG2"] = adminLog($aapid, $Tidaklayaksebab, $statusresult);
//   } else {
//     $status["STATUS"] = false;
//     $status["STATUSLOG"] = false;
//     $status["STATUSLOG2"] = false;
//   }
//
//   return $status;
// }
//
// if($_POST["func"] == "penyedia-return"){
//   echo json_encode(penyediaReturn($_POST));
// }
//
// function penyediaReturn($data){
//   global $conn;
//
//   $id = $_SESSION["ID"];
//
//   $aapid = $data["AAP"];
//   $notes = $data["decnotes"];
//   $returnstatus = "2003";
//   // SHA2(aap_id, 256)
//
//   $u = "UPDATE a_applicant_permohonan SET
//   penyedia_return_stat = '$returnstatus',
//   penyedia_return_note = '$notes',
//   penyedia_uu_id = '$id',
//   penyedia_return_date = NOW()
//   WHERE SHA2(aap_id, 256) = '$aapid'";
//
//   if ($conn->query($u)) {
//     $status["STATUS"] = true;
//     $status["STATUSLOG"] = adminLog($aapid, $notes, $returnstatus);
//
//     $icno = "SELECT pt2_no_kp_pemohon FROM a_applicant_permohonan WHERE SHA2(aap_id, 256) = '$aapid'";
//     $s = "SELECT aa_username, aa_fullname as name, aa_email as email, SHA2(aa_id,256) as aa_id,
//     SHA2(aa_email,256) as aa_email, penyedia_return_note FROM a_applicant
//     LEFT JOIN a_applicant_permohonan ON pt2_no_kp_pemohon = aa_username
//     WHERE aa_username = ($icno)";
//     $result = $conn->query($s);
//     $row = $result->fetch_assoc();
//
//     $aaid = $row["aa_id"]; // ENCRYPTED EMAIL AND ID
//     $email = $row["aa_email"]; // ENCRYPTED EMAIL AND ID
//     $toname = $row["name"];
//     $toemail = $row["email"];
//     $toemail = $row["email"];
//     $ic = $row["aa_username"];
//     $note = $row["penyedia_return_note"];
//
//     $status["EMAILSTATUS"] = returnForm($aaid,$email,$toname,$toemail,$ic,$note);
//   } else {
//     $status["STATUS"] = false;
//   }
//   return $status;
// }
//
// if($_POST["func"] == "penyedia-sokongLayak"){
//   echo json_encode(penyediaSokongLayak($_POST));
// }
//
// function penyediaSokongLayak($data){
//   global $conn;
//
//   $id = $_SESSION["ID"];
//
//   $aapid = $data["AAP"];
//   $notes = $data["decnotes"];
//   $statuschange = "2001";
//   // SHA2(aap_id, 256)
//   $u = "UPDATE a_applicant_permohonan SET
//   penyedia_stat = '$statuschange',
//   penyedia_note = '$notes',
//   penyedia_uu_id = '$id',
//   penyedia_date = NOW()
//   WHERE SHA2(aap_id, 256) = '$aapid'";
//
//   if ($conn->query($u)) {
//     $status["STATUS"] = true;
//     $status["STATUSLOG"] = adminLog($aapid, $notes, $statuschange);
//   } else {
//     $status["STATUS"] = false;
//   }
//   return $status;
// }
//
// if($_POST["func"] == "penyedia-sokongTidakLayak"){
//   echo json_encode(penyediaSokongTidakLayak($_POST));
// }
//
// function penyediaSokongTidakLayak($data){
//   global $conn;
//
//   $id = $_SESSION["ID"];
//
//   $aapid = $data["AAP"];
//   $notes = $data["decnotes"];
//   $statuschange = "2002";
//   // SHA2(aap_id, 256)
//   $u = "UPDATE a_applicant_permohonan SET
//   penyedia_stat = '$statuschange',
//   penyedia_note = '$notes',
//   penyedia_uu_id = '$id',
//   penyedia_date = NOW()
//   WHERE SHA2(aap_id, 256) = '$aapid'";
//
//   if ($conn->query($u)) {
//     $status["STATUS"] = true;
//     $status["STATUSLOG"] = adminLog($aapid, $notes, $statuschange);
//   } else {
//     $status["STATUS"] = false;
//   }
//   return $status;
// }
//
// if($_POST["func"] == "penyemak-sokongTidakLayak"){
//   echo json_encode(penyemakSokongTidakLayak($_POST));
// }
//
// function penyemakSokongTidakLayak($data){
//   global $conn;
//
//   $id = $_SESSION["ID"];
//
//   $aapid = $data["AAP"];
//   $notes = $data["decnotes"];
//   $statuschange = "3002";
//   // SHA2(aap_id, 256)
//   $u = "UPDATE a_applicant_permohonan SET
//   penyemak_stat = '$statuschange',
//   penyemak_note = '$notes',
//   penyemak_uu_id = '$id',
//   penyemak_date = NOW()
//   WHERE SHA2(aap_id, 256) = '$aapid'";
//
//   if ($conn->query($u)) {
//     $status["STATUS"] = true;
//     $status["STATUSLOG"] = adminLog($aapid, $notes, $statuschange);
//   } else {
//     $status["STATUS"] = false;
//   }
//   return $status;
// }
//
// if($_POST["func"] == "penyemak-sokongLayak"){
//   echo json_encode(penyemakSokongLayak($_POST));
// }
//
// function penyemakSokongLayak($data){
//   global $conn;
//
//   $id = $_SESSION["ID"];
//
//   $aapid = $data["AAP"];
//   $notes = $data["decnotes"];
//   $statuschange = "3001";
//   // SHA2(aap_id, 256)
//   $u = "UPDATE a_applicant_permohonan SET
//   penyemak_stat = '$statuschange',
//   penyemak_note = '$notes',
//   penyemak_uu_id = '$id',
//   penyemak_date = NOW()
//   WHERE SHA2(aap_id, 256) = '$aapid'";
//
//   if ($conn->query($u)) {
//     $status["STATUS"] = true;
//     $status["STATUSLOG"] = adminLog($aapid, $notes, $statuschange);
//   } else {
//     $status["STATUS"] = false;
//   }
//   return $status;
// }
//
// if($_POST["func"] == "pelulus-sokongLayak"){
//   echo json_encode(pelulusSokongLayak($_POST));
// }
//
// function pelulusSokongLayak($data){
//   global $conn;
//
//   $id = $_SESSION["ID"];
//   $aapid = $data["AAP"];
//   $notes = $data["decnotes"];
//   $statuschange = "4001";
//   // SHA2(aap_id, 256)
//   $u = "UPDATE a_applicant_permohonan SET
//   pelulus_stat = '$statuschange',
//   pelulus_note = '$notes',
//   pelulus_uu_id = '$id',
//   pelulus_date = NOW()
//   WHERE SHA2(aap_id, 256) = '$aapid'";
//
//   if ($conn->query($u)) {
//     $status["STATUS"] = true;
//     $status["STATUSLOG"] = adminLog($aapid, $notes, $statuschange);
//
//     $icno = "SELECT pt2_no_kp_pemohon FROM a_applicant_permohonan WHERE SHA2(aap_id, 256) = '$aapid'";
//     $s = "SELECT aa_username, aa_fullname as name, aa_email as email, SHA2(aa_id,256) as aa_id,
//     SHA2(aa_email,256) as aa_email, penyedia_return_note , DATE_FORMAT(pelulus_date,'%d/%m/%Y') as pelulus_date,
//     ipt.ript_sd as iptasd, bipt.ript_sd as iptssd, rbnk_name, pt2_no_akaun, pt3_jenis_ipt
//     FROM a_applicant
//     LEFT JOIN a_applicant_permohonan ON pt2_no_kp_pemohon = aa_username
//     LEFT JOIN ref_ipt ipt ON ipt.ript_id = pt3_nama_institusi
//     LEFT JOIN ref_ipt bipt ON bipt.ript_id = pt3_ins_ipts
//     LEFT JOIN ref_bank ON rbnk_id = pt2_nama_bank
//     WHERE aa_username = ($icno)";
//     $result = $conn->query($s);
//     $row = $result->fetch_assoc();
//
//     $aaid = $row["aa_id"]; // ENCRYPTED EMAIL AND ID
//     $email = $row["aa_email"]; // ENCRYPTED EMAIL AND ID
//     $toname = $row["name"];
//     $toemail = $row["email"];
//     $toemail = $row["email"];
//     $ic = $row["aa_username"];
//     $pelulus_date = $row["pelulus_date"];
//     $pt3_jenis_ipt = $row["pt3_jenis_ipt"];
//     $iptasd = $row["iptasd"];
//     $iptssd = $row["iptssd"];
//     $rbnk_name = $row["rbnk_name"];
//     $pt2_no_akaun = $row["pt2_no_akaun"];
//
//     if($pt3_jenis_ipt == 1){
//       $sd = $iptasd;
//     } else if ($pt3_jenis_ipt == 2){
//       $sd = $iptssd;
//     }
//
//     if ($sd == '' || $sd == null || $sd == "0") {
//       $u = "UPDATE a_applicant_permohonan SET pembayaran_sd_stat = '6003' WHERE SHA2(aap_id, 256) = '$aapid'";
//       if ($conn->query($u)) {
//         $status["STATUSSD"] = true;
//         $status["STATUSSDMSG"] = "SD Tidak Layak";
//       } else {
//         $status["STATUSSD"] = false;
//         $status["STATUSSDMSG"] = "Status Gagal Dikemaskini";
//       }
//     }
//
//     $status["EMAILSTATUS"] = lulusHPIPT($aaid,$email,$toname,$toemail,$ic,$pelulus_date,$sd,$rbnk_name,$pt2_no_akaun);
//   } else {
//     $status["STATUS"] = false;
//   }
//   return $status;
// }
//
// if($_POST["func"] == "pelulus-sokongTidakLayak"){
//   echo json_encode(pelulusSokongTidakLayak($_POST));
// }
//
// function pelulusSokongTidakLayak($data){
//   global $conn;
//
//   $id = $_SESSION["ID"];
//
//   $aapid = $data["AAP"];
//   $notes = $data["decnotes"];
//   $statuschange = "4002";
//   // SHA2(aap_id, 256)
//   $u = "UPDATE a_applicant_permohonan SET
//   pelulus_stat = '$statuschange',
//   pelulus_note = '$notes',
//   pelulus_uu_id = '$id',
//   pelulus_date = NOW()
//   WHERE SHA2(aap_id, 256) = '$aapid'";
//
//   if ($conn->query($u)) {
//     $icno = "SELECT pt2_no_kp_pemohon FROM a_applicant_permohonan WHERE SHA2(aap_id, 256) = '$aapid'";
//     $s = "SELECT aa_username, aa_fullname as name, aa_email as email, SHA2(aa_id,256) as aa_id,
//     SHA2(aa_email,256) as aa_email, penyedia_return_note , DATE_FORMAT(pelulus_date,'%d/%m/%Y') as pelulus_date,
//     ipt.ript_sd as iptasd, bipt.ript_sd as iptssd, rbnk_name, pt2_no_akaun, pt3_jenis_ipt, pelulus_note
//     FROM a_applicant
//     LEFT JOIN a_applicant_permohonan ON pt2_no_kp_pemohon = aa_username
//     LEFT JOIN ref_ipt ipt ON ipt.ript_id = pt3_nama_institusi
//     LEFT JOIN ref_ipt bipt ON bipt.ript_id = pt3_ins_ipts
//     LEFT JOIN ref_bank ON rbnk_id = pt2_nama_bank
//     WHERE aa_username = ($icno)";
//     $result = $conn->query($s);
//     $row = $result->fetch_assoc();
//
//     $aaid = $row["aa_id"]; // ENCRYPTED EMAIL AND ID
//     $email = $row["aa_email"]; // ENCRYPTED EMAIL AND ID
//     $toname = $row["name"];
//     $toemail = $row["email"];
//     $toemail = $row["email"];
//     $ic = $row["aa_username"];
//     $pelulus_date = $row["pelulus_date"];
//     $pt3_jenis_ipt = $row["pt3_jenis_ipt"];
//     $iptasd = $row["iptasd"];
//     $iptssd = $row["iptssd"];
//     $rbnk_name = $row["rbnk_name"];
//     $pt2_no_akaun = $row["pt2_no_akaun"];
//     $pelulus_note = $row["pelulus_note"];
//
//     if($pt3_jenis_ipt == 1){
//       $sd = $iptasd;
//     } else if ($pt3_jenis_ipt == 2){
//       $sd = $iptssd;
//     }
//
//     $status["EMAILSTATUS"] = tidakLayakHPIPT($aaid,$email,$toname,$toemail,$ic,$pelulus_date,$sd,$rbnk_name,$pt2_no_akaun,$pelulus_note);
//     $status["STATUS"] = true;
//     $status["STATUSLOG"] = adminLog($aapid, $notes, $statuschange);
//   } else {
//     $status["STATUS"] = false;
//   }
//   return $status;
// }
//
// function adminLog($aapid, $notes,$statcode){
//   global $conn;
//   $uuid = $_SESSION['ID'];
//
//   $s = "SELECT aap_id FROM a_applicant_permohonan WHERE SHA2(aap_id, 256) = '$aapid'";
//   $result = $conn->query($s);
//   $row = $result->fetch_assoc();
//
//   $aap_id = $row["aap_id"];
//
//   $i = "INSERT INTO a_status_log
//   (asl_aap_id, asl_uu_id, asl_note, asl_rs_id, asl_datetime)
//   VALUES ('$aap_id','$uuid','$notes','$statcode',NOW())";
//
//   if($conn->query($i)){
//     $status = true;
//   } else {
//     $status = false;
//   }
//   return $status;
// }
//
// function AdminMultipleLog($ppbid,$statchange){
//   global $conn;
//   $id = $_SESSION["ID"];
//
//   $ppbid = "SELECT ppb_id FROM p_payment_baucar WHERE SHA2(ppb_id,256) = '$ppbid'";
//   $select = "SELECT aap_id, '$id', '', '$statchange', NOW() FROM a_applicant_permohonan WHERE pembayaran_ppb_id = ($ppbid)";
//   $i = "INSERT INTO a_status_log
//   (asl_aap_id, asl_uu_id, asl_note, asl_rs_id, asl_datetime)
//   $select";
//
//   if($conn->query($i)){
//     $status = true;
//   } else {
//     $status = false;
//   }
//
//   return $status;
// }
//
// function AdminMultipleLogSD($ppbsdid,$statchange){
//   global $conn;
//
//   $id = $_SESSION["ID"];
//
//   $ppbsdid = "SELECT ppbsd_id FROM p_payment_baucar_sd WHERE SHA2(ppbsd_id,256) = '$ppbsdid'";
//   $select = "SELECT aap_id, '$id', '', '$statchange', NOW() FROM a_applicant_permohonan WHERE pembayaran_ppbsd_id = ($ppbsdid)";
//   $i = "INSERT INTO a_status_log
//   (asl_aap_id, asl_uu_id, asl_note, asl_rs_id, asl_datetime)
//   $select";
//
//   if($conn->query($i)){
//     $status = true;
//   } else {
//     $status = false;
//   }
//
//   return $status;
// }
//
// function badge($color,$icon,$status){
//    return '<span id="test" class="m-t-10 badge badge-'.$color.' badge-lg p-l-20 p-r-20"><i class="fa fa-'.$icon.' m-r-5"></i> '.$status.'</span>';
// }
//
// if($_POST["func"] == "counter-getlayak"){
//   echo json_encode(countergetlayak($_POST));
// }
//
// function countergetlayak($data){
//   global $conn;
//
//   $columns = array(
//     // datatable column index  => database column name
//     0 => 'aap_id',
//     1 => 'pt2_nama_pemohon',
//     2 => 'tarikh_permohonan',
//     3 => 'uu_fullname',
//     4 => 'kaunter_application_stat',
//     5 => 'kaunter_application_stat'
//   );
//
//   $kaunterStat = $data["kaunterStat"];
//
//   $sql = "SELECT aap_id, pt2_nama_pemohon, pt2_no_kp_pemohon,
//   DATE_FORMAT(tarikh_permohonan, '%d-%m-%Y') as tarikh_permohonan, uu_fullname, kaunter_application_stat,
//   rs_color, rs_name, rs_icon, pt2_no_kp_pemohon as enc_id
//   FROM a_applicant_permohonan
//   LEFT JOIN u_user ON kaunter_uu_id = uu_id
//   LEFT JOIN ref_status ON kaunter_application_stat = rs_id
//   WHERE kaunter_application_stat = '$kaunterStat' ";
//
//   $result = $conn->query($sql);
//   $numrows = $result->num_rows;
//   $totalData = $numrows;
//   $totalFiltered = $totalData;
//
//   if(!empty($data['search']['value'])) {
//     $search = $data['search']['value'];
//     $sql.=" AND (pt2_nama_pemohon  LIKE '%".$search."%' ";
//     $sql.=" OR pt2_no_kp_pemohon  LIKE '%".$search."%' ";
//     $sql.=" OR uu_fullname  LIKE '%".$search."%') ";
//
//     $sql.=" ORDER BY ". $columns[$data['order'][0]['column']]." ".$data['order'][0]['dir']." LIMIT ".$data['start']." ,".$data['length']."   ";
//
//     $result = $conn->query($sql);
//     $numrows = $result->num_rows;
//     $totalFiltered = $numrows;
//   } else {
//     $sql.=" ORDER BY ". $columns[$data['order'][0]['column']]." ".$data['order'][0]['dir']." LIMIT ".$data['start']." ,".$data['length']."   ";
//     $result = $conn->query($sql);
//     $numrows = $result->num_rows;
//     $totalFiltered = $numrows;
//   }
//
//   $datadb = array();
//   while ($row = $result->fetch_assoc()) {
//     $nestedData=array();
//     $nestedData[] = $row["aap_id"];
//     $nestedData[] = $row["pt2_nama_pemohon"]."<br>".$row["pt2_no_kp_pemohon"];
//     $nestedData[] = $row["uu_fullname"];
//     $nestedData[] = $row["tarikh_permohonan"];
//     $nestedData[] = badge($row["rs_color"],$row["rs_icon"],$row["rs_name"]);
//     $nestedData[] = "<button class='btn btn-primary btn-block' id='view' icno='".$row["pt2_no_kp_pemohon"]."'>View</button>";
//     $datadb[] = $nestedData;
//   }
//
//   error_log(print_r($data,true),0);
//
//   $json_data = array(
//     "draw"            => intval( $data['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw.
//     "recordsTotal"    => intval( $totalFiltered),  // total number of records
//     "recordsFiltered" => intval( $totalData ), // total number of records after searching, if there is no searching then totalFiltered = totalData
//     "data"            => $datadb   // total data array
//   );
//
//   return $json_data;
// }
//
// if($_POST["func"] == "penyedia-getLayak"){
//   echo json_encode(getPenyediaInbox($_POST,'1001'));
// }
//
// if($_POST["func"] == "penyedia-gettidakLengkap"){
//   echo json_encode(getPenyediaInbox($_POST,'1002'));
// }
//
// if($_POST["func"] == "penyedia-getTidakLayak"){
//   echo json_encode(getPenyediaInbox($_POST,'1003'));
// }
//
// function getPenyediaInbox($data,$statusKaunter){
//   global $conn;
//
//   $columns = array(
//     // datatable column index  => database column name
//     0 => 'aap_id',
//     1 => 'pt2_nama_pemohon',
//     2 => 'tarikh_permohonan',
//     3 => 'uu_fullname',
//     4 => 'kaunter_application_stat',
//     5 => 'kaunter_application_stat'
//   );
//   // $kaunterStat = $data["kaunterStat"];
//
//   $sql = "SELECT aap_id, pt2_nama_pemohon, pt2_no_kp_pemohon,
//   DATE_FORMAT(tarikh_permohonan, '%d-%m-%Y') as tarikh_permohonan, uu_fullname, kaunter_application_stat,
//   rs_color, rs_name, rs_icon, pt2_no_kp_pemohon as enc_id
//   FROM a_applicant_permohonan
//   LEFT JOIN u_user ON kaunter_uu_id = uu_id
//   LEFT JOIN ref_status ON kaunter_application_stat = rs_id
//   WHERE (kaunter_application_stat = '$statusKaunter' AND penyedia_stat = '2000') AND penyedia_return_stat != '2003'";
//
//   $result = $conn->query($sql);
//   $numrows = $result->num_rows;
//   $totalData = $numrows;
//   $totalFiltered = $totalData;
//
//   if(!empty($data['search']['value'])) {
//     $search = $data['search']['value'];
//     $sql.=" AND (pt2_nama_pemohon  LIKE '%".$search."%' ";
//     $sql.=" OR pt2_no_kp_pemohon  LIKE '%".$search."%' ";
//     $sql.=" OR uu_fullname  LIKE '%".$search."%') ";
//
//     $sql.=" ORDER BY ". $columns[$data['order'][0]['column']]." ".$data['order'][0]['dir']." LIMIT ".$data['start']." ,".$data['length']."   ";
//
//     $result = $conn->query($sql);
//     $numrows = $result->num_rows;
//     $totalFiltered = $numrows;
//   } else {
//     $sql.=" ORDER BY ". $columns[$data['order'][0]['column']]." ".$data['order'][0]['dir']." LIMIT ".$data['start']." ,".$data['length']."   ";
//     $result = $conn->query($sql);
//     $numrows = $result->num_rows;
//     $totalFiltered = $numrows;
//   }
//
//   $datadb = array();
//   while ($row = $result->fetch_assoc()) {
//     $nestedData=array();
//     $nestedData[] = $row["aap_id"];
//     $nestedData[] = $row["pt2_nama_pemohon"]."<br>".$row["pt2_no_kp_pemohon"];
//     $nestedData[] = $row["uu_fullname"];
//     $nestedData[] = $row["tarikh_permohonan"];
//     $nestedData[] = badge($row["rs_color"],$row["rs_icon"],$row["rs_name"]);
//     $nestedData[] = "<button class='btn btn-primary btn-block' id='view' icno='".$row["pt2_no_kp_pemohon"]."'>View</button>";
//     $datadb[] = $nestedData;
//   }
//
//   error_log(print_r($data,true),0);
//
//   $json_data = array(
//     "draw"            => intval( $data['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw.
//     "recordsTotal"    => intval( $totalFiltered),  // total number of records
//     "recordsFiltered" => intval( $totalData ), // total number of records after searching, if there is no searching then totalFiltered = totalData
//     "data"            => $datadb   // total data array
//   );
//
//   return $json_data;
// }
//
// if($_POST["func"] == "penyedia-gettidakLengkapOutbox"){
//   echo json_encode(getPenyediaOutbox($_POST));
// }
//
// function getPenyediaOutbox($data){
//   global $conn;
//
//   $columns = array(
//     // datatable column index  => database column name
//     0 => 'aap_id',
//     1 => 'pt2_nama_pemohon',
//     2 => 'tarikh_permohonan',
//     3 => 'uu_fullname',
//     4 => 'kaunter_application_stat',
//     5 => 'kaunter_application_stat'
//   );
//
//   $Stat = $data["Stat"];
//
//   if($Stat == "2003"){
//     $sql = "SELECT aap_id, pt2_nama_pemohon, pt2_no_kp_pemohon,
//     DATE_FORMAT(tarikh_permohonan, '%d-%m-%Y') as tarikh_permohonan, uu_fullname, kaunter_application_stat,
//     rs_color, rs_name, rs_icon, pt2_no_kp_pemohon as enc_id
//     FROM a_applicant_permohonan
//     LEFT JOIN u_user ON penyedia_uu_id = uu_id
//     LEFT JOIN ref_status ON penyedia_return_stat = rs_id
//     WHERE penyedia_stat = '2000' AND penyedia_return_stat = '2003'";
//   } else {
//     $sql = "SELECT aap_id, pt2_nama_pemohon, pt2_no_kp_pemohon,
//     DATE_FORMAT(tarikh_permohonan, '%d-%m-%Y') as tarikh_permohonan, uu_fullname, kaunter_application_stat,
//     rs_color, rs_name, rs_icon, pt2_no_kp_pemohon as enc_id
//     FROM a_applicant_permohonan
//     LEFT JOIN u_user ON penyedia_uu_id = uu_id
//     LEFT JOIN ref_status ON penyedia_stat = rs_id
//     WHERE penyedia_stat = '$Stat' AND penyedia_return_stat != '2003'";
//   }
//
//   $result = $conn->query($sql);
//   $numrows = $result->num_rows;
//   $totalData = $numrows;
//   $totalFiltered = $totalData;
//
//   if(!empty($data['search']['value'])) {
//     $search = $data['search']['value'];
//     $sql.=" AND (pt2_nama_pemohon  LIKE '%".$search."%' ";
//     $sql.=" OR pt2_no_kp_pemohon  LIKE '%".$search."%' ";
//     $sql.=" OR uu_fullname  LIKE '%".$search."%') ";
//
//     $sql.=" ORDER BY ". $columns[$data['order'][0]['column']]." ".$data['order'][0]['dir']." LIMIT ".$data['start']." ,".$data['length']."   ";
//
//     $result = $conn->query($sql);
//     $numrows = $result->num_rows;
//     $totalFiltered = $numrows;
//   } else {
//     $sql.=" ORDER BY ". $columns[$data['order'][0]['column']]." ".$data['order'][0]['dir']." LIMIT ".$data['start']." ,".$data['length']."   ";
//     $result = $conn->query($sql);
//     $numrows = $result->num_rows;
//     $totalFiltered = $numrows;
//   }
//
//   $datadb = array();
//   while ($row = $result->fetch_assoc()) {
//     $nestedData=array();
//     $nestedData[] = $row["aap_id"];
//     $nestedData[] = $row["pt2_nama_pemohon"]."<br>".$row["pt2_no_kp_pemohon"];
//     $nestedData[] = $row["uu_fullname"];
//     $nestedData[] = $row["tarikh_permohonan"];
//     $nestedData[] = badge($row["rs_color"],$row["rs_icon"],$row["rs_name"]);
//     $nestedData[] = "<button class='btn btn-primary btn-block' id='view' icno='".$row["pt2_no_kp_pemohon"]."'>View</button>";
//     $datadb[] = $nestedData;
//   }
//
//   error_log(print_r($data,true),0);
//
//   $json_data = array(
//     "draw"            => intval( $data['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw.
//     "recordsTotal"    => intval( $totalFiltered),  // total number of records
//     "recordsFiltered" => intval( $totalData ), // total number of records after searching, if there is no searching then totalFiltered = totalData
//     "data"            => $datadb   // total data array
//   );
//
//   return $json_data;
// }
//
// if($_POST["func"] == "penyemak-inbox"){
//   echo json_encode(getPenyemakInbox($_POST));
// }
//
// function getPenyemakInbox($data){
//   global $conn;
//
//   $columns = array(
//     // datatable column index  => database column name
//     0 => 'aap_id',
//     1 => 'pt2_nama_pemohon',
//     2 => 'tarikh_permohonan',
//     3 => 'uu_fullname',
//     4 => 'kaunter_application_stat',
//     5 => 'kaunter_application_stat'
//   );
//   // $kaunterStat = $data["kaunterStat"];
//
//   $sql = "SELECT aap_id, pt2_nama_pemohon, pt2_no_kp_pemohon,
//   DATE_FORMAT(tarikh_permohonan, '%d-%m-%Y') as tarikh_permohonan, uu_fullname, kaunter_application_stat,
//   rs_color, rs_name, rs_icon, pt2_no_kp_pemohon as enc_id
//   FROM a_applicant_permohonan
//   LEFT JOIN u_user ON penyedia_uu_id = uu_id
//   LEFT JOIN ref_status ON penyedia_stat = rs_id
//   WHERE penyemak_stat = '3000' AND penyedia_stat != '2000' AND kaunter_application_stat != '1000' AND penyedia_return_stat != '2003'";
//
//   $result = $conn->query($sql);
//   $numrows = $result->num_rows;
//   $totalData = $numrows;
//   $totalFiltered = $totalData;
//
//   if(!empty($data['search']['value'])) {
//     $search = $data['search']['value'];
//     $sql.=" AND (pt2_nama_pemohon  LIKE '%".$search."%' ";
//     $sql.=" OR pt2_no_kp_pemohon  LIKE '%".$search."%' ";
//     $sql.=" OR uu_fullname  LIKE '%".$search."%') ";
//
//     $sql.=" ORDER BY ". $columns[$data['order'][0]['column']]." ".$data['order'][0]['dir']." LIMIT ".$data['start']." ,".$data['length']."   ";
//
//     $result = $conn->query($sql);
//     $numrows = $result->num_rows;
//     $totalFiltered = $numrows;
//   } else {
//     $sql.=" ORDER BY ". $columns[$data['order'][0]['column']]." ".$data['order'][0]['dir']." LIMIT ".$data['start']." ,".$data['length']."   ";
//     $result = $conn->query($sql);
//     $numrows = $result->num_rows;
//     $totalFiltered = $numrows;
//   }
//
//   $datadb = array();
//   while ($row = $result->fetch_assoc()) {
//     $nestedData=array();
//     $nestedData[] = $row["aap_id"];
//     $nestedData[] = $row["pt2_nama_pemohon"]."<br>".$row["pt2_no_kp_pemohon"];
//     $nestedData[] = $row["uu_fullname"];
//     $nestedData[] = $row["tarikh_permohonan"];
//     $nestedData[] = badge($row["rs_color"],$row["rs_icon"],$row["rs_name"]);
//     $nestedData[] = "<button class='btn btn-primary btn-block' id='view' icno='".$row["pt2_no_kp_pemohon"]."'>View</button>";
//     $datadb[] = $nestedData;
//   }
//
//   error_log(print_r($data,true),0);
//
//   $json_data = array(
//     "draw"            => intval( $data['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw.
//     "recordsTotal"    => intval( $totalFiltered),  // total number of records
//     "recordsFiltered" => intval( $totalData ), // total number of records after searching, if there is no searching then totalFiltered = totalData
//     "data"            => $datadb   // total data array
//   );
//
//   return $json_data;
// }
//
// if($_POST["func"] == "penyemak-oubox"){
//   echo json_encode(penyemakOubox($_POST));
// }
//
// function penyemakOubox($data){
//   global $conn;
//
//   $columns = array(
//     // datatable column index  => database column name
//     0 => 'aap_id',
//     1 => 'pt2_nama_pemohon',
//     2 => 'tarikh_permohonan',
//     3 => 'uu_fullname',
//     4 => 'kaunter_application_stat',
//     5 => 'kaunter_application_stat'
//   );
//
//   $Stat = $data["Stat"];
//
//   $sql = "SELECT aap_id, pt2_nama_pemohon, pt2_no_kp_pemohon,
//   DATE_FORMAT(tarikh_permohonan, '%d-%m-%Y') as tarikh_permohonan, uu_fullname, kaunter_application_stat,
//   rs_color, rs_name, rs_icon, pt2_no_kp_pemohon as enc_id
//   FROM a_applicant_permohonan
//   LEFT JOIN u_user ON penyemak_uu_id = uu_id
//   LEFT JOIN ref_status ON penyemak_stat = rs_id
//   WHERE penyemak_stat = '$Stat' ";
//
//
//   $result = $conn->query($sql);
//   $numrows = $result->num_rows;
//   $totalData = $numrows;
//   $totalFiltered = $totalData;
//
//   if(!empty($data['search']['value'])) {
//     $search = $data['search']['value'];
//     $sql.=" AND (pt2_nama_pemohon  LIKE '%".$search."%' ";
//     $sql.=" OR pt2_no_kp_pemohon  LIKE '%".$search."%' ";
//     $sql.=" OR uu_fullname  LIKE '%".$search."%') ";
//
//     $sql.=" ORDER BY ". $columns[$data['order'][0]['column']]." ".$data['order'][0]['dir']." LIMIT ".$data['start']." ,".$data['length']."   ";
//
//     $result = $conn->query($sql);
//     $numrows = $result->num_rows;
//     $totalFiltered = $numrows;
//   } else {
//     $sql.=" ORDER BY ". $columns[$data['order'][0]['column']]." ".$data['order'][0]['dir']." LIMIT ".$data['start']." ,".$data['length']."   ";
//     $result = $conn->query($sql);
//     $numrows = $result->num_rows;
//     $totalFiltered = $numrows;
//   }
//
//   $datadb = array();
//   while ($row = $result->fetch_assoc()) {
//     $nestedData=array();
//     $nestedData[] = $row["aap_id"];
//     $nestedData[] = $row["pt2_nama_pemohon"]."<br>".$row["pt2_no_kp_pemohon"];
//     $nestedData[] = $row["uu_fullname"];
//     $nestedData[] = $row["tarikh_permohonan"];
//     $nestedData[] = badge($row["rs_color"],$row["rs_icon"],$row["rs_name"]);
//     $nestedData[] = "<button class='btn btn-primary btn-block' id='view' icno='".$row["pt2_no_kp_pemohon"]."'>View</button>";
//     $datadb[] = $nestedData;
//   }
//
//   error_log(print_r($data,true),0);
//
//   $json_data = array(
//     "draw"            => intval( $data['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw.
//     "recordsTotal"    => intval( $totalFiltered),  // total number of records
//     "recordsFiltered" => intval( $totalData ), // total number of records after searching, if there is no searching then totalFiltered = totalData
//     "data"            => $datadb   // total data array
//   );
//
//   return $json_data;
// }
//
// if($_POST["func"] == "pelulus-inbox"){
//   echo json_encode(getPelulusInbox($_POST));
// }
//
// function getPelulusInbox($data){
//   global $conn;
//
//   $columns = array(
//     // datatable column index  => database column name
//     0 => 'aap_id',
//     1 => 'pt2_nama_pemohon',
//     2 => 'tarikh_permohonan',
//     3 => 'uu_fullname',
//     4 => 'kaunter_application_stat',
//     5 => 'kaunter_application_stat'
//   );
//   // $kaunterStat = $data["kaunterStat"];
//
//   $sql = "SELECT aap_id, pt2_nama_pemohon, pt2_no_kp_pemohon,
//   DATE_FORMAT(tarikh_permohonan, '%d-%m-%Y') as tarikh_permohonan, uu_fullname, kaunter_application_stat,
//   rs_color, rs_name, rs_icon, pt2_no_kp_pemohon as enc_id
//   FROM a_applicant_permohonan
//   LEFT JOIN u_user ON penyemak_uu_id = uu_id
//   LEFT JOIN ref_status ON penyemak_stat = rs_id
//   WHERE pelulus_stat = '4000' AND penyemak_stat != '3000' AND penyedia_stat != '2000' AND kaunter_application_stat != '1000' AND penyedia_return_stat != '2003'";
//
//   $result = $conn->query($sql);
//   $numrows = $result->num_rows;
//   $totalData = $numrows;
//   $totalFiltered = $totalData;
//
//   if(!empty($data['search']['value'])) {
//     $search = $data['search']['value'];
//     $sql.=" AND (pt2_nama_pemohon  LIKE '%".$search."%' ";
//     $sql.=" OR pt2_no_kp_pemohon  LIKE '%".$search."%' ";
//     $sql.=" OR uu_fullname  LIKE '%".$search."%') ";
//
//     $sql.=" ORDER BY ". $columns[$data['order'][0]['column']]." ".$data['order'][0]['dir']." LIMIT ".$data['start']." ,".$data['length']."   ";
//
//     $result = $conn->query($sql);
//     $numrows = $result->num_rows;
//     $totalFiltered = $numrows;
//   } else {
//     $sql.=" ORDER BY ". $columns[$data['order'][0]['column']]." ".$data['order'][0]['dir']." LIMIT ".$data['start']." ,".$data['length']."   ";
//     $result = $conn->query($sql);
//     $numrows = $result->num_rows;
//     $totalFiltered = $numrows;
//   }
//
//   $datadb = array();
//   while ($row = $result->fetch_assoc()) {
//     $nestedData=array();
//     $nestedData[] = $row["aap_id"];
//     $nestedData[] = $row["pt2_nama_pemohon"]."<br>".$row["pt2_no_kp_pemohon"];
//     $nestedData[] = $row["uu_fullname"];
//     $nestedData[] = $row["tarikh_permohonan"];
//     $nestedData[] = badge($row["rs_color"],$row["rs_icon"],$row["rs_name"]);
//     $nestedData[] = "<button class='btn btn-primary btn-block' id='view' icno='".$row["pt2_no_kp_pemohon"]."'>View</button>";
//     $datadb[] = $nestedData;
//   }
//
//   error_log(print_r($data,true),0);
//
//   $json_data = array(
//     "draw"            => intval( $data['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw.
//     "recordsTotal"    => intval( $totalFiltered),  // total number of records
//     "recordsFiltered" => intval( $totalData ), // total number of records after searching, if there is no searching then totalFiltered = totalData
//     "data"            => $datadb   // total data array
//   );
//
//   return $json_data;
// }
//
// if($_POST["func"] == "pelulus-outbox"){
//   echo json_encode(pelulusOutbox($_POST));
// }
//
// function pelulusOutbox($data){
//   global $conn;
//
//   $columns = array(
//     // datatable column index  => database column name
//     0 => 'aap_id',
//     1 => 'pt2_nama_pemohon',
//     2 => 'tarikh_permohonan',
//     3 => 'uu_fullname',
//     4 => 'kaunter_application_stat',
//     5 => 'kaunter_application_stat'
//   );
//
//   $Stat = $data["Stat"];
//
//   $sql = "SELECT aap_id, pt2_nama_pemohon, pt2_no_kp_pemohon,
//   DATE_FORMAT(tarikh_permohonan, '%d-%m-%Y') as tarikh_permohonan, uu_fullname, kaunter_application_stat,
//   rs_color, rs_name, rs_icon, pt2_no_kp_pemohon as enc_id
//   FROM a_applicant_permohonan
//   LEFT JOIN u_user ON pelulus_uu_id = uu_id
//   LEFT JOIN ref_status ON pelulus_stat = rs_id
//   WHERE pelulus_stat = '$Stat' ";
//
//   $result = $conn->query($sql);
//   $numrows = $result->num_rows;
//   $totalData = $numrows;
//   $totalFiltered = $totalData;
//
//   if(!empty($data['search']['value'])) {
//     $search = $data['search']['value'];
//     $sql.=" AND (pt2_nama_pemohon  LIKE '%".$search."%' ";
//     $sql.=" OR pt2_no_kp_pemohon  LIKE '%".$search."%' ";
//     $sql.=" OR uu_fullname  LIKE '%".$search."%') ";
//
//     $sql.=" ORDER BY ". $columns[$data['order'][0]['column']]." ".$data['order'][0]['dir']." LIMIT ".$data['start']." ,".$data['length']."   ";
//
//     $result = $conn->query($sql);
//     $numrows = $result->num_rows;
//     $totalFiltered = $numrows;
//   } else {
//     $sql.=" ORDER BY ". $columns[$data['order'][0]['column']]." ".$data['order'][0]['dir']." LIMIT ".$data['start']." ,".$data['length']."   ";
//     $result = $conn->query($sql);
//     $numrows = $result->num_rows;
//     $totalFiltered = $numrows;
//   }
//
//   $datadb = array();
//   while ($row = $result->fetch_assoc()) {
//     $nestedData=array();
//     $nestedData[] = $row["aap_id"];
//     $nestedData[] = $row["pt2_nama_pemohon"]."<br>".$row["pt2_no_kp_pemohon"];
//     $nestedData[] = $row["uu_fullname"];
//     $nestedData[] = $row["tarikh_permohonan"];
//     $nestedData[] = badge($row["rs_color"],$row["rs_icon"],$row["rs_name"]);
//     $nestedData[] = "<button class='btn btn-primary btn-block' id='view' icno='".$row["pt2_no_kp_pemohon"]."'>View</button>";
//     $datadb[] = $nestedData;
//   }
//
//   error_log(print_r($data,true),0);
//
//   $json_data = array(
//     "draw"            => intval( $data['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw.
//     "recordsTotal"    => intval( $totalFiltered),  // total number of records
//     "recordsFiltered" => intval( $totalData ), // total number of records after searching, if there is no searching then totalFiltered = totalData
//     "data"            => $datadb   // total data array
//   );
//
//   return $json_data;
// }
//
// if($_POST["func"] == "pembayaran-inbox"){
//   echo json_encode(getPembayaranInbox($_POST));
// }
//
// function getPembayaranInbox($data){
//   global $conn;
//
//   $columns = array(
//     // datatable column index  => database column name
//     0 => 'aap_id',
//     1 => 'pt2_nama_pemohon',
//     2 => 'tarikh_permohonan',
//     3 => 'uu_fullname',
//     4 => 'kaunter_application_stat',
//     5 => 'kaunter_application_stat'
//   );
//   // $kaunterStat = $data["kaunterStat"];
//
//   $sql = "SELECT aap_id, pt2_nama_pemohon, pt2_no_kp_pemohon,
//   DATE_FORMAT(tarikh_permohonan, '%d-%m-%Y') as tarikh_permohonan, uu_fullname, kaunter_application_stat,
//   rs_color, rs_name, rs_icon, pt2_no_kp_pemohon as enc_id
//   FROM a_applicant_permohonan
//   LEFT JOIN u_user ON penyemak_uu_id = uu_id
//   LEFT JOIN ref_status ON penyemak_stat = rs_id
//   WHERE pelulus_stat = '4001' AND pembayaran_ppb_id IS NULL";
//
//   $result = $conn->query($sql);
//   $numrows = $result->num_rows;
//   $totalData = $numrows;
//   $totalFiltered = $totalData;
//
//   if(!empty($data['search']['value'])) {
//     $search = $data['search']['value'];
//     $sql.=" AND (pt2_nama_pemohon  LIKE '%".$search."%' ";
//     $sql.=" OR pt2_no_kp_pemohon  LIKE '%".$search."%' ";
//     $sql.=" OR uu_fullname  LIKE '%".$search."%') ";
//
//     $sql.=" ORDER BY ". $columns[$data['order'][0]['column']]." ".$data['order'][0]['dir']." LIMIT ".$data['start']." ,".$data['length']."   ";
//
//     $result = $conn->query($sql);
//     $numrows = $result->num_rows;
//     $totalFiltered = $numrows;
//   } else {
//     $sql.=" ORDER BY ". $columns[$data['order'][0]['column']]." ".$data['order'][0]['dir']." LIMIT ".$data['start']." ,".$data['length']."   ";
//     $result = $conn->query($sql);
//     $numrows = $result->num_rows;
//     $totalFiltered = $numrows;
//   }
//
//   $datadb = array();
//   while ($row = $result->fetch_assoc()) {
//     $nestedData=array();
//     $nestedData[] = $row["aap_id"];
//     $nestedData[] = $row["pt2_nama_pemohon"]."<br>".$row["pt2_no_kp_pemohon"];
//     $nestedData[] = $row["uu_fullname"];
//     $nestedData[] = $row["tarikh_permohonan"];
//     $nestedData[] = badge($row["rs_color"],$row["rs_icon"],$row["rs_name"]);
//     $nestedData[] = "<button class='btn btn-primary btn-block' id='view' icno='".$row["pt2_no_kp_pemohon"]."'>View</button>";
//     $datadb[] = $nestedData;
//   }
//
//   error_log(print_r($data,true),0);
//
//   $json_data = array(
//     "draw"            => intval( $data['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw.
//     "recordsTotal"    => intval( $totalFiltered),  // total number of records
//     "recordsFiltered" => intval( $totalData ), // total number of records after searching, if there is no searching then totalFiltered = totalData
//     "data"            => $datadb   // total data array
//   );
//
//   return $json_data;
// }
//
// if($_POST["func"] == "pembayaran-sd-inbox"){
//   echo json_encode(getPembayaranSDInbox($_POST));
// }
//
// function getPembayaranSDInbox($data){
//   global $conn;
//
//   $columns = array(
//     // datatable column index  => database column name
//     0 => 'aap_id',
//     1 => 'pt2_nama_pemohon',
//     2 => 'tarikh_permohonan',
//     3 => 'uu_fullname',
//     4 => 'kaunter_application_stat',
//     5 => 'kaunter_application_stat'
//   );
//
//   $ript = $data["ript"];
//
//   $sql = "SELECT aap_id, pt2_nama_pemohon, pt2_no_kp_pemohon,
//   DATE_FORMAT(tarikh_permohonan, '%d-%m-%Y') as tarikh_permohonan, uu_fullname, kaunter_application_stat,
//   rs_color, rs_name, rs_icon, pt2_no_kp_pemohon as enc_id, pt3_jenis_ipt
//   FROM a_applicant_permohonan
//   LEFT JOIN u_user ON penyemak_uu_id = uu_id
//   LEFT JOIN ref_status ON penyemak_stat = rs_id
//   LEFT JOIN ref_ipt ipt ON ipt.ript_id = pt3_nama_institusi
//   LEFT JOIN ref_ipt bipt ON bipt.ript_id = pt3_ins_ipts
//   WHERE pelulus_stat = '4001' AND pembayaran_ppbsd_id IS NULL
//   AND ((pt3_jenis_ipt = 1 AND ipt.ript_sd  = '1' AND ipt.ript_id = '$ript') OR (pt3_jenis_ipt = 2 AND bipt.ript_sd  = '1' AND bipt.ript_id = '$ript'))";
//
//   $result = $conn->query($sql);
//   $numrows = $result->num_rows;
//   $totalData = $numrows;
//   $totalFiltered = $totalData;
//
//   if(!empty($data['search']['value'])) {
//     $search = $data['search']['value'];
//     $sql.=" AND (pt2_nama_pemohon  LIKE '%".$search."%' ";
//     $sql.=" OR pt2_no_kp_pemohon  LIKE '%".$search."%' ";
//     $sql.=" OR uu_fullname  LIKE '%".$search."%') ";
//
//     $sql.=" ORDER BY ". $columns[$data['order'][0]['column']]." ".$data['order'][0]['dir']." LIMIT ".$data['start']." ,".$data['length']."   ";
//
//     $result = $conn->query($sql);
//     $numrows = $result->num_rows;
//     $totalFiltered = $numrows;
//   } else {
//     $sql.=" ORDER BY ". $columns[$data['order'][0]['column']]." ".$data['order'][0]['dir']." LIMIT ".$data['start']." ,".$data['length']."   ";
//     $result = $conn->query($sql);
//     $numrows = $result->num_rows;
//     $totalFiltered = $numrows;
//   }
//
//   $datadb = array();
//   while ($row = $result->fetch_assoc()) {
//     $nestedData=array();
//     $nestedData[] = $row["aap_id"];
//     $nestedData[] = $row["pt2_nama_pemohon"]."<br>".$row["pt2_no_kp_pemohon"];
//     $nestedData[] = $row["uu_fullname"];
//     $nestedData[] = $row["tarikh_permohonan"];
//     $nestedData[] = badge($row["rs_color"],$row["rs_icon"],$row["rs_name"]);
//     $nestedData[] = "<button class='btn btn-primary btn-block' id='view' icno='".$row["pt2_no_kp_pemohon"]."'>View</button>";
//     $datadb[] = $nestedData;
//   }
//
//   error_log(print_r($data,true),0);
//
//   $json_data = array(
//     "draw"            => intval( $data['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw.
//     "recordsTotal"    => intval( $totalFiltered),  // total number of records
//     "recordsFiltered" => intval( $totalData ), // total number of records after searching, if there is no searching then totalFiltered = totalData
//     "data"            => $datadb   // total data array
//   );
//
//   return $json_data;
// }
//
// if($_POST["func"] == "pembayaran-baucar"){
//   echo json_encode(getPembayaranbaucar($_POST));
// }
//
// function getPembayaranbaucar($data){
//   global $conn;
//
//   $columns = array(
//     // datatable column index  => database column name
//     0 => 'ppb_id',
//     1 => 'ppb_datetime',
//     2 => 'uu_fullname',
//     3 => 'ppb_status',
//     4 => 'ppb_status'
//   );
//   $StatusSelect = $data["Stat"];
//
//   $sql = "SELECT
//   ppb_id,
//   SHA2(ppb_id, 256) as enc_id,
//   DATE_FORMAT(ppb_datetime, '%d-%m-%Y') as ppb_datetime,
//   ppb_status,
//   uu_fullname,
//   rs_icon, rs_color, rs_name
//   FROM p_payment_baucar
//   LEFT JOIN u_user ON ppb_uu_id = uu_id
//   LEFT JOIN ref_status ON ppb_status = rs_id
//   WHERE ppb_status = '$StatusSelect' ";
//
//   if ($StatusSelect == '5000') {
//     $btnid = "update";
//   } else if ($StatusSelect == '5001') {
//     $btnid = "updateTransaction";
//   } else {
//     $btnid = "view";
//   }
//
//   $result = $conn->query($sql);
//   $numrows = $result->num_rows;
//   $totalData = $numrows;
//   $totalFiltered = $totalData;
//
//   if(!empty($data['search']['value'])) {
//     $search = $data['search']['value'];
//     $sql.=" AND (uu_fullname  LIKE '%".$search."%' ";
//     $sql.=" OR ppb_datetime  LIKE '%".$search."%' ";
//     $sql.=" OR ppb_id  LIKE '%".$search."%') ";
//
//     $sql.=" ORDER BY ". $columns[$data['order'][0]['column']]." ".$data['order'][0]['dir']." LIMIT ".$data['start']." ,".$data['length']."   ";
//
//     $result = $conn->query($sql);
//     $numrows = $result->num_rows;
//     $totalFiltered = $numrows;
//   } else {
//     $sql.=" ORDER BY ". $columns[$data['order'][0]['column']]." ".$data['order'][0]['dir']." LIMIT ".$data['start']." ,".$data['length']."   ";
//     $result = $conn->query($sql);
//     $numrows = $result->num_rows;
//     $totalFiltered = $numrows;
//   }
//
//   $datadb = array();
//   while ($row = $result->fetch_assoc()) {
//     $nestedData=array();
//     $nestedData[] = "HPIPT/".$row["ppb_id"];
//     $nestedData[] = $row["ppb_datetime"];
//     $nestedData[] = $row["uu_fullname"];
//     $nestedData[] = badge($row["rs_color"],$row["rs_icon"],$row["rs_name"]);
//     $nestedData[] = '
//     <div class="btn-group row w-100">
//       <div class="btn-group col-6 p-0">
//         <button id="'.$btnid.'" ppbid="'.$row["enc_id"].'" type="button" class="btn btn-primary w-100">
//           <span class="p-t-5 p-b-5">
//           <i class="fa fa-list fs-15"></i>
//           </span>
//         </button>
//       </div>
//       <div class="btn-group col-6 p-0">
//         <button id="print" ppbid="'.$row["enc_id"].'" type="button" class="btn btn-default w-100">
//           <span class="p-t-5 p-b-5">
//           <i class="fa fa-print fs-15"></i>
//           </span>
//         </button>
//       </div>
//     </div>';
//     $datadb[] = $nestedData;
//   }
//
//   error_log(print_r($data,true),0);
//
//   $json_data = array(
//     "draw"            => intval( $data['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw.
//     "recordsTotal"    => intval( $totalFiltered),  // total number of records
//     "recordsFiltered" => intval( $totalData ), // total number of records after searching, if there is no searching then totalFiltered = totalData
//     "data"            => $datadb   // total data array
//   );
//
//   return $json_data;
// }
//
// if($_POST["func"] == "pembayaran-baucar-detail"){
//   echo json_encode(getPembayaranbaucarDetail($_POST));
// }
//
// function getPembayaranbaucarDetail($data){
//   global $conn;
//
//   $columns = array(
//     // datatable column index  => database column name
//     0 => 'aap_id',
//     1 => 'pt2_nama_pemohon',
//     2 => 'pt2_no_kp_pemohon',
//     3 => 'pt2_no_akaun',
//     4 => 'pt2_no_telefon_pemohon',
//     5 => 'ppb_rate',
//     6 => 'aap_id'
//   );
//
//   $ppb = ''; if(isset($data["ppb"])) $ppb = $data["ppb"];
//
//   $sql = "SELECT SHA2(aap_id,256) as enc_id, aap_id, pt2_nama_pemohon, pt2_no_kp_pemohon, pt2_no_akaun, rbnk_name,rbnk_short, pt2_no_telefon_pemohon,
//   DATE_FORMAT(tarikh_permohonan, '%d-%m-%Y') as tarikh_permohonan, kaunter_application_stat,
//   rs_color, rs_name, rs_icon, ppb_rate, ppb_status, pembayaran_transaction
//   FROM a_applicant_permohonan
//   LEFT JOIN ref_status ON penyemak_stat = rs_id
//   LEFT JOIN ref_bank ON rbnk_id = pt2_nama_bank
//   LEFT JOIN p_payment_baucar ON ppb_id = pembayaran_ppb_id
//   WHERE SHA2(pembayaran_ppb_id,256) = '$ppb'";
//
//   $result = $conn->query($sql);
//   $numrows = $result->num_rows;
//   $totalData = $numrows;
//   $totalFiltered = $totalData;
//
//   if(!empty($data['search']['value'])) {
//     $search = $data['search']['value'];
//     $sql.=" AND (pt2_nama_pemohon  LIKE '%".$search."%' ";
//     $sql.=" OR pt2_no_kp_pemohon  LIKE '%".$search."%'";
//     $sql.=" OR rbnk_name  LIKE '%".$search."%')";
//
//     $sql.=" ORDER BY ". $columns[$data['order'][0]['column']]." ".$data['order'][0]['dir']." LIMIT ".$data['start']." ,".$data['length']."   ";
//
//     $result = $conn->query($sql);
//     $numrows = $result->num_rows;
//     $totalFiltered = $numrows;
//   } else {
//     $sql.=" ORDER BY ". $columns[$data['order'][0]['column']]." ".$data['order'][0]['dir']." LIMIT ".$data['start']." ,".$data['length']."   ";
//     $result = $conn->query($sql);
//     $numrows = $result->num_rows;
//     $totalFiltered = $numrows;
//   }
//
//   $x = 1;
//   $ppb_pngesah1_uu_id = "";
//   $ppb_pngesah2_uu_id = "";
//   $ppb_pngesah3_uu_id = "";
//
//
//
//   $datadb = array();
//   while ($row = $result->fetch_assoc()) {
//
//     $enc = $row["enc_id"];
//
//     if($row["ppb_status"] == '5001'){
//       $ptval = $row["pembayaran_transaction"];
//       $inputfield = "<input id='updatetransid' aap='$enc' value='$ptval' type='text' class='form-control' /> ";
//     } else {
//       $inputfield = $row["pembayaran_transaction"];
//     }
//
//     $nestedData=array();
//     $nestedData[] = $x;
//     $nestedData[] = $row["pt2_nama_pemohon"];
//     $nestedData[] = $row["pt2_no_kp_pemohon"];
//     $nestedData[] = "<b>".$row["pt2_no_akaun"]."</b><br>".$row["rbnk_short"];
//     $nestedData[] = $row["pt2_no_telefon_pemohon"];
//     $nestedData[] = "RM ".$row["ppb_rate"];
//     $nestedData[] = $inputfield;
//     $datadb[] = $nestedData;
//     $x++;
//   }
//
//   error_log(print_r($data,true),0);
//
//   $json_data = array(
//     "draw"            => intval( $data['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw.
//     "recordsTotal"    => intval( $totalFiltered),  // total number of records
//     "recordsFiltered" => intval( $totalData ), // total number of records after searching, if there is no searching then totalFiltered = totalData
//     "data"            => $datadb
//   );
//
//   return $json_data;
// }
//
// if($_POST["func"] == "pembayaran-baucarSD"){
//   echo json_encode(getPembayaranbaucarSD($_POST));
// }
//
// function getPembayaranbaucarSD($data){
//   global $conn;
//
//   $columns = array(
//     // datatable column index  => database column name
//     0 => 'ppbsd_id',
//     1 => 'ppbsd_datetime',
//     2 => 'uu_fullname',
//     3 => 'ppbsd_status',
//     4 => 'ppbsd_status'
//   );
//
//   $StatusSelect = $data["Stat"];
//   $ript = $data["ript"];
//
//   $sql = "SELECT
//   ppbsd_id,
//   SHA2(ppbsd_id, 256) as enc_id,
//   DATE_FORMAT(ppbsd_datetime, '%d-%m-%Y') as ppbsd_datetime,
//   ppbsd_status,
//   uu_fullname,
//   rs_icon, rs_color, rs_name
//   FROM p_payment_baucar_sd
//   LEFT JOIN u_user ON ppbsd_uu_id = uu_id
//   LEFT JOIN ref_status ON ppbsd_status = rs_id
//   WHERE ppbsd_status = '$StatusSelect' AND ppbsd_ript_id = '$ript'";
//
//   if ($StatusSelect == '6000') {
//     $btnid = "update";
//   } else if ($StatusSelect == '6001') {
//     $btnid = "updateTransaction";
//   } else {
//     $btnid = "view";
//   }
//
//   $result = $conn->query($sql);
//   $numrows = $result->num_rows;
//   $totalData = $numrows;
//   $totalFiltered = $totalData;
//
//   if(!empty($data['search']['value'])) {
//     $search = $data['search']['value'];
//     $sql.=" AND (uu_fullname  LIKE '%".$search."%' ";
//     $sql.=" OR ppbsd_datetime  LIKE '%".$search."%' ";
//     $sql.=" OR ppbsd_id  LIKE '%".$search."%') ";
//
//     $sql.=" ORDER BY ". $columns[$data['order'][0]['column']]." ".$data['order'][0]['dir']." LIMIT ".$data['start']." ,".$data['length']."   ";
//
//     $result = $conn->query($sql);
//     $numrows = $result->num_rows;
//     $totalFiltered = $numrows;
//   } else {
//     $sql.=" ORDER BY ". $columns[$data['order'][0]['column']]." ".$data['order'][0]['dir']." LIMIT ".$data['start']." ,".$data['length']."   ";
//     $result = $conn->query($sql);
//     $numrows = $result->num_rows;
//     $totalFiltered = $numrows;
//   }
//
//   $datadb = array();
//   while ($row = $result->fetch_assoc()) {
//     $nestedData=array();
//     $nestedData[] = "SD/".$row["ppbsd_id"];
//     $nestedData[] = $row["ppbsd_datetime"];
//     $nestedData[] = $row["uu_fullname"];
//     $nestedData[] = badge($row["rs_color"],$row["rs_icon"],$row["rs_name"]);
//     $nestedData[] = '
//     <div class="btn-group row w-100">
//       <div class="btn-group col-6 p-0">
//         <button id="'.$btnid.'" ppbid="'.$row["enc_id"].'" type="button" class="btn btn-primary w-100">
//           <span class="p-t-5 p-b-5">
//           <i class="fa fa-list fs-15"></i>
//           </span>
//         </button>
//       </div>
//       <div class="btn-group col-6 p-0">
//         <button id="print" ppbid="'.$row["enc_id"].'" type="button" class="btn btn-default w-100">
//           <span class="p-t-5 p-b-5">
//           <i class="fa fa-print fs-15"></i>
//           </span>
//         </button>
//       </div>
//     </div>';
//     $datadb[] = $nestedData;
//   }
//
//   error_log(print_r($data,true),0);
//
//   $json_data = array(
//     "draw"            => intval( $data['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw.
//     "recordsTotal"    => intval( $totalFiltered),  // total number of records
//     "recordsFiltered" => intval( $totalData ), // total number of records after searching, if there is no searching then totalFiltered = totalData
//     "data"            => $datadb   // total data array
//   );
//
//   return $json_data;
// }
//
// if($_POST["func"] == "pembayaran-baucar-detailSD"){
//   echo json_encode(getPembayaranbaucarDetailSD($_POST));
// }
//
// function getPembayaranbaucarDetailSD($data){
//   global $conn;
//
//   $columns = array(
//     // datatable column index  => database column name
//     0 => 'aap_id',
//     1 => 'pt2_nama_pemohon',
//     2 => 'pt2_no_kp_pemohon',
//     3 => 'rbnk_name',
//     4 => 'pt2_no_akaun',
//     5 => 'pt2_no_telefon_pemohon',
//     6 => 'aap_id'
//   );
//
//   $ppbsd = ''; if(isset($data["ppbsd"])) $ppbsd = $data["ppbsd"];
//
//   $sql = "SELECT aap_id, pt2_nama_pemohon, pt2_no_kp_pemohon, pt2_no_akaun, rbnk_name, pt2_no_telefon_pemohon,
//   DATE_FORMAT(tarikh_permohonan, '%d-%m-%Y') as tarikh_permohonan, kaunter_application_stat,
//   rs_color, rs_name, rs_icon, pt2_no_kp_pemohon as enc_id, ppbsd_rate
//   FROM a_applicant_permohonan
//   LEFT JOIN ref_status ON penyemak_stat = rs_id
//   LEFT JOIN ref_bank ON rbnk_id = pt2_nama_bank
//   LEFT JOIN p_payment_baucar_sd ON ppbsd_id = pembayaran_ppbsd_id
//   WHERE SHA2(pembayaran_ppbsd_id,256) = '$ppbsd'";
//
//   $result = $conn->query($sql);
//   $numrows = $result->num_rows;
//   $totalData = $numrows;
//   $totalFiltered = $totalData;
//
//   if(!empty($data['search']['value'])) {
//     $search = $data['search']['value'];
//     $sql.=" AND (pt2_nama_pemohon  LIKE '%".$search."%' ";
//     $sql.=" OR pt2_no_kp_pemohon  LIKE '%".$search."%'";
//     $sql.=" OR rbnk_name  LIKE '%".$search."%')";
//
//     $sql.=" ORDER BY ". $columns[$data['order'][0]['column']]." ".$data['order'][0]['dir']." LIMIT ".$data['start']." ,".$data['length']."   ";
//
//     $result = $conn->query($sql);
//     $numrows = $result->num_rows;
//     $totalFiltered = $numrows;
//   } else {
//     $sql.=" ORDER BY ". $columns[$data['order'][0]['column']]." ".$data['order'][0]['dir']." LIMIT ".$data['start']." ,".$data['length']."   ";
//     $result = $conn->query($sql);
//     $numrows = $result->num_rows;
//     $totalFiltered = $numrows;
//   }
//
//   $x = 1;
//   $ppb_pngesah1_uu_id = "";
//   $ppb_pngesah2_uu_id = "";
//   $ppb_pngesah3_uu_id = "";
//
//   $datadb = array();
//   while ($row = $result->fetch_assoc()) {
//     $nestedData=array();
//     $nestedData[] = $x;
//     $nestedData[] = $row["pt2_nama_pemohon"];
//     $nestedData[] = $row["pt2_no_kp_pemohon"];
//     $nestedData[] = $row["rbnk_name"];
//     $nestedData[] = $row["pt2_no_akaun"];
//     $nestedData[] = $row["pt2_no_telefon_pemohon"];
//     $nestedData[] = "RM ".$row["ppbsd_rate"];;
//     $datadb[] = $nestedData;
//     $x++;
//   }
//
//   error_log(print_r($data,true),0);
//
//   $json_data = array(
//     "draw"            => intval( $data['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw.
//     "recordsTotal"    => intval( $totalFiltered),  // total number of records
//     "recordsFiltered" => intval( $totalData ), // total number of records after searching, if there is no searching then totalFiltered = totalData
//     "data"            => $datadb
//   );
//
//   return $json_data;
// }
//
// if($_POST["func"] == "createBaucar"){
//   echo json_encode(createBaucar($_POST));
// }
//
// function createBaucar(){
//   global $conn;
//
//   $uuid = $_SESSION["ID"];
//
//   $s = "SELECT aap_id FROM a_applicant_permohonan WHERE pembayaran_ppb_id IS NULL AND pelulus_stat = '4001'";
//   $res = $conn->query($s);
//   $numrow = $res->num_rows;
//
//   if ($numrow != 0) {
//     $i = "INSERT INTO p_payment_baucar (ppb_datetime, ppb_status, ppb_uu_id) VALUES (NOW(),'5000','$uuid')";
//     $conn->query($i);
//     $id = $conn->insert_id;
//
//     $u = "UPDATE a_applicant_permohonan SET pembayaran_ppb_id = '$id'
//     WHERE pembayaran_ppb_id IS NULL AND pelulus_stat = '4001' LIMIT 10";
//     if ($conn->query($u)) {
//       $status["STATUS"] = true;
//     } else {
//       $status["STATUS"] = false;
//       $status["MSG"] = "Penyata Bayaran Gagal Dihasilkan";
//     }
//   } else {
//     $status["STATUS"] = false;
//     $status["MSG"] = "Tiada Permohonan untuk dimasukkan kedalam Penyata Bayaran";
//   }
//
//   return $status;
// }
//
// if($_POST["func"] == "createBaucarSD"){
//   echo json_encode(createBaucarSD($_POST));
// }
//
// function createBaucarSD($data){
//   global $conn;
//
//   $uuid = $_SESSION["ID"];
//   $ript = $data["ript"];
//
//   if(!isset($data["ript"]) || $data["ript"] == ''){
//     $status["STATUS"] = false;
//     $status["MSG"] = "Sila pilih IPT yang berkenaan";
//   } else {
//     $s = "SELECT aap_id FROM a_applicant_permohonan WHERE pembayaran_ppbsd_id IS NULL AND pelulus_stat = '4001' AND ((pt3_jenis_ipt = 1 AND pt3_nama_institusi = '$ript') OR (pt3_jenis_ipt = 2 AND pt3_ins_ipts = '$ript'))";
//     $res = $conn->query($s);
//     $numrow = $res->num_rows;
//
//     if ($numrow != 0) {
//       $i = "INSERT INTO p_payment_baucar_sd (ppbsd_ript_id ,ppbsd_datetime, ppbsd_status, ppbsd_uu_id) VALUES ('$ript', NOW(),'6000','$uuid')";
//       $conn->query($i);
//       $id = $conn->insert_id;
//
//       $u = "UPDATE a_applicant_permohonan SET pembayaran_ppbsd_id = '$id'
//       WHERE pembayaran_ppbsd_id IS NULL AND pelulus_stat = '4001' AND
//       ((pt3_jenis_ipt = 1 AND pt3_nama_institusi = '$ript') OR (pt3_jenis_ipt = 2 AND pt3_ins_ipts = '$ript'))";
//       if ($conn->query($u)) {
//         $status["STATUS"] = true;
//       } else {
//         $status["STATUS"] = false;
//         $status["MSG"] = "Penyata Bayaran Gagal Dihasilkan";
//       }
//     } else {
//       $status["STATUS"] = false;
//       $status["MSG"] = "Tiada Permohonan untuk dimasukkan kedalam Penyata Bayaran Sara Diri";
//     }
//   }
//
//
//   return $status;
// }
//
// if($_POST["func"] == "updatePembayaranPengesah"){
//   echo json_encode(updatePembayaranPengesah($_POST));
// }
//
// function updatePembayaranPengesah($data){
//   global $conn;
//
//   $p1 = $data["pengesah1"];
//   $p2 = $data["pengesah2"];
//   $p3 = $data["pengesah3"];
//   $ppbid = $data["ppbid"];
//
//   $u = "UPDATE p_payment_baucar SET
//   ppb_pngesah1_uu_id = '$p1',
//   ppb_pngesah2_uu_id = '$p2',
//   ppb_pngesah3_uu_id = '$p3'
//   WHERE SHA2(ppb_id,256) = '$ppbid' AND ppb_status = '5000'";
//
//   if ($conn->query($u)) {
//     $status["STATUS"] = true;
//   } else {
//     $status["STATUS"] = false;
//   }
//
//   return $status;
// }
//
// if($_POST["func"] == "updatePembayaranPengesahSD"){
//   echo json_encode(updatePembayaranPengesahSD($_POST));
// }
//
// function updatePembayaranPengesahSD($data){
//   global $conn;
//
//   $p1 = $data["pengesah1"];
//   $p2 = $data["pengesah2"];
//   $p3 = $data["pengesah3"];
//   $ppbsdid = $data["ppbsdid"];
//
//   $u = "UPDATE p_payment_baucar_sd SET
//   ppbsd_pngesah1_uu_id = '$p1',
//   ppbsd_pngesah2_uu_id = '$p2',
//   ppbsd_pngesah3_uu_id = '$p3'
//   WHERE SHA2(ppbsd_id,256) = '$ppbsdid' AND ppbsd_status = '6000'";
//
//   if ($conn->query($u)) {
//     $status["STATUS"] = true;
//   } else {
//     $status["STATUS"] = false;
//   }
//
//   return $status;
// }
//
// if($_POST["func"] == "baucarProsesPembayaran"){
//   echo json_encode(baucarProsesPembayaran($_POST));
// }
//
// function baucarProsesPembayaran($data){
//   global $conn;
//
//   $noboucar = $data["nobaucar"];
//   $ppbid = $data["ppbid"];
//
//   $status["STATUS"] = false;
//   $status["STATUSAAP"] = false;
//   $status["STATUSLOG"] = false;
//
//   $u = "UPDATE p_payment_baucar SET
//   ppb_name = '$noboucar', ppb_status = '5001'
//   WHERE SHA2(ppb_id,256) = '$ppbid'
//   AND ppb_status = '5000'
//   AND ppb_pngesah1_uu_id  IS NOT NULL
//   AND ppb_pngesah2_uu_id  IS NOT NULL
//   AND ppb_pngesah3_uu_id  IS NOT NULL";
//
//   if ($conn->query($u)) {
//     $status["STATUS"] = true;
//
//     $u2 = "UPDATE a_applicant_permohonan SET
//     pembayaran_hpipt_stat = '5001', pembayaran_hpipt_date = NOW()
//     WHERE SHA2(pembayaran_ppb_id,256) = '$ppbid'";
//
//     $icno = "SELECT pt2_no_kp_pemohon FROM a_applicant_permohonan WHERE SHA2(pembayaran_ppb_id, 256) = '$ppbid'";
//     $s = "SELECT aa_username, aa_fullname as name, aa_email as email, SHA2(aa_id,256) as aa_id,
//     SHA2(aa_email,256) as aa_email, penyedia_return_note , DATE_FORMAT(pelulus_date,'%d/%m/%Y') as pelulus_date,
//     ipt.ript_sd as iptasd, bipt.ript_sd as iptssd, rbnk_name, pt2_no_akaun, pt3_jenis_ipt
//     FROM a_applicant
//     LEFT JOIN a_applicant_permohonan ON pt2_no_kp_pemohon = aa_username
//     LEFT JOIN ref_ipt ipt ON ipt.ript_id = pt3_nama_institusi
//     LEFT JOIN ref_ipt bipt ON bipt.ript_id = pt3_ins_ipts
//     LEFT JOIN ref_bank ON rbnk_id = pt2_nama_bank
//     WHERE aa_username IN ($icno)";
//     $result = $conn->query($s);
//
//     while ($row = $result->fetch_assoc()) {
//       $aaid = $row["aa_id"]; // ENCRYPTED EMAIL AND ID
//       $email = $row["aa_email"]; // ENCRYPTED EMAIL AND ID
//       $toname = $row["name"];
//       $toemail = $row["email"];
//       $toemail = $row["email"];
//       $ic = $row["aa_username"];
//       $pelulus_date = $row["pelulus_date"];
//       $pt3_jenis_ipt = $row["pt3_jenis_ipt"];
//       $iptasd = $row["iptasd"];
//       $iptssd = $row["iptssd"];
//       $rbnk_name = $row["rbnk_name"];
//       $pt2_no_akaun = $row["pt2_no_akaun"];
//
//       $status["EMAILSTATUS"][$ic] = HPIPTpaymentProcess($aaid,$email,$toname,$toemail,$ic,$pelulus_date,$rbnk_name,$pt2_no_akaun);
//     }
//
//     if ($conn->query($u2)){ $status["STATUSAAP"] = true; } else { $status["STATUSAAP"] = false; }
//     $status["STATUSLOG"] = AdminMultipleLog($ppbid,'5001');
//   } else {
//     $status["STATUS"] = false;
//   }
//   return $status;
// }
//
// if($_POST["func"] == "baucarProsesPembayaranSD"){
//   echo json_encode(baucarProsesPembayaranSD($_POST));
// }
//
// function baucarProsesPembayaranSD($data){
//   global $conn;
//
//   $noboucar = $data["nobaucar"];
//   $ppbsdid = $data["ppbsdid"];
//
//   $status["STATUS"] = false;
//   $status["STATUSAAP"] = false;
//   $status["STATUSLOG"] = false;
//
//   $u = "UPDATE p_payment_baucar_sd SET
//   ppbsd_baucar = '$noboucar', ppbsd_status = '6001'
//   WHERE SHA2(ppbsd_id,256) = '$ppbsdid'
//   AND ppbsd_status = '6000'
//   AND ppbsd_pngesah1_uu_id IS NOT NULL
//   AND ppbsd_pngesah2_uu_id IS NOT NULL
//   AND ppbsd_pngesah3_uu_id IS NOT NULL";
//
//   if ($conn->query($u)) {
//     $status["STATUS"] = true;
//
//     $u2 = "UPDATE a_applicant_permohonan SET
//     pembayaran_sd_stat = '6001', pembayaran_sd_date = NOW()
//     WHERE SHA2(pembayaran_ppbsd_id,256) = '$ppbsdid'";
//
//     $icno = "SELECT pt2_no_kp_pemohon FROM a_applicant_permohonan WHERE SHA2(pembayaran_ppbsd_id, 256) = '$ppbsdid'";
//     $s = "SELECT aa_username, aa_fullname as name, aa_email as email, SHA2(aa_id,256) as aa_id,
//     SHA2(aa_email,256) as aa_email, penyedia_return_note , DATE_FORMAT(pelulus_date,'%d/%m/%Y') as pelulus_date,
//     ipt.ript_sd as iptasd, bipt.ript_sd as iptssd, rbnk_name, pt2_no_akaun, pt3_jenis_ipt
//     FROM a_applicant
//     LEFT JOIN a_applicant_permohonan ON pt2_no_kp_pemohon = aa_username
//     LEFT JOIN ref_ipt ipt ON ipt.ript_id = pt3_nama_institusi
//     LEFT JOIN ref_ipt bipt ON bipt.ript_id = pt3_ins_ipts
//     LEFT JOIN ref_bank ON rbnk_id = pt2_nama_bank
//     WHERE aa_username IN ($icno)";
//     $result = $conn->query($s);
//
//     while ($row = $result->fetch_assoc()) {
//       $aaid = $row["aa_id"]; // ENCRYPTED EMAIL AND ID
//       $email = $row["aa_email"]; // ENCRYPTED EMAIL AND ID
//       $toname = $row["name"];
//       $toemail = $row["email"];
//       $toemail = $row["email"];
//       $ic = $row["aa_username"];
//       $pelulus_date = $row["pelulus_date"];
//       $pt3_jenis_ipt = $row["pt3_jenis_ipt"];
//       $iptasd = $row["iptasd"];
//       $iptssd = $row["iptssd"];
//       $rbnk_name = $row["rbnk_name"];
//       $pt2_no_akaun = $row["pt2_no_akaun"];
//
//       $status["EMAILSTATUS"][$ic] = SDpaymentProcess($aaid,$email,$toname,$toemail,$ic,$pelulus_date,$rbnk_name,$pt2_no_akaun);
//     }
//
//     if ($conn->query($u2)){ $status["STATUSAAP"] = true; } else { $status["STATUSAAP"] = false; }
//     $status["STATUSLOG"] = AdminMultipleLogSD($ppbsdid,'6001');
//   } else {
//     $status["STATUS"] = false;
//   }
//   return $status;
// }
//
// if($_POST["func"] == "transaksiProsesPembayaran"){
//   echo json_encode(transaksiProsesPembayaran($_POST));
// }
//
// function transaksiProsesPembayaran($data){
//   global $conn;
//
//   // $notransaksi= $data["notransaksi"];
//   $ppbid = $data["ppbid"];
//
//   $status["STATUS"] = false;
//   $status["STATUSAAP"] = false;
//   $status["STATUSLOG"] = false;
//
//   $s = "SELECT aap_id FROM a_applicant_permohonan
//   WHERE SHA2(pembayaran_ppb_id,256) = '$ppbid'
//   AND (pembayaran_transaction IS NULL OR pembayaran_transaction = '')";
//   $result = $conn->query($s);
//   $num = $result->num_rows;
//
//   if ($num == 0) {
//     $u = "UPDATE p_payment_baucar SET
//     ppb_status = '5002'
//     WHERE SHA2(ppb_id,256) = '$ppbid'
//     AND ppb_status = '5001'
//     AND ppb_pngesah1_uu_id IS NOT NULL
//     AND ppb_pngesah2_uu_id IS NOT NULL
//     AND ppb_pngesah3_uu_id IS NOT NULL";
//
//     if ($conn->query($u)) {
//       $status["STATUS"] = true;
//
//       $u2 = "UPDATE a_applicant_permohonan SET
//       pembayaran_hpipt_stat = '5002', pembayaran_hpipt_date = NOW()
//       WHERE SHA2(pembayaran_ppb_id,256) = '$ppbid'";
//
//       $icno = "SELECT pt2_no_kp_pemohon FROM a_applicant_permohonan WHERE SHA2(pembayaran_ppb_id, 256) = '$ppbid'";
//       $s = "SELECT aa_username, aa_fullname as name, aa_email as email, SHA2(aa_id,256) as aa_id,
//       SHA2(aa_email,256) as aa_email, penyedia_return_note , DATE_FORMAT(pelulus_date,'%d/%m/%Y') as pelulus_date,
//        rbnk_name, pt2_no_akaun, pt3_jenis_ipt, pembayaran_transaction
//       FROM a_applicant
//       LEFT JOIN a_applicant_permohonan ON pt2_no_kp_pemohon = aa_username
//       LEFT JOIN ref_bank ON rbnk_id = pt2_nama_bank
//       WHERE aa_username IN ($icno)";
//       $result = $conn->query($s);
//
//       $namelist = array();
//       while ($row = $result->fetch_assoc()){
//         $namelist[] = $row;
//         $aaid = $row["aa_id"]; // ENCRYPTED EMAIL AND ID
//         $email = $row["aa_email"]; // ENCRYPTED EMAIL AND ID
//         $toname = $row["name"];
//         $toemail = $row["email"];
//         $toemail = $row["email"];
//         $ic = $row["aa_username"];
//         $pelulus_date = $row["pelulus_date"];
//         $pt3_jenis_ipt = $row["pt3_jenis_ipt"];
//         $rbnk_name = $row["rbnk_name"];
//         $pt2_no_akaun = $row["pt2_no_akaun"];
//         $pembayaran_transaction = $row["pembayaran_transaction"];
//
//         $status["EMAILSTATUS"][$ic] = HPIPTpaymentSuccess($aaid,$email,$toname,$toemail,$ic,$pelulus_date,$rbnk_name,$pt2_no_akaun,$pembayaran_transaction);
//       }
//
//       if ($conn->query($u2)){ $status["STATUSAAP"] = true; } else { $status["STATUSAAP"] = false; }
//       $status["STATUSLOG"] = AdminMultipleLog($ppbid,'5002');
//     } else {
//       $status["STATUS"] = false;
//       $status["MSG"] = "Data Gagal Dikemaskini";
//     }
//   } else {
//     $status["STATUS"] = false;
//     $status["MSG"] = "Sila Masukkan Kesemua ID Transaksi sebelum kemaskini status penyata. Terima Kasih";
//
//   }
//
//
//   return $status;
// }
//
// if($_POST["func"] == "transaksiProsesPembayaranSD"){
//   echo json_encode(transaksiProsesPembayaranSD($_POST));
// }
//
// function transaksiProsesPembayaranSD($data){
//   global $conn;
//
//   $notransaksi= $data["notransaksi"];
//   $ppbsdid = $data["ppbsdid"];
//
//   $status["STATUS"] = false;
//   $status["STATUSAAP"] = false;
//   $status["STATUSLOG"] = false;
//
//   $u = "UPDATE p_payment_baucar_sd SET
//   ppbsd_transaction_id = '$notransaksi', ppbsd_status = '6002'
//   WHERE SHA2(ppbsd_id,256) = '$ppbsdid'
//   AND ppbsd_status = '6001'
//   AND ppbsd_pngesah1_uu_id IS NOT NULL
//   AND ppbsd_pngesah2_uu_id IS NOT NULL
//   AND ppbsd_pngesah3_uu_id IS NOT NULL";
//
//   if ($conn->query($u)) {
//     $status["STATUS"] = true;
//
//     $u2 = "UPDATE a_applicant_permohonan SET
//     pembayaran_sd_stat = '6002', pembayaran_sd_date = NOW()
//     WHERE SHA2(pembayaran_ppbsd_id,256) = '$ppbsdid'";
//
//     $icno = "SELECT pt2_no_kp_pemohon FROM a_applicant_permohonan WHERE SHA2(pembayaran_ppbsd_id, 256) = '$ppbsdid'";
//     $s = "SELECT aa_username, aa_fullname as name, aa_email as email, SHA2(aa_id,256) as aa_id,
//     SHA2(aa_email,256) as aa_email, penyedia_return_note , DATE_FORMAT(pelulus_date,'%d/%m/%Y') as pelulus_date,
//     ipt.ript_sd as iptasd, bipt.ript_sd as iptssd, rbnk_name, pt2_no_akaun, pt3_jenis_ipt
//     FROM a_applicant
//     LEFT JOIN a_applicant_permohonan ON pt2_no_kp_pemohon = aa_username
//     LEFT JOIN ref_ipt ipt ON ipt.ript_id = pt3_nama_institusi
//     LEFT JOIN ref_ipt bipt ON bipt.ript_id = pt3_ins_ipts
//     LEFT JOIN ref_bank ON rbnk_id = pt2_nama_bank
//     WHERE aa_username IN ($icno)";
//     $result = $conn->query($s);
//
//     $namelist = array();
//     while ($row = $result->fetch_assoc()){
//       $namelist[] = $row;
//       $aaid = $row["aa_id"]; // ENCRYPTED EMAIL AND ID
//       $email = $row["aa_email"]; // ENCRYPTED EMAIL AND ID
//       $toname = $row["name"];
//       $toemail = $row["email"];
//       $toemail = $row["email"];
//       $ic = $row["aa_username"];
//       $pelulus_date = $row["pelulus_date"];
//       $pt3_jenis_ipt = $row["pt3_jenis_ipt"];
//       $iptasd = $row["iptasd"];
//       $iptssd = $row["iptssd"];
//       $rbnk_name = $row["rbnk_name"];
//       $pt2_no_akaun = $row["pt2_no_akaun"];
//
//       $status["EMAILSTATUS"][$ic] = SDpaymentSuccess($aaid,$email,$toname,$toemail,$ic,$pelulus_date,$rbnk_name,$pt2_no_akaun);
//     }
//
//     $sipt = "SELECT SHA2(ppbsd_id,256) as ppbsd_id, ppbsd_baucar, ppbsd_transaction_id, ript_email, DATE_FORMAT(ppbsd_paydate,'%d/%m/%Y') as ppbsd_paydate,
//     ript_name FROM p_payment_baucar_sd
//     LEFT JOIN ref_ipt ON ript_id = ppbsd_ript_id
//     WHERE SHA2(ppbsd_id,256) = '$ppbsdid'";
//     $result = $conn->query($sipt);
//     $row = $result->fetch_assoc();
//
//     $ript_name = $row["ript_name"];
//     $ppbsd_baucar = $row["ppbsd_baucar"];
//     $ppbsd_transaction_id = $row["ppbsd_transaction_id"];
//     $ript_email = $row["ript_email"];
//     $ppbsd_paydate = $row["ppbsd_paydate"];
//     $ppbsd_id = $row["ppbsd_id"];
//
//     $status["EMAILIPT"] = SDpaymentSuccessIPT($ript_name,$ript_email,$ppbsd_paydate,$namelist,$ppbsd_id);
//
//     if ($conn->query($u2)){ $status["STATUSAAP"] = true; } else { $status["STATUSAAP"] = false; }
//     $status["STATUSLOG"] = AdminMultipleLogSD($ppbsdid,'6002');
//   } else {
//     $status["STATUS"] = false;
//   }
//   return $status;
// }
//
// if($_POST["func"] == "getpembayaranTable"){
//   echo json_encode(getpembayaranTable($_POST));
// }
//
// function getpembayaranTable($data){
//   global $conn;
//   $ppbid = $data["ppbid"];
//
//   $s = "SELECT * FROM p_payment_baucar WHERE SHA2(ppb_id,256) = '$ppbid'";
//
//   $arr = [];
//   $result = $conn->query($s);
//   while ($row = $result->fetch_assoc())
//   {
//     $arr[] = $row;
//   }
//   return $arr;
// }
//
// if($_POST["func"] == "getpembayaranTableSD"){
//   echo json_encode(getpembayaranTableSD($_POST));
// }
//
// function getpembayaranTableSD($data){
//   global $conn;
//   $ppbidsd = $data["ppbidsd"];
//
//   $s = "SELECT * FROM p_payment_baucar_sd WHERE SHA2(ppbsd_id,256) = '$ppbidsd'";
//
//   $arr = [];
//   $result = $conn->query($s);
//   while ($row = $result->fetch_assoc())
//   {
//     $arr[] = $row;
//   }
//   return $arr;
// }
//
// if($_POST["func"] == "getPenggunaBE"){
//   echo json_encode(getPenggunaBE($_POST));
// }
//
// function getPenggunaBE($data){
//   global $conn;
//
//   $columns = array(
//     // datatable column index  => database column name
//     0 => 'uu_id',
//     1 => 'uu_fullname',
//     2 => 'rpkt_name',
//     3 => 'uu_created',
//     4 => 'uu_status',
//     5 => 'uu_status',
//   );
//
//   $ppb = ''; if(isset($data["ppb"])) $ppb = $data["ppb"];
//
//   $sql = "SELECT
//   uu_id,
//   SHA2(uu_id,256) as enc_id,
//   uu_fullname,
//   rpkt_name,
//   DATE_FORMAT(uu_created,'%d/%m/%Y') as uu_created,
//   uu_status, rs_icon, rs_name, rs_color
//   FROM u_user
//   LEFT JOIN ref_pangkat ON rpkt_id = uu_rpkt_id
//   LEFT JOIN ref_status ON rs_id = uu_status
//   WHERE TRUE
//   ";
//
//   $result = $conn->query($sql);
//   $numrows = $result->num_rows;
//   $totalData = $numrows;
//
//   if(!empty($data['search']['value'])) {
//     $search = $data['search']['value'];
//     $sql.=" AND (uu_fullname  LIKE '%".$search."%' ";
//     $sql.=" OR rpkt_name LIKE '%".$search."%'";
//     $sql.=" OR uu_created LIKE '%".$search."%')";
//
//     $sql.=" ORDER BY ". $columns[$data['order'][0]['column']]." ".$data['order'][0]['dir']." LIMIT ".$data['start']." ,".$data['length']."   ";
//
//     $result = $conn->query($sql);
//     $numrows = $result->num_rows;
//     $totalFiltered = $numrows;
//   } else {
//     $sql.=" ORDER BY ". $columns[$data['order'][0]['column']]." ".$data['order'][0]['dir']." LIMIT ".$data['start']." ,".$data['length']."   ";
//     $result = $conn->query($sql);
//     $numrows = $result->num_rows;
//     $totalFiltered = $numrows;
//   }
//
//   $x = 1;
//   $datadb = array();
//   while ($row = $result->fetch_assoc()) {
//     $nestedData=array();
//     $nestedData[] = $x;
//     $nestedData[] = $row["uu_fullname"];
//     $nestedData[] = $row["rpkt_name"];
//     $nestedData[] = $row["uu_created"];
//     $nestedData[] = badge($row["rs_color"],$row["rs_icon"],$row["rs_name"]);
//     if ($row["uu_status"] == '1') {
//       $nestedData[] = '
//       <div class="btn-group row w-100">
//         <div class="btn-group col-6 p-0">
//           <button id="edituser" uuid="'.$row["enc_id"].'" type="button" class="btn btn-primary w-100">
//             <span class="p-t-5 p-b-5">
//             <i class="fa fa-edit fs-15"></i>
//             </span>
//           </button>
//         </div>
//         <div class="btn-group col-6 p-0">
//           <button id="disabled" uuid="'.$row["enc_id"].'" type="button" class="btn btn-danger w-100">
//             <span class="p-t-5 p-b-5">
//             <i class="fa fa-close fs-15"></i>
//             </span>
//           </button>
//         </div>
//       </div>';
//     } else {
//       $nestedData[] = '
//       <div class="btn-group row w-100">
//         <div class="btn-group col-6 p-0">
//           <button id="edituser" uuid="'.$row["enc_id"].'" type="button" class="btn btn-primary w-100">
//             <span class="p-t-5 p-b-5">
//             <i class="fa fa-edit fs-15"></i>
//             </span>
//           </button>
//         </div>
//         <div class="btn-group col-6 p-0">
//           <button id="enable" uuid="'.$row["enc_id"].'" type="button" class="btn btn-success w-100">
//             <span class="p-t-5 p-b-5">
//             <i class="fa fa-check fs-15"></i>
//             </span>
//           </button>
//         </div>
//       </div>';
//     }
//
//     $datadb[] = $nestedData;
//     $x++;
//   }
//
//   error_log(print_r($data,true),0);
//
//   $json_data = array(
//     "draw"            => intval( $data['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw.
//     "recordsTotal"    => intval( $totalFiltered),  // total number of records
//     "recordsFiltered" => intval( $totalData ), // total number of records after searching, if there is no searching then totalFiltered = totalData
//     "data"            => $datadb
//   );
//
//   return $json_data;
// }
//
// if($_POST["func"] == "getPemohon"){
//   echo json_encode(getPemohon($_POST));
// }
//
// function getPemohon($data){
//   global $conn;
//
//   $columns = array(
//     // datatable column index  => database column name
//     0 => 'aa_id',
//     1 => 'aa_username',
//     2 => 'pembayaran_transaction',
//     3 => 'aa_status',
//     4 => 'aa_id'
//   );
//
//   $sql = "SELECT
//   COUNT(aa_id) as count
//   FROM a_applicant
//   LEFT JOIN a_applicant_permohonan ON pt2_no_kp_pemohon = aa_username
//   WHERE TRUE
//   ";
//
//   $result = $conn->query($sql);
//   $row = $result->fetch_assoc();
//   $numrows = $row["count"];
//   $totalData = $numrows;
//
//   $sql = "SELECT
//   aa_id,
//   SHA2(aa_id,256) as enc_id,
//   aa_fullname,
//   aa_username,
//   aa_telephone,
//   aa_password,
//   aa_email,
//   aa_status,
//   pembayaran_transaction
//   FROM a_applicant
//   LEFT JOIN a_applicant_permohonan ON pt2_no_kp_pemohon = aa_username
//   WHERE TRUE
//   ";
//
//   if(!empty($data['search'])) {
//     $search = $data['search'];
//     $sql.=" AND (aa_fullname  LIKE '%".$search."%' ";
//     $sql.=" OR aa_email LIKE '%".$search."%'";
//     $sql.=" OR aa_username LIKE '%".$search."%')";
//
//     $sql.=" ORDER BY ". $columns[$data['order'][0]['column']]." ".$data['order'][0]['dir']." LIMIT ".$data['start']." ,".$data['length']."   ";
//
//     $result = $conn->query($sql);
//     $numrows = $result->num_rows;
//     $totalFiltered = $numrows;
//   } else {
//     $sql.=" ORDER BY ". $columns[$data['order'][0]['column']]." ".$data['order'][0]['dir']." LIMIT ".$data['start']." ,".$data['length']."   ";
//     $result = $conn->query($sql);
//     $numrows = $result->num_rows;
//     $totalFiltered = $numrows;
//   }
//
//   $x = 1;
//   $datadb = array();
//   while ($row = $result->fetch_assoc()) {
//
//     if ($row["aa_fullname"] == 'null' || $row["aa_fullname"] == '' || $row["aa_fullname"] == null) {
//       $row["aa_fullname"] = "<strong class='text-danger'>[NO FULLNAME]</strong>";
//     }
//
//     if ($row["aa_password"] == 'null' || $row["aa_password"] == '' || $row["aa_password"] == null) {
//       $row["aa_password"] = "<strong class='text-danger'>[NO PASSWORD]</strong>";
//     } else {
//       $row["aa_password"] = "[ENCYPTED PASSWORD]";
//     }
//
//     if ($row["aa_status"] == "3") {
//       $pstat = "Migrate User";
//     } else if ($row["aa_status"] == "1") {
//       $pstat = "Email Verified";
//     } else if ($row["aa_status"] == "0") {
//       $pstat = "Email Not Verified";
//     }
//
//     if (!filter_var($row["aa_email"], FILTER_VALIDATE_EMAIL) || $row["aa_email"] == '' || $row["aa_email"] == null) {
//       $row["aa_email"] = "<strong class='text-danger'>[EMAIL NOT VALID]</strong>";
//     }
//
//
//     $nestedData=array();
//     $nestedData[] = $row["aa_id"];
//     $nestedData[] = $row["aa_username"]."<br>".$row["aa_fullname"]."<br>".$row["aa_email"]."<br>".$row["aa_password"];
//     $nestedData[] = $row["pembayaran_transaction"];
//     $nestedData[] = $pstat;
//     $nestedData[] = '
//     <div class="btn-group row w-100">
//       <div class="btn-group col-6 p-0">
//         <button id="edituser" aaid="'.$row["enc_id"].'" type="button" class="btn btn-primary w-100">
//           <span class="p-t-5 p-b-5">
//           <i class="fa fa-edit fs-15"></i>
//           </span>
//         </button>
//       </div>
//       <div class="btn-group col-6 p-0">
//         <button id="resetUser" aaid="'.$row["enc_id"].'" type="button" class="btn btn-danger w-100">
//           <span class="p-t-5 p-b-5">
//           <i class="fa fa-refresh fs-15"></i>
//           </span>
//         </button>
//       </div>
//     </div>';
//
//     $datadb[] = $nestedData;
//     $x++;
//   }
//
//   error_log(print_r($data,true),0);
//
//   $json_data = array(
//     "draw"            => intval( $data['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw.
//     "recordsTotal"    => intval( $totalFiltered),  // total number of records
//     "recordsFiltered" => intval( $totalData ), // total number of records after searching, if there is no searching then totalFiltered = totalData
//     "data"            => $datadb
//   );
//
//   return $json_data;
// }
//
// if($_POST["func"] == "getPemohonInfo"){
//   $data["U"] = getPemohonInfo($_POST);
//   echo json_encode($data);
// }
//
// function getPemohonInfo($data){
//   global $conn;
//   $id = $data["aaid"];
//
//   $s = "SELECT * FROM a_applicant WHERE SHA2(aa_id,256) = '$id'";
//
//   $arr = [];
//   $result = $conn->query($s);
//   while ($row = $result->fetch_assoc())
//   {
//     $arr[] = $row;
//   }
//   return $arr;
// }
//
// if($_POST["func"] == "hardresetpemohon"){
//   echo json_encode(hardresetpemohon($_POST));
// }
//
// function hardresetpemohon($data){
//   global $conn;
//
//   $id = $_SESSION["ID"];
//   $aaid = $data["aaid"];
//
//   $suser = "SELECT aa_username FROM a_applicant WHERE SHA2(aa_id,256) = '$aaid'";
//
//   $s = "SELECT pt2_no_kp_pemohon FROM a_applicant_permohonan
//   WHERE pt2_no_kp_pemohon = ($suser) AND
//   (pembayaran_transaction IS NULL OR pembayaran_transaction = '')";
//
//   $res = $conn->query($s);
//   $row = $res->fetch_assoc();
//   $num = $res->num_rows;
//
//   if ($num > 0) {
//     $nokp = $row["pt2_no_kp_pemohon"];
//     $u = "UPDATE a_applicant_permohonan SET
//     status_permohonan = '0000',
//     kaunter_document_stat = '1010',
//     kaunter_application_stat = '1000',
//     penyedia_stat = '2000',
//     penyedia_return_stat = '2000',
//     penyemak_stat = '3000',
//     pelulus_stat = '4000',
//     pembayaran_hpipt_stat = '5000',
//     pembayaran_sd_stat = '6000'
//     WHERE pt2_no_kp_pemohon = '$nokp'";
//
//     if($conn->query($u)){
//       $status["STATUS"] = true;
//       $status["MSG"] = 'Permohonan Berjaya Direset';
//     } else {
//       $status["STATUS"] = false;
//       $status["MSG"] = 'Permohonan Reset Gagal Dikemaskini';
//     }
//   } else {
//     $status["STATUS"] = false;
//     $status["MSG"] = 'Permohonan Tidak Boleh Direset kerana permohon telah lulus HPIPT';
//   }
//
//   return $status;
// }
//
//
// if($_POST["func"] == "editPemohon"){
//   echo json_encode(editPemohon($_POST));
// }
//
// function editPemohon($data){
//   global $conn;
//   global $cfg_salt;
//
//   $aaid = $data["aaid"];
//   $aa_fullname = $data["aa_name"];
//   $aa_email = $data["aa_email"];
//   $aa_telephone = $data["aa_phone"];
//   $aa_status = $data["aa_status"];
//
//   if (isset($data["aa_password"]) && $data["aa_password"] != '') {
//     $status["PWCHANGE"] = true;
//     $aa_password = $data["aa_password"];
//     $aa_password = hash('sha256', $cfg_salt.$aa_password);
//
//     $u = "UPDATE a_applicant SET
//     aa_fullname = '$aa_fullname',
//     aa_email = '$aa_email',
//     aa_telephone = '$aa_telephone',
//     aa_status = '$aa_status',
//     aa_password = '$aa_password'
//     WHERE SHA2(aa_id,256) = '$aaid'";
//   } else {
//     $status["PWCHANGE"] = false;
//     $u = "UPDATE a_applicant SET
//     aa_fullname = '$aa_fullname',
//     aa_email = '$aa_email',
//     aa_telephone = '$aa_telephone',
//     aa_status = '$aa_status'
//     WHERE SHA2(aa_id,256) = '$aaid'";
//   }
//
//   if ($conn->query($u)) {
//     $status["STATUS"] = true;
//   } else {
//     $status["STATUS"] = false;
//   }
//
//   return $status;
// }
//
// if($_POST["func"] == "enable-user"){
//   echo json_encode(enableUser($_POST));
// }
//
// function enableUser($data){
//   global $conn;
//
//   $uuid = $data["uuid"];
//   $u = "UPDATE u_user SET uu_status = '1' WHERE SHA2(uu_id,256) = '$uuid'";
//   if ($conn->query($u)) {
//     $status["STATUS"] = true;
//   } else {
//     $status["STATUS"] = false;
//   }
//
//   return $status;
// }
//
// if($_POST["func"] == "disable-user"){
//   echo json_encode(disableUser($_POST));
// }
//
// function disableUser($data){
//   global $conn;
//
//   $uuid = $data["uuid"];
//   $u = "UPDATE u_user SET uu_status = '0' WHERE SHA2(uu_id,256) = '$uuid'";
//   if ($conn->query($u)) {
//     $status["STATUS"] = true;
//   } else {
//     $status["STATUS"] = false;
//   }
//
//   return $status;
// }
//
//
// if($_POST["func"] == "getUserInfos"){
//   $data["U"] = getUserInfos($_POST);
//   $data["R"] = getUserRole($_POST);
//   echo json_encode($data);
// }
//
// function getUserInfos($data){
//   global $conn;
//   $uu_id = $data["uuid"];
//
//   $s = "SELECT * FROM u_user WHERE SHA2(uu_id,256) = '$uu_id'";
//
//   $arr = [];
//   $result = $conn->query($s);
//   while ($row = $result->fetch_assoc())
//   {
//     $arr[] = $row;
//   }
//   return $arr;
// }
//
// function getUserRole($data){
//   global $conn;
//   $uu_id = $data["uuid"];
//
//   $s = "SELECT * FROM u_user_role WHERE SHA2(uur_uu_id,256) = '$uu_id'";
//
//   $arr = [];
//   $result = $conn->query($s);
//   while ($row = $result->fetch_assoc())
//   {
//     $arr[] = $row;
//   }
//   return $arr;
// }
//
// if($_POST["func"] == "insertUser"){
//   echo json_encode(insertUser($_POST));
// }
//
// function insertUser($data){
//   global $conn;
//   global $cfg_salt;
//
//   $uu_email = '';
//   $uu_phone = '';
//   $uu_fax = '';
//   $uu_rpkt_id = '';
//
//   $uu_username = $data["uu_username"];
//   $uu_password = $cfg_salt.$data["uu_password"];
//   $uu_password = hash('sha256', $uu_password);
//   $uu_fullname = $data["uu_fullname"];
//   if(isset($data["uu_email"])) $uu_email = $data["uu_email"];
//   if(isset($data["uu_phone"])) $uu_phone = $data["uu_phone"];
//   if(isset($data["uu_fax"])) $uu_fax = $data["uu_fax"];
//   if(isset($data["uu_fax"])) $uu_rpkt_id = $data["pangkat"];
//
//
//   $i = "INSERT INTO u_user
//   (uu_username,	uu_password,	uu_email,	uu_fullname,	uu_phone,	uu_fax,	uu_created,	uu_status,	uu_rpkt_id)
//   VALUES
//   ('$uu_username',	'$uu_password',	'$uu_email',	'$uu_fullname',	'$uu_phone',	'$uu_fax',	NOW(),	0,	'$uu_rpkt_id')
//   ";
//
//   if ($conn->query($i)) {
//     $status["STATUS"] = true;
//   } else {
//     $status["STATUS"] = false;
//   }
//
//   return $status;
// }
//
// if($_POST["func"] == "editUser"){
//   echo json_encode(editUser($_POST));
// }
//
// function editUser($data){
//   global $conn;
//   global $cfg_salt;
//
//   $uu_email = '';
//   $uu_phone = '';
//   $uu_fax = '';
//   $uu_rpkt_id = '';
//   $uuid = $data["uuid"];
//
//   if(isset($data["uu_email"])) $uu_email = $data["uu_email"];
//   if(isset($data["uu_phone"])) $uu_phone = $data["uu_phone"];
//   if(isset($data["uu_fax"])) $uu_fax = $data["uu_fax"];
//   if(isset($data["uu_fax"])) $uu_rpkt_id = $data["pangkat"];
//   if (isset($data["uu_password"]) && strlen($data["uu_password"]) > 5) {
//     $uu_password = $cfg_salt.$data["uu_password"];
//     $uu_password = hash('sha256', $uu_password);
//     $u = "UPDATE u_user SET uu_password = '$uu_password', uu_email = '$uu_email', uu_phone = '$uu_phone',	uu_fax = '$uu_fax',	uu_rpkt_id = '$uu_rpkt_id' WHERE SHA2(uu_id,256) = '$uuid'";
//   } else {
//     $u = "UPDATE u_user SET uu_email = '$uu_email', uu_phone = '$uu_phone',	uu_fax = '$uu_fax',	uu_rpkt_id = '$uu_rpkt_id' WHERE SHA2(uu_id,256) = '$uuid'";
//   }
//
//   if ($conn->query($u)) {
//     $status["STATUS"] = true;
//   } else {
//     $status["STATUS"] = false;
//   }
//
//   return $status;
// }
//
// if($_POST["func"] == "changePassword"){
//   echo json_encode(changePassword($_POST));
// }
//
// function changePassword($data){
//   global $conn;
//   global $cfg_salt;
//
//   $old_password = $data["Oldpassword"];
//   $old_password = $cfg_salt.$old_password;
//   $old_password = hash('sha256', $old_password);
//
//   $new_password = $data["password"];
//   $new_password = $cfg_salt.$new_password;
//   $new_password = hash('sha256', $new_password);
//
//   $id = $_SESSION["ID"];
//
//   $s = "SELECT uu_password FROM u_user WHERE uu_id = '$id'";
//   $result = $conn->query($s);
//   $row = $result->fetch_assoc();
//
//   if($row["uu_password"] == $old_password){
//     $i = "UPDATE u_user SET uu_password = '$new_password' WHERE uu_id = '$id'";
//     if ($conn->query($i)) {
//       $status["STATUS"] = true;
//       $status["MSG"] = "Katalaluan Dikemaskini";
//     } else {
//       $status["STATUS"] = false;
//       $status["MSG"] = "Katalaluan Gagal Dikemaskini";
//     }
//   } else {
//     $status["STATUS"] = false;
//     $status["MSG"] = "Katalaluan Salah";
//   }
//
//   return $status;
// }
//
// if($_POST["func"] == "updateRole"){
//   echo json_encode(updateRole($_POST));
// }
//
// function updateRole($data){
//   global $conn;
//
//   $rrid = $data["rrid"];
//   $uuid = $data["uuid"];
//   $checked = $data["checked"];
//
//   if ($checked == 'true') {
//     $sid = "SELECT uu_id FROM u_user WHERE SHA2(uu_id,256) = '$uuid'";
//     $u = "INSERT INTO u_user_role (uur_uu_id, uur_rr_id, uur_status) VALUES (($sid),'$rrid',1)";
//   } else {
//     $u = "DELETE FROM u_user_role WHERE SHA2(uur_uu_id,256) = '$uuid' AND uur_rr_id = '$rrid'";
//   }
//
//   if ($conn->query($u)) {
//     $status["STATUS"] = true;
//   } else {
//     $status["STATUS"] = false;
//   }
//
//   return $status;
// }
//
// if($_POST["func"] == "getNewsAdmin"){
//   echo json_encode(getNewsAdmin($_POST));
// }
//
// function getNewsAdmin($data){
//   global $conn;
//
//   $columns = array(
//     // datatable column index  => database column name
//     0 => 'cn_id',
//     1 => 'cn_news',
//     2 => 'cn_date',
//     3 => 'cn_status'
//   );
//
//   $ppb = ''; if(isset($data["ppb"])) $ppb = $data["ppb"];
//
//   $sql = "SELECT cn_id, SHA2(cn_id,256) as enc_id , cn_news, DATE_FORMAT(cn_date,'%d-%m-%Y') as cn_date, cn_status, rs_icon, rs_color, rs_name
//   FROM c_news
//   LEFT JOIN ref_status ON cn_status = rs_id
//
//   WHERE TRUE ";
//
//   $result = $conn->query($sql);
//   $numrows = $result->num_rows;
//   $totalData = $numrows;
//
//   if(!empty($data['search']['value'])) {
//     $search = $data['search']['value'];
//     $sql.=" AND (cn_news  LIKE '%".$search."%' ";
//     $sql.=" OR cn_date LIKE '%".$search."%' )";
//
//     $sql.=" ORDER BY ". $columns[$data['order'][0]['column']]." ".$data['order'][0]['dir']." LIMIT ".$data['start']." ,".$data['length']."   ";
//
//     $result = $conn->query($sql);
//     $numrows = $result->num_rows;
//     $totalFiltered = $numrows;
//   } else {
//     $sql.=" ORDER BY ". $columns[$data['order'][0]['column']]." ".$data['order'][0]['dir']." LIMIT ".$data['start']." ,".$data['length']."   ";
//     $result = $conn->query($sql);
//     $numrows = $result->num_rows;
//     $totalFiltered = $numrows;
//   }
//
//   $x = 1;
//   $datadb = array();
//   while ($row = $result->fetch_assoc()) {
//     $nestedData=array();
//     $nestedData[] = $row["cn_id"];
//     $nestedData[] = $row["cn_news"];
//     $nestedData[] = $row["cn_date"];
//     $nestedData[] = badge($row["rs_color"],$row["rs_icon"],$row["rs_name"]);
//     if ($row["cn_status"] == '1') {
//       $nestedData[] = '
//       <div class="btn-group row w-100">
//         <div class="btn-group col-4 p-0">
//           <button id="edituser" cnid="'.$row["enc_id"].'" type="button" class="btn btn-primary w-100">
//             <span class="p-t-5 p-b-5">
//             <i class="fa fa-edit fs-15"></i>
//             </span>
//           </button>
//         </div>
//         <div class="btn-group col-4 p-0">
//           <button id="disabled" cnid="'.$row["enc_id"].'" type="button" class="btn btn-warning w-100">
//             <span class="p-t-5 p-b-5">
//             <i class="fa fa-close fs-15"></i>
//             </span>
//           </button>
//         </div>
//         <div class="btn-group col-4 p-0">
//           <button id="delete" cnid="'.$row["enc_id"].'" type="button" class="btn btn-danger w-100">
//             <span class="p-t-5 p-b-5">
//             <i class="fa fa-trash fs-15"></i>
//             </span>
//           </button>
//         </div>
//       </div>';
//     } else {
//       $nestedData[] = '
//       <div class="btn-group row w-100">
//         <div class="btn-group col-4 p-0">
//           <button id="edituser" cnid="'.$row["enc_id"].'" type="button" class="btn btn-primary w-100">
//             <span class="p-t-5 p-b-5">
//             <i class="fa fa-edit fs-15"></i>
//             </span>
//           </button>
//         </div>
//         <div class="btn-group col-4 p-0">
//           <button id="enable" cnid="'.$row["enc_id"].'" type="button" class="btn btn-success w-100">
//             <span class="p-t-5 p-b-5">
//             <i class="fa fa-check fs-15"></i>
//             </span>
//           </button>
//         </div>
//         <div class="btn-group col-4 p-0">
//           <button id="delete" cnid="'.$row["enc_id"].'" type="button" class="btn btn-danger w-100">
//             <span class="p-t-5 p-b-5">
//             <i class="fa fa-trash fs-15"></i>
//             </span>
//           </button>
//         </div>
//       </div>';
//     }
//
//     $datadb[] = $nestedData;
//     $x++;
//   }
//
//   error_log(print_r($data,true),0);
//
//   $json_data = array(
//     "draw"            => intval( $data['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw.
//     "recordsTotal"    => intval( $totalFiltered),  // total number of records
//     "recordsFiltered" => intval( $totalData ), // total number of records after searching, if there is no searching then totalFiltered = totalData
//     "data"            => $datadb
//   );
//
//   return $json_data;
// }
//
// if($_POST["func"] == "getNews"){
//   $data["N"] = getNews($_POST);
//   echo json_encode($data);
// }
//
// function getNews($data){
//   global $conn;
//   $cn_id = $data["cnid"];
//
//   $s = "SELECT *, DATE_FORMAT(cn_date,'%d-%m-%Y') as cn_date FROM c_news WHERE SHA2(cn_id,256) = '$cn_id'";
//
//   $arr = [];
//   $result = $conn->query($s);
//   while ($row = $result->fetch_assoc())
//   {
//     $arr[] = $row;
//   }
//   return $arr;
// }
//
// if($_POST["func"] == "enable-news"){
//   echo json_encode(enableNews($_POST));
// }
//
// function enableNews($data){
//   global $conn;
//
//   $cnid = $data["cnid"];
//   $u = "UPDATE c_news SET cn_status = '1' WHERE SHA2(cn_id,256) = '$cnid'";
//   if ($conn->query($u)) {
//     $status["STATUS"] = true;
//   } else {
//     $status["STATUS"] = false;
//   }
//
//   return $status;
// }
//
// if($_POST["func"] == "disable-news"){
//   echo json_encode(disableNews($_POST));
// }
//
// function disableNews($data){
//   global $conn;
//
//   $cnid = $data["cnid"];
//   $u = "UPDATE c_news SET cn_status = '0' WHERE SHA2(cn_id,256) = '$cnid'";
//   if ($conn->query($u)) {
//     $status["STATUS"] = true;
//   } else {
//     $status["STATUS"] = false;
//   }
//
//   return $status;
// }
//
// if($_POST["func"] == "insertNews"){
//   echo json_encode(insertNews($_POST));
// }
//
// function insertNews($data){
//   global $conn;
//
//   $cn_news = $data["cn_news"];
//   $cn_date = $data["cn_date"];
//   $cn_status = $data["cn_status"];
//
//   $i = "INSERT INTO c_news (cn_news,	cn_date,	cn_status) VALUES ('$cn_news',	'$cn_date',	'$cn_status') ";
//
//   if ($conn->query($i)) {
//     $status["STATUS"] = true;
//   } else {
//     $status["STATUS"] = false;
//   }
//
//   return $status;
// }
//
// if($_POST["func"] == "updateNews"){
//   echo json_encode(updateNews($_POST));
// }
//
// function updateNews($data){
//   global $conn;
//
//   $cn_id = $data["cnid"];
//   $cn_news = $data["cn_news"];
//   $cn_date = $data["cn_date"];
//   $cn_status = $data["cn_status"];
//
//   $i = "UPDATE c_news SET cn_news= '$cn_news',	cn_date= '$cn_date',	cn_status= '$cn_status' WHERE SHA2(cn_id,256) = '$cn_id'";
//
//   if ($conn->query($i)) {
//     $status["STATUS"] = true;
//   } else {
//     $status["STATUS"] = false;
//   }
//
//   return $status;
// }
//
// if($_POST["func"] == "deleteNews"){
//   echo json_encode(deleteNews($_POST));
// }
//
// function deleteNews($data){
//   global $conn;
//
//   $cn_id = $data["cnid"];
//
//   $i = "DELETE FROM c_news WHERE SHA2(cn_id,256) = '$cn_id'";
//
//   if ($conn->query($i)) {
//     $status["STATUS"] = true;
//   } else {
//     $status["STATUS"] = false;
//   }
//
//   return $status;
// }
//
//
//
// if($_POST["func"] == "getKpiReport"){
//   echo json_encode(getKpiReport($_POST));
// }
//
// function getKpiReport($data){
//   global $conn;
//
//   $columns = array(
//     // datatable column index  => database column name
//     0 => 'uu_id',
//     1 => 'uu_fullname',
//     2 => 'kaunter',
//     3 => 'penyedia',
//     4 => 'penyemak',
//     5 => 'pelulus',
//     6 => 'uu_id',
//   );
//
//   $year = $data["tahun"];
//
//   $sqldate = "AND YEAR(asl_datetime) = '$year'";
//
//   $sql = "SELECT uu_id, uu_fullname,
//   (SELECT count(asl_id) FROM a_status_log WHERE asl_rs_id IN ('1001','1002','1003') AND asl_uu_id = uu_id $sqldate) as kaunter,
//   (SELECT count(asl_id) FROM a_status_log WHERE asl_rs_id IN ('2001','2002') AND asl_uu_id = uu_id $sqldate) as penyedia,
//   (SELECT count(asl_id) FROM a_status_log WHERE asl_rs_id IN ('3001','3002') AND asl_uu_id = uu_id $sqldate) as penyemak,
//   (SELECT count(asl_id) FROM a_status_log WHERE asl_rs_id IN ('4001','4002') AND asl_uu_id = uu_id $sqldate) as pelulus
//   FROM u_user";
//
//   $result = $conn->query($sql);
//   $numrows = $result->num_rows;
//   $totalData = $numrows;
//
//   if(!empty($data['search']['value'])) {
//     $search = $data['search']['value'];
//     $sql.=" AND (cn_news  LIKE '%".$search."%' ";
//     $sql.=" OR cn_date LIKE '%".$search."%' )";
//
//     $sql.=" ORDER BY ". $columns[$data['order'][0]['column']]." ".$data['order'][0]['dir']." LIMIT ".$data['start']." ,".$data['length']."   ";
//
//     $result = $conn->query($sql);
//     $numrows = $result->num_rows;
//     $totalFiltered = $numrows;
//   } else {
//     $sql.=" ORDER BY ". $columns[$data['order'][0]['column']]." ".$data['order'][0]['dir']." LIMIT ".$data['start']." ,".$data['length']."   ";
//     $result = $conn->query($sql);
//     $numrows = $result->num_rows;
//     $totalFiltered = $numrows;
//   }
//
//   $x = 1;
//   $datadb = array();
//   while ($row = $result->fetch_assoc()) {
//     $nestedData=array();
//     $nestedData[] = $row["uu_id"];;
//     $nestedData[] = $row["uu_fullname"];
//     $nestedData[] = $row["kaunter"];
//     $nestedData[] = $row["penyedia"];
//     $nestedData[] = $row["penyemak"];
//     $nestedData[] = $row["pelulus"];
//     $nestedData[] = $row["kaunter"] + $row["penyedia"] + $row["penyemak"] + $row["pelulus"];
//
//     $datadb[] = $nestedData;
//     $x++;
//   }
//
//   error_log(print_r($data,true),0);
//
//   $json_data = array(
//     "draw"            => intval( $data['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw.
//     "recordsTotal"    => intval( $totalFiltered),  // total number of records
//     "recordsFiltered" => intval( $totalData ), // total number of records after searching, if there is no searching then totalFiltered = totalData
//     "data"            => $datadb
//   );
//
//   return $json_data;
// }
//
// if($_POST["func"] == "getKpiReport2"){
//   echo json_encode(getKpiReport2($_POST));
// }
//
// function getKpiReport2($data){
//   global $conn;
//
//   $columns = array(
//     // datatable column index  => database column name
//     0 => 'uu_id',
//     1 => 'uu_fullname',
//     2 => 'range1',
//     3 => 'range2',
//     4 => 'range3',
//     4 => 'range3'
//   );
//
//   $year = $data["tahun"];
//
//   $sqldate = "AND YEAR(asl_datetime) = '$year'";
//
//   $col1 = "AND DATEDIFF(a_status_log.asl_datetime, t2.asl_datetime) <= 30";
//   $col2 = "AND DATEDIFF(a_status_log.asl_datetime, t2.asl_datetime) > 30 AND DATEDIFF(a_status_log.asl_datetime, t2.asl_datetime) < 60";
//   $col3 = "AND DATEDIFF(a_status_log.asl_datetime, t2.asl_datetime) > 60";
//
//   $basicsql = "SELECT count(a_status_log.asl_id) as count
//   FROM a_status_log LEFT JOIN a_status_log AS t2 ON t2.asl_id = a_status_log.asl_id + 1 WHERE TRUE
//   AND a_status_log.asl_aap_id = t2.asl_aap_id
//   AND a_status_log.asl_uu_id = uu_id ";
//
//   $sql = "SELECT uu_id, uu_fullname,
//   ($basicsql $col1 AND year(a_status_log.asl_datetime) = '$year' ) as range1,
//   ($basicsql $col2 AND year(a_status_log.asl_datetime) = '$year' ) as range2,
//   ($basicsql $col3 AND year(a_status_log.asl_datetime) = '$year' ) as range3
//   FROM u_user";
//
//   $result = $conn->query($sql);
//   $numrows = $result->num_rows;
//   $totalData = $numrows;
//
//   if(!empty($data['search']['value'])) {
//     $search = $data['search']['value'];
//     $sql.=" AND (cn_news  LIKE '%".$search."%' ";
//     $sql.=" OR cn_date LIKE '%".$search."%' )";
//
//     $sql.=" ORDER BY ". $columns[$data['order'][0]['column']]." ".$data['order'][0]['dir']." LIMIT ".$data['start']." ,".$data['length']."   ";
//
//     $result = $conn->query($sql);
//     $numrows = $result->num_rows;
//     $totalFiltered = $numrows;
//   } else {
//     $sql.=" ORDER BY ". $columns[$data['order'][0]['column']]." ".$data['order'][0]['dir']." LIMIT ".$data['start']." ,".$data['length']."   ";
//     $result = $conn->query($sql);
//     $numrows = $result->num_rows;
//     $totalFiltered = $numrows;
//   }
//
//   $x = 1;
//   $datadb = array();
//   while ($row = $result->fetch_assoc()) {
//     $nestedData=array();
//     $nestedData[] = $row["uu_id"];;
//     $nestedData[] = $row["uu_fullname"];
//     $nestedData[] = $row["range1"];
//     $nestedData[] = $row["range2"];
//     $nestedData[] = $row["range3"];
//     $nestedData[] = $row["range1"] + $row["range2"] + $row["range3"];
//
//     $datadb[] = $nestedData;
//     $x++;
//   }
//
//   error_log(print_r($data,true),0);
//
//   $json_data = array(
//     "draw"            => intval( $data['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw.
//     "recordsTotal"    => intval( $totalFiltered),  // total number of records
//     "recordsFiltered" => intval( $totalData ), // total number of records after searching, if there is no searching then totalFiltered = totalData
//     "data"            => $datadb
//   );
//
//   return $json_data;
// }
//
// if($_POST["func"] == "getKpiReport3"){
//   echo json_encode(getKpiReport3($_POST));
// }
//
// function getKpiReport3($data){
//   global $conn;
//
//   $columns = array(
//     // datatable column index  => database column name
//     0 => 'uu_id',
//     1 => 'uu_fullname',
//     2 => 'layak',
//     3 => 'tidaklengkap',
//     4 => 'tidaklayak',
//     5 => 'jumlah'
//   );
//
//   $year = $data["tahun"];
//
//   $sqldate = "AND YEAR(asl_datetime) = '$year'";
//
//   $col1 = "AND asl_rs_id = '1001'";
//   $col2 = "AND asl_rs_id = '1002'";
//   $col3 = "AND asl_rs_id = '1003'";
//   $col4 = "AND asl_rs_id IN ('1001','1002','1003')";
//
//   $basicsql = "SELECT count(asl_id) as counter FROM a_status_log WHERE asl_uu_id = uu_id   ";
//
//   $sql = "SELECT uu_id, uu_fullname,
//   ($basicsql $col1 AND year(asl_datetime) = '$year' ) as layak,
//   ($basicsql $col2 AND year(asl_datetime) = '$year' ) as tidaklengkap,
//   ($basicsql $col3 AND year(asl_datetime) = '$year' ) as tidaklayak,
//   ($basicsql $col4 AND year(asl_datetime) = '$year' ) as jumlah
//   FROM u_user";
//
//   $result = $conn->query($sql);
//   $numrows = $result->num_rows;
//   $totalData = $numrows;
//
//   if(!empty($data['search']['value'])) {
//     $search = $data['search']['value'];
//     $sql.=" AND (cn_news  LIKE '%".$search."%' ";
//     $sql.=" OR cn_date LIKE '%".$search."%' )";
//
//     $sql.=" ORDER BY ". $columns[$data['order'][0]['column']]." ".$data['order'][0]['dir']." LIMIT ".$data['start']." ,".$data['length']."   ";
//
//     $result = $conn->query($sql);
//     $numrows = $result->num_rows;
//     $totalFiltered = $numrows;
//   } else {
//     $sql.=" ORDER BY ". $columns[$data['order'][0]['column']]." ".$data['order'][0]['dir']." LIMIT ".$data['start']." ,".$data['length']."   ";
//     $result = $conn->query($sql);
//     $numrows = $result->num_rows;
//     $totalFiltered = $numrows;
//   }
//
//   $x = 1;
//   $datadb = array();
//
//   $jumlah["layak"] = 0;
//   $jumlah["tidaklayak"] = 0;
//   $jumlah["tidaklengkap"] = 0;
//   $jumlah["jumlah"] = 0;
//
//   while ($row = $result->fetch_assoc()) {
//     $nestedData=array();
//     $nestedData[] = $row["uu_id"];;
//     $nestedData[] = $row["uu_fullname"];
//     $nestedData[] = $row["layak"];
//     $nestedData[] = $row["tidaklayak"];
//     $nestedData[] = $row["tidaklengkap"];
//     $nestedData[] = $row["jumlah"];
//
//     $jumlah["layak"] += $row["layak"];
//     $jumlah["tidaklayak"] += $row["tidaklayak"];
//     $jumlah["tidaklengkap"] += $row["tidaklengkap"];
//     $jumlah["jumlah"] += $row["jumlah"];
//
//     $datadb[] = $nestedData;
//     $x++;
//   }
//
//   error_log(print_r($data,true),0);
//
//   $json_data = array(
//     "draw"            => intval( $data['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw.
//     "recordsTotal"    => intval( $totalFiltered),  // total number of records
//     "recordsFiltered" => intval( $totalData ), // total number of records after searching, if there is no searching then totalFiltered = totalData
//     "data"            => $datadb,
//     "footer"          => $jumlah
//   );
//
//   return $json_data;
// }
//
// if($_POST["func"] == "updateHPIPTTransactionID"){
//   echo json_encode(updateHPIPTTransactionID($_POST));
// }
//
// function updateHPIPTTransactionID($data){
//   global $conn;
//
//   $value = $data["value"];
//   $aap = $data["aap"];
//
//   $i = "UPDATE a_applicant_permohonan SET pembayaran_transaction = '$value' WHERE SHA2(aap_id,256) = '$aap'";
//
//   if ($conn->query($i)) {
//     $status["STATUS"] = true;
//   } else {
//     $status["STATUS"] = false;
//   }
//
//   return $status;
// }
//
// // report
//
// if($_POST["func"] == "sParlimenReport"){
//   echo json_encode(sParlimenReport($_POST));
// }
//
// function sParlimenReport($data){
//   global $conn;
//
//   $columns = array(
//     // datatable column index  => database column name
//     0 => 'rpar_code',
//     1 => 'rpar_name',
//     2 => 'melayu_lulus',
//     3 => 'cina_lulus',
//     4 => 'india_lulus',
//     5 => 'lain_lulus',
//     6 => 'melayu_gagal',
//     7 => 'cina_gagal',
//     8 => 'india_gagal',
//     9 => 'lain_gagal',
//     10 => 'jumlah',
//   );
//
//   $year = $data["tahun"];
//
//   $where = "";
//   if(!empty($data['search']['value'])) {
//     $search = $data['search']['value'];
//     $where.=" AND (rpar_name  LIKE '%".$search."%' ";
//     $where.=" OR rpar_code LIKE '%".$search."%' )";
//   }
//
//   // $sqldate = "AND YEAR(pelulus_date) = '$year'";
//   //
//   // $sql = "SELECT rpar_code, rpar_name,
//   // (SELECT count(aap_id) FROM a_applicant_permohonan WHERE pt1_parlimen = rpar_code AND pelulus_stat = '4001' AND pt2_keturunan_pemohon = 1 $sqldate) as melayu_lulus,
//   // (SELECT count(aap_id) FROM a_applicant_permohonan WHERE pt1_parlimen = rpar_code AND pelulus_stat = '4001' AND pt2_keturunan_pemohon = 2 $sqldate) as cina_lulus,
//   // (SELECT count(aap_id) FROM a_applicant_permohonan WHERE pt1_parlimen = rpar_code AND pelulus_stat = '4001' AND pt2_keturunan_pemohon = 3 $sqldate) as india_lulus,
//   // (SELECT count(aap_id) FROM a_applicant_permohonan WHERE pt1_parlimen = rpar_code AND pelulus_stat = '4001' AND pt2_keturunan_pemohon = 99 $sqldate) as lain_lulus,
//   // (SELECT count(aap_id) FROM a_applicant_permohonan WHERE pt1_parlimen = rpar_code AND pelulus_stat = '4002' AND pt2_keturunan_pemohon = 1 $sqldate) as melayu_gagal,
//   // (SELECT count(aap_id) FROM a_applicant_permohonan WHERE pt1_parlimen = rpar_code AND pelulus_stat = '4002' AND pt2_keturunan_pemohon = 2 $sqldate) as cina_gagal,
//   // (SELECT count(aap_id) FROM a_applicant_permohonan WHERE pt1_parlimen = rpar_code AND pelulus_stat = '4002' AND pt2_keturunan_pemohon = 3 $sqldate) as india_gagal,
//   // (SELECT count(aap_id) FROM a_applicant_permohonan WHERE pt1_parlimen = rpar_code AND pelulus_stat = '4002' AND pt2_keturunan_pemohon = 99 $sqldate)  as lain_gagal,
//   // (SELECT count(aap_id) FROM a_applicant_permohonan WHERE pt1_parlimen = rpar_code AND pelulus_stat IN ('4001','4002') $sqldate)  as jumlah
//   // FROM ref_parlimen WHERE TRUE ";
//
//   $sql = "SELECT rpar_code, rpar_name,
//   SUM(pt1_parlimen = rpar_code AND pelulus_stat = '4001' AND pt2_keturunan_pemohon = 1 ) as melayu_lulus,
//   SUM(pt1_parlimen = rpar_code AND pelulus_stat = '4001' AND pt2_keturunan_pemohon = 2 ) as cina_lulus,
//   SUM(pt1_parlimen = rpar_code AND pelulus_stat = '4001' AND pt2_keturunan_pemohon = 3 ) as india_lulus,
//   SUM(pt1_parlimen = rpar_code AND pelulus_stat = '4001' AND pt2_keturunan_pemohon = 99 ) as lain_lulus,
//   SUM(pt1_parlimen = rpar_code AND pelulus_stat = '4002' AND pt2_keturunan_pemohon = 1 ) as melayu_gagal,
//   SUM(pt1_parlimen = rpar_code AND pelulus_stat = '4002' AND pt2_keturunan_pemohon = 2 ) as cina_gagal,
//   SUM(pt1_parlimen = rpar_code AND pelulus_stat = '4002' AND pt2_keturunan_pemohon = 3 ) as india_gagal,
//   SUM(pt1_parlimen = rpar_code AND pelulus_stat = '4002' AND pt2_keturunan_pemohon = 99 ) as lain_gagal,
//   SUM(pt1_parlimen = rpar_code AND pelulus_stat IN ('4001','4002') AND pt2_keturunan_pemohon IN (1,2,3,99)) as jumlah
//   FROM a_applicant_permohonan LEFT JOIN ref_parlimen ON rpar_code = pt1_parlimen WHERE YEAR(tarikh_permohonan) = '$year' AND rpar_name != '' $where GROUP BY pt1_parlimen";
//
//   $sqlcount = "SELECT rdun_code, rdun_name
//   FROM a_applicant_permohonan LEFT JOIN ref_parlimen ON rpar_code = pt1_parlimen WHERE YEAR(tarikh_permohonan) = '$year' AND rpar_name != '' $where GROUP BY pt1_parlimen";
//
//   $result = $conn->query($sql);
//   $numrows = $result->num_rows;
//   $totalData = $numrows;
//
//   $sql.=" ORDER BY ". $columns[$data['order'][0]['column']]." ".$data['order'][0]['dir']." LIMIT ".$data['start']." ,".$data['length']."   ";
//   $result = $conn->query($sql);
//   $numrows = $result->num_rows;
//   $totalFiltered = $numrows;
//
//   $x = 1;
//   $datadb = array();
//   $jumlah["melayu_lulus"] = 0;
//   $jumlah["cina_lulus"] = 0;
//   $jumlah["india_lulus"] = 0;
//   $jumlah["lain_lulus"] = 0;
//   $jumlah["melayu_gagal"] = 0;
//   $jumlah["cina_gagal"] = 0;
//   $jumlah["india_gagal"] = 0;
//   $jumlah["lain_gagal"] = 0;
//   $jumlah["jumlah"] = 0;
//
//   while ($row = $result->fetch_assoc()) {
//     $nestedData=array();
//     $nestedData[] = $row["rpar_code"];;
//     $nestedData[] = $row["rpar_name"];
//     $nestedData[] = $row["melayu_lulus"];
//     $nestedData[] = $row["cina_lulus"];
//     $nestedData[] = $row["india_lulus"];
//     $nestedData[] = $row["lain_lulus"];
//     $nestedData[] = $row["melayu_gagal"];
//     $nestedData[] = $row["cina_gagal"];
//     $nestedData[] = $row["india_gagal"];
//     $nestedData[] = $row["lain_gagal"];
//     $nestedData[] = $row["jumlah"];
//
//     $jumlah["melayu_lulus"] += $row["melayu_lulus"];
//     $jumlah["cina_lulus"] += $row["cina_lulus"];
//     $jumlah["india_lulus"] += $row["india_lulus"];
//     $jumlah["lain_lulus"] += $row["lain_lulus"];
//     $jumlah["melayu_gagal"] += $row["melayu_gagal"];
//     $jumlah["cina_gagal"] += $row["cina_gagal"];
//     $jumlah["india_gagal"] += $row["india_gagal"];
//     $jumlah["lain_gagal"] += $row["lain_gagal"];
//     $jumlah["jumlah"] += $row["jumlah"];
//
//     $datadb[] = $nestedData;
//     $x++;
//   }
//
//   error_log(print_r($data,true),0);
//
//   $json_data = array(
//     "draw"            => intval( $data['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw.
//     "recordsTotal"    => intval( $totalFiltered),  // total number of records
//     "recordsFiltered" => intval( $totalData ), // total number of records after searching, if there is no searching then totalFiltered = totalData
//     "data"            => $datadb,
//     "footer"          => $jumlah,
//   );
//
//   return $json_data;
// }
//
// if($_POST["func"] == "sDunReport"){
//   echo json_encode(sDunReport($_POST));
// }
//
// function sDunReport($data){
//   global $conn;
//
//   $columns = array(
//     // datatable column index  => database column name
//     0 => 'rdun_code',
//     1 => 'rdun_name',
//     2 => 'melayu_lulus',
//     3 => 'cina_lulus',
//     4 => 'india_lulus',
//     5 => 'lain_lulus',
//     6 => 'melayu_gagal',
//     7 => 'cina_gagal',
//     8 => 'india_gagal',
//     9 => 'lain_gagal',
//     10 => 'jumlah',
//   );
//
//   $year = $data["tahun"];
//   $sqldate = "AND YEAR(tarikh_permohonan) = '$year'";
//   $where = "";
//   if(!empty($data['search']['value'])) {
//     $search = $data['search']['value'];
//     $where.=" AND (rdun_name  LIKE '%".$search."%' ";
//     $where.=" OR rdun_code LIKE '%".$search."%' )";
//   }
//
//   $sqlcount = "SELECT rdun_code, rdun_name
//   FROM a_applicant_permohonan LEFT JOIN ref_dun ON rdun_code = pt1_dun WHERE YEAR(tarikh_permohonan) = '$year' AND rdun_name != '' $where GROUP BY pt1_dun";
//
//   $result = $conn->query($sqlcount);
//   $numrows = $result->num_rows;
//   $totalData = $numrows;
//
//   $sql = "SELECT rdun_code, rdun_name,
//   SUM(pt1_dun = rdun_code AND pelulus_stat = '4001' AND pt2_keturunan_pemohon = 1 ) as melayu_lulus,
//   SUM(pt1_dun = rdun_code AND pelulus_stat = '4001' AND pt2_keturunan_pemohon = 2 ) as cina_lulus,
//   SUM(pt1_dun = rdun_code AND pelulus_stat = '4001' AND pt2_keturunan_pemohon = 3 ) as india_lulus,
//   SUM(pt1_dun = rdun_code AND pelulus_stat = '4001' AND pt2_keturunan_pemohon = 99 ) as lain_lulus,
//   SUM(pt1_dun = rdun_code AND pelulus_stat = '4002' AND pt2_keturunan_pemohon = 1 ) as melayu_gagal,
//   SUM(pt1_dun = rdun_code AND pelulus_stat = '4002' AND pt2_keturunan_pemohon = 2 ) as cina_gagal,
//   SUM(pt1_dun = rdun_code AND pelulus_stat = '4002' AND pt2_keturunan_pemohon = 3 ) as india_gagal,
//   SUM(pt1_dun = rdun_code AND pelulus_stat = '4002' AND pt2_keturunan_pemohon = 99 ) as lain_gagal,
//   SUM(pt1_dun = rdun_code AND pelulus_stat IN ('4001','4002') AND pt2_keturunan_pemohon IN (1,2,3,99)) as jumlah
//   FROM a_applicant_permohonan LEFT JOIN ref_dun ON rdun_code = pt1_dun WHERE YEAR(tarikh_permohonan) = '$year' AND rdun_name != '' $where GROUP BY pt1_dun";
//
//   $sql.=" ORDER BY ". $columns[$data['order'][0]['column']]." ".$data['order'][0]['dir']." LIMIT ".$data['start']." ,".$data['length']."   ";
//   $result = $conn->query($sql);
//   $numrows = $result->num_rows;
//   $totalFiltered = $numrows;
//
//   $x = 1;
//   $datadb = array();
//   $jumlah["melayu_lulus"] = 0;
//   $jumlah["cina_lulus"] = 0;
//   $jumlah["india_lulus"] = 0;
//   $jumlah["lain_lulus"] = 0;
//   $jumlah["melayu_gagal"] = 0;
//   $jumlah["cina_gagal"] = 0;
//   $jumlah["india_gagal"] = 0;
//   $jumlah["lain_gagal"] = 0;
//   $jumlah["jumlah"] = 0;
//
//   while ($row = $result->fetch_assoc()) {
//     $nestedData=array();
//     $nestedData[] = $row["rdun_code"];;
//     $nestedData[] = $row["rdun_name"];
//     $nestedData[] = $row["melayu_lulus"];
//     $nestedData[] = $row["cina_lulus"];
//     $nestedData[] = $row["india_lulus"];
//     $nestedData[] = $row["lain_lulus"];
//     $nestedData[] = $row["melayu_gagal"];
//     $nestedData[] = $row["cina_gagal"];
//     $nestedData[] = $row["india_gagal"];
//     $nestedData[] = $row["lain_gagal"];
//     $nestedData[] = $row["jumlah"];
//
//     $jumlah["melayu_lulus"] += $row["melayu_lulus"];
//     $jumlah["cina_lulus"] += $row["cina_lulus"];
//     $jumlah["india_lulus"] += $row["india_lulus"];
//     $jumlah["lain_lulus"] += $row["lain_lulus"];
//     $jumlah["melayu_gagal"] += $row["melayu_gagal"];
//     $jumlah["cina_gagal"] += $row["cina_gagal"];
//     $jumlah["india_gagal"] += $row["india_gagal"];
//     $jumlah["lain_gagal"] += $row["lain_gagal"];
//     $jumlah["jumlah"] += $row["jumlah"];
//
//     $datadb[] = $nestedData;
//     $x++;
//   }
//
//   error_log(print_r($data,true),0);
//
//   $json_data = array(
//     "draw"            => intval( $data['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw.
//     "recordsTotal"    => intval( $totalFiltered),  // total number of records
//     "recordsFiltered" => intval( $totalData ), // total number of records after searching, if there is no searching then totalFiltered = totalData
//     "data"            => $datadb,
//     "footer"          => $jumlah
//   );
//
//   return $json_data;
// }
//
// if($_POST["func"] == "sIPTReport"){
//   echo json_encode(sIPTReport($_POST));
// }
//
// function sIPTReport($data){
//   global $conn;
//
//   $columns = array(
//     // datatable column index  => database column name
//     0 => 'ript_id',
//     1 => 'ript_name',
//     2 => 'melayu_lulus',
//     3 => 'cina_lulus',
//     4 => 'india_lulus',
//     5 => 'lain_lulus',
//     6 => 'melayu_gagal',
//     7 => 'cina_gagal',
//     8 => 'india_gagal',
//     9 => 'lain_gagal',
//     10 => 'jumlah',
//   );
//
//   $year = $data["tahun"];
//   $prewhere = "";
//
//   $col["0"] = "pt3_nama_institusi";
//   $col["1"] = "pt3_nama_institusi";
//   $col["2"] = "pt3_ins_ipts";
//   $col["3"] = "pt3_ins_ipts";
//
//   if (isset($data["jenisipt"]) && $data["jenisipt"] != '') {
//     $jns = $data["jenisipt"];
//     $prewhere = " AND ript_rit_id = '$jns'";
//   } else {
//     $jns = '0';
//     $prewhere = " AND ript_rit_id = '1'";
//   }
//
//   $column = $col[$jns];
//
//   if(!empty($data['search']['value'])) {
//     $search = $data['search']['value'];
//     $prewhere.=" AND (ript_name  LIKE '%".$search."%' ";
//     $prewhere.=" OR ript_id LIKE '%".$search."%' )";
//   }
//
//   $sqldate = "AND YEAR(tarikh_permohonan) = '$year' AND $column != ''";
//   $sqlcount = "SELECT ript_id, ript_name
//   FROM a_applicant_permohonan LEFT JOIN ref_ipt ON (ript_id = pt3_nama_institusi OR ript_id = pt3_ins_ipts) WHERE TRUE $sqldate $prewhere GROUP BY ript_id";
//
//   $result = $conn->query($sqlcount);
//   $numrows = $result->num_rows;
//   $totalData = $numrows;
//
//   $sql = "SELECT ript_id, ript_name,
//   SUM((ript_id = $column) AND pelulus_stat = '4001' AND pt2_keturunan_pemohon = 1 ) as melayu_lulus,
//   SUM((ript_id = $column) AND pelulus_stat = '4001' AND pt2_keturunan_pemohon = 2 ) as cina_lulus,
//   SUM((ript_id = $column) AND pelulus_stat = '4001' AND pt2_keturunan_pemohon = 3 ) as india_lulus,
//   SUM((ript_id = $column) AND pelulus_stat = '4001' AND pt2_keturunan_pemohon = 99 ) as lain_lulus,
//   SUM((ript_id = $column) AND pelulus_stat = '4002' AND pt2_keturunan_pemohon = 1 ) as melayu_gagal,
//   SUM((ript_id = $column) AND pelulus_stat = '4002' AND pt2_keturunan_pemohon = 2 ) as cina_gagal,
//   SUM((ript_id = $column) AND pelulus_stat = '4002' AND pt2_keturunan_pemohon = 3 ) as india_gagal,
//   SUM((ript_id = $column) AND pelulus_stat = '4002' AND pt2_keturunan_pemohon = 99 ) as lain_gagal,
//   SUM((ript_id = $column) AND pelulus_stat IN ('4001','4002') AND pt2_keturunan_pemohon IN (1,2,3,99)) as jumlah
//   FROM a_applicant_permohonan LEFT JOIN ref_ipt ON (ript_id = $column) WHERE TRUE $sqldate $prewhere GROUP BY ript_id";
//
//   $sql.=" ORDER BY ". $columns[$data['order'][0]['column']]." ".$data['order'][0]['dir']." LIMIT ".$data['start']." ,".$data['length']."   ";
//   $result = $conn->query($sql);
//   $numrows = $result->num_rows;
//   $totalFiltered = $numrows;
//
//   $x = 1;
//   $datadb = array();
//   $jumlah["melayu_lulus"] = 0;
//   $jumlah["cina_lulus"] = 0;
//   $jumlah["india_lulus"] = 0;
//   $jumlah["lain_lulus"] = 0;
//   $jumlah["melayu_gagal"] = 0;
//   $jumlah["cina_gagal"] = 0;
//   $jumlah["india_gagal"] = 0;
//   $jumlah["lain_gagal"] = 0;
//   $jumlah["jumlah"] = 0;
//
//   while ($row = $result->fetch_assoc()) {
//     $nestedData=array();
//     $nestedData[] = $row["ript_id"];;
//     $nestedData[] = $row["ript_name"];
//     $nestedData[] = $row["melayu_lulus"];
//     $nestedData[] = $row["cina_lulus"];
//     $nestedData[] = $row["india_lulus"];
//     $nestedData[] = $row["lain_lulus"];
//     $nestedData[] = $row["melayu_gagal"];
//     $nestedData[] = $row["cina_gagal"];
//     $nestedData[] = $row["india_gagal"];
//     $nestedData[] = $row["lain_gagal"];
//     $nestedData[] = $row["jumlah"];
//
//     $jumlah["melayu_lulus"] += $row["melayu_lulus"];
//     $jumlah["cina_lulus"] += $row["cina_lulus"];
//     $jumlah["india_lulus"] += $row["india_lulus"];
//     $jumlah["lain_lulus"] += $row["lain_lulus"];
//     $jumlah["melayu_gagal"] += $row["melayu_gagal"];
//     $jumlah["cina_gagal"] += $row["cina_gagal"];
//     $jumlah["india_gagal"] += $row["india_gagal"];
//     $jumlah["lain_gagal"] += $row["lain_gagal"];
//     $jumlah["jumlah"] += $row["jumlah"];
//
//     $datadb[] = $nestedData;
//     $x++;
//   }
//
//   error_log(print_r($data,true),0);
//
//   $json_data = array(
//     "draw"            => intval( $data['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw.
//     "recordsTotal"    => intval( $totalFiltered),  // total number of records
//     "recordsFiltered" => intval( $totalData ), // total number of records after searching, if there is no searching then totalFiltered = totalData
//     "data"            => $datadb,
//     "footer"          => $jumlah,
//   );
//
//   return $json_data;
// }
//
// if($_POST["func"] == "sJenisIPTReport"){
//   echo json_encode(sJenisIPTReport($_POST));
// }
//
// function sJenisIPTReport($data){
//   global $conn;
//
//   $columns = array(
//     // datatable column index  => database column name
//     0 => 'yearapp',
//     1 => 'melayu_lulus_a',
//     2 => 'cina_lulus_a',
//     3 => 'india_lulus_a',
//     4 => 'lain_lulus_a',
//     5 => 'melayu_gagal_s',
//     6 => 'cina_gagal_s',
//     7 => 'india_gagal_s',
//     8 => 'lain_gagal_s',
//     9 => 'melayu_gagal_l',
//     10 => 'cina_gagal_l',
//     11 => 'india_gagal_l',
//     12 => 'lain_gagal_l',
//     13 => 'jumlah',
//   );
//
//   $statusp = $data["statusp"];
//   $sqldate = "";
//   $where = "";
//   if(!empty($data['search']['value'])) {
//     $search = $data['search']['value'];
//     $where.=" AND (YEAR(tarikh_permohonan)  LIKE '%".$search."%' )";
//   }
//
//   $sql = "SELECT YEAR(tarikh_permohonan) as yearapp
//   FROM a_applicant_permohonan WHERE tarikh_permohonan IS NOT NULL $where GROUP BY YEAR(tarikh_permohonan)";
//
//   $result = $conn->query($sql);
//   $numrows = $result->num_rows;
//   $totalData = $numrows;
//
//   $sqls = "SELECT YEAR(tarikh_permohonan) as yearapp,
//   SUM((YEAR(tarikh_permohonan) = YEAR(tarikh_permohonan)) AND pelulus_stat = '$statusp' AND pt2_keturunan_pemohon = 1 AND pt3_jenis_ipt = 1) as melayu_lulus_a,
//   SUM((YEAR(tarikh_permohonan) = YEAR(tarikh_permohonan)) AND pelulus_stat = '$statusp' AND pt2_keturunan_pemohon = 2 AND pt3_jenis_ipt = 1) as cina_lulus_a,
//   SUM((YEAR(tarikh_permohonan) = YEAR(tarikh_permohonan)) AND pelulus_stat = '$statusp' AND pt2_keturunan_pemohon = 3 AND pt3_jenis_ipt = 1) as india_lulus_a,
//   SUM((YEAR(tarikh_permohonan) = YEAR(tarikh_permohonan)) AND pelulus_stat = '$statusp' AND pt2_keturunan_pemohon = 99 AND pt3_jenis_ipt = 1) as lain_lulus_a,
//   SUM((YEAR(tarikh_permohonan) = YEAR(tarikh_permohonan)) AND pelulus_stat = '$statusp' AND pt2_keturunan_pemohon = 1 AND pt3_jenis_ipt = 2) as melayu_gagal_s,
//   SUM((YEAR(tarikh_permohonan) = YEAR(tarikh_permohonan)) AND pelulus_stat = '$statusp' AND pt2_keturunan_pemohon = 2 AND pt3_jenis_ipt = 2) as cina_gagal_s,
//   SUM((YEAR(tarikh_permohonan) = YEAR(tarikh_permohonan)) AND pelulus_stat = '$statusp' AND pt2_keturunan_pemohon = 3 AND pt3_jenis_ipt = 2) as india_gagal_s,
//   SUM((YEAR(tarikh_permohonan) = YEAR(tarikh_permohonan)) AND pelulus_stat = '$statusp' AND pt2_keturunan_pemohon = 99 AND pt3_jenis_ipt = 2) as lain_gagal_s,
//   SUM((YEAR(tarikh_permohonan) = YEAR(tarikh_permohonan)) AND pelulus_stat = '$statusp' AND pt2_keturunan_pemohon = 1 AND pt3_jenis_ipt = 3) as melayu_gagal_l,
//   SUM((YEAR(tarikh_permohonan) = YEAR(tarikh_permohonan)) AND pelulus_stat = '$statusp' AND pt2_keturunan_pemohon = 2 AND pt3_jenis_ipt = 3) as cina_gagal_l,
//   SUM((YEAR(tarikh_permohonan) = YEAR(tarikh_permohonan)) AND pelulus_stat = '$statusp' AND pt2_keturunan_pemohon = 3 AND pt3_jenis_ipt = 3) as india_gagal_l,
//   SUM((YEAR(tarikh_permohonan) = YEAR(tarikh_permohonan)) AND pelulus_stat = '$statusp' AND pt2_keturunan_pemohon = 99 AND pt3_jenis_ipt = 3) as lain_gagal_l,
//   SUM((YEAR(tarikh_permohonan) = YEAR(tarikh_permohonan)) AND pelulus_stat = '$statusp' AND pt2_keturunan_pemohon IN (1,2,3,99) AND pt3_jenis_ipt IN (1,2,3)) as jumlah
//   FROM a_applicant_permohonan WHERE tarikh_permohonan IS NOT NULL $where GROUP BY YEAR(tarikh_permohonan)";
//
//   $sqls.=" ORDER BY ". $columns[$data['order'][0]['column']]." ".$data['order'][0]['dir']." LIMIT ".$data['start']." ,".$data['length']."   ";
//   $result = $conn->query($sqls);
//   $numrows = $result->num_rows;
//   $totalFiltered = $numrows;
//
//   $x = 1;
//   $datadb = array();
//   $jumlah["melayu_lulus_a"] = 0;
//   $jumlah["cina_lulus_a"] = 0;
//   $jumlah["india_lulus_a"] = 0;
//   $jumlah["lain_lulus_a"] = 0;
//   $jumlah["melayu_gagal_s"] = 0;
//   $jumlah["cina_gagal_s"] = 0;
//   $jumlah["india_gagal_s"] = 0;
//   $jumlah["lain_gagal_s"] = 0;
//   $jumlah["melayu_gagal_l"] = 0;
//   $jumlah["cina_gagal_l"] = 0;
//   $jumlah["india_gagal_l"] = 0;
//   $jumlah["lain_gagal_l"] = 0;
//   $jumlah["jumlah"] = 0;
//
//   while ($row = $result->fetch_assoc()) {
//     $nestedData=array();
//     $nestedData[] = $row["yearapp"];
//     $nestedData[] = $row["melayu_lulus_a"];
//     $nestedData[] = $row["cina_lulus_a"];
//     $nestedData[] = $row["india_lulus_a"];
//     $nestedData[] = $row["lain_lulus_a"];
//     $nestedData[] = $row["melayu_gagal_s"];
//     $nestedData[] = $row["cina_gagal_s"];
//     $nestedData[] = $row["india_gagal_s"];
//     $nestedData[] = $row["lain_gagal_s"];
//     $nestedData[] = $row["melayu_gagal_l"];
//     $nestedData[] = $row["cina_gagal_l"];
//     $nestedData[] = $row["india_gagal_l"];
//     $nestedData[] = $row["lain_gagal_l"];
//     $nestedData[] = $row["jumlah"];
//
//     $jumlah["melayu_lulus_a"] += $row["melayu_lulus_a"];
//     $jumlah["cina_lulus_a"] += $row["cina_lulus_a"];
//     $jumlah["india_lulus_a"] += $row["india_lulus_a"];
//     $jumlah["lain_lulus_a"] += $row["lain_lulus_a"];
//     $jumlah["melayu_gagal_s"] += $row["melayu_gagal_s"];
//     $jumlah["cina_gagal_s"] += $row["cina_gagal_s"];
//     $jumlah["india_gagal_s"] += $row["india_gagal_s"];
//     $jumlah["lain_gagal_s"] += $row["lain_gagal_s"];
//     $jumlah["melayu_gagal_l"] += $row["melayu_gagal_l"];
//     $jumlah["cina_gagal_l"] += $row["cina_gagal_l"];
//     $jumlah["india_gagal_l"] += $row["india_gagal_l"];
//     $jumlah["lain_gagal_l"] += $row["lain_gagal_l"];
//     $jumlah["jumlah"] += $row["jumlah"];
//
//     $datadb[] = $nestedData;
//     $x++;
//   }
//
//   error_log(print_r($data,true),0);
//
//   $json_data = array(
//     "draw"            => intval( $data['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw.
//     "recordsTotal"    => intval( $totalFiltered),  // total number of records
//     "recordsFiltered" => intval( $totalData ), // total number of records after searching, if there is no searching then totalFiltered = totalData
//     "data"            => $datadb,
//     "footer"          => $jumlah,
//   );
//
//   return $json_data;
// }
//
// if($_POST["func"] == "sBangsaReport"){
//   echo json_encode(sBangsaReport($_POST));
// }
//
// function sBangsaReport($data){
//   global $conn;
//
//   $columns = array(
//     // datatable column index  => database column name
//     0 => 'yearapp',
//     1 => 'melayu_lulus',
//     2 => 'cina_lulus',
//     3 => 'india_lulus',
//     4 => 'lain_lulus',
//     5 => 'melayu_gagal',
//     6 => 'cina_gagal',
//     7 => 'india_gagal',
//     8 => 'lain_gagal',
//     9 => 'jumlah',
//   );
//
//   $sqldate = "";
//   $where = "";
//   if(!empty($data['search']['value'])) {
//     $search = $data['search']['value'];
//     $where.=" AND YEAR(tarikh_permohonan) LIKE '%".$search."%' ";
//   }
//
//   // $sql = "SELECT YEAR(tarikh_permohonan) as yearapp,
//   // (SELECT count(aap_id) FROM a_applicant_permohonan a WHERE (YEAR(a.tarikh_permohonan) = YEAR(tarikh_permohonan)) AND pelulus_stat = '4001' AND pt2_keturunan_pemohon = 1 $sqldate) as melayu_lulus,
//   // (SELECT count(aap_id) FROM a_applicant_permohonan a WHERE (YEAR(a.tarikh_permohonan) = YEAR(tarikh_permohonan)) AND pelulus_stat = '4001' AND pt2_keturunan_pemohon = 2 $sqldate) as cina_lulus,
//   // (SELECT count(aap_id) FROM a_applicant_permohonan a WHERE (YEAR(a.tarikh_permohonan) = YEAR(tarikh_permohonan)) AND pelulus_stat = '4001' AND pt2_keturunan_pemohon = 3 $sqldate) as india_lulus,
//   // (SELECT count(aap_id) FROM a_applicant_permohonan a WHERE (YEAR(a.tarikh_permohonan) = YEAR(tarikh_permohonan)) AND pelulus_stat = '4001' AND pt2_keturunan_pemohon = 99 $sqldate) as lain_lulus,
//   // (SELECT count(aap_id) FROM a_applicant_permohonan a WHERE (YEAR(a.tarikh_permohonan) = YEAR(tarikh_permohonan)) AND pelulus_stat = '4002' AND pt2_keturunan_pemohon = 1 $sqldate) as melayu_gagal,
//   // (SELECT count(aap_id) FROM a_applicant_permohonan a WHERE (YEAR(a.tarikh_permohonan) = YEAR(tarikh_permohonan)) AND pelulus_stat = '4002' AND pt2_keturunan_pemohon = 2 $sqldate) as cina_gagal,
//   // (SELECT count(aap_id) FROM a_applicant_permohonan a WHERE (YEAR(a.tarikh_permohonan) = YEAR(tarikh_permohonan)) AND pelulus_stat = '4002' AND pt2_keturunan_pemohon = 3 $sqldate) as india_gagal,
//   // (SELECT count(aap_id) FROM a_applicant_permohonan a WHERE (YEAR(a.tarikh_permohonan) = YEAR(tarikh_permohonan)) AND pelulus_stat = '4002' AND pt2_keturunan_pemohon = 99 $sqldate)  as lain_gagal,
//   // (SELECT count(aap_id) FROM a_applicant_permohonan a WHERE (YEAR(a.tarikh_permohonan) = YEAR(tarikh_permohonan)) AND pelulus_stat IN ('4001','4002') $sqldate)  as jumlah
//   // FROM a_applicant_permohonan WHERE tarikh_permohonan IS NOT NULL GROUP BY YEAR(tarikh_permohonan)";
//
//   $sql = "SELECT YEAR(tarikh_permohonan) as yearapp
//   FROM a_applicant_permohonan WHERE tarikh_permohonan IS NOT NULL $where GROUP BY YEAR(tarikh_permohonan)";
//
//   $result = $conn->query($sql);
//   $numrows = $result->num_rows;
//   $totalData = $numrows;
//
//   $sqls = "SELECT YEAR(tarikh_permohonan) as yearapp,
//   SUM(YEAR(tarikh_permohonan) = YEAR(tarikh_permohonan) AND pelulus_stat = '4001' AND pt2_keturunan_pemohon = 1) as melayu_lulus,
//   SUM(YEAR(tarikh_permohonan) = YEAR(tarikh_permohonan) AND pelulus_stat = '4001' AND pt2_keturunan_pemohon = 2) as cina_lulus,
//   SUM(YEAR(tarikh_permohonan) = YEAR(tarikh_permohonan) AND pelulus_stat = '4001' AND pt2_keturunan_pemohon = 3) as india_lulus,
//   SUM(YEAR(tarikh_permohonan) = YEAR(tarikh_permohonan) AND pelulus_stat = '4001' AND pt2_keturunan_pemohon = 99) as lain_lulus,
//   SUM(YEAR(tarikh_permohonan) = YEAR(tarikh_permohonan) AND pelulus_stat = '4002' AND pt2_keturunan_pemohon = 1) as melayu_gagal,
//   SUM(YEAR(tarikh_permohonan) = YEAR(tarikh_permohonan) AND pelulus_stat = '4002' AND pt2_keturunan_pemohon = 2) as cina_gagal,
//   SUM(YEAR(tarikh_permohonan) = YEAR(tarikh_permohonan) AND pelulus_stat = '4002' AND pt2_keturunan_pemohon = 3) as india_gagal,
//   SUM(YEAR(tarikh_permohonan) = YEAR(tarikh_permohonan) AND pelulus_stat = '4002' AND pt2_keturunan_pemohon = 99) as lain_gagal,
//   SUM(YEAR(tarikh_permohonan) = YEAR(tarikh_permohonan) AND pelulus_stat IN ('4001','4002') AND pt2_keturunan_pemohon IN (1,2,3,99)) as jumlah
//   FROM a_applicant_permohonan WHERE tarikh_permohonan IS NOT NULL $where GROUP BY YEAR(tarikh_permohonan)";
//
//   $sqls.=" ORDER BY ". $columns[$data['order'][0]['column']]." ".$data['order'][0]['dir']." LIMIT ".$data['start']." ,".$data['length']."   ";
//   $result = $conn->query($sqls);
//   $numrows = $result->num_rows;
//   $totalFiltered = $numrows;
//
//   $x = 1;
//   $datadb = array();
//   $jumlah["melayu_lulus"] = 0;
//   $jumlah["cina_lulus"] = 0;
//   $jumlah["india_lulus"] = 0;
//   $jumlah["lain_lulus"] = 0;
//   $jumlah["melayu_gagal"] = 0;
//   $jumlah["cina_gagal"] = 0;
//   $jumlah["india_gagal"] = 0;
//   $jumlah["lain_gagal"] = 0;
//   $jumlah["jumlah"] = 0;
//
//   while ($row = $result->fetch_assoc()) {
//     $nestedData=array();
//     $nestedData[] = $row["yearapp"];
//     $nestedData[] = $row["melayu_lulus"];
//     $nestedData[] = $row["cina_lulus"];
//     $nestedData[] = $row["india_lulus"];
//     $nestedData[] = $row["lain_lulus"];
//     $nestedData[] = $row["melayu_gagal"];
//     $nestedData[] = $row["cina_gagal"];
//     $nestedData[] = $row["india_gagal"];
//     $nestedData[] = $row["lain_gagal"];
//     $nestedData[] = $row["jumlah"];
//
//     $jumlah["melayu_lulus"] += $row["melayu_lulus"];
//     $jumlah["cina_lulus"] += $row["cina_lulus"];
//     $jumlah["india_lulus"] += $row["india_lulus"];
//     $jumlah["lain_lulus"] += $row["lain_lulus"];
//     $jumlah["melayu_gagal"] += $row["melayu_gagal"];
//     $jumlah["cina_gagal"] += $row["cina_gagal"];
//     $jumlah["india_gagal"] += $row["india_gagal"];
//     $jumlah["lain_gagal"] += $row["lain_gagal"];
//     $jumlah["jumlah"] += $row["jumlah"];
//
//     $datadb[] = $nestedData;
//     $x++;
//   }
//
//   error_log(print_r($data,true),0);
//
//   $json_data = array(
//     "draw"            => intval( $data['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw.
//     "recordsTotal"    => intval( $totalFiltered),  // total number of records
//     "recordsFiltered" => intval( $totalData ), // total number of records after searching, if there is no searching then totalFiltered = totalData
//     "data"            => $datadb,
//     "footer"          => $jumlah,
//   );
//
//   return $json_data;
// }
//
// if($_POST["func"] == "sJantinaReport"){
//   echo json_encode(sJantinaReport($_POST));
// }
//
// function sJantinaReport($data){
//   global $conn;
//
//   $columns = array(
//     // datatable column index  => database column name
//     0 => 'yearapp',
//     1 => 'melayu_lulus_l',
//     2 => 'melayu_lulus_p',
//     3 => 'cina_lulus_l',
//     4 => 'cina_lulus_p',
//     5 => 'india_lulus_l',
//     6 => 'india_lulus_p',
//     7 => 'lain_lulus_l',
//     8 => 'lain_lulus_p',
//     9 => 'melayu_gagal_l',
//     10 => 'melayu_gagal_p',
//     11 => 'cina_gagal_l',
//     12 => 'cina_gagal_p',
//     13 => 'india_gagal_l',
//     14 => 'india_gagal_p',
//     15 => 'lain_gagal_l',
//     16 => 'lain_gagal_p',
//     17 => 'jumlah',
//   );
//
//   $sqldate = "";
//   $lelaki = "AND pt2_jantina_pemohon = '1'";
//   $perempuan = "AND pt2_jantina_pemohon = '2'";
//
//   $where = "";
//   if(!empty($data['search']['value'])) {
//     $search = $data['search']['value'];
//     $where.=" AND (YEAR(tarikh_permohonan) LIKE '%".$search."%' )";
//   }
//
//   $sql = "SELECT YEAR(tarikh_permohonan) as yearapp
//   FROM a_applicant_permohonan WHERE tarikh_permohonan IS NOT NULL $where GROUP BY YEAR(tarikh_permohonan) ";
//
//   $result = $conn->query($sql);
//   $numrows = $result->num_rows;
//   $totalData = $numrows;
//
//
//
//   $sqls = "SELECT YEAR(tarikh_permohonan) as yearapp,
//   SUM(YEAR(tarikh_permohonan) = YEAR(tarikh_permohonan) AND pelulus_stat = '4001' AND pt2_keturunan_pemohon = 1 $lelaki) as melayu_lulus_l,
//   SUM(YEAR(tarikh_permohonan) = YEAR(tarikh_permohonan) AND pelulus_stat = '4001' AND pt2_keturunan_pemohon = 1 $perempuan) as melayu_lulus_p,
//   SUM(YEAR(tarikh_permohonan) = YEAR(tarikh_permohonan) AND pelulus_stat = '4001' AND pt2_keturunan_pemohon = 2 $lelaki) as cina_lulus_l,
//   SUM(YEAR(tarikh_permohonan) = YEAR(tarikh_permohonan) AND pelulus_stat = '4001' AND pt2_keturunan_pemohon = 2 $perempuan) as cina_lulus_p,
//   SUM(YEAR(tarikh_permohonan) = YEAR(tarikh_permohonan) AND pelulus_stat = '4001' AND pt2_keturunan_pemohon = 3 $lelaki) as india_lulus_l,
//   SUM(YEAR(tarikh_permohonan) = YEAR(tarikh_permohonan) AND pelulus_stat = '4001' AND pt2_keturunan_pemohon = 3 $perempuan) as india_lulus_p,
//   SUM(YEAR(tarikh_permohonan) = YEAR(tarikh_permohonan) AND pelulus_stat = '4001' AND pt2_keturunan_pemohon = 99 $lelaki) as lain_lulus_l,
//   SUM(YEAR(tarikh_permohonan) = YEAR(tarikh_permohonan) AND pelulus_stat = '4001' AND pt2_keturunan_pemohon = 99 $perempuan) as lain_lulus_p,
//   SUM(YEAR(tarikh_permohonan) = YEAR(tarikh_permohonan) AND pelulus_stat = '4002' AND pt2_keturunan_pemohon = 1 $lelaki) as melayu_gagal_l,
//   SUM(YEAR(tarikh_permohonan) = YEAR(tarikh_permohonan) AND pelulus_stat = '4002' AND pt2_keturunan_pemohon = 1 $perempuan) as melayu_gagal_p,
//   SUM(YEAR(tarikh_permohonan) = YEAR(tarikh_permohonan) AND pelulus_stat = '4002' AND pt2_keturunan_pemohon = 2 $lelaki) as cina_gagal_l,
//   SUM(YEAR(tarikh_permohonan) = YEAR(tarikh_permohonan) AND pelulus_stat = '4002' AND pt2_keturunan_pemohon = 2 $perempuan) as cina_gagal_p,
//   SUM(YEAR(tarikh_permohonan) = YEAR(tarikh_permohonan) AND pelulus_stat = '4002' AND pt2_keturunan_pemohon = 3 $lelaki) as india_gagal_l,
//   SUM(YEAR(tarikh_permohonan) = YEAR(tarikh_permohonan) AND pelulus_stat = '4002' AND pt2_keturunan_pemohon = 3 $perempuan) as india_gagal_p,
//   SUM(YEAR(tarikh_permohonan) = YEAR(tarikh_permohonan) AND pelulus_stat = '4002' AND pt2_keturunan_pemohon = 99 $lelaki) as lain_gagal_l,
//   SUM(YEAR(tarikh_permohonan) = YEAR(tarikh_permohonan) AND pelulus_stat = '4002' AND pt2_keturunan_pemohon = 99 $perempuan) as lain_gagal_p,
//   SUM(YEAR(tarikh_permohonan) = YEAR(tarikh_permohonan) AND pelulus_stat IN ('4001','4002') AND pt2_keturunan_pemohon IN (1,2,3,99) AND pt2_jantina_pemohon IN (1,2)) as jumlah
//   FROM a_applicant_permohonan WHERE tarikh_permohonan IS NOT NULL $where GROUP BY YEAR(tarikh_permohonan)";
//
//   $sqls.=" ORDER BY ". $columns[$data['order'][0]['column']]." ".$data['order'][0]['dir']." LIMIT ".$data['start']." ,".$data['length']."   ";
//   $result = $conn->query($sqls);
//   $numrows = $result->num_rows;
//   $totalFiltered = $numrows;
//
//   $x = 1;
//   $datadb = array();
//   $jumlah["melayu_lulus_l"] = 0;
//   $jumlah["melayu_lulus_p"] = 0;
//   $jumlah["cina_lulus_l"] = 0;
//   $jumlah["cina_lulus_p"] = 0;
//   $jumlah["india_lulus_l"] = 0;
//   $jumlah["india_lulus_p"] = 0;
//   $jumlah["lain_lulus_l"] = 0;
//   $jumlah["lain_lulus_p"] = 0;
//   $jumlah["melayu_gagal_l"] = 0;
//   $jumlah["melayu_gagal_p"] = 0;
//   $jumlah["cina_gagal_l"] = 0;
//   $jumlah["cina_gagal_p"] = 0;
//   $jumlah["india_gagal_l"] = 0;
//   $jumlah["india_gagal_p"] = 0;
//   $jumlah["lain_gagal_l"] = 0;
//   $jumlah["lain_gagal_p"] = 0;
//   $jumlah["jumlah"] = 0;
//
//   while ($row = $result->fetch_assoc()) {
//     $nestedData=array();
//     $nestedData[] = $row["yearapp"];
//     $nestedData[] = $row["melayu_lulus_l"];
//     $nestedData[] = $row["melayu_lulus_p"];
//     $nestedData[] = $row["cina_lulus_l"];
//     $nestedData[] = $row["cina_lulus_p"];
//     $nestedData[] = $row["india_lulus_l"];
//     $nestedData[] = $row["india_lulus_p"];
//     $nestedData[] = $row["lain_lulus_l"];
//     $nestedData[] = $row["lain_lulus_p"];
//     $nestedData[] = $row["melayu_gagal_l"];
//     $nestedData[] = $row["melayu_gagal_p"];
//     $nestedData[] = $row["cina_gagal_l"];
//     $nestedData[] = $row["cina_gagal_p"];
//     $nestedData[] = $row["india_gagal_l"];
//     $nestedData[] = $row["india_gagal_p"];
//     $nestedData[] = $row["lain_gagal_l"];
//     $nestedData[] = $row["lain_gagal_p"];
//     $nestedData[] = $row["jumlah"];
//
//     $jumlah["melayu_lulus_l"] += $row["melayu_lulus_l"];
//     $jumlah["melayu_lulus_p"] += $row["melayu_lulus_p"];
//     $jumlah["cina_lulus_l"] += $row["cina_lulus_l"];
//     $jumlah["cina_lulus_p"] += $row["cina_lulus_p"];
//     $jumlah["india_lulus_l"] += $row["india_lulus_l"];
//     $jumlah["india_lulus_p"] += $row["india_lulus_p"];
//     $jumlah["lain_lulus_l"] += $row["lain_lulus_l"];
//     $jumlah["lain_lulus_p"] += $row["lain_lulus_p"];
//     $jumlah["melayu_gagal_l"] += $row["melayu_gagal_l"];
//     $jumlah["melayu_gagal_p"] += $row["melayu_gagal_p"];
//     $jumlah["cina_gagal_l"] += $row["cina_gagal_l"];
//     $jumlah["cina_gagal_p"] += $row["cina_gagal_p"];
//     $jumlah["india_gagal_l"] += $row["india_gagal_l"];
//     $jumlah["india_gagal_p"] += $row["india_gagal_p"];
//     $jumlah["lain_gagal_l"] += $row["lain_gagal_l"];
//     $jumlah["lain_gagal_p"] += $row["lain_gagal_p"];
//     $jumlah["jumlah"] += $row["jumlah"];
//
//     $datadb[] = $nestedData;
//     $x++;
//   }
//
//   error_log(print_r($data,true),0);
//
//   $json_data = array(
//     "draw"            => intval( $data['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw.
//     "recordsTotal"    => intval( $totalFiltered),  // total number of records
//     "recordsFiltered" => intval( $totalData ), // total number of records after searching, if there is no searching then totalFiltered = totalData
//     "data"            => $datadb,
//     "footer"          => $jumlah,
//   );
//
//   return $json_data;
// }
//
// if($_POST["func"] == "sPeringkatPengajianReport"){
//   echo json_encode(sPeringkatPengajianReport($_POST));
// }
//
// function sPeringkatPengajianReport($data){
//   global $conn;
//
//   $columns = array(
//     // datatable column index  => database column name
//     0 => 'yearapp',
//     1 => 'melayu_lulus_d',
//     2 => 'melayu_lulus_i',
//     3 => 'melayu_lulus_s',
//     4 => 'cina_lulus_d',
//     5 => 'cina_lulus_i',
//     6 => 'cina_lulus_s',
//     7 => 'india_lulus_d',
//     8 => 'india_lulus_i',
//     9 => 'india_lulus_s',
//     10 => 'lain_lulus_d',
//     11 => 'lain_lulus_i',
//     12 => 'lain_lulus_s',
//     13 => 'jumlah',
//   );

//   $sqldate = "";
//   $diploma = "AND pt3_peringkat_pengajian = '1' ";
//   $ijazah = "AND pt3_peringkat_pengajian = '2' ";
//   $sijil = "AND pt3_peringkat_pengajian = '3' ";
//   $statusp = $data["statusp"];
//
//   $where = "";
//   if(!empty($data['search']['value'])) {
//     $search = $data['search']['value'];
//     $where.=" AND (YEAR(tarikh_permohonan)  LIKE '%".$search."%' )";
//   }
//
//   $sqlcount = "SELECT YEAR(tarikh_permohonan) as yearapp
//   FROM a_applicant_permohonan WHERE tarikh_permohonan IS NOT NULL $where GROUP BY YEAR(tarikh_permohonan)";
//
//   $result = $conn->query($sqlcount);
//   $numrows = $result->num_rows;
//   $totalData = $numrows;
//
//   $sqls = "SELECT YEAR(tarikh_permohonan) as yearapp,
//   SUM(YEAR(tarikh_permohonan) = YEAR(tarikh_permohonan) AND pelulus_stat = '$statusp' AND pt2_keturunan_pemohon = 1 $diploma) as melayu_lulus_d,
//   SUM(YEAR(tarikh_permohonan) = YEAR(tarikh_permohonan) AND pelulus_stat = '$statusp' AND pt2_keturunan_pemohon = 1 $ijazah) as melayu_lulus_i,
//   SUM(YEAR(tarikh_permohonan) = YEAR(tarikh_permohonan) AND pelulus_stat = '$statusp' AND pt2_keturunan_pemohon = 1 $sijil) as melayu_lulus_s,
//   SUM(YEAR(tarikh_permohonan) = YEAR(tarikh_permohonan) AND pelulus_stat = '$statusp' AND pt2_keturunan_pemohon = 2 $diploma) as cina_lulus_d,
//   SUM(YEAR(tarikh_permohonan) = YEAR(tarikh_permohonan) AND pelulus_stat = '$statusp' AND pt2_keturunan_pemohon = 2 $ijazah) as cina_lulus_i,
//   SUM(YEAR(tarikh_permohonan) = YEAR(tarikh_permohonan) AND pelulus_stat = '$statusp' AND pt2_keturunan_pemohon = 2 $sijil) as cina_lulus_s,
//   SUM(YEAR(tarikh_permohonan) = YEAR(tarikh_permohonan) AND pelulus_stat = '$statusp' AND pt2_keturunan_pemohon = 3 $diploma) as india_lulus_d,
//   SUM(YEAR(tarikh_permohonan) = YEAR(tarikh_permohonan) AND pelulus_stat = '$statusp' AND pt2_keturunan_pemohon = 3 $ijazah) as india_lulus_i,
//   SUM(YEAR(tarikh_permohonan) = YEAR(tarikh_permohonan) AND pelulus_stat = '$statusp' AND pt2_keturunan_pemohon = 3 $sijil) as india_lulus_s,
//   SUM(YEAR(tarikh_permohonan) = YEAR(tarikh_permohonan) AND pelulus_stat = '$statusp' AND pt2_keturunan_pemohon = 99 $diploma) as lain_lulus_d,
//   SUM(YEAR(tarikh_permohonan) = YEAR(tarikh_permohonan) AND pelulus_stat = '$statusp' AND pt2_keturunan_pemohon = 99 $ijazah) as lain_lulus_i,
//   SUM(YEAR(tarikh_permohonan) = YEAR(tarikh_permohonan) AND pelulus_stat = '$statusp' AND pt2_keturunan_pemohon = 99 $sijil) as lain_lulus_s,
//   SUM(YEAR(tarikh_permohonan) = YEAR(tarikh_permohonan) AND pelulus_stat = '$statusp' AND pt2_keturunan_pemohon IN (1,2,3,99) AND pt3_peringkat_pengajian IN (1,2,3)) as jumlah
//   FROM a_applicant_permohonan WHERE tarikh_permohonan IS NOT NULL $where GROUP BY YEAR(tarikh_permohonan)";
//
//   $sqls.=" ORDER BY ". $columns[$data['order'][0]['column']]." ".$data['order'][0]['dir']." LIMIT ".$data['start']." ,".$data['length']."   ";
//   $result = $conn->query($sqls);
//   $numrows = $result->num_rows;
//   $totalFiltered = $numrows;
//
//   $x = 1;
//   $datadb = array();
//   $jumlah["melayu_lulus_d"] = 0;
//   $jumlah["melayu_lulus_i"] = 0;
//   $jumlah["melayu_lulus_s"] = 0;
//   $jumlah["cina_lulus_d"] = 0;
//   $jumlah["cina_lulus_i"] = 0;
//   $jumlah["cina_lulus_s"] = 0;
//   $jumlah["india_lulus_d"] = 0;
//   $jumlah["india_lulus_i"] = 0;
//   $jumlah["india_lulus_s"] = 0;
//   $jumlah["lain_lulus_d"] = 0;
//   $jumlah["lain_lulus_i"] = 0;
//   $jumlah["lain_lulus_s"] = 0;
//   $jumlah["jumlah"] = 0;
//
//   while ($row = $result->fetch_assoc()) {
//     $nestedData=array();
//     $nestedData[] = $row["yearapp"];
//     $nestedData[] = $row["melayu_lulus_s"];
//     $nestedData[] = $row["melayu_lulus_d"];
//     $nestedData[] = $row["melayu_lulus_i"];
//     $nestedData[] = $row["cina_lulus_s"];
//     $nestedData[] = $row["cina_lulus_d"];
//     $nestedData[] = $row["cina_lulus_i"];
//     $nestedData[] = $row["india_lulus_s"];
//     $nestedData[] = $row["india_lulus_d"];
//     $nestedData[] = $row["india_lulus_i"];
//     $nestedData[] = $row["lain_lulus_s"];
//     $nestedData[] = $row["lain_lulus_d"];
//     $nestedData[] = $row["lain_lulus_i"];
//     $nestedData[] = $row["jumlah"];
//
//     $jumlah["melayu_lulus_d"] += $row["melayu_lulus_d"];
//     $jumlah["melayu_lulus_i"] += $row["melayu_lulus_i"];
//     $jumlah["melayu_lulus_s"] += $row["melayu_lulus_s"];
//     $jumlah["cina_lulus_d"] += $row["cina_lulus_d"];
//     $jumlah["cina_lulus_i"] += $row["cina_lulus_i"];
//     $jumlah["cina_lulus_s"] += $row["cina_lulus_s"];
//     $jumlah["india_lulus_d"] += $row["india_lulus_d"];
//     $jumlah["india_lulus_i"] += $row["india_lulus_i"];
//     $jumlah["india_lulus_s"] += $row["india_lulus_s"];
//     $jumlah["lain_lulus_d"] += $row["lain_lulus_d"];
//     $jumlah["lain_lulus_i"] += $row["lain_lulus_i"];
//     $jumlah["lain_lulus_s"] += $row["lain_lulus_s"];
//     $jumlah["jumlah"] += $row["jumlah"];
//
//     $datadb[] = $nestedData;
//     $x++;
//   }
//
//   error_log(print_r($data,true),0);
//
//   $json_data = array(
//     "draw"            => intval( $data['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw.
//     "recordsTotal"    => intval( $totalFiltered),  // total number of records
//     "recordsFiltered" => intval( $totalData ), // total number of records after searching, if there is no searching then totalFiltered = totalData
//     "data"            => $datadb,
//     "footer"          => $jumlah,
//   );
//
//   return $json_data;
// }
//
// if($_POST["func"] == "l-pemohon"){
//   echo json_encode(listpemohon($_POST));
// }
//
// function listpemohon($data){
//   global $conn;
//
//   $columns = array(
//     // datatable column index  => database column name
//     0 => 'aap_id',
//     1 => 'pt2_nama_pemohon',
//     2 => 'rpar_name',
//     3 => 'rdun_name',
//     4 => 'kaunter_application_stat',
//     5 => 'kaunter_application_stat'
//   );
//
//   $Stat = $data["Stat"];
//
//   $where = "";
//   if($data["pejabatdaerah"] != '') $where .= " AND pt1_pejabat_daerah = '".$data["pejabatdaerah"]."' ";
//   if($data["pbt"] != '') $where .= " AND pt1_pbt = '".$data["pbt"]."' ";
//   if($data["pkd"] != '') $where .= " AND pt1_pusat_khidmat_dun = '".$data["pkd"]."' ";
//   if($data["parlimen"] != '') $where .= " AND pt1_parlimen = '".$data["parlimen"]."' ";
//   if($data["dun"] != '') $where .= " AND pt1_dun = '".$data["dun"]."' ";
//   if($data["bulan"] != '') $where .= " AND MONTH(tarikh_permohonan) = '".$data["bulan"]."' ";
//   if($data["tahun"] != '') $where .= " AND YEAR(tarikh_permohonan) = '".$data["tahun"]."' ";
//
//   if(!empty($data['search']['value'])) {
//     $search = $data['search']['value'];
//     $where.=" AND (pt2_nama_pemohon  LIKE '%".$search."%' ";
//     $where.=" OR pt2_no_kp_pemohon  LIKE '%".$search."%') ";
//   }
//
//   $sql = "SELECT aap_id, pt2_nama_pemohon, pt2_no_kp_pemohon, rpar_name, rdun_name,
//   DATE_FORMAT(pelulus_date, '%d-%m-%Y') as pelulus_date, uu_fullname, kaunter_application_stat,
//   rs_color, rs_name, rs_icon, pt2_no_kp_pemohon as enc_id
//   FROM a_applicant_permohonan
//   LEFT JOIN u_user ON penyedia_uu_id = uu_id
//   LEFT JOIN ref_status ON pelulus_stat = rs_id
//   LEFT JOIN ref_parlimen ON rpar_code = pt1_parlimen
//   LEFT JOIN ref_dun ON rdun_code = pt1_dun
//   WHERE pelulus_stat = '$Stat' $where ";
//
//   $result = $conn->query($sql);
//   $numrows = $result->num_rows;
//   $totalData = $numrows;
//   $totalFiltered = $totalData;
//
//   $sql.=" ORDER BY ". $columns[$data['order'][0]['column']]." ".$data['order'][0]['dir']." LIMIT ".$data['start']." ,".$data['length']."   ";
//   $result = $conn->query($sql);
//   $numrows = $result->num_rows;
//   $totalFiltered = $numrows;
//
//   $datadb = array();
//   while ($row = $result->fetch_assoc()) {
//     $nestedData=array();
//     $nestedData[] = $row["aap_id"];
//     $nestedData[] = $row["pt2_nama_pemohon"]."<br>".$row["pt2_no_kp_pemohon"];
//     $nestedData[] = $row["rpar_name"];
//     $nestedData[] = $row["rdun_name"];
//     $nestedData[] = badge($row["rs_color"],$row["rs_icon"],$row["rs_name"]);
//     $nestedData[] = "<button class='btn btn-primary btn-block' id='view' icno='".$row["pt2_no_kp_pemohon"]."'>View</button>";
//     $datadb[] = $nestedData;
//   }
//
//   error_log(print_r($data,true),0);
//
//   $json_data = array(
//     "draw"            => intval( $data['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw.
//     "recordsTotal"    => intval( $totalFiltered),  // total number of records
//     "recordsFiltered" => intval( $totalData ), // total number of records after searching, if there is no searching then totalFiltered = totalData
//     "data"            => $datadb   // total data array
//   );
//
//   return $json_data;
// }
//
// if($_POST["func"] == "general-resetList"){
//   echo json_encode(resetList($_POST,'1003'));
// }
//
// function resetList($data,$statusKaunter){
//   global $conn;
//
//   $columns = array(
//     // datatable column index  => database column name
//     0 => 'aap_id',
//     1 => 'pt2_nama_pemohon',
//     2 => 'tarikh_permohonan',
//     3 => 'uu_fullname',
//     4 => 'kaunter_application_stat',
//     5 => 'kaunter_application_stat'
//   );
//   // $kaunterStat = $data["kaunterStat"];
//
//   $sql = "SELECT arr_id, aap_id, pt2_nama_pemohon, pt2_no_kp_pemohon, arr_note,
//   DATE_FORMAT(arr_date, '%d-%m-%Y') as tarikh_permohonan, uu_fullname, kaunter_application_stat,
//   rs_color, rs_name, rs_icon, pt2_no_kp_pemohon as enc_id
//   FROM a_reset_request
//   LEFT JOIN a_applicant ON aa_id = arr_aa_id
//   LEFT JOIN a_applicant_permohonan ON aa_username = pt2_no_kp_pemohon
//   LEFT JOIN u_user ON arr_uu_id = uu_id
//   LEFT JOIN ref_status ON kaunter_application_stat = rs_id
//   WHERE arr_status = '0000'";
//
//   $result = $conn->query($sql);
//   $numrows = $result->num_rows;
//   $totalData = $numrows;
//   $totalFiltered = $totalData;
//
//   if(!empty($data['search']['value'])) {
//     $search = $data['search']['value'];
//     $sql.=" AND (pt2_nama_pemohon  LIKE '%".$search."%' ";
//     $sql.=" OR pt2_no_kp_pemohon  LIKE '%".$search."%' ";
//     $sql.=" OR uu_fullname  LIKE '%".$search."%') ";
//
//     $sql.=" ORDER BY ". $columns[$data['order'][0]['column']]." ".$data['order'][0]['dir']." LIMIT ".$data['start']." ,".$data['length']."   ";
//
//     $result = $conn->query($sql);
//     $numrows = $result->num_rows;
//     $totalFiltered = $numrows;
//   } else {
//     $sql.=" ORDER BY ". $columns[$data['order'][0]['column']]." ".$data['order'][0]['dir']." LIMIT ".$data['start']." ,".$data['length']."   ";
//     $result = $conn->query($sql);
//     $numrows = $result->num_rows;
//     $totalFiltered = $numrows;
//   }
//
//   $datadb = array();
//   while ($row = $result->fetch_assoc()) {
//     $nestedData=array();
//     $nestedData[] = $row["aap_id"];
//     $nestedData[] = $row["pt2_nama_pemohon"]."<br>".$row["pt2_no_kp_pemohon"];
//     $nestedData[] = nl2br($row["arr_note"]);
//     $nestedData[] = $row["tarikh_permohonan"];
//     // $nestedData[] = badge($row["rs_color"],$row["rs_icon"],$row["rs_name"]);
//     $nestedData[] = "<button class='btn btn-primary ' id='view' icno='".$row["pt2_no_kp_pemohon"]."'>View</button>
//     <button class='btn btn-danger ' id='reset' arr='".$row["arr_id"]."'>Reset</button>";
//     $datadb[] = $nestedData;
//   }
//
//   error_log(print_r($data,true),0);
//
//   $json_data = array(
//     "draw"            => intval( $data['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw.
//     "recordsTotal"    => intval( $totalFiltered),  // total number of records
//     "recordsFiltered" => intval( $totalData ), // total number of records after searching, if there is no searching then totalFiltered = totalData
//     "data"            => $datadb   // total data array
//   );
//
//   return $json_data;
// }
//
// if($_POST["func"] == "approveReset"){
//   echo json_encode(approveReset($_POST));
// }
//
// function approveReset($data){
//   global $conn;
//
//   $id = $_SESSION["ID"];
//   $arr = $data["arr"];
//
//   $suser = "SELECT aa_username FROM a_reset_request LEFT JOIN a_applicant ON arr_aa_id =  aa_id WHERE arr_id = '$arr'";
//
//   $u = "UPDATE a_applicant_permohonan SET
//   status_permohonan = '0000',
//   kaunter_document_stat = '1010',
//   kaunter_application_stat = '1000',
//   penyedia_stat = '2000',
//   penyedia_return_stat = '2000',
//   penyemak_stat = '3000',
//   pelulus_stat = '4000',
//   pembayaran_hpipt_stat = '5000',
//   pembayaran_sd_stat = '6000'
//   WHERE pt2_no_kp_pemohon = ($suser) AND pelulus_stat = '4002'";
//
//   // echo $u;exit;
//
//   if($conn->query($u)){
//     $i = "UPDATE a_reset_request SET arr_status = '0001', arr_uu_id = '$id' WHERE arr_id = '$arr'";
//
//     if($conn->query($i)){
//       $status["STATUS"] = true;
//       $status["MSG"] = 'Permohonan Berjaya Direset';
//     } else {
//       $status["STATUS"] = false;
//       $status["MSG"] = 'Permohonan Gagal Direset';
//     }
//   } else {
//     $status["STATUS"] = false;
//     $status["MSG"] = 'Permohonan Reset Gagal Dikemaskini';
//   }
//
//   return $status;
// }


?>
