<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $response = array(
        'status' => 'error',
        'message' => 'Méthode de requête invalide'
    );
    echo json_encode($response);
    exit; // Stop further script execution
}

$client_id = isset($_POST['input_client']) ? $_POST['input_client'] : null;
$total = isset($_POST['total']) ? $_POST['total'] : null;

if ($client_id === null || $total === null) {
    $response = array(
        'status' => 'error',
        'message' => 'Données manquantes'
    );
} else {
    $response = array(
        'status' => 'success',
        'message' => 'Données reçues avec succès',
        'data' => array(
            'panier_id' => $client_id,
            'total' => $total
        )
    );
}

echo json_encode($response);
?>
