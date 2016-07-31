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
            if (isset($_GET['postId'])){
                global $conn;
                $postId = $conn->escape_string($_GET['postId']);
                $post->loadFromDB($postId);
                $post->show();
            }
        }
        ?>
    </body>
</html>
