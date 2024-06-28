<?php
header('Content-Type: application/json');

// Connexion à la base de données MySQL
include('connect.php');
$con = connect();

// Vérification des informations de connexion
if(isset($_POST['nom']) && isset($_POST['code'])) {
    $username = $_POST['nom'];
    $password = $_POST['code'];

    // Échapper les valeurs pour éviter les injections SQL
    $username = $con->real_escape_string($username);
    $password = $con->real_escape_string($password);

    // Requête pour vérifier l'existence de l'utilisateur dans la base de données
    $query = "SELECT * FROM utilisateur WHERE nom = '$username' AND codutil = '$password'";
    $result = $con->query($query);

    if($result->num_rows > 0) {
        // Utilisateur authentifié, renvoie une réponse JSON
        echo json_encode(['success' => true, 'redirect' => 'mise.php?megajoeut']);
    } else {
        // Échec de l'authentification, renvoie une réponse JSON avec un message d'erreur pour le nom ou le mot de passe incorrect
        $errorMessage = [];
        if(empty($username)) {
            $errorMessage['username'] = ' entrer votre nom d\'utilisateur';
        }
        if(empty($password)) {
            $errorMessage['password'] = 'entrer votre mot de passe.';
        }
        if(!empty($username) && !empty($password)) {
            $errorMessage['invalid'] = 'Nom d\'utilisateur ou mot de passe incorrect.';
        }
        echo json_encode(['success' => false, 'message' => $errorMessage]);
    }
    
    // Fermer la connexion
    $con->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Requête invalide.']);
}
?>
