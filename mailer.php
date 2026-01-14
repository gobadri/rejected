b<?php
//Import PHPMailer classes into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

$email = $_POST['user-mail'];
$name = $_POST['user-name'];
$phone = $_POST['user-phone'];
$company = $_POST['user-company'];
$message = $_POST['user-message'];

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->SMTPDebug = 0;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'rgktdagency@gmail.com';                     //SMTP username
    $mail->Password   = 'lixjzeieueoecmoe';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('noreply@rejected.agency');
    $mail->addAddress('contact@rejected.agency', 'Rejected');     //Add a recipient
    // $mail->addAddress($email , $name);               //Name is optional

    // $mail->addReplyTo('info@example.com', 'Information');
    // $mail->addCC('cc@example.com');
    // $mail->addBCC('bcc@example.com');

    //Attachments
    // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
    // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = "Message from $name";
    $mail->Body    = "Message from $name</br>Phone Number: $phone</br>Company: $company</br>Email: $email</br><b>$message</b>";
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
    $mail->send();

    // --- EMAIL 2: To the User (Auto-reply) ---
    $mail->clearAddresses(); // <--- CRITICAL: Remove the admin address so the user doesn't see it

    // header("Location:done.html");
    $mail->addAddress($email , $name);               //Name is optional

    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = "$name, we have got your message";
    $mail->Body    = "We have recieved your email, we will get back to you as soon as possibile.</br><b>Thank you for contacting us</b></br><b>Rejected Agency</b>";
    $mail->AltBody = '';

    $mail->send();

    header("Location:emailcomfirmation.html");
    exit(); // Always run exit after a header redirect
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}