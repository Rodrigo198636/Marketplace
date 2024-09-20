<?php

    $host = "localhost";

    $dbname = "Bookstore";

    $user = "root";

    $pass = "";

  
        $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
        
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
        $secret_key = "sk_test_51Q0NfI09EtHGwjDiKmiWXWdiyGzgUsdnLwmDbg0koInhVmay49YRm1WX0gCM1xV6Vc6z8F6uuRWFsvR8gA22Xu7300DED7jRMP";

        
  