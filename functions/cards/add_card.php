<?php
session_start();

if (isset($_SESSION['user_login']) && isset($_GET['product'])) {

    require_once '../connect.php';

    $id_product = $_GET['product'];
    $id_user = $_SESSION['user_login']['id'];

    try {

// تحقق مما اذا كان ال id موجود في الداتابيز ام انه تم التلاعب به
        $query = "SELECT * FROM products WHERE id = '$id_product'";
        $query = mysqli_query($conn, $query);
        if (mysqli_num_rows($query) != 1) {
            header('location: ../../products.php');
            exit;
        }

        // تحقق مما اذا كان المستخدم قام باضافه المنتج الي المفضله من قبل ام لا
        $query = "SELECT * FROM cards WHERE product_id = '$id_product'";
        $query = mysqli_query($conn, $query);
        if (mysqli_num_rows($query) > 0) {
            header('location: ../../products.php');
            exit;
        }

        $query = "INSERT INTO cards (user_id, product_id) VALUES ('$id_user', '$id_product')";
        mysqli_query($conn, $query);
        header('location: ../../products.php');
        exit;
    } catch (Exception $e) {
        $_SESSION['error_cart'] = '<b>Error add card : </b>you have contact us quickly<br>';
        header('location: ../../products.php');
        exit;
    }

} else {
    header('location: ../../');
    exit;
}
