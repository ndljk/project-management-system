<?php
session_start();

if(!isset($_SESSION['loggedUser']))
    header("Location: prijava.php");

if(isset($_REQUEST['projekat']))
{
    $naziv = $_REQUEST['projekat'];
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

    <!-- Latest compiled and minified CSS MULTISELECT-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">

    <!-- Latest compiled and minified JavaScript MULSTISELECT-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>

    <link rel="stylesheet" href="style.css">

    <script src="script.js"></script>
    <title>Izmjeni projekat</title>
</head>
<body class="main">
    <?php 
        include "navbar.php";
        include "konekcija.php";

        $upit="SELECT * FROM `korisnici` LEFT JOIN `tipizacija` ON korisnici.id=tipizacija.korisnici_id WHERE rola!='administrator'";
        $upit2 = "SELECT * FROM `projekat` WHERE `naziv`='".$naziv."'";       
        $rezultat = $connection->query($upit);
        $rezultat2 = $connection->query($upit2);
        if($rezultat2->num_rows>0)
        {
            $projekat = mysqli_fetch_assoc($rezultat2);
    ?>
    <div class="row justify-content-center">
        <form  method="post" action="izmjenaProjekta.php?naziv=<?=$naziv?>" id="forma" class="form-group container-sm col-6 mt-5">
            <h2 class="mt-4 mb-3 title">IZMJENI PROJEKAT</h2>
            <label class="natpis fw-bold mb-2" for="nazivProjekta">Naziv projekta: </label>
            <input required type="text" class="form-control mb-2" name="nazivProjekta2" value="<?=$projekat['naziv']?>" id="nazivProjekta">
            <label class="natpis fw-bold mb-2" for="opis">Opis:  </label>
            <textarea required class="form-control mb-2" id="opis" name="opis2"><?=$projekat['opis']?></textarea>
            <label class="natpis fw-bold mb-2" for="datum">Datum kreiranja: </label>
            <input required type="date" id="datum" class="form-control mb-2" name="datum2" value="<?=$projekat['datum']?>">
            
            <label class="natpis fw-bold mb-2">Projekt menadžer(i): </label><br>
            <div class="form-group mb-2" style="margin: 0 20% 0 20%">
                <select required class=" form-control selectpicker" name="select2[]" multiple>
                <?php
                if($rezultat->num_rows>0)
                {
                    while ($red = mysqli_fetch_assoc($rezultat))
                    {
                        ?>
                         <option value="<?= $red['id']?>"><?= $red['ime']?> <?= $red['prezime']?></option>
                        <?php
                    }
                }
                ?>
                </select>
            </div>
            <script>$('select').selectpicker();</script>
            <div class="dugme">
                <button type="submit" class="btn btn-success mt-4 mb-4"> IZMJENI </button>
            </div>
        </form>
    </div>
</body>
</html>

<?php
        }
    }
?>

