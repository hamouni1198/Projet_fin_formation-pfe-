<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include('connect.php'); // Inclusion du fichier de connexion à la base de données
$con = connect(); // Connexion à la base de données

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validation des entrées utilisateur
    $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $tel = filter_var($_POST['tel'], FILTER_SANITIZE_STRING);
    $productId = filter_var($_POST['productId'], FILTER_VALIDATE_INT);
    $quantity = filter_var($_POST['quantity'], FILTER_VALIDATE_INT);

    if (!$username || !$email || !$tel || !$productId || !$quantity) {
        echo "Entrées invalides!";
        exit();
    }

    // Vérifier si le client existe déjà par son email
    $query = "SELECT id_client FROM client WHERE email = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Le client existe déjà, récupérer son ID
        $row = $result->fetch_assoc();
        $clientId = $row['id_client'];
    } else {
        // Le client n'existe pas, l'ajouter à la base de données
        $query = "INSERT INTO client (nom, email, tel) VALUES (?, ?, ?)";
        $stmt = $con->prepare($query);
        $stmt->bind_param("sss", $username, $email, $tel);
        $stmt->execute();
        $clientId = $stmt->insert_id;
    }

    // Ajouter le produit au panier
    $query = "INSERT INTO panier (id_client, id_produit, quantité) VALUES (?, ?, ?)";
    $stmt = $con->prepare($query);
    $stmt->bind_param("iii", $clientId, $productId, $quantity);
    if ($stmt->execute()) {
        echo "Produit ajouté au panier!";
    } else {
        echo "Erreur lors de l'ajout du produit au panier!";
    }

    // Fermer la connexion
    $stmt->close();
    $con->close();
} else {
    echo "Méthode de requête non supportée!";
}
?>
