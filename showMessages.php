<?php
require_once './top_inc.php';
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link rel="stylesheet" type="text/css" href="./css/style.css">
    </head>
    <body>
        <?php
           $user->getReceivedMessages();
           $user->getSentMessages();
        ?>
    </body>
</html>
