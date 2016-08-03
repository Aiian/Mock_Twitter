<?php
require_once './top_inc.php';
?>




<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
  
    </head>
    <body>
        <?php
       
            if (isset($_GET['messageId'])){
                global $conn;
                $messageId = $conn->escape_string($_GET['messageId']);
                $message->loadFromDB($messageId);
                $message->showMessageString();
            }
        ?>
    </body>
</html>
