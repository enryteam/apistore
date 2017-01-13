<?php
/**
 * @author [pooy] <[pooy@pooy.net]>
 * @blog  http://www.pooy.net
 */
require 'class.phpmailer.php';

$mail = new PHPMailer;
$mail->SMTPDebug = 1;
$mail->IsSMTP();                                      // Set mailer to use SMTP

$mail->Host = 'smtp.exmail.qq.com';  // Specify main and backup server
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = 'service@51daniu.cn';                            // SMTP username
$mail->Port = 465;
$mail->Password = 'adminchen5188';                           // SMTP password
$mail->SMTPSecure = 'ssl';                            // Enable encryption, 'ssl' also accepted
$mail->From = 'service@51daniu.cn';

$mail->FromName = 'QC-Mantis';

$mail->WordWrap = 50;                                 // Set word wrap to 50 characters
$mail->IsHTML(true);                                  // Set email format to HTML

$mail->Subject = 'Here is the subject';
$mail->Body    = 'This is the HTML message body <b>in bold!</b>';
$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
$mail->AddAddress('enry.chan@51daniu.cn');
if(!$mail->Send()) {
   echo 'Message could not be sent.';
   echo 'Mailer Error: ' . $mail->ErrorInfo;
   exit;
}

echo 'Message has been sent';
// To load the French version
//$mail->SetLanguage('cn', '/optional/path/to/language/directory/');
?>
