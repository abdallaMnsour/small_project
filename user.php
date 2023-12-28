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
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
            Update your account
        </button>
    </p>

    <?php if (isset($_SESSION['error'])) : ?>
        <div class="alert alert-danger" role="alert">
            <?= $_SESSION['error'] ?>
        </div>
    <?php endif; ?>
</div>





    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">New message</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="functions/users/update.php" method="post">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="col-form-label">Your name :</label>
                            <input name="name" type="text" class="form-control" id="name" />
                        </div>
                        <div class="mb-3">
                            <label for="email" class="col-form-label">Your email :</label>
                            <input name="email" type="email" class="form-control" id="email" />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update account</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


<?php
include 'includes/footer.php';
unset($_SESSION['error'])
?>