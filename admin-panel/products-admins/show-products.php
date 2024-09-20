<?php require "../layouts/header.php"; ?>
<?php require "../../config/config.php"; ?>

<?php
  if (!isset($_SESSION['adminname'])){
    header("location: ".ADMINURL."/admins/login-admins.php");
  }

$select = $conn->query("SELECT * FROM producto");
$select->execute();

$producto = $select->fetchAll(PDO::FETCH_OBJ);
?>
<div class="row">
  <div class="col">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title mb-4 d-inline">Products</h5>
        <a href="<?php echo ADMINURL; ?>/products-admins/create-products.php" class="btn btn-primary mb-4 text-center float-right">Create Products</a>

        <table class="table">
          <thead>
            <tr>
              <th scope="col">Producto</th>
              <th scope="col">Precio</th>
              <th scope="col">Estado</th>
              <th scope="col">Eliminar</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($producto as $product) : ?>
              <tr>
                <td><?php echo $product->nombre; ?></td>
                <td>U$S <?php echo $product->precio; ?></td>
                <?php if ($product->estado > 0) : ?>
                  <td><a href="<?php echo ADMINURL; ?>/products-admins/status.php?id=<?php echo $product->id; ?>&estado=<?php echo $product->estado; ?>" class="btn btn-danger  text-center">No verificado</a></td>
                <?php else : ?>
                  <td><a href="<?php echo ADMINURL; ?>/products-admins/status.php?id=<?php echo $product->id; ?>&estado=<?php echo $product->estado; ?>" class="btn btn-success  text-center ">Verificado</a></td>
                <?php endif; ?>
                <td><a href="<?php echo ADMINURL; ?>/products-admins/delete-products.php?id=<?php echo $product->id; ?>" class="btn btn-danger  text-center ">Eliminar</a></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<?php require "../layouts/footer.php"; ?>