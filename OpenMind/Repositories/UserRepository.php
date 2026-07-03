<?php

require_once('Repository.php');

class UserRepository extends Repository
{
    public function verifyLoginCredentials($email, $password)
    {
        $hashed = md5($password); //User's password gets hashed here if it is not null

        $query = "SELECT * FROM users WHERE user_email = :userEmail AND user_password = :userPassword";
        $statement = $this -> pdo -> prepare($query);
        $statement -> execute([":userEmail" => $email, 
                               ":userPassword" => $hashed]);

        $result = $statement -> fetch(PDO::FETCH_ASSOC);

        return $result;
    }

    public function registerUser($name, $email, $password)
    {
        $hashed = md5($password);
        $defaultProfile = 'default_profile';
        $defaultExtension = '.png';

        $query = "INSERT INTO users(user_name, user_email, user_password, user_registration_date) 
                  VALUES (:userName, :userEmail, :userPassword, CURRENT_TIMESTAMP() );";
        $statement = $this -> pdo -> prepare($query);
        $statement -> bindValue(":userName", $name, PDO::PARAM_STR);
        $statement -> bindValue(":userEmail", $email, PDO::PARAM_STR);
        $statement -> bindValue(":userPassword",  $hashed, PDO::PARAM_STR);
        $statement -> execute();

        $id = $this -> pdo ->lastInsertID();

        $query2 = "INSERT INTO photos(photo_hash_name, photo_original_name, photo_extension, photo_size, photo_type, user_id)
                   VALUES (:photoHashName, :photoOriginalName, :photoExtension, :photoSize, :photoType, :userId);";
        $statement2 = $this -> pdo -> prepare($query2);
        $statement2 -> execute([
            ":photoHashName" => $defaultProfile,
            ":photoOriginalName" => $defaultProfile,
            ":photoExtension" => $defaultExtension,
            ":photoSize" => 0,
            ":photoType" => 'PROFILE',
            ":userId" => $id
        ]);

        $this -> addUserRole($id);
                
    }

    public function getUserInfo($id)
    {
        $query = "SELECT * FROM users u, roles r 
                  WHERE r.user_id = u.user_id AND u.user_id = :userId ";
        $statement = $this -> pdo -> prepare($query);
        $statement -> execute([":userId" => $id]);
        $infoResult = $statement -> fetch(PDO::FETCH_ASSOC);
    
        $query2 = "SELECT * FROM photos WHERE user_id = :userId";
        $statement2 = $this -> pdo -> prepare($query2);
        $statement2 -> execute([":userId" => $id]);
        $profileResult = $statement2 -> fetch(PDO::FETCH_ASSOC);

        $fullresult = [
            'user_info' => $infoResult,
            'user_profile' => $profileResult
        ];

        return $fullresult;
    }

    public function getUserInfoByEmail($email)
    {
        $query = "SELECT * FROM users WHERE user_email = :userEmail";
        $statement = $this -> pdo -> prepare($query);

        $statement -> execute([":userEmail" => $email]);

        $result = $statement -> fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getAllUsersForAdmin($id, $currentPage)
    {
        $offset = ($currentPage - 1) * 10;

        $query = "SELECT * FROM users 
                  WHERE user_id != :userId
                  ORDER BY user_registration_date DESC
                  LIMIT 10 OFFSET $offset";
        $statement = $this -> pdo -> prepare($query);

        $statement -> execute([
            ":userId" => $id,
            ]);

        $result = $statement -> fetchAll(PDO::FETCH_ASSOC);
        return $result;

    }

    public function getAllUsersCount($id)
    {
        $query = "SELECT COUNT(user_id) as value FROM users WHERE user_id != :userId";
        $statement = $this -> pdo -> prepare($query);

        $statement -> execute([
            ":userId" => $id,
            ]);

        $result = $statement -> fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function resetUserPassword($email, $password)
    {
        $hashed = md5($password);

        $query = "UPDATE users SET user_password = :userPassword WHERE user_email = :userEmail";
        $statement = $this -> pdo -> prepare($query);
        $statement -> execute([
            ":userPassword" => $hashed,
            ":userEmail" => $email
            ]);
    }

    public function changeUserName($id, $name)  : void
    {
        $query = "UPDATE users SET user_name = :userName WHERE user_id = :userId";
        $statement = $this -> pdo -> prepare($query);
        
        $statement -> execute([
            ":userName" => $name,
            ":userId" => $id
        ]);

    }

    public function changeUserEmail($id, $email) : void
    {
        $query = "UPDATE users SET user_email = :userEmail WHERE user_id = :userId ";
        $statement = $this -> pdo -> prepare($query);
        
        $statement -> execute([
            ":userEmail" => $email,
            ":userId" => $id
        ]);
    }

    public function changeUserPassword($id, $password) : void
    {
        $hashed = md5($password);

        $query = "UPDATE users SET user_password = :userPassword WHERE user_id = :userId";
        $statement = $this -> pdo -> prepare($query);

        $statement -> execute([
            ":userPassword" => $hashed,
            ":userId" => $id 
        ]);
    }

    public function changeUserProfile($id, $picture) : void
    {
        $query = "UPDATE photos 
                    SET photo_hash_name = :photoHashName,  
                        photo_original_name = :photoOriginalName,  
                        photo_extension = :photoExtension, 
                        photo_size = :photoSize 
                    WHERE user_id = :userId";

        $statement = $this -> pdo -> prepare($query);
        $statement -> execute([
            ":photoHashName" => $picture['hashed_name'],
            ":photoOriginalName" => $picture['original_name'],
            ":photoExtension" => $picture['extension'],
            ":photoSize" => $picture['size'],
            ":userId" => $id
        ]);
    }

    public function removeUserProfile($id) : void
    {
        $defaultProfile = 'default_profile';
        $defaultExtension = '.png';

        $query = "UPDATE photos 
                    SET photo_hash_name = :photoHashName,  
                        photo_original_name = :photoOriginalName,  
                        photo_extension = :photoExtension, 
                        photo_size = :photoSize 
                    WHERE user_id = :userId";

        $statement = $this -> pdo -> prepare($query);
        $statement -> execute([
            ":photoHashName" => $defaultProfile,
            ":photoOriginalName" => $defaultProfile,
            ":photoExtension" => $defaultExtension,
            ":photoSize" => 0,
            ":userId" => $id
        ]);
    }


    public function checkForEmail($email) 
    {
        $query = "SELECT * FROM users WHERE user_email = :userEmail";
        $statement = $this -> pdo -> prepare($query);
        $statement -> execute([':userEmail' => $email]);
        
        $result = $statement -> fetchAll(PDO::FETCH_ASSOC);

        return $result;

    }

    public function checkEmailForEdit($id, $email)
    {
        $query = $query = "SELECT * FROM users WHERE user_email = :userEmail AND user_id NOT = :userID";
        $statement = $this -> pdo -> prepare($query);
        $statement -> execute([
            ':userEmail' => $email,
            ':userId' => $id  
        ]);
        
        $result = $statement -> fetchAll(PDO::FETCH_ASSOC);

        return $result;

    }

    private function addUserRole($id)
    {
        $query = "INSERT INTO roles (user_id, role_name)
                  VALUES (:userId, :roleName)";
        $statement = $this -> pdo -> prepare($query);

        $statement -> execute([
            ":userId" => $id,
            ":roleName" => "USER"
        ]);
    }

}

?>