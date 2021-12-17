<?php
session_start();
include "konekcija.php";

$nazivZadatka=$_REQUEST['nazivZadatka'];
$opisZadatka=$_REQUEST['opisZadatka'];
$krajnjiRok=$_REQUEST['krajnjiDatum'];

$upit2="INSERT INTO `korisnici_zadatak` (`korisnici_id`, `zadatak_id`) VALUES ";
//die($_SESSION['indeks']);
for($i=0;$i<=$_SESSION['indeks'];$i++)
{
    if(isset($_REQUEST[$i]))
    {
        $upit2.="((SELECT id from korisnici where CONCAT_WS( ' ',ime, prezime )='".$_REQUEST[$i]."' limit 1),(SELECT id FROM `zadatak` WHERE zadatak.naziv='".$nazivZadatka."' limit 1)),";
    }
}
$noviUpit2=rtrim($upit2, ", "); //UKLANJA "," KOJI STOJI NA KRAJU DA BI SE UPIT MOGAO IZVRSITI

$upit="INSERT INTO `zadatak` (`id`, `naziv`, `opis`, `vrijeme`, `datum_kreiranja`, `status`, `projekat_id`) 
        VALUES (NULL, '".$nazivZadatka."', '".$opisZadatka."', '".$krajnjiRok."', CURRENT_DATE(), 'novo', 
        (select id from projekat where projekat.naziv='".$_SESSION['nazivProjekta']."'));";

if ($connection->query($upit) === TRUE)
{
    if($noviUpit2!="INSERT INTO `korisnici_zadatak` (`korisnici_id`, `zadatak_id`) VALUES")
    {
        if ($connection->query($noviUpit2) === TRUE)
        {
            $_SESSION['alert']="alert alert-success";
            setcookie("notification", "Uspješno ste kreirali novi zadatak!", time()+60*60*24, "/");
            header("Location: index.php?nazivProjekta=".$_SESSION['nazivProjekta']);
        }
        else
        {
            //die('Puklo kod upisa u korisnici_zadatak');
            $_SESSION['alert']="alert alert-danger";
            setcookie("notification", "Dogodila se greška! Pokušajte ponovo!", time()+60*60*24, "/");
            header("Location: index.php?nazivProjekta=".$_SESSION['nazivProjekta']);
        }
    }
    else
    {
        $_SESSION['alert']="alert alert-success";
        setcookie("notification", "Uspješno ste kreirali novi zadatak!", time()+60*60*24, "/");
        header("Location: index.php?nazivProjekta=".$_SESSION['nazivProjekta']);
    }          
}
else {
    //die('Puklo kod upisa u zadatak');
    $_SESSION['alert']="alert alert-danger";
    setcookie("notification", "Dogodila se greška! Pokušajte ponovo!", time()+60*60*24, "/");
    header("Location: index.php?nazivProjekta=".$_SESSION['nazivProjekta']);
}
?>