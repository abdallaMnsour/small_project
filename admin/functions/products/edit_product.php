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
    $salary = clear($_POST['salary']);
    $cat = clear($_POST['category']);
    $desc = clear($_POST['description']);

    // validate name
    if (empty($name)) {
        $all_errors['name'] = 'The name product cannot be empty';
    }

    // validate salary
    if (empty($salary)) {
        $all_errors['salary'] = 'The salary cannot be empty';
    }

    // validate category
    if ($cat == '') {
        $all_errors['main'] = 'The category is wrong, cannot be empty';
    } else {
        $query = "SELECT * FROM categories WHERE id = '$cat'";
        $query = mysqli_query($conn, $query);
        if (mysqli_num_rows($query) != 1) {
            $all_errors['main'] = 'The category is wrong, you are changed the input';
        }
    }

    // validate description
    if (empty($desc)) {
        $all_errors['desc'] = 'The description cannot be empty';
    } else if (strlen($desc) < 8 || strlen($desc) > 254) {
        $all_errors['desc'] = 'min length character is 8 and max is 254';
    }

    $_SESSION['input_values'] = [
        'name' => $name,
        'desc' => $desc,
        'cat' => $cat,
        'salary' => $salary
    ];

    if (empty($all_errors)) {

        try {
            $query = "UPDATE products SET name='$name', category_id='$cat', salary='$salary', description='$desc' WHERE id = '$id'";
            mysqli_query($conn, $query);
        } catch (Exception $e) {
            $_SESSION['errors']['main'] = 'The category is wrong, you are changed the input<br>' . $e->getMessage();
            header('location: ../../views/products/update.php?id=' . $id);
            exit;
        }

        unset($_SESSION['input_values']);
        header('location: ../../products.php?id=' . $id);
        exit;

    } else {
        $_SESSION['errors'] = $all_errors;
        header('location: ../../views/products/update.php?id=' . $id);
        exit;
    }

} else {
    header('location: ../../../');
    exit;
}
