<?php

$conn = new mysqli('localhost', 'root', 'coderslab', 'mockTwitter_db');
    
if ($conn->connect_error) {
    die("Polaczenie nieudane. Blad: " . $conn->connect_error);
}

require_once './classes/User.php';
require_once './classes/Post.php';
require_once './classes/Comment.php';
require_once './functions/simpleGETecho.php';

session_start();

$user = new User();
$post = new Post();
$comment = new Comment();
$user->autoLogin();