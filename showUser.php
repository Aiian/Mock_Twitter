<?php
require_once './top_inc.php';

if (isset($_GET['userId'])){
    $userId = $conn->escape_string($_GET['userId']);
    $user->loadFromDB($userId);
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
        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            if (isset($_POST['newMessage'])){

                $newMessageBody = $conn->escape_string($_POST['newMessage']);
                $receiverId = $userId;

                $message->create($receiverId, $newMessageBody);
                $message->update();

                echo "<h3>Message sent.</h3>";
            }
        }
?>
        <div>
            <form class="" method="post" action="">
            <fieldset>
                <legend>SEND MESSAGE TO <?php echo $user->showMyName(); ?></legend>
                    <label>Your Message</label><br>
                    <input name="newMessage" type="text"  /><br>
                    <button type="submit" name="submit" value="login">SEND</button>
            </fieldset>
            </form>
        </div>
<?php
            echo "<h3>Posts by: " . $user->showMyName() . "</h3>";
            $user->getMyPosts();
?>

    </body>
</html>
