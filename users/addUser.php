  
<?php

include("../objects/Users.php");

$product_handler = new User($databaseHandler);

echo $product_handler->addUser($_POST['username'], $_POST['password'], $_POST['email']);

$token = $_POST['token'];

if($user_handler->validateToken($token) === false) {
    echo "Invalid token!";
    die;
}

?>