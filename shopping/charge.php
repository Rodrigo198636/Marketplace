<?php require "../includes/header.php"; ?>
<?php require "../config/config.php"; ?>
<?php require "../vendor/autoload.php"; ?>
<?php

if( $_SERVER ['REQUEST_METHOD']=='GET' && realpath(__FILE__) == realpath($_SERVER['SCRIPT_FILENAME'])){

    header('HTTP/1.0 403 Forbidden', TRUE, 403);

    die( header('location: '.APPURL.''));
}

if (!isset($_SESSION['username'])){
    header("location: ".APPURL."");
  }

if (isset($_POST['email'])) {

    $stripe = new \Stripe\StripeClient($secret_key);

    $charge = \Stripe\Charge::create([
        'source' => $_POST['stripeToken'],
        'amount' => $_SESSION['price'] * 100,
        'currency' => 'usd',
    ]);

    echo "Pago Realizado";

    if (
        empty($_POST['email']) or empty($_POST['username']) or empty($_POST['fname'])
        or empty($_POST['lname'])
    ) {
        echo "<script>alert('uno o mas campos estan vacios');</script>";
    } else {

        $email = $_POST['email'];
        $username = $_POST['username'];
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $token = $_POST['stripeToken'];
        $price = $_SESSION['price'];
        $user_id = $_SESSION['user_id'];

        $insert = $conn->prepare("INSERT INTO ordenes (email, usernam, fname, lname, token, price, user_id))
        VALUES(:email, :usernam, :fname, :lname, :token, :price, :user_id)");

        $insert->execute([
            ':email' => $email,
            ':username' => $username,
            ':fname' => $fname,
            ':lname' => $lname,
            ':token' => $token,
            ':price' => $price,
            ':user_id' => $user_id
        ]);

        header("loation: ".APPURL."/download.php");
    }
}
