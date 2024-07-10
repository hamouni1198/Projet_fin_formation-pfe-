<?php
session_start(); // Démarrer la session

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Inclure le fichier de connexion à la base de données
include('connect.php'); 
$con = connect(); // Fonction de connexion à la base de données

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_SESSION['id_client'])) {
        echo "Client non connecté!";
        exit();
    }

    // Récupérer l'ID client depuis la session
    $id_client = $_SESSION['id_client'];

    // Valider et filtrer les données du formulaire
    $productId = filter_input(INPUT_POST, 'productId', FILTER_VALIDATE_INT);
    $quantity = filter_input(INPUT_POST, 'quantity', FILTER_VALIDATE_INT);

    // Vérifier si les données sont valides
    if ($productId === false || $quantity === false) {
        echo "Données invalides!";
        exit();
    }

    // Vérifier s'il existe déjà un panier actif pour ce client
    $queryCheckPanier = "SELECT id_panier FROM panier WHERE id_client = ? ";
    $stmtCheckPanier = $con->prepare($queryCheckPanier);
    if ($stmtCheckPanier) {
        $stmtCheckPanier->bind_param("i", $id_client);
        $stmtCheckPanier->execute();
        $resultCheckPanier = $stmtCheckPanier->get_result();

        if ($resultCheckPanier->num_rows > 0) {
            // Récupérer l'ID du panier actif
            $row = $resultCheckPanier->fetch_assoc();
            $id_panier = $row['id_panier'];
        } else {
            // Insertion d'un nouveau panier pour ce client s'il n'existe pas encore
            $queryInsertPanier = "INSERT INTO panier (id_client) VALUES (?)";
            $stmtInsertPanier = $con->prepare($queryInsertPanier);
            if ($stmtInsertPanier) {
                $stmtInsertPanier->bind_param("i", $id_client);
                if ($stmtInsertPanier->execute()) {
                    $id_panier = $con->insert_id;
                } else {
                    echo "Erreur lors de la création du panier!";
                    exit();
                }
                $stmtInsertPanier->close();
            } else {
                echo "Erreur lors de la préparation de la requête pour l'insertion du panier!";
                exit();
            }
        }
        $stmtCheckPanier->close();

        // Insertion du produit dans la table detail
        $queryDetail = "INSERT INTO detail (id_panier, id_produit, quantite) VALUES (?, ?, ?)";
        $stmtDetail = $con->prepare($queryDetail);
        if ($stmtDetail) {
            $stmtDetail->bind_param("iii", $id_panier, $productId, $quantity);
            if ($stmtDetail->execute()) {
                echo "Produit ajouté au panier!";
            } else {
                echo "Erreur lors de l'ajout du produit dans le détail du panier!";
            }
            $stmtDetail->close();
        } else {
            echo "Erreur lors de la préparation de la requête pour l'insertion du détail!";
            exit();
        }
    } else {
        echo "Erreur lors de la préparation de la requête pour vérifier le panier!";
        exit();
    }

    // Fermer la connexion à la base de données
    $con->close();
}
?>
