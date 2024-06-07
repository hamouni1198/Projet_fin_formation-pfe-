<?php
include('connect.php');
$con = connect();

$postProduit = "SELECT * FROM produit_post";
$result = mysqli_query($con, $postProduit);

$products = array();
if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $products[] = $row;
    }
}

// Close the connection
mysqli_close($con);

// Send JSON response
header('Content-Type: application/json');
echo json_encode(array('produit' => $products));
?>
