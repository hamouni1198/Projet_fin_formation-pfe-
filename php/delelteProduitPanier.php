<?php
include('connect.php');
$con = connect();

if (isset($_POST['id_panier']) && isset($_POST['id_produit'])) {
    $id_panier = $_POST['id_panier'];
    $id_produit = $_POST['id_produit'];

    $requete = "DELETE FROM detail WHERE id_panier = ? AND id_produit = ?";
    $stmt = $con->prepare($requete);
    $stmt->bind_param('ii', $id_panier, $id_produit);

    if ($stmt->execute()) {
        echo "Produit supprimé avec succès.";
    } else {
        echo "Erreur lors de la suppression du produit.";
    }

    $stmt->close();
} else {
    echo "id_panier ou id_client manquant.";
}

$con->close();
?>
