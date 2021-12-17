<?php
    include "konekcija.php"; 
    header('Content-Type: text/csv; charset=utf-8');  
    header('Content-Disposition: attachment; filename=data.csv');  
    $output = fopen("php://output", "w");  
    fputcsv($output, array('ID', 'Ime', 'Prezime'));  
    $query = "SELECT id,ime,prezime from korisnici ORDER BY id DESC";  
    $result = mysqli_query($connection, $query);  
    while($row = mysqli_fetch_assoc($result))  
    {  
        fputcsv($output, $row);  
    }  
    fclose($output);  
?>