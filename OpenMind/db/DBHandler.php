<?php

require_once("CustomExceptions/NullInputException.php");
require_once("CustomExceptions/UserNotFoundException.php");
require_once("validationMode.php");

class DBHandler{

    private PDO $pdo;

    function __construct($pdo)
    {
        $this -> pdo = $pdo;
    }

    function registerUser($userName, $userEmail, $userPassword) : void 
    {
        if(!$this -> checkNull($userName, $userEmail)){
            throw new PDOException("Please fill the fields properly!");
        }

        //Password validation during user creation/registration
        $this -> validatePassword( "Placeholder" ,$userPassword, "Placeholder", ValidationMode::Creation); 
        
        if(!$this -> isEmailAvailable($userEmail)){
            throw new PDOException("Email is already taken!");
        }
        
        $hashed = md5($userPassword);

        $query = "INSERT INTO users(user_name, user_email, user_password) 
                  VALUES (:userName, :userEmail, :userPassword);";
            
        $statement = $this -> pdo -> prepare($query);
        $statement -> bindValue(":userName", $userName, PDO::PARAM_STR);
        $statement -> bindValue(":userEmail", $userEmail, PDO::PARAM_STR);
        $statement -> bindValue(":userPassword",  $hashed, PDO::PARAM_STR);

        $statement -> execute();
    }

    function verifyUser($userEmail, $userPassword)   
    {
        if(!$this -> checkNull($userEmail, $userPassword)){
            throw new NullInputException("Please fill the fields properly!");
        }

        $hashed = md5($userPassword); //User's password gets hashed here if it is not null

        $query = "SELECT * FROM users WHERE user_email = :userEmail AND user_password = :userPassword";
        $statement = $this -> pdo -> prepare($query);
        $statement -> execute([":userEmail" => $userEmail, 
                               ":userPassword" => $hashed]);

        $result = $statement -> fetchAll(PDO::FETCH_ASSOC);

        if(!$result)
        {
            throw new UserNotFoundException("Invalid credentials entered!");
        }

        return $result[0]; //The array is an array of user results, since we need only one user, the first element is returned
    }

    function getUserInfo($userId)
    {
        $query = "SELECT * FROM users WHERE user_id = :userId";
        $statement = $this -> pdo -> prepare($query);        
        $statement -> execute([":userId" => $userId]);

        $result = $statement -> fetchAll(PDO::FETCH_ASSOC);

        if(!$result)
        {
            throw new UserNotFoundException("Invalid credentials entered!");
        }

        return $result[0];
    }

    function getUserInfoByEmail($userEmail)
    {
        $query = "SELECT * FROM users WHERE user_email = :userEmail";
        $statement = $this -> pdo -> prepare($query);        
        $statement -> execute([":userEmail" => $userEmail]);

        $result = $statement -> fetchAll(PDO::FETCH_ASSOC);

        if(!$result)
        {
            throw new UserNotFoundException("Invalid credentials entered!");
        }

        return $result[0];
    }

    function changeUserName($userId, $userName)  : void
    {
        if(!$this -> checkNull($userName))
        {
            return;
        }

        $updateNameQuery = "UPDATE users SET user_name = :userName WHERE user_id = :userId";
        $updateNameStatement = $this -> pdo -> prepare($updateNameQuery);
        $updateNameStatement -> execute([":userName" => $userName,
                                         ":userId" => $userId]);

    }

    function changeUserEmail($userId, $userEmail, $originalEmail) : void
    {
        if(!$this -> checkNull($userEmail) || ($userEmail == $originalEmail) )
        {
            return;
        }

        if(!$this ->isEmailAvailable($userEmail, $originalEmail, ValidationMode::Editing))
        {
            throw new PDOException("Email is already Taken");
        }

        $updateEmailQuery = "UPDATE users SET user_email = :userEmail WHERE user_id = :userId ";
        $updateEmailStatement = $this -> pdo -> prepare($updateEmailQuery);
        $updateEmailStatement -> execute([":userEmail" => $userEmail,
                                          ":userId" => $userId]);

    }

    function changeUserPassword($userId, $userPassword, $confirmPassword)
    {
        //Password validation during password change requested by user
        $this -> validatePassword($userId, $userPassword, $confirmPassword, ValidationMode::Editing);

        $hashed = md5($userPassword);

        $updatePasswordQuery = "UPDATE users SET user_password = :userPassword WHERE user_id = :userId";
        $updatePasswordStatement = $this -> pdo -> prepare($updatePasswordQuery);
        $updatePasswordStatement -> execute([":userPassword" => $hashed,
                                             ":userId" => $userId ]);
    }


    private function validatePassword($id, $userPassword, $confirmPassword, $mode)
    {

        if(!$this -> checkNull($userPassword, $confirmPassword)){
            throw new NullInputException("Please fill the fields properly!");
        }

        if($mode == ValidationMode::Editing)
        {
            if($userPassword != $confirmPassword)
            {
                throw new PDOException("The password does not match the confirm field!");
            }

            if($this -> isSameAsOldPassword($id, $userPassword))
            {
                throw new PDOException("The password cannot be the same as old password!");
            }
        }

        if(strlen($userPassword) < 8)
        {
            throw new PDOException("The password must be at least 8 characters long!");
        }

        if(!preg_match("/[A-Z0-9]/", $userPassword))
        {
            throw new PDOException("The password must contain at least one capital letter and number!");
        }

    }

    private function isEmailAvailable($currentEmail) : bool
    {
        $query = "SELECT * FROM users WHERE user_email = :userEmail";
        $statement = $this -> pdo -> prepare($query);
        $statement -> execute([":userEmail" => $currentEmail]);

        $result = $statement -> fetchAll(PDO::FETCH_ASSOC);

        if(!$result)
        {
            return true;
        }

        return false;

    }


    private function isSameAsOldPassword($id, $password) : bool
    {
        $query = "SELECT user_password FROM users WHERE user_id = :userID";
        $statement = $this -> pdo -> prepare($query);
        $statement -> execute([":userID" => $id ]);

        $result = $statement -> fetch(PDO::FETCH_ASSOC);

        if(md5($password) == $result["user_password"]){
            return true;
        }

        echo "<script>alert('reached2')</script>";

        return false;
    }

    private function checkNull(...$params) : bool
    {
        foreach($params as $param){
            if(trim($param) == ""){
                return false;
            }
        }

        return true;
    }


}

?>