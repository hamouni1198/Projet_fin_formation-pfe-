<?php
include('connect.php');
$con = connect();

$stockSend = $_POST['stockSend'];
$id_categorie = $_POST['id_categorie'];
$id_utilisateur = $_POST['id_utilisateur']; 
$namSend = $_POST['nomSend'];
$prixSend = $_POST['prixSend'];
$ageSend = $_POST['ageSend'];
$imgSend = $_POST['imgSend'];
$descSend = $_POST['descSend'];
$dateSend = $_POST['dateSend'];
$typSend = $_POST['typeSend'];
$sexeSend = $_POST['sexeSend'];
$id_produit = $_POST['id_produit'];

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
        $namSend, 
        $prixSend, 
        $ageSend, 
        $imgSend, 
        $descSend, 
        $dateSend, 
        $typSend, 
        $sexeSend, 
        $id_categorie, 
        $id_produit
    );

    if ($stmt->execute()) {
        $message = "Record Modified Successfully";
    } else {
        $message = "Error updating record: " . $stmt->error;
    }

    $stmt->close();
}
$con->close();
?>
