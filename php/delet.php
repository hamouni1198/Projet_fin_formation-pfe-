<?php
include('connect.php');
$con = connect();

if(isset($_POST['categoryId']) ) {
    // Sanitize input (optional if using prepared statements)
    $categoryId = mysqli_real_escape_string($con, $_POST['categoryId']);


    // Begin transaction
    mysqli_begin_transaction($con);

    // Récupère les anciennes images pour les supprimer
    $query = "SELECT img FROM produit WHERE produit.id_categorie = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("i", $categoryId);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $oldImages = explode(',', $row['img']);
    $stmt->close();

    // Supprime les anciennes images du dossier
    foreach ($oldImages as $oldImage) {
        $oldImagePath = '../images/' . $oldImage;
        if (file_exists($oldImagePath)) {
            unlink($oldImagePath);
        }
    }

    // Delete from produit
    $deleteProduitQuery = "DELETE FROM produit WHERE id_categorie = '$categoryId'";
    if (!mysqli_query($con, $deleteProduitQuery)) {
        http_response_code(500); // Server error
        echo "Erreur lors de la suppression de produit: " . mysqli_error($con);
        mysqli_rollback($con);
        exit; // Stop further execution
    }

    // Delete from categorie
    $deleteCategorieQuery = "DELETE FROM categorie WHERE id_categorie = '$categoryId'";
    if (!mysqli_query($con, $deleteCategorieQuery)) {
        http_response_code(500); // Server error
        echo "Erreur lors de la suppression de la catégorie: " . mysqli_error($con);
        mysqli_rollback($con);
        exit; // Stop further execution
    }

    // Commit transaction
    mysqli_commit($con);

   

    echo "supprime avec succes";
} else {
    http_response_code(400); // Bad request
    echo "categoryId is required";
}

mysqli_close($con);
?>
