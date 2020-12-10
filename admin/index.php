<?php

session_start();
include 'portal_admin.php';
include 'constants.php';

try{
    $portal=new PortalAdmin("localhost", "root","","baza");
    echo "1";
} catch (Exception $e) {
    exit('Panel Admina chwilowo niedostępny');
}
echo "2";
$action ='showLoginForm';
if(isset($_GET['action']))
{
    echo "3";
    $action= $_GET['action'];
}
        $komunikat_adm=$portal->getAdminMessage();
        echo "4";
        
        switch ($action){
            case 'login':
                echo "5";
                if (!$portal->zalogowany_adm) {
                    echo "6";
            switch ($portal->login()) {
                case LOGIN_OK:
                    echo "7";
                    $portal->setAdminMessage("zalogowanie poprawne");
                    break;
                case LOGIN_FAILED:
                    echo "8";
                    $portal->setAdminMessage("nieprawidłowy login lub hasło");
                    break;
                case NO_ADMIN_RIGHTS:
                    echo "9";
                    $portal->setAdminMessage("brak uprawnien administracyjnych");
                    $portal->logout();
                    break;
                case xD:
                    $portal->setAdminMessage("xD");
                    break;
                default :
                    echo "10";
                    $portal->setAdminMessage("błąd serwera");
                    $portal->logout();
            }
        }
        echo "11";
        header('Location:index.php');
                exit();
            case 'logout':
                echo "12";
                $portal->logout();
                header('Location:index.php');
                exit();
        }
        if(!$portal->zalogowany_adm){
            echo "13";
            $action='showLoginForm';
        }
        echo "14";
        include 'templates/mainTemplate.php';


/*$action ='showMain';
if(isset($_GET['action']))
{
    $action= $_GET['action'];
}
$komunikat=$portal->getMessage();
switch ($action){
    case 'login' :
        include 'login.php';
        break;
    case 'logout' :
        include 'logout.php';
        break;
    case 'reg' :
        include 'reg.php';
        break;
    default :
 */