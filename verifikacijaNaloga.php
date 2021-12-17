<?php
    session_start();

    include "konekcija.php";
    require_once "sendMail.php";

    if(isset($_REQUEST['ime']) &&
    isset($_REQUEST['prezime']) &&
    isset($_REQUEST['mail']) &&
    isset($_REQUEST['user']) &&
    isset($_REQUEST['pass'])
    )
    {
        $ime=$_REQUEST['ime'];
        $prezime=$_REQUEST['prezime'];
        $mail=$_REQUEST['mail'];
        $user=$_REQUEST['user'];
        $pass=$_REQUEST['pass'];
        $token=bin2hex(random_bytes(50)); //Generiše jedinstveni token

        
        $sql = "SELECT * FROM korisnici WHERE email='".$mail."' OR korsinicko_ime='".$user."' LIMIT 1";//Provjeraval da li unesena mail adresa ili korisnicko ime vec postoje u bazi
        $sql1 = "SELECT * FROM korisnici WHERE email='".$mail."' LIMIT 1";
        $sql2 = "SELECT * FROM korisnici WHERE korsinicko_ime='".$user."' LIMIT 1";
        $result = mysqli_query($connection, $sql1);
        $result2 = mysqli_query($connection, $sql2);
        
        if (mysqli_num_rows($result) > 0)
        {
            header("Location: registracija.php");            
            $_SESSION['alert']="alert alert-danger";
            setcookie("notification", "Uneseni mail već postoji u bazi", time()+60*60*24, "/");
        }
        else if(mysqli_num_rows($result2) > 0)
        {
            header("Location: registracija.php");            
            $_SESSION['alert']="alert alert-danger";
            setcookie("notification", "Uneseno korisnicko ime već postoji u bazi", time()+60*60*24, "/");
        }
        else {
            $query = "INSERT INTO `korisnici` (`id`, `ime`, `prezime`, `korsinicko_ime`, `email`, `verifikovan`, `token`, `lozinka`) 
                        VALUES (NULL, '".$ime."', '".$prezime."', '".$user."', '".$mail."', 0, '".$token."', SHA1('".$pass."'));";
            if ($connection->query($query) === TRUE) 
            {
                        $body = '<!DOCTYPE html>
                                <html lang="en">

                                <head>
                                <meta charset="UTF-8">
                                <title>Verifikacija</title>
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
                                    <p>Molimo kliknite na link ispod da verifikujete Vaš nalog:</p>
                                    <a href="http://localhost/verifyMail.php?token=' . $token . '">Verifikuj Email</a>
                                </div>
                                </body>
                                </html>';
                        sendVerificationEmail($mail, $token, $body,'Verifikujte svoj nalog');
                        $sql = "SELECT * FROM `korisnici` WHERE `korsinicko_ime` = '".$user."'";
                        $result = $connection->query($sql);
                        if($result->num_rows > 0)
                        {
                            $korisnik = mysqli_fetch_assoc($result);
                            $korisnikID = $korisnik['id'];
                            $sql2 = "INSERT INTO `tipizacija`(`korisnici_id`, `rola`) VALUES ('".$korisnikID."','radnik')";
                            if ($connection->query($sql2) === TRUE)
                            {
                                $_SESSION['alert']="alert alert-info";
                                setcookie("notification", "Na Vašu mail adresu je poslat verifikacioni email!", time()+60*60*24, "/");
                                header("Location: prijava.php");
                            }
                        }
                 
            }
            else 
            {
                header("Location: registracija.php");
                $_SESSION['alert']="alert alert-danger";
                setcookie("notification", "Greška! Trenutno nije moguće dodati novog korisnika!", time()+60*60*24, "/");
            }
        }
    }
    else
        header("Location: ./registracija.php");
?>