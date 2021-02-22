<?php
class Account {

    private $con;
    private $errorArray = array();

    public function __construct($con) {
        $this->con = $con;
    }

    public function login($un, $pw) {
        $pw = hash("sha512", $pw);

        $query = $this->con->prepare("SELECT * FROM users WHERE username=:un AND password=:pw");
        $query->bindParam(":un", $un);
        $query->bindParam(":pw", $pw);

        $query->execute();

        if($query->rowCount() == 1) {
            return true;
        } 
        else {
            array_push($this->errorArray, Constants::$loginFailed);
            return false;
        }
    }

    public function register($fn, $ln, $un, $em, $em2, $pw, $pw2, $ethAddr, $profilePic) {
        $this->validateFirstName($fn);
        $this->validateLastName($ln);
        $this->validateUsername($un);
        $this->validateEmails($em, $em2);
        $this->validatePasswords($pw, $pw2);
        $this->validateEthAddress($ethAddr);

        if(empty($this->errorArray)) {
            return $this->insertUserDetails($fn, $ln, $un, $em, $pw, $ethAddr, $profilePic);
        } 
        else {
            return false;
        }
    }

    public function updateDetails($fn, $ln, $em, $un) {
        $this->validateFirstName($fn);
        $this->validateLastName($ln);
        $this->validateNewEmail($em, $un);

        if(empty($this->errorArray)) {
            $query = $this->con->prepare("UPDATE users SET firstName=:fn, lastName=:ln, email=:em WHERE username=:un");
            $query->bindParam(":fn", $fn);
            $query->bindParam(":ln", $ln);
            $query->bindParam(":em", $em);
            $query->bindParam(":un", $un);

            return $query->execute();
        }
        else {
            return false;
        }
    }

    public function reportVideo($videoUrl, $reportCategory, $reportComments, $reportedBy) {
        $this->validateVideoUrl($videoUrl);

        if(empty($this->errorArray)) {
            $query = $this->con->prepare("INSERT INTO reports(videoUrl, reportCategory, reportComments, reportedBy) 
            VALUES(:videoUrl, :reportCategory, :reportComments, :reportedBy)");

            $query->bindParam(":videoUrl", $videoUrl);
            $query->bindParam(":reportCategory", $reportCategory);
            $query->bindParam(":reportComments", $reportComments);
            $query->bindParam(":reportedBy", $reportedBy);

            return $query->execute();
        }
        else {
            return false;
        }
    }

    public function updatePassword($oldPw, $pw, $pw2, $un) {
        $this->validateOldPassword($oldPw, $un);
        $this->validatePasswords($pw, $pw2);

        if(empty($this->errorArray)) {
            $query = $this->con->prepare("UPDATE users SET password=:pw WHERE username=:un");
            $pw = hash("sha512", $pw);
            $query->bindParam(":pw", $pw);
            $query->bindParam(":un", $un);

            return $query->execute();
        }
        else {
            return false;
        }
    }

    private function validateOldPassword($oldPw, $un) {
        $pw = hash("sha512", $oldPw);

        $query = $this->con->prepare("SELECT * FROM users WHERE username=:un AND password=:pw");
        $query->bindParam(":un", $un);
        $query->bindParam(":pw", $pw);

        $query->execute();

        if($query->rowCount() == 0) {
            array_push($this->errorArray, Constants::$passwordIncorrect);
        }
    }


    public function insertUserDetails($fn, $ln, $un, $em, $pw, $ethAddr, $profilePic) {
        
        $pw = hash("sha512", $pw);
        //$profilePic = "assets/images/profilePictures/default.png";

        $query = $this->con->prepare("INSERT INTO users(firstName, lastName, username, email, password, profilePic, ethAddress)
                                        VALUES(:fn, :ln, :un, :em, :pw, :pic, :ethAddr)");
        $query->bindParam(":fn", $fn);
        $query->bindParam(":ln", $ln);
        $query->bindParam(":un", $un);
        $query->bindParam(":em", $em);
        $query->bindParam(":pw", $pw);
        $query->bindParam(":pic", $profilePic);
        $query->bindParam(":ethAddr", $ethAddr);

        return $query->execute();
        
    }

    private function validateFirstName($fn) {
        if(strlen($fn) > 30 || strlen($fn) < 4) {
            array_push($this->errorArray, Constants::$firstNameCharacters);
        }
    }

    private function validateLastName($ln) {
        if(strlen($ln) > 30 || strlen($ln) < 4) {
            array_push($this->errorArray, Constants::$lastNameCharacters);
        }
    }

    private function validateUsername($un) {
        if(strlen($un) > 30 || strlen($un) < 4) {
            array_push($this->errorArray, Constants::$usernameCharacters);
            return;
        }

        $query = $this->con->prepare("SELECT username FROM users WHERE username=:un");
        $query->bindParam(":un", $un);
        $query->execute();

        if($query->rowCount() != 0) {
            array_push($this->errorArray, Constants::$usernameTaken);
        }
    }

    private function validateEmails($em, $em2) {
        if($em != $em2) {
            array_push($this->errorArray, Constants::$emailsDoNotMatch);
            return;
        }

        if(!filter_var($em, FILTER_VALIDATE_EMAIL)) {
            array_push($this->errorArray, Constants::$emailInvalid);
            return;
        }
        $query = $this->con->prepare("SELECT email FROM users WHERE email=:em");
        $query->bindParam(":em", $em);
        $query->execute();

        if($query->rowCount() != 0) {
            array_push($this->errorArray, Constants::$emailTaken);
        }
    }

    private function validateNewEmail($em, $un) {

        if(!filter_var($em, FILTER_VALIDATE_EMAIL)) {
            array_push($this->errorArray, Constants::$emailInvalid);
            return;
        }

        $query = $this->con->prepare("SELECT email FROM users WHERE email=:em AND username != :un");
        $query->bindParam(":em", $em);
        $query->bindParam(":un", $un);
        $query->execute();

        if($query->rowCount() != 0) {
            array_push($this->errorArray, Constants::$emailTaken);
        }

    }

    private function validatePasswords($pw, $pw2) {
        if($pw != $pw2) {
            array_push($this->errorArray, Constants::$passwordsDoNotMatch);
            return;
        }

        if(preg_match("/[^A-Za-z0-9]/", $pw)) {
            array_push($this->errorArray, Constants::$passwordNotAlphanumeric);
            return;
        }

        if(strlen($pw) > 30 || strlen($pw) < 4) {
            array_push($this->errorArray, Constants::$passwordLength);
        }
    }

    private function validateEthAddress($ethAddr) {

        if(strlen($ethAddr) != 42) {
            array_push($this->errorArray, Constants::$ethAddressInvalid);
            return;
        }

        $query = $this->con->prepare("SELECT ethAddress FROM users WHERE ethAddress=:ethAddr");
        $query->bindParam(":ethAddr", $ethAddr);
        $query->execute();

        if($query->rowCount() != 0) {
            array_push($this->errorArray, Constants::$ethAddressTaken);
        }
    }

    private function validateVideoUrl($url) {
        if (!filter_var($url, FILTER_VALIDATE_URL)) { 
            array_push($this->errorArray, Constants::$urlInvalid);
            return;
          }
        
        $url_components = parse_url($url); 
        
        if(!array_key_exists("query" , $url_components)){
            array_push($this->errorArray, Constants::$urlInvalid);
            return;
        }

        parse_str($url_components['query'], $params); 

        if(!array_key_exists("id" , $params)){
            array_push($this->errorArray, Constants::$urlInvalid);
            return;
        }
        
        $query = $this->con->prepare("SELECT * FROM videos WHERE id=:id AND transactionStatus=1");
        $query->bindParam(":id", $params['id']);
        $query->execute();
    
        if($query->rowCount() == 0) {
            array_push($this->errorArray, Constants::$videoDoesNotExist);
            return;
        }
        
    }



    public function getError($error) {
        if(in_array($error, $this->errorArray)){
            return "<span class='errorMessage'>$error</span>";
        }
    }

    public function getFirstError() {
        if(!empty($this->errorArray)) {
            return $this->errorArray[0];
        }
        else {
            return "";
        }
    }

}
?>