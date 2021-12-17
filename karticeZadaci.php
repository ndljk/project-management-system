<?php
    include "konekcija.php";

    if(!isset($_SESSION['loggedUser']))
        header("Location: prijava.php");

    $nazivProjekta = $_GET['nazivProjekta'];
    $_SESSION['nazivProjekta']=$nazivProjekta;
    $sql = "SELECT * FROM `projekat` WHERE `naziv`='".$nazivProjekta."'";
    $result = $connection->query($sql);
    if($result->num_rows > 0)
    {
        $projekat = mysqli_fetch_assoc($result);
        $opis = $projekat['opis'];
        $datum = $projekat['datum'];
        $id = $projekat['id'];
    }
?>

<!-- Div u koji su smješteni projekt menadžeri kao i naziv projekta. Predstavlja header -->
<div class="headerKartice">
  <div class="title justify-content-center ml-4"><h1><?= $_GET['nazivProjekta']?></h1></div>
  <hr>
  <p class="ml-4"><strong>Opis:</strong> <?=$opis?></p>
  <p class="ml-4"><strong>Datum kreiranja:</strong> <?=$datum?></p>
  <div class="mb-2 ml-4 d-flex">
    <strong>Projekt menadžer/menadžeri:</strong> <ul>
    <?php 
        $sql2 = "SELECT `ime`,`prezime` FROM `korisnici` JOIN `korisnici_projekat`ON korisnici_projekat.korisnici_id = korisnici.id WHERE korisnici_projekat.projekat_id = '".$id."'";
        $result2 = $connection->query($sql2);
        if($result2->num_rows > 0)
        {
            while ($row = mysqli_fetch_assoc($result2))
            { 
            ?>

                <li><?=$row['ime']?> <?=$row['prezime']?></li>
            <?php
             }
        } ?>
    </ul>
    </div>
    <div>
    <?php
        if($_SESSION['loggedUser']['rola']=="administrator") 
        {
            ?>
            <button class="btn btn-danger ml-4" onclick="deleteProject()">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
            </svg>
            </button>
            <button class="btn btn-secondary ml-4" onclick="updateProject()">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
            </svg>
            </button>   
            <a class="btn btn-secondary ml-4" href="#" role="button" data-toggle="modal" data-target="#statistika"><i class="fa fa-line-chart "></i> Prikaži statistiku</a>         
            <a class="btn btn-secondary ml-4" href="#" role="button" data-toggle="modal" data-target="#kreirajZadatak"><i class="fa fa-plus "></i> Kreiraj novi zadatak</a>
            <?php
        } 
    ?>
    
    </div>
</div>
<hr>

<?php
$upit="SELECT ime,prezime FROM `korisnici` left join tipizacija on korisnici.id=tipizacija.korisnici_id where tipizacija.rola='radnik'";
$rezultat = $connection->query($upit);
?>
<!-- Modal za kreiranje novog zadatka -->
<div class="modal fade" id="kreirajZadatak" tabindex="-1" role="dialog" aria-labelledby="kreirajZadatakTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="kreirajZadatakTitle">Kreiraj novi zadatak</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="kreirajZadatak.php" method="post">
                        <div class="form-group">
                            <label for="nazivZadatka" class="col-form-label">Naziv zadatka:</label>
                            <input type="text" class="form-control" id="nazivZadatka" name="nazivZadatka" required>
                        </div>
                        <div class="form-group">
                            <label for="opisZadatka" class="col-form-label">Opis zadatka:</label>
                            <textarea class="form-control" id="opisZadatka" name="opisZadatka" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="krajnjiDatum" class="col-form-label">Krajnji datum izvršenja:</label>
                            <input type="date" class="form-control" id="krajnjiDatum" name="krajnjiDatum" required>
                        </div>
                        <div class="form-group">
                            <label for="radniciNaZadatku" class="col-form-label">Radnici:</label>
                            <?php                            
                            if($rezultat->num_rows>0)
                            {  
                                $indeks=0;
                                while ($radnici = mysqli_fetch_assoc($rezultat))
                                {
                                ?>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="<?=$indeks?>" id="<?=($indeks)?>" value="<?=$radnici['ime']?> <?=$radnici['prezime']?>">
                                    <label class="form-check-label"><?=$radnici['ime']?> <?=$radnici['prezime']?></label>
                                </div>
                                <?php
                                $indeks++;
                                }
                                $_SESSION['indeks']=$indeks;
                            }
                        ?>
                        </div>       
                        <p ><i class="fa fa-info-circle" aria-hidden="true"></i> Zadatak je moguće kreirati tako da nema dodijeljenog radnika</p>                 
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Zatvori</button>
                            <button type="submit" class="btn btn-primary" id="kreirajZadatak" >Kreiraj zadatak</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

<!-- Div u kojem su smješteni check boxovi koji služe za filtriranje zadataka -->
<form class="form-inline" style="margin: 30px;">
  <label class="mr-sm-2"><strong>Prikaži zadatke:</strong></label>
  <div class="form-check-inline" style="margin-left: 30px;">
    <label class="form-check-label">
    <input type="checkbox" class="form-check-input" value="" checked>Novo
  </label>
</div>
<div class="form-check-inline">
  <label class="form-check-label">
    <input type="checkbox" class="form-check-input" value="" checked>U izradi
  </label>
</div>
<div class="form-check-inline">
  <label class="form-check-label">
    <input type="checkbox" class="form-check-input" value="" checked>Završeno
  </label>
</div>
</form>



<!-- Div u koji su smješteni zadaci koji su na tom projektu u vidu kartica -->
<div class="card-columns" id="cards" style="margin: 30px;">
<?php
    $sql2 = "SELECT * FROM `zadatak` WHERE `projekat_id` = '".$id."'";
    
    $result2 = $connection->query($sql2);
    if($result-> num_rows > 0)
    {
        while($zadatak = mysqli_fetch_assoc($result2))
        {
            if($zadatak['status'] == "u izradi")
                $imgSrc="u_izradi.png";
            else if($zadatak['status'] == "novo")
                $imgSrc="novo.png";
            else
                $imgSrc="zavrseno.png";
            
            ?>
            <div class="card" style="width:400px">
            <img class="card-img-top images" src="<?=$imgSrc?>" alt="Card image">
                <div class="card-body">
                    <h4 class="card-title"><?=$zadatak['naziv']?></h4>
                    <p class="card-text">OPIS: <?=$zadatak['opis']?></p>
                    <a href="zadaciDetalji.php?nazivZadatka=<?=$zadatak['naziv']?>" class="btn btn-primary" >Prikaži detalje</a>
                </div>
            </div>
            <?php
            
        }
    }
?>
</div>

<!-- Modal za izvoz statistike-->
    <div class="modal fade" id="statistika" tabindex="-1" role="dialog" aria-labelledby="statistikaTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="statistikaTitle">Statistika projekta</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <?php
                        include "exportTableStat.php";
                    ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Zatvori</button>
                    <div class="dropdown">
                        <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-download" aria-hidden="true"></i> Sačuvaj
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="#" onClick ="$('#statistikaProjekta').tableExport({type:'pdf',escape:'false'});"><i class="fa fa-file-pdf-o "></i> .pdf</a>
                            <a class="dropdown-item" href="#" onClick ="$('#statistikaProjekta').tableExport({type:'csv',escape:'false'});"><i class="fa fa-file-excel-o "></i> .csv</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-Atwg2Pkwv9vp0ygtn1JAojH0nYbwNJLPhwyoVbhoPwBhjQPR5VtM2+xf0Uwh9KtT" crossorigin="anonymous"></script>

<script type="text/javascript">
        var naziv = "<?=$nazivProjekta?>";
        function deleteProject()
        {
            window.location="deleteProject.php?projekat="+naziv;
        }
        function updateProject()
        {
            window.location="updateProject.php?projekat="+naziv;
        }

</script>
