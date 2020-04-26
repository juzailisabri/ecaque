<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
    <meta charset="utf-8" />
    <title>eCaque Agent Portal Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
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
    <!-- BEGIN PLUGINS -->
    <link href="administrator/assets/plugins/sweetalert/sweetalert.css" rel="stylesheet" type="text/css">
    <link href="assets/plugins/pace/pace-theme-flash.css" rel="stylesheet" type="text/css" />
    <link href="assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/plugins/font-awesome/css/font-awesome.css" rel="stylesheet" type="text/css" />
    <link href="assets/plugins/swiper/css/swiper.css" rel="stylesheet" type="text/css" media="screen" />
    <!-- END PLUGINS -->
    <!-- BEGIN PAGES CSS -->
    <link class="main-stylesheet" href="pages/css/pages.css" rel="stylesheet" type="text/css" />
    <link class="main-stylesheet" href="pages/css/pages-icons.css" rel="stylesheet" type="text/css" />
    <link href="administrator/assets/plugins/formvalidation/css/formValidation.css" rel="stylesheet" type="text/css" media="screen" />
    <!-- BEGIN PAGES CSS -->
  </head>
  <body class="pace-white">
    <!-- BEGIN JUMBOTRON -->
    <div class="modal fade stick-up"  id="forgotPassword" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" >
            <div class="modal-content">

                <div class="modal-header clearfix text-left">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    <i class="pg-close fs-14"></i>
                    </button>
                    <h5> <i class="fa fa-user m-r-5"></i> <span class="semi-bold">Lupa Katalaluan</span> ?</h5>
                    <p>Sila Masukkan Alamat Emel anda. Kami akan hantar pautan untuk reset password anda.</p>
                </div>
                <div class="modal-body">
                  <form class="" id="forgetPasswordform">
                    <div class="row m-t-20" >
                      <div class="col-lg-12">
                        <div class="form-group form-group-default">
                          <label>Alamat Emel</label>
                          <div class="controls">
                            <input type="text" id="emailfp" name="emailfp" placeholder="cikkiah@abc.com" class="form-control" required="">
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row m-t-20">
                      <div class="col-lg-12">
                        <button type="submit" class="btn btn-primary" name="button" id="resetPassword">Reset Password</button>
                      </div>
                    </div>
                  </form>

                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <section class="jumbotron demo-custom-height xs-full-height bg-black" data-pages-bg-image="assets/slider/login2.jpg" style="">
      <div class="container-xs-height full-height">
        <div class="col-xs-height col-middle text-left">
          <div class="container ">
            <div class="col-sm-7 bg-black padding-40">
              <h1 class="light text-white">eCaque.my | Ejen Ecaque</h1>
              <h4 class="text-white">Login using your email address & password</h4>
              <form class="m-t-25 m-b-20" id="forgotPasswordForm">
                <div class="form-group form-group-default input-group no-border input-group-attached col-md-12  col-sm-12 col-xs-12">
                  <label class="control-label">Email Address</label>
                  <input id="email" type="email" class="form-control" placeholder="cikkiah@abc.com">
                </div>
                <div class="form-group form-group-default input-group no-border input-group-attached col-md-12  col-sm-12 col-xs-12">
                  <label class="control-label">Password</label>
                  <input type="password" id="password" class="form-control" placeholder="***********">
                  <span class="input-group-btn">
                     <button id="login" name="login" class="btn btn-primary  btn-cons" type="button">Login!</button>
                  </span>
                </div>
              </form>
              <p class="text-white fs-12"><a id="forgetPasswordBtn" href="#">Forgot password? Click Here</a></p>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- END JUMBOTRON -->
    <!-- START FOOTER -->
    <section class="p-b-30 p-t-40">
      <div class="container">
        <div class="row">
          <div class="col-sm-6">
            <img src="assets/images/Logo_2020_Black_Large.png" width="280" data-src-retina="assets/images/Logo_2020_Black_Large.png" class="logo inline m-r-50" alt="">
            <div class="m-t-10 ">
              <ul class="no-style fs-11 no-padding font-arial">
                <li class="inline no-padding"><a href="index" class=" text-master p-r-10 b-r b-grey">Home</a></li>
                <li class="inline no-padding"><a href="index" class="hint-text text-master p-l-10 p-r-10 b-r b-grey">Beli Sekarang</a></li>
                <li class="inline no-padding"><a href="index" class="hint-text text-master p-l-10 p-r-10 b-r b-grey">Where To Buy</a></li>
                <li class="inline no-padding"><a href="index" class="hint-text text-master p-l-10 p-r-10 xs-no-padding xs-m-t-10">Contact Us</a></li>
              </ul>
            </div>
          </div>
          <div class="col-sm-6 text-right font-arial sm-text-left">
            <!-- <p class="fs-11 no-margin small-text"><span class="hint-text">Exclusive only at</span> Envato Marketplace,Themeforest <span class="hint-text">See</span> Standard licenses &amp; Extended licenses
            </p> -->
            <p class="fs-11 muted">Copyright &copy; 2020 eCaque Enterprise. All Rights Reserved.</p>
          </div>
        </div>
      </div>
    </section>
    <!-- END FOOTER -->
    <!-- BEGIN CORE FRAMEWORK -->
    <script src="administrator/assets/plugins/sweetalert/sweetalert.min.js"></script>
    <script src="assets/plugins/pace/pace.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="pages/js/pages.image.loader.js"></script>
    <script type="text/javascript" src="assets/plugins/jquery/jquery-1.11.1.min.js"></script>
    <script src="assets/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <!-- BEGIN RETINA IMAGE LOADER -->
    <script type="text/javascript" src="assets/plugins/jquery-unveil/jquery.unveil.min.js"></script>
    <!-- END VENDOR JS -->
    <!-- BEGIN PAGES FRONTEND LIB -->
    <script type="text/javascript" src="pages/js/pages.frontend.js"></script>
    <script src="administrator/assets/plugins/formvalidation/js/formValidation.min.js"></script>
    <script src="administrator/assets/plugins/formvalidation/js/framework/bootstrap.min.js"></script>
    <!-- END PAGES LIB -->
  </body>

  <script type="text/javascript">

  $("#username").on("keydown", function(e) {
      if (e.keyCode === 13) {
        e.preventDefault();
      $("[id='login']").click();
    }
  });

  $("#password").on("keydown", function(e) {
      if (e.keyCode === 13) {
        e.preventDefault();
      $("[id='login']").click();
    }
  });

  $("[id='login']").click(function(e){
    var email = $("#email").val();
    var password = $("#password").val();
    var fd = new FormData();
    fd.append("email",email);
    fd.append("password",password);
    fd.append("func","Login");
    $.ajax({
        type: 'POST',
        url: "agent/db",
        data: fd,
        dataType: "json",
        cache: false,
        contentType: false,
        processData: false,
        success: function(data) {
          if(data["STATUS"]){
            window.location = "agent/index";
          } else {
            saAlert3("Harap Maaf",data["MSG"],"warning")
          }
        },
        error: function(data) {
          // saAlert3("Error","Session Log Out Error","warning");
        }
    });
  });

  $("#forgetPasswordBtn").click(function(e){
    $("#forgotPassword").modal();
  });

  $('#forgetPasswordform').formValidation({
  }).on('success.form.fv', function(e) {
      e.preventDefault();
      forgotPassword();
  });

  function forgotPassword(){
    var fd = new FormData(document.getElementById('forgetPasswordform'));
    fd.append("func","forgotPassword");
    $.ajax({
        type: 'POST',
        url: "agent/db",
        data: fd,
        dataType: "json",
        cache: false,
        contentType: false,
        processData: false,
        success: function(data) {
          if(data["STATUS"]){
            saAlert3("Berjaya",data["MSG"],"success");
          }  else {
            saAlert3("Harap Maaf",data["MSG"],"warning");
          }
        },
        error: function(data) {
          // saAlert3("Error","Session Log Out Error","warning");
        }
    });
  }

  function saAlert3(title,msg,status){ swal(title,msg,status); }
  </script>
</html>
