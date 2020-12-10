<?php
if(!isset($portal)) die();

if(!$portal->zalogowany){
    
    if(($val2=$portal->register())==REG_OK){
         $portal->setMessage("Rejstracja zzkończona sukcesem!<br> Proszę się zalogować.");
        header("Location:index.php?action=showLoginForm");
            exit();
    }
    else
    {
         $portal->setMessage($val2);
    }
}
 else {
    $portal->setMessage("Jestes zalogowany!");
}
header("Location:index.php?action=showRegForm");


/*
if($portal->zalogowany){
    switch ($portal->register()){
        case REG_OK:
            header("Location:index.php?action=showMain");
            exit();
        case LOGIN_FAILED :
            $portal->setMessage("Nieprawidłowa nazwa lub hasło.");
            break;
        case SERVER_ERROR :
        default :
            $portal->setMessage("Błąd serwera.");
    }
}
else {
    $portal->setMessage("Najepierw musisz sie wylogować.");
}
header("Location:index.php?action=showLoginForm");

*/