<?php //if(!isset($portal)) die();?>

<div id="newsListDiv">
    <table>
        <tr>
            <th>Nagłówek</th><th>Data</th><th>Autor</th>
        </tr>
        <?php while($row=$news->fetch_row()):?>
        <tr>
            <td><a href="index.php?action=showNews&amp;newsId=<?=$row[0]?>">
                <?=$row[1]?></a></td>
            <td><?=$row[2]?></td>
            <td><?=$row[3]?></td>
            
        </tr>
        <?php endwhile; ?>
        
    </table>
    <div class="paginationDiv">
        <?=$this->getPagination($page, $pages, 'index.php?action=showNewsList', 'Idź do strony');?>
        
    </div>
</div>


