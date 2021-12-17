<?php

//KONEKCIJA NA BAZU PODATAKA

$connection=mysqli_connect("localhost","root","","itp2021");

if(!$connection)
{
    $_SESSION['alert']="alert alert-danger";
    setcookie("notification", "Neuspješna konekcija na bazu!", time()+3600*24, "/");
}
?>