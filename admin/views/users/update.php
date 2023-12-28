<?php

require_once '../../functions/connect.php';

session_start();

if (isset($_SESSION['user_login']) && $_SESSION['user_login']['priv'] == 1 && isset($_GET['id'])) {

    $id = $_GET['id'];

    $query = "SELECT * FROM users WHERE id = '$id'";

    $query = mysqli_query($conn, $query);

    if (isset($_SESSION['input_values'])) {

        $name = $_SESSION['input_values']['name'];
        $email = $_SESSION['input_values']['email'];
        $priv = $_SESSION['input_values']['priv'];

    } else if (mysqli_num_rows($query) == 1) {

        $user = mysqli_fetch_assoc($query);
        $name = $user['name'];
        $email = $user['email'];
        $priv = $user['priv'];

    } else {
        header('location: ../../users.php');
        exit;
    }
} else {
    header('location: ../../../');
    exit;
}

// اذا كان هناك اخطاء قم بجمعها في اراي
$err_bool = false;
if (isset($_SESSION['errors'])) {
    $err_bool = true;
    $err = $_SESSION['errors'];
}
?>
    <!doctype html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="../../../style/bootstrap.min.css">
        <link rel="stylesheet" href="../../../style/style.css">
        <title>Document</title>
    </head>
    <body>

    <div class="my-cont mt-5">
        <form method="post" action="../../functions/users/edit_user.php">

            <?php if ($err_bool && isset($err['main'])) : ?>
                <div class="alert alert-danger" role="alert">
                    <!-- اذا لم يكن هناك خطا في ال sql اذا اهناك خطا في ال input -->
                    <?= $err['main'] ?>
                </div>
            <?php endif; ?>

            <div class="mb-3">
                <label for="name" class="form-label">Name user</label>
                <input name="name" type="text" class="form-control" id="name" value="<?= $name ?? '' ?>" />
            </div>

            <?php if ($err_bool && isset($err['name'])) : ?>
                <div class="alert alert-danger" role="alert">
                    <?= $err['name'] ?>
                </div>
            <?php endif; ?>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input name="email" type="email" class="form-control" id="email"  value="<?= $email ?? '' ?>" />
            </div>

            <?php if ($err_bool && isset($err['email'])) : ?>
                <div class="alert alert-danger" role="alert">
                    <?= $err['email'] ?>
                </div>
            <?php endif; ?>

            <label for="priv" class="form-label">Privilege</label>
            <select id="priv" name="priv" class="form-select mb-3" aria-label="Default select example">
                <option <?= $priv != 0 ?: 'selected' ?> value="0">User</option>
                <option <?= $priv != 1 ?: 'selected' ?> value="1">Admin</option>
            </select>

            <button name="id" value="<?= $id ?>" type="submit" class="btn btn-primary">Submit</button>
            <a href="../../users.php" class="btn btn-secondary">Back</a>
        </form>
    </div>

    </body>
    </html>
<?php
unset($_SESSION['errors']);
unset($_SESSION['input_values']);
