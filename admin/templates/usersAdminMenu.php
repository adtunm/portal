<?php //if(!isset($portal)) die(); ?>
<div id="usersAdminMenu">
    <a href="index.php?action=usersAdmin&amp;wtd=showList">Lista</a>
    <a href="index.php?action=usersAdmin&amp;wtd=showSchearchForm">Szukaj</a>
    <a href="index.php?action=usersAdmin&amp;wtd=showAddForm">Dodaj</a>
</div>
<?php if($komunikat_adm): ?>
<div class="komunikat"><?=$komunikat_adm?></div>
<?php endif; ?>



