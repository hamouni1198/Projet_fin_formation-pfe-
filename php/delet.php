<?php
include('connect.php');
$con = connect();

if(isset($_POST['categoryId'])) {
    $categorieID = $_POST['categoryId'];

    $categorieID = $con->real_escape_string($categorieID);
    
    $deleteQuery = "DELETE FROM categorie WHERE id_categorie = '$categorieID'";
    $deleteResult = $con->query($deleteQuery);

    if ($deleteResult) {
        echo "supprime avec succes"; 
    } else {
        echo "Erreur lors de la suppression de la catégorie: " . $con->error;
    }
}

$con->close();
?>
