<?php
include('connect.php');
$con = connect();




// Récupérer les données POST
$idProduitVue = isset($_POST['id_produit_vue']) ? intval($_POST['id_produit_vue']) : 0;
$idCategorieVue = isset($_POST['id_categorie_vue']) ? intval($_POST['id_categorie_vue']) : 0;
$etat = isset($_POST['etat']) ? intval($_POST['etat']) : 0;

// Vérifier que les données nécessaires sont présentes
if ($idProduitVue > 0 && $idCategorieVue > 0) {
    // Mettre à jour la colonne etat de la table produit
    $sql = "UPDATE produit SET etat = ? WHERE id_produit = ? AND id_categorie = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("iii", $etat, $idProduitVue, $idCategorieVue);

    if ($stmt->execute()) {
        $response = ['success' => true, 'message' => 'Produit mis à jour avec succès'];
    } else {
        $response = ['error' => 'Erreur lors de la mise à jour du produit : ' . $stmt->error];
    }

    $stmt->close();
} else {
    $response = ['error' => 'Données manquantes'];
}

$con->close();

// Retourner la réponse en JSON
echo json_encode($response);
?>
