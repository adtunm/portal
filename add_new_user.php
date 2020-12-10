<?php

session_start();
include 'constants_old.php';
$nazwa=$_POST['nazwa'];
    $haslo=$_POST['haslo'];
    $haslo2=$_POST['haslo2'];
    $imie=$_POST['imie'];
    $nazwisko=$_POST['nazwisko'];
    $email=$_POST['email'];
    function show(){
        global $nazwa, $haslo, $haslo2, $imie, $nazwisko, $email;
    echo "'nazwa= '$nazwa,' haslo= ' $haslo,' haslo2= ' $haslo2 ,' imie= ' $imie,' nazwisko= ' $nazwisko, ' mail= '$email";
    }
    show();



    $host='localhost';
    $baza='baza';
    $uzytkownik='root';
    $haslo='';
    
    function addUser($nazwa, $pass, $pass2, $imie, $nazwisko, $email)
    {
        global $host, $baza, $haslo, $uzytkownik;
        
        $userPassLenght = mb_strlen($pass, 'UTF-8');
        echo "0";
        if($imie=="" || $nazwisko==""|| $email==""){
            return EMPTY_FIELDS;
        }
        echo "1";
        if($userPassLenght<6 || $userPassLenght >40 ){
            return INVALID_USER_PASS;
        }
        echo "2";
        if($pass != $pass2){
            return PASSWORDS_DO_NOT_MATCH;
        }
        echo "3";
        
        //echo $nazwa, $pass, $imie, $nazwisko, $email;
        
        $db_obj=new mysqli($host, $uzytkownik, $haslo, $baza);
        if($db_obj->connect_errno){
        return SERVER_ERROR;
        }
        echo "4";
        $nazwa=$db_obj->real_escape_string($nazwa);
        $imie=$db_obj->real_escape_string($imie);
        $nazwisko=$db_obj->real_escape_string($nazwisko);
        $email=$db_obj->real_escape_string($email);
    
        $query="SELECT COUNT(*) FROM user WHERE User='$nazwa'";
        if(!$result=$db_obj->query($query)){
         $db_obj->close();
         return SERVER_ERROR;
        }
        echo "5";
        if(!$row=$result->fetch_row()){
         $db_obj->close();
         return SERVER_ERROR;
        }
        
        else{
            if($row[0]>0){
                $db_obj->close();
                return USER_ALREDY_EXIST;
            }
        }
        echo "6";
        $pass1=md5($pass);
        $query = "INSERT INTO `user` (`Id`, `User`, `Haslo`, `imie`, `nazwisko`, `email`) VALUES (NULL, '$nazwa', '$pass1', '$imie', '$nazwisko', '$email')";
        
        
        if(!$result=$db_obj->query($query)){
            $db_obj->close();
            return SERVER_ERROR;
        }
        echo "7";
        $count=$db_obj->affected_rows;
        if($count <> 1){
            $db_obj->close();
            return SERVER_ERROR;
        }
        
        else {
            $db_obj->close();
            return OK;
        }
        echo "8";
    }

    if(isset($_SESSION['zalogowany'])){
        header("Location: main.php");
    }
    else if(!isset($_POST['nazwa'])   || !isset($_POST['haslo'])||
            !isset($_POST['haslo2'])  || !isset($_POST['imie']) ||
            !isset($_POST['nazwisko'])|| !isset($_POST['email'])){
                header('Location: new_user_form.php');
    
}
else{
    $nazwa=$_POST['nazwa'];
    $haslo1=$_POST['haslo'];
    $haslo2=$_POST['haslo2'];
    $imie=$_POST['imie'];
    $nazwisko=$_POST['nazwisko'];
    $email=$_POST['email'];
    
     //echo $nazwa, $haslo1,$haslo2 , $imie, $nazwisko, $email;
    
    $val= addUser($nazwa, $haslo1, $haslo2, $imie, $nazwisko, $email);
    $_SESSION['kod']=$val;
    echo "'   val= '$val";
    
    switch($val){
        case OK:
            $_SESSION['komunikat']='Rejstracja poprawna';
            break;
        case INVALID_USER_NAME:
            $_SESSION['komunikat']='Nazwa uzytkownika musi mieć od 3 do 20 znaków';
            break;
        case INVALID_USER_PASS:
            $_SESSION['komunikat']='Haśło musi miec od 6 do 40 znaków';
            break;
        case USER_ALREDY_EXIST:
            $_SESSION['komunikat']="Nazwa '$nazwa' jest zajęta";
            break;
        case EMPTY_FIELDS:
            $_SESSION['komunikat']='Prosze wypelnić wszystkie pola w formularzu';
            break;
        case PASSWORDS_DO_NOT_MATCH:
            $_SESSION['komunikat']='Wpisane hasła róźnią się.';
            break;
        default :
            $_SESSION['komunikat']='Błąd serwera. Rejstracja nie powiodła sie.';
    }
    header('Location:after_registration.php');
}
    
