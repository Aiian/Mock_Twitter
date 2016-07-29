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
        <div>
            <form class="" method="post" action="home.php">
            <fieldset>
                <legend>LOG IN</legend>
                    <label>E-Mail</label><br>
                    <input name="email" type="text" maxlength="50" value=""/><br>
                    <label>Password</label><br>
                    <input name="password" type="password" maxlength="30" value=""/><br>
                    <button type="submit" name="submit" value="login">LOG IN</button>
            </fieldset>
            </form>
        </div>
        <a href="register.php">Not a part of Mock_Twitter yet? Register!</a>
        
        
        
        <?php
        // put your code here
        ?>
    </body>
</html>
