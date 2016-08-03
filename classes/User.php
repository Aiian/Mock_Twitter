<?php

class User {
    
    private $id;
    private $email;
    private $passwordHashed;
    private $alias;
    
    private $emailValid = 0;
    private $passwordValid = 0;

    
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getAlias() {
        return $this->alias;
    }

    public function setEmail($email) {
        
        global $conn;
        
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->setEmailValid();
            $sql="SELECT `email` FROM `Users` WHERE email = '$email'";
            $result = $conn->query($sql);
            if ($result->num_rows == 0) {
                $this->email = $email;
                return true;
            } else {
                return false;
            }
        } else {
            $this->setEmailInvalid();
            return false;
        }
    }

    public function setPassword($password, $password2) {
        if (strlen($password) >= 8){
            $this->setPasswordValid();
            if ($password === $password2){
                    $this->passwordHashed = sha1($password);
                    return true;
            } else {
                return false;    
            }  
        } else {
            $this->setPasswordInvalid();
            return false;
        }
    }

    public function setAlias($alias) {
        $this->alias = $alias;
    }

    public function setEmailValid() {
        $this->emailValid = 1;
    }
    
    public function setEmailInvalid() {
        $this->emailValid = 0;
    }
    
    function getEmailValid() {
        return $this->emailValid;
    }
        
    function setPasswordValid() {
        $this->passwordValid = 1;
    }
    
    function setPasswordInvalid() {
        $this->passwordValid = 0;
    }

    public function getPasswordValid() {
        return $this->passwordValid;
    }

    function getPasswordHashed() {
        return $this->passwordHashed;
    }
        
    public function register($email, $password, $password2){

        global $conn;

        if (!$this->setEmail($email) && $this->getEmailValid()){
            header("Location: register.php?duplicateEmail=1");
            die();
        } elseif (!$this->setEmail($email)){
            header("Location: register.php?wrongEmail=1");
            die();
        }

        if (!$this->setPassword($password, $password2) && $this->getPasswordValid()){
            header("Location: register.php?passwordsNotEqual=1");
            die();
        } elseif (!$this->setPassword($password, $password2)){
            header("Location: register.php?passwordNotValid=1");
            die();
        }

        $sql = "INSERT INTO Users(`email`,`password`) VALUES ('$this->getEmail()','$this->getPasswordHashed()')";
        $conn->query($sql);

        $this->login($this->getEmail(), $this->getPasswordHashed());

        header("Location: index.php?firstTime=1");        
        
    }
    
    public function changeEmail($email){

        global $conn;

        if (!$this->setEmail($email) && $this->getEmailValid()){
            header("Location: editUser.php?duplicateEmail=1");
            die();
        } elseif (!$this->setEmail($email)){
            header("Location: editUser.php?wrongEmail=1");
            die();
        }

        $sql = "UPDATE Users SET email = '" . $this->getEmail() . "' WHERE email= '" . $_SESSION['email'] . "'";
        $conn->query($sql);

        $this->login($this->getEmail(), $_SESSION['password']);

        header("Location: editUser.php?success=1");        
        
    }
    
    public function changePassword($password, $password2){

        global $conn;

        if (!$this->setPassword($password, $password2) && $this->getPasswordValid()){
            header("Location: editUser.php?passwordsNotEqual=1");
            die();
        } elseif (!$this->setPassword($password, $password2)){
            header("Location: editUser.php?passwordNotValid=1");
            die();
        }

        $sql = "UPDATE Users SET password ='" . $this->getPasswordHashed() . "' WHERE email= '" . $_SESSION['email'] . "'";
        $conn->query($sql);

        $this->login($_SESSION['email'], $this->getPasswordHashed());

        header("Location: editUser.php?success=1");        
        
    }
    
    public function login($email, $passwordHashed){
        
        global $conn;
        
        $sql = "SELECT `email`, `password`, `id` FROM `Users` WHERE email = '$email'";
        $result = $conn->query($sql);
        $checkArray = $result->fetch_assoc();
        
        if ($email === $checkArray['email'] && $passwordHashed === $checkArray['password']){
            
            $_SESSION['email'] = $email;
            $_SESSION['password'] = $passwordHashed;
            $_SESSION['id'] = $checkArray['id'];

            return true;
            
        } else {
            
            header("Location: log_in.php?userOrPasswordNotFound=1");
            return false;
        }
    }
    
    public function autoLogin(){
        if ($this->isLogged()){
            $this->login($_SESSION['email'],$_SESSION['password']);
       } else {
           header("Location: log_in.php"); 
       }
    }
    
    public function logout(){
        if ($this->isLogged()){
            $_SESSION['email'] = null;
            $_SESSION['password'] = null;

        }
    }
    
    public function isLogged(){
        if (isset($_SESSION['email'])){
            return true;
        }
    }
    
    public function loadFromDB($id = null){
        
        isset($id) ? $this->setId($id) : $this->setId($_SESSION['id']);
        
    }
    
    public function getMyPosts(){
        
        global $conn;
        $sql ="SELECT `post_id`, `post_body`, `date` FROM `Users` JOIN `Posts` ON Users.id=Posts.user_id WHERE Users.id = " . $this->getId() . " ORDER BY Posts.date DESC";
        $result = $conn->query($sql);

        if (isset($result)){
            foreach ($result as $post){
            echo "<a href='./showPost.php?postId=" . $post['post_id'] . "' style='border: dotted 1px blue; display: block;'>";
            echo "<h4>Wpis z dnia: " . $post['date'] . "</h4>";
            echo "<p>" . $post['post_body'] . "</p>";
            
            $sql2 = "SELECT `id` FROM `Posts` JOIN `Comments` ON Posts.post_id=Comments.post_id WHERE Posts.post_id = ". $post['post_id'];
            $result2 =$conn->query($sql2);
            echo "<p>Number of comments: " . $result2->num_rows . "</p>";
            echo "</a>";
            }
        }
    }
    
    public function showMyName(){
        global $conn;
        $sql ="SELECT `email` FROM `Users`  WHERE id = " . $this->getId();
        $result = $conn->query($sql);
        return $result->fetch_assoc()['email'];
    }
    
    public function getReceivedMessages(){

        global $conn;
        $sql = "SELECT email, message_id, sender_id, message_body, `read`, message_date, message_string FROM `Messages` JOIN `Users` ON Users.id=Messages.sender_id WHERE receiver_id=" . $_SESSION['id'] . " ORDER BY message_date DESC";
        $result = $conn->query($sql);
        echo "<h2>Messages Received</h2>";
        if (isset($result)){
            foreach ($result as $recMessage){
                
            strlen($recMessage['message_body']) > 30 ? $messageSnap = "<p>" . substr($recMessage['message_body'],0,30) . "...</p>" : $messageSnap = $recMessage['message_body'];  
                
            $recMessage['read'] == 1 ? $read = "class='read'" : $read = "class='unread'";
            
            echo "<a href='./showSingleMessage.php?messageId=" . $recMessage['message_id'] . "' style='border: dotted 1px blue; display: block;'>";
            echo "<h4 $read>Message from " . $recMessage['email'] . " received on " . $recMessage['message_date'] . "</h4>";
            echo $messageSnap;
            echo "</a>";
            }
        }
    }
    
    public function getSentMessages(){
        global $conn;
        $sql = "SELECT email, message_id, sender_id, message_body, message_date, message_string FROM `Messages` JOIN `Users` ON Users.id=Messages.receiver_id WHERE sender_id=" . $_SESSION['id'] . " ORDER BY message_date DESC";
        $result = $conn->query($sql);

        echo "<h2>Messages Sent</h2>";
        if (isset($result)){
            foreach ($result as $sentMessage){
                
            strlen($sentMessage['message_body']) > 30 ? $messageSnap = "<p>" . substr($sentMessage['message_body'],0,30) . "...</p>" : $messageSnap = $sentMessage['message_body'];  

            echo "<a href='./showSingleMessage.php?messageId=" . $sentMessage['message_id'] . "' style='border: dotted 1px blue; display: block;'>";
            echo "<h4>Message to " . $sentMessage['email'] . " sent on " . $sentMessage['message_date'] . "</h4>";
            echo $messageSnap;
            echo "</a>";
            }
        }
    }
    
    public function deleteUser() {
        
    }

    public function showRandUsers($numToShow){
        
        global $conn;
    $sql = "SELECT id, email FROM `Users` WHERE email NOT IN ('" . $_SESSION['email'] . "') ORDER BY RAND() LIMIT " . $numToShow;
        $result = $conn->query($sql);
        foreach ($result as $row){
            echo "<a href='./showUser.php?userId=" . $row['id'] . "'>Check what's up with " . $row['email'] . "</a><br>";
        }
    }
}
