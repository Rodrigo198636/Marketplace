<?php require "../layouts/header.php"; ?>
<?php require "../../config/config.php"; ?>

<?php

    if (!isset($_SESSION['adminname'])){
      header("location: ".ADMINURL."/admins/login-admins.php");
    }
    
   if (isset($_POST['submit'])) {

    if (empty($_POST['nombre']) or empty($_POST['descripcion'])) {
        echo "<script>alert('uno o mas campos estan vacios');</script>";
    } else {
        $nombre = $_POST['nombre'];        
        $descripcion = $_POST['descripcion'];
        $imagen = $_FILES['imagen']['name'];

        $dir = "images/" . basename($imagen);

        $insert = $conn->prepare("INSERT INTO categorias (nombre,descripcion, imagen)
            VALUES (:nombre, :descripcion, :imagen)");

        $insert->execute([
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
              <h5 class="card-title mb-5 d-inline">Crear Categorias</h5>
          <form method="POST" action="create-category.php" enctype="multipart/form-data">
                <!-- Email input -->
                <div class="form-outline mb-4 mt-4">
                <label for="exampleFormControlTextarea1">Nombre</label>
                  <input type="text" name="nombre" id="form2Example1" class="form-control" placeholder="Nombre de la Categoria" />
                 
                </div>

                <div class="form-group">
                    <label for="exampleFormControlTextarea1">Descripcion</label>
                    <textarea name="descripcion" placeholder="Descripcion de la Categoria" class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                </div>

                <div class="form-outline mb-4 mt-4">
                    <label>Imagen</label>

                    <input type="file" name="imagen" id="form2Example1" class="form-control" placeholder="image" />
                </div>

      
                <!-- Submit button -->
                <button type="submit" name="submit" class="btn btn-primary  mb-4 text-center">Crear</button>

          
              </form>

            </div>
          </div>
        </div>
      </div>
<?php require "../layouts/footer.php"; ?>