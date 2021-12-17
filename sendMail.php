<?php
require_once 'vendor/autoload.php';

// Create the Transport
$transport = (new Swift_SmtpTransport('smtp.gmail.com', 465, 'ssl'))
    ->setUsername("verify.itp@gmail.com")//mail adresa i lozinka google naloga
    ->setPassword("itp_2021");

// Create the Mailer using your created Transport
$mailer = new Swift_Mailer($transport);

function sendVerificationEmail($userEmail, $token, $body,$swift)
{
    global $mailer;

    // Create a message
    $message = (new Swift_Message($swift))
        ->setFrom("verify.itp@gmail.com")
        ->setTo($userEmail)
        ->setBody($body, 'text/html');

    // Send the message
    $result = $mailer->send($message);

    if ($result > 0) {
        return true;
    } else {
        return false;
    }
}