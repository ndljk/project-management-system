<?php
session_start();
include "konekcija.php";


    $komentar=$_REQUEST['komentar'];
    $vrijemePocetka=$_REQUEST['datumPocetka'];

    $upit="INSERT INTO `evidencija_vremena` (`id`, `utroseno_vrijeme`, `komentar`, `vrijeme_evidentiranja`, `korisnici_id`, `zadatak_id`) 
            VALUES (NULL, '".$vrijemePocetka."', '".$komentar."', NOW(), '".$_SESSION['loggedUser']['id']."', 
            (SELECT id FROM zadatak where zadatak.naziv='".$_SESSION['nazivZadatka']."' limit 1))";

    if ($connection->query($upit) === TRUE)
    {
        $_SESSION['alert']="alert alert-success";
        setcookie("notification", "Uspješno ste evidentirali vrijeme i dodali komentar!", time()+60*60*24, "/");
        header("Location: zadaciDetalji.php?nazivZadatka=".$_SESSION['nazivZadatka']);
    }
    else {
        $_SESSION['alert']="alert alert-danger";
        setcookie("notification", "Dogodila se greška!", time()+60*60*24, "/");
        header("Location: zadaciDetalji.php?nazivZadatka=".$_SESSION['nazivZadatka']);
    }
?>