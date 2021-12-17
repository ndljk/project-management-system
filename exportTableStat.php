<?php
    include "konekcija.php";
    $sumaDana=0;
?>
<table class="table" id="statistikaProjekta">
<thead class="thead-dark">
    <tr>
    <th scope="col" colspan=3><?=$_SESSION['nazivProjekta']?></th>
    </tr>
</thead>
<tbody>
    <tr>
        <th scope="col">Zadatak</th>        
        <th scope="col">Predviđeno vrijeme kraja</th>
        <th scope="col">Ukupno evidentirano vrijeme zadatka (u danima)</th>
    </tr>
    <?php
        $upit1="SELECT id,naziv,CAST(vrijeme AS DATE) AS krajnji_rok FROM `zadatak` WHERE zadatak.projekat_id=
                (select id FROM projekat WHERE projekat.naziv='".$_SESSION['nazivProjekta']."' limit 1)";
        $rezultat1=$connection->query($upit1);
        if($rezultat1->num_rows>0)
        {
            while ($red1 = mysqli_fetch_assoc($rezultat1))
            {
                ?>                 
                <tr>
                    <td><?=$red1['naziv']?></td>
                    <td><?=$red1['krajnji_rok']?></td>
                    <?php
                        $upit2="SELECT SUM(DATEDIFF(evidencija_vremena.vrijeme_evidentiranja, evidencija_vremena.utroseno_vrijeme)) AS evidentirano 
                                FROM evidencija_vremena 
                                WHERE evidencija_vremena.zadatak_id=".$red1['id'];
                        $rezultat2=$connection->query($upit2);
                        if($rezultat2->num_rows>0)  
                        {
                            $red2=mysqli_fetch_assoc($rezultat2);
                            ?>
                                <td><?=$red2['evidentirano']?></td>
                            <?php
                            $sumaDana+=intval($red2['evidentirano']);                    
                        }
                    ?>
                </tr>
                <?php
            }
        }
    ?>
</tbody>
<thead class="thead-dark">
    <tr>
        <th scope="col" colspan=4>Ukupno evidentirano vrijeme projekta: <?=$sumaDana?> dana</th>
    </tr>
</thead>
<tbody>
    <tr class="table-secondary">
        <th scope="col" >Ime:</th>
        <th scope="col">Prezime:</th>
        <th scope="col">Pozicija:</th>
    </tr>
<?php
    $upit="SELECT ime, prezime, rola from korisnici, tipizacija where tipizacija.korisnici_id=korisnici.id and korisnici.id IN
            (select korisnici_projekat.korisnici_id from korisnici_projekat where 
            korisnici_projekat.projekat_id=(SELECT id FROM projekat WHERE projekat.naziv='".$_SESSION['nazivProjekta']."'))";
    $rezultat=$connection->query($upit);
    if($rezultat->num_rows>0)
    {
        while ($red = mysqli_fetch_assoc($rezultat))
        {
            ?>                 
            <tr>
                <td><?=$red['ime']?></td>
                <td><?=$red['prezime']?></td>
                <td><?=$red['rola']?></td>
            </tr>
            <?php
        }
    }
?>
</tbody>
</table>

