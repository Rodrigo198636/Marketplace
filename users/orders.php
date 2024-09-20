<?php require "../includes/header.php"; ?>
<?php require "../config/config.php"; ?>

<?php


    if (!isset($_SESSION['username'])) {
        header("location: " . APPURL . "");
        }
    
        if(isset($_GET['id'])) {
            $id = $_GET['id'];

            if($id !== $_SESSION['user_id']) {
            header("location: ".APPURL."");    
            }    
        }

            
        $select = $conn->query("SELECT * FROM ordenes WHERE user_id='$_SESSION[user_id]'");
        $select->execute();

        $ordenes = $select->fetchAll(PDO::FETCH_OBJ);

?>
    <div class="row mt-5" style="margin-bottom: 321px">
        <div class="col">
            <?php if(count($ordenes) >0) : ?>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-4 d-inline">Ordenes</h5>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">N°</th>
                                <th scope="col">Usuario</th>
                                <th scope="col">Email</th>
                                <th scope="col">Nombre</th>
                                <th scope="col">Apellido</th>
                                <th scope="col">Estado</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php foreach ($ordenes as $orden) : ?>
                                <tr>
                                    <td><?php echo $orden->id; ?></td>
                                    <td><?php echo $orden->username; ?></td>
                                    <td><?php echo $orden->email; ?></td>
                                    <td><?php echo $orden->fname; ?></td>
                                    <td><?php echo $orden->lname; ?></td>
                                    <td><?php echo 'Finalizado'; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php else :?>
                <div class="alert alert-success text-white bg-success">No hay Ordenes realizadas</div>
            <?php endif;?>
        </div>
    </div>
<?php require "../includes/footer.php"; ?>