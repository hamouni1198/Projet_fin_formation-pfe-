<?php
include('connect.php');
$con = connect();

// Utilisation d'une requête préparée pour la sécurité
$postProduit = "
    SELECT produit.*, categorie.* 
    FROM produit 
    JOIN categorie ON categorie.id_categorie = produit.id_categorie
    WHERE produit.etat = 1
";
$stmt = $con->prepare($postProduit);
$stmt->execute();
$result = $stmt->get_result();

$data = array();
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

// Envoi de la réponse JSON
header('Content-Type: application/json');
echo json_encode(array('produits' => $data));
?>
