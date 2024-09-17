<?php
// include PHP Mailer
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\SMTP;

	require 'PHPMailer-master/src/Exception.php';
	require 'PHPMailer-master/src/PHPMailer.php';
	require 'PHPMailer-master/src/SMTP.php';
   /*
    *
    * Function send_mail_by_PHPMailer($to, $from, $subject, $message);
    * send a mail by PHPMailer method
    * @Param $to -> mail to send
    * @Param $from -> sender of mail
    * @Param $subject -> suject of mail
    * @Param $message -> html content with datas
    * @Return true if success / Json encoded error message if error 
    * !! need -> classes/Exception.php - classes/PHPMailer.php - classes/SMTP.php
    *
    */
    function send_mail_by_PHPMailer(){

          // SEND MAIL by PHP MAILER
          $mail = new PHPMailer();
	  $mail->SMTPDebug = SMTP::DEBUG_SERVER;
          $mail->IsSMTP(); // Use SMTP protocol
	  $mail->Mailer = "smtp";
          $mail->Host = 'smtp.gmail.com';
          $mail->SMTPAuth = true; // Auth. SMTP
          $mail->Username = 'csworkflowsite@gmail.com'; // Mail who send by PHPMailer
          $mail->Password = 'wqycmcfxfixcyhvf'; // your pass mail box
          $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
          $mail->Port = 465;
          $mail->setFrom('csworkflowsite@gmail.com', 'Tester');
          $mail->addAddress('dilloncooke8@gmail.com', 'tester2');
          $mail->Subject = 'Testing this";
          $mail->Body = 'Does this work';
          $mail->send();
    }
?>