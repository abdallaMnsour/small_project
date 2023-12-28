<?php

session_start();
$user_bool = false;

/*
عندما أقوم بتسجيل الدخول اريد من المتصفح ان يتذكرني
حينها اقوم بتسجيل كوكي بها رقم ال id الخاص بالمستخدم
*/
if (isset($_COOKIE['user_login'])) {
    require_once 'functions/connect.php';
    $query = "SELECT * FROM users WHERE id = '{$_COOKIE['user_login']}'";
    $query = mysqli_query($conn, $query);
    $_SESSION['user_login'] = mysqli_fetch_assoc($query);
    // اقوم بتعريف متغير به كل صفات المستخد كي يسهل علي استخدامه
    $user = $_SESSION['user_login'];
    $user_bool = true;
    /*
    اذا لم يكن هناك كوكي معناها انه لم يطلب ان يتم تذكره
    لذا قم بطريقه السيشن اللتي هي عباره عن اراي بها كل معلومات المستخدم
    */
} else if (isset($_SESSION['user_login'])) {
    require_once 'functions/connect.php';
    $query = "SELECT * FROM users WHERE id = '{$_SESSION['user_login']['id']}'";
    $query = mysqli_query($conn, $query);
    $user = mysqli_fetch_assoc($query);
    $user_bool = true;
}


/*
تحقق قي اي صفحه ان حتي تقوم بتفعيل اي
*/
$page_bool = false;
if (isset($_GET['page'])) {
    $page_bool = true;
    if ($_GET['page'] == 'home') {
        $page_home = 'active';
    } else if ($_GET['page'] == 'account') {
        $page_acc = 'active';
    } else if ($_GET['page'] == 'products') {
        $page_pro = 'active';
    } else if ($_GET['page'] == 'cart') {
        $page_cart = 'active';
    }
}

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style/style.css">
    <link rel="stylesheet" href="style/bootstrap.min.css">
    <title>Document</title>
</head>
<body>

<nav class="navbar navbar-expand-lg bg-body-tertiary my-nav p-3">
    <div class="container-fluid">
        <a class="navbar-brand" href="user.php"><?= $user_bool ? $user['name'] : 'Hello user' ?></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <?php if ($user_bool) : ?>
                    <li class="nav-item">
                        <a class="nav-link <?= $page_bool ? $page_home ?? '' : 'active' ?>" aria-current="page" href="index.php?page=home">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= $page_pro ?? '' ?>" href="products.php?page=products">Product</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= $page_acc ?? '' ?>" href="user.php?page=account">Account</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= $page_cart ?? '' ?>" href="carts.php?page=cart">Cart</a>
                    </li>
                <?php else : ?>
                    <li class="nav-item">
                        <a class="nav-link <?= $page_bool ? $page_home ?? '' : 'active' ?>" aria-current="page" href="index.php?page=home">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= $page_pro ?? '' ?>" href="products.php?page=products">Product</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
    <div class="d-flex">
        <?php if ($user_bool && $user['priv'] == '1') : ?>
            <a href="admin/products.php" class="btn btn-primary">Edit products</a>
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#delete">
                Logout
            </button>
        <?php elseif ($user_bool) : ?>
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#delete">
                Logout
            </button>
        <?php else : ?>
            <a href="login/login.php" class="btn btn-primary">Login</a>
            <a href="login/register.php" class="btn btn-primary">Register</a>
        <?php endif; ?>
    </div>
</nav>

<!-- Modal -->
<div class="modal fade" id="delete" tabindex="-1" aria-labelledby="deleteLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="deleteLabel">are you sure you want to log-out ?</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                if you click on "Yes" you will log-out from our site
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <a href="functions/users/logout.php" class="btn btn-danger">Yes</a>
            </div>
        </div>
    </div>
</div>
