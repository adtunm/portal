<?php //if(isset($portal)) die();?>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Panel Admina</title>
        <link rel="Stylesheet" type="text/css" href="CSS/style.css" />
    </head>
    <body>
        <div id="header" class="obrys">
            <div id="naglowek">
                Funkcje:
                <span class='headerLinks'>
                    <a href='index.php?action=usersAdmin'>Zarządzanie użytkownikami</a>
                    
                </span>
            </div>
            <div id="info">
            <?php if($portal->zalogowany_adm && isset($_SESSION['przywileje'][1])):?>
                <div>
                    Jesteś zalogowany jako: <?=$portal->zalogowany?>
                </div>
                <div>
                    <a href="index.php?action=logout">Wylogowanie</a>
                </div>
                <?php else: ?>
                
                <?php endif ?>
            </div>
        </div>
        
        <div  class="obrys">
            <div id="main">
            <?php
            switch ($action) :
                case 'showLoginForm' :
                    include 'LoginForm.php';
                    break;
                case 'usersAdmin' :
                    include 'usersAdminMenu.php';
                    $portal->usersAdmin();
                    break;
                case 'showMainAdmin':
                default :
                ?>
            <p> Wybierz funkcje administracyjną z menu.</p>
            <?php
            endswitch;
            ?>
            </div>
            <div id="panelPrawy">
                
            </div>
        </div>
        <div id="stopka" class="obrys">
            
        </div>
    </body>
</html>
