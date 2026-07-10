<?php

require_once('Repositories/UserRepository.php');

require_once('Customexceptions/ValidationException.php');
require_once('Customexceptions/UserNotFoundException.php');
require_once('CustomExceptions/InvalidTokenException.php');

class AuthService{

    private $userRepository;

    public function __construct()
    {
        $this -> userRepository = new UserRepository();
    }

    public function authenticateUser($email, $password)
    {
        $this -> validateLoginData($email, $password);
        $result = $this -> userRepository -> verifyLoginCredentials($email, $password);

        var_dump($result);

        if(!$result)
        {
            throw new UserNotFoundException('Invalid credentials Entered');
        }

        return $this -> userRepository -> getUserInfo($result['user_id']);

    }

    public function registerUser($name, $email, $password, $role) : void
    {
        $this -> validateRegisterData($name, $email, $password);
        $this -> userRepository -> registerUser($name, $email, $password, $role);
    }

    public function resetPassword($email, $passwordNew, $passwordconfirm)
    {
        $this -> validatePasswordReset($email, $passwordNew, $passwordconfirm);
        $this -> userRepository -> resetUserPassword($email, $passwordNew);
    }


    public function editName($id, $name) : void
    {
        if(isset($name)){

            $this -> validateNameEdit($name);
            $this -> userRepository -> changeUserName($id, $name);
        }
        
    }

    public function editEmail($id, $email) : void
    {
        if(isset($email)){
            
            $this -> validateEmailEdit($id, $email);
            $this -> userRepository -> changeUseremail($id, $email);
        }
    }

    public function editPassword($id, $passwordNew, $passwordConfirm)
    {
        $this -> validatePasswordEdit($id, $passwordNew, $passwordConfirm);
        $this -> userRepository -> changeUserPassword($id, $passwordNew);
    }

    private function validateLoginData($email, $password) : void
    {
        $errors = [];

        if(trim($email) === '' ){
            $errors[] = 'Email cannot be empty.';
        }

        if(trim($password) === '' ){
            $errors[] = 'Password cannot be empty.';
        }

        if(!empty($errors))
        {
            throw new ValidationException(implode(' ', $errors));
        }

    }

    private function validateRegisterData($name, $email, $password) : void
    {
        $errors = [];

        if(trim($name) === '' ){
            $errors[] = 'Name cannot be empty.';
        }

        if(strlen($name) > 40){
            $errors[] = 'Name cannot be longer than 40 characters.';
        }

        if(trim($email) === '' ){
            $errors[] = 'Email cannot be empty.';
        }

        if(!$this -> isEmailAvailable($email)){
            $errors[] = 'Email already taken.';
        }

        if(trim($password) === '' ){
            $errors[] = 'Password cannot be empty.';
        }

        if(strlen($password) < 8)
        {
            $errors[] = 'The password must be at least 8 characters long.';
        }

        if(!preg_match("/[A-Z0-9]/", $password))
        {
            $errors[] = 'The password must contain at least one capital letter and number.';
        }

        if(!empty($errors))
        {
            throw new ValidationException(implode(' ', $errors));
        }

    }

    private function validatePasswordReset($email, $passwordNew, $passwordConfirm) : void
    {
        $errors = [];

        if(trim($email) === '' ){
            $errors[] = 'Email cannot be empty.';
        }

        if(trim($passwordNew) === '' ){
            $errors[] = 'New password cannot be empty.';
        }

        if(trim($passwordConfirm) === '' ){
            $errors[] = 'Confirm password cannot be empty.';
        }

        if(!$this -> isValidEmail($email)){
            $errors[] = 'Invalid email provided.';
        }

        if($this -> isValidEmail($email) && $this -> isSameAsOldPasswordByEmail($email, $passwordNew)){
            $errors[] = 'New password Cannot be the same as old password.';
        }

        if(strlen($passwordNew) < 8)
        {
            $errors[] = 'The password must be at least 8 characters long.';
        }

        if(!preg_match("/[A-Z0-9]/", $passwordNew))
        {
            $errors[] = 'The password must contain at least one capital letter and number.';
        }

        if($passwordNew != $passwordConfirm)
        {
            $errors[] = 'The new password does not match the confirmation field.';
        }

        if(!empty($errors))
        {
            throw new ValidationException(implode(' ', $errors));
        }
    }

    private function validateNameEdit($name) : void
    {
        $errors = [];

        if(trim($name) === '' ){
            $errors[] = 'Name cannot be empty.';
        }

        if(strlen($name) > 40){
            $errors[] = 'Name cannot be longer than 40 characters.';
        }

        if(!empty($errors))
        {
            throw new ValidationException(implode(' ', $errors));
        }

    }

    private function validateEmailEdit($id, $email) : void
    {
        $errors = [];

        if(trim($email) === '' ){
            $errors[] = 'Email cannot be empty.';
        }

        if(!$this -> isEmailAvailableforEdit($id, $email)){
            $errors[] = 'Email already taken.';
        }

        if(!empty($errors))
        {
            throw new ValidationException(implode(' ', $errors));
        }

    }

    private function validatePasswordEdit($id, $passwordNew, $passwordConfirm)
    {
        $errors = [];

        if(trim($passwordNew) === '' ){
            $errors[] = 'New password cannot be empty.';
        }

        if(trim($passwordConfirm) === '' ){
            $errors[] = 'Confirm password cannot be empty.';
        }

        if($this -> isSameAsOldPasswordById($id, $passwordNew))
        {
             $errors[] = 'New password cannot be the same as the old password';
        }

        if(strlen($passwordNew) < 8)
        {
            $errors[] = 'The password must be at least 8 characters long.';
        }

        if(!preg_match("/[A-Z0-9]/", $passwordNew))
        {
            $errors[] = 'The password must contain at least one capital letter and number.';
        }

        if($passwordNew != $passwordConfirm)
        {
            $errors[] = 'The new password does not match the confirmation field.';
        }

        if(!empty($errors))
        {
            throw new ValidationException(implode(' ', $errors));
        }
    }

    private function isEmailAvailable($email) : bool
    {
        $result = $this -> userRepository -> checkForEmail($email);
        if(!$result)
        {
            return true;
        }

        return false;
    }

    private function isEmailAvailableforEdit($id, $email) : bool
    {
        $result = $this -> userRepository -> checkForEmail($id, $email);
        if(!$result)
        {
            return true;
        }

        return false;
    }

    private function isValidEmail($email) : bool
    {
        $result = $this -> userRepository -> getUserInfoByEmail($email);

        if($result)
        {
            return true;
        }

        return false;
    }

    private function isSameAsOldPasswordByEmail($email, $password) : bool
    {
        $result = $this -> userRepository -> getUserInfoByEmail($email);

        return md5($password) == $result['user_password'];
    }

    private function isSameAsOldPasswordById($id, $password)
    {
        $result = $this -> userRepository -> getUserInfo($id);

        return md5($password) == $result['user_info'] -> __get('user_password');
    }

}

?>