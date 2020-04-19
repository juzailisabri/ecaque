<?php include("administrator/formfunction.php"); ?>

<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
    <meta charset="utf-8" />
    <title>eCaque - Homemade Fruit Cake</title>
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
  </head>
  <body class="pace-dark">
    <!-- BEGIN HEADER -->
    <nav class="header bg-header transparent-dark " data-pages="header" data-pages-header="autoresize" data-pages-resize-class="dark">
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
                <a href="#" class="active  text-white">Home </a>
              </li>
              <li>
                <a class="text-white  active"href="pricing.html">Pricing </a>
              </li>
              <li>
                <a class="text-white  active"href="pricing.html">Where to Buy </a>
              </li>
              <li>
                <a class="text-white active"href="contact.html">Contact Us</a>
              </li>
            </ul>
            <a href="#" class="text-white search-toggle hidden-xs hidden-sm" data-toggle="search"><i class="fs-14 pg-search"></i></a>
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
      <section class="jumbotron full-vh" data-pages="parallax">
        <div class="inner full-height">
          <!-- BEGIN SLIDER -->
          <div class="swiper-container" id="hero">
            <div class="swiper-wrapper">
              <!-- BEGIN SLIDE -->
              <div class="swiper-slide fit">
                <!-- BEGIN IMAGE PARRALAX -->
                <div class="slider-wrapper">
                  <div class="background-wrapper" data-swiper-parallax="30%">
                    <!-- YOUR BACKGROUND IMAGE HERE, YOU CAN ALSO USE IMG with the same classes -->
                    <div class="background" data-pages-bg-image="assets/slider/slider3.jpg"></div>
                  </div>
                </div>
                <!-- END IMAGE PARRALAX -->
                <!-- BEGIN CONTENT -->
                <div class="content-layer">
                  <div class="inner full-height">
                    <div class="container-xs-height full-height">
                      <div class="col-xs-height col-bottom text-left">
                        <div class="container ">
                          <div class="col-md-offset-6a col-md-12  m-b-100 col-xs-12 ">
                            <!-- <h1 class="hidden-sm hidden-xs text-white sm-text-center no-padding no-margin" data-swiper-parallax="-15%">Rasai keenakkannya... <br>Pasti sedap..  pasti nak lagi! <br> Kek Buah Kukus eCaque</h1>
                            <h1 class="hidden-sm visible-xs text-white sm-text-center no-padding no-margin" data-swiper-parallax="-15%">Rasai keenakkannya... <br>Pasti sedap..  pasti nak lagi! <br> Kek Buah Kukus eCaque</h1>
                            <h2 class="visible-sm text-white sm-text-center no-padding no-margin" data-swiper-parallax="-15%">Rasai keenakkannya... <br>Pasti sedap..  pasti nak lagi! <br> Kek Buah Kukus eCaque</h2>
                            <hr class="">
                            <h5 class="block-title text-white sm-text-center">KEK BUAH KUKUS eCAQUE</h5>
                            <p class="hidden-xs hidden-sm text-white" style="text-align: justify;">Kek buah kukus Ecaque adalah satu produk muslim homemade yang telah dipasarkan bermula dari tahun 2016. Dihasilkan mengikut resepi asal pemiliknya, Pn Faridah Borham, ianya diadun menggunakan bahan-bahan yang berkualiti tinggi .Kek buah ini dikukus selama 4 jam untuk menghasilkn kek yang lebih tahan lama. Struktur kek yang moist, tidak terlalu manis dengan gabungan aroma butter , caramel dan buah-buahan campuran kering serta tiada bahan pengawet. Ia amat sesuai dihidangkan untuk minum petang, majlis-majlis dan dihadiahkn kepada yang tersayang.</p> -->
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- END CONTENT -->
              </div>
              <!-- END SLIDE -->
              <!-- BEGIN SLIDE -->
              <div class="swiper-slide fit">
                <!-- BEGIN IMAGE PARRALAX -->
                <div class="slider-wrapper">
                  <div class="background-wrapper" data-swiper-parallax="30%">
                    <!-- YOUR BACKGROUND IMAGE HERE, YOU CAN ALSO USE IMG with the same classes -->
                    <div data-pages-bg-image="assets/images/hero_2.jpeg" draggable="false" class="background"></div>
                  </div>
                </div>
                <!-- END IMAGE PARRALAX -->
                <!-- BEGIN CONTENT -->
                <div class="content-layer">
                  <div class="inner full-height">
                    <div class="container-xs-height full-height">
                      <div class="col-xs-height col-middle text-left">
                        <div class="container">
                          <div class="col-md-6 no-padding col-xs-10 col-xs-offset-1">
                            <h1 class="light sm-text-center" data-swiper-parallax="-15%"> Twenty & Counting... Unique Website Templates</h1>
                            <h4 class="sm-text-center">Save time, save money, look more professional and win more clients.</h4>
                            <h5 class="block-title text-white sm-text-center">Behind the scenes watch tour</h5>
                            <p class="fs-12 font-arial hint-text sm-text-center">Available at themeforest, envato market place.</p>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- END CONTENT -->
              </div>
              <!-- END SLIDE -->
              <!-- BEGIN SLIDE -->
              <div class="swiper-slide fit">
                <!-- BEGIN IMAGE PARRALAX -->
                <div class="slider-wrapper">
                  <div class="background-wrapper" data-swiper-parallax="30%">
                    <div data-pages-bg-image="assets/images/hero_5.jpeg" draggable="false" class="background"></div>
                  </div>
                </div>
                <!-- END IMAGE PARRALAX -->
                <!-- BEGIN CONTENT -->
                <div class="content-layer">
                  <div class="inner full-height">
                    <div class="container-xs-height full-height">
                      <div class="col-xs-height col-middle text-left">
                        <div class="container">
                          <div class="col-sm-6 col-sm-offset-3 text-center">
                            <h1 class="light" data-swiper-parallax="-15%">Simplicity beats confusion
                                        </h1>
                            <p class="fs-12 font-arial hint-text">Available at themeforest, envato market place.</p>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- END CONTENT -->
              </div>
              <!-- END SLIDE -->
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
      <!-- END JUMBOTRON -->
      <!-- BEGIN CONTENT SECTION -->
      <section class=" p-b-85 p-t-75 no-overflow">
        <div class="container">
          <div class="md-p-l-20 md-p-r-20 xs-no-padding">
            <h5 class="block-title hint-text no-margin">PENGENALAN</h5>
            <div class="row">
              <div class="col-sm-12">
                <h1 class="m-t-5 m-b-20">KEK BUAH KUKUS eCAQUE</h1>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-10">
                <p class="m-b-20 text-justify">Kek buah kukus Ecaque adalah satu produk muslim homemade yang telah dipasarkan bermula dari tahun 2016. Dihasilkan mengikut resepi asal pemiliknya, Pn Faridah Borham, ianya diadun menggunakan bahan-bahan yang berkualiti tinggi. Kek buah ini dikukus selama 4 jam untuk menghasilkn kek yang lebih tahan lama. Struktur kek adalah moist, tidak terlalu manis dengan gabungan aroma butter, caramel dan buah-buahan campuran kering serta tiada bahan pengawet. Ia amat sesuai dihidangkan untuk minum petang, majlis-majlis dan dihadiahkn kepada yang tersayang.</p>
              </div>

            </div>
            <div class="row">
              <div class="col-sm-12">
              </div>
            </div>
            <div class="row">
              <div class="col-sm-5">
                <img src="assets/ecauqe_images/packaging_1.jpg" class="m-b-20" width="100%" alt="">

                <p class="hint-text font-arial text-black bold small-text no-padding no-margin">Cara Penyimpanan / Storage Condition:</p>
                <p class="m-b-20 text-justify">Simpan yang optimum adalah disimpan di dalam tempat yang sejuk dan kering untuk membenarkan kek untuk bertahan hingga 4 bulan. kek akan bertahan selama 2 bulan jika disimpan pada suhu bilik</p>

              </div>
              <div class="col-sm-5 no-padding xs-p-l-15 xs-p-r-15 p-l-20">

                <p class="hint-text font-arial text-black bold small-text no-padding no-margin">Berat: </p>
                <p class="m-b-20">1.0 Kilogram / 1000 gram</p>

                <p class="hint-text font-arial text-black bold small-text no-padding no-margin">Ukuran Kek: </p>
                <p class="m-b-20">6 inch x 6 inch</p>

                <p class="hint-text font-arial text-black bold small-text no-padding no-margin">Keistimewaan</p>
                <ul class="p-l-20 p-t-0 m-t-0">
                  <li><p>Tekstur Kek Moist, Gebu Kerana Dihasilkan Dengan Menggunakan Cara Kukus</p></li>
                  <li><p>Boleh Bertahan Selama 2 Bulan Pada Suhu Bilik</p></li>
                  <li><p>Kotak Eksklusif Sesuai Untuk Hadiah</p></li>
                  <li><p>Ramuan Yang Digunakan Adalah Premium</p></li>
                  <li><p>Menggunakan Pure Butter Jenama Anchor</p></li>
                  <li><p>Tiada Sebarang Bahan Pengawet</p></li>
                  <li><p>Produk Kek Kukus Termasuk Bekas Tertutup Diberikan Secara Percuma</p></li>
                </ul>
                <p class="hint-text font-arial text-black bold small-text no-padding no-margin">Bahan-bahan: </p>
                <p class="m-b-20 text-justify" >100% mentega tulen, Tepung Gandum Penuh Berprotein Tinggi,  Gula pasir, Buah-buahan Campuran Bermutu Tinggi dan Telur Gred A</p>
              </div>
            </div>
          </div>
        </div>
      </section>
      <!-- END CONTENT SECTION -->
      <!-- BEGIN CONTENT SECTION -->
      <section class="bg-master-lightest p-b-85 p-t-75">
        <div class="container">
          <div class="md-p-l-20 md-p-r-20 xs-no-padding">
            <h5 class="block-title hint-text no-margin">Pencarian Agen Stokis</h5>
            <div class="row">
              <div class="col-sm-6">
                <h1 class="m-t-5">Anda memerlukan pendapatan tambahan? </h1>
              </div>
              <div class="col-sm-7 col-md-5 no-padding xs-p-l-15 xs-p-r-15">
                <div class="p-t-20 p-l-35 md-p-l-5 md-p-t-15">
                  <p class="text-justify">Sertai program Agen Stokist kami dengan segera untuk menjana duit lebih bersama kami. Berminat? Sila daftar sebagai Agen Stokis kami dan mulakan bisness anda dari mana anda berada. </p>
                  <!-- <p>
                    <button type="button" class="btn btn-primary" name="button">Daftar Ejen Stokis</button>
                  </p> -->
                  <!-- <p class="hint-text font-arial small-text col-md-7 no-padding">
                  </p> -->
                </div>
              </div>
            </div>

          </div>


        </div>
      </section>

      <section class="bg-master-dark p-b-85 p-t-75">
        <div class="container">
          <div class="md-p-l-20 md-p-r-20 xs-no-padding">
            <h5 class="block-title text-white hint-text no-margin">Ejen Stokis eCaque</h5>
            <div class="row">
              <div class="col-md-12">
                <h1 class="light text-white m-b-0 p-b-0">Pendaftaran Ejen Stokis eCaque</h1>
                <h4 class="text-white m-t-0 p-t-0">Daftar jika ingin membuat pendapatan tambahan bersama kami</h4>
              </div>
            </div>
            <div class="row">
              <div class="col-md-7">
                <form class="m-t-25 m-b-20">
                  <div class="row">
                    <div class="col-md-7">
                      <div class="form-group form-group-default input-group no-bordera input-group-attached col-xs-12">
                        <label class="control-label">Nama Penuh</label>
                        <input id="fullname" name="fullname" type="text" class="form-control" placeholder="">
                      </div>
                    </div>
                    <div class="col-md-5 ">
                      <div class="form-group form-group-default input-group no-bordera input-group-attached col-xs-12">
                        <label class="control-label">No. Kad Pengenalan</label>
                        <input id="identificationNo" name="identificationNo" type="text" class="form-control" placeholder="XXXXXX-XX-XXXX">
                      </div>
                    </div>
                  </div>
                  <div class="row m-t-5">
                    <div class="col-md-4">
                      <div class="form-group form-group-default input-group no-bordera input-group-attached col-xs-12">
                        <label class="control-label">Jantina</label>
                        <select id="jantina" name="jantina" class="form-control" >
                          <?php getJantina(); ?>
                        </select>
                        <!-- <input type="fullname" class="form-control" placeholder="johnsmith@abc.com"> -->
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group form-group-default input-group no-bordera input-group-attached col-xs-12">
                        <label class="control-label">Warganegara</label>
                        <select id="nationality" name="nationality" class="form-control" >
                          <?php getNegara(); ?>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group form-group-default input-group no-bordera input-group-attached col-xs-12">
                        <label class="control-label">Bangsa</label>
                        <select id="bangsa" name="bangsa" class="form-control" >
                          <?php getKeturunan(); ?>
                        </select>
                      </div>
                    </div>
                  </div>

                  <h5 class="text-white block-title">Alamat Surat Menyurat</h5>

                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group form-group-default input-group no-bordera input-group-attached col-xs-12">
                        <label class="control-label">Alamat Premis</label>
                        <input id="alamat" name="alamat" type="text" class="form-control" placeholder="">
                      </div>
                    </div>
                  </div>
                  <div class="row m-t-5">
                    <div class="col-md-4">
                      <div class="form-group form-group-default input-group no-bordera input-group-attached col-xs-12">
                        <label class="control-label">Bandar</label>
                        <input id="bandar" name="bandar" type="text" class="form-control" placeholder="">
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group form-group-default input-group no-bordera input-group-attached col-xs-12">
                        <label class="control-label">Negeri</label>
                        <select id="negeri" name="negeri" class="form-control" >
                          <?php getNegeri(); ?>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group form-group-default input-group no-bordera input-group-attached col-xs-12">
                        <label class="control-label">Poskod</label>
                        <input id="poskod" name="poskod" type="text" class="form-control" placeholder="">
                      </div>
                    </div>
                  </div>

                  <h5 class="text-white block-title">Maklumat Telekomunikasi</h5>

                  <div class="row">
                    <div class="col-md-7">
                      <div class="form-group form-group-default input-group no-bordera input-group-attached col-xs-12">
                        <label class="control-label">Alamat emel</label>
                        <input id="email" name="email" type="text" class="form-control" placeholder="">
                      </div>
                    </div>
                    <div class="col-md-5">
                      <div class="form-group form-group-default input-group no-bordera input-group-attached col-xs-12">
                        <label class="control-label">No. Telefon</label>
                        <input id="phone" name="phone" type="text" class="form-control" placeholder="">
                      </div>
                    </div>
                  </div>

                  <h5 class="text-white block-title">Maklumat Media Sosial</h5>

                  <div class="row">
                    <div class="col-md-4">
                      <div class="form-group form-group-default input-group no-bordera input-group-attached col-xs-12">
                        <label class="control-label">Facebook</label>
                        <input id="facebook" name="facebook" type="text" class="form-control" placeholder="">
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group form-group-default input-group no-bordera input-group-attached col-xs-12">
                        <label class="control-label">Instagram</label>
                        <input id="instagram" name="instagram" type="text" class="form-control" placeholder="">
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group form-group-default input-group no-bordera input-group-attached col-xs-12">
                        <label class="control-label">linkedin</label>
                        <input id="linkedin" name="linkedin" type="text" class="form-control" placeholder="">
                      </div>
                    </div>
                  </div>


                  <h5 class="text-white block-title">Pengakuan</h5>
                  <div class="row">
                    <div class="col-md-12">
                      <p class="text-white">
                        Saya dengan ini mengaku bahawa segala maklumat yang diberikan di atas adalah benar dan tepat. Saya juga bersetuju untuk mematuhi syarat-syarat dan peraturan-peraturan yang telah ditetapkan oleh pihak ECAQUE ENTERPRISE
                      </p>
                    </div>
                  </div>

                  <div class="row m-t-20">
                    <div class="col-md-12">
                      <button type="button" class="btn btn-primary" name="button">Daftar Ejen Stokis <i class="fa fa-send m-l-5"></i></button>
                    </div>
                  </div>
                </form>
              </div>
              <div class="col-md-5 m-t-10">
                <h4 class="text-white">Do</h4>
                <ul class="text-white">
                  <li>Hanya ejen yang berdaftar secara sah di bawah eCaque Enterprise sahaja dibenarkan untuk berhubung terus dengan pihak HQ di mana kami akan memberi tip-tip dan panduan serta tunjuk ajar bagi memasarkan produk eCaque.</li>
                  <li>Untuk tujuan pemasaran, ejen dibenarkan untuk menggunakan platform seperti  FB Personal, FB Ads, Instagram, group-group business, personal wall, e-commerce personal, blog personal, google ads, website personal, group WeChat, group WhatsApp dan lain-lain.</li>
                  <li>Ejen adalah <b>DIBENARKAN</b> untuk melantik staff jualan bagi tujuan membuat pemasaran secara dalam talian (online) atau secara jualan langsung (offline)</li>
                  <li>Ejen <b>DIWAJIBKAN</b> untuk mengambil stok sekurang-kurangnya <b>LIMA(5) KOTAK</b> untuk setiap pesanan stok.</li>
                </ul>
                <h4 class="text-white">Don't</h4>
                <ul class="text-white">
                  <li>Ejen adalah <b>TIDAK DIBENARKAN</b> untuk menjual di <b>PLATFORM MARKETPLACE</b> seperti di Shopee, Mudah.my, Lazada, marketplace FB dan lain-lain. Ini bagi mengelakkan berlakunya isu salah faham mengenai harga oleh pelanggan.</li>
                  <li><b>DILARANG</b> mengubah harga secara sengaja atau tidak sengaja tanpa kebenaran pihak HQ.</li>
                  <li>Ejen <b>DILARANG</b> melakukan apa-apa tindakan berunsurkan sabotaj atau perkara-perkara yang boleh menjatuhkan reputasi HQ / Pemilik eCaque / Ejen / pelanggan Ecaque.</li>
                  <li><b>DILARANG</b> menjual kepada pihak ketiga seperti Pemborong, Kedai Kek, Bazaar Expo dan sebagainya.</li>
                </ul>
              </div>
          </div>
        </div>

        </div>
      </section>


      <!-- END CONTENT SECTION -->
      <!-- BEGIN CONTENT SECTION -->
      <section class="p-b-85 p-t-75 p-b-65 p-t-55  bg-master-lighter">
        <div class="container">
          <div class="md-p-l-20 xs-no-padding clearfix">
            <div class="col-sm-4 no-padding">
              <div class="p-r-40 md-pr-30">
                <!-- <img alt="" class="m-b-20" src="assets/images/Parachute.svg"> -->
                <h6 class="block-title p-b-5">Content Material  <i class="pg-arrow_right m-l-10"></i></h6>
                <p class="m-b-30">Content Material Akan diberikan kepada anda untuk memudahkan anda untuk penerangan maklumat produk kepada pelanggan-pelanggan anda.</p>
              </div>
              <div class="visible-xs b-b b-grey-light m-t-30 m-b-30"></div>
            </div>
            <div class="col-sm-4 no-padding">
              <div class="p-r-40 md-pr-30">
                <!-- <img alt="" class="m-b-20" src="assets/images/Prizemedalion.svg"> -->
                <h6 class="block-title p-b-5">Guideline<i class="pg-arrow_right m-l-10"></i></h6>
                <p class="m-b-30">Kami akan berikan panduan kepada anda bagaimana cara-cara yang membolehkan tuan/puan untuk mendapatkan jualan.</p>
                <!-- <p class="muted font-arial small-text col-sm-9 no-padding">Limitless possibilities, Highly customizable, Great UI & UX</p> -->
              </div>
              <div class="visible-xs b-b b-grey-light m-t-30 m-b-30"></div>
            </div>
            <div class="col-sm-4 no-padding">
              <div class="p-r-40 md-pr-30">
                <!-- <img alt="" class="m-b-20" src="assets/images/Umbrella.svg"> -->
                <h6 class="block-title p-b-5">Coaching Online & Offline <i class="pg-arrow_right m-l-10"></i></h6>
                <p class="m-b-30">Pihak tuan/puan boleh menghubungi atau datang berjumpa dengan kami untuk mendapatkan khidmat coaching bagi melancarkan lagi proses marketing & jualan anda.</p>
                <!-- <p class="muted font-arial small-text col-sm-9 no-padding">Highly customizable NVD3, rickshaw, Spark Lines, D3.</p> -->
              </div>
            </div>
          </div>
          <div class="md-p-l-20 m-t-30 xs-no-padding clearfix">
            <div class="col-sm-4 no-padding">
              <div class="p-r-40 md-pr-30">
                <!-- <img alt="" class="m-b-20" src="assets/images/Parachute.svg"> -->
                <h6 class="block-title p-b-5">Group Whatsapp dan FB <i class="pg-arrow_right m-l-10"></i></h6>
                <p class="m-b-30">Group diwujudkan bagi memudahkan pihak Tuan/Puan untuk merujuk sesuatu daripada pihak HQ berkenaan produk kek buah eCaque</p>
                <!-- <p class="muted font-arial small-text col-sm-9 no-padding">Icon Fonts, Vector SVG's, pages 14x14px vector icons.</p> -->
              </div>
              <div class="visible-xs b-b b-grey-light m-t-30 m-b-30"></div>
            </div>
            <div class="col-sm-4 no-padding">
              <div class="p-r-40 md-pr-30">
                <!-- <img alt="" class="m-b-20" src="assets/images/Prizemedalion.svg"> -->
                <h6 class="block-title p-b-5">Bonus Duit Raya <i class="pg-arrow_right m-l-10"></i></h6>
                <p class="m-b-30">Berita baik untuk stokis yang mencapai jualan yang ditetapkan oleh pihak HQ akan memperolehi bonus sempena hari raya 2020.</p>
                <!-- <p class="muted font-arial small-text col-sm-9 no-padding">Limitless possibilities, Highly customizable, Great UI & UX</p> -->
              </div>
              <div class="visible-xs b-b b-grey-light m-t-30 m-b-30"></div>
            </div>
            <div class="col-sm-4 no-padding">
              <div class="p-r-40 md-pr-30">
                <!-- <img alt="" class="m-b-20" src="assets/images/Umbrella.svg"> -->
                <h6 class="block-title p-b-5">Produk Senang Dijual <i class="pg-arrow_right m-l-10"></i></h6>
                <p class="m-b-30">Produk Kek Kukus eCaque sangat senang dijual kerana rasa kek buah yang sangat diminati ramai dijual dengan harga yang berpatutan.</p>
                <!-- <p class="muted font-arial small-text col-sm-9 no-padding">Highly customizable NVD3, rickshaw, Spark Lines, D3.</p> -->
              </div>
            </div>
          </div>
        </div>
      </section>
      <!-- END CONTENT SECTION -->

      <!-- BEGIN CONTENT SECTION -->
      <!-- <section class="p-b-85 p-t-75 bg-master-lighter">
        <div class="container">
          <div class="md-p-l-20 xs-no-padding clearfix">
            <div class="row visible-sm">
              <div class="col-sm-8 m-b-40">
                <h2>Save time, save money, look more professional and win more clients.</h2>
                <p class="hint-text font-arial small-text col-md-4 col-sm-6 no-padding">Via Senior Vice President Design REVOX Ltd. 12345</p>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4 col-sm-4">
                <div class="device_morph" data-pages="auto-scroll">
                  <img alt="" class="xs-image-responsive-height image-responsive-width" src="assets/images/b_phone.png" id="mobile_phone">
                  <div class="screen">
                    <div class="iphone-border">
                      <img src="assets/images/mobile_preview.jpg" class="image-responsive-height lazy" alt="">
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-7 col-md-offset-1  col-sm-offset-2 col-sm-6">
                <div class="clearfix hidden-sm">
                  <h2>Save time, save money, look more professional and win more clients.</h2>
                  <p class="hint-text font-arial small-text col-md-4 col-sm-6 no-padding">Via Senior Vice President Design REVOX Ltd. 12345</p>
                </div>
                <div class="col-md-9 col-md-offset-1 col-sm-11">
                  <div class="p-t-50">
                    <dl>
                      <dt class="block-title p-b-15 text-black">Launch Design <i class="pg-arrow_right m-l-10"></i></dt>
                      <dd class="m-b-30">Our long standing vision has been to bypass the usual admin dashboard structure, and move forward with a more sophisticated yet simple framework</dd>
                    </dl>
                    <dl>
                      <dt class="block-title p-b-15 text-black">Responsive <i class="pg-arrow_right m-l-10"></i></dt>
                      <dd class="m-b-30">Our long standing vision has been to bypass the usual admin dashboard structure, and move forward with a</dd>
                    </dl>
                    <dl>
                      <dt class="block-title text-black p-b-15 ">Launch Your Design <i class="pg-arrow_right m-l-10"></i></dt>
                      <dd class="m-b-30">Our long standing vision has been to bypass the usual admin dashboard structure.</dd>
                    </dl>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section> -->
      <!-- END CONTENT SECTION -->
      <section class=" p-b-85 p-t-75 no-overflow">
        <div class="container">
          <div class="md-p-l-20 md-p-r-20 xs-no-padding">
            <h5 class="block-title hint-text no-margin">Frequent Ask Question</h5>
            <div class="row">
              <div class="col-sm-12">
                <h1 class="m-t-5 m-b-20">SOALAN LAZIM</h1>
              </div>
            </div>
            <div class="row">

              <div class="col-sm-5 xs-p-l-15 xs-p-r-15">
                <p class=" font-arial no-padding no-margin">BERAPA LAMA KEK DAPAT BERTAHAN / Expiry</p>
                <p class="bold text-black m-b-20">2 Bulan jika disimpan pada suhu bilik & 4 Bulan jika disimpan ditempat yang sejuk & kering.</p>

                <p class=" font-arial no-padding no-margin">BERAT PRODUK / Product weight</p>
                <p class="bold text-black m-b-20">Berat kek adalah 1 Kilogram bersamaan 1000 gram</p>

                <!-- <p class=" font-arial no-padding no-margin">SIJIL HALAL / Halal Certificate</p>
                <p class="bold text-black m-b-20">Tiada, Produk Dihasilkan Dirumah</p> -->

                <p class=" font-arial no-padding no-margin">BAHAN ADA SIJIL HALAL / Ingredients Halal Certificate</p>
                <p class="bold text-black m-b-20">Ya, Semua Ramuan Mempunyai Sijil Halal</p>

                <p class=" font-arial no-padding no-margin">ADAKAH PRODUK BOLEH DI POS / Is the product can be deliver via courier</p>
                <p class="bold text-black m-b-20">Ya, Produk Boleh Di Pos</p>



              </div>
              <div class="col-sm-5 xs-p-l-15 xs-p-r-15">
                <p class=" font-arial no-padding no-margin">CARA PEMBUATAN / ways of making</p>
                <p class="bold text-black m-b-20">Kek Dikukus selama 4 jam untuk memastikan kek boleh tahan lama.</p>

                <p class=" font-arial no-padding no-margin">PRODUK BUMIPUTRA / Bumi Product</p>
                <p class="bold text-black m-b-20">Ya, eCaque Enterprise dimiliki penuh oleh Pn. Faridah Borham.</p>

                <p class=" font-arial no-padding no-margin">CARA PENYIMPANAN / Storage Condition</p>
                <p class="bold text-black m-b-20">Simpan Di Tempat Yang Sejuk Dan Kering</p>

                <p class=" font-arial no-padding no-margin">PRODUK BERASAL DARI MANA / Origin of Product</p>
                <p class="bold text-black m-b-20">Sungai Besar, Selangor</p>
              </div>
            </div>
          </div>
        </div>
      </section>
      <section class="p-b-85 p-t-75 ">
        <!-- BEGIN TESTIMONIALS SLIDER-->
        <div class="swiper-container" id="testimonials_slider">
          <div class="swiper-wrapper">
            <!-- BEGIN TESTIMONIAL -->
            <div class="swiper-slide">
              <div class="container">
                <div class="col-sm-8 col-sm-offset-2">
                  <h3 class="text-center">
                            Dah banyak saya cuba tapi kek ni paling sedap dan moist keknya… saya brpuas hati sangat, keknya rasanya sedap.. keknya di potong tak berderai...manisnya pun cukup.. Sekarang saya nak order lagi, 3pek <br> <small>- Ema Shadan (Brunei)</small>
                            </h3>
                  <!-- <img alt="" class="m-t-20" src="assets/images/signature_sample.png"> -->
                </div>
              </div>
            </div>
            <!-- END TESTIMONIAL -->
            <!-- BEGIN TESTIMONIAL -->
            <div class="swiper-slide">
              <div class="container">
                <div class="col-sm-8 col-sm-offset-2">
                  <h3 class="text-center">
                            Alhamdulillah sedap sungguh kek buah ni. Makannya pun tak jemu sebab tidak terlalu manis. <br> <small>– Nurdin (Alor Setar, Kedah)</small>
                            </h3>
                  <!-- <img alt="" class="m-t-20" src="assets/images/signature_sample.png"> -->
                </div>
              </div>
            </div>
            <!-- END TESTIMONIAL -->
            <!-- BEGIN TESTIMONIAL -->
            <div class="swiper-slide">
              <div class="container">
                <div class="col-sm-8 col-sm-offset-2">
                  <h3 class="text-center">
                            Saya sudah beli 5 biji,4 biji saya bagi emak dan akak-akak, menyesal saya cuma 1 biji sahaja sebab dah habis separuh sebelum raya… Saya dan suami tidak jemu makan kek  ni, tidak ada sama kek buah yang lain yang pernah saya makan sebelum ni..  Betul2 sedap <br> <small>– Hjh Zuraidah (Brunei)</small>
                            </h3>
                  <!-- <img alt="" class="m-t-20" src="assets/images/signature_sample.png"> -->
                </div>
              </div>
            </div>
            <div class="swiper-slide">
              <div class="container">
                <div class="col-sm-8 col-sm-offset-2">
                  <h3 class="text-center">
                            Dah makan pun. Allah, sedap betul kek buah nii. Rasa moist dan bau butternya. Buah pun banyak. Sedap sungguh! <br> <small>- Pn Norida Mohamed (Subang, Selangor)</small>
                            </h3>
                  <!-- <img alt="" class="m-t-20" src="assets/images/signature_sample.png"> -->
                </div>
              </div>
            </div>
            <div class="swiper-slide">
              <div class="container">
                <div class="col-sm-8 col-sm-offset-2">
                  <h3 class="text-center">
                            Saya dengar cerita sedap kek ni, saya pun beli lah 1 bekas.. Subhanallah memang sedap rasanya lembut dan moist lembab rasa kek tu.. penuh buahnya… Tak cukup satu nak lagi..  <br> <small>- Wadiananty Abdullah (Miri, Sarawak)</small>
                            </h3>
                  <!-- <img alt="" class="m-t-20" src="assets/images/signature_sample.png"> -->
                </div>
              </div>
            </div>
            <div class="swiper-slide">
              <div class="container">
                <div class="col-sm-8 col-sm-offset-2">
                  <h3 class="text-center">
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
      <section class="p-b-55 p-t-75 xs-p-b-20 bg-master-darker ">
        <div class="container">
          <div class="row">
            <div class="col-sm-4 col-xs-12 xs-m-b-40">
              <img src="assets/images/Logo_2020_White.png" width="300"  data-src-retina="assets/images/Logo_2020_White.png" class="alt" alt="">
            </div>
            <!-- <div class="col-sm-2 col-xs-6 xs-m-b-20">
              <h6 class="font-montserrat text-uppercase fs-14 text-white p-b-10">Company </h6>
              <ul class="no-style">
                <li class="m-b-5 no-padding"><a href="#" class="link text-white ">Design</a></li>
                <li class="m-b-5 no-padding"><a href="#" class="link text-white">Features</a></li>
                <li class="m-b-5 no-padding"><a href="#" class="link text-white">Team</a></li>
                <li class="m-b-5 no-padding"><a href="#" class="link text-white">Work Station</a></li>
                <li class="m-b-5 no-padding"><a href="#" class="link text-white">Privacy</a></li>
                <li class="m-b-5 no-padding"><a href="#" class="link text-white">Legal</a></li>
                <li class="m-b-5 no-padding"><a href="#" class="link text-white">Jobs</a></li>
              </ul>
            </div>
            <div class="col-sm-2 col-xs-6 xs-m-b-20">
              <h6 class="font-montserrat text-uppercase fs-14 text-white p-b-10">Work </h6>
              <ul class="no-style">
                <li class="m-b-5 no-padding"><a href="#" class="link text-white ">Apps</a></li>
                <li class="m-b-5 no-padding"><a href="#" class="link text-white ">Popular</a></li>
                <li class="m-b-5 no-padding"><a href="#" class="link text-white ">Web-Arch</a></li>
                <li class="m-b-5 no-padding"><a href="#" class="link text-white">Pages</a></li>
                <li class="m-b-5 no-padding"><a href="#" class="link text-white">Frontend</a></li>
                <li class="m-b-5 no-padding"><a href="#" class="link text-white">Charity</a></li>
                <li class="m-b-5 no-padding"><a href="#" class="link text-white">Marketplaces</a></li>
              </ul>
            </div>
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
    <div class="overlay hide" data-pages="search">
      <!-- BEGIN Overlay Content !-->
      <div class="overlay-content full-height has-results">
        <!-- END Overlay Header !-->
        <div class="container relative full-height">
          <!-- BEGIN Overlay Header !-->
          <div class="container-fluid">
            <!-- BEGIN Overlay Close !-->
            <a href="#" class="close-icon-light overlay-close text-black fs-16 top-right">
              <i class="pg-close_line"></i>
            </a>
            <!-- END Overlay Close !-->
          </div>
          <div class="container-fluid">
            <div class="inline-block bottom-right m-b-30">
              <div class="checkbox right">
                <input id="checkboxn" type="checkbox" value="1" checked="checked">
                <label for="checkboxn">Search within page</label>
              </div>
            </div>
          </div>
          <div class="container-xs-height full-height">
            <div class="col-xs-height col-middle text-center">
              <!-- BEGIN Overlay Controls !-->
              <input id="overlay-search" class="no-border overlay-search bg-transparent col-sm-6 col-sm-offset-4" placeholder="Search..." autocomplete="off" spellcheck="false">
              <br>
              <div class="inline-block bottom-left m-l-10 m-b-30 hidden-xs">
                <p class="fs-14"><i class="fa fa-search m-r-10"></i> Press enter to search</p>
              </div>
              <!-- END Overlay Controls !-->
            </div>
          </div>
        </div>
      </div>
      <!-- END Overlay Content !-->
    </div>
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
    <!-- BEGIN RETINA IMAGE LOADER -->
    <script type="text/javascript" src="assets/plugins/jquery-unveil/jquery.unveil.min.js"></script>
    <!-- END VENDOR JS -->
    <!-- BEGIN PAGES FRONTEND LIB -->
    <script type="text/javascript" src="pages/js/pages.frontend.js"></script>
    <!-- END PAGES LIB -->
    <!-- BEGIN YOUR CUSTOM JS -->
    <script type="text/javascript" src="assets/js/custom.js"></script>
    <!-- END PAGES LIB -->
  </body>
</html>
