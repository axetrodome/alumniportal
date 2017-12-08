<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
//Load composer's autoloader
require 'vendor/autoload.php';

    $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
    //Server settings
    // $mail->SMTPDebug = 2;                                 // Enable verbose debug output
    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
    $mail->Host = 'smtp.gmail.com;';  // Specify main and backup SMTP servers
    $mail->Port = 465;                                    // TCP port to connect to
    $mail->isHTML();
    $mail->Username = 'axetrodome@gmail.com';                 // SMTP username
    $mail->Password = 'axelchen';                           // SMTP password
    //Recipients
    $mail->setFrom('axetrodome@yahoo.com', 'SomeName'); //
    $mail->addAddress('axetrodome@yahoo.com', 'SomeNameSSS');     // Add a recipient name of st cath
    $mail->addReplyTo('axetrodome@yahoo.com', 'Information');
    // $mail->addCC('cc@example.com');
    // $mail->addBCC('bcc@example.com');
    // Attachments  
    //Content
    // $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'Some subject LOLSSSSSS';
    $mail->Body    = '<b>This is the HTML message body in bold!</b>';
    // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
    $mail->send();