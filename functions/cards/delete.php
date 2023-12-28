<?php

session_start();
require_once '../connect.php';

if (isset($_SESSION['user_login']) && isset($_GET['id'])) {

    $query = "DELETE FROM cards WHERE user_id = '{$_SESSION['user_login']['id']}' and product_id = '{$_GET['id']}'";

    mysqli_query($conn, $query);
    
    header('location: ../../cards.php');
    exit;

} else {
    header('location: ../../../');
    exit;
}