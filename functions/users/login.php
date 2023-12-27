<?php

session_start();

if (isset($_POST)) {
    if (
        isset($_POST['email']) &&
        isset($_POST['password'])
    ) {

        function clear ($value)
        {
            $value = trim($value);
            $value = addslashes($value);
            return $value;
        }
        require_once '../connect.php';
        $all_errors = [];

        $email = clear($_POST['email']);
        $password = clear($_POST['password']);

        if (empty($email)) {
            $all_errors['email'] = 'your email cannot be empty';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $all_errors['email'] = 'Invalid email format.';
        }

        if (empty($password)) {
            $all_errors['password'] = 'your password cannot be empty';
        }

        $remember_bool = false;
        if (isset($_POST['remember'])) {
            $remember = clear($_POST['remember']);
            if (!empty($remember) && $remember == 'yes') {
                $remember_bool = true;
            } else {
                $all_errors['remember'] = 'The input has been tampered with.';
            }
        }

        $user = $_SESSION['person'] = [
            'remember' => $remember_bool,
            'password' => $password,
            'email' => $email
        ];

        if (empty($all_errors)) {

            try {
                $query = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";
                $query = mysqli_query($conn, $query);
            } catch (Exception $e) {
                $_SESSION['errors']['sql'] = $e->getMessage();
                header('location: ../../login/login.php');
                exit;
            }

            if (mysqli_num_rows($query) != 1) {
                $_SESSION['errors']['sql'] = 'the userEmail or password is wrong try again';
                header('location: ../../login/login.php');
                exit;
            }

            $user = mysqli_fetch_assoc($query);

            if ($remember_bool) {
                setcookie('user_login', $user['id'], time() + (60 * 60 * 24 * 30 * 6), '/');
            }

            session_unset();

            $_SESSION['user_login'] = $user;

            header('location: ../../');
            exit;

        } else {
            $_SESSION['errors'] = $all_errors;
            header('location: ../../login/login.php');
            exit;
        }
    } else {
        $_SESSION['errors']['input_error'] = 'you have an error in you\'r inputs make an refresh and try again';
        header('location: ../../login/login.php');
        exit;
    }
} else {
    header('location: ../../');
    exit;
}
