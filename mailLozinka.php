<?php
session_start();

include "konekcija.php";
require_once "sendMail.php";

if(isset($_REQUEST['zabLozinka']))
{
    $email=$_REQUEST['zabLozinka'];
    
    $sql = "SELECT * FROM korisnici WHERE email='$email' LIMIT 1";//Provjerava da li postoji email u bazi
    $result = mysqli_query($connection, $sql);
    if (mysqli_num_rows($result) > 0)
    {
        $user= mysqli_fetch_assoc($result);
        $userToken=$user['token'];
        $body = '<!DOCTYPE html>
                <html lang="en">

                <head>
                <meta charset="UTF-8">
                <title>Resetovanje lozinke</title>
                <style>
                    .wrapper {
                    padding: 20px;
                    color: #444;
                    font-size: 1.3em;
                    }
                    a {
                    background: #592f80;
                    text-decoration: none;
                    padding: 8px 15px;
                    border-radius: 5px;
                    color: #fff;
                    }
                </style>
                </head>

                <body>
                <div class="wrapper">
                    <p>Ukoliko ste zatražili resetovanje lozinke potvrdite to klikom na link ispod</p>
                    <a href="http://localhost/unosNoveLozinke.php?token=' . $userToken . '">Resetovanje lozinke</a>
                    <p><b>Ukoliko niste ignorišite ovaj mail</b></p>
                </div>
                </body>
                </html>';
        sendVerificationEmail($email, $token, $body,'Resetovanje lozinke');
        $_SESSION['alert']="alert alert-info";
        setcookie("notification", "Na Vašu mail adresu je poslat email za resetovanje lozinke!", time()+60*60*24, "/");
        header("Location: prijava.php");
    }
    else 
    {
        header("Location: resetLozinke.php");            
        $_SESSION['alert']="alert alert-danger";
        setcookie("notification", "Uneseni mail ne postoji u bazi", time()+60*60*24, "/");
    }
}
else {
    die("GREŠKA");
}


?>