<?php //if(!isset($portal)) die(); ?>

<?php while($row=$newsHeader->fetch_row()): 
    //var_dump($row);
    ?>
<div class="newsHeaderDiv">
    <?=$row[1]?>
    <a href="index.php?action=showNews&amp;newsId=<?=row[0]?>"
       >więcej</a>
</div>
<?php endwhile; ?>


