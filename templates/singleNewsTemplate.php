<?php if(!isset($portal)) die ();?>

<div class="newsDiv">
    <?php if($news): ?>
        <table>
        <tr>
            <td>Nagłówek</td><td><?=$news[0]?></td>
        </tr><tr>
            <td>Data</td><td><?=$news[2]?></td>
        </tr><tr>
            <td>Autor</td><td><?=$news[3]?></td>
        </tr><tr>
            <td>Treść</td><td><?=$news[1]?></td>
        </tr>
        <?php var_dump((int)$_SESSION['id'])?>
        <?php if((int)$news[4] == (int)$_SESSION['id']):?>
        <tr><td><a href="index.php?action=editNews&amp;id=<?=$_GET['newsId']?>">Edytuj</a></td></tr>
        <?php endif;?>
        
        <?php $i=(int)$_SESSION['page'];
        //echo $i;?>
        <tr><td colspan="2"><a href="index.php?action=showNewsList&page=<?=$i;?>">Powrót do listy news'ów</a></td></tr>
        </table>
    <?php else: ?>
    Brak Danych
    <?php endif; ?>
</div>



