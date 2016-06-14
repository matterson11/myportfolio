<?php
/**
 * This example shows settings to use when sending via Google's Gmail servers.
 */

$fullname = strip_tags(trim($_POST["fullname"]));
$fullname = str_replace(array("\r","\n"),array(" "," "),$fullname);
$email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
$subject = trim($_POST["subject"]);
$message = trim($_POST["message"]);


//SMTP needs accurate times, and the PHP time zone MUST be set
//This should be done in your php.ini, but this is how to do it if you don't have access to that
date_default_timezone_set('Etc/UTC');
require 'vendor/phpmailer/phpmailer/PHPMailerAutoload.php';
//require 'PHPMailerAutoload.php';
require 'vendor/autoload.php';
//Create a new PHPMailer instance
$mail = new PHPMailer;
//Tell PHPMailer to use SMTP
$mail->isSMTP();
//Enable SMTP debugging
// 0 = off (for production use)
// 1 = client messages
// 2 = client and server messages
$mail->SMTPDebug = 0;
//Ask for HTML-friendly debug output
$mail->Debugoutput = 'html';
//Set the hostname of the mail server
//$mail->Host = 'smtp.gmail.com';
$mail->Host = localhost;
//$mail->Host = "smtp.secureserver.net";
//$mail->Host = "smtpout.secureserver.net";
//$mail->Host = "relay-hosting.secureserver.net";
// use
// $mail->Host = gethostbyname('smtp.gmail.com');
// if your network does not support SMTP over IPv6
//Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
//$mail->Port = 465;
//$mail->Port = 587;
$mail->Port = 25;
//Set the encryption system to use - ssl (deprecated) or tls
$mail->SMTPSecure = 'tls';
//Whether to use SMTP authentication
$mail->SMTPAuth = false;
//Username to use for SMTP authentication - use full email address for gmail
//$mail->Username = "mytimelearningcontact@gmail.com";
$mail->Username = "contactme@mytimelearning.co.uk";
//Password to use for SMTP authentication
$mail->Password = "password";

//Set who the message is to be sent from
$mail->setFrom($email, $fullname);
//Set an alternative reply-to address
//$mail->addReplyTo('mytimelearningcontact@gmail.com', 'Name');
//Set who the message is to be sent to
$mail->addAddress('email', 'name');
//Set the subject line
$mail->Subject = $subject;
//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body
//$mail->msgHTML = $message;
//Replace the plain text body with one created manually
//$mail->AltBody = $message;
//Attach an image file
//$mail->addAttachment('images/phpmailer_mini.png');
//send the message, check for errors
$mail->Body = $message;
$mail->AltBody = $message;
if (!$mail->send()) {
    echo "Mailer Error: " . $mail->ErrorInfo;

} else {
    echo "Thanks for getting in touch!";

}
?>
