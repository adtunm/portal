<?php if(!isset($portal)) die();?>
<div id="loginFormWrapper">
    <div class="komunikat">
        <?php
        if($komunikat):
            echo $komunikat;
        else:?>
        Wprowadź nazwe i hasło uzytkownika:
        
        <?php endif;?>
        <?php// echo $_SESSION['blad'];?>
        
    </div>
    <form action="index.php?action=login" method="POST">
                <table>
                    <tr>
                        <td>Użytkownik:</td>
                        <td><input type="text" name="user"></td>
                        
                    </tr><tr>
                        <td>
                            Hasło:
                        </td><td><input type="password" name="haslo"></td>
                    </tr><tr>
                        <td><a href="index.php?action=reg">Rejstracja</a></td>
                        <td style="text-align: right;">
                            <input type="submit" value="Wejdź">
                        </td>
                    </tr>
                </table>
            </form>
</div>



