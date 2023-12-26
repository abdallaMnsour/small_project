<?php
include 'includes/header.php';
if (!$user_bool) {
    header('location: index.php');
    exit;
}
?>
hello mr <?= $user['name'] ?>
<?php
include 'includes/footer.php';
?>