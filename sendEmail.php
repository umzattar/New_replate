<?php
define('NameCompany', 'WECARE.com');
define('EmailComp', 'eduproject032023@gmail.com');
define('PasswordComp', 'lnerzwatcyltdonx');

//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

class sendEmail
{
  private $mail;
  public function sendMessageEmail($email, $name, $subject, $Msg)
  {
    //Instantiation and passing `true` enables exceptions
    $mail = new PHPMailer(true);

    try {
      //Enable verbose debug output
      $mail->SMTPDebug = 0; //SMTP::DEBUG_SERVER;

      //Send using SMTP
      $mail->isSMTP();

      //Set the SMTP server to send through
      $mail->Host = 'smtp.gmail.com';

      //Enable SMTP authentication
      $mail->SMTPAuth = true;

      //SMTP username
      $mail->Username = EmailComp;

      //SMTP password
      $mail->Password = PasswordComp;

      //Enable TLS encryption;
      $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

      //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
      $mail->Port = 587;

      //Recipients
      $mail->setFrom(EmailComp, NameCompany);

      //Add a recipient
      $mail->addAddress($email, $name);

      //Set email format to HTML
      $mail->isHTML(true);
      $mail->Subject = $subject;
      $mail->Body    = $Msg;

    // Attach the image file
    //$mail->addAttachment($imagePath);
      $mail->send();

      return true;
      exit();
    } catch (Exception $e) {
      return false;
    }
  }
}
