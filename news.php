<?php

if(isset($_GET['action'])){
    if($_GET['action']=='sNewsList'){
        header("Location:index.php?action=showNewsList");
   }
    else if($_GET['action']=='aNews'){
        header("Location:index.php?action=addNews");
    }
}
