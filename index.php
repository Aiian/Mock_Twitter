 <?php
 
require_once './top_inc.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    if (isset($_POST['newPost'])){
        $newPost = $conn->escape_string($_POST['newPost']);
        $post->create($newPost);
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
                $user->loadFromDB();
                if (isset($_GET['firstTime'])){
                    if ($_GET['firstTime'] == 1){
                        echo "<h3>Nice to see you " . $user->showMyName() . " for the first time. Let's have some fun at Mock_Twitter!</h3>";
                    } else {
                        echo "<h3>Nice to see you " . $user->showMyName() . " again. Let's have some fun at Mock_Twitter!</h3>";
                    }
                }
            }
 
        $user->showRandUsers(5);
        ?>
        <div>
            <ol>MENU
                <li><a href="editUser.php">Change your info</a></li>
                <li><a href="log_in.php?logout=1">Log out</a></li>
                <li><a href="showMessages.php">Messages</a></li>
            </ol>
        </div>
        
       <div>
            <form class="" method="post" action="">
            <fieldset>
                <legend>CREATE NEW POST</legend>
                    <label>Your thoughts</label><br>
                    <input name="newPost" type="text" maxlength="140" /><br>
                    <button type="submit" name="submit" value="login">PUBLISH</button>
            </fieldset>
            </form>
        </div>
        <?php
            $user->loadFromDB();
            $user->getMyPosts();
        ?>
    </body>
</html>
