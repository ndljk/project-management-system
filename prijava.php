<?php
    session_start();

    if(isset($_SESSION['loggedUser']))
        header("Location: index.php?nazivProjekta=");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prijava</title>
    <!-- Icon library -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body class="main contrainer-fluid">    
    <?php
        include "konekcija.php";
        include "coockieAlert.php";
    ?>
    <div class="row justify-content-center">
        <form class="form-group container-sm col-6" action="provjeraPrijave.php" method="get">
            <h1 class="ml-2 mr-2 mt-4 title"> Upravljanje projektnim zadacima </h1>
            <h2 class="mt-4 mb-3 title"> PRIJAVA </h2>
            <label class="natpis fw-bold mb-2" for="username">Korisničko ime ili e-pošta: </label>
            <input type="text" class="form-control mb-2" id="username" name="username" required>
            <label class="natpis fw-bold mb-2" for="password">Lozinka: </label>
            <div class="input-group mb-2">
                <input type="password" class="form-control mb-2" id="password" name="password" required>
                <div class="input-group-append" style="margin-right: 20%">
                    <button onclick="prikaziLozinku()" class="btn btn-secondary" type="button"><i id="btnIcon" class="fa fa-eye"></i></button>
                </div>
            </div>           
            <hr/>
            <span>
                <a href="resetLozinke.php" class="natpis fw-bold mb-2">Zaboravili ste lozinku?</a>
            </span>
            <div class="dugme">
                <button type="submit" class="btn btn-success mt-4 mb-4"> PRIJAVI SE</button>
                <input type="button" class="btn btn-secondary mt-4 mb-4" value="Registruj se" onClick="document.location.href='registracija.php'"></input>
            </div>               
        </form>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js" integrity="sha384-Atwg2Pkwv9vp0ygtn1JAojH0nYbwNJLPhwyoVbhoPwBhjQPR5VtM2+xf0Uwh9KtT" crossorigin="anonymous"></script>
    
    <!-- Funkcija za prikaz lozinke i promjenu ikonice na buttonu. NECE DA SE POKRENE IZ script.js PA JE UKLJUCENA OVAKO-->
    <script>
        function prikaziLozinku()
        {
        var element = document.getElementById("password");
        var icon = document.getElementById("btnIcon");

        if (element.type === "password") 
        {
            element.type = "text";
            icon.className="fa fa-eye-slash";
        } 
        else 
        {
            element.type = "password";
            icon.className="fa fa-eye";
        }
        }
    </script>
</body>