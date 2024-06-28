<?php
include('connect.php');
$con = connect();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $total = count($_FILES['fileImg']['name']);

    // Variable pour stocker les noms des images
    $imageNames = "";

    // Boucle à travers chaque fichier téléchargé
    for ($i = 0; $i < $total; $i++) {
        $imageName = $_FILES['fileImg']['name'][$i];
        $tmpName = $_FILES['fileImg']['tmp_name'][$i];
    
        $validImageExtension = ['jpg', 'jpeg', 'png', 'webp'];
        $imageExtension = explode('.', $imageName);
        $name = $imageExtension[0];
        $imageExtension = strtolower(end($imageExtension));
    
        // Vérifie si l'extension est valide
        if (!in_array($imageExtension, $validImageExtension)) {
            echo "Extension invalide";
            exit;
        } else {
            $uploadPath = '../images/' . $imageName;
    
            // Déplace le fichier téléchargé vers le dossier de destination avec le nom d'origine
            if (!move_uploaded_file($tmpName, $uploadPath)) {
                echo "Erreur lors du téléchargement de l'image.";
                exit;
            }
    
            // Ajoute le nom de l'image à la liste séparée par des virgules
            if ($imageNames === "") {
                $imageNames = $imageName;
            } else {
                $imageNames .= "," . $imageName;
            }
        }
    }

    // Récupère les autres données du formulaire
    $typeSend = $_POST['typeSend'];
    $sexeSend = $_POST['sexeSend'];
    $stockSend = $_POST['stockSend'];
    $nomSend = $_POST['nomSend'];
    $prixSend = $_POST['prixSend'];
    $ageSend = $_POST['ageSend'];
    $descSend = $_POST['descSend'];
    $dateSend = $_POST['dateSend'];

    // Insertion de la catégorie dans la base de données
    $insertCategory = "INSERT INTO categorie (typ_cat, sexe) VALUES (?, ?)";
    $stmt = $con->prepare($insertCategory);
    $stmt->bind_param("ss", $typeSend, $sexeSend);
    $stmt->execute();
    $id_categorie = $stmt->insert_id;

    // Si la catégorie est insérée avec succès, insère le produit avec les images dans la base de données
    if ($id_categorie > 0) {
        $insertProductQuery = "INSERT INTO produit (stock, id_categorie, nam, prix, age, img, description, date_creation) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $con->prepare($insertProductQuery);
        $stmt->bind_param("iississs", $stockSend, $id_categorie, $nomSend, $prixSend, $ageSend, $imageNames, $descSend, $dateSend);
        $stmt->execute();

        // Vérifie si l'insertion a réussi
        if ($stmt->affected_rows > 0) {
            echo "Insertion réussie !";
        } else {
            echo "Erreur lors de l'insertion du produit.";
        }
    } else {
        echo "Erreur lors de l'insertion de la catégorie.";
    }
}

// Ferme la connexion à la base de données
$con->close();
?>
