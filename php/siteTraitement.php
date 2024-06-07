<?php
include('connect.php');
$con = connect();

$idProduitVue = $_POST['id_produit_vue']; // Récupérer la valeur de id_produit_vue envoyée via AJAX
$idCategorieVue = $_POST['id_categorie_vue']; // Récupérer la valeur de id_categorie_vue envoyée via AJAX

// Vérifier si le produit existe déjà
$search_existing = "SELECT id_produit FROM produit_post WHERE id_produit = ?";
$stmt_existing = $con->prepare($search_existing);
$stmt_existing->bind_param("i", $idProduitVue);
$stmt_existing->execute();
$result_existing = $stmt_existing->get_result();

// Si le produit existe déjà, renvoyer un message
if ($result_existing->num_rows > 0) {
    $data['error'] = "Le produit avec l'identifiant $idProduitVue existe déjà.";
} else {
    // Le produit n'existe pas encore, continuer avec la récupération des données et l'insertion
    
    // Préparer la requête SQL avec des paramètres pour récupérer les données
    $search = "SELECT * FROM produit, categorie WHERE categorie.id_categorie = produit.id_categorie AND produit.id_produit = ? AND categorie.id_categorie = ?";
    $stmt = $con->prepare($search);
    $stmt->bind_param("ii", $idProduitVue, $idCategorieVue);
    $stmt->execute();
    $search_run = $stmt->get_result(); // Obtenir le résultat de la requête

    $data = array();

    while ($row = mysqli_fetch_assoc($search_run)) {
        $data[] = $row;
    }

    // Insérer les données récupérées dans une autre table de la base de données
    if (!empty($data)) {
        // Préparer la requête d'insertion
        $insert = "INSERT INTO produit_post (id_produit, id_categorie, stock, nam, prix, age, img, description, date_creation, typ_cat, sexe) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt_insert = $con->prepare($insert);

        foreach ($data as $row) {
            // Liaison des valeurs et exécution de la requête d'insertion
            $stmt_insert->bind_param("iisssssssss", $row['id_produit'], $row['id_categorie'], $row['stock'], $row['nam'], $row['prix'], $row['age'], $row['img'], $row['description'], $row['date_creation'], $row['typ_cat'], $row['sexe']);
            $stmt_insert->execute();
        }
    }
}

echo json_encode($data); // Renvoyer les données récupérées en réponse à la requête AJAX
?>
