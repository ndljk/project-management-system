<?php
    session_start();

    if(isset($_SESSION['loggedUser']))
        header("Location: index.php");
    else {
        if(!isset($_GET['token']))
        {
            $_SESSION['alert']="alert alert-danger";
            setcookie("notification", "Neispravan token!", time()+60*60*24, "/");
            header("Location: prijava.php");
        }
        else {
            $_SESSION['token']=$_GET['token'];
        }
    }
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
    <script src="script.js"></script>
</head>
<body class="main contrainer-fluid">    
    <?php
        include "konekcija.php";
        include "coockieAlert.php";
    ?>
    <div class="row justify-content-center">
        <form class="form-group container-sm col-6" action="rePasswordCheck.php" method="post">
            <h1 class="ml-2 mr-2 mt-4 title"> Upravljanje projektnim zadacima </h1>
            <label class="natpis fw-bold mb-2" for="rePass">Vaša nova lozinka: </label>
            <input type="password" class="form-control mb-2" id="rePass" name="rePass" onkeyup="checkPass()" required>
            <label class="natpis fw-bold mb-2" for="rePassConf">Potvrdite Vašu novu lozinku: </label>
            <input type="password" class="form-control mb-2" id="rePassConf" name="rePassConf" onkeyup="checkPass()" required>
            <div class="form-check">
                <label class="form-check-label natpis fw-bold mb-2">
                    <input type="checkbox" class="form-check-input" onclick="prikaziLozinke()">Prikaži unesene lozinke
                </label>
            </div>
            <div class="dugme">
                <button id="submit" type="submit" class="btn btn-success mt-4 mb-4" disabled> Snimi izmjene</button>
            </div>               
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js" integrity="sha384-Atwg2Pkwv9vp0ygtn1JAojH0nYbwNJLPhwyoVbhoPwBhjQPR5VtM2+xf0Uwh9KtT" crossorigin="anonymous"></script>

    <script>
    //Provjerava da li su prilikom resetovanja lozinke, unesene lozinke jednake
    //te u zavisnosti od toga o(ne)mogucava submit btn
    function checkPass() {
        if((document.getElementById('rePass').value !="") ||
            (document.getElementById('rePassConf').value!=""))
            {
                if (document.getElementById('rePass').value ==
                    document.getElementById('rePassConf').value) 
                {
                    document.getElementById('submit').disabled = false;
                } 
                else 
                {
                document.getElementById('submit').disabled = true;
                }
            }else
            {
                 document.getElementById('submit').disabled = true;               
            }
    }
    </script>

</body>

