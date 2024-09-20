<?php require "../layouts/header.php"; ?>
<?php require "../../config/config.php"; ?>

<?php


  if (!isset($_SESSION['adminname'])){
    header("location: ".ADMINURL."/admins/login-admins.php");
  }
  
  $select = $conn->query("SELECT * FROM admins");
  $select->execute();

  $admins = $select->fetchAll(PDO::FETCH_OBJ);

?>
  <div class="row">
    <div class="col">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title mb-4 d-inline">Administradores</h5>
          <a href="<?php echo ADMINURL; ?>/admins/create-admins.php" class="btn btn-primary mb-4 text-center float-right">Crear Administrador</a>
          <table class="table">
            <thead>
              <tr>
                <th scope="col">adminname</th>
                <th scope="col">email</th>
              </tr>
            </thead>
            <tbody>
              
            <?php foreach($admins as $admin) : ?>
              <tr>                
                <td><?php echo $admin->adminname; ?></td>
                <td><?php echo $admin->email; ?></td>

              </tr>
            <?php endforeach; ?>  

            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>


<?php require "../layouts/footer.php"; ?>