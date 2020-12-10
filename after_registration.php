<?php
session_start();
include 'constants.php';

if(isset($_SESSION['komunikat']) && isset($_SESSION['kod'])){
    $komunikat=$_SESSION['komunikat'];
    $kod=$_SESSION['kod'];
    unset($_SESSION['komunikat']);
    unset($_SESSION['kod']);

}
else{
    $komunikat="Nieznany status rejstracji";
    $kod=UNKNOWN_ERROR;
}

?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Rejstracja uzytkownika</title>
    </head>
    <body>
        <p><?php echo $komunikat;?></p>
        <?php if($kod==OK): ?>
        <p>Możesz się <a href="login.php">zalogować</a>.</p>
        <?php else:?>
        <p>Powrót do<a href="new_user_form.php">formularza rejstracyjnego</a></p>
        <?php endif;?>
    </body>
</html>
