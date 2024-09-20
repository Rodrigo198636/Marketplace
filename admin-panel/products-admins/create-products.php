<?php require "../layouts/header.php"; ?>
<?php require "../../config/config.php"; ?>

<?php

  if (!isset($_SESSION['adminname'])){
    header("location: ".ADMINURL."/admins/login-admins.php");
  }


    $select = $conn->query("SELECT * FROM categorias");
    $select->execute();

    $categories = $select->fetchAll(PDO::FETCH_OBJ);
   
   
    if (isset($_POST['submit'])) {

    if (empty($_POST['nombre']) or empty($_POST['descripcion']) or empty($_POST['precio'])or empty($_POST['categoria_id'])) {
        echo "<script>alert('uno o mas campos estan vacios');</script>";
    } else {
        $nombre = $_POST['nombre'];        
        $descripcion = $_POST['descripcion'];
        $precio = $_POST['precio'];    
        $imagen = $_FILES['imagen']['name'];
        $archivo = $_FILES['archivo']['name'];
        $categoria_id = $_POST['categoria_id'];    

        $dir_img = "images/" . basename($imagen);
        $dir_arc = "libros/" . basename($archivo);

        $insert = $conn->prepare("INSERT INTO producto (nombre,precio,descripcion, imagen, archivo, categoria_id)
            VALUES (:nombre, :precio, :descripcion, :imagen, :archivo, :categoria_id)");

        $insert->execute([
            ':nombre' => $nombre,
            ':precio' => $precio,
            ':descripcion' => $descripcion,
            ':imagen' => $imagen,
            ':archivo' => $archivo,
            ':categoria_id' => $categoria_id
        ]);

        if(move_uploaded_file($_FILES['imagen']['tmp_name'], $dir_img) AND move_uploaded_file($_FILES['archivo']['tmp_name'], $dir_arc)) {
          header("location: ".ADMINURL."/products-admins/show-products.php ");
        }

       
    }
}
?>
       <div class="row">
        <div class="col">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title mb-5 d-inline">Crear Producto</h5>
              <form method="POST" action="create-products.php" enctype="multipart/form-data">
                
                <div class="form-outline mb-4 mt-4">
                  <label>Nombre</label>

                  <input type="text" name="nombre" id="form2Example1" class="form-control" placeholder="Nombre del Producto" />
                </div>

                <div class="form-outline mb-4 mt-4">
                    <label>Precio</label>

                    <input type="text" name="precio" id="form2Example1" class="form-control" placeholder="Precio del Producto" />
                </div>

                <div class="form-group">
                    <label for="exampleFormControlTextarea1">Descripcion</label>
                    <textarea name="descripcion" placeholder="Descripcion del Producto" class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                </div>

                <div class="form-group">
                    <label for="exampleFormControlSelect1">Seleccionar Categoria</label>
                    <select name="categoria_id" class="form-control" id="exampleFormControlSelect1">
                      <option>--seleccione una categoria--</option>
                      <?php foreach($categories as $category) : ?>
                       <option value="<?php echo $category->id; ?>"><?php echo $category->nombre; ?></option>
                      <?php endforeach;?>
                    </select>
                  </div>

                <div class="form-outline mb-4 mt-4">
                    <label>Imagen</label>

                    <input type="file" name="imagen" id="form2Example1" class="form-control" placeholder="Coloque una Imagen" />
                </div>

                <div class="form-outline mb-4 mt-4">
                    <label>Archivo</label>
                    <input type="file" name="archivo" id="form2Example1" class="form-control" placeholder="Coloque un Archivo" />
                </div>

      
                <!-- Submit button -->
                <button type="submit" name="submit" class="btn btn-primary  mb-4 text-center">Crear!</button>

          
              </form>

            </div>
          </div>
        </div>
      </div>
<?php require "../layouts/footer.php"; ?>