<?php //if(!isset($this)) die();?>
<div class="forms" id="editNewsForm">
    <form action="index.php?action=editNews&amp;wtd=<?=$wtd?>" method="POST">
        <table>
            <tr>
                <td>Nagłówek</td>
                <td class='editNewsForm'><input type="text" name="naglowek" size="40" value="<?=$naglowek?>"></td>
            </tr><tr>
                <td>Treść</td>
                <td class='editNewsForm'><textarea name="tresc" cols="40" rows="5"><?=$tresc?></textarea></td>
            </tr><tr>
                <td>
                <?php if($wtd=='modifyNews'):?>
            <a href="index.php?action=news&amp;wtd=deleteNews&amp;id=<?=$id?>">Usuń</a>
                </td>
                <?php endif;?>
                <td class='editNewsForm'
                    <?php if($wtd=="addNews"):?> colspan='2' <?php endif;?>>
                    <input type="submit" value="Zapisz">
                </td>
            </tr>
        </table>
    </form>
    
</div>

