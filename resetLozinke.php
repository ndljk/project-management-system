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
    <title>Resetovanje lozinke</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body class="main contrainer-fluid">    
    <?php
        include "konekcija.php";
        include "coockieAlert.php";
    ?>
    <div class="row justify-content-center">
        <form class="form-group container-sm col-6" action="mailLozinka.php" method="get">
            <h1 class="ml-2 mr-2 mt-4 title"> Upravljanje projektnim zadacima </h1>
            <label class="natpis fw-bold mb-2">Na Vašu e-mail adresu ćemo poslati link za resetovanje lozinke</label>
            <label class="natpis fw-bold mb-2" for="zabLozinka">Unesite Vašu e-mail adresu: </label>
            <input type="mail" class="form-control mb-2" id="zabLozinka" name="zabLozinka" placeholder="example@mail.com" required>
            <div class="dugme">
                <button type="submit" class="btn btn-success mt-4 mb-4"> Pošalji</button>
            </div>               
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js" integrity="sha384-Atwg2Pkwv9vp0ygtn1JAojH0nYbwNJLPhwyoVbhoPwBhjQPR5VtM2+xf0Uwh9KtT" crossorigin="anonymous"></script>
</body>