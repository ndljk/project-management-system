<?php
    session_start();
    include "konekcija.php";

    if(isset($_REQUEST['rePass']) &&
        isset($_REQUEST['rePassConf']))
    {
        $rePass=$_REQUEST['rePass'];
        $rePassConf=$_REQUEST['rePassConf'];
        
        $token = $_SESSION['token'];
        $user = mysqli_fetch_assoc($result);
        $query = "UPDATE `korisnici` SET `lozinka` = SHA1('".$rePass."') WHERE token='$token'";
        if (mysqli_query($connection, $query)) {            
            $_SESSION['alert']="alert alert-success";
            setcookie("notification", "Uspješno ste promijenili Vašu lozinku!", time()+60*60*24, "/");
            header('location: prijava.php');
        }
        else {
            $_SESSION['alert']="alert alert-danger";
            setcookie("notification", "Dogodila se greška! Pokušajte ponovo.", time()+60*60*24, "/");
            header('location: prijava.php');
        }
    }
    else {
        die("GREŠKA!");
    }
?>