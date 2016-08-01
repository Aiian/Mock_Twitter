<?php
require_once './top_inc.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    if (isset($_POST['newComment'])){
        $newComment = $conn->escape_string($_POST['newComment']);
        $comment->create($newComment);
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
        
        if (isset($_GET['postId'])){
            global $conn;
            $postId = $conn->escape_string($_GET['postId']);
            $post->loadFromDB($postId);
            $post->show();
        }
        
        ?>
        <div>
            <form class="" method="post" action="">
            <fieldset>
                <legend>GIVE YOUR OWN COMMENT</legend>
                    <label></label><br>
                    <input name="newComment" type="text" maxlength="60" value=""/><br>
                    <button type="submit" name="submit" value="login">COMMENT</button>
            </fieldset>
            </form>
        </div>
        <?php
       
        if (isset($_GET['postId'])){
            global $conn;
            $postId = $conn->escape_string($_GET['postId']);
            $post->loadAllComments();
        }

        ?>
    </body>
</html>
