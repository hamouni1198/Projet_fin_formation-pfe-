<?php
include('connect.php'); // Inclusion du fichier de connexion à la base de données
$con = connect(); // Établissement de la connexion à la base de données

// Vérification de la méthode de requête POST et de la présence de id_produit et id_categorie
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_produit'], $_POST['id_categorie'])) {
    $produitId = $_POST['id_produit'];
    $categorieId = $_POST['id_categorie'];

    // Requête SQL pour récupérer les détails du produit basés sur id_produit et id_categorie
    $search = "SELECT * FROM produit_post WHERE id_produit = ? AND id_categorie = ?";
    $stmt = $con->prepare($search);

    if ($stmt === false) {
        echo json_encode(['error' => 'Échec de la préparation de la requête SQL : ' . $con->error]);
        exit;
    }

    $stmt->bind_param("ii", $produitId, $categorieId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result === false) {
        echo json_encode(['error' => 'Échec de l\'exécution de la requête SQL : ' . $stmt->error]);
        exit;
    }

    if ($result->num_rows > 0) {
        $productData = $result->fetch_assoc(); // Récupère une seule ligne de résultat

        // Ajoutez l'URL de l'image si elle est stockée dans une colonne de la base de données
        // Supposons que les URLs d'images sont stockées sous forme de chaîne séparée par des virgules
        if (!empty($productData['img'])) {
            $productData['img_urls'] = explode(',', $productData['img']);
        }

        echo json_encode($productData); // Retourne les détails du produit au format JSON
    } else {
        echo json_encode(['error' => 'Aucune donnée trouvée pour les IDs spécifiés']);
    }
} else {
    echo json_encode(['error' => 'Requête invalide']);
}
?>
