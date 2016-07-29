<?php

class Post {
   
    private $id;
    private $userId;
    private $body;
    
    public function __construct() {
        $this->id = -1;
        $this->userId = null;
        $this->body = null;
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

    public function loadFromDB() {
        
    }
    
    public function create() {
        
    }
    
    public function update() {
        
    }
    
    public function show() {
        
    }
    
    
    
    
    
    
    
    
}
