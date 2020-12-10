<?php

include 'constants.php';

class Portal
{
    private $dbo=null;
    public $zalogowany =null;
    
    function __construct($host, $user, $pass, $db) {
        $this->dbo= $this->initDB($host, $user, $pass, $db);
        $this->zalogowany= $this->getActualUser();
    }
    
    function initDB($host, $user, $pass, $db)
            {
            $dbo=new mysqli($host, $user, $pass, $db);
            if($dbo->connect_errno){
            $msg="Brak połączenia z bazą danych.";
            $msg.=$dbo->connect_error;
            throw new Exception($msg);
        }
        return $dbo;
    }
    
    function getActualUser()
    {
        if(isset($_SESSION['zalogowany']))
            return $_SESSION['zalogowany'];
        else
            return null;
    }
    
    function setMessage($komunikat)
    {
        $_SESSION['komunikat']=$komunikat;
    }
    
    function getMessage()
    {
        if(isset($_SESSION['komunikat'])){
            $komunikat=$_SESSION['komunikat'];
            unset($_SESSION['komunikat']);
            return $komunikat;
        }
        else            
            return null;
    }
    
    function getQuerySingleResult($query)
    {
        if(!$this->dbo) return false;
        
        if(!$result= $this->dbo->query($query))
        {
            return false;
        }
        
        if ($row = $result->fetch_row()) {
            return $row[0];
        } else {
            return false;
        }
    }
    
    function getQueryResultAsTableRows($query, $colNames=false, $colNamesAsTh=true)
    {
        if(!$this->dbo) return false;
        if(!$result = $this->dbo->query($query)) return false;
        if(!$colums = $result->fetch_fields())return false;
        
        $str='';
        
        if($colNames)
        {
            $str.='<tr>';
            $tag=$colNamesAsTh ? 'th':'td';
            foreach ($colums as $col)
            {
                $str.="<$tag>{$col->name}</$tag>";
            }
            $str.='</tr>';
            
        }
        
        return $str;
    }
    
    function login()
    {
        
        if(!$this->dbo) return SERVER_ERROR;
        
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
                
               $_SESSION['zalogowany']=$row[1];
               $_SESSION['id']=$row[2];
           }
            
           return LOGIN_OK;
       }
       
       
    }
    
    function logout()
    {
        if(isset($_SESSION['zalogowany'])){
            $this->zalogowany=null;
            unset($_SESSION['zalogowany']);
        }
    }
    
    function check($nazwa, $pass, $pass2, $imie, $nazwisko, $email)
    {
        if($imie=="" || $nazwisko==""|| $email==""){
            return REG_EMPTY_FIELDS;
        }
        $userPassLenght = mb_strlen($pass, 'UTF-8');
        echo "1";
        if($userPassLenght<6 || $userPassLenght >40 ){
            return REG_BAD_PASSWORD;
        }
         $userNameLenght = mb_strlen($nazwa, 'UTF-8');
          if($userNameLenght<4 || $userNameLenght >20 ){
            return REG_BAD_NICKNAME;
        }
        echo "2";
        if($pass != $pass2){
            return REG_PASSWORD_ERROR;
        }
        //$nazwa= $this->dbo->real_escape_string($nazwa);
        //$imie= $this->obj->real_escape_string($imie);
        //$nazwisko= $this->obj->real_escape_string($nazwisko);
        //$email= $this->obj->real_escape_string($email);
        $query="SELECT COUNT(*) FROM user WHERE User='$nazwa'";
        if(!$result= $this->dbo->query($query))
        {  
            return REG_USER_ALREDY_EXIST;
        }
        
        if(!$row=$result->fetch_row())
        {
            return SERVER_ERROR;
        }
        else{
            if($row[0]>0){
                return REG_USER_ALREDY_EXIST;
            }
        }
        return OK;
    }
        
    function addUser($nazwa, $pass, $imie, $nazwisko, $email)
    {
        $pass1=md5($pass);
        $query = "INSERT INTO `user` (`Id`, `User`, `Haslo`, `imie`, `nazwisko`, `email`) VALUES (NULL, '$nazwa', '$pass1', '$imie', '$nazwisko', '$email')";

        if(!$result= $this->dbo->query($query)){
            return SERVER_ERROR;
        }
        echo "7";
        $count= $this->dbo->affected_rows;
        if($count <> 1){
           // $db_obj->close();
            return SERVER_ERROR;
        }
        else {
            return OK;
        }
    }
            
    
    function register()
    {
        if(!$this->dbo) 
            return SERVER_ERROR;
        $imie=$_POST['imie'];
        $nazwisko=$_POST['nazwisko'];
        $email=$_POST['email'];
        $pass=$_POST['haslo'];
        $pass2=$_POST['haslo2'];
        $nazwa=$_POST['nazwa'];
        
        $val= $this->check($nazwa, $pass, $pass2, $imie, $nazwisko, $email);
        
        
        
        if($val==OK)
        {
            $val= $this->addUser($nazwa, $pass, $imie, $nazwisko, $email);
            if($val==OK)
            {
                return REG_OK;
            }
            else
            {
                return $val;    
            }
        }
        else 
        {
            return $val;
        }
    }
    
    function getNewsHeaders($ile)
    {
        if(!$this->dbo)return false;
        $query="SELECT id, naglowek FROM news ORDER BY data DESC LIMIT '$ile'";
        return $this->dbo->query($query);
    }
    
    function getNews()
    {
        if(!$this->dbo) return FALSE;
        
        if(!isset($_GET['newsId'])){
            return False;
        }
        else{
            $newsId=(int)$_GET['newsId'];
        }
        
        $query= "SELECT n.naglowek, n.tresc, n.data, u.User, n.`id_user` \n"
                . "FROM news n INNER JOIN user u\n"
                . "ON n.`id_user`=u.id\n"
                . "WHERE n.id = '$newsId'";
        if(!$result= $this->dbo->query($query)){
            return FALSE;
        }
        return $result->fetch_row();
        
        
    }
    
    function showNewsList($limit)
    {
        if(!$this->dbo) return false;
        
        if(isset($_GET['page'])){
            $page=(int)$_GET['page'];
        }
        else{
            $page=0;
        }
        
        $query= "SELECT count(*) FROM news";
        $rowsCount=(int)$this->getQuerySingleResult($query);
        
        //$this->dbo->getQuerySingleResult($query)
        if($limit!=0){
            $pages=ceil($rowsCount / $limit);
            if($page<0 || $page >= $pages){
                $page=0;
            }
            $offset=$page*$limit;
        }
        else{
            $page=0;
            $pages=1;
            $offset=0;
            $limit=$rowsCount;
        }
        
        $query="SELECT n.id, n.naglowek, n.data, u.User "
                . "FROM user u join news n "
                . "ON n.`id_user`=u.Id "
                . "ORDER BY data DESC "
                . "LIMIT $offset, $limit";
        $news= $this->dbo->query($query);
        //var_dump($query);
        include 'templates/newsTemplate.php';
    }
    
    function getPagination($page, $pages, $link, $msg)
    {
        $str='';
        for($i=0;$i<$pages;$i++){
           if($i != $page){
               $str .= "<a href=$link&amp;page=$i>".($i+1)."</a>";
           } 
           else{
               $str.='<span class="activePaginationPage">'.($i+1)
                       .'</span>';
           }
           $str .= '<span class="space"> </span>';
        }
        //$_SESSION['page']=$i;
        $str = $msg.$str;
        return $str;
    }
    
    function showEditForm($action)
    {
        
        if(!$this->dbo) return SERVER_ERROR;
    //var_dump("123321");
        if($action=='edit')
        {
            
            if(isset($_GET['id'])){
                echo "nieprawidłowe id";
                return FORM_DATA_MISSING;
            }
            if(($id=(int)$_GET['id'])<1){
                echo "brak uprawnien";
                return NO_ADMIN_RIGHTS;
            }
            
            $query="SELECT * FROM news WHERE id=$id";
            if(!$result= $this->dbo->query($query)){
                echo "błąd niewłaściwe zapytanie sql";
                return SERVER_ERROR;
            }
            if(!$row=$result->fetch_row()){
                echo "nieprawidłowy parametr id";
                return INVALID_FOUND;
            }
            
            $id=$row[0];
            $naglowek=$row[2];
            $tresc=$row[3];
            
            $wtd='modifyNews';
            $readOnly='readonly="readonly"';
            
        }
        else{
            $id=null;
            $naglowek='';
            $tresc='';
            $wtd='addNews';
            $readOnly='';
        }
        include 'templates/newsEditForm.php';
    }
    
    function chcekNewsEditRights($newsId)
    {
        if(!$this->dbo) return false;
        
        $userId=$_SESSION['id'];
        $query="SELECT `id_user` FROM news WHERE Id=$newsId AND `id_user`=$userId";
        return (bool) $this->getQuerySingleResult($query);
    }
    
    function editNews($action, &$id=0)
    {
        if(!$this->dbo) return SERVER_ERROR;
        
        if(!isset($_POST['naglowek']) || !isset($_POST['tresc'])){
            return FORM_DATA_MISSING;
        }
        
        $id=null;
        $naglowek= filter_input(INPUT_POST, 'naglowek', FILTER_SANITIZE_SPECIAL_CHARS);
        $tresc= filter_input(INPUT_POST, 'tresc', FILTER_SANITIZE_SPECIAL_CHARS);
        
        if($action=='edit'){
            if(!$this->chcekNewsEditRights($id)){
                return NO_ADMIN_RIGHTS;
            }
            $query="UPDATE news SET naglowek='$naglowek', tresc='$tresc' WHERE id=$id";
        }
        else{
            if($id>0){
                $query="SELECT id FROM news WHERE id=$id";
                if($this->getQuerySingleResult($query) !== false){
                    return 200;
                }
            }
            $userId=$_SESSION['id'];
            $query="INSERT INTO news VALUES(NULL,$userId,'$naglowek','$tresc',NOW())";
        }
        
        if($this->dbo->query($query)){
            return OK;
        }
        else {
            return ERROR;
        }
        
        
        
    }
}
