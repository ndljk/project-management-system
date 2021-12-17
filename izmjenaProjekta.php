<?php
session_start();
include "konekcija.php";

//die($_REQUEST['nazivProjekta2']);

if(!isset($_SESSION['loggedUser']))
    header("Location: prijava.php");
if(isset($_REQUEST['naziv']))
{
    if(isset($_REQUEST['nazivProjekta2'])
	&& isset($_REQUEST['opis2'])
	&& isset($_REQUEST['datum2'])
	&& isset($_REQUEST['select2']))
	{
		$naziv = $_REQUEST['nazivProjekta2'];
		$opis = $_REQUEST['opis2'];
		$datum = $_REQUEST['datum2'];
		$menadzerID = $_REQUEST['select2'];
    }

    $sql1 = "UPDATE `projekat` SET `naziv`='".$naziv."',`opis`='".$opis."',`datum`='".$datum."' WHERE `naziv`='".$_SESSION['nazivProjekta']."'";
    
    if (mysqli_query($connection, $sql1))
    {
        $sql2="DELETE FROM korisnici_projekat WHERE
				korisnici_projekat.projekat_id=(SELECT id FROM projekat WHERE projekat.naziv='".$_SESSION['nazivProjekta']."')";
		if ($connection->query($sql2)=== TRUE)
		{
			foreach ($_POST['select2'] as $projektMenadzeri)  
			{
				$sql3="INSERT INTO `korisnici_projekat` (`korisnici_id`, `projekat_id`) 
						VALUES ('".$projektMenadzeri."', (SELECT id FROM `projekat` WHERE projekat.naziv='".$naziv."' LIMIT 1));";
				if (mysqli_query($connection, $sql3))
				{
					$sql4="UPDATE tipizacija SET tipizacija.rola='projekt menadzer' WHERE tipizacija.korisnici_id=".$projektMenadzeri;
					if (mysqli_query($connection, $sql4))
					{
						$_SESSION['alert']="alert alert-success";
						setcookie("notification", "Uspješno ste izmjenili podatke projekta!", time()+60*60*24, "/");
						header("Location: index.php?nazivProjekta=".$_SESSION['nazivProjekta']);
					}
					else
					{
						$_SESSION['alert']="alert alert-danger";
						setcookie("notification", "Dogodila se greška prilikom izmjene projekta!", time()+60*60*24, "/");
						header("Location: index.php?nazivProjekta=".$_SESSION['nazivProjekta']);
					}
				}
				else
				{
					$_SESSION['alert']="alert alert-danger";
					setcookie("notification", "Dogodila se greška prilikom izmjene projekta!", time()+60*60*24, "/");
					header("Location: index.php?nazivProjekta=".$_SESSION['nazivProjekta']);
				}
			}
		}
		else
		{
			$_SESSION['alert']="alert alert-danger";
			setcookie("notification", "Dogodila se greška prilikom izmjene projekta!", time()+60*60*24, "/");
			header("Location: index.php?nazivProjekta=".$_SESSION['nazivProjekta']);
		}					
    }
	else
	{
		echo('Puko 1 upit');
		$_SESSION['alert']="alert alert-danger";
		setcookie("notification", "Dogodila se greška prilikom izmjene projekta!", time()+60*60*24, "/");
		header("Location: index.php?nazivProjekta=".$_SESSION['nazivProjekta']);
	}
}
?>