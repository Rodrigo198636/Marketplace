

<?php require "layouts/header.php"; ?>  
<?php require "../config/config.php"; ?>
<?php

  $products = $conn->query("SELECT COUNT(*) as productos_num FROM producto");
  $products->execute();
  $allProducts = $products->fetch(PDO::FETCH_OBJ);

  $categories = $conn->query("SELECT COUNT(*) as categorias_num FROM categorias");
  $categories->execute();
  $allCategories = $categories->fetch(PDO::FETCH_OBJ);

  $admins = $conn->query("SELECT COUNT(*) as admins_num FROM admins");
  $admins->execute();
  $allAdmins = $admins->fetch(PDO::FETCH_OBJ);

?>
            
      <div class="row">
        <div class="col-md-4">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Productos</h5>
              <!-- <h6 class="card-subtitle mb-2 text-muted">Bootstrap 4.0.0 Snippet by pradeep330</h6> -->
              <p class="card-text">Numero de Productos: <?php echo $allProducts->productos_num; ?></p>
             
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Categorias</h5>
              
              <p class="card-text">Numero de Categorias: <?php echo $allCategories->categorias_num; ?></p>
              
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Administradores</h5>
              
              <p class="card-text">Numero de Administradores: <?php echo $allAdmins->admins_num; ?></p>
              
            </div>
          </div>
        </div>
      </div>
  
          
<?php require "layouts/footer.php"; ?>  
