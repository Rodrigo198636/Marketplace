<?php require "includes/header.php"; ?>
<?php require "config/config.php"; ?>

<?php
    
    if (!isset($_SERVER['HTTP_REFERER'])) {
        //dirige a la rua deseada
        header('location: index.php');
        exit;
      }
   

    $select = $conn->query("SELECT * FROM carrito WHERE user_id='$_SESSION[user_id]'");
    $select->execute(); 
    $allProducts = $select->fetchAll(PDO::FETCH_OBJ);

        


      
 

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'src/Exception.php';
require 'src/PHPMailer.php';
require 'src/SMTP.php';

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings                   //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'marketplace198638@gmail.com';                     //SMTP username
    $mail->Password   = '';                               //SMTP password
    /* $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; */            //Enable implicit TLS encryption
    $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Correo del Marketplace
    $mail->setFrom('marketplace198638@gmail.com', 'Bookstore'); 
    //Correo del comprador
    $mail->addAddress($_SESSION['email'], 'User');    


    foreach($allProdcuts as $products) {
        $path  = 'admin-panel/products-admins/books';
        //$file = $products->pro_file;

        for($i=0; $i < count($allProdcuts); $i++) {
          
            $mail->addAttachment($path . "/" . $products->prod_archivo);        

        }
    }

    $select = $conn->query("DELETE FROM carrito WHERE user_id='$_SESSION[user_id]'");
    $select->execute(); 

    header("location: index.php");

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Tus Productos';
    $mail->Body    = 'Aqui estan tus Libros, Disfrutalos!!<b>Gracias por tu Compra!</b>';
   /*  $mail->AltBody = 'This is the body in plain text for non-HTML mail clients'; */

    $mail->send();
    echo 'Mensaje Enviado!';
} catch (Exception $e) {
    echo "El mensaje no pudo ser enviado. Error: {$mail->ErrorInfo}";
}
