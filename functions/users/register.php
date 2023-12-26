<?php

session_start();

if (isset($_POST)) {
    if (
        isset($_POST['name']) &&
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

        $name = clear($_POST['name']);
        $email = clear($_POST['email']);
        $password = clear($_POST['password']);

        if (empty($name)) {
            $all_errors['name'] = 'your name cannot be empty';
        } else if (strlen($name) > 50 || strlen($name) < 3) {
            $all_errors['name'] = 'min character is 3 and max is 50 try again';
        }

        if (empty($email)) {
            $all_errors['email'] = 'your email cannot be empty';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $all_errors['email'] = 'Invalid email format.';
        } else  {
            $query = "SELECT id FROM users WHERE email = '$email'";
            $query = mysqli_query($conn, $query);
            if ($query->num_rows > 0) {
                $all_errors['email'] = 'This email is already reserved';
            }
        }

        if (empty($password)) {
            $all_errors['password'] = 'your password cannot be empty';
        } else if (strlen($password) < 8) {
            $all_errors['password'] = 'Password must be at least 8 characters long.';
        } else {
            preg_match('/[\w.]+/', $password, $match);
            if (strlen($password) != strlen($match[0])) {
                $all_errors['password'] = 'Password can only contain letters, numbers, dot, and underscores.';
            }
        }

        $remember_bool = false;
        if (isset($_POST['remember'])) {
            $remember = clear($_POST['remember']);
            if (!empty($remember) && $remember == 'yes') {
                $remember_bool = true;
            }
        }

        $user = $_SESSION['person'] = [
            'name' => $name,
            'remember' => $remember_bool,
            'password' => $password,
            'email' => $email
        ];

        if (empty($all_errors)) {

            try {
                $query = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$password')";
                $query = mysqli_query($conn, $query);
                $id = mysqli_insert_id($conn);
            } catch (Exception $e) {
                $_SESSION['errors']['sql'] = $e->getMessage();
                header('location: ../../login/register.php');
                exit;
            }
            if ($remember_bool) {
                setcookie('user_login', $id, time() + (60 * 60 * 24 * 30 * 6), '/');
            }
            session_unset();
            $_SESSION['user_login'] = [
                'name' => $name,
                'password' => $password,
                'email' => $email,
                'id' => $id
            ];
            header('location: ../../');
            exit;
        } else {
            $_SESSION['errors'] = $all_errors;
            header('location: ../../login/register.php');
            exit;
        }
    } else {
        $_SESSION['errors']['input_error'] = 'you have an error in you\'r inputs make an refresh and try again';
        header('location: ../../login/register.php');
        exit;
    }
} else {
    header('location: ../../');
    exit;
}
