<?php

class Post {
   
    private $id;
    private $userId;
    private $body;
    private $date;
    
    public function __construct() {
        $this->id = -1;
        $this->setUserId(null);
        $this->setBody(null);
    }

    public function getId() {
        return $this->id;
    }

    public function getUserId() {
        return $this->userId;
    }

    public function getBody() {
        return $this->body;
    }

    public function setUserId($userId) {
        $this->userId = $userId;
    }

    public function setBody($body) {
        $this->body = $body;
    }

    public function getDate() {
        return $this->date;
    }

    public function setDate($date) {
        $this->date = $date;
    }

    function setId($id) {
        $this->id = $id;
    }
            
    public function loadFromDB($id) {
        global $conn;

        $sql = "SELECT post_id, user_id, post_body, date FROM `Posts` WHERE post_id=$id";
        $result = $conn->query($sql);
        $postDataArray = $result->fetch_assoc();
        
        $this->setId($postDataArray['post_id']);
        $this->setBody($postDataArray['post_body']);
        $this->setDate($postDataArray['date']);
        $this->setUserId($postDataArray['user_id']);
        
        $_SESSION['post_id'] = $this->getId();
        }

    
    public function create($body) {
        
        global $conn;
        
        $this->setBody($body);
        $this->setUserId($_SESSION['id']);
        $sql = "INSERT INTO `Posts`(user_id, post_body, date) VALUES (" . $this->getUserId() . ", '" . $this->getBody() . "', NOW())";
        $conn->query($sql);
    }
    
    public function update() {
        
    }
    
    public function show() {
        $currentUserName = "";
        if ($this->getUserId() == $_SESSION['id']){
            $currentUserName = "You";
        } else {
            global $conn;
            $sql="SELECT email FROM `Posts` JOIN `Users` ON Users.id=Posts.user_id WHERE user_id=" . $this->getUserId();
            $result = $conn->query($sql);
            $currentUserName = $result->fetch_assoc()['email'];
        }
        
        echo "<h3>Post by $currentUserName from " . $this->getDate() . "</h3>";
        echo "<p>" . $this->getBody() . "</p>";
    }
    
    public function loadAllComments(){
        global $conn;
        $sql = "SELECT `email`, `comment_body`, `comment_date` FROM `Posts` JOIN `Comments` ON Posts.post_id=Comments.post_id JOIN `Users` ON Comments.user_id=Users.id WHERE Posts.post_id = " . $this->getId();
        $result =$conn->query($sql);
        foreach ($result as $comment){
            echo "<h5>Comment by " . $comment['email'] . " from " . $comment['comment_date'] . "</h5>";
            echo "<p>" . $comment['comment_body'] . "</p>";
        }
    }
    
    
    
    
    
    
}
