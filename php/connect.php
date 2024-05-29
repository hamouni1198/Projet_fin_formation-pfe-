<?php
function connect()
{ 
$server = 'localhost';
    $bd = 'megajouet';
    $user = 'root';
    $password = '';
    $con = new mysqli($server, $user, $password, $bd);

    return  $con;
     }
    ?>