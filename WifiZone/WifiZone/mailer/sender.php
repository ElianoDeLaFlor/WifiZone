<?php
use PHPMailer\PHPMailer\PHPMailer;
require 'vendor/autoload.php';

$mailaddress=$_POST['txtmail'];
$mail = new PHPMailer;
$mail->isSMTP();
$mail->SMTPDebug = 2;
$mail->Host = "mail31.lwspanel.com";
$mail->Port = 587;
$mail->SMTPAuth = true;
$mail->Username = 'rie.afstrel@afstrel.com';
$mail->Password = '2405-Entreprise';
$mail->setFrom('rie.afstrel@afstrel.com', 'AFSTREL-RIE');
$mail->addReplyTo('rie.afstrel@afstrel.com', 'AFSTREL-RIE');
$mail->addAddress($mailaddress, 'Receiver Name');
$mail->Subject = 'Demande de renseignement';
$mail->msgHTML('toute mes salutations', __DIR__);
$mail->AltBody = 'This is a plain text message body';
//$mail->addAttachment('test.txt');
if (!$mail->send()) {
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    echo 'Message sent!';
}
?>