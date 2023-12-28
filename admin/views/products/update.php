<?php

require_once '../../functions/connect.php';

session_start();

if (isset($_SESSION['user_login']) && $_SESSION['user_login']['priv'] == 1 && isset($_GET['id'])) {

    $id = $_GET['id'];

    $query = "SELECT * FROM products WHERE id = '$id'";

    $query = mysqli_query($conn, $query);

    if (isset($_SESSION['input_values'])) {

        $name = $_SESSION['input_values']['name'];
        $desc = $_SESSION['input_values']['desc'];
        $cat = $_SESSION['input_values']['cat'];
        $salary = $_SESSION['input_values']['salary'];

    } else if (mysqli_num_rows($query) == 1) {

        $product = mysqli_fetch_assoc($query);
        $name = $product['name'];
        $desc = $product['description'];
        $cat = $product['category_id'];
        $salary = $product['salary'];

    } else {
        header('location: ../../products.php');
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
    <form method="post" action="../../functions/products/edit_product.php">
        <?php if ($err_bool && isset($err['main'])) : ?>
            <div class="alert alert-danger" role="alert">
                <!-- اذا لم يكن هناك خطا في ال sql اذا اهناك خطا في ال input -->
                <?= $err['main'] ?>
            </div>
        <?php endif; ?>
        <div class="mb-3">
            <label for="name" class="form-label">Name product</label>
            <input name="name" type="text" class="form-control" id="name" value="<?= $name ?? '' ?>" />
        </div>

        <?php if ($err_bool && isset($err['name'])) : ?>
            <div class="alert alert-danger" role="alert">
                <?= $err['name'] ?>
            </div>
        <?php endif; ?>

        <div class="mb-3">
            <label for="salary" class="form-label">Salary</label>
            <input name="salary" type="number" class="form-control" id="salary"  value="<?= $salary ?? '' ?>" />
        </div>

        <?php if ($err_bool && isset($err['salary'])) : ?>
            <div class="alert alert-danger" role="alert">
                <?= $err['salary'] ?>
            </div>
        <?php endif; ?>

        <label for="cat" class="form-label">Category</label>
        <select id="cat" name="category" class="form-select mb-3" aria-label="Default select example">
            <?php
            $query = mysqli_query($conn, "SELECT * FROM categories");
            while ($category = mysqli_fetch_assoc($query)) :
                ?>
                <option <?= $cat == $category['id'] ? 'selected' : '' ?> value="<?= $category['id'] ?>"><?= $category['name'] ?></option>
            <?php endwhile; ?>
        </select>

        <?php if ($err_bool && isset($err['cat'])) : ?>
            <div class="alert alert-danger" role="alert">
                <?= $err['cat'] ?>
            </div>
        <?php endif; ?>

        <div class="form-floating mb-3">
            <textarea name="description" class="form-control" placeholder="Leave a description here" id="desc" style="height: 150px"><?= $desc ?? '' ?></textarea>
            <label for="desc">Description</label>
        </div>

        <?php if ($err_bool && isset($err['desc'])) : ?>
            <div class="alert alert-danger" role="alert">
                <?= $err['desc'] ?>
            </div>
        <?php endif; ?>

        <button name="id" value="<?= $id ?>" type="submit" class="btn btn-primary">Submit</button>
        <a href="../../products.php" class="btn btn-secondary">Back</a>
    </form>
</div>

</body>
</html>
<?php
unset($_SESSION['errors']);
unset($_SESSION['input_values']);
