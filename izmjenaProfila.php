<?php
    session_start();
    if(!isset($_SESSION['loggedUser']))
    header("Location: prijava.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">

    <link rel="stylesheet" href="style.css">

    <!-- Icon library -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <script src="script.js"></script>
    <title>Izmjena profila</title>
</head>
<body class="main">
    <?php
        include "navbar.php";
        include "coockieAlert.php";
    ?>
     <div class="row justify-content-center">
        <form class="form-group reg container-sm col-6" action="izmjenaProfilaValidacija.php" method="post">
            <h2 class="mt-4 mb-3 title"> Izmjena profila </h2>
            <label class="natpis fw-bold mb-2" for="chIme">Ime: </label>
            <input type="text" class="form-control mb-2" id="chIme" name="chIme" value="<?=$_SESSION['loggedUser']['ime']?>" required>
            <label  for="chPrezime" class="natpis fw-bold mb-2">Prezime: </label>
            <input type="text" class="form-control mb-2" id="chPrezime" name="chPrezime" value="<?=$_SESSION['loggedUser']['prezime']?>" required>
            <label class="natpis fw-bold mb-2" for="chMail">E-pošta: </label>
            <input type="email" class="form-control mb-2" id="chMail" name="chMail" value="<?=$_SESSION['loggedUser']['email']?>" required>
            <label class="natpis fw-bold mb-2" for="chUsername">Korisničko ime: </label>
            <input type="text" class="form-control mb-2" id="chUsername" name="chUsername" value="<?=$_SESSION['loggedUser']['korsinicko_ime']?>" required>
            <label  for="chPassword" class="natpis fw-bold mb-2">Lozinka: </label>
            <div class="input-group mb-3">
                <input type="password" class="form-control" id="chPassword" name="chPassword">
                <div class="input-group-append" style="margin-right: 20%">
                    <button onclick="prikaziLozinku()" class="btn btn-secondary" type="button"><i id="btnIcon" class="fa fa-eye"></i></button>
                </div>
            </div>
            <div class="dugme"><button type="submit" class="btn btn-success mt-4 mb-4"> Izmjeni podatke</button></div>            
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js" integrity="sha384-Atwg2Pkwv9vp0ygtn1JAojH0nYbwNJLPhwyoVbhoPwBhjQPR5VtM2+xf0Uwh9KtT" crossorigin="anonymous"></script>
    
    <!-- Funkcija za prikaz lozinke i promjenu ikonice na buttonu. NECE DA SE POKRENE IZ script.js PA JE UKLJUCENA OVAKO-->
    <script>
        function prikaziLozinku()
        {
        var element = document.getElementById("chPassword");
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
</html>