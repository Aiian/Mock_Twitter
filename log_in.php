<?php
require_once './top_inc.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    if (isset($_POST['email']) && isset($_POST['password']) && isset($_POST['password2'])){

        $email = $conn->escape_string($_POST['email']);
        $password = $conn->escape_string($_POST['password']);
        $password2 = $conn->escape_string($_POST['password2']);

        $user->register($email, $password, $password2);
    }
}
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
                if (isset($_GET['userOrPasswordNotFound'])){
                    if ($_GET['userOrPasswordNotFound'] == 1){
                        echo "<h3>Wrong e-mail or password. Please try again.</h3>";
                    }
                }
            }
        ?>
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
