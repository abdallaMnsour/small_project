<?php
require_once 'functions/connect.php';
$cat = null;
session_start();
if (isset($_SESSION['input_values'])) {
    $name = $_SESSION['input_values']['name'];
    $desc = $_SESSION['input_values']['desc'];
    $cat = $_SESSION['input_values']['cat'];
    $salary = $_SESSION['input_values']['salary'];
}
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
    <link rel="stylesheet" href="../style/style.css">
    <link rel="stylesheet" href="../style/bootstrap.min.css">
    <title>Document</title>
</head>
<body>
<div class="my-cont mt-5">


    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">All product</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Add product</button>
        </li>
    </ul>
    <div class="tab-content" id="pills-tabContent">


        <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab" tabindex="0">

            <table class="table table-light table-hover">
                <tr>
                    <th>id</th>
                    <th>name</th>
                    <th>price</th>
                    <th>description</th>
                    <th>category</th>
                    <th>control</th>
                </tr>
                <?php
                    $query = "SELECT * FROM products";
                    $query = mysqli_query($conn, $query);

                    while ($product = mysqli_fetch_assoc($query)) :
                        $cat = "SELECT * FROM categories WHERE id = '{$product['category_id']}'";
                        $cat = mysqli_query($conn, $cat);
                        $cat = mysqli_fetch_assoc($cat);
                ?>
                    <tr>
                        <td><?= $product['id'] ?></td>
                        <td><?= $product['name'] ?></td>
                        <td><?= $product['salary'] ?></td>
                        <td><?= $product['description'] ?></td>
                        <td><?= $cat['name'] ?></td>
                        <td class="d-flex btn-group">
                            <a href="views/products/update.php?id=<?= $product['id'] ?>" class="btn btn-primary">Update</a>
                            <a href="functions/products/delete_product.php?id=<?= $product['id'] ?>" class="btn btn-danger">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </table>
        </div>



        <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab" tabindex="0">
            <form method="post" action="functions/products/add_product.php">
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

                <select name="category" class="form-select mb-3" aria-label="Default select example">
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

                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
    <a href="../" class="btn btn-primary">Back</a>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>

<?php
unset($_SESSION['errors']);