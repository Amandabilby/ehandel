<?php

    include("../objects/Posts.php");

    $Posts = new Post($databaseHandler); 
    $Posts->fetchAll();
    
    foreach( $Posts->getPosts() as $post )
    
    $token = $_POST['token'];

if($user_handler->validateToken($token) === false) {
    echo "Invalid token!";
    die;
}


?>