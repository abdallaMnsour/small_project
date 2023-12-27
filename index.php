<?php
include 'includes/header.php';
?>
<div class="my-cont">

    <?php if (isset($_SESSION['error_delete'])) : ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error from backend !</strong> You have contact us quickly.<br>
            <?= $_SESSION['error_delete'] ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['error_delete_admin'])) : ?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <?= $_SESSION['error_delete_admin'] ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="card" style="width: 18rem;">
        <img src="images/products/test.png" class="card-img-top" alt="product">
        <div class="card-body">
            <h5 class="card-title">Card title</h5>
            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
            <a href="#" class="btn btn-primary">Add to card</a>
        </div>
    </div>
</div>
<?php
include 'includes/footer.php';
unset($_SESSION['error_delete']);
unset($_SESSION['error_delete_admin']);
?>