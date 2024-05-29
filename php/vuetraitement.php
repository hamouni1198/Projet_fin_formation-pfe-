<?php
include('connect.php');
$con = connect();

if(isset($_POST['click_edite'], $_POST['id_produit'], $_POST['id_categorie'])) {
    $produitId = $_POST['id_produit'];
    $categorieId = $_POST['id_categorie'];
    
    $search = "SELECT * FROM produit, categorie WHERE produit.id_produit = ? AND categorie.id_categorie = ?";
    $stmt = $con->prepare($search);
    $stmt->bind_param("ii", $produitId, $categorieId);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows > 0) {
        $arrayresultat = $result->fetch_all(MYSQLI_ASSOC);
        // Output the result as JSON
        echo json_encode($arrayresultat);
    } else {
        echo 'error';
    }
} else {
    echo 'Invalid request';
}
?>
