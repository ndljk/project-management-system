<?php
session_start();

include "konekcija.php";

if(isset($_GET['token'])) 
{
    $token = $_GET['token'];
    $sql = "SELECT * FROM korisnici WHERE token='$token' LIMIT 1";
    $result = mysqli_query($connection, $sql);

    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        $query = "UPDATE korisnici SET verifikovan=1 WHERE token='$token'";

        if (mysqli_query($connection, $query)) {            
            $_SESSION['alert']="alert alert-success";
            setcookie("notification", "Uspješno ste verifikovali Vaš nalog!", time()+60*60*24, "/");
            header('location: prijava.php');
        }
    } else {
        $_SESSION['alert']="alert alert-danger";
        setcookie("notification", "Token nije validan!", time()+60*60*24, "/");
        header('location: prijava.php');
    }
} else {
    $_SESSION['alert']="alert alert-danger";
    setcookie("notification", "Token nije validan!", time()+60*60*24, "/");
    header('location: prijava.php');
}