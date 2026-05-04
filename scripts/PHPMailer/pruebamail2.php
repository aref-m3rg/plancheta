<?php
require 'PHPMailerAutoload.php';
    $mail = new PHPMailer();
    $mail->IsSMTP(); 
    $mail->Host = 'mail.tierradelfuego.gov.ar';
    $mail->Port = 465;
    $mail->SMTPSecure = 'ssl';
    $mail->SMTPAuth = true;
    $mail->Username = "catastrotdf";
    $mail->Password = "Tdf36002";
    $mail->setFrom('catastrotdf@tierradelfuego.gov.ar', 'Direccion General de Catastro TDF');  //add sender email address.
    $mail->addAddress('catastrotdf@tierradelfuego.gov.ar', "Direccion General de Catastro TDF");  //Set who the message is to be sent to.
    $mail->Subject = "prueba loca de e-mail desde servidor de gobierno";
    $mail->Body     = 'Prueba de envio de mail a Marcelo Zayas';
    //$mail->AltBody = 'This is a plain-text message body';
    if (!$mail->send()) {
        echo "Mailer Error: " . $mail->ErrorInfo;
    } else {
        echo "Message sent!";
    }
?>