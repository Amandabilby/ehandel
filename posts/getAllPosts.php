<?php

    include("../objects/Posts.php");
    include("../objects/Users.php");

    
    $Posts = new Post($databaseHandler); 
    $Posts->fetchAll();
    
    foreach( $Posts->getPosts() as $post )
    
    $token = $_POST['token'];

if($post_handler->validateToken($token) === false) {
    echo "Invalid token!";
    die;
}


?>