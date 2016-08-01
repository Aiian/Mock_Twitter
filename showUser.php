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
                if (isset($_GET['userId'])){
                    global $conn;
                    $userId = $conn->escape_string($_GET['userId']);
                    $user->loadFromDB($userId);
                    echo "<h3>Posts by: " . $user->showMyName() . "</h3>";
                    $user->getMyPosts();
                }
            }
        ?>

    </body>
</html>
