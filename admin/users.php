<?php
require_once 'functions/connect.php';
$priv = null;
session_start();
if (isset($_SESSION['input_values'])) {
    $name = $_SESSION['input_values']['name'];
    $email = $_SESSION['input_values']['email'];
    $priv = $_SESSION['input_values']['priv'];
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
                        <th>email</th>
                        <th>priv</th>
                        <th>control</th>
                    </tr>
                    <?php
                    $query = "SELECT * FROM users";
                    $query = mysqli_query($conn, $query);

                    while ($user = mysqli_fetch_assoc($query)) :
                        ?>
                        <tr>
                            <td><?= $user['id'] ?></td>
                            <td><?= $user['name'] ?></td>
                            <td><?= $user['email'] ?></td>
                            <td><?= $user['priv'] == 1 ? 'admin' : 'user'?></td>
                            <td class="d-flex btn-group">
                                <a href="views/users/update.php?id=<?= $user['id'] ?>" class="btn btn-primary">Update</a>
                                <a href="functions/users/delete_user.php?id=<?= $user['id'] ?>" class="btn btn-danger">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </table>

            </div>



            <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab" tabindex="0">
                <form method="post" action="functions/users/add_user.php">
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
                        <label for="email" class="form-label">E-mail</label>
                        <input name="email" type="text" class="form-control" id="email"  value="<?= $email ?? '' ?>" />
                    </div>

                    <?php if ($err_bool && isset($err['email'])) : ?>
                        <div class="alert alert-danger" role="alert">
                            <?= $err['email'] ?>
                        </div>
                    <?php endif; ?>

                    <label for="priv" class="mb-3">Privilege</label>
                    <select name="priv" id="priv" class="form-select mb-3" aria-label="Default select example">
                        <option <?= $priv == 0 ? 'selected' : '' ?> value="0">User</option>
                        <option <?= $priv == 1 ? 'selected' : '' ?> value="1">Admin</option>
                    </select>

                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
        <a href="../" class="btn btn-primary mt-3">Back to the site</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    </body>
    </html>

<?php
unset($_SESSION['errors']);