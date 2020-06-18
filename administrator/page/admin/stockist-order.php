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
            <h3 class="font-montserrat "> STOCK ORDER</h3>
            <p>Sila pilih Stokis yang berkenaan dan masukkan kuantiti, tarikh pesanan dan tarikh pungutan pesanan.</p>
            </div>
          </div>
        </div>
      </div>
      <div class="row m-b-20 padding-20">
        <div class="col-md-3 no-padding">
          <div class="form-group form-group-default">
            <label>Carian Stokist</label>
            <input id="filter" name="filter" type="text" class="form-control" required="">
          </div>
        </div>
        <div class="col-md-3 no-padding">
          <div class="form-group form-group-default form-group-default-select2">
            <label>Negeri</label>
            <select id="filterNegeri" data-init-plugin='select2' class="full-width" name="filterNegeri">
              <?php getNegeri(); ?>
            </select>
          </div>
        </div>
        <div class="col-md-3 no-padding">
          <div class="form-group form-group-default form-group-default-select2">
            <label>Status Stokis</label>
            <select id="filterStatus" data-init-plugin='select2' class="full-width" name="filterStatus">
              <?php getStatus(1) ?>
            </select>
          </div>
        </div>
        <div class="col-md-3 no-padding">
          <div class="form-group form-group-default form-group-default-select2">
            <label>Status Pesanan</label>
            <select id="filterStatusOrder" data-init-plugin='select2' class="full-width" name="filterStatusOrder">
              <?php getStatus(2) ?>
            </select>
          </div>
        </div>

        <div class="col-md-12 no-padding">
          <button id="filterbtn" type="button" class="btn btn-primary" name="button">Filter</button>
          <button id="resetbtn" type="button" class="btn btn-primary" name="button">Reset</button>
          <button id="addNewOrder" type="button" class="btn btn-success pull-right" name="button"> <i class="fa fa-plus m-r-5"></i> Add New Order</button>
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
                  <th class="">Nama Stokist</th>
                  <th style="width:200px;" class="text-center">Contact Details</th>
                  <th style="width:100px;" class="text-center">Quantity</th>
                  <th style="width:200px;" class="text-center">Tarikh</th>
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
  <div class="bg-white padding-20 container-fixed-lg p-b-30">
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

<div class="" id="detailDivStokistOrder" style="display:none">
  <div class="bg-white padding-20 container-fixed-lg p-b-30">
    <div class="container full-height">
      <div class="row">
        <div class="col-md-12">
          <div class="row">
            <?php include("form-template-order-stock.php") ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php mediaViewer(); ?>

<script type="text/javascript">


$("#PrintStockOrder").click(function(e){
  window.open("stokist-order?id="+EOSID);
});

$("#PrintInvoice").click(function(e){
  window.open("stokist-invoice?id="+EOSID);
});

$("#PrintReceipt").click(function(e){
  window.open("stokist-receipt?id="+EOSID);
});

$("#PrintDeliveryOrder").click(function(e){
  window.open("stokist-deliver?id="+EOSID);
});


$("#addNewOrder").click(function(e){
  $('#form-stokist-order').formValidation("resetForm",true);
  $("#detailDivStokistOrder").show();
  $("#mainDiv").hide();
  $("#detailDiv").hide();
  $('#form-stokist-order').find("select").val("").change();
  $('#form-stokist-order').formValidation("resetForm",true);

  resetDefValue($("[name='rpprice[]']"));
  resetDefValue($("[name='rpid[]']"));
  resetDefValue($("[name='quantity[]']"));

  $("#cetakDokumenDiv").hide();

  ESOFUNC = "insertOrder";
});

$("[name='rpprice[]'],[name='rpid[]'],[name='quantity[]']").change(function(e){
  CHANGESTABLEPRODUCT = true;
});

function resetDefValue(element){
  $(element).each(function(e){
    $(this).val($(this).attr("defvalue"));
  })
}

$("[id='back']").click(function(e){
  $("#mainDiv").show();
  $("#detailDiv").hide();
  $("#detailDivStokistOrder").hide();
  tablePengguna.ajax.reload(null, false);
});

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
      d.func = "getStokistOrder";
      d.search = $("#filter").val();
      d.negeri = $("#filterNegeri").val();
      d.status = $("#filterStatus").val();
      d.statusOrder = $("#filterStatusOrder").val();
      // d.kaunterStat = $("#kaunterStatus").val();
    }
  },
  columnDefs: [
    { targets: [0,3,4,5], class: "text-center hidden-xs" },
    { targets: [2], class: "hidden-xs" },
    { targets: [1], class: "visible-xs" }
  ], // your case first column "className": "text-center", }],
  fnDrawCallback: function () {
    // $("#counter").html(this.fnSettings().fnRecordsTotal())
    tablePengguna.$("[id='edituser']").click(edituserFunc);
    tablePengguna.$("[id='editOrder']").click(editOrder);
  }
});

$("#filter").on("keydown", function(e) {
    if (e.keyCode === 13) {
      e.preventDefault();
      tablePengguna.ajax.reload();
    }
});

$("#filterNegeri, #filterStatusOrder, #filterStatus").change(function(e){
  tablePengguna.ajax.reload();
});

$("#filterbtn").click(function(e){
  tablePengguna.ajax.reload();
});

var EOSID;
var CHANGESTABLEPRODUCT;

function editOrder(){
  loading();
  $("#cetakDokumenDiv").show();
  CHANGESTABLEPRODUCT = false;
  ESOFUNC = "updateOrderStock";
  EOSID = $(this).attr("key");
  console.log(EOSID);
  var fd = new FormData();
  fd.append("func","getStokistOrderDetail");
  fd.append("eosid",EOSID);
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
        setFormOrder(data);
      },
      error: function(data) {
      }
  });
}

var ESID = null;

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
  INSFUNC = 'updateStockist';
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
  $('#form-stokist').formValidation("resetForm",false);
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

  $('#form-stokist').formValidation("resetForm",false);

  $("#mainDiv").hide();
  $("#detailDiv").show();
  $("#detailDivStokistOrder").hide();

  detectDisabled();
}

function setFormOrder(data){
  resetDefValue($("[name='rpprice[]']"));
  resetDefValue($("[name='rpid[]']"));
  resetDefValue($("[name='quantity[]']"));
  // var enc_id = data["EOS"][0]["enc_id"];
  var eos_es_id = data["EOS"][0]["eos_es_id"];
  var eos_dateorder = data["EOS"][0]["eos_dateorder"];
  var eos_datepickup = data["EOS"][0]["eos_datepickup"];
  var eos_rjp_id = data["EOS"][0]["eos_rjp_id"];
  var eos_rtp_id = data["EOS"][0]["eos_rtp_id"];
  var eos_otherPlace = data["EOS"][0]["eos_otherPlace"];
  var eos_deliveryCharges = data["EOS"][0]["eos_deliveryCharges"];
  var eos_status = data["EOS"][0]["eos_status"];

  $("#stokist").val(eos_es_id).change();
  $("#orderDate").val(eos_dateorder).change();
  $("#pickupDate").val(eos_datepickup).change();
  $("#JenisPenghantaran").val(eos_rjp_id).change();
  $("#tempatPenghantaran").val(eos_rtp_id).change();
  $("#tempatOthers").val(eos_otherPlace).change();
  $("#deliveryCharges").val(eos_deliveryCharges).change();
  $("#setStatus").val(eos_status).change();

  $("#mainDiv").hide();
  $("#detailDiv").hide();
  $("#detailDivStokistOrder").show();

  $.each( data["EOSP"], function( key, value ) {
    var id = data["EOSP"][key]["eosp_rp_id"];
    var pr = data["EOSP"][key]["eosp_price"];
    var qt = data["EOSP"][key]["eosp_quantity"];

    $("[name='rpprice[]'][key='"+id+"']").val(pr);
    $("[name='quantity[]'][key='"+id+"']").val(qt);
  });

  $('#form-stokist-order').formValidation("resetForm",false);
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

$("#addnewstockist").click(function(e){
  $("#mainDiv").hide();
  $("#detailDiv").show();
  $('#form-stokist').formValidation("resetForm",true);
  $('#form-stokist').find("select").change();
  $('#form-stokist').formValidation("resetForm",true);
  $("#facebook").val("");
  $("#instagram").val("");
  $("#linkedin").val("");
  INSFUNC = 'insertStokist';
});



$('#form-stokist').formValidation({
}).on('success.form.fv', function(e) {
    // Prevent form submission
    e.preventDefault();
    runfunction = save;
    saConfirm4("Muktamat","Anda pasti untuk stokis data pemohon? Sila pastikan butiran stokis adalah betul. Terima Kasih.","warning","Ya, Pasti",runfunction,"Pasti");
});

$('#form-stokist-order').formValidation({
}).on('success.form.fv', function(e) {
    // Prevent form submission
    e.preventDefault();
    runfunction = saveOrder;
    saConfirm4("Muktamat","Anda pasti untuk simpan data pesanan? Sila pastikan butiran pesanan adalah betul. Terima Kasih.","warning","Ya, Pasti",runfunction,"Pasti");
});

var INSFUNC = 'insertStokist';

function save(){
  var myform = document.getElementById('form-stokist');
  var fd = new FormData(myform);
  fd.append("func",INSFUNC);
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
          saAlert3("Berjaya",data["MSG"],"success");
        } else {
          saAlert3("Gagal",data["MSG"],"warning");
        }
      },
      error: function(data) {
        // saAlert3("Error","Session Log Out Error","warning");
      }
  });
}

var ESOFUNC = "insertOrder";

function saveOrder(){
  var myform = document.getElementById('form-stokist-order');
  var fd = new FormData(myform);
  fd.append("func",ESOFUNC);
  fd.append("CHANGESTABLEPRODUCT",CHANGESTABLEPRODUCT);
  fd.append("eosid",EOSID);
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
          saAlert3("Berjaya",data["MSG"],"success");
        } else {
          saAlert3("Gagal",data["MSG"],"warning");
        }
      },
      error: function(data) {
        // saAlert3("Error","Session Log Out Error","warning");
      }
  });
}



$("#orderDate").datepicker({
  format: 'dd-mm-yyyy'
});

$("#pickupDate").datepicker({
  format: 'dd-mm-yyyy'
});

$("#JenisPenghantaran").change(function(e){
  $('#form-stokist-order').formValidation("resetForm",false);
  var val = $(this).val();
  if (val == "1") {
    $("#tempatPenghantaran").prop("disabled",false);
    $("#deliveryCharges").val("").change();
    // $("#deliveryCharges").prop("disabled",true);
  } else if (val == "2") {
    $("#tempatPenghantaran").prop("disabled",true);
    // $("#deliveryCharges").prop("disabled",false);
  } else {
    $("#tempatPenghantaran").prop("disabled",true);
    // $("#deliveryCharges").prop("disabled",true);
    $("#tempatPenghantaran").val("").change();
  }
});

$("#tempatPenghantaran").change(function(e){
  $('#form-stokist-order').formValidation("resetForm",false);
  var val = $(this).val();
  if (val == "99") {
    $("#tempatOthers").prop("disabled",false);
  } else {
    $("#tempatOthers").prop("disabled",true);
    $("#tempatOthers").val("").change();
  }
});

$("[id='quantity[]']").change(function(e){
  calculateOrder();
});

$("#deliveryCharges").change(function(e){
  calculateOrder();
});

function calculateOrder(){
  var myform = document.getElementById('form-stokist-order');
  var fd = new FormData(myform);
  fd.append("func","calculateOrderStokist");
  $.ajax({
      type: 'POST',
      url: "db",
      data: fd,
      dataType: "json",
      cache: false,
      contentType: false,
      processData: false,
      success: function(data) {
        var totals = data["totals"];
        $("#rpPostage").html(totals["postagetotal"]);
        // $("#deliveryCharges").val(totals["postagetotal"]);
        $("#rpTotal").html(totals["gtotal"]);
        $("#rpGrandTotal").html(totals["gtotalpayment"]);
      },
      error: function(data) {
        // saAlert3("Error","Session Log Out Error","warning");
      }
  });
}

</script>
