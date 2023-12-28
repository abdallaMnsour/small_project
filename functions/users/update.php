<?php

session_start();

if (isset($_POST)) {
    if (
        isset($_POST['email']) &&
        isset($_POST['name'])
    ) {

        function clear ($value)
        {
            $value = trim($value);
            $value = addslashes($value);
            return $value;
        }
        require_once '../connect.php';
        $all_errors = '';

        $email = clear($_POST['email']);
        $name = clear($_POST['name']);

        if (empty($name)) {
            $all_errors = 'your name cannot be empty';
        }

        // اذا كان الايميل الجديد يساوي القديم فلا تقم باي من الخطوات التاليه لانها غير ضروريه
        if ($email != $_SESSION['user_login']['email']) {
            if (empty($email)) {
                $all_errors = 'your email cannot be empty';
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $all_errors = 'Invalid email format.';
            } else  {
                $query = "SELECT id FROM users WHERE email = '$email'";
                $query = mysqli_query($conn, $query);
                if ($query->num_rows > 0) {
                    $all_errors = 'This email is already reserved';
                }
            }
        }

        if ($all_errors == '') {

            try {
                $query = "UPDATE users SET email='$email', name='$name' WHERE id = {$_SESSION['user_login']['id']}";
                mysqli_query($conn, $query);
            } catch (Exception $e) {
                $_SESSION['error'] = $e->getMessage();
                header('location: ../../user.php');
                exit;
            }

            header('location: ../../user.php');
            exit;

        } else {
            $_SESSION['error'] = $all_errors;
            header('location: ../../user.php');
            exit;
        }
    } else {
        $_SESSION['error'] = 'you have an error in you\'r inputs make an refresh and try again';
        header('location: ../../user.php');
        exit;
    }
} else {
    header('location: ../../');
    exit;
}
