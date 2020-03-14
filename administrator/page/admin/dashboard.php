<?php
include("../../formfunction.php");
//
// function dashboard(){
//   global $conn;
//
//   $select = "SELECT
//   SUM(pembayaran_ppb_id IS NULL AND pelulus_stat = '4001') as pending,
//   SUM(pembayaran_ppb_id IS NOT NULL AND pelulus_stat = '4001') as proses,
//   SUM(pelulus_stat = '4001') as total
//
//   FROM a_applicant_permohonan
//   ";
//
//   $result = $conn->query($select);
//
//   $arr = array();
//   while ($row = $result->fetch_assoc()) {
//     $arr[] = $row;
//   }
//
//   return $arr;
// }
//
// function graft(){
//   global $conn;
//   $basicselect = "status_permohonan = '0001'";
//   $select = "SELECT
//   SUM($basicselect AND YEAR(tarikh_permohonan) = YEAR(NOW()) AND MONTH(tarikh_permohonan) = MONTH(NOW())) as m1,
//   SUM($basicselect AND YEAR(tarikh_permohonan) = YEAR(DATE_ADD(NOW(), INTERVAL -1 MONTH)) AND MONTH(tarikh_permohonan) = MONTH(DATE_ADD(NOW(), INTERVAL -1 MONTH))) as m2,
//   SUM($basicselect AND YEAR(tarikh_permohonan) = YEAR(DATE_ADD(NOW(), INTERVAL -2 MONTH)) AND MONTH(tarikh_permohonan) = MONTH(DATE_ADD(NOW(), INTERVAL -2 MONTH))) as m3,
//   SUM($basicselect AND YEAR(tarikh_permohonan) = YEAR(DATE_ADD(NOW(), INTERVAL -3 MONTH)) AND MONTH(tarikh_permohonan) = MONTH(DATE_ADD(NOW(), INTERVAL -3 MONTH))) as m4,
//   SUM($basicselect AND YEAR(tarikh_permohonan) = YEAR(DATE_ADD(NOW(), INTERVAL -4 MONTH)) AND MONTH(tarikh_permohonan) = MONTH(DATE_ADD(NOW(), INTERVAL -4 MONTH))) as m5,
//   SUM($basicselect AND YEAR(tarikh_permohonan) = YEAR(DATE_ADD(NOW(), INTERVAL -5 MONTH)) AND MONTH(tarikh_permohonan) = MONTH(DATE_ADD(NOW(), INTERVAL -5 MONTH))) as m6,
//   SUM($basicselect AND YEAR(tarikh_permohonan) = YEAR(DATE_ADD(NOW(), INTERVAL -6 MONTH)) AND MONTH(tarikh_permohonan) = MONTH(DATE_ADD(NOW(), INTERVAL -6 MONTH))) as m7,
//   SUM($basicselect AND YEAR(tarikh_permohonan) = YEAR(DATE_ADD(NOW(), INTERVAL -7 MONTH)) AND MONTH(tarikh_permohonan) = MONTH(DATE_ADD(NOW(), INTERVAL -7 MONTH))) as m8,
//   SUM($basicselect AND YEAR(tarikh_permohonan) = YEAR(DATE_ADD(NOW(), INTERVAL -8 MONTH)) AND MONTH(tarikh_permohonan) = MONTH(DATE_ADD(NOW(), INTERVAL -8 MONTH))) as m9,
//   SUM($basicselect AND YEAR(tarikh_permohonan) = YEAR(DATE_ADD(NOW(), INTERVAL -9 MONTH)) AND MONTH(tarikh_permohonan) = MONTH(DATE_ADD(NOW(), INTERVAL -9 MONTH))) as m10,
//   SUM($basicselect AND YEAR(tarikh_permohonan) = YEAR(DATE_ADD(NOW(), INTERVAL -10 MONTH)) AND MONTH(tarikh_permohonan) = MONTH(DATE_ADD(NOW(), INTERVAL -10 MONTH))) as m11
//   FROM a_applicant_permohonan ";
//
//   $result = $conn->query($select);
//   $arr = array();
//   $row = $result->fetch_assoc();
//
//   $m1 = $row["m1"];
//   $m2 = $row["m2"];
//   $m3 = $row["m3"];
//   $m4 = $row["m4"];
//   $m5 = $row["m5"];
//   $m6 = $row["m6"];
//   $m7 = $row["m7"];
//   $m8 = $row["m8"];
//   $m9 = $row["m9"];
//   $m10 = $row["m10"];
//   $m11 = $row["m11"];
//
//   $stringg = "[{x:1 , y:$m11 },{x:2 , y:$m10 },{x:3 , y:$m9 },{x:4 , y:$m8 },{x:5 , y:$m7 },{x:6 , y:$m6 },{x:7 , y:$m5 },{x:8 , y:$m4 },{x:9 , y:$m3 },{x:10 , y:$m2 },{x:11 , y:$m1 }]";
//
//   return $stringg;
// }
//
// $graft = graft();
// $dash = dashboard();
// $pending = getCard("Belum Diproses",$dash[0]["pending"],$dash[0]["total"],"danger");
// $prosesed = getCard("Sudah Diproses",$dash[0]["proses"],$dash[0]["total"],"success");
//
// $numbercard[0] = $pending;
// $numbercard[1] = $prosesed;
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

  <?php // mediaViewer(); ?>
  <?php // dashboardheader(); ?>
  <?php dashboardMainDiv(); ?>
  <?php dashboardViewPemohon(); ?>

  <script type="text/javascript">

  $("#searchIC").on("keydown", function(e) {
      if (e.keyCode === 13) {
        e.preventDefault();
      $("#searchbtn").click();
    }
  });

  var statp1 = true;
  var statp2 = true;
  var statp3 = true;
  var statp4 = true;
  var statp5 = true;
  var statp6 = true;
  var statp7 = true;
  var AAP = null;

  $("#tab2").removeClass("active");
  $("#tab3").removeClass("active");
  $("#tab4").removeClass("active");
  $("#tab5").removeClass("active");
  $("#tab6").removeClass("active");
  $("#tab7").removeClass("active");

  $(function () {
    $('[data-toggle="tooltip"]').tooltip()
  });

  $("[id='searchbtn']").click(function(e){
    getPermohonanStatus();
  });

  $("#openBorang").click(function(e){
    e.preventDefault();
    var searchIC = $("#searchIC").val();
    console.log(searchIC);
    getPermohonanFormByIC(searchIC);
  });

  $("#closeresult").click(function(e){
    $("#searchresultstatus").hide();
    $('.page-container').stop(true, true).animate({
      scrollTop: 176
    });
  });

  function getPermohonanStatus() {
    var searchIC = $("#searchIC").val();
    var fd = new FormData();
    fd.append("func","getPermohonanFormStatus");
    fd.append("icno",searchIC);
    $.ajax({
      type: 'POST',
      url: "db",
      data: fd,
      dataType: "json",
      cache: false,
      contentType: false,
      processData: false,
      success: function(data) {
        var count = Object.keys(data["P"]).length;
        if(count != 0){
          $("#searchresultstatus").show();
          $("#sr-name").html(data["P"][0]["pt2_nama_pemohon"]);
          $("#sr-icno").html(data["P"][0]["pt2_no_kp_pemohon"]);
          $("#sr-address").html(data["P"][0]["fulladdress"]);
          $("#sr-university").html(data["P"][0]["university"]);
          $("#sr-phone").html(data["P"][0]["pt2_no_hp_pemohon"]);
          $("#sr-email").html(data["P"][0]["pt2_emel_pemohon"]);

          changeStat("permohonanDihantar",data["P"][0]["status_permohonan"],data["P"][0]["tarikh_permohonan"]);
          changeStat("Kaunter",data["P"][0]["kaunter_application_stat"],data["P"][0]["kaunter_date"]);
          changeStat("BorangPengesahan",data["P"][0]["kaunter_document_stat"],data["P"][0]["kaunter_date"]);
          changeStat("Penyedia",data["P"][0]["penyedia_stat"],data["P"][0]["penyedia_date"]);
          changeStat("permohonanDisemak",data["P"][0]["penyemak_stat"],data["P"][0]["penyemak_date"]);
          changeStat("permohonanDilulus",data["P"][0]["pelulus_stat"],data["P"][0]["pelulus_date"]);
          changeStat("PembayaranHPIPT",data["P"][0]["pembayaran_hpipt_stat"],data["P"][0]["pembayaran_hpipt_date"]);
          changeStat("PembayaranSD",data["P"][0]["pembayaran_sd_stat"],data["P"][0]["pembayaran_sd_date"]);
          // changeStat("permohonanDilulus",data["P"][0]["status_permohonan"],data["P"][0]["tarikh_permohonan"]);
          // changeStat("Pembayaran",data["P"][0]["status_permohonan"],data["P"][0]["tarikh_permohonan"]);

          AAP = data["P"][0]["enc_id"];
          SuccessNoti("Berjaya","Data <b>"+data["P"][0]["pt2_nama_pemohon"]+"</b> ditemui");
          $("#searchresultstatus").show();
          $('.page-container').stop(true, true).delay(100).animate({
            scrollTop: $("#searchresultstatus").offset().top - 186
          });
        } else {
          AAP = null;
          $("#searchresultstatus").hide();
          saAlert3("Harap Maaf","Tiada Rekod Permohonan Dijumpai dalam Pengkalan data","warning");
        }
      },
      error: function(data) {
      }
    });
  }

  function changeStat(id,data,date){
    var icon = "fa fa-"+data["rs_icon"];
    var bg = "icon-thumbnail bg-"+data["rs_color"]+" pull-left text-white";
    $("[id='"+id+"'][type='icon-color']").removeClass();
    $("[id='"+id+"'][type='icon-color']").attr("class",bg);
    $("[id='"+id+"'][type='status']").html(data["rs_name"]);
    $("[id='"+id+"'][type='icon']").attr("class",icon);
    $("[id='"+id+"'][type='date']").html(date);
  }

  // set up our data series with 50 random data points

  var seriesData = <?php echo $graft; ?>

  var graph = new Rickshaw.Graph( {
  	element: document.getElementById("chart"),
  	width: 245,
  	height: 150,
  	renderer: 'line',
    interpolation: 'basis',
  	series: [
  		{
  			color: "#c05020",
  			data: seriesData,
  			name: 'Permohonan'
  		}
  	]
  } );

  // linear: straight lines between points
  // step-after: square steps from point to point
  // cardinal: smooth curves via cardinal splines (default)
  // basis: smooth curves via B-splines

  graph.render();

  var hoverDetail = new Rickshaw.Graph.HoverDetail( {
  	graph: graph,
  	formatter: function(series, x, y) {
      var invert = x;
      invert = (invert * -1)+11;
      var monthnew = moment().subtract(invert, 'months');
      var df = monthnew.format("MM/YYYY");
      // var date = '<span class="date">' + new Date(x * 1000).toUTCString() + '</span>';
  		var date = '<span class="date">' + df + '</span>';
  		var swatch = '<span class="detail_swatch" style="background-color: ' + series.color + '"></span>';
  		var content = swatch + series.name + ": " + parseInt(y) + '<br>' + df;
  		return content;
  	}
  });

</script>
<script type="text/javascript" src="assets/js/read.js" />
