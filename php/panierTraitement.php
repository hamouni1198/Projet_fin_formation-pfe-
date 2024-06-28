<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include('connect.php'); // Inclusion du fichier de connexion à la base de données
$con = connect();  // Connexion à la base de données

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $tel = $_POST['tel'];
    $productId = $_POST['productId'];
    $quantity = $_POST['quantity'];

    // Vérifier les valeurs reçues
    echo "Données reçues : <br>";
    echo "Username : " . htmlspecialchars($username) . "<br>";
    echo "Email : " . htmlspecialchars($email) . "<br>";
    echo "Tel : " . htmlspecialchars($tel) . "<br>";
    echo "ProductId : " . $productId . "<br>";
    echo "Quantity : " . $quantity . "<br>";

    // Commencer une transaction pour assurer l'intégrité des données
    $con->begin_transaction();

    // Vérifier si le client existe déjà par son email
    $query = "SELECT id_client FROM client WHERE nom = ? AND email=? AND tel=?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("ssi", $username, $email, $tel);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Le client existe déjà, récupérer son ID
        $row = $result->fetch_assoc();
        $clientId = $row['id_client'];
        echo "Client existant. ID : " . $clientId . "<br>";
    } else {
        // Le client n'existe pas, l'ajouter à la base de données
        $query = "INSERT INTO client (nom, email, tel) VALUES (?, ?, ?)";
        $stmt = $con->prepare($query);
        $stmt->bind_param("sss", $username, $email, $tel);
        if ($stmt->execute()) {
            $clientId = $stmt->insert_id;
            echo "Nouveau client ajouté. ID : " . $clientId . "<br>";
        } else {
            echo "Erreur lors de l'ajout du client : " . $stmt->error;
            $con->rollback(); // Annuler la transaction en cas d'erreur
            exit(); // Arrête l'exécution du script en cas d'erreur
        }
    }

    // Ajouter le produit au panier
    $query = "INSERT INTO panier (id_client, id_produit, quantité) VALUES (?, ?, ?)";
    $stmt = $con->prepare($query);
    $stmt->bind_param("iii", $clientId, $productId, $quantity);
    if ($stmt->execute()) {
        echo "Produit ajouté au panier!";
        $con->commit(); // Valider la transaction si tout s'est bien passé
    } else {
        echo "Erreur lors de l'ajout du produit au panier : " . $stmt->error;
        $con->rollback(); // Annuler la transaction en cas d'erreur
        exit(); // Arrête l'exécution du script en cas d'erreur
    }

    // Fermer la connexion
    $stmt->close();
    $con->close();
} else {
    echo "Méthode de requête non supportée!";
}
?>
