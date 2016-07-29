<?php
require_once './top_inc.php';
?>


<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
            if ($_SERVER['REQUEST_METHOD'] === 'GET'){
                if (isset($_GET['duplicateEmail'])){
                    if ($_GET['duplicateEmail'] == 1){
                        echo "<h3>Given e-mail already exists. Please pick a different one.</h3>";
                    }
                }
            }
        
        ?>
        <div>
            <form class="" method="post" action="log_in.php">
            <fieldset>
                <legend>REGISTER</legend>
                    <label>E-Mail</label><br>
                    <input name="email" type="text" maxlength="50" value=""/><br>
                    <label>Password</label><br>
                    <input name="password" type="password" maxlength="30" value=""/><br>
                    <label>Repeat Password please</label><br>
                    <input name="password2" type="password" maxlength="30" value=""/><br>
                    <button type="submit" name="submit" value="login">REGISTER</button>
            </fieldset>
            </form>
        </div>
        <a href="log_in.php">Already a part of Mock_Twitter? Log in!</a>
    </body>
</html>
