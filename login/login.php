<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
<link rel="stylesheet" href="../style/style.css" />

<form action="../functions/users/login.php" method="post" class="login-page">
    <div class="mb-3">
        <label for="email" class="form-label">Email address</label>
        <input name="email" type="email" class="form-control" id="email">
    </div>
    <div class="mb-3">
        <label for="pass" class="form-label">Password</label>
        <input name="password" type="password" class="form-control" id="pass">
    </div>
    <div class="mb-3 form-check">
        <input name="remember" type="checkbox" class="form-check-input" id="remember">
        <label class="form-check-label" for="remember">Remember me</label>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>