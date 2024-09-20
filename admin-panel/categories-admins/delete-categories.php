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

        $images = $select->fetch(PDO::FETCH_OBJ);

        unlink("images/".$images->imagen."");

        $delete = $conn->query("DELETE FROM categorias WHERE id='$id'");
        $delete->execute();
        header("location: ".ADMINURL."/categories-admins/show-categories.php ");

    } else {
        header("location: http://localhost/bookstore/404.php");
    }

?>