<?php
session_start();
$err_bool = false;
if (isset($_SESSION['errors'])) {
    $err_bool = true;
    $err = $_SESSION['errors'];
}

if (isset($_SESSION['person'])) {
    $name = $_SESSION['person']['name'];
    $email = $_SESSION['person']['email'];
    $password = $_SESSION['person']['password'];
    $remember = $_SESSION['person']['remember'];
}

?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
<link rel="stylesheet" href="../style/style.css" />

<form action="../functions/users/register.php" method="post" class="login-page">
    <?php if ($err_bool && (isset($err['sql']) || isset($err['input_error']))) : ?>
    <div class="alert alert-danger" role="alert">
        <?= $err['sql'] ?? $err['input_error'] ?>
    </div>
    <?php endif; ?>
    <div class="mb-3">
        <label for="name" class="form-label">Your name</label>
        <input name="name" type="text" class="form-control" id="name" value="<?= $name ?? '' ?>" />
    </div>
    <?php if ($err_bool && isset($err['name'])) : ?>
        <div class="alert alert-danger" role="alert">
            <?= $err['name'] ?>
        </div>
    <?php endif; ?>
    <div class="mb-3">
        <label for="email" class="form-label">Email address</label>
        <input name="email" type="email" class="form-control" id="email" value="<?= $email ?? '' ?>" />
    </div>
    <?php if ($err_bool && isset($err['email'])) : ?>
        <div class="alert alert-danger" role="alert">
            <?= $err['email'] ?>
        </div>
    <?php endif; ?>
    <div class="mb-3">
        <label for="pass" class="form-label">Password</label>
        <input name="password" type="password" class="form-control" id="pass" value="<?= $password ?? '' ?>" />
    </div>
    <?php if ($err_bool && isset($err['password'])) : ?>
        <div class="alert alert-danger" role="alert">
            <?= $err['password'] ?>
        </div>
    <?php endif; ?>
    <div class="mb-3 form-check">
        <input name="remember" type="checkbox" class="form-check-input" id="remember" value="yes" />
        <label class="form-check-label" for="remember">Remember me</label>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>

<?php
unset($_SESSION['errors']);
