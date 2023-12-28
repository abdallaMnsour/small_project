<?php
include 'includes/header.php';
?>

<?php if (isset($_SESSION['error_cart'])) : ?>
    <div class="alert alert-danger alert-dismissible fade show m-5" role="alert">
        <?= $_SESSION['error_cart'] ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>
    <div class="my-cont d-flex justify-content-around">

        <?php
            $query = mysqli_query($conn, "SELECT * FROM products");
            while ($product = mysqli_fetch_assoc($query)) :
        ?>

            <div class="card" style="width: 18rem;">
                <img src="images/products/test.png" class="card-img-top" alt="product">
                <div class="card-body">
                    <h5 class="card-title"><?= htmlspecialchars($product['name']) ?></h5>
                    <p class="card-text"><?= htmlspecialchars($product['description']) ?></p>
                    <p><b><?= htmlspecialchars($product['salary']) ?></b></p>
                    <a href="functions/cards/add_card.php?product=<?= $product['id'] ?>" class="btn btn-primary">Add to card</a>
                </div>
            </div>

        <?php endwhile; ?>
    </div>
<?php
include 'includes/footer.php';
unset($_SESSION['error_cart']);
?>