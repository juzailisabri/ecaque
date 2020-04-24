<?php
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
//Load Composer's autoloader
include("conn.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function email($toemail,$toname,$body,$subject){
  require_once 'PHPMailer/src/Exception.php';
  require_once 'PHPMailer/src/PHPMailer.php';
  require_once 'PHPMailer/src/SMTP.php';

  $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
  try {
      //Server settings
      $mail->SMTPDebug = 0;                                 // Enable verbose debug output
      $mail->isSMTP();                                      // Set mailer to use SMTP
      $mail->Host = 'baboon.mschosting.com';  // Specify main and backup SMTP servers
      $mail->SMTPAuth = true;                               // Enable SMTP authentication
      $mail->Username = 'no-reply@ecaque.my';                 // SMTP username
      $mail->Password = 'a}TdE@f2Uku%';                            // SMTP password
      //$mail->SMTPSecure = 'tls';
      // $mail->SMTPAutoTLS = false;                      // Enable TLS encryption, `ssl` also accepted
      $mail->Port = 587;                                // TCP port to connect to
      //Recipients
      $mail->setFrom('no-reply@ecaque.my', 'eCaque No-Reply');
      $mail->addAddress($toemail, $toname);     // Add a recipient
      //Attachments
      // $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
      // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
      //Content
      $mail->isHTML(true);                                  // Set email format to HTML
      $mail->Subject = $subject;
      $mail->Body    = $body;
      // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

      $mail->send();
      return true;
  } catch (Exception $e) {
      return $mail->ErrorInfo;
  }
}

$logoUrl = "$http://".$_SERVER["HTTP_HOST"]."$rootdir/assets/images/Logo_2020_Black_Large.png";
$slider = "$http://".$_SERVER["HTTP_HOST"]."$rootdir/assets/slider/Slider3.jpg";
$header = '<!DOCTYPE html> <html lang="en" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office"> <head> <meta charset="utf-8"> <meta http-equiv="x-ua-compatible" content="ie=edge"> <meta name="viewport" content="width=device-width, initial-scale=1"> <meta name="x-apple-disable-message-reformatting"> <meta content="#E9EBEE" name="sr bgcolor"> <title>Roll - Marketing Email Notifications</title> <style type="text/css"> @import url("https://fonts.googleapis.com/css?family=Quicksand:400,500,700|Roboto:300,400,700&display=swap"); @media only screen { .col, td, th, div, p { font-family: -apple-system, system-ui, BlinkMacSystemFont, "Segoe UI", "Roboto", "Helvetica Neue", Arial, sans-serif; } .quicksand { font-family: "Quicksand", Arial, Helvetica, sans-serif; } .roboto { font-family: "Roboto", Arial, sans-serif; } /* h1 { font-family: "Quicksand", Arial, sans-serif; font-size: 34px; line-height: 40px; font-weight: 700; margin: 0; } h2 { font-family: "Quicksand", Arial, sans-serif; font-size: 22px; line-height: 28px; font-weight: 700; margin: 0; } h3 { font-family: "Quicksand", Arial, sans-serif; font-size: 18px; line-height: 22px; font-weight: 700; text-transform: uppercase; margin: 0; } p { font-family: "Roboto", Arial, sans-serif; font-size: 14px; line-height: 24px; font-weight: 400; margin: 0; } a { font-family: "Roboto", Arial, sans-serif; font-size: 12px; line-height: 18px; font-weight: 400; text-decoration: underline; } */ } #outlook a { padding: 0; } img { border: 0; line-height: 100%; vertical-align: middle; } .col { font-size: 16px; line-height: 26px; vertical-align: top; } @media only screen and (max-width: 730px) { .wrapper img { max-width: 100%; } u~div .wrapper { min-width: 100vw; } .container { width: 100% !important; -webkit-text-size-adjust: 100%; } } @media only screen and (max-width: 699px) { .col { box-sizing: border-box; display: inline-block !important; line-height: 23px; width: 100% !important; } .col-sm-1 { max-width: 8.33333%; } .col-sm-2 { max-width: 16.66667%; } .col-sm-3 { max-width: 25%; } .col-sm-4 { max-width: 33.33333%; } .col-sm-5 { max-width: 41.66667%; } .col-sm-6 { max-width: 50%; } .col-sm-7 { max-width: 58.33333%; } .col-sm-8 { max-width: 66.66667%; } .col-sm-9 { max-width: 75%; } .col-sm-10 { max-width: 83.33333%; } .col-sm-11 { max-width: 91.66667%; } .col-sm-push-1 { margin-left: 8.33333%; } .col-sm-push-2 { margin-left: 16.66667%; } .col-sm-push-3 { margin-left: 25%; } .col-sm-push-4 { margin-left: 33.33333%; } .col-sm-push-5 { margin-left: 41.66667%; } .col-sm-push-6 { margin-left: 50%; } .col-sm-push-7 { margin-left: 58.33333%; } .col-sm-push-8 { margin-left: 66.66667%; } .col-sm-push-9 { margin-left: 75%; } .col-sm-push-10 { margin-left: 83.33333%; } .col-sm-push-11 { margin-left: 91.66667%; } .full-width-sm { display: table !important; width: 100% !important; } .stack-sm-first { display: table-header-group !important; } .stack-sm-last { display: table-footer-group !important; } .stack-sm-top { display: table-caption !important; max-width: 100%; padding-left: 0 !important; } .toggle-content { max-height: 0; overflow: auto; transition: max-height .4s linear; -webkit-transition: max-height .4s linear; } .toggle-trigger:hover+.toggle-content, .toggle-content:hover { max-height: 999px !important; } .show-sm { display: inherit !important; font-size: inherit !important; line-height: inherit !important; max-height: none !important; } .hide-sm { display: none !important; } .align-sm-center { display: table !important; float: none; margin-left: auto !important; margin-right: auto !important; } .align-sm-left { float: left; } .align-sm-right { float: right; } .text-sm-center { text-align: center !important; } .text-sm-left { text-align: left !important; } .text-sm-right { text-align: right !important; } .borderless-sm { border: none !important; } .nav-sm-vertical .nav-item { display: block; } .nav-sm-vertical .nav-item a { display: inline-block; padding: 4px 0 !important; } .spacer { height: 0; } .p-sm-0 { padding: 0 !important; } .p-sm-10 { padding: 10px !important; } .p-sm-20 { padding: 20px !important; } .p-sm-30 { padding: 30px !important; } .pt-sm-0 { padding-top: 0 !important; } .pt-sm-10 { padding-top: 10px !important; } .pt-sm-20 { padding-top: 20px !important; } .pt-sm-30 { padding-top: 30px !important; } .pr-sm-0 { padding-right: 0 !important; } .pr-sm-10 { padding-right: 10px !important; } .pr-sm-20 { padding-right: 20px !important; } .pr-sm-30 { padding-right: 30px !important; } .pb-sm-0 { padding-bottom: 0 !important; } .pb-sm-10 { padding-bottom: 10px !important; } .pb-sm-20 { padding-bottom: 20px !important; } .pb-sm-30 { padding-bottom: 30px !important; } .pl-sm-0 { padding-left: 0 !important; } .pl-sm-10 { padding-left: 10px !important; } .pl-sm-20 { padding-left: 20px !important; } .pl-sm-30 { padding-left: 30px !important; } .px-sm-0 { padding-right: 0 !important; padding-left: 0 !important; } .px-sm-10 { padding-right: 10px !important; padding-left: 10px !important; } .px-sm-20 { padding-right: 20px !important; padding-left: 20px !important; } .px-sm-30 { padding-right: 30px !important; padding-left: 30px !important; } .py-sm-0 { padding-top: 0 !important; padding-bottom: 0 !important; } .py-sm-10 { padding-top: 10px !important; padding-bottom: 10px !important; } .py-sm-20 { padding-top: 20px !important; padding-bottom: 20px !important; } .py-sm-30 { padding-top: 30px !important; padding-bottom: 30px !important; } } /* @tab Off Promotion @section Background Image @tip Set the image background for section. */ .Off_Promotion_Bg { /*@editable*/ background-image: url("images/2_bg.png"); background-color: #C9D2DB; background-repeat: no-repeat; background-size: cover; } /* @tab E-book Download @section Background Image @tip Set the image background fo section. */ .e-book_Bg { /*@editable*/ background-image: url("images/4_bg.png"); background-color: #C9D2DB; background-repeat: no-repeat; background-size: cover; } /* @tab Video @section Video Thumbnails @tip Set the thumbnail image of the video. */ .video_thumb { /*@editable*/ background-image: url("images/video.png"); background-color: #C9D2DB; background-repeat: no-repeat; background-size: cover; } /* @tab Payment Receipet @section Product showoff @tip Set the product view image . */ .Payment_Receipet_Image { /*@editable*/ background-image: url("images/6_bg.png"); background-color: #C9D2DB; background-repeat: no-repeat; background-size: cover; } </style> </head> <body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" yahoo="fix" style="box-sizing:border-box;margin:0;padding:0;width:100%;word-break:break-word;-webkit-font-smoothing:antialiased;"> <div lang="en" style="display:none;font-size:0;line-height:0;"> Designed & Coded With love , By ExticThemes. </div>';
$footer = '</body>
</html>';

function generateBody($content,$title){
  global $header;
  global $footer;
  global $url;

  $body = $header.'
  <tr> <td bgcolor="#D8F1FF" align="center" style="padding: 70px 15px 70px 15px;" class="section-padding"> <!--[if (gte mso 9)|(IE)]> <table align="center" border="0" cellspacing="0" cellpadding="0" width="500"> <tr> <td align="center" valign="top" width="500"> <![endif]--> <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;" class="responsive-table"> <tr> <td> <!-- HERO IMAGE --> <table width="100%" border="0" cellspacing="0" cellpadding="0"> <tr> <td> <!-- COPY --> <table width="100%" border="0" cellspacing="0" cellpadding="0"> <tr> <td align="left" style="font-size: 25px; font-family: Helvetica, Arial, sans-serif; color: #333333; padding-top: 30px;" class="padding">'.$title.'</td> </tr> <tr> <td align="left" style="padding: 20px 0 0 0; font-size: 16px; line-height: 25px; font-family: Helvetica, Arial, sans-serif; color: #666666;" class="padding"> '.$content.' </td> </tr> </table> </td> </tr> </table> </td> </tr> <tr> <td align="center"> <!-- BULLETPROOF BUTTON --> <table width="100%" border="0" cellspacing="0" cellpadding="0"> <tr> <td align="center" style="padding-top: 25px;" class="padding"> <table border="0" cellspacing="0" cellpadding="0" class="mobile-button-container"> <tr> <td align="center" style="border-radius: 3px;" bgcolor="#256F9C"><a href="'.$url.'" target="_blank" style="font-size: 16px; font-family: Helvetica, Arial, sans-serif; color: #ffffff; text-decoration: none; color: #ffffff; text-decoration: none; border-radius: 3px; padding: 15px 25px; border: 1px solid #256F9C; display: inline-block;" class="mobile-button">Login Sistem</a></td> </tr> </table> </td> </tr> </table> </td> </tr> </table> <!--[if (gte mso 9)|(IE)]> </td> </tr> </table> <![endif]--> </td> </tr>
  '.$footer;

  return $body;
}

function banner1($title,$subtitle){
  global $logoUrl;
  global $slider;

  $html = "<!-- Content -->
  <table align=\"center\" cellpadding=\"0\" cellspacing=\"0\" role=\"presentation\" width=\"100%\" style=\"background-color:#F1F9FF\">
    <tbody>
    <tr>
      <td align=\"center\" class=\"col\" width=\"500\" style=\"vertical-align: middle; padding: 50px 50px\">
        <table align=\"center\" cellpadding=\"0\" cellspacing=\"0\" role=\"presentation\" width=\"100%\">
          <tbody><tr>
            <td align=\"center\" class=\"col\" width=\"400\" style=\"vertical-align: middle; padding: 00px 0;\">
              <img mc:edit=\"\" src=\"$logoUrl\" class=\"align-sm-center\" alt=\"logo\" width=\"200\" style=\"display:block;width:300px; max-width:300px;\">
            </td>
          </tr>
        </tbody></table>
      </td>
    </tr>
    <tr>
      <td align=\"center\" class=\"col\" width=\"500\" style=\"vertical-align: middle; padding: 0px 0px\">
        <table align=\"center\" cellpadding=\"0\" cellspacing=\"0\" role=\"presentation\" width=\"100%\">
          <tbody><tr>
            <td align=\"center\" class=\"col\" width=\"400\" style=\"vertical-align: middle; padding: 00px 0;\">
              <img mc:edit=\"\" src=\"$slider\" class=\"align-sm-center\" alt=\"logo\" width=\"600\" style=\"display:block;width:600px; max-width:600px;\">
            </td>
          </tr>
        </tbody></table>
      </td>
    </tr>
  </tbody></table>
  <table align=\"center\" cellpadding=\"0\" cellspacing=\"0\" role=\"presentation\" width=\"100%\" style=\"background-color:#F1F9FF\">
    <tbody><tr>
      <td background=\"images/headerbg.png\" align=\"center\" class=\"col px-sm-30\" width=\"500\" style=\"vertical-align: middle; padding: 0px  50px; background-repeat: no-repeat;background-size: contain; background-position: left bottom; direction: ltr; text-align: left;\">
        <table align=\"left\" cellpadding=\"0\" cellspacing=\"0\" role=\"presentation\" width=\"100%\">
          <tbody><tr>
            <td align=\" left\" class=\"col\" width=\"600\" style=\"vertical-align: middle; padding-bottom: 15px;\">
              <h2 mc:edit=\"\" data-color=\"Header Title\" style=\"font-family: \"Quicksand\", Arial, sans-serif;font-size: 34px;line-height: 40px;font-weight: 700;; color:#400A91;margin: 0; margin-bottom: 15px;\">
                $title
              </h2>
              <p mc:edit=\"\" data-color=\"Header text\" style=\"font-family: \"Roboto\", Arial, sans-serif;font-size: 18px;line-height:24px;font-weight: 400;margin: 0;color:#252525; text-transform: none;\">
                $subtitle</p>
            </td>
            <td align=\"left\" class=\"col\" width=\"150\" style=\"vertical-align: middle;\">
              &nbsp;
            </td>
          </tr>
        </tbody></table>
      </td>
    </tr>
  </tbody></table>";

  return $html;
}

function AgentRegistration($aaid,$email,$toname,$toemail){
  global $logoUrl;
  global $header;
  global $footer;
  global $rootdir;
  global $slider;

  $title = "Program Agen Dropship/Stokis";
  $subtitle = "Pendaftaran Anda Berjaya diterima oleh pihak eCaque Enterprise";
  $banner = banner1($title,$subtitle);
  $text1 = "Anda telah berjaya mendaftarkan diri dalam Program Agen Dropship/Stokis eCaque. Kami berharap pihak tuan/puan mohon bersabar sementara team ecaque membuat kelulusan permohonan anda. Berikut adalah perkara yang boleh dan tidak boleh dilakukan oleh pihak tuan/puan bagi menjalankan urusniaga sebagai Dropship/Stokis eCauqe.";
  $text2 = "<h4 class=\"text-white\">Do</h4>
  <ul class=\"text-white\">
    <li>Hanya ejen yang berdaftar secara sah di bawah eCaque Enterprise sahaja dibenarkan untuk berhubung terus dengan pihak HQ di mana kami akan memberi tip-tip dan panduan serta tunjuk ajar bagi memasarkan produk eCaque.</li>
    <li>Untuk tujuan pemasaran, ejen dibenarkan untuk menggunakan platform seperti  FB Personal, FB Ads, Instagram, group-group business, personal wall, e-commerce personal, blog personal, google ads, website personal, group WeChat, group WhatsApp dan lain-lain.</li>
    <li>Ejen adalah <b>DIBENARKAN</b> untuk melantik staff jualan bagi tujuan membuat pemasaran secara dalam talian (online) atau secara jualan langsung (offline)</li>
    <!-- <li>Ejen <b>DIWAJIBKAN</b> untuk mengambil stok sekurang-kurangnya <b>LIMA(5) KOTAK</b> untuk setiap pesanan stok.</li> -->
  </ul>
  <h4 class=\"text-white\">Don't</h4>
  <ul class=\"text-white\">
    <li>Ejen adalah <b>TIDAK DIBENARKAN</b> untuk menjual di <b>PLATFORM MARKETPLACE</b> seperti di Shopee, Mudah.my, Lazada, marketplace FB dan lain-lain. Ini bagi mengelakkan berlakunya isu salah faham mengenai harga oleh pelanggan.</li>
    <li><b>DILARANG</b> mengubah harga secara sengaja atau tidak sengaja tanpa kebenaran pihak HQ.</li>
    <li>Ejen <b>DILARANG</b> melakukan apa-apa tindakan berunsurkan sabotaj atau perkara-perkara yang boleh menjatuhkan reputasi HQ / Pemilik eCaque / Ejen / pelanggan Ecaque.</li>
    <li><b>DILARANG</b> menjual kepada pihak ketiga seperti Pemborong, Kedai Kek, Bazaar Expo dan sebagainya.</li>
  </ul>";

  $body = $header."
  <table class=\"container\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\" role=\"presentation\" bgcolor=\"#FFFFFF\" width=\"600\">
    <tbody><tr>
      <td>
        $banner
        <table align=\"center\" cellpadding=\"0\" cellspacing=\"0\" role=\"presentation\" width=\"100%\" style=\"background-color:#FFFFFF\">
          <tbody><tr>
            <td align=\"center\" class=\"col p-sm-30\" width=\"400\" style=\"vertical-align: middle; padding: 50px 50px\">
              <table align=\"center\" cellpadding=\"0\" cellspacing=\"0\" role=\"presentation\" width=\"100%\">
                <tbody><tr>
                  <td align=\"left\" class=\"col\" width=\"500\" style=\"vertical-align: middle;\">
                    <h2 mc:edit=\"\" data-color=\"Simple Title\" style=\"font-family: \"Quicksand\", Arial, sans-serif;font-size: 22px;line-height: 26px;font-weight: 700;; color:#242424;margin-top: 0; margin-bottom: 15px;\">
                      Hi, <span data-color=\"Simple Title Span\" style=\"color:#400A91;\">$toname</span>
                    </h2>
                    <p mc:edit=\"\" data-color=\"Simple Text text\" style=\"font-family: \"Roboto\", Arial, sans-serif;font-size: 18px;line-height:24px;font-weight: 400;margin: 0;color:#595959; text-transform: none;\">
                    $text1</p>
                    <hr>
                    <p mc:edit=\"\" data-color=\"Simple Text text\" style=\"font-family: \"Roboto\", Arial, sans-serif;font-size: 18px;line-height:24px;font-weight: 400;margin: 0;color:#595959; text-transform: none;\">
                    $text2</p>
                    <div class=\"spacer py-sm-20\" style=\"line-height: 50px;\">‌</div>
                    <!-- Custom: center-aligned on mobile only -->
                    <table align=\"center\" class=\"full-width-sm\" cellpadding=\"0\" cellspacing=\"0\" role=\"presentation\">
                      <tbody><tr>
                        <th data-bgcolor=\"Button Color\" bgcolor=\"#93EFE0\" style=\" line-height: 100%; mso-padding-alt: 5px 50px 10px;\">
                          <!-- <a mc:edit=\"\" href=\"http://exemple.com\" data-color=\"Buton Text\" style=\"color: #400A91; display: block; font-size: 18px; padding: 15px 40px; text-decoration: none;\">
                            CONFIRME
                          </a> -->
                        </th>
                      </tr>
                    </tbody></table>
                  </td>
                </tr>
              </tbody></table>
            </td>
          </tr>
        </tbody></table>
        <!-- /Content -->

      </td>
    </tr>
  </tbody></table>".$footer;

  $subject = '[No-Reply] Pendaftaran Agen Dropsip/Stokis eCaque';

  // echo $body;
  return email($toemail,$toname,$body,$subject);
}

function forgotPasswordEmail($toemail,$toname,$encrypt){
  global $logoUrl;
  global $header;
  global $footer;
  global $rootdir;
  global $slider;
  global $http;

  $url = "$http://".$_SERVER["HTTP_HOST"]."$rootdir/forgotpassword?e=$encrypt";

  $title = "Lupa Katalaluan?";
  $subtitle = "Jangan Bimbang, kami akan bantu ada untuk reset kata laluan anda";
  $banner = banner1($title,$subtitle);
  $text1 = "Sila tekan pautan dibawah untuk reset ketalaluan anda. <br> <a target=\"_blank\" href=\"$url\">$url</a>";
  $text2 = "<h4 class=\"text-white\">Do</h4>
  <ul class=\"text-white\">
    <li>Hanya ejen yang berdaftar secara sah di bawah eCaque Enterprise sahaja dibenarkan untuk berhubung terus dengan pihak HQ di mana kami akan memberi tip-tip dan panduan serta tunjuk ajar bagi memasarkan produk eCaque.</li>
    <li>Untuk tujuan pemasaran, ejen dibenarkan untuk menggunakan platform seperti  FB Personal, FB Ads, Instagram, group-group business, personal wall, e-commerce personal, blog personal, google ads, website personal, group WeChat, group WhatsApp dan lain-lain.</li>
    <li>Ejen adalah <b>DIBENARKAN</b> untuk melantik staff jualan bagi tujuan membuat pemasaran secara dalam talian (online) atau secara jualan langsung (offline)</li>
    <!-- <li>Ejen <b>DIWAJIBKAN</b> untuk mengambil stok sekurang-kurangnya <b>LIMA(5) KOTAK</b> untuk setiap pesanan stok.</li> -->
  </ul>
  <h4 class=\"text-white\">Don't</h4>
  <ul class=\"text-white\">
    <li>Ejen adalah <b>TIDAK DIBENARKAN</b> untuk menjual di <b>PLATFORM MARKETPLACE</b> seperti di Shopee, Mudah.my, Lazada, marketplace FB dan lain-lain. Ini bagi mengelakkan berlakunya isu salah faham mengenai harga oleh pelanggan.</li>
    <li><b>DILARANG</b> mengubah harga secara sengaja atau tidak sengaja tanpa kebenaran pihak HQ.</li>
    <li>Ejen <b>DILARANG</b> melakukan apa-apa tindakan berunsurkan sabotaj atau perkara-perkara yang boleh menjatuhkan reputasi HQ / Pemilik eCaque / Ejen / pelanggan Ecaque.</li>
    <li><b>DILARANG</b> menjual kepada pihak ketiga seperti Pemborong, Kedai Kek, Bazaar Expo dan sebagainya.</li>
  </ul>";

  $body = $header."
  <table class=\"container\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\" role=\"presentation\" bgcolor=\"#FFFFFF\" width=\"600\">
    <tbody><tr>
      <td>
        $banner
        <table align=\"center\" cellpadding=\"0\" cellspacing=\"0\" role=\"presentation\" width=\"100%\" style=\"background-color:#FFFFFF\">
          <tbody><tr>
            <td align=\"center\" class=\"col p-sm-30\" width=\"400\" style=\"vertical-align: middle; padding: 50px 50px\">
              <table align=\"center\" cellpadding=\"0\" cellspacing=\"0\" role=\"presentation\" width=\"100%\">
                <tbody><tr>
                  <td align=\"left\" class=\"col\" width=\"500\" style=\"vertical-align: middle;\">
                    <h2 mc:edit=\"\" data-color=\"Simple Title\" style=\"font-family: \"Quicksand\", Arial, sans-serif;font-size: 22px;line-height: 26px;font-weight: 700;; color:#242424;margin-top: 0; margin-bottom: 15px;\">
                      Hi, <span data-color=\"Simple Title Span\" style=\"color:#400A91;\">$toname</span>
                    </h2>
                    <p mc:edit=\"\" data-color=\"Simple Text text\" style=\"font-family: \"Roboto\", Arial, sans-serif;font-size: 18px;line-height:24px;font-weight: 400;margin: 0;color:#595959; text-transform: none;\">
                    $text1</p>
                    <hr>
                    <p mc:edit=\"\" data-color=\"Simple Text text\" style=\"font-family: \"Roboto\", Arial, sans-serif;font-size: 18px;line-height:24px;font-weight: 400;margin: 0;color:#595959; text-transform: none;\">
                    $text2</p>
                    <div class=\"spacer py-sm-20\" style=\"line-height: 50px;\">‌</div>
                    <!-- Custom: center-aligned on mobile only -->
                    <table align=\"center\" class=\"full-width-sm\" cellpadding=\"0\" cellspacing=\"0\" role=\"presentation\">
                      <tbody><tr>
                        <th data-bgcolor=\"Button Color\" bgcolor=\"#93EFE0\" style=\" line-height: 100%; mso-padding-alt: 5px 50px 10px;\">
                          <!-- <a mc:edit=\"\" href=\"http://exemple.com\" data-color=\"Buton Text\" style=\"color: #400A91; display: block; font-size: 18px; padding: 15px 40px; text-decoration: none;\">
                            CONFIRME
                          </a> -->
                        </th>
                      </tr>
                    </tbody></table>
                  </td>
                </tr>
              </tbody></table>
            </td>
          </tr>
        </tbody></table>
        <!-- /Content -->

      </td>
    </tr>
  </tbody></table>".$footer;

  $subject = '[No-Reply] Lupa Katalaluan';
  // echo $body;
  return email($toemail,$toname,$body,$subject);
}
