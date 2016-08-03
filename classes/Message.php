<?php

class Message {
   
    private $id;
    private $senderId;
    private $receiverId;
    private $body;
    private $date;
    private $read;
    private $string;

    public function __construct() {
        $this->id = -1;
        $this->setsenderId(null);
        $this->setReceiverId(null);
        $this->setBody(null);
        $this->setDate(null);
        $this->setRead(null);
        $this->setString(null);
    }
    
    
    
    function getId() {
        return $this->id;
    }

    function getSenderId() {
        return $this->senderId;
    }

    function getReceiverId() {
        return $this->receiverId;
    }

    function getBody() {
        return $this->body;
    }

    function getDate() {
        return $this->date;
    }

    function getRead() {
        return $this->read;
    }

    function getString() {
        return $this->string;
    }
        
    function setId($id) {
        $this->id = $id;
    }

    function setSenderId($senderId) {
        $this->senderId = $senderId;
    }

    function setReceiverId($receiverId) {
        $this->receiverId = $receiverId;
    }

    function setBody($body) {
        $this->body = $body;
    }

    function setDate($date) {
        $this->date = $date;
    }

    function setRead($read) {
        $this->read = $read;
    }
                
    function setString($string) {
        $this->string = $string;
    }

    public function loadFromDB($id) {
        global $conn;

        $sql = "SELECT message_id, sender_id, receiver_id, message_body, message_date, message_string FROM `Messages` WHERE message_id=$id AND (receiver_id = " . $_SESSION['id'] . " OR sender_id = " . $_SESSION['id'] . ")";
        $result = $conn->query($sql);
        $messageDataArray = $result->fetch_assoc();
        
        $this->setId($messageDataArray['message_id']);
        $this->setSenderId($messageDataArray['sender_id']);
        $this->setReceiverId($messageDataArray['receiver_id']);
        $this->setBody($messageDataArray['message_body']);
        $this->setDate($messageDataArray['message_date']);
        $this->setString($messageDataArray['message_string']);
     
        $_SESSION['message_id'] = $this->getId();
        
        }

    
    public function create($receiverId, $body, $string = 0) {
        
        $this->setsenderId($_SESSION['id']);
        $this->setReceiverId($receiverId);
        $this->setBody($body);
        $this->setDate(date("Y-m-d"));
        $this->setRead(0);
        $this->setString($string);
 
    }
    
    public function update() {
        
         global $conn;
        
        $sql = "INSERT INTO `Messages`(sender_id, receiver_id, message_body, message_date, message_string) VALUES (" . $this->getSenderId() . ", " . $this->getReceiverId() . ", '" . $this->getBody() ."', '" . $this->getDate() . "', " . $this->getString() . ")";
        $conn->query($sql);
    }
    
    public function showMessageString($string = 0) {

        
        
        if ($string == 0){
            $this->show();
        } else {
        
            
        }
       
    }
    
    private function show(){
        
        global $conn;
        
        if ($this->getSenderId() == $_SESSION['id']){
            
            $sql="SELECT email FROM `Messages` JOIN `Users` ON Users.id=Messages.receiver_id WHERE message_id= " . $this->getId();
                $result = $conn->query($sql);
                $email = $result->fetch_assoc()['email'];

                echo "<h3>Message sent by You on " . $this->getDate() . " to $email</h3>";
                echo "<p>" . $this->getBody() . "</p>";
                
        } elseif ($this->getReceiverId() == $_SESSION['id']){
            
           $sql="SELECT email FROM `Messages` JOIN `Users` ON Users.id=Messages.sender_id WHERE message_id= " . $this->getId();
                $result = $conn->query($sql);
                $email = $result->fetch_assoc()['email'];

                echo "<h3>Message sent to You on " . $this->getDate() . " by $email</h3>";
                echo "<p>" . $this->getBody() . "</p>";
                
            $sql2 = "UPDATE `Messages` SET `read` = 1 WHERE message_id = " . $this->getId();
            $conn->query($sql2);
                
        } else {
             echo "<h1>Unable to get message from Server. Please try again.</h1>";
        }
        
        
    }
}
