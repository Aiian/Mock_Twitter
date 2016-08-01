<?php

class Comment {
   
    private $id;
    private $userId;
    private $postId;
    private $body;
    private $date;
    
    public function __construct() {
        $this->id = -1;
        $this->setUserId(null);
        $this->setPostId(null);
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

    public function getPostId() {
        return $this->postId;
    }

    public function setUserId($userId) {
        $this->userId = $userId;
    }

    public function setBody($body) {
        $this->body = $body;
    }

    function setPostId($postId) {
        $this->postId = $postId;
    }
        
    public function getDate() {
        return $this->date;
    }

    public function setDate($date) {
        $this->date = $date;
    }

        
    public function loadFromDB($id) {
        global $conn;

        $sql = "SELECT user_id, post_id, comment_body, comment_date FROM `Comments` WHERE comment_id=$id";
        $result = $conn->query($sql);
        $commentDataArray = $result->fetch_assoc();
        
        $this->setBody($commentDataArray['comment_body']);
        $this->setDate($commentDataArray['comment_date']);
        $this->setUserId($commentDataArray['user_id']);
        $this->setPostId($commentDataArray['post_id']);
        
        }

    
    public function create($body) {
        
        global $conn;
        
        $this->setBody($body);
        $this->setUserId($_SESSION['id']);
        $this->setPostId($_SESSION['post_id']);
        $sql = "INSERT INTO `Comments`(user_id, post_id, comment_body, comment_date) VALUES (" . $this->getUserId() . ", ". $this->getPostId() . ", '" . $this->getBody() . "', NOW())";
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
    
    
    
    
    
    
    
    
}
