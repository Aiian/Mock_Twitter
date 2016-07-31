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

        $sql = "INSERT INTO Users(`email`,`password`) VALUES ('$this->email','$this->passwordHashed')";
        $conn->query($sql);

        $this->login($this->email, $this->passwordHashed);

        header("Location: home.php?firstTime=1");        
        
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
                echo "</a>";
            }
        }
    }
    
    public function getMyMessages(){
        
    }
    
    
    public function deleteUser() {
        
    }

    public function showRandUsers($numToShow){
        
        global $conn;
    $sql = "SELECT id, email FROM `Users` WHERE email NOT IN ('" . $_SESSION['email'] . "') ORDER BY RAND() LIMIT " . $numToShow;
        $result = $conn->query($sql);
        $userArray = [];
        foreach ($result as $row){
            echo "<a href='./showUser.php?userId=" . $row['id'] . "'>Check what's up with " . $row['email'] . "</a><br>";
        }
    }
}
