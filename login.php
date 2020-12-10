<?php
if(!isset($portal)) die();

if(!$portal->zalogowany){
    switch ($portal->login()){
        case LOGIN_OK:
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

  
    
    
    
    /*
session_start();
     $host='localhost';
     $baza='baza';
     $uzytkownik='root';
     $haslo='';
     
     function checkPass($user, $pass)
     {
         global $haslo, $baza, $host, $uzytkownik;
         
         $userNameLenght= mb_strlen($user, 'UTF-8');
         $userPassLenght= mb_strlen($pass, 'UTF-8');
         if ($userNameLenght < 1 || $userNameLenght > 20 ||
            $userPassLenght < 1 || $userPassLenght > 40) {
        return 2;
    }

     $db_obj = new mysqli($host, $uzytkownik, $haslo, $baza);
     if($db_obj->connect_errno){
         echo "Wystąpił błąd podczas próby z połączeniem z serwerem MySQL";
         return 5;
     }
     
     $user=$db_obj->real_escape_string($user);
     $pass=$db_obj->real_escape_string($pass);
     
     $query = "SELECT Haslo FROM user WHERE User='$user' ";
     
     
     if(!$result = $db_obj->query($query)){
         echo "Wystąpił błąd, nieprawidłowe zapytanie";
         $db_obj->close();
         return 1;
     }
     $pass1= md5($pass);
     if($result->num_rows <> 1){
         $result=2;
     }
     else{
         $row=$result->fetch_row();
         $pass_db=$row[0];
         if($pass1 != $pass_db){
             $result=2;
         }
        else {
            $result=0;
        }
     }
     
     $db_obj->close();
     return $result;
     }
     
     if(isset($_SESSION['zalogowany'])){
         header("Location:main.php");
     }
     else if(!isset($_POST["haslo"]) ||!isset($_POST["user"])){
         if(!isset($_SESSION['komunikat'])){
             $_SESSION['komunkat']="Wprowadź nazwę i hasło użytkownika";
         }
         include('form.php');
     } 
     
     else{
         $val= checkPass($_POST['user'],$_POST['haslo']);
             if($val==0){
                 $_SESSION['zalogowany']=$_POST["user"];
                 header("Location: main.php");
             }
             else if($val==1){
                $_SESSION['komunikat']="Błąd serwera. Zalogowanie było niemożliwe.";
                header("Location: login.php");
             }
             else if($val==2){
                $_SESSION['komunikat']="Nieprawidłowa nazwa lub hasło uzytkownika.";
                header("Location: login.php");
             }
            
             else{
                $_SESSION['komunkat']="Błąd serwera. Zalogowanie było niemożliwe";
                header("Location: login.php");
             }
     }
          
?>

*/