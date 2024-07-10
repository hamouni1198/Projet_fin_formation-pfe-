<?php
session_start(); // Démarrage de la session

include('connect.php'); // Inclusion du fichier de connexion à la base de données

// Vérification si l'utilisateur est connecté et que $_SESSION['id_client'] est défini
if (!isset($_SESSION['id_client'])) {
    // Gérer le cas où l'utilisateur n'est pas connecté ou où $_SESSION['id_client'] n'est pas défini
    echo json_encode(['error' => 'L\'utilisateur n\'est pas connecté']);
    exit;
}

// Connexion à la base de données
$con = connect(); 

// Récupération de l'ID client depuis la session
$id_client = $_SESSION['id_client'];

// Requête SQL pour récupérer les produits du panier
$sql = "SELECT produit.id_produit, produit.nam, produit.img, produit.prix, detail.quantite,panier.id_panier
        FROM panier
        INNER JOIN detail ON panier.id_panier = detail.id_panier
        INNER JOIN produit ON detail.id_produit = produit.id_produit
        WHERE panier.id_client = ?";

// Préparation de la requête SQL
$stmt = $con->prepare($sql);
if (!$stmt) {
    // En cas d'erreur de préparation, renvoyer une réponse d'erreur JSON
    echo json_encode(['error' => 'Préparation de la requête échouée: ' . $con->error]);
    exit;
}

// Liaison des paramètres et exécution de la requête
$stmt->bind_param("i", $id_client);
$stmt->execute();

// Récupération des résultats de la requête
$result = $stmt->get_result();

// Création d'un tableau pour stocker les produits
$produits = array();
while ($row = $result->fetch_assoc()) {
    $produits[] = $row;
}

// Fermeture du statement
$stmt->close();

// Requête SQL pour compter le nombre de produits dans le panier
$count_sql = "SELECT COUNT(detail.id_produit) AS nbProduit FROM panier
              INNER JOIN detail ON panier.id_panier = detail.id_panier
              WHERE panier.id_client = ?";
$stmt_count = $con->prepare($count_sql);
$stmt_count->bind_param("i", $id_client);
$stmt_count->execute();
$result_count = $stmt_count->get_result();

// Récupération du nombre de produits dans le panier
$count_data = $result_count->fetch_assoc();
$nbProduit = $count_data['nbProduit'];

// Fermeture du statement et de la connexion
$stmt_count->close();
$con->close();

// Envoi de la réponse en JSON avec les produits récupérés et le nombre de produits dans le panier
header('Content-Type: application/json');
echo json_encode(['produits' => $produits, 'nbProduit' => $nbProduit]);
?>
