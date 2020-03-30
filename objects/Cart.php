<?php 

    include("../config/database_handler.php");

class Cart {
    private $database_handler;
    private $cart_id; 
    private $token_validity_time = 2;

    public function __construct( $database_handler_IN ) {
    $this->database_handler = $database_handler_IN;

    }

    public function setCartId($cart_id_IN) { 
        $this->cart_id = $cart_id_IN; 

    }

    public function fetchCart() { //fetchSinglePost

        $query_string = "SELECT id, user_id FROM cart WHERE id=:cart_id";
        $statementHandler = $this->database_handler->prepare($query_string);

        if($statementHandler !== false) {
            
            $statementHandler->bindParam(":cart_id", $this->cart_id);
            $statementHandler->execute();

            return $statementHandler->fetch();



        } else {
            echo "Could not create database statement!";
            die();
        }

    }

    

    public function addProductToCart($product_param, $token_param) {

        $query_string = "INSERT INTO cart(product_id, token_id) VALUES(:product_id, :token_id)";
        $statementHandler = $this->database_handler->prepare($query_string);

        if($statementHandler !== false) {
            $return_object = new stdClass();

            $statementHandler->bindParam(':product_id', $product_param);
            $statementHandler->bindParam(':token_id', $token_param);
            
            $statementHandler->execute();
            $return = $statementHandler->fetch();

            if($return === true) {
                echo "OK!";
            } else {
                echo "Error while trying to insert post to database!";
            
            }
        } else {
            echo "Could not create database statement!";
            die();
        }
    }
    public function validateToken($token) {
            $query_string = "SELECT id FROM tokens WHERE token=:token";
            $statementHandler = $this->database_handler->prepare($query_string);

                if($statementHandler !== false) {
                    $statementHandler->bindParam(':token', $token);
                    $statementHandler->execute();

                    $token_data = $statementHandler->fetch();

                        if(!empty($token_data['time_updated'])) {
                            $diff = time() - $token_data['time_updated'];

                                if(($diff / 60) < $this->token_validity_time) {
                                    $query_string = "UPDATE tokens SET time_updated=:updated_time WHERE token=:token";
                                    $statementHandler = $this->database_handler->prepare($query_string);

                                    $updatedDate = time();
                                    $statementHandler->bindParam(":updated_time", $updatedDate, PDO::PARAM_INT);
                                    $statementHandler->bindParam(':token', $token);

                                    $statementHandler->execute();

                                    return true;

                                } else {
                                return false; 
                                echo "Din tid har runnit ut!";
                                }

                        } else {
                        return false;
                        echo "Om fältet inte finns..";
                        }

                } else {
                echo "if couldnt create statementhandler";
                return false;
                }
            return true;
        }

    }
?>