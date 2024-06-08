<?php
include('connect.php');
$con = connect();

$postProduit = "SELECT * FROM produit_post";
$result = mysqli_query($con, $postProduit);

$data = array();
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

// Send JSON response
echo json_encode(array('produits' => $data));
?>
