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

/* if(isset($_GET['action']) && $_GET['action'] == "add") { //om det finns action att göra o om den är satt så ska den deletas. Det innebär: allt som görs under

    $query = "DELETE FROM products WHERE id=". $_GET['id'];

    $Id = htmlspecialchars($id);

    $sth =  $dbh->prepare($query); 
    $sth->bindParam('id', $id); 

    $return = $dbh->exec($query);


    $query = "DELETE FROM products WHERE id=". $_GET['id']; //query returnerar en array med värdet från databasen 

    $return = $dbh->exec($query); //exec returnerar false

    header("location:../productside.php"); 
} */


    class Post {

        private $database_handler;
        private $type;
        private $token_validity_time = 1; // minutes



       
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




                if(!empty($return)) {

                    $this->type = $return['type'];

                    $return_object->token = $this->getToken($return['id'], $return['type']);
                    return json_encode($return_object);
                } else {
                    echo "fel login";
                }

                

            } else {
                echo "Could not create a statementhandler";
                die;
            }
       
       
        }

        public function getProduct($type_parameter, $color_parameter, $price_parameter) {
            $query_string = "SELECT id, type, color, price FROM products WHERE type=:type_IN";
            $statementHandler = $this->database_handler->prepare($query_string);
            
            if($statementHandler !== false) {
    
    
                $statementHandler->bindParam(':type_IN', $type_parameter);
              


    
    
                
    
                $statementHandler->execute();
                $return = $statementHandler->fetch();
    
                if(!empty($return)) {
    
                    $this->type = $return['type'];
    
                    $return_object->token = $this->getToken($return['id'], $return['type']);
                    return json_encode($return_object);
                } else {
                echo "Could not create a statementhandler";
            }
        }
    }


    private function getToken($productID, $type) {

        $token = $this->checkToken($productID);

        return $token;

    }

    private function checkToken($productID_IN) {

        $query_string = "SELECT token, date_updated FROM carttokens WHERE product_id=:productID";
        $statementHandler = $this->database_handler->prepare($query_string);

        if($statementHandler !== false) {

                $statementHandler->bindParam(":productID", $productID_IN);
                $statementHandler->execute();
                $return = $statementHandler->fetch();
              

                
                if(!empty($return['token'])) {
                    // token finns

                    $token_timestamp = $return['date_updated'];
                    $diff = time() - $token_timestamp;
                    if(($diff / 60) > $this->token_validity_time) {

                        $query_string = "DELETE FROM carttokens WHERE product_id=:productID";
                        $statementHandler = $this->database_handler->prepare($query_string);

                        $statementHandler->bindParam(':productID', $productID_IN);
                        $statementHandler->execute();

                        return $this->createToken($productID_IN);

                    } else {
                        return $return['token'];
                    }
         

                } else {

                    return $this->createToken($productID_IN);

                }

        } else {
            echo "Could not create a statementhandler";
        }

    }

    private function createToken($product_id_parameter) {

        $uniqToken = md5($this->type.uniqid('', true).time());

        $query_string = "INSERT INTO carttokens (product_id, token, date_updated) VALUES(:productid, :carttoken, :current_time)";
        $statementHandler = $this->database_handler->prepare($query_string);

        if($statementHandler !== false) {

            $currentTime = time();
            $statementHandler->bindParam(":productid", $product_id_parameter);
            $statementHandler->bindParam(":token", $uniqToken);
            $statementHandler->bindParam(":current_time", $currentTime, PDO::PARAM_INT);

            $statementHandler->execute();
          //  $statementHandler->debugDumpParams();

            return $uniqToken;


        } else {
            return "Could not create a statementhandler";
        }


    }


public function validateToken($token) {

    $query_string = "SELECT product_id, date_updated FROM carttokens WHERE token=:token";
    $statementHandler = $this->database_handler->prepare($query_string);

    if($statementHandler !== false ){

        $statementHandler->bindParam(":token", $token);
        $statementHandler->execute();

        $token_data = $statementHandler->fetch();

        if(!empty($token_data['date_updated'])) {

            $diff = time() - $token_data['date_updated'];

            if( ($diff / 60) < $this->token_validity_time ) {

                $query_string = "UPDATE carttokens SET date_updated=:updated_date WHERE token=:token";
                $statementHandler = $this->database_handler->prepare($query_string);
                
                $updatedDate = time();
                $statementHandler->bindParam(":updated_date", $updatedDate, PDO::PARAM_INT);
                $statementHandler->bindParam(":token", $token);

                $statementHandler->execute();

                return true;

            } else {
                echo "Session closed due to inactivity<br />";
                return false;
            }
        } else {
            echo "Could not find token, please login first<br />";
            return false;
        }

    } else {
        echo "Couldnt create statementhandler<br />";
        return false;
    }

    // 1. Validera parametern $token mot databasen.
    // 2. Uppdatera date_updated vid check om den är aktiv.
    // 3. returnera sant om den finns, falskt om den inte finns eller om den är inaktiv.



    return true;

}


}


class GetProducts {
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