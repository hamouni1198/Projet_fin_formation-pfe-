<?php
include('connect.php');
$con = connect();
$search = "SELECT * FROM produit,categorie WHERE categorie.id_categorie = produit.id_categorie ";

$type = $_POST['type'];
$sexe = $_POST['sexe'];
$date = $_POST['date'];

if (!empty($date) && !empty($type) && !empty($sexe)) {
    $search .= " AND date_creation = '$date' AND typ_cat='$type' AND sexe='$sexe' ";
} elseif (!empty($date) && !empty($sexe)) {
    $search .= " AND date_creation = '$date' AND sexe='$sexe' ";
} elseif (!empty($type) && !empty($sexe)) {
    $search .= " AND typ_cat='$type' AND sexe='$sexe' ";
} elseif (!empty($date)) {
    $search .= " AND date_creation = '$date' ";
} elseif (!empty($type)) {  
    $search .= " AND typ_cat='$type' ";
} elseif (!empty($sexe)) {
    $search .= " AND sexe='$sexe'";
}
$search .= "ORDER BY id_produit desc";
$search_run = $con->query($search);

// Tableau pour stocker les données
$data = array();

// Récupérer les données de la requête
while ($row = mysqli_fetch_assoc($search_run)) {
    $data[] = $row;
}

// Afficher les données au format JSON
echo json_encode($data);
?>
