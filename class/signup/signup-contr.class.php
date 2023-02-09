
<?php

class SignupContr extends Signup
{
    private $uid;
    private $pwd;
    private $password;
    private $email;

    public function __construct($uid, $pwd, $password, $email){
        $this->uid = $uid;
        $this->pwd = $pwd;
        $this->password = $password;
        $this->email = $email;
    }
    private function emptyInputs(){
        $result;
        if (empty($this->uid) || empty($this->pwd) || empty($this->password) || empty($this->email)) {
            $result = false;
            # code...false because the fields will be empty;
        }
        else {
            $result = true;
            #code.... true because the fields will not be empty;
        }
        return $result;
    }
    private function passwordMatch(){
        $result;
        if ($this->pwd !== $this->password) {
            $result = false;
        } else {
            $result = true;
        }
        return $result;
        
    }
    private function usernameAlreadyRegistered(){
        $result;
        if (!$this->checkUser($this->uid, $this->email)) {
            $result = false;
        }else {
            $result = true;
        }
        return $result;
    }
    private function invalidEmail(){
        $result;
        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $result = false;
        } else {
            $result = true;
        }
        return $result;   
    }
    public function setUser(){
        if ($this->usernameAlreadyRegistered() == false) {
            header("location: ../login.php?error=userExist");
            exit();
            # code... username already exist;
        }
        if ($this->passwordMatch() == false) {
            header("location: ../index.php?error=passwordMismatch");
            exit();
        }
        else {
            if ($this->emptyInputs() == false){
                header("location: ../index.php?error=fields are empty");
                exit();
            }
            if ($this->invalidEmail() == false) {
                header("location: ../index.php?error=inavlid email address");
                exit();
            }
        }
        $this->registerUser($this->uid, $this->pwd, $this->email);
        
    }
    
}    
