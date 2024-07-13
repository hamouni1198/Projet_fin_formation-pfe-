<?php
include('connect.php');
$con = connect();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $stockSend = $_POST['stockSend'];
    $id_categorie = $_POST['id_categorie'];
    $id_utilisateur = $_POST['id_utilisateur'];
    $nomSend = $_POST['nomSend'];
    $prixSend = $_POST['prixSend'];
    $ageSend = $_POST['ageSend'];
    $descSend = $_POST['descSend'];
    $dateSend = $_POST['dateSend'];
    $typSend = $_POST['typeSend'];
    $sexeSend = $_POST['sexeSend'];
    $id_produit = $_POST['id_produit'];

    $newImageNames = "";

    if (isset($_FILES['fileImg']) && count($_FILES['fileImg']['name']) > 0 && $_FILES['fileImg']['name'][0] !== '') {
        // Récupère les anciennes images pour les supprimer
        $query = "SELECT img FROM produit WHERE id_produit = ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param("i", $id_produit);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $oldImages = explode(',', $row['img']);
        $stmt->close();

        // Supprime les anciennes images du dossier
        foreach ($oldImages as $oldImage) {
            $oldImagePath = '../images/' . $oldImage;
            if (file_exists($oldImagePath)) {
                unlink($oldImagePath);
            }
        }

        // Télécharge et enregistre les nouvelles images
        $total = count($_FILES['fileImg']['name']);
        for ($i = 0; $i < $total; $i++) {
            $imageName = $_FILES['fileImg']['name'][$i];
            $tmpName = $_FILES['fileImg']['tmp_name'][$i];

            $validImageExtension = ['jpg', 'jpeg', 'png', 'webp'];
            $imageExtension = explode('.', $imageName);
            $imageExtension = strtolower(end($imageExtension));

            // Vérifie si l'extension est valide
            if (!in_array($imageExtension, $validImageExtension)) {
                echo "Extension invalide";
                exit;
            } else {
                // Récupère le timestamp actuel
                $timestamp = time();
                // Génère un nom unique pour chaque image
                $newName = substr(md5($timestamp . $i), 0, 8);
                $newImageName = $newName . '.' . $imageExtension;
                $uploadPath = '../images/' . $newImageName;

                // Déplace le fichier téléchargé vers le dossier de destination avec le nouveau nom
                if (!move_uploaded_file($tmpName, $uploadPath)) {
                    echo "Erreur lors du téléchargement de l'image.";
                    exit;
                }

                // Ajoute le nom de l'image à la liste séparée par des virgules
                if ($newImageNames === "") {
                    $newImageNames = $newImageName;
                } else {
                    $newImageNames .= "," . $newImageName;
                }
            }
        }
    } else {
        // Si aucun fichier d'image n'est téléchargé, conserver les anciennes images
        $query = "SELECT img FROM produit WHERE id_produit = ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param("i", $id_produit);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $newImageNames = $row['img'];
        $stmt->close();
    }

    // Mise à jour des informations du produit et de la catégorie
    if (count($_POST) > 0) {
        $stmt = $con->prepare("UPDATE categorie c, produit p 
            SET p.stock=?,  
                c.id_categorie=?, 
                p.id_utilisateur=?, 
                p.nam=?, 
                p.prix=?, 
                p.age=?, 
                p.img=?, 
                p.description=?, 
                p.date_creation=?, 
                c.typ_cat=?, 
                c.sexe=?
            WHERE c.id_categorie=? 
            AND p.id_produit=?");

        $stmt->bind_param("iiississsssii", 
            $stockSend, 
            $id_categorie, 
            $id_utilisateur, 
            $nomSend, 
            $prixSend, 
            $ageSend, 
            $newImageNames, 
            $descSend, 
            $dateSend, 
            $typSend, 
            $sexeSend, 
            $id_categorie, 
            $id_produit
        );

        if ($stmt->execute()) {
            echo "Record Modified Successfully";
        } else {
            echo "Error updating record: " . $stmt->error;
        }

        $stmt->close();
    }
    $con->close();
}
?>
