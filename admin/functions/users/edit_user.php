<?php

session_start();
require_once '../connect.php';

if (isset($_SESSION['user_login']) && $_SESSION['user_login']['priv'] == '1' && $_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    function clear($value)
    {
        $value = trim($value);
        $value = addslashes($value);
        return $value;
    }

    $all_errors = [];

    $id = clear($_POST['id']);
    $name = clear($_POST['name']);
    $email = clear($_POST['email']);
    $priv = clear($_POST['priv']);

    // validate name
    if (empty($name)) {
        $all_errors['name'] = 'The name cannot be empty';
    }

    // validate email
    if (empty($email)) {
        $all_errors['email'] = 'The email cannot be empty';
    }

    // validate privilege
    if ($priv == '') {
        $all_errors['main'] = 'The privilege is wrong, cannot be empty';
    } else {
        if (!($priv == 1 || $priv == 0)) {
            $all_errors['main'] = 'The category is wrong, you are changed the input';
        }
    }

    $_SESSION['input_values'] = [
        'name' => $name,
        'email' => $email,
        'priv' => $priv
    ];

    if (empty($all_errors)) {

        try {
            $query = "UPDATE users SET name='$name', email='$email', priv='$priv' WHERE id = '$id'";
            mysqli_query($conn, $query);
        } catch (Exception $e) {
            $_SESSION['errors']['main'] = 'you have contact us quickly<br>' . $e->getMessage();
            header('location: ../../views/users/update.php?id=' . $id);
            exit;
        }

        unset($_SESSION['input_values']);
        header('location: ../../users.php?id=' . $id);
        exit;

    } else {
        $_SESSION['errors'] = $all_errors;
        header('location: ../../views/users/update.php?id=' . $id);
        exit;
    }

} else {
    header('location: ../../../');
    exit;
}
