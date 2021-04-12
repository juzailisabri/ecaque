<?php
include("administrator/formfunction.php");
$buyPanel = "false"; if (isset($_GET["l"])) { $buyPanel = $_GET["l"]; }
$rpid = ""; if (isset($_GET["rpid"])) { $rpid = $_GET["rpid"]; }
$ogimage = "http://".$_SERVER["HTTP_HOST"]."$rootdir/assets/promo/RMDN2021/desktopBanner.jpg";

$rp7 = getProductEnc(13);
$rp8 = getProductEnc(14);
$rp9 = getProductEnc(15);
$rp10 = getProductEnc(16);
$rp11 = getProductEnc(17);
$rp12 = getProductEnc(18);

?>

<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
    <meta charset="utf-8" />
    <title>eCaque - Homemade Fruit Cake</title>

    <meta property="og:site_name" content="eCaque.my | Homemade Fruit Cake">
    <meta property="og:title" content="eCaque | Promosi Istimewa Ramadan 2021" />
    <meta property="og:description" content="Kek buah kukus Ecaque adalah satu produk muslim homemade yang telah dipasarkan bermula dari tahun 2016. Dihasilkan mengikut resepi asal pemiliknya, Pn Faridah Borham, ianya diadun menggunakan bahan-bahan yang berkualiti tinggi. Kek buah ini dikukus selama 4 jam untuk menghasilkn kek yang lebih tahan lama. Struktur kek adalah moist, tidak terlalu manis dengan gabungan aroma butter, caramel dan buah-buahan campuran kering serta tiada bahan pengawet. Ia amat sesuai dihidangkan untuk minum petang, majlis-majlis dan dihadiahkn kepada yang tersayang." />
    <meta property="og:image" itemprop="image" content="<?php echo $ogimage ?>">
    <meta property="og:type" content="website" />

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
    <link href="assets/plugins/pace/pace-theme-flash.css" rel="stylesheet" type="text/css" />
    <link href="assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/plugins/font-awesome/css/font-awesome.css" rel="stylesheet" type="text/css" />
    <link href="assets/plugins/swiper/css/swiper.css" rel="stylesheet" type="text/css" media="screen" />
    <!-- END PLUGINS -->
    <!-- BEGIN PAGES CSS -->
    <link class="main-stylesheet" href="pages/css/pages.css" rel="stylesheet" type="text/css" />
    <link class="main-stylesheet" href="pages/css/pages-icons.css" rel="stylesheet" type="text/css" />
    <!-- BEGIN PAGES CSS -->
    <link href="administrator/assets/plugins/sweetalert/sweetalert.css" rel="stylesheet" type="text/css">
    <link href="administrator/assets/plugins/formvalidation/css/formValidation.css" rel="stylesheet" type="text/css" media="screen" />
    <style media="screen">
      .fv-form-bootstrap .help-block {
        margin-bottom: 0;
        margin-left: 10px;
        margin-bottom: 5px;
      }
    </style>
  </head>
  <body class="pace-dark">
    <div class="modal fade slide-up disable-scrolla" id="modalSlideUp" tabindex="-1" role="dialog" aria-labelledby="modalSlideUpLabel" aria-hidden="false">
        <div class="modal-dialog " style="margin-bottom:100px;">
            <div class="modal-content-wrapper">
            <div class="modal-content">
                <div class=" modal-header clearfix text-left">
                    <!-- <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                      <i class="pg-close fs-14"></i>
                    </button> -->
                    <h4 class="fs-20">Ramadan Tiba <span class="semi-bold">eCaque</span> |  Whatsapp</h4>
                    <!-- <p class="text-black  fs-13">Sila masukkan maklumat Nama, Alamat, No. Telefon dan kuantiti kek yang anda perlukan bagi pesanan ini. Pesanan ini akan dihantar melalui aplikasi WhatsApp.</p> -->
                </div>
                <div class="modal-body">
                  <form class="m-t-25 m-b-20" id="form-order">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group form-group-default input-group no-bordera input-group-attached col-xs-12">
                          <label class="control-label">Nama Produk / Kombo</label>
                          <input id="productname" readonly name="productname" type="text" class="text-black bold form-control" placeholder="">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group form-group-default input-group no-bordera input-group-attached col-xs-12">
                          <label class="control-label">Nama Penuh</label>
                          <input id="fullname" required name="fullname" type="text" class="form-control" placeholder="">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group form-group-default input-group no-bordera input-group-attached col-xs-12">
                          <label class="control-label">Alamat Penghantaran</label>
                          <textarea id="address" style="height:60px" required name="address" type="text" class="form-control" placeholder=""></textarea>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group form-group-default input-group no-bordera input-group-attached col-xs-12">
                          <label class="control-label">No. Telefon</label>
                          <input id="phone" required name="phone" type="text" class="form-control" placeholder="">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group form-group-default input-group no-bordera input-group-attached col-xs-12">
                          <label class="control-label">Kuantiti</label>
                          <!-- <input id="quantityOrder" pattern="[0-9]*" required name="quantityOrder" type="number" class="form-control" placeholder=""> -->
                          <select id="quantityOrder"  name="quantityOrder" class="form-control" required>
                            <?php getKuantiti(); ?>
                          </select>

                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group form-group-default input-group no-bordera input-group-attached col-xs-12">
                          <label class="control-label">Jenis Penghantaran</label>
                          <select id="jenisPenghantaran" required name="jenisPenghantaran" class="form-control" >
                            <?php getJenisPenghantaran2(); ?>
                          </select>
                          <!-- <input type="fullname" class="form-control" placeholder="johnsmith@abc.com"> -->
                        </div>
                      </div>
                    </div>

                    <div class="row m-t-20">
                      <div class="col-xs-8">
                        <div class="text-whitea text-right block-title">Price/Item</div>
                      </div>
                      <div class="col-xs-4 text-right ">
                        RM <span id="sTotal">00.00</span>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-xs-8">
                        <div class="text-whitea text-right block-title">Postage</div>
                      </div>
                      <div class="col-xs-4 text-right ">
                        RM <span id="sPostage">00.00</span>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-xs-8">
                        <div class="text-whitea text-right block-title">Total</div>
                      </div>
                      <div class="col-xs-4 text-right ">
                        RM <span id="sGtotal">00.00</span>
                      </div>
                    </div>

                    <hr>

                    <div class="row m-t-20">
                      <div class="col-md-12 text-right">
                        <button data-dismiss="modal" aria-hidden="true" type="button" class="btn btn-dark" name="button"> <i class="fa fa-close"></i></button>
                        <button type="submit" class="btn btn-primary" name="button">Hantar <i class="fa fa-send m-l-5"></i></button>
                      </div>
                    </div>
                  </form>
                </div>
            </div>
            </div>
            <!-- /.modal-content -->
        </div>
    </div>
    <div class="modal fade slide-up disable-scrolla " id="modalPromo" tabindex="-1" role="dialog" aria-labelledby="modalSlideUpLabel" aria-hidden="false">
        <div class="modal-dialog modal-lg ">
            <div class="modal-content-wrapper">
            <div class="modal-content bg-black no-border">
                <!-- <div class="modal-header clearfix text-left bg-darker">
                    <h4 class="fs-20 text-white"><span class="semi-bold">eCaque</span> |  Promo Hari Bapa 2020</h4>
                </div> -->
                <div class="modal-body no-padding  bg-black">
                  <div class="">
                    <img src="assets/promo/promo-fathersday-2020.jpg" width="100%" alt="">
                  </div>
                  <!-- <div class="row">
                    <div class="col-lg-12 padding-10">
                      <button type="button" class="btn  btn-success pull-right m-r-15" name="button">Saya Berminat</button>
                      <button type="button" class="btn  btn-muted pull-right m-r-10" name="button"> <i class="fa fa-close"></i> </button>
                    </div>
                  </div> -->
                </div>
            </div>
            </div>
            <!-- /.modal-content -->
        </div>
    </div>
    <!-- BEGIN HEADER -->
    <nav class="hidden header bg-header transparent-dark " data-pages="header" data-pages-header="autoresize" data-pages-resize-class="dark">
      <div class="container relative">
        <!-- BEGIN LEFT CONTENT -->
        <div class="pull-left">
          <!-- .header-inner Allows to vertically Align elements to the Center-->
          <div class="header-inner">
            <!-- BEGIN LOGO -->
            <img src="assets/images/Logo_2020_White.png" width="250" data-src-retina="assets/images/Logo_2020_White.png" class="logo" alt="">
            <!-- <img src="assets/images/Logo_2020_Black_Large.png" width="250" data-src-retina="assets/images/Logo_2020_Black_Large.png" class="logo" alt=""> -->
            <img src="assets/images/Logo_2020_White.png" width="250" data-src-retina="assets/images/Logo_2020_White.png" class="alt" alt="">
          </div>
        </div>
        <!-- BEGIN HEADER TOGGLE FOR MOBILE & TABLET -->
        <div class="pull-right">
          <div class="header-inner">
            <!-- <a href="#" class="text-white search-toggle visible-sm-inline visible-xs-inline p-r-10" data-toggle="search"><i class="fs-14 pg-search"></i></a> -->
            <div class=" visible-sm-inline visible-xs-inline menu-toggler pull-right p-l-10" data-pages="header-toggle" data-pages-element="#header">
              <div class="one"></div>
              <div class="two"></div>
              <div class="three"></div>
            </div>
          </div>
        </div>
        <!-- END HEADER TOGGLE FOR MOBILE & TABLET -->
        <!-- BEGIN RIGHT CONTENT -->
        <div class="menu-content mobile-dark pull-right clearfix" data-pages-direction="slideRight" id="header">
          <!-- BEGIN HEADER CLOSE TOGGLE FOR MOBILE -->
          <div class="pull-right">
            <a href="#" class="padding-10 visible-xs-inline visible-sm-inline pull-right m-t-10 m-b-10 m-r-10" data-pages="header-toggle" data-pages-element="#header">
              <i class=" pg-close_line"></i>
            </a>
          </div>
          <!-- END HEADER CLOSE TOGGLE FOR MOBILE -->
          <!-- BEGIN MENU ITEMS -->
          <div class="header-inner">
            <ul class="menu ">
              <li>
                <a id="menuLink" target="home" href="#" class="active  text-white">Home </a>
              </li>
              <li>
                <a id="menuLink" target="pricing" class="text-white  active"href="#">Beli Sekarang </a>
              </li>
              <li>
                <a id="menuLink" target="agent" class="text-white  active" href="#">Daftar Ejen </a>
              </li>
              <li>
                <a  id="menuLink" target="contact"  class="text-white active"href="#">Hubungi Kami</a>
              </li>
              <li>
                <a class="text-white active"href="login">Login Ejen</a>
              </li>
              <li>
                <a class="text-white active visible-xs" href="loginAdmin">Login Admin</a>
              </li>
            </ul>
            <a href="loginAdmin" class="text-white search-toggle hidden-xs hidden-sm" data-toggle="searcha"><i class="fa fa-lock fa-lg"></i></a>
            <!-- BEGIN COPYRIGHT FOR MOBILE -->
            <div class="font-arial m-l-35 m-r-35 m-b-20 visible-sm visible-xs m-t-20">
              <!-- <p class="fs-11 no-margin small-text p-b-20">Exclusive only at ,Themeforest. See Standard licenses & Extended licenses
              </p> -->
              <p class="fs-11 small-text muted">Copyright &copy; 2020 eCaque Enterprise</p>
            </div>
            <!-- END COPYRIGHT FOR MOBILE -->
          </div>
          <!-- END MENU ITEMS -->
        </div>
      </div>
    </nav>
    <!-- END HEADER -->
    <div class="page-wrappers">
      <!-- BEGIN JUMBOTRON -->
      <section class="jumbotron full-vh" data-pages="parallax" id="homeaaaa">
        <div class="inner full-height">
          <!-- BEGIN SLIDER -->
          <div class="swiper-container" id="menuLink" target="home2">
            <div class="swiper-wrapper" >

              <div class="swiper-slide fit" id="">
                <div class="slider-wrapper">
                  <div class="background-wrapper" data-swiper-parallax="0%">
                    <div class="background hidden-xs"  style="background-position: center top" data-pages-bg-image="assets/promo/RMDN2021/desktopBanner.jpg"></div>
                    <div class="background visible-xs"  style="background-position: center center" data-pages-bg-image="assets/promo/RMDN2021/mobileBanner.jpg"></div>
                  </div>
                </div>
                <div class="content-layer">
                  <div class="inner full-height">
                    <div class="container-xs-height full-height">
                      <div class="col-xs-height col-bottom text-left">
                        <div class="container ">
                          <div class="col-md-offset-6a col-md-12  m-b-100 col-xs-12 ">

                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- BEGIN ANIMATED MOUSE -->
            <div class="hidden-xs mouse-wrapper">
              <div class="mouse">
                <div class="mouse-scroll"></div>
              </div>
            </div>
            <!-- Add Navigation -->
            <!-- <div class="swiper-navigation swiper-dark-solid swiper-button-prev auto-reveal"></div>
            <div class="swiper-navigation swiper-dark-solid swiper-button-next auto-reveal"></div> -->
          </div>
        </div>
        <!-- END SLIDER -->
      </section>

      <section class="jumbotron full-vha visible-xs" style="padding-top:13%;position:relative;" data-pages="parallax" id="home2">
        <div class="inner full-height bg-master-darkest" style="position: absolute; top: 0; left: 0; bottom: 0; right: 0;">
            <div class="m-t-15 text-center text-white bold">
             <small>Swipe left to view promotion & tap image to buy</small>
            </div>
        </div>
      </section>



      <section class="jumbotron full-vha visible-xs" style="padding-top:100%;position:relative;" data-pages="parallax" id="home2">
        <div class="inner full-height" style="position: absolute; top: 0; left: 0; bottom: 0; right: 0;">
          <!-- BEGIN SLIDER -->
          <div class="swiper-container" id="hero2" >
            <div class="swiper-wrapper" >

              <div class="swiper-slide fit" id="promoBuy" prod="<?php echo $rp7; ?>">
                <div class="slider-wrapper">
                  <div class="background-wrapper" data-swiper-parallax="0%">
                    <div class="background visible-xs"  style="background-position: center center" data-pages-bg-image="assets/promo/RMDN2021/s3.jpg"></div>
                  </div>
                </div>
                <div class="content-layer">
                  <div class="inner full-height">
                    <div class="container-xs-height full-height">
                      <div class="col-xs-height col-bottom text-left">
                        <div class="container ">
                          <div class="col-md-offset-6a col-md-12  m-b-100 col-xs-12 ">

                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="swiper-slide fit" id="promoBuy" prod="<?php echo $rp8; ?>">
                <div class="slider-wrapper">
                  <div class="background-wrapper" data-swiper-parallax="0%">
                    <div class="background visible-xs"  style="background-position: center center" data-pages-bg-image="assets/promo/RMDN2021/s1.jpg"></div>
                  </div>
                </div>
                <div class="content-layer">
                  <div class="inner full-height">
                    <div class="container-xs-height full-height">
                      <div class="col-xs-height col-bottom text-left">
                        <div class="container ">
                          <div class="col-md-offset-6a col-md-12  m-b-100 col-xs-12 ">

                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="swiper-slide fit" id="promoBuy" prod="<?php echo $rp9; ?>">
                <div class="slider-wrapper">
                  <div class="background-wrapper" data-swiper-parallax="0%">
                    <div class="background visible-xs"  style="background-position: center center" data-pages-bg-image="assets/promo/RMDN2021/s2.jpg"></div>
                  </div>
                </div>
                <div class="content-layer">
                  <div class="inner full-height">
                    <div class="container-xs-height full-height">
                      <div class="col-xs-height col-bottom text-left">
                        <div class="container ">
                          <div class="col-md-offset-6a col-md-12  m-b-100 col-xs-12 ">

                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="swiper-slide fit" id="promoBuy" prod="<?php echo $rp10; ?>">
                <div class="slider-wrapper">
                  <div class="background-wrapper" data-swiper-parallax="0%">
                    <div class="background visible-xs"  style="background-position: center center" data-pages-bg-image="assets/promo/RMDN2021/s4.jpg"></div>
                  </div>
                </div>
                <div class="content-layer">
                  <div class="inner full-height">
                    <div class="container-xs-height full-height">
                      <div class="col-xs-height col-bottom text-left">
                        <div class="container ">
                          <div class="col-md-offset-6a col-md-12  m-b-100 col-xs-12 ">
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="swiper-slide fit" id="promoBuy" prod="<?php echo $rp11; ?>">
                <div class="slider-wrapper">
                  <div class="background-wrapper" data-swiper-parallax="0%">
                    <div class="background visible-xs"  style="background-position: center center" data-pages-bg-image="assets/promo/RMDN2021/s5.jpg"></div>
                  </div>
                </div>
                <div class="content-layer">
                  <div class="inner full-height">
                    <div class="container-xs-height full-height">
                      <div class="col-xs-height col-bottom text-left">
                        <div class="container ">
                          <div class="col-md-offset-6a col-md-12  m-b-100 col-xs-12 ">

                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="swiper-slide fit" id="promoBuy" prod="<?php echo $rp12; ?>">
                <div class="slider-wrapper">
                  <div class="background-wrapper" data-swiper-parallax="0%">
                    <div class="background visible-xs"  style="background-position: center center" data-pages-bg-image="assets/promo/RMDN2021/s6.jpg"></div>
                  </div>
                </div>
                <div class="content-layer">
                  <div class="inner full-height">
                    <div class="container-xs-height full-height">
                      <div class="col-xs-height col-bottom text-left">
                        <div class="container ">
                          <div class="col-md-offset-6a col-md-12  m-b-100 col-xs-12 ">

                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- BEGIN ANIMATED MOUSE -->
            <div class="hidden-xs mouse-wrapper">
              <div class="mouse">
                <div class="mouse-scroll"></div>
              </div>
            </div>
            <!-- Add Navigation -->
            <div class="swiper-navigation swiper-dark-solid swiper-button-prev auto-reveal"></div>
            <div class="swiper-navigation swiper-dark-solid swiper-button-next auto-reveal"></div>
          </div>
        </div>


        <!-- END SLIDER -->
      </section>



      <section class="jumbotron full-vha hidden-xs padding-20a"  data-pages="" id="home2">
          <div class="row bg-master-darkest">
            <div class="padding-20 text-center text-white ">
             <b>Klik gambar promo dibawah untuk membuat pesanan</b> / <i>Click at promotion image Below to Order</i>
            </div>
          </div>
          <div class="text-center">
            <div class="col-md-4 no-padding no-margin" id="promoBuy" prod="<?php echo $rp7; ?>">
              <img src="assets/promo/RMDN2021/s3.jpg" style="display: block; cursor:pointer;" class="no-padding no-margin" width="100%" alt="">
            </div>
            <div class="col-md-4 no-padding no-margin" id="promoBuy" prod="<?php echo $rp8; ?>">
              <img src="assets/promo/RMDN2021/s1.jpg" style="display: block; cursor:pointer;" class="no-padding no-margin" width="100%" alt="">
            </div>
            <div class="col-md-4 no-padding no-margin" id="promoBuy" prod="<?php echo $rp9; ?>">
              <img src="assets/promo/RMDN2021/s2.jpg" style="display: block; cursor:pointer;" class="no-padding no-margin" width="100%" alt="">
            </div>
            <div class="col-md-4 no-padding no-margin" id="promoBuy" prod="<?php echo $rp10; ?>">
              <img src="assets/promo/RMDN2021/s4.jpg" style="display: block; cursor:pointer;" class="no-padding no-margin" width="100%" alt="">
            </div>
            <div class="col-md-4 no-padding no-margin" id="promoBuy" prod="<?php echo $rp11; ?>">
              <img src="assets/promo/RMDN2021/s5.jpg" style="display: block; cursor:pointer;" class="no-padding no-margin" width="100%" alt="">
            </div>
            <div class="col-md-4 no-padding no-margin" id="promoBuy" prod="<?php echo $rp12; ?>">
              <img src="assets/promo/RMDN2021/s6.jpg" style="display: block; cursor:pointer;" class="no-padding no-margin" width="100%" alt="">
            </div>
          </div>
      </section>

      <section class="jumbotron full-vha visible-xs" style="padding-top:13%;position:relative;" data-pages="parallax" id="home2">
        <div class="inner full-height bg-master-darkest" style="position: absolute; top: 0; left: 0; bottom: 0; right: 0;">
            <div class="m-t-15 text-center text-white bold">
             <small>Swipe left to view promotion & tap image to buy</small>
            </div>
        </div>
      </section>

      <section class="jumbotron full-vha visible-xs" style="padding-top:100%;position:relative;" data-pages="parallax" id="home2">
        <div class="inner full-height bg-danger" style="position: absolute; top: 0; left: 0; bottom: 0; right: 0;">
          <img src="assets/promo/RMDN2021/teaser3.jpg" width="100%" alt="">
        </div>
      </section>
      <section class="jumbotron full-vha visible-xs" style="padding-top:100%;position:relative;" data-pages="parallax" id="home2">
        <div class="inner full-height bg-danger" style="position: absolute; top: 0; left: 0; bottom: 0; right: 0;">
          <img src="assets/promo/RMDN2021/teaser2.jpg" width="100%" alt="">
        </div>
      </section>
      <section class="jumbotron full-vha visible-xs" style="padding-top:100%;position:relative;" data-pages="parallax" id="home2">
        <div class="inner full-height bg-danger" style="position: absolute; top: 0; left: 0; bottom: 0; right: 0;">
          <img src="assets/promo/RMDN2021/teaser1.jpg" width="100%" alt="">
        </div>
      </section>

      <section class="jumbotron full-vha hidden-xs padding-20a"  data-pages="" id="home2">
          <div class="row bg-master-darkest">
            <div class="padding-20 text-center text-white ">
             <b>Klik gambar promo dibawah untuk membuat pesanan</b> / <i>Click at promotion image Below to Order</i>
            </div>
          </div>
          <div class="text-center">
            <div class="col-md-4 no-padding no-margin" >
              <img src="assets/promo/RMDN2021/teaser3.jpg" style="display: block; cursor:pointer;" class="no-padding no-margin" width="100%" alt="">
            </div>
            <div class="col-md-4 no-padding no-margin" >
              <img src="assets/promo/RMDN2021/teaser2.jpg" style="display: block; cursor:pointer;" class="no-padding no-margin" width="100%" alt="">
            </div>
            <div class="col-md-4 no-padding no-margin" >
              <img src="assets/promo/RMDN2021/teaser1.jpg" style="display: block; cursor:pointer;" class="no-padding no-margin" width="100%" alt="">
            </div>
          </div>
      </section>

      <!-- END JUMBOTRON -->
      <!-- BEGIN CONTENT SECTION -->
      <section class=" p-b-85 p-t-75 no-overflow bg-master-darker">
        <div class="container">
          <div class="md-p-l-20 md-p-r-20 xs-no-padding">
            <h5 class="block-title hint-text no-margin text-white">Frequently Asked Questions</h5>
            <div class="row">
              <div class="col-sm-12">
                <h1 class="m-t-5 m-b-20 text-white">SOALAN LAZIM</h1>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-5 xs-p-l-15 xs-p-r-15">
                <p class=" font-arial no-padding no-margin">BERAPA LAMA KEK DAPAT BERTAHAN / Expiry</p>
                <p class="bold text-black m-b-20  text-white">2 Bulan jika disimpan pada suhu bilik & 4 Bulan jika disimpan ditempat yang sejuk & kering.</p>

                <p class=" font-arial no-padding no-margin">BERAT PRODUK / Product weight</p>
                <p class="bold text-black m-b-20  text-white">Berat kek adalah 1 Kilogram bersamaan 1000 gram</p>

                <!-- <p class=" font-arial no-padding no-margin">SIJIL HALAL / Halal Certificate</p>
                <p class="bold text-black m-b-20  text-white">Tiada, Produk Dihasilkan Dirumah</p> -->
                <p class=" font-arial no-padding no-margin">BAHAN ADA SIJIL HALAL / Ingredients Halal Certificate</p>
                <p class="bold text-black m-b-20  text-white">Ya, Semua Ramuan Mempunyai Sijil Halal</p>

                <p class=" font-arial no-padding no-margin">ADAKAH PRODUK BOLEH DI POS / Is the product can be deliver via courier</p>
                <p class="bold text-black m-b-20  text-white">Ya, Produk Boleh Di Pos</p>
              </div>
              <div class="col-sm-5 xs-p-l-15 xs-p-r-15">
                <p class=" font-arial no-padding no-margin">CARA PEMBUATAN / ways of making</p>
                <p class="bold text-black m-b-20  text-white">Kek Dikukus selama 4 jam untuk memastikan kek boleh tahan lama.</p>

                <p class=" font-arial no-padding no-margin">PRODUK BUMIPUTRA / Bumi Product</p>
                <p class="bold text-black m-b-20  text-white">Ya, eCaque Enterprise dimiliki penuh oleh Pn. Faridah Borham.</p>

                <p class=" font-arial no-padding no-margin">CARA PENYIMPANAN / Storage Condition</p>
                <p class="bold text-black m-b-20  text-white">Simpan Di Tempat Yang Sejuk Dan Kering</p>

                <p class=" font-arial no-padding no-margin">PRODUK BERASAL DARI MANA / Origin of Product</p>
                <p class="bold text-black m-b-20  text-white">Sungai Besar, Selangor</p>
              </div>
            </div>
          </div>
        </div>
      </section>

      <section class="p-b-85 p-t-75 bg-master-darkest">
        <!-- BEGIN TESTIMONIALS SLIDER-->
        <div class="swiper-container bg-master-darkest" id="testimonials_slider">
          <div class="swiper-wrapper bg-master-darkest">
            <!-- BEGIN TESTIMONIAL -->
            <div class="swiper-slide bg-master-darkest">
              <div class="container bg-master-darkest">
                <div class="col-sm-8 col-sm-offset-2">
                  <h3 class="text-center text-white">
                  Saya sudah beli 5 biji,4 biji saya bagi emak dan akak-akak, menyesal saya cuma 1 biji sahaja sebab dah habis separuh sebelum raya… Saya dan suami tidak jemu makan kek  ni, tidak ada sama kek buah yang lain yang pernah saya makan sebelum ni..  Betul2 sedap <br> <small>– Hjh Zuraidah (Brunei)</small>
                  </h3>
                  <!-- <img alt="" class="m-t-20" src="assets/images/signature_sample.jpg"> -->
                </div>
              </div>
            </div>
            <div class="swiper-slide bg-master-darkest">
              <div class="container bg-master-darkest">
                <div class="col-sm-8 col-sm-offset-2">
                  <h3 class="text-center text-white">
                  Dah banyak saya cuba tapi kek ni paling sedap dan moist keknya… saya brpuas hati sangat, keknya rasanya sedap.. keknya di potong tak berderai...manisnya pun cukup.. Sekarang saya nak order lagi, 3pek <br> <small>- Ema Shadan (Brunei)</small>
                  </h3>
                  <!-- <img alt="" class="m-t-20" src="assets/images/signature_sample.jpg"> -->
                </div>
              </div>
            </div>
            <!-- END TESTIMONIAL -->
            <!-- BEGIN TESTIMONIAL -->
            <div class="swiper-slide bg-master-darkest">
              <div class="container bg-master-darkest">
                <div class="col-sm-8 col-sm-offset-2">
                  <h3 class="text-center text-white">
                  Alhamdulillah sedap sungguh kek buah ni. Makannya pun tak jemu sebab tidak terlalu manis. <br> <small>– Nurdin (Alor Setar, Kedah)</small>
                  </h3>
                  <!-- <img alt="" class="m-t-20" src="assets/images/signature_sample.jpg"> -->
                </div>
              </div>
            </div>
            <!-- END TESTIMONIAL -->
            <!-- BEGIN TESTIMONIAL -->
            <div class="swiper-slide bg-master-darkest">
              <div class="container bg-master-darkest">
                <div class="col-sm-8 col-sm-offset-2">
                  <h3 class="text-center text-white">
                  Dah makan pun. Allah, sedap betul kek buah nii. Rasa moist dan bau butternya. Buah pun banyak. Sedap sungguh! <br> <small>- Pn Norida Mohamed (Subang, Selangor)</small>
                  </h3>
                  <!-- <img alt="" class="m-t-20" src="assets/images/signature_sample.jpg"> -->
                </div>
              </div>
            </div>
            <div class="swiper-slide bg-master-darkest">
              <div class="container bg-master-darkest">
                <div class="col-sm-8 col-sm-offset-2">
                  <h3 class="text-center text-white">
                  Saya dengar cerita sedap kek ni, saya pun beli lah 1 bekas.. Subhanallah memang sedap rasanya lembut dan moist lembab rasa kek tu.. penuh buahnya… Tak cukup satu nak lagi..  <br> <small>- Wadiananty Abdullah (Miri, Sarawak)</small>
                  </h3>
                  <!-- <img alt="" class="m-t-20" src="assets/images/signature_sample.jpg"> -->
                </div>
              </div>
            </div>
            <div class="swiper-slide bg-master-darkest">
              <div class="container bg-master-darkest">
                <div class="col-sm-8 col-sm-offset-2">
                  <h3 class="text-center text-white">
                  SubhanaAllah sedap sangat rasanya kek buah ecaque ni… Tak pernah saya rasa kek buah se”Moist” macam ini.. sebiji je tak cukup confirm akan habis sebelum raya. <br> <small>- Adina Rusdi (Dengkil, Selangor)</small>
                  </h3>
                  <!-- <img alt="" class="m-t-20" src="assets/images/signature_sample.png"> -->
                </div>
              </div>
            </div>
            <!-- END TESTIMONIAL -->
          </div>
          <!-- Add Navigation -->
          <div class="swiper-pagination relative p-t-20"></div>
        </div>
        <!-- END TESTIMONIALS -->
      </section>
      <!-- BEGIN FOOTER -->
      <section class="p-b-55 p-t-75 xs-p-b-20 bg-master-darker " id="contact">
        <div class="container">
          <div class="row">
            <div class="col-sm-4 col-xs-12 xs-m-b-40">
              <img src="assets/images/Logo_2020_White.png" width="300"  data-src-retina="assets/images/Logo_2020_White.png" class="alt" alt="">
            </div>

            <div class="col-sm-4 xs-m-b-20">
              <h6 class="font-montserrat text-uppercase fs-14 text-white p-b-10">Maklumat Syarikat</h6>
              <ul class="no-style">
                <li class="m-b-5 no-padding"><a href="#" class="link text-white ">Alamat Pejabat :</a></li>
                <li class="m-b-5 no-padding bold text-white">No. 23, Jalan Purnama 2/3, Taman Purnama 2, 45300 Sungai Besar, Selangor Darul Ehsan</li>
                <li class="m-b-5 no-padding"><a href="#" class="link text-white ">Contact (WhatsApp/Call) :</a></li>
                <li class="m-b-5 no-padding bold text-white">+6018 378 8508</li>
                <li class="m-b-5 no-padding"><a href="#" class="link text-white ">Alamat Email :</a></li>
                <li class="m-b-5 no-padding bold text-white">sales@ecaque.my</li>
              </ul>
            </div>
            <div class="col-sm-2 col-xs-6 xs-m-b-20">
              <h6 class="font-montserrat text-uppercase fs-14 text-white p-b-10">Media Sosial </h6>
              <ul class="no-style">
                <li class="m-b-5 no-padding"><a href="#" class="link text-white ">Instagram</a></li>
                <li class="m-b-5 no-padding"><a href="#" class="link text-white">Facebook</a></li>
                <!-- <li class="m-b-5 no-padding"><a href="#" class="link text-white">Team</a></li>
                <li class="m-b-5 no-padding"><a href="#" class="link text-white">Work Station</a></li>
                <li class="m-b-5 no-padding"><a href="#" class="link text-white">Privacy</a></li>
                <li class="m-b-5 no-padding"><a href="#" class="link text-white">Legal</a></li>
                <li class="m-b-5 no-padding"><a href="#" class="link text-white">Jobs</a></li> -->
              </ul>
            </div>
            <!--
            <div class="col-sm-2 col-xs-6 xs-m-b-20">
              <h6 class="font-montserrat text-uppercase fs-14 text-white p-b-10">Clients </h6>
              <ul class="no-style">
                <li class="m-b-5 no-padding"><a href="#" class="link text-white ">Our team</a></li>
                <li class="m-b-5 no-padding"><a href="#" class="link text-white">Our location</a></li>
                <li class="m-b-5 no-padding"><a href="#" class="link text-white">Contact Us</a></li>
                <li class="m-b-5 no-padding"><a href="#" class="link text-white">About Us</a></li>
              </ul>
            </div>
            <div class="col-sm-2 col-xs-6 xs-m-b-20">
              <h6 class="font-montserrat text-uppercase fs-14 text-white p-b-10">Pages </h6>
              <ul class="no-style">
                <li class="m-b-5 no-padding"><a href="#" class="link text-white ">Pages</a></li>
                <li class="m-b-5 no-padding"><a href="#" class="link text-white">Home</a></li>
                <li class="m-b-5 no-padding"><a href="#" class="link text-white">Tour</a></li>
                <li class="m-b-5 no-padding"><a href="#" class="link text-white">Versions</a></li>
                <li class="m-b-5 no-padding"><a href="#" class="link text-white">Dropdown</a></li>
                <li class="m-b-5 no-padding"><a href="#" class="link text-white">Pricing Page</a></li>
                <li class="m-b-5 no-padding"><a href="#" class="link text-white">Blog</a></li>
              </ul>
            </div> -->
          </div>
          <p class="fs-12 hint-text p-t-10 text-white">Copyright &copy; 2020. All Rights Reserved </p>
        </div>
      </section>
      <!-- END FOOTER -->
    </div>
    <!-- START OVERLAY SEARCH -->

    <!-- END OVERLAY SEARCH -->
    <!-- BEGIN CORE FRAMEWORK -->
    <script src="assets/plugins/pace/pace.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="pages/js/pages.image.loader.js"></script>
    <script type="text/javascript" src="assets/plugins/jquery/jquery-1.11.1.min.js"></script>
    <script type="text/javascript" src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>
    <!-- BEGIN SWIPER DEPENDENCIES -->
    <script type="text/javascript" src="assets/plugins/swiper/js/swiper.jquery.min.js"></script>
    <script type="text/javascript" src="assets/plugins/velocity/velocity.min.js"></script>
    <script type="text/javascript" src="assets/plugins/velocity/velocity.ui.js"></script>
    <script type="text/javascript" src="assets/plugins/vide/jquery.vide.min.js"></script>
    <script type="text/javascript" src="assets/plugins/vide/jquery.vide.min.js"></script>
    <!-- BEGIN RETINA IMAGE LOADER -->
    <script type="text/javascript" src="assets/plugins/jquery-unveil/jquery.unveil.min.js"></script>
    <!-- END VENDOR JS -->
    <!-- BEGIN PAGES FRONTEND LIB -->
    <script type="text/javascript" src="pages/js/pages.frontend.js"></script>
    <!-- END PAGES LIB -->
    <!-- BEGIN YOUR CUSTOM JS -->
    <script type="text/javascript" src="assets/js/custom.js"></script>
    <!-- END PAGES LIB -->
    <script src="administrator/assets/plugins/sweetalert/sweetalert.min.js"></script>
    <script src="administrator/assets/plugins/formvalidation/js/formValidation.min.js"></script>
    <script src="administrator/assets/plugins/formvalidation/js/framework/bootstrap.min.js"></script>
    <script type="text/javascript">
    $('#form-stokist').formValidation({
      fields: {
        password: {
          validators: {
              stringLength: {
                  min: 8,
                  message: 'Must be minimum 8 characters long '
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
        runfunction = save;
        saConfirm4("Daftar Ejen","Anda pasti maklumat yang dibekalkan adalah benar?","warning","Ya, Pasti",runfunction,"Pasti");
    });

    function save(){
      var myform = document.getElementById('form-stokist');
      var fd = new FormData(myform);
      fd.append("func","insertAgent");
      $.ajax({
          type: 'POST',
          url: "db?registerAgent",
          data: fd,
          dataType: "json",
          cache: false,
          contentType: false,
          processData: false,
          success: function(data) {
            if(data["STATUS"]){
              saAlert3("Berjaya",data["MSG"],"success");
              $('#form-stokist').formValidation("resetForm",true);
            } else {
              saAlert3("Gagal",data["MSG"],"warning");
            }
          },
          error: function(data) {
            // saAlert3("Error","Session Log Out Error","warning");
          }
      });
    }

    $('#form-order').formValidation({
    }).on('success.form.fv', function(e) {
        e.preventDefault();
        order();
    });

    function order(){
      $("#form-order").find("button").prop("disabled",true);
      var myform = document.getElementById('form-order');
      var fd = new FormData(myform);
      fd.append("func","OrderNow");
      fd.append("rpid",RPID);
      $.ajax({
          type: 'POST',
          url: "db?OrderNow",
          data: fd,
          dataType: "json",
          cache: false,
          contentType: false,
          processData: false,
          success: function(data) {
            if(data["STATUS"]){
              $("#form-order").find("button").prop("disabled",false);
              LINK = data["link"];
              // window.open(LINK, "_blank");
              window.location.assign(LINK);
            } else {
              // saAlert3("Gagal",data["MSG"],"warning");
            }
          },
          error: function(data) {
            // saAlert3("Error","Session Log Out Error","warning");
          }
      });
    }

    $(document).ready(function(e){
      var buyNOW = '<?php echo $buyPanel;?>';
      if (buyNOW == 'true') {
        $("#modalSlideUp").modal();
        $("#quantityOrder").val(1);
        getPrice();
      }
    });


    $("#form-order").find("input").change(function(e){
      getPrice();
    });

    var RPID = '<?php echo $rpid; ?>';

    $("[id='buyNow']").click(function(e){
      $("#modalSlideUp").modal();
      var quantity = $(this).attr("quantity");
      $("#quantityOrder").val(quantity);
      RPID = $(this).attr("rpid");
      getPrice();
    });

    $("#quantityOrder").change(function(e){
      getPrice();
    });

    var LINK = "";

    function getPrice(){
      $("#form-order").find("button").prop("disabled",true);
      var myform = document.getElementById('form-order');
      var fd = new FormData(myform);
      fd.append("func","whatsappOrder");
      fd.append("rpid",RPID);
      $.ajax({
          type: 'POST',
          url: "db?whatsappOrder",
          data: fd,
          dataType: "json",
          cache: false,
          contentType: false,
          processData: false,
          success: function(data) {
            if(data["STATUS"]){
              link = data["link"];
              rp_price = data["rp_price"];
              postagefee = data["postagefee"];
              total = data["total"];
              rp_name = data["rp_name"];
              LINK = link;

              $("#sTotal").html(rp_price);
              $("#sPostage").html(postagefee);
              $("#sGtotal").html(total);
              $("#productname").val(rp_name);
              $("#form-order").find("button").prop("disabled",false);


            } else {
              // saAlert3("Gagal",data["MSG"],"warning");
            }
          },
          error: function(data) {
            // saAlert3("Error","Session Log Out Error","warning");
          }
      });
    }

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
          imageUrl: "administrator/assets/img/loading3.gif",
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

    function getStokistList(){
      var fd = new FormData();
      fd.append("func","getStokistList");
      $.ajax({
          type: 'POST',
          url: "db?getStokistList",
          data: fd,
          dataType: "json",
          cache: false,
          contentType: false,
          processData: false,
          success: function(data) {
            $("#stokistlist").empty();
              $("#stokistlist").html(data);
            // $.each(data, function( index, value ) {
            //   $("#stokistlist").append(data[index]["html"]);
            // });
          },
          error: function(data) {
            // saAlert3("Error","Session Log Out Error","warning");
          }
      });
    }

    getStokistList();

    </script>

    <script type="text/javascript">
    // FOR PROMO FUNCTION ONLY

    $("[id='promoBuy']").click(function(e){
      var prod = $(this).attr("prod");
      // console.log("asd");
      $("#modalSlideUp").modal();
      $("#quantityOrder").val(1);
      RPID = prod;
      getPrice();
    });
    </script>
  </body>
</html>
