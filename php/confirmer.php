<?php
include('connect.php'); // Include database connection script
session_start(); // Start session

$con = connect(); // Connect to the database

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Retrieve input data
  $input_client = $_POST['input_client'];
  $total = $_POST['total'];

  // Check if id_client is set in session
  if (isset($_SESSION['id_client'])) {
    $id_client = $_SESSION['id_client'];

    // Check if id_panier exists in the panier table
    $check_query = "SELECT COUNT(*) AS count FROM panier WHERE id_panier = ?";
    $check_stmt = $con->prepare($check_query);
    $check_stmt->bind_param("i", $input_client);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();
    $row = $check_result->fetch_assoc();

    if ($row['count'] > 0) {
      // Insertion query
      $insert_query = "INSERT INTO commande (id_client, id_panier, total) VALUES (?, ?, ?)";
      $insert_stmt = $con->prepare($insert_query);
      $insert_stmt->bind_param("iii", $id_client, $input_client, $total);

      // Execute insertion query
      if ($insert_stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Commande insérée avec succès']);
      } else {
        echo json_encode(['success' => false, 'message' => 'Erreur lors de l\'insertion de la commande']);
      }

      // Close statement
      $insert_stmt->close();
    } else {
      echo json_encode(['success' => false, 'message' => 'L\'id_panier spécifié n\'existe pas dans la table panier']);
    }

    // Close check statement
    $check_stmt->close();
  } else {
    echo json_encode(['success' => false, 'message' => 'Identifiant client non trouvé dans la session']);
  }
} else {
  echo json_encode(['success' => false, 'message' => 'Méthode non autorisée']);
}
?>
