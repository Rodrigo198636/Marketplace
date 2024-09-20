<?php require "../layouts/header.php"; ?>
<?php require "../../config/config.php"; ?>

<?php
  
    if (!isset($_SESSION['adminname'])){
        header("location: ".ADMINURL."/admins/login-admins.php");
      }
      

    if(isset($_GET['id']) AND isset($_GET['estado'])) {
        $id = $_GET['id'];
        $estado = $_GET['estado'];

        if ($estado > 0){

            $update =$conn->prepare("UPDATE producto SET estado = 0 WHERE ID ='$id'");
            $update->execute();

            header("location: ".ADMINURL."/products-admins/show-products.php");
        } else {
            $update =$conn->prepare("UPDATE producto SET estado = 1 WHERE ID ='$id'");
            $update->execute();

            header("location: ".ADMINURL."/products-admins/show-products.php");
        }
    }
?>
