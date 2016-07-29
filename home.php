 <?php
 
require_once './top_inc.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    if (isset($_POST['email']) && isset($_POST['password'])){

        $email = $conn->escape_string($_POST['email']);
        $passwordHashed = sha1($conn->escape_string($_POST['password']));

        $user->login($email,$passwordHashed);
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
       
    </body>
</html>
