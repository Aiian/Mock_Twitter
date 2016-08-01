<?php

$conn = new mysqli('localhost', 'root', 'coderslab', 'mockTwitter_db');
    
if ($conn->connect_error) {
    die("Polaczenie nieudane. Blad: " . $conn->connect_error);
}

require_once './classes/User.php';
require_once './functions/simpleGETecho.php';

$user = new User();

session_start();
$user->logout();

