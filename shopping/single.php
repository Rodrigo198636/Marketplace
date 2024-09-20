<?php
require "../includes/header.php";
require "../config/config.php";




        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {


            $prod_id = $_POST['prod_id'];
            $prod_nombre = $_POST['prod_nombre'];
            $prod_imagen = $_POST['prod_imagen'];
            $prod_precio = $_POST['prod_precio'];
            $prod_cantidad = $_POST['prod_cantidad'];
            $prod_archivo = $_POST['prod_archivo'];
            $user_id = $_POST['user_id'];

            try {
                // Verificar si el producto ya está en el carrito
                $check = $conn->prepare("SELECT * FROM carrito WHERE prod_id = :prod_id AND user_id = :user_id");
                $check->execute([
                    ':prod_id' => $prod_id,
                    ':user_id' => $user_id
                ]);



                if ($check->rowCount() == 0) {
                    // Insertar el producto en el carrito
                    $insert = $conn->prepare("INSERT INTO carrito (prod_id, prod_nombre, prod_imagen, prod_precio, prod_archivo, prod_cantidad, user_id) VALUES (:prod_id, :prod_nombre, :prod_imagen, :prod_precio, :prod_archivo, :prod_cantidad, :user_id)");
                    $insert->execute([
                        ':prod_id' => $prod_id,
                        ':prod_nombre' => $prod_nombre,
                        ':prod_imagen' => $prod_imagen,
                        ':prod_precio' => $prod_precio,
                        ':prod_archivo' => $prod_archivo,
                        ':prod_cantidad' => $prod_cantidad,
                        ':user_id' => $user_id
                    ]);
                    echo json_encode(['status' => 'success', 'message' => 'Producto agregado al carrito']);
                } else {
                    echo json_encode(['status' => 'info', 'message' => 'El producto ya está en el carrito']);
                }
            } catch (PDOException $e) {
                echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
            }
            exit;
        }

        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            if (isset($_SESSION['user_id'])) {
                $select = $conn->prepare("SELECT * FROM carrito WHERE prod_id = :prod_id AND user_id = :user_id");
                $select->execute([
                    ':prod_id' => $id,
                    ':user_id' => $_SESSION['user_id']
                ]);
            }

            $row = $conn->prepare("SELECT * FROM producto WHERE estado = 1 AND id = :id");
            $row->execute([':id' => $id]);
            $product = $row->fetch(PDO::FETCH_OBJ);

            if (!$product) {
                echo "404";
                exit;
            }
        } else {
            header("location: " . APPURL . "/404.PHP");
        }
?>


<div class="row d-flex justify-content-center mt-4">
    <div class="col-md-10">
        <div class="card">
            <div class="row">
                <div class="col-md-6">
                    <div class="imagen p-3">
                        <div class="text-center p-4">
                            <img id="main-image" src="<?php echo IMGURL; ?>/<?php echo $product->imagen; ?>" width="250" />
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="product p-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <a href="<?php echo APPURL; ?>" class="ml-1 btn btn-primary">
                                    <i class="fa fa-long-arrow-left"></i> volver
                                </a>
                            </div>
                            <i class="fa fa-shopping-cart text-muted"></i>
                        </div>
                        <div class="mt-4 mb-3">
                            <h5 class="text-uppercase"><?php echo $product->nombre; ?></h5>
                            <div class="precio d-flex flex-row align-items-center">
                                <span class="act-price">(U$S<?php echo $product->precio; ?>)</span>
                            </div>
                        </div>
                        <p class="about"><?php echo $product->descripcion; ?></p>
                        <form method="POST" id="form-data">
                            <input type="hidden" name="prod_id" value="<?php echo $product->id; ?>" />
                            <input type="hidden" name="prod_nombre" value="<?php echo $product->nombre; ?>" />
                            <input type="hidden" name="prod_imagen" value="<?php echo $product->imagen; ?>" />
                            <input type="hidden" name="prod_precio" value="<?php echo $product->precio; ?>" />
                            <input type="hidden" name="prod_cantidad" value="1" />
                            <input type="hidden" name="prod_archivo" value="<?php echo $product->archivo; ?>" />
                            <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>" />
                            <div class="cart mt-4 align-items-center">
                                <?php if (isset($_SESSION['user_id'])) : ?>
                                    <?php if ($select->rowCount() > 0) : ?>
                                        <button id="submit" name="submit" type="submit" disabled class="btn btn-primary text-uppercase mr-2 px-4">
                                            <i class="fas fa-shopping-cart"></i> Agregado al carrito
                                        </button>
                                    <?php else : ?>
                                        <button id="submit" name="submit" type="submit" class="btn btn-primary text-uppercase mr-2 px-4">
                                            <i class="fas fa-shopping-cart"></i> Agregar al carrito
                                        </button>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require "../includes/footer.php"; ?>

<script>
    $(document).ready(function() {
        $('#form-data').on('submit', function(e) {
            e.preventDefault();

            var formdata = $(this).serialize();
            console.log(formdata);
            $.ajax({
                url: 'cart.php',
                type: 'POST',
                data: formdata,
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        console.log(response);
                        alert(response.message);
                        $("#submit").html("<i class='fas fa-shopping-cart'></i> Agregado al carrito").prop("disabled", true);
                    } else {
                        alert(response.message);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log("Error:", errorThrown); // Verifica los detalles del error.
                    alert('Hubo un error al agregar el producto al carrito');
                }
            });
        });
    });
</script>