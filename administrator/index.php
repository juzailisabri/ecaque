<?php
include("formfunction.php");


if(!isset($_SESSION['ID']) && empty($_SESSION['ID'])) {
   header("Location: ../loginAdmin");
} else {

}

$linkmenu = null;
if (isset($_GET["m"])) { $linkmenu = $_GET["m"]; }

?>
<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
    <meta charset="utf-8" />
    <title>eCaque | Admin Management</title>
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
    <div class="modal fade stick-up" style="z-index:11000" id="modalPacking" tabindex="-1" role="dialog" aria-labelledby="modalPacking" aria-hidden="true">
        <div class="modal-dialog ">
            <div class="modal-content-wrapper">
              <div class="modal-content p-b-n">
                  <div class="modal-header clearfix text-left">
                      <!-- <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        <i class="pg-close fs-14"></i>
                      </button> -->
                      <h4 class="fs-20">Delivery <span class="semi-bold">Tracking</span> |  eCaque</h4>
                      <p class="text-black  fs-14">Sila pilih servis kurier dan isikan nombor tracking.</p>
                  </div>
                  <div class="modal-body p-b-10">
                    <form class="m-t-25 m-b-20" id="packingForm">
                      <div class="row">
                        <div class="col-md-12">
                          <div class="form-group form-group-default input-group no-bordera input-group-attached col-xs-12">
                            <label class="control-label">Syarikat Courier</label>
                            <select id="courier" required name="courier" class="form-control" >
                              <?php refdeliveryCourier(); ?>
                            </select>
                            <!-- <input type="fullname" class="form-control" placeholder="johnsmith@abc.com"> -->
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-12">
                          <div class="form-group form-group-default input-group no-bordera input-group-attached col-xs-12">
                            <label class="control-label">Tracking No.</label>
                            <input id="trackingNo" required name="trackingNo" type="text" class="form-control" placeholder="">
                          </div>
                        </div>
                      </div>
                      <div class="row m-t-20">
                        <div class="col-md-12 text-right">
                          <a id="sendWhatsapp" type="button" target="_blank" href="#" class="btn btn-primary pull-left" name="button">Send WhatsApp <i class="fa fa-send m-l-5"></i></a>
                          <button data-dismiss="modal" aria-hidden="true" type="button" class="btn btn-dark" name="button"> <i class="fa fa-close"></i></button>
                          <button type="submit" class="btn btn-primary" name="button">Save <i class="fa fa-send m-l-5"></i></button>
                        </div>
                      </div>
                    </form>
                  </div>
              </div>
            </div>
            <!-- /.modal-content -->
        </div>
    </div>
    <div class="modal fade stick-up" style="z-index:11000" id="modalPayment" tabindex="-1" role="dialog" aria-labelledby="modalPayment" aria-hidden="false">
        <div class="modal-dialog ">
            <div class="modal-content-wrapper">
              <div class="modal-content p-b-n">
                  <div class="modal-header clearfix text-left">
                      <!-- <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        <i class="pg-close fs-14"></i>
                      </button> -->
                      <h4 class="fs-20">Payment <span class="semi-bold">Record</span> |  eCaque</h4>
                      <p class="text-black  fs-14">Sila pilih bank dan isikan nombor pengesahan dari bank.</p>
                  </div>
                  <div class="modal-body p-b-10">
                    <form class="m-t-25 m-b-20" id="paymentForm">
                      <div class="row">
                        <div class="col-md-12">
                          <div class="form-group form-group-default input-group no-bordera input-group-attached col-xs-12">
                            <label class="control-label">Bank</label>
                            <select id="bank" required name="bank" class="form-control" >
                              <?php getBank(); ?>
                            </select>
                            <!-- <input type="fullname" class="form-control" placeholder="johnsmith@abc.com"> -->
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-12">
                          <div class="form-group form-group-default input-group no-bordera input-group-attached col-xs-12">
                            <label class="control-label">Reference No.</label>
                            <input id="refNo" required name="refNo" type="text" class="form-control" placeholder="">
                          </div>
                        </div>
                        <!-- <div class="col-md-6">
                          <div class="form-group form-group-default input-group no-bordera input-group-attached col-xs-12">
                            <label class="control-label">Date Payment</label>
                            <input id="DatePayment" required name="DatePayment" type="text" class="form-control" placeholder="">
                          </div>
                        </div> -->
                      </div>
                      <div class="row m-t-20">
                        <div class="col-md-12 text-right">
                          <button data-dismiss="modal" aria-hidden="true" type="button" class="btn btn-dark" name="button"> <i class="fa fa-close"></i></button>
                          <button type="submit" class="btn btn-primary" name="button">Save <i class="fa fa-send m-l-5"></i></button>
                        </div>
                      </div>
                    </form>
                  </div>
              </div>
            </div>
            <!-- /.modal-content -->
        </div>
    </div>
    <div class="header bg-dark">
      <div class="container">
        <div class="header-inner header-md-height ">
          <a href="#" class="btn-link toggle-sidebar d-lg-none pg pg-menu" data-toggle="horizontal-menu">
          </a>
          <div class="">
            <!-- START NOTIFICATION LIST -->
            <ul class="d-lg-inline-block d-none notification-list no-margin b-grey b-l b-r no-style p-l-0 p-r-20">
              <li class="p-r-10 inline  ">
              </li>
            </ul>
          </div>
          <div class="d-flex align-items-center">
            <div class="pull-left p-r-10 fs-14 font-heading d-lg-inline-block">
              <span id="username" class="semi-bold"><?php echo $_SESSION["FULLNAME"] ?></span>
            </div>
            <div class="dropdown pull-right sm-m-r-5">
              <button class="profile-dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="thumbnail-wrapper d32 circular inline">
                  <img src="assets/img/profiles/avatar.jpg" alt="" data-src="assets/img/profiles/avatar.jpg" data-src-retina="assets/img/profiles/avatar.jpg" width="32" height="32">
                  </span>
              </button>
              <div class="dropdown-menu dropdown-menu-right profile-dropdown" role="menu">
                <a href="#" id="logoutBtn" class="clearfix bg-master-lighter dropdown-item">
                  <span class="pull-left" >Logout</span>
                  <span class="pull-right"><i class="pg-power"></i></span>
                </a>
              </div>
            </div>
          </div>
        </div>
        <div class="header-inner justify-content-start header-lg-height title-bar">
          <div class="brand inline align-self-end">
            <img src="../assets/images/Logo_2020_White.png" alt="logo" data-src="../assets/images/Logo_2020_White.png" data-src-retina="../assets/images/Logo_2020_White.png" height="50">
          </div>
          <h2 class="page-title align-self-center hidden-xs p-t-10">
            Admin Management
          </h2>
        </div>
        <div class="menu-bar header-sm-height" data-pages-init='horizontal-menu' data-hide-extra-li="0">
          <a href="#" class="btn-link toggle-sidebar d-lg-none pg pg-close" data-toggle="horizontal-menu">
          </a>
          <ul>
            <li class="active">
              <a href="page/admin/dashboard" class="syslink" id="mainpage" href="#">Papan Pemuka</a>
            </li>
            <!-- <li class="active">
              <a href="page/kaunter/application" class="syslink" id="profileSetting">Inbox</a>
            </li> -->
            <li class="active">
              <a href="page/admin/customer-order" class="syslink" id="customerOrder">Customer Order</a>
            </li>
            <li class="active">
              <a href="page/admin/stock-record" class="syslink" id="profileSetting">Stock Record</a>
            </li>
            <li class="active">
              <a href="javascript:;" class="syslink2">
                <span class="title ">Ejen Stokis</span>
                <span class="arrow"></span>
              </a>
              <ul class="">
                <li class="">
                  <a class="syslink" href="page/admin/pemohon-tetapan">Senarai Stokis</a>
                </li>
                <li class="">
                  <a class="syslink" href="page/admin/stockist-order">Order Stok</a>
                </li>
              </ul>
            </li>
          </ul>
          <a href="#" class="search-link d-flex justify-content-between align-items-center d-lg-none" data-toggle="search">Tap here to search <i class="pg-search float-right"></i></a>
        </div>
      </div>
    </div>
    <div class="page-container">

      <!-- START PAGE CONTENT WRAPPER -->
      <div class="page-content-wrapper ">

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
              <span class="hint-text">Copyright &copy; 2020 </span>
              <span class="font-montserrat">eCaque Enterprise</span>.
              <span class="hint-text">All rights reserved. </span>
              <span class="sm-block"><a href="#" class="m-l-10 m-r-10">Terms of use</a> <span class="muted">|</span> <a href="#" class="m-l-10">Privacy Policy</a></span>
            </p>
            <p class="small no-margin pull-right sm-pull-reset">
              Powered by Dabeliu Production</span>
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
    <!-- </div> -->
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
            if (typeof DASHBOARDINT !== 'undefined') { clearInterval(DASHBOARDINT); }
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
          var linkmenu = '<?php echo $linkmenu ?>';
          if (linkmenu == '') {
            $("#mainpage").click();
          } else {
            $("a[id='"+linkmenu+"']").click();
          }
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
                window.location = "../loginAdmin";
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

        function getUrlVars() {
            var vars = {};
            var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
                vars[key] = value;
            });
            return vars;
        }

        function getUrlParam(parameter, defaultvalue){
            var urlparameter = defaultvalue;
            if(window.location.href.indexOf(parameter) > -1){
                urlparameter = getUrlVars()[parameter];
                }
            return urlparameter;
        }

        setInterval(function(){ checksession(); }, 5000);


    </script>
  </body>
</html>
