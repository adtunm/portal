<?php
//if(isset($portal)) die();


if($portal->zalogowany){
    $portal->logout();
}
header("Location: index.php");
    
    /*
    session_start();
if(!isset($_SESSION['zalogowany'])){
    $komunikat="Nie jestes zalogowany";
}
else{
    unset($_SESSION['zalogowany']);
    $komunikat="Wylogowanie prawidłowe";
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Wylogowanie</title>
    </head>
    <body>
        <p><?=$komunikat?></p>
        <p><a href="login.php">Powrót do strony logowania</a></p>
    </body>
</html>

*/