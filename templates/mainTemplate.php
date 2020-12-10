<?php //if(isset($portal)) die();?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Strona główna</title>
        <link rel="Stylesheet" type="text/css" href="CSS/style.css" />
    </head>
    <body>
        <div id="header" class="obrys">
            <div id="naglowek">
                <a href="index.php">Główna</a>
                <a href="index.php?action=sNewsList">Lista Nowości</a>
                <?php if($portal->zalogowany):?>
                <a href="index.php?action=aNews">Dodaj news'a</a>
                    <?php endif; ?>
            </div>
            <div id="info">
            <?php if($portal->zalogowany):?>
                <div>
                    Jesteś zalogowany jako: <?=$portal->zalogowany?>
                   <?php //var_dump($_SESSION['id']);?>
                </div>
                <div>
                    <a href="index.php?action=logout">Wylogowanie</a>
                </div>
                <?php else: ?>
                <div> 
                    Nie jesteś zalogowany.
                </div>
                <div>
                    <a href="index.php?action=showLoginForm">Logowanie</a>
                </div>
                <div>
                    <a href="index.php?action=showRegForm">Rejstracja</a>
                </div>
                <?php endif ?>
            </div>
        </div>
        
        <div id="srodek" class="obrys">
            <div id="main">
            <?php
            switch ($action):
                case 'showLoginForm':
                include 'templates/loginForm.php';
                break;
                case 'showRegForm':
                include 'templates/regForm.php';
                break;
                case 'showNewsList':
                     $portal->showNewsList(ROWS_ON_PAGE);
                    if(isset($_GET['page'])){
                        $p=$_GET['page'];
                    }
                    else{
                        $p=0;
                    }
                    $_SESSION['page']=$p;
                    //echo $page;
                    //include 'templates/newsTemplate.php';
                break;
                case 'showNews' :
                    $news=$portal->getNews();
                    include 'templates/singleNewsTemplate.php';
                    
                    break;
                case 'addNews' :
                    //echo '1';
                    //var_dump($action);
                    $portal->showEditForm($action);
                    //include 'templates/newsEditForm.php';
                    break;
                case 'editNews':
                   //$wtd=$_GET['wtd'];
                    $portal->editNews($action, $id);
                    break;
                case 'showMain' :
                default :
                include 'templates/innerContentDiv.php';
            endswitch;
            ?>
               </div>
            <div id="panelPrawy">
                <div>
                    <div class="header">
                        Nowości
                    </div>
                    <div class="content">
                        <?php if($newsHeader){
                        include'templates/newsHeaders.php';
                        
                        }
                            else {
                                echo "brak nowości";
                            }
                        ?>
                    </div>
                </div>
            </div> 
        </div>
        <div id="stopka" class="obrys">
            
        </div>
    </body>
</html>
