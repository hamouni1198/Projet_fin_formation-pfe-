<?php
include('connect.php');
$con = connect();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $total = count($_FILES['fileImg']['name']);

    $imageNames = "";

    for ($i = 0; $i < $total; $i++) {
        $imageName = $_FILES['fileImg']['name'][$i];
        $tmpName = $_FILES['fileImg']['tmp_name'][$i];

        $validImageExtension = ['jpg', 'jpeg', 'png', 'webp'];
        $imageExtension = explode('.', $imageName);
        $name = $imageExtension[0];
        $imageExtension = strtolower(end($imageExtension));

        if (!in_array($imageExtension, $validImageExtension)) {
            echo "Extension invalide";
            exit;
        } else {
            $newImageName = $name . "-" . uniqid(); 
            $newImageName .= '.' . $imageExtension;

            $uploadPath = '../images/' . $newImageName;

            if (!move_uploaded_file($tmpName, $uploadPath)) {
                echo "Erreur lors du téléchargement de l'image.";
                exit;
            }

            if ($imageNames === "") {
                $imageNames = $newImageName;
            } else {
                $imageNames .= "," . $newImageName;
            }
        }
    }

    $typeSend = $_POST['typeSend'];
    $sexeSend = $_POST['sexeSend'];
    $stockSend = $_POST['stockSend'];
    $nomSend = $_POST['nomSend'];
    $prixSend = $_POST['prixSend'];
    $ageSend = $_POST['ageSend'];
    $descSend = $_POST['descSend'];
    $dateSend = $_POST['dateSend'];

    $insertCategory = "INSERT INTO categorie (typ_cat, sexe) VALUES (?, ?)";
    $stmt = $con->prepare($insertCategory);
    $stmt->bind_param("ss", $typeSend, $sexeSend);
    $stmt->execute();
    $id_categorie = $stmt->insert_id;

    if ($id_categorie > 0) {
        $insertProductQuery = "INSERT INTO produit (stock, id_categorie, nam, prix, age, img, description, date_creation) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $con->prepare($insertProductQuery);
        $stmt->bind_param("iississs", $stockSend, $id_categorie, $nomSend, $prixSend, $ageSend, $imageNames, $descSend, $dateSend);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo "Insertion réussie !";
        } else {
            echo "Erreur lors de l'insertion du produit.";
        }
    } else {
        echo "Erreur lors de l'insertion de la catégorie.";
    }
}
$con->close();
?>
