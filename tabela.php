<?php
include 'konekcija.php';

$result = $connection->query('SELECT * FROM `korisnici`, `tipizacija` where korisnici.id=tipizacija.korisnici_id;');

?>
    <div class="mt-4 container">         
    <table class="table table-dark">
        <thead>
        <tr>
            <th>Ime</th>
            <th>Prezime</th>
            <th>Email</th>
            <th>Pozicija</th>
        </tr>
        </thead>
        <tbody id="tabela">
<?php

if($result->num_rows>0)
{
    while ($row = mysqli_fetch_assoc($result))
    {
        ?>
        
        <tr>
           <td><?= $row['ime'] ?></td>
            <td><?= $row['prezime'] ?></td>
            <td><?= $row['email'] ?></td>
            <td><?= $row['rola'] ?></td>
        </tr>
        <?php
    }
}
?>
    </tbody>
    </table>
</div>
