$("[id='downloadUserDiv']").hide();

$("#back").click(function(e){
  $("#searchDiv").show();
  $("#searchResult").hide();
});

function getPermohonanFormByICKaunter(icno){
  loading();
  $("#searchDiv").hide();
  var fd = new FormData();
  fd.append("func","getPermohonanFormKaunter");
  fd.append("icno",icno);
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
        var count = Object.keys(data["P"]).length;
        if(count != 0){
          setFormP1(data["P"][0]);
          setFormP2(data["P"][0]);
          setFormP3(data["P"][0]);
          setFormP4(data["P"][0]);
          setFormP5(data["P"][0]);
          setFormP6(data["P"][0]);
          setAttachment(data["A"]);
          displayStatus(data["S"]);
          $(".myui-button").hide();
          $("a[href='#tab1']").click();

          $("#form-pt1").find("input, select, textarea").prop("disabled",true);
          $("#form-pt2").find("input, select, textarea").prop("disabled",true);
          $("#form-pt3").find("input, select, textarea").prop("disabled",true);
          $("#form-pt4").find("input, select, textarea").prop("disabled",true);
          $("#form-pt5").find("input, select, textarea").prop("disabled",true);
          $("#form-pt6").find("input, select, textarea").prop("disabled",true);
          $("#form-pt7").find("input, select, textarea").prop("disabled",true);

          $("#head-name").html(data["P"][0]["pt2_nama_pemohon"]);
          $("#head-ic").html(data["P"][0]["pt2_no_kp_pemohon"]);
          $("#head-uni").html(data["P"][0]["university"]);
          $("#head-email").html(data["P"][0]["pt2_emel_pemohon"]);
          $("#head-phone").html(data["P"][0]["pt2_no_telefon_pemohon"]);
          AAP = data["P"][0]["enc_id"];

          SuccessNoti("Berjaya","Data <b>"+data["P"][0]["pt2_nama_pemohon"]+"</b> ditemui");
          $("#searchResult").show();
        } else {
          AAP = null;
          $("#searchResult").hide();
          saAlert3("Harap Maaf","Tiada Rekod Permohonan Dijumpai dalam Pengkalan data","warning");
        }
      },
      error: function(data) {
      }
  });
}

function getPermohonanFormByIC(icno){
  loading();
  $("#searchDiv").hide();
  var fd = new FormData();
  fd.append("func","getPermohonanForm");
  fd.append("icno",icno);
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
        var count = Object.keys(data["P"]).length;
        if(count != 0){
          setFormP1(data["P"][0]);
          setFormP2(data["P"][0]);
          setFormP3(data["P"][0]);
          setFormP4(data["P"][0]);
          setFormP5(data["P"][0]);
          setFormP6(data["P"][0]);
          setAttachment(data["A"]);
          displayStatus(data["S"]);
          $(".myui-button").hide();
          $("a[href='#tab1']").click();

          $("#form-pt1").find("input, select, textarea").prop("disabled",true);
          $("#form-pt2").find("input, select, textarea").prop("disabled",true);
          $("#form-pt3").find("input, select, textarea").prop("disabled",true);
          $("#form-pt4").find("input, select, textarea").prop("disabled",true);
          $("#form-pt5").find("input, select, textarea").prop("disabled",true);
          $("#form-pt6").find("input, select, textarea").prop("disabled",true);
          $("#form-pt7").find("input, select, textarea").prop("disabled",true);

          $("#head-name").html(data["P"][0]["pt2_nama_pemohon"]);
          $("#head-ic").html(data["P"][0]["pt2_no_kp_pemohon"]);
          $("#head-uni").html(data["P"][0]["university"]);
          $("#head-email").html(data["P"][0]["pt2_emel_pemohon"]);
          $("#head-phone").html(data["P"][0]["pt2_no_telefon_pemohon"]);
          AAP = data["P"][0]["enc_id"];

          SuccessNoti("Berjaya","Data <b>"+data["P"][0]["pt2_nama_pemohon"]+"</b> ditemui");
          $("#searchResult").show();
        } else {
          AAP = null;
          $("#searchResult").hide();
          saAlert3("Harap Maaf","Tiada Rekod Permohonan Dijumpai dalam Pengkalan data","warning");
        }
      },
      error: function(data) {
      }
  });
}

function setAttachment(data){
  $("[id='ulist']").html("");
  $.each(data, function( key, value ) {
    var did = data[key]["apa_input_name"];
    var url = data[key]["url"];
    var enc_id = data[key]["enc_id"];
    $("[id='ulistbody'][did='"+did+"']").show();

    var html =
    '<div class="">'+
     '<a id="viewattach" href="'+url+'" target="_blank"><i class="fa fa-paperclip m-r-5"></i>'+data[key]["apa_filename"]+'</a>'+
    '</div>';

    $("[id='ulist'][did='"+did+"']").append(html);
  });

  $("[id='viewattach']").click(function(e){
    e.preventDefault();
    var url = $(this).attr("href");
    var extension = getFileExtension(url);
    if(extension == "pdf"){
      $("#pdfpreview").attr("src",url);
      $("#pdfpreview").show();
      $("#myModal").modal();
    } else {
      var image = new Image();
      image.src = url;
      var viewer = new Viewer(image, {
        hidden: function () {
          viewer.destroy();
        },
      });
      viewer.show();
    }
  });

  $("[id='examples']").click(function(e){
    e.preventDefault();
    var url = $(this).attr("href");
    var extension = getFileExtension(url);
    var image = new Image();
    image.src = url;
    var viewer = new Viewer(image, {
      hidden: function () {
        viewer.destroy();
      },
    });
    viewer.show();
  });

  $("[id='deleteAttach']").click(function(e){
    e.preventDefault();
    var apa = $(this).attr("apa");
    APAID = apa;
    runfunction = deleteattach;
    saConfirm4("Delete","Anda pasti untuk buang dokumen?","warning","Ya, Pasti",runfunction,"Pasti");
  });

  var APAID = null;

  function deleteattach(){
    var func = "deleteAttachment";
    var fd = new FormData();
    fd.append("func",func)
    fd.append("apa",APAID)
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
            saAlert3("Delete","Dokumen anda berjaya dibuang","success");
            refreshattachment();
          } else {
            saAlert3("Delete","Dokumen anda gagal dibuang","warning");
          }
        },
        error: function(data) {
        }
    });
  }
  // $("#form-pt7").formValidation("resetForm");
  // $("#form-pt7").formValidation("validate");
}

(function($) {
    FormValidation.Validator.uploadchecker = {
      validate: function(validator, $field, options) {
          var id = $field.attr("id");
          var did = $("input[type='file'][name='"+id+"']").attr("did");
          var ulist = $("[id='ulist'][did='"+did+"']").find("div").length;
          if(ulist === 0){
            return false;
          } else {
            return true;
          }
      }
    };
}(window.jQuery));

function displayStatus(data){
  console.log("display");
  $("#statusdiv").empty();

  $.each(data, function( key, value ) {
    var html = data[key]["div"];
    $("#statusdiv").append(html);
  });
}

function setFormP1(data){
  $("#pejabatdaerah").val(data["pt1_pejabat_daerah"]).change();
  $("#pbt").val(data["pt1_pbt"]).change();
  $("#pkd").val(data["pt1_pusat_khidmat_dun"]).change();
  $("#parlimen").val(data["pt1_parlimen"]).change();
  $("#dun").val(data["pt1_dun"]).change();
}

function setFormP2(data){
  $("#pt2_icno").val(data["pt2_no_kp_pemohon"]).change();
  $("#pt2_fullname").val(data["pt2_nama_pemohon"]).change();
  $("#pt2_address1").val(data["pt2_alamat_pemohon"]).change();
  $("#pt2_address2").val(data["pt2_alamat_pemohon2"]).change();
  // $("#pt2_alamat_pemohon3").val(data["pt2_alamat_pemohon3"]).change();
  $("#pt2_poscode").val(data["pt2_poskod_pemohon"]).change();
  $("#pt2_telephone").val(data["pt2_no_telefon_pemohon"]).change();
  $("#pt2_email").val(data["pt2_emel_pemohon"]).change();
  $("#pt2_cellphone").val(data["pt2_no_hp_pemohon"]).change();
  $("#pt2_warganegara").val(data["pt2_warganegara_pemohon"]).change();
  $("#pt2_umur").val(data["pt2_umur_pemohon"]).change();
  $("#pt2_keturunan").val(data["pt2_keturunan_pemohon"]).change();
  $("#pt2_keturunan_specify").val(data["pt2_keturunan_specify"]).change();
  $("#pt2_birthdate").datepicker('setDate', data["pt2_tarikh_lahir_pemohon"]);
  // $("#pt2_birthdate").val(data["pt2_tarikh_lahir_pemohon"]).change();
  $("#pt2_negeri_lahir").val(data["pt2_negeri_lahir_pemohon"]).change();
  $("#pt2_daerah_lahir").val(data["pt2_daerah_lahir_pemohon"]).change();
  $("#pt2_jantina").val(data["pt2_jantina_pemohon"]).change();
  $("#pt2_bank").val(data["pt2_nama_bank"]).change();
  $("#pt2_bankaccount").val(data["pt2_no_akaun"]).change();
  $("#pt2_negeri").val(data["pt2_negeri_pemohon"]).change();
  $("#pt2_daerah").val(data["pt2_daerah_pemohon"]).change();
  $("#pt2_bandar").val(data["pt2_bandar_pemohon"]).change();
}

function setFormP3(data){
  $("#pt3_jenisInstitusi").val(data["pt3_jenis_ipt"]).change();
  $("#pt3_namaInstitusi_awam").val(data["pt3_nama_institusi"]).change();
  $("#pt3_peringkatPengajian").val(data["pt3_peringkat_pengajian"]).change();
  $("#pt3_ulnNegara").val(data["pt3_negara_uln"]).change();
  $("#pt3_ulnName").val(data["pt3_ins_uln"]).change();
  $("#pt3_namaInstitusi_swasta").val(data["pt3_ins_ipts"]).change();
  $("#pt3_iptsOther").val(data["pt3_ins_ipts_lain"]).change();
  $("#pt3_namaKursus").val(data["pt3_nama_kursus"]).change();
  $("#pt3_fakulti").val(data["pt3_fakulti_pusat"]).change();
  $("#pt3_bulanKemasukan").val(data["pt3_sesi_kemasukan_bulan"]).change();
  $("#pt3_tahunKemasukan").val(data["pt3_sesi_kemasukan_tahun"]).change();
  $("#pt3_jenisPengajian").val(data["pt3_jenis_pengajian"]).change();
  $("#pt3_bulanKemasukan").val(data["pt3_bulan_masuk"]).change();
  $("#pt3_tarikhPendaftaran").val(data["pt3_tarikh_pendaftaran_diri"]).change();
  $("#pt3_tempohTahunPengajianTahun").val(data["pt3_tempoh_pengajian_tahun"]).change();
  $("#pt3_tempohBulanPengajianBulan").val(data["pt3_tempoh_pengajian_bulan"]).change();
}

function setFormP4(data){
  $("#pt4_negeriLahirBapa").val(data["pt4_negeri_lahir_bapa"]).change();
  $("#pt4_statusBapa").val(data["pt4_status_bapa"]).change();
  $("#pt4_namaBapa").val(data["pt4_nama_bapa"]).change();
  $("#pt4_jenisIC").val(data["pt4_jenis_kp_bapa"]).change();
  $("#pt4_icBapa").val(data["pt4_no_kp_bapa"]).change();
  $("#pt4_tarikh_lahir_bapa").val(data["pt4_tarikh_lahir_bapa"]).change();
  $("#pt4_keturunanBapa").val(data["pt4_keturunan_bapa"]).change();
  $("#pt4_pekerjaanBapa").val(data["pt4_pekerjaan_bapa"]).change();
  $("#pt4_namaMajikanBapa").val(data["pt4_nama_majikan_bapa"]).change();
  $("#pt4_alamatMajikanBapa").val(data["pt4_alamat_majikan_bapa"]).change();
  $("#pt4_noTelefonMajikanBapa").val(data["pt4_no_telefon_majikan_bapa"]).change();
  $("#pt4_pendapatanSebenarBapa").val(data["pt4_pendapatan_bapa"]).change();
  $("#pt4_anggaranGajiBapa").val(data["pt4_julat_pendapatan_bapa"]).change();
}

function setFormP5(data){
  $("#pt5_negeriLahirIbu").val(data["pt5_negeri_lahir_ibu"]).change();
  $("#pt5_statusIbu").val(data["pt5_status_ibu"]).change();
  $("#pt5_namaIbu").val(data["pt5_nama_ibu"]).change();
  $("#pt5_jenisIC").val(data["pt5_jenis_kp_ibu"]).change();
  $("#pt5_icIbu").val(data["pt5_no_kp_ibu"]).change();
  $("#pt5_tarikh_lahir_Ibu").val(data["pt5_tarikh_lahir_ibu"]).change();
  $("#pt5_keturunanIbu").val(data["pt5_keturunan_ibu"]).change();
  $("#pt5_pekerjaanIbu").val(data["pt5_pekerjaan_ibu"]).change();
  $("#pt5_namaMajikanIbu").val(data["pt5_nama_majikan_ibu"]).change();
  $("#pt5_alamatMajikanIbu").val(data["pt5_alamat_majikan_ibu"]).change();
  $("#pt5_noTelefonMajikanIbu").val(data["pt5_no_telefon_majikan_ibu"]).change();
  $("#pt5_pendapatanSebenarIbu").val(data["pt5_pendapatan_ibu"]).change();
  $("#pt5_anggaranGajiIbu").val(data["pt5_julat_pendapatan_ibu"]).change();
}

function setFormP6(data){
  $("#pt6_negeriLahirPenjaga").val(data["pt6_negeri_penjaga"]).change();
  $("#pt6_statusPenjaga").val(data["pt6_status_penjaga"]).change();
  $("#pt6_namaPenjaga").val(data["pt6_nama_penjaga"]).change();
  $("#pt6_jenisIC").val(data["pt6_jenis_kp_penjaga"]).change();
  $("#pt6_icPenjaga").val(data["pt6_no_kp_penjaga"]).change();
  $("#pt6_tarikh_lahir_Penjaga").val(data["pt6_tarikh_lahir_penjaga"]).change();
  $("#pt6_keturunanPenjaga").val(data["pt6_keturunan_penjaga"]).change();
  $("#pt6_pekerjaanPenjaga").val(data["pt6_pekerjaan_penjaga"]).change();
  $("#pt6_namaMajikanPenjaga").val(data["pt6_nama_majikan_penjaga"]).change();
  $("#pt6_alamatMajikanPenjaga").val(data["pt6_alamat_majikan_penjaga"]).change();
  $("#pt6_noTelefonMajikanPenjaga").val(data["pt6_no_telefon_majikan_penjaga"]).change();
  $("#pt6_pendapatanSebenarPenjaga").val(data["pt6_pendapatan_penjaga"]).change();
  $("#pt6_anggaranGajiPenjaga").val(data["pt6_julat_pendapatan_penjaga"]).change();
}

$("[data-init-plugin='select2']").select2();
$("#pt2_bandar").chained("#pt2_negeri");
$("#pt2_daerah").chained("#pt2_negeri");
$("#pt2_daerah_lahir").chained("#pt2_negeri_lahir");
$("#pt3_namaInstitusi_swasta").chained("#pt3_jenisInstitusi");
$("#pt3_namaInstitusi_awam").chained("#pt3_jenisInstitusi");

$("#pt3_jenisInstitusi").change(function(e){
var val = $(this).val();
$("[id='iptawam']").hide();
$("[id='iptswasta']").hide();
$("[id='iptluar']").hide();

if(val == 1){
  $("[id='iptawam']").show();
} else if (val == 2) {
  $("[id='iptswasta']").show();
} else if (val == 3) {
  $("[id='iptluar']").show();
} else {

}
});

$("#pt3_namaInstitusi_swasta").change(function(e){
var val = $(this).val();
if(val == "-1"){
  $("[id='iptswasta_lain2']").show();
} else {
  $("[id='iptswasta_lain2']").hide();
}
});

$("#pt3_bulanKemasukan").datepicker({
viewMode: "months",
minViewMode: "months",
format: 'mm'
});

$("#pt3_tahunKemasukan").datepicker({
viewMode: "years",
minViewMode: "years",
format: 'yyyy'
});

$("#pt3_tarikhPendaftaran").datepicker({
format: 'dd-mm-yyyy'
});

$("#pt2_birthdate").datepicker({
format: 'dd-mm-yyyy'
});

$("#pt3_tahunKemasukan").change(function(e){
$("#form-pt3").formValidation("revalidateField","pt3_tahunKemasukan")
});

$("#pt3_bulanKemasukan").change(function(e){
$("#form-pt3").formValidation("revalidateField","pt3_bulanKemasukan")
});

$("#pt3_tarikhPendaftaran").change(function(e){
$("#form-pt3").formValidation("revalidateField","pt3_tarikhPendaftaran")
});

$("#pt4_pekerjaanBapa").change(function(e){
  pekerjaanBapa();
});

function pekerjaanBapa(){
  var val = $("#pt4_pekerjaanBapa").val();
  // $("#form-pt4").find("input, select, textarea").attr("disabled",false);
  $("#form-pt4").formValidation("resetForm");

  var nomajikan = $("#pt4_pekerjaanBapa > option:selected").attr("no-majikan");
  if(nomajikan == 1){
    $("#divPekerjaanBapaDetails").find("input, select, textarea").prop("disabled",true);
  } else {
    $("#divPekerjaanBapaDetails").find("input, select, textarea").prop("disabled",false);
  }

  if(val == 3 || val == 4 || val == 7  || val == ""){
    $("#SalinanPenyataPendapatanBapa").hide();
  } else {
    $("#SalinanPenyataPendapatanBapa").show();
  }

  if(val == 3 || val == 4){
    $("#KadPesaraPenyataBayaranPencenBapa").show();
  } else {
    $("#KadPesaraPenyataBayaranPencenBapa").hide();
  }

  if(val == 6 || val == 7){
    $("#SuratPerakuanPendapatanBapa").show();
    $("#pt4_anggaranGajiBapa").attr("disabled",false);
    $("#pt4_pendapatanSebenarBapa").attr("disabled",true);
  } else {
    $("#SuratPerakuanPendapatanBapa").hide();
    $("#pt4_anggaranGajiBapa").attr("disabled",true);
    $("#pt4_pendapatanSebenarBapa").attr("disabled",false);
  }
  detectDisabled();
}

$("#pt5_pekerjaanIbu").change(function(e){
  pekerjaanIbu();
});

function pekerjaanIbu(){
  var val = $("#pt5_pekerjaanIbu").val();
  // $("#form-pt5").find("input, select, textarea").attr("disabled",false);
  $("#form-pt5").formValidation("resetForm");

  var nomajikan = $("#pt5_pekerjaanIbu > option:selected").attr("no-majikan");
  if(nomajikan == 1){
    $("#divPekerjaanIbuDetails").find("input, select, textarea").attr("disabled",true);
  } else {
    $("#divPekerjaanIbuDetails").find("input, select, textarea").attr("disabled",false);
  }

  if(val == 3 || val == 4 || val == 7  || val == ""){
    $("#SalinanPenyataPendapatanIbu").hide();
  } else {
    $("#SalinanPenyataPendapatanIbu").show();
  }

  if(val == 3 || val == 4){
    $("#KadPesaraPenyataBayaranPencenIbu").show();
  } else {
    $("#KadPesaraPenyataBayaranPencenIbu").hide();
  }

  if(val == 6 || val == 7){
    $("#SuratPerakuanPendapatanIbu").show();
    $("#pt5_anggaranGajiIbu").attr("disabled",false);
    $("#pt5_pendapatanSebenarIbu").attr("disabled",true);
  } else {
    $("#SuratPerakuanPendapatanIbu").hide();
    $("#pt5_anggaranGajiIbu").attr("disabled",true);
    $("#pt5_pendapatanSebenarIbu").attr("disabled",false);
  }

  detectDisabled();
}

$("#pt6_pekerjaanPenjaga").change(function(e){
  var val = $(this).val();
  // $("#form-pt6").find("input, select, textarea").attr("disabled",false);
  $("#form-pt6").formValidation("resetForm");

  var nomajikan = $("#pt6_pekerjaanPenjaga > option:selected").attr("no-majikan");
  if(nomajikan == 1){
    $("#divPekerjaanPenjagaDetails").find("input, select, textarea").attr("disabled",true);
  } else {
    $("#divPekerjaanPenjagaDetails").find("input, select, textarea").attr("disabled",false);
  }

  if(val == 3 || val == 4 || val == 7  || val == ""){
    $("#SalinanPenyataPendapatanPenjaga").hide();
  } else {
    $("#SalinanPenyataPendapatanPenjaga").show();
  }

  if(val == 3 || val == 4){
    $("#KadPesaraPenyataBayaranPencenPenjaga").show();
  } else {
    $("#KadPesaraPenyataBayaranPencenPenjaga").hide();
  }

  if(val == 6 || val == 7){
    $("#SuratPerakuanPendapatanPenjaga").show();
    $("#pt6_anggaranGajiPenjaga").attr("disabled",false);
    $("#pt6_pendapatanSebenarPenjaga").attr("disabled",true);
  } else {
    $("#SuratPerakuanPendapatanPenjaga").hide();
    $("#pt6_anggaranGajiPenjaga").attr("disabled",true);
    $("#pt6_pendapatanSebenarPenjaga").attr("disabled",false);
  }
  detectDisabled();
});

$("#pt4_statusBapa, #pt5_statusIbu").change(function(e){
  var bapa = $("#pt4_statusBapa").val();
  var ibu = $("#pt5_statusIbu").val();

  var bapakerja = $("#pt4_pekerjaanBapa").val();
  var ibukerja = $("#pt5_pekerjaanIbu").val();

  var id = $(this).attr("id");
  if (id == "pt4_statusBapa") {
    $("#form-pt4").formValidation('resetForm',false);
  } else if (id = "pt5_statusIbu") {
    $("#form-pt5").formValidation('resetForm',false);
  }

  if((bapa == "4" || bapa == "2") && (ibu == "4" || ibu == "2")){ // NO IBU BAPA
    $("a[data-target='#tab6']").parents(".nav-item").show();
    if(bapa == 4 || bapa == 2){
      $("[id='divPekerjaanBapaDetails'], [id='divPekerjaanBapa']").find("input, select, textarea").attr("disabled",true);
      $("[id='divPekerjaanBapaDetails'], [id='divPekerjaanBapa']").find(".form-group").removeClass("required");
    } else {
      $("[id='divPekerjaanBapaDetails'], [id='divPekerjaanBapa']").find("input, select, textarea").attr("disabled",false);
      $("[id='divPekerjaanBapaDetails'], [id='divPekerjaanBapa']").find(".form-group").addClass("required");
    }

    if(ibu == 4 || ibu == 2){
      $("[id='divPekerjaanIbuDetails'], [id='divPekerjaanIbu']").find("input, select, textarea").attr("disabled",true);
      $("[id='divPekerjaanIbuDetails'], [id='divPekerjaanIbu']").find(".form-group").removeClass("required");
    } else {
      $("[id='divPekerjaanIbuDetails'], [id='divPekerjaanIbu']").find("input, select, textarea").attr("disabled",false);
      $("[id='divPekerjaanIbuDetails'], [id='divPekerjaanIbu']").find(".form-group").addClass("required");
    }
  } else {
    if(bapa == 4 || bapa == 2){
      $("[id='divPekerjaanBapaDetails'], [id='divPekerjaanBapa']").find("input, select, textarea").attr("disabled",true);
      $("[id='divPekerjaanBapaDetails'], [id='divPekerjaanBapa']").find(".form-group").removeClass("required");
    } else {
      $("[id='divPekerjaanBapaDetails'], [id='divPekerjaanBapa']").find("input, select, textarea").attr("disabled",false);
      $("[id='divPekerjaanBapaDetails'], [id='divPekerjaanBapa']").find(".form-group").addClass("required");
    }

    if(ibu == 4 || ibu == 2){
      $("[id='divPekerjaanIbuDetails'], [id='divPekerjaanIbu']").find("input, select, textarea").attr("disabled",true);
      $("[id='divPekerjaanIbuDetails'], [id='divPekerjaanIbu']").find(".form-group").removeClass("required");
    } else {
      $("[id='divPekerjaanIbuDetails'], [id='divPekerjaanIbu']").find("input, select, textarea").attr("disabled",false);
      $("[id='divPekerjaanIbuDetails'], [id='divPekerjaanIbu']").find(".form-group").addClass("required");
    }

    pekerjaanBapa();
    pekerjaanIbu();

    $("#form-pt6").formValidation("resetForm",true);
    // $("#pt6_namaPenjaga").change();
    $("a[data-target='#tab6']").parents(".nav-item").hide();
    // $("#pt6_pekerjaanPenjaga").val("").change();
  }

  $("#KadPengenalanBapa").hide();
  $("#KadPengenalanIbu").hide();
  $("#KadPengenalanPenjaga").hide();
  $("#SalinanSijilKematianBapa").hide();
  $("#SalinanSijilKematianIbu").hide();
  $("#SalinanSuratPerakuanCerai").hide();
  $("#SalinanSuratAkuanSumpah").hide();
  $("#SalinanPenyataPendapatanBapa").hide();
  $("#SalinanPenyataPendapatanIbu").hide();
  $("#SalinanPenyataPendapatanPenjaga").hide();
  $("#KadPesaraPenyataBayaranPencenBapa").hide();
  $("#KadPesaraPenyataBayaranPencenIbu").hide();
  $("#KadPesaraPenyataBayaranPencenPenjaga").hide();

  if((bapa == 2 || bapa == 4) && (ibu == 2 || ibu == 4)){ // DUA2 TIDAK DIJUMPAI
    $("#KadPengenalanPenjaga").show();
    $("#SalinanSuratAkuanSumpah").show();
    $("#SalinanPenyataPendapatanPenjaga").show();
    $("#KadPesaraPenyataBayaranPencenPenjaga").show();
    $("#SalinanSuratAkuanSumpah").show();
    if(bapa == 4){ $("#SalinanSijilKematianBapa").show(); }
    if(ibu == 4){ $("#SalinanSijilKematianIbu").show(); }
  } else {
    if(bapa != 2 && bapa != 4){
      $("#KadPengenalanBapa").show();
      pekerjaanBapa();// $("#SalinanPenyataPendapatanBapa").show();
    }
    if(ibu != 2 && ibu != 4){
      $("#KadPengenalanIbu").show();
      pekerjaanIbu();// $("#SalinanPenyataPendapatanIbu").show();
    }
    if(bapa == 3 || ibu == 3){ $("#SalinanSuratPerakuanCerai").show(); }
    // $("#pt6_pekerjaanPenjaga").change();
  }
  detectDisabled();
});

$("#pt2_keturunan").change(function(e){
var val = $(this).val();
if (val==99) {
  $("#pt2_keturunan_specify").prop("disabled",false);
  $("#pt2_keturunan_specify").val("")
} else {
  $("#pt2_keturunan_specify").prop("disabled",true);
  $("#pt2_keturunan_specify").val("")
}
detectDisabled();

});

function detectDisabled(){
$("input").parents(".form-group").removeClass("disabled");
$("input").parents(".form-group").removeClass("disabled");
$("textarea").parents(".form-group").removeClass("disabled");
$("textarea").parents(".form-group").removeClass("disabled");

$("input[readonly]").parents(".form-group").addClass("disabled");
$("input[disabled]").parents(".form-group").addClass("disabled");
$("textarea[readonly]").parents(".form-group").addClass("disabled");
$("textarea[disabled]").parents(".form-group").addClass("disabled");
}

detectDisabled();

$("input[type='file']").change(function(e){
var file = $(this)[0].files[0];
var filename = file.name;
$(this).prev().html(filename);
var size = (Math.round(file.size / 1024))/1000;
var MaxSize = $(this).attr("maxSize");
var did = $(this).attr("did");
var type = getFileExtension(filename);
var allowedformat = $(this).attr("format");
allowedformat = allowedformat.trim();
allowedformat = allowedformat.replace(/,/g, '');
allowedformat = allowedformat.replace(/ /g, '');
allowedformat = allowedformat.split(".");
// console.log(size);

var type = getFileExtension(filename);

// console.log(type);

if(jQuery.inArray(type, allowedformat) != -1){
  if(size <= MaxSize){
    var formData = new FormData();
    formData.append('file', file);
    formData.append('did', did);
    formData.append('func', "uploadDocument");
    $("#progress-bar2").width('0%');
    $("#loading").modal();
    $.ajax({
        type: 'POST',
        url: "db",
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        beforeSend: function() {
          $("#progress-bar2").width('0%');
          $("#loading").modal();
        },
        uploadProgress: function(event, position, total, percentComplete) {
          $("#progress-bar2").width(percentComplete + '%');
        },
        success: function(data) {
          $("#progressdiv2").fadeOut();
          setTimeout(function(e){$("#loading").modal('hide');$("#progress-bar2").width('0%');},1000);
          refreshattachment();
        },
        error: function(data) {
            // console.log("error");
        },
        xhr: function() {
          myXhr = $.ajaxSettings.xhr();
          if (myXhr.upload) {
              myXhr.upload.addEventListener('progress', showProgress2, false);
          } else {
              // console.log("Upload is not supported.");
          }
          return myXhr;
        }
    });
  } else {
    saAlert3("Error","Size File Tidak Dibenarkan","warning");
    $(this).val("");
  }
} else {
  saAlert3("Error","Format File Tidak Dibenarkan","warning");
  $(this).val("");
}
});

function showProgress2(evt) {
  if (evt.lengthComputable) {
      var percentComplete = (evt.loaded / evt.total) * 100;
      $("#progress-bar2").width(Math.round(percentComplete) + '%');
      $("#load-percentage2").html("" + Math.round(percentComplete) + '%');
  }
}



$(document).ajaxStart(function() {
  $('#loadingDiv').show();
});

jQuery.ajaxSetup({
  beforeSend: function(XMLHttpRequest) {

  },
  complete: function() {
    $("#loadingDiv").delay(1000).fadeOut(1000);
  }
});

function getFileExtension(filename) {
  var ext = /^.+\.([^.]+)$/.exec(filename);
  return ext == null ? "" : ext[1];
}

$("#pt1-next").click(function(e){
if(statp1){
  // SuccessNoti("Terima Kasih","Bahagian 1 Lengkap");
  $("a[href='#tab2']").click();
} else {
  // $("#form-pt1").formValidation("validate");
  // saAlert3("Maklumat Tidak Lengkap","Sila Isi Bahagian 1 (Kawasan Permastautin) dengan Lengkap, Terima Kasih","warning");
}
});

$("#pt2-next").click(function(e){
if(statp2){
  // SuccessNoti("Terima Kasih","Bahagian 2 Lengkap");
  $("a[href='#tab3']").click();
} else {
  // $("#form-pt2").formValidation("validate");
  // saAlert3("Maklumat Tidak Lengkap","Sila Isi Bahagian 2 (Butiran Pemohon) dengan Lengkap, Terima Kasih","warning");
}
});

$("#pt3-next").click(function(e){
if(statp3){
  // SuccessNoti("Terima Kasih","Bahagian 3 Lengkap");
  $("a[href='#tab4']").click();
} else {
  // $("#form-pt3").formValidation("validate");
  // saAlert3("Maklumat Tidak Lengkap","Sila Isi Bahagian 3 (Butiran Pengajian) dengan Lengkap, Terima Kasih","warning");
}
});

$("#pt4-next").click(function(e){
if(statp4){
  // SuccessNoti("Terima Kasih","Bahagian 4 Lengkap");
  $("a[href='#tab5']").click();
} else {
  // $("#form-pt4").formValidation("validate");
  // saAlert3("Maklumat Tidak Lengkap","Sila Isi Bahagian 4 (Butiran Bapa) dengan Lengkap, Terima Kasih","warning");
}
});

$("#pt5-next").click(function(e){
if(statp5){
  // SuccessNoti("Terima Kasih","Bahagian 5 Lengkap");
  var penjaga = $("a[data-target='#tab6']").parents(".nav-item").is(':visible');
  if(penjaga){
    $("a[href='#tab6']").click();
  } else {
    $("a[href='#tab7']").click();
  }
} else {
  // $("#form-pt5").formValidation("validate");
  // saAlert3("Maklumat Tidak Lengkap","Sila Isi Bahagian 5 (Butiran Ibu) dengan Lengkap, Terima Kasih","warning");
}
});

$("#pt6-next").click(function(e){
if(statp6){
  // SuccessNoti("Terima Kasih","Bahagian 6 Lengkap");
  $("a[href='#tab7']").click();
} else {
  // $("#form-pt6").formValidation("validate");
  // saAlert3("Maklumat Tidak Lengkap","Sila Isi Bahagian 6 (Butiran Penjaga) dengan Lengkap, Terima Kasih","warning");
}
});

$("#pt7-next").click(function(e){
if(statp7){
  // SuccessNoti("Terima Kasih","Bahagian 7 Lengkap");
  $("a[href='#tab8']").click();
} else {
  // $("#form-pt7").formValidation("validate");
  // saAlert3("Maklumat Tidak Lengkap","Sila Isi Bahagian 7 (Muat Naik Dokumen) dengan Lengkap, Terima Kasih","warning");
}
});

$("[id='prev']").click(function(e){
var href = $(this).attr("target");
$("a[href='"+href+"']").click();
});

$("button[id='prevpt7']").click(function(e){
var penjaga = $("a[data-target='#tab6']").parents(".nav-item").is(':visible');
if(penjaga){
  $("a[href='#tab6']").click();
} else {
  $("a[href='#tab5']").click();
}
});

$("a[href='#tab8']").click(function(e){
var success = "fa fa-check text-success m-r-5";
var failed = "fa fa-close text-danger m-r-5";
var penjaga = $("a[data-target='#tab6']").parents(".nav-item").is(':visible');
if(!penjaga){ statp6 = true; $("#stat-Penjaga").hide() }

$("#stat-Pemastautin").find("i").removeClass();
$("#stat-Pemohon").find("i").removeClass();
$("#stat-Pengajian").find("i").removeClass();
$("#stat-Bapa").find("i").removeClass();
$("#stat-Ibu").find("i").removeClass();
$("#stat-Penjaga").find("i").removeClass();
$("#stat-Dokumen").find("i").removeClass();

if(statp1){ $("#stat-Pemastautin").find("i").addClass(success); } else { $("#stat-Pemastautin").find("i").addClass(failed); }
if(statp2){ $("#stat-Pemohon").find("i").addClass(success); } else { $("#stat-Pemohon").find("i").addClass(failed); }
if(statp3){ $("#stat-Pengajian").find("i").addClass(success); } else { $("#stat-Pengajian").find("i").addClass(failed); }
if(statp4){ $("#stat-Bapa").find("i").addClass(success); } else { $("#stat-Bapa").find("i").addClass(failed); }
if(statp5){ $("#stat-Ibu").find("i").addClass(success); } else { $("#stat-Ibu").find("i").addClass(failed); }
if(statp6){ $("#stat-Penjaga").find("i").addClass(success); } else { $("#stat-Penjaga").find("i").addClass(failed); }
if(statp7){ $("#stat-Dokumen").find("i").addClass(success); } else { $("#stat-Dokumen").find("i").addClass(failed); }
});

// $("#hantarPermohonan").click(function(e){
// if (statp1 && statp2 && statp3 && statp4 && statp5 && statp6 && statp7) {
//   runfunction = send;
//   saConfirm4("Hantar Pemohonan","Anda pasti untuk Hantar Permohonan?","warning","Ya, Pasti",runfunction,"Pasti");
// } else {
//   saAlert3("Maklumat Tidak Lengkap"," Sila Lengkapkan semua butiran di dalam semua bahagian yang diperlukan, Terima Kasih","warning");
// }
// });

// function send(){
// var fd = new FormData();
// fd.append("func","submitApplication")
// $.ajax({
//     type: 'POST',
//     url: "db",
//     data: fd,
//     dataType: "json",
//     cache: false,
//     contentType: false,
//     processData: false,
//     success: function(data) {
//       if(data["STATUS"]){
//         saAlert3("Permohonan Dihantar","Permohonan Berjaya Dihantar","success");
//         $("a.syslink[href='page/dashboard']").click();
//       } else {
//         saAlert3("Permohonan Gagal Dihantar","Permohonan Gagal Dihantar","warning");
//       }
//     },
//     error: function(data) {
//       // saAlert3("Error","Session Log Out Error","warning");
//     }
// });
// }

$("#toDashboard").click(function(e){
$("a.syslink[href='page/dashboard']").click();
});

var G_imageRotate = 0;

$("#rotate_cw").click(function(e){
  var plus = 90;
  G_imageRotatebef = G_imageRotate;
  G_imageRotate = G_imageRotate + plus;
  $("#imgpreview").rotate({
      angle: G_imageRotatebef,
      center: ["50%", "50%"],
      animateTo:G_imageRotate
    });
});
$("#rotate_ccw").click(function(e){
  var plus = 90;
  G_imageRotatebef = G_imageRotate;
  G_imageRotate = G_imageRotate - plus;
  $("#imgpreview").rotate({
      angle: G_imageRotatebef,
      center: ["50%", "50%"],
      animateTo:G_imageRotate
    });
});
