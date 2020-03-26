<?php

include("../objects/Posts.php");

$post_handler = new Post($databaseHandler);

echo $post_handler->addProduct($_POST['type'], $_POST['color'], $_POST['price']); 

header("location:../productside.php");

$token = $_POST['token'];

if($user_handler->validateToken($token) === false) {
    echo "Invalid token!";
    die;
}


?>