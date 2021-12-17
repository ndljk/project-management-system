<?php
    session_start();
    
    include "konekcija.php";

    $upit="UPDATE `korisnici` SET 
            `ime` = '".$_POST['chIme']."', `prezime` = '".$_POST['chPrezime']."', 
            `korsinicko_ime` = '".$_POST['chUsername']."', `email` = '".$_POST['chMail']."'"; 

    if($_POST['chPassword']!="")
        $upit.=", `lozinka` = SHA1('".$_POST['chPassword']."') ";

    $upit.="WHERE `korisnici`.`id` = ".$_SESSION['loggedUser']['id'];
    if (mysqli_query($connection, $upit)) {  
            $_SESSION['loggedUser']['korsinicko_ime']=$_POST['chUsername'];   
            $_SESSION['loggedUser']['ime']=$_POST['chIme'];  
            $_SESSION['loggedUser']['prezime']=$_POST['chPrezime'];   
            $_SESSION['loggedUser']['email']=$_POST['chMail'];     
            $_SESSION['alert']="alert alert-success";
            setcookie("notification", "Uspješno ste ažurirali Vaš nalog!", time()+60*60*24, "/");
            header('location: izmjenaProfila.php');
        }
    else {
        $_SESSION['alert']="alert alert-danger";
        setcookie("notification", "Dogodila se greška! Pokušajte ponovo.", time()+60*60*24, "/");
        header('location: izmjenaProfila.php');
    }

    //var_dump($upit);
?>