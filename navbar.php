<?php
    include "konekcija.php";

    $upit="SELECT DISTINCT * FROM projekat";
    $rezultat = $connection->query($upit);
?>

<div class="container-fluid navbar-padding">
    <nav class="navbar navbar-expand-md bg-dark navbar-dark">
        <!-- Dropdown projekata-->
        <div class="dropdown">
            <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown">
                <i class="fas fa-align-left"></i>
            </button>
            <div class="dropdown-menu">
                <?php
                if($rezultat->num_rows>0)
                {
                    while ($projekti = mysqli_fetch_assoc($rezultat))
                    {
                        ?>
                        <a class="dropdown-item" href="index.php?nazivProjekta=<?= $projekti['naziv'] ?>"><?= $projekti['naziv'] ?></a>
                        <?php
                    }
                }

                if($_SESSION['loggedUser']['rola']=="administrator") 
                {
                    ?>
                    <a class="dropdown-item" href="kreirajProjekat.php"><i class="fas fa-plus-circle "></i> Dodaj projekat</a>  
                    <?php
                } ?>
            </div>
        </div>

        <a class="navbar-brand" href="index.php?nazivProjekta=" style="margin-left: 15px"><?=$_SESSION['loggedUser']['korsinicko_ime']?> (<?=$_SESSION['loggedUser']['rola']?>)</a>

        <!-- Navbar linkovi -->
        <div class="collapse navbar-collapse" id="collapsibleNavbar">
            <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="izmjenaProfila.php">Izmjena profila</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="pregled.php">Zaposleni</a>
            </li>
            </ul>
        </div>

        <!--Odjavi se-->
        <button class="btn btn-secondary" onClick="document.location.href='odjava.php'" ><i class="fas fa-sign-out-alt"></i> Odjavi se</button>
    </nav>
</div>