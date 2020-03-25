<?php
include("objects/Posts.php");
include("config/database_handler.php");


$query = "SELECT * FROM products WHERE id=". $_GET['id'];


$sth =  $dbh->prepare($query); //statement handler
$sth->bindParam('id', $id); //BindParam sätter :name till variabel. PDO-funktion.

$return = $dbh->query($query); //exec returnerar false


$postdata = $return->fetch(PDO::FETCH_ASSOC);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Amandas E-handel</title>
    <link href="https://fonts.googleapis.com/css?family=Nunito+Sans&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>

<div id="editstyle">


<h1>Uppdatera produkt</h1>

<form method="POST" action='objects/Posts.php?action=update&id=<?php echo $_GET['id'];?>'>

Produkttyp:
<input type="text" id="input" name="type" value="<?php echo $postdata['type']; ?>" style="height: 30px; width: 300px;" /><br />

Färg: 
<input type="text" id="input" name="color" value="<?php echo $postdata['color']; ?>" style="height: 30px; width: 300px;" /><br />

 <br />
Pris: 
<input type="text" id="input" name="price" value="<?php echo $postdata['price']; ?>" style="width: 300px; height: 30px;" /><br />
<input type="submit" name="submit" value="Posta" />
</form>
</div>
</body>