<?php
session_start(); // Démarrer la session

error_reporting(E_ALL);
ini_set('display_errors', 1);

include('connect.php'); 
$con = connect(); // Connexion à la base de données

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_SESSION['id_client'])) {
        echo "Client non connecté!";
        exit();
    }

    $id_client = $_SESSION['id_client'];
    $productId = filter_var($_POST['productId'], FILTER_VALIDATE_INT);
    $quantity = filter_var($_POST['quantity'], FILTER_VALIDATE_INT);

    if ($productId === false || $quantity === false) {
        echo "Données invalides!";
        exit();
    }

    // Insertion dans la table panier
    $queryPanier = "INSERT INTO panier (id_client) VALUES (?)";
    $stmtPanier = $con->prepare($queryPanier);
    $stmtPanier->bind_param("i", $id_client);
    if ($stmtPanier->execute()) {
        // Récupérer l'ID du panier inséré
        $id_panier = $con->insert_id;
        
        // Insertion dans la table detail
        $queryDetail = "INSERT INTO detail (id_panier, id_produit, quantite) VALUES (?, ?, ?)";
        $stmtDetail = $con->prepare($queryDetail);
        $stmtDetail->bind_param("iii", $id_panier, $productId, $quantity);
        
        if ($stmtDetail->execute()) {
            echo "Produit ajouté au panier!";
        } else {
            echo "Erreur lors de l'ajout du produit dans le détail du panier!";
        }
        $stmtDetail->close();
    } else {
        echo "Erreur lors de l'ajout du produit au panier!";
    }

    $stmtPanier->close();
    $con->close();
}
?>
