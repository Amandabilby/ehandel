<?php
include("config/database_handler.php");
include("objects/Posts.php");

?>
<br><br><br><center>

<?php
$Posts = new GetProduct($databaseHandler); 
$Posts->fetchAll();

foreach( $Posts->getPosts() as $post ) {
  echo "" . "Typ: " . "" . $post ['type'] . "<br />";
  echo "" . "Färg: " . "" . $post ['color'] . "<br />";
  echo "" . "Pris: " . "" . $post ['price'] . " sek<br /><br>"; 
  echo "" . "<button type='button'><a id='btn' href=\"cart.php?id=" . $post['id'] ."\">Lägg till i varukorg</a></button><br><br>"; 


/* } if(!isset($_SESSION['role']) || $_SESSION['role'] != "admin") {
    echo "<hr />";
    } else { */
      echo "<a id='btn' href=\"objects/Posts.php?action=delete&id=" . $post['id'] ."\">Ta bort produkt</a><br />
      <a id='btn' href=\"editProduct.php?id=" . $post['id'] ."\">Uppdatera produkt</a> <br /><br /><br><br>
      ";
  
    }


?>

</center>