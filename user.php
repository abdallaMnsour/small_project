<?php
include 'includes/header.php';
if (!$user_bool) {
    header('location: index.php');
    exit;
}
?>


<div class="m-auto" style="max-width: 500px">
    <p><b>name : </b><?= htmlspecialchars($user['name']) ?></p>
    <p><b>name : </b><?= htmlspecialchars($user['email']) ?></p>
    <p><b>name : </b><?= $user['priv'] == 1 ? 'admin' : 'user' ?></p>
    <p>
        <a href="#" class="btn btn-primary">update your account</a>
    </p>
</div>



<?php
include 'includes/footer.php';
?>