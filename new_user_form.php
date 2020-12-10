<html>
    <head>
        <meta charset="UTF-8">
        <title>Rejstracja Użytkownika</title>
        <script type="text/javascript">
            function sprawdz(){
                var f= document.forms.formularz1;        
                f.submit();
    }
            </script>
    </head>
    <body>
        <h2>Wprowadź dane rejstracyjne:</h2>
        <form name="formularz1" action="add_new_user.php" method="post">
            
            <table>
                <tr>
                    <td>
                        Nazwa Użytkownuka:
                    </td>
                    <td>
                        <input type="text" name="nazwa">
                    </td>
                </tr>
                <tr>
                    <td>
                        Hasło:
                    </td>
                    <td>
                        <input type="password" name="haslo">
                    </td>
                </tr>
                <tr>
                    <td>
                        Powórz hasło:
                    </td>
                    <td>
                        <input type="password" name="haslo2">
                    </td>
                </tr>
                <tr>
                    <td>
                       Imie:
                    </td>
                    <td>
                        <input type="text" name="imie">
                    </td>
                </tr>
                <tr>
                    <td>
                        Nazwisko:
                    </td>
                    <td>
                        <input type="text" name="nazwisko">
                    </td>
                </tr>
                <tr>
                    <td>
                        Mail:
                    </td>
                    <td>
                        <input type="text" name="email">
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="text-align: right;">
                        <input type="submit" value="Rejstracja">
                    </td>
                </tr>
            </table>
        </form>
    </body>
</html>
