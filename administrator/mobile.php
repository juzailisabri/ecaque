<?php
include("../formfunction.php");

if(!isset($_SESSION['USERNAME']) && empty($_SESSION['USERNAME'])) {
   header("Location: login");
} else {
  if(!$_SESSION["BEUSER"]){
    header("Location: login");
  }
}

function getroleuser(){
  global $conn;

  $id = $_SESSION["ID"];

  $select = "SELECT * FROM u_user_role LEFT JOIN ref_role ON rr_id = uur_rr_id WHERE uur_uu_id = '$id'";
  $result = $conn->query($select);

  while ($row = $result->fetch_assoc()) {
    ?>
    <a class="dropdown-item" href="#" id="changeRole" rrid="<?php echo $row["rr_id"]; ?>"><i class="fa fa-exchange m-r-10"></i> <?php echo $row["rr_name"]; ?></a>
    <?php
  }
}
?>
<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
    <meta charset="utf-8" />
    <title>Sistem Hadiah Pengajian IPT</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, shrink-to-fit=no" />
    <link rel="apple-touch-icon" href="pages/ico/60.png">
    <link rel="apple-touch-icon" sizes="76x76" href="pages/ico/76.png">
    <link rel="apple-touch-icon" sizes="120x120" href="pages/ico/120.png">
    <link rel="apple-touch-icon" sizes="152x152" href="pages/ico/152.png">
    <link rel="icon" type="image/x-icon" href="favicon.ico" />
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-touch-fullscreen" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta content="" name="description" />
    <meta content="" name="author" />
    <link href="assets/plugins/sweetalert/sweetalert.css" rel="stylesheet" type="text/css">
    <link href="assets/plugins/pace/pace-theme-flash.css" rel="stylesheet" type="text/css" />
  	<link href="assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
  	<link href="assets/plugins/font-awesome/css/font-awesome.css" rel="stylesheet" type="text/css" />
  	<link href="assets/plugins/jquery-scrollbar/jquery.scrollbar.css" rel="stylesheet" type="text/css" media="screen" />
    <link href="assets/plugins/select2/css/select2.css" rel="stylesheet" type="text/css" media="screen" />
  	<link href="assets/plugins/formvalidation/css/formValidation.css" rel="stylesheet" type="text/css" media="screen" />
  	<link href="assets/plugins/switchery/css/switchery.min.css" rel="stylesheet" type="text/css" media="screen" />
    <link href="assets/plugins/bootstrap-datepicker/css/datepicker3.css" rel="stylesheet" type="text/css" media="screen">
    <link type="text/css" rel="stylesheet" href="assets/plugins/rickshaw/rickshaw.min.css"></link>
    <link href="assets/plugins/jquery-datatable/media/css/dataTables.bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/plugins/jquery-datatable/extensions/FixedColumns/css/dataTables.fixedColumns.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/plugins/jquery-datatable/extensions/button/css/buttons.dataTables.css" rel="stylesheet">
    <link href="assets/plugins/jquery-datatable/extensions/Responsive/css/dataTables.responsive.css" rel="stylesheet">
    <link href="assets/plugins/datatables-responsive/css/datatables.responsive.css" rel="stylesheet" type="text/css" media="screen" />

    <link href="assets/css/animate.css" rel="stylesheet" type="text/css">
    <link media="screen" type="text/css" rel="stylesheet" href="assets/plugins/switchery/css/switchery.min.css">
    <link href="pages/css/pages-icons.css" rel="stylesheet" type="text/css">
    <link class="main-stylesheet" href="pages/css/pages.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/viewer.css" rel="stylesheet" type="text/css">
  </head>
  <body class="fixed-header horizontal-menu horizontal-app-menu ">
    <!-- START HEADER -->
    <div class="header">
      <div class="container">
        <div class="header-inner header-md-height ">
          <a href="#" class="btn-link toggle-sidebar d-lg-none pg pg-menu" data-toggle="horizontal-menu">
          </a>
          <div class="">
            <!-- START NOTIFICATION LIST -->
            <ul class="d-lg-inline-block d-none notification-list no-margin b-grey b-l b-r no-style p-l-0 p-r-20">

              <li class="p-r-10 inline">
                <a href="#" class="header-icon pg pg-link"></a>
              </li>
              <li class="p-r-10 inline">
                <a href="#" class="header-icon pg pg-thumbs"></a>
              </li>
            </ul>
            <!-- END NOTIFICATIONS LIST -->
          </div>
          <div class="d-flex align-items-center">
            <!-- START User Info-->
            <div class="pull-left p-r-10 fs-14 font-heading d-lg-inline-block">
              <span id="username" class="semi-bold"><?php echo $_SESSION['FULLNAME'] ?></span>
            </div>
            <div class="dropdown pull-right sm-m-r-5">
              <button class="profile-dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="thumbnail-wrapper d32 circular inline">
                  <img src="../assets/img/profiles/avatar.jpg" alt="" data-src="../assets/img/profiles/avatar.jpg" data-src-retina="../assets/img/profiles/avatar_small2x.jpg" width="32" height="32">
                  </span>
              </button>
              <div class="dropdown-menu dropdown-menu-right profile-dropdown" role="menu">
                <a class="dropdown-item syslink" href="page/profile-setting"><i class="pg-settings_small"></i> Profil</a>
                <hr class="p0 m0">
                <?php
                getroleuser();
                ?>
                <!-- <a href="#" class="dropdown-item"><i class="pg-signals"></i> Help</a> -->
                <a href="#" id="logoutBtn" class="clearfix bg-master-lighter dropdown-item">
                  <span class="pull-left" >Logout</span>
                  <span class="pull-right"><i class="pg-power"></i></span>
                </a>
              </div>
            </div>
            <!-- END User Info-->
          </div>
        </div>
        <div class="header-inner justify-content-start header-lg-height title-bar">
          <div class="brand inline align-self-end">
            <img src="../assets/img/Jata_selangor.png" alt="logo" data-src="../assets/img/Jata_selangor.png" data-src-retina="../assets/img/Jata_selangor.png" height="50">
            <img src="../assets/img/logo2_white_2x.png" alt="logo" data-src="../assets/img/logo2_white.png" data-src-retina="../assets/img/logo2_white_2x.png" height="50">
          </div>
          <h2 class="page-title align-self-center hidden-xs p-t-10">
            <!-- Sistem Hadiah Pengajian IPT -->
            <?php echo $_SESSION['ROLETITLE']; ?>
          </h2>
        </div>
        <div class="menu-bar header-sm-height" data-pages-init='horizontal-menu' data-hide-extra-li="0">
          <a href="#" class="btn-link toggle-sidebar d-lg-none pg pg-close" data-toggle="horizontal-menu">
          </a>
          <ul>
            <?php
            if ($_SESSION["ROLE"] == 1) {
            ?>
            <li class="active">
              <a href="page/kaunter/dashboard" class="syslink" id="mainpage" href="#">Papan Pemuka</a>
            </li>
            <li class="active">
              <a href="page/kaunter/application" class="syslink" id="profileSetting">Carian Permohonan</a>
            </li>
            <li class="active">
              <a href="page/kaunter/outbox" class="syslink" id="profileSetting">Outbox</a>
            </li>
            <li class="active">
              <a href="page/general/resetpermohonan" class="syslink" id="Outbox">Reset Permohonan</a>
            </li>
            <li class="active">
              <a href="page/profile-setting" class="syslink" id="profileSetting">Kemaskini Profil</a>
            </li>
            <?php
            }
            if ($_SESSION["ROLE"] == 2) {
            ?>
            <li class="active">
              <a href="page/penyedia1/dashboard" class="syslink" id="mainpage" href="#">Papan Pemuka</a>
            </li>
            <li class="active">
              <a href="page/penyedia1/inbox" class="syslink" id="inbox">Inbox</a>
            </li>
            <li class="active">
              <a href="page/penyedia1/outbox" class="syslink" id="Outbox">Outbox</a>
            </li>
            <li class="active">
              <a href="page/general/resetpermohonan" class="syslink" id="Outbox">Reset Permohonan</a>
            </li>
            <li class="active">
              <a href="page/profile-setting" class="syslink" id="profileSetting">Kemaskini Profil</a>
            </li>
            <?php
            }
            if ($_SESSION["ROLE"] == 3) {
            ?>
            <li class="active">
              <a href="page/penyedia2/dashboard" class="syslink" id="mainpage" href="#">Papan Pemuka</a>
            </li>
            <li class="active">
              <a href="page/penyedia2/inbox" class="syslink" id="inbox">Inbox</a>
            </li>
            <li class="active">
              <a href="page/penyedia2/outbox" class="syslink" id="Outbox">Outbox</a>
            </li>
            <li class="active">
              <a href="page/general/resetpermohonan" class="syslink" id="Outbox">Reset Permohonan</a>
            </li>
            <li class="active">
              <a href="page/profile-setting" class="syslink" id="profileSetting">Kemaskini Profil</a>
            </li>
            <?php
            }

            if ($_SESSION["ROLE"] == 4) {
            ?>
            <li class="active">
              <a href="page/penyedia3/dashboard" class="syslink" id="mainpage" href="#">Papan Pemuka</a>
            </li>
            <li class="active">
              <a href="page/penyedia3/inbox" class="syslink" id="inbox">Inbox</a>
            </li>
            <li class="active">
              <a href="page/penyedia3/outbox" class="syslink" id="Outbox">Outbox</a>
            </li>
            <li class="active">
              <a href="page/general/resetpermohonan" class="syslink" id="Outbox">Reset Permohonan</a>
            </li>
            <li class="active">
              <a href="page/profile-setting" class="syslink" id="profileSetting">Kemaskini Profil</a>
            </li>
            <?php
            }

            if ($_SESSION["ROLE"] == 5) {
            ?>
            <li class="active">
              <a href="page/penyemak/dashboard" class="syslink" id="mainpage" href="#">Papan Pemuka</a>
            </li>
            <li class="active">
              <a href="page/penyemak/inbox" class="syslink" id="inbox">Inbox</a>
            </li>
            <li class="active">
              <a href="page/penyemak/outbox" class="syslink" id="Outbox">Outbox</a>
            </li>
            <li class="active">
              <a href="page/general/resetpermohonan" class="syslink" id="Outbox">Reset Permohonan</a>
            </li>
            <li class="active">
              <a href="page/profile-setting" class="syslink" id="profileSetting">Kemaskini Profil</a>
            </li>
            <?php
            }

            if ($_SESSION["ROLE"] == 6) {
            ?>
            <li class="active">
              <a href="page/pelulus/dashboard" class="syslink" id="mainpage" href="#">Papan Pemuka</a>
            </li>
            <li class="active">
              <a href="page/pelulus/inbox" class="syslink" id="inbox">Inbox</a>
            </li>
            <li class="active">
              <a href="page/pelulus/outbox" class="syslink" id="Outbox">Outbox</a>
            </li>
            <li class="active">
              <a href="page/general/resetpermohonan" class="syslink" id="Outbox">Reset Permohonan</a>
            </li>
            <li class="active">
              <a href="page/profile-setting" class="syslink" id="profileSetting">Kemaskini Profil</a>
            </li>
            <?php
            }

            if ($_SESSION["ROLE"] == 7) {
            ?>
            <li class="active">
              <a href="page/pembayaran/dashboard" class="syslink" id="mainpage" href="#">Papan Pemuka</a>
            </li>
            <li class="active">
              <a href="javascript:;" class="syslink2">
                <span class="title ">HPIPT</span>
                <span class="arrow"></span>
              </a>
              <ul class="">
                <li class="">
                  <a class="syslink" href="page/pembayaran/inbox">Inbox</a>
                </li>
                <li class="">
                  <a class="syslink" href="page/pembayaran/outbox">Penyata Bayaran</a>
                </li>
              </ul>
            </li>
            <li class="active">
              <a href="javascript:;" class="syslink2">
                <span class="title ">Sara Diri</span>
                <span class="arrow"></span>
              </a>
              <ul class="">
                <li class="">
                  <a class="syslink" href="page/pembayaran/inbox-sd">Inbox</a>
                </li>
                <li class="">
                  <a class="syslink" href="page/pembayaran/outbox-sd">Penyata Bayaran</a>
                </li>
              </ul>
            </li>
            <li class="active">
              <a href="page/profile-setting" class="syslink" id="profileSetting">Kemaskini Profil</a>
            </li>
            <?php
            }

            if ($_SESSION["ROLE"] == 8) {
            ?>
            <li class="active">
              <a href="page/admin/dashboard" class="syslink" id="mainpage" href="#">Papan Pemuka</a>
            </li>
            <li class="active">
              <a href="javascript:;" class="syslink2">
                <span class="title ">Pengguna</span>
                <span class="arrow"></span>
              </a>
              <ul class="">
                <li class="">
                  <a class="syslink" href="page/admin/pengguna-tetapan">Penetapan</a>
                </li>
                <!-- <li class="">
                  <a class="syslink" href="page/admin/kpi-report">Penunjuk KPI</a>
                </li>
                <li class="">
                  <a class="syslink" href="page/admin/kpi-report2">Penunjuk KPI 2</a>
                </li> -->

              </ul>
            </li>
            <li class="active">
              <a href="javascript:;" class="syslink2">
                <span class="title ">Laporan Statistik</span>
                <span class="arrow"></span>
              </a>
              <ul class="">
                <li class="">
                  <a class="syslink" href="page/admin/s-bangsa"> Statistik Mengikut Bangsa</a>
                </li>
                <li class="">
                  <a class="syslink" href="page/admin/s-jantina">Statistik Mengikut Jantina</a>
                </li>
                <li class="">
                  <a class="syslink" href="page/admin/s-dun">Statistik Mengikut Dun</a>
                </li>
                <li class="">
                  <a class="syslink" href="page/admin/s-parlimen">Statistik Mengikut Parlimen</a>
                </li>
                <li class="">
                  <a class="syslink" href="page/admin/s-jenisipt">Statistik Mengikut Jenis IPT</a>
                </li>
                <li class="">
                  <a class="syslink" href="page/admin/s-ipt">Statistik Mengikut IPT</a>
                </li>
                <li class="">
                  <a class="syslink" href="page/admin/s-jenispengajian">Statistik Mengikut Peringkat Pengajian</a>
                </li>
              </ul>
            </li>
            <li class="active">
              <a href="javascript:;" class="syslink2">
                <span class="title ">Laporan Senarai</span>
                <span class="arrow"></span>
              </a>
              <ul class="">
                <li class="">
                  <a class="syslink" href="page/admin/l-pemohon">Senarai Pemohon</a>
                </li>
                <li class="">
                  <a class="syslink" href="page/admin/kpi-report3">KPI Pegawai</a>
                </li>
              </ul>
            </li>
            <li class="active">
              <a href="javascript:;" class="syslink2">
                <span class="title ">Konfigurasi Sistem</span>
                <span class="arrow"></span>
              </a>
              <ul class="">
                <li class="">
                  <a class="syslink" href="page/admin/c-sysconfig">Tetapan Permohonan</a>
                </li>
              </ul>
            </li>
            <li class="active">
              <a href="page/general/resetpermohonan" class="syslink" id="Outbox">Reset Permohonan</a>
            </li>
            <li class="active">
              <a href="page/admin/news" class="syslink" id="Outbox">Berita</a>
            </li>
            <li class="active">
              <a href="page/profile-setting" class="syslink" id="profileSetting">Kemaskini Profil</a>
            </li>
            <?php
            }
            ?>
          </ul>
          <a href="#" class="search-link d-flex justify-content-between align-items-center d-lg-none" data-toggle="search">Tap here to search <i class="pg-search float-right"></i></a>
        </div>
      </div>
    </div>
    <div class="page-container">
      <div class="modal stick-up" style="z-index:11000"  id="loadingModal" tabindex="-1" role="dialog" aria-labelledby="loadingModal" aria-hidden="true">
          <div class="modal-dialog">
              <div class="modal-content">
                  <div class="modal-header clearfix text-center p-0">
                      <!-- <h5>Sila Tunggu Sebentar <span class="semi-bold"></span></h5> -->
                      <p class="p-t-15 bold text-center"> <img src="assets/img/loading3.gif" height="60px" alt=""> Loading. Sila Tunggu Sebentar</p>
                  </div>

              </div>
          </div>
      </div>
      <!-- START PAGE CONTENT WRAPPER -->
      <div class="page-content-wrapper ">
        <div class="jumbotron m-b-0" id="jumbotron" style="z-index:2">
          <div class=" container p-l-0 p-r-0 container-fixed-lg sm-p-l-0 sm-p-r-0">
            <div class="inner">
              <!-- START BREADCRUMB -->
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">HPIPT</a></li>
                <li id="breadcrumb" class="breadcrumb-item active">Papan Pemuka</li>
              </ol>
              <!-- END BREADCRUMB -->
            </div>
          </div>
        </div>
        <!-- START PAGE CONTENT -->
        <div class="content faster" id="content">
          <!-- START JUMBOTRON -->

          <!-- END JUMBOTRON -->
          <!-- START CONTAINER FLUID -->

          <!-- END CONTAINER FLUID -->
        </div>
        <!-- END PAGE CONTENT -->
        <!-- START COPYRIGHT -->
        <!-- START CONTAINER FLUID -->
        <!-- START CONTAINER FLUID -->
        <div class="container container-fixed-lg footer">
          <div class="copyright sm-text-center">
            <p class="small no-margin pull-left sm-pull-reset">
              <span class="hint-text">Copyright &copy; 2018 </span>
              <span class="font-montserrat">Kerajaan Negeri Selangor</span>.
              <span class="hint-text">All rights reserved. </span>
              <span class="sm-block"><a href="#" class="m-l-10 m-r-10">Terms of use</a> <span class="muted">|</span> <a href="#" class="m-l-10">Privacy Policy</a></span>
            </p>
            <p class="small no-margin pull-right sm-pull-reset">
              Powered by Isente Sdn. Bhd.</span>
            </p>
            <div class="clearfix"></div>
          </div>
        </div>
        <!-- END COPYRIGHT -->
      </div>
      <!-- END PAGE CONTENT WRAPPER -->
    </div>
    <!-- END PAGE CONTAINER -->
    <!--START QUICKVIEW -->
      <!-- Nav tabs -->
    </div>
    <!-- END QUICKVIEW-->
    <!-- START OVERLAY -->

    <!-- END OVERLAY -->
    <!-- BEGIN VENDOR JS -->
        <!-- BEGIN VENDOR JS -->
    <script src="assets/plugins/pace/pace.min.js" type="text/javascript"></script>
    <script src="assets/plugins/jquery/jquery-3.2.1.min.js" type="text/javascript"></script>
    <script src="assets/plugins/modernizr.custom.js" type="text/javascript"></script>
    <script src="assets/plugins/jquery-ui/jquery-ui.min.js" type="text/javascript"></script>
    <script src="assets/plugins/popper/umd/popper.min.js" type="text/javascript"></script>
    <script src="assets/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="assets/plugins/jquery/jquery-easy.js" type="text/javascript"></script>
    <script src="assets/plugins/jquery-unveil/jquery.unveil.min.js" type="text/javascript"></script>
    <script src="assets/plugins/jquery-ios-list/jquery.ioslist.min.js" type="text/javascript"></script>
    <script src="assets/plugins/jquery-actual/jquery.actual.min.js"></script>
    <script src="assets/plugins/jquery-scrollbar/jquery.scrollbar.min.js"></script>
    <!-- END VENDOR JS -->
    <!-- BEGIN CORE TEMPLATE JS -->

    <script src="assets/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
    <script src="assets/plugins/formvalidation/js/formValidation.min.js"></script>
    <script src="assets/plugins/formvalidation/js/framework/bootstrap.min.js"></script>

    <script src="assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js" type="text/javascript"></script>
    <script src="assets/plugins/summernote/js/summernote.min.js" type="text/javascript"></script>
    <script src="assets/plugins/moment/moment.min.js"></script>
    <script src="assets/plugins/bootstrap-daterangepicker/daterangepicker.js"></script>
    <script src="assets/plugins/bootstrap-timepicker/bootstrap-timepicker.min.js"></script>

    <script src="assets/plugins/sweetalert/sweetalert.min.js"></script>
    <script src="assets/plugins/select2/js/select2.full.min.js"></script>
    <script type="text/javascript" src="assets/plugins/classie/classie.js"></script>
    <script src="assets/plugins/jquery-datatable/media/js/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="assets/plugins/jquery-datatable/extensions/TableTools/js/dataTables.tableTools.min.js" type="text/javascript"></script>
    <script src="assets/plugins/jquery-datatable/media/js/dataTables.bootstrap.js" type="text/javascript"></script>
    <script src="assets/plugins/jquery-datatable/extensions/Bootstrap/jquery-datatable-bootstrap.js" type="text/javascript"></script>

    <script src="assets/plugins/jquery-datatable/extensions/button/js/dataTables.buttons.js"></script>
    <script src="assets/plugins/jquery-datatable/extensions/button/js/buttons.html5.js"></script>
    <script src="assets/plugins/jquery-datatable/extensions/button/js/buttons.print.js"></script>

    <script src="assets/plugins/jquery-datatable/jszip.min.js"></script>
    <script src="assets/plugins/jquery-datatable/pdfmake.min.js"></script>
    <script src="assets/plugins/jquery-datatable/vfs_fonts.js"></script>


    <script type="text/javascript" src="assets/plugins/datatables-responsive/js/datatables.responsive.js"></script>
    <script type="text/javascript" src="assets/plugins/datatables-responsive/js/lodash.min.js"></script>
    <script type="text/javascript" src="assets/plugins/switchery/js/switchery.min.js"></script>
    <script src="assets/js/jquery.chained.js"></script>
    <script src="assets/js/jquery.redirect.js"></script>
    <!-- <script src="assets/js/jQueryRotate.js"></script> -->
    <script src="pages/js/pages.min.js" type="text/javascript"></script>

    <script src="assets/plugins/d3/d3.min.js"></script>
    <script src="assets/plugins/rickshaw/rickshaw.min.js"></script>
    <!-- END CORE TEMPLATE JS -->
    <!-- BEGIN PAGE LEVEL JS -->
    <script src="assets/js/scripts.js" type="text/javascript"></script>
    <script src="assets/js/viewer.js" type="text/javascript"></script>
    <!-- END PAGE LEVEL JS -->

    <script type="text/javascript">
        $(document).ready(function () {
            // $.toast({
            //     heading: 'Welcome to Elite admin'
            //     , text: 'Use the predefined ones, or specify a custom position object.'
            //     , position: 'top-right'
            //     , loaderBg: '#ff6849'
            //     , icon: 'info'
            //     , hideAfter: 3500
            //     , stack: 6
            // })
        });

        $("body").on("click","[id='closeModal']",function(e){
          $.magnificPopup.close();
        });

        $.fn.extend({
          animateCss: function(animationName, callback) {
            var animationEnd = (function(el) {
              var animations = {
                animation: 'animationend',
                OAnimation: 'oAnimationEnd',
                MozAnimation: 'mozAnimationEnd',
                WebkitAnimation: 'webkitAnimationEnd',
              };

              for (var t in animations) {
                if (el.style[t] !== undefined) {
                  return animations[t];
                }
              }
            })(document.createElement('div'));

            this.addClass('animated ' + animationName).one(animationEnd, function() {
              $(this).removeClass('animated ' + animationName);

              if (typeof callback === 'function') callback();
            });

            return this;
          },
        });

        $(document).ready(function(e){
          $("body").on("click",".syslink",function(e){
            loadingMain();
            $(".syslink").removeClass("text-success");
            $(".syslink").removeClass("bold");
            $(".syslink2").removeClass("text-success");
            $(".syslink2").removeClass("bold");

            $(this).addClass("text-success");
            $(this).addClass("bold");
            $(this).parents("li").parents("ul").parents("li").find("a:eq(0)").addClass("text-success");
            $(this).parents("li").parents("ul").parents("li").find("a:eq(0)").addClass("bold");
            e.preventDefault();
            var link = $(this).attr("href");
            $('#content').animateCss('slideOutUp',function(e){
              $("#content").empty();
              var fd = new FormData();
              $.ajax({
                  type: 'POST',
                  url: link,
                  data: fd,
                  cache: false,
                  contentType: false,
                  processData: false,
                  success: function(data) {
                    loadingMainFinish();
                    $("#content").html(data);
                    $('#content').animateCss('slideInDown');
                    // $('#jumbotron').animateCss('slideInDown');
                    $('.menu-bar').removeClass('open')

                    $('.horizontal-menu-backdrop').hide();
                    // $("#content").show();
                  },
                  error: function(data) {
                  }
              });
            });
            var title = $(this).text();
            $("#breadcrumb").html(title);
          });
        });


        function saAlert(msg){ swal(msg); }
        function saAlert2(title,msg){ swal(title,msg); }
        function saAlert3(title,msg,status){ swal(title,msg,status); }
        function saConfirm(title,text,type,confirmbtntext,runfunction,confirmtext,confirmdesc,canceltext,canceldesc){
          swal({
              title: title,
              text: text,
              type: type,
              showCancelButton: true,
              confirmButtonColor: "#DD6B55",
              confirmButtonText: confirmbtntext,
              cancelButtonText: "Cancel",
              closeOnConfirm: false,
              closeOnCancel: false
          }, function(isConfirm){
              if (isConfirm) {
                runfunction();
                swal(confirmtext, confirmdesc, "success");
              } else {
                swal(canceltext, canceldesc, "error");
              }
          });
        }

        function saConfirm2(title,text,type,confirmbtntext,runfunction,confirmtext,confirmdesc,canceltext,canceldesc){
          swal({
              title: title,
              text: text,
              type: type,
              showCancelButton: true,
              confirmButtonColor: "#DD6B55",
              confirmButtonText: confirmbtntext,
              cancelButtonText: "Cancel",
              closeOnConfirm: false,
              closeOnCancel: true
          }, function(isConfirm){
              if (isConfirm) {
                runfunction();
              } else {
                swal(canceltext, canceldesc, "error");
              }
          });
        }

        function saConfirm4(title,text,type,confirmbtntext,runfunction,confirmtext){
          swal({
              title: title,
              text: text,
              type: type,
              showCancelButton: true,
              confirmButtonColor: "#DD6B55",
              confirmButtonText: confirmbtntext,
              cancelButtonText: "Cancel",
              closeOnConfirm: false,
              closeOnCancel: true
          }, function(isConfirm){
              if (isConfirm) {
                saLoading();
                runfunction();
              }
          });
        }

        function saConfirm3(title,text,type){
          swal({
              title: title,
              text: text,
              closeOnConfirm: false,
              closeOnCancel: false,
              showCancelButton: false,
              showConfirmButton: false,
              imageUrl: "assets/img/loading3.gif",
              imageSize: '200x200'
          }, function(isConfirm){

          });
        }

        function saLoading(){
          saConfirm3("Memposes Data","Sila Tunggu Sebentar sementara \n pelayan memproses data. \n\n Terima Kasih","loading");
        }

        function loading(){
          // saConfirm3("Sila Tunggu Sebentar","Sementara sistem memproses data dari pengkalan data. Terima Kasih","success");
          $("#loadingModal").modal({backdrop: 'static', keyboard: false});
        }

        function loadingMain(){
          $("#loadingModal").modal({backdrop: 'static', keyboard: false});
        }

        function loadingMainFinish(){
          $("#loadingModal").modal('hide');
        }

        function finishload(){
          $("#loadingModal").modal('hide');
        }

        function SuccessNoti(title,message){
          $('body').pgNotification({
            style: 'flip',
            type: 'success',
            title: title,
            message: "<i class='fa fa-check m-r-5'></i> "+message,
            timeout: 2000
          }).show();
        }

        function failedNoti(title,message){
          $('body').pgNotification({
            style: 'flip',
            type: 'danger',
            title: title,
            message: message,
            timeout: 2000
          }).show();
        }

        // var MEMBER = null;
        //
        // function getMember(runfunction){
        //   var fd = new FormData();
        //   fd.append("func","getMember");
        //   $.ajax({
        //       type: 'POST',
        //       url: "db",
        //       data: fd,
        //       dataType: "json",
        //       cache: false,
        //       contentType: false,
        //       processData: false,
        //       success: function(data) {
        //         MEMBER = data[0];
        //         $("#Header-User").html(MEMBER["mm_name"]);
        //         runfunction();
        //       },
        //       error: function(data) {
        //         saAlert3("Error","Member Data Failed to Load","warning");
        //       }
        //   });
        // }

        $(document).ready(function(e){
          // getMember(NA);
          $("#mainpage").click();
        });

        function NA(){ }

        $("[id='logoutBtn']").click(function(e){
          var fd = new FormData();
          fd.append("func","logout");
          $.ajax({
              type: 'POST',
              url: "db",
              data: fd,
              dataType: "json",
              cache: false,
              contentType: false,
              processData: false,
              success: function(data) {
                window.location = "login";
              },
              error: function(data) {
                // saAlert3("Error","Session Log Out Error","warning");
              }
          });
        });

        function checksession(){
          var fd = new FormData();
          fd.append("func","logout");
          $.ajax({
              type: 'POST',
              url: "session",
              data: fd,
              dataType: "json",
              cache: false,
              contentType: false,
              processData: false,
              success: function(data) {
                if (data == false) {
                  window.location = "index";
                }
                // window.location = "login";
              },
              error: function(data) {
                // saAlert3("Error","Session Log Out Error","warning");
              }
          });
        }

        $("[id='changeRole']").click(function(e){
          var role = $(this).attr("rrid");
          var fd = new FormData();
          fd.append("func","changeRole");
          fd.append("rrid",role);
          $.ajax({
              type: 'POST',
              url: "db",
              data: fd,
              dataType: "json",
              cache: false,
              contentType: false,
              processData: false,
              success: function(data) {
                if (data == true) {
                  window.location = "index";
                }
                // window.location = "login";
              },
              error: function(data) {
                // saAlert3("Error","Session Log Out Error","warning");
              }
          });
        });

        setInterval(function(){ checksession(); }, 5000);

    </script>
  </body>
</html>
