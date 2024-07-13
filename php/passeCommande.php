<?php
include('connect.php'); 
$con = connect();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données envoyées par l'Ajax
    $id_panier = $_POST['id_panier'];
    $id_client = $_POST['id_client'];
    $total = $_POST['total'];

    // Préparer et exécuter la requête d'insertion
    $requete = "INSERT INTO commande (id_client, id_panier, total) VALUES (?, ?, ?)";
    $reponse = $con->prepare($requete);
    $success = $reponse->execute([$id_client, $id_panier, $total]);

    if ($success) {
        // Supprimer l'entrée de la table panier
        $requete_suppression = "DELETE FROM panier WHERE id_panier = ?";
        $reponse_suppression = $con->prepare($requete_suppression);
        $reponse_suppression->execute([$id_panier]);

        if ($reponse_suppression->rowCount() > 0) {
            echo "Commande passée avec succès et panier supprimé";
        } else {
            echo "Commande passée avec succès, mais échec de la suppression du panier";
        }
    } else {
        echo "Erreur lors de la passation de la commande";
    }
}
?>
