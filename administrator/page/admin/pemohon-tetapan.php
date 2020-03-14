<?php include("../../formfunction.php"); ?>

<style media="screen">
.form-control[disabled], .form-control[readonly], fieldset[disabled] .form-control{
  color: #444;
}

.select2-container--default.select2-container--disabled .select2-selection--single {
  background: none;
}

  .form-control[disabled], .form-control[readonly], fieldset[disabled] .form-control{
    color: #626262;
    background-color: white;
  }

  .form-group-default.disabled {
    background-color: white;
    color:#626262;

  }

  .select2-container--default.select2-container--disabled .select2-selection--single {
    background-color: white;
  }

  input[disabled]{
    color: #626262;
  }

  .myfileupload-buttonbar input
  {
      position: absolute;
      top: 0;
      right: 0;
      margin: 0;
      border: solid transparent;
      border-width: 0 0 100px 200px;
      opacity: 0.0;
      filter: alpha(opacity=0);
      -o-transform: translate(250px, -50px) scale(1);
      -moz-transform: translate(-300px, 0) scale(4);
      direction: ltr;
      cursor: pointer;
      display:none;
  }
  .myui-button
  {
      position: relative;
      cursor: pointer;
      overflow: visible;
      overflow: hidden;
      display:none;
  }

  * {box-sizing: border-box;}

  .img-zoom-container {
    position: relative;
  }

  .img-zoom-lens {
    position: absolute;
    border: 1px solid #d4d4d4;
    /*set the size of the lens:*/
    width: 300px;
    height: 300px;
  }

  .img-zoom-result {
    border: 1px solid #d4d4d4;
    /*set the size of the result div:*/
    width: 300px;
    height: 300px;
  }
</style>


<div class=" no-padding container-fixed-lg bg-white p-b-30" id="mainDiv">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="card card-transparent">
          <div class="card-header ">
            <div class="card-title">
            </div>
          </div>
          <div class="card-body no-padding ">
            <h3 class="font-montserrat "> SENARAI EJEN eCAQUE</h3>
            <p>Senarai stokis boleh dikemaskini dengan menekan butang kemaskini. Sila pastikan butiran adalah betul.</p>
            </div>
          </div>
        </div>
      </div>
      <div class="row m-b-20">
        <div class="col-md-6">
          <div class="form-group form-group-default">
            <label>Carian Stokist</label>
            <input id="filter" name="filter" type="text" class="form-control" required="">
          </div>
        </div>
        <div class="col-md-3 p-l-0 m-l-0">
          <div class="form-group form-group-default form-group-default-select2">
            <label>Negeri</label>
            <select data-init-plugin='select2' class="full-width" name="filterNegeri">
              <?php getNegeri(); ?>
            </select>
          </div>
        </div>
        <div class="col-md-3 p-l-0 m-l-0">
          <div class="form-group form-group-default form-group-default-select2">
            <label>Status</label>
            <select data-init-plugin='select2' class="full-width" name="filterStatus">
              <option value="">-- Pilih Status --</option>
              <option value="1000">Not Verified</option>
              <option value="1001">Verified</option>
              <option value="1002">Barred</option>
            </select>
          </div>
        </div>

        <div class="col-md-12">
          <button id="filterbtn" type="button" class="btn btn-primary" name="button">Filter</button>
          <button id="resetbtn" type="button" class="btn btn-primary" name="button">Reset</button>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="card card-transparent ">
            <table class="table" id="table-pengguna">
              <thead>
                <tr>
                  <th style="width:10px;"  class="text-center">#</th>
                  <th class="">Nama Stokist</th>
                  <th style="width:200px;" class="text-center">Contact Details</th>
                  <th style="width:200px;" class="text-center">Registered Date</th>
                  <th style="width:100px;" class="text-center">Negeri</th>
                  <th style="width:90px;" class="text-center">Action</th>
                </tr>
              </thead>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="" id="detailDiv" style="display:none">
  <div class="bg-white no-padding container-fixed-lg p-b-30 hidden-xs">
    <div class="container full-height">
      <div class="row">
        <div class="col-md-12">
          <div class="row">
            <?php include("form-template-pemohon.php") ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">

function detectDisabled(){
  $("input").parents(".form-group").removeClass("required");
  $("select").parents(".form-group").removeClass("required");

  $("input[required]").parents(".form-group").addClass("required");
  $("select[required]").parents(".form-group").addClass("required");
}

$("[data-init-plugin='select2']").select2();

var tablePengguna = $('#table-pengguna').on('preXhr.dt', function ( e, settings, data ) {
    loading();
  }).on('xhr.dt', function ( e, settings, json, xhr ) {
    finishload();
  }).DataTable( {
  "sDom":"l<t>r<'row'<p i>>",
  "responsive":true,
  "processing": true,
  "serverSide": true,
  "ajax": {
    "url": "db",
    "type": "POST",
    "data": function ( d ) {
      d.func = "getStokist";
      d.search = $("#filter").val();
      // d.kaunterStat = $("#kaunterStatus").val();
    }
  },
  'columnDefs': [
  { "targets": [0,2,3,4], "className": "text-center" }
  ], // your case first column "className": "text-center", }],
  "fnDrawCallback": function () {
    // $("#counter").html(this.fnSettings().fnRecordsTotal())
    tablePengguna.$("[id='edituser']").click(edituserFunc);
    tablePengguna.$("[id='resetUser']").click(resetUserFunc);
  }
});

$("#filter").on("keydown", function(e) {
    if (e.keyCode === 13) {
      e.preventDefault();
      tablePengguna.ajax.reload();
    }
});

$("#filterbtn").click(function(e){
  tablePengguna.ajax.reload();
});

var ESID = null;

function resetUserFunc(){
  var esid = $(this).attr("esid");
  ESID = esid;
  runfunction = hardReset;
  saConfirm4("Reset Permohonan?","Anda pasti untuk reset permohonan?","warning","Ya, Pasti",runfunction,"Pasti");
}

function hardReset(){
  var fd = new FormData();
  fd.append("func","hardresetpemohon");
  fd.append("esid",ESID);
  $.ajax({
      type: 'POST',
      url: "db",
      data: fd,
      dataType: "json",
      cache: false,
      contentType: false,
      processData: false,
      success: function(data) {
        if (data["STATUS"]) {
          tablePengguna.ajax.reload(null, false);
          saAlert3("Berjaya",data["MSG"],"success");
        } else {
          saAlert3("Tidak Berjaya",data["MSG"],"warning");
        }
      },
      error: function(data) {
        // saAlert3("Error","Session Log Out Error","warning");
      }
  });
}

function enableFunc(){
  var esid = $(this).attr("key");
  ESID = esid;
  T_FUNC = "enable-user";
  runfunction = toogleStatus;
  saConfirm4("Aktifkan pengguna?","Anda pasti untuk aktifkan pengguna?","warning","Ya, Pasti",runfunction,"Pasti");
}

function disabledFunc(){
  var esid = $(this).attr("key");
  ESID = esid;
  T_FUNC = "disable-user";
  runfunction = toogleStatus;
  saConfirm4("Nyah-Aktifkan pengguna?","Anda pasti untuk Nyah-Aktifkankan pengguna?","warning","Ya, Pasti",runfunction,"Pasti");
}

function edituserFunc(){
  var esid = $(this).attr("key");
  ESID = esid;
  getStockistInfos();
}

function getStockistInfos(){
  loading();
  var fd = new FormData();
  fd.append("func","getStokistDetail");
  fd.append("esid",ESID);
  $.ajax({
      type: 'POST',
      url: "db",
      data: fd,
      dataType: "json",
      cache: false,
      contentType: false,
      processData: false,
      success: function(data) {
        finishload();
        setForm(data[0]);
        $("#t1").find("a").click();
        $("#t2").show();
      },
      error: function(data) {
      }
  });
}

$("#changePassword").click(function(e){
  $('#form-pemohon').formValidation("resetForm",false);
  $("#katalaluanDiv").toggle();
  $('#aa_password').val("");
  $('#aa_password2').val("");
})

function setForm(data){

  $("#fullname").val(data["es_name"]);
  $("#identificationNo").val(data["es_icno"]);
  $("#jantina").val(data["es_rjan_id"]).change();
  $("#nationality").val(data["es_rngra_id"]).change();
  $("#bangsa").val(data["es_rktrn_id"]).change();
  $("#alamat").val(data["es_address"]);
  $("#bandar").val(data["es_bandar"]);
  $("#negeri").val(data["es_rngri_id"]).change();
  $("#poskod").val(data["es_poskod"]);
  $("#email").val(data["es_email"]);
  $("#phone").val(data["es_phone"]);
  $("#facebook").val(data["es_facebook"]);
  $("#instagram").val(data["es_instagram"]);
  $("#linkedin").val(data["es_linkedin"]);

  $('#form-pemohon').formValidation("resetForm",false);

  $("#mainDiv").hide();
  $("#detailDiv").show();

  detectDisabled();
}

function toogleStatus(){
  var fd = new FormData();
  fd.append("func",T_FUNC);
  fd.append("esid",ESID);
  $.ajax({
      type: 'POST',
      url: "db",
      data: fd,
      dataType: "json",
      cache: false,
      contentType: false,
      processData: false,
      success: function(data) {
        if (data["STATUS"]) {
          tablePengguna.ajax.reload(null, false);
          saAlert3("Berjaya","Status Berjaya Dikemaskini","success");
        } else {
          saAlert3("Berjaya","Status Gagal Dikemaskini","warning");
        }
      },
      error: function(data) {
        // saAlert3("Error","Session Log Out Error","warning");
      }
  });
}

$("#addbtn").click(function(e){
  $("#mainDiv").hide();
  $("#detailDiv").show();
  $('#form-pemohon').formValidation("resetForm",true);
  $('#aa_username').prop("disabled",false);
  $('#aa_fullname').prop("disabled",false);
  $('#aa_password').prop("required",true);
  $('#aa_password2').prop("required",true);
  $("#pangkat").change();

  $("#t1").find("a").click();
  $("#t2").hide();

  detectDisabled();
});

$("[id='back']").click(function(e){
  $("#mainDiv").show();
  $("#detailDiv").hide();
  tablePengguna.ajax.reload(null, false);
});

$('#form-pemohon').formValidation({
  message: 'This value is not valid',
  fields: {
    aa_username : {
      message: 'Butiran Tidak Sah',
      validators: {
          stringLength: {
              min: 6,
              message: 'Must be minimum 6 characters long'
          }
      }
    },
    aa_fullname : {
      message: 'Butiran Tidak Sah',
      validators: {
          stringLength: {
              min: 6,
              message: 'Must be minimum 6 characters long'
          }
      }
    },
    aa_password: {
      message: 'Butiran Tidak Sah',
      validators: {
          notEmpty: {
            enabled: true,
            message: 'Required to change password'
          },
          stringLength: {
              min: 8,
              message: 'Must be minimum 8 characters long'
          }
      }
    },
    aa_password2: {
      message: 'Butiran Tidak Sah',
      validators: {
          notEmpty: {
            enabled: true,
            message: 'Required to change password'
          },
          identical: {
              field: 'aa_password',
              message: 'Password confirmation does not match'
          }
      }
    }
  }
}).on('success.form.fv', function(e) {
    // Prevent form submission
    e.preventDefault();
    runfunction = editPemohonConfirm;
    saConfirm4("Muktamat","Anda pasti untuk simpan data pemohon? Sila pastikan butiran pemohon adalah betul. Terima Kasih.","warning","Ya, Pasti",runfunction,"Pasti");
});

function editPemohonConfirm(){
  var myform = document.getElementById('form-pemohon');
  var fd = new FormData(myform);
  fd.append("func","editPemohon");
  fd.append("esid",ESID);
  $.ajax({
      type: 'POST',
      url: "db",
      data: fd,
      dataType: "json",
      cache: false,
      contentType: false,
      processData: false,
      success: function(data) {
        if(data["STATUS"]){
          saAlert3("Berjaya","Data Berjaya Disimpan","success");
        } else {
          saAlert3("Gagal","Data Gagal Disimpan","warning");
        }
      },
      error: function(data) {
        // saAlert3("Error","Session Log Out Error","warning");
      }
  });
}

</script>
