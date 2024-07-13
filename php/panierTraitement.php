<?php
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

include('connect.php');
$con = connect();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_SESSION['id_client'])) {
        echo "Client non connecté!";
        exit();
    }

    $id_client = $_SESSION['id_client'];

    $productId = filter_input(INPUT_POST, 'productId', FILTER_VALIDATE_INT);
    $quantity = filter_input(INPUT_POST, 'quantity', FILTER_VALIDATE_INT);

    if ($productId === false || $quantity === false) {
        echo "Données invalides!";
        exit();
    }

    // Vérifier s'il existe déjà un panier actif pour ce client
    $queryCheckPanier = "SELECT id_panier FROM panier WHERE id_client = ?";
    $stmtCheckPanier = $con->prepare($queryCheckPanier);
    if ($stmtCheckPanier) {
        $stmtCheckPanier->bind_param("i", $id_client);
        $stmtCheckPanier->execute();
        $resultCheckPanier = $stmtCheckPanier->get_result();

        if ($resultCheckPanier->num_rows > 0) {
            $row = $resultCheckPanier->fetch_assoc();
            $id_panier = $row['id_panier'];
        } else {
            // Créer un nouveau panier pour ce client s'il n'existe pas encore
            $queryInsertPanier = "INSERT INTO panier (id_client) VALUES (?)";
            $stmtInsertPanier = $con->prepare($queryInsertPanier);
            if ($stmtInsertPanier) {
                $stmtInsertPanier->bind_param("i", $id_client);
                if ($stmtInsertPanier->execute()) {
                    $id_panier = $con->insert_id;
                } else {
                    echo "Erreur lors de la création du panier: " . $stmtInsertPanier->error;
                    exit();
                }
                $stmtInsertPanier->close();
            } else {
                echo "Erreur lors de la préparation de la requête pour l'insertion du panier: " . $con->error;
                exit();
            }
        }
        $stmtCheckPanier->close();

        // Insérer le détail du produit dans la table detail
        $queryDetail = "INSERT INTO detail (id_panier, id_produit, quantite) VALUES (?, ?, ?)";
        $stmtDetail = $con->prepare($queryDetail);
        if ($stmtDetail) {
            $stmtDetail->bind_param("iii", $id_panier, $productId, $quantity);
            if ($stmtDetail->execute()) {
                echo "Produit ajouté au panier!";
            } else {
                echo "Erreur lors de l'ajout du produit dans le détail du panier: " . $stmtDetail->error;
            }
            $stmtDetail->close();
        } else {
            echo "Erreur lors de la préparation de la requête pour l'insertion du détail: " . $con->error;
            exit();
        }
    } else {
        echo "Erreur lors de la préparation de la requête pour vérifier le panier: " . $con->error;
        exit();
    }

    $con->close();
}
?>
