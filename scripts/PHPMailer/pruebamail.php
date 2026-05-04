<?php
require_once('class.phpmailer.php');
//include("class.smtp.php"); // optional, gets called from within class.phpmailer.php if not already loaded
$mail             = new PHPMailer();
//$body             = file_get_contents('contents.html');
//$body             = eregi_replace("[\]",'',$body);
$mail->IsSMTP(); // telling the class to use SMTP
$mail->Host       = "mail.tierradelfuego.gov.ar"; // SMTP server
$mail->SMTPDebug  = 2;                     // enables SMTP debug information (for testing)
                                           // 1 = errors and messages
                                           // 2 = messages only
$mail->SMTPAuth   = true;                  // enable SMTP authentication
//mail->Port       = 25;                    // set the SMTP port for the GMAIL server
$mail->Username   = "catastrotdf"; // SMTP account username
$mail->Password   = "Tdf36002";        // SMTP account password
$mail->SetFrom('catastro@tierradelfuego.gov.ar', 'First Last');
$mail->AddReplyTo("catastro@tierradelfuego.gov.ar","First Last");
$mail->Subject    = "PHPMailer Test Subject via smtp, basic with authentication";
$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
//$mail->MsgHTML($body);
$mail->MsgHTML("PRUEBA");
$address = "mazayas@tierradelfuego.gov.ar";
$mail->AddAddress($address, "Marcelo Zayas");
//$mail->AddAttachment("images/phpmailer.gif");      // attachment
//$mail->AddAttachment("images/phpmailer_mini.gif"); // attachment
if(!$mail->Send()) {
  echo "Mailer Error: " . $mail->ErrorInfo;
} else {
  echo "Message sent!";
}
?>