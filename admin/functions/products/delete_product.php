<?php

session_start();
require_once '../connect.php';

if (isset($_SESSION['user_login']) && $_SESSION['user_login']['priv'] == 1 && isset($_GET['id'])) {
    $query = "SELECT * FROM products WHERE id = {$_GET['id']}";
    $query = mysqli_query($conn, $query);

    if (mysqli_num_rows($query) != 1) {
        header('location: ../../products.php');
        exit;
    } else {

        try {
            $query = "DELETE FROM products WHERE id = {$_GET['id']}";
            mysqli_query($conn, $query);
            header('location: ../../products.php');
            exit;
        } catch (Exception $e) {
            echo $e->getMessage();
        }

    }

} else {
    header('location: ../../../');
    exit;
}