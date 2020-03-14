<?php include("../../formfunction.php"); ?>

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
            <div class="card-title">SETTING PENGGUNA
            </div>
          </div>
          <div class="card-body">
            <h3>KEMASKINI PROFIL</h3>
            <p>Anda boleh kemaskini katalaluan anda.</p>
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
            <div class="card card-transparent ">
              <ul class="nav nav-tabs nav-tabs-complete nav-tabs-fillup d-none d-md-flex d-lg-flex d-xl-flex" data-init-reponsive-tabs="dropdownfx">
                <li class="nav-item">
                  <a href="#" data-toggle="tab" data-target="#tab-fillup2" class="active show"><span>Katalaluan</span></a>
                </li>
              </ul>
              <div class="tab-content">
                <div class="tab-pane" id="tab-fillup1">
                  <div class="row m-t-20">
                    <div class="col-lg-12">
                      <h3 class="m-b-0">Kemaskini Profile</h3>
                      <p>Sila kemaskini profil anda jika diperlukan sahaja.</p>
                    </div>
                  </div>
                  <div class="row column-seperation">
                    <div class="col-md-12">
                      <form id="form-update-profil" class="p-t-15" role="form" action="dbo">
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group form-group-default">
                              <label>Nama Penuh Pengguna</label>
                              <input type="text" name="fullname" id="fullname" placeholder="Nama Penuh Pengguna" class="form-control" required>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group form-group-default">
                              <label>No. Tentera</label>
                              <input type="text" name="notentera" id="notentera" placeholder="No. Tentera" class="form-control" required>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group form-group-default">
                              <label>Tarikh Lahir</label>
                              <input type="text" name="tarikhLahir" data-date-format='dd-mm-yyyy' id="tarikhLahir" placeholder="Pilih Tarikh" class="form-control" required>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group form-group-default">
                              <label>No. Telefon</label>
                              <input type="text" name="phone" id="phone" placeholder="No. Telefon" class="form-control" required>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-12">
                            <div class="form-group form-group-default">
                              <label>Alamat Email</label>
                              <input type="email" name="email" id="email" placeholder="Alamat email" class="form-control" required>
                            </div>
                          </div>
                        </div>
                        <button class="btn btn-success btn-cons m-t-10" type="submit">Kemaskini Profil</button>
                        <a class="btn btn-danger btn-cons m-t-10" href="login">Batal</a>
                      </form>
                    </div>
                  </div>

                </div>
                <div class="tab-pane  active show" id="tab-fillup2">
                  <div class="row m-t-20">
                    <div class="col-lg-12">
                      <h3 class="m-b-0">Kemaskini Katalaluan</h3>
                      <p>Sila masukkan katalaluan lama anda dan katalaluan baru</p>
                    </div>
                  </div>
                  <div class="row column-seperation">
                    <div class="col-md-12">
                      <form id="form-update-password" class="p-t-15" role="form" action="dbo">
                        <div class="row">
                          <div class="col-md-12">
                            <div class="form-group form-group-default">
                              <label>Katalaluan Lama</label>
                              <input type="password" name="Oldpassword" placeholder="Minima 8 Huruf & Nombor" class="form-control" required>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group form-group-default">
                              <label>Katalaluan</label>
                              <input type="password" name="password" placeholder="Minima 8 Huruf & Nombor" class="form-control" required>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group form-group-default">
                              <label>Ulang Katalaluan</label>
                              <input type="password" name="password2" placeholder="" class="form-control" required>
                            </div>
                          </div>
                        </div>
                        <button class="btn btn-success btn-cons m-t-10" type="submit">Tukar Katalaluan</button>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>



<script type="text/javascript">
  $("#tarikhLahir").datepicker();

  $('#form-update-password').formValidation({
    message: 'This value is not valid',
    fields: {
      Oldpassword: {
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
      password: {
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
      password2: {
        message: 'Field is not valid',
        validators: {
            identical: {
                field: 'password',
                message: 'Password confirmation does not match'
            }
        }
      }
    }
  }).on('success.form.fv', function(e) {
      // Prevent form submission
      e.preventDefault();
      runfunction = updatePassword;
      saConfirm2("Confirmation","Proceed with membership registration?","warning","Yes, Confirm",runfunction);
  });

  function updatePassword(){
    saConfirm3("Sila Tunggu","Permohonan dalam proses. Harap Bersabar","warning");
    var myform = document.getElementById("form-update-password");
    var fd = new FormData(myform);
    fd.append("func","changePassword")
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
            $("#profileSetting[class='syslink']").click();
          } else {
            saAlert3("Tidak Berjaya",data["MSG"],"warning");
          }
        },
        error: function(data) {
          // saAlert3("Error","Session Log Out Error","warning");
        }
    });
  }



    // $("#PerkhidmatanHingga").rules('add', { greaterThan: "#PerkhidmatanDari" });
</script>
<!-- <script src="assets/js/scripts.js" type="text/javascript"></script>
<script src="pages/js/pages.min.js"></script>
<script src="assets/js/scripts.js" type="text/javascript"></script> -->
