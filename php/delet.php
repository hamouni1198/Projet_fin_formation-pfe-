<?php
include('connect.php');
$con = connect();

if(isset($_POST['categoryId'])) {
    // Sanitize input (optional if using prepared statements)
    $categoryId = mysqli_real_escape_string($con, $_POST['categoryId']);

    // Begin transaction
    mysqli_begin_transaction($con);

    // Delete from produit_post
    $deleteProduitPostQuery = "DELETE FROM produit_post WHERE id_categorie = '$categoryId'";
    if (!mysqli_query($con, $deleteProduitPostQuery)) {
        http_response_code(500); // Server error
        echo "Erreur lors de la suppression de produit_post: " . mysqli_error($con);
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
