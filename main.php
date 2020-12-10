<?php

session_start();
if(!isset($_SESSION['zalogowany'])){
    $_SESSION['komunikat']="Nie jesteś zalogowany";
    header("Location: login.php");
    exit();
    
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Główna część serwisu</title>
    </head>
    <body>
        <p>Jesteś zalogowany jako:<?=$_SESSION['zalogowany']?></p>
        <p><a href="logout.php">Wylogowanie</a></p>
    </body>
</html>

