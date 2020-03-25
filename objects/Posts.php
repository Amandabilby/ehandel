<?php

    include("../config/database_handler.php");

    if(isset($_GET['action']) && $_GET['action'] == "delete") { //om det finns action att göra o om den är satt så ska den deletas. Det innebär: allt som görs under

        $query = "DELETE FROM products WHERE id=". $_GET['id'];
    
        $Id = htmlspecialchars($id);
    
        $sth =  $dbh->prepare($query); 
        $sth->bindParam('id', $id); 
    
        $return = $dbh->exec($query);
    
    
        $query = "DELETE FROM products WHERE id=". $_GET['id']; //query returnerar en array med värdet från databasen 
    
        $return = $dbh->exec($query); //exec returnerar false
    
        header("location:../productside.php"); 
    }
else if(isset($_GET['action']) && $_GET['action'] == "update"){
    $type = $_POST['type'];
    $color = $_POST['color'];
    $price = $_POST['price'];
    $query = "UPDATE products SET type='$type', color='$color', price='$price' WHERE id=". $_GET['id'];
    $return = $dbh->exec($query);
    header("location:../productside.php");
}


    class Post {

        private $database_handler;
        private $type;


       
       public function __construct($database_handler_parameter_IN)
       {
           $this->database_handler = $database_handler_parameter_IN;
       }

       public function addProduct($type_IN, $color_IN, $price_IN) {
        $return_object = new stdClass();

       /* if($this->isUsernameTaken($username_IN) === false) {
            if($this->isEmailTaken($email_IN) === false) {
*/
                
                $return = $this->insertProductToDatabase($type_IN, $color_IN, $price_IN);
                if($return !== false) {

                    $return_object->state = "SUCCESS";
                    $return_object->user = $return;

                }  else {

                    $return_object->state = "ERROR";
                    $return_object->message = "Something went wrong when trying to INSERT type";

                }


        return json_encode($return_object);
       }
       
       private function insertProductToDatabase($type_param, $color_param, $price_param) {

            $query_string = "INSERT INTO products (type, color, price) VALUES(:type, :color, :price)";
            $statementHandler = $this->database_handler->prepare($query_string);

            if($statementHandler !== false ){


                $statementHandler->bindParam(':type', $type_param);
                $statementHandler->bindParam(':color', $color_param);
                $statementHandler->bindParam(':price', $price_param);

                $statementHandler->execute(); 


                $last_inserted_user_id = $this->database_handler->lastInsertId();

                $query_string = "SELECT id, type, color, price FROM products WHERE id=:last_user_id";
                $statementHandler = $this->database_handler->prepare($query_string);

                $statementHandler->bindParam(':last_user_id', $last_inserted_user_id);

                $statementHandler->execute();

                return $statementHandler->fetch();
                

            } else {
                return false;
            }

            

       }


    }

    class GetProduct {
        private $databaseHandler;
        private $order = "desc";
        private $posts; 
    
        public function __construct($dbh) {
            $this->databaseHandler = $dbh;
    
        }
     /* hämtar alla poster och returnerar dem en array*/
        public function fetchAll() {
            $query = "SELECT id, type, color, price FROM products ORDER BY id $this->order";
            $return_array = $this->databaseHandler->query($query);
            $return_array = $return_array->fetchAll(PDO::FETCH_ASSOC);
    
            $this->posts = $return_array;
        }
    
        public function getPosts() {
            return $this->posts;
        }
    
     }
    
?>