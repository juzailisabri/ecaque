<?php include("../formfunction.php"); ?>

<style media="screen">
  .form-control[disabled], .form-control[readonly], fieldset[disabled] .form-control{
    color: #444;
  }
</style>

<div class=" no-padding container-fixed-lg bg-white p-b-30">
  <div class="container">
    <div class="row">
      <div class="col-md-4">

        <div class="card card-transparent">
          <div class="card-header ">
            <div class="card-title">BORANG KELUAR
            </div>
          </div>
          <div class="card-body">
            <h3>PERMOHONAN UNTUK KELUAR RUMAH KELAMIN</h3>
            <p>Sila pastikan keputusan yang anda lakukan adalah muktamat.</p>
              <p>Pada tarikh akhir anda menduduki rumah RKAT pegawai kami akan hadir untuk memeriksa meter & aset rumah yang anda duduki.</p>
              <br>
              <div>
                <div class="profile-img-wrapper m-t-5 inline">
                  <img width="35" height="35" src="assets/img/profiles/avatar_small.jpg" alt="" data-src="assets/img/profiles/avatar_small.jpg" data-src-retina="assets/img/profiles/avatar_small2x.jpg">
                  <div class="chat-status available">
                  </div>
                </div>
                <div class="inline m-l-10">
                  <p class="small hint-text m-t-5">Admin Sistem RKAT
                    <br> Terima Kasih</p>
                  </div>
                </div>
              </div>
            </div>

          </div>
          <div class="col-md-8">
            <div class="row">
            <div class="col-lg-12">

              <div class="">
                <!-- <div class=" m-t-30">
                  <div class="" style="width:100%">
                    <div class="col-md-12 text-center h6">
                      <b><u>PERMOHONAN</u> <br> <small>UNTUK MENDUDUKI RUMAH KELAMIN</small></b>
                    </div>
                  </div>
                  <span class="pull-right">(BAT H 5)</span>
                </div> -->
                <div class="card-body">
                <?php
                if($keluarStatus["STATUS"]){ ?>
                  <form class="" role="form" id="application-form" method="post">
                    <div class="row m-t-20">
                      <div class="col-lg-12">
                        <div class="card card-default bg-complete">
                          <div class="card-header m-b-10 ">
                            <div class="card-title">Sebab Permohonan Keluar RKAT
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <?php radioKeluar(); ?>
                      </div>
                    </div>
                    <div class="row m-t-20">
                      <div class="col-md-12">
                        <div class="form-group form-group-default  required">
                          <div class="form-input-group">
                            <label class="fade">Tarikh Keluar RKAT yang Dipohon</label>
                            <input required data-date-format='dd-mm-yyyy' type="text" class="form-control" placeholder="Pick a date" id="mulai" name="mulai">
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row m-t-10">
                      <div class="col-md-12">
                        <button class="btn btn-primary btn-success m-t-10 " type="submit">Hantar Permohonan</button>
                        <button class="btn btn-primary btn-danger m-t-10 pull-right" type="button">Batal</button>
                        <button class="btn btn-primary btn-cons m-t-10 " type="button"><i class="fa fa-refresh"></i></button>
                      </div>
                    </div>
                  </form>
                <?php
                } else {
                ?>
                <div class="card card-default bg-danger-dark m-t-20">
                  <div class="card-header separator">
                    <div class="text-white" class="card-title">Notifikasi
                    </div>
                  </div>
                  <div class="card-body">
                      <h3 class="text-white">
                        <span class="semi-bold">Tiada Rumah yang diduduki</span>
                      </h3>
                      <p class="text-white hint-text">Sila buat permohonan Rumah kelamin dengan menekan butang 'borang permohonan'.</p>
                  </div>
                  </div>
                <?php
                } ?>
                </div>
              </div>

            </div>
          </div>
          </div>
    </div>
  </div>
</div>



<script type="text/javascript">
  // $("#pangkat").select2();
  $("#mulai").datepicker();
  $("#NoRujukanSuratKuasaDate").datepicker();
  $("#tarikhLahir").datepicker();
  $("#PerkhidmatanDari").datepicker();
  $("#PerkhidmatanHingga").datepicker();
  $("#AlamatLuarDari").datepicker();
  $("#AlamatLuarHingga").datepicker();
  $("#tarikhPerkahwinan").datepicker();

  $("#application-form").formValidation({

  }).on('success.form.fv', function(e) {
      e.preventDefault();
      runfunction = saveData;
      saConfirm2("Muktamat?","Anda pasti butiran semua betul dan hantar borang permohonan kepada Quarter Master?","warning","Yes, Confirm",runfunction,"confirmtext","confirmdesc","Dibatalkan","Terima Kasih");
  });

  function saveData(){
    saConfirm3("Submitting","Your submission is in progress. Please wait","warning");
    var myform = document.getElementById("application-form");
    var fd = new FormData(myform);
    fd.append("func","apply")
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
            saAlert3("Permohonan Dihantar",data["MSG"],"success");
            $("#borangPermohonan[class='syslink']").click();
          } else {
            saAlert3("Permohonan Gagal Dihantar",data["MSG"],"warning");
          }
        },
        error: function(data) {
          // saAlert3("Error","Session Log Out Error","warning");
        }
    });
  }

  $("#pangkat").change(function(e){
    $("#pangkat2").val($(this).val()).change();
  });

  $("#pangkat, #PerkhidmatanDari, #PerkhidmatanHingga").change(function(e){
    var pangkat = $("#pangkat").val();
    var PerkhidmatanDari = $("#PerkhidmatanDari").val();
    var PerkhidmatanHingga = $("#PerkhidmatanHingga").val();

    var fd = new FormData();
    fd.append("pangkat",pangkat);
    fd.append("PerkhidmatanDari",PerkhidmatanDari);
    fd.append("PerkhidmatanHingga",PerkhidmatanHingga);
    fd.append("func","calculatePangkatPoint");

    $.ajax({
        type: 'POST',
        url: "db",
        data: fd,
        dataType: "json",
        cache: false,
        contentType: false,
        processData: false,
        success: function(data) {
          $("#mataPerkhidmatan").val(data["MATAPERKHIDMATAN"]).change();
          $("#mataPangkat").val(data["MATAPANGKAT"]).change();
        },
        error: function(data) {
          // saAlert3("Error","Session Log Out Error","warning");
        }
    });

  });


  function getApplicant(){
    var fd = new FormData();
    fd.append("func","getApplicant");

    $.ajax({
        type: 'POST',
        url: "db",
        data: fd,
        dataType: "json",
        cache: false,
        contentType: false,
        processData: false,
        success: function(data) {
          $("#fullname").val(data[0]["aa_name"]);
          $("#notentera").val(data[0]["aa_id_no"]);
          $("#tarikhLahir").val(data[0]["aa_birthday"]);
        },
        error: function(data) {
          // saAlert3("Error","Session Log Out Error","warning");
        }
    });
  }

  $("#bilanganAnak").change(function(e){
    var bilanak = $(this).val();

    var fd = new FormData();
    fd.append("func","calculateAnakPoint");
    fd.append("bilanak",bilanak);

    $.ajax({
        type: 'POST',
        url: "db",
        data: fd,
        dataType: "json",
        cache: false,
        contentType: false,
        processData: false,
        success: function(data) {
          $("#mataAnak").val(data["MATANAK"]).change();
        },
        error: function(data) {
          // saAlert3("Error","Session Log Out Error","warning");
        }
    });
  });

  $("#AlamatLuar, [name='mode'], #AlamatLuarDari, #AlamatLuarHingga").change(function(e){
    var mode = $("[name='mode']:checked").val();
    var AlamatLuarDari = $("#AlamatLuarDari").val();
    var AlamatLuarHingga = $("#AlamatLuarHingga").val();
    var tarikhPerkahwinan = $("#tarikhPerkahwinan").val();
    var AlamatLuar = $("#AlamatLuar").val();

    if($("[name='mode']:checked").length != 0 && AlamatLuarDari != '' && AlamatLuarHingga != '' && tarikhPerkahwinan != '' && AlamatLuar != ''){
      var fd = new FormData();
      fd.append("func","calculateAlamatLuar");
      fd.append("mode",mode);
      fd.append("AlamatLuarDari",AlamatLuarDari);
      fd.append("AlamatLuarHingga",AlamatLuarHingga);
      fd.append("tarikhPerkahwinan",tarikhPerkahwinan);

      $.ajax({
          type: 'POST',
          url: "db",
          data: fd,
          dataType: "json",
          cache: false,
          contentType: false,
          processData: false,
          success: function(data) {
            $("#mataAlamatLuar").val(data["MATAALAMATLUAR"]).change();
          },
          error: function(data) {
            // saAlert3("Error","Session Log Out Error","warning");
          }
      });
    }

    $("#mataAlamatLuar, #mataPerkhidmatan, #mataPangkat, #mataAnak").change(function(e){
      var mataAlamatLuar = $("#mataAlamatLuar").val();
      var mataAnak = $("#mataAnak").val();
      var mataPerkhidmatan = $("#mataPerkhidmatan").val();
      var mataPangkat = $("#mataPangkat").val();

      var total = Math.round(mataAlamatLuar) +  Math.round(mataAnak) +  Math.round(mataPerkhidmatan) + Math.round(mataPangkat);

      $("#jumlahMata").val(total);
    });
  });

  $("[id='batalpermohonanbtn']").click(function(e){
    G_FUNC = "batalPermohonan";
    runfunction = batalPermohonan;
    saConfirm4("Confirmation","Anda Pasti untuk Membatalkan Permohonan?","warning","Ya, Pasti",runfunction);
  });
var G_FUNC = 0;

  function batalPermohonan(){
    var fd = new FormData();
    fd.append("func",G_FUNC);
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
            saAlert3("Permohonan Dibatalkan","Anda Boleh membuat permohonan semula dengan menekan butang 'Borang Permohonan'. Terima Kasih","success");
            $("#borangPermohonan[class='syslink']").click();
          }
        },
        error: function(data) {
          // saAlert3("Error","Session Log Out Error","warning");
        }
    });
  }

  getApplicant();



    // $("#PerkhidmatanHingga").rules('add', { greaterThan: "#PerkhidmatanDari" });
</script>
<script src="assets/js/scripts.js" type="text/javascript"></script>

<script src="pages/js/pages.min.js"></script>
<script src="assets/js/scripts.js" type="text/javascript"></script>
