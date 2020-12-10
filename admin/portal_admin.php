<?php

include 'users_admin.php';

class PortalAdmin
{
    private $dbo=null;
    public $zalogowany_adm=null;
    
    function __construct($host, $user, $pass, $db) {
        $this->dbo= $this->initDB($host,$user,$pass,$db);
        $this->zalogowany_adm= $this->getActualAdmin();    
    }
    
    function initDB($host,$user,$pass,$db)
    {
        $dbo=new mysqli($host, $user, $pass, $db);
            if($dbo->connect_errno){
            $msg="Brak połączenia z bazą danych.";
            $msg.=$dbo->connect_error;
            throw new Exception($msg);
        }
        return $dbo;
    }
    function getActualAdmin()
    {
       if(isset($_SESSION['zalogowany_adm']))
            return $_SESSION['zalogowany_adm'];
        else
            return null; 
    }
    function setAdminMessage($komunikat_adm)
    {
       $_SESSION['komunikat_adm']=$komunikat_adm; 
    }
    function getAdminMessage()
    {
        if(isset($_SESSION['komunikat_adm'])){
            $komunikat_adm=$_SESSION['komunikat_adm'];
            unset($_SESSION['komunikat_adm']);
            return $komunikat_adm;
        }
        else            
            return null;
    }
    function login()
    {
        if(!$this->dbo) return xD;
        
        if(!isset($_POST["haslo"]) || !isset($_POST["user"]))
            return LOGIN_FAILED;
        
        
        $user=$_POST["user"];
        //return $komunikat=$user;
        $pass=$_POST["haslo"];
        

        $userNameLenght= mb_strlen($user, 'UTF-8');
        $userPassLenght= mb_strlen($pass, 'UTF-8');
         if ($userNameLenght < 1 || $userNameLenght > 20 ||
            $userPassLenght < 1 || $userPassLenght > 40) {
        return LOGIN_FAILED;
        
    }
    
       $user= $this->dbo->real_escape_string($user);
       $pass= $this->dbo->real_escape_string($pass);
       
       $query = "SELECT Haslo, User, Id FROM user WHERE User='$user'";
       
       
       if(!$result= $this->dbo->query($query)){
           return SERVER_ERROR;
       }
       
       if($result->num_rows <> 1){
            
           return LOGIN_FAILED;
       }
      
       else{
           
           $row=$result->fetch_row();
           $pass_db=$row[0];
           if(md5($pass) != $pass_db){
                
               return LOGIN_FAILED;
           }
           else{
                
               $_SESSION['zalogowany_adm']=$row[1];
           }
           
           if(!isset($_SESSION['przywileje']))
           {
               $_SESSION['przywileje']=array();
           }
            
           $query = "SELECT `id_funkcja` FROM user WHERE id = '$row[2]'";
           
           if($result= $this->dbo->query($query)){
                while($row=$result->fetch_row())
                {
                    $_SESSION['przywileje'][$row[0]]=true;
                }
            }  
            if(isset($_SESSION['przywileje'][$row[1]])){
                return LOGIN_OK;
            }
            else 
            {
                return NO_ADMIN_RIGHTS;
            }
           
       }
    }
    function logout()
    {
        if(isset($_SESSION['zalogowany_adm'])){
            $this->zalogowany_adm=null;
            unset($_SESSION['zalogowany_adm']);
            unset($_SESSION['przywileje']);
            if(isset($_COOKIE[session_name()])){
                setcookie(session_name(),'', time()-3600);
            }
        session_destroy();
        }   
    }
    function usersAdmin()
    {
        $ua=new UsersAdmin($this->dbo);
        if(isset($_GET['wtd'])){
            $wtd=$_GET['wtd'];
        }
        else {
            $wtd='showList';
        }
        switch ($wtd){
            case 'showEditForm':
                $ua->showEditForm('edit');
                break;
            case 'showAddForm':
                $ua->showEditForm('add');
                break;
            case 'showSearchForm':
                $ua->showSearchForm();
                break;
            case 'addUser' :
                $ua->editUser('add');
                break;
            case 'modifyUser':
                $ua->editUser('edit');
                break;
            case 'searchUser':
                $ua->srarchUser();
                break;
            case 'deleteUser':
                $ua->deleteUser();
                break;
            case 'showList':
            default :
                $ua->showList(ROWS_ON_PAGE);
        }
    }
}
?>