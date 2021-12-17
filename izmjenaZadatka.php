<?php
session_start();
include "konekcija.php";

if(empty($_POST))   //PROVJERAVA DA LI SU NAPRAVLJENJE BILO KAKVE IZMJENE NA ZADATKU PROVJERAVANJEM $_POST NIZA
{
    $_SESSION['alert']="alert alert-primary";
    setcookie("notification", "Niste napravili nikakvu izmjenu na zadatku!", time()+60*60*24, "/");
    header("Location: zadaciDetalji.php?nazivZadatka=".$_SESSION['nazivZadatka']);
}
else 
{
    $upisiuBazu=0;
    $upit="UPDATE `zadatak` SET ";
    if(array_key_exists('nazivZadatka', $_POST))
    {
        $upit.="`naziv` = '".$_POST['nazivZadatka']."', ";
        $upisiuBazu=1;
    }        
    if(array_key_exists('opisZadatka', $_POST))
    {
        $upit.="`opis` = '".$_POST['opisZadatka']."', "; 
        $upisiuBazu=1;
    }         
    if(array_key_exists('predvidjenoVrijeme', $_POST))
    {
        $upit.="`vrijeme` = '".$_POST['predvidjenoVrijeme']."', ";
        $upisiuBazu=1;
    }          
    if(array_key_exists('statusZadatka', $_POST))
    {
        $upit.="`status` = '".$_POST['statusZadatka']."', ";
        $upisiuBazu=1;
    }         
    
    $noviUpit=rtrim($upit, ", ");
    $noviUpit.=" WHERE `zadatak`.`id` = (select id from zadatak where zadatak.naziv='".$_SESSION['nazivZadatka']."' limit 1);";

    //die($noviUpit); //Provjera izgleda upita

    if(array_key_exists('radnici', $_POST))
    {        
        $upitBrisanje="DELETE FROM `korisnici_zadatak` WHERE korisnici_zadatak.zadatak_id=(select id from zadatak where zadatak.naziv='".$_SESSION['nazivZadatka']."' limit 1)";   
        if ($connection->query($upitBrisanje)=== TRUE)
        {
            foreach($_POST['radnici'] as $value)
            {
                $upitKorisnikzadaci="INSERT INTO `korisnici_zadatak` (`korisnici_id`, `zadatak_id`) VALUES
                        ((select id from korisnici where CONCAT_WS(' ',ime,prezime)='".$value."' limit 1), 
                        (SELECT id from zadatak where zadatak.naziv='".$_SESSION['nazivZadatka']."' limit 1))";
                //echo($upitKorisnikzadaci);
                if (mysqli_query($connection, $upitKorisnikzadaci))
                {
                    $_SESSION['alert']="alert alert-success";
                    setcookie("notification", "Uspješno ste izmjenili zadatak!", time()+60*60*24, "/");
                }
                else
                {                
                    $_SESSION['alert']="alert alert-danger";
                    setcookie("notification", "Dogodila se greška prilikom izmjene zadatka!", time()+60*60*24, "/");
                    header("Location: zadaciDetalji.php?nazivZadatka=". $_SESSION['nazivZadatka']);
                }

            }
        }else
        {                
            $_SESSION['alert']="alert alert-danger";
            setcookie("notification", "Puklo ovdje!", time()+60*60*24, "/");
            header("Location: zadaciDetalji.php?nazivZadatka=". $_SESSION['nazivZadatka']);
        }
    }    

    if($upisiuBazu==1)
    {
        if (mysqli_query($connection, $noviUpit))
        {
            $_SESSION['alert']="alert alert-success";
            setcookie("notification", "Uspješno ste ažurirali zadatak!", time()+60*60*24, "/");
            
        }
        else
        {
            $_SESSION['alert']="alert alert-danger";
            setcookie("notification", "Dogodila se greška prilikom izmjene zadatka!", time()+60*60*24, "/");
            header("Location: zadaciDetalji.php?nazivZadatka=". $_SESSION['nazivZadatka']);
        }
    }   

    if(array_key_exists('nazivZadatka', $_POST))
        header("Location: zadaciDetalji.php?nazivZadatka=". $_POST['nazivZadatka']);   
    else
        header("Location: zadaciDetalji.php?nazivZadatka=". $_SESSION['nazivZadatka']);
    
}
?>