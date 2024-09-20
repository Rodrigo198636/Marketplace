<?php require "../includes/header.php"; ?>
<?php require "../config/config.php"; ?>
<?php


if (!isset($_SESSION['username'])){
  header("location: ".APPURL."");
}

$products = $conn->query("SELECT * FROM carrito WHERE user_id = '$_SESSION[user_id]'");
$products->execute();

$allProducts = $products->fetchAll(PDO::FETCH_OBJ);

if(isset($_POST['submit'])) {

  $price =$_POST['price'];

  $_SESSION['price'] = $price;

  header("location: checkout.php");
}

?>

<div class="container">
  <div class="row d-flex justify-content-center align-items-center h-100 mt-5 mt-5">
    <div class="col-12">
      <div class="card card-registration card-registration-2" style="border-radius: 15px;">
        <div class="card-body p-0">
          <div class="row g-0">
            <div class="col-lg-8">
              <div class="p-5">
                <div class="d-flex justify-content-between align-items-center mb-5">
                  <h1 class="fw-bold mb-0 text-black">Carrito de Compra</h1>

                </div>


                <table class="table" height="190">
                  <thead>
                    <tr>
                      <th scope="col">Imagen</th>
                      <th scope="col">Nombre</th>
                      <th scope="col">Precio</th>
                      <th scope="col">Cantidad</th>
                      <th scope="col">Importe</th>
                      <th scope="col">Actualizar</th>
                      <th scope="col"><button class="delete-all btn btn-danger text-white">Limpiar</button></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if (count($allProducts) > 0) : ?>
                      <?php foreach ($allProducts as $product) : ?>
                        <tr class="mb-4">
                          <td><img width="100" height="100"
                              src="<?php echo IMGURL; ?>/<?php echo $product->prod_imagen; ?>"
                              class="img-fluid rounded-3" alt="Cotton T-shirt">
                          </td>
                          <td><?php echo $product->prod_nombre; ?></td>
                          <td class="prod_precio"><?php echo $product->prod_precio; ?></td>
                          <td><input id="form1" min="1" name="quantity" value="<?php echo $product->prod_cantidad; ?>" type="number"
                              class="form-control form-control-sm prod_cantidad" /></td>
                          <td class="total_price">U$S<?php echo $product->prod_precio * $product->prod_cantidad; ?></td>
                          <td><button value="<?php echo $product->id; ?>" class="btn-update btn btn-warning text-white"><i class="fas fa-pen"></i> </button></td>

                          <td><button value="<?php echo $product->id; ?>" class="btn btn-danger text-white btn-delete"><i class="fas fa-trash-alt"></i> </button></td>
                        </tr>
                      <?php endforeach; ?>
                    <?php else : ?>
                      <div class="alert alert-danger bg-danger text-white">No hay Productos en el Carrito</div>
                    <?php endif; ?>
                  </tbody>
                </table>
                <a href="<?php echo APPURL; ?>" class="btn btn-success text-white"><i class="fas fa-arrow-left"></i> Continuar Comprando</a>
              </div>
            </div>
            <div class="col-lg-4 bg-grey">
              <div class="p-5">
                <h3 class="fw-bold mb-5 mt-2 pt-1">Cantidad</h3>
                <hr class="my-4">
                <form method="POST" action="cart.php">
                  <div class="d-flex justify-content-between mb-5">
                    <h5 class="text-uppercase">Importe</h5>
                    <h5 class="full_price"></h5>
                    <input class="inp_price" name="price" type="hidden">
                  </div>

                  <button type="submit" name="submit" class=" checkout btn btn-dark btn-block btn-lg"
                    data-mdb-ripple-color="dark">Comprar</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>

  </div>
</div>

<?php require "../includes/footer.php"; ?>

<script>
  $(document).ready(function() {
    $(document).on('change', '.prod_cantidad', function() {
      var $el = $(this).closest('tr');
      var prod_cantidad = $el.find(".prod_cantidad").val();
      var prod_precio = $el.find(".prod_precio").text();
      var total = prod_cantidad * prod_precio;
      $el.find(".total_price").text(total.toFixed(2) + 'U$S');
    });

    $(".btn-update").on('click', function() {
      var id = $(this).val();
      var prod_cantidad = $(this).closest('tr').find(".prod_cantidad").val();
      $.ajax({
        type: "POST",
        url: "update-item.php",
        data: {
          update: "update",
          id: id,
          product_amount: prod_cantidad
        },
        success: function() {
          alert("Producto Actualizado");
          location.reload(); // Recargar la página para ver cambios
        }
      });
    });

    $(".btn-delete").on('click', function() {
      var id = $(this).val();
      $.ajax({
        type: "POST",
        url: "delete-item.php",
        data: {
          delete: "delete",
          id: id
        },
        success: function() {
          alert("Producto Eliminado");
          location.reload(); // Recargar la página para ver cambios
        }
      });
    });

    $(".delete-all").on('click', function() {
      $.ajax({
        type: "POST",
        url: "delete-all-item.php",
        data: {
          delete: "delete"
        },
        success: function() {
          alert("Productos Eliminados");
          location.reload(); // Recargar la página para ver cambios
        }
      });
    });

    function fetch() {
      var sum = 0.0;
      $('.total_price').each(function() {
        sum += parseFloat($(this).text());
      });
      $(".full_price").text(sum.toFixed(2) + "$");
      $(".inp_price").val(sum);

      if($(".inp_price").val() > 0) {
        $(".checkout").show();
      } else {
        $(".checkout").hide();
      }


    }

    fetch();

    function reload() {


      $("body").load("cart.php")

    }
  })
</script>