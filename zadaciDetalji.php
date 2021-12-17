<?php
    session_start();
    if(!isset($_SESSION['loggedUser']))
        header("Location: prijava.php");
    if(!isset($_REQUEST['nazivZadatka']))
        header("Location: index.php");
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

     <!-- Icon library -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="style.css">

    <script src="script.js"></script>
    <title><?=$_REQUEST['nazivZadatka']?>-detalji</title>
</head>
<body class="main">
    <?php
        include "navbar.php";
        include "coockieAlert.php";

        $nazivZadatka=$_REQUEST['nazivZadatka'];
        $_SESSION['nazivZadatka']=$nazivZadatka;

        $upit="SELECT * FROM `zadatak` WHERE naziv='".$nazivZadatka."'";
        $rezultat = $connection->query($upit);
        if($rezultat->num_rows>0)
        {
            $zadatak = mysqli_fetch_assoc($rezultat);  
            //die($zadatak['vrijeme']);      
    ?>
     <div class="row justify-content-center">
        <form class="form-group reg container-sm col-6" action="izmjenaZadatka.php" method="POST">
            <h2 class="mt-4 mb-3 title"> Detaljan prikaz zadatka </h2>
            <p ><i class="fa fa-info-circle" aria-hidden="true"></i> Ukoliko obavite bilo kakvu izmjenu obavezno je <a href="#sacuvajZadatak">sačuvajte</a>!</p>
            
            <label class="natpis fw-bold mb-2" for="nazivZadatka">Naziv zadatka: </label>
            <div class="input-group mb-3">
                <input type="text" class="form-control" id="nazivZadatka" name="nazivZadatka" value="<?=$nazivZadatka?>" disabled>
                <div class="input-group-append" style="margin-right: 20%">
                    <button data-toggle="tooltip" data-placement="right" title="Izmjeni" onclick="enabledDisabled('nazivZadatka')" class="btn btn-secondary" type="button"><i id class="fa fa-pencil"></i></button>
                </div>
            </div>
            <label class="natpis fw-bold mb-2" for="opisZadatka">Opis zadatka: </label>
            <div class="input-group mb-3">
                <input type="text" class="form-control" id="opisZadatka" name="opisZadatka" value="<?=$zadatak['opis']?>" disabled>
                <div class="input-group-append" style="margin-right: 20%">
                    <button data-toggle="tooltip" data-placement="right" title="Izmjeni" onclick="enabledDisabled('opisZadatka')" class="btn btn-secondary" type="button"><i id class="fa fa-pencil"></i></button>
                </div>
            </div>
            <label class="natpis fw-bold mb-2" for="predvidjenoVrijeme">Predviđeno vrijeme: </label>
            <div class="input-group mb-3">
                <input type="date" class="form-control" id="predvidjenoVrijeme" name="predvidjenoVrijeme" value="<?php echo date('Y-m-d',strtotime($zadatak['vrijeme'])) ?>" disabled>
                <div class="input-group-append" style="margin-right: 20%">
                    <button data-toggle="tooltip" data-placement="right" title="Izmjeni" onclick="enabledDisabled('predvidjenoVrijeme')" class="btn btn-secondary" type="button"><i class="fa fa-pencil"></i></button>
                </div>
            </div>
            <label class="natpis fw-bold mb-2" for="statusZadatka">Status : </label>
            <div class="input-group mb-3">
                <?php
                    switch($zadatak['status'])
                    {
                        case 'novo':
                        ?>
                            <select class="form-control" id="statusZadatka" name="statusZadatka" onchange="selectColor()" disabled>
                                <option value="novo" style="background-color: white" selected>Novo</option>
                                <option value="u izradi" style="background-color: white" >U izradi</option>
                                <option value="zavrseno" style="background-color: white">Završeno</option>
                            </select>
                        <?php
                        break;
                        case 'u izradi':
                        ?>
                            <select class="form-control" id="statusZadatka" name="statusZadatka" onchange="selectColor()" disabled>
                                <option value="novo" style="background-color: white" >Novo</option>
                                <option value="u izradi" style="background-color: white" selected>U izradi</option>
                                <option value="zavrseno" style="background-color: white">Završeno</option>
                            </select>
                        <?php
                        break;
                        case 'zavrseno':
                        ?>
                            <select class="form-control" id="statusZadatka" name="statusZadatka" onchange="selectColor()" disabled>
                                <option value="novo" style="background-color: white" >Novo</option>
                                <option value="u izradi" style="background-color: white" >U izradi</option>
                                <option value="zavrseno" style="background-color: white" selected>Završeno</option>
                            </select>
                        <?php
                        break;
                    }
                }      
                ?>
                <div class="input-group-append" style="margin-right: 20%">
                    <button data-toggle="tooltip" data-placement="right" title="Izmjeni" onclick="enabledDisabled('statusZadatka')" class="btn btn-secondary" type="button"><i class="fa fa-pencil"></i></button>
                </div>  
            </div>          
            <?php
            $upitRadniciDodijeljeni="SELECT id, ime, prezime FROM korisnici left JOIN korisnici_zadatak on korisnici.id=korisnici_zadatak.korisnici_id 
                                    where korisnici_zadatak.zadatak_id=(SELECT id from zadatak where zadatak.naziv='".$nazivZadatka."' limit 1)";
            $rezultatRadniciDodijeljeni = $connection->query($upitRadniciDodijeljeni);
            
            ?>
            <div class="form-group">
                            <label for="radniciZadatakDodijeljeni" class="col-form-label">Radnici na zadatku:</label>
                            <?php                           
                            if($rezultatRadniciDodijeljeni->num_rows>0)
                            {  
                                while ($radniciDodijeljeni = mysqli_fetch_assoc($rezultatRadniciDodijeljeni))
                                {
                                ?>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="radnici[]" value="<?=$radniciDodijeljeni['ime']?> <?=$radniciDodijeljeni['prezime']?>" checked disabled>
                                    <label class="form-check-label"><?=$radniciDodijeljeni['ime']?> <?=$radniciDodijeljeni['prezime']?></label>
                                </div>
                                <?php
                                }
                            }  
                        ?>
            </div> 
            <?php
            $upitRadniciSlobodni="SELECT id,ime, prezime from korisnici left join tipizacija on korisnici.id=tipizacija.korisnici_id 
                                where tipizacija.rola='radnik' and korisnici.id NOT in 
                                (SELECT id FROM korisnici left JOIN korisnici_zadatak on korisnici.id=korisnici_zadatak.korisnici_id 
                                where korisnici_zadatak.zadatak_id=(SELECT id from zadatak where zadatak.naziv='".$nazivZadatka."' limit 1))";
            $rezultatRadniciSlobodni = $connection->query($upitRadniciSlobodni);
            ?>
            <div class="form-group">
                            <label for="radniciZadatakSlobodni" class="col-form-label">Dostupni radnici:</label>
                            <?php                            
                            if($rezultatRadniciSlobodni->num_rows>0)
                            {  
                                while ($radniciSlobodni = mysqli_fetch_assoc($rezultatRadniciSlobodni))
                                {
                                ?>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="radnici[]" value="<?=$radniciSlobodni['ime']?> <?=$radniciSlobodni['prezime']?>" disabled>
                                    <label class="form-check-label"><?=$radniciSlobodni['ime']?> <?=$radniciSlobodni['prezime']?></label>
                                </div>
                                <?php
                                }
                            }  
                        ?>
            </div> 
            <p ><i class="fa fa-info-circle" aria-hidden="true"></i> Jednom kada je zadatak dodijeljen nekom radniku, nemoguće je ukoliniti sve radnike sa zadatka</p>
            <div class="input-group-append" style="margin-right: 20%">
                <button data-toggle="tooltip" data-placement="right" title="Dodaj ili ukloni radnike" onclick="enabledDisabledCheckBoxes()" class="btn btn-secondary" type="button"><i class="fa fa-user-plus"></i> ili <i class="fa fa-user-times"></i></button>
            </div>

            <div class="dugme  ml-1"><button type="button" class="btn btn-secondary mt-4 mb-4" data-toggle="modal" data-target="#dodajKom"><i class="fa fa-commenting-o"></i> <i class="fa fa-plus "></i></button><div>
            <div class="dugme  ml-1"><button type="button" class="btn btn-secondary mt-4 mb-4" data-toggle="modal" data-target="#sviKomentari"><i class="fa fa-commenting-o"></i> Svi komentari</button><div>
            <div class="dugme  ml-1"><button type="button" class="btn btn-secondary mt-4 mb-4" data-toggle="modal" data-target="#evidencijaVremena"><i class="fa fa-clock-o"></i> Evidencija vremena</button><div>

            <a href="obrisiZadatak.php?zadatak=<?=$nazivZadatka?>" type="button" class="btn btn-danger btn-lg btn-block mb-2">Obriši zadatak <i class="fa fa-trash-o"></i></a>     
            <button id="sacuvajZadatak" type="submit" class="btn btn-success btn-lg btn-block mb-2">Sačuvaj izmjene <i class="fa fa-floppy-o"></i></button>
            
        </form>

    </div>    

    <?php
    $upitVrijemeKomentari="SELECT * FROM `evidencija_vremena`,`zadatak`,`korisnici` WHERE
            evidencija_vremena.zadatak_id=zadatak.id and 
            evidencija_vremena.korisnici_id=korisnici.id and 
            zadatak.naziv='".$nazivZadatka."'
            ORDER BY `evidencija_vremena`.`vrijeme_evidentiranja` DESC";        
    ?>

    <!-- Modal komentari-->
    <div class="modal fade" id="sviKomentari" tabindex="-1" role="dialog" aria-labelledby="sviKomentariTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="sviKomentariTitle">Komentari</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                <?php                    
                $rezultatVrijemeKomentari = $connection->query($upitVrijemeKomentari);
                if($rezultatVrijemeKomentari->num_rows>0)
                {
                while($vrijemeKomentari = mysqli_fetch_assoc($rezultatVrijemeKomentari))
                    { 
                ?>
                    <strong><?=$vrijemeKomentari['korsinicko_ime']?>, <?=$vrijemeKomentari['vrijeme_evidentiranja']?></strong>
                    <p><?=$vrijemeKomentari['komentar']?></p>
                    <?php
                    }     
                }
                ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Zatvori</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal svih evidencija vremena-->
    <div class="modal fade" id="evidencijaVremena" tabindex="-1" role="dialog" aria-labelledby="evidencijaVremenaTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="evidencijaVremenaTitle">Evidencija vremena</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php
                $ukupnoVrijemeUpit="SELECT SUM(DATEDIFF(evidencija_vremena.vrijeme_evidentiranja, evidencija_vremena.utroseno_vrijeme)) AS dani 
                                    FROM evidencija_vremena 
                                    WHERE evidencija_vremena.zadatak_id=(SELECT id FROM zadatak WHERE zadatak.naziv='".$nazivZadatka."' limit 1)";
                $rezultatUkpnoVrijeme = $connection->query($ukupnoVrijemeUpit);
            ?>
            <div class="modal-body">
                 <?php 
                 if($rezultatUkpnoVrijeme->num_rows>0)
                 {
                     $ukuonoVrijeme = mysqli_fetch_assoc($rezultatUkpnoVrijeme);
                     if($ukuonoVrijeme['dani']!=0)
                     {
                        ?>               
                        <p>Ukupno utrošeno vremena na zadatak: <strong><?=$ukuonoVrijeme['dani']?> dana</strong></p><hr/>
                        <?php
                     }else
                     {
                         ?>               
                        <p>Ukupno utrošeno vremena na zadatak: <strong>0 dana</strong></p><hr/>
                        <?php
                     }
                     
                 }
                           
            $rezultatVrijemeKomentari = $connection->query($upitVrijemeKomentari);
            if($rezultatVrijemeKomentari->num_rows>0)
            {
            while($vrijemeKomentari = mysqli_fetch_assoc($rezultatVrijemeKomentari))
                { 
            ?>
                <strong><?=$vrijemeKomentari['korsinicko_ime']?></strong>
                <p><strong>od</strong> <?=$vrijemeKomentari['utroseno_vrijeme']?> <strong>do</strong> <?=$vrijemeKomentari['vrijeme_evidentiranja']?></p>
                <?php
                }     
            }
            ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Zatvori</button>
            </div>
            </div>
        </div>
    </div> 

    <!-- Modal za dodavanje komentara i evidenciju vremena-->
    <div class="modal fade" id="dodajKom" tabindex="-1" role="dialog" aria-labelledby="dodajKomTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="dodajKomTitle">Evidentiraj vrijeme</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="insertKomentar.php" method="post">
                    <div class="form-group">
                        <label for="datumPocetka" class="col-form-label">Datum početka izvršenja (dijela) zadatka:</label>
                        <input type="date" class="form-control" id="datumPocetka" name="datumPocetka" required>
                    </div>
                    <div class="form-group">
                        <label for="komentar" class="col-form-label">Komentar:</label>
                        <textarea class="form-control" id="komentar" name="komentar" required></textarea>
                    </div>
                    
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Zatvori</button>
                    <button type="submit" class="btn btn-primary">Dodaj</button>
                </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js" integrity="sha384-Atwg2Pkwv9vp0ygtn1JAojH0nYbwNJLPhwyoVbhoPwBhjQPR5VtM2+xf0Uwh9KtT" crossorigin="anonymous"></script>
    
    <script>
        //Funkcija za koja mijenja status input polja sa disabled na enabled ukoliko mijenjamo podatke o zadatku. 
        //NECE DA SE POKRENE IZ script.js PA JE UKLJUCENA OVAKO
        function enabledDisabled(documentID)
        {
            document.getElementById(documentID).disabled = false;
        }

        function enabledDisabledCheckBoxes()
        {
            for (x = 0; x < document.getElementsByTagName('input').length; x++) 
            {
                if (document.getElementsByTagName('input').item(x).type == 'checkbox') 
                {
                    document.getElementsByTagName('input').item(x).disabled = false;
                }
            }
        }

        //Funkcija koja mijenja boju pozadine select liste u zavisnosti od izabranog
        window.onload=selectColor; //postavlja boju pozadine pri prvom pokretanju stranice
        function selectColor()
        {
            var selectList=document.getElementById("statusZadatka");
            if(selectList.value=="novo")
                selectList.style.backgroundColor="#66FF66";
            else if(selectList.value=="u izradi")
                selectList.style.backgroundColor="#FFFF66";
            else
                selectList.style.backgroundColor="#FF3333";
        }

        function enableCheckBox()
        {
            var elementi=document.getElementsByClassName("form-check-input");
            var i;
            for(i=0;i<elementi.lenght;i++)
            {
                elementi[i].disabled=false;
                console.log(elementi);
            }
        }
    </script>
</body>
</html>