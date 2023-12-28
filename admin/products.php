<?php
require_once 'functions/connect.php';
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
            <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Add product</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Delete product</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill" data-bs-target="#pills-contact" type="button" role="tab" aria-controls="pills-contact" aria-selected="false">Update product</button>
        </li>
    </ul>
    <div class="tab-content" id="pills-tabContent">


        <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab" tabindex="0">
            <form>
                <div class="mb-3">
                    <label for="name" class="form-label">Name product</label>
                    <input name="name" type="text" class="form-control" id="name">
                </div>

                <div class="mb-3">
                    <label for="salary" class="form-label">Salary</label>
                    <input name="salary" type="text" class="form-control" id="salary">
                </div>

                <select class="form-select mb-3" aria-label="Default select example">
                    <?php
                        $query = mysqli_query($conn, "SELECT * FROM categories");
                        while ($category = mysqli_fetch_assoc($query)) :
                    ?>
                      <option value="<?= $category['id'] ?>"><?= $category['name'] ?></option>
                    <?php endwhile; ?>
                </select>

                <div class="form-floating mb-3">
                    <textarea class="form-control" placeholder="Leave a description here" id="desc" style="height: 150px"></textarea>
                    <label for="desc">Description</label>
                </div>



                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>



        <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab" tabindex="0">delete</div>
        <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab" tabindex="0">update</div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>