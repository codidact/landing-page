<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
/*
 * Load PHP mailer class using composer.
 */
include "include/vendor/autoload.php";
/*
 * Regex pattern for email.
 * Copyright Michael Rushton.
 * Feel free to use and redistribute this code. But please keep this copyright notice.
 * http://lxr.php.net/xref/PHP_5_4/ext/filter/logical_filters.c#501
 */
$pattern = '/^(?!(?:(?:\\x22?\\x5C[\\x00-\\x7E]\\x22?)|(?:\\x22?[^\\x5C\\x22]\\x22?)){255,})(?!(?:(?:\\x22?\\x5C[\\x00-\\x7E]\\x22?)|(?:\\x22?[^\\x5C\\x22]\\x22?)){65,}@)(?:(?:[\\x21\\x23-\\x27\\x2A\\x2B\\x2D\\x2F-\\x39\\x3D\\x3F\\x5E-\\x7E]+)|(?:\\x22(?:[\\x01-\\x08\\x0B\\x0C\\x0E-\\x1F\\x21\\x23-\\x5B\\x5D-\\x7F]|(?:\\x5C[\\x00-\\x7F]))*\\x22))(?:\\.(?:(?:[\\x21\\x23-\\x27\\x2A\\x2B\\x2D\\x2F-\\x39\\x3D\\x3F\\x5E-\\x7E]+)|(?:\\x22(?:[\\x01-\\x08\\x0B\\x0C\\x0E-\\x1F\\x21\\x23-\\x5B\\x5D-\\x7F]|(?:\\x5C[\\x00-\\x7F]))*\\x22)))*@(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)?[a-z0-9]+(?:-+[a-z0-9]+)*\\.){1,126}){1,}(?:(?:[a-z][a-z0-9]*)|(?:(?:xn--)[a-z0-9]+))(?:-+[a-z0-9]+)*)|(?:\\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})|(?:(?!(?:.*[a-f0-9][:\\]]){7,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?)))|(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)|(?:(?!(?:.*[a-f0-9]:){5,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))(?:\\.(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))){3}))\\]))$/iD';
/*
 * Constants for email credentials.
 * Makes it easy to edit the username, password, port, etc.
 * LOAD from a env file that's in the root folder, the template can be found in
 * .env.example file
 *
 * Original:  $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
 * Changed to put in private folder outside www
 */
$dotenv = Dotenv\Dotenv::createImmutable('/home/codidact/private/');
$dotenv->load();
$constants = array(
  "HOST" => $_ENV['HOST'],
  "USERNAME" => $_ENV['USERNAME'],
  "PASSWORD" => $_ENV['PASSWORD'],
  "PORT" => (int)$_ENV['PORT'],
  "TO" => $_ENV['TO'],
  "DEBUG" => (int)$_ENV['DEBUG']
);

if (!isset($_POST["mail_input"])) {
  header("location: ./");
  exit();
}
$mail = new PHPMailer(true);
$emailString = $_POST["mail_input"];
/*
 * Setup a response string for returning a response, in case the email was bad.
 */
$responseString = "";
/*
 * Server side email validation.
 */
if (preg_match($pattern, $emailString) !== 1) {
  $responseString = "Please enter an email";
  echo $responseString;
  exit();
}
try {
  /*
   * Server settings.
  */
  $mail->SMTPDebug = $constants["DEBUG"];
  $mail->Host       = $constants["HOST"];
  $mail->SMTPAuth   = true;
  $mail->Username   = $constants["USERNAME"];
  $mail->Password   = $constants["PASSWORD"];
  $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
  $mail->Port       = $constants["PORT"];
  /*
   * Should be turned on in production.
   * $mail->SMTPDebug  = false;
   */

  /*
   * Email recipents.
   */
  $mail->setFrom($emailString);
  $mail->addAddress($constants["TO"]);
  /*
      Content section. Subject and body goes here.
   */
  $mail->Subject = 'Subscription to Codidact email list';
  $mail->Body    = 'Subscription request for announcements@codidact.org';
  $mail->AltBody = '';
  /*
      Send the mail.
   */
  $mail->send();
  $responseString = "Thank you for your subscription request. You should receive an automated message with confirmation instructions.<br><a href=\"https://codidact.org\">Click here to return to Codidact</a>";
  echo $responseString;
} catch (Exception $e) {
  $err = $mail->ErrorInfo;
  $responseString = "Mail was not sent, please report the issue <a href='https://github.com/codidact/landing-page/issues'>here</a>";
  echo $responseString;
}
