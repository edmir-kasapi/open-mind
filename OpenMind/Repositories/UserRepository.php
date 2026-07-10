<?php

require_once('Repository.php');
require_once('Models/User.php');
require_once('Models/Photo.php');

class UserRepository extends Repository
{
    private $defaultProfile = 'default_profile';
    private $defaultExtension = '.png';
    private $defaultSize = 0;
    private $photoType = 'PROFILE';

    public function verifyLoginCredentials($email, $password)
    {
        $hashed = md5($password); //User's password gets hashed here if it is not null

        $result = User::where('user_email', '=', $email)
            ->where('user_password', '=', $hashed)
            ->first();

        return $result;
    }

    public function registerUser($name, $email, $password, $role)
    {
        $hashed = md5($password);

        $id = User::store([
            'user_name' => $name,
            'user_email' => $email,
            'user_password' => $hashed,
            'user_registration_date' => date("Y/m/d"),
            'role_id' => $role
        ]);

        Photo::store([
            'photo_hash_name' => $this->defaultProfile,
            'photo_original_name' => $this->defaultProfile,
            'photo_extension' => $this->defaultExtension,
            'photo_size' => $this->defaultSize,
            'photo_type' => $this->photoType,
            'user_id' => $id
        ]);

    }

    public function getUserInfo($id)
    {

        $infoResult = User::find($id);

        $profileResult = Photo::where('user_id', '=', $id)
            ->firstModel();

        $fullresult = [
            'user_info' => $infoResult,
            'user_profile' => $profileResult
        ];

        return $fullresult;
    }

    public function getUserInfoByEmail($email)
    {
        $result = User::where('user_email', '=', $email)
            ->first();

        return $result;
    }

    public function getAllUsersForAdmin($id, $currentPage, $options)
    {
        $offset = ($currentPage - 1) * 10; //for pagination if it needs to be implemented

        $name_email_no_filter = false;
        $category_no_filter = false;

        if( is_null($options['name_email_filter']) || trim($options['name_email_filter'] ) === "")
        {
            $name_email_no_filter = true;
        }

        if( is_null($options['category_filter']) || $options['category_filter'] === 'ALL' )
        {
            $category_no_filter = true;
        }


        $result = User::where('user_id', '!=', $id)
            ->where('user_name', 'LIKE', '%'. $options['name_email_filter'] . "%", $name_email_no_filter)
            ->where('role_id', '=',  $options['category_filter'] , $category_no_filter)
            ->limit(10)
            ->offset($offset)
            ->getAllModels();

        return $result;
    }

    public function resetUserPassword($email, $password)
    {
        $hashed = md5($password);

        User::update(['user_password' => $hashed])
            ->where('user_email', '=', $email)
            ->execute();
    }

    public function changeUserName($id, $name): void
    {
        User::update(['user_name' => $name])
            ->where('user_id', '=', $id)
            ->execute(); 
    }

    public function changeUserEmail($id, $email): void
    {
        User::update(['user_email' => $email])
            ->where('user_id', '=', $id)
            ->execute();
    }

    public function changeUserPassword($id, $password): void
    {
        $hashed = md5($password);

        User::update(['user_password' => $hashed])
            ->where('user_id', '=', $id)
            ->execute();
    }

    public function changeUserProfile($id, $picture): void
    {
        Photo::update([
                'photo_hash_name' => $picture['hashed_name'],
                'photo_original_name' => $picture['original_name'],
                'photo_extension' => $picture['extension'],
                'photo_size' => $picture['size']
            ])
            ->where('user_id', '=', $id)
            ->execute();
    }

    public function removeUserProfile($id): void
    {
        Photo::update([
                'photo_hash_name' => $this->defaultProfile,
                'photo_original_name' => $this->defaultProfile,
                'photo_extension' => $this->defaultExtension,
                'photo_size' => $this->defaultExtension
            ])
            ->where('user_id', '=', $id)
            ->execute();
    }

    public function deleteUserInfo($id)
    {
        $profile = Photo::where('user_id', '=', $id)->firstModel();
        Photo::destroy($profile -> __get('photo_id'));

        User::destroy($id);
    }

    public function checkForEmail($email)
    {
        $result = User::where('user_email', '=', $email)
            ->getAll();

        return $result;
    }

    public function checkEmailForEdit($id, $email)
    {
        $result = User::where('user_email', '=', $email) 
            ->where('user_id', '!=', $id)
            ->getAll();

        return $result;
    }

    public function getAllUsersCount($id, $options = ['name_email_filter' => NULL, 'category_filter' => NULL])
    {
        $name_email_no_filter = false;
        $category_no_filter = false;

        if(is_null($options['name_email_filter']) || trim($options['name_email_filter'] ) === "")
        {
            $name_email_no_filter = true;
        }

        if(is_null($options['category_filter']) || $options['category_filter'] === 'ALL' )
        {
            $category_no_filter = true;
        }

        $result = User::count('user_id')
            ->where('user_id', '!=', $id)
            ->where('user_name', 'LIKE', '%'. $options['name_email_filter'] . "%", $name_email_no_filter)
            ->where('role_id', '=',  $options['category_filter'] , $category_no_filter)
            ->getAll();


        return $result;
    }

    public function getAdminUsersCount($id)
    {
        $result =  User::count('user_id')
            ->join('roles', 'users.role_id', '=', 'roles.role_id')
            ->where('users.user_id', '!=', $id)
            ->where('roles.role_name', '=', 'ADMIN')
            ->getAll();

        return $result;
    }

    public function getNormalUserscount($id)
    {
        $result =  User::count('user_id')
            ->join('roles', 'users.role_id', '=', 'roles.role_id')
            ->where('users.user_id', '!=', $id)
            ->where('roles.role_name', '=', 'USER')
            ->getAll();

        return $result;
    }

    public function getProfilePicturesCount($id)
    {
        $result = Photo::count('photo_id')
            ->where('user_id', '!=', $id)
            ->where('photo_type', '=', 'PROFILE')
            ->where('photo_hash_name', '!=', 'default_profile')
            ->getAll();

        return $result;
    }
}
