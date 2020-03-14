<?php
session_start();

include "conn.php";

function getJantina(){
  global $conn;

  $select = "SELECT * FROM ref_jantina WHERE rjan_status = 1";
  $result = $conn->query($select);
  echo "<option value=''>-- Pilih Jantina --</option>";
  while ($row = $result->fetch_assoc())
  {
    $id=$row["rjan_id"];
    $name=$row["rjan_name"];
    echo "<option value='$id'>$name</option>";
  }
}

function getNegara(){
  global $conn;

  $select = "SELECT * FROM ref_negara WHERE rngra_status = 1 ORDER BY rngra_name";
  $result = $conn->query($select);
  echo "<option value=''>-- Pilih Negara --</option>";
  while ($row = $result->fetch_assoc())
  {
    $id=$row["rngra_id"];
    $name=$row["rngra_name"];
    echo "<option value='$id'>$name</option>";
  }
}

function getNegeri(){
  global $conn;

  $select = "SELECT * FROM ref_negeri WHERE rngri_status = 1";
  $result = $conn->query($select);
  echo "<option value=''>-- Pilih Negeri --</option>";
  while ($row = $result->fetch_assoc())
  {
    $id=$row["rngri_id"];
    $name=$row["rngri_name"];
    echo "<option value='$id'>$name</option>";
  }
}
function getKeturunan(){
  global $conn;

  $select = "SELECT * FROM ref_keturunan WHERE rktrn_status = 1";
  $result = $conn->query($select);
  echo "<option value=''>-- Pilih Bangsa --</option>";
  while ($row = $result->fetch_assoc())
  {
    $id=$row["rktrn_id"];
    $name=$row["rktrn_name"];
    echo "<option value='$id'>$name</option>";
  }
}

function dashboardheader(){
  ?>
  <div class="social-wrapper">
    <div class="social " data-pages="social">
      <div class="jumbotron bg-primary" style="height:300px" data-social="cover" data-pages="parallax" data-scroll-element=".page-container">
        <!-- <div class="cover-photo" style="background-image: url('../assets/slider/slider3.jpg'); transform: translateY(0px);"> </div> -->
        <div class=" container container-fixed-lg sm-p-l-0 sm-p-r-0">
          <div class="inner" style="transform: translateY(0px); opacity: 1;">
            <div class="pull-bottom bottom-left m-b-20 sm-p-l-15">
              <h5 class="text-white no-margin"><small><small><strong>Selamat Datang</strong></small></small><br><?php echo $_SESSION['FULLNAME'] ?></h5>
              <h1 class="text-white no-margin"><span class="semi-bold"></span></h1>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php
}

function dashboardMainDiv(){
  ?>
  <div class="container container-fixed-lg m-t-30" id="searchDiv">
    <div class="row m-b-30">
      <div class="col-lg-12">
        <div class="row md-m-b-10">
          <div class="col-sm-3">
            <div class="card no-border  no-margin widget-loader-circle todolist-widget pending-projects-widget" data-social="item">
              <div class="card-body p-0 m-0">
              </div>
            </div>
            <div class="card social-card share  full-width m-b-10 no-border" data-social="item">
              <div class="card-header ">
                <div class="card-title"><i class="fa fa-inbox m-r-5"></i>Permohonan Diterima  </div>
                <div class="clearfix"></div>
              </div>
              <div class="card-body d-flex flex-column">
                <div class="row">
                  <div class="col-lg-12 p-0 p-t-10">
                    <div id="chart"></div>
                    <rickshaw
                        rickshaw-options="options"
                        rickshaw-features="features"
                        rickshaw-series="series">
                    </rickshaw>
                  </div>
                </div>
                <div class="row p-t-10">
                  <div class="col-lg-12">
                    <small>Permohonan yang diterima mengikut bulan daripada <b>bulan ini hingga (6) enam bulan</b> sebelum.</small>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-3">
            <?php //summaryStatistic(); ?>
            <?php //getNews(); ?>
          </div>
          <div class="col-lg-6">
            <?php //dashboardSearch(); ?>
            <?php //dashboardSearchResult(); ?>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php
}

function dashboardViewPemohon(){
  ?>
  <div class="" id="searchResult" style="display:none">
    <div class="container">
      <div class="row p-r-30">
        <!-- <div class="col-md-5 b-r b-dashed b-grey sm-b-b"> -->
        <div class="col-md-6 text-left ">
          <div class="p-t-30 p-l-0 sm-padding-5 sm-m-t-15 m-t-20">
            <button id="back" type="button" class="btn btn-primary btn-lg" name="button"> <i class="fa fa-arrow-left m-r-10"></i> Kembali</button>
          </div>
        </div>
        <div class="col-md-6 text-right ">
          <div class="padding-30 sm-padding-5 sm-m-t-15 m-t-20">
            <!-- <i class="fa fa-inbox fa-4x hint-text"></i> -->
            <h2 class="bold m-b-0 p-b-0" id="head-name">Juzaili Bin Ahmad Sabri</h2>
            <h2 class="p-t-0 m-t-0" id="head-ic">820810-29-9988</h2>
            <p id="head-uni">University Name</p>
            <p class="small hint-text"> <i class="fa fa-envelope"></i> <span id="head-email" class="p-l-10">juzaili.sabri@gmail.com</span> <i class="m-l-20 fa fa-phone"></i><span id="head-phone" class="p-l-10">+6019 266 9420</span> </p>
          </div>
        </div>
      </div>
    </div>

    <div class="bg-white no-padding container-fixed-lg p-b-30 hidden-xs">
      <div class="container full-height">
        <div class="row">
          <div class="col-md-12">
            <div class="row">
              <?php include("../kaunter/form-template-view.php") ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php
}


 ?>
