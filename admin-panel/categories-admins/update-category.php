<?php require "../layouts/header.php"; ?>
<?php require "../../config/config.php"; ?>

<?php

    if (!isset($_SESSION['adminname'])){
      header("location: ".ADMINURL."/admins/login-admins.php");
    }
  
    

  if(isset($_GET['id'])) {
    $id = $_GET['id'];

    $select = $conn->query("SELECT * FROM categorias WHERE id='$id'");
    $select->execute();

    $categories = $select->fetch(PDO::FETCH_OBJ);

    
    if (empty($_POST['nombre']) or empty($_POST['descripcion'])) {
      echo "<script>alert('uno o mas campos estan vacios');</script>";
    } else {

        unlink("images/".$categories->imagen."");

        $nombre = $_POST['nombre'];        
        $descripcion = $_POST['descripcion'];
        $imagen = $_FILES['imagen']['name'];

        $dir = "images/" . basename($imagen);

        $update = $conn->prepare("UPDATE categorias SET nombre = :nombre, descripcion = :descripcion, imagen = :imagen
        WHERE id='$id'");

        $update->execute([
            ':nombre' => $nombre,
            ':descripcion' => $descripcion,
            ':imagen' => $imagen
        ]);

        if(move_uploaded_file($_FILES['imagen']['tmp_name'], $dir)) {
          header("location: ".ADMINURL."/categories-admins/show-categories.php ");
        }

      
    }

  }
?>
       <div class="row">
        <div class="col">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title mb-5 d-inline">Actualizar Categorias</h5>
          <form method="POST" action="update-category.php?id=<?php echo $id; ?>" enctype="multipart/form-data">
                <!-- Email input -->
                <div class="form-outline mb-4 mt-4">
                <label for="exampleFormControlTextarea1">Nombre</label>
                  <input type="text" name="nombre" value="<?php echo $categories->nombre; ?>" id="form2Example1" class="form-control" placeholder="name" />
                 
                </div>

                <div class="form-group">
                    <label for="exampleFormControlTextarea1">Descripcion</label>
                    <textarea name="descripcion"  placeholder="Descripcion de la Categoria" class="form-control" id="exampleFormControlTextarea1" rows="3">
                      <?php echo $categories->descripcion; ?></textarea>
                </div>

                <div class="form-outline mb-4 mt-4">
                    <label>Imagen</label><br>
                    <img src="images/<?php echo $categories->imagen; ?>" alt="img" width="200" height="200">
                    <input type="file" name="imagen" id="form2Example1" class="form-control" placeholder="image" />
                </div>

      
                <!-- Submit button -->
                <button type="submit" name="submit" class="btn btn-primary  mb-4 text-center">update</button>

          
              </form>

            </div>
          </div>
        </div>
      </div>
<?php require "../layouts/footer.php"; ?>