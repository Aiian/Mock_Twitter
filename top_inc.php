<?php

$conn = new mysqli('localhost', 'root', 'coderslab', 'mockTwitter_db');
    
if ($conn->connect_error) {
    die("Polaczenie nieudane. Blad: " . $conn->connect_error);
}

require_once './classes/User.php';

if (!isset($_SESSION)) session_start();

$user = new User();
$user->autoLogin();