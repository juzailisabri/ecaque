<?php
include("../../administrator/formfunction.php");
$oid = null;
if (isset($_GET["oid"])) { $oid = $_GET["oid"]; }
?>

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

<div class=" no-padding container-fixed-lg bg-white p-b-30 " id="mainDiv">
  <div class="p-t-30 hidden-xs"> </div>
  <div class="container no-padding">
    <div class="row">
      <div class="col-md-7">
        <div class="card">
          <div class="card-header ">
            <div class="card-title">My Profile
            </div>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-12">
                <h3 class="mw-80">Sila kemaskini maklumat anda dengan maklumat yang terbaharu.</h3>
                <p class="mw-80">
                  Pastikan maklumat yang dimasukkan adalah benar supaya dapat memudahkan proses pengedaran maklumat dari pihak eCaque Enterprise
                </p>
                <br>
                <form id="form-profile" class="form-horizontal" role="form" autocomplete="off" novalidate="novalidate">

                  <h5 class="text-uppercase font-montserrat m-t-30 block-title"><i class="fa fa-lock m-r-5"></i> Katalaluan </h5>

                  <div class="form-group row no-padding p-b-10 p-t-10" id="passwordDiv">
                    <label for="fname" class="text-black bold required col-md-5 control-label" aria-required="true">Katalaluan Lama</label>
                    <div class="col-md-7">
                      <input type="password" class="form-control" id="oldpassword" name="oldpassword" aria-required="true">
                      <span class="help">Sila masukkan katalaluan lama untuk pengesahan penukaran katalaluan.</span>
                    </div>
                  </div>
                  <div class="form-group row no-padding p-b-10 p-t-10" id="passwordDiv">
                    <label for="fname" class="text-black bold required col-md-5 control-label" aria-required="true">Katalaluan Baru</label>
                    <div class="col-md-7">
                      <input type="password" class="form-control" id="password" name="password" aria-required="true">
                      <!-- <span class="help">The URL to your SAML Metadata XML file. It must be publicly accessible for Pages
                      Framework to download and process.</span> -->
                    </div>
                  </div>
                  <div class="form-group row no-padding p-b-10 p-t-10" id="passwordDiv">
                    <label for="fname" class="text-black bold required col-md-5 control-label" aria-required="true">Ulang Katalaluan Baru</label>
                    <div class="col-md-7">
                      <input type="password" class="form-control" id="password2" name="password2" aria-required="true">
                      <!-- <span class="help">The URL to your SAML Metadata XML file. It must be publicly accessible for Pages
                      Framework to download and process.</span> -->
                    </div>
                  </div>

                  <div class="row m-t-30">
                    <div class="col-md-6">
                    </div>
                    <div class="col-md-6">
                      <button aria-label="" class="btn btn-success pull-right" type="submit">Save Changes</button>
                    </div>
                  </div>

                  <h5 class="text-uppercase font-montserrat m-t-30 block-title">Maklumat Ejen</h5>

                  <div class="form-group row no-padding p-b-10 p-t-10">
                    <label for="fname" class="text-black bold required col-md-5 control-label" aria-required="true">Nama Penuh</label>
                    <div class="col-md-7">
                      <input type="text" class="form-control" id="fullname" name="fullname" required aria-required="true">
                      <!-- <span class="help">The URL to your SAML Metadata XML file. It must be publicly accessible for Pages
                      Framework to download and process.</span> -->
                    </div>
                  </div>

                  <div class="form-group row no-padding p-b-10 p-t-10">
                    <label for="fname" class="text-black bold required col-md-5 control-label" aria-required="true">No. Kad Pengenalan</label>
                    <div class="col-md-7">
                      <input disabled type="text" class="form-control" id="identificationNo" name="identificationNo" required aria-required="true">
                      <span class="help">Maklumat ini tidak boleh ditukar. jika perlukan kemaskini sila hubungi pihak admin.</span>
                    </div>
                  </div>

                  <div class="form-group row no-padding p-b-10 p-t-10">
                    <label for="fname" class="text-black bold required col-md-5 control-label" aria-required="true">Jantina</label>
                    <div class="col-md-7">
                      <select id="jantina" class="form-control" name="jantina">
                        <?php getJantina(); ?>
                      </select>
                      <!-- <span class="help">The URL to your SAML Metadata XML file. It must be publicly accessible for Pages
                      Framework to download and process.</span> -->
                    </div>
                  </div>

                  <div class="form-group row no-padding p-b-10 p-t-10">
                    <label for="fname" class="text-black bold required col-md-5 control-label" aria-required="true">Warganegara</label>
                    <div class="col-md-7">
                      <select id="nationality" class="form-control" name="nationality">
                        <?php getNegara(); ?>
                      </select>
                      <!-- <span class="help">The URL to your SAML Metadata XML file. It must be publicly accessible for Pages
                      Framework to download and process.</span> -->
                    </div>
                  </div>

                  <div class="form-group row no-padding p-b-10 p-t-10">
                    <label for="fname" class="text-black bold required col-md-5 control-label" aria-required="true">Bangsa</label>
                    <div class="col-md-7">
                      <select id="bangsa" class="form-control" name="bangsa">
                        <?php getKeturunan(); ?>
                      </select>
                      <!-- <span class="help">The URL to your SAML Metadata XML file. It must be publicly accessible for Pages
                      Framework to download and process.</span> -->
                    </div>
                  </div>
                  <h5 class="text-uppercase font-montserrat m-t-30 block-title">Maklumat Surat Menyurat</h5>

                  <div class="form-group row no-padding p-b-10 p-t-10">
                    <label for="fname" class="text-black bold required col-md-5 control-label" aria-required="true">Alamat Premis</label>
                    <div class="col-md-7">
                      <input type="text" class="form-control" id="alamat" name="alamat" required aria-required="true">
                      <!-- <span class="help">The URL to your SAML Metadata XML file. It must be publicly accessible for Pages
                      Framework to download and process.</span> -->
                    </div>
                  </div>

                  <div class="form-group row no-padding p-b-10 p-t-10">
                    <label for="fname" class="text-black bold required col-md-5 control-label" aria-required="true">Bandar</label>
                    <div class="col-md-7">
                      <input type="text" class="form-control" id="bandar" name="bandar" required aria-required="true">
                      <!-- <span class="help">The URL to your SAML Metadata XML file. It must be publicly accessible for Pages
                      Framework to download and process.</span> -->
                    </div>
                  </div>

                  <div class="form-group row no-padding p-b-10 p-t-10">
                    <label for="fname" class="text-black bold required col-md-5 control-label" aria-required="true">Negeri</label>
                    <div class="col-md-7">
                      <select id="negeri" class="form-control" name="negeri">
                        <?php getNegeri(); ?>
                      </select>
                      <!-- <span class="help">The URL to your SAML Metadata XML file. It must be publicly accessible for Pages
                      Framework to download and process.</span> -->
                    </div>
                  </div>

                  <div class="form-group row no-padding p-b-10 p-t-10">
                    <label for="fname" class="text-black bold required col-md-5 control-label" aria-required="true">Poskod</label>
                    <div class="col-md-7">
                      <input type="text" class="form-control" id="poskod" name="poskod" required aria-required="true">
                      <!-- <span class="help">The URL to your SAML Metadata XML file. It must be publicly accessible for Pages
                      Framework to download and process.</span> -->
                    </div>
                  </div>
                  <h5 class="text-uppercase font-montserrat m-t-30 block-title">Maklumat Telekomunikasi</h5>

                  <div class="form-group row no-padding p-b-10 p-t-10">
                    <label for="fname" class="text-black bold required col-md-5 control-label" aria-required="true">Alamat Emel</label>
                    <div class="col-md-7">
                      <input type="text" disabled class="form-control" id="email" name="email" required aria-required="true">
                      <span class="help">Maklumat ini tidak boleh ditukar. jika perlukan kemaskini sila hubungi pihak admin.</span>
                    </div>
                  </div>

                  <div class="form-group row no-padding p-b-10 p-t-10">
                    <label for="fname" class="text-black bold required col-md-5 control-label" aria-required="true">No. Telefon</label>
                    <div class="col-md-7">
                      <input type="text" class="form-control" id="phone" name="phone" required aria-required="true">
                      <!-- <span class="help">The URL to your SAML Metadata XML file. It must be publicly accessible for Pages
                      Framework to download and process.</span> -->
                    </div>
                  </div>
                  <h5 class="text-uppercase font-montserrat m-t-30 block-title">Maklumat Media Sosial</h5>

                  <div class="form-group row no-padding p-b-10 p-t-10">
                    <label for="fname" class="text-black bold required col-md-5 control-label" aria-required="true">Facebook</label>
                    <div class="col-md-7">
                      <input type="text" class="form-control" id="facebook" name="facebook" aria-required="true">
                      <!-- <span class="help">The URL to your SAML Metadata XML file. It must be publicly accessible for Pages
                      Framework to download and process.</span> -->
                    </div>
                  </div>

                  <div class="form-group row no-padding p-b-10 p-t-10">
                    <label for="fname" class="text-black bold required col-md-5 control-label" aria-required="true">Instagram</label>
                    <div class="col-md-7">
                      <input type="text" class="form-control" id="instagram" name="instagram" aria-required="true">
                      <!-- <span class="help">The URL to your SAML Metadata XML file. It must be publicly accessible for Pages
                      Framework to download and process.</span> -->
                    </div>
                  </div>

                  <div class="form-group row no-padding p-b-10 p-t-10">
                    <label for="fname" class="text-black bold required col-md-5 control-label" aria-required="true">linkedin</label>
                    <div class="col-md-7">
                      <input type="text" class="form-control" id="linkedin" name="linkedin" aria-required="true">
                      <!-- <span class="help">The URL to your SAML Metadata XML file. It must be publicly accessible for Pages
                      Framework to download and process.</span> -->
                    </div>
                  </div>
                  <div class="row m-t-30">
                    <div class="col-md-6">
                      <p class="small-text hint-text">Note: changes may take some time to apply. Wait a day and then try to verify again </p>
                    </div>
                    <div class="col-md-6">
                      <button aria-label="" class="btn btn-success pull-right" type="submit">Save Changes</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-5">
        <div class="card">
          <div class="card-header ">
            <div class="card-title">Pautan Channel Telegram
            </div>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-12">
                <h3 class="mw-80">Bahan Marketing eCaque</h3>
                <p class="mw-80">
                  Berikut adalah link ke Channel telegram yang telah di sediakan oleh pihak eCaque untuk
                  membantu anda untuk close sale.
                </p>
                <br>
                <p>
                  <b class="font-montserrat text-uppercase">Skrip Close Sale </b><br>
                  <a target="_blank" href="https://t.me/skripclosingecaque">t.me/skripclosingecaque</a>
                </p>
                <p>
                  <b class="font-montserrat text-uppercase">Koleksi Gambar Kek </b><br>
                  <a target="_blank" href="https://t.me/gambarecaque">t.me/gambarecaque</a>
                </p>
                <p>
                  <b class="font-montserrat text-uppercase">Video Feedback Kek </b><br>
                  <a target="_blank" href="https://t.me/videofeedbackecaque">t.me/videofeedbackecaque</a>
                </p>
                <p>
                  <b class="font-montserrat text-uppercase">Feedback Testimoni </b><br>
                  <a target="_blank" href="https://t.me/feedbackecaque">t.me/feedbackecaque</a>
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>

<?php mediaViewer(); ?>

<script type="text/javascript">

$('#form-profile').formValidation({
  fields: {
    oldpassword: {
      validators: {
          stringLength: {
              min: 8,
              message: 'Must be minimum 8 characters long '
          }
      }
    },
    password: {
      validators: {
          stringLength: {
              min: 8,
              message: 'Must be minimum 8 characters long '
          },
          callback : {
            message : 'Please input new password to change password',
            callback : function(e){
              console.log($("#oldpassword").val());
              if ($("#oldpassword").val() != "") {
                if ($("#password").val() == "") {
                  return false;
                } else {
                  return true;
                }
              } else {
                return true;
              }
            }
          }
      }
    },
    password2: {
      validators: {
          identical: {
              field: 'password',
              message: 'Password confirmation does not match '
          }
      }
    }
  }
}).on('success.form.fv', function(e) {
  // Prevent form submission
  e.preventDefault();
  runfunction = updateProfile;
  saConfirm4("Muktamat","Anda pasti maklumat pembayaran adalah betul?","warning","Ya, Pasti",runfunction,"Pasti");
});

function updateProfile(){
  var fd = new FormData(document.getElementById('form-profile'));
  fd.append("func","updateProfile");
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
          saAlert3("Berjaya",data["MSG"],"success");
        } else {
          saAlert3("Berjaya",data["MSG"],"warning");
        }
        getStockistInfos();
      },
      error: function(data) {
      }
  });
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
      },
      error: function(data) {
      }
  });
}

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

  // $("#mainDiv").hide();
  // $("#detailDiv").show();

  detectDisabled();
}

function detectDisabled(){
  $("input").parents(".form-group").removeClass("required");
  $("select").parents(".form-group").removeClass("required");

  $("input[required]").parents(".form-group").addClass("required");
  $("select[required]").parents(".form-group").addClass("required");
}

getStockistInfos();



</script>
