
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


<h1>Kundvagn</h1>


Produkttyp:
<?php echo $postdata['type']; ?><br /><br />

Färg: 
<?php echo $postdata['color']; ?><br />

 <br />
Pris: 
<?php echo $postdata['price']; ?><br />
</form>
</div>
</body>