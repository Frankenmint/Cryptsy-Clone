<?php
function Send_Mail($to,$subject,$body)
{
require './class.phpmailer.php';
$from = "admin@crypto-maniac.com";
$mail = new PHPMailer();
$mail->IsSMTP(true); // SMTP
$mail->SMTPAuth   = true;  // SMTP authentication
$mail->Mailer = "smtp";
$mail->Host       = "mail.privateemail.com"; // Amazon SES server, note "tls://" protocol
$mail->Port       = 465;                    // set the SMTP port
$mail->Username   = "admin@crypto-maniac.com";  // SES SMTP  username
$mail->Password   = "smtppass123smtp2014";  // SES SMTP password
$mail->SetFrom($from, 'Crypto Maniac');
$mail->AddReplyTo($from,'Crypto Maniac');
$mail->Subject = $subject;
$mail->MsgHTML($body);
$address = $to;
$mail->AddAddress($address, $to);

if(!$mail->Send())
return false;
else
return true;

}
?>