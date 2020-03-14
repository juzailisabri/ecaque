<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
    <meta charset="utf-8" />
    <title>Pages - Admin Dashboard UI Kit - Lock Screen</title>
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
    <link href="assets/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" media="screen" />
    <link href="assets/plugins/switchery/css/switchery.min.css" rel="stylesheet" type="text/css" media="screen" />
    <link href="assets/plugins/bootstrap-datepicker/css/datepicker3.css" rel="stylesheet" type="text/css" media="screen">
    <link href="pages/css/pages-icons.css" rel="stylesheet" type="text/css">
    <link class="main-stylesheet" href="pages/css/themes/light.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript">
    window.onload = function()
    {
      // fix for windows 8
      if (navigator.appVersion.indexOf("Windows NT 6.2") != -1)
        document.head.innerHTML += '<link rel="stylesheet" type="text/css" href="pages/css/windows.chrome.fix.css" />'
    }
    </script>
  </head>
  <body class="fixed-header menu-pin menu-behind">
    <div class="register-container full-height sm-p-t-30">
      <div class="d-flex justify-content-center flex-column full-height ">
        <img src="assets/img/logo2.png" alt="logo" data-src="assets/img/logo2.png" data-src-retina="assets/img/logo2_2x.png" width="78" height="22">
        <h3>Sistem Pengurusan Rumah Angkatan Tentera</h3>
        <p>
          Sila isi semua butir yang diperlukan bagi membenarkan anda mengakses sistem pengurusan rumah angkatan tentera cawangan Perumahan Sungai Besi.
        </p>
        <form id="form-register" class="p-t-15" role="form" action="dbo">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group form-group-default">
                <label>Nama Penuh Pengguna</label>
                <input type="text" name="fullname" placeholder="Nama Penuh Pengguna" class="form-control" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group form-group-default">
                <label>No. Tentera</label>
                <input type="text" name="notentera" placeholder="No. Tentera" class="form-control" required>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group form-group-default">
                <label>Tarikh Lahir</label>
                <input type="text" name="birthdate" data-date-format='dd-mm-yyyy' id="birthdate" placeholder="Pilih Tarikh" class="form-control" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group form-group-default">
                <label>No. Telefon</label>
                <input type="text" name="phone" placeholder="Alamat email" class="form-control" required>
              </div>
            </div>
          </div>
          <div class="row">

            <div class="col-md-12">
              <div class="form-group form-group-default">
                <label>Alamat Email</label>
                <input type="email" name="email" placeholder="Alamat email" class="form-control" required>
              </div>
            </div>
          </div>
          <hr>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group form-group-default">
                <label>Nama Pengguna</label>
                <input type="text" name="uname" placeholder="Nama Pengguna" class="form-control" required>
              </div>
            </div>

          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group form-group-default">
                <label>Katalaluan</label>
                <input type="password" name="pass" placeholder="Minima 8 Huruf & Nombor" class="form-control" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group form-group-default">
                <label>Ulang Katalaluan</label>
                <input type="password" name="pass2" placeholder="" class="form-control" required>
              </div>
            </div>
          </div>

          <div class="row m-t-10">
            <div class="col-lg-12">
              <p><small>Saya bersetuju dengan terma, syarat dan polisi privasi sistem ini.</p>
            </div>
            <div class="col-lg-12 text-right">
              <a href="#" class="text-info small">Pertolongan? Hubungi Kami</a>
            </div>
          </div>
          <button class="btn btn-primary btn-cons m-t-10" type="submit">Daftar Akaun Baharu</button>
          <a class="btn btn-primary btn-cons m-t-10" href="login">Batal</a>
        </form>
      </div>
    </div>

    <!-- START OVERLAY -->
    <!-- END OVERLAY -->
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
    <script type="text/javascript" src="assets/plugins/select2/js/select2.full.min.js"></script>
    <script type="text/javascript" src="assets/plugins/classie/classie.js"></script>
    <script src="assets/plugins/switchery/js/switchery.min.js" type="text/javascript"></script>

    <script src="assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js" type="text/javascript"></script>
    <script src="assets/plugins/summernote/js/summernote.min.js" type="text/javascript"></script>
    <script src="assets/plugins/moment/moment.min.js"></script>
    <script src="assets/plugins/bootstrap-daterangepicker/daterangepicker.js"></script>
    <script src="assets/plugins/bootstrap-timepicker/bootstrap-timepicker.min.js"></script>
    <script src="assets/plugins/sweetalert/sweetalert.min.js"></script>
    <!-- <script src="assets/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script> -->
    <script src="assets/plugins/formvalidation/js/formValidation.min.js"></script>
    <script src="assets/plugins/formvalidation/js/framework/bootstrap.min.js"></script>
    <!-- END VENDOR JS -->
    <script src="pages/js/pages.min.js"></script>
    <script>

    function saAlert(msg){ swal(msg); }
    function saAlert2(title,msg){ swal(title,msg); }
    function saAlert3(title,msg,status){ swal(title,msg,status); }
    function saAlert4(title,msg,status,link){
      swal({
        title: title,
         text: msg,
          type: status
        },
        function(){
          window.location.href = link;
      });
    }
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
          closeOnCancel: false
      }, function(isConfirm){
          if (isConfirm) {
            runfunction();
          } else {
            swal(canceltext, canceldesc, "error");
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
          imageUrl: "img/loading.gif"
      }, function(isConfirm){

      });
    }

    $(function()
    {
      $('#form-register').formValidation({
        message: 'This value is not valid',
        fields: {
          uname: {
            message: 'Field is not valid',
            validators: {
                notEmpty: {
                    message: 'Field is required'
                },
                stringLength: {
                    min: 4,
                    message: 'Must be minimum 4 characters long'
                }
            }
          },
          fullname: {
            message: 'Field is not valid',
            validators: {
                notEmpty: {
                    message: 'Field is required'
                },
                stringLength: {
                    min: 8,
                    message: 'Must be minimum 8 characters long'
                }
            }
          },
          pass: {
            message: 'Field is not valid',
            validators: {
                notEmpty: {
                    message: 'Field is required'
                },
                stringLength: {
                    min: 8,
                    message: 'Must be minimum 8 characters long'
                }
            }
          },
          pass2: {
            message: 'Field is not valid',
            validators: {
                identical: {
                    field: 'pass',
                    message: 'Password confirmation does not match'
                }
            }
          },
          email: {

          }
        }
      }).on('success.form.fv', function(e) {
          // Prevent form submission
          e.preventDefault();
          runfunction = saveData;
          saConfirm2("Confirmation","Proceed with membership registration?","warning","Yes, Confirm",runfunction);


      });
    });



    function saveData(){
      saConfirm3("Submitting","Your submission is in progress. Please wait","warning");
      var $form    = $('#form-register'),
          formData = new FormData(),
          params   = $form.serializeArray();

      $.each(params, function(i, val) {
          formData.append(val.name, val.value);
      });

      $.ajax({
          url: $form.attr('action'),
          data: formData,
          cache: false,
          contentType: false,
          processData: false,
          type: 'POST',
          dataType:'json',
          beforeSend:function() {
            $("#btnSubmit").attr('disabled','disabled');
          },
          success: function(data) {
            console.log (data);
            $("#status_text").html(data);
            if(data['STATUS']){
              saAlert4("Tahniah!","Email pengesahan telah dihantar ke akaun email anda.\n\n Sila periksa email anda dan klik pada pautan yang diberikan untuk mengaktifkan akaun anda.","success","login");
            } else {
              saAlert3("Harap Maaf",data['MSG'],"warning");
            }
          }
      });
    }

    $("#birthdate").datepicker();
    </script>
  </body>
</html>
