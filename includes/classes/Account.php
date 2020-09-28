<?php 

    class Account{

        private $conn;
        private $errArray = array();
        public function __construct($conn) {
            $this->conn = $conn;
        }

        public function updatePassword($oldPwd,$newPwd,$newPwd2,$un){
            $this->validateOldPassword($oldPwd,$un);
            $this->validatePasswords($newPwd,$newPwd2);

            if(empty($this->errArray)){
                $query = $this->conn -> prepare("UPDATE users SET password=:pwd WHERE username=:un");
                $pwd = hash("sha512",$newPwd);
                $query->bindValue(":pwd",$pwd);
                $query->bindValue(":un",$un);
                return $query->execute();
            }
            return false;
        }

        public function validateOldPassword($oldPwd,$un){
            $pwd = hash("sha512",$oldPwd);
        
            $query = $this->conn->prepare("SELECT * FROM users WHERE username=:un AND password=:pwd");
            $query->bindValue(":un",$un);
            $query->bindValue(":pwd",$pwd);

            $query->execute();

            if($query->rowCount() == 0 ){
                array_push($this->errArray,Constants::$passwordIncorrect);
            }
        }

        public function updateDetails($fn,$ln,$em,$un){
            $this->validateFirstName($fn);
            $this->validateLastName($ln);
            $this->validateNewEmail($em,$un);

            if(empty($this->errArray)){
                $query = $this->conn -> prepare("UPDATE users SET firstName=:fn,lastName=:ln,
                                            email=:em WHERE username=:un");
                $query->bindValue(":fn",$fn);
                $query->bindValue(":ln",$ln);
                $query->bindValue(":un",$un);
                $query->bindValue(":em",$em);
                return $query->execute();
            }
            return false;
        }

        public function register($fn, $ln, $un , $em, $em2, $pwd, $pwd2) {
            $this->validateFirstName($fn);
            $this->validateLastName($ln);
            $this->validateUserName($un);
            $this->validateEmails($em, $em2);
            $this->validatePasswords($pwd, $pwd2);

            if(empty($this->errArray)){
                return $this->insertUserDetails($fn, $ln, $un , $em, $pwd);
            }

            return false;
        }

        public function login($un, $pwd){
            $pwd = hash("sha512",$pwd);
        
            $query = $this->conn->prepare("SELECT * FROM users WHERE username=:un AND password=:pwd");
            $query->bindValue(":un",$un);
            $query->bindValue(":pwd",$pwd);

            $query->execute();

            if($query->rowCount() == 1 ){
                return true;
            }

            array_push($this->errArray, Constants::$loginFailed);
            return false;
        }

        private function insertUserDetails($fn, $ln, $un , $em, $pwd){
            $pwd = hash("sha512",$pwd);

            $query = $this->conn->prepare("INSERT INTO users(firstName,lastName,username,email,password)
                                                    VALUES (:fn,:ln,:un,:em,:pwd)");
            $query->bindValue(":fn",$fn);
            $query->bindValue(":ln",$ln);
            $query->bindValue(":un",$un);
            $query->bindValue(":em",$em);
            $query->bindValue(":pwd",$pwd);
            
            return $query->execute();

        }

        private function validateFirstName($fn){
            if(strlen($fn) < 2 || strlen($fn) > 25){
                array_push($this->errArray, Constants::$firstNameCharacters);
            }

        }

        private function validateLastName($ln){
            if(strlen($ln) < 2 || strlen($ln) > 25){
                array_push($this->errArray, Constants::$lastNameCharacters);
            }

        }

        private function validateUserName($un){
            if(strlen($un) < 5 || strlen($un) > 25){
                array_push($this->errArray, Constants::$userNameCharacters);
                return;
            }

            $query = $this->conn->prepare("SELECT * FROM users WHERE username=:un");
            $query->bindValue(":un",$un);
            $query->execute();

            if($query->rowCount() != 0 ){
                array_push($this->errArray, Constants::$userNameTaken);
            }
        }

        private function validateEmails($em , $em2){
            if($em != $em2){
                array_push($this->errArray, Constants::$emailsDontMatch);
                return;
            }
            if(!filter_var($em, FILTER_VALIDATE_EMAIL)){
                array_push($this->errArray, Constants::$emailInvalid);
                return; 
            }
            $query = $this->conn->prepare("SELECT * FROM users WHERE email=:em");
            $query->bindValue(":em",$em);
            $query->execute();

            if($query->rowCount() != 0 ){
                array_push($this->errArray, Constants::$EmailTaken);
            }

        }

        private function validateNewEmail($em , $un){
            
            if(!filter_var($em, FILTER_VALIDATE_EMAIL)){
                array_push($this->errArray, Constants::$emailInvalid);
                return; 
            }
            $query = $this->conn->prepare("SELECT * FROM users WHERE email=:em AND username!=:un");
            $query->bindValue(":em",$em);
            $query->bindValue(":un",$un);
            $query->execute();

            if($query->rowCount() != 0 ){
                array_push($this->errArray, Constants::$EmailTaken);
            }

        }

        private function validatePasswords($pwd, $pwd2){
            if($pwd != $pwd2){
                array_push($this->errArray, Constants::$passwordsDontMatch);
                return;
            }
            if(strlen($pwd) < 5 || strlen($pwd) > 25){
                array_push($this->errArray, Constants::$passwordLength);
            }

        }

        public function getError($error) {
            if(in_array($error,$this->errArray)) {
                return "<span class='errorMessage'>$error</span>";
            }
        }

        public function getFirstError(){
            if(!empty($this->errArray)){
                return $this->errArray[0];
            }
        }
    }

?>