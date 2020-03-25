<?php

    include("../objects/Posts.php");

    $Posts = new Post($databaseHandler); 
    $Posts->fetchAll();
    
    foreach( $Posts->getPosts() as $post )
    

?>