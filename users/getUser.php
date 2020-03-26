<?php

    include("../objects/Users.php");

    $user_handler = new User($databaseHandler);

    print_r($user_handler->loginUser($_POST['username'], $_POST['password']));
    

    $token = $_POST['token'];

    if($user_handler->validateToken($token) === false) {
        echo "Invalid token!";
        die;
    }
    
?>