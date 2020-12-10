<?php

session_start();
$timeout=5;
include 'portal.php';

try{
    $portal=new Portal("localhost", "root","","baza");
    //echo "1";
} catch (Exception $e) {
    exit('Portal chwilowo niedostępny');
}
$action ='showMain';
if(isset($_GET['action']))
{
    $action= $_GET['action'];
}
$newsHeader=$portal->getNewsHeaders(5);
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
    case 'sNewsList':
      //  $portal->showNewsList(ROWS_ON_PAGE);
       include 'news.php';
        break;
    case 'aNews':
        //$news=$portal->getNews();
        //include 'templates/singleNewsTemplate.php';
        include 'news.php';
        break;
    default :
        include 'templates/mainTemplate.php';
}


