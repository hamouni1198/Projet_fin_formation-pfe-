<?php
include('connect.php');
$con = connect();

if(isset($_POST['produitId'])) {
    $produitId = $_POST['produitId'];
    
    $deleteQuery = "UPDATE produit SET etat = 0 WHERE id_produit= $produitId";
    $deleteResult = $con->query($deleteQuery);

    if ($deleteResult) {
        echo "supprime avec succes";
    } else {
        http_response_code(500); // Set HTTP response status code to 500 for server error
        echo "Erreur lors de la suppression de la catégorie: " . $con->error;
    }
} else {
    http_response_code(400); // Set HTTP response status code to 400 for bad request
    echo "produitId is required";
}

$con->close();
?>
