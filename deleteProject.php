<?php
session_start();

    if(!isset($_SESSION['loggedUser']))
        header("Location: prijava.php");

    include 'konekcija.php';

    if(isset($_REQUEST['projekat']))
    {
        $naziv = $_REQUEST['projekat'];
        $sql = "DELETE FROM `projekat` WHERE `naziv`='".$naziv."'";

         if($connection->query($sql) === TRUE)
         {
            $_SESSION['alert']="alert alert-success";
            setcookie("notification", "Uspješno ste obrisali projekat!", time()+60*60*24, "/");
            header("Location: index.php?nazivProjekta=");
         }
         else
         {
            $_SESSION['alert']="alert alert-danger";
            setcookie("notification", "Dogodila se greška prilikom brisanja!", time()+60*60*24, "/");
            header("Location: index.php?nazivProjekta=");
         }
    }

?>