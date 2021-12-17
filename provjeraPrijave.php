<?php
    session_start();
    include "konekcija.php";

    if(isset($_REQUEST['username']) && isset($_REQUEST['password']))
    {
        $username = $_REQUEST['username'];
        $password = $_REQUEST['password'];
        
        $loginUpit="SELECT * FROM `korisnici` LEFT JOIN `tipizacija` 
                    ON korisnici.id=tipizacija.korisnici_id WHERE
                    (korsinicko_ime='".$username."' OR email='".$username."')
                    AND lozinka='".sha1($password)."'";

        $login = $connection->query($loginUpit);
        //var_dump($login);
        if($login->num_rows>0)
        {
            $user = mysqli_fetch_assoc($login);
            if($user['verifikovan']==1)
            {
                
                $_SESSION['loggedUser']=$user;
                header("Location: index.php?nazivProjekta=");
            }
            else
            {
                $_SESSION['alert']="alert alert-danger";
                setcookie("notification", "Vaš nalog nije verifikovan!", time()+60*60*24, "/");
                header("Location: prijava.php");
            }
        }
        else
        {
            $_SESSION['alert']="alert alert-danger";
            setcookie("notification", "Lozinka ili korisničko ime nisu ispravni!", time()+60*60*24, "/");
            header("Location: prijava.php");
        }
    }
    else 
        header("Location: prijava.php");
?>