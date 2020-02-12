<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
/*
    Load PHP mailer class using composer.
 */
include "include/vendor/autoload.php";
/*
    Regex pattern for email.
    Copyright Michael Rushton.
    Feel free to use and redistribute this code. But please keep this copyright notice.
    http://lxr.php.net/xref/PHP_5_4/ext/filter/logical_filters.c#501
 */
$pattern = '/^(?!(?:(?:\\x22?\\x5C[\\x00-\\x7E]\\x22?)|(?:\\x22?[^\\x5C\\x22]\\x22?)){255,})(?!(?:(?:\\x22?\\x5C[\\x00-\\x7E]\\x22?)|(?:\\x22?[^\\x5C\\x22]\\x22?)){65,}@)(?:(?:[\\x21\\x23-\\x27\\x2A\\x2B\\x2D\\x2F-\\x39\\x3D\\x3F\\x5E-\\x7E]+)|(?:\\x22(?:[\\x01-\\x08\\x0B\\x0C\\x0E-\\x1F\\x21\\x23-\\x5B\\x5D-\\x7F]|(?:\\x5C[\\x00-\\x7F]))*\\x22))(?:\\.(?:(?:[\\x21\\x23-\\x27\\x2A\\x2B\\x2D\\x2F-\\x39\\x3D\\x3F\\x5E-\\x7E]+)|(?:\\x22(?:[\\x01-\\x08\\x0B\\x0C\\x0E-\\x1F\\x21\\x23-\\x5B\\x5D-\\x7F]|(?:\\x5C[\\x00-\\x7F]))*\\x22)))*@(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)?[a-z0-9]+(?:-+[a-z0-9]+)*\\.){1,126}){1,}(?:(?:[a-z][a-z0-9]*)|(?:(?:xn--)[a-z0-9]+))(?:-+[a-z0-9]+)*)|(?:\\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})|(?:(?!(?:.*[a-f0-9][:\\]]){7,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?)))|(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)|(?:(?!(?:.*[a-f0-9]:){5,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))(?:\\.(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))){3}))\\]))$/iD';
/**
 * Setup a response string for returning a response, in case the email was bad.
 */
$responseString = "";
/*
    Constants for email credentials.
    Makes it easy to edit the username, password, port, etc.
 */
$constants = array(
    "HOST" => "",
    "USERNAME" => "",
    "PASSWORD" => "",
    "PORT" => 465,
    "SET_FROM" => ""
);

if (isset($_POST["mail_input"])) {
    $mail = new PHPMailer(true);
    $emailString = $_POST["mail_input"];
    /*
        Server side email validation.
     */
    if (preg_match($pattern, $emailString) === 1) {

        try {
            /*
                Server settings.
             */
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;
            $mail->isSMTP();
            $mail->Host       = $constants["HOST"];
            $mail->SMTPAuth   = true;
            $mail->Username   = $constants["USERNAME"];
            $mail->Password   = $constants["PASSWORD"];
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = $constants["PORT"];
            $mail->SMTPSecure = 'ssl';
            /*
            Should be turned on in production.
            */
            // $mail->SMTPDebug  = false;
            /*
                Email recipents.
             */
            $mail->setFrom($constants["SET_FROM"]);
            $mail->addAddress($emailString);
            //$mail->addReplyTo('info@example.com', 'Information');
            /*
                Content section. Subject and body goes here.
             */
            $mail->Subject = '';
            $mail->Body    = '';
            $mail->AltBody = '';
            /*
                Send the mail.
             */
            $mail->send();
            $responseString = "Subscribed!";
        } catch (Exception $e) {
            $err = $mail->ErrorInfo;
            $responseString = "Mail was not sent, please report the issue <a href='https://github.com/codidact/landing-page/issues'>here</a>";
        }
    } else {
        /*
            Email is not valid. Return to the page.
         */
        $responseString = "please enter a email";
    }
    echo $responseString;
} else {
    /*
        If no response. Return to the page.
     */
    header("location: ./");
}
