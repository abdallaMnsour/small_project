<?php

session_start();
require_once '../connect.php';

if (isset($_SESSION['user_login']) && $_SESSION['user_login']['priv'] == 1 && isset($_GET['id'])) {
    $query = "SELECT * FROM users WHERE id = {$_GET['id']}";
    $query = mysqli_query($conn, $query);

    if (mysqli_num_rows($query) != 1) {
        header('location: ../../users.php');
        exit;
    } else {

        try {
            $query = mysqli_fetch_assoc($query);
            $id = $query['id'];
            $query = "DELETE FROM users WHERE id = '$id'";
            mysqli_query($conn, $query);

            if (isset($_COOKIE['user_login']) && $_COOKIE['user_login'] == $id) {
                setcookie('user_login', '', 123, '/');
            }

            header('location: ../../users.php');
            exit;
        } catch (Exception $e) {
            echo $e->getMessage();
        }

    }

} else {
    header('location: ../../../');
    exit;
}