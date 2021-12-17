<?php
include "konekcija.php";

session_start();
if(!isset($_SESSION['loggedUser']))
    header("Location: prijava.php");
if(!isset($_REQUEST['zadatak']))
    header("Location: index.php?nazivProjekta=");

$deleteUpit="DELETE FROM `zadatak` WHERE `zadatak`.`naziv` = '".$_REQUEST['zadatak']."'";

if ($connection->query($deleteUpit) === TRUE) {
    header("Location: index.php?nazivProjekta=".$_SESSION['nazivProjekta']);
} else {  
    $_SESSION['alert']="alert alert-danger";
    setcookie("notification", "Nije moguće obrisati zadatak!", time()+60*60*24, "/");
    header("Location: index.php?nazivProjekta=".$_SESSION['nazivProjekta']);
}
?>