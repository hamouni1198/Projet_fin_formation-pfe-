<?php
include('connect.php');
$con = connect();

if(isset($_POST['click_edite'])) {
    $produitId = $_POST['id_produit'];
    $categorieId = $_POST['id_categorie'];
    $arrayresultat = [];

    $search = "SELECT * FROM produit, categorie WHERE categorie.id_categorie = ? AND produit.id_produit = ?";
    $stmt = $con->prepare($search);
    $stmt->bind_param("ii", $categorieId, $produitId);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            array_push($arrayresultat, $row);
        }
        header('Content-Type: application/json');
        echo json_encode($arrayresultat);
    } else {
        echo "Error: No results found";
    }
}



?>
