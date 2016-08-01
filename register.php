<?php
require_once './top_inc_no_log.php';

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
                
                echoLine('duplicateEmail', 'Given e-mail already exists. Please pick a different one.');
                echoLine('wrongEmail', 'Given e-mail is incorrect. Please pick an existing one.');
                echoLine('passwordNotValid', 'Password must be at least 8 characters long. Please try again.');
                echoLine('passwordsNotEqual', 'Passwords not equal. Please try again.');
                
            }
        
        ?>
        <div>
            <form class="" method="post" action="register.php">
            <fieldset>
                <legend>REGISTER</legend>
                    <label>E-Mail</label><br>
                    <input name="email" type="text" maxlength="50" value=""/><br>
                    <label>Password (min. 8 char.)</label><br>
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
