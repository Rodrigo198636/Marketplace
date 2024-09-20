<?php require "../includes/header.php"; ?>
<?php require "../config/config.php"; ?>


<?php

    if( $_SERVER ['REQUEST_METHOD']=='GET' && realpath(__FILE__) == realpath($_SERVER['SCRIPT_FILENAME'])){

        header('HTTP/1.0 403 Forbidden', TRUE, 403);

        die( header('location: '.APPURL.''));
        }

        if (!isset($_SESSION['username'])){
            header("location: ".APPURL."");
          }

        if(isset($_POST['update'])) {
            $id = $_POST['id'];
            $pro_amount = $_POST['prod_cantidad'];

            $update = $conn->prepare("UPDATE carrito SET prod_cantidad = $prod_cantidad WHERE id = $id'");
            $update->execute();


    }

?>

<?php require "../includes/footer.php"; ?>