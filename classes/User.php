<?php

class User {
    
    private $email;
    private $passwordHashed;
    private $alias;

    public function getEmail() {
        return $this->email;
    }

    public function getPassword() {
        return $this->password;
    }

    public function getAlias() {
        return $this->alias;
    }

    public function setEmail($email) {
        
        global $conn;
        
        $sql="SELECT `email` FROM `Users` WHERE email = '$email'";
        $result = $conn->query($sql);
        if ($result->num_rows == 0) {
            $this->email = $email;
            return true;
        } else {
            return false;
        }
    }

    public function setPassword($password, $password2) {
        if ($password === $password2){
            $this->passwordHashed = sha1($password);
        }
    }

    public function setAlias($alias) {
        $this->alias = $alias;
    }

    public function register($email, $password, $password2){
        
        global $conn;

        if (!$this->setEmail($email)){
            header("Location: register.php?duplicateEmail=1");
            die();
        }
        
        $this->setPassword($password, $password2);

        $sql = "INSERT INTO Users(`email`,`password`) VALUES ('$this->email','$this->passwordHashed')";
        $conn->query($sql);
        
        header("Location: home.php?firstTime=1");        
        
    }
    
    public function login($email, $passwordHashed){
        
        global $conn;
        
        $sql = "SELECT `email`, `password` FROM `Users` WHERE email = '$email'";
        $result = $conn->query($sql);

        if ($email === $result->fetch_assoc()['email'] && $passwordHashed === $result->fetch_assoc()['password']){
            
            $_SESSION['email'] = $email;
            $_SESSION['$password'] = $passwordHashed;
            
        } else {
            header("Location: log_in.php?userOrPasswordNotFound=1");    
        }
    }
    
    public function autoLogin(){
        if ($this->isLogged()){
            $this->login($_SESSION['email'],$_SESSION['$password']);
       }
    }
    
    public function logout(){
        $_SESSION['email'] = null;
        $_SESSION['$password'] = null;
        
        session_destroy();
    }
    
    public function isLogged(){
        if (isset($_SESSION['email'])){
            return !!$_SESSION['email'];
        }
    }
    
    private function loadFromDB(){
        
    }
    
    public function getMyPosts(){
        
    }
    
    public function getMyMessages(){
        
    }
    
    
    public function deleteUser() {
        
    }
    
//    public function addPost(){
//        
//    }
//    
//    public function addComment(){
//        
//    }
//    
//    public function sendMessage(){
//        
//    }
}
