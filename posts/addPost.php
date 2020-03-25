<?php

include("../objects/Posts.php");

$post_handler = new Post($databaseHandler);

echo $post_handler->addProduct($_POST['type'], $_POST['color'], $_POST['price']); 


?>