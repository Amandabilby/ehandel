<?php

    include("../objects/Posts.php");
    include("../objects/Users.php");
    include("../objects/Cart.php");



    $carts_object = new Cart($databaseHandler);

    



echo $carts_object->addProductToCart($_POST['product_id'], $_POST['token_id']); 


    $products_object = new Post ($databaseHandler);



    $token_id_IN = ( isset($_POST['token_id']) ? $_POST['token_id'] : '');
    $product_id_IN = ( isset($_POST['product_id']) ? $_POST['product_id'] : '' );
    
    if(!empty($product_id_IN)) {
        if(!empty($token_id_IN)) {
        $carts_object->addProductToCart($token_id_IN, $product_id_IN);

        echo "". $_POST['token_id'] ."";
        echo "". $_POST['product_id'] ."";

    } else {
        echo "Error: price cannot be empty";
    } 
} 

    /* print_r($product_handler->addProductToCart($_POST['type'], $_POST['color'], $_POST['price']));
    

    $token = $_POST['token'];

    if($product_handler->validateToken($token) === false) {
        echo "Invalid token!";
        die;
    } */
    
?>