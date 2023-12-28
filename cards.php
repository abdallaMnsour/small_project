<?php
include 'includes/header.php';
if (!$user_bool) {
    header('location: index.php');
    exit;
}
?>
<div class="my-cont">
    <?php
        $query = "SELECT * FROM cards WHERE user_id = '{$user['id']}'";
        $query = mysqli_query($conn, $query);
        while ($card = mysqli_fetch_assoc($query)) :
            $products = mysqli_query($conn, "SELECT * FROM products WHERE id = '{$card['product_id']}'");
            $product = mysqli_fetch_assoc($products);
    ?>
        <div class="card mb-3" style="max-width: 540px;">
            <div class="row g-0">
                <div class="col-md-4">
                    <img src="images/products/test.png" class="img-fluid rounded-start" alt="...">
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <h5 class="card-title"><?= $product['name'] ?></h5>
                        <p class="card-text"><?= $product['description'] ?></p>
                        <p class="card-text"><small class="text-body-secondary"><?= $product['salary'] ?></small></p>
                        <a href="functions/cards/delete.php?id=<?= $product['id'] ?>" class="btn btn-primary">delete</a>
                    </div>
                </div>
            </div>
        </div>
    <?php endwhile; ?>
</div>
<?php
include 'includes/footer.php';
?>