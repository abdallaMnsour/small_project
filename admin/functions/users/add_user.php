<?php

session_start();
if (isset($_SESSION['user_login']) && $_SESSION['user_login']['priv'] == '1' && $_SERVER['REQUEST_METHOD'] == 'POST') {
    function clear ($value)
    {
        $value = trim($value);
        $value = addslashes($value);
        return $value;
    }

    require_once '../connect.php';
    $all_errors = [];

    $name = clear($_POST['name']);
    $email = clear($_POST['email']);
    $priv = clear($_POST['priv']);

    // validate name
    if (empty($name)) {
        $all_errors['name'] = 'The name product cannot be empty';
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
            $all_errors['main'] = 'The privilege is wrong, you are changed the input';
        }
    }

    $_SESSION['input_values'] = [
        'name' => $name,
        'email' => $email,
        'priv' => $priv
    ];

    if (empty($all_errors)) {

        try {
            $query = "INSERT INTO users (name, email, priv) VALUES ('$name', '$email', '$priv')";
            $query = mysqli_query($conn, $query);
        } catch (Exception $e) {
            $_SESSION['errors']['main'] = 'The category is wrong, you are changed the input<br>' . $e->getMessage();
            header('location: ../../users.php');
            exit;
        }

        unset($_SESSION['input_values']);
        header('location: ../../users.php');
        exit;

    } else {
        $_SESSION['errors'] = $all_errors;
        header('location: ../../users.php');
        exit;
    }

} else {
    header('location: ../../../');
    exit;
}