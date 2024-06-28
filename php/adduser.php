<?php
include('connect.php');
$con = connect();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['tel'])) {
        $tel = $_POST['tel'];
    }
    if (isset($_POST['email'])) {
        $email = $_POST['email'];
    }
    if (isset($_POST['nom'])) {
        $nom = $_POST['nom'];
    }

    $stmt = $con->prepare("INSERT INTO client (nom, email, tel) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $nom, $email, $tel);

    if ($stmt->execute()) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
} else {
    echo "Invalid input.";
}

$con->close();
?>
