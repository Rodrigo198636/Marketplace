<?php require "../includes/header.php"; ?>
<?php require "../config/config.php"; ?>

<?php

    $select = $conn->query("SELECT * FROM categorias");
    $select->execute();

    $categories = $select->fetchAll(PDO::FETCH_OBJ);

?>
<div class="row mt-5">

    <?php foreach ($categories as $category): ?>

        <div class="col-lg-4 col-md-6 col-sm-10 offset-md-0 offset-sm-1">
            <div class="card">
                <img height="213px" class="card-img-top" src="http://localhost/bookstore/admin-panel/categories-admins/images/<?php echo $category->imagen; ?>">
                <div class="card-body">
                    <h5><b><?php echo $category->nombre; ?></b> </h5>
                    <div class="d-flex flex-row my-2">
                        <div class="text-muted"><?php echo $category->descripcion; ?></div>

                    </div>
                    <a href="<?php echo APPURL; ?>/categories/single-category.php?id=<?php echo $category->id; ?>" class="btn btn-primary w-100 rounded my-2">Explora los Productos</a>

                </div>
            </div>
        </div>
        <br>
    <?php endforeach; ?>
</div>

<?php require "../includes/footer.php"; ?>