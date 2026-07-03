<?php

require_once('Repositories/UserRepository.php');

class AdminService
{
    private $userRepository;

    public function __construct()
    {
        $this -> userRepository = new UserRepository();
    }

    public function getUserData($id, $currentPage)
    {
        $users = $this -> userRepository -> getAllUsersForAdmin($id, $currentPage);
        $userData = [];

        foreach($users as $user)
        {
            $userData[] = $this -> userRepository -> getUserInfo($user['user_id']);
        }

        return  $userData;
    }

    public function getUserCount($id)
    {
        return $this -> userRepository -> getAllUsersCount($id);
    }
}

?>