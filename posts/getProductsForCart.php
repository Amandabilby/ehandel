<?php

    include("../objects/Posts.php");

    $product_handler = new Post($databaseHandler);

    print_r($product_handler->getProduct($_POST['type'], $_POST['color'], $_POST['price']));
    

    $token = $_POST['token'];

    if($product_handler->validateToken($token) === false) {
        echo "Invalid token!";
        die;
    }
    
?>