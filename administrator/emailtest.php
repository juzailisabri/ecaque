<?php
// use PHPMailer\PHPMailer\PHPMailer;
// use PHPMailer\PHPMailer\Exception;
include("email.php");
// // forgotPasswordEmail('$name','$email','$encid')
//
// function email2($toemail,$toname,$uu_name,$uu_email,$body,$subject){
//   require_once 'PHPMailer/src/Exception.php';
//   require_once 'PHPMailer/src/PHPMailer.php';
//   require_once 'PHPMailer/src/SMTP.php';
//
//   $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
//   try {
//       //Server settings
//       $mail->SMTPDebug = 1;                                 // Enable verbose debug output
//       $mail->isSMTP();                                      // Set mailer to use SMTP
//       $mail->Host = 'smtprelay1.selangor.gov.my';  // Specify main and backup SMTP servers
//       $mail->SMTPAuth = false;                               // Enable SMTP authentication
//       $mail->Username = 'hpipt@selangor.gov.my';                 // SMTP username
//       $mail->Password = 'Suksel2016';                            // SMTP password
//       // $mail->SMTPSecure = 'tls';
//       // $mail->SMTPAutoTLS = false;                      // Enable TLS encryption, `ssl` also accepted
//       $mail->Port = 25;                                  // TCP port to connect to
//       //Recipients
//       $mail->setFrom('hpipt@selangor.gov.my', 'hpipt');
//       $mail->addAddress($toemail, $toname);     // Add a recipient
//       $mail->addAddress($uu_email, $uu_name);     // Add a recipient
//       //Attachments
//       // $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
//       // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
//       //Content
//       $mail->isHTML(true);                                  // Set email format to HTML
//       $mail->Subject = $subject;
//       $mail->Body    = $body;
//       // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
//
//       $mail->send();
//       return true;
//   } catch (Exception $e) {
//       return $mail->ErrorInfo;
//   }
// }

AgentRegistration("juzaili.sabri@gmail.com","Juzaili Sabri","Juzaili Ahmad Sabri","juzaili.sabri@gmail.com","test","test");
?>
