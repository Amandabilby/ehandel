<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Amandas E-handel!</title>


</head>
<body><center>
<h1>Välkommen till Amandas E-handel</h1><br>
    
    Logga in <br>
    <form action="http://192.168.64.2/ehandel/users/getUser.php" method="POST">
        <input type="text" name="username" placeholder="username" /><br />
        <input type="password" name="password" placeholder="password" /><br />
        
        <input type="submit" value="Logga in!" />
    </form>
    <br><br>
Registrera användare <br>
    <form action="http://192.168.64.2/ehandel/users/addUser.php" method="POST">
        <input type="text" name="username" placeholder="username" /><br />
        <input type="password" name="password" placeholder="password" /><br />
        <input type="email" name="email" placeholder="email@example.com" /><br />
        
        <input type="submit" value="Registrera!" />
    </form>
    <br> (admin)
    <a href="addProduct.php">Lägg till produkter</a><br>
(alla)
    <a href="productside.php">Till produkterna</a>
</center>
    
</body>
</html>