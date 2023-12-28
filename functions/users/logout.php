<?php

session_start();
require_once '../connect.php';

if (isset($_SESSION['user_login']) && $_SESSION['user_login']['priv'] == 0) {

    $id = $_SESSION['user_login']['id'];

    try {
        mysqli_query($conn,"DELETE FROM users WHERE id = '$id'");
    } catch (Exception $e) {
        $_SESSION['error_delete'] = $e->getMessage();
        header('location: ../../');
        exit;
    }

    session_destroy();

    if (isset($_COOKIE['user_login'])) {
        setcookie('user_login', '', 123, '/');
    }

    header('location: ../../');
    exit;
} else if ($_SESSION['user_login']['priv'] == 1) {

    session_destroy();

    if (isset($_COOKIE['user_login'])) {
        setcookie('user_login', '', 123, '/');
    }

    header('location: ../../');
    exit;
} else {
    header('location: ../../');
    exit;
}
