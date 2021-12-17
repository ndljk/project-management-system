<?php
	session_start();
	include "konekcija.php";

	if(isset($_REQUEST['nazivProjekta'])
	&& isset($_REQUEST['opis'])
	&& isset($_REQUEST['select']))
	{
		$naziv = $_REQUEST['nazivProjekta'];
		$opis = $_REQUEST['opis'];
		$menadzerID = $_REQUEST['select'];

		$upit1 = "INSERT INTO `projekat`(`id`, `naziv`, `opis`, `datum`) VALUES (NULL,'".$naziv."','".$opis."', CURDATE())";

		//print_r($_POST["select"]); //Provjera sta vraca multiselect
		
		if($connection->query($upit1)=== TRUE)
		{	
			foreach ($_POST['select'] as $projektMenadzer)  
			{
				$upit2="INSERT INTO `korisnici_projekat` (`korisnici_id`, `projekat_id`) 
						VALUES ('".$projektMenadzer."', (SELECT id FROM `projekat` WHERE projekat.naziv='".$naziv."' LIMIT 1));";
				if (mysqli_query($connection, $upit2))
				{
					$upit3="UPDATE tipizacija SET tipizacija.rola='projekt menadzer' WHERE tipizacija.korisnici_id=".$projektMenadzer;
					if (mysqli_query($connection, $upit3))
					{
						$_SESSION['alert']="alert alert-success";
						setcookie("notification", "Uspješno ste kreirali novi projekat!", time()+60*60*24, "/");
						header("Location: index.php?nazivProjekta=".$naziv);
					}
					else
					{
						$_SESSION['alert']="alert alert-danger";
						setcookie("notification", "Dogodila se greška prilikom kreiranja projekta!", time()+60*60*24, "/");
						header("Location: index.php?nazivProjekta=");	
					}
				}
				else
				{					
					$_SESSION['alert']="alert alert-danger";
					setcookie("notification", "Dogodila se greška prilikom kreiranja projekta!", time()+60*60*24, "/");
					header("Location: index.php?nazivProjekta=");
				}
			}			
			
		}
		else
		{
			$_SESSION['alert']="alert alert-danger";
			setcookie("notification", "Dogodila se greška prilikom kreiranja projekta!", time()+60*60*24, "/");
			header("Location: index.php?nazivProjekta=");	
		}
	}
?>