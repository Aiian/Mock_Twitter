<?php
require_once './top_inc.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['submitEmail'])){
    if (isset($_POST['email']) && !empty($_POST['email'])){

        $email = $conn->escape_string($_POST['email']);
        $user->changeEmail($email);
    }
}
    
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['submitPassword'])){
    if (isset($_POST['password']) && isset($_POST['password2']) && !empty($_POST['password']) && !empty($_POST['password2'])){
        
        $password = $conn->escape_string($_POST['password']);
        $password2 = $conn->escape_string($_POST['password2']);
        
        $user->changePassword($password, $password2); 
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
        <form class="" method="post" action="">
        <fieldset>
            <legend>CHANGE YOUR E-MAIL</legend>
                <label>New E-Mail</label><br>
                <input name="email" type="text" maxlength="50" value=""/><br>
                <button type="submit" name="submitEmail" value="login">CHANGE</button>
        </fieldset>
        </form>
    </div>
    <div>
        <form class="" method="post" action="">
        <fieldset>
            <legend>CHANGE YOUR PASSWORD</legend>
                <label>New Password (min. 8 char.)</label><br>
                <input name="password" type="password" maxlength="30" value=""/><br>
                <label>Repeat Password please</label><br>
                <input name="password2" type="password" maxlength="30" value=""/><br>
                <button type="submit" name="submitPassword" value="login">CHANGE</button>
        </fieldset>
        </form>
    </div>
    </body>
</html>
