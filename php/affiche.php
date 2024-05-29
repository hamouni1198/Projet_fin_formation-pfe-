<?php
include('connect.php');
$con = connect();
$search = "SELECT * FROM produit,categorie WHERE categorie.id_categorie = produit.id_categorie ";


$search .= "ORDER BY id_produit desc";
$search_run = $con->query($search);

$data = array();

while ($row = mysqli_fetch_assoc($search_run)) {
    $data[] = $row;
}

echo json_encode($data);
?>
