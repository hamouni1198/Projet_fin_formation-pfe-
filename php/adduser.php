<?php
session_start();
include('connect.php');
$con = connect();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Détruire l'ancienne session
    session_unset();
    session_destroy();
    // Recommencer une nouvelle session
    session_start();

    if (isset($_POST['tel'])) {
        $tel = $_POST['tel'];
    }
    if (isset($_POST['email'])) {
        $email = $_POST['email'];
    }
    if (isset($_POST['nom'])) {
        $nom = $_POST['nom'];
    }

    // Vérifier si le client existe déjà
    $check_stmt = $con->prepare("SELECT id_client FROM client WHERE nom = ? AND email = ? ");
    $check_stmt->bind_param("ss", $nom, $email);
    $check_stmt->execute();
    $check_stmt->store_result();
    
    if ($check_stmt->num_rows > 0) {
        // Le client existe déjà
        $check_stmt->bind_result($client_id);
        $check_stmt->fetch();
        $_SESSION['id_client'] = $client_id;
        $_SESSION['client_nom'] = $nom;
        echo "Client already exists. Client ID: " . $client_id;
    } else {
        // Insérer un nouveau client
        $stmt = $con->prepare("INSERT INTO client (nom, email, tel) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $nom, $email, $tel);

        if ($stmt->execute()) {
            // Récupérer l'ID du client inséré
            $client_id = $con->insert_id;
            // Stocker l'ID du client dans la session
            $_SESSION['id_client'] = $client_id;
            $_SESSION['client_nom'] = $nom;
            echo "New record created successfully. Client ID: " . $client_id;
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    }
    $check_stmt->close();
} else {
    echo "Invalid input.";
}

$con->close();
?>
