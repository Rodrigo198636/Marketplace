<?php require "../layouts/header.php"; ?>
<?php require "../../config/config.php"; ?>

<?php

  if (!isset($_SESSION['adminname'])){
    header("location: ".ADMINURL."/admins/login-admins.php");
  }


  $select = $conn->query("SELECT * FROM categorias");
  $select->execute();

  $categories = $select->fetchAll(PDO::FETCH_OBJ);

?>

          <div class="row">
        <div class="col">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title mb-4 d-inline">Categories</h5>
             <a  href="<?php echo ADMINURL; ?>/categories-admins/create-category.php" class="btn btn-primary mb-4 text-center float-right">Crear Categorias</a>
              <table class="table">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Actualizar</th>
                    <th scope="col">Eliminar</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach($categories as $category) : ?>
                    <tr>
                      <th scope="row"><?php echo $category->id; ?></th>
                      <td><?php echo $category->nombre; ?></td>
                      <td><a  href="<?php echo ADMINURL; ?>/categories-admins/update-category.php?id=<?php echo $category->id; ?>" class="btn btn-warning text-white text-center ">Actualizar </a></td>
                      <td><a href="<?php echo ADMINURL; ?>/categories-admins/delete-categories.php?id=<?php echo $category->id; ?>" class="btn btn-danger  text-center ">Eliminar</a></td>
                    </tr>
                  <?php endforeach;?>
                 
                </tbody>
              </table> 
            </div>
          </div>
        </div>
      </div>


<?php require "../layouts/footer.php"; ?>